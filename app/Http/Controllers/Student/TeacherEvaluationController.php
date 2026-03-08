<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherEvaluation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeacherEvaluationController extends Controller
{
    /**
     * Show the form for creating a new evaluation.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Ensure the user is a student and has a teacher assigned
        if (!$user->isStudent() || !$user->teacher_id) {
            return redirect()->route('dashboard')->with('error', 'You must be assigned a teacher to evaluate them.');
        }

        $teacher = User::find($user->teacher_id);
        
        return view('student.evaluations.create', compact('teacher'));
    }

    /**
     * Store a newly created evaluation in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Ensure the user is a student and has a teacher assigned
        if (!$user->isStudent() || !$user->teacher_id) {
            return redirect()->route('dashboard')->with('error', 'You must be assigned a teacher to evaluate them.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        TeacherEvaluation::create([
            'student_id' => $user->id,
            'teacher_id' => $user->teacher_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('dashboard')->with('success', 'Thank you! Your evaluation has been submitted.');
    }
}
