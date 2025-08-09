<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->unique();
            $table->string('short_name')->unique();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('halls', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->unique();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('postal_code');
            $table->string('city');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->ulid('club_id');
            $table->timestamps();

            $table->foreign('club_id')->references('id')->on('clubs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clubs');
        Schema::dropIfExists('halls');
    }
};
