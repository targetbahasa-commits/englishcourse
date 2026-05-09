<?php

namespace App\Application\ToeflShared;

use App\Domain\ToeflShared\Repositories\ToeflSharedRepository;

class ToeflBatchResolver
{
    public function __construct(
        private readonly ToeflSharedRepository $repository
    ) {}

    public function resolveBatchProgramForToefl($user)
    {
        $program = null;

        if ($user && $user->program_id) {
            $program = $this->repository->findProgramByIdWithClassPeriods($user->program_id);
        }

        if (!$program) {
            $program = $this->repository->findToeflProgramWithClassPeriods();
        }

        return $program;
    }

    public function resolveSelectedClassPeriodForProgram($program)
    {
        if (!$program || empty($program->period)) {
            return null;
        }

        return $program->classPeriods->firstWhere('name', $program->period);
    }

    public function resolveToeflSelectedClassPeriod($user)
    {
        $batchProgram = $this->resolveBatchProgramForToefl($user);

        return $this->resolveSelectedClassPeriodForProgram($batchProgram);
    }

    public function resolveToeflLockedState($batchLockMap, int $meetingNumber, bool $globalLocked, bool $useBatchRules = false): bool
    {
        if ($batchLockMap && $batchLockMap->has($meetingNumber)) {
            return !((bool) $batchLockMap->get($meetingNumber));
        }

        if ($useBatchRules) {
            return true;
        }

        return $globalLocked;
    }
}