<?php

use App\Enums\BeerStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('worts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at');
        });

        Schema::create('kegs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('volume');
            $table->dateTime('created_at');
            $table->softDeletes();
        });

        Schema::create('fermenters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('volume');
            $table->dateTime('created_at');
            $table->softDeletes();
        });

        Schema::create('fermentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wort_id')->constrained('worts', 'id');
            $table->foreignId('fermenter_id');
            $table->string('fermenter_type', 30);
            $table->float('volume');
            $table->dateTime('created_at');
        });

        Schema::create('fermentation_gravities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fermentation_id')->constrained('fermentations', 'id');
            $table->float('value');
            $table->dateTime('created_at');
        });

        Schema::create('beers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type', 50)->index();
            $table->float('volume')->nullable();
            $table->foreignId('fermentation_id')->nullable()->constrained('fermentations', 'id');
            $table->string('status', 50)->default(BeerStatus::ToDo);
            $table->dateTime('created_at');
            $table->unique('fermentation_id');
        });

        Schema::create('keggings', function (Blueprint $table) {
            $table->id();
            $table->float('volume');
            $table->foreignId('beer_id')->constrained('beers', 'id');
            $table->foreignId('keg_id')->constrained('kegs', 'id');
            $table->dateTime('created_at');
        });

        Schema::create('gaz_tanks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('volume');
            $table->tinyInteger('co2_percent');
            $table->tinyInteger('n2_percent');
            $table->dateTime('created_at');
            $table->softDeletes();
        });

        Schema::create('taps', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type', 50);
            $table->dateTime('created_at');
            $table->softDeletes();
        });

        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegging_id')->constrained('keggings', 'id');
            $table->foreignId('gaz_tank_id')->constrained('gaz_tanks', 'id');
            $table->foreignId('tap_id')->constrained('taps', 'id');
            $table->dateTime('created_at');
            $table->softDeletes();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id');
            $table->string('entity_type', 30);
            $table->text('value');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('links');
        Schema::dropIfExists('taps');
        Schema::dropIfExists('gaz_tanks');
        Schema::dropIfExists('keggings');
        Schema::dropIfExists('beers');
        Schema::dropIfExists('fermentation_gravities');
        Schema::dropIfExists('fermentations');
        Schema::dropIfExists('fermenters');
        Schema::dropIfExists('kegs');
        Schema::dropIfExists('worts');
    }
};
