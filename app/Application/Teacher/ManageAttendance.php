<?php

namespace App\Application\Teacher;

use App\Domain\Teacher\Repositories\AttendanceRepository;

class ManageAttendance
{
    public function __construct(
        private readonly AttendanceRepository $repository
    ) {
    }

    public function getClassPeriods(): array
    {
        return $this->repository->getClassPeriodsForTeacher();
    }

    public function getMeetings(int $classPeriodId): array
    {
        return $this->repository->getClassMeetings($classPeriodId);
    }

    public function getStudents(int $classPeriodId): array
    {
        return $this->repository->getStudentsInClass($classPeriodId);
    }

    public function getAttendanceData(int $classMeetingId): array
    {
        $classMeeting = $this->repository->findClassMeeting($classMeetingId);
        $students = collect($this->repository->getStudentsInClass($classMeeting->class_period_id));
        $attendances = collect($this->repository->getAttendances($classMeetingId))->keyBy('user_id');

        return $students->map(function ($student) use ($attendances) {
            $record = $attendances->get($student->id);

            return [
                'id'     => $student->id,
                'name'   => $student->name,
                'status' => $record ? $record->status : '',
                'notes'  => $record ? $record->notes : '',
            ];
        })->all();
    }

    public function saveAttendances(int $classMeetingId, array $attendanceData, int $recorderId): void
    {
        foreach ($attendanceData as $userId => $data) {
            $this->repository->saveAttendance($classMeetingId, (int) $userId, $data, $recorderId);
        }
    }

    public function updateMeeting(int $classMeetingId, array $meetingData): mixed
    {
        return $this->repository->updateClassMeeting($classMeetingId, $meetingData);
    }
}
