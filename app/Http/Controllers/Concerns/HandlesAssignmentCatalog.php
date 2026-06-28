<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Auth;

trait HandlesAssignmentCatalog
{
    public function index()
    {
        $grammarSubSlugs = [
            'introductory-grammar-for-writing',
            'complexity-grammar-for-writing',
            'proficiency-grammar-for-writing',
            'fast-track-grammar-for-writing',
        ];

        $speakingSubSlugs = [
            'introductory-speaking',
            'intermediate-speaking',
            'advanced-speaking',
        ];

        $programs = \App\Models\Program::whereNotIn('slug', array_merge(
                ['ielts-academic-listening', 'ielts-academic-reading'],
                $grammarSubSlugs,
                $speakingSubSlugs
            ))
            ->where('slug', 'not like', 'cambridge-%')
            ->where('slug', 'not like', 'toefl-itp-mock-package-%')
            ->where('is_active', true)
            ->get();

        // Add a synthetic "Grammar for Writing" group entry
        $grammarGroup = new \App\Models\Program([
            'name' => 'Grammar for Writing',
            'slug' => 'grammar-for-writing',
            'description' => 'Master the fundamentals of English grammar specifically tailored for academic and professional writing.',
            'color' => 'blue',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>',
            'is_active' => true,
        ]);
        $programs->prepend($grammarGroup);

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