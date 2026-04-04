<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\BottlingController;
use Database\Seeders\BottledBeerSeeder;
use Tests\TestCase;

/**
 * @see BottlingController
 */
class BottlingControllerTest extends TestCase
{

    public function test_list_bottlings()
    {
        $this->seed(BottledBeerSeeder::class);

        $this->get('/api/bottlings')
            ->assertExactJsonStructure([
                0 => [
                    'id',
                    'beer_id',
                    'bottle_id',
                    'guarding_days',
                    'created_at',
                    'beer'   => [
                        'id',
                        'uid',
                        'name',
                        'type',
                        'abv',
                        'is_homemade',
                    ],
                    'bottle' => [
                        'id',
                        'uid',
                        'volume',
                    ],
                ],
            ]);
    }

    public function test_create_bottling()
    {
        $this->markTestIncomplete('todo');
    }

}
