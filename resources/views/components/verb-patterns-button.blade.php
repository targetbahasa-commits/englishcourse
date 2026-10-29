<!-- Verb Patterns Floating Button Component -->
<div x-data="{
    verbPatternsOpen: false,
    x: window.innerWidth - 260,
    y: window.innerHeight - 300,
    dragging: false,
    offset: { x: 0, y: 0 },
    hasMoved: false,
    init() {
        window.addEventListener('resize', () => {
            this.x = Math.min(this.x, window.innerWidth - 60);
            this.y = Math.min(this.y, window.innerHeight - 60);
        });
    },
    startDrag(e) {
        this.dragging = true;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        if (!this.hasMoved) {
            const rect = e.currentTarget.getBoundingClientRect();
            this.x = rect.left;
            this.y = rect.top;
            this.hasMoved = true;
        }
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
            this.verbPatternsOpen = true;
        }
    }
}">

    <!-- Verb Patterns Button -->
    <button @click="verbPatternsOpen = true"
            title="Verb Palsu (Verb Patterns)"
            class="bg-sky-500 hover:bg-sky-600 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
        <span class="hidden sm:inline">Verb Palsu</span>
    </button>

    <!-- Verb Patterns Modal Backdrop -->
    <div x-show="verbPatternsOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         style="display: none;">
      
        <!-- Modal Content -->
        <div @click.outside="verbPatternsOpen = false"
             class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[85vh] flex flex-col overflow-hidden cursor-auto">
          
            <!-- Header -->
            <div class="p-6 border-b border-blue-100 flex justify-between items-center bg-blue-50">
                <h3 class="text-xl font-bold text-tb-primary">Verb Patterns Guide (Gerund, To-Infinitive & Complex Ditransitive)</h3>
                <button @click="verbPatternsOpen = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Content Container -->
            <div class="overflow-y-auto px-6 pb-6" style="max-height: 65vh;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                    <!-- Verb + Gerund Section -->
                    <div>
                        <h2 class="text-lg font-bold text-white bg-green-500 p-3 rounded-t-lg text-center shadow-md">Verb + Gerund (V-ing)</h2>
                        <div class="border border-green-200 rounded-b-lg overflow-hidden shadow-sm">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-green-50 text-green-800 font-semibold border-b border-green-200">
                                    <tr>
                                        <th class="p-3">Verb</th>
                                        <th class="p-3">Arti</th>
                                        <th class="p-3">Example</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-green-100">
                                    @php
                                        $gerunds = [
                                            ['admit', 'Mengakui', 'She admitted <strong class="text-green-600">stealing</strong> money.'],
                                            ['advise', 'Menyarankan', 'Doctor advised <strong class="text-green-600">resting</strong>.'],
                                            ['allow', 'Mengizinkan', 'Rules don\'t allow <strong class="text-green-600">smoking</strong>.'],
                                            ['anticipate', 'Mengantisipasi', 'We anticipate <strong class="text-green-600">meeting</strong> you.'],
                                            ['appreciate', 'Menghargai', 'I appreciate <strong class="text-green-600">helping</strong> me.'],
                                            ['avoid', 'Menghindari', 'They avoid <strong class="text-green-600">eating</strong> junk.'],
                                            ['consider', 'Mempertimbangkan', 'He considers <strong class="text-green-600">moving</strong>.'],
                                            ['can\'t stand', 'Tidak tahan', 'I can\'t stand <strong class="text-green-600">waiting</strong>.'],
                                            ['celebrate', 'Merayakan', 'They celebrated <strong class="text-green-600">winning</strong>.'],
                                            ['confess', 'Mengaku', 'He confessed <strong class="text-green-600">cheating</strong>.'],
                                            ['delay', 'Menunda', 'Don\'t delay <strong class="text-green-600">starting</strong>.'],
                                            ['deny', 'Menyangkal', 'He denied <strong class="text-green-600">breaking</strong> it.'],
                                            ['discuss', 'Membahas', 'We discussed <strong class="text-green-600">going</strong> there.'],
                                            ['dislike', 'Tidak suka', 'She dislikes <strong class="text-green-600">cooking</strong>.'],
                                            ['enjoy', 'Menikmati', 'I enjoy <strong class="text-green-600">reading</strong>.'],
                                            ['escape', 'Melarikan diri', 'He escaped <strong class="text-green-600">being caught</strong>.'],
                                            ['finish', 'Menyelesaikan', 'She finished <strong class="text-green-600">working</strong>.'],
                                            ['imagine', 'Membayangkan', 'Imagine <strong class="text-green-600">living</strong> there.'],
                                            ['involve', 'Melibatkan', 'Job involves <strong class="text-green-600">travelling</strong>.'],
                                            ['justify', 'Membenarkan', 'Can\'t justify <strong class="text-green-600">spending</strong> more.'],
                                            ['keep', 'Terus/Menjaga', 'Keep <strong class="text-green-600">learning</strong>!'],
                                            ['mention', 'Menyebutkan', 'He mentioned <strong class="text-green-600">helping</strong>.'],
                                            ['mind', 'Keberatan', 'Mind <strong class="text-green-600">opening</strong> the door?'],
                                            ['miss', 'Merindukan', 'I miss <strong class="text-green-600">talking</strong> to you.'],
                                            ['postpone', 'Menunda', 'Postponed <strong class="text-green-600">meeting</strong> us.'],
                                            ['practice', 'Berlatih', 'Practices <strong class="text-green-600">speaking</strong>.'],
                                            ['prevent', 'Mencegah', 'Rain prevented <strong class="text-green-600">playing</strong>.'],
                                            ['quit', 'Berhenti', 'She quit <strong class="text-green-600">smoking</strong>.'],
                                            ['recall', 'Mengingat', 'I don\'t recall <strong class="text-green-600">seeing</strong> him.'],
                                            ['recommend', 'Merekomendasikan', 'Recommend <strong class="text-green-600">studying</strong>.'],
                                            ['resist', 'Menahan diri', 'Can\'t resist <strong class="text-green-600">eating</strong>.'],
                                            ['resume', 'Melanjutkan', 'We resumed <strong class="text-green-600">working</strong>.'],
                                            ['risk', 'Berisiko', 'Risk <strong class="text-green-600">losing</strong> all.'],
                                            ['suggest', 'Menyarankan', 'Suggest <strong class="text-green-600">taking</strong> break.'],
                                            ['tolerate', 'Mentolerir', 'Don\'t tolerate <strong class="text-green-600">cheating</strong>.'],
                                            ['understand', 'Mengerti', 'Understand <strong class="text-green-600">not going</strong>.']
                                        ];
                                    @endphp
                                    @foreach($gerunds as $row)
                                        <tr class="odd:bg-white even:bg-green-50 hover:bg-green-100 transition-colors">
                                            <td class="p-2 font-medium text-gray-800 border-r border-green-100">{{ $row[0] }}</td>
                                            <td class="p-2 text-gray-600 border-r border-green-100">{{ $row[1] }}</td>
                                            <td class="p-2 text-gray-700">{!! $row[2] !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Verb + To-Infinitive Section -->
                    <div>
                        <h2 class="text-lg font-bold text-white bg-blue-500 p-3 rounded-t-lg text-center shadow-md">Verb + To-Infinitive (to + V1)</h2>
                        <div class="border border-blue-200 rounded-b-lg overflow-hidden shadow-sm">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-blue-50 text-blue-800 font-semibold border-b border-blue-200">
                                    <tr>
                                        <th class="p-3">Verb</th>
                                        <th class="p-3">Arti</th>
                                        <th class="p-3">Example</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-blue-100">
                                    @php
                                        $infinitives = [
                                            ['agree', 'Setuju', 'They agreed <strong class="text-blue-600">to cooperate</strong>.'],
                                            ['aim', 'Bertujuan', 'We aim <strong class="text-blue-600">to finish</strong> early.'],
                                            ['allow', 'Mengizinkan', 'Rules allow us <strong class="text-blue-600">to enter</strong>.'],
                                            ['appear', 'Tampak', 'He appears <strong class="text-blue-600">to be</strong> tired.'],
                                            ['arrange', 'Mengatur', 'We arranged <strong class="text-blue-600">to meet</strong>.'],
                                            ['ask', 'Meminta', 'I asked him <strong class="text-blue-600">to stay</strong>.'],
                                            ['attempt', 'Mencoba', 'He attempted <strong class="text-blue-600">to escape</strong>.'],
                                            ['cause', 'Menyebabkan', 'Rain caused us <strong class="text-blue-600">to delay</strong>.'],
                                            ['choose', 'Memilih', 'She chose <strong class="text-blue-600">to stay</strong> home.'],
                                            ['claim', 'Mengklaim', 'He claims <strong class="text-blue-600">to know</strong> her.'],
                                            ['convince', 'Meyakinkan', 'I convinced him <strong class="text-blue-600">to join</strong>.'],
                                            ['decide', 'Memutuskan', 'She decided <strong class="text-blue-600">to leave</strong>.'],
                                            ['deserve', 'Pantas', 'You deserve <strong class="text-blue-600">to win</strong>.'],
                                            ['desire', 'Menginginkan', 'I desire <strong class="text-blue-600">to know</strong> more.'],
                                            ['enable', 'Memungkinkan', 'This enables us <strong class="text-blue-600">to work</strong> faster.'],
                                            ['expect', 'Mengharapkan', 'I expect <strong class="text-blue-600">to receive</strong> it.'],
                                            ['fail', 'Gagal', 'He failed <strong class="text-blue-600">to pass</strong>.'],
                                            ['forget', 'Lupa', 'She forgot <strong class="text-blue-600">to lock</strong> it.'],
                                            ['hope', 'Berharap', 'We hope <strong class="text-blue-600">to win</strong>.'],
                                            ['instruct', 'Menginstruksikan', 'Teacher instructed us <strong class="text-blue-600">to read</strong>.'],
                                            ['intend', 'Berniat', 'I intend <strong class="text-blue-600">to start</strong>.'],
                                            ['know (how)', 'Tahu (cara)', 'I know <strong class="text-blue-600">how to drive</strong>.'],
                                            ['learn', 'Belajar', 'I am learning <strong class="text-blue-600">to drive</strong>.'],
                                            ['learn (how)', 'Belajar (cara)', 'Learn <strong class="text-blue-600">how to swim</strong>.'],
                                            ['manage', 'Berhasil', 'She managed <strong class="text-blue-600">to finish</strong>.'],
                                            ['need', 'Perlu', 'You need <strong class="text-blue-600">to study</strong>.'],
                                            ['offer', 'Menawarkan', 'He offered <strong class="text-blue-600">to help</strong>.'],
                                            ['permit', 'Mengizinkan', 'Law permits us <strong class="text-blue-600">to vote</strong>.'],
                                            ['persuade', 'Membujuk', 'She persuaded me <strong class="text-blue-600">to go</strong>.'],
                                            ['plan', 'Berencana', 'They plan <strong class="text-blue-600">to build</strong> it.'],
                                            ['prepare', 'Bersiap', 'We prepared <strong class="text-blue-600">to leave</strong>.'],
                                            ['pretend', 'Pura-pura', 'He pretended <strong class="text-blue-600">to sleep</strong>.'],
                                            ['promise', 'Berjanji', 'She promised <strong class="text-blue-600">to call</strong>.'],
                                            ['refuse', 'Menolak', 'She refused <strong class="text-blue-600">to answer</strong>.'],
                                            ['require', 'Memerlukan', 'Job requires you <strong class="text-blue-600">to travel</strong>.'],
                                            ['seem', 'Tampaknya', 'They seem <strong class="text-blue-600">to agree</strong>.'],
                                            ['swear', 'Bersumpah', 'He swore <strong class="text-blue-600">to tell</strong> truth.'],
                                            ['teach (how)', 'Mengajar (cara)', 'She taught me <strong class="text-blue-600">how to cook</strong>.'],
                                            ['tell', 'Memberitahu', 'I told him <strong class="text-blue-600">to wait</strong>.'],
                                            ['tend', 'Cenderung', 'Prices tend <strong class="text-blue-600">to rise</strong>.'],
                                            ['use', 'Menggunakan', 'We use tools <strong class="text-blue-600">to build</strong>.'],
                                            ['vote', 'Memilih (voting)', 'They voted <strong class="text-blue-600">to accept</strong> it.'],
                                            ['want', 'Ingin', 'I want <strong class="text-blue-600">to go</strong> home.'],
                                            ['warn', 'Memperingatkan', 'I warned him <strong class="text-blue-600">to be</strong> careful.'],
                                            ['wish', 'Berharap', 'I wish <strong class="text-blue-600">to speak</strong>.'],
                                            ['would like', 'Ingin', 'I would like <strong class="text-blue-600">to order</strong>.']
                                        ];
                                    @endphp
                                    @foreach($infinitives as $row)
                                        <tr class="odd:bg-white even:bg-blue-50 hover:bg-blue-100 transition-colors">
                                            <td class="p-2 font-medium text-gray-800 border-r border-blue-100">{{ $row[0] }}</td>
                                            <td class="p-2 text-gray-600 border-r border-blue-100">{{ $row[1] }}</td>
                                            <td class="p-2 text-gray-700">{!! $row[2] !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Complex Ditransitive Section -->
                <div class="mt-8">
                    <h2 class="text-lg font-bold text-white bg-purple-500 p-3 rounded-t-lg text-center shadow-md">Complex Ditransitive Verbs (Bare Infinitive / V1)</h2>
                    <div class="border border-purple-200 rounded-b-lg overflow-hidden shadow-sm">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-purple-50 text-purple-800 font-semibold border-b border-purple-200">
                                <tr>
                                    <th class="p-3">Verb</th>
                                    <th class="p-3">Arti</th>
                                    <th class="p-3">Example</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-purple-100">
                                @php
                                    $complex = [
                                        ['Make', 'Membuat / Memaksa', 'A sudden noise can make a golfer <strong class="text-purple-600 font-bold">miss</strong> the shot.'],
                                        ['Let', 'Membiarkan / Mengizinkan', 'They let the students <strong class="text-purple-600 font-bold">leave</strong> the room early.'],
                                        ['Have', 'Menyuruh / Meminta', 'The manager had the assistant <strong class="text-purple-600 font-bold">print</strong> the document.'],
                                        ['Help', 'Membantu', 'She helped him <strong class="text-purple-600 font-bold">solve</strong> the difficult problem.'],
                                        ['See', 'Melihat', 'We saw the plane <strong class="text-purple-600 font-bold">land</strong> safely on the runway.'],
                                        ['Hear', 'Mendengar', 'They heard someone <strong class="text-purple-600 font-bold">knock</strong> on the front door.'],
                                        ['Watch', 'Menonton / Memperhatikan', 'The tourists watched the sun <strong class="text-purple-600 font-bold">rise</strong> over the mountain.'],
                                        ['Notice', 'Memperhatikan / Menyadari', 'I noticed the man <strong class="text-purple-600 font-bold">enter</strong> the building quietly.'],
                                        ['Feel', 'Merasakan', 'The residents felt the ground <strong class="text-purple-600 font-bold">shake</strong> during the earthquake.'],
                                        ['Observe', 'Mengamati', 'The scientist observed the cells <strong class="text-purple-600 font-bold">divide</strong> under the microscope.'],
                                        ['Listen to', 'Mendengarkan', 'We listened to the choir <strong class="text-purple-600 font-bold">sing</strong> our favorite song.'],
                                        ['Bid', 'Menyuruh / Memerintahkan', 'The general bade the soldiers <strong class="text-purple-600 font-bold">retreat</strong> immediately.'],
                                    ];
                                @endphp
                                @foreach($complex as $row)
                                    <tr class="odd:bg-white even:bg-purple-50 hover:bg-purple-100 transition-colors">
                                        <td class="p-2 font-medium text-gray-800 border-r border-purple-100">{{ $row[0] }}</td>
                                        <td class="p-2 text-gray-600 border-r border-purple-100">{{ $row[1] }}</td>
                                        <td class="p-2 text-gray-700">{!! $row[2] !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="p-4 bg-blue-50 border-t border-blue-100 text-center">
                <p class="text-sm text-gray-700 font-medium">
                    💡 Gunakan tabel ini untuk menentukan apakah verb diikuti oleh Gerund (V-ing), To-Infinitive (to + V1), atau Bare Infinitive (V1).
                </p>
            </div>
        </div>
    </div>
</div>
