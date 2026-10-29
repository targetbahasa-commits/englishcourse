<div x-data="{
    open: false,
    searchQuery: '',
    items: [
        {
            group: 'FANBOYS',
            category: 'Coordinating Conjunctions (FANBOYS)',
            badge: 'bg-emerald-100 text-emerald-800 border-emerald-300',
            headerBg: 'bg-emerald-50 text-emerald-900 border-emerald-200',
            description: 'Kata penghubung setara untuk menghubungkan kata, frasa, atau klausa independen.',
            details: [
                { word: 'F – For', meaning: 'Karena / Sebab', example: 'He worked hard, for he wanted to pass the exam.' },
                { word: 'A – And', meaning: 'Dan / Serta', example: 'She loves reading and writing.' },
                { word: 'N – Nor', meaning: 'Dan tidak juga', example: 'He doesn\'t eat meat, nor does he drink milk.' },
                { word: 'B – But', meaning: 'Tetapi / Namun', example: 'I tried my best, but I failed.' },
                { word: 'O – Or', meaning: 'Atau', example: 'You can stay here or come with us.' },
                { word: 'Y – Yet', meaning: 'Namun / Kendati demikian', example: 'It was raining heavily, yet they went outside.' },
                { word: 'S – So', meaning: 'Jadi / Sehingga / Oleh karena itu', example: 'It was getting dark, so we decided to return.' }
            ]
        },
        {
            group: 'ADJECTIVE',
            category: 'Adjective Clause (Relative Clause)',
            badge: 'bg-blue-100 text-blue-800 border-blue-300',
            headerBg: 'bg-blue-50 text-blue-900 border-blue-200',
            description: 'Klausa yang berfungsi sebagai kata sifat untuk menjelaskan kata benda (Noun) atau Pronoun.',
            details: [
                { word: 'Who', meaning: 'Yang (merujuk pada orang sebagai subjek)', example: 'The student who studied hard passed the test.' },
                { word: 'Whom', meaning: 'Yang (merujuk pada orang sebagai objek)', example: 'The teacher whom I met yesterday was very kind.' },
                { word: 'Whose', meaning: 'Yang ...-nya (merujuk pada kepemilikan)', example: 'The writer whose book won the award is Indonesian.' },
                { word: 'Which', meaning: 'Yang (merujuk pada benda / hewan)', example: 'The computer which I bought last week is fast.' },
                { word: 'That', meaning: 'Yang (merujuk pada orang, benda, atau hewan)', example: 'This is the article that explains the theory.' },
                { word: 'Where', meaning: 'Di mana / Tempat di mana (lokasi)', example: 'This is the school where I studied.' },
                { word: 'When', meaning: 'Ketika / Waktu di mana (waktu)', example: 'I remember the day when we first met.' },
                { word: 'Why', meaning: 'Mengapa / Alasan mengapa (alasan)', example: 'That is the reason why he was absent.' }
            ]
        },
        {
            group: 'ADVERBIAL',
            category: 'Adverbial Clause (Klausa Adverbia)',
            badge: 'bg-purple-100 text-purple-800 border-purple-300',
            headerBg: 'bg-purple-50 text-purple-900 border-purple-200',
            description: 'Klausa anak yang menjelaskan Verb, Adjective, atau klausa utama (Waktu, Sebab-Akibat, Syarat, dll).',
            details: [
                { word: 'When / Whenever', meaning: 'Ketika / Saat / Kapan pun / Setiap kali', example: 'Call me whenever you arrive.' },
                { word: 'While / As', meaning: 'Sementara / Selagi / Saat', example: 'While I was studying, my brother slept.' },
                { word: 'Before / After', meaning: 'Sebelum / Setelah (Sesudah)', example: 'Wash your hands before you eat.' },
                { word: 'Since / Until / Till', meaning: 'Sejak / Hingga / Sampai', example: 'I have been here since morning. Wait until he arrives.' },
                { word: 'As soon as / Once', meaning: 'Segera setelah / Begitu', example: 'As soon as the bell rang, the students left.' },
                { word: 'Because / Since / As', meaning: 'Karena / Sebab / Mengingat', example: 'He stayed home because he was sick.' },
                { word: 'So that / In order that', meaning: 'Sehingga / Agar / Supaya', example: 'She studied hard so that she could pass.' },
                { word: 'Although / Even though / Though', meaning: 'Meskipun / Walaupun', example: 'Although it rained, we played soccer.' },
                { word: 'Whereas / While', meaning: 'Sedangkan / Padahal / Sementara', example: 'He loves sports, whereas his sister prefers reading.' },
                { word: 'Even if', meaning: 'Bahkan jika / Pun', example: 'I will go even if it rains.' },
                { word: 'If / Unless', meaning: 'Jika (Kalau) / Kecuali jika (Jika tidak)', example: 'You won\'t succeed unless you try hard.' },
                { word: 'Provided that / As long as', meaning: 'Asalkan / Dengan syarat bahwa', example: 'You can borrow it as long as you return it tomorrow.' },
                { word: 'In case', meaning: 'Jaga-jaga jika / Seandainya', example: 'Take an umbrella in case it rains.' },
                { word: 'Where / Wherever', meaning: 'Di mana / Ke mana pun', example: 'Follow me wherever I go.' },
                { word: 'As / As if / As though', meaning: 'Seperti / Seolah-olah / Seakan-akan', example: 'He acts as if he knew the answer.' }
            ]
        },
        {
            group: 'NOUN',
            category: 'Noun Clause (Klausa Nomina)',
            badge: 'bg-amber-100 text-amber-800 border-amber-300',
            headerBg: 'bg-amber-50 text-amber-900 border-amber-200',
            description: 'Klausa anak yang berfungsi sebagai kata benda (bisa sebagai Subjek, Objek, atau Pelengkap).',
            details: [
                { word: 'That', meaning: 'Bahwa', example: 'I know that honesty is important.' },
                { word: 'What / Whatever', meaning: 'Apa yang / Apa pun yang', example: 'Listen to what I say. Do whatever you like.' },
                { word: 'Who / Whoever', meaning: 'Siapa yang / Siapa pun yang', example: 'Whoever finishes first will win a prize.' },
                { word: 'Whom / Whomever', meaning: 'Siapa yang (objek) / Siapa pun yang (objek)', example: 'Give this to whomever you meet.' },
                { word: 'Which / Whichever', meaning: 'Yang mana / Mana pun yang', example: 'Choose whichever option suits you best.' },
                { word: 'Where / Wherever', meaning: 'Di mana / Di mana pun', example: 'Tell me where you live.' },
                { word: 'When / Whenever', meaning: 'Kapan / Kapan pun', example: 'I remember when we first visited Bali.' },
                { word: 'Why / How', meaning: 'Mengapa (Alasan) / Bagaimana (Cara)', example: 'She explained how the machine works.' },
                { word: 'If / Whether (or not)', meaning: 'Apakah / Apakah ... atau tidak', example: 'I wonder whether it will rain tomorrow.' }
            ]
        }
    ],
    get filteredItems() {
        if (!this.searchQuery.trim()) {
            return this.items;
        }
        const q = this.searchQuery.toLowerCase();
        return this.items.map(group => {
            const matchesGroup = group.category.toLowerCase().includes(q) || group.description.toLowerCase().includes(q);
            const filteredDetails = group.details.filter(d => 
                d.word.toLowerCase().includes(q) || 
                d.meaning.toLowerCase().includes(q) || 
                d.example.toLowerCase().includes(q)
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
}">
    <!-- Floating Button -->
    <button @click="open = true; searchQuery = ''"
            title="Conjunction (Kata Hubung)"
            class="bg-teal-600 hover:bg-teal-700 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
        <span class="hidden sm:inline">Conjunction</span>
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
             class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden border border-slate-200">
           
            <!-- Header with Search -->
            <div class="p-5 border-b border-blue-100 bg-blue-50">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Daftar Conjunction & Clauses</h3>
                        <p class="text-xs text-slate-500">FANBOYS, Adjective Clause, Adverbial Clause, & Noun Clause</p>
                    </div>
                    
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-white/60 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Search Input -->
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        placeholder="Cari kata hubung (misal: FANBOYS, who, because, that)..."
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
            </div>

            <!-- Content Area -->
            <div class="overflow-y-auto p-5 space-y-6 flex-1 bg-slate-50/50" style="max-height: 65vh;">
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
                                        <th class="p-3 w-1/4">Conjunction / Clause</th>
                                        <th class="p-3 w-1/3">Arti Bahasa Indonesia</th>
                                        <th class="p-3">Contoh Kalimat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(detail, dIdx) in group.details" :key="dIdx">
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="p-3 font-bold text-tb-primary whitespace-nowrap" x-text="detail.word"></td>
                                            <td class="p-3 text-slate-700 font-medium" x-text="detail.meaning"></td>
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
                    <p class="font-medium text-base">Tidak ada conjunction yang sesuai pencarian</p>
                    <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain seperti "FANBOYS", "who", "because", atau "that"</p>
                </div>
            </div>

            <div class="p-3 bg-blue-50 border-t border-blue-100 text-right">
                <button @click="open = false" class="px-4 py-2 bg-tb-primary text-white rounded-xl text-xs font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
