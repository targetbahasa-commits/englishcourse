<?php

namespace App\Domain\IeltsListening\Repositories;

interface IeltsListeningRepository
{
    public function findOrCreateProgram(string $slug, array $defaultData): mixed;

    public function findProgramBySlugWithMeetings(string $slug): mixed;

    public function findMaterialByTypeId(int $typeId): mixed;

    public function findOrCreateMaterialByTypeId(int $typeId, array $defaultData): mixed;

    public function updateMaterial(int $id, array $data): void;

    public function findSectionByMeetingAndNumber(int $meetingId, int $sectionNumber): mixed;

    public function updateSection(int $id, array $data): void;

    public function createMeeting(int $programId, array $data): void;

    public function reorderMeetings(array $meetingIds): void;

    public function findMeetingOrFail(int $id): mixed;

    public function findOrCreateMeeting(int $programId, int $meetingNumber, array $defaultData): mixed;

    public function createSection(array $data): void;

    public function meetingHasSections(int $meetingId): bool;
}
