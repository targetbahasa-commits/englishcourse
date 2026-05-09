<?php

namespace App\Http\Controllers;

use App\Application\ToeflReading\BuildReadingIndexData;
use App\Application\ToeflReading\BuildReadingMeetingViewData;
use App\Application\ToeflReading\SubmitReadingMeeting;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToeflReadingController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly BuildReadingIndexData $buildReadingIndexData,
        private readonly BuildReadingMeetingViewData $buildReadingMeetingViewData,
        private readonly SubmitReadingMeeting $submitReadingMeeting,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.toefl-itp.reading.index', $this->buildReadingIndexData->handle(Auth::user()));
    }

    public function showMeeting(int $number)
    {
        $viewData = $this->buildReadingMeetingViewData->handle($number, Auth::user());

        if ($viewData['isLocked']) {
            return redirect()->route($viewData['lockedRedirectRoute'])
                ->with('error', 'Class is locked.');
        }

        return view($viewData['view'], [
            'meeting' => $viewData['meeting'],
            'passages' => $viewData['passages'],
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'meeting_number' => 'required|integer',
        ]);

        $message = $this->submitReadingMeeting->handle(
            $request->integer('meeting_number'),
            $request->all(),
            Auth::id()
        );

        return back()->with('success', $message);
    }
}