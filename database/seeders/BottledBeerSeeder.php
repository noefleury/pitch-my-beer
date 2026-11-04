<?php

namespace Database\Seeders;

use App\Enums\BeerStatus;
use App\Models\Beer;
use App\Models\Bottle;
use App\Models\Bottling;
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

class BottledBeerSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create equipment
        $fermenter = Fermenter::factory()->create();
        $bottle    = Bottle::factory()->create();

        // create wort + fermentation + beer
        $wort         = Wort::factory()->create();
        $fermentation = Fermentation::factory()->for($wort)->for($fermenter)->create();
        Beer::factory()->for($fermentation)->create();
        FermentationGravity::factory()->for($fermentation)->create();
        FermentationGravity::factory()->for($fermentation)->create(['value' => 1.000]);

        // put it in bottle
        Bottling::factory()->for($fermentation)->for($bottle)->create();
    }
}
