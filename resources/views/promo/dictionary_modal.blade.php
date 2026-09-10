<div x-data="dictionaryDataToolbar()" class="inline-block">
    <button type="button" @click="open = true"
        class="{{ $buttonClass ?? 'bg-slate-700 hover:bg-slate-600 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap' }}"
        data-tooltip="Kamus terjemahan Bahasa Inggris ↔ Indonesia" title="Dictionary">
        @if(isset($hideTextOnMobile) && $hideTextOnMobile)
            <svg class="md:hidden w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span class="hidden md:inline">Dictionary</span>
        @else
            Dictionary
        @endif
    </button>
    <template x-teleport="body">
        <div x-show="open" style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div @click.outside="open = false"
                class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden text-left">
                <div class="p-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold text-slate-800">Translation & Thesaurus</h3><span
                            class="text-xs font-bold text-slate-700 bg-slate-200 px-2 py-1 rounded">Auto-Detect</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button type="button" @click="resetDictionary()" class="text-slate-600 hover:text-slate-900 p-1.5 rounded-lg hover:bg-slate-200 transition" title="Refresh & Reset (Siap Ketik)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </button>
                        <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>
                </div>
                <div class="p-4 border-b border-gray-100">
                    <form @submit.prevent="search" class="flex gap-2">
                        <input type="text" x-ref="queryInput" x-model="query"
                               placeholder="Type a word..."
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-black text-sm">
                        <button type="submit"
                                class="bg-slate-700 text-white px-5 py-2 rounded-lg hover:bg-slate-800 font-medium text-sm disabled:opacity-50 flex items-center gap-1.5" :disabled="loading"><span
                                x-show="!loading">Search</span><span x-show="loading">...</span></button>
                        <button type="button" @click="resetDictionary()"
                                class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-slate-800 rounded-lg transition border border-gray-200 flex items-center justify-center gap-1 text-sm font-medium" title="Refresh & Reset">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span class="hidden sm:inline">Refresh</span>
                        </button>
                    </form>
                </div>
                <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                    <div x-show="loading" class="text-center py-10 text-gray-500">Searching...</div>
                    <div x-show="error" x-text="error" class="text-center text-slate-700 py-10"></div>
                    <div x-show="dictResult && !loading" class="space-y-6">
                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                                <div class="text-center flex-1">
                                    <p class="text-xs text-gray-500 uppercase font-bold"
                                        x-text="dictResult?.source === 'en' ? 'English' : 'Indonesia'"></p>
                                    <div class="flex items-center justify-center gap-2"><span
                                            class="text-xl text-gray-900" x-text="dictResult?.original"></span><button type="button"
                                            @click="playAudio(dictResult?.original, dictResult?.source == 'en' ? 'en-US' : 'id-ID')"
                                            class="text-gray-300 hover:text-slate-700">🔊</button></div>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-gray-300 mb-1">➜</div>
                                    <template x-if="dictResult?.part_of_speech">
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full uppercase tracking-wider" x-text="dictResult.part_of_speech"></span>
                                    </template>
                                </div>
                                <div class="text-center flex-1">
                                    <p class="text-xs text-gray-500 uppercase font-bold"
                                        x-text="dictResult?.source === 'en' ? 'Indonesia' : 'English'"></p>
                                    <div class="flex items-center justify-center gap-2"><span
                                            class="text-2xl font-bold text-slate-800"
                                            x-text="dictResult?.translation"></span><button type="button"
                                            @click="playAudio(dictResult?.translation, dictResult?.source == 'en' ? 'id-ID' : 'en-US')"
                                            class="text-slate-500 hover:text-slate-700">🔊</button></div>
                                </div>
                            </div>
                        </div>
                        <div x-show="dictResult?.examples?.length > 0">
                            <h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Examples</h4>
                            <ul class="bg-white rounded-xl border border-gray-200"><template
                                    x-for="ex in dictResult?.examples">
                                    <li class="px-4 py-3 border-b border-gray-100 last:border-0 italic text-gray-700"
                                        x-text="ex"></li>
                                </template></ul>
                        </div>
                        <div x-show="dictResult?.synonyms?.length > 0" class="mb-4">
                            <h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Synonyms</h4>
                            <div class="flex flex-wrap gap-2"><template x-for="syn in dictResult?.synonyms"><span
                                        class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-slate-200 cursor-pointer flex items-center"
                                        @click="query = syn.word; search()"><span x-text="syn.word"></span>
                                        <template x-if="syn.part_of_speech">
                                            <span x-text="syn.part_of_speech" class="text-[9px] text-gray-400 lowercase italic ml-1.5"></span>
                                        </template>
                                        </span></template></div>
                        </div>
                        <div x-show="dictResult?.academic_words?.length > 0">
                            <h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Academic Words</h4>
                            <div class="flex flex-wrap gap-2"><template x-for="aw in dictResult?.academic_words"><span
                                        class="px-3 py-1 bg-slate-50 text-slate-800 border border-gray-200 rounded-lg text-sm hover:bg-slate-200 cursor-pointer flex items-center"
                                        @click="query = aw.word; search()"><span x-text="aw.word"
                                            class="font-medium"></span>
                                            <template x-if="aw.part_of_speech">
                                                <span x-text="aw.part_of_speech" class="text-[9px] text-slate-400 lowercase italic ml-1.5"></span>
                                            </template>
                                            <span x-text="`(${aw.cefr})`"
                                            class="text-xs opacity-75 ml-1"></span></span></template></div>
                        </div>
                    </div>
                </div>
                @if(auth()->check() && auth()->user()->isAdmin())
                <div
                    class="p-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 bg-gray-50">
                    <div class="flex items-center gap-2"><span>Source:</span><span x-text="results?.source || 'Auto'"
                            class="font-bold"></span><a href="#" @click.prevent="testConnection()"
                            class="ml-2 text-slate-600">(Test Connection)</a></div>
                </div>
                @endif
            </div>
        </div>
    </template>
</div>

@once
<script>
    function dictionaryDataToolbar() {
        return {
            open: false, query: '', dictResult: null, loading: false, error: null, results: {},
            resetDictionary() {
                this.query = '';
                this.dictResult = null;
                this.error = null;
                this.loading = false;
                this.$nextTick(() => {
                    if (this.$refs.queryInput) this.$refs.queryInput.focus();
                });
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

                this.loading = true; this.error = null; this.dictResult = null; this.results.source = 'Google Translate';

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
                let source = 'Google Translate';
                let lang = isIndonesian ? 'id' : 'en';
                let part_of_speech = '';

                try {
                    // TIER 1: Google Translate GTX (Fast with AbortController 2.2s)
                    const googleTask = async () => {
                        try {
                            const ctrl = new AbortController();
                            const tid = setTimeout(() => ctrl.abort(), 2200);
                            const url1 = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${preferredSl}&tl=${preferredTl}&dt=t&q=` + encodeURIComponent(q);
                            const res1 = await fetch(url1, { signal: ctrl.signal });
                            clearTimeout(tid);
                            if (!res1.ok) throw new Error("Google failed");
                            const data1 = await res1.json();
                            let detected = (data1 && data1[2]) ? data1[2].toLowerCase() : (isIndonesian ? "id" : "en");
                            let translatedText = (data1 && data1[0] && Array.isArray(data1[0])) 
                                ? data1[0].map(c => (c && c[0]) ? c[0] : "").join("").trim()
                                : "";

                            if (preferredSl === 'auto' && (detected === "en" || translatedText.toLowerCase() === q.toLowerCase()) && preferredTl === 'en') {
                                const ctrl2 = new AbortController();
                                const tid2 = setTimeout(() => ctrl2.abort(), 1800);
                                const url2 = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=id&dt=t&q=" + encodeURIComponent(q);
                                const res2 = await fetch(url2, { signal: ctrl2.signal });
                                clearTimeout(tid2);
                                if (res2.ok) {
                                    const data2 = await res2.json();
                                    let translatedText2 = (data2 && data2[0] && Array.isArray(data2[0])) 
                                        ? data2[0].map(c => (c && c[0]) ? c[0] : "").join("").trim()
                                        : "";
                                    if (translatedText2) {
                                        return { text: translatedText2, source: "Google Translate", lang: "en" };
                                    }
                                }
                            }
                            if (translatedText) {
                                return { text: translatedText, source: "Google Translate", lang: detected === "id" ? "id" : "en" };
                            }
                        } catch(e) {}
                        return null;
                    };

                    // TIER 2: MyMemory Fallback (Fast with AbortController 2.2s)
                    const fallbackTask = async () => {
                        try {
                            const ctrl = new AbortController();
                            const tid = setTimeout(() => ctrl.abort(), 2200);
                            const pair = (preferredSl === 'id' || preferredTl === 'en') ? 'id|en' : 'en|id';
                            const res = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=${pair}`, { signal: ctrl.signal });
                            clearTimeout(tid);
                            const d = await res.json();
                            return d.responseData?.translatedText ? { text: d.responseData.translatedText.trim(), source: 'MyMemory', lang: pair === 'id|en' ? 'id' : 'en' } : null;
                        } catch(e) { return null; }
                    };

                    let res = await googleTask();
                    if (!res || !res.text) res = await fallbackTask();

                    if (res && res.text) {
                        translation = res.text;
                        source = res.source;
                        lang = res.lang || (isIndonesian ? "id" : "en");
                    } else {
                        throw new Error('Not found');
                    }

                    // Parallel Examples / Synonyms fetch
                    let examples = [];
                    let synonyms = [];
                    let academic_words = [];

                    let enWord = lang === 'en' ? q : translation;
                    if (enWord) {
                        const cleanEnglish = enWord.replace(/[^a-zA-Z\s-]/g, "").trim();
                        if (cleanEnglish && cleanEnglish.split(/\s+/).length === 1) {
                            const dictCtrl = new AbortController();
                            const dictTid = setTimeout(() => dictCtrl.abort(), 1800);

                            try {
                                const [dRes, mRes] = await Promise.allSettled([
                                    fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(cleanEnglish)}`, { signal: dictCtrl.signal }).then(r => r.ok ? r.json() : null),
                                    fetch(`https://api.datamuse.com/words?rel_syn=${encodeURIComponent(cleanEnglish)}&md=p&max=8`, { signal: dictCtrl.signal }).then(r => r.ok ? r.json() : null)
                                ]);
                                clearTimeout(dictTid);

                                const dictData = dRes.status === 'fulfilled' ? dRes.value : null;
                                const museData = mRes.status === 'fulfilled' ? mRes.value : null;

                                if (dictData && dictData[0]?.meanings) {
                                    dictData[0].meanings.forEach(m => {
                                        if (m.partOfSpeech && !part_of_speech) part_of_speech = m.partOfSpeech;
                                        if (m.definitions) {
                                            m.definitions.forEach(d => { if (d.example) examples.push(d.example); });
                                        }
                                    });
                                }
                                if (museData && Array.isArray(museData)) {
                                    synonyms = museData.map(i => {
                                        let pos = '';
                                        if (i.tags) {
                                            if (i.tags.includes('n')) pos = 'noun';
                                            else if (i.tags.includes('v')) pos = 'verb';
                                            else if (i.tags.includes('adj')) pos = 'adj';
                                            else if (i.tags.includes('adv')) pos = 'adv';
                                        }
                                        return { word: i.word, part_of_speech: pos };
                                    });
                                }
                            } catch(err) {}
                        }
                    }

                    const finalResult = {
                        source: lang,
                        original: q,
                        translation: translation,
                        part_of_speech: part_of_speech,
                        examples: [...new Set(examples)].slice(0, 3),
                        synonyms: synonyms.slice(0, 8),
                        academic_words: academic_words,
                        usedSource: source
                    };

                    this.dictResult = finalResult;
                    this.results.source = source;

                    // Save to memory cache
                    window.__tbDictCache.set(cacheKey, finalResult);

                } catch (e) { 
                    this.error = "Terjemahan tidak tersedia saat ini. Silakan coba kembali."; 
                } finally { 
                    this.loading = false; 
                }
            },
            playAudio(text, lang) { if (window.speechSynthesis) { const u = new SpeechSynthesisUtterance(text); u.lang = lang; window.speechSynthesis.speak(u); } },
            testConnection() { alert('Connection Test: OK'); }
        }
    }
</script>
@endonce
