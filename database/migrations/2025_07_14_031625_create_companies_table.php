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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');

            // Тип компании: юр. лицо или физ. лицо (например, ИП)
            $table->enum('type', ['legal', 'individual'])->default('legal');

            // Названия
            $table->string('name_full');
            $table->string('name_short')->nullable();

            // Основные идентификаторы
            $table->string('inn', 12)->index();    // ИНН: до 12 символов
            $table->string('kpp', 9)->nullable();  // КПП: только для юрлиц
            $table->string('ogrn', 15)->nullable(); // ОГРН или ОГРНИП

            // ОКВЭД — можно как строку хранить, если только один
            $table->string('okved')->nullable();

            // Руководитель
            $table->string('management_name')->nullable();
            $table->string('management_post')->nullable();

            // Адреса
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();

            // Контакты
            $table->string('email_corporate')->nullable();
            $table->string('phone_corporate')->nullable();

            // Подтверждение
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
