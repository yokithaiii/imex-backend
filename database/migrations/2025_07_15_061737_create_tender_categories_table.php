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
        Schema::create('tender_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Основные поля
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Дополнительные поля
            $table->string('icon')->nullable()->comment('Иконка категории');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0)->comment('Порядок сортировки');

            $table->timestamps();
        });

        Schema::table('tenders', function (Blueprint $table) {
            // Категория
            $table->foreignUuid('category_id')->constrained('tender_categories')->comment('Категория тендера');
        });

        Schema::table('tender_categories', function (Blueprint $table) {
            // Иерархия (для вложенных категорий)
            $table->foreignUuid('parent_id')->nullable()->constrained('tender_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_categories');
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
