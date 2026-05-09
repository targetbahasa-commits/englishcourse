<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;

class BuildGrammarWritingMeeting9ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackQuestions, array $fallbackParagraph): array
    {
        $paragraph = $this->loadParagraph($fallbackParagraph);

        return [
            'questions' => $fallbackQuestions,
            'paragraph' => $paragraph,
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'submitted' => session('meeting9_submitted', false),
            'results' => session('meeting9_results', []),
            'paragraphResult' => session('meeting9_paragraph_result', []),
            'finalScore' => session('meeting9_final_score', 0),
            'userAnswers' => session('meeting9_user_answers', []),
            'userParagraphAnswer' => session('meeting9_user_paragraph_answer', ''),
        ];
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(9, $fallbackParagraph);
    }
}