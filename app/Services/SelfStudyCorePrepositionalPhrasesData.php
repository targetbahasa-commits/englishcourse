<?php

namespace App\Services;

class SelfStudyCorePrepositionalPhrasesData
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
            'banner_subtitle' => 'Kuasai penggunaan frase preposisi penunjuk lokasi, waktu, cara, sebab-akibat, sumber informasi, dan cakupan topik dalam percakapan dan tulisan sehari-hari.',
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
            'concept_title' => 'Anatomi & Fungsi Frase Preposisi dalam Kalimat Sehari-hari',
            'concept_summary' => 'Frase preposisi (Prepositional Phrase) adalah konstruksi yang dibentuk oleh Preposisi diikuti Objek Preposisi (Noun Phrase, Pronoun, atau Gerund V-ing). Dalam percakapan dan tulisan sehari-hari, frase preposisi membantu kita menjelaskan lokasi, waktu, cara melakukan sesuatu, alasan, sumber informasi, dan topik yang sedang dibahas secara ringkas dan jelas.',
            'rules' => [
                [
                    'rule_title' => '1. Struktur Dasar: Preposition + Object of Preposition',
                    'rule_formula' => 'Preposition (in, at, on, by, through, during) + Noun Phrase / Gerund (V-ing)',
                    'rule_description' => 'Objek preposisi WAJIB berupa kata benda, frasa kata benda, atau gerund. Dilarang meletakkan kata kerja berkonjugasi (finite verb) langsung setelah preposisi.',
                    'examples' => [
                        [
                            'en' => 'We met our friends at the park during the weekend.',
                            'id' => 'Kami bertemu teman-teman kami di taman selama akhir pekan.',
                            'note' => 'Dua frase preposisi memodifikasi verba "met": lokasi (at...) dan waktu (during...).'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Sentence-Initial Fronting & Punctuation Logic',
                    'rule_formula' => 'Prepositional Phrase (Context) + COMMA ( , ) + Subject + Verb + Object',
                    'rule_description' => 'Memindahkan frase preposisi ke awal kalimat (fronting) berfungsi untuk menetapkan konteks sebelum inti kalimat diutarakan. Frase preposisi pembuka kalimat WAJIB dipisahkan dengan tanda koma.',
                    'examples' => [
                        [
                            'en' => 'In my neighborhood, most people walk to the market every morning.',
                            'id' => 'Di lingkungan rumah saya, kebanyakan orang berjalan kaki ke pasar setiap pagi.',
                            'note' => 'Tanda koma setelah "neighborhood" mutlak diperlukan.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Preposisi Sebab-Akibat: due to vs because',
                    'rule_formula' => 'Clause + due to / owing to / as a result of + Noun Phrase (Bukan Klausa Berpredikat)',
                    'rule_description' => '"Due to" dan "owing to" adalah preposisi, sehingga WAJIB diikuti kata benda atau frasa benda. Jangan gunakan "due to" jika diikuti kalimat lengkap (S + V).',
                    'examples' => [
                        [
                            'en' => 'The picnic was postponed due to heavy rain.',
                            'id' => 'Piknik itu ditunda akibat hujan deras.',
                            'note' => 'Diikuti Noun Phrase "heavy rain".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Multi-Prepositional Stacking Hierarchy',
                    'rule_formula' => 'Clause + [Method/Instrument] + [Location/Setting] + [Time/Conditions]',
                    'rule_description' => 'Ketika menumpuk beberapa frase preposisi di akhir kalimat, gunakan urutan alami untuk menghindari kesalahpahaman: cara/alat, lalu tempat, lalu waktu.',
                    'examples' => [
                        [
                            'en' => 'She cooked dinner by following a recipe in the kitchen during the evening.',
                            'id' => 'Ia memasak makan malam dengan mengikuti resep di dapur pada malam hari.',
                            'note' => 'Urutan: Cara (by...) -> Lokasi (in...) -> Waktu (during...).'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Kategori Preposisi', 'Preposisi Standar', 'Fungsi dalam Kalimat Sehari-hari', 'Contoh Kalimat'],
                'rows' => [
                    ['Spasial / Lokasi', 'in, at, on', 'Menjelaskan tempat suatu kejadian berlangsung', 'We met at the bus stop.'],
                    ['Temporal / Waktu', 'during, throughout, within', 'Menandai durasi, rentang waktu, atau batas waktu', 'We stayed throughout the show.'],
                    ['Cara / Instrumen', 'by (V-ing), through, via', 'Menjelaskan cara atau sarana melakukan sesuatu', 'She found the address via a map app.'],
                    ['Sebab / Alasan', 'due to, owing to, as a result of', 'Menjelaskan alasan atau penyebab singkat', 'The game was canceled due to rain.'],
                    ['Lingkup & Topik', 'in terms of, with respect to', 'Membatasi topik atau sudut pandang yang dibahas', 'It is good in terms of price.'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The trip was canceled because of it rained all day.',
                    'correct' => 'The trip was canceled because it rained all day. (atau: due to the rain)',
                    'explanation' => 'Preposisi "because of" wajib diikuti frasa benda, bukan klausa lengkap dengan predikat (rained).'
                ],
                [
                    'incorrect' => 'In my hometown people are very friendly.',
                    'correct' => 'In my hometown, people are very friendly.',
                    'explanation' => 'Missing Comma: Frase preposisi di awal kalimat wajib diakhiri tanda koma pemisah.'
                ],
                [
                    'incorrect' => 'We solved the problem with using a calculator.',
                    'correct' => 'We solved the problem by using a calculator. (atau: through a calculator)',
                    'explanation' => 'Cara melakukan sesuatu berpasangan dengan "by + Gerund", bukan "with using".'
                ],
                [
                    'incorrect' => 'According to me, this restaurant is the best in town.',
                    'correct' => 'In my opinion, this restaurant is the best in town. (atau: I think this restaurant is the best in town.)',
                    'explanation' => '"According to" dipakai untuk merujuk sumber LUAR (orang lain, laporan), bukan pendapat diri sendiri — gunakan "in my opinion" untuk itu.'
                ],
            ],
            'exam_tips' => [
                'Variasikan posisi frase preposisi (awal kalimat dengan koma vs akhir kalimat tanpa koma) agar tulisanmu tidak monoton.',
                'Periksa setiap preposisi agar selalu diikuti Noun Phrase atau Gerund, bukan finite verb.',
                'Gunakan frase preposisi seperti "in terms of", "with respect to", dan "through" untuk membuat kalimat lebih variatif dan jelas.'
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
            'name' => 'Prepositional Phrases of Location & Everyday Places (in, at, on)',
            'code' => '1.5.1',
            'concept_title' => 'Frase Preposisi Penunjuk Lokasi dan Tempat Sehari-hari',
            'concept_description' => 'Frase preposisi lokasi menjelaskan tempat suatu kejadian berlangsung. Rumus dasarnya adalah Preposisi (in, at, on) + Object of Preposition (Noun Phrase). Gunakan \'in\' untuk ruangan/wilayah luas (in the kitchen, in the city), \'at\' untuk titik spesifik atau tempat umum (at the bus stop, at school), dan \'on\' untuk permukaan (on the table, on the wall).',
            'formula' => 'Clause + IN / AT / ON + Spatial Noun Phrase',
            'rules' => [
              'Frase preposisi terdiri atas preposisi diikuti kata benda (Object of Preposition).',
              'Dilarang meletakkan kata kerja berkonjugasi langsung setelah preposisi (preposisi diikuti Noun / Gerund V-ing).',
              'Gunakan \'in\' untuk ruangan, kota, negara, dan wilayah yang dianggap seperti wadah.',
              'Gunakan \'at\' untuk titik tertentu dan tempat umum seperti sekolah, stasiun, atau toko.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Ibu sedang memasak sup ayam di dapur sore ini.',
                'target_word' => 'in the kitchen',
                'vocab' => [
                  'Mom' => [
                    'id' => 'Ibu',
                    'pos' => '(n)',
                  ],
                  'chicken soup' => [
                    'id' => 'sup ayam',
                    'pos' => '(n phr)',
                  ],
                  'kitchen' => [
                    'id' => 'dapur',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'Mom is cooking chicken soup in the kitchen this afternoon.',
                  'Mom is cooking chicken soup at the kitchen this afternoon.',
                  'Mom is cooking chicken soup on the kitchen this afternoon.',
                  'Mom is cooking chicken soup into the kitchen this afternoon.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk ruangan tertutup seperti dapur, preposisi spasial yang tepat adalah \'in\'.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Kami menunggu bus sekolah di halte dekat rumah.',
                'target_word' => 'at the bus stop',
                'vocab' => [
                  'wait for the school bus' => [
                    'id' => 'menunggu bus sekolah',
                    'pos' => '(v phr)',
                  ],
                  'bus stop' => [
                    'id' => 'halte bus',
                    'pos' => '(n phr)',
                  ],
                  'near the house' => [
                    'id' => 'dekat rumah',
                    'pos' => '(prep phr)',
                  ],
                ],
                'options' => [
                  'We wait for the school bus at the bus stop near the house.',
                  'We wait for the school bus on the bus stop near the house.',
                  'We wait for the school bus in the bus stop near the house.',
                  'We wait for the school bus into the bus stop near the house.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk tempat umum spesifik seperti halte, preposisi lokasi yang tepat adalah \'at\'.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Buku catatan matematika itu tergeletak di atas meja belajar.',
                'target_word' => 'on the study desk',
                'vocab' => [
                  'math notebook' => [
                    'id' => 'buku catatan matematika',
                    'pos' => '(n phr)',
                  ],
                  'lies' => [
                    'id' => 'tergeletak',
                    'pos' => '(v)',
                  ],
                  'study desk' => [
                    'id' => 'meja belajar',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The math notebook lies on the study desk.',
                  'The math notebook lies in the study desk.',
                  'The math notebook lies at the study desk.',
                  'The math notebook lies through the study desk.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk benda yang berada di atas permukaan datar, preposisi baku yang digunakan adalah \'on\' (\'on the desk\').',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Antrean mengular terlihat di pintu masuk bioskop yang ramai.',
                'target_word' => 'at the crowded cinema entrance',
                'vocab' => [
                  'long queue' => [
                    'id' => 'antrean mengular',
                    'pos' => '(n phr)',
                  ],
                  'visible' => [
                    'id' => 'terlihat',
                    'pos' => '(adj)',
                  ],
                  'cinema entrance' => [
                    'id' => 'pintu masuk bioskop',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'A long queue is visible at the crowded cinema entrance.',
                  'A long queue is visible on the crowded cinema entrance.',
                  'A long queue is visible to the crowded cinema entrance.',
                  'A long queue is visible by the crowded cinema entrance.',
                ],
                'correct_index' => 0,
                'explanation' => 'Titik tertentu seperti pintu masuk adalah titik acuan spesifik yang menggunakan preposisi \'at\'.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Kucing itu tidur dengan nyaman di dasar keranjang pakaian.',
                'target_word' => 'at the bottom of the laundry basket',
                'vocab' => [
                  'the cat' => [
                    'id' => 'kucing itu',
                    'pos' => '(n phr)',
                  ],
                  'sleeps comfortably' => [
                    'id' => 'tidur dengan nyaman',
                    'pos' => '(v phr)',
                  ],
                  'laundry basket' => [
                    'id' => 'keranjang pakaian',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The cat sleeps comfortably at the bottom of the laundry basket.',
                  'The cat sleeps comfortably in the bottom of the laundry basket.',
                  'The cat sleeps comfortably on the bottom of the laundry basket.',
                  'The cat sleeps comfortably toward the bottom of the laundry basket.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa posisi titik dasar menggunakan kolokasi preposisi \'at the bottom of\'.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Keluarga itu tinggal di sebuah desa kecil di pegunungan yang terpencil.',
                'target_word' => 'in a remote mountain village',
                'vocab' => [
                  'the family' => [
                    'id' => 'keluarga itu',
                    'pos' => '(n phr)',
                  ],
                  'lives' => [
                    'id' => 'tinggal',
                    'pos' => '(v)',
                  ],
                  'remote mountain village' => [
                    'id' => 'desa pegunungan terpencil',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The family lives in a remote mountain village.',
                  'The family lives at a remote mountain village.',
                  'The family lives on a remote mountain village.',
                  'The family lives by a remote mountain village.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk wilayah geografis seperti desa, preposisi yang benar adalah \'in\'.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Poster film kesayangan Kakak tertempel di dinding kamarnya.',
                'target_word' => 'on the wall of her room',
                'vocab' => [
                  'favorite movie poster' => [
                    'id' => 'poster film kesayangan',
                    'pos' => '(n phr)',
                  ],
                  'wall' => [
                    'id' => 'dinding',
                    'pos' => '(n)',
                  ],
                  'her room' => [
                    'id' => 'kamarnya',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'My sister\'s favorite movie poster hangs on the wall of her room.',
                  'My sister\'s favorite movie poster hangs in the wall of her room.',
                  'My sister\'s favorite movie poster hangs at the wall of her room.',
                  'My sister\'s favorite movie poster hangs across the wall of her room.',
                ],
                'correct_index' => 0,
                'explanation' => 'Menempel pada dinding permukaan vertikal menggunakan preposisi \'on\' (\'on the wall\').',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Pertandingan sepak bola itu berlangsung di lapangan sekolah pada sore hari.',
                'target_word' => 'at the school field',
                'vocab' => [
                  'football match' => [
                    'id' => 'pertandingan sepak bola',
                    'pos' => '(n phr)',
                  ],
                  'takes place' => [
                    'id' => 'berlangsung',
                    'pos' => '(v)',
                  ],
                  'school field' => [
                    'id' => 'lapangan sekolah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The football match takes place at the school field.',
                  'The football match takes place in the school field.',
                  'The football match takes place on the school field.',
                  'The football match takes place with the school field.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tempat kegiatan tertentu seperti lapangan sekolah wajib menggunakan preposisi \'at\'.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Ikan-ikan warna-warni itu banyak ditemukan di terumbu karang perairan dangkal.',
                'target_word' => 'in shallow-water coral reefs',
                'vocab' => [
                  'colorful fish' => [
                    'id' => 'ikan-ikan warna-warni',
                    'pos' => '(n phr)',
                  ],
                  'found' => [
                    'id' => 'ditemukan',
                    'pos' => '(v)',
                  ],
                  'shallow-water coral reefs' => [
                    'id' => 'terumbu karang perairan dangkal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Colorful fish are mostly found in shallow-water coral reefs.',
                  'Colorful fish are mostly found at shallow-water coral reefs.',
                  'Colorful fish are mostly found on shallow-water coral reefs.',
                  'Colorful fish are mostly found towards shallow-water coral reefs.',
                ],
                'correct_index' => 0,
                'explanation' => 'Untuk habitat atau lingkungan luas seperti terumbu karang, gunakan preposisi \'in\'.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Hiasan lampu kecil tergantung indah di ujung pohon Natal.',
                'target_word' => 'at the top of the Christmas tree',
                'vocab' => [
                  'small light decoration' => [
                    'id' => 'hiasan lampu kecil',
                    'pos' => '(n phr)',
                  ],
                  'hangs beautifully' => [
                    'id' => 'tergantung indah',
                    'pos' => '(v phr)',
                  ],
                  'top of the Christmas tree' => [
                    'id' => 'ujung pohon Natal',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'A small light decoration hangs beautifully at the top of the Christmas tree.',
                  'A small light decoration hangs beautifully in the top of the Christmas tree.',
                  'A small light decoration hangs beautifully on the top of the Christmas tree.',
                  'A small light decoration hangs beautifully by the top of the Christmas tree.',
                ],
                'correct_index' => 0,
                'explanation' => 'Titik puncak atau ujung tertentu menggunakan preposisi \'at\' (\'at the top of\').',
              ],
            ],
          ],
          [
            'id' => 'prep_time',
            'name' => 'Prepositional Phrases of Time & Daily Routines (during, throughout, within)',
            'code' => '1.5.2',
            'concept_title' => 'Frase Preposisi Penunjuk Waktu dalam Kegiatan Sehari-hari',
            'concept_description' => 'Frase preposisi temporal menjelaskan kapan suatu kegiatan berlangsung. Gunakan \'during\' untuk merujuk pada peristiwa atau periode tertentu (during the holiday), \'throughout\' untuk menekankan kesinambungan tanpa putus (throughout the trip), dan \'within\' untuk batas waktu maksimum (within an hour).',
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
                'id_sentence' => 'Kami mengunjungi banyak kota menarik selama liburan musim panas.',
                'target_word' => 'during the summer holiday',
                'vocab' => [
                  'we' => [
                    'id' => 'kami',
                    'pos' => '(pron)',
                  ],
                  'visit many interesting cities' => [
                    'id' => 'mengunjungi banyak kota menarik',
                    'pos' => '(v phr)',
                  ],
                  'summer holiday' => [
                    'id' => 'liburan musim panas',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'We visit many interesting cities during the summer holiday.',
                  'We visit many interesting cities while the summer holiday.',
                  'We visit many interesting cities throughout the summer holiday happens.',
                  'We visit many interesting cities within the summer holiday happens.',
                ],
                'correct_index' => 0,
                'explanation' => '\'During\' diikuti Noun Phrase \'the summer holiday\' untuk menunjukkan periode (\'while\' harus diikuti klausa berpredikat).',
              ],
              [
                'id' => 12,
                'id_sentence' => 'Hujan turun tanpa henti sepanjang perjalanan kami ke desa nenek.',
                'target_word' => 'throughout our trip to grandma\'s village',
                'vocab' => [
                  'rain fell nonstop' => [
                    'id' => 'hujan turun tanpa henti',
                    'pos' => '(v phr)',
                  ],
                  'our trip' => [
                    'id' => 'perjalanan kami',
                    'pos' => '(n phr)',
                  ],
                  'grandma\'s village' => [
                    'id' => 'desa nenek',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Rain fell nonstop throughout our trip to grandma\'s village.',
                  'Rain fell nonstop during our trip to grandma\'s village.',
                  'Rain fell nonstop inside our trip to grandma\'s village.',
                  'Rain fell nonstop amid our trip to grandma\'s village.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Throughout\' menekankan bahwa hujan turun secara konsisten dari awal hingga akhir perjalanan.',
              ],
              [
                'id' => 13,
                'id_sentence' => 'Kami akan menyelesaikan proyek kerajinan tangan dalam waktu dua jam.',
                'target_word' => 'within two hours',
                'vocab' => [
                  'we will finish' => [
                    'id' => 'kami akan menyelesaikan',
                    'pos' => '(v phr)',
                  ],
                  'handicraft project' => [
                    'id' => 'proyek kerajinan tangan',
                    'pos' => '(n phr)',
                  ],
                  'two hours' => [
                    'id' => 'dua jam',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'We will finish the handicraft project within two hours.',
                  'We will finish the handicraft project during two hours.',
                  'We will finish the handicraft project throughout two hours.',
                  'We will finish the handicraft project between two hours.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Within\' menyatakan batas rentang waktu penyelesaian (tidak lebih dari 2 jam).',
              ],
              [
                'id' => 14,
                'id_sentence' => 'Begitu sampai di rumah, Adik langsung berlari memeluk anjing kesayangannya.',
                'target_word' => 'Upon arriving home',
                'vocab' => [
                  'upon arriving' => [
                    'id' => 'begitu/segera setelah sampai',
                    'pos' => '(prep phr)',
                  ],
                  'my little brother' => [
                    'id' => 'Adik',
                    'pos' => '(n phr)',
                  ],
                  'ran to hug his favorite dog' => [
                    'id' => 'berlari memeluk anjing kesayangannya',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Upon arriving home, my little brother ran straight to hug his favorite dog.',
                  'During arriving home, my little brother ran straight to hug his favorite dog.',
                  'Within arriving home, my little brother ran straight to hug his favorite dog.',
                  'Throughout arriving home, my little brother ran straight to hug his favorite dog.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Upon + Gerund\' berarti \'segera setelah\' terjadinya suatu kejadian.',
              ],
              [
                'id' => 15,
                'id_sentence' => 'Adik harus istirahat total selama masa pemulihan setelah sakit.',
                'target_word' => 'during his recovery period',
                'vocab' => [
                  'total rest' => [
                    'id' => 'istirahat total',
                    'pos' => '(n phr)',
                  ],
                  'must take' => [
                    'id' => 'harus menjalani',
                    'pos' => '(v phr)',
                  ],
                  'recovery period' => [
                    'id' => 'masa pemulihan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'My little brother must take total rest during his recovery period.',
                  'My little brother must take total rest while his recovery period.',
                  'My little brother must take total rest within his recovery period.',
                  'My little brother must take total rest onto his recovery period.',
                ],
                'correct_index' => 0,
                'explanation' => 'Periode pemulihan ditandai dengan preposisi \'during\' + Noun Phrase.',
              ],
              [
                'id' => 16,
                'id_sentence' => 'Harga sayuran berubah-ubah secara teratur sepanjang pergantian musim.',
                'target_word' => 'throughout the changing seasons',
                'vocab' => [
                  'vegetable prices' => [
                    'id' => 'harga sayuran',
                    'pos' => '(n phr)',
                  ],
                  'fluctuate regularly' => [
                    'id' => 'berubah-ubah secara teratur',
                    'pos' => '(v phr)',
                  ],
                  'changing seasons' => [
                    'id' => 'pergantian musim',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Vegetable prices fluctuate regularly throughout the changing seasons.',
                  'Vegetable prices fluctuate regularly between the changing seasons.',
                  'Vegetable prices fluctuate regularly within the changing seasons.',
                  'Vegetable prices fluctuate regularly during the changing seasons happen.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Throughout\' tepat digunakan untuk perubahan yang berjalan sepanjang keseluruhan musim.',
              ],
              [
                'id' => 17,
                'id_sentence' => 'Aplikasi pengingat itu mengirim notifikasi dalam interval tiga puluh menit.',
                'target_word' => 'within thirty-minute intervals',
                'vocab' => [
                  'reminder app' => [
                    'id' => 'aplikasi pengingat',
                    'pos' => '(n phr)',
                  ],
                  'sends notifications' => [
                    'id' => 'mengirim notifikasi',
                    'pos' => '(v phr)',
                  ],
                  'intervals' => [
                    'id' => 'interval',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'The reminder app sends notifications within thirty-minute intervals.',
                  'The reminder app sends notifications during thirty-minute intervals.',
                  'The reminder app sends notifications throughout thirty-minute intervals.',
                  'The reminder app sends notifications upon thirty-minute intervals.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Within thirty-minute intervals\' menandai rentang batas waktu antar-notifikasi.',
              ],
              [
                'id' => 18,
                'id_sentence' => 'Toko kue itu ramai sekali selama masa liburan sekolah.',
                'target_word' => 'during the school holiday period',
                'vocab' => [
                  'cake shop' => [
                    'id' => 'toko kue',
                    'pos' => '(n phr)',
                  ],
                  'gets very crowded' => [
                    'id' => 'menjadi ramai sekali',
                    'pos' => '(v phr)',
                  ],
                  'school holiday period' => [
                    'id' => 'masa liburan sekolah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The cake shop gets very crowded during the school holiday period.',
                  'The cake shop gets very crowded while the school holiday period.',
                  'The cake shop gets very crowded upon the school holiday period.',
                  'The cake shop gets very crowded within the school holiday period.',
                ],
                'correct_index' => 0,
                'explanation' => '\'During\' diikuti oleh Noun Phrase \'the school holiday period\'.',
              ],
              [
                'id' => 19,
                'id_sentence' => 'Begitu bel sekolah berbunyi, semua murid langsung berlari keluar kelas.',
                'target_word' => 'Upon hearing the school bell',
                'vocab' => [
                  'upon hearing' => [
                    'id' => 'begitu/segera setelah mendengar',
                    'pos' => '(prep phr)',
                  ],
                  'school bell' => [
                    'id' => 'bel sekolah',
                    'pos' => '(n phr)',
                  ],
                  'ran out of the classroom' => [
                    'id' => 'berlari keluar kelas',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Upon hearing the school bell, all the students ran out of the classroom.',
                  'During hearing the school bell, all the students ran out of the classroom.',
                  'Within hearing the school bell, all the students ran out of the classroom.',
                  'Throughout hearing the school bell, all the students ran out of the classroom.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Upon + Gerund\' berarti \'segera setelah\' atau \'pada saat terjadinya suatu kejadian\'.',
              ],
              [
                'id' => 20,
                'id_sentence' => 'Sepeda itu masih berfungsi dengan baik sepanjang lima tahun pemakaian.',
                'target_word' => 'throughout five years of use',
                'vocab' => [
                  'the bicycle' => [
                    'id' => 'sepeda itu',
                    'pos' => '(n phr)',
                  ],
                  'still works well' => [
                    'id' => 'masih berfungsi dengan baik',
                    'pos' => '(v phr)',
                  ],
                  'five years of use' => [
                    'id' => 'lima tahun pemakaian',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The bicycle still works well throughout five years of use.',
                  'The bicycle still works well during five years of use.',
                  'The bicycle still works well within five years of use.',
                  'The bicycle still works well upon five years of use.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Throughout its years of use\' menyatakan kesinambungan kondisi baik sepanjang masa pakai.',
              ],
            ],
          ],
          [
            'id' => 'prep_instrument',
            'name' => 'Instrumental Prepositions: Ways of Doing Things (by, through, via)',
            'code' => '1.5.3',
            'concept_title' => 'Frase Preposisi Penunjuk Cara dan Sarana Sehari-hari',
            'concept_description' => 'Frase preposisi instrumental menjelaskan cara, alat, atau sarana yang digunakan untuk melakukan sesuatu. Gunakan \'by\' (sering diikuti Gerund V-ing: by riding, by asking) atau \'by means of\', \'through\' (melalui suatu cara: through practice), dan \'via\' (melalui suatu saluran: via text message).',
            'formula' => 'Clause + BY / THROUGH / VIA / BY MEANS OF + Noun / Gerund Phrase',
            'rules' => [
              '\'By\' diikuti Gerund (V-ing) untuk menyatakan cara yang dilakukan subjek (e.g. by practicing every day).',
              '\'Through\' diikuti kata benda proses (e.g. through hard work, through patience).',
              '\'Via\' digunakan untuk menyatakan perantara rute atau saluran komunikasi.',
              'Dilarang menggunakan \'with\' untuk cara/metode abstrak (e.g., \'solved with asking\' keliru, gunakan \'by asking\').',
            ],
            'exercises' => [
              [
                'id' => 21,
                'id_sentence' => 'Kakak memisahkan baju putih dan baju berwarna melalui dua keranjang cucian terpisah.',
                'target_word' => 'through two separate laundry baskets',
                'vocab' => [
                  'my sister' => [
                    'id' => 'Kakak',
                    'pos' => '(n phr)',
                  ],
                  'separates white and colored clothes' => [
                    'id' => 'memisahkan baju putih dan berwarna',
                    'pos' => '(v phr)',
                  ],
                  'two separate laundry baskets' => [
                    'id' => 'dua keranjang cucian terpisah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'My sister separates white and colored clothes through two separate laundry baskets.',
                  'My sister separates white and colored clothes by two separate laundry baskets.',
                  'My sister separates white and colored clothes with two separate laundry baskets.',
                  'My sister separates white and colored clothes via two separate laundry baskets.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Through\' adalah preposisi baku untuk merujuk pada cara atau metode yang dilakukan secara bertahap.',
              ],
              [
                'id' => 22,
                'id_sentence' => 'Ayah menghemat uang bensin dengan bersepeda ke kantor setiap hari.',
                'target_word' => 'by riding',
                'vocab' => [
                  'saves money on gas' => [
                    'id' => 'menghemat uang bensin',
                    'pos' => '(v phr)',
                  ],
                  'riding a bicycle to the office' => [
                    'id' => 'bersepeda ke kantor',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Dad saves money on gas by riding his bicycle to the office every day.',
                  'Dad saves money on gas through ride his bicycle to the office every day.',
                  'Dad saves money on gas with riding his bicycle to the office every day.',
                  'Dad saves money on gas via ride his bicycle to the office every day.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'by\' diikuti bentuk Gerund \'riding\' menyatakan cara yang dilakukan pelaku.',
              ],
              [
                'id' => 23,
                'id_sentence' => 'Nenek mengirim resep kue favoritnya kepada kami melalui pesan WhatsApp.',
                'target_word' => 'via a WhatsApp message',
                'vocab' => [
                  'grandma' => [
                    'id' => 'Nenek',
                    'pos' => '(n)',
                  ],
                  'sends her favorite cake recipe' => [
                    'id' => 'mengirim resep kue favoritnya',
                    'pos' => '(v phr)',
                  ],
                  'WhatsApp message' => [
                    'id' => 'pesan WhatsApp',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Grandma sends her favorite cake recipe to us via a WhatsApp message.',
                  'Grandma sends her favorite cake recipe to us by a WhatsApp message.',
                  'Grandma sends her favorite cake recipe to us with a WhatsApp message.',
                  'Grandma sends her favorite cake recipe to us through a WhatsApp message.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Via\' digunakan secara tepat untuk merujuk pada saluran komunikasi digital.',
              ],
              [
                'id' => 24,
                'id_sentence' => 'Kami menemukan jalan pulang melalui aplikasi peta di ponsel.',
                'target_word' => 'by means of a map app',
                'vocab' => [
                  'found our way home' => [
                    'id' => 'menemukan jalan pulang',
                    'pos' => '(v phr)',
                  ],
                  'map app' => [
                    'id' => 'aplikasi peta',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'We found our way home by means of a map app on the phone.',
                  'We found our way home by a map app on the phone.',
                  'We found our way home with a map app on the phone.',
                  'We found our way home in means of a map app on the phone.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase \'by means of\' digunakan untuk merujuk pada alat yang membantu menyelesaikan sesuatu.',
              ],
              [
                'id' => 25,
                'id_sentence' => 'Kami mengurangi sampah plastik dengan membawa botol minum sendiri.',
                'target_word' => 'by bringing',
                'vocab' => [
                  'reduce plastic waste' => [
                    'id' => 'mengurangi sampah plastik',
                    'pos' => '(v phr)',
                  ],
                  'bringing our own water bottles' => [
                    'id' => 'membawa botol minum sendiri',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'We reduce plastic waste by bringing our own water bottles.',
                  'We reduce plastic waste through bring our own water bottles.',
                  'We reduce plastic waste with bringing our own water bottles.',
                  'We reduce plastic waste via bring our own water bottles.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'by\' wajib diikuti Gerund \'bringing\'.',
              ],
              [
                'id' => 26,
                'id_sentence' => 'Ia memperbaiki kesalahan ejaan dengan membaca ulang tulisannya dua kali.',
                'target_word' => 'through careful re-reading',
                'vocab' => [
                  'fixes spelling mistakes' => [
                    'id' => 'memperbaiki kesalahan ejaan',
                    'pos' => '(v phr)',
                  ],
                  'careful re-reading' => [
                    'id' => 'membaca ulang dengan teliti',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'She fixes her spelling mistakes through careful re-reading of her writing.',
                  'She fixes her spelling mistakes by careful re-reading of her writing.',
                  'She fixes her spelling mistakes with careful re-reading of her writing.',
                  'She fixes her spelling mistakes via careful re-reading of her writing.',
                ],
                'correct_index' => 0,
                'explanation' => 'Cara/metode belajar seperti membaca ulang dihubungkan dengan preposisi \'through\'.',
              ],
              [
                'id' => 27,
                'id_sentence' => 'Undangan ulang tahun dikirimkan secara praktis melalui grup chat kelas.',
                'target_word' => 'via the class chat group',
                'vocab' => [
                  'birthday invitations' => [
                    'id' => 'undangan ulang tahun',
                    'pos' => '(n phr)',
                  ],
                  'class chat group' => [
                    'id' => 'grup chat kelas',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Birthday invitations are sent conveniently via the class chat group.',
                  'Birthday invitations are sent conveniently by the class chat group.',
                  'Birthday invitations are sent conveniently through the class chat group.',
                  'Birthday invitations are sent conveniently with the class chat group.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Via\' adalah preposisi standar untuk saluran pesan digital.',
              ],
              [
                'id' => 28,
                'id_sentence' => 'Petugas kebersihan menstabilkan pot bunga besar dengan memasang penyangga kayu.',
                'target_word' => 'by installing',
                'vocab' => [
                  'groundskeeper' => [
                    'id' => 'petugas kebersihan',
                    'pos' => '(n phr)',
                  ],
                  'large flower pots' => [
                    'id' => 'pot bunga besar',
                    'pos' => '(n phr)',
                  ],
                  'wooden supports' => [
                    'id' => 'penyangga kayu',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The groundskeeper stabilizes the large flower pots by installing wooden supports.',
                  'The groundskeeper stabilizes the large flower pots through install wooden supports.',
                  'The groundskeeper stabilizes the large flower pots with installing wooden supports.',
                  'The groundskeeper stabilizes the large flower pots via install wooden supports.',
                ],
                'correct_index' => 0,
                'explanation' => '\'By + Gerund (installing)\' menerangkan cara tindakan fisik yang diambil.',
              ],
              [
                'id' => 29,
                'id_sentence' => 'Ia menghilangkan noda membandel di baju melalui proses perendaman semalaman.',
                'target_word' => 'through an overnight soak',
                'vocab' => [
                  'removes stubborn stains' => [
                    'id' => 'menghilangkan noda membandel',
                    'pos' => '(v phr)',
                  ],
                  'overnight soak' => [
                    'id' => 'perendaman semalaman',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'She removes stubborn stains from clothes through an overnight soak.',
                  'She removes stubborn stains from clothes by an overnight soak.',
                  'She removes stubborn stains from clothes with an overnight soak.',
                  'She removes stubborn stains from clothes via an overnight soak.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Through\' digunakan sebelum proses yang berlangsung bertahap seperti \'an overnight soak\'.',
              ],
              [
                'id' => 30,
                'id_sentence' => 'Murid-murid bertanya kepada guru melalui kotak pertanyaan daring interaktif.',
                'target_word' => 'via an interactive online question box',
                'vocab' => [
                  'ask the teacher' => [
                    'id' => 'bertanya kepada guru',
                    'pos' => '(v phr)',
                  ],
                  'interactive online question box' => [
                    'id' => 'kotak pertanyaan daring interaktif',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Students ask the teacher questions via an interactive online question box.',
                  'Students ask the teacher questions by an interactive online question box.',
                  'Students ask the teacher questions through an interactive online question box.',
                  'Students ask the teacher questions with an interactive online question box.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Via\' adalah preposisi yang paling tepat untuk media atau platform digital.',
              ],
            ],
          ],
          [
            'id' => 'prep_attribution',
            'name' => 'Source & Attribution Prepositions (according to, based on, from)',
            'code' => '1.5.4',
            'concept_title' => 'Frase Preposisi Sumber Informasi dan Rujukan Sehari-hari',
            'concept_description' => 'Frase preposisi atribusi menghubungkan pernyataan dengan sumber informasi, seperti berita, orang lain, atau data yang kita miliki. \'According to\' digunakan untuk merujuk pada sumber luar (According to the weather forecast, ...). \'Based on\' menerangkan dasar yang melandasi suatu kesimpulan (Based on what I saw, ...). Jangan gunakan \'According to me\' untuk pendapat sendiri; gunakan \'In my opinion\'.',
            'formula' => 'ACCORDING TO / BASED ON / FROM + Source / Information',
            'rules' => [
              'Gunakan \'According to\' untuk merujuk pada sumber luar (orang lain, berita, laporan).',
              'Hindari frasa \'according to me\' atau \'according to my opinion\' — gunakan \'in my opinion\'.',
              '\'Based on\' digunakan sebagai pembuka kalimat atau penjelas dasar suatu pernyataan.',
              'Frase atribusi pembuka kalimat wajib diikuti tanda koma sebelum klausa utama.',
            ],
            'exercises' => [
              [
                'id' => 31,
                'id_sentence' => 'Menurut ramalan cuaca, akan turun hujan deras sore ini.',
                'target_word' => 'According to the weather forecast',
                'vocab' => [
                  'weather forecast' => [
                    'id' => 'ramalan cuaca',
                    'pos' => '(n phr)',
                  ],
                  'heavy rain' => [
                    'id' => 'hujan deras',
                    'pos' => '(n phr)',
                  ],
                  'this afternoon' => [
                    'id' => 'sore ini',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'According to the weather forecast, there will be heavy rain this afternoon.',
                  'Based on the weather forecast, there will be heavy rain this afternoon.',
                  'From the weather forecast, there will be heavy rain this afternoon.',
                  'According with the weather forecast, there will be heavy rain this afternoon.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa standar atribusi informasi adalah \'According to the weather forecast\' diikuti tanda koma.',
              ],
              [
                'id' => 32,
                'id_sentence' => 'Berdasarkan apa yang kami lihat, toko itu sudah tutup sejak tadi malam.',
                'target_word' => 'Based on what we saw',
                'vocab' => [
                  'what we saw' => [
                    'id' => 'apa yang kami lihat',
                    'pos' => '(n phr)',
                  ],
                  'has been closed' => [
                    'id' => 'sudah tutup',
                    'pos' => '(v phr)',
                  ],
                  'since last night' => [
                    'id' => 'sejak tadi malam',
                    'pos' => '(prep phr)',
                  ],
                ],
                'options' => [
                  'Based on what we saw, the shop has been closed since last night.',
                  'According on what we saw, the shop has been closed since last night.',
                  'Derived to what we saw, the shop has been closed since last night.',
                  'Relying in what we saw, the shop has been closed since last night.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Based on\' digunakan untuk menerangkan dasar pengamatan yang menjadi landasan pernyataan.',
              ],
              [
                'id' => 33,
                'id_sentence' => 'Menurut kata Bu Guru, ulangan matematika akan diadakan minggu depan.',
                'target_word' => 'According to our teacher',
                'vocab' => [
                  'our teacher' => [
                    'id' => 'Bu Guru',
                    'pos' => '(n phr)',
                  ],
                  'math test' => [
                    'id' => 'ulangan matematika',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'According to our teacher, the math test will be held next week.',
                  'According with our teacher, the math test will be held next week.',
                  'Based to our teacher, the math test will be held next week.',
                  'By our teacher, the math test will be held next week.',
                ],
                'correct_index' => 0,
                'explanation' => '\'According to\' diikuti nama orang atau sumber yang menyampaikan informasi.',
              ],
              [
                'id' => 34,
                'id_sentence' => 'Resep kue ini berasal langsung dari buku masak kesayangan nenek.',
                'target_word' => 'comes directly from grandma\'s favorite cookbook',
                'vocab' => [
                  'comes from' => [
                    'id' => 'berasal dari',
                    'pos' => '(v phr)',
                  ],
                  'grandma\'s favorite cookbook' => [
                    'id' => 'buku masak kesayangan nenek',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This cake recipe comes directly from grandma\'s favorite cookbook.',
                  'This cake recipe comes directly out of grandma\'s favorite cookbook.',
                  'This cake recipe comes directly by grandma\'s favorite cookbook.',
                  'This cake recipe comes directly through grandma\'s favorite cookbook.',
                ],
                'correct_index' => 0,
                'explanation' => 'Kolokasi preposisi yang baku untuk kata \'come\' (berasal) adalah \'from\'.',
              ],
              [
                'id' => 35,
                'id_sentence' => 'Berdasarkan hasil nilai ulangan, Kakak perlu belajar lebih giat lagi.',
                'target_word' => 'Based on the test score results',
                'vocab' => [
                  'test score results' => [
                    'id' => 'hasil nilai ulangan',
                    'pos' => '(n phr)',
                  ],
                  'needs to study harder' => [
                    'id' => 'perlu belajar lebih giat',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Based on the test score results, my sister needs to study harder.',
                  'According with the test score results, my sister needs to study harder.',
                  'Depending from the test score results, my sister needs to study harder.',
                  'Grounding on the test score results, my sister needs to study harder.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Based on\' mengawali kesimpulan berbasis hasil yang terlihat.',
              ],
              [
                'id' => 36,
                'id_sentence' => 'Menurut kebiasaan di keluarga kami, makan malam selalu disiapkan pukul tujuh.',
                'target_word' => 'According to our family\'s tradition',
                'vocab' => [
                  'our family\'s tradition' => [
                    'id' => 'kebiasaan keluarga kami',
                    'pos' => '(n phr)',
                  ],
                  'dinner is always prepared' => [
                    'id' => 'makan malam selalu disiapkan',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'According to our family\'s tradition, dinner is always prepared at seven.',
                  'Based to our family\'s tradition, dinner is always prepared at seven.',
                  'In our family\'s tradition according, dinner is always prepared at seven.',
                  'According with our family\'s tradition, dinner is always prepared at seven.',
                ],
                'correct_index' => 0,
                'explanation' => '\'According to our family\'s tradition\' adalah frase pembuka atribusi kebiasaan.',
              ],
              [
                'id' => 37,
                'id_sentence' => 'Cerita rakyat ini diambil dari dongeng yang diceritakan turun-temurun di desa kami.',
                'target_word' => 'taken from a folktale passed down for generations',
                'vocab' => [
                  'folk story' => [
                    'id' => 'cerita rakyat',
                    'pos' => '(n phr)',
                  ],
                  'passed down for generations' => [
                    'id' => 'diceritakan turun-temurun',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'This folk story is taken from a folktale passed down for generations in our village.',
                  'This folk story is taken of a folktale passed down for generations in our village.',
                  'This folk story is taken through a folktale passed down for generations in our village.',
                  'This folk story is taken by a folktale passed down for generations in our village.',
                ],
                'correct_index' => 0,
                'explanation' => 'Preposisi \'from\' menunjukkan sumber asal suatu cerita (\'taken from\').',
              ],
              [
                'id' => 38,
                'id_sentence' => 'Berdasarkan hasil obrolan kami, sebagian besar teman sekelas suka pelajaran olahraga.',
                'target_word' => 'Based on our chat',
                'vocab' => [
                  'our chat' => [
                    'id' => 'obrolan kami',
                    'pos' => '(n phr)',
                  ],
                  'classmates' => [
                    'id' => 'teman sekelas',
                    'pos' => '(n)',
                  ],
                  'sports class' => [
                    'id' => 'pelajaran olahraga',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Based on our chat, most of our classmates like sports class.',
                  'According on our chat, most of our classmates like sports class.',
                  'Following to our chat, most of our classmates like sports class.',
                  'Depending with our chat, most of our classmates like sports class.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Based on\' digunakan sebelum frasa yang menjadi landasan kesimpulan.',
              ],
              [
                'id' => 39,
                'id_sentence' => 'Menurut majalah kesehatan yang kubaca, tidur cukup membuat kita lebih fokus.',
                'target_word' => 'According to a health magazine I read',
                'vocab' => [
                  'health magazine' => [
                    'id' => 'majalah kesehatan',
                    'pos' => '(n phr)',
                  ],
                  'enough sleep' => [
                    'id' => 'tidur cukup',
                    'pos' => '(n phr)',
                  ],
                  'more focused' => [
                    'id' => 'lebih fokus',
                    'pos' => '(adj phr)',
                  ],
                ],
                'options' => [
                  'According to a health magazine I read, enough sleep makes us more focused.',
                  'According with a health magazine I read, enough sleep makes us more focused.',
                  'Based to a health magazine I read, enough sleep makes us more focused.',
                  'By a health magazine I read, enough sleep makes us more focused.',
                ],
                'correct_index' => 0,
                'explanation' => '\'According to a health magazine\' menyandarkan pernyataan pada sumber yang dibaca.',
              ],
              [
                'id' => 40,
                'id_sentence' => 'Informasi jadwal ujian itu berasal dari papan pengumuman sekolah.',
                'target_word' => 'comes from the school notice board',
                'vocab' => [
                  'comes from' => [
                    'id' => 'berasal dari',
                    'pos' => '(v phr)',
                  ],
                  'school notice board' => [
                    'id' => 'papan pengumuman sekolah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This exam schedule information comes from the school notice board.',
                  'This exam schedule information comes out of the school notice board.',
                  'This exam schedule information comes by the school notice board.',
                  'This exam schedule information comes through the school notice board.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba \'come\' (berasal) berkolokasi dengan preposisi \'from\'.',
              ],
            ],
          ],
          [
            'id' => 'prep_cause',
            'name' => 'Causality Prepositions: Everyday Reasons (due to, owing to, as a result of)',
            'code' => '1.5.5',
            'concept_title' => 'Frase Preposisi Sebab-Akibat dalam Kejadian Sehari-hari',
            'concept_description' => 'Frase preposisi kausalitas digunakan untuk memaparkan alasan suatu kejadian secara ringkas tanpa perlu menyusun anak kalimat baru. Pola yang baku mencakup \'due to\', \'owing to\', dan \'as a result of\', yang WAJIB diikuti oleh kata benda (Noun / Noun Phrase) atau Gerund (V-ing). Kesalahan umum adalah meletakkan kalimat lengkap langsung setelah \'due to\' (e.g., \'due to it rains\' adalah SALAH, yang benar adalah \'due to the rain\').',
            'formula' => 'Clause + DUE TO / OWING TO / AS A RESULT OF + Noun Phrase (Cause)',
            'rules' => [
              'Wajib diikuti Noun Phrase atau Gerund (bukan kalimat/klausa subjek + predikat).',
              '\'Due to\' memodifikasi kata benda, sedangkan \'owing to\' sering berfungsi sebagai penjelas klausula.',
              'Gunakan \'as a result of\' untuk menjelaskan akibat yang jelas dari suatu kejadian.',
              'Dilarang menulis \'due to + Subject + Verb\' tanpa menjembataninya dengan \'the fact that\'.',
            ],
            'exercises' => [
              [
                'id' => 41,
                'id_sentence' => 'Pertandingan sepak bola itu ditunda akibat hujan deras yang tiba-tiba turun.',
                'target_word' => 'due to sudden heavy rain',
                'vocab' => [
                  'football match' => [
                    'id' => 'pertandingan sepak bola',
                    'pos' => '(n phr)',
                  ],
                  'postponed' => [
                    'id' => 'ditunda',
                    'pos' => '(v)',
                  ],
                  'sudden heavy rain' => [
                    'id' => 'hujan deras yang tiba-tiba',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The football match was postponed due to sudden heavy rain.',
                  'The football match was postponed because sudden heavy rain.',
                  'The football match was postponed due to it suddenly rained heavily.',
                  'The football match was postponed owing that sudden heavy rain.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Due to\' diikuti oleh Noun Phrase \'sudden heavy rain\'. Opsi \'because\' keliru karena \'because\' harus diikuti klausa berpredikat.',
              ],
              [
                'id' => 42,
                'id_sentence' => 'Penerbangan kami tertunda karena cuaca buruk di bandara tujuan.',
                'target_word' => 'owing to bad weather',
                'vocab' => [
                  'our flight' => [
                    'id' => 'penerbangan kami',
                    'pos' => '(n phr)',
                  ],
                  'delayed' => [
                    'id' => 'tertunda',
                    'pos' => '(v)',
                  ],
                  'bad weather' => [
                    'id' => 'cuaca buruk',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Our flight was delayed owing to bad weather at the destination airport.',
                  'Our flight was delayed owing that bad weather at the destination airport.',
                  'Our flight was delayed due that bad weather at the destination airport.',
                  'Our flight was delayed because bad weather at the destination airport.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Owing to\' adalah preposisi kausal yang tepat diikuti frasa benda \'bad weather\'.',
              ],
              [
                'id' => 43,
                'id_sentence' => 'Nilai ujian kelas kami meningkat sebagai hasil dari jam belajar tambahan.',
                'target_word' => 'as a result of extra study hours',
                'vocab' => [
                  'our class test scores' => [
                    'id' => 'nilai ujian kelas kami',
                    'pos' => '(n phr)',
                  ],
                  'improved' => [
                    'id' => 'meningkat',
                    'pos' => '(v)',
                  ],
                  'extra study hours' => [
                    'id' => 'jam belajar tambahan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Our class test scores improved as a result of extra study hours.',
                  'Our class test scores improved as a result that extra study hours.',
                  'Our class test scores improved as a result to extra study hours.',
                  'Our class test scores improved for a result of extra study hours.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa preposisi sebab-akibat yang baku adalah \'as a result of + Noun Phrase\'.',
              ],
              [
                'id' => 44,
                'id_sentence' => 'Keterlambatan kami disebabkan oleh kemacetan panjang di jalan utama.',
                'target_word' => 'caused by heavy traffic',
                'vocab' => [
                  'our lateness' => [
                    'id' => 'keterlambatan kami',
                    'pos' => '(n phr)',
                  ],
                  'caused by' => [
                    'id' => 'disebabkan oleh',
                    'pos' => '(v phr)',
                  ],
                  'heavy traffic on the main road' => [
                    'id' => 'kemacetan panjang di jalan utama',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Our lateness was caused by heavy traffic on the main road.',
                  'Our lateness was caused of heavy traffic on the main road.',
                  'Our lateness was caused with heavy traffic on the main road.',
                  'Our lateness was caused for heavy traffic on the main road.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa predikatif sebab-akibat \'caused\' wajib berpasangan dengan preposisi \'by\'.',
              ],
              [
                'id' => 45,
                'id_sentence' => 'Hasil panen sayuran kami menurun akibat kekeringan berkepanjangan.',
                'target_word' => 'due to prolonged drought',
                'vocab' => [
                  'our vegetable harvest' => [
                    'id' => 'hasil panen sayuran kami',
                    'pos' => '(n phr)',
                  ],
                  'decreased' => [
                    'id' => 'menurun',
                    'pos' => '(v)',
                  ],
                  'prolonged drought' => [
                    'id' => 'kekeringan berkepanjangan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Our vegetable harvest decreased due to prolonged drought.',
                  'Our vegetable harvest decreased because prolonged drought.',
                  'Our vegetable harvest decreased owing that prolonged drought.',
                  'Our vegetable harvest decreased due that prolonged drought.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Due to\' menghubungkan klausa utama dengan frasa nomina penyebab \'prolonged drought\'.',
              ],
              [
                'id' => 46,
                'id_sentence' => 'Acara pasar malam ditunda karena gangguan listrik di seluruh kompleks.',
                'target_word' => 'owing to a power outage',
                'vocab' => [
                  'night market event' => [
                    'id' => 'acara pasar malam',
                    'pos' => '(n phr)',
                  ],
                  'postponed' => [
                    'id' => 'ditunda',
                    'pos' => '(v)',
                  ],
                  'power outage' => [
                    'id' => 'gangguan listrik',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The night market event was postponed owing to a power outage across the complex.',
                  'The night market event was postponed owing of a power outage across the complex.',
                  'The night market event was postponed because a power outage across the complex.',
                  'The night market event was postponed due of a power outage across the complex.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Owing to\' diikuti oleh frasa nomina penyebab \'a power outage\'.',
              ],
              [
                'id' => 47,
                'id_sentence' => 'Kualitas udara di sekitar rumah membaik sebagai akibat dari penanaman pohon baru.',
                'target_word' => 'as a result of planting new trees',
                'vocab' => [
                  'air quality around the house' => [
                    'id' => 'kualitas udara di sekitar rumah',
                    'pos' => '(n phr)',
                  ],
                  'improved' => [
                    'id' => 'membaik',
                    'pos' => '(v)',
                  ],
                  'planting new trees' => [
                    'id' => 'penanaman pohon baru',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Air quality around the house improved as a result of planting new trees.',
                  'Air quality around the house improved as a result to planting new trees.',
                  'Air quality around the house improved as a result that planting new trees.',
                  'Air quality around the house improved as result of planting new trees.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa preposisi kausal idiomatis adalah \'as a result of + Noun Phrase\'.',
              ],
              [
                'id' => 48,
                'id_sentence' => 'Pertunjukan drama kelas gagal terlaksana terutama karena kurangnya latihan.',
                'target_word' => 'largely due to a lack of practice',
                'vocab' => [
                  'class drama performance' => [
                    'id' => 'pertunjukan drama kelas',
                    'pos' => '(n phr)',
                  ],
                  'failed to happen' => [
                    'id' => 'gagal terlaksana',
                    'pos' => '(v phr)',
                  ],
                  'lack of practice' => [
                    'id' => 'kurangnya latihan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The class drama performance failed to happen largely due to a lack of practice.',
                  'The class drama performance failed to happen largely because a lack of practice.',
                  'The class drama performance failed to happen largely owing that a lack of practice.',
                  'The class drama performance failed to happen largely due that a lack of practice.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Due to\' dapat didahului adverb \'largely\' untuk membentuk frase \'largely due to + Noun Phrase\'.',
              ],
              [
                'id' => 49,
                'id_sentence' => 'Kenaikan nilai ulanganku berkaitan langsung dengan jadwal belajar yang lebih teratur.',
                'target_word' => 'linked directly to a more regular study schedule',
                'vocab' => [
                  'my improved test scores' => [
                    'id' => 'kenaikan nilai ulanganku',
                    'pos' => '(n phr)',
                  ],
                  'more regular study schedule' => [
                    'id' => 'jadwal belajar yang lebih teratur',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'My improved test scores are linked directly to a more regular study schedule.',
                  'My improved test scores are linked directly with a more regular study schedule.',
                  'My improved test scores are linked directly of a more regular study schedule.',
                  'My improved test scores are linked directly by a more regular study schedule.',
                ],
                'correct_index' => 0,
                'explanation' => 'Verba pasif \'is linked\' berpasangan dengan preposisi \'to\' (\'linked to\').',
              ],
              [
                'id' => 50,
                'id_sentence' => 'Banjir kecil di gang itu bertambah parah sebagai akibat langsung dari selokan yang tersumbat.',
                'target_word' => 'as a direct result of the clogged drain',
                'vocab' => [
                  'small flooding in the alley' => [
                    'id' => 'banjir kecil di gang itu',
                    'pos' => '(n phr)',
                  ],
                  'worsened' => [
                    'id' => 'bertambah parah',
                    'pos' => '(v)',
                  ],
                  'clogged drain' => [
                    'id' => 'selokan yang tersumbat',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Small flooding in the alley worsened as a direct result of the clogged drain.',
                  'Small flooding in the alley worsened as a direct result to the clogged drain.',
                  'Small flooding in the alley worsened as direct result of the clogged drain.',
                  'Small flooding in the alley worsened as a direct result that the clogged drain.',
                ],
                'correct_index' => 0,
                'explanation' => '\'As a direct result of\' adalah frase preposisi kausal yang menegaskan hubungan sebab-akibat yang jelas.',
              ],
            ],
          ],
          [
            'id' => 'prep_scope',
            'name' => 'Prepositional Phrases of Topic & Comparison (in terms of, with respect to)',
            'code' => '1.5.6',
            'concept_title' => 'Frase Preposisi Penjelas Topik dan Perbandingan Sehari-hari',
            'concept_description' => 'Saat membandingkan dua hal atau membahas suatu topik tertentu, membatasi pembahasan pada satu aspek tertentu membantu kalimat jadi lebih jelas. Frase seperti \'in terms of\' (dari segi / dalam hal), \'with respect to\' (berkenaan dengan), \'in relation to\' (sehubungan dengan), dan \'for the purpose of\' (untuk tujuan) digunakan untuk mengarahkan pembaca ke aspek spesifik yang dibahas.',
            'formula' => 'Clause + IN TERMS OF / WITH RESPECT TO / IN RELATION TO + Topic / Aspect',
            'rules' => [
              '\'In terms of\' diikuti topik atau aspek pembahasan (in terms of price, in terms of taste).',
              '\'With respect to\' digunakan untuk memfokuskan pembahasan pada hal tertentu.',
              '\'For the purpose of\' diikuti kata benda atau gerund V-ing (for the purpose of saving money).',
              'Gunakan koma jika frase lingkup ini diletakkan di posisi paling awal kalimat.',
            ],
            'exercises' => [
              [
                'id' => 51,
                'id_sentence' => 'Kedua toples bekal makan siang itu sebanding dalam hal ukuran dan daya tampung.',
                'target_word' => 'in terms of size and capacity',
                'vocab' => [
                  'two lunch boxes' => [
                    'id' => 'dua toples bekal makan siang',
                    'pos' => '(n phr)',
                  ],
                  'comparable' => [
                    'id' => 'sebanding',
                    'pos' => '(adj)',
                  ],
                  'size and capacity' => [
                    'id' => 'ukuran dan daya tampung',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Both lunch boxes are comparable in terms of size and capacity.',
                  'Both lunch boxes are comparable in terms to size and capacity.',
                  'Both lunch boxes are comparable with terms of size and capacity.',
                  'Both lunch boxes are comparable on terms of size and capacity.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa baku untuk menunjukkan aspek perbandingan adalah \'in terms of\'.',
              ],
              [
                'id' => 52,
                'id_sentence' => 'Kedua kelas itu tidak menunjukkan perbedaan berkenaan dengan jumlah murid laki-laki dan perempuan.',
                'target_word' => 'with respect to the number of boys and girls',
                'vocab' => [
                  'both classes' => [
                    'id' => 'kedua kelas itu',
                    'pos' => '(n phr)',
                  ],
                  'show no difference' => [
                    'id' => 'tidak menunjukkan perbedaan',
                    'pos' => '(v phr)',
                  ],
                  'number of boys and girls' => [
                    'id' => 'jumlah murid laki-laki dan perempuan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Both classes show no difference with respect to the number of boys and girls.',
                  'Both classes show no difference in respect of the number of boys and girls.',
                  'Both classes show no difference with respect of the number of boys and girls.',
                  'Both classes show no difference in respect with the number of boys and girls.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa preposisi majemuk yang baku adalah \'with respect to\'.',
              ],
              [
                'id' => 53,
                'id_sentence' => 'Kami menabung di celengan untuk tujuan membeli sepeda baru.',
                'target_word' => 'for the purpose of buying',
                'vocab' => [
                  'save money in a piggy bank' => [
                    'id' => 'menabung di celengan',
                    'pos' => '(v phr)',
                  ],
                  'buying a new bicycle' => [
                    'id' => 'membeli sepeda baru',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'We save money in a piggy bank for the purpose of buying a new bicycle.',
                  'We save money in a piggy bank for the purpose to buy a new bicycle.',
                  'We save money in a piggy bank with the purpose of buy a new bicycle.',
                  'We save money in a piggy bank for purpose of buying a new bicycle.',
                ],
                'correct_index' => 0,
                'explanation' => '\'For the purpose of\' wajib diikuti oleh bentuk Gerund \'buying\'.',
              ],
              [
                'id' => 54,
                'id_sentence' => 'Kedai kopi ini terkenal paling enak dalam hal rasa dan aroma.',
                'target_word' => 'in terms of taste and aroma',
                'vocab' => [
                  'this coffee shop' => [
                    'id' => 'kedai kopi ini',
                    'pos' => '(n phr)',
                  ],
                  'is known as the best' => [
                    'id' => 'terkenal paling enak',
                    'pos' => '(v phr)',
                  ],
                  'taste and aroma' => [
                    'id' => 'rasa dan aroma',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This coffee shop is known as the best in terms of taste and aroma.',
                  'This coffee shop is known as the best with terms of taste and aroma.',
                  'This coffee shop is known as the best in terms to taste and aroma.',
                  'This coffee shop is known as the best on terms of taste and aroma.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In terms of\' adalah frase standar untuk membatasi aspek perbandingan.',
              ],
              [
                'id' => 55,
                'id_sentence' => 'Pilihan menu kantin dievaluasi sehubungan dengan kandungan gizi dan harga.',
                'target_word' => 'in relation to nutrition and price',
                'vocab' => [
                  'canteen menu choices' => [
                    'id' => 'pilihan menu kantin',
                    'pos' => '(n phr)',
                  ],
                  'evaluated' => [
                    'id' => 'dievaluasi',
                    'pos' => '(v)',
                  ],
                  'nutrition and price' => [
                    'id' => 'kandungan gizi dan harga',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Canteen menu choices are evaluated in relation to nutrition and price.',
                  'Canteen menu choices are evaluated in relation with nutrition and price.',
                  'Canteen menu choices are evaluated with relation of nutrition and price.',
                  'Canteen menu choices are evaluated in relation of nutrition and price.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa pembanding relasional yang tepat adalah \'in relation to\'.',
              ],
              [
                'id' => 56,
                'id_sentence' => 'Mainan-mainan lama dikumpulkan kembali untuk tujuan disumbangkan ke panti asuhan.',
                'target_word' => 'for the purpose of donating',
                'vocab' => [
                  'old toys' => [
                    'id' => 'mainan-mainan lama',
                    'pos' => '(n phr)',
                  ],
                  'collected again' => [
                    'id' => 'dikumpulkan kembali',
                    'pos' => '(v phr)',
                  ],
                  'donating to an orphanage' => [
                    'id' => 'disumbangkan ke panti asuhan',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Old toys are collected again for the purpose of donating them to an orphanage.',
                  'Old toys are collected again for the purpose to donate them to an orphanage.',
                  'Old toys are collected again with the purpose of donate them to an orphanage.',
                  'Old toys are collected again in the purpose of donating them to an orphanage.',
                ],
                'correct_index' => 0,
                'explanation' => '\'For the purpose of\' berkolokasi dengan Gerund \'donating\'.',
              ],
              [
                'id' => 57,
                'id_sentence' => 'Kedua ransel sekolah itu berbeda nyata berkenaan dengan ketahanan terhadap air hujan.',
                'target_word' => 'with respect to water resistance',
                'vocab' => [
                  'two school backpacks' => [
                    'id' => 'dua ransel sekolah',
                    'pos' => '(n phr)',
                  ],
                  'differ clearly' => [
                    'id' => 'berbeda nyata',
                    'pos' => '(v phr)',
                  ],
                  'water resistance' => [
                    'id' => 'ketahanan terhadap air',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The two school backpacks differ clearly with respect to water resistance.',
                  'The two school backpacks differ clearly with respect of water resistance.',
                  'The two school backpacks differ clearly in respect with water resistance.',
                  'The two school backpacks differ clearly with respects to water resistance.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa komparasi \'with respect to\' diikuti aspek \'water resistance\'.',
              ],
              [
                'id' => 58,
                'id_sentence' => 'Permainan papan ini menawarkan keunggulan dalam hal kemudahan aturan main.',
                'target_word' => 'in terms of simple rules',
                'vocab' => [
                  'this board game' => [
                    'id' => 'permainan papan ini',
                    'pos' => '(n phr)',
                  ],
                  'offers an advantage' => [
                    'id' => 'menawarkan keunggulan',
                    'pos' => '(v phr)',
                  ],
                  'simple rules' => [
                    'id' => 'kemudahan aturan main',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'This board game offers an advantage in terms of simple rules.',
                  'This board game offers an advantage in terms to simple rules.',
                  'This board game offers an advantage on terms of simple rules.',
                  'This board game offers an advantage with terms of simple rules.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In terms of\' adalah frase pembatas aspek yang tepat.',
              ],
              [
                'id' => 59,
                'id_sentence' => 'Aturan baru perpustakaan ini cukup longgar sehubungan dengan batas waktu peminjaman buku.',
                'target_word' => 'in relation to the book borrowing deadline',
                'vocab' => [
                  'new library rule' => [
                    'id' => 'aturan baru perpustakaan',
                    'pos' => '(n phr)',
                  ],
                  'quite lenient' => [
                    'id' => 'cukup longgar',
                    'pos' => '(adj phr)',
                  ],
                  'book borrowing deadline' => [
                    'id' => 'batas waktu peminjaman buku',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The new library rule is quite lenient in relation to the book borrowing deadline.',
                  'The new library rule is quite lenient in relation with the book borrowing deadline.',
                  'The new library rule is quite lenient with relation to the book borrowing deadline.',
                  'The new library rule is quite lenient on relation to the book borrowing deadline.',
                ],
                'correct_index' => 0,
                'explanation' => '\'In relation to\' menghubungkan sifat suatu aturan dengan aspek yang dibahas.',
              ],
              [
                'id' => 60,
                'id_sentence' => 'Daftar nama peserta disusun ulang untuk tujuan mempermudah pembagian kelompok.',
                'target_word' => 'for the purpose of making group assignments easier',
                'vocab' => [
                  'participant list' => [
                    'id' => 'daftar nama peserta',
                    'pos' => '(n phr)',
                  ],
                  'rearranged' => [
                    'id' => 'disusun ulang',
                    'pos' => '(v)',
                  ],
                  'making group assignments easier' => [
                    'id' => 'mempermudah pembagian kelompok',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'The participant list is rearranged for the purpose of making group assignments easier.',
                  'The participant list is rearranged for the purpose to make group assignments easier.',
                  'The participant list is rearranged with the purpose of make group assignments easier.',
                  'The participant list is rearranged for purpose of making group assignments easier.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa tujuan: \'for the purpose of\' + Gerund \'making\'.',
              ],
            ],
          ],
          [
            'id' => 'prep_fronting',
            'name' => 'Sentence-Initial Fronting of Prepositional Phrases (In [Context], S + V)',
            'code' => '1.5.7',
            'concept_title' => 'Pembalikan Posisi Awal Frase Preposisi (Fronting & Aturan Koma)',
            'concept_description' => 'Memindahkan frase preposisi ke awal kalimat (Sentence-Initial Fronting) berfungsi untuk menetapkan konteks pembuka sebelum inti kalimat diutarakan, dan membuat tulisan tidak monoton. Aturan tanda baca mutlak: frase preposisi pembuka kalimat WAJIB dipisahkan dengan tanda koma ( , ) sebelum subjek utama muncul.',
            'formula' => 'Prepositional Phrase (Context/Setting) + COMMA ( , ) + Subject + Verb + Object',
            'rules' => [
              'Wajib menyisipkan tanda koma tepat setelah frase preposisi pembuka kalimat.',
              'Frase preposisi tidak dapat bertindak sebagai subjek kalimat (harus ada subjek independen setelah koma).',
              'Gunakan fronting untuk memandu pembaca ke lokasi atau waktu sebelum inti kalimat.',
              'Hindari menumpuk lebih dari dua frase preposisi di posisi awal agar kalimat tetap mudah dibaca.',
            ],
            'exercises' => [
              [
                'id' => 61,
                'id_sentence' => 'Di lingkungan rumah kami, kebanyakan tetangga saling mengenal dengan baik.',
                'target_word' => 'In our neighborhood,',
                'vocab' => [
                  'our neighborhood' => [
                    'id' => 'lingkungan rumah kami',
                    'pos' => '(n phr)',
                  ],
                  'most neighbors' => [
                    'id' => 'kebanyakan tetangga',
                    'pos' => '(n phr)',
                  ],
                  'know each other well' => [
                    'id' => 'saling mengenal dengan baik',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'In our neighborhood, most neighbors know each other well.',
                  'In our neighborhood most neighbors know each other well.',
                  'On our neighborhood, most neighbors know each other well.',
                  'At our neighborhood, most neighbors know each other well.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase preposisi pembuka \'In our neighborhood\' WAJIB diikuti tanda koma sebelum subjek \'most neighbors\'.',
              ],
              [
                'id' => 62,
                'id_sentence' => 'Sepanjang liburan sekolah, minat baca anak-anak di perpustakaan meningkat pesat.',
                'target_word' => 'Throughout the school holiday,',
                'vocab' => [
                  'school holiday' => [
                    'id' => 'liburan sekolah',
                    'pos' => '(n phr)',
                  ],
                  'children\'s reading interest' => [
                    'id' => 'minat baca anak-anak',
                    'pos' => '(n phr)',
                  ],
                  'rises sharply' => [
                    'id' => 'meningkat pesat',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Throughout the school holiday, children\'s reading interest at the library rises sharply.',
                  'Throughout the school holiday children\'s reading interest at the library rises sharply.',
                  'During the school holiday children\'s reading interest at the library rises sharply.',
                  'Within the school holiday children\'s reading interest at the library rises sharply.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase preposisi waktu di awal kalimat memerlukan tanda koma pemisah.',
              ],
              [
                'id' => 63,
                'id_sentence' => 'Di bawah terik matahari siang, kami beristirahat sejenak di bawah pohon rindang.',
                'target_word' => 'Under the hot midday sun,',
                'vocab' => [
                  'hot midday sun' => [
                    'id' => 'terik matahari siang',
                    'pos' => '(n phr)',
                  ],
                  'rested for a while' => [
                    'id' => 'beristirahat sejenak',
                    'pos' => '(v phr)',
                  ],
                  'shady tree' => [
                    'id' => 'pohon rindang',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Under the hot midday sun, we rested for a while under a shady tree.',
                  'Under the hot midday sun we rested for a while under a shady tree.',
                  'In the hot midday sun we rested for a while under a shady tree.',
                  'At the hot midday sun we rested for a while under a shady tree.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase preposisi kondisi \'Under the hot midday sun\' wajib diikuti koma sebelum subjek \'we\'.',
              ],
              [
                'id' => 64,
                'id_sentence' => 'Setelah hujan reda, anak-anak berlarian keluar untuk bermain di halaman.',
                'target_word' => 'After the rain,',
                'vocab' => [
                  'the rain' => [
                    'id' => 'hujan',
                    'pos' => '(n)',
                  ],
                  'ran outside' => [
                    'id' => 'berlarian keluar',
                    'pos' => '(v phr)',
                  ],
                  'play in the yard' => [
                    'id' => 'bermain di halaman',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'After the rain, the children ran outside to play in the yard.',
                  'After the rain the children ran outside to play in the yard.',
                  'By the rain, the children ran outside to play in the yard.',
                  'Within the rain, the children ran outside to play in the yard.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase waktu pembuka \'After the rain\' wajib diikuti koma sebelum subjek \'the children\'.',
              ],
              [
                'id' => 65,
                'id_sentence' => 'Pada akhir pekan, pasar tradisional itu dipadati pengunjung dari berbagai daerah.',
                'target_word' => 'On weekends,',
                'vocab' => [
                  'weekends' => [
                    'id' => 'akhir pekan',
                    'pos' => '(n phr)',
                  ],
                  'traditional market' => [
                    'id' => 'pasar tradisional',
                    'pos' => '(n phr)',
                  ],
                  'crowded with visitors' => [
                    'id' => 'dipadati pengunjung',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'On weekends, the traditional market is crowded with visitors from various areas.',
                  'On weekends the traditional market is crowded with visitors from various areas.',
                  'In weekends, the traditional market is crowded with visitors from various areas.',
                  'At weekends, the traditional market is crowded with visitors from various areas.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase waktu pembuka \'On weekends\' wajib diikuti koma sebelum subjek \'the traditional market\'.',
              ],
              [
                'id' => 66,
                'id_sentence' => 'Berkat latihan rutin setiap sore, tim basket sekolah kami semakin kompak.',
                'target_word' => 'Thanks to daily afternoon practice,',
                'vocab' => [
                  'daily afternoon practice' => [
                    'id' => 'latihan rutin setiap sore',
                    'pos' => '(n phr)',
                  ],
                  'school basketball team' => [
                    'id' => 'tim basket sekolah',
                    'pos' => '(n phr)',
                  ],
                  'increasingly united' => [
                    'id' => 'semakin kompak',
                    'pos' => '(adj phr)',
                  ],
                ],
                'options' => [
                  'Thanks to daily afternoon practice, our school basketball team is increasingly united.',
                  'Thanks to daily afternoon practice our school basketball team is increasingly united.',
                  'Due to daily afternoon practice our school basketball team is increasingly united.',
                  'For daily afternoon practice our school basketball team is increasingly united.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase sebab pembuka \'Thanks to daily afternoon practice\' wajib diikuti koma.',
              ],
              [
                'id' => 67,
                'id_sentence' => 'Melalui kerja sama tim yang baik, proyek kebun sekolah kami berjalan lancar.',
                'target_word' => 'Through good teamwork,',
                'vocab' => [
                  'good teamwork' => [
                    'id' => 'kerja sama tim yang baik',
                    'pos' => '(n phr)',
                  ],
                  'school garden project' => [
                    'id' => 'proyek kebun sekolah',
                    'pos' => '(n phr)',
                  ],
                  'runs smoothly' => [
                    'id' => 'berjalan lancar',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Through good teamwork, our school garden project runs smoothly.',
                  'Through good teamwork our school garden project runs smoothly.',
                  'By means good teamwork our school garden project runs smoothly.',
                  'Via good teamwork our school garden project runs smoothly.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase instrumental pembuka kalimat \'Through good teamwork,\' wajib diikuti koma.',
              ],
              [
                'id' => 68,
                'id_sentence' => 'Di sepanjang jalan menuju sekolah, banyak pedagang kaki lima menjajakan sarapan.',
                'target_word' => 'Along the way to school,',
                'vocab' => [
                  'the way to school' => [
                    'id' => 'jalan menuju sekolah',
                    'pos' => '(n phr)',
                  ],
                  'street vendors' => [
                    'id' => 'pedagang kaki lima',
                    'pos' => '(n phr)',
                  ],
                  'sell breakfast' => [
                    'id' => 'menjajakan sarapan',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'Along the way to school, many street vendors sell breakfast.',
                  'Along the way to school many street vendors sell breakfast.',
                  'In the way to school many street vendors sell breakfast.',
                  'At the way to school many street vendors sell breakfast.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase lokasi pembuka \'Along the way to school\' wajib diikuti koma sebelum subjek \'many street vendors\'.',
              ],
              [
                'id' => 69,
                'id_sentence' => 'Selama jam istirahat, kantin sekolah dipenuhi murid yang membeli jajanan.',
                'target_word' => 'During break time,',
                'vocab' => [
                  'break time' => [
                    'id' => 'jam istirahat',
                    'pos' => '(n phr)',
                  ],
                  'school canteen' => [
                    'id' => 'kantin sekolah',
                    'pos' => '(n phr)',
                  ],
                  'filled with students' => [
                    'id' => 'dipenuhi murid',
                    'pos' => '(v phr)',
                  ],
                ],
                'options' => [
                  'During break time, the school canteen is filled with students buying snacks.',
                  'During break time the school canteen is filled with students buying snacks.',
                  'While break time, the school canteen is filled with students buying snacks.',
                  'Within break time, the school canteen is filled with students buying snacks.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase waktu pembuka \'During break time\' wajib diikuti koma sebelum subjek \'the school canteen\'.',
              ],
              [
                'id' => 70,
                'id_sentence' => 'Berdasarkan hasil pemungutan suara kelas, tema study tour tahun ini adalah pantai.',
                'target_word' => 'Based on the class vote,',
                'vocab' => [
                  'class vote' => [
                    'id' => 'pemungutan suara kelas',
                    'pos' => '(n phr)',
                  ],
                  'this year\'s study tour theme' => [
                    'id' => 'tema study tour tahun ini',
                    'pos' => '(n phr)',
                  ],
                  'the beach' => [
                    'id' => 'pantai',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'Based on the class vote, this year\'s study tour theme is the beach.',
                  'Based on the class vote this year\'s study tour theme is the beach.',
                  'According the class vote, this year\'s study tour theme is the beach.',
                  'From on the class vote, this year\'s study tour theme is the beach.',
                ],
                'correct_index' => 0,
                'explanation' => 'Frase atribusi pembuka \'Based on the class vote\' wajib diikuti koma sebelum subjek \'this year\'s study tour theme\'.',
              ],
            ],
          ],
          [
            'id' => 'prep_stacking',
            'name' => 'Multi-Prepositional Phrase Stacking in Everyday Stories',
            'code' => '1.5.8',
            'concept_title' => 'Sintesis Penumpukan Frase Preposisi Majemuk dalam Cerita Sehari-hari',
            'concept_description' => 'Saat bercerita, kita sering kali perlu merangkai beberapa frase preposisi (Prepositional Stacking) untuk merinci cara, lokasi, dan waktu sebuah kejadian dalam satu kalimat. Urutan alami yang dianjurkan untuk menghindari kerancuan adalah: [Klausa Inti: S + V + O] + [Frase Cara/Instrumen] + [Frase Lokasi] + [Frase Waktu/Kondisi].',
            'formula' => 'Subject + Verb + Object + [by / through Instrument] + [in / at Location] + [during / under Conditions]',
            'rules' => [
              'Pastikan setiap frase preposisi menempel pada kata benda atau kata kerja yang tepat.',
              'Urutan alami: Cara/Instrumen (by/through) -> Tempat (in/at) -> Waktu/Kondisi (during/under).',
              'Jangan menyisipkan tanda koma jika penumpukan frase preposisi berada di akhir kalimat dan memodifikasi predikat secara esensial.',
              'Kombinasi ini membuat cerita lebih detail dan mudah dibayangkan.',
            ],
            'exercises' => [
              [
                'id' => 71,
                'id_sentence' => 'Para pemadam kebakaran memadamkan api melalui selang air bertekanan tinggi di gudang tua selama malam hujan deras.',
                'target_word' => 'through high-pressure hoses at the old warehouse during the heavy rainy night',
                'vocab' => [
                  'extinguish the fire' => [
                    'id' => 'memadamkan api',
                    'pos' => '(v phr)',
                  ],
                  'high-pressure hoses' => [
                    'id' => 'selang air bertekanan tinggi',
                    'pos' => '(n phr)',
                  ],
                  'old warehouse' => [
                    'id' => 'gudang tua',
                    'pos' => '(n phr)',
                  ],
                  'heavy rainy night' => [
                    'id' => 'malam hujan deras',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Firefighters extinguish the fire through high-pressure hoses at the old warehouse during the heavy rainy night.',
                  'Firefighters extinguish the fire by high-pressure hoses in the old warehouse while the heavy rainy night.',
                  'Firefighters extinguish the fire through high-pressure hoses on the old warehouse during the heavy rainy night.',
                  'Firefighters extinguish the fire with high-pressure hoses into the old warehouse within the heavy rainy night.',
                ],
                'correct_index' => 0,
                'explanation' => 'Penumpukan tiga frase preposisi: \'through high-pressure hoses\' (cara) + \'at the old warehouse\' (lokasi) + \'during the heavy rainy night\' (waktu).',
              ],
              [
                'id' => 72,
                'id_sentence' => 'Kakak menjual kue kering melalui toko daring sederhana di rumah selama bulan Ramadan.',
                'target_word' => 'through a simple online shop at home during Ramadan',
                'vocab' => [
                  'sells cookies' => [
                    'id' => 'menjual kue kering',
                    'pos' => '(v phr)',
                  ],
                  'simple online shop' => [
                    'id' => 'toko daring sederhana',
                    'pos' => '(n phr)',
                  ],
                  'during Ramadan' => [
                    'id' => 'selama bulan Ramadan',
                    'pos' => '(prep phr)',
                  ],
                ],
                'options' => [
                  'My sister sells cookies through a simple online shop at home during Ramadan.',
                  'My sister sells cookies by a simple online shop in home while Ramadan.',
                  'My sister sells cookies through a simple online shop on home during Ramadan.',
                  'My sister sells cookies with a simple online shop into home within Ramadan.',
                ],
                'correct_index' => 0,
                'explanation' => 'Urutan alami: cara (through...) -> lokasi (at home) -> waktu (during Ramadan).',
              ],
              [
                'id' => 73,
                'id_sentence' => 'Tim penyelamat mengevakuasi warga melalui perahu karet di sungai yang meluap selama musim hujan.',
                'target_word' => 'by rubber boats on the overflowing river during the rainy season',
                'vocab' => [
                  'rescue team' => [
                    'id' => 'tim penyelamat',
                    'pos' => '(n phr)',
                  ],
                  'evacuates residents' => [
                    'id' => 'mengevakuasi warga',
                    'pos' => '(v phr)',
                  ],
                  'rubber boats' => [
                    'id' => 'perahu karet',
                    'pos' => '(n phr)',
                  ],
                  'overflowing river' => [
                    'id' => 'sungai yang meluap',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The rescue team evacuates residents by rubber boats on the overflowing river during the rainy season.',
                  'The rescue team evacuates residents through rubber boats at the overflowing river while the rainy season.',
                  'The rescue team evacuates residents by rubber boats in the overflowing river within the rainy season.',
                  'The rescue team evacuates residents with rubber boats into the overflowing river upon the rainy season.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tiga frase preposisi tersusun: cara (by rubber boats) -> lokasi (on the river) -> waktu (during the rainy season).',
              ],
              [
                'id' => 74,
                'id_sentence' => 'Para siswa mempresentasikan proyek sains mereka melalui poster besar di aula sekolah pada acara pameran tahunan.',
                'target_word' => 'through large posters in the school hall during the annual exhibition',
                'vocab' => [
                  'present their science project' => [
                    'id' => 'mempresentasikan proyek sains mereka',
                    'pos' => '(v phr)',
                  ],
                  'large posters' => [
                    'id' => 'poster besar',
                    'pos' => '(n phr)',
                  ],
                  'annual exhibition' => [
                    'id' => 'pameran tahunan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The students present their science project through large posters in the school hall during the annual exhibition.',
                  'The students present their science project by large posters at the school hall while the annual exhibition.',
                  'The students present their science project through large posters on the school hall during the annual exhibition.',
                  'The students present their science project with large posters into the school hall within the annual exhibition.',
                ],
                'correct_index' => 0,
                'explanation' => 'Urutan tiga frase: cara (through posters) -> lokasi (in the hall) -> waktu (during the exhibition).',
              ],
              [
                'id' => 75,
                'id_sentence' => 'Keluarga kami merayakan ulang tahun Ayah melalui pesta kejutan kecil di taman belakang pada sore yang cerah.',
                'target_word' => 'with a small surprise party in the backyard on a sunny afternoon',
                'vocab' => [
                  'our family' => [
                    'id' => 'keluarga kami',
                    'pos' => '(n phr)',
                  ],
                  'celebrates Dad\'s birthday' => [
                    'id' => 'merayakan ulang tahun Ayah',
                    'pos' => '(v phr)',
                  ],
                  'small surprise party' => [
                    'id' => 'pesta kejutan kecil',
                    'pos' => '(n phr)',
                  ],
                  'sunny afternoon' => [
                    'id' => 'sore yang cerah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Our family celebrates Dad\'s birthday with a small surprise party in the backyard on a sunny afternoon.',
                  'Our family celebrates Dad\'s birthday by a small surprise party at the backyard during a sunny afternoon.',
                  'Our family celebrates Dad\'s birthday with a small surprise party on the backyard in a sunny afternoon.',
                  'Our family celebrates Dad\'s birthday through a small surprise party into the backyard within a sunny afternoon.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tiga frase preposisi: cara (with a party) -> lokasi (in the backyard) -> waktu (on a sunny afternoon).',
              ],
              [
                'id' => 76,
                'id_sentence' => 'Petugas perpustakaan mengatur buku-buku baru melalui sistem label warna di rak depan selama jam istirahat.',
                'target_word' => 'through a color-label system on the front shelf during break time',
                'vocab' => [
                  'librarian' => [
                    'id' => 'petugas perpustakaan',
                    'pos' => '(n phr)',
                  ],
                  'organizes the new books' => [
                    'id' => 'mengatur buku-buku baru',
                    'pos' => '(v phr)',
                  ],
                  'color-label system' => [
                    'id' => 'sistem label warna',
                    'pos' => '(n phr)',
                  ],
                  'front shelf' => [
                    'id' => 'rak depan',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The librarian organizes the new books through a color-label system on the front shelf during break time.',
                  'The librarian organizes the new books by a color-label system at the front shelf while break time.',
                  'The librarian organizes the new books through a color-label system in the front shelf during break time.',
                  'The librarian organizes the new books with a color-label system into the front shelf within break time.',
                ],
                'correct_index' => 0,
                'explanation' => 'Urutan tiga frase: cara (through the system) -> lokasi (on the shelf) -> waktu (during break time).',
              ],
              [
                'id' => 77,
                'id_sentence' => 'Nenek mengajari kami membuat batik melalui contoh langsung di teras rumah pada akhir pekan.',
                'target_word' => 'through direct demonstration on the porch on weekends',
                'vocab' => [
                  'teaches us to make batik' => [
                    'id' => 'mengajari kami membuat batik',
                    'pos' => '(v phr)',
                  ],
                  'direct demonstration' => [
                    'id' => 'contoh langsung',
                    'pos' => '(n phr)',
                  ],
                  'porch' => [
                    'id' => 'teras rumah',
                    'pos' => '(n)',
                  ],
                ],
                'options' => [
                  'Grandma teaches us to make batik through direct demonstration on the porch on weekends.',
                  'Grandma teaches us to make batik by direct demonstration at the porch during weekends.',
                  'Grandma teaches us to make batik through direct demonstration in the porch on weekends.',
                  'Grandma teaches us to make batik with direct demonstration into the porch within weekends.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tiga frase: cara (through demonstration) -> lokasi (on the porch) -> waktu (on weekends).',
              ],
              [
                'id' => 78,
                'id_sentence' => 'Tim basket kami berlatih lemparan bebas melalui sesi khusus di lapangan indoor setiap pagi.',
                'target_word' => 'through special sessions in the indoor court every morning',
                'vocab' => [
                  'our basketball team' => [
                    'id' => 'tim basket kami',
                    'pos' => '(n phr)',
                  ],
                  'practices free throws' => [
                    'id' => 'berlatih lemparan bebas',
                    'pos' => '(v phr)',
                  ],
                  'special sessions' => [
                    'id' => 'sesi khusus',
                    'pos' => '(n phr)',
                  ],
                  'indoor court' => [
                    'id' => 'lapangan indoor',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Our basketball team practices free throws through special sessions in the indoor court every morning.',
                  'Our basketball team practices free throws by special sessions at the indoor court while every morning.',
                  'Our basketball team practices free throws through special sessions on the indoor court every morning.',
                  'Our basketball team practices free throws with special sessions into the indoor court within every morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Urutan: cara (through sessions) -> lokasi (in the court) -> waktu (every morning).',
              ],
              [
                'id' => 79,
                'id_sentence' => 'Panitia kelas mengumpulkan sumbangan melalui kotak kardus sederhana di meja guru selama seminggu penuh.',
                'target_word' => 'through a simple cardboard box on the teacher\'s desk for a whole week',
                'vocab' => [
                  'class committee' => [
                    'id' => 'panitia kelas',
                    'pos' => '(n phr)',
                  ],
                  'collects donations' => [
                    'id' => 'mengumpulkan sumbangan',
                    'pos' => '(v phr)',
                  ],
                  'simple cardboard box' => [
                    'id' => 'kotak kardus sederhana',
                    'pos' => '(n phr)',
                  ],
                  'teacher\'s desk' => [
                    'id' => 'meja guru',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'The class committee collects donations through a simple cardboard box on the teacher\'s desk for a whole week.',
                  'The class committee collects donations by a simple cardboard box at the teacher\'s desk during a whole week.',
                  'The class committee collects donations through a simple cardboard box in the teacher\'s desk for a whole week.',
                  'The class committee collects donations with a simple cardboard box into the teacher\'s desk within a whole week.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tiga frase: cara (through the box) -> lokasi (on the desk) -> waktu (for a whole week).',
              ],
              [
                'id' => 80,
                'id_sentence' => 'Ayah memperbaiki genteng bocor melalui lem khusus di atap rumah pada pagi yang cerah.',
                'target_word' => 'with special adhesive on the roof on a clear morning',
                'vocab' => [
                  'fixes the leaking roof tile' => [
                    'id' => 'memperbaiki genteng bocor',
                    'pos' => '(v phr)',
                  ],
                  'special adhesive' => [
                    'id' => 'lem khusus',
                    'pos' => '(n phr)',
                  ],
                  'roof' => [
                    'id' => 'atap rumah',
                    'pos' => '(n)',
                  ],
                  'clear morning' => [
                    'id' => 'pagi yang cerah',
                    'pos' => '(n phr)',
                  ],
                ],
                'options' => [
                  'Dad fixes the leaking roof tile with special adhesive on the roof on a clear morning.',
                  'Dad fixes the leaking roof tile by special adhesive at the roof during a clear morning.',
                  'Dad fixes the leaking roof tile with special adhesive in the roof on a clear morning.',
                  'Dad fixes the leaking roof tile through special adhesive into the roof within a clear morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Tiga frase preposisi: cara (with adhesive) -> lokasi (on the roof) -> waktu (on a clear morning).',
              ],
            ],
          ],
        ];
    }
}
