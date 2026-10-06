<?php

namespace App\Http\Controllers;

use App\Application\ToeflStructure\BuildStructureIndexData;
use App\Application\ToeflStructure\BuildStructureMeetingViewData;
use App\Application\ToeflStructure\ManageStructureExplanation;
use App\Application\ToeflStructure\SubmitStructureMeeting;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Models\AssignmentDraft;
use App\Models\MeetingScore;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToeflStructureController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly BuildStructureIndexData $buildStructureIndexData,
        private readonly BuildStructureMeetingViewData $buildStructureMeetingViewData,
        private readonly ManageStructureExplanation $manageStructureExplanation,
        private readonly SubmitStructureMeeting $submitStructureMeeting,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.toefl-itp.structure.index', $this->buildStructureIndexData->handle(Auth::user()));
    }

    public function showMeeting(Request $request, int $number)
    {
        $sessionKey = 'toefl_structure_score_' . $number . ($request->has('exercise') ? '_ex_' . $request->input('exercise') : '');

        if ($request->has('retry')) {
            $request->session()->forget($sessionKey);
            $request->session()->forget('toefl_structure_score_' . $number);
            $request->session()->forget('score_data');

            if (Auth::check()) {
                $user = Auth::user();
                $programId = Program::where('slug', 'toefl-itp')->value('id') ?? 2;

                MeetingScore::where('user_id', $user->id)
                    ->where('meeting_number', $number)
                    ->where(function ($q) use ($programId, $user) {
                        $q->where('program_id', $programId);
                        if (!empty($user->program_id)) {
                            $q->orWhere('program_id', $user->program_id);
                        }
                    })
                    ->delete();

                AssignmentDraft::where('user_id', $user->id)
                    ->where('meeting_number', $number)
                    ->delete();
            }

            return redirect()->route('assignments.toefl-itp.structure.meeting', array_merge(
                ['number' => $number],
                $request->except('retry')
            ));
        }

        $viewData = $this->buildStructureMeetingViewData->handle($number, Auth::user(), $request);

        if ($viewData['isLocked']) {
            return redirect()->route($viewData['lockedRedirectRoute'])
                ->with('error', 'Class is locked.');
        }

        return view($viewData['view'], $viewData['data']);
    }

    public function submit(Request $request, int $number)
    {
        $scoreData = $this->submitStructureMeeting->handle($number, $request->input('answers', []));

        // Score is a plain percentage (<=100) for untimed lessons, but a converted
        // TOEFL ITP section score (e.g. 310-680) for full 40-question tests - only
        // the former is meaningfully a "%", matching the Score Card's own check.
        $scoreLabel = $scoreData['score'] <= 100 ? "{$scoreData['score']}%" : $scoreData['score'];

        $sessionKey = 'toefl_structure_score_' . $number . ($request->has('exercise') ? '_ex_' . $request->input('exercise') : '');
        $request->session()->put($sessionKey, $scoreData);

        if (Auth::check()) {
            $user = Auth::user();
            $programId = Program::where('slug', 'toefl-itp')->value('id') ?? $user->program_id ?? 2;

            MeetingScore::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'meeting_number' => $number,
                    'program_id' => $programId,
                ],
                [
                    'score' => $scoreData['score'],
                    'submitted_at' => now(),
                    'answers_data' => $scoreData,
                    'is_reported' => true,
                ]
            );

            AssignmentDraft::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->delete();
        }

        return back()
            ->with('score_data', $scoreData)
            ->with('success', "Score: {$scoreLabel} ({$scoreData['correct_count']}/{$scoreData['total_questions']} correct)");
    }

    public function saveDraft(Request $request, int $number)
    {
        $answers = $request->input('answers', []);
        if (!is_array($answers)) {
            return response()->json(['success' => false, 'message' => 'Invalid answers format'], 422);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $programId = Program::where('slug', 'toefl-itp')->value('id') ?? $user->program_id ?? 2;

            AssignmentDraft::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'meeting_number' => $number,
                    'program_id' => $programId,
                ],
                [
                    'answers' => $answers,
                    'last_saved_at' => now(),
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Draft tersimpan otomatis',
            'saved_count' => count(array_filter($answers, fn($v) => !empty($v))),
        ]);
    }

    public function downloadExplanation(int $number)
    {
        $download = $this->manageStructureExplanation->resolveDownload($number);

        if (!file_exists($download['absolutePath'])) {
            return back()->with('error', 'Explanation file not found.');
        }

        return response()->download($download['absolutePath'], $download['filename']);
    }

}