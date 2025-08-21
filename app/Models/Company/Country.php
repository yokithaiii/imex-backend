<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasUuids;

    protected $table = 'countries';

    protected $fillable = [
        'name',
        'iso_code'
    ];

    public function regions()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }

}
