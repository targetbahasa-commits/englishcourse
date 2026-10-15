@include('assignments.ielts.mockup.partials.reading-vocab-notes')

<!-- Quick Inline Definition Popup (When clicking words in passage) -->
<div id="definitionPopup" class="fixed bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 w-72 z-50 transition-all duration-200" style="display: none;">
    <div class="flex justify-between items-start mb-2">
        <div>
            <h4 id="def_word" class="text-base font-bold text-gray-900 capitalize"></h4>
            <p id="def_translation" class="text-sm text-emerald-600 font-semibold mt-0.5"></p>
        </div>
        <button onclick="document.getElementById('definitionPopup').style.display = 'none'" class="text-gray-400 hover:text-gray-600 p-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    
    <div class="mb-3">
        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold mb-0.5">Synonyms</p>
        <p id="def_synonyms" class="text-xs text-gray-600 leading-relaxed"></p>
    </div>

    <div class="mb-3">
        <button type="button" id="def_context_check_btn"
                onclick="checkTranslationInContext()"
                class="text-[11px] text-indigo-500 hover:text-indigo-700 flex items-center gap-1 transition">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path></svg>
            <span>Arti dalam kalimat ini?</span>
        </button>
        <p id="def_context_result" class="text-xs text-indigo-600 font-medium mt-1" style="display: none;"></p>
    </div>

    <!-- Catat Kosa Kata Button in Definition Popup -->
    <div class="mb-3">
        <button type="button" 
                onclick="window.saveCurrentPopupToVocabNotes()"
                class="w-full py-1.5 px-3 text-xs font-semibold rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white transition flex items-center justify-center gap-1.5 cursor-pointer border border-purple-200/80 shadow-sm"
                title="Simpan kosa kata ini beserta artinya ke Catatan Kosa Kata">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span id="def_save_note_btn_text">📝 Catat Kosa Kata</span>
        </button>
    </div>

    <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
        <button type="button" 
                onclick="const w = document.getElementById('def_word').innerText; if(window.speechSynthesis && w) { const u = new SpeechSynthesisUtterance(w); u.lang='en-US'; u.rate=0.9; window.speechSynthesis.speak(u); }"
                class="text-xs text-gray-400 hover:text-emerald-600 flex items-center gap-1 transition"
                title="Dengarkan pengucapan">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
            <span>Audio</span>
        </button>
        <button type="button" 
                onclick="window.openReadingDictionary(document.getElementById('def_word').innerText); document.getElementById('definitionPopup').style.display = 'none';"
                class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline flex items-center gap-1 transition">
            <span>Kamus Lengkap</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>

<script>
window.saveCurrentPopupToVocabNotes = function() {
    const wordEl = document.getElementById('def_word');
    const transEl = document.getElementById('def_translation');
    const word = wordEl ? wordEl.innerText.trim() : '';
    const trans = transEl ? transEl.innerText.trim() : '';
    const context = window.__currentDictSentence || '';

    if (word && window.addReadingVocabNote) {
        window.addReadingVocabNote({
            word: word,
            translation: (trans && trans !== 'Memuat...' && trans !== 'Error' && trans !== 'Tidak ditemukan') ? trans : null,
            context: context,
            source: 'Passage'
        });
        const btnText = document.getElementById('def_save_note_btn_text');
        if (btnText) {
            btnText.textContent = '✓ Tersimpan!';
            setTimeout(() => { if (btnText) btnText.textContent = '📝 Catat Kosa Kata'; }, 2000);
        }
    }
};
</script>

<!-- Full Reading Dictionary & Thesaurus Modal (Writing-like functionality tailored for Reading) -->
<div x-data="readingDictionaryModal()" 
     x-init="init()"
     @open-reading-dict.window="openModal($event.detail.word)"
     @keydown.escape.window="if(open) closeModal()"
     class="relative">
    
    <template x-teleport="body">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[9999] flex items-center justify-center p-3 sm:p-4"
             style="display: none;">
            
            <!-- Modal Dialog Card -->
            <div @click.outside="closeModal()"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col overflow-hidden text-left border border-gray-100">

                <!-- Header -->
                <div class="px-5 py-3.5 bg-gradient-to-r from-emerald-50 via-teal-50/40 to-white border-b border-emerald-100/80 flex justify-between items-center flex-shrink-0">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 leading-tight">Translation & Thesaurus</h3>
                            <p class="text-[11px] text-gray-500">IELTS Reading Vocabulary Companion</p>
                        </div>
                        <span class="ml-1 text-[11px] font-semibold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full border border-emerald-200/50">Auto-Detect</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button type="button" 
                                @click="resetDictionary()" 
                                class="text-gray-500 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-50 transition" 
                                title="Reset & Siap Ketik Kata Baru">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </button>
                        <button type="button" 
                                @click="closeModal()" 
                                class="text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100 transition"
                                title="Tutup (Esc)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Search Input Bar -->
                <div class="p-4 border-b border-gray-100 bg-white flex-shrink-0">
                    <form @submit.prevent="search()" class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" 
                                   x-ref="queryInput"
                                   x-model="query" 
                                   placeholder="Type a word in English or Indonesia..." 
                                   class="w-full pl-9 pr-8 py-2.5 bg-gray-50/70 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none text-sm transition">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <button type="button" 
                                    x-show="query.length > 0" 
                                    @click="query = ''; $refs.queryInput.focus()" 
                                    class="absolute right-2.5 top-2.5 text-gray-300 hover:text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <button type="submit" 
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm hover:shadow flex items-center gap-1.5 disabled:opacity-50" 
                                :disabled="loading || !query.trim()">
                            <span x-show="!loading">Search</span>
                            <span x-show="loading" class="animate-pulse">...</span>
                        </button>
                        <button type="button" 
                                @click="resetDictionary()" 
                                class="px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition border border-gray-200/80 flex items-center justify-center gap-1 text-sm font-medium" 
                                title="Reset Dictionary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span class="hidden sm:inline">Refresh</span>
                        </button>
                    </form>
                </div>

                <!-- Results Content Area -->
                <div class="flex-1 overflow-y-auto p-5 sm:p-6 bg-slate-50/70 custom-scrollbar">
                    
                    <!-- Loading State -->
                    <div x-show="loading" class="flex flex-col items-center justify-center py-12 text-gray-500">
                        <div class="w-10 h-10 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                        <span class="text-sm font-medium text-gray-600">Mencari terjemahan & sinonim...</span>
                    </div>

                    <!-- Error State -->
                    <div x-show="error && !loading" class="text-center py-6 px-4 text-rose-600 bg-rose-50 rounded-xl border border-rose-200/60">
                        <p class="text-sm font-medium" x-text="error"></p>
                    </div>

                    <!-- Result State -->
                    <div x-show="dictResult && !loading" class="space-y-4">
                        
                        <!-- 1. TRANSLATION CARD -->
                        <div class="bg-white p-5 rounded-2xl border border-emerald-200/70 shadow-sm">
                            <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">1. Translation</h4>
                                <template x-if="dictResult?.pos?.length > 0">
                                    <div class="flex gap-1">
                                        <template x-for="p in dictResult.pos" :key="p">
                                            <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded italic" x-text="p"></span>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                                <!-- Source -->
                                <div class="text-center flex-1 w-full">
                                    <p class="text-[11px] text-gray-400 uppercase font-bold tracking-wide mb-1" x-text="dictResult?.source === 'en' ? 'English' : 'Indonesia'"></p>
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-xl font-medium text-gray-900" x-text="dictResult?.original"></span>
                                        <button type="button" @click="playAudio(dictResult?.original, dictResult?.source == 'en' ? 'en-US' : 'id-ID')" class="p-1 text-gray-400 hover:text-emerald-600 rounded-full hover:bg-gray-100 transition" title="Dengarkan pengucapan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="text-emerald-400 shrink-0">
                                    <svg class="w-6 h-6 rotate-90 md:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </div>

                                <!-- Target -->
                                <div class="text-center flex-1 w-full">
                                    <p class="text-[11px] text-gray-400 uppercase font-bold tracking-wide mb-1" x-text="dictResult?.source === 'en' ? 'Indonesia' : 'English'"></p>
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-2xl font-bold text-emerald-700" x-text="dictResult?.translation"></span>
                                        <button type="button" @click="playAudio(dictResult?.translation, dictResult?.source == 'en' ? 'id-ID' : 'en-US')" class="p-1 text-emerald-400 hover:text-emerald-700 rounded-full hover:bg-emerald-50 transition" title="Dengarkan pengucapan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Save to Vocab Notes Button in Dictionary Modal -->
                            <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                                <button type="button" 
                                        @click="window.addReadingVocabNote({ word: dictResult?.original, translation: dictResult?.translation, source: 'Kamus' })"
                                        class="px-3.5 py-1.5 text-xs font-semibold rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white transition flex items-center gap-1.5 cursor-pointer border border-purple-200/80 shadow-sm"
                                        title="Simpan kosa kata ini ke Catatan Kosa Kata">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>+ Simpan ke Catatan Kosa Kata</span>
                                </button>
                            </div>
                        </div>

                        <!-- 2. EXAMPLES -->
                        <div x-show="dictResult?.examples?.length > 0" class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/80 shadow-sm">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">2. Examples (Contoh Kalimat)</h4>
                            <div class="space-y-2">
                                <template x-for="(example, idx) in dictResult?.examples" :key="idx">
                                    <div class="p-3 bg-gray-50/70 rounded-xl border border-gray-100 flex items-start gap-2.5">
                                        <span class="text-emerald-600 font-bold text-xs mt-0.5">•</span>
                                        <p class="text-gray-700 text-xs sm:text-sm italic leading-relaxed" x-text="`&quot;${example}&quot;`"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 3. SYNONYMS / THESAURUS -->
                        <div x-show="dictResult?.synonyms?.length > 0" class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/80 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">3. Synonyms (Sinonim)</h4>
                                <span class="text-[11px] text-gray-400">Klik sinonim untuk melihat artinya</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="syn in dictResult?.synonyms" :key="syn">
                                    <button type="button"
                                            @click="query = syn; search()" 
                                            class="px-3 py-1.5 bg-gray-100 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 rounded-lg text-xs font-semibold transition border border-gray-200 hover:border-emerald-300 hover:scale-105 active:scale-95"
                                            x-text="syn">
                                    </button>
                                </template>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Initial / Empty State -->
                    <div x-show="!dictResult && !loading && !error" class="text-center py-12 text-gray-400">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h4 class="text-sm font-bold text-gray-700 mb-1">Cari Kata & Kosakata IELTS</h4>
                        <p class="text-xs text-gray-500 max-w-sm mx-auto">Ketik kata apa pun dalam bahasa Inggris atau Indonesia untuk melihat terjemahan, pelafalan audio, contoh kalimat, dan sinonim.</p>
                    </div>

                </div>

                <!-- Footer -->
                <div class="px-5 py-3 border-t border-gray-100 bg-white flex justify-between items-center text-xs text-gray-400 flex-shrink-0">
                    <span class="text-[11px]" x-text="dictResult?.usedSource ? `Sumber: ${dictResult.usedSource} & Datamuse` : 'Target Bahasa • IELTS Reading Companion'"></span>
                    <button type="button" @click="closeModal()" class="text-xs text-gray-500 hover:text-gray-800 font-medium">Tutup (Esc)</button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
/* ── Global function to open Reading Dictionary Modal from anywhere ── */
window.openReadingDictionary = window.openReadingDictionary || function(word = '') {
    window.dispatchEvent(new CustomEvent('open-reading-dict', { detail: { word: word || '' } }));
};

function readingDictionaryModal() {
    return {
        open: false,
        query: '',
        dictResult: null,
        loading: false,
        error: null,

        init() {
            window.openReadingDictionary = (word = '') => {
                this.openModal(word);
            };
        },

        openModal(word = '') {
            this.open = true;
            if (word && typeof word === 'string' && word.trim()) {
                this.query = word.trim();
                this.search();
            }
            this.$nextTick(() => {
                if (this.$refs.queryInput) {
                    this.$refs.queryInput.focus();
                    this.$refs.queryInput.select();
                }
            });
        },

        closeModal() {
            this.open = false;
        },

        resetDictionary() {
            this.query = '';
            this.dictResult = null;
            this.error = null;
            this.loading = false;
            this.$nextTick(() => {
                if (this.$refs.queryInput) {
                    this.$refs.queryInput.focus();
                }
            });
        },

        playAudio(text, lang) {
            if (!window.speechSynthesis || !text) return;
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = lang || 'en-US';
            utterance.rate = 0.9;
            window.speechSynthesis.speak(utterance);
        },

        async search() {
            if (!this.query.trim()) return;
            const q = this.query.trim();
            const cacheKey = q.toLowerCase();

            window.__tbDictCache = window.__tbDictCache || new Map();
            if (window.__tbDictCache.has(cacheKey)) {
                this.dictResult = JSON.parse(JSON.stringify(window.__tbDictCache.get(cacheKey)));
                this.loading = false;
                this.error = null;
                return;
            }

            this.loading = true;
            this.error = null;
            this.dictResult = null;

            // Language heuristic
            const idWords = /\b(yang|dan|di|ke|dari|ini|itu|dengan|untuk|pada|adalah|dapat|akan|sudah|telah|oleh|karena|juga|kita|kami|saya|kamu|mereka|hanya|bisa|harus|seperti|secara|proses|metode|sangat|lebih|masih|dalam|atau|tidak|bukan|tentang|bagi|setelah|sebelum|antara|bila|jika|ketika|serta|tersebut|adanya|merupakan)\b/i;
            const idAffixes = /(^(meng|mem|men|meny|menge|ber|ter|per|di|ke|se)[a-z]+|[a-z]+(kan|an|nya|i)$)/i;
            const enWords = /\b(the|is|are|was|were|and|or|in|on|at|to|for|with|by|from|of|that|this|these|those|have|has|had|can|could|will|would|should|may|might|must|it|its|their|they|we|you|he|she|about|into|more|most|than|then|which|what|when|where|why|how|not|been|being)\b/i;
            const enAffixes = /[a-z]+(tion|ment|ness|ity|ing|ed|ly|ous|ive|able|ible|est|er)$/i;

            // These regexes only reliably signal language on short input - on
            // a longer selection (a sentence or more) they false-positive
            // easily (e.g. idAffixes' trailing [a-z]+i$ matched "...Some si"
            // from an all-English sentence, forcing sl=id on real English
            // text - Google then has nothing Indonesian to translate and
            // just echoes the input back unchanged). Forcing `sl` from a
            // guess is the actual bug; always let Google auto-detect the
            // real source language instead. `isIndonesian` is kept only as
            // a best-guess starting point for which language to translate
            // INTO - if that guess is also wrong, the auto-detect retry
            // below (triggered when the "translation" comes back identical
            // to the input) corrects it.
            let isIndonesian = idWords.test(q) || idAffixes.test(q);
            let preferredSl = 'auto';
            let preferredTl = isIndonesian ? 'en' : 'id';

            let translation = '';
            let finalSource = 'auto'; 
            let usedSource = 'Google Translate';

            try {
                // Tier 1: Google Translate GTX
                const googleTask = async () => {
                    try {
                        const ctrl = new AbortController();
                        const tid = setTimeout(() => ctrl.abort(), 2200);
                        const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${preferredSl}&tl=${preferredTl}&dt=t&q=` + encodeURIComponent(q);
                        const res = await fetch(url, { signal: ctrl.signal });
                        clearTimeout(tid);
                        if (!res.ok) throw new Error('Google failed');
                        const data = await res.json();
                        
                        let detected = (data && data[2]) ? data[2].toLowerCase() : (isIndonesian ? 'id' : 'en');
                        let translatedText = (data && data[0] && Array.isArray(data[0])) 
                            ? data[0].map(c => (c && c[0]) ? c[0] : '').join('').trim()
                            : '';
                        
                        if (preferredSl === 'auto' && (detected === 'en' || translatedText.toLowerCase() === q.toLowerCase()) && preferredTl === 'en') {
                            const ctrl2 = new AbortController();
                            const tid2 = setTimeout(() => ctrl2.abort(), 1800);
                            const url2 = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=id&dt=t&q=' + encodeURIComponent(q);
                            const res2 = await fetch(url2, { signal: ctrl2.signal });
                            clearTimeout(tid2);
                            if (res2.ok) {
                                const data2 = await res2.json();
                                let translatedText2 = (data2 && data2[0] && Array.isArray(data2[0])) 
                                    ? data2[0].map(c => (c && c[0]) ? c[0] : '').join('').trim()
                                    : '';
                                if (translatedText2) {
                                    return { text: translatedText2, source: 'Google Translate', lang: 'en' };
                                }
                            }
                        }
                        
                        if (translatedText) {
                            return {
                                text: translatedText,
                                source: 'Google Translate',
                                lang: detected === 'id' ? 'id' : 'en'
                            };
                        }
                    } catch(e) {}
                    return null;
                };

                // Tier 2: MyMemory fallback
                const myMemoryTask = async () => {
                    try {
                        const ctrl = new AbortController();
                        const tid = setTimeout(() => ctrl.abort(), 2200);
                        const pair = (preferredTl === 'en') ? 'id|en' : 'en|id';
                        const res = await fetch('https://api.mymemory.translated.net/get?q=' + encodeURIComponent(q) + '&langpair=' + pair, { signal: ctrl.signal });
                        clearTimeout(tid);
                        if (!res.ok) return null;
                        const data = await res.json();
                        let fallbackText = data?.responseData?.translatedText || null;
                        if (fallbackText) {
                            return {
                                text: fallbackText.trim(),
                                source: 'MyMemory',
                                lang: pair === 'id|en' ? 'id' : 'en'
                            };
                        }
                    } catch(e) {}
                    return null;
                };

                // Tier 3: Local backend dictionary
                const localApiTask = async () => {
                    try {
                        const res = await fetch(`{{ Route::has('api.dictionary.lookup') ? route('api.dictionary.lookup') : url('/api/dictionary/lookup') }}?word=${encodeURIComponent(q)}`);
                        if (!res.ok) return null;
                        const data = await res.json();
                        if (data && data.found) {
                            return {
                                text: data.translation,
                                source: 'TargetBahasa Dict',
                                lang: 'en',
                                synonyms: (data.synonyms && data.synonyms !== '-') ? data.synonyms.split(',').map(s=>s.trim()) : []
                            };
                        }
                    } catch(e) {}
                    return null;
                };

                let res = await googleTask();
                if (!res || !res.text) res = await myMemoryTask();
                if (!res || !res.text) res = await localApiTask();

                if (res && res.text) {
                    translation = res.text;
                    usedSource = res.source;
                    finalSource = res.lang || 'auto';
                }

                if (!translation) throw new Error('Terjemahan tidak ditemukan.');
                if (finalSource !== 'id' && finalSource !== 'en') finalSource = isIndonesian ? 'id' : 'en';

                // Examples, POS & Synonyms
                const englishWord = finalSource === 'en' ? q : translation;
                const cleanEnglish = englishWord.replace(/[^a-zA-Z\s-]/g, '').trim();
                let examples = [];
                let synonyms = (res && res.synonyms) ? res.synonyms : [];
                let pos = [];

                if (cleanEnglish && cleanEnglish.split(/\s+/).length === 1) {
                    const dictCtrl = new AbortController();
                    const dictTid = setTimeout(() => dictCtrl.abort(), 2000);

                    try {
                        const [dictRes, museRes] = await Promise.allSettled([
                            fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(cleanEnglish)}`, { signal: dictCtrl.signal }).then(r => r.ok ? r.json() : null),
                            fetch(`https://api.datamuse.com/words?rel_syn=${encodeURIComponent(cleanEnglish)}&max=10`, { signal: dictCtrl.signal }).then(r => r.ok ? r.json() : null)
                        ]);
                        clearTimeout(dictTid);

                        const dictData = dictRes.status === 'fulfilled' ? dictRes.value : null;
                        const museData = museRes.status === 'fulfilled' ? museRes.value : null;

                        if (Array.isArray(dictData)) {
                            dictData.forEach(entry => {
                                if (entry.meanings) {
                                    entry.meanings.forEach(m => {
                                        if (m.partOfSpeech) pos.push(m.partOfSpeech);
                                        if (m.definitions) {
                                            m.definitions.forEach(d => {
                                                if (d.example) examples.push(d.example);
                                            });
                                        }
                                    });
                                }
                            });
                        }
                        if (Array.isArray(museData)) {
                            const museSyns = museData.map(i => i.word).filter(Boolean);
                            synonyms = [...new Set([...synonyms, ...museSyns])];
                        }
                    } catch (err) {}
                }

                const finalResult = {
                    source: finalSource,
                    original: q,
                    translation: translation,
                    examples: [...new Set(examples)].slice(0, 3),
                    synonyms: synonyms.slice(0, 10),
                    pos: [...new Set(pos)],
                    usedSource: usedSource
                };

                this.dictResult = finalResult;
                window.__tbDictCache.set(cacheKey, finalResult);

            } catch(e) {
                console.error(e);
                this.error = 'Terjemahan tidak tersedia saat ini. Silakan periksa koneksi atau coba kata lain.';
            } finally {
                this.loading = false;
            }
        }
    };
}

/* ── Inline Passage Translation & Question-to-Passage Interactive Highlighting ── */
function getPassageContainers(passageNum = null) {
    if (passageNum) {
        // 1. Direct ID matching: #passage-1, #passage-2, #passage-3
        const pEl = document.getElementById(`passage-${passageNum}`);
        if (pEl) {
            const contents = pEl.querySelectorAll('.passage-content');
            if (contents.length > 0) return Array.from(contents);
            return [pEl];
        }

        // 2. By .passage-content index (0 = Passage 1, 1 = Passage 2, 2 = Passage 3)
        const allPassages = document.querySelectorAll('.passage-content');
        if (allPassages.length >= passageNum) {
            return [allPassages[passageNum - 1]];
        }

        // 3. By data-passage attribute
        const dataPassage = document.querySelector(`[data-passage="${passageNum}"], [data-passage-index="${passageNum}"]`);
        if (dataPassage) {
            const contents = dataPassage.querySelectorAll('.passage-content');
            if (contents.length > 0) return Array.from(contents);
            return [dataPassage];
        }
    }

    const directPassages = document.querySelectorAll('.passage-content');
    if (directPassages.length > 0) return Array.from(directPassages);

    const leftPane = document.getElementById('passage-pane') 
        || document.getElementById('text-pane') 
        || document.querySelector('[data-is-passage-pane="true"]')
        || document.querySelector('.reading-text');
    if (leftPane) return [leftPane];

    return [];
}

function unwrapTranslateWords(container) {
    if (!container) return;
    const spans = container.querySelectorAll('.translate-word');
    spans.forEach(span => {
        const parent = span.parentNode;
        if (parent) {
            parent.replaceChild(document.createTextNode(span.textContent), span);
            parent.normalize();
        }
    });
}

function wrapContainerTextNodes(container) {
    if (!container) return;
    const walker = document.createTreeWalker(
        container,
        NodeFilter.SHOW_TEXT,
        {
            acceptNode: function(node) {
                if (!node.parentNode) return NodeFilter.FILTER_REJECT;
                const parent = node.parentNode;
                const tag = parent.tagName;

                // Never touch form controls, buttons, scripts, or existing translate spans
                if (['OPTION', 'SELECT', 'INPUT', 'TEXTAREA', 'BUTTON', 'SCRIPT', 'STYLE', 'SVG', 'PATH'].includes(tag)) {
                    return NodeFilter.FILTER_REJECT;
                }
                if (parent.closest && (parent.closest('#questions-floating-toolbar') || parent.closest('#ielts-reading-autosave-container') || parent.closest('button') || parent.closest('select'))) {
                    return NodeFilter.FILTER_REJECT;
                }
                if (parent.classList && parent.classList.contains('translate-word')) {
                    return NodeFilter.FILTER_REJECT;
                }
                if (!node.nodeValue || !node.nodeValue.trim()) {
                    return NodeFilter.FILTER_SKIP;
                }
                return NodeFilter.FILTER_ACCEPT;
            }
        },
        false
    );

    const textNodes = [];
    let n;
    while ((n = walker.nextNode())) {
        textNodes.push(n);
    }

    textNodes.forEach(textNode => {
        const parent = textNode.parentNode;
        if (!parent || (parent.classList && parent.classList.contains('translate-word'))) return;

        const tokens = (textNode.nodeValue || '').match(/([a-zA-Z0-9\-\']+|[^a-zA-Z0-9\-\'\s]+|\s+)/g) || [];
        if (tokens.length === 0) return;

        const frag = document.createDocumentFragment();
        tokens.forEach(token => {
            if (/^[a-zA-Z0-9\-\']+$/.test(token)) {
                const span = document.createElement('span');
                span.className = 'translate-word cursor-pointer hover:bg-yellow-200 hover:text-yellow-800 rounded px-0.5 transition-colors border-b border-dashed border-gray-400';
                span.textContent = token;
                span.setAttribute('onclick', `lookupWord('${token.replace(/'/g, "\\'")}', event)`);
                frag.appendChild(span);
            } else {
                frag.appendChild(document.createTextNode(token));
            }
        });

        parent.replaceChild(frag, textNode);
    });
}

function showTranslateToast(msg, type = 'info') {
    let toast = document.getElementById('translate-toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'translate-toast-notification';
        document.body.appendChild(toast);
    }
    const bg = type === 'success' ? '#10b981' : (type === 'warn' ? '#f59e0b' : '#3b82f6');
    toast.style.cssText = `position: fixed; top: 70px; right: 20px; background-color: ${bg}; color: #ffffff; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; box-shadow: 0 10px 25px -3px rgba(0,0,0,0.15); z-index: 9999; transition: opacity 0.3s ease; pointer-events: none; max-width: 380px; display: flex; align-items: center; gap: 8px;`;
    toast.innerHTML = `<svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> <span>${msg}</span>`;
    toast.style.opacity = '1';

    clearTimeout(window.__translateToastTimeout);
    window.__translateToastTimeout = setTimeout(() => {
        if (toast) toast.style.opacity = '0';
    }, 3200);
}

function toggleTranslate(arg1, arg2 = null) {
    let active = true;
    let target = null;
    if (typeof arg1 === 'boolean') {
        active = arg1;
        target = arg2;
    } else if (arg1 && typeof arg1 === 'object') {
        target = arg1;
        active = (arg2 !== null) ? Boolean(arg2) : true;
    } else {
        active = Boolean(arg1);
    }

    const popup = document.getElementById('definitionPopup');
    let containers = [];
    if (target) {
        if (target.classList && target.classList.contains('passage-content')) {
            containers = [target];
        } else if (target.querySelector) {
            const inner = target.querySelector('.passage-content');
            containers = [inner || target];
        } else {
            containers = [target];
        }
    } else {
        containers = getPassageContainers();
    }

    if (!active) {
        if (popup) popup.style.display = 'none';
        containers.forEach(p => {
            unwrapTranslateWords(p);
        });
        return;
    }

    containers.forEach(contentDiv => {
        wrapContainerTextNodes(contentDiv);
    });
}

window.isQuestionsTranslateActive = false;

window.toggleQuestionsTranslate = function(forcedState = null) {
    const questionsPanel = document.getElementById('questions-panel');
    if (!questionsPanel) return;

    if (forcedState !== null) {
        window.isQuestionsTranslateActive = Boolean(forcedState);
    } else {
        window.isQuestionsTranslateActive = !window.isQuestionsTranslateActive;
    }

    const active = window.isQuestionsTranslateActive;

    // Update Header Button UI
    const headerBtn = document.getElementById('header-translate-questions-btn');
    const headerText = document.getElementById('header-translate-questions-text');
    if (headerBtn) {
        if (active) {
            headerBtn.classList.remove('bg-amber-50', 'text-amber-800', 'border-amber-200');
            headerBtn.classList.add('!bg-amber-500', '!text-white', '!border-amber-600', 'shadow-md');
            if (headerText) headerText.textContent = '✓ Translate Soal: Aktif';
        } else {
            headerBtn.classList.remove('!bg-amber-500', '!text-white', '!border-amber-600', 'shadow-md');
            headerBtn.classList.add('bg-amber-50', 'text-amber-800', 'border-amber-200');
            if (headerText) headerText.textContent = 'Translate Soal';
        }
    }

    // Update Questions Pill Button UI
    const pillBtn = document.getElementById('questions-pill-translate-btn');
    if (pillBtn) {
        if (active) {
            pillBtn.style.backgroundColor = '#facc15';
            pillBtn.style.color = '#ffffff';
            pillBtn.style.borderColor = '#eab308';
            pillBtn.style.opacity = '1';
        } else {
            pillBtn.style.backgroundColor = '';
            pillBtn.style.color = '';
            pillBtn.style.borderColor = '';
            pillBtn.style.opacity = '';
        }
    }

    if (!active) {
        unwrapTranslateWords(questionsPanel);
        const popup = document.getElementById('definitionPopup');
        if (popup) popup.style.display = 'none';
        showTranslateToast('Translate Soal dinonaktifkan', 'info');
        return;
    }

    // When Translate is active, deactivate other question tools
    if (window.questionsHighlightMode || window.questionsPencilMode || window.questionsEraserMode) {
        window.questionsHighlightMode = false;
        window.questionsPencilMode = false;
        window.questionsEraserMode = false;
        window.updateQuestionsToolbarUI();
    }

    wrapContainerTextNodes(questionsPanel);
    showTranslateToast('Translate Soal aktif: Klik kata dalam soal untuk melihat arti', 'success');
};

/* ── Questions Pane Annotations (Highlight, Pencil / Coret-coret, Eraser) ── */
window.questionsHighlightColor = 'yellow';
window.questionsHighlightMode = false;
window.questionsPencilMode = false;
window.questionsEraserMode = false;
window.questionsCanvasController = null;

window.setQuestionsHighlightColor = function(color) {
    window.questionsHighlightColor = color;
    const picker = document.getElementById('questions-color-picker');
    if (!picker) return;
    picker.querySelectorAll('button[data-color]').forEach(btn => {
        const c = btn.dataset.color;
        if (c === color) {
            btn.style.transform = 'scale(1.15)';
            const ringColor = c === 'yellow' ? '#eab308' : c === 'green' ? '#22c55e' : c === 'blue' ? '#3b82f6' : '#ec4899';
            btn.style.boxShadow = `0 0 0 2px #ffffff, 0 0 0 4px ${ringColor}`;
        } else {
            btn.style.transform = 'scale(1)';
            btn.style.boxShadow = 'none';
        }
    });
};

window.ensureQuestionsCanvas = function() {
    const questionsPanel = document.getElementById('questions-panel') || document.getElementById('questions-pane');
    if (!questionsPanel) return null;
    const innerContainer = questionsPanel.querySelector('.px-4, .sm\\:px-6') || questionsPanel.firstElementChild || questionsPanel;
    innerContainer.style.position = 'relative';

    let canvas = document.getElementById('questions-drawing-canvas');
    if (!canvas) {
        canvas = document.createElement('canvas');
        canvas.id = 'questions-drawing-canvas';
        canvas.className = 'absolute inset-0 w-full h-full pointer-events-none rounded-2xl';
        canvas.style.cssText = 'position:absolute; top:0; left:0; width:100%; height:100%; z-index:22; pointer-events:none; border-radius:1rem;';
        innerContainer.insertBefore(canvas, innerContainer.firstChild);

        if (window.ResizeObserver) {
            new ResizeObserver(() => {
                if (window.questionsCanvasController) {
                    window.questionsCanvasController.resize();
                }
            }).observe(innerContainer);
        }
    }

    if (!window.questionsCanvasController && window.initDrawingCanvas) {
        window.questionsCanvasController = window.initDrawingCanvas(canvas, questionsPanel);
    }
    return canvas;
};

window.updateQuestionsToolbarUI = function() {
    const hlBtn = document.getElementById('questions-pill-highlight-btn');
    const penBtn = document.getElementById('questions-pill-pencil-btn');
    const eraBtn = document.getElementById('questions-pill-eraser-btn');
    const picker = document.getElementById('questions-color-picker');
    const canvas = window.ensureQuestionsCanvas();

    if (hlBtn) {
        if (window.questionsHighlightMode) {
            hlBtn.style.backgroundColor = '#22c55e';
            hlBtn.style.color = '#ffffff';
            hlBtn.style.borderColor = '#16a34a';
            hlBtn.style.opacity = '1';
        } else {
            hlBtn.style.backgroundColor = '';
            hlBtn.style.color = '';
            hlBtn.style.borderColor = '';
            hlBtn.style.opacity = '';
        }
    }

    if (penBtn) {
        if (window.questionsPencilMode) {
            penBtn.style.backgroundColor = '#3b82f6';
            penBtn.style.color = '#ffffff';
            penBtn.style.borderColor = '#2563eb';
            penBtn.style.opacity = '1';
        } else {
            penBtn.style.backgroundColor = '';
            penBtn.style.color = '';
            penBtn.style.borderColor = '';
            penBtn.style.opacity = '';
        }
    }

    if (eraBtn) {
        if (window.questionsEraserMode) {
            eraBtn.style.backgroundColor = '#6366f1';
            eraBtn.style.color = '#ffffff';
            eraBtn.style.borderColor = '#4f46e5';
            eraBtn.style.opacity = '1';
        } else {
            eraBtn.style.backgroundColor = '';
            eraBtn.style.color = '';
            eraBtn.style.borderColor = '';
            eraBtn.style.opacity = '';
        }
    }

    if (picker) {
        picker.style.display = window.questionsHighlightMode ? 'flex' : 'none';
        if (window.questionsHighlightMode) {
            window.setQuestionsHighlightColor(window.questionsHighlightColor || 'yellow');
        }
    }

    if (canvas) {
        if (window.questionsPencilMode || window.questionsEraserMode) {
            canvas.style.pointerEvents = 'auto';
            canvas.style.cursor = 'crosshair';
            if (window.questionsCanvasController) {
                window.questionsCanvasController.setMode(window.questionsPencilMode ? 'draw' : 'erase');
            }
        } else {
            canvas.style.pointerEvents = 'none';
            canvas.style.cursor = 'default';
        }
    }
};

window.toggleQuestionsHighlight = function() {
    window.questionsHighlightMode = !window.questionsHighlightMode;
    if (window.questionsHighlightMode) {
        window.questionsPencilMode = false;
        window.questionsEraserMode = false;
        if (window.isQuestionsTranslateActive) {
            window.toggleQuestionsTranslate(false);
        }
        showTranslateToast('Highlight Soal aktif: Seleksi teks pada soal untuk menyorot', 'success');
    }
    window.updateQuestionsToolbarUI();
};

window.toggleQuestionsPencil = function() {
    window.questionsPencilMode = !window.questionsPencilMode;
    if (window.questionsPencilMode) {
        window.questionsHighlightMode = false;
        window.questionsEraserMode = false;
        if (window.isQuestionsTranslateActive) {
            window.toggleQuestionsTranslate(false);
        }
        showTranslateToast('Coret-coret Soal aktif: Gambar / tulis bebas pada soal', 'info');
    }
    window.updateQuestionsToolbarUI();
};

window.toggleQuestionsEraser = function() {
    window.questionsEraserMode = !window.questionsEraserMode;
    if (window.questionsEraserMode) {
        window.questionsHighlightMode = false;
        window.questionsPencilMode = false;
        if (window.isQuestionsTranslateActive) {
            window.toggleQuestionsTranslate(false);
        }
        showTranslateToast('Penghapus Soal aktif: Usap coretan atau klik highlight untuk menghapus', 'warning');
    }
    window.updateQuestionsToolbarUI();
};

function injectQuestionsTranslateUI() {
    // 1. Header Buttons
    const headerContainer = document.querySelector('.reading-fixed-shell .flex.items-center.gap-3');
    if (headerContainer) {
        // 1a. Translate Soal Button
        if (!document.getElementById('header-translate-questions-btn')) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.id = 'header-translate-questions-btn';
            btn.onclick = () => window.toggleQuestionsTranslate();
            btn.title = 'Terjemahkan teks soal / pertanyaan (klik kata untuk melihat arti)';
            btn.className = 'px-3.5 py-1.5 text-xs font-semibold rounded-lg flex items-center gap-1.5 transition shadow-sm border border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100 hover:border-amber-300 cursor-pointer';
            btn.innerHTML = `
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                <span id="header-translate-questions-text">Translate Soal</span>
            `;

            const dictBtn = headerContainer.querySelector('button[title*="Kamus"], button[onclick*="Dictionary"], button[onclick*="reading-dict"]');
            if (dictBtn) {
                headerContainer.insertBefore(btn, dictBtn);
            } else {
                headerContainer.insertBefore(btn, headerContainer.firstChild);
            }
        }

        // 1b. Catatan Kosa Kata Header Button
        if (!document.getElementById('header-vocab-notes-btn')) {
            const notesBtn = document.createElement('button');
            notesBtn.type = 'button';
            notesBtn.id = 'header-vocab-notes-btn';
            notesBtn.onclick = () => window.openReadingVocabNotes();
            notesBtn.title = 'Buka Catatan Kosa Kata & Download PDF';
            notesBtn.className = 'relative px-3.5 py-1.5 text-xs font-semibold rounded-lg flex items-center gap-1.5 transition shadow-sm border border-purple-200 bg-purple-50 text-purple-800 hover:bg-purple-100 hover:border-purple-300 cursor-pointer';
            notesBtn.innerHTML = `
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Catatan Kosa Kata</span>
                <span class="vocab-notes-badge-count ml-0.5 px-1.5 py-0.2 rounded-full bg-purple-600 text-white text-[10px] font-bold" style="display: none;">0</span>
            `;

            const dictBtn = headerContainer.querySelector('button[title*="Kamus"], button[onclick*="Dictionary"], button[onclick*="reading-dict"]');
            if (dictBtn && dictBtn.nextSibling) {
                headerContainer.insertBefore(notesBtn, dictBtn.nextSibling);
            } else {
                headerContainer.appendChild(notesBtn);
            }
            if (window.refreshVocabBadges) window.refreshVocabBadges();
        }
    }

    // 2. Ensure Canvas is present in Questions Panel
    window.ensureQuestionsCanvas();

    // 3. Questions Floating Pill Toolbar
    const questionsPanel = document.getElementById('questions-panel') || document.getElementById('questions-pane');
    if (questionsPanel && !document.getElementById('questions-floating-toolbar')) {
        const innerContainer = questionsPanel.querySelector('.px-4, .sm\\:px-6') || questionsPanel.firstElementChild || questionsPanel;
        const toolbar = document.createElement('div');
        toolbar.id = 'questions-floating-toolbar';
        toolbar.className = 'sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-6 mb-2';
        toolbar.innerHTML = `
            <!-- Questions Colour Picker (shown when Highlight tool is active) -->
            <div id="questions-color-picker"
                 class="flex gap-2 p-2 bg-white/95 backdrop-blur-md rounded-full shadow-xl border border-gray-100 mb-3 pointer-events-auto transition-all duration-200"
                 style="display: none;">
                <button type="button" data-color="yellow" onclick="window.setQuestionsHighlightColor('yellow')" class="w-8 h-8 rounded-full bg-yellow-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all cursor-pointer" title="Kuning"></button>
                <button type="button" data-color="green"  onclick="window.setQuestionsHighlightColor('green')"  class="w-8 h-8 rounded-full bg-green-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all cursor-pointer" title="Hijau"></button>
                <button type="button" data-color="blue"   onclick="window.setQuestionsHighlightColor('blue')"   class="w-8 h-8 rounded-full bg-blue-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all cursor-pointer" title="Biru"></button>
                <button type="button" data-color="pink"   onclick="window.setQuestionsHighlightColor('pink')"   class="w-8 h-8 rounded-full bg-pink-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all cursor-pointer" title="Pink"></button>
            </div>

            <!-- Main Toolbar Buttons -->
            <div class="flex justify-center items-center gap-3 pointer-events-auto bg-white/40 p-1.5 rounded-full backdrop-blur-md shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-200/50">
                <!-- Dictionary -->
                <button type="button" 
                        id="questions-pill-dict-btn"
                        onclick="window.openReadingDictionary ? window.openReadingDictionary() : window.dispatchEvent(new CustomEvent('open-reading-dict', { detail: { word: '' } }))"
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white hover:opacity-100 opacity-90 hover:shadow-md hover:text-emerald-600 hover:border-emerald-400 hover:scale-105 transition-all cursor-pointer"
                        title="Dictionary & Thesaurus (Kamus Lengkap)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </button>

                <!-- Vocabulary Notes / Catatan Kosa Kata -->
                <button type="button" 
                        id="questions-pill-notes-btn"
                        onclick="window.openReadingVocabNotes()"
                        class="relative w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white hover:opacity-100 opacity-90 hover:shadow-md hover:text-purple-600 hover:border-purple-400 hover:scale-105 transition-all cursor-pointer"
                        title="Catatan Kosa Kata (Vocabulary Notes & Download PDF)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="vocab-notes-badge-count absolute -top-1 -right-1 px-1.5 min-w-[18px] h-[18px] rounded-full bg-purple-600 text-white text-[10px] font-bold flex items-center justify-center shadow-sm" style="display: none;">0</span>
                </button>

                <!-- Translate -->
                <button type="button" 
                        id="questions-pill-translate-btn"
                        onclick="window.toggleQuestionsTranslate()"
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white hover:opacity-100 opacity-90 hover:shadow-md hover:text-yellow-600 hover:border-yellow-400 hover:scale-105 transition-all cursor-pointer"
                        title="Translate Soal (Klik kata dalam soal untuk melihat arti)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                </button>

                <!-- Highlight -->
                <button type="button" 
                        id="questions-pill-highlight-btn"
                        onclick="window.toggleQuestionsHighlight()"
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-green-600 hover:border-green-400 hover:scale-105 transition-all cursor-pointer"
                        title="Highlight Soal (Sorot teks dalam soal)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>

                <!-- Pencil / Coret-coret -->
                <button type="button" 
                        id="questions-pill-pencil-btn"
                        onclick="window.toggleQuestionsPencil()"
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-blue-600 hover:border-blue-400 hover:scale-105 transition-all cursor-pointer"
                        title="Pencil / Coret-coret Soal (Gambar & catatan bebas di panel soal)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>

                <!-- Eraser / Penghapus -->
                <button type="button" 
                        id="questions-pill-eraser-btn"
                        onclick="window.toggleQuestionsEraser()"
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-indigo-600 hover:border-indigo-400 hover:scale-105 transition-all cursor-pointer"
                        title="Penghapus Soal (Hapus coretan pensil & highlight pada soal)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg>
                </button>
            </div>
        `;
        innerContainer.appendChild(toolbar);
        window.setQuestionsHighlightColor('yellow');
        if (window.refreshVocabBadges) window.refreshVocabBadges();
    }
}

// Global text selection listener for question highlight
document.addEventListener('mouseup', function(e) {
    if (!window.questionsHighlightMode) return;
    const qPanel = document.getElementById('questions-panel') || document.getElementById('questions-pane');
    if (!qPanel || !qPanel.contains(e.target)) return;

    if (e.target.closest('input, textarea, select, button, a, #questions-floating-toolbar')) return;

    const sel = window.getSelection();
    if (!sel || sel.rangeCount === 0 || sel.isCollapsed) return;
    const text = sel.toString().trim();
    if (!text) return;

    if (window.applyAnnotation) {
        window.applyAnnotation('highlight', window.questionsHighlightColor || 'yellow', qPanel);
    }
});

// Click listener for question eraser to remove highlight mark directly
document.addEventListener('click', function(e) {
    if (!window.questionsEraserMode) return;
    const qPanel = document.getElementById('questions-panel') || document.getElementById('questions-pane');
    if (!qPanel || !qPanel.contains(e.target)) return;

    let el = e.target;
    while (el && el !== qPanel && el.tagName !== 'MARK') {
        el = el.parentElement;
    }
    if (el && el.tagName === 'MARK' && el.classList.contains('user-highlight')) {
        if (window.removeHighlight) {
            window.removeHighlight({ target: el });
        }
    }
});

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', injectQuestionsTranslateUI);
} else {
    injectQuestionsTranslateUI();
}

// Quick Floating Action Tooltip on Text Selection or Highlight Click (Questions & Passage)
(function setupSelectionTranslate() {
    let tooltip = null;
    let currentMarks = [];

    function getOrCreateTooltip() {
        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.id = 'selection-floating-action-chip';
            tooltip.className = 'fixed z-[99999] flex items-center gap-1.5 p-1 bg-white/95 backdrop-blur-md rounded-full shadow-2xl border border-gray-200 transition-all select-none';
            tooltip.style.cssText = 'position:fixed; display:none; z-index:99999; background:rgba(255,255,255,0.98); border-radius:9999px; box-shadow:0 10px 25px -5px rgba(0,0,0,0.25), 0 8px 10px -6px rgba(0,0,0,0.15); border:1px solid #e2e8f0; align-items:center; gap:6px; padding:4px 8px;';
            tooltip.innerHTML = `
                <button type="button" 
                        id="selection-delete-hl-btn" 
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all cursor-pointer border border-red-200/60 shadow-sm"
                        style="display:none;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span>Hapus Highlight</span>
                </button>
                <button type="button" 
                        id="selection-translate-btn" 
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-emerald-600 text-white hover:bg-emerald-700 active:scale-95 transition-all cursor-pointer border-none shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    <span>Terjemahkan</span>
                </button>
                <button type="button" 
                        id="selection-note-btn" 
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-purple-600 text-white hover:bg-purple-700 active:scale-95 transition-all cursor-pointer border-none shadow-sm"
                        title="Simpan kosa kata ini beserta artinya ke Catatan Kosa Kata">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Catat Kosa Kata</span>
                </button>
            `;
            document.body.appendChild(tooltip);

            const deleteBtn = tooltip.querySelector('#selection-delete-hl-btn');
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (currentMarks && currentMarks.length > 0 && window.removeHighlight) {
                    currentMarks.forEach(m => {
                        window.removeHighlight({ target: m });
                    });
                }
                tooltip.style.display = 'none';
                currentMarks = [];
                const sel = window.getSelection();
                if (sel) sel.removeAllRanges();
            });

            const transBtn = tooltip.querySelector('#selection-translate-btn');
            transBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const sel = window.getSelection();
                let text = sel ? sel.toString().trim() : '';
                if (!text && currentMarks.length > 0) {
                    text = currentMarks.map(m => m.textContent.trim()).join(' ');
                }
                if (text) {
                    if (window.openReadingDictionary) {
                        window.openReadingDictionary(text);
                    } else {
                        window.dispatchEvent(new CustomEvent('open-reading-dict', { detail: { word: text } }));
                    }
                }
                tooltip.style.display = 'none';
                currentMarks = [];
            });

            const noteBtn = tooltip.querySelector('#selection-note-btn');
            noteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const sel = window.getSelection();
                let text = sel ? sel.toString().trim() : '';
                if (!text && currentMarks.length > 0) {
                    text = currentMarks.map(m => m.textContent.trim()).join(' ');
                }
                if (text && window.addReadingVocabNote) {
                    let source = 'Passage';
                    let context = '';
                    if (sel && sel.rangeCount > 0) {
                        const range = sel.getRangeAt(0);
                        context = window.extractSentenceContext ? window.extractSentenceContext(range) : '';
                        const ancestor = range.commonAncestorContainer;
                        const el = ancestor.nodeType === 3 ? ancestor.parentElement : ancestor;
                        if (el && (el.closest('#questions-panel') || el.closest('#questions-pane'))) {
                            source = 'Soal';
                        }
                    } else if (currentMarks.length > 0) {
                        context = window.extractSentenceContext ? window.extractSentenceContext(currentMarks[0]) : '';
                        if (currentMarks[0].closest('#questions-panel') || currentMarks[0].closest('#questions-pane')) {
                            source = 'Soal';
                        }
                    }

                    window.addReadingVocabNote({
                        word: text,
                        context: context,
                        source: source
                    });
                }
                tooltip.style.display = 'none';
                currentMarks = [];
            });
        }
        return tooltip;
    }

    function findHighlightMarks(targetNode, sel) {
        const found = new Set();
        if (targetNode) {
            let el = targetNode.nodeType === 3 ? targetNode.parentElement : targetNode;
            const directMark = el ? el.closest('mark.user-highlight') : null;
            if (directMark) found.add(directMark);
        }

        if (sel && sel.rangeCount > 0 && !sel.isCollapsed) {
            const range = sel.getRangeAt(0);
            const ancestor = range.commonAncestorContainer;
            const ancestorEl = ancestor.nodeType === 3 ? ancestor.parentElement : ancestor;
            const insideMark = ancestorEl ? ancestorEl.closest('mark.user-highlight') : null;
            if (insideMark) found.add(insideMark);

            const marks = document.querySelectorAll('mark.user-highlight');
            for (let i = 0; i < marks.length; i++) {
                const m = marks[i];
                try {
                    if (sel.containsNode && sel.containsNode(m, true)) {
                        found.add(m);
                    }
                } catch(e) {}
            }
        }
        return Array.from(found);
    }

    document.addEventListener('mouseup', function(e) {
        if (e.target.closest('#definitionPopup') || e.target.closest('#selection-floating-action-chip')) return;

        // Skip if any active drawing, highlighting, or erasing mode is enabled
        if (window.questionsHighlightMode || window.questionsEraserMode || window.questionsPencilMode) return;
        const passageCard = e.target.closest('[id^="passage-"]');
        if (passageCard && passageCard.__x && passageCard.__x.$data) {
            const d = passageCard.__x.$data;
            if (d.highlightMode || d.pencilMode || d.eraserMode) return;
        }

        const sel = window.getSelection();
        const hasSelection = sel && !sel.isCollapsed && sel.toString().trim().length >= 1;
        const marks = findHighlightMarks(e.target, sel);

        if (!hasSelection && marks.length === 0) {
            if (tooltip) tooltip.style.display = 'none';
            return;
        }

        const inPassage = e.target.closest('#passage-pane') || e.target.closest('.passage-content');
        const inQuestions = e.target.closest('#questions-panel') || e.target.closest('#questions-pane');
        if (!inPassage && !inQuestions) {
            if (tooltip) tooltip.style.display = 'none';
            return;
        }

        currentMarks = marks;
        const tip = getOrCreateTooltip();
        const deleteBtn = tip.querySelector('#selection-delete-hl-btn');
        const transBtn = tip.querySelector('#selection-translate-btn');

        if (marks.length > 0) {
            deleteBtn.style.display = 'flex';
        } else {
            deleteBtn.style.display = 'none';
        }

        let rect = null;
        if (hasSelection) {
            rect = sel.getRangeAt(0).getBoundingClientRect();
        } else if (marks.length > 0) {
            rect = marks[0].getBoundingClientRect();
        }

        if (rect && rect.width > 0) {
            let top = rect.top - 46;
            if (top < 10) {
                top = rect.bottom + 8;
            }
            const left = Math.max(10, Math.min(window.innerWidth - 380, rect.left + (rect.width / 2) - 160));
            tip.style.top = `${top}px`;
            tip.style.left = `${left}px`;
            tip.style.display = 'flex';
        }
    });

    document.addEventListener('mousedown', function(e) {
        if (tooltip && tooltip.style.display !== 'none' && !tooltip.contains(e.target)) {
            tooltip.style.display = 'none';
            currentMarks = [];
        }
    });
})();

/**
 * Reconstructs the sentence surrounding a clicked .translate-word span by
 * walking its parent's childNodes (siblings are themselves either plain
 * text nodes or other word spans, produced by wrapContainerTextNodes()),
 * then splitting on sentence-ending punctuation. Needed because the cached
 * word->translation lookup has no sense of context at all - this is what
 * lets the "check in this sentence" action actually send a real sentence.
 */
function getContextSentenceForWordSpan(span) {
    if (!span || !span.parentNode) return '';
    const parent = span.parentNode;
    let fullText = '';
    let spanStart = -1;
    parent.childNodes.forEach(node => {
        const text = node.nodeType === Node.TEXT_NODE ? (node.nodeValue || '') : (node.textContent || '');
        if (node === span) {
            spanStart = fullText.length;
        }
        fullText += text;
    });
    if (spanStart === -1) return '';

    const boundaries = [0];
    const re = /[.!?]+(\s+|$)/g;
    let m;
    while ((m = re.exec(fullText)) !== null) {
        boundaries.push(m.index + m[0].length);
    }
    if (boundaries[boundaries.length - 1] !== fullText.length) {
        boundaries.push(fullText.length);
    }

    for (let i = 0; i < boundaries.length - 1; i++) {
        const start = boundaries[i], end = boundaries[i + 1];
        if (spanStart >= start && spanStart < end) {
            return fullText.slice(start, end).trim();
        }
    }
    return fullText.trim();
}

async function checkTranslationInContext() {
    const word = document.getElementById('def_word').innerText;
    const sentence = window.__currentDictSentence || '';
    const resultEl = document.getElementById('def_context_result');
    const btn = document.getElementById('def_context_check_btn');

    resultEl.style.display = 'block';

    if (!word || !sentence || sentence.split(/\s+/).length < 2) {
        resultEl.innerText = 'Konteks kalimat tidak terdeteksi.';
        return;
    }

    const contextRoute = '{{ Route::has("api.dictionary.lookup-in-context") ? route("api.dictionary.lookup-in-context") : "" }}';
    if (!contextRoute) {
        resultEl.innerText = 'Fitur analisis kalimat konteks belum aktif.';
        btn.disabled = false;
        return;
    }

    btn.disabled = true;
    resultEl.innerText = 'Memeriksa konteks...';
    try {
        const response = await fetch(`${contextRoute}?word=${encodeURIComponent(word)}&sentence=${encodeURIComponent(sentence)}`);
        const data = await response.json();
        resultEl.innerText = data.found
            ? `Dalam kalimat ini: "${data.translation}"`
            : 'Tidak dapat memeriksa konteks saat ini.';
    } catch (error) {
        resultEl.innerText = 'Tidak dapat memeriksa konteks saat ini.';
    } finally {
        btn.disabled = false;
    }
}

async function lookupWord(word, event) {
    event.stopPropagation();

    const popup = document.getElementById('definitionPopup');
    if (!popup) return;
    const cleanWord = word.replace(/[^a-zA-Z0-9\-\']/g, '').toLowerCase();

    const x = Math.max(10, Math.min(event.clientX - 20, window.innerWidth - 310));
    let y = event.clientY + 15;
    if (y + 180 > window.innerHeight) {
        y = Math.max(10, event.clientY - 160);
    }

    popup.style.top = `${y}px`;
    popup.style.left = `${x}px`;

    document.getElementById('def_word').innerText = cleanWord;
    document.getElementById('def_translation').innerText = 'Memuat...';
    document.getElementById('def_synonyms').innerText = '...';

    window.__currentDictSentence = getContextSentenceForWordSpan(event.target);
    const contextResultEl = document.getElementById('def_context_result');
    if (contextResultEl) {
        contextResultEl.style.display = 'none';
        contextResultEl.innerText = '';
    }

    popup.style.display = 'block';

    try {
        const response = await fetch(`{{ Route::has('api.dictionary.lookup') ? route('api.dictionary.lookup') : url('/api/dictionary/lookup') }}?word=${cleanWord}`);
        const data = await response.json();

        if (data.found) {
            document.getElementById('def_word').innerText = data.word;
            document.getElementById('def_translation').innerText = data.translation;
            
            if (data.synonyms && data.synonyms !== '-' && data.synonyms !== null) {
                document.getElementById('def_synonyms').innerText = data.synonyms;
            } else {
                document.getElementById('def_synonyms').innerText = 'Memuat...';
                fetch(`{{ Route::has('api.dictionary.synonyms') ? route('api.dictionary.synonyms') : url('/api/dictionary/synonyms') }}?word=${cleanWord}`)
                    .then(res => res.json())
                    .then(synData => {
                        if (document.getElementById('def_word').innerText.toLowerCase() === data.word.toLowerCase()) {
                            document.getElementById('def_synonyms').innerText = synData.synonyms || '-';
                        }
                    })
                    .catch(err => {
                        console.error('Synonym error:', err);
                        document.getElementById('def_synonyms').innerText = '-';
                    });
            }
        } else {
            document.getElementById('def_translation').innerText = 'Tidak ditemukan';
            document.getElementById('def_synonyms').innerText = '-';
        }
    } catch (error) {
        console.error('Dictionary error:', error);
        document.getElementById('def_translation').innerText = 'Error';
    }
}

document.addEventListener('click', function(e) {
    const popup = document.getElementById('definitionPopup');
    if (popup && popup.style.display !== 'none' && !popup.contains(e.target) && !e.target.classList.contains('translate-word')) {
        popup.style.display = 'none';
    }
});

/* ── Interactive Vocabulary Highlighting from Questions to Passage ── */
(function() {
    const style = document.createElement('style');
    style.innerHTML = `
        #questions-panel .question-text-content:hover,
        #questions-panel .question-text-content *:hover,
        #questions-panel li:hover span:not(.font-bold),
        #questions-panel table td:not(:first-child):hover,
        #questions-panel table td.hover\\:cursor-pointer:hover,
        #questions-panel .hover\\:cursor-pointer:hover,
        #questions-panel p:hover,
        #questions-panel table tr:hover td {
            cursor: pointer;
        }
        mark.vocab-highlight {
            background-color: #a5f3fc !important;
            color: #164e63 !important;
            padding: 0 2px;
            border-radius: 3px;
            box-shadow: 0 0 0 2px rgba(103, 232, 249, 0.5);
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);

    /**
     * Resolves which reading passage (1, 2, or 3) the clicked question belongs to.
     */
    function resolveQuestionPassageNumber(element) {
        if (!element) return null;

        // 1. Direct container with id or data-passage (e.g. #questions-passage-1, #questions-passage-2, #questions-passage-3)
        const passageGroup = element.closest('#questions-passage-1, #questions-passage-2, #questions-passage-3, [id^="questions-passage-"], [data-passage]');
        if (passageGroup) {
            if (passageGroup.dataset && passageGroup.dataset.passage) {
                const p = parseInt(passageGroup.dataset.passage, 10);
                if (!isNaN(p)) return p;
            }
            const m = passageGroup.id.match(/questions-passage-(\d+)/i);
            if (m) {
                return parseInt(m[1], 10);
            }
        }

        // 2. Check input/select name inside card or table row (e.g. name="q28")
        const card = element.closest('.bg-white, .border, tr, li, div') || element;
        const inputs = card.querySelectorAll ? card.querySelectorAll('[name^="q"], [name^="Q"]') : [];
        for (const inp of inputs) {
            const m = inp.name.match(/^q(\d+)/i);
            if (m) {
                const qNum = parseInt(m[1], 10);
                if (qNum >= 27) return 3;
                if (qNum >= 14) return 2;
                if (qNum >= 1) return 1;
            }
        }

        // 3. Check for question text pattern e.g. "Questions 27-30", "Questions 14-16"
        let checkEl = element;
        while (checkEl && checkEl !== document.body && checkEl.id !== 'questions-panel' && checkEl.id !== 'questions-pane') {
            const text = checkEl.textContent || '';
            const rangeMatch = text.match(/Questions?\s+(\d+)/i);
            if (rangeMatch) {
                const qNum = parseInt(rangeMatch[1], 10);
                if (qNum >= 27) return 3;
                if (qNum >= 14) return 2;
                if (qNum >= 1) return 1;
            }
            checkEl = checkEl.parentElement;
        }

        // 4. Compare DOM position with questions-passage-1, 2, 3
        for (const num of [3, 2, 1]) {
            const grp = document.getElementById(`questions-passage-${num}`);
            if (grp && (grp.contains(element) || (grp.compareDocumentPosition(element) & Node.DOCUMENT_POSITION_CONTAINED_BY))) {
                return num;
            }
        }

        // 5. Fallback: check closest question number label
        const numLabel = card.querySelector ? card.querySelector('.font-bold.text-blue-600, td:first-child, span.font-bold') : null;
        if (numLabel) {
            const val = parseInt(numLabel.textContent.trim(), 10);
            if (!isNaN(val) && val >= 1 && val <= 40) {
                if (val >= 27) return 3;
                if (val >= 14) return 2;
                return 1;
            }
        }

        return null;
    }

    document.addEventListener('click', function(e) {
        const inQuestionsPanel = e.target.closest('#questions-panel') || e.target.closest('#questions-pane');
        if (!inQuestionsPanel) return;

        if (['BUTTON', 'INPUT', 'SELECT', 'TEXTAREA', 'A'].includes(e.target.tagName) || e.target.closest('button') || e.target.closest('a') || e.target.closest('select') || e.target.classList.contains('translate-word') || window.isQuestionsTranslateActive || window.questionsHighlightMode || window.questionsPencilMode || window.questionsEraserMode) {
            return;
        }

        let clickedWord = '';

        if (document.caretPositionFromPoint) {
            const range = document.caretPositionFromPoint(e.clientX, e.clientY);
            if (range && range.offsetNode && range.offsetNode.nodeType === Node.TEXT_NODE) {
                clickedWord = extractWordFromTextNode(range.offsetNode.textContent, range.offset);
            }
        } else if (document.caretRangeFromPoint) {
            const range = document.caretRangeFromPoint(e.clientX, e.clientY);
            if (range && range.startContainer && range.startContainer.nodeType === Node.TEXT_NODE) {
                clickedWord = extractWordFromTextNode(range.startContainer.textContent, range.startOffset);
            }
        }

        if (!clickedWord && window.getSelection) {
            const sel = window.getSelection().toString().trim();
            if (sel && sel.length > 2 && !sel.includes('\n') && sel.split(/\s+/).length <= 2) {
                clickedWord = sel;
            }
        }

        if (!clickedWord && e.target && e.target.textContent) {
            const trimmed = e.target.textContent.trim();
            if (trimmed.length > 2 && trimmed.length < 30 && /^[a-zA-Z0-9'-]+$/.test(trimmed)) {
                clickedWord = trimmed;
            }
        }

        if (clickedWord && clickedWord.trim().length > 2) {
            const passageNum = resolveQuestionPassageNumber(e.target);
            highlightInPassage(clickedWord.trim(), passageNum);
        } else {
            clearVocabHighlights();
        }
    });

    // Escape key clears all highlights
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            clearVocabHighlights();
        }
    });

    function extractWordFromTextNode(text, offset) {
        let start = offset;
        let end = offset;
        const wordCharRegex = /[a-zA-Z0-9'-]/;

        while (start > 0 && wordCharRegex.test(text[start - 1])) {
            start--;
        }
        while (end < text.length && wordCharRegex.test(text[end])) {
            end++;
        }

        return text.substring(start, end).replace(/^['-]+|['-]+$/g, '');
    }

    function clearVocabHighlights() {
        document.querySelectorAll('mark.vocab-highlight').forEach(mark => {
            const parent = mark.parentNode;
            if (parent) {
                while (mark.firstChild) {
                    parent.insertBefore(mark.firstChild, mark);
                }
                parent.removeChild(mark);
                parent.normalize();
            }
        });
    }

    function highlightInPassage(word, passageNum = null) {
        clearVocabHighlights();

        // Strictly obtain ONLY the passage containers for the passage currently being worked on
        const passages = getPassageContainers(passageNum);
        if (!passages || passages.length === 0) return;

        let firstHighlight = null;
        let searchRegex = new RegExp(`\\b${escapeRegExp(word)}\\b`, 'gi');

        // Check if exact word exists in target passage; if not, test common inflection
        const combinedText = passages.map(p => p.textContent || '').join(' ');
        if (!searchRegex.test(combinedText)) {
            let variations = [];
            if (word.endsWith('ies') && word.length > 4) {
                variations.push(word.slice(0, -3) + 'y');
            } else if (word.endsWith('es') && word.length > 4) {
                variations.push(word.slice(0, -2));
            } else if (word.endsWith('s') && word.length > 3 && !word.endsWith('ss')) {
                variations.push(word.slice(0, -1));
            } else if (word.endsWith('ed') && word.length > 4) {
                variations.push(word.slice(0, -2));
                variations.push(word.slice(0, -1));
            } else if (word.endsWith('ing') && word.length > 5) {
                variations.push(word.slice(0, -3));
                variations.push(word.slice(0, -3) + 'e');
            } else {
                variations.push(word + 's');
                variations.push(word + 'es');
            }

            for (const v of variations) {
                const vRegex = new RegExp(`\\b${escapeRegExp(v)}\\b`, 'gi');
                if (vRegex.test(combinedText)) {
                    searchRegex = vRegex;
                    break;
                }
            }
        }

        passages.forEach(passage => {
            const treeWalker = document.createTreeWalker(
                passage,
                NodeFilter.SHOW_TEXT,
                {
                    acceptNode: function(node) {
                        if (!node.parentNode) return NodeFilter.FILTER_REJECT;
                        const parentTag = node.parentNode.tagName;
                        if (parentTag === 'MARK' && node.parentNode.classList.contains('vocab-highlight')) {
                            return NodeFilter.FILTER_REJECT;
                        }
                        if (parentTag === 'SCRIPT' || parentTag === 'STYLE' || parentTag === 'CANVAS') {
                            return NodeFilter.FILTER_REJECT;
                        }
                        return searchRegex.test(node.textContent) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
                    }
                },
                false
            );

            const nodesToReplace = [];
            let currentNode;
            while ((currentNode = treeWalker.nextNode())) {
                nodesToReplace.push(currentNode);
            }

            nodesToReplace.forEach(node => {
                const textContent = node.textContent;
                const fragment = document.createDocumentFragment();
                let lastIndex = 0;
                searchRegex.lastIndex = 0;
                let match;

                while ((match = searchRegex.exec(textContent)) !== null) {
                    if (match.index > lastIndex) {
                        fragment.appendChild(document.createTextNode(textContent.substring(lastIndex, match.index)));
                    }

                    const mark = document.createElement('mark');
                    mark.className = 'vocab-highlight';
                    mark.textContent = match[0];
                    fragment.appendChild(mark);

                    if (!firstHighlight) firstHighlight = mark;
                    lastIndex = match.index + match[0].length;
                }

                if (lastIndex < textContent.length) {
                    fragment.appendChild(document.createTextNode(textContent.substring(lastIndex)));
                }

                if (node.parentNode) {
                    node.parentNode.replaceChild(fragment, node);
                }
            });
        });

        if (firstHighlight) {
            firstHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (passageNum) {
            // If the word doesn't appear in this passage, ensure the student
            // is positioned at the correct passage rather than jumping to unrelated passages
            const pEl = document.getElementById(`passage-${passageNum}`);
            if (pEl) {
                pEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }

    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }
})();

/* ── Universal Passage Question Distinguisher / Container Divider ── */
(function() {
    function initPassageQuestionSeparators() {
        // If already structured (e.g. #questions-passage-1 already exists), skip
        if (document.getElementById('questions-passage-1')) return;

        const panel = document.getElementById('questions-panel') || document.getElementById('questions-pane');
        if (!panel) return;

        // Target the inner container with padding
        const innerWrapper = panel.querySelector(':scope > div.w-full, :scope > div.relative, :scope > div') || panel;
        if (!innerWrapper) return;

        const children = Array.from(innerWrapper.children);
        if (children.length === 0) return;

        function extractCardQNum(el) {
            if (!el || el.nodeType !== Node.ELEMENT_NODE) return null;
            const text = el.textContent || '';
            const m = text.match(/Questions?\s+(\d+)/i);
            if (m) {
                return parseInt(m[1], 10);
            }
            const input = el.querySelector('[name^="q"]');
            if (input) {
                const num = input.name.replace(/^q/i, '');
                if (/^\d+$/.test(num)) return parseInt(num, 10);
            }
            return null;
        }

        let currentPassage = 1;
        let hasDetectedQuestions = false;
        const passageGroups = { 1: [], 2: [], 3: [], others: [] };

        children.forEach(child => {
            if (child.tagName === 'SCRIPT' || child.tagName === 'STYLE') {
                return;
            }

            const rawText = (child.textContent || '').trim();

            // 1. Pure submit button container or disabled notice (must be short)
            if (rawText.length < 300 && (
                rawText.includes('Submit All Answers') || 
                rawText.includes('Submit Answers') || 
                rawText.includes('Fitur pengumpulan jawaban') || 
                rawText.includes('dinonaktifkan')
            )) {
                passageGroups.others.push(child);
                return;
            }

            // 2. Old static text divider banner (e.g. "READING PASSAGE 2") -> hide and advance currentPassage
            const pMatch = rawText.match(/^(?:READING\s+)?PASSAGE\s+([123])\b/i);
            if (pMatch && rawText.length < 60) {
                currentPassage = parseInt(pMatch[1], 10);
                child.style.display = 'none'; // Replaced by modern interactive banner
                return;
            }

            // 3. Question Card / Container
            const qNum = extractCardQNum(child);
            if (qNum !== null) {
                hasDetectedQuestions = true;
                if (qNum >= 27) currentPassage = 3;
                else if (qNum >= 14) currentPassage = 2;
                else currentPassage = 1;
            }

            if (currentPassage in passageGroups) {
                passageGroups[currentPassage].push(child);
            } else {
                passageGroups.others.push(child);
            }
        });

        if (!hasDetectedQuestions) return;

        const config = {
            1: {
                title: 'Soal untuk Passage 1',
                desc: 'Pertanyaan 1–13 berdasarkan Reading Passage 1',
                badge: 'Questions 1–13',
                pBadge: 'P1',
                gradient: 'from-pink-50 via-rose-50/40 to-white',
                border: 'border-pink-200/80 hover:border-pink-300',
                badgeBg: 'bg-pink-600',
                badgeText: 'bg-pink-100 text-pink-700 border-pink-200',
                targetPassage: 'passage-1'
            },
            2: {
                title: 'Soal untuk Passage 2',
                desc: 'Pertanyaan 14–26 berdasarkan Reading Passage 2',
                badge: 'Questions 14–26',
                pBadge: 'P2',
                gradient: 'from-blue-50 via-indigo-50/40 to-white',
                border: 'border-blue-200/80 hover:border-blue-300',
                badgeBg: 'bg-blue-600',
                badgeText: 'bg-blue-100 text-blue-700 border-blue-200',
                targetPassage: 'passage-2'
            },
            3: {
                title: 'Soal untuk Passage 3',
                desc: 'Pertanyaan 27–40 berdasarkan Reading Passage 3',
                badge: 'Questions 27–40',
                pBadge: 'P3',
                gradient: 'from-purple-50 via-violet-50/40 to-white',
                border: 'border-purple-200/80 hover:border-purple-300',
                badgeBg: 'bg-purple-600',
                badgeText: 'bg-purple-100 text-purple-700 border-purple-200',
                targetPassage: 'passage-3'
            }
        };

        [1, 2, 3].forEach(pNum => {
            const cards = passageGroups[pNum];
            if (!cards || cards.length === 0) return;

            const groupDiv = document.createElement('div');
            groupDiv.id = `questions-passage-${pNum}`;
            groupDiv.dataset.passage = pNum;
            groupDiv.className = 'passage-questions-group mb-10';

            const cfg = config[pNum];
            const banner = document.createElement('div');
            banner.className = `mb-6 flex items-center justify-between p-4 bg-gradient-to-r ${cfg.gradient} rounded-2xl border ${cfg.border} shadow-sm cursor-pointer hover:shadow-md transition select-none group`;
            banner.title = `Klik untuk melompat ke Reading Passage ${pNum}`;
            banner.onclick = function() {
                const pEl = document.getElementById(cfg.targetPassage);
                if (pEl) {
                    pEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };

            banner.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl ${cfg.badgeBg} text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:scale-105 transition-transform">${cfg.pBadge}</span>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 leading-tight flex items-center gap-2">
                            <span>${cfg.title}</span>
                            <span class="text-xs font-normal text-gray-400 group-hover:text-blue-600 transition flex items-center gap-0.5">
                                <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                <span class="hidden sm:inline">Lihat Bacaan</span>
                            </span>
                        </h3>
                        <p class="text-xs text-gray-500">${cfg.desc}</p>
                    </div>
                </div>
                <span class="px-3 py-1 ${cfg.badgeText} text-xs font-bold rounded-full border">${cfg.badge}</span>
            `;

            groupDiv.appendChild(banner);

            cards.forEach(card => {
                card.dataset.passage = pNum;
                groupDiv.appendChild(card);
            });

            innerWrapper.appendChild(groupDiv);
        });

        passageGroups.others.forEach(otherEl => {
            innerWrapper.appendChild(otherEl);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPassageQuestionSeparators);
    } else {
        initPassageQuestionSeparators();
    }
    window.addEventListener('load', initPassageQuestionSeparators);
})();
</script>

@include('assignments.ielts.mockup.partials.reading-autosave')
