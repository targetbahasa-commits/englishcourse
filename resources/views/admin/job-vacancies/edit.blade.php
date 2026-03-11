@extends('layouts.admin')

@section('title', 'Edit Job Vacancy')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Overseas Job Vacancy</h1>
            <p class="text-sm text-gray-500 mt-1">Update the details for this job posting.</p>
        </div>
        <a href="{{ route('admin.job-vacancies.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 font-medium text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.job-vacancies.update', $jobVacancy) }}" method="POST" class="p-6 sm:p-8">
            @csrf
            @method('PUT')
            <div class="space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $jobVacancy->title) }}" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Company --}}
                    <div>
                        <label for="company" class="block text-sm font-semibold text-gray-700 mb-1">Company <span class="text-red-500">*</span></label>
                        <input type="text" name="company" id="company" value="{{ old('company', $jobVacancy->company) }}" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                        @error('company')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Country --}}
                    <div>
                        <label for="country" class="block text-sm font-semibold text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                        <input type="text" name="country" id="country" value="{{ old('country', $jobVacancy->country) }}" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                            placeholder="e.g., Germany">
                        @error('country')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Location --}}
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">City / Region <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="text" name="location" id="location" value="{{ old('location', $jobVacancy->location) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                            placeholder="e.g., Berlin">
                        @error('location')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                    {{-- Job Type --}}
                    <div>
                        <label for="job_type" class="block text-sm font-semibold text-gray-700 mb-1">Job Type</label>
                        <input type="text" name="job_type" id="job_type" value="{{ old('job_type', $jobVacancy->job_type) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                            placeholder="e.g., Full-time, Healthcare, IT">
                        @error('job_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Salary --}}
                    <div>
                        <label for="salary" class="block text-sm font-semibold text-gray-700 mb-1">Salary <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="text" name="salary" id="salary" value="{{ old('salary', $jobVacancy->salary) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                            placeholder="e.g., €3000/month">
                        @error('salary')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                    {{-- Deadline --}}
                    <div>
                        <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-1">Deadline <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $jobVacancy->deadline?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                        @error('deadline')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Visa Sponsorship --}}
                    <div class="flex items-center pt-8">
                        <input id="visa_sponsorship" name="visa_sponsorship" type="checkbox" value="1" {{ old('visa_sponsorship', $jobVacancy->visa_sponsorship) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                        <div class="ml-3">
                            <label for="visa_sponsorship" class="text-sm font-medium text-gray-800 cursor-pointer">Visa Sponsorship Provided</label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t border-gray-100 pt-6 mt-6">
                    {{-- English Requirement --}}
                    <div>
                        <label for="english_requirement" class="block text-sm font-semibold text-gray-700 mb-1">English Requirement <span class="text-gray-400 font-normal">(optional)</span></label>
                        <select id="english_requirement" name="english_requirement" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                            <option value="">Select Certificate</option>
                            <option value="none" {{ old('english_requirement', $jobVacancy->english_requirement) == 'none' ? 'selected' : '' }}>None</option>
                            <option value="ielts" {{ old('english_requirement', $jobVacancy->english_requirement) == 'ielts' ? 'selected' : '' }}>IELTS</option>
                            <option value="toefl_itp" {{ old('english_requirement', $jobVacancy->english_requirement) == 'toefl_itp' ? 'selected' : '' }}>TOEFL ITP</option>
                            <option value="toefl_ibt" {{ old('english_requirement', $jobVacancy->english_requirement) == 'toefl_ibt' ? 'selected' : '' }}>TOEFL iBT</option>
                            <option value="pte" {{ old('english_requirement', $jobVacancy->english_requirement) == 'pte' ? 'selected' : '' }}>PTE</option>
                            <option value="other" {{ old('english_requirement', $jobVacancy->english_requirement) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('english_requirement')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Minimum Score --}}
                    <div>
                        <label for="min_score" class="block text-sm font-semibold text-gray-700 mb-1">Minimum Score <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="text" name="min_score" id="min_score" value="{{ old('min_score', $jobVacancy->min_score) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                        @error('min_score')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- URL --}}
                <div class="border-t border-gray-100 pt-6 mt-6">
                    <label for="url" class="block text-sm font-semibold text-gray-700 mb-1">External Link URL <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="url" name="url" id="url" value="{{ old('url', $jobVacancy->url) }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                        placeholder="https://example.com/apply">
                    @error('url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Overview/Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">{{ old('description', $jobVacancy->description) }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Benefits --}}
                <div class="mt-6">
                    <label for="benefits" class="block text-sm font-semibold text-gray-700 mb-1">Benefits / Perks <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea name="benefits" id="benefits" rows="3"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                        placeholder="e.g., Free housing, Flight tickets...">{{ old('benefits', $jobVacancy->benefits) }}</textarea>
                    @error('benefits')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                {{-- Additional Requirements --}}
                <div>
                    <label for="requirements" class="block text-sm font-semibold text-gray-700 mb-1">Additional Requirements <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea name="requirements" id="requirements" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">{{ old('requirements', $jobVacancy->requirements) }}</textarea>
                    @error('requirements')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Active --}}
                <div class="flex items-center pt-2">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $jobVacancy->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                    <div class="ml-3">
                        <label for="is_active" class="text-sm font-medium text-gray-800 cursor-pointer">Active (visible on site)</label>
                        <p class="text-xs text-gray-500">Uncheck to hide from the job search page.</p>
                    </div>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.job-vacancies.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">Update Job Vacancy</button>
            </div>
        </form>
    </div>
</div>
@endsection
