<?php

namespace App\Http\Controllers;

use App\Application\JobVacancy\SearchJobVacancies;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancySearchController extends Controller
{
    public function __construct(
        private readonly SearchJobVacancies $searchJobVacancies,
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'country', 'job_type', 'english_requirement']);
        $sort = $request->input('sort', 'newest');
        $jobVacancies = $this->searchJobVacancies->search($filters, $sort, 12);
        $filterOptions = $this->searchJobVacancies->getFilterOptions();

        $countries           = $filterOptions['countries'];
        $jobTypes            = $filterOptions['jobTypes'];
        $englishRequirements = $filterOptions['englishRequirements'];

        return view('job-vacancies.index', compact('jobVacancies', 'countries', 'jobTypes', 'englishRequirements'));
    }

    public function show(JobVacancy $jobVacancy)
    {
        if (!$jobVacancy->is_active || ($jobVacancy->deadline && \Carbon\Carbon::parse($jobVacancy->deadline)->isPast())) {
            abort(404, 'Job vacancy not found or expired.');
        }

        return view('job-vacancies.show', compact('jobVacancy'));
    }
}
