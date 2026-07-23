@extends('layouts.admin')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Class Evaluations</h1>
            <p class="text-gray-500 mt-1">Monitor all feedback provided by students regarding their classes.</p>
        </div>
        <div class="flex gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-2 flex items-center gap-2">
                <span class="text-sm font-medium text-gray-500">Platform Avg:</span>
                <span class="text-sm font-bold text-gray-900 flex items-center gap-1">
                    0.0
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </span>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-2 flex items-center gap-2">
                <span class="text-sm font-medium text-gray-500">Total Reviews:</span>
                <span class="text-sm font-bold text-blue-600">0</span>
            </div>
        </div>
    </div>

    <!-- Empty State / Placeholder -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="w-full md:w-64">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Filter by Class:</label>
                    <select class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">All Classes</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold">Class</th>
                        <th class="px-6 py-4 font-semibold text-center">Student</th>
                        <th class="px-6 py-4 font-semibold text-center">Rating</th>
                        <th class="px-6 py-4 font-semibold w-1/3">Comment</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No class evaluations found matching the current filters.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
