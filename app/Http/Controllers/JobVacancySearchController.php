<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancySearchController extends Controller
{
    /**
     * Display a listing of active job vacancies with filtering.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                  ->orWhere('deadline', '>=', now()->startOfDay());
            });

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('job_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Country Filter
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }
        
        // Job Type Filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // English Requirement Filter
        if ($request->filled('english_requirement')) {
            $query->where('english_requirement', $request->english_requirement);
        }

        // Sort Option
        $sort = $request->input('sort', 'newest');
        if ($sort === 'closing_soon') {
            $query->orderByRaw('deadline IS NULL, deadline ASC');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $jobVacancies = $query->paginate(12)->withQueryString();

        // Get unique options from DB for filters
        $countries = JobVacancy::whereNotNull('country')
            ->where('country', '!=', '')
            ->where('is_active', true)
            ->distinct()
            ->pluck('country');
            
        $jobTypes = JobVacancy::whereNotNull('job_type')
            ->where('job_type', '!=', '')
            ->where('is_active', true)
            ->distinct()
            ->pluck('job_type');
            
        $englishRequirements = JobVacancy::whereNotNull('english_requirement')
            ->where('english_requirement', '!=', '')
            ->where('is_active', true)
            ->distinct()
            ->pluck('english_requirement');

        return view('job-vacancies.index', compact('jobVacancies', 'countries', 'jobTypes', 'englishRequirements'));
    }

    /**
     * Display the specified job vacancy detail.
     */
    public function show(JobVacancy $jobVacancy)
    {
        // Bind model automatically, but we need to ensure it's active
        if (!$jobVacancy->is_active || ($jobVacancy->deadline && $jobVacancy->deadline->isPast())) {
            abort(404, 'Job vacancy not found or expired.');
        }

        return view('job-vacancies.show', compact('jobVacancy'));
    }
}
