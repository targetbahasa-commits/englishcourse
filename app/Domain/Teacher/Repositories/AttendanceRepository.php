<?php

namespace App\Domain\Teacher\Repositories;

interface AttendanceRepository
{
    public function getClassPeriodsForTeacher(): array;

    public function getClassMeetings(int $classPeriodId): array;

    public function getStudentsInClass(int $classPeriodId): array;

    public function getAttendances(int $classMeetingId): array;

    public function saveAttendance(int $classMeetingId, int $userId, array $data, int $recorderId): void;

    public function findClassMeeting(int $id): mixed;

    public function findClassPeriod(int $id): mixed;

    // Admin-level methods
    public function getAttendanceSummaryForMeeting(int $classMeetingId): array;

    public function bulkSaveAttendance(int $meetingId, array $attendanceData, int $recorderId): void;
}
