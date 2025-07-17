<?php

namespace App\Models\Company;

use App\Models\Tender\TenderBid;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasUuids;

    protected $table = 'companies';

    protected $fillable = [
        'user_id',
        'type',
        'name_full',
        'name_short',
        'inn',
        'kpp',
        'ogrn',
        'okved',
        'management_name',
        'management_post',
        'address',
        'postal_code',
        'email_corporate',
        'phone_corporate',
        'is_verified',
        'city_id'
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany(TenderBid::class, 'company_id', 'id');
    }
}
