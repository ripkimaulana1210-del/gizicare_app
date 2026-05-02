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
            'aiReady' => filled(config('services.gemini.api_key')),
            'geminiModel' => config('services.gemini.model', 'gemini-2.5-flash'),
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

        $apiKey = config('services.gemini.api_key');

        if (blank($apiKey)) {
            return response()->json([
                'message' => 'GEMINI_API_KEY belum diatur di file .env. Isi key dari Google AI Studio lalu jalankan php artisan config:clear.',
            ], 503);
        }

        $model = config('services.gemini.model', 'gemini-2.5-flash');
        $contents = $this->buildContents(
            $validated['message'],
            $validated['profile'] ?? [],
            $validated['history'] ?? []
        );

        try {
            $response = Http::withHeaders([
                    'x-goog-api-key' => $apiKey,
                ])
                ->acceptJson()
                ->asJson()
                ->timeout(45)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $this->systemInstructions()],
                        ],
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'maxOutputTokens' => 800,
                    ],
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
            $errorStatus = $error['status'] ?? null;
            $errorMessage = $error['message'] ?? null;

            Log::warning('Diagnosis AI returned an error.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return response()->json([
                'message' => $this->geminiErrorMessage($response->status(), $errorStatus, $errorMessage),
            ], $this->geminiStatusCode($response->status(), $errorStatus, $errorMessage));
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

    private function buildContents(string $message, array $profile, array $history): array
    {
        $contents = [];

        foreach (array_slice($history, -6) as $item) {
            if (! isset($item['role'], $item['content'])) {
                continue;
            }

            $contents[] = [
                'role' => $item['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [
                    ['text' => $item['content']],
                ],
            ];
        }

        $userText = trim($this->formatProfile($profile) . "\n\nKeluhan atau pertanyaan:\n" . $message);

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userText],
            ],
        ];

        return $contents;
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
            return '';
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
        $parts = [];

        foreach ($data['candidates'] ?? [] as $candidate) {
            foreach ($candidate['content']['parts'] ?? [] as $part) {
                if (isset($part['text']) && is_string($part['text'])) {
                    $parts[] = $part['text'];
                }
            }
        }

        return trim(implode("\n", $parts));
    }

    private function geminiErrorMessage(int $status, ?string $errorStatus, ?string $errorMessage): string
    {
        $mentionsApiKey = is_string($errorMessage) && str_contains(strtolower($errorMessage), 'api key');

        return match (true) {
            $errorStatus === 'RESOURCE_EXHAUSTED' => 'Batas request Gemini sedang tercapai. Tunggu kuota reset atau cek limit di Google AI Studio.',
            in_array($errorStatus, ['UNAUTHENTICATED', 'PERMISSION_DENIED'], true) || $mentionsApiKey => 'API key Gemini tidak valid atau belum punya akses. Periksa kembali nilai GEMINI_API_KEY di file .env.',
            $errorStatus === 'NOT_FOUND' => 'Model Gemini tidak tersedia. Ganti GEMINI_MODEL di .env, lalu jalankan php artisan config:clear.',
            default => $status >= 500
                ? 'Layanan AI sedang bermasalah. Coba lagi beberapa saat.'
                : 'Layanan AI belum bisa menjawab sekarang. Periksa API key, model, atau limit Gemini.',
        };
    }

    private function geminiStatusCode(int $status, ?string $errorStatus, ?string $errorMessage): int
    {
        $mentionsApiKey = is_string($errorMessage) && str_contains(strtolower($errorMessage), 'api key');

        if ($errorStatus === 'RESOURCE_EXHAUSTED') {
            return 429;
        }

        if (in_array($errorStatus, ['UNAUTHENTICATED', 'PERMISSION_DENIED'], true) || $mentionsApiKey) {
            return 401;
        }

        return $status >= 500 ? 502 : 422;
    }
}
