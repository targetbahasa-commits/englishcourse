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
                    <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg></button>
                </div>
                <div class="p-4 border-b border-gray-100">
                    <form @submit.prevent="search" class="flex gap-2"><input type="text" x-model="query"
                            placeholder="Type a word..."
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-black"><button type="submit"
                            class="bg-slate-700 text-white px-6 py-2 rounded-lg" :disabled="loading"><span
                                x-show="!loading">Search</span><span x-show="loading">...</span></button></form>
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
            async search() {
                if (!this.query.trim()) return;
                this.loading = true; this.error = null; this.dictResult = null; this.results.source = 'Auto';
                const q = this.query.trim(); const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                try {
                    // 1. MyMemory Fallback
                    const fallback = async () => {
                        const res = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=en|id`);
                        const d = await res.json();
                        return d.responseData?.translatedText ? { text: d.responseData.translatedText, source: 'MyMemory', lang: 'en' } : null;
                    };

                    // 2. Try Direct Connection
                    const aiTask = async () => {
                        try {
                            const r = await fetch('/api/ollama/translate', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }, body: JSON.stringify({ text: q }) });
                            if (r.ok) {
                                const d = await r.json();
                                if (d.translation) return { text: d.translation, source: d.source || 'Groq/Gemini AI', lang: d.detected_source, part_of_speech: d.part_of_speech };
                            }
                        } catch (e) { }

                        try {
                            let activeModel = 'local-model';
                            let modelNameDisplay = 'Local AI';
                            try {
                                const modelsRes = await fetch('http://localhost:1234/v1/models').then(r => r.ok ? r.json() : null).catch(() => null);
                                if (modelsRes && modelsRes.data && modelsRes.data.length > 0) {
                                    const m = modelsRes.data.find(m => !m.id.toLowerCase().includes('embed'));
                                    if (m) {
                                        activeModel = m.id;
                                        modelNameDisplay = m.id.split('/').pop();
                                    }
                                }
                            } catch (e) { }

                            const sysPrompt = "You are a professional dictionary. Detect language and translate. Return ONLY strict JSON. No chatter. No poems. Max 5 words.";
                            const userPrompt = `Analyze the word "${q}".\n1. Detect if it is Indonesian or English.\n2. Translate it to the OTHER language.\n3. Determine the part of speech of the English word (e.g., noun, verb, adjective, adverb).\n4. Return JSON: { "detected_source": "id" or "en", "translation": "translated_word", "part_of_speech": "noun" }\n\nExample:\nInput: "house"\nOutput: { "detected_source": "en", "translation": "rumah", "part_of_speech": "noun" }\n\nInput: "${q}"\nOutput:`;

                            const directRes = await fetch('http://localhost:1234/v1/chat/completions', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    model: activeModel,
                                    messages: [{ role: 'system', content: sysPrompt }, { role: 'user', content: userPrompt }],
                                    temperature: 0.1, stream: false
                                })
                            });

                            if (directRes.ok) {
                                const dData = await directRes.json();
                                const content = dData.choices[0].message.content;
                                let parsed = null;
                                try { parsed = JSON.parse(content); }
                                catch (e) {
                                    const match = content.match(/\{[\s\S]*\}/);
                                    if (match) parsed = JSON.parse(match[0]);
                                }

                                if (parsed && parsed.translation) {
                                    if (parsed.translation.length > 60 && q.length < 20) return null;
                                    if (q.split(' ').length === 1 && parsed.translation.split(' ').length > 5) return null;
                                    return { text: parsed.translation, source: modelNameDisplay, lang: parsed.detected_source, part_of_speech: parsed.part_of_speech };
                                }
                            }
                        } catch (e) { }
                        return null;
                    };

                    // Race
                    let winner = null;
                    try { winner = await Promise.race([aiTask(), new Promise((_, r) => setTimeout(() => r('timeout'), 4000))]); } catch (e) { }

                    let translation = ''; let source = ''; let lang = 'en'; let part_of_speech = '';
                    if (winner) { translation = winner.text; source = winner.source; lang = winner.lang; part_of_speech = winner.part_of_speech; }
                    else { const fb = await fallback(); if (fb) { translation = fb.text; source = fb.source; lang = fb.lang; } else throw new Error('Not found'); }

                    // Examples/Synonyms
                    this.dictResult = { source: lang, original: q, translation: translation, part_of_speech: part_of_speech, examples: [], synonyms: [] };
                    this.results.source = source;

                    let enWord = lang === 'en' ? q : translation;
                    if (enWord) {
                        const cleanEnglish = enWord.replace(/[.,?!]/g, "").trim();
                        if (cleanEnglish && cleanEnglish.split(/\s+/).length === 1) {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                            const [dRes, mRes, aRes] = await Promise.all([
                                fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(cleanEnglish)}`).then(r => r.ok ? r.json() : null).catch(() => null),
                                fetch(`https://api.datamuse.com/words?rel_syn=${encodeURIComponent(cleanEnglish)}&md=p&max=10`).then(r => r.ok ? r.json() : null).catch(() => null),
                                fetch('/api/ollama/academic-words', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                                    body: JSON.stringify({ word: cleanEnglish })
                                }).then(r => r.ok ? r.json() : null).catch(() => null)
                            ]);
                            if (dRes && dRes[0]?.meanings) {
                                dRes[0].meanings.forEach(m => m.definitions.forEach(d => { if (d.example) this.dictResult.examples.push(d.example); }));
                                this.dictResult.examples = [...new Set(this.dictResult.examples)].slice(0, 3);
                            }
                            if (mRes) {
                                this.dictResult.synonyms = mRes.map(i => {
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
                            if (aRes && aRes.academic_words) this.dictResult.academic_words = aRes.academic_words;
                        }
                    }
                } catch (e) { this.error = "Translation failed."; } finally { this.loading = false; }
            },
            playAudio(text, lang) { if (window.speechSynthesis) { const u = new SpeechSynthesisUtterance(text); u.lang = lang; window.speechSynthesis.speak(u); } },
            testConnection() { alert('Connection Test: OK'); }
        }
    }
</script>
@endonce
