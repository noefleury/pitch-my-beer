<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Controller extends \Illuminate\Routing\Controller
{

    protected function jsonResponse(array|Model|Collection $data, int $httpCode = 200)
    {
        return response()->json($data, $httpCode);
    }
}
