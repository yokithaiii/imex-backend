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
        // User::factory(10)->create();

        $user = User::factory()->create([
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

        Tariff::factory()->create([
            'name' => 'Базовый тариф',
            'price' => 0,
            'max_bids' => 10
        ]);

        Tariff::factory()->create([
            'name' => 'Продвинутый тариф',
            'price' => 1000,
            'max_bids' => 25
        ]);

    }
}
