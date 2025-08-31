<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |-------------------------------------------------------------------
            | Colonnes
            |-------------------------------------------------------------------
            */

            $table->date('date');
            $table->text('type');
            $table->text('name');
            $table->text('description');
            $table->integer('credit');
            $table->integer('debit');
            $table->text('reference');
            $table->boolean('reconciled')->default(false);
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
            $table->foreign('updated_by_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};
