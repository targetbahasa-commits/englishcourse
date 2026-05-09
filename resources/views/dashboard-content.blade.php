

        <!-- Main Content Area based on Section -->
        @if(request('section') === 'guest_free_tests')
            @include('guest.components.free-tests-content')
        @else
        <!-- Stats Cards -->
        <!-- Learning Hub Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Enrolled Programs Carousel -->
            <div class="col-span-1 md:col-span-2 lg:col-span-2">
                <div class="mb-4 flex items-center justify-between">
                    <span class="text-indigo-700 text-base font-bold uppercase tracking-wider">Enrolled Programs</span>
                    <a href="{{ route('assignments.index') }}" class="text-indigo-500 text-xs underline hover:text-indigo-700">Explore Programs</a>
                </div>
                @if(isset($enrolledPrograms) && $enrolledPrograms->isNotEmpty())
                <style>
                    @keyframes gradientRotate {
                        0% { background-position: 0% 50%; }
                        50% { background-position: 100% 50%; }
                        100% { background-position: 0% 50%; }
                    }
                    .animate-gradient-slow {
                        background-size: 250% 250%;
                        animation: gradientRotate 8s ease infinite;
                    }
                    .carousel-enter { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
                    .carousel-enter-start { opacity: 0; transform: translateX(30px) scale(0.95); }
                    .carousel-enter-end { opacity: 1; transform: translateX(0) scale(1); }
                    .carousel-leave { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: absolute; top: 0; left: 0; right: 0; }
                    .carousel-leave-start { opacity: 1; transform: translateX(0) scale(1); }
                    .carousel-leave-end { opacity: 0; transform: translateX(-30px) scale(0.95); }
                </style>
                <div x-data="{ current: 0, total: {{ $enrolledPrograms->count() }} }" class="relative flex flex-col items-center w-full">
                    <div class="relative w-full flex justify-center items-center py-2 px-6">
                        <!-- Navigation Prev -->
                        <button @click="current = (current - 1 + total) % total" :disabled="total <= 1" 
                            class="absolute left-0 z-20 bg-white/90 hover:bg-white hover:scale-110 text-indigo-700 rounded-full shadow-lg p-2.5 sm:p-3 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:scale-100 transition-all duration-300 border border-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        
                        <!-- Cards Container -->
                        <div class="w-full max-w-md relative min-h-[180px] perspective-1000">
                            <template x-for="(prog, idx) in {{ $enrolledPrograms->toJson() }}" :key="idx">
                                <div x-show="current === idx" 
                                     x-transition:enter="carousel-enter"
                                     x-transition:enter-start="carousel-enter-start"
                                     x-transition:enter-end="carousel-enter-end"
                                     x-transition:leave="carousel-leave"
                                     x-transition:leave-start="carousel-leave-start"
                                     x-transition:leave-end="carousel-leave-end"
                                     class="w-full"
                                >
                                    <div class="group relative rounded-[2rem] overflow-hidden cursor-pointer w-full transition-transform duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_-15px_rgba(79,70,229,0.5)] shadow-xl">
                                        <!-- Animated Background Gradient -->
                                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-500 animate-gradient-slow transition-all duration-700 group-hover:scale-105"></div>
                                        
                                        <!-- Overlay pattern and glow effects -->
                                        <div class="absolute inset-0 bg-white/5 opacity-30 mix-blend-overlay"></div>
                                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/20 rounded-full blur-[60px] group-hover:scale-150 transition-transform duration-700"></div>
                                        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-purple-400/30 rounded-full blur-[40px] group-hover:scale-125 transition-transform duration-700"></div>

                                        <!-- Content -->
                                        <div class="relative p-6 sm:p-8 text-white min-h-[180px] flex flex-col justify-between z-10 backdrop-blur-[2px]">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="px-3.5 py-1.5 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest text-white border border-white/20 shadow-sm" x-text="(prog.status ?? 'Active').toUpperCase()"></span>
                                                <div class="w-11 h-11 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20 shadow-inner group-hover:rotate-12 transition-transform duration-300">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-auto">
                                                <h3 class="text-2xl sm:text-3xl font-black leading-tight mb-3 tracking-tight drop-shadow-md" x-text="prog.name"></h3>
                                                <template x-if="prog.average_score !== undefined">
                                                    <div class="flex items-center gap-2.5">
                                                        <span class="text-indigo-100 text-xs sm:text-sm font-medium opacity-90">Class Average:</span>
                                                        <div class="flex items-baseline bg-white/10 px-2.5 py-1 rounded-lg border border-white/20 backdrop-blur-md shadow-inner">
                                                            <span class="text-base sm:text-lg font-bold text-white" x-text="Math.round(prog.average_score * 10) / 10"></span>
                                                            <span class="text-indigo-200 text-[10px] sm:text-xs ml-1 font-medium">/ 100</span>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Navigation Next -->
                        <button @click="current = (current + 1) % total" :disabled="total <= 1" 
                            class="absolute right-0 z-20 bg-white/90 hover:bg-white hover:scale-110 text-indigo-700 rounded-full shadow-lg p-2.5 sm:p-3 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:scale-100 transition-all duration-300 border border-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>
                    
                    <!-- Carousel Indicators -->
                    <div class="flex justify-center mt-6 gap-2">
                        <template x-for="idx in total">
                            <button @click="current = idx - 1" 
                                :class="current === (idx-1) ? 'bg-indigo-600 w-6 opacity-100' : 'bg-indigo-300 w-2 opacity-60 hover:opacity-100 hover:bg-indigo-400'" 
                                class="h-2 rounded-full transition-all duration-300 focus:outline-none"></button>
                        </template>
                    </div>
                </div>
                @else
                    <div class="bg-white/10 rounded-xl p-6 text-white text-center">
                        <h3 class="text-xl font-bold mb-1 mt-2">No Program</h3>
                        <a href="{{ route('assignments.index') }}" class="text-white text-sm underline hover:text-indigo-200 mt-2 inline-block">Explore Programs</a>
                    </div>
                @endif
            </div>
            <!-- Latest Test Score -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg border-0 p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-6 -mr-6 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-blue-100 text-sm font-semibold uppercase tracking-wider">Latest Test Score</span>
                        <div class="p-2 bg-white/20 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    @if($latestTest)
                        <h3 class="text-4xl font-black mb-1">{{ $latestTest->score + 0 }}</h3>
                        <p class="text-blue-100 text-sm">{{ strtoupper(str_replace('_', ' ', $latestTest->test_type)) }}</p>
                    @else
                        <h3 class="text-2xl font-bold mb-1 mt-2">No tests yet</h3>
                        <a href="{{ route('dashboard', ['section' => 'guest_free_tests']) }}" class="text-white text-sm underline hover:text-blue-200 mt-2 inline-block">Take a free test</a>
                    @endif
                </div>
            </div>
            <!-- Target Score & Scholarship Goal -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Target & Goal</span>
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                @if(isset($targetScholarship))
                    <div class="mb-4">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Target Scholarship</h4>
                        <p class="text-sm font-bold text-gray-800 line-clamp-1 mb-1" title="{{ $targetScholarship->title }}">
                            {{ $targetScholarship->title }}
                        </p>
                        @if($targetScholarship->deadline)
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 mt-2" x-data="countdown('{{ $targetScholarship->deadline->format('Y-m-d H:i:s') }}')">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span x-show="!expired" class="text-blue-600 bg-blue-50 px-1.5 rounded" x-text="days + ' days left'"></span>
                                <span x-show="expired" class="text-red-500 bg-red-50 px-1.5 rounded">Expired</span>
                            </div>
                            {{-- Dynamic Warning Logic --}}
                            @php
                                $daysRemaining = now()->diffInDays($targetScholarship->deadline, false);
                                $isEligible = true;
                                if ($predictedScore) {
                                    $isIeltsProgram = $enrolledProgram && stripos($enrolledProgram->name, 'IELTS') !== false;
                                    if($isIeltsProgram && $targetScholarship->min_ielts && $predictedScore < $targetScholarship->min_ielts) {
                                        $isEligible = false;
                                    } elseif(!$isIeltsProgram && $targetScholarship->min_toefl && $predictedScore < $targetScholarship->min_toefl) {
                                        $isEligible = false;
                                    }
                                } else {
                                    $isEligible = false; // No predicted score yet
                                }
                            @endphp
                            @if($daysRemaining >= 0 && $daysRemaining <= 30 && !$isEligible)
                                <div class="mt-3 p-2 bg-red-50 border border-red-100 rounded-lg flex items-start">
                                    <svg class="w-4 h-4 text-red-500 mr-2 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <p class="text-xs font-semibold text-red-700 leading-tight">
                                        Waktu Pendaftaran Kurang dari 1 Bulan. Tingkatkan Intensitas Belajar Anda!
                                    </p>
                                </div>
                            @endif
                        @else
                            <p class="text-xs text-emerald-600 font-bold mt-1 bg-emerald-50 inline-block px-2 py-0.5 rounded">Always Open</p>
                        @endif
                    </div>
                @else
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 italic mb-2">No scholarship target set yet.</p>
                        <a href="{{ route('scholarships.search.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 group">
                            Find Scholarships
                            <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                @endif
                <div class="mt-auto border-t border-gray-100 pt-3">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase">Target Score</span>
                        <span class="text-xs font-bold text-gray-400 uppercase">Predicted</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-black text-gray-800">{{ $targetScore ? ($targetScore + 0) : '--' }}</h3>
                        <h3 class="text-2xl font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg border border-blue-100">{{ $predictedScore ?? '--' }}</h3>
                    </div>
                    @if($recommendedProgram && !$enrolledProgram)
                        <div class="mt-3 text-right">
                            <a href="{{ route('assignments.index') }}" class="text-[11px] font-bold text-blue-600 hover:underline">Recommended: {{ $recommendedProgram->name }} →</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Review Recommended -->
            <div class="bg-orange-50 rounded-2xl shadow-sm border border-orange-100 p-6 flex flex-col h-full">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-orange-800 text-sm font-semibold uppercase tracking-wider">Review Recommended</span>
                    <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
                @if(isset($lowestScores) && count($lowestScores) > 0)
                    <div class="text-xs text-orange-700 mb-2">Perkuat materi ini untuk menaikkan nilai Anda:</div>
                    <ul class="list-disc pl-4 space-y-1 text-sm text-orange-700 font-medium">
                        @foreach($lowestScores as $weakness)
                            <li>
                                @php $routeName = 'assignments.grammar-writing.meeting' . $weakness->meeting_number; @endphp
                                @if(Route::has($routeName))
                                    <a href="{{ route($routeName) }}" class="underline hover:text-orange-900">Meeting {{ $weakness->meeting_number }}</a>
                                @else
                                    <span>Meeting {{ $weakness->meeting_number }}</span>
                                @endif
                                (Score: <span class="font-bold text-red-600">{{ $weakness->score }}</span>)
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex items-center text-sm text-emerald-600 font-medium h-full mt-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Kerja bagus! Tidak ada materi yang perlu diulang saat ini.
                    </div>
                @endif
            </div>

        </div>

        <!-- Charts & Upcoming Classes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Progress Chart -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Grafik Nilai Per Pertemuan</h3>
                        <div class="relative min-w-[160px]">
                            <select id="classSelector" class="appearance-none bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full py-2 pl-4 pr-10 hover:border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm cursor-pointer outline-none">
                                @foreach($classNames ?? [] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                        <div class="relative w-full" style="height: 320px;">
                            <canvas id="scoreChart" style="width:100%;height:100%;"></canvas>
                        </div>
                        @push('scripts')
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var classScores = @json($classScores ?? []);
                            var selector = document.getElementById('classSelector');
                            var currentProgramId = selector ? selector.value : 0;
                            var initialData = classScores[currentProgramId] || Array(20).fill(null);

                            var ctx = document.getElementById('scoreChart').getContext('2d');
                            // Create gradient for the line
                            var gradient = ctx.createLinearGradient(0, 0, 0, 320);
                            gradient.addColorStop(0, 'rgba(99,102,241,1)'); // Indigo
                            gradient.addColorStop(0.5, 'rgba(139,92,246,0.8)'); // Purple
                            gradient.addColorStop(1, 'rgba(59,130,246,0.2)'); // Blue with more transparency

                            var scoreChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: Array.from({length: 20}, (_, i) => 'M' + (i+1)),
                                    datasets: [{
                                        label: 'Nilai',
                                        data: initialData,
                                        borderColor: gradient,
                                        borderWidth: 3,
                                        pointRadius: 3,
                                        pointBackgroundColor: '#ffffff',
                                        pointBorderColor: 'rgba(99,102,241,1)',
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 6,
                                        fill: true,
                                        backgroundColor: 'rgba(99,102,241,0.06)',
                                        tension: 0.4,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    interaction: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: { 
                                            enabled: true,
                                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                            titleColor: '#1e293b',
                                            bodyColor: '#334155',
                                            borderColor: '#e2e8f0',
                                            borderWidth: 1,
                                            padding: 12,
                                            displayColors: false,
                                            titleFont: { size: 13, weight: 'bold', family: "'Inter', sans-serif" },
                                            bodyFont: { size: 14, weight: '500', family: "'Inter', sans-serif" },
                                            callbacks: {
                                                label: function(context) {
                                                    return 'Score: ' + context.parsed.y;
                                                }
                                            }
                                        },
                                    },
                                    layout: {
                                        padding: { left: 5, right: 20, top: 20, bottom: 5 }
                                    },
                                    scales: {
                                        x: {
                                            grid: { display: false, drawBorder: false },
                                            border: { display: false },
                                            ticks: { color: '#94a3b8', font: { size: 12, weight: '500', family: "'Inter', sans-serif" }, padding: 10 }
                                        },
                                        y: {
                                            grid: { color: '#f1f5f9', lineWidth: 1, drawBorder: false, borderDash: [4, 4] },
                                            border: { display: false, dash: [4, 4] },
                                            min: 0,
                                            max: 100,
                                            ticks: { stepSize: 20, color: '#94a3b8', font: { size: 12, weight: '500', family: "'Inter', sans-serif" }, padding: 15 }
                                        }
                                    }
                                }
                            });

                            if (selector) {
                                selector.addEventListener('change', function() {
                                    var selectedId = this.value;
                                    var newData = classScores[selectedId] || Array(20).fill(null);
                                    scoreChart.data.datasets[0].data = newData;
                                    scoreChart.update();
                                });
                            }
                        });
                        </script>
                        @endpush
                </div>
                <!-- Right Panel (Upcoming Classes & Diagnostics) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col gap-6">
                    
                    @if(isset($upcomingClasses) && count($upcomingClasses) > 0)
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Upcoming Classes</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($upcomingClasses as $class)
                                <div class="p-3 bg-indigo-50 border border-indigo-100 rounded-lg flex justify-between items-center">
                                    <div>
                                        <p class="font-bold text-indigo-900 text-sm">Meeting {{ $class->meeting_number }}</p>
                                        <p class="text-xs text-indigo-700">{{ \Carbon\Carbon::parse($class->meeting_date)->format('D, d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-bold text-indigo-800">{{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Diagnostic Scorecard</h3>
                        </div>
                        <div class="space-y-3">
                            <!-- Excellent Band -->
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between hover:shadow-md transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-xs text-gray-500 font-semibold uppercase">Excellent<br>(90-100)</p>
                                </div>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-black text-gray-800">{{ $diagnosticStats['excellent'] ?? 0 }}</span>
                                    <span class="text-[10px] text-gray-500">tugas</span>
                                </div>
                            </div>
                            
                            <!-- Good Band -->
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between hover:shadow-md transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    </div>
                                    <p class="text-xs text-gray-500 font-semibold uppercase">Good<br>(70-89)</p>
                                </div>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-black text-gray-800">{{ $diagnosticStats['good'] ?? 0 }}</span>
                                    <span class="text-[10px] text-gray-500">tugas</span>
                                </div>
                            </div>

                            <!-- Needs Review Band -->
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between hover:shadow-md transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <p class="text-xs text-orange-600 font-semibold uppercase">Needs Review<br>(<70)</p>
                                </div>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-black text-gray-800">{{ $diagnosticStats['needs_review'] ?? 0 }}</span>
                                    <span class="text-[10px] text-gray-500">tugas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif