<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsKeyedGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;

class BuildGrammarWritingMeeting19ViewData
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
            'submitted' => session('meeting19_submitted', false),
            'results' => session('meeting19_results', []),
            'paragraphResult' => session('meeting19_paragraph_result', []),
            'finalScore' => session('meeting19_final_score', 0),
            'userAnswers' => session('meeting19_user_answers', []),
            'userParagraphAnswer' => session('meeting19_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(array $fallbackQuestions): array
    {
        return $this->loadKeyedQuestionsForMeeting(19, $fallbackQuestions, function ($question) {
            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'vocab' => $question->vocab,
                'example' => [
                    'id' => $question->example_id,
                    'en' => $question->example_en,
                ],
                'db_id' => $question->id,
                'type' => $question->vocab['_type'] ?? '',
                'adverb' => $question->vocab['_adverb'] ?? '',
            ];
        });
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(19, $fallbackParagraph);
    }
}