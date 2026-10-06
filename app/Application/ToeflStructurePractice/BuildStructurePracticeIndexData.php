<?php

namespace App\Application\ToeflStructurePractice;

use App\Domain\ToeflStructurePractice\Repositories\ToeflStructurePracticeRepository;
use App\Models\MeetingScore;
use App\Models\Program;
use App\Models\User;

class BuildStructurePracticeIndexData
{
    public function __construct(
        private readonly ToeflStructurePracticeRepository $repository,
    ) {}

    public function handle(?User $user = null): array
    {
        $activeMeetings = $this->repository->getActivePracticeExercises(70);

        $scoresByMeeting = [];
        if ($user) {
            $meetingScores = MeetingScore::where('user_id', $user->id)->get();

            foreach ($meetingScores as $ms) {
                $data = is_array($ms->answers_data) ? $ms->answers_data : json_decode($ms->answers_data, true);
                $scoresByMeeting[(int) $ms->meeting_number] = [
                    'score' => (float) $ms->score,
                    'correct_count' => $data['correct_count'] ?? null,
                    'total_questions' => $data['total_questions'] ?? null,
                    'submitted_at' => $ms->submitted_at,
                ];
            }
        }

        $practicePackages = collect(range(1, 70))->map(function ($number) use ($activeMeetings, $scoresByMeeting) {
            $activeMeeting = $activeMeetings[$number - 1] ?? null;

            if ($activeMeeting) {
                $meetingNum = (int) $activeMeeting->meeting_number;
                $scoreData = $scoresByMeeting[$meetingNum] ?? null;

                if (!$scoreData && session()->has('toefl_structure_score_' . $meetingNum)) {
                    $sess = session('toefl_structure_score_' . $meetingNum);
                    if (is_array($sess) && isset($sess['score'])) {
                        $scoreData = [
                            'score' => (float) $sess['score'],
                            'correct_count' => $sess['correct_count'] ?? null,
                            'total_questions' => $sess['total_questions'] ?? null,
                        ];
                    }
                }

                return [
                    'package_number' => $number,
                    'status' => 'available',
                    'title' => (string) $activeMeeting->title,
                    'meeting_number' => $meetingNum,
                    'question_count' => $this->repository->countQuestionsByMeeting($activeMeeting->id),
                    'score_data' => $scoreData,
                ];
            }

            return [
                'package_number' => $number,
                'title' => 'Coming Soon',
                'status' => 'coming_soon',
                'score_data' => null,
            ];
        });

        return [
            'practicePackages' => $practicePackages,
        ];
    }
}