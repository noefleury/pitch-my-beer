<?php

use App\Enums\KeggedType;
use App\Models\Bottling;
use App\Models\Kegging;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // bottlings
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('bottlings', function (Blueprint $table) {
            $table->foreignId('fermentation_id')->after('beer_id')->constrained('fermentations', 'id');
        });
        Bottling::query()
            ->select('bottlings.id', 'beers.fermentation_id as beer_fermentation_id')
            ->join('beers', 'beer_id', 'beers.id')
            ->each(function (Bottling $bottling) {
                $bottling->fermentation_id = $bottling->getAttribute('beer_fermentation_id');
                $bottling->save();
            });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::table('bottlings', function (Blueprint $table) {
            $table->dropForeign(['beer_id']);
            $table->dropColumn('beer_id');
        });

        // keggings
        Kegging::query()
            ->select('keggings.id', 'beers.fermentation_id as beer_fermentation_id')
            ->join('beers', 'keggings.kegged_id', 'beers.id')
            ->where('kegged_type', KeggedType::Beer)
            ->each(function (Kegging $kegging) {
                $beerFermentationId = $kegging->getAttribute('beer_fermentation_id');

                // update kegging when homemade beer according to linked fermentation id
                if (filled($beerFermentationId)) {
                    $kegging->kegged_type = KeggedType::Fermentation;
                    $kegging->kegged_id   = $beerFermentationId;
                    $kegging->save();
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // no rollback for this migration
    }
};
