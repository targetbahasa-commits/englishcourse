<!-- Floating Helper Buttons Stack -->
<div class="fixed bottom-4 right-3 sm:right-8 z-50 flex flex-col gap-1.5 sm:gap-2 items-end">

    {{-- Dictionary --}}
    <div x-data="{
        open: false,
        get displayText() { return this.lookupWord || 'Dictionary'; },
        lookupWord: '',
        lookupResult: '',
        isLoading: false,
        async translate() {
            if (!this.lookupWord.trim()) return;
            this.isLoading = true;
            this.lookupResult = '';
            try {
                const res = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(this.lookupWord)}&langpair=en|id`);
                const data = await res.json();
                this.lookupResult = data.responseData?.translatedText || 'Tidak ditemukan.';
            } catch(e) {
                this.lookupResult = 'Error. Periksa koneksi internet.';
            }
            this.isLoading = false;
        }
    }">
        <button @click="open = true"
                title="Dictionary"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span class="hidden sm:inline">Dictionary</span>
        </button>
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display:none;">
            <div @click.outside="open=false" class="bg-white rounded-xl shadow-2xl w-full max-w-md flex flex-col overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">📘 Dictionary (EN → ID)</h3>
                    <button @click="open=false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <div class="p-4">
                    <div class="flex gap-2">
                        <input type="text" x-model="lookupWord" @keydown.enter="translate()"
                               placeholder="Ketik kata bahasa Inggris..."
                               class="flex-1 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button @click="translate()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Cari</button>
                    </div>
                    <div x-show="isLoading" class="mt-3 text-sm text-gray-500 text-center">⏳ Menerjemahkan...</div>
                    <div x-show="lookupResult && !isLoading" class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="text-sm font-medium text-gray-700">Hasil:</p>
                        <p class="text-base font-bold text-blue-700" x-text="lookupResult"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Linking Words --}}
    <div x-data="{ open: false }">
        <button @click="open = true"
                title="Linking Words"
                class="bg-teal-500 hover:bg-teal-600 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            <span class="hidden sm:inline">Linking Words</span>
        </button>
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display:none;">
            <div @click.outside="open=false" class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden">
                <div class="p-5 border-b flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Linking Words & Transitions</h3>
                    <button @click="open=false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <div class="overflow-y-auto p-5 space-y-4">
                    @php $lw = [
                        ['Time / Chronological', 'bg-blue-50 border-blue-200', 'Afterwards, Soon, Meanwhile, In the meantime, Next, Then, Later, Eventually, At the same time, Finally, Initially, Subsequently, Simultaneously'],
                        ['Addition', 'bg-green-50 border-green-200', 'Moreover, Furthermore, In addition, Besides, Also, Additionally, Further'],
                        ['Sequential', 'bg-yellow-50 border-yellow-200', 'First, Second, Third, Firstly, Secondly, Thirdly, Next, Finally, In the first place, To begin'],
                        ['Contrast', 'bg-red-50 border-red-200', 'However, Yet, In contrast, Conversely, On the other hand, Nevertheless, Notwithstanding, Whereas, Although'],
                        ['Conclusion / Summary', 'bg-purple-50 border-purple-200', 'In conclusion, To conclude, Therefore, Thus, In summary, To sum up, In brief, Finally, All in all, Overall'],
                        ['Cause & Effect', 'bg-orange-50 border-orange-200', 'Therefore, Thus, Hence, Consequently, As a result, Accordingly, Because, Since, Due to, Owing to'],
                        ['Example / Clarification', 'bg-pink-50 border-pink-200', 'For example, For instance, Specifically, In particular, Namely, That is, In other words, Such as, To illustrate'],
                        ['Similarity', 'bg-indigo-50 border-indigo-200', 'Likewise, Similarly, In the same way, In like manner, Equally'],
                    ]; @endphp
                    @foreach($lw as $item)
                    <div class="p-3 rounded-lg border {{ $item[1] }}">
                        <p class="font-bold text-gray-700 text-sm mb-1">{{ $item[0] }}</p>
                        <p class="text-sm text-gray-600">{{ $item[2] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Pronouns --}}
    <div x-data="{ open: false }">
        <button @click="open = true"
                title="Pronouns"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="hidden sm:inline">Pronoun</span>
        </button>
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display:none;">
            <div @click.outside="open=false" class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[85vh] flex flex-col overflow-hidden">
                <div class="p-5 border-b flex justify-between items-center bg-blue-50">
                    <h3 class="text-lg font-bold text-gray-800">English Pronouns</h3>
                    <button @click="open=false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <div class="overflow-y-auto p-5">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-blue-500 text-white">
                                <th class="p-3 border border-blue-600">Subject</th>
                                <th class="p-3 border border-blue-600">Object</th>
                                <th class="p-3 border border-blue-600">Poss. Adj.</th>
                                <th class="p-3 border border-blue-600">Poss. Pronoun</th>
                                <th class="p-3 border border-blue-600">Reflexive</th>
                                <th class="p-3 border border-blue-600">Arti</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100">
                            @php $pronouns = [
                                ['I','me','my','mine','myself','Saya / Aku'],
                                ['You','you','your','yours','yourself','Kamu / Anda'],
                                ['He','him','his','his','himself','Dia (L)'],
                                ['She','her','her','hers','herself','Dia (P)'],
                                ['It','it','its','its','itself','Itu (Benda)'],
                                ['We','us','our','ours','ourselves','Kami / Kita'],
                                ['They','them','their','theirs','themselves','Mereka'],
                            ]; @endphp
                            @foreach($pronouns as $row)
                            <tr class="odd:bg-white even:bg-blue-50">
                                @foreach($row as $cell)
                                <td class="p-2.5 border border-blue-100 text-center font-medium">{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Verb Patterns --}}
    <div x-data="{ open: false }">
        <button @click="open = true"
                title="Verb Palsu (Verb Patterns)"
                class="bg-sky-500 hover:bg-sky-600 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            <span class="hidden sm:inline">Verb Palsu</span>
        </button>
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display:none;">
            <div @click.outside="open=false" class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[85vh] flex flex-col overflow-hidden">
                <div class="p-5 border-b flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Verb Patterns (Gerund · To-Inf · Bare Inf)</h3>
                    <button @click="open=false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <div class="overflow-y-auto px-5 pb-5" style="max-height:70vh;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <h2 class="font-bold text-white bg-green-500 p-2 rounded-t-lg text-center text-sm">Verb + Gerund (V-ing)</h2>
                            <table class="w-full text-xs border border-green-200 rounded-b-lg overflow-hidden">
                                <thead class="bg-green-50 text-green-800"><tr><th class="p-2">Verb</th><th class="p-2">Arti</th><th class="p-2">Example</th></tr></thead>
                                <tbody class="divide-y divide-green-100">
                                    @php $g = [['admit','Mengakui','admitted stealing'],['advise','Menyarankan','advised resting'],['avoid','Menghindari','avoid eating junk'],['consider','Mempertimbangkan','considers moving'],["can't stand",'Tidak tahan',"can't stand waiting"],['delay','Menunda','delay starting'],['deny','Menyangkal','denied breaking'],['discuss','Membahas','discussed going'],['dislike','Tidak suka','dislikes cooking'],['enjoy','Menikmati','enjoy reading'],['finish','Menyelesaikan','finished working'],['imagine','Membayangkan','imagine living'],['keep','Terus','keep learning'],['mind','Keberatan','mind opening?'],['miss','Merindukan','miss talking'],['postpone','Menunda','postponed meeting'],['practice','Berlatih','practice speaking'],['prevent','Mencegah','prevented playing'],['quit','Berhenti','quit smoking'],['recommend','Merekomendasikan','recommend studying'],['resist','Menahan','resist eating'],['risk','Berisiko','risk losing'],['suggest','Menyarankan','suggest taking'],['tolerate','Mentolerir','tolerate cheating']]; @endphp
                                    @foreach($g as $r)<tr class="odd:bg-white even:bg-green-50"><td class="p-1.5 font-medium">{{ $r[0] }}</td><td class="p-1.5 text-gray-600">{{ $r[1] }}</td><td class="p-1.5 italic text-gray-700">{{ $r[2] }}</td></tr>@endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h2 class="font-bold text-white bg-blue-500 p-2 rounded-t-lg text-center text-sm">Verb + To-Infinitive (to + V1)</h2>
                            <table class="w-full text-xs border border-blue-200 rounded-b-lg overflow-hidden">
                                <thead class="bg-blue-50 text-blue-800"><tr><th class="p-2">Verb</th><th class="p-2">Arti</th><th class="p-2">Example</th></tr></thead>
                                <tbody class="divide-y divide-blue-100">
                                    @php $inf = [['agree','Setuju','agreed to cooperate'],['aim','Bertujuan','aim to finish'],['arrange','Mengatur','arranged to meet'],['ask','Meminta','asked him to stay'],['choose','Memilih','chose to stay'],['decide','Memutuskan','decided to leave'],['deserve','Pantas','deserve to win'],['expect','Mengharapkan','expect to receive'],['fail','Gagal','failed to pass'],['forget','Lupa','forgot to lock'],['hope','Berharap','hope to win'],['intend','Berniat','intend to start'],['learn','Belajar','learning to drive'],['manage','Berhasil','managed to finish'],['need','Perlu','need to study'],['offer','Menawarkan','offered to help'],['persuade','Membujuk','persuaded to go'],['plan','Berencana','plan to build'],['prepare','Bersiap','prepared to leave'],['pretend','Pura-pura','pretended to sleep'],['promise','Berjanji','promised to call'],['refuse','Menolak','refused to answer'],['seem','Tampaknya','seem to agree'],['tend','Cenderung','tend to rise'],['want','Ingin','want to go'],['warn','Memperingatkan','warned to be careful'],['wish','Berharap','wish to speak']]; @endphp
                                    @foreach($inf as $r)<tr class="odd:bg-white even:bg-blue-50"><td class="p-1.5 font-medium">{{ $r[0] }}</td><td class="p-1.5 text-gray-600">{{ $r[1] }}</td><td class="p-1.5 italic text-gray-700">{{ $r[2] }}</td></tr>@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h2 class="font-bold text-white bg-purple-500 p-2 rounded-t-lg text-center text-sm">Complex Ditransitive / Bare Infinitive (V1)</h2>
                        <table class="w-full text-xs border border-purple-200 rounded-b-lg overflow-hidden">
                            <thead class="bg-purple-50 text-purple-800"><tr><th class="p-2">Verb</th><th class="p-2">Arti</th><th class="p-2">Example</th></tr></thead>
                            <tbody class="divide-y divide-purple-100">
                                @php
                                    $cx = [
                                        ['Make', 'Membuat / Memaksa', 'made him <strong class="text-purple-600 font-bold">clean</strong> the room'],
                                        ['Let', 'Membiarkan', 'let the kids <strong class="text-purple-600 font-bold">play</strong> outside'],
                                        ['Have', 'Menyuruh', 'had the assistant <strong class="text-purple-600 font-bold">print</strong> it'],
                                        ['Help', 'Membantu', 'helped me <strong class="text-purple-600 font-bold">solve</strong> the issue'],
                                        ['See', 'Melihat', 'saw the plane <strong class="text-purple-600 font-bold">land</strong> safely'],
                                        ['Hear', 'Mendengar', 'heard the baby <strong class="text-purple-600 font-bold">cry</strong>'],
                                        ['Watch', 'Memperhatikan', 'watched the sun <strong class="text-purple-600 font-bold">rise</strong>'],
                                        ['Notice', 'Menyadari', 'noticed him <strong class="text-purple-600 font-bold">enter</strong>'],
                                        ['Feel', 'Merasakan', 'felt the ground <strong class="text-purple-600 font-bold">shake</strong>'],
                                        ['Observe', 'Mengamati', 'observed the cells <strong class="text-purple-600 font-bold">divide</strong>']
                                    ];
                                @endphp
                                @foreach($cx as $r)<tr class="odd:bg-white even:bg-purple-50"><td class="p-1.5 font-medium">{{ $r[0] }}</td><td class="p-1.5 text-gray-600">{{ $r[1] }}</td><td class="p-1.5 text-gray-700">{!! $r[2] !!}</td></tr>@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tenses Chart (rendered inline per-view via openTenses) --}}
    <slot name="tenses-button" />

    {{-- Lesson Chart (rendered inline per-view via openLesson) --}}
    <slot name="lesson-button" />

    {{-- Irregular Verbs --}}
    <x-irregular-verbs-button />

</div>
