<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsLegacyGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\ResolvesLegacyGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting4ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsLegacyGrammarWritingQuestions;
    use ResolvesLegacyGrammarWritingParagraph;

    public function handle(array $fallbackQuestions, array $fallbackParagraph, bool $hasSectionColumn): array
    {
        $questions = $this->formatQuestionsForView(
            $this->loadQuestionRecords($fallbackQuestions, $hasSectionColumn)
        );

        $paragraph = $this->resolveParagraphRecord($hasSectionColumn);
        $paragraphData = $paragraph
            ? [
                'id' => $paragraph->question_text,
                'en' => $paragraph->correct_answer,
                'sentences' => [],
                'vocab' => is_array($paragraph->vocab) ? $paragraph->vocab : [],
            ]
            : $fallbackParagraph;

        $userId = auth()->id();
        $cachedUserAnswers = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting4_user_answers');
        $cachedParagraphAnswer = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting4_user_paragraph_answer');

        return [
            'questions' => $questions,
            'fullParagraphId' => $paragraphData['id'],
            'fullParagraphEn' => $paragraphData['en'],
            'paragraphSentences' => $paragraphData['sentences'],
            'paragraphVocab' => $paragraphData['vocab'] ?? [],
            'submitted' => session('meeting4_submitted', false),
            'results' => session('meeting4_results', []),
            'paragraphResult' => session('meeting4_paragraph_result', []),
            'finalScore' => session('meeting4_final_score', 0),
            'userAnswers' => $cachedUserAnswers !== null ? $cachedUserAnswers : session('meeting4_user_answers', []),
            'userParagraphAnswer' => $cachedParagraphAnswer !== null ? $cachedParagraphAnswer : session('meeting4_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestionRecords(array $fallbackQuestions, bool $hasSectionColumn): Collection
    {
        return $this->loadLegacyQuestionModels(
            4,
            $hasSectionColumn,
            $fallbackQuestions,
            null,
            function ($question, $number) {
                return (object) [
                    'question_number' => (int) $number,
                    'question_text' => $question['id'],
                    'correct_answer' => $question['en'],
                    'vocab' => $question['vocab'] ?? [],
                    'id' => 0,
                ];
            }
        );
    }

    public function resolveParagraphRecord(bool $hasSectionColumn): mixed
    {
        return $this->resolveLegacyParagraphRecord(4, $hasSectionColumn);
    }

    public function formatQuestionsForView(Collection $questions): array
    {
        return $questions->mapWithKeys(function ($question) {
            return [(int) $question->question_number => [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'vocab' => is_array($question->vocab) ? $question->vocab : [],
                'db_id' => $question->id,
            ]];
        })->toArray();
    }
}