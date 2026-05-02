<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DiagnosisChatTest extends TestCase
{
    public function test_diagnosis_chat_requires_openai_api_key(): void
    {
        config(['services.openai.api_key' => null]);

        $response = $this->postJson(route('diagnosis.chat'), [
            'message' => 'Anak saya susah makan.',
        ]);

        $response
            ->assertStatus(503)
            ->assertJsonFragment([
                'message' => 'OPENAI_API_KEY belum diatur di file .env. Isi key lalu jalankan php artisan config:clear.',
            ]);
    }

    public function test_diagnosis_chat_returns_openai_reply(): void
    {
        config([
            'services.openai.api_key' => 'test-key',
            'services.openai.model' => 'gpt-5-mini',
        ]);

        Http::fake([
            'api.openai.com/v1/responses' => Http::response([
                'output_text' => "1. Ringkasan singkat kondisi.\nAnak perlu dipantau pola makannya.",
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
                'model' => 'gpt-5-mini',
            ]);

        Http::assertSent(fn ($request) => $request->url() === 'https://api.openai.com/v1/responses'
            && $request['model'] === 'gpt-5-mini'
            && $request['max_output_tokens'] === 800
        );
    }

    public function test_diagnosis_chat_reports_openai_quota_problem(): void
    {
        config([
            'services.openai.api_key' => 'test-key',
            'services.openai.model' => 'gpt-5-mini',
        ]);

        Http::fake([
            'api.openai.com/v1/responses' => Http::response([
                'error' => [
                    'message' => 'You exceeded your current quota.',
                    'type' => 'insufficient_quota',
                    'code' => 'insufficient_quota',
                ],
            ], 429),
        ]);

        $response = $this->postJson(route('diagnosis.chat'), [
            'message' => 'Anak saya susah makan.',
        ]);

        $response
            ->assertStatus(429)
            ->assertJson([
                'message' => 'API key sudah terbaca, tetapi kuota atau billing OpenAI belum aktif atau sudah habis. Cek Usage dan Billing di dashboard OpenAI.',
            ]);
    }
}
