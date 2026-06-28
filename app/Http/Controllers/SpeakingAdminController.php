<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpeakingAdminController extends Controller
{
    /**
     * SpeakingAdminController
     *
     * Handles speaking classes selector and speaking lessons management.
     */

    public function speakingClasses()
    {
        return view('assignments.speaking-classes');
    }

    public function speakingLevel(string $level)
    {
        $allowedLevels = ['introductory', 'intermediate', 'advanced'];

        if (! in_array($level, $allowedLevels, true)) {
            abort(404);
        }

        return view('assignments.speaking-classes', ['level' => $level]);
    }

    public function speaking()
    {
        // This can be expanded later to show Fast Track Speaking lessons/meetings
        return view('assignments.speaking');
    }
}
