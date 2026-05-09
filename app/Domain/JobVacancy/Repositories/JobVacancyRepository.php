<?php

namespace App\Domain\JobVacancy\Repositories;

interface JobVacancyRepository
{
    public function search(array $filters, string $sort, int $perPage): mixed;

    public function getDistinctCountries(): array;

    public function getDistinctJobTypes(): array;

    public function getDistinctEnglishRequirements(): array;

    // Admin CRUD
    public function listAll(int $perPage): mixed;

    public function create(array $data): void;

    public function update(mixed $vacancy, array $data): void;

    public function delete(mixed $vacancy): void;
}
