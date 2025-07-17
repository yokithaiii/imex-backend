<?php

namespace App\Models\User;

use App\Models\Company\Company;
use App\Models\Tender\Tender;
use App\Models\Tender\TenderBid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, HasApiTokens;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function verifyCode()
    {
        return $this->hasOne(UserVerifyCode::class, 'user_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'user_id', 'id');
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class, 'user_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany(TenderBid::class, 'user_id', 'id');
    }
}
