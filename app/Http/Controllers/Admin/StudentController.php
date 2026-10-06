<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\ManageStudents;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentAssignTeacherRequest;
use App\Http\Requests\Admin\StudentQuickUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function __construct(
        private readonly ManageStudents $manageStudents
    ) {}

    /**
     * Display a listing of all students.
     */
    public function index(Request $request)
    {
        ['students' => $students, 'teachers' => $teachers, 'programs' => $programs, 'metrics' => $metrics] = $this->manageStudents->listAll(
            $request->only(['search', 'status', 'missing', 'program_id', 'class_period_id', 'month_year']),
            15
        );

        return view('admin.students.index', compact('students', 'teachers', 'programs', 'metrics'));
    }

    /**
     * Display the specified student's profile.
     */
    public function show(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')->with('error', 'User is not a student.');
        }

        [
            'student' => $student,
            'recentActivity' => $recentActivity,
            'progressPercentage' => $progressPercentage,
            'completedAssignments' => $completedAssignments,
            'totalAssignments' => $totalAssignments,
            'averageScore' => $averageScore,
            'latestTest' => $latestTest,
            'latestFinalTest' => $latestFinalTest,
            'allAssignmentScores' => $allAssignmentScores,
        ] = $this->manageStudents->show($student);

        return view('admin.students.show', compact('student', 'recentActivity', 'progressPercentage', 'completedAssignments', 'totalAssignments', 'averageScore', 'latestTest', 'latestFinalTest', 'allAssignmentScores'));
    }

    /**
     * Reassign a student to a different teacher.
     */
    public function assignTeacher(StudentAssignTeacherRequest $request, User $student)
    {
        $teacher = null;

        if ($request->teacher_id) {
            $teacher = $this->manageStudents->getTeacherOrFail((int) $request->teacher_id);
            if ($teacher->role !== 'teacher') {
                return back()->with('error', 'The selected user is not a teacher.');
            }
        }

        $message = $this->manageStudents->assignTeacher($student, $teacher ? $teacher->id : null);

        return back()->with('success', $message);
    }

    /**
     * Quick inline update of phone_number and/or referral_code.
     */
    public function quickUpdate(StudentQuickUpdateRequest $request, User $student)
    {
        $this->manageStudents->quickUpdate($student, [
            'phone_number' => $request->phone_number,
            'referral_code' => $request->referral_code,
        ]);

        return back()->with('success', "Updated {$student->name}'s contact info successfully.");
    }

    /**
     * Bulk auto-generate referral codes for students who don't have one.
     */
    public function bulkGenerateReferralCodes()
    {
        $updated = $this->manageStudents->bulkGenerateReferralCodes();

        return back()->with('success', "Generated referral codes for {$updated} student(s).");
    }

    /**
     * Open a quick view of the student's currently active assignment path
     * with the latest detected question/answer snapshot.
     */
    public function currentAssignment(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')->with('error', 'User is not a student.');
        }

        return view('admin.students.current-assignment', $this->manageStudents->getCurrentAssignmentViewData($student));
    }

    /**
     * JSON endpoint for auto-refresh polling of student's current assignment snapshot.
     * Called every 5 seconds by the frontend to update the display with fresh data.
     */
    public function currentAssignmentJson(User $student)
    {
        if ($student->role !== 'student') {
            return response()->json(['error' => 'User is not a student.'], 403);
        }

        return response()->json($this->manageStudents->getCurrentAssignmentJsonData($student));
    }

    /**
     * JSON endpoint backing the "Lihat Jawaban" modal's refresh button on the
     * student profile page - refetches a single meeting's latest submitted
     * score or in-progress draft without reloading the whole page.
     */
    public function meetingAnswers(Request $request, User $student)
    {
        if ($student->role !== 'student') {
            return response()->json(['error' => 'User is not a student.'], 403);
        }

        $request->validate([
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'meeting_number' => ['required', 'integer'],
        ]);

        $program = \App\Models\Program::findOrFail($request->integer('program_id'));
        $meetingNumber = $request->integer('meeting_number');

        $meeting = \App\Models\Meeting::where('program_id', $program->id)
            ->where('meeting_number', $meetingNumber)
            ->first();

        $score = \App\Models\MeetingScore::where('user_id', $student->id)
            ->where('program_id', $program->id)
            ->where('meeting_number', $meetingNumber)
            ->where('is_reported', true)
            ->first();

        $draft = \App\Models\AssignmentDraft::where('user_id', $student->id)
            ->where('program_id', $program->id)
            ->where('meeting_number', $meetingNumber)
            ->first();

        $status = $score ? 'submitted' : ($draft ? 'in_progress' : 'not_started');

        $answers = $status === 'submitted'
            ? (is_array($score->answers_data) ? $score->answers_data : [])
            : ($status === 'in_progress' ? (is_array($draft->answers) ? $draft->answers : []) : []);

        $questions = AdminGrammarWritingReviewController::resolveQuestionsForMeeting(
            $program->slug ?? '',
            $meetingNumber
        );

        $savedAt = $status === 'submitted'
            ? $score->submitted_at?->diffForHumans()
            : ($status === 'in_progress' ? $draft->last_saved_at?->diffForHumans() : null);

        $isGrammarWritingTrack = in_array(
            $program->slug ?? '',
            array_column(AdminGrammarWritingReviewController::TRACKS, 'slug'),
            true
        );

        return response()->json([
            'programName' => $program->name,
            'meetingNumber' => $meetingNumber,
            'title' => $meeting->title ?? null,
            'status' => $status,
            'score' => $score->score ?? null,
            'meetingScoreId' => $isGrammarWritingTrack ? ($score->id ?? null) : null,
            'savedAt' => $savedAt,
            'answers' => $answers,
            'questions' => $questions,
        ]);
    }
}
