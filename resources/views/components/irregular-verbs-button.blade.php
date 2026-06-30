<div x-data="{
    open: false,
    searchQuery: '',
    x: window.innerWidth - 260,
    y: window.innerHeight - 85,
    dragging: false,
    offset: { x: 0, y: 0 },
    hasMoved: false,
    verbs: [
        ['arise', 'arose', 'arisen', 'timbul'],
        ['awake', 'awoke', 'awoken', 'bangun'],
        ['be', 'was/were', 'been', 'menjadi'],
        ['bear', 'bore', 'born(e)', 'menanggung'],
        ['beat', 'beat', 'beaten', 'mengalahkan'],
        ['become', 'became', 'become', 'menjadi'],
        ['begin', 'began', 'begun', 'mulai'],
        ['bend', 'bent', 'bent', 'membengkokkan'],
        ['bet', 'bet', 'bet', 'bertaruh'],
        ['bind', 'bound', 'bound', 'mengikat'],
        ['bite', 'bit', 'bitten', 'menggigit'],
        ['bleed', 'bled', 'bled', 'berdarah'],
        ['blow', 'blew', 'blown', 'meniup'],
        ['break', 'broke', 'broken', 'memecahkan'],
        ['breed', 'bred', 'bred', 'berkembang biak'],
        ['bring', 'brought', 'brought', 'membawa'],
        ['broadcast', 'broadcast', 'broadcast', 'menyiarkan'],
        ['build', 'built', 'built', 'membangun'],
        ['burn', 'burnt/burned', 'burnt/burned', 'membakar'],
        ['burst', 'burst', 'burst', 'meledak'],
        ['buy', 'bought', 'bought', 'membeli'],
        ['cast', 'cast', 'cast', 'melempar'],
        ['catch', 'caught', 'caught', 'menangkap'],
        ['choose', 'chose', 'chosen', 'memilih'],
        ['cling', 'clung', 'clung', 'melekat'],
        ['come', 'came', 'come', 'datang'],
        ['cost', 'cost', 'cost', 'berharga'],
        ['creep', 'crept', 'crept', 'merayap'],
        ['cut', 'cut', 'cut', 'memotong'],
        ['deal', 'dealt', 'dealt', 'berurusan'],
        ['dig', 'dug', 'dug', 'menggali'],
        ['do', 'did', 'done', 'melakukan'],
        ['draw', 'drew', 'drawn', 'menggambar'],
        ['dream', 'dreamt/dreamed', 'dreamt/dreamed', 'bermimpi'],
        ['drink', 'drank', 'drunk', 'minum'],
        ['drive', 'drove', 'driven', 'mengemudi'],
        ['eat', 'ate', 'eaten', 'makan'],
        ['fall', 'fell', 'fallen', 'jatuh'],
        ['feed', 'fed', 'fed', 'memberi makan'],
        ['feel', 'felt', 'felt', 'merasa'],
        ['fight', 'fought', 'fought', 'berkelahi'],
        ['find', 'found', 'found', 'menemukan'],
        ['flee', 'fled', 'fled', 'melarikan diri'],
        ['fly', 'flew', 'flown', 'terbang'],
        ['forbid', 'forbade', 'forbidden', 'melarang'],
        ['forget', 'forgot', 'forgotten', 'lupa'],
        ['forgive', 'forgave', 'forgiven', 'memaafkan'],
        ['freeze', 'froze', 'frozen', 'membeku'],
        ['get', 'got', 'got/gotten', 'mendapatkan'],
        ['give', 'gave', 'given', 'memberi'],
        ['go', 'went', 'gone', 'pergi'],
        ['grind', 'ground', 'ground', 'menggiling'],
        ['grow', 'grew', 'grown', 'tumbuh'],
        ['hang', 'hung', 'hung', 'menggantung'],
        ['have', 'had', 'had', 'mempunyai'],
        ['hear', 'heard', 'heard', 'mendengar'],
        ['hide', 'hid', 'hidden', 'menyembunyikan'],
        ['hit', 'hit', 'hit', 'memukul'],
        ['hold', 'held', 'held', 'memegang'],
        ['hurt', 'hurt', 'hurt', 'melukai'],
        ['keep', 'kept', 'kept', 'menyimpan'],
        ['kneel', 'knelt', 'knelt', 'berlutut'],
        ['know', 'knew', 'known', 'mengetahui'],
        ['lay', 'laid', 'laid', 'meletakkan'],
        ['lead', 'led', 'led', 'memimpin'],
        ['lean', 'leant/leaned', 'leant/leaned', 'bersandar'],
        ['leap', 'leapt/leaped', 'leapt/leaped', 'melompat'],
        ['learn', 'learnt/learned', 'learnt/learned', 'belajar'],
        ['leave', 'left', 'left', 'meninggalkan'],
        ['lend', 'lent', 'lent', 'meminjamkan'],
        ['let', 'let', 'let', 'membiarkan'],
        ['lie', 'lay', 'lain', 'berbaring'],
        ['light', 'lit/lighted', 'lit/lighted', 'menyalakan'],
        ['lose', 'lost', 'lost', 'kehilangan'],
        ['make', 'made', 'made', 'membuat'],
        ['mean', 'meant', 'meant', 'berarti'],
        ['meet', 'met', 'met', 'bertemu'],
        ['mow', 'mowed', 'mown/mowed', 'memotong rumput'],
        ['overcome', 'overcame', 'overcome', 'mengatasi'],
        ['pay', 'paid', 'paid', 'membayar'],
        ['put', 'put', 'put', 'meletakkan'],
        ['quit', 'quit', 'quit', 'berhenti'],
        ['read', 'read', 'read', 'membaca'],
        ['ride', 'rode', 'ridden', 'mengendarai'],
        ['ring', 'rang', 'rung', 'berdering'],
        ['rise', 'rose', 'risen', 'terbit'],
        ['run', 'ran', 'run', 'lari'],
        ['saw', 'sawed', 'sawn/sawed', 'menggergaji'],
        ['say', 'said', 'said', 'berkata'],
        ['see', 'saw', 'seen', 'melihat'],
        ['seek', 'sought', 'sought', 'mencari'],
        ['sell', 'sold', 'sold', 'menjual'],
        ['send', 'sent', 'sent', 'mengirim'],
        ['set', 'set', 'set', 'mengatur'],
        ['sew', 'sewed', 'sewn/sewed', 'menjahit'],
        ['shake', 'shook', 'shaken', 'mengguncang'],
        ['shed', 'shed', 'shed', 'menumpahkan'],
        ['shine', 'shone', 'shone', 'bersinar'],
        ['shoot', 'shot', 'shot', 'menembak'],
        ['show', 'showed', 'shown', 'menunjukkan'],
        ['shrink', 'shrank', 'shrunk', 'menyusut'],
        ['shut', 'shut', 'shut', 'menutup'],
        ['sing', 'sang', 'sung', 'bernyanyi'],
        ['sink', 'sank', 'sunk', 'tenggelam'],
        ['sit', 'sat', 'sat', 'duduk'],
        ['sleep', 'slept', 'slept', 'tidur'],
        ['slide', 'slid', 'slid', 'meluncur'],
        ['smell', 'smelt/smelled', 'smelt/smelled', 'mencium bau'],
        ['sow', 'sowed', 'sown/sowed', 'menabur'],
        ['speak', 'spoke', 'spoken', 'berbicara'],
        ['spell', 'spelt/spelled', 'spelt/spelled', 'mengeja'],
        ['spend', 'spent', 'spent', 'menghabiskan'],
        ['spill', 'spilt/spilled', 'spilt/spilled', 'menumpahkan'],
        ['spin', 'spun', 'spun', 'memutar'],
        ['spit', 'spat', 'spat', 'meludah'],
        ['split', 'split', 'split', 'membelah'],
        ['spread', 'spread', 'spread', 'menyebar'],
        ['spring', 'sprang', 'sprung', 'meloncat'],
        ['stand', 'stood', 'stood', 'berdiri'],
        ['steal', 'stole', 'stolen', 'mencuri'],
        ['stick', 'stuck', 'stuck', 'menempel'],
        ['sting', 'stung', 'stung', 'menyengat'],
        ['stink', 'stank', 'stunk', 'berbau busuk'],
        ['strike', 'struck', 'struck', 'memukul'],
        ['strive', 'strove', 'striven', 'berjuang'],
        ['swear', 'swore', 'sworn', 'bersumpah'],
        ['sweep', 'swept', 'swept', 'menyapu'],
        ['swim', 'swam', 'swum', 'berenang'],
        ['swing', 'swung', 'swung', 'mengayun'],
        ['take', 'took', 'taken', 'mengambil'],
        ['teach', 'taught', 'taught', 'mengajar'],
        ['tear', 'tore', 'torn', 'merobek'],
        ['tell', 'told', 'told', 'menceritakan'],
        ['think', 'thought', 'thought', 'berpikir'],
        ['throw', 'threw', 'thrown', 'melempar'],
        ['thrust', 'thrust', 'thrust', 'mendorong'],
        ['tread', 'trod', 'trodden', 'menginjak'],
        ['understand', 'understood', 'understood', 'mengerti'],
        ['wake', 'woke', 'woken', 'bangun'],
        ['wear', 'wore', 'worn', 'memakai'],
        ['weave', 'wove', 'woven', 'menenun'],
        ['weep', 'wept', 'wept', 'menangis'],
        ['win', 'won', 'won', 'menang'],
        ['wind', 'wound', 'wound', 'memutar'],
        ['withdraw', 'withdrew', 'withdrawn', 'menarik'],
        ['wring', 'wrung', 'wrung', 'memeras'],
        ['write', 'wrote', 'written', 'menulis']
    ],
    get filteredVerbs() {
        if (!this.searchQuery.trim()) {
            return this.verbs;
        }
        const query = this.searchQuery.toLowerCase();
        return this.verbs.filter(verb => 
            verb[0].toLowerCase().includes(query) || // V1
            verb[1].toLowerCase().includes(query) || // V2
            verb[2].toLowerCase().includes(query) || // V3
            verb[3].toLowerCase().includes(query)    // Indonesian
        );
    },
    init() {
        // Ensure it stays on screen on resize (optional simple check)
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
            this.searchQuery = ''; // Reset search when opening
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
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2 cursor-move">
       Irregular Verbs
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
            <div class="p-6 border-b border-gray-100 bg-yellow-50">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Daftar Irregular Verbs</h3>
                    <!-- DEBUG: Search box version 2.0 loaded at 18:19:10 -->

                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Search Input -->
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        placeholder="Cari verb (V1, V2, V3, atau arti)..."
                        class="w-full px-4 py-2 pl-10 pr-10 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
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
                
                <!-- Result Count -->
                <div class="mt-2 text-sm text-gray-600" x-show="searchQuery">
                    <span x-text="filteredVerbs.length"></span> hasil ditemukan
                </div>
            </div>

           <!-- Table Container -->
           <div class="overflow-y-auto overflow-x-auto px-3 sm:px-6 pb-3 sm:pb-6" style="max-height: 60vh;">
               <table class="w-full text-xs sm:text-sm text-left border-collapse">
                   <thead class="text-white sticky top-0 z-10">
                       <tr>
                           <th class="hidden sm:table-cell p-2 sm:p-3 border border-yellow-600 bg-yellow-500 sticky top-0 z-10 shadow-md">No.</th>
                           <th class="p-2 sm:p-3 border border-yellow-600 bg-yellow-500 sticky top-0 z-10 shadow-md">Base (V1)</th>
                           <th class="p-2 sm:p-3 border border-yellow-600 bg-yellow-500 sticky top-0 z-10 shadow-md">Past (V2)</th>
                           <th class="p-2 sm:p-3 border border-yellow-600 bg-yellow-500 sticky top-0 z-10 shadow-md">Participle (V3)</th>
                           <th class="p-2 sm:p-3 border border-yellow-600 bg-yellow-500 sticky top-0 z-10 shadow-md">Arti</th>
                       </tr>
                   </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(verb, index) in filteredVerbs" :key="index">
                            <tr class="odd:bg-white even:bg-yellow-50 hover:bg-yellow-100 transition-colors">
                                <td class="hidden sm:table-cell p-2 sm:p-3 border border-gray-200 text-center text-gray-500" x-text="index + 1"></td>
                                <td class="p-2 sm:p-3 border border-gray-200 font-medium text-gray-800" x-text="verb[0]"></td>
                                <td class="p-2 sm:p-3 border border-gray-200 text-gray-700" x-text="verb[1]"></td>
                                <td class="p-2 sm:p-3 border border-gray-200 text-gray-700" x-text="verb[2]"></td>
                                <td class="p-2 sm:p-3 border border-gray-200 text-gray-600 italic" x-text="verb[3]"></td>
                            </tr>
                        </template>
                        
                        <!-- No Results Message -->
                        <tr x-show="filteredVerbs.length === 0">
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="font-medium">Tidak ada hasil ditemukan</p>
                                <p class="text-sm mt-1">Coba kata kunci lain</p>
                            </td>
                        </tr>
                    </tbody>
               </table>
           </div>

            <!-- Footer Note -->
            <div class="p-4 bg-yellow-50 border-t border-yellow-100 text-center">
                <p class="text-sm text-gray-700 font-medium">
                    💡 Jika verb tidak ada di daftar maka tambah <span class="font-bold text-yellow-600">-ed</span> di akhir untuk Verb 2 dan Verb 3
                </p>
            </div>
        </div>
    </div>
</div>
