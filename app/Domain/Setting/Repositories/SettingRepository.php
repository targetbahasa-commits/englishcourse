<?php

namespace App\Domain\Setting\Repositories;

interface SettingRepository
{
    public function getAllAsKeyValue(): array;

    public function bulkUpdate(array $data): void;
}
