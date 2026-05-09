<?php

namespace App\Infrastructure\Progress;

use App\Domain\Progress\Repositories\ProgressRepository;
use App\Models\FreeTestResult;
use App\Models\MeetingScore;

class EloquentProgressRepository implements ProgressRepository
{
    public function getFreeTestResults(int $userId): array
    {
        return FreeTestResult::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()->all();
    }

    public function getMeetingScores(int $userId, int $programId): array
    {
        return MeetingScore::where('user_id', $userId)
            ->where('program_id', $programId)
            ->orderBy('meeting_number', 'asc')
            ->get()->all();
    }
}
