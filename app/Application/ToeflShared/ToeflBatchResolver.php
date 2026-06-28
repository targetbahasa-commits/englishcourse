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

    public function resolveSelectedClassPeriodForProgram($program, $user = null)
    {
        if (!$program) {
            return null;
        }

        if ($user && $user->isStudent()) {
            $enrollment = $user->enrollments()->where('program_id', $program->id)->whereHas('classPeriod')->first();
            if ($enrollment) {
                return $enrollment->classPeriod->load('classMeetings');
            }
        }

        if ($program->active_class_period_id) {
            $period = $program->classPeriods->firstWhere('id', $program->active_class_period_id);
            return $period ? $period->load('classMeetings') : null;
        }

        return null;
    }

    public function resolveToeflSelectedClassPeriod($user)
    {
        $batchProgram = $this->resolveBatchProgramForToefl($user);

        return $this->resolveSelectedClassPeriodForProgram($batchProgram, $user);
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