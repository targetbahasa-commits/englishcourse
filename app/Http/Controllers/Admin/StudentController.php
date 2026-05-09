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
        ] = $this->manageStudents->show($student);

        return view('admin.students.show', compact('student', 'recentActivity', 'progressPercentage', 'completedAssignments', 'totalAssignments', 'averageScore', 'latestTest'));
    }

    /**
     * Reassign a student to a different teacher.
     */
    public function assignTeacher(StudentAssignTeacherRequest $request, User $student)
    {
        if ($request->teacher_id) {
            $teacher = User::findOrFail($request->teacher_id);
            if ($teacher->role !== 'teacher') {
                return back()->with('error', 'The selected user is not a teacher.');
            }
        }

        $message = $this->manageStudents->assignTeacher($student, $request->teacher_id ? (int) $request->teacher_id : null);

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
}
