<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserVerifyCode extends Model
{
    use HasUuids;

    protected $table = 'user_verify_codes';

    protected $fillable = [
        'code',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
