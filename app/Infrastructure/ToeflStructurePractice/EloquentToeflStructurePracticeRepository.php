<?php

namespace App\Infrastructure\ToeflStructurePractice;

use App\Domain\ToeflStructurePractice\Repositories\ToeflStructurePracticeRepository;
use App\Models\ToeflStructureMeeting;
use App\Models\ToeflStructureQuestion;

class EloquentToeflStructurePracticeRepository implements ToeflStructurePracticeRepository
{
    public function getActivePracticeExercises(int $limit): array
    {
        return ToeflStructureMeeting::query()
            ->where(function ($q) {
                $q->where('description', 'structure_practice')
                  ->orWhereIn('meeting_number', [62, 67, 68]);
            })
            ->orderByRaw('CASE WHEN meeting_number = 62 THEN 1 WHEN meeting_number = 67 THEN 2 WHEN meeting_number = 68 THEN 3 ELSE meeting_number END')
            ->take($limit)
            ->get()->all();
    }

    public function countQuestionsByMeeting(int $meetingId): int
    {
        return ToeflStructureQuestion::where('section_id', $meetingId)->count();
    }
}
