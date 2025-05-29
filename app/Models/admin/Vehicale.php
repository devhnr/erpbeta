<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicale extends Model
{
    use HasFactory;

   protected $fillable = [
    'vehicle_name',
    'vehicle_number',
    'time_zone_id'
   ];

    public function attributes()
    {
        return $this->hasMany(VehicalAttribute::class, 'vehicle_id');
    }

    public function vehiclesAssign()
    {
        return $this->hasMany(VehiclesAssignOperation::class, 'vehicle_id');
    }
   
}
