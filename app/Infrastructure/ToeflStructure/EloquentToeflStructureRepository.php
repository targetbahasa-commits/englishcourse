<?php

namespace App\Infrastructure\ToeflStructure;

use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;
use App\Models\ClassPeriod;
use App\Models\ClassPeriodToeflMeeting;
use App\Models\ToeflStructureMeeting;
use App\Models\ToeflStructureQuestion;

class EloquentToeflStructureRepository implements ToeflStructureRepository
{
    public function getAllTopics(): array
    {
        return ToeflStructureMeeting::where('meeting_number', '<', 50)->orderBy('meeting_number')->get()->all();
    }

    public function findMeetingByNumber(int $number): mixed
    {
        return ToeflStructureMeeting::where('meeting_number', $number)->first();
    }

    public function findMeetingByNumberOrFail(int $number): mixed
    {
        return ToeflStructureMeeting::where('meeting_number', $number)->firstOrFail();
    }

    public function getModuleLockMap(int $classPeriodId, string $module): array
    {
        return ClassPeriodToeflMeeting::where('class_period_id', $classPeriodId)
            ->where('module', $module)
            ->pluck('is_open', 'meeting_number')
            ->all();
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

    public function getRelatedExercises(int $mainNumber, string $title): array
    {
        return ToeflStructureMeeting::where('meeting_number', $mainNumber)
            ->orWhere(function ($query) use ($mainNumber, $title) {
                $query->where('meeting_number', '>', 50)
                    ->where(function ($sub) use ($mainNumber, $title) {
                        $sub->where('title', 'like', $title . '%')
                            ->orWhere('description', 'parent:' . $mainNumber)
                            ->orWhere('description', 'like', 'parent:' . $mainNumber . ';%')
                            ->orWhere('description', 'like', 'parent:' . $mainNumber . ' %')
                            ->orWhere('description', 'like', '%,parent:' . $mainNumber . '%')
                            ->orWhere('description', 'like', '%parent_meeting:' . $mainNumber . '%');
                    });
            })
            ->orderBy('meeting_number')
            ->get()->all();
    }

    public function getQuestionsByMeeting(int $meetingId): array
    {
        return ToeflStructureQuestion::where('section_id', $meetingId)
            ->orderBy('question_number')
            ->get()->all();
    }

    public function createQuestion(array $data): void
    {
        ToeflStructureQuestion::create($data);
    }

    public function updateQuestion(int $id, array $data): void
    {
        ToeflStructureQuestion::findOrFail($id)->update($data);
    }

    public function deleteQuestion(int $id): void
    {
        ToeflStructureQuestion::findOrFail($id)->delete();
    }

    public function reorderMeetings(array $meetingIds): void
    {
        foreach ($meetingIds as $index => $id) {
            ToeflStructureMeeting::where('id', $id)->update(['meeting_number' => $index + 1]);
        }
    }

    public function createMeeting(int $meetingNumber, string $title): void
    {
        ToeflStructureMeeting::where('meeting_number', '>=', $meetingNumber)->increment('meeting_number');

        ToeflStructureMeeting::create([
            'meeting_number' => $meetingNumber,
            'title' => $title,
        ]);
    }

    public function getMaxExerciseNumber(): ?int
    {
        return ToeflStructureMeeting::where('meeting_number', '>', 50)->max('meeting_number');
    }

    public function createExerciseMeeting(array $data): void
    {
        ToeflStructureMeeting::create($data);
    }

    public function getExerciseMeetingsByNumber(int $number): array
    {
        return ToeflStructureMeeting::where('meeting_number', '>', 50)
            ->orderBy('meeting_number')
            ->get()->all();
    }

    public function deleteExerciseMeeting(int $targetNumber): bool
    {
        $meeting = ToeflStructureMeeting::where('meeting_number', $targetNumber)->first();

        if (!$meeting) {
            return false;
        }

        $meeting->delete();

        return true;
    }

    public function updateMeeting(int $id, int $meetingNumber, string $title): void
    {
        ToeflStructureMeeting::findOrFail($id)->update([
            'meeting_number' => $meetingNumber,
            'title' => $title,
        ]);
    }

    public function deleteMeeting(int $id): void
    {
        ToeflStructureMeeting::findOrFail($id)->delete();
    }

    public function toggleMeetingLockById(int $id): void
    {
        $meeting = ToeflStructureMeeting::findOrFail($id);
        $meeting->update(['is_locked' => !$meeting->is_locked]);
    }

    public function countMeetingsByTitlePattern(string $pattern): int
    {
        return ToeflStructureMeeting::where('title', 'like', $pattern)->count();
    }
}
