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
     * @return array{fermentation: array{id: int, volume: float, created_at: Carbon}}
     */
    public function getRelationsData(Fermenter $fermenter): array
    {
        return [
            'fermentation' => $fermenter->fermentations()->latest('id')->first([
                'id',
                'volume',
                'created_at',
            ]),
        ];
    }

}
