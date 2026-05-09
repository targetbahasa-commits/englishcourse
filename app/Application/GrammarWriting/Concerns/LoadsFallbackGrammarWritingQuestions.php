<?php

namespace App\Application\GrammarWriting\Concerns;

use Illuminate\Support\Collection;

trait LoadsFallbackGrammarWritingQuestions
{
    protected function loadFallbackQuestionsForMeeting(
        int $meetingNumber,
        array $fallbackQuestions,
        callable $mapQuestion,
        callable $mapFallbackQuestion
    ): Collection {
        $questions = collect($this->repository->getQuestionsByMeetingExcludingParagraph($meetingNumber))
            ->map($mapQuestion);

        if ($questions->isNotEmpty()) {
            return $questions->values();
        }

        return collect($fallbackQuestions)
            ->map($mapFallbackQuestion)
            ->values();
    }
}