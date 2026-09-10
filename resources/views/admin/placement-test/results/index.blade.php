@extends('layouts.admin')

@section('title', 'Hasil Tes Kompetensi')

@section('content')
<div class="p-6 sm:p-8" x-data="{ viewRawJson: null }">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">{{ __('Hasil Tes Kompetensi') }}</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar peserta dan rincian lengkap hasil penilaian tes kompetensi (Reading, Listening, Writing, Speaking, CEFR & AI Evaluation).</p>
    </div>

    {{-- Stats Grid (Matching Lead Tracker) --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-xs font-bold uppercase tracking-wider text-gray-500 truncate">Total Peserta Tes</dt>
                <dd class="mt-1 text-2xl sm:text-3xl font-black text-gray-900">{{ $totalResults ?? 0 }}</dd>
            </div>
        </div>
        <div class="bg-green-50 overflow-hidden shadow-sm rounded-xl border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-xs font-bold uppercase tracking-wider text-green-800 truncate">Selesai (Completed)</dt>
                <dd class="mt-1 text-2xl sm:text-3xl font-black text-green-900">{{ $completedResults ?? 0 }}</dd>
            </div>
        </div>
        <div class="bg-yellow-50 overflow-hidden shadow-sm rounded-xl border border-yellow-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-xs font-bold uppercase tracking-wider text-yellow-800 truncate">Sedang Berjalan</dt>
                <dd class="mt-1 text-2xl sm:text-3xl font-black text-yellow-900">{{ $inProgressResults ?? 0 }}</dd>
            </div>
        </div>
        <div class="bg-indigo-50 overflow-hidden shadow-sm rounded-xl border border-indigo-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-xs font-bold uppercase tracking-wider text-indigo-800 truncate">Tingkat Mahir (C1 / C2)</dt>
                <dd class="mt-1 text-2xl sm:text-3xl font-black text-indigo-900">{{ $advancedLevelCount ?? 0 }}</dd>
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 flex flex-wrap gap-4 items-center justify-between">
        <form method="GET" action="{{ route('admin.placement-test.results.index') }}" class="flex flex-wrap gap-3 items-center w-full md:w-auto">
            <div>
                <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs sm:text-sm font-medium">
                    <option value="">All Statuses</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div>
                <select name="cefr_level" class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs sm:text-sm font-medium">
                    <option value="">All Levels</option>
                    @foreach(['A1','A2','B1','B2','C1','C2'] as $lvl)
                        <option value="{{ $lvl }}" {{ request('cefr_level') === $lvl ? 'selected' : '' }}>Level {{ $lvl }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-grow min-w-[220px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau WA..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs sm:text-sm">
            </div>
            <div>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-xs sm:text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition">
                    Filter
                </button>
            </div>
            @if(request('status') || request('cefr_level') || request('search'))
                <div>
                    <a href="{{ route('admin.placement-test.results.index') }}" class="text-xs sm:text-sm text-gray-500 hover:text-gray-700 underline font-medium">Reset</a>
                </div>
            @endif
        </form>
    </div>

    {{-- Main Table (Matching Lead Tracker) --}}
    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-xl">
        @if($results->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Belum ada hasil tes kompetensi</h3>
                <p class="text-xs text-gray-500 mt-1">Data pengerjaan tes kompetensi oleh peserta akan muncul di sini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Peserta</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Paket Tes</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Target & Saran AI</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hasil & CEFR</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Skill Breakdown</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengerjaan & Durasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">AI JSON</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-xs sm:text-sm">
                        @foreach ($results as $result)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                {{-- Date --}}
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($result->created_at)->format('d M Y H:i') }}
                                </td>

                                {{-- Peserta --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $result->user->name ?? '—' }}</div>
                                    <div class="text-xs text-gray-500">{{ $result->user->email ?? '' }}</div>
                                    @if(!empty($result->user->phone_number))
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $result->user->phone_number) }}" target="_blank" class="text-green-600 hover:text-green-800 flex items-center gap-1 font-medium">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.573-.187-.981-.342-1.714-.651-2.836-2.42-2.92-2.532-.084-.112-.697-.927-.697-1.769s.434-1.261.587-1.423c.153-.162.336-.202.448-.202.112 0 .223.004.321.009.106.005.249-.041.385.285.14.337.476 1.161.518 1.246.042.085.069.184.014.296-.055.112-.084.183-.168.283l-.224.225c-.083.085-.171.178-.075.343.097.166.434.717.935 1.166.65.583 1.196.764 1.36.85.165.085.262.069.359-.041.098-.112.422-.493.535-.662.112-.17.223-.142.373-.085.15.056.949.448 1.111.528.161.08.269.121.309.189.039.068.039.395-.105.801z"/></svg>
                                                {{ $result->user->phone_number }}
                                            </a>
                                        </div>
                                    @endif
                                </td>

                                {{-- Paket Tes --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ $result->package->title ?? 'Tes Kompetensi' }}
                                    </span>
                                </td>
                                {{-- Target & Saran AI --}}
                                <td class="px-6 py-4">
                                    <div class="space-y-1 min-w-[200px]">
                                        <div class="flex items-center gap-1.5 text-xs">
                                            <span class="text-gray-400 font-medium shrink-0">Minat:</span>
                                            <span class="font-bold text-blue-900 truncate">{{ $result->target_program_display }}</span>
                                        </div>
                                        <div class="p-2 bg-emerald-50/90 border border-emerald-200/90 rounded-xl text-[11px] text-emerald-900 leading-snug shadow-2xs">
                                            <span class="font-black text-emerald-700 block text-[10px] uppercase tracking-wide">💡 Rekomendasi AI:</span>
                                            <span class="font-bold text-emerald-950">{{ $result->ai_recommended_program_display }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Hasil & CEFR --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($result->overall_percentage !== null)
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-black rounded-lg bg-slate-100 text-slate-900 border border-slate-200">
                                                {{ $result->score_display }}
                                            </span>
                                            @if($result->cefr_level)
                                                <span class="px-2 py-0.5 inline-flex text-[11px] font-extrabold rounded-md {{ $result->cefr_badge_class }}">
                                                    {{ $result->cefr_level }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum Selesai</span>
                                    @endif
                                </td>

                                {{-- Skill Breakdown (R / L / W / S) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="grid grid-cols-2 gap-1 text-[11px]">
                                        <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-800 border border-blue-100 font-semibold" title="Reading">
                                            R: {{ $result->reading_score !== null ? round($result->reading_score) . '%' : '—' }}
                                        </span>
                                        <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-100 font-semibold" title="Listening">
                                            L: {{ $result->listening_score !== null ? round($result->listening_score) . '%' : '—' }}
                                        </span>
                                        <span class="px-1.5 py-0.5 rounded bg-purple-50 text-purple-800 border border-purple-100 font-semibold" title="Writing">
                                            W: {{ $result->writing_score !== null ? round($result->writing_score) . '%' : '—' }}
                                        </span>
                                        <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-100 font-semibold" title="Speaking">
                                            S: {{ $result->speaking_score !== null ? round($result->speaking_score) . '%' : '—' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Pengerjaan & Durasi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-14 bg-gray-200 rounded-full h-1.5 overflow-hidden shrink-0">
                                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $result->completion_percentage }}%"></div>
                                            </div>
                                            <span class="font-bold text-gray-800 text-[11px]">{{ $result->completion_display }}</span>
                                        </div>
                                        <div class="flex items-center gap-1 text-gray-500 font-medium text-[11px]">
                                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ $result->duration_display }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- AI JSON --}}
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    @if(!empty($result->evaluation_data) || !empty($result->answers_data))
                                        @php
                                            $jsonPayload = [
                                                'evaluation' => $result->evaluation_data,
                                                'answers' => $result->answers_data,
                                                'cefr_level' => $result->cefr_level,
                                                'overall_percentage' => $result->overall_percentage,
                                            ];
                                        @endphp
                                        <button type="button" 
                                                data-json="{{ json_encode($jsonPayload) }}" 
                                                @click="viewRawJson = $el.dataset.json" 
                                                class="text-blue-600 hover:text-blue-900 underline font-semibold cursor-pointer">
                                            View JSON
                                        </button>
                                    @else
                                        <span class="text-gray-400 italic">None</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $result->status_badge_class }}">
                                        {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                    <a href="{{ route('admin.placement-test.results.show', $result) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white font-bold rounded-lg border border-blue-200 transition">
                                        Rincian &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($results->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-white">
                    {{ $results->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- JSON Viewer Modal --}}
    <div x-show="viewRawJson" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="viewRawJson" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="viewRawJson = null"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="viewRawJson" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900" id="modal-title">
                                AI Evaluation & Answers JSON
                            </h3>
                            <div class="mt-4">
                                <pre class="bg-gray-800 text-green-400 p-4 rounded-xl overflow-x-auto text-xs font-mono max-h-[60vh]" x-text="
                                    (() => {
                                        let obj = viewRawJson;
                                        let limit = 5;
                                        while (typeof obj === 'string' && limit > 0) {
                                            try {
                                                let parsed = JSON.parse(obj);
                                                if (obj === parsed) break;
                                                obj = parsed;
                                                limit--;
                                            } catch (e) {
                                                break;
                                            }
                                        }
                                        return JSON.stringify(obj, null, 2);
                                    })()
                                "></pre>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                    <button type="button" @click="viewRawJson = null" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs sm:text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
