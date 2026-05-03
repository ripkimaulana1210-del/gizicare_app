<?php

namespace App\Http\Controllers;

use App\Models\DiagnosisMessage;
use App\Models\DiagnosisSession;
use App\Models\Pencatatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DiagnosisController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $diagnosisSessions = $user->diagnosisSessions()
            ->with('pencatatan:id,nama,umur,posyandu')
            ->withCount('messages')
            ->latest('updated_at')
            ->get();
        $activeSession = $this->activeSessionFromRequest(request(), $diagnosisSessions);
        $savedMessages = $activeSession
            ? $activeSession->messages()
                ->oldest()
                ->take(80)
                ->get()
                ->map(fn (DiagnosisMessage $message) => [
                    'role' => $message->role,
                    'content' => $message->content,
                ])
            : collect();
        return view('diagnosis.index', [
            'aiReady' => filled(config('services.gemini.api_key')),
            'geminiModel' => config('services.gemini.model', 'gemini-2.5-flash'),
            'savedMessages' => $savedMessages,
            'diagnosisSessions' => $diagnosisSessions,
            'activeSession' => $activeSession,
        ]);
    }

    public function storeSession(Request $request)
    {
        $session = $request->user()->diagnosisSessions()->create([
            'title' => 'Chat diagnosis baru',
        ]);

        return redirect()->route('diagnosis', ['session' => $session->id]);
    }

    public function destroySession(Request $request, DiagnosisSession $session)
    {
        abort_unless($session->user_id === $request->user()->id, 404);

        $session->delete();

        return redirect()->route('diagnosis')->with('success', 'Riwayat diagnosis berhasil dihapus.');
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
            'history.*.content' => ['required_with:history', 'string', 'max:12000'],
            'session_id' => ['nullable', 'integer'],
            'pencatatan_id' => ['nullable', 'integer'],
        ]);

        $session = $this->resolveSession($request, $validated);
        $child = $session->pencatatan;
        $profile = array_merge($this->profileFromPencatatan($child), $validated['profile'] ?? []);
        $apiKey = config('services.gemini.api_key');

        if (blank($apiKey)) {
            return response()->json([
                'message' => 'GEMINI_API_KEY belum diatur di file .env. Isi key dari Google AI Studio lalu jalankan php artisan config:clear.',
            ], 503);
        }

        $model = config('services.gemini.model', 'gemini-2.5-flash');
        $contents = $this->buildContents(
            $validated['message'],
            $profile,
            $this->recentStoredHistory($session)
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
                        'maxOutputTokens' => 2200,
                        'temperature' => 0.42,
                        'topP' => 0.9,
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

            if ($errorStatus === 'RESOURCE_EXHAUSTED') {
                $reply = $this->localFallbackReply($validated['message'], $child);
                $this->storeChatPair($request, $session, $validated['message'], $reply, 'fallback-local');

                return response()->json([
                    'reply' => $reply,
                    'model' => 'fallback-local',
                    'fallback' => true,
                    'session_id' => $session->id,
                    'session_title' => $session->title,
                ]);
            }

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

        $this->storeChatPair($request, $session, $validated['message'], $reply, $model);

        return response()->json([
            'reply' => $reply,
            'model' => $model,
            'fallback' => false,
            'session_id' => $session->id,
            'session_title' => $session->title,
        ]);
    }

    private function recentStoredHistory(DiagnosisSession $session): array
    {
        return $session
            ->messages()
            ->latest()
            ->take(8)
            ->get()
            ->reverse()
            ->values()
            ->map(fn (DiagnosisMessage $message) => [
                'role' => $message->role,
                'content' => $message->content,
            ])
            ->all();
    }

    private function activeSessionFromRequest(Request $request, $sessions): ?DiagnosisSession
    {
        $requestedId = (int) $request->query('session');

        if ($requestedId) {
            return $sessions->firstWhere('id', $requestedId);
        }

        return $sessions->first();
    }

    private function resolveSession(Request $request, array $validated): DiagnosisSession
    {
        $child = $this->ownedPencatatan($request, $validated['pencatatan_id'] ?? null);
        $sessionId = $validated['session_id'] ?? null;

        if ($sessionId) {
            $session = $request->user()
                ->diagnosisSessions()
                ->with('pencatatan')
                ->findOrFail($sessionId);

            if ($child && blank($session->pencatatan_id)) {
                $session->update(['pencatatan_id' => $child->id]);
                $session->setRelation('pencatatan', $child);
            }

            return $session;
        }

        return $request->user()
            ->diagnosisSessions()
            ->create([
                'pencatatan_id' => $child?->id,
                'title' => $this->generateSessionTitle($validated['message'], $child),
            ])
            ->load('pencatatan');
    }

    private function ownedPencatatan(Request $request, mixed $id): ?Pencatatan
    {
        if (blank($id)) {
            return null;
        }

        return Pencatatan::query()
            ->where('user_id', $request->user()->id)
            ->find((int) $id);
    }

    private function profileFromPencatatan(?Pencatatan $pencatatan): array
    {
        if (! $pencatatan) {
            return [];
        }

        return [
            'nama' => $pencatatan->nama,
            'umur' => $pencatatan->umur,
            'berat' => $pencatatan->bb,
            'tinggi' => $pencatatan->tb,
        ];
    }

    private function storeChatPair(
        Request $request,
        DiagnosisSession $session,
        string $message,
        string $reply,
        ?string $model = null
    ): void {
        if ($session->messages()->count() === 0 && $session->title === 'Chat diagnosis baru') {
            $session->update([
                'title' => $this->generateSessionTitle($message, $session->pencatatan),
            ]);
        }

        $request->user()->diagnosisMessages()->create([
            'diagnosis_session_id' => $session->id,
            'role' => 'user',
            'content' => $message,
        ]);

        $request->user()->diagnosisMessages()->create([
            'diagnosis_session_id' => $session->id,
            'role' => 'assistant',
            'content' => $reply,
            'model' => $model,
        ]);

        $session->touch();
    }

    private function generateSessionTitle(string $message, ?Pencatatan $pencatatan = null): string
    {
        if ($pencatatan) {
            return Str::limit('Diagnosis ' . $pencatatan->nama, 72, '');
        }

        $title = trim(Str::headline(Str::lower($message)), " \t\n\r\0\x0B.!?,;:-");

        return Str::limit($title, 72, '');
    }

    private function localFallbackReply(string $message, ?Pencatatan $pencatatan = null): string
    {
        $height = $this->extractMeasurement($message, ['tinggi', 'tinggi badan', 'tb']);
        $weight = $this->extractMeasurement($message, ['berat', 'berat badan', 'bb']);

        if ($height && $weight && ! $this->mentionsChildContext($message)) {
            $heightCm = $height['unit'] && in_array(strtolower($height['unit']), ['m', 'meter'], true)
                ? $height['value'] * 100
                : $height['value'];

            if ($heightCm >= 140 && $heightCm <= 250) {
                $heightMeter = $heightCm / 100;
                $bmi = round($weight['value'] / ($heightMeter ** 2), 1);
                $idealMin = round(18.5 * ($heightMeter ** 2), 1);
                $idealMax = round(24.9 * ($heightMeter ** 2), 1);

                return implode("\n\n", [
                    'Jawaban lokal sementara',
                    "Gemini sedang kena limit, jadi GiziCare memakai hitungan lokal. Dengan tinggi {$heightCm} cm dan berat {$weight['value']} kg, BMI Anda sekitar {$bmi} dan masuk kategori {$this->adultBmiCategory($bmi)}.",
                    'Rentang berat menurut BMI normal',
                    "Untuk tinggi {$heightCm} cm, rentang BMI normal kira-kira {$idealMin}-{$idealMax} kg. Ini hanya skrining awal, bukan diagnosis medis.",
                    'Langkah mulai hari ini',
                    "- Kurangi minuman manis dan camilan tinggi gula.\n- Isi piring dengan protein, sayur, dan karbohidrat secukupnya.\n- Mulai jalan kaki 20-30 menit, 4-5 kali per minggu.\n- Tidur cukup dan pantau berat tiap minggu.\n- Jika ada hipertensi, diabetes, sesak, atau nyeri dada, cek ke tenaga kesehatan.",
                ]);
            }
        }

        if ($pencatatan) {
            return $this->childFallbackReply($pencatatan);
        }

        if ($this->mentionsChildContext($message)) {
            return implode("\n\n", [
                'Jawaban lokal sementara',
                'Gemini sedang kena limit. Untuk estimasi status gizi anak, pilih data balita dari riwayat pencatatan atau tulis umur, jenis kelamin, berat, dan tinggi.',
                'Arahan awal aman',
                "- Jaga jadwal 3 makan utama dan 2 selingan.\n- Utamakan protein hewani seperti telur, ikan, ayam, atau daging.\n- Pantau berat dan tinggi tiap bulan.\n- Ke puskesmas bila berat tidak naik 2 bulan berturut-turut atau anak tampak lemas/sakit berulang.",
            ]);
        }

        return implode("\n\n", [
            'Jawaban lokal sementara',
            'Gemini sedang kena limit, jadi GiziCare belum bisa memberi respons AI lengkap. Untuk topik gizi, tulis data inti seperti tinggi, berat, umur, jenis kelamin, pola makan, dan tujuan.',
            'Yang bisa dilakukan sekarang',
            "- Jika bertanya berat ideal dewasa, tulis tinggi dan berat agar BMI bisa dihitung.\n- Jika bertanya anak, pilih data balita dari pencatatan atau tulis umur, BB, TB, dan jenis kelamin.\n- Untuk keluhan berat seperti sesak, nyeri dada, dehidrasi, atau lemas berat, segera cek ke fasilitas kesehatan.",
        ]);
    }

    private function childFallbackReply(Pencatatan $pencatatan): string
    {
        return implode("\n\n", [
            'Jawaban lokal sementara',
            "Gemini sedang kena limit, jadi GiziCare memakai data pencatatan terakhir. {$pencatatan->nama}, usia {$pencatatan->umur} bulan, BB {$pencatatan->bb} kg, TB {$pencatatan->tb} cm.",
            'Estimasi status awal',
            "Status BB/TB: {$pencatatan->status}. Status TB/U: {$pencatatan->status_stunting}. Z-score BB/TB: " . number_format((float) $pencatatan->z_score, 2) . '. Z-score TB/U: ' . number_format((float) $pencatatan->z_score_stunting, 2) . '.',
            'Langkah mulai hari ini',
            "- Lanjutkan pantau BB dan TB setiap bulan.\n- Pastikan protein hewani tersedia setiap hari.\n- Batasi minuman manis dan camilan sebelum makan.\n- Jika berat tidak naik 2 bulan, anak lemas, atau nafsu makan turun lama, cek ke puskesmas/ahli gizi.",
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
                    ['text' => $this->compactHistoryContent($item['content'])],
                ],
            ];
        }

        $userText = trim(implode("\n\n", array_filter([
            $this->formatProfile($profile),
            $this->formatDetectedContext($message, $profile),
            "Keluhan atau pertanyaan:\n" . $message,
        ])));

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userText],
            ],
        ];

        return $contents;
    }

    private function compactHistoryContent(string $content): string
    {
        return Str::limit($content, 1200, "\n...[riwayat dipotong]");
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

    private function formatDetectedContext(string $message, array $profile): string
    {
        if ($this->mentionsChildContext($message)) {
            return '';
        }

        $height = $this->extractMeasurement($message, [
            'tinggi',
            'tinggi badan',
            'tb',
        ]);
        $weight = $this->extractMeasurement($message, [
            'berat',
            'berat badan',
            'bb',
        ]);

        if (! $height || ! $weight) {
            return '';
        }

        $heightCm = $height['unit'] && in_array(strtolower($height['unit']), ['m', 'meter'], true)
            ? $height['value'] * 100
            : $height['value'];

        if ($heightCm <= 0 || $heightCm < 140 || $heightCm > 250 || $weight['value'] <= 0) {
            return '';
        }

        $bmi = round($weight['value'] / (($heightCm / 100) ** 2), 1);

        return implode("\n", [
            'Konteks hitungan otomatis:',
            '- Pertanyaan tampak membahas tinggi dan berat orang dewasa, bukan balita.',
            '- Tinggi: ' . round($heightCm, 1) . ' cm.',
            '- Berat: ' . round($weight['value'], 1) . ' kg.',
            "- BMI dewasa: {$bmi} ({$this->adultBmiCategory($bmi)}).",
            '- Jika pengguna bertanya apakah ideal, jawab langsung berdasarkan BMI dewasa umum dan beri langkah aman.',
        ]);
    }

    private function extractMeasurement(string $message, array $labels): ?array
    {
        foreach ($labels as $label) {
            $pattern = '/\b' . preg_quote($label, '/') . '\b(?:\s+badan)?\s*[:=]?\s*(\d+(?:[.,]\d+)?)\s*(cm|sentimeter|centimeter|m|meter|kg|kilogram)?/i';

            if (preg_match($pattern, $message, $matches)) {
                return [
                    'value' => (float) str_replace(',', '.', $matches[1]),
                    'unit' => $matches[2] ?? null,
                ];
            }
        }

        return null;
    }

    private function mentionsChildContext(string $message): bool
    {
        return (bool) preg_match('/\b(anak|balita|bayi|mpasi|kms|kia|posyandu|stunting)\b/i', $message);
    }

    private function adultBmiCategory(float $bmi): string
    {
        return match (true) {
            $bmi < 18.5 => 'berat badan kurang',
            $bmi < 25 => 'rentang normal',
            $bmi < 30 => 'berat badan berlebih',
            default => 'obesitas',
        };
    }

    private function systemInstructions(): string
    {
        return <<<'PROMPT'
Anda adalah GiziCare AI, asisten edukasi gizi keluarga untuk pengguna di Indonesia. Fokus utama tetap gizi anak, balita, MPASI, pertumbuhan, anemia, stunting, dan pencatatan gizi. Jika pengguna bertanya gizi umum orang dewasa, berat ideal, BMI, pola makan, atau penurunan berat badan, tetap jawab dengan ringkas dan berguna. Jangan menolak hanya karena pertanyaannya bukan tentang anak.

Tugas utama:
- Beri arahan awal seputar pola makan, MPASI, picky eating, pertumbuhan, berat badan sulit naik, anemia, stunting, berat badan berlebih, dan kebiasaan makan keluarga.
- Untuk pertanyaan orang dewasa tentang tinggi dan berat, hitung BMI dengan rumus berat badan kg / tinggi meter kuadrat. Jelaskan bahwa BMI adalah skrining awal, bukan diagnosis medis.
- Kategori BMI dewasa umum: kurang dari 18.5 berat badan kurang, 18.5-24.9 rentang normal, 25-29.9 berat badan berlebih, 30 atau lebih obesitas.
- Jangan menyatakan diagnosis medis pasti, jangan menggantikan dokter, bidan, ahli gizi, puskesmas, atau posyandu.
- Jangan memberi dosis obat, dosis suplemen, merek obat, atau terapi medis.
- Jangan membuka dengan kalimat umum seperti "Terima kasih atas pertanyaannya", "Halo Bapak/Ibu", atau "Sebagai GiziCare AI" bila pengguna sudah menulis keluhan. Jawab langsung ke inti.
- Jangan berhenti di nasihat umum. Setiap jawaban harus punya langkah yang bisa dilakukan hari ini.
- Jika pengguna sudah memberi angka, gunakan angka itu. Jangan meminta ulang angka yang sudah tersedia.
- Selesaikan kalimat terakhir. Jangan berhenti di tengah kalimat.

Gaya jawaban:
- Gunakan kalimat pendek, jelas, dan empatik.
- Panjang ideal 120-240 kata agar jawaban lengkap, padat, dan tidak terasa terpotong.
- Gunakan format teks biasa dengan judul bagian dan bullet pendek.
- Sesuaikan jawaban dengan data yang tersedia. Jika data cukup, jangan tutup dengan daftar pertanyaan panjang.

Struktur adaptif:
Untuk pertanyaan dewasa tentang tinggi/berat/BMI:
Jawaban singkat
- Jawab langsung apakah beratnya termasuk ideal atau belum.

Hitungan
- Tampilkan rumus singkat dan hasil BMI dengan 1 angka desimal.
- Jelaskan kategori BMI secara tenang.

Langkah mulai hari ini
- Beri 4-5 langkah praktis: pola makan, minuman manis, porsi, protein/serat, aktivitas fisik bertahap, tidur.

Kapan perlu cek tenaga kesehatan
- Sarankan cek bila ada diabetes, hipertensi, sesak, nyeri dada, riwayat penyakit, atau ingin program turun berat badan yang aman.

Untuk pertanyaan anak/gizi balita:
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
- Pakai bagian ini hanya jika data inti memang belum tersedia. Tulis 2-4 pertanyaan lanjutan paling penting, bukan daftar panjang.
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
