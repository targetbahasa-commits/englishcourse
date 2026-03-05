<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Meeting;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Display a listing of the programs.
     */
    public function index()
    {
        // Load programs with counts for analytics
        $programs = Program::with('classPeriods')->withCount([
            'meetings',
            // active_enrollees: count of students assigned to this program whose status is active
            'users as active_enrollees_count' => function ($query) {
                $query->where('role', 'student')->where('status', 'active');
            }
        ])->orderBy('created_at', 'desc')->get();

        return view('admin.programs.index', compact('programs'));
    }

    /**
     * Store a newly created program in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
            'price' => 'nullable|numeric|min:0'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle boolean cast from form checkboxes
        $validated['is_active'] = $request->has('is_active');

        Program::create($validated);

        return back()->with('success', 'Program created successfully.');
    }

    /**
     * Update the specified program in storage.
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
            'price' => 'nullable|numeric|min:0'
        ]);

        // Only update slug if name changed
        if ($validated['name'] !== $program->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle boolean cast from form checkboxes
        $validated['is_active'] = $request->has('is_active');

        $program->update($validated);

        return back()->with('success', 'Program updated successfully.');
    }

    /**
     * Remove or Archive the program.
     */
    public function destroy(Program $program)
    {
        // Avoid deleting programs if they have active users.
        // For phase 1, we will just delete, but ideally this would soft delete or mark as archived.
        $activeUsers = $program->users()->where('role', 'student')->where('status', 'active')->count();

        if ($activeUsers > 0) {
            return back()->with('error', "Cannot delete program. There are $activeUsers active students currently enrolled.");
        }

        $program->delete();
        
        return back()->with('success', 'Program deleted successfully.');
    }

    /**
     * Display the syllabus builder for a program.
     */
    public function syllabus(Program $program)
    {
        $meetings = $program->meetings()->orderBy('meeting_number')->get();
        return view('admin.programs.syllabus', compact('program', 'meetings'));
    }

    /**
     * Store a new meeting in the syllabus.
     */
    public function storeSyllabus(Request $request, Program $program)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'is_locked' => 'boolean',
        ]);

        $maxMeetingNumber = $program->meetings()->max('meeting_number') ?? 0;

        $program->meetings()->create([
            'title' => $validated['title'],
            'meeting_number' => $maxMeetingNumber + 1,
            'is_locked' => $request->has('is_locked') ? $request->is_locked : false,
        ]);

        return back()->with('success', 'Meeting added successfully.');
    }

    /**
     * Update an existing meeting in the syllabus.
     */
    public function updateSyllabus(Request $request, Program $program, Meeting $meeting)
    {
        if ($meeting->program_id !== $program->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'is_locked' => 'boolean',
        ]);

        $meeting->update([
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

        $meeting->delete();

        return back()->with('success', 'Meeting deleted successfully.');
    }

    /**
     * Reorder syllabus meetings by drag-and-drop.
     */
    public function reorderSyllabus(Request $request, Program $program)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:meetings,id',
        ]);

        foreach ($validated['order'] as $index => $meetingId) {
            Meeting::where('id', $meetingId)
                ->where('program_id', $program->id)
                ->update(['meeting_number' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
