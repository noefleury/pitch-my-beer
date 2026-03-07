<?php

namespace Tests\Feature\Models;

use App\Enums\BeerStatus;
use App\Models\Beer;
use App\Models\Fermentation;
use App\Models\FermentationGravity;
use App\Models\Fermenter;
use App\Models\Wort;
use Tests\TestCase;

/**
 * @see Beer
 */
class BeerTest extends TestCase
{

    private Beer $beer;

    protected function setUp(): void
    {
        parent::setUp();
        $fermentation = Fermentation::factory()->for(Wort::factory())->for(Fermenter::factory())->create();
        FermentationGravity::factory()->for($fermentation)->create(['value' => 1.05]);
        FermentationGravity::factory()->for($fermentation)->create(['value' => 1.01]);
        $this->beer = Beer::factory()->for($fermentation)->create(['abv' => null, 'status' => BeerStatus::Ready]);
    }

    public function test_show_abv_from_db_when_not_null()
    {
        $this->beer->abv = 4.5;
        $this->beer->save();

        $this->assertSame(4.5, $this->beer->fresh()->abv);
    }

    public function test_show_abv_null_when_not_in_db_and_no_fermentation_finished()
    {
        $this->beer->status = BeerStatus::Fermenting;
        $this->beer->save();

        $this->assertNull($this->beer->fresh()->abv);
    }

    public function test_show_abv_null_when_not_in_db_and_not_enough_fermentation_gravity_data()
    {
        FermentationGravity::query()->latest()->delete();
        $this->assertNull($this->beer->fresh()->abv);
    }

    public function test_show_abv_computed()
    {
        $this->assertEqualsWithDelta(5.34, $this->beer->fresh()->abv, 0.01);
    }

}

