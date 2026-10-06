@extends('layouts.admin')

@section('title', ($meeting->title ?? 'Meeting ' . ($meeting->meeting_number ?? '')) . ' - IELTS Writing')

@push('styles')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Force cache refresh with timestamp -->
    <script>
        window.APP_VERSION = '{{ now()->timestamp }}';
    </script>
@endpush

@section('content')
@php
    $hasExistingSubmission = !empty($existingSubmission) && !empty($existingSubmission->scores);
    $existingOverallBand = $hasExistingSubmission ? ($existingSubmission->scores['overall_band'] ?? $existingSubmission->teacher_score ?? null) : null;
    $initialResultData = $hasExistingSubmission ? [
        'status' => 'success',
        'scores' => $existingSubmission->scores ?? [],
        'feedback' => $existingSubmission->scores['feedback'] ?? null,
        'correction_html' => $existingSubmission->scores['correction_html'] ?? null,
        'better_version' => $existingSubmission->scores['better_version'] ?? null,
        'lexical_improvements' => $existingSubmission->scores['lexical_improvements'] ?? null,
        'topic_vocabularies' => $existingSubmission->scores['topic_vocabularies'] ?? null,
        'grammar_improvements' => $existingSubmission->scores['grammar_improvements'] ?? null,
        'topic_grammar' => $existingSubmission->scores['topic_grammar'] ?? null,
        'task_response_improvements' => $existingSubmission->scores['task_response_improvements'] ?? null,
        'coherence_improvements' => $existingSubmission->scores['coherence_improvements'] ?? null,
    ] : [
        'status' => 'pending',
        'scores' => [
            'overall_band' => '-',
            'task_achievement' => '-',
            'coherence_cohesion' => '-',
            'lexical_resource' => '-',
            'grammatical_range' => '-'
        ],
        'feedback' => [
            'overall_comment' => '',
            'task_achievement' => '',
            'coherence_cohesion' => '',
            'lexical_resource' => '',
            'grammatical_range' => '',
            'coherence_improvements' => [],
            'grammar_improvements' => []
        ],
        'correction_html' => null,
        'better_version' => null,
        'lexical_improvements' => null,
        'topic_vocabularies' => null,
        'grammar_improvements' => null,
        'topic_grammar' => null,
        'task_response_improvements' => null,
        'coherence_improvements' => null
    ];
@endphp
<script>
    window.__ieltsWritingServerDraft = {{ Js::from($savedAnswers ?? []) }};
</script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ieltsWritingTask', (idioms = [], collocations = []) => ({
            isCollocationsOpen: false,
            isIdiomsOpen: false,
            idioms: idioms,
            collocations: collocations,
            time: {{ $task == 1 ? 1200 : 2400 }}, // Task 1 = 20m, Task 2 = 40m 
            interval: null,
            loading: false,
            improving: false,
            essay: @json($existingSubmission?->essay ?? ''),
            // Magic Sentence (inline-in-textarea, same UX as the promo test page)
            msOpen: false,
            msText: '',
            msLoading: false,
            msError: null,
            draftSyncTimer: null,
            error: null,
            lastSubmissionId: {{ $existingSubmission?->id ?? 'null' }},
            showResults: {{ $hasExistingSubmission ? 'true' : 'false' }},
            correctionFailed: false,
            feedbackFailed: false,
            improveFailed: false,
            vocabLoading: false,
            vocabError: null,
            grammarLoading: false,
            grammarError: null,
            showTopicGrammar: false,
            taskResponseLoading: false,
            taskResponseError: null,
            coherenceLoading: false,
            coherenceError: null,

            // INITIALIZE IMMEDIATELY
            result: {{ Js::from($initialResultData) }},
            
            get safeHtml() {
                const html = this.result?.correction_html;
                if (!html || html === 'undefined' || String(html).includes('undefined')) {
                    console.warn('⚠️ safeHtml: Using fallback essay');
                    return '<p class="text-gray-600">' + (this.essay || 'No content').replace(/\n/g, '<br>') + '</p>';
                }
                return html;
            },
            
            // Plan State
            plan: {
                intro: '',
                body1: '',
                body2: '',
                conclusion: '',
                extras: []
            },

            addParagraph() {
                this.plan.extras.push('');
            },

            previewEvaluasi() {
                // Admin preview: run the SAME live AI evaluation pipeline real students use
                // (evaluate -> feedback -> correct -> improve), instead of showing fake canned
                // scores. Uses a sample essay only if the admin hasn't written one.
                if (!this.essay || this.essay.trim().length < 50) {
                    this.essay = "The line graph illustrates website traffic over time from 2010 to 2020. Overall, traffic experienced a steady upward trend over the ten-year period, with notable peaks observed in the final quarter. The numbers rose sharply between 2012 and 2015 before stabilizing towards the end of the period.";
                }
                this.submitEssay();
            },

            removeParagraph(index) {
                this.plan.extras.splice(index, 1);
            },

            toggleMagicSentence() {
                this.msOpen = !this.msOpen;
                if (this.msOpen) {
                    this.msText = '';
                    if (this.$refs.msInput) {
                        this.$refs.msInput.innerText = '';
                    }
                    setTimeout(() => {
                        if (this.$refs.msInput) {
                            this.$refs.msInput.focus();
                            try {
                                let sel = window.getSelection();
                                let range = document.createRange();
                                range.selectNodeContents(this.$refs.msInput);
                                range.collapse(false);
                                sel.removeAllRanges();
                                sel.addRange(range);
                            } catch(e) {}
                        }
                    }, 50);
                }
            },

            async translateSentence() {
                if (!this.msText.trim()) return;
                this.msLoading = true;
                this.msError = null;
                try {
                    const response = await fetch('/api/ollama/translate-sentence', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content')
                        },
                        body: JSON.stringify({ text: this.msText.trim() })
                    });
                    if (!response.ok) throw new Error('Translation failed.');
                    const data = await response.json();
                    if (data.translation) {
                        const current = this.essay || '';
                        const prefix = current.length > 0 && !current.endsWith(' ') && !current.endsWith('\n') ? ' ' : '';
                        this.essay = current + prefix + data.translation;
                        this.msText = '';
                        this.msOpen = false;
                    } else {
                        this.msError = 'Unexpected response from AI.';
                    }
                } catch (e) {
                    this.msError = e.message;
                } finally {
                    this.msLoading = false;
                }
            },

            init() {
                @if(!$hasExistingSubmission)
                this.interval = setInterval(() => { 
                    if (this.time > 0) {
                        this.time--; 
                    } else {
                        clearInterval(this.interval);
                    }
                }, 1000);
                @endif
                
                // Load Plan from LocalStorage
                const planKey = 'ielts_plan_' + '{{ $meeting->id }}';
                const savedPlan = localStorage.getItem(planKey);
                let planRestoredLocally = false;
                if (savedPlan) {
                    try {
                         const parsed = JSON.parse(savedPlan);
                         this.plan = { ...this.plan, ...parsed };
                         if (!this.plan.extras) this.plan.extras = [];
                         planRestoredLocally = true;
                    } catch(e) { console.error('Error loading plan', e); }
                }

                // Watch Plan for Changes
                this.$watch('plan', (val) => {
                    localStorage.setItem(planKey, JSON.stringify(val));
                    this.queueDraftSync();
                });

                // Sync essay draft to server whenever it changes (debounced) -
                // this is separate from AutoSave.js's own localStorage-only
                // persistence below, and is what makes both cross-device
                // draft restore and the admin live-preview possible.
                this.$watch('essay', () => {
                    this.queueDraftSync();
                });

                setTimeout(() => {
                    if (!this.essay) {
                        const textarea = document.querySelector('textarea[name="essay"]');
                        if (textarea && textarea.value) {
                            if (textarea.value.trim() === 'undefined' || textarea.value.includes('undefined')) {
                                console.warn('Found "undefined" in saved essay. Purging corruption.');
                                textarea.value = ''; 
                                this.essay = '';     
                                if (window.AutoSave) {
                                    textarea.dispatchEvent(new Event('input', { bubbles: true }));
                                }
                            } else {
                                this.essay = textarea.value;
                            }
                        }
                    }

                    @if(!$hasExistingSubmission)
                    if (!this.essay || !planRestoredLocally) {
                        this.restoreFromServerAnswers(!this.essay, !planRestoredLocally);
                    }
                    @endif
                }, 500);

                this.$watch('result', (val) => {
                    if (val && val.correction_html === 'undefined') {
                        console.error('🔴 CAUGHT: correction_html is string "undefined"!');
                        this.result.correction_html = '<p>' + this.essay.replace(/\n/g, '<br>') + '</p>';
                    }
                });
                          // Initialize External AutoSave
                if (window.AutoSave) {
                    window.AutoSave.init('{{ $meeting->meeting_number }}', '{{ Auth::id() }}');
                }

                // ── Multi-Lifecycle Live Preview & Autosave Resilience ──
                window.addEventListener('online', () => {
                    console.log('[IELTS Writing] Network back online, flushing draft sync.');
                    this.syncDraftToServer();
                });
                window.addEventListener('focus', () => {
                    if (this.essay && this.essay.trim()) this.syncDraftToServer();
                });
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible' && this.essay && this.essay.trim()) {
                        this.syncDraftToServer();
                    }
                });
                window.addEventListener('pageshow', () => {
                    if (this.essay && this.essay.trim()) this.syncDraftToServer();
                });
                // 45s periodic background sync to keep admin live-preview fresh
                setInterval(() => {
                    if (this.essay && this.essay.trim()) {
                        this.syncDraftToServer();
                    }
                }, 45000);
            },

            updateAutosaveStatus(text, type = 'active') {
                const textEl = document.getElementById('autosave-status-text');
                const dotEl = document.getElementById('autosave-status-dot');
                if (textEl) textEl.textContent = text;
                if (dotEl) {
                    if (type === 'saving') {
                        dotEl.className = 'w-2 h-2 rounded-full bg-amber-500 animate-spin';
                    } else if (type === 'saved') {
                        dotEl.className = 'w-2 h-2 rounded-full bg-emerald-500';
                    } else {
                        dotEl.className = 'w-2 h-2 rounded-full bg-emerald-500 animate-pulse';
                    }
                }
            },

            confirmResetPractice() {
                if (confirm('Apakah Anda yakin ingin mengerjakan ulang latihan ini? Hasil evaluasi dan draft sebelumnya akan direset.')) {
                    const planKey = 'ielts_plan_' + '{{ $meeting->id }}';
                    localStorage.removeItem(planKey);
                    localStorage.removeItem('ielts_writing_practice_{{ $meeting->id }}');
                    if (window.AutoSave && typeof window.AutoSave.clearSaved === 'function') {
                        try { window.AutoSave.clearSaved(); } catch (e) {}
                    }
                    window.location.href = window.location.pathname + '?retry=1';
                }
            },

            // Rebuilds essay/plan from the flat "essay"/"plan_body1"/
            // "plan_extra_{index}" shape saveMeetingDraft() stores server-
            // side (see buildDraftPayload() below - the exact inverse of
            // this). Only restores whichever of essay/plan this browser's
            // localStorage didn't already have (via AutoSave.js or the
            // plan watcher above), so a student switching devices - or a
            // page that was completely unrecoverable before name="essay"
            // was added to the textarea - doesn't lose a draft that was
            // persisted to the DB.
            restoreFromServerAnswers(restoreEssay, restorePlan) {
                const flat = window.__ieltsWritingServerDraft || {};
                if (!flat || typeof flat !== 'object' || Object.keys(flat).length === 0) {
                    return;
                }

                if (restoreEssay && flat.essay !== undefined) {
                    this.essay = flat.essay;
                }

                if (restorePlan) {
                    if (flat.plan_body1 !== undefined) this.plan.body1 = flat.plan_body1;
                    if (flat.plan_body2 !== undefined) this.plan.body2 = flat.plan_body2;

                    const extras = Object.keys(flat)
                        .filter((k) => /^plan_extra_\d+$/.test(k))
                        .map((k) => ({ index: parseInt(k.replace('plan_extra_', ''), 10), value: flat[k] }))
                        .sort((a, b) => a.index - b.index)
                        .map((item) => item.value);
                    if (extras.length > 0) {
                        this.plan.extras = extras;
                    }
                }

                this.updateAutosaveStatus('Draft dipulihkan', 'saved');
            },

            // Inverse of restoreFromServerAnswers() - flattens essay/plan
            // into the same "essay"/"plan_body1"/"plan_extra_{index}" names
            // the fields themselves carry (see their name/:name attributes
            // above), so the admin live-preview's flatten()-and-match-by-
            // name injection works with no server-side reshaping needed.
            buildDraftPayload() {
                const payload = {
                    essay: this.essay,
                    plan_body1: this.plan.body1,
                    plan_body2: this.plan.body2,
                };
                (this.plan.extras || []).forEach((value, index) => {
                    payload['plan_extra_' + index] = value;
                });
                return payload;
            },

            queueDraftSync() {
                @if(!$hasExistingSubmission)
                this.updateAutosaveStatus('Menyimpan...', 'saving');
                clearTimeout(this.draftSyncTimer);
                this.draftSyncTimer = setTimeout(() => this.syncDraftToServer(), 800);
                @endif
            },

            async syncDraftToServer() {
                try {
                    let csrfToken = document.querySelector('meta[name=csrf-token]')?.content || '';
                    let response = await fetch('/assignments/ielts-academic/writing/meeting/{{ $meeting->id }}/draft', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ userAnswers: this.buildDraftPayload() }),
                        keepalive: true,
                    });

                    // Auto-recover from CSRF 419 token expiration
                    if (response.status === 419) {
                        try {
                            const tokenRes = await fetch('/csrf-token');
                            if (tokenRes.ok) {
                                const data = await tokenRes.json();
                                if (data.token) {
                                    const metaTag = document.querySelector('meta[name=csrf-token]');
                                    if (metaTag) metaTag.content = data.token;
                                    csrfToken = data.token;
                                    response = await fetch('/assignments/ielts-academic/writing/meeting/{{ $meeting->id }}/draft', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken,
                                            'X-Requested-With': 'XMLHttpRequest',
                                        },
                                        body: JSON.stringify({ userAnswers: this.buildDraftPayload() }),
                                        keepalive: true,
                                    });
                                }
                            }
                        } catch (reErr) {
                            console.error('CSRF token refresh failed:', reErr);
                        }
                    }

                    if (response.ok) {
                        const now = new Date();
                        const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0') + ':' + String(now.getSeconds()).padStart(2, '0');
                        this.updateAutosaveStatus('✓ Tersimpan (' + timeStr + ')', 'saved');
                    }

                    return response.ok;
                } catch (e) {
                    console.error('Failed to sync draft to server:', e);
                    return false;
                }
            },

            /**
             * Manual "Save" button handler - forces an immediate server
             * sync (bypassing the 800ms debounce) and gives explicit
             * visual confirmation once the server has actually persisted
             * the essay/plan, rather than relying purely on the silent
             * background debounce.
             */
            async manualSaveDraft() {
                const btn = document.getElementById('manual-save-btn');
                if (btn) {
                    btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = 'Menyimpan...';
                }

                clearTimeout(this.draftSyncTimer);
                const ok = await this.syncDraftToServer();

                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = btn.dataset.originalText;
                }

                const indicator = document.createElement('div');
                indicator.style.cssText = 'position: fixed; bottom: 72px; right: 24px; z-index: 50; transition: opacity 0.3s;';
                if (ok) {
                    indicator.className = 'bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg text-sm font-medium';
                    indicator.innerHTML = '✓ Tersimpan';
                } else {
                    indicator.className = 'bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg text-sm font-medium';
                    indicator.innerHTML = '✗ Gagal menyimpan, coba lagi';
                }
                document.body.appendChild(indicator);
                setTimeout(() => {
                    indicator.style.opacity = '0';
                    setTimeout(() => indicator.remove(), 300);
                }, 3000);
            },
            
            statusMessage: '',

            scrollToAnalysis() {
                let attempts = 0;
                const doScroll = () => {
                    attempts++;
                    const leftPanel = document.getElementById('left-panel');
                    const analysisCard = document.getElementById('detailed-text-analysis');
                    
                    if (!leftPanel || !analysisCard) return;

                    const isVisible = analysisCard.offsetHeight > 0 || analysisCard.getClientRects().length > 0;
                    if (!isVisible && attempts < 15) {
                        setTimeout(doScroll, 50);
                        return;
                    }

                    const leftPanelRect = leftPanel.getBoundingClientRect();
                    const cardRect = analysisCard.getBoundingClientRect();
                    
                    let targetScrollTop = 0;
                    if (cardRect.top > 0) {
                        targetScrollTop = leftPanel.scrollTop + (cardRect.top - leftPanelRect.top) - 16;
                    } else if (analysisCard.offsetTop > 0) {
                        targetScrollTop = analysisCard.offsetTop - 16;
                    }

                    if (targetScrollTop > 0) {
                        leftPanel.scrollTo({
                            top: targetScrollTop,
                            behavior: 'smooth'
                        });
                    }
                };

                this.$nextTick(() => {
                    setTimeout(doScroll, 50);
                });
            },

            async submitEssay() {
                if (this.essay.trim().length < 50) {
                    alert('Please write at least 50 characters.');
                    return;
                }
                
                this.loading = true;
                this.error = null;
                this.showResults = true;
                this.result.correction_html = null;
                this.statusMessage = 'Evaluating Scores...';
                
                this.scrollToAnalysis();
                
                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.evaluate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });
                    
                    if (!response.ok) throw new Error('Evaluation failed. Server returned ' + response.status);
                    
                    let data = await response.json();
                    data = this.sanitizeRecursive(data);
                    if (data.submission_id) this.lastSubmissionId = data.submission_id;
                    
                    if (data.redirect_url) {
                        if (data.message) alert(data.message);
                        window.location.href = data.redirect_url;
                        return;
                    }
                    
                    if (data.scores) {
                         this.result.scores = { ...this.result.scores, ...data.scores };
                    }
                    
                    this.showResults = true;
                    
                    await Promise.all([
                        this.getFeedback(),
                        this.getCorrection(),
                        this.improveEssay()
                    ]);
                    
                    if (this.lastSubmissionId) {
                        this.persistFullFeedback();
                    }
                    
                } catch (e) {
                    console.error(e);
                    this.error = e.message;
                } finally {
                    this.statusMessage = '';
                    this.loading = false;
                }
            },

            async persistFullFeedback() {
                if (!this.lastSubmissionId) return;
                try {
                    await fetch(`/assignments/ielts-academic/writing/submission/${this.lastSubmissionId}/save-feedback`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({
                            scores: this.result.scores,
                            feedback: this.result.feedback,
                            correction_html: this.result.correction_html,
                            better_version: this.result.better_version
                        })
                    });
                } catch (e) {
                    console.warn('Persist feedback error:', e);
                }
            },

            refreshEssay() {
                if (!confirm('Reset semua teks essay?')) {
                    return;
                }

                this.essay = '';
                this.error = null;
                this.statusMessage = '';
                this.showResults = false;

                const textarea = document.querySelector('textarea[x-model="essay"]');
                if (textarea) {
                    textarea.value = '';
                    textarea.dispatchEvent(new Event('input', { bubbles: true }));
                }

                if (window.AutoSave && typeof window.AutoSave.clearSaved === 'function') {
                    try {
                        // Clear only the saved data for THIS meeting (storageKey set during init)
                        window.AutoSave.clearSaved();
                    } catch (e) {
                        console.warn('AutoSave clearSaved failed', e);
                    }
                }
            },

            async getFeedback() {
                this.statusMessage = 'Generating Detailed Feedback...';
                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.feedback') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        if (data.feedback) {
                            this.result.feedback = { ...this.result.feedback, ...data.feedback };
                            this.feedbackFailed = false;
                        } else {
                            this.feedbackFailed = true;
                        }
                    } else {
                        this.feedbackFailed = true;
                    }
                } catch (e) {
                    console.error('Feedback stage failed:', e);
                    this.feedbackFailed = true;
                }
            },

            getBulletPoints(text) {
                if (!text || typeof text !== 'string') return null;
                const parts = text.split(/(?:^|\s)-\s+/).map(p => p.trim()).filter(p => p.length > 0);
                return parts.length > 1 ? parts : null;
            },

            async fetchWithTimeout(url, options = {}, timeoutMs = 70000) {
                const controller = new AbortController();
                const timer = setTimeout(() => controller.abort(), timeoutMs);
                try {
                    return await fetch(url, { ...options, signal: controller.signal });
                } catch (e) {
                    if (e.name === 'AbortError') {
                        throw new Error('Request timed out. The server took too long to respond.');
                    }
                    throw e;
                } finally {
                    clearTimeout(timer);
                }
            },

            sanitizeRecursive(data) {
                if (typeof data === 'string') {
                    if (data.trim() === 'undefined' || data.includes('undefined')) return '';
                    return data;
                }
                if (Array.isArray(data)) {
                    return data.map(item => this.sanitizeRecursive(item));
                }
                if (data && typeof data === 'object') {
                    Object.keys(data).forEach(key => {
                        data[key] = this.sanitizeRecursive(data[key]);
                    });
                    return data;
                }
                return data;
            },

            async getCorrection() {
                this.statusMessage = 'Analyzing Text for Corrections...';
                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.correct') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);

                        let finalHtml = null;
                        if (data.correction_html && data.correction_html.length > 20) {
                            finalHtml = data.correction_html;
                            this.correctionFailed = false;
                        } else {
                            finalHtml = '<p>' + this.essay.replace(/\n/g, '<br>') + '</p>';
                            this.correctionFailed = true;
                        }

                        this.result = {
                            ...this.result,
                            ...data,
                            correction_html: finalHtml
                        };
                        this.scrollToAnalysis();
                    } else {
                        this.correctionFailed = true;
                        this.result = {
                            ...this.result,
                            correction_html: '<p>' + this.essay.replace(/\n/g, '<br>') + '</p>'
                        };
                    }
                } catch (e) {
                    console.error('Correction stage failed:', e);
                    this.correctionFailed = true;
                     this.result = {
                         ...this.result,
                         correction_html: '<p>' + this.essay.replace(/\n/g, '<br>') + '</p>'
                     };
                }
            },

            async improveEssay() {
                this.statusMessage = 'Creating Better Version...';
                this.improving = true;
                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.improve') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);

                        if (data.better_version) {
                            this.result.better_version = data.better_version;
                            this.improveFailed = false;
                        } else {
                            this.improveFailed = true;
                        }
                    } else {
                        this.improveFailed = true;
                    }
                } catch (e) {
                    console.error('Improvement stage failed:', e);
                    this.improveFailed = true;
                } finally {
                    this.improving = false;
                }
            },

            async getVocabulary() {
                this.vocabLoading = true;
                this.vocabError = null;

                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.vocabulary') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        if (data.lexical_improvements || data.topic_vocabularies) {
                            this.result = {
                                ...this.result,
                                lexical_improvements: data.lexical_improvements || this.result?.lexical_improvements,
                                topic_vocabularies: data.topic_vocabularies || this.result?.topic_vocabularies
                            };
                        } else {
                            throw new Error('Vocabulary analysis failed');
                        }
                    } else {
                        throw new Error('Vocabulary analysis failed');
                    }
                } catch (e) {
                    console.error(e);
                    this.vocabError = 'Failed to analyze vocabulary. Please try again.';
                } finally {
                    this.vocabLoading = false;
                }
            },

            async getGrammar() {
                this.grammarLoading = true;
                this.grammarError = null;

                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.grammar') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        if (data.grammar_improvements || data.topic_grammar) {
                            this.result = {
                                ...this.result,
                                grammar_improvements: data.grammar_improvements || this.result?.grammar_improvements,
                                topic_grammar: data.topic_grammar || this.result?.topic_grammar
                            };
                        } else {
                            throw new Error('Grammar analysis failed');
                        }
                    } else {
                        throw new Error('Grammar analysis failed');
                    }
                } catch (e) {
                    console.error(e);
                    this.grammarError = 'Failed to analyze grammar. Please try again.';
                } finally {
                    this.grammarLoading = false;
                }
            },

            async getTaskResponse() {
                this.taskResponseLoading = true;
                this.taskResponseError = null;

                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.task_response') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        if (data.task_response_improvements) {
                            this.result = {
                                ...this.result,
                                task_response_improvements: data.task_response_improvements
                            };
                        } else {
                            throw new Error('Task Response analysis failed');
                        }
                    } else {
                        throw new Error('Task Response analysis failed');
                    }
                } catch (e) {
                    console.error(e);
                    this.taskResponseError = 'Failed to analyze task response. Please try again.';
                } finally {
                    this.taskResponseLoading = false;
                }
            },

            async getCoherence() {
                this.coherenceLoading = true;
                this.coherenceError = null;

                try {
                    const response = await this.fetchWithTimeout('{{ route('assignments.ielts.writing.coherence') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        if (data.coherence_improvements) {
                            this.result = {
                                ...this.result,
                                coherence_improvements: data.coherence_improvements
                            };
                        } else {
                            throw new Error('Coherence analysis failed');
                        }
                    } else {
                        throw new Error('Coherence analysis failed');
                    }
                } catch (e) {
                    console.error(e);
                    this.coherenceError = 'Failed to analyze coherence. Please try again.';
                } finally {
                    this.coherenceLoading = false;
                }
            }
        }));
    });
</script>

<div class="flex flex-col h-screen overflow-hidden bg-gradient-to-br from-blue-50 via-white to-purple-50" 
     x-data="ieltsWritingTask({{ json_encode($meeting->idioms ?? []) }}, {{ json_encode($meeting->collocations ?? []) }})"
     @toggle-collocations.window="isCollocationsOpen = !isCollocationsOpen; if(isCollocationsOpen) isIdiomsOpen = false"
     @toggle-idioms.window="isIdiomsOpen = !isIdiomsOpen; if(isIdiomsOpen) isCollocationsOpen = false"
>
    {{-- Fixed bottom-right Save button so it does not overlap the bottom-center practice_toolbar --}}
    <div x-show="!showResults" class="fixed bottom-4 right-4 z-50" style="position: fixed; bottom: 20px; right: 24px; z-index: 50;">
        <button type="button" id="manual-save-btn" @click="manualSaveDraft()"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path></svg>
            Save
        </button>
    </div>

    <!-- WRITING MODE HEADER -->
    <div x-show="!showResults" class="flex items-center justify-between mb-6 px-4 pt-4 md:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <a href="{{ $backUrl ?? route('assignments.ielts-academic.writing.practice.index') }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-{{ $task == 1 ? 'teal' : 'orange' }}-600 tracking-wider uppercase">IELTS Writing Task {{ $task }}</span>
                <h1 class="text-2xl font-bold text-gray-800">Lesson {{ $meeting->meeting_number }}</h1>
            </div>
        </div>
        
          <div class="flex gap-3 items-center">
              @if(!$hasExistingSubmission)
                  <div id="autosave-status" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                      <span id="autosave-status-dot" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                      <span id="autosave-status-text">Autosave Aktif</span>
                  </div>
              @else
                  <div class="flex items-center gap-2">
                      <div class="student-score-badge flex items-center gap-1.5 px-3 py-1 bg-emerald-600 text-white rounded-full text-xs font-bold uppercase tracking-wide border border-emerald-400 shadow-sm">
                          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                          <span>Band {{ is_numeric($existingOverallBand) ? number_format((float)$existingOverallBand, 1) : $existingOverallBand }}</span>
                      </div>
                      <button type="button" @click="confirmResetPractice()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                          <span>Kerjakan Ulang</span>
                      </button>
                      <button type="button" @click="showResults = true" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                          <span>Lihat Hasil Evaluasi →</span>
                      </button>
                  </div>
              @endif
              @if(Auth::check() && Auth::user()->isAdmin())
                  <button type="button" @click="previewEvaluasi()" :disabled="loading" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-lg shadow-sm transition-colors flex items-center gap-2" title="Khusus Admin: Preview Hasil Evaluasi AI (menggunakan sistem evaluasi yang sama dengan submission asli)">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                      <span>Preview Evaluasi</span>
                  </button>
              @endif
              <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-mono font-medium">
                  <span x-text="new Date(time * 1000).toISOString().substr(11, 8)">00:00:00</span>
              </div>
              <button @click="refreshEssay()" type="button" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                  Reset Essay
              </button>
              <button @click="submitEssay()" :disabled="loading" class="px-6 py-2 bg-{{ $task == 1 ? 'teal' : 'orange' }}-600 text-white font-bold rounded-lg shadow-md hover:bg-{{ $task == 1 ? 'teal' : 'orange' }}-700 transition-colors flex items-center gap-2">
                  <span x-show="!loading">Submit Answer</span>
                  <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                  <span x-show="loading" x-text="statusMessage || 'Evaluating...'"></span>
              </button>
          </div>
    </div>

    <!-- Error Alert -->
    <div x-show="error" class="mx-4 md:mx-6 lg:mx-8 mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-700" style="display: none;">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <span class="font-bold">Evaluation Failed:</span>
            <span x-text="error"></span>
            <p class="text-sm mt-2 text-red-600">💡 <strong>Coba ulang jika gagal memuat</strong></p>
            <button type="button" @click="submitEssay()" class="mt-2 text-sm font-semibold text-red-700 hover:text-red-800 bg-white border border-red-200 px-3 py-1.5 rounded-lg">Try again</button>
        </div>
        <button @click="error = null" class="ml-auto text-red-400 hover:text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- WRITING MODE CONTENT -->
    <div x-show="!showResults" 
         class="flex flex-col lg:flex-row flex-1 min-h-0 gap-0 lg:gap-0 overflow-hidden px-4 md:px-6 lg:px-8 pb-4" 
         x-data="{
             splitLeftWidth: 40,
             isResizing: false,
             startX: 0,
             startWidth: 40,
             resizeMoveHandler: null,
             resizeUpHandler: null,
             splitStorageKey: 'ielts-writing-meeting-split-v2-{{ $meeting->id ?? 0 }}',
             panelStyle(side) {
                 if (window.innerWidth < 1024) return '';
                 const left = this.splitLeftWidth;
                 return side === 'left' ? `width: ${left}%;` : `width: ${100 - left}%;`;
             },
             startResize(event) {
                 if (window.innerWidth < 1024) return;
                 this.isResizing = true;
                 this.startX = event.clientX;
                 this.startWidth = this.splitLeftWidth;
                 if (!this.resizeMoveHandler) this.resizeMoveHandler = (e) => this.onResize(e);
                 if (!this.resizeUpHandler) this.resizeUpHandler = () => this.stopResize();
                 document.addEventListener('mousemove', this.resizeMoveHandler);
                 document.addEventListener('mouseup', this.resizeUpHandler);
             },
             onResize(event) {
                 if (!this.isResizing) return;
                 const containerWidth = this.$el.clientWidth;
                 if (!containerWidth) return;
                 const deltaPercent = ((event.clientX - this.startX) / containerWidth) * 100;
                 this.splitLeftWidth = Math.max(30, Math.min(70, this.startWidth + deltaPercent));
             },
             stopResize() {
                 this.isResizing = false;
                 if (this.resizeMoveHandler) document.removeEventListener('mousemove', this.resizeMoveHandler);
                 if (this.resizeUpHandler) document.removeEventListener('mouseup', this.resizeUpHandler);
                 try { localStorage.setItem(this.splitStorageKey, String(this.splitLeftWidth)); } catch(e) {}
             },
             init() {
                 try {
                     const stored = parseFloat(localStorage.getItem(this.splitStorageKey) || '');
                     if (!isNaN(stored)) this.splitLeftWidth = Math.max(30, Math.min(70, stored));
                 } catch(e) {}
             }
         }">
        <!-- Left Column: Question / Prompt + RESULTS -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col min-h-0 min-w-0 lg:h-full overflow-hidden" :style="panelStyle('left')">
            <div class="p-6 pb-24 lg:pb-28 overflow-y-auto flex-1 prose max-w-none scroll-pb-24 lg:scroll-pb-28">
                @if($task == 1)
                    <div class="not-prose space-y-5">
                        <section class="rounded-2xl border border-slate-200 bg-gradient-to-b from-slate-50 to-white p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-600 mb-2">Prompt Overview</p>
                                    <h3 class="text-xl font-bold text-slate-900">The chart below shows...</h3>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700">Task 1 Reference</span>
                            </div>

                            <div class="w-full h-auto min-h-[300px] rounded-2xl border border-slate-200 bg-white flex flex-col items-center justify-center relative overflow-hidden transition-all duration-300">
                                <canvas id="meetingChart" class="w-full !h-80"></canvas>
                            </div>
                        </section>

                        <section class="rounded-2xl border border-indigo-100 bg-indigo-50/65 p-5 shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-indigo-600 mb-3">What You Need To Do</p>
                            <p class="text-base leading-8 text-slate-700">Summarize the information by selecting and reporting the main features, and make comparisons where relevant.</p>
                        </section>
                    </div>
                @else
                    <!-- Textbook Style IELTS Writing Task 2 (Cambridge IELTS Style) -->
                    @php
                        $promptText = trim(trim($meeting->prompt ?? 'Discuss the advantages and disadvantages...'), '"\'');
                    @endphp

                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200 mb-6 font-sans">
                        <!-- WRITING Header Badge -->
                        <div class="flex justify-center mb-6">
                            <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest shadow-xs">WRITING</span>
                        </div>

                        <div class="space-y-4 text-gray-900 text-[15px] leading-relaxed">
                            <h2 class="font-bold text-base tracking-wide uppercase text-gray-900 mb-1">WRITING TASK 2</h2>
                            <p class="text-gray-700 text-sm">You should spend about 40 minutes on this task.</p>
                            <p class="text-gray-900 text-sm">Write about the following topic:</p>

                            <!-- Textbook Question Box with 2px Black Border -->
                            <div class="border-2 border-gray-900 p-6 bg-white my-6 font-semibold italic text-gray-900 leading-relaxed shadow-2xs">
                                {!! $promptText !!}
                            </div>

                            <!-- Standard Instructions Below Box -->
                            <div class="space-y-2 text-gray-800 text-sm font-normal pt-2">
                                <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                                <p>Write at least 250 words.</p>
                            </div>
                        </div>
                    </div>
                @endif


                @if($task != 1)
                <!-- Essay Structure Plan (Interactive) -->
                <div x-data="{ 
                    isFloating: false,
                    x: 20,
                    y: window.innerHeight - 500,
                    width: 400,
                    height: 500,
                    dragging: false,
                    resizing: false,
                    offset: { x: 0, y: 0 },
                    
                    startDrag(e) {
                        if (!this.isFloating) return;
                        this.dragging = true;
                        this.offset.x = e.clientX - this.x;
                        this.offset.y = e.clientY - this.y;
                        
                        const onMouseMove = (e) => {
                            if (!this.dragging) return;
                            this.x = e.clientX - this.offset.x;
                            this.y = e.clientY - this.offset.y;
                            
                            // Simple bounds checking
                            if (this.y < 0) this.y = 0;
                            if (this.y > window.innerHeight - 50) this.y = window.innerHeight - 50;
                            if (this.x < 0) this.x = 0;
                            if (this.x > window.innerWidth - 50) this.x = window.innerWidth - 50;
                        };
                        
                        const onMouseUp = () => {
                            this.dragging = false;
                            window.removeEventListener('mousemove', onMouseMove);
                            window.removeEventListener('mouseup', onMouseUp);
                        };
                        
                        window.addEventListener('mousemove', onMouseMove);
                        window.addEventListener('mouseup', onMouseUp);
                    },

                    startResize(e) {
                        this.resizing = true;
                        const startX = e.clientX;
                        const startY = e.clientY;
                        const startWidth = this.width;
                        const startHeight = this.height;

                        const onMouseMove = (e) => {
                            if (!this.resizing) return;
                            const newWidth = startWidth + (e.clientX - startX);
                            const newHeight = startHeight + (e.clientY - startY);
                            
                            this.width = Math.max(300, newWidth); // Min width 300
                            this.height = Math.max(200, newHeight); // Min height 200
                        };

                        const onMouseUp = () => {
                            this.resizing = false;
                            window.removeEventListener('mousemove', onMouseMove);
                            window.removeEventListener('mouseup', onMouseUp);
                        };

                        window.addEventListener('mousemove', onMouseMove);
                        window.addEventListener('mouseup', onMouseUp);
                    }
                }" 
                :style="isFloating ? `position: fixed; left: ${x}px; top: ${y}px; width: ${width}px; height: ${height}px; margin: 0; z-index: 50;` : ''"
                :class="isFloating ? 'bg-white shadow-2xl rounded-xl border-2 border-orange-500 flex flex-col' : 'mt-8 space-y-4'">
                    
                    <!-- Floating Header -->
                    <div x-show="isFloating" 
                         @mousedown="startDrag($event)"
                         class="p-3 border-b border-gray-100 flex justify-between items-center bg-orange-50 rounded-t-xl cursor-move select-none">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                            <h4 class="font-bold text-orange-800 text-sm">Layout Plan</h4>
                        </div>
                        <button @click="isFloating = false" class="text-gray-400 hover:text-red-500 p-1 hover:bg-orange-100 rounded">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Toggle Button (Docked) -->
                    <button x-show="!isFloating" @click="isFloating = true; x = 20; y = window.innerHeight - 600;" class="w-full py-2 mb-2 bg-orange-50 text-orange-600 rounded-lg border border-orange-100 hover:bg-orange-100 flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        <span class="font-bold text-sm">Float / Undock Plan</span>
                    </button>

                    <!-- Content -->
                    <div :class="isFloating ? 'p-4 overflow-y-auto custom-scrollbar flex-1 bg-white relative' : 'space-y-4'">
                        <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                            <h4 class="font-bold text-orange-800 mb-2">Body Paragraph 1</h4>
                             <textarea name="plan_body1" x-model="plan.body1"
                                       x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                       @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                       class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none"
                                       placeholder="• Topic Sentence (Main Idea 1)&#10;• Explain/Expand&#10;• Example"></textarea>
                        </div>

                        <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                            <h4 class="font-bold text-orange-800 mb-2">Body Paragraph 2</h4>
                             <textarea name="plan_body2" x-model="plan.body2"
                                       x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                       @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                       class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none"
                                       placeholder="• Topic Sentence (Main Idea 2)&#10;• Explain/Expand&#10;• Example"></textarea>
                        </div>

                        <template x-for="(extra, index) in plan.extras" :key="index">
                            <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl relative group mt-4">
                                <h4 class="font-bold text-orange-800 mb-2" x-text="'Body Paragraph ' + (index + 3)"></h4>
                                <button @click="removeParagraph(index)" class="absolute top-2 right-2 text-orange-300 hover:text-orange-600 p-1 bg-orange-50 rounded-full" title="Remove Paragraph">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                 <textarea :name="'plan_extra_' + index" x-model="plan.extras[index]"
                                           x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                           @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                           class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none"
                                           placeholder="• Topic Sentence&#10;• Explain/Expand&#10;• Example"></textarea>
                            </div>
                        </template>

                        <button @click="addParagraph()" class="w-full py-2 mt-4 border-2 border-dashed border-orange-200 rounded-xl text-orange-400 font-bold hover:bg-orange-50 hover:border-orange-300 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Paragraph
                        </button>

                         <!-- Resize Handle -->
                        <div x-show="isFloating"
                             @mousedown.prevent.stop="startResize($event)"
                             class="absolute bottom-0 right-0 w-6 h-6 cursor-nwse-resize flex items-end justify-end p-1 z-50"
                             style="display: none;">
                            <svg class="w-4 h-4 text-orange-300" fill="currentColor" viewBox="0 0 24 24"><path d="M22 22H20V20H22V22ZM22 18H20V16H22V18ZM18 22H16V20H18V22ZM22 14H20V12H22V14ZM14 22H12V20H14V22ZM18 18H16V16H18V18Z"></path></svg>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- DIVIDER -->
        <div
            class="hidden lg:flex w-4 items-stretch justify-center cursor-col-resize select-none flex-shrink-0"
            @mousedown.prevent="startResize($event)">
            <div class="w-1 rounded-full bg-gray-300 hover:bg-blue-400 transition-colors"></div>
        </div>

        <!-- Right Column: Writing Area -->
        <div id="writing-panel" class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col min-h-0 min-w-0 lg:h-full overflow-hidden" :style="panelStyle('right')">
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-gray-700">Your Response</h2>
                    <p class="text-xs text-indigo-500 font-medium mt-0.5">Write at least {{ $task == 2 ? '250' : '150' }} words.</p>
                </div>
                <span
                    class="text-xs font-semibold text-gray-400"
                    x-data="{
                        count: 0,
                        countWords(text) {
                            const tokens = String(text || '').trim().split(/\s+/).filter(Boolean);

                            // Count only tokens containing letters; pure numbers/punctuation are excluded.
                            return tokens.filter(token => /[A-Za-z]/.test(token)).length;
                        }
                    }"
                    x-init="count = countWords(essay || ''); $watch('essay', value => count = countWords(value))"
                >Word Count: <span x-text="count">0</span></span>
            </div>
            <div class="flex-1 min-h-0 relative">
                <textarea name="essay" x-model="essay" x-show="!msOpen" class="absolute inset-0 w-full h-full p-6 resize-none overflow-y-auto focus:outline-none focus:bg-blue-50/30 transition-colors font-serif leading-relaxed text-gray-800 text-lg" placeholder="Start typing your answer here..."></textarea>

                {{-- Magic Sentence inline overlay: mirrors the essay text as a static
                     span immediately followed by a contenteditable span, so the
                     Indonesian sentence appears to be typed right where the cursor
                     was in the essay - same UX as the promo test page - instead of
                     a separate popup dialog. --}}
                <div x-show="msOpen" x-cloak class="absolute inset-0 w-full h-full z-10 bg-white">
                    <div class="absolute bottom-4 inset-x-0 flex justify-center pointer-events-none z-20">
                        <div class="bg-gray-900 bg-opacity-90 text-white px-4 py-2 rounded-full shadow-lg text-[11px] sm:text-xs flex items-center gap-2 backdrop-blur-sm">
                            <span class="text-white"><strong>Magic Sentence:</strong> Ketik B. Indonesia →
                                tekan <kbd class="bg-gray-700 text-white rounded px-1 font-mono">Ctrl+Enter</kbd> /
                                <kbd class="bg-gray-700 text-white rounded px-1 font-mono">Cmd+Return</kbd>
                                untuk translate ke gaya IELTS, atau <kbd class="bg-gray-700 text-white rounded px-1 font-mono">Esc</kbd> untuk keluar.</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 w-full h-full p-6 font-serif leading-relaxed text-gray-800 text-lg overflow-y-auto whitespace-pre-wrap break-words cursor-text"
                        @click="if($refs.msInput) {
                            $refs.msInput.focus();
                            try {
                                let sel = window.getSelection();
                                let range = document.createRange();
                                range.selectNodeContents($refs.msInput);
                                range.collapse(false);
                                sel.removeAllRanges();
                                sel.addRange(range);
                            } catch(e) {}
                        }"><span x-text="essay"></span><span x-ref="msInput" contenteditable="true" inputmode="text"
                            class="outline-none border-b-2 border-dashed border-blue-400 bg-blue-50 text-blue-900 empty:before:content-[attr(data-placeholder)] empty:before:text-blue-300 cursor-text inline"
                            data-placeholder="Ketik kalimat di sini..."
                            @keydown.enter.ctrl.prevent="msText = $el.innerText; translateSentence()"
                            @keydown.enter.meta.prevent="msText = $el.innerText; translateSentence()"
                            @keydown.escape.prevent="msOpen = false; msText = ''"
                            @input="msText = $el.innerText"></span><button
                            type="button" x-show="msText.trim().length > 0 && !msLoading"
                            @click.stop="if($refs.msInput) { msText = $refs.msInput.innerText; translateSentence(); }"
                            class="inline-flex items-center justify-center w-4 h-4 ml-0.5 bg-blue-500 hover:bg-blue-600 text-white rounded shadow-sm transition-transform hover:scale-110 focus:outline-none align-baseline"
                            title="Translate (Ctrl+Enter / Cmd+Enter)">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button><span x-show="msLoading" class="inline-flex items-center ml-1 text-blue-500 align-baseline">
                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                <!-- Refresh button removed per UX update -->
            </div>
        </div>
    </div>

    <!-- RESULT MODE (FULL PAGE) -->
    <div x-show="showResults" class="flex flex-col flex-1 min-h-0 overflow-hidden px-4 md:px-6 lg:px-8 pt-4" style="display: none;">
        <!-- Result Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <button @click="showResults = false" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </button>
                <div>
                    <h2 class="text-2xl font-bold text-red-600">Your Evaluation Results</h2>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-gray-500 text-sm">Overall Band Score:</span>
                        <span class="px-3 py-0.5 bg-red-100 text-red-700 font-bold rounded-full text-lg" x-text="result?.scores?.overall_band"></span>
                        <template x-if="lastSubmissionId">
                            <a :href="'/assignments/ielts-academic/writing/submission/' + lastSubmissionId" class="ml-2 inline-flex items-center gap-1 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors" target="_blank">
                                <span>Halaman Hasil Pengerjaan Lengkap ↗</span>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Score Summary Cards & Retry -->
            <div class="flex items-center gap-4">
                <button type="button" @click="confirmResetPractice()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Kerjakan Ulang ↺</span>
                </button>

                <div v-if="result" class="flex gap-3">
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Task</span>
                    <span class="text-xl font-bold text-red-700" x-text="result?.scores?.task_achievement"></span>
                </div>
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Coherence</span>
                    <span class="text-xl font-bold text-red-700" x-text="result?.scores?.coherence_cohesion"></span>
                </div>
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Lexical</span>
                    <span class="text-xl font-bold text-red-700" x-text="result?.scores?.lexical_resource"></span>
                </div>
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Grammar</span>
                    <span class="text-xl font-bold text-red-700" x-text="result?.scores?.grammatical_range"></span>
                </div>
                </div>
            </div>
        </div>

        <style>
            .detailed-analysis .grammar-correction { display: none; }

            /* Highlight struck-through / error tokens to make them visible in the essay */
            .detailed-analysis s,
            .detailed-analysis del,
            .detailed-analysis .line-through,
            .detailed-analysis .text-red-600,
            .detailed-analysis .bg-red-100 {
                background: rgba(254, 202, 202, 0.3);
                padding: 0.12rem 0.25rem;
                border-radius: 6px;
                color: inherit;
                margin: 0 0.05rem;
                text-decoration: line-through;
            }
        </style>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 flex-1 min-h-0">
            <!-- Left Column: Topic & Detailed Text Analysis -->
            <div id="left-panel" class="relative flex flex-col gap-4 min-h-0 h-full overflow-y-auto custom-scrollbar">
                <!-- Topic Card & Chart -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex-shrink-0">
                    <h5 class="font-bold text-gray-800 mb-2">Topic</h5>
                    <div class="text-gray-600 text-sm leading-relaxed">{!! $meeting->prompt !!}</div>
                    @if(!empty($meeting->image))
                        <div class="mt-4 p-2 bg-gray-50 rounded-xl border border-gray-100 flex justify-center">
                            <img src="{{ asset('storage/' . $meeting->image) }}" class="max-h-80 object-contain rounded-lg shadow-sm" alt="Task Diagram" />
                        </div>
                    @elseif(class_exists('\App\Support\IeltsTask1ChartResolver') && isset($meeting))
                        @php
                            $chart = \App\Support\IeltsTask1ChartResolver::resolve($meeting);
                        @endphp
                        @if(!empty($chart['publicUrl']))
                            <div class="mt-4 p-2 bg-gray-50 rounded-xl border border-gray-100 flex justify-center">
                                <img src="{{ asset($chart['publicUrl']) }}" class="max-h-80 object-contain rounded-lg shadow-sm" alt="Task Diagram" />
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Detailed Text Analysis Card -->
                <div id="detailed-text-analysis" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1 min-h-0">
                    <div class="p-4 border-b border-gray-100 bg-indigo-50/50 flex justify-between items-center flex-shrink-0">
                        <h3 class="font-bold text-indigo-800">Detailed Text Analysis</h3>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded">Error</span>
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Improvement</span>
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Suggestion</span>
                        </div>
                    </div>
                    <div class="detailed-analysis p-6 overflow-y-auto flex-1 prose prose-indigo max-w-none leading-loose text-lg text-gray-800 selection:bg-blue-100">
                        <!-- Loading Indicator -->
                        <div x-show="loading" class="mb-4 text-orange-500 flex items-center gap-2 animate-pulse not-prose">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="text-sm font-semibold">AI is analyzing your text...</span>
                        </div>

                        <!-- Graceful notice when the AI markup couldn't be generated -->
                        <div x-show="!loading && correctionFailed" class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg flex items-center justify-between gap-4 not-prose">
                            <span class="text-sm">The detailed markup is taking longer than usual. Showing your original essay below.</span>
                            <button type="button" @click="getCorrection()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 whitespace-nowrap flex-shrink-0">Try again</button>
                        </div>

                        <div x-show="!loading && !result?.correction_html && !correctionFailed" class="text-gray-400 italic animate-pulse py-8 text-center not-prose">Analyzing text structure and grammar...</div>
                        <div x-html="safeHtml"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Improvements & Feedback -->
            <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden flex flex-col h-full min-h-0" x-data="{ tab: 'feedback' }">
                <!-- Tabs -->
                <div class="flex border-b border-gray-200 bg-white overflow-x-auto no-scrollbar">
                    <button @click="tab = 'feedback'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'feedback' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Examiner Feedback</button>
                    <button @click="tab = 'task_response'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'task_response' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Task Response</button>
                    <button @click="tab = 'coherence'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'coherence' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Coherence</button>
                    <button @click="tab = 'lexical'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'lexical' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Lexical</button>
                    <button @click="tab = 'grammar'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'grammar' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Grammar</button>
                    <button @click="tab = 'better'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'better' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0 flex items-center gap-2">
                        <span>Band 9 Version</span>
                        <span x-show="improving && !result?.better_version" class="animate-spin h-3 w-3 border-2 border-orange-500 border-t-transparent rounded-full"></span>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <!-- Tab 1: General Feedback -->
                    <div x-show="tab === 'feedback'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-2">General Comments</h5>
                            <p x-show="!result?.feedback?.overall_comment && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating detailed feedback...</p>
                            <div x-show="feedbackFailed && !result?.feedback?.overall_comment" class="bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg flex items-center justify-between gap-4">
                                <span class="text-sm">Detailed feedback is taking longer than usual.</span>
                                <button type="button" @click="getFeedback()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 whitespace-nowrap flex-shrink-0">Try again</button>
                            </div>
                            <p x-show="result?.feedback?.overall_comment" class="text-gray-600 leading-relaxed" x-text="result?.feedback?.overall_comment"></p>
                        </div>
                    </div>

                    <!-- Tab 2: Task Response -->
                    <div x-show="tab === 'task_response'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Task Response Detailed Feedback</h5>
                            <p x-show="!result?.feedback?.task_achievement && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="feedbackFailed && !result?.feedback?.task_achievement" class="text-amber-700 text-sm">Couldn't generate this section. Try again from the Examiner Feedback tab.</p>
                            <template x-if="getBulletPoints(result?.feedback?.task_achievement)">
                                <ul class="list-disc list-inside space-y-1 text-gray-600 text-sm">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.task_achievement)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.task_achievement && !getBulletPoints(result?.feedback?.task_achievement)" class="text-gray-600 text-sm" x-text="result?.feedback?.task_achievement"></p>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Action Button -->
                                <div x-show="!taskResponseLoading" class="mb-4">
                                    <button type="button" @click="getTaskResponse()" class="w-full py-3 bg-green-50 text-green-700 font-bold rounded-lg border border-green-100 hover:bg-green-100 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        <span x-text="result?.task_response_improvements ? 'Re-Analyze & Upgrade Task Response (Band 7-9)' : 'Analyze & Upgrade Task Response (Band 7-9)'"></span>
                                    </button>
                                </div>

                                <!-- Loading State -->
                                <div x-show="taskResponseLoading" class="py-4 text-center text-green-600 animate-pulse flex flex-col items-center">
                                    <div class="animate-spin h-6 w-6 border-2 border-green-500 border-t-transparent rounded-full mb-2"></div>
                                    <span class="text-sm font-semibold">Analyzing Ideas & Argumentation...</span>
                                </div>

                                <!-- Error State -->
                                <div x-show="taskResponseError" class="py-2 text-center text-red-500 text-sm space-y-1">
                                    <span x-text="taskResponseError"></span>
                                    <p class="text-xs mt-2 text-red-600">💡 <strong>Coba ulang jika gagal memuat</strong></p>
                                </div>

                                <!-- Results -->
                                <div x-show="result?.task_response_improvements?.length > 0" class="space-y-4">
                                    <h6 class="font-bold text-green-700 text-sm flex items-center gap-2">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                         Upgrade Task Response (Band 7-9)
                                    </h6>
                                    <div class="space-y-3">
                                        <template x-for="(item, idx) in result?.task_response_improvements || []" :key="item.text">
                                            <div class="bg-green-50 p-3 rounded-lg border border-green-100">
                                                <div class="mb-2">
                                                    <span class="text-xs font-semibold text-green-800 bg-green-200 px-2 py-0.5 rounded">IDE / MASALAH ASLI</span>
                                                    <p class="text-gray-600 text-sm mt-1 italic" x-text="item.text"></p>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-xs font-semibold text-green-800 bg-green-200 px-2 py-0.5 rounded">VERSI LEBIH BAIK (BAND 9)</span>
                                                    <p class="text-green-800 font-medium text-sm mt-1" x-text="item.improved"></p>
                                                </div>
                                                <p class="text-green-700 text-xs mt-2 border-t border-green-200 pt-2" x-text="item.explanation"></p>

                                                <!-- Step-by-step revision guide -->
                                                <div x-show="item.steps?.length > 0" class="mt-3 pt-3 border-t border-green-200">
                                                    <span class="text-xs font-semibold text-green-800">LANGKAH PERBAIKAN:</span>
                                                    <ol class="mt-1 space-y-1 list-none">
                                                        <template x-for="(step, stepIdx) in item.steps || []" :key="stepIdx">
                                                            <li class="flex items-start gap-2 text-xs text-gray-700">
                                                                <span class="flex-shrink-0 w-4 h-4 rounded-full bg-green-600 text-white flex items-center justify-center text-[10px] font-bold mt-0.5" x-text="stepIdx + 1"></span>
                                                                <span x-text="step"></span>
                                                            </li>
                                                        </template>
                                                    </ol>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Coherence -->
                    <div x-show="tab === 'coherence'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Coherence Detailed Feedback</h5>
                            <p x-show="!result?.feedback?.coherence_cohesion && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="feedbackFailed && !result?.feedback?.coherence_cohesion" class="text-amber-700 text-sm">Couldn't generate this section. Try again from the Examiner Feedback tab.</p>
                            <template x-if="getBulletPoints(result?.feedback?.coherence_cohesion)">
                                <ul class="list-disc list-inside space-y-1 text-gray-600 text-sm">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.coherence_cohesion)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.coherence_cohesion && !getBulletPoints(result?.feedback?.coherence_cohesion)" class="text-gray-600 text-sm" x-text="result?.feedback?.coherence_cohesion"></p>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Loading State -->
                                <div x-show="coherenceLoading" class="py-4 text-center text-blue-600 animate-pulse flex flex-col items-center">
                                    <div class="animate-spin h-6 w-6 border-2 border-blue-500 border-t-transparent rounded-full mb-2"></div>
                                    <span class="text-sm font-semibold">Analyzing Coherence...</span>
                                </div>

                                <!-- Error State -->
                                <div x-show="coherenceError" class="py-2 text-center text-red-500 text-sm space-y-1">
                                    <span x-text="coherenceError"></span>
                                    <p class="text-xs mt-2 text-red-600">💡 <strong>Coba ulang jika gagal memuat</strong></p>
                                </div>

                                <!-- Results -->
                                <div x-show="result?.coherence_improvements?.length > 0" class="space-y-4 mb-4">
                                    <h6 class="font-bold text-blue-700 text-sm flex items-center gap-2">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                         Upgrade Coherence (Band 7-9)
                                    </h6>
                                    <div class="space-y-3">
                                        <template x-for="item in result?.coherence_improvements || []" :key="item.text">
                                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                                    <span class="text-gray-400 line-through text-sm" x-text="item.text"></span>
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                    <span class="text-blue-700 font-bold text-sm bg-white px-2 py-0.5 rounded shadow-sm border border-blue-100" x-text="item.improved"></span>
                                                </div>
                                                <p class="text-gray-600 text-xs mt-1" x-text="item.explanation"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div x-show="!coherenceLoading" class="mt-4">
                                    <button type="button" @click="getCoherence()" class="w-full py-3 bg-blue-50 text-blue-700 font-bold rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        <span>Analyze & Upgrade Coherence (Band 7-9)</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Lexical -->
                    <div x-show="tab === 'lexical'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Lexical Detailed Feedback</h5>
                            <p x-show="!result?.feedback?.lexical_resource && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="feedbackFailed && !result?.feedback?.lexical_resource" class="text-amber-700 text-sm">Couldn't generate this section. Try again from the Examiner Feedback tab.</p>
                            <template x-if="getBulletPoints(result?.feedback?.lexical_resource)">
                                <ul class="list-disc list-inside space-y-1 text-gray-600 text-sm">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.lexical_resource)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.lexical_resource && !getBulletPoints(result?.feedback?.lexical_resource)" class="text-gray-600 text-sm" x-text="result?.feedback?.lexical_resource"></p>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Loading State -->
                                <div x-show="vocabLoading" class="py-4 text-center text-purple-600 animate-pulse flex flex-col items-center">
                                    <div class="animate-spin h-6 w-6 border-2 border-purple-500 border-t-transparent rounded-full mb-2"></div>
                                    <span class="text-sm font-semibold">Analyzing Vocabulary...</span>
                                </div>

                                <!-- Error State -->
                                <div x-show="vocabError" class="py-2 text-center text-red-500 text-sm space-y-1">
                                    <span x-text="vocabError"></span>
                                    <p class="text-xs mt-2 text-red-600">💡 <strong>Coba ulang jika gagal memuat</strong></p>
                                </div>

                                <!-- Results -->
                                <div x-show="result?.lexical_improvements?.length > 0" class="space-y-4 mb-4">
                                    <h6 class="font-bold text-purple-700 text-sm flex items-center gap-2">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                         Upgrade Vocabulary (Band 7-9)
                                    </h6>
                                    <div class="space-y-3">
                                        <template x-for="item in result?.lexical_improvements || []" :key="item.text">
                                            <div class="bg-purple-50 p-3 rounded-lg border border-purple-100">
                                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                                    <span class="text-gray-400 line-through text-sm" x-text="item.text"></span>
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                    <span class="text-purple-700 font-bold text-sm bg-white px-2 py-0.5 rounded shadow-sm border border-purple-100" x-text="item.improved"></span>
                                                </div>
                                                <p class="text-gray-600 text-xs mt-1" x-text="item.explanation"></p>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <h6 class="font-bold text-purple-700 text-sm flex items-center gap-2 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            C1 Vocabulary You Could Use (from this topic)
                                        </h6>
                                        <p class="text-xs text-gray-500 mb-3">Advanced (CEFR C1 / IELTS Band 7-8) words and collocations relevant to this essay's topic that would have strengthened your score.</p>

                                        <div class="space-y-3">
                                            <template x-for="vocab in result?.topic_vocabularies || []" :key="vocab.term">
                                                <div class="bg-white p-3 rounded-lg border border-purple-100 shadow-sm">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold text-purple-800 text-sm" x-text="vocab.term"></span>
                                                        <span class="text-xs px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full">C1</span>
                                                    </div>
                                                    <p class="text-sm text-gray-700 mt-1 font-medium" x-text="vocab.meaning"></p>
                                                    <p class="text-xs text-gray-500 mt-1 italic">
                                                        <span class="font-semibold text-purple-600">Ex:</span>
                                                        <span x-text="vocab.example"></span>
                                                    </p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div x-show="!vocabLoading" class="mt-4">
                                    <button type="button" @click="getVocabulary()" class="w-full py-3 bg-purple-50 text-purple-700 font-bold rounded-lg border border-purple-100 hover:bg-purple-100 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        <span>Analyze & Upgrade Vocabulary (Band 7-9)</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 5: Grammar -->
                    <div x-show="tab === 'grammar'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Grammar Detailed Feedback</h5>
                            <p x-show="!result?.feedback?.grammatical_range && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="feedbackFailed && !result?.feedback?.grammatical_range" class="text-amber-700 text-sm">Couldn't generate this section. Try again from the Examiner Feedback tab.</p>
                            <template x-if="getBulletPoints(result?.feedback?.grammatical_range)">
                                <ul class="list-disc list-inside space-y-1 text-gray-600 text-sm">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.grammatical_range)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.grammatical_range && !getBulletPoints(result?.feedback?.grammatical_range)" class="text-gray-600 text-sm" x-text="result?.feedback?.grammatical_range"></p>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Loading State -->
                                <div x-show="grammarLoading" class="py-4 text-center text-purple-600 animate-pulse flex flex-col items-center">
                                    <div class="animate-spin h-6 w-6 border-2 border-purple-500 border-t-transparent rounded-full mb-2"></div>
                                    <span class="text-sm font-semibold">Analyzing Sentence Structures...</span>
                                </div>

                                <!-- Error State -->
                                <div x-show="grammarError" class="py-2 text-center text-red-500 text-sm space-y-1">
                                    <span x-text="grammarError"></span>
                                    <p class="text-xs mt-2 text-red-600">💡 <strong>Coba ulang jika gagal memuat</strong></p>
                                </div>

                                <!-- Results -->
                                <div x-show="result?.grammar_improvements?.length > 0" class="space-y-4 mb-4">
                                    <!-- Grammar Errors List Section -->
                                    <div class="bg-red-50 rounded-xl border border-red-100 p-4">
                                        <h6 class="font-bold text-red-700 text-sm flex items-center gap-2 mb-3">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                             Kesalahan Grammar yang Ditemukan
                                        </h6>
                                        <div class="space-y-2">
                                            <template x-for="(item, index) in result?.grammar_improvements || []" :key="item.text">
                                                <div class="bg-white p-3 rounded-lg border border-red-200 flex items-start gap-3 hover:shadow-sm transition-shadow">
                                                    <div class="flex-shrink-0 mt-0.5">
                                                        <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full" x-text="index + 1"></span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-red-700 text-italic line-clamp-2" x-text="item.text"></p>
                                                        <p class="text-xs text-gray-500 mt-1">⚠️ Grammar issue: <span x-text="item.explanation?.split('(')[0]?.trim() || 'Structure needs improvement'"></span></p>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Upgrade Grammar Section -->
                                    <h6 class="font-bold text-purple-700 text-sm flex items-center gap-2 mt-6">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                         Upgrade Grammar (Band 7-9)
                                    </h6>
                                    <div class="space-y-3">
                                        <template x-for="item in result?.grammar_improvements || []" :key="item.text">
                                            <div class="bg-purple-50 p-3 rounded-lg border border-purple-100">
                                                <div class="mb-2">
                                                    <span class="text-xs font-semibold text-purple-800 bg-purple-200 px-2 py-0.5 rounded">KALIMAT ASLI</span>
                                                    <p class="text-gray-600 text-sm mt-1 italic" x-text="item.text"></p>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-xs font-semibold text-purple-800 bg-purple-200 px-2 py-0.5 rounded">VERSI LEBIH BAIK (BAND 9)</span>
                                                    <p class="text-purple-800 font-medium text-sm mt-1" x-text="item.improved"></p>
                                                </div>
                                                <p class="text-purple-700 text-xs mt-2 border-t border-purple-200 pt-2" x-text="item.explanation"></p>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- TOPIC GRAMMAR SECTION -->
                                    <div class="mt-8 pt-6 border-t border-purple-100" x-show="result?.topic_grammar?.length > 0">
                                        <button type="button" @click="showTopicGrammar = !showTopicGrammar" class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-white rounded-xl border border-purple-100 hover:shadow-md transition-all group">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                </div>
                                                <div class="text-left">
                                                    <h6 class="font-bold text-gray-800">Advanced Grammar Structures</h6>
                                                    <p class="text-xs text-purple-600 font-medium">Topic-specific grammar (Band 7-9)</p>
                                                </div>
                                            </div>
                                            <svg :class="{'rotate-180': showTopicGrammar}" class="w-5 h-5 text-purple-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>

                                        <div x-show="showTopicGrammar" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-4 grid grid-cols-1 gap-3">
                                            <template x-for="item in result?.topic_grammar || []" :key="item.type">
                                                <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-sm hover:border-purple-300 transition-colors">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-xs font-bold text-white bg-purple-600 px-2 py-1 rounded-md tracking-wide" x-text="item.type"></span>
                                                    </div>
                                                    <p class="text-gray-800 font-medium text-lg leading-relaxed mb-2 font-serif" x-text="item.example"></p>
                                                    <p class="text-sm text-gray-500 italic border-l-2 border-purple-200 pl-3" x-text="item.explanation"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div x-show="!grammarLoading" class="mt-4">
                                    <button type="button" @click="getGrammar()" class="w-full py-3 bg-purple-50 text-purple-700 font-bold rounded-lg border border-purple-100 hover:bg-purple-100 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        <span>Analyze & Upgrade Grammar (Band 7-9)</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Better Version -->
                    <div x-show="tab === 'better'" class="prose max-w-none text-gray-700">
                        <div x-show="!result?.better_version && improving" class="flex flex-col items-center justify-center py-12 text-gray-400 animate-pulse">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <p>Crafting Band 9 Version...</p>
                        </div>
                        <div x-show="!result?.better_version && !improving && improveFailed" class="flex flex-col items-center justify-center py-12 text-gray-500 not-prose">
                            <p class="mb-3 text-sm">The Band 9 rewrite is taking longer than usual.</p>
                            <button type="button" @click="improveEssay()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 bg-orange-50 px-4 py-2 rounded-lg">Try again</button>
                        </div>
                        <div x-show="result?.better_version">
                            <div class="bg-orange-50 p-4 rounded-xl border border-orange-100 mb-4">
                                <p class="text-sm font-semibold text-orange-800">This rewriting demonstrates a Band 9 level response. Notice the advanced vocabulary, complex sentence structures, and clear cohesive devices.</p>
                            </div>
                            <div x-html="result?.better_version?.replace(/\n/g, '<br>')"></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @include('assignments.ielts.writing.partials.practice_panels')
    @include('assignments.ielts.writing.practice_toolbar', ['inlineMagicSentence' => true])
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        // Only run chart initialization if the canvas is present
        const canvas = document.getElementById('meetingChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const meetingNum = {{ $meeting->meeting_number ?? 0 }};
        const viewType = '{{ $meeting->view_type ?? '' }}';

        // Helper to hide canvas label if it's a table/process/map that requires HTML
        const showHtmlRender = (html) => {
            const container = canvas.parentElement;
            canvas.style.display = 'none';
            container.classList.remove('h-80', 'items-center', 'justify-center');
            container.classList.add('items-stretch', 'justify-start');
            
            let contentDiv = document.getElementById('htmlContentData');
            if (!contentDiv) {
                contentDiv = document.createElement('div');
                contentDiv.id = 'htmlContentData';
                contentDiv.className = 'w-full h-auto flex flex-col';
                container.appendChild(contentDiv);
            }
            contentDiv.innerHTML = html;
        };

        if (meetingNum === 1) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Science', 'Arts', 'Engineering', 'Business', 'IT'],
                    datasets: [
                        { label: '2010', data: [12000, 15000, 8000, 18000, 5000], backgroundColor: '#3b82f6' },
                        { label: '2020', data: [18000, 11000, 15000, 22000, 13000], backgroundColor: '#10b981' }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'University Subject Enrolments (2010 vs 2020)' } } }
            });
        } else if (meetingNum === 2) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1999', '2004', '2009', '2014', '2019'],
                    datasets: [
                        { label: 'USA', data: [35, 60, 75, 87, 92], borderColor: '#3b82f6', tension: 0.1, fill: false, borderWidth: 3 },
                        { label: 'Canada', data: [28, 55, 71, 85, 90], borderColor: '#ef4444', tension: 0.1, fill: false, borderWidth: 3 },
                        { label: 'Mexico', data: [5, 12, 25, 45, 65], borderColor: '#10b981', tension: 0.1, fill: false, borderWidth: 3 }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Internet Usage Over Time (% of Population)' } }, scales: { y: { min: 0, max: 100 } } }
            });
        } else if (meetingNum === 3) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Agriculture', 'Industry', 'Domestic'],
                    datasets: [{ data: [70, 20, 10], backgroundColor: ['#10b981', '#f59e0b', '#3b82f6'] }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Global Water Usage by Sector' } } }
            });
        } else if (meetingNum === 4) {
            showHtmlRender(`
                <table class="w-full text-left border-collapse">
                    <thead><tr class="bg-blue-100"><th class="p-3 border">Country</th><th class="p-3 border">2015 (Millions)</th><th class="p-3 border">2020 (Millions)</th></tr></thead>
                    <tbody>
                        <tr><td class="p-3 border font-bold">France</td><td class="p-3 border">84.5</td><td class="p-3 border">11.7</td></tr>
                        <tr class="bg-gray-50"><td class="p-3 border font-bold">Spain</td><td class="p-3 border">68.2</td><td class="p-3 border">18.9</td></tr>
                        <tr><td class="p-3 border font-bold">USA</td><td class="p-3 border">77.5</td><td class="p-3 border">19.4</td></tr>
                        <tr class="bg-gray-50"><td class="p-3 border font-bold">China</td><td class="p-3 border">56.9</td><td class="p-3 border">15.2</td></tr>
                    </tbody>
                </table>
            `);
        } else if (meetingNum === 5) {
            showHtmlRender(`
                <div class="text-center">
                    <h3 class="font-bold text-lg mb-4 text-gray-700">Process Diagram: Paper Recycling</h3>
                    <div class="flex flex-col items-center gap-2">
                        <div class="p-3 bg-blue-100 rounded border border-blue-300 w-48 font-semibold">1. Collection</div>
                        <i class="fas fa-arrow-down text-gray-400"></i>
                        <div class="p-3 bg-blue-100 rounded border border-blue-300 w-48 font-semibold">2. Sorting</div>
                        <i class="fas fa-arrow-down text-gray-400"></i>
                        <div class="p-3 bg-blue-100 rounded border border-blue-300 w-48 font-semibold">3. Pulping</div>
                        <i class="fas fa-arrow-down text-gray-400"></i>
                        <div class="p-3 bg-blue-100 rounded border border-blue-300 w-48 font-semibold">4. De-inking</div>
                        <i class="fas fa-arrow-down text-gray-400"></i>
                        <div class="p-3 bg-blue-100 rounded border border-blue-300 w-48 font-semibold">5. Making New Paper</div>
                    </div>
                </div>
            `);
        } else if (meetingNum === 6) {
            showHtmlRender(`
                <div class="p-6 w-full">
                    <h3 class="font-bold text-lg text-center text-gray-800 mb-5">Writing Task 1 – Quick Reference</h3>
                    <div class="flex flex-col gap-6">
                        <div class="rounded-xl overflow-hidden border border-green-300 shadow-sm">
                            <div class="bg-green-600 text-white font-bold px-5 py-3 text-base">Useful introductory phrases:</div>
                            <ul class="bg-green-50 px-5 py-4 space-y-2 text-sm text-gray-800">
                                <li><span class="text-green-600 mr-2">•</span> The table shows changes in ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The table gives information about ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The bar chart compares ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The graph illustrates ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The chart shows data about ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The pie charts compare ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The diagram shows the process of ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The figure shows how ... is produced</li>
                                <li><span class="text-green-600 mr-2">•</span> The line graph shows changes in ...</li>
                                <li><span class="text-green-600 mr-2">•</span> The line graph compares ...</li>
                            </ul>
                        </div>
                        <div class="rounded-xl overflow-hidden border border-purple-300 shadow-sm">
                            <div class="bg-purple-600 text-white font-bold px-5 py-3 text-base">Simple changes you can make:</div>
                            <ul class="bg-purple-50 px-5 py-4 space-y-2 text-sm text-gray-800">
                                <li><span class="text-purple-600 mr-2">•</span> Graph / line graph / chart / bar chart</li>
                                <li><span class="text-purple-600 mr-2">•</span> Diagram / figure</li>
                                <li><span class="text-purple-600 mr-2">•</span> Shows / illustrates / compares</li>
                                <li><span class="text-purple-600 mr-2">•</span> proportion = percentage</li>
                                <li><span class="text-purple-600 mr-2">•</span> information = data</li>
                                <li><span class="text-purple-600 mr-2">•</span> the number of / the figure for / the proportion of</li>
                                <li><span class="text-purple-600 mr-2">•</span> people in the UK / the British</li>
                                <li><span class="text-purple-600 mr-2">•</span> from 1999 to 2009 / between 1999 and 2009 / over a period of 10 years</li>
                                <li><span class="text-purple-600 mr-2">•</span> in three countries = in the UK, France and Spain (i.e. name the countries)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            `);
        } else if (meetingNum === 7) {
             new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Country A', 'Country B', 'Country C'],
                    datasets: [
                        { label: 'Coal', data: [40, 20, 15], backgroundColor: '#475569' },
                        { label: 'Gas', data: [30, 45, 25], backgroundColor: '#f59e0b' },
                        { label: 'Nuclear', data: [20, 15, 40], backgroundColor: '#3b82f6' },
                        { label: 'Renewables', data: [10, 20, 20], backgroundColor: '#10b981' }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Energy Sources by Country (%)' } }, scales: { x: { stacked: true }, y: { stacked: true, min: 0, max: 100 } } }
            });
        } else if (meetingNum === 8) {
             new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1970', '1980', '1990', '2000', '2010', '2020'],
                    datasets: [
                        { label: 'UK', data: [11.5, 10.2, 9.8, 8.5, 7.8, 5.2], borderColor: '#3b82f6', tension: 0.1, fill: false, borderWidth: 3 },
                        { label: 'Sweden', data: [9.2, 7.5, 6.0, 5.8, 5.2, 3.4], borderColor: '#10b981', tension: 0.1, fill: false, borderWidth: 3 },
                        { label: 'Italy', data: [4.2, 5.5, 7.0, 7.5, 6.5, 5.0], borderColor: '#ef4444', tension: 0.1, fill: false, borderWidth: 3 },
                        { label: 'Portugal', data: [1.5, 2.5, 4.0, 5.5, 4.8, 4.2], borderColor: '#f59e0b', tension: 0.1, fill: false, borderWidth: 3 }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'CO₂ Emissions per Capita (Metric Tons)' } } }
            });
        } else if (meetingNum === 9) {
            showHtmlRender(`
                <table class="w-full text-left border-collapse">
                    <thead><tr class="bg-indigo-100"><th class="p-3 border">Category</th><th class="p-3 border">UK (%)</th><th class="p-3 border">New Zealand (%)</th></tr></thead>
                    <tbody>
                        <tr><td class="p-3 border font-bold">Food</td><td class="p-3 border">23%</td><td class="p-3 border">25%</td></tr>
                        <tr class="bg-gray-50"><td class="p-3 border font-bold">Housing</td><td class="p-3 border">18%</td><td class="p-3 border">21%</td></tr>
                        <tr><td class="p-3 border font-bold">Transport</td><td class="p-3 border">15%</td><td class="p-3 border">14%</td></tr>
                        <tr class="bg-gray-50"><td class="p-3 border font-bold">Leisure</td><td class="p-3 border">11%</td><td class="p-3 border">9%</td></tr>
                        <tr><td class="p-3 border font-bold">Clothing</td><td class="p-3 border">8%</td><td class="p-3 border">6%</td></tr>
                    </tbody>
                </table>
            `);
        } else if (meetingNum === 10) {
            showHtmlRender(`
                <div class="flex h-full w-full gap-4 items-center justify-center p-2">
                    <div class="w-1/2 h-full"><canvas id="mixedChart1"></canvas></div>
                    <div class="w-1/2 h-full"><canvas id="mixedChart2"></canvas></div>
                </div>
            `);
            new Chart(document.getElementById('mixedChart1').getContext('2d'), {
                type: 'pie',
                data: { labels: ['Car', 'Bus', 'Train', 'Walk/Bike'], datasets: [{ data: [55, 20, 15, 10], backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6', '#10b981'] }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Primary Commuting Methods' } } }
            });
            new Chart(document.getElementById('mixedChart2').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['< 5 Miles', '5 - 15 Miles', '> 15 Miles'],
                    datasets: [
                        { label: 'Car', data: [40, 60, 80], backgroundColor: '#ef4444' },
                        { label: 'Public Transport', data: [20, 30, 15], backgroundColor: '#3b82f6' },
                        { label: 'Walk/Bike', data: [40, 10, 5], backgroundColor: '#10b981' }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Methods by Distance' } } }
            });
        } else {
            // Fallback or Image placeholder
            showHtmlRender(`
                <div class="text-center text-gray-400">
                    <i class="fas fa-chart-line text-4xl mb-3 block"></i>
                    <p>Chart data for this specific lesson is not mapped yet.</p>
                </div>
            `);
        }
    }, 200);
});
</script>

{{--
    Live-sync (teacher watches the student's essay update in real time) is
    gated on CRDT_WS_URL being explicitly configured to our OWN relay
    server - it deliberately no longer falls back to the public Yjs demo
    server (wss://demos.yjs.dev). That demo server was never meant for
    real traffic: student essay content (including exam prompts) was
    being sent to an unauthenticated third-party server with no SLA, and
    its instability is why "CRDT: reconnecting..." showed up so often.
    Until CRDT_WS_URL and CRDT_RELAY_SECRET both point at our own
    infrastructure, this feature is simply off - students can still write
    and submit normally either way, this only affects the separate
    "teacher watches live" capability.
--}}
@if(auth()->check() && in_array(auth()->user()->role, ['student', 'guest']) && !empty(env('CRDT_WS_URL')) && !empty(env('CRDT_RELAY_SECRET')))
@php
    $crdtRoomId = 'ielts-writing:' . $meeting->id . ':task:' . (int) $task . ':user:' . auth()->id();
    // Our own relay rejects any connection whose token doesn't match this
    // HMAC - see the relay's server.js. Without it, knowing/guessing a
    // room name (predictable: meeting/task/user IDs) would be enough to
    // read or write into someone else's essay in real time.
    $crdtToken = hash_hmac('sha256', $crdtRoomId, env('CRDT_RELAY_SECRET'));
@endphp
<script type="module">
    // ?deps=yjs@13.6.18 pins y-websocket's OWN internal yjs dependency to
    // the exact same module instance imported below - without it, esm.sh
    // resolves y-websocket's yjs separately (a different version even),
    // producing a real SECOND Yjs instance side-by-side. Yjs's internal
    // constructor checks silently fail to merge updates across that
    // instance boundary, so this isn't cosmetic: without this pin, sync
    // updates round-trip over the wire (confirmed via byte-level logging)
    // but never actually apply to the receiving side's document - the
    // "live sync" here would never have worked correctly.
    // See https://github.com/yjs/yjs/issues/438
    import * as Y from 'https://esm.sh/yjs@13.6.18';
    import { WebsocketProvider } from 'https://esm.sh/y-websocket@1.5.3?deps=yjs@13.6.18';

    const wsUrl = @json(env('CRDT_WS_URL'));
    const roomId = @json($crdtRoomId);
    const crdtToken = @json($crdtToken);

    const statusPill = document.createElement('div');
    statusPill.id = 'crdtWriterStatus';
    statusPill.className = 'fixed bottom-6 left-6 z-[85] text-xs font-semibold px-3 py-2 rounded-full bg-amber-100 text-amber-700 shadow';
    statusPill.textContent = 'CRDT: connecting...';
    document.body.appendChild(statusPill);

    const setStatus = (text, css) => {
        statusPill.textContent = text;
        statusPill.className = `fixed bottom-6 left-6 z-[85] text-xs font-semibold px-3 py-2 rounded-full shadow ${css}`;
    };

    const waitForEssayTextarea = () => {
        const found = document.querySelector('textarea[x-model="essay"]');
        if (found) {
            return Promise.resolve(found);
        }

        return new Promise((resolve) => {
            const timer = setInterval(() => {
                const el = document.querySelector('textarea[x-model="essay"]');
                if (el) {
                    clearInterval(timer);
                    resolve(el);
                }
            }, 100);
        });
    };

    const doc = new Y.Doc();
    const provider = new WebsocketProvider(wsUrl, roomId, doc, { connect: true, params: { token: crdtToken } });
    const yEssay = doc.getText('essay');

    provider.on('status', (event) => {
        if (event.status === 'connected') {
            setStatus('CRDT: live sync on', 'bg-emerald-100 text-emerald-700');
        } else {
            setStatus('CRDT: reconnecting...', 'bg-amber-100 text-amber-700');
        }
    });

    const textarea = await waitForEssayTextarea();
    let applyingRemote = false;
    let applyTimer = null;
    let pushTimer = null;

    const syncTextareaFromY = () => {
        const nextValue = yEssay.toString();
        if (textarea.value === nextValue) {
            return;
        }

        // Never stomp the user's own live typing - if this field is
        // focused, skip the overwrite entirely rather than clobbering
        // mid-keystroke. It'll be re-applied on the next observe tick
        // once there's a genuinely newer remote change to reflect.
        if (document.activeElement === textarea) {
            return;
        }

        applyingRemote = true;
        textarea.value = nextValue;
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
        applyingRemote = false;
    };

    const pushTextareaToY = () => {
        if (applyingRemote) {
            return;
        }

        const current = yEssay.toString();
        const next = textarea.value || '';
        if (current === next) {
            return;
        }

        doc.transact(() => {
            yEssay.delete(0, yEssay.length);
            yEssay.insert(0, next);
        }, 'local-essay-input');
    };

    // Origin-tagged: only re-apply to the textarea for changes that did
    // NOT originate from this same client's own pushTextareaToY() call
    // just above. Without this check, every local edit "echoes" back
    // through Y ~40-160ms later (the combined push+apply debounce) and
    // re-stamps the textarea with that now-stale snapshot - silently
    // wiping out whatever the user typed in the meantime and resetting
    // the caret to the end. That's what caused characters to drop out
    // mid-word while typing (e.g. "with" becoming "w c").
    yEssay.observe((event, transaction) => {
        if (transaction.origin === 'local-essay-input') {
            return;
        }
        clearTimeout(applyTimer);
        applyTimer = setTimeout(syncTextareaFromY, 40);
    });

    textarea.addEventListener('input', () => {
        // Also skip scheduling a push for the synthetic 'input' event
        // syncTextareaFromY() dispatches when applying a remote change -
        // there's nothing new to push back in that case.
        if (applyingRemote) {
            return;
        }
        clearTimeout(pushTimer);
        pushTimer = setTimeout(pushTextareaToY, 120);
    });

    // Seed initial value once when the shared doc is empty.
    setTimeout(() => {
        if (yEssay.length === 0 && textarea.value && textarea.value.trim().length > 0) {
            pushTextareaToY();
        } else {
            syncTextareaFromY();
        }
    }, 300);

    window.addEventListener('beforeunload', () => {
        provider.destroy();
        doc.destroy();
    });
</script>
@endif

@endsection
