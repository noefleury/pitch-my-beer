<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FermenterController;
use App\Models\Fermenter;
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
        $response = $this->get('/api/materials/fermenters/'.$this->fermenter->getKey());

        $response->assertOk()
            ->assertExactJsonStructure([
                'id',
                'name',
                'volume',
                'created_at',
                'deleted_at',
            ]);
    }

}
