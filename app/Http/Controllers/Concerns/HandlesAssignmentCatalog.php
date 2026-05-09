<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Auth;

trait HandlesAssignmentCatalog
{
    public function index()
    {
        $programs = \App\Models\Program::whereNotIn('slug', ['ielts-academic-listening', 'ielts-academic-reading'])
            ->where('slug', 'not like', 'cambridge-%')
            ->where('slug', 'not like', 'toefl-itp-mock-package-%')
            ->where('is_active', true)
            ->get();
        $allowedAssignmentProgramSlugs = $this->resolveAllowedAssignmentProgramSlugsForUser(Auth::user());

        return view('assignments.index', compact('programs', 'allowedAssignmentProgramSlugs'));
    }

    public function ieltsAcademic()
    {
        $user = Auth::user();
        $programSlug = 'ielts-academic';
        if (!$this->userCanAccessAssignmentProgram($user, $programSlug)) {
            return redirect()->route('assignments.index')->with('error', 'You can only access assignments for your registered program.');
        }

        return view('ielts.writing.index');
    }

    public function pteAcademic()
    {
        $user = Auth::user();
        $programSlug = 'pte-academic';
        if (!$this->userCanAccessAssignmentProgram($user, $programSlug)) {
            return redirect()->route('assignments.index')->with('error', 'You can only access assignments for your registered program.');
        }

        return view('assignments.pte-academic');
    }

    public function ieltsGeneral()
    {
        $user = Auth::user();
        $programSlug = 'ielts-general';
        if (!$this->userCanAccessAssignmentProgram($user, $programSlug)) {
            return redirect()->route('assignments.index')->with('error', 'You can only access assignments for your registered program.');
        }

        return view('assignments.ielts-general');
    }
}