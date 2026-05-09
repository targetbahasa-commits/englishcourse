<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingExampleQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting15ViewData
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
            'submitted' => session('meeting15_submitted', false),
            'results' => session('meeting15_results', []),
            'paragraphResult' => session('meeting15_paragraph_result', []),
            'finalScore' => session('meeting15_final_score', 0),
            'userAnswers' => session('meeting15_user_answers', []),
            'userParagraphAnswer' => session('meeting15_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(): Collection
    {
        return $this->loadExampleQuestionsForMeeting(15);
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(15, $fallbackParagraph);
    }
}