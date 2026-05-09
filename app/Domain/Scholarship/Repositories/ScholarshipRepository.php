<?php

namespace App\Domain\Scholarship\Repositories;

interface ScholarshipRepository
{
    public function listActive(int $perPage): mixed;

    public function getOpenScholarships(int $limit): mixed;

    public function search(array $filters, int $perPage): mixed;

    public function getDistinctCountries(): array;

    public function getDistinctDegreeLevels(): array;

    public function getDistinctFundingTypes(): array;

    public function getAllMajors(): array;

    public function getLatestNews(int $limit): array;

    public function getActiveForCalendar(): array;

    // Admin CRUD — ScholarshipNews
    public function listAllNews(int $perPage): mixed;

    public function createNews(array $data): void;

    public function findNewsOrFail(int $id): mixed;

    public function updateNews(mixed $news, array $data): void;

    public function deleteNews(mixed $news): void;
}
