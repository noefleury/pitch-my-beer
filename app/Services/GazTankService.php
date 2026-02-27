<?php

namespace App\Services;

use App\Models\GazTank;

class GazTankService
{

    public function show(GazTank $gazTank): GazTank
    {
        return $gazTank;
    }

}
