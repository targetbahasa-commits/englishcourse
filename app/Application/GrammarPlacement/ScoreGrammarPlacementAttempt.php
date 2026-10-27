<?php

namespace App\Application\GrammarPlacement;

use App\Application\PlacementTest\ResolvePlacementCefrLevel;
use App\Models\GrammarPlacementQuestion;
use App\Models\GrammarPlacementResult;

class ScoreGrammarPlacementAttempt
{
    public function __construct(
        private readonly ResolvePlacementCefrLevel $cefrResolver,
        private readonly ResolveGrammarTier $tierResolver,
    ) {
    }

    /**
     * @param array<int, string> $answers question_id => selected option (a/b/c/d)
     */
    public function execute(array $answers, array $meta): GrammarPlacementResult
    {
        $questionIds = array_map('intval', array_keys($answers));
        $questions = GrammarPlacementQuestion::whereIn('id', $questionIds)->get()->keyBy('id');

        $correct = 0;
        foreach ($answers as $questionId => $selected) {
            $question = $questions->get((int) $questionId);
            if ($question && strtolower((string) $selected) === strtolower((string) $question->correct_option)) {
                $correct++;
            }
        }

        $total = count($answers);
        $percentage = $total > 0 ? round(($correct / $total) * 100, 2) : 0.0;
        $cefrLevel = $this->cefrResolver->resolve($percentage);
        $recommendedProgram = $this->tierResolver->resolve($cefrLevel);

        return GrammarPlacementResult::create([
            'grammar_placement_package_id' => $meta['grammar_placement_package_id'] ?? null,
            'student_name' => $meta['student_name'],
            'student_phone' => $meta['student_phone'] ?? null,
            'user_id' => $meta['user_id'] ?? null,
            'administered_by' => $meta['administered_by'] ?? null,
            'answers_data' => $answers,
            'correct_count' => $correct,
            'total_count' => $total,
            'percentage' => $percentage,
            'cefr_level' => $cefrLevel,
            'recommended_program_id' => $recommendedProgram?->id,
            'notes' => $meta['notes'] ?? null,
        ]);
    }
}
