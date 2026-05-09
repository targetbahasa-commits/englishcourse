<?php

namespace App\Application\Guest;

use App\Domain\Guest\Repositories\GuestUserRepository;

class CreateQuickGuestAccess
{
    public function __construct(
        private readonly GuestUserRepository $repository
    ) {
    }

    public function execute(): mixed
    {
        return $this->repository->createQuickGuestUser([]);
    }

    public function findById(int $id): mixed
    {
        return $this->repository->findQuickGuestById($id);
    }
}
