<?php

namespace App\Application\Payment;

use App\Models\Payment;

/**
 * Rejects a pending payment.
 *
 * Extracted from PaymentController::reject().
 */
class RejectPayment
{
    /**
     * @return array{status: string}
     */
    public function handle(Payment $payment, int $rejectorId, string $notes): array
    {
        if ($payment->status === 'paid') {
            return ['status' => 'already_paid'];
        }

        $meta                  = $payment->meta ?? [];
        $meta['rejected_by']   = $rejectorId;
        $meta['rejected_at']   = now()->toDateTimeString();

        $payment->update([
            'status' => 'failed',
            'meta'   => $meta,
            'notes'  => $notes,
        ]);

        return ['status' => 'rejected'];
    }
}
