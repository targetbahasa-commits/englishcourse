<?php

namespace App\Http\Controllers;

use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingClassController extends Controller
{
    /**
     * Display public booking form (no login or signup required).
     */
    public function index(Request $request)
    {
        $programs = Program::whereNot('slug', 'like', 'cambridge-%')
            ->whereNot('slug', 'like', 'toefl-itp-mock-package-%')
            ->orderBy('name')
            ->get();

        // 12 Months selection list
        $months = [
            'Maret 2026', 'April 2026', 'Mei 2026', 'Juni 2026',
            'Juli 2026', 'Agustus 2026', 'September 2026', 'Oktober 2026',
            'November 2026', 'Desember 2026', 'Januari 2027', 'Februari 2027'
        ];

        // 4 Weeks selection list per month
        $weeks = [
            [
                'id' => 'Minggu 1',
                'label' => 'Minggu ke-1',
                'dates' => 'Tanggal 1 – 7',
                'period' => 'Awal Bulan',
            ],
            [
                'id' => 'Minggu 2',
                'label' => 'Minggu ke-2',
                'dates' => 'Tanggal 8 – 14',
                'period' => 'Pertengahan Awal',
            ],
            [
                'id' => 'Minggu 3',
                'label' => 'Minggu ke-3',
                'dates' => 'Tanggal 15 – 21',
                'period' => 'Pertengahan Akhir',
            ],
            [
                'id' => 'Minggu 4',
                'label' => 'Minggu ke-4',
                'dates' => 'Tanggal 22 – Akhir Bulan',
                'period' => 'Akhir Bulan',
            ],
        ];

        $user = Auth::user();
        $userEnrollments = $user ? $user->enrollments()->where('status', 'active')->with(['program', 'classPeriod.teacher'])->get() : collect();

        // Attach the registered-member count for each enrollment's OWN batch
        // only. This intentionally never touches $periodCounts/$bookingCounts
        // (which cover every program/batch) - a student must only ever see how
        // many members are in the specific class they themselves booked.
        $userEnrollments->each(function (Enrollment $enrollment) {
            $enrollment->batch_occupied_count = $enrollment->classPeriod ? $enrollment->classPeriod->occupiedSeats() : null;
        });

        // Total students already booked per program (all-time), shown as social
        // proof / demand indicator to prospective students on the booking form.
        $bookingCounts = Enrollment::whereNotNull('class_period_booked_at')
            ->selectRaw('program_id, count(*) as total')
            ->groupBy('program_id')
            ->pluck('total', 'program_id');

        // Live per Program+Month+Week registrant counts, keyed the same way the
        // matching ClassPeriod is named in submit() ("{$program->name} -
        // {$bookingMonth} ({$bookingWeek})"), so the form can show "X siswa
        // sudah booking" as the student picks a specific period.
        $programNames = $programs->pluck('name', 'id');
        $periodCounts = [];
        ClassPeriod::whereIn('program_id', $programs->pluck('id'))->get()->each(function (ClassPeriod $period) use ($programNames, &$periodCounts) {
            $programName = $programNames[$period->program_id] ?? null;
            if (!$programName) {
                return;
            }
            if (preg_match('/^' . preg_quote($programName, '/') . ' - (.+) \((.+)\)$/', $period->name, $matches)) {
                $key = $period->program_id . '|' . $matches[1] . '|' . $matches[2];
                $periodCounts[$key] = ($periodCounts[$key] ?? 0) + $period->occupiedSeats();
            }
        });

        return view('booking-class.index', compact('programs', 'months', 'weeks', 'user', 'userEnrollments', 'bookingCounts', 'periodCounts'));
    }

    /**
     * Handle public booking form submission with Month and Week selection.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:50',
            'program_id' => 'required|exists:programs,id',
            'booking_month' => 'required|string|max:100',
            'booking_week' => 'required|string|max:100',
            'batch_type' => 'nullable|string|in:regular,private,semi_private,all',
            'learning_mode' => 'nullable|string|in:online,offline,all',
            'notes' => 'nullable|string|max:1000',
            'class_period_id' => 'nullable|exists:class_periods,id',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email aktif wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'whatsapp.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'program_id.required' => 'Silakan pilih salah satu program kursus bahasa.',
            'program_id.exists' => 'Program kursus bahasa yang dipilih tidak valid.',
            'booking_month.required' => 'Silakan pilih bulan mulai belajar.',
            'booking_week.required' => 'Silakan pilih minggu belajar.',
        ]);

        $email = strtolower(trim($validated['email']));
        $name = trim($validated['name']);
        $phone = trim($validated['whatsapp']);
        $batchType = in_array($validated['batch_type'] ?? '', ['private', 'semi_private'], true) ? $validated['batch_type'] : 'regular';
        $learningMode = ($validated['learning_mode'] === 'offline') ? 'offline' : 'online';
        $bookingMonth = trim($validated['booking_month']);
        $bookingWeek = trim($validated['booking_week']);

        // Find or create a lead for this booking without forcing manual
        // password signup. Deliberately role='guest', not 'student' - a
        // booking is just reserving interest in a batch time slot, not a
        // real registration. HandlesAssignmentAccess already gates guests
        // out of assignments, so this also means a mere booking no longer
        // grants full learning access before the lead actually registers
        // (see RegistrationController::store()'s guest->student upgrade,
        // which fires once they complete real registration via the signed
        // "continue registration" link generated on the admin bookings
        // page).
        $user = Auth::user();
        if (!$user) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phone,
                    'role' => 'guest',
                    'status' => 'active',
                    'password' => bcrypt(Str::random(24)),
                ]);
            } else {
                if (empty($user->phone_number) && !empty($phone)) {
                    $user->update(['phone_number' => $phone]);
                }
            }
        }

        /** @var Program $program */
        $program = Program::findOrFail($validated['program_id']);

        // Find or create matching ClassPeriod for this program, month & week
        $periodName = "{$program->name} - {$bookingMonth} ({$bookingWeek})";
        
        $classPeriod = null;
        if (!empty($validated['class_period_id'])) {
            $classPeriod = ClassPeriod::find($validated['class_period_id']);
        }

        if (!$classPeriod) {
            $classPeriod = ClassPeriod::where('program_id', $program->id)
                ->where('name', $periodName)
                ->first();
        }

        if (!$classPeriod) {
            $classPeriod = ClassPeriod::create([
                'name' => $periodName,
                'program_id' => $program->id,
                'batch_type' => $batchType,
                'learning_mode' => $learningMode,
                'status' => 'active',
                'max_capacity' => ($batchType === 'private') ? 1 : 20,
                'min_capacity' => ['regular' => 4, 'semi_private' => 2, 'private' => 1][$batchType] ?? 1,
            ]);
        }

        // Lock & assign enrollment
        DB::transaction(function () use ($user, $program, $classPeriod) {
            $enrollment = Enrollment::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'program_id' => $program->id,
                ],
                [
                    'enrolled_at' => now(),
                    'status' => 'active',
                ]
            );

            $enrollment->update([
                'class_period_id' => $classPeriod->id,
                'class_period_booked_at' => now(),
                'status' => 'active',
            ]);
        });

        try {
            app(\App\Services\ClassQuotaNotifier::class)->checkAndNotifyAdmin($classPeriod);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('ClassQuotaNotifier failed after booking submit: ' . $e->getMessage());
        }

        $bookingSuccessData = [
            'student_name' => $name,
            'student_email' => $email,
            'student_phone' => $phone,
            'program_name' => $program->name,
            'batch_name' => "Bulan {$bookingMonth} — {$bookingWeek}",
            'batch_type' => $batchType === 'semi_private' ? 'Semi-Privat (2-3 orang)' : ($batchType === 'private' ? 'Private 1-on-1' : 'Reguler (4-10 orang)'),
            'learning_mode' => ucfirst($learningMode),
            'booking_month' => $bookingMonth,
            'booking_week' => $bookingWeek,
            'teacher_name' => $classPeriod->teacher->name ?? 'Akan dikonfirmasi Admin',
            'notes' => $validated['notes'] ?? null,
            'booked_at' => now()->format('d M Y, H:i') . ' WIB',
        ];

        // Send email & WA notifications to admin
        try {
            $adminEmails = ['targetbahasa@gmail.com', 'info@targetbahasa.com'];
            $settingEmails = setting('notification_emails');
            if (!empty($settingEmails)) {
                $parsed = array_filter(array_map('trim', explode(',', $settingEmails)));
                if (count($parsed) > 0) {
                    $adminEmails = array_unique(array_merge($adminEmails, $parsed));
                }
            }

            \Illuminate\Support\Facades\Mail::to($adminEmails)->send(new \App\Mail\ClassBookingNotificationMail($bookingSuccessData));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send class booking notification email: ' . $e->getMessage());
        }

        try {
            $notificationWhatsapps = setting('notification_whatsapps');
            if (!empty($notificationWhatsapps)) {
                $whatsapps = array_filter(array_map('trim', explode(',', $notificationWhatsapps)));
                if (count($whatsapps) > 0) {
                    $waMessage = "Pendaftaran Booking Kelas Baru!\n\nNama: {$name}\nEmail: {$email}\nWA: {$phone}\nProgram: {$program->name}\nPeriode: Bulan {$bookingMonth} — {$bookingWeek}\nTipe: {$bookingSuccessData['batch_type']}\nModa: " . ucfirst($learningMode) . "\nCatatan: " . ($validated['notes'] ?? '-');
                    $waGateway = app(\App\Domain\Notification\Contracts\WhatsAppGateway::class);
                    foreach ($whatsapps as $waNumber) {
                        $waGateway->sendMessage($waNumber, $waMessage);
                    }
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send class booking WA notification: ' . $e->getMessage());
        }

        return back()
            ->with('success', "Selamat! Anda berhasil terdaftar untuk program {$program->name} pada {$bookingMonth} ({$bookingWeek}).")
            ->with('booking_success_data', $bookingSuccessData);
    }

    /**
     * Backward compatibility endpoint for direct batch booking.
     */
    public function book(Request $request, ClassPeriod $classPeriod): RedirectResponse
    {
        $request->merge([
            'program_id' => $classPeriod->program_id,
            'booking_month' => $classPeriod->start_date ? $classPeriod->start_date->format('F Y') : date('F Y'),
            'booking_week' => 'Minggu 1',
            'class_period_id' => $classPeriod->id,
        ]);
        
        if (Auth::check()) {
            $request->merge([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'whatsapp' => Auth::user()->phone_number ?? '08123456789',
            ]);
        }

        return $this->submit($request);
    }
}
