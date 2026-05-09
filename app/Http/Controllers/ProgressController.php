<?php

namespace App\Http\Controllers;

use App\Application\Progress\GetUserProgress;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function __construct(
        private readonly GetUserProgress $getUserProgress,
    ) {
    }

    public function index()
    {
        $user = Auth::user();

        $progressData = $this->getUserProgress->buildProgressData($user);
        $freeTests    = $this->getUserProgress->getFreeTests($user);

        return view('student.progress.index', compact('freeTests', 'progressData'));
    }
}
