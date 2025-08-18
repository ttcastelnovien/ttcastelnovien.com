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
            $table->date('last_image_rights_authorization_date')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */
            $table->timestamps();
        });

        Schema::create('licences', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Administratif
            |--------------------------------------------------------------------------
            */

            $table->string('licence_type')->default(LicenceType::LOISIR);
            $table->boolean('validated')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Autorisations
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_image_rights')->nullable();
            $table->boolean('has_exit_authorization')->nullable();
            $table->boolean('has_care_authorization')->nullable();
            $table->boolean('has_transport_authorization')->nullable();
            $table->boolean('has_medical_certificate')->nullable();
            $table->boolean('has_health_declaration')->nullable();

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
            | Contraintes
            |--------------------------------------------------------------------------
            */

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->unique(['person_id', 'season_id']);
        });

        Schema::create('child_parent', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->ulid('parent_id');
            $table->ulid('child_id');

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

            $table->foreign('parent_id')->references('id')->on('people')->cascadeOnDelete();
            $table->foreign('child_id')->references('id')->on('people')->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->primary(['parent_id', 'child_id']);
            $table->unique(['parent_id', 'child_id']);
        });

        Schema::create('medical_certificates', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->string('doctor_name');
            $table->string('doctor_identifier');
            $table->date('date');
            $table->string('file')->nullable();

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
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
        Schema::dropIfExists('licences');
        Schema::dropIfExists('child_parent');
        Schema::dropIfExists('medical_certificates');
    }
};
