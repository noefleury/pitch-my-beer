<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Tests\Feature\Helpers\VolumeTest;
use Throwable;

/**
 * @see VolumeTest
 */
class Volume
{

    /**
     * Get formatted volume value depending on volume system config (metric, etc.)
     *
     * @param   float  $liters
     *
     * @return string formatted & normalized value
     * @throws Throwable
     */
    public static function getFormattedValue(float $liters): string
    {
        $value = match (self::getVolumeSystemFromConfig()) {
            'metric' => $liters,
            'us_customary' => $liters * 0.264172,
            'uk_imperial' => $liters * 0.219969,
        };

        $symbol = self::getUnitSymbol($value);

        if ($value < 1.0) {
            $value *= match (self::getVolumeSystemFromConfig()) {
                'metric' => 1000,
                'us_customary' => 128,
                'uk_imperial' => 160,
            };
        }

        return round($value, 2)." $symbol";
    }

    /**
     * Get volume system from config
     *
     * @return string
     *
     * @throws Throwable
     */
    private static function getVolumeSystemFromConfig(): string
    {
        $system = Config::string('custom.units.volume_system', 'metric');

        throw_if(
            !in_array($system, ['metric', 'us_customary', 'uk_imperial']),
            'Config error. Volume system is not valid',
        );

        return $system;
    }

    /**
     * Get unit symbol from config depending on given value
     *
     * @param   float  $value
     *
     * @return string
     * @throws Throwable
     */
    private static function getUnitSymbol(float $value): string
    {
        $greaterThanOne = $value > 1.0;

        return match (self::getVolumeSystemFromConfig()) {
            'metric' => $greaterThanOne ? 'L' : 'mL',
            'us_customary', 'uk_imperial' => $greaterThanOne ? 'gal' : 'oz',
        };
    }


}
