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

        if ($selectedClassPeriod) {
            $batchLockMap = collect($this->repository->getModuleLockMap($selectedClassPeriod->id, 'reading'));

            $meetings = collect($meetings)->map(function ($meeting) use ($batchLockMap, $selectedClassPeriod) {
                $meeting->is_locked = $this->batchResolver->resolveToeflLockedState(
                    $batchLockMap,
                    (int) $meeting->meeting_number,
                    (bool) $meeting->is_locked,
                    (bool) $selectedClassPeriod
                );

                return $meeting;
            })->all();
        }

        return [
            'meetings' => $meetings,
            'batchProgram' => $batchProgram,
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }
}