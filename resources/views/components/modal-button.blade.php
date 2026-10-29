{{-- Modal Auxiliaries Button Component --}}
<div x-data="{
    open: false,
    searchQuery: '',
    selectedCategory: 'all',
    modals: [
        {
            modal: 'Can',
            type: 'Present',
            function: 'Kemampuan (Ability), Izin (Permission)',
            meaning: 'Bisa, Dapat, Mampu, Boleh',
            formula: 'S + can + V1',
            example: 'I can speak three languages.',
            exampleId: 'Saya bisa berbicara tiga bahasa.',
            category: 'ability'
        },
        {
            modal: 'Could',
            type: 'Past / Polite',
            function: 'Kemampuan lampau (Past Ability), Permintaan sopan (Polite Request)',
            meaning: 'Bisa/Dapat (dulu), Sudikah/Bisakah',
            formula: 'S + could + V1 / Could + S + V1?',
            example: 'Could you please help me with this task?',
            exampleId: 'Bisakah Anda membantu saya mengerjakan tugas ini?',
            category: 'ability'
        },
        {
            modal: 'May',
            type: 'Present',
            function: 'Izin resmi (Formal Permission), Kemungkinan (Possibility ~50%)',
            meaning: 'Boleh, Mungkin',
            formula: 'S + may + V1 / May + S + V1?',
            example: 'May I leave the room early today?',
            exampleId: 'Bolehkah saya meninggalkan ruangan lebih awal hari ini?',
            category: 'permission'
        },
        {
            modal: 'Might',
            type: 'Possibility',
            function: 'Kemungkinan kecil (Weak Possibility ~30%)',
            meaning: 'Mungkin saja, Barangkali',
            formula: 'S + might + V1',
            example: 'It might rain later this afternoon.',
            exampleId: 'Mungkin saja nanti sore akan hujan.',
            category: 'possibility'
        },
        {
            modal: 'Must',
            type: 'Present / Future',
            function: 'Keharusan mutlak (Strong Obligation), Kesimpulan pasti (Deduction 95%)',
            meaning: 'Harus, Wajib, Pasti',
            formula: 'S + must + V1 / S + must be + Adj',
            example: 'You must submit your report before 5 PM. / He must be exhausted.',
            exampleId: 'Kamu wajib mengumpulkan laporanmu sebelum jam 5 sore. / Dia pasti kelelahan.',
            category: 'obligation'
        },
        {
            modal: 'Must not (Mustn\'t)',
            type: 'Prohibition',
            function: 'Larangan keras (Prohibition)',
            meaning: 'Dilarang, Tidak boleh sama sekali',
            formula: 'S + must not + V1',
            example: 'You must not use your phone during the exam.',
            exampleId: 'Kamu dilarang menggunakan ponsel selama ujian.',
            category: 'obligation'
        },
        {
            modal: 'Have to / Has to',
            type: 'Semi-Modal',
            function: 'Keharusan karena aturan eksternal (External Obligation)',
            meaning: 'Harus, Terpaksa harus',
            formula: 'S + have/has to + V1',
            example: 'Employees have to wear an ID card at the office.',
            exampleId: 'Karyawan harus memakai kartu pengenal di kantor.',
            category: 'obligation'
        },
        {
            modal: 'Don\'t / Doesn\'t have to',
            type: 'Lack of Obligation',
            function: 'Tidak perlu / Tidak ada keharusan',
            meaning: 'Tidak harus, Tidak perlu',
            formula: 'S + don\'t/doesn\'t have to + V1',
            example: 'Tomorrow is Sunday, so you don\'t have to wake up early.',
            exampleId: 'Besok hari Minggu, jadi kamu tidak harus bangun pagi.',
            category: 'obligation'
        },
        {
            modal: 'Should',
            type: 'Advice',
            function: 'Saran / Anjuran (Advice / Recommendation)',
            meaning: 'Seharusnya, Sebaiknya',
            formula: 'S + should + V1 / S + should not + V1',
            example: 'You should drink more water every day.',
            exampleId: 'Kamu sebaiknya minum lebih banyak air setiap hari.',
            category: 'advice'
        },
        {
            modal: 'Ought to',
            type: 'Moral Obligation',
            function: 'Kewajiban moral / Saran yang kuat',
            meaning: 'Seharusnya, Patutnya',
            formula: 'S + ought to + V1',
            example: 'We ought to respect our parents and teachers.',
            exampleId: 'Kita seharusnya menghormati orang tua dan guru kita.',
            category: 'advice'
        },
        {
            modal: 'Had better',
            type: 'Strong Advice',
            function: 'Saran mendesak dengan konsekuensi (Urgent Advice)',
            meaning: 'Lebih baik (jika tidak, ada resiko)',
            formula: 'S + had better + V1 (not \'to\')',
            example: 'You had better hurry, or you will miss the train.',
            exampleId: 'Kamu lebih baik bergegas, atau kamu akan ketinggalan kereta.',
            category: 'advice'
        },
        {
            modal: 'Will',
            type: 'Future / Promise',
            function: 'Keputusan spontan, Masa depan (Future), Janji/Kesediaan (Willingness)',
            meaning: 'Akan, Mau',
            formula: 'S + will + V1 / Won\'t + V1',
            example: 'I will support you no matter what happens.',
            exampleId: 'Saya akan mendukungmu apapun yang terjadi.',
            category: 'future'
        },
        {
            modal: 'Would',
            type: 'Past Future / Polite',
            function: 'Permintaan sangat sopan (Polite Request), Kebiasaan lampau (Past Habit)',
            meaning: 'Sudikah, Maukah, Akan (lampau)',
            formula: 'Would + S + like / Would + S + mind + V-ing / S + would + V1',
            example: 'Would you like a cup of coffee? / Would you mind opening the door?',
            exampleId: 'Apakah Anda ingin secangkir kopi? / Sudikah Anda membukakan pintunya?',
            category: 'future'
        },
        {
            modal: 'Shall',
            type: 'Formal / Offer',
            function: 'Tawaran bantuan / Saran bersama (dengan I & We)',
            meaning: 'Haruskah kita, Mari kita, Akan',
            formula: 'Shall + I/We + V1?',
            example: 'Shall we start the meeting now?',
            exampleId: 'Haruskah kita memulai rapatnya sekarang?',
            category: 'future'
        },
        {
            modal: 'Need to',
            type: 'Semi-Modal',
            function: 'Kebutuhan / Keperluan (Necessity)',
            meaning: 'Perlu untuk',
            formula: 'S + need(s) to + V1',
            example: 'She needs to improve her vocabulary score.',
            exampleId: 'Dia perlu meningkatkan nilai kosakatanya.',
            category: 'obligation'
        }
    ],
    get filteredModals() {
        let list = this.modals;
        if (this.selectedCategory !== 'all') {
            list = list.filter(m => m.category === this.selectedCategory);
        }
        if (this.searchQuery.trim()) {
            const q = this.searchQuery.toLowerCase();
            list = list.filter(m => 
                m.modal.toLowerCase().includes(q) ||
                m.meaning.toLowerCase().includes(q) ||
                m.function.toLowerCase().includes(q) ||
                m.example.toLowerCase().includes(q) ||
                m.exampleId.toLowerCase().includes(q)
            );
        }
        return list;
    }
}">
    <!-- Floating Button -->
    <button @click="open = true; searchQuery = ''"
            title="Modal Auxiliaries"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <span>Modal</span>
    </button>

    <!-- Modal Backdrop -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         style="display: none;">
      
        <!-- Modal Content Container -->
        <div @click.outside="open = false"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[88vh] flex flex-col overflow-hidden">
          
            <!-- Header -->
            <div class="p-5 border-b border-blue-100 bg-tb-primary text-white flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold">Panduan Lengkap Modal Auxiliaries</h3>
                    <p class="text-xs text-blue-100 mt-0.5">Rumus, fungsi, arti, dan contoh kata kerja bantu (Modal Verbs)</p>
                </div>
                <button @click="open = false" class="text-white hover:text-blue-200 p-1 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Rumus / Key Rules Box -->
            <div class="bg-blue-50/80 px-6 py-3 border-b border-blue-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                    <div class="bg-white p-2.5 rounded-xl border border-blue-200 shadow-xs">
                        <span class="font-bold text-tb-primary block mb-1">1. Verbal (Dasar)</span>
                        <code class="text-tb-primary font-semibold font-mono">S + Modal + V1 (Bare Inf)</code>
                        <p class="text-gray-600 mt-1">Tanpa <em class="text-red-500">to/s/es/ing</em> setelah modal.</p>
                    </div>
                    <div class="bg-white p-2.5 rounded-xl border border-blue-200 shadow-xs">
                        <span class="font-bold text-tb-primary block mb-1">2. Nominal / Adjective</span>
                        <code class="text-tb-primary font-semibold font-mono">S + Modal + be + Adj/Noun</code>
                        <p class="text-gray-600 mt-1">Gunakan <strong>be</strong> sebelum kata sifat/benda.</p>
                    </div>
                    <div class="bg-white p-2.5 rounded-xl border border-blue-200 shadow-xs">
                        <span class="font-bold text-tb-primary block mb-1">3. Pasif (Passive)</span>
                        <code class="text-tb-primary font-semibold font-mono">S + Modal + be + V3</code>
                        <p class="text-gray-600 mt-1">Bermakna pasif ("di-" atau "ter-").</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Controls -->
            <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row gap-3 items-center justify-between bg-white">
                <div class="relative w-full sm:w-72">
                    <input type="text"
                           x-model="searchQuery"
                           placeholder="Cari modal, arti, atau fungsi..."
                           class="w-full pl-9 pr-8 py-2 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-tb focus:outline-none">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <button x-show="searchQuery" @click="searchQuery = ''" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs">✕</button>
                </div>

                <!-- Category Filters -->
                <div class="flex flex-wrap gap-1.5 w-full sm:w-auto">
                    <button @click="selectedCategory = 'all'"
                            :class="selectedCategory === 'all' ? 'bg-tb-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3 py-1 rounded-lg text-xs font-semibold transition">Semua</button>
                    <button @click="selectedCategory = 'ability'"
                            :class="selectedCategory === 'ability' ? 'bg-tb-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3 py-1 rounded-lg text-xs font-semibold transition">Kemampuan</button>
                    <button @click="selectedCategory = 'obligation'"
                            :class="selectedCategory === 'obligation' ? 'bg-tb-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3 py-1 rounded-lg text-xs font-semibold transition">Keharusan / Larangan</button>
                    <button @click="selectedCategory = 'advice'"
                            :class="selectedCategory === 'advice' ? 'bg-tb-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3 py-1 rounded-lg text-xs font-semibold transition">Saran</button>
                    <button @click="selectedCategory = 'possibility'"
                            :class="selectedCategory === 'possibility' ? 'bg-tb-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3 py-1 rounded-lg text-xs font-semibold transition">Kemungkinan</button>
                    <button @click="selectedCategory = 'future'"
                            :class="selectedCategory === 'future' ? 'bg-tb-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3 py-1 rounded-lg text-xs font-semibold transition">Masa Depan / Tawaran</button>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-y-auto p-4 flex-1" style="max-height: 52vh;">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-blue-50 text-tb-primary font-bold sticky top-0 border-b border-blue-200">
                        <tr>
                            <th class="p-3 w-32">Modal</th>
                            <th class="p-3 w-40">Arti (Bahasa Indonesia)</th>
                            <th class="p-3 w-48">Fungsi / Kegunaan</th>
                            <th class="p-3">Pola & Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(item, idx) in filteredModals" :key="idx">
                            <tr class="hover:bg-blue-50/50 transition-colors odd:bg-white even:bg-slate-50/60">
                                <td class="p-3 align-top">
                                    <span class="font-bold text-sm text-tb-primary block" x-text="item.modal"></span>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 text-[10px] rounded-full bg-blue-100 text-tb-primary font-medium" x-text="item.type"></span>
                                </td>
                                <td class="p-3 align-top font-semibold text-gray-800" x-text="item.meaning"></td>
                                <td class="p-3 align-top text-gray-600 leading-relaxed" x-text="item.function"></td>
                                <td class="p-3 align-top">
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-2 font-mono text-[11px] text-tb-primary mb-1" x-text="item.formula"></div>
                                    <div class="text-gray-900 font-medium" x-text="item.example"></div>
                                    <div class="text-gray-500 italic text-[11px] mt-0.5" x-text="item.exampleId"></div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredModals.length === 0">
                            <td colspan="4" class="p-8 text-center text-gray-400">
                                Tidak ada modal yang cocok dengan kata pencarian "<span x-text="searchQuery" class="font-semibold"></span>".
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Note -->
            <div class="p-3 bg-blue-50/50 border-t border-blue-100 text-center text-xs text-gray-600">
                💡 <strong>Kunci Utama:</strong> Semua modal selalu diikuti oleh <strong>Verb 1 dasar (Bare Infinitive)</strong> atau <strong>be + Adjective/Noun</strong>.
            </div>
        </div>
    </div>
</div>
