<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->text('clothing_size')->nullable()->default(null);
            $table->text('pants_size')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
