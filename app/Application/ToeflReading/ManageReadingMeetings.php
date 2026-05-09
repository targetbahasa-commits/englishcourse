<?php

namespace App\Application\ToeflReading;

use App\Domain\ToeflReading\Repositories\ToeflReadingRepository;

class ManageReadingMeetings
{
    public function __construct(
        private readonly ToeflReadingRepository $repository,
    ) {}

    public function reorder(array $meetingIds): void
    {
        $this->repository->reorderMeetings($meetingIds);
    }

    public function toggleLock(int $meetingId, int $meetingNumber, ?int $classPeriodId): string
    {
        if ($classPeriodId) {
            $batchRule = $this->repository->findBatchRuleForMeeting($classPeriodId, 'reading', $meetingNumber);

            if ($batchRule) {
                $isOpenNow = !$batchRule->is_open;
                $this->repository->updateBatchRule($batchRule->id, $isOpenNow);
            } else {
                $this->repository->createBatchRule([
                    'class_period_id' => $classPeriodId,
                    'module' => 'reading',
                    'meeting_number' => $meetingNumber,
                    'is_open' => true,
                ]);
                $isOpenNow = true;
            }

            $classPeriod = $this->repository->findClassPeriod($classPeriodId);
            $label = $isOpenNow ? 'OPEN' : 'LOCKED';

            return "Meeting is now {$label} for batch {$classPeriod->name}.";
        }

        $this->repository->toggleMeetingLockById($meetingId);

        return 'Meeting lock status updated.';
    }

    public function create(int $meetingNumber, string $title): void
    {
        $this->repository->createMeeting($meetingNumber, $title);
    }

    public function update(int $meetingId, int $meetingNumber, string $title): void
    {
        $this->repository->updateMeeting($meetingId, $meetingNumber, $title);
    }

    public function destroy(int $meetingId): void
    {
        $this->repository->deleteMeeting($meetingId);
    }
}