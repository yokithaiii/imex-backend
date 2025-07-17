<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TenderContact extends Model
{
    use HasUuids;

    protected $table = 'tender_contacts';

    protected $fillable = [
        'tender_id',
        'fullname',
        'phone',
        'email'
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id', 'id');
    }
}
