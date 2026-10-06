<?php

namespace App\Http\Controllers\Admin;

use App\Application\Program\ManagePrograms;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgramBrochureUpdateRequest;
use App\Http\Requests\Admin\ProgramSyllabusReorderRequest;
use App\Http\Requests\Admin\ProgramSyllabusStoreRequest;
use App\Http\Requests\Admin\ProgramUpsertRequest;
use App\Models\Meeting;
use App\Models\Program;
use App\Models\User;

class ProgramController extends Controller
{
    public function __construct(
        private readonly ManagePrograms $managePrograms
    ) {}

    /**
     * Display a listing of the programs.
     */
    public function index()
    {
        $programs = $this->managePrograms->listAll();
        $satuanPrograms = \App\Models\Program::where('program_type', 'satuan')->get();

        return view('admin.programs.index', compact('programs', 'satuanPrograms'));
    }

    /**
     * Display a listing of purely mock test programs.
     */
    public function mockTestsIndex()
    {
        ['programs' => $programs, 'isMockTestView' => $isMockTestView] = $this->managePrograms->listMockTests();

        return view('admin.programs.index', compact('programs', 'isMockTestView'));
    }

    /**
     * Store a newly created program in storage.
     */
    public function store(ProgramUpsertRequest $request)
    {
        $validated = $request->validated();

        $this->managePrograms->store($validated, $request);

        return back()->with('success', 'Program created successfully.');
    }

    /**
     * Update the specified program in storage.
     */
    public function update(ProgramUpsertRequest $request, Program $program)
    {
        $validated = $request->validated();

        $this->managePrograms->update($program, $validated, $request);

        return back()->with('success', 'Program updated successfully.');
    }

    /**
     * Show the brochure management page for a program.
     */
    public function show(Program $program)
    {
        return redirect()->route('programs.index');
    }

    public function brochure(Program $program)
    {
        $aiPrompt = $this->managePrograms->buildBrochurePrompt($program);
        $geminiAvailable = \App\Services\AiBrochureImageGenerator::isAvailable('gemini');
        $openaiAvailable = \App\Services\AiBrochureImageGenerator::isAvailable('openai');

        return view('admin.programs.brochure', compact('program', 'aiPrompt', 'geminiAvailable', 'openaiAvailable'));
    }

    /**
     * Update brochure files (image and/or pdf) for a program.
     */
    public function updateBrochure(ProgramBrochureUpdateRequest $request, Program $program)
    {
        $this->managePrograms->updateBrochure($program, $request);

        return back()->with('success', 'Brosur berhasil diperbarui!');
    }

    /**
     * Generate an AI brochure image draft for review (not yet saved onto the program).
     */
    public function generateAiBrochureImage(\Illuminate\Http\Request $request, Program $program)
    {
        $request->validate([
            'provider' => 'required|in:gemini,openai',
            'prompt' => 'required|string|max:4000',
        ]);

        $result = $this->managePrograms->generateAiBrochureImage($request->input('provider'), $request->input('prompt'));

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    /**
     * Accept a previously generated AI brochure draft as the program's brochure image.
     */
    public function acceptAiBrochureImage(\Illuminate\Http\Request $request, Program $program)
    {
        $request->validate([
            'draft_path' => 'required|string|starts_with:brochures/ai-drafts/',
        ]);

        $finalPath = $this->managePrograms->acceptAiBrochureImage($program, $request->input('draft_path'));

        return response()->json([
            'success' => true,
            'url' => \Illuminate\Support\Facades\Storage::disk('public')->url($finalPath),
        ]);
    }

    /**
     * Deactivate a program (first step before permanent deletion).
     */
    public function deactivate(Program $program)
    {
        $this->managePrograms->deactivate($program);

        return back()->with('success', 'Program "' . $program->name . '" has been deactivated. You can now delete it permanently.');
    }

    /**
     * Quick toggle between Active/Not Active from the programs list, without
     * going through the deactivate-then-delete flow above.
     */
    public function toggleActive(Program $program)
    {
        $program = $this->managePrograms->toggleActive($program);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'program' => $program]);
        }

        return back()->with('success', 'Program "' . $program->name . '" is now ' . ($program->is_active ? 'Active' : 'Not Active') . '.');
    }

    /**
     * Sets which meeting is "current" for this program - a plain pacing
     * counter for admin/teacher's own reference (see the floating
     * meeting-progress-bar component on meeting pages), not an
     * access-control flag. Students never get to change this.
     */
    public function updateCurrentMeeting(\Illuminate\Http\Request $request, Program $program)
    {
        $user = auth()->user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['meeting_number' => 'nullable|integer|min:0']);

        $meetingNumber = $request->input('meeting_number');
        $val = ($meetingNumber !== null && (int)$meetingNumber > 0) ? (int)$meetingNumber : null;
        $program->update(['current_meeting_number' => $val]);

        return response()->json(['success' => true, 'current_meeting_number' => $program->current_meeting_number]);
    }

    /**
     * Permanently delete the program (only allowed if already inactive).
     */
    public function destroy(Program $program)
    {
        // Guard: must be deactivated first
        if ($program->is_active) {
            return back()->with('error', 'Program must be deactivated before it can be permanently deleted. Click "Deactivate" first.');
        }

        // Guard: cannot delete if there are active students enrolled.
        // Checks three separate signals because a student can be tied to a program
        // through any of them independently: users.program_id (set by the payment/
        // conversion flow), an Enrollment record, or class_period_id (set by the
        // admin "assign student to class period" action, which never touches
        // users.program_id or creates an Enrollment).
        $classPeriodIds = $program->classPeriods()->pluck('id');

        $hasActiveUsers = User::where('role', 'student')
            ->where('status', 'active')
            ->where(function ($query) use ($program, $classPeriodIds) {
                $query->where('program_id', $program->id)
                    ->orWhereIn('class_period_id', $classPeriodIds);
            })
            ->exists();

        $hasActiveEnrollments = $program->enrollments()->where('status', 'active')->exists();

        if ($hasActiveUsers || $hasActiveEnrollments) {
            return back()->with('error', 'Cannot delete program. There are active students, enrollments, or class period assignments associated with it.');
        }

        $programName = $program->name;
        $programName = $this->managePrograms->delete($program);

        return back()->with('success', "Program \"$programName\" has been permanently deleted.");
    }


    /**
     * Display the syllabus builder for a program.
     */
    public function syllabus(Program $program)
    {
        ['program' => $program, 'meetings' => $meetings] = $this->managePrograms->getSyllabus($program);
        return view('admin.programs.syllabus', compact('program', 'meetings'));
    }

    /**
     * Store a new meeting in the syllabus.
     */
    public function storeSyllabus(ProgramSyllabusStoreRequest $request, Program $program)
    {
        $validated = $request->validated();

        $this->managePrograms->addMeeting($program, [
            'title' => $validated['title'],
            'is_locked' => $request->has('is_locked') ? $request->is_locked : false,
        ]);

        return back()->with('success', 'Meeting added successfully.');
    }

    /**
     * Update an existing meeting in the syllabus.
     */
    public function updateSyllabus(ProgramSyllabusStoreRequest $request, Program $program, Meeting $meeting)
    {
        if ($meeting->program_id !== $program->id) {
            abort(404);
        }

        $validated = $request->validated();

        $this->managePrograms->updateMeeting($program, $meeting, [
            'title' => $validated['title'],
            'is_locked' => $request->has('is_locked') ? $request->is_locked : false,
        ]);

        return back()->with('success', 'Meeting updated successfully.');
    }

    /**
     * Remove a meeting from the syllabus.
     */
    public function destroySyllabus(Program $program, Meeting $meeting)
    {
        if ($meeting->program_id !== $program->id) {
            abort(404);
        }

        $this->managePrograms->deleteMeeting($meeting);

        return back()->with('success', 'Meeting deleted successfully.');
    }

    /**
     * Reorder syllabus meetings by drag-and-drop.
     */
    public function reorderSyllabus(ProgramSyllabusReorderRequest $request, Program $program)
    {
        $validated = $request->validated();

        $this->managePrograms->reorderMeetings($program, $validated['order']);

        return response()->json(['success' => true]);
    }
}
