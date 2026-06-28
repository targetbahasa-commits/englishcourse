<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;

class BuildGrammarWritingMeeting5ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    public function handle(): array
    {
        [$gerundInfinitiveComplex, $toInfinitive, $gerund, $paragraph] = $this->loadSections();

        return [
            'gerundInfinitiveComplex' => $gerundInfinitiveComplex,
            'toInfinitive' => $toInfinitive,
            'gerund' => $gerund,
            'paragraph' => $paragraph,
            'submitted' => session('meeting5_submitted', false),
            'results' => session('meeting5_results', []),
            'finalScore' => session('meeting5_final_score', 0),
            'userAnswers' => session('meeting5_user_answers', []),
        ];
    }

    public function loadSections(): array
    {
        $questions = $this->repository->getLegacyQuestionsByMeeting(5);

        $gerundInfinitiveComplex = [];
        $toInfinitive = [];
        $gerund = [];
        $paragraph = null;

        foreach ($questions as $question) {
            $item = [
                'db_id' => $question->id,
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'example' => $question->example,
                'vocab' => $question->vocab,
                'section' => $question->section,
            ];

            if ($question->section === 'gerund_infinitive_complex') {
                $gerundInfinitiveComplex[$question->question_number] = $item;
            } elseif ($question->section === 'to_infinitive') {
                $toInfinitive[$question->question_number] = $item;
            } elseif ($question->section === 'gerund') {
                $gerund[$question->question_number] = $item;
            } elseif ($question->section === 'paragraph') {
                $paragraph = $item;
            }
        }

        return [$gerundInfinitiveComplex, $toInfinitive, $gerund, $paragraph];
    }
}