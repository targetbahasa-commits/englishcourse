<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::latest()->paginate(15);
        return view('admin.job-vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        return view('admin.job-vacancies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'company'             => 'required|string|max:255',
            'country'             => 'required|string|max:255',
            'location'            => 'nullable|string|max:255',
            'job_type'            => 'nullable|string|max:255',
            'salary'              => 'nullable|string|max:255',
            'visa_sponsorship'    => 'nullable|boolean',
            'description'         => 'required|string',
            'requirements'        => 'nullable|string',
            'benefits'            => 'nullable|string',
            'english_requirement' => 'nullable|string|in:ielts,toefl_itp,toefl_ibt,pte,none,other',
            'min_score'           => 'nullable|string|max:255',
            'deadline'            => 'nullable|date',
            'url'                 => 'nullable|url|max:500',
            'is_active'           => 'boolean',
        ]);
        
        $validated['is_active'] = $request->boolean('is_active');

        JobVacancy::create($validated);

        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy created successfully.');
    }

    public function edit(JobVacancy $jobVacancy)
    {
        return view('admin.job-vacancies.edit', compact('jobVacancy'));
    }

    public function update(Request $request, JobVacancy $jobVacancy)
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'company'             => 'required|string|max:255',
            'country'             => 'required|string|max:255',
            'location'            => 'nullable|string|max:255',
            'job_type'            => 'nullable|string|max:255',
            'salary'              => 'nullable|string|max:255',
            'visa_sponsorship'    => 'nullable|boolean',
            'description'         => 'required|string',
            'requirements'        => 'nullable|string',
            'benefits'            => 'nullable|string',
            'english_requirement' => 'nullable|string|in:ielts,toefl_itp,toefl_ibt,pte,none,other',
            'min_score'           => 'nullable|string|max:255',
            'deadline'            => 'nullable|date',
            'url'                 => 'nullable|url|max:500',
            'is_active'           => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $jobVacancy->update($validated);

        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy updated successfully.');
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();
        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy deleted successfully.');
    }
}
