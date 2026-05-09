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
            ->where('meeting_number', '>', 50)
            ->orderBy('meeting_number')
            ->take($limit)
            ->get()->all();
    }

    public function countQuestionsByMeeting(int $meetingId): int
    {
        return ToeflStructureQuestion::where('section_id', $meetingId)->count();
    }
}
