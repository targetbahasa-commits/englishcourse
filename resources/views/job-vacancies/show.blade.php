@extends('layouts.dashboard')

@section('title', $jobVacancy->title . ' - Overseas Jobs')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6">

    <!-- Breadcrumbs -->
    <nav class="flex text-sm text-gray-500 mb-8 font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li>
                <a href="{{ route('overseas-jobs.index') }}" class="hover:text-indigo-600 transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Overseas Jobs
                </a>
            </li>
            <li>
                <div class="flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                </div>
            </li>
            <li>
                <span class="text-gray-800 line-clamp-1 truncate max-w-[200px] sm:max-w-[400px]" aria-current="page">{{ $jobVacancy->title }}</span>
            </li>
        </ol>
    </nav>

    <!-- Main Content -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
        <!-- Header Banner Area -->
        <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700 relative overflow-hidden">
            <svg class="absolute right-0 top-0 h-full w-1/2 text-white/10 transform translate-x-1/3 -translate-y-1/4 scale-150 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>

        <div class="px-6 sm:px-10 pb-10">
            <!-- Header Content -->
            <div class="relative -mt-12 mb-8">
                <div class="w-24 h-24 bg-white rounded-2xl shadow-md border border-gray-100 flex items-center justify-center mb-5 text-indigo-600">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight mb-2">{{ $jobVacancy->title }}</h1>
                <p class="text-lg text-gray-600 font-medium">{{ $jobVacancy->company }}</p>
                
                <div class="flex flex-wrap items-center mt-6 gap-3">
                    <span class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-bold text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $jobVacancy->country }}
                    </span>
                    
                    @if($jobVacancy->deadline)
                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-50 text-amber-700 font-bold text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Closes {{ $jobVacancy->deadline->format('d M Y') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Details Key Info Grid -->
            <div class="bg-gray-50 rounded-2xl p-6 mb-10 border border-gray-100 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">
                
                @if($jobVacancy->salary)
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Estimated Salary</h3>
                    <p class="text-gray-900 font-semibold inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $jobVacancy->salary }}
                    </p>
                </div>
                @endif
                
                @if($jobVacancy->location)
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">City / Region</h3>
                    <p class="text-gray-900 font-semibold inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $jobVacancy->location }}, {{ $jobVacancy->country }}
                    </p>
                </div>
                @endif

                @if($jobVacancy->job_type)
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Job Type</h3>
                    <p class="text-gray-900 font-semibold inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $jobVacancy->job_type }}
                    </p>
                </div>
                @endif

                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">English Req.</h3>
                    @if($jobVacancy->english_requirement && $jobVacancy->english_requirement !== 'none')
                        <p class="text-gray-900 font-semibold uppercase inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            {{ str_replace('_', ' ', $jobVacancy->english_requirement) }}
                            @if($jobVacancy->min_score)
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs ml-1">{{ $jobVacancy->min_score }}</span>
                            @endif
                        </p>
                    @else
                        <p class="text-gray-500 font-medium inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            No Certificate Needed
                        </p>
                    @endif
                </div>

                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Visa Sponsorship</h3>
                    @if($jobVacancy->visa_sponsorship)
                        <p class="text-emerald-600 font-semibold inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Provided by Employer
                        </p>
                    @else
                        <p class="text-gray-500 font-medium inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Candidate responsibility
                        </p>
                    @endif
                </div>

            </div>

            <!-- Main Text Content -->
            <div class="prose prose-indigo prose-lg max-w-none text-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">Job Description</h2>
                <div class="whitespace-pre-wrap">{{ $jobVacancy->description }}</div>

                @if($jobVacancy->requirements)
                    <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4 pb-2 border-b border-gray-100">Requirements</h2>
                    <div class="whitespace-pre-wrap">{{ $jobVacancy->requirements }}</div>
                @endif
                
                @if($jobVacancy->benefits)
                    <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4 pb-2 border-b border-gray-100">Benefits & Perks</h2>
                    <div class="whitespace-pre-wrap">{{ $jobVacancy->benefits }}</div>
                @endif
            </div>

            <!-- Action Section -->
            @if($jobVacancy->url)
                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-indigo-50/50 rounded-2xl p-6">
                    <div class="mb-4 sm:mb-0 text-center sm:text-left">
                        <h4 class="font-bold text-gray-900 text-lg">Ready to apply?</h4>
                        <p class="text-sm text-gray-500 mt-1">Visit the official recruitment page for full details and application instructions.</p>
                    </div>
                    @auth
                        <a href="{{ $jobVacancy->url }}" target="_blank" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-xl shadow-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto w-full transition-all hover:-translate-y-0.5">
                            Apply Now
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 border border-indigo-200 text-base font-bold rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto w-full transition-all hover:-translate-y-0.5">
                            Login to Apply
                            <svg class="ml-2 -mr-1 w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
