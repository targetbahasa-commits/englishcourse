<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflReadingQuestion extends Model
{
    protected $fillable = [
        'passage_id',
        'question_number',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'keywords',
    ];

    protected $casts = [
        'keywords' => 'array',
    ];

    public function passage()
    {
        return $this->belongsTo(ToeflReadingPassage::class, 'passage_id');
    }
}
