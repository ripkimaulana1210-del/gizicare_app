<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedPageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_edukasi_and_diagnosis_pages(): void
    {
        $this->get(route('edukasi.index'))
            ->assertRedirect(route('login'));

        $this->get(route('diagnosis'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_open_edukasi_and_diagnosis_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('edukasi.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('diagnosis'))
            ->assertOk();
    }
}
