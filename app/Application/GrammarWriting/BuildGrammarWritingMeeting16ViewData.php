<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;

class BuildGrammarWritingMeeting16ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackParagraph): array
    {
        $paragraph = $this->loadParagraph($fallbackParagraph);

        return [
            'submitted' => session('meeting16_submitted', false),
            'results' => session('meeting16_results', []),
            'paragraphResult' => session('meeting16_paragraph_result', []),
            'finalScore' => session('meeting16_final_score', 0),
            'userAnswers' => session('meeting16_user_answers', []),
            'userParagraphAnswer' => session('meeting16_user_paragraph_answer', ''),
            'questions' => [],
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'paragraphDbId' => $paragraph['db_id'],
        ];
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(16, $fallbackParagraph);
    }
}