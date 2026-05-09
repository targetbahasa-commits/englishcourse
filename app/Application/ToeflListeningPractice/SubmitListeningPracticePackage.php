<?php

namespace App\Application\ToeflListeningPractice;

use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;
use RuntimeException;

class SubmitListeningPracticePackage
{
    public function __construct(
        private readonly ListeningPracticeRepository $listeningPracticeRepository,
    ) {
    }

    public function handle(array $requestData): \App\Application\ToeflListeningPractice\ListeningPracticePackageSubmissionResult
    {
        $questions = collect($this->listeningPracticeRepository->getAllQuestions());

        if ($questions->isEmpty()) {
            throw new RuntimeException('Soal paket belum tersedia.');
        }

        $correctCount = 0;
        $reviewRows = [];
        $totalQuestions = $questions->count();

        foreach ($questions as $question) {
            $userAnswer = strtoupper((string) ($requestData['question_' . $question->id] ?? ''));
            $correctAnswer = strtoupper((string) $question->correct_answer);
            $isCorrect = $userAnswer !== '' && $userAnswer === $correctAnswer;

            if ($isCorrect) {
                $correctCount++;
            }

            $reviewRows[] = [
                'question_number' => (int) $question->question_number,
                'part' => (string) $question->part,
                'user_answer' => $userAnswer !== '' ? $userAnswer : '-',
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
                'is_unanswered' => $userAnswer === '',
            ];
        }

        $score = (int) round(($correctCount / max(1, $totalQuestions)) * 100);

        return new \App\Application\ToeflListeningPractice\ListeningPracticePackageSubmissionResult(
            success: true,
            score: $score,
            correct: $correctCount,
            total: $totalQuestions,
            message: "Jawaban listening tersimpan. Skor: {$score} ({$correctCount}/{$totalQuestions} benar)",
            reviewRows: $reviewRows,
        );
    }
}