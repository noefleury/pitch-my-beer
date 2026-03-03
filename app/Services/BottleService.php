<?php

namespace App\Services;

use App\Models\Bottle;

class BottleService
{

    public function show(Bottle $bottle): Bottle
    {
        return $bottle;
    }

}
