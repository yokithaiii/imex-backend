<?php

namespace App\Http\Controllers;

use App\Models\Tariff\Tariff;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        Tariff::query()->updateOrCreate([
            'name' => 'Базовый тариф',
            'price' => 0,
            'max_bids' => 10
        ]);

        Tariff::query()->updateOrCreate([
            'name' => 'Продвинутый тариф',
            'price' => 1000,
            'max_bids' => 25
        ]);
    }
}
