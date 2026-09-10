<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;



class BuildGrammarWritingMeeting6ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    public function handle(): array
    {
        [$verbPatterns, $toInfinitive, $gerund, $paragraph] = $this->loadSections();

        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using session() below would prefill the page with the
        // ADMIN's own session state instead of the real student's - the
        // correct per-student data is safely injected client-side afterward
        // by injectSnapshotIntoIframe() in current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');

        return [
            'verbPatterns' => $verbPatterns,
            'toInfinitive' => $toInfinitive,
            'gerund' => $gerund,
            'paragraph' => $paragraph,
            'submitted' => $isLivePreview ? false : session('meeting6_submitted', false),
            'results' => $isLivePreview ? [] : session('meeting6_results', []),
            'finalScore' => $isLivePreview ? 0 : session('meeting6_final_score', 0),
            'userAnswers' => $isLivePreview ? [] : session('meeting6_user_answers', []),
        ];
    }

    public function loadSections(): array
    {
        $questions = $this->repository->getLegacyQuestionsByMeeting(6);

        $verbPatterns = [];
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

            if ($question->section === 'verb_patterns') {
                $verbPatterns[$question->question_number] = $item;
            } elseif ($question->section === 'to_infinitive') {
                $toInfinitive[$question->question_number] = $item;
            } elseif ($question->section === 'gerund') {
                $gerund[$question->question_number] = $item;
            } elseif ($question->section === 'paragraph') {
                $paragraph = $item;
            }
        }

        return [$verbPatterns, $toInfinitive, $gerund, $paragraph];
    }
}