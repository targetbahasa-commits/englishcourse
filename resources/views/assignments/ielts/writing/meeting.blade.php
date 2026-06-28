@extends('layouts.admin')

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
<script>
    // NUCLEAR OPTION: Global Alpine Interceptor
    document.addEventListener('alpine:init', () => {
        Alpine.store('safeRender', {
            html(value) {
                if (!value || value === 'undefined' || String(value).includes('undefined')) {
                    console.warn('🚫 BLOCKED undefined render');
                    return '';
                }
                return value;
            }
        });
    });
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
            essay: '',
            error: null,
            showResults: false,
            
            // INITIALIZE IMMEDIATELY
            result: {
                status: 'pending',
                scores: {
                    overall_band: '-',
                    task_achievement: '-',
                    coherence_cohesion: '-',
                    lexical_resource: '-',
                    grammatical_range: '-'
                },
                feedback: {
                    overall_comment: '',
                    task_achievement: '',
                    coherence_cohesion: '',
                    lexical_resource: '',
                    grammatical_range: '',
                    coherence_improvements: [],
                    grammar_improvements: []
                },
                correction_html: null,
                better_version: null,
                vocabulary_improvements: [],
                collocations: []
            },
            
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

            removeParagraph(index) {
                this.plan.extras.splice(index, 1);
            },

            init() {
                this.interval = setInterval(() => { 
                    if (this.time > 0) {
                        this.time--; 
                    } else {
                        clearInterval(this.interval);
                        // Optional: alert('Time is up!');
                    }
                }, 1000);
                
                // Load Plan from LocalStorage
                const planKey = 'ielts_plan_' + '{{ $meeting->id }}';
                const savedPlan = localStorage.getItem(planKey);
                if (savedPlan) {
                    try {
                         const parsed = JSON.parse(savedPlan);
                         this.plan = { ...this.plan, ...parsed };
                         if (!this.plan.extras) this.plan.extras = []; 
                    } catch(e) { console.error('Error loading plan', e); }
                }

                // Watch Plan for Changes
                this.$watch('plan', (val) => {
                    localStorage.setItem(planKey, JSON.stringify(val));
                });
                
                setTimeout(() => {
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
            },
            
            statusMessage: '',

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
                
                try {
                    const response = await fetch('{{ route('assignments.ielts.writing.evaluate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}' })
                    });
                    
                    if (!response.ok) throw new Error('Evaluation failed. Server returned ' + response.status);
                    
                    let data = await response.json();
                    data = this.sanitizeRecursive(data);
                    
                    if (data.scores) {
                         this.result.scores = { ...this.result.scores, ...data.scores };
                    }
                    
                    this.showResults = true;
                    
                    await this.getFeedback();
                    await this.getCorrection();
                    await this.improveEssay();
                    
                } catch (e) {
                    console.error(e);
                    this.error = e.message;
                } finally {
                    this.statusMessage = '';
                    this.loading = false;
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

            highlightInEssay(original) {
                this.tab = 'analysis';
                const highlight = () => {
                    try {
                        const container = document.querySelector('.detailed-analysis') || document.querySelector('.p-6.prose');
                        if (!container) return;

                        // Clear previous highlights
                        container.querySelectorAll('.tb-highlight').forEach(el => {
                            el.classList.remove('tb-highlight');
                            if (el.dataset && el.dataset.replaced === '1') {
                                const parent = el.parentNode;
                                while (el.firstChild) parent.insertBefore(el.firstChild, el);
                                parent.removeChild(el);
                            }
                        });

                        const phrase = String(original).trim();
                        if (!phrase) return;

                        // Find first element whose text contains the phrase
                        const nodes = Array.from(container.querySelectorAll('*'));
                        const matchingElement = nodes.find(el => el.childElementCount === 0 && el.innerText && el.innerText.toLowerCase().includes(phrase.toLowerCase()));

                        if (matchingElement) {
                            const text = matchingElement.innerText;
                            const idx = text.toLowerCase().indexOf(phrase.toLowerCase());
                            if (idx >= 0) {
                                const before = text.slice(0, idx);
                                const matchText = text.slice(idx, idx + phrase.length);
                                const after = text.slice(idx + phrase.length);
                                matchingElement.innerHTML = `${before}<span class="tb-highlight" data-replaced="1">${matchText}</span>${after}`;
                                const wrapper = matchingElement.querySelector('.tb-highlight');
                                if (wrapper) wrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                return;
                            }
                        }

                        const fallback = Array.from(container.querySelectorAll('*')).find(el => el.innerText && el.innerText.toLowerCase().includes(phrase.toLowerCase()));
                        if (fallback) {
                            fallback.classList.add('tb-highlight');
                            fallback.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } catch (e) {
                        console.error('Highlight failed', e);
                    }
                };

                if (typeof this.$nextTick === 'function') {
                    this.$nextTick(highlight);
                } else {
                    setTimeout(highlight, 50);
                }
            },

            async getFeedback() {
                this.statusMessage = 'Generating Detailed Feedback...';
                try {
                    const response = await fetch('{{ route('assignments.ielts.writing.feedback') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        if (data.feedback) {
                            this.result.feedback = { ...this.result.feedback, ...data.feedback };
                        }
                    }
                } catch (e) {
                    console.error('Feedback stage failed:', e);
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
                    const response = await fetch('{{ route('assignments.ielts.writing.correct') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        
                        let finalHtml = null;
                        if (data.correction_html && data.correction_html.length > 20) {
                            finalHtml = data.correction_html;
                        }
                        
                        if (!finalHtml) {
                             finalHtml = '<p>' + this.essay.replace(/\n/g, '<br>') + '</p>';
                        }
                        
                        this.result = {
                            ...this.result,
                            ...data,
                            correction_html: finalHtml
                        };
                    }
                } catch (e) {
                    console.error('Correction stage failed:', e);
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
                    const response = await fetch('{{ route('assignments.ielts.writing.improve') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ essay: this.essay, task_type: '{{ $task }}' })
                    });

                    if (response.ok) {
                        let data = await response.json();
                        data = this.sanitizeRecursive(data);
                        
                        if (data.better_version) this.result.better_version = data.better_version;
                        if (data.vocabulary_improvements) this.result.vocabulary_improvements = data.vocabulary_improvements;
                        if (data.collocations) this.result.collocations = data.collocations;
                    }
                } catch (e) {
                    console.error('Improvement stage failed:', e);
                } finally {
                    this.improving = false;
                }
            },

            getGrammarErrors() {
                if (!this.result?.correction_html) return [];
                
                const div = document.createElement('div');
                div.innerHTML = this.result.correction_html;
                
                const errors = [];
                const spans = div.querySelectorAll('span');
                
                for (let i = 0; i < spans.length; i++) {
                    const span = spans[i];
                    if (span.classList.contains('bg-red-100') || span.classList.contains('text-red-600')) {
                        const errorText = span.innerText;
                        let correctionText = '';
                        
                        let next = span.nextSibling;
                        if (next && next.nodeType === 3 && next.textContent.trim() === '') {
                            next = next.nextSibling; 
                        }
                        
                        if (next && next.nodeType === 1 && next.tagName === 'SPAN' && (next.classList.contains('text-green-600') || next.classList.contains('font-bold'))) {
                            correctionText = next.innerText;
                        }
                        
                        errors.push({ error: errorText, correction: correctionText });
                    }
                }
                return errors;
            }
        }));
    });
</script>

<div class="flex flex-col h-screen overflow-hidden bg-gradient-to-br from-blue-50 via-white to-purple-50" 
     x-data="ieltsWritingTask({{ json_encode($meeting->idioms ?? []) }}, {{ json_encode($meeting->collocations ?? []) }})"
     @toggle-collocations.window="isCollocationsOpen = !isCollocationsOpen; if(isCollocationsOpen) isIdiomsOpen = false"
     @toggle-idioms.window="isIdiomsOpen = !isIdiomsOpen; if(isIdiomsOpen) isCollocationsOpen = false"
>
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
        
          <div class="flex gap-3">
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
            <p class="text-sm mt-1 text-red-600">Please ensure your local AI server (LM Studio or Ollama) is running.</p>
            <p class="text-sm mt-2 text-red-600">💡 <strong>Coba ulang jika gagal memuat</strong></p>
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
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h2 class="font-bold text-gray-700">Question Prompt</h2>
                <span class="text-xs font-semibold text-gray-400">Read Carefully</span>
            </div>
            
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
                    <h3 class="text-lg font-bold mb-4 text-gray-700">You should spend about 40 minutes on this task.</h3>
                    
                    <!-- Question Container -->
                    <div class="bg-indigo-50/50 p-6 rounded-xl border border-indigo-100 mb-8 shadow-sm">
                        <div class="prose prose-lg text-gray-800 font-medium italic">
                            "{!! $meeting->prompt ?? 'Discuss the advantages and disadvantages...' !!}"
                        </div>
                    </div>

                @if(!isset($meeting) || $meeting->category != 'practice_item')
                    <!-- Divider -->
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-px bg-gray-200 flex-1"></div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Instructions</span>
                        <div class="h-px bg-gray-200 flex-1"></div>
                    </div>

                    <!-- Instructions Container -->
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Your Task</h4>
                                <p class="text-gray-600">Write an essay in response to the above topic. Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-yellow-800 mb-1">Expert Tip</h4>
                                <p class="text-sm text-yellow-700">Ensure you have a clear introduction, body paragraphs, and conclusion.</p>
                            </div>
                        </div>
                    </div>
                @endif
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
                             <textarea x-model="plan.body1" 
                                       x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                       @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                       class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none" 
                                       placeholder="• Topic Sentence (Main Idea 1)&#10;• Explain/Expand&#10;• Example"></textarea>
                        </div>

                        <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                            <h4 class="font-bold text-orange-800 mb-2">Body Paragraph 2</h4>
                             <textarea x-model="plan.body2" 
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
                                 <textarea x-model="plan.extras[index]" 
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
                             class="absolute bottom-0 right-0 w-6 h-6 cursor-nwse-resize flex items-end justify-end p-1 z-50">
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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col min-h-0 min-w-0 lg:h-full overflow-hidden" :style="panelStyle('right')">
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
            <textarea x-model="essay" class="flex-1 min-h-0 w-full p-6 resize-none overflow-y-auto focus:outline-none focus:bg-blue-50/30 transition-colors font-serif leading-relaxed text-gray-800 text-lg" placeholder="Start typing your answer here..."></textarea>
            
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
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-gray-500 text-sm">Overall Band Score:</span>
                        <span class="px-3 py-0.5 bg-red-100 text-red-700 font-bold rounded-full text-lg" x-text="result?.scores?.overall_band"></span>
                    </div>
                </div>
            </div>

            <!-- Score Summary Cards -->
            <div v-if="result" class="flex gap-4">
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 flex-1 min-h-0">
            <!-- Left Column: Topic & Detailed Analysis -->
            <div class="flex flex-col gap-4 min-h-0 h-full">
                <!-- Topic Card -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex-shrink-0">
                    <h5 class="font-bold text-gray-800 mb-2">Topic</h5>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $meeting->prompt }}</p>
                </div>

                <!-- Analysis Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1 min-h-0">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Detailed Text Analysis</h3>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <span class="bg-red-100 text-red-600 px-1 rounded">Error</span>
                            <span class="bg-yellow-200 text-gray-800 px-2 py-0.5 rounded">Improvement</span>
                        </div>
                    </div>
                    <!-- Correction Content -->
                    <style>
                        .detailed-analysis .grammar-correction { display: none; }
                    </style>
                    <style>
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
                        }

                        /* Make sure removal markers remain visually crossed-out */
                        .detailed-analysis s,
                        .detailed-analysis del,
                        .detailed-analysis .line-through {
                            text-decoration: line-through;
                        }
                    </style>
                    <style>
                        /* Highlight wrapper applied when user clicks a vocab item */
                        .tb-highlight {
                            background: rgba(167,139,250,0.18);
                            padding: 0.12rem 0.22rem;
                            border-radius: 6px;
                            box-shadow: 0 0 0 2px rgba(167,139,250,0.06) inset;
                        }
                    </style>
                    <!-- Correction Content -->
                    <style>
                        .detailed-analysis .grammar-correction { display: none; }
                    </style>
                    <div class="detailed-analysis p-6 overflow-y-auto flex-1 prose max-w-none leading-loose text-lg text-gray-800 selection:bg-blue-100">
                        
                        <!-- DEBUG BANNER -->
                        <div class="bg-red-600 text-white text-center font-bold p-2 mb-4 rounded">
                            DEBUG MODE ACTIVE v{{ time() }}
                        </div>

                        <!-- Loading Indicator -->
                        <div x-show="loading" class="mb-4 text-orange-500 flex items-center gap-2 animate-pulse">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="text-sm font-semibold">AI is analyzing your text...</span>
                        </div>

                        <!-- NUCLEAR OPTION: Inline sanitization -->
                        <div x-html="(() => {
                            try {
                                const html = result?.correction_html;
                                let isBad = false;
                                
                                if (!html) isBad = true;
                                if (html === 'undefined') isBad = true;
                                if (typeof html === 'string' && html.indexOf('undefined') !== -1) isBad = true;
                                if (html && html.length < 15) isBad = true;

                                if (isBad) {
                                    let content = essay;
                                    if (!content || content === 'undefined') content = 'Waiting for content...';
                                    return '<div class=\'bg-red-50 border-2 border-red-500 p-4 rounded\'><strong>FALLBACK TRIGGERED:</strong><br>' + content.replace(/\n/g, '<br>') + '</div>';
                                }
                                return html;
                            } catch (e) { return 'JS ERROR'; }
                        })()"></div>
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
                    <button @click="tab = 'vocab'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'vocab' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0 flex items-center gap-2">
                        <span>Vocabulary</span>
                        <span x-show="improving && !result?.vocabulary_improvements" class="animate-spin h-3 w-3 border-2 border-orange-500 border-t-transparent rounded-full"></span>
                    </button>
                    <button @click="tab = 'analysis'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'analysis' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Text Analysis</button>
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
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating detailed feedback...</p>
                            <p x-show="result?.feedback" class="text-gray-600 leading-relaxed" x-text="result?.feedback?.overall_comment"></p>
                        </div>
                    </div>

                    <!-- Tab 2: Task Response -->
                    <div x-show="tab === 'task_response'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Task Response Detailed Feedback</h5>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="result?.feedback" class="text-gray-600 text-sm" x-text="result?.feedback?.task_achievement"></p>
                        </div>
                    </div>

                    <!-- Tab 3: Coherence -->
                    <div x-show="tab === 'coherence'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Coherence Detailed Feedback</h5>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="result?.feedback" class="text-gray-600 text-sm" x-text="result?.feedback?.coherence_cohesion"></p>
                        </div>

                        <!-- Coherence Improvements -->
                        <div x-show="result?.feedback?.coherence_improvements?.length > 0">
                             <h4 class="font-bold text-gray-800 mb-3 mt-4 text-sm uppercase tracking-wide">Saran Penggunaan Conjunctions/Linking Words</h4>
                             <div class="space-y-3">
                                <template x-for="(item, idx) in result?.feedback?.coherence_improvements" :key="idx">
                                    <div class="bg-white p-3 rounded-lg border border-gray-100">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-red-500 line-through decoration-red-300 text-sm" x-text="item.text"></span>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                            <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded text-sm" x-text="item.improved"></span>
                                        </div>
                                        <p class="text-gray-500 text-xs italic" x-text="item.explanation"></p>
                                    </div>
                                </template>
                             </div>
                        </div>
                    </div>

                    <!-- Tab 4: Lexical -->
                    <div x-show="tab === 'lexical'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Lexical Detailed Feedback</h5>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="result?.feedback" class="text-gray-600 text-sm" x-text="result?.feedback?.lexical_resource"></p>
                        </div>
                    </div>

                    <!-- Tab 5: Grammar -->
                    <div x-show="tab === 'grammar'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Grammar Detailed Feedback</h5>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-show="result?.feedback" class="text-gray-600 text-sm" x-text="result?.feedback?.grammatical_range"></p>
                        </div>

                        <!-- Extracted Grammar List -->
                        <div x-show="getGrammarErrors().length > 0">
                            <h4 class="font-bold text-gray-800 mb-3 mt-4 text-sm uppercase tracking-wide">Perbaikan Grammar</h4>
                            <div class="space-y-2">
                                <template x-for="(item, idx) in getGrammarErrors()" :key="idx">
                                    <div class="bg-white p-3 rounded-lg border border-gray-100 flex flex-wrap items-center gap-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold" x-text="idx + 1"></span>
                                            <span class="text-red-500 line-through decoration-red-300" x-text="item.error"></span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded" x-text="item.correction || '(Remove)'"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Vocabulary -->
                    <div x-show="tab === 'vocab'" class="space-y-6">
                        <div x-show="result?.vocabulary_improvements?.length > 0">
                            <h4 class="font-bold text-gray-800 mb-3">Suggested Improvements</h4>
                            <div class="space-y-3">
                                <template x-for="item in result?.vocabulary_improvements">
                                    <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                        <div class="flex items-center gap-2 mb-1">
                                            <button type="button" @click.prevent="highlightInEssay(item.original)" class="text-red-500 line-through hover:opacity-90 cursor-pointer" x-text="item.original"></button>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                            <button type="button" class="text-green-600 font-bold" @click.prevent="highlightInEssay(item.improved)" x-text="item.improved"></button>
                                        </div>
                                        <p class="text-sm text-gray-600" x-text="item.explanation"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="result?.collocations?.length > 0">
                             <h4 class="font-bold text-gray-800 mb-3 border-t border-gray-200 pt-4">Relevant Collocations</h4>
                             <div class="flex flex-wrap gap-2">
                                <template x-for="col in result?.collocations">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium" x-text="col"></span>
                                </template>
                             </div>
                        </div>
                    </div>

                    <!-- Tab: Text Analysis -->
                    <div x-show="tab === 'analysis'" class="max-w-3xl mx-auto">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                             <div class="p-4 border-b border-gray-100 bg-indigo-50/50 flex justify-between items-center">
                                <h3 class="font-bold text-indigo-800">Detailed Text Analysis</h3>
                                <div class="flex items-center gap-3 text-xs font-medium">
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded">Error</span>
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Improvement</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Suggestion</span>
                                </div>
                            </div>
                            <div class="p-6 prose prose-indigo max-w-none leading-loose text-lg text-gray-800">
                                <div x-show="!result?.correction_html" class="text-gray-400 italic animate-pulse py-8 text-center">Analyzing text structure and grammar...</div>
                                <div x-html="safeHtml"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Better Version -->
                    <div x-show="tab === 'better'" class="prose max-w-none text-gray-700">
                        <div x-show="!result?.better_version && improving" class="flex flex-col items-center justify-center py-12 text-gray-400 animate-pulse">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <p>Crafting Band 9 Version...</p>
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
    @include('assignments.ielts.writing.practice_toolbar')
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

@if(auth()->check() && in_array(auth()->user()->role, ['student', 'guest']))
@php
    $crdtRoomId = 'ielts-writing:' . $meeting->id . ':task:' . (int) $task . ':user:' . auth()->id();
@endphp
<script type="module">
    import * as Y from 'https://esm.sh/yjs@13.6.18';
    import { WebsocketProvider } from 'https://esm.sh/y-websocket@1.5.3';

    const wsUrl = @json(env('CRDT_WS_URL', 'wss://demos.yjs.dev'));
    const roomId = @json($crdtRoomId);

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
    const provider = new WebsocketProvider(wsUrl, roomId, doc, { connect: true });
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

    yEssay.observe(() => {
        clearTimeout(applyTimer);
        applyTimer = setTimeout(syncTextareaFromY, 40);
    });

    textarea.addEventListener('input', () => {
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
