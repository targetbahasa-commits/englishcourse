<?php

namespace App\Application\GrammarPlacement;

class ResolveSelfStudyGrammarMode
{
    /**
     * The self-study placement test (SelfStudyGrammarPlacementSeeder) is built
     * as an even 10 easy (A1-A2) / 10 harder (B1-C1) split, so resolving mode
     * from the raw percentage directly - rather than routing through the
     * generic ResolvePlacementCefrLevel ladder, which was tuned for a
     * differently-weighted test - keeps the threshold meaningful for this
     * specific question set. 55% requires getting every easy question right
     * plus at least one harder one, so a student who only knows the A1-A2
     * half isn't tipped into the advanced track by a single lucky guess.
     */
    private const MODE_B_THRESHOLD = 55.0;

    public function resolve(float $percentage): string
    {
        return $percentage >= self::MODE_B_THRESHOLD ? 'B' : 'A';
    }
}
