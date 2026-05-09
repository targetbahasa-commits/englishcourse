<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;
use Illuminate\Support\Collection;

class EvaluateGrammarWritingMeeting3Submission
{
    use ScoresWordMatchAnswers;

    public function handle(Collection $questions, string $paragraphAnswer, array $userAnswers, string $correctParagraph): array
    {
        $results = [];
        $totalScore = 0;
        $maxScore = ($questions->count() * 10) + 20;

        foreach ($questions as $question) {
            $questionNumber = (int) $question->question_number;
            $userTense = trim((string) ($userAnswers[$questionNumber]['tense'] ?? ''));
            $userTranslation = trim((string) ($userAnswers[$questionNumber]['trans'] ?? ''));

            $tenseScore = strtolower($userTense) === strtolower((string) $question->tense) ? 5 : 0;
            [$translationScore, $formattedAnswer] = $this->evaluateTranslation($userTranslation, (string) $question->correct_answer);

            $totalScore += ($tenseScore + $translationScore);

            $results[$questionNumber] = [
                'tense_score' => $tenseScore,
                'trans_score' => $translationScore,
                'user_tense' => $userTense,
                'user_trans' => $userTranslation,
                'formatted_answer' => $formattedAnswer,
            ];
        }

        $paragraphResult = $this->evaluateParagraph($paragraphAnswer, $correctParagraph);
        $totalScore += $paragraphResult['score'];

        return [
            'meeting3_submitted' => true,
            'meeting3_results' => $results,
            'meeting3_paragraph_result' => $paragraphResult,
            'meeting3_final_score' => $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0,
            'meeting3_user_answers' => $userAnswers,
            'meeting3_user_paragraph_answer' => $paragraphAnswer,
        ];
    }

    private function evaluateTranslation(string $userTranslation, string $correctAnswer): array
    {
        $variants = explode('|', $correctAnswer);
        $bestScore = -1;
        $bestFormatted = '';

        foreach ($variants as $variant) {
            $variant = trim($variant);
            $correctWords = preg_split('/\s+/', $variant, -1, PREG_SPLIT_NO_EMPTY);
            $userWords = preg_split('/\s+/', $userTranslation, -1, PREG_SPLIT_NO_EMPTY);

            $matchCount = 0;
            foreach ($userWords as $userWord) {
                foreach ($correctWords as $correctWord) {
                    if (strtolower(rtrim($userWord, '.!,')) === strtolower(rtrim($correctWord, '.!,'))) {
                        $matchCount++;
                        break;
                    }
                }
            }

            $currentScore = 0;
            if (count($correctWords) > 0) {
                $ratio = $matchCount / count($correctWords);
                if ($ratio == 1) {
                    $currentScore = 5;
                } elseif ($ratio >= 0.8) {
                    $currentScore = 4;
                } elseif ($ratio >= 0.6) {
                    $currentScore = 3;
                } elseif ($ratio >= 0.4) {
                    $currentScore = 2;
                } elseif ($ratio > 0) {
                    $currentScore = 1;
                }
            }

            if ($currentScore > $bestScore) {
                $bestScore = $currentScore;
                $bestFormatted = $this->formatWordMatchDiff($userWords, $correctWords);
            }
        }

        if ($bestFormatted === '') {
            $bestScore = 0;
            $bestFormatted = $this->formatWordMatchDiff(
                preg_split('/\s+/', $userTranslation, -1, PREG_SPLIT_NO_EMPTY),
                preg_split('/\s+/', trim($variants[0] ?? ''), -1, PREG_SPLIT_NO_EMPTY),
            );
        }

        return [max(0, $bestScore), $bestFormatted];
    }

    private function evaluateParagraph(string $paragraphAnswer, string $correctParagraph): array
    {
        $correctWords = preg_split('/\s+/', $correctParagraph, -1, PREG_SPLIT_NO_EMPTY);
        $userWords = preg_split('/\s+/', $paragraphAnswer, -1, PREG_SPLIT_NO_EMPTY);

        $matchCount = 0;
        foreach ($userWords as $userWord) {
            foreach ($correctWords as $correctWord) {
                if (strtolower(rtrim($userWord, '.!,')) === strtolower(rtrim($correctWord, '.!,'))) {
                    $matchCount++;
                    break;
                }
            }
        }

        $score = 0;
        if (count($correctWords) > 0) {
            $score = round(($matchCount / count($correctWords)) * 20);
        }

        return [
            'score' => $score,
            'max_score' => 20,
            'formatted_answer' => $this->formatWordMatchDiff($userWords, $correctWords),
        ];
    }
}