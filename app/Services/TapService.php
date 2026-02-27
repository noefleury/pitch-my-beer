<?php

namespace App\Services;

use App\Models\Tap;

class TapService
{

    public function show(Tap $tap): Tap
    {
        return $tap;
    }

}
