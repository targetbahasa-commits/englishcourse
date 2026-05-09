<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsKeyedGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;

class BuildGrammarWritingMeeting17ViewData
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
            'nounClauseExample' => [
                'id' => 'Saya tidak tahu apakah dia akan datang.',
                'en' => 'I don\'t know whether he will come.',
            ],
            'submitted' => session('meeting17_submitted', false),
            'results' => session('meeting17_results', []),
            'paragraphResult' => session('meeting17_paragraph_result', []),
            'finalScore' => session('meeting17_final_score', 0),
            'userAnswers' => session('meeting17_user_answers', []),
            'userParagraphAnswer' => session('meeting17_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(array $fallbackQuestions): array
    {
        return $this->loadKeyedQuestionsForMeeting(17, $fallbackQuestions, function ($question) {
            $mappedQuestion = [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'example' => [
                    'id' => $question->example_text ?? $question->example_id,
                    'en' => $question->example_en,
                ],
                'vocab' => $question->vocab,
                'db_id' => $question->id,
            ];

            if ($question->example_id) {
                $mappedQuestion['example']['id'] = $question->example_id;
            }

            return $mappedQuestion;
        });
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(17, $fallbackParagraph);
    }
}