<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeltsListeningMaterial extends Model
{
    protected $fillable = [
        'material_type_id',
        'title',
        'audio_file',
        'transcript_en',
        'transcript_id',
        'answer_key',
    ];

    protected $casts = [
        'material_type_id' => 'integer',
    ];
}
