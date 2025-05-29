<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationPackingMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'material_id',
        'godown_id',
        'allocate',
        'price_cost',
    ];
}
