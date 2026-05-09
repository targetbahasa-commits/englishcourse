
<!-- Hero Section -->
<div x-data="{
        currentSlide: 0,
        images: [
            'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&q=80&w=2070', // Oxford/Campus path
            'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&q=80&w=2070', // Library
            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=2070', // Graduates on campus
            'https://images.unsplash.com/photo-1606761568499-6d2451b23c66?auto=format&fit=crop&q=80&w=2074'  // Classic architecture
        ],
        init() {
            setInterval(() => {
                this.currentSlide = (this.currentSlide + 1) % this.images.length;
            }, 6000);
        }
    }" 
    class="relative bg-gray-900 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.15)] mb-12 overflow-hidden border border-gray-800">
    
    <!-- Slideshow Backgrounds -->
    <div 
        class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat transition-opacity duration-1000 ease-in-out z-0"
        style="background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&q=80&w=2070')"
        :class="currentSlide === 0 ? 'opacity-40' : 'opacity-0'" 
    ></div>
    <div 
        class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat transition-opacity duration-1000 ease-in-out z-0"
        style="background-image: url('https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&q=80&w=2070')"
        :class="currentSlide === 1 ? 'opacity-40' : 'opacity-0'" 
    ></div>
    <div 
        class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat transition-opacity duration-1000 ease-in-out z-0"
        style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=2070')"
        :class="currentSlide === 2 ? 'opacity-40' : 'opacity-0'" 
    ></div>
    <div 
        class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat transition-opacity duration-1000 ease-in-out z-0"
        style="background-image: url('https://images.unsplash.com/photo-1629532599283-7d5eb1d2b70f?auto=format&fit=crop&q=80&w=2070')"
        :class="currentSlide === 3 ? 'opacity-40' : 'opacity-0'" 
    ></div>
    
    <!-- Gradient Overlay for enhanced readability -->
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent z-10"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-gray-900/60 via-transparent to-transparent z-10"></div>
    
    <div class="relative z-20 px-6 py-20 md:py-24 text-center max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30 backdrop-blur-md mb-6 uppercase tracking-wider shadow-lg">
            Target Bahasa Course
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 drop-shadow-2xl">
            <span class="block text-white mb-2">Uji Kemampuan Bahasa Inggrismu</span>
            <span class="block bg-gradient-to-r from-blue-300 via-indigo-300 to-purple-300 bg-clip-text text-transparent pb-2 drop-shadow-lg">Secara Gratis!</span>
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-200 leading-relaxed font-medium drop-shadow-md">
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

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
        <!-- IELTS Academic -->
        <div class="group relative bg-white rounded-[2rem] shadow-lg hover:shadow-2xl transition-all duration-500 ease-out p-8 flex flex-col h-full overflow-hidden border border-gray-100 hover:border-blue-300 hover:-translate-y-2">
            <!-- Background Icon Watermark -->
            <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-gray-100 opacity-50 transform rotate-12 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-700 ease-out pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>

            <!-- Top Accent Line -->
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out"></div>

            <!-- Header -->
            <div class="relative z-10 flex items-start justify-between mb-6">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center border border-blue-100 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ease-out">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                </div>
                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider border border-blue-200">
                    Academic
                </span>
            </div>

            <!-- Content -->
            <h3 class="text-2xl font-bold text-gray-900 mb-3 relative z-10 group-hover:text-blue-600 transition-colors duration-300 tracking-tight">IELTS Academic</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <p class="text-gray-500 text-sm leading-relaxed mb-6 min-h-[40px]">Bagi yang ingin studi ke luar negeri.</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-blue-50 group-hover:border-blue-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 text-blue-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">15 Menit</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-blue-50 group-hover:border-blue-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 text-blue-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Reading & Listening</span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-auto relative">
                    <a href="{{ route('guest.quick-access', 'ielts_academic') }}" class="flex items-center justify-center gap-2 w-full font-bold text-white bg-blue-600 hover:bg-blue-700 py-3.5 px-6 rounded-xl transition-colors duration-300 shadow-md">
                        <span>Start Free Test</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- IELTS General -->
        <div class="group relative bg-white rounded-[2rem] shadow-lg hover:shadow-2xl transition-all duration-500 ease-out p-8 flex flex-col h-full overflow-hidden border border-gray-100 hover:border-emerald-300 hover:-translate-y-2">
            <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-gray-100 opacity-50 transform rotate-12 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-700 ease-out pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>

            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-emerald-400 to-emerald-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out"></div>

            <div class="relative z-10 flex items-start justify-between mb-6">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center border border-emerald-100 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ease-out">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold uppercase tracking-wider border border-emerald-200">
                    General
                </span>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3 relative z-10 group-hover:text-emerald-600 transition-colors duration-300 tracking-tight">IELTS General</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <p class="text-gray-500 text-sm leading-relaxed mb-6 min-h-[40px]">Untuk bekerja atau imigrasi.</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-emerald-50 group-hover:border-emerald-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">15 Menit</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-emerald-50 group-hover:border-emerald-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Reading & Listening</span>
                    </div>
                </div>

                <div class="mt-auto relative">
                    <a href="{{ route('guest.quick-access', 'ielts_general') }}" class="flex items-center justify-center gap-2 w-full font-bold text-white bg-emerald-500 hover:bg-emerald-600 py-3.5 px-6 rounded-xl transition-colors duration-300 shadow-md">
                        <span>Start Free Test</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOEFL ITP -->
        <div class="group relative bg-white rounded-[2rem] shadow-lg hover:shadow-2xl transition-all duration-500 ease-out p-8 flex flex-col h-full overflow-hidden border border-gray-100 hover:border-purple-300 hover:-translate-y-2">
            <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-gray-100 opacity-50 transform rotate-12 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-700 ease-out pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>

            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-purple-400 to-purple-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out"></div>

            <div class="relative z-10 flex items-start justify-between mb-6">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center border border-purple-100 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ease-out">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-purple-50 text-purple-600 text-xs font-bold uppercase tracking-wider border border-purple-200">
                    ITP
                </span>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3 relative z-10 group-hover:text-purple-600 transition-colors duration-300 tracking-tight">TOEFL ITP</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <p class="text-gray-500 text-sm leading-relaxed mb-6 min-h-[40px]">Model soal institusi lokal/beasiswa.</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-purple-50 group-hover:border-purple-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 text-purple-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">20 Menit</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-purple-50 group-hover:border-purple-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 text-purple-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">All Sections</span>
                    </div>
                </div>

                <div class="mt-auto relative">
                    <a href="{{ route('guest.quick-access', 'toefl_itp') }}" class="flex items-center justify-center gap-2 w-full font-bold text-white bg-purple-600 hover:bg-purple-700 py-3.5 px-6 rounded-xl transition-colors duration-300 shadow-md">
                        <span>Start Free Test</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- PTE Academic -->
        <div class="group relative bg-white rounded-[2rem] shadow-lg hover:shadow-2xl transition-all duration-500 ease-out p-8 flex flex-col h-full overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2">
            <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-gray-100 opacity-50 transform rotate-12 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-700 ease-out pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>

            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-orange-400 to-orange-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out"></div>

            <div class="relative z-10 flex items-start justify-between mb-6">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center border border-orange-100 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ease-out">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-white shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-xs font-bold uppercase tracking-wider border border-orange-200">
                    Academic
                </span>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3 relative z-10 group-hover:text-orange-600 transition-colors duration-300 tracking-tight">PTE Academic</h3>
            
            <div class="flex-1 flex flex-col relative z-10">
                <p class="text-gray-500 text-sm leading-relaxed mb-6 min-h-[40px]">Sistem tes integrated skills.</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-orange-50 group-hover:border-orange-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0 text-orange-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">15 Menit</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 group-hover:bg-orange-50 group-hover:border-orange-200 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0 text-orange-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Computer Based</span>
                    </div>
                </div>

                <div class="mt-auto relative">
                    <a href="{{ route('guest.quick-access', 'pte_academic') }}" class="flex items-center justify-center gap-2 w-full font-bold text-white bg-orange-500 hover:bg-orange-600 py-3.5 px-6 rounded-xl transition-colors duration-300 shadow-md">
                        <span>Start Free Test</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
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


