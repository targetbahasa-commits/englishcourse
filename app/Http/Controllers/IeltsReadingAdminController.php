<?php

namespace App\Http\Controllers;

use App\Application\IeltsReading\ManageIeltsReadingContent;
use App\Application\IeltsReading\ManageIeltsReadingMeetings;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\RequiresAdminAccess;
use Illuminate\Http\Request;

class IeltsReadingAdminController extends Controller
{
    use HandlesAssignmentAccess, RequiresAdminAccess;

    public function __construct(
        private readonly ManageIeltsReadingContent $manageIeltsReadingContent,
        private readonly ManageIeltsReadingMeetings $manageIeltsReadingMeetings,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function storePassage(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'material_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $this->manageIeltsReadingContent->createPassage($validated);

        return response()->json(['success' => true, 'message' => 'Passage created successfully']);
    }

    public function updatePassage(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $this->manageIeltsReadingContent->updatePassage($id, $validated);

        return response()->json(['success' => true, 'message' => 'Passage updated successfully']);
    }

    public function destroyPassage(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsReadingContent->deletePassage($id);

        return response()->json(['success' => true, 'message' => 'Passage deleted successfully']);
    }

    public function storeQuestion(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'passage_id' => 'required|integer|exists:ielts_reading_passages,id',
            'question_number' => 'required|integer',
            'question_text' => 'nullable|string',
            'type' => 'required|string',
            'options' => 'nullable',
            'correct_answer' => 'nullable',
            'explanation' => 'nullable|string',
            'order' => 'nullable|integer',
            'data' => 'nullable|array',
        ]);

        $this->manageIeltsReadingContent->createQuestion($validated);

        return response()->json(['success' => true, 'message' => 'Question created successfully']);
    }

    public function updateQuestion(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'question_number' => 'required|integer',
            'question_text' => 'nullable|string',
            'type' => 'required|string',
            'options' => 'nullable',
            'correct_answer' => 'nullable',
            'explanation' => 'nullable|string',
            'order' => 'nullable|integer',
            'data' => 'nullable|array',
        ]);

        $this->manageIeltsReadingContent->updateQuestion($id, $validated);

        return response()->json(['success' => true, 'message' => 'Question updated successfully']);
    }

    public function destroyQuestion(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsReadingContent->deleteQuestion($id);

        return response()->json(['success' => true, 'message' => 'Question deleted successfully']);
    }

    public function storeMeeting(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meeting_number' => 'required|integer',
        ]);

        $this->manageIeltsReadingMeetings->createMeeting($validated);

        return back()->with('success', 'Practice Test created successfully');
    }

    public function reorderMeetings(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'meetings' => 'required|array',
            'meetings.*' => 'exists:meetings,id',
        ]);

        $this->manageIeltsReadingMeetings->reorderMeetings($validated['meetings']);

        return response()->json(['success' => true]);
    }

    public function uploadDiagram(Request $request)
    {
        $this->requireAdmin();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('diagrams', 'public');
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Upload failed'], 400);
    }
}
