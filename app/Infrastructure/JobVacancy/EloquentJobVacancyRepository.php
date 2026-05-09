<?php

namespace App\Infrastructure\JobVacancy;

use App\Domain\JobVacancy\Repositories\JobVacancyRepository;
use App\Models\JobVacancy;

class EloquentJobVacancyRepository implements JobVacancyRepository
{
    public function search(array $filters, string $sort, int $perPage): mixed
    {
        $query = JobVacancy::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                  ->orWhere('deadline', '>=', now()->startOfDay());
            });

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('job_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        if (!empty($filters['job_type'])) {
            $query->where('job_type', $filters['job_type']);
        }

        if (!empty($filters['english_requirement'])) {
            $query->where('english_requirement', $filters['english_requirement']);
        }

        if ($sort === 'closing_soon') {
            $query->orderByRaw('deadline IS NULL, deadline ASC');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($perPage)->withQueryString();
    }

        public function getDistinctCountries(): array
    {
        return JobVacancy::whereNotNull('country')
            ->where('country', '!=', '')
            ->where('is_active', true)
            ->distinct()
            ->pluck('country')
            ->all();
    }

        public function getDistinctJobTypes(): array
    {
        return JobVacancy::whereNotNull('job_type')
            ->where('job_type', '!=', '')
            ->where('is_active', true)
            ->distinct()
            ->pluck('job_type')
            ->all();
    }

        public function getDistinctEnglishRequirements(): array
    {
        return JobVacancy::whereNotNull('english_requirement')
            ->where('english_requirement', '!=', '')
            ->where('is_active', true)
            ->distinct()
            ->pluck('english_requirement')
            ->all();
    }

    public function listAll(int $perPage): mixed
    {
        return JobVacancy::latest()->paginate($perPage);
    }

    public function create(array $data): void
    {
        JobVacancy::create($data);
    }

    public function update(mixed $vacancy, array $data): void
    {
        $vacancy->update($data);
    }

    public function delete(mixed $vacancy): void
    {
        $vacancy->delete();
    }
}
