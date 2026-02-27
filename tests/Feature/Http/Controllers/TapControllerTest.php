<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\TapController;
use App\Models\Tap;
use Tests\TestCase;

/**
 * @see TapController
 */
class TapControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->tap = Tap::factory()->create();
    }

    public function test_show_tap()
    {
        $this->get('/api/materials/taps/'.$this->tap->getKey())
            ->assertOk()
            ->assertExactJsonStructure([
                'id',
                'uid',
                'name',
                'type',
                'created_at',
                'deleted_at',
            ]);
    }

}
