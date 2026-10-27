<?php

namespace App\Services;

class SelfStudyModalAuxiliariesDataAdvanced
{
    /**
     * Get the complete Modal Auxiliaries in Academic Context (Level 101) package.
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
            'banner_title' => 'Modal Auxiliaries (Kata Kerja Bantu Modal)',
            'banner_subtitle' => 'Kuasai penggunaan kata kerja bantu modal (can, could, may, might, must, should, will, would) untuk menyatakan kemungkinan, kemampuan, saran, keharusan, serta bentuk pasif dan dugaan masa lalu.',
            'banner_badge' => 'MODUL 1.7 MODAL AUXILIARIES',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.7
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Kata Kerja Bantu Modal (Modal Auxiliaries)',
            'concept_summary' => 'Modal Auxiliaries (can, could, may, might, should, must, will, would) adalah kata kerja bantu khusus untuk menambahkan makna penting pada kalimat—seperti menyatakan kemungkinan, kemampuan, saran/anjuran, keharusan, maupun kesimpulan logis. Ciri khas utama semua modal: selalu diikuti kata kerja bentuk dasar (V1 murni tanpa -s, -es, -ed, atau -ing) dan tidak boleh disisipkan partikel "to" langsung setelah modal dasar.',
            'rules' => [
                [
                    'rule_title' => '1. Menyatakan Kemungkinan (May, Might, Could)',
                    'rule_formula' => 'Subject + MAY / MIGHT / COULD + Bare Infinitive (V1)',
                    'rule_description' => 'Gunakan "may", "might", atau "could" untuk menyatakan hal yang mungkin terjadi atau barangkali benar. Modal selalu diikuti kata kerja dasar murni tanpa imbuhan apapun.',
                    'examples' => [
                        [
                            'en' => 'Preliminary observations may indicate an indirect correlation between atmospheric aerosols and cloud albedo.',
                            'id' => 'Observasi awal mungkin mengindikasikan korelasi tidak langsung antara aerosol atmosfer dan albedo awan.',
                            'note' => 'Bentuk "may indicate" digunakan untuk menyatakan kemungkinan yang masuk akal berdasarkan data.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Menyatakan Kemampuan vs Kesimpulan Logis (Can vs Must / Cannot)',
                    'rule_formula' => 'Can + V1 (Kemampuan) | Must / Cannot + BE (Kesimpulan Pasti / Mustahil)',
                    'rule_description' => '"Can" menyatakan kemampuan nyata seseorang atau fungsi instrumen/sistem. "Must be" menyatakan kesimpulan logis yang pasti, sedangkan lawan kesimpulannya adalah "cannot be" (tidak mungkin/mustahil, bukan must not).',
                    'examples' => [
                        [
                            'en' => 'Given the strict sterile environment, the culture cannot be contaminated.',
                            'id' => 'Mengingat lingkungan steril yang ketat, kultur tersebut tidak mungkin terkontaminasi.',
                            'note' => 'Gunakan "cannot be" untuk menyatakan kesimpulan bahwa sesuatu mustahil terjadi.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Menyatakan Saran & Rekomendasi (Should, Ought to)',
                    'rule_formula' => 'Subject (Policymakers / Researchers) + SHOULD / OUGHT TO + V1',
                    'rule_description' => 'Gunakan "should" atau "ought to" untuk menyampaikan anjuran atau saran perbaikan secara sopan, elegan, dan persuasif.',
                    'examples' => [
                        [
                            'en' => 'Regulatory authorities should consider the socio-ecological impacts of new policies.',
                            'id' => 'Otoritas regulasi sebaiknya mempertimbangkan dampak sosio-ekologis dari kebijakan baru.',
                            'note' => '"Should consider" menyampaikan saran konstruktif dalam kalimat tunggal.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Bentuk Pasif Modal & Dugaan Masa Lalu (Modal + Be + V3 / Modal + Have + V3)',
                    'rule_formula' => 'Pasif: Modal + BE + V3 | Masa Lalu: Modal + HAVE + V3',
                    'rule_description' => 'Pola pasif modal ("can be observed", "must be standardized") memfokuskan kalimat pada tindakan secara objektif. Pola masa lalu ("may have been caused by", "should have checked") digunakan untuk menduga atau mengevaluasi hal lampau.',
                    'examples' => [
                        [
                            'en' => 'The data discrepancy may have been caused by undetected temperature variations.',
                            'id' => 'Diskrepansi data mungkin telah disebabkan oleh variasi suhu yang tidak terdeteksi.',
                            'note' => 'Menggunakan "may have been caused by" untuk menduga penyebab di masa lampau.'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Modal Auxiliary', 'Fungsi Utama', 'Makna / Nuansa', 'Contoh Kalimat'],
                'rows' => [
                    ['may / might / could', 'Menyatakan Kemungkinan', 'Mungkin / Barangkali', 'These findings may suggest an alternative pathway.'],
                    ['can / is able to', 'Menyatakan Kemampuan', 'Dapat / Bisa / Mampu', 'The instrument can detect nano-particles.'],
                    ['should / ought to', 'Menyatakan Saran / Anjuran', 'Sebaiknya / Seharusnya', 'Policymakers should tighten emission limits.'],
                    ['must / cannot', 'Kesimpulan Logis', 'Pasti (must) / Mustahil (cannot)', 'The compound must be unstable under heat.'],
                    ['will / would', 'Masa Depan & Pengandaian', 'Akan (will) / Bersyarat (would)', 'Further hikes would dampen consumer demand.'],
                    ['modal + be + V3', 'Bentuk Pasif Formal', 'Dapat / Harus di-...', 'Parameters must be standardized across trials.'],
                    ['modal + have + V3', 'Dugaan / Evaluasi Masa Lalu', 'Mungkin telah / Seharusnya sudah', 'Researchers should have controlled for age.'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The findings may indicates that the hypothesis is true.',
                    'correct' => 'The findings may indicate that the hypothesis is true.',
                    'explanation' => 'Modal selalu diikuti bentuk kata kerja dasar (V1 murni tanpa tambahan -s/-es).'
                ],
                [
                    'incorrect' => 'Because the test failed, the theory must not be valid.',
                    'correct' => 'Because the test failed, the theory cannot be valid.',
                    'explanation' => 'Untuk menarik kesimpulan bahwa sesuatu "tidak mungkin benar", gunakan "cannot be", bukan "must not be".'
                ],
                [
                    'incorrect' => 'The data anomaly may has been caused by calibration errors.',
                    'correct' => 'The data anomaly may have been caused by calibration errors.',
                    'explanation' => 'Setelah modal, selalu gunakan kata dasar "have", dilarang menggunakan "has" atau "had".'
                ],
                [
                    'incorrect' => 'The software can to classify high-resolution medical scans.',
                    'correct' => 'The software can classify high-resolution medical scans.',
                    'explanation' => 'Dilarang meletakkan partikel "to" langsung setelah modal dasar (can, may, must, should, will).'
                ],
            ],
            'exam_tips' => [
                'Gunakan modal seperti "may" atau "could" untuk menyajikan argumen atau kesimpulan yang berhati-hati dan terukur.',
                'Pastikan kata kerja setelah modal selalu kembali ke bentuk dasar (V1 murni tanpa -s, -ed, atau -ing).',
                'Ingat lawan kata dalam penarikan kesimpulan: "must be" (pasti benar) >< "cannot be" (mustahil/tidak mungkin benar).'
            ],
        ];
    }

    /**
     * Complete list of 8 sub-lessons for Topic 1.7
     */
    public static function getSubLessons(): array
    {
        return [
          [
            'id' => 'epistemic_possibility_hedging',
            'name' => 'Menyatakan Kemungkinan (May, Might, Could)',
            'code' => '1.7.1',
            'concept_title' => 'Menyatakan Kemungkinan (May, Might, Could)',
            'concept_description' => 'Dalam penulisan jurnal ilmiah dan esai akademik (IELTS/TOEFL), peneliti dilarang membuat klaim yang terlampau mutlak (overgeneralization). Modal derajat probabilitas tentatif (may, might, could) berfungsi sebagai instrumen \'hedging\' untuk melunakkan klaim, menginterpretasikan data secara hati-hati, dan menjaga objektivitas saintifik.',
            'formula' => 'Subject + MAY / MIGHT / COULD + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan \'may\' untuk kemungkinan moderat yang didukung indikasi teoritis kuat.',
              'Gunakan \'might\' atau \'could\' untuk probabilitas tentatif atau kemungkinan spekulatif dengan tingkat kepastian lebih rendah.',
              'Modal selalu diikuti kata kerja bentuk dasar (Bare Infinitive / V1 murni), dilarang menambahkan to atau akhiran -s/-es.',
              'Hedging dengan modal melindungi peneliti dari klaim yang belum terbukti 100% secara definitif.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Temuan awal ini mungkin mengindikasikan adanya hubungan tidak langsung antara kedua parameter iklim.',
                'target_word' => 'may indicate',
                'vocab' => [
                  'preliminary findings' => [
                    'id' => 'temuan awal',
                    'pos' => '(n phr)',
                  ],
                  'may' => [
                    'id' => 'mungkin / dapat (hedging)',
                    'pos' => '(modal)',
                  ],
                  'indicate' => [
                    'id' => 'mengindikasikan',
                    'pos' => '(v)',
                  ],
                  'indirect correlation' => [
                    'id' => 'hubungan tidak langsung',
                    'pos' => '(n phr)',
                  ],
                  'climate parameters' => [
                    'id' => 'parameter iklim',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'These preliminary findings may indicate an indirect correlation between the two climate parameters.',
                  'These preliminary findings may indicates an indirect correlation between the two climate parameters.',
                  'These preliminary findings may to indicate an indirect correlation between the two climate parameters.',
                  'These preliminary findings may indicating an indirect correlation between the two climate parameters.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal \'may\' wajib diikuti bare infinitive (\'may indicate\') untuk melunakkan klaim interpretasi temuan ilmiah.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Fluktuasi suhu yang drastis bisa memicu kerusakan struktural pada komposit polimer.',
                'target_word' => 'could trigger',
                'vocab' => [
                  'drastic temperature fluctuations' => [
                    'id' => 'fluktuasi suhu drastis',
                    'pos' => '(n phr)',
                  ],
                  'could' => [
                    'id' => 'bisa / dapat berpotensi',
                    'pos' => '(modal)',
                  ],
                  'trigger' => [
                    'id' => 'memicu',
                    'pos' => '(v)',
                  ],
                  'structural failure' => [
                    'id' => 'kerusakan struktural',
                    'pos' => '(n phr)',
                  ],
                  'polymer composites' => [
                    'id' => 'komposit polimer',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Drastic temperature fluctuations could trigger structural failure in polymer composites.',
                  'Drastic temperature fluctuations could triggers structural failure in polymer composites.',
                  'Drastic temperature fluctuations could to trigger structural failure in polymer composites.',
                  'Drastic temperature fluctuations could triggering structural failure in polymer composites.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal \'could\' diikuti kata kerja dasar (\'could trigger\') untuk menyatakan potensi risiko material.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Perubahan regulasi moneter mungkin memengaruhi keputusan investasi asing di sektor perbankan.',
                'target_word' => 'might influence',
                'vocab' => [
                  'monetary regulatory shifts' => [
                    'id' => 'perubahan regulasi moneter',
                    'pos' => '(n phr)',
                  ],
                  'might' => [
                    'id' => 'mungkin (tentatif)',
                    'pos' => '(modal)',
                  ],
                  'influence' => [
                    'id' => 'memengaruhi',
                    'pos' => '(v)',
                  ],
                  'foreign investment decisions' => [
                    'id' => 'keputusan investasi asing',
                    'pos' => '(n phr)',
                  ],
                  'banking sector' => [
                    'id' => 'sektor perbankan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Monetary regulatory shifts might influence foreign investment decisions in the banking sector.',
                  'Monetary regulatory shifts might influences foreign investment decisions in the banking sector.',
                  'Monetary regulatory shifts might to influence foreign investment decisions in the banking sector.',
                  'Monetary regulatory shifts might influencing foreign investment decisions in the banking sector.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal \'might\' diikuti verba bentuk dasar (\'might influence\').',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Kehadiran katalisator organik dapat mempercepat laju reaksi tanpa meningkatkan suhu wadah.',
                'target_word' => 'may accelerate',
                'vocab' => [
                  'presence' => [
                    'id' => 'kehadiran / adanya',
                    'pos' => '(n)',
                  ],
                  'organic catalyst' => [
                    'id' => 'katalisator organik',
                    'pos' => '(n phr)',
                  ],
                  'accelerate' => [
                    'id' => 'mempercepat',
                    'pos' => '(v)',
                  ],
                  'reaction rate' => [
                    'id' => 'laju reaksi',
                    'pos' => '(n phr)',
                  ],
                  'vessel temperature' => [
                    'id' => 'suhu wadah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The presence of an organic catalyst may accelerate the reaction rate without raising vessel temperature.',
                  'The presence of an organic catalyst may accelerates the reaction rate without raising vessel temperature.',
                  'The presence of an organic catalyst may to accelerate the reaction rate without raising vessel temperature.',
                  'The presence of an organic catalyst may accelerating the reaction rate without raising vessel temperature.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal \'may\' mengambil bare infinitive (\'may accelerate\').',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Kelemahan metodologis dalam survei tersebut bisa mendistorsi hasil estimasi populasi.',
                'target_word' => 'could distort',
                'vocab' => [
                  'methodological weaknesses' => [
                    'id' => 'kelemahan metodologis',
                    'pos' => '(n phr)',
                  ],
                  'survey' => [
                    'id' => 'survei',
                    'pos' => '(n)',
                  ],
                  'distort' => [
                    'id' => 'mendistorsi / membiaskan',
                    'pos' => '(v)',
                  ],
                  'population estimation results' => [
                    'id' => 'hasil estimasi populasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Methodological weaknesses in the survey could distort population estimation results.',
                  'Methodological weaknesses in the survey could distorts population estimation results.',
                  'Methodological weaknesses in the survey could to distort population estimation results.',
                  'Methodological weaknesses in the survey could distorting population estimation results.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Could distort\' (modal + bare verb) menyatakan potensi bias tanpa overstatement.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Paparan kronis terhadap polutan udara mikro mungkin melemahkan respons imun paru-paru.',
                'target_word' => 'might impair',
                'vocab' => [
                  'chronic exposure' => [
                    'id' => 'paparan kronis',
                    'pos' => '(n phr)',
                  ],
                  'microscopic air pollutants' => [
                    'id' => 'polutan udara mikro',
                    'pos' => '(n phr)',
                  ],
                  'impair' => [
                    'id' => 'melemahkan / merusak',
                    'pos' => '(v)',
                  ],
                  'pulmonary immune response' => [
                    'id' => 'respons imun paru-paru',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Chronic exposure to microscopic air pollutants might impair pulmonary immune responses.',
                  'Chronic exposure to microscopic air pollutants might impairs pulmonary immune responses.',
                  'Chronic exposure to microscopic air pollutants might to impair pulmonary immune responses.',
                  'Chronic exposure to microscopic air pollutants might impairing pulmonary immune responses.',
                ],
                'correct_index' => 0,
                'explanation' => 'Gunakan \'might impair\' untuk hipotesis biologis yang memerlukan pengujian lebih lanjut.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Model simulasi numerik ini mungkin menghasilkan perkiraan yang lebih realistis untuk daerah pesisir.',
                'target_word' => 'may yield',
                'vocab' => [
                  'numerical simulation model' => [
                    'id' => 'model simulasi numerik',
                    'pos' => '(n phr)',
                  ],
                  'yield' => [
                    'id' => 'menghasilkan',
                    'pos' => '(v)',
                  ],
                  'realistic estimates' => [
                    'id' => 'perkiraan realistis',
                    'pos' => '(n phr)',
                  ],
                  'coastal zones' => [
                    'id' => 'daerah pesisir',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This numerical simulation model may yield more realistic estimates for coastal zones.',
                  'This numerical simulation model may yields more realistic estimates for coastal zones.',
                  'This numerical simulation model may to yield more realistic estimates for coastal zones.',
                  'This numerical simulation model may yielding more realistic estimates for coastal zones.',
                ],
                'correct_index' => 0,
                'explanation' => '\'May yield\' menyatakan ekspektasi akademis dengan tingkat kehati-hatian (*cautious claim*).',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Ketidakstabilan geopolitik di kawasan tersebut bisa mengganggu rantai pasok semikonduktor global.',
                'target_word' => 'could disrupt',
                'vocab' => [
                  'geopolitical instability' => [
                    'id' => 'ketidakstabilan geopolitik',
                    'pos' => '(n phr)',
                  ],
                  'region' => [
                    'id' => 'kawasan / wilayah',
                    'pos' => '(n)',
                  ],
                  'disrupt' => [
                    'id' => 'mengganggu',
                    'pos' => '(v)',
                  ],
                  'global semiconductor supply chain' => [
                    'id' => 'rantai pasok semikonduktor global',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Geopolitical instability in the region could disrupt global semiconductor supply chains.',
                  'Geopolitical instability in the region could disrupts global semiconductor supply chains.',
                  'Geopolitical instability in the region could to disrupt global semiconductor supply chains.',
                  'Geopolitical instability in the region could disrupting global semiconductor supply chains.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Could disrupt\' menyatakan potensi skenario risiko makroekonomi.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Peningkatan curah hujan musiman mungkin berkontribusi terhadap erosi tanah di lereng bukit.',
                'target_word' => 'might contribute',
                'vocab' => [
                  'increased seasonal precipitation' => [
                    'id' => 'peningkatan curah hujan musiman',
                    'pos' => '(n phr)',
                  ],
                  'contribute' => [
                    'id' => 'berkontribusi',
                    'pos' => '(v)',
                  ],
                  'soil erosion' => [
                    'id' => 'erosi tanah',
                    'pos' => '(n phr)',
                  ],
                  'hillsides' => [
                    'id' => 'lereng bukit',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'Increased seasonal precipitation might contribute to soil erosion on steep hillsides.',
                  'Increased seasonal precipitation might contributes to soil erosion on steep hillsides.',
                  'Increased seasonal precipitation might to contribute to soil erosion on steep hillsides.',
                  'Increased seasonal precipitation might contributing to soil erosion on steep hillsides.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal \'might\' diikuti bare verb \'contribute\' dan preposisi \'to\' (\'might contribute to\').',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Variasi genetik yang baru ditemukan ini mungkin menjelaskan resistensi pasien terhadap terapi standar.',
                'target_word' => 'may account for',
                'vocab' => [
                  'newly identified genetic variation' => [
                    'id' => 'variasi genetik yang baru ditemukan',
                    'pos' => '(n phr)',
                  ],
                  'account for' => [
                    'id' => 'menjelaskan / menjadi penyebab',
                    'pos' => '(v phr)',
                  ],
                  'patient resistance' => [
                    'id' => 'resistensi pasien',
                    'pos' => '(n phr)',
                  ],
                  'standard therapy' => [
                    'id' => 'terapi standar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This newly identified genetic variation may account for patient resistance to standard therapy.',
                  'This newly identified genetic variation may accounts for patient resistance to standard therapy.',
                  'This newly identified genetic variation may to account for patient resistance to standard therapy.',
                  'This newly identified genetic variation may accounting for patient resistance to standard therapy.',
                ],
                'correct_index' => 0,
                'explanation' => '\'May account for\' adalah frasa modal hedging standar dalam artikel medis.',
              ],
            ],
          ],
          [
            'id' => 'capability_can',
            'name' => 'Menyatakan Kemampuan & Kapabilitas (Can, Could, Be able to)',
            'code' => '1.7.2',
            'concept_title' => 'Menyatakan Kemampuan & Kapabilitas (Can, Could, Be able to)',
            'concept_description' => 'Modal \'can\' dalam academic writing digunakan untuk menerangkan kapasitas teoretis, kemampuan fungsional sistem teknologi, atau potensi bawaan yang dapat dibuktikan secara empiris dalam kondisi terkontrol. Berbeda dengan \'may\' (kemungkinan), \'can\' menegaskan adanya kapabilitas riil.',
            'formula' => 'Subject + CAN + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan \'can + V1\' untuk mendeskripsikan kapabilitas fungsional algoritma, instrumen laboratorium, atau formula matematis.',
              'Dilarang menambahkan \'to\' setelah modal \'can\' (misal: \'can to solve\' ➔ SALAH; \'can solve\' ➔ BENAR).',
              'Dalam konstruksi infinitif setelah verba bantu lain, gunakan parafrase \'be able to\' (misal: \'is expected to be able to predict\').',
              'Gunakan bentuk negatif \'cannot\' (ditulis tersambung satu kata) untuk menyatakan ketidakmampuan absolut sistem.',
            ],
            'exercises' => [
              [
                'id' => 11,
                'id_sentence' => 'Spektrometer massa canggih ini dapat mendeteksi zat pencemar jejak pada konsentrasi bagian per triliun.',
                'target_word' => 'can detect',
                'vocab' => [
                  'advanced mass spectrometer' => [
                    'id' => 'spektrometer massa canggih',
                    'pos' => '(n phr)',
                  ],
                  'can' => [
                    'id' => 'dapat / mampu',
                    'pos' => '(modal)',
                  ],
                  'detect' => [
                    'id' => 'mendeteksi',
                    'pos' => '(v)',
                  ],
                  'trace contaminants' => [
                    'id' => 'zat pencemar jejak',
                    'pos' => '(n phr)',
                  ],
                  'parts-per-trillion concentrations' => [
                    'id' => 'konsentrasi bagian per triliun',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This advanced mass spectrometer can detect trace contaminants at parts-per-trillion concentrations.',
                  'This advanced mass spectrometer can detects trace contaminants at parts-per-trillion concentrations.',
                  'This advanced mass spectrometer can to detect trace contaminants at parts-per-trillion concentrations.',
                  'This advanced mass spectrometer can detecting trace contaminants at parts-per-trillion concentrations.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can detect\' mengekspresikan kapabilitas teknis instrumen secara lugas tanpa \'to\' atau akhiran \'-s\'.',
              ],
              [
                'id' => 12,
                'id_sentence' => 'Arsitektur jaringan saraf tiruan yang diusulkan dapat mengklasifikasikan pola citra medis dengan akurasi 98%.',
                'target_word' => 'can classify',
                'vocab' => [
                  'proposed neural network architecture' => [
                    'id' => 'arsitektur jaringan saraf tiruan yang diusulkan',
                    'pos' => '(n phr)',
                  ],
                  'classify' => [
                    'id' => 'mengklasifikasikan',
                    'pos' => '(v)',
                  ],
                  'medical image patterns' => [
                    'id' => 'pola citra medis',
                    'pos' => '(n phr)',
                  ],
                  'accuracy' => [
                    'id' => 'akurasi',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The proposed neural network architecture can classify medical image patterns with 98% accuracy.',
                  'The proposed neural network architecture can classifies medical image patterns with 98% accuracy.',
                  'The proposed neural network architecture can to classify medical image patterns with 98% accuracy.',
                  'The proposed neural network architecture can of classifying medical image patterns with 98% accuracy.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal kapabilitas \'can\' wajib diikuti bentuk kata kerja dasar (\'can classify\').',
              ],
              [
                'id' => 13,
                'id_sentence' => 'Metode penyulingan bertingkat ini tidak dapat menghilangkan seluruh residu logam berat dari air limbah.',
                'target_word' => 'cannot eliminate',
                'vocab' => [
                  'fractional distillation method' => [
                    'id' => 'metode penyulingan bertingkat',
                    'pos' => '(n phr)',
                  ],
                  'cannot' => [
                    'id' => 'tidak dapat (satu kata)',
                    'pos' => '(modal neg)',
                  ],
                  'eliminate' => [
                    'id' => 'menghilangkan / mengeliminasi',
                    'pos' => '(v)',
                  ],
                  'heavy metal residues' => [
                    'id' => 'residu logam berat',
                    'pos' => '(n phr)',
                  ],
                  'wastewater' => [
                    'id' => 'air limbah',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'This fractional distillation method cannot eliminate all heavy metal residues from wastewater.',
                  'This fractional distillation method can not to eliminate all heavy metal residues from wastewater.',
                  'This fractional distillation method cannot eliminates all heavy metal residues from wastewater.',
                  'This fractional distillation method cannot eliminating all heavy metal residues from wastewater.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk standar \'cannot eliminate\' ditulis sebagai satu kata dalam bahasa Inggris akademik formal.',
              ],
              [
                'id' => 14,
                'id_sentence' => 'Sel punca pluripoten dapat berdiferensiasi menjadi hampir semua jenis sel khusus dalam tubuh manusia.',
                'target_word' => 'can differentiate',
                'vocab' => [
                  'pluripotent stem cells' => [
                    'id' => 'sel punca pluripoten',
                    'pos' => '(n phr)',
                  ],
                  'differentiate' => [
                    'id' => 'berdiferensiasi',
                    'pos' => '(v)',
                  ],
                  'specialized cell types' => [
                    'id' => 'jenis sel khusus',
                    'pos' => '(n phr)',
                  ],
                  'human body' => [
                    'id' => 'tubuh manusia',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Pluripotent stem cells can differentiate into nearly all specialized cell types in the human body.',
                  'Pluripotent stem cells can differentiates into nearly all specialized cell types in the human body.',
                  'Pluripotent stem cells can to differentiate into nearly all specialized cell types in the human body.',
                  'Pluripotent stem cells can differentiating into nearly all specialized cell types in the human body.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba dasar \'differentiate\' mengikuti modal kapabilitas bawaan \'can\'.',
              ],
              [
                'id' => 15,
                'id_sentence' => 'Sensor serat optik mampu mengukur deformasi regangan mikro di sepanjang struktur jembatan gantung.',
                'target_word' => 'is able to measure',
                'vocab' => [
                  'fiber-optic sensor' => [
                    'id' => 'sensor serat optik',
                    'pos' => '(n phr)',
                  ],
                  'is able to' => [
                    'id' => 'mampu',
                    'pos' => '(adj phr)',
                  ],
                  'measure' => [
                    'id' => 'mengukur',
                    'pos' => '(v)',
                  ],
                  'micro-strain deformation' => [
                    'id' => 'deformasi regangan mikro',
                    'pos' => '(n phr)',
                  ],
                  'suspension bridge' => [
                    'id' => 'jembatan gantung',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The fiber-optic sensor is able to measure micro-strain deformation along the suspension bridge.',
                  'The fiber-optic sensor is able measure micro-strain deformation along the suspension bridge.',
                  'The fiber-optic sensor is able to measuring micro-strain deformation along the suspension bridge.',
                  'The fiber-optic sensor is able for measure micro-strain deformation along the suspension bridge.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Be able to\' membutuhkan to-infinitive (\'is able to measure\') untuk mengekspresikan kapabilitas terukur.',
              ],
              [
                'id' => 16,
                'id_sentence' => 'Kerangka kerja kriptografi kuantum dapat mengamankan komunikasi data terhadap upaya peretasan komputasi tercepat.',
                'target_word' => 'can secure',
                'vocab' => [
                  'quantum cryptographic framework' => [
                    'id' => 'kerangka kerja kriptografi kuantum',
                    'pos' => '(n phr)',
                  ],
                  'secure' => [
                    'id' => 'mengamankan',
                    'pos' => '(v)',
                  ],
                  'data communications' => [
                    'id' => 'komunikasi data',
                    'pos' => '(n phr)',
                  ],
                  'computational interception' => [
                    'id' => 'upaya peretasan komputasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'A quantum cryptographic framework can secure data communications against computational interception.',
                  'A quantum cryptographic framework can secures data communications against computational interception.',
                  'A quantum cryptographic framework can to secure data communications against computational interception.',
                  'A quantum cryptographic framework can securing data communications against computational interception.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can secure\' menyatakan kapabilitas teoretis teknologi kriptografi.',
              ],
              [
                'id' => 17,
                'id_sentence' => 'Para ahli ekologi dapat memodelkan dinamika predator-mangsa dengan persamaan diferensial non-linear.',
                'target_word' => 'can model',
                'vocab' => [
                  'ecologists' => [
                    'id' => 'para ahli ekologi',
                    'pos' => '(n)',
                  ],
                  'model' => [
                    'id' => 'memodelkan',
                    'pos' => '(v)',
                  ],
                  'predator-prey dynamics' => [
                    'id' => 'dinamika predator-mangsa',
                    'pos' => '(n phr)',
                  ],
                  'non-linear differential equations' => [
                    'id' => 'persamaan diferensial non-linear',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Ecologists can model predator-prey dynamics using non-linear differential equations.',
                  'Ecologists can models predator-prey dynamics using non-linear differential equations.',
                  'Ecologists can to model predator-prey dynamics using non-linear differential equations.',
                  'Ecologists can modeling predator-prey dynamics using non-linear differential equations.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can model\' (modal + V1) menerangkan metodologi pemodelan matematika.',
              ],
              [
                'id' => 18,
                'id_sentence' => 'Baterai lithium-sulfur baru ini dapat menyimpan energi dua kali lebih banyak daripada sel ion standar.',
                'target_word' => 'can store',
                'vocab' => [
                  'lithium-sulfur battery' => [
                    'id' => 'baterai lithium-sulfur',
                    'pos' => '(n phr)',
                  ],
                  'store' => [
                    'id' => 'menyimpan',
                    'pos' => '(v)',
                  ],
                  'twice as much energy' => [
                    'id' => 'energi dua kali lebih banyak',
                    'pos' => '(phr)',
                  ],
                  'standard ion cells' => [
                    'id' => 'sel ion standar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This novel lithium-sulfur battery can store twice as much energy as standard ion cells.',
                  'This novel lithium-sulfur battery can stores twice as much energy as standard ion cells.',
                  'This novel lithium-sulfur battery can to store twice as much energy as standard ion cells.',
                  'This novel lithium-sulfur battery can storing twice as much energy as standard ion cells.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can store\' mengekspresikan kapasitas fisik baterai.',
              ],
              [
                'id' => 19,
                'id_sentence' => 'Tanpa data kalibrasi dasar, para peneliti tidak dapat memvalidasi akurasi instrumen tersebut.',
                'target_word' => 'cannot validate',
                'vocab' => [
                  'baseline calibration data' => [
                    'id' => 'data kalibrasi dasar',
                    'pos' => '(n phr)',
                  ],
                  'validate' => [
                    'id' => 'memvalidasi',
                    'pos' => '(v)',
                  ],
                  'instrument accuracy' => [
                    'id' => 'akurasi instrumen',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Without baseline calibration data, researchers cannot validate the instrument accuracy.',
                  'Without baseline calibration data, researchers cannot validates the instrument accuracy.',
                  'Without baseline calibration data, researchers can not to validate the instrument accuracy.',
                  'Without baseline calibration data, researchers cannot validating the instrument accuracy.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Cannot validate\' menunjukkan ketiadaan kapabilitas akibat keterbatasan prasyarat metodologis.',
              ],
              [
                'id' => 20,
                'id_sentence' => 'Turbin angin lepas pantai dapat menghasilkan daya listrik yang stabil bahkan pada kecepatan angin rendah.',
                'target_word' => 'can generate',
                'vocab' => [
                  'offshore wind turbines' => [
                    'id' => 'turbin angin lepas pantai',
                    'pos' => '(n phr)',
                  ],
                  'generate' => [
                    'id' => 'menghasilkan',
                    'pos' => '(v)',
                  ],
                  'stable electrical power' => [
                    'id' => 'daya listrik stabil',
                    'pos' => '(n phr)',
                  ],
                  'low wind speeds' => [
                    'id' => 'kecepatan angin rendah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Offshore wind turbines can generate stable electrical power even at low wind velocities.',
                  'Offshore wind turbines can generates stable electrical power even at low wind velocities.',
                  'Offshore wind turbines can to generate stable electrical power even at low wind velocities.',
                  'Offshore wind turbines can generating stable electrical power even at low wind velocities.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can generate\' adalah konstruksi modal kapabilitas teknis yang baku.',
              ],
            ],
          ],
          [
            'id' => 'recommendation_should',
            'name' => 'Menyatakan Saran & Rekomendasi (Should, Ought to)',
            'code' => '1.7.3',
            'concept_title' => 'Menyatakan Saran & Rekomendasi (Should, Ought to)',
            'concept_description' => 'Di bab pembahasan (Discussion) dan kesimpulan (Conclusion) tesis atau makalah ilmiah, penulis menyampaikan anjuran perbaikan atau rekomendasi kebijakan publik menggunakan \'should\' atau \'ought to\'. Modal ini mengekspresikan kewajiban moral/ilmiah secara persuasif dan elegan tanpa terdengar otoriter seperti \'must\'.',
            'formula' => 'Subject (Governments / Researchers / Clinicians) + SHOULD / OUGHT TO + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan \'should + V1\' untuk merumuskan saran penelitian lanjutan atau intervensi kebijakan.',
              'Gunakan \'ought to + V1\' sebagai padanan yang lebih formal dan berbobot normatif.',
              'Hindari penggunaan kata kerja imperatif langsung (\'Do this!\') dalam naskah ilmiah; gunakan konstruksi modal rekomendasi.',
              'Dalam saran metodologis impersonal, gabungkan dengan pasif (\'further studies should be conducted\').',
            ],
            'exercises' => [
              [
                'id' => 21,
                'id_sentence' => 'Para pembuat kebijakan sebaiknya mempertimbangkan dampak sosio-ekologis sebelum menyetujui proyek bendungan besar.',
                'target_word' => 'should consider',
                'vocab' => [
                  'policymakers' => [
                    'id' => 'para pembuat kebijakan',
                    'pos' => '(n)',
                  ],
                  'should' => [
                    'id' => 'sebaiknya / seyogianya',
                    'pos' => '(modal)',
                  ],
                  'consider' => [
                    'id' => 'mempertimbangkan',
                    'pos' => '(v)',
                  ],
                  'socio-ecological impacts' => [
                    'id' => 'dampak sosio-ekologis',
                    'pos' => '(n phr)',
                  ],
                  'mega-dam project' => [
                    'id' => 'proyek bendungan besar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Policymakers should consider socio-ecological impacts prior to approving the mega-dam project.',
                  'Policymakers should considers socio-ecological impacts prior to approving the mega-dam project.',
                  'Policymakers should to consider socio-ecological impacts prior to approving the mega-dam project.',
                  'Policymakers should considering socio-ecological impacts prior to approving the mega-dam project.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal \'should\' diikuti bentuk dasar verba (\'should consider\') untuk merumuskan rekomendasi kebijakan yang obyektif.',
              ],
              [
                'id' => 22,
                'id_sentence' => 'Peneliti masa depan sebaiknya memperluas ukuran sampel untuk memvalidasi temuan awal ini.',
                'target_word' => 'ought to expand',
                'vocab' => [
                  'future researchers' => [
                    'id' => 'peneliti masa depan',
                    'pos' => '(n phr)',
                  ],
                  'ought to' => [
                    'id' => 'sepatutnya / seyogianya',
                    'pos' => '(modal)',
                  ],
                  'expand' => [
                    'id' => 'memperluas',
                    'pos' => '(v)',
                  ],
                  'sample size' => [
                    'id' => 'ukuran sampel',
                    'pos' => '(n phr)',
                  ],
                  'validate preliminary findings' => [
                    'id' => 'memvalidasi temuan awal',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Future researchers ought to expand the sample size to validate these preliminary findings.',
                  'Future researchers ought expand the sample size to validate these preliminary findings.',
                  'Future researchers ought to expanding the sample size to validate these preliminary findings.',
                  'Future researchers ought to expands the sample size to validate these preliminary findings.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Ought to\' selalu menyertakan partikel \'to\' diikuti bare verb (\'ought to expand\').',
              ],
              [
                'id' => 23,
                'id_sentence' => 'Institusi kesehatan masyarakat seharusnya mengalokasikan lebih banyak sumber daya untuk pencegahan epidemi.',
                'target_word' => 'should allocate',
                'vocab' => [
                  'public health institutions' => [
                    'id' => 'institusi kesehatan masyarakat',
                    'pos' => '(n phr)',
                  ],
                  'allocate' => [
                    'id' => 'mengalokasikan',
                    'pos' => '(v)',
                  ],
                  'resources' => [
                    'id' => 'sumber daya',
                    'pos' => '(n)',
                  ],
                  'epidemic prevention' => [
                    'id' => 'pencegahan epidemi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Public health institutions should allocate more resources to epidemic prevention strategies.',
                  'Public health institutions should allocates more resources to epidemic prevention strategies.',
                  'Public health institutions should to allocate more resources to epidemic prevention strategies.',
                  'Public health institutions should allocating more resources to epidemic prevention strategies.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should allocate\' menyampaikan anjuran alokasi anggaran secara persuasif dan terukur.',
              ],
              [
                'id' => 24,
                'id_sentence' => 'Laboratorium pengujian sepatutnya mematuhi standar sertifikasi internasional yang diakui.',
                'target_word' => 'ought to adhere to',
                'vocab' => [
                  'testing laboratories' => [
                    'id' => 'laboratorium pengujian',
                    'pos' => '(n phr)',
                  ],
                  'adhere to' => [
                    'id' => 'mematuhi / menaati',
                    'pos' => '(v phr)',
                  ],
                  'recognized international certification standards' => [
                    'id' => 'standar sertifikasi internasional yang diakui',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Testing laboratories ought to adhere to recognized international certification standards.',
                  'Testing laboratories ought adhere to recognized international certification standards.',
                  'Testing laboratories ought to adhering to recognized international certification standards.',
                  'Testing laboratories ought to adheres to recognized international certification standards.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Ought to adhere to\' memadukan modal rekomendasi normatif dengan phrasal verb baku.',
              ],
              [
                'id' => 25,
                'id_sentence' => 'Dokter bedah sebaiknya tidak mengabaikan perubahan kecil pada tanda-tanda vital pasien.',
                'target_word' => 'should not ignore',
                'vocab' => [
                  'surgeons' => [
                    'id' => 'dokter bedah',
                    'pos' => '(n)',
                  ],
                  'should not' => [
                    'id' => 'sebaiknya tidak',
                    'pos' => '(modal neg)',
                  ],
                  'ignore' => [
                    'id' => 'mengabaikan',
                    'pos' => '(v)',
                  ],
                  'subtle changes' => [
                    'id' => 'perubahan kecil / halus',
                    'pos' => '(n phr)',
                  ],
                  'vital signs' => [
                    'id' => 'tanda-tanda vital',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Surgeons should not ignore subtle changes in patient vital signs during anesthesia.',
                  'Surgeons should not ignores subtle changes in patient vital signs during anesthesia.',
                  'Surgeons should not to ignore subtle changes in patient vital signs during anesthesia.',
                  'Surgeons should not ignoring subtle changes in patient vital signs during anesthesia.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk negatif rekomendasi adalah \'should not + V1\' (\'should not ignore\').',
              ],
              [
                'id' => 26,
                'id_sentence' => 'Pemerintah kota seharusnya mengintegrasikan koridor hijau ke dalam perencanaan tata ruang kota.',
                'target_word' => 'should integrate',
                'vocab' => [
                  'municipal governments' => [
                    'id' => 'pemerintah kota',
                    'pos' => '(n phr)',
                  ],
                  'integrate' => [
                    'id' => 'mengintegrasikan',
                    'pos' => '(v)',
                  ],
                  'green corridors' => [
                    'id' => 'koridor hijau',
                    'pos' => '(n phr)',
                  ],
                  'urban spatial planning' => [
                    'id' => 'perencanaan tata ruang kota',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Municipal governments should integrate green corridors into urban spatial planning frameworks.',
                  'Municipal governments should integrates green corridors into urban spatial planning frameworks.',
                  'Municipal governments should to integrate green corridors into urban spatial planning frameworks.',
                  'Municipal governments should integrating green corridors into urban spatial planning frameworks.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should integrate\' adalah rekomendasi perencanaan kota yang terstruktur.',
              ],
              [
                'id' => 27,
                'id_sentence' => 'Para akademisi sepatutnya menjaga transparansi penuh mengenai konflik kepentingan finansial.',
                'target_word' => 'ought to maintain',
                'vocab' => [
                  'academics' => [
                    'id' => 'para akademisi',
                    'pos' => '(n)',
                  ],
                  'maintain' => [
                    'id' => 'menjaga / mempertahankan',
                    'pos' => '(v)',
                  ],
                  'full transparency' => [
                    'id' => 'transparansi penuh',
                    'pos' => '(n phr)',
                  ],
                  'financial conflicts of interest' => [
                    'id' => 'konflik kepentingan finansial',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Academics ought to maintain full transparency regarding potential financial conflicts of interest.',
                  'Academics ought maintain full transparency regarding potential financial conflicts of interest.',
                  'Academics ought to maintaining full transparency regarding potential financial conflicts of interest.',
                  'Academics ought to maintains full transparency regarding potential financial conflicts of interest.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Ought to maintain\' menegaskan standar integritas etika ilmiah.',
              ],
              [
                'id' => 28,
                'id_sentence' => 'Penulis artikel ilmiah sebaiknya membatasi penggunaan kalimat pasif yang berlebihan pada bagian pendahuluan.',
                'target_word' => 'should limit',
                'vocab' => [
                  'authors' => [
                    'id' => 'penulis artikel ilmiah',
                    'pos' => '(n)',
                  ],
                  'limit' => [
                    'id' => 'membatasi',
                    'pos' => '(v)',
                  ],
                  'excessive passive constructions' => [
                    'id' => 'kalimat pasif berlebihan',
                    'pos' => '(n phr)',
                  ],
                  'introductory sections' => [
                    'id' => 'bagian pendahuluan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Authors should limit excessive passive constructions in introductory manuscript sections.',
                  'Authors should limits excessive passive constructions in introductory manuscript sections.',
                  'Authors should to limit excessive passive constructions in introductory manuscript sections.',
                  'Authors should limiting excessive passive constructions in introductory manuscript sections.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should limit\' memberikan panduan stilistik akademis.',
              ],
              [
                'id' => 29,
                'id_sentence' => 'Otoritas keuangan seharusnya memperketat pengawasan terhadap transaksi kripto berisiko tinggi.',
                'target_word' => 'should tighten',
                'vocab' => [
                  'regulatory authorities' => [
                    'id' => 'otoritas pengawas keuangan',
                    'pos' => '(n phr)',
                  ],
                  'tighten' => [
                    'id' => 'memperketat',
                    'pos' => '(v)',
                  ],
                  'oversight' => [
                    'id' => 'pengawasan',
                    'pos' => '(n)',
                  ],
                  'high-risk cryptocurrency transactions' => [
                    'id' => 'transaksi kripto berisiko tinggi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Financial regulatory authorities should tighten oversight of high-risk cryptocurrency transactions.',
                  'Financial regulatory authorities should tightens oversight of high-risk cryptocurrency transactions.',
                  'Financial regulatory authorities should to tighten oversight of high-risk cryptocurrency transactions.',
                  'Financial regulatory authorities should tightening oversight of high-risk cryptocurrency transactions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should tighten\' mengekspresikan tindakan regulatif yang dianjurkan.',
              ],
              [
                'id' => 30,
                'id_sentence' => 'Para insinyur sepatutnya menguji kembali ketahanan material terhadap korosi sebelum pemasangan akhir.',
                'target_word' => 'ought to retest',
                'vocab' => [
                  'engineers' => [
                    'id' => 'para insinyur',
                    'pos' => '(n)',
                  ],
                  'retest' => [
                    'id' => 'menguji kembali',
                    'pos' => '(v)',
                  ],
                  'corrosion resistance' => [
                    'id' => 'ketahanan terhadap korosi',
                    'pos' => '(n phr)',
                  ],
                  'final installation' => [
                    'id' => 'pemasangan akhir',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers ought to retest material corrosion resistance prior to final installation.',
                  'Engineers ought retest material corrosion resistance prior to final installation.',
                  'Engineers ought to retesting material corrosion resistance prior to final installation.',
                  'Engineers ought to retests material corrosion resistance prior to final installation.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Ought to retest\' menandai kewajiban prosedural demi keselamatan teknis.',
              ],
            ],
          ],
          [
            'id' => 'epistemic_deduction_must',
            'name' => 'Menyatakan Kepastian & Kesimpulan Logis (Must, Cannot)',
            'code' => '1.7.4',
            'concept_title' => 'Menyatakan Kepastian & Kesimpulan Logis (Must, Cannot)',
            'concept_description' => 'Ketika bukti empiris atau fakta rasional mengarah pada satu kesimpulan yang tak terelakkan, bahasa akademik menggunakan \'must\' (pasti / tidak diragukan lagi) untuk deduksi afirmatif, dan \'cannot\' (mustahil / tidak mungkin) untuk deduksi negatif. Ini berbeda dengan \'must\' kewajiban sosial; \'must\' epistemik menyatakan derajat kepastian logis tingkat tinggi.',
            'formula' => 'Subject + MUST / CANNOT + BE + Adjective / Noun ATAU Subject + MUST / CANNOT + V1',
            'rules' => [
              'Gunakan \'must + V1\' atau \'must be + Adj/Noun\' saat bukti logis memaksa satu kesimpulan yang pasti.',
              'Lawan negatif dari \'must\' epistemik BUKAN \'must not\', melainkan \'cannot\' (artinya mustahil/tidak logis).',
              '\'Must not\' hanya dipakai untuk larangan regulasi (prohibition), bukan untuk deduksi kesimpulan.',
              'Gunakan deduksi epistemik secara hemat dalam artikel penelitian untuk menghindari kesan arogansi ilmiah.',
            ],
            'exercises' => [
              [
                'id' => 31,
                'id_sentence' => 'Mengingat laju transmisi yang luar biasa cepat, varian virus tersebut pasti sangat menular.',
                'target_word' => 'must be highly contagious',
                'vocab' => [
                  'rapid transmission rate' => [
                    'id' => 'laju transmisi yang luar biasa cepat',
                    'pos' => '(n phr)',
                  ],
                  'viral variant' => [
                    'id' => 'varian virus',
                    'pos' => '(n phr)',
                  ],
                  'must be' => [
                    'id' => 'pasti / tentu saja',
                    'pos' => '(modal + be)',
                  ],
                  'highly contagious' => [
                    'id' => 'sangat menular',
                    'pos' => '(adj phr)',
                  ],
                ],
                'options' => [
                  'Given its rapid transmission rate, the viral variant must be highly contagious.',
                  'Given its rapid transmission rate, the viral variant must to be highly contagious.',
                  'Given its rapid transmission rate, the viral variant must is highly contagious.',
                  'Given its rapid transmission rate, the viral variant must being highly contagious.',
                ],
                'correct_index' => 0,
                'explanation' => 'Deduksi logis afirmatif dengan kata sifat menggunakan \'must be + Adjective\' (\'must be highly contagious\').',
              ],
              [
                'id' => 32,
                'id_sentence' => 'Karena data menunjukkan penurunan drastis, hipotesis awal peneliti tidak mungkin benar.',
                'target_word' => 'cannot be correct',
                'vocab' => [
                  'drastic decline' => [
                    'id' => 'penurunan drastis',
                    'pos' => '(n phr)',
                  ],
                  'initial hypothesis' => [
                    'id' => 'hipotesis awal',
                    'pos' => '(n phr)',
                  ],
                  'cannot be' => [
                    'id' => 'mustahil / tidak mungkin',
                    'pos' => '(modal neg + be)',
                  ],
                  'correct' => [
                    'id' => 'benar',
                    'pos' => '(adj)',
                  ],
                ],
                'options' => [
                  'Because the empirical data shows a drastic decline, the researcher initial hypothesis cannot be correct.',
                  'Because the empirical data shows a drastic decline, the researcher initial hypothesis must not be correct.',
                  'Because the empirical data shows a drastic decline, the researcher initial hypothesis cannot to be correct.',
                  'Because the empirical data shows a drastic decline, the researcher initial hypothesis cannot being correct.',
                ],
                'correct_index' => 0,
                'explanation' => 'Penyangkalan deduksi logis (mustahil benar) wajib menggunakan \'cannot be\', bukan \'must not be\'.',
              ],
              [
                'id' => 33,
                'id_sentence' => 'Lapisan tanah yang membeku secara permanen pasti mengandung sejumlah besar gas metana terperangkap.',
                'target_word' => 'must contain',
                'vocab' => [
                  'permafrost layer' => [
                    'id' => 'lapisan tanah yang membeku permanen',
                    'pos' => '(n phr)',
                  ],
                  'must' => [
                    'id' => 'pasti',
                    'pos' => '(modal)',
                  ],
                  'contain' => [
                    'id' => 'mengandung',
                    'pos' => '(v)',
                  ],
                  'substantial volumes' => [
                    'id' => 'sejumlah besar',
                    'pos' => '(n phr)',
                  ],
                  'trapped methane gas' => [
                    'id' => 'gas metana terperangkap',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The permafrost layer must contain substantial volumes of trapped methane gas.',
                  'The permafrost layer must contains substantial volumes of trapped methane gas.',
                  'The permafrost layer must to contain substantial volumes of trapped methane gas.',
                  'The permafrost layer must containing substantial volumes of trapped methane gas.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must contain\' (modal + bare verb) menyatakan deduksi ilmiah berdasarkan geologi termal.',
              ],
              [
                'id' => 34,
                'id_sentence' => 'Dengan tingkat kebisingan akustik setinggi itu, sensor bawah air tidak mungkin mendeteksi getaran mikro.',
                'target_word' => 'cannot detect',
                'vocab' => [
                  'acoustic noise levels' => [
                    'id' => 'tingkat kebisingan akustik',
                    'pos' => '(n phr)',
                  ],
                  'underwater sensor' => [
                    'id' => 'sensor bawah air',
                    'pos' => '(n phr)',
                  ],
                  'cannot' => [
                    'id' => 'tidak mungkin / mustahil',
                    'pos' => '(modal neg)',
                  ],
                  'detect' => [
                    'id' => 'mendeteksi',
                    'pos' => '(v)',
                  ],
                  'micro-vibrations' => [
                    'id' => 'getaran mikro',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'With such elevated acoustic noise levels, the underwater sensor cannot detect micro-vibrations.',
                  'With such elevated acoustic noise levels, the underwater sensor must not detect micro-vibrations.',
                  'With such elevated acoustic noise levels, the underwater sensor cannot to detect micro-vibrations.',
                  'With such elevated acoustic noise levels, the underwater sensor cannot detecting micro-vibrations.',
                ],
                'correct_index' => 0,
                'explanation' => 'Deduksi negatif matematis menggunakan \'cannot detect\'.',
              ],
              [
                'id' => 35,
                'id_sentence' => 'Perbedaan tajam dalam hasil eksperimen pasti mencerminkan variasi dalam kondisi kelembapan laboratorium.',
                'target_word' => 'must reflect',
                'vocab' => [
                  'sharp divergence' => [
                    'id' => 'perbedaan tajam',
                    'pos' => '(n phr)',
                  ],
                  'experimental outcomes' => [
                    'id' => 'hasil eksperimen',
                    'pos' => '(n phr)',
                  ],
                  'reflect' => [
                    'id' => 'mencerminkan',
                    'pos' => '(v)',
                  ],
                  'humidity variations' => [
                    'id' => 'variasi kelembapan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The sharp divergence in experimental outcomes must reflect variations in ambient humidity conditions.',
                  'The sharp divergence in experimental outcomes must reflects variations in ambient humidity conditions.',
                  'The sharp divergence in experimental outcomes must to reflect variations in ambient humidity conditions.',
                  'The sharp divergence in experimental outcomes must reflecting variations in ambient humidity conditions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must reflect\' adalah kesimpulan logis yang tak terelakkan dari perbedaan data.',
              ],
              [
                'id' => 36,
                'id_sentence' => 'Senyawa yang sangat tidak stabil tersebut tidak mungkin bertahan pada suhu di atas 300 derajat Celsius.',
                'target_word' => 'cannot survive',
                'vocab' => [
                  'highly unstable compound' => [
                    'id' => 'senyawa sangat tidak stabil',
                    'pos' => '(n phr)',
                  ],
                  'survive' => [
                    'id' => 'bertahan',
                    'pos' => '(v)',
                  ],
                  'temperatures' => [
                    'id' => 'suhu',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The highly unstable compound cannot survive at temperatures exceeding 300 degrees Celsius.',
                  'The highly unstable compound must not survive at temperatures exceeding 300 degrees Celsius.',
                  'The highly unstable compound cannot to survive at temperatures exceeding 300 degrees Celsius.',
                  'The highly unstable compound cannot surviving at temperatures exceeding 300 degrees Celsius.',
                ],
                'correct_index' => 0,
                'explanation' => 'Ketidakmungkinan termodinamika dinyatakan dengan \'cannot survive\'.',
              ],
              [
                'id' => 37,
                'id_sentence' => 'Tanpa adanya pasokan oksigen terlarut, organisme aerobik pasti mati dalam beberapa menit.',
                'target_word' => 'must perish',
                'vocab' => [
                  'absence of dissolved oxygen' => [
                    'id' => 'ketiadaan pasokan oksigen terlarut',
                    'pos' => '(n phr)',
                  ],
                  'aerobic organisms' => [
                    'id' => 'organisme aerobik',
                    'pos' => '(n phr)',
                  ],
                  'perish' => [
                    'id' => 'mati / binasa',
                    'pos' => '(v)',
                  ],
                  'within minutes' => [
                    'id' => 'dalam beberapa menit',
                    'pos' => '(prep phr)',
                  ],
                ],
                'options' => [
                  'In the absence of dissolved oxygen, aerobic organisms must perish within minutes.',
                  'In the absence of dissolved oxygen, aerobic organisms must perishes within minutes.',
                  'In the absence of dissolved oxygen, aerobic organisms must to perish within minutes.',
                  'In the absence of dissolved oxygen, aerobic organisms must perishing within minutes.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must perish\' menyatakan konsekuensi biologis mutlak.',
              ],
              [
                'id' => 38,
                'id_sentence' => 'Korelasi statistik yang begitu tinggi tidak mungkin sekadar kebetulan acak semata.',
                'target_word' => 'cannot be mere coincidence',
                'vocab' => [
                  'high statistical correlation' => [
                    'id' => 'korelasi statistik tinggi',
                    'pos' => '(n phr)',
                  ],
                  'mere coincidence' => [
                    'id' => 'kebetulan acak semata',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Such a high statistical correlation cannot be a mere random coincidence.',
                  'Such a high statistical correlation must not be a mere random coincidence.',
                  'Such a high statistical correlation cannot to be a mere random coincidence.',
                  'Such a high statistical correlation cannot being a mere random coincidence.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Cannot be a mere random coincidence\' adalah deduksi logis penolakan hipotesis nol.',
              ],
              [
                'id' => 39,
                'id_sentence' => 'Penurunan tajam populasi lebah madu pasti mengganggu stabilitas penyerbukan tanaman pertanian.',
                'target_word' => 'must disrupt',
                'vocab' => [
                  'steep decline' => [
                    'id' => 'penurunan tajam',
                    'pos' => '(n phr)',
                  ],
                  'honeybee population' => [
                    'id' => 'populasi lebah madu',
                    'pos' => '(n phr)',
                  ],
                  'disrupt' => [
                    'id' => 'mengganggu',
                    'pos' => '(v)',
                  ],
                  'crop pollination stability' => [
                    'id' => 'stabilitas penyerbukan tanaman',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'A steep decline in the honeybee population must disrupt crop pollination stability.',
                  'A steep decline in the honeybee population must disrupts crop pollination stability.',
                  'A steep decline in the honeybee population must to disrupt crop pollination stability.',
                  'A steep decline in the honeybee population must disrupting crop pollination stability.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must disrupt\' menyatakan keniscayaan ekologis kausal.',
              ],
              [
                'id' => 40,
                'id_sentence' => 'Sampel batuan purba tersebut tidak mungkin berasal dari periode geologi yang lebih muda.',
                'target_word' => 'cannot originate from',
                'vocab' => [
                  'ancient rock specimen' => [
                    'id' => 'sampel batuan purba',
                    'pos' => '(n phr)',
                  ],
                  'originate from' => [
                    'id' => 'berasal dari',
                    'pos' => '(v phr)',
                  ],
                  'younger geological era' => [
                    'id' => 'periode geologi yang lebih muda',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The ancient rock specimen cannot originate from a younger geological era.',
                  'The ancient rock specimen must not originate from a younger geological era.',
                  'The ancient rock specimen cannot to originate from a younger geological era.',
                  'The ancient rock specimen cannot originating from a younger geological era.',
                ],
                'correct_index' => 0,
                'explanation' => 'Deduksi kronologis ilmiah menggunakan \'cannot originate from\'.',
              ],
            ],
          ],
          [
            'id' => 'predictive_certainty_will_would',
            'name' => 'Menyatakan Masa Depan & Kepastian (Will, Would)',
            'code' => '1.7.5',
            'concept_title' => 'Menyatakan Masa Depan & Kepastian (Will, Would)',
            'concept_description' => 'Dalam memproyeksikan implikasi riset atau dampak skenario jangka panjang, penulis membedakan antara \'will\' (kepastian prediktif tinggi berdasarkan data model) dan \'would\' (kondisi hipotetis atau probabilitas bersyarat). Memilih modal yang tepat mencegah ketidaktepatan proyeksi ilmiah.',
            'formula' => 'Subject + WILL / WOULD + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan \'will + V1\' untuk menyatakan hasil yang tak terhindarkan berdasarkan proyeksi data empiris yang kuat.',
              'Gunakan \'would + V1\' untuk menyatakan hasil potensial yang bergantung pada pemenuhan syarat atau skenario hipotetis.',
              'Dalam ringkasan temuan (Abstract), \'will\' sering dipakai untuk menjanjikan kontribusi artikel (\'This paper will demonstrate...\').',
              'Modal \'would\' juga dipakai untuk hedging yang lebih santun dan diplomatis dibanding \'will\'.',
            ],
            'exercises' => [
              [
                'id' => 41,
                'id_sentence' => 'Urbanisasi yang tidak terkendali akan memperparah krisis pasokan air bersih di kota-kota megapolitan.',
                'target_word' => 'will exacerbate',
                'vocab' => [
                  'uncontrolled urbanization' => [
                    'id' => 'urbanisasi yang tidak terkendali',
                    'pos' => '(n phr)',
                  ],
                  'will' => [
                    'id' => 'akan (kepastian prediktif)',
                    'pos' => '(modal)',
                  ],
                  'exacerbate' => [
                    'id' => 'memperparah / memperburuk',
                    'pos' => '(v)',
                  ],
                  'clean water supply crisis' => [
                    'id' => 'krisis pasokan air bersih',
                    'pos' => '(n phr)',
                  ],
                  'megacities' => [
                    'id' => 'kota-kota megapolitan',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'Uncontrolled urbanization will exacerbate the clean water supply crisis in megacities.',
                  'Uncontrolled urbanization will exacerbates the clean water supply crisis in megacities.',
                  'Uncontrolled urbanization will to exacerbate the clean water supply crisis in megacities.',
                  'Uncontrolled urbanization will exacerbating the clean water supply crisis in megacities.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal \'will\' diikuti bare verb (\'will exacerbate\') untuk menyampaikan kepastian proyeksi demografi.',
              ],
              [
                'id' => 42,
                'id_sentence' => 'Penerapan pajak karbon yang seragam akan mendorong industri manufaktur beralih ke energi bersih.',
                'target_word' => 'would encourage',
                'vocab' => [
                  'uniform carbon tax' => [
                    'id' => 'pajak karbon seragam',
                    'pos' => '(n phr)',
                  ],
                  'would' => [
                    'id' => 'akan (kondisional hipotetis)',
                    'pos' => '(modal)',
                  ],
                  'encourage' => [
                    'id' => 'mendorong',
                    'pos' => '(v)',
                  ],
                  'manufacturing industries' => [
                    'id' => 'industri manufaktur',
                    'pos' => '(n phr)',
                  ],
                  'transition to clean energy' => [
                    'id' => 'beralih ke energi bersih',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'The implementation of a uniform carbon tax would encourage manufacturing industries to transition to clean energy.',
                  'The implementation of a uniform carbon tax would encourages manufacturing industries to transition to clean energy.',
                  'The implementation of a uniform carbon tax would to encourage manufacturing industries to transition to clean energy.',
                  'The implementation of a uniform carbon tax would encouraging manufacturing industries to transition to clean energy.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Would encourage\' menyatakan proyeksi hipotetis dari simulasi kebijakan fiskal.',
              ],
              [
                'id' => 43,
                'id_sentence' => 'Artikel ini akan menyajikan analisis komparatif atas efisiensi algoritma komputasi kuantum.',
                'target_word' => 'will present',
                'vocab' => [
                  'this article' => [
                    'id' => 'artikel ini',
                    'pos' => '(n phr)',
                  ],
                  'present' => [
                    'id' => 'menyajikan / memaparkan',
                    'pos' => '(v)',
                  ],
                  'comparative analysis' => [
                    'id' => 'analisis komparatif',
                    'pos' => '(n phr)',
                  ],
                  'quantum computing algorithms' => [
                    'id' => 'algoritma komputasi kuantum',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This article will present a comparative analysis of quantum computing algorithm efficiencies.',
                  'This article will presents a comparative analysis of quantum computing algorithm efficiencies.',
                  'This article will to present a comparative analysis of quantum computing algorithm efficiencies.',
                  'This article will presenting a comparative analysis of quantum computing algorithm efficiencies.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa pengantar abstrak resmi: \'This article will present...\' menggunakan modal \'will\'.',
              ],
              [
                'id' => 44,
                'id_sentence' => 'Kenaikan suku bunga lebih lanjut akan menurunkan minat belanja konsumen dalam jangka pendek.',
                'target_word' => 'would dampen',
                'vocab' => [
                  'further interest rate hikes' => [
                    'id' => 'kenaikan suku bunga lebih lanjut',
                    'pos' => '(n phr)',
                  ],
                  'dampen' => [
                    'id' => 'menurunkan / meredam',
                    'pos' => '(v)',
                  ],
                  'consumer spending appetite' => [
                    'id' => 'minat belanja konsumen',
                    'pos' => '(n phr)',
                  ],
                  'short term' => [
                    'id' => 'jangka pendek',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Further interest rate hikes would dampen consumer spending appetite in the short term.',
                  'Further interest rate hikes would dampens consumer spending appetite in the short term.',
                  'Further interest rate hikes would to dampen consumer spending appetite in the short term.',
                  'Further interest rate hikes would dampening consumer spending appetite in the short term.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Would dampen\' mengekspresikan efek prediktif kondisional makroekonomi.',
              ],
              [
                'id' => 45,
                'id_sentence' => 'Pengadopsian rekam medis elektronik terpadu akan merampingkan alur kerja klinis di rumah sakit.',
                'target_word' => 'will streamline',
                'vocab' => [
                  'adoption' => [
                    'id' => 'pengadopsian',
                    'pos' => '(n)',
                  ],
                  'integrated electronic health records' => [
                    'id' => 'rekam medis elektronik terpadu',
                    'pos' => '(n phr)',
                  ],
                  'streamline' => [
                    'id' => 'merampingkan',
                    'pos' => '(v)',
                  ],
                  'clinical workflows' => [
                    'id' => 'alur kerja klinis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The adoption of integrated electronic health records will streamline clinical workflows in hospitals.',
                  'The adoption of integrated electronic health records will streamlines clinical workflows in hospitals.',
                  'The adoption of integrated electronic health records will to streamline clinical workflows in hospitals.',
                  'The adoption of integrated electronic health records will streamlining clinical workflows in hospitals.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Will streamline\' menegaskan kepastian keuntungan operasional sistem baru.',
              ],
              [
                'id' => 46,
                'id_sentence' => 'Kegagalan memperbaiki bendungan tua tersebut akan menimbulkan bencana hidrologis berskala luas.',
                'target_word' => 'would precipitate',
                'vocab' => [
                  'failure to rehabilitate' => [
                    'id' => 'kegagalan memperbaiki',
                    'pos' => '(n phr)',
                  ],
                  'aging dam' => [
                    'id' => 'bendungan tua',
                    'pos' => '(n phr)',
                  ],
                  'precipitate' => [
                    'id' => 'menimbulkan / memicu',
                    'pos' => '(v)',
                  ],
                  'large-scale hydrological disaster' => [
                    'id' => 'bencana hidrologis berskala luas',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Failure to rehabilitate the aging dam would precipitate a large-scale hydrological disaster.',
                  'Failure to rehabilitate the aging dam would precipitates a large-scale hydrological disaster.',
                  'Failure to rehabilitate the aging dam would to precipitate a large-scale hydrological disaster.',
                  'Failure to rehabilitate the aging dam would precipitating a large-scale hydrological disaster.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Would precipitate\' menyatakan konsekuensi hipotetis dari skenario kelalaian infrastruktur.',
              ],
              [
                'id' => 47,
                'id_sentence' => 'Kenaikan permukaan air laut rata-rata global akan menenggelamkan ribuan hektar lahan basah pesisir.',
                'target_word' => 'will inundate',
                'vocab' => [
                  'global mean sea-level rise' => [
                    'id' => 'kenaikan permukaan air laut rata-rata global',
                    'pos' => '(n phr)',
                  ],
                  'inundate' => [
                    'id' => 'menenggelamkan / membanjiri',
                    'pos' => '(v)',
                  ],
                  'coastal wetlands' => [
                    'id' => 'lahan basah pesisir',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Global mean sea-level rise will inundate thousands of hectares of coastal wetlands.',
                  'Global mean sea-level rise will inundates thousands of hectares of coastal wetlands.',
                  'Global mean sea-level rise will to inundate thousands of hectares of coastal wetlands.',
                  'Global mean sea-level rise will inundating thousands of hectares of coastal wetlands.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Will inundate\' menyatakan kepastian proyeksi biogeografis.',
              ],
              [
                'id' => 48,
                'id_sentence' => 'Penelitian tambahan akan membantu memperjelas mekanisme molekuler yang mendasari resistensi obat.',
                'target_word' => 'would help elucidate',
                'vocab' => [
                  'additional research' => [
                    'id' => 'penelitian tambahan',
                    'pos' => '(n phr)',
                  ],
                  'help' => [
                    'id' => 'membantu',
                    'pos' => '(v)',
                  ],
                  'elucidate' => [
                    'id' => 'memperjelas / menguraikan',
                    'pos' => '(v)',
                  ],
                  'underlying molecular mechanisms' => [
                    'id' => 'mekanisme molekuler yang mendasari',
                    'pos' => '(n phr)',
                  ],
                  'drug resistance' => [
                    'id' => 'resistensi obat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Additional research would help elucidate the molecular mechanisms underlying drug resistance.',
                  'Additional research would helps elucidate the molecular mechanisms underlying drug resistance.',
                  'Additional research would to help elucidate the molecular mechanisms underlying drug resistance.',
                  'Additional research would helping elucidate the molecular mechanisms underlying drug resistance.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Would help elucidate\' adalah frasa penutup rekomendasi riset lanjutan yang sangat umum.',
              ],
              [
                'id' => 49,
                'id_sentence' => 'Krisis energi berkepanjangan akan memaksa utilitas listrik mencari alternatif bahan bakar fosil.',
                'target_word' => 'will force',
                'vocab' => [
                  'prolonged energy crisis' => [
                    'id' => 'krisis energi berkepanjangan',
                    'pos' => '(n phr)',
                  ],
                  'force' => [
                    'id' => 'memaksa',
                    'pos' => '(v)',
                  ],
                  'power utilities' => [
                    'id' => 'utilitas listrik',
                    'pos' => '(n phr)',
                  ],
                  'seek alternatives' => [
                    'id' => 'mencari alternatif',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'A prolonged energy crisis will force power utilities to seek alternatives to fossil fuels.',
                  'A prolonged energy crisis will forces power utilities to seek alternatives to fossil fuels.',
                  'A prolonged energy crisis will to force power utilities to seek alternatives to fossil fuels.',
                  'A prolonged energy crisis will forcing power utilities to seek alternatives to fossil fuels.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Will force\' memadukan proyeksi kepastian masa depan dengan pola transitif infinitif.',
              ],
              [
                'id' => 50,
                'id_sentence' => 'Pemberian subsidi pendidikan tinggi akan memperluas akses bagi mahasiswa berpenghasilan rendah.',
                'target_word' => 'would broaden',
                'vocab' => [
                  'provision of higher education subsidies' => [
                    'id' => 'pemberian subsidi pendidikan tinggi',
                    'pos' => '(n phr)',
                  ],
                  'broaden' => [
                    'id' => 'memperluas',
                    'pos' => '(v)',
                  ],
                  'access' => [
                    'id' => 'akses',
                    'pos' => '(n)',
                  ],
                  'low-income students' => [
                    'id' => 'mahasiswa berpenghasilan rendah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The provision of higher education subsidies would broaden access for low-income students.',
                  'The provision of higher education subsidies would broadens access for low-income students.',
                  'The provision of higher education subsidies would to broaden access for low-income students.',
                  'The provision of higher education subsidies would broadening access for low-income students.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Would broaden\' menyampaikan ekspektasi kebijakan sosial secara akademis.',
              ],
            ],
          ],
          [
            'id' => 'passive_modal_constructions',
            'name' => 'Bentuk Pasif Modal: can be done, must be checked (Modal + Be + V3)',
            'code' => '1.7.6',
            'concept_title' => 'Bentuk Pasif Modal: can be done, must be checked (Modal + Be + V3)',
            'concept_description' => 'Dalam metodologi dan laporan eksperimen, kombinasi Modal + Passive Voice (\'modal + be + V3\') merupakan salah satu struktur paling dominan dalam bahasa ilmiah. Pola ini memfokuskan kalimat pada objek atau temuan penelitian secara impersonal dan elegan (misal: \'can be observed\', \'must be interpreted\', \'should be noted\', \'may be attributed to\').',
            'formula' => 'Subject (Findings / Samples / Factors) + MODAL (can / may / must / should) + BE + Verb 3 (Past Participle)',
            'rules' => [
              'Rumus modal pasif: Modal + BE (bentuk dasar) + Verb 3 (Past Participle).',
              'Dilarang mengonjugasi \'be\' menjadi is/am/are setelah modal (misal: \'can is explained\' ➔ SALAH; \'can be explained\' ➔ BENAR).',
              'Frasa idiomatik pelaporan akademis: \'It should be noted that...\', \'Findings can be categorized as...\', \'Discrepancies may be attributed to...\'.',
              'Bentuk negatif modal pasif menyisipkan \'not\' tepat setelah modal: \'cannot be replicated\', \'should not be assumed\'.',
            ],
            'exercises' => [
              [
                'id' => 51,
                'id_sentence' => 'Peningkatan emisi gas rumah kaca dapat dikaitkan dengan ekspansi industri yang pesat.',
                'target_word' => 'can be attributed to',
                'vocab' => [
                  'increased greenhouse gas emissions' => [
                    'id' => 'peningkatan emisi gas rumah kaca',
                    'pos' => '(n phr)',
                  ],
                  'can be attributed to' => [
                    'id' => 'dapat dikaitkan dengan / disebabkan oleh',
                    'pos' => '(passive modal phr)',
                  ],
                  'rapid industrial expansion' => [
                    'id' => 'ekspansi industri yang pesat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Increased greenhouse gas emissions can be attributed to rapid industrial expansion.',
                  'Increased greenhouse gas emissions can attributed to rapid industrial expansion.',
                  'Increased greenhouse gas emissions can is attributed to rapid industrial expansion.',
                  'Increased greenhouse gas emissions can being attributed to rapid industrial expansion.',
                ],
                'correct_index' => 0,
                'explanation' => 'Konstruksi modal pasif wajib menggunakan \'can + be + V3\' (\'can be attributed to\').',
              ],
              [
                'id' => 52,
                'id_sentence' => 'Perlu dicatat bahwa data survei dikumpulkan selama puncak pembatasan pandemi.',
                'target_word' => 'It should be noted that',
                'vocab' => [
                  'it should be noted that' => [
                    'id' => 'perlu dicatat bahwa',
                    'pos' => '(passive modal phr)',
                  ],
                  'survey data' => [
                    'id' => 'data survei',
                    'pos' => '(n phr)',
                  ],
                  'collected' => [
                    'id' => 'dikumpulkan',
                    'pos' => '(v3)',
                  ],
                  'peak pandemic restrictions' => [
                    'id' => 'puncak pembatasan pandemi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'It should be noted that survey data was collected during the peak of pandemic restrictions.',
                  'It should noted that survey data was collected during the peak of pandemic restrictions.',
                  'It should to be noted that survey data was collected during the peak of pandemic restrictions.',
                  'It should being noted that survey data was collected during the peak of pandemic restrictions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'It should be noted that\' adalah frasa pasif modal akademik standar untuk menarik atensi pembaca.',
              ],
              [
                'id' => 53,
                'id_sentence' => 'Hasil uji klinis tahap awal harus direplikasi oleh institusi independen sebelum disetujui.',
                'target_word' => 'must be replicated',
                'vocab' => [
                  'early clinical trial results' => [
                    'id' => 'hasil uji klinis tahap awal',
                    'pos' => '(n phr)',
                  ],
                  'must be replicated' => [
                    'id' => 'harus direplikasi',
                    'pos' => '(passive modal phr)',
                  ],
                  'independent institutions' => [
                    'id' => 'institusi independen',
                    'pos' => '(n phr)',
                  ],
                  'approved' => [
                    'id' => 'disetujui',
                    'pos' => '(v3)',
                  ],
                ],
                'options' => [
                  'Early clinical trial results must be replicated by independent institutions prior to regulatory approval.',
                  'Early clinical trial results must replicated by independent institutions prior to regulatory approval.',
                  'Early clinical trial results must to be replicated by independent institutions prior to regulatory approval.',
                  'Early clinical trial results must being replicated by independent institutions prior to regulatory approval.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must be replicated\' (must + be + V3) menegaskan kewajiban saintifik verifikasi data.',
              ],
              [
                'id' => 54,
                'id_sentence' => 'Fenomena fluoresensi mikroskopis dapat diamati di bawah eksitasi sinar laser ultraviolet.',
                'target_word' => 'can be observed',
                'vocab' => [
                  'microscopic fluorescence phenomenon' => [
                    'id' => 'fenomena fluoresensi mikroskopis',
                    'pos' => '(n phr)',
                  ],
                  'can be observed' => [
                    'id' => 'dapat diamati',
                    'pos' => '(passive modal phr)',
                  ],
                  'ultraviolet laser excitation' => [
                    'id' => 'eksitasi sinar laser ultraviolet',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The microscopic fluorescence phenomenon can be observed under ultraviolet laser excitation.',
                  'The microscopic fluorescence phenomenon can observed under ultraviolet laser excitation.',
                  'The microscopic fluorescence phenomenon can is observed under ultraviolet laser excitation.',
                  'The microscopic fluorescence phenomenon can being observed under ultraviolet laser excitation.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can be observed\' (can + be + V3) mendeskripsikan fenomena observasi ilmiah pasif.',
              ],
              [
                'id' => 55,
                'id_sentence' => 'Anomali statistik tersebut mungkin dijelaskan oleh variasi musiman dalam perilaku konsumen.',
                'target_word' => 'may be explained by',
                'vocab' => [
                  'statistical anomalies' => [
                    'id' => 'anomali statistik',
                    'pos' => '(n phr)',
                  ],
                  'may be explained by' => [
                    'id' => 'mungkin dijelaskan oleh',
                    'pos' => '(passive modal phr)',
                  ],
                  'seasonal variations' => [
                    'id' => 'variasi musiman',
                    'pos' => '(n phr)',
                  ],
                  'consumer behavior' => [
                    'id' => 'perilaku konsumen',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'These statistical anomalies may be explained by seasonal variations in consumer behavior.',
                  'These statistical anomalies may explained by seasonal variations in consumer behavior.',
                  'These statistical anomalies may are explained by seasonal variations in consumer behavior.',
                  'These statistical anomalies may being explained by seasonal variations in consumer behavior.',
                ],
                'correct_index' => 0,
                'explanation' => '\'May be explained by\' memadukan hedging probabilitas dengan konstruksi kalimat pasif.',
              ],
              [
                'id' => 56,
                'id_sentence' => 'Pengaruh variabel perancu tidak boleh diabaikan dalam menganalisis korelasi epidemiologis.',
                'target_word' => 'should not be overlooked',
                'vocab' => [
                  'influence of confounding variables' => [
                    'id' => 'pengaruh variabel perancu',
                    'pos' => '(n phr)',
                  ],
                  'should not be overlooked' => [
                    'id' => 'tidak boleh / jangan diabaikan',
                    'pos' => '(passive modal phr)',
                  ],
                  'epidemiological correlations' => [
                    'id' => 'korelasi epidemiologis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The influence of confounding variables should not be overlooked when analyzing epidemiological correlations.',
                  'The influence of confounding variables should not overlooked when analyzing epidemiological correlations.',
                  'The influence of confounding variables should not to be overlooked when analyzing epidemiological correlations.',
                  'The influence of confounding variables should not being overlooked when analyzing epidemiological correlations.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk negatif modal pasif adalah \'should not be + V3\' (\'should not be overlooked\').',
              ],
              [
                'id' => 57,
                'id_sentence' => 'Parameter uji coba laboratorium harus distandarisasi untuk menjamin konsistensi pengukuran.',
                'target_word' => 'must be standardized',
                'vocab' => [
                  'laboratory testing parameters' => [
                    'id' => 'parameter uji coba laboratorium',
                    'pos' => '(n phr)',
                  ],
                  'must be standardized' => [
                    'id' => 'harus distandarisasi',
                    'pos' => '(passive modal phr)',
                  ],
                  'guarantee measurement consistency' => [
                    'id' => 'menjamin konsistensi pengukuran',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Laboratory testing parameters must be standardized to guarantee measurement consistency.',
                  'Laboratory testing parameters must standardized to guarantee measurement consistency.',
                  'Laboratory testing parameters must to be standardized to guarantee measurement consistency.',
                  'Laboratory testing parameters must being standardized to guarantee measurement consistency.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must be standardized\' (must + be + V3) menyatakan keharusan standardisasi metodologi.',
              ],
              [
                'id' => 58,
                'id_sentence' => 'Temuan empiris ini tidak dapat digeneralisasikan pada seluruh populasi pedesaan.',
                'target_word' => 'cannot be generalized to',
                'vocab' => [
                  'empirical findings' => [
                    'id' => 'temuan empiris',
                    'pos' => '(n phr)',
                  ],
                  'cannot be generalized to' => [
                    'id' => 'tidak dapat digeneralisasikan pada',
                    'pos' => '(passive modal phr)',
                  ],
                  'entire rural population' => [
                    'id' => 'seluruh populasi pedesaan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'These empirical findings cannot be generalized to the entire rural population.',
                  'These empirical findings cannot generalized to the entire rural population.',
                  'These empirical findings cannot are generalized to the entire rural population.',
                  'These empirical findings can not to be generalized to the entire rural population.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Cannot be generalized to\' adalah batasan studi (*study limitation*) yang sangat sering muncul di jurnal.',
              ],
              [
                'id' => 59,
                'id_sentence' => 'Spesimen jaringan biologis dapat diawetkan pada suhu nitrogen cair selama beberapa dekade.',
                'target_word' => 'can be preserved',
                'vocab' => [
                  'biological tissue specimens' => [
                    'id' => 'spesimen jaringan biologis',
                    'pos' => '(n phr)',
                  ],
                  'can be preserved' => [
                    'id' => 'dapat diawetkan',
                    'pos' => '(passive modal phr)',
                  ],
                  'liquid nitrogen temperatures' => [
                    'id' => 'suhu nitrogen cair',
                    'pos' => '(n phr)',
                  ],
                  'several decades' => [
                    'id' => 'beberapa dekade',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Biological tissue specimens can be preserved at liquid nitrogen temperatures for several decades.',
                  'Biological tissue specimens can preserved at liquid nitrogen temperatures for several decades.',
                  'Biological tissue specimens can are preserved at liquid nitrogen temperatures for several decades.',
                  'Biological tissue specimens can being preserved at liquid nitrogen temperatures for several decades.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can be preserved\' mengekspresikan kapasitas pengawetan materi biologis.',
              ],
              [
                'id' => 60,
                'id_sentence' => 'Intervensi kebijakan moneter bisa dianggap berhasil jika stabilitas harga tercapai.',
                'target_word' => 'could be deemed',
                'vocab' => [
                  'monetary policy intervention' => [
                    'id' => 'intervensi kebijakan moneter',
                    'pos' => '(n phr)',
                  ],
                  'could be deemed' => [
                    'id' => 'bisa dianggap / dinilai',
                    'pos' => '(passive modal phr)',
                  ],
                  'successful' => [
                    'id' => 'berhasil',
                    'pos' => '(adj)',
                  ],
                  'price stability' => [
                    'id' => 'stabilitas harga',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The monetary policy intervention could be deemed successful if price stability is attained.',
                  'The monetary policy intervention could deemed successful if price stability is attained.',
                  'The monetary policy intervention could is deemed successful if price stability is attained.',
                  'The monetary policy intervention could being deemed successful if price stability is attained.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Could be deemed\' adalah konstruksi modal pasif bersyarat (*conditional passive modal*).',
              ],
            ],
          ],
          [
            'id' => 'perfect_modals_past',
            'name' => 'Dugaan & Evaluasi Masa Lalu (Modal + Have + V3)',
            'code' => '1.7.7',
            'concept_title' => 'Dugaan & Evaluasi Masa Lalu: may have been, should have done (Modal + Have + V3)',
            'concept_description' => 'Dalam menganalisis anomali eksperimen yang telah terjadi atau mengevaluasi kegagalan metodologi sebelumnya, bahasa akademik mengandalkan bentuk Perfect Modal:
- \'may / might have + V3\': dugaan penyebab di masa lalu (misal: \'contamination may have occurred\').
- \'must have + V3\': deduksi logis masa lalu dengan kepastian tinggi (misal: \'the sensor must have failed\').
- \'should have + V3\': evaluasi metodologis yang seharusnya dilakukan tetapi terlewatkan (misal: \'researchers should have controlled for age\').',
            'formula' => 'Subject + MAY / MIGHT / MUST / SHOULD + HAVE + Verb 3 (Past Participle)',
            'rules' => [
              'Rumus: Modal + HAVE (selalu bentuk dasar \'have\', dilarang menggunakan \'has\' atau \'had\') + Verb 3.',
              'Gunakan \'might/may have been caused by\' untuk mengajukan hipotesis penyebab anomali data di masa lampau.',
              'Gunakan \'should have + V3\' saat mendiskusikan kelemahan metodologis yang semestinya diantisipasi.',
              'Gunakan \'could not have + V3\' untuk menyatakan kemustahilan suatu peristiwa di masa lalu.',
            ],
            'exercises' => [
              [
                'id' => 61,
                'id_sentence' => 'Anomali data tersebut mungkin disebabkan oleh fluktuasi voltase yang tidak terdeteksi selama pengujian semalam.',
                'target_word' => 'may have been caused by',
                'vocab' => [
                  'data anomaly' => [
                    'id' => 'anomali data',
                    'pos' => '(n phr)',
                  ],
                  'may have been caused by' => [
                    'id' => 'mungkin disebabkan oleh (masa lalu)',
                    'pos' => '(perfect modal phr)',
                  ],
                  'undetected voltage fluctuations' => [
                    'id' => 'fluktuasi voltase yang tidak terdeteksi',
                    'pos' => '(n phr)',
                  ],
                  'overnight testing' => [
                    'id' => 'pengujian semalam',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The data anomaly may have been caused by undetected voltage fluctuations during overnight testing.',
                  'The data anomaly may has been caused by undetected voltage fluctuations during overnight testing.',
                  'The data anomaly may have being caused by undetected voltage fluctuations during overnight testing.',
                  'The data anomaly may had been caused by undetected voltage fluctuations during overnight testing.',
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah modal \'may\', auxiliary wajib menggunakan bentuk dasar \'have\' (\'may have been caused by\'). Dilarang menggunakan \'has\' atau \'had\'.',
              ],
              [
                'id' => 62,
                'id_sentence' => 'Para peneliti seharusnya mengontrol faktor usia subjek sebelum menarik kesimpulan klinis.',
                'target_word' => 'should have controlled for',
                'vocab' => [
                  'researchers' => [
                    'id' => 'para peneliti',
                    'pos' => '(n)',
                  ],
                  'should have controlled for' => [
                    'id' => 'seharusnya mengontrol (evaluasi lampau)',
                    'pos' => '(perfect modal phr)',
                  ],
                  'subject age factors' => [
                    'id' => 'faktor usia subjek',
                    'pos' => '(n phr)',
                  ],
                  'clinical conclusions' => [
                    'id' => 'kesimpulan klinis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers should have controlled for subject age factors prior to drawing clinical conclusions.',
                  'Researchers should has controlled for subject age factors prior to drawing clinical conclusions.',
                  'Researchers should have control for subject age factors prior to drawing clinical conclusions.',
                  'Researchers should had controlled for subject age factors prior to drawing clinical conclusions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should have controlled for\' mengevaluasi prosedur yang seharusnya dilakukan di masa lampau.',
              ],
              [
                'id' => 63,
                'id_sentence' => 'Sensor tekanan pasti mengalami kerusakan mekanis sebelum tangki penyimpanan meledak.',
                'target_word' => 'must have failed',
                'vocab' => [
                  'pressure sensor' => [
                    'id' => 'sensor tekanan',
                    'pos' => '(n phr)',
                  ],
                  'must have failed' => [
                    'id' => 'pasti telah mengalami kerusakan',
                    'pos' => '(perfect modal phr)',
                  ],
                  'storage tank explosion' => [
                    'id' => 'ledakan tangki penyimpanan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The pressure sensor must have failed mechanically before the storage tank ruptured.',
                  'The pressure sensor must has failed mechanically before the storage tank ruptured.',
                  'The pressure sensor must have fail mechanically before the storage tank ruptured.',
                  'The pressure sensor must had failed mechanically before the storage tank ruptured.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must have failed\' adalah deduksi logis pasti mengenai peristiwa di masa lampau.',
              ],
              [
                'id' => 64,
                'id_sentence' => 'Kultur bakteri tersebut tidak mungkin terkontaminasi di dalam ruang bersih laminar bertekanan positif.',
                'target_word' => 'could not have been contaminated',
                'vocab' => [
                  'bacterial culture' => [
                    'id' => 'kultur bakteri',
                    'pos' => '(n phr)',
                  ],
                  'could not have been contaminated' => [
                    'id' => 'mustahil / tidak mungkin terkontaminasi (lampau)',
                    'pos' => '(perfect modal phr)',
                  ],
                  'positive-pressure laminar cleanroom' => [
                    'id' => 'ruang bersih laminar bertekanan positif',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The bacterial culture could not have been contaminated inside the positive-pressure laminar cleanroom.',
                  'The bacterial culture could not has been contaminated inside the positive-pressure laminar cleanroom.',
                  'The bacterial culture could not had been contaminated inside the positive-pressure laminar cleanroom.',
                  'The bacterial culture could not have being contaminated inside the positive-pressure laminar cleanroom.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Could not have been contaminated\' menyatakan kemustahilan peristiwa masa lalu.',
              ],
              [
                'id' => 65,
                'id_sentence' => 'Penulis artikel sebelumnya mungkin salah menafsirkan koefisien regresi statistik tersebut.',
                'target_word' => 'might have misinterpreted',
                'vocab' => [
                  'previous authors' => [
                    'id' => 'penulis artikel sebelumnya',
                    'pos' => '(n phr)',
                  ],
                  'might have misinterpreted' => [
                    'id' => 'mungkin telah salah menafsirkan',
                    'pos' => '(perfect modal phr)',
                  ],
                  'statistical regression coefficient' => [
                    'id' => 'koefisien regresi statistik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Previous authors might have misinterpreted the statistical regression coefficient in their report.',
                  'Previous authors might has misinterpreted the statistical regression coefficient in their report.',
                  'Previous authors might have misinterpret the statistical regression coefficient in their report.',
                  'Previous authors might had misinterpreted the statistical regression coefficient in their report.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Might have misinterpreted\' mengajukan kemungkinan kekeliruan masa lampau secara halus.',
              ],
              [
                'id' => 66,
                'id_sentence' => 'Pemerintah seharusnya memberlakukan karantina wilayah lebih awal untuk memperlambat penyebaran patogen.',
                'target_word' => 'should have imposed',
                'vocab' => [
                  'government' => [
                    'id' => 'pemerintah',
                    'pos' => '(n)',
                  ],
                  'should have imposed' => [
                    'id' => 'seharusnya memberlakukan',
                    'pos' => '(perfect modal phr)',
                  ],
                  'regional lockdown' => [
                    'id' => 'karantina wilayah',
                    'pos' => '(n phr)',
                  ],
                  'slow pathogen transmission' => [
                    'id' => 'memperlambat penyebaran patogen',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'The government should have imposed the regional lockdown earlier to decelerate pathogen transmission.',
                  'The government should has imposed the regional lockdown earlier to decelerate pathogen transmission.',
                  'The government should have impose the regional lockdown earlier to decelerate pathogen transmission.',
                  'The government should had imposed the regional lockdown earlier to decelerate pathogen transmission.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should have imposed\' menyatakan penyesalan kebijakan atau evaluasi retrospektif.',
              ],
              [
                'id' => 67,
                'id_sentence' => 'Penurunan tajam populasi ikan tersebut pasti dipicu oleh penurunan kadar oksigen terlarut.',
                'target_word' => 'must have been triggered by',
                'vocab' => [
                  'sharp decline in fish populations' => [
                    'id' => 'penurunan tajam populasi ikan',
                    'pos' => '(n phr)',
                  ],
                  'must have been triggered by' => [
                    'id' => 'pasti dipicu oleh (lampau)',
                    'pos' => '(perfect modal phr)',
                  ],
                  'depletion of dissolved oxygen' => [
                    'id' => 'penurunan kadar oksigen terlarut',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The sharp decline in fish populations must have been triggered by the depletion of dissolved oxygen.',
                  'The sharp decline in fish populations must has been triggered by the depletion of dissolved oxygen.',
                  'The sharp decline in fish populations must had been triggered by the depletion of dissolved oxygen.',
                  'The sharp decline in fish populations must have being triggered by the depletion of dissolved oxygen.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must have been triggered by\' adalah deduksi kausal retrospektif dalam ekologi air.',
              ],
              [
                'id' => 68,
                'id_sentence' => 'Sampel batuan meteorit mungkin telah mengalami pelapukan termal selama masuknya ke atmosfer bumi.',
                'target_word' => 'may have undergone',
                'vocab' => [
                  'meteorite specimen' => [
                    'id' => 'sampel batuan meteorit',
                    'pos' => '(n phr)',
                  ],
                  'may have undergone' => [
                    'id' => 'mungkin telah mengalami',
                    'pos' => '(perfect modal phr)',
                  ],
                  'thermal weathering' => [
                    'id' => 'pelapukan termal',
                    'pos' => '(n phr)',
                  ],
                  'atmospheric entry' => [
                    'id' => 'masuknya ke atmosfer',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The meteorite specimen may have undergone thermal weathering during atmospheric entry.',
                  'The meteorite specimen may has undergone thermal weathering during atmospheric entry.',
                  'The meteorite specimen may have undergo thermal weathering during atmospheric entry.',
                  'The meteorite specimen may had undergone thermal weathering during atmospheric entry.',
                ],
                'correct_index' => 0,
                'explanation' => '\'May have undergone\' (may + have + V3) untuk hipotesis geokimia masa lalu.',
              ],
              [
                'id' => 69,
                'id_sentence' => 'Tim teknisi seharusnya menguji redundansi sistem cadangan daya sebelum pemadaman listrik terencana.',
                'target_word' => 'should have verified',
                'vocab' => [
                  'engineering team' => [
                    'id' => 'tim teknisi',
                    'pos' => '(n phr)',
                  ],
                  'should have verified' => [
                    'id' => 'seharusnya memverifikasi / menguji',
                    'pos' => '(perfect modal phr)',
                  ],
                  'backup power system redundancy' => [
                    'id' => 'redundansi sistem cadangan daya',
                    'pos' => '(n phr)',
                  ],
                  'scheduled outage' => [
                    'id' => 'pemadaman listrik terencana',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The engineering team should have verified backup power system redundancy prior to the scheduled outage.',
                  'The engineering team should has verified backup power system redundancy prior to the scheduled outage.',
                  'The engineering team should have verify backup power system redundancy prior to the scheduled outage.',
                  'The engineering team should had verified backup power system redundancy prior to the scheduled outage.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should have verified\' menggarisbawahi kegagalan prosedural yang seharusnya dilakukan.',
              ],
              [
                'id' => 70,
                'id_sentence' => 'Spesies endemik tersebut tidak mungkin punah semata-mata karena perburuan liar.',
                'target_word' => 'could not have vanished',
                'vocab' => [
                  'endemic species' => [
                    'id' => 'spesies endemik',
                    'pos' => '(n phr)',
                  ],
                  'could not have vanished' => [
                    'id' => 'tidak mungkin punah / lenyap (lampau)',
                    'pos' => '(perfect modal phr)',
                  ],
                  'solely due to poaching' => [
                    'id' => 'semata-mata karena perburuan liar',
                    'pos' => '(prep phr)',
                  ],
                ],
                'options' => [
                  'The endemic species could not have vanished solely due to illegal poaching.',
                  'The endemic species could not has vanished solely due to illegal poaching.',
                  'The endemic species could not had vanished solely due to illegal poaching.',
                  'The endemic species could not have vanish solely due to illegal poaching.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Could not have vanished\' menyangkal kepunahan masa lalu disebabkan oleh faktor tunggal.',
              ],
            ],
          ],
          [
            'id' => 'synthesis_hedging_calibration',
            'name' => 'Latihan Campuran & Penerapan Modal Auxiliaries',
            'code' => '1.7.8',
            'concept_title' => 'Latihan Campuran & Penerapan Modal Auxiliaries',
            'concept_description' => 'Sub-lesson ini menggabungkan seluruh penggunaan modal auxiliaries (kemungkinan, kemampuan, saran, kepastian logis, bentuk pasif, dan dugaan masa lalu) ke dalam berbagai konteks kalimat penulisan agar pemahaman menjadi mantap dan menyeluruh.',
            'formula' => 'Synthesized Clause: Evidence [Subject] + appears to / tends to + MODAL + [Hedging Adverb] + Verb (Base Form)',
            'rules' => [
              'Pahami Hirarki Derajat Kepastian (Certainty Spectrum): Must/Will (Tinggi) ➔ Should/Ought to (Normatif) ➔ May/Can (Moderat) ➔ Might/Could (Tentatif/Rendah).',
              'Kombinasikan modal dengan adverbia probabilitas secara elegan (misal: \'may potentially accelerate\', \'could conceivably reduce\').',
              'Hindari redundansi bertumpuk yang berlebihan (\'may probably perhaps\' ➔ SALAH).',
              'Gunakan verba \'appear to\' atau \'suggest that\' berpasangan dengan modal untuk menghasilkan register jurnal bereputasi tinggi.',
            ],
            'exercises' => [
              [
                'id' => 71,
                'id_sentence' => 'Data statistik ini tampaknya menunjukkan bahwa terapi baru tersebut mungkin berpotensi menurunkan resistensi insulin.',
                'target_word' => 'appears to indicate that may potentially reduce',
                'vocab' => [
                  'statistical data' => [
                    'id' => 'data statistik',
                    'pos' => '(n phr)',
                  ],
                  'appears to indicate' => [
                    'id' => 'tampaknya menunjukkan',
                    'pos' => '(v phr)',
                  ],
                  'novel therapy' => [
                    'id' => 'terapi baru',
                    'pos' => '(n phr)',
                  ],
                  'may potentially reduce' => [
                    'id' => 'mungkin berpotensi menurunkan',
                    'pos' => '(modal + adv + v)',
                  ],
                  'insulin resistance' => [
                    'id' => 'resistensi insulin',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This statistical data appears to indicate that the novel therapy may potentially reduce insulin resistance.',
                  'This statistical data appears to indicate that the novel therapy may potentially reduces insulin resistance.',
                  'This statistical data appears indicate that the novel therapy may potentially reduce insulin resistance.',
                  'This statistical data appears to indicating that the novel therapy can potentially reduce insulin resistance.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Appears to indicate that... may potentially reduce\' adalah kombinasi multi-level hedging tingkat lanjut yang sangat disukai dalam penulisan jurnal internasional.',
              ],
              [
                'id' => 72,
                'id_sentence' => 'Perubahan iklim mikro bisa dibayangkan dapat mempercepat laju kepunahan amfibi di hutan dataran tinggi.',
                'target_word' => 'could conceivably accelerate',
                'vocab' => [
                  'microclimatic shifts' => [
                    'id' => 'perubahan iklim mikro',
                    'pos' => '(n phr)',
                  ],
                  'could conceivably' => [
                    'id' => 'bisa dibayangkan / secara masuk akal dapat',
                    'pos' => '(modal + adv)',
                  ],
                  'accelerate' => [
                    'id' => 'mempercepat',
                    'pos' => '(v)',
                  ],
                  'amphibian extinction rates' => [
                    'id' => 'laju kepunahan amfibi',
                    'pos' => '(n phr)',
                  ],
                  'highland forests' => [
                    'id' => 'hutan dataran tinggi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Microclimatic shifts could conceivably accelerate amphibian extinction rates in highland forests.',
                  'Microclimatic shifts could conceivably accelerates amphibian extinction rates in highland forests.',
                  'Microclimatic shifts could conceivably to accelerate amphibian extinction rates in highland forests.',
                  'Microclimatic shifts could conceivably accelerating amphibian extinction rates in highland forests.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Could conceivably accelerate\' memadukan modal tentatif \'could\' dengan adverbia penalaran \'conceivably\'.',
              ],
              [
                'id' => 73,
                'id_sentence' => 'Penulis menyarankan bahwa perbedaan metodologis mungkin dapat menjelaskan sebagian dari diskrepansi temuan.',
                'target_word' => 'suggests that might partly explain',
                'vocab' => [
                  'author' => [
                    'id' => 'penulis',
                    'pos' => '(n)',
                  ],
                  'suggests that' => [
                    'id' => 'menyarankan bahwa / berpendapat bahwa',
                    'pos' => '(v phr)',
                  ],
                  'methodological disparities' => [
                    'id' => 'perbedaan metodologis',
                    'pos' => '(n phr)',
                  ],
                  'might partly explain' => [
                    'id' => 'mungkin dapat menjelaskan sebagian',
                    'pos' => '(modal + adv + v)',
                  ],
                  'discrepancies' => [
                    'id' => 'diskrepansi / ketidaksesuaian',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The author suggests that methodological disparities might partly explain the discrepancy in findings.',
                  'The author suggests that methodological disparities might partly explains the discrepancy in findings.',
                  'The author suggests that methodological disparities might to partly explain the discrepancy in findings.',
                  'The author suggests that methodological disparities might partly explaining the discrepancy in findings.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Suggests that... might partly explain\' menyusun argumen akademis yang seimbang tanpa klaim absolut.',
              ],
              [
                'id' => 74,
                'id_sentence' => 'Penerapan standar emisi yang ketat seharusnya secara masuk akal dapat menurunkan polusi udara perkotaan.',
                'target_word' => 'should reasonably reduce',
                'vocab' => [
                  'strict emission standards' => [
                    'id' => 'standar emisi ketat',
                    'pos' => '(n phr)',
                  ],
                  'should reasonably' => [
                    'id' => 'seharusnya secara masuk akal',
                    'pos' => '(modal + adv)',
                  ],
                  'reduce' => [
                    'id' => 'menurunkan / mengurangi',
                    'pos' => '(v)',
                  ],
                  'urban air pollution' => [
                    'id' => 'polusi udara perkotaan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The enforcement of strict emission standards should reasonably reduce urban air pollution within five years.',
                  'The enforcement of strict emission standards should reasonably reduces urban air pollution within five years.',
                  'The enforcement of strict emission standards should to reasonably reduce urban air pollution within five years.',
                  'The enforcement of strict emission standards should reasonably reducing urban air pollution within five years.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should reasonably reduce\' memadukan ekspektasi normatif dengan pertimbangan rasional.',
              ],
              [
                'id' => 75,
                'id_sentence' => 'Bukti empiris yang disajikan tentu tidak dapat dianggap sebagai bukti definitif adanya kausalitas langsung.',
                'target_word' => 'cannot be considered definitive proof',
                'vocab' => [
                  'empirical evidence presented' => [
                    'id' => 'bukti empiris yang disajikan',
                    'pos' => '(n phr)',
                  ],
                  'cannot be considered' => [
                    'id' => 'tidak dapat dianggap',
                    'pos' => '(passive modal phr)',
                  ],
                  'definitive proof' => [
                    'id' => 'bukti definitif',
                    'pos' => '(n phr)',
                  ],
                  'direct causality' => [
                    'id' => 'kausalitas langsung',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The empirical evidence presented cannot be considered definitive proof of direct causality.',
                  'The empirical evidence presented must not be considered definitive proof of direct causality.',
                  'The empirical evidence presented cannot considered definitive proof of direct causality.',
                  'The empirical evidence presented cannot to be considered definitive proof of direct causality.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Cannot be considered definitive proof\' adalah frasa standar untuk membedakan korelasi dengan kausalitas.',
              ],
              [
                'id' => 76,
                'id_sentence' => 'Senyawa sintetik baru tersebut dapat secara tentatif diklasifikasikan sebagai semikonduktor organik tipe-p.',
                'target_word' => 'can be tentatively classified as',
                'vocab' => [
                  'synthetic compound' => [
                    'id' => 'senyawa sintetik',
                    'pos' => '(n phr)',
                  ],
                  'can be tentatively classified as' => [
                    'id' => 'dapat secara tentatif diklasifikasikan sebagai',
                    'pos' => '(passive modal + adv)',
                  ],
                  'p-type organic semiconductor' => [
                    'id' => 'semikonduktor organik tipe-p',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The novel synthetic compound can be tentatively classified as a p-type organic semiconductor.',
                  'The novel synthetic compound can tentatively classified as a p-type organic semiconductor.',
                  'The novel synthetic compound can is tentatively classified as a p-type organic semiconductor.',
                  'The novel synthetic compound can to be tentatively classified as a p-type organic semiconductor.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Can be tentatively classified as\' menempatkan adverbia pembatas di antara \'be\' dan \'V3\'.',
              ],
              [
                'id' => 77,
                'id_sentence' => 'Para insinyur berpendapat bahwa arsitektur komputasi baru ini pada akhirnya akan menggantikan sistem lama.',
                'target_word' => 'will eventually supplant',
                'vocab' => [
                  'engineers argue that' => [
                    'id' => 'para insinyur berpendapat bahwa',
                    'pos' => '(clause)',
                  ],
                  'novel computing architecture' => [
                    'id' => 'arsitektur komputasi baru',
                    'pos' => '(n phr)',
                  ],
                  'will eventually' => [
                    'id' => 'pada akhirnya akan',
                    'pos' => '(modal + adv)',
                  ],
                  'supplant' => [
                    'id' => 'menggantikan',
                    'pos' => '(v)',
                  ],
                  'legacy systems' => [
                    'id' => 'sistem lama',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers argue that this novel computing architecture will eventually supplant legacy systems.',
                  'Engineers argue that this novel computing architecture will eventually supplants legacy systems.',
                  'Engineers argue that this novel computing architecture will to eventually supplant legacy systems.',
                  'Engineers argue that this novel computing architecture will eventually supplanting legacy systems.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Will eventually supplant\' memadukan kepastian modal masa depan dengan adverbia waktu jangka panjang.',
              ],
              [
                'id' => 78,
                'id_sentence' => 'Hasil eksperimen yang tidak terduga tersebut kemungkinan besar pasti dipicu oleh kontaminasi reagen.',
                'target_word' => 'must almost certainly have been triggered by',
                'vocab' => [
                  'unexpected experimental outcomes' => [
                    'id' => 'hasil eksperimen tak terduga',
                    'pos' => '(n phr)',
                  ],
                  'must almost certainly have been triggered by' => [
                    'id' => 'kemungkinan besar pasti dipicu oleh',
                    'pos' => '(calibrated perfect modal phr)',
                  ],
                  'reagent contamination' => [
                    'id' => 'kontaminasi reagen',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The unexpected experimental outcomes must almost certainly have been triggered by reagent contamination.',
                  'The unexpected experimental outcomes must almost certainly has been triggered by reagent contamination.',
                  'The unexpected experimental outcomes must almost certainly had been triggered by reagent contamination.',
                  'The unexpected experimental outcomes must almost certainly have being triggered by reagent contamination.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Must almost certainly have been triggered by\' adalah bentuk deduksi retrospektif berderajat keyakinan tinggi.',
              ],
              [
                'id' => 79,
                'id_sentence' => 'Pembuat kebijakan sebaiknya secara hati-hati mengevaluasi risiko sistemik sebelum mencabut subsidi bahan bakar.',
                'target_word' => 'should prudently evaluate',
                'vocab' => [
                  'policymakers' => [
                    'id' => 'pembuat kebijakan',
                    'pos' => '(n)',
                  ],
                  'should prudently' => [
                    'id' => 'sebaiknya secara bijak / hati-hati',
                    'pos' => '(modal + adv)',
                  ],
                  'evaluate' => [
                    'id' => 'mengevaluasi',
                    'pos' => '(v)',
                  ],
                  'systemic risks' => [
                    'id' => 'risiko sistemik',
                    'pos' => '(n phr)',
                  ],
                  'repealing fuel subsidies' => [
                    'id' => 'mencabut subsidi bahan bakar',
                    'pos' => '(gerund phr)',
                  ],
                ],
                'options' => [
                  'Policymakers should prudently evaluate systemic risks prior to repealing fuel subsidies.',
                  'Policymakers should prudently evaluates systemic risks prior to repealing fuel subsidies.',
                  'Policymakers should to prudently evaluate systemic risks prior to repealing fuel subsidies.',
                  'Policymakers should prudently evaluating systemic risks prior to repealing fuel subsidies.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Should prudently evaluate\' merumuskan rekomendasi kebijakan publik dengan kehati-hatian (*prudence*).',
              ],
              [
                'id' => 80,
                'id_sentence' => 'Berdasarkan bukti yang tersedia saat ini, model prediktif tersebut dapat dikatakan cukup kuat.',
                'target_word' => 'may arguably be described as',
                'vocab' => [
                  'based on currently available evidence' => [
                    'id' => 'berdasarkan bukti yang tersedia saat ini',
                    'pos' => '(prep phr)',
                  ],
                  'predictive model' => [
                    'id' => 'model prediktif',
                    'pos' => '(n phr)',
                  ],
                  'may arguably be described as' => [
                    'id' => 'dapat dikatakan cukup (hedging pasif)',
                    'pos' => '(passive modal phr)',
                  ],
                  'sufficiently robust' => [
                    'id' => 'cukup kuat / kokoh',
                    'pos' => '(adj phr)',
                  ],
                ],
                'options' => [
                  'Based on currently available evidence, the predictive model may arguably be described as sufficiently robust.',
                  'Based on currently available evidence, the predictive model may arguably described as sufficiently robust.',
                  'Based on currently available evidence, the predictive model may arguably is described as sufficiently robust.',
                  'Based on currently available evidence, the predictive model may arguably to be described as sufficiently robust.',
                ],
                'correct_index' => 0,
                'explanation' => '\'May arguably be described as\' adalah contoh terbaik sintesis hedging akademis tingkat mahir (*hedged claim*).',
              ],
            ],
          ],
        ];
    }
}
