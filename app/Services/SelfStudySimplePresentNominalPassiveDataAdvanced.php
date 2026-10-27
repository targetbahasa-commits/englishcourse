<?php

namespace App\Services;

class SelfStudySimplePresentNominalPassiveDataAdvanced
{
    /**
     * Get the complete Simple Present: Nominal, Passive, & Form Contrasts package.
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
            'banner_title' => 'Simple Present: Nominal, Passive, & Verbal vs Nominal vs Passive',
            'banner_subtitle' => 'Kuasai konstruksi kalimat Nominal Simple Present, kalimat Pasif ilmiah, serta komparasi sintaksis Verbal vs Nominal vs Passive untuk eliminasi kesalahan fatal dalam penulisan akademik.',
            'banner_badge' => 'MODULE 1.3 NOMINAL & PASSIVE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.3
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Tiga Pilar Struktur Kalimat Simple Present dalam Academic Writing',
            'concept_summary' => 'Dalam penulisan formal (IELTS, TOEFL, SAT, dan jurnal ilmiah), setiap klausa Simple Present Tense mutlak tergolong ke dalam salah satu dari tiga arsitektur sintaksis: (1) Kalimat Verbal (Subjek melakukan aksi nyata: S + V1), (2) Kalimat Nominal (Subjek menyatakan status, sifat, atau definisi: S + to be + Complement), dan (3) Kalimat Pasif (Subjek dikenai tindakan objektif: S + to be + V3). Menguasai perbedaan mutlak ketiganya adalah kunci utama untuk menghilangkan kesalahan fatal seperti double predicate ("is demonstrates") dan passive incomplete ("data collected").',
            'rules' => [
                [
                    'rule_title' => '1. Kalimat Nominal Simple Present (Definisi, Status & Kualitas)',
                    'rule_formula' => 'Subject + to be (am / is / are) + Complement (Noun Phrase / Adjective / Prepositional Phrase)',
                    'rule_description' => 'Digunakan saat kalimat TIDAK memiliki kata kerja aksi, melainkan mendefinisikan subjek atau menerangkan kualitasnya. Subjek jamak (They, We, You, Plural Nouns) menggunakan ARE; subjek tunggal (He, She, It, Singular & Uncountable Nouns) menggunakan IS; subjek I menggunakan AM.',
                    'examples' => [
                        [
                            'en' => 'Antibiotic resistance is a critical public health challenge worldwide.',
                            'id' => 'Resistensi antibiotik merupakan tantangan kesehatan masyarakat yang krusial di seluruh dunia.',
                            'note' => 'Predikat adalah linking verb "is" diikuti Noun Phrase pelengkap.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Kalimat Nominal Negatif & Interogatif',
                    'rule_formula' => 'Negatif: Subject + am/is/are + not + Complement | Tanya: Is/Are + Subject + Complement?',
                    'rule_description' => 'Kalimat nominal TIDAK BOLEH menggunakan auxiliary do/does! Cukup sisipkan kata "not" tepat setelah to be untuk kalimat negatif, atau pindahkan to be ke awal kalimat untuk kalimat tanya.',
                    'examples' => [
                        [
                            'en' => 'These initial survey findings are not representative of the broader population.',
                            'id' => 'Temuan survei awal ini tidak mewakili populasi yang lebih luas.',
                            'note' => 'Gunakan "are not representative", BUKAN "do not representative".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Kalimat Pasif Simple Present (Fokus Objektif & Prosedur)',
                    'rule_formula' => 'Subject (Objek Penerima Aksi) + to be (is / are) + Past Participle (Verb 3) (+ by Agent)',
                    'rule_description' => 'Digunakan dalam penulisan metodologi, proses ilmiah, dan pemaparan data agar perhatian pembaca tertuju pada objek penelitian, bukan pelaku penelitian. Gunakan ARE + V3 untuk subjek jamak, dan IS + V3 untuk subjek tunggal/uncountable.',
                    'examples' => [
                        [
                            'en' => 'Water samples are analyzed using automated spectroscopy in certified laboratories.',
                            'id' => 'Sampel-sampel air dianalisis menggunakan spektroskopi otomatis di laboratorium bersertifikat.',
                            'note' => 'Subjek jamak "samples" + "are analyzed" (to be + V3).'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Kalimat Pasif Negatif & Interogatif',
                    'rule_formula' => 'Negatif: Subject + is/are not + Verb 3 | Tanya: Is/Are + Subject + Verb 3?',
                    'rule_description' => 'Bentuk pasif negatif menyisipkan "not" setelah to be (e.g., is not discharged, are not permitted). Pada kalimat tanya, to be mendahului subjek penerima aksi.',
                    'examples' => [
                        [
                            'en' => 'Hazardous chemical effluents are not discharged directly into municipal drainage.',
                            'id' => 'Limbah cair kimia berbahaya tidak dibuang langsung ke saluran pembuangan kota.',
                            'note' => 'Gunakan "are not discharged", jangan gunakan "do not discharged".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '5. Verbal vs Nominal: Menghilangkan Double Predicate',
                    'rule_formula' => 'Verbal: S + Verb 1 (-s/-es) [TANPA TO BE] vs Nominal: S + is/are + Adj/Noun [WAJIB TO BE]',
                    'rule_description' => 'Kesalahan penutur Indonesia paling umum adalah menggabungkan to be dengan kata kerja bentuk pertama ("The study is proves" ➔ SALAH! Wajib: "The study proves"). Sebaliknya, dalam kalimat nominal dilarang menghilangkan to be ("These results significant" ➔ SALAH! Wajib: "These results are significant").',
                    'examples' => [
                        [
                            'en' => 'The framework regulates market volatility (Verbal) vs The framework is effective (Nominal)',
                            'id' => 'Kerangka kerja ini meregulasi volatilitas pasar (Verbal) vs Kerangka kerja ini efektif (Nominal)',
                            'note' => 'Dilarang keras: "The framework is regulates" (Double Predicate).'
                        ],
                    ],
                ],
                [
                    'rule_title' => '6. Verbal vs Passive: Aktor Aktif vs Penerima Aksi',
                    'rule_formula' => 'Active Verbal: S (Pelaku) + V1 + Object vs Passive: S (Penerima) + is/are + V3',
                    'rule_description' => 'Tentukan apakah subjek kalimat bertindak sebagai PELAKU aksi (Verbal Aktif) atau sebagai PENERIMA aksi (Pasif). Kesalahan sering terjadi saat kata kerja intransitif dipasifkan, atau saat kalimat pasif lupa menyisipkan to be ("Data analyzed yesterday" tanpa to be).',
                    'examples' => [
                        [
                            'en' => 'Researchers conduct trials (Verbal) vs Trials are conducted by researchers (Passive)',
                            'id' => 'Peneliti melakukan uji coba (Verbal Aktif) vs Uji coba dilakukan oleh peneliti (Pasif)',
                            'note' => 'Kalimat pasif wajib memiliki to be (is/are) sebelum Verb 3.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '7. Nominal vs Passive: Adjective Complement vs Past Participle Action',
                    'rule_formula' => 'Nominal: S + is/are + Adjective (Kondisi/Status) vs Passive: S + is/are + Verb 3 (Aksi yang Dikenakan)',
                    'rule_description' => 'Beberapa kata memiliki bentuk serupa antara Adjective dan Verb 3 (participle). Nominal mendeskripsikan kondisi permanen subjek (e.g., "The library is closed on Sundays" - status), sedangkan Pasif menyatakan tindakan yang dilakukan agen eksternal (e.g., "The laboratory is sanitized every morning by custodial staff" - aksi berulang).',
                    'examples' => [
                        [
                            'en' => 'The methodology is sound (Nominal/Adjective) vs The methodology is evaluated annually (Passive/Action)',
                            'id' => 'Metodologinya dapat diandalkan (Nominal) vs Metodologinya dievaluasi setiap tahun (Pasif)',
                            'note' => 'Pahami fungsi sintaksis kata setelah to be.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '8. Tiga Pilar: Verbal vs Nominal vs Passive Synthesis',
                    'rule_formula' => 'S + V1 (Verbal Aktif) | S + is/am/are + Comp (Nominal) | S + is/am/are + V3 (Pasif)',
                    'rule_description' => 'Kuasai identifikasi ketiga bentuk kalimat tunggal ini dalam penulisan ilmiah akademik.',
                    'examples' => [
                        [
                            'en' => 'Engineers design sustainable transit solutions for metropolitan areas.',
                            'id' => 'Para insinyur merancang solusi transportasi berkelanjutan untuk kawasan metropolitan.',
                            'note' => 'Contoh kalimat verbal tunggal murni: Subjek "Engineers" + Verb 1 "design" + Objek Frasa Nomina.'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Parameter', '1. Kalimat Verbal', '2. Kalimat Nominal', '3. Kalimat Pasif'],
                'rows' => [
                    ['Fungsi Inti', 'Menyatakan aksi/aktivitas subjek', 'Mendeskripsikan status/kualitas/definisi', 'Menonjolkan objek penerima tindakan'],
                    ['Komponen Predikat', 'Verb 1 (-s/-es untuk subjek tunggal)', 'To Be (is, am, are) + Noun / Adjective / Adverb', 'To Be (is, am, are) + Verb 3 (Past Participle)'],
                    ['To Be Digunakan?', 'DILARANG (Tidak boleh ada is/am/are)', 'WAJIB (is, am, are sebagai inti predikat)', 'WAJIB (is, am, are sebagai auxiliary)'],
                    ['Bentuk Negatif', 'Subject + do/does not + Verb 1', 'Subject + is/am/are + not + Complement', 'Subject + is/am/are + not + Verb 3'],
                    ['Contoh Kalimat', 'The government enforces the regulation.', 'The regulation is mandatory for all banks.', 'The regulation is enforced rigorously.'],
                    ['Kesalahan Fatal', 'The government is enforces... (SALAH)', 'The regulation mandatory... (SALAH)', 'The regulation enforces by government... (SALAH)'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The research is demonstrates that climate change is accelerates.',
                    'correct' => 'The research demonstrates that climate change accelerates.',
                    'explanation' => 'Double Predicate: Jangan menyisipkan "is" sebelum kata kerja verbal "demonstrates" dan "accelerates".'
                ],
                [
                    'incorrect' => 'These policies effective in reducing economic inequality.',
                    'correct' => 'These policies are effective in reducing economic inequality.',
                    'explanation' => 'Missing To Be: Kalimat nominal wajib memiliki linking verb "are" sebelum kata sifat "effective".'
                ],
                [
                    'incorrect' => 'New guidelines implement by the council every quarter.',
                    'correct' => 'New guidelines are implemented by the council every quarter.',
                    'explanation' => 'Passive Without To Be: Kalimat pasif wajib menggunakan "are implemented" (to be + V3).'
                ],
                [
                    'incorrect' => 'The data does not consistent with previous findings.',
                    'correct' => 'The data are not consistent with previous findings.',
                    'explanation' => 'Jangan gunakan "does not" untuk kalimat nominal; kata "consistent" adalah kata sifat (Adjective), sehingga harus menggunakan to be: "are not consistent".'
                ],
            ],
            'exam_tips' => [
                'Langkah 1: Identifikasi jenis predikat dalam kalimat: Apakah itu AKSI PELAKU (Verbal), STATUS/SIFAT (Nominal), atau TINDAKAN TERHADAP OBJEK (Pasif)?',
                'Langkah 2: Jika Verbal ➔ Gunakan V1 (-s/-es untuk tunggal). JANGAN masukkan is/am/are!',
                'Langkah 3: Jika Nominal ➔ Gunakan is/am/are + Noun/Adj. JANGAN gunakan do/does!',
                'Langkah 4: Jika Pasif ➔ Gunakan is/am/are + Verb 3 (Past Participle).',
                'Dalam esai Task 2 IELTS, kombinasikan ketiga struktur ini secara bergantian untuk memaksimalkan skor Grammatical Range & Accuracy.'
            ],
        ];
    }

    /**
     * Get the 8 structured sub-lessons with 10 exercises each (80 exercises total).
     */
    public static function getSubLessons(): array
    {
        return [
[
                'id' => 'nominal-plural',
                'name' => 'Simple Present Nominal: Subjek I, You, We, They & Benda Jamak (+ am/are)',
                'code' => '1.3.1',
                'concept_title' => 'Kalimat Nominal Simple Present dengan Subjek I, You, We, They, dan Plural Nouns',
                'concept_description' => 'Kalimat nominal menyatakan identitas, status, sifat, atau lokasi subjek tanpa kata kerja aksi. Untuk subjek jamak (They, We, You, Plural Nouns: researchers, universities, alternatives), predikat wajib berupa to be \'are\' diikuti pelengkap (Complement: Noun Phrase, Adjective, atau Prepositional Phrase). Untuk subjek \'I\', gunakan to be \'am\'.',
                'formula' => 'Subject (I ➔ am | You / We / They / Plural Nouns ➔ are) + Complement (Noun / Adjective / Adverbial)',
                'rules' => [
                    'Subjek jamak wajib menggunakan to be \'are\'.',
                    'Subjek \'I\' menggunakan to be \'am\'.',
                    'Dilarang memasukkan kata kerja aksi setelah to be (e.g., \'They are study\' adalah salah).',
                    'Kata sifat (Adjective) dan frasa kata benda (Noun Phrase) setelah to be berfungsi sebagai Subject Complement.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Energi surya dan tenaga angin merupakan alternatif yang layak untuk menggantikan bahan bakar fosil konvensional.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'solar and wind power' => [
                                'id' => 'energi surya dan tenaga angin',
                                'pos' => '(n phr)',
                            ],
                            'viable alternatives' => [
                                'id' => 'alternatif yang layak',
                                'pos' => '(n phr)',
                            ],
                            'conventional fossil fuels' => [
                                'id' => 'bahan bakar fosil konvensional',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Solar and wind power are viable alternatives to conventional fossil fuels.',
                            'Solar and wind power is viable alternatives to conventional fossil fuels.',
                            'Solar and wind power viable alternatives to conventional fossil fuels.',
                            'Solar and wind power are being viable alternatives to conventional fossil fuels.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek majemuk \'Solar and wind power\' adalah jamak (plural). Oleh karena itu, linking verb to be yang benar adalah \'are\', diikuti Noun Phrase pelengkap \'viable alternatives\'.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Para peneliti di laboratorium universitas sangat berhati-hati dalam menangani bahan kimia berbahaya.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'researchers' => [
                                'id' => 'para peneliti',
                                'pos' => '(n)',
                            ],
                            'meticulous' => [
                                'id' => 'sangat berhati-hati / teliti',
                                'pos' => '(adj)',
                            ],
                            'hazardous chemicals' => [
                                'id' => 'bahan kimia berbahaya',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Researchers in university laboratories are meticulous in handling hazardous chemical reagents.',
                            'Researchers in university laboratories is meticulous in handling hazardous chemical reagents.',
                            'Researchers in university laboratories meticulous in handling hazardous chemical reagents.',
                            'Researchers in university laboratories are be meticulous in handling hazardous chemical reagents.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjeknya adalah \'Researchers\' (jamak). Kalimat nominal yang menerangkan sifat subjek (\'meticulous\' = Adjective) wajib menggunakan to be \'are\'.',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Kami sadar akan keterbatasan metodologis yang melekat pada pengumpulan data survei daring.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'cognizant of' => [
                                'id' => 'sadar akan / menyadari',
                                'pos' => '(adj phr)',
                            ],
                            'methodological constraints' => [
                                'id' => 'keterbatasan metodologis',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'We are fully cognizant of the methodological constraints inherent in online survey sampling.',
                            'We is fully cognizant of the methodological constraints inherent in online survey sampling.',
                            'We fully cognizant of the methodological constraints inherent in online survey sampling.',
                            'We are be fully cognizant of the methodological constraints inherent in online survey sampling.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'We\' selalu berpasangan dengan linking verb \'are\' sebelum komplemen kata sifat \'cognizant of\'.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Universitas-universitas terkemuka bertanggung jawab penuh atas pemeliharaan integritas akademik di lingkungan kampus.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'leading universities' => [
                                'id' => 'universitas terkemuka',
                                'pos' => '(n)',
                            ],
                            'responsible for' => [
                                'id' => 'bertanggung jawab atas',
                                'pos' => '(adj phr)',
                            ],
                            'academic integrity' => [
                                'id' => 'integritas akademik',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Leading universities are primarily responsible for maintaining scholarly integrity across research faculties.',
                            'Leading universities is primarily responsible for maintaining scholarly integrity across research faculties.',
                            'Leading universities primarily responsible for maintaining scholarly integrity across research faculties.',
                            'Leading universities are being primarily responsible for maintaining scholarly integrity across research faculties.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'Leading universities\' adalah plural noun. Predikat nominal wajib menggunakan \'are responsible\'.',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Saya yakin bahwa kerangka kerja regulasi baru ini efektif dalam membatasi emisi karbon.',
                        'target_word' => 'am (Linking Verb)',
                        'vocab' => [
                            'I' => [
                                'id' => 'saya',
                                'pos' => '(pron)',
                            ],
                            'confident that' => [
                                'id' => 'yakin bahwa',
                                'pos' => '(adj)',
                            ],
                            'regulatory framework' => [
                                'id' => 'kerangka kerja regulasi',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'I am confident that this newly formulated regulatory framework is effective in curbing emissions.',
                            'I is confident that this newly formulated regulatory framework is effective in curbing emissions.',
                            'I are confident that this newly formulated regulatory framework is effective in curbing emissions.',
                            'I confident that this newly formulated regulatory framework is effective in curbing emissions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek orang pertama tunggal \'I\' wajib menggunakan to be \'am\': \'I am confident\'.',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Kawasan lindung pesisir sangat penting bagi pelestarian keanekaragaman hayati terumbu karang.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'marine protected areas' => [
                                'id' => 'kawasan lindung pesisir/laut',
                                'pos' => '(n)',
                            ],
                            'vital for' => [
                                'id' => 'sangat penting / krusial bagi',
                                'pos' => '(adj phr)',
                            ],
                            'biodiversity conservation' => [
                                'id' => 'pelestarian keanekaragaman hayati',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Marine protected areas are vital for the long-term conservation of coral reef biodiversity.',
                            'Marine protected areas is vital for the long-term conservation of coral reef biodiversity.',
                            'Marine protected areas vital for the long-term conservation of coral reef biodiversity.',
                            'Marine protected areas are be vital for the long-term conservation of coral reef biodiversity.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'Marine protected areas\' menggunakan to be \'are\' diikuti kata sifat \'vital\'.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Kedua artikel jurnal tersebut relevan secara langsung dengan topik tinjauan literatur disertasi saya.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'journal articles' => [
                                'id' => 'artikel jurnal',
                                'pos' => '(n)',
                            ],
                            'directly relevant to' => [
                                'id' => 'relevan secara langsung dengan',
                                'pos' => '(adj phr)',
                            ],
                            'literature review' => [
                                'id' => 'tinjauan literatur',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Both journal articles are directly relevant to the central theme of my doctoral dissertation.',
                            'Both journal articles is directly relevant to the central theme of my doctoral dissertation.',
                            'Both journal articles directly relevant to the central theme of my doctoral dissertation.',
                            'Both journal articles are be directly relevant to the central theme of my doctoral dissertation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'Both journal articles\' adalah jamak. To be yang tepat adalah \'are\'.',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Para pemangku kepentingan utama selalu optimis mengenai prospek adopsi energi terbarukan di daerah mereka.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'key stakeholders' => [
                                'id' => 'pemangku kepentingan utama',
                                'pos' => '(n)',
                            ],
                            'optimistic about' => [
                                'id' => 'optimis mengenai',
                                'pos' => '(adj phr)',
                            ],
                            'renewable energy adoption' => [
                                'id' => 'adopsi energi terbarukan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Key regional stakeholders are consistently optimistic about the expansion of renewable power generation.',
                            'Key regional stakeholders is consistently optimistic about the expansion of renewable power generation.',
                            'Key regional stakeholders consistently optimistic about the expansion of renewable power generation.',
                            'Key regional stakeholders are be consistently optimistic about the expansion of renewable power generation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'Key regional stakeholders\' berpasangan dengan \'are ... optimistic\'.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Data statistik dari kementerian tenaga kerja tersedia untuk umum melalui portal daring pemerintah.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'statistical data' => [
                                'id' => 'data statistik',
                                'pos' => '(n plural)',
                            ],
                            'publicly accessible' => [
                                'id' => 'tersedia untuk umum',
                                'pos' => '(adj)',
                            ],
                            'online portal' => [
                                'id' => 'portal daring',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Statistical data from the labor ministry are publicly accessible through the national open-data portal.',
                            'Statistical data from the labor ministry is publicly accessible through the national open-data portal.',
                            'Statistical data from the labor ministry publicly accessible through the national open-data portal.',
                            'Statistical data from the labor ministry are be publicly accessible through the national open-data portal.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dalam penulisan akademik formal, \'data\' diperlakukan sebagai kata benda jamak (plural). Maka to be yang tepat adalah \'are publicly accessible\'.',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Anda memenuhi syarat untuk mengajukan permohonan hibah penelitian pascadoktoral internasional ini.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'you' => [
                                'id' => 'anda',
                                'pos' => '(pron)',
                            ],
                            'eligible to apply' => [
                                'id' => 'memenuhi syarat untuk mengajukan',
                                'pos' => '(adj phr)',
                            ],
                            'postdoctoral research grant' => [
                                'id' => 'hibah penelitian pascadoktoral',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'You are fully eligible to apply for this competitive international postdoctoral fellowship grant.',
                            'You is fully eligible to apply for this competitive international postdoctoral fellowship grant.',
                            'You fully eligible to apply for this competitive international postdoctoral fellowship grant.',
                            'You are be fully eligible to apply for this competitive international postdoctoral fellowship grant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'You\' selalu menggunakan to be \'are\': \'You are eligible\'.',
                    ],
                ],
            ],
[
                'id' => 'nominal-singular',
                'name' => 'Simple Present Nominal: Subjek He, She, It & Benda Tunggal/Uncountable (+ is)',
                'code' => '1.3.2',
                'concept_title' => 'Kalimat Nominal Simple Present dengan Subjek He, She, It, dan Uncountable Nouns',
                'concept_description' => 'Ketika subjek berupa orang ketiga tunggal (He, She, It), nama benda tunggal (a hypothesis, the institution), atau kata benda tak dapat dihitung (uncountable nouns: evidence, research, information, legislation, biodiversity), to be yang digunakan mutlak \'is\'.',
                'formula' => 'Subject (He / She / It / Singular Noun / Uncountable Noun) + is + Complement (Noun / Adjective / Prepositional Phrase)',
                'rules' => [
                    'Subjek orang ketiga tunggal dan benda tunggal selalu menggunakan \'is\'.',
                    'Uncountable nouns (evidence, research, air pollution) berstatus tunggal ➔ wajib menggunakan \'is\'.',
                    'Gerund dan klausa yang bertindak sebagai subjek juga menggunakan \'is\'.',
                    'Jangan sekali-kali menyisipkan kata kerja dasar setelah \'is\' (e.g., \'The theory is explain\' adalah salah fatal).',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Resistensi antibiotik merupakan tantangan kesehatan masyarakat yang krusial di seluruh dunia.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'antibiotic resistance' => [
                                'id' => 'resistensi antibiotik',
                                'pos' => '(n uncountable)',
                            ],
                            'critical public health challenge' => [
                                'id' => 'tantangan kesehatan masyarakat krusial',
                                'pos' => '(n phr)',
                            ],
                            'worldwide' => [
                                'id' => 'di seluruh dunia',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'Antibiotic resistance is a critical public health challenge worldwide.',
                            'Antibiotic resistance are a critical public health challenge worldwide.',
                            'Antibiotic resistance a critical public health challenge worldwide.',
                            'Antibiotic resistance is be a critical public health challenge worldwide.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Antibiotic resistance\' adalah uncountable noun (tunggal). Linking verb yang benar adalah \'is\' diikuti Noun Phrase pelengkap.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Keanekaragaman hayati sangat penting untuk menjaga keseimbangan dan ketahanan ekosistem hutan hujan tropis.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'biodiversity' => [
                                'id' => 'keanekaragaman hayati',
                                'pos' => '(n uncountable)',
                            ],
                            'essential for' => [
                                'id' => 'sangat penting bagi',
                                'pos' => '(adj phr)',
                            ],
                            'ecosystem resilience' => [
                                'id' => 'ketahanan ekosistem',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Biodiversity is essential for sustaining the structural resilience of tropical rainforest ecosystems.',
                            'Biodiversity are essential for sustaining the structural resilience of tropical rainforest ecosystems.',
                            'Biodiversity essential for sustaining the structural resilience of tropical rainforest ecosystems.',
                            'Biodiversity is be essential for sustaining the structural resilience of tropical rainforest ecosystems.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Biodiversity\' adalah kata benda tunggal/tak dapat dihitung. Verb yang tepat adalah \'is essential\'.',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Bukti empiris yang disajikan dalam artikel tersebut konsisten dengan temuan uji klinis terdahulu.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'empirical evidence' => [
                                'id' => 'bukti empiris',
                                'pos' => '(n uncountable)',
                            ],
                            'consistent with' => [
                                'id' => 'konsisten dengan',
                                'pos' => '(adj phr)',
                            ],
                            'prior clinical trials' => [
                                'id' => 'uji klinis terdahulu',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The empirical evidence presented in the journal article is consistent with prior clinical benchmarks.',
                            'The empirical evidence presented in the journal article are consistent with prior clinical benchmarks.',
                            'The empirical evidence presented in the journal article consistent with prior clinical benchmarks.',
                            'The empirical evidence presented in the journal article is be consistent with prior clinical benchmarks.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Evidence\' adalah uncountable noun yang berstatus tunggal dalam bahasa Inggris. Oleh karena itu, to be yang digunakan adalah \'is\'.',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Penelitian mengenai komputasi kuantum ini sangat menjanjikan untuk masa depan enkripsi data.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'research into quantum computing' => [
                                'id' => 'penelitian tentang komputasi kuantum',
                                'pos' => '(n phr)',
                            ],
                            'highly promising' => [
                                'id' => 'sangat menjanjikan',
                                'pos' => '(adj phr)',
                            ],
                            'data encryption' => [
                                'id' => 'enkripsi data',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'This ongoing research into quantum cryptography is highly promising for sovereign data security.',
                            'This ongoing research into quantum cryptography are highly promising for sovereign data security.',
                            'This ongoing research into quantum cryptography highly promising for sovereign data security.',
                            'This ongoing research into quantum cryptography is be highly promising for sovereign data security.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Research\' adalah kata benda tak dapat dihitung (uncountable). Predikat yang benar adalah \'is highly promising\'.',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Metodologi yang diusulkan oleh tim geologi sangat tepat untuk menganalisis lapisan batuan purba.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'proposed methodology' => [
                                'id' => 'metodologi yang diusulkan',
                                'pos' => '(n singular)',
                            ],
                            'appropriate for' => [
                                'id' => 'sangat tepat untuk',
                                'pos' => '(adj phr)',
                            ],
                            'sedimentary rock strata' => [
                                'id' => 'lapisan batuan purba',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The methodology proposed by the geological research team is well suited for analyzing sedimentary strata.',
                            'The methodology proposed by the geological research team are well suited for analyzing sedimentary strata.',
                            'The methodology proposed by the geological research team well suited for analyzing sedimentary strata.',
                            'The methodology proposed by the geological research team is be well suited for analyzing sedimentary strata.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek intinya adalah \'The methodology\' (singular noun). To be yang selaras adalah \'is\'.',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Kerangka regulasi kecerdasan buatan merupakan prioritas kebijakan mendesak bagi parlemen nasional.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'regulatory framework' => [
                                'id' => 'kerangka regulasi',
                                'pos' => '(n singular)',
                            ],
                            'urgent policy priority' => [
                                'id' => 'prioritas kebijakan mendesak',
                                'pos' => '(n phr)',
                            ],
                            'national parliament' => [
                                'id' => 'parlemen nasional',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The artificial intelligence governance framework is an urgent legislative priority for the national parliament.',
                            'The artificial intelligence governance framework are an urgent legislative priority for the national parliament.',
                            'The artificial intelligence governance framework an urgent legislative priority for the national parliament.',
                            'The artificial intelligence governance framework is be an urgent legislative priority for the national parliament.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The artificial intelligence governance framework\' adalah subjek tunggal. Predikat kalimat adalah \'is an urgent legislative priority\'.',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Informasi keuangan yang disediakan oleh dewan direksi akurat dan dapat diverifikasi secara independen.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'financial information' => [
                                'id' => 'informasi keuangan',
                                'pos' => '(n uncountable)',
                            ],
                            'accurate and verifiable' => [
                                'id' => 'akurat dan dapat diverifikasi',
                                'pos' => '(adj phr)',
                            ],
                            'independently' => [
                                'id' => 'secara independen',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'The financial information furnished by the executive board is accurate and independently verifiable.',
                            'The financial information furnished by the executive board are accurate and independently verifiable.',
                            'The financial information furnished by the executive board accurate and independently verifiable.',
                            'The financial information furnished by the executive board is be accurate and independently verifiable.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Information\' adalah uncountable noun (tunggal). Verb to be yang tepat adalah \'is\'.',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Kenaikan suhu global rata-rata merupakan indikator nyata dari percepatan perubahan iklim.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'rise in average global temperature' => [
                                'id' => 'kenaikan suhu global rata-rata',
                                'pos' => '(n phr)',
                            ],
                            'clear indicator' => [
                                'id' => 'indikator nyata',
                                'pos' => '(n phr)',
                            ],
                            'accelerated climate change' => [
                                'id' => 'percepatan perubahan iklim',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The persistent rise in mean global temperature is a tangible indicator of accelerating climate change.',
                            'The persistent rise in mean global temperature are a tangible indicator of accelerating climate change.',
                            'The persistent rise in mean global temperature a tangible indicator of accelerating climate change.',
                            'The persistent rise in mean global temperature is be a tangible indicator of accelerating climate change.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun kalimat adalah \'The persistent rise\' (tunggal). Predikat yang selaras adalah \'is\'.',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Profesor Aris adalah pakar terkemuka di bidang linguistik terapan dan sintaksis komparatif.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'leading specialist' => [
                                'id' => 'pakar terkemuka',
                                'pos' => '(n phr)',
                            ],
                            'applied linguistics' => [
                                'id' => 'linguistik terapan',
                                'pos' => '(n)',
                            ],
                            'comparative syntax' => [
                                'id' => 'sintaksis komparatif',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Professor Aris is a distinguished authority in applied linguistics and comparative syntax.',
                            'Professor Aris are a distinguished authority in applied linguistics and comparative syntax.',
                            'Professor Aris a distinguished authority in applied linguistics and comparative syntax.',
                            'Professor Aris is be a distinguished authority in applied linguistics and comparative syntax.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek adalah nama orang tunggal \'Professor Aris\' (He). To be yang benar adalah \'is\'.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Undang-undang baru mengenai perlindungan data pribadi sangat ketat bagi perusahaan teknologi multinasional.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'legislation' => [
                                'id' => 'undang-undang / regulasi',
                                'pos' => '(n uncountable)',
                            ],
                            'stringent' => [
                                'id' => 'sangat ketat',
                                'pos' => '(adj)',
                            ],
                            'multinational corporations' => [
                                'id' => 'perusahaan multinasional',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The new legislation regarding consumer data privacy is exceptionally stringent for multinational tech firms.',
                            'The new legislation regarding consumer data privacy are exceptionally stringent for multinational tech firms.',
                            'The new legislation regarding consumer data privacy exceptionally stringent for multinational tech firms.',
                            'The new legislation regarding consumer data privacy is be exceptionally stringent for multinational tech firms.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Legislation\' adalah uncountable noun (tunggal). Bentuk to be yang benar adalah \'is\'.',
                    ],
                ],
            ],
[
                'id' => 'nominal-negative-interrogative',
                'name' => 'Simple Present Nominal: Bentuk Negatif & Interogatif (am/is/are not & Is/Are...?)',
                'code' => '1.3.3',
                'concept_title' => 'Pola Negasi dan Kalimat Tanya pada Kalimat Nominal Simple Present',
                'concept_description' => 'Kalimat nominal disangkal HANYA dengan menyisipkan partikel negasi \'not\' setelah to be: \'is not\' (isn\'t), \'are not\' (aren\'t), atau \'am not\'. Kalimat nominal TIDAK PERNAH menggunakan auxiliary \'do not\' atau \'does not\'. Untuk membentuk kalimat tanya, pindahkan to be ke posisi sebelum subjek.',
                'formula' => 'Negatif: S + is / am / are + not + Complement | Tanya: (WH-word) + Is / Are + S + Complement?',
                'rules' => [
                    'Dilarang menggunakan do not / does not pada kalimat nominal (e.g., \'The result does not valid\' adalah SALAH MUTLAK).',
                    'Gunakan \'is not\' atau \'are not\' diikuti Adjective, Noun, atau Prepositional Phrase.',
                    'Kalimat tanya yes/no diawali dengan \'Is\' atau \'Are\' sebelum subjek.',
                    'Kalimat tanya informasi (WH-questions) meletakkan WH-word sebelum to be (e.g., \'Why is the policy inadequate?\').',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Temuan survei awal ini tidak mewakili seluruh populasi nasional secara akurat.',
                        'target_word' => 'are not (Negative Nominal)',
                        'vocab' => [
                            'survey findings' => [
                                'id' => 'temuan survei',
                                'pos' => '(n plural)',
                            ],
                            'representative of' => [
                                'id' => 'mewakili / representatif terhadap',
                                'pos' => '(adj phr)',
                            ],
                            'entire national population' => [
                                'id' => 'seluruh populasi nasional',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'These preliminary survey findings are not representative of the broader national demographic.',
                            'These preliminary survey findings do not representative of the broader national demographic.',
                            'These preliminary survey findings is not representative of the broader national demographic.',
                            'These preliminary survey findings does not representative of the broader national demographic.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'representative\' adalah kata sifat (Adjective). Karena subjek \'findings\' jamak, bentuk negasi yang benar adalah \'are not representative\', BUKAN \'do not\'.',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Tingkat inflasi saat ini tidak cukup stabil untuk membenarkan penurunan suku bunga acuan bank sentral.',
                        'target_word' => 'is not (Negative Nominal)',
                        'vocab' => [
                            'inflation rate' => [
                                'id' => 'tingkat inflasi',
                                'pos' => '(n singular)',
                            ],
                            'stable enough to' => [
                                'id' => 'cukup stabil untuk',
                                'pos' => '(adj phr)',
                            ],
                            'benchmark interest rate' => [
                                'id' => 'suku bunga acuan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The prevailing inflation rate is not sufficiently stable to justify benchmark interest rate cuts.',
                            'The prevailing inflation rate does not sufficiently stable to justify benchmark interest rate cuts.',
                            'The prevailing inflation rate are not sufficiently stable to justify benchmark interest rate cuts.',
                            'The prevailing inflation rate do not sufficiently stable to justify benchmark interest rate cuts.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The prevailing inflation rate\' adalah subjek tunggal. Karena predikatnya menerangkan kata sifat (\'stable\'), bentuk negasi wajib memakai to be: \'is not sufficiently stable\'.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Apakah kerangka regulasi ini memadai untuk mencegah monopoli pasar digital?',
                        'target_word' => 'Is (Interrogative To Be)',
                        'vocab' => [
                            'regulatory framework' => [
                                'id' => 'kerangka regulasi',
                                'pos' => '(n singular)',
                            ],
                            'adequate to prevent' => [
                                'id' => 'memadai untuk mencegah',
                                'pos' => '(adj phr)',
                            ],
                            'digital market monopolies' => [
                                'id' => 'monopoli pasar digital',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Is this antitrust regulatory framework adequate to prevent algorithmic market cartels?',
                            'Does this antitrust regulatory framework adequate to prevent algorithmic market cartels?',
                            'Are this antitrust regulatory framework adequate to prevent algorithmic market cartels?',
                            'Do this antitrust regulatory framework adequate to prevent algorithmic market cartels?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat tanya nominal dengan pelengkap kata sifat (\'adequate\') dan subjek tunggal (\'framework\') diawali dengan to be \'Is\', bukan auxiliary \'Does\'.',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Apakah para mahasiswa pascasarjana tersebut siap untuk mempublikasikan artikel mereka di jurnal internasional?',
                        'target_word' => 'Are (Interrogative To Be)',
                        'vocab' => [
                            'postgraduate candidates' => [
                                'id' => 'mahasiswa pascasarjana',
                                'pos' => '(n plural)',
                            ],
                            'ready to publish' => [
                                'id' => 'siap untuk mempublikasikan',
                                'pos' => '(adj phr)',
                            ],
                            'peer-reviewed journals' => [
                                'id' => 'jurnal peer-reviewed',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Are those postgraduate research candidates ready to disseminate their papers in indexed journals?',
                            'Do those postgraduate research candidates ready to disseminate their papers in indexed journals?',
                            'Is those postgraduate research candidates ready to disseminate their papers in indexed journals?',
                            'Does those postgraduate research candidates ready to disseminate their papers in indexed journals?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'candidates\' adalah jamak dan diikuti komplemen Adjective (\'ready\'). Kalimat tanya diawali dengan \'Are\'.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Penelitian laboratorium ini tidak mahal dibandingkan dengan eksperimen akselerator partikel skala besar.',
                        'target_word' => 'is not (Negative Nominal)',
                        'vocab' => [
                            'laboratory research' => [
                                'id' => 'penelitian laboratorium',
                                'pos' => '(n uncountable)',
                            ],
                            'prohibitively expensive' => [
                                'id' => 'sangat mahal',
                                'pos' => '(adj phr)',
                            ],
                            'particle accelerators' => [
                                'id' => 'akselerator partikel',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'This benchtop laboratory investigation is not prohibitively expensive relative to particle accelerator trials.',
                            'This benchtop laboratory investigation does not prohibitively expensive relative to particle accelerator trials.',
                            'This benchtop laboratory investigation are not prohibitively expensive relative to particle accelerator trials.',
                            'This benchtop laboratory investigation do not prohibitively expensive relative to particle accelerator trials.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Investigation\' adalah subjek tunggal dan \'expensive\' adalah Adjective. Bentuk negasi yang tepat adalah \'is not\'.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Kriteria seleksi beasiswa tersebut tidak adil bagi pelamar yang berasal dari wilayah pedalaman tertinggal.',
                        'target_word' => 'are not (Negative Nominal)',
                        'vocab' => [
                            'scholarship selection criteria' => [
                                'id' => 'kriteria seleksi beasiswa',
                                'pos' => '(n plural)',
                            ],
                            'equitable for' => [
                                'id' => 'adil bagi',
                                'pos' => '(adj phr)',
                            ],
                            'underprivileged regions' => [
                                'id' => 'wilayah tertinggal',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The fellowship selection criteria are not equitable for candidates originating from marginalized territories.',
                            'The fellowship selection criteria do not equitable for candidates originating from marginalized territories.',
                            'The fellowship selection criteria is not equitable for candidates originating from marginalized territories.',
                            'The fellowship selection criteria does not equitable for candidates originating from marginalized territories.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Criteria\' adalah bentuk jamak dari \'criterion\'. Bentuk negasi nominal untuk subjek jamak adalah \'are not equitable\'.',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Mengapa transisi menuju kendaraan listrik tanpa emisi tidak semudah yang diperkirakan para pakar?',
                        'target_word' => 'is ... not (Negative WH-Question)',
                        'vocab' => [
                            'transition to electric vehicles' => [
                                'id' => 'transisi ke kendaraan listrik',
                                'pos' => '(n phr)',
                            ],
                            'as straightforward as' => [
                                'id' => 'semudah / sejelas yang',
                                'pos' => '(adj phr)',
                            ],
                            'analysts anticipated' => [
                                'id' => 'diperkirakan para analis',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Why is the nationwide adoption of zero-emission mobility not as straightforward as analysts projected?',
                            'Why does the nationwide adoption of zero-emission mobility not as straightforward as analysts projected?',
                            'Why are the nationwide adoption of zero-emission mobility not as straightforward as analysts projected?',
                            'Why do the nationwide adoption of zero-emission mobility not as straightforward as analysts projected?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek kalimat adalah \'the nationwide adoption\' (singular). Kalimat tanya nominal diawali WH + to be: \'Why is ... not as straightforward\'.',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Pemerintah tidak berwenang untuk mencabut izin operasional rumah sakit tanpa penyelidikan formal terlebih dahulu.',
                        'target_word' => 'is not (Negative Nominal)',
                        'vocab' => [
                            'government' => [
                                'id' => 'pemerintah',
                                'pos' => '(n singular)',
                            ],
                            'authorized to' => [
                                'id' => 'berwenang untuk',
                                'pos' => '(adj phr)',
                            ],
                            'formal inquiry' => [
                                'id' => 'penyelidikan formal',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The municipal regulator is not legally authorized to revoke clinical permits without a formal statutory inquiry.',
                            'The municipal regulator does not legally authorized to revoke clinical permits without a formal statutory inquiry.',
                            'The municipal regulator are not legally authorized to revoke clinical permits without a formal statutory inquiry.',
                            'The municipal regulator do not legally authorized to revoke clinical permits without a formal statutory inquiry.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The municipal regulator\' adalah tunggal dan \'authorized\' berfungsi sebagai Adjective complement. Bentuk negasi yang benar adalah \'is not\'.',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Apakah instrumen laboratorium mutakhir tersebut cocok untuk mengukur radiasi tingkat sangat rendah?',
                        'target_word' => 'Is (Interrogative To Be)',
                        'vocab' => [
                            'laboratory apparatus' => [
                                'id' => 'instrumen / aparatus laboratorium',
                                'pos' => '(n singular)',
                            ],
                            'suitable for measuring' => [
                                'id' => 'cocok untuk mengukur',
                                'pos' => '(adj phr)',
                            ],
                            'low-level background radiation' => [
                                'id' => 'radiasi tingkat rendah',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Is this state-of-the-art detector suitable for measuring sub-picocurie radiation thresholds?',
                            'Does this state-of-the-art detector suitable for measuring sub-picocurie radiation thresholds?',
                            'Are this state-of-the-art detector suitable for measuring sub-picocurie radiation thresholds?',
                            'Do this state-of-the-art detector suitable for measuring sub-picocurie radiation thresholds?',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'This detector\' adalah subjek tunggal yang diikuti komplemen \'suitable\' (Adjective). Kalimat tanya wajib menggunakan \'Is\'.',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Hipotesis kerja alternatif ini tidak konsisten dengan data geokimia yang diperoleh dari pengeboran inti laut.',
                        'target_word' => 'is not (Negative Nominal)',
                        'vocab' => [
                            'working hypothesis' => [
                                'id' => 'hipotesis kerja',
                                'pos' => '(n singular)',
                            ],
                            'consistent with' => [
                                'id' => 'konsisten dengan',
                                'pos' => '(adj phr)',
                            ],
                            'geochemical core data' => [
                                'id' => 'data geokimia pengeboran inti',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'This secondary working hypothesis is not consistent with geochemical metrics recovered from deep-sea core drilling.',
                            'This secondary working hypothesis does not consistent with geochemical metrics recovered from deep-sea core drilling.',
                            'This secondary working hypothesis are not consistent with geochemical metrics recovered from deep-sea core drilling.',
                            'This secondary working hypothesis do not consistent with geochemical metrics recovered from deep-sea core drilling.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'hypothesis\' berakhiran -is (tunggal) dan pelengkapnya adalah Adjective (\'consistent\'). Bentuk yang tepat adalah \'is not consistent\'.',
                    ],
                ],
            ],
[
                'id' => 'passive-plural',
                'name' => 'Simple Present Passive: Subjek Jamak & I/You/We/They (+ are/am + V3)',
                'code' => '1.3.4',
                'concept_title' => 'Kalimat Pasif Simple Present untuk Subjek Jamak (are + Past Participle)',
                'concept_description' => 'Kalimat pasif berfokus pada apa yang dialami oleh objek penerima aksi, bukan siapa yang melakukan aksi. Dalam laporan sains dan esai akademis, konstruksi pasif digunakan secara luas untuk menjelaskan prosedur rutin dan fakta yang teruji. Rumus pasif Simple Present untuk subjek jamak adalah: Subjek Jamak + ARE + Verb 3 (Past Participle).',
                'formula' => 'Subject (Plural Nouns / They / We / You) + ARE + Verb 3 (Past Participle) (+ by Agent)',
                'rules' => [
                    'Subjek jamak wajib menggunakan auxiliary \'are\' sebelum Verb 3.',
                    'Verb harus selalu berupa Past Participle (Verb 3) seperti analyzed, conducted, recorded, observed.',
                    'Pelaku aksi (+ by Agent) bersifat opsional dan sering dihilangkan bila bersifat umum atau tidak relevan.',
                    'Jangan lupa menyisipkan \'are\' (menulis \'Samples analyzed daily\' tanpa auxiliary adalah kalimat runtuh/fragment).',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Sampel-sampel darah dianalisis di laboratorium bersertifikat menggunakan spektrometer otomatis.',
                        'target_word' => 'are analyzed (Passive Verb)',
                        'vocab' => [
                            'blood specimens' => [
                                'id' => 'sampel darah',
                                'pos' => '(n plural)',
                            ],
                            'analyzed' => [
                                'id' => 'dianalisis',
                                'pos' => '(v3)',
                            ],
                            'automated spectrometers' => [
                                'id' => 'spektrometer otomatis',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Patient blood specimens are analyzed in certified clinical laboratories using automated high-throughput spectrometers.',
                            'Patient blood specimens analyze in certified clinical laboratories using automated high-throughput spectrometers.',
                            'Patient blood specimens is analyzed in certified clinical laboratories using automated high-throughput spectrometers.',
                            'Patient blood specimens are analyze in certified clinical laboratories using automated high-throughput spectrometers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek penerima aksi adalah \'Patient blood specimens\' (jamak). Bentuk pasif Simple Present yang benar adalah \'are analyzed\' (to be \'are\' + Verb 3).',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Parameter kualitas air dipantau setiap hari di sepanjang aliran sungai industri.',
                        'target_word' => 'are monitored (Passive Verb)',
                        'vocab' => [
                            'water quality parameters' => [
                                'id' => 'parameter kualitas air',
                                'pos' => '(n plural)',
                            ],
                            'monitored' => [
                                'id' => 'dipantau',
                                'pos' => '(v3)',
                            ],
                            'industrial water basin' => [
                                'id' => 'aliran sungai industri',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Ecological water quality parameters are monitored on a daily schedule throughout the municipal river basin.',
                            'Ecological water quality parameters monitor on a daily schedule throughout the municipal river basin.',
                            'Ecological water quality parameters is monitored on a daily schedule throughout the municipal river basin.',
                            'Ecological water quality parameters are monitor on a daily schedule throughout the municipal river basin.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Parameters\' adalah kata benda jamak. Kalimat pasif membutuhkan \'are monitored\'.',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Laporan keuangan tahunan diaudit oleh akuntan publik independen sebelum diserahkan kepada pemegang saham.',
                        'target_word' => 'are audited (Passive Verb)',
                        'vocab' => [
                            'annual financial statements' => [
                                'id' => 'laporan keuangan tahunan',
                                'pos' => '(n plural)',
                            ],
                            'audited' => [
                                'id' => 'diaudit',
                                'pos' => '(v3)',
                            ],
                            'independent certified accountants' => [
                                'id' => 'akuntan bersertifikat independen',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Comprehensive annual balance sheets are audited by accredited statutory accountants prior to shareholder circulation.',
                            'Comprehensive annual balance sheets audit by accredited statutory accountants prior to shareholder circulation.',
                            'Comprehensive annual balance sheets is audited by accredited statutory accountants prior to shareholder circulation.',
                            'Comprehensive annual balance sheets are audit by accredited statutory accountants prior to shareholder circulation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Comprehensive annual balance sheets\' adalah subjek jamak. Bentuk pasif yang benar adalah \'are audited\'.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Subjek-subjek uji klinis diperiksa kesehatannya secara menyeluruh sebelum pemberian obat.',
                        'target_word' => 'are examined (Passive Verb)',
                        'vocab' => [
                            'clinical trial participants' => [
                                'id' => 'peserta uji klinis',
                                'pos' => '(n plural)',
                            ],
                            'examined thoroughly' => [
                                'id' => 'diperiksa menyeluruh',
                                'pos' => '(v3 phr)',
                            ],
                            'drug administration' => [
                                'id' => 'pemberian obat',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Prospective trial participants are examined thoroughly by licensed physicians before investigational drug dosing.',
                            'Prospective trial participants examine thoroughly by licensed physicians before investigational drug dosing.',
                            'Prospective trial participants is examined thoroughly by licensed physicians before investigational drug dosing.',
                            'Prospective trial participants are examine thoroughly by licensed physicians before investigational drug dosing.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'participants\' berpasangan dengan auxiliary pasif \'are\' dan Verb 3 \'examined\'.',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Seluruh transaksi perbankan internasional dicatat dan diverifikasi melalui sistem buku besar terdesentralisasi.',
                        'target_word' => 'are recorded (Passive Verb)',
                        'vocab' => [
                            'international transactions' => [
                                'id' => 'transaksi internasional',
                                'pos' => '(n plural)',
                            ],
                            'recorded and verified' => [
                                'id' => 'dicatat dan diverifikasi',
                                'pos' => '(v3)',
                            ],
                            'decentralized ledger' => [
                                'id' => 'buku besar terdesentralisasi',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Cross-border interbank settlements are recorded and validated automatically via encrypted ledger protocols.',
                            'Cross-border interbank settlements record and validate automatically via encrypted ledger protocols.',
                            'Cross-border interbank settlements is recorded and validated automatically via encrypted ledger protocols.',
                            'Cross-border interbank settlements are record and validate automatically via encrypted ledger protocols.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'settlements\' (jamak) dikenai tindakan, sehingga membutuhkan \'are recorded and validated\'.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Spesies serangga invasif sering kali ditemukan di dalam kargo pelabuhan yang belum diperiksa.',
                        'target_word' => 'are discovered (Passive Verb)',
                        'vocab' => [
                            'invasive insect species' => [
                                'id' => 'spesies serangga invasif (jamak)',
                                'pos' => '(n plural)',
                            ],
                            'discovered' => [
                                'id' => 'ditemukan',
                                'pos' => '(v3)',
                            ],
                            'uninspected freight' => [
                                'id' => 'kargo belum diperiksa',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Invasive insect species are frequently discovered hidden within non-fumigated maritime freight containers.',
                            'Invasive insect species frequently discover hidden within non-fumigated maritime freight containers.',
                            'Invasive insect species is frequently discovered hidden within non-fumigated maritime freight containers.',
                            'Invasive insect species are frequently discover hidden within non-fumigated maritime freight containers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Konteks kalimat merujuk pada banyak spesies yang ditemukan (\'species\' sebagai jamak). Bentuk pasif yang benar adalah \'are frequently discovered\'.',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Survei kepuasan pelanggan dikirimkan secara otomatis setiap kali transaksi layanan selesai.',
                        'target_word' => 'are dispatched (Passive Verb)',
                        'vocab' => [
                            'feedback questionnaires' => [
                                'id' => 'kuesioner umpan balik',
                                'pos' => '(n plural)',
                            ],
                            'dispatched' => [
                                'id' => 'dikirimkan',
                                'pos' => '(v3)',
                            ],
                            'transaction completion' => [
                                'id' => 'penyelesaian transaksi',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Automated feedback questionnaires are dispatched electronically following the resolution of each consumer inquiry.',
                            'Automated feedback questionnaires dispatch electronically following the resolution of each consumer inquiry.',
                            'Automated feedback questionnaires is dispatched electronically following the resolution of each consumer inquiry.',
                            'Automated feedback questionnaires are dispatch electronically following the resolution of each consumer inquiry.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Questionnaires\' adalah jamak. Bentuk pasif Simple Present yang tepat adalah \'are dispatched\'.',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Data sensus kependudukan dievaluasi ulang oleh badan statistik nasional setiap lima tahun sekali.',
                        'target_word' => 'are reappraised (Passive Verb)',
                        'vocab' => [
                            'demographic census records' => [
                                'id' => 'catatan sensus demografi',
                                'pos' => '(n plural)',
                            ],
                            'reappraised' => [
                                'id' => 'dievaluasi ulang',
                                'pos' => '(v3)',
                            ],
                            'national statistical agency' => [
                                'id' => 'badan statistik nasional',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Comprehensive demographic census records are reappraised by the central statistical institute quinquennially.',
                            'Comprehensive demographic census records reappraise by the central statistical institute quinquennially.',
                            'Comprehensive demographic census records is reappraised by the central statistical institute quinquennially.',
                            'Comprehensive demographic census records are reappraise by the central statistical institute quinquennially.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Census records\' adalah plural noun. Bentuk pasif baku adalah \'are reappraised\'.',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Peraturan lingkungan hidup yang baru ini dipatuhi secara ketat oleh seluruh perusahaan manufaktur.',
                        'target_word' => 'are observed (Passive Verb)',
                        'vocab' => [
                            'environmental regulations' => [
                                'id' => 'peraturan lingkungan',
                                'pos' => '(n plural)',
                            ],
                            'observed / complied with' => [
                                'id' => 'dipatuhi',
                                'pos' => '(v3)',
                            ],
                            'manufacturing enterprises' => [
                                'id' => 'perusahaan manufaktur',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Stricter environmental guidelines are rigorously observed by heavy industrial manufacturers nationwide.',
                            'Stricter environmental guidelines rigorously observe by heavy industrial manufacturers nationwide.',
                            'Stricter environmental guidelines is rigorously observed by heavy industrial manufacturers nationwide.',
                            'Stricter environmental guidelines are rigorously observe by heavy industrial manufacturers nationwide.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek kalimat adalah \'guidelines\' (jamak). Kalimat pasif membutuhkan \'are observed\'.',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Para kandidat peneliti diberitahu tentang hasil seleksi tahap pertama melalui surat elektronik resmi.',
                        'target_word' => 'are notified (Passive Verb)',
                        'vocab' => [
                            'fellowship candidates' => [
                                'id' => 'kandidat peneliti',
                                'pos' => '(n plural)',
                            ],
                            'notified' => [
                                'id' => 'diberitahu / dinotifikasi',
                                'pos' => '(v3)',
                            ],
                            'electronic correspondence' => [
                                'id' => 'surat elektronik',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Shortlisted fellowship applicants are formally notified of initial assessment outcomes via encrypted email.',
                            'Shortlisted fellowship applicants formally notify of initial assessment outcomes via encrypted email.',
                            'Shortlisted fellowship applicants is formally notified of initial assessment outcomes via encrypted email.',
                            'Shortlisted fellowship applicants are formally notify of initial assessment outcomes via encrypted email.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Shortlisted fellowship applicants\' adalah subjek jamak. Bentuk pasif yang benar adalah \'are formally notified\'.',
                    ],
                ],
            ],
[
                'id' => 'passive-singular',
                'name' => 'Simple Present Passive: Subjek Tunggal & Uncountable (+ is + V3)',
                'code' => '1.3.5',
                'concept_title' => 'Kalimat Pasif Simple Present untuk Subjek Tunggal & Uncountable Nouns (is + V3)',
                'concept_description' => 'Ketika subjek yang dikenai tindakan berupa benda tunggal (a sample, the theory, a patient) atau kata benda tak dapat dihitung (data, water, waste, energy, evidence), kalimat pasif Simple Present menggunakan rumus: Subjek Tunggal/Uncountable + IS + Verb 3 (Past Participle).',
                'formula' => 'Subject (Singular & Uncountable Nouns / He / She / It) + IS + Verb 3 (Past Participle) (+ by Agent)',
                'rules' => [
                    'Subjek tunggal dan benda tak dapat dihitung wajib berpasangan dengan \'is + V3\'.',
                    'Uncountable nouns seperti \'energy\', \'waste\', \'information\' selalu mengambil \'is + V3\'.',
                    'Pastikan kata kerja berada dalam bentuk Past Participle (e.g., \'is collected\', \'is demonstrated\', \'is required\').',
                    'Dilarang menggabungkan \'is\' dengan Verb 1 dasar (e.g., \'is collect\' adalah salah besar).',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Data primer dikumpulkan melalui kuesioner terstruktur dan wawancara mendalam.',
                        'target_word' => 'is collected (Passive Verb)',
                        'vocab' => [
                            'primary empirical data' => [
                                'id' => 'data primer empiris',
                                'pos' => '(n uncountable)',
                            ],
                            'collected' => [
                                'id' => 'dikumpulkan',
                                'pos' => '(v3)',
                            ],
                            'structured surveys' => [
                                'id' => 'survei terstruktur',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Primary field data is systematically collected via standardized psychometric surveys and field observations.',
                            'Primary field data systematically collect via standardized psychometric surveys and field observations.',
                            'Primary field data are systematically collected via standardized psychometric surveys and field observations.',
                            'Primary field data is systematically collect via standardized psychometric surveys and field observations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bila \'data\' diperlakukan sebagai entitas himpunan tunggal (mass noun dalam general academic context) atau subjek tunggal, bentuk pasifnya adalah \'is collected\' (is + Verb 3).',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Setiap proposal penelitian ditinjau secara ketat oleh dewan peninjau etik independen.',
                        'target_word' => 'is reviewed (Passive Verb)',
                        'vocab' => [
                            'research proposal' => [
                                'id' => 'proposal penelitian',
                                'pos' => '(n singular)',
                            ],
                            'reviewed' => [
                                'id' => 'ditinjau / direview',
                                'pos' => '(v3)',
                            ],
                            'ethics board' => [
                                'id' => 'dewan etik',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Each submitted research protocol is thoroughly reviewed by an autonomous institutional review board.',
                            'Each submitted research protocol thoroughly review by an autonomous institutional review board.',
                            'Each submitted research protocol are thoroughly reviewed by an autonomous institutional review board.',
                            'Each submitted research protocol is thoroughly review by an autonomous institutional review board.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Each submitted research protocol\' adalah subjek tunggal. Bentuk pasif yang benar adalah \'is thoroughly reviewed\'.',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Energi surya diubah menjadi arus listrik bolak-balik oleh modul inverter terpusat.',
                        'target_word' => 'is converted (Passive Verb)',
                        'vocab' => [
                            'solar photovoltaic energy' => [
                                'id' => 'energi fotovoltaik surya',
                                'pos' => '(n uncountable)',
                            ],
                            'converted into' => [
                                'id' => 'diubah menjadi',
                                'pos' => '(v3 phr)',
                            ],
                            'alternating current' => [
                                'id' => 'arus listrik bolak-balik',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Direct solar radiation is converted into usable alternating current electricity by central grid inverters.',
                            'Direct solar radiation convert into usable alternating current electricity by central grid inverters.',
                            'Direct solar radiation are converted into usable alternating current electricity by central grid inverters.',
                            'Direct solar radiation is convert into usable alternating current electricity by central grid inverters.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Solar radiation\' adalah uncountable noun (tunggal). Bentuk pasif yang tepat adalah \'is converted\'.',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Limbah kimia beracun dinetralkan dengan larutan basa sebelum dialirkan ke sistem pengolahan.',
                        'target_word' => 'is neutralized (Passive Verb)',
                        'vocab' => [
                            'toxic chemical effluent' => [
                                'id' => 'limbah kimia beracun',
                                'pos' => '(n uncountable)',
                            ],
                            'neutralized' => [
                                'id' => 'dinetralkan',
                                'pos' => '(v3)',
                            ],
                            'alkaline reagents' => [
                                'id' => 'larutan basa',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Highly toxic acidic effluent is neutralized with specialized alkaline buffers prior to filtration discharge.',
                            'Highly toxic acidic effluent neutralize with specialized alkaline buffers prior to filtration discharge.',
                            'Highly toxic acidic effluent are neutralized with specialized alkaline buffers prior to filtration discharge.',
                            'Highly toxic acidic effluent is neutralize with specialized alkaline buffers prior to filtration discharge.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Acidic effluent\' (limbah cair) adalah uncountable noun. Bentuk pasif yang selaras adalah \'is neutralized\'.',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Kebijakan fiskal baru ini dirancang untuk menstabilkan pasar obligasi negara yang bergejolak.',
                        'target_word' => 'is designed (Passive Verb)',
                        'vocab' => [
                            'fiscal policy' => [
                                'id' => 'kebijakan fiskal',
                                'pos' => '(n singular)',
                            ],
                            'designed to' => [
                                'id' => 'dirancang untuk',
                                'pos' => '(v3 phr)',
                            ],
                            'sovereign bond markets' => [
                                'id' => 'pasar obligasi negara',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The new macroeconomic fiscal policy is expressly designed to stabilize turbulent sovereign bond auctions.',
                            'The new macroeconomic fiscal policy expressly design to stabilize turbulent sovereign bond auctions.',
                            'The new macroeconomic fiscal policy are expressly designed to stabilize turbulent sovereign bond auctions.',
                            'The new macroeconomic fiscal policy is expressly design to stabilize turbulent sovereign bond auctions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The new macroeconomic fiscal policy\' adalah subjek tunggal. Bentuk pasif yang benar adalah \'is expressly designed\'.',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Kekayaan intelektual dilindungi secara hukum oleh undang-undang paten nasional dan traktat internasional.',
                        'target_word' => 'is protected (Passive Verb)',
                        'vocab' => [
                            'intellectual property' => [
                                'id' => 'kekayaan intelektual',
                                'pos' => '(n uncountable)',
                            ],
                            'protected' => [
                                'id' => 'dilindungi',
                                'pos' => '(v3)',
                            ],
                            'patent statutes' => [
                                'id' => 'undang-undang paten',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Proprietary technical know-how is legally protected under domestic patent statutes and multinational accords.',
                            'Proprietary technical know-how legally protect under domestic patent statutes and multinational accords.',
                            'Proprietary technical know-how are legally protected under domestic patent statutes and multinational accords.',
                            'Proprietary technical know-how is legally protect under domestic patent statutes and multinational accords.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Technical know-how\' (pengetahuan/kekayaan intelektual) adalah uncountable. Bentuk pasif adalah \'is legally protected\'.',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Tingkat keparahan penyakit ini dinilai berdasarkan kriteria diagnostik klinis yang terstandarisasi.',
                        'target_word' => 'is assessed (Passive Verb)',
                        'vocab' => [
                            'severity of the disorder' => [
                                'id' => 'tingkat keparahan penyakit',
                                'pos' => '(n singular)',
                            ],
                            'assessed' => [
                                'id' => 'dinilai / dievaluasi',
                                'pos' => '(v3)',
                            ],
                            'clinical diagnostic scales' => [
                                'id' => 'skala diagnostik klinis',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Pathological symptom severity is assessed using standardized psychometric diagnostic grading matrices.',
                            'Pathological symptom severity assess using standardized psychometric diagnostic grading matrices.',
                            'Pathological symptom severity are assessed using standardized psychometric diagnostic grading matrices.',
                            'Pathological symptom severity is assess using standardized psychometric diagnostic grading matrices.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun kalimat adalah \'severity\' (tunggal/uncountable). Predikat pasif yang tepat adalah \'is assessed\'.',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Informasi genetik disimpan di dalam rantai molekul DNA dari setiap sel hidup.',
                        'target_word' => 'is stored (Passive Verb)',
                        'vocab' => [
                            'genetic information' => [
                                'id' => 'informasi genetik',
                                'pos' => '(n uncountable)',
                            ],
                            'stored in' => [
                                'id' => 'disimpan di dalam',
                                'pos' => '(v3 phr)',
                            ],
                            'deoxyribonucleic acid strands' => [
                                'id' => 'untaian molekul DNA',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Crucial genetic information is securely stored within the molecular architecture of double-stranded DNA.',
                            'Crucial genetic information securely store within the molecular architecture of double-stranded DNA.',
                            'Crucial genetic information are securely stored within the molecular architecture of double-stranded DNA.',
                            'Crucial genetic information is securely store within the molecular architecture of double-stranded DNA.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Information\' adalah uncountable noun (tunggal). Kalimat pasif yang benar adalah \'is securely stored\'.',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Sebuah model simulasi iklim baru dijalankan pada superkomputer universitas untuk memproyeksikan curah hujan.',
                        'target_word' => 'is executed (Passive Verb)',
                        'vocab' => [
                            'climate simulation model' => [
                                'id' => 'model simulasi iklim',
                                'pos' => '(n singular)',
                            ],
                            'executed / deployed' => [
                                'id' => 'dijalankan',
                                'pos' => '(v3)',
                            ],
                            'university supercomputers' => [
                                'id' => 'superkomputer universitas',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'A high-resolution climatological model is executed on academic supercomputing clusters to forecast precipitation.',
                            'A high-resolution climatological model execute on academic supercomputing clusters to forecast precipitation.',
                            'A high-resolution climatological model are executed on academic supercomputing clusters to forecast precipitation.',
                            'A high-resolution climatological model is execute on academic supercomputing clusters to forecast precipitation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'A ... climatological model\' adalah kata benda tunggal. Bentuk pasif yang benar adalah \'is executed\'.',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Kandungan protein dari pakan ternak diuji secara berkala oleh teknisi kendali mutu.',
                        'target_word' => 'is tested (Passive Verb)',
                        'vocab' => [
                            'crude protein concentration' => [
                                'id' => 'konsentrasi protein kasar',
                                'pos' => '(n uncountable)',
                            ],
                            'tested periodically' => [
                                'id' => 'diuji secara berkala',
                                'pos' => '(v3 phr)',
                            ],
                            'quality assurance technicians' => [
                                'id' => 'teknisi kendali mutu',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Crude protein content in commercial feedstocks is tested routinely by certified quality assurance specialists.',
                            'Crude protein content in commercial feedstocks test routinely by certified quality assurance specialists.',
                            'Crude protein content in commercial feedstocks are tested routinely by certified quality assurance specialists.',
                            'Crude protein content in commercial feedstocks is test routinely by certified quality assurance specialists.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun adalah \'Crude protein content\' (tunggal/uncountable). Predikat pasif yang benar adalah \'is tested\'.',
                    ],
                ],
            ],
[
                'id' => 'passive-negative-interrogative',
                'name' => 'Simple Present Passive: Bentuk Negatif & Interogatif (is/are not + V3 & Is/Are... V3?)',
                'code' => '1.3.6',
                'concept_title' => 'Bentuk Negasi dan Kalimat Tanya pada Kalimat Pasif Simple Present',
                'concept_description' => 'Kalimat pasif negatif dibentuk dengan menyisipkan \'not\' tepat di antara to be dan Verb 3 (is not / are not + Past Participle). DILARANG menggunakan do/does not pada kalimat pasif. Untuk kalimat tanya pasif, pindahkan to be (Is atau Are) ke depan subjek penerima aksi, diikuti Verb 3.',
                'formula' => 'Negatif: S + is / are + not + Verb 3 | Tanya: (WH) + Is / Are + S + Verb 3?',
                'rules' => [
                    'Bentuk pasif negatif: \'is not + V3\' (tunggal) atau \'are not + V3\' (jamak).',
                    'Jangan pernah menulis \'does not analyzed\' atau \'do not collected\' (kesalahan fatal campur aduk auxiliary).',
                    'Kalimat tanya pasif: \'Is the data verified?\' atau \'Are the samples inspected?\'.',
                    'Subjek tetap diletakkan di antara to be dan Verb 3 pada kalimat tanya.',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Limbah kimia berbahaya tidak dibuang langsung ke saluran pembuangan air kota.',
                        'target_word' => 'is not discharged (Negative Passive)',
                        'vocab' => [
                            'hazardous industrial waste' => [
                                'id' => 'limbah industri berbahaya',
                                'pos' => '(n uncountable)',
                            ],
                            'discharged directly' => [
                                'id' => 'dibuang langsung',
                                'pos' => '(v3 phr)',
                            ],
                            'municipal drainage' => [
                                'id' => 'saluran air kota',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Hazardous industrial solvent waste is not discharged directly into municipal sewer arteries.',
                            'Hazardous industrial solvent waste does not discharged directly into municipal sewer arteries.',
                            'Hazardous industrial solvent waste are not discharged directly into municipal sewer arteries.',
                            'Hazardous industrial solvent waste is not discharge directly into municipal sewer arteries.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Waste\' adalah uncountable noun (tunggal). Kalimat pasif negatif yang benar menggunakan to be \'is not\' + Verb 3: \'is not discharged\'.',
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Akses tanpa izin ke server pangkalan data rahasia tidak diizinkan dalam kondisi apa pun.',
                        'target_word' => 'is not permitted (Negative Passive)',
                        'vocab' => [
                            'unauthorized remote access' => [
                                'id' => 'akses jarak jauh tanpa izin',
                                'pos' => '(n uncountable)',
                            ],
                            'permitted' => [
                                'id' => 'diizinkan',
                                'pos' => '(v3)',
                            ],
                            'circumstances' => [
                                'id' => 'kondisi / keadaan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Unauthorized remote access to classified government servers is not permitted under any operational condition.',
                            'Unauthorized remote access to classified government servers does not permitted under any operational condition.',
                            'Unauthorized remote access to classified government servers are not permitted under any operational condition.',
                            'Unauthorized remote access to classified government servers is not permit under any operational condition.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Unauthorized remote access\' adalah kata benda tunggal. Bentuk pasif negatif yang tepat adalah \'is not permitted\'.',
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Apakah uji klinis tersebut dilakukan sesuai dengan pedoman keselamatan internasional?',
                        'target_word' => 'Are ... conducted (Passive Question)',
                        'vocab' => [
                            'clinical drug evaluations' => [
                                'id' => 'evaluasi obat klinis',
                                'pos' => '(n plural)',
                            ],
                            'conducted in accordance with' => [
                                'id' => 'dilakukan sesuai dengan',
                                'pos' => '(v3 phr)',
                            ],
                            'safety guidelines' => [
                                'id' => 'pedoman keselamatan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Are multi-center clinical evaluations conducted in strict accordance with World Health Organization guidelines?',
                            'Do multi-center clinical evaluations conducted in strict accordance with World Health Organization guidelines?',
                            'Is multi-center clinical evaluations conducted in strict accordance with World Health Organization guidelines?',
                            'Does multi-center clinical evaluations conducted in strict accordance with World Health Organization guidelines?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek kalimat adalah \'multi-center clinical evaluations\' (jamak). Kalimat tanya pasif diawali to be \'Are\', diikuti subjek, dan diakhiri Verb 3 \'conducted\'.',
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Apakah keakuratan model prediksi cuaca diverifikasi oleh stasiun meteorologi independen?',
                        'target_word' => 'Is ... verified (Passive Question)',
                        'vocab' => [
                            'predictive accuracy' => [
                                'id' => 'keakuratan prediksi',
                                'pos' => '(n uncountable/singular)',
                            ],
                            'verified by' => [
                                'id' => 'diverifikasi oleh',
                                'pos' => '(v3 phr)',
                            ],
                            'meteorological observatories' => [
                                'id' => 'stasiun pengamatan meteorologi',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Is the predictive accuracy of the barometric model verified independently by regional weather observatories?',
                            'Does the predictive accuracy of the barometric model verified independently by regional weather observatories?',
                            'Are the predictive accuracy of the barometric model verified independently by regional weather observatories?',
                            'Do the predictive accuracy of the barometric model verified independently by regional weather observatories?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun adalah \'the predictive accuracy\' (tunggal). Kalimat tanya pasif Simple Present diawali \'Is\' + Subject + \'verified\'.',
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Data pribadi para partisipan survei tidak dibagikan kepada pihak ketiga untuk kepentingan komersial.',
                        'target_word' => 'are not shared (Negative Passive)',
                        'vocab' => [
                            'personally identifiable data' => [
                                'id' => 'data yang dapat mengidentifikasi pribadi',
                                'pos' => '(n plural)',
                            ],
                            'shared with third parties' => [
                                'id' => 'dibagikan ke pihak ketiga',
                                'pos' => '(v3 phr)',
                            ],
                            'commercial monetization' => [
                                'id' => 'monetisasi komersial',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Personally identifiable participant records are not shared with third-party vendors for commercial monetization.',
                            'Personally identifiable participant records do not shared with third-party vendors for commercial monetization.',
                            'Personally identifiable participant records is not shared with third-party vendors for commercial monetization.',
                            'Personally identifiable participant records are not share with third-party vendors for commercial monetization.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Participant records\' adalah subjek jamak. Bentuk pasif negatif yang benar adalah \'are not shared\'.',
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Bagaimana data satelit mentah diproses sebelum ditampilkan pada platform pemantau kebakaran hutan?',
                        'target_word' => 'is ... processed (WH Passive Question)',
                        'vocab' => [
                            'raw satellite imagery telemetry' => [
                                'id' => 'telemetri citra satelit mentah',
                                'pos' => '(n uncountable)',
                            ],
                            'processed' => [
                                'id' => 'diproses',
                                'pos' => '(v3)',
                            ],
                            'wildfire monitoring dashboard' => [
                                'id' => 'dasbor pemantau kebakaran hutan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'How is raw satellite telemetry processed prior to visualization on the interactive wildfire dashboard?',
                            'How does raw satellite telemetry processed prior to visualization on the interactive wildfire dashboard?',
                            'How are raw satellite telemetry processed prior to visualization on the interactive wildfire dashboard?',
                            'How do raw satellite telemetry processed prior to visualization on the interactive wildfire dashboard?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjeknya adalah \'raw satellite telemetry\' (uncountable/tunggal). Urutan kalimat tanya pasif adalah WH (\'How\') + to be (\'is\') + Subject + Verb 3 (\'processed\').',
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Spesimen fosil langka tersebut tidak dipamerkan di galeri publik demi menjaga keutuhannya.',
                        'target_word' => 'is not exhibited (Negative Passive)',
                        'vocab' => [
                            'fossil specimen' => [
                                'id' => 'spesimen fosil',
                                'pos' => '(n singular)',
                            ],
                            'exhibited' => [
                                'id' => 'dipamerkan',
                                'pos' => '(v3)',
                            ],
                            'preservation purposes' => [
                                'id' => 'tujuan pelestarian',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The holotypic avian fossil specimen is not exhibited in public exhibition halls for conservation safeguards.',
                            'The holotypic avian fossil specimen does not exhibited in public exhibition halls for conservation safeguards.',
                            'The holotypic avian fossil specimen are not exhibited in public exhibition halls for conservation safeguards.',
                            'The holotypic avian fossil specimen is not exhibit in public exhibition halls for conservation safeguards.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek adalah benda tunggal \'The ... specimen\'. Bentuk pasif negatif adalah \'is not exhibited\'.',
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Di mana sampel sedimen laut dalam disimpan setelah ekspedisi oseanografi selesai?',
                        'target_word' => 'are ... archived (WH Passive Question)',
                        'vocab' => [
                            'deep-sea sediment cores' => [
                                'id' => 'inti sedimen laut dalam',
                                'pos' => '(n plural)',
                            ],
                            'archived / stored' => [
                                'id' => 'disimpan / diarsipkan',
                                'pos' => '(v3)',
                            ],
                            'oceanographic expedition' => [
                                'id' => 'ekspedisi oseanografi',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Where are deep-sea sedimentary drill cores curated upon completion of maritime survey cruises?',
                            'Where do deep-sea sedimentary drill cores curated upon completion of maritime survey cruises?',
                            'Where is deep-sea sedimentary drill cores curated upon completion of maritime survey cruises?',
                            'Where does deep-sea sedimentary drill cores curated upon completion of maritime survey cruises?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek kalimat adalah \'drill cores\' (jamak). Kalimat tanya pasif diawali \'Where are\' + Subject + \'curated\'.',
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Artikel penelitian ini tidak dipublikasikan secara daring sampai proses peninjauan sejawat selesai.',
                        'target_word' => 'is not published (Negative Passive)',
                        'vocab' => [
                            'research article' => [
                                'id' => 'artikel penelitian',
                                'pos' => '(n singular)',
                            ],
                            'published online' => [
                                'id' => 'dipublikasikan secara daring',
                                'pos' => '(v3 phr)',
                            ],
                            'peer review process' => [
                                'id' => 'proses peninjauan sejawat',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The peer-reviewed investigation is not published online until all editorial revisions are formally signed off.',
                            'The peer-reviewed investigation does not published online until all editorial revisions are formally signed off.',
                            'The peer-reviewed investigation are not published online until all editorial revisions are formally signed off.',
                            'The peer-reviewed investigation is not publish online until all editorial revisions are formally signed off.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The ... investigation\' adalah tunggal. Bentuk pasif negatif Simple Present adalah \'is not published\'.',
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah variabel perancu dikontrol secara memadai dalam analisis regresi statistik tersebut?',
                        'target_word' => 'Are ... controlled (Passive Question)',
                        'vocab' => [
                            'confounding variables' => [
                                'id' => 'variabel perancu',
                                'pos' => '(n plural)',
                            ],
                            'adequately controlled' => [
                                'id' => 'dikontrol secara memadai',
                                'pos' => '(v3 phr)',
                            ],
                            'regression analysis' => [
                                'id' => 'analisis regresi',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Are potential confounding sociodemographic variables adequately controlled for in the regression models?',
                            'Do potential confounding sociodemographic variables adequately controlled for in the regression models?',
                            'Is potential confounding sociodemographic variables adequately controlled for in the regression models?',
                            'Does potential confounding sociodemographic variables adequately controlled for in the regression models?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjeknya adalah \'confounding ... variables\' (jamak). Kalimat tanya pasif diawali to be \'Are\', diikuti subjek dan Verb 3 \'controlled\'.',
                    ],
                ],
            ],
[
                'id' => 'verbal-vs-nominal',
                'name' => 'Verbal vs Nominal: Membedakan Aksi vs Status & Eliminasi Double Predicate',
                'code' => '1.3.7',
                'concept_title' => 'Membedakan Kalimat Verbal vs Nominal dan Menghapus Double Predicate',
                'concept_description' => 'Kunci utama ketepatan tata bahasa Inggris adalah membedakan kapan menggunakan Kalimat Verbal murni (Aksi: Subjek + V1 TANPA to be) dan kapan menggunakan Kalimat Nominal (Status/Sifat: Subjek + to be + Adjective/Noun). Kesalahan penutur Indonesia paling umum adalah: (1) Menyisipkan \'is/are\' sebelum kata kerja aksi (e.g., \'The theory is explains\' -> SALAH), atau (2) Menghilangkan to be sebelum kata sifat (e.g., \'The system effective\' -> SALAH).',
                'formula' => 'Verbal: Subject + Verb 1 (-s/-es) [DILARANG ADA TO BE] vs Nominal: Subject + to be + Adj / Noun [WAJIB TO BE]',
                'rules' => [
                    'Jika kata kerja inti adalah AKSI (demonstrate, investigate, increase, correlate) ➔ GUNAKAN VERBAL MURNI (jangan tambahkan is/am/are).',
                    'Jika kata berikutnya adalah KATA SIFAT (effective, significant, essential, viable) ➔ GUNAKAN NOMINAL (wajib tambahkan is/am/are).',
                    'Waspadai kata kerja pelapor akademis (explain, provide, show): selalu berbentuk verbal \'The study explains\', bukan \'The study is explains\'.',
                    'Bentuk negatif verbal memakai \'do/does not + V1\'; bentuk negatif nominal memakai \'is/are not + Adjective\'.',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Penelitian ilmiah baru ini membuktikan bahwa mikroplastik menumpuk di dalam jaringan organisme laut.',
                        'target_word' => 'proves (Verbal Verb)',
                        'vocab' => [
                            'empirical inquiry' => [
                                'id' => 'penelitian empiris',
                                'pos' => '(n singular)',
                            ],
                            'proves' => [
                                'id' => 'membuktikan (aksi kognitif)',
                                'pos' => '(v)',
                            ],
                            'microplastics accumulate' => [
                                'id' => 'mikroplastik menumpuk',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'This new empirical inquiry proves that microplastic particles accumulate within benthic marine organisms.',
                            'This new empirical inquiry is proves that microplastic particles accumulate within benthic marine organisms.',
                            'This new empirical inquiry is prove that microplastic particles accumulate within benthic marine organisms.',
                            'This new empirical inquiry proving that microplastic particles accumulate within benthic marine organisms.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat ini adalah Kalimat Verbal murni dengan predikat aksi kognitif \'proves\' (subjek tunggal \'inquiry\'). DILARANG menyisipkan to be \'is\' (\'is proves\' adalah double predicate).',
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Protokol keamanan hayati yang baru ini sangat efektif dalam mencegah penularan patogen di rumah sakit.',
                        'target_word' => 'is effective (Nominal Predicate)',
                        'vocab' => [
                            'biosecurity protocol' => [
                                'id' => 'protokol keamanan hayati',
                                'pos' => '(n singular)',
                            ],
                            'effective in' => [
                                'id' => 'efektif dalam (kata sifat)',
                                'pos' => '(adj phr)',
                            ],
                            'pathogen transmission' => [
                                'id' => 'penularan patogen',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'This updated hospital biosecurity protocol is highly effective in curbing nosocomial transmission.',
                            'This updated hospital biosecurity protocol highly effective in curbing nosocomial transmission.',
                            'This updated hospital biosecurity protocol does highly effective in curbing nosocomial transmission.',
                            'This updated hospital biosecurity protocol is effect in curbing nosocomial transmission.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'effective\' adalah kata sifat (Adjective). Kalimat nominal WAJIB menyertakan to be \'is\' sebelum kata sifat. Menghilangkan \'is\' (\'protocol highly effective\') menghasilkan klausa tanpa verba.',
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Kerangka regulasi ini melindungi hak-hak konsumen dari manipulasi harga oleh platform e-commerce.',
                        'target_word' => 'protects (Verbal Verb)',
                        'vocab' => [
                            'regulatory framework' => [
                                'id' => 'kerangka regulasi',
                                'pos' => '(n singular)',
                            ],
                            'protects' => [
                                'id' => 'melindungi (aksi)',
                                'pos' => '(v)',
                            ],
                            'consumer entitlements' => [
                                'id' => 'hak-hak konsumen',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The comprehensive consumer framework protects individual purchasers from algorithmic price manipulation.',
                            'The comprehensive consumer framework is protects individual purchasers from algorithmic price manipulation.',
                            'The comprehensive consumer framework is protect individual purchasers from algorithmic price manipulation.',
                            'The comprehensive consumer framework does protects individual purchasers from algorithmic price manipulation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Protects\' adalah kata kerja verbal aksi dengan subjek tunggal \'framework\'. Tidak boleh ada to be \'is\' sebelum kata kerja verbal.',
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Fasilitas pengolahan limbah industri tersebut mematuhi seluruh baku mutu lingkungan hidup nasional.',
                        'target_word' => 'complies with (Verbal Verb)',
                        'vocab' => [
                            'industrial treatment facility' => [
                                'id' => 'fasilitas pengolahan industri',
                                'pos' => '(n singular)',
                            ],
                            'complies with' => [
                                'id' => 'mematuhi (aksi)',
                                'pos' => '(v)',
                            ],
                            'environmental standards' => [
                                'id' => 'baku mutu lingkungan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The regional waste management facility complies strictly with all national effluent standards.',
                            'The regional waste management facility is complies strictly with all national effluent standards.',
                            'The regional waste management facility is comply strictly with all national effluent standards.',
                            'The regional waste management facility compliant strictly with all national effluent standards.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bila menggunakan kata kerja \'complies with\' (Verbal), dilarang menambahkan \'is\'. (Bila ingin nominal, gunakan \'is compliant with\'). Opsi \'complies strictly\' adalah bentuk verbal baku.',
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Studi komparatif ini relevan secara langsung dengan perdebatan mengenai reformasi perpajakan daerah.',
                        'target_word' => 'is relevant (Nominal Predicate)',
                        'vocab' => [
                            'comparative study' => [
                                'id' => 'studi komparatif',
                                'pos' => '(n singular)',
                            ],
                            'relevant to' => [
                                'id' => 'relevan dengan (kata sifat)',
                                'pos' => '(adj phr)',
                            ],
                            'tax reform debates' => [
                                'id' => 'debat reformasi pajak',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'This comparative empirical inquiry is directly relevant to ongoing provincial taxation reform debates.',
                            'This comparative empirical inquiry directly relevant to ongoing provincial taxation reform debates.',
                            'This comparative empirical inquiry does directly relevant to ongoing provincial taxation reform debates.',
                            'This comparative empirical inquiry is relevancy to ongoing provincial taxation reform debates.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Relevant\' adalah kata sifat (Adjective). Kalimat nominal wajib menggunakan to be: \'is directly relevant\'.',
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Hasil eksperimen laboratorium tersebut menunjukkan korelasi positif yang kuat antara kedua variabel.',
                        'target_word' => 'indicate (Verbal Verb)',
                        'vocab' => [
                            'experimental outcomes' => [
                                'id' => 'hasil eksperimen',
                                'pos' => '(n plural)',
                            ],
                            'indicate' => [
                                'id' => 'menunjukkan (aksi pelaporan)',
                                'pos' => '(v)',
                            ],
                            'positive correlation' => [
                                'id' => 'korelasi positif',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The empirical laboratory outcomes indicate a robust positive correlation between both tested variables.',
                            'The empirical laboratory outcomes are indicate a robust positive correlation between both tested variables.',
                            'The empirical laboratory outcomes are indicating a robust positive correlation between both tested variables.',
                            'The empirical laboratory outcomes is indicate a robust positive correlation between both tested variables.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'outcomes\' melakukan aksi pelaporan verbal \'indicate\'. Dilarang menyisipkan \'are indicate\' (double predicate).',
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Metodologi penelitian yang dipilih oleh penulis tidak tepat untuk menjawab pertanyaan riset utama.',
                        'target_word' => 'is not appropriate (Negative Nominal)',
                        'vocab' => [
                            'methodology' => [
                                'id' => 'metodologi',
                                'pos' => '(n singular)',
                            ],
                            'appropriate for' => [
                                'id' => 'tepat / sesuai (kata sifat)',
                                'pos' => '(adj phr)',
                            ],
                            'primary research questions' => [
                                'id' => 'pertanyaan riset utama',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The qualitative methodology adopted by the author is not appropriate for addressing the core research question.',
                            'The qualitative methodology adopted by the author does not appropriate for addressing the core research question.',
                            'The qualitative methodology adopted by the author not appropriate for addressing the core research question.',
                            'The qualitative methodology adopted by the author is not appropriately for addressing the core research question.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'appropriate\' adalah kata sifat (Adjective). Kalimat nominal disangkal dengan \'is not appropriate\', BUKAN \'does not appropriate\'.',
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Penulis tidak menyetujui kesimpulan yang ditarik oleh kelompok peneliti sebelumnya.',
                        'target_word' => 'does not endorse (Negative Verbal)',
                        'vocab' => [
                            'the lead author' => [
                                'id' => 'penulis utama',
                                'pos' => '(n singular)',
                            ],
                            'endorse' => [
                                'id' => 'menyetujui / mengesahkan (aksi)',
                                'pos' => '(v)',
                            ],
                            'speculative deductions' => [
                                'id' => 'kesimpulan spekulatif',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The lead author does not endorse the speculative deductions proposed by the prior research consortium.',
                            'The lead author is not endorse the speculative deductions proposed by the prior research consortium.',
                            'The lead author not endorse the speculative deductions proposed by the prior research consortium.',
                            'The lead author does not endorses the speculative deductions proposed by the prior research consortium.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Endorse\' adalah kata kerja verbal aksi. Kalimat verbal dengan subjek tunggal dinegatifkan dengan \'does not endorse\', BUKAN \'is not endorse\'.',
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Data statistik ini penting untuk perumusan kebijakan subsidi energi hijau jangka panjang.',
                        'target_word' => 'are essential (Nominal Predicate)',
                        'vocab' => [
                            'statistical metrics' => [
                                'id' => 'metrik statistik',
                                'pos' => '(n plural)',
                            ],
                            'essential for' => [
                                'id' => 'penting bagi (kata sifat)',
                                'pos' => '(adj phr)',
                            ],
                            'energy policy formulation' => [
                                'id' => 'perumusan kebijakan energi',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'These longitudinal statistical metrics are essential for drafting durable clean energy subsidy frameworks.',
                            'These longitudinal statistical metrics essential for drafting durable clean energy subsidy frameworks.',
                            'These longitudinal statistical metrics do essential for drafting durable clean energy subsidy frameworks.',
                            'These longitudinal statistical metrics are essence for drafting durable clean energy subsidy frameworks.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Essential\' adalah kata sifat. Subjek jamak \'metrics\' wajib didampingi linking verb to be \'are\'.',
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Sistem peringatan dini bencana alam berfungsi tanpa gangguan teknis selama periode musim hujan ekstrem.',
                        'target_word' => 'operates (Verbal Verb)',
                        'vocab' => [
                            'early warning system' => [
                                'id' => 'sistem peringatan dini',
                                'pos' => '(n singular)',
                            ],
                            'operates' => [
                                'id' => 'berfungsi / beroperasi (aksi)',
                                'pos' => '(v)',
                            ],
                            'monsoon rainfall' => [
                                'id' => 'curah hujan muson',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The coastal early warning system operates without technical disruption throughout intense monsoon events.',
                            'The coastal early warning system is operates without technical disruption throughout intense monsoon events.',
                            'The coastal early warning system is operate without technical disruption throughout intense monsoon events.',
                            'The coastal early warning system operating without technical disruption throughout intense monsoon events.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Operates\' adalah finite action verb dengan subjek tunggal \'system\'. Dilarang menyisipkan \'is\' sebelum kata kerja dasar (\'is operates\' = salah double predicate).',
                    ],
                ],
            ],
[
                'id' => 'verbal-nominal-passive-synthesis',
                'name' => 'Verbal vs Nominal vs Passive: Komparasi Lengkap 3 Struktur Kalimat Akademik',
                'code' => '1.3.8',
                'concept_title' => 'Sintesis Komparatif: Membedakan Kalimat Verbal, Nominal, dan Pasif dalam Esai Formal',
                'concept_description' => 'Dalam penulisan ilmiah tingkat mahir (IELTS Band 8.0-9.0 & SAT), penulis harus mampu secara sadar memilih antara: (1) Kalimat Verbal untuk menonjolkan aksi aktif agen (e.g., \'The algorithm detects anomalies\'), (2) Kalimat Nominal untuk memberikan definisi atau status analitis (e.g., \'The algorithm is reliable\'), dan (3) Kalimat Pasif untuk menonjolkan prosedur atau perlakuan terhadap objek riset (e.g., \'The algorithm is deployed across cloud clusters\'). Sub-lesson ini menguji kemampuan Anda memilih dan menyusun ketiga struktur secara presisi tanpa salah bentuk.',
                'formula' => 'Verbal: S + V1 (-s/-es) | Nominal: S + is/are + Adj/Noun | Passive: S + is/are + V3',
                'rules' => [
                    'Tentukan fokus: Aksi Pelaku (Verbal), Sifat/Definisi (Nominal), atau Penerima Aksi (Pasif).',
                    'Ingat pembeda utama to be: Verbal = NO to be; Nominal = to be + Adj/Noun; Passive = to be + V3.',
                    'Jangan rancu antara Adjective pelengkap nominal dengan Past Participle pasif.',
                    'Gunakan variasi ketiga bentuk kalimat ini dalam satu paragraf untuk menghasilkan esai yang kaya dan dinamis.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Kecerdasan buatan menganalisis pola penyakit (Verbal), bersifat akurat (Nominal), dan diterapkan di rumah sakit (Pasif).',
                        'target_word' => 'analyzes | is accurate | is deployed',
                        'vocab' => [
                            'analyzes' => [
                                'id' => 'menganalisis (Verbal)',
                                'pos' => '(v)',
                            ],
                            'is accurate' => [
                                'id' => 'akurat (Nominal)',
                                'pos' => '(v+adj)',
                            ],
                            'is deployed' => [
                                'id' => 'diterapkan (Pasif)',
                                'pos' => '(v passive)',
                            ],
                        ],
                        'options' => [
                            'Artificial intelligence analyzes disease trajectories, is remarkably accurate, and is deployed across tertiary clinics.',
                            'Artificial intelligence is analyzes disease trajectories, is remarkably accurate, and deployed across tertiary clinics.',
                            'Artificial intelligence analyzes disease trajectories, accurate, and is deploy across tertiary clinics.',
                            'Artificial intelligence is analyzed disease trajectories, is remarkably accurate, and is deployed across tertiary clinics.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Sintesis sempurna: Klausa 1 Verbal (\'analyzes\' tanpa to be), Klausa 2 Nominal (\'is remarkably accurate\'), Klausa 3 Pasif (\'is deployed\' to be + V3).',
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Pemerintah memberlakukan undang-undang perpajakan baru untuk meningkatkan pendapatan negara.',
                        'target_word' => 'enacts (Verbal Active)',
                        'vocab' => [
                            'the government' => [
                                'id' => 'pemerintah (pelaku aksi)',
                                'pos' => '(n singular)',
                            ],
                            'enacts' => [
                                'id' => 'memberlakukan (aksi aktif)',
                                'pos' => '(v)',
                            ],
                            'fiscal legislation' => [
                                'id' => 'undang-undang fiskal',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The central administration enacts comprehensive corporate taxation legislation to enhance public revenues.',
                            'The central administration is enacts comprehensive corporate taxation legislation to enhance public revenues.',
                            'The central administration is enacted comprehensive corporate taxation legislation to enhance public revenues.',
                            'The central administration enact comprehensive corporate taxation legislation to enhance public revenues.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The central administration\' adalah PELAKU aksi aktif yang memberlakukan regulasi. Bentuk kalimat yang benar adalah Verbal Aktif: \'enacts\' (bukan pasif \'is enacted\' dan bukan double predicate \'is enacts\').',
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Undang-undang perpajakan baru diberlakukan oleh pemerintah untuk meningkatkan pendapatan negara.',
                        'target_word' => 'is enacted (Passive Verb)',
                        'vocab' => [
                            'tax legislation' => [
                                'id' => 'undang-undang pajak (penerima aksi)',
                                'pos' => '(n singular)',
                            ],
                            'is enacted' => [
                                'id' => 'diberlakukan (pasif)',
                                'pos' => '(v passive)',
                            ],
                            'by the administration' => [
                                'id' => 'oleh pemerintah',
                                'pos' => '(agent)',
                            ],
                        ],
                        'options' => [
                            'Comprehensive corporate taxation legislation is enacted by the administration to enhance public revenues.',
                            'Comprehensive corporate taxation legislation enacts by the administration to enhance public revenues.',
                            'Comprehensive corporate taxation legislation is enact by the administration to enhance public revenues.',
                            'Comprehensive corporate taxation legislation are enacted by the administration to enhance public revenues.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'legislation\' adalah OBJEK PENERIMA aksi (undang-undang tidak memberlakukan dirinya sendiri). Maka wajib menggunakan bentuk Pasif: \'is enacted\'.',
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Undang-undang perpajakan baru tersebut wajib dan mengikat secara hukum bagi seluruh korporasi.',
                        'target_word' => 'is mandatory and legally binding (Nominal Predicate)',
                        'vocab' => [
                            'legislation' => [
                                'id' => 'undang-undang (status/sifat)',
                                'pos' => '(n singular)',
                            ],
                            'mandatory and binding' => [
                                'id' => 'wajib dan mengikat (kata sifat)',
                                'pos' => '(adj phr)',
                            ],
                            'commercial corporations' => [
                                'id' => 'korporasi komersial',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The newly drafted taxation legislation is mandatory and legally binding for all incorporated enterprises.',
                            'The newly drafted taxation legislation mandatory and legally binding for all incorporated enterprises.',
                            'The newly drafted taxation legislation does mandatory and legally binding for all incorporated enterprises.',
                            'The newly drafted taxation legislation is mandatorily and legally bind for all incorporated enterprises.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat ini mendeskripsikan STATUS hukum (\'mandatory and legally binding\' = Adjectives). Maka wajib menggunakan bentuk Nominal: \'is mandatory and legally binding\'.',
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Para insinyur menguji ketahanan jembatan (Verbal) karena keselamatan publik adalah prioritas utama (Nominal).',
                        'target_word' => 'test (Verbal) | is (Nominal)',
                        'vocab' => [
                            'engineers test' => [
                                'id' => 'insinyur menguji (Verbal)',
                                'pos' => '(clause)',
                            ],
                            'structural resilience' => [
                                'id' => 'ketahanan struktural',
                                'pos' => '(n)',
                            ],
                            'public safety is a top priority' => [
                                'id' => 'keselamatan publik adalah prioritas (Nominal)',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Structural engineers test bridge load-bearing capacity because commuter safety is the paramount institutional priority.',
                            'Structural engineers are test bridge load-bearing capacity because commuter safety is the paramount institutional priority.',
                            'Structural engineers test bridge load-bearing capacity because commuter safety the paramount institutional priority.',
                            'Structural engineers are tested bridge load-bearing capacity because commuter safety is the paramount institutional priority.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama adalah Verbal aktif \'engineers test\' (tanpa to be). Klausa kedua adalah Nominal \'commuter safety is ... priority\' (wajib to be \'is\').',
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Ketahanan jembatan diuji secara berkala oleh para insinyur (Pasif) agar infrastruktur tersebut tetap aman (Nominal).',
                        'target_word' => 'is tested (Passive) | remains / is safe (Nominal)',
                        'vocab' => [
                            'bridge capacity is tested' => [
                                'id' => 'kapasitas jembatan diuji (Pasif)',
                                'pos' => '(clause)',
                            ],
                            'infrastructure remains secure' => [
                                'id' => 'infrastruktur tetap aman (Nominal)',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Bridge load-bearing capacity is tested periodically by engineers so that the municipal infrastructure remains safe.',
                            'Bridge load-bearing capacity tests periodically by engineers so that the municipal infrastructure remains safe.',
                            'Bridge load-bearing capacity is test periodically by engineers so that the municipal infrastructure safe.',
                            'Bridge load-bearing capacity are tested periodically by engineers so that the municipal infrastructure remains safe.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Capacity\' adalah subjek tunggal yang diuji (Pasif: \'is tested\'). Bagian kedua adalah keadaan aman (Nominal/Linking: \'remains safe\').',
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Model ekonomi baru ini memberikan prediksi yang andal (Verbal) dan terbukti bermanfaat bagi bank sentral (Nominal).',
                        'target_word' => 'provides (Verbal) | is advantageous (Nominal)',
                        'vocab' => [
                            'provides reliable predictions' => [
                                'id' => 'memberikan prediksi andal (Verbal)',
                                'pos' => '(clause)',
                            ],
                            'is highly advantageous' => [
                                'id' => 'sangat bermanfaat (Nominal)',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'This econometric forecasting tool provides reliable projections and is highly advantageous for central bankers.',
                            'This econometric forecasting tool is provides reliable projections and is highly advantageous for central bankers.',
                            'This econometric forecasting tool provides reliable projections and highly advantageous for central bankers.',
                            'This econometric forecasting tool is provided reliable projections and advantageous for central bankers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bagian pertama adalah Verbal aktif \'provides\' (bukan \'is provides\'). Bagian kedua adalah Nominal \'is highly advantageous\' (wajib ada to be sebelum kata sifat).',
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Data statistik tidak membuktikan hubungan sebab-akibat (Verbal), melainkan hanya mengindikasikan korelasi (Verbal).',
                        'target_word' => 'do not prove | indicate (Verbal)',
                        'vocab' => [
                            'do not prove' => [
                                'id' => 'tidak membuktikan (Verbal Negatif)',
                                'pos' => '(v)',
                            ],
                            'causal mechanism' => [
                                'id' => 'mekanisme kausal',
                                'pos' => '(n)',
                            ],
                            'merely indicate' => [
                                'id' => 'hanya mengindikasikan (Verbal)',
                                'pos' => '(v)',
                            ],
                        ],
                        'options' => [
                            'These statistical data do not prove direct causality; they merely indicate a correlational association.',
                            'These statistical data are not prove direct causality; they merely indicate a correlational association.',
                            'These statistical data does not prove direct causality; they merely is indicate a correlational association.',
                            'These statistical data not prove direct causality; they merely are indicating a correlational association.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bila predikat adalah kata kerja aksi \'prove\', bentuk negatif verbal untuk subjek jamak \'data\' adalah \'do not prove\', BUKAN \'are not prove\'.',
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Prosedur operasi standar diperbarui setiap kuartal (Pasif) untuk menjamin bahwa seluruh protokol tetap patuh (Nominal).',
                        'target_word' => 'are updated (Passive) | are compliant (Nominal)',
                        'vocab' => [
                            'operating procedures are updated' => [
                                'id' => 'SOP diperbarui (Pasif)',
                                'pos' => '(clause)',
                            ],
                            'protocols are compliant' => [
                                'id' => 'protokol tetap patuh (Nominal)',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Standard operating procedures are updated quarterly to ensure that operational workflows are fully compliant.',
                            'Standard operating procedures update quarterly to ensure that operational workflows are fully compliant.',
                            'Standard operating procedures are update quarterly to ensure that operational workflows fully compliant.',
                            'Standard operating procedures is updated quarterly to ensure that operational workflows are fully compliant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama pasif \'procedures are updated\' (jamak: to be + V3). Klausa kedua nominal \'workflows are fully compliant\' (jamak: to be + Adjective).',
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Para peneliti menyimpulkan (Verbal) bahwa metode ini efisien (Nominal) dan harus direplikasi di tempat lain (Pasif).',
                        'target_word' => 'conclude (Verbal) | is efficient (Nominal) | is replicated (Passive)',
                        'vocab' => [
                            'researchers conclude' => [
                                'id' => 'peneliti menyimpulkan (Verbal)',
                                'pos' => '(clause)',
                            ],
                            'the method is efficient' => [
                                'id' => 'metode ini efisien (Nominal)',
                                'pos' => '(clause)',
                            ],
                            'is replicated' => [
                                'id' => 'direplikasi (Pasif)',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Researchers conclude that the proposed synthesis is exceptionally efficient and is easily replicated across laboratories.',
                            'Researchers are conclude that the proposed synthesis is exceptionally efficient and is easily replicated across laboratories.',
                            'Researchers conclude that the proposed synthesis exceptionally efficient and easily replicate across laboratories.',
                            'Researchers are concluded that the proposed synthesis is exceptionally efficient and is easily replicated across laboratories.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Integrasi 3 pilar: (1) Verbal aktif \'Researchers conclude\' (tanpa to be), (2) Nominal \'synthesis is exceptionally efficient\' (to be + Adj), (3) Pasif \'is easily replicated\' (to be + V3).',
                    ],
                ],
            ]
        ];
    }
}
