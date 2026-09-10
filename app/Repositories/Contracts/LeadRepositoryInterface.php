<?php

namespace App\Repositories\Contracts;

interface LeadRepositoryInterface
{
    public function getPaginatedLeads(array $filters = [], int $perPage = 15);
    public function getFilteredCount(array $filters = [], ?string $status = null): int;
    public function countAll(): int;
    public function countByStatus(string $status): int;
    public function updateStatus(int $id, string $status): bool;
}
