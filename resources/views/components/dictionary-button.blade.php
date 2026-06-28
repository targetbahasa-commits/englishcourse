<div x-data="dictionaryData()"
@mousemove.window="doDrag"
@touchmove.window="doDrag"
@mouseup.window="stopDrag"
@touchend.window="stopDrag"
class="fixed z-50 select-none touch-none"
:style="`left: ${x}px; top: ${y}px;`">

<script>
function dictionaryData() {
    return {
        open: false,
        query: '',
        dictResult: null,
        results: {
            translation: '',
            examples: [],
            synonyms: [],
            source: '', // Track Used Source
            debug: '' // Track Error Msg
        },
        loading: false,
        error: null,
        x: window.innerWidth - 260,
        y: window.innerHeight - 145,
        dragging: false,
        offset: { x: 0, y: 0 },
        hasMoved: false,
        
        init() {
            console.log('Dictionary Component v3.0 - Safeguards Active');
            window.addEventListener('resize', () => {
                this.x = Math.min(this.x, window.innerWidth - 60);
                this.y = Math.min(this.y, window.innerHeight - 60);
            });
        },
        startDrag(e) {
            this.dragging = true;
            this.hasMoved = false;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            this.offset.x = clientX - this.x;
            this.offset.y = clientY - this.y;
        },
        doDrag(e) {
            if (this.dragging) {
                this.hasMoved = true;
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                this.x = clientX - this.offset.x;
                this.y = clientY - this.offset.y;
            }
        },
        stopDrag() {
            this.dragging = false;
        },
        handleClick() {
            if (!this.hasMoved) {
                this.open = true;
            }
        },

        async search() {
            if(!this.query.trim()) return;
            this.loading = true;
            this.error = null;
            this.dictResult = null;
            this.results.debug = ''; 
            
            const q = this.query.trim();
            
            // Variables for Result
            let translation = '';
            let finalSource = 'auto'; 
            let usedSource = 'MyMemory (Cloud)';

            try {
                // 1. DEFINE TASKS (Parallel Promises)
                
                // TASK A: FALLBACK (MyMemory - Fast)
                const fallbackTask = (async () => {
                     try {
                        let heuristicSource = 'id'; // Default to Indonesian
                        
                        // Detect English Features (Heuristic: Common Words + Suffixes)
                        const englishCommon = /\b(the|this|that|is|are|am|was|were|i|you|he|she|they|we|it|what|when|where|why|how|a|an|in|on|at|to|for|with|by|from|of|and|but|or|so|not|no|yes|if|as|be|have|has|do|does|did|will|would|can|could|should)\b/i;
                        const englishSuffixes = /(tion|ment|nce|ness|ity|ing|ed|ous|ive|al|ic|ble|est|er|ly)$/i;
                        
                        // Detect Indonesian Features (Common Words + Affixes)
                        const indoCommon = /\b(yang|di|ke|dari|dan|atau|tapi|ini|itu|ada|adalah|dengan|untuk|bagi|pada|saya|kamu|dia|mereka|kita|kami|apa|kapan|dimana|kenapa|bagaimana|tidak|ya|bukan|jika|karena|sudah|sedang|akan|bisa|dapat|harus)\b/i;
                        const indoAffixes = /^(ber|ter|se|me|di|ke)|(kan|an|i|lah|kah|nya|ku|mu)$/i;

                        // Score-based Detection
                        let enScore = 0;
                        let idScore = 0;

                        if (q.match(englishCommon)) enScore += 2;
                        if (q.match(englishSuffixes)) enScore += 1;
                        
                        if (q.match(indoCommon)) idScore += 2;
                        if (q.match(indoAffixes)) idScore += 1;

                        // Tie-breaker: Length for English suffixes is usually stronger for academic words
                        if (enScore > idScore) {
                            heuristicSource = 'en';
                        } else if (idScore > enScore) {
                            heuristicSource = 'id';
                        } else {
                            // Default / Fallback based on character characteristics if needed, or stick to 'id' default
                            // But for "complicated", 'ed' gives +1 enScore. 'd' is not a specific ID suffix.
                            // So heuristicSource should become 'en'.
                            if (q.match(englishSuffixes)) heuristicSource = 'en';
                        }
                        
                        const pair = heuristicSource === 'id' ? 'id|en' : 'en|id';
                        const res = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=${pair}`);
                        const data = await res.json();
                        
                        if (data.responseData && data.responseData.translatedText) {
                            return { 
                                type: 'mymemory', 
                                text: data.responseData.translatedText, 
                                source: 'MyMemory (Cloud)',
                                lang: heuristicSource, // Correctly set Source Language (id or en)
                                detected: heuristicSource
                            };
                        }
                     } catch(e) { console.warn('Fallback failed', e); }
                     return null;
                })();

                // TASK B: AI (Llama 3 - High Quality)
                const aiTask = (async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    // 1. Try Backend First
                    try {
                        const ollamaRes = await fetch('/api/ollama/translate', {
                             method: 'POST',
                             headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                             body: JSON.stringify({ text: q })
                        });
                        if (ollamaRes.ok) {
                             const oData = await ollamaRes.json();
                             if (oData.translation) {
                                 const t = oData.translation;
                                 
                                 // Hallucination Check (Backend)
                                 if (t.length > 50 && q.length < 20) return null;
                                 if (q.split(' ').length === 1 && t.split(' ').length > 5) return null;

                                 return { type: 'ai', text: t, source: 'Llama 3 (Local Brain)', detected: oData.detected_source };
                             }
                        }
                    } catch(e) { }

                    // 2. Try Direct Connection
                    try {
                         let activeModel = 'local-model';
                         let modelNameDisplay = 'Local AI';
                         try {
                             const modelsRes = await fetch('http://localhost:1234/v1/models').then(r=>r.ok?r.json():null).catch(()=>null);
                             if (modelsRes && modelsRes.data && modelsRes.data.length > 0) {
                                 const m = modelsRes.data.find(m => !m.id.toLowerCase().includes('embed'));
                                 if (m) {
                                     activeModel = m.id;
                                     modelNameDisplay = m.id.split('/').pop();
                                 }
                             }
                         } catch(e) {}
                         
                         const sysPrompt = "You are a professional dictionary. Detect language and translate. Return ONLY strict JSON. No chatter. No poems. Max 5 words.";
                         const userPrompt = `Analyze the word "${q}".\n1. Detect if it is Indonesian or English.\n2. Translate it to the OTHER language.\n3. Return JSON: { "detected_source": "id" or "en", "translation": "translated_word" }\n\nExample:\nInput: "house"\nOutput: { "detected_source": "en", "translation": "rumah" }\n\nInput: "${q}"\nOutput:`;
                         
                         const directRes = await fetch('http://localhost:1234/v1/chat/completions', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                model: activeModel,
                                messages: [ { role: 'system', content: sysPrompt }, { role: 'user', content: userPrompt } ],
                                temperature: 0.1, stream: false
                            })
                         });
                         
                         if (directRes.ok) {
                             const dData = await directRes.json();
                             const content = dData.choices[0].message.content;
                             let parsed = null;
                             try { parsed = JSON.parse(content); } 
                             catch(e) { 
                                 const match = content.match(/\{[\s\S]*\}/);
                                 if(match) parsed = JSON.parse(match[0]);
                             }
                             
                             if (parsed && parsed.translation) {
                                  // Hallucination Check: Reject overly long translations (Poem/Explanation filter)
                                  if (parsed.translation.length > 60 && q.length < 20) {
                                      console.warn('AI Hallucination Rejected (Too Long):', parsed.translation);
                                      return null; 
                                  }
                                  
                                  // Word Count Check: Single word input shouldn't yield > 5 words output
                                  if (q.split(' ').length === 1 && parsed.translation.split(' ').length > 5) {
                                      console.warn('AI Hallucination Rejected (Too Many Words):', parsed.translation);
                                      return null;
                                  }

                                  const cT = parsed.translation.toLowerCase().trim();
                                  const cQ = q.toLowerCase().trim();

                                  if (cT !== cQ && !((cT.length > 5 && cT.includes(cQ)))) {
                                      return { type: 'ai', text: parsed.translation, source: modelNameDisplay, detected: parsed.detected_source };
                                  }
                             }
                         }
                    } catch(e) { }
                    
                    throw new Error('AI Failed');
                })();

                // 2. STRATEGY SELECTION: Word vs Sentence
                // Single words -> Prefer Deterministic (MyMemory) to avoid "Creative" Hallucinations
                // Sentences -> Prefer AI (Llama 3) for context handling
                
                const isSentence = q.split(/\s+/).length > 2;

                if (!isSentence) {
                    // --- SINGLE WORD STRATEGY ---
                    // 1. Try AI First (Better quality for common words like "perlindungan" -> "protection")
                    let aiWinner = null;
                    try {
                        // Give AI 5 seconds (allow warm-up time)
                        aiWinner = await Promise.race([ aiTask, new Promise((_, r) => setTimeout(() => r('timeout'), 5000)) ]);
                    } catch (e) { }

                    if (aiWinner) {
                         translation = aiWinner.text;
                         usedSource = aiWinner.source;
                         if (aiWinner.detected) finalSource = aiWinner.detected.toLowerCase();
                    } else {
                        // 2. Fallback to MyMemory (Deterministic)
                        let fb = await fallbackTask;
                        
                        // Optimization: Swap check (if MyMemory failed language detection)
                        const isBadTranslation = (text, query) => {
                            if (!text) return true;
                            const t = text.toLowerCase().trim();
                            const q = query.toLowerCase().trim();
                            return t === q || t.indexOf(q) !== -1;
                        };

                        if (fb && isBadTranslation(fb.text, q)) {
                             const swapPair = fb.lang === 'id' ? 'en|id' : 'id|en';
                             try {
                                const res2 = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=${swapPair}`);
                                const data2 = await res2.json();
                                 if (data2.responseData && data2.responseData.translatedText) {
                                     const t2 = data2.responseData.translatedText;
                                     if (!isBadTranslation(t2, q)) {
                                         fb = { 
                                             type: 'mymemory', 
                                             text: t2, 
                                             source: 'MyMemory (Cloud)',
                                             lang: fb.lang === 'id' ? 'en' : 'id',
                                             detected: fb.lang === 'id' ? 'en' : 'id'
                                         };
                                     }
                                 }
                             } catch(e) {}
                        }
                        
                        if (fb && fb.text && !isBadTranslation(fb.text, q)) {
                            translation = fb.text;
                            usedSource = fb.source;
                            finalSource = fb.lang;
                        }
                    }
                } else {
                    // --- SENTENCE STRATEGY ---
                    // Race AI vs Timeout, fall back to MyMemory
                    let winner = null;
                    try {
                        const timeoutPromise = new Promise((_, reject) => setTimeout(() => reject('timeout'), 3000)); // Longer timeout for sentences
                        winner = await Promise.race([ aiTask, timeoutPromise ]);
                    } catch (error) { console.log('AI Timeout'); }

                    if (winner) {
                        translation = winner.text;
                        usedSource = winner.source;
                        if (winner.detected) finalSource = winner.detected.toLowerCase();
                    } else {
                        const fb = await fallbackTask;
                        if (fb) {
                            translation = fb.text;
                            usedSource = fb.source;
                            finalSource = fb.lang;
                        }
                    }
                }
                
                if(!translation) throw new Error('Translation Unavailable');
                
                // --- FINAL DEFENSE: Ruthless Override for Hallucinations ---
                // If, despite all safeguards, we still have a poem for a single word, DESTROY IT.
                if (!isSentence && translation.length > 50) {
                     console.warn('Final Defense Triggered: Overwriting AI Hallucination with MyMemory');
                     try {
                         // Force ID|EN or EN|ID based on guess
                         const pair = 'id|en'; // Default guess
                         const resFO = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=${pair}`);
                         const dataFO = await resFO.json();
                         if (dataFO.responseData && dataFO.responseData.translatedText) {
                             translation = dataFO.responseData.translatedText;
                             usedSource = 'MyMemory (Emergency Validated)';
                             // If it still equals input, try swap
                             if (translation.toLowerCase() === q.toLowerCase()) {
                                  const resFO2 = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=en|id`);
                                  const dataFO2 = await resFO2.json();
                                  if (dataFO2.responseData?.translatedText) {
                                      translation = dataFO2.responseData.translatedText;
                                  }
                             }
                         }
                     } catch(e) { 
                         translation = "Translation Failed"; 
                     }
                }

                if(finalSource !== 'id' && finalSource !== 'en') finalSource = 'auto';

                // 3. EXAMPLES & THESAURUS
                const englishWord = finalSource === 'en' ? q : translation;
                const cleanEnglish = englishWord.replace(/[.,?!]/g, "").trim();
                let examples = [];
                let synonyms = [];
                let pos = [];
                let academic_words = [];

                if (cleanEnglish && cleanEnglish.split(/\s+/).length === 1) {
                     const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                     // Run these in parallel for speed too!
                     const [dictData, museData, aRes] = await Promise.all([
                        fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${cleanEnglish}`).then(r => r.ok ? r.json() : null).catch(()=>null),
                        fetch(`https://api.datamuse.com/words?rel_syn=${cleanEnglish}&max=10`).then(r => r.ok ? r.json() : null).catch(()=>null),
                        fetch('/api/ollama/academic-words', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                            body: JSON.stringify({ word: cleanEnglish })
                        }).then(r=>r.ok?r.json():null).catch(()=>null)
                     ]);
                     
                     if (Array.isArray(dictData)) {
                        dictData.forEach(entry => {
                            if(entry.meanings) {
                                entry.meanings.forEach(m => {
                                    pos.push(m.partOfSpeech);
                                    if(m.definitions) {
                                        m.definitions.forEach(d => {
                                            if(d.example) examples.push(d.example);
                                        });
                                    }
                                });
                            }
                        });
                     }
                     if (Array.isArray(museData)) {
                        synonyms = museData.map(i => i.word);
                     }
                     if (aRes && aRes.academic_words) {
                        academic_words = aRes.academic_words;
                     }
                }

                this.dictResult = {
                    source: finalSource,
                    original: q,
                    translation: translation,
                    examples: [...new Set(examples)].slice(0, 3),
                    synonyms: synonyms,
                    academic_words: academic_words,
                    pos: [...new Set(pos)]
                };
                
                this.results.source = usedSource;

            } catch(e) {
                console.error(e);
                this.error = 'Translation Unavailable';
            } finally {
                this.loading = false;
            }
        },
        testConnection() {
            alert('Testing Auto-Detection of Model...');
            
            // 1. Connectivity Check & Model List
            fetch('http://localhost:1234/v1/models')
                .then(async res => {
                    if(!res.ok) throw new Error('GET /models failed with Status ' + res.status);
                    
                    const data = await res.json();
                    const models = data.data || [];
                    
                    if (models.length === 0) {
                        alert('⚠️ CONNECTED, BUT NO MODELS FOUND.\n\nLM Studio Server is running, but returns 0 models.\nPlease ensure a model is loaded in the "Server" or "Chat" tab.');
                        return;
                    }

                    // Filter out Embedding Models (which cause 400 Error)
                    const activeModel = models.find(m => !m.id.toLowerCase().includes('embed'))?.id || models[0].id;
                    alert('✅ FOUND MODEL: ' + activeModel + '\nAttempting translation...');

                    // 2. Translation Check (POST)
                    try {
                        const postRes = await fetch('http://localhost:1234/v1/chat/completions', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                model: activeModel, // USE REAL ID
                                messages: [{ role: 'user', content: 'Say Success in one word.' }],
                                temperature: 0.7
                            })
                        });

                        if (postRes.ok) {
                            const data2 = await postRes.json();
                            const reply = data2.choices?.[0]?.message?.content || 'No Content';
                            alert('✅ FULL SUCCESS!\n\nModel "' + activeModel + '" replied: "' + reply + '"');
                            // If this works, we should update our main code to do this
                            this.results.source = 'Llama 3 (Direct)'; 
                            this.results.debug = '';
                        } else {
                            const txt = await postRes.text();
                            alert('⚠️ MODEL FOUND BUT ERROR.\nStatus: ' + postRes.status + '\nResponse: ' + txt);
                        }
                    } catch(postErr) {
                        alert('❌ POST REQUEST FAILED.\nError: ' + postErr.message);
                    }
                })
                .catch(err => {
                    alert('❌ CONNECTIVITY FAILED.\n\nError: ' + err.message);
                });
        },
        playAudio(text, lang) {
            if (!window.speechSynthesis) return;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = lang;
            window.speechSynthesis.speak(utterance);
        }
    }
}
</script>

    <!-- Floating Button -->
    <button @mousedown="startDrag"
            @touchstart="startDrag"
            @click="handleClick"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2 cursor-move select-none touch-none">
        Dictionary
    </button>

    <!-- Modal Backdrop -->
    <div x-show="open"
         x-transition.opacity
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         style="display: none;">
        
        <!-- Modal Content -->
        <div @click.outside="open = false"
             class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
            
            <!-- Header -->
            <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <h3 class="text-xl font-bold text-blue-900">Translation & Thesaurus</h3>
                    <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">Auto-Detect</span>
                </div>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Search Area -->
            <div class="p-4 border-b border-gray-100">
                <form @submit.prevent="search" class="flex gap-2">
                    <input type="text" x-model="query" 
                           placeholder="Type a word in English or Indonesia..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium disabled:opacity-50" :disabled="loading">
                        <span x-show="!loading">Search</span>
                        <span x-show="loading" class="animate-pulse">...</span>
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
                @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="flex items-center gap-2">
                        <span>Source:</span>
                        <span x-show="results.source === 'Llama 3 (Local Brain)' || results.source === 'Llama 3 (Direct)'" class="text-green-600 font-bold flex items-center gap-1">
                            <span>⚡</span> Llama 3
                        </span>
                        <span x-show="results.source !== 'Llama 3 (Local Brain)' && results.source !== 'Llama 3 (Direct)'" class="text-gray-500 flex items-center gap-1">
                            <span>☁️</span> MyMemory (Cloud)
                            <span x-show="error" class="text-red-400 ml-1 cursor-help underline decoration-red-400 decoration-dotted" :title="results.debug || 'Llama 3 Offline'">(Llama Offline)</span>
                        </span>
                        
                        <!-- Test Button -->
                        <a href="#" @click.prevent="testConnection()" class="text-blue-400 hover:text-blue-600 ml-2 border-l pl-2 border-gray-200">
                            (Test Connection)
                        </a>
                    </div>
                @else
                    <!-- Spacer for non-admins -->
                    <div></div>
                @endif
                <div>
                    Target Bahasa Course
                </div>
            </div>
        </div>
    </div>
</div>
