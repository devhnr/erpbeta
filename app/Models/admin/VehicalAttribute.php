<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicalAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'driver_name',
        'driver_email',
        'driver_mobile_no'
    ];
}
