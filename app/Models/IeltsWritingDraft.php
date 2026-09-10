<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Same purpose as AssignmentDraft (queryable snapshot of a saved-but-not-
 * submitted answer, upserted every autosave) but keyed the way
 * IeltsWritingPracticeSubmission itself is keyed - (user_id, meeting_id,
 * task_type) - rather than (user_id, program_id, meeting_number), since
 * IELTS Writing meetings are their own per-task rows, not grouped under
 * separate track Programs the way Grammar Writing is.
 */
class IeltsWritingDraft extends Model
{
    protected $fillable = [
        'user_id',
        'meeting_id',
        'task_type',
        'answers',
        'last_saved_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'last_saved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(IeltsWritingMeeting::class, 'meeting_id');
    }
}
