<?php

namespace App\Http\Controllers\Concerns;

use App\Models\ClassPeriod;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

/**
 * Provides helpers to determine whether the currently-authenticated student
 * is still within an active class period for a given program, or whether
 * their class has ended and submissions should be treated as "Practice Mode"
 * (stored but NOT reported to admin/teachers).
 */
trait EvaluatesClassPeriodEnd
{
    /**
     * Determine if the student's class period for the given program slug has ended.
     * Returns true if:
     *   - The student has no class period at all (no class = no access, treated as ended).
     *   - The class period's end_date is in the past.
     *
     * Returns false (class is still active) if end_date is today or in the future,
     * or if the user is admin/teacher (they are never blocked).
     */
    protected function isStudentClassPeriodEnded(?string $programSlug = null): bool
    {
        $user = Auth::user();

        if (!$user || !$user->isStudent()) {
            return false;
        }

        $classPeriod = $this->resolveClassPeriodForUser($user, $programSlug);

        if (!$classPeriod) {
            // No assigned class period → treat as ended
            return true;
        }

        if (!$classPeriod->end_date) {
            // No end date set → class is open-ended (active)
            return false;
        }

        return now()->startOfDay()->isAfter($classPeriod->end_date->endOfDay());
    }

    /**
     * Resolve the most relevant class period for the student.
     * Checks both the legacy class_period_id field and the enrollments table.
     */
    protected function resolveClassPeriodForUser($user, ?string $programSlug = null): ?ClassPeriod
    {
        // Try enrollments first (newer system)
        $enrollmentQuery = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->with(['classPeriod', 'program']);

        if ($programSlug) {
            $enrollmentQuery->whereHas('program', function ($q) use ($programSlug) {
                $q->where('slug', $programSlug)
                  ->orWhere('slug', 'like', $programSlug . '-%');
            });
        }

        $enrollment = $enrollmentQuery->latest()->first();

        if ($enrollment?->classPeriod) {
            return $enrollment->classPeriod;
        }

        // Fallback to legacy class_period_id on users table
        if ($user->class_period_id) {
            $classPeriod = ClassPeriod::find($user->class_period_id);
            if ($classPeriod) {
                return $classPeriod;
            }
        }

        return null;
    }
}
