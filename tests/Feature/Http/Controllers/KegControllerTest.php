<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\KegController;
use App\Models\Keg;
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

}
