<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherEvaluation;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of evaluations for the authenticated teacher.
     */
    public function index()
    {
        $teacher = Auth::user();

        // Ensure user is actually a teacher
        if (!$teacher->isTeacher()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $evaluations = TeacherEvaluation::with('student')
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->paginate(15);
            
        $averageRating = TeacherEvaluation::where('teacher_id', $teacher->id)->avg('rating');
        $totalEvaluations = TeacherEvaluation::where('teacher_id', $teacher->id)->count();

        return view('teacher.evaluations.index', compact('evaluations', 'averageRating', 'totalEvaluations'));
    }
}
