<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting10ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackParagraph, array $examples): array
    {
        $questions = $this->loadQuestions();
        $paragraph = $this->loadParagraph($fallbackParagraph);

        return [
            'questions' => $questions,
            'paragraph' => $paragraph,
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'examples' => $examples,
            'submitted' => session('meeting10_submitted', false),
            'results' => session('meeting10_results', []),
            'paragraphResult' => session('meeting10_paragraph_result', []),
            'finalScore' => session('meeting10_final_score', 0),
            'userAnswers' => session('meeting10_user_answers', []),
            'userParagraphAnswer' => session('meeting10_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(): Collection
    {
        return collect($this->repository->getQuestionsByMeetingExcludingParagraph(10))
            ->map(function ($question) {
                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'type' => $question->structure,
                    'vocab' => $question->vocab,
                    'example' => [
                        'id' => $question->example_id,
                        'en' => $question->example_en,
                    ],
                    'db_id' => $question->id,
                ];
            });
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(10, $fallbackParagraph);
    }
}