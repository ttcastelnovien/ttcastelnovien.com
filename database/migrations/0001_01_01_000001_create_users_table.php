<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /*
            |-------------------------------------------------------------------
            | Colonnes
            |-------------------------------------------------------------------
            */

            $table->string('username')->unique();
            $table->string('password');
            $table->string('roles');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->text('reset_password_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
