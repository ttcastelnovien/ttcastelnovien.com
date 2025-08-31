<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supporting_documents', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |-------------------------------------------------------------------
            | Colonnes
            |-------------------------------------------------------------------
            */

            $table->text('reference');
            $table->text('type');
            $table->integer('total_amount');
            $table->date('date');
            $table->date('due_date');
            $table->date('paid_at')->nullable()->default(null);
            $table->text('payment_method')->nullable()->default(null);
            $table->text('payment_reference')->nullable()->default(null);
            $table->text('payment_status')->nullable()->default(null);
            $table->text('observations')->nullable()->default(null);
            $table->text('file');
            $table->timestamps();

            /*
            |-------------------------------------------------------------------
            | Relations
            |-------------------------------------------------------------------
            */

            $table->ulid('journal_id');
            $table->ulid('person_id')->nullable()->default(null);
            $table->ulid('supplier_id')->nullable()->default(null);
            $table->ulid('created_by_id')->nullable()->default(null);
            $table->ulid('updated_by_id')->nullable()->default(null);

            /*
            |-------------------------------------------------------------------
            | Contraintes
            |-------------------------------------------------------------------
            */

            $table->foreign('journal_id')->references('id')->on('journals')->restrictOnDelete();
            $table->foreign('person_id')->references('id')->on('people')->nullOnDelete();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supporting_documents');
    }
};
