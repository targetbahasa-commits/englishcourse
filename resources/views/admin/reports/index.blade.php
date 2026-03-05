@extends('layouts.admin')

@section('title', 'Reports Dashboard')

@push('scripts')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Reports Overview</h1>
        <p class="text-gray-500 mt-2">Gambaran besar mengenai kesehatan bisnis, akademik, performa pengajar, dan operasional.</p>
    </div>

    <!-- 1. Top Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Monthly Revenue -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Monthly Revenue</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="p-3 bg-green-50 rounded-xl text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- New Enrolled Students -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">New Enrolled Students</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $newEnrolledStudents }}</h3>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <!-- Active Teachers -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Active Teachers</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $activeTeachers }}</h3>
            </div>
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <!-- 2. Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Line Chart: Student Growth -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pertumbuhan Siswa (6 Bulan Terakhir)</h3>
            <div class="relative h-72 w-full">
                <canvas id="studentGrowthChart"></canvas>
            </div>
        </div>

        <!-- Pie Chart: Program Popularity -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Program</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="programPopularityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- 3. Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Performing Students -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Top Performing Students</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 font-semibold">Program</th>
                            <th class="px-6 py-4 font-semibold">Peningkatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($topPerformingStudents as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $student['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $student['program'] }}</td>
                            <td class="px-6 py-4 text-sm text-green-600 font-bold">{{ $student['score_improvement'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Highest Rated Teachers -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Highest Rated Teachers</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold">Nama Pengajar</th>
                            <th class="px-6 py-4 font-semibold">Spesialisasi</th>
                            <th class="px-6 py-4 font-semibold">Rating (NPS)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($highestRatedTeachers as $teacher)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $teacher['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher['specialty'] }}</td>
                            <td class="px-6 py-4 text-sm text-yellow-500 font-bold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                {{ $teacher['rating'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. Detailed Metrics Sections -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Detailed Operational Insights</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Financial & Sales -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
            <div class="p-4 bg-green-50 text-green-600 rounded-xl h-fit">
                <i class="bi bi-wallet2 fs-3"></i>
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-800 mb-2">Financial & Sales Report</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex justify-between border-b pb-1">
                        <span>Conversion Rate (Guest &rarr; Student)</span>
                        <span class="font-bold text-gray-800">{{ $metrics['financial']['conversion_rate'] }}</span>
                    </li>
                    <li class="flex justify-between border-b pb-1">
                        <span>Most Popular Program</span>
                        <span class="font-bold text-gray-800">IELTS Prep (60%)</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Academic & Student Progress -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-xl h-fit">
                <i class="bi bi-mortarboard fs-3"></i>
            </div>
            <div class="w-full">
                <h4 class="text-lg font-bold text-gray-800 mb-2">Academic & Student Progress</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex justify-between border-b pb-1">
                        <span>Retention Rate</span>
                        <span class="font-bold text-gray-800">{{ $metrics['academic']['retention_rate'] }}</span>
                    </li>
                    <li class="flex justify-between border-b pb-1">
                        <span>Average Student Satisfaction (NPS)</span>
                        <span class="font-bold text-gray-800">{{ $metrics['academic']['avg_nps'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Teacher Performance -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
            <div class="p-4 bg-purple-50 text-purple-600 rounded-xl h-fit">
                <i class="bi bi-person-video3 fs-3"></i>
            </div>
            <div class="w-full">
                <h4 class="text-lg font-bold text-gray-800 mb-2">Teacher Performance</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex justify-between border-b pb-1">
                        <span>Grading Turnaround Time</span>
                        <span class="font-bold text-gray-800">{{ $metrics['teacher']['grading_time'] }}</span>
                    </li>
                    <li class="flex justify-between border-b pb-1">
                        <span>Class Completion Ratio</span>
                        <span class="font-bold text-gray-800">{{ $metrics['teacher']['class_completion'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Operational & Engagement -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
            <div class="p-4 bg-orange-50 text-orange-600 rounded-xl h-fit">
                <i class="bi bi-activity fs-3"></i>
            </div>
            <div class="w-full">
                <h4 class="text-lg font-bold text-gray-800 mb-2">Operational & Engagement</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex justify-between border-b pb-1">
                        <span>Peak Activity Hours</span>
                        <span class="font-bold text-gray-800">{{ $metrics['operational']['peak_hours'] }}</span>
                    </li>
                    <li class="flex justify-between border-b pb-1">
                        <span>Attendance Summary</span>
                        <span class="font-bold text-gray-800">{{ $metrics['operational']['attendance_summary'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Student Growth Line Chart
        const lineCtx = document.getElementById('studentGrowthChart').getContext('2d');
        const growthLabels = @json($studentGrowthData['labels']);
        const growthData = @json($studentGrowthData['data']);
        
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: growthLabels,
                datasets: [{
                    label: 'Aktif Siswa',
                    data: growthData,
                    borderColor: '#3B82F6', // blue-500
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3B82F6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1E293B',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            borderDash: [5, 5]
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // 2. Program Popularity Doughnut Chart
        const pieCtx = document.getElementById('programPopularityChart').getContext('2d');
        const programLabels = @json($programPopularityData['labels']);
        const programData = @json($programPopularityData['data']);

        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: programLabels,
                datasets: [{
                    data: programData,
                    backgroundColor: [
                        '#3B82F6', // Blue (IELTS)
                        '#F59E0B', // Yellow (TOEFL)
                        '#10B981', // Green (General)
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'figtree', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
