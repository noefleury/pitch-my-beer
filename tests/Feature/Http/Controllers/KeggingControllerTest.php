<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\KeggingController;
use App\Models\Beer;
use App\Models\Fermentation;
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
        $this->fermentation = Fermentation::factory()->create(['volume' => 10.0]);
        $this->keg          = Keg::factory()->create(['volume' => 5.0]);
        // already kegged 5L in some keg
        Kegging::factory()->for($this->fermentation, 'kegged')->for(Keg::factory()->create(['volume' => 5.0]))->create(
            ['volume' => 5.0]
        );
    }

    public function test_create_validation_keg_already_kegged()
    {
        Kegging::factory()->for(Beer::factory(), 'kegged')->for($this->keg)->create();

        $this
            ->postJson('/api/keggings', [
                    'volume'          => 4.5,
                    'fermentation_id' => $this->fermentation->getKey(),
                    'keg_id'          => $this->keg->getKey(),
                ]
            )
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['keg' => 'The given keg is already kegged']);
    }

    public function test_create_validation_keg_too_small()
    {
        $this
            ->postJson('/api/keggings', [
                    'volume'          => 5.5,
                    'fermentation_id' => $this->fermentation->getKey(),
                    'keg_id'          => $this->keg->getKey(),
                ]
            )
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['volume' => 'This volume cannot be filled in given keg']);
    }

    public function test_create_validation_not_enough_beer()
    {
        $this
            ->postJson('/api/keggings', [
                    'volume'          => 5.5,
                    'fermentation_id' => $this->fermentation->getKey(),
                    'keg_id'          => $this->keg->getKey(),
                ]
            )
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['volume' => 'This volume cannot be taken from the given fermentation']);
    }

    public function test_create_kegging()
    {
        $this->assertDatabaseCount('keggings', 1);

        $this
            ->post('/api/keggings', [
                    'volume'          => 5.0,
                    'fermentation_id' => $this->fermentation->getKey(),
                    'keg_id'          => $this->keg->getKey(),
                ]
            )
            ->assertCreated();

        $this->assertDatabaseCount('keggings', 2);
        $this->assertDatabaseHas('keggings', [
            'volume'      => 5.0,
            'kegged_id'   => $this->fermentation->getKey(),
            'kegged_type' => 'fermentation',
            'keg_id'      => $this->keg->getKey(),
        ]);
    }


}
