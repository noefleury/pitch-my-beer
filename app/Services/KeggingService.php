<?php

namespace App\Services;

use App\Models\Kegging;

class KeggingService
{

    public function create(float $volume, int $beerId, int $kegId): array
    {
        $kegging = Kegging::query()->create([
            'volume'  => $volume,
            'beer_id' => $beerId,
            'keg_id'  => $kegId,
        ]);

        return $kegging->only(['id']);
    }

}
