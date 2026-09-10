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

        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using session() below would prefill the page with the
        // ADMIN's own session state instead of the real student's - the
        // correct per-student data is safely injected client-side afterward
        // by injectSnapshotIntoIframe() in current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');

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
            'submitted' => $isLivePreview ? false : session('meeting17_submitted', false),
            'results' => $isLivePreview ? [] : session('meeting17_results', []),
            'paragraphResult' => $isLivePreview ? [] : session('meeting17_paragraph_result', []),
            'finalScore' => $isLivePreview ? 0 : session('meeting17_final_score', 0),
            'userAnswers' => $isLivePreview ? [] : session('meeting17_user_answers', []),
            'userParagraphAnswer' => $isLivePreview ? '' : session('meeting17_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(array $fallbackQuestions): array
    {
        return $this->loadKeyedQuestionsForMeeting(17, $fallbackQuestions, function ($question) {
            $mappedQuestion = [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'structure' => $question->structure,
                'conjunction' => $question->formula,
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