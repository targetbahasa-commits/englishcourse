<?php

namespace App\Application\ToeflStructure;

use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;

class SubmitStructureMeeting
{
    public function __construct(
        private readonly ToeflStructureRepository $repository,
    ) {}

    public function handle(int $number, array $userAnswers): array
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($number);
        $questions = $this->repository->getQuestionsByMeeting($meeting->id);

        $correctCount = 0;
        foreach ($questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
            if ($userAnswer === $question->correct_answer) {
                $correctCount++;
            }
        }

        $score = count($questions) > 0 ? ($correctCount / count($questions)) * 100 : 0;

        if (count($questions) === 40) {
            $conversion = [
                40 => 68, 39 => 68, 38 => 68,
                37 => 65, 36 => 63,
                35 => 61, 34 => 60, 33 => 59,
                32 => 58, 31 => 57, 30 => 56,
                29 => 55, 28 => 54, 27 => 53,
                26 => 52, 25 => 51, 24 => 50,
                23 => 49, 22 => 48, 21 => 48,
                20 => 47, 19 => 46, 18 => 45,
                17 => 44, 16 => 43, 15 => 42,
                14 => 40, 13 => 39, 12 => 38,
                11 => 36, 10 => 34, 9 => 32,
                8 => 31, 7 => 31, 6 => 31,
                5 => 31, 4 => 31, 3 => 31, 2 => 31, 1 => 31, 0 => 31,
            ];
            $score = ($conversion[$correctCount] ?? 31) * 10;
        }

        return [
            'score' => $score,
            'correct_count' => $correctCount,
            'total_questions' => count($questions),
            'user_answers' => $userAnswers,
        ];
    }
}