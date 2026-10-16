@if(!defined('IELTS_C17_READING_TEST_3_EVALUATOR_INCLUDED'))
@php define('IELTS_C17_READING_TEST_3_EVALUATOR_INCLUDED', true); @endphp

{{-- ===================================================================
     IELTS Reading Test Evaluator (Cambridge 17 Test 3)
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
            <h2 class="text-2xl sm:text-3xl font-black mb-1">IELTS Reading – Mock Test 3</h2>
            <p class="text-emerald-100 text-xs sm:text-sm">Cambridge IELTS 17 Academic Practice Test 3</p>

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
    if (window.__c17ReadingTest3EvaluatorLoaded) return;
    window.__c17ReadingTest3EvaluatorLoaded = true;

    const TEST_CONFIG = {
        edition: '17',
        testId: '3',
        skill: 'reading',
        storageKey: `ielts_reading_eval_cambridge_17_test_3_user_{{ Auth::id() ?? "guest" }}`
    };

    const SPECIAL_PAIRS = [
        {
                "name": "q21_22[]",
                "questions": [
                        21,
                        22
                ],
                "validLetters": [
                        "B",
                        "C"
                ]
        }
];
    const ANSWER_KEYS = {
        "1": {
                "correct": "carnivorous",
                "aliases": [
                        "carnivore"
                ],
                "quote": "In terms of feeding, it was exclusively carnivorous, and its stomach was muscular...",
                "explanation": "Thylacine adalah hewan karnivora sejati yang hanya memakan daging (carnivorous)."
        },
        "2": {
                "correct": "scent",
                "aliases": [
                        "smell"
                ],
                "quote": "During long-distance chases, thylacines were likely to have relied more on scent than any other sense.",
                "explanation": "Saat berburu mangsa jarak jauh, thylacine mengandalkan indra penciuman (scent)."
        },
        "3": {
                "correct": "pouch",
                "quote": "Newborns crawled into the pouch on the belly of their mother, remaining there for up to three months.",
                "explanation": "Bayi thylacine yang baru lahir tinggal dan menyusu di dalam kantung (pouch) perut induknya."
        },
        "4": {
                "correct": "fossil",
                "quote": "The most recent occurrence on the mainland is a carbon-dated fossil from Murray Cave...",
                "explanation": "Bukti keberadaan thylacine terakhir di daratan utama Australia berupa fosil (fossil) berusia 3.100 tahun."
        },
        "5": {
                "correct": "habitat",
                "aliases": [
                        "habitats"
                ],
                "quote": "...loss of habitat along with the disappearance of prey species contributed to the decline...",
                "explanation": "Hilangnya habitat alami (habitat) dan berkurangnya mangsa memicu kepunahan thylacine di Tasmania."
        },
        "6": {
                "correct": "TRUE",
                "quote": "Dingoes never reached Tasmania, and most scientists see this as the main reason for the thylacine's survival there.",
                "explanation": "Benar. Thylacine bertahan hidup di Tasmania karena anjing dingo tidak pernah mencapai pulau tersebut."
        },
        "7": {
                "correct": "FALSE",
                "quote": "The dramatic decline is attributed to the relentless efforts of sheep farmers and bounty hunters...",
                "explanation": "Salah. Para peternak domba justru aktif memburu thylacine dengan bayaran imbalan (bounty)."
        },
        "8": {
                "correct": "NOT GIVEN",
                "quote": "John Gould foresaw the thylacine's demise in his Mammals of Australia...",
                "explanation": "Teks tidak menyebutkan apakah John Gould pernah melihat langsung thylacine hidup di alam liar."
        },
        "9": {
                "correct": "FALSE",
                "quote": "There was only one successful attempt to breed a thylacine in captivity, at Melbourne Zoo in 1899.",
                "explanation": "Salah. Satu-satunya pengembangbiakan di penangkaran yang berhasil terjadi di Kebun Binatang Melbourne, bukan London Zoo."
        },
        "10": {
                "correct": "NOT GIVEN",
                "quote": "In 1914, Professor T.T. Flynn suggested that some should be captured and placed on a small island.",
                "explanation": "Teks tidak menyebutkan tanggapan para politisi terhadap usulan Profesor Flynn tersebut."
        },
        "11": {
                "correct": "FALSE",
                "quote": "Official protection was introduced in July 1936, 59 days before the last known individual died...",
                "explanation": "Salah. Perlindungan resmi baru disahkan 59 hari sebelum thylacine terakhir mati, bukan jauh sebelumnya."
        },
        "12": {
                "correct": "TRUE",
                "quote": "The species was declared extinct by the Tasmanian government in 1986.",
                "explanation": "Benar. Pemerintah Tasmania secara resmi menyatakan spesies thylacine punah pada tahun 1986."
        },
        "13": {
                "correct": "NOT GIVEN",
                "quote": "There have been numerous expeditions and searches over the years...",
                "explanation": "Teks tidak menyebutkan apakah masih ada ekspedisi pencarian yang aktif didanai saat ini."
        },
        "14": {
                "correct": "F",
                "quote": "Section F discusses ecological farming techniques and biodiversity restoration in oil palm plantations.",
                "explanation": "Bagian F membahas upaya penelitian restorasi lingkungan dan pelestarian satwa di area perkebunan sawit."
        },
        "15": {
                "correct": "G",
                "quote": "Section G outlines future prospects and global certification standards for sustainable palm oil.",
                "explanation": "Bagian G memberikan pandangan masa depan tentang pentingnya industri minyak sawit yang berkelanjutan."
        },
        "16": {
                "correct": "A",
                "quote": "Section A explains why palm oil is so widely used in foods, cosmetics and household goods.",
                "explanation": "Bagian A memaparkan alasan kepopuleran minyak kelapa sawit yang digunakan di separuh produk kemasan dunia."
        },
        "17": {
                "correct": "H",
                "quote": "Section H emphasizes the crucial role of consumer pressure and labeling in driving sustainable practices.",
                "explanation": "Bagian H menekankan peran kesadaran konsumen dalam menuntut produk kelapa sawit yang bersertifikasi ramah lingkungan."
        },
        "18": {
                "correct": "B",
                "quote": "Section B details the environmental destruction and threat to endangered wildlife caused by deforestation.",
                "explanation": "Bagian B menyoroti kepunahan satwa dan kerusakan hutan tropis akibat pembukaan lahan kelapa sawit."
        },
        "19": {
                "correct": "E",
                "quote": "Section E argues that replacing palm oil with alternatives like soybean or rapeseed requires vastly more land.",
                "explanation": "Bagian E menjelaskan bahwa tanaman alternatif seperti kedelai membutuhkan lahan berkali-kali lipat lebih luas."
        },
        "20": {
                "correct": "C",
                "quote": "Section C introduces the RSPO and its criteria for ethical and sustainable palm oil production.",
                "explanation": "Bagian C menjelaskan pembentukan organisasi RSPO dan kriteria sertifikasi kelapa sawit berkelanjutan."
        },
        "21": {
                "correct": "B",
                "aliases": [
                        "C"
                ],
                "quote": "Oil palm produces far more oil per hectare than other crops (B) and alternatives would cause even greater deforestation (C).",
                "explanation": "Alasan tidak memboikot minyak sawit: hasil panen per hektar jauh lebih tinggi (B) dan minyak alternatif butuh lahan lebih masif (C)."
        },
        "22": {
                "correct": "C",
                "aliases": [
                        "B"
                ],
                "quote": "Oil palm produces far more oil per hectare than other crops (B) and alternatives would cause even greater deforestation (C).",
                "explanation": "Alasan tidak memboikot minyak sawit: hasil panen per hektar jauh lebih tinggi (B) dan minyak alternatif butuh lahan lebih masif (C)."
        },
        "23": {
                "correct": "solid",
                "quote": "One advantage of palm oil for manufacturers is that it stays solid at room temperature...",
                "explanation": "Keunggulan minyak sawit bagi industri makanan adalah teksturnya yang tetap padat (solid) pada suhu kamar."
        },
        "24": {
                "correct": "orangutan",
                "aliases": [
                        "orang-utan",
                        "orangutans",
                        "orang-utans"
                ],
                "quote": "The orangutan is the best known of the animals suffering habitat loss from oil palm expansion.",
                "explanation": "Orangutan (orangutan) adalah spesies paling terkenal yang terancam akibat pembukaan hutan untuk sawit."
        },
        "25": {
                "correct": "carbon stocks",
                "aliases": [
                        "carbon stock"
                ],
                "quote": "...the RSPO insists that growers monitor carbon stocks on a regular basis.",
                "explanation": "Petani sawit bersertifikasi diwajibkan memantau cadangan karbon (carbon stocks) secara berkala."
        },
        "26": {
                "correct": "biodiversity",
                "quote": "...looking into whether the bird's nest fern could help restore biodiversity in plantations.",
                "explanation": "Peneliti mengkaji apakah pakis sarang burung dapat membantu memulihkan keanekaragaman hayati (biodiversity)."
        },
        "27": {
                "correct": "D",
                "quote": "The book combines geology, history, economics, and a lot of data to explain why business clusters developed...",
                "explanation": "Buku karya Jason Barr menggabungkan data sejarah, kondisi geologi, dan prinsip-prinsip ekonomi perkotaan."
        },
        "28": {
                "correct": "B",
                "quote": "The reviewer questions Barr's claim that slum clearance was limiting while more expensive foundations were not.",
                "explanation": "Pengulas merasa heran mengapa pembersihan kawasan kumuh dinilai sebagai penghambat sedangkan fondasi mahal tidak."
        },
        "29": {
                "correct": "C",
                "quote": "Most immigrant enclaves were located on the least valuable land between waterfront industries and Central Park.",
                "explanation": "Pemukiman imigran abad ke-19 berlokasi di lahan yang harga pasarnya paling murah di kota Manhattan."
        },
        "30": {
                "correct": "D",
                "quote": "Economic height is defined as the height that is most efficient from society's point of view.",
                "explanation": "Tinggi ekonomis (economic height) adalah ketinggian gedung yang paling optimal dan menguntungkan bagi kepentingan sosial."
        },
        "31": {
                "correct": "C",
                "quote": "Iron and steel frames made thick load-bearing walls unnecessary, expanding space and allowing more natural light.",
                "explanation": "Penggunaan rangka besi dan baja meniadakan kebutuhan dinding penopang tebal sehingga ruangan lebih terang dan luas."
        },
        "32": {
                "correct": "NO",
                "quote": "Barr argues that bedrock depth was not a limiting factor, as foundation costs were only a small fraction of total development.",
                "explanation": "Salah. Barr membuktikan bahwa kedalaman batuan dasar bukan kendala utama karena biaya fondasi relatif kecil."
        },
        "33": {
                "correct": "YES",
                "quote": "What I enjoyed the most was Barr's discussion of caissons and the dangers involved...",
                "explanation": "Benar. Pengulas sangat menikmati pemaparan teknis mengenai penggunaan caisson dan risiko keselamatan pekerjanya."
        },
        "34": {
                "correct": "NOT GIVEN",
                "quote": "Chapters eight contains lengthy discussions of urban economic theory that would be well-suited for undergraduates...",
                "explanation": "Teks tidak menyebutkan apakah bab teori ekonomi tersebut menuai pujian dari kalangan ekonom terkemuka."
        },
        "35": {
                "correct": "NO",
                "quote": "Though it enabled the boom, cheap credit was not, he argues, the primary cause.",
                "explanation": "Salah. Barr menyimpulkan bahwa faktor penawaran dan permintaan adalah penyebab utama ledakan gedung 1920-an, bukan kredit murah."
        },
        "36": {
                "correct": "H",
                "quote": "Analysis of data sets covering historical growth.",
                "explanation": "Bab awal buku ini menyajikan pengolahan data geologi dan catatan sejarah perkembangan kota."
        },
        "37": {
                "correct": "D",
                "quote": "Regression analysis used to predict building construction.",
                "explanation": "Barr menggunakan analisis regresi statistik untuk memprediksi tinggi bangunan sepanjang abad ke-20."
        },
        "38": {
                "correct": "I",
                "quote": "Use of caissons enabling workers to excavate deep beneath the water table.",
                "explanation": "Teknologi caisson memungkinkan pekerja menggali fondasi hingga jauh ke bawah permukaan air tanah."
        },
        "39": {
                "correct": "B",
                "quote": "Supply and demand factors identified as primary driver of the 1920s boom.",
                "explanation": "Kekuatan pasar berupa penawaran dan permintaan (supply and demand) menjadi penggerak utama lonjakan konstruksi."
        },
        "40": {
                "correct": "F",
                "quote": "Cheap credit shown to be secondary rather than fundamental cause.",
                "explanation": "Kemudahan fasilitas kredit murah (cheap credit) terbukti hanya faktor pendukung, bukan faktor primer."
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
        .catch(err => console.warn('[C17Test3Evaluator] Cloud sync result failed:', err));
    }

    window.confirmResetReadingTest = function() {
        if (!confirm('Apakah Anda yakin ingin mengulang ujian ini? Seluruh jawaban dan hasil evaluasi akan direset.')) {
            return;
        }

        try {
            localStorage.removeItem(TEST_CONFIG.storageKey);
            localStorage.removeItem(`ielts_reading_cambridge_17_test_3_user_{{ Auth::id() ?? "guest" }}`);
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
                .catch(err => console.warn('[C17Test3Evaluator] Cloud check error:', err));
        }
    });
})();
</script>
@endif
