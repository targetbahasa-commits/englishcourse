<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HandlesAssignmentAccess
{
    private const TEMP_FULL_ASSIGNMENT_ACCESS_EMAILS = [
        'student4@dummy.com',
    ];

    protected function registerAssignmentAccessMiddleware(): void
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            if ($user && in_array($user->active_role, ['guest', 'guest_quick', 'test-taker'], true)) {
                // Always allow mockup routes through — the controller/view handles access gating
                if ($request->routeIs('assignments.ielts-academic.mockup.*') || $request->routeIs('assignments.ielts.writing.*') || $request->routeIs('assignments.toefl-itp.*')) {
                    return $next($request);
                }

                return redirect()->route('guest.free-tests')
                    ->with('error', 'Guest account does not have access to assignments.');
            }

            $requiredProgramSlug = $this->resolveAssignmentProgramSlugFromRequest($request);

            // Allow public access to top-level program landing pages (e.g. assignments.ielts-academic)
            // but keep access checks for deeper assignment routes (meetings/materials/practice).
            $routeName = $request->route()?->getName();
            if ($routeName && preg_match('/^assignments\.[^.]+$/', $routeName)) {
                return $next($request);
            }

            if ($user && !$this->userCanAccessAssignmentProgram($user, $requiredProgramSlug)) {
                return redirect()->route('assignments.index')
                    ->with('error', 'You can only access assignments for your registered program.');
            }

            if ($user && $user->isStudent() && $requiredProgramSlug === 'ielts-academic' && $routeName && !preg_match('/^assignments\.[^.]+$/', $routeName)) {
                $rawSlugs = [];
                if ($user->program && $user->class_period_id) $rawSlugs[] = $user->program->slug;
                $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->whereIn('status', ['active', 'completed'])->whereNotNull('class_period_id')->with('program')->get();
                foreach ($enrollments as $enr) { if ($enr->program) $rawSlugs[] = $enr->program->slug; }
                
                $hasFullAccess = in_array('ielts-academic-full-package', $rawSlugs) || in_array('ielts-academic', $rawSlugs) || $this->hasTemporaryFullAssignmentAccess($user->email);
                
                if (!$hasFullAccess) {
                    if (str_contains($routeName, '.listening.') && !in_array('ielts-academic-listening', $rawSlugs)) {
                        return redirect()->route('assignments.ielts-academic')->with('error', 'Anda tidak memiliki akses ke kelas IELTS Listening.');
                    }
                    if (str_contains($routeName, '.reading.') && !in_array('ielts-academic-reading', $rawSlugs)) {
                        return redirect()->route('assignments.ielts-academic')->with('error', 'Anda tidak memiliki akses ke kelas IELTS Reading.');
                    }
                    if (str_contains($routeName, '.writing.') && !in_array('ielts-academic-writing', $rawSlugs)) {
                        return redirect()->route('assignments.ielts-academic')->with('error', 'Anda tidak memiliki akses ke kelas IELTS Writing.');
                    }
                    if (str_contains($routeName, '.speaking.') && !in_array('ielts-academic-speaking', $rawSlugs)) {
                        return redirect()->route('assignments.ielts-academic')->with('error', 'Anda tidak memiliki akses ke kelas IELTS Speaking.');
                    }
                }
            }

            return $next($request);
        });
    }

    protected function resolveAssignmentProgramSlugFromRequest(Request $request): ?string
    {
        if ($request->routeIs('assignments.toefl-itp*')) {
            return 'toefl-itp';
        }

        if ($request->routeIs('assignments.ielts-academic*') || $request->routeIs('assignments.ielts.*')) {
            return 'ielts-academic';
        }

        if ($request->routeIs('assignments.pte-academic*')) {
            return 'pte-academic';
        }

        if ($request->routeIs('assignments.ielts-general*')) {
            return 'ielts-general';
        }

        if ($request->routeIs('assignments.grammar-writing*')) {
            return 'grammar-for-writing';
        }

        return null;
    }

    protected function resolveAllowedAssignmentProgramSlugsForUser($user): array
    {
        if (!$user || !$user->isStudent()) {
            return [];
        }

        $slugs = [];

        if ($user->program && $user->class_period_id) {
            $slugs[] = $this->normalizeAssignmentProgramSlug($user->program->slug);
        }

        $enrollments = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->whereNotNull('class_period_id')
            ->with('program')
            ->get();

        foreach ($enrollments as $enrollment) {
            if ($enrollment->program) {
                $slugs[] = $this->normalizeAssignmentProgramSlug($enrollment->program->slug);
            }
        }

        return array_values(array_unique(array_filter($slugs)));
    }

    protected function normalizeAssignmentProgramSlug(?string $slug): ?string
    {
        if ($slug === 'grammar-writing') {
            return 'grammar-for-writing';
        }

        if (in_array($slug, ['ielts-academic-listening', 'ielts-academic-reading', 'ielts-academic-writing', 'ielts-academic-speaking', 'ielts-academic-full-package'], true)) {
            return 'ielts-academic';
        }

        if (str_starts_with((string) $slug, 'cambridge-')) {
            return 'ielts-academic';
        }

        return $slug;
    }

    protected function userCanAccessAssignmentProgram($user, ?string $requiredProgramSlug): bool
    {
        if (!$requiredProgramSlug || !$user || !$user->isStudent()) {
            return true;
        }

        if ($this->hasTemporaryFullAssignmentAccess($user?->email)) {
            return true;
        }

        $allowedProgramSlugs = $this->resolveAllowedAssignmentProgramSlugsForUser($user);

        if ($allowedProgramSlugs === []) {
            return false;
        }

        return in_array($requiredProgramSlug, $allowedProgramSlugs, true);
    }

    protected function hasTemporaryFullAssignmentAccess(?string $email): bool
    {
        if (!$email) {
            return false;
        }

        return in_array(strtolower($email), self::TEMP_FULL_ASSIGNMENT_ACCESS_EMAILS, true);
    }
}