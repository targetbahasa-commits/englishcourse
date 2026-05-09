<?php

namespace App\Application\GrammarWriting;

class EvaluateGrammarWritingMeeting2Submission
{
    public function handle(
        int $stage,
        array $input,
        array $tenses,
        array $translationSentences,
        array $translationMatrix,
        int $scorePart1,
    ): array {
        if ($stage === 1) {
            return $this->evaluateStageOne($input, $tenses);
        }

        if ($stage === 2) {
            return $this->evaluateStageTwo($input, $translationSentences, $translationMatrix, $scorePart1);
        }

        return [
            'session' => [],
            'saveScore' => false,
            'totalScore' => null,
        ];
    }

    private function evaluateStageOne(array $input, array $tenses): array
    {
        $results = [];
        $scorePart1 = 0;
        $totalItems = 0;

        foreach ($tenses as $tenseName => $formulas) {
            foreach (['verbal', 'nominal', 'passive'] as $type) {
                $key = str_replace(' ', '_', strtolower($tenseName)) . '_' . $type;
                $userAnswer = trim((string) ($input['tenses'][$key] ?? ''));
                $correctAnswer = (string) ($formulas[$type] ?? '');

                $normUser = strtolower((string) preg_replace('/\s+/', '', $userAnswer));
                $normCorrect = strtolower((string) preg_replace('/\s+/', '', $correctAnswer));

                $isCorrect = $normUser === $normCorrect;
                if ($isCorrect) {
                    $scorePart1++;
                }
                $totalItems++;

                $results[$tenseName][$type] = [
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer,
                    'is_correct' => $isCorrect,
                ];
            }
        }

        $finalScorePart1 = $totalItems > 0 ? round(($scorePart1 / $totalItems) * 50) : 0;

        return [
            'session' => [
                'meeting2_stage' => 2,
                'meeting2_results' => $results,
                'meeting2_score_part1' => $finalScorePart1,
            ],
            'saveScore' => false,
            'totalScore' => null,
        ];
    }

    private function evaluateStageTwo(array $input, array $translationSentences, array $translationMatrix, int $scorePart1): array
    {
        $transResults = ['sentences' => [], 'matrix' => []];
        $scorePart2 = 0;
        $totalItems = 0;

        foreach ($translationSentences as $index => $item) {
            $userAnswer = trim((string) ($input['trans_sent'][$index] ?? ''));
            $correctAnswer = (string) ($item['en'] ?? '');

            $isCorrect = strtolower(rtrim($userAnswer, '.!')) === strtolower(rtrim($correctAnswer, '.!'));
            if ($isCorrect) {
                $scorePart2++;
            }
            $totalItems++;

            $transResults['sentences'][$index] = [
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        foreach ($translationMatrix as $tenseName => $items) {
            foreach (['verbal', 'nominal', 'passive'] as $type) {
                $key = str_replace(' ', '_', strtolower($tenseName)) . '_' . $type;
                $userAnswer = trim((string) ($input['trans_matrix'][$key] ?? ''));
                $correctAnswer = (string) ($items[$type]['en'] ?? '');

                $isCorrect = strtolower(rtrim($userAnswer, '.!')) === strtolower(rtrim($correctAnswer, '.!'));
                if ($isCorrect) {
                    $scorePart2++;
                }
                $totalItems++;

                $transResults['matrix'][$tenseName][$type] = [
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer,
                    'is_correct' => $isCorrect,
                ];
            }
        }

        $finalScorePart2 = $totalItems > 0 ? round(($scorePart2 / $totalItems) * 50) : 0;
        $totalScore = $scorePart1 + $finalScorePart2;

        return [
            'session' => [
                'meeting2_stage' => 3,
                'meeting2_trans_results' => $transResults,
                'meeting2_score_part2' => $finalScorePart2,
                'meeting2_total_score' => $totalScore,
            ],
            'saveScore' => true,
            'totalScore' => $totalScore,
        ];
    }
}