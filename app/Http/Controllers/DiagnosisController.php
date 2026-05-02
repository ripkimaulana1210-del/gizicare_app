<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiagnosisController extends Controller
{
    public function index()
    {
        return view('diagnosis.index', [
            'aiReady' => filled(config('services.openai.api_key')),
            'openAiModel' => config('services.openai.model', 'gpt-5-mini'),
        ]);
    }

    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
            'profile' => ['nullable', 'array'],
            'profile.nama' => ['nullable', 'string', 'max:80'],
            'profile.umur' => ['nullable', 'numeric', 'min:0', 'max:216'],
            'profile.berat' => ['nullable', 'numeric', 'min:0', 'max:250'],
            'profile.tinggi' => ['nullable', 'numeric', 'min:0', 'max:250'],
            'history' => ['nullable', 'array', 'max:8'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:1600'],
        ]);

        $apiKey = config('services.openai.api_key');

        if (blank($apiKey)) {
            return response()->json([
                'message' => 'OPENAI_API_KEY belum diatur di file .env. Isi key lalu jalankan php artisan config:clear.',
            ], 503);
        }

        $model = config('services.openai.model', 'gpt-5-mini');
        $messages = $this->buildMessages(
            $validated['message'],
            $validated['profile'] ?? [],
            $validated['history'] ?? []
        );

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->asJson()
                ->timeout(45)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => $model,
                    'instructions' => $this->systemInstructions(),
                    'input' => $messages,
                    'max_output_tokens' => 800,
                ]);
        } catch (\Throwable $exception) {
            Log::warning('Diagnosis AI request failed before response.', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Koneksi ke layanan AI gagal. Coba lagi beberapa saat.',
            ], 502);
        }

        if ($response->failed()) {
            $error = $response->json('error') ?? [];
            $errorCode = $error['code'] ?? $error['type'] ?? null;

            Log::warning('Diagnosis AI returned an error.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return response()->json([
                'message' => $this->openAiErrorMessage($response->status(), $errorCode),
            ], $this->openAiStatusCode($response->status(), $errorCode));
        }

        $reply = $this->extractOutputText($response->json() ?? []);

        if (blank($reply)) {
            return response()->json([
                'message' => 'AI memberi respons kosong. Coba tulis ulang keluhan dengan detail yang lebih jelas.',
            ], 502);
        }

        return response()->json([
            'reply' => $reply,
            'model' => $model,
        ]);
    }

    private function buildMessages(string $message, array $profile, array $history): array
    {
        $messages = [];

        foreach (array_slice($history, -6) as $item) {
            if (! isset($item['role'], $item['content'])) {
                continue;
            }

            $messages[] = [
                'role' => $item['role'],
                'content' => $item['content'],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => trim($this->formatProfile($profile) . "\n\nKeluhan atau pertanyaan:\n" . $message),
        ];

        return $messages;
    }

    private function formatProfile(array $profile): string
    {
        $rows = [
            'Nama anak' => $profile['nama'] ?? null,
            'Umur' => isset($profile['umur']) ? $profile['umur'] . ' bulan' : null,
            'Berat badan' => isset($profile['berat']) ? $profile['berat'] . ' kg' : null,
            'Tinggi badan' => isset($profile['tinggi']) ? $profile['tinggi'] . ' cm' : null,
        ];

        $filledRows = collect($rows)
            ->filter(fn ($value) => filled($value))
            ->map(fn ($value, $label) => "{$label}: {$value}")
            ->values()
            ->all();

        if (empty($filledRows)) {
            return 'Profil anak: belum diisi.';
        }

        return "Profil anak:\n" . implode("\n", $filledRows);
    }

    private function systemInstructions(): string
    {
        return <<<'PROMPT'
Anda adalah asisten konsultasi gizi anak untuk aplikasi GiziCare. Jawab dalam bahasa Indonesia yang hangat, jelas, dan praktis.

Beri konsultasi awal seputar pola makan, pertumbuhan, status gizi, MPASI, picky eating, anemia, stunting, berat badan kurang/lebih, dan kebiasaan makan keluarga. Jangan menyatakan diagnosis medis pasti, jangan menggantikan dokter, bidan, ahli gizi, atau puskesmas, dan jangan memberi dosis obat atau suplemen spesifik.

Jika data belum cukup, ajukan 2-4 pertanyaan lanjutan yang paling penting. Jika ada tanda bahaya seperti sesak napas, kejang, lemas berat, dehidrasi, tidak mau minum, muntah/diare terus-menerus, darah pada BAB/muntah, demam tinggi, penurunan berat badan cepat, bayi di bawah 6 bulan sakit, atau tampak sangat mengantuk, sarankan segera ke fasilitas kesehatan.

Struktur jawaban:
1. Ringkasan singkat kondisi.
2. Kemungkinan masalah atau faktor yang perlu dicek.
3. Langkah aman yang bisa dilakukan di rumah.
4. Kapan perlu ke tenaga kesehatan.

Gunakan kalimat pendek dan dapat ditindaklanjuti. Untuk status gizi, arahkan pengguna membandingkan data dengan Buku KIA/KMS atau pengukuran di posyandu/puskesmas bila perlu.
PROMPT;
    }

    private function extractOutputText(array $data): string
    {
        if (isset($data['output_text']) && is_string($data['output_text'])) {
            return trim($data['output_text']);
        }

        $parts = [];

        foreach ($data['output'] ?? [] as $output) {
            foreach ($output['content'] ?? [] as $content) {
                if (isset($content['text']) && is_string($content['text'])) {
                    $parts[] = $content['text'];
                }
            }
        }

        return trim(implode("\n", $parts));
    }

    private function openAiErrorMessage(int $status, ?string $errorCode): string
    {
        return match ($errorCode) {
            'insufficient_quota' => 'API key sudah terbaca, tetapi kuota atau billing OpenAI belum aktif atau sudah habis. Cek Usage dan Billing di dashboard OpenAI.',
            'invalid_api_key' => 'API key OpenAI tidak valid. Periksa kembali nilai OPENAI_API_KEY di file .env.',
            'model_not_found' => 'Model OpenAI tidak tersedia untuk API key ini. Ganti OPENAI_MODEL di .env, lalu jalankan php artisan config:clear.',
            'rate_limit_exceeded' => 'Batas request OpenAI sedang tercapai. Tunggu sebentar lalu coba lagi.',
            default => $status >= 500
                ? 'Layanan AI sedang bermasalah. Coba lagi beberapa saat.'
                : 'Layanan AI belum bisa menjawab sekarang. Periksa API key, model, atau billing OpenAI.',
        };
    }

    private function openAiStatusCode(int $status, ?string $errorCode): int
    {
        if ($errorCode === 'insufficient_quota' || $errorCode === 'rate_limit_exceeded') {
            return 429;
        }

        if ($errorCode === 'invalid_api_key') {
            return 401;
        }

        return $status >= 500 ? 502 : 422;
    }
}
