<?php

namespace Database\Seeders;

use App\Models\Pencatatan;
use App\Services\WhoGrowthStandard;
use Illuminate\Database\Seeder;

class PencatatanDummySeeder extends Seeder
{
    public function run(): void
    {
        $growthStandard = app(WhoGrowthStandard::class);

        $records = [
            ['nama' => 'Aisyah', 'posyandu' => 'Posyandu Melati', 'jk' => 'P', 'umur' => 12, 'bb' => 9.1, 'tb' => 75.0, 'lk' => 45.2],
            ['nama' => 'Bima', 'posyandu' => 'Posyandu Melati', 'jk' => 'L', 'umur' => 18, 'bb' => 8.6, 'tb' => 80.0, 'lk' => 46.0],
            ['nama' => 'Citra', 'posyandu' => 'Posyandu Melati', 'jk' => 'P', 'umur' => 24, 'bb' => 11.4, 'tb' => 85.0, 'lk' => 46.8],
            ['nama' => 'Dimas', 'posyandu' => 'Posyandu Melati', 'jk' => 'L', 'umur' => 36, 'bb' => 14.6, 'tb' => 96.0, 'lk' => 48.0],
            ['nama' => 'Elin', 'posyandu' => 'Posyandu Melati', 'jk' => 'P', 'umur' => 48, 'bb' => 17.9, 'tb' => 103.5, 'lk' => 49.1],

            ['nama' => 'Farhan', 'posyandu' => 'Posyandu Mawar', 'jk' => 'L', 'umur' => 10, 'bb' => 8.9, 'tb' => 72.0, 'lk' => 45.7],
            ['nama' => 'Gita', 'posyandu' => 'Posyandu Mawar', 'jk' => 'P', 'umur' => 16, 'bb' => 7.3, 'tb' => 70.0, 'lk' => 45.0],
            ['nama' => 'Hana', 'posyandu' => 'Posyandu Mawar', 'jk' => 'P', 'umur' => 30, 'bb' => 14.7, 'tb' => 92.0, 'lk' => 47.3],
            ['nama' => 'Iqbal', 'posyandu' => 'Posyandu Mawar', 'jk' => 'L', 'umur' => 42, 'bb' => 16.8, 'tb' => 101.0, 'lk' => 49.0],
            ['nama' => 'Jihan', 'posyandu' => 'Posyandu Mawar', 'jk' => 'P', 'umur' => 54, 'bb' => 14.1, 'tb' => 98.0, 'lk' => 48.8],

            ['nama' => 'Kania', 'posyandu' => 'Posyandu Kenanga', 'jk' => 'P', 'umur' => 8, 'bb' => 7.7, 'tb' => 68.0, 'lk' => 43.9],
            ['nama' => 'Lala', 'posyandu' => 'Posyandu Kenanga', 'jk' => 'P', 'umur' => 20, 'bb' => 10.0, 'tb' => 82.5, 'lk' => 46.4],
            ['nama' => 'Malik', 'posyandu' => 'Posyandu Kenanga', 'jk' => 'L', 'umur' => 24, 'bb' => 9.5, 'tb' => 78.0, 'lk' => 47.1],
            ['nama' => 'Nabila', 'posyandu' => 'Posyandu Kenanga', 'jk' => 'P', 'umur' => 36, 'bb' => 16.2, 'tb' => 96.5, 'lk' => 48.0],
            ['nama' => 'Oka', 'posyandu' => 'Posyandu Kenanga', 'jk' => 'L', 'umur' => 60, 'bb' => 14.0, 'tb' => 96.0, 'lk' => 50.2],

            ['nama' => 'Putri', 'posyandu' => 'Posyandu Cempaka', 'jk' => 'P', 'umur' => 14, 'bb' => 8.2, 'tb' => 74.0, 'lk' => 44.8],
            ['nama' => 'Raka', 'posyandu' => 'Posyandu Cempaka', 'jk' => 'L', 'umur' => 22, 'bb' => 11.8, 'tb' => 86.0, 'lk' => 47.8],
            ['nama' => 'Sari', 'posyandu' => 'Posyandu Cempaka', 'jk' => 'P', 'umur' => 28, 'bb' => 10.7, 'tb' => 82.0, 'lk' => 46.1],
            ['nama' => 'Tegar', 'posyandu' => 'Posyandu Cempaka', 'jk' => 'L', 'umur' => 44, 'bb' => 18.2, 'tb' => 103.0, 'lk' => 49.8],
            ['nama' => 'Vina', 'posyandu' => 'Posyandu Cempaka', 'jk' => 'P', 'umur' => 58, 'bb' => 20.6, 'tb' => 110.0, 'lk' => 50.0],

            ['nama' => 'Wulan', 'posyandu' => 'Posyandu Anggrek', 'jk' => 'P', 'umur' => 11, 'bb' => 8.3, 'tb' => 72.5, 'lk' => 44.4],
            ['nama' => 'Yoga', 'posyandu' => 'Posyandu Anggrek', 'jk' => 'L', 'umur' => 26, 'bb' => 12.9, 'tb' => 91.0, 'lk' => 48.0],
            ['nama' => 'Zahra', 'posyandu' => 'Posyandu Anggrek', 'jk' => 'P', 'umur' => 34, 'bb' => 12.0, 'tb' => 94.0, 'lk' => 47.2],
            ['nama' => 'Rian', 'posyandu' => 'Posyandu Anggrek', 'jk' => 'L', 'umur' => 52, 'bb' => 15.5, 'tb' => 99.0, 'lk' => 49.4],
        ];

        foreach ($records as $record) {
            $bb = (float) $record['bb'];
            $tb = (float) $record['tb'];
            $assessment = $growthStandard->assess($record['jk'], (int) $record['umur'], $bb, $tb);
            $stunting = $growthStandard->assessStunting($record['jk'], (int) $record['umur'], $tb);

            Pencatatan::updateOrCreate(
                [
                    'nama' => $record['nama'],
                    'posyandu' => $record['posyandu'],
                ],
                [
                    ...$record,
                    'imt' => round($bb / pow($tb / 100, 2), 2),
                    'status' => $assessment['status'],
                    'indikator' => $assessment['indicator'],
                    'z_score' => $assessment['z_score'],
                    'standar' => $assessment['standard'],
                    'indikator_stunting' => $stunting['indicator'],
                    'z_score_stunting' => $stunting['z_score'],
                    'status_stunting' => $stunting['status'],
                    'standar_stunting' => $stunting['standard'],
                ]
            );
        }
    }
}
