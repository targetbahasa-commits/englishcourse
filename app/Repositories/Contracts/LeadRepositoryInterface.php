<?php

namespace App\Repositories\Contracts;

interface LeadRepositoryInterface
{
    public function getPaginatedLeads(?string $status, ?string $search, int $perPage = 15);
    public function countAll(): int;
    public function countByStatus(string $status): int;
    public function updateStatus(int $id, string $status): bool;
}
