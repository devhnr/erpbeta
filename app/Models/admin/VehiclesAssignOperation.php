<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclesAssignOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'vehicle_id',
        'driver_id',
        'driver_mobile_no',
        'no_of_trip',
        'amount',
        'pack_date',
        'time_zone_id',
    ];
}
