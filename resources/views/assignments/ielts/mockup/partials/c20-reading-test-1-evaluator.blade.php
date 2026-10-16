@if(!defined('IELTS_C20_READING_TEST_1_EVALUATOR_INCLUDED'))
@php define('IELTS_C20_READING_TEST_1_EVALUATOR_INCLUDED', true); @endphp

{{-- ===================================================================
     IELTS Reading Test Evaluator (Cambridge 20 Test 1)
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
            <h2 class="text-2xl sm:text-3xl font-black mb-1">IELTS Reading – Mock Test 1</h2>
            <p class="text-emerald-100 text-xs sm:text-sm">Cambridge IELTS 20 Academic Practice Test 1</p>

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
    if (window.__c20ReadingTest1EvaluatorLoaded) return;
    window.__c20ReadingTest1EvaluatorLoaded = true;

    const TEST_CONFIG = {
        edition: '20',
        testId: '1',
        skill: 'reading',
        storageKey: `ielts_reading_eval_cambridge_20_test_1_user_{{ Auth::id() ?? "guest" }}`
    };

    const SPECIAL_PAIRS = [];
    const ANSWER_KEYS = {
        "1": {
                "correct": "FALSE",
                "quote": "It is the world's only flightless parrot",
                "explanation": "Pernyataan bahwa ada burung beo lain yang juga tidak bisa terbang salah karena teks menyatakan kākāpō adalah satu-satunya burung beo yang tidak bisa terbang di dunia."
        },
        "2": {
                "correct": "FALSE",
                "quote": "Kākāpō breed in summer and autumn, but only in years when food is plentiful.",
                "explanation": "Kākāpō tidak berkembang biak setiap tahun, melainkan hanya pada tahun-tahun ketika makanan melimpah."
        },
        "3": {
                "correct": "FALSE",
                "quote": "Males play no part in incubation or chick-rearing – females alone incubate eggs and feed the chicks.",
                "explanation": "Teks menyatakan bahwa jantan tidak berperan dalam mengeram atau membesarkan anak; hanya betina yang melakukannya, bertentangan dengan pernyataan."
        },
        "4": {
                "correct": "NOT GIVEN",
                "explanation": "Teks menyebutkan baik penduduk Polinesia maupun tikus Polinesia sebagai ancaman, tetapi tidak membandingkan mana yang lebih besar ancamannya."
        },
        "5": {
                "correct": "TRUE",
                "quote": "predation by feral cats on Rakiura Island led to a rapid decline in kākāpō numbers. As a result, during 1980–97, the surviving population was evacuated to three island sanctuaries",
                "explanation": "Teks menegaskan populasi dipindahkan dari Rakiura karena ancaman predasi kucing liar."
        },
        "6": {
                "correct": "TRUE",
                "quote": "rescuing and hand-raising any failing chicks",
                "explanation": "Salah satu langkah dalam Recovery Plan adalah menyelamatkan dan membesarkan anak burung yang gagal bertahan hidup, sesuai pernyataan."
        },
        "7": {
                "correct": "bulbs",
                "quote": "diet including the leaves, roots and bark of trees as well as bulbs, and fern fronds",
                "explanation": "Selain pucuk pakis dan bagian pohon, makanan kākāpō juga mencakup umbi (bulbs)."
        },
        "8": {
                "correct": "soil",
                "quote": "The 1–4 eggs are laid in soil, which is repeatedly turned over",
                "explanation": "Sarang dibuat di dalam tanah (soil) tempat telur diletakkan."
        },
        "9": {
                "correct": "feathers",
                "quote": "They ate its meat and used its feathers to make soft cloaks.",
                "explanation": "Bulu (feathers) kākāpō digunakan penduduk Polinesia untuk membuat jubah."
        },
        "10": {
                "correct": "deer",
                "quote": "introduced species such as deer depleted the remaining forests of food",
                "explanation": "Rusa (deer) adalah hewan yang diperkenalkan dan menghabiskan sumber makanan di hutan."
        },
        "11": {
                "correct": "1980",
                "quote": "in 1980 it was confirmed females were also present",
                "explanation": "Kehadiran betina di Pulau Rakiura baru dipastikan pada tahun 1980."
        },
        "12": {
                "correct": "funding",
                "quote": "together with a specialist advisory group ... and a higher amount of funding",
                "explanation": "Recovery Plan tahun 1996 disertai peningkatan pendanaan (funding)."
        },
        "13": {
                "correct": "stakeholders",
                "quote": "ensure stakeholders continue to be fully engaged in the preservation of the species",
                "explanation": "Salah satu tujuan Recovery Plan saat ini adalah memastikan keterlibatan para pemangku kepentingan (stakeholders)."
        },
        "14": {
                "correct": "C",
                "quote": "the number of these mature survivors is relatively small ... What are the reasons for their survival?",
                "explanation": "Bagian C membahas keterbatasan penelitian karena hanya sedikit pohon elm dewasa yang bertahan."
        },
        "15": {
                "correct": "G",
                "quote": "For her, the environmental case for reintroducing elm is strong ... Others are more wary.",
                "explanation": "Bagian G memuat perbedaan pendapat antara Russell dan Elliot soal nilai reintroduksi elm."
        },
        "16": {
                "correct": "B",
                "quote": "in the '70s a second epidemic was triggered by shipments of elm from Canada",
                "explanation": "Bagian B menjelaskan asal mula Dutch elm disease dibawa melalui pengiriman kayu elm dari Kanada."
        },
        "17": {
                "correct": "E",
                "quote": "Strong winds from the sea make it difficult for the determined elm bark beetle to attack this coastal city's elm population.",
                "explanation": "Bagian E menjelaskan kondisi angin kencang di Brighton yang membantu pohon elm selamat dari penyakit."
        },
        "18": {
                "correct": "C",
                "quote": "Once the trunk of the elm reaches 10–15 centimetres or so in diameter, it becomes a perfect size for beetles to lay eggs",
                "explanation": "Bagian C menyebutkan ukuran batang tertentu yang membuat pohon elm muda rentan diserang kumbang."
        },
        "19": {
                "correct": "B",
                "quote": "'The effects are very quick,' says Russell. 'You return in four to six weeks...'",
                "explanation": "Russell menjelaskan bahwa dampak infeksi terlihat cepat dalam waktu singkat."
        },
        "20": {
                "correct": "A",
                "quote": "'Sometimes the best thing you can do is just give nature time to recover ... over time, you might get resistance,' says Elliot.",
                "explanation": "Elliot menyarankan menunggu dan membiarkan alam pulih sendiri."
        },
        "21": {
                "correct": "B",
                "quote": "'What are the reasons for their survival?' asks Russell.",
                "explanation": "Russell menegaskan perlunya penjelasan atas bertahannya pohon elm dewasa."
        },
        "22": {
                "correct": "C",
                "quote": "'The beetles can just march in if we're not careful, as the threat is right on our doorstep,' says Bourne.",
                "explanation": "Bourne mengingatkan bahwa ancaman kumbang sangat dekat dan bisa menyerang kapan saja."
        },
        "23": {
                "correct": "A",
                "quote": "'You look at old photographs from the 1960s and it's only then that you realise the impact [elms had]'",
                "explanation": "Elliot menjelaskan bahwa dampak penyakit baru terasa nyata ketika melihat foto lama."
        },
        "24": {
                "correct": "oak",
                "quote": "elm ran a close second to oak as the hardwood tree of choice in Britain",
                "explanation": "Pohon yang lebih populer daripada elm adalah oak (ek)."
        },
        "25": {
                "correct": "flooring",
                "quote": "its wood was used for items such as storage crates and flooring",
                "explanation": "Kayu elm pada abad ke-18 digunakan untuk membuat peti dan lantai (flooring)."
        },
        "26": {
                "correct": "keel",
                "quote": "used to build the keel of the 19th-century sailing ship Cutty Sark",
                "explanation": "Bagian lunas (keel) kapal Cutty Sark dibangun dari kayu elm."
        },
        "27": {
                "correct": "C",
                "quote": "we are all sometimes required to weigh up information under stressful conditions",
                "explanation": "Paragraf pembuka menyebutkan tantangan yang dihadapi semua orang dalam mengambil keputusan di saat stres."
        },
        "28": {
                "correct": "A",
                "quote": "These ups and downs presented the perfect setting for an experiment",
                "explanation": "Variasi tingkat stres dalam pekerjaan pemadam kebakaran menjadikan mereka subjek penelitian yang ideal."
        },
        "29": {
                "correct": "D",
                "quote": "This is how we arrived at these results. We asked the firefighters to estimate...",
                "explanation": "Paragraf keempat menjelaskan metodologi penelitian yang digunakan."
        },
        "30": {
                "correct": "C",
                "quote": "a sudden boost in a neural signal important for learning, specifically in response to unexpected warning signs",
                "explanation": "Mekanisme otak yang dijelaskan meningkatkan kepekaan terhadap tanda-tanda ancaman eksternal."
        },
        "31": {
                "correct": "B",
                "quote": "People are normally quite optimistic – they will ignore bad news and embrace the good. This is what happened when the firefighters were relaxed",
                "explanation": "Saat relaks, petugas pemadam cenderung mengabaikan berita buruk."
        },
        "32": {
                "correct": "G",
                "quote": "they became hyper-vigilant to bad news ... altered their beliefs in response",
                "explanation": "Saat stres, mereka menganggap kemungkinan mengalami hal buruk menjadi lebih besar."
        },
        "33": {
                "correct": "F",
                "quote": "stress didn't change how they responded to good news",
                "explanation": "Respons terhadap berita baik tetap sama, tidak dipengaruhi kondisi stres."
        },
        "34": {
                "correct": "E",
                "quote": "students who were told they had to give a surprise public speech, which would be judged by a panel, recorded and posted online",
                "explanation": "Para mahasiswa ditempatkan dalam situasi penuh tekanan berupa pidato dadakan di depan umum."
        },
        "35": {
                "correct": "D",
                "quote": "we observed the same pattern in students ... their cortisol levels spiked ... and they suddenly became better at processing unrelated, yet alarming, information",
                "explanation": "Pemrosesan informasi negatif meningkat ketika subjek berada dalam kondisi stres."
        },
        "36": {
                "correct": "YES",
                "quote": "if we observe positive feeds on social media ... we are more likely to post uplifting messages ourselves. If we observe negative posts ... we will in turn create more negative posts.",
                "explanation": "Nada unggahan media sosial kita cenderung mengikuti nada unggahan yang kita lihat di linimasa."
        },
        "37": {
                "correct": "NOT GIVEN",
                "explanation": "Teks membahas dampak stres akibat memeriksa ponsel, tetapi tidak membandingkannya dengan perangkat elektronik lain."
        },
        "38": {
                "correct": "NO",
                "quote": "they suddenly became better at processing unrelated, yet alarming, information",
                "explanation": "Teks justru menyatakan orang menjadi lebih baik (bukan kurang mampu) memproses informasi mengkhawatirkan saat stres."
        },
        "39": {
                "correct": "YES",
                "quote": "trips are cancelled, even if the disaster took place across the globe; stocks are sold, even when holding on is the best thing to do",
                "explanation": "Stres akibat media sosial dapat mendorong tindakan pencegahan berlebihan yang sebenarnya tidak diperlukan."
        },
        "40": {
                "correct": "YES",
                "quote": "positive emotions, such as hope, are contagious too, and are powerful in inducing people to act to find solutions",
                "explanation": "Kecenderungan terpengaruh suasana hati orang lain juga dapat dimanfaatkan secara positif."
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
            const sel = document.querySelector(`select[name="q${i}"]`);
            if (sel && sel.value) {
                answers[i] = sel.value.trim();
                continue;
            }

            const txt = document.querySelector(`input[type="text"][name="q${i}"]`);
            if (txt && txt.value) {
                answers[i] = txt.value.trim();
                continue;
            }

            const rad = document.querySelector(`input[type="radio"][name="q${i}"]:checked`);
            if (rad && rad.value) {
                answers[i] = rad.value.trim();
                continue;
            }
        }

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

            const inputEl = document.querySelector(`[name="q${i}"]`);
            if (inputEl) {
                inputEl.classList.remove('border-emerald-500', 'border-rose-500', 'border-gray-300', 'bg-emerald-50', 'bg-rose-50');
                if (d.isCorrect) {
                    inputEl.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-900');
                } else {
                    inputEl.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-900');
                }
            }

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
        .catch(err => console.warn('[C20Test1Evaluator]  Cloud sync result failed:', err));
    }

    window.confirmResetReadingTest = function() {
        if (!confirm('Apakah Anda yakin ingin mengulang ujian ini? Seluruh jawaban dan hasil evaluasi akan direset.')) {
            return;
        }

        try {
            localStorage.removeItem(TEST_CONFIG.storageKey);
            localStorage.removeItem(`ielts_reading_cambridge_20_test_1_user_{{ Auth::id() ?? "guest" }}`);
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
                .catch(err => console.warn('[C20Test1Evaluator] Cloud check error:', err));
        }
    });
})();
</script>
@endif
