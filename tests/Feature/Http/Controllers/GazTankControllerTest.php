<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FermenterController;
use App\Http\Controllers\GazTankController;
use App\Models\Fermenter;
use App\Models\GazTank;
use Tests\TestCase;

/**
 * @see GazTankController
 */
class GazTankControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->gazTank = GazTank::factory()->create();
    }

    public function test_show_gaz_tank()
    {
        $this->get('/api/materials/gaz-tanks/'.$this->gazTank->getKey())
            ->assertOk()
            ->assertExactJsonStructure([
                'id',
                'uid',
                'name',
                'volume',
                'co2_percent',
                'n2_percent',
                'created_at',
                'deleted_at',
            ]);
    }

    public function test_create_gaz_tank()
    {
        $this->assertDatabaseCount('gaz_tanks', 1);

        $response = $this->post(
            '/api/materials/gaz-tanks',
            [
                'volume'      => 4.5,
                'co2_percent' => 70,
                'name'        => 'dummy',
            ],
        );

        $response
            ->assertCreated()
            ->assertExactJsonStructure(['id', 'uid']);

        $gazTankId = $response->json('id');

        $this->assertDatabaseCount('gaz_tanks', 2);
        $this->assertDatabaseHas(
            'gaz_tanks',
            ['id' => $gazTankId, 'volume' => 4.5, 'co2_percent' => 70, 'name' => 'dummy'],
        );
    }

}
