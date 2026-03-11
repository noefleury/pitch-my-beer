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
        Schema::table('gaz_tanks', function (Blueprint $table) {
            $table->dropColumn('n2_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaz_tanks', function (Blueprint $table) {
            $table->tinyInteger('n2_percent')->after('co2_percent');
        });
    }
};
