<?php

namespace App\Application\Attendance;

use App\Domain\Teacher\Repositories\AttendanceRepository;

class ManageAdminAttendance
{
    public function __construct(
        private readonly AttendanceRepository $repository
    ) {}

    public function getClassPeriodsWithStudents(): mixed
    {
        return $this->repository->getClassPeriodsForTeacher();
    }

    public function getMeetingsForPeriod(int $classPeriodId): mixed
    {
        return $this->repository->getClassMeetings($classPeriodId);
    }

    public function getAttendanceSummary(int $classMeetingId): array
    {
        return $this->repository->getAttendanceSummaryForMeeting($classMeetingId);
    }

    public function saveAttendance(int $meetingId, array $attendanceData, int $recorderId): void
    {
        $this->repository->bulkSaveAttendance($meetingId, $attendanceData, $recorderId);
    }
}
