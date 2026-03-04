<?php

namespace App\Services;

use App\Models\Fermenter;
use Illuminate\Support\Carbon;

class FermenterService
{

    public function show(Fermenter $fermenter): Fermenter
    {
        return $fermenter;
    }

    /**
     * Get relations data
     *
     * @param   Fermenter  $fermenter
     *
     * @return array{current_fermentation: array{id: int, volume: float, created_at: Carbon}}
     */
    public function getRelationsData(Fermenter $fermenter): array
    {
        return [
            'current_fermentation' => $fermenter->fermentations()->latest()->first([
                'id',
                'volume',
                'created_at',
            ]),
        ];
    }

}
