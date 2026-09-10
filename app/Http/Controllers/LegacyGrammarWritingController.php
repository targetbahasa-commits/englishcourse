<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\BuildGrammarWritingMeeting1ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting3ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting4ViewData;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting1Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting3Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting4Submission;
use App\Application\GrammarWriting\GrammarWritingDataRepository;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\HandlesGrammarWritingSessions;
use App\Http\Controllers\Concerns\HandlesLegacyGrammarWritingData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LegacyGrammarWritingController extends Controller
{

    /**
     * LegacyGrammarWritingController
     *
     * Handles legacy grammar-writing meetings (1, 3, 4) and fallback data.
     * Uses legacy data trait for compatibility with old meeting flows.
     */
    use HandlesAssignmentAccess;
    use HandlesGrammarWritingSessions;
    use HandlesLegacyGrammarWritingData;

    public function __construct(private GrammarWritingDataRepository $data)
    {
        $this->registerAssignmentAccessMiddleware();
    }

    public function meeting1(BuildGrammarWritingMeeting1ViewData $buildGrammarWritingMeeting1ViewData)
    {
        return view('assignments.grammar-writing.meeting1', $buildGrammarWritingMeeting1ViewData->handle(
            $this->grammarQuestionsHasSectionColumn(),
            $this->meeting1Paragraph,
            $this->meeting1FallbackQuestions,
            $this->meeting1FallbackVocab,
        ));
    }

    public function meeting1Submit(
        Request $request,
        BuildGrammarWritingMeeting1ViewData $buildGrammarWritingMeeting1ViewData,
        EvaluateGrammarWritingMeeting1Submission $evaluateGrammarWritingMeeting1Submission,
    ) {
        $hasSectionColumn = $this->grammarQuestionsHasSectionColumn();
        $questions = $buildGrammarWritingMeeting1ViewData->loadQuestionModels(
            $hasSectionColumn,
            $this->meeting1FallbackQuestions,
        );

        $paragraphReference = $buildGrammarWritingMeeting1ViewData->resolveParagraphData(
            $hasSectionColumn,
            $this->meeting1Paragraph,
        );
        $evaluation = $evaluateGrammarWritingMeeting1Submission->handle(
            $questions,
            $request->all(),
            $paragraphReference,
        );

        $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? auth()->user()?->program_id;
        $submissionData = [
            'results' => $evaluation['results'],
            'paragraphResult' => $evaluation['paragraphResult'],
            'user_answers' => $request->except(['_token']),
        ];

        $this->saveMeetingScore(1, $evaluation['finalScore'], $programId, [
            'answers' => $submissionData,
            'answers_data' => $submissionData,
        ]);

        if (auth()->check() && $programId) {
            try {
                \App\Models\AssignmentDraft::updateOrCreate(
                    ['user_id' => auth()->id(), 'program_id' => $programId, 'meeting_number' => 1],
                    ['answers' => $request->except(['_token']), 'last_saved_at' => now()]
                );
            } catch (\Throwable $e) {}
        }

        return view('assignments.grammar-writing.meeting1', $buildGrammarWritingMeeting1ViewData->composeViewData(
            $questions,
            $paragraphReference,
            $this->meeting1FallbackVocab,
            [
            'submitted' => true,
            'score' => $evaluation['finalScore'],
            'results' => $evaluation['results'],
            'paragraphResult' => $evaluation['paragraphResult']
            ],
        ));
    }

    public function meeting1Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting1',
            [
            'meeting1_submitted',
            'meeting1_results',
            'meeting1_paragraph_result',
            'meeting1_final_score',
            'meeting1_user_answers',
            'meeting1_user_paragraph_answer'
            ],
        );
    }

    public function meeting3(BuildGrammarWritingMeeting3ViewData $buildGrammarWritingMeeting3ViewData)
    {
        return view('assignments.grammar-writing.meeting3', $buildGrammarWritingMeeting3ViewData->handle(
            $this->meeting4Questions,
            $this->meeting4Paragraph,
            $this->grammarQuestionsHasSectionColumn(),
        ));
    }

    public function meeting3Submit(
        Request $request,
        BuildGrammarWritingMeeting3ViewData $buildGrammarWritingMeeting3ViewData,
        EvaluateGrammarWritingMeeting3Submission $evaluateGrammarWritingMeeting3Submission,
    ) {
        $userAnswers = (array) ($request->input('userAnswers') ?? []);
        $userParagraphAnswer = (string) ($request->input('userParagraphAnswer') ?? '');
        $hasSectionColumn = $this->grammarQuestionsHasSectionColumn();
        $questions = $buildGrammarWritingMeeting3ViewData->loadQuestionModels(
            $this->meeting4Questions,
            $hasSectionColumn,
        );
        $filledTranslations = 0;

        foreach ($questions as $question) {
            $questionNumber = (int) ($question->question_number ?? 0);
            if ($questionNumber <= 0) {
                continue;
            }

            $rawAnswer = $userAnswers[$questionNumber] ?? '';
            $translation = is_array($rawAnswer)
                ? trim((string) ($rawAnswer['trans'] ?? ''))
                : trim((string) $rawAnswer);
            if ($translation !== '') {
                $filledTranslations++;
            }
        }

        // Cek Jawaban no longer requires finishing every question first -
        // students can check whatever they've done so far; the evaluator
        // excludes unanswered questions from scoring entirely rather than
        // marking them wrong (see EvaluateGrammarWritingMeeting3Submission).
        // Still block a completely empty submission - nothing to check.
        if ($filledTranslations === 0 && trim($userParagraphAnswer) === '') {
            return back()
                ->withInput()
                ->withErrors([
                    'userAnswers' => 'Isi minimal satu jawaban (soal translate atau paragraf) sebelum mengecek jawaban.',
                ]);
        }

        $paragraphRecord = $buildGrammarWritingMeeting3ViewData->resolveParagraphRecord($hasSectionColumn);

        $sessionPayload = $evaluateGrammarWritingMeeting3Submission->handle(
            $questions,
            $userParagraphAnswer,
            $userAnswers,
            $paragraphRecord?->correct_answer ?? $this->meeting4Paragraph['en'],
        );

        return $this->completeGrammarWritingMeetingSubmission(
            3,
            'assignments.grammar-writing.meeting3',
            $sessionPayload,
            'meeting3_final_score',
        );
    }

    /**
     * GET /assignments/grammar-writing/fast-track/meeting3/materi/pdf
     *
     * The material (SEOM chart) is static content, identical for every
     * student - the PDF view is a hand-written dompdf-safe transcription
     * rather than reusing meeting3.blade.php's own Tailwind grid/flex
     * markup, since dompdf's CSS support doesn't reliably handle those
     * (see the whiteboard-export PDF's box-model quirks).
     */
    public function meeting3MaterialPdf()
    {
        $pdf = Pdf::loadView('pdf.grammar-writing-fast-track-meeting3-materi')
            ->setPaper('a4', 'portrait');

        return $pdf->download('Materi-Fast-Track-Meeting3-Modals.pdf');
    }

    /**
     * GET /assignments/grammar-writing/fast-track/meeting3/hasil/pdf
     *
     * Reuses the exact same view-data builder as the meeting3() page render,
     * so the PDF always reflects whatever the student currently sees on
     * screen (session-backed, falling back to the latest MeetingScore row -
     * same resolution BuildGrammarWritingMeeting3ViewData already does).
     */
    public function meeting3ResultPdf(BuildGrammarWritingMeeting3ViewData $buildGrammarWritingMeeting3ViewData)
    {
        $viewData = $buildGrammarWritingMeeting3ViewData->handle(
            $this->meeting4Questions,
            $this->meeting4Paragraph,
            $this->grammarQuestionsHasSectionColumn(),
        );

        if (empty($viewData['submitted'])) {
            return back()->withErrors([
                'userAnswers' => 'Belum ada jawaban yang dicek - klik "Cek Jawaban" dahulu sebelum mengunduh hasil penilaian.',
            ]);
        }

        $user = auth()->user();
        $cleanStudent = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '-', $user->name ?? 'Siswa'));

        $pdf = Pdf::loadView('pdf.grammar-writing-fast-track-meeting3-hasil', array_merge($viewData, [
            'studentName' => $user->name ?? 'Siswa',
            'studentEmail' => $user->email ?? '-',
        ]))->setPaper('a4', 'portrait');

        return $pdf->download("Hasil-Penilaian-Fast-Track-Meeting3-{$cleanStudent}.pdf");
    }

    public function meeting3Reset()
    {
        // Student can only reset if form was previously submitted
        $isAdminOrTeacher = auth()->user() && (auth()->user()->isAdmin() || auth()->user()->role === 'teacher');
        $wasFormSubmitted = session()->has('meeting3_submitted');
        
        if (!$isAdminOrTeacher && !$wasFormSubmitted) {
            abort(403, 'Unauthorized: Only students with submitted forms can reset.');
        }

        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting3',
            [
            'meeting3_submitted',
            'meeting3_results',
            'meeting3_paragraph_result',
            'meeting3_final_score',
            'meeting3_user_answers',
            'meeting3_user_paragraph_answer'
            ],
        );
    }

    /**
     * Reset only admin/teacher grading and notes, leaving student answers intact
     */
    public function meeting3AdminReset()
    {
        // Only admin/teacher can reset their own grading
        $isAdminOrTeacher = auth()->user() && (auth()->user()->isAdmin() || auth()->user()->role === 'teacher');
        
        if (!$isAdminOrTeacher) {
            abort(403, 'Unauthorized: Only admin and teacher can reset their grading.');
        }

        // Clear only admin/teacher-specific session keys, NOT student answers
        session()->forget([
            'meeting3_admin_grading',
            'meeting3_admin_notes',
            'meeting3_admin_score',
        ]);

        return redirect()->route('assignments.grammar-writing.meeting3')->with('success', 'Reset grading Anda berhasil.');
    }

    public function meeting3Draft(Request $request)
    {
        return $this->meetingDraft($request, 3);
    }

    /**
     * Server-side fallback for restoring in-progress answers when the
     * browser's own localStorage copy is empty or incomplete (new device,
     * cleared browser data, storage eviction, etc). Without this, the page
     * only ever restores from localStorage, so answers that were already
     * synced to the server (AssignmentDraft) via meetingDraft() appear to
     * have vanished even though they're safe - and worse, the next
     * localStorage-only auto-sync would overwrite the good server copy
     * with the impoverished local state.
     */
    public function meetingDraftShow(int $meeting)
    {
        if ($meeting < 1 || $meeting > 20) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid meeting number.',
            ], 422);
        }

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['ok' => false, 'answers' => [], 'paragraph_answer' => null]);
        }

        $cachedAnswers = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting' . $meeting . '_user_answers');
        $cachedParagraph = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting' . $meeting . '_user_paragraph_answer');
        $cachedSavedAt = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting' . $meeting . '_user_answers_saved_at');

        $answers = is_array($cachedAnswers) ? $cachedAnswers : (session('meeting' . $meeting . '_user_answers') ?? []);
        $paragraphAnswer = is_string($cachedParagraph) && $cachedParagraph !== ''
            ? $cachedParagraph
            : (session('meeting' . $meeting . '_user_paragraph_answer') ?? null);
        // Lets the client (meeting3.blade.php's restoreAnswers()) tell whether
        // this server copy or its own localStorage copy is actually newer,
        // instead of unconditionally letting localStorage win regardless of
        // staleness - only set when $answers genuinely came from the cache
        // write below, since that's the only source with a paired timestamp.
        $savedAt = is_array($cachedAnswers) ? $cachedSavedAt : null;

        try {
            $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id');
            $draft = $programId
                ? \App\Models\AssignmentDraft::where('user_id', $userId)
                    ->where('program_id', $programId)
                    ->where('meeting_number', $meeting)
                    ->first()
                : null;

            if ($draft && is_array($draft->answers)) {
                $dbAnswers = $draft->answers;
                $dbParagraph = $dbAnswers['paragraph_answer'] ?? null;
                unset($dbAnswers['paragraph_answer']);
                if (empty($answers)) {
                    $answers = $dbAnswers;
                    $savedAt = optional($draft->last_saved_at)->toIso8601String();
                }
                if ($paragraphAnswer === null && $dbParagraph !== null) {
                    $paragraphAnswer = $dbParagraph;
                }
            }
        } catch (\Throwable $e) {
            // Ignore DB error if table not ready
        }

        return response()->json([
            'ok' => true,
            'answers' => $answers,
            'paragraph_answer' => $paragraphAnswer,
            'saved_at' => $savedAt,
        ]);
    }

    public function meetingDraft(Request $request, int $meeting)
    {
        if ($meeting < 1 || $meeting > 20) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid meeting number.',
            ], 422);
        }

        $userAnswers = $request->input('userAnswers', []);
        if (!is_array($userAnswers) || $userAnswers === []) {
            $rawPayload = $request->except(['_token', 'userParagraphAnswer']);
            $userAnswers = is_array($rawPayload) ? $rawPayload : [];
        }

        $userParagraphAnswer = (string) ($request->input('userParagraphAnswer', '') ?? '');

        session([
            'meeting' . $meeting . '_user_answers' => $userAnswers,
            'meeting' . $meeting . '_user_paragraph_answer' => $userParagraphAnswer,
        ]);

        // Persist immediately so admin snapshot polling can read latest draft data.
        // We also use Cache to prevent session race conditions caused by concurrent live-drawing polling.
        $userId = auth()->id() ?? 0;
        if ($userId) {
            try {
                $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? auth()->user()?->program_id;
                $mergedAnswers = $userAnswers;

                if ($programId) {
                    $existingDraft = \App\Models\AssignmentDraft::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->first();

                    if ($existingDraft && is_array($existingDraft->answers)) {
                        foreach ($existingDraft->answers as $k => $oldVal) {
                            if ($k === 'paragraph_answer') {
                                if ($userParagraphAnswer === '' && is_string($oldVal) && trim($oldVal) !== '') {
                                    $userParagraphAnswer = $oldVal;
                                }
                                continue;
                            }

                            $isNewEmpty = !isset($mergedAnswers[$k])
                                || (is_string($mergedAnswers[$k]) && trim($mergedAnswers[$k]) === '')
                                || (is_array($mergedAnswers[$k]) && !collect($mergedAnswers[$k])->contains(fn($v) => trim((string)$v) !== ''));

                            if ($isNewEmpty) {
                                if (is_string($oldVal) && trim($oldVal) !== '') {
                                    $mergedAnswers[$k] = $oldVal;
                                } elseif (is_array($oldVal) && collect($oldVal)->contains(fn($v) => trim((string)$v) !== '')) {
                                    if (!isset($mergedAnswers[$k]) || !is_array($mergedAnswers[$k])) {
                                        $mergedAnswers[$k] = $oldVal;
                                    } else {
                                        foreach ($oldVal as $subK => $subV) {
                                            if ((!isset($mergedAnswers[$k][$subK]) || trim((string)$mergedAnswers[$k][$subK]) === '') && trim((string)$subV) !== '') {
                                                $mergedAnswers[$k][$subK] = $subV;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $hasAnyFilledAnswer = (trim($userParagraphAnswer) !== '') || collect($mergedAnswers)->flatten()->contains(function ($v) {
                        return $v !== null && trim((string)$v) !== '';
                    });

                    if ($hasAnyFilledAnswer) {
                        \App\Models\AssignmentDraft::updateOrCreate(
                            ['user_id' => $userId, 'program_id' => $programId, 'meeting_number' => $meeting],
                            ['answers' => $mergedAnswers + ($userParagraphAnswer !== '' ? ['paragraph_answer' => $userParagraphAnswer] : []), 'last_saved_at' => now()]
                        );
                    }
                }

                \Illuminate\Support\Facades\Cache::put('user_' . $userId . '_meeting' . $meeting . '_user_answers', $mergedAnswers, now()->addHours(24));
                \Illuminate\Support\Facades\Cache::put('user_' . $userId . '_meeting' . $meeting . '_user_paragraph_answer', $userParagraphAnswer, now()->addHours(24));
                \Illuminate\Support\Facades\Cache::put('user_' . $userId . '_meeting' . $meeting . '_user_answers_saved_at', now()->toIso8601String(), now()->addHours(24));
                if ($meeting === 6) {
                    \Illuminate\Support\Facades\Cache::put('user_' . $userId . '_meeting10_user_answers', $mergedAnswers, now()->addHours(24));
                    \Illuminate\Support\Facades\Cache::put('user_' . $userId . '_meeting10_user_paragraph_answer', $userParagraphAnswer, now()->addHours(24));
                } elseif ($meeting === 10) {
                    \Illuminate\Support\Facades\Cache::put('user_' . $userId . '_meeting6_user_answers', $mergedAnswers, now()->addHours(24));
                    \Illuminate\Support\Facades\Cache::put('user_' . $userId . '_meeting6_user_paragraph_answer', $userParagraphAnswer, now()->addHours(24));
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to save AssignmentDraft: ' . $e->getMessage());
            }
        }

        session()->save();

        return response()->json([
            'ok' => true,
            'meeting' => $meeting,
            'saved_at' => now()->toIso8601String(),
        ]);
    }

    public function meeting4(BuildGrammarWritingMeeting4ViewData $buildGrammarWritingMeeting4ViewData)
    {
        return view('assignments.grammar-writing.meeting4', $buildGrammarWritingMeeting4ViewData->handle(
            $this->data->meeting4NegativeTenseExamples,
            $this->data->meeting4NegativeVocabularies,
        ));
    }

    public function meeting4Submit(Request $request, EvaluateGrammarWritingMeeting4Submission $evaluateGrammarWritingMeeting4Submission)
    {
        $isAiVariation = session('meeting4_use_ai_variation', false);
        $aiVariation = session('meeting4_ai_variation');

        if ($isAiVariation && is_array($aiVariation) && !empty($aiVariation['sentences'])) {
            $transSentences = $aiVariation['sentences'];
            $matrixIntro = $aiVariation['matrixIntro'] ?? [];
            $transMatrix = $aiVariation['matrix'] ?? [];
        } else {
            $transSentences = $this->data->meeting4NegativeTranslationSentences;
            $matrixIntro = $this->data->meeting4NegativeMatrixIntroSentences;
            $transMatrix = $this->data->meeting4NegativeTranslationMatrix;
        }

        $evaluation = $evaluateGrammarWritingMeeting4Submission->handle(
            $request->all(),
            $transSentences,
            $matrixIntro,
            $transMatrix,
        );

        return $this->completeConditionalGrammarWritingMeetingSubmission(
            4,
            'assignments.grammar-writing.meeting4',
            $evaluation['session'] ?? [],
            !empty($evaluation['saveScore']) ? $evaluation['totalScore'] : null,
        );
    }

    public function meeting4GenerateAiVariation(
        Request $request,
        \App\Application\GrammarWriting\GenerateGrammarVariationService $generator,
        BuildGrammarWritingMeeting4ViewData $buildGrammarWritingMeeting4ViewData
    ) {
        $baseData = $buildGrammarWritingMeeting4ViewData->handle(
            $this->data->meeting4NegativeTenseExamples,
            $this->data->meeting4NegativeVocabularies,
        );

        $baseSentences = is_array($baseData['translationSentences']) ? $baseData['translationSentences'] : $baseData['translationSentences']->toArray();
        $baseMatrixIntro = is_array($baseData['matrixIntroSentences']) ? $baseData['matrixIntroSentences'] : $baseData['matrixIntroSentences']->toArray();
        $baseMatrix = $baseData['translationMatrix'];

        $variation = $generator->generateMeeting4($baseSentences, $baseMatrixIntro, $baseMatrix);
        $nextAttempt = (int) session('meeting4_ai_attempt', 0) + 1;

        session([
            'meeting4_ai_variation' => $variation,
            'meeting4_use_ai_variation' => true,
            'meeting4_ai_attempt' => $nextAttempt,
            'meeting4_stage' => 1,
            'meeting4_trans_results' => [],
            'meeting4_score_part1' => 0,
            'meeting4_score_part2' => 0,
            'meeting4_total_score' => 0,
            'meeting4_user_answers' => [],
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'attempt' => $nextAttempt,
                'is_ai_generated' => $variation['is_ai_generated'] ?? true,
                'message' => 'Soal variasi baru berhasil dibuat!',
            ]);
        }

        return redirect()->route('assignments.grammar-writing.meeting4')->with('success', 'Soal variasi baru dari AI berhasil dibuat!');
    }

    public function meeting4SwitchMode(Request $request)
    {
        $mode = $request->input('mode', 'default');

        if ($mode === 'default') {
            session(['meeting4_use_ai_variation' => false]);
        } else {
            session(['meeting4_use_ai_variation' => true]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'mode' => $mode]);
        }

        return redirect()->route('assignments.grammar-writing.meeting4');
    }

    public function meeting4Reset()
    {
        $userId = auth()->id();
        $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? auth()->user()?->program_id;
        if ($userId && $programId) {
            try {
                \App\Models\AssignmentDraft::where('user_id', $userId)
                    ->where('program_id', $programId)
                    ->where('meeting_number', 4)
                    ->delete();
            } catch (\Throwable $e) {}
        }

        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting4',
            [
                'meeting4_stage',
                'meeting4_trans_results',
                'meeting4_score_part1',
                'meeting4_score_part2',
                'meeting4_total_score',
                'meeting4_user_answers',
            ],
        );
    }
}