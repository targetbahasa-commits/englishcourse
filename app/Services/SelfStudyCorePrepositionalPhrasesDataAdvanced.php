<?php

namespace App\Services;

class SelfStudyCorePrepositionalPhrasesDataAdvanced
{
    /**
     * Get the complete Core Prepositional Phrases (Level 101) package.
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
            'banner_title' => 'Core Prepositional Phrases (Level 101)',
            'banner_subtitle' => 'Kuasai penggunaan frase preposisi penunjuk lokasi, waktu, instrumen, sebab-akibat, atribusi, serta teknik fronting untuk memperkaya kepadatan kalimat ilmiah.',
            'banner_badge' => 'MODULE 1.5 PREPOSITIONAL PHRASES',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.5
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Anatomi & Fungsi Sintaksis Prepositional Phrases dalam Academic Writing',
            'concept_summary' => 'Frase preposisi (Prepositional Phrase) adalah konstruksi sintaksis yang dibentuk oleh Preposisi diikuti Objek Preposisi (Noun Phrase, Pronoun, atau Gerund V-ing). Dalam academic writing, frase preposisi bertindak sebagai instrumen vital untuk memperluas klausa dasar (Clause Expansion), menetapkan parameter eksperimental secara terukur (lokasi, waktu, metode, dan batasan sebab-akibat), serta menciptakan kohesi teks tanpa menimbulkan subordinasi bertingkat yang membingungkan.',
            'rules' => [
                [
                    'rule_title' => '1. Struktur Dasar: Preposition + Object of Preposition',
                    'rule_formula' => 'Preposition (in, at, on, by, through, during) + Noun Phrase / Gerund (V-ing)',
                    'rule_description' => 'Objek preposisi WAJIB berupa kata benda, frasa kata benda, atau gerund. Dilarang meletakkan kata kerja berkonjugasi (finite verb) langsung setelah preposisi.',
                    'examples' => [
                        [
                            'en' => 'Researchers analyze samples through density gradient centrifugation in sterile environments.',
                            'id' => 'Peneliti menganalisis sampel melalui sentrifugasi gradien densitas di lingkungan steril.',
                            'note' => 'Dua frase preposisi memodifikasi verba "analyze": instrumen (through...) dan lokasi (in...).'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Sentence-Initial Fronting & Punctuation Logic',
                    'rule_formula' => 'Prepositional Phrase (Context) + COMMA ( , ) + Subject + Verb + Object',
                    'rule_description' => 'Memindahkan frase preposisi ke awal kalimat (fronting) berfungsi untuk menetapkan kerangka topik (Theme) sebelum inti argumen diutarakan. Frase preposisi pembuka kalimat WAJIB dipisahkan dengan tanda koma.',
                    'examples' => [
                        [
                            'en' => 'In recent demographic studies, metropolitan urbanization demonstrates a steady deceleration.',
                            'id' => 'Dalam studi demografi baru-baru ini, urbanisasi metropolitan menunjukkan perlambatan yang stabil.',
                            'note' => 'Tanda koma setelah "studies" mutlak diperlukan.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Preposisi Sebab-Akibat: due to vs because',
                    'rule_formula' => 'Clause + due to / owing to / as a result of + Noun Phrase (Bukan Klausa Berpredikat)',
                    'rule_description' => '"Due to" dan "owing to" adalah preposisi, sehingga WAJIB diikuti kata benda atau frasa benda. Jangan gunakan "due to" jika diikuti kalimat lengkap (S + V).',
                    'examples' => [
                        [
                            'en' => 'Agricultural productivity declines due to prolonged precipitation anomalies.',
                            'id' => 'Produktivitas pertanian menurun akibat anomali curah hujan berkepanjangan.',
                            'note' => 'Diikuti Noun Phrase "prolonged precipitation anomalies".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Multi-Prepositional Stacking Hierarchy',
                    'rule_formula' => 'Clause + [Method/Instrument] + [Location/Setting] + [Time/Conditions]',
                    'rule_description' => 'Ketika menumpuk beberapa frase preposisi di akhir kalimat, gunakan urutan hierarkis alami untuk menghindari kesalahpahaman modifikasi sintaksis.',
                    'examples' => [
                        [
                            'en' => 'The sensor records seismic tremors via wireless telemetry at high altitudes during winter storms.',
                            'id' => 'Sensor merekam getaran seismik via telemetri nirkabel di ketinggian tinggi selama badai musim dingin.',
                            'note' => 'Urutan: Instrumen (via...) -> Lokasi (at...) -> Waktu (during...).'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Kategori Preposisi', 'Preposisi Standar', 'Fungsi dalam Penulisan Ilmiah', 'Contoh Kalimat'],
                'rows' => [
                    ['Spasial / Lokasi', 'in, at, on', 'Menetapkan batasan fisik & institusional riset', 'Conducted at university laboratories.'],
                    ['Temporal / Waktu', 'during, throughout, within', 'Menandai durasi, interval & batas waktu pengujian', 'Observed throughout the six-month trial.'],
                    ['Instrumental / Cara', 'by (V-ing), through, via', 'Menerangkan alat, metode & saluran teknologi', 'Identified through infrared spectroscopy.'],
                    ['Kausalitas / Sebab', 'due to, owing to, as a result of', 'Merasionalkan faktor penyebab secara ringkas', 'Evaporates due to elevated temperatures.'],
                    ['Lingkup & Dimensi', 'in terms of, with respect to', 'Membatasi metrik atau sudut pandang analisis', 'Optimal in terms of energy efficiency.'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The experiment succeeded because of the researchers worked diligently.',
                    'correct' => 'The experiment succeeded because the researchers worked diligently. (atau: due to diligent research work)',
                    'explanation' => 'Preposisi "because of" wajib diikuti frasa benda, bukan klausa lengkap dengan predikat (worked).'
                ],
                [
                    'incorrect' => 'In developing countries public transit remains underfunded.',
                    'correct' => 'In developing countries, public transit remains underfunded.',
                    'explanation' => 'Missing Comma: Frase preposisi di awal kalimat wajib diakhiri tanda koma pemisah.'
                ],
                [
                    'incorrect' => 'Researchers analyzed the chemical structure with using chromatography.',
                    'correct' => 'Researchers analyzed the chemical structure by using chromatography. (atau: through chromatography)',
                    'explanation' => 'Metode tindakan aktif berpasangan dengan "by + Gerund", bukan "with using".'
                ],
                [
                    'incorrect' => 'According to my perspective, this methodology is superior.',
                    'correct' => 'From an analytical perspective, this methodology is superior. (atau: In this study, ...)',
                    'explanation' => 'Hindari frasa subjektif kasual "According to my perspective/me" dalam register akademis.'
                ],
            ],
            'exam_tips' => [
                'Variasikan posisi frase preposisi (awal kalimat dengan koma vs akhir kalimat tanpa koma) untuk menciptakan ritme tulisan akademik yang dinamis.',
                'Periksa setiap preposisi agar selalu diikuti Noun Phrase atau Gerund, bukan finite verb.',
                'Gunakan frase preposisi formal seperti "in terms of", "with respect to", dan "through" untuk menaikkan skor Lexical Resource & Grammatical Range di IELTS/TOEFL.'
            ],
        ];
    }

    /**
     * Complete list of 8 sub-lessons for Topic 1.5
     */
    public static function getSubLessons(): array
    {
        return [
          [
            'id' => 'prep_location',
            'name' => 'Prepositional Phrases of Location & Spatial Settings (in, at, on)',
            'code' => '1.5.1',
            'concept_title' => 'Frase Preposisi Penunjuk Lokasi dan Ruang Lingkup Spasial',
            'concept_description' => 'Dalam academic writing, frase preposisi lokasi menetapkan tempat geografis, institusional, atau lingkungan fisik tempat fenomena diamati. Rumus dasarnya adalah Preposisi (in, at, on) + Object of Preposition (Noun Phrase). Gunakan \'in\' untuk wilayah luas/wadah (in urban areas, in tropical forests), \'at\' untuk titik spesifik atau institusi (at university laboratories, at atmospheric pressure), dan \'on\' untuk permukaan (on the ocean surface, on cell membranes).',
            'formula' => 'Clause + IN / AT / ON + Spatial Noun Phrase',
            'rules' => [
              'Frase preposisi terdiri atas preposisi diikuti kata benda (Object of Preposition).',
              'Dilarang meletakkan kata kerja berkonjugasi langsung setelah preposisi (preposisi diikuti Noun / Gerund V-ing).',
              'Gunakan \'in\' untuk wilayah geografis, negara, kota, dan lingkungan internal.',
              'Gunakan \'at\' untuk titik acuan temperatur/tekanan tertentu dan fasilitas institusional.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Para peneliti mengumpulkan sampel tanah di hutan hujan tropis selama musim kemarau.',
                'target_word' => 'in tropical rainforests',
                'vocab' => [
                  'soil samples' => [
                    'id' => 'sampel tanah',
                    'pos' => '(n phr)',
                  ],
                  'tropical rainforests' => [
                    'id' => 'hutan hujan tropis',
                    'pos' => '(n phr)',
                  ],
                  'dry season' => [
                    'id' => 'musim kemarau',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers collect soil samples in tropical rainforests during the dry season.',
                  'Researchers collect soil samples at tropical rainforests during the dry season.',
                  'Researchers collect soil samples on tropical rainforests during the dry season.',
                  'Researchers collect soil samples into tropical rainforests during the dry season.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk area geografis/bioma luas seperti hutan hujan tropis, preposisi spasial yang tepat adalah \'in\'.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Pengujian kekuatan tarik dilakukan di laboratorium metalurgi universitas.',
                'target_word' => 'at the university metallurgical laboratory',
                'vocab' => [
                  'tensile strength testing' => [
                    'id' => 'pengujian kekuatan tarik',
                    'pos' => '(n phr)',
                  ],
                  'conduct' => [
                    'id' => 'melakukan / melaksanakan',
                    'pos' => '(v)',
                  ],
                  'metallurgical laboratory' => [
                    'id' => 'laboratorium metalurgi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Tensile strength testing takes place at the university metallurgical laboratory.',
                  'Tensile strength testing takes place on the university metallurgical laboratory.',
                  'Tensile strength testing takes place by the university metallurgical laboratory.',
                  'Tensile strength testing takes place through the university metallurgical laboratory.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk fasilitas atau institusi spesifik, preposisi lokasi yang tepat adalah \'at\'.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Bakteri patogen membentuk lapisan biofilm pelindung pada permukaan implan medis.',
                'target_word' => 'on the surface of medical implants',
                'vocab' => [
                  'pathogenic bacteria' => [
                    'id' => 'bakteri patogen',
                    'pos' => '(n phr)',
                  ],
                  'biofilm layer' => [
                    'id' => 'lapisan biofilm',
                    'pos' => '(n phr)',
                  ],
                  'surface' => [
                    'id' => 'permukaan',
                    'pos' => '(n)',
                  ],
                  'medical implants' => [
                    'id' => 'implan medis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Pathogenic bacteria form a protective biofilm layer on the surface of medical implants.',
                  'Pathogenic bacteria form a protective biofilm layer in the surface of medical implants.',
                  'Pathogenic bacteria form a protective biofilm layer at the surface of medical implants.',
                  'Pathogenic bacteria form a protective biofilm layer through the surface of medical implants.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk permukaan kontak fisik dua dimensi, preposisi baku yang digunakan adalah \'on\' (\'on the surface of\').',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Konsentrasi karbon monoksida mencapai tingkat berbahaya di persimpangan jalan perkotaan yang padat.',
                'target_word' => 'at congested urban intersections',
                'vocab' => [
                  'carbon monoxide concentrations' => [
                    'id' => 'konsentrasi karbon monoksida',
                    'pos' => '(n phr)',
                  ],
                  'hazardous levels' => [
                    'id' => 'tingkat berbahaya',
                    'pos' => '(n phr)',
                  ],
                  'congested intersections' => [
                    'id' => 'persimpangan padat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Carbon monoxide concentrations reach hazardous levels at congested urban intersections.',
                  'Carbon monoxide concentrations reach hazardous levels on congested urban intersections.',
                  'Carbon monoxide concentrations reach hazardous levels to congested urban intersections.',
                  'Carbon monoxide concentrations reach hazardous levels by congested urban intersections.',
                ],
                'correct_index' => 0,
                'explanation' => 'Titik persimpangan jalan (intersections) adalah titik acuan spesifik yang menggunakan preposisi \'at\'.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Endapan sedimen terakumulasi secara bertahap di dasar cekungan danau purba.',
                'target_word' => 'at the bottom of the ancient lake basin',
                'vocab' => [
                  'sedimentary deposits' => [
                    'id' => 'endapan sedimen',
                    'pos' => '(n phr)',
                  ],
                  'accumulate' => [
                    'id' => 'terakumulasi',
                    'pos' => '(v)',
                  ],
                  'ancient lake basin' => [
                    'id' => 'cekungan danau purba',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Sedimentary deposits accumulate gradually at the bottom of the ancient lake basin.',
                  'Sedimentary deposits accumulate gradually in the bottom of the ancient lake basin.',
                  'Sedimentary deposits accumulate gradually on the bottom of the ancient lake basin.',
                  'Sedimentary deposits accumulate gradually toward the bottom of the ancient lake basin.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa posisi titik dasar menggunakan kolokasi preposisi \'at the bottom of\'.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Spesies endemik ini bertahan hidup secara eksklusif di dataran tinggi pegunungan terpencil.',
                'target_word' => 'in isolated mountainous highlands',
                'vocab' => [
                  'endemic species' => [
                    'id' => 'spesies endemik',
                    'pos' => '(n phr)',
                  ],
                  'survive' => [
                    'id' => 'bertahan hidup',
                    'pos' => '(v)',
                  ],
                  'isolated highlands' => [
                    'id' => 'dataran tinggi terpencil',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This endemic species survives exclusively in isolated mountainous highlands.',
                  'This endemic species survives exclusively at isolated mountainous highlands.',
                  'This endemic species survives exclusively on isolated mountainous highlands.',
                  'This endemic species survives exclusively by isolated mountainous highlands.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk wilayah geografis dataran tinggi luas, preposisi yang benar adalah \'in\'.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Sensor elektrokimia ditempatkan secara permanen di dinding dalam reaktor kimia.',
                'target_word' => 'on the interior wall',
                'vocab' => [
                  'electrochemical sensors' => [
                    'id' => 'sensor elektrokimia',
                    'pos' => '(n phr)',
                  ],
                  'interior wall' => [
                    'id' => 'dinding dalam',
                    'pos' => '(n phr)',
                  ],
                  'chemical reactor' => [
                    'id' => 'reaktor kimia',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Electrochemical sensors reside permanently on the interior wall of the chemical reactor.',
                  'Electrochemical sensors reside permanently in the interior wall of the chemical reactor.',
                  'Electrochemical sensors reside permanently at the interior wall of the chemical reactor.',
                  'Electrochemical sensors reside permanently across the interior wall of the chemical reactor.',
                ],
                'correct_index' => 0,
                'explanation' => 'Menempel pada dinding permukaan vertikal menggunakan preposisi \'on\' (\'on the interior wall\').',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Eksperimen difraksi sinar-X berlangsung pada temperatur ruangan standar.',
                'target_word' => 'at standard ambient temperature',
                'vocab' => [
                  'X-ray diffraction experiments' => [
                    'id' => 'eksperimen difraksi sinar-X',
                    'pos' => '(n phr)',
                  ],
                  'proceed' => [
                    'id' => 'berlangsung',
                    'pos' => '(v)',
                  ],
                  'standard ambient temperature' => [
                    'id' => 'temperatur ruangan standar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'X-ray diffraction experiments proceed at standard ambient temperature.',
                  'X-ray diffraction experiments proceed in standard ambient temperature.',
                  'X-ray diffraction experiments proceed on standard ambient temperature.',
                  'X-ray diffraction experiments proceed with standard ambient temperature.',
                ],
                'correct_index' => 0,
                'explanation' => 'Nilai suhu, kecepatan, atau tekanan spesifik wajib menggunakan preposisi \'at\' (\'at standard temperature\').',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Keanekaragaman hayati laut terkonsentrasi terutama di terumbu karang perairan dangkal.',
                'target_word' => 'in shallow-water coral reefs',
                'vocab' => [
                  'marine biodiversity' => [
                    'id' => 'keanekaragaman hayati laut',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'concentrate' => [
                    'id' => 'terkonsentrasi',
                    'pos' => '(v)',
                  ],
                  'shallow-water coral reefs' => [
                    'id' => 'terumbu karang perairan dangkal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Marine biodiversity concentrates predominantly in shallow-water coral reefs.',
                  'Marine biodiversity concentrates predominantly at shallow-water coral reefs.',
                  'Marine biodiversity concentrates predominantly on shallow-water coral reefs.',
                  'Marine biodiversity concentrates predominantly towards shallow-water coral reefs.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk habitat ekosistem lingkungan perairan laut, gunakan preposisi \'in\'.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Tekanan hidrostatik meningkat secara linier pada kedalaman laut yang lebih besar.',
                'target_word' => 'at greater ocean depths',
                'vocab' => [
                  'hydrostatic pressure' => [
                    'id' => 'tekanan hidrostatik',
                    'pos' => '(n phr)',
                  ],
                  'increase linearly' => [
                    'id' => 'meningkat secara linier',
                    'pos' => '(v phr)',
                  ],
                  'greater depths' => [
                    'id' => 'kedalaman yang lebih besar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Hydrostatic pressure increases linearly at greater ocean depths.',
                  'Hydrostatic pressure increases linearly in greater ocean depths.',
                  'Hydrostatic pressure increases linearly on greater ocean depths.',
                  'Hydrostatic pressure increases linearly by greater ocean depths.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tingkat kedalaman atau ketinggian acuan ilmiah menggunakan preposisi \'at\' (\'at greater depths\').',
              ],
            ],
          ],
          [
            'id' => 'prep_time',
            'name' => 'Prepositional Phrases of Time & Chronology (during, throughout, within)',
            'code' => '1.5.2',
            'concept_title' => 'Frase Preposisi Penunjuk Waktu dan Kronologi Eksperimental',
            'concept_description' => 'Frase preposisi temporal menetapkan kerangka waktu pelaksanaan eksperimen, interval pengamatan, atau durasi proses ilmiah. Gunakan \'during\' untuk merujuk pada peristiwa atau periode tertentu (during the intervention), \'throughout\' untuk menekankan kesinambungan tanpa putus (throughout the 12-month trial), dan \'within\' untuk batas waktu maksimum (within twenty-four hours).',
            'formula' => 'Clause + DURING / THROUGHOUT / WITHIN / UPON + Temporal Noun Phrase',
            'rules' => [
              '\'During\' diikuti kata benda penunjuk peristiwa/periode (bukan klausula berpredikat).',
              '\'Throughout\' bermakna \'sepanjang keseluruhan rentang waktu dari awal hingga akhir\'.',
              '\'Within\' digunakan untuk menyatakan batas rentang waktu tertentu.',
              '\'Upon\' diikuti kata benda atau gerund bermakna \'segera setelah terjadinya suatu peristiwa\'.',
            ],
            'exercises' => [
              [
                'id' => 11,
                'id_sentence' => 'Subjek penelitian menunjukkan fluktuasi detak jantung yang signifikan selama fase tidur gelombang lambat.',
                'target_word' => 'during slow-wave sleep phases',
                'vocab' => [
                  'study subjects' => [
                    'id' => 'subjek penelitian',
                    'pos' => '(n phr)',
                  ],
                  'heart rate fluctuations' => [
                    'id' => 'fluktuasi detak jantung',
                    'pos' => '(n phr)',
                  ],
                  'slow-wave sleep' => [
                    'id' => 'tidur gelombang lambat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Study subjects exhibit significant heart rate fluctuations during slow-wave sleep phases.',
                  'Study subjects exhibit significant heart rate fluctuations while slow-wave sleep phases.',
                  'Study subjects exhibit significant heart rate fluctuations throughout slow-wave sleep phases.',
                  'Study subjects exhibit significant heart rate fluctuations within slow-wave sleep phases.',
                ],
                'correct_index' => 0,
                'explanation' => '\'During\' diikuti Noun Phrase \'slow-wave sleep phases\' untuk menunjukkan periode terjadinya fluktuasi (\'while\' harus diikuti klausa berpredikat).',
              ],
              [
                'id' => 12,
                'id_sentence' => 'Suhu larutan tetap konstan sepanjang durasi percobaan enam jam.',
                'target_word' => 'throughout the six-hour trial',
                'vocab' => [
                  'solution temperature' => [
                    'id' => 'suhu larutan',
                    'pos' => '(n phr)',
                  ],
                  'remain constant' => [
                    'id' => 'tetap konstan',
                    'pos' => '(v phr)',
                  ],
                  'six-hour trial' => [
                    'id' => 'percobaan enam jam',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The solution temperature remains constant throughout the six-hour trial.',
                  'The solution temperature remains constant during the six-hour trial.',
                  'The solution temperature remains constant inside the six-hour trial.',
                  'The solution temperature remains constant amid the six-hour trial.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Throughout\' menekankan bahwa suhu konstan secara konsisten dari menit pertama hingga menit terakhir uji coba.',
              ],
              [
                'id' => 13,
                'id_sentence' => 'Katalis kimia menginduksi reaksi presipitasi sempurna dalam waktu empat puluh delapan jam.',
                'target_word' => 'within forty-eight hours',
                'vocab' => [
                  'chemical catalyst' => [
                    'id' => 'katalis kimia',
                    'pos' => '(n phr)',
                  ],
                  'precipitation reaction' => [
                    'id' => 'reaksi presipitasi',
                    'pos' => '(n phr)',
                  ],
                  'forty-eight hours' => [
                    'id' => 'empat puluh delapan jam',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The chemical catalyst induces complete precipitation within forty-eight hours.',
                  'The chemical catalyst induces complete precipitation during forty-eight hours.',
                  'The chemical catalyst induces complete precipitation throughout forty-eight hours.',
                  'The chemical catalyst induces complete precipitation between forty-eight hours.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Within\' menyatakan batas rentang waktu penyelesaian reaksi (tidak lebih dari 48 jam).',
              ],
              [
                'id' => 14,
                'id_sentence' => 'Segera setelah terpapar suhu dingin ekstrem, pembuluh darah perifer menyempit secara drastis.',
                'target_word' => 'Upon exposure to extreme cold',
                'vocab' => [
                  'upon exposure' => [
                    'id' => 'segera setelah terpapar',
                    'pos' => '(prep phr)',
                  ],
                  'peripheral blood vessels' => [
                    'id' => 'pembuluh darah perifer',
                    'pos' => '(n phr)',
                  ],
                  'constrict' => [
                    'id' => 'menyempit',
                    'pos' => '(v)',
                  ],
                ],
                'options' => [
                  'Upon exposure to extreme cold, peripheral blood vessels constrict dramatically.',
                  'During exposure to extreme cold, peripheral blood vessels constrict dramatically.',
                  'Within exposure to extreme cold, peripheral blood vessels constrict dramatically.',
                  'Throughout exposure to extreme cold, peripheral blood vessels constrict dramatically.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Upon + Noun\' berarti \'segera setelah\' atau \'pada saat terjadinya suatu stimulus\'.',
              ],
              [
                'id' => 15,
                'id_sentence' => 'Pasien harus mematuhi pembatasan asupan garam ketat selama masa pemulihan pasca operasi.',
                'target_word' => 'during the postoperative recovery period',
                'vocab' => [
                  'salt intake restrictions' => [
                    'id' => 'pembatasan asupan garam',
                    'pos' => '(n phr)',
                  ],
                  'adhere to' => [
                    'id' => 'mematuhi',
                    'pos' => '(v phr)',
                  ],
                  'postoperative recovery' => [
                    'id' => 'pemulihan pasca operasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Patients adhere to strict sodium restrictions during the postoperative recovery period.',
                  'Patients adhere to strict sodium restrictions while the postoperative recovery period.',
                  'Patients adhere to strict sodium restrictions within the postoperative recovery period.',
                  'Patients adhere to strict sodium restrictions onto the postoperative recovery period.',
                ],
                'correct_index' => 0,
                'explanation' => 'Periode pemulihan ditandai dengan preposisi \'during\' + Noun Phrase.',
              ],
              [
                'id' => 16,
                'id_sentence' => 'Konsentrasi ozon stratosfer berfluktuasi secara teratur sepanjang pergantian musim tahunan.',
                'target_word' => 'throughout the annual seasonal cycle',
                'vocab' => [
                  'stratospheric ozone' => [
                    'id' => 'ozon stratosfer',
                    'pos' => '(n phr, uncountable)',
                  ],
                  'fluctuate' => [
                    'id' => 'berfluktuasi',
                    'pos' => '(v)',
                  ],
                  'seasonal cycle' => [
                    'id' => 'siklus musim tahunan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Stratospheric ozone concentrations fluctuate regularly throughout the annual seasonal cycle.',
                  'Stratospheric ozone concentrations fluctuate regularly between the annual seasonal cycle.',
                  'Stratospheric ozone concentrations fluctuate regularly within the annual seasonal cycle.',
                  'Stratospheric ozone concentrations fluctuate regularly during the annual seasonal cycle.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Throughout\' tepat digunakan untuk siklus yang berjalan utuh sepanjang tahun.',
              ],
              [
                'id' => 17,
                'id_sentence' => 'Sistem komputasi awan menghasilkan cadangan data otomatis dalam interval tiga puluh menit.',
                'target_word' => 'within thirty-minute intervals',
                'vocab' => [
                  'cloud computing infrastructure' => [
                    'id' => 'infrastruktur komputasi awan',
                    'pos' => '(n phr)',
                  ],
                  'automated backups' => [
                    'id' => 'cadangan otomatis',
                    'pos' => '(n phr)',
                  ],
                  'intervals' => [
                    'id' => 'interval',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The cloud computing infrastructure generates automated backups within thirty-minute intervals.',
                  'The cloud computing infrastructure generates automated backups during thirty-minute intervals.',
                  'The cloud computing infrastructure generates automated backups throughout thirty-minute intervals.',
                  'The cloud computing infrastructure generates automated backups upon thirty-minute intervals.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Within thirty-minute intervals\' menandai rentang batas waktu pelaksanaan pencadangan.',
              ],
              [
                'id' => 18,
                'id_sentence' => 'Tingkat pengangguran usia muda meningkat tajam selama periode resesi ekonomi makro.',
                'target_word' => 'during periods of macroeconomic recession',
                'vocab' => [
                  'youth unemployment rate' => [
                    'id' => 'tingkat pengangguran usia muda',
                    'pos' => '(n phr)',
                  ],
                  'rise sharply' => [
                    'id' => 'meningkat tajam',
                    'pos' => '(v phr)',
                  ],
                  'macroeconomic recession' => [
                    'id' => 'resesi ekonomi makro',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The youth unemployment rate rises sharply during periods of macroeconomic recession.',
                  'The youth unemployment rate rises sharply while periods of macroeconomic recession.',
                  'The youth unemployment rate rises sharply upon periods of macroeconomic recession.',
                  'The youth unemployment rate rises sharply within periods of macroeconomic recession.',
                ],
                'correct_index' => 0,
                'explanation' => '\'During\' diikuti oleh Noun Phrase \'periods of macroeconomic recession\'.',
              ],
              [
                'id' => 19,
                'id_sentence' => 'Segera setelah penambahan asam sulfat, larutan berubah warna menjadi kuning pekat.',
                'target_word' => 'Upon the addition of sulfuric acid',
                'vocab' => [
                  'addition of acid' => [
                    'id' => 'penambahan asam',
                    'pos' => '(n phr)',
                  ],
                  'sulfuric acid' => [
                    'id' => 'asam sulfat',
                    'pos' => '(n phr)',
                  ],
                  'turn intense yellow' => [
                    'id' => 'berubah warna kuning pekat',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Upon the addition of sulfuric acid, the solution turns an intense yellow hue.',
                  'During the addition of sulfuric acid, the solution turns an intense yellow hue.',
                  'Within the addition of sulfuric acid, the solution turns an intense yellow hue.',
                  'Throughout the addition of sulfuric acid, the solution turns an intense yellow hue.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Upon + Noun Phrase\' mengindikasikan reaksi spontan segera setelah langkah penambahan dilakukan.',
              ],
              [
                'id' => 20,
                'id_sentence' => 'Sensor akustik mempertahankan sensitivitas deteksi optimal sepanjang masa pakai lima tahun.',
                'target_word' => 'throughout its five-year lifespan',
                'vocab' => [
                  'acoustic transducer' => [
                    'id' => 'sensor akustik',
                    'pos' => '(n phr)',
                  ],
                  'optimal sensitivity' => [
                    'id' => 'sensitivitas optimal',
                    'pos' => '(n phr)',
                  ],
                  'five-year lifespan' => [
                    'id' => 'masa pakai lima tahun',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The acoustic transducer maintains optimal detection sensitivity throughout its five-year lifespan.',
                  'The acoustic transducer maintains optimal detection sensitivity during its five-year lifespan.',
                  'The acoustic transducer maintains optimal detection sensitivity within its five-year lifespan.',
                  'The acoustic transducer maintains optimal detection sensitivity upon its five-year lifespan.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Throughout its lifespan\' menyatakan kesinambungan performa sepanjang masa pakai perangkat.',
              ],
            ],
          ],
          [
            'id' => 'prep_instrument',
            'name' => 'Instrumental & Methodological Prepositions (by, through, via)',
            'code' => '1.5.3',
            'concept_title' => 'Frase Preposisi Penunjuk Metode, Instrumen, dan Sarana Ilmiah',
            'concept_description' => 'Dalam metodologi penelitian, frase preposisi instrumental menerangkan sarana, alat, atau mekanisme teknis yang digunakan untuk mengeksekusi suatu proses. Gunakan \'by\' (sering kali diikuti Gerund V-ing: by administering, by measuring) atau \'by means of\', \'through\' (melalui proses bertahap: through fractional distillation), dan \'via\' (melalui perantara saluran/rute teknologi: via wireless telemetry).',
            'formula' => 'Clause + BY / THROUGH / VIA / BY MEANS OF + Procedural Noun / Gerund Phrase',
            'rules' => [
              '\'By\' diikuti Gerund (V-ing) untuk menyatakan tindakan yang dilakukan subjek (e.g. by applying pressure).',
              '\'Through\' diikuti kata benda proses (e.g. through statistical regression, through filtration).',
              '\'Via\' digunakan untuk menyatakan perantara rute, medium komunikasi, atau saluran transmisi digital.',
              'Dilarang menggunakan \'with\' untuk proses metodologis abstrak (e.g., \'analyzed with survey\' keliru, gunakan \'through a survey\').',
            ],
            'exercises' => [
              [
                'id' => 21,
                'id_sentence' => 'Para ahli biokimia memisahkan protein plasma darah melalui sentrifugasi gradien densitas.',
                'target_word' => 'through density gradient centrifugation',
                'vocab' => [
                  'biochemists' => [
                    'id' => 'para ahli biokimia',
                    'pos' => '(n)',
                  ],
                  'plasma proteins' => [
                    'id' => 'protein plasma',
                    'pos' => '(n phr)',
                  ],
                  'density gradient centrifugation' => [
                    'id' => 'sentrifugasi gradien densitas',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Biochemists isolate blood plasma proteins through density gradient centrifugation.',
                  'Biochemists isolate blood plasma proteins by density gradient centrifugation.',
                  'Biochemists isolate blood plasma proteins with density gradient centrifugation.',
                  'Biochemists isolate blood plasma proteins via density gradient centrifugation.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Through\' adalah preposisi baku untuk merujuk pada proses/metode analitis laboratoris berkesinambungan.',
              ],
              [
                'id' => 22,
                'id_sentence' => 'Pemerintah mengendalikan laju inflasi dengan menaikkan tingkat suku bunga acuan perbankan.',
                'target_word' => 'by increasing',
                'vocab' => [
                  'curb inflation' => [
                    'id' => 'mengendalikan inflasi',
                    'pos' => '(v phr)',
                  ],
                  'benchmark interest rate' => [
                    'id' => 'suku bunga acuan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The government curbs inflation by increasing the commercial benchmark interest rate.',
                  'The government curbs inflation through increase the commercial benchmark interest rate.',
                  'The government curbs inflation with increasing the commercial benchmark interest rate.',
                  'The government curbs inflation via increasing the commercial benchmark interest rate.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'by\' diikuti bentuk Gerund \'increasing\' menyatakan sarana tindakan pelaku.',
              ],
              [
                'id' => 23,
                'id_sentence' => 'Data seismik ditransmisikan secara langsung ke pusat pengamatan vulkanologi melalui telemetri satelit.',
                'target_word' => 'via satellite telemetry',
                'vocab' => [
                  'seismic data' => [
                    'id' => 'data seismik',
                    'pos' => '(n phr)',
                  ],
                  'transmit' => [
                    'id' => 'mentransmisikan',
                    'pos' => '(v)',
                  ],
                  'volcanology observatory' => [
                    'id' => 'pusat pengamatan vulkanologi',
                    'pos' => '(n phr)',
                  ],
                  'satellite telemetry' => [
                    'id' => 'telemetri satelit',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Seismic data transmit directly to the volcanology observatory via satellite telemetry.',
                  'Seismic data transmit directly to the volcanology observatory by satellite telemetry.',
                  'Seismic data transmit directly to the volcanology observatory with satellite telemetry.',
                  'Seismic data transmit directly to the volcanology observatory through satellite telemetry.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Via\' digunakan secara tepat untuk merujuk pada saluran/rute transmisi komunikasi elektronik.',
              ],
              [
                'id' => 24,
                'id_sentence' => 'Peneliti menentukan struktur kristal senyawa baru melalui difraksi sinar-X serbuk.',
                'target_word' => 'by means of powder X-ray diffraction',
                'vocab' => [
                  'crystal structure' => [
                    'id' => 'struktur kristal',
                    'pos' => '(n phr)',
                  ],
                  'powder X-ray diffraction' => [
                    'id' => 'difraksi sinar-X serbuk',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Investigators determine novel crystal structures by means of powder X-ray diffraction.',
                  'Investigators determine novel crystal structures by powder X-ray diffraction.',
                  'Investigators determine novel crystal structures with powder X-ray diffraction.',
                  'Investigators determine novel crystal structures in means of powder X-ray diffraction.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase preposisi formal \'by means of\' digunakan untuk merujuk pada instrumen ilmiah yang digunakan.',
              ],
              [
                'id' => 25,
                'id_sentence' => 'Perusahaan meminimalkan risiko kepatuhan dengan menerapkan protokol audit internal yang ketat.',
                'target_word' => 'by implementing',
                'vocab' => [
                  'compliance risks' => [
                    'id' => 'risiko kepatuhan',
                    'pos' => '(n phr)',
                  ],
                  'rigorous audit protocols' => [
                    'id' => 'protokol audit ketat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The corporation minimizes compliance risks by implementing rigorous internal audit protocols.',
                  'The corporation minimizes compliance risks through implement rigorous internal audit protocols.',
                  'The corporation minimizes compliance risks with implementing rigorous internal audit protocols.',
                  'The corporation minimizes compliance risks via implement rigorous internal audit protocols.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'by\' wajib diikuti Gerund \'implementing\'.',
              ],
              [
                'id' => 26,
                'id_sentence' => 'Sistem ini mendeteksi intrusi jaringan berbahaya melalui algoritma pembelajaran mesin tingkat lanjut.',
                'target_word' => 'through advanced machine-learning algorithms',
                'vocab' => [
                  'malicious intrusions' => [
                    'id' => 'intrusi berbahaya',
                    'pos' => '(n phr)',
                  ],
                  'machine-learning algorithms' => [
                    'id' => 'algoritma pembelajaran mesin',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The system detects malicious network intrusions through advanced machine-learning algorithms.',
                  'The system detects malicious network intrusions by advanced machine-learning algorithms.',
                  'The system detects malicious network intrusions with advanced machine-learning algorithms.',
                  'The system detects malicious network intrusions via advanced machine-learning algorithms.',
                ],
                'correct_index' => 0,
                'explanation' => 'Metode komputasi/algoritma abstrak dihubungkan dengan preposisi \'through\'.',
              ],
              [
                'id' => 27,
                'id_sentence' => 'Survei kepuasan pelanggan didistribusikan secara efisien melalui portal perpesanan seluler terenkripsi.',
                'target_word' => 'via an encrypted mobile messaging portal',
                'vocab' => [
                  'satisfaction surveys' => [
                    'id' => 'survei kepuasan',
                    'pos' => '(n phr)',
                  ],
                  'encrypted messaging portal' => [
                    'id' => 'portal perpesanan terenkripsi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Customer satisfaction surveys distribute efficiently via an encrypted mobile messaging portal.',
                  'Customer satisfaction surveys distribute efficiently by an encrypted mobile messaging portal.',
                  'Customer satisfaction surveys distribute efficiently through an encrypted mobile messaging portal.',
                  'Customer satisfaction surveys distribute efficiently with an encrypted mobile messaging portal.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Via\' adalah preposisi standar untuk kanal distribusi dan perantara pesan digital.',
              ],
              [
                'id' => 28,
                'id_sentence' => 'Insinyur sipil menstabilkan lereng curam dengan memasang jaring jangkar baja prategang.',
                'target_word' => 'by installing',
                'vocab' => [
                  'civil engineers' => [
                    'id' => 'insinyur sipil',
                    'pos' => '(n phr)',
                  ],
                  'steep slopes' => [
                    'id' => 'lereng curam',
                    'pos' => '(n phr)',
                  ],
                  'post-tensioned steel anchors' => [
                    'id' => 'jangkar baja prategang',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Civil engineers stabilize steep slopes by installing post-tensioned steel ground anchors.',
                  'Civil engineers stabilize steep slopes through install post-tensioned steel ground anchors.',
                  'Civil engineers stabilize steep slopes with installing post-tensioned steel ground anchors.',
                  'Civil engineers stabilize steep slopes via install post-tensioned steel ground anchors.',
                ],
                'correct_index' => 0,
                'explanation' => '\'By + Gerund (installing)\' menerangkan cara tindakan fisik yang diambil para insinyur.',
              ],
              [
                'id' => 29,
                'id_sentence' => 'Peneliti memurnikan ekstrak tanaman obat melalui kromatografi kolom tekanan rendah.',
                'target_word' => 'through low-pressure column chromatography',
                'vocab' => [
                  'medicinal extracts' => [
                    'id' => 'ekstrak tanaman obat',
                    'pos' => '(n phr)',
                  ],
                  'column chromatography' => [
                    'id' => 'kromatografi kolom',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers purify medicinal plant extracts through low-pressure column chromatography.',
                  'Researchers purify medicinal plant extracts by low-pressure column chromatography.',
                  'Researchers purify medicinal plant extracts with low-pressure column chromatography.',
                  'Researchers purify medicinal plant extracts via low-pressure column chromatography.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Through\' digunakan sebelum prosedur pemurnian analitis \'column chromatography\'.',
              ],
              [
                'id' => 30,
                'id_sentence' => 'Siswa berinteraksi dengan tutor kecerdasan buatan melalui antarmuka bahasa alami interaktif.',
                'target_word' => 'via an interactive natural-language interface',
                'vocab' => [
                  'interact' => [
                    'id' => 'berinteraksi',
                    'pos' => '(v)',
                  ],
                  'artificial intelligence tutor' => [
                    'id' => 'tutor kecerdasan buatan',
                    'pos' => '(n phr)',
                  ],
                  'natural-language interface' => [
                    'id' => 'antarmuka bahasa alami',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Students interact with the artificial intelligence tutor via an interactive natural-language interface.',
                  'Students interact with the artificial intelligence tutor by an interactive natural-language interface.',
                  'Students interact with the artificial intelligence tutor through an interactive natural-language interface.',
                  'Students interact with the artificial intelligence tutor with an interactive natural-language interface.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Via\' adalah preposisi yang paling tepat untuk media antarmuka perangkat lunak komputer.',
              ],
            ],
          ],
          [
            'id' => 'prep_attribution',
            'name' => 'Source, Attribution & Evidence Prepositions (according to, based on, from)',
            'code' => '1.5.4',
            'concept_title' => 'Frase Preposisi Sumber Data, Atribusi, dan Bukti Teoretis',
            'concept_description' => 'Frase preposisi atribusi menghubungkan pernyataan penulis dengan sumber otoritatif, data statistik, atau literatur akademik sebelumnya. \'According to\' digunakan untuk merujuk pada peneliti lain, laporan lembaga, atau teori (According to the World Bank report, ...). \'Based on\' menerangkan dasar data yang melandasi kesimpulan (Based on demographic projections, ...). Jangan pernah menggunakan \'According to me\' dalam academic writing; gunakan \'In this study\' atau sudut pandang objektif.',
            'formula' => 'ACCORDING TO / BASED ON / DERIVED FROM + Authoritative Source / Empirical Dataset',
            'rules' => [
              'Gunakan \'According to\' untuk merujuk pada sumber eksternal (peneliti, badan riset, regulasi).',
              'Hindari frasa subjektif \'according to me\' atau \'according to my opinion\'.',
              '\'Based on\' digunakan sebagai modifier pembuka atau penjelas dasar argumen ilmiah.',
              'Frase atribusi pembuka kalimat wajib diikuti tanda koma sebelum klausa utama.',
            ],
            'exercises' => [
              [
                'id' => 31,
                'id_sentence' => 'Menurut data sensus terbaru, populasi lansia di kawasan metropolitan meningkat secara signifikan.',
                'target_word' => 'According to the latest census data',
                'vocab' => [
                  'census data' => [
                    'id' => 'data sensus',
                    'pos' => '(n phr)',
                  ],
                  'elderly population' => [
                    'id' => 'populasi lansia',
                    'pos' => '(n phr)',
                  ],
                  'expand significantly' => [
                    'id' => 'meningkat secara signifikan',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'According to the latest census data, the elderly population in metropolitan zones expands significantly.',
                  'Based on the latest census data, the elderly population in metropolitan zones expands significantly.',
                  'From the latest census data, the elderly population in metropolitan zones expands significantly.',
                  'According with the latest census data, the elderly population in metropolitan zones expands significantly.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa standar atribusi kutipan resmi adalah \'According to the latest census data\' diikuti tanda koma.',
              ],
              [
                'id' => 32,
                'id_sentence' => 'Berdasarkan proyeksi keuangan kuartalan, dewan direksi menyetujui ekspansi fasilitas produksi.',
                'target_word' => 'Based on quarterly financial projections',
                'vocab' => [
                  'quarterly financial projections' => [
                    'id' => 'proyeksi keuangan kuartalan',
                    'pos' => '(n phr)',
                  ],
                  'board of directors' => [
                    'id' => 'dewan direksi',
                    'pos' => '(n phr)',
                  ],
                  'approve' => [
                    'id' => 'menyetujui',
                    'pos' => '(v)',
                  ],
                ],
                'options' => [
                  'Based on quarterly financial projections, the board of directors approves production facility expansion.',
                  'According on quarterly financial projections, the board of directors approves production facility expansion.',
                  'Derived to quarterly financial projections, the board of directors approves production facility expansion.',
                  'Relying in quarterly financial projections, the board of directors approves production facility expansion.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Based on\' digunakan untuk menerangkan data kuantitatif yang menjadi fondasi pengambilan keputusan.',
              ],
              [
                'id' => 33,
                'id_sentence' => 'Menurut laporan Organisasi Kesehatan Dunia, resistensi antimikroba merupakan ancaman global yang mendesak.',
                'target_word' => 'According to World Health Organization reports',
                'vocab' => [
                  'antimicrobial resistance' => [
                    'id' => 'resistensi antimikroba',
                    'pos' => '(n phr)',
                  ],
                  'pressing global threat' => [
                    'id' => 'ancaman global yang mendesak',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'According to World Health Organization reports, antimicrobial resistance represents a pressing global threat.',
                  'According with World Health Organization reports, antimicrobial resistance represents a pressing global threat.',
                  'Based to World Health Organization reports, antimicrobial resistance represents a pressing global threat.',
                  'By World Health Organization reports, antimicrobial resistance represents a pressing global threat.',
                ],
                'correct_index' => 0,
                'explanation' => '\'According to\' diikuti nama institusi resmi penerbit laporan.',
              ],
              [
                'id' => 34,
                'id_sentence' => 'Parameter uji ini diturunkan langsung dari hukum pertama termodinamika klasik.',
                'target_word' => 'derived directly from the first law',
                'vocab' => [
                  'derived from' => [
                    'id' => 'diturunkan dari',
                    'pos' => '(v phr)',
                  ],
                  'first law of classical thermodynamics' => [
                    'id' => 'hukum pertama termodinamika klasik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'These test parameters derive directly from the first law of classical thermodynamics.',
                  'These test parameters derive directly out of the first law of classical thermodynamics.',
                  'These test parameters derive directly by the first law of classical thermodynamics.',
                  'These test parameters derive directly through the first law of classical thermodynamics.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kolokasi preposisi yang baku untuk kata \'derive\' adalah \'from\' (\'derive from the first law\').',
              ],
              [
                'id' => 35,
                'id_sentence' => 'Berdasarkan bukti empiris yang dikumpulkan, hipotesis awal tidak dapat dipertahankan.',
                'target_word' => 'Based upon empirical evidence gathered',
                'vocab' => [
                  'empirical evidence gathered' => [
                    'id' => 'bukti empiris yang dikumpulkan',
                    'pos' => '(n phr)',
                  ],
                  'primary hypothesis' => [
                    'id' => 'hipotesis awal',
                    'pos' => '(n phr)',
                  ],
                  'untenable' => [
                    'id' => 'tidak dapat dipertahankan',
                    'pos' => '(adj)',
                  ],
                ],
                'options' => [
                  'Based upon empirical evidence gathered, the primary hypothesis remains untenable.',
                  'According with empirical evidence gathered, the primary hypothesis remains untenable.',
                  'Depending from empirical evidence gathered, the primary hypothesis remains untenable.',
                  'Grounding on empirical evidence gathered, the primary hypothesis remains untenable.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Based upon / Based on\' mengawali kesimpulan ilmiah berbasis bukti yang dikumpulkan.',
              ],
              [
                'id' => 36,
                'id_sentence' => 'Menurut teori agensi, pemisahan kepemilikan dan kendali menimbulkan potensi konflik kepentingan.',
                'target_word' => 'According to agency theory',
                'vocab' => [
                  'agency theory' => [
                    'id' => 'teori agensi',
                    'pos' => '(n phr)',
                  ],
                  'separation of ownership and control' => [
                    'id' => 'pemisahan kepemilikan dan kendali',
                    'pos' => '(n phr)',
                  ],
                  'conflict of interest' => [
                    'id' => 'konflik kepentingan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'According to agency theory, the separation of ownership and control creates potential conflicts of interest.',
                  'Based to agency theory, the separation of ownership and control creates potential conflicts of interest.',
                  'In agency theory according, the separation of ownership and control creates potential conflicts of interest.',
                  'According with agency theory, the separation of ownership and control creates potential conflicts of interest.',
                ],
                'correct_index' => 0,
                'explanation' => '\'According to agency theory\' adalah frase pembuka atribusi teoretis akademik.',
              ],
              [
                'id' => 37,
                'id_sentence' => 'Informasi genetik ini diekstraksi dari sampel fosil berumur sepuluh ribu tahun.',
                'target_word' => 'extracted from ten-thousand-year-old fossil specimens',
                'vocab' => [
                  'genetic information' => [
                    'id' => 'informasi genetik',
                    'pos' => '(n phr)',
                  ],
                  'fossil specimens' => [
                    'id' => 'sampel fosil',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Genetic information is extracted from ten-thousand-year-old fossil specimens.',
                  'Genetic information is extracted of ten-thousand-year-old fossil specimens.',
                  'Genetic information is extracted through ten-thousand-year-old fossil specimens.',
                  'Genetic information is extracted by ten-thousand-year-old fossil specimens.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'from\' menunjukkan sumber asal fisik (\'extracted from\').',
              ],
              [
                'id' => 38,
                'id_sentence' => 'Berdasarkan hasil wawancara mendalam, sebagian besar responden menyatakan kekhawatiran privasi data.',
                'target_word' => 'Based on in-depth interview outcomes',
                'vocab' => [
                  'in-depth interview outcomes' => [
                    'id' => 'hasil wawancara mendalam',
                    'pos' => '(n phr)',
                  ],
                  'respondents' => [
                    'id' => 'responden',
                    'pos' => '(n)',
                  ],
                  'data privacy concerns' => [
                    'id' => 'kekhawatiran privasi data',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Based on in-depth interview outcomes, most respondents voice serious data privacy concerns.',
                  'According on in-depth interview outcomes, most respondents voice serious data privacy concerns.',
                  'Following to in-depth interview outcomes, most respondents voice serious data privacy concerns.',
                  'Depending with in-depth interview outcomes, most respondents voice serious data privacy concerns.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Based on\' digunakan sebelum frasa hasil kualitatif (\'Based on in-depth interview outcomes\').',
              ],
              [
                'id' => 39,
                'id_sentence' => 'Menurut literatur kedokteran kontemporer, intervensi dini mengurangi risiko komplikasi vaskular.',
                'target_word' => 'According to contemporary medical literature',
                'vocab' => [
                  'contemporary medical literature' => [
                    'id' => 'literatur kedokteran kontemporer',
                    'pos' => '(n phr)',
                  ],
                  'early intervention' => [
                    'id' => 'intervensi dini',
                    'pos' => '(n phr)',
                  ],
                  'vascular complications' => [
                    'id' => 'komplikasi vaskular',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'According to contemporary medical literature, early intervention lowers the risk of vascular complications.',
                  'According with contemporary medical literature, early intervention lowers the risk of vascular complications.',
                  'Based to contemporary medical literature, early intervention lowers the risk of vascular complications.',
                  'By contemporary medical literature, early intervention lowers the risk of vascular complications.',
                ],
                'correct_index' => 0,
                'explanation' => '\'According to contemporary medical literature\' menyandarkan klaim pada konsensus kepustakaan.',
              ],
              [
                'id' => 40,
                'id_sentence' => 'Data statistik ini berasal dari pangkalan data Bank Pembangunan Asia.',
                'target_word' => 'originates from the Asian Development Bank database',
                'vocab' => [
                  'originate from' => [
                    'id' => 'berasal dari',
                    'pos' => '(v phr)',
                  ],
                  'Asian Development Bank database' => [
                    'id' => 'pangkalan data Bank Pembangunan Asia',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This statistical dataset originates from the Asian Development Bank database.',
                  'This statistical dataset originates out of the Asian Development Bank database.',
                  'This statistical dataset originates by the Asian Development Bank database.',
                  'This statistical dataset originates through the Asian Development Bank database.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'originate\' berkolokasi dengan preposisi \'from\'.',
              ],
            ],
          ],
          [
            'id' => 'prep_cause',
            'name' => 'Causality Prepositions (due to, owing to, as a consequence of)',
            'code' => '1.5.5',
            'concept_title' => 'Frase Preposisi Sebab-Akibat dan Rasionalisasi Ilmiah',
            'concept_description' => 'Frase preposisi kausalitas digunakan untuk memaparkan faktor penyebab suatu fenomena secara ringkas tanpa perlu menyusun anak kalimat subordinatif baru. Pola yang baku mencakup \'due to\', \'owing to\', dan \'as a consequence of\', yang WAJIB diikuti oleh kata benda (Noun / Noun Phrase) atau Gerund (V-ing). Kesalahan fatal penutur bahasa Inggris adalah meletakkan klausa berpredikat lengkap langsung setelah \'due to\' (e.g., \'due to it rains\' adalah SALAH, yang benar adalah \'due to the rainfall\' atau \'due to the fact that it rains\').',
            'formula' => 'Clause + DUE TO / OWING TO / AS A CONSEQUENCE OF + Noun Phrase (Cause)',
            'rules' => [
              'Wajib diikuti Noun Phrase atau Gerund (bukan kalimat/klausa subjek + predikat).',
              '\'Due to\' memodifikasi kata benda, sedangkan \'owing to\' sering berfungsi sebagai adverbial penjelas klausula.',
              'Gunakan frasa berbobot seperti \'as a consequence of\' atau \'attributable to\' untuk karya ilmiah formal.',
              'Dilarang menulis \'due to + Subject + Verb\' tanpa menjembataninya dengan \'the fact that\'.',
            ],
            'exercises' => [
              [
                'id' => 41,
                'id_sentence' => 'Efisiensi panel surya menurun drastis akibat akumulasi debu tebal pada permukaan kaca.',
                'target_word' => 'due to heavy dust accumulation',
                'vocab' => [
                  'solar panel efficiency' => [
                    'id' => 'efisiensi panel surya',
                    'pos' => '(n phr)',
                  ],
                  'drop precipitously' => [
                    'id' => 'menurun drastis',
                    'pos' => '(v phr)',
                  ],
                  'dust accumulation' => [
                    'id' => 'akumulasi debu',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Solar panel efficiency drops precipitously due to heavy dust accumulation on the glass surface.',
                  'Solar panel efficiency drops precipitously because heavy dust accumulation on the glass surface.',
                  'Solar panel efficiency drops precipitously due to heavy dust accumulates on the glass surface.',
                  'Solar panel efficiency drops precipitously owing that heavy dust accumulation on the glass surface.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Due to\' diikuti oleh Noun Phrase \'heavy dust accumulation\'. Opsi \'because\' keliru karena \'because\' harus diikuti klausa berpredikat.',
              ],
              [
                'id' => 42,
                'id_sentence' => 'Penerbangan eksperimental dibatalkan karena turbulensi atmosfer ekstrem di lapisan stratosfer bawah.',
                'target_word' => 'owing to severe atmospheric turbulence',
                'vocab' => [
                  'experimental flights' => [
                    'id' => 'penerbangan eksperimental',
                    'pos' => '(n phr)',
                  ],
                  'cancel' => [
                    'id' => 'membatalkan',
                    'pos' => '(v)',
                  ],
                  'severe atmospheric turbulence' => [
                    'id' => 'turbulensi atmosfer ekstrem',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Experimental flights face cancellation owing to severe atmospheric turbulence in the lower stratosphere.',
                  'Experimental flights face cancellation owing that severe atmospheric turbulence in the lower stratosphere.',
                  'Experimental flights face cancellation due that severe atmospheric turbulence in the lower stratosphere.',
                  'Experimental flights face cancellation because severe atmospheric turbulence in the lower stratosphere.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Owing to\' adalah preposisi kausal yang tepat diikuti frasa benda \'severe atmospheric turbulence\'.',
              ],
              [
                'id' => 43,
                'id_sentence' => 'Kepadatan terumbu karang menyusut sebagai konsekuensi dari pengasaman laut global.',
                'target_word' => 'as a consequence of global ocean acidification',
                'vocab' => [
                  'coral reef density' => [
                    'id' => 'kepadatan terumbu karang',
                    'pos' => '(n phr)',
                  ],
                  'diminish' => [
                    'id' => 'menyusut / berkurang',
                    'pos' => '(v)',
                  ],
                  'ocean acidification' => [
                    'id' => 'pengasaman laut',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Coral reef density diminishes as a consequence of global ocean acidification.',
                  'Coral reef density diminishes as a consequence that global ocean acidification.',
                  'Coral reef density diminishes as a consequence to global ocean acidification.',
                  'Coral reef density diminishes for a consequence of global ocean acidification.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa preposisi formal sebab-akibat yang baku adalah \'as a consequence of + Noun Phrase\'.',
              ],
              [
                'id' => 44,
                'id_sentence' => 'Penyimpangan data tersebut disebabkan oleh kalibrasi instrumen optik yang tidak akurat.',
                'target_word' => 'attributable to inaccurate calibration',
                'vocab' => [
                  'data variance' => [
                    'id' => 'penyimpangan data',
                    'pos' => '(n phr)',
                  ],
                  'attributable to' => [
                    'id' => 'disebabkan oleh',
                    'pos' => '(adj phr)',
                  ],
                  'inaccurate optical calibration' => [
                    'id' => 'kalibrasi optik tidak akurat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The data variance is attributable to inaccurate optical calibration of the instruments.',
                  'The data variance is attributable of inaccurate optical calibration of the instruments.',
                  'The data variance is attributable with inaccurate optical calibration of the instruments.',
                  'The data variance is attributable by inaccurate optical calibration of the instruments.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa predikatif sebab-akibat \'attributable\' wajib berpasangan dengan preposisi \'to\'.',
              ],
              [
                'id' => 45,
                'id_sentence' => 'Hasil panen menurun secara signifikan akibat gelombang panas berkepanjangan.',
                'target_word' => 'due to prolonged heatwaves',
                'vocab' => [
                  'agricultural yields' => [
                    'id' => 'hasil panen',
                    'pos' => '(n phr)',
                  ],
                  'decline significantly' => [
                    'id' => 'menurun secara signifikan',
                    'pos' => '(v phr)',
                  ],
                  'prolonged heatwaves' => [
                    'id' => 'gelombang panas berkepanjangan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Agricultural yields decline significantly due to prolonged heatwaves across rural provinces.',
                  'Agricultural yields decline significantly because prolonged heatwaves across rural provinces.',
                  'Agricultural yields decline significantly owing that prolonged heatwaves across rural provinces.',
                  'Agricultural yields decline significantly due that prolonged heatwaves across rural provinces.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Due to\' menghubungkan klausa utama dengan frasa nomina penyebab \'prolonged heatwaves\'.',
              ],
              [
                'id' => 46,
                'id_sentence' => 'Proyek konstruksi mengalami penundaan karena gangguan rantai pasokan global.',
                'target_word' => 'owing to global supply chain disruptions',
                'vocab' => [
                  'construction initiatives' => [
                    'id' => 'proyek konstruksi',
                    'pos' => '(n phr)',
                  ],
                  'encounter delays' => [
                    'id' => 'mengalami penundaan',
                    'pos' => '(v phr)',
                  ],
                  'supply chain disruptions' => [
                    'id' => 'gangguan rantai pasokan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Construction initiatives encounter delays owing to global supply chain disruptions.',
                  'Construction initiatives encounter delays owing of global supply chain disruptions.',
                  'Construction initiatives encounter delays because global supply chain disruptions.',
                  'Construction initiatives encounter delays due of global supply chain disruptions.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Owing to\' diikuti oleh frasa nomina penyebab \'global supply chain disruptions\'.',
              ],
              [
                'id' => 47,
                'id_sentence' => 'Kualitas udara membaik sebagai akibat dari pembatasan emisi kendaraan bermotor yang ketat.',
                'target_word' => 'as a result of stringent emission controls',
                'vocab' => [
                  'urban air quality' => [
                    'id' => 'kualitas udara perkotaan',
                    'pos' => '(n phr)',
                  ],
                  'improve' => [
                    'id' => 'membaik',
                    'pos' => '(v)',
                  ],
                  'stringent emission controls' => [
                    'id' => 'pembatasan emisi ketat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Urban air quality improves as a result of stringent vehicular emission controls.',
                  'Urban air quality improves as a result to stringent vehicular emission controls.',
                  'Urban air quality improves as a result that stringent vehicular emission controls.',
                  'Urban air quality improves as result of stringent vehicular emission controls.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa preposisi kausal idiomatis adalah \'as a result of + Noun Phrase\'.',
              ],
              [
                'id' => 48,
                'id_sentence' => 'Degradasi habitat satwa liar terjadi terutama karena ekspansi perkebunan kelapa sawit.',
                'target_word' => 'largely due to oil palm expansion',
                'vocab' => [
                  'wildlife habitat degradation' => [
                    'id' => 'degradasi habitat satwa liar',
                    'pos' => '(n phr)',
                  ],
                  'occur' => [
                    'id' => 'terjadi',
                    'pos' => '(v)',
                  ],
                  'oil palm expansion' => [
                    'id' => 'ekspansi perkebunan kelapa sawit',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Wildlife habitat degradation occurs largely due to oil palm agricultural expansion.',
                  'Wildlife habitat degradation occurs largely because oil palm agricultural expansion.',
                  'Wildlife habitat degradation occurs largely owing that oil palm agricultural expansion.',
                  'Wildlife habitat degradation occurs largely due that oil palm agricultural expansion.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Due to\' dapat didahului adverb \'largely\' untuk membentuk frase \'largely due to + Noun Phrase\'.',
              ],
              [
                'id' => 49,
                'id_sentence' => 'Peningkatan morbiditas pasien berkaitan langsung dengan infeksi sekunder bakteri resisten obat.',
                'target_word' => 'linked directly to secondary infections',
                'vocab' => [
                  'patient morbidity' => [
                    'id' => 'morbiditas pasien',
                    'pos' => '(n phr)',
                  ],
                  'secondary bacterial infections' => [
                    'id' => 'infeksi sekunder bakteri',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Elevated patient morbidity is linked directly to secondary drug-resistant bacterial infections.',
                  'Elevated patient morbidity is linked directly with secondary drug-resistant bacterial infections.',
                  'Elevated patient morbidity is linked directly of secondary drug-resistant bacterial infections.',
                  'Elevated patient morbidity is linked directly by secondary drug-resistant bacterial infections.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba pasif \'is linked\' berpasangan dengan preposisi \'to\' (\'linked to\').',
              ],
              [
                'id' => 50,
                'id_sentence' => 'Erosi pantai bertambah parah sebagai konsekuensi langsung dari kenaikan permukaan air laut.',
                'target_word' => 'as a direct consequence of sea-level rise',
                'vocab' => [
                  'coastal erosion' => [
                    'id' => 'erosi pantai',
                    'pos' => '(n phr)',
                  ],
                  'worsen' => [
                    'id' => 'bertambah parah',
                    'pos' => '(v)',
                  ],
                  'sea-level rise' => [
                    'id' => 'kenaikan permukaan air laut',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Coastal erosion worsens as a direct consequence of global sea-level rise.',
                  'Coastal erosion worsens as a direct consequence to global sea-level rise.',
                  'Coastal erosion worsens as direct consequence of global sea-level rise.',
                  'Coastal erosion worsens as a direct consequence that global sea-level rise.',
                ],
                'correct_index' => 0,
                'explanation' => '\'As a direct consequence of\' adalah frase preposisi kausal formal dalam teks ilmiah.',
              ],
            ],
          ],
          [
            'id' => 'prep_scope',
            'name' => 'Prepositional Phrases of Purpose & Scope (in terms of, with respect to)',
            'code' => '1.5.6',
            'concept_title' => 'Frase Preposisi Penjelas Ruang Lingkup dan Dimensi Analisis',
            'concept_description' => 'Dalam analisis komparatif dan pelaporan data (seperti IELTS Academic Task 1 dan Task 2), membatasi ruang lingkup pembahasan pada parameter tertentu sangat penting untuk mempertahankan ketajaman argumen. Frase preposisi majemuk seperti \'in terms of\' (dari segi / dalam hal), \'with respect to\' (berkenaan dengan), \'in relation to\' (sehubungan dengan), dan \'for the purpose of\' (untuk tujuan) digunakan untuk memandu pembaca ke metrik spesifik yang dievaluasi.',
            'formula' => 'Clause + IN TERMS OF / WITH RESPECT TO / IN RELATION TO + Dimension / Metric',
            'rules' => [
              '\'In terms of\' diikuti metrik atau dimensi evaluasi (in terms of efficiency, in terms of cost).',
              '\'With respect to\' digunakan untuk memfokuskan observasi pada variabel tertentu.',
              '\'For the purpose of\' diikuti kata benda atau gerund V-ing (for the purpose of optimizing yields).',
              'Gunakan koma jika frase lingkup ini diletakkan di posisi paling awal kalimat.',
            ],
            'exercises' => [
              [
                'id' => 51,
                'id_sentence' => 'Kedua sistem penyimpanan energi tersebut sebanding dalam hal efisiensi termal.',
                'target_word' => 'in terms of thermal efficiency',
                'vocab' => [
                  'energy storage architectures' => [
                    'id' => 'sistem penyimpanan energi',
                    'pos' => '(n phr)',
                  ],
                  'comparable' => [
                    'id' => 'sebanding',
                    'pos' => '(adj)',
                  ],
                  'thermal efficiency' => [
                    'id' => 'efisiensi termal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Both energy storage architectures are comparable in terms of thermal efficiency.',
                  'Both energy storage architectures are comparable in terms to thermal efficiency.',
                  'Both energy storage architectures are comparable with terms of thermal efficiency.',
                  'Both energy storage architectures are comparable on terms of thermal efficiency.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa baku untuk menunjukkan dimensi perbandingan adalah \'in terms of\'.',
              ],
              [
                'id' => 52,
                'id_sentence' => 'Data statistik tersebut tidak menunjukkan variasi signifikan berkenaan dengan latar belakang demografis.',
                'target_word' => 'with respect to demographic background',
                'vocab' => [
                  'statistical dataset' => [
                    'id' => 'data statistik',
                    'pos' => '(n phr)',
                  ],
                  'significant variations' => [
                    'id' => 'variasi signifikan',
                    'pos' => '(n phr)',
                  ],
                  'demographic background' => [
                    'id' => 'latar belakang demografis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The statistical dataset displays no significant variations with respect to demographic background.',
                  'The statistical dataset displays no significant variations in respect of demographic background.',
                  'The statistical dataset displays no significant variations with respect of demographic background.',
                  'The statistical dataset displays no significant variations in respect with demographic background.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa preposisi majemuk yang baku adalah \'with respect to\'.',
              ],
              [
                'id' => 53,
                'id_sentence' => 'Peneliti menambahkan buffer kimia untuk tujuan mempertahankan tingkat pH yang stabil.',
                'target_word' => 'for the purpose of maintaining',
                'vocab' => [
                  'chemical buffer' => [
                    'id' => 'buffer kimia',
                    'pos' => '(n phr)',
                  ],
                  'stable pH levels' => [
                    'id' => 'tingkat pH yang stabil',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Investigators introduce a chemical buffer for the purpose of maintaining stable pH levels.',
                  'Investigators introduce a chemical buffer for the purpose to maintain stable pH levels.',
                  'Investigators introduce a chemical buffer with the purpose of maintain stable pH levels.',
                  'Investigators introduce a chemical buffer for purpose of maintaining stable pH levels.',
                ],
                'correct_index' => 0,
                'explanation' => '\'For the purpose of\' wajib diikuti oleh bentuk Gerund \'maintaining\'.',
              ],
              [
                'id' => 54,
                'id_sentence' => 'Kota metropolitan ini menduduki peringkat tertinggi dalam hal adopsi infrastruktur hijau.',
                'target_word' => 'in terms of green infrastructure adoption',
                'vocab' => [
                  'metropolitan center' => [
                    'id' => 'kota metropolitan',
                    'pos' => '(n phr)',
                  ],
                  'ranks highest' => [
                    'id' => 'menduduki peringkat tertinggi',
                    'pos' => '(v phr)',
                  ],
                  'green infrastructure' => [
                    'id' => 'infrastruktur hijau',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The metropolitan center ranks highest in terms of green infrastructure adoption.',
                  'The metropolitan center ranks highest with terms of green infrastructure adoption.',
                  'The metropolitan center ranks highest in terms to green infrastructure adoption.',
                  'The metropolitan center ranks highest on terms of green infrastructure adoption.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In terms of\' adalah frase standar metrik evaluasi pemeringkatan.',
              ],
              [
                'id' => 55,
                'id_sentence' => 'Tingkat risiko kredit dievaluasi sehubungan dengan stabilitas arus kas korporasi.',
                'target_word' => 'in relation to corporate cash flow',
                'vocab' => [
                  'credit risk exposure' => [
                    'id' => 'tingkat risiko kredit',
                    'pos' => '(n phr)',
                  ],
                  'evaluate' => [
                    'id' => 'mengevaluasi',
                    'pos' => '(v)',
                  ],
                  'corporate cash flow stability' => [
                    'id' => 'stabilitas arus kas korporasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Credit risk exposure is evaluated in relation to corporate cash flow stability.',
                  'Credit risk exposure is evaluated in relation with corporate cash flow stability.',
                  'Credit risk exposure is evaluated with relation of corporate cash flow stability.',
                  'Credit risk exposure is evaluated in relation of corporate cash flow stability.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa pembanding relasional yang tepat adalah \'in relation to\'.',
              ],
              [
                'id' => 56,
                'id_sentence' => 'Subjek penelitian dikelompokkan kembali untuk tujuan mengisolasi efek samping obat.',
                'target_word' => 'for the purpose of isolating',
                'vocab' => [
                  'trial subjects' => [
                    'id' => 'subjek penelitian',
                    'pos' => '(n phr)',
                  ],
                  'restratify' => [
                    'id' => 'mengelompokkan kembali',
                    'pos' => '(v)',
                  ],
                  'isolate adverse side effects' => [
                    'id' => 'mengisolasi efek samping',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Trial subjects are restratified for the purpose of isolating adverse drug side effects.',
                  'Trial subjects are restratified for the purpose to isolate adverse drug side effects.',
                  'Trial subjects are restratified with the purpose of isolate adverse drug side effects.',
                  'Trial subjects are restratified in the purpose of isolating adverse drug side effects.',
                ],
                'correct_index' => 0,
                'explanation' => '\'For the purpose of\' berkolokasi dengan Gerund \'isolating\'.',
              ],
              [
                'id' => 57,
                'id_sentence' => 'Kedua material komposit tersebut berbeda nyata berkenaan dengan ketahanan terhadap impak.',
                'target_word' => 'with respect to impact resistance',
                'vocab' => [
                  'composite materials' => [
                    'id' => 'material komposit',
                    'pos' => '(n phr)',
                  ],
                  'differ markedly' => [
                    'id' => 'berbeda nyata',
                    'pos' => '(v phr)',
                  ],
                  'impact resistance' => [
                    'id' => 'ketahanan terhadap impak',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The two composite materials differ markedly with respect to impact resistance.',
                  'The two composite materials differ markedly with respect of impact resistance.',
                  'The two composite materials differ markedly in respect with impact resistance.',
                  'The two composite materials differ markedly with respects to impact resistance.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa komparasi \'with respect to\' diikuti parameter \'impact resistance\'.',
              ],
              [
                'id' => 58,
                'id_sentence' => 'Metrik ini menawarkan keunggulan kompetitif dalam hal kecepatan kalkulasi algoritma.',
                'target_word' => 'in terms of algorithmic computation speed',
                'vocab' => [
                  'metric' => [
                    'id' => 'metrik',
                    'pos' => '(n)',
                  ],
                  'competitive advantage' => [
                    'id' => 'keunggulan kompetitif',
                    'pos' => '(n phr)',
                  ],
                  'computation speed' => [
                    'id' => 'kecepatan kalkulasi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This metric offers a competitive advantage in terms of algorithmic computation speed.',
                  'This metric offers a competitive advantage in terms to algorithmic computation speed.',
                  'This metric offers a competitive advantage on terms of algorithmic computation speed.',
                  'This metric offers a competitive advantage with terms of algorithmic computation speed.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In terms of\' adalah frase pembatas parameter performa yang tepat.',
              ],
              [
                'id' => 59,
                'id_sentence' => 'Peraturan lingkungan baru ini cukup lunak sehubungan dengan target pengurangan karbon industri.',
                'target_word' => 'in relation to industrial carbon reduction targets',
                'vocab' => [
                  'environmental regulations' => [
                    'id' => 'peraturan lingkungan',
                    'pos' => '(n phr)',
                  ],
                  'lenient' => [
                    'id' => 'lunak / longgar',
                    'pos' => '(adj)',
                  ],
                  'carbon reduction targets' => [
                    'id' => 'target pengurangan karbon',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The new environmental regulations are lenient in relation to industrial carbon reduction targets.',
                  'The new environmental regulations are lenient in relation with industrial carbon reduction targets.',
                  'The new environmental regulations are lenient with relation to industrial carbon reduction targets.',
                  'The new environmental regulations are lenient on relation to industrial carbon reduction targets.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In relation to\' menghubungkan status kelonggaran aturan dengan target industri.',
              ],
              [
                'id' => 60,
                'id_sentence' => 'Data dikodekan ulang untuk tujuan mempermudah komparasi statistik multivariat.',
                'target_word' => 'for the purpose of facilitating',
                'vocab' => [
                  'recode' => [
                    'id' => 'mengodekan ulang',
                    'pos' => '(v)',
                  ],
                  'multivariate statistical comparison' => [
                    'id' => 'komparasi statistik multivariat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Raw indicators are recoded for the purpose of facilitating multivariate statistical comparisons.',
                  'Raw indicators are recoded for the purpose to facilitate multivariate statistical comparisons.',
                  'Raw indicators are recoded with the purpose of facilitate multivariate statistical comparisons.',
                  'Raw indicators are recoded for purpose of facilitating multivariate statistical comparisons.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa tujuan akademik: \'for the purpose of\' + Gerund \'facilitating\'.',
              ],
            ],
          ],
          [
            'id' => 'prep_fronting',
            'name' => 'Sentence-Initial Fronting of Prepositional Phrases (In [Context], S + V)',
            'code' => '1.5.7',
            'concept_title' => 'Pembalikan Posisi Awal Frase Preposisi (Fronting & Punctuation Logic)',
            'concept_description' => 'Dalam penulisan esai akademik berperingkat tinggi, memindahkan frase preposisi ke awal kalimat (Sentence-Initial Fronting) berfungsi untuk menetapkan konteks pembuka (Theme-Rheme dynamics), menghindari kebosanan struktur \'Subject + Verb\' yang monoton, dan menciptakan transisi yang kohesif antar-paragraf. Aturan tanda baca mutlak: frase preposisi pembuka kalimat WAJIB dipisahkan dengan tanda koma ( , ) sebelum subjek utama muncul.',
            'formula' => 'Prepositional Phrase (Context/Setting) + COMMA ( , ) + Subject + Verb + Object',
            'rules' => [
              'Wajib menyisipkan tanda koma tepat setelah frase preposisi pembuka kalimat.',
              'Frase preposisi tidak dapat bertindak sebagai subjek kalimat (harus ada subjek independen setelah koma).',
              'Gunakan fronting untuk memandu pembaca ke lokasi, kerangka waktu, atau landasan teoretis sebelum klaim inti.',
              'Hindari menumpuk lebih dari dua frase preposisi di posisi awal agar kalimat tetap terbaca jernih.',
            ],
            'exercises' => [
              [
                'id' => 61,
                'id_sentence' => 'Di banyak negara berkembang, infrastruktur transportasi umum tetap tidak memadai.',
                'target_word' => 'In many developing nations,',
                'vocab' => [
                  'developing nations' => [
                    'id' => 'negara berkembang',
                    'pos' => '(n phr)',
                  ],
                  'public transit infrastructure' => [
                    'id' => 'infrastruktur transportasi umum',
                    'pos' => '(n phr)',
                  ],
                  'inadequate' => [
                    'id' => 'tidak memadai',
                    'pos' => '(adj)',
                  ],
                ],
                'options' => [
                  'In many developing nations, public transit infrastructure remains critically inadequate.',
                  'In many developing nations public transit infrastructure remains critically inadequate.',
                  'On many developing nations, public transit infrastructure remains critically inadequate.',
                  'At many developing nations, public transit infrastructure remains critically inadequate.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase preposisi pembuka \'In many developing nations\' WAJIB diikuti tanda koma sebelum subjek \'public transit infrastructure\'.',
              ],
              [
                'id' => 62,
                'id_sentence' => 'Sepanjang dekade terakhir, investasi energi surya tumbuh secara eksponensial di seluruh dunia.',
                'target_word' => 'Throughout the past decade,',
                'vocab' => [
                  'past decade' => [
                    'id' => 'dekade terakhir',
                    'pos' => '(n phr)',
                  ],
                  'solar capital investment' => [
                    'id' => 'investasi modal surya',
                    'pos' => '(n phr)',
                  ],
                  'grow exponentially' => [
                    'id' => 'tumbuh secara eksponensial',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Throughout the past decade, solar capital investment expands exponentially across the globe.',
                  'Throughout the past decade solar capital investment expands exponentially across the globe.',
                  'During the past decade solar capital investment expands exponentially across the globe.',
                  'Within the past decade solar capital investment expands exponentially across the globe.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase preposisi waktu di awal kalimat memerlukan tanda koma pemisah.',
              ],
              [
                'id' => 63,
                'id_sentence' => 'Di bawah kondisi tekanan atmosfer tinggi, gas mulia mengembun menjadi cairan transparan.',
                'target_word' => 'Under high atmospheric pressure conditions,',
                'vocab' => [
                  'atmospheric pressure' => [
                    'id' => 'tekanan atmosfer',
                    'pos' => '(n phr)',
                  ],
                  'noble gases' => [
                    'id' => 'gas mulia',
                    'pos' => '(n phr)',
                  ],
                  'condense' => [
                    'id' => 'mengembun',
                    'pos' => '(v)',
                  ],
                ],
                'options' => [
                  'Under high atmospheric pressure conditions, noble gases condense into a transparent fluid.',
                  'Under high atmospheric pressure conditions noble gases condense into a transparent fluid.',
                  'In high atmospheric pressure conditions noble gases condense into a transparent fluid.',
                  'At high atmospheric pressure conditions noble gases condense into a transparent fluid.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase kondisi pembuka \'Under ... conditions,\' wajib diakhiri tanda koma.',
              ],
              [
                'id' => 64,
                'id_sentence' => 'Menurut teori pertumbuhan ekonomi endogen, inovasi teknologi mendorong produktivitas jangka panjang.',
                'target_word' => 'According to endogenous growth theory,',
                'vocab' => [
                  'endogenous growth theory' => [
                    'id' => 'teori pertumbuhan endogen',
                    'pos' => '(n phr)',
                  ],
                  'technological innovation' => [
                    'id' => 'inovasi teknologi',
                    'pos' => '(n phr)',
                  ],
                  'drive productivity' => [
                    'id' => 'mendorong produktivitas',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'According to endogenous growth theory, technological innovation drives long-term productivity.',
                  'According to endogenous growth theory technological innovation drives long-term productivity.',
                  'Based to endogenous growth theory, technological innovation drives long-term productivity.',
                  'According with endogenous growth theory, technological innovation drives long-term productivity.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa atribusi teori pembuka \'According to endogenous growth theory,\' wajib diikuti tanda koma.',
              ],
              [
                'id' => 65,
                'id_sentence' => 'Dalam hal kepatuhan regulasi lingkungan, fasilitas manufaktur baru ini memenuhi semua standar internasional.',
                'target_word' => 'In terms of environmental compliance,',
                'vocab' => [
                  'environmental compliance' => [
                    'id' => 'kepatuhan lingkungan',
                    'pos' => '(n phr)',
                  ],
                  'manufacturing facility' => [
                    'id' => 'fasilitas manufaktur',
                    'pos' => '(n phr)',
                  ],
                  'international benchmarks' => [
                    'id' => 'standar internasional',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'In terms of environmental compliance, this new manufacturing facility satisfies all international benchmarks.',
                  'In terms of environmental compliance this new manufacturing facility satisfies all international benchmarks.',
                  'In terms to environmental compliance, this new manufacturing facility satisfies all international benchmarks.',
                  'With terms of environmental compliance, this new manufacturing facility satisfies all international benchmarks.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In terms of environmental compliance,\' di posisi awal kalimat memerlukan koma.',
              ],
              [
                'id' => 66,
                'id_sentence' => 'Pada fase awal uji klinis, para dokter memantau respons fisiologis partisipan secara terus-menerus.',
                'target_word' => 'In the preliminary phase of the trial,',
                'vocab' => [
                  'preliminary phase' => [
                    'id' => 'fase awal',
                    'pos' => '(n phr)',
                  ],
                  'clinicians' => [
                    'id' => 'para dokter klinis',
                    'pos' => '(n)',
                  ],
                  'monitor physiological responses' => [
                    'id' => 'memantau respons fisiologis',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'In the preliminary phase of the clinical trial, clinicians monitor physiological responses continuously.',
                  'In the preliminary phase of the clinical trial clinicians monitor physiological responses continuously.',
                  'At the preliminary phase of the clinical trial, clinicians monitor physiological responses continuously.',
                  'On the preliminary phase of the clinical trial, clinicians monitor physiological responses continuously.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase preposisi temporal majemuk di awal kalimat memerlukan tanda koma.',
              ],
              [
                'id' => 67,
                'id_sentence' => 'Karena volatilitas nilai tukar mata uang asing, margin laba importir menyusut tajam.',
                'target_word' => 'Due to foreign exchange volatility,',
                'vocab' => [
                  'foreign exchange volatility' => [
                    'id' => 'volatilitas valuta asing',
                    'pos' => '(n phr)',
                  ],
                  'importers\' profit margins' => [
                    'id' => 'margin laba importir',
                    'pos' => '(n phr)',
                  ],
                  'contract sharply' => [
                    'id' => 'menyusut tajam',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Due to foreign exchange volatility, importers\' profit margins contract sharply.',
                  'Due to foreign exchange volatility importers\' profit margins contract sharply.',
                  'Owing that foreign exchange volatility, importers\' profit margins contract sharply.',
                  'Because foreign exchange volatility, importers\' profit margins contract sharply.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase kausal \'Due to foreign exchange volatility,\' di awal kalimat wajib memakai koma.',
              ],
              [
                'id' => 68,
                'id_sentence' => 'Tanpa verifikasi data independen, kesimpulan makalah ilmiah tersebut tetap diragukan.',
                'target_word' => 'Without independent data verification,',
                'vocab' => [
                  'independent data verification' => [
                    'id' => 'verifikasi data independen',
                    'pos' => '(n phr)',
                  ],
                  'conclusions' => [
                    'id' => 'kesimpulan',
                    'pos' => '(n, plural)',
                  ],
                  'remain questionable' => [
                    'id' => 'tetap diragukan',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Without independent data verification, the conclusions of the treatise remain questionable.',
                  'Without independent data verification the conclusions of the treatise remain questionable.',
                  'Except independent data verification, the conclusions of the treatise remain questionable.',
                  'Apart independent data verification, the conclusions of the treatise remain questionable.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi negatif \'Without + Noun Phrase,\' di posisi pembuka membutuhkan koma.',
              ],
              [
                'id' => 69,
                'id_sentence' => 'Berkenaan dengan keakuratan metode prediksi, model statistik kedua mengungguli model pertama.',
                'target_word' => 'With respect to predictive accuracy,',
                'vocab' => [
                  'predictive accuracy' => [
                    'id' => 'keakuratan prediksi',
                    'pos' => '(n phr)',
                  ],
                  'statistical model' => [
                    'id' => 'model statistik',
                    'pos' => '(n phr)',
                  ],
                  'outperform' => [
                    'id' => 'mengungguli',
                    'pos' => '(v)',
                  ],
                ],
                'options' => [
                  'With respect to predictive accuracy, the secondary statistical model outperforms the primary one.',
                  'With respect to predictive accuracy the secondary statistical model outperforms the primary one.',
                  'With respect of predictive accuracy, the secondary statistical model outperforms the primary one.',
                  'In respect with predictive accuracy, the secondary statistical model outperforms the primary one.',
                ],
                'correct_index' => 0,
                'explanation' => '\'With respect to predictive accuracy,\' di depan kalimat memerlukan tanda koma.',
              ],
              [
                'id' => 70,
                'id_sentence' => 'Melalui analisis spektroskopi inframerah lanjutan, para peneliti mengidentifikasi gugus fungsi polimer.',
                'target_word' => 'Through advanced infrared spectroscopy,',
                'vocab' => [
                  'infrared spectroscopy' => [
                    'id' => 'spektroskopi inframerah',
                    'pos' => '(n phr)',
                  ],
                  'functional groups' => [
                    'id' => 'gugus fungsi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Through advanced infrared spectroscopy, researchers identify polymer functional groups accurately.',
                  'Through advanced infrared spectroscopy researchers identify polymer functional groups accurately.',
                  'By means advanced infrared spectroscopy, researchers identify polymer functional groups accurately.',
                  'Via advanced infrared spectroscopy researchers identify polymer functional groups accurately.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase instrumental pembuka kalimat \'Through advanced infrared spectroscopy,\' wajib diikuti koma.',
              ],
            ],
          ],
          [
            'id' => 'prep_stacking',
            'name' => 'Multi-Prepositional Phrase Stacking in Academic Prose',
            'code' => '1.5.8',
            'concept_title' => 'Sintesis Penumpukan Frase Preposisi Majemuk dalam Kalimat Ilmiah',
            'concept_description' => 'Dalam penulisan naskah akademik (publikasi jurnal internasional, tesis, dan laporan teknis), penulis sering kali perlu merangkai beberapa frase preposisi (Prepositional Stacking) untuk merinci metode, instrumen, lokasi, dan batas waktu dalam satu klausa padat. Urutan alami yang dianjurkan untuk meminimalkan ambiguitas modifikasi adalah: [Klausa Inti: S + V + O] + [Frase Instrumen/Metode] + [Frase Lokasi/Setting] + [Frase Waktu/Kondisi].',
            'formula' => 'Subject + Verb + Object + [by / through Instrument] + [in / at Location] + [during / under Conditions]',
            'rules' => [
              'Pastikan setiap frase preposisi menempel pada kata benda atau kata kerja yang tepat (hindari dangling modifiers).',
              'Urutan hierarkis alami: Manner/Instrument (by/through) -> Place/Location (in/at) -> Time/Condition (during/under).',
              'Jangan menyisipkan tanda koma jika penumpukan frase preposisi berada di akhir kalimat dan memodifikasi predikat secara esensial.',
              'Kombinasi sintaksis ini memaksimalkan lexical density dan kecanggihan struktur tulisan.',
            ],
            'exercises' => [
              [
                'id' => 71,
                'id_sentence' => 'Para peneliti mengukur emisi gas buang melalui penganalisis portabel di lokasi konstruksi perkotaan selama jam sibuk.',
                'target_word' => 'through portable analyzers at urban construction sites during peak hours',
                'vocab' => [
                  'exhaust emissions' => [
                    'id' => 'emisi gas buang',
                    'pos' => '(n phr)',
                  ],
                  'portable analyzers' => [
                    'id' => 'penganalisis portabel',
                    'pos' => '(n phr)',
                  ],
                  'construction sites' => [
                    'id' => 'lokasi konstruksi',
                    'pos' => '(n phr)',
                  ],
                  'peak hours' => [
                    'id' => 'jam sibuk',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Researchers measure exhaust emissions through portable analyzers at urban construction sites during peak hours.',
                  'Researchers measure exhaust emissions by portable analyzers in urban construction sites while peak hours.',
                  'Researchers measure exhaust emissions through portable analyzers on urban construction sites during peak hours.',
                  'Researchers measure exhaust emissions with portable analyzers into urban construction sites within peak hours.',
                ],
                'correct_index' => 0,
                'explanation' => 'Penumpukan tiga frase preposisi: \'through portable analyzers\' (metode) + \'at urban construction sites\' (lokasi) + \'during peak hours\' (waktu).',
              ],
              [
                'id' => 72,
                'id_sentence' => 'Insinyur mengevaluasi integritas struktural jembatan dengan sensor akustik nirkabel di bawah kondisi beban dinamis.',
                'target_word' => 'with wireless acoustic sensors under dynamic load conditions',
                'vocab' => [
                  'structural integrity' => [
                    'id' => 'integritas struktural',
                    'pos' => '(n phr)',
                  ],
                  'wireless sensors' => [
                    'id' => 'sensor nirkabel',
                    'pos' => '(n phr)',
                  ],
                  'dynamic load conditions' => [
                    'id' => 'kondisi beban dinamis',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Engineers evaluate bridge structural integrity using wireless acoustic sensors under dynamic load conditions.',
                  'Engineers evaluate bridge structural integrity using wireless acoustic sensors beneath dynamic load conditions.',
                  'Engineers evaluate bridge structural integrity using wireless acoustic sensors at dynamic load conditions.',
                  'Engineers evaluate bridge structural integrity using wireless acoustic sensors through dynamic load conditions.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kombinasi instrumen teknis dan kondisi eksperimen: \'under dynamic load conditions\'.',
              ],
              [
                'id' => 73,
                'id_sentence' => 'Ahli meteorologi memantau badai tropis melalui citra satelit resolusi tinggi di wilayah Pasifik barat daya.',
                'target_word' => 'via high-resolution satellite imagery in the southwestern Pacific',
                'vocab' => [
                  'tropical cyclones' => [
                    'id' => 'badai tropis',
                    'pos' => '(n phr)',
                  ],
                  'satellite imagery' => [
                    'id' => 'citra satelit',
                    'pos' => '(n phr)',
                  ],
                  'southwestern Pacific' => [
                    'id' => 'Pasifik barat daya',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Meteorologists monitor tropical cyclones via high-resolution satellite imagery in the southwestern Pacific region.',
                  'Meteorologists monitor tropical cyclones by high-resolution satellite imagery on the southwestern Pacific region.',
                  'Meteorologists monitor tropical cyclones with high-resolution satellite imagery at the southwestern Pacific region.',
                  'Meteorologists monitor tropical cyclones through high-resolution satellite imagery onto the southwestern Pacific region.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kombinasi kanal transmisi data (\'via satellite imagery\') dan wilayah spasial (\'in the southwestern Pacific region\').',
              ],
              [
                'id' => 74,
                'id_sentence' => 'Bakteri mempertahankan homeostasis seluler melalui pompa ion membran di bawah tekanan osmotik tinggi.',
                'target_word' => 'through membrane ion pumps under severe osmotic stress',
                'vocab' => [
                  'cellular homeostasis' => [
                    'id' => 'homeostasis seluler',
                    'pos' => '(n phr)',
                  ],
                  'membrane ion pumps' => [
                    'id' => 'pompa ion membran',
                    'pos' => '(n phr)',
                  ],
                  'severe osmotic stress' => [
                    'id' => 'tekanan osmotik tinggi',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Bacteria maintain cellular homeostasis through membrane ion pumps under severe osmotic stress.',
                  'Bacteria maintain cellular homeostasis by membrane ion pumps during severe osmotic stress.',
                  'Bacteria maintain cellular homeostasis with membrane ion pumps inside severe osmotic stress.',
                  'Bacteria maintain cellular homeostasis via membrane ion pumps beneath severe osmotic stress.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Through membrane ion pumps\' (mekanisme) + \'under severe osmotic stress\' (kondisi biologis).',
              ],
              [
                'id' => 75,
                'id_sentence' => 'Data dikumpulkan dari kuesioner daring di sepuluh universitas terkemuka selama semester musim gugur.',
                'target_word' => 'from online questionnaires across ten leading universities during the fall semester',
                'vocab' => [
                  'online questionnaires' => [
                    'id' => 'kuesioner daring',
                    'pos' => '(n phr)',
                  ],
                  'leading universities' => [
                    'id' => 'universitas terkemuka',
                    'pos' => '(n phr)',
                  ],
                  'fall semester' => [
                    'id' => 'semester musim gugur',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Data are collected from online questionnaires across ten leading universities during the fall semester.',
                  'Data are collected of online questionnaires in ten leading universities throughout the fall semester.',
                  'Data are collected by online questionnaires at ten leading universities within the fall semester.',
                  'Data are collected through online questionnaires onto ten leading universities during the fall semester.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tiga frase preposisi berturut-turut: sumber (\'from online questionnaires\') + distribusi spasial (\'across ten universities\') + waktu (\'during the fall semester\').',
              ],
              [
                'id' => 76,
                'id_sentence' => 'Spesimen mengalami dekomposisi enzimatik yang cepat di dalam ruang inkubasi steril pada suhu tiga puluh tujuh derajat.',
                'target_word' => 'within sterile incubation chambers at thirty-seven degrees',
                'vocab' => [
                  'enzymatic decomposition' => [
                    'id' => 'dekomposisi enzimatik',
                    'pos' => '(n phr)',
                  ],
                  'incubation chambers' => [
                    'id' => 'ruang inkubasi',
                    'pos' => '(n phr)',
                  ],
                  'thirty-seven degrees' => [
                    'id' => 'tiga puluh tujuh derajat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Specimens undergo rapid enzymatic decomposition within sterile incubation chambers at thirty-seven degrees.',
                  'Specimens undergo rapid enzymatic decomposition inside sterile incubation chambers in thirty-seven degrees.',
                  'Specimens undergo rapid enzymatic decomposition into sterile incubation chambers on thirty-seven degrees.',
                  'Specimens undergo rapid enzymatic decomposition across sterile incubation chambers with thirty-seven degrees.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Within incubation chambers\' (ruang lingkup tertutup) + \'at thirty-seven degrees\' (suhu spesifik).',
              ],
              [
                'id' => 77,
                'id_sentence' => 'Petugas bea cukai memeriksa kargo kontainer menggunakan pemindai radiasi sinar-X di pelabuhan laut utama.',
                'target_word' => 'with high-energy X-ray scanners at major maritime ports',
                'vocab' => [
                  'containerized cargo' => [
                    'id' => 'kargo kontainer',
                    'pos' => '(n phr)',
                  ],
                  'X-ray scanners' => [
                    'id' => 'pemindai sinar-X',
                    'pos' => '(n phr)',
                  ],
                  'maritime ports' => [
                    'id' => 'pelabuhan laut',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Customs inspectors inspect containerized cargo using high-energy X-ray scanners at major maritime ports.',
                  'Customs inspectors inspect containerized cargo using high-energy X-ray scanners in major maritime ports.',
                  'Customs inspectors inspect containerized cargo using high-energy X-ray scanners on major maritime ports.',
                  'Customs inspectors inspect containerized cargo using high-energy X-ray scanners through major maritime ports.',
                ],
                'correct_index' => 0,
                'explanation' => '\'At major maritime ports\' melengkapi instrumen teknologi dalam mendeskripsikan aktivitas prosedural.',
              ],
              [
                'id' => 78,
                'id_sentence' => 'Pasien menerima terapi cairan intravena melalui pompa infus terprogram di unit perawatan intensif.',
                'target_word' => 'via programmed infusion pumps in intensive care units',
                'vocab' => [
                  'intravenous hydration' => [
                    'id' => 'hidrasi intravena',
                    'pos' => '(n phr)',
                  ],
                  'infusion pumps' => [
                    'id' => 'pompa infus',
                    'pos' => '(n phr)',
                  ],
                  'intensive care units' => [
                    'id' => 'unit perawatan intensif',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Patients receive intravenous hydration therapy via programmed infusion pumps in intensive care units.',
                  'Patients receive intravenous hydration therapy by programmed infusion pumps at intensive care units.',
                  'Patients receive intravenous hydration therapy with programmed infusion pumps onto intensive care units.',
                  'Patients receive intravenous hydration therapy through programmed infusion pumps across intensive care units.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Via programmed infusion pumps\' (saluran medis) + \'in intensive care units\' (lingkungan medis).',
              ],
              [
                'id' => 79,
                'id_sentence' => 'Senyawa volatil menguap secara bertahap dari permukaan daun di bawah paparan sinar matahari terik.',
                'target_word' => 'from foliar surfaces under intense solar radiation',
                'vocab' => [
                  'volatile organic compounds' => [
                    'id' => 'senyawa organik volatil',
                    'pos' => '(n phr)',
                  ],
                  'evaporate' => [
                    'id' => 'menguap',
                    'pos' => '(v)',
                  ],
                  'foliar surfaces' => [
                    'id' => 'permukaan daun',
                    'pos' => '(n phr)',
                  ],
                  'solar radiation' => [
                    'id' => 'radiasi matahari',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Volatile organic compounds evaporate gradually from foliar surfaces under intense solar radiation.',
                  'Volatile organic compounds evaporate gradually out of foliar surfaces during intense solar radiation.',
                  'Volatile organic compounds evaporate gradually off foliar surfaces beneath intense solar radiation.',
                  'Volatile organic compounds evaporate gradually through foliar surfaces within intense solar radiation.',
                ],
                'correct_index' => 0,
                'explanation' => '\'From foliar surfaces\' (titik asal) + \'under intense solar radiation\' (kondisi paparan lingkungan).',
              ],
              [
                'id' => 80,
                'id_sentence' => 'Algoritma memproses transaksi keuangan secara aman melalui protokol kriptografi terdistribusi dalam hitungan milidetik.',
                'target_word' => 'through distributed cryptographic protocols within milliseconds',
                'vocab' => [
                  'financial transactions' => [
                    'id' => 'transaksi keuangan',
                    'pos' => '(n phr)',
                  ],
                  'cryptographic protocols' => [
                    'id' => 'protokol kriptografi',
                    'pos' => '(n phr)',
                  ],
                  'milliseconds' => [
                    'id' => 'milidetik',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The algorithm processes financial transactions securely through distributed cryptographic protocols within milliseconds.',
                  'The algorithm processes financial transactions securely by distributed cryptographic protocols during milliseconds.',
                  'The algorithm processes financial transactions securely with distributed cryptographic protocols throughout milliseconds.',
                  'The algorithm processes financial transactions securely via distributed cryptographic protocols inside milliseconds.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kombinasi metode komputasi \'through distributed cryptographic protocols\' dan batasan waktu presisi \'within milliseconds\'.',
              ],
            ],
          ],
        ];
    }
}
