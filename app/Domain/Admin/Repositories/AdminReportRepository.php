<?php

namespace App\Domain\Admin\Repositories;

interface AdminReportRepository
{
    public function buildDashboardData(): array;
}
