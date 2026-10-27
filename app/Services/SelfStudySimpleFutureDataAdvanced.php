<?php

namespace App\Services;

class SelfStudySimpleFutureDataAdvanced
{
    /**
     * Get the complete Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive) package.
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
            'banner_title' => 'Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive) in Academic Writing',
            'banner_subtitle' => 'Kuasai proyeksi masa depan, prediksi berbasis bukti (be going to), rekomendasi riset (will + V1), status kondisi masa depan (will be + Adj/Noun), metodologi pasif terencana (will be + V3), serta aturan ketat larangan will dalam klausa waktu (No Future in Time Clauses).',
            'banner_badge' => 'MODULE 1.11 SIMPLE FUTURE TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.11
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Simple Future Tense: Proyeksi, Rekomendasi, & Perencanaan Metodologi Ilmiah',
            'concept_summary' => 'Simple Future Tense dalam penulisan akademis dan esai formal (IELTS Academic Task 2 & Research Proposals) digunakan untuk merumuskan implikasi jangka panjang, rekomendasi kebijakan, proyeksi dampak teknologi, dan tahapan metodologi yang akan dijalankan. Penulis harus menguasai secara presisi perbedaan antara proyeksi formal ("will"), prediksi berbasis bukti data nyata ("be going to"), bentuk nominal ("will be"), bentuk pasif metodologis ("will be + V3"), dan aturan mutlak larangan penggunaan "will" dalam klausa penunjuk waktu (Time Clauses).',
            'rules' => [
                [
                    'rule_title' => '1. Simple Future Verbal Aktif: Will + Verb 1 (Base Form)',
                    'rule_formula' => 'Subject + will + Verb 1 (Bare Infinitive) + Object',
                    'rule_description' => 'Gunakan "will + V1" untuk seluruh subjek tunggal dan jamak saat menyampaikan rekomendasi atau prediksi umum. Kata kerja setelah "will" wajib berbentuk dasar tanpa akhiran -s, -ed, atau -ing. Hindari singkatan informal (tulis "will not", bukan "won\\\'t").',
                    'examples' => [
                        [
                            'en' => 'The implementation of this technology will enhance operational efficiency.',
                            'id' => 'Penerapan teknologi ini akan meningkatkan efisiensi operasional.',
                            'note' => '"will" langsung diikuti kata kerja dasar murni "enhance".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Prediksi Berbasis Bukti Nyata: Be Going To + V1',
                    'rule_formula' => 'Subject + am/is/are + going to + Verb 1 (Base Form)',
                    'rule_description' => 'Gunakan "be going to" jika ada bukti data konkret saat ini yang mengindikasikan suatu kepastian hasil, atau jika suatu proyek telah direncanakan secara definitif dalam agenda institusi.',
                    'examples' => [
                        [
                            'en' => 'Based on the current trajectory, urban carbon emissions are going to exceed safe thresholds.',
                            'id' => 'Berdasarkan lintasan saat ini, emisi karbon perkotaan akan melampaui batas aman.',
                            'note' => 'Didukung oleh bukti data tren yang sedang berlangsung ("current trajectory").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Nominal Masa Depan: Will Be & Be Going To Be',
                    'rule_formula' => 'Subject + will be / is/are going to be + Adjective / Noun Phrase / Prepositional Phrase',
                    'rule_description' => 'Menyatakan status, sifat, atau kondisi keberadaan subjek di masa mendatang. Kata "be" wajib hadir sebagai kopula sebelum kata sifat, nomina, atau preposisi.',
                    'examples' => [
                        [
                            'en' => 'The new transport infrastructure will be highly beneficial to rural communities.',
                            'id' => 'Infrastruktur transportasi baru tersebut akan sangat bermanfaat bagi masyarakat perdesaan.',
                            'note' => 'Dilarang meniadakan "be" (*will beneficial adalah SALAH).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Bentuk Pasif Metodologis Ilmiah: Will Be + Verb 3 (Past Participle)',
                    'rule_formula' => 'Passive Subject + will be + Verb 3 (Past Participle) + (by Agent)',
                    'rule_description' => 'Pola dominan dalam bab Proposal Penelitian (Research Proposal) dan rencana intervensi kebijakan. Fokus kalimat diletakkan pada prosedur yang akan dikenakan terhadap sampel atau populasi.',
                    'examples' => [
                        [
                            'en' => 'Soil samples will be collected on a weekly basis to monitor changing acidity levels.',
                            'id' => 'Sampel tanah akan dikumpulkan setiap minggu untuk memantau tingkat keasaman.',
                            'note' => '"will be collected" memaparkan prosedur pengumpulan sampel terencana.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Aturan Larangan "Will" dalam Klausa Waktu (No Future in Time Clauses)',
                    'rule_formula' => 'Time Conjunction (When/Once/As soon as/Before) + S + Verb 1/V-s (Simple Present), Main Clause (will + V1)',
                    'rule_description' => 'Anak kalimat yang diawali oleh konjungsi waktu (when, as soon as, once, before, after, until) atau syarat (if, unless) DILARANG KERAS menggunakan "will". Gunakan Simple Present di anak kalimat, dan letakkan "will" hanya di induk kalimat.',
                    'examples' => [
                        [
                            'en' => 'When the sensor detects an anomaly, the emergency system will shut down the reactor.',
                            'id' => 'Ketika sensor mendeteksi anomali, sistem darurat akan mematikan reaktor.',
                            'note' => 'Gunakan "detects" (Simple Present), BUKAN *will detect.'
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
                'id' => 'future-verbal-will',
                'name' => "1.11.1 Simple Future Verbal with 'Will': Future Projections & Research Recommendations",
                'code' => '1.11.1',
                'concept_title' => 'Simple Future Verbal (Will): Proyeksi Masa Depan & Rekomendasi Riset',
                'concept_description' => "Simple Future Verbal dengan modal auxiliary 'will' adalah instrumen standar penulisan akademis untuk menyusun proyeksi objektif, merumuskan implikasi masa depan, dan menyampaikan rekomendasi riset dalam bab Kesimpulan (Discussion & Conclusion). Strukturnya tidak bergantung pada subjek tunggal atau jamak: selalu gunakan 'will' diikuti kata kerja dasar murni (Bare Infinitive / V1) tanpa akhiran -s, -ed, atau -ing.",
                'description' => "Simple Future Verbal dengan modal auxiliary 'will' adalah instrumen standar penulisan akademis untuk menyusun proyeksi objektif, merumuskan implikasi masa depan, dan menyampaikan rekomendasi riset dalam bab Kesimpulan (Discussion & Conclusion). Strukturnya tidak bergantung pada subjek tunggal atau jamak: selalu gunakan 'will' diikuti kata kerja dasar murni (Bare Infinitive / V1) tanpa akhiran -s, -ed, atau -ing.",
                'formula' => 'Subject + will + Verb 1 (Base Form) + Object / Complement',
                'rules' => [
                    "Gunakan 'will + V1' untuk seluruh jenis subjek, baik tunggal (the author, this algorithm) maupun jamak (researchers, policies).",
                    "Kata kerja setelah 'will' wajib berbentuk dasar (Bare Infinitive): will enhance, will provide, will examine.",
                    'Dilarang menambahkan to be sebelum V1 aktif (*will is enhance, *will to provide adalah SALAH).',
                    "Dalam register formal akademis, hindari kontraksi informal seperti 'it'll' atau 'they'll'; tulis secara utuh 'it will' dan 'they will'.",
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Penerapan teknologi ini akan meningkatkan efisiensi operasional pabrik manufaktur.',
                        'target_word' => 'will enhance (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'implementation', 'id' => 'penerapan'],
                            ['en' => 'operational efficiency', 'id' => 'efisiensi operasional'],
                            ['en' => 'manufacturing facility', 'id' => 'pabrik manufaktur'],
                        ],
                        'options' => [
                            'The implementation of this technology will enhance the operational efficiency of the manufacturing facility.',
                            'The implementation of this technology will enhances the operational efficiency of the manufacturing facility.',
                            'The implementation of this technology will to enhance the operational efficiency of the manufacturing facility.',
                            'The implementation of this technology is will enhance the operational efficiency of the manufacturing facility.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah modal auxiliary 'will', kata kerja wajib berbentuk dasar (Bare Infinitive) 'enhance' tanpa akhiran -s atau partikel 'to'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Para peneliti akan mempublikasikan data sekuensing genom dalam jurnal akses terbuka bulan depan.',
                        'target_word' => 'will publish (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'researchers', 'id' => 'para peneliti'],
                            ['en' => 'genome sequencing data', 'id' => 'data sekuensing genom'],
                            ['en' => 'open-access journal', 'id' => 'jurnal akses terbuka'],
                        ],
                        'options' => [
                            'Researchers will publish the complete genome sequencing data in an open-access journal next month.',
                            'Researchers will publishes the complete genome sequencing data in an open-access journal next month.',
                            'Researchers will published the complete genome sequencing data in an open-access journal next month.',
                            'Researchers are will publish the complete genome sequencing data in an open-access journal next month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Researchers' dipadukan dengan modal 'will' + V1 'publish'. Pilihan C salah menggunakan V2/V3.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Model pembelajaran mesin baru ini akan memprediksi pola konsumsi energi dengan akurasi yang lebih tinggi.',
                        'target_word' => 'will predict (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'machine learning model', 'id' => 'model pembelajaran mesin'],
                            ['en' => 'energy consumption patterns', 'id' => 'pola konsumsi energi'],
                            ['en' => 'greater accuracy', 'id' => 'akurasi yang lebih tinggi'],
                        ],
                        'options' => [
                            'This novel machine learning model will predict energy consumption patterns with greater accuracy.',
                            'This novel machine learning model will predicts energy consumption patterns with greater accuracy.',
                            'This novel machine learning model will predicting energy consumption patterns with greater accuracy.',
                            'This novel machine learning model will be predict energy consumption patterns with greater accuracy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Modal 'will' langsung diikuti V1 murni 'predict'. Bentuk 'will predicts' melanggar aturan sintaksis modal.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Kebijakan fiskal yang diusulkan akan mendorong investasi swasta dalam proyek infrastruktur hijau.',
                        'target_word' => 'will stimulate (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'proposed fiscal policy', 'id' => 'kebijakan fiskal yang diusulkan'],
                            ['en' => 'private investment', 'id' => 'investasi swasta'],
                            ['en' => 'green infrastructure projects', 'id' => 'proyek infrastruktur hijau'],
                        ],
                        'options' => [
                            'The proposed fiscal policy will stimulate private investment in green infrastructure projects.',
                            'The proposed fiscal policy will stimulates private investment in green infrastructure projects.',
                            'The proposed fiscal policy will stimulated private investment in green infrastructure projects.',
                            'The proposed fiscal policy is will stimulate private investment in green infrastructure projects.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will stimulate' adalah konstruksi verbal aktif masa depan yang benar; tidak boleh ditambah to be 'is' di depannya.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Studi lanjutan akan menyelidiki efek samping jangka panjang dari senyawa terapeutik tersebut.',
                        'target_word' => 'will investigate (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'further studies', 'id' => 'studi lanjutan'],
                            ['en' => 'investigate', 'id' => 'menyelidiki'],
                            ['en' => 'long-term adverse effects', 'id' => 'efek samping jangka panjang'],
                        ],
                        'options' => [
                            'Further studies will investigate the long-term adverse effects of the therapeutic compound.',
                            'Further studies will investigates the long-term adverse effects of the therapeutic compound.',
                            'Further studies will to investigate the long-term adverse effects of the therapeutic compound.',
                            'Further studies will investigating the long-term adverse effects of the therapeutic compound.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rekomendasi riset di bagian akhir naskah akademik lazim menggunakan 'Further studies will investigate...'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Pemerintah kota akan memperluas jaringan jalur sepeda untuk mengurangi kemacetan lalu lintas.',
                        'target_word' => 'will expand (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'municipal government', 'id' => 'pemerintah kota'],
                            ['en' => 'expand the network', 'id' => 'memperluas jaringan'],
                            ['en' => 'traffic congestion', 'id' => 'kemacetan lalu lintas'],
                        ],
                        'options' => [
                            'The municipal government will expand the dedicated cycling network to alleviate traffic congestion.',
                            'The municipal government will expands the dedicated cycling network to alleviate traffic congestion.',
                            'The municipal government will expanded the dedicated cycling network to alleviate traffic congestion.',
                            'The municipal government will to expand the dedicated cycling network to alleviate traffic congestion.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk dasar 'expand' wajib digunakan setelah 'will'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Kenaikan permukaan air laut akan mengancam pemukiman pesisir dataran rendah dalam beberapa dekade mendatang.',
                        'target_word' => 'will threaten (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'sea level rise', 'id' => 'kenaikan permukaan air laut'],
                            ['en' => 'low-lying coastal settlements', 'id' => 'pemukiman pesisir dataran rendah'],
                            ['en' => 'coming decades', 'id' => 'beberapa dekade mendatang'],
                        ],
                        'options' => [
                            'Sea level rise will threaten low-lying coastal settlements over the coming decades.',
                            'Sea level rise will threatens low-lying coastal settlements over the coming decades.',
                            'Sea level rise will threatened low-lying coastal settlements over the coming decades.',
                            'Sea level rise is will threaten low-lying coastal settlements over the coming decades.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will threaten' memaparkan proyeksi bahaya ekologis masa depan dengan kata kerja dasar.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Universitas akan memperkenalkan program beasiswa baru bagi mahasiswa dari wilayah tertinggal.',
                        'target_word' => 'will introduce (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'university', 'id' => 'universitas'],
                            ['en' => 'scholarship initiative', 'id' => 'program beasiswa'],
                            ['en' => 'underrepresented regions', 'id' => 'wilayah tertinggal'],
                        ],
                        'options' => [
                            'The university will introduce a new scholarship initiative for students from underrepresented regions.',
                            'The university will introduces a new scholarship initiative for students from underrepresented regions.',
                            'The university will introduced a new scholarship initiative for students from underrepresented regions.',
                            'The university will to introduce a new scholarship initiative for students from underrepresented regions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The university' diikuti modal 'will' + V1 'introduce'.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Transisi menuju energi surya akan menurunkan ketergantungan negara pada bahan bakar fosil impor.',
                        'target_word' => 'will decrease (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'transition toward solar energy', 'id' => 'transisi menuju energi surya'],
                            ['en' => 'decrease reliance', 'id' => 'menurunkan ketergantungan'],
                            ['en' => 'imported fossil fuels', 'id' => 'bahan bakar fosil impor'],
                        ],
                        'options' => [
                            "The transition toward solar energy will decrease the nation's reliance on imported fossil fuels.",
                            "The transition toward solar energy will decreases the nation's reliance on imported fossil fuels.",
                            "The transition toward solar energy will decreased the nation's reliance on imported fossil fuels.",
                            "The transition toward solar energy is will decrease the nation's reliance on imported fossil fuels.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek frase panjang 'The transition toward solar energy' berpredikat 'will decrease'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Para ekonom memperkirakan bahwa inflasi akan stabil pada kuartal ketiga tahun depan.',
                        'target_word' => 'will stabilize (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'economists project', 'id' => 'para ekonom memperkirakan'],
                            ['en' => 'inflation', 'id' => 'inflasi'],
                            ['en' => 'stabilize', 'id' => 'stabil/menjadi stabil'],
                        ],
                        'options' => [
                            'Economists project that headline inflation will stabilize in the third quarter of next year.',
                            'Economists project that headline inflation will stabilizes in the third quarter of next year.',
                            'Economists project that headline inflation will stabilized in the third quarter of next year.',
                            'Economists project that headline inflation will to stabilize in the third quarter of next year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa proyeksi ekonomi menggunakan modal masa depan 'will stabilize'.",
                    ],
                ]
            ],
            [
                'id' => 'future-be-going-to',
                'name' => "1.11.2 Simple Future with 'Be Going To': Evidence-Based Predictions & Pre-Planned Projects",
                'code' => '1.11.2',
                'concept_title' => 'Simple Future (Be Going To): Prediksi Berbasis Bukti & Rencana Matang',
                'concept_description' => "Konstruksi 'be going to' digunakan secara khusus dalam analisis data dan laporan studi kasus ketika ada bukti empiris nyata saat ini (present tangible evidence) yang mengarah kuat pada hasil masa depan, atau ketika suatu program telah diputuskan secara definitif oleh institusi. Auxiliary 'be' diselaraskan dengan subjek (is / am / are) diikuti 'going to' dan kata kerja dasar (V1).",
                'description' => "Konstruksi 'be going to' digunakan secara khusus dalam analisis data dan laporan studi kasus ketika ada bukti empiris nyata saat ini (present tangible evidence) yang mengarah kuat pada hasil masa depan, atau ketika suatu program telah diputuskan secara definitif oleh institusi. Auxiliary 'be' diselaraskan dengan subjek (is / am / are) diikuti 'going to' dan kata kerja dasar (V1).",
                'formula' => 'Subject + am/is/are + going to + Verb 1 (Base Form) + Object',
                'rules' => [
                    "Selaraskan to be dengan subjek: 'is going to' (tunggal), 'are going to' (jamak), 'am going to' (I).",
                    "Setelah 'going to', kata kerja wajib berbentuk dasar V1 murni (Bare Infinitive).",
                    "Gunakan 'be going to' saat ada bukti faktual saat ini (misal: 'Looking at these data trends, temperatures are going to exceed...').",
                    'Jangan menghilangkan to be (*The team going to launch adalah SALAH).',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Berdasarkan lintasan saat ini, emisi karbon perkotaan akan melampaui batas aman sebelum akhir dekade.',
                        'target_word' => 'are going to exceed (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'current trajectory', 'id' => 'lintasan saat ini'],
                            ['en' => 'urban carbon emissions', 'id' => 'emisi karbon perkotaan'],
                            ['en' => 'exceed safe thresholds', 'id' => 'melampaui batas aman'],
                        ],
                        'options' => [
                            'Based on the current trajectory, urban carbon emissions are going to exceed safe thresholds before 2030.',
                            'Based on the current trajectory, urban carbon emissions is going to exceed safe thresholds before 2030.',
                            'Based on the current trajectory, urban carbon emissions are going to exceeding safe thresholds before 2030.',
                            'Based on the current trajectory, urban carbon emissions going to exceed safe thresholds before 2030.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'emissions' memerlukan to be 'are' + 'going to exceed'. Ada bukti empiris ('Based on the current trajectory') yang mendasari prediksi.",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Mengingat laju pencairan gletser yang pesat, permukaan air laut diperkirakan akan naik secara drastis.',
                        'target_word' => 'is going to rise (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'rapid glacier melting rate', 'id' => 'laju pencairan gletser yang pesat'],
                            ['en' => 'sea level', 'id' => 'permukaan air laut'],
                            ['en' => 'rise drastically', 'id' => 'naik secara drastis'],
                        ],
                        'options' => [
                            'Given the rapid rate of glacier melting, the regional sea level is going to rise drastically.',
                            'Given the rapid rate of glacier melting, the regional sea level are going to rise drastically.',
                            'Given the rapid rate of glacier melting, the regional sea level is going to rising drastically.',
                            'Given the rapid rate of glacier melting, the regional sea level going to rise drastically.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'the regional sea level' berpasangan dengan 'is going to rise'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Universitas tersebut akan meluncurkan pusat penelitian kuantum baru pada semester depan.',
                        'target_word' => 'is going to launch (Pre-Planned Project)',
                        'vocab' => [
                            ['en' => 'university', 'id' => 'universitas'],
                            ['en' => 'launch a new quantum research center', 'id' => 'meluncurkan pusat penelitian kuantum baru'],
                            ['en' => 'next semester', 'id' => 'semester depan'],
                        ],
                        'options' => [
                            'The university is going to launch a new quantum research center next academic semester.',
                            'The university are going to launch a new quantum research center next academic semester.',
                            'The university is going to launches a new quantum research center next academic semester.',
                            'The university is going to launched a new quantum research center next academic semester.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rencana institusi yang telah dipersiapkan memakai 'is going to launch' dengan kata kerja dasar 'launch'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Melihat tanda-tanda kelelahan material pada sayap pesawat, para insinyur akan mengganti komponen tersebut.',
                        'target_word' => 'are going to replace (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'signs of material fatigue', 'id' => 'tanda-tanda kelelahan material'],
                            ['en' => 'engineers', 'id' => 'para insinyur'],
                            ['en' => 'replace the component', 'id' => 'mengganti komponen'],
                        ],
                        'options' => [
                            'Noticing clear signs of material fatigue, engineers are going to replace the structural component.',
                            'Noticing clear signs of material fatigue, engineers is going to replace the structural component.',
                            'Noticing clear signs of material fatigue, engineers are going to replacing the structural component.',
                            'Noticing clear signs of material fatigue, engineers going to replace the structural component.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'engineers' berpasangan dengan 'are going to replace'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Dengan tingginya angka pengangguran pemuda saat ini, perekonomian akan menghadapi tantangan konsumsi yang berat.',
                        'target_word' => 'is going to face (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'high youth unemployment', 'id' => 'tingginya angka pengangguran pemuda'],
                            ['en' => 'domestic economy', 'id' => 'perekonomian domestik'],
                            ['en' => 'severe consumption challenges', 'id' => 'tantangan konsumsi yang berat'],
                        ],
                        'options' => [
                            'With high youth unemployment rates, the domestic economy is going to face severe consumption challenges.',
                            'With high youth unemployment rates, the domestic economy are going to face severe consumption challenges.',
                            'With high youth unemployment rates, the domestic economy is going to facing severe consumption challenges.',
                            'With high youth unemployment rates, the domestic economy going to face severe consumption challenges.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'the domestic economy' menggunakan 'is going to face'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Dewan direksi akan meninjau kembali strategi investasi tahunan pada pertemuan luar biasa minggu depan.',
                        'target_word' => 'is going to reassess (Pre-Planned Decision)',
                        'vocab' => [
                            ['en' => 'board of directors', 'id' => 'dewan direksi'],
                            ['en' => 'reassess the investment strategy', 'id' => 'meninjau kembali strategi investasi'],
                            ['en' => 'extraordinary meeting', 'id' => 'pertemuan luar biasa'],
                        ],
                        'options' => [
                            "The board of directors is going to reassess the annual investment strategy at next week's extraordinary meeting.",
                            "The board of directors are going to reassess the annual investment strategy at next week's extraordinary meeting.",
                            "The board of directors is going to reassessing the annual investment strategy at next week's extraordinary meeting.",
                            "The board of directors going to reassess the annual investment strategy at next week's extraordinary meeting.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Collective noun 'The board of directors' sebagai entitas tunggal memakai 'is going to reassess'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Karena cadangan air waduk menipis secara kritis, otoritas setempat akan memberlakukan pembatasan air.',
                        'target_word' => 'are going to impose (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'reservoir reserves critically depleted', 'id' => 'cadangan air waduk menipis secara kritis'],
                            ['en' => 'local authorities', 'id' => 'otoritas setempat'],
                            ['en' => 'impose water restrictions', 'id' => 'memberlakukan pembatasan air'],
                        ],
                        'options' => [
                            'Because reservoir reserves are critically depleted, local authorities are going to impose water restrictions.',
                            'Because reservoir reserves are critically depleted, local authorities is going to impose water restrictions.',
                            'Because reservoir reserves are critically depleted, local authorities are going to imposing water restrictions.',
                            'Because reservoir reserves are critically depleted, local authorities going to impose water restrictions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'local authorities' berpasangan dengan 'are going to impose'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Konsorsium peneliti akan mempresentasikan temuan komparatif mereka pada konferensi internasional bulan depan.',
                        'target_word' => 'is going to present (Pre-Planned Schedule)',
                        'vocab' => [
                            ['en' => 'research consortium', 'id' => 'konsorsium peneliti'],
                            ['en' => 'present comparative findings', 'id' => 'mempresentasikan temuan komparatif'],
                            ['en' => 'international conference', 'id' => 'konferensi internasional'],
                        ],
                        'options' => [
                            'The research consortium is going to present its comparative findings at the international symposium next month.',
                            'The research consortium are going to present its comparative findings at the international symposium next month.',
                            'The research consortium is going to presents its comparative findings at the international symposium next month.',
                            'The research consortium going to present its comparative findings at the international symposium next month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The research consortium' mengambil 'is going to present'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Melihat laju deforestasi yang terus berlanjut, keanekaragaman hayati hutan hujan akan mengalami kerugian permanen.',
                        'target_word' => 'is going to suffer (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'ongoing deforestation rate', 'id' => 'laju deforestasi yang terus berlanjut'],
                            ['en' => 'rainforest biodiversity', 'id' => 'keanekaragaman hayati hutan hujan'],
                            ['en' => 'suffer permanent loss', 'id' => 'mengalami kerugian permanen'],
                        ],
                        'options' => [
                            'Given the ongoing rate of deforestation, rainforest biodiversity is going to suffer irreversible losses.',
                            'Given the ongoing rate of deforestation, rainforest biodiversity are going to suffer irreversible losses.',
                            'Given the ongoing rate of deforestation, rainforest biodiversity is going to suffering irreversible losses.',
                            'Given the ongoing rate of deforestation, rainforest biodiversity going to suffer irreversible losses.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'biodiversity' adalah singular mass noun, maka to be yang benar adalah 'is going to suffer'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Para pengembang perangkat lunak akan memperbarui protokol enkripsi guna mencegah kebocoran data.',
                        'target_word' => 'are going to upgrade (Pre-Planned Action)',
                        'vocab' => [
                            ['en' => 'software developers', 'id' => 'pengembang perangkat lunak'],
                            ['en' => 'upgrade encryption protocols', 'id' => 'memperbarui protokol enkripsi'],
                            ['en' => 'prevent data breaches', 'id' => 'mencegah kebocoran data'],
                        ],
                        'options' => [
                            'The software developers are going to upgrade encryption protocols to prevent unauthorized data breaches.',
                            'The software developers is going to upgrade encryption protocols to prevent unauthorized data breaches.',
                            'The software developers are going to upgrading encryption protocols to prevent unauthorized data breaches.',
                            'The software developers going to upgrade encryption protocols to prevent unauthorized data breaches.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'The software developers' membutuhkan 'are going to upgrade'.",
                    ],
                ]
            ],
            [
                'id' => 'future-nominal',
                'name' => "1.11.3 Simple Future Nominal: Future States & Conditions ('Will Be' & 'Be Going To Be')",
                'code' => '1.11.3',
                'concept_title' => 'Simple Future Nominal: Menjelaskan Status & Kondisi Masa Depan',
                'concept_description' => "Presentasi ide akademis sering kali membutuhkan proyeksi status, peran, atau sifat subjek di masa depan. Simple Future Nominal dibentuk dengan meletakkan 'be' setelah modal 'will' (will be) atau setelah 'going to' (is/are going to be) diikuti pelengkap (Adjective, Noun Phrase, atau Prepositional Phrase). Jangan pernah meniadakan kata 'be' pada kalimat nominal masa depan.",
                'description' => "Presentasi ide akademis sering kali membutuhkan proyeksi status, peran, atau sifat subjek di masa depan. Simple Future Nominal dibentuk dengan meletakkan 'be' setelah modal 'will' (will be) atau setelah 'going to' (is/are going to be) diikuti pelengkap (Adjective, Noun Phrase, atau Prepositional Phrase). Jangan pernah meniadakan kata 'be' pada kalimat nominal masa depan.",
                'formula' => 'Subject + will be / is/are going to be + Adjective / Noun Phrase / Prepositional Phrase',
                'rules' => [
                    "Bentuk baku nominal: 'will be + Complement' atau 'is/are going to be + Complement'.",
                    'Pelengkap (Complement) dapat berupa kata sifat (beneficial, crucial), frasa nomina (a major catalyst), atau preposisi (in effect).',
                    "Dilarang keras meniadakan 'be' (*The policy will beneficial adalah KESALAHAN BESAR).",
                    'Dilarang menggunakan to be lain setelah will (*will is, *will was).',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Infrastruktur transportasi baru tersebut akan sangat bermanfaat bagi masyarakat perdesaan.',
                        'target_word' => 'will be highly beneficial (Future Nominal)',
                        'vocab' => [
                            ['en' => 'transport infrastructure', 'id' => 'infrastruktur transportasi'],
                            ['en' => 'highly beneficial', 'id' => 'sangat bermanfaat'],
                            ['en' => 'rural communities', 'id' => 'masyarakat perdesaan'],
                        ],
                        'options' => [
                            'The new transport infrastructure will be highly beneficial to remote rural communities.',
                            'The new transport infrastructure will highly beneficial to remote rural communities.',
                            'The new transport infrastructure will is highly beneficial to remote rural communities.',
                            'The new transport infrastructure will being highly beneficial to remote rural communities.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah modal 'will', kita wajib menyertakan kata kerja bantu 'be' sebelum adjective 'beneficial' ('will be highly beneficial').",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Kecerdasan buatan akan menjadi pendorong utama pertumbuhan ekonomi di era industri berikutnya.',
                        'target_word' => 'will be a primary driver (Future Nominal)',
                        'vocab' => [
                            ['en' => 'artificial intelligence', 'id' => 'kecerdasan buatan'],
                            ['en' => 'primary driver', 'id' => 'pendorong utama'],
                            ['en' => 'economic expansion', 'id' => 'pertumbuhan ekonomi'],
                        ],
                        'options' => [
                            'Artificial intelligence will be a primary driver of economic expansion in the next industrial era.',
                            'Artificial intelligence will a primary driver of economic expansion in the next industrial era.',
                            'Artificial intelligence will is a primary driver of economic expansion in the next industrial era.',
                            'Artificial intelligence will being a primary driver of economic expansion in the next industrial era.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be' sebelum noun phrase 'a primary driver'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Kondisi cuaca ekstrem diperkirakan akan menjadi lebih sering terjadi akibat pemanasan global.',
                        'target_word' => 'are going to be more frequent (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'extreme weather events', 'id' => 'kondisi cuaca ekstrem'],
                            ['en' => 'more frequent', 'id' => 'lebih sering terjadi'],
                            ['en' => 'global warming', 'id' => 'pemanasan global'],
                        ],
                        'options' => [
                            'Extreme weather events are going to be more frequent as global temperatures continue to rise.',
                            'Extreme weather events is going to be more frequent as global temperatures continue to rise.',
                            'Extreme weather events are going to more frequent as global temperatures continue to rise.',
                            'Extreme weather events are going to being more frequent as global temperatures continue to rise.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'events' membutuhkan 'are going to be' diikuti adjective 'more frequent'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Protokol keamanan hayati yang direvisi akan berlaku efektif mulai awal tahun depan.',
                        'target_word' => 'will be in effect (Future Nominal with Prepositional Phrase)',
                        'vocab' => [
                            ['en' => 'revised biosafety protocols', 'id' => 'protokol keamanan hayati yang direvisi'],
                            ['en' => 'in effect', 'id' => 'berlaku efektif'],
                            ['en' => 'beginning of next year', 'id' => 'awal tahun depan'],
                        ],
                        'options' => [
                            'The revised biosafety protocols will be in effect starting from the beginning of next year.',
                            'The revised biosafety protocols will in effect starting from the beginning of next year.',
                            'The revised biosafety protocols will are in effect starting from the beginning of next year.',
                            'The revised biosafety protocols will being in effect starting from the beginning of next year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa preposisional 'in effect' memerlukan 'will be'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Biaya operasional untuk komputasi awan akan menjadi lebih terjangkau bagi usaha rintisan.',
                        'target_word' => 'will be more affordable (Future Nominal)',
                        'vocab' => [
                            ['en' => 'operational costs', 'id' => 'biaya operasional'],
                            ['en' => 'cloud computing', 'id' => 'komputasi awan'],
                            ['en' => 'more affordable for startups', 'id' => 'lebih terjangkau bagi usaha rintisan'],
                        ],
                        'options' => [
                            'Operational costs for cloud computing will be more affordable for emerging tech startups.',
                            'Operational costs for cloud computing will more affordable for emerging tech startups.',
                            'Operational costs for cloud computing will are more affordable for emerging tech startups.',
                            'Operational costs for cloud computing will being more affordable for emerging tech startups.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kalimat nominal masa depan wajib menggunakan 'will be' sebelum komparatif 'more affordable'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Program gelar ganda ini akan menjadi peluang emas bagi para mahasiswa sarjana berprestasi.',
                        'target_word' => 'is going to be a golden opportunity (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'dual-degree curriculum', 'id' => 'program gelar ganda'],
                            ['en' => 'golden opportunity', 'id' => 'peluang emas'],
                            ['en' => 'undergraduate scholars', 'id' => 'mahasiswa sarjana berprestasi'],
                        ],
                        'options' => [
                            'This dual-degree curriculum is going to be a golden opportunity for ambitious undergraduate scholars.',
                            'This dual-degree curriculum are going to be a golden opportunity for ambitious undergraduate scholars.',
                            'This dual-degree curriculum is going to a golden opportunity for ambitious undergraduate scholars.',
                            'This dual-degree curriculum going to be a golden opportunity for ambitious undergraduate scholars.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'This curriculum' dipadukan dengan 'is going to be a golden opportunity'.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Kolaborasi interdisipliner akan sangat krusial dalam memecahkan teka-teki perubahan iklim.',
                        'target_word' => 'will be crucial (Future Nominal)',
                        'vocab' => [
                            ['en' => 'interdisciplinary collaboration', 'id' => 'kolaborasi interdisipliner'],
                            ['en' => 'crucial', 'id' => 'sangat krusial/penting'],
                            ['en' => 'resolving climate challenges', 'id' => 'memecahkan tantangan iklim'],
                        ],
                        'options' => [
                            'Interdisciplinary collaboration will be crucial in resolving complex global climate challenges.',
                            'Interdisciplinary collaboration will crucial in resolving complex global climate challenges.',
                            'Interdisciplinary collaboration will is crucial in resolving complex global climate challenges.',
                            'Interdisciplinary collaboration will being crucial in resolving complex global climate challenges.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be crucial' adalah struktur nominal masa depan yang baku.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Hasil penelitian ini akan relevan bagi perumusan kebijakan publik di bidang kesehatan.',
                        'target_word' => 'will be relevant (Future Nominal)',
                        'vocab' => [
                            ['en' => 'study findings', 'id' => 'hasil penelitian'],
                            ['en' => 'relevant', 'id' => 'relevan'],
                            ['en' => 'public healthcare policy', 'id' => 'kebijakan publik di bidang kesehatan'],
                        ],
                        'options' => [
                            'The findings of this study will be relevant to public healthcare policy formulation.',
                            'The findings of this study will relevant to public healthcare policy formulation.',
                            'The findings of this study will are relevant to public healthcare policy formulation.',
                            'The findings of this study will being relevant to public healthcare policy formulation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be' sebelum kata sifat 'relevant'.",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Dua ilmuwan senior tersebut akan menjadi pembicara utama dalam simposium astronomi internasional.',
                        'target_word' => 'are going to be keynote speakers (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'senior scientists', 'id' => 'ilmuwan senior'],
                            ['en' => 'keynote speakers', 'id' => 'pembicara utama'],
                            ['en' => 'international astronomy symposium', 'id' => 'simposium astronomi internasional'],
                        ],
                        'options' => [
                            'The two senior scientists are going to be keynote speakers at the international astronomy symposium.',
                            'The two senior scientists is going to be keynote speakers at the international astronomy symposium.',
                            'The two senior scientists are going to keynote speakers at the international astronomy symposium.',
                            'The two senior scientists are going to being keynote speakers at the international astronomy symposium.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'scientists' mengambil 'are going to be'.",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Wilayah pesisir tersebut akan rentan terhadap intrusi air asin jika pemompaan air tanah berlanjut.',
                        'target_word' => 'will be vulnerable (Future Nominal)',
                        'vocab' => [
                            ['en' => 'coastal aquifer', 'id' => 'akuifer pesisir'],
                            ['en' => 'vulnerable to saltwater intrusion', 'id' => 'rentan terhadap intrusi air asin'],
                            ['en' => 'groundwater extraction continues', 'id' => 'pemompaan air tanah berlanjut'],
                        ],
                        'options' => [
                            'The coastal aquifer will be vulnerable to saltwater intrusion if excessive groundwater extraction continues.',
                            'The coastal aquifer will vulnerable to saltwater intrusion if excessive groundwater extraction continues.',
                            'The coastal aquifer will is vulnerable to saltwater intrusion if excessive groundwater extraction continues.',
                            'The coastal aquifer will being vulnerable to saltwater intrusion if excessive groundwater extraction continues.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be vulnerable' menggabungkan modal 'will' dengan 'be' dan adjective 'vulnerable'.",
                    ],
                ]
            ],
            [
                'id' => 'future-passive',
                'name' => '1.11.4 Simple Future Passive: Future Methodologies, Policy Interventions & Planned Procedures',
                'code' => '1.11.4',
                'concept_title' => 'Simple Future Pasif: Metodologi Masa Depan & Intervensi Kebijakan',
                'concept_description' => "Simple Future Pasif adalah struktur wajib dalam penulisan Proposal Penelitian (Research Proposal), bagian Rencana Eksperimen (Experimental Plan), dan rancangan intervensi kebijakan. Kalimat ini menonjolkan objek atau sampel yang akan dikenai tindakan ilmiah di masa mendatang (misal: 'samples will be gathered', 'data will be analyzed'). Rumusnya menggunakan 'will be' diikuti Past Participle (V3).",
                'description' => "Simple Future Pasif adalah struktur wajib dalam penulisan Proposal Penelitian (Research Proposal), bagian Rencana Eksperimen (Experimental Plan), dan rancangan intervensi kebijakan. Kalimat ini menonjolkan objek atau sampel yang akan dikenai tindakan ilmiah di masa mendatang (misal: 'samples will be gathered', 'data will be analyzed'). Rumusnya menggunakan 'will be' diikuti Past Participle (V3).",
                'formula' => 'Subject (Patient) + will be / is/are going to be + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    'Rumus utama: will be + Verb 3 (Past Participle).',
                    'Jangan tertukar dengan Future Continuous aktif (will be + V-ing); bentuk pasif WAJIB berakhiran V3 (will be tested, bukan will be testing).',
                    "Dalam bentuk 'be going to', rumusnya adalah 'is/are going to be + V3'.",
                    'Bentuk pasif menciptakan sudut pandang objektif yang impersonal standar proposal penelitian internasional.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Sampel tanah akan dikumpulkan setiap minggu untuk memantau tingkat keasaman.',
                        'target_word' => 'will be collected (Future Passive)',
                        'vocab' => [
                            ['en' => 'soil samples', 'id' => 'sampel tanah'],
                            ['en' => 'collected weekly', 'id' => 'dikumpulkan setiap minggu'],
                            ['en' => 'monitor acidity levels', 'id' => 'memantau tingkat keasaman'],
                        ],
                        'options' => [
                            'Soil samples will be collected on a weekly basis to monitor changing acidity levels.',
                            'Soil samples will collect on a weekly basis to monitor changing acidity levels.',
                            'Soil samples will be collect on a weekly basis to monitor changing acidity levels.',
                            'Soil samples will being collected on a weekly basis to monitor changing acidity levels.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'Soil samples' memerlukan 'will be' diikuti bentuk V3 'collected'. Opsi B aktif ('akan mengumpulkan').",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Data mentah dari survei kuesioner akan dianalisis menggunakan perangkat lunak statistik mutakhir.',
                        'target_word' => 'will be analyzed (Future Passive)',
                        'vocab' => [
                            ['en' => 'raw survey data', 'id' => 'data mentah survei'],
                            ['en' => 'analyzed', 'id' => 'dianalisis'],
                            ['en' => 'statistical software', 'id' => 'perangkat lunak statistik'],
                        ],
                        'options' => [
                            'Raw survey data will be analyzed using cutting-edge statistical modeling software.',
                            'Raw survey data will analyze using cutting-edge statistical modeling software.',
                            'Raw survey data will be analyze using cutting-edge statistical modeling software.',
                            'Raw survey data will being analyzed using cutting-edge statistical modeling software.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk pasif masa depan yang tepat adalah 'will be analyzed' (will be + V3).",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Vaksin eksperimental tersebut akan diuji dalam uji klinis fase ketiga pada musim semi mendatang.',
                        'target_word' => 'is going to be tested (Future Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'experimental vaccine', 'id' => 'vaksin eksperimental'],
                            ['en' => 'tested in clinical trials', 'id' => 'diuji dalam uji klinis'],
                            ['en' => 'phase three', 'id' => 'fase ketiga'],
                        ],
                        'options' => [
                            'The experimental vaccine is going to be tested in phase three clinical trials next spring.',
                            'The experimental vaccine are going to be tested in phase three clinical trials next spring.',
                            'The experimental vaccine is going to be test in phase three clinical trials next spring.',
                            'The experimental vaccine is going to being tested in phase three clinical trials next spring.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The vaccine' dipadukan dengan 'is going to be tested' (is going to be + V3).",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Rekomendasi kebijakan baru akan diserahkan kepada dewan legislatif pada akhir bulan.',
                        'target_word' => 'will be submitted (Future Passive)',
                        'vocab' => [
                            ['en' => 'policy recommendations', 'id' => 'rekomendasi kebijakan'],
                            ['en' => 'submitted', 'id' => 'diserahkan'],
                            ['en' => 'legislative council', 'id' => 'dewan legislatif'],
                        ],
                        'options' => [
                            'New policy recommendations will be submitted to the legislative council by the end of the month.',
                            'New policy recommendations will submit to the legislative council by the end of the month.',
                            'New policy recommendations will be submit to the legislative council by the end of the month.',
                            'New policy recommendations will being submitted to the legislative council by the end of the month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'recommendations' dikenai aksi penyerahan sehingga memerlukan 'will be submitted'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Prosedur operasi standar yang baru akan diterapkan di seluruh fasilitas manufaktur.',
                        'target_word' => 'will be implemented (Future Passive)',
                        'vocab' => [
                            ['en' => 'standard operating procedures', 'id' => 'prosedur operasi standar'],
                            ['en' => 'implemented', 'id' => 'diterapkan'],
                            ['en' => 'manufacturing facilities', 'id' => 'fasilitas manufaktur'],
                        ],
                        'options' => [
                            'Updated standard operating procedures will be implemented across all manufacturing facilities.',
                            'Updated standard operating procedures will implement across all manufacturing facilities.',
                            'Updated standard operating procedures will be implement across all manufacturing facilities.',
                            'Updated standard operating procedures are will be implemented across all manufacturing facilities.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be implemented' adalah pola pasif masa depan yang benar.",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Laporan keuangan tahunan perusahaan akan diaudit oleh kantor akuntan publik independen.',
                        'target_word' => 'will be audited (Future Passive)',
                        'vocab' => [
                            ['en' => 'annual financial statement', 'id' => 'laporan keuangan tahunan'],
                            ['en' => 'audited by an independent firm', 'id' => 'diaudit oleh kantor akuntan independen'],
                        ],
                        'options' => [
                            'The corporate annual financial statement will be audited by an independent accounting firm.',
                            'The corporate annual financial statement will audit by an independent accounting firm.',
                            'The corporate annual financial statement will be audit by an independent accounting firm.',
                            'The corporate annual financial statement is will be audited by an independent accounting firm.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk pasif formal 'will be audited' (will be + V3).",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Fasilitas pengolahan limbah beracun akan dibangun di luar zona permukiman padat penduduk.',
                        'target_word' => 'is going to be constructed (Future Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'hazardous waste treatment facility', 'id' => 'fasilitas pengolahan limbah beracun'],
                            ['en' => 'constructed', 'id' => 'dibangun'],
                            ['en' => 'densely populated residential zones', 'id' => 'zona permukiman padat penduduk'],
                        ],
                        'options' => [
                            'A modern hazardous waste treatment facility is going to be constructed outside densely populated zones.',
                            'A modern hazardous waste treatment facility are going to be constructed outside densely populated zones.',
                            'A modern hazardous waste treatment facility is going to be construct outside densely populated zones.',
                            'A modern hazardous waste treatment facility going to be constructed outside densely populated zones.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'facility' mengambil pasif 'is going to be constructed'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Efektivitas strategi pengajaran baru akan dinilai melalui tes diagnostik komparatif.',
                        'target_word' => 'will be evaluated (Future Passive)',
                        'vocab' => [
                            ['en' => 'pedagogical strategy', 'id' => 'strategi pengajaran'],
                            ['en' => 'evaluated', 'id' => 'dinilai/dievaluasi'],
                            ['en' => 'comparative diagnostic examinations', 'id' => 'tes diagnostik komparatif'],
                        ],
                        'options' => [
                            'The efficacy of the pedagogical strategy will be evaluated through comparative diagnostic examinations.',
                            'The efficacy of the pedagogical strategy will evaluate through comparative diagnostic examinations.',
                            'The efficacy of the pedagogical strategy will be evaluate through comparative diagnostic examinations.',
                            'The efficacy of the pedagogical strategy will being evaluated through comparative diagnostic examinations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be evaluated' menyajikan rencana metodologi evaluasi pasif yang objektif.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Dana hibah penelitian tambahan akan dialokasikan untuk laboratorium biologi molekuler.',
                        'target_word' => 'will be allocated (Future Passive)',
                        'vocab' => [
                            ['en' => 'supplementary research grants', 'id' => 'dana hibah penelitian tambahan'],
                            ['en' => 'allocated', 'id' => 'dialokasikan'],
                            ['en' => 'molecular biology laboratory', 'id' => 'laboratorium biologi molekuler'],
                        ],
                        'options' => [
                            'Supplementary research grants will be allocated to the molecular biology laboratory.',
                            'Supplementary research grants will allocate to the molecular biology laboratory.',
                            'Supplementary research grants will be allocate to the molecular biology laboratory.',
                            'Supplementary research grants will being allocated to the molecular biology laboratory.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'grants' memerlukan 'will be allocated'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Partisipan studi akan diberitahu mengenai hasil pemindaian medis mereka secara rahasia.',
                        'target_word' => 'will be notified (Future Passive)',
                        'vocab' => [
                            ['en' => 'study participants', 'id' => 'partisipan studi'],
                            ['en' => 'notified', 'id' => 'diberitahu'],
                            ['en' => 'confidentially', 'id' => 'secara rahasia'],
                        ],
                        'options' => [
                            'Enrolled study participants will be notified regarding their medical scan results confidentially.',
                            'Enrolled study participants will notify regarding their medical scan results confidentially.',
                            'Enrolled study participants will be notify regarding their medical scan results confidentially.',
                            'Enrolled study participants are will be notified regarding their medical scan results confidentially.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be notified' (will be + V3) menyatakan bahwa partisipan akan menerima pemberitahuan (pasif).",
                    ],
                ]
            ],
            [
                'id' => 'future-aspect-distinctions',
                'name' => "1.11.5 'Will' vs 'Be Going To' vs Present Continuous for Future Plans",
                'code' => '1.11.5',
                'concept_title' => "Nuansa Pragmatis Masa Depan: 'Will' vs 'Be Going To' vs Present Continuous",
                'concept_description' => "Dalam penulisan formal dan akademis tingkat lanjut, penulis harus mampu membedakan ketiga ragam penanda masa depan: (1) 'Will' untuk komitmen formal, prediksi tanpa bukti langsung, dan janji institusional; (2) 'Be Going To' untuk prediksi berbasis tanda fisik/tren empiris yang ada saat ini; dan (3) 'Present Continuous' (is/are + V-ing) untuk acara atau kesepakatan yang telah terjadwal secara definitif dalam agenda kalender.",
                'description' => "Dalam penulisan formal dan akademis tingkat lanjut, penulis harus mampu membedakan ketiga ragam penanda masa depan: (1) 'Will' untuk komitmen formal, prediksi tanpa bukti langsung, dan janji institusional; (2) 'Be Going To' untuk prediksi berbasis tanda fisik/tren empiris yang ada saat ini; dan (3) 'Present Continuous' (is/are + V-ing) untuk acara atau kesepakatan yang telah terjadwal secara definitif dalam agenda kalender.",
                'formula' => 'Will (Projections/Promises) | Be Going To (Evidence/Intention) | Present Continuous (Arranged Calendar Events)',
                'rules' => [
                    "Gunakan Present Continuous untuk jadwal pasti yang sudah memiliki tanggal/waktu definitif ('The committee is meeting tomorrow at 10 AM').",
                    "Gunakan 'be going to' bila ada bukti konkret saat ini yang mengindikasikan hasil ('The bar chart shows that emissions are going to rise').",
                    "Gunakan 'will' untuk konsekuensi logis, syarat pengandaian, atau proyeksi jangka panjang ('This will reduce poverty').",
                    "Hindari penggunaan 'will' pada anak kalimat penunjuk waktu (Time Clauses: when, as soon as, before).",
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Universitas menyelenggarakan konferensi internasional tersebut pada hari Senin depan di aula utama.',
                        'target_word' => 'is hosting next Monday (Present Continuous for Fixed Arrangement)',
                        'vocab' => [
                            ['en' => 'university', 'id' => 'universitas'],
                            ['en' => 'international conference', 'id' => 'konferensi internasional'],
                            ['en' => 'main auditorium', 'id' => 'aula utama'],
                        ],
                        'options' => [
                            'The university is hosting the international symposium next Monday in the main auditorium.',
                            'The university will to host the international symposium next Monday in the main auditorium.',
                            'The university is going to hosted the international symposium next Monday in the main auditorium.',
                            'The university hosts will the international symposium next Monday in the main auditorium.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Untuk agenda terjadwal pasti dengan waktu dan lokasi tertera ('next Monday in the main auditorium'), Present Continuous ('is hosting') adalah ekspresi yang paling alami dan baku.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Jika para pembuat kebijakan gagal bertindak, pemanasan global akan mempercepat kenaikan permukaan laut.',
                        'target_word' => 'will accelerate (Conditional Future Consequence)',
                        'vocab' => [
                            ['en' => 'policymakers fail to act', 'id' => 'pembuat kebijakan gagal bertindak'],
                            ['en' => 'global warming', 'id' => 'pemanasan global'],
                            ['en' => 'accelerate sea level rise', 'id' => 'mempercepat kenaikan permukaan laut'],
                        ],
                        'options' => [
                            'If policymakers fail to act decisively, global warming will accelerate sea level rise exponentially.',
                            'If policymakers fail to act decisively, global warming is accelerating sea level rise exponentially next year.',
                            'If policymakers fail to act decisively, global warming will accelerates sea level rise exponentially.',
                            'If policymakers fail to act decisively, global warming is going to accelerated sea level rise exponentially.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Konsekuensi logis masa depan dalam klausa pengandaian (First Conditional) wajib menggunakan modal 'will + V1' ('will accelerate').",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Melihat awan polusi tebal yang melayang di atas lembah, kualitas udara akan menurun tajam sore ini.',
                        'target_word' => 'is going to deteriorate (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'dense smog cloud', 'id' => 'awan polusi tebal'],
                            ['en' => 'valley', 'id' => 'lembah'],
                            ['en' => 'air quality deteriorate', 'id' => 'kualitas udara menurun'],
                        ],
                        'options' => [
                            'Observing the dense smog cloud over the valley, regional air quality is going to deteriorate sharply this evening.',
                            'Observing the dense smog cloud over the valley, regional air quality will deteriorating sharply this evening.',
                            'Observing the dense smog cloud over the valley, regional air quality is going to deteriorated sharply this evening.',
                            'Observing the dense smog cloud over the valley, regional air quality deteriorates will sharply this evening.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Prediksi yang didasarkan pada bukti fisik kasat mata saat ini ('Observing the dense smog cloud...') paling tepat menggunakan 'is going to deteriorate'.",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Dewan juri menerbitkan daftar pemenang penghargaan riset pada tanggal lima belas November.',
                        'target_word' => 'is publishing on November 15 (Scheduled Arrangement)',
                        'vocab' => [
                            ['en' => 'adjudication panel', 'id' => 'dewan juri'],
                            ['en' => 'research award laureates', 'id' => 'pemenang penghargaan riset'],
                            ['en' => 'on November 15', 'id' => 'pada tanggal 15 November'],
                        ],
                        'options' => [
                            'The adjudication panel is publishing the official list of research laureates on November 15.',
                            'The adjudication panel will to publish the official list of research laureates on November 15.',
                            'The adjudication panel is going to published the official list of research laureates on November 15.',
                            'The adjudication panel publishing will the official list of research laureates on November 15.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jadwal resmi kalender publikasi ('on November 15') secara efektif dinyatakan dengan Present Continuous 'is publishing'.",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Kami menjamin bahwa data responden akan tetap dirahasiakan selama penelitian berlangsung.',
                        'target_word' => 'will remain confidential (Formal Institutional Guarantee)',
                        'vocab' => [
                            ['en' => 'guarantee', 'id' => 'menjamin'],
                            ['en' => 'respondent data', 'id' => 'data responden'],
                            ['en' => 'remain confidential', 'id' => 'tetap dirahasiakan'],
                        ],
                        'options' => [
                            'We guarantee that all respondent survey data will remain strictly confidential throughout the study.',
                            'We guarantee that all respondent survey data are remaining strictly confidential throughout the study.',
                            'We guarantee that all respondent survey data will to remain strictly confidential throughout the study.',
                            'We guarantee that all respondent survey data is going to remaining strictly confidential throughout the study.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Janji institusional atau jaminan etik formal (guarantee, promise, pledge) selalu menggunakan 'will + V1' ('will remain').",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Tren grafik menunjukkan bahwa penjualan telepon pintar akan melampaui komputer jinjing pada tahun mendatang.',
                        'target_word' => 'are going to overtake (Graphic Trend Evidence)',
                        'vocab' => [
                            ['en' => 'chart trajectory indicates', 'id' => 'tren grafik menunjukkan'],
                            ['en' => 'smartphone sales', 'id' => 'penjualan telepon pintar'],
                            ['en' => 'overtake laptop shipments', 'id' => 'melampaui penjualan laptop'],
                        ],
                        'options' => [
                            'The chart trajectory indicates that smartphone sales are going to overtake laptop shipments in the coming year.',
                            'The chart trajectory indicates that smartphone sales is going to overtake laptop shipments in the coming year.',
                            'The chart trajectory indicates that smartphone sales are going to overtaking laptop shipments in the coming year.',
                            'The chart trajectory indicates that smartphone sales will to overtake laptop shipments in the coming year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Data tren visual yang memperlihatkan kurva kenaikan ('chart trajectory indicates') lazim dilaporkan dengan 'are going to overtake' (subjek jamak 'sales').",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Profesor Pratama memimpin delegasi akademis ke Tokyo pada hari Kamis lusa.',
                        'target_word' => 'is leading on Thursday (Definite Travel Arrangement)',
                        'vocab' => [
                            ['en' => 'lead the academic delegation', 'id' => 'memimpin delegasi akademis'],
                            ['en' => 'this Thursday', 'id' => 'hari Kamis ini'],
                        ],
                        'options' => [
                            'Professor Pratama is leading the academic delegation to Tokyo this coming Thursday.',
                            'Professor Pratama will to lead the academic delegation to Tokyo this coming Thursday.',
                            'Professor Pratama is going to led the academic delegation to Tokyo this coming Thursday.',
                            'Professor Pratama will leading the academic delegation to Tokyo this coming Thursday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rencana perjalanan resmi dengan tanggal pasti ('this coming Thursday') diekspresikan dengan Present Continuous 'is leading'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Penerapan kecerdasan buatan dalam radiologi akan meminimalkan kesalahan diagnosis manusiawi.',
                        'target_word' => 'will minimize (General Analytical Projection)',
                        'vocab' => [
                            ['en' => 'artificial intelligence integration', 'id' => 'penerapan kecerdasan buatan'],
                            ['en' => 'radiology', 'id' => 'radiologi'],
                            ['en' => 'minimize human diagnostic errors', 'id' => 'meminimalkan kesalahan diagnosis manusiawi'],
                        ],
                        'options' => [
                            'The integration of artificial intelligence in radiology will minimize human diagnostic errors significantly.',
                            'The integration of artificial intelligence in radiology will minimizes human diagnostic errors significantly.',
                            'The integration of artificial intelligence in radiology is minimizing human diagnostic errors next year.',
                            'The integration of artificial intelligence in radiology will to minimize human diagnostic errors significantly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Proyeksi ilmiah umum tentang dampak teknologi masa depan diungkapkan dengan modal 'will minimize'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Melihat indikator ekonomi yang terus melemah, bank sentral akan menaikkan suku bunga acuan.',
                        'target_word' => 'is going to raise (Evidence-Based Policy Action)',
                        'vocab' => [
                            ['en' => 'deteriorating economic indicators', 'id' => 'indikator ekonomi yang melemah'],
                            ['en' => 'central bank', 'id' => 'bank sentral'],
                            ['en' => 'raise benchmark interest rates', 'id' => 'menaikkan suku bunga acuan'],
                        ],
                        'options' => [
                            'Judging by deteriorating macroeconomic indicators, the central bank is going to raise benchmark interest rates.',
                            'Judging by deteriorating macroeconomic indicators, the central bank are going to raise benchmark interest rates.',
                            'Judging by deteriorating macroeconomic indicators, the central bank is going to raising benchmark interest rates.',
                            'Judging by deteriorating macroeconomic indicators, the central bank will to raise benchmark interest rates.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan kebijakan yang didasari bukti indikator konkret ('Judging by...') menggunakan 'is going to raise'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Para delegasi menandatangani perjanjian pakta iklim multilateral pada sesi penutupan esok hari.',
                        'target_word' => 'are signing tomorrow (Scheduled Formal Milestone)',
                        'vocab' => [
                            ['en' => 'delegates', 'id' => 'para delegasi'],
                            ['en' => 'multilateral climate treaty', 'id' => 'perjanjian pakta iklim multilateral'],
                            ['en' => 'closing plenary tomorrow', 'id' => 'sesi penutupan esok hari'],
                        ],
                        'options' => [
                            'Delegates are signing the multilateral climate treaty during the closing plenary tomorrow morning.',
                            'Delegates will to sign the multilateral climate treaty during the closing plenary tomorrow morning.',
                            'Delegates are going to signed the multilateral climate treaty during the closing plenary tomorrow morning.',
                            'Delegates will signing the multilateral climate treaty during the closing plenary tomorrow morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jadwal seremonial resmi yang telah ditetapkan pada agenda ('tomorrow morning') memakai Present Continuous 'are signing'.",
                    ],
                ]
            ],
            [
                'id' => 'future-negative-interrogative',
                'name' => '1.11.6 Simple Future Negative & Interrogative: Refuting Adverse Impacts & Research Inquiries',
                'code' => '1.11.6',
                'concept_title' => 'Simple Future Negatif & Interogatif: Membantah Dampak & Mengajukan Pertanyaan',
                'concept_description' => "Bentuk negatif Simple Future ('will not' / 'is/are not going to') digunakan dalam penulisan ilmiah untuk menyangkal potensi dampak buruk dari suatu metode baru atau menegaskan batas toleransi eksperimen. Bentuk interogatif ('Will + Subject + V1...?' atau 'Is/Are + Subject + going to...?) digunakan dalam merumuskan pertanyaan prospektif di awal penelitian.",
                'description' => "Bentuk negatif Simple Future ('will not' / 'is/are not going to') digunakan dalam penulisan ilmiah untuk menyangkal potensi dampak buruk dari suatu metode baru atau menegaskan batas toleransi eksperimen. Bentuk interogatif ('Will + Subject + V1...?' atau 'Is/Are + Subject + going to...?) digunakan dalam merumuskan pertanyaan prospektif di awal penelitian.",
                'formula' => 'Negative: Subject + will NOT + V1 / be Adj/V3 | Interrogative: Will + Subject + V1 / be V3?',
                'rules' => [
                    "Bentuk negatif formal: 'will not + V1' atau 'will not be + V3/Adj'. Hindari singkatan 'won't' dalam karya tulis ilmiah.",
                    "Untuk bentuk 'be going to' negatif: 'is/are not going to + V1'.",
                    "Kalimat tanya dimulai dengan modal 'Will' atau to be 'Is/Are' diikuti subjek dan verba bentuk dasar.",
                    'Dilarang menggunakan do/does not sebelum will (*does not will generate adalah SALAH BESAR).',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Metode pemurnian air yang baru ini tidak akan menghasilkan produk sampingan beracun.',
                        'target_word' => 'will not generate (Negative Verbal with Will)',
                        'vocab' => [
                            ['en' => 'purification methodology', 'id' => 'metode pemurnian'],
                            ['en' => 'toxic byproducts', 'id' => 'produk sampingan beracun'],
                        ],
                        'options' => [
                            'This new purification methodology will not generate toxic chemical byproducts.',
                            'This new purification methodology will not generates toxic chemical byproducts.',
                            'This new purification methodology does not will generate toxic chemical byproducts.',
                            'This new purification methodology will not to generate toxic chemical byproducts.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk negatif modal formal adalah 'will not' diikuti kata kerja dasar murni 'generate'.",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Sampel biologis tersebut tidak akan disimpan pada suhu ruangan guna mencegah degradasi.',
                        'target_word' => 'will not be stored (Negative Passive)',
                        'vocab' => [
                            ['en' => 'biological specimens', 'id' => 'sampel biologis'],
                            ['en' => 'ambient room temperature', 'id' => 'suhu ruangan'],
                            ['en' => 'prevent degradation', 'id' => 'mencegah degradasi'],
                        ],
                        'options' => [
                            'The biological specimens will not be stored at ambient room temperature to prevent degradation.',
                            'The biological specimens will not stored at ambient room temperature to prevent degradation.',
                            'The biological specimens will not be store at ambient room temperature to prevent degradation.',
                            'The biological specimens do not will be stored at ambient room temperature to prevent degradation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola pasif negatif masa depan adalah 'will not be' + V3 'stored'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Apakah algoritma pengenalan gambar baru ini akan melampaui kinerja para spesialis medis manusia?',
                        'target_word' => 'Will ... outperform (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'image recognition algorithm', 'id' => 'algoritma pengenalan gambar'],
                            ['en' => 'outperform', 'id' => 'melampaui kinerja'],
                            ['en' => 'human medical specialists', 'id' => 'spesialis medis manusia'],
                        ],
                        'options' => [
                            'Will this image recognition algorithm outperform human medical specialists in diagnostic speed?',
                            'Will this image recognition algorithm outperforms human medical specialists in diagnostic speed?',
                            'Does this image recognition algorithm will outperform human medical specialists in diagnostic speed?',
                            'Will this image recognition algorithm to outperform human medical specialists in diagnostic speed?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertanyaan masa depan diawali 'Will' + Subject + V1 'outperform'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Kenaikan suku bunga yang moderat tidak akan menghambat investasi jangka panjang di sektor teknologi.',
                        'target_word' => 'will not impede (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'moderate interest rate hike', 'id' => 'kenaikan suku bunga moderat'],
                            ['en' => 'impede long-term investment', 'id' => 'menghambat investasi jangka panjang'],
                            ['en' => 'technology sector', 'id' => 'sektor teknologi'],
                        ],
                        'options' => [
                            'A moderate interest rate hike will not impede long-term investment in the technology sector.',
                            'A moderate interest rate hike will not impedes long-term investment in the technology sector.',
                            'A moderate interest rate hike does not will impede long-term investment in the technology sector.',
                            'A moderate interest rate hike will not to impede long-term investment in the technology sector.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will not impede' memaparkan penyangkalan dampak negatif secara lugas dan formal.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Apakah uji coba fase ketiga akan dilakukan di beberapa pusat medis internasional?',
                        'target_word' => 'Will ... be conducted (Interrogative Passive)',
                        'vocab' => [
                            ['en' => 'phase three trial', 'id' => 'uji coba fase ketiga'],
                            ['en' => 'conducted', 'id' => 'dilakukan'],
                            ['en' => 'international medical centers', 'id' => 'pusat medis internasional'],
                        ],
                        'options' => [
                            'Will the phase three trial be conducted across multiple international medical centers?',
                            'Will the phase three trial conduct across multiple international medical centers?',
                            'Will the phase three trial be conduct across multiple international medical centers?',
                            'Is the phase three trial will be conducted across multiple international medical centers?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertanyaan pasif masa depan menggunakan struktur: 'Will' + Subject + 'be' + V3 ('be conducted').",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Pemerintah daerah tidak akan memotong anggaran pendidikan untuk tahun fiskal mendatang.',
                        'target_word' => 'is not going to reduce (Negative with Be Going To)',
                        'vocab' => [
                            ['en' => 'regional administration', 'id' => 'pemerintah daerah'],
                            ['en' => 'reduce educational funding', 'id' => 'memotong anggaran pendidikan'],
                            ['en' => 'upcoming fiscal year', 'id' => 'tahun fiskal mendatang'],
                        ],
                        'options' => [
                            'The regional administration is not going to reduce educational funding for the upcoming fiscal year.',
                            'The regional administration are not going to reduce educational funding for the upcoming fiscal year.',
                            'The regional administration is not going to reducing educational funding for the upcoming fiscal year.',
                            'The regional administration not is going to reduce educational funding for the upcoming fiscal year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The regional administration' berpasangan dengan 'is not going to reduce'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah pergeseran iklim akan mengubah pola migrasi spesies burung arktik secara permanen?',
                        'target_word' => 'Will ... alter (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'climatic shifts', 'id' => 'pergeseran iklim'],
                            ['en' => 'alter migratory patterns', 'id' => 'mengubah pola migrasi'],
                            ['en' => 'arctic avian species', 'id' => 'spesies burung arktik'],
                        ],
                        'options' => [
                            'Will climatic shifts permanently alter the migratory patterns of arctic avian species?',
                            'Will climatic shifts permanently alters the migratory patterns of arctic avian species?',
                            'Do climatic shifts will permanently alter the migratory patterns of arctic avian species?',
                            'Will climatic shifts permanently to alter the migratory patterns of arctic avian species?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Will' diletakkan di depan subjek 'climatic shifts' dan diikuti V1 'alter'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Data sensitif pasien tidak akan dibagikan kepada pihak ketiga tanpa izin tertulis.',
                        'target_word' => 'will not be disclosed (Negative Passive)',
                        'vocab' => [
                            ['en' => 'sensitive patient records', 'id' => 'data sensitif pasien'],
                            ['en' => 'disclosed to third parties', 'id' => 'dibagikan kepada pihak ketiga'],
                            ['en' => 'explicit written consent', 'id' => 'izin tertulis'],
                        ],
                        'options' => [
                            'Sensitive patient records will not be disclosed to third parties without explicit written consent.',
                            'Sensitive patient records will not disclosed to third parties without explicit written consent.',
                            'Sensitive patient records will not be disclose to third parties without explicit written consent.',
                            'Sensitive patient records do not will be disclosed to third parties without explicit written consent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola pasif negatif 'will not be disclosed' (will not be + V3).",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Peralatan laboratorium lama tersebut tidak akan digunakan lagi setelah pembaruan fasilitas selesai.',
                        'target_word' => 'are not going to be utilized (Negative Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'legacy laboratory instruments', 'id' => 'peralatan laboratorium lama'],
                            ['en' => 'utilized', 'id' => 'digunakan'],
                            ['en' => 'facility upgrade', 'id' => 'pembaruan fasilitas'],
                        ],
                        'options' => [
                            'The legacy laboratory instruments are not going to be utilized once the facility upgrade is finished.',
                            'The legacy laboratory instruments is not going to be utilized once the facility upgrade is finished.',
                            'The legacy laboratory instruments are not going to be utilize once the facility upgrade is finished.',
                            'The legacy laboratory instruments are not going to utilized once the facility upgrade is finished.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'instruments' memakai 'are not going to be utilized'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah model matematika ini akan memberikan prediksi yang andal dalam skenario krisis?',
                        'target_word' => 'Will ... provide (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'mathematical model', 'id' => 'model matematika'],
                            ['en' => 'reliable projections', 'id' => 'prediksi yang andal'],
                            ['en' => 'crisis scenarios', 'id' => 'skenario krisis'],
                        ],
                        'options' => [
                            'Will this mathematical model provide reliable projections under severe crisis scenarios?',
                            'Will this mathematical model provides reliable projections under severe crisis scenarios?',
                            'Does this mathematical model will provide reliable projections under severe crisis scenarios?',
                            'Will this mathematical model to provide reliable projections under severe crisis scenarios?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Will' + Subject ('this mathematical model') + V1 ('provide').",
                    ],
                ]
            ],
            [
                'id' => 'future-time-clauses',
                'name' => "1.11.7 Future Time Clauses: The 'No Future in Time Clauses' Rule",
                'code' => '1.11.7',
                'concept_title' => "Klausa Waktu Masa Depan: Aturan Larangan 'Will' dalam Time Clauses",
                'concept_description' => "Salah satu aturan tata bahasa paling ketat dalam penulisan akademis adalah: anak kalimat yang diawali konjungsi waktu (when, as soon as, once, after, before, until) atau syarat (if, unless) DILARANG menggunakan kata kerja masa depan ('will' atau 'be going to'). Anak kalimat tersebut WAJIB menggunakan Simple Present Tense (V1/V-s), meskipun maknanya merujuk ke masa depan. Bentuk Simple Future ('will') hanya diletakkan pada induk kalimat (Main Clause).",
                'description' => "Salah satu aturan tata bahasa paling ketat dalam penulisan akademis adalah: anak kalimat yang diawali konjungsi waktu (when, as soon as, once, after, before, until) atau syarat (if, unless) DILARANG menggunakan kata kerja masa depan ('will' atau 'be going to'). Anak kalimat tersebut WAJIB menggunakan Simple Present Tense (V1/V-s), meskipun maknanya merujuk ke masa depan. Bentuk Simple Future ('will') hanya diletakkan pada induk kalimat (Main Clause).",
                'formula' => 'Time Conjunction (When/Once/As soon as) + Subject + Verb 1/V-s (Simple Present), Subject + will + V1',
                'rules' => [
                    "Dilarang menggunakan 'will' dalam klausa yang diawali: when, as soon as, once, after, before, until, if, provided that (*When the system will detect adalah KESALAHAN FATAL).",
                    'Gunakan Simple Present (V1 atau V-s) di dalam anak kalimat waktu.',
                    "Gunakan 'will + V1' atau 'will be + V3' di dalam induk kalimat (Main Clause).",
                    'Jika anak kalimat diletakkan di awal, wajib dipisahkan dengan tanda koma sebelum induk kalimat.',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Ketika sensor mendeteksi anomali tekanan, sistem darurat akan mematikan reaktor secara otomatis.',
                        'target_word' => 'detects ... will shut down (Time Clause Rule)',
                        'vocab' => [
                            ['en' => 'sensor detects', 'id' => 'sensor mendeteksi'],
                            ['en' => 'pressure anomaly', 'id' => 'anomali tekanan'],
                            ['en' => 'shut down the reactor', 'id' => 'mematikan reaktor'],
                        ],
                        'options' => [
                            'When the sensor detects a pressure anomaly, the emergency system will shut down the reactor automatically.',
                            'When the sensor will detect a pressure anomaly, the emergency system will shut down the reactor automatically.',
                            'When the sensor detects a pressure anomaly, the emergency system shuts down will the reactor automatically.',
                            'When the sensor is going to detect a pressure anomaly, the emergency system will shut down the reactor automatically.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa waktu yang diawali 'When' wajib menggunakan Simple Present ('detects'), bukan 'will detect'. Modal 'will' hanya ada pada induk kalimat ('will shut down').",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Segera setelah data klinis diverifikasi, para peneliti akan mempresentasikan laporan akhir mereka.',
                        'target_word' => 'is verified ... will present (Passive Time Clause)',
                        'vocab' => [
                            ['en' => 'as soon as', 'id' => 'segera setelah'],
                            ['en' => 'clinical data is verified', 'id' => 'data klinis diverifikasi'],
                            ['en' => 'present their final report', 'id' => 'mempresentasikan laporan akhir'],
                        ],
                        'options' => [
                            'As soon as the clinical data is verified, researchers will present their final comprehensive report.',
                            'As soon as the clinical data will be verified, researchers will present their final comprehensive report.',
                            'As soon as the clinical data is verified, researchers present will their final comprehensive report.',
                            'As soon as the clinical data will verify, researchers will present their final comprehensive report.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah konjungsi 'As soon as', gunakan Simple Present Pasif ('is verified'), bukan 'will be verified'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Setelah komite etik menyetujui proposal tersebut, fase perekrutan pasien akan dimulai.',
                        'target_word' => 'approves ... will commence (Time Clause Rule)',
                        'vocab' => [
                            ['en' => 'ethics committee approves', 'id' => 'komite etik menyetujui'],
                            ['en' => 'proposal', 'id' => 'proposal'],
                            ['en' => 'patient recruitment phase will commence', 'id' => 'fase perekrutan pasien akan dimulai'],
                        ],
                        'options' => [
                            'Once the ethics committee approves the research proposal, the patient recruitment phase will commence.',
                            'Once the ethics committee will approve the research proposal, the patient recruitment phase will commence.',
                            'Once the ethics committee approves the research proposal, the patient recruitment phase commences will.',
                            'Once the ethics committee will approves the research proposal, the patient recruitment phase will commence.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa waktu 'Once...' wajib memakai Simple Present 'approves'. Induk kalimat memakai 'will commence'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Pemerintah tidak akan mencabut pembatasan lingkungan sebelum emisi industri menurun ke ambang batas aman.',
                        'target_word' => 'will not lift ... decrease (Before Time Clause)',
                        'vocab' => [
                            ['en' => 'lift environmental restrictions', 'id' => 'mencabut pembatasan lingkungan'],
                            ['en' => 'industrial emissions decrease', 'id' => 'emisi industri menurun'],
                            ['en' => 'safe thresholds', 'id' => 'ambang batas aman'],
                        ],
                        'options' => [
                            'The government will not lift environmental restrictions before industrial emissions decrease below the safe threshold.',
                            'The government will not lift environmental restrictions before industrial emissions will decrease below the safe threshold.',
                            'The government does not lift environmental restrictions before industrial emissions will decrease below the safe threshold.',
                            'The government will not to lift environmental restrictions before industrial emissions decrease below the safe threshold.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah konjungsi 'before', kata kerja wajib Simple Present 'decrease' (subjek jamak 'emissions').",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Jika algoritma baru tersebut terbukti efisien, teknologi ini akan diadopsi oleh industri perbankan.',
                        'target_word' => 'proves ... will be adopted (Conditional + Passive Future)',
                        'vocab' => [
                            ['en' => 'proves efficient', 'id' => 'terbukti efisien'],
                            ['en' => 'adopted by the banking sector', 'id' => 'diadopsi oleh sektor perbankan'],
                        ],
                        'options' => [
                            'If the novel algorithm proves efficient, the technology will be adopted by the commercial banking sector.',
                            'If the novel algorithm will prove efficient, the technology will be adopted by the commercial banking sector.',
                            'If the novel algorithm proves efficient, the technology will adopted by the commercial banking sector.',
                            'If the novel algorithm is will prove efficient, the technology will be adopted by the commercial banking sector.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' menggunakan Simple Present 'proves', sedangkan induk kalimat menggunakan pasif masa depan 'will be adopted'.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Kecuali jika dana talangan disetujui minggu ini, proyek eksplorasi luar angkasa akan dihentikan sementara.',
                        'target_word' => 'is approved ... will be suspended (Unless Clause)',
                        'vocab' => [
                            ['en' => 'unless emergency funding is approved', 'id' => 'kecuali dana talangan disetujui'],
                            ['en' => 'space exploration venture', 'id' => 'proyek eksplorasi luar angkasa'],
                            ['en' => 'suspended', 'id' => 'dihentikan sementara'],
                        ],
                        'options' => [
                            'Unless emergency funding is approved this week, the space exploration venture will be suspended indefinitely.',
                            'Unless emergency funding will be approved this week, the space exploration venture will be suspended indefinitely.',
                            'Unless emergency funding is approved this week, the space exploration venture is suspended will indefinitely.',
                            'Unless emergency funding will approve this week, the space exploration venture will be suspended indefinitely.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'Unless' menggunakan Simple Present Pasif 'is approved'. Induk kalimat menggunakan 'will be suspended'.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Setelah para ahli kimia mengidentifikasi struktur molekul, mereka akan memulai proses sintesis senyawa.',
                        'target_word' => 'identify ... will begin (After Time Clause)',
                        'vocab' => [
                            ['en' => 'chemists identify', 'id' => 'ahli kimia mengidentifikasi'],
                            ['en' => 'molecular structure', 'id' => 'struktur molekul'],
                            ['en' => 'compound synthesis process', 'id' => 'proses sintesis senyawa'],
                        ],
                        'options' => [
                            'After chemists identify the exact molecular structure, they will begin the compound synthesis process.',
                            'After chemists will identify the exact molecular structure, they will begin the compound synthesis process.',
                            'After chemists identify the exact molecular structure, they begin will the compound synthesis process.',
                            'After chemists will to identify the exact molecular structure, they will begin the compound synthesis process.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah 'After', gunakan Simple Present 'identify' (subjek jamak 'chemists').",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Tim medis akan menunda prosedur bedah sampai tekanan darah pasien kembali normal.',
                        'target_word' => 'will postpone ... returns (Until Time Clause)',
                        'vocab' => [
                            ['en' => 'surgical procedure', 'id' => 'prosedur bedah'],
                            ['en' => 'blood pressure returns to normal', 'id' => 'tekanan darah kembali normal'],
                        ],
                        'options' => [
                            "The medical team will postpone the surgical procedure until the patient's blood pressure returns to normal.",
                            "The medical team will postpone the surgical procedure until the patient's blood pressure will return to normal.",
                            "The medical team postpones will the surgical procedure until the patient's blood pressure returns to normal.",
                            "The medical team will to postpone the surgical procedure until the patient's blood pressure returns to normal.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa setelah 'until' wajib menggunakan Simple Present tunggal 'returns', bukan 'will return'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Begitu prototipe baterai lulus uji ketahanan panas, produksi massal akan segera dimulai.',
                        'target_word' => 'passes ... will initiate (As soon as Time Clause)',
                        'vocab' => [
                            ['en' => 'battery prototype passes', 'id' => 'prototipe baterai lulus'],
                            ['en' => 'thermal resilience tests', 'id' => 'uji ketahanan panas'],
                            ['en' => 'mass production will initiate', 'id' => 'produksi massal akan dimulai'],
                        ],
                        'options' => [
                            'As soon as the battery prototype passes thermal resilience tests, commercial mass production will initiate.',
                            'As soon as the battery prototype will pass thermal resilience tests, commercial mass production will initiate.',
                            'As soon as the battery prototype passes thermal resilience tests, commercial mass production initiate will.',
                            'As soon as the battery prototype will passes thermal resilience tests, commercial mass production will initiate.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'As soon as' + Simple Present tunggal 'passes', diikuti induk kalimat 'will initiate'.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Jika suhu global naik melebihi dua derajat Celsius, ekosistem terumbu karang akan mengalami kepunahan massal.',
                        'target_word' => 'rises ... will suffer (Conditional Clause)',
                        'vocab' => [
                            ['en' => 'global temperatures rise', 'id' => 'suhu global naik'],
                            ['en' => 'two degrees Celsius', 'id' => 'dua derajat Celsius'],
                            ['en' => 'coral reef ecosystems', 'id' => 'ekosistem terumbu karang'],
                            ['en' => 'mass extinction', 'id' => 'kepunahan massal'],
                        ],
                        'options' => [
                            'If the global average temperature rises beyond two degrees Celsius, coral reef ecosystems will suffer mass extinction.',
                            'If the global average temperature will rise beyond two degrees Celsius, coral reef ecosystems will suffer mass extinction.',
                            'If the global average temperature rises beyond two degrees Celsius, coral reef ecosystems suffer will mass extinction.',
                            'If the global average temperature is will rise beyond two degrees Celsius, coral reef ecosystems will suffer mass extinction.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' menggunakan Simple Present 'rises', dan induk kalimat menggunakan 'will suffer'.",
                    ],
                ]
            ],
            [
                'id' => 'future-synthesis-roadmap',
                'name' => '1.11.8 Comprehensive Synthesis: Future Policy Impact & Long-Term Research Roadmap',
                'code' => '1.11.8',
                'concept_title' => 'Sintesis Komprehensif: Dampak Kebijakan Masa Depan & Peta Jalan Riset',
                'concept_description' => "Mengintegrasikan seluruh variasi Simple Future (aktif 'will', bukti 'be going to', bentuk nominal, pasif metodologi, dan aturan klausa waktu) ke dalam paragraf sintesis naskah ilmiah utuh. Sangat krusial untuk penulisan bab Rekomendasi (Recommendations), Peta Jalan Penelitian (Research Roadmap), dan esai argumentatif IELTS Task 2.",
                'description' => "Mengintegrasikan seluruh variasi Simple Future (aktif 'will', bukti 'be going to', bentuk nominal, pasif metodologi, dan aturan klausa waktu) ke dalam paragraf sintesis naskah ilmiah utuh. Sangat krusial untuk penulisan bab Rekomendasi (Recommendations), Peta Jalan Penelitian (Research Roadmap), dan esai argumentatif IELTS Task 2.",
                'formula' => 'Synthesized Future Academic Discourse: Complex Time/Condition Clause + Passive Future Plan + Strategic Projection',
                'rules' => [
                    "Gunakan Simple Present dalam anak kalimat bersyarat/waktu ('Once data are collected...').",
                    "Gunakan Future Passive untuk prosedur terencana ('...further analysis will be conducted').",
                    "Gunakan Future Active untuk dampak langsung ('...which will provide actionable insights').",
                    'Jaga konsistensi logika waktu dan keselarasan subjek-verba di seluruh kalimat majemuk bertingkat.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Begitu kerangka kerja regulasi baru diratifikasi, audit lingkungan wajib akan diberlakukan, yang akan mendorong korporasi untuk mengurangi emisi.',
                        'target_word' => 'is ratified ... will be mandated ... will incentivize (Future Policy Synthesis)',
                        'vocab' => [
                            ['en' => 'regulatory framework is ratified', 'id' => 'kerangka regulasi diratifikasi'],
                            ['en' => 'mandatory environmental audits', 'id' => 'audit lingkungan wajib'],
                            ['en' => 'will be mandated', 'id' => 'akan diberlakukan'],
                            ['en' => 'incentivize corporations', 'id' => 'mendorong korporasi'],
                        ],
                        'options' => [
                            'Once the new regulatory framework is ratified, mandatory environmental audits will be mandated, which will incentivize corporations to cut emissions.',
                            'Once the new regulatory framework will be ratified, mandatory environmental audits will be mandated, which will incentivize corporations to cut emissions.',
                            'Once the new regulatory framework is ratified, mandatory environmental audits will mandate, which will incentivize corporations to cut emissions.',
                            'Once the new regulatory framework will ratify, mandatory environmental audits will be mandated, which will incentivize corporations to cut emissions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'Once' menggunakan Simple Present Pasif 'is ratified'. Induk kalimat menggunakan Future Pasif 'will be mandated', dilanjutkan relative clause aktif 'which will incentivize'.",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Jika subsidi energi terbarukan dipertahankan, pangsa pasar tenaga surya akan berlipat ganda, dan biaya listrik bagi konsumen akan menjadi lebih terjangkau.',
                        'target_word' => 'are maintained ... will double ... will be (Conditional Future Synthesis)',
                        'vocab' => [
                            ['en' => 'renewable energy subsidies', 'id' => 'subsidi energi terbarukan'],
                            ['en' => 'maintained', 'id' => 'dipertahankan'],
                            ['en' => 'solar market share will double', 'id' => 'pangsa pasar surya akan berlipat ganda'],
                            ['en' => 'will be more affordable', 'id' => 'akan menjadi lebih terjangkau'],
                        ],
                        'options' => [
                            'If renewable energy subsidies are maintained, the market share of solar power will double, and electricity tariffs will be more affordable.',
                            'If renewable energy subsidies will be maintained, the market share of solar power will double, and electricity tariffs will be more affordable.',
                            'If renewable energy subsidies are maintained, the market share of solar power will doubles, and electricity tariffs will are more affordable.',
                            'If renewable energy subsidies maintain, the market share of solar power will double, and electricity tariffs will being more affordable.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa syarat pasif memakai Simple Present 'are maintained', diikuti dua klausa masa depan koordinatif: aktif 'will double' dan nominal 'will be more affordable'.",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Para insinyur memperkirakan bahwa sistem baterai solid-state akan siap untuk produksi komersial sebelum akhir dekade ini.',
                        'target_word' => 'will be ready (Future Nominal Projection)',
                        'vocab' => [
                            ['en' => 'engineers anticipate', 'id' => 'para insinyur memperkirakan'],
                            ['en' => 'solid-state battery systems', 'id' => 'sistem baterai solid-state'],
                            ['en' => 'ready for commercial production', 'id' => 'siap untuk produksi komersial'],
                        ],
                        'options' => [
                            'Engineers anticipate that solid-state battery systems will be ready for commercial mass deployment before the end of this decade.',
                            'Engineers anticipate that solid-state battery systems will ready for commercial mass deployment before the end of this decade.',
                            'Engineers anticipate that solid-state battery systems will are ready for commercial mass deployment before the end of this decade.',
                            'Engineers anticipate that solid-state battery systems will to be ready for commercial mass deployment before the end of this decade.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be ready' sebelum adjective 'ready'.",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Sebelum fase kedua uji klinis dimulai, protokol keselamatan yang diperketat akan ditinjau secara menyeluruh oleh komite penasihat independen.',
                        'target_word' => 'begins ... will be reviewed (Time Clause with Passive Main)',
                        'vocab' => [
                            ['en' => 'second phase begins', 'id' => 'fase kedua dimulai'],
                            ['en' => 'stringent safety protocols', 'id' => 'protokol keselamatan yang diperketat'],
                            ['en' => 'reviewed thoroughly', 'id' => 'ditinjau secara menyeluruh'],
                        ],
                        'options' => [
                            'Before the second clinical phase begins, stringent safety protocols will be reviewed thoroughly by an independent advisory committee.',
                            'Before the second clinical phase will begin, stringent safety protocols will be reviewed thoroughly by an independent advisory committee.',
                            'Before the second clinical phase begins, stringent safety protocols will review thoroughly by an independent advisory committee.',
                            'Before the second clinical phase will begins, stringent safety protocols will being reviewed thoroughly by an independent advisory committee.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Before' + Simple Present tunggal 'begins', disusul Future Pasif 'will be reviewed'.",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Karena data sensor menunjukkan ketidakstabilan termal yang meningkat, reaktor pendingin akan dimatikan untuk mencegah kerusakan permanen.',
                        'target_word' => 'is going to be shut down (Evidence-Based Passive)',
                        'vocab' => [
                            ['en' => 'sensor data indicates', 'id' => 'data sensor menunjukkan'],
                            ['en' => 'escalating thermal instability', 'id' => 'ketidakstabilan termal yang meningkat'],
                            ['en' => 'cooling reactor', 'id' => 'reaktor pendingin'],
                            ['en' => 'shut down', 'id' => 'dimatikan'],
                        ],
                        'options' => [
                            'Because sensor readings indicate escalating thermal instability, the auxiliary reactor is going to be shut down to prevent damage.',
                            'Because sensor readings indicate escalating thermal instability, the auxiliary reactor are going to be shut down to prevent damage.',
                            'Because sensor readings indicate escalating thermal instability, the auxiliary reactor is going to be shut down to preventing damage.',
                            'Because sensor readings indicate escalating thermal instability, the auxiliary reactor going to be shut down to prevent damage.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Prediksi berbasis bukti empiris sensor menggunakan pasif tunggal 'is going to be shut down'.",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Ketika algoritma diagnostik baru diterapkan, waktu skrining pasien akan berkurang secara substansial, yang akan meningkatkan kepuasan layanan rumah sakit.',
                        'target_word' => 'is deployed ... will decrease ... will enhance (Roadmap Multi-Clause)',
                        'vocab' => [
                            ['en' => 'diagnostic algorithm is deployed', 'id' => 'algoritma diagnostik diterapkan'],
                            ['en' => 'patient screening turnaround times', 'id' => 'waktu skrining pasien'],
                            ['en' => 'decrease substantially', 'id' => 'berkurang secara substansial'],
                            ['en' => 'enhance healthcare satisfaction', 'id' => 'meningkatkan kepuasan layanan'],
                        ],
                        'options' => [
                            'When the diagnostic algorithm is deployed, patient screening times will decrease substantially, which will enhance healthcare satisfaction.',
                            'When the diagnostic algorithm will be deployed, patient screening times will decrease substantially, which will enhance healthcare satisfaction.',
                            'When the diagnostic algorithm is deployed, patient screening times will decreases substantially, which will enhance healthcare satisfaction.',
                            'When the diagnostic algorithm is deployed, patient screening times will decrease substantially, which enhances will healthcare satisfaction.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'When' menggunakan Simple Present Pasif 'is deployed', induk kalimat memakai 'will decrease', dan relative clause hasil memakai 'which will enhance'.",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Meskipun biaya transisi awal akan tinggi, penghematan energi jangka panjang akan menguntungkan sektor industri.',
                        'target_word' => 'will be high ... will benefit (Dual Future Contrast)',
                        'vocab' => [
                            ['en' => 'initial transition expenditure', 'id' => 'biaya transisi awal'],
                            ['en' => 'high', 'id' => 'tinggi'],
                            ['en' => 'long-term energy savings', 'id' => 'penghematan energi jangka panjang'],
                            ['en' => 'benefit industrial enterprises', 'id' => 'menguntungkan sektor industri'],
                        ],
                        'options' => [
                            'Although initial transition expenditures will be high, long-term operational energy savings will benefit industrial enterprises.',
                            'Although initial transition expenditures will high, long-term operational energy savings will benefit industrial enterprises.',
                            'Although initial transition expenditures will are high, long-term operational energy savings will benefit industrial enterprises.',
                            'Although initial transition expenditures will being high, long-term operational energy savings will benefit industrial enterprises.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa konsesi memakai nominal masa depan 'will be high', disusul klausa utama verbal aktif 'will benefit'.",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Setelah vaksin baru disetujui oleh regulator kesehatan, kampanye imunisasi massal akan diluncurkan di seluruh distrik.',
                        'target_word' => 'is approved ... will be launched (Regulatory Milestone Synthesis)',
                        'vocab' => [
                            ['en' => 'vaccine is approved by regulators', 'id' => 'vaksin disetujui oleh regulator'],
                            ['en' => 'mass immunization drive', 'id' => 'kampanye imunisasi massal'],
                            ['en' => 'launched across all provinces', 'id' => 'diluncurkan di seluruh distrik'],
                        ],
                        'options' => [
                            'After the novel vaccine is approved by healthcare regulators, a nationwide immunization drive will be launched across all provinces.',
                            'After the novel vaccine will be approved by healthcare regulators, a nationwide immunization drive will be launched across all provinces.',
                            'After the novel vaccine is approved by healthcare regulators, a nationwide immunization drive will launch across all provinces.',
                            'After the novel vaccine will approve by healthcare regulators, a nationwide immunization drive will be launched across all provinces.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'After' + Simple Present Pasif 'is approved', diikuti Future Pasif 'will be launched'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Jika emisi gas rumah kaca tidak dikurangi secara drastis, frekuensi bencana alam ekstrem akan meningkat dan ketahanan pangan akan terancam.',
                        'target_word' => 'are not reduced ... will increase ... will be compromised (Triple Future Clause)',
                        'vocab' => [
                            ['en' => 'greenhouse emissions are not curtailed', 'id' => 'emisi gas rumah kaca tidak dikurangi'],
                            ['en' => 'frequency of extreme weather disasters', 'id' => 'frekuensi bencana alam ekstrem'],
                            ['en' => 'will increase', 'id' => 'akan meningkat'],
                            ['en' => 'food security will be compromised', 'id' => 'ketahanan pangan akan terancam'],
                        ],
                        'options' => [
                            'If greenhouse gas emissions are not curtailed drastically, the frequency of extreme natural disasters will increase and food security will be compromised.',
                            'If greenhouse gas emissions will not be curtailed drastically, the frequency of extreme natural disasters will increase and food security will be compromised.',
                            'If greenhouse gas emissions are not curtailed drastically, the frequency of extreme natural disasters will increases and food security will compromise.',
                            'If greenhouse gas emissions are not curtailed drastically, the frequency of extreme natural disasters will increase and food security will compromised.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' memakai Simple Present Pasif negatif 'are not curtailed'. Induk kalimat memadukan aktif 'will increase' dan pasif 'will be compromised'.",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Peta jalan penelitian ini mengonfirmasi bahwa teknologi komputasi kuantum akan menjadi fondasi bagi keamanan siber masa depan segera setelah algoritma enkripsi pasca-kuantum distandarisasi.',
                        'target_word' => 'will be ... as soon as ... are standardized (Research Roadmap Climax)',
                        'vocab' => [
                            ['en' => 'research roadmap confirms', 'id' => 'peta jalan penelitian mengonfirmasi'],
                            ['en' => 'quantum computing', 'id' => 'komputasi kuantum'],
                            ['en' => 'foundation of cybersecurity', 'id' => 'fondasi keamanan siber'],
                            ['en' => 'post-quantum cryptographic algorithms are standardized', 'id' => 'algoritma enkripsi distandarisasi'],
                        ],
                        'options' => [
                            'This research roadmap confirms that quantum computing will be the cornerstone of future cybersecurity as soon as post-quantum algorithms are standardized.',
                            'This research roadmap confirms that quantum computing will be the cornerstone of future cybersecurity as soon as post-quantum algorithms will be standardized.',
                            'This research roadmap confirms that quantum computing will the cornerstone of future cybersecurity as soon as post-quantum algorithms are standardized.',
                            'This research roadmap confirms that quantum computing will is the cornerstone of future cybersecurity as soon as post-quantum algorithms are standardized.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa komplemen memakai Future Nominal 'will be the cornerstone', disusul klausa waktu 'as soon as' dengan Simple Present Pasif jamak 'are standardized'.",
                    ],
                ]
            ],
        ];
    }
}
