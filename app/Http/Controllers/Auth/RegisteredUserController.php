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

    public function createTeacher(): View
    {
        return view('auth.register-teacher');
    }

    public function createStudent(Request $request): View
    {
        return $this->renderStudentRegistrationView($request, false);
    }

    public function createStudentNoPayment(Request $request): View
    {
        return $this->renderStudentRegistrationView($request, true);
    }

    private function renderStudentRegistrationView(Request $request, bool $skipPaymentFlow): View
    {
        $ref = $request->query('ref');
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

        return view('auth.register-student', compact('classPeriods', 'ref', 'preselectedProgramSlug', 'skipPaymentFlow'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // 'cf-turnstile-response' => ['required', new \App\Rules\Turnstile()],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'string', 'in:student,teacher,guest'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
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
            'payment_channel_choice' => ['nullable', 'string', 'in:bank_transfer,cash'],
            'skip_payment_flow' => ['nullable', 'boolean'],
        ]);

        $attributionData = $this->extractAttributionData($request);

        $role = $request->role ?? 'student';
        $selectedProgramId = null;
        $skipPaymentFlow = $request->boolean('skip_payment_flow');

        if ($role === 'student') {
            $selectedProgramSlug = (string) $request->input('program_choice', '');
            $selectedPaymentChannel = (string) $request->input('payment_channel_choice', '');

            if ($selectedProgramSlug === '') {
                return back()->withInput()->withErrors([
                    'program_choice' => 'Silakan pilih kelas terlebih dahulu.',
                ]);
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

            $program = Program::whereIn('slug', $slugsToFind)->first();

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

        // Generate a unique referral code for the new user
        $newReferralCode = 'TB-' . strtoupper(Str::random(6));
        while (User::where('referral_code', $newReferralCode)->exists()) {
            $newReferralCode = 'TB-' . strtoupper(Str::random(6));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => $role,
            'referral_code' => $newReferralCode,
            'referred_by_id' => $referredBy,
            // 'program_id' is intentionally left null until admin approves the EnrollmentRequest
        ] + $attributionData);

        event(new Registered($user));

        Auth::login($user);

        if ($role === 'student' && $selectedProgramId) {
            \App\Models\EnrollmentRequest::create([
                'user_id' => $user->id,
                'program_id' => $selectedProgramId,
                'status' => 'pending',
            ]);
        }

        if ($role === 'student' && $selectedProgramId && !$skipPaymentFlow) {
            return redirect()->route('student.payments.index')
                ->with('success', 'Akun berhasil dibuat. Lanjutkan ke tahap pembayaran untuk membuat invoice pertamamu.')
                ->with('registration_prefill_program_id', $selectedProgramId)
                ->with('registration_prefill_payment_channel', (string) $request->input('payment_channel_choice', 'bank_transfer'));
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

        return redirect(route('dashboard', absolute: false));
    }
}
