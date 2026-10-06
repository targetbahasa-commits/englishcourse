@extends('layouts.admin')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
            <a href="{{ route('students.index') }}" class="hover:text-blue-600 transition-colors">Students</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-gray-900 font-medium">{{ $student->name }}</span>
        </div>
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-3">
            Student Profile
        </h2>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition">
            Back to List
        </a>
        <a href="{{ route('users.edit', $student) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Student
        </a>
        <button type="button" @click="showPasswordModal = true" class="px-4 py-2 bg-amber-600 text-white font-medium rounded-xl hover:bg-amber-700 shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            Change Password
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="p-8 max-w-7xl mx-auto space-y-8" x-data="{ showPasswordModal: false }">
    @if(session('success'))
        <div class="mb-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Top Identity Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700"></div>
        <div class="px-8 pb-8">
            <div class="flex flex-col md:flex-row gap-6 -mt-16 mb-4">
                <!-- Avatar -->
                <div class="relative w-28 h-28 rounded-2xl bg-white p-1.5 shadow-md flex-shrink-0 mx-auto md:mx-0">
                    <div class="w-full h-full rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center border border-blue-100 overflow-hidden">
                        @if(isset($student) && $student->profile_photo)
                            <img src="{{ asset($student->profile_photo) }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl font-bold text-blue-600">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>
                
                <!-- Basic Info -->
                <div class="flex-1 flex flex-col justify-between pt-1">
                    <div class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-3">
                        <h1 class="text-3xl font-bold text-white drop-shadow-sm">{{ $student->name }}</h1>
                        @if($student->status === 'active')
                            <span class="px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-lg flex items-center gap-1.5 mt-2 md:mt-0 shadow-sm border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold bg-gray-100 text-gray-700 rounded-lg flex items-center gap-1.5 mt-2 md:mt-0 shadow-sm border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Inactive
                            </span>
                        @endif
                        <button type="button" @click="showPasswordModal = true" class="px-3 py-1 text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white rounded-lg flex items-center gap-1.5 mt-2 md:mt-0 shadow-sm transition">
                            🔑 Change Password
                        </button>
                    </div>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm text-gray-500 mt-6 md:mt-0 pb-1">
                        <a href="https://mail.google.com/mail/?view=cm&to={{ urlencode($student->email) }}"
                           target="_blank"
                           class="flex items-center gap-1.5 text-red-400 hover:text-red-600 transition-colors group"
                           title="Kirim email ke {{ $student->email }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="group-hover:underline">{{ $student->email }}</span>
                        </a>
                        @if($student->phone_number)
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $student->phone_number);
                            if (str_starts_with($waNumber, '0')) { $waNumber = '62' . substr($waNumber, 1); }
                            $waDisplay = '+' . ltrim($waNumber, '+');
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}"
                           target="_blank"
                           class="flex items-center gap-1.5 text-green-500 hover:text-green-600 font-medium transition-colors group"
                           title="Buka WhatsApp ke {{ $waDisplay }}">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span class="group-hover:underline">{{ $waDisplay }}</span>
                        </a>
                        @endif
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Joined {{ $student->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid within Header -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Program</p>
                    <p class="font-semibold text-gray-900">
                        @php
                            $allPrograms = [];
                            if ($student->program) {
                                $allPrograms[$student->program->id] = $student->program->name;
                            }
                            if ($student->enrollments) {
                                foreach ($student->enrollments as $enrollment) {
                                    if ($enrollment->program && in_array($enrollment->status, ['active', 'completed'])) {
                                        $allPrograms[$enrollment->program->id] = $enrollment->program->name;
                                    }
                                }
                            }
                        @endphp
                        @if(count($allPrograms) > 0)
                            {{ implode(', ', $allPrograms) }}
                        @else
                            No Program
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Learning Mode</p>
                    <p class="font-semibold text-gray-900 capitalize">{{ $student->learning_mode ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Batch Kelas</p>
                    <p class="font-semibold text-gray-900">
                        @if($student->classPeriod)
                            {{ $student->classPeriod->name }}
                        @else
                            <span class="text-gray-400 italic">Belum ditentukan</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Assigned Teacher</p>
                    <p class="font-semibold text-gray-900">
                        @if($student->teacher)
                            {{ $student->teacher->name }}
                        @else
                            <span class="text-red-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Needs Assignment</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Referral Code</p>
                    <p class="font-semibold text-gray-900">
                        @if($student->referral_code)
                            <span class="bg-gray-100 px-2 py-0.5 rounded text-sm tracking-wider font-mono">{{ $student->referral_code }}</span>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Camp Location</p>
                    <p class="font-semibold text-gray-900">
                        @if($student->camp)
                            {{ $student->camp->nama_camp }}
                            @if($student->campRoom)
                                <span class="text-xs text-gray-500 block">Room: {{ $student->campRoom->nama_kamar }}</span>
                            @endif
                        @else
                            <span class="text-gray-400">Tidak tinggal di camp</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Academic Progress -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Progress Overview -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    Academic Progress
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Progress Card -->
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-sm font-medium text-gray-500 mb-1">Course Completion</p>
                        <div class="flex items-end gap-2 mb-3">
                            <span class="text-3xl font-black text-gray-900">{{ $progressPercentage }}%</span>
                            <span class="text-sm text-gray-500 mb-1">({{ $completedAssignments }}/{{ $totalAssignments }})</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>

                    <!-- Avg Score Card -->
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-sm font-medium text-gray-500 mb-1">Average Score</p>
                        <div class="flex items-end gap-2">
                            <span class="text-3xl font-black text-gray-900">{{ round($averageScore, 1) }}</span>
                            <span class="text-sm text-gray-500 mb-1">pts</span>
                        </div>
                    </div>

                    <!-- Points Card -->
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-sm font-medium text-gray-500 mb-1">Referral Points</p>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-black text-amber-500">{{ $student->referral_points }}</span>
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Recent Submissions Table -->
                <h4 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Recent Activity</h4>
                @if($recentActivity->count() > 0)
                <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Assignment</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Score</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($recentActivity as $activity)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $activity->program->name ?? 'Assignment' }} - Meeting {{ $activity->meeting_number }}
                                    </div>
                                    <div class="text-xs text-gray-500">M-{{ str_pad($activity->meeting_number, 2, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                        {{ $activity->score >= 80 ? 'bg-green-100 text-green-800' : 
                                           ($activity->score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $activity->score }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($activity->submitted_at)->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-gray-500 font-medium text-sm">No recent activity found.</p>
                </div>
                @endif
            </div>

            {{-- ─── All Assignment Scores ──────────────────────────────── --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center text-violet-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        All Assignment Scores
                    </h3>
                    @if($allAssignmentScores->count() > 0)
                        <span class="text-xs font-semibold bg-violet-100 text-violet-700 px-3 py-1 rounded-full">
                            {{ $allAssignmentScores->count() }} submission{{ $allAssignmentScores->count() !== 1 ? 's' : '' }}
                        </span>
                    @endif
                </div>

                @if($allAssignmentScores->count() > 0)
                    @php
                        $scoresByProgram = $allAssignmentScores->groupBy(fn($s) => $s->program?->name ?? 'Unknown Program');
                    @endphp

                    <div class="space-y-6">
                        @foreach($scoresByProgram as $programName => $scores)
                        @php
                            $progAvg    = round($scores->avg('score'), 1);
                            $progMin    = $scores->min('score');
                            $progMax    = $scores->max('score');
                            $avgColor   = $progAvg >= 80 ? 'text-green-600' : ($progAvg >= 60 ? 'text-amber-500' : 'text-red-500');
                            $barColor   = $progAvg >= 80 ? 'bg-green-500' : ($progAvg >= 60 ? 'bg-amber-400' : 'bg-red-400');
                        @endphp
                        <div class="border border-gray-100 rounded-2xl overflow-hidden">
                            {{-- Program header --}}
                            <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-gray-800">{{ $programName }}</span>
                                    <span class="text-xs text-gray-400 font-medium">{{ $scores->count() }} meetings</span>
                                </div>
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span>Min: <strong class="text-gray-700">{{ $progMin }}</strong></span>
                                    <span>Max: <strong class="text-gray-700">{{ $progMax }}</strong></span>
                                    <span>Avg: <strong class="{{ $avgColor }}">{{ $progAvg }}</strong></span>
                                </div>
                            </div>

                            {{-- Score progress bar --}}
                            <div class="px-5 pt-3 pb-1">
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="{{ $barColor }} h-1.5 rounded-full transition-all" style="width: {{ min(100, $progAvg) }}%"></div>
                                </div>
                            </div>

                            {{-- Scores table --}}
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-50">
                                    <thead>
                                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                            <th class="px-5 py-2">Meeting</th>
                                            <th class="px-5 py-2 text-center">Score</th>
                                            <th class="px-5 py-2 text-right">Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-50">
                                        @foreach($scores as $score)
                                        @php
                                            $scoreVal   = $score->score;
                                            $badgeClass = $scoreVal >= 80
                                                ? 'bg-green-100 text-green-800'
                                                : ($scoreVal >= 60 ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800');
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-5 py-3 text-sm font-medium text-gray-900">
                                                Meeting {{ str_pad($score->meeting_number, 2, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $badgeClass }}">
                                                    {{ $scoreVal }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3 text-right text-xs text-gray-400">
                                                {{ $score->submitted_at ? \Carbon\Carbon::parse($score->submitted_at)->format('d M Y, H:i') : '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <svg class="mx-auto h-10 w-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-gray-500 font-medium text-sm">No assignment scores recorded yet.</p>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    Latest Free Test Record
                </h3>

                @if($latestTest)
                <div class="flex items-center justify-between p-6 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl border border-emerald-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2 block">{{ str_replace('_', ' ', $latestTest->test_type) }}</span>
                        <h4 class="text-2xl font-black text-gray-900">{{ $latestTest->score }}</h4>
                        <p class="text-sm text-gray-500 mt-1">Taken on {{ $latestTest->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('free-test.result', $latestTest->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-emerald-700 font-medium rounded-xl border border-emerald-200 shadow-sm hover:bg-emerald-50 transition text-sm">
                            View Result <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                    <p class="text-gray-500 font-medium text-sm">Has not taken any Free Tests yet.</p>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    Final Test Certificate
                </h3>

                @if($latestFinalTest)
                <div class="flex items-center justify-between p-6 bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-2 block">{{ $latestFinalTest->test_label ?: str_replace('_', ' ', $latestFinalTest->test_type) }}</span>
                        <h4 class="text-2xl font-black text-gray-900">{{ is_numeric($latestFinalTest->score) ? number_format((float) $latestFinalTest->score, 1) : $latestFinalTest->score }}</h4>
                        <p class="text-sm text-gray-500 mt-1">Completed on {{ optional($latestFinalTest->completed_at ?? $latestFinalTest->created_at)->format('d M Y') }}</p>
                    </div>
                    <div class="text-right flex flex-col gap-2 items-end">
                        <a href="{{ route('final-test.results.show', $latestFinalTest) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-amber-700 font-medium rounded-xl border border-amber-200 shadow-sm hover:bg-amber-50 transition text-sm">
                            View Result <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                        <a href="{{ route('final-test.certificate.download', $latestFinalTest) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white font-medium rounded-xl shadow-sm hover:bg-amber-700 transition text-sm">
                            Download Certificate <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </a>
                    </div>
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                    <p class="text-gray-500 font-medium text-sm">Has not completed any Final Test yet.</p>
                </div>
                @endif
            </div>

        </div>

        <!-- Right Column: Classes and Details -->
        <div class="space-y-8">
            
            <!-- Class Period / Schedule -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Class Schedule
                </h3>

                @if($student->classPeriod)
                <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100 mb-4">
                    <h4 class="font-bold text-indigo-900">{{ $student->classPeriod->name }}</h4>
                    <p class="text-xs text-indigo-700 mt-1">{{ $student->classPeriod->classMeetings->count() }} total meetings</p>
                </div>
                
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Upcoming Meetings</h4>
                <div class="space-y-3">
                    @php
                        $upcoming = $student->classPeriod->classMeetings()
                            ->where('meeting_date', '>=', now()->toDateString())
                            ->orderBy('meeting_date')
                            ->orderBy('start_time')
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @forelse($upcoming as $meet)
                    <div class="flex items-center gap-4 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="bg-indigo-100 text-indigo-700 w-12 h-12 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold leading-none">{{ \Carbon\Carbon::parse($meet->meeting_date)->format('M') }}</span>
                            <span class="text-lg font-black leading-none mt-0.5">{{ \Carbon\Carbon::parse($meet->meeting_date)->format('d') }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm line-clamp-1">{{ $meet->assignment->title ?? 'Meeting ' . $meet->meeting_number }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($meet->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($meet->end_time)->format('H:i') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 italic">No upcoming meetings scheduled.</p>
                    @endforelse
                </div>
                @else
                <p class="text-sm text-gray-500">Not assigned to any class period yet.</p>
                @endif
            </div>

            <!-- Enrolled Programs & Scores -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    Program Scores
                </h3>

                @php
                    $enrolledProgramIds = \App\Models\Enrollment::where('user_id', $student->id)->pluck('program_id')->toArray();
                    if ($student->program_id) {
                        $enrolledProgramIds[] = $student->program_id;
                    }
                    
                    // Distinct programs
                    $programIds = array_unique($enrolledProgramIds);
                    $programs = \App\Models\Program::whereIn('id', $programIds)->get();
                    
                    $programScores = \App\Models\MeetingScore::where('user_id', $student->id)
                        ->whereNotNull('program_id')
                        ->selectRaw('program_id, count(*) as count, avg(score) as avg_score')
                        ->groupBy('program_id')
                        ->get()
                        ->keyBy('program_id');
                @endphp

                @if($programs->count() > 0)
                <div class="space-y-4">
                    @foreach($programs as $prog)
                    @php
                        $scoreData = $programScores->get($prog->id);
                        $avgScore = $scoreData ? $scoreData->avg_score : null;
                        $count = $scoreData ? $scoreData->count : 0;
                    @endphp
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">{{ $prog->name }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $count }} meetings submitted</p>
                        </div>
                        <div class="text-right">
                            @if($avgScore !== null)
                                <span class="text-lg font-black {{ $avgScore >= 80 ? 'text-green-600' : ($avgScore >= 60 ? 'text-amber-500' : 'text-red-500') }}">
                                    {{ round($avgScore, 1) }}
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-gray-400 bg-gray-200 px-2 py-1 rounded-md uppercase tracking-wide">No Score</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-500 italic">No programs found.</p>
                @endif
            </div>

            <!-- Semua Meeting: full meeting list per program with click-to-view
                 Q&A, so admin can review/correct without leaving this page. -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8" x-data="{
                    viewingMeeting: null,
                    refreshingMeeting: false,
                    refreshViewingMeeting() {
                        if (!this.viewingMeeting || this.refreshingMeeting) return;
                        this.refreshingMeeting = true;
                        const params = new URLSearchParams({
                            program_id: this.viewingMeeting.programId,
                            meeting_number: this.viewingMeeting.meetingNumber,
                        });
                        fetch(@js(route('admin.students.meeting_answers', $student)) + '?' + params.toString(), {
                            headers: { 'Accept': 'application/json' },
                        })
                            .then(res => res.json())
                            .then(data => {
                                this.viewingMeeting = { ...this.viewingMeeting, ...data };
                            })
                            .finally(() => { this.refreshingMeeting = false; });
                    },
                    ...draftViewerWithDrawing(),
                }">
                <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Semua Meeting
                </h3>

                @php
                    $meetingGroups = collect();
                    foreach ($programs as $prog) {
                        $meetingsForProg = \App\Models\Meeting::where('program_id', $prog->id)
                            ->orderBy('meeting_number')
                            ->get();

                        if ($meetingsForProg->isEmpty()) {
                            continue;
                        }

                        $submittedByMeeting = \App\Models\MeetingScore::where('user_id', $student->id)
                            ->where('program_id', $prog->id)
                            ->where('is_reported', true)
                            ->get()
                            ->keyBy('meeting_number');

                        $draftsByMeeting = \App\Models\AssignmentDraft::where('user_id', $student->id)
                            ->where('program_id', $prog->id)
                            ->get()
                            ->keyBy('meeting_number');

                        $meetingGroups->push([
                            'program' => $prog,
                            'rows' => $meetingsForProg->map(function ($m) use ($submittedByMeeting, $draftsByMeeting) {
                                $score = $submittedByMeeting->get($m->meeting_number);
                                $draft = $draftsByMeeting->get($m->meeting_number);
                                $status = $score ? 'submitted' : ($draft ? 'in_progress' : 'not_started');

                                return ['meeting' => $m, 'status' => $status, 'score' => $score, 'draft' => $draft];
                            }),
                        ]);
                    }
                @endphp

                @forelse ($meetingGroups as $group)
                    @php
                        $groupTotal = $group['rows']->count();
                        $groupSubmitted = $group['rows']->where('status', 'submitted')->count();
                        $groupInProgress = $group['rows']->where('status', 'in_progress')->count();
                        // Only one program to show? Keep it expanded (no behavior
                        // change from before). Multiple programs collapse by
                        // default so the page doesn't get flooded with rows.
                        $groupOpenByDefault = $meetingGroups->count() <= 1 ? 'true' : 'false';
                    @endphp
                    <div class="mb-4 last:mb-0 border border-gray-100 rounded-2xl overflow-hidden" x-data="{ open: {{ $groupOpenByDefault }} }">
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between gap-3 p-4 bg-gray-50 hover:bg-gray-100 transition text-left">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $group['program']->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $groupTotal }} meeting &bull; {{ $groupSubmitted }} submitted
                                    @if($groupInProgress)
                                        &bull; {{ $groupInProgress }} sedang dikerjakan
                                    @endif
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-collapse class="p-4 pt-2 space-y-2">
                            @foreach ($group['rows'] as $row)
                                @php
                                    $m = $row['meeting'];
                                    $status = $row['status'];
                                    $score = $row['score'];
                                    $draft = $row['draft'];
                                    $answers = $status === 'submitted'
                                        ? (is_array($score->answers_data) ? $score->answers_data : [])
                                        : ($status === 'in_progress' ? (is_array($draft->answers) ? $draft->answers : []) : []);
                                    $questions = \App\Http\Controllers\Admin\AdminGrammarWritingReviewController::resolveQuestionsForMeeting(
                                        $group['program']->slug ?? '',
                                        (int) $m->meeting_number
                                    );
                                    $savedAt = $status === 'submitted'
                                        ? $score->submitted_at?->diffForHumans()
                                        : ($status === 'in_progress' ? $draft->last_saved_at?->diffForHumans() : null);
                                    // The full-page "Koreksi" editor only knows how to
                                    // render Grammar Writing content - don't link there
                                    // for other program types (IELTS, Speaking, etc.).
                                    $isGrammarWritingTrack = in_array(
                                        $group['program']->slug ?? '',
                                        array_column(\App\Http\Controllers\Admin\AdminGrammarWritingReviewController::TRACKS, 'slug'),
                                        true
                                    );
                                @endphp
                                <button type="button"
                                    @if($status !== 'not_started')
                                    @click="viewingMeeting = { programId: {{ (int) $group['program']->id }}, programName: @js($group['program']->name), meetingNumber: {{ (int) $m->meeting_number }}, title: @js($m->title), status: @js($status), score: {{ $score->score ?? 'null' }}, meetingScoreId: {{ $isGrammarWritingTrack ? ($score->id ?? 'null') : 'null' }}, savedAt: @js($savedAt), answers: @js($answers), questions: @js($questions) }"
                                    @endif
                                    {{ $status === 'not_started' ? 'disabled' : '' }}
                                    class="w-full flex items-center justify-between gap-3 p-3 rounded-xl border transition text-left
                                        {{ $status === 'submitted' ? 'border-green-200 bg-green-50 hover:bg-green-100 cursor-pointer' : '' }}
                                        {{ $status === 'in_progress' ? 'border-amber-200 bg-amber-50 hover:bg-amber-100 cursor-pointer' : '' }}
                                        {{ $status === 'not_started' ? 'border-gray-100 bg-gray-50 opacity-60 cursor-not-allowed' : '' }}">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold shrink-0
                                            {{ $status === 'submitted' ? 'bg-green-600 text-white' : '' }}
                                            {{ $status === 'in_progress' ? 'bg-amber-500 text-white' : '' }}
                                            {{ $status === 'not_started' ? 'bg-gray-300 text-gray-600' : '' }}">
                                            {{ $m->meeting_number }}
                                        </span>
                                        <span class="text-sm font-semibold text-gray-800 truncate">{{ $m->title ?? ('Meeting ' . $m->meeting_number) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        @if($status === 'submitted')
                                            <span class="text-sm font-black text-green-700">{{ $score->score }}</span>
                                            <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-full uppercase">Submitted</span>
                                        @elseif($status === 'in_progress')
                                            <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full uppercase">Sedang Dikerjakan</span>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-400 bg-gray-200 px-2 py-0.5 rounded-full uppercase">Belum Dikerjakan</span>
                                        @endif
                                    </div>
                                </button>
                                @if($status === 'in_progress' && $isGrammarWritingTrack)
                                    <button type="button"
                                        @click="viewingDraft = { id: {{ (int) $draft->id }}, user_id: {{ (int) $draft->user_id }}, program_id: {{ (int) $group['program']->id }}, meeting_number: {{ (int) $m->meeting_number }}, name: @js($student->name), email: @js($student->email ?? ''), meta: @js($group['program']->name . ' · Meeting ' . $m->meeting_number), savedAt: @js($savedAt), answers: @js($answers), questions: @js($questions) }"
                                        class="mt-1.5 w-full flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition cursor-pointer">
                                        ✏️ Koreksi (Coret-Coret &amp; Download)
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">Belum ada data meeting untuk program yang diambil.</p>
                @endforelse

                <!-- Meeting Answers Modal (same rendering pattern as the
                     "Lihat Jawaban" modal on admin/assignments/results/show) -->
                <div x-show="viewingMeeting" x-cloak @keydown.escape.window="viewingMeeting = null" @click.self="viewingMeeting = null"
                     class="fixed inset-0 bg-black/50 backdrop-blur-xs flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] flex flex-col overflow-hidden border border-gray-100" @click.stop>
                        <div class="flex items-start justify-between p-6 pb-4 border-b border-gray-100 bg-slate-50/50 shrink-0">
                            <div>
                                <h3 class="text-lg font-extrabold text-gray-900" x-text="viewingMeeting?.programName"></h3>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-orange-100 text-orange-800"
                                          x-text="'Meeting ' + viewingMeeting?.meetingNumber + (viewingMeeting?.title ? (' - ' + viewingMeeting.title) : '')"></span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold"
                                          :class="viewingMeeting?.status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800'"
                                          x-text="viewingMeeting?.status === 'submitted' ? 'Submitted' : 'Sedang Dikerjakan'"></span>
                                    <template x-if="viewingMeeting?.score !== null && viewingMeeting?.score !== undefined">
                                        <span class="text-xs font-black text-gray-700">Score: <span x-text="viewingMeeting?.score"></span></span>
                                    </template>
                                    <span class="text-xs text-gray-400" x-show="viewingMeeting?.savedAt">&bull;</span>
                                    <span class="text-xs text-gray-500 font-medium" x-text="viewingMeeting?.savedAt ? ('Tersimpan ' + viewingMeeting.savedAt) : ''"></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" @click="refreshViewingMeeting()" :disabled="refreshingMeeting" title="Refresh jawaban terbaru" class="w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-700 hover:bg-gray-100 flex items-center justify-center transition shadow-xs disabled:opacity-50">
                                    <svg class="w-4 h-4" :class="refreshingMeeting ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                                <button type="button" @click="viewingMeeting = null" class="w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-700 hover:bg-gray-100 flex items-center justify-center transition shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6 space-y-4 overflow-y-auto max-h-[calc(85vh-100px)]">
                            <template x-for="(value, key) in (viewingMeeting?.answers || {})" :key="key">
                                <div class="border border-gray-200/90 rounded-2xl p-4 bg-gray-50/70 hover:bg-gray-50 transition space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-800"
                                                  x-text="key === 'paragraph_answer' || key === 'userParagraphAnswer' ? 'Latihan Paragraf' : (isNaN(key) ? key : 'Soal ' + key)">
                                            </span>
                                        </div>
                                    </div>

                                    <template x-if="(viewingMeeting?.questions && viewingMeeting?.questions[key]) || (typeof value === 'object' && value !== null && (value.question || value.question_text))">
                                        <div class="bg-red-50 border border-red-200 rounded-xl p-3">
                                            <span class="text-[10px] font-bold text-red-500 uppercase tracking-wider block mb-1">Soal:</span>
                                            <p class="text-sm font-bold text-red-600 leading-relaxed whitespace-pre-wrap" x-html="(viewingMeeting?.questions && viewingMeeting?.questions[key]) || value.question || value.question_text"></p>
                                        </div>
                                    </template>

                                    <template x-if="typeof value === 'object' && value !== null && !Array.isArray(value)">
                                        <div class="space-y-2.5">
                                            <template x-if="value.tense">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-semibold text-gray-500 uppercase">Tense:</span>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/80" x-text="value.tense"></span>
                                                </div>
                                            </template>

                                            <template x-if="value.trans !== undefined || value.answer !== undefined || value.user_answer !== undefined">
                                                <div>
                                                    <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Terjemahan / Jawaban:</span>
                                                    <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed"
                                                         x-text="(value.trans || value.answer || value.user_answer || '(kosong)')">
                                                    </div>
                                                </div>
                                            </template>

                                            <template x-if="value.v2 || value.v3">
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                                                    <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                                        <span class="text-[10px] font-bold text-gray-400 block uppercase mb-0.5">V2 (Simple Past)</span>
                                                        <span class="text-sm font-bold text-gray-800" x-text="value.v2 || '—'"></span>
                                                    </div>
                                                    <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                                        <span class="text-[10px] font-bold text-gray-400 block uppercase mb-0.5">V3 (Past Participle)</span>
                                                        <span class="text-sm font-bold text-gray-800" x-text="value.v3 || '—'"></span>
                                                    </div>
                                                </div>
                                            </template>

                                            <template x-for="(subVal, subKey) in value" :key="subKey">
                                                <template x-if="!['tense', 'trans', 'answer', 'user_answer', 'v2', 'v3'].includes(subKey)">
                                                    <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                                        <span class="text-xs font-bold text-gray-500 uppercase block mb-1" x-text="subKey"></span>
                                                        <div class="text-sm text-gray-800 whitespace-pre-wrap" x-text="typeof subVal === 'object' ? JSON.stringify(subVal, null, 2) : (subVal || '(kosong)')"></div>
                                                    </div>
                                                </template>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="typeof value !== 'object' || value === null">
                                        <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed"
                                             x-text="value || '(kosong)'">
                                        </div>
                                    </template>

                                    <template x-if="Array.isArray(value)">
                                        <div class="space-y-2">
                                            <template x-for="(item, idx) in value" :key="idx">
                                                <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs text-sm text-gray-800 flex items-start gap-2.5">
                                                    <span class="text-xs font-bold text-gray-400 shrink-0" x-text="(idx + 1) + '.'"></span>
                                                    <span class="font-medium" x-text="typeof item === 'object' ? JSON.stringify(item) : (item || '(kosong)')"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <p x-show="!viewingMeeting?.answers || Object.keys(viewingMeeting.answers).length === 0" class="text-sm text-gray-400 text-center py-8">
                                Belum ada jawaban tersimpan.
                            </p>

                            <div x-show="viewingMeeting?.status === 'submitted'" class="pt-2 border-t border-gray-100 mt-4">
                                <a :href="'{{ url('/admin/grammar-writing-review') }}/' + viewingMeeting?.meetingScoreId"
                                   x-show="viewingMeeting?.meetingScoreId"
                                   class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800">
                                    Buka Halaman Koreksi Lengkap
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.partials.draft-drawing-modal')
            </div>

            <!-- Notes or Bio -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Bio / Notes
                </h3>
                
                @if($student->bio)
                <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 text-sm text-amber-900 whitespace-pre-line">
                    {{ $student->bio }}
                </div>
                @else
                <p class="text-sm text-gray-400 italic">No bio or notes provided by the student.</p>
                @endif
            </div>

    {{-- =============================
         Change Password Modal
         ============================= --}}
    <div x-show="showPasswordModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showPasswordModal = false"></div>
            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10">
                <form action="{{ route('admin.users.change_password', $student) }}" method="POST">
                    @csrf
                    <div class="flex items-start gap-4 mb-5">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-amber-100">
                            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Change Student Password</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Set a new password for <span class="font-bold text-gray-900">{{ $student->name }}</span>.</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password" required minlength="6" placeholder="At least 6 characters"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required minlength="6" placeholder="Repeat new password"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showPasswordModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-amber-600 rounded-xl hover:bg-amber-700 transition shadow-sm flex items-center gap-1.5">
                            🔑 Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.draft-drawing-script')
@endpush
