<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;

class BuildGrammarWritingMeeting16ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackParagraph): array
    {
        $paragraph = $this->loadParagraph($fallbackParagraph);

        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using session() below would prefill the page with the
        // ADMIN's own session state instead of the real student's - the
        // correct per-student data is safely injected client-side afterward
        // by injectSnapshotIntoIframe() in current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');

        return [
            'submitted' => $isLivePreview ? false : session('meeting16_submitted', false),
            'results' => $isLivePreview ? [] : session('meeting16_results', []),
            'paragraphResult' => $isLivePreview ? [] : session('meeting16_paragraph_result', []),
            'finalScore' => $isLivePreview ? 0 : session('meeting16_final_score', 0),
            'userAnswers' => $isLivePreview ? [] : session('meeting16_user_answers', []),
            'userParagraphAnswer' => $isLivePreview ? '' : session('meeting16_user_paragraph_answer', ''),
            'questions' => [],
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'paragraphDbId' => $paragraph['db_id'],
        ];
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(16, $fallbackParagraph);
    }
}