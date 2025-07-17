<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CompanyVerify extends Model
{
    use HasUuids;

    protected $table = 'company_verifies';

    protected $fillable = [
        'company_id',
        'status',
        'power_of_attorney',
        'egrul',
        'passport'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
