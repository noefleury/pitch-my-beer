<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\StatsController;
use App\Models\Beer;
use App\Models\Keg;
use App\Models\Kegging;
use Carbon\Carbon;
use Database\Seeders\Stats\GlobalStatsSeeder;
use Tests\TestCase;

/**
 * @see StatsController
 */
class StatsControllerTest extends TestCase
{

    public function test_compute_global_stats()
    {
        $this->seed(GlobalStatsSeeder::class);

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


    public function test_compute_keg_stats()
    {
        $keg = Keg::factory()->create();
        Kegging::factory()->for(Beer::factory())->for($keg)->create(['volume' => 12.5]);
        Kegging::factory()->for(Beer::factory())->for($keg)->create(
            [
                'volume'     => 19.0,
                'deleted_at' => Carbon::parse('2026-03-16 18:49'),
            ]
        );
        $this->get('/api/stats/kegs/'.$keg->getKey())
            ->assertOk()
            ->assertExactJson([
                'kegged_count'  => 2,
                'kegged_liters' => 31.5,
            ]);
    }


}
