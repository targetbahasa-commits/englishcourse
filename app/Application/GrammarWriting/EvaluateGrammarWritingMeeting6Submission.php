<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting6Submission
{
    use ScoresWordMatchAnswers;

    public function handle(array $userAnswers, array $verbPatterns, array $toInfinitive, array $gerund, array $paragraph): array
    {
        $results = [];
        $totalScore = 0;
        $totalItems = 0;

        [$results['verbPatterns'], $score, $count] = $this->evaluateGroup($userAnswers['verbPatterns'] ?? [], $verbPatterns);
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
            'meeting6_submitted' => true,
            'meeting6_results' => $results,
            'meeting6_final_score' => $totalItems > 0 ? round($totalScore / $totalItems) : 0,
            'meeting6_user_answers' => $userAnswers,
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
        return $this->scoreWordMatchAnswer($userTranslation, $correctAnswer, 100);
    }
}