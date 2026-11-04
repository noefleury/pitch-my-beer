<?php

namespace App\Services;

use App\Enums\KeggedType;
use App\Models\Kegging;

class KeggingService
{

    public function create(float $volume, int $fermentationId, int $kegId): array
    {
        $kegging = Kegging::query()->create([
            'volume'      => $volume,
            'kegged_id'   => $fermentationId,
            'kegged_type' => KeggedType::Fermentation,
            'keg_id'      => $kegId,
        ]);

        return $kegging->only(['id']);
    }

}
