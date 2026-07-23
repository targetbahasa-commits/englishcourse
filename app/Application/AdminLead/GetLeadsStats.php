<?php

namespace App\Application\AdminLead;

use App\Repositories\Contracts\LeadRepositoryInterface;

class GetLeadsStats
{
    public function __construct(
        private readonly LeadRepositoryInterface $leadRepository
    ) {
    }

    public function execute(): array
    {
        return [
            'totalLeads' => $this->leadRepository->countAll(),
            'pendingLeads' => $this->leadRepository->countByStatus('pending'),
            'contactedLeads' => $this->leadRepository->countByStatus('contacted'),
            'enrolledLeads' => $this->leadRepository->countByStatus('enrolled'),
        ];
    }
}
