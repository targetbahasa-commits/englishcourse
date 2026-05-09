<?php

namespace App\Http\Controllers\Concerns;

use App\Application\ToeflShared\ToeflBatchResolver;

trait HandlesToeflBatchSelection
{
    protected function resolveBatchProgramForToefl($user)
    {
        return app(ToeflBatchResolver::class)->resolveBatchProgramForToefl($user);
    }

    protected function resolveSelectedClassPeriodForProgram($program)
    {
        return app(ToeflBatchResolver::class)->resolveSelectedClassPeriodForProgram($program);
    }

    protected function resolveToeflSelectedClassPeriod($user)
    {
        return app(ToeflBatchResolver::class)->resolveToeflSelectedClassPeriod($user);
    }

    protected function resolveToeflLockedState($batchLockMap, int $meetingNumber, bool $globalLocked, bool $useBatchRules = false): bool
    {
        return app(ToeflBatchResolver::class)->resolveToeflLockedState($batchLockMap, $meetingNumber, $globalLocked, $useBatchRules);
    }
}