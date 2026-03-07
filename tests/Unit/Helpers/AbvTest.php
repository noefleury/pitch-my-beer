<?php

namespace Tests\Unit\Helpers;

use App\Helpers\Abv;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

/**
 * @see Abv
 */
class AbvTest extends TestCase
{

    #[TestWith([6.61, 1.050, 1.000])]
    #[TestWith([5.34, 1.050, 1.010])]
    #[TestWith([3.31, 1.040, 1.015])]
    #[TestWith([8.71, 1.056, 0.990])]
    public function test_compute_abv_from_gravities(float $expectedAbv, float $originalGravity, float $finalGravity)
    {
        $this->assertEqualsWithDelta($expectedAbv, Abv::computeFromGravities($originalGravity, $finalGravity), 0.01);
    }


}
