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
        Schema::create('tender_bids', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('tender_id')->constrained('tenders')->onDelete('set null');

            $table->foreignUuid('user_id')->constrained('users')->onDelete('set null');
            $table->foreignUuid('company_id')->constrained('companies')->onDelete('set null');

            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'won',
                'lose'
            ])->default('pending');

            $table->decimal('price', 14, 2)->default(0);
            $table->date('date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_bids');
    }
};
