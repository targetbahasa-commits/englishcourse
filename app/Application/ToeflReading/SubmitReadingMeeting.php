<?php

namespace App\Application\ToeflReading;

use App\Domain\ToeflReading\Repositories\ToeflReadingRepository;

class SubmitReadingMeeting
{
    public function __construct(
        private readonly ToeflReadingRepository $repository,
    ) {}

    public function handle(int $meetingNumber, array $requestData, ?int $userId): string
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($meetingNumber);
        $questions = $this->repository->getQuestionsByMeeting($meeting->id);

        $correctCount = 0;
        $userAnswers = [];
        foreach ($questions as $question) {
            $userAnswer = $requestData['question_' . $question->id] ?? null;
            $userAnswers[$question->id] = $userAnswer ? strtoupper((string) $userAnswer) : null;
            if ($userAnswer && strtoupper((string) $userAnswer) === strtoupper((string) $question->correct_answer)) {
                $correctCount++;
            }
        }

        $totalQuestions = count($questions);
        $score = 0;

        if ($totalQuestions == 50) {
            $conversion = [
                50 => 67, 49 => 66, 48 => 65,
                47 => 64, 46 => 63, 45 => 62,
                44 => 61, 43 => 60, 42 => 59,
                41 => 58, 40 => 58, 39 => 57,
                38 => 56, 37 => 56, 36 => 55,
                35 => 54, 34 => 54, 33 => 53,
                32 => 52, 31 => 52, 30 => 51,
                29 => 50, 28 => 50, 27 => 49,
                26 => 48, 25 => 48, 24 => 47,
                23 => 46, 22 => 45, 21 => 44,
                20 => 43, 19 => 42, 18 => 41,
                17 => 40, 16 => 38, 15 => 37,
                14 => 35, 13 => 33, 12 => 31,
                11 => 31, 10 => 31, 9 => 31, 8 => 31, 7 => 31, 6 => 31, 5 => 31, 4 => 31, 3 => 31, 2 => 31, 1 => 31, 0 => 31,
            ];
            $score = ($conversion[$correctCount] ?? 31) * 10;
        } elseif ($totalQuestions > 0) {
            $score = ($correctCount / $totalQuestions) * 100;
        }

        $this->repository->saveScore($userId, $meetingNumber, [
            'score' => $score,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'answers' => $userAnswers,
        ]);

        return "Assignment submitted! Your Score: {$score} ({$correctCount}/{$totalQuestions} correct)";
    }
}