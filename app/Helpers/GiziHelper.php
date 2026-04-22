<?php

if (!function_exists('hitungStatus')) {
    function hitungStatus($bb, $tb)
    {
        $imt = $bb / (($tb / 100) * ($tb / 100));

        if ($imt < 18.5) return "Kurus";
        elseif ($imt < 25) return "Normal";
        else return "Gemuk";
    }
}
