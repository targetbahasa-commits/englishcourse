<?php

namespace App\Application\ToeflListening;

use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;

class ManageListeningMeetings
{
    public function __construct(
        private readonly ToeflListeningRepository $repository,
    ) {}
    public function addSet(int $number): int
    {
        $maxSet = $this->repository->getMaxSetNumber($number);
        $nextSet = $maxSet ? $maxSet + 1 : 1;

        $this->repository->createQuestion([
            'meeting_number' => $number,
            'set_number' => $nextSet,
            'question_number' => 1,
            'question_text' => 'New Set Placeholder',
            'option_a' => 'Option A',
            'option_b' => 'Option B',
            'option_c' => 'Option C',
            'option_d' => 'Option D',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        return $nextSet;
    }

    public function removeSet(int $number, ?int $setNumber): bool
    {
        if (!$setNumber) {
            return false;
        }

        return $this->repository->deleteQuestionsByMeetingAndSet($number, $setNumber);
    }

    public function toggleLock(int $number, ?int $classPeriodId): string
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($number);

        if ($classPeriodId) {
            $batchRule = $this->repository->findBatchRuleForMeeting($classPeriodId, 'listening', $meeting->meeting_number);

            if ($batchRule) {
                $isOpenNow = !$batchRule->is_open;
                $this->repository->updateBatchRule($batchRule->id, $isOpenNow);
            } else {
                $this->repository->createBatchRule([
                    'class_period_id' => $classPeriodId,
                    'module' => 'listening',
                    'meeting_number' => $meeting->meeting_number,
                    'is_open' => true,
                ]);
                $isOpenNow = true;
            }

            $classPeriod = $this->repository->findClassPeriod($classPeriodId);
            $label = $isOpenNow ? 'OPEN' : 'LOCKED';

            return "Meeting is now {$label} for batch {$classPeriod->name}.";
        }

        $this->repository->toggleMeetingLock($number);

        return 'Meeting lock status updated.';
    }

    public function toggleTranscript(int $number): string
    {
        return $this->repository->toggleMeetingTranscript($number);
    }
}