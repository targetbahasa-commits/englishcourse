<?php

namespace App\Domain\GrammarWriting\Repositories;

interface GrammarWritingRepository
{
    // Question queries
    public function getQuestionsByMeetingExcludingParagraph(int $meetingNumber): array;

    public function getAllQuestionsByMeeting(int $meetingNumber): array;

    public function getQuestionsByMeetingWithNullSection(int $meetingNumber): array;

    public function getQuestionsByMeetingAndSection(int $meetingNumber, string $section): array;

    public function getLegacyQuestionsByMeeting(int $meetingNumber, ?string $section = null): array;

    public function getParagraphQuestion(int $meetingNumber, bool $useSection = true): mixed;

    public function getQuestionsBySectionForMeeting(int $meetingNumber, string $section): array;

    public function getVocabularyByMeeting(int $meetingNumber): array;

    public function createQuestion(array $data): void;

    public function updateQuestion(int $id, array $data): void;

    public function deleteQuestion(int $id): void;

    // Vocabulary
    public function createVocabulary(array $data): void;

    public function updateVocabulary(int $id, array $data): void;

    public function deleteVocabulary(int $id): void;

    // Program & meeting
    public function findProgramBySlugWithMeetingsAndClassPeriods(string $slug): mixed;

    public function findProgramByIdWithClassPeriods(int $id): mixed;

    public function updateProgram(int $id, array $data): void;

    /** @return array<int, mixed> meeting_number => score */
    public function getScoresForUser(?int $userId): array;

    public function findMeetingOrFail(int $id): mixed;

    public function findClassPeriodForProgram(int $classPeriodId, int $programId): mixed;

    public function updateMeeting(int $id, array $data): void;

    public function toggleMeetingLock(int $meetingId, ?int $classPeriodId): array;
}
