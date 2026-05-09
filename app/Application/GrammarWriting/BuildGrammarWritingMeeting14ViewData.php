<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingExampleQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting14ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsGrammarWritingExampleQuestions;
    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackParagraph): array
    {
        $questions = $this->loadQuestions();
        $paragraph = $this->loadParagraph($fallbackParagraph);

        return [
            'questions' => $questions,
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'paragraphDbId' => $paragraph['db_id'],
            'submitted' => session('meeting14_submitted', false),
            'results' => session('meeting14_results', []),
            'paragraphResult' => session('meeting14_paragraph_result', []),
            'finalScore' => session('meeting14_final_score', 0),
            'userAnswers' => session('meeting14_user_answers', []),
            'userParagraphAnswer' => session('meeting14_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(): Collection
    {
        return $this->loadExampleQuestionsForMeeting(14);
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(14, $fallbackParagraph);
    }
}