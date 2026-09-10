<?php

namespace App\Http\Controllers\Admin;

use App\Application\Score\ManageScores;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\MeetingScore;
use Illuminate\Support\Facades\Auth;

class AssignmentResultController extends Controller
{
    public function __construct(private readonly ManageScores $manageScores)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'program_id']);

        $programsWithAssignments = $this->manageScores->listProgramsWithAssignments($filters);
        $stats = $this->manageScores->getOverallAssignmentStats($filters);
        $allPrograms = $this->manageScores->getProgramOptions();
        $topPrograms = $this->manageScores->getTopPrograms();

        return view('admin.assignments.results.index', compact(
            'programsWithAssignments',
            'allPrograms',
            'topPrograms'
        ) + $stats);
    }

    public function show(Program $program)
    {
        $details = $this->manageScores->getProgramAssignmentDetails($program);

        return view('admin.assignments.results.show', $details);
    }

    public function showSubmission(Program $program, mixed $submission)
    {
        $submission = $this->manageScores->getSubmissionDetails($program, $submission);

        if (!$submission) {
            abort(404);
        }

        return view('admin.assignments.results.submission', compact(
            'program',
            'submission'
        ));
    }

    public function saveReview(Request $request, Program $program, MeetingScore $submission)
    {
        if ($submission->program_id !== $program->id) {
            abort(404);
        }

        $validated = $request->validate([
            'teacher_score' => 'nullable|numeric|min:0|max:100',
            'teacher_feedback' => 'nullable|string|max:5000',
        ]);

        $this->manageScores->saveSubmissionReview($submission, $validated, Auth::id());

        return back()->with('success', 'Nilai dan catatan guru berhasil disimpan!');
    }
}
