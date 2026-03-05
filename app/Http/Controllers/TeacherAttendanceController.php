<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassPeriod;
use App\Models\ClassMeeting;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class TeacherAttendanceController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Get class periods where the teacher has students
        $classPeriods = ClassPeriod::whereHas('users', function ($query) {
            $query->where('role', 'student');
        })->get();

        return view('teacher.attendance.index', compact('classPeriods'), [
            'pageTitle' => 'My Class Attendance'
        ]);
    }

    public function getMeetings(ClassPeriod $classPeriod)
    {
        $meetings = $classPeriod->classMeetings()->orderBy('meeting_number')->get();
        return response()->json($meetings);
    }

    public function getAttendance(ClassMeeting $classMeeting)
    {
        // Get all students in the class
        $students = $classMeeting->classPeriod->users()->where('role', 'student')->get();
        
        // Get existing attendance records for this meeting
        $attendances = $classMeeting->attendances()->get()->keyBy('user_id');

        $data = $students->map(function ($student) use ($attendances) {
            $record = $attendances->get($student->id);
            return [
                'id' => $student->id,
                'name' => $student->name,
                'status' => $record ? $record->status : '',
                'notes' => $record ? $record->notes : '',
            ];
        });

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

        foreach ($validated['attendance'] as $userId => $data) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $userId,
                    'class_meeting_id' => $meetingId,
                ],
                [
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'recorded_by' => $recorderId,
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Attendance saved successfully']);
    }
}
