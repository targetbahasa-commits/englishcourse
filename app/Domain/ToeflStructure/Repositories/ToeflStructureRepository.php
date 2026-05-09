<?php

namespace App\Domain\ToeflStructure\Repositories;

interface ToeflStructureRepository
{
    public function getAllTopics(): array;

    public function findMeetingByNumber(int $number): mixed;

    public function findMeetingByNumberOrFail(int $number): mixed;

    public function getModuleLockMap(int $classPeriodId, string $module): array;

    public function findBatchRuleForMeeting(int $classPeriodId, string $module, int $meetingNumber): mixed;

    public function createBatchRule(array $data): void;

    public function updateBatchRule(int $id, bool $isOpen): void;

    public function findClassPeriod(int $classPeriodId): mixed;

    public function getRelatedExercises(int $mainNumber, string $title): array;

    public function getQuestionsByMeeting(int $meetingId): array;

    public function createQuestion(array $data): void;

    public function updateQuestion(int $id, array $data): void;

    public function deleteQuestion(int $id): void;

    public function reorderMeetings(array $meetingIds): void;

    public function createMeeting(int $meetingNumber, string $title): void;

    public function getMaxExerciseNumber(): ?int;

    public function createExerciseMeeting(array $data): void;

    public function getExerciseMeetingsByNumber(int $number): array;

    public function deleteExerciseMeeting(int $targetNumber): bool;

    public function updateMeeting(int $id, int $meetingNumber, string $title): void;

    public function deleteMeeting(int $id): void;

    public function toggleMeetingLockById(int $id): void;

    public function countMeetingsByTitlePattern(string $pattern): int;
}
