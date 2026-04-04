<?php

namespace App\Services;

use App\Enums\BeerStatus;
use App\Enums\FermenterType;
use App\Models\Beer;
use App\Models\Keg;
use App\Models\Kegging;
use App\Models\Wort;
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
                ->map(function (Kegging $kegging) {
                    $kegging->kegged->makeHidden(['id', 'kegged_id', 'kegged_type']);

                    return $kegging->makeHidden(['kegged_id', 'kegged_type']);
                }),
            'bottlings'    => $beer->bottlings()
                ->get()
                ->load('bottle:id,volume')
                ->sortByDesc('bottle.volume')
                ->sortBy('deleted_at')
                ->values(),
            'comments'     => $beer->comments()->get(),
        ];
    }

    public function createHomemade(
        string $name,
        string $type,
        float $volume,
        FermenterType $fermenterType,
        int $fermenterId,
        float $ogGravity,
    ): Beer {
        $fermentation = app(FermentationService::class)->create($fermenterId, $fermenterType, $volume);
        $fermentation->gravities()->create(['value' => $ogGravity]);

        return Beer::query()->create([
            'name'            => $name,
            'type'            => $type,
            'volume'          => $volume,
            'fermentation_id' => $fermentation->getKey(),
            'status'          => BeerStatus::ToDo,
        ]);
    }

    public function createBought(string $name, string $type, float $volume, float $abv): Beer
    {
        $beer = Beer::query()->create([
            'name'   => $name,
            'type'   => $type,
            'volume' => $volume,
            'abv'    => $abv,
            'status' => BeerStatus::Ready,
        ]);

        // automatically create keg linked to bought beer then keg beer inside it
        $beer->keggings()->create([
            'volume' => $beer->volume,
            'keg_id' => Keg::query()->create([
                'name'   => self::PREFIX_KEG_AUTO_CREATED_FOR_BEER.$beer->getKey(),
                'volume' => $beer->volume,
            ])->getKey(),
        ]);

        return $beer;
    }

}
