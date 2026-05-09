<?php

namespace App\Domain\ToeflListening\Repositories;

interface ToeflListeningRepository
{
    public function getAllMeetings(): array;

    public function findMeetingByNumber(int $number): mixed;

    public function findMeetingByNumberOrFail(int $number): mixed;

    public function getModuleLockMap(int $classPeriodId, string $module): array;

    public function getScoreForUser(int $userId, int $meetingNumber, ?int $setNumber = null): mixed;

    public function getQuestions(int $meetingNumber, ?int $setNumber = null): array;

    public function getAvailableSets(int $meetingNumber): array;

    public function getMaxSetNumber(int $meetingNumber): ?int;

    public function createQuestion(array $data): void;

    public function deleteQuestionsByMeetingAndSet(int $meetingNumber, int $setNumber): bool;

    public function findQuestion(int $id): mixed;

    public function updateQuestion(int $id, array $data): void;

    public function deleteQuestion(int $id): void;

    public function findBatchRuleForMeeting(int $classPeriodId, string $module, int $meetingNumber): mixed;

    public function createBatchRule(array $data): void;

    public function updateBatchRule(int $id, bool $isOpen): void;

    public function findClassPeriod(int $classPeriodId): mixed;

    public function toggleMeetingLock(int $meetingNumber): void;

    public function toggleMeetingTranscript(int $meetingNumber): string;

    public function saveScore(array $criteria, array $data): void;

    public function updateTranscriptByMeetingAndSet(int $number, int $set, ?string $en, ?string $id): void;

    public function findFirstQuestionByMeetingAndSet(int $number, int $set): mixed;

    public function updateAudioByMeetingAndSet(int $number, int $set, string $audioPath): void;

    public function updateSingleTranscript(int $number, int $set, string $language, string $text): void;
}
