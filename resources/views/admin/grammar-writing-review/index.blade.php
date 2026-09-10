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
                                return collect($value)->contains(fn ($v) => trim((string) $v) !== '');
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

    <!-- Draft Answers Modal with Coret-Coret (Annotation/Drawing) Feature -->
    <div x-show="viewingDraft" x-cloak @keydown.escape.window="closeDraft()" @click.self="closeDraft()"
         class="fixed inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center z-50 p-3 sm:p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col overflow-hidden border border-gray-100" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 pb-4 border-b border-gray-100 bg-slate-50/70 shrink-0 gap-3">
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900 leading-tight" x-text="viewingDraft?.name"></h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-orange-100 text-orange-800" x-text="viewingDraft?.meta"></span>
                        <span class="text-xs text-gray-400">&bull;</span>
                        <span class="text-xs text-gray-500 font-medium" x-text="'Tersimpan ' + viewingDraft?.savedAt"></span>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <!-- Download PDF Button -->
                    <button type="button" @click="exportAndDownloadPdf()" 
                            :disabled="isExportingPdf"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition shadow-xs cursor-pointer select-none disabled:opacity-50">
                        <svg x-show="!isExportingPdf" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M7 10l5 5 5-5M12 15V3"></path>
                        </svg>
                        <svg x-show="isExportingPdf" class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"></path>
                        </svg>
                        <span x-text="isExportingPdf ? 'Membuat...' : 'Unduh PDF'"></span>
                    </button>

                    <!-- Save for Student Button -->
                    <button type="button" @click="saveEvaluationForStudent()" 
                            :disabled="isSavingForStudent"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-xs cursor-pointer select-none disabled:opacity-50">
                        <svg x-show="!isSavingForStudent" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        <svg x-show="isSavingForStudent" class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"></path>
                        </svg>
                        <span x-text="isSavingForStudent ? 'Menyimpan...' : 'Simpan Coretan'"></span>
                    </button>

                    <!-- Toggle Coret-Coret Button -->
                    <button type="button" @click="toggleDrawingMode()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-xs cursor-pointer select-none"
                            :class="drawingMode ? 'bg-rose-600 text-white hover:bg-rose-700 ring-2 ring-rose-300' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-rose-600'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <span x-text="drawingMode ? 'Selesai Coret' : '✏️ Coret-Coret'"></span>
                    </button>

                    <!-- Close Modal Button -->
                    <button type="button" @click="closeDraft()" class="w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-700 hover:bg-gray-100 flex items-center justify-center transition shrink-0 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Coret-Coret Toolbar (Visible only when drawingMode is true) -->
            <!-- Coret-Coret Toolbar (Visible only when drawingMode is true) -->
            <div x-show="drawingMode" x-transition class="bg-slate-900 text-white px-4 py-2.5 flex items-center justify-between gap-3 text-xs shrink-0 flex-wrap shadow-inner border-b border-slate-800 select-none">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <!-- Tool Selection -->
                    <div class="inline-flex bg-slate-800 p-0.5 rounded-lg border border-slate-700">
                        <button type="button" @click="activeTool = 'pen'" 
                                class="px-2.5 py-1 rounded-md font-semibold transition flex items-center gap-1 cursor-pointer"
                                :class="activeTool === 'pen' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-300 hover:text-white'">
                            ✏️ Pulpen
                        </button>
                        <button type="button" @click="activeTool = 'highlighter'" 
                                class="px-2.5 py-1 rounded-md font-semibold transition flex items-center gap-1 cursor-pointer"
                                :class="activeTool === 'highlighter' ? 'bg-amber-500 text-slate-950 shadow-xs' : 'text-slate-300 hover:text-white'">
                            🖍️ Stabilo
                        </button>
                        <button type="button" @click="activeTool = 'text'" 
                                class="px-2.5 py-1 rounded-md font-semibold transition flex items-center gap-1 cursor-pointer"
                                :class="activeTool === 'text' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-300 hover:text-white'">
                            🔤 Teks
                        </button>
                        <button type="button" @click="activeTool = 'eraser'" 
                                class="px-2.5 py-1 rounded-md font-semibold transition flex items-center gap-1 cursor-pointer"
                                :class="activeTool === 'eraser' ? 'bg-slate-600 text-white shadow-xs' : 'text-slate-300 hover:text-white'">
                            🧹 Penghapus
                        </button>
                    </div>

                    <!-- Color Palette -->
                    <div x-show="activeTool !== 'eraser'" class="flex items-center gap-1.5 pl-2 border-l border-slate-700">
                        <template x-for="color in ['#ef4444', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#111827']" :key="color">
                            <button type="button" @click="activeColor = color"
                                    class="w-5 h-5 rounded-full transition transform hover:scale-110 flex items-center justify-center cursor-pointer"
                                    :style="'background-color: ' + color"
                                    :class="activeColor === color ? 'ring-2 ring-white ring-offset-1 ring-offset-slate-900 scale-110' : 'opacity-75 hover:opacity-100'">
                            </button>
                        </template>
                    </div>

                    <!-- Size / Thickness / Font Size -->
                    <div x-show="activeTool !== 'text'" class="flex items-center gap-1 pl-2 border-l border-slate-700">
                        <button type="button" @click="activeSize = 2" class="px-2 py-0.5 rounded text-[11px] font-semibold cursor-pointer" :class="activeSize === 2 ? 'bg-slate-700 text-white' : 'text-slate-400 hover:text-slate-200'">Tipis</button>
                        <button type="button" @click="activeSize = 4" class="px-2 py-0.5 rounded text-[11px] font-semibold cursor-pointer" :class="activeSize === 4 ? 'bg-slate-700 text-white' : 'text-slate-400 hover:text-slate-200'">Sedang</button>
                        <button type="button" @click="activeSize = 8" class="px-2 py-0.5 rounded text-[11px] font-semibold cursor-pointer" :class="activeSize === 8 ? 'bg-slate-700 text-white' : 'text-slate-400 hover:text-slate-200'">Tebal</button>
                    </div>

                    <div x-show="activeTool === 'text'" class="flex items-center gap-1 pl-2 border-l border-slate-700">
                        <span class="text-[10px] text-slate-400 font-bold uppercase mr-1">Ukuran:</span>
                        <button type="button" @click="activeFontSize = 12" class="px-2 py-0.5 rounded text-[11px] font-semibold cursor-pointer" :class="activeFontSize === 12 ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'">12px</button>
                        <button type="button" @click="activeFontSize = 14" class="px-2 py-0.5 rounded text-[11px] font-semibold cursor-pointer" :class="activeFontSize === 14 ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'">14px</button>
                        <button type="button" @click="activeFontSize = 16" class="px-2 py-0.5 rounded text-[11px] font-semibold cursor-pointer" :class="activeFontSize === 16 ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'">16px</button>
                        <button type="button" @click="activeFontSize = 18" class="px-2 py-0.5 rounded text-[11px] font-semibold cursor-pointer" :class="activeFontSize === 18 ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'">18px</button>
                    </div>

                    <span x-show="activeTool === 'text'" class="text-[11px] text-amber-300 font-medium ml-2">
                        💡 Klik pada lembar kerja untuk membuat kotak teks
                    </span>
                </div>

                <!-- Undo & Clear Actions -->
                <div class="flex items-center gap-2">
                    <button type="button" @click="undo()" title="Undo coretan" class="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-lg border border-slate-700 font-medium flex items-center gap-1 transition cursor-pointer">
                        ↩️ Undo
                    </button>
                    <button type="button" @click="clearCanvas()" title="Hapus Semua Coretan" class="px-2.5 py-1 bg-rose-950 hover:bg-rose-900 text-rose-300 rounded-lg border border-rose-800 font-medium flex items-center gap-1 transition cursor-pointer">
                        🗑️ Bersihkan
                    </button>
                </div>
            </div>

            <!-- Modal Scroll Container with Canvas Overlay -->
            <div id="draft-modal-scroll" class="p-6 overflow-y-auto max-h-[calc(90vh-140px)] relative">
                <div id="draft-modal-canvas-wrapper" class="relative space-y-4">
                    <!-- HTML5 Drawing Canvas Layer -->
                    <canvas id="draft-drawing-canvas" 
                            class="absolute inset-0 z-20 touch-none"
                            :class="drawingMode ? (activeTool === 'text' ? 'pointer-events-auto cursor-text' : 'pointer-events-auto cursor-crosshair') : 'pointer-events-none'"
                            @pointerdown="startDrawing($event)"
                            @pointermove="draw($event)"
                            @pointerup="stopDrawing()"
                            @pointercancel="stopDrawing()"
                            @pointerleave="stopDrawing()">
                    </canvas>

                    <!-- Floating Text Boxes Layer -->
                    <template x-for="(tb, tbIndex) in textBoxes" :key="tb.id">
                        <div class="absolute z-30 shadow-lg rounded-xl border p-2 flex flex-col gap-1 transition-all bg-white"
                             :style="`top: ${tb.top}px; left: ${tb.left}px; min-width: 180px; max-width: 340px; background-color: ${getTextBg(tb.color)}; border-color: ${tb.color};`"
                             @click.stop>
                            <div class="flex items-center justify-between gap-2 border-b pb-1 text-[10px] select-none cursor-move opacity-80 hover:opacity-100"
                                 :style="`border-color: ${tb.color}40; color: ${tb.color};`"
                                 @mousedown="startDragTextBox($event, tbIndex)">
                                <span class="font-bold uppercase flex items-center gap-1">
                                    📝 Catatan Teks
                                </span>
                                <button type="button" @click.stop="removeTextBox(tbIndex)" title="Hapus kotak teks" class="hover:text-red-600 font-black px-1 rounded cursor-pointer transition text-xs">✕</button>
                            </div>
                            <textarea x-model="tb.text" 
                                      rows="2" 
                                      placeholder="Ketik catatan evaluasi di sini..." 
                                      class="w-full bg-transparent resize-y font-semibold border-0 focus:ring-0 p-1 leading-relaxed focus:outline-none placeholder-gray-400"
                                      :style="`color: ${tb.color}; font-size: ${tb.fontSize || '14px'};`"></textarea>
                        </div>
                    </template>

                    <!-- Question Cards Loop -->
                    <template x-for="(value, key) in (viewingDraft?.answers || {})" :key="key">
                        <div class="border border-gray-200/90 rounded-2xl p-4 bg-gray-50/70 hover:bg-gray-50 transition space-y-2.5 relative z-10">
                            <!-- Item Header / Question Number -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-800"
                                          x-text="key === 'paragraph_answer' || key === 'userParagraphAnswer' ? 'Latihan Paragraf' : (isNaN(key) ? key : 'Soal ' + key)">
                                    </span>
                                </div>
                            </div>

                            <!-- Isi Soal (Warna Merah) -->
                            <template x-if="(viewingDraft?.questions && viewingDraft?.questions[key]) || (typeof value === 'object' && value !== null && (value.question || value.question_text))">
                                <div class="bg-red-50 border border-red-200 rounded-xl p-3">
                                    <span class="text-[10px] font-bold text-red-500 uppercase tracking-wider block mb-1">Soal:</span>
                                    <p class="text-sm font-bold text-red-600 leading-relaxed whitespace-pre-wrap" x-text="(viewingDraft?.questions && viewingDraft?.questions[key]) || value.question || value.question_text"></p>
                                </div>
                            </template>

                            <!-- Case 1: Value is an Object (e.g. {tense: '...', trans: '...'}) -->
                            <template x-if="typeof value === 'object' && value !== null && !Array.isArray(value)">
                                <div class="space-y-2.5">
                                    <!-- Tense if present -->
                                    <template x-if="value.tense">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-semibold text-gray-500 uppercase">Tense:</span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/80" x-text="value.tense"></span>
                                        </div>
                                    </template>

                                    <!-- Translation / Answer if present -->
                                    <template x-if="(value.trans !== undefined && value.trans !== null && value.trans !== '') || (value.answer !== undefined && value.answer !== null && value.answer !== '') || (value.user_answer !== undefined && value.user_answer !== null && value.user_answer !== '')">
                                        <div>
                                            <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Terjemahan / Jawaban:</span>
                                            <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed" 
                                                 x-text="value.trans || value.answer || value.user_answer">
                                            </div>
                                        </div>
                                    </template>

                                    <!-- If both tense and trans are empty -->
                                    <template x-if="!value.tense && !value.trans && !value.answer && !value.user_answer && !value.v2 && !value.v3">
                                        <div class="py-1">
                                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-400 font-medium italic">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Belum diisi oleh siswa
                                            </span>
                                        </div>
                                    </template>

                                    <!-- Verb Forms (v2 / v3) if present -->
                                    <template x-if="value.v2 || value.v3">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                                            <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                                <span class="text-[10px] font-bold text-gray-400 block uppercase mb-0.5">V2 (Simple Past)</span>
                                                <span class="text-sm font-bold text-gray-800" x-text="value.v2 || '—'"></span>
                                            </div>
                                            <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                                <span class="text-[10px] font-bold text-gray-400 block uppercase mb-0.5">V3 (Past Participle)</span>
                                                <span class="text-sm font-bold text-gray-800" x-text="value.v3 || '—'"></span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Generic Fallback for other Object properties (e.g. tenses, trans_matrix) -->
                                    <template x-for="(subVal, subKey) in value" :key="subKey">
                                        <template x-if="!['tense', 'trans', 'answer', 'user_answer', 'v2', 'v3'].includes(subKey)">
                                            <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                                <span class="text-xs font-bold text-gray-500 uppercase block mb-1" x-text="subKey.replace(/_/g, ' ')"></span>
                                                <div class="text-sm leading-relaxed" 
                                                     :class="(subVal === null || subVal === '' || subVal === undefined) ? 'text-gray-400 italic' : 'text-gray-900 font-medium whitespace-pre-wrap'"
                                                     x-text="(subVal === null || subVal === '' || subVal === undefined) ? '(Belum diisi oleh siswa)' : (typeof subVal === 'object' ? JSON.stringify(subVal, null, 2) : subVal)">
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                </div>
                            </template>

                            <!-- Case 2: Value is a Plain String / Primitive -->
                            <template x-if="typeof value !== 'object' || value === null">
                                <div class="text-sm p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed"
                                     :class="(value === null || value === '' || value === undefined) ? 'bg-gray-50 text-gray-400 italic' : 'bg-white text-gray-900 font-medium'"
                                     x-text="(value === null || value === '' || value === undefined) ? '(Belum diisi oleh siswa)' : value">
                                </div>
                            </template>

                            <!-- Case 3: Value is an Array -->
                            <template x-if="Array.isArray(value)">
                                <div class="space-y-2">
                                    <template x-for="(item, idx) in value" :key="idx">
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs text-sm text-gray-800 flex items-start gap-2.5">
                                            <span class="text-xs font-bold text-gray-400 shrink-0" x-text="(idx + 1) + '.'"></span>
                                            <span class="font-medium" x-text="typeof item === 'object' ? JSON.stringify(item) : (item || '(kosong)')"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>

                    <p x-show="!viewingDraft?.answers || Object.keys(viewingDraft.answers).length === 0" class="text-sm text-gray-400 text-center py-8">
                        Belum ada jawaban tersimpan.
                    </p>
                </div>
            </div>
        </div>
    </div>
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

<script>
function draftViewerWithDrawing() {
    return {
        viewingDraft: null,
        drawingMode: false,
        activeTool: 'pen', // 'pen' | 'highlighter' | 'text' | 'eraser'
        activeColor: '#ef4444',
        activeSize: 3,
        activeFontSize: 14,
        textBoxes: [],
        history: [],
        isDrawing: false,
        lastX: 0,
        lastY: 0,

        closeDraft() {
            this.viewingDraft = null;
            this.drawingMode = false;
            this.history = [];
            this.textBoxes = [];
        },

        toggleDrawingMode() {
            this.drawingMode = !this.drawingMode;
            if (this.drawingMode) {
                this.initCanvas();
            }
        },

        initCanvas() {
            this.$nextTick(() => {
                setTimeout(() => {
                    const canvas = document.getElementById('draft-drawing-canvas');
                    const wrapper = document.getElementById('draft-modal-canvas-wrapper');
                    if (!canvas || !wrapper) return;

                    const dpr = window.devicePixelRatio || 1;
                    const width = wrapper.offsetWidth || 600;
                    const height = Math.max(wrapper.scrollHeight, wrapper.offsetHeight, 400);

                    let prevData = null;
                    if (canvas.width > 0 && canvas.height > 0) {
                        try {
                            prevData = canvas.toDataURL();
                        } catch (e) {}
                    }

                    canvas.width = width * dpr;
                    canvas.height = height * dpr;
                    canvas.style.width = width + 'px';
                    canvas.style.height = height + 'px';

                    const ctx = canvas.getContext('2d');
                    ctx.scale(dpr, dpr);
                    ctx.lineCap = 'round';
                    ctx.lineJoin = 'round';

                    if (prevData) {
                        const img = new Image();
                        img.onload = () => {
                            ctx.drawImage(img, 0, 0, width, height);
                        };
                        img.src = prevData;
                    } else if (this.history.length === 0) {
                        this.history.push(canvas.toDataURL());
                    }
                }, 100);
            });
        },

        saveState() {
            const canvas = document.getElementById('draft-drawing-canvas');
            if (!canvas) return;
            if (this.history.length > 30) this.history.shift();
            this.history.push(canvas.toDataURL());
        },

        undo() {
            if (this.history.length <= 1) {
                this.clearCanvas();
                return;
            }
            const lastAction = this.history.pop();
            if (lastAction && typeof lastAction === 'object' && lastAction.type === 'textbox_add') {
                const idx = this.textBoxes.findIndex(t => t.id === lastAction.id);
                if (idx !== -1) {
                    this.textBoxes.splice(idx, 1);
                }
                return;
            }

            const prevState = this.history[this.history.length - 1];
            const canvas = document.getElementById('draft-drawing-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const dpr = window.devicePixelRatio || 1;
            const img = new Image();
            img.onload = () => {
                ctx.save();
                ctx.setTransform(1, 0, 0, 1, 0, 0);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);
                ctx.restore();
            };
            img.src = typeof prevState === 'string' ? prevState : (this.history[0] || '');
        },

        clearCanvas() {
            const canvas = document.getElementById('draft-drawing-canvas');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                ctx.save();
                ctx.setTransform(1, 0, 0, 1, 0, 0);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.restore();
                this.history = [canvas.toDataURL()];
            }
            this.textBoxes = [];
        },

        startDrawing(e) {
            if (!this.drawingMode) return;

            if (this.activeTool === 'text') {
                this.addTextBoxAt(e);
                return;
            }

            const canvas = document.getElementById('draft-drawing-canvas');
            if (!canvas) return;
            try {
                canvas.setPointerCapture(e.pointerId);
            } catch (err) {}

            const rect = canvas.getBoundingClientRect();
            this.isDrawing = true;
            this.lastX = e.clientX - rect.left;
            this.lastY = e.clientY - rect.top;

            const ctx = canvas.getContext('2d');
            ctx.beginPath();
            ctx.moveTo(this.lastX, this.lastY);

            // Draw initial dot
            this.drawDot(this.lastX, this.lastY);
        },

        addTextBoxAt(e) {
            const wrapper = document.getElementById('draft-modal-canvas-wrapper');
            if (!wrapper) return;
            const rect = wrapper.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const newTb = {
                id: Date.now(),
                top: Math.max(10, Math.round(y - 15)),
                left: Math.max(10, Math.min(Math.round(x - 15), (wrapper.offsetWidth || 600) - 220)),
                text: '',
                color: this.activeColor,
                fontSize: (this.activeFontSize || 14) + 'px'
            };

            this.textBoxes.push(newTb);
            this.history.push({ type: 'textbox_add', id: newTb.id });

            this.$nextTick(() => {
                const tas = wrapper.querySelectorAll('textarea');
                if (tas.length > 0) {
                    tas[tas.length - 1].focus();
                }
            });
        },

        removeTextBox(index) {
            this.textBoxes.splice(index, 1);
        },

        startDragTextBox(e, index) {
            e.preventDefault();
            const tb = this.textBoxes[index];
            if (!tb) return;
            const wrapper = document.getElementById('draft-modal-canvas-wrapper');
            const startX = e.clientX;
            const startY = e.clientY;
            const initialLeft = tb.left;
            const initialTop = tb.top;

            const onMove = (moveEvent) => {
                const dx = moveEvent.clientX - startX;
                const dy = moveEvent.clientY - startY;
                tb.left = Math.max(0, Math.min(initialLeft + dx, (wrapper?.offsetWidth || 600) - 180));
                tb.top = Math.max(0, initialTop + dy);
            };

            const onUp = () => {
                window.removeEventListener('mousemove', onMove);
                window.removeEventListener('mouseup', onUp);
            };

            window.addEventListener('mousemove', onMove);
            window.addEventListener('mouseup', onUp);
        },

        getTextBg(color) {
            if (color === '#ef4444') return '#fff1f2';
            if (color === '#3b82f6') return '#eff6ff';
            if (color === '#10b981') return '#f0fdf4';
            if (color === '#f59e0b') return '#fffbeb';
            if (color === '#8b5cf6') return '#faf5ff';
            return '#ffffff';
        },

        draw(e) {
            if (!this.isDrawing || !this.drawingMode || this.activeTool === 'text') return;
            const canvas = document.getElementById('draft-drawing-canvas');
            if (!canvas) return;
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ctx = canvas.getContext('2d');
            this.applyStrokeStyle(ctx);

            ctx.beginPath();
            ctx.moveTo(this.lastX, this.lastY);
            ctx.lineTo(x, y);
            ctx.stroke();

            this.lastX = x;
            this.lastY = y;
        },

        drawDot(x, y) {
            const canvas = document.getElementById('draft-drawing-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            this.applyStrokeStyle(ctx);
            ctx.beginPath();
            ctx.arc(x, y, (ctx.lineWidth || 2) / 2, 0, Math.PI * 2);
            ctx.fillStyle = ctx.strokeStyle;
            ctx.fill();
        },

        applyStrokeStyle(ctx) {
            if (this.activeTool === 'eraser') {
                ctx.globalCompositeOperation = 'destination-out';
                ctx.strokeStyle = 'rgba(0,0,0,1)';
                ctx.lineWidth = this.activeSize * 6;
            } else if (this.activeTool === 'highlighter') {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = this.getHighlighterColor(this.activeColor);
                ctx.lineWidth = this.activeSize * 5;
            } else {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = this.activeColor;
                ctx.lineWidth = this.activeSize;
            }
        },

        stopDrawing() {
            if (!this.isDrawing) return;
            this.isDrawing = false;
            this.saveState();
        },

        getHighlighterColor(color) {
            if (color === '#ef4444') return 'rgba(239, 68, 68, 0.45)';
            if (color === '#3b82f6') return 'rgba(59, 130, 246, 0.45)';
            if (color === '#10b981') return 'rgba(16, 185, 129, 0.45)';
            if (color === '#f59e0b') return 'rgba(245, 158, 11, 0.5)';
            if (color === '#8b5cf6') return 'rgba(139, 92, 246, 0.45)';
            return 'rgba(234, 179, 8, 0.5)';
        },

        isExportingPdf: false,
        isSavingForStudent: false,

        async captureCanvasComposite() {
            const wrapper = document.getElementById('draft-modal-canvas-wrapper');
            if (!wrapper) return null;

            // Use html2canvas to snapshot the entire question list + drawing overlay
            if (typeof html2canvas === 'undefined') {
                await new Promise((resolve, reject) => {
                    const script = document.createElement('script');
                    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
                    script.onload = resolve;
                    script.onerror = reject;
                    document.head.appendChild(script);
                });
            }

            const canvas = await html2canvas(wrapper, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                windowWidth: wrapper.scrollWidth,
                windowHeight: wrapper.scrollHeight
            });

            return canvas.toDataURL('image/png');
        },

        async exportAndDownloadPdf() {
            if (this.isExportingPdf) return;
            this.isExportingPdf = true;

            try {
                const imgPayload = await this.captureCanvasComposite();
                if (!imgPayload) throw new Error('Gagal mengambil gambar lembar tugas.');

                const response = await fetch('/api/live-drawing/pdf', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ payload: imgPayload })
                });

                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const blob = await response.blob();
                const blobUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                const cleanName = (this.viewingDraft?.name || 'Student').replace(/[^a-zA-Z0-9_-]/g, '_');
                a.download = `Evaluasi-${cleanName}-${Date.now()}.pdf`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(blobUrl);
            } catch (err) {
                console.error('[Review] Export PDF error:', err);
                alert('Gagal mengekspor PDF: ' + err.message);
            } finally {
                this.isExportingPdf = false;
            }
        },

        async saveEvaluationForStudent() {
            if (this.isSavingForStudent || !this.viewingDraft) return;
            this.isSavingForStudent = true;

            try {
                const imgPayload = await this.captureCanvasComposite();
                if (!imgPayload) throw new Error('Gagal mengambil gambar lembar tugas.');

                const res = await fetch('{{ route('admin.grammar-writing-review.save-canvas') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        user_id: this.viewingDraft.user_id,
                        program_id: this.viewingDraft.program_id || null,
                        meeting_number: this.viewingDraft.meeting_number,
                        score_id: this.viewingDraft.score_id || null,
                        draft_id: this.viewingDraft.id || null,
                        image: imgPayload,
                    })
                });

                const data = await res.json();
                if (!res.ok || !data.success) {
                    throw new Error(data.message || `HTTP ${res.status}`);
                }

                alert('✓ Hasil coret-coret evaluasi berhasil disimpan!\n\nSiswa (' + this.viewingDraft.name + ') sekarang dapat mengunduh file PDF evaluasi ini langsung dari halaman nilainya.');
            } catch (err) {
                console.error('[Review] Save canvas error:', err);
                alert('Gagal menyimpan evaluasi: ' + err.message);
            } finally {
                this.isSavingForStudent = false;
            }
        }
    };
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endsection
