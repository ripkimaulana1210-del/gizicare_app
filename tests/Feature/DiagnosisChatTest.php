<?php

namespace Tests\Feature;

use App\Models\DiagnosisMessage;
use App\Models\DiagnosisSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DiagnosisChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_diagnosis_chat_requires_login(): void
    {
        $response = $this->postJson(route('diagnosis.chat'), [
            'message' => 'Anak saya susah makan.',
        ]);

        $response->assertUnauthorized();
    }

    public function test_diagnosis_chat_requires_gemini_api_key(): void
    {
        config(['services.gemini.api_key' => null]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('diagnosis.chat'), [
            'message' => 'Anak saya susah makan.',
        ]);

        $response
            ->assertStatus(503)
            ->assertJsonFragment([
                'message' => 'GEMINI_API_KEY belum diatur di file .env. Isi key dari Google AI Studio lalu jalankan php artisan config:clear.',
            ]);
    }

    public function test_diagnosis_page_loads_saved_chat_history_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $session = DiagnosisSession::create([
            'user_id' => $user->id,
            'title' => 'Sesi saya',
        ]);
        $otherSession = DiagnosisSession::create([
            'user_id' => $otherUser->id,
            'title' => 'Sesi orang lain',
        ]);

        DiagnosisMessage::create([
            'user_id' => $user->id,
            'diagnosis_session_id' => $session->id,
            'role' => 'user',
            'content' => 'Riwayat chat akun saya',
        ]);

        DiagnosisMessage::create([
            'user_id' => $otherUser->id,
            'diagnosis_session_id' => $otherSession->id,
            'role' => 'user',
            'content' => 'Riwayat akun lain',
        ]);

        $response = $this->actingAs($user)->get(route('diagnosis'));

        $response->assertOk();
        $response->assertSee('Riwayat chat akun saya');
        $response->assertDontSee('Riwayat akun lain');
    }

    public function test_user_can_create_and_delete_diagnosis_session(): void
    {
        $user = User::factory()->create();

        $createResponse = $this->actingAs($user)->post(route('diagnosis.session.store'));

        $session = DiagnosisSession::where('user_id', $user->id)->first();

        $this->assertNotNull($session);
        $this->assertNull($session->pencatatan_id);
        $createResponse->assertRedirect(route('diagnosis', ['session' => $session->id]));

        $this->actingAs($user)
            ->delete(route('diagnosis.session.destroy', $session))
            ->assertRedirect(route('diagnosis'));

        $this->assertDatabaseMissing('diagnosis_sessions', [
            'id' => $session->id,
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

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('diagnosis.chat'), [
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
            && $request['generationConfig']['maxOutputTokens'] === 2200
            && $request['generationConfig']['temperature'] === 0.42
            && $request['generationConfig']['topP'] === 0.9
            && $request['contents'][0]['role'] === 'user'
            && str_contains($request['system_instruction']['parts'][0]['text'], 'Jangan membuka dengan kalimat umum')
            && str_contains($request['system_instruction']['parts'][0]['text'], 'Langkah mulai hari ini')
        );

        $this->assertDatabaseHas('diagnosis_messages', [
            'user_id' => $user->id,
            'role' => 'user',
            'content' => 'Anak saya susah makan.',
        ]);

        $this->assertDatabaseHas('diagnosis_messages', [
            'user_id' => $user->id,
            'role' => 'assistant',
            'content' => "1. Ringkasan singkat kondisi.\nAnak perlu dipantau pola makannya.",
        ]);

        $this->assertDatabaseHas('diagnosis_sessions', [
            'user_id' => $user->id,
            'title' => 'Anak Saya Susah Makan',
            'pencatatan_id' => null,
        ]);
    }

    public function test_diagnosis_chat_sends_adult_bmi_context_when_height_and_weight_are_present(): void
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
                                ['text' => "Jawaban singkat\nBMI sekitar 36,2 dan belum termasuk ideal."],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('diagnosis.chat'), [
            'message' => 'tinggi 175cm dan berat 111kg apakah ideal',
            'history' => [],
        ]);

        $response->assertOk();

        Http::assertSent(fn ($request) => str_contains($request['contents'][0]['parts'][0]['text'], 'Konteks hitungan otomatis')
            && str_contains($request['contents'][0]['parts'][0]['text'], 'BMI dewasa: 36.2 (obesitas)')
            && str_contains($request['system_instruction']['parts'][0]['text'], 'Jika pengguna bertanya gizi umum orang dewasa')
        );
    }

    public function test_diagnosis_chat_compacts_long_history_before_sending_to_gemini(): void
    {
        config([
            'services.gemini.api_key' => 'test-key',
            'services.gemini.model' => 'gemini-2.5-flash',
        ]);

        $user = User::factory()->create();
        $session = DiagnosisSession::create([
            'user_id' => $user->id,
            'title' => 'BMI dewasa',
        ]);

        DiagnosisMessage::create([
            'user_id' => $user->id,
            'diagnosis_session_id' => $session->id,
            'role' => 'user',
            'content' => 'tinggi 175cm dan berat 111kg apakah ideal',
        ]);

        DiagnosisMessage::create([
            'user_id' => $user->id,
            'diagnosis_session_id' => $session->id,
            'role' => 'assistant',
            'content' => str_repeat('Respons panjang. ', 180),
            'model' => 'gemini-2.5-flash',
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Jawaban baru.'],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $response = $this->actingAs($user)->postJson(route('diagnosis.chat'), [
            'message' => 'BERAPA BERAT BADAN IDEALNYA',
            'session_id' => $session->id,
            'history' => [],
        ]);

        $response->assertOk();

        Http::assertSent(fn ($request) => collect($request['contents'])->contains(
            fn ($content) => str_contains($content['parts'][0]['text'], '[riwayat dipotong]')
                && strlen($content['parts'][0]['text']) < 1300
        ));
    }

    public function test_diagnosis_chat_uses_local_fallback_when_gemini_quota_is_exhausted(): void
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

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('diagnosis.chat'), [
            'message' => 'tinggi 175 cm berat 111 kg apakah ideal',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'model' => 'fallback-local',
                'fallback' => true,
            ]);

        $this->assertStringContainsString('BMI', $response->json('reply'));
    }
}
