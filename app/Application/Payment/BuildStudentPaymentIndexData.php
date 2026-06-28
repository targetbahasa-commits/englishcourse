<?php

namespace App\Application\Payment;

use App\Domain\Payment\Repositories\PaymentRepository;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Builds the view data for the student's payment index page.
 */
class BuildStudentPaymentIndexData
{
    public function __construct(
        private readonly PaymentRepository        $paymentRepository,
        private readonly ResolveApplicableDiscount $discountResolver,
    ) {}

    public function handle(Authenticatable $user, int $prefillProgramId, string $prefillPaymentChannel): array
    {
        $payments = Payment::query()
            ->with('program')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $programs = Program::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $programPricingPreview = [];
        foreach ($programs as $program) {
            $classTypes = ['regular', 'semi_private', 'private'];
            $programPricingPreview[(string) $program->id] = [];
            
            foreach ($classTypes as $type) {
                $basePrice = $program->price ?? 0;
                
                if ($type === 'private') {
                    $basePrice = $program->price_private ?? $basePrice;
                } elseif ($type === 'semi_private') {
                    $basePrice = $program->price_semi_private ?? $basePrice;
                }

                if (in_array($user->learning_mode, ['offline', 'both'])) {
                    if ($type === 'private' && !is_null($program->price_private_offline)) {
                        $basePrice = $program->price_private_offline;
                    } elseif ($type === 'semi_private' && !is_null($program->price_semi_private_offline)) {
                        $basePrice = $program->price_semi_private_offline;
                    } elseif (!is_null($program->price_offline)) {
                        $basePrice = $program->price_offline;
                    }
                }
                
                $baseAmount   = max(0, (int) $basePrice);
                $discount     = $this->discountResolver->resolve($user, $program, $baseAmount);

                $programPricingPreview[(string) $program->id][$type] = [
                    'base_amount'    => $baseAmount,
                    'discount_amount'=> $discount->amount,
                    'net_amount'     => max(0, $baseAmount - $discount->amount),
                    'discount_label' => $discount->label,
                ];
            }
        }

        $activeEnrollmentProgramIds = Enrollment::query()
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->pluck('program_id')
            ->all();

        return [
            'payments'                   => $payments,
            'programs'                   => $programs,
            'activeEnrollmentProgramIds' => $activeEnrollmentProgramIds,
            'programPricingPreview'      => $programPricingPreview,
            'prefillProgramId'           => $prefillProgramId,
            'prefillPaymentChannel'      => $prefillPaymentChannel,
        ];
    }
}
