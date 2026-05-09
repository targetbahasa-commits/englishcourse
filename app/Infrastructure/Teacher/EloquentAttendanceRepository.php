<?php

namespace App\Infrastructure\Teacher;

use App\Domain\Teacher\Repositories\AttendanceRepository;
use App\Models\Attendance;
use App\Models\ClassMeeting;
use App\Models\ClassPeriod;

class EloquentAttendanceRepository implements AttendanceRepository
{
    public function getClassPeriodsForTeacher(): array
    {
        return ClassPeriod::whereHas('users', function ($query) {
            $query->where('role', 'student');
        })->get()->all();
    }

    public function getClassMeetings(int $classPeriodId): array
    {
        return ClassPeriod::find($classPeriodId)->classMeetings()->orderBy('meeting_number')->get()->all();
    }

    public function getStudentsInClass(int $classPeriodId): array
    {
        return ClassPeriod::find($classPeriodId)->users()->where('role', 'student')->get()->all();
    }

    public function getAttendances(int $classMeetingId): array
    {
        return ClassMeeting::find($classMeetingId)->attendances()->get()->all();
    }

    public function saveAttendance(int $classMeetingId, int $userId, array $data, int $recorderId): void
    {
        Attendance::updateOrCreate(
            [
                'user_id'            => $userId,
                'class_meeting_id'   => $classMeetingId,
            ],
            [
                'status'      => $data['status'],
                'notes'       => $data['notes'] ?? null,
                'recorded_by' => $recorderId,
            ]
        );
    }

    public function findClassMeeting(int $id): mixed
    {
        return ClassMeeting::findOrFail($id);
    }

    public function findClassPeriod(int $id): mixed
    {
        return ClassPeriod::findOrFail($id);
    }

    public function getAttendanceSummaryForMeeting(int $classMeetingId): array
    {
        $meeting = ClassMeeting::findOrFail($classMeetingId);
        $students = $meeting->classPeriod->users()->where('role', 'student')->get();
        $attendances = $meeting->attendances()->get()->keyBy('user_id');

        return $students->map(function ($student) use ($attendances) {
            $record = $attendances->get($student->id);
            return [
                'id'     => $student->id,
                'name'   => $student->name,
                'status' => $record ? $record->status : '',
                'notes'  => $record ? $record->notes : '',
            ];
        })->values()->all();
    }

    public function bulkSaveAttendance(int $meetingId, array $attendanceData, int $recorderId): void
    {
        foreach ($attendanceData as $userId => $data) {
            Attendance::updateOrCreate(
                [
                    'user_id'          => $userId,
                    'class_meeting_id' => $meetingId,
                ],
                [
                    'status'      => $data['status'],
                    'notes'       => $data['notes'] ?? null,
                    'recorded_by' => $recorderId,
                ]
            );
        }
    }
}
