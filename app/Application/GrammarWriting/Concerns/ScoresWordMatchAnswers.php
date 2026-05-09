<?php

namespace App\Application\GrammarWriting\Concerns;

trait ScoresWordMatchAnswers
{
    protected function scoreBestVariantWordMatchAnswer(
        string $userTranslation,
        string $correctAnswer,
        int $maxScore,
        string $trimCharacters = '.!,'
    ): array {
        $variants = explode('|', $correctAnswer);
        $bestResult = null;

        foreach ($variants as $variant) {
            $result = $this->scoreWordMatchAnswer($userTranslation, trim($variant), $maxScore, $trimCharacters);

            if ($bestResult === null || $result['score'] > $bestResult['score']) {
                $bestResult = $result;
            }
        }

        if ($bestResult !== null) {
            return $bestResult;
        }

        return $this->scoreWordMatchAnswer($userTranslation, '', $maxScore, $trimCharacters);
    }

    protected function scoreWordMatchAnswer(
        string $userTranslation,
        string $correctAnswer,
        int $maxScore,
        string $trimCharacters = '.!,'
    ): array {
        $correctWords = preg_split('/\s+/', $correctAnswer, -1, PREG_SPLIT_NO_EMPTY);
        $userWords = preg_split('/\s+/', $userTranslation, -1, PREG_SPLIT_NO_EMPTY);

        $matchCount = 0;
        foreach ($userWords as $userWord) {
            foreach ($correctWords as $correctWord) {
                if ($this->normalizeWord($userWord, $trimCharacters) === $this->normalizeWord($correctWord, $trimCharacters)) {
                    $matchCount++;
                    break;
                }
            }
        }

        $score = 0;
        if (count($correctWords) > 0) {
            $score = round(($matchCount / count($correctWords)) * $maxScore);
        }

        return [
            'user_answer' => $userTranslation,
            'score' => $score,
            'formatted_answer' => $this->formatWordMatchDiff($userWords, $correctWords, $trimCharacters),
        ];
    }

    protected function formatWordMatchDiff(array $userWords, array $correctWords, string $trimCharacters = '.!,'): string
    {
        $matrix = [];
        $userWordCount = count($userWords);
        $correctWordCount = count($correctWords);

        for ($userIndex = 0; $userIndex <= $userWordCount; $userIndex++) {
            $matrix[$userIndex][0] = 0;
        }

        for ($correctIndex = 0; $correctIndex <= $correctWordCount; $correctIndex++) {
            $matrix[0][$correctIndex] = 0;
        }

        for ($userIndex = 1; $userIndex <= $userWordCount; $userIndex++) {
            for ($correctIndex = 1; $correctIndex <= $correctWordCount; $correctIndex++) {
                $userWord = $this->normalizeWord($userWords[$userIndex - 1], $trimCharacters);
                $correctWord = $this->normalizeWord($correctWords[$correctIndex - 1], $trimCharacters);

                if ($userWord === $correctWord) {
                    $matrix[$userIndex][$correctIndex] = $matrix[$userIndex - 1][$correctIndex - 1] + 1;
                } else {
                    $matrix[$userIndex][$correctIndex] = max($matrix[$userIndex - 1][$correctIndex], $matrix[$userIndex][$correctIndex - 1]);
                }
            }
        }

        $userIndex = $userWordCount;
        $correctIndex = $correctWordCount;
        $diff = [];

        while ($userIndex > 0 || $correctIndex > 0) {
            if ($userIndex > 0 && $correctIndex > 0) {
                $userWord = $this->normalizeWord($userWords[$userIndex - 1], $trimCharacters);
                $correctWord = $this->normalizeWord($correctWords[$correctIndex - 1], $trimCharacters);

                if ($userWord === $correctWord) {
                    array_unshift($diff, ['type' => 'match', 'word' => $userWords[$userIndex - 1]]);
                    $userIndex--;
                    $correctIndex--;
                    continue;
                }
            }

            if ($correctIndex > 0 && ($userIndex === 0 || $matrix[$userIndex][$correctIndex - 1] >= $matrix[$userIndex - 1][$correctIndex])) {
                array_unshift($diff, ['type' => 'missing', 'word' => $correctWords[$correctIndex - 1]]);
                $correctIndex--;
            } elseif ($userIndex > 0 && ($correctIndex === 0 || $matrix[$userIndex][$correctIndex - 1] < $matrix[$userIndex - 1][$correctIndex])) {
                array_unshift($diff, ['type' => 'extra', 'word' => $userWords[$userIndex - 1]]);
                $userIndex--;
            }
        }

        $finalOutput = [];
        $diffCount = count($diff);
        for ($diffIndex = 0; $diffIndex < $diffCount; $diffIndex++) {
            $current = $diff[$diffIndex];
            $next = ($diffIndex + 1 < $diffCount) ? $diff[$diffIndex + 1] : null;

            if ($current['type'] === 'extra' && $next && $next['type'] === 'missing') {
                $finalOutput[] = '<span class="word-wrong">' . htmlspecialchars($current['word']) . '</span>';
                $finalOutput[] = '<span class="word-missing">(' . htmlspecialchars($next['word']) . ')</span>';
                $diffIndex++;
            } elseif ($current['type'] === 'match') {
                $finalOutput[] = '<span class="word-correct">' . htmlspecialchars($current['word']) . '</span>';
            } elseif ($current['type'] === 'extra') {
                $finalOutput[] = '<span class="word-extra">' . htmlspecialchars($current['word']) . '</span>';
            } elseif ($current['type'] === 'missing') {
                $finalOutput[] = '<span class="word-missing">(' . htmlspecialchars($current['word']) . ')</span>';
            }
        }

        return implode(' ', $finalOutput);
    }

    private function normalizeWord(string $word, string $trimCharacters): string
    {
        return strtolower(rtrim($word, $trimCharacters));
    }
}