<div x-data="{
    open: false,
    searchQuery: '',
    x: window.innerWidth / 2 - 350,
    y: window.innerHeight - 85,
    dragging: false,
    offset: { x: 0, y: 0 },
    hasMoved: false,
    words: [
        { category: 'Time / Chronological (Waktu)', words: 'Afterwards – Setelah itu, Soon – Segera, Meanwhile – Sementara itu, In the meantime – Selagi itu, Next – Berikutnya, Then – Lalu, Later – Nanti, Eventually – Akhirnya, At the same time – Pada saat yang sama, In the same instant – Dalam waktu yang bersamaan, Today – Hari ini, Nowadays – Sekarang ini, In the beginning – Pada awalnya, To begin – Untuk memulai, In time – Pada waktunya, In future – Di masa depan, Finally – Akhirnya, Initially – Awalnya, Subsequently – Selanjutnya, Simultaneously – Secara bersamaan' },
        
        { category: 'Addition (Penambahan)', words: 'Moreover – Selain itu, Furthermore – Lebih lanjut, In addition – Sebagai tambahan, Further – Selanjutnya' },
        
        { category: 'Sequential (Urutan)', words: 'Next – Berikutnya, First – Pertama, Second – Kedua, Third – Ketiga, Firstly – Pertama-tama, Secondly – Kedua, Thirdly – Ketiga, In the first place – Yang pertama, In the second place – Yang kedua, In the third place – Yang ketiga' },
        
        { category: 'Contrast (Pertentangan)', words: 'However – Namun, Yet – Namun demikian, In contrast – Sebaliknya, Conversely – Sebaliknya, On the other hand – Di sisi lain, On the contrary – Sebaliknya, Otherwise – Jika tidak, Nevertheless – Meskipun begitu, Notwithstanding – Walaupun demikian, In spite of this – Meskipun demikian, By contrast – Sebagai perbandingan, Whereas – Padahal' },
        
        { category: 'Conclusion / Summary (Kesimpulan)', words: 'As a result – Akibatnya, As has been noted – Seperti dicatat, As I have said – Seperti dikatakan, As mentioned earlier – Seperti disebutkan, In conclusion – Kesimpulan, To conclude – Untuk menyimpulkan, In brief – Secara singkat, Finally – Akhirnya, In other words – Dengan kata lain, In short – Singkatnya, In a word – Dalam satu kata, On the whole – Secara keseluruhan, Therefore – Oleh karena itu, In summary – Ringkasnya, To summarize – Merangkum, To sum up – Menyimpulkan, All in all – Secara keseluruhan' },
        
        { category: 'Similarity (Persamaan)', words: 'Likewise – Demikian juga, Similarly – Demikian pula, In the same way – Dengan cara sama, In like manner – Dengan cara serupa' },
        
        { category: 'Cause & Effect (Logika/Sebab-Akibat)', words: 'Therefore – Oleh karena itu, Thus – Jadi, Hence – Maka, Consequently – Akibatnya, After all – Bagaimanapun juga, Accordingly – Dengan demikian, Knowing this – Mengetahui hal ini, With this in mind – Dengan pertimbangan ini' },
        
        { category: 'Example / Clarification (Contoh/Klarifikasi)', words: 'For example – Misalnya, For instance – Contohnya, More specifically – Lebih spesifik, In particular – Secara khusus, Indeed – Memang, Namely – Yaitu, Specifically – Secara khusus, To illustrate – Untuk menggambarkan, In other words – Dengan kata lain, In fact – Sebenarnya, That is – Yaitu, In brief – Singkatnya' },
        
        { category: 'Reason / Cause (Alasan/Sebab)', words: 'Because – Karena, Because of – Dikarenakan, Since – Karena, As – Karena, Due to – Dikarenakan, Owing to – Dikarenakan, Thanks to – Berkat, For the reason that – Dengan alasan bahwa, On account of – Dikarenakan, Given that – Mengingat bahwa' }
    ],
    get filteredWords() {
        if (!this.searchQuery.trim()) {
            return this.words;
        }
        const query = this.searchQuery.toLowerCase();
        return this.words.filter(item => 
            item.category.toLowerCase().includes(query) || 
            item.words.toLowerCase().includes(query)
        );
    },
    init() {
        window.addEventListener('resize', () => {
            this.x = Math.min(this.x, window.innerWidth - 60);
            this.y = Math.min(this.y, window.innerHeight - 60);
        });
    },
    startDrag(e) {
        this.dragging = true;
        this.hasMoved = false;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        this.offset.x = clientX - this.x;
        this.offset.y = clientY - this.y;
    },
    doDrag(e) {
        if (this.dragging) {
            this.hasMoved = true;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            this.x = clientX - this.offset.x;
            this.y = clientY - this.offset.y;
        }
    },
    stopDrag() {
        this.dragging = false;
    },
    handleClick() {
        if (!this.hasMoved) {
            this.open = true;
            this.searchQuery = ''; 
        }
    }
}"
@mousemove.window="doDrag"
@touchmove.window="doDrag"
@mouseup.window="stopDrag"
@touchend.window="stopDrag"
class="fixed z-50 select-none touch-none"
:style="`left: ${x}px; top: ${y}px;`">
    <!-- Floating Button -->
    <button @mousedown="startDrag"
            @touchstart="startDrag"
            @click="handleClick"
            class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2 cursor-move">
        <span>🔗</span> Linking Words
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
       
        <!-- Modal Content -->
        <div @click.outside="open = false"
             class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
           
            <!-- Header with Search -->
            <div class="p-6 border-b border-gray-100 bg-teal-50">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Daftar Linking Words</h3>
                    
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Search Input -->
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        placeholder="Cari kategori atau kata..."
                        class="w-full px-4 py-2 pl-10 pr-10 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <button x-show="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-y-auto px-6 pb-6" style="max-height: 60vh;">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3 border border-teal-600 bg-teal-500 sticky top-0 z-10 shadow-md w-1/4">Function / Kategori</th>
                            <th class="p-3 border border-teal-600 bg-teal-500 sticky top-0 z-10 shadow-md">Linking Words</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(item, index) in filteredWords" :key="index">
                            <tr class="odd:bg-white even:bg-teal-50 hover:bg-teal-100 transition-colors">
                                <td class="p-3 border border-gray-200 font-bold text-teal-800" x-text="item.category"></td>
                                <td class="p-3 border border-gray-200 text-gray-700 leading-relaxed">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="word in item.words.split(', ')" :key="word">
                                            <span class="px-2 py-1 bg-white border border-teal-200 rounded text-teal-700" x-text="word"></span>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        
                        <!-- No Results Message -->
                        <tr x-show="filteredWords.length === 0">
                            <td colspan="2" class="p-8 text-center text-gray-500">
                                <p class="font-medium">Tidak ada hasil ditemukan</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Note -->
            <div class="p-4 bg-teal-50 border-t border-teal-100 text-center">
                <p class="text-sm text-gray-700 font-medium">
                    💡 Gunakan linking words untuk meningkatkan <strong>Coherence & Cohesion</strong> tulisan Anda.
                </p>
            </div>
        </div>
    </div>
</div>
