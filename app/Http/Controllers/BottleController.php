<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use App\Services\BottleService;
use Tests\Feature\Http\Controllers\BottleControllerTest;

/**
 * @see BottleControllerTest
 */
class BottleController extends Controller
{

    public function __construct(private readonly BottleService $bottleService)
    {
    }

    public function show(Bottle $bottle)
    {
        return $this->jsonResponse(
            $this->bottleService->show($bottle),
        );
    }
}
