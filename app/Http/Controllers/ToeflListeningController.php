<?php

namespace App\Http\Controllers;

use App\Application\ToeflListening\BuildListeningIndexData;
use App\Application\ToeflListening\BuildListeningMeetingViewData;
use App\Application\ToeflListening\SubmitListeningMeeting;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\ResolvesAuthenticatedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToeflListeningController extends Controller
{
    use HandlesAssignmentAccess;
    use ResolvesAuthenticatedUser;

    public function __construct(
        private readonly BuildListeningIndexData $buildListeningIndexData,
        private readonly BuildListeningMeetingViewData $buildListeningMeetingViewData,
        private readonly SubmitListeningMeeting $submitListeningMeeting,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.toefl-itp.listening.index', $this->buildListeningIndexData->handle($this->authenticatedUser()));
    }

    public function showMeeting(int $number)
    {
        $viewData = $this->buildListeningMeetingViewData->handle($number, $this->authenticatedUser());

        if ($viewData['isLocked']) {
            return redirect()->route('assignments.toefl-itp.listening')
                ->with('error', 'This meeting is currently locked.');
        }

        return view($viewData['view'], $viewData['data']);
    }

    public function showPractice(int $number, int $set)
    {
        $viewData = $this->buildListeningMeetingViewData->handle($number, $this->authenticatedUser(), $set);

        if ($viewData['isLocked']) {
            return redirect()->route('assignments.toefl-itp.listening')
                ->with('error', 'This meeting is currently locked.');
        }

        return view($viewData['view'], $viewData['data']);
    }

    public function submit(Request $request, int $number)
    {
        $result = $this->submitListeningMeeting->handle(
            $number,
            Auth::id(),
            $request->filled('set_number') ? $request->integer('set_number') : null,
            $request->all(),
        );

        if ($result['set_number']) {
            return redirect()->route('assignments.toefl-itp.listening.meeting.practice', ['number' => $number, 'set' => $result['set_number']])
                ->with('success', "Score (Set {$result['set_number']}): {$result['score']}% ({$result['correct_count']}/{$result['total_question']} correct)")
                ->with('score_data', $result);
        }

        return redirect()->route('assignments.toefl-itp.listening.meeting', $number)
            ->with('success', "Score: {$result['score']}% ({$result['correct_count']}/{$result['total_question']} correct)")
            ->with('score_data', $result);
    }
}
