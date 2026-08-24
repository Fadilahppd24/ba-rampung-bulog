<?php

namespace App\Services;

class RendemenCalculator
{
    /**
     * Rendemen (%) = (kuantum hasil / kuantum bahan sebelum pengolahan) * 100
     *
     * This is always recomputed server-side on save; the frontend value
     * (if any) is display-only and never persisted as-is.
     */
    public static function hitung(float $kuantumSebelum, float $kuantumSesudah): float
    {
        if ($kuantumSebelum <= 0) {
            return 0.0;
        }

        return round(($kuantumSesudah / $kuantumSebelum) * 100, 2);
    }
}
