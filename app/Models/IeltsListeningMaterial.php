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
        'answer_key_practice_1',
        'answer_key_practice_2',
        'answer_key_practice_3',
        'answer_key_practice_4',
        'answer_key_practice_5',
        'answer_key_practice_6',
        'answer_key_practice_7',
        'answer_key_practice_8',
        'answer_key_practice_9',
        'answer_key_practice_10',
        'answer_key_practice_11',
        'answer_key_practice_12',
        'answer_key_practice_13',
        'answer_key_practice_14',
        'answer_key_practice_15',
        'answer_key_practice_16',
        'answer_key_practice_17',
        'answer_key_practice_18',
        'answer_key_practice_19',
        'answer_key_practice_20',
    ];

    protected $casts = [
        'material_type_id' => 'integer',
    ];
}
