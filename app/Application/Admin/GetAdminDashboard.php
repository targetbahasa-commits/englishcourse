<?php

namespace App\Application\Admin;

use App\Domain\Admin\Contracts\DatabaseHealthChecker;
use App\Domain\Admin\Repositories\AdminRepository;
use Carbon\Carbon;

class GetAdminDashboard
{
    public function __construct(
        private readonly AdminRepository $repository,
        private readonly DatabaseHealthChecker $databaseHealthChecker,
    ) {
    }

    /**
     * @param  int  $activeWindowHours  How far back "recently active" looks for
     *   the Students/Teachers widgets specifically (24 or 48). Program
     *   performance's own active-student count always uses the standard
     *   24h window regardless, since that's a separate metric the caller
     *   isn't choosing a window for.
     * @param  bool  $includeAttendanceHealth  Adds missingClassTimeCount (see
     *   below). Off by default since this is only meaningful for the actual
     *   Dashboard page render - the 30s-polled activeStudentsJson/
     *   activeTeachersJson endpoints also call execute() but never read that
     *   key, so skip the extra query for those.
     */
    public function execute(int $activeWindowHours = 24, bool $includeAttendanceHealth = false): array
    {
        $threshold = Carbon::now()->subHours(24)->timestamp;
        $activeWindowThreshold = Carbon::now()->subHours($activeWindowHours)->timestamp;

        $totalStudents = $this->repository->countStudents();
        $totalTeachers = $this->repository->countTeachers();
        $totalPrograms = $this->repository->countPrograms();
        $activeAssignments = $this->repository->countMeetings();

        $activeStudents = $this->repository->getActiveStudents($activeWindowThreshold);
        $activeTeachers = $this->repository->getActiveTeachers($activeWindowThreshold);
        $programPerformance = $this->repository->getProgramPerformance($threshold);
        $teacherActivitySummary = $this->repository->getTeacherActivitySummary();

        $dbStatus = $this->databaseHealthChecker->isConnected() ? 'Connected' : 'Disconnected';

        $appVersion = config('app.version', 'v'.app()->version());
        $mailService = config('mail.default', 'smtp');

        // Auto-attendance (see HandlesAssignmentAccess::maybeRecordAttendanceForAssignmentAccess())
        // can only mark a student present for a ClassMeeting that has a real
        // meeting_date, and needs "Jam Kelas" (start_time/end_time) filled in
        // to hit its normal, precise time-window match. A meeting missing
        // that isn't a hard failure anymore (there's a same-day fallback -
        // see resolveCurrentClassMeetingForAttendance()), but it's still
        // silent: nothing tells the admin a class has been running without
        // "Jam Kelas" set. Surface it here instead of only discovering it
        // after days of classes have already gone by unrecorded.
        $missingClassTimeCount = $includeAttendanceHealth
            ? \App\Models\ClassMeeting::whereBetween('meeting_date', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString(),
            ])->where(function ($query) {
                $query->whereNull('start_time')->orWhereNull('end_time');
            })->count()
            : 0;

        return compact(
            'totalStudents',
            'totalTeachers',
            'totalPrograms',
            'activeAssignments',
            'activeStudents',
            'activeTeachers',
            'programPerformance',
            'teacherActivitySummary',
            'dbStatus',
            'appVersion',
            'mailService',
            'missingClassTimeCount'
        );
    }
}
