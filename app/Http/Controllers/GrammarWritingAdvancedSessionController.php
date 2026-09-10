<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\BuildGrammarWritingMeeting13ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting14ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting15ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting16ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting17ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting18ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting19ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting20ViewData;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting13Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting14Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting15Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting16Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting17Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting18Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting19Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting20Submission;
use App\Application\GrammarWriting\GrammarWritingDataRepository;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\HandlesGrammarWritingSessions;
use Illuminate\Http\Request;

class GrammarWritingAdvancedSessionController extends Controller
{

    /**
     * GrammarWritingAdvancedSessionController
     *
     * Handles grammar-writing meetings 13–20 (advanced student-facing session logic).
     * All session helpers and view data are injected; no admin logic here.
     */
    use HandlesAssignmentAccess;
    use HandlesGrammarWritingSessions;

    public function __construct(private GrammarWritingDataRepository $data)
    {
        $this->registerAssignmentAccessMiddleware();
    }

    public function meeting13(BuildGrammarWritingMeeting13ViewData $buildGrammarWritingMeeting13ViewData)
    {
        return view('assignments.grammar-writing.meeting13', $buildGrammarWritingMeeting13ViewData->handle(
            $this->data->meeting13Paragraph,
        ));
    }

    public function meeting13Submit(
        Request $request,
        BuildGrammarWritingMeeting13ViewData $buildGrammarWritingMeeting13ViewData,
        EvaluateGrammarWritingMeeting13Submission $evaluateGrammarWritingMeeting13Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting13ViewData->loadQuestions();
        $paragraph = $buildGrammarWritingMeeting13ViewData->loadParagraph($this->data->meeting13Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting13Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            13,
            'assignments.grammar-writing.meeting13',
            $sessionPayload,
            'meeting13_final_score',
        );
    }

    public function meeting13Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting13',
            [
            'meeting13_submitted',
            'meeting13_results',
            'meeting13_paragraph_result',
            'meeting13_final_score',
            'meeting13_user_answers',
            'meeting13_user_paragraph_answer'
            ],
        );
    }

    public function meeting14(Request $request, BuildGrammarWritingMeeting14ViewData $buildGrammarWritingMeeting14ViewData)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $displayMeetingNumber = $isFastTrack ? 8 : 14;

        return view('assignments.grammar-writing.meeting14', array_merge(
            $buildGrammarWritingMeeting14ViewData->handle(
                $this->data->meeting14Paragraph,
            ),
            [
                'displayMeetingNumber' => $displayMeetingNumber,
                'backRoute' => $isFastTrack ? route('assignments.grammar-writing') : route('assignments.grammar-writing.classes'),
            ]
        ));
    }

    public function meeting14Submit(
        Request $request,
        BuildGrammarWritingMeeting14ViewData $buildGrammarWritingMeeting14ViewData,
        EvaluateGrammarWritingMeeting14Submission $evaluateGrammarWritingMeeting14Submission,
    ) {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting8' : 'assignments.grammar-writing.meeting14';
        $meetingNum = $isFastTrack ? 8 : 14;

        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting14ViewData->loadQuestions();
        $paragraph = $buildGrammarWritingMeeting14ViewData->loadParagraph($this->data->meeting14Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting14Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            $meetingNum,
            $redirectRoute,
            $sessionPayload,
            'meeting14_final_score',
        );
    }

    public function meeting14Reset(Request $request)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting8' : 'assignments.grammar-writing.meeting14';

        return $this->resetGrammarWritingMeetingSession(
            $redirectRoute,
            [
            'meeting14_submitted',
            'meeting14_results',
            'meeting14_paragraph_result',
            'meeting14_final_score',
            'meeting14_user_answers',
            'meeting14_user_paragraph_answer'
            ],
        );
    }

    public function meeting15(Request $request, BuildGrammarWritingMeeting15ViewData $buildGrammarWritingMeeting15ViewData)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $displayMeetingNumber = $isFastTrack ? 9 : 15;

        return view('assignments.grammar-writing.meeting15', array_merge(
            $buildGrammarWritingMeeting15ViewData->handle(
                $this->data->meeting15Paragraph,
            ),
            [
                'displayMeetingNumber' => $displayMeetingNumber,
                'backRoute' => $isFastTrack ? route('assignments.grammar-writing') : route('assignments.grammar-writing.classes'),
            ]
        ));
    }

    public function meeting15Submit(
        Request $request,
        BuildGrammarWritingMeeting15ViewData $buildGrammarWritingMeeting15ViewData,
        EvaluateGrammarWritingMeeting15Submission $evaluateGrammarWritingMeeting15Submission,
    ) {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting9' : 'assignments.grammar-writing.meeting15';
        $meetingNum = $isFastTrack ? 9 : 15;

        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting15ViewData->loadQuestions();
        $paragraph = $buildGrammarWritingMeeting15ViewData->loadParagraph($this->data->meeting15Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting15Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            $meetingNum,
            $redirectRoute,
            $sessionPayload,
            'meeting15_final_score',
        );
    }

    public function meeting15Reset(Request $request)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting9' : 'assignments.grammar-writing.meeting15';

        return $this->resetGrammarWritingMeetingSession(
            $redirectRoute,
            [
            'meeting15_submitted',
            'meeting15_results',
            'meeting15_paragraph_result',
            'meeting15_final_score',
            'meeting15_user_answers',
            'meeting15_user_paragraph_answer'
            ],
        );
    }

    public function meeting16(BuildGrammarWritingMeeting16ViewData $buildGrammarWritingMeeting16ViewData)
    {
        return view('assignments.grammar-writing.meeting16', $buildGrammarWritingMeeting16ViewData->handle(
            $this->data->meeting16Paragraph,
        ));
    }

    public function meeting16Submit(
        Request $request,
        BuildGrammarWritingMeeting16ViewData $buildGrammarWritingMeeting16ViewData,
        EvaluateGrammarWritingMeeting16Submission $evaluateGrammarWritingMeeting16Submission,
    ) {
        $userParagraphAnswer = (string) $request->input('userParagraphAnswer', '');
        $paragraph = $buildGrammarWritingMeeting16ViewData->loadParagraph($this->data->meeting16Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting16Submission->handle(
            $paragraph['en'],
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            16,
            'assignments.grammar-writing.meeting16',
            $sessionPayload,
            'meeting16_final_score',
        );
    }

    public function meeting16Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting16',
            [
            'meeting16_submitted',
            'meeting16_results',
            'meeting16_paragraph_result',
            'meeting16_final_score',
            'meeting16_user_answers',
            'meeting16_user_paragraph_answer'
            ],
        );
    }

    public function meeting17(Request $request, BuildGrammarWritingMeeting17ViewData $buildGrammarWritingMeeting17ViewData)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $displayMeetingNumber = $isFastTrack ? 10 : 17;

        return view('assignments.grammar-writing.meeting17', array_merge(
            $buildGrammarWritingMeeting17ViewData->handle(
                $this->data->meeting17Questions,
                $this->data->meeting17Paragraph,
            ),
            [
                'displayMeetingNumber' => $displayMeetingNumber,
                'backRoute' => $isFastTrack ? route('assignments.grammar-writing') : route('assignments.grammar-writing.classes'),
            ]
        ));
    }

    public function meeting17Submit(
        Request $request,
        BuildGrammarWritingMeeting17ViewData $buildGrammarWritingMeeting17ViewData,
        EvaluateGrammarWritingMeeting17Submission $evaluateGrammarWritingMeeting17Submission,
    ) {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting10' : 'assignments.grammar-writing.meeting17';
        $meetingNum = $isFastTrack ? 10 : 17;

        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting17ViewData->loadQuestions($this->data->meeting17Questions);
        $paragraph = $buildGrammarWritingMeeting17ViewData->loadParagraph($this->data->meeting17Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting17Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            $meetingNum,
            $redirectRoute,
            $sessionPayload,
            'meeting17_final_score',
        );
    }

    public function meeting17Reset(Request $request)
    {
        $isFastTrack = str_contains($request->path(), 'fast-track');
        $redirectRoute = $isFastTrack ? 'assignments.grammar-writing.meeting10' : 'assignments.grammar-writing.meeting17';

        return $this->resetGrammarWritingMeetingSession(
            $redirectRoute,
            [
            'meeting17_submitted',
            'meeting17_results',
            'meeting17_paragraph_result',
            'meeting17_final_score',
            'meeting17_user_answers',
            'meeting17_user_paragraph_answer'
            ],
        );
    }

    public function meeting18(BuildGrammarWritingMeeting18ViewData $buildGrammarWritingMeeting18ViewData)
    {
        return view('assignments.grammar-writing.meeting18', $buildGrammarWritingMeeting18ViewData->handle(
            $this->data->meeting18Questions,
            $this->data->meeting18Paragraph,
        ));
    }

    public function meeting18Submit(
        Request $request,
        BuildGrammarWritingMeeting18ViewData $buildGrammarWritingMeeting18ViewData,
        EvaluateGrammarWritingMeeting18Submission $evaluateGrammarWritingMeeting18Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting18ViewData->loadQuestions($this->data->meeting18Questions);
        $paragraph = $buildGrammarWritingMeeting18ViewData->loadParagraph($this->data->meeting18Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting18Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            18,
            'assignments.grammar-writing.meeting18',
            $sessionPayload,
            'meeting18_final_score',
        );
    }

    public function meeting18Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting18',
            [
            'meeting18_submitted',
            'meeting18_results',
            'meeting18_paragraph_result',
            'meeting18_final_score',
            'meeting18_user_answers',
            'meeting18_user_paragraph_answer'
            ],
        );
    }

    public function meeting19(BuildGrammarWritingMeeting19ViewData $buildGrammarWritingMeeting19ViewData)
    {
        return view('assignments.grammar-writing.meeting19', $buildGrammarWritingMeeting19ViewData->handle(
            $this->data->meeting19Questions,
            $this->data->meeting19Paragraph,
        ));
    }

    public function meeting19Submit(
        Request $request,
        BuildGrammarWritingMeeting19ViewData $buildGrammarWritingMeeting19ViewData,
        EvaluateGrammarWritingMeeting19Submission $evaluateGrammarWritingMeeting19Submission,
    ) {
        $userAnswers = $request->input('userAnswers', []);
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $questions = $buildGrammarWritingMeeting19ViewData->loadQuestions($this->data->meeting19Questions);
        $paragraph = $buildGrammarWritingMeeting19ViewData->loadParagraph($this->data->meeting19Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting19Submission->handle(
            $questions,
            $paragraph['en'],
            $userAnswers,
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            19,
            'assignments.grammar-writing.meeting19',
            $sessionPayload,
            'meeting19_final_score',
        );
    }

    public function meeting19Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting19',
            [
            'meeting19_submitted',
            'meeting19_results',
            'meeting19_paragraph_result',
            'meeting19_final_score',
            'meeting19_user_answers',
            'meeting19_user_paragraph_answer'
            ],
        );
    }

    public function meeting20(BuildGrammarWritingMeeting20ViewData $buildGrammarWritingMeeting20ViewData)
    {
        return view('assignments.grammar-writing.meeting20', $buildGrammarWritingMeeting20ViewData->handle(
            $this->data->meeting20Paragraph,
        ));
    }

    public function meeting20Submit(
        Request $request,
        BuildGrammarWritingMeeting20ViewData $buildGrammarWritingMeeting20ViewData,
        EvaluateGrammarWritingMeeting20Submission $evaluateGrammarWritingMeeting20Submission,
    ) {
        $userParagraphAnswer = $request->input('userParagraphAnswer', '');
        $paragraph = $buildGrammarWritingMeeting20ViewData->loadParagraph($this->data->meeting20Paragraph);

        $sessionPayload = $evaluateGrammarWritingMeeting20Submission->handle(
            $paragraph['en'],
            $userParagraphAnswer,
        );

        return $this->completeGrammarWritingMeetingSubmission(
            20,
            'assignments.grammar-writing.meeting20',
            $sessionPayload,
            'meeting20_final_score',
        );
    }

    public function meeting20Reset()
    {
        return $this->resetGrammarWritingMeetingSession(
            'assignments.grammar-writing.meeting20',
            ['meeting20_submitted', 'meeting20_user_paragraph_answer', 'meeting20_paragraph_result', 'meeting20_final_score'],
        );
    }
}
