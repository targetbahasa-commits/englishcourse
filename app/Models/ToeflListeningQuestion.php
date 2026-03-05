<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflListeningQuestion extends Model
{
    protected $fillable = [
        'meeting_number',
        'set_number',
        'question_number',
        'audio_file',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'transcript_en',
        'transcript_id',
    ];

    public function scopeByMeeting($query, $meetingNumber)
    {
        return $query->where('meeting_number', $meetingNumber)->orderBy('question_number');
    }
}
