<?php

namespace App\Http\Controllers;

use App\Application\Teacher\ManageTeachers;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct(
        private readonly ManageTeachers $manageTeachers,
    ) {
    }

    public function index(Request $request)
    {
        $filters = [];
        if ($request->filled('search')) {
            $filters['search'] = $request->search;
        }
        if ($request->filled('status')) {
            $filters['status'] = $request->status;
        }

        $teachers = $this->manageTeachers->searchTeachers($filters);
        $unassignedStudents = $this->manageTeachers->getUnassignedStudents();
        $unassignedClasses = $this->manageTeachers->getUnassignedClasses();

        $totalTeachersCount = User::where('role', 'teacher')->count();
        
        $metrics = [
            'grading_progress' => 85,
            'attendance_rate'  => 95,
            'material_uploads' => $totalTeachersCount * 4,
        ];

        return view('admin.teachers.index', compact('teachers', 'unassignedStudents', 'unassignedClasses', 'metrics'));
    }

    public function show(User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            return redirect()->route('teachers.index')->with('error', 'The selected user is not a teacher.');
        }

        $teacher->load(['classes.students', 'students.program']);

        $evaluations = \App\Models\TeacherEvaluation::where('teacher_id', $teacher->id)
            ->with('student')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
            
        $averageRating = \App\Models\TeacherEvaluation::where('teacher_id', $teacher->id)->avg('rating') ?? 4.8;

        $upcomingClasses = \App\Models\ClassPeriod::where('teacher_id', $teacher->id)
            ->whereIn('status', ['active', 'upcoming'])
            ->withCount('users as students_count')
            ->get();

        return view('admin.teachers.show', compact('teacher', 'evaluations', 'averageRating', 'upcomingClasses'));
    }

    public function assignStudent(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $teacher = User::findOrFail($request->teacher_id);

        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'The selected user is not a teacher.');
        }

        $this->manageTeachers->assignStudent($request->teacher_id, $request->student_id);
        $student = User::findOrFail($request->student_id);

        return back()->with('success', "Student {$student->name} has been successfully assigned to {$teacher->name} as a private student.");
    }

    public function assignClass(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'class_id'   => 'required|exists:class_periods,id',
        ]);

        $teacher = User::findOrFail($request->teacher_id);

        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'The selected user is not a teacher.');
        }

        $this->manageTeachers->assignClass($request->teacher_id, $request->class_id);
        $classPeriod = \App\Models\ClassPeriod::findOrFail($request->class_id);

        return back()->with('success', "Class '{$classPeriod->name}' has been successfully assigned to {$teacher->name}.");
    }
}
