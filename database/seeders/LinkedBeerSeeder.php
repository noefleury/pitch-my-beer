<?php

namespace Database\Seeders;

use App\Enums\BeerStatus;
use App\Models\Beer;
use App\Models\Comment;
use App\Models\Fermentation;
use App\Models\FermentationGravity;
use App\Models\Fermenter;
use App\Models\GazTank;
use App\Models\Keg;
use App\Models\Kegging;
use App\Models\Link;
use App\Models\Tap;
use App\Models\Wort;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkedBeerSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create equipments
        $fermenter = Fermenter::factory()->create();
        $gazTank   = GazTank::factory()->create();
        $keg       = Keg::factory()->create();
        $tap       = Tap::factory()->create();

        // create fermentation + beer
        $wort         = Wort::factory()->create();
        $fermentation = Fermentation::factory()->for($wort)->for($fermenter)->create();
        FermentationGravity::factory()->for($fermentation)->create();
        FermentationGravity::factory()->for($fermentation)->create(['value' => 1.000]);
        $beer = Beer::factory()->for($fermentation)->create(['status' => BeerStatus::Linked]);
        Comment::factory()->for($beer, 'entity')->create();

        // put it in keg
        $kegging = Kegging::factory()->for($beer)->for($keg)->create();

        // link it
        Link::factory()->for($kegging)->for($gazTank)->for($tap)->create();
    }
}
