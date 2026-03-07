<?php

namespace App\Services;

use App\Enums\FermenterType;
use App\Models\Beer;
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
     * @return array
     */
    public function getRelationsData(Beer $beer): array
    {
        return [
            'fermentation' => $beer->fermentation()->first(),
            'keggings'     => $beer->keggings()
                ->get()
                ->load('keg:id')
                ->sortByDesc('volume')
                ->sortBy('deleted_at')
                ->values(),
            'bottlings'    => $beer->bottlings()
                ->get()
                ->load('bottle:id,volume')
                ->sortByDesc('bottle.volume')
                ->sortBy('deleted_at')
                ->values(),
            'comments'     => $beer->comments()->get(),
        ];
    }

}
