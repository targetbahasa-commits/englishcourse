<?php

namespace App\Http\Controllers\Concerns;

trait ScoresTextAccuracy
{
    /**
     * Word-level overlap ratio between the target text and the submitted text (case-insensitive).
     */
    protected function wordAccuracy(string $target, string $submitted): float
    {
        $normalize = fn (string $s) => array_values(array_filter(preg_split('/\s+/', strtolower(trim(preg_replace('/[^\w\s]/', '', $s))))));

        $targetWords = $normalize($target);
        $submittedWords = $normalize($submitted);

        if (empty($targetWords)) {
            return 0;
        }

        $matched = 0;
        $pool = $submittedWords;
        foreach ($targetWords as $word) {
            $index = array_search($word, $pool, true);
            if ($index !== false) {
                $matched++;
                unset($pool[$index]);
            }
        }

        return $matched / count($targetWords);
    }

    /**
     * Scale a 0-1 accuracy ratio to the app's 10-90 promo score convention.
     */
    protected function scaleToPteScore(float $ratio): int
    {
        $ratio = max(0, min(1, $ratio));
        return (int) round(10 + $ratio * 80);
    }
}
