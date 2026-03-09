<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeTestCertificate extends Model
{
    protected $fillable = [
        'test_type',
        'background_image',
        'description',
        'text_color',
        'is_active',
    ];
}
