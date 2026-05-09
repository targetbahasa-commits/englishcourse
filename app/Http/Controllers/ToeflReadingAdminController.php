<?php

namespace App\Http\Controllers;

use App\Application\ToeflReading\ManageReadingContent;
use App\Application\ToeflReading\ManageReadingMeetings;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToeflReadingAdminController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly ManageReadingContent $manageReadingContent,
        private readonly ManageReadingMeetings $manageReadingMeetings,
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

        $this->manageReadingMeetings->create($request->integer('meeting_number'), (string) $request->input('title'));

        return back()->with('success', 'Reading meeting added successfully.');
    }

    public function reorder(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'meetings' => 'required|array',
            'meetings.*' => 'exists:toefl_reading_meetings,id',
        ]);

        $this->manageReadingMeetings->reorder($request->input('meetings', []));

        return response()->json(['success' => true]);
    }

    public function toggleLock(ToeflReadingMeeting $meeting, Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $message = $this->manageReadingMeetings->toggleLock($meeting->id, (int) $meeting->meeting_number, $request->integer('class_period_id'));

        return back()->with('success', $message);
    }

    public function update(Request $request, ToeflReadingMeeting $meeting)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'meeting_number' => 'required|integer',
            'title' => 'required|string|max:255',
        ]);

        $this->manageReadingMeetings->update($meeting->id, $request->integer('meeting_number'), (string) $request->input('title'));

        return back()->with('success', 'Reading meeting updated successfully.');
    }

    public function destroy(ToeflReadingMeeting $meeting)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $this->manageReadingMeetings->destroy($meeting->id);

        return back()->with('success', 'Reading meeting deleted successfully.');
    }

    public function storePassage(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'meeting_id' => 'required|exists:toefl_reading_meetings,id',
            'passage_number' => 'required|integer',
            'content' => 'required|string',
            'translation' => 'nullable|string',
        ]);

        $this->manageReadingContent->createPassage($request->only(['meeting_id', 'passage_number', 'content', 'translation']));

        return back()->with('success', 'Passage added successfully.');
    }

    public function updatePassage(Request $request, ToeflReadingPassage $passage)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'passage_number' => 'required|integer',
            'content' => 'required|string',
            'translation' => 'nullable|string',
        ]);

        $this->manageReadingContent->updatePassage($passage->id, $request->only(['passage_number', 'content', 'translation']));

        return back()->with('success', 'Passage updated successfully.');
    }

    public function destroyPassage(ToeflReadingPassage $passage)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $this->manageReadingContent->deletePassage($passage->id);

        return back()->with('success', 'Passage deleted successfully.');
    }

    public function storeQuestion(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'passage_id' => 'required|exists:toefl_reading_passages,id',
            'question_number' => 'required|integer',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $this->manageReadingContent->createQuestion($request->only([
            'passage_id',
            'question_number',
            'question_text',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'correct_answer',
        ]));

        return back()->with('success', 'Question added successfully.');
    }

    public function updateQuestion(Request $request, ToeflReadingQuestion $question)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'question_number' => 'required|integer',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $this->manageReadingContent->updateQuestion($question->id, $request->only([
            'question_number',
            'question_text',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'correct_answer',
        ]));

        return back()->with('success', 'Question updated successfully.');
    }

    public function destroyQuestion(ToeflReadingQuestion $question)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $this->manageReadingContent->deleteQuestion($question->id);

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

        $question = ToeflReadingQuestion::find($id);
        if (!$question) {
            return response()->json(['success' => false, 'message' => 'Question not found'], 404);
        }

        $question->update(['correct_answer' => $validated['correct_answer']]);

        return response()->json(['success' => true, 'message' => 'Answer updated successfully.']);
    }
}
