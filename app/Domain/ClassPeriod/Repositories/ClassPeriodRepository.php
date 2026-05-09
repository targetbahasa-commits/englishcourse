<?php

namespace App\Domain\ClassPeriod\Repositories;

interface ClassPeriodRepository
{
    public function listWithCounts(array $filters): array;

    public function getNextBatchNumber(int $programId): int;

    public function create(array $data): mixed;

    public function findOrFail(int $id): mixed;

    public function update(mixed $classPeriod, array $data): void;

    public function delete(mixed $classPeriod): void;

    public function getAllStudents(): array;

    public function getMeetingPivotStatus(mixed $classPeriod): array;

    public function toggleMeeting(mixed $classPeriod, int $meetingId, bool $currentStatus): void;

    public function attachMeeting(mixed $classPeriod, int $meetingId, bool $isOpen): void;

    public function findStudentOrFail(int $userId): mixed;

    public function assignStudent(mixed $classPeriod, mixed $user): void;

    public function removeStudent(mixed $classPeriod, mixed $user): void;
}
