<?php

namespace App\Services;

use App\Models\Keg;

class KegService
{

    public function show(Keg $keg): Keg
    {
        return $keg;
    }

}
