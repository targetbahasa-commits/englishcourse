<?php

namespace App\Http\Controllers;

use App\Application\Registration\CreateRegistrationLead;
use App\Application\Registration\GetRegistrationForm;
use App\Http\Controllers\Concerns\ExtractsAttributionData;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use ExtractsAttributionData;

    public function __construct(
        private readonly GetRegistrationForm $getRegistrationForm,
        private readonly CreateRegistrationLead $createRegistrationLead,
    ) {
    }

    public function show()
    {
        $data = $this->getRegistrationForm->execute();

        return view('registration.form', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'            => 'required|string|max:150',
            'whatsapp'             => 'required|string|max:20',
            'email'                => 'nullable|email|max:150',
            'city'                 => 'required|string|max:100',
            'age'                  => 'nullable|integer|min:10|max:100',
            'profession'           => 'required|in:student_sma,mahasiswa,karyawan,other',
            'profession_other'     => 'nullable|string|max:100',
            'program_id'           => 'required|exists:programs,id',
            'class_period_id'      => 'nullable|exists:class_periods,id',
            'program_interest'     => 'nullable|string|max:100',
            'mode'                 => 'required|in:online,offline,flexible',
            'schedule_preference'  => 'required|in:weekday,weekend,flexible',
            'preferred_time'       => 'required|in:pagi,siang,sore,malam,flexible',
            'learning_goal'        => 'nullable|string|max:1000',
            'target_score'         => 'nullable|string|max:50',
            'source'               => 'required|in:instagram,tiktok,teman,google,brosur,youtube,other',
            'source_detail'        => 'nullable|string|max:100',
            'utm_source'           => 'nullable|string|max:100',
            'utm_medium'           => 'nullable|string|max:100',
            'utm_campaign'         => 'nullable|string|max:150',
            'utm_content'          => 'nullable|string|max:150',
            'utm_term'             => 'nullable|string|max:150',
            'acquisition_referrer' => 'nullable|string|max:1000',
            'acquisition_landing_path' => 'nullable|string|max:255',
            'acquisition_source_page'  => 'nullable|string|max:100',
            'acquisition_variant'      => 'nullable|string|max:50',
            'acquisition_last_cta'     => 'nullable|string|max:100',
            'has_previous_course'  => 'boolean',
            'previous_course_name' => 'nullable|string|max:100',
            'budget_range'         => 'nullable|string|max:50',
            'best_contact_time'    => 'nullable|string|max:100',
            'notes'                => 'nullable|string|max:1000',
            'password'             => 'required|string|min:8|confirmed',
        ], [
            'program_id.required' => 'Silakan pilih program yang kamu minati.',
            'program_id.exists'   => 'Program yang dipilih tidak valid.',
        ]);

        $data = array_merge($data, $this->extractAttributionData($request));
        $data['has_previous_course'] = $request->boolean('has_previous_course');
        $data['password'] = bcrypt($data['password']);

        $errors = $this->createRegistrationLead->validateClassPeriod($data);
        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        $this->createRegistrationLead->execute($data);

        // Store the selected program_id and class_period_id in session to display payment details on success page
        if (!empty($data['program_id'])) {
            session([
                'registration_last_program_id' => $data['program_id'],
                'registration_last_class_period_id' => $data['class_period_id'] ?? null,
            ]);
        }

        return redirect()->route('registration.success');
    }

    public function success()
    {
        $paymentDetails = null;
        $programId = session('registration_last_program_id');
        $classPeriodId = session('registration_last_class_period_id');

        // Fallback for development/reloads if session is empty
        if (!$programId) {
            $latestLead = \App\Models\RegistrationLead::latest()->first();
            if ($latestLead && $latestLead->program_id) {
                $programId = $latestLead->program_id;
                $classPeriodId = $latestLead->class_period_id;
            }
        }

        if ($programId) {
            $program = \App\Models\Program::find($programId);
            if ($program) {
                $baseAmount    = (int) ($program->price ?? 0);
                $discountAmount = 0;

                $discount = \App\Models\ProgramDiscount::where('program_id', $program->id)
                    ->where('is_active', true)
                    ->where('type', 'new_user')
                    ->first();

                if ($discount) {
                    if ($discount->discount_type === 'percentage') {
                        $pct = max(0, min(100, (int) $discount->discount_value));
                        $discountAmount = (int) floor(($baseAmount * $pct) / 100);
                    } else {
                        $discountAmount = min($baseAmount, (int) $discount->discount_value);
                    }
                }

                $paymentDetails = [
                    'program_name'    => $program->name,
                    'base_amount'     => $baseAmount,
                    'discount_amount' => $discountAmount,
                    'net_amount'      => max(0, $baseAmount - $discountAmount),
                    'batch_name'      => null,
                ];

                if ($classPeriodId) {
                    $classPeriod = \App\Models\ClassPeriod::find($classPeriodId);
                    if ($classPeriod) {
                        $paymentDetails['batch_name'] = $classPeriod->name;
                        
                        if ($classPeriod->start_date && $classPeriod->end_date) {
                            $paymentDetails['batch_dates'] = \Carbon\Carbon::parse($classPeriod->start_date)->translatedFormat('d M') . ' – ' . \Carbon\Carbon::parse($classPeriod->end_date)->translatedFormat('d M Y');
                        } else {
                            $paymentDetails['batch_dates'] = null;
                        }
                    }
                }
            }
        }

        return view('registration.success', compact('paymentDetails'));
    }
}
