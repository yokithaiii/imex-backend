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
        Schema::create('company_verifies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('company_id')->constrained('companies')->onDelete('cascade');
            $table->enum('status', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending');
            $table->string('power_of_attorney')->nullable();
            $table->string('egrul')->nullable();
            $table->string('passport')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_verifies');
    }
};
