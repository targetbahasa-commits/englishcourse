<?php

namespace App\Application\GrammarWriting\Concerns;

use Illuminate\Support\Collection;

trait LoadsLegacyGrammarWritingQuestions
{
    protected function loadLegacyQuestionModels(
        int $meetingNumber,
        bool $hasSectionColumn,
        array $fallbackQuestions,
        ?string $sectionFilter,
        callable $mapFallbackQuestion
    ): Collection {
        $questions = collect($this->repository->getLegacyQuestionsByMeeting($meetingNumber, $sectionFilter))
            ->filter(function ($question) use ($hasSectionColumn) {
                return $hasSectionColumn || (int) $question->question_number !== 999;
            })
            ->values();

        if ($questions->isNotEmpty()) {
            return $questions;
        }

        return collect($fallbackQuestions)
            ->map($mapFallbackQuestion)
            ->values();
    }
}
