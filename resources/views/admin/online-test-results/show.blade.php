@extends('layouts.admin')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Hasil Test') }}
    </h2>
    <a href="{{ route('admin.online-test-results.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mb-4 flex justify-between items-center">
        <button onclick="history.back()" type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back
        </button>
        <a href="{{ route('admin.online-test-results.certificate', $result->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 text-sm font-medium shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Lihat Sertifikat
        </a>
    </div>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Taker Info Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                <h3 class="text-white font-bold text-lg">Informasi Test Taker</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nama</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->taker->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Email</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->taker->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Candidate ID</p>
                        <p class="text-base font-mono font-semibold text-gray-900">{{ $result->taker->candidate_id ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Test Type</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->taker->test_type ?? '-' }}</p>
                    </div>
                    @if($result->taker->date_of_birth)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal Lahir</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->taker->date_of_birth->format('d M Y') }}</p>
                    </div>
                    @endif
                    @if($result->taker->sex)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Jenis Kelamin</p>
                        <p class="text-base font-semibold text-gray-900">{{ ucfirst($result->taker->sex) }}</p>
                    </div>
                    @endif
                    @if($result->taker->country_of_origin)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Country of Origin</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->taker->country_of_origin }}</p>
                    </div>
                    @endif
                    @if($result->taker->first_language)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">First Language</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->taker->first_language }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Test Result Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-4">
                <h3 class="text-white font-bold text-lg">Hasil Test</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Test</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->test_label }}</p>
                    </div>
                                        <div x-data="{
                        status: '{{ $result->status ?? 'not_started' }}',
                        loading: false,
                        async updateStatus(newStatus) {
                            this.loading = true;
                            try {
                                const res = await fetch('{{ route('admin.online-test-results.update-status', $result->id ?? 0) }}', {
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
                        <p class="text-xs text-gray-500 mb-1">Status</p>
                        <div class="relative inline-block">
                            <select x-model="status" @change="updateStatus($event.target.value)" :disabled="loading"
                                class="text-sm font-semibold rounded-full border border-gray-200 pl-4 pr-8 py-1 focus:ring-0 cursor-pointer appearance-none transition-colors"
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
                            <svg x-show="loading" class="absolute right-3 top-2 w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Score</p>
                        @if($result->score !== null)
                            <p class="text-2xl font-bold text-indigo-700">{{ number_format($result->score, 1) }}</p>
                        @else
                            <p class="text-base text-gray-400">Belum tersedia</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Duration</p>
                        @if($result->time_spent_seconds)
                            <p class="text-base font-semibold text-gray-900">{{ gmdate('H:i:s', $result->time_spent_seconds) }}</p>
                        @else
                            <p class="text-base text-gray-400">—</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Started At</p>
                        <p class="text-base font-semibold text-gray-900">
                            {{ $result->started_at ? $result->started_at->format('d M Y, H:i') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Completed At</p>
                        <p class="text-base font-semibold text-gray-900">
                            {{ $result->completed_at ? $result->completed_at->format('d M Y, H:i') : '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Evaluation Data --}}
        @if($result->evaluation_data && count($result->evaluation_data) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-teal-700 px-6 py-4">
                <h3 class="text-white font-bold text-lg">Evaluation Data</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach(array_keys($result->evaluation_data) as $key)
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($result->evaluation_data as $value)
                                    <td class="px-4 py-2 font-medium text-gray-900">
                                        @if(is_array($value))
                                            <pre class="text-xs bg-gray-50 p-2 rounded">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        {{-- Answers Data --}}
        @if($result->answers_data && count($result->answers_data) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-600 to-orange-700 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-lg">Answers Data</h3>
                <span class="text-white/80 text-sm">{{ count($result->answers_data) }} answers</span>
            </div>
            <div class="p-6">
                <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-x-auto max-h-96 overflow-y-auto">{{ json_encode($result->answers_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
