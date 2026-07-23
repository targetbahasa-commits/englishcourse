@extends('layouts.admin')

@section('title', 'Assignment Results - ' . $program->name)

@push('styles')
    <style>
        .score-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 0.875rem;
        }
        
        .score-excellent { background-color: #dcfce7; color: #166534; }
        .score-good { background-color: #dbeafe; color: #1e40af; }
        .score-fair { background-color: #fef3c7; color: #92400e; }
        .score-poor { background-color: #fee2e2; color: #991b1b; }
        
        .score-badge.pending { background-color: #f3f4f6; color: #6b7280; }
    </style>
@endpush

@section('content')
<div class="p-8">
    <!-- Header with Back Button -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.assignment-results.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to All Results
            </a>
            <h1 class="text-4xl font-bold text-gray-900">{{ $program->name }}</h1>
            <p class="text-gray-500 mt-2">Assignment submission and scoring details</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Submissions</p>
            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalSubmissions }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Completed</p>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $completedSubmissions }}</p>
            <p class="text-xs text-gray-500 mt-2">{{ $totalSubmissions > 0 ? round(($completedSubmissions / $totalSubmissions) * 100) : 0 }}% completed</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Average Score</p>
            <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $averageScore ? number_format($averageScore, 1) : 'N/A' }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Unique Students</p>
            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $uniqueStudents }}</p>
        </div>
    </div>

    <!-- Submissions by Meeting -->
    @if($submissionsByMeeting->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Submissions by Meeting</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Meeting</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Completed</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($submissionsByMeeting as $meeting)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-900">Meeting {{ $meeting->meeting_number }}</td>
                        <td class="px-6 py-4">
                            <span class="text-lg font-bold text-gray-900">{{ $meeting->total }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                {{ $meeting->completed }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    @php
                                        $percentage = $meeting->total > 0 ? ($meeting->completed / $meeting->total) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-blue-600 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ round($percentage) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Recent Submissions -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Submissions</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Meeting</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($program->meetingScores as $submission)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4">
                            <div>
                                <a href="{{ route('admin.assignment-results.submission', [$program, $submission]) }}" class="font-semibold text-gray-900 hover:text-blue-600 hover:underline">
                                    {{ $submission->user->name ?? 'N/A' }}
                                </a>
                                <p class="text-xs text-gray-500 mt-1">ID: {{ $submission->user->id ?? 'N/A' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $submission->user->email ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                                Meeting {{ $submission->meeting_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($submission->score !== null)
                            <span class="score-badge 
                                @if($submission->score >= 80) score-excellent
                                @elseif($submission->score >= 60) score-good
                                @elseif($submission->score >= 40) score-fair
                                @else score-poor
                                @endif">
                                {{ $submission->score }}
                            </span>
                            @else
                            <span class="score-badge pending">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($submission->submitted_at)
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $submission->submitted_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $submission->submitted_at->format('H:i') }}</p>
                            </div>
                            @else
                            <p class="text-sm text-gray-500">Not submitted</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-gray-500">No submissions found for this program.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
