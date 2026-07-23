<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reading: Fill in the Blanks | Target Bahasa</title>
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
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic.reading.index') }}" class="hover:text-blue-600 transition">Reading</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Reading: Fill in the Blanks</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">300 Practice Topics</h1>
                            <p class="text-gray-600 mt-1">Pilih topik untuk memulai latihan Reading: Fill in the Blanks.</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.pte-academic.reading.index') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @for ($i = 1; $i <= 300; $i++)
                <a id="topic-{{ $i }}" data-topic-card="{{ $i }}" href="{{ route('assignments.pte-academic.reading.reading-fill-blanks.practice', ['id' => $i]) }}" class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <x-pte-topic-badge />
                    <div class="relative flex items-center justify-between w-full mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-xl shadow-md flex items-center justify-center font-bold text-lg group-hover:shadow-lg transition-all duration-300">
                            {{ $i }}
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 group-hover:bg-blue-50 group-hover:text-blue-500 transition-all duration-300">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                    <div class="relative mt-auto">
                        <h3 class="text-gray-800 font-bold text-lg mb-1 group-hover:text-blue-700 transition-colors">{{ $topics[$i]['title'] }}</h3>
                        <p class="text-gray-500 text-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>
                            Reading: Fill in the Blanks
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
                        <div @click.away="showTips = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-gray-200">
                            <div class="flex items-center justify-between p-6 border-b border-blue-100 bg-blue-50 shrink-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-blue-900">B. Common Reading Collocations (FIB)</h2>
                                        <p class="text-blue-600 text-sm">Daftar padanan kata esensial yang paling sering muncul di Reading Fill in the Blanks. (Daftar ini telah dirapikan dan disortir dari data repetitif).</p>
                                    </div>
                                </div>
                                <button @click="showTips = false" class="text-blue-400 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="p-6 overflow-y-auto bg-gray-50 flex-1">

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-gray-100 border-b border-gray-200">
                                                    <th class="p-3 text-gray-700 font-bold border-r border-gray-200">Collocation (English)</th>
                                                    <th class="p-3 text-gray-700 font-bold border-r border-gray-200">Arti (Indonesian)</th>
                                                    <th class="p-3 text-gray-700 font-bold border-r border-gray-200">Collocation (English)</th>
                                                    <th class="p-3 text-gray-700 font-bold">Arti (Indonesian)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Row 1 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">make a decision</td>
                                                    <td class="p-3 border-r border-gray-200">membuat keputusan</td>
                                                    <td class="p-3 border-r border-gray-200">reach a conclusion</td>
                                                    <td class="p-3">mencapai kesimpulan</td>
                                                </tr>
                                                <!-- Row 2 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">draw a conclusion</td>
                                                    <td class="p-3 border-r border-gray-200">menarik kesimpulan</td>
                                                    <td class="p-3 border-r border-gray-200">play a crucial/key role</td>
                                                    <td class="p-3">memainkan peran penting/utama</td>
                                                </tr>
                                                <!-- Row 3 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">take responsibility</td>
                                                    <td class="p-3 border-r border-gray-200">mengambil tanggung jawab</td>
                                                    <td class="p-3 border-r border-gray-200">gain experience/knowledge</td>
                                                    <td class="p-3">mendapat pengalaman/pengetahuan</td>
                                                </tr>
                                                <!-- Row 4 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">obtain information</td>
                                                    <td class="p-3 border-r border-gray-200">memperoleh informasi</td>
                                                    <td class="p-3 border-r border-gray-200">provide evidence/support</td>
                                                    <td class="p-3">memberikan bukti/dukungan</td>
                                                </tr>
                                                <!-- Row 5 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">conduct/carry out research</td>
                                                    <td class="p-3 border-r border-gray-200">melakukan penelitian</td>
                                                    <td class="p-3 border-r border-gray-200">raise/increase awareness</td>
                                                    <td class="p-3">meningkatkan kesadaran</td>
                                                </tr>
                                                <!-- Row 6 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">pose a threat/risk</td>
                                                    <td class="p-3 border-r border-gray-200">menimbulkan ancaman/risiko</td>
                                                    <td class="p-3 border-r border-gray-200">face/pose challenges</td>
                                                    <td class="p-3">menghadapi/menimbulkan tantangan</td>
                                                </tr>
                                                <!-- Row 7 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">meet requirements</td>
                                                    <td class="p-3 border-r border-gray-200">memenuhi persyaratan</td>
                                                    <td class="p-3 border-r border-gray-200">achieve success/goals</td>
                                                    <td class="p-3">mencapai kesuksesan/tujuan</td>
                                                </tr>
                                                <!-- Row 8 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">solve a problem</td>
                                                    <td class="p-3 border-r border-gray-200">memecahkan masalah</td>
                                                    <td class="p-3 border-r border-gray-200">address an issue</td>
                                                    <td class="p-3">menangani masalah</td>
                                                </tr>
                                                <!-- Row 9 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">have an impact/effect</td>
                                                    <td class="p-3 border-r border-gray-200">memiliki dampak/efek</td>
                                                    <td class="p-3 border-r border-gray-200">take into account</td>
                                                    <td class="p-3">mempertimbangkan</td>
                                                </tr>
                                                <!-- Row 10 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">pay attention</td>
                                                    <td class="p-3 border-r border-gray-200">memberikan perhatian</td>
                                                    <td class="p-3 border-r border-gray-200">come to/reach an agreement</td>
                                                    <td class="p-3">mencapai kesepakatan</td>
                                                </tr>
                                                <!-- Row 11 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">build relationships</td>
                                                    <td class="p-3 border-r border-gray-200">membangun hubungan</td>
                                                    <td class="p-3 border-r border-gray-200">develop skills/knowledge</td>
                                                    <td class="p-3">mengembangkan keterampilan/ilmu</td>
                                                </tr>
                                                <!-- Row 12 (Image 2) -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">increase productivity</td>
                                                    <td class="p-3 border-r border-gray-200">meningkatkan produktivitas</td>
                                                    <td class="p-3 border-r border-gray-200">improve performance/quality</td>
                                                    <td class="p-3">meningkatkan kinerja/kualitas</td>
                                                </tr>
                                                <!-- Row 13 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">reduce costs/pollution/risk</td>
                                                    <td class="p-3 border-r border-gray-200">mengurangi biaya/polusi/risiko</td>
                                                    <td class="p-3 border-r border-gray-200">create opportunities/value</td>
                                                    <td class="p-3">menciptakan peluang/nilai</td>
                                                </tr>
                                                <!-- Row 14 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">generate income/interest</td>
                                                    <td class="p-3 border-r border-gray-200">menghasilkan pendapatan/minat</td>
                                                    <td class="p-3 border-r border-gray-200">offer a chance/solutions</td>
                                                    <td class="p-3">memberikan kesempatan/solusi</td>
                                                </tr>
                                                <!-- Row 15 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">apply knowledge/theory</td>
                                                    <td class="p-3 border-r border-gray-200">menerapkan pengetahuan/teori</td>
                                                    <td class="p-3 border-r border-gray-200">take action/measures/steps</td>
                                                    <td class="p-3">mengambil tindakan/langkah</td>
                                                </tr>
                                                <!-- Row 16 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">take advantage</td>
                                                    <td class="p-3 border-r border-gray-200">memanfaatkan</td>
                                                    <td class="p-3 border-r border-gray-200">make progress/improvements</td>
                                                    <td class="p-3">membuat kemajuan/perbaikan</td>
                                                </tr>
                                                <!-- Row 17 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">have access/difficulty</td>
                                                    <td class="p-3 border-r border-gray-200">memiliki akses/kesulitan</td>
                                                    <td class="p-3 border-r border-gray-200">conduct experiments/surveys</td>
                                                    <td class="p-3">melakukan eksperimen/survei</td>
                                                </tr>
                                                <!-- Row 18 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">draw attention/comparisons</td>
                                                    <td class="p-3 border-r border-gray-200">menarik perhatian/perbandingan</td>
                                                    <td class="p-3 border-r border-gray-200">cause damage/concern</td>
                                                    <td class="p-3">menyebabkan kerusakan/kekhawatiran</td>
                                                </tr>
                                                <!-- Row 19 -->
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="p-3 border-r border-gray-200">take part in activities</td>
                                                    <td class="p-3 border-r border-gray-200">ikut serta dalam aktivitas</td>
                                                    <td class="p-3 border-r border-gray-200">gain recognition/support</td>
                                                    <td class="p-3">mendapatkan pengakuan/dukungan</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
        pteTracking.init('reading-fill-blanks');
    </script>

</body>
</html>
