<?php

namespace App\Application\ClassPeriod;

use App\Domain\ClassPeriod\Repositories\ClassPeriodRepository;
use App\Models\StudentGroup;
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

        // Per-game visibility control - only meaningful for Speaking-track
        // programs (games are hardcoded content in SpeakingAdminController,
        // not DB rows). For every other program this lookup is skipped
        // entirely and $meeting->games is simply never set.
        $speakingLevel = $classPeriod->program
            ? app(\App\Http\Controllers\SpeakingAdminController::class)->speakingLevelForProgramSlug($classPeriod->program->slug ?? '')
            : null;
        if ($speakingLevel) {
            $hiddenLookup = \App\Models\ClassPeriodGameVisibility::where('class_period_id', $classPeriod->id)
                ->where('is_open', false)
                ->get()
                ->groupBy('meeting_id');

            $meetings->transform(function ($meeting) use ($speakingLevel, $hiddenLookup) {
                $meeting->games = app(\App\Http\Controllers\SpeakingAdminController::class)->gamesForMeeting($speakingLevel, $meeting->meeting_number);
                $meeting->hidden_game_indexes = ($hiddenLookup[$meeting->id] ?? collect())->pluck('game_index')->all();
                return $meeting;
            });
        }

        $allStudents = $this->repository->getAllStudents();

        // Students who self-booked this batch via "Booking Class" (Enrollment-based,
        // separate from the legacy users.class_period_id assignment above) - shown
        // distinctly since a self-booked student may not appear in $classPeriod->users
        // at all if an admin never manually assigned them.
        $bookedEnrollments = \App\Models\Enrollment::where('class_period_id', $classPeriod->id)
            ->where('status', 'active')
            ->whereNotNull('class_period_booked_at')
            ->with('user')
            ->orderByDesc('class_period_booked_at')
            ->get();

        $studentGroups = $classPeriod->studentGroups()->with('members', 'meeting')->get();

        // Same dedup-by-id union ClassPeriod::occupiedSeats() uses - everyone
        // in this batch either way, as candidates for the group-member picker.
        $rosterStudents = $classPeriod->users
            ->merge($bookedEnrollments->pluck('user')->filter())
            ->unique('id')
            ->sortBy('name')
            ->values();

        return compact('classPeriod', 'meetings', 'allStudents', 'bookedEnrollments', 'studentGroups', 'rosterStudents');
    }

    public function update(mixed $classPeriod, array $data): void
    {
        $data = $this->resolveName($data, $classPeriod);
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

    /**
     * Opposite default from toggleMeeting(): a game is open unless a row
     * explicitly says otherwise, so the first toggle on a never-touched game
     * always means "hide it" - there's nothing to show/re-open until then.
     */
    public function toggleGame(mixed $classPeriod, mixed $meeting, int $gameIndex): void
    {
        $row = \App\Models\ClassPeriodGameVisibility::where('class_period_id', $classPeriod->id)
            ->where('meeting_id', $meeting->id)
            ->where('game_index', $gameIndex)
            ->first();

        if ($row) {
            $row->update(['is_open' => !$row->is_open]);
        } else {
            \App\Models\ClassPeriodGameVisibility::create([
                'class_period_id' => $classPeriod->id,
                'meeting_id' => $meeting->id,
                'game_index' => $gameIndex,
                'is_open' => false,
            ]);
        }
    }

    /**
     * @return array{status: string}
     */
    public function assignStudent(mixed $classPeriod, int $userId): array
    {
        if ($classPeriod->max_capacity !== null) {
            $currentCount = $classPeriod->users()->where('role', 'student')->count();
            $alreadyInThisPeriod = $classPeriod->users()->where('role', 'student')->where('id', $userId)->exists();

            if (!$alreadyInThisPeriod && $currentCount >= $classPeriod->max_capacity) {
                return ['status' => 'capacity_exceeded'];
            }
        }

        $user = $this->repository->findStudentOrFail($userId);
        $this->repository->assignStudent($classPeriod, $user);

        return ['status' => 'assigned'];
    }

    /**
     * Creates a group/pair within a class period - a "pair" is simply a
     * group with 2 members, no separate data model needed. A student isn't
     * restricted from belonging to more than one group at once; this is a
     * pure record-keeping tool, nothing elsewhere enforces exclusivity.
     *
     * $meetingId null (default) means the group applies batch-wide, across
     * every meeting - pass a specific meeting to scope the group to just
     * that meeting's pairwork/group activity instead.
     *
     * $gameIndex null (default) means the group applies to every game within
     * the meeting - pass a specific 0-based index (see the Game Speaking tab's
     * $games list) to scope the group to just that one subtopic's game.
     */
    public function createGroup(mixed $classPeriod, ?string $name, array $userIds, ?int $meetingId = null, ?int $gameIndex = null): StudentGroup
    {
        $name = trim((string) $name);
        if ($name === '') {
            $name = 'Kelompok ' . ($classPeriod->studentGroups()->count() + 1);
        }

        $group = $classPeriod->studentGroups()->create(['name' => $name, 'meeting_id' => $meetingId, 'game_index' => $gameIndex]);
        $group->members()->syncWithoutDetaching($userIds);

        return $group;
    }

    /**
     * Distributes a roster in one go: $assignments maps user_id => group
     * number (1-based, matching the picker in the UI) or null/omitted for
     * "not in any group". Creates one StudentGroup per number that actually
     * has at least one member - a number nobody picked produces no group,
     * rather than an empty one nobody asked for.
     *
     * @param array<int|string, int|string|null> $assignments
     * @return \Illuminate\Support\Collection<int, StudentGroup>
     */
    public function bulkCreateGroups(mixed $classPeriod, int $groupCount, array $assignments, ?int $meetingId = null, ?int $gameIndex = null): \Illuminate\Support\Collection
    {
        $groups = collect();

        for ($number = 1; $number <= $groupCount; $number++) {
            $memberIds = collect($assignments)
                ->filter(fn ($assignedNumber) => $assignedNumber !== null && (int) $assignedNumber === $number)
                ->keys()
                ->map(fn ($id) => (int) $id)
                ->values()
                ->all();

            if (empty($memberIds)) {
                continue;
            }

            $groups->push($this->createGroup($classPeriod, "Kelompok {$number}", $memberIds, $meetingId, $gameIndex));
        }

        return $groups;
    }

    public function autoPairGroups(
        mixed $classPeriod,
        array $userIds,
        ?int $meetingId = null,
        ?int $gameIndex = null,
        string $namePrefix = 'Pair',
        string $oddHandling = 'trio',
        bool $replaceExisting = false
    ): \Illuminate\Support\Collection {
        if ($replaceExisting) {
            $this->deleteAllGroups($classPeriod, $meetingId, $gameIndex);
        }

        $userIds = array_values(array_unique(array_map('intval', $userIds)));
        shuffle($userIds);

        $chunks = [];
        $total = count($userIds);

        if ($total === 0) {
            return collect();
        }

        if ($total === 1) {
            $chunks[] = $userIds;
        } else {
            for ($i = 0; $i < $total; $i += 2) {
                $slice = array_slice($userIds, $i, 2);
                $chunks[] = $slice;
            }

            if ($oddHandling === 'trio' && count(end($chunks)) === 1 && count($chunks) > 1) {
                $lastSingle = array_pop($chunks);
                $chunks[count($chunks) - 1][] = $lastSingle[0];
            }
        }

        $groups = collect();
        $pairNumber = 1;
        foreach ($chunks as $memberIds) {
            $groupName = "{$namePrefix} {$pairNumber}";
            $groups->push($this->createGroup($classPeriod, $groupName, $memberIds, $meetingId, $gameIndex));
            $pairNumber++;
        }

        return $groups;
    }

    /**
     * $meetingId null means "scoped to batch-wide groups only" (whereNull),
     * matching createGroup()'s own null semantics for that column - NOT "no
     * filter, delete every meeting's groups". This matters because the
     * Auto-Pair tab's "replace_existing" checkbox is checked by default with
     * no confirmation dialog: without this, choosing "berlaku untuk semua
     * meeting" (meeting_id=null) on that tab would silently wipe out
     * meeting-specific groups for every OTHER meeting in the batch too.
     *
     * $gameIndex null intentionally keeps "no filter" semantics - unlike
     * meeting_id, every caller that omits it (the "Hapus Semua Kelompok
     * Meeting Ini" button, and Auto-Pair's own "Semua Game" option once a
     * specific meeting is already selected) means "regardless of game" for
     * that already-narrow scope, not "only batch-wide-game groups".
     */
    public function deleteAllGroups(mixed $classPeriod, ?int $meetingId = null, ?int $gameIndex = null): int
    {
        $query = $classPeriod->studentGroups();

        if ($meetingId !== null) {
            $query->where('meeting_id', $meetingId);
        } else {
            $query->whereNull('meeting_id');
        }
        if ($gameIndex !== null) {
            $query->where('game_index', $gameIndex);
        }

        $groups = $query->get();
        $count = $groups->count();

        foreach ($groups as $group) {
            $group->members()->detach();
            $group->delete();
        }

        return $count;
    }

    public function deleteGroup(mixed $classPeriod, mixed $group): bool
    {
        if ($group->class_period_id !== $classPeriod->id) {
            return false;
        }
        $group->delete();
        return true;
    }

    public function addGroupMember(mixed $group, int $userId): void
    {
        $group->members()->syncWithoutDetaching([$userId]);
    }

    public function removeGroupMember(mixed $group, int $userId): void
    {
        $group->members()->detach($userId);
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

    private function resolveName(array $data, mixed $existing = null): array
    {
        $startDate = $data['start_date'] ?? $existing?->start_date;
        $endDate = $data['end_date'] ?? $existing?->end_date;
        $batchNumber = $data['batch_number'] ?? $existing?->batch_number;

        $isDefaultBatchPattern = empty($data['name'])
            || ($existing && $data['name'] === $existing->name)
            || preg_match('/^Batch\s*(\d+)?\s*-\s*.+\s+to\s+.+$/i', $data['name'] ?? '');

        if ($isDefaultBatchPattern && !empty($startDate) && !empty($endDate)) {
            $start = Carbon::parse($startDate)->translatedFormat('d M Y');
            $end = Carbon::parse($endDate)->translatedFormat('d M Y');
            $batchStr = !empty($batchNumber) ? "Batch {$batchNumber} - " : "Batch ";
            $data['name'] = "{$batchStr}{$start} to {$end}";
        }

        return $data;
    }
}
