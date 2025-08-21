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
        Schema::create('tracked_mails', function (Blueprint $table): void {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->text('status');
            $table->text('object');
            $table->text('message_id');
            $table->text('recipient');

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracked_mails');
    }
};
