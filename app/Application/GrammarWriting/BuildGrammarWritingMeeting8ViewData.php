<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsQuestionSectionWithParagraph;

class BuildGrammarWritingMeeting8ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsQuestionSectionWithParagraph;

    public function handle(): array
    {
        [$questions, $paragraph] = $this->loadSections();
        $paragraph = $paragraph ?? [];
        $paragraph['sentences'] = $paragraph['sentences'] ?? [];

        return [
            'questions' => $questions,
            'paragraph' => $paragraph,
            'submitted' => session('meeting8_submitted', false),
            'results' => session('meeting8_results', []),
            'paragraphResult' => session('meeting8_paragraph_result', []),
            'finalScore' => session('meeting8_final_score', 0),
            'userAnswers' => session('meeting8_user_answers', []),
            'userParagraphAnswer' => session('meeting8_user_paragraph_answer', ''),
        ];
    }

    public function loadSections(): array
    {
        return $this->loadQuestionSectionWithParagraph(8, 'prepositional_phrases');
    }
}