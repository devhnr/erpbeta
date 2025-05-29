<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;
    protected $table = 'supervisor_assign';

    public $timestamps = false; // Disable automatic timestamps

    protected $fillable = [
        'enquiry_id',
        'assigned_date',
        'supervisors_id',
        'time_zones',
    ];
}
