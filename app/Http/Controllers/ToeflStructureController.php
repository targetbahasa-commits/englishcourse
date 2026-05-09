<?php

namespace App\Http\Controllers;

use App\Application\ToeflStructure\BuildStructureIndexData;
use App\Application\ToeflStructure\BuildStructureMeetingViewData;
use App\Application\ToeflStructure\ManageStructureExplanation;
use App\Application\ToeflStructure\SubmitStructureMeeting;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
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

        return back()
            ->with('score_data', $scoreData)
            ->with('success', "Score: {$scoreData['score']}% ({$scoreData['correct_count']}/{$scoreData['total_questions']} correct)");
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