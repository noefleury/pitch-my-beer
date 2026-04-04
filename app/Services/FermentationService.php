<?php

namespace App\Services;

use App\Enums\FermenterType;
use App\Models\Fermentation;
use App\Models\Wort;

class FermentationService
{

    public function create(int $fermenterId, FermenterType $fermenterType, float $volume): Fermentation
    {
        return Fermentation::query()->create([
            'wort_id'        => Wort::query()->create()->getKey(),
            'fermenter_id'   => $fermenterId,
            'fermenter_type' => $fermenterType,
            'volume'         => $volume,
        ]);
    }

}
