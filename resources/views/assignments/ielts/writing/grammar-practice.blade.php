<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 { color: #111827; font-weight: 700; margin-top: 1.5em; margin-bottom: 0.5em; line-height: 1.3; }
        .prose h3 { font-size: 1.5rem; }
        .prose h4 { font-size: 1.25rem; }
        .prose p { margin-top: 1em; margin-bottom: 1em; line-height: 1.75; color: #374151; }
        .prose ul { list-style-type: disc; padding-left: 1.625em; margin-top: 1em; margin-bottom: 1em; }
        .prose ol { list-style-type: decimal; padding-left: 1.625em; margin-top: 1em; margin-bottom: 1em; }
        .prose li { margin-top: 0.5em; margin-bottom: 0.5em; color: #374151; }
        .prose li::marker { color: #9ca3af; }
        .prose strong { font-weight: 700; color: #111827; }
        .prose blockquote { border-left-width: 4px; border-color: #e5e7eb; padding-left: 1em; font-style: italic; color: #4b5563; margin-top: 1.6em; margin-bottom: 1.6em; }
        .prose code { color: #111827; background-color: #f3f4f6; padding: 0.2em 0.4em; border-radius: 0.25rem; font-size: 0.875em; }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-teal-50 via-cyan-50 to-emerald-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                                {{ $title }}
                            </h1>
                            <p class="text-gray-600 mt-1">{{ $desc }}</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>

                @if(in_array($level, ['introductory', 'complexity', 'proficiency', 'all']))
                    <div x-data="practiceAI()" @open-lesson-explanation.window="generateLessonExplanation()" class="space-y-6">
                        <!-- Lessons Explanation Container -->
                        <div class="bg-gradient-to-r from-teal-50 to-emerald-50 rounded-2xl shadow-sm border border-teal-100 p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 text-teal-100 opacity-50">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            </div>
                            <div class="relative z-10 flex items-start gap-4">
                                <div class="p-3 bg-white rounded-xl shadow-sm">
                                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-teal-900 mb-2">Penjelasan Lessons ({{ ucfirst($level) }})</h2>
                                    <p class="text-teal-800 leading-relaxed max-w-3xl">
                                        @if($level === 'complexity')
                                            Di tingkat Complexity ini, Anda akan berlatih menerjemahkan struktur kalimat yang lebih kompleks dan paragraf yang menantang. Latihan ini dirancang untuk memperdalam penguasaan grammar tingkat lanjut dan kemampuan merangkai kalimat majemuk secara natural.
                                        @else
                                            Di tingkat Introductory ini, Anda akan berlatih menerjemahkan kalimat-kalimat dasar dan paragraf pendek. Latihan ini akan mengasah pemahaman Anda tentang struktur kalimat sederhana dalam bahasa Inggris, memperkuat fondasi grammar yang krusial untuk level selanjutnya.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- ============================================================ --}}
                        {{-- ADMIN ONLY: Manage Grammar Topics Panel                     --}}
                        {{-- ============================================================ --}}
                        @if(Auth::user()->isAdmin())
                        <div x-data="introTopicAdmin()" class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden">
                            <!-- Collapsible Header -->
                            <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-amber-500 rounded-lg shadow-sm">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-amber-900">Admin: Kelola Topik Grammar {{ ucfirst($level) }}</h3>
                                        <p class="text-xs text-amber-600">Klik untuk buka/tutup panel pengeditan topik AI Generator</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-amber-600 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-transition class="p-6" style="display:none;">
                                <!-- Actions Bar -->
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-sm text-gray-600">Total: <strong x-text="topics.length"></strong> topik terdaftar. Topik ini yang tampil sebagai pilihan di AI Generator.</p>
                                    <button @click="openCreate()" type="button" class="flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white text-sm rounded-xl font-medium hover:bg-teal-700 transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Topik
                                    </button>
                                </div>

                                <!-- Status message -->
                                <div x-show="statusMsg" x-text="statusMsg" class="mb-3 p-3 text-sm text-center font-medium rounded-xl" :class="statusOk ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600'"></div>

                                <!-- Topics Table -->
                                <div class="overflow-x-auto rounded-xl border border-gray-100">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                            <tr>
                                                <th class="px-4 py-3 text-left w-12">#</th>
                                                <th class="px-4 py-3 text-left w-20">Label</th>
                                                <th class="px-4 py-3 text-left">Nama Topik</th>
                                                <th class="px-4 py-3 text-left">Aturan Grammar (untuk AI)</th>
                                                <th class="px-4 py-3 text-center w-24">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <template x-for="(topic, idx) in topics" :key="topic.id ?? idx">
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-4 py-3 text-gray-400 font-mono text-xs" x-text="idx + 1"></td>
                                                    <td class="px-4 py-3">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700" x-text="topic.label"></span>
                                                    </td>
                                                    <td class="px-4 py-3 font-semibold text-gray-800" x-text="topic.topic"></td>
                                                    <td class="px-4 py-3 text-gray-500 text-xs max-w-xs truncate" :title="topic.grammar_rules">
                                                        <span x-text="topic.grammar_rules ? topic.grammar_rules.substring(0, 70) + (topic.grammar_rules.length > 70 ? '...' : '') : '—'"></span>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="flex items-center justify-center gap-1">
                                                            <button @click="openEdit(topic)" type="button" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                            </button>
                                                            <button @click="deleteTopic(topic)" type="button" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr x-show="topics.length === 0">
                                                <td colspan="5" class="px-4 py-8 text-center text-gray-400 italic">Belum ada topik tersimpan. Klik "Tambah Topik" atau muat ulang halaman untuk mengisi dari data default.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Edit/Create Modal (rendered outside collapsed area) -->
                            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;" @keydown.escape.window="showModal = false">
                                <div class="absolute inset-0 bg-black/50" @click="showModal = false"></div>
                                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden z-10" x-transition>
                                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                                        <h3 class="text-lg font-bold text-gray-900" x-text="isCreating ? 'Tambah Topik Grammar Baru' : 'Edit Topik Grammar'"></h3>
                                        <button @click="showModal = false" type="button" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <form @submit.prevent="submitForm" class="px-6 py-5 space-y-4">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Label <span class="text-xs text-gray-400">(mis: 8a)</span></label>
                                                <input type="text" x-model="form.label" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5" placeholder="8a" required>
                                            </div>
                                            <div class="col-span-2">
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Topik</label>
                                                <input type="text" x-model="form.topic" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5" placeholder="mis: Modal, Gerund, Simple Past Tense" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                                Aturan Grammar untuk AI
                                                <span class="text-xs font-normal text-gray-400 ml-1">(Opsional — akan disertakan dalam prompt AI sebagai aturan tambahan)</span>
                                            </label>
                                            <textarea x-model="form.grammar_rules" rows="4" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: Wajib menggunakan modal auxiliary (can/could/will/would/shall/should/may/might/must). Struktur: S + Modal + V1. DILARANG Gerund atau To-Infinitive."></textarea>
                                        </div>
                                        <div class="flex justify-end gap-3 pt-2">
                                            <button type="button" @click="showModal = false" class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">Batal</button>
                                            <button type="submit" :disabled="isSaving" class="px-5 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition shadow-sm disabled:opacity-50">
                                                <span x-show="!isSaving" x-text="isCreating ? 'Tambahkan' : 'Simpan Perubahan'"></span>
                                                <span x-show="isSaving">Menyimpan...</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                        function introTopicAdmin() {
                            return {
                                open: false,
                                showModal: false,
                                isCreating: false,
                                isSaving: false,
                                statusMsg: '',
                                statusOk: true,
                                topics: {!! $introTopics->map(fn($t) => ['id' => $t->id, 'label' => $t->label, 'topic' => $t->topic, 'grammar_rules' => $t->grammar_rules ?? ''])->values()->toJson() !!},
                                form: { label: '', topic: '', grammar_rules: '' },
                                editingId: null,
                                openCreate() {
                                    this.isCreating = true;
                                    this.editingId = null;
                                    this.form = { label: '', topic: '', grammar_rules: '' };
                                    this.showModal = true;
                                },
                                openEdit(topic) {
                                    this.isCreating = false;
                                    this.editingId = topic.id;
                                    this.form = { label: topic.label, topic: topic.topic, grammar_rules: topic.grammar_rules || '' };
                                    this.showModal = true;
                                },
                                async submitForm() {
                                    this.isSaving = true;
                                    const url = this.isCreating
                                        ? '{{ route("assignments.grammar-writing.intro-topics.store") }}'
                                        : `/assignments/grammar-writing/intro-topics/${this.editingId}`;
                                    const method = this.isCreating ? 'POST' : 'PUT';
                                    try {
                                        const res = await fetch(url, {
                                            method,
                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                                            body: JSON.stringify(this.form)
                                        });
                                        const data = await res.json();
                                        if (data.success) {
                                            this.showModal = false;
                                            this.statusMsg = this.isCreating ? '✓ Topik berhasil ditambahkan! Memuat ulang...' : '✓ Topik berhasil diperbarui! Memuat ulang...';
                                            this.statusOk = true;
                                            setTimeout(() => window.location.reload(), 800);
                                        }
                                    } catch(e) {
                                        this.statusMsg = '✗ Terjadi kesalahan. Silakan coba lagi.';
                                        this.statusOk = false;
                                        this.isSaving = false;
                                    }
                                },
                                async deleteTopic(topic) {
                                    if (!topic.id) { alert('Topik ini belum tersimpan di database. Muat ulang halaman terlebih dahulu.'); return; }
                                    if (!confirm(`Hapus topik "${topic.topic}"? Tindakan ini tidak dapat dibatalkan.`)) return;
                                    try {
                                        const res = await fetch(`/assignments/grammar-writing/intro-topics/${topic.id}`, {
                                            method: 'DELETE',
                                            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
                                        });
                                        const data = await res.json();
                                        if (data.success) {
                                            this.topics = this.topics.filter(t => t.id !== topic.id);
                                            this.statusMsg = '✓ Topik berhasil dihapus.';
                                            this.statusOk = true;
                                            this.open = true;
                                            setTimeout(() => window.location.reload(), 800);
                                        }
                                    } catch(e) {
                                        this.statusMsg = '✗ Gagal menghapus topik.';
                                        this.statusOk = false;
                                    }
                                }
                            };
                        }
                        </script>
                        @endif

                        <div class="bg-white rounded-3xl shadow-sm border border-teal-100 overflow-visible mb-8">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">AI Generator</h2>
                            </div>
                            <p class="text-gray-600 mb-8 leading-relaxed text-sm md:text-base">
                                @if($level === 'all')
                                Sistem pintar kami siap membantu Anda! Pilih topik grammar di bawah ini, lalu AI akan menyusun <strong>10 kalimat latihan dan 2 paragraf argumentatif bergaya IELTS Academic Task 2</strong> yang disesuaikan khusus untuk melatih penguasaan topik grammar Anda.
                                @else
                                Sistem pintar kami siap membantu Anda! Pilih topik grammar dan tingkat kesulitan kosakata di bawah ini, lalu AI akan menyusun <strong>10 kalimat latihan terjemahan</strong> dan <strong>1 paragraf cerita</strong> yang disesuaikan khusus untuk Anda.
                                @endif
                            </p>
                            
                            <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gradient-to-b from-gray-50 to-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                                    <div class="flex items-center justify-between gap-2 mb-4 cursor-pointer" @click="showTopics = !showTopics">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <label class="block text-sm font-bold text-gray-800 cursor-pointer">Topik Grammar Pokok</label>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{'rotate-180': showTopics}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="showTopics" x-transition>
                                        <p class="text-xs text-gray-500 mb-4">Pilih satu atau lebih topik grammar yang ingin difokuskan pada latihan ini.</p>
                                    
                                    <div class="flex flex-wrap gap-2 max-h-52 overflow-y-auto pr-2 custom-scrollbar bg-white p-3 rounded-xl border border-gray-100">
                                        <!-- All Lessons Checkbox (Select All / Deselect All) -->
                                        <label class="inline-flex items-center gap-2 cursor-pointer group px-3 py-1.5 rounded-full border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition"
                                               :class="{'bg-indigo-50 border-indigo-300': selectedLessons.length === availableLessons.length}">
                                            <input type="checkbox"
                                                   :checked="selectedLessons.length === availableLessons.length"
                                                   @click="if (selectedLessons.length === availableLessons.length) { selectedLessons = []; } else { selectedLessons = [...availableLessons]; }"
                                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition duration-200">
                                            <span class="text-sm text-gray-800 group-hover:text-indigo-700 transition font-bold whitespace-nowrap">Semua Topik (All Lessons)</span>
                                        </label>
                                        
                                        <template x-for="lesson in availableLessons" :key="lesson">
                                            <label class="inline-flex items-center gap-2 cursor-pointer group px-3 py-1.5 rounded-full border border-gray-200 hover:border-indigo-300 hover:bg-gray-50 transition"
                                                   :class="{'bg-indigo-50 border-indigo-300': selectedLessons.includes(lesson)}">
                                                <input type="checkbox" :value="lesson" x-model="selectedLessons" class="w-4 h-4 text-indigo-500 border-gray-300 rounded focus:ring-indigo-500 transition duration-200">
                                                <span class="text-sm text-gray-700 group-hover:text-gray-900 transition font-medium whitespace-nowrap" x-text="lesson"></span>
                                            </label>
                                        </template>
                                    </div>
                                    </div>
                                </div>

                                <!-- Level Selection & Vocab Topic Card -->
                                <div class="bg-gradient-to-b from-gray-50 to-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition duration-300 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                            <label class="block text-sm font-bold text-gray-800">Tingkat Kesulitan Kosa Kata</label>
                                        </div>
                                        <div class="relative">
                                            <select x-model="selectedLevel" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm py-2.5 bg-white appearance-none pr-10">
                                                <option value="">Pilih Level Kosa Kata (CEFR)...</option>
                                                <template x-for="lvl in levels" :key="lvl">
                                                    <option :value="lvl" x-text="lvl"></option>
                                                </template>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Pilih A1 untuk pemula, hingga C1 untuk tingkat mahir.
                                        </p>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                            <label class="block text-sm font-bold text-gray-800">Tema / Konteks Pembahasan</label>
                                        </div>
                                        <div class="relative">
                                            <select x-model="selectedVocabTopic" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5 bg-white appearance-none pr-10">
                                                <option value="">Pilih Topik Kosakata...</option>
                                                <template x-for="topic in vocabTopics" :key="topic">
                                                    <option :value="topic" x-text="topic"></option>
                                                </template>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6 flex flex-wrap items-center gap-3">
                                <button @click="generateQuestions" :disabled="isGenerating || !apiKey || selectedLessons.length === 0 || !selectedLevel || !selectedVocabTopic" class="px-6 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium rounded-xl hover:from-teal-600 hover:to-emerald-600 focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition disabled:opacity-50 flex items-center gap-2 shadow-sm">
                                    <span x-show="isGenerating">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </span>
                                    Buatkan Soal {{ ucfirst($level) }}
                                </button>
                                
                                <button @click="resetPractice" type="button" class="px-6 py-2.5 bg-white text-gray-700 font-medium rounded-xl border border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition flex items-center gap-2 shadow-sm">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Refresh Ulang
                                </button>

                                <div class="w-full">
                                    <p x-show="selectedLessons.length === 0 || !selectedLevel || !selectedVocabTopic" class="text-sm text-amber-600 mt-2 font-medium">
                                        * Silakan pilih Topik Grammar, Level CEFR, dan Topik Kosakata terlebih dahulu.
                                    </p>
                                </div>
                            </div>

                            <div x-show="error" x-text="error" class="p-4 mb-6 bg-red-50 text-red-600 rounded-xl hidden" :class="{'hidden': !error}"></div>

                            <!-- Generated Output -->
                            <div x-show="output.sentences && output.sentences.length > 0 || output.paragraph" class="space-y-6 hidden" :class="{'hidden': !output.sentences && !output.paragraph}">
                                <div x-show="output.sentences && output.sentences.length > 0">
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">10 Kalimat Terjemahan</h3>
                                    <div class="space-y-4">
                                        <template x-for="(sentence, index) in output.sentences" :key="index">
                                            <div class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-teal-200 space-y-3 overflow-visible">
                                                <div class="flex items-start gap-3 sm:gap-4">
                                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-bold shrink-0" x-text="index + 1">
                                                    </div>
                                                    <div class="pt-1 flex-1">
                                                        <p class="text-gray-800 leading-relaxed" x-text="sentence.id"></p>
                                                    </div>
                                                </div>
                                                <div class="ml-11 sm:ml-13">
                                                    <div class="flex gap-2 items-start">
                                                        <div class="flex-1">
                                                            <div class="relative">
                                                                <input type="text"
                                                                       x-model="sentence.answer"
                                                                       @input="saveState()"
                                                                       :disabled="sentence.submitted"
                                                                       placeholder="Tulis bahasa Inggrisnya di sini..."
                                                                       class="w-full px-3 py-2.5 pr-10 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-white hover:border-gray-400 disabled:bg-gray-100 disabled:text-gray-500">
                                                                <button @click="sentence.answer = ''; sentence.submitted = false; sentence.evaluation = ''; saveState()" 
                                                                        title="Refresh/Ulangi Latihan Ini"
                                                                        class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-teal-600 transition focus:outline-none bg-transparent">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                                </button>
                                                            </div>
                                                            
                                                            <div x-show="sentence.submitted" x-transition class="mt-2 p-3 bg-teal-50/50 border border-teal-100 rounded-lg">
                                                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Evaluasi Jawaban</p>
                                                                <p class="text-sm mt-1" x-html="sentence.evaluation"></p>
                                                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-3">Kunci Jawaban</p>
                                                                <p class="text-teal-800 text-sm mt-1 font-medium" x-text="sentence.en"></p>
                                                                
                                                                <div class="mt-3 pt-3 border-t border-teal-200/50">
                                                                    <p class="text-xs font-bold text-teal-600 uppercase tracking-wider flex items-center gap-1">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                        Penjelasan AI
                                                                    </p>
                                                                    <div x-show="sentence.isExplaining" class="mt-2 flex items-center gap-2 text-sm text-teal-600">
                                                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                                        Sedang menganalisis jawaban...
                                                                    </div>
                                                                    <p x-show="!sentence.isExplaining && sentence.ai_explanation" class="text-sm text-gray-700 mt-1 leading-relaxed" x-text="sentence.ai_explanation"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button @click="submitAnswer(sentence)" 
                                                                x-show="!sentence.submitted"
                                                                class="px-4 py-2.5 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition shadow-sm shrink-0">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="mt-8 rounded-2xl border border-green-200 bg-green-50/40 p-4 sm:p-5 space-y-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <h4 class="text-lg font-bold text-gray-800">
                                            @if($level === 'all')
                                            2 Paragraf Latihan Menulis (IELTS Academic Task 2)
                                            @else
                                            Latihan Paragraf
                                            @endif
                                        </h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Terjemahkan paragraf berikut ke dalam Bahasa Inggris.</p>

                                    <p class="whitespace-pre-wrap text-base md:text-lg leading-relaxed text-gray-800 bg-white border border-gray-200 rounded-xl p-5" x-text="output.paragraph?.id">
                                    </p>

                                    <div class="relative">
                                        <textarea
                                            x-model="output.paragraph.answer"
                                            @input="saveState()"
                                            :disabled="output.paragraph?.submitted"
                                            rows="{{ $level === 'all' ? '12' : '6' }}"
                                            class="w-full p-4 pr-12 border border-gray-300 rounded-lg text-base md:text-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white disabled:bg-gray-100 disabled:text-gray-500"
                                            placeholder="Tulis terjemahan paragraf di sini..."></textarea>
                                        <button @click="output.paragraph.answer = ''; output.paragraph.submitted = false; output.paragraph.evaluation = ''; saveState()" 
                                                title="Refresh/Ulangi Latihan Ini"
                                                class="absolute right-3 top-4 p-1.5 text-gray-400 hover:text-green-600 transition focus:outline-none bg-transparent">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        </button>
                                    </div>

                                    <div class="flex justify-end gap-2" x-show="!output.paragraph?.submitted">
                                        <button @click="submitAnswer(output.paragraph)" 
                                                class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition shadow-sm">
                                            Submit
                                        </button>
                                    </div>

                                    <div x-show="output.paragraph?.submitted" x-transition class="mt-2 p-4 bg-white border border-green-200 rounded-xl">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Evaluasi Jawaban</p>
                                        <p class="text-sm mt-1 leading-relaxed" x-html="output.paragraph?.evaluation"></p>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-4">Kunci Jawaban</p>
                                        <p class="text-green-800 text-sm mt-1 leading-relaxed font-medium" x-text="output.paragraph?.en"></p>
                                        
                                        <div class="mt-4 pt-4 border-t border-green-100">
                                            <p class="text-xs font-bold text-green-600 uppercase tracking-wider flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Penjelasan AI
                                            </p>
                                            <div x-show="output.paragraph?.isExplaining" class="mt-2 flex items-center gap-2 text-sm text-green-600">
                                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Sedang menganalisis jawaban...
                                            </div>
                                            <p x-show="!output.paragraph?.isExplaining && output.paragraph?.ai_explanation" class="text-sm text-gray-700 mt-1 leading-relaxed" x-text="output.paragraph?.ai_explanation"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Lesson Explanation Modal -->
                        <template x-teleport="body">
                            <div x-show="showLessonExplanation" style="display: none;"
                                 class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-4 z-[100]"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0">
                                <div @click.outside="showLessonExplanation = false"
                                     class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-4xl w-full max-h-[90vh] flex flex-col transform transition-all"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">
                                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                                        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                            <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            Penjelasan Materi
                                        </h3>
                                        <button @click="showLessonExplanation = false" class="text-gray-400 hover:text-gray-600 focus:outline-none bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="overflow-y-auto flex-1 pr-2 prose prose-emerald max-w-none">
                                        <div x-show="isExplainingLesson" class="flex flex-col items-center justify-center py-12 text-gray-500">
                                            <svg class="animate-spin h-10 w-10 text-emerald-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            <p class="text-lg font-medium">AI sedang menyusun penjelasan materi untuk Anda...</p>
                                        </div>
                                        <div x-show="!isExplainingLesson" x-html="lessonExplanationHtml"></div>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- Include Marked.js for markdown parsing -->
                    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

                    <script>
                        function practiceAI() {
                            return {
                                apiKey: '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',
                                isGenerating: false,
                                error: null,
                                output: {},
                                introTopics: {!! $introTopics->toJson() !!},
                                availableLessons: {!! $availableTopics->toJson() !!},
                                selectedLessons: {!! $level === 'all' ? $availableTopics->toJson() : '[]' !!},
                                levels: ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'],
                                selectedLevel: '',
                                vocabTopics: ['Education', 'Business', 'Technology', 'Environment', 'Health', 'Science', 'Economy', 'History', 'Social', 'Geography', 'Random'],
                                selectedVocabTopic: '',
                                showTopics: {{ $level === 'all' ? 'false' : 'true' }},
                                showLessonExplanation: false,
                                isExplainingLesson: false,
                                lessonExplanationHtml: '',
                                init() {
                                    this.loadState();
                                },
                                saveState() {
                                    localStorage.setItem('practice_state_{{ $level }}', JSON.stringify({
                                        selectedLessons: this.selectedLessons,
                                        selectedLevel: this.selectedLevel,
                                        selectedVocabTopic: this.selectedVocabTopic,
                                        output: this.output
                                    }));
                                },
                                loadState() {
                                    const saved = localStorage.getItem('practice_state_{{ $level }}');
                                    if (saved) {
                                        try {
                                            const parsed = JSON.parse(saved);
                                            if (parsed.output && parsed.output.sentences) {
                                                this.selectedLessons = parsed.selectedLessons && parsed.selectedLessons.length > 0 ? parsed.selectedLessons : {!! $level === 'all' ? $availableTopics->toJson() : '[]' !!};
                                                this.selectedLevel = parsed.selectedLevel || '';
                                                this.selectedVocabTopic = parsed.selectedVocabTopic || '';
                                                this.output = parsed.output;
                                            }
                                        } catch (e) {
                                            console.error("Failed to parse saved state", e);
                                        }
                                    }
                                },
                                resetPractice() {
                                    this.output = {};
                                    this.selectedLessons = {!! $level === 'all' ? $availableTopics->toJson() : '[]' !!};
                                    this.selectedLevel = '';
                                    this.selectedVocabTopic = '';
                                    this.error = null;
                                    localStorage.removeItem('practice_state_{{ $level }}');
                                },
                                async submitAnswer(item) {
                                    if(!item.answer || item.answer.trim() === '') { 
                                        alert('Jawaban tidak boleh kosong. Silakan tulis terjemahan Anda terlebih dahulu.'); 
                                        return; 
                                    }
                                    
                                    item.evaluation = this.evaluateAnswer(item.answer, item.en);
                                    item.submitted = true;
                                    item.isExplaining = true;
                                    item.ai_explanation = '';
                                    this.saveState();

                                    try {
                                        const topicsList = this.selectedLessons.length > 0 ? this.selectedLessons.join(', ') : 'All Lessons';
                                        const prompt = `Anda adalah guru bahasa Inggris yang ramah dan ahli grammar.
Topik Grammar yang sedang dipelajari: ${topicsList}
Level: ${this.selectedLevel}

Soal (Kalimat Indonesia): ${item.id}
Kunci Jawaban Benar (Inggris): ${item.en}
Jawaban Murid: ${item.answer}

TUGAS:
Bandingkan jawaban murid dengan kunci jawaban. Berikan penjelasan singkat (maksimal 2-3 kalimat) dalam bahasa Indonesia tentang:
1. Kesalahan murid (jika ada salah struktur/grammar, atau pemilihan kata yang kurang pas).
2. Mengapa kunci jawaban benar berdasarkan aturan grammar topik yang sedang dipelajari.

Jika jawaban murid 100% benar dan natural, berikan pujian singkat dan jelaskan secara ringkas mengapa kalimat tersebut benar secara struktur.`;
                                        
                                        const response = await fetch('https://api.groq.com/openai/v1/chat/completions', {
                                            method: 'POST',
                                            headers: { 
                                                'Content-Type': 'application/json',
                                                'Authorization': 'Bearer ' + this.apiKey
                                            },
                                            body: JSON.stringify({
                                                model: 'llama-3.3-70b-versatile',
                                                messages: [{ role: 'user', content: prompt }],
                                                temperature: 0.5
                                            })
                                        });

                                        if (!response.ok) {
                                            throw new Error('API Error');
                                        }
                                        
                                        const data = await response.json();
                                        item.ai_explanation = data.choices[0].message.content;
                                    } catch (e) {
                                        item.ai_explanation = "Gagal memuat penjelasan dari AI. Silakan periksa koneksi Anda atau coba lagi nanti.";
                                    } finally {
                                        item.isExplaining = false;
                                        this.saveState();
                                    }
                                },
                                async generateLessonExplanation() {
                                    if (this.selectedLessons.length === 0) {
                                        alert("Silakan pilih topik grammar (Lesson) terlebih dahulu pada bagian 'Topik Grammar Pokok'.");
                                        return;
                                    }
                                    
                                    this.showLessonExplanation = true;
                                    this.isExplainingLesson = true;
                                    this.lessonExplanationHtml = '';
                                    
                                    try {
                                        const topicsList = this.selectedLessons.includes('All Lessons') ? 'Semua Topik Grammar secara umum' : this.selectedLessons.join(', ');
                                        const prompt = `Anda adalah instruktur bahasa Inggris profesional. Tugas Anda adalah memberikan ringkasan materi untuk topik grammar: **${topicsList}**.
Penjelasan harus dalam bahasa Indonesia yang sistematis, sangat rapi, dan mudah dipahami.

ATURAN FORMATTING:
1. GUNAKAN MARKDOWN YANG RAPI DAN CANTIK.
2. Pisahkan judul materi dengan Heading 3 (###) atau Heading 4 (####).
3. Buat paragraf yang terstruktur dengan baik.
4. Gunakan bullet points (- atau *) untuk daftar rumus atau contoh kalimat.
5. Beri cetak tebal (**) pada rumus atau istilah penting.
6. Berikan contoh kalimat Bahasa Inggris beserta terjemahannya (dalam kurung).`;
                                        
                                        const response = await fetch('https://api.groq.com/openai/v1/chat/completions', {
                                            method: 'POST',
                                            headers: { 
                                                'Content-Type': 'application/json',
                                                'Authorization': 'Bearer ' + this.apiKey
                                            },
                                            body: JSON.stringify({
                                                model: 'llama-3.3-70b-versatile',
                                                messages: [{ role: 'user', content: prompt }],
                                                temperature: 0.5
                                            })
                                        });

                                        if (!response.ok) throw new Error('API Error');
                                        
                                        const data = await response.json();
                                        // Parse markdown output nicely with marked.js
                                        let markdownContent = data.choices[0].message.content;
                                        if (typeof marked !== 'undefined') {
                                            this.lessonExplanationHtml = marked.parse(markdownContent);
                                        } else {
                                            this.lessonExplanationHtml = markdownContent.replace(/\n/g, '<br>');
                                        }
                                    } catch (e) {
                                        this.lessonExplanationHtml = '<p class="text-red-500 font-medium">Maaf, terjadi kesalahan saat memuat penjelasan materi. Silakan periksa koneksi Anda atau coba lagi nanti.</p>';
                                    } finally {
                                        this.isExplainingLesson = false;
                                    }
                                },
                                async generateQuestions() {
                                    this.isGenerating = true;
                                    this.error = null;
                                    this.output = {};

                                    let kbContext = "";
                                    try {
                                        let words = [];
                                        let collocations = [];
                                        let patterns = [];
                                        
                                        // Load level examples
                                        if (this.selectedLevel) {
                                            const levelRes = await fetch(`/knowledge/levels/${this.selectedLevel}.json`);
                                            if (levelRes.ok) {
                                                const levelData = await levelRes.json();
                                                kbContext += `\nCONTOH KALIMAT LEVEL ${this.selectedLevel} (Jadikan patokan gaya bahasa):\n- ` + levelData.join("\n- ") + "\n";
                                            }
                                        }

                                        // Load academic words
                                        const acRes = await fetch('/knowledge/academic_words.json');
                                        if (acRes.ok) {
                                            const acData = await acRes.json();
                                            words.push(...acData.sort(() => 0.5 - Math.random()).slice(0, 10)); // sample 10 words
                                        }

                                        // Load topic vocab
                                        if (this.selectedVocabTopic) {
                                            let topicToLoad = this.selectedVocabTopic.toLowerCase();
                                            if (topicToLoad === 'random') {
                                                const availableTopics = ['education', 'business', 'technology', 'environment', 'health'];
                                                topicToLoad = availableTopics[Math.floor(Math.random() * availableTopics.length)];
                                            }
                                            const topicRes = await fetch(`/knowledge/topics/${topicToLoad}.json`);
                                            if (topicRes.ok) {
                                                const topicData = await topicRes.json();
                                                words.push(...topicData.sort(() => 0.5 - Math.random()).slice(0, 10));
                                                kbContext += `\nTEMA KOSAKATA UTAMA: ${topicToLoad.toUpperCase()}\n`;
                                            }
                                        }

                                        // Load collocations
                                        const colRes = await fetch('/knowledge/collocations.json');
                                        if (colRes.ok) {
                                            const colData = await colRes.json();
                                            collocations.push(...colData.sort(() => 0.5 - Math.random()).slice(0, 5));
                                        }

                                        // Load patterns
                                        const patRes = await fetch('/knowledge/sentence_patterns.json');
                                        if (patRes.ok) {
                                            const patData = await patRes.json();
                                            patterns.push(...patData.sort(() => 0.5 - Math.random()).slice(0, 5));
                                        }

                                        kbContext += `\nGUNAKAN KOSAKATA & KOLOKASI BERIKUT JIKA MEMUNGKINKAN:\nVocabulary: ${words.join(', ')}\nCollocations: ${collocations.join(', ')}\n\nCONTOH POLA KALIMAT:\n- ${patterns.join('\n- ')}\n`;

                                    } catch (err) {
                                        console.error("Failed to load knowledge base", err);
                                    }

                                    // Default to 'All Lessons' if empty
                                    let activeLessons = this.selectedLessons.length > 0 ? this.selectedLessons : ['All Lessons'];
                                    
                                    // If 'All Lessons' is selected alongside others, just use 'All Lessons'
                                    if (activeLessons.includes('All Lessons')) {
                                        activeLessons = ['All Lessons'];
                                    }
                                    
                                    const topicsList = activeLessons.join(', ');
                                    const levelStr = this.selectedLevel ? this.selectedLevel : 'Introductory';
                                    
                                    // Collect custom grammar rules from DB
                                    let customRules = "";
                                    if (this.introTopics && this.introTopics.length > 0) {
                                        const selectedRules = this.introTopics
                                            .filter(t => activeLessons.includes(t.topic) && t.grammar_rules && t.grammar_rules.trim() !== '')
                                            .map(t => `- Aturan untuk "${t.topic}": ${t.grammar_rules}`);
                                        if (selectedRules.length > 0) {
                                            customRules = `\n\nATURAN GRAMMAR KHUSUS DARI DATABASE:\n${selectedRules.join('\n')}`;
                                        }
                                    }
                                    
                                    let prompt = "";
                                    if ('{{ $level }}' === 'all') {
                                        prompt = `Anda adalah instruktur IELTS dan Grammar bahasa Inggris yang sangat ketat dan presisi.

TUGAS: Buatkan 10 kalimat latihan terjemahan (Bahasa Indonesia → Bahasa Inggris) dan 2 paragraf berkesinambungan (seperti Body Paragraph 1 dan Body Paragraph 2 pada IELTS Academic Writing Task 2), KHUSUS untuk topik grammar: **${topicsList}**.${customRules}

==============================================================
ATURAN MUTLAK YANG TIDAK BOLEH DILANGGAR SAMA SEKALI:
==============================================================

1. HANYA BOLEH menggunakan SATU struktur grammar utama: **${topicsList}**.
   - Setiap kalimat, baik di bagian latihan kalimat maupun paragraf, WAJIB memuat struktur grammar tersebut.
   - Paragraf ini harus bernada akademis, argumentatif, dan memiliki linking words (transisi) yang sangat baik ala IELTS.

2. ATURAN PANJANG PARAGRAF (SANGAT PENTING):
   - SETIAP paragraf WAJIB terdiri dari MINIMAL 5 KALIMAT.
   - Struktur per paragraf harus mengikuti standar IELTS: Topic Sentence, Explanation, Example, Result/Further detail, dan Concluding sentence.
   - Jangan membuat paragraf yang terlalu singkat. 

3. KHUSUS TINGKAT LATIHAN SAAT INI (ALL):
   Gunakan struktur kalimat kompleks dengan academic vocabulary tingkat tinggi (C1/C2).
   Berikan contoh konkret di dalam paragraf untuk mendukung argumen.

4. ATURAN TAMBAHAN:
   - Kalimat dan Paragraf Bahasa Indonesia harus terasa ALAMI dan akademis.
   - Terjemahan Bahasa Inggris harus menggunakan struktur IELTS Academic band 7.5+.
   - Hindari pengulangan pola yang sama persis di setiap kalimat latihan.

${kbContext}

==============================================================
FORMAT OUTPUT (JSON murni tanpa markdown):
==============================================================
{
  "sentences": [
    {"id": "Kalimat Indonesia 1", "en": "English sentence 1"},
    {"id": "Kalimat Indonesia 2", "en": "English sentence 2"}
  ],
  "paragraph": {
    "id": "Tulis 2 paragraf bahasa Indonesia di sini. Gunakan \\n\\n sebagai pemisah antar paragraf.",
    "en": "English translation 2 paragraphs here. Use \\n\\n for paragraph breaks."
  }
}`;
                                    } else {
                                        prompt = `Anda adalah instruktur grammar bahasa Inggris yang sangat ketat dan presisi.

TUGAS: Buatkan 10 kalimat latihan terjemahan (Bahasa Indonesia → Bahasa Inggris) dan 1 paragraf (6 kalimat), KHUSUS untuk topik: **${topicsList}**.${customRules}

==============================================================
ATURAN MUTLAK YANG TIDAK BOLEH DILANGGAR SAMA SEKALI:
==============================================================

1. HANYA BOLEH menggunakan SATU struktur grammar utama: **${topicsList}**.
   - Setiap kalimat WAJIB menunjukkan struktur grammar tersebut secara eksplisit.
   - DILARANG KERAS menggunakan struktur grammar LAIN yang tidak termasuk dalam topik "${topicsList}".
   - Contoh TERLARANG jika topiknya adalah "Modal":
     * DILARANG menggunakan Gerund (V-ing sebagai noun, contoh: "dengan menggunakan", "by using", "swimming is...")
     * DILARANG menggunakan To-Infinitive sebagai fokus kalimat (contoh: "to study is...", "I want to go...")
     * DILARANG menggunakan kalimat Conditional kompleks
     * DILARANG menggunakan Present Perfect (have/has + V3) kecuali topiknya memang itu
   - Contoh BENAR jika topiknya adalah "Modal":
     * Gunakan HANYA modal auxiliary: can, could, will, would, shall, should, may, might, must, ought to
     * Struktur: Subjek + Modal + Verb dasar (V1)
     * Contoh: "Anda dapat meningkatkan kemampuan belajar." → "You can improve your learning ability."
     * Contoh: "Mereka harus mematuhi peraturan tersebut." → "They must comply with the regulation."

2. CAKUPAN STRUKTUR berdasarkan topik yang dipilih:
   - Jika "Modal" → WAJIB: S + Modal (can/could/will/would/shall/should/may/might/must) + V1. Boleh ada objek/keterangan setelah V1 tapi TANPA Gerund atau Infinitive sebagai pelengkap
   - Jika "Gerund" → WAJIB: V-ing digunakan sebagai noun (subjek/objek). DILARANG Modal
   - Jika "To Infinitive" → WAJIB: to + V1 sebagai tujuan/fungsi. DILARANG Gerund
   - Jika "Simple Present Verbal" → WAJIB: S + V1(s/es). DILARANG: Modal, Perfect, Continuous
   - Jika "Simple Present Nominal" → WAJIB: S + to be (is/am/are) + Noun/Adj/Adv. DILARANG action verb
   - Jika "Present Continuous" → WAJIB: S + is/am/are + V-ing
   - Jika "Simple Past Tense" → WAJIB: S + V2. DILARANG: Modal, Present tense
   - Jika "Present Perfect" → WAJIB: S + have/has + V3
   - Jika topik lain → ikuti struktur yang sesuai dengan nama topiknya

3. TINGKAT KESULITAN KOSAKATA: ${levelStr} (CEFR). Sesuaikan kompleksitas kosakata dengan level ini.

4. KHUSUS TINGKAT LATIHAN SAAT INI:
   @if($level === 'introductory')
   Semua 10 kalimat WAJIB berupa KALIMAT TUNGGAL (1 klausa). DILARANG menggunakan kata hubung seperti "karena", "dan", "tetapi", "meskipun", "sehingga", "ketika", dll.
   @elseif($level === 'complexity')
   Kalimat sebaiknya berupa KALIMAT MAJEMUK ATAU KOMPLEKS (Compound/Complex Sentences) yang menunjukkan tingkat kerumitan (complexity) sesuai topik.
   @else
   Gunakan variasi kalimat yang sesuai dengan tingkat kemahiran (proficiency).
   @endif

5. ATURAN TAMBAHAN:
   - Kalimat Bahasa Indonesia harus terasa ALAMI dan tidak kaku
   - Terjemahan Bahasa Inggris harus NATURAL & benar secara grammar
   - Hindari pengulangan kata atau pola yang sama di 10 kalimat
   - Hindari pola "dengan menggunakan" jika topiknya bukan Gerund

${kbContext}

==============================================================
FORMAT OUTPUT (JSON murni tanpa markdown):
==============================================================
{
  "sentences": [
    {"id": "Kalimat Indonesia 1", "en": "English sentence 1"},
    {"id": "Kalimat Indonesia 2", "en": "English sentence 2"}
  ],
  "paragraph": {
    "id": "Paragraf Indonesia di sini yang berisi 6 kalimat.",
    "en": "English translation paragraph here."
  }
}`;
                                    }

                                    try {
                                        const response = await fetch('https://api.groq.com/openai/v1/chat/completions', {
                                            method: 'POST',
                                            headers: { 
                                                'Content-Type': 'application/json',
                                                'Authorization': 'Bearer ' + this.apiKey
                                            },
                                            body: JSON.stringify({
                                                model: 'llama-3.3-70b-versatile',
                                                messages: [{ role: 'user', content: prompt }],
                                                response_format: { type: "json_object" },
                                                temperature: 0.7
                                            })
                                        });

                                        if (!response.ok) {
                                            const errorData = await response.json();
                                            throw new Error(errorData.error?.message || 'Gagal mengambil data dari API.');
                                        }

                                        const data = await response.json();
                                        const text = data.choices[0].message.content;
                                        let parsed = JSON.parse(text);
                                        
                                        if (parsed.sentences) {
                                            parsed.sentences.forEach(s => {
                                                s.answer = '';
                                                s.submitted = false;
                                                s.evaluation = '';
                                            });
                                        }
                                        if (parsed.paragraph) {
                                            parsed.paragraph.answer = '';
                                            parsed.paragraph.submitted = false;
                                            parsed.paragraph.evaluation = '';
                                        }
                                        
                                        this.output = parsed;
                                        this.saveState();
                                    } catch (err) {
                                        this.error = err.message || 'Terjadi kesalahan saat memproses data.';
                                    } finally {
                                        this.isGenerating = false;
                                    }
                                },
                                escapeHtml(unsafe) {
                                    if (!unsafe) return '';
                                    return unsafe.toString()
                                         .replace(/&/g, "&amp;")
                                         .replace(/</g, "&lt;")
                                         .replace(/>/g, "&gt;")
                                         .replace(/"/g, "&quot;")
                                         .replace(/'/g, "&#039;");
                                },
                                evaluateAnswer(userTranslation, correctAnswer) {
                                    if (!userTranslation) userTranslation = '';
                                    const normalizeWord = (w) => w.toLowerCase().replace(/[.!,]+$/, '');
                                    const userWords = userTranslation.trim().split(/\s+/).filter(w => w);
                                    const correctWords = correctAnswer.trim().split(/\s+/).filter(w => w);
                                    
                                    let matrix = [];
                                    let userWordCount = userWords.length;
                                    let correctWordCount = correctWords.length;

                                    for (let i = 0; i <= userWordCount; i++) {
                                        matrix[i] = [];
                                        matrix[i][0] = 0;
                                    }
                                    for (let j = 0; j <= correctWordCount; j++) {
                                        matrix[0][j] = 0;
                                    }

                                    for (let i = 1; i <= userWordCount; i++) {
                                        for (let j = 1; j <= correctWordCount; j++) {
                                            let uWord = normalizeWord(userWords[i - 1]);
                                            let cWord = normalizeWord(correctWords[j - 1]);
                                            if (uWord === cWord) {
                                                matrix[i][j] = matrix[i - 1][j - 1] + 1;
                                            } else {
                                                matrix[i][j] = Math.max(matrix[i - 1][j], matrix[i][j - 1]);
                                            }
                                        }
                                    }

                                    let diff = [];
                                    let i = userWordCount;
                                    let j = correctWordCount;

                                    while (i > 0 || j > 0) {
                                        if (i > 0 && j > 0) {
                                            let uWord = normalizeWord(userWords[i - 1]);
                                            let cWord = normalizeWord(correctWords[j - 1]);
                                            if (uWord === cWord) {
                                                diff.unshift({ type: 'match', word: userWords[i - 1] });
                                                i--; j--;
                                                continue;
                                            }
                                        }

                                        if (j > 0 && (i === 0 || matrix[i][j - 1] >= matrix[i - 1][j])) {
                                            diff.unshift({ type: 'missing', word: correctWords[j - 1] });
                                            j--;
                                        } else if (i > 0 && (j === 0 || matrix[i][j - 1] < matrix[i - 1][j])) {
                                            diff.unshift({ type: 'extra', word: userWords[i - 1] });
                                            i--;
                                        }
                                    }

                                    let finalOutput = [];
                                    for (let k = 0; k < diff.length; k++) {
                                        let current = diff[k];
                                        let next = (k + 1 < diff.length) ? diff[k + 1] : null;

                                        if (current.type === 'extra' && next && next.type === 'missing') {
                                            finalOutput.push('<span class="text-red-500 line-through">' + this.escapeHtml(current.word) + '</span>');
                                            finalOutput.push('<span class="text-green-600 font-bold">' + this.escapeHtml(next.word) + '</span>');
                                            k++;
                                        } else if (current.type === 'match') {
                                            finalOutput.push('<span class="text-green-600">' + this.escapeHtml(current.word) + '</span>');
                                        } else if (current.type === 'extra') {
                                            finalOutput.push('<span class="text-red-500 line-through">' + this.escapeHtml(current.word) + '</span>');
                                        } else if (current.type === 'missing') {
                                            finalOutput.push('<span class="text-green-600 font-bold">' + this.escapeHtml(current.word) + '</span>');
                                        }
                                    }

                                    return finalOutput.join(' ');
                                }
                            }
                        }
                    </script>
                @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-teal-100 p-12 flex flex-col items-center justify-center min-h-[400px]">
                    <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada latihan</h3>
                    <p class="text-gray-500 text-center max-w-md">Latihan untuk tingkat ini sedang dalam tahap persiapan. Silakan kembali lagi nanti.</p>
                </div>
                @endif
        </main>
    </div>

    @include('assignments.ielts.writing.practice_toolbar', [
        'meeting' => (object)['task_type' => 3, 'prompt' => 'Grammar Practice: Latihan terjemahan kalimat bahasa Indonesia ke Inggris sesuai tata bahasa yang dipilih.'],
        'grammarLevel' => $level
    ])

    @include('components.student-broadcaster')
</body>
</html>
