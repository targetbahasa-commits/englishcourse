<?php

namespace App\Domain\Admin\Repositories;

interface AdminRepository
{
    public function countStudents(): int;

    public function countTeachers(): int;

    public function countPrograms(): int;

    public function countMeetings(): int;

    public function getActiveStudents(int $threshold): array;

    public function getProgramPerformance(int $threshold): array;

    public function getTeacherActivitySummary(): array;
}
