<?php

namespace App\Application\GrammarPlacement;

use App\Models\Program;

class ResolveGrammarTier
{
    private const ORDER = ['A1' => 1, 'A2' => 2, 'B1' => 3, 'B2' => 4, 'C1' => 5, 'C2' => 6];

    /**
     * The four Grammar for Writing tiers, in ascending order. Matched against
     * each program's own min/max_cefr_level range (set on the Manage Programs
     * page) rather than hardcoded bands, so this stays correct if that range
     * is ever adjusted.
     */
    private const GRAMMAR_TIER_SLUGS = [
        'introductory-grammar-for-writing',
        'fast-track-grammar-for-writing',
        'complexity-grammar-for-writing',
        'proficiency-grammar-for-writing',
    ];

    /**
     * Finds the Grammar for Writing program whose CEFR range contains the
     * resolved level. Falls back to the closest tier by level if none of the
     * four match exactly (e.g. a tier's CEFR range was left unset).
     */
    public function resolve(string $cefrLevel): ?Program
    {
        $target = self::ORDER[$cefrLevel] ?? 3;

        $tiers = Program::whereIn('slug', self::GRAMMAR_TIER_SLUGS)
            ->where('is_active', true)
            ->get();

        $match = $tiers->first(function (Program $program) use ($target) {
            $min = self::ORDER[$program->min_cefr_level] ?? 1;
            $max = self::ORDER[$program->max_cefr_level] ?? 6;

            return $target >= $min && $target <= $max;
        });

        if ($match) {
            return $match;
        }

        return $tiers->sortBy(function (Program $program) use ($target) {
            $min = self::ORDER[$program->min_cefr_level] ?? 1;
            return abs($target - $min);
        })->first();
    }
}
