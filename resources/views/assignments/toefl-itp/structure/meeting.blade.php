@extends('layouts.dashboard')

@section('content')
<div x-data="{
    showCheatSheet: false,
    cheatZoom: 1,
    minCheatZoom: 0.6,
    maxCheatZoom: 2.5,
    zoomStep: 0.1,
    cheatPos: {
        x: window.innerWidth >= 768 ? 288 : 28,
        y: Math.max(20, Math.round(window.innerHeight * 0.15))
    },
    cheatDrag: {
        active: false,
        offsetX: 0,
        offsetY: 0
    },
    zoomIn() {
        this.cheatZoom = Math.min(this.maxCheatZoom, +(this.cheatZoom + this.zoomStep).toFixed(2));
    },
    zoomOut() {
        this.cheatZoom = Math.max(this.minCheatZoom, +(this.cheatZoom - this.zoomStep).toFixed(2));
    },
    resetZoom() {
        this.cheatZoom = 1;
    },
    startCheatDrag(e) {
        const p = e.touches ? e.touches[0] : e;
        this.cheatDrag.active = true;
        this.cheatDrag.offsetX = p.clientX - this.cheatPos.x;
        this.cheatDrag.offsetY = p.clientY - this.cheatPos.y;
    },
    onCheatDrag(e) {
        if (!this.cheatDrag.active) return;
        const p = e.touches ? e.touches[0] : e;
        this.cheatPos.x = p.clientX - this.cheatDrag.offsetX;
        this.cheatPos.y = p.clientY - this.cheatDrag.offsetY;
        this.constrainCheatSheet();
    },
    stopCheatDrag() {
        this.cheatDrag.active = false;
    },
    cheatSize: { width: 350, height: Math.round(window.innerHeight * 0.8) },
    cheatResize: { active: false, startX: 0, startY: 0, startW: 0, startH: 0 },
    startCheatResize(e) {
        e.stopPropagation();
        const p = e.touches ? e.touches[0] : e;
        this.cheatResize.active = true;
        this.cheatResize.startX = p.clientX;
        this.cheatResize.startY = p.clientY;
        this.cheatResize.startW = this.cheatSize.width;
        this.cheatResize.startH = this.cheatSize.height;
    },
    onCheatResize(e) {
        if (!this.cheatResize.active) return;
        const p = e.touches ? e.touches[0] : e;
        const dx = p.clientX - this.cheatResize.startX;
        const dy = p.clientY - this.cheatResize.startY;
        this.cheatSize.width = Math.max(280, Math.min(window.innerWidth - this.cheatPos.x - 8, this.cheatResize.startW + dx));
        this.cheatSize.height = Math.max(200, Math.min(window.innerHeight - this.cheatPos.y - 8, this.cheatResize.startH + dy));
    },
    stopCheatResize() {
        this.cheatResize.active = false;
    },
    constrainCheatSheet() {
        this.cheatPos.x = Math.max(8, Math.min(window.innerWidth - this.cheatSize.width - 8, this.cheatPos.x));
        this.cheatPos.y = Math.max(8, Math.min(window.innerHeight - this.cheatSize.height - 8, this.cheatPos.y));
    },
    getExplanationData() {
        const container = document.getElementById('explanation-container');
        if (!container || typeof Alpine === 'undefined') return null;
        try {
            return Alpine.$data(container);
        } catch (e) {
            return null;
        }
    },
    isLaserActive() {
        const explanation = this.getExplanationData();
        return !!(explanation && explanation.explanationMode && explanation.tool === 'laser');
    },
    isExplanationActive() {
        const explanation = this.getExplanationData();
        return !!(explanation && explanation.explanationMode);
    },
    isToolActive(tool) {
        const explanation = this.getExplanationData();
        return !!(explanation && explanation.explanationMode && explanation.tool === tool);
    },
    triggerCheatLaser(e) {
        const explanation = this.getExplanationData();
        if (!explanation || !explanation.explanationMode || explanation.tool !== 'laser') return;
        explanation.showLaserPointer(e.clientX, e.clientY, true);
    },
    triggerCheatLaserMove(e) {
        const isMouse = e.pointerType === 'mouse' || !e.pointerType;
        if (isMouse && e.buttons !== 1) return;
        this.triggerCheatLaser(e);
    }
}"
@mousemove.window="onCheatDrag($event); onCheatResize($event)"
@touchmove.window="onCheatDrag($event); onCheatResize($event)"
@mouseup.window="stopCheatDrag(); stopCheatResize()"
@touchend.window="stopCheatDrag(); stopCheatResize()"
@resize.window="constrainCheatSheet()">
            <!-- Fixed Cheat Sheet Button (Left of Question Area) -->
    <button @click="showCheatSheet = !showCheatSheet; if (showCheatSheet) { $nextTick(() => { if (typeof initCanvases === 'function') initCanvases(); }); }"
                        class="fixed bottom-8 left-7 md:left-72 z-[90] px-4 py-2 bg-yellow-400 text-yellow-900 rounded-full shadow-lg font-bold hover:bg-yellow-300 transition flex items-center gap-2 border border-yellow-500 cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Contekan
    </button>

    <!-- Cheat Sheet Popup (Fixed Position) -->
    <div x-show="showCheatSheet" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
            class="fixed z-[150] shadow-2xl rounded-xl ring-1 ring-black/5 bg-white border border-gray-200 flex flex-col"
            :style="`left: ${cheatPos.x}px; top: ${cheatPos.y}px; width: ${cheatSize.width}px; height: ${cheatSize.height}px;`">
        
        <!-- Header -->
        <div class="bg-yellow-300 border-b flex justify-between items-center select-none rounded-t-xl">
            <div class="flex-1 min-w-0 p-4 flex items-center gap-2 text-yellow-900 cursor-move"
                 @mousedown.prevent="startCheatDrag($event)"
                 @touchstart.prevent="startCheatDrag($event)">
                <h3 class="font-bold text-base text-gray-800 whitespace-nowrap">Cheat Sheet</h3>
            </div>
            <div class="pr-2 pl-1 flex items-center gap-1.5 shrink-0">
                <button type="button" @click="zoomOut()" class="w-8 h-8 rounded-lg bg-white/80 hover:bg-white text-gray-700 font-bold border border-yellow-500">-</button>
                <span class="text-xs font-bold text-gray-700 min-w-[52px] text-center" x-text="Math.round(cheatZoom * 100) + '%'">100%</span>
                <button type="button" @click="zoomIn()" class="w-8 h-8 rounded-lg bg-white/80 hover:bg-white text-gray-700 font-bold border border-yellow-500">+</button>
                <button type="button" @click="resetZoom()" class="px-2 py-1 rounded-lg bg-white/80 hover:bg-white text-[11px] font-semibold text-gray-700 border border-yellow-500">Reset</button>
                <button type="button"
                        @click.stop="showCheatSheet = false"
                        @mousedown.stop="showCheatSheet = false"
                        onclick="this.closest('[x-data]').__x.$data.showCheatSheet = false"
                        class="relative z-20 pointer-events-auto bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg border-2 border-red-700 transform transition hover:scale-105 flex items-center justify-center w-9 h-9 md:w-10 md:h-10 cursor-pointer"
                        title="Close">
                    <svg class="w-6 h-6 pointer-events-none font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Image Content -->
           <div class="flex-1 bg-white p-0 relative overflow-auto rounded-b-xl"
                         @pointerdown="triggerCheatLaser($event)"
                         @pointermove="triggerCheatLaserMove($event)"
             @wheel="if ($event.ctrlKey) { $event.preventDefault(); $event.deltaY < 0 ? zoomIn() : zoomOut(); }">
            <div class="min-h-full flex items-start justify-center p-2">
                <div class="relative inline-block">
                    <img src="/images/materials/cheatsheets/cheatsheet_contekan.jpg"
                         @load="$nextTick(() => { if (typeof initCanvases === 'function') initCanvases(); })"
                         class="max-w-none h-auto transition-all duration-150"
                         :style="`width: ${Math.round(cheatZoom * 100)}%;`"
                         alt="TOEFL Cheat Sheet">
                    <canvas id="cheat-explanation-canvas"
                            class="explanation-draw-canvas absolute inset-0 w-full h-full pointer-events-auto"></canvas>
                </div>
            </div>
        </div>

        <!-- Resize Handle -->
        <div class="absolute bottom-0 right-0 w-6 h-6 cursor-se-resize z-10 flex items-center justify-center opacity-40 hover:opacity-90 transition-opacity"
             @mousedown.prevent.stop="startCheatResize($event)"
             @touchstart.prevent.stop="startCheatResize($event)"
             title="Resize">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M11 1L1 11" stroke="#374151" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M11 5L5 11" stroke="#374151" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M11 9L9 11" stroke="#374151" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
</div>
<style>
    .cursor-tool-pen {
        cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>') 2 22, auto !important;
    }
    .cursor-tool-eraser {
        cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="%23ffffff" stroke="%23000000" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2"/></svg>') 12 12, auto !important;
    }
    .cursor-tool-highlight {
         cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="%23ffff00" stroke="%23000000" stroke-width="1"><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>') 2 22, auto !important;
    }
    .error-option {
        text-decoration: underline;
        text-decoration-thickness: 2px;
        text-underline-offset: 4px;
        position: relative;
        display: inline-block;
        margin: 0 8px;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 4px;
        padding: 0 2px;
        line-height: 1.2; /* Critical: Reset line height so top:100% is tight to text */
        vertical-align: baseline;
    }
    .error-option:hover {
        background-color: #FEF3C7;
        color: #B45309;
        text-decoration-color: #B45309;
    }
    .error-option::after {
        content: '(' attr(data-label) ')';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.75em;
        font-weight: bold;
        color: #6B7280;
        margin-top: 2px; /* Reduced margin slightly */
        transition: all 0.2s;
        padding: 2px 6px;
        border-radius: 999px;
        white-space: nowrap;
        background-color: white;
        z-index: 10;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .error-option.selected-error {
        color: #DC2626;
        text-decoration-color: #DC2626;
        background-color: #FEF2F2;
    }
    .error-option.selected-error::after {
        background-color: #DC2626;
        color: white;
        content: attr(data-label);
    }
    
    /* Laser Pointer Styles */
    @keyframes laser-trail-fade {
        0% {
            opacity: 0.95;
            transform: translate(-6px, -6px) scale(1);
        }
        100% {
            opacity: 0;
            transform: translate(-6px, -6px) scale(0.6);
        }
    }

    .laser-dot {
        width: 4px;
        height: 4px;
        background: #EF4444;
        border-radius: 50%;
        box-shadow: 0 0 3px rgba(239, 68, 68, 0.55);
    }

    .laser-trail-dot {
        position: fixed;
        width: 5px;
        height: 5px;
        background: rgba(239, 68, 68, 0.92);
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(239, 68, 68, 0.55);
        animation: laser-trail-fade 4s ease-out forwards;
    }
    
    /* Custom Red Dot Cursor for Laser Tool */
    .cursor-laser {
        cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5" fill="%23EF4444" opacity="0.8"/><circle cx="12" cy="12" r="3" fill="%23EF4444"/></svg>') 12 12, crosshair;
    }
</style>
<div class="container mx-auto px-4 py-8">
    @php
        $backRoute = $number > 50
            ? route('assignments.toefl-itp.structure.practice')
            : route('assignments.toefl-itp.structure');

        $totalQuestionCount = collect($questions)->count();
        $answerKeyFilledCount = collect($questions)->filter(function ($question) {
            return filled(trim((string) ($question->correct_answer ?? '')));
        })->count();
        $isAnswerKeyComplete = $totalQuestionCount > 0 && $answerKeyFilledCount === $totalQuestionCount;
    @endphp
    <!-- Header -->
    <div class="mb-8 flex justify-between items-end">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ $backRoute }}" class="text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Structure Meeting {{ $number }}</h2>
            </div>
            <p class="text-gray-500 text-sm ml-9">{{ $title }}</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap justify-end">
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <button type="button" onclick="openAnswerKeyStatusModal()" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold {{ $isAnswerKeyComplete ? 'bg-emerald-100 text-emerald-700 border border-emerald-200 hover:bg-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200 hover:bg-amber-200' }} transition" title="Lihat daftar answer key">
                    <span class="w-2 h-2 rounded-full {{ $isAnswerKeyComplete ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                    {{ $isAnswerKeyComplete ? 'Answer Key Ditambahkan' : 'Answer Key Belum Lengkap' }}
                </button>
                <button type="button" onclick="openAnswerKeyStatusModal()" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-slate-100 text-slate-700 border border-slate-200 hover:bg-slate-200 transition" title="Lihat daftar answer key">
                    {{ $answerKeyFilledCount }}/{{ $totalQuestionCount }} Soal
                </button>
            @else
                <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold {{ $isAnswerKeyComplete ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                    <span class="w-2 h-2 rounded-full {{ $isAnswerKeyComplete ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                    {{ $isAnswerKeyComplete ? 'Answer Key Ditambahkan' : 'Answer Key Belum Lengkap' }}
                </span>
                <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $answerKeyFilledCount }}/{{ $totalQuestionCount }} Soal
                </span>
            @endif

            @if(Auth::user()->isAdmin())
                <button onclick="openAddQuestionModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Question
                </button>
            @endif

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <button type="button" onclick="saveExplanationCanvas()" class="px-4 py-2 bg-slate-700 text-white rounded-lg shadow-md hover:bg-slate-800 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"></path></svg>
                    Save Explanation
                </button>
            @endif

            @if($hasSavedExplanation)
                <a href="{{ route('assignments.toefl-itp.structure.meeting.download-explanation', $number) }}" class="px-4 py-2 bg-white text-slate-700 rounded-lg shadow-md hover:bg-slate-50 transition flex items-center gap-2 border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"></path></svg>
                    Download Teacher Notes
                </a>
            @endif

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <button onclick="document.getElementById('explanation-container').__x?.toggleAnswerKey()" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition flex items-center gap-2" id="toggleAnswerBtn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span>Show Answer Key</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Questions Form -->
    <div id="explanation-container" x-data="{ 
        explanationMode: false,
        showAnswerKey: false, 
        questionZoom: 1,
        questionZoomMin: 0.8,
        questionZoomMax: 1.5,
        questionZoomStep: 0.1,
        tool: 'pen', 
        color: '#EF4444', 
        baseColor: '#EF4444',
        opacity: 0.2, 
        lineWidth: 2,
        colors: {
            pen: ['#EF4444', '#3B82F6', '#10B981', '#FACC15', '#F59E0B', '#8B5CF6', '#06B6D4', '#F97316'],
            highlight: ['#FFFF00', '#93C5FD', '#86EFAC', '#F9A8D4', '#FCD34D', '#C4B5FD', '#A7F3D0', '#FDBA74']
        },
        stamps: ['Subject', 'Verb Asli', 'Verb Palsu', 'Ving', 'V3', 'To infinitive', 'Preposition', 'Conjunction', 'Appositive', 'FANBOYS', 'Main Clause', 'Sub Clause', 'Comparative', 'Superlative'],
        selectedStamp: null,
        stampPanel: {
            x: Math.max(8, window.innerWidth - 170),
            y: Math.max(70, Math.round(window.innerHeight / 2) - 300),
            maxHeight: Math.max(260, window.innerHeight - 190),
            dragging: false,
            offsetX: 0,
            offsetY: 0
        },
        laserPointer: { visible: false, x: 0, y: 0, localX: 0, localY: 0, scope: 'question', timeout: null },
        laserPressing: false,
        laserTrail: [],
        addLaserTrailPoint(x, y, scope = 'question') {
            const id = Date.now() + Math.random();
            this.laserTrail.push({ id, x, y, scope });
            if (this.laserTrail.length > 220) {
                this.laserTrail.shift();
            }

            setTimeout(() => {
                this.laserTrail = this.laserTrail.filter(point => point.id !== id);
            }, 4000);
        },
        toggleMode() {
            this.explanationMode = !this.explanationMode;
            if (this.explanationMode) {
                setTimeout(() => {
                     if(typeof initCanvases === 'function') initCanvases();
                }, 50);
                this.$nextTick(() => this.constrainStampPanel());
            } else {
                this.laserTrail = [];
            }
        },
        zoomQuestionIn() {
            this.questionZoom = Math.min(this.questionZoomMax, +(this.questionZoom + this.questionZoomStep).toFixed(2));
            if (this.explanationMode) {
                setTimeout(() => { if (typeof initCanvases === 'function') initCanvases(); }, 80);
            }
        },
        zoomQuestionOut() {
            this.questionZoom = Math.max(this.questionZoomMin, +(this.questionZoom - this.questionZoomStep).toFixed(2));
            if (this.explanationMode) {
                setTimeout(() => { if (typeof initCanvases === 'function') initCanvases(); }, 80);
            }
        },
        resetQuestionZoom() {
            this.questionZoom = 1;
            if (this.explanationMode) {
                setTimeout(() => { if (typeof initCanvases === 'function') initCanvases(); }, 80);
            }
        },
        startStampDrag(e) {
            const p = e.touches ? e.touches[0] : e;
            this.stampPanel.dragging = true;
            this.stampPanel.offsetX = p.clientX - this.stampPanel.x;
            this.stampPanel.offsetY = p.clientY - this.stampPanel.y;
        },
        onStampDrag(e) {
            if (!this.stampPanel.dragging) return;
            const p = e.touches ? e.touches[0] : e;
            this.stampPanel.x = p.clientX - this.stampPanel.offsetX;
            this.stampPanel.y = p.clientY - this.stampPanel.offsetY;
            this.constrainStampPanel();
        },
        stopStampDrag() {
            this.stampPanel.dragging = false;
        },
        getStampPanelHeight() {
            const panel = document.getElementById('stamp-panel');
            if (panel && panel.offsetHeight > 0) {
                return panel.offsetHeight;
            }
            return Math.min(window.innerHeight * 0.8, 560);
        },
        constrainStampPanel() {
            const panelWidth = 180;
            const minTop = 70;
            const safeBottomGap = window.innerWidth < 768 ? 120 : 24;
            const availableHeight = Math.max(260, window.innerHeight - minTop - safeBottomGap);
            this.stampPanel.maxHeight = availableHeight;

            const panelHeight = this.getStampPanelHeight();
            const maxY = Math.max(minTop, window.innerHeight - panelHeight - safeBottomGap);
            this.stampPanel.x = Math.max(8, Math.min(window.innerWidth - panelWidth - 8, this.stampPanel.x));
            this.stampPanel.y = Math.max(minTop, Math.min(maxY, this.stampPanel.y));
        },
        toggleAnswerKey() {
            this.showAnswerKey = !this.showAnswerKey;
            const btn = document.getElementById('toggleAnswerBtn');
            const span = btn.querySelector('span');
            if (this.showAnswerKey) {
                btn.classList.add('ring-2', 'ring-yellow-400');
                span.textContent = 'Hide Answer Key';
            } else {
                btn.classList.remove('ring-2', 'ring-yellow-400');
                span.textContent = 'Show Answer Key';
            }
        },
        hexToRgba(hex, alpha) {
            let c;
            if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
                c= hex.substring(1).split('');
                if(c.length== 3){
                    c= [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c= '0x'+c.join('');
                return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+alpha+')';
            }
            return hex;
        },
        updateColor() {
             if (this.tool === 'highlight') {
                 this.color = this.hexToRgba(this.baseColor, this.opacity);
             } else {
                 this.color = this.baseColor;
             }
        },
        setTool(t) {
            this.tool = t;
            this.selectedStamp = null; 
            
            if(t === 'transparency') return; // slider guard?

            if(t === 'highlight') { 
                this.lineWidth = 25; 
                this.baseColor = this.colors.highlight[0];
            } else if (t === 'eraser') { 
                this.lineWidth = 20; 
            } else { // Pen, Line, Text
                this.lineWidth = 2; 
                this.baseColor = this.colors.pen[0];
            }
            this.updateColor();
        },
        setStamp(s) {
            this.tool = 'stamp';
            this.selectedStamp = s;
        },
        setColor(c) {
            this.color = c;
        },
        extractLaserCoords(arg1, arg2) {
            if (typeof arg1 === 'number' && typeof arg2 === 'number') {
                return { x: arg1, y: arg2 };
            }

            if (arg1 && typeof arg1 === 'object') {
                if (typeof arg1.clientX === 'number' && typeof arg1.clientY === 'number') {
                    return { x: arg1.clientX, y: arg1.clientY };
                }

                const t = arg1.touches && arg1.touches[0] ? arg1.touches[0] : (arg1.changedTouches && arg1.changedTouches[0] ? arg1.changedTouches[0] : null);
                if (t && typeof t.clientX === 'number' && typeof t.clientY === 'number') {
                    return { x: t.clientX, y: t.clientY };
                }
            }

            return { x: NaN, y: NaN };
        },
        getLaserBoundsRect() {
            const questionViewport = document.getElementById('question-viewport');
            if (questionViewport) {
                return questionViewport.getBoundingClientRect();
            }

            const questionCanvas = document.getElementById('global-explanation-canvas');
            if (questionCanvas) {
                return questionCanvas.getBoundingClientRect();
            }

            return null;
        },
        isPointInsideRect(x, y, rect) {
            if (!rect) return true;
            return x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom;
        },
        showLaserPointer(arg1, arg2, allowOutsideQuestion = false) {
            if (this.laserPointer.timeout) {
                clearTimeout(this.laserPointer.timeout);
            }

            const { x, y } = this.extractLaserCoords(arg1, arg2);

            if (!Number.isFinite(x) || !Number.isFinite(y)) return;

            if (!allowOutsideQuestion) {
                const rect = this.getLaserBoundsRect();
                if (!this.isPointInsideRect(x, y, rect)) {
                    this.hideLaserPointer();
                    return;
                }

                this.laserPointer.scope = 'question';
                this.laserPointer.localX = rect ? (x - rect.left) : x;
                this.laserPointer.localY = rect ? (y - rect.top) : y;
            } else {
                this.laserPointer.scope = 'global';
                this.laserPointer.localX = x;
                this.laserPointer.localY = y;
            }
            
            this.laserPointer.visible = true;
            this.laserPointer.x = x;
            this.laserPointer.y = y;
            this.addLaserTrailPoint(
                this.laserPointer.scope === 'question' ? this.laserPointer.localX : x,
                this.laserPointer.scope === 'question' ? this.laserPointer.localY : y,
                this.laserPointer.scope
            );
            this.laserPointer.timeout = setTimeout(() => {
                this.hideLaserPointer();
            }, 4000);
        },
        handleGlobalLaserDown(e) {
            if (!this.explanationMode || this.tool !== 'laser') return;
            this.laserPressing = true;
            this.showLaserPointer(e);
        },
        handleGlobalLaserMove(e) {
            if (!this.explanationMode || this.tool !== 'laser') return;
            const isMouse = e.pointerType === 'mouse' || !e.pointerType;
            if (isMouse && !(this.laserPressing || e.buttons === 1)) return;
            this.showLaserPointer(e);
        },
        handleGlobalLaserUp() {
            this.laserPressing = false;
        },
        hideLaserPointer() {
            this.laserPointer.visible = false;
            if (this.laserPointer.timeout) {
                clearTimeout(this.laserPointer.timeout);
                this.laserPointer.timeout = null;
            }
        }
    }"
    @mousemove.window="onStampDrag($event)"
    @touchmove.window="onStampDrag($event)"
    @mouseup.window="stopStampDrag()"
    @touchend.window="stopStampDrag()"
    @pointerdown.window="handleGlobalLaserDown($event)"
    @pointermove.window="handleGlobalLaserMove($event)"
    @pointerup.window="handleGlobalLaserUp()"
    @pointercancel.window="handleGlobalLaserUp()"
    @blur.window="handleGlobalLaserUp()"
    @resize.window="constrainStampPanel()">
        
        <!-- Auto-save Indicator -->
        <div id="autosave-indicator"
             class="fixed bottom-4 right-4 z-[200] flex items-center gap-1.5 px-3 py-1.5 bg-green-600 text-white text-xs font-semibold rounded-full shadow-lg transition-opacity duration-500 opacity-0 pointer-events-none">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            Tersimpan otomatis
        </div>

        <!-- Global Laser Pointer Overlay -->
        <div x-show="explanationMode" class="fixed inset-0 pointer-events-none z-[260]" style="display: none;">
            <template x-for="point in laserTrail.filter(p => p.scope === 'global')" :key="point.id">
                <div class="laser-trail-dot"
                     :style="`left: ${point.x}px; top: ${point.y}px; transform: translate(-2.5px, -2.5px);`"></div>
            </template>

            <div x-show="laserPointer.visible && laserPointer.scope === 'global'"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-50"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-150"
                 class="fixed"
                 :style="`left: ${laserPointer.x}px; top: ${laserPointer.y}px; transform: translate(-2.5px, -2.5px);`"
                 style="display: none;">
                <div class="laser-dot"></div>
            </div>
        </div>
        <!-- Explanation Mode Toggle (Header) -->
        <div class="mb-4 flex justify-end gap-2">
            <div class="px-3 py-2 rounded-lg bg-white/80 border border-gray-200 shadow-sm flex items-center gap-2">
                <button type="button" @click="zoomQuestionOut()" class="w-7 h-7 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">-</button>
                <span class="text-xs font-bold text-gray-600 min-w-[48px] text-center" x-text="Math.round(questionZoom * 100) + '%'">100%</span>
                <button type="button" @click="zoomQuestionIn()" class="w-7 h-7 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">+</button>
                <button type="button" @click="resetQuestionZoom()" class="px-2 py-1 rounded-md bg-gray-100 hover:bg-gray-200 text-[11px] font-semibold text-gray-700">Reset</button>
            </div>
        </div>

        <!-- Floating Explanation Mode Button -->
        <button @click="toggleMode()"
            :class="explanationMode ? 'bg-yellow-500 text-gray-900 ring-2 ring-yellow-200' : 'bg-gray-900 text-white'"
            class="fixed bottom-24 right-4 md:right-6 z-[120] h-14 w-14 sm:w-auto sm:min-w-[220px] sm:px-5 rounded-full font-bold shadow-xl transition hover:scale-105 active:scale-95 flex items-center justify-center gap-2 backdrop-blur-sm"
            :aria-label="explanationMode ? 'Keluar Mode Penjelasan' : 'Mode Penjelasan'"
            :title="explanationMode ? 'Keluar Mode Penjelasan' : 'Mode Penjelasan'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            <span class="hidden sm:inline" x-text="explanationMode ? 'Keluar Mode' : 'Mode Penjelasan'"></span>
        </button>

        <!-- Float Toolbar (Bottom Tools) -->
        <div x-show="explanationMode" x-transition 
             class="fixed bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl z-50 flex items-center gap-4 border border-gray-700">
            
            <!-- Pen -->
            <button @click="setTool('pen')" :class="tool === 'pen' ? 'text-blue-400 scale-110' : 'text-gray-400 hover:text-white'" class="transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                <span class="text-[10px]">Pen</span>
            </button>

            <!-- Line Tool -->
            <button @click="setTool('line')" :class="tool === 'line' ? 'text-blue-400 scale-110' : 'text-gray-400 hover:text-white'" class="transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 4L4 20"></path></svg>
                <span class="text-[10px]">Line</span>
            </button>

            <!-- Text Tool -->
            <button @click="setTool('text')" :class="tool === 'text' ? 'text-blue-400 scale-110' : 'text-gray-400 hover:text-white'" class="transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M12 7v9m-4 0h8"></path></svg>
                <span class="text-[10px]">Text</span>
            </button>

            <!-- Highlight -->
            <button @click="setTool('highlight')" :class="tool === 'highlight' ? 'text-yellow-400 scale-110' : 'text-gray-400 hover:text-white'" class="transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                <span class="text-[10px]">Stabilo</span>
            </button>

            <!-- Laser Pointer -->
            <button @click="setTool('laser')" :class="tool === 'laser' ? 'text-red-400 scale-110' : 'text-gray-400 hover:text-white'" class="transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" fill="currentColor"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h10"></path></svg>
                <span class="text-[10px]">Laser</span>
            </button>

            <!-- Eraser -->
            <button @click="setTool('eraser')" :class="tool === 'eraser' ? 'text-white scale-110' : 'text-gray-400 hover:text-white'" class="transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span class="text-[10px]">Eraser</span>
            </button>

            <div class="w-px h-8 bg-gray-700 mx-2"></div>

            <!-- Color Palette -->
            <div x-show="tool === 'pen' || tool === 'highlight' || tool === 'line' || tool === 'text'" class="flex items-center gap-2 animate-fade-in-right">
                <template x-for="c in colors[(tool === 'line' || tool === 'text') ? 'pen' : tool]" :key="c">
                    <button @click="baseColor = c; updateColor()"
                            class="w-6 h-6 rounded-full border-2 transition"
                            :class="baseColor === c ? 'border-white scale-110' : 'border-transparent hover:scale-105'"
                            :style="'background-color: ' + c"
                    ></button>
                </template>

                <!-- Opacity Slider (Highlighter Only) -->
                <div x-show="tool === 'highlight'" class="flex items-center gap-2 ml-2 border-l border-gray-700 pl-2">
                    <span class="text-[10px] text-gray-400">Opacity</span>
                    <input type="range" min="0.1" max="1.0" step="0.1" 
                           x-model.number="opacity" @input="updateColor()" 
                           class="w-16 h-1 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-yellow-400">
                </div>
            </div>

            <div class="w-px h-8 bg-gray-700 mx-2"></div>

            <!-- Undo -->
            <button onclick="undoLastAction()" class="text-gray-400 hover:text-white transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                <span class="text-[10px]">Undo</span>
            </button>

             <!-- Clear All -->
             <button onclick="clearAllCanvases()" class="text-red-500 hover:text-red-400 transition flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span class="text-[10px]">Clear All</span>
            </button>
        </div>

        <!-- Vertical Stamp Sidebar -->
        <div x-show="explanationMode" x-transition
               id="stamp-panel"
                         class="fixed bg-white/90 backdrop-blur-sm shadow-xl border border-gray-200 rounded-2xl p-2 z-[320] flex flex-col gap-2 overflow-y-auto"
                         :style="`left: ${stampPanel.x}px; top: ${stampPanel.y}px; width: 170px; max-height: ${stampPanel.maxHeight}px;`">
               <div class="flex items-center justify-between px-1 mb-1 cursor-move select-none"
                   @mousedown.prevent="startStampDrag($event)"
                   @touchstart.prevent="startStampDrag($event)">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Stamps</div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h8M8 15h8"></path></svg>
               </div>
             <button @click.stop="explanationMode = false" @mousedown.stop
                 class="w-full flex items-center justify-center gap-1 px-2 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-500 hover:bg-red-100 border border-red-200 transition mb-1">
                 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                 Keluar Mode
             </button>
             <template x-for="stamp in stamps" :key="stamp">
                <button @click="setStamp(stamp)"
                    class="px-3 py-2 rounded-lg text-xs font-bold transition shadow-sm border"
                    :class="selectedStamp === stamp ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-gray-50 text-gray-600 hover:bg-indigo-50 border-gray-100'"
                    x-text="stamp"
                ></button>
             </template>
        </div>

        <form id="question-form-container" action="{{ route('assignments.toefl-itp.structure.meeting.submit', $number) }}" method="POST" class="relative max-w-4xl mx-auto transition-transform duration-150" :style="`transform: scale(${questionZoom}); transform-origin: top center; width: ${100 / questionZoom}%;`">
            @csrf
            <div x-show="explanationMode"
                 class="absolute inset-0 z-40 pointer-events-none"
                 :class="{
                     'cursor-text': tool === 'text',
                     'cursor-crosshair': tool === 'line',
                     'cursor-tool-pen': tool === 'pen',
                     'cursor-tool-highlight': tool === 'highlight',
                     'cursor-tool-eraser': tool === 'eraser',
                     'cursor-laser': tool === 'laser'
                 }"
                 style="touch-action: none; display: none;">
                <canvas id="global-explanation-canvas" class="explanation-draw-canvas w-full h-full pointer-events-auto"></canvas>
            </div>

            <div id="question-viewport" class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
                <div x-show="explanationMode" class="absolute inset-0 pointer-events-none z-[255]" style="display: none;">
                    <template x-for="point in laserTrail.filter(p => p.scope === 'question')" :key="point.id">
                        <div class="laser-trail-dot"
                             :style="`left: ${point.x}px; top: ${point.y}px; transform: translate(-2.5px, -2.5px);`"></div>
                    </template>

                    <div x-show="laserPointer.visible && laserPointer.scope === 'question'"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-50"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-150"
                         class="absolute"
                           :style="`left: ${laserPointer.localX}px; top: ${laserPointer.localY}px; transform: translate(-2.5px, -2.5px);`"
                         style="display: none;">
                        <div class="laser-dot"></div>
                    </div>
                </div>
                <div class="space-y-8">
                    @forelse($questions as $question)
                    <div class="question-item relative group/item" x-data="{ selected: '{{ $userAnswer ?? '' }}' }">

                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                            <div class="absolute top-0 right-0 flex gap-2 transition z-50">
                                @if(Auth::user()->isAdmin())
                                <button type="button" onclick="openEditAnswerModal({{ $question->id }}, '{{ $question->correct_answer }}')" class="p-1 bg-yellow-100 text-yellow-600 rounded hover:bg-yellow-200" title="Edit Answer Key">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                </button>
                                <button type="button" onclick="openEditQuestionModal({{ $question }})" class="p-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('assignments.toefl-itp.structure.question.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Delete this question?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 bg-red-100 text-red-600 rounded hover:bg-red-200" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        @endif

                        @php
                            $userAnswer = null;
                            $correctAnswer = null;
                            $isCorrect = false;
                            if(session('score_data')) {
                                $userAnswer = session('answers')[$question->id] ?? null;
                                $correctAnswer = $question->correct_answer;
                                $isCorrect = $userAnswer === $correctAnswer;
                            }
                            
                            // Identify Written Expression type
                            $isWrittenExpression = str_contains($question->question_text, 'error-option');
                        @endphp

                        <div class="flex gap-4 items-start">
                            <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 font-bold rounded-lg text-sm {{ $isWrittenExpression ? 'mt-4' : '' }}">
                                {{ $question->question_number }}
                            </span>
                            

                            
                            <div class="flex-1" 
                                 @click.self="if($root.explanationMode && $root.tool === 'laser') { $root.showLaserPointer($event) }"
                                 x-init="$watch('selected', value => {
                                    $el.querySelectorAll('.error-option').forEach(opt => {
                                        opt.classList.toggle('selected-error', opt.dataset.label === value);
                                    });
                                 });
                                 // Initial check
                                 $nextTick(() => {
                                     $el.querySelectorAll('.error-option').forEach(opt => {
                                        opt.classList.toggle('selected-error', opt.dataset.label === selected);
                                    });
                                 });
                                 "
                                 @click="
                                    if ($event.target.classList.contains('error-option')) {
                                        selected = $event.target.dataset.label;
                                    } else if ($root.explanationMode && $root.tool === 'laser' && !$event.target.closest('label')) {
                                        $root.showLaserPointer($event);
                                    }
                                 ">
                                <!-- Conditional line-height only for Written Expression to handle labels -->
                                <p class="text-gray-800 font-medium mb-4 text-lg select-none" style="{{ $isWrittenExpression ? 'line-height: 3.5 !important;' : '' }}">{!! $question->question_text !!}</p>
                                
                                @if($isWrittenExpression)
                                    <!-- Written Expression Mode: Hidden Inputs + Clickable Text -->
                                    <div class="hidden">
                                        @foreach(['A', 'B', 'C', 'D'] as $option)
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" x-model="selected">
                                        @endforeach
                                    </div>
                                    <!-- Visual feedback for current selection is handled by the x-init logic above -->
                                @else
                                    <!-- Standard Multiple Choice Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach(['a', 'b', 'c', 'd'] as $option)
                                        @php
                                            $optionUpper = strtoupper($option);
                                            // Default class
                                            $staticClass = 'border-gray-200 hover:bg-gray-50';
                                            
                                            // PHP-based styling for scored state
                                            if(session('score_data')) {
                                                $checked = $userAnswer === $optionUpper;
                                                if($optionUpper === $correctAnswer) {
                                                    $staticClass = 'bg-green-50 border-green-500 ring-1 ring-green-500';
                                                } elseif($checked && !$isCorrect) {
                                                    $staticClass = 'bg-red-50 border-red-500 ring-1 ring-red-500';
                                                }
                                            }
                                        @endphp
                                        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition group relative"
                                            @if(session('score_data'))
                                                class="{{ $staticClass }}"
                                            @else
                                                :class="showAnswerKey && '{{ $optionUpper }}' === '{{ $question->correct_answer }}' ? 'border-green-500 bg-green-50 ring-1 ring-green-500' : (selected == '{{ $optionUpper }}' ? 'border-gray-300 bg-white' : 'border-gray-200 hover:bg-gray-50')"
                                            @endif
                                        >
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optionUpper }}" class="peer sr-only" x-model="selected" {{ session('score_data') ? 'disabled' : '' }}>
                                            
                                            <!-- Container for Badge and Text -->
                                            <div class="flex items-center gap-3 w-full p-1">
                                                <!-- Letter Badge -->
                                                <span class="w-8 h-8 min-w-[2rem] shrink-0 flex items-center justify-center rounded-full text-sm font-bold transition-colors border aspect-square"
                                                    @if(session('score_data'))
                                                        class="{{ $checked ? ($isCorrect ? 'bg-green-600 text-white border-green-600' : 'bg-red-600 text-white border-red-600') : 'bg-gray-50 text-gray-500 border-gray-200' }}"
                                                    @else
                                                        :class="showAnswerKey && '{{ $optionUpper }}' === '{{ $question->correct_answer }}' ? 'bg-green-600 text-white border-green-600' : (selected == '{{ $optionUpper }}' ? 'bg-red-600 text-white border-red-600' : 'bg-gray-50 text-gray-500 border-gray-200 group-hover:bg-gray-100')"
                                                    @endif
                                                >
                                                    {{ $optionUpper }}
                                                </span>

                                                <!-- Option Text -->
                                                <span class="font-medium transition-colors select-none"
                                                    @if(session('score_data'))
                                                        class="{{ $checked ? ($isCorrect ? 'text-green-700' : 'text-red-700') : 'text-gray-600' }}"
                                                    @else
                                                        :class="showAnswerKey && '{{ $optionUpper }}' === '{{ $question->correct_answer }}' ? 'text-green-700' : (selected == '{{ $optionUpper }}' ? 'text-red-600' : 'text-gray-600 group-hover:text-gray-900')"
                                                    @endif
                                                >
                                                    {{ $question->{'option_'.$option} }}
                                                </span>
                                            </div>
                                            
                                            @if(session('score_data'))
                                                @if($optionUpper === $correctAnswer)
                                                    <span class="absolute right-3 text-green-500">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </span>
                                                @elseif($checked && !$isCorrect)
                                                    <span class="absolute right-3 text-red-500">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </span>
                                                @endif
                                            @else
                                                <span x-show="showAnswerKey && '{{ $optionUpper }}' === '{{ $question->correct_answer }}'" class="absolute right-3 text-green-500">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </span>
                                            @endif
                                        </label>
                                        @endforeach
                                    </div>
                                @endif

                                @if(session('score_data'))
                                    @php
                                        $answerStatus = is_null($userAnswer) ? 'Belum Dijawab' : ($isCorrect ? 'Benar' : 'Salah');
                                        $answerStatusClass = is_null($userAnswer)
                                            ? 'bg-gray-100 text-gray-700 border-gray-300'
                                            : ($isCorrect ? 'bg-green-100 text-green-700 border-green-300' : 'bg-red-100 text-red-700 border-red-300');
                                    @endphp
                                    <div class="mt-4 p-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 space-y-3">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="text-xs font-bold px-2 py-1 rounded-md bg-white border border-slate-300">
                                                Kunci: {{ $correctAnswer ?? '-' }}
                                            </span>
                                            <span class="text-xs font-bold px-2 py-1 rounded-md bg-white border border-slate-300">
                                                Jawaban Anda: {{ $userAnswer ?? '-' }}
                                            </span>
                                            <span class="text-xs font-bold px-2 py-1 rounded-md border {{ $answerStatusClass }}">
                                                {{ $answerStatus }}
                                            </span>
                                        </div>

                                        <div class="rounded-lg border border-amber-200 bg-amber-50 p-3 text-amber-900">
                                            <p class="text-sm font-bold mb-1">Penjelasan Jawaban</p>
                                            <p class="text-sm leading-relaxed">
                                                {{ $question->explanation ?: 'Penjelasan belum tersedia untuk soal ini.' }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">No Questions Yet</h3>
                        <p class="text-gray-500">The content for this teaching/lesson is coming soon.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @if(session('score_data'))
            <!-- Score Card -->
            <div class="bg-white rounded-3xl shadow-lg border border-green-100 p-8 mb-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative z-10 text-center">
                    <h3 class="text-lg font-bold text-gray-400 mb-2 uppercase tracking-wider">Lesson Score</h3>
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <span class="text-6xl font-black text-gray-800">{{ round(session('score_data.score')) }}</span>
                        @if(session('score_data.score') <= 100)
                        <span class="text-2xl font-bold text-gray-400">/ 100</span>
                        @endif
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full font-bold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('score_data.correct_count') }} Correct Answers
                    </div>
                    
                    <div class="mt-8 flex justify-center gap-4">
                        <a href="{{ route('assignments.toefl-itp.structure.meeting', $number) }}" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition">
                            Try Again
                        </a>
                        <a href="{{ $backRoute }}" class="px-6 py-2 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition">
                            Finish Lesson
                        </a>
                    </div>
                </div>
            </div>
            @elseif(count($questions) > 0)
            <!-- Submit Button -->
            <div class="flex justify-end mt-2">
                <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl shadow-lg hover:bg-green-700 font-bold transition transform hover:-translate-y-1">
                    Submit Answers
                </button>
            </div>
            @endif
        </form>
    </div>

    <!-- SCRIPT FOR DRAWING -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                initCanvases();
            } else {
                document.addEventListener('DOMContentLoaded', initCanvases);
            }
        });

        // Re-init on resize
        window.addEventListener('resize', initCanvases);

        let canvases = {}; // Store canvas contexts and states
        let undoStack = []; // History stack for undo functionality

        // ===== AUTO-SAVE =====
        const AUTOSAVE_KEY = 'expl_canvas_{{ $number }}';
        let autoSaveTimer = null;

        function autoSaveCanvas() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                const canvas = document.getElementById('global-explanation-canvas');
                if (!canvas || canvas.width === 0 || canvas.height === 0) return;
                try {
                    localStorage.setItem(AUTOSAVE_KEY, canvas.toDataURL('image/png'));
                    const el = document.getElementById('autosave-indicator');
                    if (el) {
                        el.style.opacity = '1';
                        clearTimeout(el._t);
                        el._t = setTimeout(() => { el.style.opacity = '0'; }, 2000);
                    }
                } catch(e) {}
            }, 1500);
        }

        function restoreCanvasFromStorage() {
            const saved = localStorage.getItem(AUTOSAVE_KEY);
            if (!saved) return;
            const canvas = document.getElementById('global-explanation-canvas');
            if (!canvas || canvas.width === 0 || canvas.height === 0) return;
            const img = new Image();
            img.onload = () => canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
            img.src = saved;
        }
        // ===== END AUTO-SAVE =====

        function preventDrag(e) { e.preventDefault(); }

        // === TEXT TOOL HELPERS ===
        function createTextInput(x, y, canvas, ctx, color) {
            // Remove any existing inputs
            const existing = document.querySelector('.temp-text-input');
            if (existing) existing.remove();

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'temp-text-input absolute pointer-events-auto select-text';
            
            // Critical Styles for Interaction
            Object.assign(input.style, {
                left: x + 'px',
                top: (y - 12) + 'px',
                zIndex: '100',
                position: 'absolute',
                backgroundColor: '#ffffff',
                border: '2px solid #3B82F6',
                borderRadius: '4px',
                padding: '4px 8px',
                font: "bold 16px sans-serif",
                color: color,
                width: 'auto',
                minWidth: '100px',
                outline: 'none',
                boxShadow: '0 4px 6px rgba(0,0,0,0.1)',
                touchAction: 'manipulation', // Allow touch interaction
                userSelect: 'text',
                webkitUserSelect: 'text'
            });
            input.placeholder = 'Type...';

            canvas.parentElement.appendChild(input);
            
            // Force focus
            setTimeout(() => {
                input.focus();
                input.click(); // Mobile sometimes needs click
            }, 50);

            // Commit on blur or Enter
            const commit = () => {
                const text = input.value;
                if (text && text.trim().length > 0) {
                     // Undo
                     if (undoStack.length > 50) undoStack.shift();
                     undoStack.push({ id: canvas.id, imageData: ctx.getImageData(0, 0, canvas.width, canvas.height) });

                     ctx.font = "bold 16px sans-serif";
                     ctx.fillStyle = color;
                     ctx.fillText(text, x, y);
                }
                input.remove();
            };

            input.addEventListener('blur', commit);
            input.addEventListener('keydown', (e) => {
                if(e.key === 'Enter') input.blur(); 
            });
        }

        function initCanvases() {
            const canvasList = document.querySelectorAll('.explanation-draw-canvas');
            if (!canvasList.length) return;

            canvasList.forEach((canvas) => {
                const parent = canvas.parentElement;
                const id = canvas.id;
                if (!parent || !id) return;

                // Initialize State Object if needed
                if (!canvases[id]) {
                    canvases[id] = {
                        canvas: canvas,
                        ctx: canvas.getContext('2d'),
                        isDrawing: false,
                        lineState: null,
                        lastX: 0,
                        lastY: 0,
                        observer: null
                    };
                } else {
                    canvases[id].canvas = canvas;
                    canvases[id].ctx = canvas.getContext('2d');
                }

                // Context setup
                const data = canvases[id];
                const ctx = data.ctx;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                // Resize Observer for robust dimensions
                if (!data.observer) {
                    let _firstResize = true;
                    const observer = new ResizeObserver(() => {
                        const rect = parent.getBoundingClientRect();
                        if (canvas.width !== rect.width || canvas.height !== rect.height) {
                            if (rect.width > 0 && rect.height > 0) {
                                let snapshot = null;
                                if (!_firstResize) {
                                    try {
                                        snapshot = ctx.getImageData(0, 0, canvas.width, canvas.height);
                                    } catch (e) {}
                                }

                                canvas.width = rect.width;
                                canvas.height = rect.height;

                                ctx.lineCap = 'round';
                                ctx.lineJoin = 'round';

                                if (snapshot) {
                                    ctx.putImageData(snapshot, 0, 0);
                                } else if (_firstResize && id === 'global-explanation-canvas') {
                                    _firstResize = false;
                                    // Restore auto-saved drawing only for question canvas
                                    restoreCanvasFromStorage();
                                }
                            }
                        }
                    });
                    observer.observe(parent);
                    data.observer = observer;
                }

                // Remove old listeners
                canvas.removeEventListener('mousedown', startDrawing);
                canvas.removeEventListener('mousemove', draw);
                canvas.removeEventListener('mouseup', stopDrawing);
                canvas.removeEventListener('mouseout', stopDrawing);

                canvas.removeEventListener('touchstart', startDrawing);
                canvas.removeEventListener('touchmove', draw);
                canvas.removeEventListener('touchend', stopDrawing);
                canvas.removeEventListener('touchcancel', stopDrawing);

                canvas.removeEventListener('pointerdown', startDrawing);
                canvas.removeEventListener('pointermove', draw);
                canvas.removeEventListener('pointerup', stopDrawing);
                canvas.removeEventListener('pointerout', stopDrawing);
                canvas.removeEventListener('pointercancel', stopDrawing);

                canvas.removeEventListener('dragstart', preventDrag);

                // Add Listeners (Pointer Events - Unified)
                canvas.addEventListener('pointerdown', startDrawing);
                canvas.addEventListener('pointermove', draw);
                canvas.addEventListener('pointerup', stopDrawing);
                canvas.addEventListener('pointerout', stopDrawing);
                canvas.addEventListener('pointercancel', stopDrawing);

                // Prevent standard drag behavior
                canvas.addEventListener('dragstart', preventDrag);
            });
        }

        function getAlpineData() {
            return Alpine.$data(document.getElementById('explanation-container')); 
        }

        function getPointerPos(e, canvas, cachedRect = null) {
            const rect = cachedRect || canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;
            return {
                x: (e.clientX - rect.left) * scaleX,
                y: (e.clientY - rect.top) * scaleY
            };
        }

        function ensureCanvasReady(canvas, data) {
            const rect = canvas.getBoundingClientRect();
            if (rect.width <= 0 || rect.height <= 0) return rect;

            if (canvas.width !== Math.round(rect.width) || canvas.height !== Math.round(rect.height)) {
                let snapshot = null;
                try {
                    if (canvas.width > 0 && canvas.height > 0) {
                        snapshot = data.ctx.getImageData(0, 0, canvas.width, canvas.height);
                    }
                } catch (e) {}

                canvas.width = rect.width;
                canvas.height = rect.height;
                data.ctx = canvas.getContext('2d');
                data.ctx.lineCap = 'round';
                data.ctx.lineJoin = 'round';

                if (snapshot) {
                    data.ctx.putImageData(snapshot, 0, 0);
                }
            }
            return rect;
        }

        // ... helpers ...

        function startDrawing(e) {
            const app = getAlpineData();
            if (!app || !app.explanationMode) return;

            const canvas = e.target;
            const data = canvases[canvas.id];
            if (!data) return;

            // Cache rect for performance during this stroke
            data.rect = ensureCanvasReady(canvas, data);
            if (data.rect.width <= 0 || data.rect.height <= 0) return;

            // === LASER TOOL LOGIC ===
            if (app.tool === 'laser') {
                app.showLaserPointer(e);
                return; // Don't draw anything
            }

            // === TEXT TOOL LOGIC ===
            if (app.tool === 'text') {
                 if (e.cancelable) e.preventDefault(); 
                 const {x, y} = getPointerPos(e, canvas, data.rect);
                 createTextInput(x, y, canvas, data.ctx, app.color);
                 return;
            }

            // === OTHER TOOLS ===
            if (e.cancelable) e.preventDefault();
            
            // Capture pointer 
            if(canvas.setPointerCapture) {
                canvas.setPointerCapture(e.pointerId);
            }

            const {x, y} = getPointerPos(e, canvas, data.rect);

            // === LINE TOOL LOGIC ===
            if (app.tool === 'line') {
                data.isDrawing = false;
                if (data.lineState) {
                    const ctx = data.ctx;
                    ctx.putImageData(data.lineState.snapshot, 0, 0);
                    ctx.strokeStyle = app.color;
                    ctx.lineWidth = app.lineWidth;
                    ctx.beginPath();
                    ctx.moveTo(data.lineState.originX, data.lineState.originY);
                    ctx.lineTo(x, data.lineState.originY); 
                    ctx.stroke();
                    data.lineState = null; 
                    return;
                } else {
                    if (undoStack.length > 50) undoStack.shift();
                    const snapshot = data.ctx.getImageData(0, 0, canvas.width, canvas.height);
                    undoStack.push({ id: canvas.id, imageData: snapshot });
                    data.lineState = {
                        originX: x,
                        originY: y,
                        snapshot: snapshot
                    };
                    return;
                }
            }

            // === PEN / HIGHLIGHTER / ERASER / STAMP LOGIC ===
            data.lineState = null; 

            if (app.tool === 'stamp' && app.selectedStamp) {
                if (undoStack.length > 50) undoStack.shift(); 
                undoStack.push({ id: canvas.id, imageData: data.ctx.getImageData(0, 0, canvas.width, canvas.height) });
                drawStamp(data.ctx, app.selectedStamp, x, y);
                autoSaveCanvas();
                return;
            }

            data.isDrawing = true;
            [data.lastX, data.lastY] = [x, y];

            if (undoStack.length > 50) undoStack.shift(); 
            undoStack.push({ id: canvas.id, imageData: data.ctx.getImageData(0, 0, canvas.width, canvas.height) });

            const ctx = data.ctx;
            ctx.lineWidth = app.lineWidth;
            ctx.strokeStyle = app.color;
            
            // Style Configuration
            if (app.tool === 'highlight') {
                ctx.lineCap = 'butt';
                ctx.lineJoin = 'bevel';
            } else {
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
            }

            if(app.tool === 'eraser') {
                ctx.globalCompositeOperation = 'destination-out';
            } else {
                ctx.globalCompositeOperation = 'source-over';
            }
            
            ctx.beginPath();
            ctx.moveTo(x, y);
            if(app.tool !== 'eraser') {
                 ctx.lineTo(x + 0.1, y + 0.1); 
                 ctx.stroke();
            }
        }

        function draw(e) {
            const canvas = e.target;
            const data = canvases[canvas.id];
            const app = getAlpineData();

            if (!app || !app.explanationMode) return;
            if (!data) return;

            if (app.tool === 'laser') {
                const isMouse = e.pointerType === 'mouse' || !e.pointerType;
                if (isMouse && !(app.laserPressing || e.buttons === 1)) return;
                app.showLaserPointer(e);
                return;
            }
            
            const rect = data.rect || ensureCanvasReady(canvas, data); // Use cached rect
            if (rect.width <= 0 || rect.height <= 0) return;
            const {x, y} = getPointerPos(e, canvas, rect);
            const ctx = data.ctx;

            // === LINE TOOL PREVIEW ===
            if (app.tool === 'line') {
                if (data.lineState) {
                    ctx.putImageData(data.lineState.snapshot, 0, 0);
                    ctx.lineWidth = app.lineWidth;
                    ctx.strokeStyle = app.color;
                    ctx.beginPath();
                    ctx.moveTo(data.lineState.originX, data.lineState.originY);
                    ctx.lineTo(x, data.lineState.originY); 
                    ctx.stroke();
                }
                return; 
            }

            // === PEN / HIGHLIGHTER / ERASER ===
            if (!data.isDrawing) return; 

            ctx.lineWidth = app.lineWidth;
            ctx.strokeStyle = app.color;

            // Use Coalesced Events for smooth curves
            const events = e.getCoalescedEvents ? e.getCoalescedEvents() : [e];

            ctx.beginPath();
            // Start from the last known position
            ctx.moveTo(data.lastX, data.lastY);

            events.forEach(event => {
                const pos = getPointerPos(event, canvas, rect);
                // Draw line to new position
                ctx.lineTo(pos.x, pos.y);
                // Update last position for next frame/loop iteration
                // But we don't update data.lastX inside the loop for the moveTo? 
                // We update it so *after* the loop, data.lastX is the last pos.
                // However, for the *current* path, we just lineTo.
            });
            
            // Update global state to the last point of this batch
            if (events.length > 0) {
                 const lastEvent = events[events.length - 1];
                 const lastPos = getPointerPos(lastEvent, canvas, rect);
                 data.lastX = lastPos.x;
                 data.lastY = lastPos.y;
            }

            ctx.stroke();
        }

        function drawStamp(ctx, text, x, y) {
            ctx.font = "bold 11px sans-serif";
            const padding = 7;
            const metrics = ctx.measureText(text);
            const width = metrics.width + (padding * 2);
            const height = 22;
            const radius = 8;

            // Centering logic: Stamps are clicked at x,y. Let's center the pill there.
            const drawX = x - (width / 2);
            const drawY = y - (height / 2);

            // Draw Pill Shape
            ctx.beginPath();
            ctx.moveTo(drawX + radius, drawY);
            ctx.lineTo(drawX + width - radius, drawY);
            ctx.quadraticCurveTo(drawX + width, drawY, drawX + width, drawY + radius);
            ctx.lineTo(drawX + width, drawY + height - radius);
            ctx.quadraticCurveTo(drawX + width, drawY + height, drawX + width - radius, drawY + height);
            ctx.lineTo(drawX + radius, drawY + height);
            ctx.quadraticCurveTo(drawX, drawY + height, drawX, drawY + height - radius);
            ctx.lineTo(drawX, drawY + radius);
            ctx.quadraticCurveTo(drawX, drawY, drawX + radius, drawY);
            ctx.closePath();

            // Styling (Blue Theme)
            ctx.fillStyle = '#EFF6FF'; 
            ctx.fill();
            ctx.lineWidth = 1;
            ctx.strokeStyle = '#2563EB'; 
            ctx.stroke();

            // Text
            ctx.fillStyle = '#1E40AF';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(text, x, y);
        }

        function stopDrawing(e) {
            const app = getAlpineData();
            // Line tool does not stop on mouseup/pointerup (Wait for 2nd click)
            if (app && app.tool === 'line') return;

            const canvas = e.target;
            const data = canvases[canvas.id];
            
            if(data) data.isDrawing = false;

            // Release capture to return control to browser/other elements if needed
            if(canvas.releasePointerCapture && e.pointerId) {
                try {
                     canvas.releasePointerCapture(e.pointerId);
                } catch(err) {
                    // Ignore error if pointer was not captured
                }
            }

            // Auto-save after each stroke
            autoSaveCanvas();
        }

        async function saveExplanationCanvas() {
            const canvas = document.getElementById('global-explanation-canvas');
            if (!canvas) {
                alert('Explanation canvas not found.');
                return;
            }

            try {
                const image = canvas.toDataURL('image/png');
                const response = await fetch("{{ route('assignments.toefl-itp.structure.meeting.save-explanation', $number) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ image })
                });

                const data = await response.json();
                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Failed to save explanation.');
                }

                alert('Explanation saved successfully.');
                window.location.reload();
            } catch (error) {
                alert(error.message || 'Failed to save explanation.');
            }
        }

        function undoLastAction() {
            if (undoStack.length === 0) return;
            
            const lastState = undoStack.pop();
            const data = canvases[lastState.id];
            
            if (data && data.ctx) {
                data.ctx.putImageData(lastState.imageData, 0, 0);
            }
        }

        function clearAllCanvases() {
            if(confirm('Clear all drawings?')) {
                document.querySelectorAll('.explanation-draw-canvas').forEach((canvas) => {
                    const ctx = canvas.getContext('2d');
                    if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
                });
                localStorage.removeItem(AUTOSAVE_KEY);
            }
        }
    </script>
</div>
@if(true)
    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
    <!-- Answer Key Status Modal -->
    <div id="answerKeyStatusModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-16 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Daftar Answer Key</h3>
                <button type="button" onclick="closeAnswerKeyStatusModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="mb-4 text-sm text-gray-600">
                <span class="font-semibold">Terisi:</span> {{ $answerKeyFilledCount }}/{{ $totalQuestionCount }} soal
            </div>

            <div class="max-h-96 overflow-y-auto border border-gray-100 rounded-lg">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-4 py-2 font-semibold text-gray-600">Nomor</th>
                            <th class="text-left px-4 py-2 font-semibold text-gray-600">Answer Key</th>
                            <th class="text-left px-4 py-2 font-semibold text-gray-600">Status</th>
                            <th class="text-left px-4 py-2 font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                            @php
                                $answerKeyValue = trim((string) ($question->correct_answer ?? ''));
                                $isFilled = $answerKeyValue !== '';
                            @endphp
                            <tr class="border-b border-gray-50">
                                <td class="px-4 py-2 text-gray-700">{{ $question->question_number }}</td>
                                <td class="px-4 py-2">
                                    <select id="answer-key-select-{{ $question->id }}" class="border border-gray-300 rounded-md px-2 py-1 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="" {{ $answerKeyValue === '' ? 'selected' : '' }}>-</option>
                                        <option value="A" {{ strtoupper($answerKeyValue) === 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ strtoupper($answerKeyValue) === 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ strtoupper($answerKeyValue) === 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ strtoupper($answerKeyValue) === 'D' ? 'selected' : '' }}>D</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <span id="answer-key-status-{{ $question->id }}" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold {{ $isFilled ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $isFilled ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                        {{ $isFilled ? 'Terisi' : 'Kosong' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <button type="button" onclick="saveAnswerKeyFromStatusModal({{ $question->id }})" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs font-semibold hover:bg-blue-700 transition">
                                        Simpan
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5 flex justify-end">
                <button type="button" onclick="closeAnswerKeyStatusModal()" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300 transition">Tutup</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Add Question Modal -->
    <div id="addQuestionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Add Question</h3>
            <form action="{{ route('assignments.toefl-itp.structure.question.store', $number) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Number</label>
                        <input type="number" name="question_number" value="{{ count($questions) + 1 }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div>
                         <label class="block text-gray-700 text-sm font-bold mb-2">Correct Answer</label>
                         <select name="correct_answer" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                         </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                    <textarea name="question_text" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-xs font-bold mb-1">Option A</label><input type="text" name="option_a" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                    <div><label class="block text-xs font-bold mb-1">Option B</label><input type="text" name="option_b" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                    <div><label class="block text-xs font-bold mb-1">Option C</label><input type="text" name="option_c" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                    <div><label class="block text-xs font-bold mb-1">Option D</label><input type="text" name="option_d" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('addQuestionModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded text-gray-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 rounded text-white">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Answer Modal -->
    <div id="editAnswerModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border w-11/12 md:w-1/3 shadow-lg rounded-lg bg-white">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Answer Key</h3>
            <form id="editAnswerForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-3">Select Correct Answer:</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="answer-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-bold text-lg hover:bg-blue-50 transition" data-answer="A">A</button>
                        <button type="button" class="answer-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-bold text-lg hover:bg-blue-50 transition" data-answer="B">B</button>
                        <button type="button" class="answer-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-bold text-lg hover:bg-blue-50 transition" data-answer="C">C</button>
                        <button type="button" class="answer-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-bold text-lg hover:bg-blue-50 transition" data-answer="D">D</button>
                    </div>
                    <input type="hidden" name="correct_answer" id="selectedAnswer" value="">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('editAnswerModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded text-gray-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 rounded text-white font-bold">Update Answer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div id="editQuestionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Question</h3>
            <form id="editQuestionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Number</label>
                        <input type="number" name="question_number" id="edit_num" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div>
                         <label class="block text-gray-700 text-sm font-bold mb-2">Correct Answer</label>
                         <select name="correct_answer" id="edit_ans" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                         </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                    <textarea name="question_text" id="edit_text" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-xs font-bold mb-1">Option A</label><input type="text" name="option_a" id="edit_a" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                    <div><label class="block text-xs font-bold mb-1">Option B</label><input type="text" name="option_b" id="edit_b" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                    <div><label class="block text-xs font-bold mb-1">Option C</label><input type="text" name="option_c" id="edit_c" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                    <div><label class="block text-xs font-bold mb-1">Option D</label><input type="text" name="option_d" id="edit_d" class="shadow border rounded w-full py-2 px-3 text-gray-700"></div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('editQuestionModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded text-gray-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded text-white">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAnswerKeyStatusModal() {
            const modal = document.getElementById('answerKeyStatusModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeAnswerKeyStatusModal() {
            const modal = document.getElementById('answerKeyStatusModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function saveAnswerKeyFromStatusModal(questionId) {
            const selectEl = document.getElementById(`answer-key-select-${questionId}`);
            const statusEl = document.getElementById(`answer-key-status-${questionId}`);
            if (!selectEl) return;

            const answer = (selectEl.value || '').toUpperCase().trim();
            if (!answer) {
                alert('Pilih answer key terlebih dahulu.');
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('correct_answer', answer);

            fetch(`/assignments/toefl-itp/structure/question/${questionId}/update-answer`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Gagal menyimpan answer key.');
                }

                if (statusEl) {
                    statusEl.className = 'inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700';
                    statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Terisi';
                }

                alert('Answer key berhasil diperbarui.');
                window.location.reload();
            })
            .catch(error => {
                alert(error.message || 'Terjadi kesalahan saat menyimpan answer key.');
            });
        }

        function openAddQuestionModal() {
            document.getElementById('addQuestionModal').classList.remove('hidden');
        }

        function openEditQuestionModal(question) {
            document.getElementById('edit_num').value = question.question_number;
            document.getElementById('edit_text').value = question.question_text;
            document.getElementById('edit_ans').value = question.correct_answer;
            document.getElementById('edit_a').value = question.option_a;
            document.getElementById('edit_b').value = question.option_b;
            document.getElementById('edit_c').value = question.option_c;
            document.getElementById('edit_d').value = question.option_d;
            
            document.getElementById('editQuestionForm').action = "/assignments/toefl-itp/structure/question/" + question.id;
            document.getElementById('editQuestionModal').classList.remove('hidden');
        }

        let currentQuestionIdForAnswer = null;

        function openEditAnswerModal(questionId, currentAnswer) {
            currentQuestionIdForAnswer = questionId;
            document.getElementById('selectedAnswer').value = currentAnswer;
            
            // Reset button states
            document.querySelectorAll('.answer-btn').forEach(btn => {
                btn.classList.remove('bg-green-100', 'border-green-500');
                btn.classList.add('border-gray-300');
            });
            
            // Highlight current answer
            document.querySelectorAll('.answer-btn').forEach(btn => {
                if (btn.dataset.answer === currentAnswer) {
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('bg-green-100', 'border-green-500', 'border-2');
                }
            });
            
            document.getElementById('editAnswerModal').classList.remove('hidden');
        }

        // Answer button click handler
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.answer-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const answer = this.dataset.answer;
                    document.getElementById('selectedAnswer').value = answer;
                    
                    // Update UI
                    document.querySelectorAll('.answer-btn').forEach(b => {
                        b.classList.remove('bg-green-100', 'border-green-500');
                        b.classList.add('border-gray-300');
                    });
                    this.classList.remove('border-gray-300');
                    this.classList.add('bg-green-100', 'border-green-500', 'border-2');
                });
            });

            // Handle edit answer form submission
            document.getElementById('editAnswerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const answer = document.getElementById('selectedAnswer').value;
                
                if (!answer) {
                    alert('Please select an answer');
                    return;
                }

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('correct_answer', answer);

                fetch(`/assignments/toefl-itp/structure/question/${currentQuestionIdForAnswer}/update-answer`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Answer updated successfully!');
                        document.getElementById('editAnswerModal').classList.add('hidden');
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to update answer'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating answer');
                });
            });
        });
    </script>
@endif
    <!-- Irregular Verbs Button -->
    <x-irregular-verbs-button />

@endsection
