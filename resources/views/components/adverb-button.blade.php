{{-- Adverb Helper Button Component --}}
<script>
    function adverbButtonData() {
        return {
            open: false,
            searchQuery: '',
            selectedCategory: 'all',
            rules: [
                {
                    title: '1. Apa Itu Adverb (Kata Keterangan)?',
                    content: 'Adverb adalah kata yang memodifikasi/menerangkan <strong>Verb</strong> (kata kerja: <em>walks slowly</em>), <strong>Adjective</strong> (kata sifat: <em>extremely smart</em>), <strong>Adverb lain</strong> (<em>very quickly</em>), atau <strong>Seluruh Kalimat</strong> (<em>Fortunately, we arrived on time</em>).'
                },
                {
                    title: '2. Aturan Emas 3 Posisi (Adverb Placement)',
                    content: '• <strong>Front Position (Awal):</strong> Adverbia penghubung & sikap (<em>However, Fortunately, In addition</em>).<br>• <strong>Mid Position (Tengah):</strong> Sebelum kata kerja utama, atau setelah <em>to be</em> / kata kerja bantu (<em>He <strong>always</strong> double-checks... / She is <strong>currently</strong> working...</em>).<br>• <strong>End Position (Akhir):</strong> Menjelaskan cara, tempat, dan waktu.'
                },
                {
                    title: '3. Aturan Urutan di Akhir Kalimat: M - P - T',
                    content: 'Jika dalam satu kalimat ada beberapa keterangan, urutannya adalah:<br><strong>Manner (Cara) &rarr; Place (Tempat) &rarr; Time (Waktu)</strong><br><span class="italic text-violet-800">Contoh: &ldquo;She spoke <strong>brilliantly</strong> (M) <strong>in the auditorium</strong> (P) <strong>this morning</strong> (T).&rdquo;</span>'
                },
                {
                    title: '4. Jebakan Linking Verbs (Wajib Adjective, Bukan Adverb!)',
                    content: 'Kata kerja indera/penghubung (<em>seem, appear, look, smell, taste, feel, sound, become</em>) WAJIB diikuti <strong>Adjective</strong>, BUKAN Adverb!<br><span class="text-emerald-700 font-semibold">&check; The food smells <strong>delicious</strong>.</span> <span class="text-red-600 line-through">&cross; deliciously</span><br><span class="text-emerald-700 font-semibold">&check; I feel <strong>confident</strong> today.</span> <span class="text-red-600 line-through">&cross; confidently</span>'
                },
                {
                    title: '5. Kata yang Menjebak (Bentuk Sama & Beda Arti)',
                    content: '• <strong>Fast:</strong> Adjective & Adverb bentuknya SAMA (TIDAK ADA kata <em>fastly</em>).<br>• <strong>Hard</strong> (keras/giat) vs <strong>Hardly</strong> (hampir tidak pernah/sama sekali tidak).<br>• <strong>Late</strong> (terlambat) vs <strong>Lately</strong> (akhir-akhir ini / baru-baru ini).<br>• <strong>Near</strong> (dekat) vs <strong>Nearly</strong> (hampir).'
                }
            ],
            items: [
                {
                    group: 'MANNER',
                    category: 'Adverbs of Manner (Cara Melakukan Sesuatu)',
                    badge: 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    headerBg: 'bg-emerald-50 text-emerald-900 border-emerald-200',
                    description: 'Menjelaskan bagaimana suatu tindakan dilakukan (menjawab pertanyaan "How?").',
                    details: [
                        { word: 'Carefully', meaning: 'Dengan hati-hati / cermat', position: 'Mid / End', example: 'He carefully reviewed the contract before signing.' },
                        { word: 'Fluently', meaning: 'Dengan lancar / fasih', position: 'End', example: 'She speaks three international languages fluently.' },
                        { word: 'Accurately', meaning: 'Secara akurat / tepat', position: 'Mid / End', example: 'The algorithm accurately forecasted market trends.' },
                        { word: 'Efficiently', meaning: 'Secara efisien', position: 'Mid / End', example: 'The automated system processes requests efficiently.' },
                        { word: 'Rigorously', meaning: 'Secara ketat / mendalam', position: 'Mid / End', example: 'All clinical trials were rigorously conducted.' },
                        { word: 'Dramatically', meaning: 'Secara dramatis / mencolok', position: 'Mid / End', example: 'Operational costs decreased dramatically this quarter.' },
                        { word: 'Substantially', meaning: 'Secara substansial / besar', position: 'Mid / End', example: 'Profit margins improved substantially after the audit.' },
                        { word: 'Deliberately', meaning: 'Dengan sengaja / penuh pertimbangan', position: 'Mid', example: 'He spoke deliberately to emphasize each strategic goal.' },
                        { word: 'Reluctantly', meaning: 'Dengan enggan / terpaksa', position: 'Mid', example: 'The management reluctantly accepted the union terms.' },
                        { word: 'Thoroughly', meaning: 'Secara menyeluruh / tuntas', position: 'Mid / End', example: 'The team thoroughly investigated the software vulnerability.' },
                        { word: 'Seamlessly', meaning: 'Secara mulus tanpa celah', position: 'Mid / End', example: 'The cloud migration integrated seamlessly with legacy data.' },
                        { word: 'Promptly', meaning: 'Segera / tepat pada waktunya', position: 'Mid / End', example: 'Please respond promptly to the client inquiry.' },
                        { word: 'Smoothly', meaning: 'Dengan lancar tanpa hambatan', position: 'End', example: 'The product launch proceeded smoothly as scheduled.' }
                    ]
                },
                {
                    group: 'DEGREE',
                    category: 'Adverbs of Degree & Intensity (Tingkat & Intensitas)',
                    badge: 'bg-violet-100 text-violet-800 border-violet-300',
                    headerBg: 'bg-violet-50 text-violet-900 border-violet-200',
                    description: 'Menjelaskan kadar atau tingkatan intensitas suatu kata sifat, kata kerja, atau adverb lain (menjawab "How much?").',
                    details: [
                        { word: 'Extremely', meaning: 'Sangat / amat sangat', position: 'Sebelum Adj/Adv', example: 'The project deadline is extremely tight.' },
                        { word: 'Highly', meaning: 'Sangat / bertaraf tinggi', position: 'Sebelum Adj', example: 'She is a highly qualified executive consultant.' },
                        { word: 'Deeply', meaning: 'Sangat mendalam', position: 'Sebelum Adj/Verb', example: 'We are deeply committed to sustainable innovation.' },
                        { word: 'Completely / Entirely', meaning: 'Sepenuhnya / secara total', position: 'Sebelum Adj/V3', example: 'The platform architecture was completely redesigned.' },
                        { word: 'Considerably', meaning: 'Cukup besar / sangat terasa', position: 'Sebelum Adj/Verb', example: 'User retention improved considerably over six months.' },
                        { word: 'Quite / Fairly', meaning: 'Cukup / lumayan', position: 'Sebelum Adj', example: 'The executive briefing was quite informative.' },
                        { word: 'Barely / Scarcely', meaning: 'Hampir tidak / nyaris tidak', position: 'Mid', example: 'There was barely enough time to finalize the presentation.' },
                        { word: 'Utterly', meaning: 'Sama sekali / mutlak', position: 'Sebelum Adj', example: 'The false allegation was utterly baseless.' },
                        { word: 'Substantially', meaning: 'Secara signifikan / substansial', position: 'Mid / End', example: 'The revised policy substantially reduced turnaround time.' },
                        { word: 'Partially', meaning: 'Sebagian / belum penuh', position: 'Mid', example: 'The system has only partially restored data access.' },
                        { word: 'Remarkably', meaning: 'Luar biasa / sangat mengagumkan', position: 'Sebelum Adj', example: 'The startup achieved remarkably fast profitability.' }
                    ]
                },
                {
                    group: 'FREQUENCY',
                    category: 'Adverbs of Frequency (Frekuensi & Kekerapan)',
                    badge: 'bg-blue-100 text-blue-800 border-blue-300',
                    headerBg: 'bg-blue-50 text-blue-900 border-blue-200',
                    description: 'Menunjukkan seberapa sering suatu perbuatan dilakukan (menjawab "How often?").',
                    details: [
                        { word: 'Always (100%)', meaning: 'Selalu', position: 'Mid', example: 'He always arrives ten minutes before the meeting begins.' },
                        { word: 'Usually / Normally (90%)', meaning: 'Biasanya', position: 'Mid', example: 'We usually hold our strategic review on Monday morning.' },
                        { word: 'Frequently / Often (70%)', meaning: 'Sering / berulang kali', position: 'Mid / End', example: 'Market conditions frequently shift due to currency fluctuations.' },
                        { word: 'Sometimes (50%)', meaning: 'Kadang-kadang', position: 'Front / Mid', example: 'Unforeseen bottlenecks sometimes impede project timelines.' },
                        { word: 'Occasionally (30%)', meaning: 'Sesekali / pada waktu tertentu', position: 'Front / Mid', example: 'We occasionally invite guest speakers from industry leaders.' },
                        { word: 'Seldom / Rarely (10%)', meaning: 'Jarang', position: 'Mid', example: 'Executive leadership rarely intervenes in daily team operations.' },
                        { word: 'Hardly ever (5%)', meaning: 'Hampir tidak pernah', position: 'Mid', example: 'She hardly ever misses a project milestone.' },
                        { word: 'Never (0%)', meaning: 'Tidak pernah', position: 'Mid', example: 'Security regulations must never be compromised.' }
                    ]
                },
                {
                    group: 'TIME',
                    category: 'Adverbs of Time & Sequence (Waktu & Urutan Peristiwa)',
                    badge: 'bg-amber-100 text-amber-800 border-amber-300',
                    headerBg: 'bg-amber-50 text-amber-900 border-amber-200',
                    description: 'Menjelaskan kapan atau dalam urutan apa suatu peristiwa terjadi (menjawab "When?").',
                    details: [
                        { word: 'Currently / Now', meaning: 'Saat ini / sekarang', position: 'Front / Mid', example: 'The engineering team is currently testing the patch.' },
                        { word: 'Recently / Lately', meaning: 'Baru-baru ini / akhir-akhir ini', position: 'Front / Mid / End', example: 'The company has recently adopted automated workflows.' },
                        { word: 'Already', meaning: 'Sudah / lebih awal dari perkiraan', position: 'Mid', example: 'They have already exceeded their quarterly revenue targets.' },
                        { word: 'Still', meaning: 'Masih / tetap berlangsung', position: 'Mid', example: 'The negotiations are still ongoing in Geneva.' },
                        { word: 'Yet', meaning: 'Belum / sudahkah (kalimat negatif / tanya)', position: 'End', example: 'The financial audit has not been completed yet.' },
                        { word: 'Soon / Shortly', meaning: 'Segera / sebentar lagi', position: 'End', example: 'The managing director will make an announcement shortly.' },
                        { word: 'Eventually', meaning: 'Pada akhirnya / lambat laun', position: 'Front / Mid', example: 'Persistent collaboration eventually resolved the dispute.' },
                        { word: 'Previously', meaning: 'Sebelumnya / dahulu', position: 'Front / Mid', example: 'She previously led the Asia-Pacific expansion unit.' },
                        { word: 'Beforehand', meaning: 'Sebelumnya / di muka', position: 'End', example: 'All attendees received the briefing materials beforehand.' },
                        { word: 'Simultaneously', meaning: 'Secara bersamaan', position: 'End', example: 'Both software modules were launched simultaneously.' }
                    ]
                },
                {
                    group: 'PLACE',
                    category: 'Adverbs of Place & Direction (Tempat & Arah)',
                    badge: 'bg-rose-100 text-rose-800 border-rose-300',
                    headerBg: 'bg-rose-50 text-rose-900 border-rose-200',
                    description: 'Menjelaskan lokasi atau arah terjadinya tindakan (menjawab "Where?").',
                    details: [
                        { word: 'Abroad / Overseas', meaning: 'Di luar negeri / ke luar negeri', position: 'End', example: 'The conglomerate plans to expand operations abroad.' },
                        { word: 'Nearby', meaning: 'Di dekat sini / berdekatan', position: 'End', example: 'A state-of-the-art data center is located nearby.' },
                        { word: 'Everywhere', meaning: 'Di mana-mana', position: 'End', example: 'Digital payment solutions are accepted everywhere.' },
                        { word: 'Upstairs / Downstairs', meaning: 'Di lantai atas / bawah', position: 'End', example: 'The main conference hall is located upstairs.' },
                        { word: 'Forward / Backward', meaning: 'Ke depan / ke belakang', position: 'End', example: 'We need to move forward with the strategic roadmap.' },
                        { word: 'Indoors / Outdoors', meaning: 'Di dalam / luar ruangan', position: 'End', example: 'The annual shareholder meeting was held indoors.' }
                    ]
                },
                {
                    group: 'CONJUNCTIVE',
                    category: 'Conjunctive Adverbs (Transisi & Penghubung Antar Kalimat)',
                    badge: 'bg-indigo-100 text-indigo-800 border-indigo-300',
                    headerBg: 'bg-indigo-50 text-indigo-900 border-indigo-200',
                    description: 'Kata keterangan penghubung yang menjembatani hubungan logis antara dua klausa independen.',
                    details: [
                        { word: 'However', meaning: 'Namun / akan tetapi', position: 'Front / Interrupter', example: 'The timeline is ambitious; however, our team is confident.' },
                        { word: 'Therefore', meaning: 'Oleh karena itu / maka dari itu', position: 'Front / Mid', example: 'Demand increased; therefore, production capacity was doubled.' },
                        { word: 'Moreover / Furthermore', meaning: 'Selain itu / lebih-lebih lagi', position: 'Front', example: 'The tool saves time; furthermore, it reduces human error.' },
                        { word: 'Nevertheless / Nonetheless', meaning: 'Meskipun demikian / kendati begitu', position: 'Front', example: 'Risks were evident; nevertheless, the investment paid off.' },
                        { word: 'Consequently', meaning: 'Sebagai konsekuensinya / akibatnya', position: 'Front', example: 'Budget cuts occurred; consequently, some projects were paused.' },
                        { word: 'Meanwhile', meaning: 'Sementara itu', position: 'Front', example: 'The CEO met stakeholders; meanwhile, developers fixed the bug.' },
                        { word: 'Otherwise', meaning: 'Jika tidak / kalau tidak demikian', position: 'Front / Mid', example: 'We must submit today; otherwise, we forfeit the tender.' },
                        { word: 'In addition', meaning: 'Sebagai tambahan / di samping itu', position: 'Front', example: 'The deal includes capital; in addition, it grants expert advice.' }
                    ]
                },
                {
                    group: 'VIEWPOINT',
                    category: 'Viewpoint & Attitude Adverbs (Sikap & Sudut Pandang Kalimat)',
                    badge: 'bg-pink-100 text-pink-800 border-pink-300',
                    headerBg: 'bg-pink-50 text-pink-900 border-pink-200',
                    description: 'Menyatakan sudut pandang, kepastian, atau perasaan pembicara terhadap seluruh isi kalimat.',
                    details: [
                        { word: 'Fortunately / Luckily', meaning: 'Untungnya / syukurlah', position: 'Front', example: 'Fortunately, all client databases had been backed up.' },
                        { word: 'Unfortunately', meaning: 'Sayangnya', position: 'Front', example: 'Unfortunately, international flights were canceled due to weather.' },
                        { word: 'Clearly / Obviously', meaning: 'Jelas sekali / tentunya', position: 'Front / Mid', example: 'This outcome clearly validates our product strategy.' },
                        { word: 'Undoubtedly', meaning: 'Tanpa diragukan lagi / pasti', position: 'Front / Mid', example: 'Data privacy is undoubtedly our highest priority.' },
                        { word: 'Frankly / Honestly', meaning: 'Secara jujur / terus terang', position: 'Front', example: 'Frankly, the initial delivery estimates were unrealistic.' },
                        { word: 'Inevitably', meaning: 'Tak terelakkan / mau tidak mau', position: 'Mid', example: 'Market maturation will inevitably compress profit margins.' },
                        { word: 'Apparently', meaning: 'Tampaknya / rupanya', position: 'Front / Mid', example: 'Apparently, the regulator approved the merger terms.' },
                        { word: 'Personally', meaning: 'Secara pribadi / menurut saya', position: 'Front', example: 'Personally, I recommend proceeding with the acquisition.' }
                    ]
                }
            ],
            get filteredItems() {
                let list = this.items;
                if (this.selectedCategory !== 'all') {
                    list = list.filter(g => g.group === this.selectedCategory);
                }
                if (!this.searchQuery.trim()) {
                    return list;
                }
                const q = this.searchQuery.toLowerCase();
                return list.map(group => {
                    const matchesGroup = group.category.toLowerCase().includes(q) || group.description.toLowerCase().includes(q);
                    const filteredDetails = group.details.filter(d =>
                        d.word.toLowerCase().includes(q) ||
                        d.meaning.toLowerCase().includes(q) ||
                        d.example.toLowerCase().includes(q) ||
                        d.position.toLowerCase().includes(q)
                    );
                    if (matchesGroup || filteredDetails.length > 0) {
                        return {
                            ...group,
                            details: matchesGroup ? group.details : filteredDetails
                        };
                    }
                    return null;
                }).filter(Boolean);
            }
        };
    }
</script>

<div x-data="adverbButtonData()">
    <!-- Floating Button -->
    <button @click="open = true; searchQuery = ''"
            type="button"
            title="Adverb (Kata Keterangan)"
            class="bg-violet-600 hover:bg-violet-700 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        <span class="hidden sm:inline">Adverb</span>
    </button>

    <!-- Modal Backdrop -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         style="display: none;">

        <!-- Modal Content -->
        <div @click.outside="open = false"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[88vh] flex flex-col overflow-hidden border border-slate-200">

            <!-- Header with Search & Tabs -->
            <div class="p-5 border-b border-blue-100 bg-blue-50">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-tb-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">⚡</span>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Materi &amp; Panduan Lengkap Adverbs (Kata Keterangan)</h3>
                            <p class="text-xs text-slate-500">Aturan Posisi (Placement), Perbedaan vs Adjective, &amp; 100+ Kosakata Adverb Lengkap Contoh</p>
                        </div>
                    </div>

                    <button @click="open = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-white/60 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Search Input -->
                <div class="relative mb-3">
                    <input
                        type="text"
                        x-model="searchQuery"
                        placeholder="Cari kata adverb (misal: quickly, extremely, always, however, fortunately, recently)..."
                        class="w-full px-4 py-2.5 pl-10 pr-10 border border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-tb focus:border-transparent bg-white text-sm"
                    >
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <button x-show="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs font-semibold scrollbar-none">
                    <button @click="selectedCategory = 'all'" :class="selectedCategory === 'all' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Semua Kategori
                    </button>
                    <button @click="selectedCategory = 'rules'" :class="selectedCategory === 'rules' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        📌 Aturan &amp; Posisi Emas
                    </button>
                    <button @click="selectedCategory = 'MANNER'" :class="selectedCategory === 'MANNER' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Manner (Cara)
                    </button>
                    <button @click="selectedCategory = 'DEGREE'" :class="selectedCategory === 'DEGREE' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Degree (Intensitas)
                    </button>
                    <button @click="selectedCategory = 'FREQUENCY'" :class="selectedCategory === 'FREQUENCY' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Frequency (Frekuensi)
                    </button>
                    <button @click="selectedCategory = 'TIME'" :class="selectedCategory === 'TIME' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Time (Waktu)
                    </button>
                    <button @click="selectedCategory = 'PLACE'" :class="selectedCategory === 'PLACE' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Place (Tempat)
                    </button>
                    <button @click="selectedCategory = 'CONJUNCTIVE'" :class="selectedCategory === 'CONJUNCTIVE' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Conjunctive (Transisi)
                    </button>
                    <button @click="selectedCategory = 'VIEWPOINT'" :class="selectedCategory === 'VIEWPOINT' ? 'bg-tb-primary text-white shadow-sm' : 'bg-white/80 text-slate-700 hover:bg-white'" class="px-3 py-1.5 rounded-lg transition whitespace-nowrap border border-blue-200">
                        Viewpoint (Sikap)
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="overflow-y-auto p-5 space-y-6 flex-1 bg-slate-50/50" style="max-height: 65vh;">

                <!-- Golden Rules Box (shown when 'all' or 'rules' selected and no search) -->
                <div x-show="(!searchQuery.trim() && (selectedCategory === 'all' || selectedCategory === 'rules'))" class="bg-blue-50 rounded-2xl border border-blue-200 p-5 shadow-sm space-y-3">
                    <div class="flex items-center gap-2 mb-2 text-tb-primary font-bold text-base">
                        <span class="text-xl">💡</span>
                        <h4>Panduan Konsep, Posisi &amp; Aturan Emas Adverb</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 text-xs">
                        <template x-for="(rule, rIdx) in rules" :key="rIdx">
                            <div class="bg-white p-3.5 rounded-xl border border-blue-100 shadow-xs">
                                <h5 class="font-bold text-tb-primary mb-1" x-text="rule.title"></h5>
                                <div class="text-slate-700 leading-relaxed font-normal" x-html="rule.content"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Tables by Group -->
                <template x-if="selectedCategory !== 'rules'">
                    <div class="space-y-6">
                        <template x-for="(group, gIdx) in filteredItems" :key="gIdx">
                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                                <!-- Group Header -->
                                <div class="px-4 py-3 border-b flex items-center justify-between" :class="group.headerBg">
                                    <div>
                                        <h4 class="font-bold text-sm md:text-base flex items-center gap-2" x-text="group.category"></h4>
                                        <p class="text-xs opacity-80 mt-0.5" x-text="group.description"></p>
                                    </div>
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border" :class="group.badge" x-text="group.group"></span>
                                </div>

                                <!-- Details Table -->
                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs md:text-sm text-left border-collapse">
                                        <thead>
                                            <tr class="bg-slate-100/70 text-slate-600 border-b border-slate-200 font-semibold text-xs">
                                                <th class="p-3 w-1/5">Adverb</th>
                                                <th class="p-3 w-1/4">Arti (Bahasa Indonesia)</th>
                                                <th class="p-3 w-1/6">Posisi Umum</th>
                                                <th class="p-3">Contoh Kalimat</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <template x-for="(detail, dIdx) in group.details" :key="dIdx">
                                                <tr class="hover:bg-blue-50/40 transition-colors">
                                                    <td class="p-3 font-bold text-tb-primary whitespace-nowrap" x-text="detail.word"></td>
                                                    <td class="p-3 text-slate-700 font-medium" x-text="detail.meaning"></td>
                                                    <td class="p-3 text-slate-500 font-mono text-xs">
                                                        <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 font-semibold text-slate-700" x-text="detail.position"></span>
                                                    </td>
                                                    <td class="p-3 text-slate-600 italic font-mono text-xs bg-slate-50/50" x-text="detail.example"></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>

                        <!-- No Results -->
                        <div x-show="filteredItems.length === 0" class="py-12 text-center text-slate-500">
                            <p class="font-medium text-base">Tidak ada kata adverb yang sesuai pencarian</p>
                            <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain seperti &ldquo;quickly&rdquo;, &ldquo;extremely&rdquo;, &ldquo;always&rdquo;, atau &ldquo;however&rdquo;</p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Footer -->
            <div class="p-3 bg-blue-50 border-t border-blue-100 flex justify-between items-center">
                <span class="text-xs text-slate-500 italic">Tips: Gunakan Adverb untuk meningkatkan variasi dan bobot kalimat C1/C2.</span>
                <button @click="open = false" class="px-4 py-2 bg-tb-primary text-white rounded-xl text-xs font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
