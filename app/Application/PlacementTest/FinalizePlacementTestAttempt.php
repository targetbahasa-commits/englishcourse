<?php

namespace App\Application\PlacementTest;

use App\Application\IeltsWriting\IeltsWritingAiSupport;
use App\Models\PlacementSpeakingPrompt;
use App\Models\PlacementTestResult;
use App\Models\PlacementWritingPrompt;

class FinalizePlacementTestAttempt
{
    public function __construct(
        private readonly IeltsWritingAiSupport $aiSupport,
        private readonly BuildPlacementWritingAiPrompt $writingPromptBuilder,
        private readonly ScorePlacementSpeaking $speakingScorer,
        private readonly ResolvePlacementCefrLevel $cefrResolver,
        private readonly RecommendProgramsByCefrLevel $recommender,
    ) {
    }

    public function execute(PlacementTestResult $result): PlacementTestResult
    {
        $answers = $result->answers_data ?? [];
        $evaluation = $result->evaluation_data ?? [];

        $writingScore = $result->writing_score !== null ? (float) $result->writing_score : null;
        if (!empty($answers['writing']['essay']) && !isset($evaluation['writing'])) {
            $promptText = optional(PlacementWritingPrompt::find($answers['writing']['prompt_id'] ?? null))->prompt_text ?? '';
            $prompt = $this->writingPromptBuilder->build($promptText, $answers['writing']['essay']);
            $aiResult = $this->aiSupport->runJsonPrompt($prompt);

            $evaluation['writing'] = [
                'scores' => $aiResult['scores'] ?? null,
                'cefr_estimate' => $aiResult['cefr_estimate'] ?? null,
                'feedback' => $aiResult['feedback'] ?? null,
            ];

            $writingScore = $this->averageScore($aiResult['scores'] ?? null);
        }

        $speakingScore = $result->speaking_score !== null ? (float) $result->speaking_score : null;
        if (!empty($answers['speaking']['audio_path']) && !isset($evaluation['speaking'])) {
            $promptText = optional(PlacementSpeakingPrompt::find($answers['speaking']['prompt_id'] ?? null))->prompt_text ?? '';
            $speakingResult = $this->speakingScorer->score($answers['speaking']['audio_path'], $promptText);

            $evaluation['speaking'] = $speakingResult;
            $speakingScore = $this->averageScore($speakingResult['scores'] ?? null);
        }

        $scores = array_values(array_filter([
            $result->reading_score !== null ? (float) $result->reading_score : null,
            $result->listening_score !== null ? (float) $result->listening_score : null,
            $writingScore,
            $speakingScore,
        ], fn ($s) => $s !== null));

        $overallPercentage = count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : 0.0;
        $cefrLevel = $this->cefrResolver->resolve($overallPercentage);
        $recommendedPrograms = $this->recommender->recommend($cefrLevel);

        $result->update([
            'writing_score' => $writingScore,
            'speaking_score' => $speakingScore,
            'overall_percentage' => $overallPercentage,
            'cefr_level' => $cefrLevel,
            'evaluation_data' => $evaluation,
            'recommended_program_ids' => $recommendedPrograms->pluck('id')->values()->all(),
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return $result->fresh();
    }

    private function averageScore(?array $scores): ?float
    {
        if (empty($scores)) {
            return null;
        }

        $values = array_filter($scores, 'is_numeric');
        if (empty($values)) {
            return null;
        }

        return round(array_sum($values) / count($values), 2);
    }
}
