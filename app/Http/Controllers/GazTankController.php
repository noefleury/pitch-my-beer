<?php

namespace App\Http\Controllers;

use App\Models\GazTank;
use App\Services\GazTankService;
use Tests\Feature\Http\Controllers\GazTankControllerTest;

/**
 * @see GazTankControllerTest
 */
class GazTankController extends Controller
{

    public function __construct(private readonly GazTankService $gazTankService)
    {
    }

    public function show(GazTank $gazTank)
    {
        return $this->jsonResponse(
            $this->gazTankService->show($gazTank),
        );
    }
}
