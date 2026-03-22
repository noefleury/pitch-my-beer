<?php

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
        Schema::table('keggings', function (Blueprint $table) {
            $table->dropForeign(['beer_id']);
            $table->renameColumn('beer_id', 'kegged_id');
            $table->string('kegged_type')->after('kegged_id');
        });
        Kegging::withTrashed()->update(['kegged_type' => 'beer']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keggings', function (Blueprint $table) {
            $table->dropColumn('kegged_type');
            $table->renameColumn('kegged_id', 'beer_id');
            $table->foreign('beer_id')->references('id')->on('beers');
        });
    }
};
