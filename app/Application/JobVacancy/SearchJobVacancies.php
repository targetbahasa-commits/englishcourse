<?php

namespace App\Application\JobVacancy;

use App\Domain\JobVacancy\Repositories\JobVacancyRepository;

class SearchJobVacancies
{
    public function __construct(
        private readonly JobVacancyRepository $repository
    ) {
    }

    public function search(array $filters, string $sort = 'newest', int $perPage = 12): mixed
    {
        return $this->repository->search($filters, $sort, $perPage);
    }

    public function getFilterOptions(): array
    {
        return [
            'countries'            => $this->repository->getDistinctCountries(),
            'jobTypes'             => $this->repository->getDistinctJobTypes(),
            'englishRequirements'  => $this->repository->getDistinctEnglishRequirements(),
        ];
    }
}
