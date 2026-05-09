<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;
use Illuminate\Support\Collection;

class EvaluateGrammarWritingMeeting5Submission
{
    use ScoresWordMatchAnswers;

    public function handle(array $userAnswers, Collection $sentenceQuestions, Collection $matrixQuestions, Collection $prQuestions): array
    {
        $results = [];
        $totalScore = 0;
        $totalItems = 0;

        foreach ($sentenceQuestions as $question) {
            $questionKey = $question->question_number;
            $userTranslation = trim((string) ($userAnswers['sentences'][$questionKey] ?? ''));
            $result = $this->evaluateAnswer($userTranslation, (string) $question->correct_answer);

            $results['sentences'][$questionKey] = $result + ['correct_answer' => $question->correct_answer];
            $totalScore += $result['score'];
            $totalItems++;
        }

        foreach ($matrixQuestions as $question) {
            $key = str_replace(' ', '_', strtolower((string) $question->tense)) . '_' . $question->structure;
            $userTranslation = trim((string) ($userAnswers['matrix'][$key] ?? ''));
            $result = $this->evaluateAnswer($userTranslation, (string) $question->correct_answer);

            $results['matrix'][$question->tense][$question->structure] = $result + ['correct_answer' => $question->correct_answer];
            $totalScore += $result['score'];
            $totalItems++;
        }

        foreach ($prQuestions->values() as $index => $question) {
            $userTranslation = trim((string) ($userAnswers['pr'][$index] ?? ''));
            $result = $this->evaluateAnswer($userTranslation, (string) $question->correct_answer);

            $results['pr'][$index] = $result + ['correct_answer' => $question->correct_answer];
            $totalScore += $result['score'];
            $totalItems++;
        }

        return [
            'meeting5_submitted' => true,
            'meeting5_results' => $results,
            'meeting5_final_score' => $totalItems > 0 ? round($totalScore / $totalItems) : 0,
            'meeting5_user_answers' => $userAnswers,
        ];
    }

    private function evaluateAnswer(string $userTranslation, string $correctAnswer): array
    {
        return $this->scoreBestVariantWordMatchAnswer($userTranslation, $correctAnswer, 100);
    }
}