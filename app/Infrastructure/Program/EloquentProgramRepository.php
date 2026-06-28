<?php

namespace App\Infrastructure\Program;

use App\Domain\Program\Repositories\ProgramRepository;
use App\Models\Meeting;
use App\Models\Program;
use Illuminate\Support\Str;

class EloquentProgramRepository implements ProgramRepository
{
    public function create(array $data): mixed
    {
        return Program::create(array_merge($data, [
            'slug' => Str::slug($data['name']),
        ]));
    }

    public function listWithCounts(): array
    {
        return Program::with(['subprograms', 'classPeriods' => function ($q) {
                $q->withCount('users')->orderBy('created_at', 'desc');
            }])
            ->withCount([
                'meetings',
                'users as active_enrollees_count' => function ($query) {
                    $query->where('role', 'student')->where('status', 'active');
                },
            ])
            ->where('slug', 'not like', 'cambridge-%')
            ->where('slug', 'not like', 'toefl-itp-mock-package-%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->all();
    }

    public function listMockTests(): array
    {
        return Program::with('classPeriods')->withCount([
            'meetings',
            'users as active_enrollees_count' => function ($query) {
                $query->where('role', 'student')->where('status', 'active');
            },
        ])->where(function ($q) {
            $q->where('slug', 'like', 'cambridge-%')
              ->orWhere('slug', 'like', 'toefl-itp-mock-package-%');
        })->orderBy('created_at', 'desc')
          ->get()
          ->all();
    }

    public function syncToeflMockTestPrograms(array $packages): void
    {
        foreach ($packages as $package) {
            Program::updateOrCreate(['slug' => $package['slug']], $package);
        }
    }

    public function findOrFail(int $id): mixed
    {
        return Program::findOrFail($id);
    }

    public function update(mixed $program, array $data): void
    {
        $program->update($data);
    }

    public function deactivate(mixed $program): void
    {
        $program->update(['is_active' => false]);
    }

    public function delete(mixed $program): void
    {
        $program->delete();
    }

    public function getMeetingsForSyllabus(mixed $program): array
    {
        return $program->meetings()->orderBy('meeting_number')->get()->all();
    }

    public function addMeeting(mixed $program, array $data): void
    {
        $maxMeetingNumber = $program->meetings()->max('meeting_number') ?? 0;
        $program->meetings()->create([
            'title'          => $data['title'],
            'meeting_number' => $maxMeetingNumber + 1,
            'is_locked'      => $data['is_locked'] ?? false,
        ]);
    }

    public function updateMeeting(mixed $meeting, array $data): void
    {
        $meeting->update([
            'title'     => $data['title'],
            'is_locked' => $data['is_locked'] ?? false,
        ]);
    }

    public function deleteMeeting(mixed $meeting): void
    {
        $meeting->delete();
    }

    public function reorderMeetings(mixed $program, array $order): void
    {
        foreach ($order as $index => $meetingId) {
            Meeting::where('id', $meetingId)
                ->where('program_id', $program->id)
                ->update(['meeting_number' => $index + 1]);
        }
    }

    public function findMeetingOrFail(int $id): mixed
    {
        return Meeting::findOrFail($id);
    }
}
