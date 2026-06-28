<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeTestCertificate extends Model
{
    protected $fillable = [
        'program_id',
        'test_type',
        'background_image',
        'description',
        'text_color',
        'template_config',
        'is_active',
        'signature_name',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    protected $casts = [
        'template_config' => 'array',
        'is_active' => 'boolean',
    ];
}
