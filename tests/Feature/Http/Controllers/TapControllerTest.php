<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\TapController;
use App\Models\Tap;
use Database\Seeders\LinkedBeerSeeder;
use Tests\TestCase;

/**
 * @see TapController
 */
class TapControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->tap = Tap::factory()->create();
        $this->seed(LinkedBeerSeeder::class);
    }

    public function test_show_tap()
    {
        $this->get('/api/materials/taps/'.$this->tap->getKey())
            ->assertOk()
            ->assertExactJsonStructure([
                'id',
                'uid',
                'name',
                'type',
                'created_at',
                'deleted_at',
            ]);
    }

    public function test_show_on_taps()
    {
        $this->get('/api/on-taps')
            ->assertOk()
            ->assertExactJsonStructure([
                [
                    'id',
                    'beer_id',
                    'beer_type',
                    'beer_name',
                    'gaz_tank_id',
                    'gaz_blend',
                    'tap_id',
                    'tap_type',
                    'date',
                ],
            ]);
    }

}
