<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;

class BuildGrammarWritingMeeting5ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    public function handle(array $tenseExamples = []): array
    {
        [$gerundInfinitiveComplex, $toInfinitive, $gerund, $paragraph] = $this->loadSections();

        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using session() below would prefill the page with the
        // ADMIN's own session state instead of the real student's - the
        // correct per-student data is safely injected client-side afterward
        // by injectSnapshotIntoIframe() in current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');

        return [
            'gerundInfinitiveComplex' => $gerundInfinitiveComplex,
            'toInfinitive' => $toInfinitive,
            'gerund' => $gerund,
            'paragraph' => $paragraph,
            'submitted' => $isLivePreview ? false : session('meeting5_submitted', false),
            'results' => $isLivePreview ? [] : session('meeting5_results', []),
            'finalScore' => $isLivePreview ? 0 : session('meeting5_final_score', 0),
            'userAnswers' => $isLivePreview ? [] : session('meeting5_user_answers', []),
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
            $vocab = is_array($question->vocab)
                ? $question->vocab
                : (json_decode($question->vocab ?? '', true) ?: []);
            $example = is_array($question->example)
                ? $question->example
                : (json_decode($question->example ?? '', true) ?: $question->example);

            $item = [
                'db_id' => $question->id,
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'example' => $example,
                'vocab' => $vocab,
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