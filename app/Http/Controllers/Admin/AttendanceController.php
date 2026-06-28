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
        $batches = $this->manageAdminAttendance->getAllBatches();

        return view('admin.attendance.index', compact('classPeriods', 'batches'));
    }

    public function getMeetings(ClassPeriod $classPeriod)
    {
        $meetings = $this->manageAdminAttendance->getMeetingsForPeriod($classPeriod->id);

        $payload = array_map(function ($m) {
            return [
                'id'             => $m->id,
                'meeting_number' => $m->meeting_number,
                'topic'          => $m->topic,
                'meeting_date'   => $m->meeting_date ? (string) $m->meeting_date : null,
                'class_period_id'=> $m->class_period_id,
            ];
        }, $meetings);

        return response()->json($payload);
    }

    public function getAttendance(ClassMeeting $classMeeting)
    {
        $data = $this->manageAdminAttendance->getAttendanceSummary($classMeeting->id);
        return response()->json($data);
    }

    public function getBatchInfo(string $batchType, ?int $batchNumber = null)
    {
        $classPeriods = $this->manageAdminAttendance->getClassPeriodsByBatch($batchType, $batchNumber);
        $students     = $this->manageAdminAttendance->getStudentsByBatch($batchType, $batchNumber);

        return response()->json([
            'class_periods' => $classPeriods,
            'students'      => $students,
            'count'         => [
                'classes'  => count($classPeriods),
                'students' => count($students),
            ],
        ]);
    }

    public function getClassesByBatch(string $batchType, ?int $batchNumber = null)
    {
        $classPeriods = $this->manageAdminAttendance->getClassPeriodsByBatch($batchType, $batchNumber);
        return response()->json($classPeriods);
    }

    public function getMeetingsByBatch(string $batchType, ?int $batchNumber = null)
    {
        $meetings = $this->manageAdminAttendance->getMeetingsByBatch($batchType, $batchNumber);
        return response()->json($meetings);
    }

    public function getStudentsByBatch(string $batchType, ?int $batchNumber = null)
    {
        $students = $this->manageAdminAttendance->getStudentsByBatch($batchType, $batchNumber);
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_meeting_id'        => 'required|exists:class_meetings,id',
            'attendance'              => 'required|array',
            'attendance.*.status'     => 'required|in:present,absent,late,excused',
            'attendance.*.notes'      => 'nullable|string',
        ]);

        $meetingId  = $validated['class_meeting_id'];
        $recorderId = Auth::id();

        $this->manageAdminAttendance->saveAttendance($meetingId, $validated['attendance'], $recorderId);

        return response()->json(['success' => true, 'message' => 'Attendance saved successfully']);
    }

    /**
     * Create a new ClassMeeting for a class period (for programs without predefined meetings).
     */
    public function createMeeting(ClassPeriod $classPeriod, Request $request)
    {
        $validated = $request->validate([
            'topic'          => 'required|string|max:255',
            'meeting_date'   => 'nullable|date',
        ]);

        $meeting = $this->manageAdminAttendance->createMeeting($classPeriod->id, $validated);

        return response()->json([
            'success' => true,
            'meeting' => [
                'id'             => $meeting->id,
                'meeting_number' => $meeting->meeting_number,
                'topic'          => $meeting->topic,
                'meeting_date'   => $meeting->meeting_date ? (string) $meeting->meeting_date : null,
                'class_period_id'=> $meeting->class_period_id,
            ],
        ]);
    }

    /**
     * Update topic/date of an existing ClassMeeting.
     */
    public function updateMeeting(ClassMeeting $classMeeting, Request $request)
    {
        $validated = $request->validate([
            'topic'        => 'nullable|string|max:255',
            'meeting_date' => 'nullable|date',
        ]);

        $meeting = $this->manageAdminAttendance->updateMeeting($classMeeting->id, $validated);

        return response()->json([
            'success' => true,
            'meeting' => [
                'id'             => $meeting->id,
                'meeting_number' => $meeting->meeting_number,
                'topic'          => $meeting->topic,
                'meeting_date'   => $meeting->meeting_date ? (string) $meeting->meeting_date : null,
                'class_period_id'=> $meeting->class_period_id,
            ],
        ]);
    }

    /**
     * Delete a ClassMeeting (only if no attendance records exist).
     */
    public function deleteMeeting(ClassMeeting $classMeeting)
    {
        try {
            $this->manageAdminAttendance->deleteMeeting($classMeeting->id);
        } catch (\RuntimeException $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 422);
        }

        return response()->json(['success' => true, 'message' => 'Meeting deleted.']);
    }
}
