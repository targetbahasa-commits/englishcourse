@php
$freeLessons = [
    [
        'id' => 'a1',
        'title' => 'Vocabulary A1',
        'description' => 'Essential vocabulary for absolute beginners. 20 topics covering everyday situations.',
        'color' => 'blue',
        'route' => route('vocabulary-a1')
    ],
    [
        'id' => 'a2',
        'title' => 'Vocabulary A2',
        'description' => 'Elementary vocabulary to expand your daily communication skills.',
        'color' => 'green',
        'route' => route('vocabulary-a2')
    ],
    [
        'id' => 'b1',
        'title' => 'Vocabulary B1',
        'description' => 'Intermediate vocabulary for more complex conversations.',
        'color' => 'purple',
        'route' => route('vocabulary-b1')
    ],
    [
        'id' => 'b2',
        'title' => 'Vocabulary B2',
        'description' => 'Upper-intermediate vocabulary for professional fluency.',
        'color' => 'orange',
        'route' => route('vocabulary-b2')
    ],
    [
        'id' => 'c1',
        'title' => 'Vocabulary C1',
        'description' => 'Advanced vocabulary for near-native proficiency.',
        'color' => 'red',
        'route' => route('vocabulary-c1')
    ],
    [
        'id' => 'verbs',
        'title' => 'Verbs (A1-C1)',
        'description' => 'Master English verbs across 5 proficiency levels.',
        'color' => 'teal',
        'route' => route('vocabulary-verb')
    ],
    [
        'id' => 'adjectives',
        'title' => 'Adjectives (A1-C1)',
        'description' => 'Descriptive words to enhance your expression.',
        'color' => 'yellow',
        'route' => route('vocabulary-adjective')
    ],
    [
        'id' => 'adverbs',
        'title' => 'Adverbs (A1-C1)',
        'description' => 'Add nuance to your verbs and adjectives.',
        'color' => 'indigo',
        'route' => route('vocabulary-adverb')
    ],
    [
        'id' => 'expressions',
        'title' => 'English Expressions',
        'description' => 'Common expressions for natural conversation.',
        'color' => 'cyan',
        'route' => route('english-expression')
    ],
     [
        'id' => 'idioms',
        'title' => 'English Idioms',
        'description' => 'Learn idioms to sound like a native speaker.',
        'color' => 'pink',
        'route' => route('idioms')
    ],
     [
        'id' => 'phrasal-verbs',
        'title' => 'Phrasal Verbs',
        'description' => 'Essential phrasal verbs for fluency.',
        'color' => 'orange',
        'route' => route('phrasal-verbs')
    ],
     [
        'id' => 'irregular-verbs',
        'title' => 'Irregular Verbs',
        'description' => 'Complete list of irregular verbs.',
        'color' => 'purple',
        'route' => route('irregular-verbs')
    ]
];
@endphp

<!-- Hero Section -->
<div class="relative bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-12 overflow-hidden border border-gray-100/50">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[140%] rounded-full bg-gradient-to-br from-blue-50/50 to-purple-50/50 blur-3xl transform rotate-12"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[40%] h-[120%] rounded-full bg-gradient-to-tr from-green-50/50 to-blue-50/50 blur-3xl transform -rotate-12"></div>
    </div>
    
    <div class="relative z-10 px-6 py-20 md:py-24 text-center max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100 mb-6 uppercase tracking-wider">
            Target Bahasa Course
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6">
            <span class="block text-gray-900 mb-2">Uji Kemampuan Bahasa Inggrismu</span>
            <span class="block bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent pb-2">Secara Gratis!</span>
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500 leading-relaxed font-medium">
            Ketahui estimasi skormu sebelum mengambil tes resmi atau pelajari materi dasar secara cuma-cuma. Pilih jenis layanan di bawah ini dan mulai tingkatkan kemampuanmu sekarang.
        </p>
    </div>
</div>

<!-- Free Tests Section -->
<div class="mb-16">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 pb-4 border-b border-gray-100">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Free Mini Tests</h2>
            <p class="text-gray-500 text-lg">Simulasi singkat format tes aslinya. Dapatkan estimasi skormu secara instan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- IELTS Academic -->
        <div class="group bg-white rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 hover:border-blue-200 hover:shadow-[0_8px_30px_rgb(37,99,235,0.1)] transition-all duration-300 p-8 flex flex-col h-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-[100px] z-0 opacity-50 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="relative z-10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-sm bg-gradient-to-br from-blue-500 to-blue-600 transform group-hover:-translate-y-1 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3 relative z-10">IELTS Academic</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <div class="mb-6 text-sm text-gray-500 space-y-3">
                    <p class="font-medium text-gray-600 leading-relaxed">Bagi yang ingin studi ke luar negeri.</p>
                    <ul class="space-y-2 mt-4">
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="font-medium">15 Menit</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <span class="font-medium">Reading & Listening</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <a href="{{ route('free-test.register.show', 'ielts_academic') }}" class="group/btn block w-full text-center text-blue-600 font-bold py-3 px-4 rounded-xl border-2 border-blue-500 hover:bg-blue-600 hover:text-white transition-all duration-300">
                        Start Free Test <span class="inline-block transform group-hover/btn:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- IELTS General -->
        <div class="group bg-white rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.1)] transition-all duration-300 p-8 flex flex-col h-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-50 to-transparent rounded-bl-[100px] z-0 opacity-50 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="relative z-10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-sm bg-gradient-to-br from-emerald-500 to-emerald-600 transform group-hover:-translate-y-1 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3 relative z-10">IELTS General</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <div class="mb-6 text-sm text-gray-500 space-y-3">
                    <p class="font-medium text-gray-600 leading-relaxed">Untuk bekerja atau imigrasi.</p>
                    <ul class="space-y-2 mt-4">
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="font-medium">15 Menit</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <span class="font-medium">Reading & Listening</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <a href="{{ route('free-test.register.show', 'ielts_general') }}" class="group/btn block w-full text-center text-emerald-600 font-bold py-3 px-4 rounded-xl border-2 border-emerald-500 hover:bg-emerald-600 hover:text-white transition-all duration-300">
                        Start Free Test <span class="inline-block transform group-hover/btn:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOEFL ITP -->
        <div class="group bg-white rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 hover:border-purple-200 hover:shadow-[0_8px_30px_rgb(147,51,234,0.1)] transition-all duration-300 p-8 flex flex-col h-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-50 to-transparent rounded-bl-[100px] z-0 opacity-50 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="relative z-10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-sm bg-gradient-to-br from-purple-500 to-purple-600 transform group-hover:-translate-y-1 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3 relative z-10">TOEFL ITP</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <div class="mb-6 text-sm text-gray-500 space-y-3">
                    <p class="font-medium text-gray-600 leading-relaxed">Model soal institusi lokal/beasiswa.</p>
                    <ul class="space-y-2 mt-4">
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="font-medium">20 Menit</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <span class="font-medium">All Sections</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <a href="{{ route('free-test.register.show', 'toefl_itp') }}" class="group/btn block w-full text-center text-purple-600 font-bold py-3 px-4 rounded-xl border-2 border-purple-500 hover:bg-purple-600 hover:text-white transition-all duration-300">
                        Start Free Test <span class="inline-block transform group-hover/btn:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- PTE Academic -->
        <div class="group bg-white rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 hover:border-orange-200 hover:shadow-[0_8px_30px_rgb(234,88,12,0.1)] transition-all duration-300 p-8 flex flex-col h-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-[100px] z-0 opacity-50 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="relative z-10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-sm bg-gradient-to-br from-orange-500 to-orange-600 transform group-hover:-translate-y-1 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3 relative z-10">PTE Academic</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <div class="mb-6 text-sm text-gray-500 space-y-3">
                    <p class="font-medium text-gray-600 leading-relaxed">Sistem tes integrated skills.</p>
                    <ul class="space-y-2 mt-4">
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="font-medium">15 Menit</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <span class="font-medium">Computer Based</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <a href="{{ route('free-test.register.show', 'pte_academic') }}" class="group/btn block w-full text-center text-orange-600 font-bold py-3 px-4 rounded-xl border-2 border-orange-500 hover:bg-orange-600 hover:text-white transition-all duration-300">
                        Start Free Test <span class="inline-block transform group-hover/btn:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Why Take Our Free Test? -->
<div class="mb-16">
    <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-[2rem] shadow-2xl shadow-indigo-500/20 overflow-hidden p-8 md:p-12 border border-white/20">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-32 -right-32 w-[30rem] h-[30rem] bg-white/10 rounded-full blur-3xl mix-blend-overlay"></div>
            <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] bg-pink-400/30 rounded-full blur-3xl mix-blend-overlay"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white/5 to-transparent"></div>
        </div>

        <div class="relative z-10 text-center mb-10">
            <h3 class="text-3xl font-bold text-white mb-4">Why Take Our Free Test?</h3>
            <p class="text-blue-100 text-lg">Keunggulan simulasi tes di Target Bahasa.</p>
        </div>

        <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center group bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 shadow-xl shadow-black/5 hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-400 to-red-500 flex items-center justify-center mx-auto mb-6 transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-white mb-3 tracking-wide">Akurat</h4>
                <p class="text-blue-50 leading-relaxed font-medium">Soal dikurasi sesuai dengan standar pola tes asli terbaru.</p>
            </div>
            
            <div class="text-center group bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 shadow-xl shadow-black/5 hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-300 to-orange-500 flex items-center justify-center mx-auto mb-6 transform group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-white mb-3 tracking-wide">Instan</h4>
                <p class="text-blue-50 leading-relaxed font-medium">Dapatkan estimasi band/skormu secara realtime segera setelah selesai.</p>
            </div>
            
            <div class="text-center group bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 shadow-xl shadow-black/5 hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mx-auto mb-6 transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-white mb-3 tracking-wide">Analisis</h4>
                <p class="text-blue-50 leading-relaxed font-medium">Ketahui detail kelemahanmu di aspek spesifik untuk bahan evaluasi belajar.</p>
            </div>
        </div>
    </div>
</div>

<!-- Free Lessons Section -->
<div>
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 pb-4 border-b border-gray-100">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Free Mini Lessons</h2>
            <p class="text-gray-500 text-lg">Materi gratis step-by-step untuk memperkuat fondasi bahasa Inggris kamu.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($freeLessons as $lesson)
            @php
                $colorClasses = [
                    'blue' => [
                        'bg' => 'bg-blue-50', 
                        'text' => 'text-blue-600', 
                        'border' => 'border-blue-100 hover:border-blue-300',
                        'icon_bg' => 'bg-blue-100/50',
                        'btn' => 'bg-blue-600 hover:bg-blue-700'
                    ],
                    'green' => [
                        'bg' => 'bg-emerald-50', 
                        'text' => 'text-emerald-600', 
                        'border' => 'border-emerald-100 hover:border-emerald-300',
                        'icon_bg' => 'bg-emerald-100/50',
                        'btn' => 'bg-emerald-600 hover:bg-emerald-700'
                    ],
                    'purple' => [
                        'bg' => 'bg-purple-50', 
                        'text' => 'text-purple-600', 
                        'border' => 'border-purple-100 hover:border-purple-300',
                        'icon_bg' => 'bg-purple-100/50',
                        'btn' => 'bg-purple-600 hover:bg-purple-700'
                    ],
                    'orange' => [
                        'bg' => 'bg-orange-50', 
                        'text' => 'text-orange-600', 
                        'border' => 'border-orange-100 hover:border-orange-300',
                        'icon_bg' => 'bg-orange-100/50',
                        'btn' => 'bg-orange-600 hover:bg-orange-700'
                    ],
                    'red' => [
                        'bg' => 'bg-rose-50', 
                        'text' => 'text-rose-600', 
                        'border' => 'border-rose-100 hover:border-rose-300',
                        'icon_bg' => 'bg-rose-100/50',
                        'btn' => 'bg-rose-600 hover:bg-rose-700'
                    ],
                    'teal' => [
                        'bg' => 'bg-teal-50', 
                        'text' => 'text-teal-600', 
                        'border' => 'border-teal-100 hover:border-teal-300',
                        'icon_bg' => 'bg-teal-100/50',
                        'btn' => 'bg-teal-600 hover:bg-teal-700'
                    ],
                    'indigo' => [
                        'bg' => 'bg-indigo-50', 
                        'text' => 'text-indigo-600', 
                        'border' => 'border-indigo-100 hover:border-indigo-300',
                        'icon_bg' => 'bg-indigo-100/50',
                        'btn' => 'bg-indigo-600 hover:bg-indigo-700'
                    ],
                    'pink' => [
                        'bg' => 'bg-pink-50', 
                        'text' => 'text-pink-600', 
                        'border' => 'border-pink-100 hover:border-pink-300',
                        'icon_bg' => 'bg-pink-100/50',
                        'btn' => 'bg-pink-600 hover:bg-pink-700'
                    ],
                    'yellow' => [
                        'bg' => 'bg-amber-50', 
                        'text' => 'text-amber-600', 
                        'border' => 'border-amber-100 hover:border-amber-300',
                        'icon_bg' => 'bg-amber-100/50',
                        'btn' => 'bg-amber-500 hover:bg-amber-600'
                    ],
                    'cyan' => [
                        'bg' => 'bg-cyan-50', 
                        'text' => 'text-cyan-600', 
                        'border' => 'border-cyan-100 hover:border-cyan-300',
                        'icon_bg' => 'bg-cyan-100/50',
                        'btn' => 'bg-cyan-600 hover:bg-cyan-700'
                    ],
                ];
                $colors = $colorClasses[$lesson['color']] ?? $colorClasses['blue'];
            @endphp
            
            <a href="{{ $lesson['route'] }}" class="group bg-white rounded-2xl p-6 border {{ $colors['border'] }} hover:shadow-lg transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl {{ $colors['bg'] }} {{ $colors['text'] }} flex items-center justify-center font-bold text-lg shadow-sm border {{ $colors['border'] }}">
                        {{ substr($lesson['title'], 0, 1) }}
                    </div>
                    <div class="w-8 h-8 rounded-full {{ $colors['icon_bg'] }} {{ $colors['text'] }} flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" transform="rotate(-45)" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </div>
                </div>
                
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:{{ $colors['text'] }} transition-colors">{{ $lesson['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">{{ $lesson['description'] }}</p>
                
                <div class="mt-auto flex items-center gap-2 text-sm font-semibold {{ $colors['text'] }}">
                    Belajar Sekarang
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </div>
            </a>
        @endforeach
    </div>
</div>

