<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->index();
            $table->string('color')->default('#000000');
            $table->timestamps();
        });

        Schema::create('group_person', function (Blueprint $table) {
            $table->ulid('group_id');
            $table->ulid('person_id');
            $table->timestamps();
            $table->primary(['group_id', 'person_id']);
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();
            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_person');
    }
};
