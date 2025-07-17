<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderPayment extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tender_payments';

    protected $fillable = [
        'title'
    ];
}
