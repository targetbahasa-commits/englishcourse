<?php

namespace App\Application\Progress;

use App\Domain\Progress\Repositories\ProgressRepository;

class GetUserProgress
{
    public function __construct(
        private readonly ProgressRepository $repository
    ) {
    }

    public function buildProgressData(mixed $user): array
    {
        $enrollments  = $user->enrollments()->with('program')->get();
        $progressData = [];

        foreach ($enrollments as $enrollment) {
            $programId = $enrollment->program_id;
            $scores    = collect($this->repository->getMeetingScores($user->id, $programId));

            $total = $scores->count();
            $avg   = $scores->avg('score') ?? 0;

            $skillScores = [
                'Module 1' => $scores->whereIn('meeting_number', [1, 2, 3, 4, 5])->avg('score') ?? 0,
                'Module 2' => $scores->whereIn('meeting_number', [6, 7, 8, 9, 10])->avg('score') ?? 0,
                'Module 3' => $scores->whereIn('meeting_number', [11, 12, 13, 14, 15])->avg('score') ?? 0,
                'Module 4' => $scores->whereIn('meeting_number', [16, 17, 18, 19, 20])->avg('score') ?? 0,
            ];

            $progressData[] = [
                'program'           => $enrollment->program,
                'totalAssignments'  => $total,
                'averageScore'      => $avg,
                'meetingScores'     => $scores,
                'skillScores'       => $skillScores,
                'id'                => $programId,
            ];
        }

        return $progressData;
    }

    public function getFreeTests(mixed $user): array
    {
        return $this->repository->getFreeTestResults($user->id);
    }
}
