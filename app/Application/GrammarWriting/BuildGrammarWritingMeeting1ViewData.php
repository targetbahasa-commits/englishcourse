<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsLegacyGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\ResolvesLegacyGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting1ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsLegacyGrammarWritingQuestions;
    use ResolvesLegacyGrammarWritingParagraph;

    public function handle(
        bool $hasSectionColumn,
        array $fallbackParagraph,
        array $fallbackQuestions,
        array $fallbackVocab,
    ): array {
        return $this->composeViewData(
            $this->loadQuestionModels($hasSectionColumn, $fallbackQuestions),
            $this->resolveParagraphData($hasSectionColumn, $fallbackParagraph),
            $fallbackVocab,
        );
    }

    public function composeViewData(
        Collection $questions,
        array $paragraphData,
        array $fallbackVocab,
        array $overrides = [],
    ): array {
        return array_merge([
            'questions' => $this->formatQuestionsForView($questions),
            'paragraphData' => $paragraphData,
            'vocabList' => $this->resolveVocabList($fallbackVocab),
            'submitted' => false,
        ], $overrides);
    }

    public function loadQuestionModels(bool $hasSectionColumn, array $fallbackQuestions): Collection
    {
        return $this->loadLegacyQuestionModels(
            1,
            $hasSectionColumn,
            $fallbackQuestions,
            null,
            function ($question, $number) {
                return (object) [
                    'id' => null,
                    'meeting_number' => 1,
                    'question_number' => (int) $number,
                    'question_text' => $question['id'],
                    'correct_answer' => $question['en'],
                    'example_id' => $question['example']['id'] ?? null,
                    'example_en' => $question['example']['en'] ?? null,
                    'vocab' => $question['vocab'] ?? [],
                ];
            }
        );
    }

    public function resolveParagraphData(bool $hasSectionColumn, array $fallbackParagraph): array
    {
        $dbParagraph = $this->resolveLegacyParagraphRecord(1, $hasSectionColumn);

        return $dbParagraph
            ? ['id' => $dbParagraph->question_text, 'en' => $dbParagraph->correct_answer]
            : $fallbackParagraph;
    }

    public function resolveVocabList(array $fallbackVocab): array
    {
        $vocabList = collect($this->repository->getVocabularyByMeeting(1))
            ->where('section', 'global')
            ->mapWithKeys(function ($vocabulary) {
                return [$vocabulary->word => [
                    'id' => $vocabulary->translation,
                    'pos' => $vocabulary->pos,
                    'db_id' => $vocabulary->id,
                ]];
            })
            ->toArray();

        return empty($vocabList) ? $fallbackVocab : $vocabList;
    }

    public function formatQuestionsForView(Collection $questions): array
    {
        return $questions->keyBy('question_number')->map(function ($question) {
            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'example' => [
                    'id' => $question->example_id,
                    'en' => $question->example_en,
                ],
                'vocab' => $question->vocab,
                'db_id' => $question->id,
            ];
        })->toArray();
    }
}