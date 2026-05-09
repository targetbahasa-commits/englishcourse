<?php

namespace App\Application\Scholarship;

use App\Domain\Scholarship\Repositories\ScholarshipRepository;

class ManageScholarshipNews
{
    public function __construct(
        private readonly ScholarshipRepository $repository
    ) {}

    public function listAll(int $perPage = 15): mixed
    {
        return $this->repository->listAllNews($perPage);
    }

    public function create(array $data): void
    {
        $this->repository->createNews($data);
    }

    public function findOrFail(int $id): mixed
    {
        return $this->repository->findNewsOrFail($id);
    }

    public function update(mixed $news, array $data): void
    {
        $this->repository->updateNews($news, $data);
    }

    public function delete(mixed $news): void
    {
        $this->repository->deleteNews($news);
    }
}
