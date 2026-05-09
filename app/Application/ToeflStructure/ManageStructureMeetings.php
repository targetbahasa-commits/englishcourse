<?php

namespace App\Application\ToeflStructure;

use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;

class ManageStructureMeetings
{
    public function __construct(
        private readonly ToeflStructureRepository $repository,
    ) {
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

    public function reorder(array $meetingIds): void
    {
        $this->repository->reorderMeetings($meetingIds);
    }

    public function toggleLock(int $meetingId, int $meetingNumber, ?int $classPeriodId): string
    {
        if ($classPeriodId) {
            $batchRule = $this->repository->findBatchRuleForMeeting($classPeriodId, 'structure', $meetingNumber);

            if ($batchRule) {
                $isOpenNow = !$batchRule->is_open;
                $this->repository->updateBatchRule($batchRule->id, $isOpenNow);
            } else {
                $this->repository->createBatchRule([
                    'class_period_id' => $classPeriodId,
                    'module' => 'structure',
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

    public function addSet(int $number): void
    {
        $parent = $this->repository->findMeetingByNumberOrFail($number);

        $max = $this->repository->getMaxExerciseNumber();
        $next = $max ? $max + 1 : 51;

        $currentCount = $this->repository->countMeetingsByTitlePattern($parent->title . '%');
        $nextIndex = $currentCount + 1;

        $this->repository->createExerciseMeeting([
            'meeting_number' => $next,
            'title' => $parent->title . ' (Exercise ' . $nextIndex . ')',
            'is_locked' => 0,
        ]);

        $newMeeting = $this->repository->findMeetingByNumber($next);
        $this->repository->createQuestion([
            'section_id' => $newMeeting->id,
            'question_number' => 1,
            'question_text' => 'New Exercise Placeholder',
            'option_a' => 'A',
            'option_b' => 'B',
            'option_c' => 'C',
            'option_d' => 'D',
            'correct_answer' => 'A',
        ]);
    }

    public function removeSet(?int $targetNumber): string
    {
        if ($targetNumber === 6) {
            return 'Cannot delete the main lesson here.';
        }

        $deleted = $this->repository->deleteExerciseMeeting((int) $targetNumber);

        return $deleted ? 'Exercise deleted successfully.' : 'Meeting not found.';
    }
}