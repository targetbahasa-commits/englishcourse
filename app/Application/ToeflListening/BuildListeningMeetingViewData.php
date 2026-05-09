<?php

namespace App\Application\ToeflListening;

use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;

class BuildListeningMeetingViewData
{
    public function __construct(
        private readonly ToeflBatchResolver $batchResolver,
        private readonly ToeflListeningRepository $repository,
    ) {
    }

    public function handle(int $number, $user, ?int $setNumber = null): array
    {
        if (($number < 1 || $number > 20) && !in_array($number, [101, 102, 103], true)) {
            abort(404);
        }

        $meeting = $this->repository->findMeetingByNumber($number);
        $batchLockMap = collect();
        $selectedClassPeriod = $this->batchResolver->resolveToeflSelectedClassPeriod($user);

        if ($selectedClassPeriod) {
            $batchLockMap = collect($this->repository->getModuleLockMap($selectedClassPeriod->id, 'listening'));
        }

        $isLocked = $meeting
            ? $this->batchResolver->resolveToeflLockedState(
                $batchLockMap,
                (int) $meeting->meeting_number,
                (bool) $meeting->is_locked,
                (bool) $selectedClassPeriod,
            )
            : false;

        $questions = $this->repository->getQuestions($number, $setNumber ?: null);

        $existingScore = $this->repository->getScoreForUser($user->id, $number, $setNumber ?: null);

        $availableSets = $this->repository->getAvailableSets($number);

        if ($availableSets === [] && in_array($number, [2, 3, 4], true)) {
            $availableSets = [1, 2, 3];
        }

        $view = ($number >= 2 && $number <= 16)
            ? 'assignments.toefl-itp.listening.meeting' . $number
            : 'assignments.toefl-itp.listening.meeting';

        return [
            'isLocked' => $isLocked,
            'meeting' => $meeting,
            'view' => $view,
            'data' => [
                'questions' => $questions,
                'number' => $number,
                'set' => $setNumber,
                'existingScore' => $existingScore,
                'availableSets' => $availableSets,
                'transcript_enabled' => $meeting ? $meeting->transcript_enabled : false,
            ],
        ];
    }
}