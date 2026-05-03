<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function test_new_users_can_register_from_ngrok_forwarded_request(): void
    {
        $response = $this
            ->withServerVariables([
                'HTTP_HOST' => 'unburned-kitten-scoundrel.ngrok-free.dev',
                'HTTPS' => 'on',
                'HTTP_X_FORWARDED_HOST' => 'unburned-kitten-scoundrel.ngrok-free.dev',
                'HTTP_X_FORWARDED_PROTO' => 'https',
                'HTTP_X_FORWARDED_PORT' => '443',
            ])
            ->post('/register', [
                'name' => 'Ngrok User',
                'email' => 'ngrok-user@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->assertDatabaseHas('users', [
            'name' => 'Ngrok User',
            'email' => 'ngrok-user@example.com',
        ]);
    }
}
