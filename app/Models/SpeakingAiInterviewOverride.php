<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Admin-edited replacement for a Speaking meeting's "AI Interview" tab
 * question set - see SpeakingAdminController::speakingMeeting(). Keyed by
 * the same (level, meeting_number) route params the page itself uses
 * (not a programs/meetings FK - not every level/meeting combination is
 * backed by a real Meeting row). When no row exists for a given
 * (level, meeting_number), the page falls back to its original hardcoded
 * question content unchanged.
 */
class SpeakingAiInterviewOverride extends Model
{
    protected $fillable = [
        'level',
        'meeting_number',
        'questions',
    ];

    protected $casts = [
        'questions' => 'array',
    ];
}
