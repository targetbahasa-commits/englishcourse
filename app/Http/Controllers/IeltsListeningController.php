<?php

namespace App\Http\Controllers;

use App\Application\IeltsListening\BuildIeltsListeningIndexData;
use App\Application\IeltsListening\BuildIeltsListeningMaterialData;
use App\Application\IeltsListening\BuildIeltsListeningPracticeIndexData;
use App\Application\IeltsListening\BuildIeltsListeningWarmUpData;
use App\Application\IeltsListening\PrepareIeltsListeningPracticeData;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\ResolvesAuthenticatedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IeltsListeningController extends Controller
{
    use HandlesAssignmentAccess;
    use ResolvesAuthenticatedUser;

    public function __construct(
        private readonly BuildIeltsListeningIndexData $buildIeltsListeningIndexData,
        private readonly BuildIeltsListeningMaterialData $buildIeltsListeningMaterialData,
        private readonly BuildIeltsListeningPracticeIndexData $buildIeltsListeningPracticeIndexData,
        private readonly BuildIeltsListeningWarmUpData $buildIeltsListeningWarmUpData,
        private readonly PrepareIeltsListeningPracticeData $prepareIeltsListeningPracticeData,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.ielts.listening.index', $this->buildIeltsListeningIndexData->handle(Auth::user()));
    }

    public function practiceIndex()
    {
        return view('assignments.ielts.listening.practice-index', $this->buildIeltsListeningPracticeIndexData->handle());
    }

    public function material(Request $request, int $id)
    {
        return view(
            'assignments.ielts.listening.material',
            $this->buildIeltsListeningMaterialData->material($id, (int) $request->get('practice', 1))
        );
    }

    public function warmUp(Request $request, string $type)
    {
        return view(
            'assignments.ielts.listening.warmup.' . $type,
            $this->buildIeltsListeningWarmUpData->handle($type, (int) $request->get('practice', 1))
        );
    }

    public function practiceIndexPart(int $set)
    {
        $validParts = [1, 2, 3, 4];

        if (!in_array($set, $validParts, true)) {
            abort(404);
        }

        return view('assignments.ielts.listening.part1-practice', ['set' => $set]);
    }

    public function practiceIndexTest(int $set, int $test)
    {
        $data = $this->prepareIeltsListeningPracticeData->createPracticeIndexTestMeeting($set);
        $data['testId'] = $test;

        return view('assignments.ielts.listening.test-practice', $data);
    }

    public function showPractice(int $meetingId, int $set, ?int $partNumber = null)
    {
        $user = $this->authenticatedUser();
        $data = $this->prepareIeltsListeningPracticeData->ensurePracticeMeetingIsAccessible(
            $meetingId,
            $set,
            $partNumber,
            $user,
        );

        if ($user && $data['isLocked'] && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('assignments.ielts-academic.listening.index')->with('error', 'This practice test is currently locked.');
        }

        unset($data['isLocked']);

        return view('assignments.ielts.listening.part1-practice', $data);
    }

    public function showPracticeTest(int $meetingId, int $set, int $testId, ?int $partNumber = null)
    {
        $user = $this->authenticatedUser();
        $data = $this->prepareIeltsListeningPracticeData->ensurePracticeTestIsAccessible(
            $meetingId,
            $set,
            $testId,
            $partNumber,
            $user,
        );

        if ($user && $data['isLocked'] && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('assignments.ielts-academic.listening.index')->with('error', 'This practice test is currently locked.');
        }

        unset($data['isLocked']);

        return view('assignments.ielts.listening.test-practice', $data);
    }

    public function submitPractice(Request $request)
    {
        return redirect()->back()->with('success', 'Your IELTS Listening answers have been submitted successfully!');
    }
}
