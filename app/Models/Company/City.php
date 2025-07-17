<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasUuids;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'fias_id',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
