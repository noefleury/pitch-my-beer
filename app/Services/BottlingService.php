<?php

namespace App\Services;

use App\Models\Bottling;

class BottlingService
{

    public function create(int $beerId, array $bottleIds): true
    {
        foreach ($bottleIds as $bottleId) {
            Bottling::query()->create([
                'beer_id'   => $beerId,
                'bottle_id' => $bottleId,
            ]);
        }

        return true;
    }

}
