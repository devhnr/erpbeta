<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAccountDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'account_type',
        'swift_code',
        'iban',
    ];
}
