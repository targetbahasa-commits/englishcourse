<?php

namespace App\Application\Admin;

use App\Domain\Admin\Repositories\AdminReportRepository;

class BuildAdminReport
{
    public function __construct(
        private readonly AdminReportRepository $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->buildDashboardData();
    }
}
