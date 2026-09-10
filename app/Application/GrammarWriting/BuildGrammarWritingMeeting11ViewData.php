<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsFallbackGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting11ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsFallbackGrammarWritingQuestions;
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
            'submitted' => $isLivePreview ? false : session('meeting11_submitted', false),
            'results' => $isLivePreview ? [] : session('meeting11_results', []),
            'paragraphResult' => $isLivePreview ? [] : session('meeting11_paragraph_result', []),
            'finalScore' => $isLivePreview ? 0 : session('meeting11_final_score', 0),
            'userAnswers' => $isLivePreview ? [] : session('meeting11_user_answers', []),
            'userParagraphAnswer' => $isLivePreview ? '' : session('meeting11_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(array $fallbackQuestions): Collection
    {
        return $this->loadFallbackQuestionsForMeeting(
            11,
            $fallbackQuestions,
            function ($question) {
                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'vocab' => $question->vocab,
                    'example' => $question->example_en,
                    'db_id' => $question->id,
                ];
            },
            function ($question) {
                return [
                    'id' => $question['id'],
                    'en' => $question['en'],
                    'vocab' => $question['vocab'] ?? [],
                    'example' => $question['example'] ?? '',
                    'db_id' => null,
                ];
            }
        );
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(11, $fallbackParagraph, fn ($vocab) => $vocab ?? []);
    }
}