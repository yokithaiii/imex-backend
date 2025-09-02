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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')->constrained('users')->onDelete('set null');
            $table->foreignUuid('tariff_id')->constrained('tariffs')->onDelete('set null');

            $table->date('start_date');
            $table->date('end_date');

            $table->boolean('is_active')->default(false);
            $table->enum('status', [
                'pending',
                'completed',
                'cancelled',
                'failed'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
