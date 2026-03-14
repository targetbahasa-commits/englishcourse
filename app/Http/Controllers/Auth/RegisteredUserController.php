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
        ]);

        // Require OTP verification only for non-guest roles
        if ($request->role !== 'guest') {
            $request->validate(['phone_number' => ['required']]);
            
            $otpRecord = \App\Models\Otp::where('phone_number', $request->phone_number)
                ->where('is_verified', true)
                ->first();

            if (!$otpRecord) {
                return back()->withInput()->withErrors(['phone_number' => 'Please verify your WhatsApp number with an OTP first.']);
            }
        }

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
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
