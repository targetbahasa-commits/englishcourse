<div x-data="{
    open: false,
    searchQuery: '',
    items: [
        {
            group: 'PLACE',
            category: 'Preposition of Place, Position & Direction (Tempat, Posisi & Arah)',
            badge: 'bg-blue-100 text-blue-800 border-blue-300',
            headerBg: 'bg-blue-50 text-blue-900 border-blue-200',
            description: 'Menunjukkan lokasi, tempat, batas, atau arah pergerakan.',
            details: [
                { word: 'In', meaning: 'Di / Di dalam (ruangan, area, kota, negara)', example: 'She lives in Jakarta. / The keys are in the drawer.' },
                { word: 'On', meaning: 'Di / Di atas (permukaan, jalan, lantai)', example: 'The laptop is on the table. / He lives on Main Street.' },
                { word: 'At', meaning: 'Di (titik spesifik, alamat, lokasi tertentu)', example: 'He is waiting at the bus stop. / Meet me at the entrance.' },
                { word: 'Inside', meaning: 'Di bagian dalam / Di dalam', example: 'Go inside the house before it rains.' },
                { word: 'Outside', meaning: 'Di luar / Di bagian luar', example: 'Please wait outside the conference room.' },
                { word: 'Under', meaning: 'Di bawah (tertutup / terhalang)', example: 'The cat is sleeping under the wooden table.' },
                { word: 'Underneath', meaning: 'Tepat di bawah / Di balik', example: 'The lost key was found underneath the rug.' },
                { word: 'Below', meaning: 'Di bawah (posisi / tingkat / suhu lebih rendah)', example: 'The temperature dropped below freezing.' },
                { word: 'Beneath', meaning: 'Di bawah / Di balik (posisi tersembunyi)', example: 'The treasure is buried beneath the old tree.' },
                { word: 'Over', meaning: 'Di atas (melayang / menutupi permukaan)', example: 'The plane flew over the city.' },
                { word: 'Above', meaning: 'Di atas (posisi lebih tinggi dari objek lain)', example: 'The painting hangs above the sofa.' },
                { word: 'Next to / Beside', meaning: 'Di samping / Di sebelah', example: 'Sit next to me during the seminar.' },
                { word: 'By', meaning: 'Di dekat / Di samping', example: 'They built a cottage by the sea.' },
                { word: 'Near / Nearby', meaning: 'Di dekat / Dekat dengan', example: 'The school is located near the park.' },
                { word: 'Close to', meaning: 'Dekat dengan', example: 'She sat close to the fireplace.' },
                { word: 'Between', meaning: 'Di antara (dua benda / orang)', example: 'He stood between John and Mary.' },
                { word: 'Among / Amongst', meaning: 'Di antara (banyak benda / anggota kelompok)', example: 'She felt comfortable among her classmates.' },
                { word: 'Behind', meaning: 'Di belakang', example: 'The garden is situated behind the building.' },
                { word: 'In front of', meaning: 'Di depan', example: 'He parked his car in front of the gate.' },
                { word: 'Opposite / Across from', meaning: 'Berseberangan dengan / Di seberang', example: 'The bank is opposite the grocery store.' },
                { word: 'Into', meaning: 'Ke dalam (ada gerakan masuk)', example: 'She walked into the office.' },
                { word: 'Out of', meaning: 'Keluar dari (ada gerakan keluar)', example: 'He got out of the taxi.' },
                { word: 'Onto', meaning: 'Ke atas (gerakan naik ke permukaan)', example: 'The cat jumped onto the kitchen counter.' },
                { word: 'Off', meaning: 'Lepas dari / Turun dari', example: 'Keep off the grass! / Take it off the shelf.' },
                { word: 'Through', meaning: 'Melalui / Menembus (ruang 3 dimensi)', example: 'The train traveled through the long tunnel.' },
                { word: 'Across', meaning: 'Menyeberangi / Di seberang', example: 'They walked across the wooden bridge.' },
                { word: 'Along', meaning: 'Di sepanjang', example: 'We took a stroll along the beach.' },
                { word: 'Towards / Toward', meaning: 'Menuju / Ke arah', example: 'She ran towards the finish line.' },
                { word: 'Away from', meaning: 'Jauh dari / Menjauh dari', example: 'Walk away from the dangerous area.' },
                { word: 'Up', meaning: 'Ke atas / Naik', example: 'Climb up the stairs.' },
                { word: 'Down', meaning: 'Ke bawah / Turun', example: 'Go down the hill slowly.' },
                { word: 'Around / Round', meaning: 'Di sekitar / Mengelilingi', example: 'Sit around the dining table.' },
                { word: 'Past', meaning: 'Melewati / Melewati titik', example: 'Walk past the library and turn left.' },
                { word: 'Beyond', meaning: 'Di luar / Melampaui batas', example: 'The village lies beyond the mountains.' },
                { word: 'Amid / Amidst', meaning: 'Di tengah-tengah / Di tengah suasana', example: 'He stayed calm amid the chaos.' }
            ]
        },
        {
            group: 'TIME',
            category: 'Preposition of Time & Duration (Waktu & Durasi)',
            badge: 'bg-emerald-100 text-emerald-800 border-emerald-300',
            headerBg: 'bg-emerald-50 text-emerald-900 border-emerald-200',
            description: 'Menunjukkan waktu terjadinya sesuatu (jam, hari, bulan, durasi, tenggat).',
            details: [
                { word: 'At', meaning: 'Pada (jam spesifik, waktu tepat, malam, akhir pekan)', example: 'At 5 PM, at midnight, at noon, at the weekend.' },
                { word: 'On', meaning: 'Pada (hari, tanggal, hari libur spesifik)', example: 'On Monday, on May 1st, on my birthday.' },
                { word: 'In', meaning: 'Pada / Dalam (bulan, tahun, abad, musim, waktu hari)', example: 'In 2026, in August, in summer, in the morning.' },
                { word: 'Before', meaning: 'Sebelum', example: 'Finish the report before noon.' },
                { word: 'After', meaning: 'Setelah / Sesudah', example: 'Let\'s discuss this after the presentation.' },
                { word: 'During', meaning: 'Selama / Selama berlangsungnya (suatu kegiatan)', example: 'He fell asleep during the lecture.' },
                { word: 'For', meaning: 'Selama (durasi rentang waktu tertentu)', example: 'I have lived here for five years.' },
                { word: 'Since', meaning: 'Sejak (titik awal mulai waktu)', example: 'She has been working here since 2020.' },
                { word: 'Until / Till', meaning: 'Hingga / Sampai', example: 'The store is open until 9 PM.' },
                { word: 'By', meaning: 'Paling lambat pada / Sebelum batas waktu', example: 'Please submit your assignment by Friday.' },
                { word: 'Within', meaning: 'Dalam jangka waktu / Kurang dari', example: 'Reply to this email within 24 hours.' },
                { word: 'Throughout', meaning: 'Sepanjang / Selama seluruh periode', example: 'It rained throughout the night.' },
                { word: 'From ... to / until', meaning: 'Dari ... sampai', example: 'The museum is open from 9 AM to 5 PM.' },
                { word: 'Over', meaning: 'Selama (jangka waktu tertentu)', example: 'We will discuss this over the weekend.' },
                { word: 'Prior to', meaning: 'Sebelum / Dahulu dari', example: 'Prior to the event, check your ticket.' },
                { word: 'Pending', meaning: 'Sambil menunggu / Hingga adanya keputusan', example: 'He was suspended pending investigation.' }
            ]
        },
        {
            group: 'MANNER',
            category: 'Preposition of Manner, Instrument & Agent (Cara, Sarana, & Pembuat)',
            badge: 'bg-purple-100 text-purple-800 border-purple-300',
            headerBg: 'bg-purple-50 text-purple-900 border-purple-200',
            description: 'Menunjukkan cara melakukan sesuatu, media, instrumen, atau pembuat.',
            details: [
                { word: 'By', meaning: 'Dengan / Oleh / Menggunakan (transportasi / metode / pembuat)', example: 'He travels by train. / The book was written by Shakespeare.' },
                { word: 'With', meaning: 'Dengan / Bersama / Menggunakan alat', example: 'She wrote the note with a pen. / Go with him.' },
                { word: 'Without', meaning: 'Tanpa', example: 'You cannot live without water.' },
                { word: 'Like', meaning: 'Seperti / Mirip dengan', example: 'He acts like a professional athlete.' },
                { word: 'As', meaning: 'Sebagai (peran / status resmi)', example: 'She works as a senior software engineer.' },
                { word: 'In', meaning: 'Dalam / Dengan cara (bahasa, kondisi, suasana)', example: 'Written in English. / He left in a hurry.' },
                { word: 'On', meaning: 'Dengan / Menggunakan (media / perangkat)', example: 'I heard it on the radio. / On foot.' },
                { word: 'Via', meaning: 'Melalui / Lewat (jalur / media)', example: 'The document was sent via courier.' }
            ]
        },
        {
            group: 'CAUSE',
            category: 'Preposition of Cause, Reason & Purpose (Sebab, Alasan & Tujuan)',
            badge: 'bg-rose-100 text-rose-800 border-rose-300',
            headerBg: 'bg-rose-50 text-rose-900 border-rose-200',
            description: 'Menjelaskan alasan terjadinya sesuatu atau tujuan.',
            details: [
                { word: 'For', meaning: 'Untuk / Demi / Sebagai tujuan', example: 'This trophy is for the winner.' },
                { word: 'Because of', meaning: 'Karena / Dikarenakan (karena benda/frasa)', example: 'The match was canceled because of rain.' },
                { word: 'Due to', meaning: 'Dikarenakan / Disebabkan oleh', example: 'Delays due to technical issues.' },
                { word: 'Owing to', meaning: 'Karena / Mengingat', example: 'Owing to bad weather, flights were grounded.' },
                { word: 'On account of', meaning: 'Karena / Mengingat', example: 'He retired on account of poor health.' },
                { word: 'Thanks to', meaning: 'Berkat / Karena bantuan', example: 'Thanks to your help, we finished early.' },
                { word: 'Out of', meaning: 'Didorong oleh / Karena (emosi/alasan)', example: 'He helped her out of kindness.' },
                { word: 'For the sake of', meaning: 'Demi / Untuk kepentingan', example: 'For the sake of peace, they compromised.' }
            ]
        },
        {
            group: 'COMPLEX',
            category: 'Compound & Complex Prepositions (Preposisi Majemuk)',
            badge: 'bg-amber-100 text-amber-800 border-amber-300',
            headerBg: 'bg-amber-50 text-amber-900 border-amber-200',
            description: 'Frasa preposisi gabungan yang sering digunakan dalam bahasa penulisan formal & akademis.',
            details: [
                { word: 'According to', meaning: 'Menurut / Berdasarkan', example: 'According to the survey, 80% agreed.' },
                { word: 'In addition to', meaning: 'Selain / Sebagai tambahan dari', example: 'In addition to writing, she paints.' },
                { word: 'Instead of', meaning: 'Alih-alih / Sebagai ganti dari', example: 'Choose water instead of soda.' },
                { word: 'In spite of / Despite', meaning: 'Meskipun / Walaupun', example: 'Despite the rain, they continued playing.' },
                { word: 'In terms of', meaning: 'Dalam hal / Dari segi', example: 'In terms of cost, it is very economical.' },
                { word: 'On behalf of', meaning: 'Atas nama / Mewakili', example: 'I accept this award on behalf of my team.' },
                { word: 'Regardless of', meaning: 'Tanpa memedulikan / Terlepas dari', example: 'Everyone can apply regardless of background.' },
                { word: 'In case of', meaning: 'Jika terjadi / Dalam hal', example: 'In case of emergency, call 911.' },
                { word: 'In place of', meaning: 'Sebagai pengganti', example: 'He was hired in place of the former director.' },
                { word: 'By means of', meaning: 'Dengan cara / Melalui sarana', example: 'They succeeded by means of hard work.' },
                { word: 'In accordance with', meaning: 'Sesuai dengan / Berdasarkan aturan', example: 'Act in accordance with company policy.' },
                { word: 'As well as', meaning: 'Dan juga / Serta', example: 'He speaks English as well as German.' },
                { word: 'With regard to / Regarding', meaning: 'Mengenai / Berkenaan dengan', example: 'With regard to your request, we agree.' },
                { word: 'In relation to', meaning: 'Berkenaan dengan / Terkait', example: 'Questions in relation to the new policy.' },
                { word: 'Contrary to', meaning: 'Berlawanan dengan / Berbeda dari', example: 'Contrary to popular belief, it works.' }
            ]
        },
        {
            group: 'DEPENDENT',
            category: 'Dependent Prepositions (Pasangan Preposisi Kata Kerja & Adjektiva)',
            badge: 'bg-indigo-100 text-indigo-800 border-indigo-300',
            headerBg: 'bg-indigo-50 text-indigo-900 border-indigo-200',
            description: 'Kombinasi preposisi wajib yang melekat pada kata sifat (Adjective) atau kata kerja (Verb).',
            details: [
                { word: 'Interested in', meaning: 'Tertarik pada', example: 'She is interested in art history.' },
                { word: 'Good at / Bad at', meaning: 'Bagus dalam / Buruk dalam', example: 'He is very good at mathematics.' },
                { word: 'Afraid of / Scared of', meaning: 'Takut pada', example: 'Many children are afraid of the dark.' },
                { word: 'Depend on / Rely on', meaning: 'Tergantung pada / Mempercayakan pada', example: 'Success depends on your effort.' },
                { word: 'Belong to', meaning: 'Milik / Termasuk kepunyaan', example: 'This notebook belongs to Sarah.' },
                { word: 'Succeed in', meaning: 'Berhasil dalam', example: 'He succeeded in passing the test.' },
                { word: 'Famous for', meaning: 'Terkenal karena', example: 'Italy is famous for its cuisine.' },
                { word: 'Responsible for', meaning: 'Bertanggung jawab atas', example: 'You are responsible for your actions.' },
                { word: 'Pleased with / Satisfied with', meaning: 'Puas dengan', example: 'The teacher was pleased with her score.' },
                { word: 'Used to / Accustomed to', meaning: 'Terbiasa dengan', example: 'I am used to getting up early.' }
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
            title="Preposition (Kata Depan)"
            class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        <span class="hidden sm:inline">Preposition</span>
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
            <div class="p-5 border-b border-cyan-100 bg-gradient-to-r from-cyan-50 to-blue-50">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Daftar Lengkap Preposisi (Prepositions)</h3>
                        <p class="text-xs text-slate-500">85+ Preposisi Bahasa Inggris Lengkap dengan Arti & Contoh Kalimat</p>
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
                        placeholder="Cari kata preposisi (misal: in, on, at, despite, because of, beneath, towards)..."
                        class="w-full px-4 py-2.5 pl-10 pr-10 border border-cyan-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white text-sm"
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
                                        <th class="p-3 w-1/4">Preposition</th>
                                        <th class="p-3 w-1/3">Arti Bahasa Indonesia</th>
                                        <th class="p-3">Contoh Kalimat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(detail, dIdx) in group.details" :key="dIdx">
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="p-3 font-bold text-cyan-700 whitespace-nowrap" x-text="detail.word"></td>
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
                    <p class="font-medium text-base">Tidak ada preposisi yang sesuai pencarian</p>
                    <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain seperti "in", "on", "at", "despite", atau "because of"</p>
                </div>
            </div>

            <div class="p-3 bg-slate-100 border-t border-slate-200 text-right">
                <button @click="open = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
