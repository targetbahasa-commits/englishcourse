<?php

namespace App\Application\JobVacancy;

use App\Domain\JobVacancy\Repositories\JobVacancyRepository;

class ManageJobVacancies
{
    public function __construct(
        private readonly JobVacancyRepository $repository
    ) {}

    public function listAll(int $perPage = 15): mixed
    {
        return $this->repository->listAll($perPage);
    }

    public function create(array $data): void
    {
        $this->repository->create($data);
    }

    public function update(mixed $vacancy, array $data): void
    {
        $this->repository->update($vacancy, $data);
    }

    public function delete(mixed $vacancy): void
    {
        $this->repository->delete($vacancy);
    }
}
