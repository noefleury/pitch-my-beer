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

    public function test_create_bottle()
    {
        $this->assertDatabaseCount('bottles', 1);

        $this
            ->post(
                '/api/materials/bottles',
                [
                    'volume' => 123,
                ],
            )
            ->assertCreated()
            ->assertJsonIsArray()
            ->assertJsonCount(1)
            ->assertExactJsonStructure(['*' => ['id', 'uid']]);

        $this->assertDatabaseCount('bottles', 2);
        $this->assertDatabaseHas('bottles', ['volume' => 123]);
    }

    public function test_create_multiple_bottle()
    {
        $this->assertDatabaseCount('bottles', 1);

        $this
            ->post(
                '/api/materials/bottles',
                [
                    'volume' => 220,
                    'count'  => 3,
                ],
            )
            ->assertCreated()
            ->assertJsonIsArray()
            ->assertJsonCount(3)
            ->assertExactJsonStructure(['*' => ['id', 'uid']]);

        $this->assertDatabaseCount('bottles', 4);
        $this->assertDatabaseHas('bottles', ['volume' => 220]);
    }

}
