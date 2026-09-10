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
        .prose h1,
        .prose h2,
        .prose h3,
        .prose h4,
        .prose h5,
        .prose h6 {
            color: #111827;
            font-weight: 700;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            line-height: 1.3;
        }

        .prose h3 {
            font-size: 1.5rem;
        }

        .prose h4 {
            font-size: 1.25rem;
        }

        .prose p {
            margin-top: 1em;
            margin-bottom: 1em;
            line-height: 1.75;
            color: #374151;
        }

        .prose ul {
            list-style-type: disc;
            padding-left: 1.625em;
            margin-top: 1em;
            margin-bottom: 1em;
        }

        .prose ol {
            list-style-type: decimal;
            padding-left: 1.625em;
            margin-top: 1em;
            margin-bottom: 1em;
        }

        .prose li {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            color: #374151;
        }

        .prose li::marker {
            color: #9ca3af;
        }

        .prose strong {
            font-weight: 700;
            color: #111827;
        }

        .prose blockquote {
            border-left-width: 4px;
            border-color: #e5e7eb;
            padding-left: 1em;
            font-style: italic;
            color: #4b5563;
            margin-top: 1.6em;
            margin-bottom: 1.6em;
        }

        .prose code {
            color: #111827;
            background-color: #f3f4f6;
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            font-size: 0.875em;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-teal-50 via-cyan-50 to-emerald-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @auth
            @if(Auth::user()->isAdmin())
                @include('components.sidebar-admin')
            @elseif(Auth::user()->isTeacher())
                @include('components.sidebar-teacher')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endauth

        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-end mb-3">
                    <a href="{{ route('assignments.grammar-writing.practice') }}"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200 text-xs sm:text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back</span>
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <div
                        class="p-2.5 sm:p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1
                            class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent break-words">
                            {{ $title }}
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1 break-words">{{ $desc }}</p>
                    </div>
                </div>
            </div>

            @if(in_array($level, ['introductory', 'complexity', 'proficiency', 'all']))
                <div x-data="practiceAI()" @open-lesson-explanation.window="generateLessonExplanation()" class="space-y-6">

                    {{-- ============================================================ --}}
                    {{-- ADMIN ONLY: Manage Grammar Topics Panel --}}
                    {{-- ============================================================ --}}
                    @if(Auth::user()?->isAdmin())
                        <div x-data="introTopicAdmin()"
                            class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden">
                            <!-- Collapsible Header -->
                            <button @click="open = !open" type="button"
                                class="w-full flex items-center justify-between px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-white0 rounded-lg shadow-sm">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-amber-900">Admin: Kelola Topik Grammar
                                            {{ ucfirst($level) }}
                                        </h3>
                                        <p class="text-xs text-amber-600">Klik untuk buka/tutup panel pengeditan topik AI
                                            Generator</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-amber-600 transition-transform duration-200"
                                    :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition class="p-6" style="display:none;">
                                <!-- Actions Bar -->
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-sm text-gray-600">Total: <strong x-text="topics.length"></strong> topik
                                        terdaftar. Topik ini yang tampil sebagai pilihan di AI Generator.</p>
                                    <button @click="openCreate()" type="button"
                                        class="flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white text-sm rounded-xl font-medium hover:bg-teal-700 transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Topik
                                    </button>
                                </div>

                                <!-- Status message -->
                                <div x-show="statusMsg" x-text="statusMsg"
                                    class="mb-3 p-3 text-sm text-center font-medium rounded-xl"
                                    :class="statusOk ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600'"></div>

                                <!-- Topics Table -->
                                <div class="overflow-x-auto rounded-xl border border-gray-100">
                                    <table class="w-full text-sm">
                                        <thead class="bg-white text-gray-600 text-xs uppercase tracking-wider">
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
                                                <tr class="hover:bg-white transition">
                                                    <td class="px-4 py-3 text-gray-400 font-mono text-xs" x-text="idx + 1"></td>
                                                    <td class="px-4 py-3">
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-white text-indigo-700"
                                                            x-text="topic.label"></span>
                                                    </td>
                                                    <td class="px-4 py-3 font-semibold text-gray-800" x-text="topic.topic"></td>
                                                    <td class="px-4 py-3 text-gray-500 text-xs max-w-xs truncate"
                                                        :title="topic.grammar_rules">
                                                        <span
                                                            x-text="topic.grammar_rules ? topic.grammar_rules.substring(0, 70) + (topic.grammar_rules.length > 70 ? '...' : '') : '—'"></span>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="flex items-center justify-center gap-1">
                                                            <button @click="openEdit(topic)" type="button"
                                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-white rounded-lg transition"
                                                                title="Edit">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                            <button @click="deleteTopic(topic)" type="button"
                                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                                title="Hapus">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr x-show="topics.length === 0">
                                                <td colspan="5" class="px-4 py-8 text-center text-gray-400 italic">Belum ada
                                                    topik tersimpan. Klik "Tambah Topik" atau muat ulang halaman untuk mengisi
                                                    dari data default.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Edit/Create Modal (rendered outside collapsed area) -->
                            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                style="display:none;" @keydown.escape.window="showModal = false">
                                <div class="absolute inset-0 bg-black/50" @click="showModal = false"></div>
                                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden z-10"
                                    x-transition>
                                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                                        <h3 class="text-lg font-bold text-gray-900"
                                            x-text="isCreating ? 'Tambah Topik Grammar Baru' : 'Edit Topik Grammar'"></h3>
                                        <button @click="showModal = false" type="button"
                                            class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <form @submit.prevent="submitForm" class="px-6 py-5 space-y-4">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Label <span
                                                        class="text-xs text-gray-400">(mis: 8a)</span></label>
                                                <input type="text" x-model="form.label"
                                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                                                    placeholder="8a" required>
                                            </div>
                                            <div class="col-span-2">
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Topik</label>
                                                <input type="text" x-model="form.topic"
                                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                                                    placeholder="mis: Modal, Gerund, Simple Past Tense" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                                Aturan Grammar untuk AI
                                                <span class="text-xs font-normal text-gray-400 ml-1">(Opsional — akan disertakan
                                                    dalam prompt AI sebagai aturan tambahan)</span>
                                            </label>
                                            <textarea x-model="form.grammar_rules" rows="4"
                                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                                placeholder="Contoh: Wajib menggunakan modal auxiliary (can/could/will/would/shall/should/may/might/must). Struktur: S + Modal + V1. DILARANG Gerund atau To-Infinitive."></textarea>
                                        </div>
                                        <div class="flex justify-end gap-3 pt-2">
                                            <button type="button" @click="showModal = false"
                                                class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-white transition">Batal</button>
                                            <button type="submit" :disabled="isSaving"
                                                class="px-5 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition shadow-sm disabled:opacity-50">
                                                <span x-show="!isSaving"
                                                    x-text="isCreating ? 'Tambahkan' : 'Simpan Perubahan'"></span>
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
                                        } catch (e) {
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
                                        } catch (e) {
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                        </path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">AI Generator</h2>
                            </div>
                            <p class="text-gray-600 mb-8 leading-relaxed text-sm md:text-base">
                                @if($level === 'all')
                                    Sistem pintar kami siap membantu Anda! Pilih topik grammar di bawah ini, lalu AI akan
                                    menyusun <strong>10 kalimat latihan dan 2 paragraf argumentatif bergaya IELTS Academic Task
                                        2</strong> yang disesuaikan khusus untuk melatih penguasaan topik grammar Anda.
                                @else
                                    Sistem pintar kami siap membantu Anda! Pilih topik grammar dan tingkat kesulitan kosakata di
                                    bawah ini, lalu AI akan menyusun <strong>10 kalimat latihan terjemahan</strong> dan
                                    <strong>1 paragraf cerita</strong> yang disesuaikan khusus untuk Anda.
                                @endif
                            </p>

                            <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="bg-gradient-to-b from-gray-50 to-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                                    <div class="flex items-center justify-between gap-2 mb-4 cursor-pointer"
                                        @click="showTopics = !showTopics">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                </path>
                                            </svg>
                                            <label class="block text-sm font-bold text-gray-800 cursor-pointer">Topik
                                                Grammar Pokok</label>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                            :class="{'rotate-180': showTopics}" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                    <div x-show="showTopics" x-transition>
                                        <p class="text-xs text-gray-500 mb-4">Pilih satu atau lebih topik grammar yang ingin
                                            difokuskan pada latihan ini.</p>

                                        <div
                                            class="flex flex-wrap gap-2 max-h-52 overflow-y-auto pr-2 custom-scrollbar bg-white p-3 rounded-xl border border-gray-100">
                                            <!-- All Lessons Checkbox (Select All / Deselect All) -->
                                            <label
                                                class="inline-flex items-center gap-2 cursor-pointer group px-3 py-1.5 rounded-full border border-gray-200 hover:border-indigo-300 hover:bg-white transition"
                                                :class="{'bg-white border-indigo-300': selectedLessons.length === availableLessons.length}">
                                                <input type="checkbox"
                                                    :checked="selectedLessons.length === availableLessons.length"
                                                    @click="if (selectedLessons.length === availableLessons.length) { selectedLessons = []; } else { selectedLessons = [...availableLessons]; }"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition duration-200">
                                                <span
                                                    class="text-sm text-gray-800 group-hover:text-indigo-700 transition font-bold whitespace-nowrap">Semua
                                                    Topik (All Lessons)</span>
                                            </label>

                                            <template x-for="lesson in availableLessons" :key="lesson">
                                                <label
                                                    class="inline-flex items-center gap-2 cursor-pointer group px-3 py-1.5 rounded-full border border-gray-200 hover:border-indigo-300 hover:bg-white transition"
                                                    :class="{'bg-white border-indigo-300': selectedLessons.includes(lesson)}">
                                                    <input type="checkbox" :value="lesson" x-model="selectedLessons"
                                                        class="w-4 h-4 text-indigo-500 border-gray-300 rounded focus:ring-indigo-500 transition duration-200">
                                                    <span
                                                        class="text-sm text-gray-700 group-hover:text-gray-900 transition font-medium whitespace-nowrap"
                                                        x-text="lesson"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Level Selection & Vocab Topic Card -->
                                <div
                                    class="bg-gradient-to-b from-gray-50 to-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition duration-300 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                </path>
                                            </svg>
                                            <label class="block text-sm font-bold text-gray-800">Tingkat Kesulitan Kosa
                                                Kata</label>
                                        </div>
                                        <div class="relative">
                                            <select x-model="selectedLevel"
                                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm py-2.5 bg-white appearance-none pr-10">
                                                <option value="">Pilih Level Kosa Kata (CEFR)...</option>
                                                <template x-for="lvl in levels" :key="lvl">
                                                    <option :value="lvl" x-text="lvl"></option>
                                                </template>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Pilih A1 untuk pemula, hingga C1 untuk tingkat mahir.
                                        </p>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                            <label class="block text-sm font-bold text-gray-800">Tema / Konteks
                                                Pembahasan</label>
                                        </div>
                                        <div class="relative">
                                            <select x-model="selectedVocabTopic"
                                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5 bg-white appearance-none pr-10">
                                                <option value="">Pilih Topik Kosakata...</option>
                                                <template x-for="topic in vocabTopics" :key="topic">
                                                    <option :value="topic" x-text="topic"></option>
                                                </template>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6 flex flex-wrap items-center gap-3">
                                <button @click="generateQuestions"
                                    :disabled="isGenerating || selectedLessons.length === 0 || !selectedLevel || !selectedVocabTopic"
                                    :class="{
                                                                'opacity-50 cursor-not-allowed pointer-events-none bg-gray-300 text-gray-500 shadow-none': isGenerating || selectedLessons.length === 0 || !selectedLevel || !selectedVocabTopic,
                                                                'bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white shadow-sm': !isGenerating && selectedLessons.length > 0 && selectedLevel && selectedVocabTopic
                                                            }"
                                    class="px-6 py-2.5 font-medium rounded-xl focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition flex items-center gap-2">
                                    <span x-show="isGenerating">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </span>
                                    Buatkan Soal {{ ucfirst($level) }}
                                </button>

                                <button @click="resetPractice" type="button"
                                    class="px-6 py-2.5 bg-white text-gray-700 font-medium rounded-xl border border-gray-300 hover:bg-white focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition flex items-center gap-2 shadow-sm">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Refresh Ulang
                                </button>

                                <div class="w-full">
                                    <p x-show="selectedLessons.length === 0 || !selectedLevel || !selectedVocabTopic"
                                        class="text-sm text-red-600 mt-2 font-semibold flex items-center gap-1.5 bg-red-50 p-3 rounded-xl border border-red-200">
                                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <span>Wajib memilih <strong>Level Kosa Kata (CEFR)</strong> dan <strong>Tema /
                                                Konteks Pembahasan</strong> terlebih dahulu sebelum membuat soal.</span>
                                    </p>
                                </div>
                            </div>

                            <div x-show="error" x-text="error" class="p-4 mb-6 bg-red-50 text-red-600 rounded-xl hidden"
                                :class="{'hidden': !error}"></div>

                            <!-- Generated Output -->
                            <div x-show="output.sentences && output.sentences.length > 0 || output.paragraph"
                                class="space-y-6 hidden" :class="{'hidden': !output.sentences && !output.paragraph}">
                                <div x-show="output.sentences && output.sentences.length > 0">
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">10 Kalimat Terjemahan</h3>
                                    <div class="space-y-4">
                                        <template x-for="(sentence, index) in output.sentences" :key="'s-' + index">
                                            <div
                                                class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-teal-200 space-y-3 overflow-visible">
                                                <div class="flex items-start gap-3 sm:gap-4">
                                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-white text-teal-700 flex items-center justify-center text-sm font-bold shrink-0"
                                                        x-text="index + 1">
                                                    </div>
                                                    <div class="pt-1 flex-1">
                                                        <p class="text-gray-800 leading-relaxed" x-text="sentence.id"></p>
                                                    </div>
                                                </div>
                                                <div class="ml-11 sm:ml-13">
                                                    <div class="flex gap-2 items-start">
                                                        <div class="flex-1">
                                                            <div class="relative">
                                                                <input type="text" x-model="sentence.answer"
                                                                    @input="saveState()"
                                                                    @keydown.enter.prevent="if(!sentence.submitted) submitAnswer(sentence)"
                                                                    :disabled="sentence.submitted"
                                                                    placeholder="Tulis bahasa Inggrisnya di sini..."
                                                                    class="w-full px-3 py-2.5 pr-10 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-white hover:border-gray-400 disabled:bg-white disabled:text-gray-500">
                                                                <button type="button"
                                                                    @click.prevent="sentence.answer = ''; sentence.submitted = false; sentence.evaluation = ''; sentence.isExplaining = false; sentence.ai_explanation = ''; saveState()"
                                                                    title="Refresh/Ulangi Latihan Ini"
                                                                    class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-teal-600 transition focus:outline-none bg-transparent">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <div x-show="sentence.submitted" x-transition
                                                                class="mt-2 p-3 bg-white border border-teal-100 rounded-lg">
                                                                <p
                                                                    class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                                    Evaluasi Jawaban</p>
                                                                <p class="text-sm mt-1" x-html="sentence.evaluation"></p>
                                                                <p
                                                                    class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-3">
                                                                    Kunci Jawaban</p>
                                                                <p class="text-teal-800 text-sm mt-1 font-medium"
                                                                    x-text="sentence.en"></p>

                                                                <div class="mt-3 pt-3 border-t border-teal-200/50">
                                                                    <p
                                                                        class="text-xs font-bold text-teal-600 uppercase tracking-wider flex items-center gap-1">
                                                                        <svg class="w-4 h-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                            </path>
                                                                        </svg>
                                                                        Penjelasan
                                                                    </p>
                                                                    <div x-show="sentence.isExplaining"
                                                                        class="mt-2 flex items-center gap-2 text-sm text-teal-600">
                                                                        <svg class="animate-spin h-4 w-4"
                                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                            viewBox="0 0 24 24">
                                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                                r="10" stroke="currentColor"
                                                                                stroke-width="4"></circle>
                                                                            <path class="opacity-75" fill="currentColor"
                                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                            </path>
                                                                        </svg>
                                                                        Sedang menganalisis jawaban...
                                                                    </div>
                                                                    <div x-show="!sentence.isExplaining && sentence.ai_explanation"
                                                                        class="text-sm text-gray-700 mt-2 p-3 bg-white/90 rounded-lg border border-teal-100/80 shadow-2xs whitespace-pre-line leading-relaxed"
                                                                        x-text="cleanAiExplanation(sentence.ai_explanation)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" @click.prevent="submitAnswer(sentence)"
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
                                    <p class="text-sm text-gray-600">Terjemahkan paragraf berikut ke dalam Bahasa Inggris.
                                    </p>

                                    <p class="whitespace-pre-wrap text-base md:text-lg leading-relaxed text-gray-800 bg-white border border-gray-200 rounded-xl p-5"
                                        x-text="output.paragraph?.id">
                                    </p>

                                    <div class="relative">
                                        <textarea x-model="output.paragraph.answer" @input="saveState()"
                                            :disabled="output.paragraph?.submitted"
                                            rows="{{ $level === 'all' ? '12' : '6' }}"
                                            class="w-full p-4 pr-12 border border-gray-300 rounded-lg text-base md:text-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white disabled:bg-white disabled:text-gray-500"
                                            placeholder="Tulis terjemahan paragraf di sini..."></textarea>
                                        <button type="button"
                                            @click.prevent="output.paragraph.answer = ''; output.paragraph.submitted = false; output.paragraph.evaluation = ''; output.paragraph.isExplaining = false; output.paragraph.ai_explanation = ''; saveState()"
                                            title="Refresh/Ulangi Latihan Ini"
                                            class="absolute right-3 top-4 p-1.5 text-gray-400 hover:text-green-600 transition focus:outline-none bg-transparent">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex justify-end gap-2" x-show="!output.paragraph?.submitted">
                                        <button type="button" @click.prevent="submitAnswer(output.paragraph)"
                                            class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition shadow-sm">
                                            Submit
                                        </button>
                                    </div>

                                    <div x-show="output.paragraph?.submitted" x-transition
                                        class="mt-2 p-4 bg-white border border-green-200 rounded-xl">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Evaluasi Jawaban
                                        </p>
                                        <p class="text-sm mt-1 leading-relaxed" x-html="output.paragraph?.evaluation"></p>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-4">Kunci
                                            Jawaban</p>
                                        <p class="text-green-800 text-sm mt-1 leading-relaxed font-medium"
                                            x-text="output.paragraph?.en"></p>

                                        <div class="mt-4 pt-4 border-t border-green-100">
                                            <p
                                                class="text-xs font-bold text-green-600 uppercase tracking-wider flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                Penjelasan
                                            </p>
                                            <div x-show="output.paragraph?.isExplaining"
                                                class="mt-2 flex items-center gap-2 text-sm text-green-600">
                                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                Sedang menganalisis jawaban...
                                            </div>
                                            <p x-show="!output.paragraph?.isExplaining && output.paragraph?.ai_explanation"
                                                class="text-sm text-gray-700 mt-1 leading-relaxed"
                                                x-text="output.paragraph?.ai_explanation"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Lesson Explanation Modal -->
                        <template x-teleport="body">
                            <div x-show="showLessonExplanation" style="display: none;"
                                class="fixed inset-0 bg-black/60 backdrop-blur-xs flex justify-center items-center p-4 z-[100]"
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div @click.outside="showLessonExplanation = false"
                                    class="bg-white rounded-2xl shadow-2xl border border-gray-100 max-w-4xl w-full max-h-[90vh] flex flex-col transform transition-all overflow-hidden"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                                    {{-- Modal Header --}}
                                    <div
                                        class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-emerald-50/70 via-white to-teal-50/70">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2.5 bg-white text-emerald-700 rounded-xl shadow-xs">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-xl md:text-2xl font-extrabold text-gray-800 leading-tight">
                                                    Penjelasan Materi Grammar
                                                </h3>
                                                <p class="text-xs text-gray-500 font-medium">Panduan ringkas & rumus
                                                    terstruktur untuk latihan Anda</p>
                                            </div>
                                        </div>
                                        <button @click="showLessonExplanation = false"
                                            class="text-gray-400 hover:text-gray-700 focus:outline-none bg-white hover:bg-gray-200 p-2 rounded-full transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Modal Body --}}
                                    <div class="overflow-y-auto flex-1 p-6 md:p-8 bg-white custom-scrollbar">
                                        <div x-show="isExplainingLesson"
                                            class="flex flex-col items-center justify-center py-16 text-gray-500">
                                            <div class="relative mb-4">
                                                <div
                                                    class="w-12 h-12 rounded-full border-4 border-emerald-100 border-t-emerald-600 animate-spin">
                                                </div>
                                            </div>
                                            <p class="text-base font-bold text-gray-700">AI sedang menyusun penjelasan
                                                materi grammar untuk Anda...</p>
                                            <p class="text-xs text-gray-400 mt-1">Menyiapkan rumus, konsep dasar, dan contoh
                                                kalimat</p>
                                        </div>
                                        <div x-show="!isExplainingLesson" class="grammar-explanation-content"
                                            x-html="lessonExplanationHtml"></div>
                                    </div>

                                    {{-- Modal Footer --}}
                                    <div
                                        class="px-6 py-3.5 bg-white border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
                                        <span class="flex items-center gap-1.5 font-medium text-gray-500">
                                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Target Bahasa Learning Support
                                        </span>
                                        <button @click="showLessonExplanation = false"
                                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg text-xs transition">
                                            Tutup
                                        </button>
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
                                isGenerating: false,
                                error: null,
                                output: {},
                                introTopics: {!! $introTopics->toJson() !!},
                                availableLessons: {!! $availableTopics->toJson() !!},
                                selectedLessons: {!! $level === 'all' ? $availableTopics->toJson() : '[]' !!},
                                levels: ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'],
                                selectedLevel: '',
                                vocabTopics: ['Education', 'Business', 'Technology', 'Environment', 'Health', 'Science', 'Economy', 'History', 'Social', 'Geography', 'Mix', 'Random'],
                                selectedVocabTopic: '',
                                showTopics: {{ $level === 'all' ? 'false' : 'true' }},
                                showLessonExplanation: false,
                                isExplainingLesson: false,
                                lessonExplanationHtml: '',
                                cleanAiExplanation(text) {
                                    if (!text) return '';
                                    var trimmed = String(text).trim();
                                    if (trimmed.startsWith('```')) {
                                        trimmed = trimmed.replace(/^```(?:json)?\s*/i, '').replace(/\s*```$/, '').trim();
                                    }
                                    if ((trimmed.startsWith('{') && trimmed.endsWith('}')) || (trimmed.startsWith('[') && trimmed.endsWith(']'))) {
                                        try {
                                            var obj = JSON.parse(trimmed);
                                            if (typeof obj === 'object' && obj !== null) {
                                                var parts = [];
                                                if (obj.feedback) parts.push(obj.feedback);
                                                if (obj.explanation) parts.push(obj.explanation);
                                                if (obj.suggestion) parts.push(' Saran perbaikan: ' + obj.suggestion);
                                                if (obj.correction) parts.push(' Koreksi: ' + obj.correction);
                                                if (parts.length > 0) return parts.join('\n\n');

                                                var vals = Object.values(obj).filter(function (v) { return typeof v === 'string'; });
                                                if (vals.length > 0) return vals.join('\n\n');
                                            }
                                        } catch (e) { }
                                    }
                                    return trimmed;
                                },
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
                                    if (!item.answer || item.answer.trim() === '') {
                                        alert('Jawaban tidak boleh kosong. Silakan tulis terjemahan Anda terlebih dahulu.');
                                        return;
                                    }

                                    item.evaluation = this.evaluateAnswer(item.answer, item.en);
                                    item.submitted = true;
                                    item.isExplaining = true;
                                    item.ai_explanation = '';
                                    this.saveState();

                                    try {
                                        const activeLessons = this.selectedLessons.length > 0 ? this.selectedLessons : ['Grammar Practice'];
                                        const targetTopicStr = activeLessons.join(', ');

                                        const prompt = `Anda adalah instruktur grammar bahasa Inggris yang sangat cermat, profesional, dan komprehensif.
                    TOPIK GRAMMAR UTAMA YANG SEDANG DILATIH: **${targetTopicStr}**
                    Level CEFR: ${this.selectedLevel || 'B2'}

                    Soal (Bahasa Indonesia): ${item.id}
                    Kunci Jawaban Benar (Bahasa Inggris): ${item.en}
                    Jawaban Murid: ${item.answer}

                    INSTRUKSI EVALUASI & PENJELASAN KOMPREHENSIF (SANGAT PENTING):
                    1. WAJIB MENJELASKAN SECARA SEIMBANG SELURUH ELEMEN GRAMMAR PENTING DALAM KALIMAT:
                       - **Elemen Imbuhan (Suffixes):** Jelaskan penggunaan kata-kata berimbuhan (suffix) yang digunakan pada kunci jawaban (seperti imbuhan -ment pada assessment/development/management, -al pada environmental, -ity pada sustainability, -tion pada evaluation, dll), contohnya perubahan kata kerja menjadi noun ("assess" -> "assessment") atau noun menjadi adjective ("environment" -> "environmental"). Evaluasi penggunaan suffix murid.
                       - **Elemen Gerund (V-ing):** Jika kalimat memuat Gerund (seperti "before starting", "process of implementing", "strengthening management"), WAJIB jelaskan penggunaan Gerund setelah preposisi (misal after/before/of/in) atau sebagai kata benda, serta mengapa V-ing digunakan di sana.
                       - **Elemen Struktur Utama (${targetTopicStr}):** Evaluasi penerapan topik utama **${targetTopicStr}** (Omitting / Reducing / Abridgement / Suffixes / Appositives / dll) secara eksplisit. Khusus jika topik "Appositives", jelaskan jenis appositive yang digunakan (Non-Restrictive dengan koma, atau Restrictive tanpa koma) beserta kata benda yang dijelaskannya.

                    2. Tuliskan penjelasan dalam 3-5 kalimat Bahasa Indonesia yang ramah, konstruktif, dan sangat terstruktur.
                    3. Sebutkan secara seimbang penjelasan **Suffixes** DAN **Gerund** (jika ada dalam kalimat) serta perbaikan kesalahan murid agar murid mendapatkan pemahaman grammar yang utuh dan mendalam.`;

                                        const explainController = new AbortController();
                                        const explainTimeoutId = setTimeout(() => explainController.abort(), 60000);
                                        try {
                                            const response = await fetch('{{ route('assignments.grammar-writing.ai-proxy') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                    'Accept': 'application/json'
                                                },
                                                body: JSON.stringify({
                                                    prompt: prompt,
                                                    temperature: 0.5
                                                }),
                                                signal: explainController.signal
                                            });

                                            const data = await response.json();
                                            if (!response.ok || !data.success) {
                                                throw new Error(data.message || 'API Error');
                                            }

                                            item.ai_explanation = data.content;
                                        } finally {
                                            clearTimeout(explainTimeoutId);
                                        }
                                    } catch (e) {
                                        item.ai_explanation = e.name === 'AbortError'
                                            ? "AI membutuhkan waktu terlalu lama untuk merespons. Silakan coba lagi."
                                            : "Gagal memuat penjelasan dari AI. Silakan periksa koneksi Anda atau coba lagi nanti.";
                                    } finally {
                                        item.isExplaining = false;
                                        this.saveState();
                                    }
                                },
                                getFallbackLessonExplanation(topic) {
                                    var t = String(topic || '').toLowerCase();
                                    if (t.includes('omitting')) {
                                        return `<div class="space-y-6 text-gray-800">
    <div class="bg-white border border-emerald-200 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-emerald-900 mb-2"> Ringkasan Konsep Dasar: Omitting</h3>
        <p class="text-sm text-emerald-800 leading-relaxed">
            <strong>Omitting</strong> adalah penghilangan kata hubung (<em>conjunction</em>) atau kata ganti relatif (<em>relative pronoun</em>) tanpa mengubah makna kalimat. Di tingkat akademis (IELTS Academic Writing), omitting membuat kalimat lebih ringkas, efisien, dan efektif.
        </p>
    </div>
    <div class="space-y-4">
        <h4 class="text-lg font-bold text-gray-800"> 2 Bentuk Utama Omitting</h4>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 1. Omitting "That" pada Noun Clause sebagai Objek</h5>
            <p class="text-sm text-gray-600">Kata "that" setelah kata kerja mental/pelaporan (<em>believe, think, suggest, state, find, claim</em>) dapat dihilangkan.</p>
            <div class="bg-white p-3 rounded-lg text-sm font-mono text-gray-700">
                <strong> Rumus:</strong> Subject + Verb + [that] + Subject + Verb + Object
            </div>
            <div class="space-y-1.5 text-sm">
                <p class="font-medium text-gray-800"> Contoh Kalimat:</p>
                <p class="text-gray-700">🇬🇧 <em>Researchers believe (that) climate change requires immediate action.</em></p>
                <p class="text-gray-500 text-xs">🇮🇩 (Peneliti percaya bahwa perubahan iklim membutuhkan tindakan segera.)</p>
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 2. Omitting Relative Pronoun sebagai Objek</h5>
            <p class="text-sm text-gray-600">Kata ganti relatif (<em>that / which / whom</em>) dapat dihilangkan jika berfungsi sebagai objek dari klausa relatif.</p>
            <div class="bg-white p-3 rounded-lg text-sm font-mono text-gray-700">
                <strong> Rumus:</strong> Noun + [that/which/whom] + Subject + Verb
            </div>
            <div class="space-y-1.5 text-sm">
                <p class="font-medium text-gray-800"> Contoh Kalimat:</p>
                <p class="text-gray-700">🇬🇧 <em>The policy (which) the government introduced proved effective.</em></p>
                <p class="text-gray-500 text-xs">🇮🇩 (Kebijakan yang pemerintah perkenalkan terbukti efektif.)</p>
            </div>
        </div>
    </div>
    <div class="bg-amber-100 border border-amber-200 rounded-xl p-4 text-sm text-amber-900 space-y-2" style="background-color: #fef3c7 !important;">
        <p class="font-bold"> Tips Penting:</p>
        <p> <strong>Salah:</strong> <em>The man (who) lives next door is a doctor.</em> (Dilarang menghilangkan relative pronoun yang berfungsi sebagai <strong>Subjek</strong>).</p>
        <p> <strong>Benar:</strong> <em>The man who lives next door is a doctor.</em></p>
        <p> <strong>Benar (Omitting Object):</strong> <em>The book (which) I read yesterday was interesting.</em></p>
    </div>
</div>`;
                                    } else if (t.includes('reducing')) {
                                        return `<div class="space-y-6 text-gray-800">
    <div class="bg-white border border-emerald-200 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-emerald-900 mb-2"> Ringkasan Konsep Dasar: Reducing</h3>
        <p class="text-sm text-emerald-800 leading-relaxed">
            <strong>Reducing Relative Clauses</strong> (Penyederhanaan Klausa Relatif) adalah pengubahan klausa sifat (<em>adjective clause</em>) menjadi frasa partisipil (<em>participle phrase</em>) <strong>V-ing</strong> (aktif) atau <strong>V3</strong> (pasif) untuk menghemat kata dan meningkatkan keringkasan tulisan.
        </p>
    </div>
    <div class="space-y-4">
        <h4 class="text-lg font-bold text-gray-800"> 2 Bentuk Utama Reducing</h4>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 1. Reduced Active Relative Clause (Present Participle / V-ing)</h5>
            <p class="text-sm text-gray-600">Digunakan ketika subjek dalam klausa relatif melakukan tindakan aktif.</p>
            <div class="bg-white p-3 rounded-lg text-sm font-mono text-gray-700">
                <strong> Rumus:</strong> Noun + [who/which + V-aktif] ➔ Noun + V-ing
            </div>
            <div class="space-y-1.5 text-sm">
                <p class="font-medium text-gray-800"> Contoh Kalimat:</p>
                <p class="text-gray-700">🇬🇧 <em>Students who study abroad gain valuable experience.</em></p>
                <p class="text-teal-700 font-semibold">➔ Students <strong>studying</strong> abroad gain valuable experience.</p>
                <p class="text-gray-500 text-xs">🇮🇩 (Siswa yang belajar di luar negeri mendapatkan pengalaman berharga.)</p>
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 2. Reduced Passive Relative Clause (Past Participle / V3)</h5>
            <p class="text-sm text-gray-600">Digunakan ketika kata benda menerima tindakan pasif (di-/ter-).</p>
            <div class="bg-white p-3 rounded-lg text-sm font-mono text-gray-700">
                <strong> Rumus:</strong> Noun + [which/who + be + V3] ➔ Noun + V3
            </div>
            <div class="space-y-1.5 text-sm">
                <p class="font-medium text-gray-800"> Contoh Kalimat:</p>
                <p class="text-gray-700">🇬🇧 <em>The research that was conducted by Harvard confirmed the theory.</em></p>
                <p class="text-teal-700 font-semibold">➔ The research <strong>conducted</strong> by Harvard confirmed the theory.</p>
                <p class="text-gray-500 text-xs">🇮🇩 (Penelitian yang dilakukan oleh Harvard mengonfirmasi teori tersebut.)</p>
            </div>
        </div>
    </div>
    <div class="bg-amber-100 border border-amber-200 rounded-xl p-4 text-sm text-amber-900 space-y-2" style="background-color: #fef3c7 !important;">
        <p class="font-bold"> Tips Penting:</p>
        <p> <strong>Salah:</strong> <em>Companies reduce emissions play a vital role.</em></p>
        <p> <strong>Benar:</strong> <em>Companies <strong>reducing</strong> emissions play a vital role.</em></p>
    </div>
</div>`;
                                    } else if (t.includes('abridgement')) {
                                        return `<div class="space-y-6 text-gray-800">
    <div class="bg-white border border-emerald-200 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-emerald-900 mb-2"> Ringkasan Konsep Dasar: Abridgement</h3>
        <p class="text-sm text-emerald-800 leading-relaxed">
            <strong>Abridgement</strong> (Reduced Adverbial Clauses) adalah penyederhanaan klausa kata keterangan (<em>adverbial clause</em>) yang diawali kata hubung seperti <em>after, before, while, when, although, if, unless</em>.
        </p>
    </div>
    <div class="space-y-4">
        <h4 class="text-lg font-bold text-gray-800"> Bentuk Utama Abridgement</h4>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 1. Active Abridgement (Conjunction + V-ing)</h5>
            <div class="bg-white p-3 rounded-lg text-sm font-mono text-gray-700">
                <strong> Rumus:</strong> [Conjunction + Subject + Verb] ➔ Conjunction + V-ing
            </div>
            <div class="space-y-1.5 text-sm">
                <p class="font-medium text-gray-800"> Contoh Kalimat:</p>
                <p class="text-gray-700">🇬🇧 <em>After <strong>obtaining</strong> a PhD, she joined the research team.</em></p>
                <p class="text-gray-500 text-xs">🇮🇩 (Setelah mendapatkan gelar PhD, ia bergabung dengan tim peneliti.)</p>
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 2. Passive Abridgement (Conjunction + V3)</h5>
            <div class="bg-white p-3 rounded-lg text-sm font-mono text-gray-700">
                <strong> Rumus:</strong> [Conjunction + Subject + be + V3] ➔ Conjunction + V3
            </div>
            <div class="space-y-1.5 text-sm">
                <p class="font-medium text-gray-800"> Contoh Kalimat:</p>
                <p class="text-gray-700">🇬🇧 <em>When <strong>asked</strong> about the results, the director refused to comment.</em></p>
                <p class="text-gray-500 text-xs">🇮🇩 (Ketika ditanya tentang hasilnya, direktur menolak berkomentar.)</p>
            </div>
        </div>
    </div>
    <div class="bg-amber-100 border border-amber-200 rounded-xl p-4 text-sm text-amber-900 space-y-2" style="background-color: #fef3c7 !important;">
        <p class="font-bold"> Tips Penting:</p>
        <p>Syarat mutlak Abridgement: <strong>Subjek klausa keterangan harus sama dengan subjek klausa utama</strong>.</p>
    </div>
</div>`;
                                    } else {
                                        return `<div class="space-y-6 text-gray-800">
    <div class="bg-white border border-emerald-200 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-emerald-900 mb-2"> Ringkasan Konsep Dasar: Grammar Practice</h3>
        <p class="text-sm text-emerald-800 leading-relaxed">
            Penguasaan berbagai struktur tata bahasa Inggris (<em>Grammar Structures</em>) sangat penting untuk menyampaikan gagasan secara presisi, akademis, dan profesional dalam latihan penulisan.
        </p>
    </div>
    <div class="space-y-4">
        <h4 class="text-lg font-bold text-gray-800"> Panduan Struktur Penting</h4>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 1. Active vs Passive Voice</h5>
            <div class="space-y-1 text-sm">
                <p><strong>Active:</strong> Subject + Verb + Object ➔ <em>The company launched a new campaign.</em></p>
                <p><strong>Passive:</strong> Object + be + V3 ➔ <em>A new campaign was launched by the company.</em></p>
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs space-y-3">
            <h5 class="font-bold text-teal-700">🔹 2. Complex & Compound Sentences</h5>
            <p class="text-sm text-gray-600">Gunakan kata hubung (<em>conjunctions</em>) seperti <em>however, furthermore, although, because, in order to</em> untuk menghubungkan klausa dan membangun paragraf yang padu.</p>
        </div>
    </div>
</div>`;
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

                                        let topicRules = "";
                                        if (this.selectedLessons.includes('Omitting') || topicsList.includes('Omitting')) {
                                            topicRules = `\n\nATURAN MUTLAK KHUSUS TOPIK "Omitting":
                    - Topik "Omitting" HANYA mencakup dua hal berikut:
                      1. Omitting "that" untuk Noun Clause as Object (contoh: I believe [that] education is essential / Saya percaya pendidikan itu penting).
                      2. Omitting "that" untuk Relative Pronoun as Object (contoh: The report [that] he submitted was thorough / Laporan yang dia serahkan itu mendalam).
                    - DILARANG KERAS menjelaskan atau memberikan contoh omitting kata/struktur selain dua hal di atas (seperti omitting "will", "be", subject pronoun, auxiliary verb, dsb).`;
                                        }

                                        const prompt = `Anda adalah instruktur bahasa Inggris profesional. Tugas Anda adalah memberikan ringkasan materi untuk topik grammar: **${topicsList}**.${topicRules}
                    Penjelasan harus dalam bahasa Indonesia yang sistematis, sangat rapi, dan mudah dipahami.

                    ATURAN FORMATTING:
                    1. GUNAKAN MARKDOWN YANG RAPI DAN CANTIK.
                    2. Pisahkan judul materi dengan Heading 3 (###) atau Heading 4 (####).
                    3. Buat paragraf yang terstruktur dengan baik.
                    4. Gunakan bullet points (- atau *) untuk daftar rumus atau contoh kalimat.
                    5. Beri cetak tebal (**) pada rumus atau istilah penting.
                    6. Berikan contoh kalimat Bahasa Inggris beserta terjemahannya (dalam kurung).`;

                                        const lessonController = new AbortController();
                                        const lessonTimeoutId = setTimeout(() => lessonController.abort(), 60000);
                                        try {
                                            const response = await fetch('{{ route('assignments.grammar-writing.ai-proxy') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                    'Accept': 'application/json'
                                                },
                                                body: JSON.stringify({
                                                    prompt: prompt,
                                                    temperature: 0.5
                                                }),
                                                signal: lessonController.signal
                                            });

                                            const data = await response.json();
                                            if (!response.ok || !data.success) throw new Error(data.message || 'API Error');

                                            // Parse markdown output nicely with marked.js
                                            let markdownContent = data.content;
                                            if (markdownContent && markdownContent.trim() !== '') {
                                                if (typeof marked !== 'undefined') {
                                                    this.lessonExplanationHtml = marked.parse(markdownContent);
                                                } else {
                                                    this.lessonExplanationHtml = markdownContent.replace(/\n/g, '<br>');
                                                }
                                            } else {
                                                const topicsList = (this.selectedLessons && this.selectedLessons.length > 0) ? this.selectedLessons.join(', ') : 'Grammar Practice';
                                                this.lessonExplanationHtml = this.getFallbackLessonExplanation(topicsList);
                                            }
                                        } finally {
                                            clearTimeout(lessonTimeoutId);
                                        }
                                    } catch (e) {
                                        console.warn("Lesson explanation AI failed, using local fallback...", e);
                                        const topicsList = (this.selectedLessons && this.selectedLessons.length > 0) ? this.selectedLessons.join(', ') : 'Grammar Practice';
                                        this.lessonExplanationHtml = this.getFallbackLessonExplanation(topicsList);
                                    } finally {
                                        this.isExplainingLesson = false;
                                    }
                                },
                                async generateQuestions() {
                                    if (!this.selectedLevel || !this.selectedVocabTopic) {
                                        this.error = "Wajib memilih Level Kosa Kata (CEFR) dan Tema / Konteks Pembahasan terlebih dahulu sebelum membuat soal.";
                                        alert("Wajib memilih Level Kosa Kata (CEFR) dan Tema / Konteks Pembahasan terlebih dahulu.");
                                        return;
                                    }
                                    if (this.selectedLessons.length === 0) {
                                        this.error = "Wajib memilih setidaknya satu Topik Grammar Pokok terlebih dahulu.";
                                        alert("Wajib memilih setidaknya satu Topik Grammar Pokok terlebih dahulu.");
                                        return;
                                    }
                                    this.isGenerating = true;
                                    this.error = null;
                                    this.output = {};

                                    let kbContext = "";
                                    // activeLessons/topicsList are declared here (not with `let`/`const` inside
                                    // the try block below) because both are read again after the try/catch
                                    // closes - block-scoping them inside the try made every call throw
                                    // "activeLessons is not defined" right after the knowledge base fetch,
                                    // which aborted the whole function before it ever reached the AI request,
                                    // leaving isGenerating stuck true and the button spinning forever.
                                    let activeLessons = this.selectedLessons.length > 0 ? this.selectedLessons : ['All Lessons'];
                                    let topicsList = activeLessons.join(', ');
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
                                            if (topicToLoad === 'random' || topicToLoad === 'mix') {
                                                const availableTopics = ['education', 'business', 'technology', 'environment', 'health', 'science', 'economy', 'history', 'social', 'geography'];
                                                topicToLoad = availableTopics[Math.floor(Math.random() * availableTopics.length)];
                                            }
                                            const topicRes = await fetch(`/knowledge/topics/${topicToLoad}.json`);
                                            if (topicRes.ok) {
                                                const topicData = await topicRes.json();
                                                words.push(...topicData.sort(() => 0.5 - Math.random()).slice(0, 10));
                                                kbContext += `\nTEMA KOSAKATA UTAMA: ${topicToLoad.toUpperCase()} (CAMPURAN/MIX BERBAGAI TEMA KOSAKATA)\n`;
                                            }
                                        }

                                        // Load collocations
                                        const colRes = await fetch('/knowledge/collocations.json');
                                        if (colRes.ok) {
                                            const colData = await colRes.json();
                                            collocations.push(...colData.sort(() => 0.5 - Math.random()).slice(0, 5));
                                        }

                                        // Load patterns only if not Omitting, Reducing, or Abridgement
                                        if (!activeLessons.includes('Omitting') && !topicsList.includes('Omitting') &&
                                            !activeLessons.includes('Reducing') && !topicsList.includes('Reducing') &&
                                            !activeLessons.includes('Abridgement') && !topicsList.includes('Abridgement') &&
                                            !activeLessons.includes('Appositives') && !topicsList.includes('Appositives')) {
                                            const patRes = await fetch('/knowledge/sentence_patterns.json');
                                            if (patRes.ok) {
                                                const patData = await patRes.json();
                                                patterns.push(...patData.sort(() => 0.5 - Math.random()).slice(0, 5));
                                            }
                                        }

                                        if (patterns.length > 0) {
                                            kbContext += `\nGUNAKAN KOSAKATA & KOLOKASI BERIKUT JIKA MEMUNGKINKAN:\nVocabulary: ${words.join(', ')}\nCollocations: ${collocations.join(', ')}\n\nCONTOH POLA KALIMAT:\n- ${patterns.join('\n- ')}\n`;
                                        } else {
                                            kbContext += `\nGUNAKAN KOSAKATA & KOLOKASI BERIKUT JIKA MEMUNGKINKAN:\nVocabulary: ${words.join(', ')}\nCollocations: ${collocations.join(', ')}\n`;
                                        }

                                    } catch (err) {
                                        console.error("Failed to load knowledge base", err);
                                    }

                                    // Default to 'All Lessons' if empty
                                    if (activeLessons.includes('All Lessons')) {
                                        activeLessons = ['All Lessons'];
                                    }

                                    const levelStr = this.selectedLevel ? this.selectedLevel : 'B2';

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

                                    if (activeLessons.includes('Omitting') || topicsList.includes('Omitting')) {
                                        customRules += `\n\n==============================================================
                    INSTRUKSI MUTLAK KHUSUS TOPIK "OMITTING":
                    ==============================================================
                    SEMUA 10 KALIMAT LATIHAN (NOMOR 1 SAMPAI 10) WAJIB MERUPAKAN KALIMAT OMITTING.
                    DILARANG KERAS MEMBUAT SEKALIPUN 1 KALIMAT BIASA/AKTIF/PASIF TANPA STRUKTUR OMITTING (seperti "Perusahaan mengalokasikan dana...").

                    Topik Omitting HANYA BOLEH menggunakan 2 jenis pola ini (kombinasikan keduanya untuk tema ${this.selectedVocabTopic || 'Business'} dan level ${this.selectedLevel || 'B2'}):

                    POLA 1: Noun Clause as Object (Omitting "that")
                    - Bahasa Indonesia: Memuat klausa dengan kata "bahwa" setelah kata kerja/klausa utama (misal: "Manajer percaya bahwa...", "Peneliti menemukan bahwa...", "Ini adalah fakta bahwa...", "Direktur menegaskan bahwa...").
                    - Bahasa Inggris (properti "en"): Kata "that" WAJIB DIHILANGKAN (OMITTED).
                      Contoh: "Manajer percaya bahwa pelanggan memiliki kebutuhan yang unik." -> "The manager believes customers have unique needs." (TANPA kata "that").

                    POLA 2: Relative Pronoun as Object (Omitting "that/which/whom")
                    - Bahasa Indonesia: Memuat klausa "yang [subjek] [kata kerja]" di mana kata benda dijelaskan oleh tindakan subjek lain (misal: "kebijakan yang kongres sahkan", "gadget yang orang tua abaikan", "strategi yang tim kembangkan").
                    - Bahasa Inggris (properti "en"): Kata "that/which/whom" WAJIB DIHILANGKAN (OMITTED).
                      Contoh: "Sebagian besar masyarakat menolak kebijakan yang kongres sahkan." -> "Most of the public rejects the policy congress passed." (TANPA kata "that/which").

                    10 CONTOH POLA GOLD STANDARD KLIEN:
                    1. "Ini telah dihipotesiskan bahwa kita saat ini diambang kepunahan massal ke-enam." -> "It has been hypothesized we are now in the brink of 6th mass extinction."
                    2. "Boas menekankan bahwa antropologi berbeda dengan bidang lainnya..." -> "Boas emphasized anthropology differs from other fields..."
                    3. "Para peneliti telah menemukan bahwa efisiensi penggunaan air..." -> "Researchers have found water use efficiency is often hindered..."
                    4. "Dari semua radiasi matahari yang Bumi terima dari matahari..." -> "Of all solar radiation the Earth receives from the sun..."
                    5. "Ini adalah fakta bahwa kehidupan manusia bergantung pada..." -> "It is a fact human life depends on..."
                    6. "Anak - anak menggunakan kemampuan bawaan untuk mempelajari bahasa yang mereka terekspos." -> "Children use an innate ability to learn the language they are exposed to."
                    7. "Para ilmuwan menduga bahwa black hole hadir di pusat dari galaksi - galaksi." -> "Scientists suspect black holes are present in the center of galaxies."
                    8. "Kebudayaan yang orang - orang miliki memiliki kebijaksanaan di dalamnya." -> "The culture people possess has wisdom in it."
                    9. "Sebagian besar masyarakat menolak kebijakan yang kongres sahkan." -> "Most of the public rejects the policy congress passed."
                    10. "Perkembangan mental anak - anak kemungkinan terganggu oleh sosial media melalui gadget yang banyak orang tua abaikan." -> "Children's mental development is likely disturbed by social media through gadgets many parents ignore."

                    WAJIB MEMBAGI 10 KALIMAT MENJADI MIX SEIMBANG ANTARA AKTIF, PASIF, DAN NOMINAL:

                    1. KALIMAT AKTIF (4-5 kalimat): Subjek + Verb aktif + Noun Clause/Relative Clause.
                    2. KALIMAT PASIF (3-4 kalimat): Subjek + Be + V3 + Noun Clause/Relative Clause.
                    3. KALIMAT NOMINAL (2-3 kalimat): Subjek + To be + Adjective/Noun + Noun Clause/Relative Clause.

                    DILARANG KERAS MEMBUAT SEKALIPUN 1 KALIMAT BIASA TANPA STRUKTUR OMITTING.
                    DALAM BAHASA INGGRIS, KATA "THAT" WAJIB DIHILANGKAN (OMITTED).
                    SEMUA 10 KALIMAT HARUS MENGIKUTI POLA DI ATAS SESUAI TEMA ${this.selectedVocabTopic || 'Business'} DAN LEVEL ${this.selectedLevel || 'B2'}.`;
                                    }

                                    if (activeLessons.includes('Reducing') || topicsList.includes('Reducing')) {
                                        customRules += `\n\n==============================================================
                    INSTRUKSI MUTLAK KHUSUS TOPIK "REDUCING" (REDUCED RELATIVE CLAUSES / PARTICIPLE CLAUSES):
                    ==============================================================
                    SEMUA 10 KALIMAT LATIHAN (NOMOR 1 SAMPAI 10) WAJIB MERUPAKAN KALIMAT REDUCING RELATIVE CLAUSE (PARTICIPLE CLAUSES).
                    DILARANG KERAS MEMBUAT SEKALIPUN 1 KALIMAT BIASA DENGAN KATA KERJA "MENGURANGI" (seperti "Pemerintah mengurangi emisi..." ATAU "Perusahaan memperbarui teknologi untuk mengurangi..."). 
                    "REDUCING" DI SINI ADALAH PENYEDERHANAAN KLAUSA RELATIF (ADJECTIVE CLAUSE REDUCTION)!

                    WAJIB MEMBAGI 10 KALIMAT MENJADI MIX SEIMBANG ANTARA AKTIF, PASIF, DAN NOMINAL:

                    1. KALIMAT AKTIF (4-5 kalimat): Reduced Active Clause (Present Participle / V-ing)
                       - Indonesia: "...yang [verb aktif]..." (misal: "Universitas yang menyediakan...", "Guru yang mengembangkan...", "Kromosom yang membawa gen...", "Sistem yang terdiri dari...").
                       - Inggris: V-ing (misal: "providing", "developing", "living", "carrying", "consisting of", "involving", "melting").

                    2. KALIMAT PASIF (3-4 kalimat): Reduced Passive Clause (Past Participle / V3)
                       - Indonesia: "...yang [di- / ter- / verb pasif]..." (misal: "Penelitian yang dilakukan oleh...", "Pestisida yang digunakan di...", "Iklim yang dipengaruhi oleh...", "Kurikulum yang dirancang oleh...").
                       - Inggris: V3 (misal: "conducted by", "used in", "affected by", "designed by", "found in").

                    3. KALIMAT NOMINAL (2-3 kalimat): Reduced Nominal / Descriptive Clause
                       - Indonesia: "...yang merupakan...", "...yang adalah...", "...yang menjadi...", "...yang berupa..." (misal: "Archaebacteria yang merupakan kelompok bakteri ekstrim...", "Hutan hujan yang merupakan sumber oksigen utama...", "Fasilitas yang menjadi pendukung utama...").
                       - Inggris: Reduced noun/adjective phrase atau being/to be (misal: "being the primary source...", "a bacterial group living in...", "the main support for...").

                    DILARANG HANYA MEMBUAT KALIMAT AKTIF! WAJIB MENYERTAKAN KALIMAT PASIF DAN NOMINAL AGAR TERDAPAT MIX DENGAN SEIMBANG (AKTIF, PASIF, DAN NOMINAL).`;
                                    }

                                    if (activeLessons.includes('Abridgement') || topicsList.includes('Abridgement')) {
                                        customRules += `\n\n==============================================================
                    INSTRUKSI MUTLAK KHUSUS TOPIK "ABRIDGEMENT" (REDUCED ADVERBIAL CLAUSES):
                    ==============================================================
                    SEMUA 10 KALIMAT LATIHAN (NOMOR 1 SAMPAI 10) WAJIB MERUPAKAN KALIMAT ABRIDGEMENT (REDUCED ADVERBIAL CLAUSE).
                    DILARANG KERAS MEMBUAT SEKALIPUN 1 KALIMAT BIASA SEPERTI "Pemerintah mengembangkan kebijakan..." ATAU "Perusahaan memiliki komitmen...".

                    ABRIDGEMENT DI SINI ADALAH PENYEDERHANAAN KLAUSA ADVERBIA (ADVERBIAL CLAUSE REDUCTION) YANG MEMUAT KATA HUBUNG SEPERTI: after, before, while, when, whenever, although, though, if, unless, once, wherever, until, as.

                    WAJIB MEMBAGI 10 KALIMAT MENJADI MIX SEIMBANG ANTARA AKTIF, PASIF, DAN NOMINAL:

                    1. KALIMAT AKTIF (4-5 kalimat): Adverbial Conjunction + V-ing
                       - Indonesia: Memuat kata hubung + verb aktif (misal: "setelah berevolusi", "sebelum mengalami metamorfosis", "sambil berotasi", "meskipun cenderung untuk...", "seakan-akan memiliki...", "jika beradaptasi...", "dimanapun tinggal...", "sebelum bereproduksi...", "setelah mengkoloni...").
                       - Inggris: Conjunction + V-ing (misal: "after evolving", "before undergoing", "while rotating", "although tending to", "as if having", "if adapting", "wherever living", "before reproducing", "once colonizing").
                       - Contoh: "Beberapa spesies menjadi punah segera setelah mereka berevolusi." -> "Several species become extinct after evolving."

                    2. KALIMAT PASIF (3-4 kalimat): Adverbial Conjunction + V3
                       - Indonesia: Memuat kata hubung + verb pasif/di-/ter- (misal: "setelah diburu oleh...", "sebelum dipenuhi oleh...", "sebelum diadopsi sebagai...", "ketika diminta untuk...", "ketika diperkenalkan dari...", "ketika dipolinasi...", "kapanpun terancam oleh...", "dimanapun diinvasi oleh...", "sebelum dipanen...", "hingga terbukti bersalah...").
                       - Inggris: Conjunction + V3 (misal: "after hunted by", "before populated by", "before adopted as", "when asked to", "when introduced from", "when pollinated", "whenever threatened by", "wherever invaded by", "before harvested", "until proven guilty").
                       - Contoh: "Mammoth menjadi punah setelah diburu oleh manusia purba." -> "Mammoths became extinct after hunted by ancient humans."

                    3. KALIMAT NOMINAL (2-3 kalimat): Adverbial Conjunction + Adjective / Noun Phrase / Prepositional Phrase
                       - Indonesia: Memuat kata hubung + frasa nominal/sifat (misal: "dimanapun mungkin", "meskipun tidak pernah dominan", "meskipun seekor mamalia", "meskipun mampu untuk terbang", "sebelum punah di...", "ketika sakit", "hanya jika ada di perairan...", "sementara masih di dalam daftar...", "meskipun sukses", "kecuali tidak mampu terbang...").
                       - Inggris: Conjunction + Noun/Adj/Prep (misal: "whenever possible", "although never dominant", "although a mammal", "although capable of flying", "before extinct in...", "when sick", "only if in Australian waters", "while still on the endangered list", "although successful", "unless incapable of flight").
                       - Contoh: "Ide klasifikasi yang menggambarkan genealogy seharusnya diadopsi dimanapun mungkin." -> "Classification ideas illustrating genealogy should be adopted whenever possible."

                    27 CONTOH GOLD STANDARD KLIEN UNTUK ABRIDGEMENT:
                    [AKTIF]
                    - "Beberapa spesies menjadi punah segera setelah mereka berevolusi." -> "Several species become extinct after evolving."
                    - "setelah mendapatkan sebuah M.D dari Universitas Edinburgh..." -> "after obtaining an M.D from..."
                    - "sebelum mengalami metamorfosis." -> "before undergoing metamorphosis."
                    - "sambil berotasi pada sumbunya." -> "while rotating on its axis."
                    - "meskipun cenderung untuk kurang agresif daripada pit vipers." -> "although tending to be less aggressive than..."
                    - "seakan - akan memiliki mata." -> "as if having eyes."
                    - "jika beradaptasi sebagai respon dari perubahan." -> "if adapting in response to changes."
                    - "Dimanapun tinggal, mamalia selalu beradaptasi..." -> "Wherever living, mammals always adapt..."

                    [PASIF]
                    - "Mammoth menjadi punah setelah diburu oleh manusia purba." -> "Mammoths became extinct after hunted by ancient humans."
                    - "sebelum dipenuhi oleh tumbuhan." -> "before populated by plants."
                    - "ketika diminta untuk segera menyebarkan vaksin." -> "when asked to immediately deploy..."
                    - "ketika secara sukses diperkenalkan dari tanaman lain." -> "when successfully introduced from another plant."
                    - "ketika dipolinasi." -> "when pollinated."
                    - "kapanpun terancam oleh predator." -> "whenever threatened by predators."
                    - "dimanapun diinvasi oleh manusia..." -> "wherever invaded by humans..."
                    - "sebelum dipanen." -> "before harvested."
                    - "hingga terbukti bersalah." -> "until proven guilty."

                    [NOMINAL]
                    - "Ide klasifikasi yang menggambarkan genealogy seharusnya diadopsi dimanapun mungkin." -> "Classification ideas illustrating genealogy should be adopted whenever possible."
                    - "meskipun tidak pernah dominan..." -> "although never dominant..."
                    - "Meskipun seekor mamalia, Platypus bertelur." -> "Although a mammal, the Platypus lays eggs."
                    - "Mesites meskipun mampu untuk terbang..." -> "Mesites although capable of flight..."
                    - "ketika sakit." -> "when sick."
                    - "Sementara masih di dalam daftar hewan terancam punah..." -> "While still on the endangered list..."
                    - "Kecuali (unless) tidak mampu terbang..." -> "Unless incapable of flight..."

                    DILARANG KERAS MEMBUAT KALIMAT BIASA TANPA ABRIDGED ADVERBIAL CLAUSES!
                    SEMUA 10 KALIMAT HARUS MENGIKUTI POLA DI ATAS SESUAI TEMA ${this.selectedVocabTopic || 'Environment'} DAN LEVEL ${this.selectedLevel || 'B2'}.`;
                                    }

                                    if (activeLessons.includes('Mix') || topicsList.includes('Mix')) {
                                        customRules += `\n\n==============================================================
                    INSTRUKSI KHUSUS TOPIK GRAMMAR "MIX / CAMPURAN TOPIK":
                    ==============================================================
                    SEMUA 10 KALIMAT LATIHAN HARUS MEMUAT VARIATIF CAMPURAN (MIX) DARI BERBAGAI TOPIK GRAMMAR POKOK:
                    - Kalimat 1-2: Omitting (Noun Clause Object / Relative Clause Object omitting "that")
                    - Kalimat 3-4: Reducing (Reduced Active V-ing / Reduced Passive V3)
                    - Kalimat 5-6: Abridgement (Adverbial Conjunction + V-ing / V3 / Nominal)
                    - Kalimat 7-8: Suffixes (Kata berimbuhan -ment, -al, -tion, -ity, -ness, -ful, -ize)
                    - Kalimat 9-10: Appositives / Inversion / Parallel Structures
                    Setiap kalimat WAJIB menggunakan struktur grammar lanjutan yang berbeda-beda agar murid mendapatkan latihan campuran secara komprehensif.`;
                                    }

                                    if (activeLessons.includes('Appositives') || topicsList.includes('Appositives')) {
                                        customRules += `\n\n==============================================================
                    INSTRUKSI MUTLAK KHUSUS TOPIK "APPOSITIVES":
                    ==============================================================
                    SEMUA 10 KALIMAT LATIHAN (NOMOR 1 SAMPAI 10) WAJIB MEMUAT STRUKTUR APPOSITIVE (Frasa benda yang mendeskripsikan/menjelaskan kata benda sebelumnya).
                    DILARANG KERAS MEMBUAT KALIMAT BIASA TANPA APPOSITIVE!

                    Kombinasikan jenis Appositive berikut (70% Non-Restrictive, 30% Restrictive):
                    1. Non-Restrictive Appositive (Diapit koma, memberi info tambahan). 
                       - "Jakarta, the capital city of Indonesia, is very crowded." -> "Jakarta, ibu kota Indonesia, sangat padat."
                       - "Borobudur, a famous Buddhist temple, is located in Central Java." -> "Borobudur, candi Buddha terkenal, terletak di Jawa Tengah."
                       - "Susi Pudjiastuti, the former Minister of Maritime Affairs, is known for her slogan." -> "Susi Pudjiastuti, mantan Menteri Kelautan, dikenal dengan slogannya."
                       - "Rendang, a traditional food from Minangkabau, is very delicious." -> "Rendang, makanan tradisional dari Minangkabau, sangat lezat."

                    2. Restrictive Appositive (Tanpa koma, info spesifik yang sangat penting).
                       - "The singer Bruno Mars will hold a concert next month." -> "Penyanyi Bruno Mars akan mengadakan konser bulan depan."
                       - "My friend Budi lives in Surabaya." -> "Temanku Budi tinggal di Surabaya."
                       - "The famous artist Vincent van Gogh painted The Starry Night." -> "Seniman terkenal Vincent van Gogh melukis The Starry Night."

                    Gunakan struktur Appositive ini dan terapkan pada Tema Kosakata: ${this.selectedVocabTopic || 'Umum'} dan Level: ${this.selectedLevel || 'B2'}.`;
                                    }

                                    if (this.selectedVocabTopic === 'Mix' || this.selectedVocabTopic === 'Random') {
                                        customRules += `\n\n==============================================================
                    INSTRUKSI KHUSUS TEMA "MIX / CAMPURAN KOSAKATA":
                    ==============================================================
                    Buatkan 10 kalimat latihan dan 2 paragraf dengan Tema Kosakata yang bervariasi secara acak (kombinasi konteks Education, Business, Technology, Environment, Health, Science, Economy, History, Social, Geography) sehingga setiap kalimat membahas konteks dunia nyata yang beragam.`;
                                    }

                                    let prompt = "";
                                    if ('{{ $level }}' === 'all') {
                                        prompt = `Anda adalah instruktur IELTS dan Grammar bahasa Inggris yang sangat ketat dan presisi.

                    TUGAS: Buatkan 10 kalimat latihan terjemahan (Bahasa Indonesia → Bahasa Inggris) dan 2 paragraf berkesinambungan (seperti Body Paragraph 1 dan Body Paragraph 2 pada IELTS Academic Writing Task 2), KHUSUS untuk topik grammar: **${topicsList}**, dengan Tema Kosakata: **${this.selectedVocabTopic || 'Umum'}** dan Level CEFR: **${this.selectedLevel || 'B2'}**.${customRules}

                    ==============================================================
                    ATURAN MUTLAK YANG TIDAK BOLEH DILANGGAR SAMA SEKALI:
                    ==============================================================

                    1. HANYA BOLEH menggunakan SATU struktur grammar utama: **${topicsList}**.
                       - Setiap kalimat, baik di bagian latihan kalimat maupun paragraf, WAJIB memuat struktur grammar tersebut.
                       - Paragraf ini harus bernada akademis, argumentatif, dan memiliki linking words (transisi) yang sangat baik ala IELTS.

                    2. KOMPOSISI BENTUK KALIMAT (WAJIB MIX SEIMBANG ANTARA AKTIF, PASIF, DAN NOMINAL):
                       - 10 KALIMAT LATIHAN WAJIB TERDIRI DARI KOMBINASI SEIMBANG:
                         * KALIMAT AKTIF (~4 KALIMAT / 40%)
                         * KALIMAT PASIF (~3-4 KALIMAT / 30-40%)
                         * KALIMAT NOMINAL (~2-3 KALIMAT / 20-30%, predikat berupa to be / noun / adjective / preposition)
                       - DILARANG KERAS membuat 10 kalimat yang semuanya aktif! Wajib bervariasi mencampurkan kalimat aktif, pasif, dan nominal.

                    3. ATURAN PANJANG PARAGRAF (SANGAT PENTING):
                       - SETIAP paragraf WAJIB terdiri dari MINIMAL 5 KALIMAT.
                       - Struktur per paragraf harus mengikuti standar IELTS: Topic Sentence, Explanation, Example, Result/Further detail, dan Concluding sentence.

                    4. KHUSUS TINGKAT LATIHAN SAAT INI (${this.selectedLevel || 'B2'}):
                       Gunakan struktur kalimat kompleks akademis ala Reading/Writing IELTS dengan vocabulary sesuai level ${this.selectedLevel || 'B2'}.
                       Berikan contoh konkret di dalam paragraf untuk mendukung argumen.

                    5. ATURAN TAMBAHAN:
                       - Kalimat dan Paragraf Bahasa Indonesia harus terasa ALAMI dan akademis.
                       - Terjemahan Bahasa Inggris harus menggunakan struktur IELTS Academic band 7.5+.
                       - Hindari pengulangan pola yang sama persis di setiap kalimat latihan.
                       - DILARANG KERAS menggunakan teks placeholder atau dummy seperti "Kalimat Indonesia 1". Properti "id" HARUS berisi kalimat soal bahasa Indonesia sebenarnya yang utuh.

                    ${kbContext}

                    ==============================================================
                    FORMAT OUTPUT (JSON murni tanpa markdown):
                    ==============================================================
                    catatan: Properti "id" adalah kalimat soal Bahasa Indonesia sebenarnya (BUKAN dummy 'Kalimat Indonesia 1'), dan "en" adalah terjemahan Bahasa Inggrisnya.

                    {
                      "sentences": [
                        {"id": "Tuliskan kalimat soal 1 bahasa Indonesia di sini...", "en": "Actual English translation 1..."},
                        {"id": "Tuliskan kalimat soal 2 bahasa Indonesia di sini...", "en": "Actual English translation 2..."}
                      ],
                      "paragraph": {
                        "id": "Tuliskan 2 paragraf soal bahasa Indonesia sebenarnya di sini. Gunakan \\n\\n sebagai pemisah antar paragraf.",
                        "en": "Actual English translation 2 paragraphs here. Use \\n\\n for paragraph breaks."
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
                       - Jika "Omitting" → WAJIB HANYA menggunakan omitting kata "that" untuk Noun Clause as Object (contoh: I know [that] she is honest) dan Relative Pronoun as Object (contoh: The book [that] I bought yesterday). DILARANG KERAS jenis omitting selain kata "that" objek.
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
                       - DILARANG KERAS menggunakan teks placeholder atau dummy seperti "Kalimat Indonesia 1". Properti "id" HARUS berisi kalimat soal bahasa Indonesia sebenarnya yang utuh.

                    ${kbContext}

                    ==============================================================
                    FORMAT OUTPUT (JSON murni tanpa markdown):
                    ==============================================================
                    catatan: Properti "id" adalah kalimat soal Bahasa Indonesia sebenarnya (BUKAN dummy 'Kalimat Indonesia 1'), dan "en" adalah terjemahan Bahasa Inggrisnya.

                    {
                      "sentences": [
                        {"id": "Tuliskan kalimat soal 1 bahasa Indonesia di sini...", "en": "Actual English translation 1..."},
                        {"id": "Tuliskan kalimat soal 2 bahasa Indonesia di sini...", "en": "Actual English translation 2..."}
                      ],
                      "paragraph": {
                        "id": "Tuliskan paragraf soal bahasa Indonesia sebenarnya di sini yang berisi 6 kalimat.",
                        "en": "Actual English translation paragraph here."
                      }
                    }`;
                                    }

                                    const genController = new AbortController();
                                    const genTimeoutId = setTimeout(() => genController.abort(), 100000);
                                    try {
                                        const response = await fetch('{{ route('assignments.grammar-writing.ai-proxy') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                prompt: prompt,
                                                json_mode: true,
                                                temperature: 0.7
                                            }),
                                            signal: genController.signal
                                        });

                                        const data = await response.json();
                                        if (!response.ok || !data.success) {
                                            throw new Error(data.message || 'Gagal mengambil data dari API.');
                                        }

                                        const text = data.content;
                                        let parsed = JSON.parse(text);

                                        if (!Array.isArray(parsed.sentences) || parsed.sentences.length === 0 || !parsed.paragraph) {
                                            throw new Error('AI mengembalikan format soal yang tidak lengkap. Silakan coba lagi.');
                                        }

                                        if (parsed.sentences && Array.isArray(parsed.sentences)) {
                                            parsed.sentences = parsed.sentences.map((s, idx) => ({
                                                id: s.id || '',
                                                en: s.en || '',
                                                answer: '',
                                                submitted: false,
                                                evaluation: '',
                                                isExplaining: false,
                                                ai_explanation: ''
                                            }));
                                        }
                                        if (parsed.paragraph) {
                                            parsed.paragraph = {
                                                id: parsed.paragraph.id || '',
                                                en: parsed.paragraph.en || '',
                                                answer: '',
                                                submitted: false,
                                                evaluation: '',
                                                isExplaining: false,
                                                ai_explanation: ''
                                            };
                                        }

                                        this.output = parsed;
                                        this.saveState();
                                    } catch (err) {
                                        console.warn("AI service unavailable, invoking fallback questions bank...", err);
                                        this.generateFallbackQuestions(topicsList, levelStr);
                                    } finally {
                                        clearTimeout(genTimeoutId);
                                        this.isGenerating = false;
                                    }
                                },
                                generateFallbackQuestions(topicsList, levelStr) {
                                    const fallbackBank = {
                                        'Omitting': {
                                            sentences: [
                                                { id: "Manajer percaya bahwa pelanggan memiliki kebutuhan yang unik.", en: "The manager believes customers have unique needs." },
                                                { id: "Para peneliti telah menemukan bahwa efisiensi penggunaan air sering kali terhambat.", en: "Researchers have found water use efficiency is often hindered." },
                                                { id: "Ini adalah fakta bahwa kehidupan manusia sangat bergantung pada lingkungan.", en: "It is a fact human life depends heavily on the environment." },
                                                { id: "Para ilmuwan menduga bahwa lubang hitam berada di pusat galaksi.", en: "Scientists suspect black holes are present in the center of galaxies." },
                                                { id: "Sebagian besar masyarakat menolak kebijakan yang kongres sahkan.", en: "Most of the public rejects the policy congress passed." },
                                                { id: "Kebudayaan yang orang-orang miliki mengandung kebijaksanaan di dalamnya.", en: "The culture people possess has wisdom in it." },
                                                { id: "Boas menekankan bahwa antropologi berbeda dengan bidang ilmu lainnya.", en: "Boas emphasized anthropology differs from other fields of science." },
                                                { id: "Anak-anak mempelajari bahasa yang mereka dengar setiap hari.", en: "Children learn the language they hear every day." },
                                                { id: "Perusahaan membatalkan proyek yang direksi usulkan bulan lalu.", en: "The company canceled the project the board proposed last month." },
                                                { id: "Laporan yang tim audit serahkan menunjukkan peningkatan efisiensi.", en: "The report the audit team submitted shows an increase in efficiency." }
                                            ],
                                            paragraph: {
                                                id: "Banyak pakar meyakini bahwa perubahan iklim mempengaruhi ekosistem global secara drastis.\n\nLaporan yang para ilmuwan publikasikan menegaskan bahwa emisi karbon harus segera dikurangi.",
                                                en: "Many experts believe climate change affects global ecosystems drastically.\n\nThe report scientists published confirms carbon emissions must be reduced immediately."
                                            }
                                        },
                                        'Reducing': {
                                            sentences: [
                                                { id: "Universitas yang menyediakan beasiswa riset menarik mahasiswa internasional.", en: "Universities providing research scholarships attract international students." },
                                                { id: "Penelitian yang dilakukan oleh tim independen memverifikasi temuan tersebut.", en: "Research conducted by an independent team verified the findings." },
                                                { id: "Sistem yang terdiri dari beberapa modul mempermudah analisis data.", en: "Systems consisting of several modules facilitate data analysis." },
                                                { id: "Pestisida yang digunakan pada pertanian dapat mencemari sumber air.", en: "Pesticides used in agriculture can contaminate water sources." },
                                                { id: "Kromosom yang membawa gen tertentu menentukan sifat organisme.", en: "Chromosomes carrying specific genes determine organism traits." },
                                                { id: "Iklim yang dipengaruhi oleh arus laut menghasilkan cuaca ekstrem.", en: "Climate affected by ocean currents produces extreme weather." },
                                                { id: "Spesies yang hidup di dataran tinggi memiliki adaptasi khusus.", en: "Species living in highlands have special adaptations." },
                                                { id: "Kurikulum yang dirancang oleh para ahli meningkatkan kualitas pembelajaran.", en: "The curriculum designed by experts improves learning quality." },
                                                { id: "Perusahaan yang mengembangkan energi terbarukan mendapat dukungan publik.", en: "Companies developing renewable energy receive public support." },
                                                { id: "Data yang dikumpulkan dari survei menunjukkan tren positif.", en: "Data collected from the survey shows a positive trend." }
                                            ],
                                            paragraph: {
                                                id: "Organisme yang hidup di lingkungan ekstrem memiliki mekanisme bertahan yang unik.\n\nSenyawa kimia yang ditemukan dalam sampel jaringan memberikan wawasan baru bagi para peneliti.",
                                                en: "Organisms living in extreme environments possess unique survival mechanisms.\n\nChemical compounds found in tissue samples provide new insights for researchers."
                                            }
                                        },
                                        'Abridgement': {
                                            sentences: [
                                                { id: "Beberapa spesies menjadi punah setelah berevolusi.", en: "Several species become extinct after evolving." },
                                                { id: "Mammoth menjadi punah setelah diburu oleh manusia purba.", en: "Mammoths became extinct after hunted by ancient humans." },
                                                { id: "Ide klasifikasi harus diadopsi dimanapun mungkin.", en: "Classification ideas should be adopted whenever possible." },
                                                { id: "Platypus bertelur meskipun merupakan seekor mamalia.", en: "The platypus lays eggs although a mammal." },
                                                { id: "Bakteri bereproduksi secara cepat ketika berada di lingkungan yang hangat.", en: "Bacteria reproduce rapidly when in a warm environment." },
                                                { id: "Perusahaan harus melakukan revisi sebelum meluncurkan produk baru.", en: "The company must revise before launching a new product." },
                                                { id: "Teknologi ini menghemat biaya jika diterapkan secara masal.", en: "This technology saves costs if implemented on a large scale." },
                                                { id: "Karyawan tetap bekerja dengan tekun meskipun menghadapi tantangan.", en: "Employees keep working diligently although facing challenges." },
                                                { id: "Minyak bumi dibersihkan sebelum didistribusikan ke pasar.", en: "Crude oil is refined before distributed to the market." },
                                                { id: "Protokol keamanan wajib dijalankan saat menangani zat berbahaya.", en: "Security protocols must be executed when handling dangerous substances." }
                                            ],
                                            paragraph: {
                                                id: "Setelah mengalami transformasi digital, perusahaan mampu meningkatkan efisiensi operasional.\n\nJika diterapkan secara konsisten, strategi baru ini akan membawa pertumbuhan jangka panjang.",
                                                en: "After undergoing digital transformation, the company was able to increase operational efficiency.\n\nIf applied consistently, this new strategy will bring long-term growth."
                                            }
                                        },
                                        'Suffixes': {
                                            sentences: [
                                                { id: "Efisiensi sistem operasional perusahaan telah meningkat secara signifikan.", en: "The efficiency of the company operational system has improved significantly." },
                                                { id: "Pembangunan infrastruktur berkelanjutan adalah prioritas pemerintah.", en: "Sustainable infrastructure development is a government priority." },
                                                { id: "Evaluasi kinerja tahunan memberikan penilaian yang objektif.", en: "Annual performance evaluation provides an objective assessment." },
                                                { id: "Ketergantungan pada bahan bakar fosil harus dikurangi.", en: "Dependence on fossil fuels must be reduced." },
                                                { id: "Partisipasi aktif warga sangat penting dalam demokrasi.", en: "Active participation of citizens is crucial in democracy." },
                                                { id: "Perusahaan meluncurkan kampanye periklanan baru.", en: "The company launched a new advertising campaign." },
                                                { id: "Kerentanan sistem keamanan siber perlu segera diatasi.", en: "The vulnerability of cyber security systems needs immediate resolution." },
                                                { id: "Pengembangan teknologi pintar mengubah cara kita bekerja.", en: "The development of smart technology changes how we work." },
                                                { id: "Keberhasilan proyek ini bergantung pada kerja sama tim.", en: "The success of this project depends on team cooperation." },
                                                { id: "Penyesuaian strategi bisnis diperlukan saat terjadi fluktuasi pasar.", en: "Adjustment of business strategy is necessary during market fluctuations." }
                                            ],
                                            paragraph: {
                                                id: "Pengembangan industri hijau membutuhkan partisipasi aktif dari seluruh sektor.\n\nKomitmen terhadap kelestarian lingkungan akan menciptakan stabilitas ekonomi.",
                                                en: "The development of green industry requires active participation from all sectors.\n\nCommitment to environmental sustainability will create economic stability."
                                            }
                                        },
                                        'Appositives': {
                                            sentences: [
                                                { id: "Jakarta, ibu kota Indonesia, adalah kota yang sangat padat.", en: "Jakarta, the capital city of Indonesia, is a very crowded city." },
                                                { id: "Borobudur, candi Buddha terkenal, terletak di Jawa Tengah.", en: "Borobudur, a famous Buddhist temple, is located in Central Java." },
                                                { id: "Dr. Smith, seorang pakar ekonomi terkemuka, memberikan kuliah hari ini.", en: "Dr. Smith, a leading economic expert, gave a lecture today." },
                                                { id: "Rendang, makanan tradisional dari Minangkabau, sangat populer.", en: "Rendang, a traditional food from Minangkabau, is very popular." },
                                                { id: "Penyanyi Bruno Mars akan mengadakan konser bulan depan.", en: "The singer Bruno Mars will hold a concert next month." },
                                                { id: "Oksigen, unsur penting bagi kehidupan, dihasilkan oleh tumbuhan.", en: "Oxygen, an essential element for life, is produced by plants." },
                                                { id: "Planet Jupiter, raksasa gas terbesar di tata surya, memiliki banyak bulan.", en: "Planet Jupiter, the largest gas giant in the solar system, has many moons." },
                                                { id: "Seniman terkenal Vincent van Gogh melukis The Starry Night.", en: "The famous artist Vincent van Gogh painted The Starry Night." },
                                                { id: "Komputer, alat elektronik canggih, mempermudah komunikasi.", en: "Computers, advanced electronic devices, facilitate communication." },
                                                { id: "Sungai Nil, sungai terpanjang di dunia, mengalir melalui Mesir.", en: "The Nile, the longest river in the world, flows through Egypt." }
                                            ],
                                            paragraph: {
                                                id: "Dr. Amelia, seorang peneliti biologi kelautan, memimpin ekspedisi di Samudra Pasifik.\n\nEkspedisi tersebut bertujuan mempelajari terumbu karang, ekosistem laut yang sangat rentan.",
                                                en: "Dr. Amelia, a marine biology researcher, led an expedition in the Pacific Ocean.\n\nThe expedition aimed to study coral reefs, highly vulnerable marine ecosystems."
                                            }
                                        },
                                        'Inversion': {
                                            sentences: [
                                                { id: "Jarang sekali seorang pemimpin mengakui kesalahannya di depan umum.", en: "Rarely does a leader admit his mistakes in public." },
                                                { id: "Sangat sedikit yang disadari manajer tentang krisis keuangan tersebut.", en: "Little did the manager realize about the financial crisis." },
                                                { id: "Hanya setelah laporan diterbitkan, kebenaran terungkap.", en: "Only after the report was published was the truth revealed." },
                                                { id: "Jarang sekali pasar mengalami stabilitas tanpa campur tangan pemerintah.", en: "Seldom does the market experience stability without government intervention." },
                                                { id: "Seandainya dewan menyetujui proposal tersebut, perusahaan tidak akan bangkrut.", en: "Had the board approved the proposal, the company would not have gone bankrupt." },
                                                { id: "Tidak pernah sebelumnya masyarakat menyaksikan perubahan teknologi secepat ini.", en: "Never before has society witnessed such rapid technological change." },
                                                { id: "Hanya dengan bekerja keras kita dapat mencapai hasil maksimal.", en: "Only by working hard can we achieve maximum results." },
                                                { id: "Hampir tidak pernah sistem ini mengalami kegagalan.", en: "Hardly ever does this system experience failure." },
                                                { id: "Seandainya kamu tiba lebih awal, kita tidak akan ketinggalan kereta.", en: "Were you to arrive earlier, we would not miss the train." },
                                                { id: "Dalam keadaan apa pun aturan keselamatan tidak boleh dilanggar.", en: "Under no circumstances may safety rules be breached." }
                                            ],
                                            paragraph: {
                                                id: "Jarang sekali perusahaan mengalami pertumbuhan pesat tanpa strategi yang matang.\n\nHanya setelah melakukan investasi riset yang mendalam, inovasi dapat tercipta.",
                                                en: "Seldom does a company experience rapid growth without a mature strategy.\n\nOnly after conducting deep research investments can innovation be created."
                                            }
                                        },
                                        'Default': {
                                            sentences: [
                                                { id: "Manajer percaya bahwa pelanggan memiliki kebutuhan yang unik.", en: "The manager believes customers have unique needs." },
                                                { id: "Universitas yang menyediakan beasiswa riset menarik mahasiswa internasional.", en: "Universities providing research scholarships attract international students." },
                                                { id: "Beberapa spesies menjadi punah setelah berevolusi.", en: "Several species become extinct after evolving." },
                                                { id: "Efisiensi sistem operasional perusahaan telah meningkat secara signifikan.", en: "The efficiency of the company operational system has improved significantly." },
                                                { id: "Dr. Smith, seorang pakar ekonomi terkemuka, memberikan kuliah hari ini.", en: "Dr. Smith, a leading economic expert, gave a lecture today." },
                                                { id: "Jarang sekali seorang pemimpin mengakui kesalahannya di depan umum.", en: "Rarely does a leader admit his mistakes in public." },
                                                { id: "Adalah dedikasi tim medis yang berhasil mengendalikan penyebaran virus.", en: "It was the dedication of the medical team that controlled the spread of the virus." },
                                                { id: "Jika pemerintah menerapkan reformasi, ekonomi akan pulih dengan cepat.", en: "If the government implements reforms, the economy will recover quickly." },
                                                { id: "Penelitian yang dilakukan oleh tim independen memverifikasi temuan tersebut.", en: "Research conducted by an independent team verified the findings." },
                                                { id: "Pembangunan infrastruktur berkelanjutan adalah prioritas pemerintah.", en: "Sustainable infrastructure development is a government priority." }
                                            ],
                                            paragraph: {
                                                id: "Pengembangan industri hijau membutuhkan partisipasi aktif dari seluruh sektor.\n\nKomitmen terhadap kelestarian lingkungan akan menciptakan stabilitas ekonomi.",
                                                en: "The development of green industry requires active participation from all sectors.\n\nCommitment to environmental sustainability will create economic stability."
                                            }
                                        }
                                    };

                                    let matchKey = 'Default';
                                    const searchStr = String(topicsList || '');
                                    for (let key in fallbackBank) {
                                        if (searchStr.includes(key)) {
                                            matchKey = key;
                                            break;
                                        }
                                    }

                                    const selected = fallbackBank[matchKey] || fallbackBank['Default'];
                                    const parsed = {
                                        sentences: selected.sentences.map(s => ({
                                            id: s.id,
                                            en: s.en,
                                            answer: '',
                                            submitted: false,
                                            evaluation: '',
                                            isExplaining: false,
                                            ai_explanation: ''
                                        })),
                                        paragraph: {
                                            id: selected.paragraph.id,
                                            en: selected.paragraph.en,
                                            answer: '',
                                            submitted: false,
                                            evaluation: '',
                                            isExplaining: false,
                                            ai_explanation: ''
                                        }
                                    };

                                    this.output = parsed;
                                    this.error = null;
                                    this.saveState();
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
                    <div
                        class="bg-white rounded-3xl shadow-xl overflow-hidden border border-teal-100 p-12 flex flex-col items-center justify-center min-h-[400px]">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada latihan</h3>
                        <p class="text-gray-500 text-center max-w-md">Latihan untuk tingkat ini sedang dalam tahap
                            persiapan. Silakan kembali lagi nanti.</p>
                    </div>
                @endif
        </main>
    </div>

    @include('assignments.ielts.writing.practice_toolbar', [
        'meeting' => (object) ['task_type' => 3, 'prompt' => 'Grammar Practice: Latihan terjemahan kalimat bahasa Indonesia ke Inggris sesuai tata bahasa yang dipilih.'],
        'grammarLevel' => $level
    ])

    @include('components.student-broadcaster')
</body>

</html>