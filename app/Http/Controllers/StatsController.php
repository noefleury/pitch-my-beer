<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use Tests\Feature\Http\Controllers\StatsControllerTest;

/**
 * @see StatsControllerTest
 */
class StatsController extends Controller
{

    public function __construct(private readonly StatsService $statsService)
    {
    }

    public function computeGlobalStats()
    {
        return $this->jsonResponse(
            $this->statsService->computeGlobalStats(),
        );
    }

}
