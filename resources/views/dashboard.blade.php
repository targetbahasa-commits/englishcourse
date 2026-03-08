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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                
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

                <!-- Target Score & Recommendation -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Target & Plan</span>
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    @if($targetScore)
                        <div class="flex items-end gap-2 mb-3">
                            <h3 class="text-3xl font-bold text-gray-800">{{ $targetScore + 0 }}</h3>
                            <span class="text-sm text-gray-500 mb-1">Target Score</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-4 italic">Take a test to see your target.</p>
                    @endif
                    
                    @if($recommendedProgram)
                        <div class="mt-4 pt-4 border-t border-gray-50">
                            <p class="text-xs text-gray-400 mb-1">Recommended for you:</p>
                            <a href="{{ route('assignments.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 group">
                                {{ $recommendedProgram->name }}
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    @else
                        <div class="mt-4 pt-4 border-t border-gray-50">
                            <a href="{{ route('assignments.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View Programs →</a>
                        </div>
                    @endif
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
