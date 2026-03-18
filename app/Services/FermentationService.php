<?php

namespace App\Services;

use App\Enums\FermenterType;
use App\Models\Fermentation;

class FermentationService
{

    public function create(int $wortId, int $fermenterId, FermenterType $fermenterType, float $volume): true
    {
        Fermentation::query()->create([
            'wort_id'        => $wortId,
            'fermenter_id'   => $fermenterId,
            'fermenter_type' => $fermenterType,
            'volume'         => $volume,
        ]);

        return true;
    }

}
