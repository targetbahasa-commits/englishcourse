<?php

namespace App\Domain\IeltsReading\Repositories;

interface IeltsReadingRepository
{
    public function findProgramBySlugWithMeetings(string $slug): mixed;

    public function findMeetingByProgramAndNumber(int $programId, int $meetingNumber): mixed;

    public function getPassagesByMaterialWithQuestions(int $materialId): array;

    public function getQuestionsByType(array $types): array;

    public function createPassage(array $data): void;

    public function updatePassage(int $id, array $data): void;

    public function deletePassage(int $id): void;

    public function createQuestion(array $data): void;

    public function updateQuestion(int $id, array $data): void;

    public function deleteQuestion(int $id): void;

    public function createMeeting(int $programId, array $data): void;

    public function reorderMeetings(array $meetingIds): void;
}
