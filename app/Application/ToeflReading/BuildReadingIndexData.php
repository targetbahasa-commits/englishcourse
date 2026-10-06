<?php

namespace App\Application\ToeflReading;

use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\ToeflReading\Repositories\ToeflReadingRepository;

class BuildReadingIndexData
{
    public function __construct(
        private readonly ToeflBatchResolver $batchResolver,
        private readonly ToeflReadingRepository $repository,
    ) {
    }

    public function handle($user): array
    {
        $meetings = $this->repository->getAllMeetings();
        $batchProgram = $this->batchResolver->resolveBatchProgramForToefl($user);
        $selectedClassPeriod = $this->batchResolver->resolveToeflSelectedClassPeriod($user);

        $scoresByMeeting = $user
            ? \App\Models\ToeflReadingScore::where('user_id', $user->id)->get()->keyBy('meeting_number')
            : collect();

        $batchLockMap = collect();
        if ($selectedClassPeriod) {
            $batchLockMap = collect($this->repository->getModuleLockMap($selectedClassPeriod->id, 'reading'));
        }

        $meetings = collect($meetings)->map(function ($meeting) use ($batchLockMap, $selectedClassPeriod, $scoresByMeeting) {
            $meeting->is_locked = $this->batchResolver->resolveToeflLockedState(
                $batchLockMap,
                (int) $meeting->meeting_number,
                (bool) $meeting->is_locked,
                (bool) $selectedClassPeriod
            );

            $userScore = $scoresByMeeting->get($meeting->meeting_number);
            $meeting->completed = ($userScore !== null);
            $meeting->user_score = $userScore ? $userScore->score : null;

            return $meeting;
        })->all();

        return [
            'meetings' => $meetings,
            'batchProgram' => $batchProgram,
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }
}