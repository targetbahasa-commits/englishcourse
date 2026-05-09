<?php

namespace App\Domain\Guest\Repositories;

interface GuestUserRepository
{
    public function findByEmail(string $email): mixed;

    public function createGuestUser(array $data): mixed;

    public function updateGuestUser(int $userId, array $data): void;

    public function createQuickGuestUser(array $data): mixed;

    public function findQuickGuestById(int $id): mixed;
}
