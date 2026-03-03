<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\BottleController;
use App\Models\Bottle;
use Tests\TestCase;

/**
 * @see BottleController
 */
class BottleControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->bottle = Bottle::factory()->create();
    }

    public function test_show_bottle()
    {
        $this->get('/api/materials/bottles/'.$this->bottle->getKey())
            ->assertOk()
            ->assertExactJsonStructure([
                'id',
                'uid',
                'volume',
                'created_at',
                'deleted_at',
            ]);
    }

}
