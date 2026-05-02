<?php

namespace App\Services;

use InvalidArgumentException;

class WhoGrowthStandard
{
    public function assess(string $sex, int $ageMonths, float $weightKg, float $heightCm): array
    {
        $tableKey = $this->tableKeyFor($sex, $ageMonths);
        $table = config("who_growth.{$tableKey}", []);

        if (!$table) {
            throw new InvalidArgumentException('Tabel standar WHO tidak tersedia.');
        }

        $measure = round($heightCm, 1);
        $rowKey = $this->normalizeMeasureKey($measure);

        if (!array_key_exists($rowKey, $table)) {
            [$min, $max] = $this->range($table);
            $label = $ageMonths < 24 ? 'panjang badan' : 'tinggi badan';

            throw new InvalidArgumentException(sprintf(
                'Nilai %s %.1f cm di luar rentang tabel WHO untuk usia ini (%.1f-%.1f cm).',
                $label,
                $heightCm,
                $min,
                $max
            ));
        }

        $row = $table[$rowKey];
        $zScore = $this->calculateZScore($weightKg, (float) $row['l'], (float) $row['m'], (float) $row['s']);

        return [
            'indicator' => $ageMonths < 24 ? 'BB/PB' : 'BB/TB',
            'standard' => $ageMonths < 24
                ? 'WHO/UNICEF Weight-for-Length'
                : 'WHO/UNICEF Weight-for-Height',
            'measurement_cm' => $measure,
            'z_score' => round($zScore, 2),
            'status' => $this->classifyWeightForHeight($zScore),
        ];
    }

    public function assessStunting(string $sex, int $ageMonths, float $heightCm): array
    {
        $tableKey = $this->stuntingTableKeyFor($sex);
        $table = config("who_growth.{$tableKey}", []);

        if (!$table) {
            throw new InvalidArgumentException('Tabel standar WHO untuk stunting tidak tersedia.');
        }

        $ageDays = $this->ageMonthsToDays($ageMonths);
        $rowKey = $this->normalizeMeasureKey($ageDays);

        if (!array_key_exists($rowKey, $table)) {
            [$min, $max] = $this->range($table);

            throw new InvalidArgumentException(sprintf(
                'Usia %d bulan di luar rentang tabel WHO untuk stunting (%d-%d hari).',
                $ageMonths,
                (int) $min,
                (int) $max
            ));
        }

        $row = $table[$rowKey];
        $zScore = $this->calculateZScore($heightCm, (float) $row['l'], (float) $row['m'], (float) $row['s']);

        return [
            'indicator' => $ageMonths < 24 ? 'PB/U' : 'TB/U',
            'standard' => 'WHO/UNICEF Length/Height-for-Age',
            'age_days' => $ageDays,
            'z_score' => round($zScore, 2),
            'status' => $this->classifyStunting($zScore),
        ];
    }

    private function tableKeyFor(string $sex, int $ageMonths): string
    {
        $suffix = match ($sex) {
            'L' => 'boys',
            'P' => 'girls',
            default => throw new InvalidArgumentException('Jenis kelamin harus L atau P.'),
        };

        return ($ageMonths < 24 ? 'wfl_' : 'wfh_') . $suffix;
    }

    private function stuntingTableKeyFor(string $sex): string
    {
        $suffix = match ($sex) {
            'L' => 'boys',
            'P' => 'girls',
            default => throw new InvalidArgumentException('Jenis kelamin harus L atau P.'),
        };

        return 'lhfa_' . $suffix;
    }

    private function ageMonthsToDays(int $ageMonths): int
    {
        return (int) round($ageMonths * 30.4375);
    }

    private function calculateZScore(float $value, float $l, float $m, float $s): float
    {
        if ($m <= 0 || $s <= 0) {
            throw new InvalidArgumentException('Parameter tabel WHO tidak valid.');
        }

        if (abs($l) < 0.000001) {
            return log($value / $m) / $s;
        }

        return (pow($value / $m, $l) - 1) / ($l * $s);
    }

    private function classifyWeightForHeight(float $zScore): string
    {
        return match (true) {
            $zScore < -3 => 'Gizi Buruk',
            $zScore < -2 => 'Gizi Kurang',
            $zScore <= 1 => 'Normal',
            $zScore <= 2 => 'Risiko Lebih',
            $zScore <= 3 => 'Gizi Lebih',
            default => 'Obesitas',
        };
    }

    private function classifyStunting(float $zScore): string
    {
        return match (true) {
            $zScore < -3 => 'Stunting Berat',
            $zScore < -2 => 'Stunting',
            $zScore > 3 => 'Tinggi',
            default => 'Normal',
        };
    }

    private function normalizeMeasureKey(float $measure): int|string
    {
        if (abs($measure - round($measure)) < 0.000001) {
            return (int) round($measure);
        }

        return number_format($measure, 1, '.', '');
    }

    private function range(array $table): array
    {
        $keys = array_map('floatval', array_keys($table));

        return [min($keys), max($keys)];
    }
}
