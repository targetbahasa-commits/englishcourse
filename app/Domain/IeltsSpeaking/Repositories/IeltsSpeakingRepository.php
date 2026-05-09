<?php

namespace App\Domain\IeltsSpeaking\Repositories;

interface IeltsSpeakingRepository
{
    public function findOrFail(int $id): mixed;

    public function getAllOrdered(): array;

    public function findBySlug(string $slug): mixed;

    public function create(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;
}
