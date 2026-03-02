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
        Schema::create('bottles', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('volume')->comment('milliliters');
            $table->dateTime('created_at');
            $table->softDeletes();
        });
        Schema::create('bottlings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beer_id')->constrained('beers', 'id');
            $table->foreignId('bottle_id')->constrained('bottles', 'id');
            $table->dateTime('created_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bottlings');
        Schema::dropIfExists('bottles');
    }
};
