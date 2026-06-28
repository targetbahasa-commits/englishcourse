<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting5Submission
{
    use ScoresWordMatchAnswers;

    public function handle(array $userAnswers, array $gerundInfinitiveComplex, array $toInfinitive, array $gerund, array $paragraph): array
    {
        $results = [];
        $totalScore = 0;
        $totalItems = 0;

        [$results['gerundInfinitiveComplex'], $score, $count] = $this->evaluateGroup($userAnswers['gerundInfinitiveComplex'] ?? [], $gerundInfinitiveComplex);
        $totalScore += $score;
        $totalItems += $count;

        [$results['toInfinitive'], $score, $count] = $this->evaluateGroup($userAnswers['toInfinitive'] ?? [], $toInfinitive);
        $totalScore += $score;
        $totalItems += $count;

        [$results['gerund'], $score, $count] = $this->evaluateGroup($userAnswers['gerund'] ?? [], $gerund);
        $totalScore += $score;
        $totalItems += $count;

        $paragraphAnswer = trim((string) ($userAnswers['paragraph'] ?? ''));
        $paragraphResult = $this->evaluateAnswer($paragraphAnswer, (string) ($paragraph['en'] ?? ''));
        $results['paragraph'] = $paragraphResult + ['correct_answer' => $paragraph['en'] ?? ''];
        $totalScore += $paragraphResult['score'];
        $totalItems++;

        return [
            'meeting5_submitted' => true,
            'meeting5_results' => $results,
            'meeting5_final_score' => $totalItems > 0 ? round($totalScore / $totalItems) : 0,
            'meeting5_user_answers' => $userAnswers,
        ];
    }

    private function evaluateGroup(array $groupAnswers, array $questions): array
    {
        $results = [];
        $totalScore = 0;
        $totalItems = 0;

        foreach ($questions as $index => $question) {
            $userTranslation = trim((string) ($groupAnswers[$index] ?? ''));
            $result = $this->evaluateAnswer($userTranslation, (string) $question['en']);

            $results[$index] = $result + ['correct_answer' => $question['en']];
            $totalScore += $result['score'];
            $totalItems++;
        }

        return [$results, $totalScore, $totalItems];
    }

    private function evaluateAnswer(string $userTranslation, string $correctAnswer): array
    {
        return $this->scoreBestVariantWordMatchAnswer($userTranslation, $correctAnswer, 100);
    }
}