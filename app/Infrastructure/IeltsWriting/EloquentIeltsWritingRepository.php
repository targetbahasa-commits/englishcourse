<?php

namespace App\Infrastructure\IeltsWriting;

use App\Domain\IeltsWriting\Repositories\IeltsWritingRepository;
use App\Models\IeltsSpeakingTopic;
use App\Models\IeltsWritingMeeting;
use App\Models\IeltsWritingQuestion;

class EloquentIeltsWritingRepository implements IeltsWritingRepository
{
    public function findMeetingOrFail(int $id): mixed
    {
        return IeltsWritingMeeting::findOrFail($id);
    }

    public function createMeeting(array $data): void
    {
        IeltsWritingMeeting::create($data);
    }

    public function updateMeeting(int $id, array $data): void
    {
        IeltsWritingMeeting::findOrFail($id)->update($data);
    }

    public function deleteMeeting(int $id): void
    {
        IeltsWritingMeeting::findOrFail($id)->delete();
    }

        public function getMeetingsByTaskAndCategory(string $taskType, string $category): array
    {
        return IeltsWritingMeeting::where('task_type', $taskType)
            ->where('category', $category)
            ->orderBy('meeting_number')
            ->get()
            ->all();
    }

        public function getMeetingsBetweenNumbers(int $min, int $max, string $category, int $taskType): array
    {
        return IeltsWritingMeeting::whereBetween('meeting_number', [$min, $max])
            ->where('category', $category)
            ->where('task_type', $taskType)
            ->orderBy('meeting_number')
            ->get()
            ->all();
    }

        public function getPracticeItemsInRange(int $min, int $max): array
    {
        return IeltsWritingMeeting::where('category', 'practice_item')
            ->whereBetween('meeting_number', [$min, $max])
            ->orderBy('title')
            ->get()
            ->all();
    }

        public function getMeetingsByTaskAndViewType(int $taskType, string $category, string $viewType): array
    {
        return IeltsWritingMeeting::where('task_type', $taskType)
            ->where('category', $category)
            ->where('view_type', $viewType)
            ->orderBy('meeting_number')
            ->get()
            ->all();
    }

    public function createQuestion(array $data): void
    {
        IeltsWritingQuestion::create($data);
    }

    public function updateQuestion(int $id, array $data): void
    {
        IeltsWritingQuestion::findOrFail($id)->update($data);
    }

    public function deleteQuestion(int $id): void
    {
        IeltsWritingQuestion::findOrFail($id)->delete();
    }

    public function findSpeakingTopicOrFail(int $id): mixed
    {
        return IeltsSpeakingTopic::findOrFail($id);
    }

    public function updateSpeakingTopic(int $id, array $data): void
    {
        IeltsSpeakingTopic::findOrFail($id)->update($data);
    }

    public function toggleMeetingLock(int $id): bool
    {
        $meeting = IeltsWritingMeeting::findOrFail($id);
        $meeting->update(['is_locked' => !$meeting->is_locked]);
        return (bool) $meeting->is_locked;
    }

    public function toggleSpeakingTopicLock(int $id): bool
    {
        $topic = IeltsSpeakingTopic::findOrFail($id);
        $topic->update(['is_locked' => !$topic->is_locked]);
        return (bool) $topic->is_locked;
    }

    public function findMeetingByNumber(int $number): mixed
    {
        return IeltsWritingMeeting::where('meeting_number', $number)->first();
    }

    public function reorderMeetings(array $order): void
    {
        foreach ($order as $item) {
            IeltsWritingMeeting::where('id', $item['id'])->update(['meeting_number' => $item['meeting_number']]);
        }
    }
}
