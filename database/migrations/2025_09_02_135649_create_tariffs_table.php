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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->enum('type', [
                'free',
                'base',
                'pro',
                'premium'
            ])->default('free');
            $table->integer('price');

            $table->integer('max_bids')->default(20);
            $table->boolean('has_infinity_bids')->default(false); // Тариф Премиум, безлимит

            $table->integer('max_products')->default(20);
            $table->boolean('has_infinity_products')->default(false); // Тариф Премиум, безлимит

            $table->enum('escrow_type', ['paid', 'free'])->default('paid');
            $table->enum('analytics_type', ['base', 'full'])->default('base');

            $table->boolean('has_ads_marketing')->default(false);
            $table->boolean('has_personal_manager')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
