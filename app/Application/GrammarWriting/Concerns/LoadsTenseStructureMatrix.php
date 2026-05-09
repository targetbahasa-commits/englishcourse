<?php

namespace App\Application\GrammarWriting\Concerns;

trait LoadsTenseStructureMatrix
{
    protected function loadTenseStructureMatrix(int $meetingNumber, array $matrix = [], ?callable $mapQuestion = null): array
    {
        $matrixQuestions = $this->repository->getQuestionsByMeetingAndSection($meetingNumber, 'matrix');

        $mapQuestion = $mapQuestion ?? function ($question) {
            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'db_id' => $question->id,
            ];
        };

        foreach ($matrixQuestions as $question) {
            $matrix[$question->tense][$question->structure] = $mapQuestion($question);
        }

        return $matrix;
    }
}