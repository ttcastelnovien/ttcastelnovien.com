<?php

use App\Enums\LicenceType;
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
            |--------------------------------------------------------------------------
            | Identité
            |--------------------------------------------------------------------------
            */

            $table->string('first_name');
            $table->string('last_name');
            $table->string('sex')->default('H');
            $table->string('birth_name')->nullable();
            $table->date('birth_date');
            $table->string('birth_city')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Coordonnées
            |--------------------------------------------------------------------------
            */

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('postal_code');
            $table->string('city');

            /*
            |--------------------------------------------------------------------------
            | Administratif
            |--------------------------------------------------------------------------
            */

            $table->string('licence_number')->nullable();
            $table->string('nationality')->default('FR');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */
            $table->timestamps();
        });

        Schema::create('licences', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Administratif
            |--------------------------------------------------------------------------
            */

            $table->string('licence_type')->default(LicenceType::LOISIR);

            /*
            |--------------------------------------------------------------------------
            | Obligations
            |--------------------------------------------------------------------------
            */

            $table->boolean('needs_image_rights')->default(false);
            $table->boolean('needs_exit_authorization')->default(false);
            $table->boolean('needs_care_authorization')->default(false);
            $table->boolean('needs_transport_authorization')->default(false);
            $table->boolean('needs_medical_certificate')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Autorisations
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_image_rights')->nullable();
            $table->boolean('has_exit_authorization')->nullable();
            $table->boolean('has_care_authorization')->nullable();
            $table->boolean('has_transport_authorization')->nullable();
            $table->boolean('has_medical_certificate')->default(false);
            $table->boolean('has_health_declaration')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Médical
            |--------------------------------------------------------------------------
            */

            $table->string('doctor_name')->nullable();
            $table->string('doctor_identifier')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->ulid('person_id');
            $table->ulid('season_id');

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Clés
            |--------------------------------------------------------------------------
            */

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->primary(['person_id', 'season_id']);
            $table->unique(['person_id', 'season_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
        Schema::dropIfExists('licences');
    }
};
