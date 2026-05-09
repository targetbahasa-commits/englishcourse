<?php

namespace App\Domain\IeltsWriting\Repositories;

interface IeltsWritingRepository
{
    public function findMeetingOrFail(int $id): mixed;

    public function createMeeting(array $data): void;

    public function updateMeeting(int $id, array $data): void;

    public function deleteMeeting(int $id): void;

    public function getMeetingsByTaskAndCategory(string $taskType, string $category): array;

    public function getMeetingsBetweenNumbers(int $min, int $max, string $category, int $taskType): array;

    public function getPracticeItemsInRange(int $min, int $max): array;

    public function getMeetingsByTaskAndViewType(int $taskType, string $category, string $viewType): array;

    public function createQuestion(array $data): void;

    public function updateQuestion(int $id, array $data): void;

    public function deleteQuestion(int $id): void;

    public function findSpeakingTopicOrFail(int $id): mixed;

    public function updateSpeakingTopic(int $id, array $data): void;

    public function toggleMeetingLock(int $id): bool;

    public function toggleSpeakingTopicLock(int $id): bool;

    public function findMeetingByNumber(int $number): mixed;

    public function reorderMeetings(array $order): void;
}
