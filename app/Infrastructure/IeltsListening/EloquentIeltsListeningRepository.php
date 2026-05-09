<?php

namespace App\Infrastructure\IeltsListening;

use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;
use App\Models\IeltsListeningMaterial;
use App\Models\IeltsSection;
use App\Models\Meeting;
use App\Models\Program;

class EloquentIeltsListeningRepository implements IeltsListeningRepository
{
    public function findOrCreateProgram(string $slug, array $defaultData): mixed
    {
        return Program::firstOrCreate(['slug' => $slug], $defaultData);
    }

    public function findProgramBySlugWithMeetings(string $slug): mixed
    {
        return Program::where('slug', $slug)->with('meetings')->first();
    }

    public function findMaterialByTypeId(int $typeId): mixed
    {
        return IeltsListeningMaterial::where('material_type_id', $typeId)->first();
    }

    public function findOrCreateMaterialByTypeId(int $typeId, array $defaultData): mixed
    {
        return IeltsListeningMaterial::firstOrCreate(['material_type_id' => $typeId], $defaultData);
    }

    public function updateMaterial(int $id, array $data): void
    {
        IeltsListeningMaterial::findOrFail($id)->update($data);
    }

    public function findSectionByMeetingAndNumber(int $meetingId, int $sectionNumber): mixed
    {
        return IeltsSection::where('meeting_id', $meetingId)
            ->where('section_number', $sectionNumber)
            ->first();
    }

    public function updateSection(int $id, array $data): void
    {
        IeltsSection::findOrFail($id)->update($data);
    }

    public function createMeeting(int $programId, array $data): void
    {
        Meeting::create(array_merge(['program_id' => $programId], $data));
    }

    public function reorderMeetings(array $meetingIds): void
    {
        foreach ($meetingIds as $index => $id) {
            Meeting::where('id', $id)->update(['meeting_number' => $index + 1]);
        }
    }

    public function findMeetingOrFail(int $id): mixed
    {
        return Meeting::findOrFail($id);
    }

    public function findOrCreateMeeting(int $programId, int $meetingNumber, array $defaultData): mixed
    {
        return Meeting::firstOrCreate(
            ['program_id' => $programId, 'meeting_number' => $meetingNumber],
            $defaultData
        );
    }

    public function createSection(array $data): void
    {
        IeltsSection::create($data);
    }

    public function meetingHasSections(int $meetingId): bool
    {
        return IeltsSection::where('meeting_id', $meetingId)->exists();
    }
}
