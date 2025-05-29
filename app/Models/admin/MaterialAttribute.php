<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
                            'material_id',
                            'godown_id',
                            'stock',
                            'price',
                        ];
    

    public function attributes()
    {
        return $this->hasMany(Godown::class, 'godown_id');
    }
}
