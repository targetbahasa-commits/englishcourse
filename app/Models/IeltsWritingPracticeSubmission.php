<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IeltsWritingPracticeSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'meeting_id',
        'task_type',
        'essay',
        'scores',
        'evaluation_status',
        'error_message',
        'attempts',
        'teacher_feedback',
        'teacher_score',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'scores' => 'array',
        'teacher_score' => 'float',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(IeltsWritingMeeting::class, 'meeting_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
