<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |-------------------------------------------------------------------
            | Identité
            |-------------------------------------------------------------------
            */

            $table->string('first_name');
            $table->string('last_name');
            $table->string('sex')->default('H');
            $table->string('birth_name')->nullable();
            $table->date('birth_date');
            $table->string('birth_city')->nullable();

            /*
            |-------------------------------------------------------------------
            | Coordonnées
            |-------------------------------------------------------------------
            */

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('postal_code');
            $table->string('city');

            /*
            |-------------------------------------------------------------------
            | Administratif
            |-------------------------------------------------------------------
            */

            $table->string('licence_number')->nullable();
            $table->string('nationality')->default('FR');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('last_image_rights_authorization_date')->nullable();
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('created_by_id')->nullable()->default(null);
            $table->ulid('updated_by_id')->nullable()->default(null);

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
