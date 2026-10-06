@extends('layouts.admin')

@section('header')
<div class="flex justify-between items-center" x-data>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Final Tests Results') }}
        </h2>
        <p class="text-xs text-gray-500 mt-0.5">Hasil ujian akhir dan penerbitan sertifikat siswa</p>
    </div>
    <button type="button" @click="$dispatch('open-manual-certificate-modal')" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Terbitkan Sertifikat Manual
    </button>
</div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Stats Cards (same layout as online results) --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['takers'] }}</p>
                        <p class="text-xs text-gray-500">Test Takers</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
            <form method="GET" action="{{ route('admin.final-test-results.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau ID kandidat..."
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-48">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Test Type</label>
                    <select name="test_type" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        @foreach($testTypes as $type)
                            <option value="{{ $type->test_slug }}" {{ request('test_type') === $type->test_slug ? 'selected' : '' }}>
                                {{ $type->test_label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-40">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'test_type', 'status']))
                    <a href="{{ route('admin.final-test-results.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Results Table (simplified, mirrors Online Test Results) --}}
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Taker</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidate ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($results as $result)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ optional($result->created_at)->format ? $result->created_at->format('d M Y') : '-' }}
                                    <div class="text-xs text-gray-400">{{ optional($result->created_at)->format ? $result->created_at->format('H:i') : '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($result->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.final-test-results.show', $result->id ?? $result->ID ?? 0) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 hover:underline">{{ $result->name ?? '-' }}</a>
                                            <div class="text-xs text-gray-500">{{ $result->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                        {{ $result->candidate_id ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $result->test_label ?? ($result->test_type ?? '-') }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap" x-data="{
                                    status: '{{ $result->status ?? 'not_started' }}',
                                    loading: false,
                                    async updateStatus(newStatus) {
                                        this.loading = true;
                                        try {
                                            const res = await fetch('{{ route('admin.final-test-results.update-status', $result->id ?? $result->ID ?? 0) }}', {
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

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($result->test_type) && strtolower($result->test_type) === 'toefl_itp' && isset($result->answers_data))
                                        @php
                                            $converter = app(\App\Domain\ToeflMockup\ToeflScoreConverter::class);
                                            $rawL = $result->answers_data['listening'] ?? 0;
                                            $rawS = $result->answers_data['structure'] ?? 0;
                                            $rawR = $result->answers_data['reading'] ?? 0;
                                            $scL = $converter->convert('listening', $rawL);
                                            $scS = $converter->convert('structure', $rawS);
                                            $scR = $converter->convert('reading', $rawR);
                                            $scT = is_numeric($result->score) ? number_format($result->score, 0) : $result->score;
                                        @endphp
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 rounded-lg border border-gray-100">
                                            <span class="text-xs font-medium text-gray-500 tracking-wider">L/S/R/TOEFL</span>
                                            <span class="text-xs text-gray-300">|</span>
                                            <span class="text-xs font-bold text-gray-900">
                                                {{ $scL }}<span class="text-gray-400 font-normal">/</span>{{ $scS }}<span class="text-gray-400 font-normal">/</span>{{ $scR }}<span class="text-gray-400 font-normal">/</span><span class="text-indigo-700">{{ $scT }}</span>
                                            </span>
                                        </div>
                                    @elseif(isset($result->test_type) && str_starts_with(strtolower($result->test_type), 'ielts'))
                                        @php
                                            $ev = is_array($result->evaluation_data) ? $result->evaluation_data : [];
                                            $ans = is_array($result->answers_data) ? $result->answers_data : [];
                                            $scL = $ev['listening'] ?? $ans['listening'] ?? '-';
                                            $scR = $ev['reading'] ?? $ans['reading'] ?? '-';
                                            $scW = $ev['writing'] ?? $ans['writing'] ?? '-';
                                            $scS = $ev['speaking'] ?? $ans['speaking'] ?? '-';
                                            $scT = is_numeric($result->score) ? number_format($result->score, 1) : $result->score;
                                        @endphp
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 rounded-lg border border-gray-100">
                                            <span class="text-xs font-medium text-gray-500 tracking-wider">L/R/W/S/IELTS</span>
                                            <span class="text-xs text-gray-300">|</span>
                                            <span class="text-xs font-bold text-gray-900">
                                                {{ $scL }}<span class="text-gray-400 font-normal">/</span>{{ $scR }}<span class="text-gray-400 font-normal">/</span>{{ $scW }}<span class="text-gray-400 font-normal">/</span>{{ $scS }}<span class="text-gray-400 font-normal">/</span><span class="text-indigo-700">{{ $scT ?? '-' }}</span>
                                            </span>
                                        </div>
                                    @else
                                        @if(isset($result->score) && $result->score !== null)
                                            <span class="text-sm font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg">
                                                {{ is_numeric($result->score) ? number_format($result->score, 1) : $result->score }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($result->time_spent_seconds ?? false)
                                        {{ gmdate('H:i:s', $result->time_spent_seconds) }}
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.final-test-results.show', $result->id ?? $result->ID ?? 0) }}" class="inline-flex items-center gap-1 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-sm text-gray-500">Belum ada data hasil final test.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($results->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $results->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@include('components.manual-certificate-modal')
@endsection
