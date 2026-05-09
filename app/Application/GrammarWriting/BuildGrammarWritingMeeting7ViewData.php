<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsQuestionSectionWithParagraph;

class BuildGrammarWritingMeeting7ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsQuestionSectionWithParagraph;

    public function handle(): array
    {
        [$questions, $paragraph] = $this->loadSections();

        return [
            'questions' => $questions,
            'paragraph' => $paragraph,
            'fullParagraphId' => $paragraph['id'] ?? '',
            'fullParagraphEn' => $paragraph['en'] ?? '',
            'paragraphSentences' => $paragraph['sentences'] ?? [],
            'paragraphVocab' => $paragraph['vocab'] ?? [],
            'submitted' => session('meeting7_submitted', false),
            'results' => session('meeting7_results', []),
            'paragraphResult' => session('meeting7_paragraph_result', []),
            'finalScore' => session('meeting7_final_score', 0),
            'userAnswers' => session('meeting7_user_answers', []),
            'userParagraphAnswer' => session('meeting7_user_paragraph_answer', ''),
        ];
    }

    public function loadSections(): array
    {
        return $this->loadQuestionSectionWithParagraph(7, 'noun_phrases');
    }
}