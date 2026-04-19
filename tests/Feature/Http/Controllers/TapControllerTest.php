<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\TapController;
use App\Models\Link;
use App\Models\Tap;
use Carbon\Carbon;
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

    public function test_create_tap()
    {
        $this->assertDatabaseCount('taps', 1);

        $response = $this->post(
            '/api/materials/taps',
            [
                'type' => 'picnic',
                'name' => 'dummy',
            ],
        );

        $response
            ->assertCreated()
            ->assertExactJsonStructure(['id', 'uid']);

        $tapId = $response->json('id');

        $this->assertDatabaseCount('taps', 2);
        $this->assertDatabaseHas('taps', ['id' => $tapId, 'type' => 'picnic', 'name' => 'dummy']);
    }

    public function test_show_on_taps()
    {
        $this->seed(LinkedBeerSeeder::class);

        // finished Link -> not listed
        $this->seed(LinkedBeerSeeder::class);
        $olderLink             = Link::query()->oldest()->first();
        $olderLink->deleted_at = Carbon::now();
        $olderLink->save();

        $this->get('/api/on-taps')
            ->assertOk()
            ->assertExactJsonStructure([
                0 => [
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
