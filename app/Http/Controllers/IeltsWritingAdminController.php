<?php

namespace App\Http\Controllers;

use App\Application\IeltsWriting\ManageIeltsWritingContent;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\RequiresAdminAccess;
use Illuminate\Http\Request;

class IeltsWritingAdminController extends Controller
{
    use HandlesAssignmentAccess, RequiresAdminAccess;

    public function __construct(
        private readonly ManageIeltsWritingContent $manageIeltsWritingContent,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function storeMeeting(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'task_type' => 'required|in:1,2',
            'meeting_number' => 'required|integer',
            'title' => 'required|string',
            'prompt' => 'required|string',
            'image' => 'nullable|string',
            'category' => 'nullable|in:lesson,practice',
        ]);

        $this->manageIeltsWritingContent->createMeeting($validated);

        return back()->with('success', 'Lesson added successfully.');
    }

    public function updateMeeting(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string',
            'prompt' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        unset($validated['image']);

        $this->manageIeltsWritingContent->updateMeeting($id, $validated, $request->file('image'));

        return back()->with('success', 'Lesson updated successfully.');
    }

    public function destroyMeeting(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsWritingContent->deleteMeeting($id);

        return back()->with('success', 'Lesson deleted successfully.');
    }

    public function toggleMeetingLock(int $id)
    {
        $this->requireAdmin();

        $isLocked = $this->manageIeltsWritingContent->toggleMeetingLock($id);
        $newLabel = $isLocked ? 'LOCKED' : 'OPEN';

        return back()
            ->with('success', 'Writing lesson is now ' . $newLabel . '.')
            ->with('success_state', $isLocked ? 'locked' : 'open');
    }

    public function toggleSpeakingLock(int $id)
    {
        $this->requireAdmin();

        $isLocked = $this->manageIeltsWritingContent->toggleSpeakingLock($id);
        $newLabel = $isLocked ? 'LOCKED' : 'OPEN';

        return back()
            ->with('success', 'Speaking topic is now ' . $newLabel . '.')
            ->with('success_state', $isLocked ? 'locked' : 'open');
    }

    public function storeQuestion(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'ielts_writing_meeting_id' => 'required|exists:ielts_writing_meetings,id',
            'title' => 'required|string',
            'instruction' => 'nullable|string',
        ]);

        $this->manageIeltsWritingContent->createQuestion($validated);

        return back()->with('success', 'Question added successfully.');
    }

    public function updateQuestion(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string',
            'instruction' => 'nullable|string',
        ]);

        $this->manageIeltsWritingContent->updateQuestion($id, $validated);

        return back()->with('success', 'Question updated successfully.');
    }

    public function destroyQuestion(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsWritingContent->deleteQuestion($id);

        return back()->with('success', 'Question deleted successfully.');
    }

    public function reorderMeetings(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|integer|exists:ielts_writing_meetings,id',
            'order.*.meeting_number' => 'required|integer|min:1',
        ]);

        $this->manageIeltsWritingContent->reorderMeetings($validated['order']);

        return response()->json(['success' => true]);
    }
}