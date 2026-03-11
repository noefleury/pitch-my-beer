<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\StatsController;
use Carbon\Carbon;
use Database\Seeders\Stats\GlobalStatsSeeder;
use Tests\TestCase;

/**
 * @see StatsController
 */
class StatsControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(GlobalStatsSeeder::class);
    }

    public function test_compute_global_stats()
    {
        $this->get('/api/stats')
            ->assertOk()
            ->assertExactJson([
                'beers_drunk'          => 3,
                'beers_bought_drunk'   => 1,
                'beers_homemade_drunk' => 2,
                'liters_drunk'         => 40.0,
                'bottles_drunk'        => 4,
            ]);
    }

}
