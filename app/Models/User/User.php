<?php

namespace App\Models\User;

use App\Models\Company\Company;
use App\Models\Tariff\Tariff;
use App\Models\Tender\Tender;
use App\Models\Tender\TenderBid;
use Carbon\Carbon;
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
        'balance'
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $date = Carbon::parse($model->created_at);
            $userSubscription = UserSubscription::query()->create([
                'user_id' => $model->id,
                'tariff_id' => Tariff::query()->where('price', 0)->pluck('id')->first(),
                'start_date' => $date->format('Y-m-d'),
                'end_date' => $date->addYear()->format('Y-m-d'),
                'is_active' => true,
                'status' => 'completed'
            ]);
            UserTransaction::query()->create([
                'user_id' => $model->id,
                'user_subscription_id' => $userSubscription->id,
                'transaction_id' => 'automatically_created',
                'amount' => 0,
                'date' => $date->format('Y-m-d'),
            ]);
        });
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

    public function subscription()
    {
        return $this->hasOne(UserSubscription::class, 'user_id', 'id');
    }

    public function tariff()
    {
        return $this->subscription->tariff();
    }

}
