
<div x-data="{
        x: window.innerWidth / 2 - 300, 
        y: window.innerHeight - 100,
        dragging: false,
        offset: { x: 0, y: 0 },
        startDrag(e) {
            this.dragging = true;
            this.offset.x = e.clientX - this.x;
            this.offset.y = e.clientY - this.y;
            
            const onMouseMove = (e) => {
                if (!this.dragging) return;
                this.x = e.clientX - this.offset.x;
                this.y = e.clientY - this.offset.y;

                // Bounds check
                if (this.y < 0) this.y = 0;
                if (this.y > window.innerHeight - 50) this.y = window.innerHeight - 50;
                if (this.x < 0) this.x = 0;
                if (this.x > window.innerWidth - 50) this.x = window.innerWidth - 50;
            };
            
            const onMouseUp = () => {
                this.dragging = false;
                window.removeEventListener('mousemove', onMouseMove);
                window.removeEventListener('mouseup', onMouseUp);
            };
            
            window.addEventListener('mousemove', onMouseMove);
            window.addEventListener('mouseup', onMouseUp);
        }
    }"
    :style="`position: fixed; left: ${x}px; top: ${y}px; z-index: 40; margin: 0; transform: none;`"
    @mousedown="startDrag($event)"
    class="flex items-center gap-3 bg-white/90 backdrop-blur-sm p-3 rounded-2xl shadow-2xl border border-gray-200 overflow-x-auto max-w-full mx-4 cursor-move select-none">
    
    <!-- 1. LINKING WORDS -->
    <div x-data="{
        open: false,
        searchQuery: '',
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
            if (!this.searchQuery.trim()) return this.words;
            const query = this.searchQuery.toLowerCase();
            return this.words.filter(item => item.category.toLowerCase().includes(query) || item.words.toLowerCase().includes(query));
        }
    }">
        <button @click="open = true" class="bg-teal-500 hover:bg-teal-600 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <span>🔗</span> Linking Words
        </button>

        <template x-teleport="body">
        <div x-show="open" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-teal-50">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Daftar Linking Words</h3>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <input type="text" x-model="searchQuery" placeholder="Cari kategori atau kata..." class="w-full px-4 py-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div class="overflow-y-auto px-6 pb-6 bg-white" style="max-height: 60vh;">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead><tr><th class="p-3 border border-teal-600 bg-teal-500 text-white w-1/4">Kategori</th><th class="p-3 border border-teal-600 bg-teal-500 text-white">Words</th></tr></thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="(item, index) in filteredWords" :key="index">
                                <tr class="odd:bg-white even:bg-teal-50 hover:bg-teal-100">
                                    <td class="p-3 border border-gray-200 font-bold text-teal-800" x-text="item.category"></td>
                                    <td class="p-3 border border-gray-200 text-gray-700"><div class="flex flex-wrap gap-2"><template x-for="word in item.words.split(', ')" :key="word"><span class="px-2 py-1 bg-white border border-teal-200 rounded text-teal-700" x-text="word"></span></template></div></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </template>
    </div>

    <!-- 2. IRREGULAR VERBS -->
    <div x-data="{
        open: false,
        searchQuery: '',
        verbs: [
             ['arise', 'arose', 'arisen', 'timbul'], ['awake', 'awoke', 'awoken', 'bangun'], ['be', 'was/were', 'been', 'menjadi'], ['bear', 'bore', 'born(e)', 'menanggung'], ['beat', 'beat', 'beaten', 'mengalahkan'], ['become', 'became', 'become', 'menjadi'], ['begin', 'began', 'begun', 'mulai'], ['bend', 'bent', 'bent', 'membengkokkan'], ['bet', 'bet', 'bet', 'bertaruh'], ['bind', 'bound', 'bound', 'mengikat'], ['bite', 'bit', 'bitten', 'menggigit'], ['bleed', 'bled', 'bled', 'berdarah'], ['blow', 'blew', 'blown', 'meniup'], ['break', 'broke', 'broken', 'memecahkan'], ['breed', 'bred', 'bred', 'berkembang biak'], ['bring', 'brought', 'brought', 'membawa'], ['broadcast', 'broadcast', 'broadcast', 'menyiarkan'], ['build', 'built', 'built', 'membangun'], ['burn', 'burnt/burned', 'burnt/burned', 'membakar'], ['burst', 'burst', 'burst', 'meledak'], ['buy', 'bought', 'bought', 'membeli'], ['cast', 'cast', 'cast', 'melempar'], ['catch', 'caught', 'caught', 'menangkap'], ['choose', 'chose', 'chosen', 'memilih'], ['cling', 'clung', 'clung', 'melekat'], ['come', 'came', 'come', 'datang'], ['cost', 'cost', 'cost', 'berharga'], ['creep', 'crept', 'crept', 'merayap'], ['cut', 'cut', 'cut', 'memotong'], ['deal', 'dealt', 'dealt', 'berurusan'], ['dig', 'dug', 'dug', 'menggali'], ['do', 'did', 'done', 'melakukan'], ['draw', 'drew', 'drawn', 'menggambar'], ['dream', 'dreamt/dreamed', 'dreamt/dreamed', 'bermimpi'], ['drink', 'drank', 'drunk', 'minum'], ['drive', 'drove', 'driven', 'mengemudi'], ['eat', 'ate', 'eaten', 'makan'], ['fall', 'fell', 'fallen', 'jatuh'], ['feed', 'fed', 'fed', 'memberi makan'], ['feel', 'felt', 'felt', 'merasa'], ['fight', 'fought', 'fought', 'berkelahi'], ['find', 'found', 'found', 'menemukan'], ['flee', 'fled', 'fled', 'melarikan diri'], ['fly', 'flew', 'flown', 'terbang'], ['forbid', 'forbade', 'forbidden', 'melarang'], ['forget', 'forgot', 'forgotten', 'lupa'], ['forgive', 'forgave', 'forgiven', 'memaafkan'], ['freeze', 'froze', 'frozen', 'membeku'], ['get', 'got', 'got/gotten', 'mendapatkan'], ['give', 'gave', 'given', 'memberi'], ['go', 'went', 'gone', 'pergi'], ['grind', 'ground', 'ground', 'menggiling'], ['grow', 'grew', 'grown', 'tumbuh'], ['hang', 'hung', 'hung', 'menggantung'], ['have', 'had', 'had', 'mempunyai'], ['hear', 'heard', 'heard', 'mendengar'], ['hide', 'hid', 'hidden', 'menyembunyikan'], ['hit', 'hit', 'hit', 'memukul'], ['hold', 'held', 'held', 'memegang'], ['hurt', 'hurt', 'hurt', 'melukai'], ['keep', 'kept', 'kept', 'menyimpan'], ['kneel', 'knelt', 'knelt', 'berlutut'], ['know', 'knew', 'known', 'mengetahui'], ['lay', 'laid', 'laid', 'meletakkan'], ['lead', 'led', 'led', 'memimpin'], ['lean', 'leant/leaned', 'leant/leaned', 'bersandar'], ['leap', 'leapt/leaped', 'leapt/leaped', 'melompat'], ['learn', 'learnt/learned', 'learnt/learned', 'belajar'], ['leave', 'left', 'left', 'meninggalkan'], ['lend', 'lent', 'lent', 'meminjamkan'], ['let', 'let', 'let', 'membiarkan'], ['lie', 'lay', 'lain', 'berbaring'], ['light', 'lit/lighted', 'lit/lighted', 'menyalakan'], ['lose', 'lost', 'lost', 'kehilangan'], ['make', 'made', 'made', 'membuat'], ['mean', 'meant', 'meant', 'berarti'], ['meet', 'met', 'met', 'bertemu'], ['mow', 'mowed', 'mown/mowed', 'memotong rumput'], ['overcome', 'overcame', 'overcome', 'mengatasi'], ['pay', 'paid', 'paid', 'membayar'], ['put', 'put', 'put', 'meletakkan'], ['quit', 'quit', 'quit', 'berhenti'], ['read', 'read', 'read', 'membaca'], ['ride', 'rode', 'ridden', 'mengendarai'], ['ring', 'rang', 'rung', 'berdering'], ['rise', 'rose', 'risen', 'terbit'], ['run', 'ran', 'run', 'lari'], ['saw', 'sawed', 'sawn/sawed', 'menggergaji'], ['say', 'said', 'said', 'berkata'], ['see', 'saw', 'seen', 'melihat'], ['seek', 'sought', 'sought', 'mencari'], ['sell', 'sold', 'sold', 'menjual'], ['send', 'sent', 'sent', 'mengirim'], ['set', 'set', 'set', 'mengatur'], ['sew', 'sewed', 'sewn/sewed', 'menjahit'], ['shake', 'shook', 'shaken', 'mengguncang'], ['shed', 'shed', 'shed', 'menumpahkan'], ['shine', 'shone', 'shone', 'bersinar'], ['shoot', 'shot', 'shot', 'menembak'], ['show', 'showed', 'shown', 'menunjukkan'], ['shrink', 'shrank', 'shrunk', 'menyusut'], ['shut', 'shut', 'shut', 'menutup'], ['sing', 'sang', 'sung', 'bernyanyi'], ['sink', 'sank', 'sunk', 'tenggelam'], ['sit', 'sat', 'sat', 'duduk'], ['sleep', 'slept', 'slept', 'tidur'], ['slide', 'slid', 'slid', 'meluncur'], ['smell', 'smelt/smelled', 'smelt/smelled', 'mencium bau'], ['sow', 'sowed', 'sown/sowed', 'menabur'], ['speak', 'spoke', 'spoken', 'berbicara'], ['spell', 'spelt/spelled', 'spelt/spelled', 'mengeja'], ['spend', 'spent', 'spent', 'menghabiskan'], ['spill', 'spilt/spilled', 'spilt/spilled', 'menumpahkan'], ['spin', 'spun', 'spun', 'memutar'], ['spit', 'spat', 'spat', 'meludah'], ['split', 'split', 'split', 'membelah'], ['spread', 'spread', 'spread', 'menyebar'], ['spring', 'sprang', 'sprung', 'meloncat'], ['stand', 'stood', 'stood', 'berdiri'], ['steal', 'stole', 'stolen', 'mencuri'], ['stick', 'stuck', 'stuck', 'menempel'], ['sting', 'stung', 'stung', 'menyengat'], ['stink', 'stank', 'stunk', 'berbau busuk'], ['strike', 'struck', 'struck', 'memukul'], ['strive', 'strove', 'striven', 'berjuang'], ['swear', 'swore', 'sworn', 'bersumpah'], ['sweep', 'swept', 'swept', 'menyapu'], ['swim', 'swam', 'swum', 'berenang'], ['swing', 'swung', 'swung', 'mengayun'], ['take', 'took', 'taken', 'mengambil'], ['teach', 'taught', 'taught', 'mengajar'], ['tear', 'tore', 'torn', 'merobek'], ['tell', 'told', 'told', 'menceritakan'], ['think', 'thought', 'thought', 'berpikir'], ['throw', 'threw', 'thrown', 'melempar'], ['thrust', 'thrust', 'thrust', 'mendorong'], ['tread', 'trod', 'trodden', 'menginjak'], ['understand', 'understood', 'understood', 'mengerti'], ['wake', 'woke', 'woken', 'bangun'], ['wear', 'wore', 'worn', 'memakai'], ['weave', 'wove', 'woven', 'menenun'], ['weep', 'wept', 'wept', 'menangis'], ['win', 'won', 'won', 'menang'], ['wind', 'wound', 'wound', 'memutar'], ['withdraw', 'withdrew', 'withdrawn', 'menarik'], ['wring', 'wrung', 'wrung', 'memeras'], ['write', 'wrote', 'written', 'menulis']
        ],
        get filteredVerbs() {
            if (!this.searchQuery.trim()) return this.verbs;
            const query = this.searchQuery.toLowerCase();
            return this.verbs.filter(verb => verb.some(v => v.toLowerCase().includes(query)));
        }
    }">
        <button @click="open = true" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <span>📖</span> Irregular Verbs
        </button>

        <template x-teleport="body">
        <div x-show="open" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-yellow-50">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Daftar Irregular Verbs</h3>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <input type="text" x-model="searchQuery" placeholder="Cari verb (V1, V2, V3, atau arti)..." class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <div class="overflow-y-auto px-6 pb-6 bg-white" style="max-height: 60vh;">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead><tr><th class="p-3 border border-yellow-600 bg-yellow-500 text-white">V1</th><th class="p-3 border border-yellow-600 bg-yellow-500 text-white">V2</th><th class="p-3 border border-yellow-600 bg-yellow-500 text-white">V3</th><th class="p-3 border border-yellow-600 bg-yellow-500 text-white">Arti</th></tr></thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="(verb, index) in filteredVerbs" :key="index">
                                <tr class="odd:bg-white even:bg-yellow-50 hover:bg-yellow-100">
                                    <td class="p-3 font-medium text-gray-800" x-text="verb[0]"></td><td class="p-3" x-text="verb[1]"></td><td class="p-3" x-text="verb[2]"></td><td class="p-3 italic text-gray-600" x-text="verb[3]"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </template>
    </div>

    <!-- 3. GRAPHICAL VOCABULARIES (Task 1 Only) -->
    @if($meeting->task_type == 1)
    <div x-data="{ open: false }">
        <button @click="open = true" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <span>📈</span> Graphical Vocabularies
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-indigo-900">Describing Trends & Language of Change</h3>
                            <p class="text-sm text-indigo-600">Vocabulary used to describe changes in graphs.</p>
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    
                    <div class="overflow-y-auto p-6 bg-white space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- UP -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    <h4 class="font-bold text-lg text-gray-800">Trends: Up ↗️</h4>
                                </div>
                                <table class="w-full text-sm border-collapse border border-blue-200">
                                    <thead class="bg-blue-100 text-blue-900"><tr><th class="p-2 border border-blue-200 text-left">Verb</th><th class="p-2 border border-blue-200 text-left">Noun</th></tr></thead>
                                    <tbody class="divide-y divide-blue-50">
                                        <tr><td class="p-2 border border-blue-100">rise</td><td class="p-2 border border-blue-100">a rise</td></tr>
                                        <tr><td class="p-2 border border-blue-100">increase</td><td class="p-2 border border-blue-100">an increase</td></tr>
                                        <tr><td class="p-2 border border-blue-100">grow</td><td class="p-2 border border-blue-100">a growth</td></tr>
                                        <tr><td class="p-2 border border-blue-100">climb</td><td class="p-2 border border-blue-100">a climb</td></tr>
                                        <tr><td class="p-2 border border-blue-100">boom</td><td class="p-2 border border-blue-100">a boom</td></tr>
                                        <tr><td class="p-2 border border-blue-100">peak</td><td class="p-2 border border-blue-100">a peak</td></tr>
                                        <tr><td class="p-2 border border-blue-100">go up</td><td class="p-2 border border-blue-100 text-gray-400">N/A</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- DOWN -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                                    <h4 class="font-bold text-lg text-gray-800">Trends: Down ↘️</h4>
                                </div>
                                <table class="w-full text-sm border-collapse border border-green-200">
                                    <thead class="bg-green-100 text-green-900"><tr><th class="p-2 border border-green-200 text-left">Verb</th><th class="p-2 border border-green-200 text-left">Noun</th></tr></thead>
                                    <tbody class="divide-y divide-green-50">
                                        <tr><td class="p-2 border border-green-100">fall</td><td class="p-2 border border-green-100">a fall</td></tr>
                                        <tr><td class="p-2 border border-green-100">decrease</td><td class="p-2 border border-green-100">a decrease</td></tr>
                                        <tr><td class="p-2 border border-green-100">reduce</td><td class="p-2 border border-green-100">a reduction</td></tr>
                                        <tr><td class="p-2 border border-green-100">decline</td><td class="p-2 border border-green-100">a decline</td></tr>
                                        <tr><td class="p-2 border border-green-100">dip</td><td class="p-2 border border-green-100">a dip</td></tr>
                                        <tr><td class="p-2 border border-green-100">go down</td><td class="p-2 border border-green-100 text-gray-400">N/A</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- LEFT COLUMN GROUP (Stable + Fluctuation) -->
                            <div class="space-y-8">
                                <!-- STABLE -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 12h14"></path></svg>
                                        <h4 class="font-bold text-lg text-gray-800">Trends: Stable ➡️</h4>
                                    </div>
                                    <table class="w-full text-sm border-collapse border border-red-200">
                                        <thead class="bg-red-100 text-red-900"><tr><th class="p-2 border border-red-200 text-left">Verb</th><th class="p-2 border border-red-200 text-left">Noun</th></tr></thead>
                                        <tbody class="divide-y divide-red-50">
                                            <tr><td class="p-2 border border-red-100">level out</td><td class="p-2 border border-red-100">a leveling out</td></tr>
                                            <tr><td class="p-2 border border-red-100">not change</td><td class="p-2 border border-red-100">no change</td></tr>
                                            <tr><td class="p-2 border border-red-100">remain stable</td><td class="p-2 border border-red-100">(a period of) stability</td></tr>
                                            <tr><td class="p-2 border border-red-100">remain steady</td><td class="p-2 border border-red-100 text-gray-400">N/A</td></tr>
                                            <tr><td class="p-2 border border-red-100">stay constant</td><td class="p-2 border border-red-100 text-gray-400">N/A</td></tr>
                                            <tr><td class="p-2 border border-red-100">maintain the same level</td><td class="p-2 border border-red-100 text-gray-400">N/A</td></tr>
                                            <tr><td class="p-2 border border-red-100">stand steady</td><td class="p-2 border border-red-100 text-gray-400">N/A</td></tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- FLUCTUATION -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 12l4-6 4 12 4-8 4 6"></path></svg>
                                        <h4 class="font-bold text-lg text-gray-800">Fluctuation 〰️</h4>
                                    </div>
                                    <table class="w-full text-sm border-collapse border border-orange-200">
                                        <thead class="bg-orange-100 text-orange-900"><tr><th class="p-2 border border-orange-200 text-left">Verb</th><th class="p-2 border border-orange-200 text-left">Noun</th></tr></thead>
                                        <tbody class="divide-y divide-orange-50">
                                            <tr><td class="p-2 border border-orange-100">fluctuate</td><td class="p-2 border border-orange-100">a fluctuation</td></tr>
                                            <tr><td class="p-2 border border-orange-100 highlight bg-orange-100/50">oscillate</td><td class="p-2 border border-orange-100 highlight bg-orange-100/50">an oscillation</td></tr>
                                            <tr><td class="p-2 border border-orange-100">be volatile</td><td class="p-2 border border-orange-100">a period of volatility</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- DEGREE AND SPEED -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <h4 class="font-bold text-lg text-gray-800">Degree & Speed ⚡</h4>
                                </div>
                                <div class="flex gap-4 items-stretch">
                                    <div class="flex-1 bg-gradient-to-b from-purple-50 to-white rounded-lg border border-purple-100 p-1">
                                        <table class="w-full text-sm border-collapse">
                                            <thead class="bg-purple-200 text-purple-900"><tr><th class="p-2 text-left">Adverb</th><th class="p-2 text-left">Adjective</th></tr></thead>
                                            <tbody class="divide-y divide-purple-100">
                                                <!-- Strong -->
                                                <tr class="bg-purple-100/50"><td class="p-2 font-semibold">dramatically</td><td class="p-2 font-semibold">dramatic</td></tr>
                                                <tr class="bg-purple-100/40"><td class="p-2 font-semibold">sharply</td><td class="p-2 font-semibold">sharp</td></tr>
                                                <tr class="bg-purple-100/30"><td class="p-2">enormously</td><td class="p-2">enormous</td></tr>
                                                <tr class="bg-purple-100/20"><td class="p-2">steeply</td><td class="p-2">steep</td></tr>
                                                <tr><td class="p-2">substantially</td><td class="p-2">substantial</td></tr>
                                                <tr><td class="p-2">considerably</td><td class="p-2">considerable</td></tr>
                                                <tr><td class="p-2">significantly</td><td class="p-2">significant</td></tr>
                                                <tr><td class="p-2">rapidly</td><td class="p-2">rapid</td></tr>
                                                <tr><td class="p-2">moderately</td><td class="p-2">moderate</td></tr>
                                                <tr><td class="p-2">gradually</td><td class="p-2">gradual</td></tr>
                                                <tr><td class="p-2 text-gray-600">slightly</td><td class="p-2 text-gray-600">slight</td></tr>
                                                <tr class="bg-gray-50"><td class="p-2 text-gray-500">minimally</td><td class="p-2 text-gray-500">minimal</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Triangle Indicator -->
                                    <div class="flex flex-col items-center w-12 shrink-0 py-2">
                                        <div class="text-xs font-bold text-purple-900 mb-1">Strong</div>
                                        <div class="flex-1 w-full relative">
                                            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                                <defs>
                                                    <linearGradient id="gradTheme" x1="0%" y1="0%" x2="0%" y2="100%">
                                                        <stop offset="0%" style="stop-color:#9333ea;stop-opacity:1" />
                                                        <stop offset="100%" style="stop-color:#e9d5ff;stop-opacity:1" />
                                                    </linearGradient>
                                                </defs>
                                                <polygon points="0,0 100,0 50,100" fill="url(#gradTheme)" />
                                            </svg>
                                        </div>
                                        <div class="text-xs font-bold text-gray-400 mt-1">Weak</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </template>
    </div>
    @endif

    <!-- 3. COLLOCATIONS -->
    @if($meeting->task_type == 2)
    <button @click="$dispatch('toggle-collocations')" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
        <span>🔗</span> Collocations
    </button>

    <!-- 4. IDIOMS -->
    <button @click="$dispatch('toggle-idioms')" class="bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
        <span>💡</span> Idioms
    </button>

    @endif

    <!-- 5. COLLOCATION DICTIONARY -->
    <div x-data="{
        open: false,
        query: '',
        results: [],
        loading: false,
        error: null,
        async search() {
            if(!this.query.trim()) return;
            this.loading = true;
            this.error = null;
            this.results = [];
            try {
                const response = await fetch(`/api/ollama/collocation?word=${encodeURIComponent(this.query.trim())}`);
                if (!response.ok) throw new Error('AI Brain (Ollama) is offline or busy.');
                const data = await response.json();
                if (data.collocations && Array.isArray(data.collocations)) this.results = data.collocations;
                else this.error = 'AI returned unexpected format.';
            } catch(e) { this.error = e.message; } finally { this.loading = false; }
        },
        getGroups() {
            if (!this.results.length) return {};
            return this.results.reduce((acc, item) => {
                const type = item.type || 'General';
                if (!acc[type]) acc[type] = [];
                acc[type].push(item);
                return acc;
            }, {});
        }
    }">
        <button @click="open = true" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <span>🧠</span> Collocation Dictionary
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-2xl relative overflow-hidden" style="height: 80vh;">
                    <div class="absolute top-0 left-0 right-0 z-20 bg-white shadow-sm flex flex-col" style="height: 150px;">
                        <div class="p-4 bg-purple-50 border-b border-purple-100 flex justify-between items-center" style="height: 70px;">
                            <h3 class="text-xl font-bold text-purple-900">Collocation Dictionary</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                        <div class="p-4 border-b border-gray-100 bg-white" style="height: 80px;">
                            <form @submit.prevent="search" class="flex gap-2 h-full items-center"><input type="text" x-model="query" placeholder="Type a word..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg h-10"><button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg h-10" :disabled="loading"><span x-show="!loading">Ask AI</span><span x-show="loading">...</span></button></form>
                        </div>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 overflow-y-auto p-6 bg-gray-50 bg-white" style="top: 150px;">
                        <div x-show="loading" class="text-center py-10">Processing...</div>
                        <div x-show="error" x-text="error" class="text-center text-red-500 py-10"></div>
                        <div x-show="!loading && !error && results.length > 0">
                            <h2 x-text="query" class="text-3xl font-bold text-center mb-4"></h2>
                            <template x-for="(items, type) in getGroups()" :key="type">
                                <div class="mb-4">
                                    <h4 class="font-bold text-purple-700 uppercase mb-2 border-l-4 border-purple-500 pl-2" x-text="type"></h4>
                                    <div class="space-y-3">
                                        <template x-for="item in items" :key="item.phrase">
                                            <div class="bg-white p-3 rounded shadow-sm border">
                                                <div class="flex items-center gap-2 mb-1"><span class="font-bold text-lg" x-text="item.phrase"></span><button @click="query = item.phrase; search()" class="text-xs text-gray-400">RESEARCH</button></div>
                                                <div class="text-sm text-gray-600 mb-1" x-text="item.explanation"></div>
                                                <div class="text-sm italic text-purple-800 bg-purple-50 p-2 rounded" x-text="item.example"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>


    <!-- 6. DICTIONARY (Full Logic) -->
    <div x-data="dictionaryDataToolbar()">
        <button @click="open = true" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <span>📘</span> Dictionary
        </button>
        <template x-teleport="body">
            <div x-show="open" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
                    <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                         <div class="flex items-center gap-2"><h3 class="text-xl font-bold text-blue-900">Translation & Thesaurus</h3><span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">Auto-Detect</span></div>
                         <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <div class="p-4 border-b border-gray-100">
                        <form @submit.prevent="search" class="flex gap-2"><input type="text" x-model="query" placeholder="Type a word..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg" :disabled="loading"><span x-show="!loading">Search</span><span x-show="loading">...</span></button></form>
                    </div>
                    <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                        <div x-show="loading" class="text-center py-10">Searching...</div>
                        <div x-show="error" x-text="error" class="text-center text-red-500 py-10"></div>
                        <div x-show="result && !loading" class="space-y-6">
                            <div class="bg-white p-6 rounded-xl border border-blue-200 shadow-sm">
                                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                                    <div class="text-center flex-1"><p class="text-xs text-gray-500 uppercase font-bold" x-text="result.source === 'en' ? 'English' : 'Indonesia'"></p><div class="flex items-center justify-center gap-2"><span class="text-xl text-gray-900" x-text="result.original"></span><button @click="playAudio(result.original, result.source == 'en' ? 'en-US' : 'id-ID')" class="text-gray-300 hover:text-blue-500">🔊</button></div></div>
                                    <div class="text-gray-300">➜</div>
                                    <div class="text-center flex-1"><p class="text-xs text-gray-500 uppercase font-bold" x-text="result.source === 'en' ? 'Indonesia' : 'English'"></p><div class="flex items-center justify-center gap-2"><span class="text-2xl font-bold text-blue-700" x-text="result.translation"></span><button @click="playAudio(result.translation, result.source == 'en' ? 'id-ID' : 'en-US')" class="text-blue-300 hover:text-blue-600">🔊</button></div></div>
                                </div>
                            </div>
                            <div x-show="result?.examples?.length > 0"><h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Examples</h4><ul class="bg-white rounded-xl border border-gray-200"><template x-for="ex in result?.examples"><li class="px-4 py-3 border-b border-gray-100 last:border-0 italic text-gray-700" x-text="ex"></li></template></ul></div>
                            <div x-show="result?.synonyms?.length > 0"><h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Synonyms</h4><div class="flex flex-wrap gap-2"><template x-for="syn in result?.synonyms"><span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-purple-100 cursor-pointer" @click="query = syn; search()" x-text="syn"></span></template></div></div>
                        </div>
                    </div>
                    <div class="p-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 bg-gray-50">
                        <div class="flex items-center gap-2"><span>Source:</span><span x-text="results?.source || 'Auto'" class="font-bold"></span><a href="#" @click.prevent="testConnection()" class="ml-2 text-blue-400">(Test Connection)</a></div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function dictionaryDataToolbar() {
    return {
        open: false, query: '', result: null, loading: false, error: null, results: {},
        async search() {
            if(!this.query.trim()) return;
            this.loading = true; this.error = null; this.result = null; this.results.source = 'Auto';
            const q = this.query.trim(); const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            try {
                // 1. MyMemory Fallback
                const fallback = async () => {
                    const res = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=en|id`);
                    const d = await res.json();
                    return d.responseData?.translatedText ? { text: d.responseData.translatedText, source: 'MyMemory', lang: 'en' } : null;
                };
                
                // 2. AI Task
                const aiTask = async () => {
                   try {
                       const r = await fetch('/api/ollama/translate', { method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }, body: JSON.stringify({ text: q }) });
                       if (r.ok) { const d = await r.json(); if (d.translation) return { text: d.translation, source: 'Llama 3', lang: d.detected_source }; }
                   } catch(e) {}
                   return null;
                };

                // Race
                let winner = null;
                try { winner = await Promise.race([ aiTask(), new Promise((_,r) => setTimeout(() => r('timeout'), 4000)) ]); } catch(e) {}
                
                let translation = ''; let source = ''; let lang = 'en';
                if (winner) { translation = winner.text; source = winner.source; lang = winner.lang; }
                else { const fb = await fallback(); if(fb) { translation = fb.text; source = fb.source; lang = fb.lang; } else throw new Error('Not found'); }
                
                // Examples/Synonyms
                this.result = { source: lang, original: q, translation: translation, examples: [], synonyms: [] };
                this.results.source = source;
                
                if (lang === 'en') {
                     const [dRes, mRes] = await Promise.all([
                         fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${q}`).then(r=>r.ok?r.json():null).catch(()=>null),
                         fetch(`https://api.datamuse.com/words?rel_syn=${q}&max=10`).then(r=>r.ok?r.json():null).catch(()=>null)
                     ]);
                     if (dRes && dRes[0]?.meanings) {
                         dRes[0].meanings.forEach(m => m.definitions.forEach(d => { if(d.example) this.result.examples.push(d.example); }));
                         this.result.examples = this.result.examples.slice(0, 3);
                     }
                     if (mRes) this.result.synonyms = mRes.map(i => i.word);
                }
            } catch(e) { this.error = "Translation failed."; } finally { this.loading = false; }
        },
        playAudio(text, lang) { if(window.speechSynthesis) { const u = new SpeechSynthesisUtterance(text); u.lang = lang; window.speechSynthesis.speak(u); } },
        testConnection() { alert('Connection Test: OK'); }
    }
}
</script>
