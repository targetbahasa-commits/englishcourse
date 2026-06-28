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

        $payload['data']['isClassEnded'] = Auth::user()?->isStudent() ? $this->isStudentClassPeriodEnded('ielts-academic-full-package') : false;

        return view($payload['view'], $payload['data']);
    }

    public function showMeeting(int $task, int $id)
    {
        $meeting = $this->showIeltsWritingMeeting->handle($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($meeting->is_locked && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('assignments.ielts-academic.writing.index', ['task' => $task])
                ->with('error', 'This practice test is currently locked.');
        }

        $this->hydrateIeltsWritingSupportData->handle($meeting);

        $backUrl = $this->resolveIeltsWritingNavigation->determineBackUrl($task, $meeting);

        $isClassEnded = Auth::user()?->isStudent() ? $this->isStudentClassPeriodEnded('ielts-academic-full-package') : false;

        if ($meeting->view_type === 'practice_selection') {
            $range = $this->resolveIeltsWritingNavigation->practiceSelectionRange($meeting->meeting_number);
            $practices = $this->showIeltsWritingMeeting->getPracticeItemsInRange($range[0], $range[1]);

            return view('assignments.ielts.writing.practice_selection', compact('task', 'meeting', 'practices', 'backUrl', 'isClassEnded'));
        }

        $view = $this->resolveIeltsWritingNavigation->resolveMeetingView($meeting->view_type);

        return view($view, compact('task', 'meeting', 'backUrl', 'isClassEnded'));
    }

    public function practiceIndex(Request $request)
    {
        $task = $request->query('task');
        $type = $request->query('type');
        $data = $this->resolveIeltsWritingNavigation->buildPracticeIndexData($task, $type);
        $items = $data['items'];
        $task2Meetings = $data['task2Meetings'];

        $isClassEnded = Auth::user()?->isStudent() ? $this->isStudentClassPeriodEnded('ielts-academic-full-package') : false;

        return view('assignments.ielts.writing.practice-index', compact('task', 'type', 'items', 'task2Meetings', 'isClassEnded'));
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
        
        $availableTopics = $introAvailable->merge($complexityAvailable)->merge($proficiencyAvailable)->unique()->values();
        
        $introTopics = collect();
        
        return view('assignments.ielts.writing.grammar-practice', compact('title', 'desc', 'level', 'topics', 'availableTopics', 'introTopics'));
    }

    public function evaluate(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(1200);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->grading($essay, $taskType),
            1200,
            4096,
            true,
            true,
            'IELTS Grading',
            'AI Response Error',
            $taskType,
            'evaluate'
        );
    }

    public function feedback(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(600);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithFeedbackPrompt(
            $this->buildIeltsWritingAiPrompt->feedback($essay, $taskType),
            600,
            4096,
            $taskType,
            'feedback'
        );
    }

    public function correct(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(1200);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithCorrectionPrompt(
            $this->buildIeltsWritingAiPrompt->correction($essay, $taskType),
            $essay,
            1200,
            4096,
            $taskType,
            'correct'
        );
    }

    public function vocabulary(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(300);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->vocabulary($essay, $taskType), 
            300, 
            4096,
            false,
            true,
            null,
            'AI Response Error',
            $taskType,
            'vocabulary'
        );
    }

    public function coherence(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(300);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->coherence($essay, $taskType), 
            300, 
            4096,
            false,
            true,
            null,
            'AI Response Error',
            $taskType,
            'coherence'
        );
    }

    public function taskResponse(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(300);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->taskResponse($essay, $taskType),
            300,
            4096,
            false,
            true,
            'Task Response',
            'AI Response Error',
            $taskType,
            'task_achievement'
        );
    }

    public function grammar(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(300);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->grammar($essay, $taskType), 
            300, 
            4096,
            false,
            true,
            null,
            'AI Response Error',
            $taskType,
            'grammar'
        );
    }

    public function improve(IeltsWritingEssayRequest $request)
    {
        $this->configureExecutionLimit(300, false);
        $essay = $request->essay();
        $taskType = $request->taskType();

        return $this->handleIeltsWritingAiResponse->respondWithJsonPrompt(
            $this->buildIeltsWritingAiPrompt->improve($essay, $taskType),
            300,
            4096,
            true,
            false,
            'IELTS Improvement',
            'AI Response Error: ' . json_last_error_msg(),
            $taskType,
            'improve'
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