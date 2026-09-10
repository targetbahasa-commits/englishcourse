<?php

namespace App\Application\PlacementTest;

class ResolvePlacementCefrLevel
{
    /**
     * Same generic percentage->CEFR ladder as
     * App\Application\Guest\BuildGuestMyEnglishData::resolveCefrLevel().
     */
    public function resolve(float $percentage): string
    {
        return match (true) {
            $percentage >= 90 => 'C2',
            $percentage >= 80 => 'C1',
            $percentage >= 65 => 'B2',
            $percentage >= 50 => 'B1',
            $percentage >= 35 => 'A2',
            default => 'A1',
        };
    }
}
