<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |-------------------------------------------------------------------
            | Colonnes
            |-------------------------------------------------------------------
            */

            $table->date('date');
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('credit');
            $table->integer('debit');
            $table->boolean('reconciled')->default(false);
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('journal_id');
            $table->ulid('ledger_account_id');
            $table->ulid('client_ledger_account_id')->nullable()->default(null);
            $table->ulid('supplier_ledger_account_id')->nullable()->default(null);
            $table->ulid('supporting_document_id');
            $table->ulid('created_by_id')->nullable()->default(null);
            $table->ulid('updated_by_id')->nullable()->default(null);

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('journal_id')->references('id')->on('journals')->restrictOnDelete();
            $table->foreign('ledger_account_id')->references('id')->on('ledger_accounts')->restrictOnDelete();
            $table->foreign('client_ledger_account_id')->references('id')->on('ledger_accounts')->nullOnDelete();
            $table->foreign('supplier_ledger_account_id')->references('id')->on('ledger_accounts')->nullOnDelete();
            $table->foreign('supporting_document_id')->references('id')->on('supporting_documents')->restrictOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
