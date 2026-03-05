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
    @vite(['resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .mobile-closed { transform: translateX(-100%) !important; }
        .mobile-open { transform: translateX(0) !important; }
        @media (min-width: 768px) {
            .mobile-closed, .mobile-open { transform: none !important; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80 z-20 md:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-md transition-transform duration-300 ease-in-out md:static md:inset-auto"
               :class="sidebarOpen ? 'mobile-open' : 'mobile-closed'">
            <div class="relative p-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
                    <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
                </div>
                <!-- Close Button (Mobile) -->
                <button type="button" @click="sidebarOpen = false" class="md:hidden absolute top-4 right-4 p-2 bg-gray-100 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-200 focus:outline-none z-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 mb-4">MENU UTAMA</p>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-medium border-l-4 border-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Assignments
                    </a>
                    <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Free Lesson
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-8 px-6 w-full">
                <p class="text-xs font-semibold text-gray-400 mb-4">AKUN</p>
                <nav class="space-y-2">
                     <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile
                    </a>
                     <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition w-full text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Log Out
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8 w-full">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu Button -->
                    <button @click="sidebarOpen = true" class="md:hidden p-2 text-gray-600 hover:bg-white rounded-lg shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <div class="relative w-full md:w-96 hidden md:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    <button class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </button>
                    <button class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-yellow-400 rounded-full overflow-hidden flex items-center justify-center text-gray-800 font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-500">Berikut adalah ringkasan progress belajar Anda.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Completed Assignments -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <span class="text-xs font-bold {{ $progressPercentage >= 50 ? 'text-green-600 bg-green-50' : 'text-orange-600 bg-orange-50' }} px-2 py-1 rounded-full">
                            {{ round($progressPercentage) }}% Selesai
                        </span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $totalCompleted }}<span class="text-lg text-gray-400 font-normal">/{{ $totalAssignments }}</span></h3>
                    <p class="text-gray-500 text-sm">Tugas Diselesaikan</p>
                </div>
                
                <!-- Average Score -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $averageScore }}</h3>
                    <p class="text-gray-500 text-sm">Rata-rata Nilai</p>
                </div>
                
                <!-- Highest Score -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $highestScore }}</h3>
                    <p class="text-gray-500 text-sm">Nilai Tertinggi</p>
                </div>
                
                <!-- Total Points -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($totalPoints) }}</h3>
                    <p class="text-gray-500 text-sm">Total Poin Akumulasi</p>
                </div>
            </div>

            <!-- Enrolled Programs Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Program yang Diambil</h2>
                        <p class="text-sm text-gray-500">Daftar program yang sedang Anda ikuti</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($enrolledPrograms as $program)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <!-- Program Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $program['name'] }}</h3>
                                    <p class="text-xs text-gray-500">{{ $program['period'] }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-bold rounded-full
                                    {{ $program['status'] === 'active' ? 'bg-green-100 text-green-600' : 
                                       ($program['status'] === 'completed' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($program['status']) }}
                                </span>
                            </div>

                            <!-- Progress Stats -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-gray-600">Progress</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $program['progress'] }}%</span>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500
                                        {{ $program['progress'] >= 80 ? 'bg-green-500' : 
                                           ($program['progress'] >= 50 ? 'bg-blue-500' : 
                                           ($program['progress'] >= 25 ? 'bg-yellow-500' : 'bg-red-500')) }}"
                                        style="width: {{ $program['progress'] }}%">
                                    </div>
                                </div>
                                
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ $program['completed_meetings'] }} dari {{ $program['total_meetings'] }} pertemuan selesai
                                </p>
                            </div>

                            <!-- Action Button -->
                            @if($program['slug'] === 'grammar-for-writing')
                                <a href="{{ route('assignments.grammar-writing') }}" 
                                   class="block w-full py-2 px-4 bg-blue-600 text-white text-center rounded-xl font-medium hover:bg-blue-700 transition">
                                    Lanjutkan Belajar
                                </a>
                            @else
                                <button class="block w-full py-2 px-4 bg-gray-300 text-gray-500 text-center rounded-xl font-medium cursor-not-allowed" disabled>
                                    Coming Soon
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                            <p class="text-gray-500">Anda belum terdaftar di program manapun.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Charts & Recent Activity -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Grafik Nilai Per Program</h2>
                        <p class="text-sm text-gray-500">Progress nilai untuk setiap program yang diambil</p>
                    </div>
                </div>

                <!-- Program Charts Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    @foreach($enrolledPrograms as $program)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $program['name'] }}</h3>
                                    <p class="text-xs text-gray-500">{{ $program['completed_meetings'] }}/{{ $program['total_meetings'] }} pertemuan selesai</p>
                                </div>
                                <span class="text-sm font-bold px-3 py-1 rounded-full
                                    {{ $program['progress'] >= 80 ? 'bg-green-100 text-green-600' : 
                                       ($program['progress'] >= 50 ? 'bg-blue-100 text-blue-600' : 
                                       ($program['progress'] >= 25 ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }}">
                                    {{ $program['progress'] }}%
                                </span>
                            </div>
                            <div class="relative h-64 w-full">
                                <canvas id="chart-{{ $program['slug'] }}"></canvas>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
                </div>
                <div class="space-y-4">
                        @forelse($recentActivity as $activity)
                            <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition border border-transparent hover:border-gray-100">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white
                                    {{ $activity->score >= 80 ? 'bg-green-500' : ($activity->score >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ $activity->meeting_number }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-800">Meeting {{ $activity->meeting_number }}</h4>
                                    <p class="text-xs text-gray-500">{{ $activity->submitted_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-bold {{ $activity->score >= 80 ? 'text-green-600' : ($activity->score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $activity->score }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400">
                                <p>Belum ada aktivitas.</p>
                                <a href="{{ route('assignments.grammar-writing') }}" class="text-blue-500 text-sm hover:underline mt-2 inline-block">Mulai Belajar</a>
                            </div>
                        @endforelse
                    </div>
                    
                    @if($recentActivity->count() > 0)
                        <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                            <a href="{{ route('assignments.grammar-writing') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lanjutkan Belajar →</a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Chart colors for different programs
        const programColors = {
            'grammar-for-writing': { border: '#4F46E5', bg: 'rgba(79, 70, 229, 0.1)' }, // Indigo
            'grammar-for-speaking': { border: '#10B981', bg: 'rgba(16, 185, 129, 0.1)' }, // Green
            'ielts-general': { border: '#F59E0B', bg: 'rgba(245, 158, 11, 0.1)' }, // Amber
            'ielts-academic': { border: '#EF4444', bg: 'rgba(239, 68, 68, 0.1)' }, // Red
            'pte': { border: '#8B5CF6', bg: 'rgba(139, 92, 246, 0.1)' } // Purple
        };

        // Get enrolled programs data
        const enrolledPrograms = @json($enrolledPrograms);

        // Create a chart for each program
        enrolledPrograms.forEach(program => {
            const canvasId = `chart-${program.slug}`;
            const canvas = document.getElementById(canvasId);
            
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            const labels = Array.from({length: program.total_meetings}, (_, i) => `M${i + 1}`);
            const colors = programColors[program.slug] || { border: '#6B7280', bg: 'rgba(107, 114, 128, 0.1)' };

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nilai',
                        data: program.chart_data, // Use program-specific chart data
                        borderColor: colors.border,
                        backgroundColor: colors.bg,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: colors.border,
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
                                    size: 10
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
        });
    </script>
</body>
</html>
