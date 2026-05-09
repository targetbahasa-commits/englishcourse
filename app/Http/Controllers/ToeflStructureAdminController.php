<?php

namespace App\Http\Controllers;

use App\Application\ToeflStructure\ManageStructureExplanation;
use App\Application\ToeflStructure\ManageStructureMeetings;
use App\Application\ToeflStructure\ManageStructureQuestions;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Models\ToeflStructureMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToeflStructureAdminController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly ManageStructureMeetings $manageStructureMeetings,
        private readonly ManageStructureExplanation $manageStructureExplanation,
        private readonly ManageStructureQuestions $manageStructureQuestions,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'meeting_number' => 'required|integer',
            'title' => 'required|string|max:255',
        ]);

        $this->manageStructureMeetings->create($request->integer('meeting_number'), (string) $request->input('title'));

        return back()->with('success', 'Structure meeting added successfully.');
    }

    public function addSet(Request $request, int $number)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $this->manageStructureMeetings->addSet($number);

        return back()->with('success', 'New exercise added successfully.');
    }

    public function removeSet(Request $request, int $number)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $message = $this->manageStructureMeetings->removeSet($request->integer('target_number'));
        $flashKey = $message === 'Exercise deleted successfully.' ? 'success' : 'error';

        return back()->with($flashKey, $message);
    }

    public function reorder(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'meetings' => 'required|array',
            'meetings.*' => 'exists:toefl_structure_meetings,id',
        ]);

        $this->manageStructureMeetings->reorder($request->input('meetings', []));

        return response()->json(['success' => true]);
    }

    public function saveExplanation(Request $request, int $number)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $validated = $request->validate([
            'image' => 'required|string',
        ]);

        try {
            $this->manageStructureExplanation->save($number, $validated['image']);
        } catch (\RuntimeException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json(['success' => true, 'message' => 'Explanation saved successfully.']);
    }

    public function toggleLock(ToeflStructureMeeting $meeting, Request $request)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $message = $this->manageStructureMeetings->toggleLock($meeting->id, (int) $meeting->meeting_number, $request->integer('class_period_id'));

        return back()->with('success', $message);
    }

    public function update(Request $request, ToeflStructureMeeting $meeting)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'meeting_number' => 'required|integer',
            'title' => 'required|string|max:255',
        ]);

        $this->manageStructureMeetings->update($meeting->id, $request->integer('meeting_number'), (string) $request->input('title'));

        return back()->with('success', 'Structure meeting updated successfully.');
    }

    public function destroy(ToeflStructureMeeting $meeting)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $this->manageStructureMeetings->destroy($meeting->id);

        return back()->with('success', 'Structure meeting deleted successfully.');
    }

    public function storeQuestion(Request $request, int $number)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'question_number' => 'required|integer',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $this->manageStructureQuestions->create($number, $validated);

        return back()->with('success', 'Question added successfully.');
    }

    public function updateQuestion(Request $request, int $id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'question_number' => 'required|integer',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $this->manageStructureQuestions->update($id, $validated);

        return back()->with('success', 'Question updated successfully.');
    }

    public function destroyQuestion(int $id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $this->manageStructureQuestions->destroy($id);

        return back()->with('success', 'Question deleted successfully.');
    }

    public function updateQuestionAnswer(Request $request, int $id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $this->manageStructureQuestions->updateAnswer($id, $validated['correct_answer']);

        return response()->json(['success' => true, 'message' => 'Answer updated successfully.']);
    }
}
