<?php

namespace App\Infrastructure\Scholarship;

use App\Domain\Scholarship\Repositories\ScholarshipRepository;
use App\Models\Scholarship;
use App\Models\ScholarshipNews;

class EloquentScholarshipRepository implements ScholarshipRepository
{
    public function listActive(int $perPage): mixed
    {
        return Scholarship::where('is_active', true)
            ->where('deadline', '>=', now()->startOfDay())
            ->latest()
            ->paginate($perPage);
    }

    public function getOpenScholarships(int $limit): mixed
    {
        return Scholarship::where('status', 'open')
            ->orderBy('deadline', 'asc')
            ->take($limit)
            ->get();
    }

    public function search(array $filters, int $perPage): mixed
    {
        $query = Scholarship::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                  ->orWhere('deadline', '>=', now()->startOfDay());
            });

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('provider', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        if (!empty($filters['degree_level'])) {
            $query->where('level_of_study', $filters['degree_level']);
        }

        if (!empty($filters['funding_type'])) {
            $query->where('funding_type', $filters['funding_type']);
        }

        if (!empty($filters['major'])) {
            $query->whereJsonContains('majors', $filters['major']);
        }

        return $query->orderBy('deadline', 'asc')->paginate($perPage)->withQueryString();
    }

        public function getDistinctCountries(): array
    {
        return Scholarship::whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
            ->pluck('country')
            ->all();
    }

        public function getDistinctDegreeLevels(): array
    {
        return Scholarship::whereNotNull('level_of_study')
            ->where('level_of_study', '!=', '')
            ->distinct()
            ->pluck('level_of_study')
            ->all();
    }

        public function getDistinctFundingTypes(): array
    {
        return Scholarship::whereNotNull('funding_type')
            ->where('funding_type', '!=', '')
            ->distinct()
            ->pluck('funding_type')
            ->all();
    }

        public function getAllMajors(): array
    {
        $allMajors = [];
        $scholarships = Scholarship::whereNotNull('majors')->get();
        foreach ($scholarships as $scholarship) {
            if (is_array($scholarship->majors)) {
                $allMajors = array_merge($allMajors, $scholarship->majors);
            }
        }

        return collect($allMajors)->unique()->sort()->values()->all();
    }

    public function getLatestNews(int $limit): array
    {
        return ScholarshipNews::where('is_active', true)
            ->latest('published_at')
            ->take($limit)
            ->get()->all();
    }

    public function getActiveForCalendar(): array
    {
        return Scholarship::where('is_active', true)
            ->get(['id', 'title', 'opening_date', 'deadline'])
            ->all();
    }

    public function listAllNews(int $perPage): mixed
    {
        return ScholarshipNews::latest('published_at')->paginate($perPage);
    }

    public function createNews(array $data): void
    {
        ScholarshipNews::create($data);
    }

    public function findNewsOrFail(int $id): mixed
    {
        return ScholarshipNews::findOrFail($id);
    }

    public function updateNews(mixed $news, array $data): void
    {
        $news->update($data);
    }

    public function deleteNews(mixed $news): void
    {
        $news->delete();
    }
}
