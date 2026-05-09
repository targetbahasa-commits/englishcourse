<?php

namespace App\Application\GrammarWriting\Concerns;

trait LoadsQuestionSectionWithParagraph
{
    protected function loadQuestionSectionWithParagraph(int $meetingNumber, string $questionSection): array
    {
        $questionsDb = $this->repository->getAllQuestionsByMeeting($meetingNumber);

        $questions = [];
        $paragraph = null;

        foreach ($questionsDb as $question) {
            if ($question->section === $questionSection) {
                $questions[$question->question_number] = [
                    'db_id' => $question->id,
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'example' => $question->example,
                    'vocab' => $question->vocab,
                ];
            } elseif ($question->section === 'paragraph') {
                $paragraph = [
                    'db_id' => $question->id,
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'sentences' => $question->vocab,
                ];
            }
        }

        return [$questions, $paragraph];
    }
}