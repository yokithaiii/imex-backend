<?php

namespace App\Models\Tariff;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'tariffs';

    protected $fillable = [
        'name',
        'type',
        'price',
        'max_bids',
        'has_infinity_bids',
        'max_products',
        'has_infinity_products',
        'escrow_type',
        'analytics_type',
        'has_ads_marketing',
        'has_personal_manager',
    ];


}
