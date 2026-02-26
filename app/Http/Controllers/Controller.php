<?php

namespace App\Http\Controllers;

abstract class Controller extends \Illuminate\Routing\Controller
{

    protected function jsonResponse(array $data, int $httpCode = 200)
    {
        return response()->json($data, $httpCode);
    }
}
