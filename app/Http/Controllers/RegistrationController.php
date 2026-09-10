<?php

namespace App\Http\Controllers;

use App\Application\Registration\CreateRegistrationLead;
use App\Application\Registration\GetRegistrationForm;
use App\Http\Controllers\Concerns\ExtractsAttributionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        if (!empty($request->input('address_line_2'))) {
            abort(403, 'Bot detected.');
        }

        $data = $request->validate([
            'full_name'            => 'required|string|max:150',
            'whatsapp'             => 'required|string|max:20',
            // Blocks registering with an email that already belongs to a
            // DIFFERENT account - shows a clear "already registered" error
            // instead of silently logging the submitter into someone
            // else's account (the previous behavior of the lookup below).
            // ->ignore(auth()->id()) lets an already-logged-in user keep
            // using their own email to register for an additional program
            // via this same form - the one legitimate case of "resubmitting
            // with an email that's already in `users`".
            'email'                => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore(auth()->id())],
            'city'                 => 'required|string|max:100',
            'age'                  => 'nullable|integer|min:10|max:100',
            'profession'           => 'required|in:student_sma,mahasiswa,karyawan,other',
            'profession_other'     => 'nullable|string|max:100',
            'program_id'           => ['required', Rule::exists('programs', 'id')->where('is_active', true)],
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
            'referral_code'        => 'nullable|string|max:50',
            'payment_channel'      => 'nullable|in:bank_transfer,cash,qris',
            'cf-turnstile-response' => ['required', new \App\Rules\Turnstile()],
        ], [
            'program_id.required' => 'Silakan pilih program yang kamu minati.',
            'program_id.exists'   => 'Program yang dipilih tidak valid.',
            'email.unique'        => 'Email ini sudah terdaftar. Silakan login jika ini akun kamu, atau gunakan email lain.',
        ]);

        $data = array_merge($data, $this->extractAttributionData($request));
        $data['has_previous_course'] = $request->boolean('has_previous_course');
        $data['password'] = bcrypt($data['password']);

        $errors = $this->createRegistrationLead->validateClassPeriod($data);
        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        $lead = $this->createRegistrationLead->execute($data);

        // ---- Auto-create User & Payment to integrate with Admin Payment Queue ----
        $rawPhone = preg_replace('/[^0-9]/', '', (string) $data['whatsapp']);
        if ($rawPhone && str_starts_with($rawPhone, '0')) {
            $rawPhone = '62' . substr($rawPhone, 1);
        }

        $email = trim((string) ($data['email'] ?? ''));
        if ($email === '') {
            $email = 'lead-' . time() . '-' . rand(100, 999) . '@targetbahasa.local';
        }

        $referrer = null;
        if (!empty($data['referral_code'])) {
            $referrer = \App\Models\User::where('referral_code', trim($data['referral_code']))->first();
        }

        $user = \App\Models\User::where('email', $email)->first();

        // Fallback match on WhatsApp number when there's no exact email
        // match - this is the common case when email was left blank above
        // (it's labeled optional on the form) and we just fabricated a
        // synthetic, always-unique placeholder address, which meant the
        // email lookup above could NEVER find a match even if this exact
        // person had already registered before (via /daftar or
        // /student/register) - silently creating a fresh duplicate
        // `users` row every time. This was the single biggest source of
        // duplicate student accounts sitewide (investigation dated
        // 2026-09-01 found 6 duplicate-name groups, 12+ accounts).
        // Scoped to role=student so a shared family phone doesn't
        // accidentally match an unrelated admin/teacher account.
        if (!$user && $rawPhone) {
            $user = \App\Models\User::where('phone_number', $rawPhone)
                ->where('role', 'student')
                ->first();
        }

        if (!$user) {
            $newReferralCode = strtoupper(\Illuminate\Support\Str::random(6));
            while (\App\Models\User::where('referral_code', $newReferralCode)->exists()) {
                $newReferralCode = strtoupper(\Illuminate\Support\Str::random(6));
            }

            $bioParts = [];
            if (!empty($data['learning_goal'])) $bioParts[] = "Tujuan: " . $data['learning_goal'];
            if (!empty($data['target_score'])) $bioParts[] = "Target Skor: " . $data['target_score'];
            if (!empty($data['has_previous_course']) && $data['has_previous_course']) $bioParts[] = "Kursus Sebelumnya: " . ($data['previous_course_name'] ?? 'Ya');
            if (!empty($data['schedule_preference'])) $bioParts[] = "Jadwal: " . $data['schedule_preference'];
            if (!empty($data['preferred_time'])) $bioParts[] = "Waktu: " . $data['preferred_time'];
            if (!empty($data['best_contact_time'])) $bioParts[] = "Waktu Dihubungi: " . $data['best_contact_time'];
            if (!empty($data['notes'])) $bioParts[] = "Catatan: " . $data['notes'];
            $bioStr = implode("\n", $bioParts);

            try {
                $user = \App\Models\User::create([
                    'name'            => $data['full_name'],
                    'email'           => $email,
                    'phone_number'    => $rawPhone,
                    'password'        => $data['password'],
                    'role'            => 'student',
                    'status'          => 'active',
                    'program_id'      => $data['program_id'] ?? null,
                    'class_period_id' => $data['class_period_id'] ?? null,
                    'learning_mode'   => ($data['mode'] ?? 'flexible') === 'flexible' ? 'both' : ($data['mode'] ?? 'online'),
                    'referral_code'   => $newReferralCode,
                    'referred_by_id'  => $referrer ? $referrer->id : null,
                    'bio'             => $bioStr,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                // Two near-simultaneous submissions with the same email (double-click,
                // client retry) can both pass the !$user check above before either
                // insert commits. If this is the unique-email race, fall back to the
                // row the other request just created instead of a raw 500.
                $user = \App\Models\User::where('email', $email)->first();
                if (!$user) {
                    throw $e;
                }
            }
        } elseif ($user->role === 'guest') {
            // Same matched row (found by email or phone above), not a new
            // one - this is a booking lead (see BookingClassController)
            // completing real registration. Upgrade in place, mirroring
            // EloquentAdminUserRepository::convertGuest() exactly, so they
            // stop showing up in the admin's booking-leads list (which
            // filters on converted_from_guest_at being null) and gain
            // normal assignment access via HandlesAssignmentAccess.
            $user->role = 'student';
            $user->converted_from_guest_at = now();
            $user->save();
        }

        $lead->update([
            'converted_user_id' => $user->id,
            'status' => 'converted',
            'converted_at' => $lead->converted_at ?? now(),
        ]);

        // Auto-login as the newly registered/converted user so they can immediately see
        // and manage their invoice. Always switch sessions (even if someone else, e.g. a
        // stale guest/student session on a shared device, was already logged in) - the
        // redirect below requires the CURRENT session to own $invoicePayment, so leaving
        // a stale different-user session active would 403 the customer right after they
        // just registered and paid.
        Auth::login($user);

        $invoicePayment = null;
        if (!empty($data['program_id'])) {
            try {
                $initiatePayment = app(\App\Application\Payment\InitiatePayment::class);
                $paymentChannel = $data['payment_channel'] ?? 'bank_transfer';
                $result = $initiatePayment->handle($user, (int) $data['program_id'], $paymentChannel);

                if (in_array($result['status'], ['created', 'pending_exists'], true)) {
                    $invoicePayment = $result['payment'];
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to initiate payment for new lead: ' . $e->getMessage());
            }
        }
        // -------------------------------------------------------------------------

        // Send notifications
        try {
            $notificationEmails = setting('notification_emails');
            if (!empty($notificationEmails)) {
                $emails = array_filter(array_map('trim', explode(',', $notificationEmails)));
                if (count($emails) > 0) {
                    \Illuminate\Support\Facades\Mail::to($emails)->send(new \App\Mail\NewRegistrationAdminMail($lead));
                }
            }

            $notificationWhatsapps = setting('notification_whatsapps');
            if (!empty($notificationWhatsapps)) {
                $whatsapps = array_filter(array_map('trim', explode(',', $notificationWhatsapps)));
                if (count($whatsapps) > 0) {
                    $waMessage = "Pendaftaran Baru!\nNama: {$lead->full_name}\nWA: {$lead->whatsapp}\nKota: {$lead->city}\nSilakan cek dashboard admin.";
                    $waGateway = app(\App\Domain\Notification\Contracts\WhatsAppGateway::class);
                    foreach ($whatsapps as $waNumber) {
                        $waGateway->sendMessage($waNumber, $waMessage);
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send new registration notifications: ' . $e->getMessage());
        }

        // Store the selected program_id and class_period_id in session to display payment details on success page
        if (!empty($data['program_id'])) {
            session([
                'registration_last_program_id' => $data['program_id'],
                'registration_last_class_period_id' => $data['class_period_id'] ?? null,
                'registration_last_mode' => $data['mode'] ?? 'flexible',
                'registration_last_referral_valid' => $referrer ? true : false,
            ]);
        }

        // Redirect to invoice page if one was created/found, otherwise to success page
        if ($invoicePayment) {
            return redirect()->route('student.payments.show', $invoicePayment)
                ->with('success', 'Pendaftaran berhasil! Invoice telah dibuat. Silakan lakukan pembayaran sesuai instruksi di bawah.');
        }

        return redirect()->route('registration.success');
    }

    public function success()
    {
        $paymentDetails = null;
        $programId = session('registration_last_program_id');
        $classPeriodId = session('registration_last_class_period_id');

        $mode = session('registration_last_mode');

        // Fallback for development/reloads if session is empty
        if (!$programId) {
            $latestLead = \App\Models\RegistrationLead::latest()->first();
            if ($latestLead && $latestLead->program_id) {
                $programId = $latestLead->program_id;
                $classPeriodId = $latestLead->class_period_id;
                if (!$mode) {
                    $mode = $latestLead->mode;
                }
            }
        }

        if ($programId) {
            $program = \App\Models\Program::find($programId);
            if ($program) {
                $basePrice = $program->price ?? 0;
                if (in_array($mode, ['offline', 'flexible']) && !is_null($program->price_offline)) {
                    $basePrice = $program->price_offline;
                }
                $baseAmount    = (int) $basePrice;
                $discountAmount = 0;

                $hasReferral = session('registration_last_referral_valid', false);

                $discount = null;
                if ($hasReferral) {
                    $discount = \App\Models\ProgramDiscount::where('program_id', $program->id)
                        ->where('is_active', true)
                        ->where('type', 'referral')
                        ->first();
                }

                if (!$discount) {
                    $discount = \App\Models\ProgramDiscount::where('program_id', $program->id)
                        ->where('is_active', true)
                        ->where('type', 'new_user')
                        ->first();
                }

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

    /**
     * Entry point for the signed "Arahkan ke Registrasi" link generated on
     * the admin bookings page (Admin\BookingController::index()). A
     * booking-form lead (role='guest', see BookingClassController) isn't
     * logged in on whatever device opens this link, and /daftar's email
     * field is validated with Rule::unique(...)->ignore(auth()->id()) - if
     * they aren't authenticated as themselves first, submitting the form
     * pre-filled with their own already-used email would be rejected as
     * "already registered" by the exact validation that was just added to
     * stop a real duplicate-account incident (see store()). Logging them
     * into their own existing account here is what makes ignore(auth()->id())
     * correctly exempt their own row, so the pre-filled form can actually
     * be submitted.
     *
     * The route this method is bound to is signed + time-limited
     * (registered with the `signed` middleware) - Laravel rejects the
     * request before this method ever runs if the URL has been tampered
     * with or has expired, so $enrollment->id is trustworthy here.
     */
    public function continueFromBooking(\App\Models\Enrollment $enrollment)
    {
        $user = $enrollment->user;

        if (!$user || !$enrollment->class_period_booked_at) {
            abort(404);
        }

        Auth::login($user);

        return redirect()->route('registration.show', [
            'full_name' => $user->name,
            'whatsapp' => $user->phone_number,
            'email' => $user->email,
            'program_id' => $enrollment->program_id,
            'class_period_id' => $enrollment->class_period_id,
        ]);
    }
}
