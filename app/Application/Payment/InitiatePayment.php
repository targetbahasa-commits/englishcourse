<?php

namespace App\Application\Payment;

use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;

/**
 * Creates a new pending payment invoice for a student.
 *
 * Contains the business logic previously embedded in PaymentController::initiate().
 */
class InitiatePayment
{
    public function __construct(
        private readonly ResolveApplicableDiscount $discountResolver,
    ) {}

    /**
     * @throws \RuntimeException if user is already enrolled or has a pending payment.
     * @return array{status: string, payment?: Payment, message?: string, redirect?: string}
     */
    public function handle(Authenticatable $user, int $programId, string $paymentChannel, string $classType = 'regular'): array
    {
        $program = Program::query()->findOrFail($programId);

        $alreadyEnrolled = Enrollment::query()
            ->where('user_id', $user->id)
            ->where('program_id', $program->id)
            ->whereIn('status', ['active', 'completed'])
            ->exists();

        if ($alreadyEnrolled) {
            return ['status' => 'already_enrolled'];
        }

        $existingPending = Payment::query()
            ->where('user_id', $user->id)
            ->where('program_id', $program->id)
            ->where('status', 'pending')
            ->first();

        if ($existingPending) {
            return ['status' => 'pending_exists', 'payment' => $existingPending];
        }

        $paymentMethod = in_array($paymentChannel, ['bank_transfer', 'qris']) ? 'manual_transfer' : 'offline_cash';
        
        $basePrice = $program->price ?? 0;
        if ($classType === 'private') {
            $basePrice = $program->price_private ?? $basePrice;
        } elseif ($classType === 'semi_private') {
            $basePrice = $program->price_semi_private ?? $basePrice;
        }

        if (in_array($user->learning_mode, ['offline', 'both'])) {
            if ($classType === 'private' && !is_null($program->price_private_offline)) {
                $basePrice = $program->price_private_offline;
            } elseif ($classType === 'semi_private' && !is_null($program->price_semi_private_offline)) {
                $basePrice = $program->price_semi_private_offline;
            } elseif (!is_null($program->price_offline)) {
                $basePrice = $program->price_offline;
            }
        }
        $baseAmount    = max(0, (int) $basePrice);
        $discount      = $this->discountResolver->resolve($user, $program, $baseAmount);

        $payment = Payment::query()->create([
            'user_id'          => $user->id,
            'program_id'       => $program->id,
            'invoice_number'   => $this->generateInvoiceNumber(),
            'amount'           => $baseAmount,
            'discount_amount'  => $discount->amount,
            'currency'         => 'IDR',
            'status'           => 'pending',
            'payment_method'   => $paymentMethod,
            'payment_channel'  => $paymentChannel,
            'payment_provider' => 'internal',
            'due_at'           => now()->addDays(3),
            'meta'             => [
                'class_type'       => $classType,
                'applied_discount' => $discount->meta,
                'instructions'     => [
                    'bank_name'      => setting('bank_name', 'BCA'),
                    'account_number' => setting('bank_account_number', '1234567890'),
                    'account_holder' => setting('bank_account_holder', 'Target Bahasa Course'),
                ],
            ],
        ]);

        return [
            'status'          => 'created',
            'payment'         => $payment,
            'netAmount'       => max(0, $baseAmount - $discount->amount),
            'discountAmount'  => $discount->amount,
            'discountLabel'   => $discount->label,
        ];
    }

    private function generateInvoiceNumber(): string
    {
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $candidate = 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            if (!Payment::query()->where('invoice_number', $candidate)->exists()) {
                return $candidate;
            }
        }

        return 'INV-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(8));
    }
}
