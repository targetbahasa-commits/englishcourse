<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflMockupQuestion extends Model
{
    protected $fillable = [
        'section',
        'part',
        'package_number',
        'question_number',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'audio_file',
        'transcript_en',
        'transcript_id',
    ];
}
