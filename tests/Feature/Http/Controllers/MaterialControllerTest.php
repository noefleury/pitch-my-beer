<?php

namespace Feature\Http\Controllers;

use App\Http\Controllers\MaterialController;
use App\Models\Fermenter;
use App\Models\GazTank;
use App\Models\Keg;
use App\Models\Tap;
use Tests\TestCase;

/**
 * @see MaterialController
 */
class MaterialControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        Fermenter::factory()->create(['name' => 'my fermenter']);
        GazTank::factory()->create(['name' => 'my gaz tank']);
        Keg::factory()->create(['name' => 'my keg']);
        Tap::factory()->create(['name' => 'my tap']);
    }

    public function test_listing_materials()
    {
        $response = $this->get('/api/materials');

        $response->assertOk()
            ->assertExactJsonStructure([
                'fermenters' => [
                    '*' => ['id', 'name', 'volume'],
                ],
                'gaz_tanks'  => [
                    '*' => ['id', 'name', 'co2_percent', 'n2_percent'],
                ],
                'kegs'       => [
                    '*' => ['id', 'name', 'volume'],
                ],
                'taps'       => [
                    '*' => ['id', 'name', 'type'],
                ],
            ])
            ->assertJsonCount(1, 'fermenters')
            ->assertJsonCount(1, 'gaz_tanks')
            ->assertJsonCount(1, 'kegs')
            ->assertJsonCount(1, 'taps');
    }

}
