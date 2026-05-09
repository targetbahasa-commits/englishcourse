<?php

namespace App\Application\ToeflListening;

use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;

class BuildListeningIndexData
{
    public function __construct(
        private readonly ToeflBatchResolver $batchResolver,
        private readonly ToeflListeningRepository $repository,
    ) {
    }

    public function handle($user): array
    {
        $meetings = [];
        $batchProgram = $this->batchResolver->resolveBatchProgramForToefl($user);
        $selectedClassPeriod = $this->batchResolver->resolveToeflSelectedClassPeriod($user);
        $batchLockMap = collect();

        if ($selectedClassPeriod) {
            $batchLockMap = collect($this->repository->getModuleLockMap($selectedClassPeriod->id, 'listening'));
        }

        $dbMeetings = $this->repository->getAllMeetings();

        if ($dbMeetings === []) {
            for ($number = 1; $number <= 20; $number++) {
                $meeting = $this->repository->findMeetingByNumber($number);
                $score = $this->repository->getScoreForUser($user->id, $number);

                $meetings[] = [
                    'number' => $number,
                    'is_locked' => $this->batchResolver->resolveToeflLockedState(
                        $batchLockMap,
                        $number,
                        $meeting ? (bool) $meeting->is_locked : false,
                        (bool) $selectedClassPeriod,
                    ),
                    'transcript_enabled' => $meeting ? $meeting->transcript_enabled : false,
                    'completed' => $score !== null,
                    'score' => $score ? $score->score : null,
                ];
            }
        } else {
            foreach ($dbMeetings as $dbMeeting) {
                $score = $this->repository->getScoreForUser($user->id, $dbMeeting->meeting_number);

                $meetings[] = [
                    'number' => $dbMeeting->meeting_number,
                    'is_locked' => $this->batchResolver->resolveToeflLockedState(
                        $batchLockMap,
                        (int) $dbMeeting->meeting_number,
                        (bool) $dbMeeting->is_locked,
                        (bool) $selectedClassPeriod,
                    ),
                    'transcript_enabled' => $dbMeeting->transcript_enabled,
                    'completed' => $score !== null,
                    'score' => $score ? $score->score : null,
                ];
            }
        }

        return [
            'meetings' => $meetings,
            'batchProgram' => $batchProgram,
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }
}