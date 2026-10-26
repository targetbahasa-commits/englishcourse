<?php

namespace App\Services;

class SelfStudyModalAuxiliariesData
{
    /**
     * Get the complete Modal Auxiliaries (Level 101) package.
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
            'concept_summary' => 'Modal Auxiliaries (can, could, may, might, should, must, will, would) adalah kata kerja bantu khusus untuk menambahkan makna penting pada kalimat—seperti menyatakan kemungkinan, kemampuan, saran, keharusan, maupun dugaan. Ciri khas utama semua modal: selalu diikuti kata kerja bentuk dasar (V1 murni tanpa -s, -es, -ed, atau -ing) dan tidak boleh disisipkan partikel "to" langsung setelah modal.',
            'rules' => [
                [
                    'rule_title' => '1. Menyatakan Kemungkinan (May, Might, Could)',
                    'rule_formula' => 'Subject + MAY / MIGHT / COULD + Bare Infinitive (V1)',
                    'rule_description' => 'Gunakan "may", "might", atau "could" untuk menyatakan hal yang mungkin terjadi. Modal selalu diikuti kata kerja dasar murni tanpa imbuhan apapun.',
                    'examples' => [
                        [
                            'en' => 'It might rain this afternoon, so take an umbrella.',
                            'id' => 'Mungkin hujan sore ini, jadi bawalah payung.',
                            'note' => 'Bentuk "might rain" digunakan untuk menyatakan kemungkinan di masa depan.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Menyatakan Kemampuan vs Kesimpulan Pasti (Can vs Must / Cannot)',
                    'rule_formula' => 'Can + V1 (Kemampuan) | Must / Cannot + BE (Kesimpulan Pasti / Mustahil)',
                    'rule_description' => '"Can" menyatakan kemampuan nyata seseorang. "Must be" menyatakan kesimpulan yang hampir pasti, sedangkan lawannya adalah "cannot be" (tidak mungkin, bukan must not).',
                    'examples' => [
                        [
                            'en' => 'He is not answering his phone, so he must be asleep.',
                            'id' => 'Dia tidak menjawab teleponnya, jadi dia pasti sedang tidur.',
                            'note' => 'Gunakan "must be" untuk menyatakan kesimpulan yang hampir pasti benar.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Menyatakan Saran & Rekomendasi (Should, Ought to)',
                    'rule_formula' => 'Subject + SHOULD / OUGHT TO + V1',
                    'rule_description' => 'Gunakan "should" atau "ought to" untuk menyampaikan saran atau anjuran secara sopan.',
                    'examples' => [
                        [
                            'en' => 'You should drink more water every day.',
                            'id' => 'Kamu sebaiknya minum lebih banyak air setiap hari.',
                            'note' => '"Should drink" menyampaikan saran yang baik untuk kesehatan.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Bentuk Pasif Modal & Dugaan Masa Lalu (Modal + Be + V3 / Modal + Have + V3)',
                    'rule_formula' => 'Pasif: Modal + BE + V3 | Masa Lalu: Modal + HAVE + V3',
                    'rule_description' => 'Pola pasif modal ("must be cleaned", "can be fixed") memfokuskan kalimat pada tindakannya. Pola masa lalu ("may have forgotten", "should have called") digunakan untuk menduga atau menyesali hal yang sudah terjadi.',
                    'examples' => [
                        [
                            'en' => 'She may have forgotten about our meeting today.',
                            'id' => 'Dia mungkin lupa tentang pertemuan kita hari ini.',
                            'note' => 'Menggunakan "may have forgotten" untuk menduga sesuatu yang terjadi di masa lalu.'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Modal Auxiliary', 'Fungsi Utama', 'Makna / Nuansa', 'Contoh Kalimat'],
                'rows' => [
                    ['may / might / could', 'Menyatakan Kemungkinan', 'Mungkin / Barangkali', 'She might join us for dinner tonight.'],
                    ['can / is able to', 'Menyatakan Kemampuan', 'Dapat / Bisa / Mampu', 'My little brother can swim very well.'],
                    ['should / ought to', 'Menyatakan Saran / Anjuran', 'Sebaiknya / Seharusnya', 'You should wear a jacket; it is cold outside.'],
                    ['must / cannot', 'Kesimpulan Pasti', 'Pasti (must) / Mustahil (cannot)', 'That cannot be true; I just saw him yesterday.'],
                    ['will / would', 'Masa Depan & Pengandaian', 'Akan (will) / Bersyarat (would)', 'I would help you if I had more free time.'],
                    ['modal + be + V3', 'Bentuk Pasif', 'Dapat / Harus di-...', 'The dishes must be washed before dinner.'],
                    ['modal + have + V3', 'Dugaan / Penyesalan Masa Lalu', 'Mungkin telah / Seharusnya sudah', 'You should have told me you were coming.'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'She might comes to the party tonight.',
                    'correct' => 'She might come to the party tonight.',
                    'explanation' => 'Modal selalu diikuti bentuk kata kerja dasar (V1 murni tanpa tambahan -s/-es).'
                ],
                [
                    'incorrect' => 'He did not call, so he must not be busy.',
                    'correct' => 'He did not call, so he cannot be busy.',
                    'explanation' => 'Untuk menarik kesimpulan bahwa sesuatu "tidak mungkin benar", gunakan "cannot be", bukan "must not be".'
                ],
                [
                    'incorrect' => 'I think I may has left my keys at home.',
                    'correct' => 'I think I may have left my keys at home.',
                    'explanation' => 'Setelah modal, selalu gunakan kata dasar "have", dilarang menggunakan "has" atau "had".'
                ],
                [
                    'incorrect' => 'You can to borrow my pen if you need one.',
                    'correct' => 'You can borrow my pen if you need one.',
                    'explanation' => 'Dilarang meletakkan partikel "to" langsung setelah modal dasar (can, may, must, should, will).'
                ],
            ],
            'exam_tips' => [
                'Gunakan modal seperti "may" atau "could" saat kamu tidak 100% yakin tentang sesuatu.',
                'Pastikan kata kerja setelah modal selalu kembali ke bentuk dasar (V1 murni tanpa -s, -ed, atau -ing).',
                'Ingat lawan kata dalam kesimpulan: "must be" (pasti benar) >< "cannot be" (mustahil/tidak mungkin benar).'
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
            'id' => 'possibility_may_might_could',
            'name' => 'Menyatakan Kemungkinan (May, Might, Could)',
            'code' => '1.7.1',
            'concept_title' => 'Menyatakan Kemungkinan (May, Might, Could)',
            'concept_description' => 'Dalam percakapan dan tulisan sehari-hari, kita sering tidak 100% yakin tentang sesuatu. Modal "may", "might", dan "could" digunakan untuk menyatakan hal yang mungkin terjadi atau mungkin benar, tanpa membuat klaim yang terlalu pasti.',
            'formula' => 'Subject + MAY / MIGHT / COULD + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan "may" untuk kemungkinan yang cukup masuk akal.',
              'Gunakan "might" atau "could" untuk kemungkinan yang lebih tidak pasti atau sekadar dugaan.',
              'Modal selalu diikuti kata kerja bentuk dasar (Bare Infinitive / V1 murni), dilarang menambahkan "to" atau akhiran -s/-es.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Kakak saya mungkin datang ke pesta ulang tahunmu akhir pekan ini.',
                'target_word' => 'may come',
                'vocab' => [
                  'my sister' => ['id' => 'kakak/adik perempuan saya', 'pos' => '(n phr)'],
                  'may' => ['id' => 'mungkin', 'pos' => '(modal)'],
                  'come' => ['id' => 'datang', 'pos' => '(v)'],
                  'birthday party' => ['id' => 'pesta ulang tahun', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'My sister may come to your birthday party this weekend.',
                  'My sister may comes to your birthday party this weekend.',
                  'My sister may to come to your birthday party this weekend.',
                  'My sister may coming to your birthday party this weekend.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "may" wajib diikuti bentuk dasar kata kerja ("may come"), bukan "comes", "to come", atau "coming".',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Cuaca hari ini mungkin berubah menjadi hujan deras pada sore hari.',
                'target_word' => 'might turn',
                'vocab' => [
                  "today's weather" => ['id' => 'cuaca hari ini', 'pos' => '(n phr)'],
                  'might' => ['id' => 'mungkin', 'pos' => '(modal)'],
                  'turn into' => ['id' => 'berubah menjadi', 'pos' => '(v phr)'],
                  'heavy rain' => ['id' => 'hujan deras', 'pos' => '(n phr)'],
                ],
                'options' => [
                  "Today's weather might turn into heavy rain this afternoon.",
                  "Today's weather might turns into heavy rain this afternoon.",
                  "Today's weather might to turn into heavy rain this afternoon.",
                  "Today's weather might turning into heavy rain this afternoon.",
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti kata kerja dasar ("might turn") untuk menyatakan kemungkinan cuaca.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Harga tiket pesawat mungkin naik menjelang musim liburan.',
                'target_word' => 'might rise',
                'vocab' => [
                  'plane ticket prices' => ['id' => 'harga tiket pesawat', 'pos' => '(n phr)'],
                  'rise' => ['id' => 'naik', 'pos' => '(v)'],
                  'holiday season' => ['id' => 'musim liburan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'Plane ticket prices might rise before the holiday season.',
                  'Plane ticket prices might rises before the holiday season.',
                  'Plane ticket prices might to rise before the holiday season.',
                  'Plane ticket prices might rising before the holiday season.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti verba dasar ("might rise").',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Secangkir teh hangat bisa membantumu tidur lebih nyenyak malam ini.',
                'target_word' => 'could help',
                'vocab' => [
                  'a cup of warm tea' => ['id' => 'secangkir teh hangat', 'pos' => '(n phr)'],
                  'could' => ['id' => 'bisa', 'pos' => '(modal)'],
                  'help' => ['id' => 'membantu', 'pos' => '(v)'],
                  'sleep better' => ['id' => 'tidur lebih nyenyak', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'A cup of warm tea could help you sleep better tonight.',
                  'A cup of warm tea could helps you sleep better tonight.',
                  'A cup of warm tea could to help you sleep better tonight.',
                  'A cup of warm tea could helping you sleep better tonight.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "could" diikuti kata kerja dasar ("could help") untuk memberikan saran yang mungkin berguna.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Lalu lintas mungkin padat pagi ini karena ada perbaikan jalan.',
                'target_word' => 'may be',
                'vocab' => [
                  'traffic' => ['id' => 'lalu lintas', 'pos' => '(n)'],
                  'heavy' => ['id' => 'padat', 'pos' => '(adj)'],
                  'road repairs' => ['id' => 'perbaikan jalan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'Traffic may be heavy this morning because of road repairs.',
                  'Traffic may is heavy this morning because of road repairs.',
                  'Traffic may to be heavy this morning because of road repairs.',
                  'Traffic may being heavy this morning because of road repairs.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "may" diikuti "be" dalam bentuk dasar ("may be"), bukan "is" atau "being".',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Jika kamu terus begadang, kamu mungkin merasa lelah besok pagi.',
                'target_word' => 'might feel',
                'vocab' => [
                  'stay up late' => ['id' => 'begadang', 'pos' => '(v phr)'],
                  'feel' => ['id' => 'merasa', 'pos' => '(v)'],
                  'tired' => ['id' => 'lelah', 'pos' => '(adj)'],
                ],
                'options' => [
                  'If you keep staying up late, you might feel tired tomorrow morning.',
                  'If you keep staying up late, you might feels tired tomorrow morning.',
                  'If you keep staying up late, you might to feel tired tomorrow morning.',
                  'If you keep staying up late, you might feeling tired tomorrow morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti kata kerja dasar ("might feel").',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Restoran baru itu mungkin menyajikan makanan yang sangat lezat.',
                'target_word' => 'may serve',
                'vocab' => [
                  'new restaurant' => ['id' => 'restoran baru', 'pos' => '(n phr)'],
                  'serve' => ['id' => 'menyajikan', 'pos' => '(v)'],
                  'delicious food' => ['id' => 'makanan lezat', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'The new restaurant may serve very delicious food.',
                  'The new restaurant may serves very delicious food.',
                  'The new restaurant may to serve very delicious food.',
                  'The new restaurant may serving very delicious food.',
                ],
                'correct_index' => 0,
                'explanation' => '"May serve" menyatakan dugaan yang masuk akal tentang sesuatu yang belum dicoba.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Tetangga kami mungkin pindah rumah bulan depan.',
                'target_word' => 'could move',
                'vocab' => [
                  'our neighbor' => ['id' => 'tetangga kami', 'pos' => '(n phr)'],
                  'move' => ['id' => 'pindah', 'pos' => '(v)'],
                  'next month' => ['id' => 'bulan depan', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Our neighbor could move next month.',
                  'Our neighbor could moves next month.',
                  'Our neighbor could to move next month.',
                  'Our neighbor could moving next month.',
                ],
                'correct_index' => 0,
                'explanation' => '"Could move" (modal + bare verb) menyatakan kemungkinan yang belum pasti.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Latihan rutin setiap pagi mungkin membantu meningkatkan konsentrasimu.',
                'target_word' => 'might help',
                'vocab' => [
                  'regular exercise' => ['id' => 'latihan rutin', 'pos' => '(n phr)'],
                  'improve' => ['id' => 'meningkatkan', 'pos' => '(v)'],
                  'concentration' => ['id' => 'konsentrasi', 'pos' => '(n)'],
                ],
                'options' => [
                  'Regular morning exercise might help improve your concentration.',
                  'Regular morning exercise might helps improve your concentration.',
                  'Regular morning exercise might to help improve your concentration.',
                  'Regular morning exercise might helping improve your concentration.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti bare verb "help".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Film itu mungkin membuatmu menangis di bagian akhir.',
                'target_word' => 'may make',
                'vocab' => [
                  'the movie' => ['id' => 'film itu', 'pos' => '(n phr)'],
                  'make someone cry' => ['id' => 'membuat seseorang menangis', 'pos' => '(v phr)'],
                  'ending' => ['id' => 'bagian akhir', 'pos' => '(n)'],
                ],
                'options' => [
                  'The movie may make you cry at the ending.',
                  'The movie may makes you cry at the ending.',
                  'The movie may to make you cry at the ending.',
                  'The movie may making you cry at the ending.',
                ],
                'correct_index' => 0,
                'explanation' => '"May make" adalah frasa modal umum untuk menyatakan dugaan tentang reaksi seseorang.',
              ],
            ],
          ],
          [
            'id' => 'ability_can_could',
            'name' => 'Menyatakan Kemampuan & Kapabilitas (Can, Could, Be able to)',
            'code' => '1.7.2',
            'concept_title' => 'Menyatakan Kemampuan & Kapabilitas (Can, Could, Be able to)',
            'concept_description' => 'Modal "can" digunakan untuk menyatakan kemampuan seseorang melakukan sesuatu saat ini, sementara "could" digunakan untuk kemampuan di masa lalu. "Be able to" bisa dipakai sebagai pengganti "can" dalam berbagai bentuk waktu.',
            'formula' => 'Subject + CAN / COULD + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan "can + V1" untuk kemampuan di masa sekarang.',
              'Dilarang menambahkan "to" setelah modal "can" (misal: "can to swim" salah; "can swim" benar).',
              'Gunakan "could" untuk kemampuan di masa lalu (misal: "When I was young, I could run very fast").',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Adik saya bisa berenang sejauh seratus meter tanpa berhenti.',
                'target_word' => 'can swim',
                'vocab' => [
                  'my little sibling' => ['id' => 'adik saya', 'pos' => '(n phr)'],
                  'can' => ['id' => 'bisa', 'pos' => '(modal)'],
                  'swim' => ['id' => 'berenang', 'pos' => '(v)'],
                  'without stopping' => ['id' => 'tanpa berhenti', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'My little sibling can swim one hundred meters without stopping.',
                  'My little sibling can swims one hundred meters without stopping.',
                  'My little sibling can to swim one hundred meters without stopping.',
                  'My little sibling can swimming one hundred meters without stopping.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bentuk dasar kata kerja ("can swim"), bukan "swims", "to swim", atau "swimming".',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Ayah saya bisa memperbaiki hampir semua barang elektronik di rumah.',
                'target_word' => 'can fix',
                'vocab' => [
                  'my father' => ['id' => 'ayah saya', 'pos' => '(n phr)'],
                  'fix' => ['id' => 'memperbaiki', 'pos' => '(v)'],
                  'almost any' => ['id' => 'hampir semua', 'pos' => '(det)'],
                  'electronic device' => ['id' => 'barang elektronik', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'My father can fix almost any electronic device at home.',
                  'My father can fixes almost any electronic device at home.',
                  'My father can to fix almost any electronic device at home.',
                  'My father can fixing almost any electronic device at home.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti verba dasar ("can fix").',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Waktu masih kecil, saya bisa memanjat pohon mangga di belakang rumah.',
                'target_word' => 'could climb',
                'vocab' => [
                  'when I was young' => ['id' => 'waktu masih kecil', 'pos' => '(adv phr)'],
                  'could' => ['id' => 'dulu bisa', 'pos' => '(modal)'],
                  'climb' => ['id' => 'memanjat', 'pos' => '(v)'],
                  'mango tree' => ['id' => 'pohon mangga', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'When I was young, I could climb the mango tree behind our house.',
                  'When I was young, I could climbs the mango tree behind our house.',
                  'When I was young, I could to climb the mango tree behind our house.',
                  'When I was young, I could climbing the mango tree behind our house.',
                ],
                'correct_index' => 0,
                'explanation' => '"Could climb" menyatakan kemampuan di masa lalu dengan kata kerja bentuk dasar.',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Teman sekelasku bisa berbicara tiga bahasa dengan lancar.',
                'target_word' => 'can speak',
                'vocab' => [
                  'my classmate' => ['id' => 'teman sekelasku', 'pos' => '(n phr)'],
                  'speak' => ['id' => 'berbicara', 'pos' => '(v)'],
                  'fluently' => ['id' => 'dengan lancar', 'pos' => '(adv)'],
                ],
                'options' => [
                  'My classmate can speak three languages fluently.',
                  'My classmate can speaks three languages fluently.',
                  'My classmate can to speak three languages fluently.',
                  'My classmate can speaking three languages fluently.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "speak".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Mobil ini bisa menampung tujuh penumpang dengan nyaman.',
                'target_word' => 'can carry',
                'vocab' => [
                  'this car' => ['id' => 'mobil ini', 'pos' => '(n phr)'],
                  'carry' => ['id' => 'menampung / membawa', 'pos' => '(v)'],
                  'passengers' => ['id' => 'penumpang', 'pos' => '(n)'],
                  'comfortably' => ['id' => 'dengan nyaman', 'pos' => '(adv)'],
                ],
                'options' => [
                  'This car can carry seven passengers comfortably.',
                  'This car can carries seven passengers comfortably.',
                  'This car can to carry seven passengers comfortably.',
                  'This car can carrying seven passengers comfortably.',
                ],
                'correct_index' => 0,
                'explanation' => '"Can carry" menyatakan kapasitas atau kemampuan sebuah benda.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Nenek saya masih bisa membaca tanpa kacamata.',
                'target_word' => 'can read',
                'vocab' => [
                  'my grandmother' => ['id' => 'nenek saya', 'pos' => '(n phr)'],
                  'still' => ['id' => 'masih', 'pos' => '(adv)'],
                  'read' => ['id' => 'membaca', 'pos' => '(v)'],
                  'without glasses' => ['id' => 'tanpa kacamata', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'My grandmother can still read without glasses.',
                  'My grandmother can still reads without glasses.',
                  'My grandmother can still to read without glasses.',
                  'My grandmother can still reading without glasses.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti verba dasar ("can read").',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Saat masih muda, kakek bisa berlari sangat cepat.',
                'target_word' => 'could run',
                'vocab' => [
                  'grandfather' => ['id' => 'kakek', 'pos' => '(n)'],
                  'run' => ['id' => 'berlari', 'pos' => '(v)'],
                  'very fast' => ['id' => 'sangat cepat', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'When he was young, grandfather could run very fast.',
                  'When he was young, grandfather could runs very fast.',
                  'When he was young, grandfather could to run very fast.',
                  'When he was young, grandfather could running very fast.',
                ],
                'correct_index' => 0,
                'explanation' => '"Could run" (modal + bare verb) menyatakan kemampuan di masa lalu.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Anjing kami bisa membuka pintu dengan hidungnya.',
                'target_word' => 'can open',
                'vocab' => [
                  'our dog' => ['id' => 'anjing kami', 'pos' => '(n phr)'],
                  'open' => ['id' => 'membuka', 'pos' => '(v)'],
                  'with its nose' => ['id' => 'dengan hidungnya', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Our dog can open the door with its nose.',
                  'Our dog can opens the door with its nose.',
                  'Our dog can to open the door with its nose.',
                  'Our dog can opening the door with its nose.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "open".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Saya belum bisa mengendarai sepeda motor, tapi saya bisa naik sepeda.',
                'target_word' => 'can ride',
                'vocab' => [
                  'not yet' => ['id' => 'belum', 'pos' => '(adv)'],
                  'motorbike' => ['id' => 'sepeda motor', 'pos' => '(n)'],
                  'ride' => ['id' => 'mengendarai / mengendarai (sepeda)', 'pos' => '(v)'],
                  'bicycle' => ['id' => 'sepeda', 'pos' => '(n)'],
                ],
                'options' => [
                  "I can't ride a motorbike yet, but I can ride a bicycle.",
                  "I can't ride a motorbike yet, but I can rides a bicycle.",
                  "I can't ride a motorbike yet, but I can to ride a bicycle.",
                  "I can't ride a motorbike yet, but I can riding a bicycle.",
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "ride".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Tim kami bisa menyelesaikan proyek itu sebelum tenggat waktu.',
                'target_word' => 'can finish',
                'vocab' => [
                  'our team' => ['id' => 'tim kami', 'pos' => '(n phr)'],
                  'finish' => ['id' => 'menyelesaikan', 'pos' => '(v)'],
                  'deadline' => ['id' => 'tenggat waktu', 'pos' => '(n)'],
                ],
                'options' => [
                  'Our team can finish the project before the deadline.',
                  'Our team can finishes the project before the deadline.',
                  'Our team can to finish the project before the deadline.',
                  'Our team can finishing the project before the deadline.',
                ],
                'correct_index' => 0,
                'explanation' => '"Can finish" menyatakan kemampuan tim menyelesaikan sesuatu tepat waktu.',
              ],
            ],
          ],
          [
            'id' => 'advice_should_ought_to',
            'name' => 'Menyatakan Saran & Rekomendasi (Should, Ought to)',
            'code' => '1.7.3',
            'concept_title' => 'Menyatakan Saran & Rekomendasi (Should, Ought to)',
            'concept_description' => 'Gunakan "should" atau "ought to" ketika kamu ingin memberi saran atau anjuran kepada orang lain tentang apa yang sebaiknya dilakukan.',
            'formula' => 'Subject + SHOULD / OUGHT TO + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan "should + V1" untuk memberi saran sehari-hari.',
              '"Ought to" memiliki arti yang sama dengan "should", tapi jarang dipakai dalam percakapan santai.',
              'Bentuk negatif: "should not / shouldn\'t + V1".',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Kamu sebaiknya tidur lebih awal malam ini.',
                'target_word' => 'should sleep',
                'vocab' => [
                  'should' => ['id' => 'sebaiknya', 'pos' => '(modal)'],
                  'sleep' => ['id' => 'tidur', 'pos' => '(v)'],
                  'earlier' => ['id' => 'lebih awal', 'pos' => '(adv)'],
                ],
                'options' => [
                  'You should sleep earlier tonight.',
                  'You should sleeps earlier tonight.',
                  'You should to sleep earlier tonight.',
                  'You should sleeping earlier tonight.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bentuk dasar kata kerja ("should sleep").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Kita sebaiknya membawa payung karena langit terlihat mendung.',
                'target_word' => 'should bring',
                'vocab' => [
                  'bring' => ['id' => 'membawa', 'pos' => '(v)'],
                  'umbrella' => ['id' => 'payung', 'pos' => '(n)'],
                  'cloudy' => ['id' => 'mendung', 'pos' => '(adj)'],
                ],
                'options' => [
                  'We should bring an umbrella because the sky looks cloudy.',
                  'We should brings an umbrella because the sky looks cloudy.',
                  'We should to bring an umbrella because the sky looks cloudy.',
                  'We should bringing an umbrella because the sky looks cloudy.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should bring").',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Kamu sebaiknya tidak makan terlalu banyak gula setiap hari.',
                'target_word' => 'should not eat',
                'vocab' => [
                  'should not' => ['id' => 'sebaiknya tidak', 'pos' => '(modal)'],
                  'eat' => ['id' => 'makan', 'pos' => '(v)'],
                  'too much sugar' => ['id' => 'terlalu banyak gula', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'You should not eat too much sugar every day.',
                  'You should not eats too much sugar every day.',
                  'You should not to eat too much sugar every day.',
                  'You should not eating too much sugar every day.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk negatif modal tetap diikuti verba dasar ("should not eat").',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Dia sebaiknya meminta maaf kepada temannya.',
                'target_word' => 'should apologize',
                'vocab' => [
                  'apologize' => ['id' => 'meminta maaf', 'pos' => '(v)'],
                  'to his friend' => ['id' => 'kepada temannya', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'He should apologize to his friend.',
                  'He should apologizes to his friend.',
                  'He should to apologize to his friend.',
                  'He should apologizing to his friend.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bare verb "apologize".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Kamu sebaiknya memeriksakan giggimu ke dokter setiap enam bulan.',
                'target_word' => 'should check',
                'vocab' => [
                  'check' => ['id' => 'memeriksakan', 'pos' => '(v)'],
                  'teeth' => ['id' => 'gigi', 'pos' => '(n)'],
                  'every six months' => ['id' => 'setiap enam bulan', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'You should check your teeth every six months.',
                  'You should checks your teeth every six months.',
                  'You should to check your teeth every six months.',
                  'You should checking your teeth every six months.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should check").',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Mereka sebaiknya mempersiapkan rencana cadangan untuk acara itu.',
                'target_word' => 'should prepare',
                'vocab' => [
                  'prepare' => ['id' => 'mempersiapkan', 'pos' => '(v)'],
                  'backup plan' => ['id' => 'rencana cadangan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'They should prepare a backup plan for the event.',
                  'They should prepares a backup plan for the event.',
                  'They should to prepare a backup plan for the event.',
                  'They should preparing a backup plan for the event.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bare verb "prepare".',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Kita sebaiknya mematikan lampu sebelum tidur untuk menghemat listrik.',
                'target_word' => 'should turn off',
                'vocab' => [
                  'turn off' => ['id' => 'mematikan', 'pos' => '(v phr)'],
                  'save electricity' => ['id' => 'menghemat listrik', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'We should turn off the lights before sleeping to save electricity.',
                  'We should turns off the lights before sleeping to save electricity.',
                  'We should to turn off the lights before sleeping to save electricity.',
                  'We should turning off the lights before sleeping to save electricity.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should turn off").',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Siswa sebaiknya mengumpulkan tugas tepat waktu.',
                'target_word' => 'should submit',
                'vocab' => [
                  'students' => ['id' => 'siswa', 'pos' => '(n)'],
                  'submit' => ['id' => 'mengumpulkan', 'pos' => '(v)'],
                  'on time' => ['id' => 'tepat waktu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Students should submit their homework on time.',
                  'Students should submits their homework on time.',
                  'Students should to submit their homework on time.',
                  'Students should submitting their homework on time.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bare verb "submit".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Kamu sebaiknya beristirahat jika merasa sangat lelah.',
                'target_word' => 'should rest',
                'vocab' => [
                  'rest' => ['id' => 'beristirahat', 'pos' => '(v)'],
                  'very tired' => ['id' => 'sangat lelah', 'pos' => '(adj phr)'],
                ],
                'options' => [
                  'You should rest if you feel very tired.',
                  'You should rests if you feel very tired.',
                  'You should to rest if you feel very tired.',
                  'You should resting if you feel very tired.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should rest").',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Kita sebaiknya menghormati pendapat orang lain meskipun berbeda.',
                'target_word' => 'should respect',
                'vocab' => [
                  'respect' => ['id' => 'menghormati', 'pos' => '(v)'],
                  "others' opinions" => ['id' => 'pendapat orang lain', 'pos' => '(n phr)'],
                ],
                'options' => [
                  "We should respect others' opinions even if they are different.",
                  "We should respects others' opinions even if they are different.",
                  "We should to respect others' opinions even if they are different.",
                  "We should respecting others' opinions even if they are different.",
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bare verb "respect".',
              ],
            ],
          ],
          [
            'id' => 'certainty_must_cannot',
            'name' => 'Menyatakan Kepastian & Kesimpulan (Must, Cannot)',
            'code' => '1.7.4',
            'concept_title' => 'Menyatakan Kepastian & Kesimpulan (Must, Cannot)',
            'concept_description' => 'Gunakan "must" ketika kamu hampir yakin sesuatu itu benar berdasarkan bukti yang kamu lihat. Gunakan "cannot" ketika kamu yakin sesuatu itu mustahil atau tidak mungkin benar.',
            'formula' => 'Subject + MUST / CANNOT + BE + Adjective/Noun ATAU Subject + MUST / CANNOT + V1',
            'rules' => [
              'Gunakan "must be" untuk kesimpulan yang hampir pasti benar.',
              'Gunakan "cannot be" untuk kesimpulan bahwa sesuatu mustahil/tidak mungkin benar (bukan "must not be").',
              'Modal "must" dan "cannot" tetap diikuti kata kerja bentuk dasar.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Lampu di kamarnya menyala, jadi dia pasti ada di rumah.',
                'target_word' => 'must be',
                'vocab' => [
                  'must' => ['id' => 'pasti', 'pos' => '(modal)'],
                  'be' => ['id' => 'berada / adalah', 'pos' => '(v)'],
                  'at home' => ['id' => 'di rumah', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'The light in his room is on, so he must be at home.',
                  'The light in his room is on, so he must is at home.',
                  'The light in his room is on, so he must to be at home.',
                  'The light in his room is on, so he must being at home.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be" ("must be"), bukan "is" atau "being".',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Dia baru saja makan siang, jadi dia pasti tidak lapar sekarang.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'just had lunch' => ['id' => 'baru saja makan siang', 'pos' => '(v phr)'],
                  'cannot' => ['id' => 'tidak mungkin', 'pos' => '(modal)'],
                  'hungry' => ['id' => 'lapar', 'pos' => '(adj)'],
                ],
                'options' => [
                  'She just had lunch, so she cannot be hungry now.',
                  'She just had lunch, so she cannot is hungry now.',
                  'She just had lunch, so she cannot to be hungry now.',
                  'She just had lunch, so she cannot being hungry now.',
                ],
                'correct_index' => 0,
                'explanation' => '"Cannot be" digunakan untuk menyatakan bahwa sesuatu tidak mungkin benar.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Mobil itu sangat mahal, jadi pemiliknya pasti kaya.',
                'target_word' => 'must be',
                'vocab' => [
                  'expensive' => ['id' => 'mahal', 'pos' => '(adj)'],
                  'owner' => ['id' => 'pemilik', 'pos' => '(n)'],
                  'rich' => ['id' => 'kaya', 'pos' => '(adj)'],
                ],
                'options' => [
                  'That car is very expensive, so its owner must be rich.',
                  'That car is very expensive, so its owner must is rich.',
                  'That car is very expensive, so its owner must to be rich.',
                  'That car is very expensive, so its owner must being rich.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Anak itu menguap terus-menerus, jadi dia pasti mengantuk.',
                'target_word' => 'must be',
                'vocab' => [
                  'keep yawning' => ['id' => 'menguap terus-menerus', 'pos' => '(v phr)'],
                  'sleepy' => ['id' => 'mengantuk', 'pos' => '(adj)'],
                ],
                'options' => [
                  'The child keeps yawning, so he must be sleepy.',
                  'The child keeps yawning, so he must is sleepy.',
                  'The child keeps yawning, so he must to be sleepy.',
                  'The child keeps yawning, so he must being sleepy.',
                ],
                'correct_index' => 0,
                'explanation' => '"Must be" menyatakan kesimpulan yang hampir pasti dari sebuah tanda/bukti.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Dia bisa berbicara bahasa Prancis dengan lancar, jadi dia pasti pernah tinggal di sana.',
                'target_word' => 'must have',
                'vocab' => [
                  'fluently' => ['id' => 'dengan lancar', 'pos' => '(adv)'],
                  'must have lived' => ['id' => 'pasti pernah tinggal', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'She speaks French fluently, so she must have lived there before.',
                  'She speaks French fluently, so she must has lived there before.',
                  'She speaks French fluently, so she must to have lived there before.',
                  'She speaks French fluently, so she must having lived there before.',
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah modal, gunakan "have" bentuk dasar, bukan "has".',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Toko itu gelap dan tutup, jadi mereka pasti sudah pulang.',
                'target_word' => 'must be',
                'vocab' => [
                  'dark and closed' => ['id' => 'gelap dan tutup', 'pos' => '(adj phr)'],
                  'gone home' => ['id' => 'pulang', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The shop is dark and closed, so they must be gone home.',
                  'The shop is dark and closed, so they must is gone home.',
                  'The shop is dark and closed, so they must to be gone home.',
                  'The shop is dark and closed, so they must being gone home.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Dia baru menang lotre, jadi berita itu pasti tidak benar jika dia bilang dia bangkrut.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'win the lottery' => ['id' => 'menang lotre', 'pos' => '(v phr)'],
                  'broke' => ['id' => 'bangkrut', 'pos' => '(adj)'],
                ],
                'options' => [
                  'He just won the lottery, so it cannot be true that he is broke.',
                  'He just won the lottery, so it cannot is true that he is broke.',
                  'He just won the lottery, so it cannot to be true that he is broke.',
                  'He just won the lottery, so it cannot being true that he is broke.',
                ],
                'correct_index' => 0,
                'explanation' => '"Cannot be true" menyatakan bahwa sesuatu mustahil benar.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Pintunya terkunci dan gelap di dalam, jadi dia pasti tidak ada di rumah.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'locked' => ['id' => 'terkunci', 'pos' => '(adj)'],
                  'dark inside' => ['id' => 'gelap di dalam', 'pos' => '(adj phr)'],
                ],
                'options' => [
                  'The door is locked and it is dark inside, so he cannot be home.',
                  'The door is locked and it is dark inside, so he cannot is home.',
                  'The door is locked and it is dark inside, so he cannot to be home.',
                  'The door is locked and it is dark inside, so he cannot being home.',
                ],
                'correct_index' => 0,
                'explanation' => '"Cannot be" menyatakan sesuatu tidak mungkin benar.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Dia memakai jaket tebal, jadi pasti cuacanya dingin di luar.',
                'target_word' => 'must be',
                'vocab' => [
                  'thick jacket' => ['id' => 'jaket tebal', 'pos' => '(n phr)'],
                  'cold' => ['id' => 'dingin', 'pos' => '(adj)'],
                ],
                'options' => [
                  'He is wearing a thick jacket, so it must be cold outside.',
                  'He is wearing a thick jacket, so it must is cold outside.',
                  'He is wearing a thick jacket, so it must to be cold outside.',
                  'He is wearing a thick jacket, so it must being cold outside.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Kucing itu tidur sepanjang hari, jadi dia pasti tidak sakit.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'sleeps all day' => ['id' => 'tidur sepanjang hari', 'pos' => '(v phr)'],
                  'sick' => ['id' => 'sakit', 'pos' => '(adj)'],
                ],
                'options' => [
                  'The cat sleeps peacefully all day, so it cannot be sick.',
                  'The cat sleeps peacefully all day, so it cannot is sick.',
                  'The cat sleeps peacefully all day, so it cannot to be sick.',
                  'The cat sleeps peacefully all day, so it cannot being sick.',
                ],
                'correct_index' => 0,
                'explanation' => '"Cannot be sick" menyatakan kesimpulan bahwa sesuatu tidak mungkin benar.',
              ],
            ],
          ],
          [
            'id' => 'future_will_would',
            'name' => 'Menyatakan Masa Depan & Pengandaian (Will, Would)',
            'code' => '1.7.5',
            'concept_title' => 'Menyatakan Masa Depan & Pengandaian (Will, Would)',
            'concept_description' => '"Will" digunakan untuk menyatakan rencana, janji, atau prediksi masa depan. "Would" digunakan untuk pengandaian atau permintaan yang lebih sopan.',
            'formula' => 'Subject + WILL / WOULD + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan "will + V1" untuk keputusan, janji, atau prediksi tentang masa depan.',
              'Gunakan "would + V1" untuk pengandaian (jika... maka...) atau permintaan sopan.',
              'Bentuk negatif: "will not / won\'t" dan "would not / wouldn\'t".',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Saya akan menelepon kamu segera setelah sampai di rumah.',
                'target_word' => 'will call',
                'vocab' => [
                  'will' => ['id' => 'akan', 'pos' => '(modal)'],
                  'call' => ['id' => 'menelepon', 'pos' => '(v)'],
                  'as soon as' => ['id' => 'segera setelah', 'pos' => '(conj)'],
                ],
                'options' => [
                  'I will call you as soon as I get home.',
                  'I will calls you as soon as I get home.',
                  'I will to call you as soon as I get home.',
                  'I will calling you as soon as I get home.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bentuk dasar kata kerja ("will call").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Jika saya punya lebih banyak waktu, saya akan belajar memasak.',
                'target_word' => 'would learn',
                'vocab' => [
                  'if' => ['id' => 'jika', 'pos' => '(conj)'],
                  'would' => ['id' => 'akan (pengandaian)', 'pos' => '(modal)'],
                  'learn' => ['id' => 'belajar', 'pos' => '(v)'],
                  'cook' => ['id' => 'memasak', 'pos' => '(v)'],
                ],
                'options' => [
                  'If I had more time, I would learn to cook.',
                  'If I had more time, I would learns to cook.',
                  'If I had more time, I would to learn to cook.',
                  'If I had more time, I would learning to cook.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "would" diikuti bentuk dasar kata kerja ("would learn") dalam kalimat pengandaian.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Kami akan pergi ke pantai akhir pekan ini jika cuacanya cerah.',
                'target_word' => 'will go',
                'vocab' => [
                  'go' => ['id' => 'pergi', 'pos' => '(v)'],
                  'beach' => ['id' => 'pantai', 'pos' => '(n)'],
                  'sunny' => ['id' => 'cerah', 'pos' => '(adj)'],
                ],
                'options' => [
                  'We will go to the beach this weekend if the weather is sunny.',
                  'We will goes to the beach this weekend if the weather is sunny.',
                  'We will to go to the beach this weekend if the weather is sunny.',
                  'We will going to the beach this weekend if the weather is sunny.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bare verb "go".',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Maukah kamu membantu saya membawa tas-tas ini?',
                'target_word' => 'would you help',
                'vocab' => [
                  'would you' => ['id' => 'maukah kamu', 'pos' => '(modal phr)'],
                  'carry' => ['id' => 'membawa', 'pos' => '(v)'],
                  'bags' => ['id' => 'tas-tas', 'pos' => '(n)'],
                ],
                'options' => [
                  'Would you help me carry these bags?',
                  'Would you helps me carry these bags?',
                  'Would you to help me carry these bags?',
                  'Would you helping me carry these bags?',
                ],
                'correct_index' => 0,
                'explanation' => '"Would you help" adalah permintaan sopan dengan modal + bare verb.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Dia berjanji akan mengirim pesan begitu dia tiba di bandara.',
                'target_word' => 'will send',
                'vocab' => [
                  'promise' => ['id' => 'berjanji', 'pos' => '(v)'],
                  'send' => ['id' => 'mengirim', 'pos' => '(v)'],
                  'arrive' => ['id' => 'tiba', 'pos' => '(v)'],
                ],
                'options' => [
                  'She promises she will send a message as soon as she arrives at the airport.',
                  'She promises she will sends a message as soon as she arrives at the airport.',
                  'She promises she will to send a message as soon as she arrives at the airport.',
                  'She promises she will sending a message as soon as she arrives at the airport.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bentuk dasar kata kerja ("will send").',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Jika saya menjadi kamu, saya tidak akan membeli mobil itu.',
                'target_word' => 'would not buy',
                'vocab' => [
                  'if I were you' => ['id' => 'jika saya menjadi kamu', 'pos' => '(phr)'],
                  'would not' => ['id' => 'tidak akan', 'pos' => '(modal)'],
                  'buy' => ['id' => 'membeli', 'pos' => '(v)'],
                ],
                'options' => [
                  'If I were you, I would not buy that car.',
                  'If I were you, I would not buys that car.',
                  'If I were you, I would not to buy that car.',
                  'If I were you, I would not buying that car.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk negatif modal tetap diikuti bare verb ("would not buy").',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Sekolah akan libur selama dua minggu bulan depan.',
                'target_word' => 'will be',
                'vocab' => [
                  'school' => ['id' => 'sekolah', 'pos' => '(n)'],
                  'on holiday' => ['id' => 'libur', 'pos' => '(adj phr)'],
                  'for two weeks' => ['id' => 'selama dua minggu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'School will be on holiday for two weeks next month.',
                  'School will is on holiday for two weeks next month.',
                  'School will to be on holiday for two weeks next month.',
                  'School will being on holiday for two weeks next month.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Dia bilang dia akan datang tepat waktu besok.',
                'target_word' => 'will come',
                'vocab' => [
                  'on time' => ['id' => 'tepat waktu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'He said he will come on time tomorrow.',
                  'He said he will comes on time tomorrow.',
                  'He said he will to come on time tomorrow.',
                  'He said he will coming on time tomorrow.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bare verb "come".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Jika saya memenangkan lotre, saya akan berkeliling dunia.',
                'target_word' => 'would travel',
                'vocab' => [
                  'win the lottery' => ['id' => 'memenangkan lotre', 'pos' => '(v phr)'],
                  'travel around the world' => ['id' => 'berkeliling dunia', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'If I won the lottery, I would travel around the world.',
                  'If I won the lottery, I would travels around the world.',
                  'If I won the lottery, I would to travel around the world.',
                  'If I won the lottery, I would traveling around the world.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "would" diikuti bare verb "travel" dalam kalimat pengandaian.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Kami akan merayakan ulang tahunnya dengan kue kesukaannya.',
                'target_word' => 'will celebrate',
                'vocab' => [
                  'celebrate' => ['id' => 'merayakan', 'pos' => '(v)'],
                  'favorite cake' => ['id' => 'kue kesukaannya', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'We will celebrate her birthday with her favorite cake.',
                  'We will celebrates her birthday with her favorite cake.',
                  'We will to celebrate her birthday with her favorite cake.',
                  'We will celebrating her birthday with her favorite cake.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bare verb "celebrate".',
              ],
            ],
          ],
          [
            'id' => 'passive_modal_forms',
            'name' => 'Bentuk Pasif Modal (Modal + Be + V3)',
            'code' => '1.7.6',
            'concept_title' => 'Bentuk Pasif Modal: can be done, must be checked (Modal + Be + V3)',
            'concept_description' => 'Gunakan bentuk pasif modal ketika yang penting adalah tindakannya, bukan siapa yang melakukannya — misalnya untuk tugas rumah tangga, aturan, atau instruksi.',
            'formula' => 'Subject + MODAL (can / may / must / should) + BE + Verb 3 (Past Participle)',
            'rules' => [
              'Pola pasif modal: Modal + BE + V3.',
              'Gunakan bentuk ini saat pelaku tindakan tidak penting atau tidak disebutkan.',
              'Jangan lupa "be" setelah modal sebelum kata kerja bentuk ketiga (V3).',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Piring-piring ini harus dicuci sebelum makan malam.',
                'target_word' => 'must be washed',
                'vocab' => [
                  'dishes' => ['id' => 'piring-piring', 'pos' => '(n)'],
                  'must be washed' => ['id' => 'harus dicuci', 'pos' => '(v phr)'],
                  'before dinner' => ['id' => 'sebelum makan malam', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'These dishes must be washed before dinner.',
                  'These dishes must washed before dinner.',
                  'These dishes must be washing before dinner.',
                  'These dishes must to be washed before dinner.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk pasif modal: Modal + BE + V3 ("must be washed").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Sepeda ini bisa diperbaiki dengan mudah di bengkel dekat rumah.',
                'target_word' => 'can be fixed',
                'vocab' => [
                  'bicycle' => ['id' => 'sepeda', 'pos' => '(n)'],
                  'can be fixed' => ['id' => 'bisa diperbaiki', 'pos' => '(v phr)'],
                  'repair shop' => ['id' => 'bengkel', 'pos' => '(n)'],
                ],
                'options' => [
                  'This bicycle can be fixed easily at the repair shop near our house.',
                  'This bicycle can fixed easily at the repair shop near our house.',
                  'This bicycle can be fixing easily at the repair shop near our house.',
                  'This bicycle can to be fixed easily at the repair shop near our house.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "can be fixed" (modal + be + V3) menekankan tindakannya, bukan pelakunya.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Pintu ini harus dikunci setiap malam sebelum tidur.',
                'target_word' => 'must be locked',
                'vocab' => [
                  'door' => ['id' => 'pintu', 'pos' => '(n)'],
                  'must be locked' => ['id' => 'harus dikunci', 'pos' => '(v phr)'],
                  'every night' => ['id' => 'setiap malam', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This door must be locked every night before bed.',
                  'This door must locked every night before bed.',
                  'This door must be locking every night before bed.',
                  'This door must to be locked every night before bed.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: Modal + BE + V3 ("must be locked").',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Baju kotor ini harus dicuci dengan air dingin.',
                'target_word' => 'should be washed',
                'vocab' => [
                  'dirty clothes' => ['id' => 'baju kotor', 'pos' => '(n phr)'],
                  'cold water' => ['id' => 'air dingin', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'These dirty clothes should be washed with cold water.',
                  'These dirty clothes should washed with cold water.',
                  'These dirty clothes should be washing with cold water.',
                  'These dirty clothes should to be washed with cold water.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "should be washed".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Tugas ini bisa diselesaikan dalam waktu satu jam.',
                'target_word' => 'can be finished',
                'vocab' => [
                  'assignment' => ['id' => 'tugas', 'pos' => '(n)'],
                  'within an hour' => ['id' => 'dalam waktu satu jam', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This assignment can be finished within an hour.',
                  'This assignment can finished within an hour.',
                  'This assignment can be finishing within an hour.',
                  'This assignment can to be finished within an hour.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "can be finished".',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Tanaman ini harus disiram dua kali sehari.',
                'target_word' => 'must be watered',
                'vocab' => [
                  'plant' => ['id' => 'tanaman', 'pos' => '(n)'],
                  'twice a day' => ['id' => 'dua kali sehari', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This plant must be watered twice a day.',
                  'This plant must watered twice a day.',
                  'This plant must be watering twice a day.',
                  'This plant must to be watered twice a day.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "must be watered".',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Tiket konser itu bisa dibeli secara daring.',
                'target_word' => 'can be bought',
                'vocab' => [
                  'concert tickets' => ['id' => 'tiket konser', 'pos' => '(n phr)'],
                  'online' => ['id' => 'secara daring', 'pos' => '(adv)'],
                ],
                'options' => [
                  'Concert tickets can be bought online.',
                  'Concert tickets can bought online.',
                  'Concert tickets can be buying online.',
                  'Concert tickets can to be bought online.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "can be bought".',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Kesalahan ini seharusnya bisa dihindari jika kita lebih berhati-hati.',
                'target_word' => 'could be avoided',
                'vocab' => [
                  'mistake' => ['id' => 'kesalahan', 'pos' => '(n)'],
                  'avoided' => ['id' => 'dihindari', 'pos' => '(v, pasif)'],
                  'more careful' => ['id' => 'lebih berhati-hati', 'pos' => '(adj phr)'],
                ],
                'options' => [
                  'This mistake could be avoided if we were more careful.',
                  'This mistake could avoided if we were more careful.',
                  'This mistake could be avoiding if we were more careful.',
                  'This mistake could to be avoided if we were more careful.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "could be avoided".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Ruangan ini harus dibersihkan sebelum tamu datang.',
                'target_word' => 'must be cleaned',
                'vocab' => [
                  'room' => ['id' => 'ruangan', 'pos' => '(n)'],
                  'guests arrive' => ['id' => 'tamu datang', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'This room must be cleaned before the guests arrive.',
                  'This room must cleaned before the guests arrive.',
                  'This room must be cleaning before the guests arrive.',
                  'This room must to be cleaned before the guests arrive.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "must be cleaned".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Surat ini harus dikirim paling lambat hari Jumat.',
                'target_word' => 'must be sent',
                'vocab' => [
                  'letter' => ['id' => 'surat', 'pos' => '(n)'],
                  'by Friday' => ['id' => 'paling lambat hari Jumat', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This letter must be sent by Friday.',
                  'This letter must sent by Friday.',
                  'This letter must be sending by Friday.',
                  'This letter must to be sent by Friday.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "must be sent".',
              ],
            ],
          ],
          [
            'id' => 'past_deduction_modal_have',
            'name' => 'Dugaan & Penyesalan Masa Lalu (Modal + Have + V3)',
            'code' => '1.7.7',
            'concept_title' => 'Dugaan & Penyesalan Masa Lalu (Modal + Have + V3)',
            'concept_description' => 'Gunakan pola "modal + have + V3" untuk menduga sesuatu yang terjadi di masa lalu (may/might/must have) atau untuk menyesali sesuatu yang seharusnya dilakukan tapi tidak dilakukan (should have).',
            'formula' => 'Subject + MAY / MIGHT / MUST / SHOULD + HAVE + Verb 3 (Past Participle)',
            'rules' => [
              'Gunakan "may/might have + V3" untuk dugaan tentang masa lalu.',
              'Gunakan "must have + V3" untuk kesimpulan yang hampir pasti tentang masa lalu.',
              'Gunakan "should have + V3" untuk menyesali sesuatu yang seharusnya dilakukan tapi tidak dilakukan.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Dia mungkin lupa membawa kuncinya pagi ini.',
                'target_word' => 'may have forgotten',
                'vocab' => [
                  'may have forgotten' => ['id' => 'mungkin lupa', 'pos' => '(v phr)'],
                  'keys' => ['id' => 'kunci', 'pos' => '(n)'],
                ],
                'options' => [
                  'He may have forgotten his keys this morning.',
                  'He may has forgotten his keys this morning.',
                  'He may have forgot his keys this morning.',
                  'He may having forgotten his keys this morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "may have + V3" ("may have forgotten") menyatakan dugaan tentang masa lalu.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Kamu seharusnya memberitahuku lebih awal bahwa kamu akan datang.',
                'target_word' => 'should have told',
                'vocab' => [
                  'should have told' => ['id' => 'seharusnya memberitahu', 'pos' => '(v phr)'],
                  'earlier' => ['id' => 'lebih awal', 'pos' => '(adv)'],
                ],
                'options' => [
                  'You should have told me earlier that you were coming.',
                  'You should has told me earlier that you were coming.',
                  'You should have tell me earlier that you were coming.',
                  'You should having told me earlier that you were coming.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" menyatakan penyesalan tentang sesuatu yang tidak dilakukan.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Jalanan basah, jadi pasti sudah hujan semalam.',
                'target_word' => 'must have rained',
                'vocab' => [
                  'wet' => ['id' => 'basah', 'pos' => '(adj)'],
                  'must have rained' => ['id' => 'pasti sudah hujan', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The street is wet, so it must have rained last night.',
                  'The street is wet, so it must has rained last night.',
                  'The street is wet, so it must have rain last night.',
                  'The street is wet, so it must having rained last night.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "must have + V3" menyatakan kesimpulan hampir pasti tentang masa lalu.',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Saya seharusnya belajar lebih giat untuk ujian kemarin.',
                'target_word' => 'should have studied',
                'vocab' => [
                  'should have studied' => ['id' => 'seharusnya belajar', 'pos' => '(v phr)'],
                  'harder' => ['id' => 'lebih giat', 'pos' => '(adv)'],
                ],
                'options' => [
                  'I should have studied harder for yesterday\'s exam.',
                  'I should has studied harder for yesterday\'s exam.',
                  'I should have study harder for yesterday\'s exam.',
                  'I should having studied harder for yesterday\'s exam.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" ("should have studied") menyatakan penyesalan.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Dia tidak menjawab teleponnya, jadi dia mungkin sedang tidur.',
                'target_word' => 'might have been',
                'vocab' => [
                  "didn't answer" => ['id' => 'tidak menjawab', 'pos' => '(v phr)'],
                  'might have been sleeping' => ['id' => 'mungkin sedang tidur', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'He didn\'t answer his phone, so he might have been sleeping.',
                  'He didn\'t answer his phone, so he might has been sleeping.',
                  'He didn\'t answer his phone, so he might have being sleeping.',
                  'He didn\'t answer his phone, so he might having been sleeping.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "might have been + V-ing" menyatakan dugaan tentang kegiatan di masa lalu.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Kami seharusnya memesan tiket lebih awal sebelum harganya naik.',
                'target_word' => 'should have booked',
                'vocab' => [
                  'should have booked' => ['id' => 'seharusnya memesan', 'pos' => '(v phr)'],
                  'price went up' => ['id' => 'harganya naik', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'We should have booked the tickets earlier before the price went up.',
                  'We should has booked the tickets earlier before the price went up.',
                  'We should have book the tickets earlier before the price went up.',
                  'We should having booked the tickets earlier before the price went up.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" menyatakan penyesalan tentang keputusan masa lalu.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Pintunya terbuka, jadi seseorang pasti sudah masuk ke dalam rumah.',
                'target_word' => 'must have entered',
                'vocab' => [
                  'open' => ['id' => 'terbuka', 'pos' => '(adj)'],
                  'must have entered' => ['id' => 'pasti sudah masuk', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The door is open, so someone must have entered the house.',
                  'The door is open, so someone must has entered the house.',
                  'The door is open, so someone must have enter the house.',
                  'The door is open, so someone must having entered the house.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "must have + V3" menyatakan kesimpulan hampir pasti.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Dia mungkin salah mendengar apa yang saya katakan tadi.',
                'target_word' => 'might have misheard',
                'vocab' => [
                  'might have misheard' => ['id' => 'mungkin salah mendengar', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'He might have misheard what I said earlier.',
                  'He might has misheard what I said earlier.',
                  'He might have mishear what I said earlier.',
                  'He might having misheard what I said earlier.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "might have + V3" menyatakan dugaan tentang masa lalu.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Kamu seharusnya tidak makan begitu banyak sebelum tidur.',
                'target_word' => 'should not have eaten',
                'vocab' => [
                  'should not have eaten' => ['id' => 'seharusnya tidak makan', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'You should not have eaten so much before bed.',
                  'You should not has eaten so much before bed.',
                  'You should not have eat so much before bed.',
                  'You should not having eaten so much before bed.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola negatif "should not have + V3" menyatakan penyesalan atas tindakan yang dilakukan.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Kamarnya berantakan, jadi dia pasti terburu-buru tadi pagi.',
                'target_word' => 'must have been',
                'vocab' => [
                  'messy' => ['id' => 'berantakan', 'pos' => '(adj)'],
                  'must have been in a hurry' => ['id' => 'pasti terburu-buru', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'His room is messy, so he must have been in a hurry this morning.',
                  'His room is messy, so he must has been in a hurry this morning.',
                  'His room is messy, so he must have be in a hurry this morning.',
                  'His room is messy, so he must having been in a hurry this morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "must have been" menyatakan kesimpulan hampir pasti tentang keadaan masa lalu.',
              ],
            ],
          ],
          [
            'id' => 'mixed_practice_modals',
            'name' => 'Latihan Campuran: Semua Modal Auxiliaries',
            'code' => '1.7.8',
            'concept_title' => 'Latihan Campuran: Semua Modal Auxiliaries',
            'concept_description' => 'Latihan ini menggabungkan semua fungsi modal yang telah kamu pelajari: kemungkinan, kemampuan, saran, kepastian, masa depan, bentuk pasif, dan dugaan masa lalu — semua dalam konteks kehidupan sehari-hari.',
            'formula' => 'Subject + MODAL + V1 (atau BE + V3 / HAVE + V3 sesuai konteks)',
            'rules' => [
              'Kenali dulu makna yang ingin disampaikan (kemungkinan, saran, kepastian, dsb.) sebelum memilih modal yang tepat.',
              'Modal selalu diikuti bentuk dasar kata kerja, baik dalam bentuk aktif, pasif, maupun dugaan masa lalu.',
              'Perhatikan konteks kalimat untuk menentukan modal mana yang paling cocok.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Kamu sebaiknya memakai helm setiap kali naik sepeda motor.',
                'target_word' => 'should wear',
                'vocab' => [
                  'wear a helmet' => ['id' => 'memakai helm', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'You should wear a helmet every time you ride a motorbike.',
                  'You should wears a helmet every time you ride a motorbike.',
                  'You should to wear a helmet every time you ride a motorbike.',
                  'You should wearing a helmet every time you ride a motorbike.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bentuk dasar kata kerja ("should wear").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Dia mungkin terlambat karena lalu lintas yang padat.',
                'target_word' => 'may be',
                'vocab' => [
                  'late' => ['id' => 'terlambat', 'pos' => '(adj)'],
                  'heavy traffic' => ['id' => 'lalu lintas padat', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'He may be late because of the heavy traffic.',
                  'He may is late because of the heavy traffic.',
                  'He may to be late because of the heavy traffic.',
                  'He may being late because of the heavy traffic.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "may" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Jendela-jendela ini harus ditutup sebelum hujan turun.',
                'target_word' => 'must be closed',
                'vocab' => [
                  'windows' => ['id' => 'jendela-jendela', 'pos' => '(n)'],
                  'closed' => ['id' => 'ditutup', 'pos' => '(v, pasif)'],
                ],
                'options' => [
                  'These windows must be closed before it rains.',
                  'These windows must closed before it rains.',
                  'These windows must be closing before it rains.',
                  'These windows must to be closed before it rains.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk pasif modal: "must be closed".',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Dia bisa bermain gitar dengan sangat baik sejak kecil.',
                'target_word' => 'can play',
                'vocab' => [
                  'play the guitar' => ['id' => 'bermain gitar', 'pos' => '(v phr)'],
                  'since childhood' => ['id' => 'sejak kecil', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'He can play the guitar very well since childhood.',
                  'He can plays the guitar very well since childhood.',
                  'He can to play the guitar very well since childhood.',
                  'He can playing the guitar very well since childhood.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "play".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Saya seharusnya menelepon ibu saya kemarin, tapi saya lupa.',
                'target_word' => 'should have called',
                'vocab' => [
                  'should have called' => ['id' => 'seharusnya menelepon', 'pos' => '(v phr)'],
                  'forgot' => ['id' => 'lupa', 'pos' => '(v)'],
                ],
                'options' => [
                  'I should have called my mother yesterday, but I forgot.',
                  'I should has called my mother yesterday, but I forgot.',
                  'I should have call my mother yesterday, but I forgot.',
                  'I should having called my mother yesterday, but I forgot.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" menyatakan penyesalan atas sesuatu yang tidak dilakukan.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Pekerjaan rumah ini harus dikumpulkan besok pagi.',
                'target_word' => 'must be submitted',
                'vocab' => [
                  'homework' => ['id' => 'pekerjaan rumah', 'pos' => '(n)'],
                  'submitted' => ['id' => 'dikumpulkan', 'pos' => '(v, pasif)'],
                ],
                'options' => [
                  'This homework must be submitted tomorrow morning.',
                  'This homework must submitted tomorrow morning.',
                  'This homework must be submitting tomorrow morning.',
                  'This homework must to be submitted tomorrow morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk pasif modal: "must be submitted".',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Kita akan merayakan kelulusan kita minggu depan.',
                'target_word' => 'will celebrate',
                'vocab' => [
                  'graduation' => ['id' => 'kelulusan', 'pos' => '(n)'],
                  'next week' => ['id' => 'minggu depan', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'We will celebrate our graduation next week.',
                  'We will celebrates our graduation next week.',
                  'We will to celebrate our graduation next week.',
                  'We will celebrating our graduation next week.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bare verb "celebrate".',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Lampunya mati, jadi listriknya pasti padam.',
                'target_word' => 'must be out',
                'vocab' => [
                  'lights are off' => ['id' => 'lampunya mati', 'pos' => '(adj phr)'],
                  'power' => ['id' => 'listrik', 'pos' => '(n)'],
                  'out' => ['id' => 'padam', 'pos' => '(adj)'],
                ],
                'options' => [
                  'The lights are off, so the power must be out.',
                  'The lights are off, so the power must is out.',
                  'The lights are off, so the power must to be out.',
                  'The lights are off, so the power must being out.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Apakah kamu bisa menjaga tas saya sebentar?',
                'target_word' => 'can you watch',
                'vocab' => [
                  'watch' => ['id' => 'menjaga', 'pos' => '(v)'],
                  'for a moment' => ['id' => 'sebentar', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Can you watch my bag for a moment?',
                  'Can you watches my bag for a moment?',
                  'Can you to watch my bag for a moment?',
                  'Can you watching my bag for a moment?',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "watch" dalam bentuk pertanyaan.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Dia mungkin sudah pergi sebelum kita tiba di sana.',
                'target_word' => 'might have left',
                'vocab' => [
                  'might have left' => ['id' => 'mungkin sudah pergi', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'He might have left before we arrived there.',
                  'He might has left before we arrived there.',
                  'He might have leave before we arrived there.',
                  'He might having left before we arrived there.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "might have + V3" menyatakan dugaan tentang masa lalu.',
              ],
            ],
          ],
        ];
    }
}
