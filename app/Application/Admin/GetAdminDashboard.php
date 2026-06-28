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

    public function execute(): array
    {
        $threshold = Carbon::now()->subHours(24)->timestamp;

        $totalStudents = $this->repository->countStudents();
        $totalTeachers = $this->repository->countTeachers();
        $totalPrograms = $this->repository->countPrograms();
        $activeAssignments = $this->repository->countMeetings();

        $activeStudents = $this->repository->getActiveStudents($threshold);
        $activeTeachers = $this->repository->getActiveTeachers($threshold);
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
