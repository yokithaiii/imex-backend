<?php

namespace Database\Seeders;

use App\Models\Tariff\Tariff;
use App\Models\Tender\TenderCategory;
use App\Models\Tender\TenderPayment;
use App\Models\User\User;
use App\Models\User\UserSubscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tariff::factory()->create([
            'name' => 'Бесплатный тариф',
            'type' => 'free',
            'price' => 0,
            'max_bids' => 5,
            'has_infinity_bids' => false,
            'max_products' => 5,
            'has_infinity_products' => false,
            'escrow_type' => 'paid',
            'analytics_type' => 'base',
            'has_ads_marketing' => false,
            'has_personal_manager' => false,
        ]);

        Tariff::factory()->create([
            'name' => 'Базовый тариф',
            'type' => 'base',
            'price' => 5000,
            'max_bids' => 20,
            'has_infinity_bids' => false,
            'max_products' => 20,
            'has_infinity_products' => false,
            'escrow_type' => 'paid',
            'analytics_type' => 'base',
            'has_ads_marketing' => false,
            'has_personal_manager' => false,
        ]);

        Tariff::factory()->create([
            'name' => 'Продвинутый тариф',
            'type' => 'pro',
            'price' => 19900,
            'max_bids' => 50,
            'has_infinity_bids' => false,
            'max_products' => 50,
            'has_infinity_products' => false,
            'escrow_type' => 'free',
            'analytics_type' => 'full',
            'has_ads_marketing' => true,
            'has_personal_manager' => false,
        ]);

        Tariff::factory()->create([
            'name' => 'Премиум тариф',
            'type' => 'premium',
            'price' => 200000,
            'max_bids' => 1000,
            'has_infinity_bids' => true,
            'max_products' => 1000,
            'has_infinity_products' => true,
            'escrow_type' => 'free',
            'analytics_type' => 'full',
            'has_ads_marketing' => true,
            'has_personal_manager' => true,
        ]);

        User::factory()->create([
            'firstname' => 'Spartak',
            'lastname' => 'Vasilev',
            'email' => 'spartakvasilev1999@gmail.com',
            'password' => 'qweqweqwe'
        ]);

        TenderCategory::factory()->create([
            'name' => 'Техника',
            'description' => 'Цифровая техника',
            'icon' => null,
            'is_active' => true,
            'parent_id' => null,
        ]);

        TenderPayment::factory()->create([
            'title' => 'escrow'
        ]);

    }
}
