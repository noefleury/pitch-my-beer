<?php

namespace App\Services;

use App\Enums\KeggedType;
use App\Models\Kegging;

class KeggingService
{

    public function create(float $volume, int $beerId, int $kegId): array
    {
        $kegging = Kegging::query()->create([
            'volume'      => $volume,
            'kegged_id'   => $beerId,
            'kegged_type' => KeggedType::Beer,
            'keg_id'      => $kegId,
        ]);

        return $kegging->only(['id']);
    }

}
