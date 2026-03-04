<?php

namespace App\Services;

use App\Enums\FermenterType;
use App\Models\Beer;
use App\Models\Bottling;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class BeerService
{

    private const int LISTING_LIMIT = 50;

    /**
     * @return Collection<Beer>
     */
    public function list(): Collection
    {
        return Beer::query()
            ->latest('id')
            ->limit(self::LISTING_LIMIT)
            ->get();
    }

    public function get(Beer $beer): Beer
    {
        return $beer;
    }

    /**
     * Get relations data
     *
     * @param   Beer  $beer
     *
     * @return array{fermentation: array{id: int, wort_id: int, fermentation_id: int, fermenter_type: FermenterType, volume: float, created_at: Carbon}, keggings: array{array{id: int, volume:: float, beer_id: int, keg_id: int, created_at: Carbon}}, bottlings: array{array{id: int, beer_id: int, bottle_id: int, created_at: Carbon, deleted_at: Carbon}}}
     */
    public function getRelationsData(Beer $beer): array
    {
        return [
            'fermentation' => $beer->fermentation()->first(),
            'keggings'     => $beer->keggings()->get(),
            'bottlings'    => $beer->bottlings()->get()->load('bottle:id,volume')->each(
                fn(Bottling $bottling) => $bottling->bottle->withoutAppends()->makeHidden(['id']),
            ),
        ];
    }

}
