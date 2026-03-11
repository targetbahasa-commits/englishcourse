@extends('layouts.dashboard')

@section('title', 'Overseas Job Vacancies')

@section('content')

<!-- Hero Section -->
<div class="bg-indigo-600 rounded-3xl p-10 mb-8 text-center sm:text-left relative overflow-hidden flex flex-col sm:flex-row items-center justify-between shadow-xl shadow-indigo-200">
    <div class="relative z-10 max-w-2xl">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-4">Kerja di Luar Negeri dengan Gaji Dollar 💼</h1>
        <p class="text-lg text-indigo-100 mb-8 font-medium">Temukan peluang kerja di Jerman, Australia, Jepang, dan negara lainnya yang sesuai dengan kemampuan bahasa Inggris kamu.</p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="#job-listings" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 shadow-md transition-colors">
                Cari Lowongan
            </a>
            <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 border-2 border-indigo-300 text-base font-bold rounded-xl text-white hover:bg-indigo-500 hover:border-indigo-400 focus:outline-none transition-colors">
                Mulai Tes Bahasa Inggris
            </a>
        </div>
    </div>
    <!-- Decorative element -->
    <svg class="absolute right-0 top-0 h-full w-1/2 text-indigo-500/30 transform translate-x-1/3 -translate-y-1/4 scale-150 rotate-12 pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
</div>

<!-- Langkah Menuju Kerja Section -->
<div class="mb-12">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Langkah Menuju Kerja di Luar Negeri</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center relative border-b-4 border-b-blue-500">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">1</div>
            <h3 class="font-bold text-gray-900 mb-2">Tes Kemampuan</h3>
            <p class="text-sm text-gray-500">Ketahui level bahasa Inggris kamu saat ini.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center relative border-b-4 border-b-indigo-500">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">2</div>
            <h3 class="font-bold text-gray-900 mb-2">Ikuti Kelas</h3>
            <p class="text-sm text-gray-500">Belajar intensif sesuai target negara tujuan.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center relative border-b-4 border-b-purple-500">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">3</div>
            <h3 class="font-bold text-gray-900 mb-2">Dapat Sertifikat</h3>
            <p class="text-sm text-gray-500">Raih sertifikat TOEFL/IELTS resmi.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center relative border-b-4 border-b-green-500">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">4</div>
            <h3 class="font-bold text-gray-900 mb-2">Apply Kerja</h3>
            <p class="text-sm text-gray-500">Wujudkan mimpimu kerja di luar negeri!</p>
        </div>
    </div>
</div>

<div id="job-listings" class="w-full mx-auto relative scroll-mt-6">

    <!-- Filters Bar (Inline) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-8">
        <form method="GET" action="{{ route('overseas-jobs.index') }}" class="flex flex-col lg:flex-row gap-3">
            <!-- Search -->
            <div class="flex-grow">
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search job title or company..."
                           class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm font-medium">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Country -->
            <div class="lg:w-48 shrink-0">
                <div class="relative">
                    <select name="country" class="w-full appearance-none pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm font-medium text-gray-700">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Job Type -->
            <div class="lg:w-48 shrink-0">
                <div class="relative">
                    <select name="job_type" class="w-full appearance-none pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm font-medium text-gray-700">
                        <option value="">All Job Types</option>
                        @foreach($jobTypes as $type)
                            <option value="{{ $type }}" {{ request('job_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- English Req -->
            <div class="lg:w-48 shrink-0">
                <div class="relative">
                    <select name="english_requirement" class="w-full appearance-none pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm font-medium text-gray-700">
                        <option value="">Any English Req</option>
                        @foreach($englishRequirements as $req)
                            <option value="{{ $req }}" {{ request('english_requirement') == $req ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', strtoupper($req)) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Sort By -->
            <div class="lg:w-40 shrink-0">
                <div class="relative">
                    <select name="sort" class="w-full appearance-none pl-4 pr-10 py-3 bg-indigo-50 border border-indigo-100 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm font-bold text-indigo-700">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Most Recent</option>
                        <option value="closing_soon" {{ request('sort') == 'closing_soon' ? 'selected' : '' }}>Closing Soon</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-indigo-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="lg:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-all flex justify-center items-center">
                Search
            </button>
        </form>
    </div>

    <!-- Job Grid -->
    @if($jobVacancies->count() > 0)
        <!-- LinkedIn Style Job Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            @foreach($jobVacancies as $job)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col h-full relative group">
                    <!-- Badges -->
                    <div class="flex justify-between items-start mb-3">
                        <div class="text-2xl" title="{{ $job->country }}">
                            @php
                                // Simple mapping for flag emojis
                                $countryLower = strtolower($job->country);
                                $flag = '🌍'; // default
                                if(str_contains($countryLower, 'germany')) $flag = '🇩🇪';
                                if(str_contains($countryLower, 'australia')) $flag = '🇦🇺';
                                if(str_contains($countryLower, 'japan')) $flag = '🇯🇵';
                                if(str_contains($countryLower, 'uk') || str_contains($countryLower, 'kingdom')) $flag = '🇬🇧';
                                if(str_contains($countryLower, 'usa') || str_contains($countryLower, 'states')) $flag = '🇺🇸';
                                if(str_contains($countryLower, 'canada')) $flag = '🇨🇦';
                            @endphp
                            {{ $flag }} <span class="text-sm font-semibold text-gray-600 align-middle ml-1">{{ $job->country }}</span>
                        </div>
                        
                        <div class="flex gap-2">
                            @if($job->created_at->diffInDays(now()) < 7)
                                <span class="px-2.5 py-1 text-[10px] uppercase tracking-wider font-bold bg-green-100 text-green-700 rounded-lg">New</span>
                            @endif
                            @if($job->deadline && $job->deadline->diffInDays(now()) <= 14 && $job->deadline->isFuture())
                                <span class="px-2.5 py-1 text-[10px] uppercase tracking-wider font-bold bg-red-100 text-red-700 rounded-lg">Closing Soon</span>
                            @endif
                        </div>
                    </div>

                    <!-- Title & Company -->
                    <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-2">
                        <a href="{{ route('overseas-jobs.show', $job->id) }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ $job->title }}
                        </a>
                    </h3>
                    <p class="text-sm font-semibold text-gray-500 mb-5 flex items-center gap-1.5 border-b border-gray-50 pb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $job->company }}
                    </p>

                    <!-- Job Details Grid -->
                    <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-sm text-gray-600 mb-5">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @if($job->salary)
                            <span class="font-medium truncate text-gray-900">{{ $job->salary }}</span>
                            @else
                            <span class="font-medium truncate text-gray-400">Competitive</span>
                            @endif
                        </div>

                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            @if($job->location)
                            <span class="font-medium truncate">{{ $job->location }}</span>
                            @else
                            <span class="font-medium truncate text-gray-400">Not specified</span>
                            @endif
                        </div>

                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            <span class="font-medium truncate text-gray-900">
                                @if($job->english_requirement && $job->english_requirement !== 'none')
                                    {{ str_replace('_', ' ', strtoupper($job->english_requirement)) }} {{ $job->min_score }}
                                @else
                                    No Specific Req
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex items-start gap-2">
                            @if($job->visa_sponsorship)
                                <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium text-emerald-600 truncate">Visa Sponsored</span>
                            @else
                                @if($job->job_type)
                                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="font-medium truncate">{{ $job->job_type }}</span>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span class="font-medium truncate text-gray-400">Visa varies</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="text-xs text-gray-500 font-medium">
                            @if($job->deadline)
                                @if($job->deadline->isPast())
                                    <span class="text-red-500">Closed</span>
                                @else
                                    Closes {{ $job->deadline->format('d M Y') }}
                                @endif
                            @else
                                <span class="text-green-600">Open</span>
                            @endif
                        </div>
                        <span class="text-sm font-bold text-indigo-600 group-hover:underline">View Details →</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $jobVacancies->links() }}
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100 mb-12">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No jobs found</h3>
            <p class="text-gray-500">Try adjusting your filters or search query to find what you're looking for.</p>
            <a href="{{ route('overseas-jobs.index') }}" class="mt-6 inline-block px-6 py-2 bg-indigo-50 text-indigo-700 font-semibold rounded-lg hover:bg-indigo-100 transition-colors">Clear All Filters</a>
        </div>
    @endif

    <!-- Educational Guide: English Levels -->
    <div class="mb-12 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col md:flex-row gap-8 items-center">
        <div class="md:w-1/3 shrink-0 text-center md:text-left">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto md:mx-0 mb-4 transform -rotate-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Panduan Level Bahasa Inggris</h3>
            <p class="text-gray-500 text-sm">Pahami standar ECFR dan skor tes resmi untuk mengetahui pekerjaan mana yang sesuai dengan kemampuanmu.</p>
        </div>
        <div class="md:w-2/3 grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="block text-xl font-black text-slate-800 mb-1">A2-B1</span>
                <span class="block text-sm font-semibold text-slate-600 mb-2">Basic - Int.</span>
                <p class="text-[10px] text-gray-500 leading-snug">Kerja operasional, hotel & restoran, atau caregiver. (IELTS 4.0 - 5.0)</p>
            </div>
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                <span class="block text-xl font-black text-blue-800 mb-1">B2</span>
                <span class="block text-sm font-semibold text-blue-600 mb-2">Upper Int.</span>
                <p class="text-[10px] text-gray-500 leading-snug">Level standar untuk profesional, engineer, dan visa kerja umum. (IELTS 5.5 - 6.5)</p>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50 border border-indigo-100">
                <span class="block text-xl font-black text-indigo-800 mb-1">C1</span>
                <span class="block text-sm font-semibold text-indigo-600 mb-2">Advanced</span>
                <p class="text-[10px] text-gray-500 leading-snug">Posisi manajerial, medis, spesialis IT senior. (IELTS 7.0 - 8.0)</p>
            </div>
            <div class="p-4 rounded-xl bg-purple-50 border border-purple-100 flex flex-col justify-center items-center text-center">
                <svg class="w-8 h-8 text-purple-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-700 hover:text-purple-900">Uji Levelmu<br>Sekarang →</a>
            </div>
        </div>
    </div>

    <!-- Alumni Story & Job Alert -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
        <!-- Success Story -->
        <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden flex flex-col justify-between shadow-xl">
            <svg class="absolute top-0 right-0 text-slate-800 w-32 h-32 transform translate-x-10 -translate-y-10" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
            <div class="relative z-10">
                <div class="flex items-center gap-1 mb-6 text-yellow-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>
                <p class="text-lg/relaxed font-medium text-slate-200 mb-8 max-w-md">"Belajar TOEFL di Target Bahasa sangat membantu saya menembus skor 600. Berkat itu, aplikasi visa kerja saya ke Australia berjalan mulus dan disetujui tanpa hambatan!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-700 flex items-center justify-center font-bold text-xl text-indigo-300">A</div>
                    <div>
                        <h4 class="font-bold text-white">Andi S.</h4>
                        <p class="text-sm text-slate-400">Software Engineer di Sydney 🇦🇺</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Alert -->
        <div class="bg-indigo-50 rounded-3xl p-8 border border-indigo-100 flex flex-col justify-center shadow-sm">
            <div class="w-12 h-12 bg-white rounded-xl shadow-sm text-indigo-600 flex items-center justify-center mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Notifikasi Lowongan</h3>
            <p class="text-gray-600 mb-6">Jadilah yang pertama tahu saat ada lowongan baru di luar negeri yang sesuai profilmu.</p>
            <form action="#" onsubmit="event.preventDefault(); alert('Siap! Anda akan menerima update lowongan via email.');" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <input type="email" required placeholder="Masukkan email..." class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-sm transition-shadow">
                </div>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-md shrink-0">
                    Berlangganan
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom CTA -->
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl p-10 text-center border border-indigo-100 shadow-sm relative overflow-hidden">
        <svg class="absolute -left-10 -bottom-10 w-40 h-40 text-indigo-100 transform rotate-45" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Belum memenuhi syarat English?</h2>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Sebagian besar lowongan kerja internasional membutuhkan skor resmi. Tingkatkan skor TOEFL atau IELTS kamu sekarang di Target Bahasa.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-md transition-all hover:scale-105">
                    Mulai Tes English Gratis
                </a>
                <a href="#" class="inline-flex justify-center items-center px-6 py-3 border border-indigo-200 text-base font-bold rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 transition-colors">
                    Lihat Kelas Intensif
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
