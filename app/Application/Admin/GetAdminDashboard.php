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
     */
    public function execute(int $activeWindowHours = 24): array
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
            'mailService'
        );
    }
}
