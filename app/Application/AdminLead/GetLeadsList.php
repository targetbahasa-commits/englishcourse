<?php

namespace App\Application\AdminLead;

use App\Repositories\Contracts\LeadRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GetLeadsList
{
    public function __construct(
        private readonly LeadRepositoryInterface $leadRepository
    ) {
    }

    public function execute(?string $status, ?string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->leadRepository->getPaginatedLeads($status, $search, $perPage);
    }
}
