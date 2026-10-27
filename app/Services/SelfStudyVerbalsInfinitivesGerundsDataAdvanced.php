<?php

namespace App\Services;

class SelfStudyVerbalsInfinitivesGerundsDataAdvanced
{
    /**
     * Get the complete Verbals: Basic Infinitives & Gerunds (Level 101) package.
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
            'banner_title' => 'Verbals: Basic Infinitives & Gerunds (Level 101)',
            'banner_subtitle' => 'Kuasai pola komplementasi verba ilmiah: pemilihan to-infinitive vs gerund, infinitif penunjuk tujuan, kombinasi preposisi + gerund, pola transitif kausatif, dan eliminasi kesalahan struktur ganda.',
            'banner_badge' => 'MODULE 1.6 VERBALS: INFINITIVES & GERUNDS',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.6
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Sintaksis Verbals: Komplementasi To-Infinitive & Gerund dalam Academic Writing',
            'concept_summary' => 'Dalam penulisan kalimat akademik, verba sering membutuhkan tindakan sekunder sebagai objek atau pelengkap. Bahasa Inggris mengatur komplementasi ini secara ketat melalui dua bentuk non-finite verbs: To-Infinitive (to + V1) dan Gerund (V-ing). Kesalahan memadukan verba utama dengan pelengkap yang keliru (seperti "involves to analyze" atau "fails analyzing") adalah salah satu penanda utama ketidakmatangan gramatikal dalam esai IELTS/TOEFL dan artikel jurnal ilmiah.',
            'rules' => [
                [
                    'rule_title' => '1. Verba yang Wajib Diikuti To-Infinitive (Intensi & Upaya)',
                    'rule_formula' => 'Subject + (attempt, tend, aim, decide, fail, refuse, intend, hesitate) + TO + V1',
                    'rule_description' => 'Kata kerja yang berorientasi pada niat, sasaran, atau usaha masa depan selalu mengambil to-infinitive sebagai objeknya.',
                    'examples' => [
                        [
                            'en' => 'Researchers attempt to quantify greenhouse gas emissions across metropolitan sectors.',
                            'id' => 'Peneliti berupaya mengukur emisi gas rumah kaca di berbagai sektor metropolitan.',
                            'note' => 'Bentuk "attempt quantifying" adalah keliru secara gramatikal.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Verba yang Wajib Diikuti Gerund (Proses, Inklusi & Penghindaran)',
                    'rule_formula' => 'Subject + (involve, avoid, consider, suggest, deny, include, practice, postpone) + GERUND (V-ing)',
                    'rule_description' => 'Kata kerja yang berorientasi pada aktivitas nyata, pelibatan proses, atau penolakan selalu mengambil gerund.',
                    'examples' => [
                        [
                            'en' => 'The proposed methodology involves extracting high-purity proteins from cultured tissues.',
                            'id' => 'Metodologi yang diusulkan melibatkan ekstraksi protein berkemurnian tinggi dari jaringan kultur.',
                            'note' => 'Gunakan "involves extracting", bukan "involves to extract".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Infinitive of Purpose vs Preposition + Gerund',
                    'rule_formula' => 'Clause + (in order) TO + V1 (Purpose) vs Clause + BY / WITHOUT / PRIOR TO + V-ing (Manner / Condition)',
                    'rule_description' => 'Gunakan to-infinitive untuk menyatakan tujuan pelaku subjek (misal: "to minimize error"), dan gunakan preposisi + gerund untuk menerangkan instrumen atau kondisi (misal: "by analyzing data", "prior to conducting trials"). Jangan pernah gunakan "for + V1" untuk tujuan.',
                    'examples' => [
                        [
                            'en' => 'Physicians calibrate sensors to prevent diagnostic discrepancies.',
                            'id' => 'Dokter mengkalibrasi sensor untuk mencegah diskrepansi diagnostik.',
                            'note' => 'Gunakan "to prevent", bukan "for prevent" atau "for preventing".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Pola Kausatif / Permisif: Verb + Object + To-Infinitive',
                    'rule_formula' => 'Subject + (enable, allow, require, compel, permit, cause) + Object + TO + V1',
                    'rule_description' => 'Dalam mendeskripsikan kapabilitas teknologi atau dampak variabel, subjek memicu objek melakukan tindakan tertentu.',
                    'examples' => [
                        [
                            'en' => 'Automated telemetry enables scientists to monitor seismic activity in real time.',
                            'id' => 'Telemetri otomatis memungkinkan ilmuwan memantau aktivitas seismik secara real-time.',
                            'note' => 'Wajib menyertakan objek sebelum to-infinitive ("enables scientists to monitor").'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Kategori Verbal', 'Kata Kerja Kunci', 'Pola Gramatikal', 'Contoh Kalimat Akademik'],
                'rows' => [
                    ['To-Infinitive Only', 'attempt, tend, aim, decide, fail, refuse', 'Verb + to + V1', 'The study aims to evaluate long-term outcomes.'],
                    ['Gerund Only', 'involve, avoid, consider, suggest, include', 'Verb + V-ing', 'The protocol avoids contaminating sterile samples.'],
                    ['Dual: Meaning Shift', 'try, stop, remember, regret', 'Verb + to + V1 vs V-ing', 'Try adjusting pH (test) vs try to stabilize (effort).'],
                    ['Infinitive of Purpose', 'to, in order to, so as to', 'Clause + to + V1', 'Recalibrated in order to minimize error.'],
                    ['Preposition + Gerund', 'by, without, upon, prior to, instead of', 'Prep + V-ing', 'Enhanced by combining multiple neural networks.'],
                    ['Transitive Object Pattern', 'enable, allow, require, permit', 'Verb + Object + to + V1', 'Enables analysts to identify subtle patterns.'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The experiment involves to analyze five distinct chemical compounds.',
                    'correct' => 'The experiment involves analyzing five distinct chemical compounds.',
                    'explanation' => 'Verba "involve" wajib diikuti oleh gerund (V-ing), bukan to-infinitive.'
                ],
                [
                    'incorrect' => 'Scientists centrifuge the samples for isolate the target protein.',
                    'correct' => 'Scientists centrifuge the samples to isolate the target protein. (atau: in order to isolate)',
                    'explanation' => 'Tujuan tindakan peneliti wajib dinyatakan dengan to-infinitive ("to isolate"), dilarang menggunakan "for + V1".'
                ],
                [
                    'incorrect' => 'Prior to conduct the clinical trial, authors obtained ethical clearance.',
                    'correct' => 'Prior to conducting the clinical trial, authors obtained ethical clearance.',
                    'explanation' => 'Dalam frasa "prior to", kata "to" adalah preposisi waktu, sehingga wajib diikuti gerund ("conducting").'
                ],
                [
                    'incorrect' => 'The software enables to process massive satellite imagery datasets.',
                    'correct' => 'The software enables researchers to process massive satellite imagery datasets.',
                    'explanation' => 'Verba "enable" adalah transitif dan memerlukan objek sebelum to-infinitive ("enables researchers to process").'
                ],
            ],
            'exam_tips' => [
                'Hafalkan daftar kata kerja "infinitive only" vs "gerund only" agar tidak kehilangan poin akurasi tata bahasa di IELTS/TOEFL Writing.',
                'Gunakan pola "Verb + Object + To-Infinitive" (seperti enables X to Y, allows A to B) untuk menyusun argumen sebab-akibat teknologi yang elegan.',
                'Waspadai preposisi yang berakhiran "to" (committed to, prior to, with a view to) yang selalu diikuti Gerund V-ing, bukan bare verb.'
            ],
        ];
    }

    /**
     * Complete list of 8 sub-lessons for Topic 1.6
     */
    public static function getSubLessons(): array
    {
        return [
          [
            'id' => 'verbs_to_infinitive',
            'name' => 'Verbs Exclusively Followed by To-Infinitive (attempt, tend, aim, decide, fail)',
            'code' => '1.6.1',
            'concept_title' => 'Kata Kerja Akademik yang Wajib Diikuti To-Infinitive',
            'concept_description' => 'Dalam penulisan ilmiah, kata kerja yang menyatakan intensi, usaha, tujuan, atau kecenderungan (seperti attempt, tend, aim, decide, fail, refuse, intend, hesitate) wajib mengambil \'to-infinitive\' (to + V1) sebagai komplemen verbalnya. Bentuk gerund (V-ing) dilarang digunakan setelah kata kerja kelompok ini.',
            'formula' => 'Subject + ATTEMPT / TEND / AIM / FAIL / DECIDE / REFUSE + TO + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan to-infinitive (to + V1) setelah kata kerja: attempt, tend, aim, decide, fail, refuse, intend, hesitate, struggle.',
              'Dilarang menggunakan to + Gerund (misal: \'tend to showing\' ➔ SALAH; \'tend to show\' ➔ BENAR).',
              'Dalam kalimat pasif atau nominal, to-infinitive tetap mempertahankan bentuk dasar (misal: \'aims to be\', \'attempts to clarify\').',
              'Kata kerja \'fail\' sering dipakai sebagai hedging akademis untuk menyatakan ketiadaan efek (misal: \'fails to demonstrate\').',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Para peneliti berupaya untuk mengukur dampak polusi mikroplastik terhadap organisme laut.',
                'target_word' => 'attempt to quantify',
                'vocab' => [
                  'attempt' => [
                    'id' => 'berupaya / mencoba',
                    'pos' => '(v)',
                  ],
                  'quantify' => [
                    'id' => 'mengukur secara kuantitatif',
                    'pos' => '(v)',
                  ],
                  'microplastic pollution' => [
                    'id' => 'polusi mikroplastik',
                    'pos' => '(n phr)',
                  ],
                  'marine organisms' => [
                    'id' => 'organisme laut',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers attempt to quantify the impact of microplastic pollution on marine organisms.',
                  'Researchers attempt quantifying the impact of microplastic pollution on marine organisms.',
                  'Researchers attempt quantify the impact of microplastic pollution on marine organisms.',
                  'Researchers attempt to quantifying the impact of microplastic pollution on marine organisms.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'attempt\' wajib diikuti to-infinitive (\'to quantify\'), bukan gerund atau bare verb.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Negara-negara berkembang cenderung mengalami pertumbuhan demografi yang lebih cepat di wilayah perkotaan.',
                'target_word' => 'tend to experience',
                'vocab' => [
                  'developing nations' => [
                    'id' => 'negara-negara berkembang',
                    'pos' => '(n phr)',
                  ],
                  'tend' => [
                    'id' => 'cenderung',
                    'pos' => '(v)',
                  ],
                  'demographic growth' => [
                    'id' => 'pertumbuhan demografi',
                    'pos' => '(n phr)',
                  ],
                  'urban regions' => [
                    'id' => 'wilayah perkotaan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Developing nations tend to experience more rapid demographic growth in urban regions.',
                  'Developing nations tend experiencing more rapid demographic growth in urban regions.',
                  'Developing nations tend to experiencing more rapid demographic growth in urban regions.',
                  'Developing nations tend experience more rapid demographic growth in urban regions.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'tend\' selalu diikuti to-infinitive (\'tend to experience\').',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Studi percontohan ini bertujuan untuk mengevaluasi efektivitas terapi imunologis baru.',
                'target_word' => 'aims to evaluate',
                'vocab' => [
                  'pilot study' => [
                    'id' => 'studi percontohan / awal',
                    'pos' => '(n phr)',
                  ],
                  'aim' => [
                    'id' => 'bertujuan',
                    'pos' => '(v)',
                  ],
                  'evaluate' => [
                    'id' => 'mengevaluasi',
                    'pos' => '(v)',
                  ],
                  'effectiveness' => [
                    'id' => 'efektivitas',
                    'pos' => '(n)',
                  ],
                  'immunological therapy' => [
                    'id' => 'terapi imunologis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This pilot study aims to evaluate the effectiveness of the novel immunological therapy.',
                  'This pilot study aims evaluating the effectiveness of the novel immunological therapy.',
                  'This pilot study aims to evaluating the effectiveness of the novel immunological therapy.',
                  'This pilot study aims evaluate the effectiveness of the novel immunological therapy.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'aim\' berpasangan dengan to-infinitive (\'aims to evaluate\') untuk menyatakan tujuan penelitian.',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Model ekonomi standar gagal menjelaskan fluktuasi pasar modal selama krisis likuiditas.',
                'target_word' => 'fails to explain',
                'vocab' => [
                  'standard economic model' => [
                    'id' => 'model ekonomi standar',
                    'pos' => '(n phr)',
                  ],
                  'fail' => [
                    'id' => 'gagal',
                    'pos' => '(v)',
                  ],
                  'explain' => [
                    'id' => 'menjelaskan',
                    'pos' => '(v)',
                  ],
                  'capital market fluctuations' => [
                    'id' => 'fluktuasi pasar modal',
                    'pos' => '(n phr)',
                  ],
                  'liquidity crisis' => [
                    'id' => 'krisis likuiditas',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The standard economic model fails to explain capital market fluctuations during a liquidity crisis.',
                  'The standard economic model fails explaining capital market fluctuations during a liquidity crisis.',
                  'The standard economic model fails to explaining capital market fluctuations during a liquidity crisis.',
                  'The standard economic model fails in explain capital market fluctuations during a liquidity crisis.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'fail\' membutuhkan to-infinitive (\'fails to explain\').',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Dewan penguji memutuskan untuk memperpanjang batas waktu pengumpulan laporan disertasi.',
                'target_word' => 'decides to extend',
                'vocab' => [
                  'examination board' => [
                    'id' => 'dewan penguji',
                    'pos' => '(n phr)',
                  ],
                  'decide' => [
                    'id' => 'memutuskan',
                    'pos' => '(v)',
                  ],
                  'extend' => [
                    'id' => 'memperpanjang',
                    'pos' => '(v)',
                  ],
                  'deadline' => [
                    'id' => 'batas waktu / tenggat',
                    'pos' => '(n)',
                  ],
                  'dissertation report' => [
                    'id' => 'laporan disertasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The examination board decides to extend the submission deadline for the dissertation report.',
                  'The examination board decides extending the submission deadline for the dissertation report.',
                  'The examination board decides to extending the submission deadline for the dissertation report.',
                  'The examination board decides extend the submission deadline for the dissertation report.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'decide\' berpasangan dengan to-infinitive (\'decides to extend\').',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Perusahaan farmasi tersebut menolak untuk mempublikasikan data mentah uji klinis tahap awal.',
                'target_word' => 'refuses to publish',
                'vocab' => [
                  'pharmaceutical company' => [
                    'id' => 'perusahaan farmasi',
                    'pos' => '(n phr)',
                  ],
                  'refuse' => [
                    'id' => 'menolak',
                    'pos' => '(v)',
                  ],
                  'publish' => [
                    'id' => 'mempublikasikan',
                    'pos' => '(v)',
                  ],
                  'raw data' => [
                    'id' => 'data mentah',
                    'pos' => '(n phr)',
                  ],
                  'clinical trials' => [
                    'id' => 'uji klinis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The pharmaceutical company refuses to publish the raw data of the early-stage clinical trials.',
                  'The pharmaceutical company refuses publishing the raw data of the early-stage clinical trials.',
                  'The pharmaceutical company refuses to publishing the raw data of the early-stage clinical trials.',
                  'The pharmaceutical company refuses publish the raw data of the early-stage clinical trials.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'refuse\' diikuti to-infinitive (\'refuses to publish\').',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Para insinyur berencana untuk menguji paduan titanium di bawah kondisi suhu ekstrem.',
                'target_word' => 'plan to test',
                'vocab' => [
                  'engineers' => [
                    'id' => 'para insinyur',
                    'pos' => '(n)',
                  ],
                  'plan' => [
                    'id' => 'berencana',
                    'pos' => '(v)',
                  ],
                  'test' => [
                    'id' => 'menguji',
                    'pos' => '(v)',
                  ],
                  'titanium alloy' => [
                    'id' => 'paduan titanium',
                    'pos' => '(n phr)',
                  ],
                  'extreme temperature conditions' => [
                    'id' => 'kondisi suhu ekstrem',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers plan to test the titanium alloy under extreme temperature conditions.',
                  'Engineers plan testing the titanium alloy under extreme temperature conditions.',
                  'Engineers plan to testing the titanium alloy under extreme temperature conditions.',
                  'Engineers plan test the titanium alloy under extreme temperature conditions.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'plan\' wajib diikuti to-infinitive (\'plan to test\').',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Komite etik ragu-ragu untuk menyetujui eksperimen rekayasa genetika tersebut.',
                'target_word' => 'hesitates to approve',
                'vocab' => [
                  'ethics committee' => [
                    'id' => 'komite etik',
                    'pos' => '(n phr)',
                  ],
                  'hesitate' => [
                    'id' => 'ragu-ragu / enggan',
                    'pos' => '(v)',
                  ],
                  'approve' => [
                    'id' => 'menyetujui',
                    'pos' => '(v)',
                  ],
                  'genetic engineering experiment' => [
                    'id' => 'eksperimen rekayasa genetika',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The ethics committee hesitates to approve the genetic engineering experiment.',
                  'The ethics committee hesitates approving the genetic engineering experiment.',
                  'The ethics committee hesitates to approving the genetic engineering experiment.',
                  'The ethics committee hesitates approve the genetic engineering experiment.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'hesitate\' berpasangan dengan to-infinitive (\'hesitates to approve\').',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Pemerintah berniat untuk menerapkan regulasi emisi karbon yang lebih ketat pada sektor manufaktur.',
                'target_word' => 'intends to implement',
                'vocab' => [
                  'government' => [
                    'id' => 'pemerintah',
                    'pos' => '(n)',
                  ],
                  'intend' => [
                    'id' => 'berniat / bermaksud',
                    'pos' => '(v)',
                  ],
                  'implement' => [
                    'id' => 'menerapkan',
                    'pos' => '(v)',
                  ],
                  'stricter carbon emission regulations' => [
                    'id' => 'regulasi emisi karbon yang lebih ketat',
                    'pos' => '(n phr)',
                  ],
                  'manufacturing sector' => [
                    'id' => 'sektor manufaktur',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The government intends to implement stricter carbon emission regulations in the manufacturing sector.',
                  'The government intends implementing stricter carbon emission regulations in the manufacturing sector.',
                  'The government intends to implementing stricter carbon emission regulations in the manufacturing sector.',
                  'The government intends implement stricter carbon emission regulations in the manufacturing sector.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'intend\' lazim diikuti to-infinitive (\'intends to implement\') dalam konteks kebijakan formal.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Universitas berharap untuk menarik lebih banyak peneliti pascadoktoral internasional tahun ini.',
                'target_word' => 'hopes to attract',
                'vocab' => [
                  'university' => [
                    'id' => 'universitas',
                    'pos' => '(n)',
                  ],
                  'hope' => [
                    'id' => 'berharap',
                    'pos' => '(v)',
                  ],
                  'attract' => [
                    'id' => 'menarik',
                    'pos' => '(v)',
                  ],
                  'postdoctoral researchers' => [
                    'id' => 'peneliti pascadoktoral',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The university hopes to attract more international postdoctoral researchers this year.',
                  'The university hopes attracting more international postdoctoral researchers this year.',
                  'The university hopes to attracting more international postdoctoral researchers this year.',
                  'The university hopes attract more international postdoctoral researchers this year.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'hope\' diikuti to-infinitive (\'hopes to attract\').',
              ],
            ],
          ],
          [
            'id' => 'verbs_gerund',
            'name' => 'Verbs Exclusively Followed by Gerund (involve, avoid, consider, suggest, deny)',
            'code' => '1.6.2',
            'concept_title' => 'Kata Kerja Akademik yang Wajib Diikuti Gerund (V-ing)',
            'concept_description' => 'Kelompok kata kerja yang mendeskripsikan proses, penyangkalan, pertimbangan, penghindaran, atau saran prosedur (seperti involve, avoid, consider, suggest, deny, include, practice, postpone, recommend) wajib mengambil \'gerund\' (V-ing) sebagai objek langsungnya. Menggunakan to-infinitive setelah kata kerja ini merupakan kesalahan gramatikal fatal dalam esai TOEFL/IELTS dan jurnal ilmiah.',
            'formula' => 'Subject + INVOLVE / AVOID / CONSIDER / SUGGEST / DENY / INCLUDE + GERUND (V-ing) + Object',
            'rules' => [
              'Gunakan Gerund (V-ing) setelah kata kerja: involve, avoid, consider, suggest, deny, include, practice, postpone, recommend, risk.',
              'Dilarang menggunakan to-infinitive setelah kata kerja ini (misal: \'involves to synthesize\' ➔ SALAH; \'involves synthesizing\' ➔ BENAR).',
              'Setelah verba saran seperti \'suggest\' atau \'recommend\', gunakan Gerund untuk rujukan umum (misal: \'The authors recommend replicating the trial\').',
              'Dalam konstruksi pasif atau negatif, bentuk gerund tetap berlaku (\'avoid being contaminated\').',
            ],
            'exercises' => [
              [
                'id' => 11,
                'id_sentence' => 'Prosedur laboratorium ini melibatkan pengekstrakan DNA dari sampel darah beku.',
                'target_word' => 'involves extracting',
                'vocab' => [
                  'laboratory procedure' => [
                    'id' => 'prosedur laboratorium',
                    'pos' => '(n phr)',
                  ],
                  'involve' => [
                    'id' => 'melibatkan',
                    'pos' => '(v)',
                  ],
                  'extract' => [
                    'id' => 'mengekstrak',
                    'pos' => '(v)',
                  ],
                  'frozen blood samples' => [
                    'id' => 'sampel darah beku',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This laboratory procedure involves extracting DNA from frozen blood samples.',
                  'This laboratory procedure involves to extract DNA from frozen blood samples.',
                  'This laboratory procedure involves extract DNA from frozen blood samples.',
                  'This laboratory procedure involves to extracting DNA from frozen blood samples.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'involve\' wajib diikuti gerund (\'involves extracting\'), bukan to-infinitive.',
              ],
              [
                'id' => 12,
                'id_sentence' => 'Para peneliti mengambil tindakan pencegahan ketat untuk menghindari kontaminasi kultur sel steril.',
                'target_word' => 'avoid contaminating',
                'vocab' => [
                  'strict precautions' => [
                    'id' => 'tindakan pencegahan ketat',
                    'pos' => '(n phr)',
                  ],
                  'avoid' => [
                    'id' => 'menghindari',
                    'pos' => '(v)',
                  ],
                  'contaminate' => [
                    'id' => 'mengontaminasi',
                    'pos' => '(v)',
                  ],
                  'sterile cell cultures' => [
                    'id' => 'kultur sel steril',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers take strict precautions to avoid contaminating sterile cell cultures.',
                  'Researchers take strict precautions to avoid to contaminate sterile cell cultures.',
                  'Researchers take strict precautions to avoid contaminate sterile cell cultures.',
                  'Researchers take strict precautions to avoid in contaminating sterile cell cultures.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'avoid\' wajib mengambil gerund (\'avoid contaminating\').',
              ],
              [
                'id' => 13,
                'id_sentence' => 'Komite peninjau mempertimbangkan pengalokasian dana hibah tambahan untuk penelitian kanker.',
                'target_word' => 'considers allocating',
                'vocab' => [
                  'review committee' => [
                    'id' => 'komite peninjau',
                    'pos' => '(n phr)',
                  ],
                  'consider' => [
                    'id' => 'mempertimbangkan',
                    'pos' => '(v)',
                  ],
                  'allocate' => [
                    'id' => 'mengalokasikan',
                    'pos' => '(v)',
                  ],
                  'grant funding' => [
                    'id' => 'dana hibah',
                    'pos' => '(n phr)',
                  ],
                  'cancer research' => [
                    'id' => 'penelitian kanker',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The review committee considers allocating additional grant funding for cancer research.',
                  'The review committee considers to allocate additional grant funding for cancer research.',
                  'The review committee considers allocate additional grant funding for cancer research.',
                  'The review committee considers to allocating additional grant funding for cancer research.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'consider\' diikuti gerund (\'considers allocating\') saat bertindak sebagai objek verbal langsung.',
              ],
              [
                'id' => 14,
                'id_sentence' => 'Penulis menyarankan pengulangan analisis statistik dengan ukuran sampel yang lebih besar.',
                'target_word' => 'suggests repeating',
                'vocab' => [
                  'author' => [
                    'id' => 'penulis',
                    'pos' => '(n)',
                  ],
                  'suggest' => [
                    'id' => 'menyarankan',
                    'pos' => '(v)',
                  ],
                  'repeat' => [
                    'id' => 'mengulang',
                    'pos' => '(v)',
                  ],
                  'statistical analysis' => [
                    'id' => 'analisis statistik',
                    'pos' => '(n phr)',
                  ],
                  'sample size' => [
                    'id' => 'ukuran sampel',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The author suggests repeating the statistical analysis with a larger sample size.',
                  'The author suggests to repeat the statistical analysis with a larger sample size.',
                  'The author suggests repeat the statistical analysis with a larger sample size.',
                  'The author suggests to repeating the statistical analysis with a larger sample size.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'suggest\' mengambil bentuk gerund (\'suggests repeating\'), bukan to-infinitive.',
              ],
              [
                'id' => 15,
                'id_sentence' => 'Juru bicara kementerian membantah memanipulasi data indikator ekonomi kuartal ketiga.',
                'target_word' => 'denies manipulating',
                'vocab' => [
                  'ministry spokesperson' => [
                    'id' => 'juru bicara kementerian',
                    'pos' => '(n phr)',
                  ],
                  'deny' => [
                    'id' => 'membantah',
                    'pos' => '(v)',
                  ],
                  'manipulate' => [
                    'id' => 'memanipulasi',
                    'pos' => '(v)',
                  ],
                  'economic indicator data' => [
                    'id' => 'data indikator ekonomi',
                    'pos' => '(n phr)',
                  ],
                  'third quarter' => [
                    'id' => 'kuartal ketiga',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The ministry spokesperson denies manipulating third-quarter economic indicator data.',
                  'The ministry spokesperson denies to manipulate third-quarter economic indicator data.',
                  'The ministry spokesperson denies manipulate third-quarter economic indicator data.',
                  'The ministry spokesperson denies to manipulating third-quarter economic indicator data.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'deny\' wajib diikuti gerund (\'denies manipulating\').',
              ],
              [
                'id' => 16,
                'id_sentence' => 'Rencana reformasi kurikulum mencakup pengintegrasian modul kecerdasan buatan ke dalam ilmu sains.',
                'target_word' => 'includes integrating',
                'vocab' => [
                  'curriculum reform plan' => [
                    'id' => 'rencana reformasi kurikulum',
                    'pos' => '(n phr)',
                  ],
                  'include' => [
                    'id' => 'mencakup / meliputi',
                    'pos' => '(v)',
                  ],
                  'integrate' => [
                    'id' => 'mengintegrasikan',
                    'pos' => '(v)',
                  ],
                  'artificial intelligence modules' => [
                    'id' => 'modul kecerdasan buatan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The curriculum reform plan includes integrating artificial intelligence modules into science courses.',
                  'The curriculum reform plan includes to integrate artificial intelligence modules into science courses.',
                  'The curriculum reform plan includes integrate artificial intelligence modules into science courses.',
                  'The curriculum reform plan includes to integrating artificial intelligence modules into science courses.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'include\' berpasangan dengan gerund (\'includes integrating\').',
              ],
              [
                'id' => 17,
                'id_sentence' => 'Para mahasiswa kedokteran berlatih melakukan intubasi endotrakeal pada simulator anatomi.',
                'target_word' => 'practice performing',
                'vocab' => [
                  'medical students' => [
                    'id' => 'mahasiswa kedokteran',
                    'pos' => '(n phr)',
                  ],
                  'practice' => [
                    'id' => 'berlatih',
                    'pos' => '(v)',
                  ],
                  'perform' => [
                    'id' => 'melakukan / melaksanakan',
                    'pos' => '(v)',
                  ],
                  'endotracheal intubation' => [
                    'id' => 'intubasi endotrakeal',
                    'pos' => '(n phr)',
                  ],
                  'anatomical simulators' => [
                    'id' => 'simulator anatomi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Medical students practice performing endotracheal intubation on anatomical simulators.',
                  'Medical students practice to perform endotracheal intubation on anatomical simulators.',
                  'Medical students practice perform endotracheal intubation on anatomical simulators.',
                  'Medical students practice to performing endotracheal intubation on anatomical simulators.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'practice\' diikuti gerund (\'practice performing\').',
              ],
              [
                'id' => 18,
                'id_sentence' => 'Tim ekspedisi menunda peluncuran penyelaman laut dalam karena kondisi cuaca buruk.',
                'target_word' => 'postpones launching',
                'vocab' => [
                  'expedition team' => [
                    'id' => 'tim ekspedisi',
                    'pos' => '(n phr)',
                  ],
                  'postpone' => [
                    'id' => 'menunda',
                    'pos' => '(v)',
                  ],
                  'launch' => [
                    'id' => 'meluncurkan',
                    'pos' => '(v)',
                  ],
                  'deep-sea dive' => [
                    'id' => 'penyelaman laut dalam',
                    'pos' => '(n phr)',
                  ],
                  'severe weather conditions' => [
                    'id' => 'kondisi cuaca buruk',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The expedition team postpones launching the deep-sea dive due to severe weather conditions.',
                  'The expedition team postpones to launch the deep-sea dive due to severe weather conditions.',
                  'The expedition team postpones launch the deep-sea dive due to severe weather conditions.',
                  'The expedition team postpones to launching the deep-sea dive due to severe weather conditions.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'postpone\' wajib mengambil gerund (\'postpones launching\').',
              ],
              [
                'id' => 19,
                'id_sentence' => 'Laporan keselamatan tersebut merekomendasikan penggantian pipa pendingin reaktor nuklir yang usang.',
                'target_word' => 'recommends replacing',
                'vocab' => [
                  'safety report' => [
                    'id' => 'laporan keselamatan',
                    'pos' => '(n phr)',
                  ],
                  'recommend' => [
                    'id' => 'merekomendasikan',
                    'pos' => '(v)',
                  ],
                  'replace' => [
                    'id' => 'mengganti',
                    'pos' => '(v)',
                  ],
                  'obsolete cooling pipes' => [
                    'id' => 'pipa pendingin usang',
                    'pos' => '(n phr)',
                  ],
                  'nuclear reactor' => [
                    'id' => 'reaktor nuklir',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The safety report recommends replacing obsolete nuclear reactor cooling pipes.',
                  'The safety report recommends to replace obsolete nuclear reactor cooling pipes.',
                  'The safety report recommends replace obsolete nuclear reactor cooling pipes.',
                  'The safety report recommends to replacing obsolete nuclear reactor cooling pipes.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'recommend\' tanpa direct personal object diikuti oleh gerund (\'recommends replacing\').',
              ],
              [
                'id' => 20,
                'id_sentence' => 'Spesies burung langka tersebut menghadapi risiko kepunahan jika deforestasi terus berlanjut.',
                'target_word' => 'risks facing',
                'vocab' => [
                  'rare avian species' => [
                    'id' => 'spesies burung langka',
                    'pos' => '(n phr)',
                  ],
                  'risk' => [
                    'id' => 'menghadapi risiko / berisiko',
                    'pos' => '(v)',
                  ],
                  'extinction' => [
                    'id' => 'kepunahan',
                    'pos' => '(n)',
                  ],
                  'deforestation' => [
                    'id' => 'deforestasi',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The rare avian species risks facing extinction if deforestation continues unabated.',
                  'The rare avian species risks to face extinction if deforestation continues unabated.',
                  'The rare avian species risks face extinction if deforestation continues unabated.',
                  'The rare avian species risks to facing extinction if deforestation continues unabated.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'risk\' wajib mengambil gerund (\'risks facing\').',
              ],
            ],
          ],
          [
            'id' => 'dual_meaning_shift',
            'name' => 'Dual-Pattern Verbs with Meaning Shift (stop, try, remember, regret)',
            'code' => '1.6.3',
            'concept_title' => 'Verba Bermakna Ganda: Perbedaan Makna To-Infinitive vs Gerund',
            'concept_description' => 'Beberapa kata kerja dapat diikuti oleh to-infinitive maupun gerund, namun menghasilkan implikasi semantik yang sangat berbeda. Dalam konteks eksperimen ilmiah:
- \'try to + V1\' berarti mengerahkan tenaga untuk mencapai target sulit (attempt), sedangkan \'try + V-ing\' berarti menguji metode atau perlakuan baru sebagai eksperimen (experiment with a technique).
- \'stop to + V1\' berarti berhenti dari suatu aktivitas demi melakukan hal lain (pause in order to), sedangkan \'stop + V-ing\' berarti menghentikan atau mengakhiri tindakan tersebut secara permanen/sementara (cease an activity).
- \'regret to inform\' (menyesal harus mengumumkan kabar buruk) vs \'regret publishing\' (menyesali tindakan di masa lalu).',
            'formula' => 'TRY TO + V1 (Effort) vs TRY + V-ING (Experiment) | STOP TO + V1 (Purpose) vs STOP + V-ING (Cease)',
            'rules' => [
              'Pahami perbedaan esensial antara try to + V1 (upaya keras mengatasi rintangan) dan try + V-ing (mencoba metode alternatif untuk melihat hasilnya).',
              'Pahami perbedaan antara stop to + V1 (jeda demi tujuan lain) dan stop + V-ing (berhenti melakukan tindakan tersebut).',
              'Dalam laporan riset, gunakan \'try adjusting\' saat menguji variasi konsentrasi kimiawi, dan \'try to achieve\' saat berusaha mencapai target presisi.',
              'Gunakan \'remember to do\' untuk kewajiban protokol dan \'remember doing\' untuk memori pengalaman lampau.',
            ],
            'exercises' => [
              [
                'id' => 21,
                'id_sentence' => 'Para kimiawan mencoba menyesuaikan tingkat pH untuk melihat apakah laju pengendapan meningkat.',
                'target_word' => 'try adjusting',
                'vocab' => [
                  'chemists' => [
                    'id' => 'para kimiawan',
                    'pos' => '(n)',
                  ],
                  'try' => [
                    'id' => 'mencoba (metode alternatif)',
                    'pos' => '(v)',
                  ],
                  'adjust' => [
                    'id' => 'menyesuaikan',
                    'pos' => '(v)',
                  ],
                  'pH levels' => [
                    'id' => 'tingkat pH',
                    'pos' => '(n phr)',
                  ],
                  'precipitation rate' => [
                    'id' => 'laju pengendapan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The chemists try adjusting the pH levels to observe whether the precipitation rate accelerates.',
                  'The chemists try to adjust the pH levels to observe whether the precipitation rate accelerates.',
                  'The chemists try adjust the pH levels to observe whether the precipitation rate accelerates.',
                  'The chemists try to adjusting the pH levels to observe whether the precipitation rate accelerates.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Try adjusting (V-ing)\' bermakna menguji coba perlakuan atau metode alternatif sebagai eksperimen untuk melihat efeknya.',
              ],
              [
                'id' => 22,
                'id_sentence' => 'Para insinyur berusaha keras untuk menstabilkan voltase jaringan listrik selama lonjakan beban puncak.',
                'target_word' => 'try to stabilize',
                'vocab' => [
                  'engineers' => [
                    'id' => 'para insinyur',
                    'pos' => '(n)',
                  ],
                  'try' => [
                    'id' => 'berusaha keras',
                    'pos' => '(v)',
                  ],
                  'stabilize' => [
                    'id' => 'menstabilkan',
                    'pos' => '(v)',
                  ],
                  'grid voltage' => [
                    'id' => 'voltase jaringan listrik',
                    'pos' => '(n phr)',
                  ],
                  'peak load surge' => [
                    'id' => 'lonjakan beban puncak',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers try to stabilize grid voltage during the sudden peak load surge.',
                  'Engineers try stabilizing grid voltage during the sudden peak load surge.',
                  'Engineers try stabilize grid voltage during the sudden peak load surge.',
                  'Engineers try to stabilizing grid voltage during the sudden peak load surge.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Try to stabilize (to + V1)\' bermakna mengerahkan upaya keras untuk mengatasi kendala atau rintangan berat.',
              ],
              [
                'id' => 23,
                'id_sentence' => 'Pabrik peleburan tersebut berhenti membuang limbah cair beracun ke sungai setempat.',
                'target_word' => 'stops discharging',
                'vocab' => [
                  'smelting plant' => [
                    'id' => 'pabrik peleburan',
                    'pos' => '(n phr)',
                  ],
                  'stop' => [
                    'id' => 'berhenti / menghentikan tindakan',
                    'pos' => '(v)',
                  ],
                  'discharge' => [
                    'id' => 'membuang / melepaskan',
                    'pos' => '(v)',
                  ],
                  'toxic effluent' => [
                    'id' => 'limbah cair beracun',
                    'pos' => '(n phr)',
                  ],
                  'local river' => [
                    'id' => 'sungai setempat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The smelting plant stops discharging toxic effluent into the local river.',
                  'The smelting plant stops to discharge toxic effluent into the local river.',
                  'The smelting plant stops discharge toxic effluent into the local river.',
                  'The smelting plant stops in discharging toxic effluent into the local river.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Stop discharging (V-ing)\' berarti menghentikan secara total tindakan pembuangan limbah.',
              ],
              [
                'id' => 24,
                'id_sentence' => 'Di tengah percobaan, peneliti berhenti sejenak untuk memeriksa kalibrasi spektrometer.',
                'target_word' => 'stops to verify',
                'vocab' => [
                  'experiment' => [
                    'id' => 'percobaan / eksperimen',
                    'pos' => '(n)',
                  ],
                  'stop' => [
                    'id' => 'berhenti sejenak untuk',
                    'pos' => '(v)',
                  ],
                  'verify' => [
                    'id' => 'memeriksa / memverifikasi',
                    'pos' => '(v)',
                  ],
                  'spectrometer calibration' => [
                    'id' => 'kalibrasi spektrometer',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Midway through the experiment, the researcher stops to verify the spectrometer calibration.',
                  'Midway through the experiment, the researcher stops verifying the spectrometer calibration.',
                  'Midway through the experiment, the researcher stops verify the spectrometer calibration.',
                  'Midway through the experiment, the researcher stops for verifying the spectrometer calibration.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Stop to verify (to + V1)\' bermakna menjeda kegiatan yang sedang berjalan dengan tujuan memeriksa instrumen.',
              ],
              [
                'id' => 25,
                'id_sentence' => 'Penulis menyesal harus menyatakan bahwa data longitudinal tersebut memiliki anomali yang signifikan.',
                'target_word' => 'regrets to state',
                'vocab' => [
                  'author' => [
                    'id' => 'penulis',
                    'pos' => '(n)',
                  ],
                  'regret' => [
                    'id' => 'menyesal harus menyatakan (berita buruk)',
                    'pos' => '(v)',
                  ],
                  'state' => [
                    'id' => 'menyatakan',
                    'pos' => '(v)',
                  ],
                  'longitudinal dataset' => [
                    'id' => 'data longitudinal',
                    'pos' => '(n phr)',
                  ],
                  'significant anomalies' => [
                    'id' => 'anomali signifikan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The author regrets to state that the longitudinal dataset exhibits significant anomalies.',
                  'The author regrets stating that the longitudinal dataset exhibits significant anomalies.',
                  'The author regrets state that the longitudinal dataset exhibits significant anomalies.',
                  'The author regrets to stating that the longitudinal dataset exhibits significant anomalies.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Regret to state (to + V1)\' adalah frasa formal akademis untuk menyampaikan informasi yang tidak menyenangkan.',
              ],
              [
                'id' => 26,
                'id_sentence' => 'Asisten laboratorium selalu ingat untuk mensterilkan instrumen bedah sebelum setiap prosedur.',
                'target_word' => 'remembers to sterilize',
                'vocab' => [
                  'laboratory assistant' => [
                    'id' => 'asisten laboratorium',
                    'pos' => '(n phr)',
                  ],
                  'remember' => [
                    'id' => 'ingat untuk (tugas/protokol)',
                    'pos' => '(v)',
                  ],
                  'sterilize' => [
                    'id' => 'mensterilkan',
                    'pos' => '(v)',
                  ],
                  'surgical instruments' => [
                    'id' => 'instrumen bedah',
                    'pos' => '(n phr)',
                  ],
                  'procedure' => [
                    'id' => 'prosedur',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The laboratory assistant always remembers to sterilize surgical instruments before every procedure.',
                  'The laboratory assistant always remembers sterilizing surgical instruments before every procedure.',
                  'The laboratory assistant always remembers sterilize surgical instruments before every procedure.',
                  'The laboratory assistant always remembers to sterilizing surgical instruments before every procedure.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Remember to sterilize (to + V1)\' berarti mengingat suatu kewajiban/tugas yang harus dilaksanakan.',
              ],
              [
                'id' => 27,
                'id_sentence' => 'Teknisi tidak boleh lupa untuk mengunci katup tekanan sebelum meninggalkan area fasilitas.',
                'target_word' => 'forget to lock',
                'vocab' => [
                  'technicians' => [
                    'id' => 'para teknisi',
                    'pos' => '(n)',
                  ],
                  'forget' => [
                    'id' => 'lupa',
                    'pos' => '(v)',
                  ],
                  'lock' => [
                    'id' => 'mengunci',
                    'pos' => '(v)',
                  ],
                  'pressure valves' => [
                    'id' => 'katup tekanan',
                    'pos' => '(n phr)',
                  ],
                  'facility area' => [
                    'id' => 'area fasilitas',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Technicians must not forget to lock the pressure valves before departing the facility area.',
                  'Technicians must not forget locking the pressure valves before departing the facility area.',
                  'Technicians must not forget lock the pressure valves before departing the facility area.',
                  'Technicians must not forget to locking the pressure valves before departing the facility area.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Forget to lock (to + V1)\' berarti lalai dalam mengerjakan suatu tugas yang seharusnya dilakukan.',
              ],
              [
                'id' => 28,
                'id_sentence' => 'Pengembang perangkat lunak mencoba menerapkan algoritma kompresi baru untuk mempercepat transmisi data.',
                'target_word' => 'try applying',
                'vocab' => [
                  'software developers' => [
                    'id' => 'pengembang perangkat lunak',
                    'pos' => '(n phr)',
                  ],
                  'try' => [
                    'id' => 'mencoba (metode baru)',
                    'pos' => '(v)',
                  ],
                  'apply' => [
                    'id' => 'menerapkan',
                    'pos' => '(v)',
                  ],
                  'compression algorithm' => [
                    'id' => 'algoritma kompresi',
                    'pos' => '(n phr)',
                  ],
                  'data transmission' => [
                    'id' => 'transmisi data',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Software developers try applying a novel compression algorithm to accelerate data transmission.',
                  'Software developers try to apply a novel compression algorithm to accelerate data transmission.',
                  'Software developers try apply a novel compression algorithm to accelerate data transmission.',
                  'Software developers try to applying a novel compression algorithm to accelerate data transmission.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Try applying (V-ing)\' bermakna menguji coba implementasi teknik baru untuk mengamati performanya.',
              ],
              [
                'id' => 29,
                'id_sentence' => 'Banyak negara industri berhenti menggunakan batu bara untuk pembangkit listrik termal.',
                'target_word' => 'stop utilizing',
                'vocab' => [
                  'industrialized nations' => [
                    'id' => 'negara-negara industri',
                    'pos' => '(n phr)',
                  ],
                  'stop' => [
                    'id' => 'berhenti / menyetop',
                    'pos' => '(v)',
                  ],
                  'utilize' => [
                    'id' => 'memanfaatkan / menggunakan',
                    'pos' => '(v)',
                  ],
                  'coal' => [
                    'id' => 'batu bara',
                    'pos' => '(n)',
                  ],
                  'thermal power plants' => [
                    'id' => 'pembangkit listrik termal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Many industrialized nations stop utilizing coal for thermal power generation.',
                  'Many industrialized nations stop to utilize coal for thermal power generation.',
                  'Many industrialized nations stop utilize coal for thermal power generation.',
                  'Many industrialized nations stop of utilizing coal for thermal power generation.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Stop utilizing (V-ing)\' bermakna menghentikan penggunaan batu bara secara permanen.',
              ],
              [
                'id' => 30,
                'id_sentence' => 'Peserta konferensi berhenti untuk mencatat poin-poin utama selama presentasi pleno.',
                'target_word' => 'stop to record',
                'vocab' => [
                  'conference participants' => [
                    'id' => 'peserta konferensi',
                    'pos' => '(n phr)',
                  ],
                  'stop' => [
                    'id' => 'berhenti sejenak untuk',
                    'pos' => '(v)',
                  ],
                  'record' => [
                    'id' => 'mencatat / merekam',
                    'pos' => '(v)',
                  ],
                  'key points' => [
                    'id' => 'poin-poin utama',
                    'pos' => '(n phr)',
                  ],
                  'plenary presentation' => [
                    'id' => 'presentasi pleno',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Conference participants stop to record the key points during the plenary presentation.',
                  'Conference participants stop recording the key points during the plenary presentation.',
                  'Conference participants stop record the key points during the plenary presentation.',
                  'Conference participants stop for recording the key points during the plenary presentation.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Stop to record (to + V1)\' menunjukkan tujuan menjeda aktivitas demi mencatat informasi penting.',
              ],
            ],
          ],
          [
            'id' => 'dual_minimal_shift',
            'name' => 'Dual-Pattern Verbs with Minimal Meaning Shift (begin, continue, start, propose)',
            'code' => '1.6.4',
            'concept_title' => 'Verba yang Fleksibel Diikuti To-Infinitive atau Gerund',
            'concept_description' => 'Kata kerja aspek fase seperti begin, start, continue, dan propose dapat diikuti oleh to-infinitive atau gerund tanpa perbedaan makna yang signifikan. Namun, dalam academic writing terdapat kaidah stilistik penting: hindari pengulangan bentuk berakhiran -ing secara berurutan (Avoid Double -ing: \'is beginning to decompose\', BUKAN \'is beginning decomposing\').',
            'formula' => 'Subject + BEGIN / CONTINUE / START + TO + V1 ATAU V-ING',
            'rules' => [
              'Kata kerja begin, start, continue, propose dapat diikuti to-infinitive maupun gerund tanpa mengubah makna esensial.',
              'Kaidah Stilistik: Jika kata kerja utama berbentuk progressive (-ing), wajib gunakan to-infinitive (misal: \'The specimen is starting to degrade\', bukan \'starting degrading\').',
              'Dalam gaya penulisan ilmiah yang ringkas, bentuk gerund sering dipilih untuk menyatakan aksi yang berkelanjutan (misal: \'continues rising\').',
              'Pastikan konsistensi paralelisme dalam satu kalimat majemuk.',
            ],
            'exercises' => [
              [
                'id' => 31,
                'id_sentence' => 'Suhu global terus meningkat akibat konsentrasi gas rumah kaca yang tak henti.',
                'target_word' => 'continues to rise',
                'vocab' => [
                  'global temperatures' => [
                    'id' => 'suhu global',
                    'pos' => '(n phr)',
                  ],
                  'continue' => [
                    'id' => 'terus / berlanjut',
                    'pos' => '(v)',
                  ],
                  'rise' => [
                    'id' => 'meningkat',
                    'pos' => '(v)',
                  ],
                  'greenhouse gas concentrations' => [
                    'id' => 'konsentrasi gas rumah kaca',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Global temperatures continue to rise due to unrelenting greenhouse gas concentrations.',
                  'Global temperatures continue rise due to unrelenting greenhouse gas concentrations.',
                  'Global temperatures continue to rising due to unrelenting greenhouse gas concentrations.',
                  'Global temperatures continue of rising due to unrelenting greenhouse gas concentrations.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'continue\' dapat diikuti to-infinitive (\'continue to rise\') atau gerund (\'continue rising\'). Opsi 1 adalah konstruksi standar yang gramatikal.',
              ],
              [
                'id' => 32,
                'id_sentence' => 'Senyawa organik tersebut mulai membusuk ketika terpapar udara terbuka.',
                'target_word' => 'begins to decompose',
                'vocab' => [
                  'organic compound' => [
                    'id' => 'senyawa organik',
                    'pos' => '(n phr)',
                  ],
                  'begin' => [
                    'id' => 'mulai',
                    'pos' => '(v)',
                  ],
                  'decompose' => [
                    'id' => 'membusuk / terurai',
                    'pos' => '(v)',
                  ],
                  'exposed to open air' => [
                    'id' => 'terpapar udara terbuka',
                    'pos' => '(adj phr)',
                  ],
                ],
                'options' => [
                  'The organic compound begins to decompose when exposed to ambient atmospheric air.',
                  'The organic compound begins decompose when exposed to ambient atmospheric air.',
                  'The organic compound begins to decomposing when exposed to ambient atmospheric air.',
                  'The organic compound begins of decomposing when exposed to ambient atmospheric air.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Begins to decompose\' (to-infinitive) atau \'begins decomposing\' keduanya sah. Opsi 1 menggunakan to-infinitive secara tepat.',
              ],
              [
                'id' => 33,
                'id_sentence' => 'Para peneliti mengusulkan untuk menerapkan model simulasi hidrologi terdistribusi.',
                'target_word' => 'propose to apply',
                'vocab' => [
                  'investigators' => [
                    'id' => 'para peneliti',
                    'pos' => '(n)',
                  ],
                  'propose' => [
                    'id' => 'mengusulkan',
                    'pos' => '(v)',
                  ],
                  'apply' => [
                    'id' => 'menerapkan',
                    'pos' => '(v)',
                  ],
                  'distributed hydrological simulation model' => [
                    'id' => 'model simulasi hidrologi terdistribusi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Investigators propose to apply a distributed hydrological simulation model.',
                  'Investigators propose apply a distributed hydrological simulation model.',
                  'Investigators propose to applying a distributed hydrological simulation model.',
                  'Investigators propose of applying a distributed hydrological simulation model.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'propose\' dapat diikuti to-infinitive (\'propose to apply\') atau gerund (\'propose applying\').',
              ],
              [
                'id' => 34,
                'id_sentence' => 'Kultur bakteri mulai memperlihatkan resistensi terhadap antibiotik lini pertama.',
                'target_word' => 'starts to exhibit',
                'vocab' => [
                  'bacterial culture' => [
                    'id' => 'kultur bakteri',
                    'pos' => '(n phr)',
                  ],
                  'start' => [
                    'id' => 'mulai',
                    'pos' => '(v)',
                  ],
                  'exhibit' => [
                    'id' => 'memperlihatkan / menunjukkan',
                    'pos' => '(v)',
                  ],
                  'resistance' => [
                    'id' => 'resistensi / kekebalan',
                    'pos' => '(n)',
                  ],
                  'first-line antibiotics' => [
                    'id' => 'antibiotik lini pertama',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The bacterial culture starts to exhibit resistance to first-line antibiotics.',
                  'The bacterial culture starts exhibit resistance to first-line antibiotics.',
                  'The bacterial culture starts to exhibiting resistance to first-line antibiotics.',
                  'The bacterial culture starts of exhibiting resistance to first-line antibiotics.',
                ],
                'correct_index' => 0,
                'explanation' => 'Konstruksi \'starts to exhibit\' menggunakan to-infinitive secara gramatikal dan formal.',
              ],
              [
                'id' => 35,
                'id_sentence' => 'Tingkat inflasi terus mengikis daya beli rumah tangga berpenghasilan rendah.',
                'target_word' => 'continues eroding',
                'vocab' => [
                  'inflation rate' => [
                    'id' => 'tingkat inflasi',
                    'pos' => '(n phr)',
                  ],
                  'continue' => [
                    'id' => 'terus / berlanjut',
                    'pos' => '(v)',
                  ],
                  'erode' => [
                    'id' => 'mengikis',
                    'pos' => '(v)',
                  ],
                  'purchasing power' => [
                    'id' => 'daya beli',
                    'pos' => '(n phr)',
                  ],
                  'low-income households' => [
                    'id' => 'rumah tangga berpenghasilan rendah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The inflation rate continues eroding the purchasing power of low-income households.',
                  'The inflation rate continues to erode the purchasing power of low-income households.',
                  'The inflation rate continues erode the purchasing power of low-income households.',
                  'The inflation rate continues for eroding the purchasing power of low-income households.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'continue\' diikuti gerund (\'continues eroding\') menyampaikan makna proses kontinu yang berlangsung stabil.',
              ],
              [
                'id' => 36,
                'id_sentence' => 'Spesimen polimer sedang mulai mengalami degradasi struktural di bawah sinar UV.',
                'target_word' => 'is beginning to undergo',
                'vocab' => [
                  'polymer specimen' => [
                    'id' => 'spesimen polimer',
                    'pos' => '(n phr)',
                  ],
                  'begin' => [
                    'id' => 'mulai',
                    'pos' => '(v)',
                  ],
                  'undergo' => [
                    'id' => 'mengalami',
                    'pos' => '(v)',
                  ],
                  'structural degradation' => [
                    'id' => 'degradasi struktural',
                    'pos' => '(n phr)',
                  ],
                  'ultraviolet radiation' => [
                    'id' => 'sinar UV',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The polymer specimen is beginning to undergo structural degradation under ultraviolet radiation.',
                  'The polymer specimen is beginning undergoing structural degradation under ultraviolet radiation.',
                  'The polymer specimen is beginning undergo structural degradation under ultraviolet radiation.',
                  'The polymer specimen is beginning to undergoing structural degradation under ultraviolet radiation.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kaidah \'Avoid Double -ing\': Karena kata kerja utama berbentuk progressive (\'is beginning\'), maka pelengkap wajib berbentuk to-infinitive (\'to undergo\').',
              ],
              [
                'id' => 37,
                'id_sentence' => 'Ekonom mulai mempertanyakan validitas asumsi pasar efisien klasik.',
                'target_word' => 'begin to question',
                'vocab' => [
                  'economists' => [
                    'id' => 'para ekonom',
                    'pos' => '(n)',
                  ],
                  'begin' => [
                    'id' => 'mulai',
                    'pos' => '(v)',
                  ],
                  'question' => [
                    'id' => 'mempertanyakan',
                    'pos' => '(v)',
                  ],
                  'validity' => [
                    'id' => 'validitas',
                    'pos' => '(n)',
                  ],
                  'efficient market assumptions' => [
                    'id' => 'asumsi pasar efisien',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Economists begin to question the validity of classical efficient market assumptions.',
                  'Economists begin question the validity of classical efficient market assumptions.',
                  'Economists begin to questioning the validity of classical efficient market assumptions.',
                  'Economists begin of questioning the validity of classical efficient market assumptions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Begin to question\' menggunakan to-infinitive secara tepat untuk verba kognitif.',
              ],
              [
                'id' => 38,
                'id_sentence' => 'Kedua laboratorium sepakat untuk terus bertukar sampel materi genetik.',
                'target_word' => 'continue exchanging',
                'vocab' => [
                  'both laboratories' => [
                    'id' => 'kedua laboratorium',
                    'pos' => '(n phr)',
                  ],
                  'continue' => [
                    'id' => 'terus / melanjutkan',
                    'pos' => '(v)',
                  ],
                  'exchange' => [
                    'id' => 'bertukar',
                    'pos' => '(v)',
                  ],
                  'genetic material samples' => [
                    'id' => 'sampel materi genetik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Both laboratories agree to continue exchanging genetic material samples.',
                  'Both laboratories agree to continue exchange genetic material samples.',
                  'Both laboratories agree to continue of exchanging genetic material samples.',
                  'Both laboratories agree to continue to exchanging genetic material samples.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Continue exchanging\' menggunakan gerund setelah continue secara lugas dan alami.',
              ],
              [
                'id' => 39,
                'id_sentence' => 'Komite teknis mengusulkan revisi protokol keselamatan penerbangan.',
                'target_word' => 'proposes revising',
                'vocab' => [
                  'technical committee' => [
                    'id' => 'komite teknis',
                    'pos' => '(n phr)',
                  ],
                  'propose' => [
                    'id' => 'mengusulkan',
                    'pos' => '(v)',
                  ],
                  'revise' => [
                    'id' => 'merevisi',
                    'pos' => '(v)',
                  ],
                  'aviation safety protocols' => [
                    'id' => 'protokol keselamatan penerbangan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The technical committee proposes revising aviation safety protocols.',
                  'The technical committee proposes revise aviation safety protocols.',
                  'The technical committee proposes to revising aviation safety protocols.',
                  'The technical committee proposes for revise aviation safety protocols.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Proposes revising\' (gerund) adalah bentuk yang sangat umum dan ringkas dalam konteks rekomendasi kebijakan.',
              ],
              [
                'id' => 40,
                'id_sentence' => 'Sensor sedang mulai mentransmisikan data telemetri ke stasiun bumi.',
                'target_word' => 'is starting to transmit',
                'vocab' => [
                  'sensor' => [
                    'id' => 'sensor',
                    'pos' => '(n)',
                  ],
                  'start' => [
                    'id' => 'mulai',
                    'pos' => '(v)',
                  ],
                  'transmit' => [
                    'id' => 'mentransmisikan',
                    'pos' => '(v)',
                  ],
                  'telemetry data' => [
                    'id' => 'data telemetri',
                    'pos' => '(n phr)',
                  ],
                  'ground station' => [
                    'id' => 'stasiun bumi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The sensor is starting to transmit telemetry data to the ground station.',
                  'The sensor is starting transmitting telemetry data to the ground station.',
                  'The sensor is starting transmit telemetry data to the ground station.',
                  'The sensor is starting to transmitting telemetry data to the ground station.',
                ],
                'correct_index' => 0,
                'explanation' => 'Hindari double -ing: \'is starting to transmit\' wajib menggunakan to-infinitive karena verba bantu sudah berakhiran -ing.',
              ],
            ],
          ],
          [
            'id' => 'infinitive_of_purpose',
            'name' => 'Infinitives of Purpose & Academic Rationale (to + V1, in order to, so as to)',
            'code' => '1.6.5',
            'concept_title' => 'Infinitif Penunjuk Tujuan (Infinitive of Purpose) dalam Metodologi Riset',
            'concept_description' => 'Dalam metodologi penelitian ilmiah, tujuan tindakan peneliti dijelaskan menggunakan Infinitive of Purpose (\'to + V1\', \'in order to + V1\', atau \'so as to + V1\'). Kesalahan fatal yang paling sering dilakukan pembelajar adalah menggunakan \'for + V1\' (misal: \'for isolate the protein\' ➔ SALAH) atau \'for + V-ing\' untuk menyatakan tujuan pelaku subjek (misal: \'Researchers centrifuge samples for isolating...\' ➔ SALAH; wajib \'to isolate\').',
            'formula' => 'Clause + (IN ORDER) TO / SO AS TO + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan \'to + V1\', \'in order to + V1\', atau \'so as to + V1\' untuk menyatakan tujuan atau maksud eksperimental.',
              'Dilarang keras menggunakan \'for + V1\' (misal: \'for determine\' ➔ SALAH; \'to determine\' ➔ BENAR).',
              '\'For + V-ing\' HANYA digunakan untuk menerangkan fungsi permanen suatu alat (misal: \'The microscope is used for analyzing tissues\'), BUKAN untuk menyatakan intensi pelaku.',
              'Frasa tujuan dapat ditempatkan di awal kalimat untuk penekanan (Fronting): \'In order to assess toxicity, researchers exposed cells to the compound.\'',
            ],
            'exercises' => [
              [
                'id' => 41,
                'id_sentence' => 'Para ilmuwan menggunakan kromatografi cair untuk memisahkan senyawa kimia kompleks.',
                'target_word' => 'to separate',
                'vocab' => [
                  'scientists' => [
                    'id' => 'para ilmuwan',
                    'pos' => '(n)',
                  ],
                  'liquid chromatography' => [
                    'id' => 'kromatografi cair',
                    'pos' => '(n phr)',
                  ],
                  'separate' => [
                    'id' => 'memisahkan',
                    'pos' => '(v)',
                  ],
                  'complex chemical compounds' => [
                    'id' => 'senyawa kimia kompleks',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Scientists utilize liquid chromatography to separate complex chemical compounds.',
                  'Scientists utilize liquid chromatography for separate complex chemical compounds.',
                  'Scientists utilize liquid chromatography for separating complex chemical compounds.',
                  'Scientists utilize liquid chromatography to separating complex chemical compounds.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk menyatakan tujuan tindakan peneliti, gunakan to-infinitive of purpose (\'to separate\'), bukan \'for separate\' atau \'for separating\'.',
              ],
              [
                'id' => 42,
                'id_sentence' => 'Guna meminimalkan kesalahan eksperimental, tim teknisi mengkalibrasi ulang semua sensor optik.',
                'target_word' => 'In order to minimize',
                'vocab' => [
                  'in order to' => [
                    'id' => 'guna / demi',
                    'pos' => '(prep phr)',
                  ],
                  'minimize' => [
                    'id' => 'meminimalkan',
                    'pos' => '(v)',
                  ],
                  'experimental errors' => [
                    'id' => 'kesalahan eksperimental',
                    'pos' => '(n phr)',
                  ],
                  'engineering team' => [
                    'id' => 'tim teknisi',
                    'pos' => '(n phr)',
                  ],
                  'recalibrate' => [
                    'id' => 'mengkalibrasi ulang',
                    'pos' => '(v)',
                  ],
                  'optical sensors' => [
                    'id' => 'sensor optik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'In order to minimize experimental errors, the engineering team recalibrates all optical sensors.',
                  'For minimize experimental errors, the engineering team recalibrates all optical sensors.',
                  'In order to minimizing experimental errors, the engineering team recalibrates all optical sensors.',
                  'So as minimizing experimental errors, the engineering team recalibrates all optical sensors.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa tujuan di awal kalimat wajib menggunakan \'In order to + V1\' (\'In order to minimize\') diikuti tanda koma.',
              ],
              [
                'id' => 43,
                'id_sentence' => 'Peneliti mengumpulkan data survei untuk mengevaluasi persepsi publik terhadap energi nuklir.',
                'target_word' => 'to evaluate',
                'vocab' => [
                  'survey data' => [
                    'id' => 'data survei',
                    'pos' => '(n phr)',
                  ],
                  'evaluate' => [
                    'id' => 'mengevaluasi',
                    'pos' => '(v)',
                  ],
                  'public perception' => [
                    'id' => 'persepsi publik',
                    'pos' => '(n phr)',
                  ],
                  'nuclear energy' => [
                    'id' => 'energi nuklir',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers collect survey data to evaluate public perception toward nuclear energy.',
                  'Researchers collect survey data for evaluate public perception toward nuclear energy.',
                  'Researchers collect survey data for evaluating public perception toward nuclear energy.',
                  'Researchers collect survey data so that evaluate public perception toward nuclear energy.',
                ],
                'correct_index' => 0,
                'explanation' => 'Gunakan to-infinitive (\'to evaluate\') untuk menyatakan maksud pengumpulan data.',
              ],
              [
                'id' => 44,
                'id_sentence' => 'Spesimen didinginkan secara bertahap agar tidak merusak struktur kristal mikroskopis.',
                'target_word' => 'so as not to disrupt',
                'vocab' => [
                  'specimen' => [
                    'id' => 'spesimen',
                    'pos' => '(n)',
                  ],
                  'cool gradually' => [
                    'id' => 'mendinginkan secara bertahap',
                    'pos' => '(v phr)',
                  ],
                  'so as not to' => [
                    'id' => 'agar tidak / supaya tidak',
                    'pos' => '(conj phr)',
                  ],
                  'disrupt' => [
                    'id' => 'merusak / mengganggu',
                    'pos' => '(v)',
                  ],
                  'microscopic crystalline structure' => [
                    'id' => 'struktur kristal mikroskopis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The specimen is cooled gradually so as not to disrupt the microscopic crystalline structure.',
                  'The specimen is cooled gradually so as to not disrupting the microscopic crystalline structure.',
                  'The specimen is cooled gradually for not disrupt the microscopic crystalline structure.',
                  'The specimen is cooled gradually in order not disrupting the microscopic crystalline structure.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk negatif dari infinitif tujuan adalah \'so as not to + V1\' atau \'in order not to + V1\'.',
              ],
              [
                'id' => 45,
                'id_sentence' => 'Untuk memastikan keterulangan temuan, laboratorium independen mereplikasi seluruh eksperimen.',
                'target_word' => 'To ensure',
                'vocab' => [
                  'ensure' => [
                    'id' => 'memastikan',
                    'pos' => '(v)',
                  ],
                  'reproducibility' => [
                    'id' => 'keterulangan / reproduktibilitas',
                    'pos' => '(n)',
                  ],
                  'findings' => [
                    'id' => 'temuan penelitian',
                    'pos' => '(n)',
                  ],
                  'independent laboratory' => [
                    'id' => 'laboratorium independen',
                    'pos' => '(n phr)',
                  ],
                  'replicate' => [
                    'id' => 'mereplikasi',
                    'pos' => '(v)',
                  ],
                ],
                'options' => [
                  'To ensure the reproducibility of findings, an independent laboratory replicates the entire experiment.',
                  'For ensure the reproducibility of findings, an independent laboratory replicates the entire experiment.',
                  'To ensuring the reproducibility of findings, an independent laboratory replicates the entire experiment.',
                  'For ensuring the reproducibility of findings, an independent laboratory replicates the entire experiment.',
                ],
                'correct_index' => 0,
                'explanation' => 'Infinitive of purpose di awal kalimat \'To ensure the reproducibility...\' menetapkan rasionalisasi ilmiah sebelum klausa independen.',
              ],
              [
                'id' => 46,
                'id_sentence' => 'Ahli meteorologi menganalisis citra satelit guna memprediksi lintasan badai tropis secara akurat.',
                'target_word' => 'in order to predict',
                'vocab' => [
                  'meteorologists' => [
                    'id' => 'ahli meteorologi',
                    'pos' => '(n)',
                  ],
                  'satellite imagery' => [
                    'id' => 'citra satelit',
                    'pos' => '(n phr)',
                  ],
                  'in order to' => [
                    'id' => 'guna / untuk',
                    'pos' => '(prep phr)',
                  ],
                  'predict' => [
                    'id' => 'memprediksi',
                    'pos' => '(v)',
                  ],
                  'trajectory' => [
                    'id' => 'lintasan',
                    'pos' => '(n)',
                  ],
                  'tropical storm' => [
                    'id' => 'badai tropis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Meteorologists analyze satellite imagery in order to predict tropical storm trajectories accurately.',
                  'Meteorologists analyze satellite imagery in order to predicting tropical storm trajectories accurately.',
                  'Meteorologists analyze satellite imagery for predict tropical storm trajectories accurately.',
                  'Meteorologists analyze satellite imagery so as predict tropical storm trajectories accurately.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In order to + V1\' (\'in order to predict\') adalah bentuk formal infinitif tujuan.',
              ],
              [
                'id' => 47,
                'id_sentence' => 'Bank sentral menaikkan suku bunga acuan untuk mengendalikan tekanan inflasi yang melonjak.',
                'target_word' => 'to curb',
                'vocab' => [
                  'central bank' => [
                    'id' => 'bank sentral',
                    'pos' => '(n phr)',
                  ],
                  'benchmark interest rate' => [
                    'id' => 'suku bunga acuan',
                    'pos' => '(n phr)',
                  ],
                  'curb' => [
                    'id' => 'mengendalikan / meredam',
                    'pos' => '(v)',
                  ],
                  'surging inflationary pressures' => [
                    'id' => 'tekanan inflasi yang melonjak',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The central bank raises the benchmark interest rate to curb surging inflationary pressures.',
                  'The central bank raises the benchmark interest rate for curb surging inflationary pressures.',
                  'The central bank raises the benchmark interest rate for curbing surging inflationary pressures.',
                  'The central bank raises the benchmark interest rate to curbing surging inflationary pressures.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tujuan intervensi moneter dinyatakan dengan to-infinitive (\'to curb\').',
              ],
              [
                'id' => 48,
                'id_sentence' => 'Para insinyur merancang ventilasi darurat untuk mencegah penumpukan gas metana berlebih.',
                'target_word' => 'to prevent',
                'vocab' => [
                  'emergency ventilation' => [
                    'id' => 'ventilasi darurat',
                    'pos' => '(n phr)',
                  ],
                  'prevent' => [
                    'id' => 'mencegah',
                    'pos' => '(v)',
                  ],
                  'excessive buildup' => [
                    'id' => 'penumpukan berlebih',
                    'pos' => '(n phr)',
                  ],
                  'methane gas' => [
                    'id' => 'gas metana',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers design emergency ventilation to prevent excessive methane gas buildup.',
                  'Engineers design emergency ventilation for prevent excessive methane gas buildup.',
                  'Engineers design emergency ventilation to preventing excessive methane gas buildup.',
                  'Engineers design emergency ventilation so prevent excessive methane gas buildup.',
                ],
                'correct_index' => 0,
                'explanation' => 'Gunakan \'to prevent\' (to-infinitive) untuk menerangkan maksud perancangan teknologi.',
              ],
              [
                'id' => 49,
                'id_sentence' => 'Guna menghindari bias seleksi, subjek penelitian ditempatkan secara acak ke dalam kelompok kontrol.',
                'target_word' => 'So as to avoid',
                'vocab' => [
                  'so as to' => [
                    'id' => 'guna / demi',
                    'pos' => '(prep phr)',
                  ],
                  'avoid' => [
                    'id' => 'menghindari',
                    'pos' => '(v)',
                  ],
                  'selection bias' => [
                    'id' => 'bias seleksi',
                    'pos' => '(n phr)',
                  ],
                  'randomly assigned' => [
                    'id' => 'ditempatkan secara acak',
                    'pos' => '(v phr)',
                  ],
                  'control group' => [
                    'id' => 'kelompok kontrol',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'So as to avoid selection bias, research subjects are randomly assigned to the control group.',
                  'So as to avoiding selection bias, research subjects are randomly assigned to the control group.',
                  'For avoid selection bias, research subjects are randomly assigned to the control group.',
                  'In order avoiding selection bias, research subjects are randomly assigned to the control group.',
                ],
                'correct_index' => 0,
                'explanation' => '\'So as to + V1\' (\'So as to avoid\') adalah bentuk infinitif tujuan alternatif yang sangat formal.',
              ],
              [
                'id' => 50,
                'id_sentence' => 'Laboratorium menerapkan protokol enkripsi baru untuk melindungi data privasi pasien.',
                'target_word' => 'to protect',
                'vocab' => [
                  'encryption protocols' => [
                    'id' => 'protokol enkripsi',
                    'pos' => '(n phr)',
                  ],
                  'protect' => [
                    'id' => 'melindungi',
                    'pos' => '(v)',
                  ],
                  'patient privacy data' => [
                    'id' => 'data privasi pasien',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The laboratory deploys novel encryption protocols to protect patient privacy data.',
                  'The laboratory deploys novel encryption protocols for protect patient privacy data.',
                  'The laboratory deploys novel encryption protocols to protecting patient privacy data.',
                  'The laboratory deploys novel encryption protocols for protecting patient privacy data.',
                ],
                'correct_index' => 0,
                'explanation' => 'Gunakan to-infinitive of purpose (\'to protect\').',
              ],
            ],
          ],
          [
            'id' => 'preposition_plus_gerund',
            'name' => 'Preposition + Gerund Combinations in Methodology (by, without, upon, prior to)',
            'code' => '1.6.6',
            'concept_title' => 'Kombinasi Preposisi dan Gerund dalam Deskripsi Metodologi Ilmiah',
            'concept_description' => 'Aturan sintaksis bahasa Inggris menetapkan bahwa objek dari preposisi WAJIB berupa kata benda, frasa benda, atau Gerund (V-ing). Menempatkan to-infinitive atau bare verb setelah preposisi metode (seperti by, without, upon, prior to, in addition to, instead of) adalah kesalahan fatal dalam academic writing.',
            'formula' => 'Clause + PREPOSITION (by, without, upon, prior to, instead of) + GERUND (V-ing) + Object',
            'rules' => [
              'Semua preposisi yang diikuti tindakan kata kerja WAJIB menggunakan bentuk Gerund (-ing).',
              'Gunakan \'by + V-ing\' untuk menjelaskan metode atau sarana tindakan peneliti.',
              'Gunakan \'without + V-ing\' untuk menyatakan kondisi pengecualian atau ketiadaan tindakan pendukung.',
              'Waspadai preposisi ganda berakhiran \'to\' seperti \'prior to\', \'in addition to\', \'committed to\' — kata \'to\' di sini adalah preposisi, BUKAN penanda infinitif, sehingga WAJIB diikuti Gerund (misal: \'prior to conducting\', BUKAN \'prior to conduct\').',
            ],
            'exercises' => [
              [
                'id' => 51,
                'id_sentence' => 'Para peneliti mengukur laju difusi dengan menganalisis citra fluoresensi beresolusi tinggi.',
                'target_word' => 'by analyzing',
                'vocab' => [
                  'diffusion rate' => [
                    'id' => 'laju difusi',
                    'pos' => '(n phr)',
                  ],
                  'by' => [
                    'id' => 'dengan (metode)',
                    'pos' => '(prep)',
                  ],
                  'analyze' => [
                    'id' => 'menganalisis',
                    'pos' => '(v)',
                  ],
                  'fluorescence imagery' => [
                    'id' => 'citra fluoresensi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers measure the diffusion rate by analyzing high-resolution fluorescence imagery.',
                  'Researchers measure the diffusion rate by analyze high-resolution fluorescence imagery.',
                  'Researchers measure the diffusion rate by to analyze high-resolution fluorescence imagery.',
                  'Researchers measure the diffusion rate with analyze high-resolution fluorescence imagery.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'by\' wajib diikuti gerund (\'by analyzing\') untuk menerangkan instrumen atau metodologi kerja.',
              ],
              [
                'id' => 52,
                'id_sentence' => 'Reaksi kimia berlangsung sempurna tanpa menghasilkan produk sampingan beracun.',
                'target_word' => 'without producing',
                'vocab' => [
                  'chemical reaction' => [
                    'id' => 'reaksi kimia',
                    'pos' => '(n phr)',
                  ],
                  'proceeds to completion' => [
                    'id' => 'berlangsung sempurna',
                    'pos' => '(v phr)',
                  ],
                  'without' => [
                    'id' => 'tanpa',
                    'pos' => '(prep)',
                  ],
                  'produce' => [
                    'id' => 'menghasilkan',
                    'pos' => '(v)',
                  ],
                  'toxic byproducts' => [
                    'id' => 'produk sampingan beracun',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The chemical reaction proceeds to completion without producing toxic byproducts.',
                  'The chemical reaction proceeds to completion without produce toxic byproducts.',
                  'The chemical reaction proceeds to completion without to produce toxic byproducts.',
                  'The chemical reaction proceeds to completion without to producing toxic byproducts.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'without\' wajib diikuti gerund (\'without producing\').',
              ],
              [
                'id' => 53,
                'id_sentence' => 'Sebelum memulai uji coba klinis, dokter wajib memperoleh persetujuan tertulis dari pasien.',
                'target_word' => 'Prior to initiating',
                'vocab' => [
                  'prior to' => [
                    'id' => 'sebelum / menjelang',
                    'pos' => '(prep phr)',
                  ],
                  'initiate' => [
                    'id' => 'memulai / menginisiasi',
                    'pos' => '(v)',
                  ],
                  'clinical trials' => [
                    'id' => 'uji coba klinis',
                    'pos' => '(n phr)',
                  ],
                  'written informed consent' => [
                    'id' => 'persetujuan tertulis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Prior to initiating clinical trials, physicians must obtain written informed consent from patients.',
                  'Prior to initiate clinical trials, physicians must obtain written informed consent from patients.',
                  'Prior initiate clinical trials, physicians must obtain written informed consent from patients.',
                  'Prior to be initiating clinical trials, physicians must obtain written informed consent from patients.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Prior to\' adalah frasa preposisi (di mana \'to\' adalah preposisi), sehingga wajib diikuti gerund (\'initiating\').',
              ],
              [
                'id' => 54,
                'id_sentence' => 'Saat mencapai suhu kritis, superkonduktor kehilangan seluruh resistensi listriknya.',
                'target_word' => 'Upon reaching',
                'vocab' => [
                  'upon' => [
                    'id' => 'saat / begitu mencapai',
                    'pos' => '(prep)',
                  ],
                  'reach' => [
                    'id' => 'mencapai',
                    'pos' => '(v)',
                  ],
                  'critical temperature' => [
                    'id' => 'suhu kritis',
                    'pos' => '(n phr)',
                  ],
                  'superconductor' => [
                    'id' => 'superkonduktor',
                    'pos' => '(n)',
                  ],
                  'electrical resistance' => [
                    'id' => 'resistensi listrik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Upon reaching the critical temperature, the superconductor loses all electrical resistance.',
                  'Upon reach the critical temperature, the superconductor loses all electrical resistance.',
                  'Upon to reach the critical temperature, the superconductor loses all electrical resistance.',
                  'Upon to reaching the critical temperature, the superconductor loses all electrical resistance.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi temporal formal \'upon\' wajib diikuti gerund (\'upon reaching\').',
              ],
              [
                'id' => 55,
                'id_sentence' => 'Selain menerbitkan artikel ilmiah, para profesor berkomitmen membimbing mahasiswa pascasarjana.',
                'target_word' => 'In addition to publishing',
                'vocab' => [
                  'in addition to' => [
                    'id' => 'selain',
                    'pos' => '(prep phr)',
                  ],
                  'publish' => [
                    'id' => 'menerbitkan',
                    'pos' => '(v)',
                  ],
                  'peer-reviewed articles' => [
                    'id' => 'artikel ilmiah bereputasi',
                    'pos' => '(n phr)',
                  ],
                  'professors' => [
                    'id' => 'para profesor',
                    'pos' => '(n)',
                  ],
                  'mentor' => [
                    'id' => 'membimbing',
                    'pos' => '(v)',
                  ],
                  'postgraduate students' => [
                    'id' => 'mahasiswa pascasarjana',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'In addition to publishing peer-reviewed articles, professors commit to mentoring postgraduate students.',
                  'In addition to publish peer-reviewed articles, professors commit to mentoring postgraduate students.',
                  'In addition publishing peer-reviewed articles, professors commit to mentoring postgraduate students.',
                  'In addition to publish peer-reviewed articles, professors commit to mentor postgraduate students.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa \'in addition to\' dan \'commit to\' keduanya berakhiran preposisi \'to\', sehingga masing-masing diikuti gerund (\'publishing\', \'mentoring\').',
              ],
              [
                'id' => 56,
                'id_sentence' => 'Alih-alih membuang limbah industri, pabrik mendaur ulangnya menjadi bahan baku sekunder.',
                'target_word' => 'Instead of discarding',
                'vocab' => [
                  'instead of' => [
                    'id' => 'alih-alih',
                    'pos' => '(prep phr)',
                  ],
                  'discard' => [
                    'id' => 'membuang',
                    'pos' => '(v)',
                  ],
                  'industrial waste' => [
                    'id' => 'limbah industri',
                    'pos' => '(n phr)',
                  ],
                  'recycle' => [
                    'id' => 'mendaur ulang',
                    'pos' => '(v)',
                  ],
                  'secondary raw materials' => [
                    'id' => 'bahan baku sekunder',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Instead of discarding industrial waste, the plant recycles it into secondary raw materials.',
                  'Instead of discard industrial waste, the plant recycles it into secondary raw materials.',
                  'Instead of to discard industrial waste, the plant recycles it into secondary raw materials.',
                  'Instead discarding industrial waste, the plant recycles it into secondary raw materials.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi komparatif \'instead of\' wajib diikuti gerund (\'discarding\').',
              ],
              [
                'id' => 57,
                'id_sentence' => 'Ahli geologi memetakan patahan aktif bumi dengan menggabungkan data seismik dan radar satelit.',
                'target_word' => 'by combining',
                'vocab' => [
                  'geologists' => [
                    'id' => 'ahli geologi',
                    'pos' => '(n)',
                  ],
                  'active tectonic faults' => [
                    'id' => 'patahan tektonik aktif',
                    'pos' => '(n phr)',
                  ],
                  'combine' => [
                    'id' => 'menggabungkan',
                    'pos' => '(v)',
                  ],
                  'seismic data' => [
                    'id' => 'data seismik',
                    'pos' => '(n phr)',
                  ],
                  'satellite radar' => [
                    'id' => 'radar satelit',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Geologists map active tectonic faults by combining seismic data and satellite radar.',
                  'Geologists map active tectonic faults by combine seismic data and satellite radar.',
                  'Geologists map active tectonic faults by to combine seismic data and satellite radar.',
                  'Geologists map active tectonic faults with combine seismic data and satellite radar.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi instrumen metodologis \'by\' mengambil gerund (\'by combining\').',
              ],
              [
                'id' => 58,
                'id_sentence' => 'Algoritma kecerdasan buatan menyortir jutaan catatan medis tanpa melanggar kerahasiaan pasien.',
                'target_word' => 'without violating',
                'vocab' => [
                  'artificial intelligence algorithm' => [
                    'id' => 'algoritma kecerdasan buatan',
                    'pos' => '(n phr)',
                  ],
                  'sort' => [
                    'id' => 'menyortir / memilah',
                    'pos' => '(v)',
                  ],
                  'medical records' => [
                    'id' => 'catatan medis',
                    'pos' => '(n phr)',
                  ],
                  'violate' => [
                    'id' => 'melanggar',
                    'pos' => '(v)',
                  ],
                  'patient confidentiality' => [
                    'id' => 'kerahasiaan pasien',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The artificial intelligence algorithm sorts millions of medical records without violating patient confidentiality.',
                  'The artificial intelligence algorithm sorts millions of medical records without violate patient confidentiality.',
                  'The artificial intelligence algorithm sorts millions of medical records without to violate patient confidentiality.',
                  'The artificial intelligence algorithm sorts millions of medical records without of violating patient confidentiality.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Without\' adalah preposisi yang wajib diikuti bentuk gerund (\'without violating\').',
              ],
              [
                'id' => 59,
                'id_sentence' => 'Setelah menyelesaikan proses sentrifugasi, teknisi memindahkan supernatan ke dalam tabung reaksi steril.',
                'target_word' => 'After completing',
                'vocab' => [
                  'after' => [
                    'id' => 'setelah',
                    'pos' => '(prep)',
                  ],
                  'complete' => [
                    'id' => 'menyelesaikan',
                    'pos' => '(v)',
                  ],
                  'centrifugation process' => [
                    'id' => 'proses sentrifugasi',
                    'pos' => '(n phr)',
                  ],
                  'transfer' => [
                    'id' => 'memindahkan',
                    'pos' => '(v)',
                  ],
                  'supernatant' => [
                    'id' => 'supernatan / cairan bening',
                    'pos' => '(n)',
                  ],
                  'sterile test tubes' => [
                    'id' => 'tabung reaksi steril',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'After completing the centrifugation process, the technician transfers the supernatant into sterile test tubes.',
                  'After complete the centrifugation process, the technician transfers the supernatant into sterile test tubes.',
                  'After to complete the centrifugation process, the technician transfers the supernatant into sterile test tubes.',
                  'After of completing the centrifugation process, the technician transfers the supernatant into sterile test tubes.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'after\' diikuti gerund (\'completing\') untuk klausa waktu ringkas.',
              ],
              [
                'id' => 60,
                'id_sentence' => 'Para insinyur memperkuat ketahanan jembatan dengan menyuntikkan resin epoksi ke dalam retakan mikro.',
                'target_word' => 'by injecting',
                'vocab' => [
                  'reinforce' => [
                    'id' => 'memperkuat',
                    'pos' => '(v)',
                  ],
                  'structural resilience' => [
                    'id' => 'ketahanan struktural',
                    'pos' => '(n phr)',
                  ],
                  'inject' => [
                    'id' => 'menyuntikkan',
                    'pos' => '(v)',
                  ],
                  'epoxy resin' => [
                    'id' => 'resin epoksi',
                    'pos' => '(n phr)',
                  ],
                  'micro-fissures' => [
                    'id' => 'retakan mikro',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers reinforce the bridge structural resilience by injecting epoxy resin into micro-fissures.',
                  'Engineers reinforce the bridge structural resilience by inject epoxy resin into micro-fissures.',
                  'Engineers reinforce the bridge structural resilience by to inject epoxy resin into micro-fissures.',
                  'Engineers reinforce the bridge structural resilience with to inject epoxy resin into micro-fissures.',
                ],
                'correct_index' => 0,
                'explanation' => '\'By injecting\' (preposisi + gerund) adalah bentuk yang tepat untuk menjelaskan prosedur perbaikan struktural.',
              ],
            ],
          ],
          [
            'id' => 'verb_object_infinitive',
            'name' => 'Verb + Object + To-Infinitive Structures (enable, allow, require, permit)',
            'code' => '1.6.7',
            'concept_title' => 'Pola Transitif Kompleks: Verb + Noun Object + To-Infinitive',
            'concept_description' => 'Dalam menjelaskan kapabilitas teknologi, metodologi, dan hubungan kausal, bahasa akademik sering memakai pola \'Verb + Noun Object + To-Infinitive\' dengan kata kerja kausatif/permisif seperti enable, allow, require, permit, compel, force, and instruct. Penggunaan bentuk gerund setelah objek dalam pola ini (misal: \'enables researchers analyzing\' ➔ SALAH) adalah kesalahan umum yang harus dihindari.',
            'formula' => 'Subject + ENABLE / ALLOW / REQUIRE / PERMIT / COMPEL + Noun Object + TO + V1',
            'rules' => [
              'Pola transitif: Kata kerja (enable, allow, require, permit, cause) + Objek (Noun/Pronoun) + TO + V1 (Base Form).',
              'Dilarang menggunakan to-infinitive langsung tanpa objek pada kata kerja \'enable\' (misal: \'The tool enables to analyze\' ➔ SALAH; wajib ada objek: \'enables users to analyze\').',
              'Dalam bentuk pasif, objek berpindah ke posisi subjek diikuti to-infinitive: \'Participants are required to submit their reports.\'',
              'Bedakan dengan kata kerja tertentu seperti \'let\' atau \'make\' yang mengambil bare infinitive tanpa \'to\' (walaupun jarang dipakai dalam register jurnal formal).',
            ],
            'exercises' => [
              [
                'id' => 61,
                'id_sentence' => 'Mikroskop beresolusi tinggi ini memungkinkan para ilmuwan untuk mengamati struktur organel sel secara detail.',
                'target_word' => 'enables scientists to observe',
                'vocab' => [
                  'high-resolution microscope' => [
                    'id' => 'mikroskop beresolusi tinggi',
                    'pos' => '(n phr)',
                  ],
                  'enable' => [
                    'id' => 'memungkinkan',
                    'pos' => '(v)',
                  ],
                  'observe' => [
                    'id' => 'mengamati',
                    'pos' => '(v)',
                  ],
                  'cellular organelle structures' => [
                    'id' => 'struktur organel sel',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This high-resolution microscope enables scientists to observe cellular organelle structures in detail.',
                  'This high-resolution microscope enables scientists observing cellular organelle structures in detail.',
                  'This high-resolution microscope enables to scientists observe cellular organelle structures in detail.',
                  'This high-resolution microscope enables scientists observe cellular organelle structures in detail.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola \'enable + Object + to-infinitive\' (\'enables scientists to observe\') adalah konstruksi gramatikal yang benar.',
              ],
              [
                'id' => 62,
                'id_sentence' => 'Protokol keamanan universitas mewajibkan semua peneliti untuk mengenakan alat pelindung diri di laboratorium.',
                'target_word' => 'requires all researchers to wear',
                'vocab' => [
                  'university safety protocol' => [
                    'id' => 'protokol keamanan universitas',
                    'pos' => '(n phr)',
                  ],
                  'require' => [
                    'id' => 'mewajibkan',
                    'pos' => '(v)',
                  ],
                  'wear' => [
                    'id' => 'mengenakan',
                    'pos' => '(v)',
                  ],
                  'personal protective equipment' => [
                    'id' => 'alat pelindung diri',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'University safety protocols require all researchers to wear personal protective equipment in the laboratory.',
                  'University safety protocols require all researchers wearing personal protective equipment in the laboratory.',
                  'University safety protocols require all researchers wear personal protective equipment in the laboratory.',
                  'University safety protocols require to all researchers wear personal protective equipment in the laboratory.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'require\' mengambil pola transitif \'require + Object + to-infinitive\' (\'require researchers to wear\').',
              ],
              [
                'id' => 63,
                'id_sentence' => 'Perangkat lunak open-source mengizinkan para analis untuk memodifikasi kode sumber sesuai kebutuhan riset.',
                'target_word' => 'allows analysts to modify',
                'vocab' => [
                  'open-source software' => [
                    'id' => 'perangkat lunak open-source',
                    'pos' => '(n phr)',
                  ],
                  'allow' => [
                    'id' => 'mengizinkan / memungkinkan',
                    'pos' => '(v)',
                  ],
                  'analysts' => [
                    'id' => 'para analis',
                    'pos' => '(n)',
                  ],
                  'modify' => [
                    'id' => 'memodifikasi',
                    'pos' => '(v)',
                  ],
                  'source code' => [
                    'id' => 'kode sumber',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Open-source software allows analysts to modify the source code according to research needs.',
                  'Open-source software allows analysts modifying the source code according to research needs.',
                  'Open-source software allows to analysts modify the source code according to research needs.',
                  'Open-source software allows analysts modify the source code according to research needs.',
                ],
                'correct_index' => 0,
                'explanation' => 'Gunakan pola \'allow + Object + to-infinitive\' (\'allows analysts to modify\').',
              ],
              [
                'id' => 64,
                'id_sentence' => 'Regulasi lingkungan baru memaksa pabrik kimia untuk menurunkan emisi sulfur dioksida.',
                'target_word' => 'compels chemical plants to reduce',
                'vocab' => [
                  'environmental regulations' => [
                    'id' => 'regulasi lingkungan',
                    'pos' => '(n phr)',
                  ],
                  'compel' => [
                    'id' => 'memaksa / mendorong kuat',
                    'pos' => '(v)',
                  ],
                  'chemical plants' => [
                    'id' => 'pabrik kimia',
                    'pos' => '(n phr)',
                  ],
                  'reduce' => [
                    'id' => 'menurunkan / mengurangi',
                    'pos' => '(v)',
                  ],
                  'sulfur dioxide emissions' => [
                    'id' => 'emisi sulfur dioksida',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'New environmental regulations compel chemical plants to reduce sulfur dioxide emissions.',
                  'New environmental regulations compel chemical plants reducing sulfur dioxide emissions.',
                  'New environmental regulations compel to chemical plants reduce sulfur dioxide emissions.',
                  'New environmental regulations compel chemical plants reduce sulfur dioxide emissions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Compel + Object + to-infinitive\' (\'compel plants to reduce\') menyatakan paksaan regulasi secara formal.',
              ],
              [
                'id' => 65,
                'id_sentence' => 'Teknologi komputasi awan mempermudah para pengembang untuk menyebarkan aplikasi secara global.',
                'target_word' => 'permits developers to deploy',
                'vocab' => [
                  'cloud computing technology' => [
                    'id' => 'teknologi komputasi awan',
                    'pos' => '(n phr)',
                  ],
                  'permit' => [
                    'id' => 'memungkinkan / mengizinkan',
                    'pos' => '(v)',
                  ],
                  'developers' => [
                    'id' => 'para pengembang',
                    'pos' => '(n)',
                  ],
                  'deploy' => [
                    'id' => 'menyebarkan / men-deploy',
                    'pos' => '(v)',
                  ],
                  'applications globally' => [
                    'id' => 'aplikasi secara global',
                    'pos' => '(adv phr)',
                  ],
                ],
                'options' => [
                  'Cloud computing technology permits developers to deploy applications globally with minimal latency.',
                  'Cloud computing technology permits developers deploying applications globally with minimal latency.',
                  'Cloud computing technology permits to developers deploy applications globally with minimal latency.',
                  'Cloud computing technology permits developers deploy applications globally with minimal latency.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola \'permit + Object + to-infinitive\' (\'permits developers to deploy\') adalah pola transitif standar.',
              ],
              [
                'id' => 66,
                'id_sentence' => 'Fluktuasi suhu yang drastis menyebabkan beton mengembang dan retak di sepanjang sambungan ekspansi.',
                'target_word' => 'causes concrete to expand',
                'vocab' => [
                  'drastic temperature fluctuations' => [
                    'id' => 'fluktuasi suhu drastis',
                    'pos' => '(n phr)',
                  ],
                  'cause' => [
                    'id' => 'menyebabkan',
                    'pos' => '(v)',
                  ],
                  'concrete' => [
                    'id' => 'beton',
                    'pos' => '(n)',
                  ],
                  'expand' => [
                    'id' => 'mengembang',
                    'pos' => '(v)',
                  ],
                  'crack' => [
                    'id' => 'retak',
                    'pos' => '(v)',
                  ],
                  'expansion joints' => [
                    'id' => 'sambungan ekspansi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Drastic temperature fluctuations cause concrete to expand and crack along expansion joints.',
                  'Drastic temperature fluctuations cause concrete expanding and cracking along expansion joints.',
                  'Drastic temperature fluctuations cause to concrete expand and crack along expansion joints.',
                  'Drastic temperature fluctuations cause concrete expand and crack along expansion joints.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Cause + Object + to-infinitive\' (\'causes concrete to expand\') adalah pola kausatif ilmiah.',
              ],
              [
                'id' => 67,
                'id_sentence' => 'Pedoman penulisan jurnal menginstruksikan para penulis untuk menyertakan ringkasan grafis.',
                'target_word' => 'instructs authors to include',
                'vocab' => [
                  'journal author guidelines' => [
                    'id' => 'pedoman penulisan jurnal',
                    'pos' => '(n phr)',
                  ],
                  'instruct' => [
                    'id' => 'menginstruksikan',
                    'pos' => '(v)',
                  ],
                  'authors' => [
                    'id' => 'para penulis',
                    'pos' => '(n)',
                  ],
                  'include' => [
                    'id' => 'menyertakan',
                    'pos' => '(v)',
                  ],
                  'graphical abstract' => [
                    'id' => 'ringkasan grafis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The journal author guidelines instruct authors to include a graphical abstract with their submission.',
                  'The journal author guidelines instruct authors including a graphical abstract with their submission.',
                  'The journal author guidelines instruct to authors include a graphical abstract with their submission.',
                  'The journal author guidelines instruct authors include a graphical abstract with their submission.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Instruct + Object + to-infinitive\' (\'instruct authors to include\') merupakan pola imperatif/instruksional akademis.',
              ],
              [
                'id' => 68,
                'id_sentence' => 'Data empiris mendorong dewan gubernur untuk meninjau kembali asumsi pertumbuhan fiskal.',
                'target_word' => 'prompts the board to reconsider',
                'vocab' => [
                  'empirical data' => [
                    'id' => 'data empiris',
                    'pos' => '(n phr)',
                  ],
                  'prompt' => [
                    'id' => 'mendorong / menggerakkan',
                    'pos' => '(v)',
                  ],
                  'governing board' => [
                    'id' => 'dewan gubernur',
                    'pos' => '(n phr)',
                  ],
                  'reconsider' => [
                    'id' => 'meninjau kembali',
                    'pos' => '(v)',
                  ],
                  'fiscal growth assumptions' => [
                    'id' => 'asumsi pertumbuhan fiskal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Empirical data prompts the governing board to reconsider fiscal growth assumptions.',
                  'Empirical data prompts the governing board reconsidering fiscal growth assumptions.',
                  'Empirical data prompts to the governing board reconsider fiscal growth assumptions.',
                  'Empirical data prompts the governing board reconsider fiscal growth assumptions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Prompt + Object + to-infinitive\' (\'prompts the board to reconsider\') adalah pola kausatif halus (*persuasive causation*).',
              ],
              [
                'id' => 69,
                'id_sentence' => 'Kerangka kerja hukum ini melarang perusahaan monopoli untuk menetapkan harga diskriminatif.',
                'target_word' => 'forbids monopolies to set',
                'vocab' => [
                  'legal framework' => [
                    'id' => 'kerangka kerja hukum',
                    'pos' => '(n phr)',
                  ],
                  'forbid' => [
                    'id' => 'melarang',
                    'pos' => '(v)',
                  ],
                  'monopolies' => [
                    'id' => 'perusahaan monopoli',
                    'pos' => '(n)',
                  ],
                  'set' => [
                    'id' => 'menetapkan',
                    'pos' => '(v)',
                  ],
                  'discriminatory prices' => [
                    'id' => 'harga diskriminatif',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The legal framework forbids monopolies to set discriminatory prices in the domestic market.',
                  'The legal framework forbids monopolies setting discriminatory prices in the domestic market.',
                  'The legal framework forbids to monopolies set discriminatory prices in the domestic market.',
                  'The legal framework forbids monopolies of setting discriminatory prices in the domestic market.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Forbid + Object + to-infinitive\' (\'forbids monopolies to set\') adalah pola pelarangan formal.',
              ],
              [
                'id' => 70,
                'id_sentence' => 'Dosen pembimbing mendorong mahasiswa untuk mengeksplorasi metodologi penelitian interdisipliner.',
                'target_word' => 'encourages students to explore',
                'vocab' => [
                  'academic advisor' => [
                    'id' => 'dosen pembimbing',
                    'pos' => '(n phr)',
                  ],
                  'encourage' => [
                    'id' => 'mendorong / menyemangati',
                    'pos' => '(v)',
                  ],
                  'students' => [
                    'id' => 'para mahasiswa',
                    'pos' => '(n)',
                  ],
                  'explore' => [
                    'id' => 'mengeksplorasi',
                    'pos' => '(v)',
                  ],
                  'interdisciplinary research methodologies' => [
                    'id' => 'metodologi penelitian interdisipliner',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The academic advisor encourages students to explore interdisciplinary research methodologies.',
                  'The academic advisor encourages students exploring interdisciplinary research methodologies.',
                  'The academic advisor encourages to students explore interdisciplinary research methodologies.',
                  'The academic advisor encourages students explore interdisciplinary research methodologies.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Encourage + Object + to-infinitive\' (\'encourages students to explore\') adalah pola transitif standar.',
              ],
            ],
          ],
          [
            'id' => 'synthesis_error_elimination',
            'name' => 'Academic Synthesis & Error Elimination (To-Infinitive vs Gerund Contrasts)',
            'code' => '1.6.8',
            'concept_title' => 'Sintesis Akademik: Eliminasi Kerancuan Infinitive vs Gerund',
            'concept_description' => 'Sub-lesson penutup ini menguji kemampuan sintesis tingkat lanjut dalam membedakan kapan menggunakan to-infinitive, kapan menggunakan gerund, mengenali \'to\' sebagai preposisi versus \'to\' sebagai penanda infinitif (seperti committed to + V-ing, look forward to + V-ing, with a view to + V-ing), serta menyusun kalimat kompleks multi-verbal yang akurat dan bebas dari kesalahan fatal.',
            'formula' => 'Synthesized Clause: Main Verb [Target Verbal Complement] + Modifier [Preposition + Gerund / Infinitive of Purpose]',
            'rules' => [
              'Waspadai frasa preposisi berakhiran \'to\': \'committed to\', \'dedicated to\', \'with a view to\', \'look forward to\' WAJIB diikuti Gerund (-ing), bukan to + V1.',
              'Bedakan fungsi: Infinitive menyatakan tujuan atau potensi masa depan (to achieve, to verify), sedangkan Gerund menyatakan aktivitas/proses nyata yang berlangsung atau fakta umum (conducting, analyzing).',
              'Hindari double predicates (misal: \'The study attempts analyze\' ➔ SALAH; wajib \'attempts to analyze\').',
              'Jaga paralelisme kata kerja pelengkap saat dihubungkan konjungsi koordinatif (misal: \'involves collecting data and analyzing trends\', BUKAN \'collecting data and to analyze\').',
            ],
            'exercises' => [
              [
                'id' => 71,
                'id_sentence' => 'Institusi riset tersebut berkomitmen untuk memajukan teknologi energi bersih di seluruh dunia.',
                'target_word' => 'is committed to advancing',
                'vocab' => [
                  'research institution' => [
                    'id' => 'institusi riset',
                    'pos' => '(n phr)',
                  ],
                  'committed to' => [
                    'id' => 'berkomitmen untuk',
                    'pos' => '(adj + prep)',
                  ],
                  'advance' => [
                    'id' => 'memajukan',
                    'pos' => '(v)',
                  ],
                  'clean energy technologies' => [
                    'id' => 'teknologi energi bersih',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The research institution is committed to advancing clean energy technologies worldwide.',
                  'The research institution is committed to advance clean energy technologies worldwide.',
                  'The research institution is committed advance clean energy technologies worldwide.',
                  'The research institution commits to advance clean energy technologies worldwide.',
                ],
                'correct_index' => 0,
                'explanation' => 'Dalam frasa \'committed to\', kata \'to\' adalah preposisi, sehingga wajib diikuti gerund (\'advancing\'), bukan bare verb atau infinitive.',
              ],
              [
                'id' => 72,
                'id_sentence' => 'Proyek ini bertujuan untuk mengisolasi patogen dengan tetap menghindari kontaminasi silang pada sampel lain.',
                'target_word' => 'aims to isolate while avoiding',
                'vocab' => [
                  'project' => [
                    'id' => 'proyek',
                    'pos' => '(n)',
                  ],
                  'aim' => [
                    'id' => 'bertujuan',
                    'pos' => '(v)',
                  ],
                  'isolate' => [
                    'id' => 'mengisolasi',
                    'pos' => '(v)',
                  ],
                  'avoid' => [
                    'id' => 'menghindari',
                    'pos' => '(v)',
                  ],
                  'cross-contamination' => [
                    'id' => 'kontaminasi silang',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The project aims to isolate the pathogen while avoiding cross-contamination of other samples.',
                  'The project aims isolating the pathogen while avoiding cross-contamination of other samples.',
                  'The project aims to isolate the pathogen while to avoid cross-contamination of other samples.',
                  'The project aims isolate the pathogen while avoiding cross-contamination of other samples.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Aim\' diikuti to-infinitive (\'aims to isolate\'), dan konjungsi \'while\' diikuti gerund (\'avoiding cross-contamination\').',
              ],
              [
                'id' => 73,
                'id_sentence' => 'Pemerintah merencanakan kebijakan baru dengan tujuan untuk menstabilkan pasar keuangan domestik.',
                'target_word' => 'with a view to stabilizing',
                'vocab' => [
                  'government' => [
                    'id' => 'pemerintah',
                    'pos' => '(n)',
                  ],
                  'plans novel policies' => [
                    'id' => 'merencanakan kebijakan baru',
                    'pos' => '(v phr)',
                  ],
                  'with a view to' => [
                    'id' => 'dengan tujuan untuk / demi',
                    'pos' => '(prep phr)',
                  ],
                  'stabilize' => [
                    'id' => 'menstabilkan',
                    'pos' => '(v)',
                  ],
                  'domestic financial markets' => [
                    'id' => 'pasar keuangan domestik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The government plans novel policies with a view to stabilizing domestic financial markets.',
                  'The government plans novel policies with a view to stabilize domestic financial markets.',
                  'The government plans novel policies with a view stabilize domestic financial markets.',
                  'The government plans novel policies with a view to be stabilizing domestic financial markets.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa formal \'with a view to\' diakhiri oleh preposisi \'to\', sehingga wajib diikuti gerund (\'stabilizing\').',
              ],
              [
                'id' => 74,
                'id_sentence' => 'Penulis menolak untuk berspekulasi tanpa memiliki bukti empiris yang cukup.',
                'target_word' => 'refuses to speculate without possessing',
                'vocab' => [
                  'author' => [
                    'id' => 'penulis',
                    'pos' => '(n)',
                  ],
                  'refuse' => [
                    'id' => 'menolak',
                    'pos' => '(v)',
                  ],
                  'speculate' => [
                    'id' => 'berspekulasi',
                    'pos' => '(v)',
                  ],
                  'without' => [
                    'id' => 'tanpa',
                    'pos' => '(prep)',
                  ],
                  'possess' => [
                    'id' => 'memiliki',
                    'pos' => '(v)',
                  ],
                  'sufficient empirical evidence' => [
                    'id' => 'bukti empiris yang cukup',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The author refuses to speculate without possessing sufficient empirical evidence.',
                  'The author refuses speculating without possessing sufficient empirical evidence.',
                  'The author refuses to speculate without possess sufficient empirical evidence.',
                  'The author refuses speculate without to possess sufficient empirical evidence.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Refuse\' wajib diikuti to-infinitive (\'refuses to speculate\'), dan preposisi \'without\' wajib diikuti gerund (\'possessing\').',
              ],
              [
                'id' => 75,
                'id_sentence' => 'Metodologi penelitian ini mencakup perancangan kuesioner dan pelaksanaan wawancara mendalam.',
                'target_word' => 'involves designing and conducting',
                'vocab' => [
                  'research methodology' => [
                    'id' => 'metodologi penelitian',
                    'pos' => '(n phr)',
                  ],
                  'involve' => [
                    'id' => 'mencakup / melibatkan',
                    'pos' => '(v)',
                  ],
                  'design' => [
                    'id' => 'merancang',
                    'pos' => '(v)',
                  ],
                  'questionnaires' => [
                    'id' => 'kuesioner',
                    'pos' => '(n)',
                  ],
                  'conduct' => [
                    'id' => 'melaksanakan',
                    'pos' => '(v)',
                  ],
                  'in-depth interviews' => [
                    'id' => 'wawancara mendalam',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The research methodology involves designing questionnaires and conducting in-depth interviews.',
                  'The research methodology involves to design questionnaires and to conduct in-depth interviews.',
                  'The research methodology involves designing questionnaires and to conduct in-depth interviews.',
                  'The research methodology involves design questionnaires and conducting in-depth interviews.',
                ],
                'correct_index' => 0,
                'explanation' => 'Paralelisme gerund: \'involve\' mengambil gerund, dan kedua kata kerja yang dikoordinasikan oleh \'and\' wajib sama-sama berbentuk gerund (\'designing... and conducting...\').',
              ],
              [
                'id' => 76,
                'id_sentence' => 'Laboratorium gagal mendeteksi partikel radioaktif sebelum mengkalibrasi ulang detektor geiger.',
                'target_word' => 'fails to detect prior to recalibrating',
                'vocab' => [
                  'laboratory' => [
                    'id' => 'laboratorium',
                    'pos' => '(n)',
                  ],
                  'fail' => [
                    'id' => 'gagal',
                    'pos' => '(v)',
                  ],
                  'detect' => [
                    'id' => 'mendeteksi',
                    'pos' => '(v)',
                  ],
                  'radioactive particles' => [
                    'id' => 'partikel radioaktif',
                    'pos' => '(n phr)',
                  ],
                  'prior to' => [
                    'id' => 'sebelum',
                    'pos' => '(prep phr)',
                  ],
                  'recalibrate' => [
                    'id' => 'mengkalibrasi ulang',
                    'pos' => '(v)',
                  ],
                  'Geiger counter' => [
                    'id' => 'detektor Geiger',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The laboratory fails to detect radioactive particles prior to recalibrating the Geiger counter.',
                  'The laboratory fails detecting radioactive particles prior to recalibrating the Geiger counter.',
                  'The laboratory fails to detect radioactive particles prior to recalibrate the Geiger counter.',
                  'The laboratory fails detect radioactive particles prior to recalibrating the Geiger counter.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Fail\' wajib diikuti to-infinitive (\'fails to detect\'), sedangkan \'prior to\' adalah frasa preposisi yang mewajibkan gerund (\'prior to recalibrating\').',
              ],
              [
                'id' => 77,
                'id_sentence' => 'Algoritma berusaha untuk mengoptimalkan rute logistik guna meminimalkan konsumsi bahan bakar armada.',
                'target_word' => 'attempts to optimize to minimize',
                'vocab' => [
                  'algorithm' => [
                    'id' => 'algoritma',
                    'pos' => '(n)',
                  ],
                  'attempt' => [
                    'id' => 'berusaha',
                    'pos' => '(v)',
                  ],
                  'optimize' => [
                    'id' => 'mengoptimalkan',
                    'pos' => '(v)',
                  ],
                  'logistical routes' => [
                    'id' => 'rute logistik',
                    'pos' => '(n phr)',
                  ],
                  'minimize' => [
                    'id' => 'meminimalkan',
                    'pos' => '(v)',
                  ],
                  'fleet fuel consumption' => [
                    'id' => 'konsumsi bahan bakar armada',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The algorithm attempts to optimize logistical routes in order to minimize fleet fuel consumption.',
                  'The algorithm attempts optimizing logistical routes in order to minimize fleet fuel consumption.',
                  'The algorithm attempts to optimize logistical routes in order for minimize fleet fuel consumption.',
                  'The algorithm attempts optimize logistical routes so as to minimizing fleet fuel consumption.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Attempt\' diikuti to-infinitive (\'to optimize\'), dan klausa tujuan rasional menggunakan \'in order to minimize\'.',
              ],
              [
                'id' => 78,
                'id_sentence' => 'Subjek uji coba berhenti mengonsumsi suplemen untuk memantau efek pemulihan alami tubuh.',
                'target_word' => 'stop taking in order to monitor',
                'vocab' => [
                  'trial subjects' => [
                    'id' => 'subjek uji coba',
                    'pos' => '(n phr)',
                  ],
                  'stop' => [
                    'id' => 'berhenti / menyetop konsumsi',
                    'pos' => '(v)',
                  ],
                  'take' => [
                    'id' => 'mengonsumsi',
                    'pos' => '(v)',
                  ],
                  'dietary supplements' => [
                    'id' => 'suplemen makanan',
                    'pos' => '(n phr)',
                  ],
                  'monitor' => [
                    'id' => 'memantau',
                    'pos' => '(v)',
                  ],
                  'natural recovery effects' => [
                    'id' => 'efek pemulihan alami',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Trial subjects stop taking dietary supplements in order to monitor the body natural recovery effects.',
                  'Trial subjects stop to take dietary supplements in order to monitor the body natural recovery effects.',
                  'Trial subjects stop taking dietary supplements in order to monitoring the body natural recovery effects.',
                  'Trial subjects stop take dietary supplements for monitor the body natural recovery effects.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Stop taking (V-ing)\' bermakna menghentikan tindakan minum suplemen, disusul infinitif tujuan \'in order to monitor\'.',
              ],
              [
                'id' => 79,
                'id_sentence' => 'Para insinyur mempertimbangkan untuk mengadopsi bahan komposit guna memungkinkan struktur menahan beban seismik.',
                'target_word' => 'consider adopting to enable to withstand',
                'vocab' => [
                  'consider' => [
                    'id' => 'mempertimbangkan',
                    'pos' => '(v)',
                  ],
                  'adopt' => [
                    'id' => 'mengadopsi / menerapkan',
                    'pos' => '(v)',
                  ],
                  'composite materials' => [
                    'id' => 'bahan komposit',
                    'pos' => '(n phr)',
                  ],
                  'enable' => [
                    'id' => 'memungkinkan',
                    'pos' => '(v)',
                  ],
                  'withstand' => [
                    'id' => 'menahan',
                    'pos' => '(v)',
                  ],
                  'seismic loads' => [
                    'id' => 'beban seismik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers consider adopting composite materials to enable the structure to withstand seismic loads.',
                  'Engineers consider to adopt composite materials to enable the structure to withstand seismic loads.',
                  'Engineers consider adopting composite materials for enable the structure withstanding seismic loads.',
                  'Engineers consider adopt composite materials to enable the structure withstand seismic loads.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Consider\' diikuti gerund (\'adopting\'), \'to enable\' adalah infinitif tujuan, dan \'enable + Object + to-infinitive\' (\'enable the structure to withstand\').',
              ],
              [
                'id' => 80,
                'id_sentence' => 'Dewan direksi menolak untuk menghentikan pendanaan riset sebelum tim menyelesaikan validasi model.',
                'target_word' => 'refuses to discontinue prior to completing',
                'vocab' => [
                  'board of directors' => [
                    'id' => 'dewan direksi',
                    'pos' => '(n phr)',
                  ],
                  'refuse' => [
                    'id' => 'menolak',
                    'pos' => '(v)',
                  ],
                  'discontinue' => [
                    'id' => 'menghentikan / menyetop',
                    'pos' => '(v)',
                  ],
                  'research funding' => [
                    'id' => 'pendanaan riset',
                    'pos' => '(n phr)',
                  ],
                  'prior to' => [
                    'id' => 'sebelum',
                    'pos' => '(prep phr)',
                  ],
                  'complete' => [
                    'id' => 'menyelesaikan',
                    'pos' => '(v)',
                  ],
                  'model validation' => [
                    'id' => 'validasi model',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The board of directors refuses to discontinue research funding prior to the team completing model validation.',
                  'The board of directors refuses discontinuing research funding prior to the team completing model validation.',
                  'The board of directors refuses to discontinue research funding prior to the team complete model validation.',
                  'The board of directors refuses discontinue research funding prior to the team to complete model validation.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Refuse\' wajib diikuti to-infinitive (\'refuses to discontinue\'), dan \'prior to\' adalah preposisi waktu yang diikuti gerund (\'completing\').',
              ],
            ],
          ],
        ];
    }
}
