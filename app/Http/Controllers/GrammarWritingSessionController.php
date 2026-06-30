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

        return $this->completeConditionalGrammarWritingMeetingSubmission(
            2,
            'assignments.grammar-writing.meeting2',
            $evaluation['session'] ?? [],
            !empty($evaluation['saveScore']) ? $evaluation['totalScore'] : null,
        );
    }

    public function meeting2Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting2',
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
            1 => ['example' => ['id' => 'Seluruh dokumen telah diverifikasi oleh tim audit internal.', 'en' => 'All documents have been verified by the internal audit team.'], 'vocab' => ['verified' => ['id' => 'terverifikasi', 'pos' => '(v3)'], 'strict process' => ['id' => 'proses ketat', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Para peneliti sedang memetakan area pesisir secara detail.', 'en' => 'Researchers are mapping the coastal area in detail.'], 'vocab' => ['mapping' => ['id' => 'pemetaan', 'pos' => '(n)'], 'coastal area' => ['id' => 'wilayah pesisir', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Karakteristik geologis daerah ini sangat berbeda.', 'en' => 'The geological characteristics of this region are very different.'], 'vocab' => ['geomorphology' => ['id' => 'geomorfologi', 'pos' => '(n)'], 'mountainous' => ['id' => 'pegunungan', 'pos' => '(adj)']]],
            4 => ['example' => ['id' => 'Peradaban kuno membangun kanal irigasi di area kering.', 'en' => 'Ancient civilizations built irrigation canals in arid areas.'], 'vocab' => ['civilization' => ['id' => 'peradaban', 'pos' => '(n)'], 'arid' => ['id' => 'gersang', 'pos' => '(adj)']]],
            5 => ['example' => ['id' => 'Setiap komponen sistem harus berada dalam keseimbangan.', 'en' => 'Each system component must remain in balance.'], 'vocab' => ['element' => ['id' => 'elemen', 'pos' => '(n)'], 'balanced' => ['id' => 'seimbang', 'pos' => '(adj)']]],
            6 => ['example' => ['id' => 'Strategi mitigasi sedang ditinjau oleh lembaga terkait.', 'en' => 'The mitigation strategy is being reviewed by the relevant institution.'], 'vocab' => ['mitigation' => ['id' => 'mitigasi', 'pos' => '(n)'], 'reviewed' => ['id' => 'ditinjau', 'pos' => '(v3)']]],
            7 => ['example' => ['id' => 'Ilmuwan itu menjadi tokoh penting dalam fisika modern.', 'en' => 'That scientist became a key figure in modern physics.'], 'vocab' => ['scientist' => ['id' => 'ilmuwan', 'pos' => '(n)'], 'central figure' => ['id' => 'figur sentral', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Fotosintesis mengubah energi cahaya menjadi energi kimia.', 'en' => 'Photosynthesis converts light energy into chemical energy.'], 'vocab' => ['photosynthesis' => ['id' => 'fotosintesis', 'pos' => '(n)'], 'converts' => ['id' => 'mengonversi', 'pos' => '(v1)']]],
            9 => ['example' => ['id' => 'Struktur administrasi pada era itu tidak terlalu kaku.', 'en' => 'The administrative structure in that era was not too rigid.'], 'vocab' => ['bureaucratic structure' => ['id' => 'struktur birokrasi', 'pos' => '(n)'], 'rigid' => ['id' => 'kaku', 'pos' => '(adj)']]],
            10 => ['example' => ['id' => 'Naskah bersejarah dikirim ke museum untuk digitalisasi.', 'en' => 'The historical manuscript was sent to the museum for digitization.'], 'vocab' => ['manuscript' => ['id' => 'naskah', 'pos' => '(n)'], 'digital preservation' => ['id' => 'preservasi digital', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Analisis spektrum membantu menentukan unsur bintang.', 'en' => 'Spectrum analysis helps determine stellar elements.'], 'vocab' => ['spectrum analysis' => ['id' => 'analisis spektrum', 'pos' => '(n)'], 'composition' => ['id' => 'komposisi', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Arsitek membangun fondasi antigempa untuk gedung utama.', 'en' => 'Architects built an earthquake-resistant foundation for the main building.'], 'vocab' => ['foundation' => ['id' => 'fondasi', 'pos' => '(n)'], 'earthquake-resistant' => ['id' => 'tahan guncangan', 'pos' => '(adj)']]],
            13 => ['example' => ['id' => 'Atmosfer planet itu berada dalam fase transisi ekstrem.', 'en' => 'That planet atmosphere is in an extreme transition phase.'], 'vocab' => ['atmosphere' => ['id' => 'atmosfer', 'pos' => '(n)'], 'transition phase' => ['id' => 'tahap transisi', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Kebijakan dekarbonisasi wajib diterapkan oleh setiap negara.', 'en' => 'Decarbonization policies must be implemented by every country.'], 'vocab' => ['decarbonization' => ['id' => 'dekarbonisasi', 'pos' => '(n)'], 'implemented' => ['id' => 'diimplementasikan', 'pos' => '(v3)']]],
            15 => ['example' => ['id' => 'Tim arkeolog menemukan permukiman neolitikum saat ekskavasi.', 'en' => 'The archaeologist team discovered a Neolithic settlement during excavation.'], 'vocab' => ['archaeologist' => ['id' => 'arkeolog', 'pos' => '(n)'], 'excavation' => ['id' => 'ekskavasi', 'pos' => '(n)']]],
        ];
        
        return view('assignments.grammar-writing-complexity-meeting', [
            'meetingNumber' => 2,
            'topic' => 'Latihan penerapan tenses',
            'trackTitle' => 'Fast-track Grammar for Writing',
            'questions' => $questions,
            'questionHelpers' => $questionHelpers,
        ]);
    }

    public function meeting2PracticeSubmit(Request $request)
    {
        // For now just redirect back since the complexity track doesn't actually process this form yet either
        return redirect()->route('assignments.grammar-writing.meeting2')->with('success', 'Jawaban berhasil disimpan.');
    }

    public function meeting2PracticeReset()
    {
        return redirect()->route('assignments.grammar-writing.meeting2');
    }


    public function meeting5(BuildGrammarWritingMeeting5ViewData $buildGrammarWritingMeeting5ViewData)
    {
        return view('assignments.grammar-writing.meeting5', $buildGrammarWritingMeeting5ViewData->handle());
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

    public function meeting10(BuildGrammarWritingMeeting10ViewData $buildGrammarWritingMeeting10ViewData)
    {
        return view('assignments.grammar-writing.meeting10', $buildGrammarWritingMeeting10ViewData->handle(
            $this->data->meeting10Paragraph,
            $this->data->meeting10Examples,
        ));
    }

    public function meeting10Submit(
        Request $request,
        BuildGrammarWritingMeeting10ViewData $buildGrammarWritingMeeting10ViewData,
        EvaluateGrammarWritingMeeting10Submission $evaluateGrammarWritingMeeting10Submission,
    ) {
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
            10,
            'assignments.grammar-writing.meeting10',
            $sessionPayload,
            'meeting10_final_score',
        );
    }

    public function meeting10Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting10',
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

    public function meeting12(BuildGrammarWritingMeeting12ViewData $buildGrammarWritingMeeting12ViewData)
    {
        return view('assignments.grammar-writing.meeting12', $buildGrammarWritingMeeting12ViewData->handle(
            $this->data->meeting12Questions,
            $this->data->meeting12Paragraph,
        ));
    }

    public function meeting12Submit(
        Request $request,
        BuildGrammarWritingMeeting12ViewData $buildGrammarWritingMeeting12ViewData,
        EvaluateGrammarWritingMeeting12Submission $evaluateGrammarWritingMeeting12Submission,
    ) {
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
            12,
            'assignments.grammar-writing.meeting12',
            $sessionPayload,
            'meeting12_final_score',
        );
    }

    public function meeting12Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting12',
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
