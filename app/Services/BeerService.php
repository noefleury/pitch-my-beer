<?php

namespace App\Services;

use App\Enums\BeerStatus;
use App\Models\Beer;
use App\Models\Keg;
use App\Models\Kegging;
use Illuminate\Database\Eloquent\Collection;

class BeerService
{

    private const int LISTING_LIMIT = 50;
    private const string PREFIX_KEG_AUTO_CREATED_FOR_BEER = 'auto-created-keg-beer-';

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
                ->makeHidden(['kegged_id', 'kegged_type'])
                ->values(),
            'transfers'    => $beer->keggings()
                ->get()
                ->map(fn(Kegging $kegging) => $kegging->transfers(true))
                ->flatten()
                ->map(fn(Kegging $kegging) => $kegging->makeHidden(['kegged_id', 'kegged_type'])),
            'bottlings'    => $beer->bottlings()
                ->get()
                ->load('bottle:id,volume')
                ->sortByDesc('bottle.volume')
                ->sortBy('deleted_at')
                ->values(),
            'comments'     => $beer->comments()->get(),
        ];
    }

    public function create(string $name, string $type, bool $isHomemade, ?float $volume, ?float $abv): array
    {
        $beer = Beer::query()->create([
            'name'   => $name,
            'type'   => $type,
            'volume' => $volume,
            'abv'    => $abv,
            'status' => $isHomemade ? BeerStatus::ToDo : BeerStatus::Ready,
        ]);

        if (!$isHomemade) {
            $this->autoHandleBoughtBeerToKeg($beer);
        }

        return $beer->only(['id', 'uid']);
    }

    /**
     * This method will automatically create keg linked to bought beer then keg beer inside it
     *
     * @param   Beer  $beer
     *
     * @return void
     */
    private function autoHandleBoughtBeerToKeg(Beer $beer): void
    {
        $beer->keggings()->create([
            'volume' => $beer->volume,
            'keg_id' => Keg::query()->create([
                'name'   => self::PREFIX_KEG_AUTO_CREATED_FOR_BEER.$beer->getKey(),
                'volume' => $beer->volume,
            ])->getKey(),
        ]);
    }

}
