<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Concerns\ExtractsAttributionData;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use ExtractsAttributionData;

    /**
     * Display the registration view.
     */
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $ref = $request->query('ref');
        return view('auth.register', compact('ref'));
    }

    /**
     * Shareable per-partner link (distributed by an HR/L&D contact to their
     * employees) - resolves the code and hands off to the normal student
     * registration page with it attached, so registration itself stays a
     * single code path.
     */
    public function partnerRedirect(string $code): RedirectResponse
    {
        $partner = \App\Models\Partner::where('registration_code', $code)->where('is_active', true)->first();

        if (!$partner) {
            return redirect()->route('student.register')->with('error', 'Kode kerjasama instansi tidak valid atau sudah tidak aktif.');
        }

        return redirect()->route('student.register', ['partner' => $partner->registration_code]);
    }

    public function createTeacher(): View
    {
        return view('auth.register-teacher');
    }

    public function createStudent(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (Auth::check() && !Auth::user()->isAdmin()) {
            return redirect('/dashboard');
        }
        return $this->renderStudentRegistrationView($request, false);
    }

    public function createStudentNoPayment(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (Auth::check() && !Auth::user()->isAdmin()) {
            return redirect('/dashboard');
        }
        return $this->renderStudentRegistrationView($request, true);
    }

    public function createTestTaker(Request $request): View
    {
        $ref = $request->query('ref');
        return view('auth.register-test-taker', compact('ref'));
    }

    private function renderStudentRegistrationView(Request $request, bool $skipPaymentFlow): View
    {
        $ref = $request->query('ref');
        $partner = null;
        $partnerCode = $request->query('partner');
        if ($partnerCode) {
            $partner = \App\Models\Partner::where('registration_code', $partnerCode)->where('is_active', true)->first();
        }
        $classPeriods = \App\Models\ClassPeriod::where('status', '!=', 'closed')->latest()->get();

        $requestedProgram = strtolower(trim((string) $request->query('program', '')));
        $programAliases = [
            'ielts academic' => 'ielts-academic',
            'ielts general' => 'ielts-general',
            'toefl itp' => 'toefl-itp',
            'pte' => 'pte-academic',
            'pte academic' => 'pte-academic',
            'grammar for writing' => 'grammar-for-writing',
            'grammar writing' => 'grammar-for-writing',
            'ielts-academic' => 'ielts-academic',
            'ielts-general' => 'ielts-general',
            'toefl-itp' => 'toefl-itp',
            'pte-academic' => 'pte-academic',
            'grammar-for-writing' => 'grammar-for-writing',
        ];

        $preselectedProgramSlug = $programAliases[$requestedProgram] ?? null;

        $programs = \App\Models\Program::where('is_active', true)->withoutMockTests()->orderBy('name')->get();

        return view('auth.register-student', compact('classPeriods', 'ref', 'partner', 'preselectedProgramSlug', 'skipPaymentFlow', 'programs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cf-turnstile-response' => ['required', new \App\Rules\Turnstile()],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()],
            'role' => ['nullable', 'string', 'in:student,teacher,guest,test-taker'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
            'partner_code' => ['nullable', 'string', 'exists:partners,registration_code'],
            'utm_source' => ['nullable', 'string', 'max:100'],
            'utm_medium' => ['nullable', 'string', 'max:100'],
            'utm_campaign' => ['nullable', 'string', 'max:150'],
            'utm_content' => ['nullable', 'string', 'max:150'],
            'utm_term' => ['nullable', 'string', 'max:150'],
            'acquisition_referrer' => ['nullable', 'string', 'max:1000'],
            'acquisition_landing_path' => ['nullable', 'string', 'max:255'],
            'acquisition_source_page' => ['nullable', 'string', 'max:100'],
            'acquisition_variant' => ['nullable', 'string', 'max:50'],
            'acquisition_last_cta' => ['nullable', 'string', 'max:100'],
            'program_choice' => ['nullable', 'string'],
            'payment_channel_choice' => ['nullable', 'string', 'in:bank_transfer,cash,qris'],
            'skip_payment_flow' => ['nullable', 'boolean'],
            'proof_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ], [
            'password.min' => 'Password minimal :min karakter.',
            'password.mixed_case' => 'Password harus mengandung huruf kapital dan huruf kecil.',
            'password.numbers' => 'Password harus mengandung angka.',
            'proof_file.mimes' => 'Format file bukti transfer harus JPG, PNG, atau PDF.',
            'proof_file.max' => 'Ukuran file bukti transfer maksimal 4MB.',
        ]);

        $attributionData = $this->extractAttributionData($request);

        $role = $request->role ?? 'student';
        $selectedProgramId = null;
        $skipPaymentFlow = $request->boolean('skip_payment_flow');

        if ($role === 'student') {
            $selectedProgramSlug = (string) $request->input('program_choice', '');
            $selectedPaymentChannel = (string) $request->input('payment_channel_choice', '');
            $selectedClassType = (string) $request->input('class_type', 'regular');

            if ($selectedProgramSlug === '') {
                return back()->withInput()->withErrors([
                    'program_choice' => 'Silakan pilih kelas terlebih dahulu.',
                ]);
            }

            if (!in_array($selectedClassType, ['regular', 'semi_private', 'private'])) {
                $selectedClassType = 'regular';
            }

            if (!$skipPaymentFlow && $selectedPaymentChannel === '') {
                return back()->withInput()->withErrors([
                    'payment_channel_choice' => 'Silakan pilih metode pembayaran terlebih dahulu.',
                ]);
            }

            $acceptedProgramSlugs = [
                'ielts-academic' => ['ielts-academic'],
                'ielts-general' => ['ielts-general'],
                'toefl-itp' => ['toefl-itp'],
                'pte-academic' => ['pte-academic', 'pte'],
                'grammar-for-writing' => ['grammar-for-writing', 'grammar-writing'],
            ];

            $slugsToFind = $acceptedProgramSlugs[$selectedProgramSlug] ?? [$selectedProgramSlug];

            $program = Program::whereIn('slug', $slugsToFind)->where('is_active', true)->first();

            if (!$program) {
                return back()->withInput()->withErrors([
                    'program_choice' => 'Pilihan kelas tidak valid.',
                ]);
            }

            $selectedProgramId = $program->id;
        }

        // OTP verification temporarily disabled
        // if ($request->role !== 'guest') {
        //     $request->validate(['phone_number' => ['required']]);
        //
        //     $otpRecord = \App\Models\Otp::where('phone_number', $request->phone_number)
        //         ->where('is_verified', true)
        //         ->first();
        //
        //     if (!$otpRecord) {
        //         return back()->withInput()->withErrors(['phone_number' => 'Please verify your WhatsApp number with an OTP first.']);
        //     }
        // }

        $referredBy = null;
        if ($request->filled('referral_code')) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        $partnerId = null;
        if ($request->filled('partner_code')) {
            $partner = \App\Models\Partner::where('registration_code', $request->partner_code)
                ->where('is_active', true)
                ->first();
            if ($partner) {
                $partnerId = $partner->id;
            }
        }

        // Generate a unique referral code for the new user
        $newReferralCode = strtoupper(Str::random(6));
        while (User::where('referral_code', $newReferralCode)->exists()) {
            $newReferralCode = strtoupper(Str::random(6));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => $role,
            'referral_code' => $newReferralCode,
            'referred_by_id' => $referredBy,
            'partner_id' => $partnerId,
            // 'program_id' is intentionally left null until admin approves the Payment
        ] + $attributionData);

        event(new Registered($user));

        Auth::login($user);



        if ($role === 'student' && $selectedProgramId && !$skipPaymentFlow) {
            $paymentChannel = (string) $request->input('payment_channel_choice', 'bank_transfer');

            try {
                // Initialize Payment unconditionally so they show up in admin queue immediately
                $initiatePayment = app(\App\Application\Payment\InitiatePayment::class);
                $result = $initiatePayment->handle($user, $selectedProgramId, $paymentChannel, $selectedClassType);

                if (in_array($paymentChannel, ['bank_transfer', 'qris']) && $request->hasFile('proof_file') && isset($result['payment'])) {
                    $payment = $result['payment'];
                    $path = $request->file('proof_file')->store('payment-proofs/' . $user->id, 'public');

                    $payment->update([
                        'proof_file' => $path,
                        'status' => 'waiting_verification',
                    ]);

                    return redirect()->route('student.payments.show', $payment)
                        ->with('success', 'Akun berhasil dibuat dan bukti transfer sedang diverifikasi admin.');
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to initiate payment on registration: ' . $e->getMessage());
            }

            return redirect()->route('student.payments.index')
                ->with('success', 'Akun berhasil dibuat. Silakan lanjutkan pembayaran untuk invoice pertamamu.');
        }

        // After registration, always redirect students to assignments so locking is visible
        if ($role === 'student') {
            return redirect()->route('assignments.index')
                ->with('success', 'Akun berhasil dibuat. Silakan mulai belajar di program yang kamu pilih.');
        }
        // Guest registration: redirect directly to free tests page
        if ($role === 'guest') {
            return redirect()->route('guest.free-tests')
                ->with('success', 'Akun berhasil dibuat. Selamat datang di Target Bahasa!');
        }

        // Test-Taker registration: redirect directly to online test portal
        if ($role === 'test-taker') {
            return redirect()->route('online-test.index');
        }

        return redirect(route('dashboard', absolute: false));
    }
}
