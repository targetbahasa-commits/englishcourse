<?php

namespace App\Domain\IeltsShared\Repositories;

interface IeltsSharedRepository
{
    public function findProgramByIdWithClassPeriods(int $programId): mixed;

    public function findFirstIeltsProgramWithClassPeriods(): mixed;

    public function findMeetingOrFail(int $id): mixed;

    public function updateMeeting(int $id, array $data): void;

    public function deleteMeeting(int $id): void;

    public function hasEnrollmentForPrograms(int $userId, string $editionSlug, ?string $testSlug): bool;

    public function findOrCreateMockupByTestId(string $testId): mixed;

    public function toggleMeetingLock(int $id): void;
}
