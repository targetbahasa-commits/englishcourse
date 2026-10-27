<?php

namespace App\Services;

class SelfStudySimplePastDataAdvanced
{
    /**
     * Get the complete Simple Past Tense (Verbal, Nominal, Passive) package.
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
            'banner_title' => 'Simple Past Tense (Verbal, Nominal, Passive) in Academic Writing',
            'banner_subtitle' => 'Kuasai seluruh variasi masa lampau: V2 beraturan & tak beraturan (aktif), was/were nominal, pelaporan metodologi eksperimen pasif (was/were + V3), penyangkalan hipotesis (did not + V1), dan penempatan keterangan waktu definitif.',
            'banner_badge' => 'MODULE 1.8 SIMPLE PAST TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.8
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Simple Past Tense: Verbal, Nominal, & Pasif dalam Penulisan Ilmiah',
            'concept_summary' => 'Simple Past Tense adalah instrumen utama dalam penulisan bab Metodologi (Methods), Prosedur Eksperimen, dan Laporan Hasil (Results) naskah akademis. Tense ini digunakan untuk mencatat dan melaporkan peristiwa, observasi, atau tindakan penelitian yang telah selesai sepenuhnya di masa lampau (Completed Past Events). Tiga konstruksi dasarnya harus dikuasai secara presisi: Bentuk Verbal Aktif (S + V2), Bentuk Nominal (S + was/were + Complement), dan Bentuk Pasif Ilmiah (S + was/were + V3).',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Regular vs Irregular (Subject + V2)',
                    'rule_formula' => 'Subject + Verb 2 + Object / Complement',
                    'rule_description' => 'Gunakan V2 beraturan (-ed) atau tidak beraturan untuk tindakan aktif masa lalu. Subjek tunggal dan jamak menggunakan bentuk V2 yang sama. Dilarang menambahkan was/were di depan V2 aktif (SALAH: "The data was showed" ➔ BENAR: "The data showed").',
                    'examples' => [
                        [
                            'en' => 'Researchers observed significant temperature changes during the overnight testing.',
                            'id' => 'Para peneliti mengamati perubahan suhu yang signifikan selama pengujian semalam.',
                            'note' => '"observed" adalah bentuk V2 aktif.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Bentuk Nominal Lampau: was vs were (Subject + was/were + Complement)',
                    'rule_formula' => 'Singular Subject + WAS + Adj/Noun | Plural Subject + WERE + Adj/Noun',
                    'rule_description' => 'Gunakan "was" untuk subjek tunggal (I, he, she, it, the sample) dan "were" untuk subjek jamak (we, they, the samples). Diikuti kata sifat, kata benda, atau frasa preposisi tanpa kata kerja aksi.',
                    'examples' => [
                        [
                            'en' => 'The results of the early-stage trial were highly significant statistically.',
                            'id' => 'Hasil uji klinis tahap awal sangat signifikan secara statistik.',
                            'note' => 'Subjek jamak "results" dipadukan dengan "were significant".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif Ilmiah (Subject + was/were + V3)',
                    'rule_formula' => 'Subject (Patient/Object) + WAS / WERE + Verb 3 (Past Participle)',
                    'rule_description' => 'Gunakan pasif lampau untuk memfokuskan kalimat pada sampel atau prosedur laboratorium daripada pelaku (contoh: "samples were collected", "data was analyzed"). Verba setelah was/were WAJIB berbentuk V3 (Past Participle).',
                    'examples' => [
                        [
                            'en' => 'Groundwater samples were collected from ten different wells across the industrial estate.',
                            'id' => 'Sampel air tanah dikumpulkan dari sepuluh sumur berbeda di kawasan industri.',
                            'note' => '"were collected" (were + V3) memaparkan prosedur pengumpulan sampel.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Bentuk Negatif & Penyangkalan Hipotesis (did not + V1 / was not)',
                    'rule_formula' => 'Verbal: S + DID NOT + V1 (Base Form) | Nominal/Pasif: S + WAS/WERE NOT + Adj/V3',
                    'rule_description' => 'Pada kalimat verbal negatif, verba selalu kembali ke bentuk dasar V1 murni setelah "did not" (did not show, did not dissolve). Jangan pernah menggunakan V2 setelah did not.',
                    'examples' => [
                        [
                            'en' => 'The experimental results did not show any significant correlation between the two variables.',
                            'id' => 'Hasil eksperimen tidak menunjukkan korelasi yang signifikan antara kedua variabel.',
                            'note' => '"did not show" menggunakan V1 "show" setelah "did not".'
                        ]
                    ]
                ]
            ],
            'contrast_table' => [
                'headers' => ['Kategori Kalimat', 'Pola Rumus Baku', 'Kapan Digunakan', 'Contoh Kalimat Akademik'],
                'rows' => [
                    ['Verbal Aktif (Regular)', 'Subject + V2 (-ed)', 'Aksi aktif subjek yang selesai di masa lalu', 'The team conducted three independent trials.'],
                    ['Verbal Aktif (Irregular)', 'Subject + Irregular V2', 'Aksi aktif kata kerja tak beraturan', 'The researchers found unexpected anomalies.'],
                    ['Nominal Lampau (Tunggal)', 'Singular Subject + was + Adj/Noun', 'Kondisi/sifat subjek tunggal masa lalu', 'The volcanic rock sample was extremely brittle.'],
                    ['Nominal Lampau (Jamak)', 'Plural Subject + were + Adj/Noun', 'Kondisi/sifat subjek jamak masa lalu', 'Weather conditions were severe throughout winter.'],
                    ['Pasif Ilmiah (Tunggal)', 'Singular Subject + was + V3', 'Prosedur objek tunggal dikenai tindakan', 'The test solution was heated to 100 degrees.'],
                    ['Pasif Ilmiah (Jamak)', 'Plural Subject + were + V3', 'Prosedur objek jamak dikenai tindakan', 'Groundwater samples were collected from ten wells.'],
                    ['Verbal Negatif', 'Subject + did not + V1', 'Penyangkalan temuan/aksi lampau', 'The results did not show statistical significance.'],
                    ['Nominal/Pasif Negatif', 'Subject + was/were not + Adj/V3', 'Kondisi negatif atau tindakan tidak terjadi', 'The data was not published before peer review.']
                ]
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The preliminary data was showed a positive correlation.',
                    'correct' => 'The preliminary data showed a positive correlation (Active) OR The data was shown to correlate positively (Passive).',
                    'explanation' => 'Jangan menyisipkan "was/were" di depan kata kerja aktif transitif. "The data showed" adalah bentuk aktif yang benar.'
                ],
                [
                    'incorrect' => 'An unexpected error was occurred during the computation.',
                    'correct' => 'An unexpected error occurred during the computation.',
                    'explanation' => 'Kata kerja intransitif seperti "occur", "consist of", "happen" tidak bisa dipasifkan.'
                ],
                [
                    'incorrect' => 'The researchers did not found any significant changes.',
                    'correct' => 'The researchers did not find any significant changes.',
                    'explanation' => 'Setelah "did not", kata kerja WAJIB kembali ke bentuk dasar V1 ("find", bukan "found").'
                ],
                [
                    'incorrect' => 'In 2020, the laboratory has discovered a new enzyme.',
                    'correct' => 'In 2020, the laboratory discovered a new enzyme.',
                    'explanation' => 'Keterangan waktu lampau spesifik ("In 2020") mewajibkan Simple Past V2, bukan Present Perfect.'
                ]
            ],
            'exam_tips' => [
                'Gunakan Simple Past Pasif (was/were + V3) untuk mendominasi penulisan bab Metodologi agar tulisan Anda memiliki nada objektif impersonal standar jurnal internasional.',
                'Gunakan Simple Past Aktif (V2) saat menekankan temuan utama peneliti ("We found that...", "Smith et al. investigated...").',
                'Selalu periksa verba setelah "did not": pastikan tidak ada akhiran -ed atau bentuk tidak beraturan V2.'
            ]
        ];
    }

    /**
     * Complete list of 8 sub-lessons for Topic 1.8
     */
    public static function getSubLessons(): array
    {
        return [
            [
                'id' => 'past_verbal_regular',
                'name' => 'Simple Past Verbal: Regular Verbs (Subject + V2 -ed)',
                'code' => '1.8.1',
                'concept_title' => 'Simple Past Verbal: Regular Verbs (Subject + V2 -ed)',
                'concept_description' => 'Simple Past Tense bentuk verbal aktif digunakan untuk melaporkan tindakan, prosedur eksperimen, atau peristiwa yang telah selesai sepenuhnya di masa lampau (Past Completed Action). Pada kata kerja beraturan (Regular Verbs), bentuk lampau dibentuk dengan menambahkan akhiran \'-ed\' atau \'-d\' pada bentuk dasar kata kerja (V1).',
                'formula' => 'Subject + Verb 2 (-ed) + Object / Complement + (Past Time Marker)',
                'rules' => [
                    'Bentuk V2 beraturan dibentuk dengan menambahkan \'-ed\' pada kata kerja dasar (investigate -> investigated, conduct -> conducted).',
                    'Jika kata kerja berakhir dengan huruf \'e\', cukup tambahkan \'-d\' (analyze -> analyzed, observe -> observed).',
                    'Jika berakhiran konsonan + \'y\', ubah \'y\' menjadi \'i\' lalu tambahkan \'-ed\' (identify -> identified, verify -> verified).',
                    'Subject-Verb Agreement pada Simple Past verbal tidak membedakan subjek tunggal dan jamak; semua subjek menggunakan bentuk V2 yang sama.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Para peneliti mengamati perubahan suhu yang signifikan selama pengujian semalam.',
                        'target_word' => 'observed',
                        'vocab' => [
                            'researchers' => [
                                'id' => 'para peneliti',
                                'pos' => '(n pl)',
                            ],
                            'observed' => [
                                'id' => 'mengamati',
                                'pos' => '(v2)',
                            ],
                            'significant temperature changes' => [
                                'id' => 'perubahan suhu yang signifikan',
                                'pos' => '(n phr)',
                            ],
                            'overnight testing' => [
                                'id' => 'pengujian semalam',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The researchers observed significant temperature changes during the overnight testing.',
                            'The researchers observe significant temperature changes during the overnight testing.',
                            'The researchers observes significant temperature changes during the overnight testing.',
                            'The researchers observing significant temperature changes during the overnight testing.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Tindakan lampau yang telah selesai dilaporkan dengan bentuk V2 beraturan \'observed\'. Pilihan \'observe\' (V1) atau \'observes\' salah tenses.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Tim laboratorium melakukan serangkaian eksperimen kimia untuk memverifikasi hipotesis awal.',
                        'target_word' => 'conducted',
                        'vocab' => [
                            'laboratory team' => [
                                'id' => 'tim laboratorium',
                                'pos' => '(n phr)',
                            ],
                            'conducted' => [
                                'id' => 'melakukan / melaksanakan',
                                'pos' => '(v2)',
                            ],
                            'series of chemical experiments' => [
                                'id' => 'serangkaian eksperimen kimia',
                                'pos' => '(n phr)',
                            ],
                            'verify initial hypothesis' => [
                                'id' => 'memverifikasi hipotesis awal',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'The laboratory team conducted a series of chemical experiments to verify the initial hypothesis.',
                            'The laboratory team conduct a series of chemical experiments to verify the initial hypothesis.',
                            'The laboratory team conducts a series of chemical experiments to verify the initial hypothesis.',
                            'The laboratory team was conducted a series of chemical experiments to verify the initial hypothesis.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk aktif lampau menggunakan V2 \'conducted\'. Bentuk \'was conducted\' salah karena itu adalah pasif (\'dilakukan\'), sedangkan subjeknya adalah pelaku aktif (\'tim\').',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Ahli statistik menganalisis data survei dengan menggunakan model regresi linier berganda.',
                        'target_word' => 'analyzed',
                        'vocab' => [
                            'statistician' => [
                                'id' => 'ahli statistik',
                                'pos' => '(n)',
                            ],
                            'analyzed' => [
                                'id' => 'menganalisis',
                                'pos' => '(v2)',
                            ],
                            'survey data' => [
                                'id' => 'data survei',
                                'pos' => '(n phr)',
                            ],
                            'multiple linear regression model' => [
                                'id' => 'model regresi linier berganda',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The statistician analyzed the survey data using a multiple linear regression model.',
                            'The statistician analyze the survey data using a multiple linear regression model.',
                            'The statistician analyzes the survey data using a multiple linear regression model.',
                            'The statistician is analyzed the survey data using a multiple linear regression model.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'analyzed\' adalah bentuk V2 lampau aktif dari kata kerja \'analyze\'.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Pemerintah daerah mengumumkan kebijakan pembatasan lalu lintas pada bulan lalu.',
                        'target_word' => 'announced',
                        'vocab' => [
                            'local government' => [
                                'id' => 'pemerintah daerah',
                                'pos' => '(n phr)',
                            ],
                            'announced' => [
                                'id' => 'mengumumkan',
                                'pos' => '(v2)',
                            ],
                            'traffic restriction policy' => [
                                'id' => 'kebijakan pembatasan lalu lintas',
                                'pos' => '(n phr)',
                            ],
                            'last month' => [
                                'id' => 'bulan lalu',
                                'pos' => '(time adv)',
                            ],
                        ],
                        'options' => [
                            'The local government announced the traffic restriction policy last month.',
                            'The local government announces the traffic restriction policy last month.',
                            'The local government announce the traffic restriction policy last month.',
                            'The local government was announce the traffic restriction policy last month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu lampau \'last month\' mewajibkan penggunaan V2 \'announced\'.',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Para insinyur merancang prototipe sensor baru untuk mendeteksi kebocoran gas metana.',
                        'target_word' => 'designed',
                        'vocab' => [
                            'engineers' => [
                                'id' => 'para insinyur',
                                'pos' => '(n pl)',
                            ],
                            'designed' => [
                                'id' => 'merancang',
                                'pos' => '(v2)',
                            ],
                            'new sensor prototype' => [
                                'id' => 'prototipe sensor baru',
                                'pos' => '(n phr)',
                            ],
                            'detect methane leaks' => [
                                'id' => 'mendeteksi kebocoran gas metana',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'The engineers designed a new sensor prototype to detect methane gas leaks.',
                            'The engineers design a new sensor prototype to detect methane gas leaks.',
                            'The engineers designs a new sensor prototype to detect methane gas leaks.',
                            'The engineers were designed a new sensor prototype to detect methane gas leaks.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'designed\' adalah bentuk V2 regular untuk subjek aktif \'The engineers\'.',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Partisipan menyelesaikan kuesioner psikologis dalam waktu kurang dari tiga puluh menit.',
                        'target_word' => 'completed',
                        'vocab' => [
                            'participants' => [
                                'id' => 'partisipan',
                                'pos' => '(n pl)',
                            ],
                            'completed' => [
                                'id' => 'menyelesaikan',
                                'pos' => '(v2)',
                            ],
                            'psychological questionnaire' => [
                                'id' => 'kuesioner psikologis',
                                'pos' => '(n phr)',
                            ],
                            'less than thirty minutes' => [
                                'id' => 'kurang dari tiga puluh menit',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'Participants completed the psychological questionnaire in less than thirty minutes.',
                            'Participants complete the psychological questionnaire in less than thirty minutes.',
                            'Participants completes the psychological questionnaire in less than thirty minutes.',
                            'Participants was completed the psychological questionnaire in less than thirty minutes.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'completed\' (V2) menyatakan tindakan lampau yang telah tuntas.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Laporan medis tersebut mengonfirmasi keberadaan antibodi penetral dalam sampel darah donor.',
                        'target_word' => 'confirmed',
                        'vocab' => [
                            'medical report' => [
                                'id' => 'laporan medis',
                                'pos' => '(n phr)',
                            ],
                            'confirmed' => [
                                'id' => 'mengonfirmasi',
                                'pos' => '(v2)',
                            ],
                            'presence of neutralizing antibodies' => [
                                'id' => 'keberadaan antibodi penetral',
                                'pos' => '(n phr)',
                            ],
                            'donor blood samples' => [
                                'id' => 'sampel darah donor',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The medical report confirmed the presence of neutralizing antibodies in donor blood samples.',
                            'The medical report confirms the presence of neutralizing antibodies in donor blood samples.',
                            'The medical report confirm the presence of neutralizing antibodies in donor blood samples.',
                            'The medical report was confirmed the presence of neutralizing antibodies in donor blood samples.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Laporan eksperimen historis menggunakan V2 aktif \'confirmed\'.',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Dewan juri mengevaluasi proposal penelitian berdasarkan kriteria orisinalitas dan metodologi.',
                        'target_word' => 'evaluated',
                        'vocab' => [
                            'panel of judges' => [
                                'id' => 'dewan juri / panel penilai',
                                'pos' => '(n phr)',
                            ],
                            'evaluated' => [
                                'id' => 'mengevaluasi',
                                'pos' => '(v2)',
                            ],
                            'research proposals' => [
                                'id' => 'proposal penelitian',
                                'pos' => '(n phr)',
                            ],
                            'originality criteria' => [
                                'id' => 'kriteria orisinalitas',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The panel of judges evaluated the research proposals based on criteria of originality and methodology.',
                            'The panel of judges evaluate the research proposals based on criteria of originality and methodology.',
                            'The panel of judges evaluates the research proposals based on criteria of originality and methodology.',
                            'The panel of judges were evaluated the research proposals based on criteria of originality and methodology.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'evaluated\' adalah bentuk lampau V2 beraturan.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Perusahaan farmasi tersebut menghentikan uji klinis tahap awal karena masalah keamanan.',
                        'target_word' => 'halted',
                        'vocab' => [
                            'pharmaceutical company' => [
                                'id' => 'perusahaan farmasi',
                                'pos' => '(n phr)',
                            ],
                            'halted' => [
                                'id' => 'menghentikan',
                                'pos' => '(v2)',
                            ],
                            'early-stage clinical trials' => [
                                'id' => 'uji klinis tahap awal',
                                'pos' => '(n phr)',
                            ],
                            'safety concerns' => [
                                'id' => 'masalah keamanan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The pharmaceutical company halted early-stage clinical trials due to safety concerns.',
                            'The pharmaceutical company halt early-stage clinical trials due to safety concerns.',
                            'The pharmaceutical company halts early-stage clinical trials due to safety concerns.',
                            'The pharmaceutical company was halted early-stage clinical trials due to safety concerns.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'halted\' (V2 dari \'halt\') menyatakan tindakan penghentian yang dilakukan perusahaan di masa lampau.',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Penelitian sebelumnya membuktikan korelasi positif antara aktivitas fisik dan kesehatan kognitif.',
                        'target_word' => 'proved',
                        'vocab' => [
                            'previous study' => [
                                'id' => 'penelitian sebelumnya',
                                'pos' => '(n phr)',
                            ],
                            'proved' => [
                                'id' => 'membuktikan',
                                'pos' => '(v2)',
                            ],
                            'positive correlation' => [
                                'id' => 'korelasi positif',
                                'pos' => '(n phr)',
                            ],
                            'cognitive health' => [
                                'id' => 'kesehatan kognitif',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The previous study proved a positive correlation between physical activity and cognitive health.',
                            'The previous study proves a positive correlation between physical activity and cognitive health.',
                            'The previous study prove a positive correlation between physical activity and cognitive health.',
                            'The previous study was proved a positive correlation between physical activity and cognitive health.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The previous study\' (studi terdahulu) mewajibkan V2 lampau \'proved\' untuk melaporkan temuan studi tersebut.',
                    ],
                ],
            ],
            [
                'id' => 'past_verbal_irregular',
                'name' => 'Simple Past Verbal: Irregular Verbs (Subject + Irregular V2)',
                'code' => '1.8.2',
                'concept_title' => 'Simple Past Verbal: Irregular Verbs (Subject + Irregular V2)',
                'concept_description' => 'Kata kerja tak beraturan (Irregular Verbs) tidak menggunakan akhiran \'-ed\' untuk membentuk masa lampau (V2), melainkan mengalami perubahan ejaan internal (misal: find -> found, grow -> grew, take -> took, lead -> led, rise -> rose). Penguasaan bentuk V2 tak beraturan ini mutlak diperlukan dalam penulisan akademis.',
                'formula' => 'Subject + Irregular V2 + Object / Prepositional Phrase + (Time Marker)',
                'rules' => [
                    'Bentuk V2 tak beraturan harus dihafalkan karena memiliki perubahan unik (find -> found, undergo -> underwent, arise -> arose).',
                    'Dilarang menambahkan \'-ed\' pada kata kerja tidak beraturan (misal: \'finded\' ➔ SALAH; \'found\' ➔ BENAR; \'growed\' ➔ SALAH; \'grew\' ➔ BENAR).',
                    'Subjek tunggal maupun jamak menggunakan bentuk V2 yang sama persis.',
                    'Dalam kalimat negatif, verba kembali ke bentuk dasar V1 setelah kata kerja bantu \'did not\'.',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Peneliti menemukan bukti fosil baru di lapisan sedimen kapur wilayah pesisir.',
                        'target_word' => 'found',
                        'vocab' => [
                            'researchers' => [
                                'id' => 'para peneliti',
                                'pos' => '(n pl)',
                            ],
                            'found' => [
                                'id' => 'menemukan',
                                'pos' => '(v2 irregular)',
                            ],
                            'new fossil evidence' => [
                                'id' => 'bukti fosil baru',
                                'pos' => '(n phr)',
                            ],
                            'limestone sediment layers' => [
                                'id' => 'lapisan sedimen kapur',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Researchers found new fossil evidence in coastal limestone sediment layers.',
                            'Researchers finded new fossil evidence in coastal limestone sediment layers.',
                            'Researchers find new fossil evidence in coastal limestone sediment layers.',
                            'Researchers was found new fossil evidence in coastal limestone sediment layers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'find\' adalah \'found\', bukan \'finded\'.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Kultur bakteri tersebut tumbuh dengan pesat di dalam cawan petri bernutrisi tinggi.',
                        'target_word' => 'grew',
                        'vocab' => [
                            'bacterial culture' => [
                                'id' => 'kultur bakteri',
                                'pos' => '(n phr)',
                            ],
                            'grew rapidly' => [
                                'id' => 'tumbuh dengan pesat',
                                'pos' => '(v phr)',
                            ],
                            'nutrient-rich petri dish' => [
                                'id' => 'cawan petri bernutrisi tinggi',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The bacterial culture grew rapidly in the nutrient-rich petri dish.',
                            'The bacterial culture growed rapidly in the nutrient-rich petri dish.',
                            'The bacterial culture grow rapidly in the nutrient-rich petri dish.',
                            'The bacterial culture was grew rapidly in the nutrient-rich petri dish.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'grow\' adalah \'grew\', bukan \'growed\'.',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Proses sintesis kimia tersebut memakan waktu empat jam hingga mencapai kesetimbangan.',
                        'target_word' => 'took',
                        'vocab' => [
                            'chemical synthesis process' => [
                                'id' => 'proses sintesis kimia',
                                'pos' => '(n phr)',
                            ],
                            'took four hours' => [
                                'id' => 'memakan waktu empat jam',
                                'pos' => '(v phr)',
                            ],
                            'reach equilibrium' => [
                                'id' => 'mencapai kesetimbangan',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'The chemical synthesis process took four hours to reach equilibrium.',
                            'The chemical synthesis process taked four hours to reach equilibrium.',
                            'The chemical synthesis process take four hours to reach equilibrium.',
                            'The chemical synthesis process was took four hours to reach equilibrium.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'take\' adalah \'took\'.',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Spesimen logam mengalami deformasi struktural di bawah tekanan hidrolik ekstrem.',
                        'target_word' => 'underwent',
                        'vocab' => [
                            'metallic specimen' => [
                                'id' => 'spesimen logam',
                                'pos' => '(n phr)',
                            ],
                            'underwent' => [
                                'id' => 'mengalami',
                                'pos' => '(v2 irregular)',
                            ],
                            'structural deformation' => [
                                'id' => 'deformasi struktural',
                                'pos' => '(n phr)',
                            ],
                            'extreme hydraulic pressure' => [
                                'id' => 'tekanan hidrolik ekstrem',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The metallic specimen underwent structural deformation under extreme hydraulic pressure.',
                            'The metallic specimen undergoed structural deformation under extreme hydraulic pressure.',
                            'The metallic specimen undergo structural deformation under extreme hydraulic pressure.',
                            'The metallic specimen was underwent structural deformation under extreme hydraulic pressure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'undergo\' adalah \'underwent\'.',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Suhu larutan uji naik secara tiba-tiba setelah penambahan katalis asam.',
                        'target_word' => 'rose',
                        'vocab' => [
                            'test solution temperature' => [
                                'id' => 'suhu larutan uji',
                                'pos' => '(n phr)',
                            ],
                            'rose abruptly' => [
                                'id' => 'naik secara tiba-tiba',
                                'pos' => '(v phr)',
                            ],
                            'addition of acid catalyst' => [
                                'id' => 'penambahan katalis asam',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The test solution temperature rose abruptly following the addition of the acid catalyst.',
                            'The test solution temperature rised abruptly following the addition of the acid catalyst.',
                            'The test solution temperature rise abruptly following the addition of the acid catalyst.',
                            'The test solution temperature was rose abruptly following the addition of the acid catalyst.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'rise\' (naik) adalah \'rose\', bukan \'rised\'.',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Senyawa baru tersebut menjadi tidak stabil ketika terpapar sinar matahari langsung.',
                        'target_word' => 'became',
                        'vocab' => [
                            'novel compound' => [
                                'id' => 'senyawa baru',
                                'pos' => '(n phr)',
                            ],
                            'became unstable' => [
                                'id' => 'menjadi tidak stabil',
                                'pos' => '(v phr)',
                            ],
                            'exposed to direct sunlight' => [
                                'id' => 'terpapar sinar matahari langsung',
                                'pos' => '(part phr)',
                            ],
                        ],
                        'options' => [
                            'The novel compound became unstable when exposed to direct sunlight.',
                            'The novel compound becomed unstable when exposed to direct sunlight.',
                            'The novel compound become unstable when exposed to direct sunlight.',
                            'The novel compound was became unstable when exposed to direct sunlight.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'become\' adalah \'became\'.',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Analisis awal menunjukkan adanya anomali pada spektrum gelombang elektromagnetik.',
                        'target_word' => 'showed',
                        'vocab' => [
                            'initial analysis' => [
                                'id' => 'analisis awal',
                                'pos' => '(n phr)',
                            ],
                            'showed' => [
                                'id' => 'menunjukkan',
                                'pos' => '(v2)',
                            ],
                            'anomalies' => [
                                'id' => 'anomali',
                                'pos' => '(n pl)',
                            ],
                            'electromagnetic wave spectrum' => [
                                'id' => 'spektrum gelombang elektromagnetik',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The initial analysis showed anomalies in the electromagnetic wave spectrum.',
                            'The initial analysis was showed anomalies in the electromagnetic wave spectrum.',
                            'The initial analysis shown anomalies in the electromagnetic wave spectrum.',
                            'The initial analysis shows anomalies in the electromagnetic wave spectrum.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'showed\' adalah V2 aktif. Hindari kesalahan lazim \'was showed\'.',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Eksperimen kedua dimulai tepat pada pukul delapan pagi di ruang terkondisi.',
                        'target_word' => 'began',
                        'vocab' => [
                            'second experiment' => [
                                'id' => 'eksperimen kedua',
                                'pos' => '(n phr)',
                            ],
                            'began' => [
                                'id' => 'dimulai',
                                'pos' => '(v2 irregular)',
                            ],
                            'at eight o\'clock in the morning' => [
                                'id' => 'pada pukul delapan pagi',
                                'pos' => '(time phr)',
                            ],
                            'climate-controlled chamber' => [
                                'id' => 'ruang terkondisi',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The second experiment began promptly at eight o\'clock in the climate-controlled chamber.',
                            'The second experiment begined promptly at eight o\'clock in the climate-controlled chamber.',
                            'The second experiment begun promptly at eight o\'clock in the climate-controlled chamber.',
                            'The second experiment was began promptly at eight o\'clock in the climate-controlled chamber.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'begin\' adalah \'began\'. (\'begun\' adalah V3).',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Kekurangan data empiris menyebabkan penundaan publikasi manuskrip ilmiah.',
                        'target_word' => 'led to',
                        'vocab' => [
                            'lack of empirical data' => [
                                'id' => 'kekurangan data empiris',
                                'pos' => '(n phr)',
                            ],
                            'led to' => [
                                'id' => 'menyebabkan / berujung pada',
                                'pos' => '(v phr)',
                            ],
                            'delay in manuscript publication' => [
                                'id' => 'penundaan publikasi manuskrip',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'A lack of empirical data led to a delay in the manuscript\'s publication.',
                            'A lack of empirical data leaded to a delay in the manuscript\'s publication.',
                            'A lack of empirical data lead to a delay in the manuscript\'s publication.',
                            'A lack of empirical data was led to a delay in the manuscript\'s publication.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'lead to\' adalah \'led to\'.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Panitia seleksi memilih tiga puluh kandidat terbaik untuk tahap wawancara lanjutan.',
                        'target_word' => 'chose',
                        'vocab' => [
                            'selection committee' => [
                                'id' => 'panitia seleksi',
                                'pos' => '(n phr)',
                            ],
                            'chose' => [
                                'id' => 'memilih',
                                'pos' => '(v2 irregular)',
                            ],
                            'top thirty candidates' => [
                                'id' => 'tiga puluh kandidat terbaik',
                                'pos' => '(n phr)',
                            ],
                            'advanced interview round' => [
                                'id' => 'tahap wawancara lanjutan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The selection committee chose the top thirty candidates for the advanced interview round.',
                            'The selection committee choosed the top thirty candidates for the advanced interview round.',
                            'The selection committee choose the top thirty candidates for the advanced interview round.',
                            'The selection committee was chose the top thirty candidates for the advanced interview round.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'choose\' adalah \'chose\', bukan \'choosed\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_nominal',
                'name' => 'Simple Past Nominal: Singular & Plural (was / were + Complement)',
                'code' => '1.8.3',
                'concept_title' => 'Simple Past Nominal: Singular & Plural (was / were + Complement)',
                'concept_description' => 'Kalimat Nominal lampau digunakan ketika predikat kalimat menerangkan kondisi, sifat (Adjective), identitas (Noun), atau lokasi/keberadaan (Prepositional Phrase) subjek di masa lalu, tanpa kata kerja aksi utama. Kata kerja bantunya adalah \'WAS\' (untuk subjek I, He, She, It, dan kata benda tunggal) dan \'WERE\' (untuk You, We, They, dan kata benda jamak).',
                'formula' => 'Subject (Singular) + WAS + Complement | Subject (Plural) + WERE + Complement',
                'rules' => [
                    'Gunakan \'was\' untuk subjek tunggal: I, He, She, It, the sample, the result, water.',
                    'Gunakan \'were\' untuk subjek jamak: We, They, the samples, the results, scientists.',
                    'Komplemen dapat berupa: Kata Sifat (was significant), Kata Benda (was a breakthrough), atau Frasa Preposisi (were in the laboratory).',
                    'Dilarang meletakkan kata kerja V1 setelah was/were dalam kalimat nominal (misal: \'The test was succeed\' ➔ SALAH; \'The test was successful\' ➔ BENAR).',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Hasil uji klinis tahap awal sangat signifikan secara statistik.',
                        'target_word' => 'were highly significant',
                        'vocab' => [
                            'results of the early-stage trial' => [
                                'id' => 'hasil uji klinis tahap awal',
                                'pos' => '(n pl)',
                            ],
                            'were highly significant' => [
                                'id' => 'sangat signifikan',
                                'pos' => '(phr)',
                            ],
                            'statistically' => [
                                'id' => 'secara statistik',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'The results of the early-stage trial were highly significant statistically.',
                            'The results of the early-stage trial was highly significant statistically.',
                            'The results of the early-stage trial are highly significant statistically.',
                            'The results of the early-stage trial were highly significance statistically.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek adalah jamak (\'The results\'), sehingga kata kerja bantu lampau yang wajib digunakan adalah \'were\'. Diikuti kata sifat \'significant\'.',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sampel batuan vulkanik tersebut sangat rapuh selama proses pengeboran inti.',
                        'target_word' => 'was extremely brittle',
                        'vocab' => [
                            'volcanic rock sample' => [
                                'id' => 'sampel batuan vulkanik',
                                'pos' => '(n sg)',
                            ],
                            'was extremely brittle' => [
                                'id' => 'sangat rapuh',
                                'pos' => '(phr)',
                            ],
                            'core drilling process' => [
                                'id' => 'proses pengeboran inti',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The volcanic rock sample was extremely brittle during the core drilling process.',
                            'The volcanic rock sample were extremely brittle during the core drilling process.',
                            'The volcanic rock sample was extremely brittleness during the core drilling process.',
                            'The volcanic rock sample did extremely brittle during the core drilling process.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The volcanic rock sample\' menggunakan \'was\' + adjective \'brittle\'.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Data historis tidak tersedia pada saat investigasi awal dilakukan.',
                        'target_word' => 'was unavailable',
                        'vocab' => [
                            'historical data' => [
                                'id' => 'data historis',
                                'pos' => '(n)',
                            ],
                            'was unavailable' => [
                                'id' => 'tidak tersedia',
                                'pos' => '(phr)',
                            ],
                            'initial investigation' => [
                                'id' => 'investigasi awal',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Historical data was unavailable at the time of the initial investigation.',
                            'Historical data were unavailable at the time of the initial investigation.',
                            'Historical data did unavailable at the time of the initial investigation.',
                            'Historical data was not availability at the time of the initial investigation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dalam konteks ini \'data\' diperlakukan sebagai entitas massa singular: \'was unavailable\' (adjective).',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Para partisipan berada di ruang isolasi selama dua puluh empat jam penuh.',
                        'target_word' => 'were in isolation',
                        'vocab' => [
                            'participants' => [
                                'id' => 'para partisipan',
                                'pos' => '(n pl)',
                            ],
                            'were in isolation' => [
                                'id' => 'berada di ruang isolasi',
                                'pos' => '(phr)',
                            ],
                            'for twenty-four hours' => [
                                'id' => 'selama 24 jam',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The participants were in isolation for twenty-four full hours.',
                            'The participants was in isolation for twenty-four full hours.',
                            'The participants did in isolation for twenty-four full hours.',
                            'The participants were isolatedly for twenty-four full hours.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'The participants\' menggunakan \'were\' + frasa preposisi \'in isolation\'.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Penemuan antibiotik baru tersebut merupakan terobosan medis terbesar pada masanya.',
                        'target_word' => 'was a major medical breakthrough',
                        'vocab' => [
                            'discovery of the novel antibiotic' => [
                                'id' => 'penemuan antibiotik baru',
                                'pos' => '(n sg)',
                            ],
                            'was a major breakthrough' => [
                                'id' => 'merupakan terobosan besar',
                                'pos' => '(phr)',
                            ],
                            'of its era' => [
                                'id' => 'pada masanya',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The discovery of the novel antibiotic was a major medical breakthrough of its era.',
                            'The discovery of the novel antibiotic were a major medical breakthrough of its era.',
                            'The discovery of the novel antibiotic did a major medical breakthrough of its era.',
                            'The discovery of the novel antibiotic was breakthroughly of its era.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The discovery\' menggunakan \'was\' + frasa nomina komplemen \'a major medical breakthrough\'.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Kondisi cuaca di lokasi stasiun pemantau sangat buruk sepanjang musim dingin lalu.',
                        'target_word' => 'were severe',
                        'vocab' => [
                            'weather conditions' => [
                                'id' => 'kondisi cuaca',
                                'pos' => '(n pl)',
                            ],
                            'monitoring station' => [
                                'id' => 'stasiun pemantau',
                                'pos' => '(n phr)',
                            ],
                            'were severe' => [
                                'id' => 'sangat buruk / parah',
                                'pos' => '(phr)',
                            ],
                            'last winter' => [
                                'id' => 'musim dingin lalu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'Weather conditions at the monitoring station site were severe throughout last winter.',
                            'Weather conditions at the monitoring station site was severe throughout last winter.',
                            'Weather conditions at the monitoring station site did severe throughout last winter.',
                            'Weather conditions at the monitoring station site were severely throughout last winter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun \'conditions\' jamak, sehingga memerlukan kata kerja bantu \'were\' + adjective \'severe\'.',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Tekanan uap di dalam tabung reaksi sangat tinggi sebelum katup pengaman terbuka.',
                        'target_word' => 'was extremely high',
                        'vocab' => [
                            'vapor pressure' => [
                                'id' => 'tekanan uap',
                                'pos' => '(n sg)',
                            ],
                            'inside the reaction tube' => [
                                'id' => 'di dalam tabung reaksi',
                                'pos' => '(prep phr)',
                            ],
                            'was extremely high' => [
                                'id' => 'sangat tinggi',
                                'pos' => '(phr)',
                            ],
                            'safety valve opened' => [
                                'id' => 'katup pengaman terbuka',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Vapor pressure inside the reaction tube was extremely high before the safety valve opened.',
                            'Vapor pressure inside the reaction tube were extremely high before the safety valve opened.',
                            'Vapor pressure inside the reaction tube did extremely high before the safety valve opened.',
                            'Vapor pressure inside the reaction tube was extremely height before the safety valve opened.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tak terhitung \'Vapor pressure\' menggunakan \'was\' + adjective \'high\'.',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Semua dokumen arsip rahasia berada dalam keadaan aman di lemari besi laboratorium.',
                        'target_word' => 'were secure',
                        'vocab' => [
                            'confidential archive documents' => [
                                'id' => 'dokumen arsip rahasia',
                                'pos' => '(n pl)',
                            ],
                            'were secure' => [
                                'id' => 'berada dalam keadaan aman',
                                'pos' => '(phr)',
                            ],
                            'laboratory vault' => [
                                'id' => 'lemari besi laboratorium',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'All confidential archive documents were secure inside the laboratory vault.',
                            'All confidential archive documents was secure inside the laboratory vault.',
                            'All confidential archive documents did secure inside the laboratory vault.',
                            'All confidential archive documents were securely inside the laboratory vault.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'documents\' menggunakan \'were\' + kata sifat \'secure\'.',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Larutan kimia tersebut transparan dan tidak berbau sebelum reaksi reduksi dimulai.',
                        'target_word' => 'was transparent and odorless',
                        'vocab' => [
                            'chemical solution' => [
                                'id' => 'larutan kimia',
                                'pos' => '(n sg)',
                            ],
                            'was transparent and odorless' => [
                                'id' => 'transparan dan tidak berbau',
                                'pos' => '(phr)',
                            ],
                            'reduction reaction began' => [
                                'id' => 'reaksi reduksi dimulai',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'The chemical solution was transparent and odorless before the reduction reaction began.',
                            'The chemical solution were transparent and odorless before the reduction reaction began.',
                            'The chemical solution did transparent and odorless before the reduction reaction began.',
                            'The chemical solution was transparently and odorless before the reduction reaction began.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The chemical solution\' (tunggal) menggunakan \'was\' + pasangan kata sifat.',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Biaya lisensi perangkat lunak pemodelan molekuler sangat mahal pada dekade sebelumnya.',
                        'target_word' => 'was prohibitive',
                        'vocab' => [
                            'licensing cost' => [
                                'id' => 'biaya lisensi',
                                'pos' => '(n sg)',
                            ],
                            'molecular modeling software' => [
                                'id' => 'perangkat lunak pemodelan molekuler',
                                'pos' => '(n phr)',
                            ],
                            'was prohibitive' => [
                                'id' => 'sangat mahal / memberatkan',
                                'pos' => '(phr)',
                            ],
                            'previous decade' => [
                                'id' => 'dekade sebelumnya',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The licensing cost of molecular modeling software was prohibitive in the previous decade.',
                            'The licensing cost of molecular modeling software were prohibitive in the previous decade.',
                            'The licensing cost of molecular modeling software did prohibitive in the previous decade.',
                            'The licensing cost of molecular modeling software was prohibitively in the previous decade.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The licensing cost\' tunggal, menggunakan \'was\' + adjective \'prohibitive\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_passive',
                'name' => 'Simple Past Passive: Scientific Reporting (was / were + V3)',
                'code' => '1.8.4',
                'concept_title' => 'Simple Past Passive: Scientific Reporting (was / were + V3)',
                'concept_description' => 'Kalimat pasif lampau (Simple Past Passive) merupakan struktur sintaksis paling dominan dalam penulisan bab Metodologi (Methods) dan Prosedur Eksperimen naskah akademik. Kalimat pasif memfokuskan perhatian pembaca pada objek eksperimen, zat uji, atau temuan penelitian daripada peneliti itu sendiri, menciptakan nada impersonal yang objektif.',
                'formula' => 'Subject (Patient/Object) + WAS / WERE + Verb 3 (Past Participle) + (by Agent) + (Context)',
                'rules' => [
                    'Gunakan \'was + V3\' jika subjek penerima tindakan adalah tunggal (the specimen was collected, the solution was heated).',
                    'Gunakan \'were + V3\' jika subjek penerima tindakan adalah jamak (the samples were gathered, participants were divided).',
                    'Verba setelah was/were WAJIB berbentuk Past Participle (V3), bukan V1 atau V2 murni.',
                    'Frasa pelaku (\'by the researchers\') sering kali dihilangkan untuk menjaga nada pelaporan yang ringkas dan impersonal.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Sampel air tanah dikumpulkan dari sepuluh sumur berbeda di kawasan industri.',
                        'target_word' => 'were collected',
                        'vocab' => [
                            'groundwater samples' => [
                                'id' => 'sampel air tanah',
                                'pos' => '(n pl)',
                            ],
                            'were collected' => [
                                'id' => 'dikumpulkan',
                                'pos' => '(v passive)',
                            ],
                            'from ten different wells' => [
                                'id' => 'dari sepuluh sumur berbeda',
                                'pos' => '(prep phr)',
                            ],
                            'industrial estate' => [
                                'id' => 'kawasan industri',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Groundwater samples were collected from ten different wells across the industrial estate.',
                            'Groundwater samples was collected from ten different wells across the industrial estate.',
                            'Groundwater samples collected from ten different wells across the industrial estate.',
                            'Groundwater samples were collect from ten different wells across the industrial estate.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'samples\' dipadukan dengan pasif lampau: \'were collected\' (were + V3).',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Larutan uji dipanaskan pada suhu seratus derajat Celcius selama tiga puluh menit.',
                        'target_word' => 'was heated',
                        'vocab' => [
                            'test solution' => [
                                'id' => 'larutan uji',
                                'pos' => '(n sg)',
                            ],
                            'was heated' => [
                                'id' => 'dipanaskan',
                                'pos' => '(v passive)',
                            ],
                            'at one hundred degrees Celsius' => [
                                'id' => 'pada suhu 100 derajat Celcius',
                                'pos' => '(prep phr)',
                            ],
                            'for thirty minutes' => [
                                'id' => 'selama tiga puluh menit',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The test solution was heated to one hundred degrees Celsius for thirty minutes.',
                            'The test solution were heated to one hundred degrees Celsius for thirty minutes.',
                            'The test solution heated to one hundred degrees Celsius for thirty minutes.',
                            'The test solution was heat to one hundred degrees Celsius for thirty minutes.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The test solution\' menggunakan \'was heated\' (was + V3).',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Para partisipan dibagi secara acak ke dalam kelompok eksperimen dan kelompok kontrol.',
                        'target_word' => 'were randomly assigned',
                        'vocab' => [
                            'participants' => [
                                'id' => 'para partisipan',
                                'pos' => '(n pl)',
                            ],
                            'were randomly assigned' => [
                                'id' => 'dibagi / dialokasikan secara acak',
                                'pos' => '(v passive phr)',
                            ],
                            'experimental and control groups' => [
                                'id' => 'kelompok eksperimen dan kontrol',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Participants were randomly assigned into experimental and control groups.',
                            'Participants was randomly assigned into experimental and control groups.',
                            'Participants randomly assigned into experimental and control groups.',
                            'Participants were randomly assign into experimental and control groups.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'were randomly assigned\' adalah kalimat pasif lampau baku dalam prosedur uji klinis.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Data kuantitatif dianalisis menggunakan perangkat lunak statistik standar industri.',
                        'target_word' => 'was analyzed',
                        'vocab' => [
                            'quantitative data' => [
                                'id' => 'data kuantitatif',
                                'pos' => '(n)',
                            ],
                            'was analyzed' => [
                                'id' => 'dianalisis',
                                'pos' => '(v passive)',
                            ],
                            'industry-standard statistical software' => [
                                'id' => 'perangkat lunak statistik standar industri',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Quantitative data was analyzed using industry-standard statistical software.',
                            'Quantitative data analyzed using industry-standard statistical software.',
                            'Quantitative data was analyze using industry-standard statistical software.',
                            'Quantitative data were analyzing using industry-standard statistical software.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola pasif lampau: \'was analyzed\' (was + V3).',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Survei tersebut didistribusikan kepada lebih dari lima ratus responden terpilih.',
                        'target_word' => 'was distributed',
                        'vocab' => [
                            'survey' => [
                                'id' => 'survei',
                                'pos' => '(n sg)',
                            ],
                            'was distributed' => [
                                'id' => 'didistribusikan',
                                'pos' => '(v passive)',
                            ],
                            'to over five hundred respondents' => [
                                'id' => 'kepada lebih dari 500 responden',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The survey was distributed to over five hundred selected respondents.',
                            'The survey were distributed to over five hundred selected respondents.',
                            'The survey distributed to over five hundred selected respondents.',
                            'The survey was distribute to over five hundred selected respondents.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The survey\' tunggal, menggunakan \'was distributed\'.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Zat kontaminan diidentifikasi melalui spektrometri massa resolusi tinggi.',
                        'target_word' => 'was identified',
                        'vocab' => [
                            'contaminating substance' => [
                                'id' => 'zat kontaminan',
                                'pos' => '(n sg)',
                            ],
                            'was identified' => [
                                'id' => 'diidentifikasi',
                                'pos' => '(v passive)',
                            ],
                            'high-resolution mass spectrometry' => [
                                'id' => 'spektrometri massa resolusi tinggi',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The contaminating substance was identified through high-resolution mass spectrometry.',
                            'The contaminating substance were identified through high-resolution mass spectrometry.',
                            'The contaminating substance identified through high-resolution mass spectrometry.',
                            'The contaminating substance was identify through high-resolution mass spectrometry.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'was identified\' (was + V3) secara tepat memaparkan hasil identifikasi zat.',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Semua rekaman wawancara ditranskripsikan kata demi kata oleh asisten peneliti.',
                        'target_word' => 'were transcribed verbatim',
                        'vocab' => [
                            'interview recordings' => [
                                'id' => 'rekaman wawancara',
                                'pos' => '(n pl)',
                            ],
                            'were transcribed verbatim' => [
                                'id' => 'ditranskripsikan kata demi kata',
                                'pos' => '(v passive phr)',
                            ],
                            'research assistant' => [
                                'id' => 'asisten peneliti',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'All interview recordings were transcribed verbatim by the research assistant.',
                            'All interview recordings was transcribed verbatim by the research assistant.',
                            'All interview recordings were transcribe verbatim by the research assistant.',
                            'All interview recordings transcribed verbatim by the research assistant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'recordings\' menggunakan \'were transcribed\' (were + V3).',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Protokol keamanan baru diterapkan di seluruh fasilitas laboratorium pada tahun 2023.',
                        'target_word' => 'was implemented',
                        'vocab' => [
                            'new safety protocol' => [
                                'id' => 'protokol keamanan baru',
                                'pos' => '(n sg)',
                            ],
                            'was implemented' => [
                                'id' => 'diterapkan',
                                'pos' => '(v passive)',
                            ],
                            'across all laboratory facilities' => [
                                'id' => 'di seluruh fasilitas laboratorium',
                                'pos' => '(prep phr)',
                            ],
                            'in 2023' => [
                                'id' => 'pada tahun 2023',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'A new safety protocol was implemented across all laboratory facilities in 2023.',
                            'A new safety protocol were implemented across all laboratory facilities in 2023.',
                            'A new safety protocol implemented across all laboratory facilities in 2023.',
                            'A new safety protocol was implement across all laboratory facilities in 2023.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'protocol\' menggunakan \'was implemented\'.',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Hasil pengukuran dicatat setiap lima belas menit selama durasi eksperimen.',
                        'target_word' => 'were recorded',
                        'vocab' => [
                            'measurement readings' => [
                                'id' => 'hasil pengukuran',
                                'pos' => '(n pl)',
                            ],
                            'were recorded' => [
                                'id' => 'dicatat',
                                'pos' => '(v passive)',
                            ],
                            'every fifteen minutes' => [
                                'id' => 'setiap 15 menit',
                                'pos' => '(time phr)',
                            ],
                            'experiment duration' => [
                                'id' => 'durasi eksperimen',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Measurement readings were recorded every fifteen minutes throughout the experiment.',
                            'Measurement readings was recorded every fifteen minutes throughout the experiment.',
                            'Measurement readings recorded every fifteen minutes throughout the experiment.',
                            'Measurement readings were record every fifteen minutes throughout the experiment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'readings\' memerlukan pasif \'were recorded\'.',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Biaya proyek infrastruktur disetujui oleh kementerian keuangan pada kuartal kedua.',
                        'target_word' => 'was approved',
                        'vocab' => [
                            'infrastructure project cost' => [
                                'id' => 'biaya proyek infrastruktur',
                                'pos' => '(n sg)',
                            ],
                            'was approved' => [
                                'id' => 'disetujui',
                                'pos' => '(v passive)',
                            ],
                            'Ministry of Finance' => [
                                'id' => 'Kementerian Keuangan',
                                'pos' => '(n phr)',
                            ],
                            'second quarter' => [
                                'id' => 'kuartal kedua',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The infrastructure project cost was approved by the Ministry of Finance in the second quarter.',
                            'The infrastructure project cost were approved by the Ministry of Finance in the second quarter.',
                            'The infrastructure project cost approved by the Ministry of Finance in the second quarter.',
                            'The infrastructure project cost was approve by the Ministry of Finance in the second quarter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'cost\' adalah singular noun: \'was approved\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_trifecta_comparison',
                'name' => 'Trifecta Comparison: Verbal vs Nominal vs Pasif Masa Lampau',
                'code' => '1.8.5',
                'concept_title' => 'Trifecta Comparison: Verbal vs Nominal vs Pasif Masa Lampau',
                'concept_description' => 'Sub-lesson ini dirancang khusus untuk membedakan dan mengeliminasi kesalahan sintaksis paling umum pada tulisan mahasiswa: kerancuan antara bentuk aktif lampau (V2), nominal lampau (was/were + Adj), dan pasif lampau (was/were + V3). Kesalahan seperti \'The data was showed\' atau \'The system was consist of\' diperbaiki melalui analisis perbandingan struktur predikat.',
                'formula' => 'Aktif: S + V2 + O | Nominal: S + WAS/WERE + Adj/Noun | Pasif: S + WAS/WERE + V3',
                'rules' => [
                    'JANGAN gunakan \'was/were\' di depan kata kerja aktif transitif (SALAH: \'The survey was found that...\' ➔ BENAR: \'The survey found that...\').',
                    'Gunakan \'was/were + V3\' HANYA jika subjek adalah penderita/objek yang dikenai tindakan (BENAR: \'The sample was examined\').',
                    'Verba intransitif seperti \'consist of\', \'occur\', \'happen\', \'belong\' TIDAK BISA dipasifkan (SALAH: \'The error was occurred\' ➔ BENAR: \'The error occurred\').',
                    'Gunakan \'was/were + Adjective\' untuk kondisi subjek tanpa aksi (BENAR: \'The result was inconsistent\').',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Data tersebut menunjukkan korelasi kuat antara polusi udara dan penyakit pernapasan.',
                        'target_word' => 'showed (Aktif V2)',
                        'vocab' => [
                            'the data' => [
                                'id' => 'data tersebut',
                                'pos' => '(n)',
                            ],
                            'showed' => [
                                'id' => 'menunjukkan',
                                'pos' => '(v2 aktif)',
                            ],
                            'strong correlation' => [
                                'id' => 'korelasi kuat',
                                'pos' => '(n phr)',
                            ],
                            'respiratory illness' => [
                                'id' => 'penyakit pernapasan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The data showed a strong correlation between air pollution and respiratory illness.',
                            'The data was showed a strong correlation between air pollution and respiratory illness.',
                            'The data were showed a strong correlation between air pollution and respiratory illness.',
                            'The data was shown a strong correlation between air pollution and respiratory illness.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Karena \'data\' melakukan tindakan \'menunjukkan\', gunakan bentuk verbal aktif \'showed\'. Bentuk \'was showed\' adalah kerancuan pasif fatal.',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Reaksi kimia yang tidak terduga terjadi selama proses pemanasan larutan.',
                        'target_word' => 'occurred (Intransitif V2)',
                        'vocab' => [
                            'unexpected chemical reaction' => [
                                'id' => 'reaksi kimia yang tidak terduga',
                                'pos' => '(n phr)',
                            ],
                            'occurred' => [
                                'id' => 'terjadi',
                                'pos' => '(v2 intransitif)',
                            ],
                            'solution heating process' => [
                                'id' => 'proses pemanasan larutan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'An unexpected chemical reaction occurred during the solution heating process.',
                            'An unexpected chemical reaction was occurred during the solution heating process.',
                            'An unexpected chemical reaction was occurringly during the solution heating process.',
                            'An unexpected chemical reaction did occurred during the solution heating process.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'occur\' adalah intransitif (tidak memiliki objek), sehingga TIDAK BISA dipasifkan menjadi \'was occurred\'. Gunakan bentuk aktif \'occurred\'.',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Spesimen uji ditempatkan di dalam ruang vakum selama empat puluh delapan jam.',
                        'target_word' => 'was placed (Pasif V3)',
                        'vocab' => [
                            'test specimen' => [
                                'id' => 'spesimen uji',
                                'pos' => '(n sg)',
                            ],
                            'was placed' => [
                                'id' => 'ditempatkan',
                                'pos' => '(v pasif)',
                            ],
                            'inside the vacuum chamber' => [
                                'id' => 'di dalam ruang vakum',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The test specimen was placed inside the vacuum chamber for forty-eight hours.',
                            'The test specimen placed inside the vacuum chamber for forty-eight hours.',
                            'The test specimen was place inside the vacuum chamber for forty-eight hours.',
                            'The test specimen did placed inside the vacuum chamber for forty-eight hours.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Karena spesimen dikenai tindakan (\'ditempatkan\'), gunakan pasif lampau \'was placed\' (was + V3). Pilihan \'placed\' saja bermakna spesimen meletakkan benda lain.',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Hasil evaluasi awal sangat konsisten dengan temuan studi terdahulu.',
                        'target_word' => 'were consistent (Nominal)',
                        'vocab' => [
                            'preliminary evaluation results' => [
                                'id' => 'hasil evaluasi awal',
                                'pos' => '(n pl)',
                            ],
                            'were consistent with' => [
                                'id' => 'konsisten dengan',
                                'pos' => '(adj phr)',
                            ],
                            'earlier findings' => [
                                'id' => 'temuan terdahulu',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Preliminary evaluation results were consistent with findings from earlier studies.',
                            'Preliminary evaluation results consisted with findings from earlier studies.',
                            'Preliminary evaluation results was consistent with findings from earlier studies.',
                            'Preliminary evaluation results were consistently with findings from earlier studies.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'consistent\' adalah kata sifat (adjective), sehingga memerlukan kata kerja bantu \'were consistent\' (nominal).',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Metode penelitian tersebut terdiri dari tiga tahap pengujian independen.',
                        'target_word' => 'consisted of (Intransitif V2)',
                        'vocab' => [
                            'research methodology' => [
                                'id' => 'metode penelitian',
                                'pos' => '(n sg)',
                            ],
                            'consisted of' => [
                                'id' => 'terdiri dari',
                                'pos' => '(v phr aktif)',
                            ],
                            'three independent testing phases' => [
                                'id' => 'tiga tahap pengujian independen',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The research methodology consisted of three independent testing phases.',
                            'The research methodology was consisted of three independent testing phases.',
                            'The research methodology was consist of three independent testing phases.',
                            'The research methodology did consist of three independent testing phases.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'consist of\' tidak pernah dipasifkan. \'was consisted of\' atau \'was consist of\' adalah kesalahan umum yang harus dihindari.',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Sampel darah dianalisis oleh dua teknisi laboratorium berpengalaman secara independen.',
                        'target_word' => 'were analyzed (Pasif V3)',
                        'vocab' => [
                            'blood samples' => [
                                'id' => 'sampel darah',
                                'pos' => '(n pl)',
                            ],
                            'were analyzed' => [
                                'id' => 'dianalisis',
                                'pos' => '(v pasif)',
                            ],
                            'two experienced technicians' => [
                                'id' => 'dua teknisi berpengalaman',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The blood samples were analyzed independently by two experienced laboratory technicians.',
                            'The blood samples analyzed independently by two experienced laboratory technicians.',
                            'The blood samples was analyzed independently by two experienced laboratory technicians.',
                            'The blood samples were analyze independently by two experienced laboratory technicians.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'samples\' menerima tindakan pasif dari teknisi: \'were analyzed by\'.',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Kandungan mineral dalam batuan tersebut tidak cukup untuk eksploitasi komersial.',
                        'target_word' => 'was insufficient (Nominal)',
                        'vocab' => [
                            'mineral content' => [
                                'id' => 'kandungan mineral',
                                'pos' => '(n sg)',
                            ],
                            'inside the ore' => [
                                'id' => 'dalam bijih batuan',
                                'pos' => '(prep phr)',
                            ],
                            'was insufficient for' => [
                                'id' => 'tidak cukup / tidak memadai untuk',
                                'pos' => '(adj phr)',
                            ],
                            'commercial exploitation' => [
                                'id' => 'eksploitasi komersial',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The mineral content inside the ore was insufficient for commercial exploitation.',
                            'The mineral content inside the ore insufficiento for commercial exploitation.',
                            'The mineral content inside the ore were insufficient for commercial exploitation.',
                            'The mineral content inside the ore was insufficiently for commercial exploitation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'was insufficient\' adalah kalimat nominal lampau menggunakan kata sifat \'insufficient\'.',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Para insinyur menyelesaikan kalibrasi instrumen sebelum pengujian dimulai.',
                        'target_word' => 'completed (Aktif V2)',
                        'vocab' => [
                            'engineers' => [
                                'id' => 'para insinyur',
                                'pos' => '(n pl)',
                            ],
                            'completed' => [
                                'id' => 'menyelesaikan',
                                'pos' => '(v2 aktif)',
                            ],
                            'instrument calibration' => [
                                'id' => 'kalibrasi instrumen',
                                'pos' => '(n phr)',
                            ],
                            'testing commenced' => [
                                'id' => 'pengujian dimulai',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'The engineers completed the instrument calibration before testing commenced.',
                            'The engineers were completed the instrument calibration before testing commenced.',
                            'The engineers was completed the instrument calibration before testing commenced.',
                            'The engineers did completed the instrument calibration before testing commenced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The engineers\' adalah pelaku aktif: \'completed the calibration\', bukan \'were completed\'.',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Hipotesis kerja kedua terbukti salah setelah analisis data lanjutan dilakukan.',
                        'target_word' => 'proved to be false (Kopulatif/Aktif V2)',
                        'vocab' => [
                            'second working hypothesis' => [
                                'id' => 'hipotesis kerja kedua',
                                'pos' => '(n phr)',
                            ],
                            'proved to be false' => [
                                'id' => 'terbukti salah',
                                'pos' => '(v phr)',
                            ],
                            'further data analysis' => [
                                'id' => 'analisis data lanjutan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The second working hypothesis proved to be false after further data analysis.',
                            'The second working hypothesis was proved to be false after further data analysis.',
                            'The second working hypothesis was prove to be false after further data analysis.',
                            'The second working hypothesis did proved to be false after further data analysis.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'proved to be false\' berfungsi sebagai verba kopulatif aktif yang menyatakan hasil pembuktian.',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Laporan keuangan tahunan diverifikasi oleh kantor akuntan publik independen.',
                        'target_word' => 'was verified (Pasif V3)',
                        'vocab' => [
                            'annual financial report' => [
                                'id' => 'laporan keuangan tahunan',
                                'pos' => '(n sg)',
                            ],
                            'was verified by' => [
                                'id' => 'diverifikasi oleh',
                                'pos' => '(v pasif phr)',
                            ],
                            'independent public accounting firm' => [
                                'id' => 'kantor akuntan publik independen',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The annual financial report was verified by an independent public accounting firm.',
                            'The annual financial report verified by an independent public accounting firm.',
                            'The annual financial report were verified by an independent public accounting firm.',
                            'The annual financial report was verify by an independent public accounting firm.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The annual financial report\' (tunggal) menerima tindakan diverifikasi: \'was verified by\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_negative_questions',
                'name' => 'Simple Past Negative & Interrogative (did not + V1, was/were not)',
                'code' => '1.8.6',
                'concept_title' => 'Simple Past Negative & Interrogative (did not + V1, was/were not)',
                'concept_description' => 'Dalam penulisan ilmiah, kalimat negatif lampau sering digunakan untuk menyangkal hipotesis (Hypothesis Negation) atau menyatakan bahwa suatu fenomena tidak teramati. Pada kalimat verbal, bentuk negatif menggunakan kata kerja bantu \'did not\' diikuti kata kerja dasar (V1 murni). Pada kalimat nominal dan pasif, tambahkan \'not\' setelah was/were.',
                'formula' => 'Verbal Negatif: Subject + DID NOT + V1 (Base Form) | Nominal/Pasif Negatif: Subject + WAS/WERE NOT + Complement/V3',
                'rules' => [
                    'Setelah \'did not\', kata kerja WAJIB kembali ke bentuk dasar V1 (dilarang menggunakan V2 setelah did not: \'did not went\' ➔ SALAH; \'did not go\' ➔ BENAR).',
                    'Dalam naskah akademik formal, hindari bentuk singkatan (gunakan \'did not\', bukan \'didn\'t\'; \'was not\', bukan \'wasn\'t\').',
                    'Pada kalimat tanya formal: \'Did + Subject + V1 ...?\' atau \'Was/Were + Subject + Complement/V3 ...?\'.',
                    'Penyangkalan temuan penelitian harus dinyatakan secara objektif dan akurat.',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Hasil eksperimen tidak menunjukkan korelasi yang signifikan antara kedua variabel.',
                        'target_word' => 'did not show',
                        'vocab' => [
                            'experimental results' => [
                                'id' => 'hasil eksperimen',
                                'pos' => '(n pl)',
                            ],
                            'did not show' => [
                                'id' => 'tidak menunjukkan',
                                'pos' => '(v neg)',
                            ],
                            'significant correlation' => [
                                'id' => 'korelasi signifikan',
                                'pos' => '(n phr)',
                            ],
                            'two variables' => [
                                'id' => 'kedua variabel',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The experimental results did not show any significant correlation between the two variables.',
                            'The experimental results did not showed any significant correlation between the two variables.',
                            'The experimental results not showed any significant correlation between the two variables.',
                            'The experimental results were not show any significant correlation between the two variables.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk negatif verbal lampau: \'did not\' + V1 murni (\'show\'). Bentuk \'did not showed\' adalah kesalahan fatal.',
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Substansi kimia tersebut tidak larut dalam pelarut organik pada suhu kamar.',
                        'target_word' => 'did not dissolve',
                        'vocab' => [
                            'chemical substance' => [
                                'id' => 'substansi kimia',
                                'pos' => '(n sg)',
                            ],
                            'did not dissolve' => [
                                'id' => 'tidak larut',
                                'pos' => '(v neg)',
                            ],
                            'organic solvent' => [
                                'id' => 'pelarut organik',
                                'pos' => '(n phr)',
                            ],
                            'at room temperature' => [
                                'id' => 'pada suhu kamar',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The chemical substance did not dissolve in the organic solvent at room temperature.',
                            'The chemical substance did not dissolved in the organic solvent at room temperature.',
                            'The chemical substance was not dissolve in the organic solvent at room temperature.',
                            'The chemical substance not dissolved in the organic solvent at room temperature.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'did not dissolve\' menggunakan V1 \'dissolve\' setelah auxiliary \'did not\'.',
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Perbedaan rata-rata antara kedua kelompok uji tidak signifikan secara statistik.',
                        'target_word' => 'was not statistically significant',
                        'vocab' => [
                            'mean difference' => [
                                'id' => 'perbedaan rata-rata',
                                'pos' => '(n sg)',
                            ],
                            'two test groups' => [
                                'id' => 'kedua kelompok uji',
                                'pos' => '(n phr)',
                            ],
                            'was not statistically significant' => [
                                'id' => 'tidak signifikan secara statistik',
                                'pos' => '(phr neg)',
                            ],
                        ],
                        'options' => [
                            'The mean difference between the two test groups was not statistically significant.',
                            'The mean difference between the two test groups did not statistically significant.',
                            'The mean difference between the two test groups were not statistically significant.',
                            'The mean difference between the two test groups was not statistical significance.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'significant\' adalah kata sifat (adjective), sehingga kalimat negatifnya menggunakan \'was not significant\' (bukan \'did not\').',
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Para peneliti tidak mendeteksi tanda-tanda kontaminasi silang di dalam ruang isolasi.',
                        'target_word' => 'did not detect',
                        'vocab' => [
                            'researchers' => [
                                'id' => 'para peneliti',
                                'pos' => '(n pl)',
                            ],
                            'did not detect' => [
                                'id' => 'tidak mendeteksi',
                                'pos' => '(v neg)',
                            ],
                            'signs of cross-contamination' => [
                                'id' => 'tanda-tanda kontaminasi silang',
                                'pos' => '(n phr)',
                            ],
                            'isolation chamber' => [
                                'id' => 'ruang isolasi',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Researchers did not detect any signs of cross-contamination inside the isolation chamber.',
                            'Researchers did not detected any signs of cross-contamination inside the isolation chamber.',
                            'Researchers were not detect any signs of cross-contamination inside the isolation chamber.',
                            'Researchers not detected any signs of cross-contamination inside the isolation chamber.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'did not detect\' mematuhi aturan \'did not + V1\'.',
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Data survei tersebut tidak dipublikasikan sebelum proses penelaahan sejawat selesai.',
                        'target_word' => 'was not published',
                        'vocab' => [
                            'survey data' => [
                                'id' => 'data survei',
                                'pos' => '(n)',
                            ],
                            'was not published' => [
                                'id' => 'tidak dipublikasikan',
                                'pos' => '(v pasif neg)',
                            ],
                            'peer review process' => [
                                'id' => 'proses penelaahan sejawat',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The survey data was not published prior to the completion of the peer review process.',
                            'The survey data did not published prior to the completion of the peer review process.',
                            'The survey data was not publish prior to the completion of the peer review process.',
                            'The survey data not was published prior to the completion of the peer review process.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pasif negatif lampau: \'was not published\' (was + not + V3).',
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Apakah dosis obat yang lebih tinggi memicu efek samping yang merugikan pada hewan uji?',
                        'target_word' => 'Did the higher dosage trigger',
                        'vocab' => [
                            'higher drug dosage' => [
                                'id' => 'dosis obat yang lebih tinggi',
                                'pos' => '(n phr)',
                            ],
                            'trigger' => [
                                'id' => 'memicu',
                                'pos' => '(v)',
                            ],
                            'adverse side effects' => [
                                'id' => 'efek samping merugikan',
                                'pos' => '(n phr)',
                            ],
                            'test animals' => [
                                'id' => 'hewan uji',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Did the higher drug dosage trigger adverse side effects in test animals?',
                            'Did the higher drug dosage triggered adverse side effects in test animals?',
                            'Was the higher drug dosage trigger adverse side effects in test animals?',
                            'Does the higher drug dosage triggered adverse side effects in test animals?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat tanya verbal lampau: \'Did + Subject + V1 (trigger)?\'.',
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah instrumen sensor tersebut dikalibrasi sebelum dimulainya uji coba lapangan?',
                        'target_word' => 'Was the sensor calibrated',
                        'vocab' => [
                            'sensor instrument' => [
                                'id' => 'instrumen sensor',
                                'pos' => '(n sg)',
                            ],
                            'calibrated' => [
                                'id' => 'dikalibrasi',
                                'pos' => '(v3)',
                            ],
                            'field trial commencement' => [
                                'id' => 'dimulainya uji coba lapangan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Was the sensor instrument calibrated prior to the commencement of field trials?',
                            'Did the sensor instrument calibrated prior to the commencement of field trials?',
                            'Were the sensor instrument calibrated prior to the commencement of field trials?',
                            'Was the sensor instrument calibrate prior to the commencement of field trials?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat tanya pasif lampau: \'Was + Singular Subject + V3 (calibrated)?\'.',
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Penelitian perintis tersebut tidak berhasil membuktikan keberadaan materi gelap.',
                        'target_word' => 'did not succeed in proving',
                        'vocab' => [
                            'pioneering study' => [
                                'id' => 'penelitian perintis',
                                'pos' => '(n phr)',
                            ],
                            'did not succeed in proving' => [
                                'id' => 'tidak berhasil membuktikan',
                                'pos' => '(v neg phr)',
                            ],
                            'existence of dark matter' => [
                                'id' => 'keberadaan materi gelap',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The pioneering study did not succeed in proving the existence of dark matter.',
                            'The pioneering study did not succeeded in proving the existence of dark matter.',
                            'The pioneering study was not succeed in proving the existence of dark matter.',
                            'The pioneering study not succeeded in proving the existence of dark matter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'did not succeed\' (did not + V1).',
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Apakah para peserta merasa puas dengan metode intervensi pembelajaran yang diterapkan?',
                        'target_word' => 'Were the participants satisfied',
                        'vocab' => [
                            'participants' => [
                                'id' => 'para peserta',
                                'pos' => '(n pl)',
                            ],
                            'satisfied with' => [
                                'id' => 'puas dengan',
                                'pos' => '(adj phr)',
                            ],
                            'learning intervention method' => [
                                'id' => 'metode intervensi pembelajaran',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Were the participants satisfied with the implemented learning intervention method?',
                            'Did the participants satisfied with the implemented learning intervention method?',
                            'Was the participants satisfied with the implemented learning intervention method?',
                            'Did the participants be satisfied with the implemented learning intervention method?',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'satisfied\' adalah adjective (nominal), sehingga kalimat tanya menggunakan \'Were + Plural Subject + Adjective?\'.',
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Keluaran tegangan listrik generator tidak konstan selama fluktuasi beban puncak.',
                        'target_word' => 'was not constant',
                        'vocab' => [
                            'generator electrical voltage output' => [
                                'id' => 'keluaran tegangan listrik generator',
                                'pos' => '(n sg)',
                            ],
                            'was not constant' => [
                                'id' => 'tidak konstan',
                                'pos' => '(adj neg)',
                            ],
                            'peak load fluctuations' => [
                                'id' => 'fluktuasi beban puncak',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The generator\'s electrical voltage output was not constant during peak load fluctuations.',
                            'The generator\'s electrical voltage output did not constant during peak load fluctuations.',
                            'The generator\'s electrical voltage output were not constant during peak load fluctuations.',
                            'The generator\'s electrical voltage output was not constantly during peak load fluctuations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'constant\' adalah adjective, gunakan \'was not constant\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_time_adverbials',
                'name' => 'Past Time Adverbials & Contextual Positioning (in 2020, during the trial, previously)',
                'code' => '1.8.7',
                'concept_title' => 'Past Time Adverbials & Contextual Positioning (in 2020, during the trial, previously)',
                'concept_description' => 'Penempatan frasa keterangan waktu lampau (Past Time Adverbials) sangat penting dalam menyusun narasi metodologi dan laporan tinjauan riwayat riset. Frasa keterangan waktu dapat diletakkan di awal kalimat (dengan tanda koma sebagai pembuka narasi) atau di akhir kalimat sebagai penjelas parameter waktu.',
                'formula' => 'Time Adverbial Phrase + , + Subject + V2 / was/were + Object | Subject + V2 + Object + Time Adverbial',
                'rules' => [
                    'Keterangan waktu lampau yang definitif (in 2022, last year, three days ago, during the trial) mewajibkan penggunaan Simple Past Tense (V2 / was / were).',
                    'Jika frasa preposisi waktu diletakkan di awal kalimat, WAJIB dipisahkan dengan tanda koma (contoh: \'In 2021, the team discovered...\').',
                    'Dilarang menggabungkan Present Perfect (\'has/have + V3\') dengan keterangan waktu lampau spesifik seperti \'in 2019\' atau \'yesterday\'.',
                    'Variasikan posisi adverbial untuk menjaga alur kalimat yang dinamis dan tidak monoton.',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Pada tahun 2021, tim peneliti memublikasikan penemuan obat antivirus baru di jurnal internasional.',
                        'target_word' => 'In 2021, the team published',
                        'vocab' => [
                            'in 2021' => [
                                'id' => 'pada tahun 2021',
                                'pos' => '(time phr)',
                            ],
                            'research team' => [
                                'id' => 'tim peneliti',
                                'pos' => '(n phr)',
                            ],
                            'published' => [
                                'id' => 'memublikasikan',
                                'pos' => '(v2)',
                            ],
                            'novel antiviral drug discovery' => [
                                'id' => 'penemuan obat antivirus baru',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'In 2021, the research team published the discovery of a novel antiviral drug in an international journal.',
                            'In 2021, the research team has published the discovery of a novel antiviral drug in an international journal.',
                            'In 2021 the research team publishes the discovery of a novel antiviral drug in an international journal.',
                            'In 2021, the research team was published the discovery of a novel antiviral drug in an international journal.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu definitif \'In 2021,\' mewajibkan V2 lampau aktif \'published\' (bukan present perfect \'has published\'). Tanda koma wajib diletakkan setelah frasa pembuka waktu.',
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Selama fase pengujian pertama, konsumsi daya turun sebesar lima belas persen.',
                        'target_word' => 'During the initial testing phase, power consumption dropped',
                        'vocab' => [
                            'during the initial testing phase' => [
                                'id' => 'selama fase pengujian pertama',
                                'pos' => '(time phr)',
                            ],
                            'power consumption' => [
                                'id' => 'konsumsi daya',
                                'pos' => '(n phr)',
                            ],
                            'dropped by fifteen percent' => [
                                'id' => 'turun sebesar 15 persen',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'During the initial testing phase, power consumption dropped by fifteen percent.',
                            'During the initial testing phase, power consumption drops by fifteen percent.',
                            'During the initial testing phase, power consumption was dropped by fifteen percent.',
                            'During the initial testing phase power consumption has dropped by fifteen percent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'During the initial testing phase,\' adalah keterangan waktu lampau yang diikuti V2 \'dropped\'.',
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Sebelum penerapan kebijakan baru, angka emisi karbon industri meningkat secara konsisten.',
                        'target_word' => 'Prior to the implementation, emissions increased',
                        'vocab' => [
                            'prior to policy implementation' => [
                                'id' => 'sebelum penerapan kebijakan',
                                'pos' => '(prep phr)',
                            ],
                            'industrial carbon emissions' => [
                                'id' => 'emisi karbon industri',
                                'pos' => '(n phr)',
                            ],
                            'increased consistently' => [
                                'id' => 'meningkat secara konsisten',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'Prior to the implementation of the new policy, industrial carbon emissions increased consistently.',
                            'Prior to the implementation of the new policy, industrial carbon emissions have increased consistently.',
                            'Prior to the implementation of the new policy, industrial carbon emissions increases consistently.',
                            'Prior to the implementation of the new policy, industrial carbon emissions were increase consistently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Prior to the implementation...\' merujuk pada rentang waktu lampau, membutuhkan V2 \'increased\'.',
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Studi sebelumnya melaporkan tingkat keberhasilan terapi sebesar delapan puluh persen.',
                        'target_word' => 'reported',
                        'vocab' => [
                            'previous study' => [
                                'id' => 'studi sebelumnya',
                                'pos' => '(n phr)',
                            ],
                            'reported' => [
                                'id' => 'melaporkan',
                                'pos' => '(v2)',
                            ],
                            'therapy success rate' => [
                                'id' => 'tingkat keberhasilan terapi',
                                'pos' => '(n phr)',
                            ],
                            'eighty percent' => [
                                'id' => 'delapan puluh persen',
                                'pos' => '(num phr)',
                            ],
                        ],
                        'options' => [
                            'The previous study reported an eighty percent therapeutic success rate.',
                            'The previous study has reported an eighty percent therapeutic success rate.',
                            'The previous study reports an eighty percent therapeutic success rate.',
                            'The previous study was reported an eighty percent therapeutic success rate.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Untuk merujuk ke publikasi masa lampau (\'The previous study\'), gunakan V2 \'reported\'.',
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Tiga dekade lalu, infrastruktur komputasi awan belum tersedia bagi peneliti akademis.',
                        'target_word' => 'Three decades ago, cloud infrastructure was unavailable',
                        'vocab' => [
                            'three decades ago' => [
                                'id' => 'tiga dekade lalu',
                                'pos' => '(time phr)',
                            ],
                            'cloud computing infrastructure' => [
                                'id' => 'infrastruktur komputasi awan',
                                'pos' => '(n phr)',
                            ],
                            'was unavailable to' => [
                                'id' => 'belum tersedia bagi',
                                'pos' => '(adj phr)',
                            ],
                            'academic researchers' => [
                                'id' => 'peneliti akademis',
                                'pos' => '(n pl)',
                            ],
                        ],
                        'options' => [
                            'Three decades ago, cloud computing infrastructure was unavailable to academic researchers.',
                            'Three decades ago, cloud computing infrastructure were unavailable to academic researchers.',
                            'Three decades ago, cloud computing infrastructure did unavailable to academic researchers.',
                            'Three decades ago, cloud computing infrastructure has been unavailable to academic researchers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Three decades ago\' adalah penanda waktu lampau definitif. Diikuti \'was unavailable\'.',
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Sepanjang tahun fiskal lalu, ekspor manufaktur nasional tumbuh sebesar enam persen.',
                        'target_word' => 'Throughout the last fiscal year, exports grew',
                        'vocab' => [
                            'throughout the last fiscal year' => [
                                'id' => 'sepanjang tahun fiskal lalu',
                                'pos' => '(time phr)',
                            ],
                            'national manufacturing exports' => [
                                'id' => 'ekspor manufaktur nasional',
                                'pos' => '(n pl)',
                            ],
                            'grew by six percent' => [
                                'id' => 'tumbuh sebesar 6 persen',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'Throughout the last fiscal year, national manufacturing exports grew by six percent.',
                            'Throughout the last fiscal year, national manufacturing exports have grown by six percent.',
                            'Throughout the last fiscal year, national manufacturing exports grows by six percent.',
                            'Throughout the last fiscal year, national manufacturing exports was grew by six percent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Rentang waktu \'Throughout the last fiscal year\' memerlukan V2 irregular \'grew\'.',
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Setelah gempa bumi besar terjadi, aliran listrik padam di seluruh distrik selama tiga hari.',
                        'target_word' => 'Following the major earthquake, power supply failed',
                        'vocab' => [
                            'following the major earthquake' => [
                                'id' => 'setelah gempa bumi besar',
                                'pos' => '(prep phr)',
                            ],
                            'electrical power supply' => [
                                'id' => 'pasokan aliran listrik',
                                'pos' => '(n phr)',
                            ],
                            'failed across the district' => [
                                'id' => 'padam / terputus di seluruh distrik',
                                'pos' => '(v phr)',
                            ],
                            'for three days' => [
                                'id' => 'selama tiga hari',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'Following the major earthquake, the electrical power supply failed across the entire district for three days.',
                            'Following the major earthquake, the electrical power supply has failed across the entire district for three days.',
                            'Following the major earthquake, the electrical power supply fails across the entire district for three days.',
                            'Following the major earthquake, the electrical power supply was failed across the entire district for three days.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'failed\' (V2) menyatakan pemadaman listrik historis pascagempa.',
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Di awal dekade ini, investasi global dalam teknologi ramah lingkungan mencapai rekor baru.',
                        'target_word' => 'At the beginning of the decade, investment reached',
                        'vocab' => [
                            'at the beginning of the decade' => [
                                'id' => 'di awal dekade ini',
                                'pos' => '(time phr)',
                            ],
                            'global investment in green technology' => [
                                'id' => 'investasi global teknologi ramah lingkungan',
                                'pos' => '(n phr)',
                            ],
                            'reached a new record' => [
                                'id' => 'mencapai rekor baru',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'At the beginning of the decade, global investment in green technology reached a new record.',
                            'At the beginning of the decade, global investment in green technology has reached a new record.',
                            'At the beginning of the decade, global investment in green technology reaches a new record.',
                            'At the beginning of the decade, global investment in green technology was reached a new record.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu di awal kalimat diikuti V2 \'reached\'.',
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Para ahli bedah menyelesaikan prosedur transplantasi yang rumit dalam waktu enam jam kemarin.',
                        'target_word' => 'completed',
                        'vocab' => [
                            'surgeons' => [
                                'id' => 'para ahli bedah',
                                'pos' => '(n pl)',
                            ],
                            'completed' => [
                                'id' => 'menyelesaikan',
                                'pos' => '(v2)',
                            ],
                            'complex transplantation procedure' => [
                                'id' => 'prosedur transplantasi yang rumit',
                                'pos' => '(n phr)',
                            ],
                            'in six hours yesterday' => [
                                'id' => 'dalam 6 jam kemarin',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'Surgeons completed the complex transplantation procedure in six hours yesterday.',
                            'Surgeons have completed the complex transplantation procedure in six hours yesterday.',
                            'Surgeons completes the complex transplantation procedure in six hours yesterday.',
                            'Surgeons were completed the complex transplantation procedure in six hours yesterday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'yesterday\' adalah penanda waktu lampau mutlak yang tidak boleh digabungkan dengan Present Perfect.',
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Sebelum abad ke-20, teori mekanika klasik mendominasi seluruh paradigma ilmu fisika.',
                        'target_word' => 'dominated',
                        'vocab' => [
                            'prior to the twentieth century' => [
                                'id' => 'sebelum abad ke-20',
                                'pos' => '(time phr)',
                            ],
                            'classical mechanics theory' => [
                                'id' => 'teori mekanika klasik',
                                'pos' => '(n phr)',
                            ],
                            'dominated' => [
                                'id' => 'mendominasi',
                                'pos' => '(v2)',
                            ],
                            'entire physics paradigm' => [
                                'id' => 'seluruh paradigma fisika',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Prior to the twentieth century, classical mechanics theory dominated the entire physics paradigm.',
                            'Prior to the twentieth century, classical mechanics theory has dominated the entire physics paradigm.',
                            'Prior to the twentieth century, classical mechanics theory dominates the entire physics paradigm.',
                            'Prior to the twentieth century, classical mechanics theory was dominated the entire physics paradigm.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Era lampau sebelum abad ke-20 menggunakan Simple Past V2 \'dominated\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_methodology_synthesis',
                'name' => 'Comprehensive Methodology & Past Narrative Synthesis (Laporan Metodologi Utuh)',
                'code' => '1.8.8',
                'concept_title' => 'Comprehensive Methodology & Past Narrative Synthesis (Laporan Metodologi Utuh)',
                'concept_description' => 'Sub-lesson penutup ini mensintesis seluruh keterampilan Simple Past Tense: perpaduan kalimat aktif (tindakan terencana peneliti), kalimat pasif (perlakuan terhadap sampel dan instrumen), serta kalimat nominal (kondisi dan sifat lingkungan pengujian) dalam penulisan narasi ilmiah dan laporan metodologi komprehensif yang siap dipublikasikan.',
                'formula' => 'Synthesized Academic Methodology: S + V2 (Active) + while + S + was/were + V3 (Passive) + where + S + was/were + Adj (Nominal)',
                'rules' => [
                    'Gunakan kalimat pasif lampau (\'samples were gathered\', \'temperatures were measured\') untuk mendeskripsikan prosedur laboratorium objektif.',
                    'Gunakan kalimat aktif lampau (\'the team formulated\', \'the algorithm demonstrated\') untuk menekankan kontribusi dan aksi konseptual peneliti.',
                    'Gunakan kalimat nominal lampau (\'conditions were optimal\', \'the baseline was stable\') untuk menetapkan parameter awal pengujian.',
                    'Jaga konsistensi tenses di sepanjang perenggan metodologi tanpa melompat ke Present Tense secara acak.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Peneliti mengumpulkan sampel sedimen dan segera membekukannya pada suhu minus dua puluh derajat.',
                        'target_word' => 'collected ... froze',
                        'vocab' => [
                            'researchers' => [
                                'id' => 'para peneliti',
                                'pos' => '(n pl)',
                            ],
                            'collected' => [
                                'id' => 'mengumpulkan',
                                'pos' => '(v2 regular)',
                            ],
                            'immediately froze' => [
                                'id' => 'segera membekukan',
                                'pos' => '(v2 irregular)',
                            ],
                            'at minus twenty degrees' => [
                                'id' => 'pada suhu minus 20 derajat',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'Researchers collected sediment samples and immediately froze them at minus twenty degrees.',
                            'Researchers collected sediment samples and immediately freeze them at minus twenty degrees.',
                            'Researchers was collected sediment samples and immediately froze them at minus twenty degrees.',
                            'Researchers have collected sediment samples and immediately froze them at minus twenty degrees.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua kata kerja yang dihubungkan oleh \'and\' wajib paralel dalam bentuk Simple Past: \'collected ... froze\'.',
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Sebanyak dua ratus partisipan direkrut dan dibagi secara acak ke dalam empat kelompok perlakuan.',
                        'target_word' => 'were recruited and randomly divided',
                        'vocab' => [
                            'two hundred participants' => [
                                'id' => '200 partisipan',
                                'pos' => '(n pl)',
                            ],
                            'were recruited and randomly divided' => [
                                'id' => 'direkrut dan dibagi secara acak',
                                'pos' => '(v pasif phr)',
                            ],
                            'four treatment groups' => [
                                'id' => 'empat kelompok perlakuan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'A total of two hundred participants were recruited and randomly divided into four treatment groups.',
                            'A total of two hundred participants was recruited and randomly divided into four treatment groups.',
                            'A total of two hundred participants recruited and randomly divided into four treatment groups.',
                            'A total of two hundred participants were recruited and randomly divide into four treatment groups.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua verba pasif terkoordinasi: \'were recruited and randomly divided\'.',
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Meskipun kondisi eksperimen sangat menantang, sensor tetap berfungsi secara stabil.',
                        'target_word' => 'were challenging ... remained',
                        'vocab' => [
                            'experimental conditions were challenging' => [
                                'id' => 'kondisi eksperimen sangat menantang',
                                'pos' => '(clause nominal)',
                            ],
                            'sensor remained functional' => [
                                'id' => 'sensor tetap berfungsi',
                                'pos' => '(clause aktif)',
                            ],
                        ],
                        'options' => [
                            'Although experimental conditions were challenging, the sensor remained functional throughout testing.',
                            'Although experimental conditions was challenging, the sensor remained functional throughout testing.',
                            'Although experimental conditions were challenging, the sensor remains functional throughout testing.',
                            'Although experimental conditions did challenging, the sensor remained functional throughout testing.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'were challenging\' (nominal lampau) dipadukan dengan klausa utama \'remained functional\' (aktif V2).',
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Larutan asam disaring secara perlahan dan filtratnya dianalisis dengan kromatografi gas.',
                        'target_word' => 'was filtered ... was analyzed',
                        'vocab' => [
                            'acidic solution was filtered' => [
                                'id' => 'larutan asam disaring',
                                'pos' => '(clause pasif)',
                            ],
                            'filtrate was analyzed' => [
                                'id' => 'filtratnya dianalisis',
                                'pos' => '(clause pasif)',
                            ],
                            'gas chromatography' => [
                                'id' => 'kromatografi gas',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The acidic solution was slowly filtered, and the resulting filtrate was analyzed via gas chromatography.',
                            'The acidic solution slowly filtered, and the resulting filtrate was analyzed via gas chromatography.',
                            'The acidic solution was slowly filtered, and the resulting filtrate analyzed via gas chromatography.',
                            'The acidic solution was slowly filter, and the resulting filtrate was analyze via gas chromatography.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa adalah kalimat pasif lampau yang rapi: \'was slowly filtered\' dan \'was analyzed\'.',
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Tim riset mengisolasi bakteri patogen tersebut sebelum resistensi antibiotik berkembang luas.',
                        'target_word' => 'isolated ... developed',
                        'vocab' => [
                            'research team isolated' => [
                                'id' => 'tim riset mengisolasi',
                                'pos' => '(clause aktif)',
                            ],
                            'pathogenic bacteria' => [
                                'id' => 'bakteri patogen',
                                'pos' => '(n phr)',
                            ],
                            'before antibiotic resistance developed' => [
                                'id' => 'sebelum resistensi berkembang',
                                'pos' => '(clause aktif)',
                            ],
                        ],
                        'options' => [
                            'The research team isolated the pathogenic bacteria before widespread antibiotic resistance developed.',
                            'The research team was isolated the pathogenic bacteria before widespread antibiotic resistance developed.',
                            'The research team isolated the pathogenic bacteria before widespread antibiotic resistance was developed.',
                            'The research team has isolated the pathogenic bacteria before widespread antibiotic resistance developed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'isolated\' dan \'developed\' keduanya adalah bentuk aktif Simple Past V2.',
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Data numerik diekstraksi dari rekam medis dan diverifikasi silang dengan dokumen fisik.',
                        'target_word' => 'were extracted ... cross-verified',
                        'vocab' => [
                            'numerical data were extracted' => [
                                'id' => 'data numerik diekstraksi',
                                'pos' => '(v pasif phr)',
                            ],
                            'medical records' => [
                                'id' => 'rekam medis',
                                'pos' => '(n pl)',
                            ],
                            'cross-verified with physical files' => [
                                'id' => 'diverifikasi silang dengan dokumen fisik',
                                'pos' => '(v pasif phr)',
                            ],
                        ],
                        'options' => [
                            'Numerical data were extracted from electronic records and cross-verified with physical files.',
                            'Numerical data was extracted from electronic records and cross-verified with physical files.',
                            'Numerical data extracted from electronic records and cross-verified with physical files.',
                            'Numerical data were extract from electronic records and cross-verify with physical files.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'data\' dalam laporan kuantitatif dipasifkan dengan \'were extracted ... and cross-verified\'.',
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Tingkat kemurnian senyawa kimia tersebut adalah sembilan puluh sembilan persen setelah kristalisasi.',
                        'target_word' => 'was ninety-nine percent',
                        'vocab' => [
                            'purity level' => [
                                'id' => 'tingkat kemurnian',
                                'pos' => '(n sg)',
                            ],
                            'chemical compound' => [
                                'id' => 'senyawa kimia',
                                'pos' => '(n phr)',
                            ],
                            'was ninety-nine percent' => [
                                'id' => 'adalah 99 persen',
                                'pos' => '(nominal phr)',
                            ],
                            'following recrystallization' => [
                                'id' => 'setelah kristalisasi ulang',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The purity level of the chemical compound was ninety-nine percent following recrystallization.',
                            'The purity level of the chemical compound were ninety-nine percent following recrystallization.',
                            'The purity level of the chemical compound did ninety-nine percent following recrystallization.',
                            'The purity level of the chemical compound was purely ninety-nine percent following recrystallization.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The purity level\' (tunggal) menggunakan \'was\' + persentase komplemen.',
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Pemerintah memberlakukan pembatasan impor darurat karena pasokan dalam negeri tidak mencukupi.',
                        'target_word' => 'enacted ... was insufficient',
                        'vocab' => [
                            'government enacted' => [
                                'id' => 'pemerintah memberlakukan',
                                'pos' => '(clause aktif V2)',
                            ],
                            'emergency import restrictions' => [
                                'id' => 'pembatasan impor darurat',
                                'pos' => '(n phr)',
                            ],
                            'domestic supply was insufficient' => [
                                'id' => 'pasokan dalam negeri tidak mencukupi',
                                'pos' => '(clause nominal)',
                            ],
                        ],
                        'options' => [
                            'The government enacted emergency import restrictions because the domestic supply was insufficient.',
                            'The government was enacted emergency import restrictions because the domestic supply was insufficient.',
                            'The government enacted emergency import restrictions because the domestic supply were insufficient.',
                            'The government enacted emergency import restrictions because the domestic supply did insufficient.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'enacted\' (aktif V2) berpasangan dengan \'was insufficient\' (nominal lampau).',
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Semua anomali data diidentifikasi dan didiskusikan secara mendalam dalam laporan teknis akhir.',
                        'target_word' => 'were identified and thoroughly discussed',
                        'vocab' => [
                            'all data anomalies' => [
                                'id' => 'semua anomali data',
                                'pos' => '(n pl)',
                            ],
                            'were identified and discussed' => [
                                'id' => 'diidentifikasi dan didiskusikan',
                                'pos' => '(v pasif phr)',
                            ],
                            'final technical report' => [
                                'id' => 'laporan teknis akhir',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'All data anomalies were identified and thoroughly discussed in the final technical report.',
                            'All data anomalies was identified and thoroughly discussed in the final technical report.',
                            'All data anomalies identified and thoroughly discussed in the final technical report.',
                            'All data anomalies were identify and thoroughly discuss in the final technical report.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'anomalies\' menggunakan pasif koordinatif: \'were identified and thoroughly discussed\'.',
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Proyek percontohan tersebut berhasil membuktikan kelayakan teknis teknologi penyimpanan energi baru.',
                        'target_word' => 'successfully demonstrated',
                        'vocab' => [
                            'pilot project' => [
                                'id' => 'proyek percontohan',
                                'pos' => '(n phr)',
                            ],
                            'successfully demonstrated' => [
                                'id' => 'berhasil membuktikan',
                                'pos' => '(v2 aktif phr)',
                            ],
                            'technical feasibility' => [
                                'id' => 'kelayakan teknis',
                                'pos' => '(n phr)',
                            ],
                            'new energy storage technology' => [
                                'id' => 'teknologi penyimpanan energi baru',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The pilot project successfully demonstrated the technical feasibility of the new energy storage technology.',
                            'The pilot project was successfully demonstrated the technical feasibility of the new energy storage technology.',
                            'The pilot project successfully demonstrate the technical feasibility of the new energy storage technology.',
                            'The pilot project has successfully demonstrated the technical feasibility of the new energy storage technology.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The pilot project successfully demonstrated...\' adalah bentuk verbal aktif V2 yang baku untuk menutup laporan proyek.',
                    ],
                ],
            ],
        ];
    }
}
