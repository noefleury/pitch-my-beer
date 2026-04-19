<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\BeerStatus;
use App\Http\Controllers\BottlingController;
use App\Models\Beer;
use App\Models\Bottle;
use App\Models\Bottling;
use Carbon\Carbon;
use Database\Seeders\BottledBeerSeeder;
use Tests\TestCase;

/**
 * @see BottlingController
 */
class BottlingControllerTest extends TestCase
{

    public function test_list_bottlings()
    {
        $this->seed(BottledBeerSeeder::class);

        $this->get('/api/bottlings')
            ->assertExactJsonStructure([
                0 => [
                    'id',
                    'beer_id',
                    'bottle_id',
                    'guarding_days',
                    'created_at',
                    'beer'   => [
                        'id',
                        'uid',
                        'name',
                        'type',
                        'abv',
                        'is_homemade',
                    ],
                    'bottle' => [
                        'id',
                        'uid',
                        'volume',
                    ],
                ],
            ]);
    }

    public function test_create_bottling()
    {
        // create beer and bottle
        $beer   = Beer::factory()->create(['volume' => 20.0, 'status' => BeerStatus::Fermenting]);
        $bottle = Bottle::factory()->create(['volume' => 750]); // 750 mL

        // the bottle have been bottled and drunk in the past
        Bottling::factory()
            ->for(Beer::factory())
            ->for($bottle)
            ->create(['deleted_at' => Carbon::now()]);

        $this
            ->post(
                '/api/bottlings',
                [
                    'beer_id'    => $beer->getKey(),
                    'bottle_ids' => [$bottle->getKey()],
                ]
            )
            ->assertCreated();

        $this->assertDatabaseHas('bottlings', [
            'beer_id'    => $beer->getKey(),
            'bottle_id'  => $bottle->getKey(),
            'deleted_at' => null,
        ]);
    }

}
