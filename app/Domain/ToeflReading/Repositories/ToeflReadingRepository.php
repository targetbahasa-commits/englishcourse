<?php

namespace App\Domain\ToeflReading\Repositories;

interface ToeflReadingRepository
{
    public function getAllMeetings(): array;

    public function findMeetingByNumber(int $number): mixed;

    public function findMeetingByNumberOrFail(int $number): mixed;

    public function getModuleLockMap(int $classPeriodId, string $module): array;

    public function getPassagesWithQuestions(int $meetingId): array;

    public function findBatchRuleForMeeting(int $classPeriodId, string $module, int $meetingNumber): mixed;

    public function createBatchRule(array $data): void;

    public function updateBatchRule(int $id, bool $isOpen): void;

    public function findClassPeriod(int $classPeriodId): mixed;

    public function getQuestionsByMeeting(int $meetingId): array;

    public function getScoreForUser(int $userId, int $meetingNumber): mixed;

    public function deleteScoreForUser(int $userId, int $meetingNumber): bool;

    public function saveScore(int $userId, int $meetingNumber, array $data): void;

    public function createPassage(array $data): void;

    public function createQuestion(array $data): void;

    public function reorderMeetings(array $meetingIds): void;

    public function createMeeting(int $meetingNumber, string $title): void;

    public function updateMeeting(int $id, int $meetingNumber, string $title): void;

    public function deleteMeeting(int $id): void;

    public function toggleMeetingLockById(int $id): void;

    public function updatePassage(int $id, array $data): void;

    public function deletePassage(int $id): void;

    public function updateQuestion(int $id, array $data): void;

    public function deleteQuestion(int $id): void;
}
