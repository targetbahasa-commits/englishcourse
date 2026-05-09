<?php

namespace App\Infrastructure\Payment;

use App\Domain\Payment\Repositories\PaymentRepository;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\ProgramDiscount;

class EloquentPaymentRepository implements PaymentRepository
{
    public function buildQuery(array $filters, bool $withRelations = true): mixed
    {
        $search     = $filters['q'] ?? '';
        $status     = $filters['status'] ?? 'pending';
        $channel    = $filters['channel'] ?? 'all';
        $proof      = $filters['proof'] ?? 'all';
        $settlement = $filters['settlement'] ?? 'all';
        $variance   = $filters['variance'] ?? 'all';
        $override   = $filters['override'] ?? 'all';
        $dateFrom   = $filters['date_from'] ?? '';
        $dateTo     = $filters['date_to'] ?? '';

        $query = Payment::query();

        if ($withRelations) {
            $query->with(['user', 'program']);
        }

        return $query
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('invoice_number', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($channel !== 'all', fn ($q) => $q->where('payment_channel', $channel))
            ->when($proof === 'yes', fn ($q) => $q->whereNotNull('meta->transfer_proof_path'))
            ->when($proof === 'no', fn ($q) => $q->whereNull('meta->transfer_proof_path'))
            ->when($settlement === 'underpaid', fn ($q) => $q->whereNotNull('paid_amount')
                ->whereRaw('paid_amount < CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END'))
            ->when($settlement === 'exact', fn ($q) => $q->whereNotNull('paid_amount')
                ->whereRaw('paid_amount = CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END'))
            ->when($settlement === 'overpaid', fn ($q) => $q->whereNotNull('paid_amount')
                ->whereRaw('paid_amount > CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END'))
            ->when($variance === 'negative', fn ($q) => $q->whereNotNull('paid_amount')
                ->whereRaw('(paid_amount - CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END) < 0'))
            ->when($variance === 'zero', fn ($q) => $q->whereNotNull('paid_amount')
                ->whereRaw('(paid_amount - CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END) = 0'))
            ->when($variance === 'positive', fn ($q) => $q->whereNotNull('paid_amount')
                ->whereRaw('(paid_amount - CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END) > 0'))
            ->when($override === 'yes', fn ($q) => $q->where('meta->override_underpayment', true))
            ->when($override === 'no', fn ($q) => $q->where(function ($inner) {
                $inner->whereNull('meta->override_underpayment')
                    ->orWhere('meta->override_underpayment', false);
            }))
            ->when($dateFrom !== '', fn ($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo !== '', fn ($q) => $q->whereDate('created_at', '<=', $dateTo));
    }

    public function getDiscountsForProgram(int $programId): array
    {
        return ProgramDiscount::query()
            ->where('program_id', $programId)
            ->where('is_active', true)
            ->get()->all();
    }

    public function hasUserPaidPayments(int $userId): bool
    {
        return Payment::query()
            ->where('user_id', $userId)
            ->where('status', 'paid')
            ->exists();
    }

    public function hasUserActiveEnrollment(int $userId): bool
    {
        return Enrollment::query()
            ->where('user_id', $userId)
            ->whereIn('status', ['active', 'completed'])
            ->exists();
    }
}
