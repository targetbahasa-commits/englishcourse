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

    /**
     * Grace window (minutes) around a ClassMeeting's start_time/end_time
     * that still counts as "class is happening" for auto-attendance.
     */
    private const ATTENDANCE_GRACE_MINUTES = 15;

    protected function registerAssignmentAccessMiddleware(): void
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            if ($user && in_array($user->active_role, ['guest', 'guest_quick', 'test-taker'], true)) {
                // Always allow mockup and free test routes through — the controller/view handles access gating
                if ($request->routeIs('assignments.ielts-academic.mockup.*') || $request->routeIs('assignments.ielts.writing.*') || $request->routeIs('assignments.toefl-itp.*') || $request->routeIs('assignments.pte-academic*') || $request->routeIs('mock-test.*') || $request->routeIs('assignments.ielts-general*')) {
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
                $message = $this->hasExpiredEnrollmentForProgramSlug($user, $requiredProgramSlug)
                    ? 'Masa akses soal untuk program ini sudah berakhir (6 bulan sejak batch dimulai). Hubungi admin jika ingin memperpanjang.'
                    : 'You can only access assignments for your registered program.';

                return redirect()->route('assignments.index')->with('error', $message);
            }

            if ($user && $user->isStudent() && $requiredProgramSlug === 'ielts-academic' && $routeName && !preg_match('/^assignments\.[^.]+$/', $routeName)) {
                $rawSlugs = [];
                if ($user->program && $user->class_period_id) $rawSlugs[] = $user->program->slug;
                $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->whereIn('status', ['active', 'completed'])->with('program')->get();
                foreach ($enrollments as $enr) { if ($enr->program) $rawSlugs[] = $enr->program->slug; }
                
                $hasFullAccess = in_array('ielts-academic-full-package', $rawSlugs) || in_array('ielts-academic-all-sections', $rawSlugs) || in_array('ielts-academic', $rawSlugs) || $this->hasTemporaryFullAssignmentAccess($user->email);
                
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

            $this->maybeRecordAttendanceForAssignmentAccess($user, $requiredProgramSlug, $request);

            return $next($request);
        });
    }

    /**
     * Auto-marks a student present the moment they open an assignment page
     * while one of their scheduled ClassMeetings is actually happening
     * (within ATTENDANCE_GRACE_MINUTES of start_time/end_time). Opening an
     * assignment outside any scheduled window is left alone entirely -
     * that's self-practice ("Practice Mode", see EvaluatesClassPeriodEnd),
     * not class attendance.
     *
     * Deliberately checks $user->role (the real, un-overridable account
     * type) rather than $user->isStudent() - isStudent() reads active_role,
     * which User::getActiveRoleAttribute() swaps to session('view_as_role')
     * whenever an admin is using "view as student" preview mode, which
     * would otherwise silently create fake attendance rows under a staff
     * member's own account every time they preview an assignment page.
     *
     * Never overwrites an existing row (manual teacher entry, or a prior
     * auto-mark) - only fills in when nothing has been recorded yet for
     * that (user, class meeting) pair.
     */
    protected function maybeRecordAttendanceForAssignmentAccess($user, ?string $requiredProgramSlug, Request $request): void
    {
        if (!$requiredProgramSlug || !$user || $user->role !== 'student' || !$request->isMethod('get')) {
            return;
        }

        $classMeeting = $this->resolveCurrentClassMeetingForAttendance($user, $requiredProgramSlug);
        if (!$classMeeting) {
            return;
        }

        if (\App\Models\Attendance::where('user_id', $user->id)
            ->where('class_meeting_id', $classMeeting->id)
            ->exists()) {
            return;
        }

        try {
            \App\Models\Attendance::create([
                'user_id' => $user->id,
                'class_meeting_id' => $classMeeting->id,
                'status' => 'present',
                'notes' => 'Tercatat otomatis - siswa membuka assignment saat jadwal kelas berlangsung.',
                'recorded_by' => null,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Unique (user_id, class_meeting_id) race between near-simultaneous
            // requests - harmless, the other request's row already exists.
        }
    }

    /**
     * Finds the ClassMeeting (if any) happening right now, within a grace
     * window, for one of the student's enrollments matching the given
     * program. Mirrors ScheduleController@index's own raw TIME-string
     * comparisons against class_meetings.start_time/end_time rather than
     * touching the model's `datetime` cast on those columns, which would
     * otherwise misinterpret a plain TIME value.
     */
    protected function resolveCurrentClassMeetingForAttendance($user, string $requiredProgramSlug): ?\App\Models\ClassMeeting
    {
        $matchingEnrollments = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->whereNotNull('class_period_id')
            ->with('program')
            ->get()
            ->filter(fn ($e) => $e->program && $this->normalizeAssignmentProgramSlug($e->program->slug) === $requiredProgramSlug);

        $classPeriodIds = $matchingEnrollments->pluck('class_period_id');

        if ($classPeriodIds->isEmpty()) {
            return null;
        }

        // "Jam Kelas" override: a teacher/admin can explicitly designate
        // which meeting is happening right now (see
        // ManageGrammarWritingMeetings::updateActiveClassMeeting()), for
        // when the auto-generated weekly schedule drifts from the actual
        // class day. That designation wins over the time-window guess
        // below, as long as it's genuinely one of this student's matching
        // class periods (avoids a stale/foreign pointer leaking through).
        foreach ($matchingEnrollments as $enrollment) {
            $activeClassMeetingId = $enrollment->program->active_class_meeting_id ?? null;
            if (!$activeClassMeetingId) {
                continue;
            }

            $activeMeeting = \App\Models\ClassMeeting::find($activeClassMeetingId);
            if ($activeMeeting && $classPeriodIds->contains($activeMeeting->class_period_id)) {
                return $activeMeeting;
            }
        }

        $now = now();
        $windowStart = $now->copy()->subMinutes(self::ATTENDANCE_GRACE_MINUTES)->toTimeString();
        $windowEnd = $now->copy()->addMinutes(self::ATTENDANCE_GRACE_MINUTES)->toTimeString();

        return \App\Models\ClassMeeting::whereIn('class_period_id', $classPeriodIds)
            ->where('meeting_date', $now->toDateString())
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->where('start_time', '<=', $windowEnd)
            ->where('end_time', '>=', $windowStart)
            ->first();
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

        if ($user->program && $user->class_period_id && !$this->isClassPeriodAccessExpired($user->classPeriod)) {
            $slugs[] = $this->normalizeAssignmentProgramSlug($user->program->slug);
        }

        // Note: class_period_id determines WHICH class schedule/meetings apply to this
        // enrollment, not WHETHER the student may see the program's materials at all -
        // an active enrollment with a null/not-yet-assigned class_period_id must still
        // grant content access, or the student gets bounced with "not your program"
        // despite having paid and being actively enrolled. It's only used here to check
        // the 6-month access-expiry window (a null class period has no start date to
        // measure from, so it's treated as not-yet-expired rather than blocked).
        $enrollments = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->with(['program', 'classPeriod'])
            ->get();

        foreach ($enrollments as $enrollment) {
            if ($enrollment->program && !$this->isClassPeriodAccessExpired($enrollment->classPeriod)) {
                $slugs[] = $this->normalizeAssignmentProgramSlug($enrollment->program->slug);
            }
        }

        return array_values(array_unique(array_filter($slugs)));
    }

    /**
     * Students get 6 months of assignment access from their class period's
     * start_date. A class period with no start_date (or no class period at
     * all) has nothing to measure the window from, so it is NOT treated as
     * expired - only a class period that demonstrably started more than 6
     * months ago blocks access.
     */
    protected function isClassPeriodAccessExpired($classPeriod): bool
    {
        if (!$classPeriod || !$classPeriod->start_date) {
            return false;
        }

        return $classPeriod->start_date->copy()->addMonths(6)->isPast();
    }

    /**
     * True when the user has (or had) an enrollment matching the required
     * program but access was denied specifically because its class period's
     * 6-month window has passed - used only to pick a clearer error message,
     * not for the actual access decision.
     */
    protected function hasExpiredEnrollmentForProgramSlug($user, ?string $requiredProgramSlug): bool
    {
        if (!$requiredProgramSlug || !$user || !$user->isStudent()) {
            return false;
        }

        if ($user->program && $user->class_period_id
            && $this->normalizeAssignmentProgramSlug($user->program->slug) === $requiredProgramSlug
            && $this->isClassPeriodAccessExpired($user->classPeriod)) {
            return true;
        }

        $enrollments = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->with(['program', 'classPeriod'])
            ->get();

        foreach ($enrollments as $enrollment) {
            if ($enrollment->program
                && $this->normalizeAssignmentProgramSlug($enrollment->program->slug) === $requiredProgramSlug
                && $this->isClassPeriodAccessExpired($enrollment->classPeriod)) {
                return true;
            }
        }

        return false;
    }

    protected function normalizeAssignmentProgramSlug(?string $slug): ?string
    {
        if (in_array($slug, [
            'grammar-writing',
            'introductory-grammar-for-writing',
            'complexity-grammar-for-writing',
            'proficiency-grammar-for-writing',
            'fast-track-grammar-for-writing'
        ], true)) {
            return 'grammar-for-writing';
        }

        if (in_array($slug, [
            'introductory-speaking',
            'intermediate-speaking',
            'advanced-speaking',
            'grammar-for-speaking'
        ], true)) {
            return 'speaking';
        }

        if (in_array($slug, ['ielts-academic-listening', 'ielts-academic-reading', 'ielts-academic-writing', 'ielts-academic-speaking', 'ielts-academic-full-package', 'ielts-academic-all-sections'], true)) {
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