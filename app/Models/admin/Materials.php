<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function attributes()
    {
        return $this->hasMany(MaterialAttribute::class, 'material_id');
    }
}
