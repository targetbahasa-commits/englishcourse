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
        ?string $track = null,
    ): array {
        // This same evaluator/view (meeting2.blade.php, "Teknik Silang"
        // tenses matrix) is shared between fast-track's own meeting 1 AND
        // complexity's meeting 1 - $track (null for fast-track, the
        // original/unprefixed behavior, kept byte-for-byte identical to
        // avoid disturbing any in-progress fast-track session) picks which
        // session-key convention the result gets written under, so the two
        // tracks' progress/scores never collide.
        $keyPrefix = $track ? "{$track}_" : '';
        // Evaluate Matrix (Part 1)
        $results = [];
        $part1Score = 0;
        $totalItemsPart1 = 0;

        foreach ($tenses as $tenseName => $formulas) {
            foreach (['verbal', 'nominal', 'passive'] as $type) {
                $key = str_replace(' ', '_', strtolower($tenseName)) . '_' . $type;
                $userAnswer = trim((string) ($input['tenses'][$key] ?? ''));
                $correctAnswer = (string) ($formulas[$type] ?? '');

                $normUser = strtolower((string) preg_replace('/\s+/', '', $userAnswer));
                $normCorrect = strtolower((string) preg_replace('/\s+/', '', $correctAnswer));

                $isCorrect = $normUser === $normCorrect && $normUser !== '';
                if ($isCorrect) {
                    $part1Score++;
                }
                $totalItemsPart1++;

                $results[$tenseName][$type] = [
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer,
                    'is_correct' => $isCorrect,
                ];
            }
        }

        $finalScorePart1 = $totalItemsPart1 > 0 ? round(($part1Score / $totalItemsPart1) * 50) : 0;

        // Evaluate Translation (Part 2)
        $transResults = ['sentences' => [], 'matrix' => []];
        $part2Score = 0;
        $totalItemsPart2 = 0;

        foreach ($translationSentences as $index => $item) {
            $userAnswer = trim((string) ($input['trans_sent'][$index] ?? ''));
            $correctAnswer = (string) ($item['en'] ?? '');

            $isCorrect = strtolower(rtrim($userAnswer, '.!')) === strtolower(rtrim($correctAnswer, '.!')) && $userAnswer !== '';
            if ($isCorrect) {
                $part2Score++;
            }
            $totalItemsPart2++;

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
                "{$keyPrefix}meeting2_stage" => 3, // Directly go to result stage
                "{$keyPrefix}meeting2_results" => $results,
                "{$keyPrefix}meeting2_score_part1" => $finalScorePart1,
                "{$keyPrefix}meeting2_trans_results" => $transResults,
                "{$keyPrefix}meeting2_score_part2" => $finalScorePart2,
                "{$keyPrefix}meeting2_total_score" => $totalScore,
            ],
            'saveScore' => true,
            'totalScore' => $totalScore,
        ];
    }
}