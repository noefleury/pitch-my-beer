<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\GazTankController;
use App\Models\GazTank;
use Carbon\Carbon;
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

    public function test_delete_gaz_tank()
    {
        Carbon::setTestNow('2026-04-24 21:29');

        $this->delete('/api/materials/gaz-tanks/'.$this->gazTank->getKey())
            ->assertNoContent();

        $this->assertDatabaseHas('gaz_tanks', [
            'id'         => $this->gazTank->getKey(),
            'deleted_at' => '2026-04-24 21:29:00',
        ]);
    }

}
