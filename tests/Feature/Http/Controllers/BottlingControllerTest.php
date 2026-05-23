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

        // drunk -> not listed
        Bottling::factory()->for(Beer::factory())->for(Bottle::factory())->create(['deleted_at' => Carbon::now()]);

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

    public function test_delete_bottling()
    {
        Carbon::setTestNow('2026-05-23 10:03');

        $this->seed(BottledBeerSeeder::class);
        $bottlingId = Bottling::query()->first()->getKey();

        $this->assertDatabaseCount('bottlings', 1);

        $this->delete('/api/bottlings/'.$bottlingId)->assertNoContent();

        $this->assertDatabaseCount('bottlings', 1);
        $this->assertDatabaseHas('bottlings', ['id' => $bottlingId, 'deleted_at' => '2026-05-23 10:03']);
    }

    public function test_delete_bottling_already_consumed()
    {
        Carbon::setTestNow('2026-05-23 10:18');

        $bottlingDrunk = Bottling::factory()->for(Beer::factory())->for(Bottle::factory())->create(
            ['deleted_at' => '2026-05-23 10:17']
        );

        $this->assertDatabaseCount('bottlings', 1);

        $this->delete('/api/bottlings/'.$bottlingDrunk->getKey())->assertNotFound();

        $this->assertDatabaseCount('bottlings', 1);

        // ensure already drunk bottling was not impacted
        $this->assertDatabaseHas('bottlings', ['id' => $bottlingDrunk->getKey(), 'deleted_at' => '2026-05-23 10:17']);
    }

    public function test_delete_bottling_not_exist()
    {
        $this->delete('/api/bottlings/123')->assertNotFound();
    }

}
