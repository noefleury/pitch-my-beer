<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Controller extends \Illuminate\Routing\Controller
{

    protected function jsonResponse(array|Model|Collection $data, int $httpCode = 200)
    {
        return response()->json($data, $httpCode);
    }
}
