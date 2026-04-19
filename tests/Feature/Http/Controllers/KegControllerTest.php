<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\KegController;
use App\Models\Beer;
use App\Models\Keg;
use App\Models\Kegging;
use Tests\TestCase;

/**
 * @see KegController
 */
class KegControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->keg = Keg::factory()->create();
    }

    public function test_show_keg()
    {
        $this->get('/api/materials/kegs/'.$this->keg->getKey())
            ->assertOk()
            ->assertExactJsonStructure([
                'id',
                'uid',
                'name',
                'volume',
                'created_at',
                'deleted_at',
            ]);
    }

    public function test_show_keg_relations()
    {
        Kegging::factory()->for(Beer::factory(), 'kegged')->for($this->keg)->create();
        $this->get('/api/materials/kegs/'.$this->keg->getKey().'/relations')
            ->assertOk()
            ->assertExactJsonStructure([
                'kegging'     => [
                    'volume',
                    'created_at',
                ],
                'kegged_beer' => [
                    'id',
                    'uid',
                    'name',
                    'type',
                    'status',
                    'is_homemade',
                ],
                'comments'    => [
                    '*' => [
                        'id',
                        'value',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function test_create_keg()
    {
        $this->assertDatabaseCount('kegs', 1);

        $response = $this->post(
            '/api/materials/kegs',
            [
                'volume' => 18.5,
                'name'   => 'dummy',
            ],
        );

        $response
            ->assertCreated()
            ->assertExactJsonStructure(['id', 'uid']);

        $kegId = $response->json('id');

        $this->assertDatabaseCount('kegs', 2);
        $this->assertDatabaseHas('kegs', ['id' => $kegId, 'volume' => 18.5, 'name' => 'dummy']);
    }

}
