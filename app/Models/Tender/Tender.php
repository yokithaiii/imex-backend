<?php

namespace App\Models\Tender;

use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tender extends Model
{
    use HasUuids;

    protected $table = 'tenders';

    protected $fillable = [
        'user_id',
        'company_id',
        'region_id',
        'payment_id',
        'category_id',
        'title',
        'description',
        'tender_number',
        'unit_quantity',
        'unit_measure',
        'start_date',
        'end_date',
        'published_at',
        'start_price',
        'max_price',
        'status',
        'notifications_new_members',
        'notifications_offer_changes',
        'recommend_before_tender_end',
        'is_escrow_tender',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'TND-' . date('Y') . '-';
            $maxNumber = self::query()->where('tender_number', 'like', $prefix . '%')
                ->max('tender_number');

            $nextNumber = $maxNumber
                ? (int)str_replace($prefix, '', $maxNumber) + 1
                : 1;

            $model->tender_number = $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(TenderCategory::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(TenderPayment::class, 'payment_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(TenderFile::class, 'tender_id', 'id');
    }

}
