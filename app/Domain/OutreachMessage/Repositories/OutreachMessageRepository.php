<?php

namespace App\Domain\OutreachMessage\Repositories;

interface OutreachMessageRepository
{
    public function listAll(int $perPage): mixed;

    public function create(array $data): void;

    public function update(mixed $message, array $data): void;

    public function delete(mixed $message): void;

    public function getActiveProgramOptions(): array;
}
