<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ledger_accounts', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |-------------------------------------------------------------------
            | Colonnes
            |-------------------------------------------------------------------
            */

            $table->text('name');
            $table->text('code');
            $table->integer('balance')->default(0);
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('parent_id')->nullable()->default(null);
            $table->ulid('default_journal_id')->nullable()->default(null);
            $table->ulid('created_by_id')->nullable()->default(null);
            $table->ulid('updated_by_id')->nullable()->default(null);

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('default_journal_id')->references('id')->on('journals')->nullOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('ledger_accounts', function (Blueprint $table) {
            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('parent_id')->references('id')->on('ledger_accounts')->nullOnDelete();
        });

        Schema::table('people', function (Blueprint $table) {
            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('client_ledger_account_id')->references('id')->on('ledger_accounts')->restrictOnDelete();
        });

        Schema::table('suppliers', function (Blueprint $table) {
            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('supplier_ledger_account_id')->references('id')->on('ledger_accounts')->restrictOnDelete();
            $table->foreign('default_ledger_account_id')->references('id')->on('ledger_accounts')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ledger_accounts');
    }
};
