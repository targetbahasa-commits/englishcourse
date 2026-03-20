<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Meeting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'name'           => 'required|string|max:255',
            'period'         => 'required|string|max:255',
            'description'    => 'required|string',
            'price'          => 'nullable|numeric|min:0',
            'brochure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'brochure_pdf'   => 'nullable|mimes:pdf|max:20480',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('brochure_image')) {
            $validated['brochure_image'] = $request->file('brochure_image')->store('brochures', 'public');
        }
        if ($request->hasFile('brochure_pdf')) {
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('brochures', 'public');
        }

        Program::create($validated);

        return back()->with('success', 'Program created successfully.');
    }

    /**
     * Update the specified program in storage.
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'period'         => 'required|string|max:255',
            'description'    => 'required|string',
            'price'          => 'nullable|numeric|min:0',
            'brochure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'brochure_pdf'   => 'nullable|mimes:pdf|max:20480',
        ]);

        if ($validated['name'] !== $program->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('brochure_image')) {
            if ($program->brochure_image) Storage::disk('public')->delete($program->brochure_image);
            $validated['brochure_image'] = $request->file('brochure_image')->store('brochures', 'public');
        }
        if ($request->hasFile('brochure_pdf')) {
            if ($program->brochure_pdf) Storage::disk('public')->delete($program->brochure_pdf);
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('brochures', 'public');
        }

        // Delete brochure if checkbox checked
        if ($request->has('remove_brochure_image') && $program->brochure_image) {
            Storage::disk('public')->delete($program->brochure_image);
            $validated['brochure_image'] = null;
        }
        if ($request->has('remove_brochure_pdf') && $program->brochure_pdf) {
            Storage::disk('public')->delete($program->brochure_pdf);
            $validated['brochure_pdf'] = null;
        }

        $program->update($validated);

        return back()->with('success', 'Program updated successfully.');
    }

    /**
     * Show the brochure management page for a program.
     */
    public function brochure(Program $program)
    {
        return view('admin.programs.brochure', compact('program'));
    }

    /**
     * Update brochure files (image and/or pdf) for a program.
     */
    public function updateBrochure(Request $request, Program $program)
    {
        $request->validate([
            'brochure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'brochure_pdf'   => 'nullable|mimes:pdf|max:20480',
        ]);

        $data = [];

        if ($request->hasFile('brochure_image')) {
            if ($program->brochure_image) Storage::disk('public')->delete($program->brochure_image);
            $data['brochure_image'] = $request->file('brochure_image')->store('brochures', 'public');
        }
        if ($request->hasFile('brochure_pdf')) {
            if ($program->brochure_pdf) Storage::disk('public')->delete($program->brochure_pdf);
            $data['brochure_pdf'] = $request->file('brochure_pdf')->store('brochures', 'public');
        }
        if ($request->has('remove_brochure_image') && $program->brochure_image) {
            Storage::disk('public')->delete($program->brochure_image);
            $data['brochure_image'] = null;
        }
        if ($request->has('remove_brochure_pdf') && $program->brochure_pdf) {
            Storage::disk('public')->delete($program->brochure_pdf);
            $data['brochure_pdf'] = null;
        }

        if (!empty($data)) {
            $program->update($data);
        }

        return back()->with('success', 'Brosur berhasil diperbarui!');
    }

    /**
     * Deactivate a program (first step before permanent deletion).
     */
    public function deactivate(Program $program)
    {
        $program->update(['is_active' => false]);

        return back()->with('success', 'Program "' . $program->name . '" has been deactivated. You can now delete it permanently.');
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

        // Guard: cannot delete if there are active students enrolled
        $activeUsers = $program->users()->where('role', 'student')->where('status', 'active')->count();
        if ($activeUsers > 0) {
            return back()->with('error', "Cannot delete program. There are $activeUsers active students currently enrolled.");
        }

        $programName = $program->name;
        $program->delete();

        return back()->with('success', "Program \"$programName\" has been permanently deleted.");
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
