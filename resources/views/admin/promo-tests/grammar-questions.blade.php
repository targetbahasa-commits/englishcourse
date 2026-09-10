@extends('layouts.admin')

@section('title', 'Soal Promo Test - ' . $topic->title)

@section('content')
<div class="p-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.promo-tests.index') }}" class="text-sm text-gray-400 hover:text-gray-600">&larr; Manage Promo Tests</a>
            </div>
            <div class="flex items-center gap-3">
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ $topic->title }}</h2>
                <span class="px-3 py-1 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-xs font-bold">
                    {{ count($questions) }} Soal di Bank Soal
                </span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Kelola soal untuk halaman Promo Test ini secara langsung - editor ini terpisah dari menu Assignments, jadi tidak akan mempengaruhi akses student/guest ke program berbayar.</p>
        </div>
        <div class="flex items-center gap-3">
            @if(!$questions->isEmpty())
                <form method="POST" action="{{ route('admin.promo-tests.grammar-practice.questions.clear-all', $topic->id) }}" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus SEMUA {{ count($questions) }} soal pada topik ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3.5 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-lg font-semibold text-xs hover:bg-red-100 transition shadow-2xs">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Kosongkan Semua Soal
                    </button>
                </form>
            @endif
            <button type="button" onclick="openQuestionModal('sentence')" class="inline-flex items-center px-4 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Soal Manual
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div x-data="grammarAiGenerator({{ $topic->id }})" class="mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-purple-600 flex items-center justify-center shadow-sm shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="text-left">
                        <h3 class="font-bold text-gray-800">AI Generator Soal</h3>
                        <p class="text-xs text-gray-500">Buat soal otomatis dengan jumlah presisi: ketik topik materi, pilih level CEFR dan tema.</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="open" x-transition class="p-6 border-t border-gray-100 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-gray-800 mb-1.5">Topik Materi</label>
                        <input type="text" x-model="materialTopic" list="materialTopicOptions" placeholder="Ketik atau pilih topik materi, mis. Simple Present Passive"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                        <datalist id="materialTopicOptions">
                            @foreach ($materialTopicSuggestions as $suggestion)
                                <option value="{{ $suggestion }}"></option>
                            @endforeach
                        </datalist>
                        <p class="text-xs text-gray-500 mt-1">Bebas ketik topik apapun, atau pilih dari daftar topik yang sudah ada.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1.5">Level CEFR</label>
                        <div class="flex flex-wrap gap-1.5">
                            <template x-for="lvl in ['A1','A2','B1','B2','C1']" :key="lvl">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer px-3 py-1.5 rounded-full border text-sm font-semibold transition"
                                       :class="levels.includes(lvl) ? 'bg-purple-600 border-purple-600 text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-purple-300'">
                                    <input type="checkbox" :value="lvl" x-model="levels" class="hidden">
                                    <span x-text="lvl"></span>
                                </label>
                            </template>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih. A1 pemula &mdash; C1 mahir. Soal akan didistribusikan merata ke tiap level yang dipilih.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1.5">Tema / Konteks</label>
                        <input type="text" x-model="theme" list="themeOptions" placeholder="mis. Technology, Education, Business"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                        <datalist id="themeOptions">
                            <option value="Technology"></option>
                            <option value="Education"></option>
                            <option value="Business"></option>
                            <option value="Environment"></option>
                            <option value="Health"></option>
                            <option value="Science"></option>
                            <option value="Social"></option>
                            <option value="Mix / Campuran"></option>
                        </datalist>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-gray-700">Jumlah soal:</label>
                    <input type="number" x-model.number="count" min="1" max="20" class="w-24 rounded-lg border-gray-300 shadow-sm text-sm font-bold text-center">

                    <button type="button" @click="generate()" :disabled="generating || !materialTopic || levels.length === 0 || !theme"
                            :class="(generating || !materialTopic || levels.length === 0 || !theme) ? 'opacity-50 cursor-not-allowed bg-gray-300 text-gray-500' : 'bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white'"
                            class="ml-auto px-5 py-2.5 font-semibold rounded-xl transition flex items-center gap-2 text-sm shadow-sm">
                        <svg x-show="generating" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        <span x-text="generating ? 'Membuat Tepat ' + count + ' Soal...' : 'Buatkan ' + count + ' Soal'"></span>
                    </button>
                </div>

                <p x-show="!materialTopic || levels.length === 0 || !theme" class="text-xs text-red-600 font-medium">
                    Wajib isi Topik Materi, minimal 1 Level CEFR, dan Tema sebelum membuat soal.
                </p>

                <div x-show="error" x-text="error" class="p-3 bg-red-50 text-red-600 text-sm rounded-xl"></div>

                <!-- Preview of generated sentences, before saving -->
                <div x-show="preview.length > 0" class="space-y-4 pt-3 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-purple-50/70 p-3.5 rounded-xl border border-purple-200">
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">
                                Hasil AI: Tepat <span x-text="preview.length" class="text-purple-700 font-extrabold"></span> Soal Dibuat
                            </h4>
                            <p class="text-xs text-gray-600 mt-0.5"><span x-text="preview.filter(p => p.checked).length"></span> dari <span x-text="preview.length"></span> soal dipilih untuk disimpan.</p>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <label class="inline-flex items-center gap-2 text-xs font-semibold text-gray-700 cursor-pointer select-none bg-white px-3 py-2 rounded-lg border border-gray-200 shadow-2xs">
                                <input type="checkbox" x-model="replaceExisting" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span>Ganti/Timpa Semua Soal Lama</span>
                            </label>
                            
                            <button type="button" @click="saveChecked()" :disabled="saving || preview.filter(p => p.checked).length === 0"
                                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold rounded-lg transition shadow-sm flex items-center gap-2">
                                <svg x-show="saving" class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                <span x-text="saving ? 'Menyimpan...' : (replaceExisting ? 'Simpan & Ganti Soal Lama' : 'Tambahkan ke Bank Soal')"></span>
                            </button>
                        </div>
                    </div>

                    <template x-for="(item, idx) in preview" :key="idx">
                        <div class="flex items-start gap-3 p-3 rounded-xl border" :class="item.checked ? 'border-purple-200 bg-purple-50/40' : 'border-gray-200 bg-gray-50'">
                            <span class="mt-2 text-xs font-bold text-gray-500 w-5 text-center" x-text="idx + 1"></span>
                            <input type="checkbox" x-model="item.checked" class="mt-2 w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                            <div class="flex-1 space-y-2">
                                <textarea x-model="item.id" rows="2" class="w-full text-sm rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" placeholder="Soal Bahasa Indonesia"></textarea>
                                <textarea x-model="item.en" rows="2" class="w-full text-sm rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-gray-600" placeholder="Kunci Jawaban Bahasa Inggris"></textarea>
                                <template x-if="item.vocab_helper && Object.keys(item.vocab_helper).length > 0">
                                    <div class="flex flex-wrap gap-1 pt-1">
                                        <template x-for="(helper, word) in item.vocab_helper" :key="word">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-white border border-gray-200 text-gray-700 text-xs rounded-md">
                                                <strong class="text-purple-700" x-text="word"></strong>
                                                <span class="text-gray-400">=</span>
                                                <span x-text="helper.id || ''"></span>
                                                <template x-if="helper.pos">
                                                    <span class="text-[10px] px-1 bg-gray-100 text-gray-600 rounded font-mono" x-text="helper.pos"></span>
                                                </template>
                                            </span>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            <select x-model="item.level" class="mt-1 rounded-lg border-gray-300 shadow-sm text-xs font-bold text-purple-700 py-1">
                                <template x-for="lvl in ['A1','A2','B1','B2','C1']" :key="lvl">
                                    <option :value="lvl" x-text="lvl"></option>
                                </template>
                            </select>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        @if($questions->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="bg-gray-50 p-4 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada soal</h3>
                <p class="text-gray-500 mt-1 mb-6 max-w-sm">Gunakan AI Generator di atas atau klik tombol Tambah Soal Manual untuk mengisi bank soal topik ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Level</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kunci Jawaban</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($questions as $idx => $q)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-500">{{ $idx + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $q->type === 'paragraph' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($q->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($q->cefr_level)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800">{{ $q->cefr_level }}</span>
                                    @else
                                        <span class="text-xs text-gray-300">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 max-w-md text-sm text-gray-800">
                                    <div>{!! $q->question_id !!}</div>
                                    @if(!empty($q->vocab_helper) && is_array($q->vocab_helper))
                                        <div class="flex flex-wrap gap-1 mt-1.5">
                                            @foreach($q->vocab_helper as $word => $helper)
                                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-gray-100 text-gray-700 text-[11px] rounded border border-gray-200">
                                                    <strong class="text-teal-700">{{ $word }}</strong> = {{ $helper['id'] ?? '' }}
                                                    @if(!empty($helper['pos']))
                                                        <span class="text-[9px] px-1 bg-gray-200 text-gray-600 rounded font-mono">{{ $helper['pos'] }}</span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 max-w-md text-sm text-gray-600">{{ $q->answer_en }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <button type="button"
                                            onclick="openQuestionModal('{{ $q->type }}', {{ $q->id }}, {{ Illuminate\Support\Js::from($q->question_id) }}, {{ Illuminate\Support\Js::from($q->answer_en) }}, {{ Illuminate\Support\Js::from($q->vocab_helper ? json_encode($q->vocab_helper) : '') }}, {{ Illuminate\Support\Js::from($q->example ? json_encode($q->example) : '') }}, {{ Illuminate\Support\Js::from($q->cefr_level ?? '') }})"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <button type="button" onclick="confirmDeleteQuestion({{ $q->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Question Modal -->
<div id="questionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 shrink-0">
            <h3 id="questionModalTitle" class="text-xl font-bold text-gray-800">Tambah Soal</h3>
            <button onclick="closeQuestionModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <form id="questionForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="questionMethod" value="POST">
                <input type="hidden" name="type" id="questionType" value="sentence">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Level CEFR (Opsional)</label>
                        <select name="cefr_level" id="questionCefrLevel" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">&mdash; Tidak ditentukan &mdash;</option>
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="C1">C1</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan (Indonesian)</label>
                        <textarea name="question_id" id="questionId" rows="3" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Gunakan tag &lt;strong&gt;teks&lt;/strong&gt; untuk menebalkan kata.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kunci Jawaban (English)</label>
                        <textarea name="answer_en" id="questionEn" rows="3" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vocabulary Helper (JSON)</label>
                        <textarea name="vocab_helper" id="questionVocab" rows="4" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" placeholder='{"word": {"pos": "v", "id": "arti"}}'></textarea>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada.</p>
                    </div>

                    <div id="exampleField" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Example Helper (JSON)</label>
                        <input type="text" name="example" id="questionExample" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" placeholder='{"id": "contoh", "en": "example"}'>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada.</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeQuestionModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteQuestionForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function grammarAiGenerator(topicId) {
        return {
            open: false,
            materialTopic: '',
            levels: [],
            theme: '',
            count: 10,
            generating: false,
            saving: false,
            replaceExisting: true,
            error: '',
            preview: [],

            async generate() {
                if (this.generating || !this.materialTopic || this.levels.length === 0 || !this.theme) return;
                this.generating = true;
                this.error = '';
                this.preview = [];

                // AI can cascade through several providers server-side before giving up;
                // without a client-side cap the button could look like it spins forever
                // if that whole chain runs long, with no feedback to the admin.
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 45000);

                try {
                    const res = await fetch(`{{ url('/admin/promo-tests/grammar-practice') }}/${topicId}/questions/generate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            material_topic: this.materialTopic,
                            levels: this.levels,
                            theme: this.theme,
                            count: this.count
                        }),
                        signal: controller.signal
                    });
                    const data = await res.json();
                    if (!res.ok || !data.success) {
                        throw new Error(data.message || 'Gagal membuat soal.');
                    }
                    this.preview = data.sentences.map(s => ({ id: s.id, en: s.en, level: s.level || this.levels[0], checked: true }));
                } catch (e) {
                    this.error = e.name === 'AbortError'
                        ? 'AI tidak merespons dalam 45 detik. Silakan coba lagi.'
                        : (e.message || 'Terjadi kesalahan saat menghubungi AI.');
                } finally {
                    clearTimeout(timeoutId);
                    this.generating = false;
                }
            },

            async saveChecked() {
                const checked = this.preview.filter(p => p.checked);
                if (this.saving || checked.length === 0) return;
                this.saving = true;
                this.error = '';

                try {
                    const res = await fetch(`{{ url('/admin/promo-tests/grammar-practice') }}/${topicId}/questions/bulk-store`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            sentences: checked.map(p => ({ id: p.id, en: p.en, level: p.level, vocab_helper: p.vocab_helper || null })),
                            replace_existing: this.replaceExisting
                        })
                    });
                    if (!res.ok) {
                        const data = await res.json().catch(() => ({}));
                        throw new Error(data.message || 'Gagal menyimpan soal.');
                    }
                    window.location.reload();
                } catch (e) {
                    this.error = e.message || 'Terjadi kesalahan saat menyimpan soal.';
                    this.saving = false;
                }
            }
        };
    }

    function openQuestionModal(type, id = null, idText = '', enText = '', vocab = '', example = '', cefrLevel = '') {
        const modal = document.getElementById('questionModal');
        const form = document.getElementById('questionForm');
        const method = document.getElementById('questionMethod');
        const title = document.getElementById('questionModalTitle');
        const typeInput = document.getElementById('questionType');
        const exampleField = document.getElementById('exampleField');

        document.getElementById('questionId').value = idText;
        document.getElementById('questionEn').value = enText;
        document.getElementById('questionVocab').value = vocab;
        document.getElementById('questionExample').value = example;
        document.getElementById('questionCefrLevel').value = cefrLevel;
        typeInput.value = type;

        if (type === 'sentence') {
            exampleField.classList.remove('hidden');
        } else {
            exampleField.classList.add('hidden');
            document.getElementById('questionExample').value = '';
        }

        if (id) {
            title.textContent = 'Edit Soal';
            form.action = `{{ url('/admin/promo-tests/grammar-practice/questions') }}/${id}`;
            method.value = 'PUT';
        } else {
            title.textContent = `Tambah ${type === 'sentence' ? 'Soal' : 'Paragraf'}`;
            form.action = `{{ route('admin.promo-tests.grammar-practice.questions.store', $topic->id) }}`;
            method.value = 'POST';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeQuestionModal() {
        const modal = document.getElementById('questionModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function confirmDeleteQuestion(id) {
        if (confirm('Yakin ingin menghapus soal ini?')) {
            const form = document.getElementById('deleteQuestionForm');
            form.action = `{{ url('/admin/promo-tests/grammar-practice/questions') }}/${id}`;
            form.submit();
        }
    }
</script>
@endsection
