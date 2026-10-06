<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatReadingWritingQuestion extends Model
{
    use HasFactory;

    protected $table = 'sat_reading_writing_questions';

    protected $fillable = [
        'meeting_id',
        'question_number',
        'category',
        'passage',
        'question_prompt',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
    ];

    protected $casts = [
        'meeting_id' => 'integer',
        'question_number' => 'integer',
    ];

    public function meeting()
    {
        return $this->belongsTo(SatReadingWritingMeeting::class, 'meeting_id');
    }
}
