@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My English 🎯</h1>
        <p class="mt-2 text-lg text-gray-600">Lacak perkembangan dan ketahui estimasi kemampuan bahasa Inggris Anda.</p>
    </div>

    @if(!$hasData)
        <!-- Empty State -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-24 h-24 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Data Kemampuan</h2>
            @if($viewerNeedsLogin)
                <p class="text-gray-500 max-w-md mx-auto mb-8">Login sebagai guest untuk melihat riwayat hasil free test Anda. Jika belum pernah tes, Anda bisa mulai dari halaman Guest Free Tests.</p>
                <div class="flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-bold px-6 py-3 rounded-full hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                        Log In Untuk Lihat Hasil
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('guest.free-tests') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-6 py-3 rounded-full border border-blue-200 hover:bg-blue-50 transition shadow-sm">
                        Ambil Free Test
                    </a>
                </div>
            @else
                <p class="text-gray-500 max-w-md mx-auto mb-8">Anda belum menyelesaikan Free Test apapun. Ambil tes sekarang untuk mengetahui level bahasa Inggris Anda secara gratis.</p>
                <a href="{{ route('guest.free-tests') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-bold px-6 py-3 rounded-full hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                    Ambil Free Test Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Level & Chart -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CEFR Level Card -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full transform translate-x-1/2 -translate-y-1/2"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                        <div class="w-32 h-32 rounded-full border-4 border-white/20 flex items-center justify-center flex-shrink-0 bg-white/10 backdrop-blur-sm">
                            <span class="text-5xl font-black">{{ $cefrLevel }}</span>
                        </div>
                        <div>
                            <p class="text-blue-200 font-semibold mb-1 uppercase tracking-wider text-sm">Estimasi Level CEFR</p>
                            <h2 class="text-3xl font-bold mb-3">{{ $cefrDescription }}</h2>
                            <p class="text-blue-100 text-sm">Berdasarkan skor <span class="font-bold text-white">{{ $latestTest->score }}</span> pada tes <span class="font-bold text-white">{{ strtoupper(str_replace('_', ' ', $latestTest->test_type)) }}</span> ({{ $latestTest->created_at->format('d M Y') }})</p>
                        </div>
                    </div>
                </div>

                <!-- Equivalency Scores -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Estimasi Skor IELTS</p>
                            <p class="text-xl font-bold text-gray-900">{{ $estimatedIelts }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Estimasi Skor TOEFL</p>
                            <p class="text-xl font-bold text-gray-900">{{ $estimatedToefl }}</p>
                        </div>
                    </div>
                </div>

                <!-- Radar Chart -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Skill Breakdown</h3>
                    <div class="relative h-80 w-full flex justify-center">
                        <canvas id="skillRadarChart"></canvas>
                    </div>
                    <div class="mt-6 text-center text-sm text-gray-500">
                        <p>*Proyeksi indikatif berdasarkan skor Free Test terbaru Anda.</p>
                    </div>
                </div>

            </div>

            <!-- Right Column: Recommendations -->
            <div class="space-y-8">
                
                <!-- Next Steps -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Next Steps</h3>
                    </div>
                    
                    <ul class="space-y-4">
                        @foreach($nextSteps as $index => $step)
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-gray-100 text-gray-600 text-xs font-bold flex items-center justify-center mt-0.5">{{ $index + 1 }}</span>
                                <span class="text-gray-700">{{ $step }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recommended Program -->
                <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-3xl shadow-lg p-8 text-white">
                    <p class="text-cyan-100 font-semibold mb-2 text-sm uppercase tracking-wider">Rekomendasi Kelas</p>
                    <h3 class="text-2xl font-bold mb-4">{{ $recommendedProgram }}</h3>
                    <p class="text-blue-50 mb-8 text-sm leading-relaxed">Bergabunglah dengan program yang dirancang khusus untuk meningkatkan kemampuan Anda dari level <span class="font-bold text-white">{{ $cefrLevel }}</span> ke tahap selanjutnya dengan pengajar profesional.</p>
                    
                    <a href="{{ route('student.register') }}" class="block w-full text-center bg-white text-blue-600 font-bold py-3 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Daftar Kelas Sekarang
                    </a>
                </div>

            </div>
        </div>
    @endif
</div>

<!-- Chart.js Injection -->
@if($hasData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxRadar = document.getElementById('skillRadarChart').getContext('2d');
        const radarScores = @json($radarData);
        
        new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: ['Grammar', 'Listening', 'Vocabulary', 'Reading', 'Writing'],
                datasets: [{
                    label: 'Estimasi Skill Level',
                    data: radarScores,
                    backgroundColor: 'rgba(79, 70, 229, 0.2)', // Indigo
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
                            font: { size: 13, family: "'Figtree', sans-serif", weight: '600' },
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
                                return ' Proyeksi Skor: ' + Math.round(context.raw);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endif

@endsection
