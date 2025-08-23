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
            |-------------------------------------------------------------------
            | Administratif
            |-------------------------------------------------------------------
            */

            $table->string('licence_type')->default(LicenceType::LOISIR);
            $table->boolean('validated')->default(false);

            /*
            |-------------------------------------------------------------------
            | Autorisations
            |-------------------------------------------------------------------
            */

            $table->boolean('has_image_rights')->nullable();
            $table->boolean('has_exit_authorization')->nullable();
            $table->boolean('has_care_authorization')->nullable();
            $table->boolean('has_transport_authorization')->nullable();
            $table->boolean('has_medical_certificate')->nullable();
            $table->boolean('has_health_declaration')->nullable();
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('person_id');
            $table->ulid('licence_fee_id');
            $table->ulid('season_id');
            $table->ulid('created_by_id')->nullable()->default(null);
            $table->ulid('updated_by_id')->nullable()->default(null);

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
            $table->foreign('licence_fee_id')->references('id')->on('licence_fees')->restrictOnDelete();
            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();

            /*
            |-------------------------------------------------------------------
            | Index
            |-------------------------------------------------------------------
            */

            $table->unique(['person_id', 'season_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licences');
    }
};
