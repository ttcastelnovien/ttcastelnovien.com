<?php

use App\Enums\LicenceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('licences');
    }
};
