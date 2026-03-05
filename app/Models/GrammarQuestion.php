<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarQuestion extends Model
{
    protected $fillable = [
        'meeting_number',
        'question_number',
        'question_text',
        'correct_answer',
        'example_id',
        'example_en',
        'vocab',
        'section',
        'tense',
        'structure',
        'formula',
        'example',
        'vocabulary'
    ];

    protected $casts = [
        'vocab' => 'array',
        'example' => 'array',
    ];
}
