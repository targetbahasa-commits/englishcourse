<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\BuildGrammarWritingMeeting1ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting3ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting4ViewData;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting1Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting3Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting4Submission;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\HandlesGrammarWritingSessions;
use App\Http\Controllers\Concerns\HandlesLegacyGrammarWritingData;
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

    public function __construct()
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

        $this->saveMeetingScore(1, $evaluation['finalScore']);

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
            $this->meeting3FallbackQuestions,
            $this->meeting3FallbackParagraph,
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
            $this->meeting3FallbackQuestions,
            $hasSectionColumn,
        );
        $minimumRequiredTranslations = 20;
        $filledTranslations = 0;

        foreach ($questions as $question) {
            $questionNumber = (int) ($question->question_number ?? 0);
            if ($questionNumber <= 0) {
                continue;
            }

            $translation = trim((string) ($userAnswers[$questionNumber]['trans'] ?? ''));
            if ($translation !== '') {
                $filledTranslations++;
            }
        }

        if ($filledTranslations < $minimumRequiredTranslations) {
            return back()
                ->withInput()
                ->withErrors([
                    'userAnswers' => 'Kamu harus mengerjakan minimal 20 soal translate sebelum submit. Saat ini baru ' . $filledTranslations . '/20.',
                ]);
        }

        $paragraphRecord = $buildGrammarWritingMeeting3ViewData->resolveParagraphRecord($hasSectionColumn);

        $sessionPayload = $evaluateGrammarWritingMeeting3Submission->handle(
            $questions,
            $userParagraphAnswer,
            $userAnswers,
            $paragraphRecord?->correct_answer ?? $this->meeting3FallbackParagraph['en'],
        );

        return $this->completeGrammarWritingMeetingSubmission(
            3,
            'assignments.grammar-writing.meeting3',
            $sessionPayload,
            'meeting3_final_score',
        );
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
            $this->meeting4Questions,
            $this->meeting4Paragraph,
            $this->grammarQuestionsHasSectionColumn(),
        ));
    }

    public function meeting4Submit(
        Request $request,
        BuildGrammarWritingMeeting4ViewData $buildGrammarWritingMeeting4ViewData,
        EvaluateGrammarWritingMeeting4Submission $evaluateGrammarWritingMeeting4Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $hasSectionColumn = $this->grammarQuestionsHasSectionColumn();
        $questions = $buildGrammarWritingMeeting4ViewData->formatQuestionsForView(
            $buildGrammarWritingMeeting4ViewData->loadQuestionRecords($this->meeting4Questions, $hasSectionColumn)
        );
        $paragraphRecord = $buildGrammarWritingMeeting4ViewData->resolveParagraphRecord($hasSectionColumn);

        $sessionPayload = $evaluateGrammarWritingMeeting4Submission->handle(
            $questions,
            $userParagraphAnswer,
            $userAnswers,
            $paragraphRecord?->correct_answer ?? $this->meeting4Paragraph['en'],
        );

        return $this->completeGrammarWritingMeetingSubmission(
            4,
            'assignments.grammar-writing.meeting4',
            $sessionPayload,
            'meeting4_final_score',
        );
    }

    public function meeting4Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting4',
            [
            'meeting4_submitted',
            'meeting4_results',
            'meeting4_paragraph_result',
            'meeting4_final_score',
            'meeting4_user_answers',
            'meeting4_user_paragraph_answer'
            ],
        );
    }
}