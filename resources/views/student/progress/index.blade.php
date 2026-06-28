<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - My Progress</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
                    <h1 class="text-2xl font-bold text-gray-800">My Progress 📈</h1>
                    <p class="text-gray-500">Analisis komprehensif riwayat belajar dan nilai Anda.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition flex items-center gap-2" onclick="window.print()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Download Report
                    </button>
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

            @forelse($progressData as $index => $data)
            <div class="mb-4">
                <h2 class="text-xl font-black text-gray-800">{{ $data['program']->name ?? 'Program' }}</h2>
                <p class="text-sm text-gray-500 mb-6">Progress assignment dan nilai Anda untuk program ini.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                <!-- Skill Breakdown (Radar Chart) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Skill / Module Breakdown</h3>
                    <div class="relative h-64 w-full flex justify-center">
                        <canvas id="skillRadarChart_{{ $index }}" data-skills="{{ json_encode($data['skillScores']) }}"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-500">*Berdasarkan rata-rata nilai assignment per modul.</p>
                    </div>
                </div>

                <!-- Assignment Scores Table -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Nilai Tugas</h3>
                        <div class="flex gap-2">
                            <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">Avg: {{ round($data['averageScore'], 1) }}</span>
                            <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-xs font-bold">{{ $data['totalAssignments'] }} Selesai</span>
                        </div>
                    </div>
                    
                    <div class="flex-1 overflow-auto rounded-lg border border-gray-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider sticky top-0 shadow-sm">
                                    <th class="p-3 font-semibold border-b border-gray-100">Meeting</th>
                                    <th class="p-3 font-semibold border-b border-gray-100">Tanggal</th>
                                    <th class="p-3 font-semibold border-b border-gray-100 text-right">Skor</th>
                                    <th class="p-3 font-semibold border-b border-gray-100 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($data['meetingScores'] as $ms)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-3 font-medium text-gray-800">Meeting {{ $ms->meeting_number }}</td>
                                        <td class="p-3 text-gray-500">{{ \Carbon\Carbon::parse($ms->submitted_at)->format('d M Y') }}</td>
                                        <td class="p-3 text-right">
                                            <span class="font-bold {{ $ms->score < 70 ? 'text-red-500' : 'text-gray-800' }}">{{ $ms->score }}</span>/100
                                        </td>
                                        <td class="p-3 text-center">
                                            @if($ms->score >= 90)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Excellent</span>
                                            @elseif($ms->score >= 70)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Good</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">Needs Review</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-gray-400">
                                            Belum ada data tugas yang diselesaikan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center max-w-2xl mx-auto mt-12 mb-12">
                <div class="w-24 h-24 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Riwayat Progress</h2>
                <p class="text-gray-500 mb-8">Anda belum memiliki nilai tugas dari program yang Anda daftarkan.</p>
                <a href="{{ route('assignments.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm hover:shadow">
                    Mulai Belajar Sekarang
                </a>
            </div>
            @endforelse

            <!-- Free Tests History -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Placement / Free Tests History</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="p-4 font-semibold rounded-tl-lg">Tanggal</th>
                                <th class="p-4 font-semibold">Tipe Tes</th>
                                <th class="p-4 font-semibold">Skor / Band</th>
                                <th class="p-4 font-semibold rounded-tr-lg text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-50">
                            @forelse($freeTests as $ft)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-600">{{ $ft->created_at->format('d M Y, H:i') }}</td>
                                    <td class="p-4 font-medium text-gray-800">{{ strtoupper(str_replace('_', ' ', $ft->test_type)) }}</td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-black text-indigo-600">{{ $ft->score + 0 }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('free-test.result', $ft->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center justify-end gap-1">
                                            Lihat Detail
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-400">
                                        <div class="text-3xl mb-2">📝</div>
                                        <p>Anda belum pernah mengambil Free Test.</p>
                                        <a href="{{ route('dashboard', ['section' => 'guest_free_tests']) }}" class="mt-2 inline-block text-blue-600 hover:underline">Ambil Tes Sekarang</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvases = document.querySelectorAll('canvas[id^="skillRadarChart_"]');
            
            canvases.forEach(canvas => {
                const ctxRadar = canvas.getContext('2d');
                const skillData = JSON.parse(canvas.getAttribute('data-skills'));
                
                new Chart(ctxRadar, {
                    type: 'radar',
                    data: {
                        labels: Object.keys(skillData),
                        datasets: [{
                            label: 'Rata-rata Skor',
                            data: Object.values(skillData),
                            backgroundColor: 'rgba(79, 70, 229, 0.2)', // Indigo 500 transparent
                            borderColor: 'rgba(79, 70, 229, 1)',
                            pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                angleLines: { color: 'rgba(0, 0, 0, 0.05)' },
                                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                                pointLabels: {
                                    font: { size: 12, family: "'Figtree', sans-serif", weight: '600' },
                                    color: '#4B5563'
                                },
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    stepSize: 20,
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                padding: 10,
                                callbacks: {
                                    label: function(context) {
                                        return ' Skor: ' + Math.round(context.raw);
                                    }
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
