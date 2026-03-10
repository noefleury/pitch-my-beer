<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kegs', function (Blueprint $table) {
            $table->decimal('volume', 4, 2)->change();
        });
        Schema::table('fermenters', function (Blueprint $table) {
            $table->decimal('volume', 4, 2)->change();
        });
        Schema::table('fermentations', function (Blueprint $table) {
            $table->decimal('volume', 4, 2)->change();
        });
        Schema::table('fermentation_gravities', function (Blueprint $table) {
            $table->decimal('value', 4, 3)->change();
        });
        Schema::table('beers', function (Blueprint $table) {
            $table->decimal('volume', 4, 2)->nullable()->change();
        });
        Schema::table('keggings', function (Blueprint $table) {
            $table->decimal('volume', 4, 2)->change();
        });
        Schema::table('gaz_tanks', function (Blueprint $table) {
            $table->decimal('volume', 4, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaz_tanks', function (Blueprint $table) {
            $table->float('volume')->change();
        });
        Schema::table('keggings', function (Blueprint $table) {
            $table->float('volume')->change();
        });
        Schema::table('beers', function (Blueprint $table) {
            $table->float('volume')->nullable()->change();
        });
        Schema::table('fermentation_gravities', function (Blueprint $table) {
            $table->float('value')->change();
        });
        Schema::table('fermentations', function (Blueprint $table) {
            $table->float('volume')->change();
        });
        Schema::table('fermenters', function (Blueprint $table) {
            $table->float('volume')->change();
        });
        Schema::table('kegs', function (Blueprint $table) {
            $table->float('volume')->change();
        });
    }
};
