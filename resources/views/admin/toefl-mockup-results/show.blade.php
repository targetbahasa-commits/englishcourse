@extends('layouts.admin')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('TOEFL Mockup Result Detail') }}</h2>
        <p class="text-sm text-gray-500">Detail hasil soal, jawaban, dan nilai.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.toefl-mockup-results.certificate', $result->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Lihat Sertifikat
        </a>
        <a href="{{ route('admin.toefl-mockup-results.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5">
                <h3 class="text-white font-bold text-lg">Detail Hasil Mockup TOEFL</h3>
            </div>
            <div class="p-6 grid gap-6 md:grid-cols-2">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-[0.2em] mb-1">Nama Siswa</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $result->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-[0.2em] mb-1">Email</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $result->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-[0.2em] mb-1">Jenis Ujian</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $result->exam_label }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-[0.2em] mb-1">Package</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $result->package_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-[0.2em] mb-1">Sumber</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $result->source_label }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-[0.2em] mb-1">Disubmit oleh</p>
                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst($result->submitted_by_role ?? 'user') }}</p>
                </div>
                <div x-data="{
                    status: '{{ $result->status ?? 'not_started' }}',
                    loading: false,
                    async updateStatus(newStatus) {
                        this.loading = true;
                        try {
                            const res = await fetch('{{ route('admin.toefl-mockup-results.update-status', $result->id ?? 0) }}', {
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
                    <p class="text-xs text-gray-500 uppercase tracking-[0.2em] mb-1">Status</p>
                    <div class="relative inline-block mt-0.5">
                        <select x-model="status" @change="updateStatus($event.target.value)" :disabled="loading"
                            class="text-sm font-semibold rounded-full border border-gray-200 pl-4 pr-8 py-1.5 focus:ring-0 cursor-pointer appearance-none transition-colors"
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
                        <svg x-show="loading" class="absolute right-3 top-2.5 w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs text-gray-500 uppercase tracking-[0.18em]">Listening</p>
                <p class="mt-4 text-4xl font-black text-blue-700">{{ $result->listening_score ?? '—' }}</p>
                <p class="mt-2 text-sm text-gray-500">Benar: {{ $result->listening_correct ?? 0 }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs text-gray-500 uppercase tracking-[0.18em]">Structure</p>
                <p class="mt-4 text-4xl font-black text-indigo-700">{{ $result->structure_score ?? '—' }}</p>
                <p class="mt-2 text-sm text-gray-500">Benar: {{ $result->structure_correct ?? 0 }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs text-gray-500 uppercase tracking-[0.18em]">Reading</p>
                <p class="mt-4 text-4xl font-black text-emerald-700">{{ $result->reading_score ?? '—' }}</p>
                <p class="mt-2 text-sm text-gray-500">Benar: {{ $result->reading_correct ?? 0 }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs text-gray-500 uppercase tracking-[0.18em]">Total Score</p>
                <p class="mt-4 text-5xl font-black text-indigo-600">{{ $result->total_score ?? '—' }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ optional($result->completed_at)->format('d M Y H:i') ?? optional($result->created_at)->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Rangkuman Hasil</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-[0.16em] mb-1">Score Listening</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->listening_score ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-[0.16em] mb-1">Score Structure</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->structure_score ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-[0.16em] mb-1">Score Reading</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->reading_score ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-[0.16em] mb-1">Total Skor</p>
                        <p class="text-base font-semibold text-gray-900">{{ $result->total_score ?? '—' }}</p>
                    </div>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-gray-600">Raw scores dan payload yang tersedia dari hasil mockup.</p>
                </div>
            </div>
        </div>

        @if(!empty($result->answers_data) || !empty($result->result_payload))
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Detail Data Jawaban</h3>
            </div>
            <div class="p-6 space-y-4">
                @if(!empty($result->result_payload))
                <div>
                    <p class="text-sm text-gray-500 mb-2">Result payload:</p>
                    <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-x-auto">{{ json_encode($result->result_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
                @endif

                @if(!empty($result->answers_data))
                <div>
                    <p class="text-sm text-gray-500 mb-2">Answer payload:</p>
                    <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-x-auto">{{ json_encode($result->answers_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
