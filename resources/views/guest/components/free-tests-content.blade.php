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
<div class="relative bg-white overflow-hidden rounded-2xl shadow-sm mb-8">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-indigo-50/50 to-purple-50/50 -z-10"></div>
    <div class="px-4 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
            <span class="block text-gray-900">Uji Kemampuan Bahasa Inggrismu</span>
            <span class="block bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mt-2">Secara Gratis!</span>
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500">
            Ketahui estimasi skormu sebelum mengambil tes resmi atau pelajari materi dasar secara cuma-cuma. Pilih jenis layanan di bawah ini dan mulai tingkatkan kemampuanmu sekarang.
        </p>
    </div>
</div>

<!-- Free Tests Section -->
<div class="mb-12">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Free Mini Tests</h2>
        <p class="text-gray-500">Simulasi singkat format tes aslinya. Dapatkan estimasi skormu secara instan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- IELTS Academic -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 flex flex-col">
            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 text-2xl">🎓</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">IELTS Academic</h3>
            <div class="text-gray-500 mb-6 flex-1 text-xs bg-gray-50 p-3 rounded-xl border border-gray-100 space-y-2">
                <p class="font-medium text-gray-700">Bagi yang ingin studi ke luar negeri.</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> 15 Menit</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Reading & Listening</p>
            </div>
            <a href="#" class="block w-full text-center bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-xl hover:bg-blue-700 transition">Start Free Test</a>
        </div>

        <!-- IELTS General -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 flex flex-col">
            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center mb-4 text-2xl">💼</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">IELTS General</h3>
            <div class="text-gray-500 mb-6 flex-1 text-xs bg-gray-50 p-3 rounded-xl border border-gray-100 space-y-2">
                <p class="font-medium text-gray-700">Untuk bekerja atau imigrasi.</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> 15 Menit</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Reading & Listening</p>
            </div>
            <a href="#" class="block w-full text-center bg-green-600 text-white font-semibold py-2.5 px-4 rounded-xl hover:bg-green-700 transition">Start Free Test</a>
        </div>

        <!-- TOEFL ITP -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 flex flex-col">
            <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center mb-4 text-2xl">🏛️</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">TOEFL ITP</h3>
            <div class="text-gray-500 mb-6 flex-1 text-xs bg-gray-50 p-3 rounded-xl border border-gray-100 space-y-2">
                <p class="font-medium text-gray-700">Model soal institusi lokal/beasiswa.</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> 20 Menit</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> All Sections</p>
            </div>
            <a href="#" class="block w-full text-center bg-purple-600 text-white font-semibold py-2.5 px-4 rounded-xl hover:bg-purple-700 transition">Start Free Test</a>
        </div>

        <!-- PTE Academic -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 flex flex-col">
            <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mb-4 text-2xl">💻</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">PTE Academic</h3>
            <div class="text-gray-500 mb-6 flex-1 text-xs bg-gray-50 p-3 rounded-xl border border-gray-100 space-y-2">
                <p class="font-medium text-gray-700">Sistem tes integrated skills.</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> 15 Menit</p>
                <p class="flex items-center gap-1.5"><svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Computer Based</p>
            </div>
            <a href="#" class="block w-full text-center bg-orange-600 text-white font-semibold py-2.5 px-4 rounded-xl hover:bg-orange-700 transition">Start Free Test</a>
        </div>
    </div>
</div>

<!-- Why Take Our Free Test? -->
<div class="mb-12 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Why Take Our Free Test?</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="text-center">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">🎯</div>
            <h4 class="font-bold text-gray-800 mb-2">Akurat</h4>
            <p class="text-sm text-gray-500">Soal dikurasi sesuai dengan standar tes asli terbaru.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">⚡</div>
            <h4 class="font-bold text-gray-800 mb-2">Instan</h4>
            <p class="text-sm text-gray-500">Dapatkan estimasi band/skormu segera setelah selesai.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">📈</div>
            <h4 class="font-bold text-gray-800 mb-2">Analisis</h4>
            <p class="text-sm text-gray-500">Ketahui kelemahanmu (Misal: Grammar lemah, Vocabulary kurang).</p>
        </div>
    </div>
</div>

<!-- Free Lessons Section -->
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Free Mini Lessons</h2>
        <p class="text-gray-500">Materi gratis untuk memperkuat fondasi bahasa Inggris kamu.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($freeLessons as $lesson)
            @php
                $colorClasses = [
                    'blue' => ['gradient' => 'from-blue-400 to-blue-600', 'btn' => 'bg-blue-500 hover:bg-blue-600'],
                    'green' => ['gradient' => 'from-green-400 to-green-600', 'btn' => 'bg-green-500 hover:bg-green-600'],
                    'purple' => ['gradient' => 'from-purple-400 to-purple-600', 'btn' => 'bg-purple-500 hover:bg-purple-600'],
                    'orange' => ['gradient' => 'from-orange-400 to-orange-600', 'btn' => 'bg-orange-500 hover:bg-orange-600'],
                    'red' => ['gradient' => 'from-red-400 to-red-600', 'btn' => 'bg-red-500 hover:bg-red-600'],
                    'teal' => ['gradient' => 'from-teal-400 to-teal-600', 'btn' => 'bg-teal-500 hover:bg-teal-600'],
                    'indigo' => ['gradient' => 'from-indigo-400 to-indigo-600', 'btn' => 'bg-indigo-500 hover:bg-indigo-600'],
                    'pink' => ['gradient' => 'from-pink-400 to-pink-600', 'btn' => 'bg-pink-500 hover:bg-pink-600'],
                    'yellow' => ['gradient' => 'from-yellow-400 to-yellow-600', 'btn' => 'bg-yellow-500 hover:bg-yellow-600 text-white'],
                    'cyan' => ['gradient' => 'from-cyan-400 to-cyan-600', 'btn' => 'bg-cyan-500 hover:bg-cyan-600'],
                ];
                $colors = $colorClasses[$lesson['color']] ?? $colorClasses['blue'];
            @endphp
            
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full group">
                 <div class="h-24 bg-gradient-to-br {{ $colors['gradient'] }} relative p-5 flex flex-col justify-end">
                    <h3 class="text-xl font-bold text-white shadow-sm group-hover:-translate-y-1 transition-transform">{{ $lesson['title'] }}</h3>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <p class="text-gray-600 mb-5 text-sm leading-relaxed">{{ $lesson['description'] }}</p>
                    <a href="{{ $lesson['route'] }}" class="inline-block w-full text-center {{ $colors['btn'] }} text-white font-medium py-2 px-4 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        Belajar Sekarang
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
