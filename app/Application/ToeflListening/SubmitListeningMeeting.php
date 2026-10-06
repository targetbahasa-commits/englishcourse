<?php

namespace App\Application\ToeflListening;

use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;

class SubmitListeningMeeting
{
    public function __construct(
        private readonly ToeflListeningRepository $repository,
    ) {}
    public function handle(int $number, int $userId, ?int $setNumber, array $answers): array
    {
        if ($number < 1 && !in_array($number, [101, 102, 103], true)) {
            abort(404);
        }

        if ($number === 21) {
            // Matches the query BuildMockupPackageViewData/ResolveMockupPackageContent
            // actually use to load these same questions for display - the column this
            // used to filter on ('is_header') does not exist on toefl_mockup_questions,
            // which made every meeting-21 submission fail with a QueryException.
            $questions = \App\Models\ToeflMockupQuestion::where('section', 'listening')
                ->where('package_number', 1)
                ->orderBy('question_number')
                ->get();
        } else {
            $questions = collect($this->repository->getQuestions($number, $setNumber ?: null));
        }

        $correctCount = 0;
        $userAnswers = [];

        foreach ($questions as $question) {
            $userAnswer = $answers['question_' . $question->id] ?? $answers['answers'][$question->id] ?? null;
            $userAnswers[$question->id] = $userAnswer;

            if ($userAnswer === $question->correct_answer) {
                $correctCount++;
            }
        }

        $score = $questions->count() > 0 ? ($correctCount / $questions->count()) * 100 : 0;

        if ($questions->count() === 50) {
            $conversion = [
                50 => 68, 49 => 66, 48 => 64,
                47 => 62, 46 => 60, 45 => 59,
                44 => 58, 43 => 57, 42 => 56,
                41 => 56, 40 => 55, 39 => 54,
                38 => 54, 37 => 53, 36 => 52,
                35 => 52, 34 => 52, 33 => 51,
                32 => 50, 31 => 50, 30 => 49,
                29 => 49, 28 => 48, 27 => 48,
                26 => 47, 25 => 46, 24 => 46,
                23 => 46, 22 => 46, 21 => 45,
                20 => 44, 19 => 44, 18 => 43,
                17 => 42, 16 => 41, 15 => 40,
                14 => 39, 13 => 38, 12 => 36,
                11 => 33, 10 => 32, 9 => 32,
                8 => 31, 7 => 31, 6 => 31, 5 => 31, 4 => 31, 3 => 31, 2 => 31, 1 => 31, 0 => 31,
            ];
            $score = ($conversion[$correctCount] ?? 31) * 10;
        }

        $updateCriteria = [
            'user_id' => $userId,
            'meeting_number' => $number,
        ];

        if ($setNumber) {
            $updateCriteria['set_number'] = $setNumber;
        }

        $this->repository->saveScore($updateCriteria, [
            'score' => $score,
            'answers' => $userAnswers,
            'submitted_at' => now(),
        ]);

        return [
            'score' => $score,
            'correct_count' => $correctCount,
            'total_question' => $questions->count(),
            'user_answers' => $userAnswers,
            'set_number' => $setNumber,
        ];
    }
}
