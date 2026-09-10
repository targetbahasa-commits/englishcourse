<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;
use App\Models\ClassMeeting;
use App\Models\ClassMeetingChangeRequest;
use App\Models\Program;
use App\Models\User;

class ManageGrammarWritingMeetings
{
    public function __construct(
        private readonly GrammarWritingRepository $repository
    ) {}

    public function updateBatchPeriod(int $programId, int $classPeriodId): array
    {
        $program = $this->repository->findProgramByIdWithClassPeriods($programId);

        if ($program->classPeriods->isNotEmpty() && !$program->classPeriods->pluck('id')->contains($classPeriodId)) {
            return [
                'ok' => false,
                'message' => 'Selected batch is invalid for this program.',
            ];
        }

        $period = $program->classPeriods->firstWhere('id', $classPeriodId);

        $program->update(['active_class_period_id' => $classPeriodId]);

        return [
            'ok' => true,
            'message' => 'Active batch set to ' . ($period ? $period->name : 'Unknown') . '.',
        ];
    }

    /**
     * "Jam Kelas" - lets an admin/teacher designate which specific
     * ClassMeeting is the one happening right now, for a program whose
     * meetings are auto-generated one per week (see
     * Admin\ClassScheduleController::syncClassPeriodMeetings()) and so can
     * drift from the day a class is actually, really held that week.
     *
     * If the picked meeting's own scheduled date already is today, it's
     * not really a correction - just confirming the system already has it
     * right - so it applies immediately. Anything else is queued as a
     * ClassMeetingChangeRequest for an admin to confirm on the Class
     * Schedule page, since accepting it means moving that meeting's real
     * calendar date.
     */
    public function updateActiveClassMeeting(int $programId, int $classMeetingId, User $user): array
    {
        $classMeeting = ClassMeeting::with('classPeriod')->find($classMeetingId);

        if (!$classMeeting || !$classMeeting->classPeriod || $classMeeting->classPeriod->program_id !== $programId) {
            return [
                'ok' => false,
                'message' => 'Jadwal yang dipilih tidak valid untuk program ini.',
            ];
        }

        $today = now()->toDateString();
        $label = 'Meeting ' . $classMeeting->meeting_number
            . ($classMeeting->meeting_date ? ' - ' . $classMeeting->meeting_date->translatedFormat('l, d M Y') : '');

        if (optional($classMeeting->meeting_date)->toDateString() === $today) {
            Program::whereKey($programId)->update(['active_class_meeting_id' => $classMeeting->id]);

            return [
                'ok' => true,
                'message' => "Jam kelas aktif diatur ke {$label}.",
            ];
        }

        ClassMeetingChangeRequest::create([
            'program_id' => $programId,
            'class_period_id' => $classMeeting->class_period_id,
            'class_meeting_id' => $classMeeting->id,
            'requested_by' => $user->id,
            'requested_date' => $today,
            'status' => 'pending',
        ]);

        return [
            'ok' => true,
            'message' => "{$label} berbeda dari jadwal sistem hari ini - menunggu konfirmasi admin.",
        ];
    }

    public function updateActivePeriod(string $period): array
    {
        $program = $this->repository->findProgramBySlugWithMeetingsAndClassPeriods('grammar-for-writing');
        $program->update(['period' => $period]);

        return [
            'message' => 'Active batch set to ' . $period . '.',
            'success_state' => 'batch',
        ];
    }

    public function toggleLock(int $meetingId, ?int $classPeriodId): array
    {
        return $this->repository->toggleMeetingLock($meetingId, $classPeriodId);
    }
}