<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsFallbackGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting12ViewData
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
            'submitted' => session('meeting12_submitted', false),
            'results' => session('meeting12_results', []),
            'paragraphResult' => session('meeting12_paragraph_result', []),
            'finalScore' => session('meeting12_final_score', 0),
            'userAnswers' => session('meeting12_user_answers', []),
            'userParagraphAnswer' => session('meeting12_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(array $fallbackQuestions): Collection
    {
        return $this->loadFallbackQuestionsForMeeting(
            12,
            $fallbackQuestions,
            function ($question) {
                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'type' => $question->structure,
                    'conjunction' => $question->formula,
                    'example' => is_array($question->example) ? $question->example : ['id' => '', 'en' => ''],
                    'vocab' => is_array($question->vocab) ? $question->vocab : [],
                    'db_id' => $question->id,
                ];
            },
            function ($question) {
                return [
                    'id' => $question['id'],
                    'en' => $question['en'],
                    'type' => $question['type'] ?? '',
                    'conjunction' => $question['conjunction'] ?? '',
                    'example' => $question['example'] ?? ['id' => '', 'en' => ''],
                    'vocab' => $question['vocab'] ?? [],
                    'db_id' => null,
                ];
            }
        );
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(12, $fallbackParagraph, fn ($vocab) => $vocab ?? []);
    }
}