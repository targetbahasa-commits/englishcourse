<?php

namespace App\Domain\Program\Repositories;

interface ProgramRepository
{
    public function create(array $data): mixed;

    public function listWithCounts(): array;

    public function listMockTests(): array;

    public function syncToeflMockTestPrograms(array $packages): void;

    public function findOrFail(int $id): mixed;

    public function update(mixed $program, array $data): void;

    public function deactivate(mixed $program): void;

    public function toggleActive(mixed $program): mixed;

    public function delete(mixed $program): void;

    public function getMeetingsForSyllabus(mixed $program): array;

    public function addMeeting(mixed $program, array $data): void;

    public function updateMeeting(mixed $meeting, array $data): void;

    public function deleteMeeting(mixed $meeting): void;

    public function reorderMeetings(mixed $program, array $order): void;

    public function findMeetingOrFail(int $id): mixed;

    public function findSplittableCandidates(): array;

    public function splitIntoOfflineVariant(mixed $program, ?string $nameSuffix = null): mixed;
}
