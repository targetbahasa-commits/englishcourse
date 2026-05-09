<?php

namespace App\Http\Controllers\Admin;

use App\Application\Attendance\ManageAdminAttendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassMeeting;
use App\Models\ClassPeriod;

class AttendanceController extends Controller
{
    public function __construct(
        private readonly ManageAdminAttendance $manageAdminAttendance
    ) {}

    public function index()
    {
        $classPeriods = $this->manageAdminAttendance->getClassPeriodsWithStudents();

        return view('admin.attendance.index', compact('classPeriods'));
    }

    public function getMeetings(ClassPeriod $classPeriod)
    {
        $meetings = $this->manageAdminAttendance->getMeetingsForPeriod($classPeriod->id);
        return response()->json($meetings);
    }

    public function getAttendance(ClassMeeting $classMeeting)
    {
        $data = $this->manageAdminAttendance->getAttendanceSummary($classMeeting->id);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_meeting_id' => 'required|exists:class_meetings,id',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.notes' => 'nullable|string',
        ]);

        $meetingId = $validated['class_meeting_id'];
        $recorderId = Auth::id();

        $this->manageAdminAttendance->saveAttendance($meetingId, $validated['attendance'], $recorderId);

        return response()->json(['success' => true, 'message' => 'Attendance saved successfully']);
    }
}
