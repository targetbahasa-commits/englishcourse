<?php

namespace App\Http\Controllers\Teacher;

use App\Application\Teacher\ManageTeacherEvaluations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function __construct(
        private readonly ManageTeacherEvaluations $manageTeacherEvaluations
    ) {
    }

    /**
     * Display a listing of evaluations for the authenticated teacher.
     */
    public function index()
    {
        $teacher = Auth::user();

        if (!$teacher->isTeacher()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $evaluations = $this->manageTeacherEvaluations->listTeacherEvaluations($teacher->id, 15);
        $averageRating = $this->manageTeacherEvaluations->getTeacherAverageRating($teacher->id);
        $totalEvaluations = $evaluations->total();

        return view('teacher.evaluations.index', compact('evaluations', 'averageRating', 'totalEvaluations'));
    }
}
