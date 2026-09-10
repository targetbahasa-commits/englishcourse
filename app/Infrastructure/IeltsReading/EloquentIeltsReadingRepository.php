<?php

namespace App\Infrastructure\IeltsReading;

use App\Domain\IeltsReading\Repositories\IeltsReadingRepository;
use App\Models\IeltsReadingPassage;
use App\Models\IeltsReadingQuestion;
use App\Models\Meeting;
use App\Models\Program;

class EloquentIeltsReadingRepository implements IeltsReadingRepository
{
    public function findProgramBySlugWithMeetings(string $slug): mixed
    {
        return Program::where('slug', $slug)->with('meetings')->first();
    }

    public function findMeetingByProgramAndNumber(int $programId, int $meetingNumber): mixed
    {
        return Meeting::where('program_id', $programId)->where('meeting_number', $meetingNumber)->first();
    }

    public function getPassagesByMaterialWithQuestions(int $materialId): array
    {
        return IeltsReadingPassage::where('material_id', $materialId)
            ->with(['questions' => function ($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get()->all();
    }

    public function getQuestionsByType(array $types): array
    {
        return IeltsReadingQuestion::whereIn('type', $types)
            ->whereHas('passage', function ($query) {
                $query->where('material_id', '<', 100);
            })
            ->with('passage')
            ->orderBy('passage_id')
            ->orderBy('order')
            ->get()->all();
    }

    public function createPassage(array $data): void
    {
        IeltsReadingPassage::create($data);
    }

    public function updatePassage(int $id, array $data): void
    {
        IeltsReadingPassage::findOrFail($id)->update($data);
    }

    public function deletePassage(int $id): void
    {
        IeltsReadingPassage::findOrFail($id)->delete();
    }

    public function createQuestion(array $data): void
    {
        IeltsReadingQuestion::create($data);
    }

    public function updateQuestion(int $id, array $data): void
    {
        IeltsReadingQuestion::findOrFail($id)->update($data);
    }

    public function deleteQuestion(int $id): void
    {
        IeltsReadingQuestion::findOrFail($id)->delete();
    }

    public function createMeeting(int $programId, array $data): void
    {
        Meeting::create(array_merge(['program_id' => $programId], $data));
    }

    public function reorderMeetings(array $meetingIds): void
    {
        foreach ($meetingIds as $index => $id) {
            Meeting::where('id', $id)->update(['meeting_number' => $index + 1]);
        }
    }
}
