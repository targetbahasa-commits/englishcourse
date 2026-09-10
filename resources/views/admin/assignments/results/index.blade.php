@extends('layouts.admin')

@section('title', 'Assignment Results')

@push('styles')
    <style>
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="mb-8 relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl shadow-lg p-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-10 w-40 h-40 bg-white opacity-5 rounded-full -mb-20"></div>
        <div class="relative z-10 text-white">
            <div class="flex items-center gap-3 mb-2">
                <span class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </span>
                <div>
                    <h1 class="text-3xl font-bold">Assignment Results</h1>
                    @if(request('program_id'))
                        <p class="text-blue-100 mt-1 text-sm">Viewing: <span class="font-semibold">{{ \App\Models\Program::find(request('program_id'))->name ?? 'Unknown' }}</span></p>
                    @else
                        <p class="text-blue-100 mt-1">View all program assignments and track student submission progress.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Total Assignments</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAssignments }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Completed</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $completedAssignments }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100) : 0 }}% completion</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Active Users</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $usersWithSubmissions }}</p>
                    <p class="text-xs text-gray-500 mt-1">of {{ $totalUsers }} total</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Programs</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ is_countable($programsWithAssignments) ? count($programsWithAssignments) : 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">with assignments</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Sedang Dikerjakan</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $inProgressCount ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">belum submit</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <form action="{{ route('admin.assignment-results.index') }}" method="GET" class="flex flex-col gap-4">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="text-xs font-semibold text-gray-600 block mb-2">Search Program</label>
                    <input type="text" name="search" placeholder="Search by program name..." value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="lg:w-80">
                    <label class="text-xs font-semibold text-gray-600 block mb-2">Filter by Class</label>
                    <select name="program_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- All Programs --</option>
                        @foreach(collect($allPrograms)->groupBy('category') as $category => $categoryPrograms)
                            <optgroup label="{{ $category }}">
                                @foreach($categoryPrograms as $program)
                                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium h-10">
                        Filter
                    </button>
                    @if(request('search') || request('program_id'))
                        <a href="{{ route('admin.assignment-results.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium h-10 flex items-center">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Top Performing Programs -->
    @if(is_countable($topPrograms) && count($topPrograms) > 0 && !request('program_id'))
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Top Performing Programs</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($topPrograms as $program)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $program->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $program->students_submitted ?? 0 }} students submitted</p>
                    </div>
                    @if($program->avg_score)
                    <div class="text-right">
                        <div class="text-2xl font-bold text-indigo-600">{{ number_format($program->avg_score, 1) }}</div>
                        <div class="text-xs text-gray-500">avg score</div>
                    </div>
                    @endif
                </div>
                <a href="{{ route('admin.assignment-results.show', $program) }}" class="inline-block text-sm text-blue-600 hover:text-blue-700 font-semibold">
                    View Details →
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Programs Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="font-bold text-gray-900">
                @if(request('program_id'))
                    {{ \App\Models\Program::find(request('program_id'))->name ?? 'Program' }} - Assignment Details
                @else
                    All Programs with Assignments
                @endif
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Program Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total Submissions</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Completed</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Completion Rate</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Enrolled Students</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($programsWithAssignments as $program)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $program->name }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $program->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-lg font-bold text-gray-900">{{ $program->meeting_scores_count ?? 0 }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                {{ $program->completed_assignments ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    @php
                                        $rate = $program->meeting_scores_count > 0 
                                            ? ($program->completed_assignments / $program->meeting_scores_count) * 100 
                                            : 0;
                                    @endphp
                                    <div class="h-full bg-blue-600 rounded-full transition" style="width: {{ $rate }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ round($rate) }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold">
                                {{ $program->enrollments_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.assignment-results.show', $program) }}"
                                class="inline-flex items-center gap-2 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-semibold text-lg mb-1">No assignment data found</p>
                                <p class="text-sm">No programs with assignment submissions yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
