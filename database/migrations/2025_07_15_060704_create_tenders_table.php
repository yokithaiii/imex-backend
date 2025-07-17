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
        Schema::create('tenders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Основная информация
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('tender_number')->unique();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');

            // Товары/услуги
            $table->string('item_name')->comment('Наименование товара/услуги');
            $table->string('unit_of_measure')->comment('Единица измерения');
            $table->decimal('quantity', 12, 2)->comment('Количество');
            $table->decimal('price_per_unit', 12, 2)->nullable()->comment('Цена за единицу');
            $table->decimal('total_amount', 15, 2)->nullable()->comment('Общая сумма');

            // Условия
            $table->string('delivery_place')->comment('Место поставки');
            $table->text('notes')->nullable()->comment('Примечание');

            // Статус и даты
            $table->enum('status', [
                'draft',
                'published',
                'in_process',
                'completed',
                'canceled'
            ])->default('draft');
            $table->dateTime('published_at')->nullable()->comment('Дата публикации');
            $table->dateTime('submission_deadline')->comment('Срок подачи заявок');
            $table->dateTime('auction_date')->nullable()->comment('Дата проведения аукциона');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
