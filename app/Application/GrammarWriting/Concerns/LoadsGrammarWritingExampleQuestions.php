<?php

namespace App\Application\GrammarWriting\Concerns;

use Illuminate\Support\Collection;

trait LoadsGrammarWritingExampleQuestions
{
    protected function loadExampleQuestionsForMeeting(int $meetingNumber): Collection
    {
        return collect($this->repository->getQuestionsByMeetingExcludingParagraph($meetingNumber))
            ->map(function ($question) {
                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'vocab' => $question->vocab,
                    'example' => [
                        'id' => $question->example_id,
                        'en' => $question->example_en,
                    ],
                    'db_id' => $question->id,
                ];
            })->values();
    }
}