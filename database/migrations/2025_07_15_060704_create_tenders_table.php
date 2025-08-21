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

            // Компания
            $table->foreignUuid('company_id')
                ->constrained('companies')
                ->onDelete('set null');

            $table->boolean('notifications_new_members')->default(false);
            $table->boolean('notifications_offer_changes')->default(false);

            // Основная информация
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('tender_number')->unique();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Адрес
            $table->foreignUuid('region_id')
                ->constrained('regions')
                ->onDelete('cascade');

            // Товары/услуги
            $table->integer('unit_quantity')->default(0);
            $table->string('unit_measure')->default('Штуки');

            // Даты
            $table->dateTime('published_at')->nullable()->comment('Дата публикации');
            $table->date('start_date');
            $table->date('end_date');

            // Цены
            $table->decimal('start_price', 14, 2)->default(0);
            $table->decimal('max_price', 14, 2)->default(0);

            // Тумблеры
            $table->boolean('recommend_before_tender_end')->default(false);
            $table->boolean('is_escrow_tender')->default(false);

            // Статус и даты
            $table->enum('status', [
                'draft',
                'published',
                'in_process',
                'completed',
                'canceled'
            ])->default('draft');

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
