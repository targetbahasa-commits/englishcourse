@component('layouts.dashboard')
    @slot('pageTitle')
        {{ $scholarship->title }}
    @endslot

<!-- ...existing code... -->
    
    <!-- Top Bar: Back Button & Academic Calendar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-2 sm:gap-4">
        <a href="{{ route('scholarships.search.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Search
        </a>

        <!-- Academic Calendar Mini Widget -->
        <div class="z-30">
            @include('components.academic-calendar')
        </div>
    </div>

    <!-- Header Card -->
    <section class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8 relative">
        <div class="h-40 sm:h-48 bg-gradient-to-r from-blue-600 to-indigo-800 relative flex items-center p-4 sm:p-8 lg:p-10">
            <!-- Decorative elements -->
            <div class="absolute right-0 top-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-white opacity-10 blur-3xl"></div>
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 sm:gap-6 relative z-10 w-full mb-[-3rem]">
                <!-- Scholarship Image/Logo -->
                <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 shrink-0 bg-white rounded-2xl shadow-lg border-4 border-white flex items-center justify-center p-2 overflow-hidden mt-6 md:mt-12">
                    @if($scholarship->image_path)
                        <img src="{{ asset('storage/' . $scholarship->image_path) }}" alt="{{ $scholarship->title }} Logo" class="w-full h-full object-contain">
                    @else
                        <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    @endif
                </div>

                <!-- Title & Provider (White text on gradient) -->
                <div class="md:mt-2 text-white">
                    <div class="flex flex-wrap gap-2 mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-white/20 backdrop-blur-sm text-white border border-white/30 uppercase tracking-widest">
                            {{ $scholarship->country ?? 'Global' }}
                        </span>
                        @if($scholarship->funding_type)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-emerald-400/20 backdrop-blur-sm text-emerald-100 border border-emerald-400/30 uppercase tracking-widest">
                                {{ $scholarship->funding_type }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 shadow-sm">{{ $scholarship->title }}</h1>
                    @if(strtolower($scholarship->provider) !== 'luarkampus.id')
                    <p class="text-lg text-blue-100 font-medium flex items-center">
                        {{ $scholarship->provider }}
                    </p>
                    @endif
                </div>
            </div>
            
            <!-- Bookmark Button Absolute Top Right -->
            @auth
                <button onclick="toggleBookmark({{ $scholarship->id }}, this)" 
                        class="absolute top-6 right-6 p-3 rounded-full cursor-pointer transition z-20 shadow-md backdrop-blur-md
                        {{ in_array($scholarship->id, $savedScholarshipIds) ? 'bg-yellow-400 text-white' : 'bg-white/20 text-white hover:bg-white/40' }}">
                    <svg class="w-6 h-6" fill="{{ in_array($scholarship->id, $savedScholarshipIds) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                </button>
            @endauth
        </div>

        <div class="px-6 pt-8 pb-6 bg-white flex flex-col gap-6 border-t border-gray-100">
            <div class="flex flex-col gap-4 w-full md:w-auto">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center text-sm text-gray-700 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100 w-full">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400 font-bold uppercase tracking-wider">Level</span>
                            <span class="font-bold text-gray-800">{{ $scholarship->level_of_study }}</span>
                        </div>
                    </div>
                    <div class="flex items-center text-sm bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100 w-full">
                        <div class="w-10 h-10 rounded-full {{ $scholarship->deadline && $scholarship->deadline->isPast() ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600' }} flex items-center justify-center mr-3 shrink-0" x-data="countdown('{{ $scholarship->deadline ? $scholarship->deadline->format('Y-m-d H:i:s') : '' }}')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs {{ $scholarship->deadline && $scholarship->deadline->isPast() ? 'text-red-400' : 'text-gray-400' }} font-bold uppercase tracking-wider">Deadline</span>
                            @if($scholarship->deadline)
                                <span class="font-bold {{ $scholarship->deadline->isPast() ? 'text-red-600' : 'text-gray-800' }}">{{ $scholarship->deadline->format('d M Y') }}</span>
                            @else
                                <span class="font-bold text-gray-800">Always Open</span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex flex-row gap-4 items-center mt-4">
                <!-- WhatsApp Share / Consult -->
                @php
                    // Create a WhatsApp share link
                    $message = "Hi! I found this interesting scholarship: *{$scholarship->title}* on Target Bahasa. Check it out: " . route('scholarships.search.show', $scholarship);
                    $waLink = "https://wa.me/?text=" . urlencode($message);
                    
                    // Google Calendar Link
                    $gcalTitle = urlencode("Beasiswa: " . $scholarship->title);
                    $gcalDetails = urlencode("Link: " . route('scholarships.search.show', $scholarship));
                    $gcalDates = "";
                    if($scholarship->deadline) {
                        $start = $scholarship->deadline->format('Ymd\\THis\\Z');
                        $end = $scholarship->deadline->copy()->addHour()->format('Ymd\\THis\\Z');
                        $gcalDates = "&dates={$start}/{$end}";
                    }
                    $gcalLink = "https://calendar.google.com/calendar/r/eventedit?text={$gcalTitle}{$gcalDates}&details={$gcalDetails}";
                @endphp
                
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <a href="{{ $waLink }}" target="_blank" class="flex-1 lg:flex-none inline-flex items-center justify-center p-3.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-xl transition-colors duration-200 border border-green-200" title="Share via WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                    
                    @if($scholarship->deadline)
                    <a href="{{ $gcalLink }}" target="_blank" class="flex-1 lg:flex-none inline-flex items-center justify-center p-3.5 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-xl transition-colors duration-200 border border-gray-200" title="Add to Google Calendar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </a>
                    @endif
                </div>

                @auth
                <button id="targetBtn" onclick="toggleTarget({{ $scholarship->id }}, this)" 
                        data-is-target="{{ $targetScholarshipId === $scholarship->id ? 'true' : 'false' }}"
                        class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3.5 font-bold rounded-xl transition-all shadow-sm border
                        {{ $targetScholarshipId === $scholarship->id ? 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                    <span class="mr-2">{{ $targetScholarshipId === $scholarship->id ? '🎯 Targeted' : 'Set as Target' }}</span>
                    <svg class="w-5 h-5 {{ $targetScholarshipId === $scholarship->id ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </button>
                @endauth
                
                @auth
                    <a href="{{ $scholarship->apply_link }}" target="_blank" class="w-full lg:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold rounded-xl transition-all shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] hover:shadow-[0_6px_20px_rgba(37,99,235,0.23)] hover:-translate-y-0.5">
                        Apply Officially
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                @else
                    <button onclick="openInquiryModal()" class="w-full lg:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5">
                        Consult with Expert
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </button>
                    <a href="{{ route('login') }}" class="w-full lg:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5" onclick="alert('Please login or create an account to view application details.')">
                        Login to Apply
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </a>
                @endauth
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left Column: Requirements & Details -->
        <div class="flex flex-col gap-6 w-full md:col-span-2">
            
            <!-- Eligibility Checklist -->
            <section class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4C10.5 7.5 14.5 7.5 16 9c1.5 1.5 1.5 5.5 0 7-1.5 1.5-5.5 1.5-7 0-1.5-1.5-1.5-5.5 0-7z"></path></svg>
                    </div>
                    Key Requirements
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <div class="flex items-start gap-3 p-4 rounded-xl border {{ $scholarship->min_ielts ? 'border-purple-100 bg-purple-50' : 'border-gray-100 bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0 {{ $scholarship->min_ielts ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                        <div>
                            <p class="text-sm font-bold text-gray-800">IELTS Minimum</p>
                            <p class="text-sm {{ $scholarship->min_ielts ? 'text-purple-700 font-bold text-lg' : 'text-gray-500' }}">
                                {{ $scholarship->min_ielts ?? 'Not specified' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl border {{ $scholarship->min_toefl ? 'border-purple-100 bg-purple-50' : 'border-gray-100 bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0 {{ $scholarship->min_toefl ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                        <div>
                            <p class="text-sm font-bold text-gray-800">TOEFL Minimum</p>
                            <p class="text-sm {{ $scholarship->min_toefl ? 'text-purple-700 font-bold text-lg' : 'text-gray-500' }}">
                                {{ $scholarship->min_toefl ?? 'Not specified' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl border {{ $scholarship->min_gpa ? 'border-blue-100 bg-blue-50' : 'border-gray-100 bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0 {{ $scholarship->min_gpa ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Minimum GPA</p>
                            <p class="text-sm {{ $scholarship->min_gpa ? 'text-blue-700 font-bold text-lg' : 'text-gray-500' }}">
                                {{ $scholarship->min_gpa ?? 'Not specified' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl border {{ $scholarship->max_age ? 'border-blue-100 bg-blue-50' : 'border-gray-100 bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0 {{ $scholarship->max_age ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Maximum Age</p>
                            <p class="text-sm {{ $scholarship->max_age ? 'text-blue-700 font-bold text-lg' : 'text-gray-500' }}">
                                {{ $scholarship->max_age ? $scholarship->max_age . ' Years' : 'Not specified' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Add eligible majors list if exists -->
                @if($scholarship->majors && count($scholarship->majors) > 0)
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <p class="text-sm font-bold text-gray-800 mb-3">Eligible Fields of Study:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($scholarship->majors as $major)
                                <span class="px-3 py-1 bg-gray-100 border border-gray-200 text-gray-700 text-xs rounded-full">{{ $major }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Description -->
            <section class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    About This Scholarship
                </h2>
                <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed whitespace-pre-line text-[15px]">
                    {{ $scholarship->description }}
                </div>
            </div>

            <!-- Full Requirements Rules -->
            @if($scholarship->requirements)
            <section class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-600 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    Full Eligibility Rules
                </h2>
                <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed whitespace-pre-line text-[15px]">
                    {{ $scholarship->requirements }}
                </div>
            </div>
            @endif

        </div>

        <!-- Right Column: Sidebar Data -->
        <div class="flex flex-col gap-6 w-full md:col-span-1">

            <!-- Benefits JSON parser -->
            <section class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center pb-4 border-b border-gray-100">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-3 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    Coverage & Benefits
                </h3>
                
                @if($scholarship->benefits)
                    <div class="space-y-3">
                        @php
                            $benefitsStr = $scholarship->benefits;
                            // Attempt to decode if json, else show as string
                            $decoded = json_decode($benefitsStr, true);
                            $benefitsList = json_last_error() === JSON_ERROR_NONE && is_array($decoded) ? $decoded : explode("\n", $benefitsStr);
                        @endphp
                        
                        @foreach($benefitsList as $key => $benefit)
                            @if(trim($benefit) !== '')
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-gray-700 text-[15px]">
                                        {{ is_string($key) ? ucfirst($key) . ': ' : '' }}{{ $benefit }}
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Benefits details are not explicitly provided. Please check the official website.</p>
                @endif
                
                @if($scholarship->has_work_contract)
                    <div class="mt-4 p-3 sm:p-4 bg-orange-50 border border-orange-100 rounded-xl flex items-start">
                        <svg class="w-5 h-5 text-orange-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-sm font-medium text-orange-800">Note: This scholarship involves a work contract or post-study obligation.</p>
                    </div>
                @endif
            </div>
            
            <!-- Target Bahasa CTA widget -->
            @guest
                <div class="bg-gradient-to-br from-blue-700 to-indigo-800 rounded-2xl shadow-md border border-blue-600 p-4 sm:p-6 md:p-8 text-white text-center relative overflow-hidden group w-full max-w-md mx-auto mb-4 md:mb-0 break-words">
                    <div class="absolute -right-16 -top-16 w-32 h-32 rounded-full bg-white opacity-10 blur-xl group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-3 sm:mb-4">
                        <span class="text-3xl">🎯</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3 relative z-10">Do you qualify?</h3>
                    <p class="text-blue-100 mb-6 text-[15px] leading-relaxed relative z-10">
                        Take our free diagnostic test to predict your score and see if you meet the requirements for this scholarship!
                    </p>
                    <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="inline-block w-full py-2.5 sm:py-3 bg-white text-blue-700 font-bold rounded-xl transition-all shadow-[0_4px_14px_0_rgba(255,255,255,0.2)] hover:shadow-[0_6px_20px_rgba(255,255,255,0.3)] hover:-translate-y-0.5 relative z-10">
                        Take Free Test
                    </a>
                </div>
            @endguest

            @auth
                <!-- Language Prep CTA Widget for active students -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow border border-indigo-100 p-4 sm:p-6 relative overflow-hidden w-full max-w-md mx-auto mb-4 md:mb-0 break-words">
                    <div class="absolute right-0 bottom-0 opacity-10">
                         <svg class="w-32 h-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-indigo-900 mb-2 relative z-10">Need a higher score?</h3>
                    <p class="text-indigo-700/80 text-sm mb-6 relative z-10">
                        {{ $scholarship->min_ielts || $scholarship->min_toefl ? 'Ensure you hit the minimum requirements.' : 'A high score makes you stand out.' }} 
                        Join our intensive preparation programs.
                    </p>
                    <a href="#" class="inline-block w-full text-center py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors shadow-sm relative z-10">
                        View Study Programs
                    </a>
                </div>
            @endauth

        </div>
    </div>

    <!-- Quick Inquiry Modal -->
    <div id="inquiryModal" class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 backdrop-blur-sm p-4 sm:p-0">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl transition-all">
            <!-- Modal header -->
            <div class="flex items-center justify-between rounded-t-2xl border-b border-gray-100 px-6 py-4">
                <h3 class="text-xl font-bold text-gray-900">
                    Consult with an Expert
                </h3>
                <button type="button" onclick="closeInquiryModal()" class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-6">Want to know more about the <span class="font-bold text-blue-600">{{ $scholarship->title }}</span>? Leave your details and our expert will contact you shortly.</p>
                <form id="inquiryForm" class="space-y-4">
                    <input type="hidden" name="source" value="scholarship">
                    <input type="hidden" name="source_detail" value="{{ $scholarship->title }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number <span class="text-red-500">*</span></label>
                        <input type="text" name="whatsapp" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5" placeholder="e.g. 081234567890">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5" placeholder="Optional">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Questions / Notes</label>
                        <textarea name="notes" rows="3" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5" placeholder="What would you like to know?"></textarea>
                    </div>

                    <div id="inquiryAlert" class="hidden p-4 mb-4 text-sm rounded-xl"></div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" onclick="closeInquiryModal()" class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">Cancel</button>
                        <button type="submit" id="inquirySubmitBtn" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Submit Inquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
@endcomponent

@push('scripts')
<script>
    // Set the API URL for the Alpine.js academicCalendar component
    window.calendarEventsUrl = '{{ route("api.scholarships.calendar-events") }}';

    function toggleBookmark(scholarshipId, btnElement) {
        @guest
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        fetch(`/scholarships-search/${scholarshipId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const svg = btnElement.querySelector('svg');
            if (data.status === 'saved') {
                btnElement.className = "absolute top-6 right-6 p-3 rounded-full cursor-pointer transition z-20 shadow-md backdrop-blur-md bg-yellow-400 text-white";
                svg.setAttribute('fill', 'currentColor');
            } else if (data.status === 'unsaved') {
                btnElement.className = "absolute top-6 right-6 p-3 rounded-full cursor-pointer transition z-20 shadow-md backdrop-blur-md bg-white/20 text-white hover:bg-white/40";
                svg.setAttribute('fill', 'none');
            }
        })
        .catch(error => {
            console.error('Error toggling bookmark:', error);
        });
    }

    function toggleTarget(scholarshipId, btnElement) {
        @guest
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        const isCurrentlyTarget = btnElement.getAttribute('data-is-target') === 'true';
        
        fetch(`/scholarships-search/${scholarshipId}/target`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const span = btnElement.querySelector('span');
            const svg = btnElement.querySelector('svg');
            
            if (data.status === 'targeted') {
                btnElement.setAttribute('data-is-target', 'true');
                btnElement.className = "w-full lg:w-auto inline-flex items-center justify-center px-6 py-3.5 font-bold rounded-xl transition-all shadow-sm border bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100";
                span.innerText = "🎯 Targeted";
                svg.classList.remove('text-gray-400');
                svg.classList.add('text-indigo-600');
                
                // Optional: show a small toast/alert
                alert(data.message);
                
            } else if (data.status === 'untargeted') {
                btnElement.setAttribute('data-is-target', 'false');
                btnElement.className = "w-full lg:w-auto inline-flex items-center justify-center px-6 py-3.5 font-bold rounded-xl transition-all shadow-sm border bg-white text-gray-700 border-gray-200 hover:bg-gray-50";
                span.innerText = "Set as Target";
                svg.classList.remove('text-indigo-600');
                svg.classList.add('text-gray-400');
            }
        })
        .catch(error => {
            console.error('Error toggling target:', error);
        });
    }

    // Modal Logic
    const inquiryModal = document.getElementById('inquiryModal');
    const inquiryForm = document.getElementById('inquiryForm');
    const inquirySubmitBtn = document.getElementById('inquirySubmitBtn');
    const inquiryAlert = document.getElementById('inquiryAlert');

    function openInquiryModal() {
        inquiryModal.classList.remove('hidden');
        inquiryModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeInquiryModal() {
        inquiryModal.classList.add('hidden');
        inquiryModal.classList.remove('flex');
        document.body.style.overflow = '';
        inquiryForm.reset();
        inquiryAlert.classList.add('hidden');
    }

    inquiryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(inquiryForm);
        const data = Object.fromEntries(formData.entries());
        
        inquirySubmitBtn.disabled = true;
        inquirySubmitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Submitting...';
        
        fetch('{{ route("public.inquiry.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            inquiryAlert.classList.remove('hidden', 'bg-red-50', 'text-red-800');
            inquiryAlert.classList.add('bg-green-50', 'text-green-800');
            inquiryAlert.innerHTML = res.message || 'Success! We will contact you soon.';
            inquirySubmitBtn.innerHTML = 'Submitted';
            
            setTimeout(() => {
                closeInquiryModal();
                inquirySubmitBtn.disabled = false;
                inquirySubmitBtn.innerHTML = 'Submit Inquiry';
            }, 2500);
        })
        .catch(err => {
            console.error(err);
            inquiryAlert.classList.remove('hidden', 'bg-green-50', 'text-green-800');
            inquiryAlert.classList.add('bg-red-50', 'text-red-800');
            inquiryAlert.innerHTML = 'Something went wrong. Please check your inputs and try again.';
            inquirySubmitBtn.disabled = false;
            inquirySubmitBtn.innerHTML = 'Submit Inquiry';
        });
    });

</script>
@endpush
