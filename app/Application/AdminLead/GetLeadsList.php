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

    public function execute(mixed $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        if (is_string($filters) || is_null($filters)) {
            $filters = [
                'status' => $filters,
                'search' => func_num_args() > 1 && is_string(func_get_arg(1)) ? func_get_arg(1) : null,
            ];
            $perPage = func_num_args() > 2 ? (int) func_get_arg(2) : 15;
        }

        return $this->leadRepository->getPaginatedLeads($filters, $perPage);
    }
}
