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
        'max_bids'
    ];


}
