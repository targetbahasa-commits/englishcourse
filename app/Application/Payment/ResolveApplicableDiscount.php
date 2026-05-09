<?php

namespace App\Application\Payment;

use App\Domain\Payment\DiscountPolicy;
use App\Domain\Payment\DiscountResult;

/**
 * @deprecated Use App\Domain\Payment\DiscountPolicy directly.
 */
class ResolveApplicableDiscount
{
    public function __construct(
        private readonly DiscountPolicy $policy,
    ) {}

    public function resolve(mixed $user, mixed $program, int $baseAmount): DiscountResult
    {
        return $this->policy->resolve($user, $program, $baseAmount);
    }
}
