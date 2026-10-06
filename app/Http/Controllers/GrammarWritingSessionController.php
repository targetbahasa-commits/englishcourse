<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\BuildGrammarWritingMeeting5ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting6ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting7ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting8ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting9ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting2ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting10ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting11ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting12ViewData;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting5Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting6Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting7Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting8Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting9Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting2Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting10Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting11Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting12Submission;
use App\Application\GrammarWriting\GrammarWritingDataRepository;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\HandlesGrammarWritingSessions;
use Illuminate\Http\Request;

class GrammarWritingSessionController extends Controller
{

    /**
     * GrammarWritingSessionController
     *
     * Handles grammar-writing meetings 2 and 5–12 (student-facing session logic).
     * All session helpers and view data are injected; no admin logic here.
     */
    use HandlesAssignmentAccess;
    use HandlesGrammarWritingSessions;

    public function __construct(private GrammarWritingDataRepository $data)
    {
        $this->registerAssignmentAccessMiddleware();
    }

    public function meeting2(BuildGrammarWritingMeeting2ViewData $buildGrammarWritingMeeting2ViewData)
    {
        return view('assignments.grammar-writing.meeting2', $buildGrammarWritingMeeting2ViewData->handle(
            $this->data->meeting2Tenses,
            $this->data->meeting2TenseExamples,
            $this->data->meeting2Vocabularies,
        ));
    }

    public function meeting2Submit(Request $request, EvaluateGrammarWritingMeeting2Submission $evaluateGrammarWritingMeeting2Submission)
    {
        $stage = session('meeting2_stage', 1);

        $evaluation = $evaluateGrammarWritingMeeting2Submission->handle(
            $stage,
            $request->all(),
            $this->data->meeting2Tenses,
            $this->data->meeting2TranslationSentences,
            $this->data->meeting2TranslationMatrix,
            (int) session('meeting2_score_part1', 0),
        );

        $targetRoute = $request->routeIs('assignments.grammar-writing.meeting2.submit')
            ? 'assignments.grammar-writing.meeting2'
            : 'assignments.grammar-writing.meeting1';

        return $this->completeConditionalGrammarWritingMeetingSubmission(
            1,
            $targetRoute,
            $evaluation['session'] ?? [],
            !empty($evaluation['saveScore']) ? $evaluation['totalScore'] : null,
        );
    }

    public function meeting2Reset(Request $request)
    {
        $targetRoute = $request->routeIs('assignments.grammar-writing.meeting2.reset')
            ? 'assignments.grammar-writing.meeting2'
            : 'assignments.grammar-writing.meeting1';

        return $this->resetGrammarWritingMeetingSession(
            $targetRoute,
            [
            'meeting2_stage',
            'meeting2_results',
            'meeting2_trans_results',
            'meeting2_score_part1',
            'meeting2_score_part2',
            'meeting2_total_score'
            ],
        );
    }

    // ── Meeting 2 Practice (fast-track/meeting2) ──────────────────────────────
    // Latihan penerapan tenses — same view/data as meeting2 (materi)
    // but stored under separate session keys so progress is independent.

    public function meeting2Practice()
    {
        $questions = [
            'Seluruh parameter penelitian telah diselesaikan melalui proses verifikasi yang ketat.',
            'Para kartografer sedang melakukan pemetaan komprehensif terhadap wilayah pesisir.',
            'Karakteristik geomorfologi di wilayah pegunungan ini sangat unik.',
            'Peradaban kuno tersebut membangun sistem irigasi yang kompleks di wilayah gersang.',
            'Setiap elemen dalam ekosistem ini harus tetap seimbang.',
            'Strategi mitigasi bencana sedang ditinjau kembali oleh otoritas terkait.',
            'Ilmuwan asal Polandia tersebut telah menjadi figur sentral dalam teori fisika kuantum.',
            'Mekanisme fotosintesis mempermudah konversi energi surya menjadi energi kimia.',
            'Struktur birokrasi pada masa kekaisaran tersebut tidak kaku.',
            'Naskah kuno tersebut dikirimkan ke museum pusat untuk proses preservasi digital.',
            'Analisis spektrum cahaya dapat memberikan informasi krusial mengenai komposisi bintang.',
            'Para arsitek telah membangun fondasi tahan guncangan pada gedung tersebut.',
            'Kondisi atmosfer di planet tersebut sedang berada dalam tahap transisi ekstrem.',
            'Kebijakan dekarbonisasi ekonomi wajib diimplementasikan secara global.',
            'Tim arkeolog menemukan sisa-sisa permukiman neolitikum selama ekskavasi kemarin.',
        ];
        
        $questionHelpers = [
            1 => ['example' => ['id' => 'Seluruh dokumen telah diverifikasi oleh tim audit internal.', 'en' => 'All documents have been verified by the internal audit team.'], 'vocab' => ['verify' => ['id' => 'memverifikasi', 'pos' => '(v1)'], 'strict process' => ['id' => 'proses ketat', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Para peneliti sedang memetakan area pesisir secara detail.', 'en' => 'Researchers are mapping the coastal area in detail.'], 'vocab' => ['mapping' => ['id' => 'pemetaan', 'pos' => '(n)'], 'coastal area' => ['id' => 'wilayah pesisir', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Karakteristik geologis daerah ini sangat berbeda.', 'en' => 'The geological characteristics of this region are very different.'], 'vocab' => ['geomorphology' => ['id' => 'geomorfologi', 'pos' => '(n)'], 'mountainous' => ['id' => 'pegunungan', 'pos' => '(adj)']]],
            4 => ['example' => ['id' => 'Peradaban kuno membangun kanal irigasi di area kering.', 'en' => 'Ancient civilizations built irrigation canals in arid areas.'], 'vocab' => ['civilization' => ['id' => 'peradaban', 'pos' => '(n)'], 'arid' => ['id' => 'gersang', 'pos' => '(adj)']]],
            5 => ['example' => ['id' => 'Setiap komponen sistem harus berada dalam keseimbangan.', 'en' => 'Each system component must remain in balance.'], 'vocab' => ['element' => ['id' => 'elemen', 'pos' => '(n)'], 'balanced' => ['id' => 'seimbang', 'pos' => '(adj)']]],
            6 => ['example' => ['id' => 'Strategi mitigasi sedang ditinjau oleh lembaga terkait.', 'en' => 'The mitigation strategy is being reviewed by the relevant institution.'], 'vocab' => ['mitigation' => ['id' => 'mitigasi', 'pos' => '(n)'], 'review' => ['id' => 'meninjau', 'pos' => '(v1)']]],
            7 => ['example' => ['id' => 'Ilmuwan itu menjadi tokoh penting dalam fisika modern.', 'en' => 'That scientist became a key figure in modern physics.'], 'vocab' => ['scientist' => ['id' => 'ilmuwan', 'pos' => '(n)'], 'central figure' => ['id' => 'figur sentral', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Fotosintesis mengubah energi cahaya menjadi energi kimia.', 'en' => 'Photosynthesis converts light energy into chemical energy.'], 'vocab' => ['photosynthesis' => ['id' => 'fotosintesis', 'pos' => '(n)'], 'converts' => ['id' => 'mengonversi', 'pos' => '(v1)']]],
            9 => ['example' => ['id' => 'Struktur administrasi pada era itu tidak terlalu kaku.', 'en' => 'The administrative structure in that era was not too rigid.'], 'vocab' => ['bureaucratic structure' => ['id' => 'struktur birokrasi', 'pos' => '(n)'], 'rigid' => ['id' => 'kaku', 'pos' => '(adj)']]],
            10 => ['example' => ['id' => 'Naskah bersejarah dikirim ke museum untuk digitalisasi.', 'en' => 'The historical manuscript was sent to the museum for digitization.'], 'vocab' => ['manuscript' => ['id' => 'naskah', 'pos' => '(n)'], 'digital preservation' => ['id' => 'preservasi digital', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Analisis spektrum membantu menentukan unsur bintang.', 'en' => 'Spectrum analysis helps determine stellar elements.'], 'vocab' => ['spectrum analysis' => ['id' => 'analisis spektrum', 'pos' => '(n)'], 'composition' => ['id' => 'komposisi', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Arsitek membangun fondasi antigempa untuk gedung utama.', 'en' => 'Architects built an earthquake-resistant foundation for the main building.'], 'vocab' => ['foundation' => ['id' => 'fondasi', 'pos' => '(n)'], 'earthquake-resistant' => ['id' => 'tahan guncangan', 'pos' => '(adj)']]],
            13 => ['example' => ['id' => 'Atmosfer planet itu berada dalam fase transisi ekstrem.', 'en' => 'That planet atmosphere is in an extreme transition phase.'], 'vocab' => ['atmosphere' => ['id' => 'atmosfer', 'pos' => '(n)'], 'transition phase' => ['id' => 'tahap transisi', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Kebijakan dekarbonisasi wajib diterapkan oleh setiap negara.', 'en' => 'Decarbonization policies must be implemented by every country.'], 'vocab' => ['decarbonization' => ['id' => 'dekarbonisasi', 'pos' => '(n)'], 'implement' => ['id' => 'mengimplementasikan', 'pos' => '(v1)']]],
            15 => ['example' => ['id' => 'Tim arkeolog menemukan permukiman neolitikum saat ekskavasi.', 'en' => 'The archaeologist team discovered a Neolithic settlement during excavation.'], 'vocab' => ['archaeologist' => ['id' => 'arkeolog', 'pos' => '(n)'], 'excavation' => ['id' => 'ekskavasi', 'pos' => '(n)']]],
        ];
        
        $paragraph = [
            'id' => 'Para ilmuwan di seluruh dunia terus mempelajari dinamika perubahan iklim global. Selama beberapa dekade terakhir, suhu rata-rata bumi telah meningkat secara signifikan akibat emisi gas rumah kaca. Saat ini, tim peneliti sedang menganalisis data satelit untuk memantau pencairan lapisan es di kutub. Pada tahun lalu, stasiun meteorologi mencatat rekor suhu tertinggi di berbagai belahan dunia. Jika tren pemanasan ini tidak segera dihentikan, keanekaragaman hayati laut akan mengalami kepunahan massal dalam beberapa dekade mendatang. Oleh karena itu, kebijakan transisi energi terbarukan harus diterapkan secara komprehensif oleh seluruh negara.',
            'en' => 'Scientists around the world continue to study the dynamics of global climate change. Over the past few decades, the earth\'s average temperature has increased significantly due to greenhouse gas emissions. Currently, research teams are analyzing satellite data to monitor the melting of polar ice caps. Last year, meteorological stations recorded the highest temperature records in various parts of the world. If this warming trend is not stopped immediately, marine biodiversity will suffer mass extinction in the coming decades. Therefore, renewable energy transition policies must be implemented comprehensively by all nations.',
            'vocab' => [
                'climate change' => ['id' => 'perubahan iklim', 'pos' => '(n)'],
                'average temperature' => ['id' => 'suhu rata-rata', 'pos' => '(n)'],
                'greenhouse gas emissions' => ['id' => 'emisi gas rumah kaca', 'pos' => '(n)'],
                'satellite data' => ['id' => 'data satelit', 'pos' => '(n)'],
                'polar ice caps' => ['id' => 'lapisan es kutub', 'pos' => '(n)'],
                'meteorological station' => ['id' => 'stasiun meteorologi', 'pos' => '(n)'],
                'biodiversity' => ['id' => 'keanekaragaman hayati', 'pos' => '(n)'],
                'mass extinction' => ['id' => 'kepunahan massal', 'pos' => '(n)'],
                'renewable energy' => ['id' => 'energi terbarukan', 'pos' => '(n)'],
                'comprehensively' => ['id' => 'secara komprehensif', 'pos' => '(adv)'],
            ]
        ];

        // DB paragraph override if exists
        $dbParagraph = \App\Models\GrammarQuestion::where('meeting_number', 2)->where('section', 'paragraph')->first();
        if ($dbParagraph) {
            $paragraph = [
                'id' => $dbParagraph->question_text,
                'en' => $dbParagraph->correct_answer,
                'vocab' => is_array($dbParagraph->vocab) ? $dbParagraph->vocab : json_decode($dbParagraph->vocab ?? '[]', true),
            ];
        }

        $userId = auth()->id();
        // Admin Live Preview loads this exact URL (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using auth()->id()/session() below would prefill this
        // page with the ADMIN's own session/database draft (which, from
        // browsing many different students' previews over time, ends up an
        // accumulated mix of whichever students' answers happened to be
        // showing when a sync fired) instead of the real student's - the
        // correct per-student data is safely injected client-side afterward
        // by injectSnapshotIntoIframe() in current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');

        if ($isLivePreview) {
            $submitted = false;
            $results = [];
            $paragraphResult = null;
            $finalScore = 0;
            $userAnswers = [];
            $userParagraphAnswer = '';
            $draftAnswers = [];
            $draftParagraph = '';
        } else {
            $submitted = session('fast-track_meeting2_submitted', false);
            $results = session('fast-track_meeting2_results', []);
            $paragraphResult = session('fast-track_meeting2_paragraph_result', null);
            $finalScore = session('fast-track_meeting2_final_score', 0);
            $userAnswers = session('fast-track_meeting2_user_answers', []);
            $userParagraphAnswer = session('fast-track_meeting2_user_paragraph', '');
            $draftAnswers = session('fast-track_meeting2_draft_answers', []);
            $draftParagraph = session('fast-track_meeting2_draft_paragraph', '');

            if ($userId) {
                try {
                    $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? auth()->user()?->program_id;

                    // If not submitted in current session, check database MeetingScore
                    if (!$submitted && $programId) {
                        $scoreRecord = \App\Models\MeetingScore::where('user_id', $userId)
                            ->where('program_id', $programId)
                            ->where('meeting_number', 2)
                            ->latest('submitted_at')
                            ->first();

                        if ($scoreRecord) {
                            $submitted = true;
                            $finalScore = $scoreRecord->score;
                            $scoreData = is_array($scoreRecord->answers) ? $scoreRecord->answers : json_decode($scoreRecord->answers ?? '[]', true);
                            if (!empty($scoreData)) {
                                $results = $scoreData['results'] ?? [];
                                $paragraphResult = $scoreData['paragraph_result'] ?? null;
                                $userAnswers = $scoreData['user_answers'] ?? [];
                                $userParagraphAnswer = $scoreData['user_paragraph'] ?? '';
                            }
                        }
                    }

                    // If answers are still empty, load from AssignmentDraft
                    if (empty($draftAnswers) && empty($userAnswers) && $programId) {
                        $draft = \App\Models\AssignmentDraft::where('user_id', $userId)
                            ->where('program_id', $programId)
                            ->where('meeting_number', 2)
                            ->first();
                        if ($draft && is_array($draft->answers)) {
                            $saved = $draft->answers;
                            if (isset($saved['paragraph_answer'])) {
                                if ($draftParagraph === '' && $userParagraphAnswer === '') {
                                    $draftParagraph = (string) $saved['paragraph_answer'];
                                }
                                unset($saved['paragraph_answer']);
                            }
                            $draftAnswers = $saved;
                        }
                    }
                } catch (\Throwable $e) {}
            }
        }

        return view('assignments.grammar-writing-complexity-meeting', [
            'meetingNumber' => 2,
            'topic' => 'Latihan penerapan tenses',
            'trackTitle' => 'Fast-track Grammar for Writing',
            'questions' => $questions,
            'questionHelpers' => $questionHelpers,
            'paragraph' => $paragraph,
            'backRoute' => route('assignments.grammar-writing.track', 'fast-track'),
            'track' => 'fast-track',
            'requireTenseAnswer' => true,
            'draftAnswers' => !empty($userAnswers) ? $userAnswers : $draftAnswers,
            'draftParagraph' => $userParagraphAnswer !== '' ? $userParagraphAnswer : $draftParagraph,
            'submitted' => $submitted,
            'results' => $results,
            'paragraphResult' => $paragraphResult,
            'finalScore' => $finalScore,
            'userAnswers' => $userAnswers,
            'userParagraphAnswer' => $userParagraphAnswer,
            'submitRoute' => route('assignments.grammar-writing.meeting2.submit'),
            'resetRoute' => route('assignments.grammar-writing.meeting2.reset'),
            'cheatSheet' => app(GrammarWritingAdminController::class)->complexityMeetingCheatSheet(2),
        ]);
    }

    public function meeting2PracticeSubmit(Request $request)
    {
        $static = app(GrammarWritingAdminController::class)->complexityStaticQuestions(2);
        $questions = $static['questions'] ?? [];
        $paragraph = $static['paragraph'] ?? null;

        $dbParagraph = \App\Models\GrammarQuestion::where('meeting_number', 2)->where('section', 'paragraph')->first();
        if ($dbParagraph) {
            $paragraph = [
                'id' => $dbParagraph->question_text,
                'en' => $dbParagraph->correct_answer,
                'vocab' => is_array($dbParagraph->vocab) ? $dbParagraph->vocab : json_decode($dbParagraph->vocab ?? '[]', true),
            ];
        }

        $userAnswers = $request->input('answers', []);
        $userParagraph = trim((string) $request->input('userParagraphAnswer', ''));

        $questionResults = [];
        $totalScore = 0;
        $maxQuestionsScore = count($questions) * 5;
        $maxParagraphScore = 25;
        $totalMax = $maxQuestionsScore + ($paragraph ? $maxParagraphScore : 0);

        $evaluator = new class {
            use \App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;
            public function score($user, $correct, $max) {
                return $this->scoreWordMatchAnswer($user, $correct, $max);
            }
        };

        $expectedAnswers = [
            1 => 'All research parameters have been completed through a rigorous verification process.',
            2 => 'Cartographers are conducting a comprehensive mapping of coastal areas.',
            3 => 'Geomorphological characteristics in this mountainous region are unique.',
            4 => 'The ancient civilization built a complex irrigation system in arid regions.',
            5 => 'Each element in this ecosystem must remain balanced.',
            6 => 'The disaster mitigation strategy is being reviewed by the relevant authority.',
            7 => 'The Polish scientist has become a central figure in quantum physics theory.',
            8 => 'The mechanism of photosynthesis facilitates the conversion of solar energy into chemical energy.',
            9 => 'The bureaucratic structure during that empire was not rigid.',
            10 => 'The ancient manuscript was sent to the central museum for digital preservation.',
            11 => 'Light spectrum analysis can provide crucial information about stellar composition.',
            12 => 'Architects have built earthquake-resistant foundations on that building.',
            13 => 'Atmospheric conditions on that planet are in an extreme transition phase.',
            14 => 'Economic decarbonization policies must be implemented globally.',
            15 => 'The archaeologist team discovered Neolithic settlement remains during the excavation yesterday.',
        ];

        // Tense formula per the "Teknik Silang" method taught on this page:
        // Waktu (Present/Past/Future) + Aspek (Perfect/Continuous/Modal/Simple) + Bentuk (Verbal/Nominal/Passive).
        $expectedTenses = [
            1 => 'Present Perfect Passive',
            2 => 'Present Continuous Verbal',
            3 => 'Present Simple Nominal',
            4 => 'Past Simple Verbal',
            5 => 'Present Modal Verbal',
            6 => 'Present Continuous Passive',
            7 => 'Present Perfect Verbal',
            8 => 'Present Simple Verbal',
            9 => 'Past Simple Nominal',
            10 => 'Past Simple Passive',
            11 => 'Present Modal Verbal',
            12 => 'Present Perfect Verbal',
            13 => 'Present Simple Nominal',
            14 => 'Present Modal Passive',
            15 => 'Past Simple Verbal',
        ];

        foreach ($questions as $idx => $qText) {
            $qNum = $idx + 1;
            $userAnswerRaw = $userAnswers[$qNum] ?? '';
            $userTense = is_array($userAnswerRaw) ? trim((string) ($userAnswerRaw['tense'] ?? '')) : '';
            $userTrans = is_array($userAnswerRaw) ? trim((string) ($userAnswerRaw['trans'] ?? '')) : trim((string) $userAnswerRaw);

            $correctAns = $expectedAnswers[$qNum] ?? '';
            $correctTense = $expectedTenses[$qNum] ?? '';

            $transRes = $evaluator->score($userTrans, $correctAns, 3);
            $tenseRes = $evaluator->score($userTense, $correctTense, 2);

            $questionResults[$qNum] = [
                'score' => $transRes['score'] + $tenseRes['score'],
                'correct_answer' => $correctAns,
                'formatted_answer' => $transRes['formatted_answer'],
                'trans_score' => $transRes['score'],
                'tense_score' => $tenseRes['score'],
                'tense_correct_answer' => $correctTense,
                'tense_formatted_answer' => $tenseRes['formatted_answer'],
            ];
            $totalScore += $questionResults[$qNum]['score'];
        }

        $paragraphResult = null;
        if ($paragraph && !empty($paragraph['en'])) {
            $paragraphResult = $evaluator->score($userParagraph, $paragraph['en'], $maxParagraphScore);
            $totalScore += $paragraphResult['score'];
        }

        $finalScore = $totalMax > 0 ? round(($totalScore / $totalMax) * 100) : 0;

        $submissionData = [
            'results' => $questionResults,
            'paragraph_result' => $paragraphResult,
            'user_answers' => $userAnswers,
            'user_paragraph' => $userParagraph,
        ];

        session([
            'fast-track_meeting2_submitted' => true,
            'fast-track_meeting2_results' => $questionResults,
            'fast-track_meeting2_paragraph_result' => $paragraphResult,
            'fast-track_meeting2_final_score' => $finalScore,
            'fast-track_meeting2_user_answers' => $userAnswers,
            'fast-track_meeting2_user_paragraph' => $userParagraph,
        ]);

        $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? auth()->user()?->program_id;

        $this->saveMeetingScore(2, $finalScore, $programId, [
            'answers' => $submissionData,
            'answers_data' => $submissionData,
        ]);

        if (auth()->check() && $programId) {
            try {
                \App\Models\AssignmentDraft::updateOrCreate(
                    ['user_id' => auth()->id(), 'program_id' => $programId, 'meeting_number' => 2],
                    ['answers' => $userAnswers + ($userParagraph !== '' ? ['paragraph_answer' => $userParagraph] : []), 'last_saved_at' => now()]
                );
            } catch (\Throwable $e) {}
        }

        return redirect()->route('assignments.grammar-writing.meeting2')->with('success', 'Jawaban berhasil dikirim.');
    }

    public function meeting2PracticeReset()
    {
        session()->forget([
            'fast-track_meeting2_submitted',
            'fast-track_meeting2_results',
            'fast-track_meeting2_paragraph_result',
            'fast-track_meeting2_final_score',
            'fast-track_meeting2_user_answers',
            'fast-track_meeting2_user_paragraph',
            'fast-track_meeting2_draft_answers',
            'fast-track_meeting2_draft_paragraph',
            'fast-track_meeting2_draft_paragraph_answer',
        ]);

        // grammarWritingMeetingDraft() (the "Translate Kalimat" autosave endpoint)
        // caches under these keys, not the generic user_{id}_meeting2_user_answers
        // shape resetGrammarWritingMeetingSession() already forgets - without this,
        // the cached draft survived the reset and kept repopulating the page.
        \Illuminate\Support\Facades\Cache::forget('user_' . \Illuminate\Support\Facades\Auth::id() . '_fast-track_meeting2_draft_answers');
        \Illuminate\Support\Facades\Cache::forget('user_' . \Illuminate\Support\Facades\Auth::id() . '_fast-track_meeting2_draft_paragraph_answer');

        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting2',
            [],
        );
    }


    public function meeting5(BuildGrammarWritingMeeting5ViewData $buildGrammarWritingMeeting5ViewData)
    {
        return view('assignments.grammar-writing.meeting5', array_merge(
            $buildGrammarWritingMeeting5ViewData->handle(),
            [
                // Same To Infinitive vs Gerund material used by Complexity Meeting 3
                // (identical grammar topic), so both pages teach from one source.
                'cheatSheet' => app(GrammarWritingAdminController::class)->complexityMeetingCheatSheet(3),
            ]
        ));
    }

    public function meeting5Submit(
        Request $request,
        BuildGrammarWritingMeeting5ViewData $buildGrammarWritingMeeting5ViewData,
        EvaluateGrammarWritingMeeting5Submission $evaluateGrammarWritingMeeting5Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        [$gerundInfinitiveComplex, $toInfinitive, $gerund, $paragraph] = $buildGrammarWritingMeeting5ViewData->loadSections();

        $sessionPayload = $evaluateGrammarWritingMeeting5Submission->handle(
            $userAnswers,
            $gerundInfinitiveComplex,
            $toInfinitive,
            $gerund,
            $paragraph ?? [],
        );

        return $this->completeGrammarWritingMeetingSubmission(
            5,
            'assignments.grammar-writing.meeting5',
            $sessionPayload,
            'meeting5_final_score',
        );
    }

    public function meeting5Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting5',
            [
            'meeting5_submitted',
            'meeting5_results',
            'meeting5_final_score',
            'meeting5_user_answers'
            ],
        );
    }

    public function meeting6(BuildGrammarWritingMeeting6ViewData $buildGrammarWritingMeeting6ViewData)
    {
        return view('assignments.grammar-writing.meeting6', $buildGrammarWritingMeeting6ViewData->handle());
    }

    public function meeting6Submit(
        Request $request,
        BuildGrammarWritingMeeting6ViewData $buildGrammarWritingMeeting6ViewData,
        EvaluateGrammarWritingMeeting6Submission $evaluateGrammarWritingMeeting6Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        [$verbPatterns, $toInfinitive, $gerund, $paragraph] = $buildGrammarWritingMeeting6ViewData->loadSections();

        $sessionPayload = $evaluateGrammarWritingMeeting6Submission->handle(
            $userAnswers,
            $verbPatterns,
            $toInfinitive,
            $gerund,
            $paragraph ?? [],
        );

        return $this->completeGrammarWritingMeetingSubmission(
            6,
            'assignments.grammar-writing.meeting6',
            $sessionPayload,
            'meeting6_final_score',
        );
    }

    public function meeting6Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting6',
            [
            'meeting6_submitted',
            'meeting6_results',
            'meeting6_final_score',
            'meeting6_user_answers'
            ],
        );
    }

    public function meeting7(BuildGrammarWritingMeeting7ViewData $buildGrammarWritingMeeting7ViewData)
    {
        return view('assignments.grammar-writing.meeting7', $buildGrammarWritingMeeting7ViewData->handle());
    }

    public function meeting7Submit(
        Request $request,
        BuildGrammarWritingMeeting7ViewData $buildGrammarWritingMeeting7ViewData,
        EvaluateGrammarWritingMeeting7Submission $evaluateGrammarWritingMeeting7Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        [$questions, $paragraph] = $buildGrammarWritingMeeting7ViewData->loadSections();

        $sessionPayload = $evaluateGrammarWritingMeeting7Submission->handle(
            $questions,
            $paragraph ?? [],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            7,
            'assignments.grammar-writing.meeting7',
            $sessionPayload,
            'meeting7_final_score',
        );
    }

    public function meeting7Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting7',
            [
            'meeting7_submitted',
            'meeting7_results',
            'meeting7_paragraph_result',
            'meeting7_final_score',
            'meeting7_user_answers',
            'meeting7_user_paragraph_answer'
            ],
        );
    }

    public function meeting8(BuildGrammarWritingMeeting8ViewData $buildGrammarWritingMeeting8ViewData)
    {
        return view('assignments.grammar-writing.meeting8', $buildGrammarWritingMeeting8ViewData->handle());
    }

    public function meeting8Submit(
        Request $request,
        BuildGrammarWritingMeeting8ViewData $buildGrammarWritingMeeting8ViewData,
        EvaluateGrammarWritingMeeting8Submission $evaluateGrammarWritingMeeting8Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        [$questions, $paragraph] = $buildGrammarWritingMeeting8ViewData->loadSections();

        $sessionPayload = $evaluateGrammarWritingMeeting8Submission->handle(
            $questions,
            $paragraph ?? [],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            8,
            'assignments.grammar-writing.meeting8',
            $sessionPayload,
            'meeting8_final_score',
        );
    }

    public function meeting8Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting8',
            [
            'meeting8_submitted',
            'meeting8_results',
            'meeting8_paragraph_result',
            'meeting8_final_score',
            'meeting8_user_answers',
            'meeting8_user_paragraph_answer'
            ],
        );
    }

    public function meeting9(BuildGrammarWritingMeeting9ViewData $buildGrammarWritingMeeting9ViewData)
    {
        return view('assignments.grammar-writing.meeting9', $buildGrammarWritingMeeting9ViewData->handle(
            $this->data->meeting9Questions,
            $this->data->meeting9Paragraph,
        ));
    }

    public function meeting9Submit(
        Request $request,
        BuildGrammarWritingMeeting9ViewData $buildGrammarWritingMeeting9ViewData,
        EvaluateGrammarWritingMeeting9Submission $evaluateGrammarWritingMeeting9Submission,
    ) {
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $paragraph = $buildGrammarWritingMeeting9ViewData->loadParagraph($this->data->meeting9Paragraph);
        $sessionPayload = $evaluateGrammarWritingMeeting9Submission->handle(
            $userParagraphAnswer,
            $paragraph['en'],
        );

        return $this->completeGrammarWritingMeetingSubmission(
            9,
            'assignments.grammar-writing.meeting9',
            $sessionPayload,
            'meeting9_final_score',
        );
    }

    public function meeting9Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting9',
            [
            'meeting9_submitted',
            'meeting9_results',
            'meeting9_paragraph_result',
            'meeting9_final_score',
            'meeting9_user_answers',
            'meeting9_user_paragraph_answer'
            ],
        );
    }

    public function meeting10(Request $request, BuildGrammarWritingMeeting10ViewData $buildGrammarWritingMeeting10ViewData)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $displayMeetingNumber = $isFastTrack ? 6 : 10;

        return view('assignments.grammar-writing.meeting10', array_merge(
            $buildGrammarWritingMeeting10ViewData->handle(
                $this->data->meeting10Paragraph,
                $this->data->meeting10Examples,
            ),
            [
                'displayMeetingNumber' => $displayMeetingNumber,
                'backRoute' => $isFastTrack ? route('assignments.grammar-writing') : route('assignments.grammar-writing.classes'),
                'cheatSheet' => $isFastTrack 
                    ? app(\App\Http\Controllers\AssignmentController::class)->getFastTrackCheatSheet(6)
                    : app(GrammarWritingAdminController::class)->complexityMeetingCheatSheet(4),
            ]
        ));
    }

    public function meeting10Submit(
        Request $request,
        BuildGrammarWritingMeeting10ViewData $buildGrammarWritingMeeting10ViewData,
        EvaluateGrammarWritingMeeting10Submission $evaluateGrammarWritingMeeting10Submission,
    ) {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting6' : 'assignments.grammar-writing.meeting10';
        $meetingNum = $isFastTrack ? 6 : 10;

        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting10ViewData->loadQuestions();
        $paragraph = $buildGrammarWritingMeeting10ViewData->loadParagraph($this->data->meeting10Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting10Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            $meetingNum,
            $redirectRoute,
            $sessionPayload,
            'meeting10_final_score',
        );
    }

    public function meeting10Reset(Request $request)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting6' : 'assignments.grammar-writing.meeting10';

        return $this->resetGrammarWritingMeetingSession(
            $redirectRoute,
            [
            'meeting10_submitted',
            'meeting10_results',
            'meeting10_paragraph_result',
            'meeting10_final_score',
            'meeting10_user_answers',
            'meeting10_user_paragraph_answer'
            ],
        );
    }

    public function meeting11(BuildGrammarWritingMeeting11ViewData $buildGrammarWritingMeeting11ViewData)
    {
        return view('assignments.grammar-writing.meeting11', $buildGrammarWritingMeeting11ViewData->handle(
            $this->data->meeting11Questions,
            $this->data->meeting11Paragraph,
        ));
    }

    public function meeting11Submit(
        Request $request,
        BuildGrammarWritingMeeting11ViewData $buildGrammarWritingMeeting11ViewData,
        EvaluateGrammarWritingMeeting11Submission $evaluateGrammarWritingMeeting11Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting11ViewData->loadQuestions($this->data->meeting11Questions);
        $paragraph = $buildGrammarWritingMeeting11ViewData->loadParagraph($this->data->meeting11Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting11Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            11,
            'assignments.grammar-writing.meeting11',
            $sessionPayload,
            'meeting11_final_score',
        );
    }

    public function meeting11Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting11',
            [
            'meeting11_submitted',
            'meeting11_results',
            'meeting11_paragraph_result',
            'meeting11_final_score',
            'meeting11_user_answers',
            'meeting11_user_paragraph_answer'
            ],
        );
    }

    public function meeting12(Request $request, BuildGrammarWritingMeeting12ViewData $buildGrammarWritingMeeting12ViewData)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $displayMeetingNumber = $isFastTrack ? 7 : 12;

        return view('assignments.grammar-writing.meeting12', array_merge(
            $buildGrammarWritingMeeting12ViewData->handle(
                $this->data->meeting12Questions,
                $this->data->meeting12Paragraph,
            ),
            [
                'displayMeetingNumber' => $displayMeetingNumber,
                'backRoute' => $isFastTrack ? route('assignments.grammar-writing') : route('assignments.grammar-writing.classes'),
            ]
        ));
    }

    public function meeting12Submit(
        Request $request,
        BuildGrammarWritingMeeting12ViewData $buildGrammarWritingMeeting12ViewData,
        EvaluateGrammarWritingMeeting12Submission $evaluateGrammarWritingMeeting12Submission,
    ) {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting7' : 'assignments.grammar-writing.meeting12';
        $meetingNum = $isFastTrack ? 7 : 12;

        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting12ViewData->loadQuestions($this->data->meeting12Questions);
        $paragraph = $buildGrammarWritingMeeting12ViewData->loadParagraph($this->data->meeting12Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting12Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            $meetingNum,
            $redirectRoute,
            $sessionPayload,
            'meeting12_final_score',
        );
    }

    public function meeting12Reset(Request $request)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting7' : 'assignments.grammar-writing.meeting12';

        return $this->resetGrammarWritingMeetingSession(
            $redirectRoute,
            [
            'meeting12_submitted',
            'meeting12_results',
            'meeting12_paragraph_result',
            'meeting12_final_score',
            'meeting12_user_answers',
            'meeting12_user_paragraph_answer'
            ],
        );
    }

}
