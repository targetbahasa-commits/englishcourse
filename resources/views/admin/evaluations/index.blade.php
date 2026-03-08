@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Teacher Evaluations</h1>
                <p class="text-sm text-gray-500 mt-1">Monitor all feedback provided by students to teachers</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="bg-white border text-gray-800 border-gray-200 px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm">
                    <span class="text-sm text-gray-500">Platform Avg:</span>
                    <span class="font-bold text-amber-500 flex items-center gap-1">
                        {{ number_format($averageRating, 1) }} ★
                    </span>
                </div>
                <div class="bg-white border text-gray-800 border-gray-200 px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm">
                    <span class="text-sm text-gray-500">Total Reviews:</span>
                    <span class="font-bold text-indigo-600">{{ number_format($totalEvaluations) }}</span>
                </div>
            </div>
        </div>

        <!-- Top Teachers Section -->
        @if($topTeachers->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Top Rated Teachers</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($topTeachers as $teacher)
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm text-center">
                        <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl mx-auto mb-3">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                        <h3 class="font-medium text-gray-900 text-sm truncate" title="{{ $teacher->name }}">{{ $teacher->name }}</h3>
                        <div class="mt-2 flex items-center justify-center gap-1">
                            <span class="text-amber-500 font-bold">{{ number_format($teacher->avg_rating, 1) }}</span>
                            <span class="text-amber-400 text-xs mt-0.5">★</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $teacher->total_reviews }} reviews</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden text-gray-800">
            <!-- Filter Bar -->
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('admin.evaluations.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
                    <label for="teacher_id" class="text-sm font-medium text-gray-700">Filter by Teacher:</label>
                    <select name="teacher_id" id="teacher_id" class="border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="">All Teachers</option>
                        @foreach($teachersWithEvaluations as $t)
                            <option value="{{ $t->id }}" {{ request('teacher_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    @if(request('teacher_id'))
                        <a href="{{ route('admin.evaluations.index') }}" class="text-sm text-red-600 hover:text-red-800 font-medium">Clear</a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Teacher</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Student</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Rating</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Comment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($evaluations as $evaluation)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $evaluation->created_at->format('M d, Y h:ia') }}
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-900 font-medium whitespace-nowrap">
                                    {{ $evaluation->teacher->name }}
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $evaluation->student->name }}
                                </td>
                                <td class="py-4 px-6 text-sm whitespace-nowrap">
                                    <div class="flex text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $evaluation->rating)
                                                ★
                                            @else
                                                <span class="text-gray-200">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-600 min-w-[300px]">
                                    @if($evaluation->comment)
                                        {{ $evaluation->comment }}
                                    @else
                                        <span class="text-gray-400 italic">No comment provided</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-gray-500">
                                    No evaluations found matching the current filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100">
                {{ $evaluations->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
