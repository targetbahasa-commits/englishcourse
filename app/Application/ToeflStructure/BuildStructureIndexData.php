<?php

namespace App\Application\ToeflStructure;

use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;

class BuildStructureIndexData
{
    public function __construct(
        private readonly ToeflBatchResolver $batchResolver,
        private readonly ToeflStructureRepository $repository,
    ) {
    }

    public function handle($user): array
    {
        $topics = $this->repository->getAllTopics();
        $batchProgram = $this->batchResolver->resolveBatchProgramForToefl($user);
        $selectedClassPeriod = $this->batchResolver->resolveToeflSelectedClassPeriod($user);

        if ($selectedClassPeriod) {
            $batchLockMap = collect($this->repository->getModuleLockMap($selectedClassPeriod->id, 'structure'));

            $topics = collect($topics)->map(function ($topic) use ($batchLockMap, $selectedClassPeriod) {
                $topic->is_locked = $this->batchResolver->resolveToeflLockedState(
                    $batchLockMap,
                    (int) $topic->meeting_number,
                    (bool) $topic->is_locked,
                    (bool) $selectedClassPeriod
                );

                return $topic;
            })->all();
        }

        return [
            'topics' => $topics,
            'batchProgram' => $batchProgram,
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }
}