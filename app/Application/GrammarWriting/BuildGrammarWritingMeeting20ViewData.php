<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;

class BuildGrammarWritingMeeting20ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackParagraph): array
    {
        $paragraph = $this->loadParagraph($fallbackParagraph);

        return [
            'submitted' => session('meeting20_submitted', false),
            'userParagraphAnswer' => session('meeting20_user_paragraph_answer', ''),
            'paragraphResult' => session('meeting20_paragraph_result', []),
            'finalScore' => session('meeting20_final_score', 0),
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'paragraphDbId' => $paragraph['db_id'],
        ];
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(20, $fallbackParagraph);
    }
}