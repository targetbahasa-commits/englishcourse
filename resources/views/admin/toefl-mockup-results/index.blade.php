@extends('layouts.admin')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('TOEFL Mockup Results') }}
    </h2>
    <div class="flex space-x-2">
        <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">
            Export (PDF/Print)
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Total Results</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-green-50 rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Completed</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-yellow-50 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">In Progress</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-purple-50 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['takers'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Test Takers</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
            <form method="GET" action="{{ route('admin.toefl-mockup-results.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau ID kandidat..."
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-48">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Test Type</label>
                    <select name="test_type" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        @foreach($testTypes ?? [] as $key => $label)
                            <option value="{{ $key }}" {{ request('test_type') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-40">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'test_type', 'status']))
                    <a href="{{ route('admin.toefl-mockup-results.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm flex flex-col sm:rounded-lg">
            
            <div class="p-0 bg-white border-b border-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Package</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scores (L / S / R)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-indigo-600 uppercase tracking-wider">Total TOEFL</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($results as $result)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $result->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.toefl-mockup-results.show', $result->id) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 hover:underline">{{ $result->name }}</a>
                                    <div class="text-sm text-gray-500">{{ $result->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $result->exam_label }}</div>
                                    <div class="text-sm text-gray-500">{{ $result->source_label }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Package {{ $result->package_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" x-data="{
                                    status: '{{ $result->status ?? 'not_started' }}',
                                    loading: false,
                                    async updateStatus(newStatus) {
                                        this.loading = true;
                                        try {
                                            const res = await fetch('{{ route('admin.toefl-mockup-results.update-status', $result->id) }}', {
                                                method: 'PATCH',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json'
                                                },
                                                body: JSON.stringify({ status: newStatus })
                                            });
                                            if(res.ok) {
                                                const data = await res.json();
                                                this.status = data.status;
                                            } else {
                                                alert('Failed to update status');
                                            }
                                        } catch (e) {
                                            alert('Error updating status');
                                        }
                                        this.loading = false;
                                    }
                                }">
                                    <div class="relative inline-block">
                                        <select x-model="status" @change="updateStatus($event.target.value)" :disabled="loading"
                                            class="text-xs font-semibold rounded-full border border-gray-200 pl-3 pr-8 py-1 focus:ring-0 cursor-pointer appearance-none transition-colors"
                                            :class="{
                                                'bg-green-50 text-green-700': status === 'completed',
                                                'bg-yellow-50 text-yellow-700': status === 'in_progress',
                                                'bg-red-50 text-red-700': status === 'abandoned',
                                                'bg-gray-50 text-gray-600': status === 'not_started' || !status
                                            }">
                                            <option value="completed">Completed</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="abandoned">Abandoned</option>
                                            <option value="not_started">Not Started</option>
                                        </select>
                                        <svg x-show="loading" class="absolute right-2 top-1.5 w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    {{ $result->listening_score }} / {{ $result->structure_score }} / {{ $result->reading_score }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-indigo-100 text-indigo-800">
                                        {{ $result->total_score }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.toefl-mockup-results.show', $result->id) }}" class="inline-flex items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-sm font-bold text-indigo-700 transition hover:bg-indigo-100">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-sm text-gray-500">Belum ada data hasil mockup test.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4">
                {{ $results->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
