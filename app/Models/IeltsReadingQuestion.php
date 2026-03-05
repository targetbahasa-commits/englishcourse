<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeltsReadingQuestion extends Model
{
    protected $fillable = [
        'passage_id',
        'question_number',
        'question_text',
        'type',
        'options',
        'correct_answer',
        'explanation',
        'order',
        'data'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'array',
        'data' => 'array',
    ];

    public function passage()
    {
        return $this->belongsTo(IeltsReadingPassage::class, 'passage_id');
    }
}
