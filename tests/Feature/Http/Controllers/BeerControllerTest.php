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

    private ?Beer $beer = null;

    private function seedBaseData(): void
    {
        $fermentation = Fermentation::factory()->for(Wort::factory())->for(Fermenter::factory())->create();
        $this->beer   = Beer::factory()->for($fermentation)->create();
        Comment::factory()->for($this->beer, 'entity')->create();
    }

    public function test_list_beers()
    {
        $this->seedBaseData();
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
        $this->seedBaseData();
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
        $this->seedBaseData();
        $kegging = Kegging::factory()->for($this->beer, 'kegged')->for(Keg::factory())->create();
        Kegging::factory()->for($kegging, 'kegged')->for(Keg::factory())->create();  // transfer
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
                    0 => [
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
                    0 => [
                        'id',
                        'volume',
                        'keg_id',
                        'created_at',
                        'deleted_at',
                        'keg'    => [
                            'id',
                            'uid',
                        ],
                        'kegged' => [
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
                ],
                'bottlings'    => [
                    0 => [
                        'id',
                        'beer_id',
                        'bottle_id',
                        'created_at',
                        'deleted_at',
                        'guarding_days',
                        'bottle' => [
                            'id',
                            'uid',
                            'volume',
                        ],
                    ],
                ],
                'comments'     => [
                    0 => [
                        'id',
                        'value',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function test_create_homemade_beer()
    {
        $fermenter = Fermenter::factory()->create(['volume' => 30.0]);

        $this->assertDatabaseEmpty('beers');
        $this->assertDatabaseEmpty('worts');
        $this->assertDatabaseEmpty('fermentations');

        $response = $this
            ->post('/api/beers', [
                'name'           => 'dummy beer',
                'type'           => 'lager',
                'is_homemade'    => true,
                'volume'         => 19.5,
                'fermenter_id'   => $fermenter->getKey(),
                'fermenter_type' => 'fermenter',
                'og_gravity'     => 1.045,
            ])
            ->assertCreated();

        $response
            ->assertCreated()
            ->assertExactJsonStructure(['id', 'uid']);

        $beerId = $response->json('id');

        $this->assertDatabaseCount('beers', 1);
        $this->assertDatabaseCount('worts', 1);
        $this->assertDatabaseCount('fermentations', 1);

        $wort         = Wort::query()->first();
        $fermentation = Fermentation::query()->first();

        $this->assertDatabaseHas('beers', [
            'id'              => $beerId,
            'name'            => 'dummy beer',
            'type'            => 'lager',
            'volume'          => 19.5,
            'fermentation_id' => $fermentation->getKey(),
            'abv'             => null,
            'status'          => 'todo',
        ]);

        $this->assertDatabaseHas('fermentations', [
            'id'             => $fermentation->getKey(),
            'wort_id'        => $wort->getKey(),
            'fermenter_id'   => $fermenter->getKey(),
            'fermenter_type' => 'fermenter',
            'volume'         => 19.5,
        ]);

        // assert no auto-kegging as bought beer
        $this->assertDatabaseEmpty('kegs');
        $this->assertDatabaseEmpty('keggings');
    }

    public function test_create_bought_beer()
    {
        $this->assertDatabaseEmpty('beers');
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

        $this->assertDatabaseCount('beers', 1);
        $this->assertDatabaseHas('beers', ['id' => $beerId, 'status' => 'ready']);

        // assert auto-kegging as bought beer
        $this->assertDatabaseCount('kegs', 1);
        $this->assertDatabaseHas('kegs', ['name' => "auto-created-keg-beer-$beerId", 'volume' => 20.0]);
        $this->assertDatabaseCount('keggings', 1);
        $this->assertDatabaseHas('keggings', ['volume' => 20.0, 'keg_id' => Keg::query()->first()->getKey()]);

        // assert no wort & fermentation
        $this->assertDatabaseEmpty('worts');
        $this->assertDatabaseEmpty('fermentations');
    }

}
