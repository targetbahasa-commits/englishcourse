<?php

namespace App\Application\ToeflStructure;

use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;
use Illuminate\Http\Request;

class BuildStructureMeetingViewData
{
    public function __construct(
        private readonly ToeflBatchResolver $batchResolver,
        private readonly StructureExplanationPathResolver $explanationPathResolver,
        private readonly ToeflStructureRepository $repository,
    ) {
    }

    public function handle(int $number, $user, Request $request): array
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($number);

        $batchLockMap = collect();
        $selectedClassPeriod = $this->batchResolver->resolveToeflSelectedClassPeriod($user);
        if ($selectedClassPeriod) {
            $batchLockMap = collect($this->repository->getModuleLockMap($selectedClassPeriod->id, 'structure'));
        }

        $isLocked = $this->batchResolver->resolveToeflLockedState(
            $batchLockMap,
            (int) $meeting->meeting_number,
            (bool) $meeting->is_locked,
            (bool) $selectedClassPeriod
        );

        if ($number < 50 && !$request->has('exercise')) {
            $main = $meeting;
            $exercises = $this->repository->getRelatedExercises($number, $main->title);

            return [
                'isLocked' => $isLocked,
                'lockedRedirectRoute' => 'assignments.toefl-itp.structure',
                'view' => 'assignments.toefl-itp.structure.selection',
                'data' => [
                    'main' => $main,
                    'exercises' => $exercises,
                ],
            ];
        }

        $questions = $this->repository->getQuestionsByMeeting($meeting->id);
        $hasSavedExplanation = file_exists($this->explanationPathResolver->resolve((int) $meeting->meeting_number));

        return [
            'isLocked' => $isLocked,
            'lockedRedirectRoute' => 'assignments.toefl-itp.structure',
            'view' => 'assignments.toefl-itp.structure.meeting',
            'data' => [
                'number' => $number,
                'title' => $meeting->title,
                'questions' => $questions,
                'hasSavedExplanation' => $hasSavedExplanation,
            ],
        ];
    }
}