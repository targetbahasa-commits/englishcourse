<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IeltsWritingQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'ielts_writing_meeting_id',
        'title',
        'instruction',
        'order',
    ];

    public function meeting()
    {
        return $this->belongsTo(IeltsWritingMeeting::class, 'ielts_writing_meeting_id');
    }
}
