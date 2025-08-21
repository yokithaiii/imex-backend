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
        Schema::create('tender_files', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('tender_id')->constrained('tenders')->cascadeOnDelete();
            $table->string('url');
            $table->enum('type', [
                'img',
                'file',
            ])->default('img');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_files');
    }
};
