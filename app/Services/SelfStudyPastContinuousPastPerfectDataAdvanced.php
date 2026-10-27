<?php

namespace App\Services;

class SelfStudyPastContinuousPastPerfectDataAdvanced
{
    /**
     * Get the complete Past Continuous & Past Perfect Tenses (Timeline Sequencing) package.
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
            'banner_title' => 'Past Continuous & Past Perfect Tenses (Timeline Sequencing) in Academic Writing',
            'banner_subtitle' => 'Kuasai pengaturan linimasa narasi ilmiah: aksi simultan lampau (was/were + V-ing), prosedur pasif yang sedang berjalan (was/were being + V3), peristiwa pendahulu (had + V3), kondisi retrospektif (had been + Adj/Noun), durasi berkelanjutan (had been + V-ing), dan penghubung waktu formal (by the time, prior to).',
            'banner_badge' => 'MODULE 1.12 TIMELINE SEQUENCING',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.12
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Past Continuous & Past Perfect: Menguasai Linimasa Wacana Akademis',
            'concept_summary' => 'Dalam penulisan bab Metodologi, laporan studi kasus historis, kronologi investigasi klinis, dan esai naratif-analitis (IELTS Task 2), kerancuan urutan waktu (timeline ambiguity) adalah kesalahan fatal yang sering menurunkan skor Coherence and Cohesion serta Grammatical Accuracy. Bab ini mengintegrasikan seluruh ragam tenses masa lampau untuk menciptakan kedalaman linimasa yang presisi: (1) Past Continuous (was/were + V-ing) untuk aksi yang sedang berlangsung di latar belakang; (2) Past Perfect (had + V3) untuk menandai peristiwa yang selesai lebih awal dari peristiwa lampau lainnya (The Earlier Past); dan (3) Past Perfect Continuous (had been + V-ing) untuk menegaskan durasi proses yang sedang berakumulasi.',
            'rules' => [
                [
                    'rule_title' => '1. Past Continuous: Latar Belakang & Aksi Simultan (Was/Were + V-ing)',
                    'rule_formula' => 'Subject + was/were + Verb-ing + while / when + Clause',
                    'rule_description' => 'Gunakan "was + V-ing" untuk subjek tunggal dan "were + V-ing" untuk subjek jamak saat menggambarkan peristiwa latar belakang yang sedang berlangsung ketika peristiwa interupsi (Simple Past) terjadi.',
                    'examples' => [
                        [
                            'en' => 'While researchers were observing the chemical reaction, an unexpected temperature spike occurred.',
                            'id' => 'Ketika para peneliti sedang mengamati reaksi kimia, lonjakan suhu yang tidak terduga terjadi.',
                            'note' => '"were observing" (sedang mengamati) disela oleh peristiwa seketika "occurred".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Past Continuous Pasif: Prosedur Sedang Dijalankan (Was/Were Being + V3)',
                    'rule_formula' => 'Passive Subject + was/were + being + Verb 3 (Past Participle)',
                    'rule_description' => 'Fokus kalimat dialihkan ke sampel atau perlakuan eksperimen yang sedang diproses di masa lampau. Sisipan partikel "being" wajib hadir untuk menandai progresivitas pasif lampau.',
                    'examples' => [
                        [
                            'en' => 'The blood specimens were being tested in the central facility when contamination was detected.',
                            'id' => 'Spesimen darah sedang diuji di laboratorium sentral ketika kontaminasi terdeteksi.',
                            'note' => '"were being tested" adalah bentuk pasif continuous jamak yang tepat.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Past Perfect: Menandai Peristiwa yang Terjadi Lebih Dulu (Had + V3)',
                    'rule_formula' => 'Subject + had + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                    'rule_description' => 'Bila terdapat dua aksi masa lalu, aksi yang selesai lebih awal WAJIB menggunakan Past Perfect "had + V3", sedangkan aksi yang terjadi belakangan menggunakan Simple Past V2.',
                    'examples' => [
                        [
                            'en' => 'The research team had completed preliminary trials before the new equipment arrived.',
                            'id' => 'Tim riset telah menyelesaikan uji coba awal sebelum peralatan laboratorium baru tiba.',
                            'note' => 'Menyelesaikan uji coba ("had completed") selesai sebelum peralatan tiba ("arrived").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Past Perfect Nominal & Pasif: Had Been + Complement / V3',
                    'rule_formula' => 'Nominal: had been + Adj/Noun | Pasif: had been + Verb 3',
                    'rule_description' => 'Menyatakan status pra-kondisi atau prosedur yang telah tuntas dilakukan terhadap objek sebelum titik tolak pengamatan lampau tercapai.',
                    'examples' => [
                        [
                            'en' => 'The clinical protocol had been approved by the ethics committee before the human trial commenced.',
                            'id' => 'Protokol klinis telah disetujui oleh komite etik sebelum penelitian dimulai.',
                            'note' => '"had been approved" menegaskan legalitas etik sebelum penelitian dimulai ("commenced").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Aturan Konjungsi Linimasa: By the time, Prior to, Once',
                    'rule_formula' => 'By the time + S + V2 (Past), S + had + V3 / had been V3',
                    'rule_description' => 'Frasa "By the time" diikuti Simple Past mewajibkan induk kalimat menggunakan Past Perfect. Preposisi "Prior to" diikuti Gerund atau Noun Phrase.',
                    'examples' => [
                        [
                            'en' => 'By the time firefighters arrived on the scene, the fire had engulfed the entire facility.',
                            'id' => 'Menjelang saat pemadam kebakaran tiba, api telah melahap seluruh fasilitas.',
                            'note' => '"had engulfed" terjadi mendahului kedatangan pemadam kebakaran ("arrived").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '6. Past Perfect Continuous: Penekanan Durasi Lampau (Had Been + V-ing)',
                    'rule_formula' => 'Subject + had been + Verb-ing + duration (for/since) + before / when Clause',
                    'rule_description' => 'Digunakan saat penulis ingin menonjolkan proses panjang dan berakumulasi sebelum suatu peristiwa penting terjadi di masa lalu.',
                    'examples' => [
                        [
                            'en' => 'Scientists had been investigating the phenomenon for decades before the breakthrough was achieved.',
                            'id' => 'Para ilmuwan telah meneliti fenomena tersebut selama beberapa dekade sebelum terobosan tercapai.',
                            'note' => '"had been investigating ... for decades" menekankan durasi riset bertahun-tahun.'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Complete 8 sub-lessons with 10 questions each (80 questions total).
     */
    public static function getSubLessons(): array
    {
        return [
            [
                'id' => 'past-continuous-verbal',
                'name' => '1.12.1 Past Continuous: Simultaneous Actions & Ongoing Background Events',
                'code' => '1.12.1',
                'concept_title' => 'Past Continuous: Tindakan Simultan & Peristiwa Latar Belakang Lampau',
                'concept_description' => 'Past Continuous Tense (was/were + V-ing) digunakan dalam laporan eksperimen dan studi kasus untuk menggambarkan peristiwa yang sedang berlangsung sebagai latar belakang (background event) ketika suatu peristiwa penting lain terjadi (interrupted action) atau dua aktivitas yang berlangsung secara bersamaan di masa lampau (simultaneous actions).',
                'description' => 'Past Continuous Tense (was/were + V-ing) digunakan dalam laporan eksperimen dan studi kasus untuk menggambarkan peristiwa yang sedang berlangsung sebagai latar belakang (background event) ketika suatu peristiwa penting lain terjadi (interrupted action) atau dua aktivitas yang berlangsung secara bersamaan di masa lampau (simultaneous actions).',
                'formula' => 'Subject + was/were + Verb-ing + while / when + Clause',
                'rules' => [
                    "Gunakan 'was + V-ing' untuk subjek tunggal (I, he, she, it, singular noun: the researcher, the reaction).",
                    "Gunakan 'were + V-ing' untuk subjek jamak (they, we, plural nouns: scientists, data points).",
                    "Gunakan 'while' untuk mengawali klausa yang sedang berlangsung (While the mixture was cooling...).",
                    "Gunakan 'when' untuk mengawali peristiwa interupsi yang biasanya berbentuk Simple Past (When the alarm sounded...).",
                    'Dilarang menggunakan to be present (is/are) untuk peristiwa masa lampau.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Ketika para peneliti sedang mengamati reaksi kimia, lonjakan suhu yang tidak terduga terjadi.',
                        'target_word' => 'were observing ... occurred (Background Action + Interruption)',
                        'vocab' => [
                            ['en' => 'researchers', 'id' => 'para peneliti'],
                            ['en' => 'chemical reaction', 'id' => 'reaksi kimia'],
                            ['en' => 'unexpected temperature spike', 'id' => 'lonjakan suhu tidak terduga'],
                        ],
                        'options' => [
                            'While researchers were observing the chemical reaction, an unexpected temperature spike occurred.',
                            'While researchers was observing the chemical reaction, an unexpected temperature spike occurred.',
                            'While researchers were observe the chemical reaction, an unexpected temperature spike occurred.',
                            'While researchers were observing the chemical reaction, an unexpected temperature spike was occurred.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'researchers' berpasangan dengan 'were observing'. Peristiwa interupsi yang tiba-tiba terjadi menggunakan Simple Past aktif 'occurred' (bukan *was occurred).",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Sensor tekanan sedang mencatat data saat pemadaman listrik menghentikan eksperimen.',
                        'target_word' => 'was recording ... halted (Interrupted Past Action)',
                        'vocab' => [
                            ['en' => 'pressure transducer', 'id' => 'sensor tekanan'],
                            ['en' => 'recording data', 'id' => 'mencatat data'],
                            ['en' => 'power outage halted', 'id' => 'pemadaman listrik menghentikan'],
                        ],
                        'options' => [
                            'The pressure transducer was recording baseline data when a sudden power outage halted the trial.',
                            'The pressure transducer were recording baseline data when a sudden power outage halted the trial.',
                            'The pressure transducer was record baseline data when a sudden power outage halted the trial.',
                            'The pressure transducer was recording baseline data when a sudden power outage was halted the trial.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'transducer' berpasangan dengan 'was recording', sedangkan klausa 'when' memakai Simple Past aktif 'halted'.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Sementara tim medis sedang memantau tanda-tanda vital pasien, pernapasan pasien mulai stabil.',
                        'target_word' => 'were monitoring ... began (Simultaneous to Outcome)',
                        'vocab' => [
                            ['en' => 'medical personnel', 'id' => 'tim medis'],
                            ['en' => 'vital signs', 'id' => 'tanda-tanda vital'],
                            ['en' => 'respiration began to stabilize', 'id' => 'pernapasan mulai stabil'],
                        ],
                        'options' => [
                            "While medical personnel were monitoring vital signs, the patient's respiration began to stabilize.",
                            "While medical personnel was monitoring vital signs, the patient's respiration began to stabilize.",
                            "While medical personnel were monitor vital signs, the patient's respiration began to stabilize.",
                            "While medical personnel were monitoring vital signs, the patient's respiration was began to stabilize.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'medical personnel' (plural) memakai 'were monitoring', diikuti klausa 'began to stabilize'.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Pada saat gempa terjadi, para ahli geologi sedang mengkalibrasi instrumen seismik di lembah.',
                        'target_word' => 'were calibrating (Past Continuous Background)',
                        'vocab' => [
                            ['en' => 'earthquake struck', 'id' => 'gempa terjadi'],
                            ['en' => 'geologists', 'id' => 'para ahli geologi'],
                            ['en' => 'calibrating seismic instruments', 'id' => 'mengkalibrasi instrumen seismik'],
                        ],
                        'options' => [
                            'At the moment the earthquake struck, geologists were calibrating sensitive seismic instruments in the valley.',
                            'At the moment the earthquake struck, geologists was calibrating sensitive seismic instruments in the valley.',
                            'At the moment the earthquake struck, geologists were calibrate sensitive seismic instruments in the valley.',
                            'At the moment the earthquake struck, geologists had calibrating sensitive seismic instruments in the valley.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'geologists' berpasangan dengan 'were calibrating' sebagai aktivitas yang sedang berlangsung di momen spesifik lampau.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Selama fase pengeringan, kelembaban udara di dalam ruangan uji sedang menurun secara bertahap.',
                        'target_word' => 'was decreasing (Past Continuous Gradual Trend)',
                        'vocab' => [
                            ['en' => 'desiccation phase', 'id' => 'fase pengeringan'],
                            ['en' => 'ambient humidity', 'id' => 'kelembaban udara'],
                            ['en' => 'decreasing gradually', 'id' => 'menurun secara bertahap'],
                        ],
                        'options' => [
                            'During the desiccation phase, ambient humidity inside the chamber was decreasing gradually.',
                            'During the desiccation phase, ambient humidity inside the chamber were decreasing gradually.',
                            'During the desiccation phase, ambient humidity inside the chamber was decrease gradually.',
                            'During the desiccation phase, ambient humidity inside the chamber decreasing was gradually.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'ambient humidity' adalah uncountable singular, sehingga membutuhkan 'was decreasing'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Sementara kelompok pertama sedang mengonsumsi plasebo, kelompok kedua menerima obat terapeutik aktif.',
                        'target_word' => 'were consuming ... received (Parallel Study Groups)',
                        'vocab' => [
                            ['en' => 'first cohort', 'id' => 'kelompok pertama'],
                            ['en' => 'consuming a placebo', 'id' => 'mengonsumsi plasebo'],
                            ['en' => 'active therapeutic agent', 'id' => 'obat terapeutik aktif'],
                        ],
                        'options' => [
                            'While the first cohort was consuming a placebo, the second group received the active therapeutic agent.',
                            'While the first cohort were consuming a placebo, the second group received the active therapeutic agent.',
                            'While the first cohort was consume a placebo, the second group received the active therapeutic agent.',
                            'While the first cohort was consuming a placebo, the second group was received the active therapeutic agent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The first cohort' (kesatuan tunggal) memakai 'was consuming', dikontraskan dengan tindakan kelompok kedua 'received'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Para insinyur perangkat lunak sedang menguji kode sumber baru saat mereka menemukan kerentanan kritis.',
                        'target_word' => 'were auditing ... discovered (Continuous + Simple Past Discovery)',
                        'vocab' => [
                            ['en' => 'software engineers', 'id' => 'insinyur perangkat lunak'],
                            ['en' => 'auditing the codebase', 'id' => 'menguji/memeriksa kode sumber'],
                            ['en' => 'critical security vulnerability', 'id' => 'kerentanan keamanan kritis'],
                        ],
                        'options' => [
                            'Software engineers were auditing the new codebase when they discovered a critical security vulnerability.',
                            'Software engineers was auditing the new codebase when they discovered a critical security vulnerability.',
                            'Software engineers were audit the new codebase when they discovered a critical security vulnerability.',
                            'Software engineers were auditing the new codebase when they were discovered a critical security vulnerability.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Software engineers were auditing' (latar belakang jamak) disela oleh temuan 'when they discovered'.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Ketika gas sedang memuai di dalam tabung reaksi, tekanan internal melonjak tajam.',
                        'target_word' => 'was expanding ... surged (Process + Sharp Result)',
                        'vocab' => [
                            ['en' => 'gas was expanding', 'id' => 'gas sedang memuai'],
                            ['en' => 'combustion chamber', 'id' => 'tabung reaksi/ruang pembakaran'],
                            ['en' => 'internal pressure surged', 'id' => 'tekanan internal melonjak tajam'],
                        ],
                        'options' => [
                            'As the pressurized gas was expanding inside the chamber, internal pressure surged dramatically.',
                            'As the pressurized gas were expanding inside the chamber, internal pressure surged dramatically.',
                            'As the pressurized gas was expand inside the chamber, internal pressure surged dramatically.',
                            'As the pressurized gas was expanding inside the chamber, internal pressure was surged dramatically.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'pressurized gas' mengambil 'was expanding', sedangkan klausa hasil memakai 'surged' aktif.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Sementara para astronom sedang mengamati galaksi jauh, teleskop ruang angkasa menangkap sinyal radio misterius.',
                        'target_word' => 'were observing ... intercepted (Observation + Event)',
                        'vocab' => [
                            ['en' => 'astronomers were observing', 'id' => 'para astronom sedang mengamati'],
                            ['en' => 'distant galaxies', 'id' => 'galaksi jauh'],
                            ['en' => 'intercepted an anomalous signal', 'id' => 'menangkap sinyal misterius/anomali'],
                        ],
                        'options' => [
                            'While astronomers were observing distant galaxies, the deep-space telescope intercepted an anomalous signal.',
                            'While astronomers was observing distant galaxies, the deep-space telescope intercepted an anomalous signal.',
                            'While astronomers were observe distant galaxies, the deep-space telescope intercepted an anomalous signal.',
                            'While astronomers were observing distant galaxies, the deep-space telescope was intercepted an anomalous signal.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'astronomers were observing' (jamak) dipadukan dengan temuan teleskop 'intercepted'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Komite peninjau sedang mendiskusikan amandemen anggaran ketika pengumuman hibah resmi dirilis.',
                        'target_word' => 'was discussing ... was released (Continuous Active + Past Passive)',
                        'vocab' => [
                            ['en' => 'review committee was discussing', 'id' => 'komite peninjau sedang mendiskusikan'],
                            ['en' => 'budgetary amendments', 'id' => 'amandemen anggaran'],
                            ['en' => 'grant announcement was released', 'id' => 'pengumuman hibah dirilis'],
                        ],
                        'options' => [
                            'The review committee was discussing budgetary amendments when the official grant announcement was released.',
                            'The review committee were discussing budgetary amendments when the official grant announcement was released.',
                            'The review committee was discuss budgetary amendments when the official grant announcement was released.',
                            'The review committee was discussing budgetary amendments when the official grant announcement released.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The review committee was discussing' (kolektif tunggal) disela oleh peristiwa pasif lampau 'was released'.",
                    ],
                ]
            ],
            [
                'id' => 'past-continuous-passive',
                'name' => '1.12.2 Past Continuous Passive: Laboratory Procedures & Operations in Progress',
                'code' => '1.12.2',
                'concept_title' => 'Past Continuous Pasif: Prosedur Eksperimen yang Sedang Dijalankan di Masa Lampau',
                'concept_description' => "Past Continuous Pasif digunakan untuk melaporkan prosedur ilmiah atau perlakuan laboratorium yang sedang aktif dijalankan terhadap sampel atau subjek pada saat tertentu di masa lalu. Rumusnya menggunakan 'was/were' diikuti partikel 'being' dan Past Participle (V3). Bentuk ini sangat penting untuk pelaporan metodologis yang objektif tanpa menyebutkan peneliti.",
                'description' => "Past Continuous Pasif digunakan untuk melaporkan prosedur ilmiah atau perlakuan laboratorium yang sedang aktif dijalankan terhadap sampel atau subjek pada saat tertentu di masa lalu. Rumusnya menggunakan 'was/were' diikuti partikel 'being' dan Past Participle (V3). Bentuk ini sangat penting untuk pelaporan metodologis yang objektif tanpa menyebutkan peneliti.",
                'formula' => 'Subject (Patient) + was/were + being + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    "Gunakan 'was being + V3' untuk subjek tunggal (the sample, the patient, the compound).",
                    "Gunakan 'were being + V3' untuk subjek jamak (the specimens, data records, cultures).",
                    "Partikel 'being' wajib hadir untuk menunjukkan progresivitas tindakan lampau.",
                    "Jangan tertukar dengan Past Perfect Pasif (had been + V3); continuous pasif selalu memakai 'being'.",
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Spesimen darah sedang diuji di laboratorium sentral ketika kontaminasi terdeteksi.',
                        'target_word' => 'were being tested (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'blood specimens', 'id' => 'spesimen darah'],
                            ['en' => 'tested in the central facility', 'id' => 'diuji di laboratorium sentral'],
                            ['en' => 'contamination was detected', 'id' => 'kontaminasi terdeteksi'],
                        ],
                        'options' => [
                            'The blood specimens were being tested in the central facility when contamination was detected.',
                            'The blood specimens was being tested in the central facility when contamination was detected.',
                            'The blood specimens were been tested in the central facility when contamination was detected.',
                            'The blood specimens were testing in the central facility when contamination was detected.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'specimens' membutuhkan 'were being tested'. Pilihan C salah memakai 'been' (untuk perfect), dan D aktif ('sedang menguji').",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Protokol keamanan baru sedang diterapkan di pabrik kimia saat kecelakaan industri terjadi.',
                        'target_word' => 'was being implemented (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'safety protocol', 'id' => 'protokol keamanan'],
                            ['en' => 'implemented', 'id' => 'diterapkan'],
                            ['en' => 'industrial mishap occurred', 'id' => 'kecelakaan industri terjadi'],
                        ],
                        'options' => [
                            'A revised safety protocol was being implemented at the chemical plant when the industrial mishap occurred.',
                            'A revised safety protocol were being implemented at the chemical plant when the industrial mishap occurred.',
                            'A revised safety protocol was been implemented at the chemical plant when the industrial mishap occurred.',
                            'A revised safety protocol was implementing at the chemical plant when the industrial mishap occurred.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'A protocol' memerlukan 'was being implemented'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Data mentah sensor sedang diproses oleh komputer pusat ketika aliran listrik terputus.',
                        'target_word' => 'was being processed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'raw sensor telemetry', 'id' => 'data mentah sensor'],
                            ['en' => 'processed by mainframe', 'id' => 'diproses oleh komputer pusat'],
                            ['en' => 'power disconnected', 'id' => 'aliran listrik terputus'],
                        ],
                        'options' => [
                            'Raw sensor telemetry was being processed by the mainframe when the power grid disconnected.',
                            'Raw sensor telemetry were being processed by the mainframe when the power grid disconnected.',
                            'Raw sensor telemetry was been processed by the mainframe when the power grid disconnected.',
                            'Raw sensor telemetry was processing by the mainframe when the power grid disconnected.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'telemetry' berpasangan dengan 'was being processed'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Sampel-sampel batuan purba sedang dipanaskan di dalam tanur listrik pada suhu seribu derajat Celsius.',
                        'target_word' => 'were being heated (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'ancient mineral samples', 'id' => 'sampel batuan purba'],
                            ['en' => 'heated in the electric furnace', 'id' => 'dipanaskan di dalam tanur listrik'],
                            ['en' => 'one thousand degrees Celsius', 'id' => 'seribu derajat Celsius'],
                        ],
                        'options' => [
                            'The ancient mineral samples were being heated in the electric furnace at one thousand degrees Celsius.',
                            'The ancient mineral samples was being heated in the electric furnace at one thousand degrees Celsius.',
                            'The ancient mineral samples were been heated in the electric furnace at one thousand degrees Celsius.',
                            'The ancient mineral samples were heating in the electric furnace at one thousand degrees Celsius.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'samples' membutuhkan 'were being heated'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Laporan keuangan tahunan bank tersebut sedang diaudit ketika regulator menemukan penyimpangan.',
                        'target_word' => 'was being audited (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => "bank's annual financial statement", 'id' => 'laporan keuangan tahunan bank'],
                            ['en' => 'audited by examiners', 'id' => 'diaudit oleh pemeriksa'],
                            ['en' => 'regulators discovered discrepancies', 'id' => 'regulator menemukan penyimpangan'],
                        ],
                        'options' => [
                            "The bank's annual financial statement was being audited when regulators discovered severe discrepancies.",
                            "The bank's annual financial statement were being audited when regulators discovered severe discrepancies.",
                            "The bank's annual financial statement was been audited when regulators discovered severe discrepancies.",
                            "The bank's annual financial statement was auditing when regulators discovered severe discrepancies.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'statement' berpasangan dengan 'was being audited'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Kultur bakteri sedang diinkubasi dalam cawan petri selama periode isolasi termal.',
                        'target_word' => 'were being incubated (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'bacterial cultures', 'id' => 'kultur bakteri'],
                            ['en' => 'incubated in petri dishes', 'id' => 'diinkubasi dalam cawan petri'],
                            ['en' => 'thermal isolation window', 'id' => 'periode isolasi termal'],
                        ],
                        'options' => [
                            'The bacterial cultures were being incubated in sealed petri dishes throughout the thermal isolation window.',
                            'The bacterial cultures was being incubated in sealed petri dishes throughout the thermal isolation window.',
                            'The bacterial cultures were been incubated in sealed petri dishes throughout the thermal isolation window.',
                            'The bacterial cultures were incubating in sealed petri dishes throughout the thermal isolation window.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'cultures' dipadukan dengan 'were being incubated'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Infrastruktur saluran pipa air sedang diperbaiki ketika gempa susulan mengguncang wilayah tersebut.',
                        'target_word' => 'was being restored (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'water distribution pipeline', 'id' => 'saluran pipa air'],
                            ['en' => 'restored', 'id' => 'diperbaiki/dipulihkan'],
                            ['en' => 'aftershock rattled the region', 'id' => 'gempa susulan mengguncang'],
                        ],
                        'options' => [
                            'The water distribution pipeline was being restored when a minor aftershock rattled the region.',
                            'The water distribution pipeline were being restored when a minor aftershock rattled the region.',
                            'The water distribution pipeline was been restored when a minor aftershock rattled the region.',
                            'The water distribution pipeline was restoring when a minor aftershock rattled the region.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'pipeline' membutuhkan 'was being restored'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Sinyal radio frekuensi rendah sedang dipancarkan dari stasiun observatorium saat gangguan atmosfer terjadi.',
                        'target_word' => 'were being transmitted (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'low-frequency signals', 'id' => 'sinyal frekuensi rendah'],
                            ['en' => 'transmitted from observatory', 'id' => 'dipancarkan dari observatorium'],
                            ['en' => 'atmospheric disturbance occurred', 'id' => 'gangguan atmosfer terjadi'],
                        ],
                        'options' => [
                            'Low-frequency signals were being transmitted from the observatory when atmospheric disturbance occurred.',
                            'Low-frequency signals was being transmitted from the observatory when atmospheric disturbance occurred.',
                            'Low-frequency signals were been transmitted from the observatory when atmospheric disturbance occurred.',
                            'Low-frequency signals were transmitting from the observatory when atmospheric disturbance occurred.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'signals' memerlukan 'were being transmitted'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Senyawa polimer sintetis tersebut sedang dievaluasi kekuatannya di bawah uji tekanan mekanis.',
                        'target_word' => 'was being evaluated (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'synthetic polymer compound', 'id' => 'senyawa polimer sintetis'],
                            ['en' => 'evaluated for tensile strength', 'id' => 'dievaluasi kekuatannya'],
                            ['en' => 'mechanical stress tests', 'id' => 'uji tekanan mekanis'],
                        ],
                        'options' => [
                            'The synthetic polymer compound was being evaluated for tensile strength under rigorous mechanical stress.',
                            'The synthetic polymer compound were being evaluated for tensile strength under rigorous mechanical stress.',
                            'The synthetic polymer compound was been evaluated for tensile strength under rigorous mechanical stress.',
                            'The synthetic polymer compound was evaluating for tensile strength under rigorous mechanical stress.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'compound' dipadukan dengan 'was being evaluated'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Kuesioner penelitian sedang disebarkan kepada penduduk setempat ketika banjir bandang melanda desa.',
                        'target_word' => 'were being distributed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'survey questionnaires', 'id' => 'kuesioner penelitian'],
                            ['en' => 'distributed to local residents', 'id' => 'disebarkan kepada penduduk setempat'],
                            ['en' => 'flash flood engulfed the village', 'id' => 'banjir bandang melanda desa'],
                        ],
                        'options' => [
                            'Survey questionnaires were being distributed to local residents when a flash flood engulfed the village.',
                            'Survey questionnaires was being distributed to local residents when a flash flood engulfed the village.',
                            'Survey questionnaires were been distributed to local residents when a flash flood engulfed the village.',
                            'Survey questionnaires were distributing to local residents when a flash flood engulfed the village.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'questionnaires' berpasangan dengan 'were being distributed'.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-verbal',
                'name' => '1.12.3 Past Perfect Verbal: Establishing Antecedent Actions (The Earlier Past)',
                'code' => '1.12.3',
                'concept_title' => 'Past Perfect Verbal: Peristiwa Pendahulu dalam Linimasa Lampau',
                'concept_description' => "Past Perfect Verbal (had + V3) digunakan ketika ada DUA peristiwa yang sama-sama terjadi di masa lalu, dan kita harus menegaskan secara eksplisit bahwa tindakan A telah selesai sepenuhnya SEBELUM tindakan B terjadi. Tense ini dinamakan 'The Earlier Past' atau masa lalu yang lebih lampau. Tidak bergantung pada subjek tunggal/jamak: semua subjek menggunakan 'had + V3'.",
                'description' => "Past Perfect Verbal (had + V3) digunakan ketika ada DUA peristiwa yang sama-sama terjadi di masa lalu, dan kita harus menegaskan secara eksplisit bahwa tindakan A telah selesai sepenuhnya SEBELUM tindakan B terjadi. Tense ini dinamakan 'The Earlier Past' atau masa lalu yang lebih lampau. Tidak bergantung pada subjek tunggal/jamak: semua subjek menggunakan 'had + V3'.",
                'formula' => 'Subject + had + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                'rules' => [
                    "Gunakan 'had + V3' untuk tindakan pertama yang terjadi lebih awal.",
                    'Gunakan Simple Past (V2) untuk tindakan kedua yang terjadi kemudian.',
                    "Semua subjek (tunggal maupun jamak) menggunakan auxiliary yang sama: 'had'.",
                    "Dilarang menggunakan 'had + V3' sendirian tanpa adanya titik tolak masa lampau (Past Point of Reference) dalam konteks kalimat.",
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Tim riset telah menyelesaikan uji coba awal sebelum peralatan laboratorium baru tiba.',
                        'target_word' => 'had completed ... arrived (Earlier Past vs Past)',
                        'vocab' => [
                            ['en' => 'research team had completed', 'id' => 'tim riset telah menyelesaikan'],
                            ['en' => 'preliminary trials', 'id' => 'uji coba awal'],
                            ['en' => 'new equipment arrived', 'id' => 'peralatan baru tiba'],
                        ],
                        'options' => [
                            'The research team had completed preliminary trials before the new laboratory equipment arrived.',
                            'The research team has completed preliminary trials before the new laboratory equipment arrived.',
                            'The research team completed preliminary trials before the new laboratory equipment had arrived.',
                            'The research team had complete preliminary trials before the new laboratory equipment arrived.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan menyelesaikan uji coba terjadi lebih dulu ('had completed') sebelum peralatan tiba ('arrived' Simple Past).",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sebelum mempublikasikan temuan mereka, para ilmuwan telah memverifikasi data melalui replikasi independen.',
                        'target_word' => 'had verified ... published (Antecedent Action)',
                        'vocab' => [
                            ['en' => 'verified the data', 'id' => 'memverifikasi data'],
                            ['en' => 'independent replications', 'id' => 'replikasi independen'],
                            ['en' => 'published findings', 'id' => 'mempublikasikan temuan'],
                        ],
                        'options' => [
                            'Before publishing their findings, scientists had verified the data through independent replications.',
                            'Before publishing their findings, scientists has verified the data through independent replications.',
                            'Before publishing their findings, scientists had verify the data through independent replications.',
                            'Before publishing their findings, scientists have verified the data through independent replications back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Verifikasi terjadi mendahului publikasi lampau, sehingga wajib menggunakan Past Perfect 'had verified'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Pasien telah meminum antibiotik selama lima hari sebelum gejala alergi parah muncul.',
                        'target_word' => 'had taken ... appeared (Earlier Past Sequence)',
                        'vocab' => [
                            ['en' => 'patient had taken antibiotics', 'id' => 'pasien telah meminum antibiotik'],
                            ['en' => 'for five days', 'id' => 'selama lima hari'],
                            ['en' => 'severe allergic symptoms appeared', 'id' => 'gejala alergi parah muncul'],
                        ],
                        'options' => [
                            'The patient had taken antibiotics for five days before severe allergic symptoms appeared.',
                            'The patient has taken antibiotics for five days before severe allergic symptoms appeared.',
                            'The patient took antibiotics for five days before severe allergic symptoms had appeared.',
                            'The patient had took antibiotics for five days before severe allergic symptoms appeared.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan minum obat ('had taken') mendahului kemunculan gejala ('appeared'). Past Participle dari take adalah 'taken', bukan 'took'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Perusahaan farmasi tersebut telah menarik kembali obat itu sebelum kementerian kesehatan mengeluarkan larangan resmi.',
                        'target_word' => 'had recalled ... issued (Prior Action)',
                        'vocab' => [
                            ['en' => 'recalled the drug', 'id' => 'menarik kembali obat'],
                            ['en' => 'health ministry issued', 'id' => 'kementerian kesehatan mengeluarkan'],
                            ['en' => 'official ban', 'id' => 'larangan resmi'],
                        ],
                        'options' => [
                            'The pharmaceutical firm had recalled the medication before the health ministry issued an official ban.',
                            'The pharmaceutical firm has recalled the medication before the health ministry issued an official ban.',
                            'The pharmaceutical firm recalled the medication before the health ministry had issued an official ban.',
                            'The pharmaceutical firm had recall the medication before the health ministry issued an official ban.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penarikan obat mendahului larangan resmi: 'had recalled' disusul 'issued'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Menjelang tahun 2020, universitas tersebut telah mendirikan tiga pusat riset energi terbarukan.',
                        'target_word' => 'had established (Completed Before Past Milestone)',
                        'vocab' => [
                            ['en' => 'by 2020', 'id' => 'menjelang tahun 2020'],
                            ['en' => 'established research centers', 'id' => 'mendirikan pusat riset'],
                            ['en' => 'renewable energy', 'id' => 'energi terbarukan'],
                        ],
                        'options' => [
                            'By 2020, the university had established three dedicated renewable energy research centers.',
                            'By 2020, the university has established three dedicated renewable energy research centers.',
                            'By 2020, the university establishes three dedicated renewable energy research centers.',
                            'By 2020, the university was established three dedicated renewable energy research centers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa batas waktu lampau 'By 2020' (sebelum/menjelang 2020) mewajibkan Past Perfect 'had established'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Para insinyur telah merancang tiga prototipe berbeda sebelum memilih desain aerodinamis akhir.',
                        'target_word' => 'had designed ... selected (Sequential Engineering)',
                        'vocab' => [
                            ['en' => 'engineers had designed', 'id' => 'para insinyur telah merancang'],
                            ['en' => 'distinct prototypes', 'id' => 'prototipe berbeda'],
                            ['en' => 'selected the final aerodynamic blueprint', 'id' => 'memilih desain akhir'],
                        ],
                        'options' => [
                            'Engineers had designed three distinct prototypes before selecting the final aerodynamic blueprint.',
                            'Engineers has designed three distinct prototypes before selecting the final aerodynamic blueprint.',
                            'Engineers designed three distinct prototypes before they had selected the final aerodynamic blueprint.',
                            'Engineers had design three distinct prototypes before selecting the final aerodynamic blueprint.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Perancangan ketiga prototipe selesai lebih dahulu ('had designed') sebelum pemilihan blueprint akhir.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Ketika dewan penilai bersidang, koordinator program telah menyusun semua laporan evaluasi semester.',
                        'target_word' => 'had compiled ... convened (Past Perfect with When)',
                        'vocab' => [
                            ['en' => 'evaluation panel convened', 'id' => 'dewan penilai bersidang'],
                            ['en' => 'program coordinator had compiled', 'id' => 'koordinator telah menyusun'],
                            ['en' => 'semester assessment dossiers', 'id' => 'laporan evaluasi semester'],
                        ],
                        'options' => [
                            'When the evaluation panel convened, the program coordinator had compiled all semester assessment dossiers.',
                            'When the evaluation panel convened, the program coordinator has compiled all semester assessment dossiers.',
                            'When the evaluation panel had convened, the program coordinator compiled all semester assessment dossiers.',
                            'When the evaluation panel convened, the program coordinator was compiled all semester assessment dossiers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penyusunan berkas selesai sebelum dewan bersidang: 'had compiled' + 'convened'.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Populasi spesies burung tersebut telah menurun sebesar empat puluh persen sebelum program konservasi diluncurkan.',
                        'target_word' => 'had declined ... was launched (Past Perfect + Past Passive)',
                        'vocab' => [
                            ['en' => 'avian population had declined', 'id' => 'populasi burung telah menurun'],
                            ['en' => 'by forty percent', 'id' => 'sebesar empat puluh persen'],
                            ['en' => 'conservation program was launched', 'id' => 'program konservasi diluncurkan'],
                        ],
                        'options' => [
                            'The avian population had declined by forty percent before the conservation initiative was launched.',
                            'The avian population has declined by forty percent before the conservation initiative was launched.',
                            'The avian population declined by forty percent before the conservation initiative had launched.',
                            'The avian population had decline by forty percent before the conservation initiative was launched.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penurunan populasi terjadi lebih dahulu ('had declined') sebelum inisiatif diluncurkan ('was launched').",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Setelah para peneliti telah mengumpulkan sampel air tanah, mereka mengukur konsentrasi logam berat.',
                        'target_word' => 'had collected ... measured (After + Past Perfect)',
                        'vocab' => [
                            ['en' => 'had collected groundwater samples', 'id' => 'telah mengumpulkan sampel air tanah'],
                            ['en' => 'measured heavy metal concentrations', 'id' => 'mengukur konsentrasi logam berat'],
                        ],
                        'options' => [
                            'After investigators had collected the groundwater samples, they measured heavy metal concentrations.',
                            'After investigators has collected the groundwater samples, they measured heavy metal concentrations.',
                            'After investigators collected the groundwater samples, they had measured heavy metal concentrations.',
                            'After investigators were collected the groundwater samples, they measured heavy metal concentrations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengumpulan sampel selesai terlebih dahulu ('had collected'), baru kemudian dilakukan pengukuran ('measured').",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Ahli kimia tersebut telah memurnikan senyawa tersebut tiga kali sebelum mengirimkannya untuk analisis spektrometri.',
                        'target_word' => 'had purified ... dispatched (Repeated Past Action Before Mark)',
                        'vocab' => [
                            ['en' => 'had purified the compound', 'id' => 'telah memurnikan senyawa'],
                            ['en' => 'three times', 'id' => 'tiga kali'],
                            ['en' => 'dispatched for spectrometry analysis', 'id' => 'mengirimkan untuk analisis spektrometri'],
                        ],
                        'options' => [
                            'The analytical chemist had purified the compound three times before dispatching it for mass spectrometry.',
                            'The analytical chemist has purified the compound three times before dispatching it for mass spectrometry.',
                            'The analytical chemist purified the compound three times before dispatching it had been mass spectrometry.',
                            'The analytical chemist had purify the compound three times before dispatching it for mass spectrometry.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemurnian 3 kali selesai lebih dahulu ('had purified') sebelum pengiriman sampel.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-nominal',
                'name' => '1.12.4 Past Perfect Nominal: Pre-Existing Past States & Conditions',
                'code' => '1.12.4',
                'concept_title' => 'Past Perfect Nominal: Keadaan & Sifat yang Berlangsung Mendahului Masa Lampau',
                'concept_description' => "Past Perfect Nominal (had been + Adjective / Noun / Prepositional Phrase) digunakan untuk menyatakan keadaan, status, atau sifat subjek yang telah berlangsung selama kurun waktu tertentu SEBELUM titik waktu masa lalu tertentu tiba. Kata 'been' wajib disisipkan setelah 'had'.",
                'description' => "Past Perfect Nominal (had been + Adjective / Noun / Prepositional Phrase) digunakan untuk menyatakan keadaan, status, atau sifat subjek yang telah berlangsung selama kurun waktu tertentu SEBELUM titik waktu masa lalu tertentu tiba. Kata 'been' wajib disisipkan setelah 'had'.",
                'formula' => 'Subject + had been + Adjective / Noun Phrase / Prepositional Phrase + before / when Clause',
                'rules' => [
                    'Pola rumus baku: Subject + had been + Complement.',
                    "Semua jenis subjek (tunggal dan jamak) menggunakan 'had been'.",
                    'Menunjukkan kondisi lampau yang bertahan hingga suatu momen interupsi masa lampau terjadi.',
                    "Dilarang meniadakan 'been' (*The patient had asymptomatic adalah SALAH BESAR).",
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Pasien telah bebas gejala selama tiga hari sebelum kambuh mendadak.',
                        'target_word' => 'had been asymptomatic (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'patient had been asymptomatic', 'id' => 'pasien telah bebas gejala'],
                            ['en' => 'for three consecutive days', 'id' => 'selama tiga hari berturut-turut'],
                            ['en' => 'sudden clinical relapse occurred', 'id' => 'kambuh mendadak'],
                        ],
                        'options' => [
                            'The patient had been asymptomatic for three consecutive days before a sudden clinical relapse occurred.',
                            'The patient has been asymptomatic for three consecutive days before a sudden clinical relapse occurred.',
                            'The patient had asymptomatic for three consecutive days before a sudden clinical relapse occurred.',
                            'The patient was been asymptomatic for three consecutive days before a sudden clinical relapse occurred.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi bebas gejala berlangsung sebelum kekambuhan lampau, sehingga wajib 'had been asymptomatic'. Opsi C salah karena menghilangkan 'been'.",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Wilayah pesisir tersebut telah menjadi zona rawan banjir selama beberapa dekade sebelum tanggul dibangun.',
                        'target_word' => 'had been a high-risk flood zone (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'coastal territory had been', 'id' => 'wilayah pesisir telah menjadi'],
                            ['en' => 'high-risk flood zone', 'id' => 'zona rawan banjir'],
                            ['en' => 'sea wall was constructed', 'id' => 'tanggul laut dibangun'],
                        ],
                        'options' => [
                            'The coastal territory had been a high-risk flood zone for decades before the modern sea wall was erected.',
                            'The coastal territory has been a high-risk flood zone for decades before the modern sea wall was erected.',
                            'The coastal territory was been a high-risk flood zone for decades before the modern sea wall was erected.',
                            'The coastal territory had a high-risk flood zone for decades before the modern sea wall was erected.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Status zona rawan mendahului pembangunan tanggul lampau: 'had been a high-risk flood zone'.",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Kedua senyawa kimia tersebut telah stabil di bawah suhu ruang sebelum katalis ditambahkan.',
                        'target_word' => 'had been stable (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'chemical compounds had been stable', 'id' => 'senyawa kimia telah stabil'],
                            ['en' => 'ambient room temperature', 'id' => 'suhu ruang'],
                            ['en' => 'catalyst was introduced', 'id' => 'katalis ditambahkan'],
                        ],
                        'options' => [
                            'Both chemical compounds had been stable at room temperature before the acidic catalyst was introduced.',
                            'Both chemical compounds have been stable at room temperature before the acidic catalyst was introduced.',
                            'Both chemical compounds had stable at room temperature before the acidic catalyst was introduced.',
                            'Both chemical compounds were been stable at room temperature before the acidic catalyst was introduced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'compounds' menggunakan 'had been stable' sebelum penambahan katalis ('was introduced').",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Profesor tersebut telah menjadi direktur institut selama sepuluh tahun ketika ia memutuskan untuk pensiun.',
                        'target_word' => 'had been the institute director (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'had been the institute director', 'id' => 'telah menjadi direktur institut'],
                            ['en' => 'for ten consecutive years', 'id' => 'selama sepuluh tahun berturut-turut'],
                            ['en' => 'decided to retire', 'id' => 'memutuskan untuk pensiun'],
                        ],
                        'options' => [
                            'The professor had been the institute director for ten consecutive years when she decided to retire.',
                            'The professor has been the institute director for ten consecutive years when she decided to retire.',
                            'The professor was been the institute director for ten consecutive years when she decided to retire.',
                            'The professor had the institute director for ten consecutive years when she decided to retire.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jabatan selama 10 tahun tersebut berlangsung sebelum keputusan pensiun lampau ('decided'): 'had been the institute director'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Hasil pembacaan sensor telah tidak konsisten selama beberapa jam sebelum malfungsi terdeteksi.',
                        'target_word' => 'had been erratic (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'sensor readings had been erratic', 'id' => 'pembacaan sensor telah tidak konsisten'],
                            ['en' => 'for several hours', 'id' => 'selama beberapa jam'],
                            ['en' => 'hardware malfunction was flagged', 'id' => 'malfungsi perangkat keras terdeteksi'],
                        ],
                        'options' => [
                            'The sensor readings had been erratic for several hours before the hardware malfunction was flagged.',
                            'The sensor readings have been erratic for several hours before the hardware malfunction was flagged.',
                            'The sensor readings had erratic for several hours before the hardware malfunction was flagged.',
                            'The sensor readings were been erratic for several hours before the hardware malfunction was flagged.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi tidak menentu ('had been erratic') mendahului terdeteksinya kerusakan lampau ('was flagged').",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Perjanjian perdagangan tersebut telah berlaku efektif selama lima tahun sebelum negosiasi ulang dimulai.',
                        'target_word' => 'had been in effect (Past Perfect Nominal with Prepositional Phrase)',
                        'vocab' => [
                            ['en' => 'trade agreement had been in effect', 'id' => 'perjanjian telah berlaku efektif'],
                            ['en' => 'for five years', 'id' => 'selama lima tahun'],
                            ['en' => 'renegotiations commenced', 'id' => 'negosiasi ulang dimulai'],
                        ],
                        'options' => [
                            'The trade agreement had been in effect for five years before bilateral renegotiations commenced.',
                            'The trade agreement has been in effect for five years before bilateral renegotiations commenced.',
                            'The trade agreement had in effect for five years before bilateral renegotiations commenced.',
                            'The trade agreement was in effect for five years before bilateral renegotiations had commenced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa 'in effect' memerlukan 'had been' untuk menyatakan masa berlaku sebelum negosiasi lampau dimulai.",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Tingkat inflasi telah tinggi sebelum bank sentral menaikkan suku bunga.',
                        'target_word' => 'had been elevated (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'inflation rate had been elevated', 'id' => 'tingkat inflasi telah tinggi/meningkat'],
                            ['en' => 'central bank raised interest rates', 'id' => 'bank sentral menaikkan suku bunga'],
                        ],
                        'options' => [
                            'The inflation rate had been elevated for several months before the central bank raised interest rates.',
                            'The inflation rate has been elevated for several months before the central bank raised interest rates.',
                            'The inflation rate had elevated for several months before the central bank raised interest rates.',
                            'The inflation rate was been elevated for several months before the central bank raised interest rates.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi inflasi tinggi mendahului kebijakan kenaikan suku bunga lampau: 'had been elevated'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Subjek uji coba telah dalam keadaan puasa selama dua belas jam sebelum tes darah dilakukan.',
                        'target_word' => 'had been in a fasted state (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'trial subjects had been in a fasted state', 'id' => 'subjek uji coba telah dalam keadaan puasa'],
                            ['en' => 'for twelve hours', 'id' => 'selama 12 jam'],
                            ['en' => 'blood draw was administered', 'id' => 'tes darah dilakukan'],
                        ],
                        'options' => [
                            'The trial subjects had been in a fasted state for twelve hours before the blood draw was administered.',
                            'The trial subjects have been in a fasted state for twelve hours before the blood draw was administered.',
                            'The trial subjects had in a fasted state for twelve hours before the blood draw was administered.',
                            'The trial subjects were been in a fasted state for twelve hours before the blood draw was administered.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'subjects' berpasangan dengan 'had been in a fasted state'.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Fasilitas laboratorium tersebut telah beroperasi selama satu abad ketika universitas memutuskan merenovasinya.',
                        'target_word' => 'had been operational (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'laboratory facility had been operational', 'id' => 'fasilitas laboratorium telah beroperasi'],
                            ['en' => 'for a century', 'id' => 'selama satu abad'],
                            ['en' => 'university resolved to modernize it', 'id' => 'universitas memutuskan merenovasinya'],
                        ],
                        'options' => [
                            'The laboratory facility had been operational for a century when the university resolved to modernize it.',
                            'The laboratory facility has been operational for a century when the university resolved to modernize it.',
                            'The laboratory facility had operational for a century when the university resolved to modernize it.',
                            'The laboratory facility was been operational for a century when the university resolved to modernize it.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Status operasional selama 1 abad mendahului keputusan renovasi lampau: 'had been operational'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Metrik kinerja karyawan telah sangat memuaskan sebelum restrukturisasi organisasi diumumkan.',
                        'target_word' => 'had been exceptionally positive (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'performance metrics had been positive', 'id' => 'metrik kinerja telah positif/memuaskan'],
                            ['en' => 'organizational restructuring was announced', 'id' => 'restrukturisasi organisasi diumumkan'],
                        ],
                        'options' => [
                            'Performance metrics had been exceptionally positive before the organizational restructuring was announced.',
                            'Performance metrics have been exceptionally positive before the organizational restructuring was announced.',
                            'Performance metrics had exceptionally positive before the organizational restructuring was announced.',
                            'Performance metrics were been exceptionally positive before the organizational restructuring was announced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Performance metrics had been exceptionally positive' mendahului momen pengumuman pasif lampau 'was announced'.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-passive',
                'name' => '1.12.5 Past Perfect Passive: Earlier Processes & Milestones in Retrospect',
                'code' => '1.12.5',
                'concept_title' => 'Past Perfect Pasif: Prosedur Pendahulu dalam Tinjauan Retrospektif',
                'concept_description' => 'Past Perfect Pasif (had been + V3) digunakan ketika subjek kalimat menerima tindakan yang telah tuntas dilakukan sebelum peristiwa masa lampau lainnya terjadi. Sangat penting dalam laporan ilmiah untuk menegaskan bahwa perlakuan terhadap sampel atau otorisasi etis telah diselesaikan sepenuhnya sebelum fase eksperimen berikutnya dimulai.',
                'description' => 'Past Perfect Pasif (had been + V3) digunakan ketika subjek kalimat menerima tindakan yang telah tuntas dilakukan sebelum peristiwa masa lampau lainnya terjadi. Sangat penting dalam laporan ilmiah untuk menegaskan bahwa perlakuan terhadap sampel atau otorisasi etis telah diselesaikan sepenuhnya sebelum fase eksperimen berikutnya dimulai.',
                'formula' => 'Subject (Patient) + had been + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                'rules' => [
                    'Rumus baku: Subject + had been + Past Participle (V3).',
                    'Jangan tertukar dengan Past Continuous Pasif (was/were being + V3) atau Present Perfect Pasif (have/has been + V3).',
                    "Berlaku sama untuk subjek tunggal dan jamak ('had been + V3').",
                    'Menegaskan kesiapan atau kepatuhan prosedur awal sebelum pengujian lanjutan dimulai.',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Protokol klinis telah disetujui oleh komite etik sebelum penelitian dimulai.',
                        'target_word' => 'had been approved ... commenced (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'clinical protocol had been approved', 'id' => 'protokol klinis telah disetujui'],
                            ['en' => 'institutional ethics committee', 'id' => 'komite etik institusi'],
                            ['en' => 'trial commenced', 'id' => 'penelitian dimulai'],
                        ],
                        'options' => [
                            'The clinical protocol had been approved by the ethics committee before the human trial commenced.',
                            'The clinical protocol has been approved by the ethics committee before the human trial commenced.',
                            'The clinical protocol was being approved by the ethics committee before the human trial commenced.',
                            'The clinical protocol had approved by the ethics committee before the human trial commenced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Persetujuan protokol terjadi dan selesai terlebih dahulu ('had been approved') sebelum penelitian dimulai ('commenced'). Opsi D salah karena bermakna aktif ('protokol telah menyetujui').",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Semua sampel darah telah dibekukan pada suhu minus delapan puluh derajat sebelum analisis DNA dilakukan.',
                        'target_word' => 'had been frozen ... was performed (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'blood specimens had been frozen', 'id' => 'sampel darah telah dibekukan'],
                            ['en' => 'minus eighty degrees', 'id' => 'minus 80 derajat'],
                            ['en' => 'DNA extraction was performed', 'id' => 'ekstraksi DNA dilakukan'],
                        ],
                        'options' => [
                            'All blood specimens had been frozen at minus eighty degrees before DNA extraction was performed.',
                            'All blood specimens have been frozen at minus eighty degrees before DNA extraction was performed.',
                            'All blood specimens had being frozen at minus eighty degrees before DNA extraction was performed.',
                            'All blood specimens were frozen at minus eighty degrees before DNA extraction had been performed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pembekuan sampel selesai lebih awal ('had been frozen') mendahului pelaksanaan analisis ('was performed').",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Teori tersebut telah dibantah oleh beberapa eksperimen independen sebelum Smith menerbitkan bukunya.',
                        'target_word' => 'had been refuted (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'hypothesis had been refuted', 'id' => 'teori/hipotesis telah dibantah'],
                            ['en' => 'independent replications', 'id' => 'eksperimen independen'],
                            ['en' => 'Smith published his treatise', 'id' => 'Smith menerbitkan bukunya'],
                        ],
                        'options' => [
                            'The hypothesis had been refuted by multiple independent experiments before Smith published his treatise.',
                            'The hypothesis has been refuted by multiple independent experiments before Smith published his treatise.',
                            'The hypothesis was being refuted by multiple independent experiments before Smith published his treatise.',
                            'The hypothesis had refuted by multiple independent experiments before Smith published his treatise.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The hypothesis had been refuted' (pasif masa lalu lebih lampau) mendahului publikasi buku ('published').",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Data mentah telah dienkripsi dengan standar militer sebelum ditransmisikan ke server pusat.',
                        'target_word' => 'had been encrypted ... was transmitted (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'telemetry data had been encrypted', 'id' => 'data telemetri telah dienkripsi'],
                            ['en' => 'military-grade protocols', 'id' => 'standar militer'],
                            ['en' => 'transmitted to central servers', 'id' => 'ditransmisikan ke server pusat'],
                        ],
                        'options' => [
                            'The telemetry data had been encrypted with military-grade standards before it was transmitted to central servers.',
                            'The telemetry data has been encrypted with military-grade standards before it was transmitted to central servers.',
                            'The telemetry data had encrypted with military-grade standards before it was transmitted to central servers.',
                            'The telemetry data had being encrypted with military-grade standards before it was transmitted to central servers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Enkripsi terjadi lebih awal ('had been encrypted') sebelum proses transmisi pasif ('was transmitted').",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Dana hibah penelitian telah dialokasikan sepenuhnya sebelum tahun anggaran berakhir.',
                        'target_word' => 'had been allocated (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'research endowment grants', 'id' => 'dana hibah penelitian'],
                            ['en' => 'fully allocated', 'id' => 'dialokasikan sepenuhnya'],
                            ['en' => 'fiscal cycle concluded', 'id' => 'tahun anggaran berakhir'],
                        ],
                        'options' => [
                            'The research endowment grants had been fully allocated before the official fiscal cycle concluded.',
                            'The research endowment grants have been fully allocated before the official fiscal cycle concluded.',
                            'The research endowment grants was being allocated before the official fiscal cycle concluded.',
                            'The research endowment grants had fully allocated before the official fiscal cycle concluded.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'grants' berpasangan dengan 'had been fully allocated'.",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Tiga puluh pasien telah direkrut sebelum uji klinis dihentikan sementara.',
                        'target_word' => 'had been enrolled ... was suspended (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'thirty eligible patients had been enrolled', 'id' => '30 pasien telah direkrut'],
                            ['en' => 'clinical study was suspended', 'id' => 'uji klinis dihentikan sementara'],
                        ],
                        'options' => [
                            'Thirty eligible patients had been enrolled before the clinical study was abruptly suspended.',
                            'Thirty eligible patients have been enrolled before the clinical study was abruptly suspended.',
                            'Thirty eligible patients were being enrolled before the clinical study was abruptly suspended.',
                            'Thirty eligible patients had enrolled before the clinical study was abruptly suspended.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Perekrutan 30 pasien selesai mendahului penghentian studi lampau: 'had been enrolled'.",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Peralatan kalibrasi telah dibersihkan secara steril sebelum pengujian kedua dimulai.',
                        'target_word' => 'had been sterilized (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'calibration instruments had been sterilized', 'id' => 'peralatan kalibrasi telah dibersihkan secara steril'],
                            ['en' => 'second trial run commenced', 'id' => 'pengujian kedua dimulai'],
                        ],
                        'options' => [
                            'The calibration instruments had been sterilized thoroughly before the second trial run commenced.',
                            'The calibration instruments have been sterilized thoroughly before the second trial run commenced.',
                            'The calibration instruments was being sterilized thoroughly before the second trial run commenced.',
                            'The calibration instruments had sterilized thoroughly before the second trial run commenced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Sterilisasi selesai mendahului pengujian kedua: 'had been sterilized'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Sistem peringatan dini telah dipasang di desa tersebut dua tahun sebelum banjir bandang melanda.',
                        'target_word' => 'had been installed (Past Perfect Passive with Time Gap)',
                        'vocab' => [
                            ['en' => 'early warning siren had been installed', 'id' => 'sistem peringatan dini telah dipasang'],
                            ['en' => 'two years prior', 'id' => 'dua tahun sebelumnya'],
                            ['en' => 'flash flood struck', 'id' => 'banjir bandang melanda'],
                        ],
                        'options' => [
                            'An early warning siren had been installed in the village two years before the catastrophic flood struck.',
                            'An early warning siren has been installed in the village two years before the catastrophic flood struck.',
                            'An early warning siren was being installed in the village two years before the catastrophic flood struck.',
                            'An early warning siren had installed in the village two years before the catastrophic flood struck.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemasangan sirene selesai 2 tahun sebelum bencana lampau terjadi: 'had been installed'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Kuesioner awal telah divalidasi oleh dewan pakar sebelum didistribusikan kepada responden.',
                        'target_word' => 'had been validated ... was distributed (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'preliminary survey had been validated', 'id' => 'kuesioner awal telah divalidasi'],
                            ['en' => 'expert panel', 'id' => 'dewan pakar'],
                            ['en' => 'distributed to respondents', 'id' => 'didistribusikan kepada responden'],
                        ],
                        'options' => [
                            'The preliminary survey had been validated by an expert panel before it was distributed to respondents.',
                            'The preliminary survey has been validated by an expert panel before it was distributed to respondents.',
                            'The preliminary survey had validated by an expert panel before it was distributed to respondents.',
                            'The preliminary survey was being validated by an expert panel before it was distributed to respondents.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Validasi instrumen tuntas sebelum proses distribusi dilakukan: 'had been validated'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Undang-undang lingkungan hidup tersebut telah disahkan oleh parlemen sebelum konferensi internasional dimulai.',
                        'target_word' => 'had been ratified (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'environmental statute had been ratified', 'id' => 'undang-undang telah disahkan/diratifikasi'],
                            ['en' => 'parliament', 'id' => 'parlemen'],
                            ['en' => 'international conference convened', 'id' => 'konferensi internasional dimulai/bersidang'],
                        ],
                        'options' => [
                            'The landmark environmental statute had been ratified by parliament before the summit convened.',
                            'The landmark environmental statute has been ratified by parliament before the summit convened.',
                            'The landmark environmental statute had ratified by parliament before the summit convened.',
                            'The landmark environmental statute was being ratified by parliament before the summit convened.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Ratifikasi undang-undang diselesaikan sebelum pertemuan puncak bersidang: 'had been ratified'.",
                    ],
                ]
            ],
            [
                'id' => 'timeline-connectors-sequencing',
                'name' => '1.12.6 Timeline Connectors & Conjunctions: By the time, Prior to, Once, When, While',
                'code' => '1.12.6',
                'concept_title' => 'Penghubung Linimasa Formal: By the time, Prior to, When, While',
                'concept_description' => "Menyusun kalimat kronologis yang kompleks membutuhkan penguasaan konjungsi waktu akademis. Pola 'By the time + Simple Past, Subject + Past Perfect' menandai bahwa tindakan telah selesai sebelum batas waktu tercapai. Sebaliknya, 'While + Past Continuous' menandai durasi simultan. Memilih tenses yang selaras dengan kata hubung adalah kunci ketepatan sintaksis.",
                'description' => "Menyusun kalimat kronologis yang kompleks membutuhkan penguasaan konjungsi waktu akademis. Pola 'By the time + Simple Past, Subject + Past Perfect' menandai bahwa tindakan telah selesai sebelum batas waktu tercapai. Sebaliknya, 'While + Past Continuous' menandai durasi simultan. Memilih tenses yang selaras dengan kata hubung adalah kunci ketepatan sintaksis.",
                'formula' => 'By the time + S + V2 (Past), S + had + V3 / had been V3 | While + S + was/were V-ing, S + V2',
                'rules' => [
                    "'By the time' + Simple Past mensyaratkan induk kalimat berbentuk Past Perfect ('By the time the ambulance arrived, the patient had recovered').",
                    "'Prior to' adalah preposisi formal yang diikuti Noun Phrase atau Gerund V-ing ('Prior to conducting the trial, the team had secured funding').",
                    "'While' mengawali klausa berdurasi sedang berlangsung (Past Continuous).",
                    "'Once' sebagai konjungsi lampau menghubungkan aksi tuntas dengan aksi berikutnya.",
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Menjelang saat pemadam kebakaran tiba, api telah melahap seluruh laboratorium kimia.',
                        'target_word' => 'By the time ... had engulfed (Timeline Connector: By the time)',
                        'vocab' => [
                            ['en' => 'by the time firefighters arrived', 'id' => 'menjelang saat pemadam kebakaran tiba'],
                            ['en' => 'had engulfed the chemical facility', 'id' => 'telah melahap fasilitas kimia'],
                        ],
                        'options' => [
                            'By the time firefighters arrived on the scene, the fire had engulfed the entire chemical facility.',
                            'By the time firefighters arrived on the scene, the fire has engulfed the entire chemical facility.',
                            'By the time firefighters had arrived on the scene, the fire engulfed the entire chemical facility.',
                            'By the time firefighters arrived on the scene, the fire was engulfing the entire chemical facility so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola baku 'By the time + Simple Past ('arrived')' mewajibkan induk kalimat menggunakan Past Perfect ('had engulfed').",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Sebelum memulai pengumpulan data lapangan, para peneliti telah memperoleh izin etik formal.',
                        'target_word' => 'Prior to commencing ... had secured (Prepositional Connectors)',
                        'vocab' => [
                            ['en' => 'prior to commencing field surveys', 'id' => 'sebelum memulai survei lapangan'],
                            ['en' => 'had secured formal ethical clearance', 'id' => 'telah memperoleh izin etik formal'],
                        ],
                        'options' => [
                            'Prior to commencing field data collection, researchers had secured formal ethical clearance.',
                            'Prior to commencing field data collection, researchers has secured formal ethical clearance.',
                            'Prior to commencing field data collection, researchers secured had formal ethical clearance.',
                            'Prior to commencing field data collection, researchers have secured formal ethical clearance back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa 'Prior to commencing' mendahului tindakan lampau, sehingga induk kalimat memakai 'had secured'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Menjelang tahun 2015, sebagian besar negara anggota telah mengadopsi standar emisi baru.',
                        'target_word' => 'By 2015 ... had adopted (Timeline Milestone: By [Year])',
                        'vocab' => [
                            ['en' => 'by 2015', 'id' => 'menjelang tahun 2015'],
                            ['en' => 'majority of member states', 'id' => 'sebagian besar negara anggota'],
                            ['en' => 'had adopted new emission thresholds', 'id' => 'telah mengadopsi standar emisi baru'],
                        ],
                        'options' => [
                            'By 2015, the vast majority of member states had adopted the stringent vehicle emission thresholds.',
                            'By 2015, the vast majority of member states has adopted the stringent vehicle emission thresholds.',
                            'By 2015, the vast majority of member states adopted had the stringent vehicle emission thresholds.',
                            'By 2015, the vast majority of member states have adopted the stringent vehicle emission thresholds back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Batas waktu lampau 'By 2015' mewajibkan Past Perfect 'had adopted'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Sementara para analis sedang memverifikasi angka-angka tersebut, direktur mengumumkan hasil kuartalan.',
                        'target_word' => 'While ... were cross-referencing ... announced (Simultaneous vs Interruption)',
                        'vocab' => [
                            ['en' => 'analysts were cross-referencing', 'id' => 'analis sedang memverifikasi'],
                            ['en' => 'financial figures', 'id' => 'angka-angka keuangan'],
                            ['en' => 'director announced quarterly results', 'id' => 'direktur mengumumkan hasil kuartalan'],
                        ],
                        'options' => [
                            'While analysts were cross-referencing the figures, the executive director announced quarterly results.',
                            'While analysts was cross-referencing the figures, the executive director announced quarterly results.',
                            'While analysts were cross-reference the figures, the executive director announced quarterly results.',
                            'While analysts were cross-referencing the figures, the executive director was announced quarterly results.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'While' + Past Continuous jamak 'were cross-referencing', disela oleh tindakan 'announced'.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Menjelang saat laporan dirilis ke publik, dewan telah merevisi rekomendasi kebijakan sebanyak dua kali.',
                        'target_word' => 'By the time ... had revised (By the time Sequence)',
                        'vocab' => [
                            ['en' => 'by the time report was released', 'id' => 'menjelang saat laporan dirilis'],
                            ['en' => 'board had revised policy recommendations', 'id' => 'dewan telah merevisi rekomendasi'],
                        ],
                        'options' => [
                            'By the time the report was released publicly, the board had revised its policy recommendations twice.',
                            'By the time the report was released publicly, the board has revised its policy recommendations twice.',
                            'By the time the report had been released publicly, the board revised its policy recommendations twice.',
                            'By the time the report was released publicly, the board revised had its policy recommendations twice.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the time' + Simple Past Pasif ('was released'), induk kalimat memakai Past Perfect 'had revised'.",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Sebelum uji coba acak dilakukan, para peneliti telah menguji senyawa tersebut pada sel mamalia.',
                        'target_word' => 'Prior to conducting ... had tested (Prior to + Gerund)',
                        'vocab' => [
                            ['en' => 'prior to conducting randomized trials', 'id' => 'sebelum melakukan uji coba acak'],
                            ['en' => 'had tested on mammalian cells', 'id' => 'telah menguji pada sel mamalia'],
                        ],
                        'options' => [
                            'Prior to conducting randomized trials, researchers had tested the compound on mammalian cell lines.',
                            'Prior to conducting randomized trials, researchers has tested the compound on mammalian cell lines.',
                            'Prior to conducting randomized trials, researchers had test the compound on mammalian cell lines.',
                            'Prior to conducting randomized trials, researchers have tested the compound on mammalian cell lines back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengujian pada sel selesai lebih dulu sebelum uji coba acak: 'had tested'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Begitu dewan menyetujui anggaran darurat, tim logistik segera memesan suku cadang pengganti.',
                        'target_word' => 'Once ... approved ... ordered (Immediate Sequence with Once)',
                        'vocab' => [
                            ['en' => 'once board approved funding', 'id' => 'begitu dewan menyetujui dana'],
                            ['en' => 'logistics unit ordered replacement parts', 'id' => 'tim logistik memesan suku cadang'],
                        ],
                        'options' => [
                            'Once the governing board approved emergency funding, the logistics unit ordered replacement parts.',
                            'Once the governing board had approved emergency funding, the logistics unit orders replacement parts.',
                            'Once the governing board approved emergency funding, the logistics unit was ordered replacement parts.',
                            'Once the governing board will approve emergency funding, the logistics unit ordered replacement parts.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Dua tindakan berurutan langsung yang saling terkait cepat di masa lalu menggunakan Simple Past: 'approved' disusul 'ordered'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Menjelang akhir abad kedua puluh, industrialisasi telah mengubah pola demografi perkotaan secara mendasar.',
                        'target_word' => 'By the close of ... had transformed (Milestone Past Perfect)',
                        'vocab' => [
                            ['en' => 'by the close of the twentieth century', 'id' => 'menjelang akhir abad ke-20'],
                            ['en' => 'industrialization had transformed', 'id' => 'industrialisasi telah mengubah'],
                            ['en' => 'urban demographics', 'id' => 'demografi perkotaan'],
                        ],
                        'options' => [
                            'By the close of the twentieth century, industrialization had transformed urban demographics fundamentally.',
                            'By the close of the twentieth century, industrialization has transformed urban demographics fundamentally.',
                            'By the close of the twentieth century, industrialization transformed had urban demographics fundamentally.',
                            'By the close of the twentieth century, industrialization was transformed urban demographics fundamentally.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the close of the twentieth century' adalah penanda waktu pembatas masa lampau yang mewajibkan 'had transformed'.",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Sementara vaksin sedang didistribusikan, epidemiolog terus melacak penyebaran varian patogen.',
                        'target_word' => 'While ... was being distributed ... tracked (Simultaneous Ongoing Passive + Active)',
                        'vocab' => [
                            ['en' => 'vaccine was being distributed', 'id' => 'vaksin sedang didistribusikan'],
                            ['en' => 'epidemiologists tracked pathogen spread', 'id' => 'epidemiolog melacak penyebaran patogen'],
                        ],
                        'options' => [
                            'While the initial vaccine batch was being distributed, epidemiologists tracked the spread of mutant variants.',
                            'While the initial vaccine batch were being distributed, epidemiologists tracked the spread of mutant variants.',
                            'While the initial vaccine batch was been distributed, epidemiologists tracked the spread of mutant variants.',
                            'While the initial vaccine batch was distributing, epidemiologists tracked the spread of mutant variants.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'While' memakai pasif continuous tunggal 'was being distributed', diiringi aksi utama 'tracked'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Sebelum pengadilan memutuskan perkara tersebut, para pihak yang bersengketa telah mencapai kesepakatan damai rahasia.',
                        'target_word' => 'Before court ruled ... had reached (Earlier Past Agreement)',
                        'vocab' => [
                            ['en' => 'court ruled on the dispute', 'id' => 'pengadilan memutuskan perkara'],
                            ['en' => 'disputing parties had reached settlement', 'id' => 'pihak bersengketa telah mencapai kesepakatan'],
                        ],
                        'options' => [
                            'Before the tribunal ruled on the dispute, the parties had reached a confidential out-of-court settlement.',
                            'Before the tribunal ruled on the dispute, the parties has reached a confidential out-of-court settlement.',
                            'Before the tribunal had ruled on the dispute, the parties reached a confidential out-of-court settlement.',
                            'Before the tribunal ruled on the dispute, the parties reached had a confidential out-of-court settlement.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kesepakatan tercapai lebih dahulu ('had reached') sebelum pengadilan memutuskan ('ruled').",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-continuous',
                'name' => '1.12.7 Past Perfect Continuous: Ongoing Duration Before a Past Event',
                'code' => '1.12.7',
                'concept_title' => 'Past Perfect Continuous: Durasi Tindakan Lampau Sebelum Terjadinya Peristiwa Lain',
                'concept_description' => "Past Perfect Continuous (had been + Verb-ing) digunakan untuk menekankan lamanya durasi (durative aspect) suatu tindakan yang sedang berlangsung dan berakumulasi di masa lalu sebelum titik waktu atau peristiwa lampau lainnya terjadi. Tense ini sangat umum dalam menyoroti lamanya usaha penelitian sebelum terobosan akhirnya tercapai ('Scientists had been investigating the phenomenon for decades before the breakthrough was achieved').",
                'description' => "Past Perfect Continuous (had been + Verb-ing) digunakan untuk menekankan lamanya durasi (durative aspect) suatu tindakan yang sedang berlangsung dan berakumulasi di masa lalu sebelum titik waktu atau peristiwa lampau lainnya terjadi. Tense ini sangat umum dalam menyoroti lamanya usaha penelitian sebelum terobosan akhirnya tercapai ('Scientists had been investigating the phenomenon for decades before the breakthrough was achieved').",
                'formula' => 'Subject + had been + Verb-ing + for/since (duration) + before / when + Simple Past Clause',
                'rules' => [
                    'Rumus baku: Subject + had been + Verb-ing + duration marker (for ten years, for hours).',
                    "Berlaku seragam untuk seluruh subjek tunggal dan jamak ('had been + V-ing').",
                    'Menekankan durasi proses yang sedang berjalan hingga disela atau dihentikan oleh peristiwa lampau (Simple Past).',
                    'Jangan gunakan stative verbs dalam bentuk continuous (*had been knowing adalah SALAH; gunakan Past Perfect simple: had known).',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Para ilmuwan telah meneliti fenomena tersebut selama beberapa dekade sebelum terobosan akhirnya tercapai.',
                        'target_word' => 'had been investigating ... was achieved (Durative Pre-Past Action)',
                        'vocab' => [
                            ['en' => 'had been investigating', 'id' => 'telah meneliti (berdurasi)'],
                            ['en' => 'for decades', 'id' => 'selama beberapa dekade'],
                            ['en' => 'breakthrough was achieved', 'id' => 'terobosan tercapai'],
                        ],
                        'options' => [
                            'Scientists had been investigating the phenomenon for decades before the definitive breakthrough was achieved.',
                            'Scientists have been investigating the phenomenon for decades before the definitive breakthrough was achieved.',
                            'Scientists were investigating the phenomenon for decades before the definitive breakthrough was achieved.',
                            'Scientists had investigating the phenomenon for decades before the definitive breakthrough was achieved.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Untuk menekankan proses riset berdurasi panjang ('for decades') yang mendahului terobosan lampau ('was achieved'), gunakan Past Perfect Continuous 'had been investigating'.",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Mesin tersebut telah mengeluarkan bunyi aneh selama berjam-jam sebelum bantalan utamanya patah.',
                        'target_word' => 'had been emitting ... snapped (Continuous Accumulation Before Failure)',
                        'vocab' => [
                            ['en' => 'engine had been emitting', 'id' => 'mesin telah mengeluarkan bunyi'],
                            ['en' => 'for hours', 'id' => 'selama berjam-jam'],
                            ['en' => 'main bearing snapped', 'id' => 'bantalan utama patah'],
                        ],
                        'options' => [
                            'The turbine engine had been emitting an unusual noise for hours before the main bearing snapped.',
                            'The turbine engine has been emitting an unusual noise for hours before the main bearing snapped.',
                            'The turbine engine was emitting an unusual noise for hours before the main bearing snapped.',
                            'The turbine engine had emitting an unusual noise for hours before the main bearing snapped.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bunyi aneh telah berlangsung akumulatif selama berjam-jam sebelum patah: 'had been emitting'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Keluarga pasien telah tinggal di dekat pabrik peleburan timbal selama bertahun-tahun sebelum gejala keracunan muncul.',
                        'target_word' => 'had been residing ... emerged (Durative Residence Before Symptom)',
                        'vocab' => [
                            ['en' => 'had been residing', 'id' => 'telah tinggal'],
                            ['en' => 'for years', 'id' => 'selama bertahun-tahun'],
                            ['en' => 'lead poisoning symptoms emerged', 'id' => 'gejala keracunan timbal muncul'],
                        ],
                        'options' => [
                            "The patient's family had been residing near the lead smelter for years before poisoning symptoms emerged.",
                            "The patient's family has been residing near the lead smelter for years before poisoning symptoms emerged.",
                            "The patient's family was residing near the lead smelter for years before poisoning symptoms emerged.",
                            "The patient's family had residing near the lead smelter for years before poisoning symptoms emerged.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tempat tinggal bertahun-tahun mendahului munculnya gejala lampau: 'had been residing'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Para ahli geologi telah memantau aktivitas seismik gunung berapi tersebut selama berminggu-minggu sebelum letusan terjadi.',
                        'target_word' => 'had been monitoring ... occurred (Monitoring Duration)',
                        'vocab' => [
                            ['en' => 'geologists had been monitoring', 'id' => 'ahli geologi telah memantau'],
                            ['en' => 'for weeks', 'id' => 'selama berminggu-minggu'],
                            ['en' => 'volcanic eruption occurred', 'id' => 'letusan gunung berapi terjadi'],
                        ],
                        'options' => [
                            'Geologists had been monitoring seismic activity on the volcano for weeks before the major eruption occurred.',
                            'Geologists have been monitoring seismic activity on the volcano for weeks before the major eruption occurred.',
                            'Geologists were monitoring seismic activity on the volcano for weeks before the major eruption occurred.',
                            'Geologists had monitoring seismic activity on the volcano for weeks before the major eruption occurred.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Aktivitas pemantauan berdurasi minggu-minggu sebelum erupsi lampau: 'had been monitoring'.",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Suhu larutan telah meningkat secara stabil selama tiga puluh menit sebelum mencapai titik didih.',
                        'target_word' => 'had been rising ... reached (Thermal Rise Duration)',
                        'vocab' => [
                            ['en' => 'solution temperature had been rising', 'id' => 'suhu larutan telah meningkat'],
                            ['en' => 'steadily for thirty minutes', 'id' => 'secara stabil selama 30 menit'],
                            ['en' => 'reached boiling point', 'id' => 'mencapai titik didih'],
                        ],
                        'options' => [
                            'The solution temperature had been rising steadily for thirty minutes before reaching boiling threshold.',
                            'The solution temperature has been rising steadily for thirty minutes before reaching boiling threshold.',
                            'The solution temperature was rising steadily for thirty minutes before reaching boiling threshold.',
                            'The solution temperature had rising steadily for thirty minutes before reaching boiling threshold.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been rising steadily for thirty minutes' menekankan durasi kenaikan suhu sebelum batas didih tercapai.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Para analis keuangan telah memperingatkan tentang gelembung pasar perumahan selama berbulan-bulan sebelum krisis perbankan melanda.',
                        'target_word' => 'had been warning ... struck (Warning Duration)',
                        'vocab' => [
                            ['en' => 'analysts had been warning', 'id' => 'para analis telah memperingatkan'],
                            ['en' => 'housing bubble for months', 'id' => 'gelembung perumahan selama berbulan-bulan'],
                            ['en' => 'banking crisis struck', 'id' => 'krisis perbankan melanda'],
                        ],
                        'options' => [
                            'Financial analysts had been warning of a real estate bubble for months before the banking crisis struck.',
                            'Financial analysts have been warning of a real estate bubble for months before the banking crisis struck.',
                            'Financial analysts were warning of a real estate bubble for months before the banking crisis struck.',
                            'Financial analysts had warning of a real estate bubble for months before the banking crisis struck.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been warning ... for months' melukiskan peringatan berkelanjutan sebelum krisis menerpa.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Program perangkat lunak tersebut telah berjalan tanpa kesalahan selama lima hari sebelum server crash mendadak.',
                        'target_word' => 'had been running ... crashed (Continuous Operation Before Crash)',
                        'vocab' => [
                            ['en' => 'software script had been running', 'id' => 'perangkat lunak telah berjalan'],
                            ['en' => 'without error for five days', 'id' => 'tanpa kesalahan selama lima hari'],
                            ['en' => 'server crashed unexpectedly', 'id' => 'server crash mendadak'],
                        ],
                        'options' => [
                            'The algorithmic script had been running without interruption for five days before the server crashed.',
                            'The algorithmic script has been running without interruption for five days before the server crashed.',
                            'The algorithmic script was running without interruption for five days before the server crashed.',
                            'The algorithmic script had running without interruption for five days before the server crashed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi operasi 5 hari tanpa henti diungkapkan dengan 'had been running'.",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Subjek penelitian telah berpuasa selama empat belas jam ketika perawat mengambil sampel darah pertama.',
                        'target_word' => 'had been fasting ... drew (Fasting Duration Before Event)',
                        'vocab' => [
                            ['en' => 'subjects had been fasting', 'id' => 'subjek telah berpuasa'],
                            ['en' => 'for fourteen hours', 'id' => 'selama 14 jam'],
                            ['en' => 'nurse drew the baseline blood sample', 'id' => 'perawat mengambil sampel darah'],
                        ],
                        'options' => [
                            'The trial subject had been fasting for fourteen hours when the nurse drew the baseline blood specimen.',
                            'The trial subject has been fasting for fourteen hours when the nurse drew the baseline blood specimen.',
                            'The trial subject was fasting for fourteen hours when the nurse drew the baseline blood specimen.',
                            'The trial subject had fasting for fourteen hours when the nurse drew the baseline blood specimen.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi puasa sebelum pengambilan sampel darah lampau: 'had been fasting'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Kedua diplomat telah menegosiasikan draf klausul perbatasan sepanjang malam sebelum mencapai kesepakatan akhir.',
                        'target_word' => 'had been negotiating ... reached (Overnight Negotiation Duration)',
                        'vocab' => [
                            ['en' => 'diplomats had been negotiating', 'id' => 'diplomat telah menegosiasikan'],
                            ['en' => 'all night', 'id' => 'sepanjang malam'],
                            ['en' => 'reached a final accord', 'id' => 'mencapai kesepakatan akhir'],
                        ],
                        'options' => [
                            'Both diplomats had been negotiating treaty clauses all night before reaching a final bilateral accord.',
                            'Both diplomats have been negotiating treaty clauses all night before reaching a final bilateral accord.',
                            'Both diplomats were negotiating treaty clauses all night before reaching a final bilateral accord.',
                            'Both diplomats had negotiating treaty clauses all night before reaching a final bilateral accord.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been negotiating ... all night' menekankan proses negosiasi berjam-jam sebelum kesepakatan dicapai.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Ketinggian air sungai telah meluap selama dua jam sebelum tanggul darurat akhirnya jebol.',
                        'target_word' => 'had been overflowing ... breached (Water Level Duration)',
                        'vocab' => [
                            ['en' => 'river had been overflowing', 'id' => 'sungai telah meluap'],
                            ['en' => 'for two hours', 'id' => 'selama dua jam'],
                            ['en' => 'earthen levee breached', 'id' => 'tanggul darurat jebol'],
                        ],
                        'options' => [
                            'The river had been overflowing its banks for two hours before the temporary earthen levee breached.',
                            'The river has been overflowing its banks for two hours before the temporary earthen levee breached.',
                            'The river was overflowing its banks for two hours before the temporary earthen levee breached.',
                            'The river had overflowing its banks for two hours before the temporary earthen levee breached.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi luapan 2 jam sebelum tanggul jebol: 'had been overflowing'.",
                    ],
                ]
            ],
            [
                'id' => 'timeline-methodology-synthesis',
                'name' => '1.12.8 Comprehensive Synthesis: Complex Timeline Sequencing in Methodology & Case Reports',
                'code' => '1.12.8',
                'concept_title' => 'Sintesis Linimasa Komprehensif: Penulisan Metodologi & Laporan Studi Kasus',
                'concept_description' => 'Menggabungkan Simple Past, Past Continuous, dan Past Perfect (aktif maupun pasif) ke dalam alur paragraf ilmiah yang utuh dan kohesif. Latihan ini melatih keterampilan menyusun bab Metodologi (Methods), tinjauan historis, kronologi investigasi klinis, dan analisis studi kasus tanpa kerancuan urutan waktu (timeline clarity) standar IELTS Band 8-9 dan jurnal internasional.',
                'description' => 'Menggabungkan Simple Past, Past Continuous, dan Past Perfect (aktif maupun pasif) ke dalam alur paragraf ilmiah yang utuh dan kohesif. Latihan ini melatih keterampilan menyusun bab Metodologi (Methods), tinjauan historis, kronologi investigasi klinis, dan analisis studi kasus tanpa kerancuan urutan waktu (timeline clarity) standar IELTS Band 8-9 dan jurnal internasional.',
                'formula' => 'Synthesized Multi-Tense Narrative: Past Background (Past Continuous) + Prior Milestone (Past Perfect) + Crucial Finding (Simple Past)',
                'rules' => [
                    "Gunakan Past Perfect untuk aksi persiapan atau kualifikasi awal ('After the patients had been screened...').",
                    "Gunakan Past Continuous untuk kegiatan operasional yang berlangsung ('...while instruments were recording...').",
                    "Gunakan Simple Past untuk peristiwa utama, interupsi, atau kesimpulan pengamatan ('...the team observed...').",
                    'Jaga konsistensi logika kronologi agar pembaca dapat merekonstruksi urutan eksperimen secara presisi.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Setelah sampel air tanah telah disaring dan disterilkan, para ilmuwan mengukur kontaminan sementara komputer sedang merekam data spektrometri.',
                        'target_word' => 'had been filtered ... measured ... was recording (Multi-Tense Sequence)',
                        'vocab' => [
                            ['en' => 'had been filtered and sterilized', 'id' => 'telah disaring dan disterilkan'],
                            ['en' => 'measured contaminants', 'id' => 'mengukur kontaminan'],
                            ['en' => 'computer was recording telemetry', 'id' => 'komputer sedang merekam data'],
                        ],
                        'options' => [
                            'After groundwater samples had been filtered and sterilized, scientists measured contaminants while the computer was recording telemetry.',
                            'After groundwater samples have been filtered and sterilized, scientists measured contaminants while the computer was recording telemetry.',
                            'After groundwater samples had been filtered and sterilized, scientists measured contaminants while the computer recorded telemetry.',
                            'After groundwater samples were filtered and sterilized, scientists had measured contaminants while the computer was recording telemetry.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kombinasi 3 lapisan waktu: Persiapan awal yang selesai ('had been filtered'), tindakan utama ('measured'), dan latar simultan yang sedang merekam ('was recording').",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Meskipun para insinyur telah menguji material sayap beberapa kali di laboratorium, retakan halus muncul saat prototipe sedang menjalani uji terowongan angin.',
                        'target_word' => 'had tested ... appeared ... was undergoing (Complex Experimental Narrative)',
                        'vocab' => [
                            ['en' => 'had tested the wing composite', 'id' => 'telah menguji material sayap'],
                            ['en' => 'microscopic fissure appeared', 'id' => 'retakan halus muncul'],
                            ['en' => 'was undergoing wind-tunnel testing', 'id' => 'sedang menjalani uji terowongan angin'],
                        ],
                        'options' => [
                            'Although engineers had tested the wing composite multiple times, a fissure appeared while the prototype was undergoing wind-tunnel trials.',
                            'Although engineers have tested the wing composite multiple times, a fissure appeared while the prototype was undergoing wind-tunnel trials.',
                            'Although engineers had tested the wing composite multiple times, a fissure was appeared while the prototype was undergoing wind-tunnel trials.',
                            'Although engineers tested the wing composite multiple times, a fissure appeared while the prototype underwent wind-tunnel trials.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengujian awal selesai ('had tested'), retakan tiba-tiba muncul ('appeared'), saat pengujian terowongan sedang berlangsung ('was undergoing').",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Sebelum protokol keselamatan baru diberlakukan, para staf telah memproses bahan kimia berbahaya tanpa perlindungan yang memadai.',
                        'target_word' => 'was enacted ... had been handling (Past Passive Boundary + Past Perfect Continuous)',
                        'vocab' => [
                            ['en' => 'safety protocol was enacted', 'id' => 'protokol keselamatan diberlakukan'],
                            ['en' => 'had been handling hazardous chemicals', 'id' => 'telah memproses bahan kimia berbahaya'],
                            ['en' => 'inadequate protective equipment', 'id' => 'perlindungan tidak memadai'],
                        ],
                        'options' => [
                            'Before the safety protocol was enacted, laboratory technicians had been handling hazardous reagents without adequate protective equipment.',
                            'Before the safety protocol has been enacted, laboratory technicians had been handling hazardous reagents without adequate protective equipment.',
                            'Before the safety protocol was enacted, laboratory technicians have been handling hazardous reagents without adequate protective equipment.',
                            'Before the safety protocol was enacted, laboratory technicians were handling hazardous reagents without adequate protective equipment so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penetapan regulasi pasif ('was enacted') didahului oleh kebiasaan penanganan berdurasi lama ('had been handling').",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Ketika dewan penyelidik tiba di lokasi pabrik, tim tanggap darurat telah mengevakuasi semua pekerja sementara teknisi sedang menstabilkan reaktor.',
                        'target_word' => 'arrived ... had evacuated ... were stabilizing (Cohesive Crisis Timeline)',
                        'vocab' => [
                            ['en' => 'investigative board arrived', 'id' => 'dewan penyelidik tiba'],
                            ['en' => 'had evacuated all plant personnel', 'id' => 'telah mengevakuasi semua pekerja'],
                            ['en' => 'technicians were stabilizing the cooling unit', 'id' => 'teknisi sedang menstabilkan reaktor'],
                        ],
                        'options' => [
                            'When the investigative board arrived, emergency crews had evacuated all personnel while technicians were stabilizing the cooling unit.',
                            'When the investigative board arrived, emergency crews has evacuated all personnel while technicians were stabilizing the cooling unit.',
                            'When the investigative board had arrived, emergency crews evacuated all personnel while technicians were stabilizing the cooling unit.',
                            'When the investigative board arrived, emergency crews were evacuated all personnel while technicians were stabilizing the cooling unit.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedatangan ('arrived') menjumpai evakuasi yang sudah tuntas ('had evacuated') dan tindakan stabilisasi yang masih berlangsung ('were stabilizing').",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Karena data uji coba tahap awal telah menunjukkan efikasi yang tinggi, komite menyetujui percepatan izin sementara produksi sedang ditingkatkan.',
                        'target_word' => 'had demonstrated ... approved ... was being scaled up (Complex Rationalization)',
                        'vocab' => [
                            ['en' => 'had demonstrated high clinical efficacy', 'id' => 'telah menunjukkan efikasi tinggi'],
                            ['en' => 'committee approved expedited review', 'id' => 'komite menyetujui percepatan izin'],
                            ['en' => 'manufacturing was being scaled up', 'id' => 'produksi sedang ditingkatkan'],
                        ],
                        'options' => [
                            'Because early data had demonstrated high clinical efficacy, the committee approved expedited review while manufacturing was being scaled up.',
                            'Because early data has demonstrated high clinical efficacy, the committee approved expedited review while manufacturing was being scaled up.',
                            'Because early data had demonstrated high clinical efficacy, the committee had approved expedited review while manufacturing was scaled up.',
                            'Because early data demonstrated high clinical efficacy, the committee approved expedited review while manufacturing was been scaled up.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bukti data sudah ada lebih dahulu ('had demonstrated'), persetujuan dikeluarkan ('approved'), sementara peningkatan pabrikasi pasif sedang berlangsung ('was being scaled up').",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Menjelang saat konferensi pers dimulai, para astronom telah mengonfirmasi bahwa sinyal yang sedang mereka lacak berasal dari pulsar berotasi cepat.',
                        'target_word' => 'began ... had confirmed ... were tracking (Multi-Layer Astronomical Narrative)',
                        'vocab' => [
                            ['en' => 'press briefing began', 'id' => 'konferensi pers dimulai'],
                            ['en' => 'had confirmed', 'id' => 'telah mengonfirmasi'],
                            ['en' => 'signal they were tracking', 'id' => 'sinyal yang sedang mereka lacak'],
                            ['en' => 'rapidly rotating pulsar', 'id' => 'pulsar berotasi cepat'],
                        ],
                        'options' => [
                            'By the time the press briefing began, astronomers had confirmed that the signal they were tracking originated from a rotating pulsar.',
                            'By the time the press briefing began, astronomers has confirmed that the signal they were tracking originated from a rotating pulsar.',
                            'By the time the press briefing had begun, astronomers confirmed that the signal they were tracking originated from a rotating pulsar.',
                            'By the time the press briefing began, astronomers had confirmed that the signal they tracked was originated from a rotating pulsar.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the time' + Simple Past ('began'), induk kalimat Past Perfect ('had confirmed'), memuat relative clause pelacakan yang sedang berlangsung ('were tracking').",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Setelah pasien telah menjalani prosedur pemindaian MRI, dokter mendiagnosis cedera ligamen saat pasien sedang beristirahat di ruang observasi.',
                        'target_word' => 'had undergone ... diagnosed ... was resting (Clinical Case Sequence)',
                        'vocab' => [
                            ['en' => 'had undergone MRI scanning', 'id' => 'telah menjalani pemindaian MRI'],
                            ['en' => 'physician diagnosed ligament damage', 'id' => 'dokter mendiagnosis cedera ligamen'],
                            ['en' => 'patient was resting in recovery', 'id' => 'pasien sedang beristirahat'],
                        ],
                        'options' => [
                            'After the patient had undergone MRI scanning, the physician diagnosed ligament damage while the patient was resting in recovery.',
                            'After the patient has undergone MRI scanning, the physician diagnosed ligament damage while the patient was resting in recovery.',
                            'After the patient had undergone MRI scanning, the physician was diagnosed ligament damage while the patient was resting in recovery.',
                            'After the patient underwent MRI scanning, the physician had diagnosed ligament damage while the patient was resting in recovery.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Prosedur MRI selesai lebih dulu ('had undergone'), diagnosis ditegakkan ('diagnosed'), saat pasien sedang beristirahat ('was resting').",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Populasi satwa liar di cagar alam tersebut telah menyusut selama bertahun-tahun sebelum pemerintah memberlakukan undang-undang anti-perburuan liar.',
                        'target_word' => 'had been dwindling ... enacted (Ecological Trend Sequence)',
                        'vocab' => [
                            ['en' => 'wildlife population had been dwindling', 'id' => 'populasi satwa telah menyusut'],
                            ['en' => 'for years', 'id' => 'selama bertahun-tahun'],
                            ['en' => 'government enacted anti-poaching legislation', 'id' => 'pemerintah memberlakukan undang-undang'],
                        ],
                        'options' => [
                            'The wildlife population in the sanctuary had been dwindling for years before the government enacted stringent anti-poaching legislation.',
                            'The wildlife population in the sanctuary has been dwindling for years before the government enacted stringent anti-poaching legislation.',
                            'The wildlife population in the sanctuary was dwindling for years before the government had enacted stringent anti-poaching legislation.',
                            'The wildlife population in the sanctuary had dwindling for years before the government enacted stringent anti-poaching legislation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penyusutan berdurasi panjang sebelum pengesahan undang-undang lampau: 'had been dwindling'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Ketika audit independen selesai, perusahaan telah menyelesaikan restrukturisasi utang sementara auditor sedang menyusun laporan kepatuhan akhir.',
                        'target_word' => 'concluded ... had finalized ... were drafting (Corporate Case Sequence)',
                        'vocab' => [
                            ['en' => 'audit concluded', 'id' => 'audit selesai'],
                            ['en' => 'had finalized debt restructuring', 'id' => 'telah menyelesaikan restrukturisasi utang'],
                            ['en' => 'auditors were drafting the compliance report', 'id' => 'auditor sedang menyusun laporan'],
                        ],
                        'options' => [
                            'When the external audit concluded, the corporation had finalized debt restructuring while examiners were drafting the compliance report.',
                            'When the external audit concluded, the corporation has finalized debt restructuring while examiners were drafting the compliance report.',
                            'When the external audit had concluded, the corporation finalized debt restructuring while examiners were drafting the compliance report.',
                            'When the external audit concluded, the corporation had finalized debt restructuring while examiners drafted the compliance report.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'concluded' (titik waktu lampau) mendapati restrukturisasi telah selesai ('had finalized') dan laporan sedang disusun ('were drafting').",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Laporan akhir mengonfirmasi bahwa peneliti telah memverifikasi semua parameter uji coba sebelum data diserahkan, yang memastikan bahwa seluruh prosedur telah mematuhi pedoman internasional.',
                        'target_word' => 'confirmed ... had verified ... was submitted ... complied (Research Milestone Climax)',
                        'vocab' => [
                            ['en' => 'final report confirmed', 'id' => 'laporan akhir mengonfirmasi'],
                            ['en' => 'had verified all testing parameters', 'id' => 'telah memverifikasi semua parameter'],
                            ['en' => 'data was submitted', 'id' => 'data diserahkan'],
                            ['en' => 'complied with international standards', 'id' => 'mematuhi standar internasional'],
                        ],
                        'options' => [
                            'The report confirmed that investigators had verified all testing parameters before data was submitted, ensuring the protocol complied with standards.',
                            'The report confirmed that investigators have verified all testing parameters before data was submitted, ensuring the protocol complied with standards.',
                            'The report had confirmed that investigators verified all testing parameters before data was submitted, ensuring the protocol complied with standards.',
                            'The report confirmed that investigators had verified all testing parameters before data was submitted, ensuring the protocol has complied with standards.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Sintesis linimasa multi-klausa: Laporan mengonfirmasi ('confirmed') bahwa peneliti telah memverifikasi lebih dulu ('had verified') sebelum data diserahkan ('was submitted') dan memastikan protokol mematuhi ('complied').",
                    ],
                ]
            ],
        ];
    }
}
