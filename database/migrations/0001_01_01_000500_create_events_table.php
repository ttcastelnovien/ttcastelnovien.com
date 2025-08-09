<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->boolean('at_home')->default(false);
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('postal_code');
            $table->string('city');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->string('opponent')->nullable();
            $table->time('check_in_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->json('attachments')->nullable();

            $table->timestamps();
        });

        Schema::create('event_user', function (Blueprint $table) {
            $table->ulid('event_id');
            $table->ulid('user_id');

            $table->primary(['event_id', 'user_id']);
            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('event_group', function (Blueprint $table) {
            $table->ulid('event_id');
            $table->ulid('group_id');

            $table->primary(['event_id', 'group_id']);
            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('event_group');
    }
};
