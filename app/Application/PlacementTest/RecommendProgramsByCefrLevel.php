<?php

namespace App\Application\PlacementTest;

use App\Models\Program;
use Illuminate\Support\Collection;

class RecommendProgramsByCefrLevel
{
    private const ORDER = ['A1' => 1, 'A2' => 2, 'B1' => 3, 'B2' => 4, 'C1' => 5, 'C2' => 6];

    public function recommend(string $cefrLevel, ?string $targetInterest = null): Collection
    {
        $target = self::ORDER[$cefrLevel] ?? 3; // Default to B1 if unknown

        $matching = Program::where('is_active', true)
            ->whereNotNull('min_cefr_level')
            ->whereNotNull('max_cefr_level')
            ->get()
            ->filter(function (Program $program) use ($target) {
                $min = self::ORDER[$program->min_cefr_level] ?? 1;
                $max = self::ORDER[$program->max_cefr_level] ?? 6;

                return $target >= $min && $target <= $max;
            });

        if (empty($targetInterest)) {
            return $matching->values();
        }

        $interest = strtolower($targetInterest);
        $sorted = $matching->sortByDesc(function (Program $program) use ($interest) {
            $name = strtolower($program->name);
            if (str_contains($interest, 'ielts') && str_contains($name, 'ielts')) return 10;
            if (str_contains($interest, 'toefl') && str_contains($name, 'toefl')) return 10;
            if (str_contains($interest, 'pte') && str_contains($name, 'pte')) return 10;
            if (str_contains($interest, 'grammar') && str_contains($name, 'grammar')) return 10;
            if (str_contains($interest, 'speaking') && str_contains($name, 'speaking')) return 10;
            return 1;
        });

        return $sorted->values();
    }
}
