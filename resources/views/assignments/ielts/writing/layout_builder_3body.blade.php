@extends('layouts.admin')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8 h-[calc(100vh-4rem)] flex flex-col overflow-hidden" 
     x-data="{ 
        mode: 'planning', 
        form: {
            intro: '',
            b1_a1: '', b1_a1_supp: '', b1_a1_ex: '',
            b2_a1: '', b2_a1_supp: '', b2_a1_ex: '',
            b3_a1: '', b3_a1_supp: '', b3_a1_ex: ''
        },
        loading: false,
        improving: false,
        essay: '',
        result: null,
        error: null,
        showResults: false,
        
        init() {
            const key = 'ielts_task2_3body_autosave_' + {{ $meeting->id }};
            
            // Restore
            const saved = localStorage.getItem(key);
            if (saved) {
                try {
                    const data = JSON.parse(saved);
                    if (data.form) this.form = { ...this.form, ...data.form };
                    if (data.essay) this.essay = data.essay;
                } catch (e) {
                    console.error('Autosave Restore Error:', e);
                }
            }

            // Watch & Save
            const saver = () => {
                localStorage.setItem(key, JSON.stringify({
                    form: this.form,
                    essay: this.essay
                }));
            };

            this.$watch('form', saver);
            this.$watch('essay', saver);
        },

        refreshEssay() {
            if (!confirm('Reset semua teks essay?')) {
                return;
            }

            this.essay = '';
            this.error = null;
            this.result = null;
            this.showResults = false;

            if (typeof window.AutoSave !== 'undefined' && typeof window.AutoSave.clearSaved === 'function') {
                try { window.AutoSave.clearSaved(); } catch (e) { console.warn('AutoSave clearSaved failed', e); }
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
                // STAGE 1: Evaluation (Scores & Correction)
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
                    throw new Error('Evaluation failed. Server returned ' + response.status);
                }
                
                const data = await response.json();
                this.result = data;
                this.showResults = true;
                
                // STAGE 2: Improvement (Background)
                this.improveEssay();
                
            } catch (e) {
                console.error(e);
                this.error = e.message;
            } finally {
                this.loading = false;
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
        }
     }">
    <!-- Header -->
    <div x-show="!showResults" class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => $task]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-orange-600 tracking-wider uppercase">IELTS Writing Task {{ $task }}</span>
                <h1 class="text-2xl font-bold text-gray-800" x-text="mode === 'planning' ? 'Essay Layout Builder (3 Body Paragraphs)' : 'Writing Practice'"></h1>
            </div>
        </div>
        
          <div class="flex gap-3">
                 <button x-show="mode === 'planning'" @click="mode = 'writing'" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 transition-colors flex items-center">
                     <span>Start Writing</span>
                     <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                 </button>
                 <button x-show="mode === 'writing'" @click="mode = 'planning'" class="px-6 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition-colors">
                     Back to Plan
                 </button>
                 <button x-show="mode === 'writing'" @click.prevent="refreshEssay()" type="button" class="px-5 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                     Reset Essay
                 </button>
                 <button x-show="mode === 'writing'" @click="submitEssay()" :disabled="loading" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2">
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
        <button @click="error = null" class="ml-auto text-red-400 hover:text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>


    <!-- Main Content Grid (Original) -->
    <div x-show="!showResults" 
         class="flex flex-col lg:flex-row flex-1 min-h-0 relative"
         x-data="{ 
             leftWidth: 40, 
             resizing: false,
             startResize(e) {
                 this.resizing = true;
                 document.body.style.cursor = 'col-resize';
                 document.body.style.userSelect = 'none';
                 
                 const onMouseMove = (e) => {
                     if (!this.resizing) return;
                     const container = this.$el;
                     const containerRect = container.getBoundingClientRect();
                     let newWidth = ((e.clientX - containerRect.left) / containerRect.width) * 100;
                     
                     // clamp between 20% and 80%
                     if (newWidth < 20) newWidth = 20;
                     if (newWidth > 80) newWidth = 80;
                     
                     this.leftWidth = newWidth;
                 };
                 
                 const onMouseUp = () => {
                     this.resizing = false;
                     document.body.style.cursor = '';
                     document.body.style.userSelect = '';
                     window.removeEventListener('mousemove', onMouseMove);
                     window.removeEventListener('mouseup', onMouseUp);
                 };
                 
                 window.addEventListener('mousemove', onMouseMove);
                 window.addEventListener('mouseup', onMouseUp);
             }
         }">
        <!-- Left Column -->
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 overflow-y-auto flex-shrink-0" :style="`width: ${leftWidth}%;`">
            
            <!-- Planning Mode: Prompt & Instructions -->
            <div x-show="mode === 'planning'">
                 <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <h2 class="font-bold text-gray-800">Topic</h2>
                        @if(Auth::user()->role === 'admin')
                        <button @click="$dispatch('open-edit-prompt-modal')" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded hover:bg-yellow-200">
                            Edit
                        </button>
                        @endif
                    </div>
                    <p class="text-gray-600">{{ $meeting->prompt }}</p>
                 </div>

                 <div class="prose max-w-none text-gray-600">
                    <h3 class="font-bold text-gray-800">Cara Menggunakan Pembuat Layout Ini</h3>
                    <p>Fokus pada pengembangan argumen dalam paragraf utama Anda.</p>
                    <ul>
                        <li><strong>Paragraf Utama:</strong> Sertakan dua argumen kuat untuk mendukung ide utama Anda, masing-masing diikuti dengan contoh relevan.</li>
                    </ul>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                             <span class="p-1 bg-blue-100 rounded text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Cara Membuat Introduction Paragraph
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Introduction paragraph pada dasarnya adalah memperkenalkan topik yang sedang dibahas kepada pembaca. Anda hanya perlu untuk mem - <strong>PARAPHRASE</strong> soal yang diberikan.
                        </p>
                        
                        <div x-data="{ activeMethod: 'active-passive' }" class="space-y-4">
                            <!-- Tabs -->
                            <div class="flex gap-2 text-xs overflow-x-auto pb-2 no-scrollbar">
                                <button @click="activeMethod = 'active-passive'" :class="{ 'bg-blue-600 text-white shadow-md': activeMethod === 'active-passive', 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50': activeMethod !== 'active-passive' }" class="px-3 py-1.5 rounded-full whitespace-nowrap transition-all">Aktif → Pasif / Pasif → Aktif</button>
                                <button @click="activeMethod = 'gerund'" :class="{ 'bg-blue-600 text-white shadow-md': activeMethod === 'gerund', 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50': activeMethod !== 'gerund' }" class="px-3 py-1.5 rounded-full whitespace-nowrap transition-all">Verb → Gerund</button>
                                <button @click="activeMethod = 'synonym'" :class="{ 'bg-blue-600 text-white shadow-md': activeMethod === 'synonym', 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50': activeMethod !== 'synonym' }" class="px-3 py-1.5 rounded-full whitespace-nowrap transition-all">Synonyms</button>
                                <button @click="activeMethod = 'mixed'" :class="{ 'bg-blue-600 text-white shadow-md': activeMethod === 'mixed', 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50': activeMethod !== 'mixed' }" class="px-3 py-1.5 rounded-full whitespace-nowrap transition-all">Mixed</button>
                            </div>

                            <!-- Content -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100 text-sm relative overflow-hidden">
                                <!-- Decorative BG -->
                                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-white opacity-20 transform rotate-45 rounded-full pointer-events-none"></div>
                                
                                <div class="relative z-10">
                                    <p class="font-bold text-gray-700 mb-2 text-xs uppercase tracking-wide">Soal Asli:</p>
                                    <div class="bg-white/80 p-3 rounded-lg border border-blue-50/50 text-gray-700 italic mb-4 text-sm font-serif">
                                        "Some people believe that university education should focus on job skills, while others think it should provide knowledge for its own sake."
                                    </div>

                                    <!-- Method 1 -->
                                    <div x-show="activeMethod === 'active-passive'" x-transition.opacity>
                                        <h4 class="font-bold text-blue-700 mb-1">1. Aktif → Pasif / Pasif → Aktif</h4>
                                        <p class="mb-3 text-xs text-gray-500">Mengubah kalimat aktif menjadi pasif ("Some people believe..." → "It is believed by some...").</p>
                                        <div class="bg-white/60 p-3 rounded-lg border border-blue-100">
                                            <p class="text-gray-800 leading-relaxed font-medium">"It is believed by some people that university education ought to be directed towards developing job skills, whereas others argue that it should be aimed at gaining knowledge for personal growth."</p>
                                        </div>
                                    </div>

                                    <!-- Method 2 -->
                                    <div x-show="activeMethod === 'gerund'" x-transition.opacity>
                                        <h4 class="font-bold text-blue-700 mb-1">2. Verb → Gerund</h4>
                                        <p class="mb-3 text-xs text-gray-500">Menjadikan verb dari soal menjadi gerund as subject ("Believe that..." → "Focusing university education...").</p>
                                        <div class="bg-white/60 p-3 rounded-lg border border-blue-100">
                                            <p class="text-gray-800 leading-relaxed font-medium">"Focusing university education on practical job skills is considered important by some people, while others think providing general knowledge is more valuable."</p>
                                        </div>
                                    </div>

                                    <!-- Method 3 -->
                                    <div x-show="activeMethod === 'synonym'" x-transition.opacity>
                                        <h4 class="font-bold text-blue-700 mb-1">3. Keyword → Sinonim</h4>
                                        <p class="mb-3 text-xs text-gray-500">Mengubah keyword ke sinonimnya.</p>
                                        <ul class="list-none space-y-1 mb-3 text-xs bg-white/60 p-2 rounded border border-blue-100">
                                            <li>🎓 University education → Higher education</li>
                                            <li>💼 Job skills → Professional abilities</li>
                                            <li>🧠 Knowledge → Intellectual development</li>
                                        </ul>
                                        <div class="bg-white/60 p-3 rounded-lg border border-blue-100">
                                            <p class="text-gray-800 leading-relaxed font-medium">"Some individuals argue that higher education ought to emphasize professional abilities, whereas others claim it should concentrate on intellectual development."</p>
                                        </div>
                                    </div>

                                    <!-- Method 4 -->
                                    <div x-show="activeMethod === 'mixed'" x-transition.opacity>
                                        <h4 class="font-bold text-blue-700 mb-1">4. Mixed Methods</h4>
                                        <p class="mb-3 text-xs text-gray-500">Gabungan dari metode pasif, sinonim, dan struktur kalimat.</p>
                                        <div class="bg-white/60 p-3 rounded-lg border border-blue-100">
                                            <p class="text-gray-800 leading-relaxed font-medium">"It is often argued that higher education should be oriented toward enhancing employability, while others maintain that broad intellectual learning is equally essential."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
             </div>

             <!-- Writing Mode: Reference Plan -->
             <div x-show="mode === 'writing'" class="space-y-6">
                <h3 class="font-bold text-gray-800 text-lg border-b pb-2">Rencana Anda (Layout)</h3>
                
                <!-- Introduction Plan -->
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-3">Introduction</h4>
                    <p class="text-sm text-gray-700 whitespace-pre-line" x-show="form.intro" x-text="form.intro"></p>
                    <p class="text-sm text-gray-400 italic" x-show="!form.intro">Belum ada pendahuluan...</p>
                </div>

                <!-- Body 1 Plan -->
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                    <h4 class="font-bold text-blue-800 mb-3">Paragraf 1</h4>
                    <div class="space-y-3 text-sm">
                        <div x-show="form.b1_a1">
                            <span class="font-semibold text-blue-600 block">Argumen:</span>
                            <p class="text-gray-700" x-text="form.b1_a1"></p>
                            <p class="text-gray-600 italic mt-1" x-show="form.b1_a1_supp" x-text="'Ide Pendukung: ' + form.b1_a1_supp"></p>
                            <p class="text-gray-500 mt-1" x-show="form.b1_a1_ex" x-text="'Contoh: ' + form.b1_a1_ex"></p>
                        </div>
                    </div>
                </div>

                <!-- Body 2 Plan -->
                <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                    <h4 class="font-bold text-orange-800 mb-3">Paragraf 2</h4>
                    <div class="space-y-3 text-sm">
                        <div x-show="form.b2_a1">
                            <span class="font-semibold text-orange-600 block">Argumen:</span>
                            <p class="text-gray-700" x-text="form.b2_a1"></p>
                            <p class="text-gray-600 italic mt-1" x-show="form.b2_a1_supp" x-text="'Ide Pendukung: ' + form.b2_a1_supp"></p>
                            <p class="text-gray-500 mt-1" x-show="form.b2_a1_ex" x-text="'Contoh: ' + form.b2_a1_ex"></p>
                        </div>
                    </div>
                </div>

                <!-- Body 3 Plan -->
                <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
                    <h4 class="font-bold text-purple-800 mb-3">Paragraf 3</h4>
                    <div class="space-y-3 text-sm">
                        <div x-show="form.b3_a1">
                            <span class="font-semibold text-purple-600 block">Argumen:</span>
                            <p class="text-gray-700" x-text="form.b3_a1"></p>
                            <p class="text-gray-600 italic mt-1" x-show="form.b3_a1_supp" x-text="'Ide Pendukung: ' + form.b3_a1_supp"></p>
                            <p class="text-gray-500 mt-1" x-show="form.b3_a1_ex" x-text="'Contoh: ' + form.b3_a1_ex"></p>
                        </div>
                    </div>
                </div>
             </div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col gap-4 overflow-y-auto pr-2 flex-1" style="min-width: 0;">
            
            <!-- Planning Mode: Builder Inputs -->
            <div x-show="mode === 'planning'" class="space-y-8">
                <!-- Introduction -->
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

                <!-- Body 1 -->
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-6 relative group hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-blue-700">Paragraf Utama 1</h3>
                        <span class="text-xs text-gray-400">~90-100 kata</span>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Argument 1 -->
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-blue-600 uppercase mb-1">Argumen</label>
                            <input x-model="form.b1_a1" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-blue-500 text-sm" placeholder="Poin utama...">
                            <textarea x-model="form.b1_a1_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-blue-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung (Penjelasan)..."></textarea>
                            <textarea x-model="form.b1_a1_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-blue-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh..."></textarea>
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
                            <label class="block text-xs font-bold text-orange-600 uppercase mb-1">Argumen</label>
                            <input x-model="form.b2_a1" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-orange-500 text-sm" placeholder="Poin utama...">
                            <textarea x-model="form.b2_a1_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-orange-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung (Penjelasan)..."></textarea>
                            <textarea x-model="form.b2_a1_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-orange-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Body 3 -->
                 <div class="bg-white rounded-xl shadow-sm border-l-4 border-purple-500 p-6 relative group hover:shadow-md transition-shadow mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-purple-700">Paragraf Utama 3</h3>
                        <span class="text-xs text-gray-400">~90-100 kata</span>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Argument 1 -->
                        <div class="bg-purple-50 p-3 rounded-lg">
                            <label class="block text-xs font-bold text-purple-600 uppercase mb-1">Argumen</label>
                            <input x-model="form.b3_a1" type="text" class="w-full mb-2 p-2 rounded border-gray-200 focus:border-purple-500 text-sm" placeholder="Poin utama...">
                            <textarea x-model="form.b3_a1_supp" class="w-full mb-2 p-2 bg-white rounded border-gray-200 focus:border-purple-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Ide Pendukung (Penjelasan)..."></textarea>
                            <textarea x-model="form.b3_a1_ex" class="w-full p-2 bg-white rounded border-gray-200 focus:border-purple-300 focus:ring-0 text-sm resize-none" rows="2" placeholder="Contoh..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Writing Mode: Textareas -->
            <div x-show="mode === 'writing'" class="h-full flex flex-col">
                <div class="flex-1 bg-white rounded-xl shadow-sm border border-blue-200 p-6 flex flex-col min-h-[400px]">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold text-blue-700">Penulisan Esai</h3>
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-full shadow-sm" 
                            x-text="(essay ? essay.trim().split(/\s+/).filter(w => /[A-Za-z]/.test(w)).length : 0) + ' Words'">
                        </span>
                    </div>
                    <textarea x-model="essay" class="flex-1 w-full p-4 bg-gray-50 rounded-lg border-transparent focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors resize-none font-serif text-lg leading-relaxed" placeholder="Tuliskan ketiga paragraf tubuh Anda di sini... Gunakan argumen dan ide pendukung yang telah Anda susun."></textarea>
                </div>
            </div>

        </div>
    </div>

    <!-- RESULT MODE (FULL PAGE) -->
    <div x-show="showResults" class="flex flex-col h-full overflow-hidden" style="display: none;">
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
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $meeting->prompt }}</p>
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
                    <div class="p-6 overflow-y-auto flex-1 prose max-w-none leading-loose text-lg text-gray-800 selection:bg-blue-100" x-html="result?.correction_html"></div>
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
                            <p class="text-gray-600 leading-relaxed" x-text="result?.feedback?.overall_comment"></p>
                        </div>
                    </div>

                    <!-- Tab 2: Task Response -->
                    <div x-show="tab === 'task_response'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Task Response Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.task_achievement"></p>
                        </div>
                    </div>

                    <!-- Tab 3: Coherence -->
                    <div x-show="tab === 'coherence'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Coherence Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.coherence_cohesion"></p>
                        </div>
                    </div>

                    <!-- Tab 4: Lexical -->
                    <div x-show="tab === 'lexical'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Lexical Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.lexical_resource"></p>
                        </div>
                    </div>

                    <!-- Tab 5: Grammar -->
                    <div x-show="tab === 'grammar'" class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase text-xs tracking-wider">Grammar Detailed Feedback</h5>
                            <p class="text-gray-600 text-sm" x-text="result?.feedback?.grammatical_range"></p>
                        </div>
                    </div>

                    <!-- Tab: Vocabulary -->
                    <div x-show="tab === 'vocab'" class="space-y-6">
                        <div x-show="result?.vocabulary_improvements?.length > 0">
                            <h4 class="font-bold text-gray-800 mb-3">Suggested Improvements</h4>
                            <div class="space-y-3">
                                <template x-for="item in result?.vocabulary_improvements || []">
                                    <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-red-500 line-through" x-text="item.original"></span>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                            <span class="text-green-600 font-bold" x-text="item.improved"></span>
                                        </div>
                                        <p class="text-sm text-gray-600" x-text="item.explanation"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="result?.collocations?.length > 0">
                             <h4 class="font-bold text-gray-800 mb-3 border-t border-gray-200 pt-4">Relevant Collocations</h4>
                             <div class="flex flex-wrap gap-2">
                                <template x-for="col in result?.collocations || []">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium" x-text="col"></span>
                                </template>
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
<x-irregular-verbs-button />
<x-linking-words-button />

<x-collocation-button />
<x-dictionary-button />
@endsection

@section('scripts')
<script>
    const AutoSave = {
        storageKey: 'ielts_writing_layout_builder_3body_task_{{ $task }}_meeting_{{ $meeting->id }}_{{ Auth::id() }}',
        
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
