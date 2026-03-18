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

    /**
     * Create fermenter
     *
     * @param   float        $volume
     * @param   string|null  $name
     *
     * @return array
     */
    public function create(float $volume, ?string $name = null): array
    {
        $fermenter = Fermenter::query()->create([
            'volume' => $volume,
            'name'   => $name,
        ]);

        return $fermenter->only(['id', 'uid']);
    }
}
