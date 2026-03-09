<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scholarship Search') }}
        </h2>
    </x-slot>

<div class="px-4 py-8 w-full max-w-7xl mx-auto">

    <!-- Page Header & Academic Calendar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6"></path></svg>
                </div>
                Scholarship Search
            </h1>
            <p class="text-gray-500 mt-2">Find and track scholarships. Match your scores with opportunities worldwide.</p>
        </div>
        
        <!-- Academic Calendar Mini Widget -->
        <div class="bg-white border rounded-xl shadow-sm p-4 flex items-center gap-4 min-w-[250px]">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Academic Calendar</p>
                <p class="text-lg font-bold text-gray-800">{{ now()->format('F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-8" x-data="{ filterOpen: {{ request()->anyFilled(['country', 'degree_level', 'funding_type', 'major']) ? 'true' : 'false' }} }">
        <form action="{{ route('scholarships.search.index') }}" method="GET">
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, provider, or location..." 
                           class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 md:flex-none px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">
                        Search
                    </button>
                    <button type="button" @click="filterOpen = !filterOpen" class="flex-1 md:flex-none px-4 py-2 bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-200 hover:bg-gray-100 transition flex items-center gap-2 justify-center">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filters
                    </button>
                </div>
            </div>
            
            <div x-show="filterOpen" x-transition x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <select name="country" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Degree Level</label>
                    <select name="degree_level" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Levels</option>
                        @foreach($degreeLevels as $level)
                            <option value="{{ $level }}" {{ request('degree_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Funding Type</label>
                    <select name="funding_type" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Types</option>
                        @foreach($fundingTypes as $type)
                            <option value="{{ $type }}" {{ request('funding_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Major</label>
                    <select name="major" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Majors</option>
                        @foreach($majors as $major)
                            <option value="{{ $major }}" {{ request('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            @if(request()->anyFilled(['search', 'country', 'degree_level', 'funding_type', 'major']))
                <div class="mt-4 flex justify-end" x-show="filterOpen">
                    <a href="{{ route('scholarships.search.index') }}" class="text-sm font-medium text-red-600 hover:text-red-800 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Clear Filters
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Guest Lead Magnet -->
    @guest
        <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-6 md:p-8 text-white mb-8 shadow-lg flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="relative z-10 md:w-2/3 mb-6 md:mb-0">
                <h3 class="text-2xl font-bold mb-2 flex items-center gap-2">
                    🎯 Don't guess your eligibility!
                </h3>
                <p class="text-blue-100 text-lg">Most top scholarships require IELTS 6.5+ or TOEFL 550+. Find out your current level instantly and let our "Smart Match" highlight scholarships you qualify for.</p>
            </div>
            
            <div class="relative z-10 w-full md:w-auto">
                <a href="{{ route('free-test.register.show', ['type' => 'ielts']) }}" class="block text-center px-8 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-md whitespace-nowrap text-lg">
                    Take Free Test Now
                </a>
            </div>
        </div>
    @endguest

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
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg uppercase tracking-wider whitespace-nowrap">{{ $scholarship->country ?? 'Global' }}</span>
                            
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
                        <p class="text-sm font-medium text-gray-500 mb-4">{{ $scholarship->provider }}</p>

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
        <div class="bg-white border rounded-2xl p-16 text-center shadow-sm max-w-2xl mx-auto">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">No scholarships found</h3>
            <p class="text-gray-500 mb-6 text-lg">We couldn't find any opportunities matching your current filters.</p>
            <a href="{{ route('scholarships.search.index') }}" class="inline-block px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm">Reset Filters & View All</a>
        </div>
    @endif
</div>

</div>
</x-app-layout>

@push('scripts')
<script>
    // Include Alpine.js if not already in layouts.app
    if (typeof window.Alpine === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
        script.defer = true;
        document.head.appendChild(script);
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('countdown', (deadlineStr) => ({
            days: '00',
            hours: '00',
            minutes: '00',
            expired: false,
            init() {
                const target = new Date(deadlineStr).getTime();
                
                const updateTimer = () => {
                    const now = new Date().getTime();
                    const distance = target - now;
                    
                    if (distance < 0) {
                        this.expired = true;
                        return;
                    }
                    
                    this.days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                };
                
                updateTimer(); // run once immediately
                setInterval(updateTimer, 60000); // update every minute since we only show minutes
            }
        }));
    });
    
    // Fallback for browsers executing script before Alpine initialization
    if (window.Alpine) {
        window.Alpine.data('countdown', (deadlineStr) => ({
            days: '00',
            hours: '00',
            minutes: '00',
            expired: false,
            init() {
                if(!deadlineStr) return;
                const target = new Date(deadlineStr).getTime();
                
                const updateTimer = () => {
                    const now = new Date().getTime();
                    const distance = target - now;
                    
                    if (distance < 0) {
                        this.expired = true;
                        return;
                    }
                    
                    this.days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                };
                
                updateTimer(); // run once immediately
                setInterval(updateTimer, 60000); // update every minute since we only show minutes
            }
        }));
    }

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
