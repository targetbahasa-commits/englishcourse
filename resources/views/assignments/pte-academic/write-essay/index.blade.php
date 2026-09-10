<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Write Essay | {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white flex flex-col min-h-screen">

    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::check())
            @php($sidebarRole = strtolower(Auth::user()->active_role ?? 'student'))
            @if($sidebarRole === 'admin')
                @include('components.sidebar-admin')
            @elseif($sidebarRole === 'teacher')
                @include('components.sidebar-teacher')
            @elseif(in_array($sidebarRole, ['guest', 'guest_quick']))
                @include('components.sidebar-guest')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endif

        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="mb-6 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                <div class="flex justify-end mb-2">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Back</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-br from-rose-500 to-rose-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="hover:text-rose-600 transition">Speaking &amp; Writing</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Write Essay</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">300 Write Essay Topics</h1>
                            <p class="text-gray-600 mt-1">Pilih topik untuk memulai latihan Write Essay Anda.</p>
                        </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @for ($i = 1; $i <= 300; $i++)
                <a id="topic-{{ $i }}" data-topic-card="{{ $i }}" href="{{ route('assignments.pte-academic.speaking-writing.write-essay.practice', ['id' => $i]) }}" class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:border-rose-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-rose-50 to-rose-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <x-pte-topic-badge />
                    <div class="relative flex items-center justify-between w-full mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-rose-400 to-rose-600 text-white rounded-xl shadow-md flex items-center justify-center font-bold text-lg group-hover:shadow-lg transition-all duration-300">
                            {{ $i }}
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-300 group-hover:bg-rose-50 group-hover:text-rose-500 transition-all duration-300">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                    <div class="relative mt-auto">
                        <h3 class="text-gray-800 font-bold text-lg mb-1 group-hover:text-rose-700 transition-colors">{{ $topics[$i]['title'] }}</h3>
                        <p class="text-gray-500 text-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Write Essay Practice
                        </p>
                    </div>
                </a>
                @endfor
            </div>
            {{-- Floating Tips Button --}}
            <div x-data="{
        showTips: false,
        isPinned: false,
        
        // Floating button position & drag
        btnX: 0, btnY: 0,
        btnDragging: false, btnIsDragged: false,
        btnStartX: 0, btnStartY: 0,

        // Modal position & dimensions
        modalX: null, modalY: null,
        modalW: 920, modalH: 650,
        modalDragging: false,
        modalStartX: 0, modalStartY: 0,

        // Modal resizing
        modalResizing: false,
        resizeStartX: 0, resizeStartY: 0,
        resizeStartW: 0, resizeStartH: 0,

        init() {
            this.btnX = Math.max(12, window.innerWidth - 90);
            this.btnY = Math.max(60, window.innerHeight - 130);
            this.modalW = Math.min(920, window.innerWidth - 24);
            this.modalH = Math.min(650, window.innerHeight - 24);
        },

        openTips() {
            if (!this.btnIsDragged) {
                this.showTips = true;
                if (this.modalX === null) {
                    this.modalW = Math.min(920, window.innerWidth - 24);
                    this.modalH = Math.min(650, window.innerHeight - 24);
                    this.modalX = Math.max(8, Math.floor((window.innerWidth - this.modalW) / 2));
                    this.modalY = Math.max(8, Math.floor((window.innerHeight - this.modalH) / 2));
                }
            }
        },

        startBtnDrag(e) {
            this.btnDragging = true;
            this.btnIsDragged = false;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.btnStartX = clientX - this.btnX;
            this.btnStartY = clientY - this.btnY;
        },

        startModalDrag(e) {
            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('input')) return;
            this.modalDragging = true;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.modalStartX = clientX - (this.modalX || 0);
            this.modalStartY = clientY - (this.modalY || 0);
        },

        startResize(e) {
            e.stopPropagation();
            e.preventDefault();
            this.modalResizing = true;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.resizeStartX = clientX;
            this.resizeStartY = clientY;
            this.resizeStartW = this.modalW;
            this.resizeStartH = this.modalH;
        },

        onMove(e) {
            let clientX = e.type.includes('mouse') ? e.clientX : (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
            let clientY = e.type.includes('mouse') ? e.clientY : (e.touches && e.touches[0] ? e.touches[0].clientY : 0);

            if (this.btnDragging) {
                this.btnIsDragged = true;
                let nx = clientX - this.btnStartX;
                let ny = clientY - this.btnStartY;
                this.btnX = Math.max(8, Math.min(nx, window.innerWidth - 65));
                this.btnY = Math.max(8, Math.min(ny, window.innerHeight - 65));
            }

            if (this.modalDragging) {
                this.modalX = clientX - this.modalStartX;
                this.modalY = clientY - this.modalStartY;
            }

            if (this.modalResizing) {
                let dx = clientX - this.resizeStartX;
                let dy = clientY - this.resizeStartY;
                this.modalW = Math.max(320, Math.min(this.resizeStartW + dx, window.innerWidth - (this.modalX || 0) - 10));
                this.modalH = Math.max(240, Math.min(this.resizeStartH + dy, window.innerHeight - (this.modalY || 0) - 10));
            }
        },

        onEnd() {
            this.btnDragging = false;
            this.modalDragging = false;
            this.modalResizing = false;
        }
    }"
    @mousemove.window="onMove" @mouseup.window="onEnd" @touchmove.window="onMove" @touchend.window="onEnd">
                <button x-show="!showTips" @click.prevent="openTips()"
                @mousedown="startBtnDrag" @touchstart="startBtnDrag"
                class="fixed z-[9999] text-white px-3.5 py-2.5 md:p-4 rounded-full shadow-2xl flex items-center gap-1.5 md:gap-2 select-none"
                :style="`left: ${btnX}px; top: ${btnY}px; background-color: #eab308; touch-action: none;`"
                :class="btnDragging ? 'cursor-grabbing scale-105' : 'cursor-grab hover:scale-105 transition-transform'"
                title="Tips & Strategi">
            <svg class="w-5 h-5 md:w-6 md:h-6 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-bold text-xs md:text-sm text-white">Tips</span>
        </button>

                {{-- Tips Modal --}}
                <template x-teleport="body">
            <div x-show="showTips" style="display: none;" class="fixed inset-0 z-[100] pointer-events-none">
                
                {{-- Dark Backdrop (Only active when NOT pinned) --}}
                <div x-show="!isPinned" 
                     @click="showTips = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="absolute inset-0 bg-black/25 pointer-events-auto cursor-pointer">
                </div>

                <div x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="fixed bg-white rounded-2xl flex flex-col shadow-2xl border border-gray-300 pointer-events-auto overflow-hidden"
                     :style="`left: ${modalX ?? 20}px; top: ${modalY ?? 20}px; width: ${modalW}px; height: ${modalH}px; max-width: 95vw; max-height: 90vh; min-width: 320px; min-height: 240px;`">
                            {{-- Seamless Header Drag Bar (Symbol Controls Only) --}}
                    <div @mousedown="startModalDrag" @touchstart="startModalDrag"
                         class="flex items-center justify-between px-4 py-3 select-none cursor-grab active:cursor-grabbing flex-shrink-0 bg-white">
                        <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
                            <span class="w-2 h-2 rounded-full bg-amber-400 inline-block animate-pulse"></span>
                            <span class="text-[11px] font-medium text-gray-400">Tips & Strategi</span>
                        </div>

                        {{-- Control Icon Buttons (Pin & Close as symbols only) --}}
                        <div class="flex items-center gap-1.5 shrink-0">
                            {{-- Pin Icon Only --}}
                            <button type="button" @click="isPinned = !isPinned" 
                                    class="w-8 h-8 rounded-full transition flex items-center justify-center cursor-pointer text-sm"
                                    :class="isPinned ? 'bg-amber-500 text-white shadow-md ring-2 ring-amber-300' : 'bg-white hover:bg-gray-200 text-gray-600'"
                                    :title="isPinned ? 'Unpin modal' : 'Pin modal'">
                                
                            </button>

                            {{-- Close Icon Only --}}
                            <button type="button" @click="showTips = false" 
                                    class="w-8 h-8 rounded-full bg-white hover:bg-gray-200 text-gray-500 hover:text-gray-800 transition flex items-center justify-center cursor-pointer"
                                    title="Tutup">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="isPinned = !isPinned" 
                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 text-xs font-bold cursor-pointer"
                                    :class="isPinned ? 'bg-amber-500 text-white shadow ring-2 ring-amber-300' : 'bg-white text-gray-600 hover:bg-gray-200 border border-gray-300'"
                                    :title="isPinned ? 'Unpin modal (allow click outside to close)' : 'Pin modal (keep visible while practicing)'">
                                <svg class="w-3.5 h-3.5" :class="isPinned ? 'rotate-45' : ''" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582A1 1 0 0115.5 6.82v4.36l1.382 1.382A1 1 0 0116.172 14H11v3.586l.707.707a1 1 0 01-1.414 1.414l-2-2a1 1 0 010-1.414l.707-.707V14H3.828a1 1 0 01-.707-1.707L4.5 10.918V6.82a1 1 0 01.546-.915L9 4.323V3a1 1 0 011-1z" />
                                </svg>
                                <span x-text="isPinned ? 'Pinned ' : 'Pin '">Pin </span>
                            </button>

                            <button type="button" @click="showTips = false" class="text-gray-400 hover:text-gray-700 hover:bg-gray-200 p-2 rounded-xl transition cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                            <div class="p-6 overflow-y-auto bg-white flex-1">

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Struktur Umum</h4>
                                    </div>
                                    <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">AWALAN</h5>
                                            <p>These days, <span class="text-amber-600 font-bold">[pernyataan esai, parafrasekan soal esai atau sebutkan secara singkat apa yang akan Anda tulis di BP1 & BP2]</span>. In this essay, the discussion will shed light on the <span class="text-amber-600 font-bold">(pilih salah satu: aspek-aspek / sebab dan akibat / masalah dan solusi / keuntungan dan kerugian)</span> of <span class="text-amber-600 font-bold">[nama topik esai]</span> to provide a balanced and well-reasoned perspective.</p>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">PERSPEKTIF</h5>
                                            <p>To begin with, there are numerous <span class="text-amber-600 font-bold">(pilih salah satu: aspek-aspek / keuntungan / kekurangan)</span> of <span class="text-amber-600 font-bold">[nama topik]</span>, such as <span class="text-amber-600 font-bold">[contoh: poin 1-bisa berupa keuntungan atau kekurangan]</span>. This is evident because <span class="text-amber-600 font-bold">[poin-poin pendukung atau alasan untuk memperkuat pernyataan di kalimat sebelumnya]</span>. For example, studies have shown that <span class="text-amber-600 font-bold">[contoh nyata atau data statistik yang berkaitan dengan poin yang disebutkan]</span>. Moreover, <span class="text-amber-600 font-bold">[poin pendukung tambahan keempat]</span>. To conclude, the aspects discussed above clearly support my viewpoint.</p>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">SUDUT PANDANG KALIAN</h5>
                                            <p><span class="text-amber-600 font-bold">Besides, another significant point is that (Gunakan jika mendukung BP1) / On the other hand, one significant (pilih salah satu: poin / aspek / faktor / sebab / akibat / manfaat / kekurangan / tantangan) is that</span> <span class="text-amber-600 font-bold">[perkenalkan ide atau argumen kedua Anda]</span>. This means that <span class="text-amber-600 font-bold">[berikan ide pendukung atau penjelasan dari argumen kedua]</span>. For instance, <span class="text-amber-600 font-bold">[berikan contoh yang relevan dengan argumen kedua]</span>. Overall, these factors demonstrate that <span class="text-amber-600 font-bold">(nama topik)</span> significantly influences perspectives regarding <span class="text-amber-600 font-bold">(ide utama atau kesimpulan dari paragraf badan esai ini)</span>.</p>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">KESIMPULAN</h5>
                                            <p>In conclusion, this topic involves various <span class="text-amber-600 font-bold">(pilih salah satu: aspek / sebab / akibat / tantangan dan solusi)</span> that deserve attention. From my perspective, <span class="text-amber-600 font-bold">[tulis ulang/parafrasekan posisi atau opini Anda terhadap topik ini]</span>. Addressing its use in a way that benefits individuals and communities, while mitigating its misuse, can ensure balanced and constructive outcomes for society.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Contoh Pemakaian Struktur</h4>
                                    </div>
                                    <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <p>“These days, <span class="text-amber-600 font-bold">[the integration of technological tools like Artificial Intelligence in educational settings has become a highly debated topic]</span>. In this essay, the discussion will shed light on the <span class="text-amber-600 font-bold">[advantages and disadvantages of Artificial Intelligence in the teaching field]</span> to provide a balanced and well-reasoned perspective.</p>
                                        <p>To begin with, there are numerous <span class="text-amber-600 font-bold">[advantages of AI]</span>, such as <span class="text-amber-600 font-bold">[automating administrative tasks for educators]</span>. This is evident because <span class="text-amber-600 font-bold">[AI tools can grade quizzes and manage student tracking efficiently.]</span> For example, studies have shown that <span class="text-amber-600 font-bold">[using AI for grading saves teachers time.]</span> Moreover, <span class="text-amber-600 font-bold">[these tools offer personalized learning paths based on student data.]</span> To conclude, the aspects discussed above clearly support my viewpoint.</p>
                                        <p>On the other hand, one significant <span class="text-amber-600 font-bold">[drawback]</span> is that <span class="text-amber-600 font-bold">[excessive reliance on AI may reduce human interaction.]</span> This means that <span class="text-amber-600 font-bold">[students might develop dependence on the technology rather than problem-solving autonomously.]</span> For instance, <span class="text-amber-600 font-bold">[lack of direct human feedback can hinder the development of soft skills.]</span> Overall, these factors demonstrate that <span class="text-amber-600 font-bold">[AI in teaching]</span> significantly influences perspectives regarding <span class="text-amber-600 font-bold">[the future role of human educators.]</span></p>
                                        <p>In conclusion, this topic involves various <span class="text-amber-600 font-bold">[advantages and drawbacks]</span> that deserve attention. From my perspective, <span class="text-amber-600 font-bold">[AI is indeed a powerful supplement to teaching, but it must be applied judiciously.]</span> Addressing its use in a way that benefits individuals and communities, while mitigating its misuse, can ensure balanced and constructive outcomes for society.”</p>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">1. Paragraf Pengantar (Introduction)</h4>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Pernyataan Topik & Pendahuluan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> <span class="text-amber-600 font-bold">[essay statement, paraphrase the statement or mention a brief of what you are writing in BP1 & BP2]</span></span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Mulailah dengan pernyataan umum tentang topik tersebut. Parafrasekan soal esai yang diberikan, atau sebutkan secara singkat poin-poin utama yang akan Anda bahas di Paragraf Badan 1 (BP1) dan Paragraf Badan 2 (BP2).</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Tujuan Esai):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> In this essay, the discussion will shed light on the (aspects, causes and effects, or issues and solutions, advantages and disadvantages) of <span class="text-amber-600 font-bold">[essay topic name]</span> to provide a balanced and well-reasoned perspective.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Pilih salah satu opsi yang paling sesuai dengan jenis esai (misalnya, pilih advantages and disadvantages jika esai meminta pandangan yang seimbang). Ganti [essay topic name] dengan nama topik utama esai Anda.</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">2. Paragraf Badan 1 (BP1)</h4>
                                        <p class="text-xs text-blue-600 mt-1 italic">Wajib 4 kalimat diisi, tidak termasuk kalimat penutup</p>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Topik & Poin Utama 1):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> To begin with, there are numerous (aspects/advantages/drawbacks) of (Topic name), such as <span class="text-amber-600 font-bold">[example: point 1- could be advantage or disadvantage]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Pilih salah satu kata transisi (aspects/advantages/drawbacks) dan masukkan nama topik. Sertakan Poin Utama 1 yang ingin Anda bahas di BP1.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Pendukung):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> This is evident because <span class="text-amber-600 font-bold">[supporting points for previous statement]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Jelaskan atau berikan alasan pendukung untuk Poin Utama 1 dari kalimat sebelumnya.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 3 (Contoh Spesifik):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> For example, studies have shown that <span class="text-amber-600 font-bold">[example related to the point mentioned]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Masukkan contoh konkret, data, atau hasil studi fiktif yang relevan untuk memperkuat argumen Anda.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 4 (Pendukung Tambahan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Moreover, <span class="text-amber-600 font-bold">[supporting point 4]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Tambahkan poin pendukung keempat (bisa berupa implikasi, dampak, atau elaborasi lain) untuk memastikan tercapai batas minimal 4 kalimat.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat Penutup BP1:</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> To conclude, the aspects discussed above clearly support my viewpoint.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Ini adalah kesimpulan mini untuk BP1, biarkan seperti apa adanya.</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">3. Paragraf Badan 2 (BP2)</h4>
                                        <p class="text-xs text-blue-600 mt-1 italic">Wajib 3 kalimat diisi, tidak termasuk kalimat penutup</p>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Transisi & Poin Utama 2):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Besides, another significant point is that / On the other hand, one significant (point/aspect/ factor/ cause / effect/benefit/drawback / challenge) is that <span class="text-amber-600 font-bold">[introduce the idea/ point]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Gunakan Besides jika poin ini mendukung pandangan yang sama dengan BP1. Gunakan On the other hand jika poin ini menyajikan pandangan yang berlawanan (untuk esai seimbang). Pilih salah satu opsi dalam kurung dan masukkan Poin Utama 2.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Penjelasan/Pendukung):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> This means that <span class="text-amber-600 font-bold">[give a supporting idea]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Berikan penjelasan lebih lanjut atau ide pendukung untuk Poin Utama 2.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 3 (Contoh Spesifik):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> For instance, <span class="text-amber-600 font-bold">[relevant example]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Berikan contoh yang relevan. Perhatikan bahwa ini adalah singkatan dari For instance.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat Penutup BP2:</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Overall, these factors demonstrate that (topic name) significantly influences perspectives regarding(main idea of essay).</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Ini adalah kesimpulan mini untuk BP2, biarkan seperti apa adanya.</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">4. Kesimpulan (Conclusion)</h4>
                                        <p class="text-xs text-blue-600 mt-1 italic">Tujuan bagian ini adalah untuk merangkum esai tanpa memperkenalkan ide baru.</p>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Ringkasan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> In conclusion, this topic involves various (aspects / causes / effects / challenge solutions) that deserve attention.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Pilih opsi yang relevan (sesuai dengan yang dipilih di Kalimat 2 Pendahuluan) untuk merangkum isu yang dibahas.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Pernyataan Ulang Pandangan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> From my perspective, <span class="text-amber-600 font-bold">(paraphrase topic statement)</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Nyatakan kembali pandangan Anda mengenai topik esai dalam kalimat yang berbeda (parafrase).</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 3 (Harapan/Rekomendasi Akhir):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Addressing its use in a way that benefits individuals and communities, while mitigating its misuse, can ensure balanced and constructive outcomes for society.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Ini berfungsi sebagai pernyataan akhir yang menekankan perlunya tindakan seimbang.</span>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </main>
    </div>


    <script src="{{ asset('js/pte-tracking.js') }}"></script>
    <script>
        pteTracking.init('write-essay');
    </script>

</body>
</html>
