<?php

namespace App\Application\AdminLead;

use App\Repositories\Contracts\LeadRepositoryInterface;

class UpdateLeadStatus
{
    public function __construct(
        private readonly LeadRepositoryInterface $leadRepository
    ) {
    }

    public function execute(int $id, string $status): bool
    {
        return $this->leadRepository->updateStatus($id, $status);
    }
}
