<?php

namespace App\Infrastructure\IeltsShared;

use App\Domain\IeltsShared\Repositories\IeltsSharedRepository;
use App\Models\Enrollment;
use App\Models\IeltsListeningMockup;
use App\Models\Meeting;
use App\Models\Program;

class EloquentIeltsSharedRepository implements IeltsSharedRepository
{
    public function findProgramByIdWithClassPeriods(int $programId): mixed
    {
        return Program::with('classPeriods')->find($programId);
    }

    public function findFirstIeltsProgramWithClassPeriods(): mixed
    {
        return Program::with('classPeriods')
            ->whereIn('slug', ['ielts-academic', 'ielts-academic-listening', 'ielts-academic-reading'])
            ->orderByRaw("CASE slug
                WHEN 'ielts-academic' THEN 1
                WHEN 'ielts-academic-listening' THEN 2
                WHEN 'ielts-academic-reading' THEN 3
                ELSE 4
            END")
            ->first();
    }

    public function findMeetingOrFail(int $id): mixed
    {
        return Meeting::findOrFail($id);
    }

    public function updateMeeting(int $id, array $data): void
    {
        Meeting::findOrFail($id)->update($data);
    }

    public function deleteMeeting(int $id): void
    {
        Meeting::destroy($id);
    }

    public function hasEnrollmentForPrograms(int $userId, string $editionSlug, ?string $testSlug): bool
    {
        return Enrollment::where('user_id', $userId)
            ->whereIn('status', ['active', 'completed'])
            ->whereHas('program', function ($query) use ($editionSlug, $testSlug) {
                $query->where('slug', $editionSlug);
                if ($testSlug) {
                    $query->orWhere('slug', $testSlug);
                }
            })
            ->exists();
    }

    public function findOrCreateMockupByTestId(string $testId): mixed
    {
        return IeltsListeningMockup::firstOrCreate(['test_id' => $testId]);
    }

    public function toggleMeetingLock(int $id): void
    {
        $meeting = Meeting::findOrFail($id);
        $meeting->is_locked = !$meeting->is_locked;
        $meeting->save();
    }
}
