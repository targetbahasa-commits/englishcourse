<?php

namespace App\Http\Controllers;

use App\Application\Teacher\ManageAttendance;
use App\Models\ClassMeeting;
use App\Models\ClassPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAttendanceController extends Controller
{
    public function __construct(
        private readonly ManageAttendance $manageAttendance,
    ) {
    }

    public function index()
    {
        $classPeriods = $this->manageAttendance->getClassPeriods();

        return view('teacher.attendance.index', compact('classPeriods'), [
            'pageTitle' => 'My Class Attendance'
        ]);
    }

    public function getMeetings(ClassPeriod $classPeriod)
    {
        $meetings = $this->manageAttendance->getMeetings($classPeriod->id);
        return response()->json($meetings);
    }

    public function getAttendance(ClassMeeting $classMeeting)
    {
        $data = $this->manageAttendance->getAttendanceData($classMeeting->id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_meeting_id' => 'required|exists:class_meetings,id',
            'attendance'       => 'required|array',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.notes'  => 'nullable|string',
        ]);

        $this->manageAttendance->saveAttendances(
            (int) $validated['class_meeting_id'],
            $validated['attendance'],
            Auth::id()
        );

        return response()->json(['success' => true, 'message' => 'Attendance saved successfully']);
    }
}
