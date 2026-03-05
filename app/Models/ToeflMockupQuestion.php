<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflMockupQuestion extends Model
{
    protected $fillable = [
        'section',
        'part',
        'question_number',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'audio_file',
    ];
}
