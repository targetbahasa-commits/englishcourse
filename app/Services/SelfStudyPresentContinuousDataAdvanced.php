<?php

namespace App\Services;

class SelfStudyPresentContinuousDataAdvanced
{
    /**
     * Get the complete Present Continuous Tense (Verbal & Passive) package.
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
            'banner_title' => 'Present Continuous Tense (Verbal & Passive) in Academic Writing',
            'banner_subtitle' => 'Kuasai pelaporan tren kontemporer, fenomena dinamis yang sedang berlangsung (is/are + V-ing), prosedur laboratorium/operasional yang sedang diproses (is/are being + V3), perbedaan situasi temporer vs permanen, serta pengecualian stative verbs.',
            'banner_badge' => 'MODULE 1.9 PRESENT CONTINUOUS TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.9
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Present Continuous Tense: Verbal & Pasif dalam Penulisan Ilmiah & Pelaporan Tren',
            'concept_summary' => 'Present Continuous Tense dalam penulisan formal dan akademis (termasuk IELTS Academic Task 1 & Task 2) memiliki fungsi strategis: bukan sekadar menyatakan apa yang sedang terjadi detik ini, melainkan mendeskripsikan tren perubahan bertahap (gradual changes), pergeseran kontemporer (contemporary shifts), proses eksperimental/kebijakan yang sedang berlangsung (ongoing procedures), dan situasi transisional (temporary situations). Dua pilar utamanya adalah Bentuk Verbal Aktif (is/am/are + V-ing) dan Bentuk Pasif Dinamis (is/am/are + being + V3).',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Ongoing Actions & Real-Time Observation',
                    'rule_formula' => 'Subject + am/is/are + Verb-ing + Complement',
                    'rule_description' => 'Digunakan ketika subjek secara aktif sedang menjalankan suatu tindakan dalam kurun waktu observasi sekarang. "is" untuk subjek tunggal (he, she, it, singular noun), "are" untuk subjek jamak (they, we, plural nouns), dan "am" untuk subjek I.',
                    'examples' => [
                        [
                            'en' => 'The research team is currently observing particle reactions under an electron microscope.',
                            'id' => 'Tim riset saat ini sedang mengamati reaksi partikel di bawah mikroskop elektron.',
                            'note' => 'Subjek "The research team" (entitas tunggal) menggunakan to be "is" + V-ing "observing".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Melaporkan Tren Dinamis & Perubahan Bertahap (IELTS Writing Task 1)',
                    'rule_formula' => 'Trend Subject + is/are + changing verb (-ing) + Adverb of Degree',
                    'rule_description' => 'Kata kerja perubahan seperti increase, decrease, expand, deteriorate, shrink, shift, surge, decline, dan grow dipadukan dengan continuous tense untuk melukiskan tren yang belum mencapai titik akhir.',
                    'examples' => [
                        [
                            'en' => 'Global consumer preferences are shifting toward eco-friendly and sustainable products.',
                            'id' => 'Preferensi konsumen global sedang bergeser ke arah produk ramah lingkungan dan berkelanjutan.',
                            'note' => 'Menunjukkan proses pergeseran tren yang sedang bergulir di era kontemporer.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif: Ongoing Operations & Processes (is/are + being + V3)',
                    'rule_formula' => 'Passive Subject + am/is/are + being + Verb 3 (Past Participle)',
                    'rule_description' => 'Dalam laporan ilmiah, fokus sering kali terletak pada objek riset atau kebijakan yang sedang diproses/dikerjakan, bukan pada penelitinya. Sisipan "being" wajib hadir di antara to be dan V3 untuk membedakannya dengan Simple Present Passive biasa.',
                    'examples' => [
                        [
                            'en' => 'New occupational safety procedures are being implemented across manufacturing facilities.',
                            'id' => 'Prosedur keselamatan kerja yang baru sedang diterapkan di seluruh fasilitas manufaktur.',
                            'note' => 'Bandingkan: "are implemented" (rutin/fakta baku) vs "are being implemented" (prosesnya sedang berlangsung sekarang).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Situasi Temporer (Continuous) vs Fakta Permanen (Simple Present)',
                    'rule_formula' => 'Permanent: Subject + V1/V-s | Temporary: Subject + is/are + V-ing',
                    'rule_description' => 'Gunakan Simple Present untuk karakteristik dasar, hukum alam, atau operasi standar. Gunakan Present Continuous bila situasi tersebut bersifat transisi sementara yang diiringi penanda waktu seperti "currently, temporarily, this semester, at present".',
                    'examples' => [
                        [
                            'en' => 'The organization is currently hosting an international symposium in Geneva.',
                            'id' => 'Organisasi tersebut saat ini sedang menyelenggarakan simposium internasional di Jenewa.',
                            'note' => '"is currently hosting" menunjukkan situasi temporer yang sedang berlangsung saat ini dalam kalimat tunggal.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Aturan Ketat Stative Verbs (Kata Kerja Status Non-Continuous)',
                    'rule_formula' => 'Subject + Stative Verb (Simple Present)',
                    'rule_description' => 'Kata kerja yang menyatakan status mental, kognisi, kepemilikan, atau persepsi (misal: understand, believe, contain, belong, possess, require, resemble, lack, consist of) TIDAK BOLEH diubah menjadi bentuk Continuous meskipun dalam konteks "saat ini".',
                    'examples' => [
                        [
                            'en' => 'The committee understands the challenge. (BUKAN: The committee is understanding the challenge.)',
                            'id' => 'Komite memahami tantangan tersebut.',
                            'note' => '"understand" adalah kata kerja status kognitif yang tidak memiliki progresivitas fisik.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '6. Bentuk Negatif & Interrogative Akademik',
                    'rule_formula' => 'Neg: Subject + is/are not + V-ing | Interrog: Is/Are + Subject + V-ing?',
                    'rule_description' => 'Dalam menyangkal hipotesis berjalan atau mengajukan pertanyaan riset eksploratif, letakkan "not" tepat setelah to be (is not / are not) sebelum partikel V-ing atau being.',
                    'examples' => [
                        [
                            'en' => 'Clinical data is not being stored on unencrypted public servers.',
                            'id' => 'Data klinis tidak sedang disimpan di server publik yang tidak terenkripsi.',
                            'note' => 'Penyangkalan pasif formal: is not being stored.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '7. Adverbia Derajat & Waktu Pendukung Continuous Tense',
                    'rule_formula' => 'currently, steadily, gradually, rapidly, at present, at this juncture',
                    'rule_description' => 'Adverbia kecepatan dan transisi biasanya diletakkan di antara auxiliary dan main verb (misal: "is steadily increasing") atau di awal klausa ("Currently, researchers are analyzing...") untuk memperkuat nuansa akademik formal.',
                    'examples' => [
                        [
                            'en' => 'Groundwater reserves in the semi-arid region are steadily depleting.',
                            'id' => 'Cadangan air tanah di wilayah semi-kering tersebut sedang menurun drastis secara stabil.',
                            'note' => '"steadily" diletakkan di antara auxiliary "are" dan verb "depleting".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '8. Struktur Tunggal Pelaporan Tren (Writing Task 1 & 2)',
                    'rule_formula' => 'Subject + is/are + continuous verb + Adverbial Modifier',
                    'rule_description' => 'Gunakan kalimat tunggal yang efektif dengan adverbia terarah untuk melaporkan tren dinamis secara objektif.',
                    'examples' => [
                        [
                            'en' => 'The renewable energy sector is currently attracting massive private investment worldwide.',
                            'id' => 'Sektor energi terbarukan saat ini sedang menarik investasi swasta yang masif di seluruh dunia.',
                            'note' => 'Bentuk kalimat tunggal: Subjek "The renewable energy sector" + "is currently attracting" + Objek + Keterangan.'
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
            // Sub-Lesson 1.9.1
            [
                'id' => 'present-continuous-verbal',
                'name' => '1.9.1 Present Continuous Verbal: Ongoing Actions & Real-Time Phenomena',
                'code' => '1.9.1',
                'concept_title' => 'Present Continuous Verbal: Ongoing Actions & Real-Time Observation',
                'concept_description' => 'Present Continuous Verbal digunakan untuk menyatakan tindakan yang sedang aktif dikerjakan oleh subjek dalam kurun waktu observasi sekarang. Konstruksi dibentuk dari to be (am/is/are) yang diselaraskan dengan subjek, diikuti oleh kata kerja berakhiran -ing (present participle).',
                'description' => 'Present Continuous Verbal digunakan untuk menyatakan tindakan yang sedang aktif dikerjakan oleh subjek dalam kurun waktu observasi sekarang. Konstruksi dibentuk dari to be (am/is/are) yang diselaraskan dengan subjek, diikuti oleh kata kerja berakhiran -ing (present participle).',
                'formula' => 'Subject + am/is/are + Verb-ing + Object / Prepositional Phrase',
                'rules' => [
                    'Gunakan \\"is\\" untuk subjek tunggal (he, she, it, singular noun).',
                    'Gunakan \\"are\\" untuk subjek jamak (they, we, plural nouns).',
                    'Gunakan \\"am\\" untuk subjek \\"I\\".',
                    'Pastikan ada auxiliary (to be) sebelum V-ing; meniadakan to be adalah kesalahan fatal.'
                ], 
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Para insinyur perangkat lunak sedang menguji pembaruan keamanan terbaru pada server inti.',
                        'target_word' => 'are testing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'software engineers', 'id' => 'insinyur perangkat lunak'],
                            ['en' => 'core servers', 'id' => 'server inti'],
                            ['en' => 'security update', 'id' => 'pembaruan keamanan']
                        ],
                        'options' => [
                            'The software engineers are testing the latest security update on the core servers.',
                            'The software engineers is testing the latest security update on the core servers.',
                            'The software engineers are tested the latest security update on the core servers.',
                            'The software engineers testing the latest security update on the core servers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The software engineers" membutuhkan auxiliary "are" diikuti V-ing "testing" untuk membentuk Present Continuous Verbal aktif.'
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Tim riset saat ini sedang mengamati reaksi partikel di bawah mikroskop elektron.',
                        'target_word' => 'is observing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'research team', 'id' => 'tim riset'],
                            ['en' => 'particle reaction', 'id' => 'reaksi partikel'],
                            ['en' => 'electron microscope', 'id' => 'mikroskop elektron']
                        ],
                        'options' => [
                            'The research team is currently observing the particle reaction under an electron microscope.',
                            'The research team are currently observing the particle reaction under an electron microscope.',
                            'The research team is currently observe the particle reaction under an electron microscope.',
                            'The research team currently observing the particle reaction under an electron microscope.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kolektif noun "The research team" bertindak sebagai kesatuan tunggal (singular entity) sehingga menggunakan "is currently observing".'
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Direktur program sedang meninjau proposal hibah penelitian bersama dewan penasihat.',
                        'target_word' => 'is reviewing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'program director', 'id' => 'direktur program'],
                            ['en' => 'research grant proposal', 'id' => 'proposal hibah penelitian'],
                            ['en' => 'advisory board', 'id' => 'dewan penasihat']
                        ],
                        'options' => [
                            'The program director is reviewing the research grant proposal with the advisory board.',
                            'The program director are reviewing the research grant proposal with the advisory board.',
                            'The program director is reviewed the research grant proposal with the advisory board.',
                            'The program director reviewing the research grant proposal with the advisory board.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The program director" berpasangan dengan "is" + V-ing "reviewing".'
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Para astronom sedang memantau lintasan asteroid baru yang mendekati orbit bumi.',
                        'target_word' => 'are monitoring (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'astronomers', 'id' => 'para astronom'],
                            ['en' => 'trajectory', 'id' => 'lintasan'],
                            ['en' => 'Earth\'s orbit', 'id' => 'orbit bumi']
                        ],
                        'options' => [
                            'Astronomers are monitoring the trajectory of a new asteroid approaching Earth\'s orbit.',
                            'Astronomers is monitoring the trajectory of a new asteroid approaching Earth\'s orbit.',
                            'Astronomers are monitor the trajectory of a new asteroid approaching Earth\'s orbit.',
                            'Astronomers monitoring the trajectory of a new asteroid approaching Earth\'s orbit.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "Astronomers" membutuhkan to be jamak "are" sebelum present participle "monitoring".'
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Dokter spesialis tersebut sedang memeriksa respons pasien terhadap obat eksperimental.',
                        'target_word' => 'is examining (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'specialist', 'id' => 'dokter spesialis'],
                            ['en' => 'patient\'s response', 'id' => 'respons pasien'],
                            ['en' => 'experimental medication', 'id' => 'obat eksperimental']
                        ],
                        'options' => [
                            'The specialist is examining the patient\'s response to the experimental medication.',
                            'The specialist are examining the patient\'s response to the experimental medication.',
                            'The specialist is examine the patient\'s response to the experimental medication.',
                            'The specialist has examining the patient\'s response to the experimental medication.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The specialist" adalah orang ketiga tunggal, sehingga formula verbal masa kini yang tepat adalah "is examining".'
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Para analis sedang mengevaluasi data transaksi keuangan untuk mendeteksi anomali.',
                        'target_word' => 'are evaluating (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'analysts', 'id' => 'para analis'],
                            ['en' => 'financial transaction data', 'id' => 'data transaksi keuangan'],
                            ['en' => 'detect anomalies', 'id' => 'mendeteksi anomali']
                        ],
                        'options' => [
                            'The analysts are evaluating financial transaction data to detect anomalies.',
                            'The analysts is evaluating financial transaction data to detect anomalies.',
                            'The analysts are evaluate financial transaction data to detect anomalies.',
                            'The analysts were evaluating financial transaction data to detect anomalies.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The analysts" berpasangan dengan "are evaluating". Pilihan "were" tidak tepat karena merujuk konteks lampau.'
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Koordinator proyek sedang memfasilitasi lokakarya interaktif bagi para pemangku kepentingan.',
                        'target_word' => 'is facilitating (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'project coordinator', 'id' => 'koordinator proyek'],
                            ['en' => 'interactive workshop', 'id' => 'lokakarya interaktif'],
                            ['en' => 'stakeholders', 'id' => 'pemangku kepentingan']
                        ],
                        'options' => [
                            'The project coordinator is facilitating an interactive workshop for stakeholders.',
                            'The project coordinator are facilitating an interactive workshop for stakeholders.',
                            'The project coordinator is facilitate an interactive workshop for stakeholders.',
                            'The project coordinator facilitating an interactive workshop for stakeholders.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The project coordinator" memerlukan auxiliary "is" + "facilitating".'
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Petugas lingkungan sedang mengumpulkan sampel tanah di sepanjang bantaran sungai yang tercemar.',
                        'target_word' => 'are collecting (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'environmental officers', 'id' => 'petugas lingkungan'],
                            ['en' => 'soil samples', 'id' => 'sampel tanah'],
                            ['en' => 'contaminated riverbank', 'id' => 'bantaran sungai yang tercemar']
                        ],
                        'options' => [
                            'Environmental officers are collecting soil samples along the contaminated riverbank.',
                            'Environmental officers is collecting soil samples along the contaminated riverbank.',
                            'Environmental officers are collect soil samples along the contaminated riverbank.',
                            'Environmental officers being collecting soil samples along the contaminated riverbank.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "Environmental officers" menggunakan auxiliary "are" + V-ing "collecting".'
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Para ahli klimatologi sedang mencatat fluktuasi suhu permukaan laut di Samudra Pasifik.',
                        'target_word' => 'are recording (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'climatologists', 'id' => 'ahli klimatologi'],
                            ['en' => 'sea surface temperature fluctuations', 'id' => 'fluktuasi suhu permukaan laut'],
                            ['en' => 'Pacific Ocean', 'id' => 'Samudra Pasifik']
                        ],
                        'options' => [
                            'Climatologists are recording sea surface temperature fluctuations in the Pacific Ocean.',
                            'Climatologists is recording sea surface temperature fluctuations in the Pacific Ocean.',
                            'Climatologists are recorded sea surface temperature fluctuations in the Pacific Ocean.',
                            'Climatologists recording sea surface temperature fluctuations in the Pacific Ocean.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Climatologists" (jamak) berpasangan dengan "are recording". Bentuk "are recorded" adalah bentuk pasif (di-catat).'
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Kepala perpustakaan universitas sedang mengarsipkan manuskrip abad pertengahan yang baru ditemukan.',
                        'target_word' => 'is archiving (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'head librarian', 'id' => 'kepala perpustakaan'],
                            ['en' => 'newly discovered', 'id' => 'baru ditemukan'],
                            ['en' => 'medieval manuscripts', 'id' => 'manuskrip abad pertengahan']
                        ],
                        'options' => [
                            'The university head librarian is archiving the newly discovered medieval manuscripts.',
                            'The university head librarian are archiving the newly discovered medieval manuscripts.',
                            'The university head librarian is archive the newly discovered medieval manuscripts.',
                            'The university head librarian archiving the newly discovered medieval manuscripts.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The university head librarian" mengambil to be "is" + V-ing "archiving".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.2
            [
                'id' => 'continuous-trends-changes',
                'name' => '1.9.2 Describing Dynamic Trends & Changing Situations',
                'code' => '1.9.2',
                'concept_title' => 'Describing Dynamic Trends & Changing Situations',
                'concept_description' => 'Dalam penulisan analitis dan pelaporan data (seperti IELTS Academic Writing Task 1), Present Continuous digunakan secara intensif dengan kata kerja perubahan (verbs of change) untuk menggambarkan tren yang sedang berproses dan belum mencapai titik henti tetap.',
                'description' => 'Dalam penulisan analitis dan pelaporan data (seperti IELTS Academic Writing Task 1), Present Continuous digunakan secara intensif dengan kata kerja perubahan (verbs of change) untuk menggambarkan tren yang sedang berproses dan belum mencapai titik henti tetap.',
                'formula' => 'Trend Subject + is/are + changing verb (-ing) + Adverb of Degree / Proportion',
                'rules' => [
                    'Verba umum perubahan meliputi: increase, decrease, rise, fall, decline, grow, shrink, expand, shift, deteriorate, improve.',
                    'Perhatikan head noun dari frasa subjek kompleks untuk menentukan to be (The adoption rate of ... -> is, bukan are).',
                    'Padukan dengan adverbia derajat untuk presisi akademik: significantly, steadily, rapidly, gradually.'
                ], 
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Tingkat adopsi energi terbarukan di negara-negara berkembang sedang meningkat secara signifikan.',
                        'target_word' => 'is increasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'adoption rate', 'id' => 'tingkat adopsi'],
                            ['en' => 'renewable energy', 'id' => 'energi terbarukan'],
                            ['en' => 'developing countries', 'id' => 'negara-negara berkembang']
                        ],
                        'options' => [
                            'The adoption rate of renewable energy in developing countries is increasing significantly.',
                            'The adoption rate of renewable energy in developing countries are increasing significantly.',
                            'The adoption rate of renewable energy in developing countries is increase significantly.',
                            'The adoption rate of renewable energy in developing countries increasing significantly.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun dari subjek adalah "The adoption rate" (tunggal), bukan "countries". Maka verb yang tepat adalah "is increasing".'
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Biaya produksi panel surya sedang menurun secara bertahap karena kemajuan manufaktur.',
                        'target_word' => 'is decreasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'production cost', 'id' => 'biaya produksi'],
                            ['en' => 'solar panels', 'id' => 'panel surya'],
                            ['en' => 'manufacturing advancements', 'id' => 'kemajuan manufaktur']
                        ],
                        'options' => [
                            'The production cost of solar panels is gradually decreasing due to manufacturing advancements.',
                            'The production cost of solar panels are gradually decreasing due to manufacturing advancements.',
                            'The production cost of solar panels is gradually decrease due to manufacturing advancements.',
                            'The production cost of solar panels gradually decreasing due to manufacturing advancements.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Inti subjek adalah "The production cost" (tunggal), sehingga kata kerja tren yang tepat adalah "is gradually decreasing".'
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Preferensi konsumen global sedang bergeser ke arah produk ramah lingkungan dan berkelanjutan.',
                        'target_word' => 'are shifting (Trend of Change)',
                        'vocab' => [
                            ['en' => 'consumer preferences', 'id' => 'preferensi konsumen'],
                            ['en' => 'eco-friendly', 'id' => 'ramah lingkungan'],
                            ['en' => 'sustainable products', 'id' => 'produk berkelanjutan']
                        ],
                        'options' => [
                            'Global consumer preferences are shifting toward eco-friendly and sustainable products.',
                            'Global consumer preferences is shifting toward eco-friendly and sustainable products.',
                            'Global consumer preferences are shift toward eco-friendly and sustainable products.',
                            'Global consumer preferences shifting toward eco-friendly and sustainable products.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "preferences" berbentuk jamak, sehingga memerlukan "are shifting".'
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Populasi perkotaan di Asia Tenggara sedang bertumbuh pada tingkat yang belum pernah terjadi sebelumnya.',
                        'target_word' => 'is growing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'urban population', 'id' => 'populasi perkotaan'],
                            ['en' => 'Southeast Asia', 'id' => 'Asia Tenggara'],
                            ['en' => 'unprecedented rate', 'id' => 'tingkat yang belum pernah terjadi sebelumnya']
                        ],
                        'options' => [
                            'The urban population in Southeast Asia is growing at an unprecedented rate.',
                            'The urban population in Southeast Asia are growing at an unprecedented rate.',
                            'The urban population in Southeast Asia is grow at an unprecedented rate.',
                            'The urban population in Southeast Asia growing at an unprecedented rate.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Population" dihitung sebagai collective noun tunggal dalam konteks demografi umum, sehingga menggunakan "is growing".'
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Kualitas air di kawasan industri tersebut sedang memburuk akibat limbah yang tidak diolah.',
                        'target_word' => 'is deteriorating (Trend of Change)',
                        'vocab' => [
                            ['en' => 'water quality', 'id' => 'kualitas air'],
                            ['en' => 'industrial zone', 'id' => 'kawasan industri'],
                            ['en' => 'untreated waste', 'id' => 'limbah yang tidak diolah']
                        ],
                        'options' => [
                            'Water quality in the industrial zone is deteriorating due to untreated waste.',
                            'Water quality in the industrial zone are deteriorating due to untreated waste.',
                            'Water quality in the industrial zone is deteriorate due to untreated waste.',
                            'Water quality in the industrial zone deteriorating due to untreated waste.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Water quality" adalah uncountable noun tunggal, sehingga to be yang tepat adalah "is" + V-ing "deteriorating".'
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Permintaan pasar terhadap tenaga profesional kecerdasan buatan sedang melonjak tajam.',
                        'target_word' => 'is soaring (Trend of Change)',
                        'vocab' => [
                            ['en' => 'market demand', 'id' => 'permintaan pasar'],
                            ['en' => 'artificial intelligence professionals', 'id' => 'tenaga profesional kecerdasan buatan'],
                            ['en' => 'soaring dramatically', 'id' => 'melonjak tajam']
                        ],
                        'options' => [
                            'Market demand for artificial intelligence professionals is soaring dramatically.',
                            'Market demand for artificial intelligence professionals are soaring dramatically.',
                            'Market demand for artificial intelligence professionals is soar dramatically.',
                            'Market demand for artificial intelligence professionals soaring dramatically.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun adalah "Market demand" (tunggal), maka verb yang benar adalah "is soaring". Frasa "for artificial intelligence professionals" adalah modifier preposisional.'
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Keanekaragaman hayati di hutan hujan tropis sedang menyusut dengan kecepatan yang mengkhawatirkan.',
                        'target_word' => 'is shrinking (Trend of Change)',
                        'vocab' => [
                            ['en' => 'biodiversity', 'id' => 'keanekaragaman hayati'],
                            ['en' => 'tropical rainforests', 'id' => 'hutan hujan tropis'],
                            ['en' => 'alarming rate', 'id' => 'kecepatan yang mengkhawatirkan']
                        ],
                        'options' => [
                            'Biodiversity in tropical rainforests is shrinking at an alarming rate.',
                            'Biodiversity in tropical rainforests are shrinking at an alarming rate.',
                            'Biodiversity in tropical rainforests is shrink at an alarming rate.',
                            'Biodiversity in tropical rainforests shrinking at an alarming rate.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Biodiversity" (kata benda tak terhitung tunggal) berpasangan dengan "is shrinking".'
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Kesenjangan ekonomi antara wilayah perkotaan dan perdesaan sedang melebar di banyak negara.',
                        'target_word' => 'is widening (Trend of Change)',
                        'vocab' => [
                            ['en' => 'economic gap', 'id' => 'kesenjangan ekonomi'],
                            ['en' => 'urban and rural areas', 'id' => 'wilayah perkotaan dan perdesaan'],
                            ['en' => 'widening', 'id' => 'melebar']
                        ],
                        'options' => [
                            'The economic gap between urban and rural areas is widening in many countries.',
                            'The economic gap between urban and rural areas are widening in many countries.',
                            'The economic gap between urban and rural areas is widen in many countries.',
                            'The economic gap between urban and rural areas widening in many countries.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek utama kalimat adalah "The economic gap" (tunggal), sehingga auxiliary yang sesuai adalah "is widening".'
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Aksesibilitas layanan telemedisin sedang berkembang pesat di kalangan masyarakat terpencil.',
                        'target_word' => 'is expanding (Trend of Change)',
                        'vocab' => [
                            ['en' => 'accessibility', 'id' => 'aksesibilitas'],
                            ['en' => 'telemedicine services', 'id' => 'layanan telemedisin'],
                            ['en' => 'remote communities', 'id' => 'masyarakat terpencil']
                        ],
                        'options' => [
                            'The accessibility of telemedicine services is expanding rapidly among remote communities.',
                            'The accessibility of telemedicine services are expanding rapidly among remote communities.',
                            'The accessibility of telemedicine services is expand rapidly among remote communities.',
                            'The accessibility of telemedicine services expanding rapidly among remote communities.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The accessibility" adalah singular noun, maka pola yang benar adalah "is expanding".'
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Tingkat pengangguran di sektor manufaktur tradisional sedang berkurang seiring transisi ekonomi.',
                        'target_word' => 'is declining (Trend of Change)',
                        'vocab' => [
                            ['en' => 'unemployment rate', 'id' => 'tingkat pengangguran'],
                            ['en' => 'traditional manufacturing sector', 'id' => 'sektor manufaktur tradisional'],
                            ['en' => 'economic transition', 'id' => 'transisi ekonomi']
                        ],
                        'options' => [
                            'The unemployment rate in the traditional manufacturing sector is declining as the economy transitions.',
                            'The unemployment rate in the traditional manufacturing sector are declining as the economy transitions.',
                            'The unemployment rate in the traditional manufacturing sector is decline as the economy transitions.',
                            'The unemployment rate in the traditional manufacturing sector declining as the economy transitions.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The unemployment rate" adalah subjek tunggal, sehingga verb tren yang tepat adalah "is declining".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.3
            [
                'id' => 'present-continuous-passive',
                'name' => '1.9.3 Present Continuous Passive: Ongoing Operations & Processes',
                'code' => '1.9.3',
                'concept_title' => 'Present Continuous Passive: Ongoing Operations & Processes',
                'concept_description' => 'Bentuk pasif continuous digunakan saat fokus utama kalimat adalah objek riset, sampel, infrastruktur, atau kebijakan yang sedang diproses atau ditangani tanpa memprioritaskan pelaku tindakan. Sisipan partikel \\"being\\" wajib hadir di antara to be dan V3.',
                'description' => 'Bentuk pasif continuous digunakan saat fokus utama kalimat adalah objek riset, sampel, infrastruktur, atau kebijakan yang sedang diproses atau ditangani tanpa memprioritaskan pelaku tindakan. Sisipan partikel \\"being\\" wajib hadir di antara to be dan V3.',
                'formula' => 'Subject (Patient) + am/is/are + being + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    'Rumus wajib: to be (am/is/are) + being + Past Participle (V3).',
                    'Jangan tertukar dengan Present Perfect Passive (have/has been + V3); continuous pasif selalu memakai \\"being\\", bukan \\"been\\".',
                    'Jika subjek jamak gunakan \\"are being + V3\\", jika tunggal gunakan \\"is being + V3\\".'
                ], 
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Prosedur keselamatan kerja yang baru sedang diterapkan di seluruh fasilitas manufaktur.',
                        'target_word' => 'are being implemented (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'occupational safety procedures', 'id' => 'prosedur keselamatan kerja'],
                            ['en' => 'implemented', 'id' => 'diterapkan'],
                            ['en' => 'manufacturing facilities', 'id' => 'fasilitas manufaktur']
                        ],
                        'options' => [
                            'New occupational safety procedures are being implemented across manufacturing facilities.',
                            'New occupational safety procedures are implementing across manufacturing facilities.',
                            'New occupational safety procedures is being implemented across manufacturing facilities.',
                            'New occupational safety procedures are been implemented across manufacturing facilities.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek pasif jamak "procedures" membutuhkan formula pasif continuous: "are" + "being" + V3 "implemented". Bentuk "been" hanya untuk perfect tense.'
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sebuah studi komparatif berskala besar sedang dilakukan oleh konsorsium universitas.',
                        'target_word' => 'is being conducted (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'comparative study', 'id' => 'studi komparatif'],
                            ['en' => 'large-scale', 'id' => 'berskala besar'],
                            ['en' => 'university consortium', 'id' => 'konsorsium universitas']
                        ],
                        'options' => [
                            'A large-scale comparative study is being conducted by the university consortium.',
                            'A large-scale comparative study are being conducted by the university consortium.',
                            'A large-scale comparative study is conducting by the university consortium.',
                            'A large-scale comparative study is been conducted by the university consortium.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "A large-scale comparative study" memerlukan "is being conducted".'
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Data mentah dari sensus penduduk sedang diproses oleh unit komputasi terpusat.',
                        'target_word' => 'is being processed (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'raw data', 'id' => 'data mentah'],
                            ['en' => 'population census', 'id' => 'sensus penduduk'],
                            ['en' => 'centralized computing unit', 'id' => 'unit komputasi terpusat']
                        ],
                        'options' => [
                            'The raw data from the population census is being processed by the centralized computing unit.',
                            'The raw data from the population census are being process by the centralized computing unit.',
                            'The raw data from the population census is processing by the centralized computing unit.',
                            'The raw data from the population census being processed by the centralized computing unit.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Raw data" dalam konteks komputasi massa sering diperlakukan sebagai singular mass noun dengan pola "is being processed". Opsi A merupakan struktur pasif continuous yang tepat.'
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Vaksin generasi berikutnya sedang diuji dalam uji klinis fase ketiga.',
                        'target_word' => 'is being tested (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'next-generation vaccine', 'id' => 'vaksin generasi berikutnya'],
                            ['en' => 'clinical trials', 'id' => 'uji klinis'],
                            ['en' => 'phase three', 'id' => 'fase ketiga']
                        ],
                        'options' => [
                            'The next-generation vaccine is being tested in phase three clinical trials.',
                            'The next-generation vaccine are being tested in phase three clinical trials.',
                            'The next-generation vaccine is testing in phase three clinical trials.',
                            'The next-generation vaccine has being tested in phase three clinical trials.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "vaccine" adalah tunggal dan menerima tindakan ("sedang diuji"), sehingga memerlukan "is being tested".'
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Infrastruktur transportasi umum perkotaan sedang direnovasi untuk mengurangi emisi karbon.',
                        'target_word' => 'is being upgraded (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'public transport infrastructure', 'id' => 'infrastruktur transportasi umum'],
                            ['en' => 'upgraded', 'id' => 'direnovasi/ditingkatkan'],
                            ['en' => 'carbon emissions', 'id' => 'emisi karbon']
                        ],
                        'options' => [
                            'Urban public transport infrastructure is being upgraded to reduce carbon emissions.',
                            'Urban public transport infrastructure are being upgraded to reduce carbon emissions.',
                            'Urban public transport infrastructure is upgrading to reduce carbon emissions.',
                            'Urban public transport infrastructure being upgraded to reduce carbon emissions.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Infrastructure" adalah uncountable noun tunggal, sehingga rumusnya adalah "is being upgraded".'
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Kelayakan ekonomi dari proyek hidroelektrik tersebut sedang dinilai secara menyeluruh.',
                        'target_word' => 'is being assessed (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'economic feasibility', 'id' => 'kelayakan ekonomi'],
                            ['en' => 'hydroelectric project', 'id' => 'proyek hidroelektrik'],
                            ['en' => 'assessed thoroughly', 'id' => 'dinilai secara menyeluruh']
                        ],
                        'options' => [
                            'The economic feasibility of the hydroelectric project is being assessed thoroughly.',
                            'The economic feasibility of the hydroelectric project are being assessed thoroughly.',
                            'The economic feasibility of the hydroelectric project is assessing thoroughly.',
                            'The economic feasibility of the hydroelectric project has been assess thoroughly.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun "The economic feasibility" berbentuk tunggal, maka bentuk pasif continuous yang tepat adalah "is being assessed".'
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Laporan keuangan tahunan perusahaan multinasional itu sedang diaudit oleh akuntan independen.',
                        'target_word' => 'is being audited (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'annual financial report', 'id' => 'laporan keuangan tahunan'],
                            ['en' => 'multinational corporation', 'id' => 'perusahaan multinasional'],
                            ['en' => 'independent accountants', 'id' => 'akuntan independen']
                        ],
                        'options' => [
                            'The multinational corporation\'s annual financial report is being audited by independent accountants.',
                            'The multinational corporation\'s annual financial report are being audited by independent accountants.',
                            'The multinational corporation\'s annual financial report is auditing by independent accountants.',
                            'The multinational corporation\'s annual financial report being audited by independent accountants.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "financial report" (tunggal) dipadukan dengan pola pasif continuous "is being audited".'
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Penyebab utama dari gangguan jaringan satelit sedang diselidiki oleh para insinyur telekomunikasi.',
                        'target_word' => 'is being investigated (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'root cause', 'id' => 'penyebab utama'],
                            ['en' => 'satellite network disruption', 'id' => 'gangguan jaringan satelit'],
                            ['en' => 'telecommunications engineers', 'id' => 'insinyur telekomunikasi']
                        ],
                        'options' => [
                            'The root cause of the satellite network disruption is being investigated by telecommunications engineers.',
                            'The root cause of the satellite network disruption are being investigated by telecommunications engineers.',
                            'The root cause of the satellite network disruption is investigating by telecommunications engineers.',
                            'The root cause of the satellite network disruption being investigated by telecommunications engineers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek utama "The root cause" adalah tunggal, sehingga memerlukan "is being investigated".'
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Materi kurikulum sains terpadu sedang direvisi untuk memenuhi standar pendidikan internasional.',
                        'target_word' => 'is being revised (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'integrated science curriculum material', 'id' => 'materi kurikulum sains terpadu'],
                            ['en' => 'revised', 'id' => 'direvisi'],
                            ['en' => 'international educational standards', 'id' => 'standar pendidikan internasional']
                        ],
                        'options' => [
                            'The integrated science curriculum material is being revised to meet international educational standards.',
                            'The integrated science curriculum material are being revised to meet international educational standards.',
                            'The integrated science curriculum material is revising to meet international educational standards.',
                            'The integrated science curriculum material being revised to meet international educational standards.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "material" (uncountable/singular) membutuhkan "is being revised".'
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Pedoman etika kecerdasan buatan sedang dirumuskan oleh komite antar-lembaga pemerintah.',
                        'target_word' => 'are being formulated (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'ethical guidelines', 'id' => 'pedoman etika'],
                            ['en' => 'artificial intelligence', 'id' => 'kecerdasan buatan'],
                            ['en' => 'inter-agency governmental committee', 'id' => 'komite antar-lembaga pemerintah']
                        ],
                        'options' => [
                            'Artificial intelligence ethical guidelines are being formulated by an inter-agency governmental committee.',
                            'Artificial intelligence ethical guidelines is being formulated by an inter-agency governmental committee.',
                            'Artificial intelligence ethical guidelines are formulating by an inter-agency governmental committee.',
                            'Artificial intelligence ethical guidelines being formulated by an inter-agency governmental committee.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "guidelines" berwujud jamak (plural), sehingga kata kerja pasif continuous yang tepat adalah "are being formulated".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.4
            [
                'id' => 'temporary-vs-permanent',
                'name' => '1.9.4 Temporary Situations vs Permanent Realities (Continuous vs Simple Present)',
                'code' => '1.9.4',
                'concept_title' => 'Temporary Situations vs Permanent Realities (Continuous vs Simple Present)',
                'concept_description' => 'Membedakan fakta umum, kebiasaan rutin, dan hukum alam (Simple Present) dengan kondisi transisional atau tindakan sementara (Present Continuous) yang sedang berlaku dalam durasi terbatas.',
                'description' => 'Membedakan fakta umum, kebiasaan rutin, dan hukum alam (Simple Present) dengan kondisi transisional atau tindakan sementara (Present Continuous) yang sedang berlaku dalam durasi terbatas.',
                'formula' => 'Permanent Reality: S + V1/V-s | Temporary Condition: S + is/are + V-ing',
                'rules' => [
                    'Gunakan Simple Present untuk kebenaran umum, lokasi markas utama, atau operasi rutin (normally operates, generally supplies).',
                    'Gunakan Present Continuous untuk aktivitas khusus sementara (currently hosting, this year is leading, is temporarily reducing).',
                    'Penanda waktu transisional meliputi: currently, presently, for the time being, this semester/week.'
                ], 
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Organisasi nirlaba tersebut biasanya beroperasi di London, tetapi saat ini sedang menyelenggarakan konferensi di Jenewa.',
                        'target_word' => 'normally operates ... is currently hosting (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'non-profit organization', 'id' => 'organisasi nirlaba'],
                            ['en' => 'normally operates', 'id' => 'biasanya beroperasi'],
                            ['en' => 'hosting a conference', 'id' => 'menyelenggarakan konferensi']
                        ],
                        'options' => [
                            'The non-profit organization normally operates in London, but it is currently hosting a conference in Geneva.',
                            'The non-profit organization is normally operating in London, but it currently hosts a conference in Geneva.',
                            'The non-profit organization normally operate in London, but it is currently hosting a conference in Geneva.',
                            'The non-profit organization normally operates in London, but it currently hosting a conference in Geneva.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Karakteristik permanen/rutin menggunakan Simple Present ("normally operates"), sedangkan kegiatan sementara saat ini menggunakan Present Continuous ("is currently hosting").'
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Profesor riset tersebut mengajar dua mata kuliah tetap setiap semester, tetapi tahun ini ia sedang memimpin proyek lapangan.',
                        'target_word' => 'teaches ... is leading (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'research professor', 'id' => 'profesor riset'],
                            ['en' => 'regular courses', 'id' => 'mata kuliah tetap'],
                            ['en' => 'field project', 'id' => 'proyek lapangan']
                        ],
                        'options' => [
                            'The research professor teaches two regular courses each semester, but this year she is leading a field project.',
                            'The research professor is teaching two regular courses each semester, but this year she leads a field project.',
                            'The research professor teach two regular courses each semester, but this year she is leading a field project.',
                            'The research professor teaches two regular courses each semester, but this year she leading a field project.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan rutin tiap semester ("each semester") memakai Simple Present "teaches", sementara komitmen khusus sementara ("this year") memakai Present Continuous "is leading".'
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Sungai tersebut umumnya mengalir dengan tenang, namun airnya sedang meluap akibat curah hujan monsun yang tidak normal.',
                        'target_word' => 'flows ... is overflowing (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'flows calmly', 'id' => 'mengalir dengan tenang'],
                            ['en' => 'overflowing', 'id' => 'meluap'],
                            ['en' => 'abnormal monsoon rainfall', 'id' => 'curah hujan monsun tidak normal']
                        ],
                        'options' => [
                            'The river generally flows calmly, but the water is overflowing due to abnormal monsoon rainfall.',
                            'The river is generally flowing calmly, but the water overflows due to abnormal monsoon rainfall.',
                            'The river generally flow calmly, but the water is overflowing due to abnormal monsoon rainfall.',
                            'The river generally flows calmly, but the water overflowing due to abnormal monsoon rainfall.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Karakter alami permanen dinyatakan dengan "generally flows", sedangkan fenomena sesaat akibat cuaca dinyatakan dengan "is overflowing".'
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Pabrik kimia ini menghasilkan 50 ton pupuk per hari, namun saat ini sedang mengurangi output demi perbaikan pipa.',
                        'target_word' => 'produces ... is currently reducing (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'chemical plant', 'id' => 'pabrik kimia'],
                            ['en' => 'fertilizer', 'id' => 'pupuk'],
                            ['en' => 'pipeline maintenance', 'id' => 'perbaikan pipa']
                        ],
                        'options' => [
                            'This chemical plant produces 50 tons of fertilizer daily, but it is currently reducing output for pipeline maintenance.',
                            'This chemical plant is producing 50 tons of fertilizer daily, but it currently reduces output for pipeline maintenance.',
                            'This chemical plant produce 50 tons of fertilizer daily, but it is currently reducing output for pipeline maintenance.',
                            'This chemical plant produces 50 tons of fertilizer daily, but it currently reducing output for pipeline maintenance.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kapasitas standar harian ("daily") menggunakan Simple Present "produces", sedangkan penyesuaian sementara ("currently") menggunakan "is currently reducing".'
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Laboratorium utama buka setiap hari kerja, namun tim teknis sedang merelokasi peralatan ke gedung baru minggu ini.',
                        'target_word' => 'opens ... is relocating (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'main laboratory', 'id' => 'laboratorium utama'],
                            ['en' => 'weekday', 'id' => 'hari kerja'],
                            ['en' => 'relocating equipment', 'id' => 'merelokasi peralatan']
                        ],
                        'options' => [
                            'The main laboratory opens every weekday, but the technical team is relocating equipment to the new building this week.',
                            'The main laboratory is opening every weekday, but the technical team relocates equipment to the new building this week.',
                            'The main laboratory open every weekday, but the technical team is relocating equipment to the new building this week.',
                            'The main laboratory opens every weekday, but the technical team relocating equipment to the new building this week.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Jadwal rutin ("every weekday") memakai "opens", sedangkan proyek sementara minggu ini ("this week") memakai "is relocating".'
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Kebanyakan akademisi mempublikasikan artikel di jurnal terindeks, namun mereka saat ini sedang menjajaki repositori akses terbuka.',
                        'target_word' => 'publish ... are currently exploring (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'academics', 'id' => 'akademisi'],
                            ['en' => 'indexed journals', 'id' => 'jurnal terindeks'],
                            ['en' => 'open-access repositories', 'id' => 'repositori akses terbuka']
                        ],
                        'options' => [
                            'Most academics publish articles in indexed journals, but they are currently exploring open-access repositories.',
                            'Most academics are publishing articles in indexed journals, but they currently explore open-access repositories.',
                            'Most academics publishes articles in indexed journals, but they are currently exploring open-access repositories.',
                            'Most academics publish articles in indexed journals, but they currently exploring open-access repositories.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola umum publikasi menggunakan Simple Present "publish", sedangkan inisiatif eksplorasi saat ini memakai Present Continuous "are currently exploring".'
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Sistem pendingin reaktor biasanya bekerja secara otomatis, tetapi staf ahli sedang mengendalikannya secara manual selama uji stres.',
                        'target_word' => 'normally works ... are operating (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'cooling system', 'id' => 'sistem pendingin'],
                            ['en' => 'normally works', 'id' => 'biasanya bekerja'],
                            ['en' => 'stress test', 'id' => 'uji stres']
                        ],
                        'options' => [
                            'The reactor cooling system normally works automatically, but specialists are operating it manually during the stress test.',
                            'The reactor cooling system is normally working automatically, but specialists operate it manually during the stress test.',
                            'The reactor cooling system normally work automatically, but specialists are operating it manually during the stress test.',
                            'The reactor cooling system normally works automatically, but specialists operating it manually during the stress test.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Normally works" menunjukkan mekanisme default, sedangkan "are operating" mendeskripsikan tindakan manual temporer selama pengujian.'
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Spesies burung migran tersebut bersarang di tundra arktik setiap musim semi, namun mereka sedang singgah di cagar alam ini bulan ini.',
                        'target_word' => 'nests ... are staying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'migratory bird species', 'id' => 'spesies burung migran'],
                            ['en' => 'arctic tundra', 'id' => 'tundra arktik'],
                            ['en' => 'nature reserve', 'id' => 'cagar alam']
                        ],
                        'options' => [
                            'The migratory bird species nests in the arctic tundra every spring, but they are staying at this nature reserve this month.',
                            'The migratory bird species is nesting in the arctic tundra every spring, but they stay at this nature reserve this month.',
                            'The migratory bird species nest in the arctic tundra every spring, but they are staying at this nature reserve this month.',
                            'The migratory bird species nests in the arctic tundra every spring, but they staying at this nature reserve this month.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Siklus biologis berulang ("every spring") menggunakan "nests", sedangkan persinggahan sementara ("this month") menggunakan "are staying".'
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Perusahaan farmasi itu umumnya memasok pasar domestik, tetapi saat ini sedang mengekspor pasokan antibiotik darurat ke negara tetangga.',
                        'target_word' => 'generally supplies ... is currently exporting (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'pharmaceutical company', 'id' => 'perusahaan farmasi'],
                            ['en' => 'domestic market', 'id' => 'pasar domestik'],
                            ['en' => 'emergency antibiotic supplies', 'id' => 'pasokan antibiotik darurat']
                        ],
                        'options' => [
                            'The pharmaceutical company generally supplies the domestic market, but it is currently exporting emergency antibiotic supplies to neighboring countries.',
                            'The pharmaceutical company is generally supplying the domestic market, but it currently exports emergency antibiotic supplies to neighboring countries.',
                            'The pharmaceutical company generally supply the domestic market, but it is currently exporting emergency antibiotic supplies to neighboring countries.',
                            'The pharmaceutical company generally supplies the domestic market, but it currently exporting emergency antibiotic supplies to neighboring countries.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Generally supplies" (operasi umum) dikontraskan secara presisi dengan "is currently exporting" (situasi darurat sementara).'
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Standar akreditasi berlaku selama lima tahun, namun dewan penilai sedang memperbarui instrumen evaluasi untuk siklus berikutnya.',
                        'target_word' => 'remain ... is updating (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'accreditation standards', 'id' => 'standar akreditasi'],
                            ['en' => 'valid', 'id' => 'berlaku'],
                            ['en' => 'evaluation instruments', 'id' => 'instrumen evaluasi']
                        ],
                        'options' => [
                            'Accreditation standards remain valid for five years, but the evaluation board is updating the evaluation instruments for the next cycle.',
                            'Accreditation standards are remaining valid for five years, but the evaluation board updates the evaluation instruments for the next cycle.',
                            'Accreditation standards remains valid for five years, but the evaluation board is updating the evaluation instruments for the next cycle.',
                            'Accreditation standards remain valid for five years, but the evaluation board updating the evaluation instruments for the next cycle.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Ketentuan legal jangka panjang memakai Simple Present "remain valid", sementara proses revisi saat ini memakai "is updating".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.5
            [
                'id' => 'stative-verbs-exception',
                'name' => '1.9.5 Stative Verbs in Academic Contexts (Perception, Cognition, Possession vs Dynamic)',
                'code' => '1.9.5',
                'concept_title' => 'Stative Verbs in Academic Contexts (Perception, Cognition, Possession vs Dynamic)',
                'concept_description' => 'Stative verbs adalah kata kerja yang menyatakan status mental, kognisi, kepemilikan, atau persepsi. Verba ini TIDAK BOLEH digunakan dalam bentuk continuous meskipun dalam konteks sekarang, karena tidak menggambarkan tindakan fisik yang memiliki durasi berproses.',
                'description' => 'Stative verbs adalah kata kerja yang menyatakan status mental, kognisi, kepemilikan, atau persepsi. Verba ini TIDAK BOLEH digunakan dalam bentuk continuous meskipun dalam konteks sekarang, karena tidak menggambarkan tindakan fisik yang memiliki durasi berproses.',
                'formula' => 'Subject + Stative Verb (Simple Present Form) + Object / Complement',
                'rules' => [
                    'Verba kognisi/pendirian: understand, believe, know, doubt (Dilarang: *is understanding, *are believing).',
                    'Verba kepemilikan/kondisi: possess, contain, consist of, lack, belong (Dilarang: *is containing, *is lacking).',
                    'Verba dinamis ganda: kata seperti \\"consider\\" atau \\"think about\\" bisa berbentuk continuous jika bermakna menimbang/memikirkan aktif.'
                ], 
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Teori fisika baru tersebut memerlukan verifikasi eksperimental yang independen sebelum diterima luas.',
                        'target_word' => 'requires (Stative Verb: Requirement)',
                        'vocab' => [
                            ['en' => 'physics theory', 'id' => 'teori fisika'],
                            ['en' => 'independent verification', 'id' => 'verifikasi independen'],
                            ['en' => 'widely accepted', 'id' => 'diterima luas']
                        ],
                        'options' => [
                            'The new physics theory requires independent experimental verification before being widely accepted.',
                            'The new physics theory is requiring independent experimental verification before being widely accepted.',
                            'The new physics theory require independent experimental verification before being widely accepted.',
                            'The new physics theory is being required independent experimental verification before being widely accepted.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "require" adalah stative verb yang menyatakan kebutuhan esensial dan tidak digunakan dalam bentuk continuous (*is requiring).'
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Para peneliti memahami kompleksitas struktural dari protein virus tersebut.',
                        'target_word' => 'understand (Stative Verb: Cognition)',
                        'vocab' => [
                            ['en' => 'researchers', 'id' => 'para peneliti'],
                            ['en' => 'structural complexity', 'id' => 'kompleksitas struktural'],
                            ['en' => 'viral protein', 'id' => 'protein virus']
                        ],
                        'options' => [
                            'The researchers understand the structural complexity of the viral protein.',
                            'The researchers are understanding the structural complexity of the viral protein.',
                            'The researchers understands the structural complexity of the viral protein.',
                            'The researchers are understand the structural complexity of the viral protein.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Understand" adalah kata kerja kognisi (keadaan pikiran) dan tidak lazim berakhiran -ing dalam konteks akademis.'
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Laporan komprehensif tersebut berisi bukti dokumenter yang membantah klaim sebelumnya.',
                        'target_word' => 'contains (Stative Verb: Composition)',
                        'vocab' => [
                            ['en' => 'comprehensive report', 'id' => 'laporan komprehensif'],
                            ['en' => 'documentary evidence', 'id' => 'bukti dokumenter'],
                            ['en' => 'refutes earlier claims', 'id' => 'membantah klaim sebelumnya']
                        ],
                        'options' => [
                            'The comprehensive report contains documentary evidence that refutes earlier claims.',
                            'The comprehensive report is containing documentary evidence that refutes earlier claims.',
                            'The comprehensive report contain documentary evidence that refutes earlier claims.',
                            'The comprehensive report is contained documentary evidence that refutes earlier claims.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Contain" adalah verba relasional/stative yang menyatakan isi; bentuk "is containing" salah secara tata bahasa.'
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Usulan kebijakan tersebut tampaknya layak, namun panitia sedang mempertimbangkan implikasi keuangannya secara mendalam.',
                        'target_word' => 'seems ... is considering (Stative vs Dynamic Meaning)',
                        'vocab' => [
                            ['en' => 'policy proposal', 'id' => 'usulan kebijakan'],
                            ['en' => 'feasible', 'id' => 'layak'],
                            ['en' => 'financial implications', 'id' => 'implikasi keuangan']
                        ],
                        'options' => [
                            'The policy proposal seems feasible, but the committee is currently considering its financial implications deeply.',
                            'The policy proposal is seeming feasible, but the committee currently considers its financial implications deeply.',
                            'The policy proposal seems feasible, but the committee considers currently its financial implications deeply.',
                            'The policy proposal is seeming feasible, but the committee is currently considering its financial implications deeply.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Seem" adalah stative verb murni (tidak boleh *is seeming), sedangkan "consider" dalam arti menimbang/memikirkan aktif dapat berbentuk continuous ("is currently considering").'
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Banyak negara berkembang kekurangan infrastruktur medis yang memadai untuk menangani wabah.',
                        'target_word' => 'lack (Stative Verb: Possession/Condition)',
                        'vocab' => [
                            ['en' => 'developing countries', 'id' => 'negara berkembang'],
                            ['en' => 'lack', 'id' => 'kekurangan'],
                            ['en' => 'adequate medical infrastructure', 'id' => 'infrastruktur medis memadai']
                        ],
                        'options' => [
                            'Many developing countries lack adequate medical infrastructure to handle outbreaks.',
                            'Many developing countries are lacking adequate medical infrastructure to handle outbreaks.',
                            'Many developing countries lacks adequate medical infrastructure to handle outbreaks.',
                            'Many developing countries are lack adequate medical infrastructure to handle outbreaks.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Verba "lack" sebagai predikat transitif formal adalah stative verb yang menyatakan kondisi ketiadaan (*are lacking salah dalam register akademis baku).'
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Konsorsium penelitian tersebut memiliki paten eksklusif atas sintesis senyawa polimer biodegradable.',
                        'target_word' => 'possesses (Stative Verb: Ownership)',
                        'vocab' => [
                            ['en' => 'research consortium', 'id' => 'konsorsium penelitian'],
                            ['en' => 'exclusive patents', 'id' => 'paten eksklusif'],
                            ['en' => 'biodegradable polymer compound', 'id' => 'senyawa polimer biodegradable']
                        ],
                        'options' => [
                            'The research consortium possesses exclusive patents on the synthesis of the biodegradable polymer compound.',
                            'The research consortium is possessing exclusive patents on the synthesis of the biodegradable polymer compound.',
                            'The research consortium possess exclusive patents on the synthesis of the biodegradable polymer compound.',
                            'The research consortium is possessed exclusive patents on the synthesis of the biodegradable polymer compound.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Possess" (memiliki/menguasai hak) adalah stative verb kepemilikan sehingga tidak dapat digunakan dalam bentuk continuous (*is possessing).'
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Model ekonometrik ini terdiri dari lima variabel makroekonomi yang saling berhubungan.',
                        'target_word' => 'consists of (Stative Verb: Composition)',
                        'vocab' => [
                            ['en' => 'econometric model', 'id' => 'model ekonometrik'],
                            ['en' => 'consists of', 'id' => 'terdiri dari'],
                            ['en' => 'interrelated macroeconomic variables', 'id' => 'variabel makroekonomi yang saling berhubungan']
                        ],
                        'options' => [
                            'This econometric model consists of five interrelated macroeconomic variables.',
                            'This econometric model is consisting of five interrelated macroeconomic variables.',
                            'This econometric model consist of five interrelated macroeconomic variables.',
                            'This econometric model is consisted of five interrelated macroeconomic variables.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa verba "consist of" selalu stative aktif (*is consisting of dan *is consisted of adalah kekeliruan fatal dalam penulisan ilmiah).'
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Dewan juri percaya bahwa argumen peserta sangat meyakinkan dalam sesi debat akademik.',
                        'target_word' => 'believes (Stative Verb: Opinion/Belief)',
                        'vocab' => [
                            ['en' => 'judging panel', 'id' => 'dewan juri'],
                            ['en' => 'believes', 'id' => 'percaya/berpendapat'],
                            ['en' => 'convincing', 'id' => 'meyakinkan']
                        ],
                        'options' => [
                            'The judging panel believes the participant\'s argument is very convincing in the academic debate session.',
                            'The judging panel is believing the participant\'s argument is very convincing in the academic debate session.',
                            'The judging panel believe the participant\'s argument is very convincing in the academic debate session.',
                            'The judging panel are believing the participant\'s argument is very convincing in the academic debate session.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Believe" adalah stative verb pendirian/opini yang tidak berbentuk continuous (*is believing).'
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Sampel batuan purba tersebut memiliki komposisi isotop yang identik dengan meteorit langka.',
                        'target_word' => 'has (Stative Verb: Possession/Attribute)',
                        'vocab' => [
                            ['en' => 'ancient rock sample', 'id' => 'sampel batuan purba'],
                            ['en' => 'isotopic composition', 'id' => 'komposisi isotop'],
                            ['en' => 'rare meteorites', 'id' => 'meteorit langka']
                        ],
                        'options' => [
                            'The ancient rock sample has an isotopic composition identical to rare meteorites.',
                            'The ancient rock sample is having an isotopic composition identical to rare meteorites.',
                            'The ancient rock sample have an isotopic composition identical to rare meteorites.',
                            'The ancient rock sample has having an isotopic composition identical to rare meteorites.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "have" yang bermakna kepemilikan atribut fisik adalah stative verb ("has", bukan *is having).'
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Para ilmuwan ragu terhadap keakuratan sensor satelit generasi pertama.',
                        'target_word' => 'doubt (Stative Verb: Mental State)',
                        'vocab' => [
                            ['en' => 'scientists', 'id' => 'para ilmuwan'],
                            ['en' => 'doubt', 'id' => 'ragu terhadap'],
                            ['en' => 'accuracy', 'id' => 'keakuratan'],
                            ['en' => 'first-generation satellite sensors', 'id' => 'sensor satelit generasi pertama']
                        ],
                        'options' => [
                            'Scientists doubt the accuracy of first-generation satellite sensors.',
                            'Scientists are doubting the accuracy of first-generation satellite sensors.',
                            'Scientists doubts the accuracy of first-generation satellite sensors.',
                            'Scientists are doubt the accuracy of first-generation satellite sensors.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Doubt" adalah stative verb yang mendeskripsikan keraguan mental, sehingga berbentuk Simple Present "doubt", bukan *are doubting.'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.6
            [
                'id' => 'continuous-negative-interrogative',
                'name' => '1.9.6 Present Continuous Negative & Interrogative Forms',
                'code' => '1.9.6',
                'concept_title' => 'Present Continuous Negative & Interrogative Forms',
                'concept_description' => 'Digunakan untuk menyangkal asumsi sementara, menyatakan fenomena yang tidak sedang berkembang, serta mengajukan pertanyaan riset eksploratif mengenai perkembangan mutakhir.',
                'description' => 'Digunakan untuk menyangkal asumsi sementara, menyatakan fenomena yang tidak sedang berkembang, serta mengajukan pertanyaan riset eksploratif mengenai perkembangan mutakhir.',
                'formula' => 'Negative: S + is/are + NOT + V-ing / being V3 | Interrogative: Is/Are + S + V-ing?',
                'rules' => [
                    'Pada kalimat verbal negatif, sisipkan \\"not\\" tepat setelah to be (is not allocating, are not receiving).',
                    'Pada kalimat pasif negatif, letakkan \\"not\\" sebelum being (is not being stored).',
                    'Pada kalimat tanya (interrogative), pindahkan auxiliary to be ke posisi paling depan sebelum subjek (Is the system transmitting...?).'
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Pemerintah tidak sedang mengalokasikan anggaran darurat untuk sektor pariwisata pada triwulan ini.',
                        'target_word' => 'is not allocating (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'emergency budget funds', 'id' => 'anggaran darurat'],
                            ['new' => 'tourism sector', 'id' => 'sektor pariwisata'],
                            ['en' => 'this quarter', 'id' => 'triwulan ini']
                        ],
                        'options' => [
                            'The government is not allocating emergency budget funds to the tourism sector this quarter.',
                            'The government does not allocating emergency budget funds to the tourism sector this quarter.',
                            'The government are not allocating emergency budget funds to the tourism sector this quarter.',
                            'The government not allocating emergency budget funds to the tourism sector this quarter.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk negatif Present Continuous Verbal dibentuk dengan meletakkan "not" setelah auxiliary: "is not allocating".'
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Data klinis tidak sedang disimpan di server publik yang tidak terenkripsi.',
                        'target_word' => 'is not being stored (Negative Passive)',
                        'vocab' => [
                            ['en' => 'clinical data', 'id' => 'data klinis'],
                            ['en' => 'stored', 'id' => 'disimpan'],
                            ['en' => 'unencrypted public servers', 'id' => 'server publik yang tidak terenkripsi']
                        ],
                        'options' => [
                            'Clinical data is not being stored on unencrypted public servers.',
                            'Clinical data is not storing on unencrypted public servers.',
                            'Clinical data does not being stored on unencrypted public servers.',
                            'Clinical data is not been stored on unencrypted public servers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola negatif pasif continuous adalah "is not being" + V3 "stored". Opsi B aktif, opsi C menggunakan auxiliary "does" yang salah, dan opsi D menggunakan "been".'
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Para peserta survei tidak sedang menerima intervensi psikologis selama fase observasi pasif.',
                        'target_word' => 'are not receiving (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'survey participants', 'id' => 'peserta survei'],
                            ['en' => 'psychological interventions', 'id' => 'intervensi psikologis'],
                            ['en' => 'passive observation phase', 'id' => 'fase observasi pasif']
                        ],
                        'options' => [
                            'Survey participants are not receiving psychological interventions during the passive observation phase.',
                            'Survey participants is not receiving psychological interventions during the passive observation phase.',
                            'Survey participants do not receiving psychological interventions during the passive observation phase.',
                            'Survey participants are not receive psychological interventions during the passive observation phase.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "Survey participants" mengambil "are not receiving".'
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Apakah sistem peringatan dini sedang mengirimkan peringatan banjir secara tepat waktu ke pusat komando?',
                        'target_word' => 'Is ... transmitting (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'early warning system', 'id' => 'sistem peringatan dini'],
                            ['en' => 'transmitting', 'id' => 'mengirimkan'],
                            ['en' => 'flood alerts', 'id' => 'peringatan banjir'],
                            ['en' => 'command center', 'id' => 'pusat komando']
                        ],
                        'options' => [
                            'Is the early warning system transmitting timely flood alerts to the command center?',
                            'Does the early warning system transmitting timely flood alerts to the command center?',
                            'Are the early warning system transmitting timely flood alerts to the command center?',
                            'Is the early warning system transmit timely flood alerts to the command center?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "the early warning system" adalah tunggal, sehingga kalimat tanya diawali auxiliary "Is" + Subjek + V-ing "transmitting".'
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Kebijakan fiskal yang restriktif tidak sedang mendukung pertumbuhan usaha kecil dan menengah.',
                        'target_word' => 'is not supporting (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'restrictive fiscal policy', 'id' => 'kebijakan fiskal yang restriktif'],
                            ['en' => 'supporting', 'id' => 'mendukung'],
                            ['en' => 'small and medium enterprises', 'id' => 'usaha kecil dan menengah']
                        ],
                        'options' => [
                            'The restrictive fiscal policy is not supporting the growth of small and medium enterprises.',
                            'The restrictive fiscal policy are not supporting the growth of small and medium enterprises.',
                            'The restrictive fiscal policy does not supporting the growth of small and medium enterprises.',
                            'The restrictive fiscal policy not is supporting the growth of small and medium enterprises.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The restrictive fiscal policy" membutuhkan "is not supporting".'
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Spesimen langka tersebut tidak sedang dipamerkan di museum karena sedang menjalani restorasi kimia.',
                        'target_word' => 'are not being displayed (Negative Passive)',
                        'vocab' => [
                            ['en' => 'rare specimens', 'id' => 'spesimen langka'],
                            ['en' => 'displayed', 'id' => 'dipamerkan'],
                            ['en' => 'chemical restoration', 'id' => 'restorasi kimia']
                        ],
                        'options' => [
                            'The rare specimens are not being displayed in the museum because they are undergoing chemical restoration.',
                            'The rare specimens is not being displayed in the museum because they are undergoing chemical restoration.',
                            'The rare specimens are not displaying in the museum because they are undergoing chemical restoration.',
                            'The rare specimens do not being displayed in the museum because they are undergoing chemical restoration.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The rare specimens" memerlukan bentuk pasif negatif: "are not being displayed".'
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah para insinyur biomedis sedang memodifikasi desain implan untuk meminimalkan penolakan jaringan?',
                        'target_word' => 'Are ... modifying (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'biomedical engineers', 'id' => 'insinyur biomedis'],
                            ['en' => 'modifying', 'id' => 'memodifikasi'],
                            ['en' => 'tissue rejection', 'id' => 'penolakan jaringan']
                        ],
                        'options' => [
                            'Are biomedical engineers modifying the implant design to minimize tissue rejection?',
                            'Is biomedical engineers modifying the implant design to minimize tissue rejection?',
                            'Do biomedical engineers modifying the implant design to minimize tissue rejection?',
                            'Are biomedical engineers modify the implant design to minimize tissue rejection?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "biomedical engineers" diawali oleh auxiliary "Are" + V-ing "modifying".'
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Tingkat polusi udara di ibu kota tidak sedang berkurang meskipun terdapat pembatasan lalu lintas kendaraan.',
                        'target_word' => 'is not decreasing (Negative Trend)',
                        'vocab' => [
                            ['en' => 'air pollution levels', 'id' => 'tingkat polusi udara'],
                            ['en' => 'decreasing', 'id' => 'berkurang'],
                            ['en' => 'vehicle traffic restrictions', 'id' => 'pembatasan lalu lintas kendaraan']
                        ],
                        'options' => [
                            'Air pollution levels in the capital city are not decreasing despite vehicle traffic restrictions.',
                            'Air pollution levels in the capital city is not decreasing despite vehicle traffic restrictions.',
                            'Air pollution levels in the capital city does not decreasing despite vehicle traffic restrictions.',
                            'Air pollution levels in the capital city are not decrease despite vehicle traffic restrictions.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "Air pollution levels" adalah jamak (levels), sehingga bentuk negatif continuous yang tepat adalah "are not decreasing".'
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Strategi manajemen risiko yang usang tidak sedang diterapkan dalam operasional perbankan modern.',
                        'target_word' => 'is not being applied (Negative Passive)',
                        'vocab' => [
                            ['en' => 'outdated risk management strategy', 'id' => 'strategi manajemen risiko usang'],
                            ['en' => 'applied', 'id' => 'diterapkan'],
                            ['en' => 'modern banking operations', 'id' => 'operasional perbankan modern']
                        ],
                        'options' => [
                            'An outdated risk management strategy is not being applied in modern banking operations.',
                            'An outdated risk management strategy are not being applied in modern banking operations.',
                            'An outdated risk management strategy is not applying in modern banking operations.',
                            'An outdated risk management strategy does not being applied in modern banking operations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "strategy" dalam bentuk pasif negatif continuous membutuhkan "is not being applied".'
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah metodologi pembelajaran terbalik sedang menunjukkan dampak positif yang terukur pada keterlibatan mahasiswa?',
                        'target_word' => 'Is ... showing (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'flipped classroom methodology', 'id' => 'metodologi pembelajaran terbalik'],
                            ['en' => 'measurable positive impacts', 'id' => 'dampak positif terukur'],
                            ['en' => 'student engagement', 'id' => 'keterlibatan mahasiswa']
                        ],
                        'options' => [
                            'Is the flipped classroom methodology showing measurable positive impacts on student engagement?',
                            'Does the flipped classroom methodology showing measurable positive impacts on student engagement?',
                            'Are the flipped classroom methodology showing measurable positive impacts on student engagement?',
                            'Is the flipped classroom methodology show measurable positive impacts on student engagement?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "the flipped classroom methodology" diawali to be "Is" + V-ing "showing".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.7
            [
                'id' => 'time-adverbs-continuous',
                'name' => '1.9.7 Prepositional Phrases & Time Adverbs with Continuous Forms',
                'code' => '1.9.7',
                'concept_title' => 'Prepositional Phrases & Time Adverbs with Continuous Forms',
                'concept_description' => 'Memperkaya kalimat continuous dengan adverbia waktu formal (currently, presently, steadily) dan frasa preposisional latar belakang (at this juncture, under the new framework) untuk menciptakan kohesi wacana ilmiah yang matang.',
                'description' => 'Memperkaya kalimat continuous dengan adverbia waktu formal (currently, presently, steadily) dan frasa preposisional latar belakang (at this juncture, under the new framework) untuk menciptakan kohesi wacana ilmiah yang matang.',
                'formula' => 'Adverbial / Prepositional Phrase + Comma + Subject + is/are + V-ing',
                'rules' => [
                    'Adverbia cara/derajat tren sering disisipkan di antara to be dan main verb (are steadily depleting).',
                    'Frasa preposisional latar belakang dapat diletakkan di depan kalimat diikuti tanda koma untuk efek variasi sintaksis (fronting).',
                    'Pastikan penanda waktu selaras dengan aspek continuous sekarang (at this transitional stage, at this very moment).'
                ], 
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Saat ini, para peneliti sedang menyusun naskah monograf tentang arkeologi maritim di Asia Timur.',
                        'target_word' => 'Currently, ... are drafting (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'currently', 'id' => 'saat ini'],
                            ['en' => 'drafting', 'id' => 'menyusun'],
                            ['en' => 'monograph manuscript', 'id' => 'naskah monograf'],
                            ['en' => 'maritime archaeology', 'id' => 'arkeologi maritim']
                        ],
                        'options' => [
                            'Currently, researchers are drafting a monograph manuscript on maritime archaeology in East Asia.',
                            'Currently, researchers is drafting a monograph manuscript on maritime archaeology in East Asia.',
                            'Currently, researchers are draft a monograph manuscript on maritime archaeology in East Asia.',
                            'Currently, researchers drafting a monograph manuscript on maritime archaeology in East Asia.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Currently" di awal kalimat dipadukan dengan klausa Present Continuous jamak "researchers are drafting".'
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Pada tahap transisi ini, universitas sedang mentransformasikan sistem manajemen pembelajarannya ke platform berbasis komputasi awan.',
                        'target_word' => 'At this transitional stage, ... is transforming (Adverbial Phrase)',
                        'vocab' => [
                            ['en' => 'transitional stage', 'id' => 'tahap transisi'],
                            ['en' => 'learning management system', 'id' => 'sistem manajemen pembelajaran'],
                            ['en' => 'cloud-based platform', 'id' => 'platform berbasis komputasi awan']
                        ],
                        'options' => [
                            'At this transitional stage, the university is transforming its learning management system to a cloud-based platform.',
                            'At this transitional stage, the university are transforming its learning management system to a cloud-based platform.',
                            'At this transitional stage, the university is transform its learning management system to a cloud-based platform.',
                            'At this transitional stage, the university transforming its learning management system to a cloud-based platform.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa preposisi "At this transitional stage" mengawali kalimat, diikuti subjek tunggal "the university is transforming".'
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Secara bertahap, cadangan air tanah di wilayah semi-kering tersebut sedang menurun drastis.',
                        'target_word' => 'are steadily depleting (Adverb of Manner/Trend)',
                        'vocab' => [
                            ['en' => 'groundwater reserves', 'id' => 'cadangan air tanah'],
                            ['en' => 'semi-arid region', 'id' => 'wilayah semi-kering'],
                            ['en' => 'depleting dramatically', 'id' => 'menurun drastis']
                        ],
                        'options' => [
                            'Groundwater reserves in the semi-arid region are steadily depleting at an alarming speed.',
                            'Groundwater reserves in the semi-arid region is steadily depleting at an alarming speed.',
                            'Groundwater reserves in the semi-arid region are steadily deplete at an alarming speed.',
                            'Groundwater reserves in the semi-arid region steadily depleting at an alarming speed.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "reserves" jamak berpasangan dengan "are steadily depleting". Adverbia "steadily" disisipkan di antara auxiliary "are" dan verb "depleting".'
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Di bawah kerangka kerja baru, para ilmuwan sedang menganalisis sampel DNA purba dari gua-gua prasejarah.',
                        'target_word' => 'Under the new framework, ... are analyzing (Prepositional Fronting)',
                        'vocab' => [
                            ['en' => 'framework', 'id' => 'kerangka kerja'],
                            ['en' => 'ancient DNA samples', 'id' => 'sampel DNA purba'],
                            ['en' => 'prehistoric caves', 'id' => 'gua-gua prasejarah']
                        ],
                        'options' => [
                            'Under the new framework, scientists are analyzing ancient DNA samples from prehistoric caves.',
                            'Under the new framework, scientists is analyzing ancient DNA samples from prehistoric caves.',
                            'Under the new framework, scientists are analyze ancient DNA samples from prehistoric caves.',
                            'Under the new framework, scientists analyzing ancient DNA samples from prehistoric caves.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa preposisi depan "Under the new framework" diikuti klausul aktif "scientists are analyzing".'
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Pada saat krisis energi ini, industri berat sedang mencari sumber bahan bakar alternatif yang lebih bersih.',
                        'target_word' => 'are seeking (Adverbial Context)',
                        'vocab' => [
                            ['en' => 'energy crisis', 'id' => 'krisis energi'],
                            ['en' => 'heavy industries', 'id' => 'industri berat'],
                            ['en' => 'cleaner alternative fuel sources', 'id' => 'sumber bahan bakar alternatif lebih bersih']
                        ],
                        'options' => [
                            'At this time of energy crisis, heavy industries are seeking cleaner alternative fuel sources.',
                            'At this time of energy crisis, heavy industries is seeking cleaner alternative fuel sources.',
                            'At this time of energy crisis, heavy industries are seek cleaner alternative fuel sources.',
                            'At this time of energy crisis, heavy industries seeking cleaner alternative fuel sources.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "heavy industries" membutuhkan "are seeking".'
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Dengan kecepatan yang meningkat, teknologi komputasi kuantum sedang mendekati ambang supremasi praktis.',
                        'target_word' => 'is approaching (Trend Pace)',
                        'vocab' => [
                            ['en' => 'accelerating pace', 'id' => 'kecepatan yang meningkat'],
                            ['en' => 'quantum computing technology', 'id' => 'teknologi komputasi kuantum'],
                            ['en' => 'threshold of practical supremacy', 'id' => 'ambang supremasi praktis']
                        ],
                        'options' => [
                            'At an accelerating pace, quantum computing technology is approaching the threshold of practical supremacy.',
                            'At an accelerating pace, quantum computing technology are approaching the threshold of practical supremacy.',
                            'At an accelerating pace, quantum computing technology is approach the threshold of practical supremacy.',
                            'At an accelerating pace, quantum computing technology approaching the threshold of practical supremacy.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun "technology" berbentuk tunggal sehingga verb-nya adalah "is approaching".'
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Di seluruh zona metropolitan, otoritas tata kota sedang merancang koridor hijau untuk menekan efek pulau panas perkotaan.',
                        'target_word' => 'are designing (Locative Fronting)',
                        'vocab' => [
                            ['en' => 'metropolitan zone', 'id' => 'zona metropolitan'],
                            ['en' => 'urban planning authorities', 'id' => 'otoritas tata kota'],
                            ['en' => 'urban heat island effect', 'id' => 'efek pulau panas perkotaan']
                        ],
                        'options' => [
                            'Across the metropolitan zone, urban planning authorities are designing green corridors to mitigate the urban heat island effect.',
                            'Across the metropolitan zone, urban planning authorities is designing green corridors to mitigate the urban heat island effect.',
                            'Across the metropolitan zone, urban planning authorities are design green corridors to mitigate the urban heat island effect.',
                            'Across the metropolitan zone, urban planning authorities designing green corridors to mitigate the urban heat island effect.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "authorities" berpasangan dengan "are designing".'
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Saat ini juga, protokol komunikasi terenkripsi sedang diperbarui untuk mencegah peretasan tingkat tinggi.',
                        'target_word' => 'are being updated (Real-Time Passive)',
                        'vocab' => [
                            ['en' => 'at this very moment', 'id' => 'saat ini juga'],
                            ['en' => 'encrypted communication protocols', 'id' => 'protokol komunikasi terenkripsi'],
                            ['en' => 'high-level cyberattacks', 'id' => 'peretasan tingkat tinggi']
                        ],
                        'options' => [
                            'At this very moment, encrypted communication protocols are being updated to prevent high-level cyberattacks.',
                            'At this very moment, encrypted communication protocols is being updated to prevent high-level cyberattacks.',
                            'At this very moment, encrypted communication protocols are updating to prevent high-level cyberattacks.',
                            'At this very moment, encrypted communication protocols being updated to prevent high-level cyberattacks.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "protocols" dalam bentuk pasif continuous membutuhkan "are being updated".'
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Secara konsisten, permintaan internasional terhadap mineral tanah jarang sedang melonjak di pasar komoditas global.',
                        'target_word' => 'is surging (Trend Adverb)',
                        'vocab' => [
                            ['en' => 'consistently', 'id' => 'secara konsisten'],
                            ['en' => 'international demand', 'id' => 'permintaan internasional'],
                            ['en' => 'rare earth minerals', 'id' => 'mineral tanah jarang'],
                            ['en' => 'commodity markets', 'id' => 'pasar komoditas']
                        ],
                        'options' => [
                            'Consistently, international demand for rare earth minerals is surging in global commodity markets.',
                            'Consistently, international demand for rare earth minerals are surging in global commodity markets.',
                            'Consistently, international demand for rare earth minerals is surge in global commodity markets.',
                            'Consistently, international demand for rare earth minerals surging in global commodity markets.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun adalah "demand" (uncountable/singular), sehingga verb yang tepat adalah "is surging".'
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Dalam iklim ekonomi yang tidak menentu ini, para investor sedang mengalihkan modal ke aset safe-haven seperti emas.',
                        'target_word' => 'are reallocating (Contextual Modifier)',
                        'vocab' => [
                            ['en' => 'uncertain economic climate', 'id' => 'iklim ekonomi tidak menentu'],
                            ['en' => 'investors', 'id' => 'para investor'],
                            ['en' => 'safe-haven assets', 'id' => 'aset safe-haven']
                        ],
                        'options' => [
                            'In this uncertain economic climate, investors are reallocating capital to safe-haven assets such as gold.',
                            'In this uncertain economic climate, investors is reallocating capital to safe-haven assets such as gold.',
                            'In this uncertain economic climate, investors are reallocate capital to safe-haven assets such as gold.',
                            'In this uncertain economic climate, investors reallocating capital to safe-haven assets such as gold.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "investors" membutuhkan "are reallocating".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.8
            [
                'id' => 'continuous-academic-synthesis',
                'name' => '1.9.8 Comprehensive Synthesis: Contemporary Trend Reporting & Dynamic Process Analysis',
                'code' => '1.9.8',
                'concept_title' => 'Comprehensive Synthesis: Contemporary Trend Reporting & Dynamic Process Analysis',
                'concept_description' => 'Membangun sintesis kalimat majemuk bertingkat (complex sentences) yang memadukan klausa subordinat (while, as, because, although), pelaporan tren simultan, dan struktur pasif proses untuk mencapai skor tinggi dalam IELTS Academic Writing.',
                'description' => 'Membangun sintesis kalimat majemuk bertingkat (complex sentences) yang memadukan klausa subordinat (while, as, because, although), pelaporan tren simultan, dan struktur pasif proses untuk mencapai skor tinggi dalam IELTS Academic Writing.',
                'formula' => 'Conjunction (While/Because/As) + Clause 1 (Continuous) + Comma + Clause 2 (Continuous)',
                'rules' => [
                    'Gunakan \\"while\\" atau \\"although\\" untuk mengontraskan dua tren atau fenomena yang berlangsung bersamaan.',
                    'Gunakan \\"because\\" atau \\"as\\" untuk menghubungkan hubungan sebab-akibat yang sedang berkembang.',
                    'Jaga konsistensi Subject-Verb Agreement pada setiap klausa independen dan dependen.'
                ], 
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Meskipun ekonomi global sedang menghadapi tantangan inflasi, sektor energi terbarukan sedang menarik investasi swasta yang masif.',
                        'target_word' => 'is facing ... is attracting (Simultaneous Trends)',
                        'vocab' => [
                            ['en' => 'inflationary challenges', 'id' => 'tantangan inflasi'],
                            ['en' => 'renewable energy sector', 'id' => 'sektor energi terbarukan'],
                            ['en' => 'massive private investment', 'id' => 'investasi swasta masif']
                        ],
                        'options' => [
                            'While the global economy is facing inflationary challenges, the renewable energy sector is attracting massive private investment.',
                            'While the global economy faces inflationary challenges, the renewable energy sector attracts massive private investment.',
                            'While the global economy are facing inflationary challenges, the renewable energy sector are attracting massive private investment.',
                            'While the global economy is facing inflationary challenges, the renewable energy sector attracting massive private investment.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dua tren kontemporer yang saling berdampingan dan sedang aktif berlangsung dinyatakan dengan klausa kontras Present Continuous: "is facing" dan "is attracting".'
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Bahan bakar penerbangan berkelanjutan sedang diproduksi dalam skala komersial, sementara mesin jet generasi baru sedang diuji untuk efisiensi bahan bakar maksimal.',
                        'target_word' => 'are being produced ... are being tested (Dual Continuous Passive)',
                        'vocab' => [
                            ['en' => 'sustainable aviation fuels', 'id' => 'bahan bakar penerbangan berkelanjutan'],
                            ['en' => 'commercial scale', 'id' => 'skala komersial'],
                            ['en' => 'jet engines', 'id' => 'mesin jet']
                        ],
                        'options' => [
                            'Sustainable aviation fuels are being produced at commercial scale, while new-generation jet engines are being tested for maximum fuel efficiency.',
                            'Sustainable aviation fuels are producing at commercial scale, while new-generation jet engines are testing for maximum fuel efficiency.',
                            'Sustainable aviation fuels is being produced at commercial scale, while new-generation jet engines is being tested for maximum fuel efficiency.',
                            'Sustainable aviation fuels are been produced at commercial scale, while new-generation jet engines are been tested for maximum fuel efficiency.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa memerlukan pasif continuous jamak: "are being produced" dan "are being tested". Opsi B aktif, opsi C salah concord tunggal, dan opsi D memakai "been".'
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Karena populasi lanjut usia sedang bertambah pesat, kebutuhan akan perawat profesional sedang meningkat di banyak negara maju.',
                        'target_word' => 'is growing ... is increasing (Causal Continuous)',
                        'vocab' => [
                            ['en' => 'elderly population', 'id' => 'populasi lanjut usia'],
                            ['en' => 'professional caregivers', 'id' => 'perawat profesional'],
                            ['en' => 'developed nations', 'id' => 'negara maju']
                        ],
                        'options' => [
                            'Because the elderly population is growing rapidly, the need for professional caregivers is increasing in many developed nations.',
                            'Because the elderly population are growing rapidly, the need for professional caregivers are increasing in many developed nations.',
                            'Because the elderly population is grow rapidly, the need for professional caregivers is increase in many developed nations.',
                            'Because the elderly population growing rapidly, the need for professional caregivers increasing in many developed nations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "elderly population" dan "the need" keduanya tunggal, sehingga membentuk relasi sebab-akibat continuous yang tepat: "is growing ... is increasing".'
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Sementara peraturan privasi data baru sedang diratifikasi oleh parlemen, perusahaan teknologi sedang menyesuaikan infrastruktur penyimpanan informasi mereka.',
                        'target_word' => 'are being ratified ... are adjusting (Passive-Active Synthesis)',
                        'vocab' => [
                            ['en' => 'data privacy regulations', 'id' => 'peraturan privasi data'],
                            ['en' => 'ratified by parliament', 'id' => 'diratifikasi oleh parlemen'],
                            ['en' => 'information storage infrastructures', 'id' => 'infrastruktur penyimpanan informasi']
                        ],
                        'options' => [
                            'While new data privacy regulations are being ratified by parliament, tech corporations are adjusting their information storage infrastructures.',
                            'While new data privacy regulations are ratifying by parliament, tech corporations are adjusting their information storage infrastructures.',
                            'While new data privacy regulations is being ratified by parliament, tech corporations is adjusting their information storage infrastructures.',
                            'While new data privacy regulations are being ratified by parliament, tech corporations adjusting their information storage infrastructures.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa subordinat berbentuk pasif continuous ("are being ratified") disandingkan dengan klausa utama aktif continuous ("are adjusting").'
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Ekosistem terumbu karang sedang mengalami pemutihan parah karena suhu permukaan laut sedang meningkat secara konsisten sepanjang musim panas.',
                        'target_word' => 'are experiencing ... are rising (Ecological Trend Reporting)',
                        'vocab' => [
                            ['en' => 'coral reef ecosystems', 'id' => 'ekosistem terumbu karang'],
                            ['en' => 'severe bleaching', 'id' => 'pemutihan parah'],
                            ['en' => 'sea surface temperatures', 'id' => 'suhu permukaan laut']
                        ],
                        'options' => [
                            'Coral reef ecosystems are experiencing severe bleaching because sea surface temperatures are rising consistently throughout the summer.',
                            'Coral reef ecosystems is experiencing severe bleaching because sea surface temperatures is rising consistently throughout the summer.',
                            'Coral reef ecosystems are experienced severe bleaching because sea surface temperatures are risen consistently throughout the summer.',
                            'Coral reef ecosystems experiencing severe bleaching because sea surface temperatures rising consistently throughout the summer.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "ecosystems" berpasangan dengan "are experiencing", dan subjek jamak "temperatures" berpasangan dengan "are rising".'
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Model kecerdasan buatan multimodal sedang diintegrasikan ke dalam diagnostik medis, sehingga keakuratan deteksi dini penyakit sedang meningkat pesat.',
                        'target_word' => 'are being integrated ... is rapidly improving (Passive to Active Trend Result)',
                        'vocab' => [
                            ['en' => 'multimodal artificial intelligence models', 'id' => 'model kecerdasan buatan multimodal'],
                            ['en' => 'medical diagnostics', 'id' => 'diagnostik medis'],
                            ['en' => 'early disease detection', 'id' => 'deteksi dini penyakit']
                        ],
                        'options' => [
                            'Multimodal artificial intelligence models are being integrated into medical diagnostics, so the accuracy of early disease detection is rapidly improving.',
                            'Multimodal artificial intelligence models is being integrated into medical diagnostics, so the accuracy of early disease detection are rapidly improving.',
                            'Multimodal artificial intelligence models are integrating into medical diagnostics, so the accuracy of early disease detection is rapidly improving.',
                            'Multimodal artificial intelligence models are being integrated into medical diagnostics, so the accuracy of early disease detection rapidly improving.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama memakai pasif continuous jamak "are being integrated", sedangkan klausa kedua menyatakan hasil tren tunggal "the accuracy ... is rapidly improving".'
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Ketika wilayah perdesaan sedang mengalami depopulasi, pemerintah daerah sedang merumuskan insentif finansial untuk menarik para profesional muda.',
                        'target_word' => 'are experiencing ... are formulating (Socioeconomic Transition)',
                        'vocab' => [
                            ['en' => 'rural regions', 'id' => 'wilayah perdesaan'],
                            ['en' => 'depopulation', 'id' => 'depopulasi'],
                            ['en' => 'financial incentives', 'id' => 'insentif finansial']
                        ],
                        'options' => [
                            'As rural regions are experiencing depopulation, local authorities are formulating financial incentives to attract young professionals.',
                            'As rural regions is experiencing depopulation, local authorities is formulating financial incentives to attract young professionals.',
                            'As rural regions are experienced depopulation, local authorities are formulate financial incentives to attract young professionals.',
                            'As rural regions experiencing depopulation, local authorities formulating financial incentives to attract young professionals.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa jamak ("rural regions" dan "local authorities") menggunakan auxiliary jamak: "are experiencing" dan "are formulating".'
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Standar emisi industri sedang diperketat oleh kementerian lingkungan hidup sementara pabrik-pabrik sedang memasang filter karbon berteknologi tinggi.',
                        'target_word' => 'are being tightened ... are installing (Regulatory Trend)',
                        'vocab' => [
                            ['en' => 'industrial emission standards', 'id' => 'standar emisi industri'],
                            ['en' => 'tightened', 'id' => 'diperketat'],
                            ['en' => 'carbon capture filters', 'id' => 'filter penangkap karbon']
                        ],
                        'options' => [
                            'Industrial emission standards are being tightened by the environmental ministry while factories are installing high-tech carbon capture filters.',
                            'Industrial emission standards are tightening by the environmental ministry while factories are installed high-tech carbon capture filters.',
                            'Industrial emission standards is being tightened by the environmental ministry while factories is installing high-tech carbon capture filters.',
                            'Industrial emission standards are being tightened by the environmental ministry while factories installing high-tech carbon capture filters.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Standar emisi mengalami pengetatan pasif ("are being tightened"), sedangkan pabrik secara aktif memasang ("are installing").'
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Pasar tenaga kerja sedang bertransformasi secara radikal karena otomatisasi sedang menggantikan pekerjaan administratif rutin.',
                        'target_word' => 'is transforming ... is replacing (Technological Disruption)',
                        'vocab' => [
                            ['en' => 'labor market', 'id' => 'pasar tenaga kerja'],
                            ['en' => 'transforming radically', 'id' => 'bertransformasi secara radikal'],
                            ['en' => 'routine administrative tasks', 'id' => 'pekerjaan administratif rutin']
                        ],
                        'options' => [
                            'The labor market is transforming radically because automation is replacing routine administrative tasks.',
                            'The labor market are transforming radically because automation are replacing routine administrative tasks.',
                            'The labor market is transformed radically because automation is replaced routine administrative tasks.',
                            'The labor market transforming radically because automation replacing routine administrative tasks.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The labor market" dan "automation" keduanya subjek tunggal yang menjalankan aksi dinamis: "is transforming" dan "is replacing".'
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Meskipun kampanye vaksinasi massal sedang digencarkan di seluruh distrik, varian patogen baru sedang dipantau secara ketat oleh epidemiolog.',
                        'target_word' => 'is being intensified ... are being monitored (Dual Academic Passive)',
                        'vocab' => [
                            ['en' => 'mass vaccination campaign', 'id' => 'kampanye vaksinasi massal'],
                            ['en' => 'intensified', 'id' => 'digencarkan'],
                            ['en' => 'new pathogen variants', 'id' => 'varian patogen baru'],
                            ['en' => 'epidemiologists', 'id' => 'epidemiolog']
                        ],
                        'options' => [
                            'Although the mass vaccination campaign is being intensified across districts, new pathogen variants are being monitored closely by epidemiologists.',
                            'Although the mass vaccination campaign is intensifying across districts, new pathogen variants are monitoring closely by epidemiologists.',
                            'Although the mass vaccination campaign are being intensified across districts, new pathogen variants is being monitored closely by epidemiologists.',
                            'Although the mass vaccination campaign is been intensified across districts, new pathogen variants are been monitored closely by epidemiologists.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama memakai pasif tunggal "is being intensified", klausa kedua memakai pasif jamak "are being monitored". Kedua subjek menerima aksi.'
                    ],
                ]
            ],
        ];
    }
}
