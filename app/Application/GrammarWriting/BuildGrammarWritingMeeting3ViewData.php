<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsLegacyGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\ResolvesLegacyGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting3ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsLegacyGrammarWritingQuestions;
    use ResolvesLegacyGrammarWritingParagraph;

    public function handle(array $fallbackQuestions, array $fallbackParagraph, bool $hasSectionColumn): array
    {
        $questions = $this->formatQuestionsForView(
            $this->loadQuestionModels($fallbackQuestions, $hasSectionColumn)
        );

        $paragraph = $this->resolveParagraphRecord($hasSectionColumn);
        $paragraphData = $paragraph
            ? [
                'id' => $paragraph->question_text,
                'en' => $paragraph->correct_answer,
                'vocab' => $paragraph->vocab,
            ]
            : [
                'id' => $fallbackParagraph['id'],
                'en' => $fallbackParagraph['en'],
                'vocab' => $fallbackParagraph['vocab'],
            ];

        $userId = auth()->id();
        $cachedUserAnswers = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting3_user_answers');
        $cachedParagraphAnswer = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting3_user_paragraph_answer');

        return [
            'questions' => $questions,
            'fullParagraphId' => $paragraphData['id'],
            'fullParagraphEn' => $paragraphData['en'],
            'paragraphVocab' => $paragraphData['vocab'],
            'submitted' => session('meeting3_submitted', false),
            'results' => session('meeting3_results', []),
            'paragraphResult' => session('meeting3_paragraph_result', []),
            'finalScore' => session('meeting3_final_score', 0),
            'userAnswers' => $cachedUserAnswers !== null ? $cachedUserAnswers : session('meeting3_user_answers', []),
            'userParagraphAnswer' => $cachedParagraphAnswer !== null ? $cachedParagraphAnswer : session('meeting3_user_paragraph_answer', ''),
            'paragraphId' => $paragraph->id ?? 0,
        ];
    }

    public function loadQuestionModels(array $fallbackQuestions, bool $hasSectionColumn): Collection
    {
        return $this->loadLegacyQuestionModels(
            3,
            $hasSectionColumn,
            $fallbackQuestions,
            'sentences',
            function ($question, $number) {
                return (object) [
                    'question_number' => (int) $number,
                    'question_text' => $question['id'],
                    'correct_answer' => $question['en'],
                    'tense' => $question['tense'],
                    'vocab' => $question['vocab'] ?? [],
                    'id' => 0,
                ];
            }
        );
    }

    public function resolveParagraphRecord(bool $hasSectionColumn): mixed
    {
        return $this->resolveLegacyParagraphRecord(3, $hasSectionColumn);
    }

    public function formatQuestionsForView(Collection $questions): Collection
    {
        return $questions->map(function ($question) {
            if (is_array($question)) {
                return $question;
            }

            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'tense' => $question->tense,
                'vocab' => $question->vocab,
                'original_id' => $question->id,
                'q_num' => $question->question_number,
            ];
        });
    }
}