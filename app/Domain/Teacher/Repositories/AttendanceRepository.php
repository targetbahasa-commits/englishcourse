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

    public function createClassMeeting(int $classPeriodId, array $data): mixed;

    public function updateClassMeeting(int $classMeetingId, array $data): mixed;

    public function deleteClassMeeting(int $classMeetingId): void;

    // Admin-level methods
    public function getAttendanceSummaryForMeeting(int $classMeetingId): array;

    public function bulkSaveAttendance(int $meetingId, array $attendanceData, int $recorderId): void;

    // Batch-level methods
    public function getAllBatches(): array;

    public function getClassPeriodsByBatch(string $batchType, ?int $batchNumber = null): array;

    public function getMeetingsByBatch(string $batchType, ?int $batchNumber = null): array;

    public function getStudentsByBatch(string $batchType, ?int $batchNumber = null): array;
}
