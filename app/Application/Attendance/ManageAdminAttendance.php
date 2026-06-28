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

    // Batch methods
    public function getAllBatches(): array
    {
        return $this->repository->getAllBatches();
    }

    public function getClassPeriodsByBatch(string $batchType, ?int $batchNumber = null): array
    {
        return $this->repository->getClassPeriodsByBatch($batchType, $batchNumber);
    }

    public function getMeetingsByBatch(string $batchType, ?int $batchNumber = null): array
    {
        return $this->repository->getMeetingsByBatch($batchType, $batchNumber);
    }

    public function createMeeting(int $classPeriodId, array $meetingData): mixed
    {
        return $this->repository->createClassMeeting($classPeriodId, $meetingData);
    }

    public function updateMeeting(int $classMeetingId, array $meetingData): mixed
    {
        return $this->repository->updateClassMeeting($classMeetingId, $meetingData);
    }

    public function deleteMeeting(int $classMeetingId): void
    {
        $this->repository->deleteClassMeeting($classMeetingId);
    }

    public function getStudentsByBatch(string $batchType, ?int $batchNumber = null): array
    {
        return $this->repository->getStudentsByBatch($batchType, $batchNumber);
    }

    public function getClassPeriodsWithBatch(string $batchType, ?int $batchNumber = null): array
    {
        $classPeriods = $this->getClassPeriodsByBatch($batchType, $batchNumber);
        return array_map(function ($cp) use ($batchType, $batchNumber) {
            $cp->batch_type = $batchType;
            $cp->batch_number = $batchNumber;
            return $cp;
        }, $classPeriods);
    }
}
