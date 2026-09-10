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
        $meetings = $this->manageAttendance->getMeetings($classPeriod->id) ?? [];

        $user = Auth::user();
        $canEdit = false;
        if ($user) {
            $canEdit = $user->isAdmin() || ($user->isTeacher() && $classPeriod->teacher_id === $user->id);
        }

        $payload = array_map(function ($m) use ($canEdit) {
            return [
                'id' => $m->id ?? null,
                'meeting_number' => $m->meeting_number ?? null,
                'topic' => $m->topic ?? null,
                'meeting_date' => isset($m->meeting_date) ? (string) $m->meeting_date : null,
                'start_time' => isset($m->start_time) ? (string) $m->start_time : null,
                'end_time' => isset($m->end_time) ? (string) $m->end_time : null,
                'class_period_id' => $m->class_period_id ?? null,
                'can_edit' => $canEdit,
            ];
        }, $meetings ?: []);

        return response()->json($payload);
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

        $classMeeting = ClassMeeting::with('classPeriod')->findOrFail($validated['class_meeting_id']);

        $user = Auth::user();
        $isAuthorized = $user && ($user->isAdmin() || ($user->isTeacher() && $classMeeting->classPeriod && $classMeeting->classPeriod->teacher_id === $user->id));

        if (! $isAuthorized) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $this->manageAttendance->saveAttendances(
            (int) $validated['class_meeting_id'],
            $validated['attendance'],
            Auth::id()
        );

        return response()->json(['success' => true, 'message' => 'Attendance saved successfully']);
    }

    public function updateMeeting(ClassMeeting $classMeeting, Request $request)
    {
        $validated = $request->validate([
            'meeting_date' => 'required|date',
        ]);

        $user = Auth::user();
        $isAuthorized = $user && ($user->isAdmin() || ($user->isTeacher() && $classMeeting->classPeriod && $classMeeting->classPeriod->teacher_id === $user->id));

        if (! $isAuthorized) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $meeting = $this->manageAttendance->updateMeeting($classMeeting->id, $validated);

        return response()->json([
            'success' => true,
            'meeting' => [
                'id' => $meeting->id,
                'meeting_number' => $meeting->meeting_number,
                'topic' => $meeting->topic,
                'meeting_date' => (string) $meeting->meeting_date,
                'start_time' => isset($meeting->start_time) ? (string) $meeting->start_time : null,
                'end_time' => isset($meeting->end_time) ? (string) $meeting->end_time : null,
                'class_period_id' => $meeting->class_period_id,
                'can_edit' => true,
            ]
        ]);
    }
}
