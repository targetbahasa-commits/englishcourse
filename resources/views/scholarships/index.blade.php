@component('layouts.dashboard')
    @slot('pageTitle')
        Scholarship Search
    @endslot

<div class="w-full flex flex-col lg:flex-row gap-6">
    
    <!-- Main Content Column -->
    <div class="flex-1 min-w-0 overflow-hidden">

    <!-- Hero Section: Desktop Only -->
    <div class="hidden md:block bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 rounded-3xl p-10 text-white mb-8 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-200 text-sm font-semibold mb-4 backdrop-blur-md">
                <span>✨</span> AI-Powered Match
            </div>
            <h1 class="text-4xl font-black mb-3 leading-tight">
                Find Scholarships That Match Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">English Level</span> 🎓
            </h1>
            <p class="text-blue-100 text-lg mb-6 max-w-2xl">Discover opportunities worldwide. Match your IELTS / TOEFL score instantly.</p>
            <div class="flex gap-4">
                <a href="#scholarship-grid" class="inline-flex items-center px-6 py-3 bg-white text-indigo-900 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-lg">Find Scholarships</a>
                @guest
                <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-indigo-500 text-white font-bold rounded-xl hover:bg-indigo-500 transition-all shadow-lg">Free English Test</a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Mobile Hero: Compact Banner -->
    <div class="md:hidden bg-gradient-to-br from-indigo-700 to-purple-800 rounded-2xl p-4 text-white mb-4 shadow-lg">
        <div class="flex items-center gap-3">
            <div class="text-3xl">🎓</div>
            <div>
                <h1 class="text-base font-black leading-tight">Scholarship Search</h1>
                <p class="text-indigo-200 text-xs mt-0.5">Match your English score to scholarships</p>
            </div>
        </div>
        @guest
        <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="mt-3 flex justify-center items-center w-full py-2.5 bg-white text-indigo-700 font-bold rounded-xl text-sm">
            ✨ Take Free English Test
        </a>
        @endguest
    </div>

    <!-- Filter Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Search Scholarships
            </h2>
            <a href="{{ route('scholarships.search.index') }}" class="text-xs font-semibold text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Reset
            </a>
        </div>
        
        <div class="p-4">
            <form action="{{ route('scholarships.search.index') }}" method="GET">
                <!-- Search Input -->
                <div class="mb-4 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="scholarship-grid" value="{{ request('search') }}" placeholder="Search scholarship, country..." 
                           class="pl-9 block w-full py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                </div>
                
                <!-- Filters: 2x2 on mobile, 4 columns on desktop -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Country</label>
                        <select name="country" class="block w-full py-2 pl-2 pr-6 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:ring-1 focus:ring-indigo-500 font-medium text-gray-700 appearance-none">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Degree</label>
                        <select name="degree_level" class="block w-full py-2 pl-2 pr-6 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:ring-1 focus:ring-indigo-500 font-medium text-gray-700 appearance-none">
                            <option value="">All Levels</option>
                            @foreach($degreeLevels as $level)
                                <option value="{{ $level }}" {{ request('degree_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Funding</label>
                        <select name="funding_type" class="block w-full py-2 pl-2 pr-6 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:ring-1 focus:ring-indigo-500 font-medium text-gray-700 appearance-none">
                            <option value="">All Types</option>
                            @foreach($fundingTypes as $type)
                                <option value="{{ $type }}" {{ request('funding_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Major</label>
                        <select name="major" class="block w-full py-2 pl-2 pr-6 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:ring-1 focus:ring-indigo-500 font-medium text-gray-700 appearance-none">
                            <option value="">All Majors</option>
                            @foreach($majors as $major)
                                <option value="{{ $major }}" {{ request('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="flex items-center gap-2 mb-4 overflow-x-auto pb-1 scrollbar-hide">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider shrink-0">Quick:</span>
                    <a href="?search=Germany+Masters" class="px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-[11px] font-semibold whitespace-nowrap transition-colors shrink-0">🇩🇪 Germany</a>
                    <a href="?search=Japan" class="px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-[11px] font-semibold whitespace-nowrap transition-colors shrink-0">🇯🇵 Japan</a>
                    <a href="?search=Nursing" class="px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-[11px] font-semibold whitespace-nowrap transition-colors shrink-0">Nursing</a>
                    <a href="?search=Engineering" class="px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-[11px] font-semibold whitespace-nowrap transition-colors shrink-0">Engineering</a>
                </div>

                <button type="submit" class="w-full py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-md text-sm">
                    Apply Filters
                </button>
            </form>
        </div>
    </div>

    <!-- How Smart Match Works (Desktop Only) -->
    <div class="hidden md:flex mb-8 bg-gradient-to-r from-slate-900 to-indigo-950 rounded-2xl p-6 text-white shadow-xl flex-row gap-8 items-center justify-between relative overflow-hidden group">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="relative z-10 w-1/3">
            <h3 class="text-xl font-black mb-2 flex items-center gap-2 text-indigo-200">
                <svg class="w-7 h-7 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                How Smart Match Works
            </h3>
            <p class="text-slate-300 text-sm">Stop reading requirements manually. We highlight eligible scholarships in green!</p>
        </div>
        <div class="relative z-10 w-2/3 flex gap-4">
            <div class="flex-1 bg-white/5 rounded-xl p-4 border border-white/10">
                <div class="w-7 h-7 rounded-full bg-indigo-500 text-white font-bold flex items-center justify-center mb-2 text-xs">1</div>
                <h4 class="font-bold text-white text-sm mb-1">Take Free Test</h4>
                <p class="text-xs text-indigo-200">Test your English in 15 mins.</p>
            </div>
            <div class="flex-1 bg-white/5 rounded-xl p-4 border border-white/10">
                <div class="w-7 h-7 rounded-full bg-indigo-500 text-white font-bold flex items-center justify-center mb-2 text-xs">2</div>
                <h4 class="font-bold text-white text-sm mb-1">Get Estimated Score</h4>
                <p class="text-xs text-indigo-200">We predict your IELTS/TOEFL score.</p>
            </div>
            <div class="flex-1 bg-indigo-600 rounded-xl p-4 border border-indigo-400 shadow-lg">
                <div class="w-7 h-7 rounded-full bg-yellow-400 text-indigo-900 font-black flex items-center justify-center mb-2 text-xs">3</div>
                <h4 class="font-bold text-white text-sm mb-1">See Matches</h4>
                <p class="text-xs text-indigo-100">Eligible scholarships glow <span class="text-green-300 font-bold">Green!</span></p>
            </div>
        </div>
    </div>

    <!-- Scholarship Grid -->
    @if($scholarships->count() > 0)
        <!-- Mobile: compact list style; Desktop: card grid -->
        <div class="space-y-3 md:hidden">
            @foreach($scholarships as $scholarship)
                @php
                    $isEligible = null;
                    $missingScores = [];
                    if ($predictedScore) {
                        $isEligible = true;
                        if ($scholarship->min_ielts && $predictedScore['ielts'] < $scholarship->min_ielts) { $isEligible = false; $missingScores[] = "IELTS (Needs {$scholarship->min_ielts})"; }
                        if ($scholarship->min_toefl && $predictedScore['toefl'] < $scholarship->min_toefl) { $isEligible = false; $missingScores[] = "TOEFL (Needs {$scholarship->min_toefl})"; }
                    }
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
                
                <!-- Mobile Card: horizontal compact -->
                <a href="{{ route('scholarships.search.show', $scholarship) }}" 
                   class="block bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition {{ $isEligible === true ? 'border-l-4 border-l-green-400' : ($isEligible === false ? 'border-l-4 border-l-red-300' : '') }}">
                    <div class="flex gap-3 p-3">
                        <!-- Thumbnail -->
                        <div class="w-16 h-16 rounded-lg bg-blue-50 shrink-0 overflow-hidden flex items-center justify-center">
                            @if($scholarship->image_path)
                                <img src="{{ asset('storage/' . $scholarship->image_path) }}" alt="{{ $scholarship->title }}" class="w-full h-full object-contain p-1.5 mix-blend-multiply">
                            @else
                                <div class="text-2xl">{{ $flag }}</div>
                            @endif
                        </div>
                        
                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-1 mb-1">
                                <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight flex-1">{{ $scholarship->title }}</h3>
                                @auth
                                    @if(auth()->user()->isStudent())
                                        @if($isEligible === true)
                                            <span class="shrink-0 text-[10px] bg-green-100 text-green-700 font-bold px-1.5 py-0.5 rounded-lg">✓ Match</span>
                                        @elseif($isEligible === false)
                                            <span class="shrink-0 text-[10px] bg-red-100 text-red-600 font-bold px-1.5 py-0.5 rounded-lg">Gap</span>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-[11px] text-gray-500">{{ $flag }} {{ $scholarship->country ?? 'Global' }}</span>
                                @if($scholarship->level_of_study)
                                    <span class="text-[11px] text-gray-400">• {{ $scholarship->level_of_study }}</span>
                                @endif
                            </div>
                            <div class="mt-1.5 flex items-center justify-between">
                                @if($scholarship->deadline)
                                    <span class="text-[10px] text-red-600 font-semibold bg-red-50 px-1.5 py-0.5 rounded">
                                        Deadline: {{ $scholarship->deadline->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-green-600 font-semibold bg-green-50 px-1.5 py-0.5 rounded">Always Open</span>
                                @endif
                                @php $reqs = []; if($scholarship->min_ielts) $reqs[] = "IELTS {$scholarship->min_ielts}"; if($scholarship->min_toefl) $reqs[] = "TOEFL {$scholarship->min_toefl}"; @endphp
                                @if(count($reqs) > 0)
                                    <span class="text-[10px] text-purple-600 font-semibold">{{ implode(' / ', $reqs) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Desktop: Card Grid -->
        <div class="hidden md:grid grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($scholarships as $scholarship)
                @php
                    $isEligible = null;
                    $missingScores = [];
                    if ($predictedScore) {
                        $isEligible = true;
                        if ($scholarship->min_ielts && $predictedScore['ielts'] < $scholarship->min_ielts) { $isEligible = false; $missingScores[] = "IELTS (Needs {$scholarship->min_ielts}, You hit {$predictedScore['ielts']})"; }
                        if ($scholarship->min_toefl && $predictedScore['toefl'] < $scholarship->min_toefl) { $isEligible = false; $missingScores[] = "TOEFL (Needs {$scholarship->min_toefl}, You hit {$predictedScore['toefl']})"; }
                        if ($scholarship->min_ielts && !$predictedScore['ielts']) { $isEligible = false; $missingScores[] = "IELTS (Needs {$scholarship->min_ielts}, No Data)"; }
                        if ($scholarship->min_toefl && !$predictedScore['toefl']) { $isEligible = false; $missingScores[] = "TOEFL (Needs {$scholarship->min_toefl}, No Data)"; }
                    }
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
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition group relative flex flex-col h-full">
                    <div class="h-44 bg-blue-50 flex items-center justify-center relative overflow-hidden">
                        @if($scholarship->image_path)
                            <img src="{{ asset('storage/' . $scholarship->image_path) }}" alt="{{ $scholarship->title }}" class="w-full h-full object-contain p-4 mix-blend-multiply group-hover:scale-105 transition duration-500">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-50 opacity-80"></div>
                            <span class="text-4xl relative z-10">{{ $flag }}</span>
                        @endif
                        @auth
                            <button onclick="toggleBookmark({{ $scholarship->id }}, this)" 
                                    class="absolute top-3 right-3 p-2 rounded-full cursor-pointer transition z-20 shadow-sm
                                    {{ in_array($scholarship->id, $savedScholarshipIds) ? 'bg-yellow-100 text-yellow-600' : 'bg-white/90 text-gray-400 hover:text-yellow-500' }}">
                                <svg class="w-5 h-5" fill="{{ in_array($scholarship->id, $savedScholarshipIds) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            </button>
                        @endauth
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-3 gap-2">
                            <div class="text-lg">{{ $flag }} <span class="text-xs font-bold text-gray-700 uppercase tracking-wider align-middle ml-1 px-2 py-0.5 bg-gray-100 rounded-md">{{ $scholarship->country ?? 'Global' }}</span></div>
                            @auth
                                @if(auth()->user()->isStudent())
                                    @if($isEligible === true)
                                        <div class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-lg flex items-center gap-1 whitespace-nowrap">✓ Eligible</div>
                                    @elseif($isEligible === false)
                                        <div class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-lg flex items-center gap-1 whitespace-nowrap" title="{{ implode(' | ', $missingScores) }}">Score Gap</div>
                                    @endif
                                @endif
                            @endauth
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 line-clamp-2 mb-1 group-hover:text-blue-700 transition">{{ $scholarship->title }}</h3>
                        @if(strtolower($scholarship->provider) !== 'luarkampus.id')
                        <p class="text-sm text-gray-500 mb-3">{{ $scholarship->provider }}</p>
                        @endif
                        <div class="space-y-2 mt-auto">
                            <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                <span>{{ $scholarship->level_of_study }}</span>
                                @if($scholarship->funding_type)<span class="text-gray-400">•</span><span>{{ $scholarship->funding_type }}</span>@endif
                            </div>
                            @php $reqs = []; if($scholarship->min_ielts) $reqs[] = "IELTS: ".$scholarship->min_ielts; if($scholarship->min_toefl) $reqs[] = "TOEFL: ".$scholarship->min_toefl; @endphp
                            <div class="flex items-center gap-1.5 text-sm text-gray-600 bg-gray-50 p-2 rounded-lg">
                                <svg class="w-4 h-4 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="truncate">{{ count($reqs) > 0 ? implode(' / ', $reqs) : 'No specific language score' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                        @if($scholarship->deadline)
                            <div x-data="countdown('{{ $scholarship->deadline->format('Y-m-d H:i:s') }}')">
                                <span class="text-[10px] text-gray-500 uppercase font-black tracking-wider block">Time Left</span>
                                <div class="flex items-center gap-1" x-show="!expired">
                                    <div class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-mono font-bold text-sm" x-text="days"></div>:
                                    <div class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-mono font-bold text-sm" x-text="hours"></div>:
                                    <div class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-mono font-bold text-sm" x-text="minutes"></div>
                                </div>
                                <span class="text-sm text-red-600 font-bold" x-show="expired">Expired</span>
                            </div>
                        @else
                            <div>
                                <span class="text-[10px] text-gray-500 uppercase font-black tracking-wider block">Deadline</span>
                                <span class="text-sm font-bold text-emerald-600">Always Open</span>
                            </div>
                        @endif
                        <a href="{{ route('scholarships.search.show', $scholarship) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition text-sm flex items-center gap-1.5">
                            Details <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $scholarships->links() }}
        </div>
    @else
        <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm">
            <div class="text-4xl mb-3">😕</div>
            <h3 class="text-lg font-black text-gray-900 mb-2">No scholarships match your filters.</h3>
            <p class="text-sm text-gray-500 mb-6">Try resetting your filters or use a different keyword.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('scholarships.search.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-gray-100 text-gray-800 font-bold rounded-xl hover:bg-gray-200 transition text-sm">Reset Filters</a>
                <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition text-sm">Take Free Test</a>
            </div>
        </div>
    @endif
    
    </div> <!-- Close Main Content Column -->

    <!-- Right Sidebar Column (Desktop Only) -->
    <div class="hidden lg:block w-[380px] xl:w-[420px] shrink-0 space-y-6">
        
        @guest
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4 text-2xl">🎯</div>
                <h3 class="text-xl font-black mb-2">Don't guess your eligibility!</h3>
                <p class="text-indigo-100 text-sm mb-5">Most top scholarships require IELTS 6.5+. Take our free test now!</p>
                <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="block w-full text-center py-3 bg-white text-indigo-700 font-bold rounded-xl hover:bg-gray-50 transition text-sm">Take Free Test Now</a>
            </div>
        </div>
        @endguest

        <!-- Alumni Stories -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2"><span class="text-2xl">🎓</span> Alumni Success</h3>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <svg class="w-8 h-8 text-indigo-100 mb-2" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H6c0-2.2 1.8-4 4-4V8zm18 0c-3.3 0-6 2.7-6 6v10h10V14h-8c0-2.2 1.8-4 4-4V8z"></path></svg>
                <p class="text-gray-700 text-sm italic font-medium leading-relaxed mb-4">"Berkat prediksi skor IELTS Target Bahasa, saya bisa tahu saya eligible untuk LPDP. Sekarang saya kuliah Master di UK!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">AS</div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Anisa S.</p>
                        <p class="text-xs text-indigo-600 font-semibold">LPDP Awardee 2024</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Academic Calendar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                Academic Calendar
            </h3>
            @include('components.academic-calendar-inline')
        </div>

        <!-- Latest News -->
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
                        <div class="w-14 h-14 rounded-xl bg-gray-50 shrink-0 overflow-hidden border border-gray-100">
                            @if($news->image_path)
                                <img src="{{ asset('storage/' . $news->image_path) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-indigo-200 text-xl">📰</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2 leading-snug">{{ $news->title }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->diffForHumans() : $news->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                    <div class="text-sm text-gray-500 text-center py-4 bg-gray-50 rounded-xl">No recent news.</div>
                @endforelse
            </div>
        </div>

    </div> <!-- Close Right Sidebar -->
</div> <!-- Close Main Flex Container -->
@endcomponent

@push('scripts')
<script>
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
                btnElement.classList.add('bg-yellow-100', 'text-yellow-600');
                btnElement.classList.remove('bg-white/90', 'text-gray-400');
                svg.setAttribute('fill', 'currentColor');
            } else if (data.status === 'unsaved') {
                btnElement.classList.remove('bg-yellow-100', 'text-yellow-600');
                btnElement.classList.add('bg-white/90', 'text-gray-400');
                svg.setAttribute('fill', 'none');
            }
        });
    }
</script>
<style>
    [x-cloak] { display: none !important; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush
