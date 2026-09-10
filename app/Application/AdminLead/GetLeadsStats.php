<?php

namespace App\Application\AdminLead;

use App\Repositories\Contracts\LeadRepositoryInterface;

class GetLeadsStats
{
    public function __construct(
        private readonly LeadRepositoryInterface $leadRepository
    ) {
    }

    public function execute(array $filters = []): array
    {
        return [
            'totalLeads' => $this->leadRepository->getFilteredCount($filters),
            'pendingLeads' => $this->leadRepository->getFilteredCount($filters, 'pending'),
            'contactedLeads' => $this->leadRepository->getFilteredCount($filters, 'contacted'),
            'enrolledLeads' => $this->leadRepository->getFilteredCount($filters, 'enrolled'),
        ];
    }
}
