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
        if (($number < 1 || $number > 20) && !in_array($number, [101, 102, 103], true)) {
            abort(404);
        }

        $questions = $this->repository->getQuestions($number, $setNumber ?: null);
        $correctCount = 0;
        $userAnswers = [];

        foreach ($questions as $question) {
            $userAnswer = $answers['question_' . $question->id] ?? null;
            $userAnswers[$question->id] = $userAnswer;

            if ($userAnswer === $question->correct_answer) {
                $correctCount++;
            }
        }

        $score = $questions->count() > 0 ? ($correctCount / $questions->count()) * 100 : 0;

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