<?php

namespace App\Http\Controllers;

use App\Application\ToeflStructurePractice\BuildStructurePracticeIndexData;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;

class ToeflStructurePracticeController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly BuildStructurePracticeIndexData $buildStructurePracticeIndexData,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.toefl-itp.structure.practice-index', $this->buildStructurePracticeIndexData->handle(\Illuminate\Support\Facades\Auth::user()));
    }
}