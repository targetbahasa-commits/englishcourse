<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    private function extractAttributionData(Request $request): array
    {
        return $request->only([
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_content',
            'utm_term',
            'acquisition_referrer',
            'acquisition_landing_path',
            'acquisition_source_page',
            'acquisition_variant',
            'acquisition_last_cta',
        ]);
    }

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
        $ref = $request->query('ref');
        $classPeriods = \App\Models\ClassPeriod::where('status', '!=', 'closed')->latest()->get();
        return view('auth.register-student', compact('classPeriods', 'ref'));
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
        ]);

        $attributionData = $this->extractAttributionData($request);

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
            'role' => $request->role ?? 'student',
            'referral_code' => $newReferralCode,
            'referred_by_id' => $referredBy,
        ] + $attributionData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
