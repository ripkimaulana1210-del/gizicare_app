<?php

namespace Tests\Feature;

use App\Models\Pencatatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PencatatanGrowthStandardTest extends TestCase
{
    use RefreshDatabase;

    public function test_pencatatan_stores_who_unicef_growth_assessment(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pencatatan.store'), [
            'nama' => 'Ari',
            'posyandu' => 'Posyandu Melati',
            'jk' => 'L',
            'umur' => 24,
            'bb' => 12.9,
            'tb' => 90,
            'lk' => 48,
        ]);

        $response->assertSessionHasNoErrors();

        $record = Pencatatan::first();

        $this->assertNotNull($record);
        $this->assertSame($user->id, $record->user_id);
        $this->assertSame('Posyandu Melati', $record->posyandu);
        $this->assertSame('Normal', $record->status);
        $this->assertSame('BB/TB', $record->indikator);
        $this->assertSame('WHO/UNICEF Weight-for-Height', $record->standar);
        $this->assertEqualsWithDelta(0, $record->z_score, 0.15);
        $this->assertSame('TB/U', $record->indikator_stunting);
        $this->assertSame('Normal', $record->status_stunting);
        $this->assertSame('WHO/UNICEF Length/Height-for-Age', $record->standar_stunting);
    }

    public function test_pencatatan_rejects_values_outside_who_table_range(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('pencatatan.index'))
            ->post(route('pencatatan.store'), [
                'nama' => 'Bima',
                'posyandu' => 'Posyandu Mawar',
                'jk' => 'L',
                'umur' => 24,
                'bb' => 8,
                'tb' => 60,
                'lk' => null,
            ]);

        $response->assertRedirect(route('pencatatan.index'));
        $response->assertSessionHasErrors('tb');
        $this->assertDatabaseCount('pencatatans', 0);
    }

    public function test_pencatatan_can_be_filtered_by_posyandu(): void
    {
        $user = User::factory()->create();

        Pencatatan::create([
            'user_id' => $user->id,
            'nama' => 'Ari',
            'posyandu' => 'Posyandu Melati',
            'jk' => 'L',
            'umur' => 24,
            'bb' => 12.9,
            'tb' => 90,
            'lk' => 48,
            'imt' => 15.93,
            'status' => 'Normal',
            'indikator' => 'BB/TB',
            'z_score' => 0,
            'standar' => 'WHO/UNICEF Weight-for-Height',
            'indikator_stunting' => 'TB/U',
            'z_score_stunting' => 0,
            'status_stunting' => 'Normal',
            'standar_stunting' => 'WHO/UNICEF Length/Height-for-Age',
        ]);

        Pencatatan::create([
            'user_id' => $user->id,
            'nama' => 'Bima',
            'posyandu' => 'Posyandu Mawar',
            'jk' => 'L',
            'umur' => 24,
            'bb' => 10,
            'tb' => 90,
            'lk' => 48,
            'imt' => 12.35,
            'status' => 'Gizi Buruk',
            'indikator' => 'BB/TB',
            'z_score' => -3.5,
            'standar' => 'WHO/UNICEF Weight-for-Height',
            'indikator_stunting' => 'TB/U',
            'z_score_stunting' => -3.2,
            'status_stunting' => 'Stunting Berat',
            'standar_stunting' => 'WHO/UNICEF Length/Height-for-Age',
        ]);

        $response = $this->actingAs($user)->get(route('pencatatan.index', [
            'posyandu' => 'Posyandu Melati',
        ]));

        $response->assertOk();
        $response->assertSee('Ari');
        $response->assertSee('Posyandu Melati');
        $response->assertDontSee('Bima');
    }

    public function test_pencatatan_is_shared_across_authenticated_users(): void
    {
        $user = User::factory()->create(['name' => 'Petugas Melati']);
        $otherUser = User::factory()->create(['name' => 'Petugas Mawar']);

        Pencatatan::create($this->pencatatanAttributes([
            'user_id' => $user->id,
            'nama' => 'Ari',
            'posyandu' => 'Posyandu Melati',
        ]));

        Pencatatan::create($this->pencatatanAttributes([
            'user_id' => $otherUser->id,
            'nama' => 'Data Akun Lain',
            'posyandu' => 'Posyandu Mawar',
            'jk' => 'P',
        ]));

        $response = $this->actingAs($user)->get(route('pencatatan.index'));

        $response->assertOk();
        $response->assertSee('Ari');
        $response->assertSee('Data Akun Lain');
        $response->assertSee('Petugas Melati');
        $response->assertSee('Petugas Mawar');
    }

    public function test_shared_pencatatan_can_be_updated_without_replacing_creator(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $record = Pencatatan::create($this->pencatatanAttributes([
            'user_id' => $otherUser->id,
            'nama' => 'Data Akun Lain',
        ]));

        $response = $this->actingAs($user)->put(route('pencatatan.update', $record), [
            'nama' => 'Data Diperbarui',
            'posyandu' => 'Posyandu Melati',
            'jk' => 'L',
            'umur' => 24,
            'bb' => 12.9,
            'tb' => 90,
            'lk' => 48,
        ]);

        $response->assertRedirect(route('pencatatan.index'));

        $record->refresh();
        $this->assertSame($otherUser->id, $record->user_id);
        $this->assertSame('Data Diperbarui', $record->nama);
    }

    private function pencatatanAttributes(array $overrides = []): array
    {
        return array_merge([
            'user_id' => null,
            'nama' => 'Ari',
            'posyandu' => 'Posyandu Melati',
            'jk' => 'L',
            'umur' => 24,
            'bb' => 12.9,
            'tb' => 90,
            'lk' => 48,
            'imt' => 15.93,
            'status' => 'Normal',
            'indikator' => 'BB/TB',
            'z_score' => 0,
            'standar' => 'WHO/UNICEF Weight-for-Height',
            'indikator_stunting' => 'TB/U',
            'z_score_stunting' => 0,
            'status_stunting' => 'Normal',
            'standar_stunting' => 'WHO/UNICEF Length/Height-for-Age',
        ], $overrides);
    }
}
