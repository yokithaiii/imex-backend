<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TenderFile extends Model
{
    use HasUuids;

    protected $table = 'tender_files';

    protected $fillable = [
        'tender_id',
        'url',
        'type'
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id', 'id');
    }
}
