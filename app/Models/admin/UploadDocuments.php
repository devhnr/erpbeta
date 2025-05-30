<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadDocuments extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'title',
        'document',
    ];
}
