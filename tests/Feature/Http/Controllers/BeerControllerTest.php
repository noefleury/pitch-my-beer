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
        Kegging::factory()->for($this->beer)->for(Keg::factory())->create();
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
                        'beer_id',
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

}
