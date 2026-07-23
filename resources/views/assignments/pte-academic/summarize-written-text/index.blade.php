<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Summarize Written Text | {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

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

        <main class="flex-1 md:ml-64 p-8">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="hover:text-emerald-600 transition">Speaking &amp; Writing</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Summarize Written Text</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">300 Summarize Written Text Topics</h1>
                            <p class="text-gray-600 mt-1">Pilih topik untuk memulai latihan Summarize Written Text Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @for ($i = 1; $i <= 300; $i++)
                <a id="topic-{{ $i }}" data-topic-card="{{ $i }}" href="{{ route('assignments.pte-academic.speaking-writing.summarize-written-text.practice', ['id' => $i]) }}" class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <x-pte-topic-badge />
                    <div class="relative flex items-center justify-between w-full mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 text-white rounded-xl shadow-md flex items-center justify-center font-bold text-lg group-hover:shadow-lg transition-all duration-300">
                            {{ $i }}
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-all duration-300">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                    <div class="relative mt-auto">
                        <h3 class="text-gray-800 font-bold text-lg mb-1 group-hover:text-emerald-700 transition-colors">{{ $topics[$i]['title'] }}</h3>
                        <p class="text-gray-500 text-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Summarize Written Text Practice
                        </p>
                    </div>
                </a>
                @endfor
            </div>
            {{-- Floating Tips Button --}}
            <div x-data="{ 
                showTips: false,
                isDragged: false,
                dragging: false,
                x: window.innerWidth / 2 - 50,
                y: window.innerHeight - 100,
                startX: 0,
                startY: 0,
                start(e) {
                    this.dragging = true;
                    this.isDragged = false;
                    let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
                    this.startX = clientX - this.x;
                    this.startY = clientY - this.y;
                },
                move(e) {
                    if (!this.dragging) return;
                    e.preventDefault();
                    this.isDragged = true;
                    let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
                    this.x = clientX - this.startX;
                    this.y = clientY - this.startY;
                    
                    // Keep within screen bounds
                    this.x = Math.max(0, Math.min(this.x, window.innerWidth - 60));
                    this.y = Math.max(0, Math.min(this.y, window.innerHeight - 60));
                },
                end() {
                    this.dragging = false;
                    // Reset position if dragged out of bounds
                    if (this.x < 0) this.x = 0;
                    if (this.y < 0) this.y = 0;
                    if (this.x > window.innerWidth - 60) this.x = window.innerWidth - 60;
                    if (this.y > window.innerHeight - 60) this.y = window.innerHeight - 60;
                }
            }" 
            @mousemove.window="move" @mouseup.window="end" @touchmove.window="move" @touchend.window="end">
                <button @click.prevent="if(!isDragged) showTips = true" 
                        @mousedown="start" @touchstart="start"
                        class="fixed z-50 text-white p-4 rounded-full shadow-2xl flex items-center gap-2 select-none"
                        :style="`left: ${x}px; top: ${y}px; background-color: #eab308; touch-action: none;`"
                        :class="dragging ? 'cursor-grabbing scale-105' : 'cursor-grab hover:scale-105 transition-transform'"
                        title="Tips & Strategi">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold hidden md:inline text-white">Tips</span>
                </button>

                {{-- Tips Modal --}}
                <template x-teleport="body">
                    <div x-show="showTips" style="display: none;" class="fixed inset-0 bg-transparent z-[100] flex items-center justify-center p-4">
                        <div @click.away="showTips = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-gray-200">
                            <div class="flex items-center justify-between p-6 border-b border-blue-100 bg-blue-50">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-blue-900">Tips Summarize Written Text (SWT)</h2>
                                        <p class="text-blue-600 text-sm">Panduan dan format jawaban Anda.</p>
                                    </div>
                                </div>
                                <button @click="showTips = false" class="text-blue-400 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="p-6 overflow-y-auto bg-white">
                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Aturan Penting</h4>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-2 list-disc ml-4">
                                        <li><strong>Syarat Kata:</strong> Mention 50-75 words in the last paragraph. Jika lebih dari 75 kata akan langsung mendapat skor 0.</li>
                                        <li><strong>Tanda Baca:</strong> Tidak boleh ada 2 titik dalam 1 jawaban (Harus menjadi 1 kalimat utuh).</li>
                                        <li><strong>Kapitalisasi & Parafrase:</strong> Huruf awal di paragraf tengah dan akhir diganti huruf kecil. Usahakan menggunakan parafrase atau sinonim (contoh: people diganti persons).</li>
                                        <li><strong>Format:</strong> Tanda kurung () dihapus saat tes.</li>
                                    </ul>
                                </div>
                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Template Summarize Written Text</h4>
                                    </div>
                                    <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-2">
                                        <p>The article presents <span class="text-amber-600 font-bold">[ ___ ]</span> that highlights <span class="text-amber-600 font-bold">[ ___ ]</span>, elaborates on <span class="text-amber-600 font-bold">[ ___ ]</span>, and explains <span class="text-amber-600 font-bold">[ ___ ]</span>, while also considering <span class="text-amber-600 font-bold">[ ___ ]</span>, thus showing <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                    </div>
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
        pteTracking.init('summarize-written-text');
    </script>

</body>
</html>
