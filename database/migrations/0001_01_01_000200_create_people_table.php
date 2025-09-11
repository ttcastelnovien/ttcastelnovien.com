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

            $table->text('firstname');
            $table->text('lastname');
            $table->text('sex')->default('H');
            $table->text('birth_name')->nullable();
            $table->date('birth_date');
            $table->text('birth_city')->nullable();
            $table->text('firstname_lastname')->storedAs("firstname || ' ' || upper(lastname)");
            $table->text('lastname_firstname')->storedAs("upper(lastname) || ' ' || firstname");

            /*
            |-------------------------------------------------------------------
            | Coordonnées
            |-------------------------------------------------------------------
            */

            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('address_line_1');
            $table->text('address_line_2')->nullable();
            $table->text('address_line_3')->nullable();
            $table->text('postal_code');
            $table->text('city');

            /*
            |-------------------------------------------------------------------
            | Administratif
            |-------------------------------------------------------------------
            */

            $table->text('licence_number')->nullable();
            $table->text('nationality')->default('FR');
            $table->text('father_name')->nullable();
            $table->text('mother_name')->nullable();
            $table->date('last_image_rights_authorization_date')->nullable();
            $table->text('clothing_size')->nullable()->default(null);
            $table->text('pants_size')->nullable()->default(null);
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('client_ledger_account_id');
            $table->ulid('created_by_id')->nullable()->default(null);
            $table->ulid('updated_by_id')->nullable()->default(null);

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
