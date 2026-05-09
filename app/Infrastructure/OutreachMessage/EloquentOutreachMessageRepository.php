<?php

namespace App\Infrastructure\OutreachMessage;

use App\Domain\OutreachMessage\Repositories\OutreachMessageRepository;
use App\Models\OutreachMessage;
use App\Models\Program;

class EloquentOutreachMessageRepository implements OutreachMessageRepository
{
    public function listAll(int $perPage): mixed
    {
        return OutreachMessage::latest()->paginate($perPage);
    }

    public function create(array $data): void
    {
        OutreachMessage::create($data);
    }

    public function update(mixed $message, array $data): void
    {
        $message->update($data);
    }

    public function delete(mixed $message): void
    {
        $message->delete();
    }

    public function getActiveProgramOptions(): array
    {
        return Program::where('is_active', true)->orderBy('name')->get()->all();
    }
}
