<?php

namespace App\Services;

use App\Enums\FermenterType;
use App\Models\Fermentation;
use App\Models\FermentationGravity;
use App\Models\Wort;
use Illuminate\Database\Eloquent\Collection;

class FermentationService
{

    /**
     * List current fermentations
     *
     * @note flag fermentation as current by taking only fermentation without kegging or bottling
     * @note maybe could take Beer with fermenting status
     *
     * @return Collection<Fermentation>
     */
    public function list(): Collection
    {
        return Fermentation::query()
            ->with('beer:id,fermentation_id,name,type,created_at')
            ->whereDoesntHave('keggings')
            ->whereDoesntHave('bottlings')
            ->get()
            ->append('fermenting_days');
    }

    public function create(int $fermenterId, FermenterType $fermenterType, float $volume): Fermentation
    {
        return Fermentation::query()->create([
            'wort_id'        => Wort::query()->create()->getKey(),
            'fermenter_id'   => $fermenterId,
            'fermenter_type' => $fermenterType,
            'volume'         => $volume,
        ]);
    }

    public function updateGravity(Fermentation $fermentation, float $gravity): FermentationGravity
    {
        return $fermentation->gravities()->create([
            'value' => $gravity,
        ]);
    }

}
