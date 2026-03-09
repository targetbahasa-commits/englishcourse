<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassPeriod;
use App\Models\Meeting;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class ClassPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ClassPeriod::withCount('users')->latest();

        if ($request->has('program_id') && $request->program_id) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $periods = $query->get();
        
        return view('admin.class-periods.index', compact('periods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,upcoming,closed',
            'learning_mode' => 'required|in:online,offline',
            'batch_type' => 'required|in:regular,private',
        ]);

        $classPeriod = ClassPeriod::create($request->all());

        return back()->with('success', 'Class Period created successfully. You can now manage meetings and students.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassPeriod $classPeriod)
    {
        $classPeriod->load('users', 'program.meetings');
        
        // Get meetings for the program associated with this class period
        // And also fetch their pivot status for THIS class period
        
        $meetings = $classPeriod->program ? $classPeriod->program->meetings : collect();
        
        // We need to attach the "is_open" status to each meeting.
        // We can do this by loading the relationship or querying the pivot table.
        // Let's get the pivot data
        $pivotData = $classPeriod->meetings()->pluck('class_period_meetings.is_open', 'class_period_meetings.meeting_id');
        
        // Map the status to the meetings collection
        $meetings->transform(function($meeting) use ($pivotData) {
            $meeting->is_open_for_period = $pivotData[$meeting->id] ?? false; // Default false (LOCKED)
            return $meeting;
        });

        // For the "Add Student" dropdown
        // Ideally fetch students NOT in any active class or generic pool
        // For simplicity, fetch all students
        $allStudents = User::where('role', 'student')->get();

        return view('admin.class-periods.show', compact('classPeriod', 'meetings', 'allStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassPeriod $classPeriod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,upcoming,closed',
            'learning_mode' => 'required|in:online,offline',
            'batch_type' => 'required|in:regular,private',
        ]);

        $classPeriod->update($request->all());

        return back()->with('success', 'Class Period updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassPeriod $classPeriod)
    {
        $classPeriod->delete();
        return redirect()->route('admin.class-periods.index')
            ->with('success', 'Class Period deleted successfully.');
    }

    // --- Custom Methods ---

    public function toggleMeeting(Request $request, ClassPeriod $classPeriod, Meeting $meeting)
    {
        // Toggle the is_open status in the pivot table
        // First check if exists
        $pivot = $classPeriod->meetings()->where('meeting_id', $meeting->id)->first();
        
        if ($pivot) {
           // Toggle
           $newStatus = !$pivot->pivot->is_open;
           $classPeriod->meetings()->updateExistingPivot($meeting->id, ['is_open' => $newStatus]);
        } else {
           // Create (Default is locked, so if we are toggling, we probably want to OPEN it, since default "non-existent" is effectively locked)
           // Wait, logic in model is: "No rule exists => LOCKED".
           // So creating an entry with is_open = true unlocks it.
           // If we toggle, we assume from "LOCKED" (non-existent) to "OPEN".
           $classPeriod->meetings()->attach($meeting->id, ['is_open' => true]);
        }

        return back()->with('success', 'Meeting status updated.');
    }

    public function assignStudent(Request $request, ClassPeriod $classPeriod)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        
        // Award referral points if this is the user's first time being assigned to a class
        if (is_null($user->class_period_id) && $user->referred_by_id) {
            $referrer = User::find($user->referred_by_id);
            if ($referrer) {
                // Award 50 points per successful referral
                $referrer->increment('referral_points', 50);
            }
        }

        $user->update(['class_period_id' => $classPeriod->id]);

        return back()->with('success', 'Student assigned to class period.');
    }
    
    public function updateStatus(Request $request, ClassPeriod $classPeriod)
    {
        $request->validate([
            'status' => 'required|in:active,upcoming,closed',
        ]);

        $classPeriod->update(['status' => $request->status]);

        return back()->with('success', "Status updated to " . ucfirst($request->status));
    }

    public function removeStudent(ClassPeriod $classPeriod, User $user)
    {
        if ($user->class_period_id === $classPeriod->id) {
            $user->update(['class_period_id' => null]);
            return back()->with('success', 'Student removed from class period.');
        }
        return back()->with('error', 'Student does not belong to this class period.');
    }
}
