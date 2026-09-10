<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::whereNotNull('class_period_booked_at')
            // Once a booking lead has been formally converted to a full
            // student (RegistrationController::store()'s guest->student
            // upgrade, or the manual Admin\UserController::convertGuest(),
            // both of which set converted_from_guest_at), their booking is
            // handled elsewhere as a real student and no longer needs to
            // clutter this leads/booking-tracking list. Booking-form users
            // are created as role='guest' (see BookingClassController) so
            // this filter now actually does something for them - it used
            // to be a no-op back when the booking form created role='student'
            // directly and never touched converted_from_guest_at at all.
            ->whereHas('user', fn ($q) => $q->whereNull('converted_from_guest_at'))
            ->with(['user', 'program', 'classPeriod']);

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->input('program_id'));
        }

        if ($request->filled('batch_type')) {
            $query->whereHas('classPeriod', function ($q) use ($request) {
                $q->where('batch_type', $request->input('batch_type'));
            });
        }

        $bookings = $query->orderByDesc('class_period_booked_at')->paginate(25)->withQueryString();

        // "Arahkan ke Registrasi" link per row: signed + 7-day expiry, logs
        // the lead into their own account then lands on /daftar pre-filled
        // with their booking data (see RegistrationController::continueFromBooking()).
        $bookings->getCollection()->each(function (Enrollment $booking) {
            $booking->registration_link = URL::temporarySignedRoute(
                'registration.continue',
                now()->addDays(7),
                ['enrollment' => $booking->id]
            );
        });

        $programs = Program::whereNot('slug', 'like', 'cambridge-%')
            ->whereNot('slug', 'like', 'toefl-itp-mock-package-%')
            ->orderBy('name')
            ->get();

        $students = User::where('role', 'student')->orderBy('name')->get(['id', 'name', 'email']);

        $bookablePeriods = ClassPeriod::whereIn('status', ['active', 'upcoming'])
            ->with(['program', 'teacher'])
            ->get()
            ->each(function (ClassPeriod $period) {
                $period->occupied_count = $period->occupiedSeats();
            })
            ->sortBy(['program.name', 'start_date']);

        // Overall + per-program booking totals so admin can see registration
        // demand at a glance instead of digging through the paginated table -
        // kept in sync with the same converted-guest exclusion as $query
        // above, so these numbers never disagree with what's actually shown
        // in the table below.
        $totalBookings = Enrollment::whereNotNull('class_period_booked_at')
            ->whereHas('user', fn ($q) => $q->whereNull('converted_from_guest_at'))
            ->count();

        $programBookingCounts = Enrollment::whereNotNull('class_period_booked_at')
            ->whereHas('user', fn ($q) => $q->whereNull('converted_from_guest_at'))
            ->selectRaw('program_id, count(*) as total')
            ->groupBy('program_id')
            ->pluck('total', 'program_id');

        // Batches that hit min_capacity and are awaiting (or were rejected -
        // reversible) an admin decision on whether to actually confirm the
        // class to students (see ClassQuotaNotifier).
        $pendingQuotaDecisions = ClassPeriod::whereNotNull('quota_met_at')
            ->where(fn ($q) => $q->whereNull('quota_met_decision')->orWhere('quota_met_decision', 'rejected'))
            ->with('program')
            ->get()
            ->each(function (ClassPeriod $period) {
                $period->occupied_count = $period->occupiedSeats();
            });

        return view('admin.bookings.index', compact('bookings', 'programs', 'students', 'bookablePeriods', 'totalBookings', 'programBookingCounts', 'pendingQuotaDecisions'));
    }

    /**
     * Admin registers a booking on a student's behalf (e.g. a student who
     * registered by phone/WhatsApp) - uses the same Enrollment.class_period_id
     * + class_period_booked_at mechanism as the student's own self-service
     * "Booking Class" page, so it shows up identically here and counts
     * identically toward capacity.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'class_period_id' => 'required|exists:class_periods,id',
        ]);

        $student = User::findOrFail($validated['user_id']);
        $classPeriod = ClassPeriod::findOrFail($validated['class_period_id']);

        $enrollment = Enrollment::where('user_id', $student->id)
            ->where('program_id', $classPeriod->program_id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return back()->with('error', "{$student->name} tidak terdaftar aktif di program untuk batch ini.")->withInput();
        }

        if ($classPeriod->status === 'closed') {
            return back()->with('error', 'Batch ini sudah ditutup dan tidak menerima booking baru.')->withInput();
        }

        if ($classPeriod->max_capacity && $classPeriod->occupiedSeats() >= $classPeriod->max_capacity) {
            return back()->with('error', 'Batch ini sudah penuh. Silakan pilih batch lain.')->withInput();
        }

        $enrollment->update([
            'class_period_id' => $classPeriod->id,
            'class_period_booked_at' => now(),
        ]);

        // Admin has now confirmed a real kelas+batch for this lead - promote
        // guest to student the same way the dedicated "Convert to Student"
        // action does (see Admin\UserController::convertGuest()), so this
        // booking no longer needs a separate manual conversion step.
        if ($student->role === 'guest') {
            app(\App\Application\Admin\ManageUsers::class)->convertGuest($student);
        }

        try {
            app(\App\Services\ClassQuotaNotifier::class)->checkAndNotifyAdmin($classPeriod);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('ClassQuotaNotifier failed after admin booking store: ' . $e->getMessage());
        }

        return back()->with('success', "Berhasil mendaftarkan {$student->name} ke batch \"{$classPeriod->name}\".");
    }

    /**
     * Move an existing booking to a different batch, and/or a different
     * program entirely (e.g. admin correcting a student's wrong program
     * pick on the self-service booking form). class_period_booked_at is
     * left untouched - it still reflects when the student originally
     * booked, not when this correction happened.
     *
     * Enrollment has a unique(user_id, program_id) constraint, so moving
     * "kelas" (program) reuses the same enrollment row rather than
     * creating a new one - if the student already has a separate
     * enrollment in the target program, that's a conflict this method
     * refuses rather than silently merging/overwriting.
     */
    public function update(Request $request, Enrollment $enrollment): RedirectResponse
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'class_period_id' => 'required|exists:class_periods,id',
        ]);

        $classPeriod = ClassPeriod::findOrFail($validated['class_period_id']);

        if ($classPeriod->program_id !== (int) $validated['program_id']) {
            return back()->with('error', 'Batch yang dipilih bukan bagian dari kelas/program yang dipilih.');
        }

        $programChanged = (int) $validated['program_id'] !== $enrollment->program_id;

        if ($programChanged) {
            $conflict = Enrollment::where('user_id', $enrollment->user_id)
                ->where('program_id', $validated['program_id'])
                ->where('id', '!=', $enrollment->id)
                ->exists();

            if ($conflict) {
                return back()->with('error', 'Student sudah terdaftar di kelas/program tersebut lewat booking lain. Tidak bisa dipindahkan lewat sini.');
            }
        }

        if (!$programChanged && $classPeriod->id === $enrollment->class_period_id) {
            return back()->with('success', 'Tidak ada perubahan - student sudah berada di kelas & batch tersebut.');
        }

        if ($classPeriod->status === 'closed') {
            return back()->with('error', 'Batch ini sudah ditutup dan tidak menerima booking baru.');
        }

        if ($classPeriod->id !== $enrollment->class_period_id
            && $classPeriod->max_capacity
            && $classPeriod->occupiedSeats() >= $classPeriod->max_capacity) {
            return back()->with('error', 'Batch ini sudah penuh. Silakan pilih batch lain.');
        }

        $enrollment->update([
            'program_id' => $classPeriod->program_id,
            'class_period_id' => $classPeriod->id,
        ]);

        // Admin has now confirmed a real kelas+batch for this lead - promote
        // guest to student the same way the dedicated "Convert to Student"
        // action does (see Admin\UserController::convertGuest()), so this
        // booking no longer needs a separate manual conversion step.
        $student = $enrollment->user;
        if ($student && $student->role === 'guest') {
            app(\App\Application\Admin\ManageUsers::class)->convertGuest($student);
        }

        try {
            app(\App\Services\ClassQuotaNotifier::class)->checkAndNotifyAdmin($classPeriod);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('ClassQuotaNotifier failed after admin booking update: ' . $e->getMessage());
        }

        $studentName = $student->name ?? 'Student';

        return back()->with('success', "Berhasil memindahkan {$studentName} ke kelas \"{$classPeriod->program->name}\" - batch \"{$classPeriod->name}\".");
    }

    /**
     * Admin's "Kirim ke Siswa" decision - confirms the class to every
     * booked student now that quota is met (e.g. tutor has been confirmed).
     */
    public function sendQuota(ClassPeriod $classPeriod): RedirectResponse
    {
        $sent = app(\App\Services\ClassQuotaNotifier::class)->sendToStudents($classPeriod);

        if (!$sent) {
            return back()->with('error', "Notifikasi untuk batch \"{$classPeriod->name}\" sudah pernah dikirim sebelumnya.");
        }

        return back()->with('success', "Notifikasi kelas terkonfirmasi berhasil dikirim ke seluruh student batch \"{$classPeriod->name}\".");
    }

    /**
     * Admin's "Tolak" decision - not final, admin can still send later
     * (e.g. once a tutor becomes available) via sendQuota().
     */
    public function rejectQuota(ClassPeriod $classPeriod): RedirectResponse
    {
        app(\App\Services\ClassQuotaNotifier::class)->reject($classPeriod);

        return back()->with('success', "Batch \"{$classPeriod->name}\" ditandai belum dikonfirmasi ke student. Anda bisa mengirim notifikasi kapan saja nanti.");
    }

    /**
     * Bulk-export cherry-picked bookings' contact info (name, WhatsApp,
     * email) as a CSV, for admin to reach out about their booking.
     *
     * Phone numbers are wrapped as an Excel/Sheets formula (`="0812..."`)
     * rather than a plain field - both apps evaluate a leading `=` in a
     * CSV cell as a formula and display/store the quoted text literally,
     * which is what actually keeps a leading zero intact and prevents the
     * number turning into scientific notation on open. A plain digit
     * string in a CSV cell gets auto-typed as a number by both apps and
     * loses that leading zero, which is exactly what "the number can be
     * copied" needs to not happen.
     */
    public function exportContacts(Request $request)
    {
        $validated = $request->validate([
            'enrollment_ids' => 'required|array|min:1',
            'enrollment_ids.*' => 'integer|exists:enrollments,id',
        ]);

        $enrollments = Enrollment::whereIn('id', $validated['enrollment_ids'])
            ->with('user')
            ->get();

        $filename = 'Data-Booking-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($enrollments) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel renders names with special characters correctly
            fputcsv($handle, ['Nama', 'WhatsApp', 'Email'], ',', '"', '\\');

            foreach ($enrollments as $enrollment) {
                $user = $enrollment->user;
                $phone = trim((string) ($user->phone_number ?? ''));
                $phoneCell = $phone !== '' ? '="' . str_replace('"', '', $phone) . '"' : '';

                fputcsv($handle, [
                    $user->name ?? '-',
                    $phoneCell,
                    $user->email ?? '-',
                ], ',', '"', '\\');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Remove a booking from this list (clears class_period_id and
     * class_period_booked_at) without touching the underlying Enrollment
     * itself - the student stays enrolled in the program, they just no
     * longer have a batch reserved, same as if they'd never booked one.
     */
    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        $studentName = $enrollment->user->name ?? 'Student';
        $batchName = $enrollment->classPeriod->name ?? 'batch ini';

        $enrollment->update([
            'class_period_id' => null,
            'class_period_booked_at' => null,
        ]);

        return back()->with('success', "Booking {$studentName} untuk \"{$batchName}\" berhasil dihapus.");
    }
}
