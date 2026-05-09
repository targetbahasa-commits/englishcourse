<?php

namespace App\Domain\Teacher\Repositories;


interface TeacherRepository
{
    public function searchTeachers(array $filters = []): mixed;

    public function getUnassignedStudents(): array;

    public function getUnassignedClasses(): array;

    public function findTeacher(int $id): mixed;

    public function assignStudentToTeacher(int $teacherId, int $studentId): void;

    public function unassignStudent(int $teacherId, int $studentId): void;

    public function assignClassToTeacher(int $teacherId, int $classPeriodId): void;

    // Admin — Teacher Evaluations
    public function listEvaluations(array $filters, int $perPage): mixed;

    public function getTeachersWithEvaluations(): array;

    public function getAverageRating(): float;

    public function countEvaluations(): int;

    public function getTopTeachers(int $limit): array;
}
