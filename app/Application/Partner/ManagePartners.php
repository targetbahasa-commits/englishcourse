<?php

namespace App\Application\Partner;

use App\Models\Enrollment;
use App\Models\MeetingScore;
use App\Models\Partner;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;

class ManagePartners
{
    public function create(array $data, ?int $createdBy): Partner
    {
        $data['registration_code'] = $this->normalizeCode($data['registration_code'] ?? '') ?: $this->generateCode();
        $data['created_by'] = $createdBy;

        return Partner::create($data);
    }

    public function update(Partner $partner, array $data): void
    {
        if (array_key_exists('registration_code', $data)) {
            $data['registration_code'] = $this->normalizeCode($data['registration_code']) ?: $partner->registration_code;
        }

        $partner->update($data);
    }

    public function generateCode(): string
    {
        do {
            $code = 'MITRA-' . Str::upper(Str::random(6));
        } while (Partner::where('registration_code', $code)->exists());

        return $code;
    }

    private function normalizeCode(string $code): string
    {
        $code = Str::upper(trim($code));

        return preg_replace('/[^A-Z0-9\-]/', '', $code) ?? '';
    }

    /**
     * Stats + linked employees for the Partner show page.
     */
    public function stats(Partner $partner): array
    {
        $employees = User::where('partner_id', $partner->id)
            ->orderByDesc('created_at')
            ->get(['id', 'name', 'email', 'role', 'created_at']);

        $employeeIds = $employees->pluck('id');

        $enrollments = Enrollment::with('program')
            ->whereIn('user_id', $employeeIds)
            ->get();

        $totalRevenue = Payment::whereIn('user_id', $employeeIds)
            ->where('status', 'paid')
            ->sum('paid_amount');

        return [
            'employees'       => $employees,
            'employeeCount'   => $employees->count(),
            'enrollments'     => $enrollments,
            'enrollmentCount' => $enrollments->count(),
            'totalRevenue'    => (int) $totalRevenue,
        ];
    }

    /**
     * Backfill: link an already-registered user to this partner (search by
     * name/email on the Partner show page, for employees who had an account
     * before the partnership existed).
     */
    public function attachExistingUser(Partner $partner, int $userId): bool
    {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        $user->update(['partner_id' => $partner->id]);

        return true;
    }

    public function detachUser(Partner $partner, int $userId): void
    {
        User::where('id', $userId)->where('partner_id', $partner->id)->update(['partner_id' => null]);
    }

    /**
     * Graded assignment scores for this partner's employees, for the
     * "Unduh Lembar Nilai" CSV export - the score_sheet alternative to
     * printing individual certificates. Covers assignment-based scoring
     * (MeetingScore, used by Grammar Writing and other meeting-based
     * programs) - other test types (IELTS Writing essays, Final Test,
     * Placement Test) have their own separate scoring tables and aren't
     * included in this first version.
     */
    public function scoreSheetRows(Partner $partner): \Illuminate\Support\Collection
    {
        $employeeIds = User::where('partner_id', $partner->id)->pluck('id');

        return MeetingScore::whereIn('user_id', $employeeIds)
            ->where('is_reported', true)
            ->with('user', 'program')
            ->orderBy('user_id')
            ->orderBy('program_id')
            ->orderBy('meeting_number')
            ->get();
    }
}
