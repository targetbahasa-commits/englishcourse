<?php

namespace App\Http\Controllers\Admin;

use App\Application\ClassPeriod\ManageClassPeriods;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassPeriodUpsertRequest;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClassPeriod;

class ClassPeriodController extends Controller
{
    public function __construct(
        private readonly ManageClassPeriods $manageClassPeriods
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periods = $this->manageClassPeriods->listAll($request->only(['program_id', 'status']));
        
        return view('admin.class-periods.index', compact('periods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassPeriodUpsertRequest $request)
    {
        $data = $request->validated();

        $this->manageClassPeriods->create($data);

        return back()->with('success', 'Class Period created successfully. You can now manage meetings and students.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassPeriod $classPeriod)
    {
        ['classPeriod' => $classPeriod, 'meetings' => $meetings, 'allStudents' => $allStudents] = $this->manageClassPeriods->show($classPeriod);

        return view('admin.class-periods.show', compact('classPeriod', 'meetings', 'allStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassPeriodUpsertRequest $request, ClassPeriod $classPeriod)
    {
        $data = $request->validated();

        $this->manageClassPeriods->update($classPeriod, $data);

        return back()->with('success', 'Class Period updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassPeriod $classPeriod)
    {
        $this->manageClassPeriods->delete($classPeriod);
        return back()->with('success', 'Class Period deleted successfully.');
    }

    public function nextBatchNumber(Request $request)
    {
        $request->validate(['program_id' => 'required|exists:programs,id']);
        $next = $this->manageClassPeriods->getNextBatchNumber((int) $request->program_id);
        return response()->json(['next_batch_number' => $next]);
    }

    // --- Custom Methods ---

    public function toggleMeeting(Request $request, ClassPeriod $classPeriod, Meeting $meeting)
    {
          $this->manageClassPeriods->toggleMeeting($classPeriod, $meeting);

        return back()->with('success', 'Meeting status updated.');
    }

    public function assignStudent(Request $request, ClassPeriod $classPeriod)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $this->manageClassPeriods->assignStudent($classPeriod, (int) $request->user_id);

        return back()->with('success', 'Student assigned to class period.');
    }
    
    public function updateStatus(Request $request, ClassPeriod $classPeriod)
    {
        $request->validate([
            'status' => 'required|in:active,upcoming,closed',
        ]);

        $this->manageClassPeriods->updateStatus($classPeriod, $request->status);

        return back()->with('success', "Status updated to " . ucfirst($request->status));
    }

    public function removeStudent(ClassPeriod $classPeriod, User $user)
    {
        if ($this->manageClassPeriods->removeStudent($classPeriod, $user)) {
            return back()->with('success', 'Student removed from class period.');
        }
        return back()->with('error', 'Student does not belong to this class period.');
    }
}
