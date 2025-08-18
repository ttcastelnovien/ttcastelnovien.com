<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->string('username')->unique();
            $table->string('password');
            $table->string('roles');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->ulid('person_id');

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Contraintes
            |--------------------------------------------------------------------------
            */

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->string('token');
            $table->timestamp('created_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->ulid('user_id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Contraintes
            |--------------------------------------------------------------------------
            */

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
