<div x-data="{
    open: false,
    searchQuery: '',
    x: window.innerWidth - 260,
    y: window.innerHeight - 150,
    dragging: false,
    offset: { x: 0, y: 0 },
    hasMoved: false,
    pronouns: [
        ['I', 'me', 'my + (noun)', 'mine', 'myself', 'Saya / Aku'],
        ['You', 'you', 'your + (noun)', 'yours', 'yourself', 'Kamu / Anda'],
        ['They', 'them', 'their + (noun)', 'theirs', 'themselves', 'Mereka'],
        ['We', 'us', 'our + (noun)', 'ours', 'ourselves', 'Kami / Kita'],
        ['He', 'him', 'his + (noun)', 'his', 'himself', 'Dia (Laki-laki)'],
        ['She', 'her', 'her + (noun)', 'hers', 'herself', 'Dia (Perempuan)'],
        ['It', 'it', 'its + (noun)', 'its', 'itself', 'Itu (Benda / Hewan)']
    ],
    get filteredPronouns() {
        if (!this.searchQuery.trim()) {
            return this.pronouns;
        }
        const query = this.searchQuery.toLowerCase();
        return this.pronouns.filter(p => 
            p.some(item => item.toLowerCase().includes(query))
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
}">
    <!-- Floating Button -->
    <button @click="open = true"
            title="Pronouns (Kata Ganti)"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span class="hidden sm:inline">Pronoun</span>
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
            class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[80vh] flex flex-col overflow-hidden cursor-auto">
          
            <!-- Header with Search -->
            <div class="p-6 border-b border-gray-100 bg-blue-50">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Daftar Pronoun (Kata Ganti)</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Search Input -->
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        placeholder="Cari kata ganti atau arti..."
                        class="w-full px-4 py-2 pl-10 pr-10 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                           <th class="p-3 border border-blue-600 bg-blue-500 sticky top-0 z-10 shadow-md">Subject</th>
                           <th class="p-3 border border-blue-600 bg-blue-500 sticky top-0 z-10 shadow-md">Object</th>
                           <th class="p-3 border border-blue-600 bg-blue-500 sticky top-0 z-10 shadow-md">Possessive Adjective</th>
                           <th class="p-3 border border-blue-600 bg-blue-500 sticky top-0 z-10 shadow-md">Possessive Pronoun</th>
                           <th class="p-3 border border-blue-600 bg-blue-500 sticky top-0 z-10 shadow-md">Reflexive Pronoun</th>
                           <th class="p-3 border border-blue-600 bg-blue-500 sticky top-0 z-10 shadow-md">Arti</th>
                       </tr>
                   </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(p, index) in filteredPronouns" :key="index">
                            <tr class="odd:bg-white even:bg-blue-50 hover:bg-blue-100 transition-colors">
                                <td class="p-3 border border-gray-200 font-medium text-gray-800" x-text="p[0]"></td>
                                <td class="p-3 border border-gray-200 text-gray-700" x-text="p[1]"></td>
                                <td class="p-3 border border-gray-200 text-gray-700 font-semibold" x-text="p[2]"></td>
                                <td class="p-3 border border-gray-200 text-gray-700" x-text="p[3]"></td>
                                <td class="p-3 border border-gray-200 text-gray-700" x-text="p[4]"></td>
                                <td class="p-3 border border-gray-200 text-gray-600 italic" x-text="p[5]"></td>
                            </tr>
                        </template>
                        
                        <!-- No Results Message -->
                        <tr x-show="filteredPronouns.length === 0">
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                <p class="font-medium">Tidak ada hasil ditemukan</p>
                            </td>
                        </tr>
                    </tbody>
               </table>
           </div>
        </div>
    </div>
</div>
