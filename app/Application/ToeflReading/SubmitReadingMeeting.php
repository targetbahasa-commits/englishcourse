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
        foreach ($questions as $question) {
            $userAnswer = $requestData['question_' . $question->id] ?? null;
            if ($userAnswer && strtoupper((string) $userAnswer) === strtoupper((string) $question->correct_answer)) {
                $correctCount++;
            }
        }

        $totalQuestions = $questions->count();
        $score = 0;

        if ($totalQuestions == 50) {
            $conversion = [
                50 => 67, 49 => 66, 48 => 65, 47 => 64, 46 => 63,
                45 => 62, 44 => 61, 43 => 60, 42 => 59, 41 => 58, 40 => 57,
                39 => 57, 38 => 56, 37 => 55, 36 => 54, 35 => 54,
                34 => 53, 33 => 52, 32 => 52, 31 => 51, 30 => 51,
                29 => 50, 28 => 49, 27 => 49, 26 => 48, 25 => 48,
                24 => 47, 23 => 47, 22 => 46, 21 => 45, 20 => 45,
                19 => 44, 18 => 43, 17 => 43, 16 => 42, 15 => 41,
                14 => 41, 13 => 40, 12 => 40, 11 => 39, 10 => 38,
                9 => 37, 8 => 37, 7 => 36, 6 => 35, 5 => 34,
                4 => 33, 3 => 32, 2 => 31, 1 => 31, 0 => 31,
            ];
            $score = ($conversion[$correctCount] ?? 31) * 10;
        } elseif ($totalQuestions > 0) {
            $score = ($correctCount / $totalQuestions) * 100;
        }

        $this->repository->saveScore($userId, $meetingNumber, [
            'score' => $score,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
        ]);

        return "Assignment submitted! Your Score: {$score} ({$correctCount}/{$totalQuestions} correct)";
    }
}