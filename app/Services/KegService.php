<?php

namespace App\Services;

use App\Models\Beer;
use App\Models\Keg;

class KegService
{

    public function show(Keg $keg): Keg
    {
        return $keg;
    }

    /**
     * Get relations data
     *
     * @param   Keg  $keg
     *
     * @return array
     */
    public function getRelationsData(Keg $keg): array
    {
        return [
            'kegging'     => $keg->keggings()
                ->first([
                    'volume',
                    'created_at',
                ]),
            'kegged_beer' => (object)$keg->keggings()->first()?->beer()->only([
                'id',
                'uid',
                'name',
                'type',
                'status',
                'is_homemade',
            ]),
            'comments'    => $keg->comments()->get(),
        ];
    }

    public function create(float $volume, ?string $name = null)
    {
        $tap = Keg::query()->create([
            'name'   => $name,
            'volume' => $volume,
        ]);

        return $tap->only(['id', 'uid']);
    }

}
