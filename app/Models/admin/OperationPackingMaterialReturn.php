<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationPackingMaterialReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'material_id',
        'godown_id',
        'allocate',
        'total_cost',
    ];
}
