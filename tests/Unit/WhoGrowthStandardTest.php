<?php

namespace Tests\Unit;

use App\Services\WhoGrowthStandard;
use Tests\TestCase;

class WhoGrowthStandardTest extends TestCase
{
    public function test_it_uses_weight_for_height_for_children_from_24_months(): void
    {
        $result = app(WhoGrowthStandard::class)->assess('L', 24, 12.9, 90);

        $this->assertSame('BB/TB', $result['indicator']);
        $this->assertSame('WHO/UNICEF Weight-for-Height', $result['standard']);
        $this->assertSame('Normal', $result['status']);
        $this->assertEqualsWithDelta(0, $result['z_score'], 0.15);
    }

    public function test_it_classifies_severe_wasting_below_minus_three_sd(): void
    {
        $result = app(WhoGrowthStandard::class)->assess('L', 24, 10.0, 90);

        $this->assertSame('Gizi Buruk', $result['status']);
        $this->assertLessThan(-3, $result['z_score']);
    }

    public function test_it_uses_weight_for_length_under_24_months(): void
    {
        $result = app(WhoGrowthStandard::class)->assess('P', 12, 9.1, 75);

        $this->assertSame('BB/PB', $result['indicator']);
        $this->assertSame('WHO/UNICEF Weight-for-Length', $result['standard']);
        $this->assertSame('Normal', $result['status']);
    }

    public function test_it_assesses_stunting_from_height_for_age(): void
    {
        $result = app(WhoGrowthStandard::class)->assessStunting('L', 24, 90);

        $this->assertSame('TB/U', $result['indicator']);
        $this->assertSame('WHO/UNICEF Length/Height-for-Age', $result['standard']);
        $this->assertSame('Normal', $result['status']);
    }

    public function test_it_classifies_severe_stunting_below_minus_three_sd(): void
    {
        $result = app(WhoGrowthStandard::class)->assessStunting('L', 24, 75);

        $this->assertSame('Stunting Berat', $result['status']);
        $this->assertLessThan(-3, $result['z_score']);
    }
}
