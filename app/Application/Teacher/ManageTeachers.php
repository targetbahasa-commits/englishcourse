<?php

namespace App\Application\Teacher;

use App\Domain\Teacher\Repositories\TeacherRepository;
use Illuminate\Support\Collection;

class ManageTeachers
{
    public function __construct(
        private readonly TeacherRepository $repository
    ) {
    }

    public function searchTeachers(array $filters = []): mixed
    {
        return $this->repository->searchTeachers($filters);
    }

    public function getUnassignedStudents(): Collection
    {
        return collect($this->repository->getUnassignedStudents());
    }

    public function getUnassignedClasses(): Collection
    {
        return collect($this->repository->getUnassignedClasses());
    }

    public function getTeacherDetails(int $teacherId): mixed
    {
        return $this->repository->findTeacher($teacherId);
    }

    public function countTeachers(): int
    {
        return $this->repository->countTeachers();
    }

    public function getTeacherRecentEvaluations(int $teacherId, int $limit = 5): array
    {
        return $this->repository->getTeacherRecentEvaluations($teacherId, $limit);
    }

    public function getTeacherAverageRating(int $teacherId): float
    {
        return $this->repository->getTeacherAverageRating($teacherId);
    }

    public function getUpcomingClasses(int $teacherId): array
    {
        return $this->repository->getUpcomingClassesForTeacher($teacherId);
    }

    public function assignStudent(int $teacherId, int $studentId): void
    {
        $this->repository->assignStudentToTeacher($teacherId, $studentId);
    }

    public function unassignStudent(int $teacherId, int $studentId): void
    {
        $this->repository->unassignStudent($teacherId, $studentId);
    }

    public function assignClass(int $teacherId, int $classPeriodId): void
    {
        $this->repository->assignClassToTeacher($teacherId, $classPeriodId);
    }
}
