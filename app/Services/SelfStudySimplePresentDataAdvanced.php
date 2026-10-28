<?php

namespace App\Services;

class SelfStudySimplePresentDataAdvanced
{
    /**
     * Get the complete Simple Present Verbal package.
     */
    public static function getPackage(): array
    {
        $subLessons = self::getSubLessons();
        $questions = [];

        foreach ($subLessons as $sl) {
            foreach ($sl['exercises'] as $ex) {
                $questions[] = [
                    'number' => (string) $ex['id'],
                    'prompt' => $ex['id_sentence'],
                    'options' => $ex['options'],
                    'correct_index' => $ex['correct_index'],
                    'explanation' => $ex['explanation'],
                    'sub_lesson' => $sl['name'],
                    'target_word' => $ex['target_word'] ?? '',
                    'vocab' => $ex['vocab'] ?? [],
                    'example' => $ex['example'] ?? null,
                ];
            }
        }

        return [
            'banner_title' => 'Simple Present Tense: Verbal Sentences',
            'banner_subtitle' => 'Kuasai konstruksi kalimat verbal Simple Present mulai dari subjek I, You, We, They & Benda Jamak (+ V1) hingga He, She, It & Benda Tunggal (+ V1/Vs/es) dalam 8 sub-lesson komprehensif.',
            'banner_badge' => 'MODULE 1.2 VERBAL FORMS',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.2
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Konsep Dasar: Kalimat Verbal Simple Present Tense',
            'concept_summary' => 'Kalimat verbal adalah kalimat yang predikat utamanya berupa kata kerja aksi (Action Verb) atau kata kerja keadaan/kognisi (Stative Verb). Dalam Simple Present Tense, bentuk kata kerja ditentukan secara mutlak oleh jenis subjeknya: apakah subjeknya termasuk kelompok (I, You, We, They, dan Benda Jamak) atau kelompok orang ketiga tunggal (He, She, It, dan Benda Tunggal/Uncountable).',
            'rules' => [
                [
                    'rule_title' => '1. Kelompok Subjek I, You, We, They & Benda Jamak (Plural)',
                    'rule_formula' => 'Subject (I / You / We / They / Plural Nouns) + Verb 1 (Base Form) + Object / Complement',
                    'rule_description' => 'Subjek jamak dan kata ganti I, You, We, They selalu menggunakan bentuk dasar kata kerja (Bare Infinitive / V1) TANPA akhiran -s atau -es. Dilarang menyisipkan to be (am/are) sebelum kata kerja.',
                    'examples' => [
                        [
                            'subject' => 'Subjek "I"',
                            'en' => 'I analyze primary data in the laboratory every morning.',
                            'id' => 'Saya menganalisis data primer di laboratorium setiap pagi.',
                            'note' => 'Subjek "I" selalu berpasangan dengan Verb 1 dasar "analyze" tanpa tambahan -s atau -es.'
                        ],
                        [
                            'subject' => 'Subjek "You"',
                            'en' => 'You formulate research hypotheses before beginning the experiment.',
                            'id' => 'Anda merumuskan hipotesis penelitian sebelum memulai eksperimen.',
                            'note' => 'Subjek "You" berpasangan dengan Verb 1 dasar "formulate" tanpa akhiran -s.'
                        ],
                        [
                            'subject' => 'Subjek "We"',
                            'en' => 'We collect soil samples from five distinct sites for chemical testing.',
                            'id' => 'Kami mengumpulkan sampel tanah dari lima lokasi berbeda untuk uji kimia.',
                            'note' => 'Subjek "We" wajib menggunakan Verb 1 dasar "collect" (bukan "collects" dan bukan "are collect").'
                        ],
                        [
                            'subject' => 'Subjek "They"',
                            'en' => 'They publish scientific findings in accredited international journals.',
                            'id' => 'Mereka mempublikasikan temuan ilmiah di jurnal internasional terakreditasi.',
                            'note' => 'Subjek "They" berpasangan dengan Verb 1 dasar "publish" tanpa akhiran -es.'
                        ],
                        [
                            'subject' => 'Benda Jamak (Plural Nouns)',
                            'en' => 'Researchers observe seawater temperature fluctuations on a weekly basis.',
                            'id' => 'Para peneliti mengamati fluktuasi suhu air laut secara mingguan.',
                            'note' => 'Subjek jamak "Researchers" berbentuk plural noun, sehingga kata kerjanya adalah Verb 1 murni tanpa -s: "observe".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Kelompok Subjek He, She, It & Benda Tunggal (Singular & Uncountable)',
                    'rule_formula' => 'Subject (He / She / It / Singular & Uncountable Nouns) + Verb 1 + (-s / -es / -ies) + Object / Complement',
                    'rule_description' => 'Subjek orang ketiga tunggal (He, She, It), nama orang tunggal, benda tunggal (a company, the institution), dan kata benda tak dapat dihitung (evidence, research, information) WAJIB menambahkan akhiran -s, -es, atau -ies pada kata kerjanya.',
                    'examples' => [
                        [
                            'subject' => 'Subjek "He"',
                            'en' => 'He leads the molecular genetics research laboratory.',
                            'id' => 'Dia (laki-laki) memimpin laboratorium riset genetika molekuler.',
                            'note' => 'Subjek orang ketiga tunggal "He" wajib menambahkan akhiran -s pada verba: "leads".'
                        ],
                        [
                            'subject' => 'Subjek "She"',
                            'en' => 'She teaches quantitative research methodology at the faculty.',
                            'id' => 'Dia (perempuan) mengajar metodologi penelitian kuantitatif di fakultas tersebut.',
                            'note' => 'Verba berakhiran fonem sibilan "-ch" ("teach") wajib ditambah akhiran -es: "teaches".'
                        ],
                        [
                            'subject' => 'Subjek "It"',
                            'en' => 'It processes billions of financial transactions instantaneously.',
                            'id' => 'Sistem komputer ini memproses miliaran transaksi keuangan secara instan.',
                            'note' => 'Subjek "It" berpasangan dengan verba berakhiran "-ss" ("process") + -es: "processes".'
                        ],
                        [
                            'subject' => 'Benda Tunggal (Singular Noun)',
                            'en' => 'The institution issues food safety certifications every semester.',
                            'id' => 'Lembaga tersebut mengeluarkan sertifikasi keamanan pangan setiap semester.',
                            'note' => 'Subjek benda tunggal "The institution" berpasangan dengan verba berakhiran -s: "issues".'
                        ],
                        [
                            'subject' => 'Uncountable Noun (Tak Dapat Dihitung)',
                            'en' => 'Empirical evidence demonstrates the effectiveness of the testing protocol.',
                            'id' => 'Bukti empiris menunjukkan efektivitas dari protokol pengujian tersebut.',
                            'note' => 'Subjek uncountable "evidence" selalu diperlakukan sebagai tunggal, sehingga verba ditambah -s: "demonstrates".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Bentuk Negatif Kalimat Verbal',
                    'rule_formula' => 'Plural / I/You/We/They + DO NOT (don\'t) + Verb 1 | Singular / He/She/It + DOES NOT (doesn\'t) + Verb 1',
                    'rule_description' => 'Kalimat verbal dinegatifkan dengan bantuan auxiliary "do not" atau "does not". Setelah do/does not, kata kerja UTAMA SELALU kembali ke bentuk dasar V1 tanpa -s/-es.',
                    'examples' => [
                        [
                            'subject' => 'Subjek I, You, We, They & Jamak (DO NOT)',
                            'en' => 'We do not accept conclusions that contradict empirical data.',
                            'id' => 'Kami tidak menyetujui kesimpulan yang bertentangan dengan data empiris.',
                            'note' => 'Subjek jamak / We menggunakan auxiliary "do not" diikuti bentuk dasar Verb 1 "accept".'
                        ],
                        [
                            'subject' => 'Subjek He, She, It & Tunggal (DOES NOT)',
                            'en' => 'The author does not support the hypothesis of unconstrained expansion.',
                            'id' => 'Penulis tidak mendukung hipotesis tentang ekspansi tanpa batas.',
                            'note' => 'Subjek tunggal "The author" menggunakan auxiliary "does not", dan verba kembali ke bentuk murni "support" tanpa -s.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Bentuk Tanya (Interrogative)',
                    'rule_formula' => 'Do + (I/You/We/They/Plural) + Verb 1? | Does + (He/She/It/Singular) + Verb 1?',
                    'rule_description' => 'Tempatkan Do atau Does di awal kalimat tanya atau tepat setelah kata tanya WH (What, Why, How). Kata kerja kembali ke bentuk dasar V1.',
                    'examples' => [
                        [
                            'subject' => 'Subjek I, You, We, They & Jamak (DO)',
                            'en' => 'Do researchers test this hypothesis under controlled laboratory conditions?',
                            'id' => 'Apakah para peneliti menguji hipotesis ini dalam kondisi laboratorium terkontrol?',
                            'note' => 'Kalimat tanya diawali "Do" untuk subjek jamak "researchers", diikuti Verb 1 dasar "test".'
                        ],
                        [
                            'subject' => 'Subjek He, She, It & Tunggal (DOES)',
                            'en' => 'Does this regulatory framework prevent capital market manipulation?',
                            'id' => 'Apakah kerangka regulasi ini mencegah manipulasi pasar modal?',
                            'note' => 'Diawali "Does" untuk subjek tunggal "regulatory framework", dan verba utama tetap Verb 1 "prevent" tanpa -s.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '5. Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                    'rule_formula' => 'Konsonan + y ➔ -ies | Ch/Sh/Ss/X/O ➔ -es | Verba Standar ➔ -s',
                    'rule_description' => 'Penambahan akhiran orang ketiga tunggal mengikuti aturan ejaan fonetis bahasa Inggris standar.',
                    'examples' => [
                        [
                            'subject' => 'Konsonan + Y ➔ -IES',
                            'en' => 'The laboratory identifies new bacterial species every month.',
                            'id' => 'Laboratorium tersebut mengidentifikasi spesies bakteri baru setiap bulan.',
                            'note' => 'Kata kerja "identify" berakhiran konsonan + y, berubah menjadi "-ies" ("identifies") untuk subjek tunggal.'
                        ],
                        [
                            'subject' => 'Akhiran Ch, Sh, Ss, X, O ➔ -ES',
                            'en' => 'The professor teaches advanced macroeconomic models to graduate students.',
                            'id' => 'Profesor tersebut mengajar model makroekonomi tingkat lanjut kepada mahasiswa pascasarjana.',
                            'note' => 'Verba berakhiran "-ch" ("teach") mendapat tambahan "-es" ("teaches").'
                        ],
                        [
                            'subject' => 'Verba Standar ➔ -S',
                            'en' => 'The experimental report confirms previous theoretical projections.',
                            'id' => 'Laporan eksperimen tersebut mengonfirmasi proyeksi teoretis sebelumnya.',
                            'note' => 'Verba berakhiran vokal/konsonan standar ("confirm") cukup ditambah "-s" ("confirms").'
                        ],
                    ],
                ],
                [
                    'rule_title' => '6. Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                    'rule_formula' => 'Subject + Adverb of Frequency (always, usually, often) + Verb 1 / V-s + Object',
                    'rule_description' => 'Adverbia frekuensi diletakkan tepat sebelum kata kerja utama dalam kalimat verbal tunggal.',
                    'examples' => [
                        [
                            'subject' => 'Subjek Jamak + Adverb of Frequency',
                            'en' => 'Scientists always verify experimental results independently.',
                            'id' => 'Para ilmuwan selalu memverifikasi hasil eksperimen secara mandiri.',
                            'note' => 'Adverb "always" diletakkan tepat sebelum kata kerja utama Verb 1 "verify".'
                        ],
                        [
                            'subject' => 'Subjek Tunggal + Adverb of Frequency',
                            'en' => 'The supervisor frequently reviews lab notes before project submission.',
                            'id' => 'Penyelia tersebut sering kali memeriksa catatan laboratorium sebelum penyerahan proyek.',
                            'note' => 'Adverb "frequently" diletakkan sebelum kata kerja berakhiran -s: "reviews".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '7. Stative Verbs dalam Simple Present Akademik',
                    'rule_formula' => 'Subject + Stative Verb (understand, believe, belong, contain) + Object / Complement',
                    'rule_description' => 'Stative verbs menyatakan kondisi mental, persepsi, atau hubungan permanen dan tidak digunakan dalam continuous tense.',
                    'examples' => [
                        [
                            'subject' => 'Verba Kognisi & Persepsi',
                            'en' => 'The expert panel understands the complexity of the environmental issue.',
                            'id' => 'Dewan pakar memahami kompleksitas permasalahan lingkungan tersebut.',
                            'note' => 'Stative verb "understand" menyatakan status kognitif dan tidak boleh berbentuk continuous (*is understanding).'
                        ],
                        [
                            'subject' => 'Verba Hubungan & Isi',
                            'en' => 'This comprehensive report contains detailed statistical analyses.',
                            'id' => 'Laporan komprehensif ini memuat analisis statistik yang terperinci.',
                            'note' => 'Stative verb "contain" menyatakan kepemilikan/cakupan isi dalam bentuk Present tunggal: "contains".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '8. Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                    'rule_formula' => 'BENAR: Subject + Verb 1 (-s/-es) | SALAH: Subject + is/are + Verb 1',
                    'rule_description' => 'Hilangkan to be (am/is/are) yang tidak diperlukan di depan kata kerja verbal murni.',
                    'examples' => [
                        [
                            'subject' => 'Bentuk Jamak (BENAR vs SALAH)',
                            'en' => 'Researchers investigate alternative energy solutions. (NOT: Researchers are investigate)',
                            'id' => 'Para peneliti menyelidiki solusi energi alternatif.',
                            'note' => 'Gunakan langsung Verb 1 "investigate" tanpa menyisipkan auxiliary "are".'
                        ],
                        [
                            'subject' => 'Bentuk Tunggal (BENAR vs SALAH)',
                            'en' => 'The government protects public health through strict regulations. (NOT: The government is protects)',
                            'id' => 'Pemerintah melindungi kesehatan masyarakat melalui regulasi ketat.',
                            'note' => 'Gunakan langsung verba "protects" tanpa menyisipkan auxiliary "is".'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Parameter Subjek', 'Kelompok I, You, We, They & Benda Jamak', 'Kelompok He, She, It & Benda Tunggal/Uncountable'],
                'rows' => [
                    ['Contoh Subjek', 'I, you, we, they, students, scientists, data, criteria', 'He, she, it, a student, the scientist, evidence, research'],
                    ['Afirmatif (+)', 'Subject + Verb 1 (e.g., observe, conclude)', 'Subject + Verb 1 + s/es/ies (e.g., observes, concludes)'],
                    ['Negatif (-)', 'Subject + DO NOT + Verb 1', 'Subject + DOES NOT + Verb 1 (tanpa -s/-es)'],
                    ['Interrogatif (?)', 'DO + Subject + Verb 1 ... ?', 'DOES + Subject + Verb 1 ... ?'],
                    ['Kesalahan Fatal', 'They are observe (SALAH ➔ Double Predicate)', 'He does not observes (SALAH ➔ Dobel -s)'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The government is protects public health by enforcing safety standards.',
                    'correct' => 'The government protects public health by enforcing safety standards.',
                    'explanation' => 'Kesalahan double predicate: jangan menyisipkan "is" sebelum kata kerja verbal "protects".'
                ],
                [
                    'incorrect' => 'The research show that global temperatures rise steadily.',
                    'correct' => 'The research shows that global temperatures rise steadily.',
                    'explanation' => '"Research" adalah kata benda tak dapat dihitung (uncountable / tunggal), sehingga wajib menggunakan kata kerja berakhiran -s: "shows".'
                ],
                [
                    'incorrect' => 'The investigator does not agrees with the methodology.',
                    'correct' => 'The investigator does not agree with the methodology.',
                    'explanation' => 'Setelah auxiliary "does not", kata kerja utama harus kembali ke Verb 1 dasar ("agree"), bukan "agrees".'
                ],
                [
                    'incorrect' => 'Many countries applies strict emission limits.',
                    'correct' => 'Many countries apply strict emission limits.',
                    'explanation' => 'Subjek jamak "Many countries" berpasangan dengan Verb 1 dasar ("apply"), bukan bentuk -ies.'
                ],
            ],
            'exam_tips' => [
                'Selalu cari subjek inti (Head Noun). Hiraukan frasa preposisi di antara subjek dan kata kerja.',
                'Hati-hati dengan kata benda jamak tak beraturan: data (jamak) ➔ data show; phenomenon (tunggal) ➔ phenomenon shows; phenomena (jamak) ➔ phenomena show.',
                'Uncountable nouns (evidence, information, advice, machinery, legislation) selalu diperlakukan sebagai tunggal dan wajib mengambil Verb + s/es.',
                'Gunakan Simple Present Verbal saat menyajikan fakta permanen dan merujuk argumen literatur dalam Task 1 & Task 2 IELTS.'
            ],
        ];
    }

    /**
     * Get the 8 structured sub-lessons with 10 exercises each (80 exercises total).
     */
    public static function getSubLessons(): array
    {
        return [
            // ==========================================
            // SUB-LESSON 1: Subjek I, You, We, They & Benda Jamak + V1
            // ==========================================
            [
                'id' => 'verbal-plural-v1',
                'name' => 'Subjek I, You, We, They & Benda Jamak + V1',
                'code' => '1.2.1',
                'concept_title' => 'Konstruksi Kalimat Verbal dengan Subjek I, You, We, They, dan Plural Nouns',
                'concept_description' => 'Subjek orang pertama (I, We), orang kedua (You), orang ketiga jamak (They), serta seluruh kata benda jamak (Plural Nouns: researchers, universities, participants, data) menggunakan bentuk dasar kata kerja (Verb 1 / Bare Infinitive) tanpa akhiran -s atau -es. Dilarang keras menyisipkan auxiliary to be (am/are) sebelum Verb 1.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">SUBJEK JAMAK / I, YOU, WE, THEY</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Verb 1 Murni (Tanpa -s / -es)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-2">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide">Rumus Dasar:</span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">S (I / You / We / They / Plural) + V1 (Base Form) + O/C</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">My classmates like playing badminton.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-emerald-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> <span class="text-white">like</span> &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="text-white line-through">likes</span> / <span class="text-white line-through">are like</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan Verb 1 dasar murni tanpa tambahan -s atau -es.',
                    'Dilarang melakukan double predicate seperti "We are investigate" ➔ wajib "We investigate".',
                    'Kata benda jamak tak beraturan seperti "data", "criteria", "people", "phenomena" wajib berpasangan dengan Verb 1 dasar.',
                    'Frasa subjek jamak gabungan dengan "and" (misal: "Solar energy and wind power") memerlukan Verb 1 dasar.'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Para peneliti mengamati perubahan suhu air laut setiap minggu.',
                        'target_word' => 'observe (V1)',
                        'options' => [
                            'Researchers observe seawater temperature fluctuations on a weekly basis.',
                            'Researchers observes seawater temperature fluctuations on a weekly basis.',
                            'Researchers are observe seawater temperature fluctuations on a weekly basis.',
                            'Researchers is observe seawater temperature fluctuations on a weekly basis.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "Researchers" adalah benda jamak (plural noun), sehingga kata kerja yang digunakan adalah Verb 1 murni tanpa -s: "observe". Opsi "observes" salah untuk jamak, dan "are observe" adalah double predicate.',
                        'vocab' => [
                            'researchers' => ['id' => 'para peneliti', 'pos' => '(n)'],
                            'observe' => ['id' => 'mengamati', 'pos' => '(v)'],
                            'temperature fluctuations' => ['id' => 'fluktuasi suhu', 'pos' => '(n)'],
                            'weekly basis' => ['id' => 'secara mingguan', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Para ahli biologi memantau migrasi burung di muara sungai.',
                            'en' => 'Biologists monitor avian migration across the estuary.'
                        ]
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Kami mengumpulkan sampel tanah dari lima lokasi berbeda untuk analisis kimia.',
                        'target_word' => 'collect (V1)',
                        'options' => [
                            'We collect soil samples from five distinct sites for chemical analysis.',
                            'We collects soil samples from five distinct sites for chemical analysis.',
                            'We are collect soil samples from five distinct sites for chemical analysis.',
                            'We collecting soil samples from five distinct sites for chemical analysis.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "We" wajib berpasangan dengan Verb 1 dasar "collect". Opsi "collects" salah karena -s hanya untuk orang ketiga tunggal.',
                        'vocab' => [
                            'collect' => ['id' => 'mengumpulkan', 'pos' => '(v)'],
                            'soil samples' => ['id' => 'sampel tanah', 'pos' => '(n)'],
                            'distinct sites' => ['id' => 'lokasi berbeda', 'pos' => '(n)'],
                            'chemical analysis' => ['id' => 'analisis kimia', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kami memeriksa catatan laboratorium secara teliti setiap pagi.',
                            'en' => 'We inspect laboratory records thoroughly every morning.'
                        ]
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Data statistik ini menunjukkan peningkatan signifikan dalam adopsi energi surya.',
                        'target_word' => 'show (V1 - Plural Data)',
                        'options' => [
                            'These statistical data show a substantial surge in solar energy adoption.',
                            'These statistical data shows a substantial surge in solar energy adoption.',
                            'These statistical data is show a substantial surge in solar energy adoption.',
                            'These statistical data are shows a substantial surge in solar energy adoption.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dalam standar akademik formal, "data" adalah bentuk jamak dari "datum" (diawali penentu jamak "These"), sehingga predikatnya adalah Verb 1 jamak "show".',
                        'vocab' => [
                            'data' => ['id' => 'data (jamak dari datum)', 'pos' => '(n)'],
                            'show' => ['id' => 'menunjukkan', 'pos' => '(v)'],
                            'substantial surge' => ['id' => 'peningkatan substansial', 'pos' => '(n)'],
                            'adoption' => ['id' => 'adopsi / penerapan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Angka-angka sensus ini mengonfirmasi tren urbanisasi.',
                            'en' => 'These census figures confirm the urbanization trend.'
                        ]
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Mereka mempublikasikan laporan tahunan tentang dampak perubahan iklim global.',
                        'target_word' => 'publish (V1)',
                        'options' => [
                            'They publish an annual report on the impacts of global climate change.',
                            'They publishes an annual report on the impacts of global climate change.',
                            'They are publish an annual report on the impacts of global climate change.',
                            'They publishing an annual report on the impacts of global climate change.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "They" berpasangan dengan Verb 1 dasar "publish" tanpa akhiran -es.',
                        'vocab' => [
                            'publish' => ['id' => 'mempublikasikan', 'pos' => '(v)'],
                            'annual report' => ['id' => 'laporan tahunan', 'pos' => '(n)'],
                            'impacts' => ['id' => 'dampak-dampak', 'pos' => '(n)'],
                            'climate change' => ['id' => 'perubahan iklim', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Mereka merilis artikel tinjauan setiap semester.',
                            'en' => 'They release a review article every semester.'
                        ]
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Banyak universitas terkemuka menawarkan beasiswa penuh bagi mahasiswa internasional.',
                        'target_word' => 'offer (V1)',
                        'options' => [
                            'Many leading universities offer comprehensive scholarships to international scholars.',
                            'Many leading universities offers comprehensive scholarships to international scholars.',
                            'Many leading universities is offer comprehensive scholarships to international scholars.',
                            'Many leading universities are offer comprehensive scholarships to international scholars.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "universities" berbentuk jamak (plural), maka verba yang benar adalah "offer" (V1).',
                        'vocab' => [
                            'leading universities' => ['id' => 'universitas terkemuka', 'pos' => '(n)'],
                            'offer' => ['id' => 'menawarkan', 'pos' => '(v)'],
                            'comprehensive scholarships' => ['id' => 'beasiswa penuh / komprehensif', 'pos' => '(n)'],
                            'scholars' => ['id' => 'mahasiswa / cendekiawan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Institusi riset menyediakan dana hibah penelitian kompetitif.',
                            'en' => 'Research institutes provide competitive study grants.'
                        ]
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Saya berpendapat bahwa pendidikan vokasi memegang peranan krusial dalam pertumbuhan ekonomi.',
                        'target_word' => 'maintain (V1)',
                        'options' => [
                            'I maintain that vocational training plays a vital role in economic development.',
                            'I maintains that vocational training plays a vital role in economic development.',
                            'I am maintain that vocational training plays a vital role in economic development.',
                            'I maintaining that vocational training plays a vital role in economic development.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "I" selalu menggunakan kata kerja dasar Verb 1 ("maintain"), bukan "maintains" dan bukan "am maintain".',
                        'vocab' => [
                            'maintain' => ['id' => 'berpendapat / menegaskan', 'pos' => '(v)'],
                            'vocational training' => ['id' => 'pelatihan vokasi', 'pos' => '(n)'],
                            'vital role' => ['id' => 'peranan krusial / penting', 'pos' => '(n)'],
                            'economic development' => ['id' => 'pembangunan ekonomi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Saya menyimpulkan bahwa intervensi dini mengurangi risiko kegagalan proyek.',
                            'en' => 'I conclude that early intervention reduces project risk.'
                        ]
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Kedua variabel tersebut berinteraksi secara dinamis dalam model simulasi komputer.',
                        'target_word' => 'interact (V1)',
                        'options' => [
                            'Both variables interact dynamically within the computational simulation model.',
                            'Both variables interacts dynamically within the computational simulation model.',
                            'Both variables is interact dynamically within the computational simulation model.',
                            'Both variables are interacts dynamically within the computational simulation model.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "Both variables" adalah jamak (dua variabel), sehingga verba yang tepat adalah "interact" (Verb 1).',
                        'vocab' => [
                            'both variables' => ['id' => 'kedua variabel', 'pos' => '(n)'],
                            'interact' => ['id' => 'berinteraksi', 'pos' => '(v)'],
                            'dynamically' => ['id' => 'secara dinamis', 'pos' => '(adv)'],
                            'simulation model' => ['id' => 'model simulasi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Faktor sosial dan ekonomi saling mempengaruhi dalam proses urbanisasi.',
                            'en' => 'Social and economic factors influence one another during urbanization.'
                        ]
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Anda harus memahami bahwa regulasi baru ini berlaku untuk seluruh lembaga keuangan.',
                        'target_word' => 'apply (V1)',
                        'options' => [
                            'You understand that these updated standards apply to all financial institutions.',
                            'You understands that these updated standards applies to all financial institutions.',
                            'You are understand that these updated standards is apply to all financial institutions.',
                            'You understanding that these updated standards applying to all financial institutions.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "You" berpasangan dengan "understand" (V1), dan subjek jamak "standards" berpasangan dengan "apply" (V1).',
                        'vocab' => [
                            'understand' => ['id' => 'memahami', 'pos' => '(v)'],
                            'updated standards' => ['id' => 'standar terbaru', 'pos' => '(n)'],
                            'apply to' => ['id' => 'berlaku untuk', 'pos' => '(v phr)'],
                            'financial institutions' => ['id' => 'lembaga keuangan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Anda melihat bahwa ketentuan tersebut melindungi hak konsumen.',
                            'en' => 'You observe that the provisions protect consumer rights.'
                        ]
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Masyarakat perkotaan menghasilkan ribuan ton limbah plastik setiap hari.',
                        'target_word' => 'generate (V1)',
                        'options' => [
                            'Urban communities generate thousands of metric tons of plastic waste daily.',
                            'Urban communities generates thousands of metric tons of plastic waste daily.',
                            'Urban communities are generate thousands of metric tons of plastic waste daily.',
                            'Urban communities is generating thousands of metric tons of plastic waste daily.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Urban communities" (masyarakat perkotaan) berbentuk jamak (akhiran -ies), sehingga membutuhkan Verb 1 "generate" tanpa -s.',
                        'vocab' => [
                            'urban communities' => ['id' => 'komunitas / masyarakat perkotaan', 'pos' => '(n)'],
                            'generate' => ['id' => 'menghasilkan', 'pos' => '(v)'],
                            'plastic waste' => ['id' => 'limbah plastik', 'pos' => '(n)'],
                            'daily' => ['id' => 'setiap hari / harian', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Pabrik-pabrik industri mengeluarkan emisi karbon ke atmosfer.',
                            'en' => 'Industrial plants release carbon emissions into the atmosphere.'
                        ]
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Tenaga surya dan energi angin melengkapi pasokan listrik jaringan nasional.',
                        'target_word' => 'complement (V1 - Compound Subject)',
                        'options' => [
                            'Solar power and wind energy complement the national grid electricity supply.',
                            'Solar power and wind energy complements the national grid electricity supply.',
                            'Solar power and wind energy are complement the national grid electricity supply.',
                            'Solar power and wind energy is complement the national grid electricity supply.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dua subjek yang digabungkan kata sambung "and" ("Solar power and wind energy") membentuk compound subject jamak, sehingga memerlukan Verb 1 "complement".',
                        'vocab' => [
                            'solar power' => ['id' => 'tenaga surya', 'pos' => '(n)'],
                            'wind energy' => ['id' => 'energi angin', 'pos' => '(n)'],
                            'complement' => ['id' => 'melengkapi', 'pos' => '(v)'],
                            'national grid' => ['id' => 'jaringan nasional', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Teori dan bukti empiris saling mendukung dalam penelitian ini.',
                            'en' => 'Theory and empirical evidence support each other in this study.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 2: Subjek He, She, It & Benda Tunggal + V1/Vs/es
            // ==========================================
            [
                'id' => 'verbal-singular-vses',
                'name' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                'code' => '1.2.2',
                'concept_title' => 'Konstruksi Kalimat Verbal dengan Subjek He, She, It, dan Singular / Uncountable Nouns',
                'concept_description' => 'Subjek orang ketiga tunggal (He, She, It), nama diri tunggal, kata benda tunggal (the author, the committee, the experiment), serta seluruh kata benda tak dapat dihitung (Uncountable Nouns: research, evidence, information, technology) WAJIB menambahkan akhiran -s, -es, atau -ies pada kata kerja utama (Verb 1). Aturan ini adalah fondasi vital dalam tata bahasa Inggris akademik.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">SUBJEK TUNGGAL / HE, SHE, IT</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Verb 1 + Akhiran (-s / -es / -ies)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-2">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide">Rumus Dasar:</span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">S (He / She / It / Singular / Uncountable) + V1(-s / -es / -ies) + O/C</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">The teacher explains the lesson clearly.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-emerald-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> <span class="text-white">explains</span> &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="text-white line-through">explain</span> / <span class="text-white line-through">is explains</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Wajib menambahkan akhiran -s/-es pada kata kerja jika subjeknya tunggal atau uncountable.',
                    'Kata kerja berakhiran -ch, -sh, -s, -x, -z, dan -o ditambah -es (misal: reaches, focuses, undergoes).',
                    'Kata kerja berakhiran konsonan + y berubah menjadi -ies (misal: applies, specifies, verifies).',
                    'Uncountable nouns (penelitian/research, bukti/evidence, literatur/literature) berstatus singular dan wajib mengambil verba berakhiran -s/-es.',
                    'Dilarang melakukan double predicate seperti "The author is highlights" ➔ WAJIB "The author highlights".'
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Peneliti utama tersebut memverifikasi keakuratan kalkulasi statistik.',
                        'target_word' => 'verifies (V1 + -ies)',
                        'options' => [
                            'The principal investigator verifies the accuracy of the statistical calculations.',
                            'The principal investigator verify the accuracy of the statistical calculations.',
                            'The principal investigator is verifies the accuracy of the statistical calculations.',
                            'The principal investigator are verify the accuracy of the statistical calculations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "The principal investigator" adalah orang ketiga tunggal (he/she), sehingga kata kerja "verify" (konsonan + y) berubah menjadi "verifies".',
                        'vocab' => [
                            'principal investigator' => ['id' => 'peneliti utama', 'pos' => '(n)'],
                            'verify' => ['id' => 'memverifikasi', 'pos' => '(v)'],
                            'accuracy' => ['id' => 'keakuratan / akurasi', 'pos' => '(n)'],
                            'statistical calculations' => ['id' => 'kalkulasi statistik', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Ilmuwan senior tersebut mengonfirmasi temuan awal.',
                            'en' => 'The senior scientist confirms the preliminary findings.'
                        ]
                    ],
                    [
                        'id' => 12,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Bukti empiris menunjukkan hubungan sebab-akibat yang kuat antara kedua fenomena.',
                        'target_word' => 'demonstrates (V1 + -s - Uncountable Subject)',
                        'options' => [
                            'Empirical evidence demonstrates a robust causal relationship between both phenomena.',
                            'Empirical evidence demonstrate a robust causal relationship between both phenomena.',
                            'Empirical evidence is demonstrates a robust causal relationship between both phenomena.',
                            'Empirical evidence are demonstrate a robust causal relationship between both phenomena.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Evidence" adalah uncountable noun (bersifat tunggal), sehingga kata kerjanya wajib berakhiran -s: "demonstrates".',
                        'vocab' => [
                            'empirical evidence' => ['id' => 'bukti empiris', 'pos' => '(n)'],
                            'demonstrate' => ['id' => 'menunjukkan / membuktikan', 'pos' => '(v)'],
                            'robust causal relationship' => ['id' => 'hubungan sebab-akibat yang kuat', 'pos' => '(n)'],
                            'phenomena' => ['id' => 'fenomena-fenomena (jamak)', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Informasi terbaru mengindikasikan perbaikan stabilitas pasar.',
                            'en' => 'Recent information indicates market stabilization.'
                        ]
                    ],
                    [
                        'id' => 13,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Undang-undang ketenagakerjaan baru ini melindungi hak-hak pekerja lepas.',
                        'target_word' => 'protects (V1 + -s)',
                        'options' => [
                            'This new labor legislation protects the legal rights of freelance workers.',
                            'This new labor legislation protect the legal rights of freelance workers.',
                            'This new labor legislation is protects the legal rights of freelance workers.',
                            'This new labor legislation are protect the legal rights of freelance workers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Legislation" adalah singular/uncountable noun, sehingga predikat verbalnya wajib berakhiran -s: "protects".',
                        'vocab' => [
                            'labor legislation' => ['id' => 'undang-undang ketenagakerjaan', 'pos' => '(n)'],
                            'protect' => ['id' => 'melindungi', 'pos' => '(v)'],
                            'legal rights' => ['id' => 'hak-hak hukum', 'pos' => '(n)'],
                            'freelance workers' => ['id' => 'pekerja lepas', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kebijakan lingkungan mengharuskan industri menekan polusi limbah.',
                            'en' => 'Environmental policy mandates industries to curtail effluent discharge.'
                        ]
                    ],
                    [
                        'id' => 14,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Sistem kecerdasan buatan tersebut memproses jutaan parameter dalam hitungan detik.',
                        'target_word' => 'processes (V1 + -es)',
                        'options' => [
                            'The artificial intelligence system processes millions of parameters in seconds.',
                            'The artificial intelligence system process millions of parameters in seconds.',
                            'The artificial intelligence system is processes millions of parameters in seconds.',
                            'The artificial intelligence system are process millions of parameters in seconds.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "process" berakhiran huruf ganda -ss. Untuk subjek tunggal "The system", imbuhannya adalah -es: "processes".',
                        'vocab' => [
                            'artificial intelligence system' => ['id' => 'sistem kecerdasan buatan', 'pos' => '(n)'],
                            'process' => ['id' => 'memproses', 'pos' => '(v)'],
                            'parameters' => ['id' => 'parameter-parameter', 'pos' => '(n)'],
                            'in seconds' => ['id' => 'dalam hitungan detik', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Komputer pusat tersebut mengakses basis data terenkripsi.',
                            'en' => 'The central server accesses encrypted databases.'
                        ]
                    ],
                    [
                        'id' => 15,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Penulis esai tersebut mengkritik ketergantungan berlebihan pada bahan bakar fosil.',
                        'target_word' => 'criticizes (V1 + -s)',
                        'options' => [
                            'The essay author criticizes excessive reliance on conventional fossil fuels.',
                            'The essay author criticize excessive reliance on conventional fossil fuels.',
                            'The essay author is criticizes excessive reliance on conventional fossil fuels.',
                            'The essay author are criticize excessive reliance on conventional fossil fuels.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "The essay author" (orang ketiga tunggal) membutuhkan verba berakhiran -s: "criticizes".',
                        'vocab' => [
                            'essay author' => ['id' => 'penulis esai', 'pos' => '(n)'],
                            'criticize' => ['id' => 'mengkritik', 'pos' => '(v)'],
                            'excessive reliance' => ['id' => 'ketergantungan berlebihan', 'pos' => '(n)'],
                            'fossil fuels' => ['id' => 'bahan bakar fosil', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kritikus sastra meneliti struktur narasi dalam novel tersebut.',
                            'en' => 'The literary critic examines narrative structure in the novel.'
                        ]
                    ],
                    [
                        'id' => 16,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Perekonomian nasional mengalami transformasi struktural menuju digitalisasi.',
                        'target_word' => 'undergoes (V1 + -es / akhiran -o)',
                        'options' => [
                            'The national economy undergoes structural transformation toward digitization.',
                            'The national economy undergo structural transformation toward digitization.',
                            'The national economy is undergoes structural transformation toward digitization.',
                            'The national economy are undergo structural transformation toward digitization.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "undergo" berakhiran huruf vokal -o, sehingga subjek tunggal "The national economy" wajib menambahkan -es: "undergoes".',
                        'vocab' => [
                            'national economy' => ['id' => 'perekonomian nasional', 'pos' => '(n)'],
                            'undergo' => ['id' => 'mengalami', 'pos' => '(v)'],
                            'structural transformation' => ['id' => 'transformasi struktural', 'pos' => '(n)'],
                            'digitization' => ['id' => 'digitalisasi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Spesimen biologis mengalami perubahan bertahap saat dipanaskan.',
                            'en' => 'The biological specimen undergoes gradual change when heated.'
                        ]
                    ],
                    [
                        'id' => 17,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Laporan tinjauan ini merangkum perdebatan akademis selama dua dasawarsa terakhir.',
                        'target_word' => 'summarizes (V1 + -s)',
                        'options' => [
                            'This review report summarizes academic debates over the past two decades.',
                            'This review report summarize academic debates over the past two decades.',
                            'This review report is summarizes academic debates over the past two decades.',
                            'This review report are summarize academic debates over the past two decades.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This review report" adalah singular noun, sehingga memerlukan kata kerja tunggal "summarizes".',
                        'vocab' => [
                            'review report' => ['id' => 'laporan tinjauan', 'pos' => '(n)'],
                            'summarize' => ['id' => 'merangkum', 'pos' => '(v)'],
                            'academic debates' => ['id' => 'perdebatan akademis', 'pos' => '(n)'],
                            'two decades' => ['id' => 'dua dasawarsa / 20 tahun', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Paragraf pengantar merangkum tujuan utama penelitian.',
                            'en' => 'The introductory paragraph encapsulates the primary research aim.'
                        ]
                    ],
                    [
                        'id' => 18,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Perusahaan multinasional tersebut mengalokasikan anggaran riset yang substansial.',
                        'target_word' => 'allocates (V1 + -s)',
                        'options' => [
                            'The multinational corporation allocates a substantial annual research budget.',
                            'The multinational corporation allocate a substantial annual research budget.',
                            'The multinational corporation is allocates a substantial annual research budget.',
                            'The multinational corporation are allocate a substantial annual research budget.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "corporation" berbentuk tunggal (it), sehingga verba yang tepat adalah "allocates".',
                        'vocab' => [
                            'multinational corporation' => ['id' => 'perusahaan multinasional', 'pos' => '(n)'],
                            'allocate' => ['id' => 'mengalokasikan', 'pos' => '(v)'],
                            'substantial' => ['id' => 'substansial / besar', 'pos' => '(adj)'],
                            'research budget' => ['id' => 'anggaran riset', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Badan pemerintah menyalurkan subsidi kepada petani lokal.',
                            'en' => 'The government agency distributes subsidies to local farmers.'
                        ]
                    ],
                    [
                        'id' => 19,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Teori relativitas umum menjelaskan kelengkungan ruang dan waktu di sekitar massa besar.',
                        'target_word' => 'explains (V1 + -s)',
                        'options' => [
                            'The theory of general relativity explains spacetime curvature around massive bodies.',
                            'The theory of general relativity explain spacetime curvature around massive bodies.',
                            'The theory of general relativity is explains spacetime curvature around massive bodies.',
                            'The theory of general relativity are explain spacetime curvature around massive bodies.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun kalimat adalah "The theory" (singular). Kata kerja yang berpasangan adalah "explains".',
                        'vocab' => [
                            'theory of general relativity' => ['id' => 'teori relativitas umum', 'pos' => '(n)'],
                            'explain' => ['id' => 'menjelaskan', 'pos' => '(v)'],
                            'spacetime curvature' => ['id' => 'kelengkungan ruang dan waktu', 'pos' => '(n)'],
                            'massive bodies' => ['id' => 'massa / benda masif', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Model matematika menjelaskan perambatan gelombang seismik.',
                            'en' => 'The mathematical model accounts for seismic wave propagation.'
                        ]
                    ],
                    [
                        'id' => 20,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Setiap anggota komite membawa perspektif unik ke dalam diskusi meja bundar.',
                        'target_word' => 'brings (V1 + -s - "Each" Subject)',
                        'options' => [
                            'Each committee member brings a unique perspective to the roundtable deliberations.',
                            'Each committee member bring a unique perspective to the roundtable deliberations.',
                            'Each committee member are bring a unique perspective to the roundtable deliberations.',
                            'Each committee member is brings a unique perspective to the roundtable deliberations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek yang diawali "Each" atau "Every" selalu berstatus singular (tunggal) dan wajib berpasangan dengan Verb berakhiran -s: "brings".',
                        'vocab' => [
                            'each committee member' => ['id' => 'setiap anggota komite', 'pos' => '(n)'],
                            'bring' => ['id' => 'membawa', 'pos' => '(v)'],
                            'unique perspective' => ['id' => 'perspektif unik', 'pos' => '(n)'],
                            'deliberations' => ['id' => 'diskusi / pertimbangan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Setiap peserta tes menyerahkan kartu identitas resmi.',
                            'en' => 'Every test taker submits official identification.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 3: Bentuk Negatif Kalimat Verbal (Do not vs. Does not + V1)
            // ==========================================
            [
                'id' => 'verbal-negative-forms',
                'name' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                'code' => '1.2.3',
                'concept_title' => 'Pembentukan Kalimat Negatif Verbal dengan Auxiliary Do not & Does not',
                'concept_description' => 'Kalimat verbal tidak dapat dinegatifkan hanya dengan menyisipkan kata "not" langsung pada kata kerja. Wajib menggunakan kata kerja bantu (auxiliary verb): "do not" (don\'t) untuk subjek I, You, We, They, dan Benda Jamak; serta "does not" (doesn\'t) untuk subjek He, She, It, dan Benda Tunggal. Yang paling krusial: setelah "does not", kata kerja utama SELALU kembali ke bentuk dasar V1 tanpa akhiran -s/-es.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-rose-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-rose-500/25 text-rose-300 border border-rose-500/50 font-mono">BENTUK NEGATIF VERBAL</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Wajib Menggunakan <em>Do not / Does not</em></span>
    </div>

    <div class="px-3 py-1.5 rounded-lg bg-amber-950/70 border border-amber-400 text-xs text-white flex items-center gap-2">
        <span class="font-black text-amber-300 uppercase tracking-wider">[PERHATIAN]</span>
        <span>Setelah <strong>does not</strong>, kata kerja SELALU kembali ke bentuk dasar <strong>V1 murni</strong> (tanpa -s/-es).</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide">[1] Subjek Jamak / I, You, We, They</span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">Subject + DO NOT (don't) + V1 + O/C</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">They do not understand the instructions.</span>
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-sky-300 uppercase tracking-wide">[2] Subjek Tunggal / He, She, It</span>
            <code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1 rounded border border-sky-500/40">Subject + DOES NOT (doesn't) + V1 (Murni) + O/C</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">She does not like spicy food.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-sky-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> <span class="text-white">does not like</span> &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="text-white line-through">does not likes</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan "do not" untuk subjek I, you, we, they, dan benda jamak.',
                    'Gunakan "does not" untuk subjek he, she, it, dan benda tunggal / uncountable.',
                    'Setelah "does not", kata kerja utama WAJIB kembali ke bentuk dasar Verb 1 murni (TIDAK BOLEH "does not shows" ➔ WAJIB "does not show").',
                    'Dilarang menggunakan to be seperti "is not show" atau "are not agree" untuk menyangkal kalimat verbal.'
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Data statistik terbaru tidak mendukung klaim yang diajukan oleh kelompok penentang.',
                        'target_word' => 'do not support (Plural Data)',
                        'options' => [
                            'The latest statistical data do not support the claim made by the opposing coalition.',
                            'The latest statistical data does not supports the claim made by the opposing coalition.',
                            'The latest statistical data are not support the claim made by the opposing coalition.',
                            'The latest statistical data is not support the claim made by the opposing coalition.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata "data" adalah plural (jamak), sehingga bentuk negatif verbal yang tepat adalah "do not support". Opsi "are not support" salah karena double predicate.',
                        'vocab' => [
                            'latest statistical data' => ['id' => 'data statistik terbaru', 'pos' => '(n)'],
                            'do not support' => ['id' => 'tidak mendukung', 'pos' => '(v phr)'],
                            'claim' => ['id' => 'klaim / pernyataan', 'pos' => '(n)'],
                            'opposing coalition' => ['id' => 'kelompok / koalisi penentang', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Temuan kami tidak menunjukkan korelasi antara kedua variabel.',
                            'en' => 'Our findings do not show correlation between the two variables.'
                        ]
                    ],
                    [
                        'id' => 22,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Penulis laporan tidak menyetujui rekomendasi pemangkasan anggaran operasional.',
                        'target_word' => 'does not endorse (Singular Subject)',
                        'options' => [
                            'The report author does not endorse the recommendation to reduce operating budgets.',
                            'The report author does not endorses the recommendation to reduce operating budgets.',
                            'The report author is not endorse the recommendation to reduce operating budgets.',
                            'The report author do not endorse the recommendation to reduce operating budgets.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "author" (tunggal) menggunakan "does not", dan verba utama kembali ke bentuk dasar "endorse" tanpa -s. Bentuk "does not endorses" adalah kesalahan dobel penanda tunggal.',
                        'vocab' => [
                            'report author' => ['id' => 'penulis laporan', 'pos' => '(n)'],
                            'does not endorse' => ['id' => 'tidak menyetujui / mendukung', 'pos' => '(v phr)'],
                            'recommendation' => ['id' => 'rekomendasi', 'pos' => '(n)'],
                            'operating budget' => ['id' => 'anggaran operasional', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pemerintah daerah tidak memungut pajak tambahan atas ekspor.',
                            'en' => 'The regional administration does not levy supplementary tariffs on exports.'
                        ]
                    ],
                    [
                        'id' => 23,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Kami tidak mengabaikan keterbatasan metodologis dalam penelitian kuantitatif ini.',
                        'target_word' => 'do not overlook (Subject "We")',
                        'options' => [
                            'We do not overlook methodological constraints in this quantitative investigation.',
                            'We does not overlook methodological constraints in this quantitative investigation.',
                            'We are not overlook methodological constraints in this quantitative investigation.',
                            'We do not overlooks methodological constraints in this quantitative investigation.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "We" berpasangan dengan auxiliary "do not" diikuti Verb 1 dasar "overlook".',
                        'vocab' => [
                            'overlook' => ['id' => 'mengabaikan / melewatkan', 'pos' => '(v)'],
                            'methodological constraints' => ['id' => 'keterbatasan metodologis', 'pos' => '(n)'],
                            'quantitative investigation' => ['id' => 'penelitian kuantitatif', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kami tidak membenarkan manipulasi data dalam bentuk apapun.',
                            'en' => 'We do not condone data manipulation in any form.'
                        ]
                    ],
                    [
                        'id' => 24,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Sistem perbankan konvensional tidak menjamin imbal hasil tinggi saat inflasi tinggi.',
                        'target_word' => 'does not guarantee (Singular System)',
                        'options' => [
                            'The conventional banking system does not guarantee high returns during elevated inflation.',
                            'The conventional banking system does not guarantees high returns during elevated inflation.',
                            'The conventional banking system is not guarantee high returns during elevated inflation.',
                            'The conventional banking system do not guarantee high returns during elevated inflation.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The system" mengambil auxiliary "does not" dan kata kerja murni "guarantee" tanpa akhiran -s.',
                        'vocab' => [
                            'conventional banking system' => ['id' => 'sistem perbankan konvensional', 'pos' => '(n)'],
                            'does not guarantee' => ['id' => 'tidak menjamin', 'pos' => '(v phr)'],
                            'high returns' => ['id' => 'imbal hasil tinggi', 'pos' => '(n)'],
                            'elevated inflation' => ['id' => 'inflasi tinggi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Perangkat lunak ini tidak memerlukan instalasi tambahan.',
                            'en' => 'This software package does not require additional configuration.'
                        ]
                    ],
                    [
                        'id' => 25,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Sebagian besar konsumen di kota besar tidak mempercayai iklan tanpa ulasan nyata.',
                        'target_word' => 'do not trust (Plural Consumers)',
                        'options' => [
                            'Most urban consumers do not trust commercial advertisements devoid of verified reviews.',
                            'Most urban consumers does not trust commercial advertisements devoid of verified reviews.',
                            'Most urban consumers are not trust commercial advertisements devoid of verified reviews.',
                            'Most urban consumers do not trusts commercial advertisements devoid of verified reviews.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Most urban consumers" adalah plural (jamak), sehingga bentuk negatifnya menggunakan "do not trust".',
                        'vocab' => [
                            'urban consumers' => ['id' => 'konsumen perkotaan', 'pos' => '(n)'],
                            'do not trust' => ['id' => 'tidak mempercayai', 'pos' => '(v phr)'],
                            'advertisements' => ['id' => 'iklan-iklan komersial', 'pos' => '(n)'],
                            'devoid of' => ['id' => 'tanpa adanya / hampa dari', 'pos' => '(adj phr)'],
                        ],
                        'example' => [
                            'id' => 'Banyak warga tidak menyadari risiko keamanan siber.',
                            'en' => 'Many citizens do not recognize cybersecurity hazards.'
                        ]
                    ],
                    [
                        'id' => 26,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Penelitian ilmiah ini tidak membuktikan hubungan kausalitas langsung.',
                        'target_word' => 'does not prove (Uncountable Research)',
                        'options' => [
                            'This scientific research does not prove a direct causal relationship.',
                            'This scientific research does not proves a direct causal relationship.',
                            'This scientific research is not prove a direct causal relationship.',
                            'This scientific research do not prove a direct causal relationship.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Research" adalah kata benda tak dapat dihitung (uncountable noun / tunggal), sehingga auxiliary yang tepat adalah "does not" dan verba dasarnya adalah "prove" (tanpa -s).',
                        'vocab' => [
                            'scientific research' => ['id' => 'penelitian ilmiah', 'pos' => '(n)'],
                            'does not prove' => ['id' => 'tidak membuktikan', 'pos' => '(v phr)'],
                            'direct causal relationship' => ['id' => 'hubungan kausalitas langsung', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Bukti medis tidak membenarkan penggunaan dosis berlebih.',
                            'en' => 'Clinical evidence does not justify excessive dosage.'
                        ]
                    ],
                    [
                        'id' => 27,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Perjanjian kerja sama bilateral tersebut tidak mencakup klausul pengalihan teknologi.',
                        'target_word' => 'does not include (Singular Treaty)',
                        'options' => [
                            'The bilateral cooperation treaty does not include clauses on intellectual property transfer.',
                            'The bilateral cooperation treaty does not includes clauses on intellectual property transfer.',
                            'The bilateral cooperation treaty is not include clauses on intellectual property transfer.',
                            'The bilateral cooperation treaty do not include clauses on intellectual property transfer.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "treaty" (perjanjian) berbentuk tunggal, maka bentuk negatifnya adalah "does not include".',
                        'vocab' => [
                            'bilateral treaty' => ['id' => 'perjanjian bilateral', 'pos' => '(n)'],
                            'does not include' => ['id' => 'tidak mencakup', 'pos' => '(v phr)'],
                            'intellectual property transfer' => ['id' => 'pengalihan kekayaan intelektual', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Dokumen kontrak tersebut tidak memuat jaminan ganti rugi.',
                            'en' => 'The contract document does not contain indemnity guarantees.'
                        ]
                    ],
                    [
                        'id' => 28,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Partisipan survei tidak mengungkapkan identitas pribadi mereka kepada pewawancara.',
                        'target_word' => 'do not disclose (Plural Participants)',
                        'options' => [
                            'Survey participants do not disclose their personal identifiable information to interviewers.',
                            'Survey participants does not disclose their personal identifiable information to interviewers.',
                            'Survey participants are not disclose their personal identifiable information to interviewers.',
                            'Survey participants do not discloses their personal identifiable information to interviewers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "participants" berbentuk jamak, sehingga memerlukan "do not disclose" (Verb 1).',
                        'vocab' => [
                            'survey participants' => ['id' => 'partisipan survei', 'pos' => '(n)'],
                            'do not disclose' => ['id' => 'tidak mengungkapkan', 'pos' => '(v phr)'],
                            'identifiable information' => ['id' => 'informasi identitas', 'pos' => '(n)'],
                            'interviewers' => ['id' => 'pewawancara', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Responden tidak membagikan rincian kontak mereka.',
                            'en' => 'Respondents do not share their contact details.'
                        ]
                    ],
                    [
                        'id' => 29,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Model ekonometrika ini tidak memperhitungkan guncangan geopolitik eksternal.',
                        'target_word' => 'does not account for (Singular Model)',
                        'options' => [
                            'This econometric model does not account for external geopolitical supply shocks.',
                            'This econometric model does not accounts for external geopolitical supply shocks.',
                            'This econometric model is not account for external geopolitical supply shocks.',
                            'This econometric model do not account for external geopolitical supply shocks.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "This econometric model" (tunggal) menggunakan "does not account for".',
                        'vocab' => [
                            'econometric model' => ['id' => 'model ekonometrika', 'pos' => '(n)'],
                            'account for' => ['id' => 'memperhitungkan / menjelaskan', 'pos' => '(v phr)'],
                            'geopolitical shocks' => ['id' => 'guncangan geopolitik', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Simulasi ini tidak memperhitungkan pengaruh gravitasi bulan.',
                            'en' => 'This simulation does not consider lunar gravitational forces.'
                        ]
                    ],
                    [
                        'id' => 30,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Saya tidak meragukan integritas komite peninjau sejawat.',
                        'target_word' => 'do not question (Subject "I")',
                        'options' => [
                            'I do not question the institutional integrity of the peer review committee.',
                            'I does not question the institutional integrity of the peer review committee.',
                            'I am not question the institutional integrity of the peer review committee.',
                            'I do not questions the institutional integrity of the peer review committee.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "I" selalu dinegatifkan dengan "do not" diikuti verba dasar "question".',
                        'vocab' => [
                            'question' => ['id' => 'meragukan / mempertanyakan', 'pos' => '(v)'],
                            'institutional integrity' => ['id' => 'integritas kelembagaan', 'pos' => '(n)'],
                            'peer review committee' => ['id' => 'komite peninjau sejawat', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Saya tidak menentang penerapan teknologi kecerdasan buatan.',
                            'en' => 'I do not oppose the deployment of artificial intelligence.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 4: Bentuk Tanya / Interrogatif Verbal (Do & Does + S + V1)
            // ==========================================
            [
                'id' => 'verbal-interrogative-forms',
                'name' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                'code' => '1.2.4',
                'concept_title' => 'Pembentukan Kalimat Tanya Verbal dalam Simple Present Tense',
                'concept_description' => 'Kalimat tanya verbal Simple Present dibentuk dengan menempatkan kata kerja bantu (auxiliary verb) Do atau Does di depan subjek. Untuk subjek I, You, We, They, dan Benda Jamak, gunakan DO. Untuk subjek He, She, It, dan Benda Tunggal, gunakan DOES. Setelah subjek, kata kerja utama WAJIB berbentuk Verb 1 dasar (infinitive tanpa to dan tanpa -s/-es). Formula yang sama berlaku untuk pertanyaan informasi dengan kata tanya WH (What, Why, How, Which).',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">BENTUK TANYA VERBAL</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Inversi Kata Bantu <em>Do / Does</em> di Awal</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide">[1] Yes / No Question</span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">DO / DOES + Subject + V1 (Murni) + ... ?</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5 space-y-1">
            <div><span class="text-emerald-400 font-bold not-italic">Jamak:</span> <span class="italic text-white">Do you live near the station?</span></div>
            <div><span class="text-sky-400 font-bold not-italic">Tunggal:</span> <span class="italic text-white">Does he speak English fluently?</span> <span class="text-yellow-300 font-bold">(V1 murni tanpa -s)</span></div>
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-sky-300 uppercase tracking-wide">[2] WH- Question (Informasi)</span>
            <code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1 rounded border border-sky-500/40">WH-Word + DO / DOES + Subject + V1 (Murni) + ... ?</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Where does she work during weekdays?</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan Do untuk subjek jamak dan I/You/We/They.',
                    'Gunakan Does untuk subjek tunggal dan He/She/It.',
                    'Kata kerja utama selalu kembali ke bentuk Verb 1 dasar tanpa -s/-es ("Does the study indicate?", BUKAN "Does the study indicates?").',
                    'Jika menggunakan Question Words (What, Where, Why, How), susunannya adalah: WH-Word + Do/Does + Subject + Verb 1.',
                    'Dilarang menggunakan to be seperti "Is the regulation apply?" ➔ WAJIB "Does the regulation apply?".'
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah kerangka hukum ini melindungi hak paten inovator independen?',
                        'target_word' => 'Does this legal framework protect (Singular Question)',
                        'options' => [
                            'Does this legal framework protect the patent rights of independent innovators?',
                            'Does this legal framework protects the patent rights of independent innovators?',
                            'Is this legal framework protect the patent rights of independent innovators?',
                            'Do this legal framework protect the patent rights of independent innovators?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "this legal framework" adalah tunggal, maka menggunakan auxiliary "Does". Verba utama harus kembali ke V1 "protect" tanpa akhiran -s.',
                        'vocab' => [
                            'legal framework' => ['id' => 'kerangka hukum', 'pos' => '(n)'],
                            'protect' => ['id' => 'melindungi', 'pos' => '(v)'],
                            'patent rights' => ['id' => 'hak paten', 'pos' => '(n)'],
                            'independent innovators' => ['id' => 'inovator independen', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah kebijakan ini menjamin keadilan akses pendidikan?',
                            'en' => 'Does this policy ensure equitable educational access?'
                        ]
                    ],
                    [
                        'id' => 32,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah para ilmuwan mengonfirmasi keterkaitan antara emisi karbon dan pemanasan global?',
                        'target_word' => 'Do scientists confirm (Plural Question)',
                        'options' => [
                            'Do scientists confirm the link between carbon emissions and global warming?',
                            'Does scientists confirm the link between carbon emissions and global warming?',
                            'Are scientists confirm the link between carbon emissions and global warming?',
                            'Do scientists confirms the link between carbon emissions and global warming?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "scientists" adalah jamak (plural), sehingga kata bantu tanya yang tepat adalah "Do", diikuti Verb 1 dasar "confirm".',
                        'vocab' => [
                            'scientists' => ['id' => 'para ilmuwan', 'pos' => '(n)'],
                            'confirm' => ['id' => 'mengonfirmasi', 'pos' => '(v)'],
                            'link' => ['id' => 'keterkaitan / hubungan', 'pos' => '(n)'],
                            'carbon emissions' => ['id' => 'emisi karbon', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah para ekonom menyepakati estimasi pertumbuhan ini?',
                            'en' => 'Do economists agree with these growth projections?'
                        ]
                    ],
                    [
                        'id' => 33,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Bagaimana algoritma pembelajaran mesin ini mendeteksi anomali dalam transaksi finansial?',
                        'target_word' => 'How does this algorithm detect (WH- Question)',
                        'options' => [
                            'How does this machine learning algorithm detect anomalies in financial transactions?',
                            'How does this machine learning algorithm detects anomalies in financial transactions?',
                            'How is this machine learning algorithm detect anomalies in financial transactions?',
                            'How do this machine learning algorithm detect anomalies in financial transactions?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pada kalimat tanya WH dengan subjek tunggal "algorithm", urutan yang benar adalah: How + does + Subject + Verb 1 ("detect").',
                        'vocab' => [
                            'algorithm' => ['id' => 'algoritma', 'pos' => '(n)'],
                            'detect' => ['id' => 'mendeteksi', 'pos' => '(v)'],
                            'anomalies' => ['id' => 'anomali / kejanggalan', 'pos' => '(n)'],
                            'financial transactions' => ['id' => 'transaksi finansial', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Bagaimana sistem ini memproses data dalam jumlah besar?',
                            'en' => 'How does this system process massive datasets?'
                        ]
                    ],
                    [
                        'id' => 34,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Mengapa banyak negara berkembang mengimpor teknologi medis dari luar negeri?',
                        'target_word' => 'Why do developing nations import (WH- Plural)',
                        'options' => [
                            'Why do many developing nations import advanced medical technology from abroad?',
                            'Why does many developing nations import advanced medical technology from abroad?',
                            'Why are many developing nations import advanced medical technology from abroad?',
                            'Why do many developing nations imports advanced medical technology from abroad?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "nations" adalah jamak, maka kata bantu tanya adalah "do", diikuti Verb 1 "import".',
                        'vocab' => [
                            'developing nations' => ['id' => 'negara-negara berkembang', 'pos' => '(n)'],
                            'import' => ['id' => 'mengimpor', 'pos' => '(v)'],
                            'medical technology' => ['id' => 'teknologi medis', 'pos' => '(n)'],
                            'from abroad' => ['id' => 'dari luar negeri', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Mengapa perusahaan mengadopsi model kerja jarak jauh?',
                            'en' => 'Why do companies adopt remote work models?'
                        ]
                    ],
                    [
                        'id' => 35,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah bukti empiris ini mendukung hipotesis yang diajukan peneliti?',
                        'target_word' => 'Does this empirical evidence corroborate',
                        'options' => [
                            'Does this empirical evidence corroborate the hypothesis proposed by the author?',
                            'Does this empirical evidence corroborates the hypothesis proposed by the author?',
                            'Is this empirical evidence corroborate the hypothesis proposed by the author?',
                            'Do this empirical evidence corroborate the hypothesis proposed by the author?'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Evidence" adalah uncountable noun (tunggal), maka kata bantu tanya yang tepat adalah "Does", dan verb-nya "corroborate" (tanpa -s).',
                        'vocab' => [
                            'empirical evidence' => ['id' => 'bukti empiris', 'pos' => '(n)'],
                            'corroborate' => ['id' => 'menguatkan / mendukung', 'pos' => '(v)'],
                            'hypothesis' => ['id' => 'hipotesis', 'pos' => '(n)'],
                            'proposed' => ['id' => 'yang diajukan', 'pos' => '(adj/participle)'],
                        ],
                        'example' => [
                            'id' => 'Apakah penelitian ini membuktikan keberhasilan vaksin?',
                            'en' => 'Does this research validate vaccine efficacy?'
                        ]
                    ],
                    [
                        'id' => 36,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Berapa banyak energi yang dikonsumsi oleh pabrik pengolahan ini setiap jam?',
                        'target_word' => 'How much energy does this processing facility consume',
                        'options' => [
                            'How much energy does this processing facility consume on an hourly basis?',
                            'How much energy does this processing facility consumes on an hourly basis?',
                            'How much energy is this processing facility consume on an hourly basis?',
                            'How much energy do this processing facility consume on an hourly basis?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "facility" adalah tunggal, sehingga menggunakan "does ... consume" (Verb 1).',
                        'vocab' => [
                            'energy' => ['id' => 'energi', 'pos' => '(n)'],
                            'processing facility' => ['id' => 'fasilitas / pabrik pengolahan', 'pos' => '(n)'],
                            'consume' => ['id' => 'mengonsumsi', 'pos' => '(v)'],
                            'hourly basis' => ['id' => 'setiap jam', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Berapa banyak air yang dibutuhkan oleh reaktor pendingin?',
                            'en' => 'How much water does the cooling reactor require?'
                        ]
                    ],
                    [
                        'id' => 37,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah Anda mengakui keterbatasan data dalam bab kesimpulan?',
                        'target_word' => 'Do you acknowledge (Subject "You")',
                        'options' => [
                            'Do you acknowledge data limitations within the concluding chapter?',
                            'Does you acknowledge data limitations within the concluding chapter?',
                            'Are you acknowledge data limitations within the concluding chapter?',
                            'Do you acknowledges data limitations within the concluding chapter?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "You" berpasangan dengan kata bantu tanya "Do", diikuti Verb 1 dasar "acknowledge".',
                        'vocab' => [
                            'acknowledge' => ['id' => 'mengakui', 'pos' => '(v)'],
                            'data limitations' => ['id' => 'keterbatasan data', 'pos' => '(n)'],
                            'concluding chapter' => ['id' => 'bab kesimpulan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah Anda setuju dengan interpretasi data ini?',
                            'en' => 'Do you concur with this data interpretation?'
                        ]
                    ],
                    [
                        'id' => 38,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah undang-undang baru ini berlaku untuk perusahaan multinasional asing?',
                        'target_word' => 'Does this new legislation apply',
                        'options' => [
                            'Does this new legislation apply to foreign multinational corporations?',
                            'Does this new legislation applies to foreign multinational corporations?',
                            'Is this new legislation apply to foreign multinational corporations?',
                            'Do this new legislation apply to foreign multinational corporations?'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Legislation" adalah singular/uncountable, sehingga wajib menggunakan "Does" dan verba "apply" (V1).',
                        'vocab' => [
                            'legislation' => ['id' => 'undang-undang / regulasi', 'pos' => '(n)'],
                            'apply to' => ['id' => 'berlaku untuk', 'pos' => '(v phr)'],
                            'foreign multinational corporations' => ['id' => 'perusahaan multinasional asing', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah aturan ini berlaku bagi seluruh mahasiswa baru?',
                            'en' => 'Does this regulation apply to all matriculating students?'
                        ]
                    ],
                    [
                        'id' => 39,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Faktor apa saja yang memicu peningkatan inflasi di kawasan regional?',
                        'target_word' => 'What factors trigger (Subject Question - Plural)',
                        'options' => [
                            'What factors trigger the inflationary pressure across the regional economy?',
                            'What factors triggers the inflationary pressure across the regional economy?',
                            'What factors does trigger the inflationary pressure across the regional economy?',
                            'What factors is trigger the inflationary pressure across the regional economy?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Ketika kata tanya menanyakan subjek langsung berupa nomina jamak ("What factors"), kata kerja langsung menggunakan Verb 1 jamak "trigger" tanpa auxiliary do/does tambahan.',
                        'vocab' => [
                            'factors' => ['id' => 'faktor-faktor', 'pos' => '(n)'],
                            'trigger' => ['id' => 'memicu', 'pos' => '(v)'],
                            'inflationary pressure' => ['id' => 'tekanan inflasi', 'pos' => '(n)'],
                            'regional economy' => ['id' => 'ekonomi regional', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Variabel apa yang mempengaruhi kepuasan pelanggan?',
                            'en' => 'What variables influence customer satisfaction?'
                        ]
                    ],
                    [
                        'id' => 40,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah para peserta memahami petunjuk keselamatan di laboratorium kimia?',
                        'target_word' => 'Do participants comprehend',
                        'options' => [
                            'Do participants comprehend the safety protocols in the chemical laboratory?',
                            'Does participants comprehend the safety protocols in the chemical laboratory?',
                            'Are participants comprehend the safety protocols in the chemical laboratory?',
                            'Do participants comprehends the safety protocols in the chemical laboratory?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "participants" adalah plural, sehingga menggunakan auxiliary "Do" + Verb 1 "comprehend".',
                        'vocab' => [
                            'participants' => ['id' => 'para peserta / partisipan', 'pos' => '(n)'],
                            'comprehend' => ['id' => 'memahami', 'pos' => '(v)'],
                            'safety protocols' => ['id' => 'protokol keselamatan', 'pos' => '(n)'],
                            'chemical laboratory' => ['id' => 'laboratorium kimia', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah para siswa menaati peraturan laboratorium?',
                            'en' => 'Do students observe laboratory safety rules?'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 5: Aturan Ejaan Akhiran Verba (-s, -es, -ies)
            // ==========================================
            [
                'id' => 'verbal-spelling-rules',
                'name' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                'code' => '1.2.5',
                'concept_title' => 'Aturan Morfologis dan Ejaan Penambahan Akhiran -s, -es, dan -ies pada Verba',
                'concept_description' => 'Penambahan akhiran pada kata kerja orang ketiga tunggal (He, She, It, Singular Nouns) mengikuti aturan ejaan fonologis baku bahasa Inggris: (1) Kata kerja berakhiran desis (-ch, -sh, -ss, -x, -z) dan vokal -o ditambah -es (reach ➔ reaches, focus ➔ focuses, go ➔ goes); (2) Kata kerja berakhiran konsonan + y berubah menjadi -ies (apply ➔ applies, study ➔ studies); (3) Kata kerja berakhiran vokal + y cukup ditambah -s saja (play ➔ plays, display ➔ displays); (4) Kata kerja tak beraturan khusus: have ➔ has.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-indigo-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-indigo-500/25 text-indigo-300 border border-indigo-500/50 font-mono">KAIDAH EJAAN VERBA</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Penambahan Akhiran pada Subjek Orang Ketiga Tunggal</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600">
            <div class="text-xs font-bold text-amber-300 mb-1">1. Akhiran Desis &amp; -o ➔ +es</div>
            <code class="text-xs font-mono text-white block bg-slate-950 p-2 rounded border border-slate-700">
                -ch, -sh, -ss, -x, -z, -o<br>
                watch ➔ <strong class="text-amber-300">watches</strong> | go ➔ <strong class="text-amber-300">goes</strong>
            </code>
        </div>
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600">
            <div class="text-xs font-bold text-sky-300 mb-1">2. Konsonan + y ➔ -ies</div>
            <code class="text-xs font-mono text-white block bg-slate-950 p-2 rounded border border-slate-700">
                study ➔ <strong class="text-sky-300">studies</strong><br>
                carry ➔ <strong class="text-sky-300">carries</strong>
            </code>
        </div>
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600">
            <div class="text-xs font-bold text-emerald-300 mb-1">3. Vokal + y ➔ +s saja</div>
            <code class="text-xs font-mono text-white block bg-slate-950 p-2 rounded border border-slate-700">
                play ➔ <strong class="text-emerald-300">plays</strong><br>
                stay ➔ <strong class="text-emerald-300">stays</strong> (Bukan *staies*)
            </code>
        </div>
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600">
            <div class="text-xs font-bold text-purple-300 mb-1">4. Verba Khusus</div>
            <code class="text-xs font-mono text-white block bg-slate-950 p-2 rounded border border-slate-700">
                have ➔ <strong class="text-purple-300">has</strong><br>
                Kata kerja lainnya ➔ +s (work ➔ works)
            </code>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Verba berakhiran konsonan + y wajib diubah menjadi -ies (identify ➔ identifies, qualify ➔ qualifies).',
                    'Verba berakhiran vokal + y TIDAK BOLEH diubah jadi -ies, cukup ditambah -s (convey ➔ conveys, delay ➔ delays).',
                    'Verba berakhiran bunyi desis (-s, -ss, -sh, -ch, -x) dan vokal -o wajib ditambah -es agar dapat diucapkan (assess ➔ assesses, diminish ➔ diminishes).',
                    'Bentuk kepemilikan kata kerja have berubah menjadi "has" untuk subjek tunggal.'
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Peneliti tersebut menerapkan metodologi statistik baru untuk menyaring sampel.',
                        'target_word' => 'applies (consonant + y -> -ies)',
                        'options' => [
                            'The researcher applies a novel statistical methodology to filter the sample.',
                            'The researcher applys a novel statistical methodology to filter the sample.',
                            'The researcher apply a novel statistical methodology to filter the sample.',
                            'The researcher is applies a novel statistical methodology to filter the sample.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "apply" berakhiran konsonan \'l\' + \'y\'. Aturan ejaannya adalah mengubah \'y\' menjadi \'ies\': "applies". Bentuk "applys" salah secara ejaan.',
                        'vocab' => [
                            'researcher' => ['id' => 'peneliti', 'pos' => '(n)'],
                            'apply' => ['id' => 'menerapkan', 'pos' => '(v)'],
                            'novel methodology' => ['id' => 'metodologi baru / mutakhir', 'pos' => '(n)'],
                            'filter' => ['id' => 'menyaring', 'pos' => '(v)'],
                        ],
                        'example' => [
                            'id' => 'Ilmuwan tersebut memodifikasi rancangan eksperimen.',
                            'en' => 'The scientist modifies the experimental design.'
                        ]
                    ],
                    [
                        'id' => 42,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Grafik ini menyampaikan tren konsumsi energi terbarukan di negara-negara maju.',
                        'target_word' => 'conveys (vowel + y -> -s)',
                        'options' => [
                            'This chart conveys clean energy consumption trajectories across developed nations.',
                            'This chart conveies clean energy consumption trajectories across developed nations.',
                            'This chart convey clean energy consumption trajectories across developed nations.',
                            'This chart is conveys clean energy consumption trajectories across developed nations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "convey" berakhiran vokal \'e\' + \'y\'. Oleh karena itu, cukup menambahkan akhiran -s saja ("conveys"). Jangan diubah menjadi "conveies".',
                        'vocab' => [
                            'chart' => ['id' => 'grafik / bagan', 'pos' => '(n)'],
                            'convey' => ['id' => 'menyampaikan / menggambarkan', 'pos' => '(v)'],
                            'trajectories' => ['id' => 'tren / lintasan perkembangan', 'pos' => '(n)'],
                            'developed nations' => ['id' => 'negara-negara maju', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Diagram tersebut menampilkan rincian persentase.',
                            'en' => 'The diagram displays percentage breakdowns.'
                        ]
                    ],
                    [
                        'id' => 43,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Komite penilai mengevaluasi dan menilai kelayakan teknis proyek infrastruktur.',
                        'target_word' => 'assesses (ending in -ss -> +es)',
                        'options' => [
                            'The evaluation committee assesses the engineering feasibility of the infrastructure project.',
                            'The evaluation committee assesss the engineering feasibility of the infrastructure project.',
                            'The evaluation committee assess the engineering feasibility of the infrastructure project.',
                            'The evaluation committee is assesses the engineering feasibility of the infrastructure project.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "assess" berakhiran konsonan desis -ss, sehingga wajib ditambah -es: "assesses". Penulisan "assesss" dengan 3 huruf \'s\' salah.',
                        'vocab' => [
                            'evaluation committee' => ['id' => 'komite penilai / evaluasi', 'pos' => '(n)'],
                            'assess' => ['id' => 'menilai / mengevaluasi', 'pos' => '(v)'],
                            'feasibility' => ['id' => 'kelayakan', 'pos' => '(n)'],
                            'infrastructure project' => ['id' => 'proyek infrastruktur', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Dewan auditor memeriksa laporan keuangan tahunan.',
                            'en' => 'The audit board dismisses unfounded claims.'
                        ]
                    ],
                    [
                        'id' => 44,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Reaksi kimia ini melepaskan gas nitrogen sebagai produk sampingan.',
                        'target_word' => 'releases (ending in -se -> +s)',
                        'options' => [
                            'This chemical reaction releases nitrogen gas as an inert byproduct.',
                            'This chemical reaction releasees nitrogen gas as an inert byproduct.',
                            'This chemical reaction release nitrogen gas as an inert byproduct.',
                            'This chemical reaction is releases nitrogen gas as an inert byproduct.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "release" sudah berakhiran huruf vokal \'e\', sehingga cukup ditambahkan huruf \'s\' saja: "releases".',
                        'vocab' => [
                            'chemical reaction' => ['id' => 'reaksi kimia', 'pos' => '(n)'],
                            'release' => ['id' => 'melepaskan / mengeluarkan', 'pos' => '(v)'],
                            'inert byproduct' => ['id' => 'produk sampingan inert', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Proses pembakaran menghasilkan panas tinggi.',
                            'en' => 'The combustion process produces intense thermal energy.'
                        ]
                    ],
                    [
                        'id' => 45,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Polusi udara perkotaan mengurangi harapan hidup masyarakat secara nyata.',
                        'target_word' => 'diminishes (ending in -sh -> +es)',
                        'options' => [
                            'Urban atmospheric pollution diminishes citizen life expectancy markedly.',
                            'Urban atmospheric pollution diminishs citizen life expectancy markedly.',
                            'Urban atmospheric pollution diminish citizen life expectancy markedly.',
                            'Urban atmospheric pollution is diminishes citizen life expectancy markedly.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "diminish" berakhiran -sh. Untuk subjek tunggal "pollution", imbuhannya adalah -es: "diminishes".',
                        'vocab' => [
                            'atmospheric pollution' => ['id' => 'polusi udara / atmosfer', 'pos' => '(n)'],
                            'diminish' => ['id' => 'mengurangi / menyusutkan', 'pos' => '(v)'],
                            'life expectancy' => ['id' => 'harapan hidup', 'pos' => '(n)'],
                            'markedly' => ['id' => 'secara nyata / mencolok', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Penebangan hutan memusnahkan keanekaragaman hayati.',
                            'en' => 'Deforestation extinguishes unique habitat biodiversity.'
                        ]
                    ],
                    [
                        'id' => 46,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Sebuah lembaga riset independen memiliki wewenang untuk memeriksa data mentah.',
                        'target_word' => 'has (irregular form of have)',
                        'options' => [
                            'An independent research institute has the authority to audit primary raw data.',
                            'An independent research institute haves the authority to audit primary raw data.',
                            'An independent research institute have the authority to audit primary raw data.',
                            'An independent research institute is has the authority to audit primary raw data.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "have" memiliki bentuk orang ketiga tunggal khusus tak beraturan, yaitu "has", bukan "haves".',
                        'vocab' => [
                            'research institute' => ['id' => 'lembaga riset', 'pos' => '(n)'],
                            'has' => ['id' => 'memiliki', 'pos' => '(v)'],
                            'authority' => ['id' => 'wewenang', 'pos' => '(n)'],
                            'raw data' => ['id' => 'data mentah', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Universitas tersebut memiliki fasilitas komputasi mutakhir.',
                            'en' => 'The university has cutting-edge computational clusters.'
                        ]
                    ],
                    [
                        'id' => 47,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Sistem pemantauan ini mendeteksi dan memperbaiki anomali sinyal secara otomatis.',
                        'target_word' => 'fixes (ending in -x -> +es)',
                        'options' => [
                            'This automated monitoring framework fixes signal anomalies spontaneously.',
                            'This automated monitoring framework fixs signal anomalies spontaneously.',
                            'This automated monitoring framework fix signal anomalies spontaneously.',
                            'This automated monitoring framework is fixes signal anomalies spontaneously.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "fix" berakhiran konsonan -x. Untuk subjek tunggal "framework", tambahkan -es: "fixes".',
                        'vocab' => [
                            'monitoring framework' => ['id' => 'kerangka pemantauan', 'pos' => '(n)'],
                            'fix' => ['id' => 'memperbaiki', 'pos' => '(v)'],
                            'signal anomalies' => ['id' => 'anomali sinyal', 'pos' => '(n)'],
                            'spontaneously' => ['id' => 'secara spontan / otomatis', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Program komputer tersebut mencampurkan dua file suara.',
                            'en' => 'The software mixes two distinct acoustic channels.'
                        ]
                    ],
                    [
                        'id' => 48,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Studi komparatif tersebut mengidentifikasi tiga faktor penghambat inovasi.',
                        'target_word' => 'identifies (consonant + y -> -ies)',
                        'options' => [
                            'The comparative study identifies three major impediments to corporate innovation.',
                            'The comparative study identifys three major impediments to corporate innovation.',
                            'The comparative study identify three major impediments to corporate innovation.',
                            'The comparative study is identifies three major impediments to corporate innovation.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"identify" berakhiran konsonan \'f\' + \'y\'. Huruf \'y\' berubah menjadi \'ies\': "identifies".',
                        'vocab' => [
                            'comparative study' => ['id' => 'studi komparatif', 'pos' => '(n)'],
                            'identify' => ['id' => 'mengidentifikasi', 'pos' => '(v)'],
                            'impediments' => ['id' => 'faktor penghambat / kendala', 'pos' => '(n)'],
                            'corporate innovation' => ['id' => 'inovasi korporasi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Laporan tersebut memperjelas perbedaan mendasar.',
                            'en' => 'The report clarifies fundamental discrepancies.'
                        ]
                    ],
                    [
                        'id' => 49,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Kurikulum baru ini menekankan keterampilan berpikir kritis dan pemecahan masalah.',
                        'target_word' => 'emphasizes (ending in -ze -> +s)',
                        'options' => [
                            'This modern pedagogical curriculum emphasizes analytical critical thinking skills.',
                            'This modern pedagogical curriculum emphasizees analytical critical thinking skills.',
                            'This modern pedagogical curriculum emphasize analytical critical thinking skills.',
                            'This modern pedagogical curriculum is emphasizes analytical critical thinking skills.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Verba berakhiran -ze seperti "emphasize" hanya ditambah huruf \'s\': "emphasizes".',
                        'vocab' => [
                            'pedagogical curriculum' => ['id' => 'kurikulum pembelajaran / pedagogis', 'pos' => '(n)'],
                            'emphasize' => ['id' => 'menekankan', 'pos' => '(v)'],
                            'critical thinking skills' => ['id' => 'keterampilan berpikir kritis', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pelatihan kepemimpinan memprioritaskan komunikasi efektif.',
                            'en' => 'The leadership module prioritizes assertive communication.'
                        ]
                    ],
                    [
                        'id' => 50,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Penulis esai tersebut mencapai kesimpulan yang logis berdasarkan bukti-bukti yang ada.',
                        'target_word' => 'reaches (ending in -ch -> +es)',
                        'options' => [
                            'The essay writer reaches a balanced conclusion underpinned by empirical findings.',
                            'The essay writer reachs a balanced conclusion underpinned by empirical findings.',
                            'The essay writer reach a balanced conclusion underpinned by empirical findings.',
                            'The essay writer is reaches a balanced conclusion underpinned by empirical findings.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"reach" berakhiran bunyi desis -ch, sehingga ditambah -es: "reaches".',
                        'vocab' => [
                            'essay writer' => ['id' => 'penulis esai', 'pos' => '(n)'],
                            'reach' => ['id' => 'mencapai', 'pos' => '(v)'],
                            'balanced conclusion' => ['id' => 'kesimpulan yang berimbang', 'pos' => '(n)'],
                            'underpinned by' => ['id' => 'didukung oleh', 'pos' => '(participle phr)'],
                        ],
                        'example' => [
                            'id' => 'Investigasi tersebut menyentuh isu-isu etika penting.',
                            'en' => 'The inquiry touches upon fundamental ethical considerations.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 6: Adverbs of Frequency & Penanda Waktu Kalimat Verbal
            // ==========================================
            [
                'id' => 'verbal-adverbs-frequency',
                'name' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                'code' => '1.2.6',
                'concept_title' => 'Posisi dan Fungsi Adverb of Frequency dalam Kalimat Verbal',
                'concept_description' => 'Dalam kalimat verbal Simple Present, Adverbs of Frequency (always, usually, frequently, often, sometimes, rarely, seldom, never) diletakkan TEPAT SEBELUM kata kerja utama (Verb 1). Posisi ini berbeda dengan kalimat nominal di mana adverb berada setelah to be. Sementara itu, adverbial waktu spesifik (annually, daily, every semester) diletakkan di akhir atau awal kalimat.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">ADVERB OF FREQUENCY</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Letak: Tepat <strong>SEBELUM</strong> Kata Kerja Utama</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-2">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide">Rumus Posisi:</span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">Subject + [Adverb] + Verb 1(s/es) + Object</code>
        </div>
        <div class="text-xs text-white">
            <strong class="text-yellow-300">Daftar Adverb:</strong> <em>always</em> (100%), <em>usually</em> (90%), <em>often</em> (70%), <em>sometimes</em> (50%), <em>rarely</em> (10%), <em>never</em> (0%).
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">He <strong class="text-amber-300">always arrives</strong> on time for morning classes.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-emerald-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> <span class="text-white">always arrives</span> &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="text-white line-through">arrives always</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Adverb of frequency berada di antara Subjek dan Kata Kerja Utama (misal: "The committee frequently evaluates", BUKAN "The committee evaluates frequently").',
                    'Jika terdapat auxiliary verb (do/does), adverb diletakkan setelah auxiliary (misal: "They do not always agree").',
                    'Never dan rarely sudah bermakna negatif, jangan digabungkan dengan "not" (Double Negative).',
                    'Kata keterangan waktu berulang seperti "annually", "quarterly", "every month" umumnya menempati posisi akhir kalimat.'
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Dewan direksi secara rutin meninjau kembali sasaran keuangan jangka panjang.',
                        'target_word' => 'regularly reviews',
                        'options' => [
                            'The board of directors regularly reviews long-term capital allocation targets.',
                            'The board of directors reviews regularly long-term capital allocation targets.',
                            'The board of directors is regularly review long-term capital allocation targets.',
                            'The board of directors regularly review long-term capital allocation targets.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "board" adalah singular collective noun ("reviews"), dan adverb "regularly" ditempatkan tepat sebelum kata kerja utama: "regularly reviews".',
                        'vocab' => [
                            'board of directors' => ['id' => 'dewan direksi', 'pos' => '(n)'],
                            'regularly' => ['id' => 'secara rutin', 'pos' => '(adv)'],
                            'reviews' => ['id' => 'meninjau kembali', 'pos' => '(v)'],
                            'capital allocation' => ['id' => 'alokasi modal', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Dosen pembimbing selalu mengevaluasi draf artikel mahasiswa.',
                            'en' => 'The academic advisor always evaluates student article drafts.'
                        ]
                    ],
                    [
                        'id' => 52,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Para peneliti di laboratorium sering kali mengamati penyimpangan data selama uji coba.',
                        'target_word' => 'frequently observe',
                        'options' => [
                            'Laboratory researchers frequently observe statistical deviations during testing.',
                            'Laboratory researchers observe frequently statistical deviations during testing.',
                            'Laboratory researchers frequently observes statistical deviations during testing.',
                            'Laboratory researchers are frequently observe statistical deviations during testing.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "researchers" mengambil Verb 1 jamak "observe", didahului adverb "frequently": "frequently observe".',
                        'vocab' => [
                            'frequently' => ['id' => 'sering kali', 'pos' => '(adv)'],
                            'observe' => ['id' => 'mengamati', 'pos' => '(v)'],
                            'statistical deviations' => ['id' => 'penyimpangan statistik', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Analis pasar sering mendeteksi pergeseran pola konsumsi.',
                            'en' => 'Market analysts often detect consumer pattern shifts.'
                        ]
                    ],
                    [
                        'id' => 53,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Organisasi nirlaba tersebut jarang menerima pendanaan dari perusahaan komersial.',
                        'target_word' => 'seldom receives (Negative adverb + singular verb)',
                        'options' => [
                            'The non-profit foundation seldom receives financing from commercial entities.',
                            'The non-profit foundation receives seldom financing from commercial entities.',
                            'The non-profit foundation does not seldom receive financing from commercial entities.',
                            'The non-profit foundation seldom receive financing from commercial entities.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "foundation" (tunggal) mengambil "receives", didahului adverb negatif "seldom". Jangan menambahkan "does not" karena akan menjadi double negative.',
                        'vocab' => [
                            'foundation' => ['id' => 'yayasan / organisasi nirlaba', 'pos' => '(n)'],
                            'seldom' => ['id' => 'jarang', 'pos' => '(adv)'],
                            'receives' => ['id' => 'menerima', 'pos' => '(v)'],
                            'commercial entities' => ['id' => 'entitas / perusahaan komersial', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Spesies langka tersebut jarang menampakkan diri di siang hari.',
                            'en' => 'The endangered predator rarely surfaces during daylight.'
                        ]
                    ],
                    [
                        'id' => 54,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Sistem pemantauan cuaca otomatis memperbarui data satelit setiap lima belas menit.',
                        'target_word' => 'updates ... every fifteen minutes',
                        'options' => [
                            'The meteorological tracking system updates satellite telemetry every fifteen minutes.',
                            'The meteorological tracking system every fifteen minutes updates satellite telemetry.',
                            'The meteorological tracking system update satellite telemetry every fifteen minutes.',
                            'The meteorological tracking system is updates satellite telemetry every fifteen minutes.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "system" berpasangan dengan "updates", dan frasa waktu "every fifteen minutes" diletakkan di akhir klausa.',
                        'vocab' => [
                            'meteorological tracking system' => ['id' => 'sistem pelacakan cuaca', 'pos' => '(n)'],
                            'updates' => ['id' => 'memperbarui', 'pos' => '(v)'],
                            'satellite telemetry' => ['id' => 'telemetri satelit', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Bank sentral merilis suku bunga acuan setiap bulan.',
                            'en' => 'The central bank releases benchmark interest rates monthly.'
                        ]
                    ],
                    [
                        'id' => 55,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Ilmuwan berintegritas tinggi tidak pernah memalsukan hasil uji laboratorium demi reputasi.',
                        'target_word' => 'never falsifies (Singular Scientist + Never)',
                        'options' => [
                            'A principled scientist never falsifies empirical assay outcomes for prestige.',
                            'A principled scientist does not never falsify empirical assay outcomes for prestige.',
                            'A principled scientist never falsify empirical assay outcomes for prestige.',
                            'A principled scientist is never falsifies empirical assay outcomes for prestige.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata "never" diletakkan sebelum kata kerja "falsifies" (subjek tunggal "scientist"). Hindari "does not never" (double negative).',
                        'vocab' => [
                            'principled scientist' => ['id' => 'ilmuwan berintegritas', 'pos' => '(n)'],
                            'never' => ['id' => 'tidak pernah', 'pos' => '(adv)'],
                            'falsify' => ['id' => 'memalsukan', 'pos' => '(v)'],
                            'prestige' => ['id' => 'reputasi / gengsi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Peneliti terpercaya tidak pernah menyembunyikan efek samping obat.',
                            'en' => 'Ethical clinicians never conceal adverse pharmaceutical reactions.'
                        ]
                    ],
                    [
                        'id' => 56,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Pemerintah kota biasanya menerbitkan panduan keselamatan untuk seluruh warga.',
                        'target_word' => 'usually issues',
                        'options' => [
                            'The municipality usually issues preventative guidelines for all residents.',
                            'The municipality issues usually preventative guidelines for all residents.',
                            'The municipality usually issue preventative guidelines for all residents.',
                            'The municipality is usually issues preventative guidelines for all residents.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "municipality" (pemerintah kota) adalah singular noun, sehingga menggunakan "usually issues".',
                        'vocab' => [
                            'municipality' => ['id' => 'pemerintah kota', 'pos' => '(n)'],
                            'usually' => ['id' => 'biasanya', 'pos' => '(adv)'],
                            'issue' => ['id' => 'menerbitkan / mengeluarkan', 'pos' => '(v)'],
                            'residents' => ['id' => 'warga / penduduk', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kementerian biasanya menyelenggarakan lokakarya untuk para pengajar.',
                            'en' => 'The ministry usually hosts pedagogical seminars for instructors.'
                        ]
                    ],
                    [
                        'id' => 57,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Kedua lembaga penelitian tersebut terkadang berkolaborasi dalam proyek eksplorasi laut dalam.',
                        'target_word' => 'sometimes collaborate (Plural Institutions)',
                        'options' => [
                            'Both research institutions sometimes collaborate on abyssal oceanic survey missions.',
                            'Both research institutions sometimes collaborates on abyssal oceanic survey missions.',
                            'Both research institutions collaborate sometimes on abyssal oceanic survey missions.',
                            'Both research institutions are sometimes collaborate on abyssal oceanic survey missions.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "Both research institutions" membutuhkan kata kerja jamak "collaborate" didahului adverb "sometimes".',
                        'vocab' => [
                            'research institutions' => ['id' => 'lembaga-lembaga penelitian', 'pos' => '(n)'],
                            'sometimes' => ['id' => 'terkadang / sewaktu-waktu', 'pos' => '(adv)'],
                            'collaborate' => ['id' => 'berkolaborasi', 'pos' => '(v)'],
                            'abyssal survey' => ['id' => 'eksplorasi / survei laut dalam', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Universitas dan sektor swasta terkadang membiayai paten bersama.',
                            'en' => 'Academia and private enterprise sometimes co-fund technological patents.'
                        ]
                    ],
                    [
                        'id' => 58,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Mahasiswa pascasarjana umumnya menghadiri seminar akademik internasional setiap tahun.',
                        'target_word' => 'generally attend ... annually',
                        'options' => [
                            'Postgraduate students generally attend international symposiums annually.',
                            'Postgraduate students attend generally international symposiums annually.',
                            'Postgraduate students generally attends international symposiums annually.',
                            'Postgraduate students are generally attend international symposiums annually.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "students" berpasangan dengan "generally attend", dengan adverbial waktu "annually" di posisi akhir.',
                        'vocab' => [
                            'postgraduate students' => ['id' => 'mahasiswa pascasarjana', 'pos' => '(n)'],
                            'generally' => ['id' => 'umumnya', 'pos' => '(adv)'],
                            'attend' => ['id' => 'menghadiri', 'pos' => '(v)'],
                            'annually' => ['id' => 'setiap tahun / tahunan', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Para dosen umumnya mempublikasikan temuan mereka setiap semester.',
                            'en' => 'Professors generally disseminate their findings semiannually.'
                        ]
                    ],
                    [
                        'id' => 59,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Kebijakan fiskal yang terburu-buru jarang membuahkan hasil ekonomi yang berkelanjutan.',
                        'target_word' => 'rarely yields',
                        'options' => [
                            'Hasty fiscal intervention rarely yields sustainable macroeconomic stabilization.',
                            'Hasty fiscal intervention yields rarely sustainable macroeconomic stabilization.',
                            'Hasty fiscal intervention does not rarely yield sustainable macroeconomic stabilization.',
                            'Hasty fiscal intervention rarely yield sustainable macroeconomic stabilization.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "intervention" mengambil verba "yields", didahului adverb negatif "rarely".',
                        'vocab' => [
                            'fiscal intervention' => ['id' => 'intervensi fiskal', 'pos' => '(n)'],
                            'rarely' => ['id' => 'jarang', 'pos' => '(adv)'],
                            'yield' => ['id' => 'membuahkan / menghasilkan', 'pos' => '(v)'],
                            'macroeconomic stabilization' => ['id' => 'stabilisasi makroekonomi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Spekulasi pasar jangka pendek jarang menghasilkan pertumbuhan riil.',
                            'en' => 'Short-term speculative trading rarely fosters genuine prosperity.'
                        ]
                    ],
                    [
                        'id' => 60,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Komite audit selalu memverifikasi catatan keuangan dengan tingkat ketelitian tinggi.',
                        'target_word' => 'always verifies',
                        'options' => [
                            'The supervisory panel always verifies accounting ledgers with high precision.',
                            'The supervisory panel verifies always accounting ledgers with high precision.',
                            'The supervisory panel always verify accounting ledgers with high precision.',
                            'The supervisory panel is always verifies accounting ledgers with high precision.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"panel" (tunggal) mengambil "always verifies".',
                        'vocab' => [
                            'supervisory panel' => ['id' => 'komite / panel pengawas', 'pos' => '(n)'],
                            'always' => ['id' => 'selalu', 'pos' => '(adv)'],
                            'verify' => ['id' => 'memverifikasi', 'pos' => '(v)'],
                            'accounting ledgers' => ['id' => 'catatan / buku besar keuangan', 'pos' => '(n)'],
                            'high precision' => ['id' => 'tingkat ketelitian tinggi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pengawas kualitas selalu menguji ketahanan material.',
                            'en' => 'Quality inspectors always scrutinize structural durability.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 7: Stative Verbs dalam Simple Present Akademik
            // ==========================================
            [
                'id' => 'verbal-stative-verbs',
                'name' => 'Stative Verbs dalam Simple Present Akademik',
                'code' => '1.2.7',
                'concept_title' => 'Penggunaan Stative Verbs (Verba Keadaan & Kognisi) dalam Esai Formal',
                'concept_description' => 'Stative verbs adalah kata kerja yang menggambarkan keadaan (state of being), proses kognisi/pikiran, kepemilikan, atau relasi abstrak yang bersifat tetap. Contoh penting dalam academic writing: believe, consist of, contain, indicate, imply, possess, recognize, resemble. Stative verbs TIDAK PERNAH digunakan dalam bentuk Continuous (-ing) dan wajib menggunakan Simple Present.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-rose-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-rose-500/25 text-rose-300 border border-rose-500/50 font-mono">STATIVE VERBS</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Verba Keadaan, Pikiran &amp; Kepemilikan</span>
    </div>

    <div class="px-3 py-1.5 rounded-lg bg-rose-950/70 border border-rose-400 text-xs text-white flex items-center gap-2">
        <span class="font-black text-rose-300 uppercase tracking-wider">[LARANGAN FATAL]</span>
        <span>Stative verbs <strong>TIDAK BISA</strong> menggunakan bentuk Continuous (<em>-ing</em>). Wajib Simple Present!</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-2">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide">Rumus:</span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">Subject + Stative Verb 1(s/es) + Complement</code>
        </div>
        <div class="text-xs text-white">
            <strong class="text-yellow-300">Contoh Verba:</strong> <em>know, believe, understand, want, need, prefer, like, love, remember, contain, belong, own</em>.
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">I understand the explanation now.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-emerald-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> <span class="text-white">I understand</span> &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="text-white line-through">I am understanding</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Stative verbs dilarang digunakan dalam bentuk Present Continuous (Dilarang "The study is indicating" ➔ WAJIB "The study indicates").',
                    'Verba kepemilikan dan komposisi (contain, consist of, comprise, possess) selalu menggunakan Simple Present.',
                    'Verba persepsi dan kognisi (understand, believe, recognize, doubt) wajib berstatus Simple Present.',
                    'Perhatikan subjek tunggal tetap menambahkan -s/-es pada stative verbs (misal: "The report contains", BUKAN "The report contain").'
                ],
                'stative_categories' => [
                    [
                        'category' => 'Kognisi & Proses Pikiran (Mental States & Cognition)',
                        'badge' => 'Kognisi',
                        'verbs' => [
                            ['en' => 'know', 'id' => 'mengetahui'],
                            ['en' => 'understand', 'id' => 'memahami'],
                            ['en' => 'believe', 'id' => 'meyakini / percaya'],
                            ['en' => 'recognize', 'id' => 'mengakui / mengenali'],
                            ['en' => 'realize', 'id' => 'menyadari'],
                            ['en' => 'remember', 'id' => 'mengingat'],
                            ['en' => 'forget', 'id' => 'melupakan'],
                            ['en' => 'doubt', 'id' => 'meragukan'],
                            ['en' => 'imply', 'id' => 'menyiratkan'],
                            ['en' => 'infer', 'id' => 'menyimpulkan'],
                            ['en' => 'mean', 'id' => 'berarti / bermakna'],
                            ['en' => 'assume', 'id' => 'berasumsi'],
                        ]
                    ],
                    [
                        'category' => 'Kepemilikan & Komposisi (Possession & Composition)',
                        'badge' => 'Komposisi',
                        'verbs' => [
                            ['en' => 'contain', 'id' => 'berisi / memuat'],
                            ['en' => 'consist of', 'id' => 'terdiri dari'],
                            ['en' => 'comprise', 'id' => 'mencakup / meliputi'],
                            ['en' => 'possess', 'id' => 'memiliki (formal)'],
                            ['en' => 'belong to', 'id' => 'milik / kepunyaan'],
                            ['en' => 'own', 'id' => 'memiliki'],
                            ['en' => 'include', 'id' => 'mencakup / termasuk'],
                            ['en' => 'lack', 'id' => 'kekurangan / tidak punya'],
                        ]
                    ],
                    [
                        'category' => 'Emosi, Sikap & Kebutuhan (Emotions, Attitudes & Desires)',
                        'badge' => 'Sikap',
                        'verbs' => [
                            ['en' => 'prefer', 'id' => 'lebih memilih'],
                            ['en' => 'appreciate', 'id' => 'mengapresiasi / menghargai'],
                            ['en' => 'need', 'id' => 'membutuhkan'],
                            ['en' => 'want', 'id' => 'menginginkan'],
                            ['en' => 'desire', 'id' => 'menghendaki'],
                            ['en' => 'value', 'id' => 'menilai / menghargai'],
                            ['en' => 'dislike', 'id' => 'tidak menyukai'],
                        ]
                    ],
                    [
                        'category' => 'Indra, Keberadaan & Relasi (State, Senses & Relation)',
                        'badge' => 'Relasi',
                        'verbs' => [
                            ['en' => 'seem', 'id' => 'tampaknya'],
                            ['en' => 'appear', 'id' => 'terlihat / tampak'],
                            ['en' => 'resemble', 'id' => 'menyerupai / mirip'],
                            ['en' => 'exist', 'id' => 'eksis / ada'],
                            ['en' => 'depend on', 'id' => 'bergantung pada'],
                            ['en' => 'matter', 'id' => 'berpengaruh / penting'],
                            ['en' => 'fit / suit', 'id' => 'cocok / sesuai'],
                            ['en' => 'cost', 'id' => 'berharga / memakan biaya'],
                        ]
                    ]
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Senyawa organik kompleks ini mengandung konsentrasi antioksidan alami yang tinggi.',
                        'target_word' => 'contains (Stative verb of composition)',
                        'options' => [
                            'This complex organic compound contains a high concentration of natural antioxidants.',
                            'This complex organic compound is containing a high concentration of natural antioxidants.',
                            'This complex organic compound contain a high concentration of natural antioxidants.',
                            'This complex organic compound are contain a high concentration of natural antioxidants.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "contain" adalah stative verb yang tidak boleh digunakan dalam bentuk progressive "is containing". Subjek tunggal "compound" berpasangan dengan "contains".',
                        'vocab' => [
                            'organic compound' => ['id' => 'senyawa organik', 'pos' => '(n)'],
                            'contain' => ['id' => 'mengandung / memuat', 'pos' => '(v)'],
                            'concentration' => ['id' => 'konsentrasi / kadar', 'pos' => '(n)'],
                            'natural antioxidants' => ['id' => 'antioksidan alami', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Laporan ini memuat data statistik lengkap.',
                            'en' => 'This report contains exhaustive demographic parameters.'
                        ]
                    ],
                    [
                        'id' => 62,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Struktur organisasi dewan riset terdiri dari sepuluh komite penasihat ahli.',
                        'target_word' => 'consists of (Stative verb)',
                        'options' => [
                            'The governance framework of the council consists of ten specialized advisory panels.',
                            'The governance framework of the council is consisting of ten specialized advisory panels.',
                            'The governance framework of the council consist of ten specialized advisory panels.',
                            'The governance framework of the council are consisting of ten specialized advisory panels.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"consist of" adalah stative verb yang wajib berbentuk Simple Present ("consists of" untuk subjek tunggal "framework"), bukan "is consisting of".',
                        'vocab' => [
                            'governance framework' => ['id' => 'struktur / kerangka tata kelola', 'pos' => '(n)'],
                            'consist of' => ['id' => 'terdiri dari', 'pos' => '(v phr)'],
                            'advisory panels' => ['id' => 'komite / panel penasihat', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Panel penguji terdiri atas lima profesor senior.',
                            'en' => 'The examination panel consists of five senior professors.'
                        ]
                    ],
                    [
                        'id' => 63,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Banyak ilmuwan meyakini bahwa fusi nuklir menawarkan solusi energi terbersih di masa depan.',
                        'target_word' => 'believe (Stative verb of belief/cognition)',
                        'options' => [
                            'Many physicists believe that nuclear fusion offers the cleanest power alternative.',
                            'Many physicists are believing that nuclear fusion offers the cleanest power alternative.',
                            'Many physicists believes that nuclear fusion offers the cleanest power alternative.',
                            'Many physicists is believe that nuclear fusion offers the cleanest power alternative.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"believe" adalah stative verb (kata kerja keyakinan/kognisi) yang tidak lazim dalam bentuk continuous ("are believing"). Subjek jamak "physicists" menggunakan Verb 1 "believe".',
                        'vocab' => [
                            'physicists' => ['id' => 'ahli fisika / ilmuwan', 'pos' => '(n)'],
                            'believe' => ['id' => 'meyakini / percaya', 'pos' => '(v)'],
                            'nuclear fusion' => ['id' => 'fusi nuklir', 'pos' => '(n)'],
                            'power alternative' => ['id' => 'alternatif energi / daya', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Para sosiolog meyakini bahwa urbanisasi membentuk kembali norma sosial.',
                            'en' => 'Sociologists believe that urbanization reshapes societal norms.'
                        ]
                    ],
                    [
                        'id' => 64,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Hasil survei ini mengindikasikan penurunan drastis dalam kepuasan konsumen.',
                        'target_word' => 'indicates (Stative reporting verb)',
                        'options' => [
                            'The customer feedback analysis indicates a steep reduction in client satisfaction.',
                            'The customer feedback analysis is indicating a steep reduction in client satisfaction.',
                            'The customer feedback analysis indicate a steep reduction in client satisfaction.',
                            'The customer feedback analysis are indicate a steep reduction in client satisfaction.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dalam literatur akademis, kata kerja pelaporan hasil seperti "indicates", "suggests", "demonstrates" menggunakan Simple Present untuk menyatakan fakta temuan.',
                        'vocab' => [
                            'analysis' => ['id' => 'analisis', 'pos' => '(n)'],
                            'indicate' => ['id' => 'mengindikasikan', 'pos' => '(v)'],
                            'steep reduction' => ['id' => 'penurunan drastis', 'pos' => '(n)'],
                            'client satisfaction' => ['id' => 'kepuasan konsumen', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Data statistik mengindikasikan kenaikan tajam angka pengangguran.',
                            'en' => 'The demographic data indicate a sharp rise in unemployment.'
                        ]
                    ],
                    [
                        'id' => 65,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Institusi tersebut memiliki sumber daya komputasi yang memadai untuk simulasi cuaca.',
                        'target_word' => 'possesses (Stative verb of possession)',
                        'options' => [
                            'The research institution possesses adequate computational hardware for climate simulations.',
                            'The research institution is possessing adequate computational hardware for climate simulations.',
                            'The research institution possess adequate computational hardware for climate simulations.',
                            'The research institution are possess adequate computational hardware for climate simulations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"possess" adalah stative verb kepemilikan yang tidak memakai bentuk continuous "is possessing". Subjek tunggal "institution" mengambil akhiran -es: "possesses".',
                        'vocab' => [
                            'research institution' => ['id' => 'institusi penelitian', 'pos' => '(n)'],
                            'possess' => ['id' => 'memiliki / menguasai', 'pos' => '(v)'],
                            'adequate hardware' => ['id' => 'perangkat keras yang memadai', 'pos' => '(n)'],
                            'simulations' => ['id' => 'simulasi', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Rumah sakit tersebut memiliki peralatan diagnostik berteknologi tinggi.',
                            'en' => 'The hospital possesses high-resolution diagnostic scanners.'
                        ]
                    ],
                    [
                        'id' => 66,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Penulis esai tersebut memahami kompleksitas perdebatan etika di bidang kecerdasan buatan.',
                        'target_word' => 'understands (Stative verb of mental state)',
                        'options' => [
                            'The essayist understands the multifaceted ethical dilemmas surrounding machine autonomy.',
                            'The essayist is understanding the multifaceted ethical dilemmas surrounding machine autonomy.',
                            'The essayist understand the multifaceted ethical dilemmas surrounding machine autonomy.',
                            'The essayist are understand the multifaceted ethical dilemmas surrounding machine autonomy.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"understand" adalah kata kerja pemahaman mental (stative). Bentuk continuous "is understanding" salah secara tata bahasa baku.',
                        'vocab' => [
                            'essayist' => ['id' => 'penulis esai', 'pos' => '(n)'],
                            'understand' => ['id' => 'memahami', 'pos' => '(v)'],
                            'multifaceted dilemmas' => ['id' => 'dilema yang beraneka segi', 'pos' => '(n)'],
                            'machine autonomy' => ['id' => 'otonomi mesin', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Para mahasiswa memahami petunjuk keselamatan praktikum.',
                            'en' => 'Undergraduates understand procedural laboratory protocols.'
                        ]
                    ],
                    [
                        'id' => 67,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Algoritma baru ini sangat menyerupai model pembelajaran saraf biologis manusia.',
                        'target_word' => 'resembles (Stative verb of relation)',
                        'options' => [
                            'The synthesized architecture closely resembles human biological neural circuits.',
                            'The synthesized architecture is closely resembling human biological neural circuits.',
                            'The synthesized architecture closely resemble human biological neural circuits.',
                            'The synthesized architecture are resemble human biological neural circuits.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"resemble" (menyerupai) adalah stative verb yang tidak boleh digunakan dalam bentuk -ing. Subjek tunggal "architecture" berpasangan dengan "resembles".',
                        'vocab' => [
                            'architecture' => ['id' => 'arsitektur / struktur sistem', 'pos' => '(n)'],
                            'resemble' => ['id' => 'menyerupai', 'pos' => '(v)'],
                            'neural circuits' => ['id' => 'sirkuit saraf biologis', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pola kristal tersebut menyerupai struktur berlian alam.',
                            'en' => 'The synthetic lattice resembles natural diamond morphology.'
                        ]
                    ],
                    [
                        'id' => 68,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Para peneliti meragukan validitas instrumen pengukuran yang belum terkalibrasi.',
                        'target_word' => 'doubt (Stative verb of doubt)',
                        'options' => [
                            'Metrologists doubt the precision of uncalibrated laboratory telemetry devices.',
                            'Metrologists are doubting the precision of uncalibrated laboratory telemetry devices.',
                            'Metrologists doubts the precision of uncalibrated laboratory telemetry devices.',
                            'Metrologists is doubt the precision of uncalibrated laboratory telemetry devices.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"doubt" adalah kata kerja mental keraguan (stative verb). Subjek jamak "Metrologists" mengambil bentuk dasar "doubt", bukan continuous.',
                        'vocab' => [
                            'metrologists' => ['id' => 'ahli pengukuran / metrolog', 'pos' => '(n)'],
                            'doubt' => ['id' => 'meragukan', 'pos' => '(v)'],
                            'precision' => ['id' => 'presisi / ketelitian', 'pos' => '(n)'],
                            'uncalibrated' => ['id' => 'belum terkalibrasi', 'pos' => '(adj)'],
                        ],
                        'example' => [
                            'id' => 'Banyak analis meragukan ketepatan ramalan ekonomi tersebut.',
                            'en' => 'Many analysts doubt the accuracy of the fiscal forecast.'
                        ]
                    ],
                    [
                        'id' => 69,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Kesimpulan penelitian ini menyiratkan perlunya perubahan kebijakan publik yang mendasar.',
                        'target_word' => 'implies (Stative reporting verb)',
                        'options' => [
                            'The study conclusion implies an urgent necessity for structural policy reform.',
                            'The study conclusion is implying an urgent necessity for structural policy reform.',
                            'The study conclusion imply an urgent necessity for structural policy reform.',
                            'The study conclusion are imply an urgent necessity for structural policy reform.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"imply" (menyiratkan) adalah stative verb yang berakhiran konsonan \'l\' + \'y\'. Untuk subjek tunggal "conclusion", ejaannya menjadi "implies".',
                        'vocab' => [
                            'conclusion' => ['id' => 'kesimpulan', 'pos' => '(n)'],
                            'imply' => ['id' => 'menyiratkan', 'pos' => '(v)'],
                            'urgent necessity' => ['id' => 'kebutuhan mendesak', 'pos' => '(n)'],
                            'policy reform' => ['id' => 'reformasi kebijakan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pernyataan menteri menyiratkan kenaikan tarif pajak.',
                            'en' => 'The minister statement implies an imminent tariff revision.'
                        ]
                    ],
                    [
                        'id' => 70,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Komunitas ilmiah internasional mengakui kontribusi penting sang penemu.',
                        'target_word' => 'recognizes (Stative verb of perception)',
                        'options' => [
                            'The international scientific community recognizes the inventor seminal breakthrough.',
                            'The international scientific community is recognizing the inventor seminal breakthrough.',
                            'The international scientific community recognize the inventor seminal breakthrough.',
                            'The international scientific community are recognize the inventor seminal breakthrough.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "community" (tunggal) mengambil stative verb "recognizes". Hindari bentuk continuous "is recognizing".',
                        'vocab' => [
                            'scientific community' => ['id' => 'komunitas ilmiah', 'pos' => '(n)'],
                            'recognize' => ['id' => 'mengakui', 'pos' => '(v)'],
                            'seminal breakthrough' => ['id' => 'terobosan / kontribusi penting', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Organisasi kesehatan dunia mengakui kemajuan penanganan pandemi.',
                            'en' => 'The global body recognizes epidemiological advancements.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 8: Koreksi Kesalahan Umum: Eliminasi Double Predicate
            // ==========================================
            [
                'id' => 'verbal-error-correction',
                'name' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                'code' => '1.2.8',
                'concept_title' => 'Identifikasi dan Eliminasi Double Predicate & Subject-Verb Mismatches',
                'concept_description' => 'Salah satu kesalahan paling fatal dan sering muncul dalam penulisan esai formal adalah "Double Predicate", yaitu menyisipkan to be (is, am, are) sebelum kata kerja verbal (seperti "The author is explains", "We are agree", "This theory is proves"). Kesalahan kedua adalah kegagalan menyelaraskan akhiran -s pada subjek tunggal atau salah menambahkan -s pada subjek jamak.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-rose-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-rose-500/25 text-rose-300 border border-rose-500/50 font-mono">KOREKSI KESALAHAN FATAL</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Eliminasi <em>Double Predicate</em> &amp; S-V Mismatch</span>
    </div>

    <!-- Perbandingan BENAR vs SALAH -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        <!-- BENAR -->
        <div class="rounded-xl bg-emerald-950/60 p-3 border border-emerald-400 space-y-1.5">
            <div class="text-xs font-black text-emerald-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span> BENTUK BENAR
            </div>
            <code class="text-xs font-mono font-bold text-white block bg-slate-950 p-2 rounded border border-emerald-500/40">
                Subject + Verb 1(-s/-es)
            </code>
            <div class="text-xs text-white pt-1 font-mono space-y-0.5">
                <div>• <span class="text-emerald-300 font-bold">He explains</span> the concept.</div>
                <div>• <span class="text-emerald-300 font-bold">We agree</span> with the proposal.</div>
                <div>• <span class="text-emerald-300 font-bold">She likes</span> coffee.</div>
            </div>
        </div>

        <!-- SALAH -->
        <div class="rounded-xl bg-rose-950/60 p-3 border border-rose-400 space-y-1.5">
            <div class="text-xs font-black text-rose-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-400"></span> SALAH MUTLAK (Double Predicate)
            </div>
            <code class="text-xs font-mono font-bold text-white block bg-slate-950 p-2 rounded border border-rose-500/40">
                Subject + [is/am/are] + Verb 1
            </code>
            <div class="text-xs text-white pt-1 font-mono space-y-0.5">
                <div>• <span class="text-rose-300 line-through">He is explains</span> the concept.</div>
                <div>• <span class="text-rose-300 line-through">We are agree</span> with the proposal.</div>
                <div>• <span class="text-rose-300 line-through">She is likes</span> coffee.</div>
            </div>
        </div>
    </div>

    <div class="text-xs text-white pl-3 border-l-2 border-amber-400 bg-amber-950/50 p-2.5 rounded-r-lg">
        <strong class="text-amber-300 uppercase">[KUNCI INGAT]:</strong> Jangan pernah menggabungkan to-be (<em>is, am, are</em>) dengan kata kerja V1 aktif!
    </div>
</div>
HTML,
                'rules' => [
                    'Dilarang keras menggabungkan to be (is/are) dengan Verb 1 dasar (e.g., "is indicates" ➔ SALAH! Seharusnya "indicates").',
                    'Kata "agree", "disagree", "consist", "depend" adalah VERBA MURNI, bukan kata sifat. Tulis "I agree", bukan "I am agree".',
                    'Periksa kembali subjek uncountable (research, data, evidence) agar tidak tertukar antara jamak dan tunggal.',
                    'Setelah modal auxiliaries (can, will, should, must), kata kerja selalu kembali ke V1 dasar murni tanpa -s.'
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Banyak akademisi setuju bahwa intervensi dini mengurangi angka putus sekolah.',
                        'target_word' => 'agree (Verba murni, BUKAN "are agree")',
                        'options' => [
                            'Many scholars agree that early childhood intervention mitigates student dropout rates.',
                            'Many scholars are agree that early childhood intervention mitigates student dropout rates.',
                            'Many scholars agrees that early childhood intervention mitigates student dropout rates.',
                            'Many scholars is agree that early childhood intervention mitigates student dropout rates.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"agree" adalah kata kerja verbal murni (Action/Stative Verb), bukan kata sifat. Penutur Indonesia sering salah menulis "are agree". Bentuk yang benar untuk subjek jamak "scholars" adalah "agree".',
                        'vocab' => [
                            'scholars' => ['id' => 'akademisi / sarjana', 'pos' => '(n)'],
                            'agree' => ['id' => 'setuju (verba murni)', 'pos' => '(v)'],
                            'mitigate' => ['id' => 'mengurangi / meredakan', 'pos' => '(v)'],
                            'dropout rates' => ['id' => 'angka putus sekolah', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Para peneliti setuju dengan rekomendasi panel ahli.',
                            'en' => 'Researchers agree with expert panel guidelines.'
                        ]
                    ],
                    [
                        'id' => 72,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Regulasi ketenagakerjaan baru tersebut menjamin transparansi dalam proses rekrutmen.',
                        'target_word' => 'ensures (BUKAN "is ensures")',
                        'options' => [
                            'The newly implemented statutory regulation ensures transparency across recruitment procedures.',
                            'The newly implemented statutory regulation is ensures transparency across recruitment procedures.',
                            'The newly implemented statutory regulation are ensure transparency across recruitment procedures.',
                            'The newly implemented statutory regulation ensure transparency across recruitment procedures.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "regulation" adalah tunggal. Predikat kalimat adalah verba murni "ensures". Menyisipkan "is" ("is ensures") adalah kesalahan fatal double predicate.',
                        'vocab' => [
                            'statutory regulation' => ['id' => 'regulasi undang-undang', 'pos' => '(n)'],
                            'ensure' => ['id' => 'menjamin / memastikan', 'pos' => '(v)'],
                            'transparency' => ['id' => 'transparansi', 'pos' => '(n)'],
                            'recruitment procedures' => ['id' => 'prosedur rekrutmen', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Aturan internal menjamin kesetaraan hak pegawai.',
                            'en' => 'Internal governance ensures employee equity.'
                        ]
                    ],
                    [
                        'id' => 73,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Keberhasilan proyek eksperimental ini bergantung pada pasokan energi listrik yang stabil.',
                        'target_word' => 'depends on (BUKAN "is depends on")',
                        'options' => [
                            'The viability of the experimental prototype depends on stable electrical power supplies.',
                            'The viability of the experimental prototype is depends on stable electrical power supplies.',
                            'The viability of the experimental prototype depend on stable electrical power supplies.',
                            'The viability of the experimental prototype are depends on stable electrical power supplies.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"depend on" adalah kata kerja verbal. Subjek inti kalimat adalah "The viability" (singular), sehingga bentuk yang benar adalah "depends on", tanpa "is".',
                        'vocab' => [
                            'viability' => ['id' => 'keberhasilan / kelangsungan hidup', 'pos' => '(n)'],
                            'depend on' => ['id' => 'bergantung pada (verba)', 'pos' => '(v phr)'],
                            'power supplies' => ['id' => 'pasokan energi listrik', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kualitas panen bergantung pada curah hujan musiman.',
                            'en' => 'Crop yield depends on seasonal precipitation levels.'
                        ]
                    ],
                    [
                        'id' => 74,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Sebagian besar anggota komite menolak proposal pembangunan gedung reaktor nuklir.',
                        'target_word' => 'oppose (BUKAN "are oppose")',
                        'options' => [
                            'A decisive majority of committee members oppose the nuclear plant construction petition.',
                            'A decisive majority of committee members are oppose the nuclear plant construction petition.',
                            'A decisive majority of committee members opposes the nuclear plant construction petition.',
                            'A decisive majority of committee members is oppose the nuclear plant construction petition.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek mengacu pada anggota komite jamak ("committee members"), verba verbal murni adalah "oppose". Jangan tambahkan "are".',
                        'vocab' => [
                            'decisive majority' => ['id' => 'mayoritas penentu', 'pos' => '(n)'],
                            'oppose' => ['id' => 'menolak / menentang (verba)', 'pos' => '(v)'],
                            'construction petition' => ['id' => 'proposal / petisi pembangunan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Para aktivis menentang pembukaan tambang batu bara baru.',
                            'en' => 'Activists oppose opening additional coal concessions.'
                        ]
                    ],
                    [
                        'id' => 75,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Bukti biologis terbaru membuktikan keberadaan mikroorganisme di palung laut dalam.',
                        'target_word' => 'proves (Uncountable evidence, BUKAN "is proves")',
                        'options' => [
                            'Recent biological evidence proves the proliferation of microbial life in oceanic trenches.',
                            'Recent biological evidence is proves the proliferation of microbial life in oceanic trenches.',
                            'Recent biological evidence prove the proliferation of microbial life in oceanic trenches.',
                            'Recent biological evidence are proves the proliferation of microbial life in oceanic trenches.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"evidence" adalah uncountable noun (tunggal), maka kata kerjanya adalah "proves". Dilarang menyisipkan "is proves".',
                        'vocab' => [
                            'biological evidence' => ['id' => 'bukti biologis', 'pos' => '(n)'],
                            'prove' => ['id' => 'membuktikan', 'pos' => '(v)'],
                            'microbial life' => ['id' => 'kehidupan mikroorganisme / mikroba', 'pos' => '(n)'],
                            'oceanic trenches' => ['id' => 'palung laut', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Hasil rontgen membuktikan tidak ada retakan tulang.',
                            'en' => 'The radiographic scan proves there is no skeletal fracture.'
                        ]
                    ],
                    [
                        'id' => 76,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Data sensus kependudukan menggambarkan pergeseran demografis dari desa ke kota.',
                        'target_word' => 'illustrate (Plural Data, BUKAN "illustrates")',
                        'options' => [
                            'The population census data illustrate a steady demographic migration toward urban centers.',
                            'The population census data illustrates a steady demographic migration toward urban centers.',
                            'The population census data is illustrate a steady demographic migration toward urban centers.',
                            'The population census data are illustrates a steady demographic migration toward urban centers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dalam standar ilmiah formal, "data" adalah jamak (plural noun), sehingga menggunakan "illustrate" tanpa akhiran -s.',
                        'vocab' => [
                            'census data' => ['id' => 'data sensus', 'pos' => '(n)'],
                            'illustrate' => ['id' => 'menggambarkan / mengilustrasikan', 'pos' => '(v)'],
                            'demographic migration' => ['id' => 'migrasi demografis', 'pos' => '(n)'],
                            'urban centers' => ['id' => 'pusat-pusat perkotaan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Data statistik menggambarkan disparitas pendapatan.',
                            'en' => 'Statistical data illustrate income distribution disparities.'
                        ]
                    ],
                    [
                        'id' => 77,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Metode pembelajaran daring memfasilitasi pertukaran ide antar mahasiswa lintas benua.',
                        'target_word' => 'facilitates (Singular Method, BUKAN "is facilitates")',
                        'options' => [
                            'The online instructional method facilitates intellectual exchange among cross-continental students.',
                            'The online instructional method is facilitates intellectual exchange among cross-continental students.',
                            'The online instructional method facilitate intellectual exchange among cross-continental students.',
                            'The online instructional method are facilitate intellectual exchange among cross-continental students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "method" adalah tunggal. Kata kerja verbal murninya adalah "facilitates" tanpa imbuhan to be.',
                        'vocab' => [
                            'instructional method' => ['id' => 'metode pembelajaran', 'pos' => '(n)'],
                            'facilitate' => ['id' => 'memfasilitasi', 'pos' => '(v)'],
                            'intellectual exchange' => ['id' => 'pertukaran ide / intelektual', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Platform digital memfasilitasi pembayaran non-tunai yang aman.',
                            'en' => 'The digital gateway facilitates secure cashless transactions.'
                        ]
                    ],
                    [
                        'id' => 78,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Kedua peneliti tersebut tidak setuju mengenai interpretasi data spektrometri.',
                        'target_word' => 'disagree (BUKAN "are disagree")',
                        'options' => [
                            'Both principal researchers disagree on the theoretical interpretation of spectrometry outputs.',
                            'Both principal researchers are disagree on the theoretical interpretation of spectrometry outputs.',
                            'Both principal researchers disagrees on the theoretical interpretation of spectrometry outputs.',
                            'Both principal researchers is disagree on the theoretical interpretation of spectrometry outputs.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"disagree" adalah kata kerja verbal murni (bukan adjective). Subjek jamak "Both principal researchers" mengambil "disagree" tanpa "are".',
                        'vocab' => [
                            'principal researchers' => ['id' => 'peneliti utama (jamak)', 'pos' => '(n)'],
                            'disagree' => ['id' => 'tidak setuju / berselisih pendapat', 'pos' => '(v)'],
                            'spectrometry outputs' => ['id' => 'keluaran / data spektrometri', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Para dokter berselisih paham mengenai diagnosis penyakit tersebut.',
                            'en' => 'Physicians disagree regarding patient prognosis.'
                        ]
                    ],
                    [
                        'id' => 79,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Sistem operasi komputer ini mengalokasikan memori secara dinamis untuk setiap aplikasi.',
                        'target_word' => 'allocates (BUKAN "is allocates")',
                        'options' => [
                            'This computer operating system allocates memory dynamically across active background tasks.',
                            'This computer operating system is allocates memory dynamically across active background tasks.',
                            'This computer operating system allocate memory dynamically across active background tasks.',
                            'This computer operating system are allocate memory dynamically across active background tasks.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "system" adalah singular noun, sehingga menggunakan "allocates" tanpa menyisipkan "is".',
                        'vocab' => [
                            'operating system' => ['id' => 'sistem operasi', 'pos' => '(n)'],
                            'allocate' => ['id' => 'mengalokasikan', 'pos' => '(v)'],
                            'dynamically' => ['id' => 'secara dinamis', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Aplikasi mengalokasikan bandwidth berdasarkan prioritas.',
                            'en' => 'The client allocates bandwidth based on task urgency.'
                        ]
                    ],
                    [
                        'id' => 80,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Buku teks akademik ini menjelaskan konsep fisika kuantum dengan sangat gamblang.',
                        'target_word' => 'elucidates (BUKAN "is elucidates")',
                        'options' => [
                            'This comprehensive academic textbook elucidates quantum mechanical concepts with remarkable clarity.',
                            'This comprehensive academic textbook is elucidates quantum mechanical concepts with remarkable clarity.',
                            'This comprehensive academic textbook elucidate quantum mechanical concepts with remarkable clarity.',
                            'This comprehensive academic textbook are elucidate quantum mechanical concepts with remarkable clarity.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "textbook" adalah tunggal. Kata kerja verbal yang tepat adalah "elucidates" (tanpa "is").',
                        'vocab' => [
                            'academic textbook' => ['id' => 'buku teks akademik', 'pos' => '(n)'],
                            'elucidate' => ['id' => 'menjelaskan / menerangkan dengan gamblang', 'pos' => '(v)'],
                            'quantum mechanics' => ['id' => 'mekanika kuantum', 'pos' => '(n)'],
                            'remarkable clarity' => ['id' => 'kejelasan luar biasa', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Monograf tersebut menerangkan asal-usul peradaban kuno.',
                            'en' => 'The monograph elucidates the origins of early civilization.'
                        ]
                    ],
                ],
            ],
        ];
    }
}
