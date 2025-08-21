<?php

namespace App\Models\Tender;

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
        'category_id',
        'payment_id',
        'title',
        'description',
        'tender_number',
        'item_name',
        'unit_of_measure',
        'quantity',
        'price_per_unit',
        'total_amount',
        'delivery_place',
        'notes',
        'status',
        'published_at',
        'submission_deadline',
        'auction_date'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'submission_deadline' => 'datetime',
        'auction_date' => 'datetime',
        'quantity' => 'decimal:2',
        'price_per_unit' => 'decimal:2',
        'total_amount' => 'decimal:2',
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
