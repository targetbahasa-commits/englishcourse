<?php

namespace App\Application\Admin;

use App\Domain\Admin\Contracts\DatabaseHealthChecker;
use App\Domain\Admin\Repositories\AdminDashboardRepository;

class GetAdminDashboardSummary
{
    public function __construct(
        private readonly AdminDashboardRepository $repository,
        private readonly DatabaseHealthChecker $databaseHealthChecker,
    ) {
    }

    public function execute(): array
    {
        $totalStudents = $this->repository->countStudents();
        $totalTeachers = $this->repository->countTeachers();
        $totalPrograms = $this->repository->countPrograms();
        $activeAssignments = $this->repository->countUnlockedMeetings();

        $activeStudents = $this->repository->recentlyActiveStudents(24, 20);
        $closingSoonScholarships = $this->repository->scholarshipsClosingSoon(14, 5);

        $dbStatus = $this->databaseHealthChecker->isConnected() ? 'Connected' : 'Disconnected';

        $appVersion = config('app.version', '2.5.0');
        $mailService = config('mail.default', 'smtp');

        return compact(
            'totalStudents',
            'totalTeachers',
            'totalPrograms',
            'activeAssignments',
            'activeStudents',
            'closingSoonScholarships',
            'dbStatus',
            'appVersion',
            'mailService'
        );
    }
}
