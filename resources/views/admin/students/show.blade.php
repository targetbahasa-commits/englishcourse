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
    </div>
</div>
@endsection

@section('content')
<div class="p-8 max-w-7xl mx-auto space-y-8">
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
                    <p class="font-semibold text-gray-900">{{ $student->program ? $student->program->name : 'No Program' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Learning Mode</p>
                    <p class="font-semibold text-gray-900 capitalize">{{ $student->learning_mode ?? 'Not Set' }}</p>
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

            <!-- Free Test History -->
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

        </div>
    </div>
</div>
@endsection
