<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsKeyedGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;

class BuildGrammarWritingMeeting18ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsKeyedGrammarWritingQuestions;
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
            'reducingExample' => [
                'id' => 'Orang yang sedang berjalan di taman adalah guru saya.',
                'en' => 'The person walking in the park is my teacher.',
            ],
            'submitted' => session('meeting18_submitted', false),
            'results' => session('meeting18_results', []),
            'paragraphResult' => session('meeting18_paragraph_result', []),
            'finalScore' => session('meeting18_final_score', 0),
            'userAnswers' => session('meeting18_user_answers', []),
            'userParagraphAnswer' => session('meeting18_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(array $fallbackQuestions): array
    {
        return $this->loadKeyedQuestionsForMeeting(18, $fallbackQuestions, function ($question) {
            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'vocab' => $question->vocab,
                'example' => [
                    'id' => $question->example_id,
                    'en' => $question->example_en,
                ],
                'db_id' => $question->id,
            ];
        });
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(18, $fallbackParagraph);
    }
}