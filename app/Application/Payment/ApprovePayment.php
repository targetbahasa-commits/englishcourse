<?php

namespace App\Application\Payment;

use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Domain\Shared\Contracts\TransactionManager;

/**
 * Approves a payment, records the paid amount, and activates the student's enrollment.
 *
 * Extracted from PaymentController::approve().
 */
class ApprovePayment
{
    public function __construct(
        private readonly TransactionManager $transactions,
    ) {}

    /**
     * @param  array{paid_amount?: int|null, override_underpayment?: bool, notes?: string}  $data
     * @return array{status: string, message?: string, errors?: array}
     */
    public function handle(Authenticatable $verifier, Payment $payment, array $data): array
    {
        if ($payment->status === 'paid') {
            return ['status' => 'already_paid'];
        }

        $netAmount          = max(0, (int) $payment->amount - (int) $payment->discount_amount);
        $paidAmount         = (int) ($data['paid_amount'] ?? $netAmount);
        $allowUnderpayment  = (bool) ($data['override_underpayment'] ?? false);
        $notes              = isset($data['notes']) ? trim((string) $data['notes']) : '';
        $receiverName       = isset($data['receiver_name']) ? trim((string) $data['receiver_name']) : null;
        $classPeriodId      = isset($data['class_period_id']) ? (int) $data['class_period_id'] : null;

        if (!$allowUnderpayment && $paidAmount < $netAmount) {
            return [
                'status' => 'validation_error',
                'errors' => ['paid_amount' => 'Nominal paid tidak boleh kurang dari total tagihan (Rp' . number_format($netAmount, 0, ',', '.') . ') kecuali override diaktifkan.'],
            ];
        }

        if ($allowUnderpayment && $paidAmount < $netAmount && $notes === '') {
            return [
                'status' => 'validation_error',
                'errors' => ['notes' => 'Alasan wajib diisi saat approve underpayment dengan override.'],
            ];
        }

        $this->transactions->run(function () use ($verifier, $payment, $paidAmount, $allowUnderpayment, $notes, $netAmount, $receiverName, $classPeriodId) {
            $meta                               = $payment->meta ?? [];
            $meta['verified_by']                = $verifier->id;
            $meta['verified_at']                = now()->toDateTimeString();
            if ($receiverName !== null && $receiverName !== '') {
                $meta['receiver_name']          = $receiverName;
            }
            $isUnderpaymentOverride             = $allowUnderpayment && $paidAmount < $netAmount;
            $meta['override_underpayment']      = $isUnderpaymentOverride;
            $meta['override_underpayment_reason'] = $isUnderpaymentOverride ? $notes : null;

            $payment->update([
                'status'     => 'paid',
                'paid_amount'=> $paidAmount,
                'paid_at'    => now(),
                'verified_by'=> $verifier->id,
                'meta'       => $meta,
                'notes'      => $notes !== '' ? $notes : $payment->notes,
            ]);

            if ($payment->user_id && $payment->program_id) {
                $enrollmentData = ['enrolled_at' => now(), 'status' => 'active'];
                if ($classPeriodId !== null) {
                    $enrollmentData['class_period_id'] = $classPeriodId;
                }

                $enrollment = Enrollment::query()->updateOrCreate(
                    ['user_id' => $payment->user_id, 'program_id' => $payment->program_id],
                    $enrollmentData
                );

                $payment->update(['enrollment_id' => $enrollment->id]);

                if ($payment->user) {
                    $userData = ['program_id' => $payment->program_id];
                    if ($classPeriodId !== null) {
                        $userData['class_period_id'] = $classPeriodId;
                    }
                    $payment->user->update($userData);
                }
            }
        });

        return ['status' => 'approved'];
    }
}
