{{-- Toggle button itself lives inline per-question next to the "v" Vocabulary
     Helper badge (see self-study-class/player.blade.php) rather than here -
     this partial just provides the shared popup markup + toggle/lookup logic
     that every one of those per-question buttons calls into. --}}
<div id="vocabDefinitionPopup"
     class="fixed bg-slate-900 text-white rounded-xl shadow-2xl p-3.5 w-72 z-[60] text-left text-xs leading-relaxed"
     style="display: none;">
    <div class="flex items-center justify-between gap-2 mb-2 pb-1.5 border-b border-slate-700">
        <span id="vocab_popup_word" class="text-sky-300 font-mono font-semibold text-sm"></span>
        <button type="button" onclick="document.getElementById('vocabDefinitionPopup').style.display='none'" class="text-slate-400 hover:text-white p-0.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <div class="flex items-center gap-2">
        <p id="vocab_popup_translation" class="text-slate-100 font-semibold text-sm flex-1">Memuat...</p>
        <button type="button"
                id="vocab_popup_audio_btn"
                onclick="window.playVocabAudio()"
                title="Dengarkan pelafalan"
                class="text-slate-400 hover:text-sky-300 p-1 shrink-0"
                style="display: none;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
        </button>
    </div>
    <span id="vocab_popup_pos" class="inline-block text-[10px] font-semibold uppercase tracking-wide text-emerald-300 bg-emerald-900/40 px-1.5 py-0.5 rounded mt-1.5" style="display: none;"></span>
    <div id="vocab_popup_synonyms_wrap" class="mt-2 pt-2 border-t border-slate-800" style="display: none;">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Sinonim</span>
        <p id="vocab_popup_synonyms" class="text-slate-200 mt-0.5"></p>
    </div>
</div>

<script>
(function() {
    if (window.__vocabHelperLoaded) return;
    window.__vocabHelperLoaded = true;

    window.vocabModeActive = false;

    /* One toggle button is rendered per question (next to its "v" Vocabulary
       Helper badge), all driving the same page-wide on/off state - plain
       class sync here instead of an Alpine store, since these buttons are
       static Blade markup with no shared x-data ancestor. */
    const vocabToggleActiveStyle = document.createElement('style');
    vocabToggleActiveStyle.innerHTML = `
        .vocab-toggle-btn.vocab-toggle-active {
            background-color: #10b981 !important;
            color: #ffffff !important;
            border-color: #059669 !important;
        }
    `;
    document.head.appendChild(vocabToggleActiveStyle);

    function syncVocabToggleButtons() {
        document.querySelectorAll('.vocab-toggle-btn').forEach(btn => {
            btn.classList.toggle('vocab-toggle-active', window.vocabModeActive);
        });
    }

    /* Soal sentences are rendered server-side as plain Blade-escaped text,
       so a plain TreeWalker-per-target wrap is enough - no nested markup to
       worry about like the Reading passage wrapper has to handle. */
    function unwrapVocabWords() {
        document.querySelectorAll('.grammar-soal-text .vocab-word').forEach(span => {
            const parent = span.parentNode;
            if (!parent) return;
            parent.replaceChild(document.createTextNode(span.textContent), span);
            parent.normalize();
        });
    }

    function wrapVocabWords() {
        document.querySelectorAll('.grammar-soal-text').forEach(el => {
            if (el.querySelector('.vocab-word')) return;

            const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT, null, false);
            const textNodes = [];
            let n;
            while ((n = walker.nextNode())) textNodes.push(n);

            textNodes.forEach(textNode => {
                const tokens = (textNode.nodeValue || '').match(/([a-zA-Z0-9\-']+|[^a-zA-Z0-9\-'\s]+|\s+)/g) || [];
                if (tokens.length === 0) return;

                const frag = document.createDocumentFragment();
                tokens.forEach(token => {
                    if (/^[a-zA-Z0-9\-']+$/.test(token)) {
                        const span = document.createElement('span');
                        span.className = 'vocab-word cursor-pointer hover:bg-emerald-100 hover:text-emerald-800 rounded px-0.5 transition-colors border-b border-dashed border-emerald-400';
                        span.textContent = token;
                        span.addEventListener('click', function(e) {
                            e.stopPropagation();
                            window.lookupVocabWord(token, e);
                        });
                        frag.appendChild(span);
                    } else {
                        frag.appendChild(document.createTextNode(token));
                    }
                });

                textNode.parentNode.replaceChild(frag, textNode);
            });
        });
    }

    window.toggleVocabMode = function(forcedState = null) {
        window.vocabModeActive = forcedState !== null ? Boolean(forcedState) : !window.vocabModeActive;
        syncVocabToggleButtons();

        if (window.vocabModeActive) {
            wrapVocabWords();
        } else {
            unwrapVocabWords();
            const popup = document.getElementById('vocabDefinitionPopup');
            if (popup) popup.style.display = 'none';
        }
    };

    /* Soal sentences are Indonesian (student translates them to English),
       the reverse of the Reading passages this mechanic was copied from -
       so the lookup direction here is fixed id->en, unlike the Dictionary
       button's auto-detect heuristic. Same provider chain (Google GTX, then
       MyMemory) as that button, just simplified to one direction. Each cache
       entry accumulates translation first, then part-of-speech/synonyms on
       first lookup, so re-clicking the same word never re-fetches. */
    const vocabTranslateCache = new Map();

    async function translateIdToEn(word) {
        let result = null;
        try {
            const ctrl = new AbortController();
            const tid = setTimeout(() => ctrl.abort(), 2500);
            const res = await fetch('https://translate.googleapis.com/translate_a/single?client=gtx&sl=id&tl=en&dt=t&q=' + encodeURIComponent(word), { signal: ctrl.signal });
            clearTimeout(tid);
            if (res.ok) {
                const data = await res.json();
                const text = (data && data[0] && Array.isArray(data[0]))
                    ? data[0].map(c => (c && c[0]) ? c[0] : '').join('').trim()
                    : '';
                if (text) result = text;
            }
        } catch (e) {}

        if (!result) {
            try {
                const ctrl2 = new AbortController();
                const tid2 = setTimeout(() => ctrl2.abort(), 2500);
                const res2 = await fetch('https://api.mymemory.translated.net/get?q=' + encodeURIComponent(word) + '&langpair=id|en', { signal: ctrl2.signal });
                clearTimeout(tid2);
                if (res2.ok) {
                    const data2 = await res2.json();
                    const text2 = data2 && data2.responseData ? data2.responseData.translatedText : null;
                    if (text2) result = text2.trim();
                }
            } catch (e) {}
        }

        return result;
    }

    /* Same providers/pattern as the Dictionary button's thesaurus lookup:
       dictionaryapi.dev for part-of-speech, Datamuse for synonyms - both
       only meaningful for a single English word, same guard as there.
       Accepts an already-fetched dictData so callers that validated a
       de-inflected candidate via fetchDictEntry() below don't pay for that
       lookup twice. */
    async function fetchEnglishMeta(englishWord, preFetchedDictData) {
        const cleanEnglish = (englishWord || '').replace(/[^a-zA-Z\s-]/g, '').trim();
        if (!cleanEnglish || cleanEnglish.split(/\s+/).length !== 1) return { pos: [], synonyms: [] };

        try {
            const ctrl = new AbortController();
            const tid = setTimeout(() => ctrl.abort(), 2200);
            const [dictRes, museRes] = await Promise.allSettled([
                preFetchedDictData !== undefined
                    ? Promise.resolve(preFetchedDictData)
                    : fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(cleanEnglish)}`, { signal: ctrl.signal }).then(r => r.ok ? r.json() : null),
                fetch(`https://api.datamuse.com/words?rel_syn=${encodeURIComponent(cleanEnglish)}&max=8`, { signal: ctrl.signal }).then(r => r.ok ? r.json() : null)
            ]);
            clearTimeout(tid);

            const dictData = dictRes.status === 'fulfilled' ? dictRes.value : null;
            const museData = museRes.status === 'fulfilled' ? museRes.value : null;

            let pos = [];
            if (Array.isArray(dictData)) {
                dictData.forEach(entry => {
                    (entry.meanings || []).forEach(m => { if (m.partOfSpeech) pos.push(m.partOfSpeech); });
                });
            }
            const synonyms = Array.isArray(museData) ? museData.map(i => i.word).filter(Boolean) : [];

            return { pos: [...new Set(pos)], synonyms: synonyms.slice(0, 8) };
        } catch (e) {
            return { pos: [], synonyms: [] };
        }
    }

    /* Indonesian verbs carry their voice/tense as prefixes/suffixes on the
       root (di- passive, me(ng/ny/n/m)- active, -kan/-i applicative) -
       Google/MyMemory then naturally render that as an inflected English
       form ("diverifikasi" -> "verified" instead of "verify"). Gate the
       de-inflection below on this so plain nouns/adjectives that happen to
       end in a verb-like English suffix are left untouched. */
    function looksLikeIndonesianVerbForm(word) {
        const w = word.toLowerCase();
        return /^(di|ter|ber|meng|meny|men|mem|me|per)[a-z]{3,}/.test(w) || /(kan|i)$/.test(w);
    }

    function buildIrregularVerbMap() {
        if (window.__vocabIrregularMap) return window.__vocabIrregularMap;
        const map = {};
        (window.__irregularVerbsList || []).forEach(([base, past, pastParticiple]) => {
            [past, pastParticiple].forEach(form => {
                (form || '').split('/').forEach(variant => {
                    const clean = variant.replace(/[()]/g, '').trim().toLowerCase();
                    if (clean && clean !== base) map[clean] = base;
                });
            });
        });
        window.__vocabIrregularMap = map;
        return map;
    }

    /* Ordered best-guess base forms for a regular English verb inflection -
       ambiguous cases (e.g. does stripping "ed" need the trailing "e" kept,
       as in "created", or dropped, as in "tested"?) are resolved by trying
       each candidate against the real dictionary in fetchDictEntry(),
       rather than by a fragile spelling rule alone. */
    function regularVerbCandidates(lowerWord) {
        const w = lowerWord;
        const candidates = [];
        const hasDoubledConsonant = (stem) => stem.length > 2
            && stem[stem.length - 1] === stem[stem.length - 2]
            && !'aeiou'.includes(stem[stem.length - 1]);

        if (w.length > 4 && w.endsWith('ied')) {
            candidates.push(w.slice(0, -3) + 'y');
        } else if (w.length > 5 && w.endsWith('ing')) {
            const stem = w.slice(0, -3);
            if (hasDoubledConsonant(stem)) candidates.push(stem.slice(0, -1));
            candidates.push(stem);
            candidates.push(stem + 'e');
        } else if (w.length > 4 && w.endsWith('ies')) {
            candidates.push(w.slice(0, -3) + 'y');
        } else if (w.length > 4 && /(ches|shes|xes|zes|ses)$/.test(w)) {
            candidates.push(w.slice(0, -2));
        } else if (w.length > 3 && w.endsWith('ed')) {
            const stem = w.slice(0, -2);
            if (hasDoubledConsonant(stem)) candidates.push(stem.slice(0, -1));
            candidates.push(stem);
            candidates.push(w.slice(0, -1));
        } else if (w.length > 3 && w.endsWith('s') && !w.endsWith('ss')) {
            candidates.push(w.slice(0, -1));
        }

        return [...new Set(candidates)];
    }

    async function fetchDictEntry(candidateWord) {
        try {
            const ctrl = new AbortController();
            const tid = setTimeout(() => ctrl.abort(), 2000);
            const res = await fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(candidateWord)}`, { signal: ctrl.signal });
            clearTimeout(tid);
            if (!res.ok) return null;
            const data = await res.json();
            return Array.isArray(data) && data.length > 0 ? data : null;
        } catch (e) {
            return null;
        }
    }

    /* Returns the base/V1 form of a verb translation plus (when available)
       the dictionary entry already fetched to confirm it, so the caller can
       skip re-fetching that same entry for part-of-speech. */
    async function normalizeVerbTranslation(translatedWord) {
        const lower = translatedWord.toLowerCase();
        if (lower.split(/\s+/).length !== 1) return { word: translatedWord, dictData: undefined };

        const irregularBase = buildIrregularVerbMap()[lower];
        if (irregularBase) {
            const dictData = await fetchDictEntry(irregularBase);
            return { word: irregularBase, dictData };
        }

        for (const candidate of regularVerbCandidates(lower)) {
            if (candidate === lower) continue;
            const dictData = await fetchDictEntry(candidate);
            if (dictData) return { word: candidate, dictData };
        }

        return { word: translatedWord, dictData: undefined };
    }

    /* These words ARE the grammar point this course tests (nominal "to be"
       sentences, conjunctions, tense/aspect markers) - showing their direct
       English translation hands the student the answer to questions built
       around exactly that word. A clue instead of a translation. */
    const GRAMMAR_CLUE_WORDS = {
        adalah: { label: 'TO BE (LINKING VERB)', clue: 'Penghubung subjek-predikat. Gunakan is/are sesuai subjek.' },
        merupakan: { label: 'TO BE (LINKING VERB)', clue: 'Penghubung subjek-predikat. Gunakan is/are sesuai subjek.' },
        ialah: { label: 'TO BE (LINKING VERB)', clue: 'Penghubung subjek-predikat. Gunakan is/are sesuai subjek.' },
        yaitu: { label: 'TO BE (LINKING VERB)', clue: 'Penghubung penjelas. Gunakan is/are/namely sesuai konteks.' },
        yakni: { label: 'TO BE (LINKING VERB)', clue: 'Penghubung penjelas. Gunakan is/are/namely sesuai konteks.' },

        dan: { label: 'KONJUNGSI', clue: 'Kata hubung penambah.' },
        atau: { label: 'KONJUNGSI', clue: 'Kata hubung pilihan.' },
        tetapi: { label: 'KONJUNGSI', clue: 'Kata hubung pertentangan.' },
        namun: { label: 'KONJUNGSI', clue: 'Kata hubung pertentangan.' },
        karena: { label: 'KONJUNGSI', clue: 'Kata hubung sebab.' },
        sebab: { label: 'KONJUNGSI', clue: 'Kata hubung sebab.' },
        sehingga: { label: 'KONJUNGSI', clue: 'Kata hubung akibat.' },
        agar: { label: 'KONJUNGSI', clue: 'Kata hubung tujuan.' },
        supaya: { label: 'KONJUNGSI', clue: 'Kata hubung tujuan.' },
        meskipun: { label: 'KONJUNGSI', clue: 'Kata hubung kontras.' },
        walaupun: { label: 'KONJUNGSI', clue: 'Kata hubung kontras.' },
        sedangkan: { label: 'KONJUNGSI', clue: 'Kata hubung kontras.' },
        padahal: { label: 'KONJUNGSI', clue: 'Kata hubung kontras.' },
        jika: { label: 'KONJUNGSI', clue: 'Kata hubung syarat.' },
        kalau: { label: 'KONJUNGSI', clue: 'Kata hubung syarat.' },
        apabila: { label: 'KONJUNGSI', clue: 'Kata hubung syarat/waktu.' },
        ketika: { label: 'KONJUNGSI', clue: 'Kata hubung waktu.' },
        saat: { label: 'KONJUNGSI', clue: 'Kata hubung waktu.' },
        sambil: { label: 'KONJUNGSI', clue: 'Kata hubung waktu bersamaan.' },
        setelah: { label: 'KONJUNGSI', clue: 'Kata hubung waktu.' },
        sebelum: { label: 'KONJUNGSI', clue: 'Kata hubung waktu.' },
        hingga: { label: 'KONJUNGSI', clue: 'Kata hubung batas waktu/akibat.' },
        sampai: { label: 'KONJUNGSI', clue: 'Kata hubung batas waktu.' },
        bahwa: { label: 'KONJUNGSI', clue: 'Kata hubung keterangan.' },
        yang: { label: 'KATA PENGHUBUNG', clue: 'Kata penghubung relatif (that/which/who).' },
        serta: { label: 'KONJUNGSI', clue: 'Kata hubung penambah, serupa "dan".' },
        maupun: { label: 'KONJUNGSI', clue: 'Kata hubung pilihan/penambah.' },
        ataupun: { label: 'KONJUNGSI', clue: 'Kata hubung pilihan.' },
        lalu: { label: 'KONJUNGSI', clue: 'Kata hubung urutan waktu.' },
        kemudian: { label: 'KONJUNGSI', clue: 'Kata hubung urutan waktu.' },

        sudah: { label: 'PENANDA WAKTU', clue: 'Penanda aspek selesai.' },
        telah: { label: 'PENANDA WAKTU', clue: 'Penanda aspek selesai.' },
        sedang: { label: 'PENANDA WAKTU', clue: 'Penanda aspek sedang berlangsung.' },
        akan: { label: 'PENANDA WAKTU', clue: 'Penanda waktu masa depan.' },
        pernah: { label: 'PENANDA WAKTU', clue: 'Penanda pengalaman.' },
        belum: { label: 'PENANDA WAKTU', clue: 'Penanda aspek belum selesai.' },
        masih: { label: 'PENANDA WAKTU', clue: 'Penanda keberlanjutan.' },
    };

    window.playVocabAudio = function() {
        const text = document.getElementById('vocab_popup_translation').textContent;
        if (!window.speechSynthesis || !text || text === 'Memuat...' || text === 'Terjemahan tidak ditemukan') return;
        window.speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US';
        utterance.rate = 0.9;
        window.speechSynthesis.speak(utterance);
    };

    window.lookupVocabWord = async function(word, event) {
        const popup = document.getElementById('vocabDefinitionPopup');
        if (!popup) return;

        const x = Math.max(10, Math.min(event.clientX - 20, window.innerWidth - 300));
        let y = event.clientY + 15;
        if (y + 220 > window.innerHeight) y = Math.max(10, event.clientY - 200);
        popup.style.top = y + 'px';
        popup.style.left = x + 'px';

        const audioBtn = document.getElementById('vocab_popup_audio_btn');
        const posEl = document.getElementById('vocab_popup_pos');
        const synWrap = document.getElementById('vocab_popup_synonyms_wrap');

        document.getElementById('vocab_popup_word').textContent = word;
        audioBtn.style.display = 'none';
        posEl.style.display = 'none';
        synWrap.style.display = 'none';
        popup.style.display = 'block';

        const key = word.toLowerCase();
        const grammarClue = GRAMMAR_CLUE_WORDS[key];
        if (grammarClue) {
            document.getElementById('vocab_popup_translation').textContent = grammarClue.clue;
            posEl.textContent = grammarClue.label;
            posEl.style.display = 'inline-block';
            return;
        }

        document.getElementById('vocab_popup_translation').textContent = 'Memuat...';
        const isStale = () => document.getElementById('vocab_popup_word').textContent !== word;

        let entry = vocabTranslateCache.get(key);
        let baseFormDictData;
        if (!entry) {
            let translation = await translateIdToEn(word);

            if (translation && looksLikeIndonesianVerbForm(word)) {
                const normalized = await normalizeVerbTranslation(translation);
                translation = normalized.word;
                baseFormDictData = normalized.dictData;
            }

            entry = { translation, pos: null, synonyms: null };
            if (translation) vocabTranslateCache.set(key, entry);
        }

        if (isStale()) return;

        if (!entry.translation) {
            document.getElementById('vocab_popup_translation').textContent = 'Terjemahan tidak ditemukan';
            return;
        }

        document.getElementById('vocab_popup_translation').textContent = entry.translation;
        audioBtn.style.display = 'inline-flex';

        if (entry.pos === null) {
            const meta = await fetchEnglishMeta(entry.translation, baseFormDictData);
            entry.pos = meta.pos;
            entry.synonyms = meta.synonyms;
        }

        if (isStale()) return;

        if (entry.pos.length) {
            posEl.textContent = entry.pos.join(', ');
            posEl.style.display = 'inline-block';
        }
        if (entry.synonyms.length) {
            document.getElementById('vocab_popup_synonyms').textContent = entry.synonyms.join(', ');
            synWrap.style.display = 'block';
        }
    };

    document.addEventListener('click', function(e) {
        const popup = document.getElementById('vocabDefinitionPopup');
        if (popup && popup.style.display !== 'none' && !popup.contains(e.target) && !e.target.classList.contains('vocab-word')) {
            popup.style.display = 'none';
        }
    });
})();
</script>
