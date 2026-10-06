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
    public function handle(Authenticatable $user, int $programId, string $paymentChannel, string $classType = 'regular', ?int $excludeEnrollmentId = null, ?int $overrideAmount = null): array
    {
        $program = Program::query()->findOrFail($programId);

        if (!$program->is_active) {
            return ['status' => 'program_inactive'];
        }

        // $excludeEnrollmentId lets a caller finalizing a specific booking
        // (which is itself an Enrollment row with status 'active') invoice
        // that same booking without it tripping its own already-enrolled
        // check - without this, every booking-to-student conversion would
        // always report already_enrolled and silently never create a Payment.
        $alreadyEnrolled = Enrollment::query()
            ->where('user_id', $user->id)
            ->where('program_id', $program->id)
            ->whereIn('status', ['active', 'completed'])
            ->when($excludeEnrollmentId, fn ($query) => $query->where('id', '!=', $excludeEnrollmentId))
            ->exists();

        if ($alreadyEnrolled) {
            return ['status' => 'already_enrolled'];
        }

        $existingPending = Payment::query()
            ->where('user_id', $user->id)
            ->where('program_id', $program->id)
            ->whereIn('status', ['pending', 'waiting_verification'])
            ->first();

        if ($existingPending) {
            return ['status' => 'pending_exists', 'payment' => $existingPending];
        }

        $paymentMethod = in_array($paymentChannel, ['bank_transfer', 'qris']) ? 'manual_transfer' : 'offline_cash';

        if ($overrideAmount !== null) {
            // Admin typed a specific amount (e.g. negotiated/offline deal, or
            // the program's price fields aren't configured) - use it as-is
            // and skip the price-field/discount resolution below entirely,
            // since that amount already represents the final figure.
            $baseAmount = $overrideAmount;
            $discount   = \App\Domain\Payment\DiscountResult::none();
        } else {
            $priceField = 'price';
            if ($classType === 'private' && $program->price_private !== null) {
                $priceField = 'price_private';
            } elseif ($classType === 'semi_private' && $program->price_semi_private !== null) {
                $priceField = 'price_semi_private';
            }

            if (in_array($user->learning_mode, ['offline', 'both'])) {
                if ($classType === 'private' && !is_null($program->price_private_offline)) {
                    $priceField = 'price_private_offline';
                } elseif ($classType === 'semi_private' && !is_null($program->price_semi_private_offline)) {
                    $priceField = 'price_semi_private_offline';
                } elseif (!is_null($program->price_offline)) {
                    $priceField = 'price_offline';
                }
            }

            // The per-price inline discount (fixed IDR or %) set on whichever
            // price field was just resolved above is applied first, then the
            // audience-based ProgramDiscount rules (guest/student/referral/...)
            // are evaluated on top of that already-discounted amount - the two
            // discount mechanisms stack rather than one replacing the other.
            $baseAmount    = $program->discountedPrice($priceField);
            $discount      = $this->discountResolver->resolve($user, $program, $baseAmount);
        }

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
