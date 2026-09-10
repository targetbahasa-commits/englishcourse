<div x-data="{
    open: false,
    query: '',
    dictResult: null,
    results: {
        translation: '',
        examples: [],
        synonyms: [],
        source: '',
        debug: ''
    },
    loading: false,
    error: null,
    
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
        if (!window.speechSynthesis) return;
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = lang;
        window.speechSynthesis.speak(utterance);
    },

    async search() {
        if (!this.query.trim()) return;
        const q = this.query.trim();
        const cacheKey = q.toLowerCase();

        // 1. Instant Cache Hit (< 1ms)
        window.__tbDictCache = window.__tbDictCache || new Map();
        if (window.__tbDictCache.has(cacheKey)) {
            this.dictResult = JSON.parse(JSON.stringify(window.__tbDictCache.get(cacheKey)));
            this.results.source = this.dictResult.usedSource || 'Fast Cache';
            this.loading = false;
            this.error = null;
            return;
        }

        this.loading = true;
        this.error = null;
        this.dictResult = null;
        this.results.debug = ''; 

        // Fast language heuristic detection
        const idWords = /\b(yang|dan|di|ke|dari|ini|itu|dengan|untuk|pada|adalah|dapat|akan|sudah|telah|oleh|karena|juga|kita|kami|saya|kamu|mereka|hanya|bisa|harus|seperti|secara|proses|metode|sangat|lebih|masih|dalam|atau|tidak|bukan|tentang|bagi|setelah|sebelum|antara|bila|jika|ketika|serta|tersebut|adanya|merupakan)\b/i;
        const idAffixes = /(^(meng|mem|men|meny|menge|ber|ter|per|di|ke|se)[a-z]+|[a-z]+(kan|an|nya|i)$)/i;
        const enWords = /\b(the|is|are|was|were|and|or|in|on|at|to|for|with|by|from|of|that|this|these|those|have|has|had|can|could|will|would|should|may|might|must|it|its|their|they|we|you|he|she|about|into|more|most|than|then|which|what|when|where|why|how|not|been|being)\b/i;
        const enAffixes = /[a-z]+(tion|ment|ness|ity|ing|ed|ly|ous|ive|able|ible|est|er)$/i;

        let isIndonesian = idWords.test(q) || idAffixes.test(q);
        let isEnglish = enWords.test(q) || enAffixes.test(q);
        let preferredSl = isIndonesian ? 'id' : (isEnglish ? 'en' : 'auto');
        let preferredTl = isIndonesian ? 'en' : 'id';

        let translation = '';
        let finalSource = 'auto'; 
        let usedSource = 'Google Translate';

        try {
            // TIER 1: Google Translate GTX (Fast with AbortController 2.2s)
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

            // TIER 2: MyMemory Cloud (Fast Fallback 2.2s)
            const myMemoryTask = async () => {
                try {
                    const ctrl = new AbortController();
                    const tid = setTimeout(() => ctrl.abort(), 2200);
                    const pair = (preferredSl === 'id' || preferredTl === 'en') ? 'id|en' : 'en|id';
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

            // Execute translation
            let res = await googleTask();
            if (!res || !res.text) res = await myMemoryTask();

            if (res && res.text) {
                translation = res.text;
                usedSource = res.source;
                finalSource = res.lang || 'auto';
            }

            if (!translation) throw new Error('Translation Unavailable');
            if (finalSource !== 'id' && finalSource !== 'en') finalSource = isIndonesian ? 'id' : 'en';

            // 2. EXAMPLES & THESAURUS (Parallel Non-blocking Fetch)
            const englishWord = finalSource === 'en' ? q : translation;
            const cleanEnglish = englishWord.replace(/[^a-zA-Z\s-]/g, '').trim();
            let examples = [];
            let synonyms = [];
            let pos = [];
            let academic_words = [];

            if (cleanEnglish && cleanEnglish.split(/\s+/).length === 1) {
                const dictCtrl = new AbortController();
                const dictTid = setTimeout(() => dictCtrl.abort(), 1800);

                try {
                    const [dictRes, museRes] = await Promise.allSettled([
                        fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(cleanEnglish)}`, { signal: dictCtrl.signal }).then(r => r.ok ? r.json() : null),
                        fetch(`https://api.datamuse.com/words?rel_syn=${encodeURIComponent(cleanEnglish)}&max=8`, { signal: dictCtrl.signal }).then(r => r.ok ? r.json() : null)
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
                        synonyms = museData.map(i => i.word).filter(Boolean);
                    }
                } catch (err) {}
            }

            const finalResult = {
                source: finalSource,
                original: q,
                translation: translation,
                examples: [...new Set(examples)].slice(0, 3),
                synonyms: synonyms.slice(0, 8),
                academic_words: academic_words,
                pos: [...new Set(pos)],
                usedSource: usedSource
            };

            this.dictResult = finalResult;
            this.results.source = usedSource;

            // Cache for instant recall
            window.__tbDictCache.set(cacheKey, finalResult);

        } catch(e) {
            console.error(e);
            this.error = 'Terjemahan tidak tersedia saat ini. Silakan coba kembali.';
        } finally {
            this.loading = false;
        }
    }
}">
    <!-- Floating Button -->
    <button @click="open = true; $nextTick(() => { if ($refs.queryInput) { $refs.queryInput.focus(); $refs.queryInput.select(); } })"
            title="Dictionary (Kamus)"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        <span class="hidden sm:inline">Dictionary</span>
    </button>

    <!-- Modal Backdrop (Teleported to body for reliable full-screen overlay) -->
    <template x-teleport="body">
        <div x-show="open"
             x-transition.opacity
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4"
             style="display: none;">
            
            <!-- Modal Content -->
            <div @click.outside="open = false"
                 class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden text-left">
            
            <!-- Header -->
            <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <h3 class="text-xl font-bold text-blue-900">Translation & Thesaurus</h3>
                    <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">Auto-Detect</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" @click="resetDictionary()" class="text-blue-600 hover:text-blue-800 p-1.5 rounded-lg hover:bg-blue-100 transition" title="Refresh & Reset (Siap Ketik)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </button>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Search Area -->
            <div class="p-4 border-b border-gray-100">
                <form @submit.prevent="search" class="flex gap-2">
                    <input type="text" 
                           x-ref="queryInput"
                           x-model="query" 
                           placeholder="Type a word in English or Indonesia..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium text-sm disabled:opacity-50 flex items-center gap-1.5" :disabled="loading">
                        <span x-show="!loading">Search</span>
                        <span x-show="loading" class="animate-pulse">...</span>
                    </button>
                    <button type="button" 
                            @click="resetDictionary()" 
                            class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-blue-600 rounded-lg transition border border-gray-200 flex items-center justify-center gap-1.5 text-sm font-medium" 
                            title="Refresh Dictionary & Reset">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span class="hidden sm:inline">Refresh</span>
                    </button>
                </form>
            </div>

            <!-- Results Area -->
            <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                
                <!-- Loading State -->
                <div x-show="loading" class="flex flex-col items-center justify-center py-10 text-gray-500">
                    <svg class="w-8 h-8 animate-spin mb-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Processing...</span>
                </div>

                <!-- Error State -->
                <div x-show="error" class="text-center py-8 text-red-500 bg-red-50 rounded-lg border border-red-100">
                    <span x-text="error"></span>
                </div>

                <!-- Result State -->
                <div x-show="dictResult && !loading" class="space-y-6">
                    
                    <!-- 1. TRANSLATION -->
                    <div class="bg-white p-6 rounded-xl border border-blue-200 shadow-sm">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wide mb-4">1. Translation</h4>
                        
                        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                            <!-- Source -->
                            <div class="text-center flex-1">
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1" x-text="dictResult?.source === 'en' ? 'English' : 'Indonesia'"></p>
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-xl text-gray-900" x-text="dictResult?.original"></span>
                                    <button @click="playAudio(dictResult?.original, dictResult?.source == 'en' ? 'en-US' : 'id-ID')" class="text-gray-300 hover:text-blue-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Arrow -->
                            <div class="text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>

                            <!-- Target -->
                            <div class="text-center flex-1">
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1" x-text="dictResult?.source === 'en' ? 'Indonesia' : 'English'"></p>
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-2xl font-bold text-blue-700" x-text="dictResult?.translation"></span>
                                    <button @click="playAudio(dictResult?.translation, dictResult?.source == 'en' ? 'id-ID' : 'en-US')" class="text-blue-300 hover:text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. EXAMPLES -->
                    <div x-show="dictResult?.examples?.length > 0">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wide mb-3">2. Examples (Contoh Kalimat)</h4>
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <template x-for="(example, idx) in dictResult?.examples" :key="idx">
                                <div class="px-4 py-3 border-b border-gray-100 last:border-0 hover:bg-gray-50">
                                    <p class="text-gray-800 text-sm italic" x-text="`&quot;${example}&quot;`"></p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 3. SYNONYMS -->
                    <div x-show="dictResult?.synonyms?.length > 0" class="mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wide mb-3">3. Synonyms (Sinonim)</h4>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="syn in dictResult?.synonyms">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-purple-100 hover:text-purple-700 transition-colors cursor-pointer border border-transparent hover:border-purple-200" 
                                      @click="query = syn; search()" 
                                      x-text="syn"></span>
                            </template>
                        </div>
                    </div>

                    <!-- 4. ACADEMIC WORDS -->
                    <div x-show="dictResult?.academic_words?.length > 0">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wide mb-3">4. Academic Words</h4>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="aw in dictResult?.academic_words">
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-lg text-sm hover:bg-blue-100 transition-colors cursor-pointer" 
                                      @click="query = aw.word; search()">
                                    <span x-text="aw.word" class="font-medium"></span>
                                    <span x-text="`(${aw.cefr})`" class="text-xs opacity-75 ml-1"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                </div>
                
                <!-- Initial State -->
                <div x-show="!dictResult && !loading && !error" class="text-center py-10 text-gray-400">
                    <span class="text-4xl block mb-2">🔎</span>
                    <p>Enter a word to translate and learn.</p>
                </div>

            </div>

            <!-- Footer / Status (Sticky Bottom) -->
            <div class="p-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 bg-gray-50 flex-shrink-0">
                <div></div>
                <div>
                    Target Bahasa Course
                </div>
            </div>
        </div>
    </template>
</div>
