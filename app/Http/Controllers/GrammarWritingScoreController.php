<?php

namespace App\Http\Controllers;

use App\Models\MeetingScore;

use Illuminate\Support\Facades\Auth;

class GrammarWritingScoreController extends Controller
{
    /**
     * Short display labels for the Grammar Writing tracks specifically (nicer
     * than the full program name in a table cell). Any other program falls
     * back to its real name - this page is not limited to Grammar Writing,
     * it shows every meeting_scores-based submission the student has, same
     * as Admin\AssignmentResultController does for teachers.
     */
    public const TRACK_LABELS = [
        'grammar-for-writing' => 'Fast-Track',
        'introductory-grammar-for-writing' => 'Introductory',
        'complexity-grammar-for-writing' => 'Complexity',
        'proficiency-grammar-for-writing' => 'Proficiency',
    ];

    public function myScores()
    {
        $scores = MeetingScore::with('program')
            ->where('user_id', Auth::id())
            ->where('is_reported', true)
            ->orderBy('program_id')
            ->orderBy('meeting_number')
            ->get();

        return view('assignments.grammar-writing.my-scores', compact('scores'));
    }

    public function myScoreShow(MeetingScore $meetingScore)
    {
        abort_unless($meetingScore->user_id === Auth::id(), 403);

        $meetingScore->load('program');
        $trackLabel = self::TRACK_LABELS[$meetingScore->program->slug ?? ''] ?? ($meetingScore->program->name ?? 'Program');

        return view('assignments.grammar-writing.my-score-show', compact('meetingScore', 'trackLabel'));
    }

    public function downloadEvaluationPdf(MeetingScore $meetingScore)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort_unless($meetingScore->user_id === $user->id, 403);
        }

        $evalPath = storage_path('app/public/evaluations/eval_' . $meetingScore->id . '.png');
        if (!file_exists($evalPath)) {
            $evalPath = storage_path('app/public/evaluations/eval_' . $meetingScore->user_id . '_' . $meetingScore->program_id . '_' . $meetingScore->meeting_number . '.png');
        }
        if (!file_exists($evalPath)) {
            $evalPath = storage_path('app/public/evaluations/eval_user_' . $meetingScore->user_id . '_m_' . $meetingScore->meeting_number . '.png');
        }

        if (!file_exists($evalPath)) {
            abort(404, 'File coret-coret evaluasi belum tersedia untuk tugas ini.');
        }

        $imageData = 'data:image/png;base64,' . base64_encode(file_get_contents($evalPath));
        $meetingScore->load('user', 'program', 'reviewer');

        $trackLabel = self::TRACK_LABELS[$meetingScore->program->slug ?? ''] ?? ($meetingScore->program->name ?? 'Grammar-Writing');
        $cleanTrack = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '-', $trackLabel));
        $cleanStudent = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '-', $meetingScore->user->name ?? 'Student'));
        $filename = "Evaluasi-{$cleanTrack}-Meeting{$meetingScore->meeting_number}-{$cleanStudent}.pdf";

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.evaluation-export', [
            'image' => $imageData,
            'meetingScore' => $meetingScore,
            'trackLabel' => $trackLabel,
        ])->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }
}
