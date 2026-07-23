<?php

namespace App\Http\Controllers\Admin;

use App\Application\Score\ManageScores;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;

class AssignmentResultController extends Controller
{
    public function __construct(private readonly ManageScores $manageScores)
    {
        $this->middleware('role:admin');
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
}
