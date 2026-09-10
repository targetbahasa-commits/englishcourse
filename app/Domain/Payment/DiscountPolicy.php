<?php

namespace App\Domain\Payment;

use App\Domain\Payment\Repositories\PaymentRepository;

class DiscountPolicy
{
    public function __construct(
        private readonly PaymentRepository $repository,
    ) {}

    public function resolve(mixed $user, mixed $program, int $baseAmount): DiscountResult
    {
        if ($baseAmount <= 0) {
            return DiscountResult::none();
        }

        $discounts = $this->repository->getDiscountsForProgram($program->id);

        $best = null;
        $bestAmount = 0;

        foreach ($discounts as $discount) {
            if (!$this->isApplicable($discount, $user)) {
                continue;
            }

            $calculated = $this->calculateAmount($discount, $baseAmount);
            if ($calculated > $bestAmount) {
                $bestAmount = $calculated;
                $best = $discount;
            }
        }

        $partnerResult = $this->resolvePartnerDiscount($user, $baseAmount);
        if ($partnerResult && $partnerResult->amount > $bestAmount) {
            return $partnerResult;
        }

        if (!$best || $bestAmount <= 0) {
            return DiscountResult::none();
        }

        return new DiscountResult(
            amount: $bestAmount,
            label: $best->label,
            meta: [
                'id'             => $best->id,
                'label'          => $best->label,
                'type'           => $best->type,
                'discount_type'  => $best->discount_type,
                'discount_value' => (int) $best->discount_value,
                'discount_amount' => $bestAmount,
            ],
        );
    }

    /**
     * A partner's flat corporate rate is a distinct discount source from
     * the ProgramDiscount rules above (negotiated per-company rather than
     * a promotional rule), so it's resolved separately and compared by
     * amount alongside them, same "largest wins" logic.
     */
    private function resolvePartnerDiscount(mixed $user, int $baseAmount): ?DiscountResult
    {
        $partner = $user->partner ?? null;
        if (!$partner || !$partner->is_active) {
            return null;
        }

        $amount = $partner->discountAmountFor($baseAmount);
        if ($amount <= 0) {
            return null;
        }

        return new DiscountResult(
            amount: $amount,
            label: 'Kerjasama Instansi: ' . $partner->name,
            meta: [
                'source'          => 'partner',
                'partner_id'      => $partner->id,
                'label'           => 'Kerjasama Instansi: ' . $partner->name,
                'discount_type'   => $partner->discount_type,
                'discount_value'  => (int) $partner->discount_value,
                'discount_amount' => $amount,
            ],
        );
    }

    public function isApplicable(mixed $discount, mixed $user): bool
    {
        $activeRole = strtolower((string) ($user->active_role ?? $user->role ?? ''));

        return match ($discount->type) {
            'guest'    => $activeRole === 'guest',
            'student'  => $activeRole === 'student',
            'new_user' => $this->isNewUserEligible($user),
            'referral' => !empty($user->referred_by_id),
            'holiday'  => $this->isHolidayEligible($discount),
            'region'   => false,
            default    => false,
        };
    }

    private function isNewUserEligible(mixed $user): bool
    {
        if ($this->repository->hasUserPaidPayments($user->id)) {
            return false;
        }

        return !$this->repository->hasUserActiveEnrollment($user->id);
    }

    private function isHolidayEligible(mixed $discount): bool
    {
        $conditions = $discount->conditions ?? [];
        if (!is_array($conditions) || empty($conditions['start_date'])) {
            return false;
        }

        $today = now()->toDateString();
        $startDate = (string) $conditions['start_date'];
        $endDate = (string) ($conditions['end_date'] ?? $startDate);

        return $today >= $startDate && $today <= $endDate;
    }

    private function calculateAmount(mixed $discount, int $baseAmount): int
    {
        if ($baseAmount <= 0) {
            return 0;
        }

        if ($discount->discount_type === 'percentage') {
            $percentage = max(0, min(100, (int) $discount->discount_value));
            $amount = (int) floor(($baseAmount * $percentage) / 100);
            return max(0, min($baseAmount, $amount));
        }

        $amount = max(0, (int) $discount->discount_value);
        return min($baseAmount, $amount);
    }
}
