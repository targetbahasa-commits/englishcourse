@component('layouts.dashboard')
    @slot('pageTitle')
        Scholarship Search
    @endslot

<div class="w-full flex flex-col lg:flex-row gap-6">
    
    <!-- Main Content Column -->
    <div class="flex-1 min-w-0">

    <!-- Expanded Hero Section -->
    <div class="bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 rounded-2xl md:rounded-3xl p-6 md:p-12 text-white mb-8 md:mb-10 shadow-2xl relative overflow-hidden">
        <!-- Abstract Decoration -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-blue-200 text-xs md:text-sm font-semibold mb-4 md:mb-6 backdrop-blur-md">
                <span>✨</span> AI-Powered Match
            </div>
            <h1 class="text-2xl md:text-5xl font-black mb-3 md:mb-4 leading-tight">
                Find Scholarships That Match Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">English Level</span> 🎓
            </h1>
            <p class="text-sm md:text-xl text-blue-100 mb-6 md:mb-8 opacity-90 leading-relaxed max-w-2xl">
                Discover opportunities around the world and see which ones match your IELTS / TOEFL score instantly. Stop guessing, start applying.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                <a href="#scholarship-grid" class="inline-flex justify-center items-center px-6 md:px-8 py-3 md:py-4 bg-white text-indigo-900 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-lg hover:-translate-y-1 text-sm md:text-base">
                    Find Scholarships
                </a>
                @guest
                <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="inline-flex justify-center items-center px-6 md:px-8 py-3 md:py-4 bg-indigo-600 border border-indigo-500 text-white font-bold rounded-xl hover:bg-indigo-500 transition-all shadow-lg hover:-translate-y-1 text-sm md:text-base">
                    Take Free English Test
                </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Modern Filter Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-3">
            <h2 class="text-base md:text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Search Scholarships
            </h2>
            <a href="{{ route('scholarships.search.index') }}" class="text-xs md:text-sm font-semibold text-gray-500 hover:text-red-500 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Clear Filters
            </a>
        </div>
        
        <div class="p-4 md:p-6">
            <form action="{{ route('scholarships.search.index') }}" method="GET">
                <div class="mb-6 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="scholarship-grid" value="{{ request('search') }}" placeholder="Search by name, provider, or location..." 
                           class="pl-11 block w-full py-3.5 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-gray-700 transition-shadow">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Country</label>
                        <select name="country" class="block w-full py-3 pl-4 pr-10 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-gray-700 text-sm appearance-none">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Degree Level</label>
                        <select name="degree_level" class="block w-full py-3 pl-4 pr-10 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-gray-700 text-sm appearance-none">
                            <option value="">All Levels</option>
                            @foreach($degreeLevels as $level)
                                <option value="{{ $level }}" {{ request('degree_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Funding Type</label>
                        <select name="funding_type" class="block w-full py-3 pl-4 pr-10 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-gray-700 text-sm appearance-none">
                            <option value="">All Types</option>
                            @foreach($fundingTypes as $type)
                                <option value="{{ $type }}" {{ request('funding_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Major</label>
                        <select name="major" class="block w-full py-3 pl-4 pr-10 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-gray-700 text-sm appearance-none">
                            <option value="">All Majors</option>
                            @foreach($majors as $major)
                                <option value="{{ $major }}" {{ request('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-3 w-full sm:w-auto overflow-x-auto pb-2 sm:pb-0 scrollbar-hide">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Popular:</span>
                        <a href="?search=Germany+Masters" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors">Germany Masters</a>
                        <a href="?search=Japan" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors">Japan Scholarship</a>
                        <a href="?search=Nursing" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors">Nursing</a>
                        <a href="?search=Engineering" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors">Engineering</a>
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-md shadow-indigo-200 shrink-0">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- How Smart Match Works (Replaces old Guest Lead Magnet) -->
    <div class="mb-8 md:mb-10 bg-gradient-to-r from-slate-900 to-indigo-950 rounded-2xl p-5 md:p-8 text-white shadow-xl flex flex-col lg:flex-row gap-6 md:gap-8 items-center justify-between relative overflow-hidden group">
        <div class="absolute inset-0 bg-black opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="relative z-10 lg:w-1/3 text-center lg:text-left">
            <h3 class="text-lg md:text-2xl font-black mb-2 flex flex-col sm:flex-row items-center lg:items-start gap-2 text-indigo-200">
                <svg class="w-6 h-6 md:w-8 md:h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                How Smart Match Works
            </h3>
            <p class="text-slate-300 text-xs md:text-sm leading-relaxed max-w-sm mx-auto lg:mx-0">Stop reading endless requirements manually. Our system does the heavy lifting for you.</p>
        </div>
        
        <div class="relative z-10 lg:w-2/3 flex flex-col sm:flex-row gap-4 w-full">
            <div class="flex-1 bg-white/5 backdrop-blur-md rounded-xl p-4 border border-white/10 hover:bg-white/10 transition-colors">
                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white font-bold flex items-center justify-center mb-3 text-sm">1</div>
                <h4 class="font-bold text-white text-sm mb-1">Take Free Test</h4>
                <p class="text-xs text-indigo-200">Test your English level for free in 15 mins.</p>
            </div>
            <div class="flex-1 bg-white/5 backdrop-blur-md rounded-xl p-4 border border-white/10 flex flex-col justify-center relative hover:bg-white/10 transition-colors">
                <div class="hidden sm:block absolute top-1/2 -left-3 w-6 h-0.5 bg-indigo-500/50"></div>
                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white font-bold flex items-center justify-center mb-3 text-sm">2</div>
                <h4 class="font-bold text-white text-sm mb-1">Get Estimated Score</h4>
                <p class="text-xs text-indigo-200">We predict your equivalent IELTS/TOEFL score.</p>
            </div>
            <div class="flex-1 bg-indigo-600 rounded-xl p-4 border border-indigo-400 shadow-lg shadow-indigo-500/30 transform group-hover:-translate-y-1 transition-all relative">
                <div class="hidden sm:block absolute top-1/2 -left-3 w-6 h-0.5 bg-indigo-500/50"></div>
                <div class="w-8 h-8 rounded-full bg-yellow-400 text-indigo-900 font-black flex items-center justify-center mb-3 text-sm">3</div>
                <h4 class="font-bold text-white text-sm mb-1">See Matches</h4>
                <p class="text-xs text-indigo-100">Eligible scholarships are highlighted <span class="text-green-300 font-bold">Green!</span></p>
            </div>
        </div>
    </div>

    <!-- Scholarship Grid -->
    @if($scholarships->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($scholarships as $scholarship)
                @php
                    // Smart Match Eligibility Logic
                    $isEligible = null; // null = pending/guest, true = eligible, false = not eligible
                    $missingScores = [];
                    
                    if ($predictedScore) {
                        $isEligible = true;
                        if ($scholarship->min_ielts && $predictedScore['ielts'] < $scholarship->min_ielts) {
                            $isEligible = false;
                            $missingScores[] = "IELTS (Needs {$scholarship->min_ielts}, You hit {$predictedScore['ielts']})";
                        }
                        if ($scholarship->min_toefl && $predictedScore['toefl'] < $scholarship->min_toefl) {
                            $isEligible = false;
                            $missingScores[] = "TOEFL (Needs {$scholarship->min_toefl}, You hit {$predictedScore['toefl']})";
                        }
                        if ($scholarship->min_ielts && !$predictedScore['ielts']) {
                            $isEligible = false;
                            $missingScores[] = "IELTS (Needs {$scholarship->min_ielts}, No Data)";
                        }
                        if ($scholarship->min_toefl && !$predictedScore['toefl']) {
                            $isEligible = false;
                            $missingScores[] = "TOEFL (Needs {$scholarship->min_toefl}, No Data)";
                        }
                    }
                @endphp
                
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition group relative flex flex-col h-full">
                    
                    <!-- Cover Image or Placeholder -->
                    <div class="h-44 bg-blue-50 flex items-center justify-center relative overflow-hidden">
                        @if($scholarship->image_path)
                            <img src="{{ asset('storage/' . $scholarship->image_path) }}" alt="{{ $scholarship->title }}" class="w-full h-full object-contain p-4 mix-blend-multiply group-hover:scale-105 transition duration-500">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-50 opacity-80 z-0"></div>
                            <svg class="w-16 h-16 text-blue-200 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        @endif

                        <!-- Bookmark Button -->
                        @auth
                            <button onclick="toggleBookmark({{ $scholarship->id }}, this)" 
                                    class="absolute top-3 right-3 p-2 rounded-full cursor-pointer transition z-20 shadow-sm
                                    {{ in_array($scholarship->id, $savedScholarshipIds) ? 'bg-yellow-100 text-yellow-600 border-yellow-200' : 'bg-white/90 text-gray-400 hover:text-yellow-500 hover:bg-white backdrop-blur-sm shadow' }}">
                                <svg class="w-5 h-5" fill="{{ in_array($scholarship->id, $savedScholarshipIds) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            </button>
                        @endauth
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-3 gap-2">
                            <div class="text-xl inline-flex items-center" title="{{ $scholarship->country ?? 'Global' }}">
                                @php
                                    $countryLower = strtolower($scholarship->country ?? '');
                                    $flag = '🌍';
                                    if(str_contains($countryLower, 'germany')) $flag = '🇩🇪';
                                    if(str_contains($countryLower, 'australia')) $flag = '🇦🇺';
                                    if(str_contains($countryLower, 'japan')) $flag = '🇯🇵';
                                    if(str_contains($countryLower, 'uk') || str_contains($countryLower, 'kingdom')) $flag = '🇬🇧';
                                    if(str_contains($countryLower, 'usa') || str_contains($countryLower, 'states')) $flag = '🇺🇸';
                                    if(str_contains($countryLower, 'canada')) $flag = '🇨🇦';
                                    if(str_contains($countryLower, 'korea')) $flag = '🇰🇷';
                                    if(str_contains($countryLower, 'taiwan')) $flag = '🇹🇼';
                                    if(str_contains($countryLower, 'hungary')) $flag = '🇭🇺';
                                    if(str_contains($countryLower, 'indonesia')) $flag = '🇮🇩';
                                @endphp
                                {{ $flag }} <span class="text-xs font-bold text-gray-700 uppercase tracking-wider align-middle ml-2 px-2 py-0.5 bg-gray-100 rounded-md">{{ $scholarship->country ?? 'Global' }}</span>
                            </div>
                            
                            <!-- Eligibility Badge -->
                            @auth
                                @if(auth()->user()->isStudent())
                                    @if($isEligible === true)
                                        <div class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-lg flex items-center gap-1.5 shadow-sm whitespace-nowrap" title="Your Predicted Score matches the requirements!">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                            Eligible
                                        </div>
                                    @elseif($isEligible === false)
                                        <div class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-lg flex items-center gap-1.5 shadow-sm whitespace-nowrap cursor-help" title="Gaps: {{ implode(' | ', $missingScores) }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> 
                                            Score Gap
                                        </div>
                                    @endif
                                @endif
                            @endauth
                        </div>

                        <h3 class="text-lg md:text-xl font-bold text-gray-900 line-clamp-2 mb-1 group-hover:text-blue-700 transition">{{ $scholarship->title }}</h3>
                        @if(strtolower($scholarship->provider) !== 'luarkampus.id')
                        <p class="text-sm font-medium text-gray-500 mb-4">{{ $scholarship->provider }}</p>
                        @endif

                        <div class="space-y-2 mt-auto">
                            <!-- Degree & Funding Level -->
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-1.5 text-sm text-gray-600 font-medium">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                    {{ $scholarship->level_of_study }}
                                </div>
                                @if($scholarship->funding_type)
                                    <div class="flex items-center gap-1.5 text-sm text-gray-600 font-medium">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6"></path></svg>
                                        {{ $scholarship->funding_type }}
                                    </div>
                                @endif
                            </div>

                            <!-- Requirements -->
                            <div class="flex items-center gap-1.5 text-sm text-gray-600 font-medium bg-gray-50 p-2 rounded-lg">
                                <svg class="w-4 h-4 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @php
                                    $reqs = [];
                                    if($scholarship->min_ielts) $reqs[] = "IELTS: ".$scholarship->min_ielts;
                                    if($scholarship->min_toefl) $reqs[] = "TOEFL: ".$scholarship->min_toefl;
                                @endphp
                                <span class="truncate">
                                    {{ count($reqs) > 0 ? implode(' / ', $reqs) : 'No specific language score' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer with Countdown -->
                    <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                        @if($scholarship->deadline)
                            <div x-data="countdown('{{ $scholarship->deadline->format('Y-m-d H:i:s') }}')" class="flex flex-col">
                                <span class="text-[10px] text-gray-500 uppercase font-black tracking-wider">Time Left</span>
                                <div class="flex items-center gap-1" x-show="!expired">
                                    <div class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-mono font-bold text-sm" x-text="days"></div>:
                                    <div class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-mono font-bold text-sm" x-text="hours"></div>:
                                    <div class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-mono font-bold text-sm" x-text="minutes"></div>
                                </div>
                                <span class="text-sm text-red-600 font-bold bg-red-50 px-2 rounded" x-show="expired">Expired</span>
                            </div>
                        @else
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-500 uppercase font-black tracking-wider">Deadline</span>
                                <span class="text-sm font-bold text-emerald-600">Always Open</span>
                            </div>
                        @endif

                        <a href="{{ route('scholarships.search.show', $scholarship) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm text-sm whitespace-nowrap flex items-center gap-1.5">
                            Details <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $scholarships->links() }}
        </div>
    @else
        <div class="bg-white border border-gray-100 rounded-3xl p-10 md:p-16 text-center shadow-sm max-w-2xl mx-auto flex flex-col items-center">
            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-6 transform rotate-3">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-3">No scholarships match your filters.</h3>
            
            <div class="text-left bg-gray-50 p-6 rounded-2xl mb-8 w-full max-w-sm mx-auto">
                <p class="text-sm font-bold text-gray-700 mb-3">Try one of these options:</p>
                <ul class="space-y-2 text-sm text-gray-600 font-medium">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Reset your search filters</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Search by general Country</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Take a test to unlock Smart Match</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <a href="{{ route('scholarships.search.index') }}" class="inline-flex justify-center items-center px-6 py-3 bg-gray-100 text-gray-800 font-bold rounded-xl hover:bg-gray-200 transition">
                    Reset Filters
                </a>
                <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-md shadow-indigo-200">
                    Take Free Test
                </a>
            </div>
        </div>
    @endif
    
    </div> <!-- Close Main Content Column -->

    <!-- Right Sidebar Column -->
    <div class="w-full lg:w-[420px] xl:w-[460px] shrink-0 space-y-6 mt-8 lg:mt-0 lg:pr-4 xl:pr-8">
        
        @guest
        <!-- Lead Gen: Free English Test -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group">
            <div class="absolute inset-0 bg-black opacity-10 group-hover:opacity-20 transition-opacity" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm flex items-center justify-center mb-4 text-2xl shadow-inner">
                    🎯
                </div>
                <h3 class="text-xl font-black mb-2">Don't guess your eligibility!</h3>
                <p class="text-indigo-100 text-sm mb-6 leading-relaxed">Most top scholarships require IELTS 6.5+ or TOEFL 550+. Find out your current level instantly and unlock Smart Match.</p>
                <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="block w-full text-center py-3.5 bg-white text-indigo-700 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-md shadow-black/10 hover:-translate-y-0.5">
                    Take Free Test Now
                </a>
            </div>
        </div>
        @endguest

        <!-- Alumni Stories -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-50 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-2xl">🎓</span>
                    Alumni Success
                </h3>
                <div class="relative bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <svg class="absolute top-2 left-2 w-8 h-8 text-indigo-100" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H6c0-2.2 1.8-4 4-4V8zm18 0c-3.3 0-6 2.7-6 6v10h10V14h-8c0-2.2 1.8-4 4-4V8z"></path></svg>
                    <p class="text-gray-700 text-sm italic relative z-10 font-medium leading-relaxed mb-4 pl-6 pt-2">
                        "Berkat prediksi skor IELTS Target Bahasa, saya bisa tahu saya eligible untuk LPDP. Sekarang saya kuliah Master di UK!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-sm">
                            AS
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Anisa S.</p>
                            <p class="text-xs text-indigo-600 font-semibold">LPDP Awardee 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Always Open Academic Calendar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                Academic Calendar
            </h3>
            
            @include('components.academic-calendar-inline')
        </div>

        <!-- Latest News Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <div class="p-1.5 bg-red-50 text-red-500 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"></path></svg>
                </div>
                Latest News
            </h3>
            
            <div class="space-y-4">
                @forelse($latestNews as $index => $news)
                    <a href="{{ $news->url ?? '#' }}" {{ $news->url ? 'target="_blank"' : '' }} class="flex gap-3 group {{ $index > 0 ? 'border-t border-gray-100 pt-4' : '' }}">
                        <div class="w-16 h-16 rounded-xl bg-gray-50 shrink-0 overflow-hidden border border-gray-100">
                            @if($news->image_path)
                                <img src="{{ asset('storage/' . $news->image_path) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 flex flex-col justify-center">
                            <p class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-snug">{{ $news->title }}</p>
                            <p class="text-[10px] text-gray-500 mt-1 bg-gray-50 px-2 py-0.5 rounded inline-flex w-max items-center gap-1 font-semibold uppercase tracking-wider">
                                <svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->diffForHumans() : $news->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="text-sm text-gray-500 text-center py-4 bg-gray-50 rounded-xl">
                        No recent news available.
                    </div>
                @endforelse
            </div>
            
            @if(!empty($latestNews))
            <a href="#" class="mt-4 block text-center text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">
                View All News →
            </a>
            @endif

        </div> <!-- Close Right Sidebar Column -->
        </div> <!-- Close Main Content Column -->
    </div> <!-- Close Main Flex Container -->
    @endcomponent

@push('scripts')
<script>
    // Set the API URL for the Alpine.js academicCalendar component
    window.calendarEventsUrl = '{{ route("api.scholarships.calendar-events") }}';

    function toggleBookmark(scholarshipId, btnElement) {
        @guest
            // Redirect to login if guest tries to bookmark
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
                btnElement.classList.replace('bg-white/90', 'bg-yellow-100');
                btnElement.classList.replace('text-gray-400', 'text-yellow-600');
                btnElement.classList.add('border-yellow-200');
                btnElement.classList.remove('hover:bg-white', 'hover:text-yellow-500');
                svg.setAttribute('fill', 'currentColor');
            } else if (data.status === 'unsaved') {
                btnElement.classList.replace('bg-yellow-100', 'bg-white/90');
                btnElement.classList.replace('text-yellow-600', 'text-gray-400');
                btnElement.classList.remove('border-yellow-200');
                btnElement.classList.add('hover:bg-white', 'hover:text-yellow-500');
                svg.setAttribute('fill', 'none');
            }
        })
        .catch(error => {
            console.error('Error toggling bookmark:', error);
        });
    }
</script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
