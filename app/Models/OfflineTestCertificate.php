<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineTestCertificate extends Model
{
    protected $fillable = [
        'test_type',
        'is_active',
        'text_color',
        'background_image',
        'template_config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'template_config' => 'array',
    ];
}
