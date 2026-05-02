<?php

if (!function_exists('hitungStatus')) {
    function hitungStatus($bb, $tb, $jk = null, $umur = null)
    {
        if ($jk !== null && $umur !== null) {
            return app(\App\Services\WhoGrowthStandard::class)
                ->assess((string) $jk, (int) $umur, (float) $bb, (float) $tb)['status'];
        }

        return 'Butuh umur dan jenis kelamin';
    }
}
