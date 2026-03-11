<?php

namespace App\Services;

use App\Models\Keg;

class KegService
{

    public function show(Keg $keg): Keg
    {
        return $keg;
    }

    public function create(float $volume, ?string $name = null)
    {
        $tap = Keg::query()->create([
            'name'   => $name,
            'volume' => $volume,
        ]);

        return $tap->only(['id', 'uid']);
    }

}
