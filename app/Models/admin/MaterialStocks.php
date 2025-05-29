<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialStocks extends Model
{
    use HasFactory;

    protected $fillable = ['material_id','godown_id','stock'];
}
