<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Program;

class StudentController extends Controller
{
    /**
     * Display a listing of all students.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->with(['program', 'teacher']);

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->paginate(15)->withQueryString();

        // Pass teachers for the Assign Teacher modal
        $teachers = User::where('role', 'teacher')->where('status', 'active')->get();

        // Calculate simple placeholder dummy metrics for the UI
        $totalStudents = User::where('role', 'student')->count();
        $activeStudents = User::where('role', 'student')->where('status', 'active')->count();

        $metrics = [
            'total_students' => $totalStudents,
            'active_students' => $activeStudents,
            'average_progress' => 65, // Dummy progress percentage
        ];

        return view('admin.students.index', compact('students', 'teachers', 'metrics'));
    }

    /**
     * Reassign a student to a different teacher.
     */
    public function assignTeacher(Request $request, User $student)
    {
        $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if ($request->teacher_id) {
            $teacher = User::findOrFail($request->teacher_id);
            if ($teacher->role !== 'teacher') {
                return back()->with('error', 'The selected user is not a teacher.');
            }
            $student->teacher_id = $teacher->id;
            $message = "Student {$student->name} has been assigned to {$teacher->name}.";
        } else {
            $student->teacher_id = null;
            $message = "Student {$student->name} has been unassigned from their teacher.";
        }

        $student->save();

        return back()->with('success', $message);
    }
}
