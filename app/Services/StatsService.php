<?php

namespace App\Services;

use App\Models\Beer;
use App\Models\Bottling;
use App\Models\Keg;

class StatsService
{

    /**
     * Compute some global stats
     *
     * @note scoped on beers which are ready (not fermenting, etc.)
     *
     * @return array
     */
    public function computeGlobalStats(): array
    {
        return [
            'beers_drunk'          => Beer::consumed()->count(),
            'beers_bought_drunk'   => Beer::consumed()->bought()->count(),
            'beers_homemade_drunk' => Beer::consumed()->homemade()->count(),
            'liters_drunk'         => (float)Beer::consumed()->sum('volume'),
            'bottles_drunk'        => Bottling::query()->whereNotNull('deleted_at')->count(),
        ];
    }

    public function computeKegStats(Keg $keg): array
    {
        return [
            'kegged_count'  => $keg->keggings()->count(),
            'kegged_liters' => (float)$keg->keggings()->sum('volume'),
        ];
    }

}
