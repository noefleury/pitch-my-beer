<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FermenterController;
use App\Models\Fermentation;
use App\Models\Fermenter;
use App\Models\Wort;
use Tests\TestCase;

/**
 * @see FermenterController
 */
class FermenterControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->fermenter = Fermenter::factory()->create();
    }

    public function test_show_fermenter()
    {
        $this->get('/api/materials/fermenters/'.$this->fermenter->getKey())
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

    public function test_get_fermenter_relations()
    {
        Fermentation::factory()->for($this->fermenter)->for(Wort::factory())->create();
        $this->get('/api/materials/fermenters/'.$this->fermenter->getKey().'/relations')
            ->assertOk()
            ->assertExactJsonStructure([
                'fermentation' => [
                    'id',
                    'volume',
                    'created_at',
                ],
            ]);
    }

}
