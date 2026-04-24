<?php

namespace App\Services;

use App\Models\GazTank;
use Carbon\Carbon;

class GazTankService
{

    public function show(GazTank $gazTank): GazTank
    {
        return $gazTank;
    }

    public function create(float $volume, int $co2Percent, ?string $name = null)
    {
        $gazTank = GazTank::query()->create([
            'name'        => $name,
            'volume'      => $volume,
            'co2_percent' => $co2Percent,
        ]);

        return $gazTank->only(['id', 'uid']);
    }

    public function delete(int $gazTankId): int
    {
        return GazTank::query()
            ->where('id', $gazTankId)
            ->update(['deleted_at' => Carbon::now()]);
    }
}
