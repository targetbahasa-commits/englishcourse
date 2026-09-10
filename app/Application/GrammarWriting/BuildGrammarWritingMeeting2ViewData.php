<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsTenseStructureMatrix;

class BuildGrammarWritingMeeting2ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsTenseStructureMatrix;

    /**
     * $track: null for fast-track's own meeting 1 (the original page this
     * was built for - keeps its exact existing session keys, untouched, so
     * no in-progress fast-track session is disturbed), 'complexity' when
     * this same view/questions are reused for Complexity's meeting 1 (see
     * GrammarWritingAdminController::grammarWritingComplexityMeeting()) -
     * without this, both tracks' stage/results/scores collided on the
     * exact same bare "meeting2_*" session keys, so progress in one track
     * silently overwrote the other's.
     */
    public function handle(array $tenses, array $tenseExamples, array $vocabularies, ?string $track = null): array
    {
        $sentenceVocabFallbacks = [
            'Kita membangun dunia ini.' => [
                'Build' => ['id' => 'Membangun', 'pos' => '(v)'],
                'World' => ['id' => 'Dunia', 'pos' => '(n)'],
                'This' => ['id' => 'Ini', 'pos' => '(det)'],
            ],
            'Dia (perempuan) menjadi pemimpin.' => [
                'Become' => ['id' => 'Menjadi', 'pos' => '(v)'],
                'Leader' => ['id' => 'Pemimpin', 'pos' => '(n)'],
            ],
        ];

        $sentences = collect($this->repository->getQuestionsByMeetingAndSection(2, 'sentences'))
            ->map(function ($question) use ($sentenceVocabFallbacks) {
                $vocab = $question->vocab;
                if (is_string($vocab)) {
                    $vocab = json_decode($vocab, true);
                }
                if (empty($vocab) && isset($sentenceVocabFallbacks[$question->question_text])) {
                    $vocab = $sentenceVocabFallbacks[$question->question_text];
                }

                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'tense' => $question->tense,
                    'type' => $question->structure,
                    'question_number' => $question->question_number,
                    'original_id' => $question->id,
                    'vocab' => $vocab,
                ];
            });

        $translationMatrix = $this->loadTenseStructureMatrix(2, [], function ($question) {
            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'question_number' => $question->question_number,
                'original_id' => $question->id,
            ];
        });

        $keyPrefix = $track ? "{$track}_" : '';
        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using auth()->id()/session() below would prefill the
        // page with the ADMIN's own session/database draft instead of the
        // real student's - the correct per-student data is safely injected
        // client-side afterward by injectSnapshotIntoIframe() in
        // current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');

        if ($isLivePreview) {
            $stage = 1;
            $results = [];
            $transResults = [];
            $scorePart1 = 0;
            $scorePart2 = 0;
            $totalScore = 0;
            $draftAnswers = [];
        } else {
            $stage = session("{$keyPrefix}meeting2_stage", 1);
            $results = session("{$keyPrefix}meeting2_results", []);
            $transResults = session("{$keyPrefix}meeting2_trans_results", []);
            $scorePart1 = session("{$keyPrefix}meeting2_score_part1", 0);
            $scorePart2 = session("{$keyPrefix}meeting2_score_part2", 0);
            $totalScore = session("{$keyPrefix}meeting2_total_score", 0);
            $draftAnswers = $track
                ? session("{$track}_meeting1_draft_answers", [])
                : session('meeting2_user_answers', []);

            $userId = auth()->id();
            if ($userId) {
                try {
                    $programSlug = $track === 'complexity' ? 'complexity-grammar-for-writing' : 'fast-track-grammar-for-writing';
                    $programId = \App\Models\Program::where('slug', $programSlug)->value('id') ?? auth()->user()?->program_id;
                    $meetingNum = 1;

                    if ($programId) {
                        $scoreRecord = \App\Models\MeetingScore::where('user_id', $userId)
                            ->where('program_id', $programId)
                            ->where('meeting_number', $meetingNum)
                            ->latest('submitted_at')
                            ->first();

                        if ($scoreRecord) {
                            $stage = 3;
                            $totalScore = $scoreRecord->score;
                            $scoreData = is_array($scoreRecord->answers) ? $scoreRecord->answers : json_decode($scoreRecord->answers ?? '[]', true);
                            if (!empty($scoreData)) {
                                $results = $scoreData['meeting2_results'] ?? ($scoreData['results'] ?? $results);
                                $transResults = $scoreData['meeting2_trans_results'] ?? ($scoreData['transResults'] ?? $transResults);
                                $scorePart1 = $scoreData['meeting2_score_part1'] ?? ($scoreData['scorePart1'] ?? $scorePart1);
                                $scorePart2 = $scoreData['meeting2_score_part2'] ?? ($scoreData['scorePart2'] ?? $scorePart2);
                            }
                        }

                        if (empty($draftAnswers)) {
                            $draft = \App\Models\AssignmentDraft::where('user_id', $userId)
                                ->where('program_id', $programId)
                                ->where('meeting_number', $meetingNum)
                                ->first();
                            if ($draft && is_array($draft->answers)) {
                                $draftAnswers = $draft->answers;
                            }
                        }
                    }
                } catch (\Throwable $e) {}
            }
        }

        return [
            'tenses' => $tenses,
            'translationSentences' => $sentences,
            'translationMatrix' => $translationMatrix,
            'tenseExamples' => $tenseExamples,
            'vocabularies' => $vocabularies,
            'track' => $track,
            'stage' => $stage,
            'results' => $results,
            'transResults' => $transResults,
            'scorePart1' => $scorePart1,
            'scorePart2' => $scorePart2,
            'totalScore' => $totalScore,
            'draftAnswers' => $draftAnswers,
        ];
    }
}