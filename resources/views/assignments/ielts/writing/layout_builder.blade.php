@extends('layouts.admin')

@push('scripts')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <script>
        // Fallback if AutoSave is not loaded
        window.AutoSave = window.AutoSave || {
            restore: () => '',
            save: () => {}
        };
    </script>
@endpush

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<style>
    @media (min-width: 1024px) {
        .dynamic-sidebar-left {
            left: var(--admin-sidebar-offset, var(--teacher-sidebar-offset, var(--student-sidebar-offset, var(--guest-sidebar-offset, 16rem)))) !important;
        }
    }
</style>
<div class="flex flex-col bg-gray-50 min-h-screen md:ml-0 lg:fixed lg:inset-y-0 lg:right-0 lg:overflow-hidden transition-all duration-200 dynamic-sidebar-left" 
     @resize.window="isLargeScreen = window.innerWidth >= 1024"
     @toggle-collocations.window="isCollocationsOpen = !isCollocationsOpen; if(isCollocationsOpen) isIdiomsOpen = false"
     @toggle-idioms.window="isIdiomsOpen = !isIdiomsOpen; if(isIdiomsOpen) isCollocationsOpen = false"
     x-data="{ 
        isLargeScreen: window.innerWidth >= 1024,
        isCollocationsOpen: false,
        isIdiomsOpen: false,
        idioms: {{ json_encode($meeting->idioms ?? []) }},
        collocations: {{ json_encode($meeting->collocations ?? []) }},
        mode: 'planning', 
        tab: 'feedback',
        form: {
            intro: '',
            conclusion: '',
            b1_a1: '', b1_a1_supp: '', b1_a1_ex: '',
            b1_a2: '', b1_a2_supp: '', b1_a2_ex: '',
            b2_a1: '', b2_a1_supp: '', b2_a1_ex: '',
            b2_a2: '', b2_a2_supp: '', b2_a2_ex: ''
        },
        loading: false,
        improving: false,
        essay: '',
        result: null,
        error: null,
        showResults: false,
        feedbackLoading: false,
        vocabLoading: false,
            showTopicVocab: false,
            showTopicGrammar: false,
        vocabError: null,
        vocabError: null,
        coherenceLoading: false,
        coherenceLoading: false,
        coherenceError: null,
        taskResponseLoading: false,
        taskResponseLoading: false,
        taskResponseError: null,
        grammarLoading: false,
        grammarError: null,

        extraParagraphs: [],
        time: {{ isset($meeting) && $meeting->category === 'practice_item' ? 300 : 0 }},
        timerType: '{{ isset($meeting) && $meeting->category === 'practice_item' ? 'countdown' : 'countup' }}',
        interval: null,
        
        // Split Screen Logic
        splitRatio: 50,
        draggingSplit: false,
        
        startResize(e) {
            this.draggingSplit = true;
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';
            
            const onMouseMove = (e) => {
                if (!this.draggingSplit) return;
                const container = this.$refs.splitContainer;
                if (!container) return;
                
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const percentage = (x / rect.width) * 100;
                
                // Constrain between 20% and 80%
                this.splitRatio = Math.max(20, Math.min(80, percentage));
            };
            
            const onMouseUp = () => {
                this.draggingSplit = false;
                document.body.style.cursor = '';
                document.body.style.userSelect = '';
                window.removeEventListener('mousemove', onMouseMove);
                window.removeEventListener('mouseup', onMouseUp);
            };
            
            window.addEventListener('mousemove', onMouseMove);
            window.addEventListener('mouseup', onMouseUp);
        },

        init() {
            const key = 'ielts_task2_autosave_' + {{ $meeting->id }};
            
            // Restore
            const saved = localStorage.getItem(key);
            if (saved) {
                try {
                    const data = JSON.parse(saved);
                    // Safe merge
                    if (data.form) this.form = { ...this.form, ...data.form };
                    if (data.extraParagraphs) this.extraParagraphs = data.extraParagraphs;
                    if (data.essay) this.essay = data.essay;
                } catch (e) {
                    console.error('Autosave Restore Error:', e);
                }
            }
            
            // Start Timer
            this.interval = setInterval(() => { 
                if (this.timerType === 'countdown') {
                    this.time--;
                } else {
                    this.time++; 
                }
            }, 1000);

            // Watch & Save
            const saver = () => {
                localStorage.setItem(key, JSON.stringify({
                    form: this.form,
                    extraParagraphs: this.extraParagraphs,
                    essay: this.essay
                }));
            };

            this.$watch('form', saver); 
            this.$watch('extraParagraphs', saver);
            this.$watch('essay', saver);
        },

        addParagraph() {
            this.extraParagraphs.push({
                id: Date.now(),
                a1: '', a1_supp: '', a1_ex: '',
                a2: '', a2_supp: '', a2_ex: ''
            });
            // Scroll to bottom after adding
            setTimeout(() => {
                const container = document.querySelector('.overflow-y-auto');
                if (container) container.scrollTop = container.scrollHeight;
            }, 100);
        },

        removeParagraph(index) {
            if (confirm('Are you sure you want to remove this paragraph?')) {
                this.extraParagraphs.splice(index, 1);
            }
        },
        
        async submitEssay() {
            if (this.essay.trim().length < 50) {
                alert('Please write at least 50 characters.');
                return;
            }
            
            this.loading = true;
            this.error = null;
            this.result = null;
            
            try {
                // STAGE 1: Evaluation (Scores Only)
                const response = await fetch('{{ route('assignments.ielts.writing.evaluate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });
                
                if (!response.ok) {
                    let errMessage = 'Evaluation failed. Server returned ' + response.status;
                    try {
                        const errData = await response.json();
                        if (errData.error) errMessage = errData.error;
                    } catch (err) {}
                    throw new Error(errMessage);
                }
                
                const data = await response.json();
                this.result = data;
                this.showResults = true;
                
                // STAGE 2: Get Correction (Separate Call)
                this.getCorrection();

                // STAGE 3: Get Feedback (Separate Call)
                this.getFeedback();

                // STAGE 4: Improvement (Background)
                this.improveEssay();
                
            } catch (e) {
                console.error(e);
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        },

        async getFeedback() {
            this.feedbackLoading = true;
            try {
                const response = await fetch('{{ route('assignments.ielts.writing.feedback') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    
                    // Merge into result
                    if (data.feedback) {
                        this.result = { 
                            ...this.result, 
                            feedback: { ...(this.result.feedback || {}), ...data.feedback },
                            grammar_improvements: data.feedback.grammar_improvements || this.result.grammar_improvements,
                            cohesive_devices_used: data.feedback.cohesive_devices_used || this.result.cohesive_devices_used
                        };
                    }
                } else {
                    let errMessage = 'Feedback request failed with status ' + response.status;
                    try {
                        const errData = await response.json();
                        if (errData.error) errMessage = errData.error;
                    } catch (err) {}
                    throw new Error(errMessage);
                }
            } catch (e) {
                console.error('Feedback stage failed:', e);
                this.error = 'Feedback Error: ' + e.message;
            } finally {
                this.feedbackLoading = false;
            }
        },

        async getCorrection() {
            try {
                const response = await fetch('{{ route('assignments.ielts.writing.correct') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    
                    let finalHtml = data.correction_html;
                    
                    // Sanitize 'undefined' string
                    if (!finalHtml || finalHtml === 'undefined' || (typeof finalHtml === 'string' && finalHtml.includes('undefined'))) {
                         finalHtml = '';
                    }

                    // Fallback to original essay if valid correction is missing
                    if (!finalHtml || finalHtml.length < 20) {
                        finalHtml = '<p>' + this.essay.replace(/\n/g, '<br>') + '</p>';
                    }

                    // Merge into result
                    this.result = { ...this.result, correction_html: finalHtml };
                }
            } catch (e) {
                console.error('Correction failed:', e);
                this.error = 'Correction Error: ' + e.message;
                // Fallback on error
                this.result = { 
                    ...this.result, 
                    correction_html: '<p>' + this.essay.replace(/\n/g, '<br>') + '</p>' 
                };
            }
        },

        async improveEssay() {
            this.improving = true;
            
            try {
                const response = await fetch('{{ route('assignments.ielts.writing.improve') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    // Merge new data into existing result
                    this.result = { ...this.result, ...data };
                }
            } catch (e) {
                console.error('Improvement stage failed:', e);
            } finally {
                this.improving = false;
            }
        },

        async getVocabulary() {
            this.vocabLoading = true;
            this.vocabError = null;
            
            try {
                const response = await fetch('{{ route('assignments.ielts.writing.vocabulary') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.lexical_improvements || data.topic_vocabularies) {
                        this.result = { 
                            ...this.result, 
                            lexical_improvements: data.lexical_improvements || this.result?.lexical_improvements,
                            topic_vocabularies: data.topic_vocabularies || this.result?.topic_vocabularies
                        };
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

        async getCoherence() {
            this.coherenceLoading = true;
            this.coherenceError = null;
            
            try {
                const response = await fetch('{{ route('assignments.ielts.writing.coherence') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.coherence_improvements) {
                        this.result = { 
                            ...this.result, 
                            coherence_improvements: data.coherence_improvements 
                        };
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
        },

        async getTaskResponse() {
            this.taskResponseLoading = true;
            this.taskResponseError = null;
            
            try {
                const response = await fetch('{{ route('assignments.ielts.writing.task_response') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.task_response_improvements) {
                        this.result = { 
                            ...this.result, 
                            task_response_improvements: data.task_response_improvements 
                        };
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

        async getGrammar() {
            this.grammarLoading = true;
            this.grammarError = null;
            
            try {
                const response = await fetch('{{ route('assignments.ielts.writing.grammar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        essay: this.essay,
                        task_type: '{{ $task }}'
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.grammar_improvements || data.topic_grammar) {
                        this.result = { 
                            ...this.result, 
                            grammar_improvements: data.grammar_improvements || this.result?.grammar_improvements,
                            topic_grammar: data.topic_grammar || this.result?.topic_grammar
                        };
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
        }
     }">
    <!-- Header -->
    <div x-show="!showResults" class="flex items-center justify-between mb-6 px-6 pt-6">
        <div class="flex items-center gap-3">
            <a href="{{ $backUrl ?? route('assignments.ielts-academic.writing.practice.index') }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-orange-600 tracking-wider uppercase">IELTS Writing Task {{ $task }}</span>
                <h1 class="text-2xl font-bold text-gray-800" x-text="mode === 'planning' ? 'Essay Layout Builder' : 'Writing Practice'"></h1>
            </div>
        </div>
        
        <div class="flex gap-4">

             <div class="px-4 py-2 rounded-lg font-mono font-medium flex items-center transition-colors duration-300"
                  :class="time < 0 ? 'bg-red-50 text-red-600 font-bold' : 'bg-blue-50 text-blue-600'">
                <span x-text="(time < 0 ? '-' : '') + new Date(Math.abs(time) * 1000).toISOString().substr(11, 8)">00:00:00</span>
             </div>
             <button x-show="mode === 'planning'" @click="mode = 'writing'; if(timerType === 'countdown') time = 2400;" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 transition-colors flex items-center">
                <span>Start Writing</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
             </button>
             <button x-show="mode === 'writing'" @click="mode = 'planning'" class="px-6 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition-colors">
                Back to Plan
             </button>
             <button type="button" x-show="mode === 'writing'" @click.prevent="submitEssay()" :disabled="loading" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2">
                <span x-show="!loading">Submit Essay</span>
                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                <span x-show="loading">Evaluating...</span>
             </button>
        </div>

    </div>



    <!-- Error Alert -->
    <div x-show="error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-700" style="display: none;">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <span class="font-bold">Evaluation Failed:</span>
            <span x-text="error"></span>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div x-show="loading" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-[60] flex flex-col items-center justify-center backdrop-blur-sm" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white p-8 rounded-2xl shadow-2xl flex flex-col items-center animate-bounce-slight max-w-sm w-full mx-4 text-center">
            <div class="relative mb-4">
                <div class="animate-spin rounded-full h-16 w-16 border-4 border-orange-200 border-t-orange-600"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800 animate-pulse mb-2">TUNGGU, SEDANG DIPROSES</h3>
            <p class="text-gray-500 text-sm">AI sedang menganalisis esai Anda...</p>
        </div>
    </div>


    <!-- Main Content -->
    <div x-show="!showResults" 
         x-ref="splitContainer"
         class="flex flex-col lg:flex-row flex-1 min-h-0 relative bg-gray-50/50"
         x-data>
        <!-- Left Column -->
        <div class="flex flex-col h-full min-w-0 min-h-0 border-r border-gray-200 transition-none lg:overflow-hidden relative"
             :style="isLargeScreen ? 'width: ' + splitRatio + '%' : ''">
            
            <!-- Fixed Header: Question Prompt Card -->
            <div class="flex-none p-4 pb-0 z-10 bg-gray-50">
               <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-h-[35vh] overflow-y-auto custom-scrollbar">
                    <div class="flex justify-between items-center mb-4 sticky top-0 bg-white z-10">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-gray-800 text-lg">Essay Topic</h3>
                            @if(Auth::user()->role === 'admin')
                            <button @click="$dispatch('open-edit-prompt-modal')" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded hover:bg-yellow-200">
                                Edit
                            </button>
                            @endif
                        </div>
                        <span class="px-2 py-1 bg-gray-100 text-gray-500 text-xs rounded-md">Task {{ $task }}</span>
                    </div>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        <div class="italic">"{!! $meeting->prompt ?? 'Discuss the advantages and disadvantages...' !!}"</div>
                    </div>
               </div>
            </div>

            <!-- Scrollable Content Area (Both Modes) -->
            <div class="flex-1 relative overflow-y-auto p-4 pb-32 space-y-6 custom-scrollbar min-h-0 max-h-full">
            
                <!-- Planning Mode -->
                <div x-show="mode === 'planning'" class="space-y-6">
                 @if($meeting->category !== 'practice_item')
                 <div class="prose max-w-none text-gray-600 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-gray-800">Cara Menggunakan Pembuat Layout Ini</h3>
                    <p>Fokus pada pengembangan argumen dalam paragraf utama Anda.</p>
                    <ul>
                        <li><strong>Paragraf Utama:</strong> Sertakan dua argumen kuat untuk mendukung ide utama Anda, masing-each diikuti dengan contoh relevan.</li>
                    </ul>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="p-1 bg-indigo-100 rounded text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Cara Membuat Conclusion Paragraph
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Conclusion Paragraph pada dasarnya adalah <strong>paraphrase</strong> dari Introduction paragraph.
                        </p>

                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100 text-base space-y-3 not-prose shadow-sm relative overflow-hidden">
                            <!-- Decorative background element -->
                            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-white opacity-20 transform rotate-45 rounded-full pointer-events-none"></div>

                            <div class="flex items-center gap-2 mb-2 relative z-10">
                                <span class="px-2 py-1 bg-white text-indigo-700 text-xs font-bold rounded border border-indigo-100 shadow-sm">Type</span>
                                <span class="text-indigo-900 font-medium text-sm">Discuss Both Views and Give Your Opinion</span>
                            </div>

                            <div>
                                <p class="font-bold text-gray-700 mb-1 text-xs uppercase tracking-wide">Soal Asli:</p>
                                <div class="bg-white/80 p-3 rounded-lg border border-indigo-50/50 text-gray-700 italic text-sm font-serif">
                                    "Some people believe that university education should focus on job skills, while others think it should provide knowledge for its own sake."
                                </div>
                            </div>

                            <div>
                                <p class="font-bold text-gray-700 mb-1 text-xs uppercase tracking-wide">Introduction (Recap):</p>
                                <div class="bg-white/80 p-3 rounded-lg border border-indigo-50/50 text-gray-700 text-sm">
                                    "People hold different views about whether universities should prioritize job-related skills or general knowledge. While practical skills are crucial for employment, broad education also plays an essential role in personal growth."
                                </div>
                            </div>

                            <div>
                                <p class="font-bold text-blue-700 mb-1 text-xs uppercase tracking-wide">Conclusion (Paraphrase + Opinion):</p>
                                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 text-gray-800 font-medium text-base leading-relaxed">
                                    "In conclusion, although focusing on job-oriented training prepares students for immediate employment, offering a broader education helps them develop critical thinking and adaptability. Personally, I believe universities should strike a balance between both approaches to meet the needs of modern society."
                                </div>
                                <p class="mt-2 text-sm text-blue-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Paraphrase isi & restate opinion clearly.
                                </p>
                            </div>
                        </div>
                    </div>
                 </div>
                 @endif
             </div>

             <!-- Writing Mode: Reference Plan -->
             <div x-show="mode === 'writing'" class="flex-1 overflow-y-auto p-4 space-y-6 custom-scrollbar">
                <h3 class="font-bold text-gray-800 text-lg border-b pb-2">Rencana Anda (Layout)</h3>
                
                <!-- Introduction Plan -->
                <!-- Introduction Plan -->
                @if($meeting->category !== 'practice_item')
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-3">Introduction</h4>
                    <p class="text-sm text-gray-700 whitespace-pre-line" x-show="form.intro" x-text="form.intro"></p>
                    <p class="text-sm text-gray-400 italic" x-show="!form.intro">Belum ada pendahuluan...</p>
                </div>
                @endif

                <!-- Body 1 Preview -->
                 <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                    <div class="flex items-center gap-2 mb-3">
                         <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">1</div>
                         <h4 class="font-bold text-blue-800">Rencana Paragraf 1</h4>
                    </div>
                    <div class="space-y-3 pl-8">
                        <div x-show="form.b1_a1" class="pt-2 border-t border-blue-200 first:border-0 first:pt-0">
                            <span class="font-semibold text-blue-700 block">Argumen 1:</span>
                            <p class="text-gray-700" x-text="form.b1_a1"></p>
                            <p class="text-gray-600 italic mt-1" x-show="form.b1_a1_supp" x-text="'Ide Pendukung: ' + form.b1_a1_supp"></p>
                            <p class="text-gray-500 mt-1" x-show="form.b1_a1_ex" x-text="'Contoh: ' + form.b1_a1_ex"></p>
                        </div>
                        <div x-show="form.b1_a2" class="pt-2 border-t border-blue-200">
                            <span class="font-semibold text-blue-700 block">Argumen 2:</span>
                            <p class="text-gray-700" x-text="form.b1_a2"></p>
                            <p class="text-gray-600 italic mt-1" x-show="form.b1_a2_supp" x-text="'Ide Pendukung: ' + form.b1_a2_supp"></p>
                            <p class="text-gray-500 mt-1" x-show="form.b1_a2_ex" x-text="'Contoh: ' + form.b1_a2_ex"></p>
                        </div>
                    </div>
                </div>

                 <!-- Body 2 Preview -->
                 <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                    <div class="flex items-center gap-2 mb-3">
                         <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs">2</div>
                         <h4 class="font-bold text-orange-800">Rencana Paragraf 2</h4>
                    </div>
                     <div class="space-y-3 pl-8">
                        <div x-show="form.b2_a1" class="pt-2 border-t border-orange-200 first:border-0 first:pt-0">
                            <span class="font-semibold text-orange-600 block">Argumen 1:</span>
                            <p class="text-gray-700" x-text="form.b2_a1"></p>
                            <p class="text-gray-600 italic mt-1" x-show="form.b2_a1_supp" x-text="'Ide Pendukung: ' + form.b2_a1_supp"></p>
                            <p class="text-gray-500 mt-1" x-show="form.b2_a1_ex" x-text="'Contoh: ' + form.b2_a1_ex"></p>
                        </div>
                        <div x-show="form.b2_a2" class="pt-2 border-t border-orange-200">
                            <span class="font-semibold text-orange-600 block">Argumen 2:</span>
                            <p class="text-gray-700" x-text="form.b2_a2"></p>
                            <p class="text-gray-600 italic mt-1" x-show="form.b2_a2_supp" x-text="'Ide Pendukung: ' + form.b2_a2_supp"></p>
                            <p class="text-gray-500 mt-1" x-show="form.b2_a2_ex" x-text="'Contoh: ' + form.b2_a2_ex"></p>
                        </div>
                        </div>
                    </div>

                <!-- Extra Paragraphs Preview (Dynamic) -->
                <template x-for="(para, index) in extraParagraphs" :key="para.id">
                    <div class="bg-green-50 rounded-xl p-5 border border-green-100 mt-4">
                        <div class="flex items-center gap-2 mb-3">
                             <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xs" x-text="index + 3"></div>
                             <h4 class="font-bold text-green-800" x-text="'Rencana Paragraf ' + (index + 3)"></h4>
                        </div>
                        <div class="space-y-3 pl-8">
                            <div x-show="para.a1" class="pt-2 border-t border-green-200 first:border-0 first:pt-0">
                                <span class="font-semibold text-green-700 block">Argumen 1:</span>
                                <p class="text-gray-700" x-text="para.a1"></p>
                                <p class="text-gray-600 italic mt-1" x-show="para.a1_supp" x-text="'Ide Pendukung: ' + para.a1_supp"></p>
                                <p class="text-gray-500 mt-1" x-show="para.a1_ex" x-text="'Contoh: ' + para.a1_ex"></p>
                            </div>
                            <div x-show="para.a2" class="pt-2 border-t border-green-200">
                                <span class="font-semibold text-green-700 block">Argumen 2:</span>
                                <p class="text-gray-700" x-text="para.a2"></p>
                                <p class="text-gray-600 italic mt-1" x-show="para.a2_supp" x-text="'Ide Pendukung: ' + para.a2_supp"></p>
                                <p class="text-gray-500 mt-1" x-show="para.a2_ex" x-text="'Contoh: ' + para.a2_ex"></p>
                            </div>
                        </div>
                    </div>
                </template>

                 <!-- Conclusion Plan -->
                 <!-- Conclusion Plan -->
                 @if($meeting->category !== 'practice_item')
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mt-4">
                    <h4 class="font-bold text-gray-800 mb-3">Conclusion</h4>
                    <p class="text-sm text-gray-700 whitespace-pre-line" x-show="form.conclusion" x-text="form.conclusion"></p>
                    <p class="text-sm text-gray-400 italic" x-show="!form.conclusion">Belum ada kesimpulan...</p>
                </div>
                @endif
             </div>
        </div>
        </div>

        <!-- Draggable Divider -->
        <div class="hidden lg:flex w-1 hover:bg-blue-500 cursor-col-resize items-center justify-center transition-colors group z-10 hover:w-2 -ml-1 -mr-1"
             @mousedown.prevent="startResize($event)">
            <div class="h-8 w-1 bg-gray-300 rounded-full group-hover:bg-white transition-colors pointer-events-none"></div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col h-auto lg:h-full min-w-0 transition-none lg:overflow-hidden"
             :style="isLargeScreen ? 'width: calc(' + (100 - splitRatio) + '% - 2px);' : ''">
             
             <div class="flex-1 overflow-visible lg:overflow-y-auto px-4 pb-32 space-y-8 custom-scrollbar">
            
            <!-- Planning Mode: Builder Inputs -->
            <div x-show="mode === 'planning'" class="space-y-8">
                <!-- Introduction -->
                <!-- Introduction -->
                @if($meeting->category !== 'practice_item')
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-gray-500 p-6 relative group hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-gray-700">Introduction</h3>
                        <span class="text-xs text-gray-400">~30-50 kata</span>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Introduction Text</label>
                            <textarea x-model="form.intro" class="w-full p-3 bg-white rounded border-gray-200 focus:border-gray-300 focus:ring-0 text-sm resize-none" rows="4" placeholder="Tuliskan pendahuluan Anda di sini (Paraphrase Topic + Thesis Statement)..."></textarea>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Body 1 -->
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-6 relative group hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-blue-700">Paragraf Utama 1</h3>
                        <span class="text-xs text-gray-400">~90-100 kata</span>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Argument 1 -->
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-blue-600 uppercase mb-1">Argumen 1</label>
                            <input x-model="form.b1_a1" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-blue-500 text-sm" placeholder="Poin utama pertama...">
                            <textarea x-model="form.b1_a1_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-blue-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung (Penjelasan)..."></textarea>
                            <textarea x-model="form.b1_a1_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-blue-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh untuk Argumen 1..."></textarea>
                        </div>

                        <!-- Argument 2 -->
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-blue-600 uppercase mb-1">Argumen 2</label>
                            <input x-model="form.b1_a2" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-blue-500 text-sm" placeholder="Poin utama kedua...">
                            <textarea x-model="form.b1_a2_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-blue-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung (Penjelasan)..."></textarea>
                            <textarea x-model="form.b1_a2_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-blue-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh untuk Argumen 2..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Body 2 -->
                 <div class="bg-white rounded-xl shadow-sm border-l-4 border-orange-500 p-6 relative group hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-orange-700">Paragraf Utama 2</h3>
                        <span class="text-xs text-gray-400">~90-100 kata</span>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Argument 1 -->
                        <div class="bg-orange-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-orange-600 uppercase mb-1">Argumen 1</label>
                            <input x-model="form.b2_a1" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-orange-500 text-sm" placeholder="Poin utama pertama...">
                            <textarea x-model="form.b2_a1_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-orange-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung (Penjelasan)..."></textarea>
                            <textarea x-model="form.b2_a1_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-orange-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh untuk Argumen 1..."></textarea>
                        </div>

                        <!-- Argument 2 -->
                        <div class="bg-orange-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-orange-600 uppercase mb-1">Argumen 2</label>
                            <input x-model="form.b2_a2" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-orange-500 text-sm" placeholder="Poin utama kedua...">
                            <textarea x-model="form.b2_a2_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-orange-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung (Penjelasan)..."></textarea>
                            <textarea x-model="form.b2_a2_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-orange-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh untuk Argumen 2..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Extra Paragraphs (Dynamic) -->
                <template x-for="(para, index) in extraParagraphs" :key="para.id">
                    <div class="bg-white rounded-xl shadow-sm border-l-4 border-green-500 p-6 relative group hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-xl text-green-700" x-text="'Paragraf Tambahan ' + (index + 1)"></h3>
                            <button @click="removeParagraph(index)" class="text-red-500 hover:text-red-700 text-xs font-bold uppercase">Hapus</button>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Argument 1 -->
                            <div class="bg-green-50 p-3 rounded-lg">
                                <label class="block text-xs font-bold text-green-600 uppercase mb-1">Argumen 1</label>
                                <input x-model="para.a1" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-green-500 text-sm" placeholder="Poin utama...">
                                <textarea x-model="para.a1_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-green-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung..."></textarea>
                                <textarea x-model="para.a1_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-green-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh..."></textarea>
                            </div>

                            <!-- Argument 2 -->
                            <div class="bg-green-50 p-3 rounded-lg">
                                <label class="block text-xs font-bold text-green-600 uppercase mb-1">Argumen 2</label>
                                <input x-model="para.a2" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-green-500 text-sm" placeholder="Poin utama kedua...">
                                <textarea x-model="para.a2_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-green-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung..."></textarea>
                                <textarea x-model="para.a2_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-green-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh..."></textarea>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Add Paragraph Button -->
                @if($meeting->id != 1)
                <button @click="addParagraph()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 font-bold hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Paragraf
                </button>
                @endif

                 <!-- Conclusion -->
                 <!-- Conclusion -->
                 @if($meeting->category !== 'practice_item')
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-gray-700 p-6 relative group hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-gray-700">Conclusion</h3>
                        <span class="text-xs text-gray-400">~30-50 kata</span>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Conclusion Text</label>
                            <textarea x-model="form.conclusion" class="w-full p-3 bg-white rounded border-gray-200 focus:border-gray-300 focus:ring-0 text-sm resize-none" rows="4" placeholder="Tuliskan kesimpulan Anda di sini (Restate Thesis + Summary)..."></textarea>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Writing Mode: Textareas -->
            <div x-show="mode === 'writing'" class="h-full flex flex-col min-h-0">
                <div class="flex-1 bg-white rounded-xl shadow-sm border border-blue-200 flex flex-col relative overflow-hidden h-full">
                    <!-- Sticky Header -->
                    <div class="flex-none bg-white/95 backdrop-blur z-20 py-3 border-b border-blue-100 px-4">
                        <div class="flex justify-between items-center">
                            <h3 class="font-bold text-blue-700">Penulisan Esai</h3>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-full shadow-sm" 
                                      x-text="(essay ? essay.trim().split(/\s+/).filter(w => /[A-Za-z]/.test(w)).length : 0) + ' Words'">
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Scrollable Textarea Container -->
                    <div class="flex-1 relative min-h-0 overflow-y-auto custom-scrollbar">
                        <textarea x-model="essay" 
                                  x-ref="writingArea"
                                  @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                  x-init="$watch('essay', () => { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px' }); $nextTick(() => { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px' })"
                                  class="block w-full min-h-full h-auto p-4 bg-gray-50 border-none resize-none font-serif text-lg leading-relaxed focus:ring-0 focus:bg-white transition-colors overflow-hidden" 
                                  placeholder="Tuliskan kedua paragraf tubuh Anda di sini... Gunakan argumen dan ide pendukung yang telah Anda susun."></textarea>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
    <!-- Result UI continues here inside the main scope -->
    
    <!-- RESULT MODE (FULL PAGE) -->
    <div x-show="showResults" class="flex flex-col flex-1 w-full overflow-hidden p-6" style="display: none;">
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
            <div x-show="result" class="flex gap-4">
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
                    <div class="text-gray-600 text-sm leading-relaxed">{!! $meeting->prompt !!}</div>
                </div>

                <!-- Analysis Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1 min-h-0">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Detailed Text Analysis</h3>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <span class="bg-red-100 text-red-600 line-through px-1 rounded">Error</span>
                            <span class="text-green-600 font-bold px-1">Correction</span>
                            <span class="bg-yellow-200 text-gray-800 px-2 py-0.5 rounded">Improvement</span>
                        </div>
                    </div>
                    <!-- Correction Content -->
                    <div class="p-6 overflow-y-auto flex-1 prose max-w-none leading-loose text-lg text-gray-800 selection:bg-blue-100">
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
            <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden flex flex-col h-full min-h-0">
                <!-- Tabs -->
                <div class="flex border-b border-gray-200 bg-white overflow-x-auto no-scrollbar">
                    <button @click="tab = 'feedback'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'feedback' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Examiner Feedback</button>
                    <button @click="tab = 'task_response'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'task_response' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Task Response</button>
                    <button @click="tab = 'coherence'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'coherence' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Coherence</button>
                    <button @click="tab = 'lexical'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'lexical' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Lexical</button>
                    <button @click="tab = 'grammar'" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'grammar' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0">Grammar</button>

                    <button @click="tab = 'better'; if(!result?.better_version && !improving) improveEssay()" :class="{ 'border-b-2 border-orange-500 text-orange-600': tab === 'better' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-orange-500 transition-colors whitespace-nowrap flex-shrink-0 flex items-center gap-2">
                        <span>Band 9 Version</span>
                        <span x-show="improving && !result?.better_version" class="animate-spin h-3 w-3 border-2 border-orange-500 border-t-transparent rounded-full"></span>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <!-- Tab 1: General Feedback -->
                    <div x-show="tab === 'feedback'" class="space-y-4">
                        <!-- Loading State -->
                        <div x-show="feedbackLoading" class="min-h-[150px] flex flex-col items-center justify-center text-orange-600 animate-pulse bg-white rounded-xl border border-gray-100 p-8">
                            <div class="animate-spin h-8 w-8 border-4 border-orange-500 border-t-transparent rounded-full mb-4"></div>
                            <span class="text-sm font-bold tracking-wide uppercase">Generating Examiner Feedback...</span>
                        </div>

                        <div x-show="!feedbackLoading && result?.feedback" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-2">General Comments</h5>
                            <p class="text-gray-600 leading-relaxed" x-text="result?.feedback?.overall_comment"></p>
                        </div>
                    </div>

                    <!-- Tab 2: Task Response -->
                    <div x-show="tab === 'task_response'" class="space-y-4">
                        <!-- Loading State -->
                        <div x-show="feedbackLoading" class="min-h-[150px] flex flex-col items-center justify-center text-green-600 animate-pulse bg-white rounded-xl border border-gray-100 p-8">
                            <div class="animate-spin h-8 w-8 border-4 border-green-500 border-t-transparent rounded-full mb-4"></div>
                            <span class="text-sm font-bold tracking-wide uppercase">Generating Task Response Feedback...</span>
                        </div>

                        <div x-show="!feedbackLoading" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Task Response Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.task_achievement"></p>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Action Button -->
                                <div x-show="!taskResponseLoading">
                                    <button @click="getTaskResponse()" class="w-full py-3 bg-green-50 text-green-700 font-bold rounded-lg border border-green-100 hover:bg-green-100 transition-colors flex items-center justify-center gap-2">
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
                                        <template x-for="item in result?.task_response_improvements || []" :key="item.text">
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
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Coherence -->
                    <div x-show="tab === 'coherence'" class="space-y-4">
                        <!-- Loading State -->
                        <div x-show="feedbackLoading" class="min-h-[150px] flex flex-col items-center justify-center text-blue-600 animate-pulse bg-white rounded-xl border border-gray-100 p-8">
                            <div class="animate-spin h-8 w-8 border-4 border-blue-500 border-t-transparent rounded-full mb-4"></div>
                            <span class="text-sm font-bold tracking-wide uppercase">Generating Coherence Feedback...</span>
                        </div>

                        <div x-show="!feedbackLoading" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Coherence Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.coherence_cohesion"></p>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Action Button -->
                                <div x-show="!coherenceLoading">
                                    <button @click="getCoherence()" class="w-full py-3 bg-blue-50 text-blue-700 font-bold rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        <span x-text="result?.coherence_improvements ? 'Re-Analyze & Upgrade Coherence (Band 7-9)' : 'Analyze & Upgrade Coherence (Band 7-9)'"></span>
                                    </button>
                                </div>

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
                                <div x-show="result?.coherence_improvements?.length > 0" class="space-y-4">
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
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Lexical -->
                    <div x-show="tab === 'lexical'" class="space-y-4">
                        <!-- Loading State -->
                        <div x-show="feedbackLoading" class="min-h-[150px] flex flex-col items-center justify-center text-purple-600 animate-pulse bg-white rounded-xl border border-gray-100 p-8">
                            <div class="animate-spin h-8 w-8 border-4 border-purple-500 border-t-transparent rounded-full mb-4"></div>
                            <span class="text-sm font-bold tracking-wide uppercase">Generating Lexical Feedback...</span>
                        </div>

                        <div x-show="!feedbackLoading" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Lexical Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.lexical_resource"></p>
                            
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Action Button -->
                                <div x-show="!vocabLoading" class="mb-4">
                                    <button @click="getVocabulary()" class="w-full py-3 bg-purple-50 text-purple-700 font-bold rounded-lg border border-purple-100 hover:bg-purple-100 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        <span x-text="result?.lexical_improvements ? 'Re-Analyze & Upgrade Vocabulary (Band 7-9)' : 'Analyze & Upgrade Vocabulary (Band 7-9)'"></span>
                                    </button>
                                </div>

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
                                <div x-show="result?.lexical_improvements?.length > 0" class="space-y-4">
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
                                    
                                    <!-- Better Vocabularies Section (New Feature) -->
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <button @click="showTopicVocab = !showTopicVocab" class="w-full py-2 bg-purple-100 text-purple-700 font-bold rounded-lg hover:bg-purple-200 transition-colors flex items-center justify-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            Better Vocabularies & Collocation
                                        </button>

                                        <div x-show="showTopicVocab" class="mt-4 space-y-3" x-transition>
                                            <template x-for="vocab in result?.topic_vocabularies || []" :key="vocab.term">
                                                <div class="bg-white p-3 rounded-lg border border-purple-100 shadow-sm">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold text-purple-800 text-sm" x-text="vocab.term"></span>
                                                        <span class="text-xs px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full">Topic Word</span>
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
                            </div>
                        </div>
                    </div>

                    <!-- Tab 5: Grammar -->
                    <div x-show="tab === 'grammar'" class="space-y-4">
                        <!-- Loading State -->
                        <div x-show="feedbackLoading" class="min-h-[150px] flex flex-col items-center justify-center text-purple-600 animate-pulse bg-white rounded-xl border border-gray-100 p-8">
                            <div class="animate-spin h-8 w-8 border-4 border-purple-500 border-t-transparent rounded-full mb-4"></div>
                            <span class="text-sm font-bold tracking-wide uppercase">Generating Grammar Feedback...</span>
                        </div>

                        <div x-show="!feedbackLoading" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Grammar Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.grammatical_range"></p>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <!-- Action Button -->
                                <!-- Action Button -->
                                <div x-show="!grammarLoading" class="mb-4">
                                    <button @click="getGrammar()" class="w-full py-3 bg-purple-50 text-purple-700 font-bold rounded-lg border border-purple-100 hover:bg-purple-100 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        <span x-text="result?.grammar_improvements ? 'Re-Analyze & Upgrade Grammar (Band 7-9)' : 'Analyze & Upgrade Grammar (Band 7-9)'"></span>
                                    </button>
                                </div>

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
                                <div x-show="result?.grammar_improvements?.length > 0" class="space-y-4">
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
                                                        <p class="text-red-700 text-sm italic line-clamp-2" x-text="item.text"></p>
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
                                </div>

                                <!-- TOPIC GRAMMAR SECTION -->
                                <div class="mt-8 pt-6 border-t border-purple-100" x-show="result?.topic_grammar?.length > 0">
                                    <button @click="showTopicGrammar = !showTopicGrammar" class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-white rounded-xl border border-purple-100 hover:shadow-md transition-all group">
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
    <!-- Admin Prompt Edit Modal -->
    @if(Auth::user()->role === 'admin')
    <div x-data="{ 
        showPromptModal: false, 
        init() {
            window.addEventListener('open-edit-prompt-modal', () => { this.showPromptModal = true });
        }
    }">
        <div x-show="showPromptModal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-2xl" @click.away="showPromptModal = false">
                <h3 class="text-xl font-bold mb-4">Edit Essay Topic</h3>
                <form action="{{ route('assignments.ielts.writing.update', $meeting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="title" value="{{ $meeting->title ?? 'Title' }}">
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Prompt / Topic</label>
                        <textarea name="prompt" class="w-full border p-2 rounded h-32" required>{{ $meeting->prompt }}</textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showPromptModal = false" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif


@endsection

@section('scripts')
<script>
    const AutoSave = {
        storageKey: 'ielts_writing_layout_builder_task_{{ $task }}_meeting_{{ $meeting->id }}_{{ Auth::id() }}',
        
        save(content) {
            if (!content) return;
            try {
                localStorage.setItem(this.storageKey, content);
                this.showIndicator();
            } catch (e) {
                console.error('Autosave failed:', e);
            }
        },

        restore() {
            return localStorage.getItem(this.storageKey);
        },

        showIndicator() {
            let indicator = document.getElementById('autosave-indicator');
            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'autosave-indicator';
                indicator.className = 'fixed bottom-4 left-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium transition-opacity duration-300';
                document.body.appendChild(indicator);
            }
            
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            indicator.innerHTML = `✓ Tersimpan ${timeStr}`;
            indicator.style.opacity = '1';

            if (this.timeout) clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                indicator.style.opacity = '0.5';
            }, 2000);
        }
    };
</script>
@endsection
