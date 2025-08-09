<?php

use App\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default(UserRole::USER);
            $table->boolean('is_active')->default(true);
            $table->ulid('person_id');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->ulid('user_id')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
