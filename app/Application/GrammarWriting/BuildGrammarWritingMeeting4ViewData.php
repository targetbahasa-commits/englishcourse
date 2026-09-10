<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;

use App\Application\GrammarWriting\Concerns\LoadsTenseStructureMatrix;

class BuildGrammarWritingMeeting4ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsTenseStructureMatrix;

    public function handle(array $tenseExamples, array $vocabularies): array
    {
        $sentenceVocabFallbacks = [
            'Pemerintah tidak mengabaikan dampak perubahan iklim global.' => [
                'Ignore' => ['id' => 'Mengabaikan', 'pos' => '(v)'],
                'Impact' => ['id' => 'Dampak', 'pos' => '(n)'],
                'Climate change' => ['id' => 'Perubahan iklim', 'pos' => '(n)'],
                'Global' => ['id' => 'Global', 'pos' => '(adj)'],
            ],
            'Bahan bakar fosil bukan sumber energi terbarukan.' => [
                'Fossil fuel' => ['id' => 'Bahan bakar fosil', 'pos' => '(n)'],
                'Renewable energy' => ['id' => 'Energi terbarukan', 'pos' => '(n)'],
                'Source' => ['id' => 'Sumber', 'pos' => '(n)'],
            ],
            'Para peneliti tidak menemukan bukti pencemaran air pada ekspedisi kemarin.' => [
                'Researcher' => ['id' => 'Peneliti', 'pos' => '(n)'],
                'Find' => ['id' => 'Menemukan', 'pos' => '(v)'],
                'Evidence' => ['id' => 'Bukti', 'pos' => '(n)'],
                'Water pollution' => ['id' => 'Pencemaran air', 'pos' => '(n)'],
                'Expedition' => ['id' => 'Ekspedisi', 'pos' => '(n)'],
            ],
            'Stasiun penelitian itu tidak aktif selama musim dingin tahun lalu.' => [
                'Research station' => ['id' => 'Stasiun penelitian', 'pos' => '(n)'],
                'Active' => ['id' => 'Aktif', 'pos' => '(adj)'],
                'During' => ['id' => 'Selama', 'pos' => '(prep)'],
                'Winter' => ['id' => 'Musim dingin', 'pos' => '(n)'],
            ],
            'Para ilmuwan tidak sedang menguji vaksin baru tersebut saat ini.' => [
                'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
                'Test' => ['id' => 'Menguji', 'pos' => '(v)'],
                'Vaccine' => ['id' => 'Vaksin', 'pos' => '(n)'],
                'At present' => ['id' => 'Saat ini', 'pos' => '(adv)'],
            ],
            'Tim geologi tidak sedang mengebor batuan vulkanik ketika badai terjadi.' => [
                'Geological team' => ['id' => 'Tim geologi', 'pos' => '(n)'],
                'Drill' => ['id' => 'Mengebor', 'pos' => '(v)'],
                'Volcanic rock' => ['id' => 'Batuan vulkanik', 'pos' => '(n)'],
                'Storm' => ['id' => 'Badai', 'pos' => '(n)'],
                'Occur' => ['id' => 'Terjadi', 'pos' => '(v)'],
            ],
            'Banyak negara berkembang belum menerapkan teknologi energi terbarukan.' => [
                'Developing countries' => ['id' => 'Negara berkembang', 'pos' => '(n)'],
                'Implement' => ['id' => 'Menerapkan', 'pos' => '(v)'],
                'Renewable energy' => ['id' => 'Energi terbarukan', 'pos' => '(n)'],
                'Technology' => ['id' => 'Teknologi', 'pos' => '(n)'],
            ],
            'Spesies langka itu belum punah sebelum bencana letusan gunung terjadi.' => [
                'Rare species' => ['id' => 'Spesies langka', 'pos' => '(n)'],
                'Extinct' => ['id' => 'Punah', 'pos' => '(adj)'],
                'Volcanic eruption' => ['id' => 'Letusan gunung', 'pos' => '(n)'],
                'Disaster' => ['id' => 'Bencana', 'pos' => '(n)'],
            ],
            'Kecerdasan buatan tidak akan menggantikan seluruh peran tenaga medis profesional.' => [
                'Artificial intelligence' => ['id' => 'Kecerdasan buatan', 'pos' => '(n)'],
                'Replace' => ['id' => 'Menggantikan', 'pos' => '(v)'],
                'Role' => ['id' => 'Peran', 'pos' => '(n)'],
                'Medical personnel' => ['id' => 'Tenaga medis', 'pos' => '(n)'],
            ],
            'Masyarakat seharusnya tidak membuang limbah kimia berbahaya ke sungai.' => [
                'Society' => ['id' => 'Masyarakat', 'pos' => '(n)'],
                'Dispose of' => ['id' => 'Membuang', 'pos' => '(v)'],
                'Hazardous chemical waste' => ['id' => 'Limbah kimia berbahaya', 'pos' => '(n)'],
                'River' => ['id' => 'Sungai', 'pos' => '(n)'],
            ],
            'Kita tidak menyelesaikan masalah ini.' => [
                'Solve' => ['id' => 'Menyelesaikan', 'pos' => '(v1)'],
                'Problem' => ['id' => 'Masalah', 'pos' => '(n)'],
            ],
            'Dia (it) tidak membantu.' => [
                'Help' => ['id' => 'Membantu', 'pos' => '(v1)'],
            ],
            'Pemerintah tidak melindungi hutan.' => [
                'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                'Protect' => ['id' => 'Melindungi', 'pos' => '(v1)'],
                'Forest' => ['id' => 'Hutan', 'pos' => '(n)'],
            ],
            'Undang-undang tidak menjamin kebebasan berekspresi.' => [
                'Law' => ['id' => 'Undang-undang / Hukum', 'pos' => '(n)'],
                'Guarantee' => ['id' => 'Menjamin', 'pos' => '(v1)'],
                'Freedom of expression' => ['id' => 'Kebebasan berekspresi', 'pos' => '(n)'],
            ],
            'Mamalia tidak menyebar secara luas 2 juta tahun yang lalu.' => [
                'Mammal' => ['id' => 'Mamalia', 'pos' => '(n)'],
                'Spread' => ['id' => 'Menyebar', 'pos' => '(v1)'],
                'Widely' => ['id' => 'Secara luas', 'pos' => '(adv)'],
            ],
        ];

        $sentences = collect($this->repository->getQuestionsByMeetingAndSection(4, 'sentences'))
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

        $matrixIntroSentences = collect($this->repository->getQuestionsByMeetingAndSection(4, 'matrix_intro'))
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

        $translationMatrix = $this->loadTenseStructureMatrix(4, [], function ($question) {
            $vocab = $question->vocab;
            if (is_string($vocab)) {
                $vocab = json_decode($vocab, true);
            }

            return [
                'id' => $question->question_text,
                'en' => $question->correct_answer,
                'question_number' => $question->question_number,
                'original_id' => $question->id,
                'vocab' => $vocab,
            ];
        });

        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using auth()->id()/session() below would prefill the
        // page with the ADMIN's own session/database draft instead of the
        // real student's - the correct per-student data is safely injected
        // client-side afterward by injectSnapshotIntoIframe() in
        // current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');
        $userId = $isLivePreview ? null : auth()->id();
        $stage = $isLivePreview ? 1 : session('meeting4_stage', 1);
        $transResults = $isLivePreview ? [] : session('meeting4_trans_results', []);
        $scorePart1 = $isLivePreview ? 0 : session('meeting4_score_part1', 0);
        $scorePart2 = $isLivePreview ? 0 : session('meeting4_score_part2', 0);
        $totalScore = $isLivePreview ? 0 : session('meeting4_total_score', 0);
        $draftAnswers = $isLivePreview ? [] : session('meeting4_user_answers', []);

        if ($userId) {
            try {
                $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? auth()->user()?->program_id;
                if ($programId) {
                    $scoreRecord = \App\Models\MeetingScore::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', 4)
                        ->latest('submitted_at')
                        ->first();

                    if ($scoreRecord) {
                        $stage = 3;
                        $totalScore = $scoreRecord->score;
                        $scoreData = is_array($scoreRecord->answers) ? $scoreRecord->answers : json_decode($scoreRecord->answers ?? '[]', true);
                        if (!empty($scoreData)) {
                            $transResults = $scoreData['meeting4_trans_results'] ?? ($scoreData['transResults'] ?? []);
                            $scorePart1 = $scoreData['meeting4_score_part1'] ?? ($scoreData['scorePart1'] ?? 0);
                            $scorePart2 = $scoreData['meeting4_score_part2'] ?? ($scoreData['scorePart2'] ?? 0);
                            if (empty($draftAnswers) && isset($scoreData['meeting4_user_answers'])) {
                                $draftAnswers = $scoreData['meeting4_user_answers'];
                            }
                        }
                    }

                    if (empty($draftAnswers)) {
                        $draft = \App\Models\AssignmentDraft::where('user_id', $userId)
                            ->where('program_id', $programId)
                            ->where('meeting_number', 4)
                            ->first();
                        if ($draft && is_array($draft->answers)) {
                            $draftAnswers = $draft->answers;
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        $isAiVariation = $isLivePreview ? false : session('meeting4_use_ai_variation', false);
        $aiVariation = $isLivePreview ? null : session('meeting4_ai_variation');
        $aiAttempt = $isLivePreview ? 1 : session('meeting4_ai_attempt', 1);

        if ($isAiVariation && is_array($aiVariation) && !empty($aiVariation['sentences'])) {
            $sentences = collect($aiVariation['sentences']);
            $matrixIntroSentences = collect($aiVariation['matrixIntro'] ?? []);
            $translationMatrix = $aiVariation['matrix'] ?? [];
        }

        return [
            'translationSentences' => $sentences,
            'matrixIntroSentences' => $matrixIntroSentences,
            'translationMatrix' => $translationMatrix,
            'tenseExamples' => $tenseExamples,
            'vocabularies' => $vocabularies,
            'stage' => $stage,
            'transResults' => $transResults,
            'scorePart1' => $scorePart1,
            'scorePart2' => $scorePart2,
            'totalScore' => $totalScore,
            'draftAnswers' => $draftAnswers,
            'isAiVariation' => $isAiVariation,
            'aiAttempt' => $aiAttempt,
        ];
    }
}
