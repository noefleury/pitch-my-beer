<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\BeerController;
use App\Models\Beer;
use App\Models\Bottle;
use App\Models\Bottling;
use App\Models\Comment;
use App\Models\Fermentation;
use App\Models\Fermenter;
use App\Models\Keg;
use App\Models\Kegging;
use App\Models\Wort;
use Tests\TestCase;

/**
 * @see BeerController
 */
class BeerControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $fermentation = Fermentation::factory()->for(Wort::factory())->for(Fermenter::factory())->create();
        $this->beer   = Beer::factory()->for($fermentation)->create();
        Comment::factory()->for($this->beer, 'entity')->create();
    }

    public function test_list_beers()
    {
        $this->get('/api/beers')
            ->assertOk()
            ->assertExactJsonStructure([
                '*' => [
                    'id',
                    'uid',
                    'name',
                    'type',
                    'volume',
                    'fermentation_id',
                    'abv',
                    'status',
                    'is_homemade',
                    'created_at',
                ],
            ]);
    }

    public function test_show_beer()
    {
        $this->get('/api/beers/'.$this->beer->getKey())
            ->assertOk()
            ->assertExactJsonStructure([
                'id',
                'uid',
                'name',
                'type',
                'volume',
                'fermentation_id',
                'abv',
                'status',
                'is_homemade',
                'created_at',
            ]);
    }

    public function test_show_beer_relations()
    {
        Kegging::factory()->for($this->beer, 'kegged')->for(Keg::factory())->create();
        Bottling::factory()->for($this->beer)->for(Bottle::factory())->create();
        $this->get('/api/beers/'.$this->beer->getKey().'/relations')
            ->assertOk()
            ->assertExactJsonStructure([
                'fermentation' => [
                    'id',
                    'wort_id',
                    'fermenter_id',
                    'fermenter_type',
                    'volume',
                    'created_at',
                ],
                'keggings'     => [
                    '*' => [
                        'id',
                        'volume',
                        'keg_id',
                        'created_at',
                        'deleted_at',
                        'keg' => [
                            'id',
                            'uid',
                        ],
                    ],
                ],
                'transfers'    => [
                    '*' => [
                        'id',
                        'volume',
                        'keg_id',
                        'created_at',
                        'deleted_at',
                        'keg' => [
                            'id',
                            'uid',
                        ],
                    ],
                ],
                'bottlings'    => [
                    '*' => [
                        'id',
                        'beer_id',
                        'bottle_id',
                        'created_at',
                        'deleted_at',
                        'bottle' => [
                            'id',
                            'uid',
                            'volume',
                        ],
                    ],
                ],
                'comments'     => [
                    '*' => [
                        'value',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function test_create_homemade_beer()
    {
        $this->assertDatabaseCount('beers', 1);

        $response = $this
            ->post('/api/beers', [
                'name'        => 'dummy beer',
                'type'        => 'lager',
                'is_homemade' => true,
            ])
            ->assertCreated();

        $response
            ->assertCreated()
            ->assertExactJsonStructure(['id', 'uid']);

        $beerId = $response->json('id');

        $this->assertDatabaseCount('beers', 2);
        $this->assertDatabaseHas('beers', ['id' => $beerId, 'status' => 'todo']);

        // assert no auto-kegging as bought beer
        $this->assertDatabaseEmpty('kegs');
        $this->assertDatabaseEmpty('keggings');
    }

    public function test_create_bought_beer()
    {
        $this->assertDatabaseCount('beers', 1);
        $this->assertDatabaseEmpty('kegs');
        $this->assertDatabaseEmpty('keggings');

        $response = $this
            ->post('/api/beers', [
                'name'        => 'dummy beer',
                'type'        => 'lager',
                'is_homemade' => false,
                'volume'      => 20.0,
                'abv'         => 4.5,
            ])
            ->assertCreated();

        $response
            ->assertCreated()
            ->assertExactJsonStructure(['id', 'uid']);

        $beerId = $response->json('id');

        $this->assertDatabaseCount('beers', 2);
        $this->assertDatabaseHas('beers', ['id' => $beerId, 'status' => 'ready']);

        // assert auto-kegging as bought beer
        $this->assertDatabaseCount('kegs', 1);
        $this->assertDatabaseHas('kegs', ['name' => "auto-created-keg-beer-$beerId", 'volume' => 20.0]);
        $this->assertDatabaseCount('keggings', 1);
        $this->assertDatabaseHas('keggings', ['volume' => 20.0, 'keg_id' => Keg::query()->first()->getKey()]);
    }

}
