<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HandlesAssignmentAccess
{
    protected function registerAssignmentAccessMiddleware(): void
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            if ($user && in_array($user->active_role, ['guest', 'guest_quick'], true)) {
                // Always allow mockup routes through — the controller/view handles access gating
                if ($request->routeIs('assignments.ielts-academic.mockup.*') || $request->routeIs('assignments.ielts.writing.*')) {
                    return $next($request);
                }

                return redirect()->route('guest.free-tests')
                    ->with('error', 'Guest account does not have access to assignments.');
            }

            $requiredProgramSlug = $this->resolveAssignmentProgramSlugFromRequest($request);

            if ($user && !$this->userCanAccessAssignmentProgram($user, $requiredProgramSlug)) {
                return redirect()->route('assignments.index')
                    ->with('error', 'You can only access assignments for your registered program.');
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

        if ($user->program) {
            $slugs[] = $this->normalizeAssignmentProgramSlug($user->program->slug);
        }

        $enrollments = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->with('program')
            ->get();

        foreach ($enrollments as $enrollment) {
            if ($enrollment->program) {
                $slugs[] = $this->normalizeAssignmentProgramSlug($enrollment->program->slug);
            }
        }

        $slugs = array_merge($slugs, ['ielts-academic', 'ielts-general']);

        return array_values(array_unique(array_filter($slugs)));
    }

    protected function normalizeAssignmentProgramSlug(?string $slug): ?string
    {
        if ($slug === 'grammar-writing') {
            return 'grammar-for-writing';
        }

        if (in_array($slug, ['ielts-academic-listening', 'ielts-academic-reading', 'ielts-academic-full-package'], true)) {
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

        $allowedProgramSlugs = $this->resolveAllowedAssignmentProgramSlugsForUser($user);

        if ($allowedProgramSlugs === []) {
            return false;
        }

        return in_array($requiredProgramSlug, $allowedProgramSlugs, true);
    }
}