<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('secondname')->nullable();

            $table->string('inn')->nullable();

            $table->string('birthdate')->nullable();
            $table->string('birthplace')->nullable();

            $table->string('passport_number')->nullable();
            $table->string('passport_series')->nullable();
            $table->string('passport_issued_date')->nullable();
            $table->string('passport_issued_who')->nullable();
            $table->timestamp('passport_verified_at')->nullable();

            $table->string('registration_address')->nullable();

            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('phone')->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('password')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
