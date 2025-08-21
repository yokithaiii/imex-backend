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
        'region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
