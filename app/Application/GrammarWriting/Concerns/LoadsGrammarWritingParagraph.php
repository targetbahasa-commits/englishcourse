<?php

namespace App\Application\GrammarWriting\Concerns;

trait LoadsGrammarWritingParagraph
{
    protected function loadMeetingParagraph(int $meetingNumber, array $fallbackParagraph, ?callable $normalizeVocab = null): array
    {
        $normalizeVocab = $normalizeVocab ?? fn ($vocab) => $vocab;

        $paragraph = $this->repository->getParagraphQuestion($meetingNumber);

        if ($paragraph) {
            return [
                'id' => $paragraph->question_text,
                'en' => $paragraph->correct_answer,
                'vocab' => $normalizeVocab($paragraph->vocab),
                'db_id' => $paragraph->id,
            ];
        }

        return [
            'id' => $fallbackParagraph['id'],
            'en' => $fallbackParagraph['en'],
            'vocab' => $normalizeVocab($fallbackParagraph['vocab'] ?? null),
            'db_id' => null,
        ];
    }
}