<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DiagnosisChatTest extends TestCase
{
    public function test_diagnosis_chat_requires_gemini_api_key(): void
    {
        config(['services.gemini.api_key' => null]);

        $response = $this->postJson(route('diagnosis.chat'), [
            'message' => 'Anak saya susah makan.',
        ]);

        $response
            ->assertStatus(503)
            ->assertJsonFragment([
                'message' => 'GEMINI_API_KEY belum diatur di file .env. Isi key dari Google AI Studio lalu jalankan php artisan config:clear.',
            ]);
    }

    public function test_diagnosis_chat_returns_gemini_reply(): void
    {
        config([
            'services.gemini.api_key' => 'test-key',
            'services.gemini.model' => 'gemini-2.5-flash',
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => "1. Ringkasan singkat kondisi.\nAnak perlu dipantau pola makannya."],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $response = $this->postJson(route('diagnosis.chat'), [
            'message' => 'Anak saya susah makan.',
            'profile' => [
                'umur' => 24,
                'berat' => 10,
                'tinggi' => 82,
            ],
            'history' => [],
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'reply' => "1. Ringkasan singkat kondisi.\nAnak perlu dipantau pola makannya.",
                'model' => 'gemini-2.5-flash',
            ]);

        Http::assertSent(fn ($request) => $request->url() === 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent'
            && $request->hasHeader('x-goog-api-key', 'test-key')
            && $request['generationConfig']['maxOutputTokens'] === 800
            && $request['contents'][0]['role'] === 'user'
        );
    }

    public function test_diagnosis_chat_reports_gemini_quota_problem(): void
    {
        config([
            'services.gemini.api_key' => 'test-key',
            'services.gemini.model' => 'gemini-2.5-flash',
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent' => Http::response([
                'error' => [
                    'code' => 429,
                    'message' => 'Quota exceeded.',
                    'status' => 'RESOURCE_EXHAUSTED',
                ],
            ], 429),
        ]);

        $response = $this->postJson(route('diagnosis.chat'), [
            'message' => 'Anak saya susah makan.',
        ]);

        $response
            ->assertStatus(429)
            ->assertJson([
                'message' => 'Batas request Gemini sedang tercapai. Tunggu kuota reset atau cek limit di Google AI Studio.',
            ]);
    }
}
