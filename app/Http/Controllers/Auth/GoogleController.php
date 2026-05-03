<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google OAuth.
     */
    public function redirect(): RedirectResponse
    {
        if (blank(config('services.google.client_id')) || blank(config('services.google.client_secret'))) {
            return redirect()
                ->route('login')
                ->with('error', 'Login Google belum dikonfigurasi. Gunakan email dan password terlebih dahulu.');
        }

        return Socialite::driver('google')
            ->redirectUrl(route('google.callback'))
            ->redirect();
    }

    /**
     * Handle callback dari Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('google.callback'))
                ->user();
            $email = $googleUser->getEmail();

            if (blank($email)) {
                return redirect()
                    ->route('login')
                    ->with('error', 'Akun Google tidak mengirim email. Gunakan email dan password.');
            }

            $user = User::where('email', $email)->first();

            if ($user) {
                $user->forceFill([
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ])->save();
            } else {
                $user = User::create([
                    'name' => $googleUser->getName() ?: Str::before($email, '@'),
                    'email' => $email,
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(32)),
                ]);
            }

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Throwable $e) {
            Log::warning('Google login failed.', [
                'message' => $e->getMessage(),
                'type' => $e::class,
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Gagal login dengan Google. Pastikan Client ID dan Client Secret sesuai OAuth Client yang aktif.');
        }
    }
}
