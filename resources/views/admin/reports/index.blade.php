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

    <div class="mb-6">
        <div class="inline-flex flex-wrap gap-2 bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
            <a href="{{ route('admin.reports.index', ['tab' => 'student']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $activeTab === 'student' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50' }}">Laporan Student <span class="ml-1 opacity-80">({{ $tabCounts['student'] }})</span></a>
            <a href="{{ route('admin.reports.index', ['tab' => 'teacher']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $activeTab === 'teacher' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50' }}">Laporan Teacher <span class="ml-1 opacity-80">({{ $tabCounts['teacher'] }})</span></a>
            <a href="{{ route('admin.reports.index', ['tab' => 'guest']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $activeTab === 'guest' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50' }}">Laporan Guest <span class="ml-1 opacity-80">({{ $tabCounts['guest'] }})</span></a>
            <a href="{{ route('admin.reports.index', ['tab' => 'finance']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $activeTab === 'finance' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50' }}">Laporan Keuangan <span class="ml-1 opacity-80">({{ $tabCounts['finance'] }})</span></a>
        </div>
    </div>

    <!-- 1. Top Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @if($activeTab === 'student')
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">New Enrolled Students</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $newEnrolledStudents }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Retention Rate</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $metrics['academic']['retention_rate'] }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Average Teacher Rating (1-5)</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $metrics['academic']['avg_teacher_rating'] }}</h3>
            </div>
        @elseif($activeTab === 'teacher')
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Active Teachers</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $activeTeachers }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Grading Turnaround</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $metrics['teacher']['grading_time'] }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Class Completion Ratio</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $metrics['teacher']['class_completion'] }}</h3>
            </div>
        @elseif($activeTab === 'guest')
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Active Guests</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $activeGuests }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">New Guests (This Month)</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $newGuestsThisMonth }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Guest to Student (This Month)</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $guestToStudentConvertedThisMonth }}</h3>
            </div>
        @else
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Monthly Revenue</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Paid Transactions (This Month)</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $financialSummary['paid_transactions_count'] }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-1">Pending Transactions</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $financialSummary['pending_transactions_count'] }}</h3>
            </div>
        @endif
    </div>

    @if($activeTab === 'student')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Pertumbuhan Siswa (6 Bulan Terakhir)</h3>
                <div class="relative h-72 w-full">
                    <canvas id="studentGrowthChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Program</h3>
                <div class="relative h-64 w-full flex justify-center">
                    <canvas id="programPopularityChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
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
    @elseif($activeTab === 'teacher')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
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
                            <td class="px-6 py-4 text-sm text-yellow-500 font-bold">{{ $teacher['rating'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($activeTab === 'guest')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h4 class="text-lg font-bold text-gray-800 mb-3">Guest Funnel Ringkas</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex justify-between border-b pb-1"><span>Active Guests</span><span class="font-bold text-gray-800">{{ $activeGuests }}</span></li>
                    <li class="flex justify-between border-b pb-1"><span>New Guests (Bulan Ini)</span><span class="font-bold text-gray-800">{{ $newGuestsThisMonth }}</span></li>
                    <li class="flex justify-between border-b pb-1"><span>Converted to Student (Bulan Ini)</span><span class="font-bold text-gray-800">{{ $guestToStudentConvertedThisMonth }}</span></li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h4 class="text-lg font-bold text-gray-800 mb-3">Konversi</h4>
                <p class="text-sm text-gray-600">Conversion Rate (Guest → Student): <span class="font-bold text-gray-800">{{ $metrics['financial']['conversion_rate'] }}</span></p>
                <p class="text-xs text-gray-500 mt-3">Dihitung dari total akun yang pernah dikonversi dari guest ke student, dibagi total akun guest + yang sudah dikonversi.</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Program</h3>
                <div class="relative h-72 w-full">
                    <canvas id="programPopularityChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Revenue Source</h3>
                <p class="text-sm text-gray-600">Basis revenue bulan ini:</p>
                <p class="mt-2 inline-flex px-3 py-1.5 rounded-lg text-xs font-semibold {{ $revenueBasis === 'paid_transactions' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $revenueBasis === 'paid_transactions' ? 'Paid Transactions' : 'Enrollment Estimate (Fallback)' }}
                </p>
                <div class="mt-4 space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between border-b pb-1"><span>Paid Transactions</span><span class="font-bold text-gray-800">{{ $financialSummary['paid_transactions_count'] }}</span></div>
                    <div class="flex justify-between border-b pb-1"><span>Pending Transactions</span><span class="font-bold text-gray-800">{{ $financialSummary['pending_transactions_count'] }}</span></div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lineEl = document.getElementById('studentGrowthChart');
        if (lineEl) {
            const lineCtx = lineEl.getContext('2d');
            const growthLabels = @json($studentGrowthData['labels']);
            const growthData = @json($studentGrowthData['data']);

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: growthLabels,
                    datasets: [{
                        label: 'Aktif Siswa',
                        data: growthData,
                        borderColor: '#3B82F6',
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
        }

        const pieEl = document.getElementById('programPopularityChart');
        if (pieEl) {
            const pieCtx = pieEl.getContext('2d');
            const programLabels = @json($programPopularityData['labels']);
            const programData = @json($programPopularityData['data']);

            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: programLabels,
                    datasets: [{
                        data: programData,
                        backgroundColor: ['#3B82F6', '#F59E0B', '#10B981', '#6366F1', '#14B8A6', '#F97316'],
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
                                    return ' ' + context.label + ': ' + context.parsed;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
