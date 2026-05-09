<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsFallbackGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting11ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsFallbackGrammarWritingQuestions;
    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackQuestions, array $fallbackParagraph): array
    {
        $questions = $this->loadQuestions($fallbackQuestions);
        $paragraph = $this->loadParagraph($fallbackParagraph);

        return [
            'questions' => $questions,
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'paragraphDbId' => $paragraph['db_id'],
            'submitted' => session('meeting11_submitted', false),
            'results' => session('meeting11_results', []),
            'paragraphResult' => session('meeting11_paragraph_result', []),
            'finalScore' => session('meeting11_final_score', 0),
            'userAnswers' => session('meeting11_user_answers', []),
            'userParagraphAnswer' => session('meeting11_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(array $fallbackQuestions): Collection
    {
        return $this->loadFallbackQuestionsForMeeting(
            11,
            $fallbackQuestions,
            function ($question) {
                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'vocab' => $question->vocab,
                    'example' => $question->example_en,
                    'db_id' => $question->id,
                ];
            },
            function ($question) {
                return [
                    'id' => $question['id'],
                    'en' => $question['en'],
                    'vocab' => $question['vocab'] ?? [],
                    'example' => $question['example'] ?? '',
                    'db_id' => null,
                ];
            }
        );
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(11, $fallbackParagraph, fn ($vocab) => $vocab ?? []);
    }
}