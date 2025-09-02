<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasUuids;

    protected $table = 'user_transactions';

    protected $fillable = [
        'user_id',
        'user_subscription_id',
        'transaction_id',
        'amount',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userSubscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id', 'id');
    }

}
