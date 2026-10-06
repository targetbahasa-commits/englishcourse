@extends('layouts.admin')

@section('title', 'Hasil & Koreksi Grammar Writing')

@section('content')
<div class="p-6 max-w-[1600px] mx-auto">
    <!-- Header Banner -->
    <div class="mb-8 relative overflow-hidden rounded-3xl shadow-lg p-8" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%); color: #ffffff;">
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full -mr-20 -mt-20 blur-2xl"></div>
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <span class="p-3.5 rounded-2xl flex items-center justify-center shrink-0 bg-white/10 backdrop-blur border border-white/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </span>
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight" style="color: #ffffff !important;">Grammar Writing — Hasil & Koreksi</h1>
                    <p class="mt-1 text-sm font-medium text-indigo-200">Daftar pengerjaan Grammar Writing (semua track), nilai otomatis, serta koreksi &amp; catatan pengajar.</p>
                </div>
            </div>

            @if(isset($stats))
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur border border-white/20 p-2.5 rounded-2xl">
                    <div class="px-4 py-1.5 text-center">
                        <div class="text-[10px] uppercase font-bold text-indigo-200">Total</div>
                        <div class="text-xl font-black text-white">{{ $stats['total'] }}</div>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div class="px-4 py-1.5 text-center">
                        <div class="text-[10px] uppercase font-bold text-amber-300">Belum Direview</div>
                        <div class="text-xl font-black text-amber-300">{{ $stats['pending'] }}</div>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div class="px-4 py-1.5 text-center">
                        <div class="text-[10px] uppercase font-bold text-purple-300">Sudah Direview</div>
                        <div class="text-xl font-black text-purple-300">{{ $stats['reviewed'] }}</div>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div class="px-4 py-1.5 text-center">
                        <div class="text-[10px] uppercase font-bold text-orange-300">Sedang Dikerjakan</div>
                        <div class="text-xl font-black text-orange-300">{{ $stats['inProgress'] ?? 0 }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Track Tabs -->
    <div class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm mb-4 flex items-center gap-2 overflow-x-auto">
        @php $currentTrack = $track ?? 'all'; @endphp
        <a href="{{ route('admin.grammar-writing-review.index', array_merge(request()->query(), ['track' => 'all'])) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ $currentTrack === 'all' ? 'bg-slate-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Semua Track
        </a>
        @foreach(\App\Http\Controllers\Admin\AdminGrammarWritingReviewController::TRACKS as $trackKey => $trackInfo)
            <a href="{{ route('admin.grammar-writing-review.index', array_merge(request()->query(), ['track' => $trackKey])) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ $currentTrack === $trackKey ? 'bg-slate-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $trackInfo['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
            @php $currentStatus = $status ?? 'all'; @endphp
            <a href="{{ route('admin.grammar-writing-review.index', array_merge(request()->query(), ['status' => 'all'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('admin.grammar-writing-review.index', array_merge(request()->query(), ['status' => 'pending_review'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'pending_review' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Belum Direview
            </a>
            <a href="{{ route('admin.grammar-writing-review.index', array_merge(request()->query(), ['status' => 'reviewed'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'reviewed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Sudah Direview
            </a>
        </div>

        <!-- Search + Meeting filter -->
        <form method="GET" action="{{ route('admin.grammar-writing-review.index') }}" class="flex items-center gap-2 shrink-0">
            <input type="hidden" name="status" value="{{ $currentStatus }}">
            <input type="hidden" name="track" value="{{ $currentTrack }}">
            <select name="meeting_number" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Meeting</option>
                @for($i = 1; $i <= 20; $i++)
                    <option value="{{ $i }}" {{ (string) request('meeting_number') === (string) $i ? 'selected' : '' }}>Meeting {{ $i }}</option>
                @endfor
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama student / email..."
                   class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-56">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition">Cari</button>
            @if(request('search') || request('meeting_number'))
                <a href="{{ route('admin.grammar-writing-review.index', ['status' => $currentStatus, 'track' => $currentTrack]) }}" class="px-3 py-2 bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl hover:bg-gray-300">Reset</a>
            @endif
        </form>
    </div>

    <!-- In Progress (Not Yet Submitted) -->
    @if($inProgressSubmissions->count() > 0)
    <div x-data="draftViewerWithDrawing()">
    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 mb-6 p-6">
        <div class="flex items-center gap-2 mb-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-500"></span>
            </span>
            <h2 class="text-lg font-bold text-gray-900">Sedang Dikerjakan (Belum Submit)</h2>
        </div>
        <p class="text-sm text-gray-500 mb-5">Student yang sudah mulai mengerjakan tapi belum submit. Progres dihitung dari jumlah jawaban yang sudah terisi, bukan hasil penilaian.</p>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-orange-50 border-b border-orange-100">
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Student</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Track</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Meeting</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Progres</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Terakhir Disimpan</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($inProgressSubmissions as $draft)
                    @php
                        $draftAnswers = is_array($draft->answers) ? $draft->answers : [];
                        $draftTotalCount = count($draftAnswers);
                        $draftFilledCount = collect($draftAnswers)->filter(function ($value) {
                            if (is_array($value)) {
                                // Some meetings' answers nest two levels deep (e.g.
                                // trans_matrix[verb][form] for the Fast-Track/Complexity
                                // Meeting 1 matrix) - flatten before checking so a nested
                                // sub-array never reaches (string) casting directly.
                                return collect($value)->flatten()->contains(fn ($v) => $v !== null && !is_array($v) && trim((string) $v) !== '');
                            }
                            return trim((string) $value) !== '';
                        })->count();
                        $draftQuestions = \App\Http\Controllers\Admin\AdminGrammarWritingReviewController::resolveQuestionsForMeeting(
                            $draft->program->slug ?? '',
                            (int) $draft->meeting_number
                        );
                    @endphp
                    <tr class="hover:bg-orange-50/50 transition">
                        <td class="p-4">
                            <p class="font-semibold text-gray-900">{{ $draft->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $draft->user->email ?? '' }}</p>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                {{ $trackLabelsBySlug[$draft->program->slug ?? ''] ?? ($draft->program->name ?? '—') }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                Meeting {{ $draft->meeting_number }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($draftTotalCount > 0)
                                <div class="flex items-center gap-2">
                                    <div class="w-20 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-orange-500 rounded-full" style="width: {{ round(($draftFilledCount / $draftTotalCount) * 100) }}%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">{{ $draftFilledCount }}/{{ $draftTotalCount }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-600">{{ $draft->last_saved_at?->diffForHumans() }}</p>
                        </td>
                        <td class="p-4">
                            <button type="button"
                                @click="viewingDraft = { id: @js($draft->id), user_id: @js($draft->user_id), program_id: @js($draft->program_id), meeting_number: @js($draft->meeting_number), name: @js($draft->user->name ?? 'N/A'), email: @js($draft->user->email ?? ''), meta: @js(($trackLabelsBySlug[$draft->program->slug ?? ''] ?? ($draft->program->name ?? '')) . ' · Meeting ' . $draft->meeting_number), savedAt: @js($draft->last_saved_at?->diffForHumans()), answers: @js($draftAnswers), questions: @js($draftQuestions) }"
                                class="text-xs font-semibold text-blue-600 hover:text-blue-800 cursor-pointer">
                                Lihat Jawaban
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('admin.partials.draft-drawing-modal')
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($scores->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="font-bold text-gray-700">Tidak ada submission yang ditemukan.</p>
                <p class="text-xs text-gray-400 mt-1">Coba ganti filter atau kata kunci pencarian.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-200">
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Student</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Track</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-center">Meeting</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-center">Skor Auto</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-center">Nilai Guru</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Waktu Submit</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($scores as $meetingScore)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-4 align-top">
                                    <div class="font-bold text-gray-900 text-sm">{{ $meetingScore->user->name ?? 'Unknown Student' }}</div>
                                    <div class="text-xs text-gray-500">{{ $meetingScore->user->email ?? '' }}</div>
                                </td>

                                <td class="p-4 align-top">
                                    @php
                                        $rowTrackLabel = collect(\App\Http\Controllers\Admin\AdminGrammarWritingReviewController::TRACKS)->firstWhere('slug', $meetingScore->program->slug ?? null)['label'] ?? '-';
                                    @endphp
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-700">
                                        {{ $rowTrackLabel }}
                                    </span>
                                </td>

                                <td class="p-4 align-top text-center">
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-teal-100 text-teal-800">
                                        Meeting {{ $meetingScore->meeting_number }}
                                    </span>
                                    @if(!$meetingScore->is_reported)
                                        <div class="text-[10px] text-gray-400 mt-1">Practice Mode</div>
                                    @endif
                                </td>

                                <td class="p-4 align-top text-center">
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-sm font-extrabold bg-amber-100 text-amber-900 border border-amber-200">
                                        {{ $meetingScore->score }}
                                    </span>
                                </td>

                                <td class="p-4 align-top text-center">
                                    @if($meetingScore->teacher_score !== null)
                                        <span class="inline-block px-2.5 py-1 rounded-lg text-sm font-extrabold bg-purple-100 text-purple-900 border border-purple-200">
                                            {{ number_format($meetingScore->teacher_score, 1) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">—</span>
                                    @endif
                                </td>

                                <td class="p-4 align-top">
                                    @if($meetingScore->reviewed_at)
                                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-800">
                                            ✓ Reviewed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2 py-0.5 rounded bg-gray-100 text-gray-600">
                                            Belum Review
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 align-top text-xs text-gray-500">
                                    {{ $meetingScore->submitted_at ? $meetingScore->submitted_at->format('d M Y H:i') : '-' }}
                                </td>

                                <td class="p-4 align-top text-right">
                                    <a href="{{ route('admin.grammar-writing-review.show', $meetingScore->id) }}" target="_blank"
                                       class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors inline-flex items-center gap-1 shadow-sm">
                                        <span>Periksa</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $scores->links() }}
            </div>
        @endif
    </div>
</div>

@include('admin.partials.draft-drawing-script')
@endsection
