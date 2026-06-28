<?php

namespace App\Application\ClassPeriod;

use App\Domain\ClassPeriod\Repositories\ClassPeriodRepository;
use Carbon\Carbon;

class ManageClassPeriods
{
    public function __construct(
        private readonly ClassPeriodRepository $repository
    ) {}

    public function listAll(array $filters = []): mixed
    {
        return $this->repository->listWithCounts($filters);
    }

    public function create(array $data): mixed
    {
        if (empty($data['batch_number']) && !empty($data['program_id'])) {
            $data['batch_number'] = $this->repository->getNextBatchNumber($data['program_id']);
        }
        $data = $this->resolveName($data);
        return $this->repository->create($data);
    }

    public function show(mixed $classPeriod): array
    {
        $classPeriod->load('users', 'program.meetings', 'teacher');
        $meetings = $classPeriod->program ? $classPeriod->program->meetings : collect();
        $pivotData = $this->repository->getMeetingPivotStatus($classPeriod);

        $meetings->transform(function ($meeting) use ($pivotData) {
            $meeting->is_open_for_period = $pivotData[$meeting->id] ?? false;
            return $meeting;
        });

        $allStudents = $this->repository->getAllStudents();

        return compact('classPeriod', 'meetings', 'allStudents');
    }

    public function update(mixed $classPeriod, array $data): void
    {
        $data = $this->resolveName($data);
        $this->repository->update($classPeriod, $data);
    }

    public function delete(mixed $classPeriod): void
    {
        $this->repository->delete($classPeriod);
    }

    public function toggleMeeting(mixed $classPeriod, mixed $meeting): void
    {
        $pivot = $classPeriod->meetings()->where('meeting_id', $meeting->id)->first();

        if ($pivot) {
            $this->repository->toggleMeeting($classPeriod, $meeting->id, (bool) $pivot->pivot->is_open);
        } else {
            $this->repository->attachMeeting($classPeriod, $meeting->id, true);
        }
    }

    public function assignStudent(mixed $classPeriod, int $userId): void
    {
        $user = $this->repository->findStudentOrFail($userId);
        $this->repository->assignStudent($classPeriod, $user);
    }

    public function removeStudent(mixed $classPeriod, mixed $user): bool
    {
        if ($user->class_period_id !== $classPeriod->id) {
            return false;
        }
        $this->repository->removeStudent($classPeriod, $user);
        return true;
    }

    public function getNextBatchNumber(int $programId): int
    {
        return $this->repository->getNextBatchNumber($programId);
    }

    public function findOrFail(int $id): mixed
    {
        return $this->repository->findOrFail($id);
    }

    public function updateStatus(mixed $classPeriod, string $status): void
    {
        $this->repository->update($classPeriod, ['status' => $status]);
    }

    private function resolveName(array $data): array
    {
        if (empty($data['name'])) {
            $start = Carbon::parse($data['start_date'])->translatedFormat('d M Y');
            $end = Carbon::parse($data['end_date'])->translatedFormat('d M Y');
            $batchStr = !empty($data['batch_number']) ? "Batch {$data['batch_number']} - " : "Batch ";
            $data['name'] = "{$batchStr}{$start} to {$end}";
        }
        return $data;
    }
}
