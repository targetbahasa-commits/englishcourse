<?php

namespace App\Domain\Admin\Repositories;

interface AdminDashboardRepository
{
    public function countStudents(): int;

    public function countTeachers(): int;

    public function countPrograms(): int;

    public function countUnlockedMeetings(): int;

    public function recentlyActiveStudents(int $hours, int $limit): array;

    public function scholarshipsClosingSoon(int $days, int $limit): array;
}
