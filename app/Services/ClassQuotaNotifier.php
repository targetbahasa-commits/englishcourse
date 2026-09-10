<?php

namespace App\Services;

use App\Domain\Notification\Contracts\WhatsAppGateway;
use App\Mail\ClassQuotaMetMail;
use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ClassQuotaNotifier
{
    private const MIN_CAPACITY_FLOOR_BY_TYPE = [
        'regular' => 4,
        'semi_private' => 2,
        'private' => 1,
    ];

    /**
     * Fires a one-time WhatsApp + email notification to the ADMIN ONLY the
     * moment a batch first reaches its min_capacity - reaching headcount
     * doesn't guarantee the class can actually run (e.g. no tutor assigned
     * yet), so students are only told via sendToStudents() once admin
     * explicitly decides. Safe to call after any booking/move - it no-ops
     * unless the threshold has just been crossed, and the
     * whereNull(...)->update() claim below prevents two near-simultaneous
     * bookings from double-firing.
     */
    public function checkAndNotifyAdmin(ClassPeriod $classPeriod): void
    {
        $minCapacity = $this->resolveMinCapacity($classPeriod);

        if (!$minCapacity || $classPeriod->quota_met_at) {
            return;
        }

        if ($classPeriod->occupiedSeats() < $minCapacity) {
            return;
        }

        $claimed = ClassPeriod::where('id', $classPeriod->id)
            ->whereNull('quota_met_at')
            ->update(['quota_met_at' => now()]);

        if (!$claimed) {
            return;
        }

        $studentCount = $this->bookedStudents($classPeriod)->count();

        $this->notifyAdmin($classPeriod, $studentCount, $minCapacity);
    }

    /**
     * Admin's "Kirim ke Siswa" action - sends the class-confirmed
     * notification to every booked student. Idempotent: returns false
     * (no-op) if already sent. Reversible from a prior reject() - there's
     * no guard against sending after quota_met_decision = 'rejected'.
     */
    public function sendToStudents(ClassPeriod $classPeriod): bool
    {
        $minCapacity = $this->resolveMinCapacity($classPeriod) ?? $classPeriod->min_capacity ?? 1;

        $claimed = ClassPeriod::where('id', $classPeriod->id)
            ->whereNull('quota_met_notified_at')
            ->update([
                'quota_met_notified_at' => now(),
                'quota_met_decision' => 'sent',
                'quota_met_decided_at' => now(),
            ]);

        if (!$claimed) {
            return false;
        }

        $students = $this->bookedStudents($classPeriod);

        foreach ($students as $student) {
            $this->notifyStudent($classPeriod, $student, $students->count(), $minCapacity);
        }

        return true;
    }

    /**
     * Admin's "Tolak" action - records the decision not to send (yet).
     * Deliberately not final: admin can call sendToStudents() later once
     * whatever blocked the class (e.g. no tutor available) is resolved.
     */
    public function reject(ClassPeriod $classPeriod): void
    {
        ClassPeriod::where('id', $classPeriod->id)->update([
            'quota_met_decision' => 'rejected',
            'quota_met_decided_at' => now(),
        ]);
    }

    private function resolveMinCapacity(ClassPeriod $classPeriod): ?int
    {
        return $classPeriod->min_capacity
            ?? self::MIN_CAPACITY_FLOOR_BY_TYPE[$classPeriod->batch_type] ?? null;
    }

    /**
     * Same union/dedup definition as ClassPeriod::occupiedSeats() - everyone
     * currently occupying a seat in this batch, regardless of role (a
     * booking-lead who hasn't finished real registration yet still counts).
     */
    private function bookedStudents(ClassPeriod $classPeriod): Collection
    {
        $legacy = User::where('class_period_id', $classPeriod->id)->where('role', 'student')->get();

        $enrolledIds = Enrollment::where('class_period_id', $classPeriod->id)
            ->where('status', 'active')
            ->pluck('user_id');
        $enrolled = User::whereIn('id', $enrolledIds)->get();

        return $legacy->merge($enrolled)->unique('id');
    }

    private function notifyAdmin(ClassPeriod $classPeriod, int $studentCount, int $minCapacity): void
    {
        $quotaData = $this->quotaData($classPeriod, $studentCount, $minCapacity, isAdmin: true);

        try {
            $adminEmails = ['targetbahasa@gmail.com', 'info@targetbahasa.com'];
            $settingEmails = setting('notification_emails');
            if (!empty($settingEmails)) {
                $parsed = array_filter(array_map('trim', explode(',', $settingEmails)));
                if (count($parsed) > 0) {
                    $adminEmails = array_unique(array_merge($adminEmails, $parsed));
                }
            }

            Mail::to($adminEmails)->send(new ClassQuotaMetMail($quotaData));
        } catch (\Throwable $e) {
            Log::error('Failed to send class quota met email to admin: ' . $e->getMessage());
        }

        try {
            $notificationWhatsapps = setting('notification_whatsapps');
            if (!empty($notificationWhatsapps)) {
                $whatsapps = array_filter(array_map('trim', explode(',', $notificationWhatsapps)));
                $waMessage = "Kuota Minimum Tercapai!\n\nProgram: {$quotaData['program_name']}\nBatch: {$quotaData['batch_name']}\nPeserta: {$studentCount}/{$minCapacity}\n\nSilakan konfirmasi di dashboard admin (menu Booking Class) apakah kelas ini akan berjalan - klik Kirim ke Siswa jika sudah pasti (misal tutor sudah tersedia), atau Tolak jika belum.";
                $waGateway = app(WhatsAppGateway::class);
                foreach ($whatsapps as $waNumber) {
                    if (!$waGateway->sendMessage($waNumber, $waMessage)) {
                        Log::error("Class quota met WA to admin ({$waNumber}) was not delivered - gateway returned false.");
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send class quota met WA to admin: ' . $e->getMessage());
        }
    }

    private function notifyStudent(ClassPeriod $classPeriod, User $student, int $studentCount, int $minCapacity): void
    {
        $quotaData = $this->quotaData($classPeriod, $studentCount, $minCapacity, isAdmin: false);
        $quotaData['recipient_name'] = $student->name;

        if (!empty($student->email)) {
            try {
                Mail::to($student->email)->send(new ClassQuotaMetMail($quotaData));
            } catch (\Throwable $e) {
                Log::error("Failed to send class quota met email to student {$student->id}: " . $e->getMessage());
            }
        }

        if (!empty($student->phone_number)) {
            try {
                $waMessage = "Kabar baik, {$student->name}!\n\nKelas {$quotaData['program_name']} batch {$quotaData['batch_name']} sudah mencapai kuota minimum ({$studentCount}/{$minCapacity} peserta) dan dipastikan akan berjalan sesuai jadwal.\n\nSampai jumpa di kelas!";
                if (!app(WhatsAppGateway::class)->sendMessage($student->phone_number, $waMessage)) {
                    Log::error("Class quota met WA to student {$student->id} was not delivered - gateway returned false.");
                }
            } catch (\Throwable $e) {
                Log::error("Failed to send class quota met WA to student {$student->id}: " . $e->getMessage());
            }
        }
    }

    private function quotaData(ClassPeriod $classPeriod, int $studentCount, int $minCapacity, bool $isAdmin): array
    {
        return [
            'is_admin' => $isAdmin,
            'program_name' => $classPeriod->program->name ?? '-',
            'batch_name' => $classPeriod->name,
            'learning_mode' => ucfirst($classPeriod->learning_mode ?? '-'),
            'teacher_name' => $classPeriod->teacher->name ?? null,
            'student_count' => $studentCount,
            'min_capacity' => $minCapacity,
        ];
    }
}
