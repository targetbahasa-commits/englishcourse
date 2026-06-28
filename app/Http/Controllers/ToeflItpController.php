<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\EvaluatesClassPeriodEnd;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use Illuminate\Support\Facades\Auth;

class ToeflItpController extends Controller
{
    use HandlesAssignmentAccess, EvaluatesClassPeriodEnd;

    public function __construct()
    {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        $user = Auth::user();

        if (!$this->userCanAccessAssignmentProgram($user, 'toefl-itp')) {
            return redirect()->route('assignments.index')->with('error', 'You can only access assignments for your registered program.');
        }

        $isClassEnded = $user?->isStudent() ? $this->isStudentClassPeriodEnded('toefl-itp') : false;

        return view('assignments.toefl-itp', compact('isClassEnded'));
    }

    public function vocabulary()
    {
        return view('assignments.toefl-itp.vocabulary');
    }
}