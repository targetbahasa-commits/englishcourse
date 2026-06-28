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
        return ClassPeriod::where(function ($q) {
            $q->whereHas('users', function ($uq) {
                $uq->where('role', 'student');
            })->orWhereHas('enrollments', function ($eq) {
                $eq->whereHas('user', function ($uq) {
                    $uq->where('role', 'student');
                });
            });
        })->get()->all();
    }

    public function getClassMeetings(int $classPeriodId): array
    {
        $classPeriod = ClassPeriod::with(['classMeetings', 'program.meetings'])->find($classPeriodId);
        
        if (!$classPeriod) {
            return [];
        }

        // Auto-generate ClassMeeting records if they don't exist, but only if program has defined meetings
        if ($classPeriod->classMeetings->isEmpty() && $classPeriod->program && $classPeriod->program->meetings->isNotEmpty()) {
            foreach ($classPeriod->program->meetings as $meeting) {
                \App\Models\ClassMeeting::create([
                    'class_period_id' => $classPeriod->id,
                    'meeting_id'      => $meeting->id,
                    'meeting_number'  => $meeting->meeting_number,
                    'topic'           => $meeting->title ?? $meeting->topic ?? ('Meeting ' . $meeting->meeting_number),
                ]);
            }
            $classPeriod->load('classMeetings'); // reload newly created
        }

        return $classPeriod->classMeetings()->orderBy('meeting_number')->get()->all();
    }

    public function getStudentsInClass(int $classPeriodId): array
    {
        $legacyUsers = ClassPeriod::find($classPeriodId)->users()->where('role', 'student')->get();
        
        $enrolledUsers = \App\Models\User::whereHas('enrollments', function ($q) use ($classPeriodId) {
            $q->where('class_period_id', $classPeriodId);
        })->where('role', 'student')->get();

        return $legacyUsers->concat($enrolledUsers)->unique('id')->values()->all();
    }

    public function getAttendances(int $classMeetingId): array
    {
        return Attendance::where('class_meeting_id', $classMeetingId)->get()->all();
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

    public function createClassMeeting(int $classPeriodId, array $data): mixed
    {
        $maxNumber = ClassMeeting::where('class_period_id', $classPeriodId)->max('meeting_number') ?? 0;

        return ClassMeeting::create([
            'class_period_id' => $classPeriodId,
            'meeting_number'  => $maxNumber + 1,
            'topic'           => $data['topic'],
            'meeting_date'    => $data['meeting_date'] ?? null,
        ]);
    }

    public function updateClassMeeting(int $classMeetingId, array $data): mixed
    {
        $meeting = ClassMeeting::findOrFail($classMeetingId);
        $meeting->update(array_filter($data, fn ($value) => !is_null($value)));
        return $meeting;
    }

    public function deleteClassMeeting(int $classMeetingId): void
    {
        $meeting = ClassMeeting::findOrFail($classMeetingId);

        if ($meeting->attendances()->count() > 0) {
            throw new \RuntimeException('Cannot delete a meeting that already has attendance records.');
        }

        $meeting->delete();
    }

    public function getAttendanceSummaryForMeeting(int $classMeetingId): array
    {
        $classMeeting = ClassMeeting::with('classPeriod')->find($classMeetingId);
        if (!$classMeeting) {
            return [];
        }

        $students = collect($this->getStudentsInClass($classMeeting->class_period_id));
        $attendances = collect($this->getAttendances($classMeetingId))->keyBy('user_id');

        return $students->map(function ($student) use ($attendances) {
            $attendance = $attendances->get($student->id);
            return [
                'id' => $student->id,
                'name' => $student->name,
                'status' => $attendance ? $attendance->status : null,
                'notes' => $attendance ? $attendance->notes : null,
            ];
        })->values()->all();
    }

    public function bulkSaveAttendance(int $meetingId, array $attendanceData, int $recorderId): void
    {
        foreach ($attendanceData as $userId => $data) {
            Attendance::updateOrCreate(
                [
                    'class_meeting_id' => $meetingId,
                    'user_id' => $userId
                ],
                [
                    'status'      => $data['status'],
                    'notes'       => $data['notes'] ?? null,
                    'recorded_by' => $recorderId,
                ]
            );
        }
    }

    public function getAllBatches(): array
    {
        return ClassPeriod::select('batch_type', 'batch_number')
            ->distinct()
            ->orderBy('batch_type')
            ->orderBy('batch_number')
            ->get()
            ->groupBy('batch_type')
            ->map(function ($items) {
                return $items->pluck('batch_number')->filter()->unique()->values()->all();
            })
            ->toArray();
    }

    public function getClassPeriodsByBatch(string $batchType, ?int $batchNumber = null): array
    {
        $query = ClassPeriod::where('batch_type', $batchType);
        
        if ($batchNumber !== null) {
            $query->where('batch_number', $batchNumber);
        }
        
        return $query->where(function ($q) {
            $q->whereHas('users', function ($uq) {
                $uq->where('role', 'student');
            })->orWhereHas('enrollments', function ($eq) {
                $eq->whereHas('user', function ($uq) {
                    $uq->where('role', 'student');
                });
            });
        })->get()->all();
    }

    public function getMeetingsByBatch(string $batchType, ?int $batchNumber = null): array
    {
        $classPeriods = $this->getClassPeriodsByBatch($batchType, $batchNumber);
        $classPeriodIds = collect($classPeriods)->pluck('id')->toArray();

        // Force auto-generation if missing
        foreach ($classPeriodIds as $cpId) {
            $this->getClassMeetings($cpId);
        }

        return ClassMeeting::whereIn('class_period_id', $classPeriodIds)
            ->orderBy('class_period_id')
            ->orderBy('meeting_number')
            ->get()
            ->all();
    }

    public function getStudentsByBatch(string $batchType, ?int $batchNumber = null): array
    {
        $classPeriods = $this->getClassPeriodsByBatch($batchType, $batchNumber);
        $classPeriodIds = collect($classPeriods)->pluck('id')->toArray();

        return \App\Models\User::whereIn('class_period_id', $classPeriodIds)
            ->where('role', 'student')
            ->distinct()
            ->get()
            ->all();
    }
}
