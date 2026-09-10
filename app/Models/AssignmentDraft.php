<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A queryable snapshot of a student's saved-but-not-yet-submitted answers,
 * upserted every autosave alongside the existing session-based draft (see
 * GrammarWritingAdminController::grammarWritingMeetingDraft() and
 * LegacyGrammarWritingController::meetingDraft()) - session data isn't
 * reportable across users, this table exists purely so admins/teachers can
 * see who's currently working on what before they hit Submit.
 */
class AssignmentDraft extends Model
{
    protected $fillable = [
        'user_id',
        'program_id',
        'meeting_number',
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

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
