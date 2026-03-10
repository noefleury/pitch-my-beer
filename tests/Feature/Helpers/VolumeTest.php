<?php

namespace Tests\Feature\Helpers;

use App\Helpers\Volume;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;
use Throwable;

/**
 * @see Volume
 */
class VolumeTest extends TestCase
{

    /**
     * @throws Throwable
     */
    public function test_get_default_unit_symbol()
    {
        $this->assertSame('metric', Config::get('custom.units.volume_system'));
    }

    /**
     * @throws Throwable
     */
    public function test_use_invalid_volume_system()
    {
        Config::set('custom.units.volume_system', 'dummy');
        $this->expectExceptionMessage('Config error. Volume system is not valid');
        Volume::getFormattedValue(2.50);
    }

    /**
     * @throws Throwable
     */
    #[TestWith(['2.5 L', 2.50])]
    #[TestWith(['330 mL', 0.330])]
    public function test_format_volume_in_liter(string $expectedValue, float $inputValue)
    {
        Config::set('custom.units.volume_system', 'metric');
        $this->assertSame($expectedValue, Volume::getFormattedValue($inputValue));
    }

    /**
     * @throws Throwable
     */
    #[TestWith(['2.5 gal', 9.46352946])]
    #[TestWith(['20 oz', 0.59147059])]
    public function test_format_volume_in_gallon_us(string $expectedValue, float $inputValue)
    {
        Config::set('custom.units.volume_system', 'us_customary');
        $this->assertSame($expectedValue, Volume::getFormattedValue($inputValue));
    }

    /**
     * @throws Throwable
     */
    #[TestWith(['2.5 gal', 11.3652])]
    #[TestWith(['20 oz', 0.5682612])]
    public function test_format_volume_in_gallon_uk(string $expectedValue, float $inputValue)
    {
        Config::set('custom.units.volume_system', 'uk_imperial');
        $this->assertSame($expectedValue, Volume::getFormattedValue($inputValue));
    }


}
