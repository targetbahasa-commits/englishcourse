<?php

namespace App\Application\GrammarWriting;

class EvaluateGrammarWritingMeeting4Submission
{
    public function handle(
        array $input,
        array $translationSentences,
        array $matrixIntroSentences,
        array $translationMatrix,
    ): array {
        // Part 1: PR sentences
        $transResults = ['sentences' => [], 'matrixIntro' => [], 'matrix' => []];
        $part1Score = 0;
        $totalItemsPart1 = 0;

        foreach ($translationSentences as $index => $item) {
            $userAnswer = trim((string) ($input['trans_sent'][$index] ?? ''));
            $correctAnswer = (string) ($item['en'] ?? '');

            $isCorrect = strtolower(rtrim($userAnswer, '.!')) === strtolower(rtrim($correctAnswer, '.!')) && $userAnswer !== '';
            if ($isCorrect) {
                $part1Score++;
            }
            $totalItemsPart1++;

            $transResults['sentences'][$index] = [
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $finalScorePart1 = $totalItemsPart1 > 0 ? round(($part1Score / $totalItemsPart1) * 50) : 0;

        // Part 2: matrix intro sentences (Simple Present/Past Verbal, asked as standalone sentences)
        // + tenses x structure matrix (remaining cells)
        $part2Score = 0;
        $totalItemsPart2 = 0;

        foreach ($matrixIntroSentences as $index => $item) {
            $userAnswer = trim((string) ($input['trans_matrix_intro'][$index] ?? ''));
            $correctAnswer = (string) ($item['en'] ?? '');

            $isCorrect = strtolower(rtrim($userAnswer, '.!')) === strtolower(rtrim($correctAnswer, '.!')) && $userAnswer !== '';
            if ($isCorrect) {
                $part2Score++;
            }
            $totalItemsPart2++;

            $transResults['matrixIntro'][$index] = [
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        foreach ($translationMatrix as $tenseName => $items) {
            foreach (['verbal', 'nominal', 'passive'] as $type) {
                if (!isset($items[$type])) {
                    continue;
                }

                $key = str_replace(' ', '_', strtolower($tenseName)) . '_' . $type;
                $userAnswer = trim((string) ($input['trans_matrix'][$key] ?? ''));
                $correctAnswer = (string) ($items[$type]['en'] ?? '');

                $isCorrect = strtolower(rtrim($userAnswer, '.!')) === strtolower(rtrim($correctAnswer, '.!')) && $userAnswer !== '';
                if ($isCorrect) {
                    $part2Score++;
                }
                $totalItemsPart2++;

                $transResults['matrix'][$tenseName][$type] = [
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer,
                    'is_correct' => $isCorrect,
                ];
            }
        }

        $finalScorePart2 = $totalItemsPart2 > 0 ? round(($part2Score / $totalItemsPart2) * 50) : 0;
        $totalScore = $finalScorePart1 + $finalScorePart2;

        return [
            'session' => [
                'meeting4_stage' => 3,
                'meeting4_trans_results' => $transResults,
                'meeting4_score_part1' => $finalScorePart1,
                'meeting4_score_part2' => $finalScorePart2,
                'meeting4_total_score' => $totalScore,
            ],
            'saveScore' => true,
            'totalScore' => $totalScore,
        ];
    }
}
