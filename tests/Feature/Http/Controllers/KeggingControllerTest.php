<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\BeerStatus;
use App\Http\Controllers\KeggingController;
use App\Models\Beer;
use App\Models\Keg;
use App\Models\Kegging;
use Tests\TestCase;

/**
 * @see KeggingController
 */
class KeggingControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->beer = Beer::factory()->create(['volume' => 10.0, 'status' => BeerStatus::Fermenting]);
        $this->keg  = Keg::factory()->create(['volume' => 5.0]);
        // already kegged 5L in some keg
        Kegging::factory()->for($this->beer, 'kegged')->for(Keg::factory()->create(['volume' => 5.0]))->create(
            ['volume' => 5.0]
        );
    }

    public function test_create_validation_beer_already_consumed()
    {
        $this->beer->status = BeerStatus::Consumed;
        $this->beer->save();

        $this
            ->postJson('/api/keggings', [
                    'volume'  => 4.5,
                    'beer_id' => $this->beer->getKey(),
                    'keg_id'  => $this->keg->getKey(),
                ]
            )
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['beer' => 'The given beer is already consumed']);
    }

    public function test_create_validation_keg_already_kegged()
    {
        Kegging::factory()->for(Beer::factory(), 'kegged')->for($this->keg)->create();

        $this
            ->postJson('/api/keggings', [
                    'volume'  => 4.5,
                    'beer_id' => $this->beer->getKey(),
                    'keg_id'  => $this->keg->getKey(),
                ]
            )
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['keg' => 'The given keg is already kegged']);
    }

    public function test_create_validation_keg_too_small()
    {
        $this
            ->postJson('/api/keggings', [
                    'volume'  => 5.5,
                    'beer_id' => $this->beer->getKey(),
                    'keg_id'  => $this->keg->getKey(),
                ]
            )
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['volume' => 'This volume cannot be filled in given keg']);
    }

    public function test_create_validation_not_enough_beer()
    {
        $this
            ->postJson('/api/keggings', [
                    'volume'  => 5.5,
                    'beer_id' => $this->beer->getKey(),
                    'keg_id'  => $this->keg->getKey(),
                ]
            )
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['volume' => 'This volume cannot be taken from the given beer']);
    }

    public function test_create_kegging()
    {
        $this->assertDatabaseCount('keggings', 1);

        $this
            ->post('/api/keggings', [
                    'volume'  => 5.0,
                    'beer_id' => $this->beer->getKey(),
                    'keg_id'  => $this->keg->getKey(),
                ]
            )
            ->assertCreated();

        $this->assertDatabaseCount('keggings', 2);
        $this->assertDatabaseHas('keggings', [
            'volume'      => 5.0,
            'kegged_id'   => $this->beer->getKey(),
            'kegged_type' => 'beer',
            'keg_id'      => $this->keg->getKey(),
        ]);
    }


}
