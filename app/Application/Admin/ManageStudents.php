<?php

namespace App\Application\Admin;

use App\Domain\Admin\Repositories\AdminStudentRepository;

class ManageStudents
{
    public function __construct(
        private readonly AdminStudentRepository $repository
    ) {}

    public function listAll(array $filters, int $perPage = 15): array
    {
        $students = $this->repository->listStudents($filters, $perPage);
        $teachers = $this->repository->getTeacherOptions();
        $programs = $this->repository->getProgramOptions();
        $metrics  = $this->repository->getStudentMetrics();

        return compact('students', 'teachers', 'programs', 'metrics');
    }

    public function show(mixed $student): array
    {
        $student->load(['program', 'teacher', 'classPeriod.classMeetings', 'classes']);

        $recentActivity  = $this->repository->getRecentActivity($student->id);
        $progressStats   = $this->repository->getProgressStats($student->id);
        $latestTest      = $this->repository->getLatestTest($student->id);

        return array_merge(
            compact('student', 'recentActivity', 'latestTest'),
            $progressStats
        );
    }

    public function assignTeacher(mixed $student, ?int $teacherId): string
    {
        return $this->repository->assignTeacher($student, $teacherId);
    }

    public function quickUpdate(mixed $student, array $data): void
    {
        $this->repository->quickUpdate($student, $data);
    }

    public function bulkGenerateReferralCodes(): int
    {
        return $this->repository->bulkGenerateReferralCodes();
    }
}
