<?php

namespace App\Infrastructure\ToeflReading;

use App\Domain\ToeflReading\Repositories\ToeflReadingRepository;
use App\Models\ClassPeriod;
use App\Models\ClassPeriodToeflMeeting;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;
use App\Models\ToeflReadingScore;

class EloquentToeflReadingRepository implements ToeflReadingRepository
{
    public function getAllMeetings(): array
    {
        return ToeflReadingMeeting::orderBy('meeting_number')->get()->all();
    }

    public function findMeetingByNumber(int $number): mixed
    {
        return ToeflReadingMeeting::where('meeting_number', $number)->first();
    }

    public function findMeetingByNumberOrFail(int $number): mixed
    {
        return ToeflReadingMeeting::where('meeting_number', $number)->firstOrFail();
    }

    public function getModuleLockMap(int $classPeriodId, string $module): array
    {
        return ClassPeriodToeflMeeting::where('class_period_id', $classPeriodId)
            ->where('module', $module)
            ->pluck('is_open', 'meeting_number')
            ->all();
    }

    public function getPassagesWithQuestions(int $meetingId): array
    {
        return ToeflReadingPassage::where('meeting_id', $meetingId)
            ->with(['questions' => function ($query) {
                $query->orderBy('question_number');
            }])
            ->orderBy('passage_number')
            ->get()->all();
    }

    public function findBatchRuleForMeeting(int $classPeriodId, string $module, int $meetingNumber): mixed
    {
        return ClassPeriodToeflMeeting::where('class_period_id', $classPeriodId)
            ->where('module', $module)
            ->where('meeting_number', $meetingNumber)
            ->first();
    }

    public function createBatchRule(array $data): void
    {
        ClassPeriodToeflMeeting::create($data);
    }

    public function updateBatchRule(int $id, bool $isOpen): void
    {
        ClassPeriodToeflMeeting::findOrFail($id)->update(['is_open' => $isOpen]);
    }

    public function findClassPeriod(int $classPeriodId): mixed
    {
        return ClassPeriod::find($classPeriodId);
    }

    public function getQuestionsByMeeting(int $meetingId): array
    {
        return ToeflReadingQuestion::whereHas('passage', function ($query) use ($meetingId) {
            $query->where('meeting_id', $meetingId);
        })->get()->all();
    }

    public function getScoreForUser(int $userId, int $meetingNumber): mixed
    {
        return ToeflReadingScore::where('user_id', $userId)
            ->where('meeting_number', $meetingNumber)
            ->first();
    }

    public function deleteScoreForUser(int $userId, int $meetingNumber): bool
    {
        return (bool) ToeflReadingScore::where('user_id', $userId)
            ->where('meeting_number', $meetingNumber)
            ->delete();
    }

    public function saveScore(int $userId, int $meetingNumber, array $data): void
    {
        ToeflReadingScore::updateOrCreate(
            ['user_id' => $userId, 'meeting_number' => $meetingNumber],
            $data
        );
    }

    public function createPassage(array $data): void
    {
        ToeflReadingPassage::create($data);
    }

    public function createQuestion(array $data): void
    {
        ToeflReadingQuestion::create($data);
    }

    public function reorderMeetings(array $meetingIds): void
    {
        foreach ($meetingIds as $index => $id) {
            ToeflReadingMeeting::where('id', $id)->update(['meeting_number' => $index + 1]);
        }
    }

    public function createMeeting(int $meetingNumber, string $title): void
    {
        ToeflReadingMeeting::where('meeting_number', '>=', $meetingNumber)->increment('meeting_number');

        ToeflReadingMeeting::create([
            'meeting_number' => $meetingNumber,
            'title' => $title,
        ]);
    }

    public function updateMeeting(int $id, int $meetingNumber, string $title): void
    {
        ToeflReadingMeeting::findOrFail($id)->update([
            'meeting_number' => $meetingNumber,
            'title' => $title,
        ]);
    }

    public function deleteMeeting(int $id): void
    {
        ToeflReadingMeeting::findOrFail($id)->delete();
    }

    public function toggleMeetingLockById(int $id): void
    {
        $meeting = ToeflReadingMeeting::findOrFail($id);
        $meeting->update(['is_locked' => !$meeting->is_locked]);
    }

    public function updatePassage(int $id, array $data): void
    {
        ToeflReadingPassage::findOrFail($id)->update($data);
    }

    public function deletePassage(int $id): void
    {
        ToeflReadingPassage::findOrFail($id)->delete();
    }

    public function updateQuestion(int $id, array $data): void
    {
        ToeflReadingQuestion::findOrFail($id)->update($data);
    }

    public function deleteQuestion(int $id): void
    {
        ToeflReadingQuestion::findOrFail($id)->delete();
    }
}
