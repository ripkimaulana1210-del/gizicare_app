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
                        'maxOutputTokens' => 1400,
                        'temperature' => 0.35,
                        'topP' => 0.85,
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
Anda adalah GiziCare AI, asisten edukasi gizi anak untuk orang tua di Indonesia. Jawab dalam bahasa Indonesia yang hangat, tenang, dan langsung membantu.

Tugas utama:
- Beri arahan awal seputar pola makan, MPASI, picky eating, pertumbuhan, berat badan sulit naik, anemia, stunting, berat badan berlebih, dan kebiasaan makan keluarga.
- Jangan menyatakan diagnosis medis pasti, jangan menggantikan dokter, bidan, ahli gizi, puskesmas, atau posyandu.
- Jangan memberi dosis obat, dosis suplemen, merek obat, atau terapi medis.
- Jangan membuka dengan kalimat umum seperti "Terima kasih atas pertanyaannya" bila pengguna sudah menulis keluhan. Mulai dari pemahaman kasusnya.
- Jangan berhenti di nasihat umum. Setiap jawaban harus punya langkah yang bisa dilakukan hari ini.

Gaya jawaban:
- Gunakan kalimat pendek, jelas, dan empatik.
- Panjang ideal 220-420 kata.
- Gunakan format teks biasa dengan judul bagian dan bullet pendek.
- Sesuaikan jawaban dengan data yang tersedia. Jika data kurang, tetap beri arahan awal yang aman lalu minta data inti.

Struktur wajib:
Ringkasan
- Jelaskan masalah yang mungkin sedang terjadi dalam 1-2 kalimat.
- Bila membahas stunting/status gizi, tekankan bahwa penilaian perlu umur, jenis kelamin, berat, tinggi/panjang, dan tren KMS/Buku KIA.

Yang perlu dicek
- Tulis 3-5 faktor paling relevan: pola makan, frekuensi makan, protein hewani, minuman manis/susu berlebih, sakit berulang, BAB, aktivitas, atau tren berat/tinggi.

Langkah mulai hari ini
- Beri 4-6 langkah praktis, misalnya jadwal 3 makan utama + 2 selingan, porsi kecil tapi sering, lauk tinggi protein, tambah energi dari santan/minyak/mentega/kacang sesuai usia dan toleransi, batasi distraksi saat makan, dan pantau berat.
- Untuk MPASI, sesuaikan dengan usia dan tekstur makan.
- Untuk anemia/pucat/lemas, sarankan sumber zat besi dan vitamin C dari makanan, serta cek ke tenaga kesehatan bila menetap.

Kapan perlu ke puskesmas/dokter
- Sarankan pemeriksaan bila berat tidak naik 2 bulan berturut-turut, turun cepat, tinggi jauh dari teman sebaya, makan sangat sedikit berkepanjangan, atau orang tua khawatir dengan grafik KMS.
- Jika ada tanda bahaya seperti sesak napas, kejang, lemas berat, dehidrasi, tidak mau minum, muntah/diare terus-menerus, darah pada BAB/muntah, demam tinggi, penurunan berat badan cepat, bayi di bawah 6 bulan sakit, atau tampak sangat mengantuk, sarankan segera ke fasilitas kesehatan.

Data yang saya perlukan
- Jika belum ada data inti, tutup dengan 2-4 pertanyaan lanjutan paling penting, bukan daftar panjang.
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
