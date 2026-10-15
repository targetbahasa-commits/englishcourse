<?php

namespace App\Infrastructure\ClassPeriod;

use App\Domain\ClassPeriod\Repositories\ClassPeriodRepository;
use App\Models\ClassPeriod;
use App\Models\User;

class EloquentClassPeriodRepository implements ClassPeriodRepository
{
    public function listWithCounts(array $filters): array
    {
        $query = ClassPeriod::with([
                'teacher',
                'program',
                // Lightweight columns only - this feeds the expandable
                // "who's in this batch" row in the admin list, not a full
                // student profile view.
                //
                // Two sources, both needed: 'users' is the legacy single
                // class_period_id FK on the users table - still the only
                // record for ~11 students who predate the enrollments
                // table. 'enrollments.user' is the real per-program link a
                // student enrolled in multiple programs actually has (one
                // Enrollment row per program/batch). Neither alone is
                // complete; the view merges and dedupes both by user id.
                'users' => fn ($q) => $q->select('users.id', 'users.name', 'users.email', 'users.class_period_id'),
                'enrollments' => fn ($q) => $q->whereIn('status', ['active', 'completed']),
                'enrollments.user' => fn ($q) => $q->select('users.id', 'users.name', 'users.email'),
            ])
            ->withCount([
                'users',
                'enrollments as booked_count' => function ($q) {
                    $q->where('status', 'active')->whereNotNull('class_period_booked_at');
                },
            ])
            ->latest();

        if (!empty($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get()->all();
    }

    public function getNextBatchNumber(int $programId): int
    {
        return (int) ClassPeriod::where('program_id', $programId)->max('batch_number') + 1;
    }

    public function create(array $data): mixed
    {
        return ClassPeriod::create($data);
    }

    public function findOrFail(int $id): mixed
    {
        return ClassPeriod::findOrFail($id);
    }

    public function update(mixed $classPeriod, array $data): void
    {
        $classPeriod->update($data);
    }

    public function delete(mixed $classPeriod): void
    {
        $classPeriod->delete();
    }

    public function getAllStudents(): array
    {
        return User::where('role', 'student')->get()->all();
    }

    public function getMeetingPivotStatus(mixed $classPeriod): array
    {
        return $classPeriod->meetings()
            ->pluck('class_period_meetings.is_open', 'class_period_meetings.meeting_id')
            ->toArray();
    }

    public function toggleMeeting(mixed $classPeriod, int $meetingId, bool $currentStatus): void
    {
        $classPeriod->meetings()->updateExistingPivot($meetingId, ['is_open' => !$currentStatus]);
    }

    public function attachMeeting(mixed $classPeriod, int $meetingId, bool $isOpen): void
    {
        $classPeriod->meetings()->attach($meetingId, ['is_open' => $isOpen]);
    }

    public function findStudentOrFail(int $userId): mixed
    {
        return User::findOrFail($userId);
    }

    public function assignStudent(mixed $classPeriod, mixed $user): void
    {
        // Award referral points if this is the user's first time being assigned to a class
        if (is_null($user->class_period_id) && $user->referred_by_id) {
            $referrer = User::find($user->referred_by_id);
            if ($referrer) {
                $referrer->increment('referral_points', 50);
            }
        }

        $user->update(['class_period_id' => $classPeriod->id]);
    }

    public function removeStudent(mixed $classPeriod, mixed $user): void
    {
        if ($user->class_period_id === $classPeriod->id) {
            $user->update(['class_period_id' => null]);
        }
    }
}
