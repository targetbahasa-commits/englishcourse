<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingExampleQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting14ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsGrammarWritingExampleQuestions;
    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackParagraph): array
    {
        $questions = $this->loadQuestions();
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
            'submitted' => $isLivePreview ? false : session('meeting14_submitted', false),
            'results' => $isLivePreview ? [] : session('meeting14_results', []),
            'paragraphResult' => $isLivePreview ? [] : session('meeting14_paragraph_result', []),
            'finalScore' => $isLivePreview ? 0 : session('meeting14_final_score', 0),
            'userAnswers' => $isLivePreview ? [] : session('meeting14_user_answers', []),
            'userParagraphAnswer' => $isLivePreview ? '' : session('meeting14_user_paragraph_answer', ''),
        ];
    }

    public function loadQuestions(): Collection
    {
        return $this->loadExampleQuestionsForMeeting(14);
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(14, $fallbackParagraph);
    }
}