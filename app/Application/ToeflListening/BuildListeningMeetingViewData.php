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
        if ($number < 1 && !in_array($number, [101, 102, 103], true)) {
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

        if ($user && in_array($user->active_role ?? $user->role, ['guest', 'guest_quick', 'test-taker'], true)) {
            $isLocked = ! ($meeting && $meeting->is_free_tier);
        }

        if ($number === 21) {
            // Serve Mockup UI for Meeting 21
            $mockupViewData = app(\App\Application\ToeflMockup\BuildMockupPackageViewData::class)->handle(1);
            $mockupViewData['isFullMockTest'] = false;
            $mockupViewData['packageMode'] = true;
            $mockupViewData['listeningSubmitRoute'] = route('assignments.toefl-itp.listening.meeting.submit', $number);
            
            return [
                'isLocked' => $isLocked,
                'meeting' => $meeting,
                'view' => 'assignments.toefl-itp.mockup',
                'data' => $mockupViewData,
            ];
        }

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
