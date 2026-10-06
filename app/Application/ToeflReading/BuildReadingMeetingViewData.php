<?php

namespace App\Application\ToeflReading;

use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\ToeflReading\Repositories\ToeflReadingRepository;

class BuildReadingMeetingViewData
{
    public function __construct(
        private readonly ToeflBatchResolver $batchResolver,
        private readonly ToeflReadingRepository $repository,
    ) {
    }

    public function handle(int $number, $user): array
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($number);

        $batchLockMap = collect();
        $selectedClassPeriod = $this->batchResolver->resolveToeflSelectedClassPeriod($user);
        if ($selectedClassPeriod) {
            $batchLockMap = collect($this->repository->getModuleLockMap($selectedClassPeriod->id, 'reading'));
        }

        $isLocked = $this->batchResolver->resolveToeflLockedState(
            $batchLockMap,
            (int) $meeting->meeting_number,
            (bool) $meeting->is_locked,
            (bool) $selectedClassPeriod
        );

        if ($user && in_array($user->active_role ?? $user->role, ['guest', 'guest_quick', 'test-taker'], true)) {
            $isLocked = ! ($meeting && $meeting->is_free_tier);
        }

        $allPassages = $this->repository->getPassagesWithQuestions($meeting->id);
        $existingScore = $user ? $this->repository->getScoreForUser($user->id, $number) : null;

        return [
            'meeting' => $meeting,
            'passages' => $allPassages,
            'existingScore' => $existingScore,
            'isLocked' => $isLocked,
            'lockedRedirectRoute' => 'assignments.toefl-itp.reading',
            'view' => $number === 13
                ? 'assignments.toefl-itp.reading.meeting13'
                : 'assignments.toefl-itp.reading.meeting',
        ];
    }
}