<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsTenseStructureMatrix;

class BuildGrammarWritingMeeting5ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsTenseStructureMatrix;

    public function handle(array $tenseExamples): array
    {
        return [
            'questions' => $this->loadSentenceQuestions(),
            'matrix' => $this->loadMatrix(array_keys($tenseExamples)),
            'prQuestions' => $this->loadPrQuestions(),
            'submitted' => session('meeting5_submitted', false),
            'results' => session('meeting5_results', []),
            'finalScore' => session('meeting5_final_score', 0),
            'userAnswers' => session('meeting5_user_answers', []),
            'tenseExamples' => $tenseExamples,
            'vocabularies' => $this->loadVocabularies(),
        ];
    }

    public function loadSentenceQuestions()
    {
        return collect($this->repository->getQuestionsByMeetingAndSection(5, 'sentences'))
            ->mapWithKeys(function ($question) {
                return [$question->question_number => [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'tense' => $question->tense,
                    'db_id' => $question->id,
                ]];
            });
    }

    public function loadMatrix(array $tenses): array
    {
        $matrix = [];
        foreach ($tenses as $tense) {
            $matrix[$tense] = [
                'verbal' => null,
                'nominal' => null,
                'passive' => null,
            ];
        }

        return $this->loadTenseStructureMatrix(5, $matrix, function ($question) {
            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'db_id' => $question->id,
            ];
        });
    }

    public function loadVocabularies(): array
    {
        $vocabRecords = $this->repository->getVocabularyByMeeting(5);
        $vocabularies = [];

        foreach ($vocabRecords as $vocabulary) {
            $parts = explode(' - ', $vocabulary->section);
            if (count($parts) < 2) {
                continue;
            }

            $type = array_pop($parts);
            $tense = implode(' - ', $parts);
            $vocabularies[$tense][$type][] = [
                'ind' => $vocabulary->word,
                'en' => $vocabulary->translation,
                'db_id' => $vocabulary->id,
            ];
        }

        return $vocabularies;
    }

    public function loadPrQuestions()
    {
        return collect($this->repository->getQuestionsByMeetingAndSection(5, 'pr'))
            ->map(function ($question) {
                $exampleParts = explode('|', $question->example ?? '');

                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'tense' => $question->tense,
                    'example' => [
                        'id' => $exampleParts[0] ?? '',
                        'en' => $exampleParts[1] ?? '',
                    ],
                    'vocabulary' => json_decode($question->vocabulary ?? '{}', true),
                    'db_id' => $question->id,
                ];
            });
    }
}