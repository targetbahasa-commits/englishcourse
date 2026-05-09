<?php

namespace App\Application\GrammarWriting\Concerns;

trait LoadsKeyedGrammarWritingQuestions
{
    protected function loadKeyedQuestionsForMeeting(int $meetingNumber, array $fallbackQuestions, callable $mapQuestion): array
    {
        $questions = [];

        $dbQuestions = collect($this->repository->getQuestionsByMeetingWithNullSection($meetingNumber));

        if ($dbQuestions->count() === 0) {
            return $fallbackQuestions;
        }

        foreach ($dbQuestions as $question) {
            $questions[$question->question_number] = $mapQuestion($question);
        }

        return $questions;
    }
}