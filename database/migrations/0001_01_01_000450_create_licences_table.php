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

            $table->text('firstname')->default('');
            $table->text('lastname')->default('');
            $table->text('type')->default(LicenceType::LOISIR);
            $table->text('category')->default('S');
            $table->integer('amount')->default(0);
            $table->integer('discounted_amount')->default(0);
            $table->boolean('is_minor')->default(false);
            $table->boolean('validated')->default(false);
            $table->text('observations')->nullable()->default(null);
            $table->text('firstname_lastname')->storedAs("firstname || ' ' || upper(lastname)");
            $table->text('lastname_firstname')->storedAs("upper(lastname) || ' ' || firstname");

            /*
            |-------------------------------------------------------------------
            | Autorisations
            |-------------------------------------------------------------------
            */

            $table->boolean('needs_image_rights')->default(false);
            $table->boolean('needs_exit_authorization')->default(false);
            $table->boolean('needs_care_authorization')->default(false);
            $table->boolean('needs_transport_authorization')->default(false);
            $table->boolean('needs_medical_certificate')->default(false);
            $table->boolean('needs_health_declaration')->default(false);

            $table->boolean('has_image_rights')->nullable()->default(null);
            $table->boolean('has_exit_authorization')->nullable()->default(null);
            $table->boolean('has_care_authorization')->nullable()->default(null);
            $table->boolean('has_transport_authorization')->nullable()->default(null);
            $table->boolean('has_medical_certificate')->nullable()->default(null);
            $table->boolean('has_health_declaration')->nullable()->default(null);
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('person_id');
            $table->ulid('licence_fee_id');
            $table->ulid('season_id');
            $table->ulid('invoice_id')->nullable()->default(null);
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
            $table->foreign('invoice_id')->references('id')->on('supporting_documents')->restrictOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by_id')->references('id')->on('users')->nullOnDelete();

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
