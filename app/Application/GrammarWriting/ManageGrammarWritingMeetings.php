<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;

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