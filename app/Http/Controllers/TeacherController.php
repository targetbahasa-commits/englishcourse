<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassPeriod;
use Carbon\Carbon;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'teacher')->withCount(['students', 'classes']);

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $teachers = $query->paginate(15)->withQueryString();

        // Get unassigned students for the "Assign Private Student" modal dropdown
        $unassignedStudents = User::where('role', 'student')
                                  ->whereNull('teacher_id')
                                  ->where('status', 'active')
                                  ->get();

        // Get unassigned active classes for the "Assign Class" modal dropdown
        $unassignedClasses = ClassPeriod::whereNull('teacher_id')
                                        ->whereIn('status', ['active', 'upcoming'])
                                        ->get();

        // Calculate simple placeholder dummy metrics for the UI based on counts
        $totalTeachersCount = User::where('role', 'teacher')->count();
        
        $metrics = [
            'grading_progress' => 85, // Dummy average percentage
            'attendance_rate' => 95, // Dummy percentage
            'material_uploads' => $totalTeachersCount * 4, // Simple calc for realism
        ];

        return view('admin.teachers.index', compact('teachers', 'unassignedStudents', 'unassignedClasses', 'metrics'));
    }

    /**
     * Display the specified teacher's profile.
     */
    public function show(User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            return redirect()->route('teachers.index')->with('error', 'The selected user is not a teacher.');
        }

        $teacher->load(['classes.students', 'students.program']);

        // Fetch recent evaluations
        $evaluations = \App\Models\TeacherEvaluation::where('teacher_id', $teacher->id)
            ->with('student')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
            
        $averageRating = \App\Models\TeacherEvaluation::where('teacher_id', $teacher->id)->avg('rating') ?? 4.8; // default if no ratings

        // Get upcoming classes taught by this teacher
        $upcomingClasses = \App\Models\ClassPeriod::where('teacher_id', $teacher->id)
            ->whereIn('status', ['active', 'upcoming'])
            ->withCount('users as students_count') // Alias the count so the view can still use 'students_count'
            ->get();

        return view('admin.teachers.show', compact('teacher', 'evaluations', 'averageRating', 'upcomingClasses'));
    }

    /**
     * Assign a private student to a teacher from the Quick Actions modal
     */
    public function assignStudent(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $teacher = User::findOrFail($request->teacher_id);
        $student = User::findOrFail($request->student_id);

        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'The selected user is not a teacher.');
        }

        $student->teacher_id = $teacher->id;
        $student->save();

        return back()->with('success', "Student {$student->name} has been successfully assigned to {$teacher->name} as a private student.");
    }

    /**
     * Assign a class period (group) to a teacher from the Quick Actions modal
     */
    public function assignClass(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:class_periods,id',
        ]);

        $teacher = User::findOrFail($request->teacher_id);
        $classPeriod = ClassPeriod::findOrFail($request->class_id);

        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'The selected user is not a teacher.');
        }

        $classPeriod->teacher_id = $teacher->id;
        $classPeriod->save();

        return back()->with('success', "Class '{$classPeriod->name}' has been successfully assigned to {$teacher->name}.");
    }
}
