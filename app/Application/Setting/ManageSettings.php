<?php

namespace App\Application\Setting;

use App\Domain\Setting\Repositories\SettingRepository;

class ManageSettings
{
    public function __construct(
        private readonly SettingRepository $repository
    ) {}

    public function getAll(): array
    {
        return $this->repository->getAllAsKeyValue();
    }

    public function bulkUpdate(array $data): void
    {
        $this->repository->bulkUpdate($data);
    }
}
