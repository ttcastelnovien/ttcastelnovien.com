<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_group', function (Blueprint $table) {
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('event_id');
            $table->ulid('group_id');

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();

            /*
            |-------------------------------------------------------------------
            | Index
            |-------------------------------------------------------------------
            */

            $table->primary(['event_id', 'group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_group');
    }
};
