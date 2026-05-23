<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\BottleController;
use App\Models\Beer;
use App\Models\Bottle;
use App\Models\Bottling;
use Carbon\Carbon;
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

    public function test_show_bottle_relations()
    {
        Bottling::factory()->for(Beer::factory())->for($this->bottle)->create();
        $this->get('/api/materials/bottles/'.$this->bottle->getKey().'/relations')
            ->assertOk()
            ->assertExactJsonStructure([
                'bottling'     => [
                    'id',
                    'guarding_days',
                    'created_at',
                ],
                'bottled_beer' => [
                    'id',
                    'uid',
                    'name',
                    'type',
                    'status',
                    'is_homemade',
                ],
                'comments'     => [
                    '*' => [
                        'id',
                        'value',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function test_consume_bottle()
    {
        Carbon::setTestNow('2026-05-23 10:13');

        // drunk one (same bottle)
        $drunkBottlingId = Bottling::factory()->for(Beer::factory())->for($this->bottle)->create(
            ['deleted_at' => '2026-05-23 10:10']
        )->getKey();

        // to consume (same bottle)
        $toConsumeBottlingId = Bottling::factory()->for(Beer::factory())->for($this->bottle)->create()->getKey();

        $this->assertDatabaseCount('bottlings', 2);

        $this->patch('/api/materials/bottles/'.$this->bottle->getKey().'/consume')
            ->assertNoContent();

        $this->assertDatabaseCount('bottlings', 2);
        $this->assertDatabaseHas('bottlings', ['id' => $toConsumeBottlingId, 'deleted_at' => '2026-05-23 10:13']);

        // ensure already drunk bottling was not impacted
        $this->assertDatabaseHas('bottlings', ['id' => $drunkBottlingId, 'deleted_at' => '2026-05-23 10:10']);
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
