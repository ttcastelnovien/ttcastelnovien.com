<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('person_id');

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
        });
    }

    public function down(): void {}
};
