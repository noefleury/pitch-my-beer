<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

abstract class Controller extends \Illuminate\Routing\Controller
{

    protected function jsonResponse(array|Model $data, int $httpCode = 200)
    {
        return response()->json($data, $httpCode);
    }
}
