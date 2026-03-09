<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Student Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-student')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    @if(request('section') === 'guest_free_tests')
                        <h1 class="text-2xl font-bold text-gray-800">Guest Free Tests</h1>
                        <p class="text-gray-500">Uji kemampuan Bahasa Inggrismu secara gratis.</p>
                    @else
                        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-gray-500">Berikut adalah ringkasan progress belajar Anda.</p>
                    @endif
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white border border-gray-100 rounded-xl px-4 py-2 hidden lg:flex items-center gap-3 mr-2 shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider leading-none mb-1">Academic Calendar</p>
                                <p class="text-sm font-bold text-gray-800 leading-none">{{ now()->format('F Y') }}</p>
                            </div>
                        </div>

                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Student</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-full overflow-hidden flex items-center justify-center text-blue-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area based on Section -->
            @if(request('section') === 'guest_free_tests')
                @include('guest.components.free-tests-content')
            @else
            <!-- Stats Cards -->
            <!-- Learning Hub Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Program Display -->
                <div class="bg-gradient-to-br from-indigo-700 to-purple-800 rounded-2xl shadow-lg border-0 p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-indigo-200 text-sm font-semibold uppercase tracking-wider">Active Program</span>
                            <div class="p-2 bg-white/20 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                        @if($enrolledProgram)
                            <h3 class="text-2xl font-black mb-1 leading-tight">{{ $enrolledProgram->name }}</h3>
                            <p class="text-indigo-200 text-sm mt-2">Class Average: <span class="font-bold text-white">{{ round($averageScore, 1) }}</span> / 100</p>
                        @else
                            <h3 class="text-xl font-bold mb-1 mt-2">No Program</h3>
                            <a href="{{ route('assignments.index') }}" class="text-white text-sm underline hover:text-indigo-200 mt-2 inline-block">Explore Programs</a>
                        @endif
                    </div>
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

                <!-- Assignment Progress -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Class Progress</span>
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-2 mb-4">
                        <h3 class="text-3xl font-bold text-gray-800">{{ $totalCompleted }}<span class="text-xl text-gray-400 font-normal">/{{ $totalAssignments }}</span></h3>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5 mb-1">
                        <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 text-right">{{ round($progressPercentage) }}% Completed</p>
                    
                    @if(isset($lowestScores) && $lowestScores->count() > 0)
                        <div class="mt-4 bg-orange-50 border-l-4 border-orange-400 p-3 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-xs font-bold text-orange-800">Review Recommended</h3>
                                    <div class="mt-1 text-xs text-orange-700">
                                        Perkuat materi ini untuk menaikkan nilai Anda:
                                        <ul class="list-disc pl-4 mt-1 space-y-1">
                                            @foreach($lowestScores as $weakness)
                                                <li>
                                                    @php $routeName = 'assignments.grammar-writing.meeting' . $weakness->meeting_number; @endphp
                                                    @if(Route::has($routeName))
                                                        <a href="{{ route($routeName) }}" class="underline hover:text-orange-900 font-medium">
                                                            Meeting {{ $weakness->meeting_number }}
                                                        </a> 
                                                    @else
                                                        <span class="font-medium">Meeting {{ $weakness->meeting_number }}</span>
                                                    @endif
                                                    (Score: <span class="font-bold text-red-600">{{ $weakness->score }}</span>)
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
                    </div>
                    <div class="relative h-80 w-full">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
                
                <!-- Upcoming Classes -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Upcoming Classes</h3>
                    </div>
                    
                    @if(Auth::user()->classPeriod)
                        <div class="space-y-4">
                            @forelse($upcomingClasses as $class)
                                <div class="flex items-start gap-4 p-3 hover:bg-gray-50 rounded-xl transition border border-transparent hover:border-gray-100">
                                    <div class="w-12 h-12 rounded-xl flex flex-col items-center justify-center bg-blue-50 text-blue-600 flex-shrink-0">
                                        <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($class->meeting_date)->format('M') }}</span>
                                        <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($class->meeting_date)->format('d') }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-gray-800 line-clamp-1">{{ $class->meeting->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400 border-2 border-dashed border-gray-100 rounded-xl">
                                    <div class="text-2xl mb-2">📅</div>
                                    <p class="text-sm">Tidak ada jadwal kelas terdekat.</p>
                                </div>
                            @endforelse
                        </div>
                    @else
                        <div class="text-center py-8 px-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-500 rounded-full mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800 mb-1">Daftar Kelas</h4>
                            <p class="text-xs text-gray-500 mb-4">Anda belum bergabung dalam Batch Kelas manapun.</p>
                            <a href="{{ route('assignments.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">Lihat Program</a>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Sprint 4: Diagnostic Scorecard (Historical) -->
            @if(isset($diagnosticStats) && array_sum($diagnosticStats) > 0)
            <div class="mb-8 relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <!-- Background Decoration -->
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-full opacity-50"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Diagnostic Analytics
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Distribusi performa historis Anda di semua tugas.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Excellent Band -->
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase">Excellent (90-100)</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-black text-gray-800">{{ $diagnosticStats['excellent'] }}</span>
                                <span class="text-xs text-gray-500">tugas</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Good Band -->
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase">Good (70-89)</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-black text-gray-800">{{ $diagnosticStats['good'] }}</span>
                                <span class="text-xs text-gray-500">tugas</span>
                            </div>
                        </div>
                    </div>

                    <!-- Needs Review Band -->
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-orange-600 font-semibold uppercase">Needs Review (<70)</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-black text-gray-800">{{ $diagnosticStats['needs_review'] }}</span>
                                <span class="text-xs text-gray-500">tugas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </main>
    </div>

    <script>
        const ctx = document.getElementById('progressChart').getContext('2d');
        const chartData = @json(array_values($chartData));
        const labels = Array.from({length: 20}, (_, i) => `M${i + 1}`);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nilai',
                    data: chartData,
                    borderColor: '#4F46E5', // Indigo-600
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4F46E5',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1F2937',
                        bodyColor: '#4B5563',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Nilai: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: '#F3F4F6',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    </script>
</body>
</html>
