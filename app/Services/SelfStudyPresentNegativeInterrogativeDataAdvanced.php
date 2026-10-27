<?php

namespace App\Services;

class SelfStudyPresentNegativeInterrogativeDataAdvanced
{
    /**
     * Get the complete Present Negative & Academic Interrogative package.
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
            'banner_title' => 'Present Negative & Academic Interrogative',
            'banner_subtitle' => 'Kuasai konstruksi kalimat negatif verbal (do/does not), nominal (is/are not), penyangkalan hipotesis ilmiah, serta formulasi pertanyaan penelitian formal.',
            'banner_badge' => 'MODULE 1.4 NEGATIVE & INTERROGATIVE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.4
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Kaidah Kalimat Negatif & Interogatif Akademik (Negative & Inverted Syntax)',
            'concept_summary' => 'Dalam penulisan ilmiah formal (IELTS Academic Task 1/2, TOEFL iBT, SAT, serta penulisan tesis dan jurnal ilmiah), kalimat negatif dan interogatif memiliki aturan sintaksis yang sangat ketat. Peneliti menggunakan kalimat negatif untuk menyangkal hipotesis (hypothesis negation), menetapkan batasan metodologi, dan melaporkan temuan non-signifikan secara objektif. Sebaliknya, bentuk interogatif digunakan untuk merumuskan Research Questions (RQ) yang mengarahkan seluruh penyelidikan ilmiah.',
            'rules' => [
                [
                    'rule_title' => '1. Verbal Negative: do not vs does not + V1',
                    'rule_formula' => 'Plural / I / You / We / They + DO NOT + V1 | Singular / He / She / It + DOES NOT + V1',
                    'rule_description' => 'Setelah auxiliary do not atau does not, kata kerja utama WAJIB kembali ke bentuk Verb 1 murni tanpa imbuhan -s/-es. Dilarang menambahkan to be (is/are) pada kalimat verbal negatif.',
                    'examples' => [
                        [
                            'en' => 'Researchers do not accept unverified claims without empirical evidence.',
                            'id' => 'Para peneliti tidak menerima klaim tak terverifikasi tanpa bukti empiris.',
                            'note' => 'Subjek jamak "Researchers" menggunakan auxiliary "do not" diikuti kata kerja dasar V1 "accept".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Nominal & Passive Negative: is/are not (+ Complement / V3)',
                    'rule_formula' => 'Nominal: S + is/are not + Adjective/Noun | Pasif: S + is/are not + V3 (Past Participle)',
                    'rule_description' => 'Gunakan linking verb to be + not untuk kalimat tanpa kata kerja aksi (seperti menerangkan kata sifat: consistent, significant, valid) atau saat objek penelitian dikenai tindakan pasif.',
                    'examples' => [
                        [
                            'en' => 'The research findings are not consistent with theoretical predictions.',
                            'id' => 'Temuan penelitian tersebut tidak konsisten dengan prediksi teoretis.',
                            'note' => 'Kalimat nominal negatif: gunakan to be "are not" diikuti kata sifat "consistent".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Penyangkalan Hipotesis Ilmiah (Hypothesis Negation)',
                    'rule_formula' => 'Evidence / Data / Findings + does/do not + (support / substantiate / corroborate / validate) + Hypothesis',
                    'rule_description' => 'Dalam bab Results dan Discussion, gunakan verba pembuktian akademik formal untuk melaporkan penolakan hipotesis nol secara berhati-hati (hedging).',
                    'examples' => [
                        [
                            'en' => 'Empirical data do not substantiate the assumption of continuous market equilibrium.',
                            'id' => 'Data empiris tidak memperkuat asumsi keseimbangan pasar berkelanjutan.',
                            'note' => 'Gaya bahasa formal dan presisi standar jurnal internasional.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Inverted Syntax pada Research Questions (RQ)',
                    'rule_formula' => 'Wh- Phrase + DOES/DO/IS/ARE + Subject + V1/Complement...?',
                    'rule_description' => 'Pertanyaan penelitian langsung mewajibkan inversi auxiliary ke depan subjek. Untuk pertanyaan Yes/No, letakkan Does/Do/Is/Are di paling awal kalimat.',
                    'examples' => [
                        [
                            'en' => 'To what extent does monetary volatility undermine foreign direct investment?',
                            'id' => 'Sejauh mana volatilitas moneter melemahkan investasi asing langsung?',
                            'note' => 'Inversi: To what extent + does (auxiliary) + volatility (subjek) + undermine (V1).'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Parameter', '1. Verbal Negative', '2. Nominal Negative', '3. Passive Negative', '4. Academic RQ'],
                'rows' => [
                    ['Auxiliary Wajib', 'do not / does not', 'is not / are not', 'is not / are not', 'Does / Do / Is / Are (di depan S)'],
                    ['Komponen Utama', 'Verb 1 (Base Form)', 'Adjective / Noun Phrase', 'Verb 3 (Past Participle)', 'Wh- + Aux + Subject + Verb/Comp'],
                    ['Contoh Kalimat', 'Data do not confirm X.', 'Results are not valid.', 'Samples are not heated.', 'Does policy X improve Y?'],
                    ['Kesalahan Fatal', 'Data are not confirm X.', 'Results do not valid.', 'Samples do not heated.', 'How policy X improves Y?'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The author does not mentions the primary causal factors.',
                    'correct' => 'The author does not mention the primary causal factors.',
                    'explanation' => 'Double Inflection: Jangan menambahkan akhiran -s pada "mention" karena sudah diserap oleh auxiliary "does".'
                ],
                [
                    'incorrect' => 'The initial hypothesis does not consistent with recent observations.',
                    'correct' => 'The initial hypothesis is not consistent with recent observations.',
                    'explanation' => 'Wrong Auxiliary: Kata "consistent" adalah kata sifat (Adjective), sehingga wajib menggunakan to be: "is not consistent".'
                ],
                [
                    'incorrect' => 'To what extent the regulatory framework protects retail investors?',
                    'correct' => 'To what extent does the regulatory framework protect retail investors?',
                    'explanation' => 'Missing Inversion: Pertanyaan langsung (direct RQ) wajib menempatkan auxiliary "does" di depan subjek.'
                ],
                [
                    'incorrect' => 'Specimens do not exposed to ambient radiation during transportation.',
                    'correct' => 'Specimens are not exposed to ambient radiation during transportation.',
                    'explanation' => 'Passive Confusion: Kalimat pasif negatif wajib menggunakan "are not exposed", bukan "do not exposed".'
                ],
            ],
            'exam_tips' => [
                'Selalu periksa apakah kata setelah kata negatif adalah kata kerja (gunakan do/does not) atau kata sifat/status (gunakan is/are not).',
                'Dalam merumuskan Research Questions (RQ), jangan pernah lupa melakukan pembalikan posisi auxiliary ke depan subjek.',
                'Gunakan auxiliary "does" untuk subjek uncountable seperti evidence, research, literature, software, dan information.'
            ],
        ];
    }

    /**
     * Complete list of 8 sub-lessons for Topic 1.4
     */
    public static function getSubLessons(): array
    {
        return [
          [
            'id' => 'verbal_neg_plural',
            'name' => 'Verbal Negative: Subjek Jamak & I/You/We/They (do not + V1)',
            'code' => '1.4.1',
            'concept_title' => 'Kalimat Verbal Negatif dengan Subjek I, You, We, They, dan Plural Nouns',
            'concept_description' => 'Kalimat verbal negatif menyatakan bahwa subjek tidak melakukan suatu tindakan atau proses. Untuk subjek jamak (They, We, You, Plural Nouns seperti researchers, institutions, participants), gunakan auxiliary \'do not\' (atau \'don\'t\' dalam konteks semi-formal) diikuti bentuk dasar kata kerja (Verb 1 / bare infinitive). Jangan pernah menambahkan akhiran -s/-es atau menyisipkan to be \'are\' pada kalimat verbal negatif.',
            'formula' => 'Subject (I / You / We / They / Plural Nouns) + DO NOT + Verb 1 (Base Form) + Object / Complement',
            'rules' => [
              'Gunakan auxiliary \'do not\' untuk subjek jamak dan kata ganti I, You, We, They.',
              'Kata kerja utama setelah \'do not\' WAJIB berupa Verb 1 bentuk dasar murni tanpa imbuhan.',
              'Dilarang menambahkan to be \'are\' (misal: \'They are not accept\' adalah SALAH).',
              'Dalam register akademik formal, hindari bentuk singkatan \'don\'t\', gunakan \'do not\'.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Para peneliti tidak menerima hasil eksperimen tanpa pengujian ulang yang independen.',
                'target_word' => 'do not accept',
                'vocab' => [
                  'researchers' => [
                    'id' => 'para peneliti',
                    'pos' => '(n)',
                  ],
                  'accept' => [
                    'id' => 'menerima',
                    'pos' => '(v)',
                  ],
                  'experimental results' => [
                    'id' => 'hasil eksperimen',
                    'pos' => '(n phr)',
                  ],
                  'independent replication' => [
                    'id' => 'pengujian ulang independen',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers do not accept experimental results without independent replication.',
                  'Researchers are not accept experimental results without independent replication.',
                  'Researchers does not accept experimental results without independent replication.',
                  'Researchers do not accepts experimental results without independent replication.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'Researchers\' adalah jamak (plural noun), sehingga auxiliary negatif yang benar adalah \'do not\', diikuti kata kerja bentuk dasar \'accept\'.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Sebagian besar universitas negeri tidak mengenakan biaya pendaftaran untuk mahasiswa sarjana kurang mampu.',
                'target_word' => 'do not charge',
                'vocab' => [
                  'public universities' => [
                    'id' => 'universitas negeri',
                    'pos' => '(n phr)',
                  ],
                  'charge' => [
                    'id' => 'mengenakan biaya',
                    'pos' => '(v)',
                  ],
                  'application fees' => [
                    'id' => 'biaya pendaftaran',
                    'pos' => '(n phr)',
                  ],
                  'underprivileged undergraduates' => [
                    'id' => 'mahasiswa sarjana kurang mampu',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Most public universities do not charge application fees for underprivileged undergraduates.',
                  'Most public universities does not charge application fees for underprivileged undergraduates.',
                  'Most public universities are not charge application fees for underprivileged undergraduates.',
                  'Most public universities do not charges application fees for underprivileged undergraduates.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'Most public universities\' bersifat jamak, memerlukan auxiliary \'do not\' + V1 murni \'charge\'.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Kami tidak mempublikasikan data mentah sebelum memverifikasi integritas metodologisnya.',
                'target_word' => 'do not publish',
                'vocab' => [
                  'raw data' => [
                    'id' => 'data mentah',
                    'pos' => '(n phr)',
                  ],
                  'publish' => [
                    'id' => 'mempublikasikan',
                    'pos' => '(v)',
                  ],
                  'verify' => [
                    'id' => 'memverifikasi',
                    'pos' => '(v)',
                  ],
                  'methodological integrity' => [
                    'id' => 'integritas metodologis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'We do not publish raw data prior to verifying its methodological integrity.',
                  'We does not publish raw data prior to verifying its methodological integrity.',
                  'We are not publish raw data prior to verifying its methodological integrity.',
                  'We do not publishes raw data prior to verifying its methodological integrity.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'We\' menggunakan auxiliary \'do not\' + Verb 1 \'publish\'.',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Indikator-indikator ekonomi ini tidak mencerminkan daya beli masyarakat berpenghasilan rendah.',
                'target_word' => 'do not reflect',
                'vocab' => [
                  'economic indicators' => [
                    'id' => 'indikator ekonomi',
                    'pos' => '(n phr)',
                  ],
                  'reflect' => [
                    'id' => 'mencerminkan',
                    'pos' => '(v)',
                  ],
                  'purchasing power' => [
                    'id' => 'daya beli',
                    'pos' => '(n phr)',
                  ],
                  'low-income households' => [
                    'id' => 'masyarakat berpenghasilan rendah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'These economic indicators do not reflect the purchasing power of low-income households.',
                  'These economic indicators does not reflect the purchasing power of low-income households.',
                  'These economic indicators are not reflect the purchasing power of low-income households.',
                  'These economic indicators do not reflects the purchasing power of low-income households.',
                ],
                'correct_index' => 0,
                'explanation' => '\'These economic indicators\' adalah frasa benda jamak, sehingga memerlukan \'do not\' + V1 \'reflect\'.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Kedua sistem kendali tersebut tidak beroperasi secara simultan selama prosedur pengujian.',
                'target_word' => 'do not operate',
                'vocab' => [
                  'control systems' => [
                    'id' => 'sistem kendali',
                    'pos' => '(n phr)',
                  ],
                  'operate' => [
                    'id' => 'beroperasi',
                    'pos' => '(v)',
                  ],
                  'simultaneously' => [
                    'id' => 'secara simultan',
                    'pos' => '(adv)',
                  ],
                  'testing procedures' => [
                    'id' => 'prosedur pengujian',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Both control systems do not operate simultaneously during testing procedures.',
                  'Both control systems does not operate simultaneously during testing procedures.',
                  'Both control systems are not operate simultaneously during testing procedures.',
                  'Both control systems do not operates simultaneously during testing procedures.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'Both control systems\' bersifat jamak, wajib memakai \'do not\' + V1 \'operate\'.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Para pengambil kebijakan tidak mengabaikan dampak jangka panjang dari degradasi lingkungan.',
                'target_word' => 'do not ignore',
                'vocab' => [
                  'policymakers' => [
                    'id' => 'para pengambil kebijakan',
                    'pos' => '(n)',
                  ],
                  'ignore' => [
                    'id' => 'mengabaikan',
                    'pos' => '(v)',
                  ],
                  'long-term impacts' => [
                    'id' => 'dampak jangka panjang',
                    'pos' => '(n phr)',
                  ],
                  'environmental degradation' => [
                    'id' => 'degradasi lingkungan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Policymakers do not ignore the long-term impacts of environmental degradation.',
                  'Policymakers does not ignore the long-term impacts of environmental degradation.',
                  'Policymakers are not ignore the long-term impacts of environmental degradation.',
                  'Policymakers do not ignores the long-term impacts of environmental degradation.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'Policymakers\' adalah kata benda jamak, sehingga membutuhkan \'do not\' + V1 \'ignore\'.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Negara-negara berkembang tidak memiliki cadangan devisa yang memadai untuk menahan guncangan eksternal.',
                'target_word' => 'do not possess',
                'vocab' => [
                  'developing nations' => [
                    'id' => 'negara-negara berkembang',
                    'pos' => '(n phr)',
                  ],
                  'possess' => [
                    'id' => 'memiliki',
                    'pos' => '(v)',
                  ],
                  'adequate foreign reserves' => [
                    'id' => 'cadangan devisa memadai',
                    'pos' => '(n phr)',
                  ],
                  'external shocks' => [
                    'id' => 'guncangan eksternal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Developing nations do not possess adequate foreign reserves to withstand external shocks.',
                  'Developing nations does not possess adequate foreign reserves to withstand external shocks.',
                  'Developing nations are not possess adequate foreign reserves to withstand external shocks.',
                  'Developing nations do not possesses adequate foreign reserves to withstand external shocks.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'Developing nations\' memerlukan auxiliary \'do not\' + V1 \'possess\'.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Saya tidak menyarankan penggunaan metodologi ini dalam studi populasi berskala besar.',
                'target_word' => 'do not advocate',
                'vocab' => [
                  'advocate' => [
                    'id' => 'menyarankan / mendukung',
                    'pos' => '(v)',
                  ],
                  'methodology' => [
                    'id' => 'metodologi',
                    'pos' => '(n)',
                  ],
                  'large-scale population studies' => [
                    'id' => 'studi populasi berskala besar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'I do not advocate the deployment of this methodology in large-scale population studies.',
                  'I does not advocate the deployment of this methodology in large-scale population studies.',
                  'I am not advocate the deployment of this methodology in large-scale population studies.',
                  'I do not advocates the deployment of this methodology in large-scale population studies.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'I\' berpasangan dengan auxiliary \'do not\' diikuti verb murni \'advocate\'.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Sensor-sensor optik tersebut tidak merekam radiasi inframerah pada panjang gelombang kritis.',
                'target_word' => 'do not record',
                'vocab' => [
                  'optical sensors' => [
                    'id' => 'sensor-sensor optik',
                    'pos' => '(n phr)',
                  ],
                  'record' => [
                    'id' => 'merekam',
                    'pos' => '(v)',
                  ],
                  'infrared radiation' => [
                    'id' => 'radiasi inframerah',
                    'pos' => '(n phr)',
                  ],
                  'critical wavelengths' => [
                    'id' => 'panjang gelombang kritis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The optical sensors do not record infrared radiation at critical wavelengths.',
                  'The optical sensors does not record infrared radiation at critical wavelengths.',
                  'The optical sensors are not record infrared radiation at critical wavelengths.',
                  'The optical sensors do not records infrared radiation at critical wavelengths.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The optical sensors\' adalah jamak, menggunakan \'do not\' + V1 \'record\'.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Para ahli bedah tidak melakukan prosedur invasif tanpa persetujuan tertulis dari pasien.',
                'target_word' => 'do not perform',
                'vocab' => [
                  'surgeons' => [
                    'id' => 'para ahli bedah',
                    'pos' => '(n)',
                  ],
                  'perform' => [
                    'id' => 'melakukan',
                    'pos' => '(v)',
                  ],
                  'invasive procedures' => [
                    'id' => 'prosedur invasif',
                    'pos' => '(n phr)',
                  ],
                  'written consent' => [
                    'id' => 'persetujuan tertulis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Surgeons do not perform invasive procedures without written patient consent.',
                  'Surgeons does not perform invasive procedures without written patient consent.',
                  'Surgeons are not perform invasive procedures without written patient consent.',
                  'Surgeons do not performs invasive procedures without written patient consent.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'Surgeons\' menggunakan auxiliary \'do not\' diikuti kata kerja dasar \'perform\'.',
              ],
            ],
          ],
          [
            'id' => 'verbal_neg_singular',
            'name' => 'Verbal Negative: Subjek Tunggal & Uncountable (does not + V1)',
            'code' => '1.4.2',
            'concept_title' => 'Kalimat Verbal Negatif dengan Subjek He, She, It, Benda Tunggal, dan Uncountable Nouns',
            'concept_description' => 'Ketika subjek kalimat berupa orang ketiga tunggal (He, She, It, nama orang/benda tunggal) atau benda tak dapat dihitung (Uncountable Nouns seperti research, evidence, literature, software, water), auxiliary negatif yang wajib digunakan adalah \'does not\'. Karena imbuhan orang ketiga tunggal (-s/-es) sudah diserap oleh auxiliary \'does\', kata kerja utama WAJIB kembali ke bentuk dasar (Verb 1 murni). Kesalahan fatal penutur bahasa Inggris non-pribumi adalah mempertahankan akhiran -s pada kata kerja (misal: \'The system does not works\' adalah SALAH).',
            'formula' => 'Subject (He / She / It / Singular & Uncountable) + DOES NOT + Verb 1 (Base Form) + Complement',
            'rules' => [
              'Gunakan \'does not\' untuk subjek tunggal dan kata benda tak dapat dihitung (uncountable).',
              'Kata kerja utama setelah \'does not\' TIDAK BOLEH berakhiran -s atau -es.',
              'Jangan pernah menyisipkan to be \'is\' sebelum kata kerja verbal (e.g., \'The model is not require\' adalah SALAH).',
              'Perhatikan bahwa kata benda abstrak seperti evidence, research, dan literature bersifat uncountable dan menggunakan \'does not\'.',
            ],
            'exercises' => [
              [
                'id' => 11,
                'id_sentence' => 'Protokol keamanan yang baru tidak memperlambat kinerja pemrosesan data jaringan.',
                'target_word' => 'does not decelerate',
                'vocab' => [
                  'security protocol' => [
                    'id' => 'protokol keamanan',
                    'pos' => '(n phr)',
                  ],
                  'decelerate' => [
                    'id' => 'memperlambat',
                    'pos' => '(v)',
                  ],
                  'data processing performance' => [
                    'id' => 'kinerja pemrosesan data',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The new security protocol does not decelerate network data processing performance.',
                  'The new security protocol do not decelerate network data processing performance.',
                  'The new security protocol is not decelerate network data processing performance.',
                  'The new security protocol does not decelerates network data processing performance.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'The new security protocol\' wajib menggunakan \'does not\' + V1 murni \'decelerate\' tanpa akhiran -s.',
              ],
              [
                'id' => 12,
                'id_sentence' => 'Bukti empiris yang tersedia tidak menunjukkan adanya korelasi langsung antara kedua parameter tersebut.',
                'target_word' => 'does not indicate',
                'vocab' => [
                  'empirical evidence' => [
                    'id' => 'bukti empiris',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'indicate' => [
                    'id' => 'menunjukkan',
                    'pos' => '(v)',
                  ],
                  'direct correlation' => [
                    'id' => 'korelasi langsung',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Available empirical evidence does not indicate a direct correlation between the two parameters.',
                  'Available empirical evidence do not indicate a direct correlation between the two parameters.',
                  'Available empirical evidence is not indicate a direct correlation between the two parameters.',
                  'Available empirical evidence does not indicates a direct correlation between the two parameters.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Evidence\' adalah kata benda tak dapat dihitung (uncountable), sehingga dianggap tunggal dan menggunakan \'does not\' + V1 \'indicate\'.',
              ],
              [
                'id' => 13,
                'id_sentence' => 'Perangkat lunak simulasi ini tidak membutuhkan kartu grafis berspesifikasi tinggi.',
                'target_word' => 'does not require',
                'vocab' => [
                  'simulation software' => [
                    'id' => 'perangkat lunak simulasi',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'require' => [
                    'id' => 'membutuhkan',
                    'pos' => '(v)',
                  ],
                  'high-end graphics card' => [
                    'id' => 'kartu grafis berspesifikasi tinggi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This simulation software does not require a high-end graphics card.',
                  'This simulation software do not require a high-end graphics card.',
                  'This simulation software is not require a high-end graphics card.',
                  'This simulation software does not requires a high-end graphics card.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Software\' bersifat uncountable, memakai auxiliary \'does not\' + V1 \'require\'.',
              ],
              [
                'id' => 14,
                'id_sentence' => 'Pemerintah pusat tidak campur tangan dalam keputusan manajerial universitas otonom.',
                'target_word' => 'does not intervene',
                'vocab' => [
                  'central government' => [
                    'id' => 'pemerintah pusat',
                    'pos' => '(n phr)',
                  ],
                  'intervene' => [
                    'id' => 'campur tangan',
                    'pos' => '(v)',
                  ],
                  'managerial decisions' => [
                    'id' => 'keputusan manajerial',
                    'pos' => '(n phr)',
                  ],
                  'autonomous universities' => [
                    'id' => 'universitas otonom',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The central government does not intervene in the managerial decisions of autonomous universities.',
                  'The central government do not intervene in the managerial decisions of autonomous universities.',
                  'The central government is not intervene in the managerial decisions of autonomous universities.',
                  'The central government does not intervenes in the managerial decisions of autonomous universities.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'The central government\' memerlukan \'does not\' + V1 murni \'intervene\'.',
              ],
              [
                'id' => 15,
                'id_sentence' => 'Penelitian terdahulu tidak menjelaskan anomali termal yang diamati di zona samudera dalam.',
                'target_word' => 'does not explain',
                'vocab' => [
                  'previous literature' => [
                    'id' => 'penelitian terdahulu / kepustakaan',
                    'pos' => '(n phr)',
                  ],
                  'explain' => [
                    'id' => 'menjelaskan',
                    'pos' => '(v)',
                  ],
                  'thermal anomaly' => [
                    'id' => 'anomali termal',
                    'pos' => '(n phr)',
                  ],
                  'deep-ocean zones' => [
                    'id' => 'zona samudera dalam',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Previous literature does not explain the thermal anomaly observed in deep-ocean zones.',
                  'Previous literature do not explain the thermal anomaly observed in deep-ocean zones.',
                  'Previous literature is not explain the thermal anomaly observed in deep-ocean zones.',
                  'Previous literature does not explains the thermal anomaly observed in deep-ocean zones.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Literature\' adalah uncountable noun (tunggal), membutuhkan \'does not\' + V1 \'explain\'.',
              ],
              [
                'id' => 16,
                'id_sentence' => 'Model matematika ini tidak mengasumsikan distribusi probabilitas normal pada variabel acak.',
                'target_word' => 'does not assume',
                'vocab' => [
                  'mathematical model' => [
                    'id' => 'model matematika',
                    'pos' => '(n phr)',
                  ],
                  'assume' => [
                    'id' => 'mengasumsikan',
                    'pos' => '(v)',
                  ],
                  'normal probability distribution' => [
                    'id' => 'distribusi probabilitas normal',
                    'pos' => '(n phr)',
                  ],
                  'random variables' => [
                    'id' => 'variabel acak',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This mathematical model does not assume a normal probability distribution across random variables.',
                  'This mathematical model do not assume a normal probability distribution across random variables.',
                  'This mathematical model is not assume a normal probability distribution across random variables.',
                  'This mathematical model does not assumes a normal probability distribution across random variables.',
                ],
                'correct_index' => 0,
                'explanation' => '\'This mathematical model\' tunggal, menggunakan \'does not\' + V1 \'assume\'.',
              ],
              [
                'id' => 17,
                'id_sentence' => 'Tingkat inflasi bulanan tidak mempengaruhi keputusan investasi korporasi multinasional.',
                'target_word' => 'does not affect',
                'vocab' => [
                  'monthly inflation rate' => [
                    'id' => 'tingkat inflasi bulanan',
                    'pos' => '(n phr)',
                  ],
                  'affect' => [
                    'id' => 'mempengaruhi',
                    'pos' => '(v)',
                  ],
                  'investment decisions' => [
                    'id' => 'keputusan investasi',
                    'pos' => '(n phr)',
                  ],
                  'multinational corporations' => [
                    'id' => 'korporasi multinasional',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The monthly inflation rate does not affect the investment decisions of multinational corporations.',
                  'The monthly inflation rate do not affect the investment decisions of multinational corporations.',
                  'The monthly inflation rate is not affect the investment decisions of multinational corporations.',
                  'The monthly inflation rate does not affects the investment decisions of multinational corporations.',
                ],
                'correct_index' => 0,
                'explanation' => 'Head noun \'rate\' tunggal, menggunakan \'does not\' + V1 \'affect\'.',
              ],
              [
                'id' => 18,
                'id_sentence' => 'Katalis kimia tersebut tidak terurai pada temperatur reaksi di bawah dua ratus derajat.',
                'target_word' => 'does not decompose',
                'vocab' => [
                  'chemical catalyst' => [
                    'id' => 'katalis kimia',
                    'pos' => '(n phr)',
                  ],
                  'decompose' => [
                    'id' => 'terurai / membusuk',
                    'pos' => '(v)',
                  ],
                  'reaction temperature' => [
                    'id' => 'temperatur reaksi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The chemical catalyst does not decompose at reaction temperatures below two hundred degrees.',
                  'The chemical catalyst do not decompose at reaction temperatures below two hundred degrees.',
                  'The chemical catalyst is not decompose at reaction temperatures below two hundred degrees.',
                  'The chemical catalyst does not decomposes at reaction temperatures below two hundred degrees.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The chemical catalyst\' tunggal, membutuhkan \'does not\' + V1 \'decompose\'.',
              ],
              [
                'id' => 19,
                'id_sentence' => 'Undang-undang ketenagakerjaan yang berlaku tidak melarang kerja paruh waktu bagi pelajar internasional.',
                'target_word' => 'does not prohibit',
                'vocab' => [
                  'labor legislation' => [
                    'id' => 'undang-undang ketenagakerjaan',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'prohibit' => [
                    'id' => 'melarang',
                    'pos' => '(v)',
                  ],
                  'part-time employment' => [
                    'id' => 'kerja paruh waktu',
                    'pos' => '(n phr)',
                  ],
                  'international students' => [
                    'id' => 'pelajar internasional',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Prevailing labor legislation does not prohibit part-time employment for international students.',
                  'Prevailing labor legislation do not prohibit part-time employment for international students.',
                  'Prevailing labor legislation is not prohibit part-time employment for international students.',
                  'Prevailing labor legislation does not prohibits part-time employment for international students.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Legislation\' bersifat uncountable (tunggal), sehingga memakai \'does not\' + V1 \'prohibit\'.',
              ],
              [
                'id' => 20,
                'id_sentence' => 'Metode kromatografi ini tidak menghasilkan limbah beracun selama proses elusi.',
                'target_word' => 'does not generate',
                'vocab' => [
                  'chromatography method' => [
                    'id' => 'metode kromatografi',
                    'pos' => '(n phr)',
                  ],
                  'generate' => [
                    'id' => 'menghasilkan',
                    'pos' => '(v)',
                  ],
                  'hazardous effluents' => [
                    'id' => 'limbah beracun',
                    'pos' => '(n phr)',
                  ],
                  'elution process' => [
                    'id' => 'proses elusi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This chromatography method does not generate hazardous effluents during the elution process.',
                  'This chromatography method do not generate hazardous effluents during the elution process.',
                  'This chromatography method is not generate hazardous effluents during the elution process.',
                  'This chromatography method does not generates hazardous effluents during the elution process.',
                ],
                'correct_index' => 0,
                'explanation' => '\'This chromatography method\' adalah subjek tunggal, membutuhkan \'does not\' + V1 \'generate\'.',
              ],
            ],
          ],
          [
            'id' => 'nominal_negative',
            'name' => 'Nominal Negative: am/is/are not + Complement',
            'code' => '1.4.3',
            'concept_title' => 'Kalimat Nominal Negatif: Penyangkalan Status, Kualitas, dan Definisi',
            'concept_description' => 'Kalimat nominal negatif digunakan untuk menyangkal status, kategori, sifat (adjective), atau lokasi subjek tanpa melibatkan kata kerja aksi. Strukturnya dibentuk dengan menyematkan partikel \'not\' tepat setelah to be (is not, are not, am not). Kesalahan paling sering terjadi adalah menggunakan \'does not\' atau \'do not\' sebelum kata sifat atau kata benda (e.g., \'The result does not consistent\' adalah SALAH, yang benar adalah \'The result is not consistent\').',
            'formula' => 'Subject + IS / ARE / AM NOT + Complement (Adjective / Noun Phrase / Prepositional Phrase)',
            'rules' => [
              'Wajib menggunakan \'is not\', \'are not\', atau \'am not\' sebelum Complement.',
              'DILARANG menggunakan \'do not\' atau \'does not\' sebelum kata sifat (Adjective) atau kata benda (Noun).',
              'Dalam register akademik formal, hindari kontraksi \'isn\'t\' atau \'aren\'t\', gunakan bentuk lengkap.',
              'Pastikan kesesuaian singular (is not) dan plural (are not) dengan subjek kalimat.',
            ],
            'exercises' => [
              [
                'id' => 21,
                'id_sentence' => 'Temuan-temuan awal ini tidak konsisten dengan teori ekonomi neoklasik standar.',
                'target_word' => 'are not consistent',
                'vocab' => [
                  'preliminary findings' => [
                    'id' => 'temuan-temuan awal',
                    'pos' => '(n phr)',
                  ],
                  'consistent' => [
                    'id' => 'konsisten',
                    'pos' => '(adj)',
                  ],
                  'neoclassical economic theory' => [
                    'id' => 'teori ekonomi neoklasik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'These preliminary findings are not consistent with standard neoclassical economic theory.',
                  'These preliminary findings do not consistent with standard neoclassical economic theory.',
                  'These preliminary findings is not consistent with standard neoclassical economic theory.',
                  'These preliminary findings does not consistent with standard neoclassical economic theory.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kata \'consistent\' adalah kata sifat (Adjective). Untuk subjek jamak \'findings\', predikat negatif nominal yang tepat adalah to be \'are not\', BUKAN \'do not\'.',
              ],
              [
                'id' => 22,
                'id_sentence' => 'Biaya operasional laboratorium klinis tidak murah bagi institusi swasta skala kecil.',
                'target_word' => 'is not negligible',
                'vocab' => [
                  'operational expenditure' => [
                    'id' => 'biaya operasional',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'negligible' => [
                    'id' => 'dapat diabaikan / murah',
                    'pos' => '(adj)',
                  ],
                  'small-scale private institutions' => [
                    'id' => 'institusi swasta skala kecil',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The operational expenditure of clinical laboratories is not negligible for small-scale private institutions.',
                  'The operational expenditure of clinical laboratories does not negligible for small-scale private institutions.',
                  'The operational expenditure of clinical laboratories are not negligible for small-scale private institutions.',
                  'The operational expenditure of clinical laboratories do not negligible for small-scale private institutions.',
                ],
                'correct_index' => 0,
                'explanation' => 'Head noun \'expenditure\' adalah tunggal, dan \'negligible\' adalah adjective; predikat wajib berupa \'is not\'.',
              ],
              [
                'id' => 23,
                'id_sentence' => 'Sampel air tanah dari sumur bor tersebut tidak aman untuk konsumsi manusia langsung.',
                'target_word' => 'is not safe',
                'vocab' => [
                  'groundwater sample' => [
                    'id' => 'sampel air tanah',
                    'pos' => '(n phr)',
                  ],
                  'safe' => [
                    'id' => 'aman',
                    'pos' => '(adj)',
                  ],
                  'direct human consumption' => [
                    'id' => 'konsumsi manusia langsung',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The groundwater sample from the borehole is not safe for direct human consumption.',
                  'The groundwater sample from the borehole does not safe for direct human consumption.',
                  'The groundwater sample from the borehole are not safe for direct human consumption.',
                  'The groundwater sample from the borehole do not safe for direct human consumption.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'sample\' diikuti linking verb to be \'is not\' sebelum adjective \'safe\'.',
              ],
              [
                'id' => 24,
                'id_sentence' => 'Perubahan iklim bukanlah fenomena lokal yang terisolasi di belahan bumi utara.',
                'target_word' => 'is not an isolated phenomenon',
                'vocab' => [
                  'climate change' => [
                    'id' => 'perubahan iklim',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'isolated phenomenon' => [
                    'id' => 'fenomena terisolasi',
                    'pos' => '(n phr)',
                  ],
                  'northern hemisphere' => [
                    'id' => 'belahan bumi utara',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Climate change is not an isolated phenomenon restricted to the northern hemisphere.',
                  'Climate change does not an isolated phenomenon restricted to the northern hemisphere.',
                  'Climate change are not an isolated phenomenon restricted to the northern hemisphere.',
                  'Climate change do not an isolated phenomenon restricted to the northern hemisphere.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Climate change\' adalah subjek tunggal yang menerangkan Noun Phrase pelengkap, sehingga wajib menggunakan \'is not\'.',
              ],
              [
                'id' => 25,
                'id_sentence' => 'Data statistik dari kedua kuesioner tersebut tidak identik dalam hal deviasi standar.',
                'target_word' => 'are not identical',
                'vocab' => [
                  'statistical data' => [
                    'id' => 'data statistik',
                    'pos' => '(n phr, plural)',
                  ],
                  'identical' => [
                    'id' => 'identik',
                    'pos' => '(adj)',
                  ],
                  'standard deviation' => [
                    'id' => 'deviasi standar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Statistical data from both questionnaires are not identical in terms of standard deviation.',
                  'Statistical data from both questionnaires do not identical in terms of standard deviation.',
                  'Statistical data from both questionnaires is not identical in terms of standard deviation.',
                  'Statistical data from both questionnaires does not identical in terms of standard deviation.',
                ],
                'correct_index' => 0,
                'explanation' => 'Dalam penulisan sains formal, \'data\' sering diperlakukan jamak (dari datum), diikuti \'are not\' sebelum adjective \'identical\'.',
              ],
              [
                'id' => 26,
                'id_sentence' => 'Kebijakan fiskal baru ini tidak memadai untuk menekan laju defisit anggaran nasional.',
                'target_word' => 'is not sufficient',
                'vocab' => [
                  'fiscal policy' => [
                    'id' => 'kebijakan fiskal',
                    'pos' => '(n phr)',
                  ],
                  'sufficient' => [
                    'id' => 'memadai',
                    'pos' => '(adj)',
                  ],
                  'national budget deficit' => [
                    'id' => 'defisit anggaran nasional',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This new fiscal policy is not sufficient to curb the expanding national budget deficit.',
                  'This new fiscal policy does not sufficient to curb the expanding national budget deficit.',
                  'This new fiscal policy are not sufficient to curb the expanding national budget deficit.',
                  'This new fiscal policy do not sufficient to curb the expanding national budget deficit.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'policy\' memerlukan \'is not\' sebelum kata sifat \'sufficient\'.',
              ],
              [
                'id' => 27,
                'id_sentence' => 'Metode pengelasan manual tidak layak untuk fabrikasi tangki bertekanan nuklir.',
                'target_word' => 'is not feasible',
                'vocab' => [
                  'manual welding' => [
                    'id' => 'pengelasan manual',
                    'pos' => '(n phr, gerund/uncountable)',
                  ],
                  'feasible' => [
                    'id' => 'layak / memungkinkan',
                    'pos' => '(adj)',
                  ],
                  'nuclear pressure vessels' => [
                    'id' => 'tangki bertekanan nuklir',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Manual welding is not feasible for the fabrication of nuclear pressure vessels.',
                  'Manual welding does not feasible for the fabrication of nuclear pressure vessels.',
                  'Manual welding are not feasible for the fabrication of nuclear pressure vessels.',
                  'Manual welding do not feasible for the fabrication of nuclear pressure vessels.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Manual welding\' adalah gerund tunggal, diikuti linking verb \'is not\' + adjective \'feasible\'.',
              ],
              [
                'id' => 28,
                'id_sentence' => 'Tingkat korelasi antara kedua variabel tidak signifikan pada ambang batas lima persen.',
                'target_word' => 'is not significant',
                'vocab' => [
                  'correlation coefficient' => [
                    'id' => 'koefisien korelasi',
                    'pos' => '(n phr)',
                  ],
                  'significant' => [
                    'id' => 'signifikan',
                    'pos' => '(adj)',
                  ],
                  'five percent threshold' => [
                    'id' => 'ambang batas lima persen',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The correlation coefficient between the two variables is not significant at the five percent threshold.',
                  'The correlation coefficient between the two variables does not significant at the five percent threshold.',
                  'The correlation coefficient between the two variables are not significant at the five percent threshold.',
                  'The correlation coefficient between the two variables do not significant at the five percent threshold.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The correlation coefficient\' adalah kata benda tunggal; pasangannya adalah \'is not\' sebelum kata sifat \'significant\'.',
              ],
              [
                'id' => 29,
                'id_sentence' => 'Bahan komposit sintetis ini tidak rentan terhadap korosi elektrokimia di lingkungan air asin.',
                'target_word' => 'is not susceptible',
                'vocab' => [
                  'synthetic composite material' => [
                    'id' => 'bahan komposit sintetis',
                    'pos' => '(n phr)',
                  ],
                  'susceptible' => [
                    'id' => 'rentan',
                    'pos' => '(adj)',
                  ],
                  'electrochemical corrosion' => [
                    'id' => 'korosi elektrokimia',
                    'pos' => '(n phr)',
                  ],
                  'saline environments' => [
                    'id' => 'lingkungan air asin',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This synthetic composite material is not susceptible to electrochemical corrosion in saline environments.',
                  'This synthetic composite material does not susceptible to electrochemical corrosion in saline environments.',
                  'This synthetic composite material are not susceptible to electrochemical corrosion in saline environments.',
                  'This synthetic composite material do not susceptible to electrochemical corrosion in saline environments.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'material\' membutuhkan to be \'is not\' sebelum adjective \'susceptible\'.',
              ],
              [
                'id' => 30,
                'id_sentence' => 'Asumsi-asumsi teoritis tersebut tidak relevan dalam konteks pasar berkembang saat ini.',
                'target_word' => 'are not relevant',
                'vocab' => [
                  'theoretical assumptions' => [
                    'id' => 'asumsi teoritis',
                    'pos' => '(n phr)',
                  ],
                  'relevant' => [
                    'id' => 'relevan',
                    'pos' => '(adj)',
                  ],
                  'emerging markets' => [
                    'id' => 'pasar berkembang',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'These theoretical assumptions are not relevant in the contemporary context of emerging markets.',
                  'These theoretical assumptions do not relevant in the contemporary context of emerging markets.',
                  'These theoretical assumptions is not relevant in the contemporary context of emerging markets.',
                  'These theoretical assumptions does not relevant in the contemporary context of emerging markets.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Theoretical assumptions\' bersifat jamak, wajib memakai \'are not\' sebelum kata sifat \'relevant\'.',
              ],
            ],
          ],
          [
            'id' => 'passive_negative',
            'name' => 'Passive Negative: is/am/are not + Verb 3',
            'code' => '1.4.4',
            'concept_title' => 'Kalimat Pasif Negatif Ilmiah: Penyangkalan Tindakan atau Perlakuan Eksperimental',
            'concept_description' => 'Kalimat pasif negatif digunakan untuk menyatakan bahwa subjek (spesimen, sampel, variabel, atau partisipan penelitian) TIDAK dikenai suatu tindakan atau perlakuan tertentu. Rumusnya dibentuk dari to be (is/are/am) + NOT + Verb 3 (Past Participle). Struktur ini sangat krusial dalam bab Metodologi untuk menegaskan batasan eksperimen dan kondisi kontrol.',
            'formula' => 'Subject + IS / ARE NOT + Verb 3 (Past Participle) + (Prepositional Modifier / by Agent)',
            'rules' => [
              'Wajib menggunakan to be (is/are not) diikuti Verb 3 (Past Participle).',
              'Jangan pernah menggunakan \'do not\' atau \'does not\' untuk kalimat pasif (e.g., \'Specimens do not heated\' adalah SALAH).',
              'Pastikan kesesuaian subjek tunggal (is not + V3) dan subjek jamak (are not + V3).',
              'Gunakan frasa preposisi (by / under / in) untuk melengkapi keterangan prosedur eksperimen.',
            ],
            'exercises' => [
              [
                'id' => 31,
                'id_sentence' => 'Spesimen kontrol tidak dipanaskan sebelum dimasukkan ke dalam ruang vakum.',
                'target_word' => 'are not heated',
                'vocab' => [
                  'control specimens' => [
                    'id' => 'spesimen kontrol',
                    'pos' => '(n phr)',
                  ],
                  'heat' => [
                    'id' => 'memanaskan',
                    'pos' => '(v) -> V3: heated',
                  ],
                  'vacuum chamber' => [
                    'id' => 'ruang vakum',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The control specimens are not heated prior to insertion into the vacuum chamber.',
                  'The control specimens do not heated prior to insertion into the vacuum chamber.',
                  'The control specimens is not heated prior to insertion into the vacuum chamber.',
                  'The control specimens are not heating prior to insertion into the vacuum chamber.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'specimens\' dikenai perlakuan pasif negatif: \'are not\' + V3 \'heated\'.',
              ],
              [
                'id' => 32,
                'id_sentence' => 'Limbah kimia beracun tidak dibuang langsung ke saluran pembuangan kota.',
                'target_word' => 'is not discharged',
                'vocab' => [
                  'toxic chemical waste' => [
                    'id' => 'limbah kimia beracun',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'discharge' => [
                    'id' => 'membuang / mengalirkan',
                    'pos' => '(v) -> V3: discharged',
                  ],
                  'municipal drainage channels' => [
                    'id' => 'saluran pembuangan kota',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Toxic chemical waste is not discharged directly into municipal drainage channels.',
                  'Toxic chemical waste does not discharged directly into municipal drainage channels.',
                  'Toxic chemical waste are not discharged directly into municipal drainage channels.',
                  'Toxic chemical waste is not discharging directly into municipal drainage channels.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Waste\' adalah uncountable noun (tunggal), predikat pasif negatifnya adalah \'is not discharged\'.',
              ],
              [
                'id' => 33,
                'id_sentence' => 'Partisipan penelitian tidak diidentifikasi berdasarkan nama asli dalam publikasi ini.',
                'target_word' => 'are not identified',
                'vocab' => [
                  'study participants' => [
                    'id' => 'partisipan penelitian',
                    'pos' => '(n phr)',
                  ],
                  'identify' => [
                    'id' => 'mengidentifikasi',
                    'pos' => '(v) -> V3: identified',
                  ],
                  'real names' => [
                    'id' => 'nama asli',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Study participants are not identified by their real names in this publication.',
                  'Study participants do not identified by their real names in this publication.',
                  'Study participants is not identified by their real names in this publication.',
                  'Study participants are not identify by their real names in this publication.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'participants\' menggunakan pasif negatif \'are not identified\'.',
              ],
              [
                'id' => 34,
                'id_sentence' => 'Perlakuan termal tambahan tidak diwajibkan untuk polimer yang distabilkan secara kimiawi.',
                'target_word' => 'is not required',
                'vocab' => [
                  'thermal treatment' => [
                    'id' => 'perlakuan termal',
                    'pos' => '(n phr)',
                  ],
                  'require' => [
                    'id' => 'mewajibkan',
                    'pos' => '(v) -> V3: required',
                  ],
                  'stabilized polymers' => [
                    'id' => 'polimer yang distabilkan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Additional thermal treatment is not required for chemically stabilized polymers.',
                  'Additional thermal treatment does not required for chemically stabilized polymers.',
                  'Additional thermal treatment are not required for chemically stabilized polymers.',
                  'Additional thermal treatment is not requiring for chemically stabilized polymers.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Treatment\' adalah subjek tunggal, pasif negatif yang tepat adalah \'is not required\'.',
              ],
              [
                'id' => 35,
                'id_sentence' => 'Variabel pengganggu tidak diabaikan dalam model regresi linier berganda.',
                'target_word' => 'are not overlooked',
                'vocab' => [
                  'confounding variables' => [
                    'id' => 'variabel pengganggu',
                    'pos' => '(n phr)',
                  ],
                  'overlook' => [
                    'id' => 'mengabaikan',
                    'pos' => '(v) -> V3: overlooked',
                  ],
                  'multiple linear regression model' => [
                    'id' => 'model regresi linier berganda',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Confounding variables are not overlooked in the multiple linear regression model.',
                  'Confounding variables do not overlooked in the multiple linear regression model.',
                  'Confounding variables is not overlooked in the multiple linear regression model.',
                  'Confounding variables are not overlooking in the multiple linear regression model.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'Confounding variables\' menggunakan pasif negatif \'are not overlooked\'.',
              ],
              [
                'id' => 36,
                'id_sentence' => 'Kerahasiaan data responden tidak dikompromikan selama fase transmisi digital.',
                'target_word' => 'is not compromised',
                'vocab' => [
                  'confidentiality of respondent data' => [
                    'id' => 'kerahasiaan data responden',
                    'pos' => '(n phr)',
                  ],
                  'compromise' => [
                    'id' => 'mengompromikan / membocorkan',
                    'pos' => '(v) -> V3: compromised',
                  ],
                  'digital transmission phase' => [
                    'id' => 'fase transmisi digital',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The confidentiality of respondent data is not compromised during the digital transmission phase.',
                  'The confidentiality of respondent data does not compromised during the digital transmission phase.',
                  'The confidentiality of respondent data are not compromised during the digital transmission phase.',
                  'The confidentiality of respondent data is not compromising during the digital transmission phase.',
                ],
                'correct_index' => 0,
                'explanation' => 'Head noun \'confidentiality\' tunggal, menggunakan pasif \'is not compromised\'.',
              ],
              [
                'id' => 37,
                'id_sentence' => 'Subjek uji coba dalam kelompok plasebo tidak diberi senyawa aktif apa pun.',
                'target_word' => 'are not administered',
                'vocab' => [
                  'trial subjects' => [
                    'id' => 'subjek uji coba',
                    'pos' => '(n phr)',
                  ],
                  'placebo cohort' => [
                    'id' => 'kelompok plasebo',
                    'pos' => '(n phr)',
                  ],
                  'administer' => [
                    'id' => 'memberikan (obat/perlakuan)',
                    'pos' => '(v) -> V3: administered',
                  ],
                  'active compound' => [
                    'id' => 'senyawa aktif',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Trial subjects in the placebo cohort are not administered any active compound.',
                  'Trial subjects in the placebo cohort do not administered any active compound.',
                  'Trial subjects in the placebo cohort is not administered any active compound.',
                  'Trial subjects in the placebo cohort are not administering any active compound.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'subjects\' membutuhkan pasif \'are not administered\'.',
              ],
              [
                'id' => 38,
                'id_sentence' => 'Sensor tekanan tidak dikalibrasi ulang setiap kali pengujian selesai.',
                'target_word' => 'is not recalibrated',
                'vocab' => [
                  'pressure transducer' => [
                    'id' => 'sensor tekanan',
                    'pos' => '(n phr)',
                  ],
                  'recalibrate' => [
                    'id' => 'mengkalibrasi ulang',
                    'pos' => '(v) -> V3: recalibrated',
                  ],
                  'individual run' => [
                    'id' => 'setiap kali pengujian',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The pressure transducer is not recalibrated after every individual run.',
                  'The pressure transducer does not recalibrated after every individual run.',
                  'The pressure transducer are not recalibrated after every individual run.',
                  'The pressure transducer is not recalibrating after every individual run.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Transducer\' tunggal, pasif negatifnya adalah \'is not recalibrated\'.',
              ],
              [
                'id' => 39,
                'id_sentence' => 'Kriteria eksklusi tidak diterapkan secara surut kepada partisipan yang sudah terdaftar.',
                'target_word' => 'are not applied',
                'vocab' => [
                  'exclusion criteria' => [
                    'id' => 'kriteria eksklusi',
                    'pos' => '(n phr, plural)',
                  ],
                  'apply' => [
                    'id' => 'menerapkan',
                    'pos' => '(v) -> V3: applied',
                  ],
                  'retroactively' => [
                    'id' => 'secara surut',
                    'pos' => '(adv)',
                  ],
                  'enrolled participants' => [
                    'id' => 'partisipan terdaftar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Exclusion criteria are not applied retroactively to already enrolled participants.',
                  'Exclusion criteria do not applied retroactively to already enrolled participants.',
                  'Exclusion criteria is not applied retroactively to already enrolled participants.',
                  'Exclusion criteria does not applied retroactively to already enrolled participants.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Criteria\' adalah bentuk jamak dari \'criterion\', sehingga memerlukan \'are not applied\'.',
              ],
              [
                'id' => 40,
                'id_sentence' => 'Algoritma kompresi data tidak disertakan dalam versi perangkat lunak sumber terbuka ini.',
                'target_word' => 'is not incorporated',
                'vocab' => [
                  'compression algorithm' => [
                    'id' => 'algoritma kompresi',
                    'pos' => '(n phr)',
                  ],
                  'incorporate' => [
                    'id' => 'menyertakan',
                    'pos' => '(v) -> V3: incorporated',
                  ],
                  'open-source release' => [
                    'id' => 'rilis sumber terbuka',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The data compression algorithm is not incorporated into this open-source release.',
                  'The data compression algorithm does not incorporated into this open-source release.',
                  'The data compression algorithm are not incorporated into this open-source release.',
                  'The data compression algorithm do not incorporated into this open-source release.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'algorithm\' menggunakan bentuk pasif \'is not incorporated\'.',
              ],
            ],
          ],
          [
            'id' => 'advanced_negative_claims',
            'name' => 'Advanced Negative Statements: Formal Claims & Assessments',
            'code' => '1.4.5',
            'concept_title' => 'Penyangkalan Klaim dan Penilaian Formal secara Objektif',
            'concept_description' => 'Dalam penulisan formal, laporan profesional, dan wacana akademik, menyangkal sebuah klaim, penilaian, atau hasil memerlukan register kebahasaan yang objektif, hati-hati (hedging), dan presisi secara sintaksis. Pola ini memadukan subjek formal/abstrak (data, findings, policy, results, evidence, the report) dengan auxiliary negatif dan kata kerja pembuktian atau penilaian (substantiate, corroborate, validate, support, confirm, justify, reflect).',
            'formula' => 'Formal Subject + DOES/DO NOT + (support / substantiate / corroborate / validate / confirm / justify / reflect) + Noun Phrase',
            'rules' => [
              'Gunakan kolokasi formal: \'do not substantiate\', \'does not corroborate\', \'do not validate\', \'does not reflect\'.',
              'Perhatikan perlakuan subjek: \'evidence / research\' (uncountable -> does not), \'findings / data\' (plural -> do not).',
              'Hindari diksi kasual seperti \'cannot prove\' atau \'says nothing about\', gunakan register objektif.',
              'Objek berupa klaim, penilaian, kebijakan, atau hasil formal lain -- tidak terbatas hanya pada hipotesis ilmiah.',
            ],
            'exercises' => [
              [
                'id' => 41,
                'id_sentence' => 'Angka penjualan kuartal ini tidak mendukung proyeksi awal bahwa permintaan akan melonjak tajam.',
                'target_word' => 'do not support',
                'vocab' => [
                  'quarterly sales figures' => [
                    'id' => 'angka penjualan kuartal ini',
                    'pos' => '(n phr, plural)',
                  ],
                  'support' => [
                    'id' => 'mendukung',
                    'pos' => '(v)',
                  ],
                  'initial projection' => [
                    'id' => 'proyeksi awal',
                    'pos' => '(n phr)',
                  ],
                  'surge in demand' => [
                    'id' => 'lonjakan permintaan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This quarter\'s sales figures do not support the initial projection that demand would surge sharply.',
                  'This quarter\'s sales figures does not support the initial projection that demand would surge sharply.',
                  'This quarter\'s sales figures are not support the initial projection that demand would surge sharply.',
                  'This quarter\'s sales figures do not supports the initial projection that demand would surge sharply.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'figures\' menggunakan \'do not support\'. Bentuk verbal negatif \'do not\' + V1 murni \'support\'.',
              ],
              [
                'id' => 42,
                'id_sentence' => 'Laporan audit ini tidak memvalidasi klaim bahwa prosedur baru mengurangi keterlambatan pengiriman.',
                'target_word' => 'does not validate',
                'vocab' => [
                  'audit report' => [
                    'id' => 'laporan audit',
                    'pos' => '(n phr)',
                  ],
                  'validate' => [
                    'id' => 'memvalidasi',
                    'pos' => '(v)',
                  ],
                  'claim' => [
                    'id' => 'klaim',
                    'pos' => '(n)',
                  ],
                  'shipping delays' => [
                    'id' => 'keterlambatan pengiriman',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This audit report does not validate the claim that the new procedure reduces shipping delays.',
                  'This audit report do not validate the claim that the new procedure reduces shipping delays.',
                  'This audit report are not validate the claim that the new procedure reduces shipping delays.',
                  'This audit report does not validates the claim that the new procedure reduces shipping delays.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'report\' wajib menggunakan auxiliary \'does not\' diikuti kata kerja dasar \'validate\'.',
              ],
              [
                'id' => 43,
                'id_sentence' => 'Bukti histologis tidak membuktikan adanya peradangan seluler pada jaringan yang terinfeksi.',
                'target_word' => 'does not substantiate',
                'vocab' => [
                  'histological evidence' => [
                    'id' => 'bukti histologis',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'substantiate' => [
                    'id' => 'membuktikan / memperkuat',
                    'pos' => '(v)',
                  ],
                  'cellular inflammation' => [
                    'id' => 'peradangan seluler',
                    'pos' => '(n phr)',
                  ],
                  'infected tissue' => [
                    'id' => 'jaringan yang terinfeksi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Histological evidence does not substantiate the presence of cellular inflammation in infected tissue.',
                  'Histological evidence do not substantiate the presence of cellular inflammation in infected tissue.',
                  'Histological evidence is not substantiate the presence of cellular inflammation in infected tissue.',
                  'Histological evidence does not substantiates the presence of cellular inflammation in infected tissue.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Evidence\' bersifat uncountable (tunggal), membutuhkan \'does not substantiate\'.',
              ],
              [
                'id' => 44,
                'id_sentence' => 'Hasil survei tidak mengonfirmasi ekspektasi bahwa kepuasan kerja berbanding lurus dengan gaji.',
                'target_word' => 'do not confirm',
                'vocab' => [
                  'survey results' => [
                    'id' => 'hasil survei',
                    'pos' => '(n phr)',
                  ],
                  'confirm' => [
                    'id' => 'mengonfirmasi',
                    'pos' => '(v)',
                  ],
                  'prior expectations' => [
                    'id' => 'ekspektasi sebelumnya',
                    'pos' => '(n phr)',
                  ],
                  'linearly correlated' => [
                    'id' => 'berbanding lurus',
                    'pos' => '(adj phr)',
                  ],
                ],
                'options' => [
                  'The survey results do not confirm prior expectations that job satisfaction is linearly correlated with salary.',
                  'The survey results does not confirm prior expectations that job satisfaction is linearly correlated with salary.',
                  'The survey results are not confirm prior expectations that job satisfaction is linearly correlated with salary.',
                  'The survey results do not confirms prior expectations that job satisfaction is linearly correlated with salary.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'results\' berpasangan dengan \'do not confirm\'.',
              ],
              [
                'id' => 45,
                'id_sentence' => 'Model iklim terbaru tidak meramalkan penurunan curah hujan yang signifikan di khatulistiwa.',
                'target_word' => 'does not forecast',
                'vocab' => [
                  'climate model' => [
                    'id' => 'model iklim',
                    'pos' => '(n phr)',
                  ],
                  'forecast' => [
                    'id' => 'meramalkan',
                    'pos' => '(v)',
                  ],
                  'significant precipitation drop' => [
                    'id' => 'penurunan curah hujan signifikan',
                    'pos' => '(n phr)',
                  ],
                  'equator' => [
                    'id' => 'khatulistiwa',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The latest climate model does not forecast a significant precipitation drop along the equator.',
                  'The latest climate model do not forecast a significant precipitation drop along the equator.',
                  'The latest climate model is not forecast a significant precipitation drop along the equator.',
                  'The latest climate model does not forecasts a significant precipitation drop along the equator.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'model\' membutuhkan \'does not forecast\'.',
              ],
              [
                'id' => 46,
                'id_sentence' => 'Eksperimen laboratorium ini tidak membenarkan asumsi umum tentang resistensi antibiotik.',
                'target_word' => 'does not corroborate',
                'vocab' => [
                  'laboratory experiment' => [
                    'id' => 'eksperimen laboratorium',
                    'pos' => '(n phr)',
                  ],
                  'corroborate' => [
                    'id' => 'membenarkan / menguatkan',
                    'pos' => '(v)',
                  ],
                  'common assumptions' => [
                    'id' => 'asumsi umum',
                    'pos' => '(n phr)',
                  ],
                  'antibiotic resistance' => [
                    'id' => 'resistensi antibiotik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This laboratory experiment does not corroborate common assumptions regarding antibiotic resistance.',
                  'This laboratory experiment do not corroborate common assumptions regarding antibiotic resistance.',
                  'This laboratory experiment is not corroborate common assumptions regarding antibiotic resistance.',
                  'This laboratory experiment does not corroborates common assumptions regarding antibiotic resistance.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'experiment\' berpasangan dengan \'does not corroborate\'.',
              ],
              [
                'id' => 47,
                'id_sentence' => 'Data kuantitatif tersebut tidak memperlihatkan kesenjangan gender yang lebar di posisi manajerial.',
                'target_word' => 'do not reveal',
                'vocab' => [
                  'quantitative data' => [
                    'id' => 'data kuantitatif',
                    'pos' => '(n phr)',
                  ],
                  'reveal' => [
                    'id' => 'memperlihatkan / mengungkap',
                    'pos' => '(v)',
                  ],
                  'gender disparity' => [
                    'id' => 'kesenjangan gender',
                    'pos' => '(n phr)',
                  ],
                  'managerial positions' => [
                    'id' => 'posisi manajerial',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The quantitative data do not reveal a pronounced gender disparity across managerial positions.',
                  'The quantitative data does not reveal a pronounced gender disparity across managerial positions.',
                  'The quantitative data are not reveal a pronounced gender disparity across managerial positions.',
                  'The quantitative data do not reveals a pronounced gender disparity across managerial positions.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'data\' menggunakan \'do not reveal\'.',
              ],
              [
                'id' => 48,
                'id_sentence' => 'Studi kasus ini tidak membuktikan bahwa desentralisasi selalu meningkatkan efisiensi fiskal.',
                'target_word' => 'does not establish',
                'vocab' => [
                  'case study' => [
                    'id' => 'studi kasus',
                    'pos' => '(n phr)',
                  ],
                  'establish' => [
                    'id' => 'membuktikan / menetapkan',
                    'pos' => '(v)',
                  ],
                  'decentralization' => [
                    'id' => 'desentralisasi',
                    'pos' => '(n)',
                  ],
                  'fiscal efficiency' => [
                    'id' => 'efisiensi fiskal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This case study does not establish that decentralization consistently enhances fiscal efficiency.',
                  'This case study do not establish that decentralization consistently enhances fiscal efficiency.',
                  'This case study is not establish that decentralization consistently enhances fiscal efficiency.',
                  'This case study does not establishes that decentralization consistently enhances fiscal efficiency.',
                ],
                'correct_index' => 0,
                'explanation' => '\'This case study\' adalah subjek tunggal, membutuhkan \'does not establish\'.',
              ],
              [
                'id' => 49,
                'id_sentence' => 'Catatan medis pasien tidak mengindikasikan adanya penyakit kardiovaskular bawaan.',
                'target_word' => 'do not indicate',
                'vocab' => [
                  'medical records' => [
                    'id' => 'catatan medis',
                    'pos' => '(n phr)',
                  ],
                  'indicate' => [
                    'id' => 'mengindikasikan',
                    'pos' => '(v)',
                  ],
                  'congenital cardiovascular disease' => [
                    'id' => 'penyakit kardiovaskular bawaan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Patient medical records do not indicate any preexisting congenital cardiovascular disease.',
                  'Patient medical records does not indicate any preexisting congenital cardiovascular disease.',
                  'Patient medical records are not indicate any preexisting congenital cardiovascular disease.',
                  'Patient medical records do not indicates any preexisting congenital cardiovascular disease.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Records\' adalah kata benda jamak, menggunakan \'do not indicate\'.',
              ],
              [
                'id' => 50,
                'id_sentence' => 'Analisis ekonomi makro tidak membenarkan pemotongan anggaran sektor kesehatan publik.',
                'target_word' => 'does not justify',
                'vocab' => [
                  'macroeconomic analysis' => [
                    'id' => 'analisis ekonomi makro',
                    'pos' => '(n phr)',
                  ],
                  'justify' => [
                    'id' => 'membenarkan / menjustifikasi',
                    'pos' => '(v)',
                  ],
                  'budgetary retrenchment' => [
                    'id' => 'pemotongan anggaran',
                    'pos' => '(n phr)',
                  ],
                  'public health sector' => [
                    'id' => 'sektor kesehatan publik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Macroeconomic analysis does not justify budgetary retrenchment in the public health sector.',
                  'Macroeconomic analysis do not justify budgetary retrenchment in the public health sector.',
                  'Macroeconomic analysis is not justify budgetary retrenchment in the public health sector.',
                  'Macroeconomic analysis does not justifies budgetary retrenchment in the public health sector.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Analysis\' adalah kata benda tunggal (jamaknya: analyses), sehingga memerlukan \'does not justify\'.',
              ],
            ],
          ],
          [
            'id' => 'advanced_interrogative_yesno',
            'name' => 'Advanced Interrogative: Formal Yes/No Questions',
            'code' => '1.4.6',
            'concept_title' => 'Pertanyaan Formal Yes/No dengan Inversi (Inverted Yes/No Questions)',
            'concept_description' => 'Pertanyaan formal digunakan untuk menguji keabsahan sebuah klaim, kebijakan, atau temuan secara langsung -- dalam laporan, presentasi, maupun diskusi profesional, tidak hanya dalam konteks penelitian ilmiah. Struktur kalimat tanya formal mensyaratkan adanya pembalikan posisi (inversi): auxiliary (Does / Do / Is / Are) diletakkan di depan subjek. Pada kalimat verbal, gunakan \'Does\' (subjek tunggal) atau \'Do\' (subjek jamak) diikuti Verb 1 murni tanpa -s/-es. Pada kalimat nominal/pasif, letakkan to be (Is/Are) di depan subjek.',
            'formula' => 'Verbal: DOES/DO + Subject + V1 (Base Form) + Object...? | Nominal: IS/ARE + Subject + Complement...?',
            'rules' => [
              'Inversi verbal: letakkan \'Does\' (tunggal) atau \'Do\' (jamak) sebelum subjek.',
              'Setelah auxiliary \'Does/Do\', kata kerja utama WAJIB berupa Verb 1 bentuk dasar murni.',
              'Inversi nominal/pasif: letakkan \'Is\' (tunggal) atau \'Are\' (jamak) sebelum subjek.',
              'Selalu sertakan tanda tanya (?) di akhir kalimat pertanyaan penelitian.',
            ],
            'exercises' => [
              [
                'id' => 51,
                'id_sentence' => 'Apakah intervensi kebijakan ini menghasilkan peningkatan terukur dalam kinerja akademik siswa?',
                'target_word' => 'Does this policy intervention produce',
                'vocab' => [
                  'policy intervention' => [
                    'id' => 'intervensi kebijakan',
                    'pos' => '(n phr)',
                  ],
                  'produce' => [
                    'id' => 'menghasilkan',
                    'pos' => '(v)',
                  ],
                  'measurable improvement' => [
                    'id' => 'peningkatan terukur',
                    'pos' => '(n phr)',
                  ],
                  'academic performance' => [
                    'id' => 'kinerja akademik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Does this policy intervention produce a measurable improvement in student academic performance?',
                  'Do this policy intervention produce a measurable improvement in student academic performance?',
                  'Is this policy intervention produce a measurable improvement in student academic performance?',
                  'Does this policy intervention produces a measurable improvement in student academic performance?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'this policy intervention\' membutuhkan auxiliary verbal \'Does\' di depan subjek, diikuti kata kerja murni \'produce\'.',
              ],
              [
                'id' => 52,
                'id_sentence' => 'Apakah institusi pendidikan tinggi mengakui kredensial pembelajaran mikro digital?',
                'target_word' => 'Do higher education institutions recognize',
                'vocab' => [
                  'higher education institutions' => [
                    'id' => 'institusi pendidikan tinggi',
                    'pos' => '(n phr)',
                  ],
                  'recognize' => [
                    'id' => 'mengakui',
                    'pos' => '(v)',
                  ],
                  'digital micro-credentials' => [
                    'id' => 'kredensial pembelajaran mikro digital',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Do higher education institutions recognize digital micro-credentials?',
                  'Does higher education institutions recognize digital micro-credentials?',
                  'Are higher education institutions recognize digital micro-credentials?',
                  'Do higher education institutions recognizes digital micro-credentials?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'institutions\' memerlukan auxiliary \'Do\' di depan subjek, diikuti V1 \'recognize\'.',
              ],
              [
                'id' => 53,
                'id_sentence' => 'Apakah algoritma kecerdasan buatan tersebut bebas dari bias data pelatihan sosiodemografis?',
                'target_word' => 'Is the artificial intelligence algorithm free',
                'vocab' => [
                  'artificial intelligence algorithm' => [
                    'id' => 'algoritma kecerdasan buatan',
                    'pos' => '(n phr)',
                  ],
                  'free from' => [
                    'id' => 'bebas dari',
                    'pos' => '(adj phr)',
                  ],
                  'training data bias' => [
                    'id' => 'bias data pelatihan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Is the artificial intelligence algorithm free from sociodemographic training data bias?',
                  'Does the artificial intelligence algorithm free from sociodemographic training data bias?',
                  'Are the artificial intelligence algorithm free from sociodemographic training data bias?',
                  'Do the artificial intelligence algorithm free from sociodemographic training data bias?',
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat nominal dengan kata sifat \'free\'. Karena subjek \'algorithm\' tunggal, to be \'Is\' diletakkan di depan subjek.',
              ],
              [
                'id' => 54,
                'id_sentence' => 'Apakah fluktuasi harga minyak bumi berdampak signifikan terhadap biaya logistik domestik?',
                'target_word' => 'Do petroleum price fluctuations significantly impact',
                'vocab' => [
                  'petroleum price fluctuations' => [
                    'id' => 'fluktuasi harga minyak bumi',
                    'pos' => '(n phr)',
                  ],
                  'impact' => [
                    'id' => 'berdampak terhadap',
                    'pos' => '(v)',
                  ],
                  'domestic logistics expenses' => [
                    'id' => 'biaya logistik domestik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Do petroleum price fluctuations significantly impact domestic logistics expenses?',
                  'Does petroleum price fluctuations significantly impact domestic logistics expenses?',
                  'Are petroleum price fluctuations significantly impact domestic logistics expenses?',
                  'Do petroleum price fluctuations significantly impacts domestic logistics expenses?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'fluctuations\' memerlukan auxiliary \'Do\' + V1 \'impact\'.',
              ],
              [
                'id' => 55,
                'id_sentence' => 'Apakah parameter eksperimental ini dapat direplikasi dalam kondisi laboratorium standar?',
                'target_word' => 'Is this experimental parameter replicable',
                'vocab' => [
                  'experimental parameter' => [
                    'id' => 'parameter eksperimental',
                    'pos' => '(n phr)',
                  ],
                  'replicable' => [
                    'id' => 'dapat direplikasi',
                    'pos' => '(adj)',
                  ],
                  'standard laboratory conditions' => [
                    'id' => 'kondisi laboratorium standar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Is this experimental parameter replicable under standard laboratory conditions?',
                  'Does this experimental parameter replicable under standard laboratory conditions?',
                  'Are this experimental parameter replicable under standard laboratory conditions?',
                  'Do this experimental parameter replicable under standard laboratory conditions?',
                ],
                'correct_index' => 0,
                'explanation' => 'Pertanyaan nominal dengan kata sifat \'replicable\'. Subjek \'parameter\' tunggal, to be yang diinversi adalah \'Is\'.',
              ],
              [
                'id' => 56,
                'id_sentence' => 'Apakah paparan radiasi ultraviolet secara berulang mengubah struktur sel epidermis?',
                'target_word' => 'Does repeated ultraviolet radiation exposure alter',
                'vocab' => [
                  'repeated ultraviolet exposure' => [
                    'id' => 'paparan radiasi ultraviolet berulang',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'alter' => [
                    'id' => 'mengubah',
                    'pos' => '(v)',
                  ],
                  'epidermal cellular structures' => [
                    'id' => 'struktur sel epidermis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Does repeated ultraviolet radiation exposure alter epidermal cellular structures?',
                  'Do repeated ultraviolet radiation exposure alter epidermal cellular structures?',
                  'Is repeated ultraviolet radiation exposure alter epidermal cellular structures?',
                  'Does repeated ultraviolet radiation exposure alters epidermal cellular structures?',
                ],
                'correct_index' => 0,
                'explanation' => 'Head noun \'exposure\' bersifat uncountable/tunggal, sehingga membutuhkan \'Does\' + V1 murni \'alter\'.',
              ],
              [
                'id' => 57,
                'id_sentence' => 'Apakah peraturan perpajakan baru tersebut berlaku efektif untuk korporasi multinasional digital?',
                'target_word' => 'Is the new tax legislation effective',
                'vocab' => [
                  'tax legislation' => [
                    'id' => 'peraturan perpajakan',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'effective' => [
                    'id' => 'berlaku efektif',
                    'pos' => '(adj)',
                  ],
                  'digital multinational corporations' => [
                    'id' => 'korporasi multinasional digital',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Is the new tax legislation effective for digital multinational corporations?',
                  'Does the new tax legislation effective for digital multinational corporations?',
                  'Are the new tax legislation effective for digital multinational corporations?',
                  'Do the new tax legislation effective for digital multinational corporations?',
                ],
                'correct_index' => 0,
                'explanation' => '\'Legislation\' adalah uncountable noun dengan predikat adjective \'effective\'; to be \'Is\' diletakkan di depan.',
              ],
              [
                'id' => 58,
                'id_sentence' => 'Apakah bank sentral menaikkan suku bunga acuan dalam merespons tekanan inflasi?',
                'target_word' => 'Does the central bank raise',
                'vocab' => [
                  'central bank' => [
                    'id' => 'bank sentral',
                    'pos' => '(n phr)',
                  ],
                  'raise' => [
                    'id' => 'menaikkan',
                    'pos' => '(v)',
                  ],
                  'benchmark interest rate' => [
                    'id' => 'suku bunga acuan',
                    'pos' => '(n phr)',
                  ],
                  'inflationary pressures' => [
                    'id' => 'tekanan inflasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Does the central bank raise the benchmark interest rate in response to inflationary pressures?',
                  'Do the central bank raise the benchmark interest rate in response to inflationary pressures?',
                  'Is the central bank raise the benchmark interest rate in response to inflationary pressures?',
                  'Does the central bank raises the benchmark interest rate in response to inflationary pressures?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'the central bank\' menggunakan auxiliary \'Does\' diikuti V1 \'raise\'.',
              ],
              [
                'id' => 59,
                'id_sentence' => 'Apakah senyawa bioaktif tersebut diekstraksi menggunakan metode maserasi ultrasonik?',
                'target_word' => 'Is the bioactive compound extracted',
                'vocab' => [
                  'bioactive compound' => [
                    'id' => 'senyawa bioaktif',
                    'pos' => '(n phr)',
                  ],
                  'extract' => [
                    'id' => 'mengekstrak',
                    'pos' => '(v) -> V3: extracted',
                  ],
                  'ultrasonic maceration' => [
                    'id' => 'maserasi ultrasonik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Is the bioactive compound extracted utilizing the ultrasonic maceration method?',
                  'Does the bioactive compound extracted utilizing the ultrasonic maceration method?',
                  'Are the bioactive compound extracted utilizing the ultrasonic maceration method?',
                  'Is the bioactive compound extracting utilizing the ultrasonic maceration method?',
                ],
                'correct_index' => 0,
                'explanation' => 'Pertanyaan pasif: subjek tunggal \'compound\' dikenai tindakan; to be \'Is\' diletakkan di depan + V3 \'extracted\'.',
              ],
              [
                'id' => 60,
                'id_sentence' => 'Apakah para pemegang saham mendukung strategi dekarbonisasi jangka panjang perusahaan?',
                'target_word' => 'Do institutional shareholders endorse',
                'vocab' => [
                  'institutional shareholders' => [
                    'id' => 'para pemegang saham institusional',
                    'pos' => '(n phr)',
                  ],
                  'endorse' => [
                    'id' => 'mendukung / menyetujui',
                    'pos' => '(v)',
                  ],
                  'long-term decarbonization strategy' => [
                    'id' => 'strategi dekarbonisasi jangka panjang',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Do institutional shareholders endorse the corporate long-term decarbonization strategy?',
                  'Does institutional shareholders endorse the corporate long-term decarbonization strategy?',
                  'Are institutional shareholders endorse the corporate long-term decarbonization strategy?',
                  'Do institutional shareholders endorses the corporate long-term decarbonization strategy?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'shareholders\' memerlukan auxiliary verbal \'Do\' di awal kalimat tanya + V1 \'endorse\'.',
              ],
            ],
          ],
          [
            'id' => 'advanced_interrogative_wh',
            'name' => 'Advanced Interrogative: Formal Wh- Questions',
            'code' => '1.4.7',
            'concept_title' => 'Formulasi Pertanyaan Formal dengan Kata Tanya Wh- (Formal Wh- Questions)',
            'concept_description' => 'Dalam laporan, presentasi bisnis, maupun tulisan analitis, pertanyaan mendalam sering kali dirumuskan menggunakan kata tanya frasa seperti \'To what extent\' (sejauh mana), \'Under what conditions\' (dalam kondisi apa), \'How\' (bagaimana), atau \'Why\' (mengapa) -- bukan hanya dalam konteks penelitian ilmiah. Struktur baku bahasa Inggris mewajibkan adanya inversi: Frasa Wh- diikuti Auxiliary (does/do/is/are), kemudian Subjek, dan terakhir Kata Kerja Bentuk Dasar / Pelengkap.',
            'formula' => 'Wh- Phrase (To what extent / Under what conditions / How) + DOES/DO/IS/ARE + Subject + Verb/Complement...?',
            'rules' => [
              'Susunan wajib: [Wh- Word/Phrase] + [Auxiliary Verb] + [Subject] + [Main Verb 1] + [Object/Complement]?',
              'Dilarang menggunakan susunan klausa terikat dalam pertanyaan langsung (e.g., \'To what extent the government regulates...?\' adalah SALAH).',
              'Pilih auxiliary yang selaras dengan subjek (does untuk tunggal, do untuk jamak).',
              'Gunakan frasa tanya berbobot akademik (e.g. \'To what extent\' lebih disukai dibanding sekadar \'How much\').',
            ],
            'exercises' => [
              [
                'id' => 61,
                'id_sentence' => 'Sejauh mana volatilitas makroekonomi mempengaruhi arus masuk investasi asing langsung?',
                'target_word' => 'To what extent does macroeconomic volatility influence',
                'vocab' => [
                  'to what extent' => [
                    'id' => 'sejauh mana',
                    'pos' => '(phr)',
                  ],
                  'macroeconomic volatility' => [
                    'id' => 'volatilitas makroekonomi',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'influence' => [
                    'id' => 'mempengaruhi',
                    'pos' => '(v)',
                  ],
                  'foreign direct investment inflows' => [
                    'id' => 'arus masuk investasi asing langsung',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'To what extent does macroeconomic volatility influence foreign direct investment inflows?',
                  'To what extent macroeconomic volatility does influence foreign direct investment inflows?',
                  'To what extent do macroeconomic volatility influence foreign direct investment inflows?',
                  'To what extent is macroeconomic volatility influence foreign direct investment inflows?',
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah frasa tanya \'To what extent\', letakkan auxiliary \'does\' (karena volatility tunggal), lalu subjek, lalu V1 murni \'influence\'.',
              ],
              [
                'id' => 62,
                'id_sentence' => 'Bagaimana interaksi antar-spesies mempengaruhi ketahanan ekosistem hutan mangrove?',
                'target_word' => 'How do inter-species interactions shape',
                'vocab' => [
                  'inter-species interactions' => [
                    'id' => 'interaksi antar-spesies',
                    'pos' => '(n phr, plural)',
                  ],
                  'shape' => [
                    'id' => 'mempengaruhi / membentuk',
                    'pos' => '(v)',
                  ],
                  'resilience of mangrove ecosystems' => [
                    'id' => 'ketahanan ekosistem hutan mangrove',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'How do inter-species interactions shape the resilience of mangrove ecosystems?',
                  'How does inter-species interactions shape the resilience of mangrove ecosystems?',
                  'How inter-species interactions do shape the resilience of mangrove ecosystems?',
                  'How are inter-species interactions shape the resilience of mangrove ecosystems?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'interactions\' membutuhkan auxiliary \'do\' tepat setelah kata tanya \'How\', diikuti V1 \'shape\'.',
              ],
              [
                'id' => 63,
                'id_sentence' => 'Dalam kondisi apa mikroorganisme tanah menguraikan polutan hidrokarbon secara optimal?',
                'target_word' => 'Under what conditions do soil microorganisms degrade',
                'vocab' => [
                  'under what conditions' => [
                    'id' => 'dalam kondisi apa',
                    'pos' => '(phr)',
                  ],
                  'soil microorganisms' => [
                    'id' => 'mikroorganisme tanah',
                    'pos' => '(n phr, plural)',
                  ],
                  'degrade' => [
                    'id' => 'menguraikan',
                    'pos' => '(v)',
                  ],
                  'hydrocarbon pollutants' => [
                    'id' => 'polutan hidrokarbon',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Under what conditions do soil microorganisms degrade hydrocarbon pollutants most effectively?',
                  'Under what conditions does soil microorganisms degrade hydrocarbon pollutants most effectively?',
                  'Under what conditions soil microorganisms do degrade hydrocarbon pollutants most effectively?',
                  'Under what conditions are soil microorganisms degrade hydrocarbon pollutants most effectively?',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa tanya \'Under what conditions\' diikuti auxiliary \'do\' (karena microorganisms jamak) + subjek + V1 \'degrade\'.',
              ],
              [
                'id' => 64,
                'id_sentence' => 'Mengapa konsumsi energi terbarukan tidak meningkat secara merata di kawasan pedesaan?',
                'target_word' => 'Why does renewable energy consumption not expand',
                'vocab' => [
                  'renewable energy consumption' => [
                    'id' => 'konsumsi energi terbarukan',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'expand' => [
                    'id' => 'meningkat / meluas',
                    'pos' => '(v)',
                  ],
                  'equitably' => [
                    'id' => 'secara merata',
                    'pos' => '(adv)',
                  ],
                  'rural territories' => [
                    'id' => 'kawasan pedesaan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Why does renewable energy consumption not expand equitably across rural territories?',
                  'Why renewable energy consumption does not expand equitably across rural territories?',
                  'Why do renewable energy consumption not expand equitably across rural territories?',
                  'Why is renewable energy consumption not expand equitably across rural territories?',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk tanya negatif: kata tanya \'Why\' + auxiliary \'does\' + subjek tunggal \'consumption\' + \'not\' + V1 murni \'expand\'.',
              ],
              [
                'id' => 65,
                'id_sentence' => 'Faktor-faktor kelembagaan apa yang menentukan keberhasilan reformasi birokrasi?',
                'target_word' => 'What institutional factors determine',
                'vocab' => [
                  'institutional factors' => [
                    'id' => 'faktor-faktor kelembagaan',
                    'pos' => '(n phr, plural)',
                  ],
                  'determine' => [
                    'id' => 'menentukan',
                    'pos' => '(v)',
                  ],
                  'success of bureaucratic reform' => [
                    'id' => 'keberhasilan reformasi birokrasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'What institutional factors determine the ultimate success of bureaucratic reform?',
                  'What institutional factors do determine the ultimate success of bureaucratic reform?',
                  'What institutional factors does determine the ultimate success of bureaucratic reform?',
                  'What institutional factors are determine the ultimate success of bureaucratic reform?',
                ],
                'correct_index' => 0,
                'explanation' => 'Ketika frasa tanya bertindak langsung sebagai Subjek (\'What institutional factors\'), tidak diperlukan auxiliary \'do/does\'; kata kerja langsung berupa V1 jamak \'determine\'.',
              ],
              [
                'id' => 66,
                'id_sentence' => 'Sejauh mana literasi keuangan digital mengurangi kesenjangan pendapatan di perkotaan?',
                'target_word' => 'To what degree does digital financial literacy mitigate',
                'vocab' => [
                  'to what degree' => [
                    'id' => 'sejauh mana',
                    'pos' => '(phr)',
                  ],
                  'digital financial literacy' => [
                    'id' => 'literasi keuangan digital',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'mitigate' => [
                    'id' => 'mengurangi / memitigasi',
                    'pos' => '(v)',
                  ],
                  'urban income inequality' => [
                    'id' => 'kesenjangan pendapatan di perkotaan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'To what degree does digital financial literacy mitigate urban income inequality?',
                  'To what degree digital financial literacy does mitigate urban income inequality?',
                  'To what degree do digital financial literacy mitigate urban income inequality?',
                  'To what degree is digital financial literacy mitigate urban income inequality?',
                ],
                'correct_index' => 0,
                'explanation' => '\'Literacy\' adalah uncountable (tunggal), membutuhkan struktur inversi: \'To what degree\' + \'does\' + subjek + V1 \'mitigate\'.',
              ],
              [
                'id' => 67,
                'id_sentence' => 'Bagaimana arsitektur jaringan saraf tiruan memproses data sensor yang tidak lengkap?',
                'target_word' => 'How does an artificial neural network architecture process',
                'vocab' => [
                  'neural network architecture' => [
                    'id' => 'arsitektur jaringan saraf tiruan',
                    'pos' => '(n phr)',
                  ],
                  'process' => [
                    'id' => 'memproses',
                    'pos' => '(v)',
                  ],
                  'incomplete sensor feeds' => [
                    'id' => 'data sensor yang tidak lengkap',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'How does an artificial neural network architecture process incomplete sensor feeds?',
                  'How an artificial neural network architecture does process incomplete sensor feeds?',
                  'How do an artificial neural network architecture process incomplete sensor feeds?',
                  'How is an artificial neural network architecture process incomplete sensor feeds?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'architecture\' memerlukan inversi \'How does\' + subjek + V1 \'process\'.',
              ],
              [
                'id' => 68,
                'id_sentence' => 'Mekanisme biologis apa yang mengatur ritme sirkadian pada organisme laut dalam?',
                'target_word' => 'What biological mechanisms regulate',
                'vocab' => [
                  'biological mechanisms' => [
                    'id' => 'mekanisme biologis',
                    'pos' => '(n phr, plural)',
                  ],
                  'regulate' => [
                    'id' => 'mengatur',
                    'pos' => '(v)',
                  ],
                  'circadian rhythms' => [
                    'id' => 'ritme sirkadian',
                    'pos' => '(n phr)',
                  ],
                  'deep-sea organisms' => [
                    'id' => 'organisme laut dalam',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'What biological mechanisms regulate circadian rhythms in deep-sea organisms?',
                  'What biological mechanisms do regulate circadian rhythms in deep-sea organisms?',
                  'What biological mechanisms does regulate circadian rhythms in deep-sea organisms?',
                  'What biological mechanisms are regulate circadian rhythms in deep-sea organisms?',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa tanya \'What biological mechanisms\' adalah subjek pertanyaan, sehingga langsung diikuti kata kerja V1 \'regulate\'.',
              ],
              [
                'id' => 69,
                'id_sentence' => 'Sejauh mana platform media sosial memfasilitasi polarisasi opini politik?',
                'target_word' => 'To what extent do social media platforms facilitate',
                'vocab' => [
                  'social media platforms' => [
                    'id' => 'platform media sosial',
                    'pos' => '(n phr, plural)',
                  ],
                  'facilitate' => [
                    'id' => 'memfasilitasi',
                    'pos' => '(v)',
                  ],
                  'polarization of political discourse' => [
                    'id' => 'polarisasi opini politik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'To what extent do social media platforms facilitate the polarization of political discourse?',
                  'To what extent does social media platforms facilitate the polarization of political discourse?',
                  'To what extent social media platforms do facilitate the polarization of political discourse?',
                  'To what extent are social media platforms facilitate the polarization of political discourse?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'platforms\' membutuhkan auxiliary \'do\' di depan subjek: \'To what extent do social media platforms facilitate...\'.',
              ],
              [
                'id' => 70,
                'id_sentence' => 'Dengan cara apa pengeringan beku mempertahankan integritas bioaktif vaksin?',
                'target_word' => 'In what manner does freeze-drying preserve',
                'vocab' => [
                  'in what manner' => [
                    'id' => 'dengan cara apa',
                    'pos' => '(phr)',
                  ],
                  'freeze-drying' => [
                    'id' => 'pengeringan beku / liofilisasi',
                    'pos' => '(n, gerund)',
                  ],
                  'preserve' => [
                    'id' => 'mempertahankan',
                    'pos' => '(v)',
                  ],
                  'bioactive integrity of vaccines' => [
                    'id' => 'integritas bioaktif vaksin',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'In what manner does freeze-drying preserve the bioactive integrity of vaccines?',
                  'In what manner freeze-drying does preserve the bioactive integrity of vaccines?',
                  'In what manner do freeze-drying preserve the bioactive integrity of vaccines?',
                  'In what manner is freeze-drying preserve the bioactive integrity of vaccines?',
                ],
                'correct_index' => 0,
                'explanation' => '\'Freeze-drying\' adalah gerund tunggal, memerlukan inversi \'In what manner does\' + subjek + V1 \'preserve\'.',
              ],
            ],
          ],
          [
            'id' => 'emphatic_and_contrastive',
            'name' => 'Emphatic Affirmative & Synthesis (do/does + V1)',
            'code' => '1.4.8',
            'concept_title' => 'Bentuk Emphatic \'do/does\' dan Sintesis Kontras Kalimat Negatif Akademik',
            'concept_description' => 'Dalam register akademik tingkat lanjut, auxiliary \'do\' dan \'does\' dapat disematkan dalam kalimat deklaratif positif untuk menciptakan penekanan retoris (Emphatic Mood). Struktur ini digunakan peneliti untuk menegaskan kembali temuan penting yang awalnya diragukan atau tampak berkontradiksi (e.g., \'Although unexpected, the substance DOES accelerate crystallization\'). Dikombinasikan dengan klausa negatif, struktur ini menghasilkan variasi kalimat yang sangat bernilai tinggi dalam penulisan esai kritis dan artikel jurnal.',
            'formula' => 'Concession Clause + Subject + DO / DOES + Verb 1 (Emphatic) + while / but Subject + DOES / DO NOT + Verb 1',
            'rules' => [
              'Auxiliary \'do/does\' dalam kalimat positif berfungsi memberikan penekanan tegas (emphasis).',
              'Kata kerja setelah \'do/does\' emphatic WAJIB berupa Verb 1 bentuk dasar murni tanpa -s/-es.',
              'Gunakan pola kontras: [Meskipun X tidak terjadi, Y sungguh terjadi] untuk memperkaya variasi argumen.',
              'Struktur ini sangat dianjurkan untuk mengangkat band score IELTS Writing Task 2 (Grammatical Range).',
            ],
            'exercises' => [
              [
                'id' => 71,
                'id_sentence' => 'Meskipun biaya produksinya tinggi, turbin angin lepas pantai memang menghasilkan energi terbarukan yang konsisten.',
                'target_word' => 'does yield',
                'vocab' => [
                  'high manufacturing costs' => [
                    'id' => 'biaya produksi tinggi',
                    'pos' => '(n phr)',
                  ],
                  'offshore wind turbine' => [
                    'id' => 'turbin angin lepas pantai',
                    'pos' => '(n phr)',
                  ],
                  'yield' => [
                    'id' => 'menghasilkan',
                    'pos' => '(v)',
                  ],
                  'consistent renewable energy' => [
                    'id' => 'energi terbarukan yang konsisten',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Although manufacturing costs are steep, the offshore wind turbine does yield consistent renewable electricity.',
                  'Although manufacturing costs are steep, the offshore wind turbine does yields consistent renewable electricity.',
                  'Although manufacturing costs are steep, the offshore wind turbine is yield consistent renewable electricity.',
                  'Although manufacturing costs are steep, the offshore wind turbine do yield consistent renewable electricity.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk emphatic untuk subjek tunggal \'turbine\': gunakan auxiliary \'does\' + Verb 1 dasar \'yield\' (bukan yields).',
              ],
              [
                'id' => 72,
                'id_sentence' => 'Para ahli bedah tidak merekomendasikan terapi alternatif, namun mereka sungguh mengakui manfaat terapeutiknya.',
                'target_word' => 'do recognize',
                'vocab' => [
                  'surgeons' => [
                    'id' => 'para ahli bedah',
                    'pos' => '(n)',
                  ],
                  'alternative therapies' => [
                    'id' => 'terapi alternatif',
                    'pos' => '(n phr)',
                  ],
                  'recognize' => [
                    'id' => 'mengakui',
                    'pos' => '(v)',
                  ],
                  'therapeutic benefits' => [
                    'id' => 'manfaat terapeutik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Surgeons do not recommend alternative therapies, yet they do recognize certain therapeutic benefits.',
                  'Surgeons does not recommend alternative therapies, yet they do recognize certain therapeutic benefits.',
                  'Surgeons do not recommend alternative therapies, yet they does recognize certain therapeutic benefits.',
                  'Surgeons are not recommend alternative therapies, yet they are recognize certain therapeutic benefits.',
                ],
                'correct_index' => 0,
                'explanation' => 'Klausa pertama negatif verbal (\'do not recommend\'), klausa kedua emphatic (\'they do recognize\').',
              ],
              [
                'id' => 73,
                'id_sentence' => 'Data statistik tidak membuktikan kausalitas langsung, tetapi memang mengindikasikan korelasi yang kuat.',
                'target_word' => 'does indicate',
                'vocab' => [
                  'statistical dataset' => [
                    'id' => 'kumpulan data statistik',
                    'pos' => '(n phr)',
                  ],
                  'prove direct causality' => [
                    'id' => 'membuktikan kausalitas langsung',
                    'pos' => '(v phr)',
                  ],
                  'indicate' => [
                    'id' => 'mengindikasikan',
                    'pos' => '(v)',
                  ],
                  'robust correlation' => [
                    'id' => 'korelasi yang kuat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The statistical dataset does not prove direct causality, but it does indicate a robust correlation.',
                  'The statistical dataset does not proves direct causality, but it does indicates a robust correlation.',
                  'The statistical dataset do not prove direct causality, but it do indicate a robust correlation.',
                  'The statistical dataset is not prove direct causality, but it is indicate a robust correlation.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'dataset\': negatif verbal \'does not prove\', diikuti emphatic \'does indicate\'.',
              ],
              [
                'id' => 74,
                'id_sentence' => 'Pemerintah tidak memberlakukan tarif impor baru, meskipun undang-undang memang mengizinkan langkah tersebut.',
                'target_word' => 'does permit',
                'vocab' => [
                  'impose new import tariffs' => [
                    'id' => 'memberlakukan tarif impor baru',
                    'pos' => '(v phr)',
                  ],
                  'legislation' => [
                    'id' => 'undang-undang',
                    'pos' => '(n, uncountable)',
                  ],
                  'permit' => [
                    'id' => 'mengizinkan',
                    'pos' => '(v)',
                  ],
                  'protective measure' => [
                    'id' => 'langkah protektif',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The government does not impose new import tariffs, although legislation does permit such a protective measure.',
                  'The government do not impose new import tariffs, although legislation does permit such a protective measure.',
                  'The government does not impose new import tariffs, although legislation do permit such a protective measure.',
                  'The government is not impose new import tariffs, although legislation does permits such a protective measure.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The government does not impose\' (negatif) + \'legislation does permit\' (emphatic singular).',
              ],
              [
                'id' => 75,
                'id_sentence' => 'Metodologi baru ini tidak sepenuhnya menggantikan teknik konvensional, namun memang meningkatkan presisi analisis.',
                'target_word' => 'does enhance',
                'vocab' => [
                  'supplant conventional techniques' => [
                    'id' => 'menggantikan teknik konvensional',
                    'pos' => '(v phr)',
                  ],
                  'enhance' => [
                    'id' => 'meningkatkan',
                    'pos' => '(v)',
                  ],
                  'analytical precision' => [
                    'id' => 'presisi analisis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This novel methodology does not completely supplant conventional techniques, yet it does enhance analytical precision.',
                  'This novel methodology do not completely supplant conventional techniques, yet it does enhance analytical precision.',
                  'This novel methodology does not completely supplants conventional techniques, yet it does enhances analytical precision.',
                  'This novel methodology is not completely supplant conventional techniques, yet it is enhance analytical precision.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Methodology\' tunggal: \'does not completely supplant\' + \'it does enhance\'.',
              ],
              [
                'id' => 76,
                'id_sentence' => 'Apakah para peneliti tidak mencatat adanya penyimpangan signifikan selama pengamatan mikroskopis?',
                'target_word' => 'Do researchers not record',
                'vocab' => [
                  'researchers' => [
                    'id' => 'para peneliti',
                    'pos' => '(n, plural)',
                  ],
                  'record' => [
                    'id' => 'mencatat',
                    'pos' => '(v)',
                  ],
                  'significant deviations' => [
                    'id' => 'penyimpangan signifikan',
                    'pos' => '(n phr)',
                  ],
                  'microscopic observation' => [
                    'id' => 'pengamatan mikroskopis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Do researchers not record any significant deviations during microscopic observation?',
                  'Does researchers not record any significant deviations during microscopic observation?',
                  'Are researchers not record any significant deviations during microscopic observation?',
                  'Do researchers not records any significant deviations during microscopic observation?',
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat tanya negatif formal: \'Do\' + subjek jamak \'researchers\' + \'not\' + V1 \'record\'.',
              ],
              [
                'id' => 77,
                'id_sentence' => 'Kebijakan moneter tidak menurunkan inflasi seketika, namun memang menstabilkan ekspektasi pasar uang.',
                'target_word' => 'does stabilize',
                'vocab' => [
                  'monetary policy' => [
                    'id' => 'kebijakan moneter',
                    'pos' => '(n phr)',
                  ],
                  'lower inflation instantaneously' => [
                    'id' => 'menurunkan inflasi seketika',
                    'pos' => '(v phr)',
                  ],
                  'stabilize' => [
                    'id' => 'menstabilkan',
                    'pos' => '(v)',
                  ],
                  'money market expectations' => [
                    'id' => 'ekspektasi pasar uang',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Monetary policy does not lower inflation instantaneously, yet it does stabilize money market expectations.',
                  'Monetary policy do not lower inflation instantaneously, yet it do stabilize money market expectations.',
                  'Monetary policy does not lowers inflation instantaneously, yet it does stabilizes money market expectations.',
                  'Monetary policy is not lower inflation instantaneously, yet it is stabilize money market expectations.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'policy\': \'does not lower\' + \'it does stabilize\'.',
              ],
              [
                'id' => 78,
                'id_sentence' => 'Para ekonom tidak menyepakati penyebab tunggal krisis perumahan, tetapi mereka memang mengakui kelangkaan pasokan.',
                'target_word' => 'do acknowledge',
                'vocab' => [
                  'economists' => [
                    'id' => 'para ekonom',
                    'pos' => '(n, plural)',
                  ],
                  'agree on a singular cause' => [
                    'id' => 'menyepakati penyebab tunggal',
                    'pos' => '(v phr)',
                  ],
                  'acknowledge' => [
                    'id' => 'mengakui',
                    'pos' => '(v)',
                  ],
                  'supply shortage' => [
                    'id' => 'kelangkaan pasokan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Economists do not agree on a singular cause for the housing crisis, but they do acknowledge severe supply shortages.',
                  'Economists does not agree on a singular cause for the housing crisis, but they do acknowledge severe supply shortages.',
                  'Economists do not agree on a singular cause for the housing crisis, but they does acknowledge severe supply shortages.',
                  'Economists are not agree on a singular cause for the housing crisis, but they are acknowledge severe supply shortages.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'Economists\': \'do not agree\' + \'they do acknowledge\'.',
              ],
              [
                'id' => 79,
                'id_sentence' => 'Apakah institusi audit independen tidak memverifikasi transaksi keuangan internasional?',
                'target_word' => 'Does the independent auditing body not verify',
                'vocab' => [
                  'independent auditing body' => [
                    'id' => 'institusi audit independen',
                    'pos' => '(n phr, singular)',
                  ],
                  'verify' => [
                    'id' => 'memverifikasi',
                    'pos' => '(v)',
                  ],
                  'international financial transactions' => [
                    'id' => 'transaksi keuangan internasional',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Does the independent auditing body not verify international financial transactions?',
                  'Do the independent auditing body not verify international financial transactions?',
                  'Is the independent auditing body not verify international financial transactions?',
                  'Does the independent auditing body not verifies international financial transactions?',
                ],
                'correct_index' => 0,
                'explanation' => 'Pertanyaan negatif formal dengan subjek tunggal \'body\': \'Does ... not verify\' + V1 murni.',
              ],
              [
                'id' => 80,
                'id_sentence' => 'Meskipun studi ini tidak menguji semua variabel kontrol, kesimpulannya memang menyajikan wawasan empiris yang solid.',
                'target_word' => 'does present',
                'vocab' => [
                  'test all control variables' => [
                    'id' => 'menguji semua variabel kontrol',
                    'pos' => '(v phr)',
                  ],
                  'conclusion' => [
                    'id' => 'kesimpulan',
                    'pos' => '(n, singular)',
                  ],
                  'present' => [
                    'id' => 'menyajikan',
                    'pos' => '(v)',
                  ],
                  'solid empirical insights' => [
                    'id' => 'wawasan empiris yang solid',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'While this study does not test every control variable, its conclusion does present solid empirical insights.',
                  'While this study do not test every control variable, its conclusion does present solid empirical insights.',
                  'While this study does not tests every control variable, its conclusion does presents solid empirical insights.',
                  'While this study is not test every control variable, its conclusion is present solid empirical insights.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kedua klausa menggunakan subjek tunggal (\'study\' dan \'conclusion\'): \'does not test\' + \'does present\'.',
              ],
            ],
          ],
        ];
    }
}
