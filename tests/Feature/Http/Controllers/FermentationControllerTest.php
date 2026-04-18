<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FermentationController;
use App\Models\Fermentation;
use App\Models\Fermenter;
use App\Models\Wort;
use Tests\TestCase;

/**
 * @see FermentationController
 */
class FermentationControllerTest extends TestCase
{

    public function test_create_fermentation()
    {
        $this->markTestIncomplete('todo');
    }

    public function test_update_gravity_of_fermentation()
    {
        $fermentation = Fermentation::factory()->for(Wort::factory())->for(Fermenter::factory())->create();

        $this
            ->patch(
                '/api/fermentations/'.$fermentation->getKey().'/gravity',
                [
                    'gravity' => 1.12,
                ]
            )
            ->assertNoContent();

        $this->assertDatabaseHas(
            'fermentation_gravities',
            ['fermentation_id' => $fermentation->getKey(), 'value' => 1.12],
        );
    }

}
