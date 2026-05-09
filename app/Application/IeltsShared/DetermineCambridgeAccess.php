<?php

namespace App\Application\IeltsShared;

use App\Domain\IeltsShared\CambridgeAccessPolicy;

/**
 * @deprecated Use App\Domain\IeltsShared\CambridgeAccessPolicy directly.
 */
class DetermineCambridgeAccess
{
    public function __construct(
        private readonly CambridgeAccessPolicy $policy,
    ) {}

    public function handle(mixed $user, int $edition, ?int $testId = null): bool
    {
        return $this->policy->canAccess($user, $edition, $testId);
    }
}