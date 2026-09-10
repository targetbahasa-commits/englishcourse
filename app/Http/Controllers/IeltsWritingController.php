<?php

namespace App\Http\Controllers;

use App\Application\IeltsWriting\BuildIeltsWritingIndexData;
use App\Application\IeltsWriting\BuildIeltsWritingAiPrompt;
use App\Application\IeltsWriting\HandleIeltsWritingAiResponse;
use App\Application\IeltsWriting\HydrateIeltsWritingSupportData;
use App\Application\IeltsWriting\ResolveIeltsWritingNavigation;
use App\Application\IeltsWriting\ShowIeltsWritingMeeting;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\EvaluatesClassPeriodEnd;
use App\Http\Requests\IeltsWritingEssayRequest;
use App\Models\IeltsWritingPracticeSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IeltsWritingController extends Controller
{
    use HandlesAssignmentAccess;
    use EvaluatesClassPeriodEnd;

    public function __construct(
        private readonly BuildIeltsWritingIndexData $buildIeltsWritingIndexData,
        private readonly BuildIeltsWritingAiPrompt $buildIeltsWritingAiPrompt,
        private readonly HandleIeltsWritingAiResponse $handleIeltsWritingAiResponse,
        private readonly HydrateIeltsWritingSupportData $hydrateIeltsWritingSupportData,
        private readonly ResolveIeltsWritingNavigation $resolveIeltsWritingNavigation,
        private readonly ShowIeltsWritingMeeting $showIeltsWritingMeeting,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index(Request $request)
    {
        $payload = $this->buildIeltsWritingIndexData->handle(Auth::user(), $request->input('task'));

        $payload['data']['isClassEnded'] = Auth::user()?->isStudent() ? $this->isStudentClassPeriodEnded('ielts-academic') : false;

        return view($payload['view'], $payload['data']);
    }

    public function generalIndex(Request $request)
    {
        $payload = $this->buildIeltsWritingIndexData->handle(Auth::user(), $request->input('task'));

        $payload['data']['isClassEnded'] = Auth::user()?->isStudent() ? $this->isStudentClassPeriodEnded('ielts-general-full-package') : false;
        $payload['data']['isGeneral'] = true;

        if ((int) $request->input('task') === 1) {
            $letterType = $request->input('letter_type');
            $payload['data']['letterType'] = in_array($letterType, ['formal', 'informal'], true) ? $letterType : null;
            // General Task 1 letter-writing content has not been authored yet, so it must never
            // fall back to the shared Task 1 lesson pool (which is Academic report-writing content).
            $payload['data']['lessons'] = [];
        }

        if ($request->input('task')) {
            return view('assignments.ielts.writing.task_list', $payload['data']);
        }

        return view('assignments.ielts.writing.index', $payload['data']);
    }

    public function showMeeting(Request $request, int $task, int $id)
    {
        $isGeneral = $request->routeIs('assignments.ielts-general.*');
        $meeting = $this->showIeltsWritingMeeting->handle($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($meeting->is_locked && !$user->isAdmin() && !$user->isTeacher()) {
            // Practice meetings are accessible directly for enrolled students (no lock restriction)
            if (!in_array($meeting->category, ['practice', 'practice_item'], true)) {
                $indexRoute = $isGeneral ? 'assignments.ielts-general.writing.index' : 'assignments.ielts-academic.writing.index';

                return redirect()->route($indexRoute, ['task' => $task])
                    ->with('error', 'This lesson is currently locked.');
            }
        }

        $this->hydrateIeltsWritingSupportData->handle($meeting);

        $backUrl = $this->resolveIeltsWritingNavigation->determineBackUrl($task, $meeting, $isGeneral);

        $isClassEnded = Auth::user()?->isStudent() ? $this->isStudentClassPeriodEnded('ielts-academic') : false;

        if ($meeting->view_type === 'practice_selection') {
            $range = $this->resolveIeltsWritingNavigation->practiceSelectionRange($meeting->meeting_number);
            $practices = $this->showIeltsWritingMeeting->getPracticeItemsInRange($range[0], $range[1]);

            return view('assignments.ielts.writing.practice_selection', compact('task', 'meeting', 'practices', 'backUrl', 'isClassEnded'));
        }

        $view = $this->resolveIeltsWritingNavigation->resolveMeetingView($meeting->view_type);

        $userId = \Illuminate\Support\Facades\Auth::id() ?? session()->getId();
        $savedAnswers = \Illuminate\Support\Facades\Cache::get("ielts_writing_draft_{$userId}_{$meeting->id}")
            ?? \Illuminate\Support\Facades\Cache::get("ielts_writing_draft_{$userId}_{$id}")
            ?? session('ielts_writing_meeting' . $meeting->id . '_user_answers')
            ?? session('ielts_writing_meeting' . $id . '_user_answers', []);

        return view($view, compact('task', 'meeting', 'backUrl', 'isClassEnded', 'savedAnswers'));
    }

    /**
     * Live-draft sync for IELTS Writing practice pages (e.g. graphical_sentences)
     * that don't use a plain <form>/named-input layout. Stores the student's
     * in-progress answers in their session under a key ending in
     * "_user_answers" so the admin/teacher live-view snapshot resolver
     * (ManageStudents::extractAnswerFromSessionData) picks it up automatically.
     */
    public function saveMeetingDraft(Request $request, int $id): JsonResponse
    {
        $userAnswers = $request->input('userAnswers', []);
        if (!is_array($userAnswers)) {
            $userAnswers = [];
        }

        $meeting = \App\Models\IeltsWritingMeeting::find($id);
        if (!$meeting) {
            $meeting = \App\Models\IeltsWritingMeeting::where('meeting_number', $id)->first();
        }

        $dbMeetingId = $meeting ? $meeting->id : $id;
        $authId = \Illuminate\Support\Facades\Auth::id();
        $userId = $authId ?? session()->getId();

        \Illuminate\Support\Facades\Cache::put("ielts_writing_draft_{$userId}_{$dbMeetingId}", $userAnswers, 86400 * 30);
        \Illuminate\Support\Facades\Cache::put("ielts_writing_draft_{$userId}_{$id}", $userAnswers, 86400 * 30);

        session([
            'ielts_writing_meeting' . $dbMeetingId . '_user_answers' => $userAnswers,
            'ielts_writing_meeting' . $id . '_user_answers' => $userAnswers,
        ]);
        session()->save();

        // Also upsert a queryable snapshot for the admin/teacher "Sedang
        // Dikerjakan" report - only for real logged-in users (guests are
        // session-only above and have no users.id row to attach to).
        // task_type comes from the meeting itself, not client input, so it
        // can't be spoofed/desynced from what a submission would later use.
        $hasAnyFilledAnswer = collect($userAnswers)->flatten()->contains(function ($v) {
            return $v !== null && trim((string)$v) !== '';
        });

        if ($authId && $meeting && $meeting->task_type && $hasAnyFilledAnswer) {
            \App\Models\IeltsWritingDraft::updateOrCreate(
                ['user_id' => $authId, 'meeting_id' => $dbMeetingId, 'task_type' => $meeting->task_type],
                ['answers' => $userAnswers, 'last_saved_at' => now()]
            );
        }

        return response()->json(['ok' => true, 'saved_at' => now()->toIso8601String()]);
    }

    
    public function evaluationPreview($task, $id, $task_id = null)
    {
        $meeting = \App\Models\IeltsWritingMeeting::find($id);
        if (!$meeting) {
            $meeting = \App\Models\IeltsWritingMeeting::where('meeting_number', $id)->first();
        }

        $taskType = (int) ($task ?? ($meeting->task_type ?? 1));
        $title = $meeting ? $meeting->title : "IELTS Writing Practice";
        $prompt = $meeting ? strip_tags($meeting->prompt) : "Summarise the information by selecting and reporting the main features, and make comparisons where relevant.";

        // Try to load latest real submission for this test.
        // Note: free_test_submissions has no test_id/meeting-level column, so this
        // can only filter by test_type (writing_t1/writing_t2), not the specific
        // meeting id — it shows the most recent matching submission as a preview.
        $submission = \Illuminate\Support\Facades\DB::table('free_test_submissions')
            ->where('test_type', 'writing_t' . $taskType)
            ->latest('id')
            ->first();

        $aiFeedback = null;
        if ($submission && !empty($submission->ai_raw_json_feedback)) {
            $decoded = json_decode($submission->ai_raw_json_feedback, true);
            if (is_array($decoded) && isset($decoded['overall_band_score'])) {
                $aiFeedback = $decoded;
            }
        }

        if (!$aiFeedback) {
            $bandScore = 7.0;
            $tableHeaderHtml = '<table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2 font-bold text-gray-700">Kutipan Asli</th><th class="border border-gray-200 p-2 font-bold text-gray-700">Masalah</th><th class="border border-gray-200 p-2 font-bold text-gray-700">Penjelasan</th><th class="border border-gray-200 p-2 font-bold text-gray-700">Perbaikan</th></tr></thead><tbody>';

            if ($taskType === 1) {
                $taskFeedbackHtml = '<p class="mb-3">Kandidat telah menyajikan gambaran umum (overview) yang jelas dan melaporkan fitur-fitur utama grafik <strong>' . e($title) . '</strong> dengan akurat. Pemilihan data angka utama sudah tepat, namun perbandingan antar kategori dapat diperdalam lebih lanjut.</p>'
                    . $tableHeaderHtml
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">traffic increased steadily</td><td class="border border-gray-200 p-2">Variasi Kosakata Data</td><td class="border border-gray-200 p-2">Frasa pengulangan yang kurang bervariasi untuk laporan statistik.</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">experienced a steady upward trend</td></tr>'
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">the graph shows that</td><td class="border border-gray-200 p-2">Struktur Pendahuluan</td><td class="border border-gray-200 p-2">Dapat menggunakan kalimat parafase yang lebih akademis.</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">the line chart illustrates / provides data regarding</td></tr>'
                    . '</tbody></table>';

                $coherenceHtml = '<p class="mb-3">Pengelompokan paragraf logis. Urutan informasi mengalir dengan baik dari gambaran umum (overview) hingga paragraf detail spesifik.</p>'
                    . $tableHeaderHtml
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">And then numbers went up</td><td class="border border-gray-200 p-2">Perangkat Kohesi Informal</td><td class="border border-gray-200 p-2">Penggunaan kata hubung "and then" terkesan informal dalam konteks laporan IELTS Task 1.</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">Subsequently, the figures surged to...</td></tr>'
                    . '</tbody></table>';

                $lexicalHtml = '<p class="mb-3">Rentang kosakata akademis yang relevan dengan deskripsi tren dan grafik telah digunakan dengan fleksibilitas yang memadai.</p>'
                    . '<table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2 font-bold text-gray-700">Kosa Kata Asli</th><th class="border border-gray-200 p-2 font-bold text-gray-700">Kosa Kata yang Lebih Baik</th></tr></thead><tbody>'
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">big increase</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">substantial surge / significant growth</td></tr>'
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">go down</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">decline sharply / drop gradually</td></tr>'
                    . '</tbody></table>';

                $grammarHtml = '<p class="mb-3">Struktur kalimat bervariasi antara kalimat tunggal dan majemuk. Akurasi tata bahasa sudah baik dengan kesalahan minor yang tidak mengganggu keterbacaan.</p>'
                    . $tableHeaderHtml
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">traffic reach peak in 2015</td><td class="border border-gray-200 p-2">Ketidaktepatan Tenses Masa Lalu</td><td class="border border-gray-200 p-2">Data bertahun 2015 wajib menggunakan Simple Past Tense secara konsisten.</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">traffic reached its peak in 2015</td></tr>'
                    . '</tbody></table>';

                $band9Model = '<p class="leading-relaxed mb-4">The line chart illustrates data regarding <strong>' . e(strtolower($title)) . '</strong> over a ten-year period from 2010 to 2020.</p>'
                    . '<p class="leading-relaxed mb-4">Overall, it is immediately apparent that traffic experienced a substantial upward trend over the decade, despite minor fluctuations in the middle years. Additionally, the final quarter registered the highest level of activity throughout the timeframe.</p>'
                    . '<p class="leading-relaxed mb-4">In 2010, the volume stood at approximately 30 units before climbing steadily to reach 50 units by 2013. Following a brief period of stabilization around 60 units, the figures surged dramatically in 2018, eventually peaking at 85 units by the end of the survey period in 2020.</p>';

                $correctionHtml = '<p class="leading-relaxed text-gray-800">The line chart <ins style="background-color:#fef08a;color:#854d0e;padding:0 4px;border-radius:2px;font-weight:600;">illustrates data regarding</ins> <del style="background-color:#fee2e2;color:#dc2626;padding:0 2px;border-radius:2px;">shows about</del> ' . e(strtolower($title)) . ' over a decade. Overall, traffic <ins style="background-color:#fef08a;color:#854d0e;padding:0 4px;border-radius:2px;font-weight:600;">experienced a substantial upward trend</ins> <del style="background-color:#fee2e2;color:#dc2626;padding:0 2px;border-radius:2px;">went up a lot</del>, reaching a peak in 2020. The figures <ins style="background-color:#fef08a;color:#854d0e;padding:0 4px;border-radius:2px;font-weight:600;">reached their peak</ins> <del style="background-color:#fee2e2;color:#dc2626;padding:0 2px;border-radius:2px;">reach peak</del> at 85 units at the end of the period.</p>';
            } else {
                $taskFeedbackHtml = '<p class="mb-3">Esai telah menjawab seluruh bagian pertanyaan prompt <strong>' . e($title) . '</strong> dengan posisi yang jelas sepanjang tulisan. Ide-ide utama telah didukung oleh alasan dan contoh yang relevan.</p>'
                    . $tableHeaderHtml
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">This is good for people</td><td class="border border-gray-200 p-2">Pengembangan Argumen Terlalu Umum</td><td class="border border-gray-200 p-2">Pernyataan masih terlalu umum, butuh elaborasi manfaat spesifik.</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">This initiative yields considerable benefits for the local populace by...</td></tr>'
                    . '</tbody></table>';

                $coherenceHtml = '<p class="mb-3">Alur pemikiran antar paragraf mengalir logis. Paragraf pendahuluan, isi (body paragraphs), dan kesimpulan terstruktur dengan rapi.</p>'
                    . $tableHeaderHtml
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">Firstly... Secondly... Thirdly...</td><td class="border border-gray-200 p-2">Kohesi Mekanis Berlebihan</td><td class="border border-gray-200 p-2">Penggunaan transisi angka yang kaku dapat diganti dengan transisi kontekstual.</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">A primary argument supporting this view is... / Another compelling factor is...</td></tr>'
                    . '</tbody></table>';

                $lexicalHtml = '<p class="mb-3">Penggunaan kosa kata bervariasi dengan fleksibilitas dan presisi yang memadai sesuai topik esai Task 2.</p>'
                    . '<table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2 font-bold text-gray-700">Kosa Kata Asli</th><th class="border border-gray-200 p-2 font-bold text-gray-700">Kosa Kata yang Lebih Baik</th></tr></thead><tbody>'
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">good thing</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">positive development / favorable trend</td></tr>'
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">bad impact</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">detrimental consequence / adverse effect</td></tr>'
                    . '</tbody></table>';

                $grammarHtml = '<p class="mb-3">Penggunaan kalimat majemuk bertingkat (complex sentences) digunakan secara fleksibel dengan akurasi tata bahasa yang tinggi.</p>'
                    . $tableHeaderHtml
                    . '<tr><td class="border border-gray-200 p-2 text-red-600">If governments will support this</td><td class="border border-gray-200 p-2">Pengandaian Conditional Clause</td><td class="border border-gray-200 p-2">Klausul "if" pada First Conditional menggunakan Present Tense, bukan "will".</td><td class="border border-gray-200 p-2 text-green-700 font-semibold">If governments support this initiative, citizens will benefit...</td></tr>'
                    . '</tbody></table>';

                $band9Model = '<p class="leading-relaxed mb-4">It is frequently debated whether <strong>' . e(strtolower($title)) . '</strong> brings more benefits than drawbacks to contemporary society. In my view, while certain challenges are undeniable, the positive impacts ultimately outweigh the disadvantages.</p>'
                    . '<p class="leading-relaxed mb-4">To begin with, a major advantage of this development is its capacity to enhance efficiency and productivity. When individuals and institutions adopt modern methods, operational costs are minimized while output is maximized. Furthermore, empirical evidence demonstrates that societies embracing these innovations experience accelerated socioeconomic progress.</p>'
                    . '<p class="leading-relaxed mb-4">In conclusion, although potential drawbacks should be prudently managed, the advantages provided far outweigh the negative aspects, laying a solid foundation for sustainable growth.</p>';

                $correctionHtml = '<p class="leading-relaxed text-gray-800">It is widely acknowledged that <strong>' . e(strtolower($title)) . '</strong> plays a pivotal role in modern society. While some argue that it brings <ins style="background-color:#fef08a;color:#854d0e;padding:0 4px;border-radius:2px;font-weight:600;">adverse effects</ins> <del style="background-color:#fee2e2;color:#dc2626;padding:0 2px;border-radius:2px;">bad impact</del>, I firmly believe that the <ins style="background-color:#fef08a;color:#854d0e;padding:0 4px;border-radius:2px;font-weight:600;">positive developments</ins> <del style="background-color:#fee2e2;color:#dc2626;padding:0 2px;border-radius:2px;">good things</del> far outweigh the drawbacks. <ins style="background-color:#fef08a;color:#854d0e;padding:0 4px;border-radius:2px;font-weight:600;">If governments support</ins> <del style="background-color:#fee2e2;color:#dc2626;padding:0 2px;border-radius:2px;">If governments will support</del> this, long-term benefits will be achieved.</p>';
            }

            $aiFeedback = [
                'overall_band_score' => $bandScore,
                'task_achievement_score' => $bandScore,
                'task_response_score' => $bandScore,
                'coherence_cohesion_score' => 7.5,
                'lexical_resource_score' => 7.0,
                'grammatical_range_score' => 7.0,
                'overall_comment' => 'Penilaian evaluasi menunjukkan penguasaan IELTS Writing yang sangat baik (Band 7.0). Struktur penulisan tersusun sistematis dengan alur paragraf yang logis, pemilihan kosakata akademis yang relevan dengan topik ' . e($title) . ', serta variasi tata bahasa kompleks yang akurat.',
                'task_achievement' => $taskFeedbackHtml,
                'task_response' => $taskFeedbackHtml,
                'coherence_cohesion' => $coherenceHtml,
                'lexical_resource' => $lexicalHtml,
                'grammatical_range' => $grammarHtml,
                'band_9_version' => $band9Model,
                'correction_html' => $correctionHtml,
            ];
        }

        if (!$submission) {
            $submission = (object) [
                'id' => 'mock',
                'name' => 'Admin Preview',
                'email' => 'admin@example.com',
                'whatsapp' => '08123456789',
                'test_type' => $taskType == 1 ? 'writing_t1' : 'writing_t2',
                'test_id' => $id,
                'ai_raw_json_feedback' => json_encode($aiFeedback),
                'created_at' => now(),
            ];
        }

        $type = $taskType == 1 ? 'writing_t1' : 'writing_t2';

        return view('assignments.ielts.writing.evaluation_preview', compact('type', 'id', 'submission', 'aiFeedback', 'prompt', 'task'));
    }

    public function practiceIndex(Request $request)
    {
        $isGeneral = $request->routeIs('assignments.ielts-general.*');
        $task = $request->query('task');
        $type = $request->query('type');

        if ($isGeneral && (int) $task === 1 && !$type) {
            $items = collect();
            $task2Meetings = collect();
        } else {
            $data = $this->resolveIeltsWritingNavigation->buildPracticeIndexData($task, $type);
            $items = $data['items'];
            $task2Meetings = $data['task2Meetings'];
        }

        $isClassEnded = Auth::user()?->isStudent() ? $this->isStudentClassPeriodEnded($isGeneral ? 'ielts-general-full-package' : 'ielts-academic') : false;

        $user = Auth::user();
        $canManageAiGrading = $user && ($user->isAdmin() || $user->isTeacher());

        return view('assignments.ielts.writing.practice-index', compact('task', 'type', 'items', 'task2Meetings', 'isClassEnded', 'isGeneral', 'canManageAiGrading'));
    }

    /**
     * Admin/Teacher: toggle AI auto-grading on/off for one specific essay prompt
     * (card). When off, submissions for that prompt skip AI scoring and go
     * straight to the manual "coret-coret" teacher review queue instead.
     */
    public function toggleMeetingAi(Request $request, \App\Models\IeltsWritingMeeting $meeting)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $enabled = $request->boolean('enabled');
        $meeting->ai_grading_enabled = $enabled;
        $meeting->save();

        return response()->json([
            'status' => 'success',
            'ai_grading_enabled' => $meeting->ai_grading_enabled,
            'message' => $enabled
                ? 'Penilaian AI diaktifkan untuk soal ini.'
                : 'Penilaian AI dinonaktifkan untuk soal ini. Jawaban student akan masuk ke halaman coret-coret Pengajar.',
        ]);
    }

    public function grammarPractice()
    {
        $grammarController = app(\App\Http\Controllers\GrammarWritingAdminController::class);
        $level = 'all';
        $title = 'IELTS Grammar Practice';
        $desc = 'Latihan untuk ' . $title . ' sedang disiapkan.';
        $topics = \App\Models\GrammarTopic::orderBy('order')->get();
        
        $dbIntroTopics = \App\Models\GrammarIntroTopic::orderBy('order')->get();
        $introAvailable = $dbIntroTopics->isNotEmpty() ? $dbIntroTopics->pluck('topic') : collect($grammarController->introductoryMeetingCatalog())->pluck('topic');
        $complexityAvailable = collect($grammarController->complexityMeetingCatalog())->pluck('topic');
        $proficiencyAvailable = collect($grammarController->buildProficiencyTrackMeetings())->pluck('topic');
        
        $availableTopics = collect(['Mix'])->merge($introAvailable)->merge($complexityAvailable)->merge($proficiencyAvailable)->unique()->values();
        
        $introTopics = collect();
        
        return view('assignments.ielts.writing.grammar-practice', compact('title', 'desc', 'level', 'topics', 'availableTopics', 'introTopics'));
    }

    public function evaluate(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(1200);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        $aiSetting = \App\Models\Setting::where('key', 'ielts_writing_ai_evaluation_enabled')->value('value');
        $globalAiEnabled = $aiSetting === null || $aiSetting === '1';

        // Per-question override: a card's own AI toggle (set by admin/teacher on the
        // practice list) can turn AI off for that specific prompt even when the global
        // switch is on, but can't turn it back on if the global switch is off.
        $meetingAiEnabled = true;
        if ($meetingId) {
            $meetingAiEnabled = \App\Models\IeltsWritingMeeting::where('id', $meetingId)->value('ai_grading_enabled');
            $meetingAiEnabled = $meetingAiEnabled === null ? true : (bool) $meetingAiEnabled;
        }

        $aiEnabled = $globalAiEnabled && $meetingAiEnabled;

        if (!$aiEnabled) {
            $user = Auth::user();
            $submission = IeltsWritingPracticeSubmission::create([
                'user_id' => Auth::id(),
                'meeting_id' => $meetingId,
                'task_type' => (int) $taskType,
                'essay' => $essay,
                'scores' => null,
                'evaluation_status' => 'pending_teacher',
                'attempts' => 1,
            ]);

            $this->notifyTeacherAndAdmins($submission);

            $showRoute = ($user && ($user->isAdmin() || $user->isTeacher()))
                ? route('admin.writing-practice-submissions.show', $submission->id)
                : route('assignments.ielts-academic.writing.submission.show', $submission->id);

            return response()->json([
                'status' => 'pending_teacher',
                'ai_enabled' => false,
                'submission_id' => $submission->id,
                'redirect_url' => $showRoute,
                'message' => 'Fitur penilaian AI sedang dinonaktifkan untuk soal ini. Jawaban Anda telah tersimpan dan akan diperiksa & dicoret-coret langsung oleh Pengajar.'
            ]);
        }

        $response = $this->handleIeltsWritingAiResponse->respondWithGradingPrompt(
            $this->buildIeltsWritingAiPrompt->grading($essay, $taskType, $meetingId),
            $essay,
            $taskType,
            90,
            4096,
            'evaluate',
            $meetingId
        );

        return $this->recordEvaluationSubmission(null, $essay, $taskType, $meetingId, $response);
    }

    /**
     * Re-run Task 1/2 AI scoring for a previously saved submission whose grading
     * failed (or is being re-checked), so a student can retry without still having
     * the essay in their browser, and an admin/teacher can retry on their behalf.
     */
    public function retryEvaluate(IeltsWritingPracticeSubmission $submission)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isOwner = $user->isStudent() && (int) $submission->user_id === (int) $user->id;

        if (!$user->isAdmin() && !$user->isTeacher() && !$isOwner) {
            abort(403);
        }

        $this->configureExecutionLimit(1200);
        $taskType = (string) $submission->task_type;

        $response = $this->handleIeltsWritingAiResponse->respondWithGradingPrompt(
            $this->buildIeltsWritingAiPrompt->grading($submission->essay, $taskType, $submission->meeting_id),
            $submission->essay,
            $taskType,
            90,
            4096,
            'evaluate-retry',
            $submission->meeting_id
        );

        return $this->recordEvaluationSubmission($submission, $submission->essay, $taskType, $submission->meeting_id, $response);
    }

    /**
     * Display the writing submission results page for student, teacher, or admin.
     */
    public function showSubmission(IeltsWritingPracticeSubmission $submission)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isOwner = $user && (int) $submission->user_id === (int) $user->id;

        if (!$user || (!$user->isAdmin() && !$user->isTeacher() && !$isOwner)) {
            abort(403);
        }

        $submission->load(['user', 'meeting', 'reviewer']);

        return view('assignments.ielts.writing.submission_result', compact('submission'));
    }

    /**
     * Save/update full feedback details (e.g. feedback, correction_html, better_version) into scores array.
     */
    public function saveFullFeedback(Request $request, IeltsWritingPracticeSubmission $submission)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isOwner = $user && (int) $submission->user_id === (int) $user->id;

        if (!$user || (!$user->isAdmin() && !$user->isTeacher() && !$isOwner)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->json()->all();
        $currentScores = $submission->scores ?? [];

        if (isset($data['feedback'])) {
            $currentScores['feedback'] = $data['feedback'];
        }
        if (isset($data['correction_html'])) {
            $currentScores['correction_html'] = $data['correction_html'];
        }
        if (isset($data['better_version'])) {
            $currentScores['better_version'] = $data['better_version'];
        }
        if (isset($data['scores'])) {
            $currentScores = array_merge($currentScores, $data['scores']);
        }

        $submission->update([
            'scores' => $currentScores,
            'evaluation_status' => 'success',
        ]);

        return response()->json(['status' => 'success', 'submission_id' => $submission->id]);
    }

    /**
     * Persists the essay + grading outcome (success or failure) so it survives past
     * the current browser session, and injects submission_id into the response so
     * the frontend can offer a retry without the student needing to resubmit the text.
     */
    private function recordEvaluationSubmission(
        ?IeltsWritingPracticeSubmission $existing,
        string $essay,
        string $taskType,
        ?int $meetingId,
        JsonResponse $response
    ): JsonResponse {
        $data = $response->getData(true) ?? [];
        $isSuccess = ($data['status'] ?? null) === 'success';

        $attributes = [
            'meeting_id' => $meetingId,
            'task_type' => (int) $taskType,
            'essay' => $essay,
            'scores' => $isSuccess ? ($data['scores'] ?? null) : null,
            'evaluation_status' => $isSuccess ? 'success' : 'failed',
            'error_message' => $isSuccess ? null : ($data['error'] ?? 'Unknown error'),
        ];

        if ($existing) {
            // Retry: keep the submission tied to the original student's profile even
            // when an admin/teacher is the one triggering the retry - never overwrite
            // user_id with whoever happens to be clicking "Kirim Ulang".
            $attributes['attempts'] = $existing->attempts + 1;
            $existing->update($attributes);
            $submission = $existing->fresh();
        } else {
            $attributes['user_id'] = Auth::id();
            $attributes['attempts'] = 1;
            $submission = IeltsWritingPracticeSubmission::create($attributes);
            $this->notifyTeacherAndAdmins($submission);
        }

        $data['submission_id'] = $submission->id;

        return response()->json($data, $response->getStatusCode());
    }

    /**
     * Send notification to responsible teacher & admins when a student submits writing.
     */
    private function notifyTeacherAndAdmins(IeltsWritingPracticeSubmission $submission): void
    {
        try {
            $student = $submission->user ?? Auth::user();
            if (!$student) {
                return;
            }

            $recipients = collect();

            // 1. Teacher assigned to student's class period / batch
            if (!empty($student->class_period_id)) {
                $classPeriod = \App\Models\ClassPeriod::with('teacher')->find($student->class_period_id);
                if ($classPeriod && $classPeriod->teacher) {
                    $recipients->push($classPeriod->teacher);
                }
            }

            // 2. All Admin & Superadmin users
            $admins = \App\Models\User::whereIn('role', ['admin', 'superadmin'])->get();
            foreach ($admins as $admin) {
                $recipients->push($admin);
            }

            $recipients = $recipients->unique('id');
            $notification = new \App\Notifications\StudentWritingSubmittedNotification($submission);

            foreach ($recipients as $recipient) {
                if ((int)$recipient->id !== (int)$student->id) {
                    $recipient->notify($notification);
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Writing submission notification error: ' . $e->getMessage());
        }
    }

    public function feedback(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(900);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        return $this->handleIeltsWritingAiResponse->respondWithFeedbackPrompt(
            $this->buildIeltsWritingAiPrompt->feedback($essay, $taskType, $meetingId),
            90,
            4096,
            $taskType,
            'feedback',
            $meetingId
        );
    }

    public function correct(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(1200);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        return $this->handleIeltsWritingAiResponse->respondWithCorrectionPrompt(
            $this->buildIeltsWritingAiPrompt->correction($essay, $taskType),
            $essay,
            90,
            4096,
            $taskType,
            'correct',
            $meetingId
        );
    }

    public function vocabulary(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(900);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->vocabulary($essay, $taskType),
            90,
            4096,
            false,
            true,
            null,
            'AI Response Error',
            $taskType,
            'vocabulary',
            $meetingId
        );
    }

    public function coherence(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(900);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->coherence($essay, $taskType),
            90,
            4096,
            false,
            true,
            null,
            'AI Response Error',
            $taskType,
            'coherence',
            $meetingId
        );
    }

    public function taskResponse(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(900);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->taskResponse($essay, $taskType),
            90,
            4096,
            false,
            true,
            'Task Response',
            'AI Response Error',
            $taskType,
            'task_achievement',
            $meetingId
        );
    }

    public function grammar(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(900);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->grammar($essay, $taskType),
            90,
            4096,
            false,
            true,
            null,
            'AI Response Error',
            $taskType,
            'grammar',
            $meetingId
        );
    }

    public function improve(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(900, false);
        $essay = $request->essay();
        $taskType = $request->taskType();
        $meetingId = $request->meetingId();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->improve($essay, $taskType),
            90,
            4096,
            true,
            false,
            'IELTS Improvement',
            'AI Response Error: ' . json_last_error_msg(),
            $taskType,
            'improve',
            $meetingId
        );
    }

    private function configureExecutionLimit(int $seconds, bool $updateIni = true): void
    {
        if ($updateIni) {
            ini_set('max_execution_time', (string) $seconds);
        }

        set_time_limit($seconds);
    }

}