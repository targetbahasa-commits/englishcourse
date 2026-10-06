<?php

namespace App\Application\ToeflStructure;

use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;
use App\Models\AssignmentDraft;
use App\Models\MeetingScore;
use App\Models\Program;
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

        if ($user && in_array($user->active_role ?? $user->role, ['guest', 'guest_quick', 'test-taker'], true)) {
            $isLocked = ! ($meeting && $meeting->is_free_tier);
        }

        if ($number < 50 && $request->has('material')) {
            $main = $meeting;
            $exercises = $this->repository->getRelatedExercises($number, $main->title);

            return [
                'isLocked' => $isLocked,
                'lockedRedirectRoute' => 'assignments.toefl-itp.structure',
                'view' => 'assignments.toefl-itp.structure.material',
                'data' => [
                    'main' => $main,
                    'exercises' => $exercises,
                ],
            ];
        }

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

        $sessionKey = 'toefl_structure_score_' . $number . ($request->has('exercise') ? '_ex_' . $request->input('exercise') : '');
        $scoreData = session('score_data') ?? session($sessionKey) ?? session('toefl_structure_score_' . $number);

        if (!$scoreData && $user) {
            $programId = Program::where('slug', 'toefl-itp')->value('id') ?? 2;
            $meetingScore = MeetingScore::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->where(function ($q) use ($programId, $user) {
                    $q->where('program_id', $programId);
                    if (!empty($user->program_id)) {
                        $q->orWhere('program_id', $user->program_id);
                    }
                })
                ->latest('submitted_at')
                ->first();

            if ($meetingScore) {
                $scoreData = $meetingScore->answers_data;
                if (empty($scoreData)) {
                    $scoreData = [
                        'score' => $meetingScore->score,
                        'correct_count' => 0,
                        'total_questions' => count($questions),
                        'user_answers' => is_array($meetingScore->answers) ? $meetingScore->answers : [],
                    ];
                }
            }
        }

        $draftAnswers = [];
        if (!$scoreData && $user) {
            $programId = Program::where('slug', 'toefl-itp')->value('id') ?? 2;
            $draft = AssignmentDraft::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->where(function ($q) use ($programId, $user) {
                    $q->where('program_id', $programId);
                    if (!empty($user->program_id)) {
                        $q->orWhere('program_id', $user->program_id);
                    }
                })
                ->first();

            if ($draft && is_array($draft->answers)) {
                $draftAnswers = $draft->answers;
            }
        }

        return [
            'isLocked' => $isLocked,
            'lockedRedirectRoute' => 'assignments.toefl-itp.structure',
            'view' => 'assignments.toefl-itp.structure.meeting',
            'data' => [
                'number' => $number,
                'title' => $meeting->title,
                'meeting' => $meeting,
                'questions' => $questions,
                'hasSavedExplanation' => $hasSavedExplanation,
                'scoreData' => $scoreData,
                'draftAnswers' => $draftAnswers,
            ],
        ];
    }
}