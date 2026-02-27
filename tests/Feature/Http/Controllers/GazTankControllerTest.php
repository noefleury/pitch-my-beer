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

}
