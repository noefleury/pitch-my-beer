<?php

namespace App\Http\Controllers;

use App\Models\Keg;
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

    public function computeKegStats(Keg $keg)
    {
        return $this->jsonResponse(
            $this->statsService->computeKegStats($keg),
        );
    }

}
