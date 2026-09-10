<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Describe Image Topics | {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white flex flex-col min-h-screen">

    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            {{-- Header --}}
            <div class="mb-6 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                <div class="flex justify-end mb-2">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Back</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}"
                                    class="hover:text-gray-700 transition">Speaking & Writing</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span class="text-gray-600 font-medium">Describe Image</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">{{ count($topics) }} Describe Image Topics</h1>
                            <p class="text-gray-600 mt-1">Pilih topik untuk memulai latihan speaking Describe Image
                                Anda.</p>
                        </div>
                </div>
            </div>



            {{-- Topics Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @for ($i = 1; $i <= count($topics); $i++)
                    <a id="topic-{{ $i }}" data-topic-card="{{ $i }}" href="{{ route('assignments.pte-academic.speaking-writing.describe-image.practice', ['id' => $i]) }}"
                        class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:border-blue-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-50 overflow-hidden flex flex-col">
                        {{-- Decorative background element --}}
                        <div
                            class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 ease-out">
                        </div>
                    <x-pte-topic-badge />

                        <div class="relative flex items-center justify-between w-full mb-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-xl shadow-md flex items-center justify-center font-bold text-lg group-hover:shadow-lg group-hover:from-blue-500 group-hover:to-blue-700 transition-all duration-50">
                                {{ $i }}
                            </div>
                            <div
                                class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-50 group-hover:bg-white group-hover:text-blue-600 transition-all duration-50">
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <div class="relative mt-auto">
                            <h3 class="text-gray-800 font-bold text-lg mb-1 group-hover:text-blue-600 transition-colors">
                                {{ $topics[$i]['title'] }}</h3>
                            <p class="text-gray-500 text-xs flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                    </path>
                                </svg>
                                Describe Image Practice
                            </p>
                        </div>
                    </a>
                @endfor
            </div>

        </main>
    </div>

    {{-- Floating Button & Draggable/Resizable/Pinnable Tips Modal --}}
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

        {{-- Draggable, Resizable, Pinnable Tips Modal --}}
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

                    {{-- Modal Content --}}
                    <div class="p-6 md:p-8 overflow-y-auto bg-white space-y-8">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-2 flex items-center gap-2">
                                Strategi Utama
                            </h3>
                            <p class="text-gray-600 bg-white p-4 rounded-xl border border-gray-200">Baca <strong>hanya clue saja</strong>. Begitu timer mencapai <strong>detik ke-25 ke atas</strong>, langsung tutup dengan conclusion.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="bg-white px-4 py-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-800">OPSI 1 <span class="text-sm font-normal text-gray-500">(Umum/Gambar)</span></h4>
                                </div>
                                <div class="p-4 space-y-4 text-sm">
                                    <div class="text-gray-600 font-medium italic bg-white p-3 rounded-lg border border-gray-100">
                                        "From the following picture I know information about [title]. According to the picture I notice with [clues]. furthermore it explains about [clues] moreover it has [clues] additionally it addresses about [clues], to sum up the picture shows good essential information of [title]."
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Example (Supermarket):</p>
                                        <p class="text-gray-600 leading-relaxed">
                                            "From the following picture I know information about <span class="font-semibold text-gray-800">Supermarket</span>. According to the picture I notice <span class="font-semibold text-gray-800">a lot of produce in this supermarket</span>. furthermore it explain about <span class="font-semibold text-gray-800">several sections</span> moreover it has <span class="font-semibold text-gray-800">fruit sections and vegetable sections with variety samples</span> additionally it addresses about <span class="font-semibold text-gray-800">peach, apple, plum, oranges, watermelon, cabbage, eggplant, lettuce, and others</span>, to sum up the picture shows good essential information of <span class="font-semibold text-gray-800">the best Supermarket in town</span>."
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="bg-white px-4 py-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-800">OPSI 2 <span class="text-sm font-normal text-gray-500">(Chart/Graph)</span></h4>
                                </div>
                                <div class="p-4 space-y-4 text-sm">
                                    <div class="text-gray-600 font-medium italic bg-white p-3 rounded-lg border border-gray-100">
                                        "From the following [chart/topic/graph/image] I know this information is about [title]. According to the graph, the percentage of [option items] from about [percentage] in [year] to about [percentage] in [year]. What's more, there are many percentages from the lowest until the highest. The lowest is [percentage] and the highest [percentage]. To sum up, the picture is about [title]."
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Example (Trend):</p>
                                        <p class="text-gray-600 leading-relaxed">
                                            "The provided chart illustrates the growth of <span class="font-semibold text-gray-800">Online purchase Trend</span>. According to the graph, the percentage of <span class="font-semibold text-gray-800">China</span> increased from about <span class="font-semibold text-gray-800">12%</span> in <span class="font-semibold text-gray-800">2016</span> to about <span class="font-semibold text-gray-800">23%</span> in <span class="font-semibold text-gray-800">2026</span>. What's more, there is a wide range of percentages from the lowest until the highest; the lowest is <span class="font-semibold text-gray-800">6%</span> recorded in the early stages, and the highest reaches <span class="font-semibold text-gray-800">38%</span> in the most recent projection. To sum up, the picture is about the significant upward <span class="font-semibold text-gray-800">trend of Online purchase Trend</span>."
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                                Tips Describe Image
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">1. Manajemen Waktu (Time Management)</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Durasi Ideal:</strong> Waktu terbaik untuk menjawab adalah sekitar <strong>35 - 38 detik</strong>.</li>
                                            <li><strong>Segera Klik "Next":</strong> Jangan menunggu sampai progress bar habis (40 detik). Segera klik tombol "Next" tepat setelah Anda mengucapkan kesimpulan untuk menghindari AI merekam keheningan (dead air) atau suara napas yang bisa merusak skor kelancaran.</li>
                                        </ul>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">2. Kelancaran & Intonasi</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Kestabilan Suara:</strong> Jaga fluency (kelancaran) dan intonasi agar tetap stabil.</li>
                                            <li><strong>Haram Hukumnya Berjeda:</strong> Usahakan tidak membuat jeda yang tidak wajar (seperti umm, ahh, atau terdiam mikir) di tengah kalimat. Algoritma AI sangat sensitif terhadap keraguan (hesitation); skor akan turun drastis jika Anda terputus-putus.</li>
                                            <li><strong class="text-red-600">Jangan Koreksi Diri Sendiri (PENTING):</strong> Jika Anda salah mengucapkan sebuah kata, JANGAN diulangi atau diperbaiki. Teruslah berbicara seolah-olah tidak terjadi kesalahan. Bagi AI PTE: <strong>Fluency > Content</strong>.</li>
                                            <li><strong>Tempo Bicara:</strong> Kelancaran bukan berarti berbicara secepat kilat. Bicaralah dengan tempo normal yang jelas artikulasinya.</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">3. Variasi Kosakata & Transisi</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Gunakan Conjunction Variatif:</strong> Gunakan kata hubung yang kaya untuk merangkai ide, seperti: <em>Firstly, Moreover, Additionally, Furthermore, Subsequently, In contrast,</em> dan <em>Lastly/To conclude</em>.</li>
                                            <li><strong>Hindari Repetisi:</strong> Jangan menggunakan conjunction atau kosakata yang sama berulang-ulang secara berdekatan (misal: terus-terusan memakai kata <em>And then, I can see, we can see, in front of,</em> atau <em>Also</em>).</li>
                                        </ul>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">4. Pengembangan Konten Grafik</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Analisis Komprehensif:</strong> Jangan hanya menyebutkan titik tertinggi dan terendah.</li>
                                            <li><strong>Jelaskan Pergerakan Data:</strong> Tambahkan penjelasan terkait: Tren kenaikan, Tren penurunan, Fluktuasi, atau Rata-rata/Kesetaraan data.</li>
                                        </ul>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">5. Improvisasi & Darurat</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Kembangkan Kalimat:</strong> Improvisasikan kalimat turunan untuk menunjang nilai Konten. Gabungkan beberapa elemen gambar menjadi satu kalimat utuh.</li>
                                            <li><strong>Taktik Jika Nge-blank:</strong> Jika di detik ke-20 Anda kehabisan ide, jangan diam! Sebutkan saja warna yang ada di gambar, bentuk objek, atau baca teks apa pun yang terlihat di layar untuk menjaga mulut tetap bergerak sampai mendekati detik ke-35.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Interactive Drag Resize Handle Corner --}}
                    <div @mousedown.stop="startResize" @touchstart.stop="startResize"
                         class="absolute bottom-0 right-0 w-9 h-9 cursor-se-resize flex items-center justify-center z-30 hover:scale-110 transition-all bg-amber-500/20 rounded-tl-xl hover:bg-amber-500 hover:text-white text-amber-600 shadow-md border-t border-l border-amber-300/50"
                         style="touch-action: none;"
                         title="Tarik sudut ini untuk mengukur ulang window tips">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 16v-4h-2v2h-2v2h4zM16 8v-2h-2v2h2zM12 12v-2h-2v2h2zM8 16v-2h-2v2h2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </template>
    </div>


    <script src="{{ asset('js/pte-tracking.js') }}"></script>
    <script>
        pteTracking.init('describe-image');
    </script>

</body>
</html>