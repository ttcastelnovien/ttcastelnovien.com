<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |-------------------------------------------------------------------
            | Présentation
            |-------------------------------------------------------------------
            */

            $table->string('title')->index();
            $table->text('description')->nullable();

            /*
            |-------------------------------------------------------------------
            | Lieu
            |-------------------------------------------------------------------
            */

            $table->boolean('at_home')->default(false);
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            /*
            |-------------------------------------------------------------------
            | Dates et heures
            |-------------------------------------------------------------------
            */

            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->time('check_in_time')->nullable();
            $table->time('departure_time')->nullable();

            /*
            |-------------------------------------------------------------------
            | Metadata
            |-------------------------------------------------------------------
            */

            $table->string('opponent')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('season_id');
            $table->ulid('created_by_id')->nullable()->default(null);
            $table->ulid('updated_by_id')->nullable()->default(null);

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
