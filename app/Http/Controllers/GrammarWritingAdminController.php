<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\BuildGrammarWritingIndexData;
use App\Application\GrammarWriting\ManageGrammarWritingContent;
use App\Application\GrammarWriting\ManageGrammarWritingMeetings;
use App\Http\Requests\StoreGrammarQuestionRequest;
use App\Http\Requests\StoreGrammarVocabularyRequest;
use App\Http\Requests\UpdateAssignmentBatchPeriodRequest;
use App\Http\Requests\UpdateGrammarQuestionRequest;
use App\Http\Requests\UpdateGrammarVocabularyRequest;
use App\Http\Requests\UpdateGrammarWritingPeriodRequest;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrammarWritingAdminController extends Controller
{

    /**
     * GrammarWritingAdminController
     *
     * Handles all grammar-writing admin and management actions (CRUD, period, lock, batch updates).
     * Only grammar admins and teachers should access these endpoints.
     */
    protected function requireGrammarWritingAdminOrTeacher(): mixed
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        return $user;
    }

    public function updateBatchPeriod(UpdateAssignmentBatchPeriodRequest $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->updateBatchPeriod(
            $request->programId(),
            $request->period(),
        );

        if (!$result['ok']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function grammarWritingClasses()
    {
        return view('assignments.grammar-writing-classes');
    }

    public function grammarWriting(BuildGrammarWritingIndexData $buildGrammarWritingIndexData)
    {
        return view('assignments.grammar-writing', $buildGrammarWritingIndexData->handle(Auth::user()));
    }

    public function updatePeriod(UpdateGrammarWritingPeriodRequest $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->updateActivePeriod(
            $request->period(),
        );

        return back()
            ->with('success', $result['message'])
            ->with('success_state', $result['success_state']);
    }

    public function toggleLock(Meeting $meeting, Request $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->toggleLock($meeting->id, $request->integer('class_period_id'));

        return back()
            ->with('success', $result['message'])
            ->with('success_state', $result['success_state']);
    }

    public function storeGrammarQuestion(StoreGrammarQuestionRequest $request, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->createQuestion($request->validated());

        return back()->with('success', 'Question added successfully.');
    }

    public function updateGrammarQuestion(UpdateGrammarQuestionRequest $request, $id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->updateQuestion((int) $id, $request->validated());

        return back()->with('success', 'Question updated successfully.');
    }

    public function destroyGrammarQuestion($id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->deleteQuestion((int) $id);

        return back()->with('success', 'Question deleted successfully.');
    }

    public function storeGrammarVocabulary(StoreGrammarVocabularyRequest $request, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->createVocabulary($request->validated());

        return back()->with('success', 'Vocabulary added successfully.');
    }

    public function updateGrammarVocabulary(UpdateGrammarVocabularyRequest $request, $id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->updateVocabulary((int) $id, $request->validated());

        return back()->with('success', 'Vocabulary updated successfully.');
    }

    public function destroyGrammarVocabulary($id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->deleteVocabulary((int) $id);

        return back()->with('success', 'Vocabulary deleted successfully.');
    }
}
