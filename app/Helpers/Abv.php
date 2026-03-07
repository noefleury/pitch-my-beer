<?php

namespace App\Helpers;

use Tests\Unit\Helpers\AbvTest;

/**
 * @see AbvTest
 */
class Abv
{

    /**
     * Compute the ABV from OG and FG
     *
     * @note using alternate formula
     *
     * @param   float  $originalGravity
     * @param   float  $finalGravity
     *
     * @return float ABV (in %)
     */
    public static function computeFromGravities(float $originalGravity, float $finalGravity): float
    {
        $og = $originalGravity;
        $fg = $finalGravity;

        return ((76.08 * ($og - $fg)) / (1.775 - $og)) * ($fg / 0.794);
    }

}
