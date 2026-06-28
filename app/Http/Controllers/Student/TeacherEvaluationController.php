<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Application\Teacher\ManageTeacherEvaluations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherEvaluationController extends Controller
{
    public function __construct(
        private readonly ManageTeacherEvaluations $manageTeacherEvaluations
    ) {
    }

    /**
     * Show the form for creating a new evaluation.
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isStudent() || !$user->teacher_id) {
            return redirect()->route('dashboard')->with('error', 'You must be assigned a teacher to evaluate them.');
        }

        $teacher = $this->manageTeacherEvaluations->getTeacherForEvaluation($user->teacher_id);
        
        return view('student.evaluations.create', compact('teacher'));
    }

    /**
     * Store a newly created evaluation in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->isStudent() || !$user->teacher_id) {
            return redirect()->route('dashboard')->with('error', 'You must be assigned a teacher to evaluate them.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $this->manageTeacherEvaluations->submitEvaluation(
            $user->id,
            $user->teacher_id,
            $request->integer('rating'),
            $request->input('comment')
        );

        return redirect()->route('dashboard')->with('success', 'Thank you! Your evaluation has been submitted.');
    }
}
