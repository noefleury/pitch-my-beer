<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\MaterialController;
use App\Models\Bottle;
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
        Bottle::factory()->create();
    }

    public function test_listing_materials()
    {
        $this->get('/api/materials')
            ->assertOk()
            ->assertExactJsonStructure([
                'fermenters' => [
                    '*' => ['id', 'uid', 'name', 'volume'],
                ],
                'gaz_tanks'  => [
                    '*' => ['id', 'uid', 'name', 'volume', 'co2_percent', 'n2_percent'],
                ],
                'kegs'       => [
                    '*' => ['id', 'uid', 'name', 'volume'],
                ],
                'taps'       => [
                    '*' => ['id', 'uid', 'name', 'type'],
                ],
                'bottles'    => [
                    '*' => ['id', 'uid', 'volume'],
                ],
            ])
            ->assertJsonCount(1, 'fermenters')
            ->assertJsonCount(1, 'gaz_tanks')
            ->assertJsonCount(1, 'kegs')
            ->assertJsonCount(1, 'taps')
            ->assertJsonCount(1, 'bottles');
    }

}
