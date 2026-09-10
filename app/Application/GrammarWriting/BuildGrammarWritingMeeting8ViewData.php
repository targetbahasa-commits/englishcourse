<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsQuestionSectionWithParagraph;

class BuildGrammarWritingMeeting8ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsQuestionSectionWithParagraph;

    public function handle(): array
    {
        [$questions, $paragraph] = $this->loadSections();
        $paragraph = $paragraph ?? [];
        $paragraph['sentences'] = $paragraph['sentences'] ?? [];

        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using session() below would prefill the page with the
        // ADMIN's own session state instead of the real student's - the
        // correct per-student data is safely injected client-side afterward
        // by injectSnapshotIntoIframe() in current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');

        return [
            'questions' => $questions,
            'paragraph' => $paragraph,
            'submitted' => $isLivePreview ? false : session('meeting8_submitted', false),
            'results' => $isLivePreview ? [] : session('meeting8_results', []),
            'paragraphResult' => $isLivePreview ? [] : session('meeting8_paragraph_result', []),
            'finalScore' => $isLivePreview ? 0 : session('meeting8_final_score', 0),
            'userAnswers' => $isLivePreview ? [] : session('meeting8_user_answers', []),
            'userParagraphAnswer' => $isLivePreview ? '' : session('meeting8_user_paragraph_answer', ''),
        ];
    }

    public function loadSections(): array
    {
        return $this->loadQuestionSectionWithParagraph(8, 'prepositional_phrases');
    }
}