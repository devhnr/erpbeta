<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
                    'enquiry_id',
                    'invoice_date',
                    'payment_by',
                    'trn_no',
                    'place_of_service',
                    'service_date',
                    'service_code',
                    'ref_no',
                    'service_description',
                    'ship_address',
                    'is_insurance',
                    'vat_charge'
                ];
}
