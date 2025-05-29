<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenPower extends Model
{
    use HasFactory;

    protected $table = 'men_power_assign';

    public $timestamps = false; // Disable automatic timestamps

    protected $fillable = [
        'enquiry_id',
        'assigned_date',
        'men_power_id',
        'time_zones',
    ];
}
