<?php

namespace App\Models\Tender;

use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TenderBid extends Model
{
    use HasUuids;

    protected $table = 'tender_bids';

    protected $fillable = [
        'tender_id',
        'user_id',
        'company_id',
        'status',
        'price',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
