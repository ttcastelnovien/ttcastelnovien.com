<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */

            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */

            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Colonnes
            |--------------------------------------------------------------------------
            */

            $table->string('type');
            $table->ulidMorphs('notifiable');
            $table->json('data');

            /*
            |--------------------------------------------------------------------------
            | Historique
            |--------------------------------------------------------------------------
            */

            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('notifications');
    }
};
