<?php

namespace App\Services;

use App\Models\Fermenter;

class FermenterService
{

    public function show(Fermenter $fermenter): Fermenter
    {
        return $fermenter;
    }

}
