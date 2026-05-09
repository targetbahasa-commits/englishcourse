<?php

namespace App\Application\Scholarship;

use App\Domain\Scholarship\Repositories\ScholarshipRepository;

class SearchScholarships
{
    public function __construct(
        private readonly ScholarshipRepository $repository
    ) {
    }

    public function search(array $filters, int $perPage = 12): mixed
    {
        return $this->repository->search($filters, $perPage);
    }

    public function getFilterOptions(): array
    {
        return [
            'countries'    => $this->repository->getDistinctCountries(),
            'degreeLevels' => $this->repository->getDistinctDegreeLevels(),
            'fundingTypes' => $this->repository->getDistinctFundingTypes(),
            'majors'       => $this->repository->getAllMajors(),
        ];
    }

    public function getLatestNews(int $limit = 3): array
    {
        return $this->repository->getLatestNews($limit);
    }

    public function getActiveForCalendar(): array
    {
        return $this->repository->getActiveForCalendar();
    }
}
