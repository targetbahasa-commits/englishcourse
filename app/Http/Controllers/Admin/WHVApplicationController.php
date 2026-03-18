<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WHVApplication;
use Illuminate\Http\Request;

class WHVApplicationController extends Controller
{
    public function index()
    {
        $applications = WHVApplication::latest()->paginate(15);
        return view('admin.whv-applications.index', compact('applications'));
    }

    public function create()
    {
        return view('admin.whv-applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                    => 'required|string|max:255',
            'visa_type'                => 'required|string|max:255',
            'country'                  => 'required|string|max:255',
            'status'                   => 'required|string|in:draft,open,closed',
            'description'              => 'required|string',
            'requirements'             => 'nullable|string',
            'benefits'                 => 'nullable|string',
            'job_opportunities'        => 'nullable|string',
            'cost_breakdown'           => 'nullable|string',
            'testimonials'             => 'nullable|string',
            'faqs'                     => 'nullable|string',
            'eligibility_criteria'     => 'nullable|string',
            'age_requirement'          => 'nullable|string|max:255',
            'education_requirement'    => 'nullable|string|max:255',
            'financial_requirement'    => 'nullable|string|max:255',
            'support_letter_info'      => 'nullable|string',
            'english_requirement'      => 'nullable|string|in:ielts,toefl_itp,toefl_ibt,pte,multiple,none,other',
            'min_score'                => 'nullable|string|max:255',
            'processing_time'          => 'nullable|string|max:255',
            'application_fee'          => 'nullable|string|max:255',
            'visa_duration'            => 'nullable|string|max:255',
            'how_to_apply'             => 'nullable|string',
            'opening_date'             => 'nullable|date',
            'application_deadline'     => 'nullable|date',
            'url'                      => 'nullable|url|max:500',
            'sponsored_by'             => 'nullable|string|max:255',
            'is_active'                => 'boolean',
        ]);
        
        $validated['is_active'] = $request->boolean('is_active');

        WHVApplication::create($validated);

        return redirect()->route('admin.whv-applications.index')
            ->with('success', 'WHV application added successfully.');
    }

    public function edit(WHVApplication $whvApplication)
    {
        return view('admin.whv-applications.edit', compact('whvApplication'));
    }

    public function update(Request $request, WHVApplication $whvApplication)
    {
        $validated = $request->validate([
            'title'                    => 'required|string|max:255',
            'visa_type'                => 'required|string|max:255',
            'country'                  => 'required|string|max:255',
            'status'                   => 'required|string|in:draft,open,closed',
            'description'              => 'required|string',
            'requirements'             => 'nullable|string',
            'benefits'                 => 'nullable|string',
            'job_opportunities'        => 'nullable|string',
            'cost_breakdown'           => 'nullable|string',
            'testimonials'             => 'nullable|string',
            'faqs'                     => 'nullable|string',
            'eligibility_criteria'     => 'nullable|string',
            'age_requirement'          => 'nullable|string|max:255',
            'education_requirement'    => 'nullable|string|max:255',
            'financial_requirement'    => 'nullable|string|max:255',
            'support_letter_info'      => 'nullable|string',
            'english_requirement'      => 'nullable|string|in:ielts,toefl_itp,toefl_ibt,pte,multiple,none,other',
            'min_score'                => 'nullable|string|max:255',
            'processing_time'          => 'nullable|string|max:255',
            'application_fee'          => 'nullable|string|max:255',
            'visa_duration'            => 'nullable|string|max:255',
            'how_to_apply'             => 'nullable|string',
            'opening_date'             => 'nullable|date',
            'application_deadline'     => 'nullable|date',
            'url'                      => 'nullable|url|max:500',
            'sponsored_by'             => 'nullable|string|max:255',
            'is_active'                => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $whvApplication->update($validated);

        return redirect()->route('admin.whv-applications.index')
            ->with('success', 'WHV application updated successfully.');
    }

    public function destroy(WHVApplication $whvApplication)
    {
        $whvApplication->delete();
        return redirect()->route('admin.whv-applications.index')
            ->with('success', 'WHV application deleted successfully.');
    }
}
