<?php

namespace App\Services;

class SelfStudyNounClauseData
{
    /**
     * Get the complete Noun Clause package (Module 3.3).
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
            'banner_title' => 'Noun Clause: Academic Reporting, Epistemic Stance & Syntactic Embedding',
            'banner_subtitle' => 'Kuasai konstruksi klausa kata benda (noun clauses) dalam penulisan ilmiah & esai IELTS Academic: Klausa \'that\' setelah kata kerja pelapor (reporting verbs), klausa kata tanya Wh- dengan susunan kata afirmatif (tanpa inversi auxiliary), klausa ketidakpastian \'whether / if\' (kaidah preposisi dan penempatan subjek), klausa nomina di posisi subjek kalimat (subject openers: What, How, Whether), serta konstruksi ekstraposisi subjek semu \'It\' dan Subjunctive mood formal.',
            'banner_badge' => 'MODULE 3.3 NOUN CLAUSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 3.3
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Komprehensif Klausa Kata Benda (Noun Clause)',
            'concept_summary' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda). Ketika berposisi sebagai subjek, Noun Clause selalu dihitung tunggal (singular agreement). Noun Clause dapat menduduki dua posisi gramatikal utama: (1) Posisi Subject (Smc / Ncl di awal kalimat sebelum Verb induk), dan (2) Posisi Object (setelah Verb induk atau setelah Preposisi). Terdapat 3 macam pembentukan Noun Clause: (1) Noun Clause from Statement dengan konjungsi "that" (artinya: bahwa); (2) Noun Clause from Yes/No Question dengan konjungsi "whether / if" (artinya: apakah), di mana posisi subjek wajib memakai "whether"; dan (3) Noun Clause from Wh- Question dengan kata tanya sebagai konjungsi dalam susunan afirmatif (tanpa inversi auxiliary). Untuk menjaga keseimbangan kalimat, Noun Clause subjek panjang dapat diekstraposisi menjadi "It is + Adj/Noun + that...".',
            'rules' => [
                [
                    'rule_title' => '1. Hakikat, Posisi & Dihitung Tunggal (Subject & Object)',
                    'rule_formula' => 'Noun Clause = Sub-clause sebagai Noun | Posisi = Subject & Object | Dihitung Tunggal (Singular Agreement)',
                    'rule_description' => 'Noun Clause menjalankan seluruh peran kata benda. Jika menempati posisi Subject (Smc / Ncl), seluruh klausa dianggap sebagai satu kesatuan gagasan tunggal, sehingga kata kerja utama (Vm) WAJIB berbentuk tunggal (is, was, has, verb-s).',
                    'examples' => [
                        [
                            'en' => 'That Earth is round is fact.',
                            'id' => 'Bahwa Bumi bulat adalah fakta.',
                            'note' => 'Klausa "That Earth is round" bertindak sebagai Subjek (Smc), diikuti predikat tunggal "is".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Noun Clause from Statement: Pola Conj (that = bahwa) + S + V',
                    'rule_formula' => '[Posisi Objek]: Sm + Vm + [that + Ss + Vs] | [Posisi Subjek]: [That + Ss + Vs] + Vm (tunggal) + Comp',
                    'rule_description' => 'Pada kalimat pernyataan (statement), kata hubung yang digunakan adalah "that" (artinya "bahwa"). Pada posisi objek, "that" melengkapi kata kerja pelapor (reporting verbs). Pada posisi subjek, "That + S + V" bertindak sebagai subjek kalimat tunggal.',
                    'examples' => [
                        [
                            'en' => 'Government believes that climate will change next month.',
                            'id' => 'Pemerintah percaya bahwa cuaca akan berubah bulan depan.',
                            'note' => 'Posisi Objek: Sm (Government) + Vm (believes) + C (that) + Ss (climate) + Vs (will change).'
                        ],
                        [
                            'en' => 'That Earth is round is fact.',
                            'id' => 'Bahwa Bumi bulat adalah fakta.',
                            'note' => 'Posisi Subjek: C (That) + Ss (Earth) + Vs (is) + Comp (round) + Vm (is) + Comp (fact).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Noun Clause from Yes/No Question: Pola Conj (whether / if = apakah) + S + V',
                    'rule_formula' => '[Posisi Subjek]: [Whether + Ss + Vs] + Vm (tunggal)... | [Posisi Objek]: Sm + Vm + [whether/if + Ss + Vs]',
                    'rule_description' => 'Dibentuk dari pertanyaan ya/tidak dengan konjungsi "whether" atau "if" (artinya "apakah"). KAIDAH MUTLAK: HANYA "whether" yang boleh menduduki posisi Subjek dan posisi setelah Preposisi (*on whether*); kata "if" DILARANG di posisi subjek dan setelah preposisi.',
                    'examples' => [
                        [
                            'en' => 'Whether Indonesia economy will get better will be discussed in meeting.',
                            'id' => 'Apakah ekonomi Indonesia akan membaik akan dibahas di rapat.',
                            'note' => 'Posisi Subjek: C (Whether) + Ss (Indonesia economy) + Vs (will get better) + Vmc (will be discussed).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Noun Clause from Wh- Question: Pola Conj (Wh-word) + S + V (Susunan Afirmatif)',
                    'rule_formula' => 'Sm + Vm + [what / how / why / where / when / who + Ss + Vs] (BUKAN *auxiliary + Ss + Vs*)',
                    'rule_description' => 'Kata tanya Wh- bertindak sebagai kata hubung (conjunction). Susunan kata di dalamnya WAJIB mengikuti pola afirmatif (Subjek + Verba), BUKAN susunan kalimat tanya langsung. Dilarang menyisipkan auxiliary did/does/do atau membalik subjek dan to-be.',
                    'examples' => [
                        [
                            'en' => 'The report explains how the algorithm processes financial transactions.',
                            'id' => 'Laporan tersebut menjelaskan bagaimana algoritma memproses transaksi keuangan.',
                            'note' => 'Susunan baku afirmatif: "how the algorithm processes" (BUKAN *how does the algorithm process*).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Ekstraposisi Subjek Semu "It" & Subjunctive Mood',
                    'rule_formula' => 'It is + Adjective/Noun + that + Ss + Vs | Subjunctive: It is + [essential/vital] + that + S + [bare infinitive / be + V3]',
                    'rule_description' => 'Untuk menghindari kalimat yang berat di depan (top-heavy), klausa "that" di posisi subjek diekstraposisi ke belakang menggunakan subjek semu "It". Contoh: "It is fact that Earth is round" menggantikan "That Earth is round is fact".',
                    'examples' => [
                        [
                            'en' => 'It is imperative that every protocol be executed with precision.',
                            'id' => 'Sangat penting bahwa setiap protokol dieksekusi dengan presisi.',
                            'note' => 'Bentuk pasif Subjunctive murni: "be executed" (BUKAN *is executed*).'
                        ]
                    ]
                ]
            ]
        ];
    }

        public static function getSubLessons(): array
    {
        return [
            [
                'id' => 'noun-clause-that-reporting-verbs',
                'name' => '3.3.1 Noun Clause from Statement (Pola Conj \'that\' = bahwa)',
                'code' => '3.3.1',
                'concept_title' => 'Noun Clause from Statement (Pola: Conj + S + V | Conj = that / bahwa)',
                'concept_description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda) dan selalu dihitung tunggal. Menempati 2 posisi utama: Subject & Object. Dalam kalimat pernyataan (Statement), kata hubung yang digunakan adalah \'that\' (artinya: \'bahwa\') dengan pola dasar: Conj + S + V. Noun clause ini dapat menempati: (1) Posisi Objek (Sm + Vm + [that + Ss + Vs], contoh: Government believes that climate will change next month), termasuk setelah kata kerja pelapor akademik (reporting verbs: demonstrate, suggest, believe, argue); dan (2) Posisi Subjek ([That + Ss + Vs] + Vm + Comp, contoh: That Earth is round is fact), di mana seluruh klausa bertindak sebagai subjek kalimat utama (Smc / Ncl) dan dihitung tunggal.',
                'description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda) dan selalu dihitung tunggal. Menempati 2 posisi utama: Subject & Object. Dalam kalimat pernyataan (Statement), kata hubung yang digunakan adalah \'that\' (artinya: \'bahwa\') dengan pola dasar: Conj + S + V. Noun clause ini dapat menempati: (1) Posisi Objek (Sm + Vm + [that + Ss + Vs], contoh: Government believes that climate will change next month), termasuk setelah kata kerja pelapor akademik (reporting verbs: demonstrate, suggest, believe, argue); dan (2) Posisi Subjek ([That + Ss + Vs] + Vm + Comp, contoh: That Earth is round is fact), di mana seluruh klausa bertindak sebagai subjek kalimat utama (Smc / Ncl) dan dihitung tunggal.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">POLA STATEMENT</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Conj (<strong>that</strong> = <em>bahwa</em>) + S + V</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> [1] Posisi Objek
            </span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">Sm + Vm + [that + Ss + Vs]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Government believes that climate will change next month.</span>
        </div>
        <div class="text-xs text-white italic pl-3 border-l-2 border-emerald-400">
            (Pemerintah percaya <em>bahwa</em> cuaca akan berubah bulan depan)
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-sky-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-sky-400"></span> [2] Posisi Subjek
            </span>
            <span class="text-[10px] font-extrabold bg-amber-500/25 text-amber-300 border border-amber-500/50 px-2 py-0.5 rounded-full font-mono uppercase">
                [SELALU DIHITUNG TUNGGAL]
            </span>
        </div>
        <div>
            <code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1 rounded border border-sky-500/40 inline-block">[That + Ss + Vs] + Vm (tunggal) + Comp</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">That Earth is round is fact.</span>
        </div>
        <div class="text-xs text-white italic pl-3 border-l-2 border-sky-400">
            (<em>Bahwa</em> Bumi bulat adalah fakta)
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Hakikat Noun Clause: Sub-clause yang fungsinya sebagai noun (kata benda), dan selalu dihitung tunggal jika berposisi sebagai subjek.',
                    'Pola Dasar Statement: Conj + S + V dengan kata hubung \'that\' (artinya: bahwa).',
                    'Posisi Objek (Sm + Vm + that + Ss + Vs): Noun clause melengkapi kata kerja induk (contoh: Government believes that climate will change next month). Dalam penulisan akademik, kata \'that\' dipertahankan eksplisit tanpa tanda koma sebelumnya.',
                    'Posisi Subjek ([That + Ss + Vs] + Vm + Comp): Noun clause bertindak sebagai subjek kalimat di awal (Smc / Ncl) dan SELALU dihitung tunggal (contoh: That Earth is round is fact).',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Hasil penelitian terbaru menunjukkan bahwa paparan mikroplastik mengganggu fungsi kekebalan tubuh pada hewan uji.',
                        'target_word' => 'Recent research demonstrates that microplastic exposure impairs immune system functioning in laboratory animals (demonstrates that + S + V)',
                        'vocab' => [
                            ['en' => 'recent research demonstrates that microplastic exposure impairs', 'id' => 'penelitian terbaru menunjukkan bahwa paparan mikroplastik mengganggu'],
                            ['en' => 'immune system functioning in laboratory animals', 'id' => 'fungsi sistem kekebalan pada hewan laboratorium'],
                        ],
                        'options' => [
                            'Recent research demonstrates that microplastic exposure impairs immune system functioning in laboratory animals.',
                            'Recent research demonstrates, that microplastic exposure impairs immune system functioning in laboratory animals.',
                            'Recent research demonstrates what microplastic exposure impairs immune system functioning in laboratory animals.',
                            'Recent research demonstrates which microplastic exposure impairs immune system functioning in laboratory animals.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa kata benda yang berfungsi sebagai objek langsung dari \'demonstrates\' menggunakan \'that\' tanpa tanda koma.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Data sensus mengindikasikan bahwa laju urbanisasi telah melambat di wilayah metropolitan selama tiga tahun berturut-turut.',
                        'target_word' => 'Census data indicate that the rate of urbanization has decelerated across metropolitan regions for three consecutive years (indicate that + S + has V3)',
                        'vocab' => [
                            ['en' => 'census data indicate that the rate of urbanization has decelerated', 'id' => 'data sensus mengindikasikan bahwa laju urbanisasi telah melambat'],
                            ['en' => 'across metropolitan regions for three consecutive years', 'id' => 'di seluruh kawasan metropolitan selama tiga tahun berturut-turut'],
                        ],
                        'options' => [
                            'Census data indicate that the rate of urbanization has decelerated across metropolitan regions for three consecutive years.',
                            'Census data indicate, that the rate of urbanization has decelerated across metropolitan regions for three consecutive years.',
                            'Census data indicate which the rate of urbanization has decelerated across metropolitan regions for three consecutive years.',
                            'Census data indicate what the rate of urbanization has decelerated across metropolitan regions for three consecutive years.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'indicate that\' memperkenalkan klausa fakta yang lengkap dengan subjek \'the rate of urbanization\' dan kata kerja \'has decelerated\'.',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Para ekonom berargumen bahwa kenaikan upah minimum tidak serta-merta memicu lonjakan tingkat pengangguran.',
                        'target_word' => 'Economists argue that an increase in the minimum wage does not necessarily precipitate a surge in unemployment rates (argue that + S + V)',
                        'vocab' => [
                            ['en' => 'economists argue that an increase in the minimum wage', 'id' => 'para ekonom berargumen bahwa peningkatan upah minimum'],
                            ['en' => 'does not necessarily precipitate a surge in unemployment rates', 'id' => 'tidak serta-merta memicu lonjakan tingkat pengangguran'],
                        ],
                        'options' => [
                            'Economists argue that an increase in the minimum wage does not necessarily precipitate a surge in unemployment rates.',
                            'Economists argue which an increase in the minimum wage does not necessarily precipitate a surge in unemployment rates.',
                            'Economists argue what an increase in the minimum wage does not necessarily precipitate a surge in unemployment rates.',
                            'Economists argue, that an increase in the minimum wage does not necessarily precipitate a surge in unemployment rates.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah kata kerja \'argue\', klausa argumen diperkenalkan oleh \'that\'.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Analisis regresi mengungkapkan bahwa terdapat korelasi positif yang signifikan antara jam tidur dan kinerja kognitif.',
                        'target_word' => 'The regression analysis reveals that a statistically significant positive correlation exists between sleep duration and cognitive performance (reveals that + S + V)',
                        'vocab' => [
                            ['en' => 'the regression analysis reveals that a statistically significant positive correlation exists', 'id' => 'analisis regresi mengungkapkan bahwa korelasi positif yang signifikan secara statistik ada'],
                            ['en' => 'between sleep duration and cognitive performance', 'id' => 'antara durasi tidur dan kinerja kognitif'],
                        ],
                        'options' => [
                            'The regression analysis reveals that a statistically significant positive correlation exists between sleep duration and cognitive performance.',
                            'The regression analysis reveals which a statistically significant positive correlation exists between sleep duration and cognitive performance.',
                            'The regression analysis reveals, that a statistically significant positive correlation exists between sleep duration and cognitive performance.',
                            'The regression analysis reveals what a statistically significant positive correlation exists between sleep duration and cognitive performance.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'reveals that\' diikuti oleh klausa utuh (S: \'correlation\' + V: \'exists\').',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Laporan pengawasan perbankan menegaskan bahwa cadangan modal institusi keuangan tetap memadai untuk menyerap guncangan likuiditas.',
                        'target_word' => 'The banking supervisory report confirms that institutional capital reserves remain adequate to absorb liquidity shocks (confirms that + S + V)',
                        'vocab' => [
                            ['en' => 'the banking supervisory report confirms that institutional capital reserves remain adequate', 'id' => 'laporan pengawasan perbankan menegaskan bahwa cadangan modal institusional tetap memadai'],
                            ['en' => 'to absorb liquidity shocks', 'id' => 'untuk menyerap guncangan likuiditas'],
                        ],
                        'options' => [
                            'The banking supervisory report confirms that institutional capital reserves remain adequate to absorb liquidity shocks.',
                            'The banking supervisory report confirms, that institutional capital reserves remain adequate to absorb liquidity shocks.',
                            'The banking supervisory report confirms which institutional capital reserves remain adequate to absorb liquidity shocks.',
                            'The banking supervisory report confirms what institutional capital reserves remain adequate to absorb liquidity shocks.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Objek kata benda dari verba pelapor \'confirms\' adalah klausa \'that institutional capital reserves remain adequate\'.',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Survei opini publik menunjukkan bahwa kepercayaan konsumen terhadap stabilitas perbankan mulai pulih.',
                        'target_word' => 'Public opinion surveys suggest that consumer confidence in banking stability is beginning to rebound (suggest that + S + V)',
                        'vocab' => [
                            ['en' => 'public opinion surveys suggest that consumer confidence in banking stability', 'id' => 'survei opini publik menunjukkan bahwa kepercayaan konsumen terhadap stabilitas perbankan'],
                            ['en' => 'is beginning to rebound', 'id' => 'mulai bangkit kembali'],
                        ],
                        'options' => [
                            'Public opinion surveys suggest that consumer confidence in banking stability is beginning to rebound.',
                            'Public opinion surveys suggest which consumer confidence in banking stability is beginning to rebound.',
                            'Public opinion surveys suggest, that consumer confidence in banking stability is beginning to rebound.',
                            'Public opinion surveys suggest what consumer confidence in banking stability is beginning to rebound.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'suggest that\' adalah frasa standar pelaporan data observasional dalam bahasa Inggris akademis.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Penulis menyimpulkan bahwa intervensi kebijakan moneter konvensional tidak lagi memadai dalam mengatasi krisis stagflasi.',
                        'target_word' => 'The author concludes that conventional monetary policy interventions are no longer sufficient to address stagflationary crises (concludes that + S + V)',
                        'vocab' => [
                            ['en' => 'the author concludes that conventional monetary policy interventions are no longer sufficient', 'id' => 'penulis menyimpulkan bahwa intervensi kebijakan moneter konvensional tidak lagi memadai'],
                            ['en' => 'to address stagflationary crises', 'id' => 'untuk mengatasi krisis stagflasi'],
                        ],
                        'options' => [
                            'The author concludes that conventional monetary policy interventions are no longer sufficient to address stagflationary crises.',
                            'The author concludes, that conventional monetary policy interventions are no longer sufficient to address stagflationary crises.',
                            'The author concludes which conventional monetary policy interventions are no longer sufficient to address stagflationary crises.',
                            'The author concludes what conventional monetary policy interventions are no longer sufficient to address stagflationary crises.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'concludes that\' mengantarkan kesimpulan ilmiah yang berbentuk klausa deklaratif lengkap.',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Bukti empiris membuktikan bahwa investasi pada pendidikan anak usia dini menghasilkan imbal hasil sosial tertinggi.',
                        'target_word' => 'Empirical evidence proves that investment in early childhood education yields the highest long-term societal returns (proves that + S + V)',
                        'vocab' => [
                            ['en' => 'empirical evidence proves that investment in early childhood education yields', 'id' => 'bukti empiris membuktikan bahwa investasi pada pendidikan anak usia dini menghasilkan'],
                            ['en' => 'the highest long-term societal returns', 'id' => 'imbal hasil sosial jangka panjang tertinggi'],
                        ],
                        'options' => [
                            'Empirical evidence proves that investment in early childhood education yields the highest long-term societal returns.',
                            'Empirical evidence proves which investment in early childhood education yields the highest long-term societal returns.',
                            'Empirical evidence proves what investment in early childhood education yields the highest long-term societal returns.',
                            'Empirical evidence proves, that investment in early childhood education yields the highest long-term societal returns.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa \'that investment in early childhood education yields...\' adalah klausa kata benda objek langsung dari \'proves\'.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Para peneliti mengamati bahwa sel punca berdiferensiasi menjadi jaringan fungsional dalam lingkungan kultur tiga dimensi.',
                        'target_word' => 'Researchers observed that stem cells differentiated into functional tissues within a three-dimensional culture environment (observed that + S + V)',
                        'vocab' => [
                            ['en' => 'researchers observed that stem cells differentiated into functional tissues', 'id' => 'para peneliti mengamati bahwa sel punca berdiferensiasi menjadi jaringan fungsional'],
                            ['en' => 'within a three-dimensional culture environment', 'id' => 'dalam lingkungan kultur tiga dimensi'],
                        ],
                        'options' => [
                            'Researchers observed that stem cells differentiated into functional tissues within a three-dimensional culture environment.',
                            'Researchers observed, that stem cells differentiated into functional tissues within a three-dimensional culture environment.',
                            'Researchers observed which stem cells differentiated into functional tissues within a three-dimensional culture environment.',
                            'Researchers observed what stem cells differentiated into functional tissues within a three-dimensional culture environment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'observed that\' memperkenalkan klausa pengamatan ilmiah tanpa tanda baca koma pemisah.',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Banyak ilmuwan berpendapat bahwa rekayasa genetika menawarkan solusi paling menjanjikan untuk ketahanan pangan global.',
                        'target_word' => 'Many scientists contend that genetic engineering offers the most promising solution to global food security challenges (contend that + S + V)',
                        'vocab' => [
                            ['en' => 'many scientists contend that genetic engineering offers', 'id' => 'banyak ilmuwan berpendapat bahwa rekayasa genetika menawarkan'],
                            ['en' => 'the most promising solution to global food security challenges', 'id' => 'solusi paling menjanjikan untuk tantangan ketahanan pangan global'],
                        ],
                        'options' => [
                            'Many scientists contend that genetic engineering offers the most promising solution to global food security challenges.',
                            'Many scientists contend which genetic engineering offers the most promising solution to global food security challenges.',
                            'Many scientists contend, that genetic engineering offers the most promising solution to global food security challenges.',
                            'Many scientists contend what genetic engineering offers the most promising solution to global food security challenges.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'contend that\' adalah ungkapan berbobot tinggi untuk menyatakan argumen ilmiah yang dipertahankan dalam debat akademik.',
                    ],
                ]
            ],
            [
                'id' => 'wh-question-word-noun-clauses',
                'name' => '3.3.2 Noun Clause from Wh- Question (Pola Conj Wh- + S + V)',
                'code' => '3.3.2',
                'concept_title' => 'Noun Clause from Wh- Question (Pola: Conj Wh- + S + V)',
                'concept_description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda) dan dihitung tunggal jika berposisi sebagai subjek. Macam ke-3 adalah Noun Clause yang berasal dari Wh- Question (pertanyaan kata tanya: what, how, why, where, when, who). Pola dasarnya adalah: Conj (Wh-) + S + V. Kaidah mutlak: susunan kata di dalam klausa WAJIB mengikuti pola kalimat berita afirmatif (Subjek + Kata Kerja), BUKAN susunan kalimat tanya (dilarang menggunakan inversi kata kerja bantu did/does/do atau membalik posisi to-be sebelum subjek).',
                'description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda) dan dihitung tunggal jika berposisi sebagai subjek. Macam ke-3 adalah Noun Clause yang berasal dari Wh- Question (pertanyaan kata tanya: what, how, why, where, when, who). Pola dasarnya adalah: Conj (Wh-) + S + V. Kaidah mutlak: susunan kata di dalam klausa WAJIB mengikuti pola kalimat berita afirmatif (Subjek + Kata Kerja), BUKAN susunan kalimat tanya (dilarang menggunakan inversi kata kerja bantu did/does/do atau membalik posisi to-be sebelum subjek).',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">POLA WH- QUESTION</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Conj (<em>what / how / why / where / when / who</em>) + S + V</span>
    </div>

    <div class="px-3 py-1.5 rounded-lg bg-rose-950/70 border border-rose-400 text-xs text-white flex items-center gap-2">
        <span class="font-black text-rose-300 uppercase tracking-wider">[KAIDAH MUTLAK]</span>
        <span>Susunan afirmatif biasa (<strong>S + V</strong>). Dilarang inversi auxiliary (<em>did / does / do</em>) atau to-be mendahului subjek.</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> [1] Posisi Objek
            </span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">Sm + Vm + [Wh-word + Ss + Vs]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">The committee examined how the policy affects low-income families.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-amber-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> <em>how the policy affects</em> &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="line-through">how does the policy affect</span>
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-sky-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-sky-400"></span> [2] Posisi Subjek
            </span>
            <span class="text-[10px] font-extrabold bg-amber-500/25 text-amber-300 border border-amber-500/50 px-2 py-0.5 rounded-full font-mono uppercase">
                [SELALU DIHITUNG TUNGGAL]
            </span>
        </div>
        <div>
            <code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1 rounded border border-sky-500/40 inline-block">[Wh-word + Ss + Vs] + Vm (tunggal) + Comp</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">What the researchers discovered is crucial for vaccine development.</span>
        </div>
        <div class="text-xs text-white italic pl-3 border-l-2 border-sky-400">
            (Apa yang ditemukan para peneliti sangat penting bagi pengembangan vaksin)
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Hakikat Noun Clause: Sub-clause yang fungsinya sebagai noun (kata benda) pada posisi Subject maupun Object.',
                    'Pola Wh- Question: Conj (what / how / why / where / when / who) + S + V (susunan afirmatif murni).',
                    'Dilarang Inversi Tanya: Jangan menyisipkan kata kerja bantu (auxiliary did, does, do) dan jangan membalik to-be ke depan subjek (contoh: *how it works*, BUKAN *how does it work*).',
                    'Posisi Subjek Dihitung Tunggal: Jika klausa Wh- berada di posisi subjek kalimat ([What/How + Ss + Vs]), seluruh klausa dihitung tunggal dan membutuhkan predikat utama (Vm) tunggal (is, was, has, V-s).',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Para insinyur sedang menyelidiki bagaimana kegagalan turbin primer dapat terjadi meskipun inspeksi keselamatan berkala telah dilakukan.',
                        'target_word' => 'Engineers are investigating how the primary turbine failure occurred despite regular safety inspections (how + Subject + Verb)',
                        'vocab' => [
                            ['en' => 'engineers are investigating how the primary turbine failure occurred', 'id' => 'para insinyur sedang menyelidiki bagaimana kegagalan turbin primer terjadi'],
                            ['en' => 'despite regular safety inspections', 'id' => 'terlepas dari inspeksi keselamatan berkala'],
                        ],
                        'options' => [
                            'Engineers are investigating how the primary turbine failure occurred despite regular safety inspections.',
                            'Engineers are investigating how did the primary turbine failure occur despite regular safety inspections.',
                            'Engineers are investigating how occurred the primary turbine failure despite regular safety inspections.',
                            'Engineers are investigating that how the primary turbine failure occurred despite regular safety inspections.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa nomina embedded harus berstruktur afirmatif: \'how\' + Subjek (\'the primary turbine failure\') + Verb (\'occurred\'). Menggunakan \'how did... occur\' adalah kesalahan inversi pertanyaan.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Laporan komite etika tidak merinci mengapa alokasi pendanaan penelitian dialihkan ke institusi swasta.',
                        'target_word' => 'The ethics committee report does not specify why research funding allocations were diverted to private institutions (why + Subject + Verb)',
                        'vocab' => [
                            ['en' => 'the ethics committee report does not specify why research funding allocations were diverted', 'id' => 'laporan komite etika tidak merinci mengapa alokasi pendanaan penelitian dialihkan'],
                            ['en' => 'to private institutions', 'id' => 'ke institusi swasta'],
                        ],
                        'options' => [
                            'The ethics committee report does not specify why research funding allocations were diverted to private institutions.',
                            'The ethics committee report does not specify why were research funding allocations diverted to private institutions.',
                            'The ethics committee report does not specify that why research funding allocations were diverted to private institutions.',
                            'The ethics committee report does not specify why did research funding allocations divert to private institutions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola baku: \'why\' + Subjek (\'research funding allocations\') + Kata Kerja Bantu Pasif (\'were diverted\'). Jangan membalik \'were\' sebelum subjek.',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Para sosiolog tertarik untuk memahami apa yang mendorong kaum muda bermigrasi dari kawasan pedesaan ke kota metropolitan.',
                        'target_word' => 'Sociologists are keen to understand what drives young adults to migrate from rural areas to metropolitan centers (what + Verb)',
                        'vocab' => [
                            ['en' => 'sociologists are keen to understand what drives young adults to migrate', 'id' => 'para sosiolog tertarik untuk memahami apa yang mendorong kaum muda bermigrasi'],
                            ['en' => 'from rural areas to metropolitan centers', 'id' => 'dari daerah pedesaan ke pusat metropolitan'],
                        ],
                        'options' => [
                            'Sociologists are keen to understand what drives young adults to migrate from rural areas to metropolitan centers.',
                            'Sociologists are keen to understand what does drive young adults to migrate from rural areas to metropolitan centers.',
                            'Sociologists are keen to understand that what drives young adults to migrate from rural areas to metropolitan centers.',
                            'Sociologists are keen to understand what are driving young adults to migrate from rural areas to metropolitan centers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'What\' berfungsi sebagai subjek langsung dari klausa nomina, diikuti verba \'drives\' (tanpa auxiliary \'does\').',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Studi ini menganalisis di mana investasi infrastruktur publik memberikan dampak ekonomi terbesar.',
                        'target_word' => 'This study analyzes where public infrastructure investments deliver the greatest economic impact (where + Subject + Verb)',
                        'vocab' => [
                            ['en' => 'this study analyzes where public infrastructure investments deliver', 'id' => 'studi ini menganalisis di mana investasi infrastruktur publik memberikan'],
                            ['en' => 'the greatest economic impact', 'id' => 'dampak ekonomi terbesar'],
                        ],
                        'options' => [
                            'This study analyzes where public infrastructure investments deliver the greatest economic impact.',
                            'This study analyzes where do public infrastructure investments deliver the greatest economic impact.',
                            'This study analyzes that where public infrastructure investments deliver the greatest economic impact.',
                            'This study analyzes where delivers public infrastructure investments the greatest economic impact.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah \'where\', urutan kata adalah Subjek (\'public infrastructure investments\') + Kata Kerja (\'deliver\').',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Kebijakan baru tersebut akan menentukan siapa yang berhak menerima subsidi energi terbarukan.',
                        'target_word' => 'The new policy will determine who is eligible to receive renewable energy subsidies (who + is eligible)',
                        'vocab' => [
                            ['en' => 'the new policy will determine who is eligible', 'id' => 'kebijakan baru akan menentukan siapa yang memenuhi syarat'],
                            ['en' => 'to receive renewable energy subsidies', 'id' => 'untuk menerima subsidi energi terbarukan'],
                        ],
                        'options' => [
                            'The new policy will determine who is eligible to receive renewable energy subsidies.',
                            'The new policy will determine whom is eligible to receive renewable energy subsidies.',
                            'The new policy will determine who eligible to receive renewable energy subsidies.',
                            'The new policy will determine that who is eligible to receive renewable energy subsidies.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Who\' adalah subjek bagi predikat \'is eligible\', membentuk klausa nomina objek dari kata kerja \'determine\'.',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Para ekonom masih memperdebatkan sejauh mana kecerdasan buatan akan mendisrupsi pasar tenaga kerja profesional.',
                        'target_word' => 'Economists are still debating to what extent artificial intelligence will disrupt the professional labor market (to what extent + S + will + V)',
                        'vocab' => [
                            ['en' => 'economists are still debating to what extent artificial intelligence will disrupt', 'id' => 'para ekonom masih memperdebatkan sejauh mana kecerdasan buatan akan mendisrupsi'],
                            ['en' => 'the professional labor market', 'id' => 'pasar tenaga kerja profesional'],
                        ],
                        'options' => [
                            'Economists are still debating to what extent artificial intelligence will disrupt the professional labor market.',
                            'Economists are still debating to what extent will artificial intelligence disrupt the professional labor market.',
                            'Economists are still debating that to what extent artificial intelligence will disrupt the professional labor market.',
                            'Economists are still debating to what extent does artificial intelligence disrupt the professional labor market.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa tanya \'to what extent\' diikuti susunan deklaratif: Subjek (\'artificial intelligence\') + Modal (\'will disrupt\'). Jangan membalik \'will\' ke depan subjek.',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Audit internal berhasil mengungkap bagaimana manipulasi laporan keuangan tersebut disamarkan selama bertahun-tahun.',
                        'target_word' => 'The internal audit revealed how the financial statement manipulation was concealed for years (how + S + was V3)',
                        'vocab' => [
                            ['en' => 'the internal audit revealed how the financial statement manipulation was concealed', 'id' => 'audit internal mengungkapkan bagaimana manipulasi laporan keuangan disembunyikan'],
                            ['en' => 'for years', 'id' => 'selama bertahun-tahun'],
                        ],
                        'options' => [
                            'The internal audit revealed how the financial statement manipulation was concealed for years.',
                            'The internal audit revealed how was the financial statement manipulation concealed for years.',
                            'The internal audit revealed that how the financial statement manipulation was concealed for years.',
                            'The internal audit revealed how did the financial statement manipulation conceal for years.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'how\' diikuti oleh Subjek (\'the financial statement manipulation\') dan to-be pasif (\'was concealed\').',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Para peneliti belum dapat memastikan kapan varian virus baru tersebut pertama kali bermutasi di populasi liar.',
                        'target_word' => 'Researchers have not yet ascertained when the novel viral variant first mutated in wild populations (when + S + mutated)',
                        'vocab' => [
                            ['en' => 'researchers have not yet ascertained when the novel viral variant first mutated', 'id' => 'para peneliti belum dapat memastikan kapan varian virus baru pertama kali bermutasi'],
                            ['en' => 'in wild populations', 'id' => 'di populasi liar'],
                        ],
                        'options' => [
                            'Researchers have not yet ascertained when the novel viral variant first mutated in wild populations.',
                            'Researchers have not yet ascertained when did the novel viral variant first mutate in wild populations.',
                            'Researchers have not yet ascertained that when the novel viral variant first mutated in wild populations.',
                            'Researchers have not yet ascertained when first mutated the novel viral variant in wild populations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'when\' mengawali klausa terikat dengan susunan Subjek + Verb lampau (\'first mutated\'), tanpa auxiliary \'did\'.',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Makalah ini mendiskusikan apa yang membedakan arsitektur komputasi kuantum dari mikroprosesor silikon konvensional.',
                        'target_word' => 'This paper discusses what distinguishes quantum computing architectures from conventional silicon microprocessors (what + Verb)',
                        'vocab' => [
                            ['en' => 'this paper discusses what distinguishes quantum computing architectures', 'id' => 'makalah ini mendiskusikan apa yang membedakan arsitektur komputasi kuantum'],
                            ['en' => 'from conventional silicon microprocessors', 'id' => 'dari mikroprosesor silikon konvensional'],
                        ],
                        'options' => [
                            'This paper discusses what distinguishes quantum computing architectures from conventional silicon microprocessors.',
                            'This paper discusses what does distinguish quantum computing architectures from conventional silicon microprocessors.',
                            'This paper discusses that what distinguishes quantum computing architectures from conventional silicon microprocessors.',
                            'This paper discusses what is distinguishing quantum computing architectures from conventional silicon microprocessors.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'what\' bertindak sebagai subjek klausa nomina, diikuti kata kerja tunggal \'distinguishes\'.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Komisi investigasi akan mempublikasikan mengapa peringatan dini kegagalan bendungan diabaikan oleh operator lapangan.',
                        'target_word' => 'The investigative commission will publish why dam failure early warnings were ignored by field operators (why + S + were ignored)',
                        'vocab' => [
                            ['en' => 'the investigative commission will publish why dam failure early warnings were ignored', 'id' => 'komisi investigasi akan mempublikasikan mengapa peringatan dini kegagalan bendungan diabaikan'],
                            ['en' => 'by field operators', 'id' => 'oleh operator lapangan'],
                        ],
                        'options' => [
                            'The investigative commission will publish why dam failure early warnings were ignored by field operators.',
                            'The investigative commission will publish why were dam failure early warnings ignored by field operators.',
                            'The investigative commission will publish that why dam failure early warnings were ignored by field operators.',
                            'The investigative commission will publish why did dam failure early warnings get ignored by field operators.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Urutan afirmatif: \'why\' + Subjek (\'dam failure early warnings\') + Predikat Pasif (\'were ignored\').',
                    ],
                ]
            ],
            [
                'id' => 'noun-clause-whether-if',
                'name' => '3.3.3 Noun Clause from Yes/No Question (Pola Conj \'whether / if\' = apakah)',
                'code' => '3.3.3',
                'concept_title' => 'Noun Clause from Yes/No Question (Pola: Conj + S + V | Conj = whether / if / apakah)',
                'concept_description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda). Macam ke-2 adalah Noun Clause yang berasal dari Yes/No Question dengan kata hubung \'whether\' atau \'if\' (artinya: \'apakah\') berpola dasar Conj + S + V. Kaidah mutlak penempatan: (1) Posisi Objek: Boleh memakai \'whether\' maupun \'if\' (Sm + Vm + [whether/if + Ss + Vs]); (2) Posisi Subjek: HANYA boleh memakai \'whether\', kata \'if\' DILARANG KIKUK/INVALID ([Whether + Ss + Vs] + Vm tunggal); (3) Setelah Preposisi: HANYA boleh memakai \'whether\' (contoh: focus on whether..., BUKAN focus on if); dan (4) Diikuti \'or not\' langsung: HANYA boleh \'whether or not\' (BUKAN if or not).',
                'description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda). Macam ke-2 adalah Noun Clause yang berasal dari Yes/No Question dengan kata hubung \'whether\' atau \'if\' (artinya: \'apakah\') berpola dasar Conj + S + V. Kaidah mutlak penempatan: (1) Posisi Objek: Boleh memakai \'whether\' maupun \'if\' (Sm + Vm + [whether/if + Ss + Vs]); (2) Posisi Subjek: HANYA boleh memakai \'whether\', kata \'if\' DILARANG KIKUK/INVALID ([Whether + Ss + Vs] + Vm tunggal); (3) Setelah Preposisi: HANYA boleh memakai \'whether\' (contoh: focus on whether..., BUKAN focus on if); dan (4) Diikuti \'or not\' langsung: HANYA boleh \'whether or not\' (BUKAN if or not).',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">POLA YES/NO QUESTION</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Conj (<strong>whether / if</strong> = <em>apakah</em>) + S + V</span>
    </div>

    <div class="px-3 py-1.5 rounded-lg bg-amber-950/70 border border-amber-400 text-xs text-white flex items-center gap-2">
        <span class="font-black text-amber-300 uppercase tracking-wider">[KAIDAH BAKU]</span>
        <span>HANYA <strong>'whether'</strong> untuk posisi Subjek &amp; setelah Preposisi. Kata <strong>'if'</strong> DILARANG.</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> [1] Posisi Objek
            </span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">Sm + Vm + [whether / if + Ss + Vs]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Economists debate whether inflation will stabilize this year.</span>
        </div>
        <div class="text-xs text-white italic pl-3 border-l-2 border-emerald-400">
            (Pakar ekonomi memperdebatkan <em>apakah</em> inflasi akan stabil tahun ini)
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-sky-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-sky-400"></span> [2] Posisi Subjek
            </span>
            <span class="text-[10px] font-extrabold bg-rose-500/25 text-rose-300 border border-rose-500/50 px-2 py-0.5 rounded-full font-mono uppercase">
                [HANYA 'WHETHER' - DILARANG 'IF']
            </span>
        </div>
        <div>
            <code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1 rounded border border-sky-500/40 inline-block">[Whether + Ss + Vs] + Vm (tunggal)...</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Whether Indonesia economy will get better will be discussed in meeting.</span>
        </div>
        <div class="text-xs text-white italic pl-3 border-l-2 border-sky-400">
            (<em>Apakah</em> ekonomi Indonesia akan membaik akan dibahas di rapat)
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 flex items-center justify-between gap-2 flex-wrap">
        <span class="text-xs font-black text-purple-300 uppercase">[3] Setelah Preposisi:</span>
        <code class="text-xs font-mono font-bold text-purple-200 bg-slate-950 px-2.5 py-1 rounded border border-purple-500/40">Preposisi + [whether + Ss + Vs]</code>
        <span class="text-xs text-white italic w-full">Contoh: The study focuses <strong>on whether</strong> the treatment reduces mortality.</span>
    </div>
</div>
HTML,
                'rules' => [
                    'Pola Yes/No Question: Conj + S + V dengan konjungsi \'whether\' atau \'if\' yang bermakna \'apakah\'.',
                    'Kaidah Posisi Subjek: HANYA \'whether\' yang sah menjadi subjek kalimat ([Whether + Ss + Vs] + Vm tunggal). Kata \'if\' TIDAK BISA digunakan sebagai subjek.',
                    'Kaidah Posisi Preposisi: Setelah kata depan/preposisi (on, about, over), WAJIB menggunakan \'whether\', bukan \'if\' (contoh: debate over whether, BUKAN debate over if).',
                    'Subjek Dihitung Tunggal: Noun clause \'Whether + Ss + Vs\' di posisi subjek selalu dihitung tunggal.',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Para peneliti sedang menyelidiki apakah terapi gen dapat memulihkan penglihatan pada pasien dengan degenerasi makula.',
                        'target_word' => 'Researchers are investigating whether gene therapy can restore vision in patients with macular degeneration (investigating whether + S + V)',
                        'vocab' => [
                            ['en' => 'researchers are investigating whether gene therapy can restore vision', 'id' => 'para peneliti sedang menyelidiki apakah terapi gen dapat memulihkan penglihatan'],
                            ['en' => 'in patients with macular degeneration', 'id' => 'pada pasien dengan degenerasi makula'],
                        ],
                        'options' => [
                            'Researchers are investigating whether gene therapy can restore vision in patients with macular degeneration.',
                            'Researchers are investigating that whether gene therapy can restore vision in patients with macular degeneration.',
                            'Researchers are investigating whether or not can gene therapy restore vision in patients with macular degeneration.',
                            'Researchers are investigating if or not gene therapy can restore vision in patients with macular degeneration.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'whether\' memperkenalkan klausa nomina ketidakpastian/pertanyaan alternatif dalam susunan afirmatif (\'gene therapy can restore\').',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Keberhasilan uji coba klinis bergantung pada apakah antibodi monoklonal dapat menembus sawar darah otak.',
                        'target_word' => 'The success of the clinical trial hinges on whether the monoclonal antibody can cross the blood-brain barrier (Preposition + whether)',
                        'vocab' => [
                            ['en' => 'the success of the clinical trial hinges on whether the monoclonal antibody can cross', 'id' => 'keberhasilan uji klinis bergantung pada apakah antibodi monoklonal dapat menembus'],
                            ['en' => 'the blood-brain barrier', 'id' => 'sawar darah otak'],
                        ],
                        'options' => [
                            'The success of the clinical trial hinges on whether the monoclonal antibody can cross the blood-brain barrier.',
                            'The success of the clinical trial hinges on if the monoclonal antibody can cross the blood-brain barrier.',
                            'The success of the clinical trial hinges on that whether the monoclonal antibody can cross the blood-brain barrier.',
                            'The success of the clinical trial hinges on whether can the monoclonal antibody cross the blood-brain barrier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah preposisi (\'on\'), HANYA \'whether\' yang boleh digunakan. Menggunakan \'if\' setelah preposisi (*on if*) adalah kesalahan gramatikal mutlak.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Dewan direksi belum memutuskan apakah akan menyetujui merger korporasi tersebut atau tidak.',
                        'target_word' => 'The board of directors has not yet determined whether or not to approve the corporate merger (whether or not + Infinitive)',
                        'vocab' => [
                            ['en' => 'the board of directors has not yet determined whether or not to approve', 'id' => 'dewan direksi belum menentukan apakah akan menyetujui atau tidak'],
                            ['en' => 'the corporate merger', 'id' => 'merger korporasi tersebut'],
                        ],
                        'options' => [
                            'The board of directors has not yet determined whether or not to approve the corporate merger.',
                            'The board of directors has not yet determined if or not to approve the corporate merger.',
                            'The board of directors has not yet determined whether or no to approve the corporate merger.',
                            'The board of directors has not yet determined that whether to approve the corporate merger.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa \'whether or not\' adalah bentuk baku (tidak boleh menggunakan *if or not*).',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Studi ini berfokus pada pertanyaan tentang apakah subsidi energi terbarukan efektif mengurangi emisi nasional.',
                        'target_word' => 'This study focuses on the question of whether renewable energy subsidies are effective in curbing national emissions (of whether + S + V)',
                        'vocab' => [
                            ['en' => 'this study focuses on the question of whether renewable energy subsidies are effective', 'id' => 'studi ini berfokus pada pertanyaan tentang apakah subsidi energi terbarukan efektif'],
                            ['en' => 'in curbing national emissions', 'id' => 'dalam menekan emisi nasional'],
                        ],
                        'options' => [
                            'This study focuses on the question of whether renewable energy subsidies are effective in curbing national emissions.',
                            'This study focuses on the question of if renewable energy subsidies are effective in curbing national emissions.',
                            'This study focuses on the question of that whether renewable energy subsidies are effective in curbing national emissions.',
                            'This study focuses on the question whether if renewable energy subsidies are effective in curbing national emissions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah preposisi \'of\', hanya \'whether\' yang sah secara gramatikal dalam bahasa Inggris formal.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Para ekonom meragukan apakah pemotongan tarif pajak penghasilan akan secara otomatis meningkatkan pendapatan negara.',
                        'target_word' => 'Economists question whether income tax rate reductions will automatically stimulate aggregate revenue generation (question whether + S + V)',
                        'vocab' => [
                            ['en' => 'economists question whether income tax rate reductions will automatically stimulate', 'id' => 'para ekonom meragukan apakah pengurangan tarif pajak penghasilan akan secara otomatis menstimulasi'],
                            ['en' => 'aggregate revenue generation', 'id' => 'penghasilan pendapatan agregat'],
                        ],
                        'options' => [
                            'Economists question whether income tax rate reductions will automatically stimulate aggregate revenue generation.',
                            'Economists question that whether income tax rate reductions will automatically stimulate aggregate revenue generation.',
                            'Economists question whether will income tax rate reductions automatically stimulate aggregate revenue generation.',
                            'Economists question if or not income tax rate reductions will automatically stimulate aggregate revenue generation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'question\' (dalam arti meragukan/mempertanyakan) secara alami mengambil klausa nomina \'whether\'.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Belum ada konsensus ilmiah mengenai apakah paparan medan elektromagnetik tingkat rendah menimbulkan risiko karsinogenik.',
                        'target_word' => 'There is no scientific consensus as to whether low-level electromagnetic field exposure poses carcinogenic risks (as to whether + S + V)',
                        'vocab' => [
                            ['en' => 'there is no scientific consensus as to whether low-level electromagnetic field exposure poses', 'id' => 'tidak ada konsensus ilmiah mengenai apakah paparan medan elektromagnetik tingkat rendah menimbulkan'],
                            ['en' => 'carcinogenic risks', 'id' => 'risiko karsinogenik'],
                        ],
                        'options' => [
                            'There is no scientific consensus as to whether low-level electromagnetic field exposure poses carcinogenic risks.',
                            'There is no scientific consensus as to if low-level electromagnetic field exposure poses carcinogenic risks.',
                            'There is no scientific consensus as to that whether low-level electromagnetic field exposure poses carcinogenic risks.',
                            'There is no scientific consensus as to whether does low-level electromagnetic field exposure pose carcinogenic risks.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah frasa preposisi \'as to\', wajib menggunakan \'whether\' (bukan *as to if*).',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Dokter harus menilai apakah pasien memenuhi syarat untuk menjalani prosedur transplantasi organ.',
                        'target_word' => 'Physicians must assess whether the patient satisfies eligibility criteria for the organ transplantation procedure (assess whether + S + V)',
                        'vocab' => [
                            ['en' => 'physicians must assess whether the patient satisfies eligibility criteria', 'id' => 'dokter harus menilai apakah pasien memenuhi kriteria kelayakan'],
                            ['en' => 'for the organ transplantation procedure', 'id' => 'untuk prosedur transplantasi organ'],
                        ],
                        'options' => [
                            'Physicians must assess whether the patient satisfies eligibility criteria for the organ transplantation procedure.',
                            'Physicians must assess whether does the patient satisfy eligibility criteria for the organ transplantation procedure.',
                            'Physicians must assess that whether the patient satisfies eligibility criteria for the organ transplantation procedure.',
                            'Physicians must assess if or not the patient satisfies eligibility criteria for the organ transplantation procedure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'assess whether\' memperkenalkan objek evaluatif tanpa inversi kata kerja bantu.',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Investor berhati-hati dalam mempertimbangkan apakah valuasi pasar saat ini mencerminkan fundamental keuangan yang wajar.',
                        'target_word' => 'Investors are cautious in considering whether current market valuations reflect sound financial fundamentals (considering whether + S + V)',
                        'vocab' => [
                            ['en' => 'investors are cautious in considering whether current market valuations reflect', 'id' => 'investor berhati-hati dalam mempertimbangkan apakah valuasi pasar saat ini mencerminkan'],
                            ['en' => 'sound financial fundamentals', 'id' => 'fundamental keuangan yang sehat'],
                        ],
                        'options' => [
                            'Investors are cautious in considering whether current market valuations reflect sound financial fundamentals.',
                            'Investors are cautious in considering that whether current market valuations reflect sound financial fundamentals.',
                            'Investors are cautious in considering whether do current market valuations reflect sound financial fundamentals.',
                            'Investors are cautious in considering if or not current market valuations reflect sound financial fundamentals.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'whether\' memimpin klausa nomina pertimbangan evaluatif berposisi objek.',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Eksperimen ini dirancang untuk menguji apakah materi komposit baru tersebut tahan terhadap korosi air laut.',
                        'target_word' => 'This experiment was designed to test whether the novel composite material is resistant to seawater corrosion (to test whether + S + V)',
                        'vocab' => [
                            ['en' => 'this experiment was designed to test whether the novel composite material is resistant', 'id' => 'eksperimen ini dirancang untuk menguji apakah materi komposit baru tahan'],
                            ['en' => 'to seawater corrosion', 'id' => 'terhadap korosi air laut'],
                        ],
                        'options' => [
                            'This experiment was designed to test whether the novel composite material is resistant to seawater corrosion.',
                            'This experiment was designed to test whether is the novel composite material resistant to seawater corrosion.',
                            'This experiment was designed to test that whether the novel composite material is resistant to seawater corrosion.',
                            'This experiment was designed to test if or not the novel composite material is resistant to seawater corrosion.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa \'whether the novel composite material is resistant...\' adalah klausa komplemen dari infinitif \'to test\'.',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Regulator telekomunikasi sedang memperdebatkan tentang apakah lisensi frekuensi 5G harus dilelang atau dialokasikan langsung.',
                        'target_word' => 'Telecommunications regulators are deliberating about whether 5G spectrum licenses should be auctioned or allocated directly (about whether + S + V)',
                        'vocab' => [
                            ['en' => 'telecommunications regulators are deliberating about whether 5G spectrum licenses should be auctioned', 'id' => 'regulator telekomunikasi sedang berunding tentang apakah lisensi spektrum 5G harus dilelang'],
                            ['en' => 'or allocated directly', 'id' => 'atau dialokasikan secara langsung'],
                        ],
                        'options' => [
                            'Telecommunications regulators are deliberating about whether 5G spectrum licenses should be auctioned or allocated directly.',
                            'Telecommunications regulators are deliberating about if 5G spectrum licenses should be auctioned or allocated directly.',
                            'Telecommunications regulators are deliberating about that whether 5G spectrum licenses should be auctioned or allocated directly.',
                            'Telecommunications regulators are deliberating about whether should 5G spectrum licenses be auctioned or allocated directly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah preposisi \'about\', hanya \'whether\' yang diterima secara gramatikal (bukan *about if*).',
                    ],
                ]
            ],
            [
                'id' => 'noun-clause-subject-position',
                'name' => '3.3.4 Noun Clause in Subject Position (Selalu Dihitung Tunggal)',
                'code' => '3.3.4',
                'concept_title' => 'Noun Clause in Subject Position (Selalu Dihitung Tunggal / Singular Agreement)',
                'concept_description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda). Ketika seluruh klausa nomina menempati posisi Subjek kalimat (Subject-position Noun Clause / Smc / Ncl), kaidah gramatikal mutlak menyatakan bahwa Noun Clause SELALU DIHITUNG TUNGGAL. Oleh karena itu, kata kerja utama kalimat (Vm) WAJIB menggunakan bentuk tunggal (is, was, has, determines, remains), terlepas dari apakah kata benda di dalam anak klausa berbentuk jamak.',
                'description' => 'Noun Clause adalah sub-clause yang fungsinya sebagai noun (kata benda). Ketika seluruh klausa nomina menempati posisi Subjek kalimat (Subject-position Noun Clause / Smc / Ncl), kaidah gramatikal mutlak menyatakan bahwa Noun Clause SELALU DIHITUNG TUNGGAL. Oleh karena itu, kata kerja utama kalimat (Vm) WAJIB menggunakan bentuk tunggal (is, was, has, determines, remains), terlepas dari apakah kata benda di dalam anak klausa berbentuk jamak.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center justify-between gap-2 pb-2 border-b border-amber-500/40 flex-wrap">
        <div class="flex items-center gap-2">
            <span class="px-2 py-0.5 rounded text-[11px] font-black bg-amber-500/25 text-amber-300 border border-amber-500/50 font-mono">SUBJECT POSITION</span>
            <span class="text-xs sm:text-sm font-extrabold text-white">Noun Clause sebagai Subjek Kalimat (Smc / Ncl)</span>
        </div>
        <span class="text-[11px] font-extrabold bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 px-2.5 py-0.5 rounded-full font-mono uppercase">
            [SELALU DIHITUNG TUNGGAL]
        </span>
    </div>

    <div class="rounded-xl bg-slate-950 p-3 border border-amber-400 text-left">
        <span class="text-xs font-bold text-amber-300 uppercase tracking-wider block mb-1">Pola Umum Subject Opener:</span>
        <code class="text-xs sm:text-sm font-mono font-black text-amber-200 block overflow-x-auto">[That / Whether / What / How + Ss + Vs] + Vm (is / was / has / V-s) + Comp/Obj</code>
    </div>

    <div class="grid grid-cols-1 gap-2 pt-1">
        <div class="rounded-lg bg-slate-900/90 p-2.5 border border-slate-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <span class="text-xs font-bold text-emerald-300 min-w-[130px]">• Statement (That):</span>
            <div class="text-xs font-mono text-white">
                <span class="text-emerald-300 font-bold">[That Earth is round]</span> <strong class="text-amber-300 underline">is</strong> fact.
            </div>
            <span class="text-xs text-white italic">(Bahwa Bumi bulat adalah fakta)</span>
        </div>

        <div class="rounded-lg bg-slate-900/90 p-2.5 border border-slate-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <span class="text-xs font-bold text-sky-300 min-w-[130px]">• Yes/No (Whether):</span>
            <div class="text-xs font-mono text-white">
                <span class="text-sky-300 font-bold">[Whether policy succeeds]</span> <strong class="text-amber-300 underline">remains</strong> uncertain.
            </div>
            <span class="text-xs text-rose-300 font-bold italic">(Hanya Whether, Dilarang If)</span>
        </div>

        <div class="rounded-lg bg-slate-900/90 p-2.5 border border-slate-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <span class="text-xs font-bold text-purple-300 min-w-[130px]">• Wh- (What/How):</span>
            <div class="text-xs font-mono text-white">
                <span class="text-purple-300 font-bold">[What researchers discovered]</span> <strong class="text-amber-300 underline">was</strong> crucial.
            </div>
            <span class="text-xs text-white italic">(Bukan *were*, tetap tunggal)</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Kaidah Dihitung Tunggal: Noun clause di posisi subjek selalu dianggap sebagai satu kesatuan gagasan tunggal, sehingga kata kerja induk (Vm) WAJIB tunggal (is, was, has, V-s).',
                    'Tidak Terpengaruh Objek Jamak di Dalam Klausa: Contoh: *What the researchers observed WERE...* (SALAH) -> *What the researchers observed WAS significant* (BENAR).',
                    'Hanya \'Whether\' untuk Yes/No di Subjek: Dilarang menggunakan \'If\' sebagai pembuka klausa subjek.',
                    'Tanpa Tanda Koma Pemisah: Tidak boleh menyisipkan tanda koma antara klausa subjek dan kata kerja utamanya (*That Earth is round, is fact* adalah salah).',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Apa yang paling mengejutkan tim peneliti adalah kecepatan pembelahan sel-sel tumor tersebut.',
                        'target_word' => 'What surprised the research team most was the velocity of the tumor cells\' proliferation (What... was)',
                        'vocab' => [
                            ['en' => 'what surprised the research team most', 'id' => 'apa yang paling mengejutkan tim peneliti'],
                            ['en' => 'was the velocity of the tumor cells\' proliferation', 'id' => 'adalah kecepatan proliferasi sel tumor'],
                        ],
                        'options' => [
                            'What surprised the research team most was the velocity of the tumor cells\' proliferation.',
                            'What surprised the research team most were the velocity of the tumor cells\' proliferation.',
                            'That surprised the research team most was the velocity of the tumor cells\' proliferation.',
                            'Which surprised the research team most was the velocity of the tumor cells\' proliferation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa nomina subjek diawali \'What\' (\'What surprised the research team most\') dan dianggap tunggal, sehingga mengambil kata kerja tunggal \'was\' (bukan \'were\').',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Bagaimana pemerintah mengalokasikan anggaran stimulus fiskal akan menentukan laju pemulihan ekonomi nasional.',
                        'target_word' => 'How the government allocates the fiscal stimulus budget will determine the trajectory of national economic recovery (How... will determine)',
                        'vocab' => [
                            ['en' => 'how the government allocates the fiscal stimulus budget', 'id' => 'bagaimana pemerintah mengalokasikan anggaran stimulus fiskal'],
                            ['en' => 'will determine the trajectory of national economic recovery', 'id' => 'akan menentukan lintasan pemulihan ekonomi nasional'],
                        ],
                        'options' => [
                            'How the government allocates the fiscal stimulus budget will determine the trajectory of national economic recovery.',
                            'How does the government allocate the fiscal stimulus budget will determine the trajectory of national economic recovery.',
                            'How the government allocates the fiscal stimulus budget, will determine the trajectory of national economic recovery.',
                            'That how the government allocates the fiscal stimulus budget will determine the trajectory of national economic recovery.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'How the government allocates the fiscal stimulus budget\' adalah klausa subjek afirmatif yang langsung diikuti kata kerja utama \'will determine\' tanpa tanda koma.',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Apakah kebijakan moneter baru ini akan berhasil menekan inflasi masih belum dapat dipastikan oleh para analis.',
                        'target_word' => 'Whether this new monetary policy will successfully curtail inflation remains uncertain among financial analysts (Whether... remains)',
                        'vocab' => [
                            ['en' => 'whether this new monetary policy will successfully curtail inflation', 'id' => 'apakah kebijakan moneter baru ini akan berhasil menekan inflasi'],
                            ['en' => 'remains uncertain among financial analysts', 'id' => 'tetap tidak pasti di kalangan analis keuangan'],
                        ],
                        'options' => [
                            'Whether this new monetary policy will successfully curtail inflation remains uncertain among financial analysts.',
                            'If this new monetary policy will successfully curtail inflation remains uncertain among financial analysts.',
                            'Whether this new monetary policy will successfully curtail inflation, remains uncertain among financial analysts.',
                            'Whether or not will this new monetary policy successfully curtail inflation remains uncertain among financial analysts.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'HANYA \'Whether\' yang sah mengawali klausa subjek kalimat. Menggunakan \'If\' di posisi subjek (*If this new monetary policy...*) adalah salah mutlak.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Bahwa pemanasan global disebabkan oleh aktivitas industri manusia kini telah didukung oleh konsensus ilmiah yang luas.',
                        'target_word' => 'That global warming is driven by human industrial activity is now substantiated by broad scientific consensus (That... is)',
                        'vocab' => [
                            ['en' => 'that global warming is driven by human industrial activity', 'id' => 'bahwa pemanasan global didorong oleh aktivitas industri manusia'],
                            ['en' => 'is now substantiated by broad scientific consensus', 'id' => 'kini dibuktikan oleh konsensus ilmiah yang luas'],
                        ],
                        'options' => [
                            'That global warming is driven by human industrial activity is now substantiated by broad scientific consensus.',
                            'What global warming is driven by human industrial activity is now substantiated by broad scientific consensus.',
                            'That global warming is driven by human industrial activity, is now substantiated by broad scientific consensus.',
                            'Fact that global warming is driven by human industrial activity is now substantiated by broad scientific consensus.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa berawalan \'That\' (\'That global warming is driven...\') dapat berfungsi sebagai subjek formal kalimat ilmiah (fakta bahwa...), diikuti predikat tunggal \'is\'.',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Mengapa spesies amfibi tersebut punah begitu cepat di habitat aslinya masih menjadi teka-teki bagi para ahli biologi.',
                        'target_word' => 'Why the amphibian species became extinct so rapidly in its native habitat remains an enigma to conservation biologists (Why... remains)',
                        'vocab' => [
                            ['en' => 'why the amphibian species became extinct so rapidly in its native habitat', 'id' => 'mengapa spesies amfibi tersebut punah begitu cepat di habitat aslinya'],
                            ['en' => 'remains an enigma to conservation biologists', 'id' => 'tetap menjadi teka-teki bagi biolog konservasi'],
                        ],
                        'options' => [
                            'Why the amphibian species became extinct so rapidly in its native habitat remains an enigma to conservation biologists.',
                            'Why did the amphibian species become extinct so rapidly in its native habitat remains an enigma to conservation biologists.',
                            'Why the amphibian species became extinct so rapidly in its native habitat, remains an enigma to conservation biologists.',
                            'That why the amphibian species became extinct so rapidly in its native habitat remains an enigma to conservation biologists.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa \'Why the amphibian species became extinct...\' bertindak sebagai subjek tunggal bagi verba \'remains\'.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Apa yang dibutuhkan sistem pendidikan saat ini adalah reformasi kurikulum yang berorientasi pada pemikiran kritis.',
                        'target_word' => 'What the contemporary educational system requires is critical thinking-oriented curriculum reform (What... is)',
                        'vocab' => [
                            ['en' => 'what the contemporary educational system requires', 'id' => 'apa yang dibutuhkan sistem pendidikan kontemporer'],
                            ['en' => 'is critical thinking-oriented curriculum reform', 'id' => 'adalah reformasi kurikulum yang berorientasi pada pemikiran kritis'],
                        ],
                        'options' => [
                            'What the contemporary educational system requires is critical thinking-oriented curriculum reform.',
                            'What does the contemporary educational system require is critical thinking-oriented curriculum reform.',
                            'What the contemporary educational system requires, is critical thinking-oriented curriculum reform.',
                            'That what the contemporary educational system requires is critical thinking-oriented curriculum reform.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Konstruksi \'What...\' (pseudo-cleft) bertindak sebagai subjek gramatikal tunggal, diikuti \'is\'.',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Di mana fasilitas penyimpanan limbah nuklir permanen akan dibangun menjadi isu geopolitik yang sangat sensitif.',
                        'target_word' => 'Where the permanent nuclear waste repository will be constructed constitutes a highly contentious geopolitical issue (Where... constitutes)',
                        'vocab' => [
                            ['en' => 'where the permanent nuclear waste repository will be constructed', 'id' => 'di mana repositori limbah nuklir permanen akan dibangun'],
                            ['en' => 'constitutes a highly contentious geopolitical issue', 'id' => 'merupakan isu geopolitik yang sangat kontroversial'],
                        ],
                        'options' => [
                            'Where the permanent nuclear waste repository will be constructed constitutes a highly contentious geopolitical issue.',
                            'Where will the permanent nuclear waste repository be constructed constitutes a highly contentious geopolitical issue.',
                            'Where the permanent nuclear waste repository will be constructed, constitutes a highly contentious geopolitical issue.',
                            'At where the permanent nuclear waste repository will be constructed constitutes a highly contentious geopolitical issue.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa lokasi \'Where...\' sebagai subjek mengambil kata kerja tunggal \'constitutes\' tanpa koma pemisah.',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Apakah negara-negara anggota akan mematuhi target emisi net-zero masih sangat diragukan oleh para pengamat lingkungan.',
                        'target_word' => 'Whether member states will comply with net-zero emissions targets is highly doubted by environmental observers (Whether... is)',
                        'vocab' => [
                            ['en' => 'whether member states will comply with net-zero emissions targets', 'id' => 'apakah negara-negara anggota akan mematuhi target emisi net-zero'],
                            ['en' => 'is highly doubted by environmental observers', 'id' => 'sangat diragukan oleh para pengamat lingkungan'],
                        ],
                        'options' => [
                            'Whether member states will comply with net-zero emissions targets is highly doubted by environmental observers.',
                            'If member states will comply with net-zero emissions targets is highly doubted by environmental observers.',
                            'Whether member states will comply with net-zero emissions targets, is highly doubted by environmental observers.',
                            'Whether will member states comply with net-zero emissions targets is highly doubted by environmental observers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whether\' wajib digunakan sebagai pembuka subjek kalimat (bukan \'If\'), dan mengambil verba tunggal \'is\'.',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Apa yang tampak sebagai anomali data acak pada awalnya ternyata merupakan sinyal gelombang gravitasi yang baru.',
                        'target_word' => 'What appeared to be a random data anomaly initially proved to be a novel gravitational wave signal (What... proved)',
                        'vocab' => [
                            ['en' => 'what appeared to be a random data anomaly initially', 'id' => 'apa yang tampak sebagai anomali data acak pada awalnya'],
                            ['en' => 'proved to be a novel gravitational wave signal', 'id' => 'terbukti sebagai sinyal gelombang gravitasi yang baru'],
                        ],
                        'options' => [
                            'What appeared to be a random data anomaly initially proved to be a novel gravitational wave signal.',
                            'Which appeared to be a random data anomaly initially proved to be a novel gravitational wave signal.',
                            'What appeared to be a random data anomaly initially, proved to be a novel gravitational wave signal.',
                            'That appeared to be a random data anomaly initially proved to be a novel gravitational wave signal.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'What\' berfungsi sebagai subjek klausa nomina (\'that which appeared...\'), yang seluruhnya menjadi subjek dari kata kerja \'proved\'.',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Bagaimana algoritma enkripsi ini memproses kunci privat menjamin kerahasiaan komunikasi data tingkat tinggi.',
                        'target_word' => 'How this encryption algorithm handles private cryptographic keys guarantees high-level data communication confidentiality (How... guarantees)',
                        'vocab' => [
                            ['en' => 'how this encryption algorithm handles private cryptographic keys', 'id' => 'bagaimana algoritma enkripsi ini menangani kunci kriptografi privat'],
                            ['en' => 'guarantees high-level data communication confidentiality', 'id' => 'menjamin kerahasiaan komunikasi data tingkat tinggi'],
                        ],
                        'options' => [
                            'How this encryption algorithm handles private cryptographic keys guarantees high-level data communication confidentiality.',
                            'How does this encryption algorithm handle private cryptographic keys guarantees high-level data communication confidentiality.',
                            'How this encryption algorithm handles private cryptographic keys, guarantees high-level data communication confidentiality.',
                            'That how this encryption algorithm handles private cryptographic keys guarantees high-level data communication confidentiality.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa \'How...\' sebagai subjek tunggal mengambil kata kerja berakhiran -s (\'guarantees\').',
                    ],
                ]
            ],
            [
                'id' => 'dummy-subject-it-noun-clause',
                'name' => '3.3.5 Dummy Subject \'It\' + Noun Clause (Ekstraposisi Subjek & Subjunctive Mood)',
                'code' => '3.3.5',
                'concept_title' => 'Dummy Subject \'It\' + Noun Clause (Ekstraposisi Subjek Semu & Subjunctive Mood)',
                'concept_description' => 'Menempatkan klausa kata benda (Noun Clause) yang panjang di awal kalimat sering membuat struktur kalimat menjadi berat di depan (top-heavy). Untuk mencapai keseimbangan retorika dalam tulisan formal dan akademis, bahasa Inggris memindahkan klausa subjek ke bagian belakang kalimat menggunakan subjek semu \'It\' (Dummy Subject Extraposition). Contohnya: kalimat \'[That Earth is round] is fact\' diubah secara elegan menjadi \'It is fact [that Earth is round]\'. Selain itu, jika konstruksi \'It is + Adjective\' menyatakan keharusan/urgensi (imperative, vital, essential, crucial), klausa \'that\' menggunakan Subjunctive Mood (kata kerja bentuk dasar/bare infinitive tanpa akhiran -s, atau \'be + V3\' untuk pasif).',
                'description' => 'Menempatkan klausa kata benda (Noun Clause) yang panjang di awal kalimat sering membuat struktur kalimat menjadi berat di depan (top-heavy). Untuk mencapai keseimbangan retorika dalam tulisan formal dan akademis, bahasa Inggris memindahkan klausa subjek ke bagian belakang kalimat menggunakan subjek semu \'It\' (Dummy Subject Extraposition). Contohnya: kalimat \'[That Earth is round] is fact\' diubah secara elegan menjadi \'It is fact [that Earth is round]\'. Selain itu, jika konstruksi \'It is + Adjective\' menyatakan keharusan/urgensi (imperative, vital, essential, crucial), klausa \'that\' menggunakan Subjunctive Mood (kata kerja bentuk dasar/bare infinitive tanpa akhiran -s, atau \'be + V3\' untuk pasif).',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-indigo-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-indigo-500/25 text-indigo-300 border border-indigo-500/50 font-mono">DUMMY SUBJECT 'IT'</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Ekstraposisi Penyeimbang Kalimat &amp; Subjunctive Mood</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> [1] Transformasi Ekstraposisi
            </span>
            <span class="text-xs text-white italic">(Solusi menghindari kalimat top-heavy)</span>
        </div>
        <div class="text-xs font-mono p-2 rounded bg-slate-950 border border-slate-700 space-y-1">
            <div class="text-white">Dari: <span class="text-rose-300">[That Earth is round]</span> is fact.</div>
            <div class="text-emerald-300 font-bold">Menjadi: <strong>It is fact</strong> <span class="underline text-emerald-300">[that Earth is round]</span>.</div>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh Akademik:</span> <span class="italic text-white">It is evident that global temperatures are rising rapidly.</span>
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-purple-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-400"></span> [2] Subjunctive Mood (Keharusan/Urgensi)
            </span>
            <span class="text-[10px] font-extrabold bg-purple-500/25 text-purple-300 border border-purple-500/50 px-2 py-0.5 rounded-full font-mono uppercase">
                [BARE VERB / BE + V3]
            </span>
        </div>
        <div>
            <code class="text-xs font-mono font-bold text-purple-300 bg-slate-950 px-2.5 py-1 rounded border border-purple-500/40 inline-block">It is + [vital / imperative / essential] + that + S + [Bare Verb / be + V3]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-purple-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">It is imperative that every protocol be executed with precision.</span>
        </div>
        <div class="text-xs text-white italic pl-3 border-l-2 border-purple-400">
            (Bentuk pasif Subjunctive murni: <em>be executed</em>, BUKAN <em>is executed</em>)
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Tujuan Ekstraposisi: Menghindari kalimat berat di depan (top-heavy) dengan meletakkan subjek semu \'It\' di posisi awal dan memindahkan Noun Clause ke belakang.',
                    'Pola Ekstraposisi: It is + [adjective / noun] + that + S + V (contoh: *It is widely recognized that renewable energy is vital*).',
                    'Aturan Subjunctive Mood: Setelah kata sifat urgensi (vital, essential, imperative, crucial, mandatory), gunakan kata kerja dasar murni (bare infinitive) tanpa -s atau modal should.',
                    'Bentuk Pasif Subjunctive: Gunakan \'be + V3\' murni (contoh: *It is essential that every sample be tested*, BUKAN *is tested*).',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Sangatlah penting bahwa integritas metodologi penelitian dipertahankan sepanjang seluruh fase pengumpulan data.',
                        'target_word' => 'It is imperative that the integrity of the research methodology be maintained throughout all data collection phases (It is imperative that + Subjunctive be + V3)',
                        'vocab' => [
                            ['en' => 'it is imperative that the integrity of the research methodology be maintained', 'id' => 'sangat penting bahwa integritas metodologi penelitian dipertahankan'],
                            ['en' => 'throughout all data collection phases', 'id' => 'sepanjang seluruh fase pengumpulan data'],
                        ],
                        'options' => [
                            'It is imperative that the integrity of the research methodology be maintained throughout all data collection phases.',
                            'It is imperative that the integrity of the research methodology is maintained throughout all data collection phases.',
                            'It is imperative that the integrity of the research methodology to be maintained throughout all data collection phases.',
                            'It is imperative the integrity of the research methodology being maintained throughout all data collection phases.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah \'It is imperative that...\', kata kerja pasif wajib menggunakan bentuk dasar Subjunctive \'be maintained\', bukan \'is maintained\'.',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Sangatlah jelas bahwa diversifikasi portofolio investasi mengurangi risiko kerugian modal yang katastrofik.',
                        'target_word' => 'It is evident that portfolio diversification reduces the risk of catastrophic capital losses (It is evident that + S + V)',
                        'vocab' => [
                            ['en' => 'it is evident that portfolio diversification reduces the risk', 'id' => 'sangat jelas bahwa diversifikasi portofolio mengurangi risiko'],
                            ['en' => 'of catastrophic capital losses', 'id' => 'dari kerugian modal katastrofik'],
                        ],
                        'options' => [
                            'It is evident that portfolio diversification reduces the risk of catastrophic capital losses.',
                            'It is evident which portfolio diversification reduces the risk of catastrophic capital losses.',
                            'It is evident, that portfolio diversification reduces the risk of catastrophic capital losses.',
                            'That portfolio diversification reduces the risk is evident that catastrophic capital losses.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'It is evident that\' adalah pola ekstraposisi baku untuk menyatakan kepastian fakta secara objektif.',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Sangat krusial bahwa setiap peneliti mematuhi protokol keselamatan hayati yang telah ditetapkan tanpa pengecualian.',
                        'target_word' => 'It is crucial that every researcher adhere strictly to established biosafety protocols without exception (It is crucial that + Subjunctive bare verb)',
                        'vocab' => [
                            ['en' => 'it is crucial that every researcher adhere strictly', 'id' => 'sangat krusial bahwa setiap peneliti mematuhi secara ketat'],
                            ['en' => 'to established biosafety protocols without exception', 'id' => 'pada protokol biosafety yang telah ditetapkan tanpa pengecualian'],
                        ],
                        'options' => [
                            'It is crucial that every researcher adhere strictly to established biosafety protocols without exception.',
                            'It is crucial that every researcher adheres strictly to established biosafety protocols without exception.',
                            'It is crucial that every researcher to adhere strictly to established biosafety protocols without exception.',
                            'It is crucial that every researcher adhered strictly to established biosafety protocols without exception.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola Subjunctive setelah \'It is crucial that\' menuntut kata kerja dasar (bare infinitive \'adhere\'), meskipun subjeknya \'every researcher\' (tunggal, tanpa akhiran -s).',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Diakui secara luas bahwa literasi digital memainkan peran penting dalam inklusi ekonomi modern.',
                        'target_word' => 'It is widely acknowledged that digital literacy plays a pivotal role in contemporary economic inclusion (It is widely acknowledged that)',
                        'vocab' => [
                            ['en' => 'it is widely acknowledged that digital literacy plays a pivotal role', 'id' => 'diakui secara luas bahwa literasi digital memainkan peran penting'],
                            ['en' => 'in contemporary economic inclusion', 'id' => 'dalam inklusi ekonomi kontemporer'],
                        ],
                        'options' => [
                            'It is widely acknowledged that digital literacy plays a pivotal role in contemporary economic inclusion.',
                            'It is widely acknowledged which digital literacy plays a pivotal role in contemporary economic inclusion.',
                            'It is widely acknowledged, that digital literacy plays a pivotal role in contemporary economic inclusion.',
                            'It is widely acknowledged what digital literacy plays a pivotal role in contemporary economic inclusion.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'It is widely acknowledged that\' adalah frasa impersonal akademis berfrekuensi tinggi dalam esai IELTS Band 8+.',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Sangat penting bahwa auditor independen memeriksa seluruh transaksi rekening luar negeri sebelum penutupan tahun fiskal.',
                        'target_word' => 'It is essential that an independent auditor examine all offshore account transactions prior to fiscal year closure (It is essential that + Subjunctive examine)',
                        'vocab' => [
                            ['en' => 'it is essential that an independent auditor examine all offshore account transactions', 'id' => 'sangat penting bahwa auditor independen memeriksa seluruh transaksi rekening luar negeri'],
                            ['en' => 'prior to fiscal year closure', 'id' => 'sebelum penutupan tahun fiskal'],
                        ],
                        'options' => [
                            'It is essential that an independent auditor examine all offshore account transactions prior to fiscal year closure.',
                            'It is essential that an independent auditor examines all offshore account transactions prior to fiscal year closure.',
                            'It is essential that an independent auditor to examine all offshore account transactions prior to fiscal year closure.',
                            'It is essential that an independent auditor examined all offshore account transactions prior to fiscal year closure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjunctive mood: gunakan kata kerja bentuk dasar \'examine\' (bukan \'examines\') setelah \'It is essential that\'.',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Tampak jelas bahwa kebijakan pembatasan impor telah memicu inflasi harga barang konsumsi di pasar domestik.',
                        'target_word' => 'It is apparent that import restriction policies have stimulated consumer goods price inflation in the domestic market (It is apparent that)',
                        'vocab' => [
                            ['en' => 'it is apparent that import restriction policies have stimulated', 'id' => 'tampak jelas bahwa kebijakan pembatasan impor telah menstimulasi'],
                            ['en' => 'consumer goods price inflation in the domestic market', 'id' => 'inflasi harga barang konsumsi di pasar domestik'],
                        ],
                        'options' => [
                            'It is apparent that import restriction policies have stimulated consumer goods price inflation in the domestic market.',
                            'It is apparent which import restriction policies have stimulated consumer goods price inflation in the domestic market.',
                            'It is apparent, that import restriction policies have stimulated consumer goods price inflation in the domestic market.',
                            'It is apparent what import restriction policies have stimulated consumer goods price inflation in the domestic market.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'It is apparent that\' memperkenalkan kesimpulan inferensial yang didukung bukti empiris.',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Merupakan persyaratan mutlak bahwa setiap peserta menandatangani formulir persetujuan medis sebelum berpartisipasi dalam uji klinis.',
                        'target_word' => 'It is mandatory that each participant sign an informed consent document prior to enrolling in the clinical trial (It is mandatory that + Subjunctive sign)',
                        'vocab' => [
                            ['en' => 'it is mandatory that each participant sign an informed consent document', 'id' => 'merupakan hal wajib bahwa setiap partisipan menandatangani dokumen persetujuan tindakan'],
                            ['en' => 'prior to enrolling in the clinical trial', 'id' => 'sebelum mendaftar dalam uji klinis'],
                        ],
                        'options' => [
                            'It is mandatory that each participant sign an informed consent document prior to enrolling in the clinical trial.',
                            'It is mandatory that each participant signs an informed consent document prior to enrolling in the clinical trial.',
                            'It is mandatory that each participant to sign an informed consent document prior to enrolling in the clinical trial.',
                            'It is mandatory each participant signing an informed consent document prior to enrolling in the clinical trial.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'It is mandatory that\' mewajibkan kata kerja subjunctive dasar \'sign\' (bukan \'signs\').',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Sangat mungkin bahwa integrasi teknologi otomasi akan mentransformasi struktur ketenagakerjaan dalam dekade mendatang.',
                        'target_word' => 'It is highly probable that automation technology integration will transform employment structures over the coming decade (It is highly probable that)',
                        'vocab' => [
                            ['en' => 'it is highly probable that automation technology integration will transform', 'id' => 'sangat mungkin bahwa integrasi teknologi otomasi akan mentransformasi'],
                            ['en' => 'employment structures over the coming decade', 'id' => 'struktur ketenagakerjaan selama dekade mendatang'],
                        ],
                        'options' => [
                            'It is highly probable that automation technology integration will transform employment structures over the coming decade.',
                            'It is highly probable which automation technology integration will transform employment structures over the coming decade.',
                            'It is highly probable, that automation technology integration will transform employment structures over the coming decade.',
                            'It is highly probable what automation technology integration will transform employment structures over the coming decade.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'It is highly probable that\' adalah formula baku probabilitas akademis tinggi.',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Sangat direkomendasikan agar spesimen jaringan dibekukan segera setelah prosedur biopsi bedah selesai.',
                        'target_word' => 'It is recommended that the tissue specimen be cryopreserved immediately upon completion of the surgical biopsy (It is recommended that + Subjunctive be + V3)',
                        'vocab' => [
                            ['en' => 'it is recommended that the tissue specimen be cryopreserved immediately', 'id' => 'sangat direkomendasikan bahwa spesimen jaringan dibekukan segera'],
                            ['en' => 'upon completion of the surgical biopsy', 'id' => 'setelah selesainya biopsi bedah'],
                        ],
                        'options' => [
                            'It is recommended that the tissue specimen be cryopreserved immediately upon completion of the surgical biopsy.',
                            'It is recommended that the tissue specimen is cryopreserved immediately upon completion of the surgical biopsy.',
                            'It is recommended that the tissue specimen to be cryopreserved immediately upon completion of the surgical biopsy.',
                            'It is recommended the tissue specimen being cryopreserved immediately upon completion of the surgical biopsy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk pasif Subjunctive setelah kata kerja/sifat rekomendasi adalah \'be + past participle\' (\'be cryopreserved\').',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Bukan rahasia lagi bahwa biaya transisi menuju energi bersih memerlukan investasi modal yang luar biasa besar.',
                        'target_word' => 'It is well established that the transition toward clean energy requires colossal capital investment commitments (It is well established that)',
                        'vocab' => [
                            ['en' => 'it is well established that the transition toward clean energy requires', 'id' => 'telah terbukti dengan baik bahwa transisi menuju energi bersih membutuhkan'],
                            ['en' => 'colossal capital investment commitments', 'id' => 'komitmen investasi modal yang luar biasa besar'],
                        ],
                        'options' => [
                            'It is well established that the transition toward clean energy requires colossal capital investment commitments.',
                            'It is well established which the transition toward clean energy requires colossal capital investment commitments.',
                            'It is well established, that the transition toward clean energy requires colossal capital investment commitments.',
                            'It is well established what the transition toward clean energy requires colossal capital investment commitments.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'It is well established that\' memperkenalkan fakta yang telah disepakati luas dalam wacana akademik.',
                    ],
                ]
            ],
        ];
    }
}
