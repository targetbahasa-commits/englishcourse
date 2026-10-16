@if(!defined('IELTS_C18_READING_TEST_4_EVALUATOR_INCLUDED'))
@php define('IELTS_C18_READING_TEST_4_EVALUATOR_INCLUDED', true); @endphp

{{-- ===================================================================
     IELTS Reading Test Evaluator (Cambridge 18 Test 4)
     Auto-generated complete evaluator with full answer keys, quotes,
     Indonesian explanations, band score, modal rapor, and cloud sync.
     =================================================================== --}}

<!-- Modal Konfirmasi Soal Belum Terjawab -->
<div id="evalConfirmModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 border border-gray-100 text-center transform transition-all animate-in fade-in zoom-in-95 duration-200">
        <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Masih Ada Soal Belum Dijawab</h3>
        <p class="text-gray-600 text-sm mb-6 leading-relaxed" id="evalConfirmMsg">
            Anda baru menjawab <span id="evalConfirmAnswered" class="font-bold text-gray-900">0</span> dari 40 soal. Masih ada <span id="evalConfirmUnanswered" class="font-bold text-amber-600">0</span> soal yang kosong.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button type="button" onclick="closeEvalConfirmModal()" class="w-full sm:w-1/2 px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">
                Periksa Kembali
            </button>
            <button type="button" onclick="confirmSubmitAnyway()" class="w-full sm:w-1/2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold text-sm shadow-md transition">
                Ya, Kumpulkan
            </button>
        </div>
    </div>
</div>

<!-- Modal Hasil Evaluasi Lengkap & Band Score -->
<div id="evalResultModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full my-8 border border-gray-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
        
        {{-- Header Modal --}}
        <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-green-700 p-6 sm:p-8 text-white relative">
            <button type="button" onclick="closeEvalResultModal()" class="absolute top-4 right-4 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-emerald-100 text-xs font-bold uppercase tracking-wider mb-3">
                <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Hasil Evaluasi Mock Test
            </div>
            <h2 class="text-2xl sm:text-3xl font-black mb-1">IELTS Reading – Mock Test 4</h2>
            <p class="text-emerald-100 text-xs sm:text-sm">Cambridge IELTS 18 Academic Practice Test 4</p>

            {{-- Band Score Card --}}
            <div class="mt-6 bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-center sm:text-left">
                    <span class="text-xs uppercase tracking-wider font-semibold text-emerald-100 block">Perkiraan Band Score</span>
                    <div class="text-5xl font-extrabold tracking-tight mt-0.5 text-white" id="modalBandScore">Band -</div>
                    <span class="text-xs font-medium text-emerald-200 mt-1 inline-block" id="modalBandLabel">IELTS Academic Reading Scale</span>
                </div>
                <div class="text-center sm:text-right border-t sm:border-t-0 sm:border-l border-white/20 pt-3 sm:pt-0 sm:pl-6 w-full sm:w-auto">
                    <div class="text-3xl font-extrabold text-white" id="modalCorrectScore">0 / 40</div>
                    <div class="text-xs text-emerald-100 font-medium">Akurasi: <span id="modalAccuracy">0%</span></div>
                </div>
            </div>
        </div>

        {{-- Body Modal --}}
        <div class="p-6 sm:p-8 space-y-6 max-h-[60vh] overflow-y-auto custom-scrollbar">
            
            {{-- Statistik 3 Kartu --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-3.5 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600 mb-0.5" id="modalStatCorrect">0</div>
                    <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wide">Benar</div>
                </div>
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-3.5 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-rose-600 mb-0.5" id="modalStatWrong">0</div>
                    <div class="text-[11px] font-bold text-rose-800 uppercase tracking-wide">Salah</div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-3.5 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-gray-600 mb-0.5" id="modalStatUnanswered">0</div>
                    <div class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Kosong</div>
                </div>
            </div>

            {{-- Grid Nomor Soal 1-40 --}}
            <div>
                <div class="flex items-center justify-between mb-2.5">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Navigasi Nomor Soal</h4>
                    <span class="text-[11px] text-gray-500">Klik nomor untuk menuju ke soal</span>
                </div>
                <div class="grid grid-cols-8 sm:grid-cols-10 gap-1.5" id="modalQuestionGrid">
                    {{-- Diisi secara dinamis oleh JavaScript --}}
                </div>
            </div>

            {{-- Info Petunjuk Pembahasan --}}
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-xs text-blue-900 leading-relaxed">
                    <strong>Pembahasan Lengkap Tersedia di Bawah Setiap Soal!</strong><br>
                    Tutup jendela ini atau klik tombol <em>"Tinjau Pembahasan Soal"</em> di bawah untuk melihat kunci jawaban resmi, status jawaban Anda, kutipan teks asli, dan pembahasan mendalam dalam bahasa Indonesia.
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <button type="button" onclick="confirmResetReadingTest()" class="w-full sm:w-auto px-5 py-2.5 text-rose-600 hover:text-rose-700 bg-white hover:bg-rose-50 border border-rose-200 font-bold text-xs sm:text-sm rounded-xl transition shadow-sm flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Kerjakan Ulang
            </button>
            <div class="flex items-center gap-2.5 w-full sm:w-auto">
                <button type="button" onclick="closeEvalResultModal()" class="flex-1 sm:flex-initial px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold text-xs sm:text-sm rounded-xl transition">
                    Tutup
                </button>
                <button type="button" onclick="reviewAllAnswers()" class="flex-1 sm:flex-initial px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition flex items-center justify-center gap-1.5">
                    <span>Tinjau Pembahasan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    if (window.__c18ReadingTest4EvaluatorLoaded) return;
    window.__c18ReadingTest4EvaluatorLoaded = true;

    const TEST_CONFIG = {
        edition: '18',
        testId: '4',
        skill: 'reading',
        storageKey: `ielts_reading_eval_cambridge_18_test_4_user_{{ Auth::id() ?? "guest" }}`
    };

    const SPECIAL_PAIRS = [
        {
                "name": "q10_11[]",
                "questions": [
                        10,
                        11
                ],
                "validLetters": [
                        "C",
                        "D"
                ]
        },
        {
                "name": "q12_13[]",
                "questions": [
                        12,
                        13
                ],
                "validLetters": [
                        "A",
                        "D"
                ]
        }
];
    const ANSWER_KEYS = {
        "1": {
                "correct": "D",
                "quote": "Section D discusses economic arguments and the concept of 'natural capital' to convince investors.",
                "explanation": "Bagian D menjelaskan pentingnya pertimbangan nilai ekonomi (natural capital) guna meyakinkan para pengembang dan investor."
        },
        "2": {
                "correct": "C",
                "quote": "Section C notes that North American cities benefit from newer buildings capable of holding deeper soil and water.",
                "explanation": "Bagian C menyoroti keunggulan gedung-gedung modern di Amerika Utara yang strukturnya lebih kokoh menampung tanah dan air."
        },
        "3": {
                "correct": "E",
                "quote": "Section E introduces innovative concepts such as water-retaining 'blue roofs' and biodiversity-rich 'brown roofs'.",
                "explanation": "Bagian E memaparkan variasi teknologi baru seperti atap biru penyimpan air dan atap cokelat pemelihara keanekaragaman hayati."
        },
        "4": {
                "correct": "B",
                "quote": "Section B discusses integrating roofs with living walls and drainage systems, as well as mental health therapy.",
                "explanation": "Bagian B menguraikan integrasi atap hijau dengan dinding hijau, sistem drainase kota, serta manfaat terapi kesehatan mental."
        },
        "5": {
                "correct": "D",
                "quote": "Section D mentions that building managers need new landscaping skills and volunteer assistance.",
                "explanation": "Bagian D menyebutkan perlunya keahlian baru seperti pertamanan dan bantuan relawan dalam pemeliharaan atap hijau."
        },
        "6": {
                "correct": "energy",
                "aliases": [
                        "energy costs"
                ],
                "quote": "Among the benefits are saving on energy costs by insulating buildings naturally...",
                "explanation": "Atap hijau memberikan manfaat isolasi termal alami sehingga menghemat biaya pemakaian energi (energy)."
        },
        "7": {
                "correct": "food",
                "quote": "...expansive, accessible and food-producing roofs installed in buildings...",
                "explanation": "Atap gedung dapat dialihfungsikan menjadi lahan pertanian produktif penghasil bahan pangan (food)."
        },
        "8": {
                "correct": "gardening",
                "quote": "Doctors are increasingly prescribing time spent gardening outdoors for patients...",
                "explanation": "Dokter kini kerap meresepkan kegiatan berkebun (gardening) di luar ruangan untuk meredakan depresi dan kecemasan."
        },
        "9": {
                "correct": "obesity",
                "quote": "...access to green spaces can provide a better quality of life and help people avoid obesity.",
                "explanation": "Aktivitas di ruang terbuka hijau terbukti meningkatkan kualitas hidup dan mencegah risiko obesitas (obesity)."
        },
        "10": {
                "correct": "C",
                "aliases": [
                        "D"
                ],
                "quote": "San Francisco requires green roofs on new buildings (C) while Toronto encourages rooftop farms (D).",
                "explanation": "Kota pelopor kebijakan: San Francisco mewajibkan atap hijau (C) dan Toronto mempromosikan kebun atap perkotaan (D)."
        },
        "11": {
                "correct": "D",
                "aliases": [
                        "C"
                ],
                "quote": "San Francisco requires green roofs on new buildings (C) while Toronto encourages rooftop farms (D).",
                "explanation": "Kota pelopor kebijakan: San Francisco mewajibkan atap hijau (C) dan Toronto mempromosikan kebun atap perkotaan (D)."
        },
        "12": {
                "correct": "A",
                "aliases": [
                        "D"
                ],
                "quote": "Newer buildings can hold greater weight for deeper soil (A) and make it easier to distribute water across the roof (D).",
                "explanation": "Keuntungan bangunan baru: mampu menahan beban tanah yang lebih dalam (A) dan memudahkan distribusi pengairan (D)."
        },
        "13": {
                "correct": "D",
                "aliases": [
                        "A"
                ],
                "quote": "Newer buildings can hold greater weight for deeper soil (A) and make it easier to distribute water across the roof (D).",
                "explanation": "Keuntungan bangunan baru: mampu menahan beban tanah yang lebih dalam (A) dan memudahkan distribusi pengairan (D)."
        },
        "14": {
                "correct": "B",
                "quote": "Paragraph B outlines Carol Dweck's experiment dividing children into intelligence-praised vs effort-praised groups.",
                "explanation": "Paragraf B memaparkan eksperimen Carol Dweck yang menguji perbedaan dampak pujian kecerdasan versus pujian usaha kerja keras."
        },
        "15": {
                "correct": "C",
                "quote": "Paragraph C explains that students praised for effort were more willing to tackle challenges without fear of failure.",
                "explanation": "Paragraf C menunjukkan anak yang dipuji usahanya lebih berani mengambil risiko dan tidak takut mengalami kegagalan."
        },
        "16": {
                "correct": "D",
                "quote": "Paragraph D points out that modern school testing and ranking reinforces the fixed mindset climate.",
                "explanation": "Paragraf D mengkritik sistem persekolahan yang terobsesi pada tes nilai angka sehingga melanggengkan pola fixed mindset."
        },
        "17": {
                "correct": "C",
                "quote": "Paragraph E cites statistician Andrew Gelman questioning the methodological rigor of growth mindset studies.",
                "explanation": "Paragraf E mengutip kritik ahli statistik Andrew Gelman mengenai kelonggaran metodologi penelitian growth mindset."
        },
        "18": {
                "correct": "B",
                "quote": "Paragraph E shares Timothy Bates's failure to replicate positive mindset findings in student grades.",
                "explanation": "Paragraf E memaparkan hasil penelitian Timothy Bates yang gagal membuktikan korelasi growth mindset terhadap peningkatan nilai anak."
        },
        "19": {
                "correct": "A",
                "quote": "Alfred Binet developed early IQ tests believing in quantified cognitive capacity.",
                "explanation": "Alfred Binet mengembangkan tes kecerdasan awal dengan pandangan bahwa kemampuan kognitif bersifat bawaan."
        },
        "20": {
                "correct": "E",
                "quote": "John Dewey argued that intelligence could be cultivated given the right educational environment.",
                "explanation": "John Dewey meyakini bahwa kecerdasan setiap anak dapat diasah dan dikembangkan melalui lingkungan pendidikan yang mendukung."
        },
        "21": {
                "correct": "B",
                "quote": "Jeff Howard asserted: 'Smart is not something that you just are, smart is something that you can get.'",
                "explanation": "Jeff Howard menyatakan bahwa kepintaran bukanlah sesuatu yang statis, melainkan dapat diraih melalui kerja keras."
        },
        "22": {
                "correct": "D",
                "quote": "Carol Dweck conducted landmark experiments on fixed vs growth mindsets in California.",
                "explanation": "Carol Dweck mempopulerkan teori growth mindset melalui penelitiannya terhadap anak-anak sekolah di California."
        },
        "23": {
                "correct": "YES",
                "quote": "In the early 20th century, progressive thinkers revolted against the notion that inherent ability is destiny.",
                "explanation": "Benar. Pada awal abad ke-20 para pemikir pendidikan mulai menolak pandangan bahwa bakat bawaan menentukan takdir seseorang."
        },
        "24": {
                "correct": "NO",
                "quote": "Praising ability actually made students perform worse and fear failure, avoiding challenging tasks.",
                "explanation": "Salah. Memuji kecerdasan bawaan anak justru menimbulkan kecemasan dan menurunkan performa belajar mereka."
        },
        "25": {
                "correct": "NOT GIVEN",
                "quote": "The research received harsh criticism from Gelman and others...",
                "explanation": "Teks tidak menyebutkan tanggapan atau bantahan langsung dari Carol Dweck terhadap kritik Andrew Gelman."
        },
        "26": {
                "correct": "YES",
                "quote": "Schools create cognitive dissonance when they applaud growth mindset but hand out fixed target grades.",
                "explanation": "Benar. Banyak sekolah mengampanyekan growth mindset namun praktiknya tetap mematok target nilai yang kaku."
        },
        "27": {
                "correct": "YES",
                "quote": "Plate tectonics is at the heart of Earth sciences today and is a descendant of Alfred Wegener's theory.",
                "explanation": "Benar. Teori lempeng tektonik yang menjadi landasan geosains modern merupakan kelanjutan dari teori pergeseran benua Wegener."
        },
        "28": {
                "correct": "NOT GIVEN",
                "quote": "The author compares plate tectonics to evolutionary theory following Darwin...",
                "explanation": "Teks membandingkan hubungan teori Wegener-tektonik dengan Darwin-evolusi, namun tidak menyebutkan apakah Wegener mengagumi Darwin secara personal."
        },
        "29": {
                "correct": "NO",
                "quote": "He was not a geologist; he trained as an astronomer and pursued a career in atmospheric physics.",
                "explanation": "Salah. Wegener bukanlah seorang ahli geologi; bidang keahlian utamanya adalah astronomi dan fisika atmosfer."
        },
        "30": {
                "correct": "NO",
                "quote": "However, he was not an 'unknown': he had set a world ballooning record and led a Greenland expedition.",
                "explanation": "Salah. Wegener bukan sosok ilmuwan yang tidak dikenal karena ia sudah termasyhur melalui rekor balon udara dan ekspedisi Greenland."
        },
        "31": {
                "correct": "I",
                "quote": "Author of a textbook, Thermodynamics of the Atmosphere (1911).",
                "explanation": "Wegener menulis buku teks ilmiah terkenal berjudul Thermodynamics of the Atmosphere pada tahun 1911."
        },
        "32": {
                "correct": "F",
                "quote": "Readers will see that he often stopped pursuing a given line of investigation only to pick it up later.",
                "explanation": "Karier ilmiah Wegener diwarnai dengan penghentian sementara dan peralihan minat riset yang beragam."
        },
        "33": {
                "correct": "A",
                "quote": "The index should be a sufficient guide for those interested in a particular aspect of Wegener's life.",
                "explanation": "Indeks buku dapat memandu pembaca yang hanya berminat menelusuri bagian karier tertentu dari sang ilmuwan."
        },
        "34": {
                "correct": "C",
                "quote": "Only a few hundred of the many thousands of letters he wrote and received in his lifetime have survived.",
                "explanation": "Hanya sebagian kecil dari ribuan surat-surat (letters) pribadi Wegener yang terselamatkan hingga saat ini."
        },
        "35": {
                "correct": "H",
                "quote": "...and he didn't keep notebooks or diaries that recorded his life and activities.",
                "explanation": "Wegener tidak terbiasa mencatat keseharian dan pergulatan pemikirannya dalam buku harian (diaries)."
        },
        "36": {
                "correct": "E",
                "quote": "Others, like Michael Faraday, left extensive journals of their thoughts and speculations.",
                "explanation": "Michael Faraday dikutip sebagai teladan ilmuwan yang mewariskan catatan jurnal pemikiran yang amat komprehensif."
        },
        "37": {
                "correct": "B",
                "quote": "We plan, think, and act with apparent freedom, but most of the time our lives 'happen to us'.",
                "explanation": "Penulis mengemukakan bahwa kebebasan bertindak manusia kerap kali bersinggungan dengan kejadian tak terduga."
        },
        "38": {
                "correct": "A",
                "quote": "This book is a story of the work that Wegener planned and intended...",
                "explanation": "Buku biografi ini mengupas hal-hal yang semula direncanakan dan ditargetkan oleh Alfred Wegener."
        },
        "39": {
                "correct": "D",
                "quote": "...and of the life and scientific work that actually 'happened to him'.",
                "explanation": "Buku ini juga menyandingkannya dengan kenyataan dan dinamika yang benar-benar terjadi dalam hidupnya."
        },
        "40": {
                "correct": "C",
                "quote": "Urging readers to experience all of his activities taken together as a coherent narrative.",
                "explanation": "Penulis mengajak pembaca memahami keseluruhan riwayat hidup dan karya Wegener sebagai satu kesatuan yang utuh."
        }
};

    function calculateIeltsBandScore(score) {
        if (score >= 39) return { band: 9.0, label: "Expert User" };
        if (score >= 37) return { band: 8.5, label: "Very Good User+" };
        if (score >= 35) return { band: 8.0, label: "Very Good User" };
        if (score >= 33) return { band: 7.5, label: "Good User+" };
        if (score >= 30) return { band: 7.0, label: "Good User" };
        if (score >= 27) return { band: 6.5, label: "Competent User+" };
        if (score >= 23) return { band: 6.0, label: "Competent User" };
        if (score >= 19) return { band: 5.5, label: "Modest User+" };
        if (score >= 15) return { band: 5.0, label: "Modest User" };
        if (score >= 13) return { band: 4.5, label: "Limited User+" };
        if (score >= 10) return { band: 4.0, label: "Limited User" };
        if (score >= 8)  return { band: 3.5, label: "Extremely Limited User" };
        if (score >= 6)  return { band: 3.0, label: "Extremely Limited User" };
        if (score >= 4)  return { band: 2.5, label: "Intermittent User" };
        return { band: 2.0, label: "Non User" };
    }

    function normalizeText(txt) {
        if (!txt) return "";
        return String(txt)
            .trim()
            .toLowerCase()
            .replace(/[\.,\/#!$%\^&\*;:{}=\-_`~()]/g, "")
            .replace(/\s+/g, " ")
            .trim();
    }

    function checkAnswerMatch(userVal, keyObj) {
        if (!userVal || !keyObj) return false;
        const normUser = normalizeText(userVal);
        const normCorrect = normalizeText(keyObj.correct);
        if (normUser === normCorrect) return true;

        if (keyObj.aliases && Array.isArray(keyObj.aliases)) {
            for (const alias of keyObj.aliases) {
                if (normUser === normalizeText(alias)) return true;
            }
        }
        return false;
    }

    function getUserAnswers() {
        const answers = {};
        for (let i = 1; i <= 40; i++) {
            // Select input
            const sel = document.querySelector(`select[name="q${i}"]`);
            if (sel && sel.value) {
                answers[i] = sel.value.trim();
                continue;
            }

            // Text input
            const txt = document.querySelector(`input[type="text"][name="q${i}"]`);
            if (txt && txt.value) {
                answers[i] = txt.value.trim();
                continue;
            }

            // Radio input
            const rad = document.querySelector(`input[type="radio"][name="q${i}"]:checked`);
            if (rad && rad.value) {
                answers[i] = rad.value.trim();
                continue;
            }
        }

        // Handle special checkbox pairs (e.g. q23_24[])
        for (const pair of SPECIAL_PAIRS) {
            const checkedBoxes = Array.from(document.querySelectorAll(`input[name="${pair.name}"]:checked`)).map(cb => cb.value.trim().toUpperCase());
            pair.questions.forEach((qNum, idx) => {
                answers[qNum] = checkedBoxes[idx] || "";
            });
        }

        return answers;
    }

    window.evaluateReadingAnswers = function(skipConfirm = false) {
        const userAnswers = getUserAnswers();
        
        let answeredCount = 0;
        for (let i = 1; i <= 40; i++) {
            if (userAnswers[i] && String(userAnswers[i]).trim() !== "") {
                answeredCount++;
            }
        }
        const unansweredCount = 40 - answeredCount;

        if (!skipConfirm && unansweredCount > 0) {
            document.getElementById('evalConfirmAnswered').innerText = answeredCount;
            document.getElementById('evalConfirmUnanswered').innerText = unansweredCount;
            document.getElementById('evalConfirmModal').classList.remove('hidden');
            return;
        }

        let correctScore = 0;
        const details = {};
        const pairedQNums = SPECIAL_PAIRS.reduce((acc, p) => acc.concat(p.questions), []);

        for (let i = 1; i <= 40; i++) {
            if (pairedQNums.includes(i)) continue;

            const keyObj = ANSWER_KEYS[i];
            const userVal = userAnswers[i] || "";
            const isCorrect = keyObj ? checkAnswerMatch(userVal, keyObj) : false;
            if (isCorrect) correctScore++;

            details[i] = {
                userAnswer: userVal,
                correctAnswer: keyObj ? keyObj.correct : "",
                isCorrect: isCorrect,
                isUnanswered: !userVal || String(userVal).trim() === ""
            };
        }

        // Evaluate checkbox pairs (order doesn't matter)
        for (const pair of SPECIAL_PAIRS) {
            const userChoices = Array.from(document.querySelectorAll(`input[name="${pair.name}"]:checked`))
                .map(cb => cb.value.trim().toUpperCase());
            const validLetters = pair.validLetters.map(l => l.trim().toUpperCase());
            const matchedCorrect = userChoices.filter(c => validLetters.includes(c));

            pair.questions.forEach((qNum, idx) => {
                const isPairCorrect = idx < matchedCorrect.length;
                if (isPairCorrect) correctScore++;
                details[qNum] = {
                    userAnswer: userChoices[idx] || "",
                    correctAnswer: validLetters.join(" atau "),
                    isCorrect: isPairCorrect,
                    isUnanswered: userChoices.length <= idx
                };
            });
        }

        const bandObj = calculateIeltsBandScore(correctScore);
        const evalResult = {
            score: correctScore,
            total: 40,
            band_score: bandObj.band,
            band_label: bandObj.label,
            details: details,
            evaluated_at: new Date().toISOString()
        };

        try {
            localStorage.setItem(TEST_CONFIG.storageKey, JSON.stringify(evalResult));
        } catch (e) {}

        syncResultToCloud(evalResult, userAnswers);
        renderInlineExplanations(evalResult);
        renderResultModal(evalResult);
        updateHeaderBadge(evalResult);
        openEvalResultModal();
    };

    window.closeEvalConfirmModal = function() {
        document.getElementById('evalConfirmModal').classList.add('hidden');
    };

    window.confirmSubmitAnyway = function() {
        closeEvalConfirmModal();
        window.evaluateReadingAnswers(true);
    };

    window.openEvalResultModal = function() {
        document.getElementById('evalResultModal').classList.remove('hidden');
    };

    window.closeEvalResultModal = function() {
        document.getElementById('evalResultModal').classList.add('hidden');
    };

    window.reviewAllAnswers = function() {
        closeEvalResultModal();
        const firstWrong = document.querySelector('.eval-feedback-card.border-rose-300, .eval-feedback-card');
        if (firstWrong) {
            firstWrong.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    };

    window.scrollToQuestion = function(num) {
        closeEvalResultModal();
        let target = document.getElementById(`eval-feedback-${num}`) || 
                     document.querySelector(`[name="q${num}"]`);
        if (!target) {
            for (const p of SPECIAL_PAIRS) {
                if (p.questions.includes(num)) {
                    target = document.querySelector(`input[name="${p.name}"]`);
                    break;
                }
            }
        }
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            target.classList.add('ring-4', 'ring-emerald-400', 'transition-all');
            setTimeout(() => target.classList.remove('ring-4', 'ring-emerald-400'), 2000);
        }
    };

    function renderResultModal(res) {
        document.getElementById('modalBandScore').innerText = `Band ${res.band_score.toFixed(1)}`;
        document.getElementById('modalBandLabel').innerText = `${res.band_label} – Skala Resmi IELTS Academic`;
        document.getElementById('modalCorrectScore').innerText = `${res.score} / ${res.total}`;
        const pct = Math.round((res.score / res.total) * 100);
        document.getElementById('modalAccuracy').innerText = `${pct}%`;

        let wrongCount = 0;
        let emptyCount = 0;
        for (let i = 1; i <= 40; i++) {
            if (!res.details[i] || res.details[i].isUnanswered) emptyCount++;
            else if (!res.details[i].isCorrect) wrongCount++;
        }
        document.getElementById('modalStatCorrect').innerText = res.score;
        document.getElementById('modalStatWrong').innerText = wrongCount;
        document.getElementById('modalStatUnanswered').innerText = emptyCount;

        const grid = document.getElementById('modalQuestionGrid');
        grid.innerHTML = '';
        for (let i = 1; i <= 40; i++) {
            const d = res.details[i] || { isCorrect: false, isUnanswered: true };
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.onclick = () => scrollToQuestion(i);
            btn.className = `py-2 rounded-xl text-xs font-black transition transform hover:scale-105 active:scale-95 shadow-xs flex flex-col items-center justify-center ${
                d.isCorrect 
                    ? 'bg-emerald-500 hover:bg-emerald-600 text-white' 
                    : (d.isUnanswered ? 'bg-gray-200 hover:bg-gray-300 text-gray-700' : 'bg-rose-500 hover:bg-rose-600 text-white')
            }`;
            btn.innerHTML = `<span>${i}</span><span class="text-[9px] font-bold opacity-80">${d.isCorrect ? '✓' : (d.isUnanswered ? '-' : '✗')}</span>`;
            grid.appendChild(btn);
        }
    }

    function renderInlineExplanations(res) {
        document.querySelectorAll('.eval-feedback-card').forEach(el => el.remove());
        document.querySelectorAll('.eval-feedback-row').forEach(el => el.remove());

        for (let i = 1; i <= 40; i++) {
            const d = res.details[i];
            const keyObj = ANSWER_KEYS[i];
            if (!keyObj || !d) continue;

            let anchor = null;
            let isSpecialPair = false;

            for (const pair of SPECIAL_PAIRS) {
                if (pair.questions.includes(i)) {
                    anchor = document.querySelector(`input[name="${pair.name}"]`)?.closest('.bg-white');
                    isSpecialPair = true;
                    break;
                }
            }

            if (!anchor) {
                const el = document.querySelector(`[name="q${i}"]`);
                if (el) {
                    anchor = el.closest('tr') || el.closest('.mb-4') || el.closest('.flex-col') || el.closest('.flex') || el.closest('p') || el.parentElement;
                }
            }
            if (!anchor) continue;

            // Highlight input border
            const inputEl = document.querySelector(`[name="q${i}"]`);
            if (inputEl) {
                inputEl.classList.remove('border-emerald-500', 'border-rose-500', 'border-gray-300', 'bg-emerald-50', 'bg-rose-50');
                if (d.isCorrect) {
                    inputEl.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-900');
                } else {
                    inputEl.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-900');
                }
            }

            // Avoid double cards for pair questions if already rendered
            if (isSpecialPair && document.getElementById(`eval-feedback-${i}`)) {
                continue;
            }

            const card = document.createElement('div');
            card.id = `eval-feedback-${i}`;
            card.className = `eval-feedback-card mt-3 p-4 rounded-2xl border text-xs leading-relaxed transition-all ${
                d.isCorrect 
                    ? 'bg-emerald-50/80 border-emerald-300 text-emerald-950' 
                    : (d.isUnanswered ? 'bg-amber-50/80 border-amber-300 text-amber-950' : 'bg-rose-50/80 border-rose-300 text-rose-950')
            }`;

            const badgeHtml = d.isCorrect
                ? `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-600 text-white font-bold text-[11px]"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Benar</span>`
                : (d.isUnanswered
                    ? `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-500 text-white font-bold text-[11px]"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Belum Dijawab</span>`
                    : `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-rose-600 text-white font-bold text-[11px]"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg> Salah</span>`);

            card.innerHTML = `
                <div class="flex items-center justify-between gap-2 mb-2 pb-2 border-b border-black/10">
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-sm text-gray-900">Nomor ${i}</span>
                        ${badgeHtml}
                    </div>
                    <div class="text-[11px] text-gray-600">
                        Kunci Jawaban Resmi: <strong class="text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded font-mono font-bold">${keyObj.correct}</strong>
                    </div>
                </div>
                ${!d.isCorrect && !d.isUnanswered ? `<div class="mb-2 text-rose-700 font-semibold">Jawaban Anda: <span class="line-through font-mono">${d.userAnswer}</span></div>` : ''}
                ${keyObj.quote ? `<div class="mb-2 p-2.5 bg-white/70 rounded-xl border border-black/5 italic text-gray-700 font-['Georgia',serif]">"${keyObj.quote}"</div>` : ''}
                <div class="text-gray-800">
                    <strong class="text-gray-900 block mb-1">💡 Pembahasan:</strong>
                    ${keyObj.explanation}
                </div>
            `;

            if (anchor.tagName === 'TR') {
                const tr = document.createElement('tr');
                tr.className = 'eval-feedback-row bg-transparent';
                const td = document.createElement('td');
                td.colSpan = anchor.children.length || 3;
                td.className = 'p-0 pb-3';
                td.appendChild(card);
                tr.appendChild(td);
                anchor.parentNode.insertBefore(tr, anchor.nextSibling);
            } else {
                anchor.parentNode.insertBefore(card, anchor.nextSibling);
            }
        }

        // Summary inline panel near submit button
        const submitContainer = document.getElementById('submitReadingBtnContainer');
        if (submitContainer) {
            let summaryPanel = document.getElementById('evalInlineSummaryPanel');
            if (!summaryPanel) {
                summaryPanel = document.createElement('div');
                summaryPanel.id = 'evalInlineSummaryPanel';
                summaryPanel.className = 'mt-6 bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-300 rounded-3xl p-6 shadow-md';
                submitContainer.parentNode.insertBefore(summaryPanel, submitContainer.nextSibling);
            }
            summaryPanel.innerHTML = `
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-center sm:text-left">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white flex flex-col items-center justify-center font-black shadow-md flex-none">
                            <span class="text-[10px] uppercase font-bold tracking-widest text-emerald-200">BAND</span>
                            <span class="text-2xl leading-none">${res.band_score.toFixed(1)}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Hasil Evaluasi: ${res.score}/40 Benar (${Math.round((res.score/40)*100)}%)</h3>
                            <p class="text-xs text-gray-600 mt-0.5">${res.band_label || 'IELTS Reading Scale'} • Penjelasan lengkap dan kutipan bacaan telah ditampilkan pada tiap nomor.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 w-full sm:w-auto">
                        <button type="button" onclick="confirmResetReadingTest()" class="flex-1 sm:flex-initial px-4 py-2 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 font-bold text-xs rounded-xl shadow-xs transition">
                            Kerjakan Ulang
                        </button>
                        <button type="button" onclick="openEvalResultModal()" class="flex-1 sm:flex-initial px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                            Lihat Rapor Lengkap
                        </button>
                    </div>
                </div>
            `;
            summaryPanel.classList.remove('hidden');
        }
    }

    function updateHeaderBadge(res) {
        const badge = document.getElementById('headerScoreBadge');
        const badgeText = document.getElementById('headerScoreBadgeText') || document.getElementById('headerScoreText');
        if (badge && badgeText) {
            badgeText.innerText = `Band ${res.band_score.toFixed(1)} (${res.score}/${res.total})`;
            badge.classList.remove('hidden');
            badge.classList.add('flex');
        }
    }

    function syncResultToCloud(evalResult, userAnswers) {
        fetch('{{ \Illuminate\Support\Facades\Route::has("cambridge.mockup.save-result") ? route("cambridge.mockup.save-result") : url("/cambridge-mockup/save-result") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                edition: TEST_CONFIG.edition,
                test_id: TEST_CONFIG.testId,
                skill: TEST_CONFIG.skill,
                score: evalResult.score,
                total_questions: evalResult.total,
                band_score: evalResult.band_score,
                answers: userAnswers,
                evaluation_details: evalResult.details
            })
        })
        .then(res => res.json())
        .catch(err => console.warn('[C18Test4Evaluator] Cloud sync result failed:', err));
    }

    window.confirmResetReadingTest = function() {
        if (!confirm('Apakah Anda yakin ingin mengulang ujian ini? Seluruh jawaban dan hasil evaluasi akan direset.')) {
            return;
        }

        try {
            localStorage.removeItem(TEST_CONFIG.storageKey);
            localStorage.removeItem(`ielts_reading_cambridge_18_test_4_user_{{ Auth::id() ?? "guest" }}`);
        } catch (e) {}

        fetch('{{ \Illuminate\Support\Facades\Route::has("cambridge.mockup.reset-test") ? route("cambridge.mockup.reset-test") : url("/cambridge-mockup/reset-test") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                edition: TEST_CONFIG.edition,
                test_id: TEST_CONFIG.testId,
                skill: TEST_CONFIG.skill
            })
        }).finally(() => {
            window.location.reload();
        });
    };

    // Auto-restore evaluation if previously submitted (Local first, then Cloud)
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const saved = localStorage.getItem(TEST_CONFIG.storageKey);
            if (saved) {
                const evalResult = JSON.parse(saved);
                if (evalResult && evalResult.details) {
                    renderInlineExplanations(evalResult);
                    renderResultModal(evalResult);
                    updateHeaderBadge(evalResult);
                }
            }
        } catch (e) {}

        if (@json(Auth::check())) {
            const loadUrl = '{{ \Illuminate\Support\Facades\Route::has("cambridge.mockup.load-draft") ? route("cambridge.mockup.load-draft") : url("/cambridge-mockup/load-draft") }}?edition=' + TEST_CONFIG.edition + '&test_id=' + TEST_CONFIG.testId + '&skill=' + TEST_CONFIG.skill;
            fetch(loadUrl, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    if (data && data.has_result && data.result) {
                        const r = data.result;
                        const cloudEval = {
                            score: r.score || r.correct,
                            total: r.total_questions || r.total || 40,
                            band_score: Number(r.band_score) || 0,
                            band_label: calculateIeltsBandScore(r.score || r.correct).label,
                            details: (r.evaluation_data && r.evaluation_data.details) ? r.evaluation_data.details : (r.evaluation_details || {}),
                            evaluated_at: r.created_at || new Date().toISOString()
                        };
                        try {
                            localStorage.setItem(TEST_CONFIG.storageKey, JSON.stringify(cloudEval));
                        } catch (e) {}
                        renderInlineExplanations(cloudEval);
                        renderResultModal(cloudEval);
                        updateHeaderBadge(cloudEval);
                    }
                })
                .catch(err => console.warn('[C18Test4Evaluator] Cloud check error:', err));
        }
    });
})();
</script>
@endif
