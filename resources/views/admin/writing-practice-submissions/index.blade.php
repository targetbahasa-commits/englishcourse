@extends('layouts.admin')

@section('title', 'Hasil & Pemeriksaan IELTS Writing Student')

@section('content')
<div class="p-6 max-w-[1600px] mx-auto">
    <!-- Header Banner -->
    <div class="mb-8 relative overflow-hidden rounded-3xl shadow-lg p-8" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%); color: #ffffff;">
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full -mr-20 -mt-20 blur-2xl"></div>
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <span class="p-3.5 rounded-2xl flex items-center justify-center shrink-0 bg-white/10 backdrop-blur border border-white/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </span>
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight" style="color: #ffffff !important;">IELTS Writing Student — Hasil & Pemeriksaan</h1>
                    <p class="mt-1 text-sm font-medium text-indigo-200">Daftar pengerjaan writing student, evaluasi AI, serta pemeriksaan dan masukan pengajar.</p>
                </div>
            </div>

            <!-- Right Section: Stats & AI Toggle Switch -->
            <div class="flex flex-wrap items-center gap-4">
                <!-- AI Evaluation Toggle Box (Khusus Admin & Teacher) -->
                <div x-data="{
                        aiEnabled: @js($aiEnabled),
                        loading: false,
                        async toggleAi() {
                            if (this.loading) return;
                            this.loading = true;
                            try {
                                const res = await fetch('{{ route('admin.writing-practice-submissions.toggle-ai') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ enabled: !this.aiEnabled })
                                });
                                const data = await res.json();
                                if (res.ok && data.status === 'success') {
                                    this.aiEnabled = data.ai_enabled;
                                    alert(data.message);
                                } else {
                                    alert('Gagal mengubah mode penilaian AI.');
                                }
                            } catch(e) {
                                console.error(e);
                                alert('Terjadi kesalahan jaringan.');
                            } finally {
                                this.loading = false;
                            }
                        }
                    }" class="bg-white/10 backdrop-blur border border-white/20 px-4 py-2.5 rounded-2xl flex items-center gap-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-base shadow-sm shrink-0"
                              :class="aiEnabled ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30' : 'bg-amber-500/20 text-amber-300 border border-amber-400/30'"
                              x-text="aiEnabled ? '🤖' : '✏️'"></span>
                        <div>
                            <div class="text-xs font-extrabold text-white flex items-center gap-1.5">
                                <span>Penilaian AI:</span>
                                <span x-text="aiEnabled ? 'AKTIF' : 'MATI (CORET-CORET GURU)'"
                                      :class="aiEnabled ? 'text-emerald-300' : 'text-amber-300'" class="uppercase tracking-wider"></span>
                            </div>
                            <p class="text-[11px] text-indigo-200 mt-0.5"
                               x-text="aiEnabled ? 'AI menilai otomatis saat disubmit' : 'Menampilkan lembar coret-coret pengajar'"></p>
                        </div>
                    </div>
                    <button type="button" @click="toggleAi()" :disabled="loading"
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                            :class="aiEnabled ? 'bg-emerald-500' : 'bg-slate-500'">
                        <span class="sr-only">Toggle AI Evaluation</span>
                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                              :class="aiEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                    </button>
                </div>

                <!-- Stats -->
                @if(isset($stats))
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur border border-white/20 p-2.5 rounded-2xl">
                        <div class="px-4 py-1.5 text-center">
                            <div class="text-[10px] uppercase font-bold text-indigo-200">Total</div>
                            <div class="text-xl font-black text-white">{{ $stats['total'] }}</div>
                        </div>
                        <div class="w-px h-8 bg-white/20"></div>
                        <div class="px-4 py-1.5 text-center">
                            <div class="text-[10px] uppercase font-bold text-emerald-300">Berhasil</div>
                            <div class="text-xl font-black text-emerald-300">{{ $stats['success'] }}</div>
                        </div>
                        <div class="w-px h-8 bg-white/20"></div>
                        <div class="px-4 py-1.5 text-center">
                            <div class="text-[10px] uppercase font-bold text-amber-300">Nilai Ulang</div>
                            <div class="text-xl font-black text-amber-300">{{ $stats['failed'] }}</div>
                        </div>
                        <div class="w-px h-8 bg-white/20"></div>
                        <div class="px-4 py-1.5 text-center">
                            <div class="text-[10px] uppercase font-bold text-purple-300">Diperiksa</div>
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
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
            @php $currentStatus = $status ?? 'all'; @endphp
            <a href="{{ route('admin.writing-practice-submissions.index', array_merge(request()->query(), ['status' => 'all'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua Submission
            </a>
            <a href="{{ route('admin.writing-practice-submissions.index', array_merge(request()->query(), ['status' => 'success'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'success' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Berhasil Dinilai
            </a>
            <a href="{{ route('admin.writing-practice-submissions.index', array_merge(request()->query(), ['status' => 'pending_review'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'pending_review' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Belum Diperiksa Pengajar
            </a>
            <a href="{{ route('admin.writing-practice-submissions.index', array_merge(request()->query(), ['status' => 'reviewed'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'reviewed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Sudah Diperiksa
            </a>
            <a href="{{ route('admin.writing-practice-submissions.index', array_merge(request()->query(), ['status' => 'failed'])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $currentStatus === 'failed' ? 'bg-rose-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Perlu Nilai Ulang (Failed)
            </a>
        </div>

        <!-- Search & Sort Form -->
        @php
            $currentSort = request('sort', 'latest');
            $sortUrl = function($targetSort) use ($currentStatus) {
                return route('admin.writing-practice-submissions.index', array_merge(request()->query(), ['sort' => $targetSort, 'status' => $currentStatus]));
            };
        @endphp
        <form method="GET" action="{{ route('admin.writing-practice-submissions.index') }}" class="flex flex-wrap items-center gap-2 shrink-0">
            <input type="hidden" name="status" value="{{ $currentStatus }}">
            
            {{-- Filter Batch --}}
            @if(isset($classPeriods) && count($classPeriods) > 0)
                <div class="flex items-center gap-1.5 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 text-xs">
                    <span class="text-gray-400 font-semibold text-[11px] uppercase tracking-wider">Batch:</span>
                    <select name="batch_id" onchange="this.form.submit()" class="bg-transparent font-bold text-gray-700 focus:outline-none cursor-pointer text-xs max-w-[170px] truncate">
                        <option value="">Semua Batch Kelas</option>
                        @foreach($classPeriods as $cp)
                            <option value="{{ $cp->id }}" {{ request('batch_id') == $cp->id ? 'selected' : '' }}>
                                {{ $cp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Urutkan --}}
            <div class="flex items-center gap-1.5 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 text-xs">
                <span class="text-gray-400 font-semibold text-[11px] uppercase tracking-wider">Urutkan:</span>
                <select name="sort" onchange="this.form.submit()" class="bg-transparent font-bold text-gray-700 focus:outline-none cursor-pointer text-xs">
                    <option value="latest" {{ $currentSort === 'latest' ? 'selected' : '' }}>Terbaru (Waktu Submit)</option>
                    <option value="oldest" {{ $currentSort === 'oldest' ? 'selected' : '' }}>Terlama (Waktu Submit)</option>
                    <option value="batch_asc" {{ $currentSort === 'batch_asc' ? 'selected' : '' }}>Nama Batch (A – Z)</option>
                    <option value="batch_desc" {{ $currentSort === 'batch_desc' ? 'selected' : '' }}>Nama Batch (Z – A)</option>
                    <option value="meeting_asc" {{ $currentSort === 'meeting_asc' ? 'selected' : '' }}>Task & Meeting (1 → 20)</option>
                    <option value="meeting_desc" {{ $currentSort === 'meeting_desc' ? 'selected' : '' }}>Task & Meeting (20 → 1)</option>
                    <option value="score_ai_desc" {{ $currentSort === 'score_ai_desc' ? 'selected' : '' }}>Score AI (Tertinggi → Terendah)</option>
                    <option value="score_ai_asc" {{ $currentSort === 'score_ai_asc' ? 'selected' : '' }}>Score AI (Terendah → Tertinggi)</option>
                    <option value="teacher_score_desc" {{ $currentSort === 'teacher_score_desc' ? 'selected' : '' }}>Nilai Pengajar (Tertinggi → Terendah)</option>
                    <option value="teacher_score_asc" {{ $currentSort === 'teacher_score_asc' ? 'selected' : '' }}>Nilai Pengajar (Terendah → Tertinggi)</option>
                    <option value="name_asc" {{ $currentSort === 'name_asc' ? 'selected' : '' }}>Nama Student (A – Z)</option>
                    <option value="name_desc" {{ $currentSort === 'name_desc' ? 'selected' : '' }}>Nama Student (Z – A)</option>
                </select>
            </div>

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama student / email..."
                   class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition">Cari</button>
            @if(request('search') || request('sort') || request('batch_id'))
                <a href="{{ route('admin.writing-practice-submissions.index', ['status' => $currentStatus]) }}" class="px-3 py-2 bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl hover:bg-gray-300">Reset</a>
            @endif
        </form>
    </div>

    <!-- In Progress (Not Yet Submitted) -->
    @if($inProgressSubmissions->count() > 0)
    <div x-data="{ viewingDraft: null }">
    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 mb-6 p-6">
        <div class="flex items-center gap-2 mb-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-500"></span>
            </span>
            <h2 class="text-lg font-bold text-gray-900">Sedang Dikerjakan (Belum Submit)</h2>
        </div>
        <p class="text-sm text-gray-500 mb-5">Student yang sudah mulai menulis esai tapi belum submit. Progres dihitung dari jumlah kata yang sudah ditulis di semua kolom draft, bukan hasil penilaian.</p>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-orange-50 border-b border-orange-100">
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Student</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Meeting</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Task</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Progres</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Terakhir Disimpan</th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($inProgressSubmissions as $draft)
                    @php
                        $draftAnswers = is_array($draft->answers) ? $draft->answers : [];
                        $draftWordCount = str_word_count(implode(' ', array_filter(array_map(fn ($v) => is_string($v) ? $v : '', $draftAnswers))));
                    @endphp
                    <tr class="hover:bg-orange-50/50 transition">
                        <td class="p-4">
                            <p class="font-semibold text-gray-900">{{ $draft->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $draft->user->email ?? '' }}</p>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-700">{{ $draft->meeting->title ?? ('Meeting ' . $draft->meeting_id) }}</p>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                Task {{ $draft->task_type }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-semibold text-gray-700">{{ $draftWordCount }} kata</span>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-600">{{ $draft->last_saved_at?->diffForHumans() }}</p>
                        </td>
                        <td class="p-4">
                            <button type="button"
                                @click="viewingDraft = { name: @js($draft->user->name ?? 'N/A'), meta: @js(($draft->meeting->title ?? ('Meeting ' . $draft->meeting_id)) . ' · Task ' . $draft->task_type), savedAt: @js($draft->last_saved_at?->diffForHumans()), answers: @js($draftAnswers) }"
                                class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                Lihat Jawaban
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Draft Answers Modal -->
        <div x-show="viewingDraft" x-cloak @keydown.escape.window="viewingDraft = null" @click.self="viewingDraft = null"
             class="fixed inset-0 bg-black/50 backdrop-blur-xs flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] flex flex-col overflow-hidden border border-gray-100" @click.stop>
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 pb-4 border-b border-gray-100 bg-slate-50/50 shrink-0">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900" x-text="viewingDraft?.name"></h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-orange-100 text-orange-800" x-text="viewingDraft?.meta"></span>
                            <span class="text-xs text-gray-400">&bull;</span>
                            <span class="text-xs text-gray-500 font-medium" x-text="'Tersimpan ' + viewingDraft?.savedAt"></span>
                        </div>
                    </div>
                    <button type="button" @click="viewingDraft = null" class="w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-700 hover:bg-gray-100 flex items-center justify-center transition shrink-0 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-4 overflow-y-auto max-h-[calc(85vh-100px)]">
                    <template x-for="(value, key) in (viewingDraft?.answers || {})" :key="key">
                        <div class="border border-gray-200/90 rounded-2xl p-4 bg-gray-50/70 hover:bg-gray-50 transition space-y-2.5">
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
                                    <template x-if="value.trans !== undefined || value.answer !== undefined || value.user_answer !== undefined">
                                        <div>
                                            <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Terjemahan / Jawaban:</span>
                                            <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed" 
                                                 x-text="(value.trans || value.answer || value.user_answer || '(kosong)')">
                                            </div>
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

                                    <!-- Generic Fallback for other Object properties -->
                                    <template x-for="(subVal, subKey) in value" :key="subKey">
                                        <template x-if="!['tense', 'trans', 'answer', 'user_answer', 'v2', 'v3'].includes(subKey)">
                                            <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                                <span class="text-xs font-bold text-gray-500 uppercase block mb-1" x-text="subKey"></span>
                                                <div class="text-sm text-gray-800 whitespace-pre-wrap" x-text="typeof subVal === 'object' ? JSON.stringify(subVal, null, 2) : (subVal || '(kosong)')"></div>
                                            </div>
                                        </template>
                                    </template>
                                </div>
                            </template>

                            <!-- Case 2: Value is a Plain String / Primitive -->
                            <template x-if="typeof value !== 'object' || value === null">
                                <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed" 
                                     x-text="value || '(kosong)'">
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
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($submissions->isEmpty())
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
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">
                                <a href="{{ $sortUrl($currentSort === 'name_asc' ? 'name_desc' : 'name_asc') }}" class="inline-flex items-center gap-1 hover:text-indigo-600 transition" title="Klik untuk mengurutkan berdasarkan nama">
                                    <span>Student</span>
                                    @if($currentSort === 'name_asc') <span class="text-indigo-600">▲</span> @elseif($currentSort === 'name_desc') <span class="text-indigo-600">▼</span> @else <span class="text-gray-300">↕</span> @endif
                                </a>
                            </th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">
                                <a href="{{ $sortUrl($currentSort === 'meeting_asc' ? 'meeting_desc' : 'meeting_asc') }}" class="inline-flex items-center gap-1 hover:text-indigo-600 transition" title="Klik untuk mengurutkan berdasarkan Task & Meeting">
                                    <span>Task & Meeting</span>
                                    @if($currentSort === 'meeting_asc') <span class="text-indigo-600">▲</span> @elseif($currentSort === 'meeting_desc') <span class="text-indigo-600">▼</span> @else <span class="text-gray-300">↕</span> @endif
                                </a>
                            </th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Cuplikan Tulisan</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-center">
                                <a href="{{ $sortUrl($currentSort === 'score_ai_desc' ? 'score_ai_asc' : 'score_ai_desc') }}" class="inline-flex items-center gap-1 hover:text-indigo-600 transition justify-center w-full" title="Klik untuk mengurutkan berdasarkan Score AI">
                                    <span>Score AI</span>
                                    @if($currentSort === 'score_ai_desc') <span class="text-indigo-600">▼</span> @elseif($currentSort === 'score_ai_asc') <span class="text-indigo-600">▲</span> @else <span class="text-gray-300">↕</span> @endif
                                </a>
                            </th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-center">
                                <a href="{{ $sortUrl($currentSort === 'teacher_score_desc' ? 'teacher_score_asc' : 'teacher_score_desc') }}" class="inline-flex items-center gap-1 hover:text-indigo-600 transition justify-center w-full" title="Klik untuk mengurutkan berdasarkan Nilai Pengajar">
                                    <span>Nilai Pengajar</span>
                                    @if($currentSort === 'teacher_score_desc') <span class="text-indigo-600">▼</span> @elseif($currentSort === 'teacher_score_asc') <span class="text-indigo-600">▲</span> @else <span class="text-gray-300">↕</span> @endif
                                </a>
                            </th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">
                                <a href="{{ $sortUrl($currentSort === 'latest' ? 'oldest' : 'latest') }}" class="inline-flex items-center gap-1 hover:text-indigo-600 transition" title="Klik untuk mengurutkan berdasarkan Waktu Submit">
                                    <span>Waktu Submit</span>
                                    @if($currentSort === 'latest') <span class="text-indigo-600">▼</span> @elseif($currentSort === 'oldest') <span class="text-indigo-600">▲</span> @else <span class="text-gray-300">↕</span> @endif
                                </a>
                            </th>
                            <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="submission-rows" class="divide-y divide-gray-100">
                        @foreach($submissions as $submission)
                            @php
                                $scores = $submission->scores ?? [];
                                $overallBand = $scores['overall_band_score'] ?? $scores['overall_band'] ?? '-';
                                $userBatchName = $submission->user->classPeriod->name ?? $submission->user->enrollments->first()->classPeriod->name ?? null;
                            @endphp
                            <tr id="submission-row-{{ $submission->id }}" class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-4 align-top">
                                    <div class="font-bold text-gray-900 text-sm">{{ $submission->user->name ?? 'Unknown Student' }}</div>
                                    <div class="text-xs text-gray-500">{{ $submission->user->email ?? '' }}</div>
                                    @if($userBatchName)
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            📦 {{ $userBatchName }}
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 align-top">
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-teal-100 text-teal-800 mb-1">
                                        Task {{ $submission->task_type }}
                                    </span>
                                    <div class="text-xs font-semibold text-gray-800 max-w-xs truncate">
                                        {{ $submission->meeting->title ?? 'Exercise Task ' . $submission->task_type }}
                                    </div>
                                </td>

                                <td class="p-4 align-top text-xs text-gray-600 max-w-xs">
                                    <span class="line-clamp-2 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($submission->essay), 110) }}</span>
                                </td>

                                <td class="p-4 align-top text-center">
                                    @if($submission->evaluation_status === 'success')
                                        <span class="inline-block px-2.5 py-1 rounded-lg text-sm font-extrabold bg-amber-100 text-amber-900 border border-amber-200">
                                            {{ $overallBand }}
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-100 text-rose-800">
                                            Failed
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 align-top text-center">
                                    @if($submission->teacher_score)
                                        <span class="inline-block px-2.5 py-1 rounded-lg text-sm font-extrabold bg-purple-100 text-purple-900 border border-purple-200">
                                            {{ number_format($submission->teacher_score, 1) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">—</span>
                                    @endif
                                </td>

                                <td class="p-4 align-top">
                                    <div class="space-y-1">
                                        @if($submission->evaluation_status === 'success')
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                                                ✓ AI OK
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded bg-rose-100 text-rose-800" title="{{ $submission->error_message }}">
                                                ⚠ AI Failed
                                            </span>
                                        @endif

                                        @if($submission->teacher_feedback)
                                            <div>
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-800">
                                                    ✓ Reviewed
                                                </span>
                                            </div>
                                        @else
                                            <div>
                                                <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2 py-0.5 rounded bg-gray-100 text-gray-600">
                                                    Belum Review
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-4 align-top text-xs text-gray-500">
                                    {{ $submission->updated_at ? $submission->updated_at->format('d M Y H:i') : '-' }}
                                    <div class="text-[10px] text-gray-400">Ke-{{ $submission->attempts }} attempt</div>
                                </td>

                                <td class="p-4 align-top text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.writing-practice-submissions.show', $submission->id) }}" target="_blank"
                                           class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1 shadow-sm">
                                            <span>Periksa</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>

                                        @if($submission->evaluation_status === 'failed')
                                            <button onclick="retrySubmission({{ $submission->id }}, this)"
                                                    class="px-3 py-1.5 bg-orange-600 hover:bg-orange-700 disabled:opacity-50 text-white text-xs font-bold rounded-lg transition-colors">
                                                Resend
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    async function retrySubmission(id, buttonEl) {
        buttonEl.disabled = true;
        const originalText = buttonEl.textContent;
        buttonEl.textContent = 'Mengirim...';

        try {
            const response = await fetch(`/assignments/ielts-academic/writing/submission/${id}/retry`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                alert('Penilaian AI berhasil diperbarui!');
                window.location.reload();
            } else {
                alert('Gagal mengirim ulang: ' + (data.error || 'Unknown error'));
                buttonEl.disabled = false;
                buttonEl.textContent = originalText;
            }
        } catch (e) {
            console.error(e);
            alert('Terjadi kesalahan koneksi.');
            buttonEl.disabled = false;
            buttonEl.textContent = originalText;
        }
    }
</script>
@endsection
