<?php

namespace App\Http\Controllers;

use App\Models\MeetingScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * SubmissionReviewSyncController
 *
 * Lets a student watch a teacher's in-progress correction of their
 * assignment submission live, using the same HTTP API polling approach as
 * LiveDrawingController (BROADCAST_CONNECTION is null in this environment,
 * so WebSocket broadcasting cannot be relied on).
 *
 * The draft teacher_score/teacher_feedback synced here is purely ephemeral
 * (Cache only) - nothing is written to meeting_scores until the teacher
 * submits the real review form (Admin\*Controller::saveReview()).
 *
 * Cache keys used:
 *   review_draft_{meetingScoreId}       → ['teacher_score' => ..., 'teacher_feedback' => ...]
 *   review_draft_time_{meetingScoreId}  → microtime(true) float timestamp
 */
class SubmissionReviewSyncController extends Controller
{
    /**
     * POST /api/submission-review/{meetingScore}/sync
     *
     * Called by the teacher's browser (debounced on input) while filling in
     * the review form. Route already restricts this to role:teacher.
     */
    public function sync(Request $request, MeetingScore $meetingScore)
    {
        $data = $request->validate([
            'teacher_score' => 'nullable|numeric|min:0|max:100',
            'teacher_feedback' => 'nullable|string|max:5000',
        ]);

        Cache::put("review_draft_{$meetingScore->id}", $data, 3600);
        Cache::put("review_draft_time_{$meetingScore->id}", microtime(true), 3600);

        return response()->json(['success' => true]);
    }

    /**
     * GET /api/submission-review/{meetingScore}/fetch
     *
     * Polled by the student's browser. Once the submission has actually been
     * reviewed (teacher clicked "Simpan Koreksi"), returns the final saved
     * values instead of the draft, so the client can switch out of "live"
     * mode. Uses the same timestamp-diff strategy as LiveDrawingController::fetch()
     * to avoid sending the draft repeatedly when nothing has changed.
     *
     * Access: the submission's own student, or an admin/teacher.
     */
    public function fetch(Request $request, MeetingScore $meetingScore)
    {
        $user = Auth::user();

        abort_unless(
            $user && ($user->isAdmin() || $user->isTeacher() || (int) $meetingScore->user_id === (int) $user->id),
            403
        );

        if ($meetingScore->reviewed_at) {
            return response()->json([
                'success' => true,
                'reviewed' => true,
                'teacher_score' => $meetingScore->teacher_score,
                'teacher_feedback' => $meetingScore->teacher_feedback,
                'reviewer_name' => $meetingScore->reviewer->name ?? null,
            ]);
        }

        $lastTime = (float) $request->query('last_time', 0);
        $serverTime = (float) Cache::get("review_draft_time_{$meetingScore->id}", 0);

        if ($serverTime > 0 && $serverTime > $lastTime) {
            $draft = Cache::get("review_draft_{$meetingScore->id}", []);

            return response()->json([
                'success' => true,
                'reviewed' => false,
                'time' => $serverTime,
                'teacher_score' => $draft['teacher_score'] ?? null,
                'teacher_feedback' => $draft['teacher_feedback'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'reviewed' => false,
            'time' => $serverTime,
        ]);
    }
}
