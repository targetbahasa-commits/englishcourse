<style>
@keyframes glow-spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); opacity: 0; }
    2% { opacity: 1; }
    8% { opacity: 1; }
    10% { transform: translate(-50%, -50%) rotate(360deg); opacity: 0; }
    100% { transform: translate(-50%, -50%) rotate(360deg); opacity: 0; }
}
.btn-glow-wrapper {
    position: relative;
    overflow: hidden;
    padding: 2px;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
.btn-glow-wrapper::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 250%;
    height: 250%;
    background: conic-gradient(from 0deg, red, orange, yellow, green, cyan, blue, violet, red);
    animation: glow-spin 20s linear infinite;
    z-index: 0;
}
.btn-glow-content {
    position: relative;
    z-index: 1;
    border-radius: 0.4rem;
    width: 100%;
    height: 100%;
}
</style>
<div class="flex items-center gap-2 flex-wrap px-2 py-1 max-w-full">

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
        <button @click="open = true"
            class="bg-orange-600 hover:bg-orange-700 text-white border border-orange-700 text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap" data-tooltip="Kosakata penghubung antar kalimat &amp; paragraf">
            Linking Words
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-slate-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Daftar Linking Words</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                        <input type="text" x-model="searchQuery" placeholder="Cari kategori atau kata..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                    </div>
                    <div class="overflow-y-auto px-6 pb-6 bg-white" style="max-height: 60vh;">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="p-3 border border-gray-400 bg-slate-200 text-slate-800 w-1/4">Kategori
                                    </th>
                                    <th class="p-3 border border-gray-400 bg-slate-200 text-slate-800">Words</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(item, index) in filteredWords" :key="index">
                                    <tr class="odd:bg-white even:bg-slate-50 hover:bg-slate-100">
                                        <td class="p-3 border border-gray-200 font-bold text-slate-800"
                                            x-text="item.category"></td>
                                        <td class="p-3 border border-gray-200 text-gray-700">
                                            <div class="flex flex-wrap gap-2"><template
                                                    x-for="word in item.words.split(', ')" :key="word"><span
                                                        class="px-2 py-1 bg-white border border-gray-200 rounded text-slate-700"
                                                        x-text="word"></span></template></div>
                                        </td>
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
        <button @click="open = true"
            class="bg-pink-600 hover:bg-pink-700 text-white border border-pink-700 text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap" data-tooltip="Daftar kata kerja tak beraturan (V1, V2, V3)">
            Irregular Verbs
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-slate-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Daftar Irregular Verbs</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                        <input type="text" x-model="searchQuery" placeholder="Cari verb (V1, V2, V3, atau arti)..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                    </div>
                    <div class="overflow-y-auto px-6 pb-6 bg-white" style="max-height: 60vh;">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="p-3 border border-gray-400 bg-slate-200 text-slate-800">V1</th>
                                    <th class="p-3 border border-gray-400 bg-slate-200 text-slate-800">V2</th>
                                    <th class="p-3 border border-gray-400 bg-slate-200 text-slate-800">V3</th>
                                    <th class="p-3 border border-gray-400 bg-slate-200 text-slate-800">Arti</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(verb, index) in filteredVerbs" :key="index">
                                    <tr class="odd:bg-white even:bg-slate-50 hover:bg-slate-100">
                                        <td class="p-3 font-medium text-gray-800" x-text="verb[0]"></td>
                                        <td class="p-3" x-text="verb[1]"></td>
                                        <td class="p-3" x-text="verb[2]"></td>
                                        <td class="p-3 italic text-gray-600" x-text="verb[3]"></td>
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
    @if($type === 'writing_t1')
        <div x-data="{ open: false }">
            <button @click="open = true"
                class="bg-gray-700 hover:bg-gray-600 text-white text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap" data-tooltip="Kosakata mendeskripsikan tren pada grafik">
                Describing Trends
            </button>

            <template x-teleport="body">
                <div x-show="open" style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                    <div @click.outside="open = false"
                        class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-slate-100 flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Describing Trends & Language of Change</h3>
                                <p class="text-sm text-slate-500">Vocabulary used to describe changes in graphs.</p>
                            </div>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg
                                    class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>

                        <div class="overflow-y-auto p-6 bg-white space-y-8">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- UP -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-slate-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <h4 class="font-bold text-lg text-gray-800">Trends: Up</h4>
                                    </div>
                                    <table class="w-full text-sm border-collapse border border-gray-200">
                                        <thead class="bg-slate-200 text-slate-800">
                                            <tr>
                                                <th class="p-2 border border-gray-200 text-left">Verb</th>
                                                <th class="p-2 border border-gray-200 text-left">Noun</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <tr>
                                                <td class="p-2 border border-gray-200">rise</td>
                                                <td class="p-2 border border-gray-200">a rise</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">increase</td>
                                                <td class="p-2 border border-gray-200">an increase</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">grow</td>
                                                <td class="p-2 border border-gray-200">a growth</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">climb</td>
                                                <td class="p-2 border border-gray-200">a climb</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">boom</td>
                                                <td class="p-2 border border-gray-200">a boom</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">peak</td>
                                                <td class="p-2 border border-gray-200">a peak</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">go up</td>
                                                <td class="p-2 border border-gray-200 text-gray-400">N/A</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- DOWN -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-slate-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                        </svg>
                                        <h4 class="font-bold text-lg text-gray-800">Trends: Down</h4>
                                    </div>
                                    <table class="w-full text-sm border-collapse border border-gray-200">
                                        <thead class="bg-slate-200 text-slate-800">
                                            <tr>
                                                <th class="p-2 border border-gray-200 text-left">Verb</th>
                                                <th class="p-2 border border-gray-200 text-left">Noun</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <tr>
                                                <td class="p-2 border border-gray-200">fall</td>
                                                <td class="p-2 border border-gray-200">a fall</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">decrease</td>
                                                <td class="p-2 border border-gray-200">a decrease</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">reduce</td>
                                                <td class="p-2 border border-gray-200">a reduction</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">decline</td>
                                                <td class="p-2 border border-gray-200">a decline</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">dip</td>
                                                <td class="p-2 border border-gray-200">a dip</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-gray-200">go down</td>
                                                <td class="p-2 border border-gray-200 text-gray-400">N/A</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- LEFT COLUMN GROUP (Stable + Fluctuation) -->
                                <div class="space-y-8">
                                    <!-- STABLE -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-8 h-8 text-slate-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 12h14"></path>
                                            </svg>
                                            <h4 class="font-bold text-lg text-gray-800">Trends: Stable</h4>
                                        </div>
                                        <table class="w-full text-sm border-collapse border border-gray-200">
                                            <thead class="bg-slate-200 text-slate-800">
                                                <tr>
                                                    <th class="p-2 border border-gray-200 text-left">Verb</th>
                                                    <th class="p-2 border border-gray-200 text-left">Noun</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <tr>
                                                    <td class="p-2 border border-gray-200">level out</td>
                                                    <td class="p-2 border border-gray-200">a leveling out</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200">not change</td>
                                                    <td class="p-2 border border-gray-200">no change</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200">remain stable</td>
                                                    <td class="p-2 border border-gray-200">(a period of) stability</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200">remain steady</td>
                                                    <td class="p-2 border border-gray-200 text-gray-400">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200">stay constant</td>
                                                    <td class="p-2 border border-gray-200 text-gray-400">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200">maintain the same level</td>
                                                    <td class="p-2 border border-gray-200 text-gray-400">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200">stand steady</td>
                                                    <td class="p-2 border border-gray-200 text-gray-400">N/A</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- FLUCTUATION -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-8 h-8 text-slate-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M4 12l4-6 4 12 4-8 4 6"></path>
                                            </svg>
                                            <h4 class="font-bold text-lg text-gray-800">Fluctuation</h4>
                                        </div>
                                        <table class="w-full text-sm border-collapse border border-gray-200">
                                            <thead class="bg-slate-200 text-slate-800">
                                                <tr>
                                                    <th class="p-2 border border-gray-200 text-left">Verb</th>
                                                    <th class="p-2 border border-gray-200 text-left">Noun</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <tr>
                                                    <td class="p-2 border border-gray-200">fluctuate</td>
                                                    <td class="p-2 border border-gray-200">a fluctuation</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 highlight bg-slate-100">oscillate
                                                    </td>
                                                    <td class="p-2 border border-gray-200 highlight bg-slate-100">an
                                                        oscillation</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200">be volatile</td>
                                                    <td class="p-2 border border-gray-200">a period of volatility</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- DEGREE AND SPEED -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <h4 class="font-bold text-lg text-gray-800">Degree & Speed ⚡</h4>
                                    </div>
                                    <div class="flex gap-4 items-stretch">
                                        <div
                                            class="flex-1 bg-gradient-to-b from-slate-50 to-white rounded-lg border border-gray-200 p-1">
                                            <table class="w-full text-sm border-collapse">
                                                <thead class="bg-slate-100 text-slate-800">
                                                    <tr>
                                                        <th class="p-2 text-left">Adverb</th>
                                                        <th class="p-2 text-left">Adjective</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    <!-- Strong -->
                                                    <tr class="bg-rose-50/50 hover:bg-rose-50/80 transition duration-150">
                                                        <td class="p-2 font-semibold text-rose-700">dramatically</td>
                                                        <td class="p-2 font-semibold text-rose-700">dramatic</td>
                                                    </tr>
                                                    <tr class="bg-rose-50/30 hover:bg-rose-50/60 transition duration-150">
                                                        <td class="p-2 font-semibold text-rose-700">sharply</td>
                                                        <td class="p-2 font-semibold text-rose-700">sharp</td>
                                                    </tr>
                                                    <tr class="bg-purple-50/50 hover:bg-purple-50/80 transition duration-150">
                                                        <td class="p-2 font-medium text-purple-700">enormously</td>
                                                        <td class="p-2 font-medium text-purple-700">enormous</td>
                                                    </tr>
                                                    <tr class="bg-purple-50/30 hover:bg-purple-50/60 transition duration-150">
                                                        <td class="p-2 text-purple-700">steeply</td>
                                                        <td class="p-2 text-purple-700">steep</td>
                                                    </tr>
                                                    <tr class="bg-indigo-50/30 hover:bg-indigo-50/60 transition duration-150">
                                                        <td class="p-2 text-indigo-700">substantially</td>
                                                        <td class="p-2 text-indigo-700">substantial</td>
                                                    </tr>
                                                    <tr class="bg-blue-50/50 hover:bg-blue-50/80 transition duration-150">
                                                        <td class="p-2 text-blue-700">considerably</td>
                                                        <td class="p-2 text-blue-700">considerable</td>
                                                    </tr>
                                                    <tr class="bg-blue-50/30 hover:bg-blue-50/60 transition duration-150">
                                                        <td class="p-2 text-blue-700">significantly</td>
                                                        <td class="p-2 text-blue-700">significant</td>
                                                    </tr>
                                                    <tr class="bg-cyan-50/30 hover:bg-cyan-50/60 transition duration-150">
                                                        <td class="p-2 text-cyan-700">rapidly</td>
                                                        <td class="p-2 text-cyan-700">rapid</td>
                                                    </tr>
                                                    <tr class="hover:bg-slate-50/50 transition duration-150">
                                                        <td class="p-2 text-gray-700">moderately</td>
                                                        <td class="p-2 text-gray-700">moderate</td>
                                                    </tr>
                                                    <tr class="hover:bg-slate-50/50 transition duration-150">
                                                        <td class="p-2 text-gray-700">gradually</td>
                                                        <td class="p-2 text-gray-700">gradual</td>
                                                    </tr>
                                                    <tr class="bg-slate-50/50 hover:bg-slate-100/50 transition duration-150">
                                                        <td class="p-2 text-slate-700 font-medium">slightly</td>
                                                        <td class="p-2 text-slate-700 font-medium">slight</td>
                                                    </tr>
                                                    <tr class="bg-slate-100/50 hover:bg-slate-200/50 transition duration-150">
                                                        <td class="p-2 text-slate-700 font-medium">minimally</td>
                                                        <td class="p-2 text-slate-700 font-medium">minimal</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Triangle Indicator -->
                                        <div class="flex flex-col items-center w-12 shrink-0 py-2">
                                            <div class="text-xs font-extrabold text-rose-600 mb-1 uppercase tracking-wider">Strong</div>
                                            <div class="flex-1 w-full relative">
                                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100"
                                                    preserveAspectRatio="none">
                                                    <defs>
                                                        <linearGradient id="gradDegreeSpeedPromo" x1="0%" y1="0%" x2="0%" y2="100%">
                                                            <stop offset="0%" style="stop-color:#f43f5e;stop-opacity:1" />
                                                            <stop offset="50%" style="stop-color:#a855f7;stop-opacity:1" />
                                                            <stop offset="100%" style="stop-color:#06b6d4;stop-opacity:1" />
                                                        </linearGradient>
                                                    </defs>
                                                    <polygon points="0,0 100,0 50,100" fill="url(#gradDegreeSpeedPromo)" />
                                                </svg>
                                            </div>
                                            <div class="text-xs font-extrabold text-cyan-600 mt-1 uppercase tracking-wider">Weak</div>
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

    <!-- 3.5. MAKING COMPARISONS (Task 1 Only) -->
    @if($type === 'writing_t1')
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="bg-gray-600 hover:bg-gray-500 text-white text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap" data-tooltip="Kosakata untuk membandingkan data grafik">
                    Making Comparisons
                </button>

                <template x-teleport="body">
                    <div x-show="open" style="display: none;"
                        class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                        <div @click.outside="open = false"
                            class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
                            <div class="p-6 border-b border-gray-100 bg-slate-100 flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">Making Comparisons</h3>
                                    <p class="text-sm text-slate-500">Vocabulary used to compare data points, contrast
                                        differences, and describe proportions.</p>
                                </div>
                                <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg
                                        class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg></button>
                            </div>

                            <div class="overflow-y-auto p-6 bg-white space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                    <!-- Proportions & Fractions -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-lg text-gray-800">Proportions & Fractions</h4>
                                        </div>
                                        <table class="w-full text-sm border-collapse border border-gray-200">
                                            <thead class="bg-slate-200 text-slate-800">
                                                <tr>
                                                    <th class="p-2 border border-gray-200 text-left">Percentage</th>
                                                    <th class="p-2 border border-gray-200 text-left">Vocabulary</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">75% - 85%</td>
                                                    <td class="p-2 border border-gray-200">A vast majority / A significant
                                                        majority</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">65% - 75%</td>
                                                    <td class="p-2 border border-gray-200">Around three quarters / A large
                                                        proportion</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">50%</td>
                                                    <td class="p-2 border border-gray-200">Exactly half</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">45% - 49%</td>
                                                    <td class="p-2 border border-gray-200">Just under half / Almost half</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">30% - 35%</td>
                                                    <td class="p-2 border border-gray-200">About a third / A third</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">25%</td>
                                                    <td class="p-2 border border-gray-200">Exactly a quarter</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">10% - 15%</td>
                                                    <td class="p-2 border border-gray-200">A small minority / A tiny proportion
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-gray-200 font-bold text-center">1% - 5%</td>
                                                    <td class="p-2 border border-gray-200">A tiny minority / An insignificant
                                                        amount</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="space-y-3">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-lg text-gray-800">Multiples & Times</h4>
                                            </div>
                                            <table class="w-full text-sm border-collapse border border-gray-200">
                                                <thead class="bg-slate-200 text-slate-800">
                                                    <tr>
                                                        <th class="p-2 border border-gray-200 text-left">Pattern</th>
                                                        <th class="p-2 border border-gray-200 text-left">Examples</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">
                                                            Double / Twice</td>
                                                        <td class="p-2 border border-gray-200">A was <b>double</b> that of
                                                            B.<br>A was <b>twice as high as</b> B.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">
                                                            Triple / Three times</td>
                                                        <td class="p-2 border border-gray-200">A <b>tripled</b> over the
                                                            period.<br>A was <b>three times larger than</b> B.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">Four
                                                            / Five times</td>
                                                        <td class="p-2 border border-gray-200">A was <b>four times as much
                                                                as</b> B.<br>It increased <b>five times over</b>.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">
                                                            -fold (Twofold, etc)</td>
                                                        <td class="p-2 border border-gray-200">There was a <b>twofold
                                                                increase</b> in A.<br>A increased <b>threefold</b>.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">Half
                                                            / A third / A quarter</td>
                                                        <td class="p-2 border border-gray-200">A was <b>exactly half of</b>
                                                            B.<br>B was <b>a third of</b> A.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="space-y-8">
                                        <!-- Comparative Structures -->
                                        <div class="space-y-3">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-lg text-gray-800">Comparative Structures</h4>
                                            </div>
                                            <table class="w-full text-sm border-collapse border border-gray-200">
                                                <thead class="bg-slate-200 text-slate-800">
                                                    <tr>
                                                        <th class="p-2 border border-gray-200 text-left">Rules</th>
                                                        <th class="p-2 border border-gray-200 text-left">Adjective</th>
                                                        <th class="p-2 border border-gray-200 text-left">Comparative</th>
                                                        <th class="p-2 border border-gray-200 text-left">Superlative</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100 align-top">
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">One
                                                            syllable</td>
                                                        <td class="p-2 border border-gray-200">quick<br>old</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Add
                                                                -er</span>quicker<br>older</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Add
                                                                -est</span>quickest<br>oldest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">One
                                                            syllable – ending in 'e'</td>
                                                        <td class="p-2 border border-gray-200">safe<br>nice</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Add
                                                                -r</span>safer<br>nicer</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Add
                                                                -st</span>safest<br>nicest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">One
                                                            syllable – CVC</td>
                                                        <td class="p-2 border border-gray-200">big<br>wet</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Double last
                                                                consonant + er</span>bigger<br>wetter</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Double last
                                                                consonant + est</span>biggest<br>wettest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">Two
                                                            syllables – ending in 'y'</td>
                                                        <td class="p-2 border border-gray-200">heavy<br>lovely</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Remove 'y' and
                                                                add -ier</span>heavier<br>lovelier</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Remove 'y' and
                                                                add -iest</span>heaviest<br>loveliest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">Two
                                                            or more syllables</td>
                                                        <td class="p-2 border border-gray-200">famous<br>embarrassed</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Use
                                                                'more'</span>more famous<br>more embarrassed</td>
                                                        <td class="p-2 border border-gray-200"><span
                                                                class="text-xs text-slate-500 italic block mb-1">Use
                                                                'most'</span>most famous<br>most embarrassed</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-gray-200 font-semibold text-slate-800">
                                                            Irregular</td>
                                                        <td class="p-2 border border-gray-200">good<br>bad</td>
                                                        <td class="p-2 border border-gray-200">better<br>worse</td>
                                                        <td class="p-2 border border-gray-200">best<br>worst</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-lg text-gray-800">Useful Comparison Verbs</h4>
                                            </div>
                                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-2">
                                                <li><b>exceed / surpass</b> – The A line exceeded B in 2022.</li>
                                                <li><b>outperform / outnumber</b> – Category X outperformed category Y.</li>
                                                <li><b>be higher than / be lower than</b> – Sales were higher than last year.
                                                </li>
                                                <li><b>rise / increase / climb</b> – The figure rose steadily.</li>
                                                <li><b>fall / decrease / drop</b> – The number dropped sharply.</li>
                                                <li><b>remain stable / stay constant</b> – The rate remained stable.</li>
                                                <li><b>peak / reach</b> – It peaked at 45%.</li>
                                                <li><b>account for / represent</b> – This category accounted for the largest
                                                    share.</li>
                                            </ul>
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

<!-- 3.6. DIRECTION & MAPS (Task 1 Only) -->
@if($type === 'writing_t1')
    <div x-data="{ open: false }">
        <button @click="open = true"
            class="bg-gray-500 hover:bg-gray-400 text-white text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            Direction & Maps
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Map & Direction Vocabulary</h3>
                            <p class="text-sm text-slate-500">Vocabulary used to describe locations, directions, and changes
                                in map/diagram tasks.</p>
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg
                                class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>
                    <div class="overflow-y-auto p-6 bg-white space-y-8">

                        <!-- Locations & Directions Visual -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-lg text-gray-800">Locations & Directions</h4>
                            </div>

                            <!-- Visual Compass -->
                            <div
                                class="bg-slate-100 rounded-xl p-4 border border-gray-200 flex justify-center items-center min-h-[300px]">
                                <svg viewBox="-40 -40 400 400"
                                    class="w-full max-w-[500px] h-auto mx-auto drop-shadow-sm flex-shrink-0"
                                    style="min-height: 450px;">
                                    <defs>
                                        <g id="small-arrow">
                                            <polygon points="160,75 170,140 160,160" fill="#E5E7EB" />
                                            <polygon points="160,75 160,160 150,140" fill="#9CA3AF" />
                                        </g>
                                        <g id="large-arrow">
                                            <polygon points="160,40 175,140 160,160" fill="#9CA3AF" />
                                            <polygon points="160,40 160,160 145,140" fill="#111827" />
                                        </g>
                                    </defs>

                                    <!-- Circles -->
                                    <circle cx="160" cy="160" r="60" fill="none" stroke="#6B7280" stroke-width="1"
                                        opacity="0.3" />
                                    <circle cx="160" cy="160" r="85" fill="none" stroke="#6B7280" stroke-width="1"
                                        opacity="0.3" />

                                    <!-- Small Arrows -->
                                    <use href="#small-arrow" transform="rotate(45 160 160)" />
                                    <use href="#small-arrow" transform="rotate(135 160 160)" />
                                    <use href="#small-arrow" transform="rotate(225 160 160)" />
                                    <use href="#small-arrow" transform="rotate(315 160 160)" />

                                    <!-- Large Arrows -->
                                    <use href="#large-arrow" transform="rotate(0 160 160)" />
                                    <use href="#large-arrow" transform="rotate(90 160 160)" />
                                    <use href="#large-arrow" transform="rotate(180 160 160)" />
                                    <use href="#large-arrow" transform="rotate(270 160 160)" />

                                    <!-- Labels -->
                                    <text x="160" y="20" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">North</text>
                                    <text x="160" y="310" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">South</text>
                                    <text x="305" y="165" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">East</text>
                                    <text x="15" y="165" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">West</text>

                                    <text x="250" y="70" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Northeast</text>
                                    <text x="70" y="70" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Northwest</text>
                                    <text x="250" y="260" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Southeast</text>
                                    <text x="70" y="260" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Southwest</text>
                                </svg>
                            </div>

                            <table class="w-full text-sm border-collapse border border-gray-200">
                                <thead class="bg-slate-200 text-slate-900">
                                    <tr>
                                        <th class="p-2 border border-gray-200 text-left">Category</th>
                                        <th class="p-2 border border-gray-200 text-left">Vocabulary & Examples</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr>
                                        <td class="p-2 border border-gray-200 font-bold">Compass Phrases</td>
                                        <td class="p-2 border border-gray-200"><b>to the north of</b>, <b>in the
                                                south-west</b>, <b>eastwards</b>, <b>just north of</b>.<br><i>The forest
                                                <b>to the north of</b> the river was cut down.</i></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-gray-200 font-bold">Sebelah & Berdampingan</td>
                                        <td class="p-2 border border-gray-200">
                                            <b>Beside</b>: <i>A small car park was built beside the library.</i><br>
                                            <b>Next to</b>: <i>The town hall is located next to the post office.</i><br>
                                            <b>By</b>: <i>A new seating area was added by the river.</i><br>
                                            <b>Near</b>: <i>The residential area was expanded near the woods.</i><br>
                                            <b>Close to</b>: <i>The new supermarket is situated close to the train
                                                station.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-gray-200 font-bold">Berhadapan & Berseberangan</td>
                                        <td class="p-2 border border-gray-200">
                                            <b>Across</b>: <i>A new bridge was constructed across the river.</i><br>
                                            <b>Across from</b>: <i>The hospital was built across from the school.</i><br>
                                            <b>In front of</b>: <i>A bus stop was added in front of the shopping
                                                mall.</i><br>
                                            <b>Opposite</b>: <i>The newly built stadium stands directly opposite the
                                                park.</i><br>
                                            <b>Facing</b>: <i>The main entrance of the hotel is facing the sea.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-gray-200 font-bold">Depan, Belakang & Tengah</td>
                                        <td class="p-2 border border-gray-200">
                                            <b>Behind</b>: <i>The warehouse was relocated behind the main factory.</i><br>
                                            <b>At the back of</b>: <i>A small garden was created at the back of the
                                                museum.</i><br>
                                            <b>In the middle of</b>: <i>The fountain in the middle of the square was
                                                removed.</i><br>
                                            <b>In the centre of</b>: <i>A massive shopping center now sits in the centre of
                                                the town.</i><br>
                                            <b>Between</b>: <i>The cafe was built between the library and the bank.</i><br>
                                            <b>Among</b>: <i>The new cottages were constructed among the trees.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-gray-200 font-bold">Atas, Bawah & Pinggir</td>
                                        <td class="p-2 border border-gray-200">
                                            <b>Above</b>: <i>On the map, the industrial estate lies above the residential
                                                zone.</i><br>
                                            <b>Below</b>: <i>The coastal village is located just below the hills.</i><br>
                                            <b>At the edge of</b>: <i>A temporary campsite was set up at the edge of the
                                                lake.</i><br>
                                            <b>Along</b>: <i>A row of new houses was built along the main road.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-gray-200 font-bold">Area pada Peta / Gambar</td>
                                        <td class="p-2 border border-gray-200">
                                            <b>In the ... corner</b> (Di pojok...): <i>A hospital was located in the top
                                                left-hand corner.</i><br>
                                            <b>On the ... side</b> (Di sisi...): <i>The residential area is situated on the
                                                right side of the river.</i><br>
                                            <b>At the top / bottom</b> (Di bagian atas/bawah): <i>There is a large mountain
                                                range at the top of the map.</i><br>
                                            <b>In the center / middle</b> (Di bagian tengah): <i>The main square lies
                                                perfectly in the center of the town.</i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Vocabulary of Change -->
                        <div class="space-y-2">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                </div>
                                <table class="w-full text-xs border-collapse border border-gray-200">
                                    <thead class="bg-slate-200 text-slate-800">
                                        <tr>
                                            <th class="px-2 py-1 border border-gray-200 text-left">Action</th>
                                            <th class="px-2 py-1 border border-gray-200 text-left">Vocabulary</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="px-2 py-1 border border-gray-200 font-bold">Adding / Building</td>
                                            <td class="px-2 py-1 border border-gray-200"><b>constructed</b>, <b>built</b>,
                                                <b>erected</b>, <b>added</b>, <b>planted</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 border border-gray-200 font-bold">Removing</td>
                                            <td class="px-2 py-1 border border-gray-200"><b>demolished</b>, <b>knocked
                                                    down</b>,
                                                <b>removed</b>, <b>cleared</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 border border-gray-200 font-bold">Replacing / Converting
                                            </td>
                                            <td class="px-2 py-1 border border-gray-200"><b>replaced by</b>, <b>converted
                                                    into</b>, <b>transformed into</b></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 border border-gray-200 font-bold">Expanding / Reducing</td>
                                            <td class="px-2 py-1 border border-gray-200"><b>expanded</b>, <b>extended</b>,
                                                <b>enlarged</b>, <b>reduced</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Map Passive Voice -->
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-base text-gray-800">Using Passive Voice</h4>
                                </div>
                                <div class="p-2 bg-slate-50 border border-gray-200 rounded-lg text-xs text-gray-700">
                                    <p class="mb-1">Use <b>Passive Voice</b> to describe changes: <b>Subject + be + Verb
                                            3</b>
                                    </p>
                                    <ul class="list-disc pl-5 space-y-0 text-xs">
                                        <li><b>was built</b>, <b>were demolished</b>, <b>has been converted</b>, <b>was
                                                extended</b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </template>
    </div>
@endif

<!-- 3.7. DESCRIBING PROCESS (Task 1 Only) -->
@if($type === 'writing_t1')
    <div x-data="{ open: false }">
        <button @click="open = true"
            class="bg-gray-300 hover:bg-gray-200 text-black text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap border border-gray-400">
            Describing Process
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Describing Process & Flowcharts</h3>
                            <p class="text-sm text-slate-700">Vocabulary used to describe steps and stages in a process
                                diagram or flowchart.</p>
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <div class="overflow-y-auto p-6 bg-white space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Sequencing Steps -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-lg text-gray-800">Sequencing Steps </h4>
                                </div>
                                <table class="w-full text-sm border-collapse border border-gray-200">
                                    <thead class="bg-slate-200 text-slate-800">
                                        <tr>
                                            <th class="p-2 border border-gray-200 text-left w-1/3">Stage</th>
                                            <th class="p-2 border border-gray-200 text-left">Vocabulary</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="p-2 border border-gray-200 font-bold">Beginning</td>
                                            <td class="p-2 border border-gray-200"><b>First</b>, <b>Firstly</b>, <b>To begin
                                                    with</b>, <b>Initially</b>, <b>The first step is</b>.<br><i><b>To begin
                                                        with</b>, the raw materials are collected.</i></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-gray-200 font-bold">Continuing</td>
                                            <td class="p-2 border border-gray-200"><b>Next</b>, <b>Then</b>, <b>Later</b>,
                                                <b>After that</b>, <b>Following this</b>, <b>Subsequently</b>, <b>In the
                                                    subsequent stage</b>, <b>Followed by</b>.<br><i><b>Subsequently</b>, the
                                                    mixture is heated to 100 degrees.</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-gray-200 font-bold">Simultaneous</td>
                                            <td class="p-2 border border-gray-200"><b>At the same time</b>,
                                                <b>Simultaneously</b>, <b>Meanwhile</b>,
                                                <b>During</b>.<br><i><b>Meanwhile</b>, the bottles are cleaned and
                                                    prepared.</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-gray-200 font-bold">Ending</td>
                                            <td class="p-2 border border-gray-200"><b>Finally</b>, <b>Eventually</b>, <b>The
                                                    final step is</b>, <b>In the last stage</b>.<br><i><b>Finally</b>, the
                                                    finished products are packaged.</i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Verbs & Passive Voice -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-lg text-gray-800">Using Passive Voice</h4>
                                </div>
                                <div class="p-4 bg-slate-100 border border-gray-200 rounded-lg text-sm text-gray-700">
                                    <p class="mb-2">In Task 1 process descriptions, we usually use the <b>Passive Voice</b>
                                        because the action is more important than who is doing it.</p>
                                    <p class="font-bold text-slate-900 mb-1">Pattern: Subject + be + Verb 3</p>
                                    <p class="font-bold text-slate-500 mb-1">be = is/am/are/was/were/been/being</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>The tea leaves <b>are picked</b> by hand.</li>
                                        <li>The boxes <b>are transported</b> to the factory.</li>
                                        <li>The liquid <b>is heated</b> and then <b>cooled</b>.</li>
                                        <li>The fruits <b>are sorted</b> before they <b>are packed</b>.</li>
                                    </ul>
                                </div>
                                <div
                                    class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-sm text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-lg text-gray-800">Common Flowchart Verbs</h4>
                                    </div>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li><b>start</b> – The process starts with raw material preparation.</li>
                                        <li><b>enter</b> – The product enters the mixing chamber.</li>
                                        <li><b>flow to / move to</b> – The liquid flows to the heating section.</li>
                                        <li><b>continue</b> – The mixture continues to the next stage.</li>
                                        <li><b>split / divide</b> – The stream divides into two separate routes.</li>
                                        <li><b>combine</b> – The components combine in the reactor.</li>
                                        <li><b>pass through</b> – The solution passes through the filter.</li>
                                        <li><b>exit</b> – The finished product exits the system.</li>
                                        <li><b>inspect</b> – The items are inspected before packaging.</li>
                                        <li><b>transfer</b> – The material is transferred to the storage tank.</li>
                                    </ul>
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
@if($type === 'writing_t2' || $type === 'writing')
    <div id="collocations-component"
        data-prompt="{{ strip_tags($test->prompt ?? (isset($test->questions) && is_array($test->questions) ? implode(' ', $test->questions) : '')) }}"
        x-data="{
                                                open: false,
                                                searchQuery: '',
                                                collocations: [],
                                                loading: false,
                                                fetched: false,
                                                error: null,
                                                async fetchCollocations() {
                                                    if (this.fetched) return;
                                                    this.loading = true;
                                                    this.error = null;
                                                    try {
                                                        let promptText = document.getElementById('collocations-component')?.dataset.prompt;
                                                        if (!promptText || promptText.trim() === '') {
                                                            const box = document.getElementById('questionInstructionBox');
                                                            if (box && box.innerText.trim() !== '') {
                                                                promptText = box.innerText;
                                                            }
                                                        }
                                                        if (!promptText || promptText.trim() === '') {
                                                            this.error = 'Tidak ada pertanyaan (prompt) yang ditemukan.';
                                                            this.loading = false;
                                                            return;
                                                        }
                                                        const response = await fetch('/api/ollama/topic-collocations', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'Accept': 'application/json',
                                                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content')
                                                            },
                                                            body: JSON.stringify({ prompt: promptText, task: {{ $type === 'writing_t1' ? 1 : 2 }} })
                                                        });
                                                        if (!response.ok) throw new Error('Gagal mendapatkan collocations.');
                                                        const data = await response.json();
                                                        if (data.collocations) {
                                                            this.collocations = data.collocations;
                                                            this.fetched = true;
                                                        } else {
                                                            this.error = 'Format dari AI tidak sesuai.';
                                                        }
                                                    } catch(e) { this.error = e.message; } finally { this.loading = false; }
                                                },
                                                get filteredCollocations() {
                                                    if (!this.searchQuery.trim()) return this.collocations;
                                                    const query = this.searchQuery.toLowerCase();
                                                    return this.collocations.filter(item => 
                                                        (item.phrase && item.phrase.toLowerCase().includes(query)) || 
                                                        (item.meaning && item.meaning.toLowerCase().includes(query))
                                                    );
                                                }
                                            }">
        <button @click="open = true; fetchCollocations()"
            class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap border border-emerald-700" data-tooltip="Kumpulan kata yang alami dipasangkan bersama">
            Collocations
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-slate-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Daftar Collocations ({{ $test->title ?? '' }})</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                        <input type="text" x-model="searchQuery" placeholder="Cari phrase atau makna..."
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                    </div>
                    <div class="overflow-y-auto px-6 pb-6 bg-white flex-1" style="max-height: 60vh;">
                        <div x-show="loading" class="text-center py-10 flex flex-col items-center">
                            <span
                                class="animate-spin h-8 w-8 border-4 border-slate-500 border-t-transparent rounded-full mb-4"></span>
                            <span class="text-slate-700 font-medium">Generating related collocations...</span>
                        </div>
                        <div x-show="error" x-text="error" class="text-center text-slate-700 py-10"></div>

                        <div x-show="!loading && !error">
                            <template x-if="collocations && collocations.length > 0">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                    <template x-for="(item, index) in filteredCollocations" :key="index">
                                        <div
                                            class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition-shadow">
                                            <h4 class="font-bold text-slate-800 text-lg mb-1" x-text="item.phrase"></h4>
                                            <p class="text-gray-600 text-sm mb-3 italic" x-text="item.meaning"></p>
                                            <div class="bg-slate-100 rounded-lg p-3">
                                                <p class="text-gray-700 text-sm" x-text="item.example"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="fetched && (!collocations || collocations.length === 0)">
                                <div class="text-center py-10 text-gray-500">
                                    Tidak ada collocations yang ditemukan untuk topik ini.
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endif

<!-- 4. IDIOMS -->
@if($type === 'writing_t2' || $type === 'writing')
    <div id="idioms-component"
        data-prompt="{{ strip_tags($test->prompt ?? (isset($test->questions) && is_array($test->questions) ? implode(' ', $test->questions) : '')) }}"
        x-data="{
                                    open: false,
                                    searchQuery: '',
                                    idioms: [],
                                    loading: false,
                                    fetched: false,
                                    error: null,
                                    async fetchIdioms() {
                                        if (this.fetched) return;
                                        this.loading = true;
                                        this.error = null;
                                        try {
                                            let promptText = document.getElementById('idioms-component')?.dataset.prompt;
                                            if (!promptText || promptText.trim() === '') {
                                                const box = document.getElementById('questionInstructionBox');
                                                if (box && box.innerText.trim() !== '') {
                                                    promptText = box.innerText;
                                                }
                                            }
                                            if (!promptText || promptText.trim() === '') {
                                                this.error = 'Tidak ada pertanyaan (prompt) yang ditemukan.';
                                                this.loading = false;
                                                return;
                                            }
                                            const response = await fetch('/api/ollama/topic-idioms', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content')
                                                },
                                                body: JSON.stringify({ prompt: promptText, task: {{ $type === 'writing_t1' ? 1 : 2 }} })
                                            });
                                            if (!response.ok) throw new Error('Gagal mendapatkan idioms.');
                                            const data = await response.json();
                                            if (data.idioms) {
                                                this.idioms = data.idioms;
                                                this.fetched = true;
                                            } else {
                                                this.error = 'Format dari AI tidak sesuai.';
                                            }
                                        } catch(e) { this.error = e.message; } finally { this.loading = false; }
                                    },
                                    get filteredIdioms() {
                                        if (!this.searchQuery.trim()) return this.idioms;
                                        const query = this.searchQuery.toLowerCase();
                                        return this.idioms.filter(item => 
                                            (item.phrase && item.phrase.toLowerCase().includes(query)) || 
                                            (item.meaning && item.meaning.toLowerCase().includes(query))
                                        );
                                    }
                                }">
        <button @click="open = true; fetchIdioms()"
            class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap border border-teal-700" data-tooltip="Ungkapan khas / peribahasa bahasa Inggris">
            Idioms
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-slate-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Daftar Idioms ({{ $test->title ?? '' }})</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                        <input type="text" x-model="searchQuery" placeholder="Cari idiom atau makna..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                    </div>
                    <div class="overflow-y-auto px-6 pb-6 bg-white flex-1" style="max-height: 60vh;">
                        <div x-show="loading" class="text-center py-10 flex flex-col items-center">
                            <span
                                class="animate-spin h-8 w-8 border-4 border-slate-500 border-t-transparent rounded-full mb-4"></span>
                            <span class="text-slate-700 font-medium">Generating related idioms...</span>
                        </div>
                        <div x-show="error" x-text="error" class="text-center text-slate-700 py-10"></div>

                        <div x-show="!loading && !error">
                            <template x-if="idioms && idioms.length > 0">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                    <template x-for="(item, index) in filteredIdioms" :key="index">
                                        <div
                                            class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition-shadow">
                                            <h4 class="font-bold text-slate-800 text-lg mb-1" x-text="item.phrase"></h4>
                                            <p class="text-gray-600 text-sm mb-3 italic" x-text="item.meaning"></p>
                                            <div class="bg-slate-100 rounded-lg p-3">
                                                <p class="text-gray-700 text-sm" x-text="item.example"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="fetched && (!idioms || idioms.length === 0)">
                                <div class="text-center py-10 text-gray-500">
                                    Tidak ada idioms yang ditemukan untuk topik ini.
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- 5. IDEAS (NEW) -->
    <div id="ideas-component"
        data-prompt="{{ strip_tags($test->prompt ?? (isset($test->questions) && is_array($test->questions) ? implode(' ', $test->questions) : '')) }}"
        x-data="{
                                    open: false,
                                    htmlContent: null,
                                    loading: false,
                                    error: null,
                                    async fetchIdeas() {
                                        if (this.htmlContent) return; // Already fetched
                                        this.loading = true;
                                        this.error = null;
                                        try {
                                            let promptText = document.getElementById('ideas-component')?.dataset.prompt;

                                            if (!promptText || promptText.trim() === '') {
                                                const box = document.getElementById('questionInstructionBox');
                                                if (box && box.innerText.trim() !== '') {
                                                    promptText = box.innerText;
                                                }
                                            }

                                            if (!promptText || promptText.trim() === '') {
                                                this.error = 'Tidak ada pertanyaan (prompt) yang ditemukan untuk dianalisis.';
                                                this.loading = false;
                                                return;
                                            }

                                            const response = await fetch('/api/ollama/ideas', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content')
                                                },
                                                body: JSON.stringify({ prompt: promptText, task: {{ $type === 'writing_t1' ? 1 : 2 }} })
                                            });
                                            if (!response.ok) throw new Error('Gagal mendapatkan ide.');
                                            const data = await response.json();
                                            if (data.html) this.htmlContent = data.html;
                                            else this.error = 'Format yang diterima dari AI tidak sesuai.';
                                        } catch(e) { this.error = e.message; } finally { this.loading = false; }
                                    }
                                }">
        <button @click="open = true; fetchIdeas()"
            class="btn-glow-wrapper shadow-sm transform transition hover:scale-105" data-tooltip="Kumpulan ide dan argumen untuk topik esai">
            <span class="btn-glow-content bg-red-500 hover:bg-red-600 text-white border-0 text-xs font-semibold py-1.5 px-3 flex items-center gap-2 whitespace-nowrap">
                Ideas
            </span>
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-slate-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-900">Topic Ideas & Vocabulary</h3>
                        <button @click="open = false" class="text-slate-500 hover:text-slate-700"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <div class="overflow-y-auto p-6 bg-white flex-1 custom-scrollbar">
                        <div x-show="loading" class="text-center py-10 flex flex-col items-center">
                            <span
                                class="animate-spin h-8 w-8 border-4 border-slate-500 border-t-transparent rounded-full mb-4"></span>
                            <span class="text-slate-700 font-medium">Generating structured topic vocabulary...</span>
                        </div>
                        <div x-show="error" x-text="error" class="text-center text-slate-700 py-10"></div>
                        <style>
                            .ideas-content h3 {
                                color: #9d174d;
                                font-size: 1.25rem;
                                font-weight: 700;
                                border-bottom: 2px solid #fbcfe8;
                                padding-bottom: 0.5rem;
                                margin-bottom: 1.5rem;
                                margin-top: 2rem;
                            }

                            .ideas-content h3:first-child {
                                margin-top: 0;
                            }

                            .ideas-content p {
                                color: #334155;
                                line-height: 1.625;
                                margin-bottom: 1rem;
                            }

                            .ideas-content strong {
                                color: #be185d;
                                font-weight: 700;
                            }

                            .ideas-content em {
                                color: #64748b;
                                font-style: italic;
                            }

                            .ideas-content ul {
                                list-style-type: disc;
                                padding-left: 1.5rem;
                                margin-bottom: 1.5rem;
                                color: #334155;
                            }

                            .ideas-content li {
                                margin-bottom: 0.5rem;
                            }

                            .ideas-content table {
                                width: 100%;
                                text-align: left;
                                border-collapse: collapse;
                                margin-top: 1rem;
                                margin-bottom: 2rem;
                                border-radius: 0.5rem;
                                overflow: hidden;
                                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                                display: block;
                                overflow-x: auto;
                                -webkit-overflow-scrolling: touch;
                            }

                            .ideas-content th {
                                background-color: #fce7f3;
                                color: #831843;
                                padding: 1rem;
                                font-weight: 600;
                                border-bottom: 1px solid #fbcfe8;
                                min-width: 140px;
                            }

                            .ideas-content td {
                                padding: 1rem;
                                color: #334155;
                                border-bottom: 1px solid #f1f5f9;
                                vertical-align: top;
                                min-width: 140px;
                            }

                            .ideas-content tr:last-child td {
                                border-bottom: none;
                            }

                            .ideas-content tr:hover td {
                                background-color: #f8fafc;
                            }
                        </style>
                        <div x-show="!loading && !error && htmlContent" class="ideas-content text-lg" x-html="htmlContent">
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- MAGIC SENTENCE -->
    <div>
        <button @click="toggleMagicSentence()"
            class="btn-glow-wrapper shadow-sm transform transition hover:scale-105" data-tooltip="Ketik Indonesia → jadi kalimat gaya IELTS otomatis">
            <span class="btn-glow-content text-xs font-semibold py-1.5 px-3 flex items-center gap-2 whitespace-nowrap"
                  :class="msOpen ? 'bg-blue-600 text-white ring-2 ring-blue-300' : 'bg-blue-500 hover:bg-blue-600 text-white'">
                Magic Sentence
            </span>
        </button>
    </div>

    <!-- 6. COLLOCATION DICTIONARY -->
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
                                            if (!response.ok) {
                                                let errMessage = 'Failed to fetch ideas.';
                                                try {
                                                    const errData = await response.json();
                                                    if (errData.error) errMessage = errData.error;
                                                    if (errData.debug) errMessage += ' - ' + errData.debug;
                                                } catch(e) {}
                                                throw new Error(errMessage);
                                            }
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
        <button @click="open = true"
            class="bg-indigo-600 hover:bg-indigo-700 text-white border border-indigo-700 text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap" data-tooltip="Kamus khusus pencarian pasangan kata">
            Collocation Dictionary
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-2xl relative overflow-hidden" style="height: 80vh;">
                    <div class="absolute top-0 left-0 right-0 z-20 bg-white shadow-sm flex flex-col" style="height: 150px;">
                        <div class="p-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center"
                            style="height: 70px;">
                            <h3 class="text-xl font-bold text-slate-800">Collocation Dictionary</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                        <div class="p-4 border-b border-gray-100 bg-white" style="height: 80px;">
                            <form @submit.prevent="search" class="flex gap-2 h-full items-center"><input type="text"
                                    x-model="query" placeholder="Type a word..."
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg h-10"><button type="submit"
                                    class="bg-slate-700 text-white px-6 py-2 rounded-lg h-10" :disabled="loading"><span
                                        x-show="!loading">Ask</span><span x-show="loading">...</span></button></form>
                        </div>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 overflow-y-auto p-6 bg-gray-50 bg-white" style="top: 150px;">
                        <div x-show="loading" class="text-center py-10">Processing...</div>
                        <div x-show="error" x-text="error" class="text-center text-slate-700 py-10"></div>
                        <div x-show="!loading && !error && results.length > 0">
                            <h2 x-text="query" class="text-3xl font-bold text-center mb-4"></h2>
                            <template x-for="(items, type) in getGroups()" :key="type">
                                <div class="mb-4">
                                    <h4 class="font-bold text-slate-700 uppercase mb-2 border-l-4 border-slate-300 pl-2"
                                        x-text="type"></h4>
                                    <div class="space-y-3">
                                        <template x-for="item in items" :key="item.phrase">
                                            <div class="bg-white p-3 rounded shadow-sm border">
                                                <div class="flex items-center gap-2 mb-1"><span class="font-bold text-lg"
                                                        x-text="item.phrase"></span><button
                                                        @click="query = item.phrase; search()"
                                                        class="text-xs text-gray-400">RESEARCH</button></div>
                                                <div class="text-sm text-gray-600 mb-1" x-text="item.explanation"></div>
                                                <div class="text-sm italic text-slate-800 bg-slate-50 p-2 rounded"
                                                    x-text="item.example"></div>
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


@endif

<!-- 6. DICTIONARY (Full Logic) -->
@include('promo.dictionary_modal', ['buttonClass' => 'bg-violet-600 hover:bg-violet-700 text-white border border-violet-700 text-xs font-semibold py-1.5 px-3 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap'])

<!-- 7. BANTUAN (FORMAT) -->
<div x-data="{ open: false }">
    <button @click="open = true" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 border border-yellow-500 text-[10px] font-bold py-1 px-2 rounded-lg shadow-sm transform transition hover:scale-105 flex items-center gap-1 whitespace-nowrap" data-tooltip="Penjelasan Format Penulisan IELTS Writing">
        BANTUAN FORMAT
    </button>
    <template x-teleport="body">
        <div x-show="open" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-3xl max-h-[80vh] flex flex-col overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Format Penulisan IELTS Writing</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="overflow-y-auto p-6 bg-white text-gray-700 text-sm space-y-5" style="max-height: 60vh;">
                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h4 class="font-bold text-blue-900 text-base mb-2">Penilaian (Scoring Criteria)</h4>
                        <ul class="list-disc pl-5 space-y-1 text-blue-800">
                            <li><strong>Task Achievement / Task Response:</strong> Menjawab pertanyaan dengan tepat dan relevan.</li>
                            <li><strong>Coherence & Cohesion:</strong> Struktur paragraf rapi dan kalimat terhubung dengan baik (menggunakan linking words).</li>
                            <li><strong>Lexical Resource:</strong> Variasi kosakata yang luas dan tepat (vocabulary/collocations).</li>
                            <li><strong>Grammatical Range & Accuracy:</strong> Penggunaan struktur grammar yang bervariasi dan meminimalisir kesalahan.</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 text-base border-b pb-1 mb-3">IELTS Writing Task 1</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-slate-50 p-3 rounded border border-gray-200">
                                <p class="font-bold text-indigo-700 mb-1">Academic Module</p>
                                <p class="mb-2">Mendeskripsikan informasi visual (grafik, tabel, peta, atau diagram proses) ke dalam sebuah tulisan laporan objektif.</p>
                                <ul class="list-disc pl-4 space-y-1">
                                    <li><strong>Waktu:</strong> 20 Menit</li>
                                    <li><strong>Panjang Kata:</strong> Minimal 150 kata</li>
                                    <li><strong>Struktur Paragraf Ideal:</strong>
                                        <br>1. Introduction (Paraphrase soal)
                                        <br>2. Overview (Tren utama)
                                        <br>3. Body Paragraph 1 (Detail 1)
                                        <br>4. Body Paragraph 2 (Detail 2)
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-slate-50 p-3 rounded border border-gray-200">
                                <p class="font-bold text-teal-700 mb-1">General Training Module</p>
                                <p class="mb-2">Menulis surat (formal, semi-formal, atau informal) untuk meminta informasi atau menjelaskan sebuah situasi.</p>
                                <ul class="list-disc pl-4 space-y-1">
                                    <li><strong>Waktu:</strong> 20 Menit</li>
                                    <li><strong>Panjang Kata:</strong> Minimal 150 kata</li>
                                    <li><strong>Struktur Paragraf Ideal:</strong>
                                        <br>1. Salutation (Dear ...) & Opening
                                        <br>2. Tujuan menulis surat (Point 1)
                                        <br>3. Detail tambahan (Point 2 & 3)
                                        <br>4. Closing & Sign-off
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 text-base border-b pb-1 mb-3">IELTS Writing Task 2 (Academic & General)</h4>
                        <div class="bg-slate-50 p-3 rounded border border-gray-200">
                            <p class="mb-2">Menulis essay formal sebagai tanggapan atas suatu opini, argumen, atau masalah.</p>
                            <ul class="list-disc pl-4 space-y-1 mb-3">
                                <li><strong>Waktu:</strong> 40 Menit</li>
                                <li><strong>Panjang Kata:</strong> Minimal 250 kata</li>
                            </ul>
                            <p class="font-bold text-gray-800 mb-1">Struktur Essay Ideal (4-5 Paragraf):</p>
                            <ol class="list-decimal pl-4 space-y-2">
                                <li><strong>Introduction:</strong> Paraphrase topik/soal dan berikan tesis statement (posisi/pendapatmu yang jelas).</li>
                                <li><strong>Body Paragraph 1:</strong> Ide utama pertama. Awali dengan topic sentence, lalu jelaskan (explain), berikan contoh (example), dan kaitkan kembali ke topik (link).</li>
                                <li><strong>Body Paragraph 2:</strong> Ide utama kedua (bisa berupa argumen pendukung, sisi yang berlawanan, atau solusi masalah tergantung tipe soal). Gunakan struktur yang sama dengan Body 1.</li>
                                <li><strong>Conclusion:</strong> Ringkas poin-poin utama dari body paragraphs dan tegaskan kembali pendapatmu. Jangan tambahkan ide baru di sini.</li>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </template>
</div>

<div id="tb-tooltip"
     style="position:fixed;z-index:9999;background:#1f2937;color:#fff;font-size:11px;padding:6px 10px;border-radius:6px;pointer-events:none;opacity:0;transition:opacity 0.15s;max-width:200px;text-align:center;line-height:1.5;box-shadow:0 4px 12px rgba(0,0,0,0.3);white-space:normal;">
</div>
<script>
(function(){
    const tip = document.getElementById('tb-tooltip');
    if (tip) {
        document.body.appendChild(tip); // Move to body to prevent overflow clipping
    }
    let hideTimer;
    document.addEventListener('mouseover', function(e){
        const btn = e.target.closest('[data-tooltip]');
        if(!btn) return;
        clearTimeout(hideTimer);
        tip.textContent = btn.dataset.tooltip;
        const r = btn.getBoundingClientRect();
        tip.style.opacity = '1';
        // Position below the button
        const tw = tip.offsetWidth || 180;
        let left = r.left + r.width/2 - tw/2;
        left = Math.max(8, Math.min(left, window.innerWidth - tw - 8));
        tip.style.left = left + 'px';
        tip.style.top  = (r.bottom + 6) + 'px';
    });
    document.addEventListener('mouseout', function(e){
        const btn = e.target.closest('[data-tooltip]');
        if(!btn) return;
        hideTimer = setTimeout(()=>{ tip.style.opacity='0'; }, 80);
    });
})();
</script>
</div>