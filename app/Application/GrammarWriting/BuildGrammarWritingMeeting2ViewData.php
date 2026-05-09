<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsTenseStructureMatrix;

class BuildGrammarWritingMeeting2ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsTenseStructureMatrix;

    public function handle(array $tenses, array $tenseExamples, array $vocabularies): array
    {
        $sentences = collect($this->repository->getQuestionsByMeetingAndSection(2, 'sentences'))
            ->map(function ($question) {
                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'tense' => $question->tense,
                    'type' => $question->structure,
                    'question_number' => $question->question_number,
                    'original_id' => $question->id,
                ];
            });

        $translationMatrix = $this->loadTenseStructureMatrix(2, [], function ($question) {
            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'question_number' => $question->question_number,
                'original_id' => $question->id,
            ];
        });

        return [
            'tenses' => $tenses,
            'translationSentences' => $sentences,
            'translationMatrix' => $translationMatrix,
            'tenseExamples' => $tenseExamples,
            'vocabularies' => $vocabularies,
            'stage' => session('meeting2_stage', 1),
            'results' => session('meeting2_results', []),
            'transResults' => session('meeting2_trans_results', []),
            'scorePart1' => session('meeting2_score_part1', 0),
            'scorePart2' => session('meeting2_score_part2', 0),
            'totalScore' => session('meeting2_total_score', 0),
        ];
    }
}