<?php

namespace App\Services;

class SelfStudyPresentPerfectDataAdvanced
{
    /**
     * Get the complete Present Perfect Tense (Verbal, Nominal, Passive) package.
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
            'banner_title' => 'Present Perfect Tense (Verbal, Nominal, Passive) in Academic Writing',
            'banner_subtitle' => 'Kuasai konstruksi menjembatani tinjauan pustaka (Literature Review), pelaporan capaian riset terkini (have/has + V3), status kondisi berkelanjutan (have/has been + Adj/Noun), ulasan literatur pasif (have/has been + V3), penanda durasi (since/for), dan penegasan celah riset.',
            'banner_badge' => 'MODULE 1.10 PRESENT PERFECT TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.10
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Present Perfect Tense: Menjembatani Literatur & Pelaporan Kemajuan Riset',
            'concept_summary' => 'Present Perfect Tense adalah tense paling fundamental kedua dalam penulisan akademis (setelah Simple Present dan Simple Past). Fungsinya adalah menciptakan jembatan temporal antara peristiwa masa lalu dengan relevansi ilmiah masa kini. Tense ini digunakan secara dominan dalam bab Pendahuluan (Introduction) dan Tinjauan Pustaka (Literature Review) untuk mendokumentasikan apa yang telah ditemukan atau dikembangkan, serta menunjukkan kesenjangan riset (Research Gaps) yang mendasari penelitian Anda.',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Capaian & Terobosan Riset Terkini',
                    'rule_formula' => 'Subject + have/has + Verb 3 (Past Participle) + Object',
                    'rule_description' => 'Gunakan "has + V3" untuk subjek tunggal orang ketiga (the author, this study, the laboratory) dan "have + V3" untuk subjek jamak (researchers, findings, we, they). Jangan pernah menyelipkan to be (was/is) di depan V3 aktif.',
                    'examples' => [
                        [
                            'en' => 'Scientists have identified a new genetic mutation linked to antibiotic resistance.',
                            'id' => 'Para ilmuwan telah mengidentifikasi mutasi genetik baru yang terkait dengan resistensi antibiotik.',
                            'note' => 'Subjek jamak "Scientists" menggunakan auxiliary "have" + V3 "identified".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Bentuk Nominal: Status & Kondisi Berkelanjutan',
                    'rule_formula' => 'Subject + have/has been + Adjective / Noun Phrase / Prepositional Phrase',
                    'rule_description' => 'Menyatakan keadaan atau sifat yang dimulai di masa lampau dan masih berlanjut hingga saat ini. Partikel "been" wajib hadir sebagai bentuk Participle dari to be.',
                    'examples' => [
                        [
                            'en' => 'The test results have been consistent across all independent laboratories.',
                            'id' => 'Hasil pengujian tersebut telah konsisten di seluruh laboratorium independen.',
                            'note' => '"have been consistent" menunjukkan keabsahan hasil yang terus bertahan konsisten.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif Ilmiah (Literature Review Milestone)',
                    'rule_formula' => 'Passive Subject + have/has been + Verb 3 (Past Participle)',
                    'rule_description' => 'Fokus kalimat dialihkan sepenuhnya ke objek penelitian, teori, atau sampel. Bedakan dengan Continuous Pasif (is/are being + V3): Present Perfect Pasif selalu menggunakan "been", bukan "being".',
                    'examples' => [
                        [
                            'en' => 'Various alternative methodologies have been proposed over the past few decades.',
                            'id' => 'Berbagai metodologi alternatif telah diusulkan dalam beberapa dekade terakhir.',
                            'note' => '"have been proposed" mencerminkan akumulasi usulan dalam khazanah ilmiah.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Penanda Waktu: For vs Since vs Over the Past Years',
                    'rule_formula' => 'SINCE + Specific Starting Point | FOR + Duration | OVER THE PAST + Period',
                    'rule_description' => 'Gunakan "since" untuk titik awal waktu (since 2015, since the baseline study). Gunakan "for" untuk akumulasi rentang durasi (for three years, for a decade). Frasa "over the past/last [period]" merujuk pada rentang masa lalu hingga kini.',
                    'examples' => [
                        [
                            'en' => 'Global temperatures have risen steadily since the beginning of the industrial era.',
                            'id' => 'Suhu global telah meningkat secara stabil sejak awal era industri.',
                            'note' => '"since" menandai titik mula era industri.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Present Perfect vs Simple Past (Kesesuaian Tinjauan Pustaka)',
                    'rule_formula' => 'Simple Past: Definite Time (in 2020, yesterday) | Present Perfect: Indefinite / Current Relevance',
                    'rule_description' => 'Jika tahun atau momen lampau spesifik disebutkan (misal: "Smith (2020) discovered..."), gunakan Simple Past. Jika merujuk pada akumulasi kajian umum terkini ("Recent studies have demonstrated..."), gunakan Present Perfect.',
                    'examples' => [
                        [
                            'en' => 'Recent studies have confirmed the original findings of Smith (2018).',
                            'id' => 'Penelitian-penelitian terkini telah mengonfirmasi temuan asli dari Smith (2018).',
                            'note' => 'Bentuk kalimat tunggal: Subjek jamak "Recent studies" + "have confirmed" + Objek Frasa Nomina.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '6. Penyangkalan & Celah Riset (Research Gaps)',
                    'rule_formula' => 'Research Gap: Subject + have/has not + (yet) + V3 / been V3',
                    'rule_description' => 'Untuk merumuskan alasan mengapa penelitian Anda perlu dilakukan, tunjukkan keterbatasan atau celah dalam literatur yang belum terselesaikan.',
                    'examples' => [
                        [
                            'en' => 'The underlying molecular mechanism has not been fully understood by biologists.',
                            'id' => 'Mekanisme molekuler yang mendasari proses tersebut belum sepenuhnya dipahami oleh para ahli biologi.',
                            'note' => 'Menyatakan celah pengetahuan ilmiah yang membuka peluang riset baru.'
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
                'id' => 'present-perfect-verbal',
                'name' => '1.10.1 Present Perfect Verbal: Recent Accomplishments & Research Breakthroughs',
                'code' => '1.10.1',
                'concept_title' => 'Present Perfect Verbal: Pencapaian Terkini & Terobosan Riset',
                'concept_description' => "Present Perfect Verbal digunakan untuk melaporkan tindakan, penemuan, atau terobosan ilmiah yang telah terjadi di masa lalu namun hasilnya relevan, berdampak, atau masih berlaku pada masa kini. Dibentuk dengan auxiliary 'have' (untuk I/you/we/they/jamak) atau 'has' (untuk he/she/it/tunggal) diikuti Past Participle (V3). Dilarang keras menggunakan to be (am/is/are/was/were) di depan V3 aktif.",
                'description' => "Present Perfect Verbal digunakan untuk melaporkan tindakan, penemuan, atau terobosan ilmiah yang telah terjadi di masa lalu namun hasilnya relevan, berdampak, atau masih berlaku pada masa kini. Dibentuk dengan auxiliary 'have' (untuk I/you/we/they/jamak) atau 'has' (untuk he/she/it/tunggal) diikuti Past Participle (V3). Dilarang keras menggunakan to be (am/is/are/was/were) di depan V3 aktif.",
                'formula' => 'Subject + have/has + Verb 3 (Past Participle) + Object / Complement',
                'rules' => [
                    "Gunakan 'has + V3' untuk subjek orang ketiga tunggal (the researcher, this study, it).",
                    "Gunakan 'have + V3' untuk subjek jamak (scientists, data analysts, they) dan subjek 'I/we/you'.",
                    'Verba wajib berbentuk Past Participle / V3 (misal: identified, developed, discovered, proven).',
                    'Jangan menambahkan to be was/is sebelum have/has atau sebelum V3 aktif (*is identified -> pasif, *has been identified -> pasif).',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Para ilmuwan telah mengidentifikasi mutasi genetik baru yang terkait dengan resistensi antibiotik.',
                        'target_word' => 'have identified (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'scientists', 'id' => 'para ilmuwan'],
                            ['en' => 'genetic mutation', 'id' => 'mutasi genetik'],
                            ['en' => 'antibiotic resistance', 'id' => 'resistensi antibiotik'],
                        ],
                        'options' => [
                            'Scientists have identified a new genetic mutation linked to antibiotic resistance.',
                            'Scientists has identified a new genetic mutation linked to antibiotic resistance.',
                            'Scientists have identify a new genetic mutation linked to antibiotic resistance.',
                            'Scientists are identified a new genetic mutation linked to antibiotic resistance.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Scientists' membutuhkan auxiliary 'have' diikuti bentuk Past Participle (V3) 'identified'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Laboratorium kami telah mengembangkan metode pengolahan air limbah yang hemat biaya.',
                        'target_word' => 'has developed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'our laboratory', 'id' => 'laboratorium kami'],
                            ['en' => 'cost-effective', 'id' => 'hemat biaya'],
                            ['en' => 'wastewater treatment method', 'id' => 'metode pengolahan air limbah'],
                        ],
                        'options' => [
                            'Our laboratory has developed a cost-effective wastewater treatment method.',
                            'Our laboratory have developed a cost-effective wastewater treatment method.',
                            'Our laboratory has develop a cost-effective wastewater treatment method.',
                            'Our laboratory was developed a cost-effective wastewater treatment method.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our laboratory' mengambil auxiliary 'has' + V3 'developed'. Opsi 'was developed' bermakna pasif ('laboratorium kami dikembangkan').",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Beberapa studi telah menunjukkan hubungan positif antara olahraga teratur dan kesehatan mental.',
                        'target_word' => 'have demonstrated (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'several studies', 'id' => 'beberapa studi'],
                            ['en' => 'demonstrated', 'id' => 'menunjukkan/membuktikan'],
                            ['en' => 'positive correlation', 'id' => 'hubungan positif'],
                        ],
                        'options' => [
                            'Several studies have demonstrated a positive correlation between regular exercise and mental health.',
                            'Several studies has demonstrated a positive correlation between regular exercise and mental health.',
                            'Several studies have demonstrate a positive correlation between regular exercise and mental health.',
                            'Several studies having demonstrated a positive correlation between regular exercise and mental health.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Several studies' adalah subjek jamak, sehingga memerlukan 'have demonstrated'.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Pemerintah telah mengesahkan undang-undang baru untuk mengurangi emisi industri.',
                        'target_word' => 'has enacted (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'government', 'id' => 'pemerintah'],
                            ['en' => 'enacted legislation', 'id' => 'mengesahkan undang-undang'],
                            ['en' => 'industrial emissions', 'id' => 'emisi industri'],
                        ],
                        'options' => [
                            'The government has enacted new legislation to reduce industrial emissions.',
                            'The government have enacted new legislation to reduce industrial emissions.',
                            'The government has enact new legislation to reduce industrial emissions.',
                            'The government was enacted new legislation to reduce industrial emissions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The government' sebagai entitas tunggal memakai 'has enacted'. Opsi C salah bentuk kata kerja (V1), dan opsi D bentuk pasif.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Para insinyur telah merancang sensor mikro yang sangat sensitif terhadap perubahan tekanan.',
                        'target_word' => 'have designed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'engineers', 'id' => 'para insinyur'],
                            ['en' => 'micro-sensors', 'id' => 'sensor mikro'],
                            ['en' => 'pressure fluctuations', 'id' => 'perubahan tekanan'],
                        ],
                        'options' => [
                            'Engineers have designed micro-sensors that are highly sensitive to pressure fluctuations.',
                            'Engineers has designed micro-sensors that are highly sensitive to pressure fluctuations.',
                            'Engineers have design micro-sensors that are highly sensitive to pressure fluctuations.',
                            'Engineers are designed micro-sensors that are highly sensitive to pressure fluctuations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Engineers' memerlukan 'have designed'. Bentuk 'are designed' adalah pasif Simple Present ('dirancang').",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Penulis telah menyusun argumen yang meyakinkan berdasarkan data empiris terkini.',
                        'target_word' => 'has constructed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'author', 'id' => 'penulis'],
                            ['en' => 'compelling argument', 'id' => 'argumen yang meyakinkan'],
                            ['en' => 'empirical data', 'id' => 'data empiris'],
                        ],
                        'options' => [
                            'The author has constructed a compelling argument based on recent empirical data.',
                            'The author have constructed a compelling argument based on recent empirical data.',
                            'The author has construct a compelling argument based on recent empirical data.',
                            'The author had constructed a compelling argument based on recent empirical data.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The author' memerlukan 'has constructed'. Opsi 'had' merupakan Past Perfect yang memerlukan referensi masa lampau kedua.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Banyak institusi pendidikan telah mengadopsi platform pembelajaran hibrida secara permanen.',
                        'target_word' => 'have adopted (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'educational institutions', 'id' => 'institusi pendidikan'],
                            ['en' => 'hybrid learning platforms', 'id' => 'platform pembelajaran hibrida'],
                            ['en' => 'permanently', 'id' => 'secara permanen'],
                        ],
                        'options' => [
                            'Many educational institutions have adopted hybrid learning platforms permanently.',
                            'Many educational institutions has adopted hybrid learning platforms permanently.',
                            'Many educational institutions have adopt hybrid learning platforms permanently.',
                            'Many educational institutions were adopted hybrid learning platforms permanently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'institutions' mengambil 'have adopted'.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Organisasi kesehatan dunia telah memperbarui pedoman pencegahan penyakit menular.',
                        'target_word' => 'has updated (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'world health organization', 'id' => 'organisasi kesehatan dunia'],
                            ['en' => 'prevention guidelines', 'id' => 'pedoman pencegahan'],
                            ['en' => 'infectious diseases', 'id' => 'penyakit menular'],
                        ],
                        'options' => [
                            'The global health agency has updated its prevention guidelines for infectious diseases.',
                            'The global health agency have updated its prevention guidelines for infectious diseases.',
                            'The global health agency has update its prevention guidelines for infectious diseases.',
                            'The global health agency is updated its prevention guidelines for infectious diseases.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The global health agency' berpasangan dengan 'has updated'.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Para peneliti telah menemukan korelasi kuat antara polusi udara perkotaan dan penyakit pernapasan.',
                        'target_word' => 'have uncovered (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'investigators', 'id' => 'para peneliti'],
                            ['en' => 'uncovered', 'id' => 'menemukan/mengungkap'],
                            ['en' => 'respiratory illnesses', 'id' => 'penyakit pernapasan'],
                        ],
                        'options' => [
                            'Investigators have uncovered a strong correlation between urban air pollution and respiratory illnesses.',
                            'Investigators has uncovered a strong correlation between urban air pollution and respiratory illnesses.',
                            'Investigators have uncover a strong correlation between urban air pollution and respiratory illnesses.',
                            'Investigators are uncovered a strong correlation between urban air pollution and respiratory illnesses.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Investigators' berbentuk jamak sehingga memakai 'have uncovered'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Perusahaan farmasi tersebut telah menyelesaikan uji klinis tahap awal dengan hasil yang memuaskan.',
                        'target_word' => 'has concluded (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'pharmaceutical company', 'id' => 'perusahaan farmasi'],
                            ['en' => 'concluded', 'id' => 'menyelesaikan/menuntaskan'],
                            ['en' => 'promising outcomes', 'id' => 'hasil yang memuaskan/menjanjikan'],
                        ],
                        'options' => [
                            'The pharmaceutical enterprise has concluded early-stage clinical trials with promising outcomes.',
                            'The pharmaceutical enterprise have concluded early-stage clinical trials with promising outcomes.',
                            'The pharmaceutical enterprise has conclude early-stage clinical trials with promising outcomes.',
                            'The pharmaceutical enterprise was concluded early-stage clinical trials with promising outcomes.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'enterprise' menggunakan 'has concluded'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-nominal',
                'name' => '1.10.2 Present Perfect Nominal: Describing Continuing States & Conditions',
                'code' => '1.10.2',
                'concept_title' => 'Present Perfect Nominal: Menjelaskan Status & Kondisi Berkelanjutan',
                'concept_description' => "Present Perfect Nominal digunakan untuk menyatakan keadaan, sifat, atau status keberadaan subjek yang telah dimulai di masa lalu dan terus bertahan hingga saat ini. Pola rumusnya menggunakan auxiliary 'have/has' diikuti 'been' dan pelengkap (Adjective, Noun, atau Prepositional Phrase). Jangan pernah meniadakan kata 'been' pada kalimat nominal.",
                'description' => "Present Perfect Nominal digunakan untuk menyatakan keadaan, sifat, atau status keberadaan subjek yang telah dimulai di masa lalu dan terus bertahan hingga saat ini. Pola rumusnya menggunakan auxiliary 'have/has' diikuti 'been' dan pelengkap (Adjective, Noun, atau Prepositional Phrase). Jangan pernah meniadakan kata 'been' pada kalimat nominal.",
                'formula' => 'Subject + have/has + been + Adjective / Noun Phrase / Prepositional Phrase',
                'rules' => [
                    "Pola nominal wajib menyertakan 'been' setelah have/has (have been / has been).",
                    'Pelengkap berupa kata sifat (adjective), kata benda (noun), atau frasa keterangan tempat/kondisi.',
                    'Dilarang menggunakan V1 atau V2 murni setelah have/has been dalam kalimat nominal (*has been be, *have been were).',
                    'Menunjukkan kontinuitas status dari masa lampau hingga saat kalimat diucapkan.',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Hasil pengujian tersebut telah konsisten di seluruh laboratorium independen.',
                        'target_word' => 'have been consistent (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'test results', 'id' => 'hasil pengujian'],
                            ['en' => 'consistent', 'id' => 'konsisten'],
                            ['en' => 'independent laboratories', 'id' => 'laboratorium independen'],
                        ],
                        'options' => [
                            'The test results have been consistent across all independent laboratories.',
                            'The test results has been consistent across all independent laboratories.',
                            'The test results have consistent across all independent laboratories.',
                            'The test results are been consistent across all independent laboratories.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'The test results' memerlukan 'have been' sebelum adjective 'consistent'. Pilihan C salah karena meniadakan 'been'.",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Transisi menuju energi hijau telah menjadi prioritas strategis bagi negara-negara anggota.',
                        'target_word' => 'has been a strategic priority (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'transition', 'id' => 'transisi'],
                            ['en' => 'strategic priority', 'id' => 'prioritas strategis'],
                            ['en' => 'member states', 'id' => 'negara-negara anggota'],
                        ],
                        'options' => [
                            'The transition toward green energy has been a strategic priority for member states.',
                            'The transition toward green energy have been a strategic priority for member states.',
                            'The transition toward green energy has a strategic priority for member states.',
                            'The transition toward green energy was been a strategic priority for member states.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Head noun 'The transition' berbentuk tunggal, maka bentuk nominal yang benar adalah 'has been a strategic priority'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Kondisi ekonomi di wilayah pedesaan telah stabil selama beberapa kuartal terakhir.',
                        'target_word' => 'have been stable (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'economic conditions', 'id' => 'kondisi ekonomi'],
                            ['en' => 'stable', 'id' => 'stabil'],
                            ['en' => 'recent quarters', 'id' => 'kuartal terakhir'],
                        ],
                        'options' => [
                            'Economic conditions in rural territories have been stable over the past several quarters.',
                            'Economic conditions in rural territories has been stable over the past several quarters.',
                            'Economic conditions in rural territories have stable over the past several quarters.',
                            'Economic conditions in rural territories had been stable over the past several quarters.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Economic conditions' berpasangan dengan 'have been stable'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Profesor tersebut telah menjadi penasihat ilmiah utama bagi kementerian lingkungan selama satu dekade.',
                        'target_word' => 'has been the chief scientific advisor (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'professor', 'id' => 'profesor'],
                            ['en' => 'chief scientific advisor', 'id' => 'penasihat ilmiah utama'],
                            ['en' => 'environment ministry', 'id' => 'kementerian lingkungan'],
                        ],
                        'options' => [
                            'The distinguished professor has been the chief scientific advisor to the environment ministry for a decade.',
                            'The distinguished professor have been the chief scientific advisor to the environment ministry for a decade.',
                            'The distinguished professor has the chief scientific advisor to the environment ministry for a decade.',
                            'The distinguished professor is being the chief scientific advisor to the environment ministry for a decade.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The distinguished professor' memerlukan 'has been' diikuti noun phrase jabatan.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Kurangnya pendanaan yang memadai telah menjadi hambatan utama bagi kemajuan riset.',
                        'target_word' => 'has been a major obstacle (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'lack of adequate funding', 'id' => 'kurangnya pendanaan memadai'],
                            ['en' => 'major obstacle', 'id' => 'hambatan utama'],
                            ['en' => 'research advancement', 'id' => 'kemajuan riset'],
                        ],
                        'options' => [
                            'The lack of adequate funding has been a major obstacle to research advancement.',
                            'The lack of adequate funding have been a major obstacle to research advancement.',
                            'The lack of adequate funding has a major obstacle to research advancement.',
                            'The lack of adequate funding been a major obstacle to research advancement.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Head noun 'The lack' adalah tunggal, sehingga bentuk nominal yang tepat adalah 'has been'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Tingkat kepuasan mahasiswa telah sangat tinggi sejak penerapan kurikulum modular baru.',
                        'target_word' => 'has been exceptionally high (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'student satisfaction rate', 'id' => 'tingkat kepuasan mahasiswa'],
                            ['en' => 'exceptionally high', 'id' => 'sangat tinggi'],
                            ['en' => 'modular curriculum', 'id' => 'kurikulum modular'],
                        ],
                        'options' => [
                            'The student satisfaction rate has been exceptionally high since the introduction of the modular curriculum.',
                            'The student satisfaction rate have been exceptionally high since the introduction of the modular curriculum.',
                            'The student satisfaction rate has exceptionally high since the introduction of the modular curriculum.',
                            'The student satisfaction rate was exceptionally high since the introduction of the modular curriculum.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The student satisfaction rate' (tunggal) dengan penanda waktu 'since' mewajibkan Present Perfect Nominal 'has been'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Kedua senyawa kimia tersebut telah reaktif di bawah kondisi tekanan atmosfer standar.',
                        'target_word' => 'have been reactive (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'chemical compounds', 'id' => 'senyawa kimia'],
                            ['en' => 'reactive', 'id' => 'reaktif'],
                            ['en' => 'atmospheric pressure', 'id' => 'tekanan atmosfer'],
                        ],
                        'options' => [
                            'Both chemical compounds have been reactive under standard atmospheric pressure conditions.',
                            'Both chemical compounds has been reactive under standard atmospheric pressure conditions.',
                            'Both chemical compounds have reactive under standard atmospheric pressure conditions.',
                            'Both chemical compounds are been reactive under standard atmospheric pressure conditions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Both chemical compounds' berpasangan dengan 'have been reactive'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Etika kecerdasan buatan telah menjadi topik perdebatan hangat di kalangan akademisi.',
                        'target_word' => 'has been a subject of intense debate (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'artificial intelligence ethics', 'id' => 'etika kecerdasan buatan'],
                            ['en' => 'intense debate', 'id' => 'perdebatan hangat'],
                            ['en' => 'academics', 'id' => 'kalangan akademisi'],
                        ],
                        'options' => [
                            'Artificial intelligence ethics has been a subject of intense debate among academic scholars.',
                            'Artificial intelligence ethics have been a subject of intense debate among academic scholars.',
                            'Artificial intelligence ethics has a subject of intense debate among academic scholars.',
                            'Artificial intelligence ethics was been a subject of intense debate among academic scholars.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Ethics' dalam bidang kajian adalah uncountable noun tunggal, sehingga memerlukan 'has been'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Kawasan lindung tersebut telah bebas dari aktivitas perburuan liar selama lima tahun berturut-turut.',
                        'target_word' => 'has been free from (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'protected reserve', 'id' => 'kawasan lindung'],
                            ['en' => 'poaching activities', 'id' => 'aktivitas perburuan liar'],
                            ['en' => 'consecutive years', 'id' => 'tahun berturut-turut'],
                        ],
                        'options' => [
                            'The protected reserve has been free from illegal poaching activities for five consecutive years.',
                            'The protected reserve have been free from illegal poaching activities for five consecutive years.',
                            'The protected reserve has free from illegal poaching activities for five consecutive years.',
                            'The protected reserve were free from illegal poaching activities for five consecutive years.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The protected reserve' dipadukan dengan 'has been free from'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Tindakan pencegahan dini telah sangat efektif dalam menekan penyebaran patogen.',
                        'target_word' => 'have been remarkably effective (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'early preventive measures', 'id' => 'tindakan pencegahan dini'],
                            ['en' => 'remarkably effective', 'id' => 'sangat efektif'],
                            ['en' => 'curbing pathogen spread', 'id' => 'menekan penyebaran patogen'],
                        ],
                        'options' => [
                            'Early preventive measures have been remarkably effective in curbing the spread of the pathogen.',
                            'Early preventive measures has been remarkably effective in curbing the spread of the pathogen.',
                            'Early preventive measures have remarkably effective in curbing the spread of the pathogen.',
                            'Early preventive measures are been remarkably effective in curbing the spread of the pathogen.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'measures' berpasangan dengan 'have been remarkably effective'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-passive',
                'name' => '1.10.3 Present Perfect Passive: Objective Literature Review & Historical Milestones',
                'code' => '1.10.3',
                'concept_title' => 'Present Perfect Pasif: Tinjauan Pustaka & Pelaporan Prosedur Ilmiah',
                'concept_description' => "Present Perfect Pasif adalah instrumen sintaksis paling krusial dalam menulis bab Tinjauan Pustaka (Literature Review) dan Latar Belakang (Introduction). Tense ini menonjolkan apa yang telah diteliti, diusulkan, atau diverifikasi oleh komunitas ilmiah, tanpa harus memfokuskan kalimat pada subjek peneliti secara personal. Rumusnya menggunakan 'have/has been' diikuti Past Participle (V3).",
                'description' => "Present Perfect Pasif adalah instrumen sintaksis paling krusial dalam menulis bab Tinjauan Pustaka (Literature Review) dan Latar Belakang (Introduction). Tense ini menonjolkan apa yang telah diteliti, diusulkan, atau diverifikasi oleh komunitas ilmiah, tanpa harus memfokuskan kalimat pada subjek peneliti secara personal. Rumusnya menggunakan 'have/has been' diikuti Past Participle (V3).",
                'formula' => 'Subject (Patient) + have/has + been + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    'Struktur wajib: have/has + been + Past Participle (V3).',
                    "Jangan tertukar dengan Continuous Pasif (is/are being + V3); perfect pasif selalu menggunakan 'been', bukan 'being'.",
                    'Verba literatur umum: proposed, documented, established, investigated, demonstrated, observed.',
                    "Subjek jamak memakai 'have been + V3', subjek tunggal memakai 'has been + V3'.",
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Berbagai metodologi alternatif telah diusulkan dalam beberapa dekade terakhir.',
                        'target_word' => 'have been proposed (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'alternative methodologies', 'id' => 'metodologi alternatif'],
                            ['en' => 'proposed', 'id' => 'diusulkan'],
                            ['en' => 'past decades', 'id' => 'dekade terakhir'],
                        ],
                        'options' => [
                            'Various alternative methodologies have been proposed over the past few decades.',
                            'Various alternative methodologies has been proposed over the past few decades.',
                            'Various alternative methodologies have being proposed over the past few decades.',
                            'Various alternative methodologies have proposed over the past few decades.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'methodologies' memerlukan 'have been proposed'. Opsi C salah memakai 'being', dan opsi D aktif ('telah mengusulkan').",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Korelasi statistik yang signifikan telah didokumentasikan dalam sejumlah penelitian epidemiologi.',
                        'target_word' => 'has been documented (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'statistically significant correlation', 'id' => 'korelasi statistik yang signifikan'],
                            ['en' => 'documented', 'id' => 'didokumentasikan'],
                            ['en' => 'epidemiological investigations', 'id' => 'penelitian epidemiologi'],
                        ],
                        'options' => [
                            'A statistically significant correlation has been documented in numerous epidemiological investigations.',
                            'A statistically significant correlation have been documented in numerous epidemiological investigations.',
                            'A statistically significant correlation has being documented in numerous epidemiological investigations.',
                            'A statistically significant correlation has documented in numerous epidemiological investigations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Head noun 'A correlation' adalah tunggal, sehingga bentuk pasif yang tepat adalah 'has been documented'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Protokol keamanan hayati yang ketat telah diterapkan di semua fasilitas laboratorium berisiko tinggi.',
                        'target_word' => 'have been implemented (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'stringent biosafety protocols', 'id' => 'protokol keamanan hayati yang ketat'],
                            ['en' => 'implemented', 'id' => 'diterapkan'],
                            ['en' => 'high-containment laboratory facilities', 'id' => 'fasilitas laboratorium berisiko tinggi'],
                        ],
                        'options' => [
                            'Stringent biosafety protocols have been implemented across all high-containment laboratory facilities.',
                            'Stringent biosafety protocols has been implemented across all high-containment laboratory facilities.',
                            'Stringent biosafety protocols have being implemented across all high-containment laboratory facilities.',
                            'Stringent biosafety protocols were implemented across all high-containment laboratory facilities since then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'protocols' membutuhkan 'have been implemented'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Hipotesis kerja tersebut telah diverifikasi melalui serangkaian eksperimen independen.',
                        'target_word' => 'has been verified (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'working hypothesis', 'id' => 'hipotesis kerja'],
                            ['en' => 'verified', 'id' => 'diverifikasi'],
                            ['en' => 'series of independent experiments', 'id' => 'serangkaian eksperimen independen'],
                        ],
                        'options' => [
                            'The working hypothesis has been verified through a rigorous series of independent experiments.',
                            'The working hypothesis have been verified through a rigorous series of independent experiments.',
                            'The working hypothesis has being verified through a rigorous series of independent experiments.',
                            'The working hypothesis has verified through a rigorous series of independent experiments.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The working hypothesis' berpasangan dengan 'has been verified'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Data survei demografi telah dikumpulkan dari lebih dari lima ribu rumah tangga.',
                        'target_word' => 'have been gathered (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'demographic survey data', 'id' => 'data survei demografi'],
                            ['en' => 'gathered', 'id' => 'dikumpulkan'],
                            ['en' => 'households', 'id' => 'rumah tangga'],
                        ],
                        'options' => [
                            'Demographic survey records have been gathered from more than five thousand participating households.',
                            'Demographic survey records has been gathered from more than five thousand participating households.',
                            'Demographic survey records have being gathered from more than five thousand participating households.',
                            'Demographic survey records have gathered from more than five thousand participating households.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'records' memerlukan 'have been gathered'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Efektivitas klinis obat baru tersebut telah dievaluasi dalam uji coba acak terkontrol.',
                        'target_word' => 'has been evaluated (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'clinical efficacy', 'id' => 'efektivitas klinis'],
                            ['en' => 'evaluated', 'id' => 'dievaluasi'],
                            ['en' => 'randomized controlled trials', 'id' => 'uji coba acak terkontrol'],
                        ],
                        'options' => [
                            'The clinical efficacy of the novel drug has been evaluated in randomized controlled trials.',
                            'The clinical efficacy of the novel drug have been evaluated in randomized controlled trials.',
                            'The clinical efficacy of the novel drug has being evaluated in randomized controlled trials.',
                            'The clinical efficacy of the novel drug has evaluated in randomized controlled trials.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek utama adalah 'The clinical efficacy' (tunggal), maka bentuk pasif yang tepat adalah 'has been evaluated'.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Temuan-temuan awal ini telah dipublikasikan di jurnal ilmiah terkemuka.',
                        'target_word' => 'have been published (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'preliminary findings', 'id' => 'temuan-temuan awal'],
                            ['en' => 'published', 'id' => 'dipublikasikan'],
                            ['en' => 'leading peer-reviewed journals', 'id' => 'jurnal ilmiah terkemuka'],
                        ],
                        'options' => [
                            'These preliminary findings have been published in leading peer-reviewed journals.',
                            'These preliminary findings has been published in leading peer-reviewed journals.',
                            'These preliminary findings have being published in leading peer-reviewed journals.',
                            'These preliminary findings have published in leading peer-reviewed journals.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'findings' dipadukan dengan 'have been published'.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Sebuah kerangka kerja konseptual yang komprehensif telah dirumuskan untuk mengatasi kesenjangan data.',
                        'target_word' => 'has been formulated (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'conceptual framework', 'id' => 'kerangka kerja konseptual'],
                            ['en' => 'formulated', 'id' => 'dirumuskan'],
                            ['en' => 'address data disparities', 'id' => 'mengatasi kesenjangan data'],
                        ],
                        'options' => [
                            'A comprehensive conceptual framework has been formulated to address persistent data disparities.',
                            'A comprehensive conceptual framework have been formulated to address persistent data disparities.',
                            'A comprehensive conceptual framework has being formulated to address persistent data disparities.',
                            'A comprehensive conceptual framework has formulated to address persistent data disparities.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'A framework' adalah tunggal, sehingga bentuk pasif formal yang tepat adalah 'has been formulated'.",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Beberapa anomali pengukuran telah terdeteksi selama fase kalibrasi instrumen.',
                        'target_word' => 'have been detected (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'measurement anomalies', 'id' => 'anomali pengukuran'],
                            ['en' => 'detected', 'id' => 'terdeteksi/dideteksi'],
                            ['en' => 'calibration phase', 'id' => 'fase kalibrasi'],
                        ],
                        'options' => [
                            'Several measurement anomalies have been detected during the instrument calibration phase.',
                            'Several measurement anomalies has been detected during the instrument calibration phase.',
                            'Several measurement anomalies have being detected during the instrument calibration phase.',
                            'Several measurement anomalies have detected during the instrument calibration phase.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'anomalies' memerlukan 'have been detected'.",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Standar emisi industri telah diperketat guna memenuhi kesepakatan iklim global.',
                        'target_word' => 'have been revised (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'industrial emission thresholds', 'id' => 'standar emisi industri'],
                            ['en' => 'tightened/revised', 'id' => 'diperketat/direvisi'],
                            ['en' => 'global climate accords', 'id' => 'kesepakatan iklim global'],
                        ],
                        'options' => [
                            'Industrial emission thresholds have been tightened to align with global climate accords.',
                            'Industrial emission thresholds has been tightened to align with global climate accords.',
                            'Industrial emission thresholds have being tightened to align with global climate accords.',
                            'Industrial emission thresholds have tightened to align with global climate accords.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'thresholds' berpasangan dengan 'have been tightened'.",
                    ],
                ]
            ],
            [
                'id' => 'duration-markers-for-since',
                'name' => '1.10.4 Duration Markers: For vs Since vs Over the Past/Last Decades',
                'code' => '1.10.4',
                'concept_title' => 'Penanda Durasi: For, Since, & Over the Past / Last Years',
                'concept_description' => "Present Perfect sering dipadukan dengan penanda waktu duratif untuk menunjukkan rentang kontinuitas suatu fenomena. Gunakan 'since' jika merujuk pada titik awal waktu spesifik (since 2010, since the inception). Gunakan 'for' untuk total kurun waktu durasi (for five years, for two decades). Gunakan 'over the past/last...' untuk merangkum perkembangan tren terkini.",
                'description' => "Present Perfect sering dipadukan dengan penanda waktu duratif untuk menunjukkan rentang kontinuitas suatu fenomena. Gunakan 'since' jika merujuk pada titik awal waktu spesifik (since 2010, since the inception). Gunakan 'for' untuk total kurun waktu durasi (for five years, for two decades). Gunakan 'over the past/last...' untuk merangkum perkembangan tren terkini.",
                'formula' => 'Subject + have/has + V3/been + FOR (duration) / SINCE (starting point) / OVER THE PAST (period)',
                'rules' => [
                    "'Since' + titik awal waktu (misal: since 1995, since the baseline survey, since graduation).",
                    "'For' + durasi waktu (misal: for three years, for a century, for months).",
                    "'Over / In the past [number] years' merujuk kurun waktu lampau hingga sekarang dan WAJIB menggunakan Present Perfect.",
                    "Jangan gunakan Simple Past dengan 'since' jika kalimat merujuk pada kondisi yang berlanjut hingga kini.",
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Suhu global telah meningkat secara stabil sejak awal era industri.',
                        'target_word' => 'have risen ... since (Duration Marker: Since)',
                        'vocab' => [
                            ['en' => 'global temperatures', 'id' => 'suhu global'],
                            ['en' => 'risen steadily', 'id' => 'meningkat secara stabil'],
                            ['en' => 'industrial era', 'id' => 'era industri'],
                        ],
                        'options' => [
                            'Global temperatures have risen steadily since the beginning of the industrial era.',
                            'Global temperatures have risen steadily for the beginning of the industrial era.',
                            'Global temperatures rose steadily since the beginning of the industrial era.',
                            'Global temperatures has risen steadily since the beginning of the industrial era.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Titik waktu awal ('the beginning...') memerlukan preposisi 'since', dan subjek jamak 'temperatures' membutuhkan 'have risen'.",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Lembaga penelitian tersebut telah beroperasi di kota ini selama lebih dari tiga dekade.',
                        'target_word' => 'has operated ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'research institution', 'id' => 'lembaga penelitian'],
                            ['en' => 'operated', 'id' => 'beroperasi'],
                            ['en' => 'three decades', 'id' => 'tiga dekade'],
                        ],
                        'options' => [
                            'The research institution has operated in this municipality for more than three decades.',
                            'The research institution has operated in this municipality since more than three decades.',
                            'The research institution have operated in this municipality for more than three decades.',
                            'The research institution operated in this municipality for more than three decades currently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rentang durasi waktu ('three decades') memerlukan 'for', dan subjek tunggal 'institution' memakai 'has operated'.",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Selama lima tahun terakhir, adopsi kendaraan listrik telah melonjak secara eksponensial.',
                        'target_word' => 'has surged ... over the past five years (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'electric vehicle adoption', 'id' => 'adopsi kendaraan listrik'],
                            ['en' => 'surged exponentially', 'id' => 'melonjak secara eksponensial'],
                            ['en' => 'over the past five years', 'id' => 'selama lima tahun terakhir'],
                        ],
                        'options' => [
                            'Over the past five years, electric vehicle adoption has surged exponentially across urban centers.',
                            'Over the past five years, electric vehicle adoption surged exponentially across urban centers in 2020.',
                            'Over the past five years, electric vehicle adoption have surged exponentially across urban centers.',
                            'Over the past five years, electric vehicle adoption is surging exponentially since then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa waktu 'Over the past five years' menghubungkan masa lampau ke masa kini sehingga memerlukan Present Perfect 'has surged'.",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Para peneliti telah memantau populasi gajah tersebut sejak proyek konservasi dimulai pada tahun 2012.',
                        'target_word' => 'have monitored ... since (Duration Marker: Since + Clause)',
                        'vocab' => [
                            ['en' => 'researchers', 'id' => 'para peneliti'],
                            ['en' => 'monitored', 'id' => 'memantau'],
                            ['en' => 'conservation project commenced', 'id' => 'proyek konservasi dimulai'],
                        ],
                        'options' => [
                            'Researchers have monitored the elephant population since the conservation project commenced in 2012.',
                            'Researchers have monitored the elephant population for the conservation project commenced in 2012.',
                            'Researchers monitored the elephant population since the conservation project commenced in 2012.',
                            'Researchers has monitored the elephant population since the conservation project commenced in 2012.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa awal waktu lampau ('since the project commenced') menjadi patokan bagi induk kalimat Present Perfect 'have monitored'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Perekonomian nasional telah mengalami pertumbuhan yang moderat selama dua kuartal berturut-turut.',
                        'target_word' => 'has experienced ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'national economy', 'id' => 'perekonomian nasional'],
                            ['en' => 'moderate growth', 'id' => 'pertumbuhan moderat'],
                            ['en' => 'two consecutive quarters', 'id' => 'dua kuartal berturut-turut'],
                        ],
                        'options' => [
                            'The national economy has experienced moderate growth for two consecutive quarters.',
                            'The national economy has experienced moderate growth since two consecutive quarters.',
                            'The national economy have experienced moderate growth for two consecutive quarters.',
                            'The national economy experienced moderate growth for two consecutive quarters now.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Total durasi waktu ('two consecutive quarters') membutuhkan preposisi 'for'.",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Dalam beberapa tahun terakhir, teknologi pembelajaran mesin telah mengubah lanskap komputasi.',
                        'target_word' => 'has transformed ... in recent years (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'machine learning technology', 'id' => 'teknologi pembelajaran mesin'],
                            ['en' => 'transformed', 'id' => 'mengubah'],
                            ['en' => 'computational landscape', 'id' => 'lanskap komputasi'],
                        ],
                        'options' => [
                            'In recent years, machine learning technology has transformed the computational landscape.',
                            'In recent years, machine learning technology transformed the computational landscape previously.',
                            'In recent years, machine learning technology have transformed the computational landscape.',
                            'In recent years, machine learning technology is transforming the computational landscape yesterday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'In recent years' adalah penanda waktu baku Present Perfect ('has transformed').",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Perjanjian perdagangan bilateral tersebut telah berlaku sejak ratifikasi resminya tahun lalu.',
                        'target_word' => 'has been in effect since (Nominal + Since)',
                        'vocab' => [
                            ['en' => 'bilateral trade agreement', 'id' => 'perjanjian perdagangan bilateral'],
                            ['en' => 'in effect', 'id' => 'berlaku'],
                            ['en' => 'formal ratification', 'id' => 'ratifikasi resmi'],
                        ],
                        'options' => [
                            'The bilateral trade agreement has been in effect since its formal ratification last year.',
                            'The bilateral trade agreement has been in effect for its formal ratification last year.',
                            'The bilateral trade agreement was in effect since its formal ratification last year.',
                            'The bilateral trade agreement have been in effect since its formal ratification last year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Momen spesifik ('its formal ratification') menggunakan 'since', dipadukan dengan Present Perfect Nominal 'has been in effect'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Keluarga pasien telah tinggal di daerah terpencil ini selama beberapa generasi.',
                        'target_word' => 'have resided ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => "patient's family", 'id' => 'keluarga pasien'],
                            ['en' => 'remote area', 'id' => 'daerah terpencil'],
                            ['en' => 'several generations', 'id' => 'beberapa generasi'],
                        ],
                        'options' => [
                            "The patient's family members have resided in this remote valley for several generations.",
                            "The patient's family members have resided in this remote valley since several generations.",
                            "The patient's family members has resided in this remote valley for several generations.",
                            "The patient's family members resided in this remote valley since several generations.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi jamak ('several generations') memakai 'for' dengan verba jamak 'have resided'.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Sejak diterbitkannya laporan itu, kepedulian masyarakat terhadap krisis iklim telah meningkat secara nyata.',
                        'target_word' => 'has heightened ... since (Since + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'publication of the report', 'id' => 'diterbitkannya laporan itu'],
                            ['en' => 'public awareness', 'id' => 'kepedulian masyarakat'],
                            ['en' => 'heightened markedly', 'id' => 'meningkat secara nyata'],
                        ],
                        'options' => [
                            'Since the publication of the report, public awareness regarding the climate crisis has heightened markedly.',
                            'For the publication of the report, public awareness regarding the climate crisis has heightened markedly.',
                            'Since the publication of the report, public awareness regarding the climate crisis heightened markedly.',
                            'Since the publication of the report, public awareness regarding the climate crisis have heightened markedly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Since' menandai titik awal penerbitan laporan; subjek tunggal 'public awareness' menggunakan 'has heightened'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Selama satu abad terakhir, harapan hidup rata-rata manusia telah berlipat ganda di banyak wilayah.',
                        'target_word' => 'has doubled ... over the last century (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'average human life expectancy', 'id' => 'harapan hidup rata-rata manusia'],
                            ['en' => 'doubled', 'id' => 'berlipat ganda'],
                            ['en' => 'over the last century', 'id' => 'selama satu abad terakhir'],
                        ],
                        'options' => [
                            'Over the last century, average human life expectancy has doubled across multiple global regions.',
                            'Over the last century, average human life expectancy doubled across multiple global regions in 1990.',
                            'Over the last century, average human life expectancy have doubled across multiple global regions.',
                            'Over the last century, average human life expectancy is doubled across multiple global regions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Over the last century' adalah penanda waktu rentang ke masa kini yang mewajibkan Present Perfect 'has doubled'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-vs-simple-past',
                'name' => '1.10.5 Present Perfect vs Simple Past (Definite Past vs Current Relevance)',
                'code' => '1.10.5',
                'concept_title' => 'Present Perfect vs Simple Past: Waktu Definitif vs Relevansi Masa Kini',
                'concept_description' => 'Membedakan peristiwa yang terputus di masa lalu (Simple Past dengan penanda waktu definitif: in 2018, yesterday, during the first phase) dengan peristiwa yang hasilnya masih relevan atau waktu terjadinya tidak spesifik (Present Perfect: recently, so far, to date). Menggabungkan kedua tense ini secara tepat adalah kunci penulisan tinjauan pustaka akademis.',
                'description' => 'Membedakan peristiwa yang terputus di masa lalu (Simple Past dengan penanda waktu definitif: in 2018, yesterday, during the first phase) dengan peristiwa yang hasilnya masih relevan atau waktu terjadinya tidak spesifik (Present Perfect: recently, so far, to date). Menggabungkan kedua tense ini secara tepat adalah kunci penulisan tinjauan pustaka akademis.',
                'formula' => 'Definite Past: S + V2 (Past Time Marker) | Current Relevance: S + have/has + V3',
                'rules' => [
                    'Waktu definitif lampau (in 2020, two years ago, last month) WAJIB menggunakan Simple Past V2.',
                    'Waktu tidak definitif atau rentang terbuka (recently, so far, to date) WAJIB menggunakan Present Perfect.',
                    'Dilarang mencampuradukkan penanda waktu lampau spesifik dengan Present Perfect (*The team has published the paper in 2020 adalah KESALAHAN BESAR).',
                    'Dalam ulasan studi terdahulu: sebutkan nama peneliti & tahun dengan Simple Past (Smith (2020) found...), lalu sintesiskan tren umumnya dengan Present Perfect (Recent studies have confirmed...).',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Para peneliti mempublikasikan laporan awal mereka pada tahun 2019, namun mereka baru saja merilis data lengkapnya tahun ini.',
                        'target_word' => 'published ... have recently released (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'published', 'id' => 'mempublikasikan (lampau)'],
                            ['en' => 'initial report', 'id' => 'laporan awal'],
                            ['en' => 'recently released', 'id' => 'baru saja merilis'],
                        ],
                        'options' => [
                            'Researchers published their initial report in 2019, but they have recently released the complete dataset this year.',
                            'Researchers have published their initial report in 2019, but they recently released the complete dataset this year.',
                            'Researchers published their initial report in 2019, but they recently release the complete dataset this year.',
                            'Researchers have published their initial report in 2019, but they have recently released the complete dataset this year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa pertama memiliki waktu definitif 'in 2019' sehingga wajib Simple Past ('published'). Klausa kedua memiliki relevansi masa kini 'have recently released'.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Meskipun krisis keuangan terjadi satu dekade yang lalu, para pembuat kebijakan telah mengadopsi regulasi yang lebih ketat sejak saat itu.',
                        'target_word' => 'occurred ... have adopted (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'financial crisis occurred', 'id' => 'krisis keuangan terjadi'],
                            ['en' => 'a decade ago', 'id' => 'satu dekade lalu'],
                            ['en' => 'have adopted', 'id' => 'telah mengadopsi'],
                        ],
                        'options' => [
                            'Although the financial crisis occurred a decade ago, policymakers have adopted stricter regulations since then.',
                            'Although the financial crisis has occurred a decade ago, policymakers have adopted stricter regulations since then.',
                            'Although the financial crisis occurred a decade ago, policymakers adopted stricter regulations since then.',
                            'Although the financial crisis was occurred a decade ago, policymakers have adopted stricter regulations since then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'a decade ago' mengharuskan Simple Past 'occurred'. 'since then' mengharuskan Present Perfect 'have adopted'.",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Smith (2018) menemukan anomali tersebut, dan penelitian-penelitian selanjutnya telah mengonfirmasi temuan aslinya.',
                        'target_word' => 'identified ... have confirmed (Literature Citation Pattern)',
                        'vocab' => [
                            ['en' => 'Smith (2018) identified', 'id' => 'Smith (2018) menemukan'],
                            ['en' => 'subsequent studies', 'id' => 'penelitian selanjutnya'],
                            ['en' => 'original findings', 'id' => 'temuan asli'],
                        ],
                        'options' => [
                            'Smith (2018) identified the anomaly, and subsequent studies have confirmed his original findings.',
                            'Smith (2018) has identified the anomaly, and subsequent studies have confirmed his original findings.',
                            'Smith (2018) identified the anomaly, and subsequent studies confirmed his original findings so far.',
                            'Smith (2018) was identified the anomaly, and subsequent studies have confirmed his original findings.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Sitasi spesifik dengan tahun 'Smith (2018)' menggunakan Simple Past 'identified', sedangkan tren penelitian umum yang menyusul memakai Present Perfect 'have confirmed'.",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Pemerintah membangun waduk tersebut pada tahun 2015, dan fasilitas itu telah menyediakan air bersih bagi warga sejak saat itu.',
                        'target_word' => 'constructed ... has provided (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'constructed the reservoir', 'id' => 'membangun waduk'],
                            ['en' => 'in 2015', 'id' => 'pada tahun 2015'],
                            ['en' => 'potable water', 'id' => 'air bersih'],
                        ],
                        'options' => [
                            'The government constructed the reservoir in 2015, and the facility has provided potable water to residents ever since.',
                            'The government has constructed the reservoir in 2015, and the facility has provided potable water to residents ever since.',
                            'The government constructed the reservoir in 2015, and the facility provided potable water to residents ever since.',
                            'The government was constructed the reservoir in 2015, and the facility has provided potable water to residents ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in 2015' membutuhkan Simple Past 'constructed', sedangkan kontinuitas 'ever since' membutuhkan Present Perfect 'has provided'.",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Uji coba pertama gagal karena masalah teknis, namun para ilmuwan telah berhasil mengatasi kendala tersebut.',
                        'target_word' => 'failed ... have successfully overcome (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'first trial failed', 'id' => 'uji coba pertama gagal'],
                            ['en' => 'technical glitch', 'id' => 'masalah teknis'],
                            ['en' => 'successfully overcome', 'id' => 'berhasil mengatasi'],
                        ],
                        'options' => [
                            'The first trial failed due to a technical glitch, but scientists have successfully overcome that constraint.',
                            'The first trial has failed due to a technical glitch, but scientists have successfully overcome that constraint.',
                            'The first trial failed due to a technical glitch, but scientists successfully overcome that constraint.',
                            'The first trial was failed due to a technical glitch, but scientists have successfully overcome that constraint.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Peristiwa kegagalan spesifik di masa lalu memakai Simple Past 'failed', sedangkan hasil capaian yang bertahan hingga kini memakai 'have successfully overcome'.",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Perusahaan tersebut didirikan pada abad ke-19, namun ia telah bertransformasi menjadi konglomerat teknologi mutakhir.',
                        'target_word' => 'was founded ... has transformed (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'was founded', 'id' => 'didirikan'],
                            ['en' => 'in the 19th century', 'id' => 'pada abad ke-19'],
                            ['en' => 'cutting-edge conglomerate', 'id' => 'konglomerat mutakhir'],
                        ],
                        'options' => [
                            'The corporation was founded in the 19th century, but it has transformed into a cutting-edge technology conglomerate.',
                            'The corporation has been founded in the 19th century, but it has transformed into a cutting-edge technology conglomerate.',
                            'The corporation was founded in the 19th century, but it transformed into a cutting-edge technology conglomerate recently.',
                            'The corporation founded in the 19th century, but it has transformed into a cutting-edge technology conglomerate.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pendirian historis 'in the 19th century' memakai Simple Past Pasif 'was founded', sedangkan status perkembangannya kini memakai Present Perfect 'has transformed'.",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Tahun lalu, dewan menyetujui anggaran riset, dan tim telah menggunakan dana tersebut secara efisien.',
                        'target_word' => 'approved ... have utilized (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'approved the research budget', 'id' => 'menyetujui anggaran riset'],
                            ['en' => 'last year', 'id' => 'tahun lalu'],
                            ['en' => 'utilized the funds', 'id' => 'menggunakan dana'],
                        ],
                        'options' => [
                            'Last year, the board approved the research budget, and the team members have utilized the funds efficiently.',
                            'Last year, the board has approved the research budget, and the team members have utilized the funds efficiently.',
                            'Last year, the board approved the research budget, and the team members utilized the funds efficiently so far.',
                            'Last year, the board was approved the research budget, and the team members have utilized the funds efficiently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Last year' mewajibkan Simple Past 'approved'. Penggunaan dana yang berjalan sampai saat ini memakai 'have utilized'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Penyelidikan epidemiologi dimulai pada bulan Januari, dan para analis telah memeriksa ribuan catatan medis sejauh ini.',
                        'target_word' => 'began ... have examined (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'investigation began', 'id' => 'penyelidikan dimulai'],
                            ['en' => 'in January', 'id' => 'pada bulan Januari'],
                            ['en' => 'examined thousands of records', 'id' => 'memeriksa ribuan catatan'],
                        ],
                        'options' => [
                            'The epidemiological investigation began in January, and analysts have examined thousands of medical records so far.',
                            'The epidemiological investigation has begun in January, and analysts have examined thousands of medical records so far.',
                            'The epidemiological investigation began in January, and analysts examined thousands of medical records so far.',
                            'The epidemiological investigation was began in January, and analysts have examined thousands of medical records so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in January' memakai Simple Past 'began', sedangkan akumulasi data 'so far' memakai Present Perfect 'have examined'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Penulis mengusulkan model teoritis tersebut pada dekade sebelumnya, tetapi eksperimen terkini telah memvalidasi prediksinya.',
                        'target_word' => 'proposed ... have validated (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'proposed the theoretical model', 'id' => 'mengusulkan model teoritis'],
                            ['en' => 'in the preceding decade', 'id' => 'pada dekade sebelumnya'],
                            ['en' => 'validated its predictions', 'id' => 'memvalidasi prediksinya'],
                        ],
                        'options' => [
                            'The author proposed the theoretical model in the preceding decade, but recent experiments have validated its predictions.',
                            'The author has proposed the theoretical model in the preceding decade, but recent experiments have validated its predictions.',
                            'The author proposed the theoretical model in the preceding decade, but recent experiments validated its predictions so far.',
                            'The author was proposed the theoretical model in the preceding decade, but recent experiments have validated its predictions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in the preceding decade' adalah penanda waktu lampau selesai ('proposed'), sedangkan pembuktian baru-baru ini memakai 'have validated'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Universitas tersebut meresmikan pusat inovasi ini tiga tahun lalu, dan pusat tersebut telah menghasilkan puluhan paten internasional.',
                        'target_word' => 'inaugurated ... has generated (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'inaugurated the innovation center', 'id' => 'meresmikan pusat inovasi'],
                            ['en' => 'three years ago', 'id' => 'tiga tahun lalu'],
                            ['en' => 'generated international patents', 'id' => 'menghasilkan paten internasional'],
                        ],
                        'options' => [
                            'The university inaugurated the innovation center three years ago, and it has generated dozens of international patents.',
                            'The university has inaugurated the innovation center three years ago, and it has generated dozens of international patents.',
                            'The university inaugurated the innovation center three years ago, and it generated dozens of international patents to date.',
                            'The university was inaugurated the innovation center three years ago, and it has generated dozens of international patents.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'three years ago' memakai Simple Past 'inaugurated'. Akumulasi paten hingga saat ini memakai Present Perfect 'has generated'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-negative-interrogative',
                'name' => '1.10.6 Present Perfect Negative & Interrogative: Research Gaps & Exploratory Questions',
                'code' => '1.10.6',
                'concept_title' => 'Present Perfect Negatif & Interogatif: Celah Riset & Pertanyaan Ilmiah',
                'concept_description' => "Dalam penulisan naskah akademis, bentuk negatif Present Perfect (have/has not + V3 / been V3) memegang peranan krusial untuk menyatakan 'Research Gap' (hal yang belum terselesaikan, belum dibuktikan, atau belum diteliti dalam literatur yang ada). Bentuk interogatif (Have/Has + Subject + V3?) digunakan untuk merumuskan Research Questions.",
                'description' => "Dalam penulisan naskah akademis, bentuk negatif Present Perfect (have/has not + V3 / been V3) memegang peranan krusial untuk menyatakan 'Research Gap' (hal yang belum terselesaikan, belum dibuktikan, atau belum diteliti dalam literatur yang ada). Bentuk interogatif (Have/Has + Subject + V3?) digunakan untuk merumuskan Research Questions.",
                'formula' => 'Negative Gap: Subject + have/has + NOT + (yet) + V3 / been V3 | Question: Have/Has + S + V3?',
                'rules' => [
                    "Sisipkan 'not' di antara auxiliary have/has dan V3 atau been (has not established, have not been evaluated).",
                    "Kata 'yet' sering ditambahkan di akhir kalimat negatif untuk mempertegas celah riset yang masih terbuka.",
                    'Untuk kalimat tanya (Research Question), letakkan Have atau Has di awal sebelum subjek (Have researchers discovered...?).',
                    "Jangan gunakan don't/doesn't untuk membentuk Present Perfect negatif (*does not have seen adalah KESALAHAN FATAL).",
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Mekanisme molekuler yang mendasari proses tersebut belum sepenuhnya dipahami oleh para ahli biologi.',
                        'target_word' => 'has not been fully understood (Research Gap Passive)',
                        'vocab' => [
                            ['en' => 'underlying molecular mechanism', 'id' => 'mekanisme molekuler yang mendasari'],
                            ['en' => 'fully understood', 'id' => 'dipahami sepenuhnya'],
                            ['en' => 'biologists', 'id' => 'para ahli biologi'],
                        ],
                        'options' => [
                            'The underlying molecular mechanism has not been fully understood by developmental biologists.',
                            'The underlying molecular mechanism have not been fully understood by developmental biologists.',
                            'The underlying molecular mechanism does not been fully understood by developmental biologists.',
                            'The underlying molecular mechanism has not being fully understood by developmental biologists.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The mechanism' dalam pola celah riset pasif membutuhkan 'has not been fully understood'.",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Para peneliti belum menguji efektivitas obat eksperimental tersebut pada subjek manusia.',
                        'target_word' => 'have not tested (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'investigators', 'id' => 'para peneliti'],
                            ['en' => 'tested', 'id' => 'menguji'],
                            ['en' => 'human subjects', 'id' => 'subjek manusia'],
                        ],
                        'options' => [
                            'Investigators have not tested the efficacy of the experimental compound on human subjects yet.',
                            'Investigators has not tested the efficacy of the experimental compound on human subjects yet.',
                            'Investigators do not have tested the efficacy of the experimental compound on human subjects yet.',
                            'Investigators have not test the efficacy of the experimental compound on human subjects yet.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Investigators' berpasangan dengan 'have not tested'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Studi komparatif berskala besar mengenai fenomena ini belum pernah dilakukan di Asia Tenggara.',
                        'target_word' => 'has never been conducted (Negative Passive with Never)',
                        'vocab' => [
                            ['en' => 'large-scale comparative study', 'id' => 'studi komparatif berskala besar'],
                            ['en' => 'never been conducted', 'id' => 'belum pernah dilakukan'],
                            ['en' => 'Southeast Asia', 'id' => 'Asia Tenggara'],
                        ],
                        'options' => [
                            'A large-scale comparative study on this phenomenon has never been conducted in Southeast Asia.',
                            'A large-scale comparative study on this phenomenon have never been conducted in Southeast Asia.',
                            'A large-scale comparative study on this phenomenon was never been conducted in Southeast Asia.',
                            'A large-scale comparative study on this phenomenon has never conducted in Southeast Asia.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'A study' dipadukan dengan pasif negatif 'has never been conducted'. Opsi D aktif ('belum pernah melakukan').",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Apakah para pembuat kebijakan telah mengalokasikan sumber daya yang cukup untuk mitigasi bencana alam?',
                        'target_word' => 'Have ... allocated (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'policymakers', 'id' => 'para pembuat kebijakan'],
                            ['en' => 'allocated sufficient resources', 'id' => 'mengalokasikan sumber daya yang cukup'],
                            ['en' => 'natural disaster mitigation', 'id' => 'mitigasi bencana alam'],
                        ],
                        'options' => [
                            'Have policymakers allocated sufficient resources for natural disaster mitigation efforts?',
                            'Has policymakers allocated sufficient resources for natural disaster mitigation efforts?',
                            'Did policymakers have allocated sufficient resources for natural disaster mitigation efforts?',
                            'Have policymakers allocate sufficient resources for natural disaster mitigation efforts?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'policymakers' diawali oleh auxiliary 'Have' diikuti subjek dan V3 'allocated'.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Data klinis dari uji coba acak tersebut belum dipublikasikan dalam repositori akses terbuka.',
                        'target_word' => 'have not been released (Negative Passive)',
                        'vocab' => [
                            ['en' => 'clinical trial data', 'id' => 'data uji coba klinis'],
                            ['en' => 'released/published', 'id' => 'dipublikasikan/dirilis'],
                            ['en' => 'open-access repositories', 'id' => 'repositori akses terbuka'],
                        ],
                        'options' => [
                            'Clinical trial records have not been released in open-access public repositories.',
                            'Clinical trial records has not been released in open-access public repositories.',
                            'Clinical trial records have not being released in open-access public repositories.',
                            'Clinical trial records do not have been released in open-access public repositories.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'records' memerlukan 'have not been released'.",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Pemerintah belum merumuskan kerangka regulasi yang jelas untuk mata uang digital.',
                        'target_word' => 'has not formulated (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'government', 'id' => 'pemerintah'],
                            ['en' => 'formulated a clear regulatory framework', 'id' => 'merumuskan kerangka regulasi yang jelas'],
                            ['en' => 'digital currencies', 'id' => 'mata uang digital'],
                        ],
                        'options' => [
                            'The national authority has not formulated a coherent regulatory framework for digital assets.',
                            'The national authority have not formulated a coherent regulatory framework for digital assets.',
                            'The national authority does not has formulated a coherent regulatory framework for digital assets.',
                            'The national authority has not formulate a coherent regulatory framework for digital assets.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The national authority' berpasangan dengan 'has not formulated'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah para insinyur telah memverifikasi ketahanan struktur terhadap beban seismik ekstrem?',
                        'target_word' => 'Have ... verified (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'engineers', 'id' => 'para insinyur'],
                            ['en' => 'verified structural resilience', 'id' => 'memverifikasi ketahanan struktur'],
                            ['en' => 'extreme seismic loads', 'id' => 'beban seismik ekstrem'],
                        ],
                        'options' => [
                            'Have structural engineers verified the resilience of the design against extreme seismic loads?',
                            'Has structural engineers verified the resilience of the design against extreme seismic loads?',
                            'Do structural engineers have verified the resilience of the design against extreme seismic loads?',
                            'Have structural engineers verify the resilience of the design against extreme seismic loads?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'structural engineers' adalah subjek jamak, sehingga kalimat tanya diawali 'Have' + Subject + V3 'verified'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Dampak jangka panjang dari polusi mikroplastik pada kesehatan manusia belum dapat dipastikan secara ilmiah.',
                        'target_word' => 'has not been ascertained (Research Gap Passive)',
                        'vocab' => [
                            ['en' => 'long-term impact', 'id' => 'dampak jangka panjang'],
                            ['en' => 'microplastic pollution', 'id' => 'polusi mikroplastik'],
                            ['en' => 'ascertained conclusively', 'id' => 'dipastikan secara meyakinkan'],
                        ],
                        'options' => [
                            'The long-term impact of microplastic ingestion has not been ascertained conclusively by researchers.',
                            'The long-term impact of microplastic ingestion have not been ascertained conclusively by researchers.',
                            'The long-term impact of microplastic ingestion has not being ascertained conclusively by researchers.',
                            'The long-term impact of microplastic ingestion is not been ascertained conclusively by researchers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Head noun adalah 'The long-term impact' (tunggal), maka bentuk pasif yang tepat adalah 'has not been ascertained'.",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Kedua kelompok eksperimen belum menunjukkan perbedaan yang signifikan secara statistik.',
                        'target_word' => 'have not exhibited (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'experimental cohorts', 'id' => 'kelompok eksperimen'],
                            ['en' => 'exhibited', 'id' => 'menunjukkan'],
                            ['en' => 'statistically significant disparity', 'id' => 'perbedaan signifikan secara statistik'],
                        ],
                        'options' => [
                            'Both experimental cohorts have not exhibited any statistically significant disparity in outcomes.',
                            'Both experimental cohorts has not exhibited any statistically significant disparity in outcomes.',
                            'Both experimental cohorts do not have exhibited any statistically significant disparity in outcomes.',
                            'Both experimental cohorts have not exhibit any statistically significant disparity in outcomes.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Both experimental cohorts' berpasangan dengan 'have not exhibited'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah studi epidemiologi terbaru telah mengidentifikasi faktor risiko lingkungan yang dominan?',
                        'target_word' => 'Has ... identified (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'epidemiological study', 'id' => 'studi epidemiologi'],
                            ['en' => 'identified', 'id' => 'mengidentifikasi'],
                            ['en' => 'dominant environmental risk factors', 'id' => 'faktor risiko lingkungan dominan'],
                        ],
                        'options' => [
                            'Has the latest epidemiological study identified dominant environmental risk factors?',
                            'Have the latest epidemiological study identified dominant environmental risk factors?',
                            'Did the latest epidemiological study has identified dominant environmental risk factors?',
                            'Has the latest epidemiological study identify dominant environmental risk factors?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'the latest epidemiological study' diawali dengan 'Has' + Subject + V3 'identified'.",
                    ],
                ]
            ],
            [
                'id' => 'adverbs-already-yet-just-recently',
                'name' => '1.10.7 Positioning Key Adverbs of Time & Aspect: Already, Yet, Just, Recently, Ever, Never',
                'code' => '1.10.7',
                'concept_title' => 'Penempatan Adverbia Aspek: Already, Just, Recently, Yet, Never',
                'concept_description' => 'Penempatan adverbia penegas (already, just, recently, never, ever, so far) di posisi yang tepat sangat memengaruhi keterbacaan (flow) dan register formal kalimat akademis. Adverbia frekuensi dan kepastian biasanya diletakkan tepat di antara auxiliary (have/has) dan main verb (V3).',
                'description' => 'Penempatan adverbia penegas (already, just, recently, never, ever, so far) di posisi yang tepat sangat memengaruhi keterbacaan (flow) dan register formal kalimat akademis. Adverbia frekuensi dan kepastian biasanya diletakkan tepat di antara auxiliary (have/has) dan main verb (V3).',
                'formula' => 'Subject + have/has + ALREADY / JUST / RECENTLY / NEVER + Verb 3 (Past Participle)',
                'rules' => [
                    "'Just' diletakkan di antara have/has dan V3 untuk menyatakan tindakan yang baru saja terjadi.",
                    "'Already' diletakkan di antara have/has dan V3 untuk menegaskan bahwa tindakan telah selesai lebih awal dari yang diperkirakan.",
                    "'Recently' dapat diletakkan di antara have/has dan V3, di awal kalimat, atau di akhir klausa.",
                    "'Never' diletakkan di antara have/has dan V3 untuk menyatakan tidak pernah sama sekali.",
                    "'Yet' diletakkan di akhir klausa negatif atau kalimat tanya.",
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Para insinyur baru saja menyelesaikan uji coba aerodinamis prototipe pesawat tersebut.',
                        'target_word' => 'have just completed (Adverb Placement: Just)',
                        'vocab' => [
                            ['en' => 'engineers', 'id' => 'para insinyur'],
                            ['en' => 'just completed', 'id' => 'baru saja menyelesaikan'],
                            ['en' => 'aerodynamic testing', 'id' => 'uji coba aerodinamis'],
                        ],
                        'options' => [
                            'Engineers have just completed the aerodynamic testing of the aircraft prototype.',
                            'Engineers just have completed the aerodynamic testing of the aircraft prototype.',
                            'Engineers have completed just the aerodynamic testing of the aircraft prototype.',
                            'Engineers has just completed the aerodynamic testing of the aircraft prototype.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Adverbia 'just' disisipkan tepat di antara auxiliary 'have' dan V3 'completed'.",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Komite peninjau telah terlebih dahulu menyetujui protokol eksperimen yang diusulkan.',
                        'target_word' => 'has already approved (Adverb Placement: Already)',
                        'vocab' => [
                            ['en' => 'review committee', 'id' => 'komite peninjau'],
                            ['en' => 'already approved', 'id' => 'telah menyetujui terlebih dahulu'],
                            ['en' => 'proposed protocol', 'id' => 'protokol yang diusulkan'],
                        ],
                        'options' => [
                            'The review committee has already approved the proposed experimental protocol.',
                            'The review committee already has approved the proposed experimental protocol.',
                            'The review committee have already approved the proposed experimental protocol.',
                            'The review committee has approved already the proposed experimental protocol.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'has already approved' adalah posisi standar register formal untuk adverbia 'already'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Para ilmuwan baru-baru ini menemukan spesies bakteri laut yang mampu mendegradasi polimer sintetis.',
                        'target_word' => 'have recently discovered (Adverb Placement: Recently)',
                        'vocab' => [
                            ['en' => 'scientists', 'id' => 'para ilmuwan'],
                            ['en' => 'recently discovered', 'id' => 'baru-baru ini menemukan'],
                            ['en' => 'degrade synthetic polymers', 'id' => 'mendegradasi polimer sintetis'],
                        ],
                        'options' => [
                            'Scientists have recently discovered a marine bacterial species capable of degrading synthetic polymers.',
                            'Scientists has recently discovered a marine bacterial species capable of degrading synthetic polymers.',
                            'Scientists recently have discover a marine bacterial species capable of degrading synthetic polymers.',
                            'Scientists have discovered recently a marine bacterial species capable of degrading synthetic polymers in laboratory.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Scientists' berpasangan dengan 'have recently discovered'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Model komputasi tersebut belum pernah menghasilkan anomali separah ini sebelumnya.',
                        'target_word' => 'has never produced (Adverb Placement: Never)',
                        'vocab' => [
                            ['en' => 'computational model', 'id' => 'model komputasi'],
                            ['en' => 'never produced', 'id' => 'belum pernah menghasilkan'],
                            ['en' => 'severe anomaly', 'id' => 'anomali parah'],
                        ],
                        'options' => [
                            'The computational model has never produced an anomaly of this magnitude before.',
                            'The computational model have never produced an anomaly of this magnitude before.',
                            'The computational model never has produced an anomaly of this magnitude before.',
                            'The computational model has produced never an anomaly of this magnitude before.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The computational model' mengambil 'has never produced'.",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Sejauh ini, tim peneliti telah menerbitkan tiga artikel tinjauan di jurnal bereputasi tinggi.',
                        'target_word' => 'have published ... so far (Adverbial Fronting: So far)',
                        'vocab' => [
                            ['en' => 'so far', 'id' => 'sejauh ini'],
                            ['en' => 'published review articles', 'id' => 'menerbitkan artikel tinjauan'],
                            ['en' => 'high-impact journals', 'id' => 'jurnal bereputasi tinggi'],
                        ],
                        'options' => [
                            'So far, the investigative team has published three review articles in high-impact journals.',
                            'So far, the investigative team have published three review articles in high-impact journals.',
                            'So far, the investigative team published three review articles in high-impact journals yesterday.',
                            'So far, the investigative team has publish three review articles in high-impact journals.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'So far' dipadukan dengan Present Perfect. Subjek kolektif tunggal 'the investigative team' menggunakan 'has published'.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Lembaga tersebut belum mengumumkan jadwal ujian sertifikasi profesi.',
                        'target_word' => 'has not yet announced (Adverb Placement: Yet)',
                        'vocab' => [
                            ['en' => 'accreditation board', 'id' => 'lembaga akreditasi'],
                            ['en' => 'not yet announced', 'id' => 'belum mengumumkan'],
                            ['en' => 'certification examination schedule', 'id' => 'jadwal ujian sertifikasi'],
                        ],
                        'options' => [
                            'The accreditation board has not yet announced the professional certification examination schedule.',
                            'The accreditation board have not yet announced the professional certification examination schedule.',
                            'The accreditation board has not announced yet the professional certification examination schedule.',
                            'The accreditation board does not yet announced the professional certification examination schedule.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The accreditation board' menggunakan pola 'has not yet announced'.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Para ahli bedah baru saja mendokumentasikan prosedur transplantasi organ yang inovatif.',
                        'target_word' => 'have just documented (Adverb Placement: Just)',
                        'vocab' => [
                            ['en' => 'surgeons', 'id' => 'para ahli bedah'],
                            ['en' => 'just documented', 'id' => 'baru saja mendokumentasikan'],
                            ['en' => 'groundbreaking transplantation procedure', 'id' => 'prosedur transplantasi inovatif'],
                        ],
                        'options' => [
                            'Surgeons have just documented a groundbreaking organ transplantation procedure.',
                            'Surgeons has just documented a groundbreaking organ transplantation procedure.',
                            'Surgeons just have documented a groundbreaking organ transplantation procedure.',
                            'Surgeons have documented just a groundbreaking organ transplantation procedure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Surgeons' memerlukan 'have just documented'.",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Badan meteorologi telah mengeluarkan peringatan cuaca buruk untuk wilayah pesisir.',
                        'target_word' => 'has already issued (Adverb Placement: Already)',
                        'vocab' => [
                            ['en' => 'meteorological service', 'id' => 'badan meteorologi'],
                            ['en' => 'already issued', 'id' => 'telah mengeluarkan'],
                            ['en' => 'severe weather advisory', 'id' => 'peringatan cuaca buruk'],
                        ],
                        'options' => [
                            'The national meteorological service has already issued a severe weather advisory for coastal provinces.',
                            'The national meteorological service have already issued a severe weather advisory for coastal provinces.',
                            'The national meteorological service already has issued a severe weather advisory for coastal provinces.',
                            'The national meteorological service has issued already a severe weather advisory for coastal provinces.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The service' mengambil 'has already issued'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Beberapa studi baru-baru ini telah menyoroti dampak negatif disinformasi online pada kohesi sosial.',
                        'target_word' => 'have recently highlighted (Adverb Placement: Recently)',
                        'vocab' => [
                            ['en' => 'several recent studies', 'id' => 'beberapa studi terkini'],
                            ['en' => 'highlighted', 'id' => 'menyoroti'],
                            ['en' => 'social cohesion', 'id' => 'kohesi sosial'],
                        ],
                        'options' => [
                            'Several independent studies have recently highlighted the detrimental impact of online disinformation on social cohesion.',
                            'Several independent studies has recently highlighted the detrimental impact of online disinformation on social cohesion.',
                            'Several independent studies have highlighted recently the detrimental impact of online disinformation on social cohesion.',
                            'Several independent studies recently have highlight the detrimental impact of online disinformation on social cohesion.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'studies' berpasangan dengan 'have recently highlighted'.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Apakah Anda pernah mengamati perilaku serupa pada spesies primata liar lainnya?',
                        'target_word' => 'Have you ever observed (Interrogative with Ever)',
                        'vocab' => [
                            ['en' => 'ever observed', 'id' => 'pernah mengamati'],
                            ['en' => 'analogous behavior', 'id' => 'perilaku serupa'],
                            ['en' => 'wild primate species', 'id' => 'spesies primata liar'],
                        ],
                        'options' => [
                            'Have you ever observed analogous behavior in other wild primate species?',
                            'Did you ever observed analogous behavior in other wild primate species?',
                            'Have you observed ever analogous behavior in other wild primate species?',
                            'Has you ever observed analogous behavior in other wild primate species?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola baku pertanyaan pengalaman hidup/observasi adalah 'Have you ever' + V3 'observed'.",
                    ],
                ]
            ],
            [
                'id' => 'literature-review-synthesis',
                'name' => '1.10.8 Comprehensive Synthesis: Literature Review Bridging & Research Status Report',
                'code' => '1.10.8',
                'concept_title' => 'Sintesis Komprehensif: Menjembatani Tinjauan Pustaka & Laporan Kemajuan Riset',
                'concept_description' => 'Mengintegrasikan bentuk verbal, nominal, dan pasif Present Perfect ke dalam wacana naskah akademis utuh (IELTS Task 2, Literature Review, dan Laporan Hasil Riset). Melatih kemampuan merangkai transisi logis antara apa yang telah dibuktikan literatur terdahulu dengan perumusan metodologi atau hipotesis penelitian baru.',
                'description' => 'Mengintegrasikan bentuk verbal, nominal, dan pasif Present Perfect ke dalam wacana naskah akademis utuh (IELTS Task 2, Literature Review, dan Laporan Hasil Riset). Melatih kemampuan merangkai transisi logis antara apa yang telah dibuktikan literatur terdahulu dengan perumusan metodologi atau hipotesis penelitian baru.',
                'formula' => 'Synthesized Academic Discourse: Background Clause + Present Perfect Clause + Logical Result Clause',
                'rules' => [
                    "Gunakan Present Perfect pasif untuk menyatakan konsensus ilmiah umum ('Although extensive studies have been conducted...').",
                    "Gunakan Present Perfect aktif untuk menonjolkan inovasi peneliti ('...our team has devised a novel architecture').",
                    'Jaga konsistensi tenses saat mengontraskan situasi lampau terputus dengan relevansi kini.',
                    'Pastikan keselarasan gramatikal (Subject-Verb Agreement) terjaga di seluruh klausa kompleks.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Meskipun banyak penelitian telah dilakukan mengenai perubahan iklim, hanya sedikit studi yang telah mengevaluasi dampaknya pada satwa liar pegunungan tinggi.',
                        'target_word' => 'have been conducted ... have evaluated (Dual Present Perfect Synthesis)',
                        'vocab' => [
                            ['en' => 'extensive research', 'id' => 'banyak penelitian'],
                            ['en' => 'evaluated its consequences', 'id' => 'mengevaluasi dampaknya'],
                            ['en' => 'high-altitude wildlife', 'id' => 'satwa liar pegunungan tinggi'],
                        ],
                        'options' => [
                            'Although extensive research has been conducted on climate change, few studies have evaluated its consequences on high-altitude wildlife.',
                            'Although extensive research have been conducted on climate change, few studies has evaluated its consequences on high-altitude wildlife.',
                            'Although extensive research was conducted on climate change, few studies evaluated its consequences on high-altitude wildlife so far.',
                            'Although extensive research has being conducted on climate change, few studies have evaluate its consequences on high-altitude wildlife.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Research' adalah mass noun tunggal ('has been conducted'), sedangkan 'few studies' adalah jamak ('have evaluated'). Keduanya membentuk jembatan celah riset yang sempurna.",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Para insinyur telah berhasil mengembangkan baterai lithium yang lebih efisien, yang telah diuji secara ketat dalam berbagai kondisi suhu.',
                        'target_word' => 'have developed ... has been tested (Active to Passive Relative Clause)',
                        'vocab' => [
                            ['en' => 'efficient lithium battery', 'id' => 'baterai lithium yang efisien'],
                            ['en' => 'rigorously tested', 'id' => 'diuji secara ketat'],
                            ['en' => 'thermal conditions', 'id' => 'kondisi suhu'],
                        ],
                        'options' => [
                            'Engineers have successfully developed an efficient lithium battery, which has been rigorously tested under diverse thermal conditions.',
                            'Engineers has successfully developed an efficient lithium battery, which have been rigorously tested under diverse thermal conditions.',
                            'Engineers have successfully develop an efficient lithium battery, which has being rigorously tested under diverse thermal conditions.',
                            'Engineers have successfully developed an efficient lithium battery, which was tested rigorously under diverse thermal conditions currently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa utama aktif jamak ('Engineers have developed') terhubung ke relative clause pasif tunggal ('which has been tested').",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Karena data awal telah menunjukkan hasil yang menjanjikan, komite etik telah memberikan persetujuan penuh untuk uji klinis skala penuh.',
                        'target_word' => 'have indicated ... has granted (Causal Present Perfect Synthesis)',
                        'vocab' => [
                            ['en' => 'preliminary data', 'id' => 'data awal'],
                            ['en' => 'promising results', 'id' => 'hasil yang menjanjikan'],
                            ['en' => 'ethics committee', 'id' => 'komite etik'],
                            ['en' => 'granted full approval', 'id' => 'memberikan persetujuan penuh'],
                        ],
                        'options' => [
                            'Because preliminary data have indicated promising results, the ethics committee has granted full approval for full-scale clinical trials.',
                            'Because preliminary data has indicated promising results, the ethics committee have granted full approval for full-scale clinical trials.',
                            'Because preliminary data have indicate promising results, the ethics committee has grant full approval for full-scale clinical trials.',
                            'Because preliminary data were indicated promising results, the ethics committee has granted full approval for full-scale clinical trials.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Data' dalam konteks formal diperlakukan sebagai jamak ('have indicated'), sedangkan 'the ethics committee' adalah entitas tunggal ('has granted').",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Sejak protokol baru ini diperkenalkan, tingkat infeksi rumah sakit telah menurun secara dramatis dan kepuasan pasien telah meningkat.',
                        'target_word' => 'has dropped ... has improved (Dual Metric Transition)',
                        'vocab' => [
                            ['en' => 'hospital-acquired infection rate', 'id' => 'tingkat infeksi rumah sakit'],
                            ['en' => 'dropped dramatically', 'id' => 'menurun secara dramatis'],
                            ['en' => 'patient satisfaction', 'id' => 'kepuasan pasien'],
                        ],
                        'options' => [
                            'Since the new protocol was introduced, the hospital-acquired infection rate has dropped dramatically and patient satisfaction has improved.',
                            'Since the new protocol was introduced, the hospital-acquired infection rate dropped dramatically and patient satisfaction improved so far.',
                            'Since the new protocol has been introduced, the hospital-acquired infection rate have dropped dramatically and patient satisfaction have improved.',
                            'Since the new protocol was introduced, the hospital-acquired infection rate has drop dramatically and patient satisfaction has improve.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'since' menggunakan Simple Past untuk momen penetapan ('was introduced'), sedangkan dampak lanjutannya menggunakan Present Perfect tunggal: 'has dropped' dan 'has improved'.",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Meskipun para astronom telah mengamati ribuan eksoplanet, belum ada tanda kehidupan ekstraterestrial yang telah diverifikasi.',
                        'target_word' => 'have observed ... has been verified (Exploratory Academic Synthesis)',
                        'vocab' => [
                            ['en' => 'astronomers', 'id' => 'para astronom'],
                            ['en' => 'exoplanets', 'id' => 'eksoplanet'],
                            ['en' => 'extraterrestrial life', 'id' => 'kehidupan ekstraterestrial'],
                            ['en' => 'verified', 'id' => 'diverifikasi'],
                        ],
                        'options' => [
                            'Although astronomers have observed thousands of exoplanets, no sign of extraterrestrial life has been verified to date.',
                            'Although astronomers has observed thousands of exoplanets, no sign of extraterrestrial life have been verified to date.',
                            'Although astronomers have observed thousands of exoplanets, no sign of extraterrestrial life was verified to date.',
                            'Although astronomers have observed thousands of exoplanets, no sign of extraterrestrial life has being verified to date.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'astronomers have observed' (jamak aktif) dikontraskan dengan 'no sign ... has been verified' (tunggal pasif).",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Banyak kota metropolitan telah menerapkan pajak kemacetan, dan langkah kebijakan ini telah terbukti sangat efektif.',
                        'target_word' => 'have implemented ... has proven (Policy Impact Reporting)',
                        'vocab' => [
                            ['en' => 'metropolitan municipalities', 'id' => 'kota metropolitan'],
                            ['en' => 'congestion pricing', 'id' => 'pajak kemacetan'],
                            ['en' => 'policy measure', 'id' => 'langkah kebijakan'],
                            ['en' => 'proven remarkably effective', 'id' => 'terbukti sangat efektif'],
                        ],
                        'options' => [
                            'Many metropolitan municipalities have implemented congestion pricing, and this policy measure has proven remarkably effective.',
                            'Many metropolitan municipalities has implemented congestion pricing, and this policy measure have proven remarkably effective.',
                            'Many metropolitan municipalities have implement congestion pricing, and this policy measure has prove remarkably effective.',
                            'Many metropolitan municipalities were implemented congestion pricing, and this policy measure has proven remarkably effective.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'municipalities have implemented' (jamak aktif) diikuti klausa 'this policy measure has proven' (tunggal aktif).",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Selama dua dekade terakhir, digitalisasi telah merevolusi sektor perbankan, namun risiko keamanan siber telah menjadi lebih kompleks.',
                        'target_word' => 'has revolutionized ... have become (Trend and New Challenges)',
                        'vocab' => [
                            ['en' => 'digitalization', 'id' => 'digitalisasi'],
                            ['en' => 'revolutionized the banking sector', 'id' => 'merevolusi sektor perbankan'],
                            ['en' => 'cybersecurity risks', 'id' => 'risiko keamanan siber'],
                            ['en' => 'have become increasingly complex', 'id' => 'telah menjadi semakin kompleks'],
                        ],
                        'options' => [
                            'Over the past two decades, digitalization has revolutionized the banking sector, yet cybersecurity risks have become increasingly complex.',
                            'Over the past two decades, digitalization have revolutionized the banking sector, yet cybersecurity risks has become increasingly complex.',
                            'Over the past two decades, digitalization revolutionized the banking sector, yet cybersecurity risks became increasingly complex currently.',
                            'Over the past two decades, digitalization has revolutionize the banking sector, yet cybersecurity risks have become increasingly complex.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'digitalization has revolutionized' (tunggal) dipadukan dengan klausa kontras 'risks have become' (jamak nominal).",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Meskipun vaksin baru telah didistribusikan secara luas, varian mutan patogen telah menimbulkan tantangan kesehatan baru.',
                        'target_word' => 'has been distributed ... have posed (Passive to Active Challenge)',
                        'vocab' => [
                            ['en' => 'novel vaccine', 'id' => 'vaksin baru'],
                            ['en' => 'widely distributed', 'id' => 'didistribusikan secara luas'],
                            ['en' => 'mutant pathogen variants', 'id' => 'varian mutan patogen'],
                            ['en' => 'posed fresh health challenges', 'id' => 'menimbulkan tantangan kesehatan baru'],
                        ],
                        'options' => [
                            'Although the novel vaccine has been distributed widely, mutant pathogen variants have posed fresh public health challenges.',
                            'Although the novel vaccine have been distributed widely, mutant pathogen variants has posed fresh public health challenges.',
                            'Although the novel vaccine has being distributed widely, mutant pathogen variants have pose fresh public health challenges.',
                            'Although the novel vaccine was distributed widely, mutant pathogen variants posed fresh public health challenges so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa konsesi memakai pasif tunggal 'has been distributed', klausa utama memakai aktif jamak 'have posed'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Berbagai inisiatif keberlanjutan telah diluncurkan oleh universitas, dan jejak karbon institusi telah berkurang sebesar dua puluh persen sejauh ini.',
                        'target_word' => 'have been launched ... has decreased (Passive-Active Synthesis)',
                        'vocab' => [
                            ['en' => 'sustainability initiatives', 'id' => 'inisiatif keberlanjutan'],
                            ['en' => 'launched', 'id' => 'diluncurkan'],
                            ['en' => 'institutional carbon footprint', 'id' => 'jejak karbon institusi'],
                            ['en' => 'decreased by twenty percent', 'id' => 'berkurang sebesar dua puluh persen'],
                        ],
                        'options' => [
                            'Various sustainability initiatives have been launched by the university, and the institutional carbon footprint has decreased by twenty percent so far.',
                            'Various sustainability initiatives has been launched by the university, and the institutional carbon footprint have decreased by twenty percent so far.',
                            'Various sustainability initiatives have being launched by the university, and the institutional carbon footprint has decrease by twenty percent so far.',
                            'Various sustainability initiatives were launched by the university, and the institutional carbon footprint decreased by twenty percent so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'initiatives have been launched' (jamak pasif) disambung 'carbon footprint has decreased' (tunggal aktif).",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Tinjauan literatur ini telah menunjukkan bahwa metodologi tradisional belum mampu mengatasi bias pengambilan sampel dalam survei populasi.',
                        'target_word' => 'has demonstrated ... have not been capable of (Literature Review Climax)',
                        'vocab' => [
                            ['en' => 'literature review', 'id' => 'tinjauan literatur'],
                            ['en' => 'demonstrated', 'id' => 'menunjukkan'],
                            ['en' => 'traditional methodologies', 'id' => 'metodologi tradisional'],
                            ['en' => 'sampling bias', 'id' => 'bias pengambilan sampel'],
                        ],
                        'options' => [
                            'This comprehensive literature review has demonstrated that traditional methodologies have not been capable of eliminating sampling bias in population surveys.',
                            'This comprehensive literature review have demonstrated that traditional methodologies has not been capable of eliminating sampling bias in population surveys.',
                            'This comprehensive literature review has demonstrated that traditional methodologies are not been capable of eliminating sampling bias in population surveys.',
                            'This comprehensive literature review demonstrated that traditional methodologies were not capable of eliminating sampling bias in population surveys so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'This review has demonstrated' (tunggal) memuat klausa komplemen 'traditional methodologies have not been' (jamak nominal).",
                    ],
                ]
            ],
        ];
    }
}
