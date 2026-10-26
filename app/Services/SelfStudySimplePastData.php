<?php

namespace App\Services;

class SelfStudySimplePastData
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
            'banner_title' => 'Simple Past Tense: Talking About Yesterday',
            'banner_subtitle' => 'Kuasai cara menceritakan kejadian yang sudah selesai di masa lalu: kata kerja beraturan & tidak beraturan (aktif), kalimat nominal dengan was/were, kalimat pasif (was/were + V3), kalimat negatif (did not + V1), dan cara meletakkan keterangan waktu.',
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
            'concept_title' => 'Panduan Lengkap Simple Past Tense: Verbal, Nominal, & Pasif',
            'concept_summary' => 'Simple Past Tense digunakan untuk menceritakan kejadian, kegiatan, atau keadaan yang sudah selesai sepenuhnya di masa lalu (Completed Past Events) — misalnya apa yang kamu lakukan kemarin atau tahun lalu. Ada tiga bentuk dasar yang perlu dikuasai: Bentuk Verbal Aktif (S + V2), Bentuk Nominal (S + was/were + Complement), dan Bentuk Pasif (S + was/were + V3).',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Beraturan vs Tidak Beraturan (Subject + V2)',
                    'rule_formula' => 'Subject + Verb 2 + Object / Complement',
                    'rule_description' => 'Gunakan V2 beraturan (-ed) atau tidak beraturan untuk tindakan aktif masa lalu. Subjek tunggal dan jamak menggunakan bentuk V2 yang sama. Jangan menambahkan was/were di depan V2 aktif (SALAH: "She was visited her friend" ➔ BENAR: "She visited her friend").',
                    'examples' => [
                        [
                            'en' => 'We visited our grandmother in the village last weekend.',
                            'id' => 'Kami mengunjungi nenek kami di desa akhir pekan lalu.',
                            'note' => '"visited" adalah bentuk V2 aktif beraturan.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Bentuk Nominal Lampau: was vs were (Subject + was/were + Complement)',
                    'rule_formula' => 'Singular Subject + WAS + Adj/Noun | Plural Subject + WERE + Adj/Noun',
                    'rule_description' => 'Gunakan "was" untuk subjek tunggal (I, he, she, it, the movie) dan "were" untuk subjek jamak (we, they, the kids). Diikuti kata sifat, kata benda, atau frasa preposisi tanpa kata kerja aksi.',
                    'examples' => [
                        [
                            'en' => 'The weather was very cold this morning.',
                            'id' => 'Cuaca sangat dingin pagi ini.',
                            'note' => 'Subjek tunggal "the weather" dipadukan dengan "was cold".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif (Subject + was/were + V3)',
                    'rule_formula' => 'Subject + WAS / WERE + Verb 3 (Past Participle)',
                    'rule_description' => 'Gunakan pasif lampau saat kita ingin fokus pada benda/orang yang menerima tindakan, bukan pelakunya (contoh: "the cake was baked", "the toys were collected"). Verba setelah was/were WAJIB berbentuk V3 (Past Participle).',
                    'examples' => [
                        [
                            'en' => 'The old house was painted bright blue last month.',
                            'id' => 'Rumah tua itu dicat biru cerah bulan lalu.',
                            'note' => '"was painted" (was + V3) menjelaskan tindakan yang dikenakan pada rumah.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Bentuk Negatif (did not + V1 / was/were not)',
                    'rule_formula' => 'Verbal: S + DID NOT + V1 (Base Form) | Nominal/Pasif: S + WAS/WERE NOT + Adj/V3',
                    'rule_description' => 'Pada kalimat verbal negatif, verba selalu kembali ke bentuk dasar V1 murni setelah "did not" (did not watch, did not eat). Jangan pernah menggunakan V2 setelah did not.',
                    'examples' => [
                        [
                            'en' => 'I did not watch the movie last night because I was too tired.',
                            'id' => 'Saya tidak menonton filmnya semalam karena terlalu lelah.',
                            'note' => '"did not watch" menggunakan V1 "watch" setelah "did not".'
                        ]
                    ]
                ]
            ],
            'contrast_table' => [
                'headers' => ['Kategori Kalimat', 'Pola Rumus Baku', 'Kapan Digunakan', 'Contoh Kalimat'],
                'rows' => [
                    ['Verbal Aktif (Beraturan)', 'Subject + V2 (-ed)', 'Aksi aktif subjek yang selesai di masa lalu', 'They cleaned the house on Sunday.'],
                    ['Verbal Aktif (Tidak Beraturan)', 'Subject + Irregular V2', 'Aksi aktif kata kerja tak beraturan', 'She found her lost keys under the sofa.'],
                    ['Nominal Lampau (Tunggal)', 'Singular Subject + was + Adj/Noun', 'Kondisi/sifat subjek tunggal masa lalu', 'The soup was too salty.'],
                    ['Nominal Lampau (Jamak)', 'Plural Subject + were + Adj/Noun', 'Kondisi/sifat subjek jamak masa lalu', 'The streets were quiet last night.'],
                    ['Pasif (Tunggal)', 'Singular Subject + was + V3', 'Benda tunggal yang dikenai tindakan', 'The window was broken by the storm.'],
                    ['Pasif (Jamak)', 'Plural Subject + were + V3', 'Benda jamak yang dikenai tindakan', 'The dishes were washed after dinner.'],
                    ['Verbal Negatif', 'Subject + did not + V1', 'Penyangkalan kejadian/aksi lampau', 'He did not finish his homework.'],
                    ['Nominal/Pasif Negatif', 'Subject + was/were not + Adj/V3', 'Kondisi negatif atau tindakan tidak terjadi', 'The shop was not open on Sunday.']
                ]
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'She was visited her grandmother yesterday.',
                    'correct' => 'She visited her grandmother yesterday.',
                    'explanation' => 'Jangan menyisipkan "was/were" di depan kata kerja aktif transitif. "She visited" adalah bentuk aktif yang benar.'
                ],
                [
                    'incorrect' => 'A strange thing was happened at school today.',
                    'correct' => 'A strange thing happened at school today.',
                    'explanation' => 'Kata kerja intransitif seperti "happen", "arrive", "sleep" tidak bisa dipasifkan.'
                ],
                [
                    'incorrect' => 'He did not went to school yesterday.',
                    'correct' => 'He did not go to school yesterday.',
                    'explanation' => 'Setelah "did not", kata kerja WAJIB kembali ke bentuk dasar V1 ("go", bukan "went").'
                ],
                [
                    'incorrect' => 'Last year, she has moved to a new city.',
                    'correct' => 'Last year, she moved to a new city.',
                    'explanation' => 'Keterangan waktu lampau spesifik ("Last year") mewajibkan Simple Past V2, bukan Present Perfect.'
                ]
            ],
            'exam_tips' => [
                'Gunakan Simple Past Pasif (was/were + V3) saat kamu ingin menekankan benda/orang yang menerima tindakan, bukan siapa pelakunya.',
                'Gunakan Simple Past Aktif (V2) saat menekankan siapa yang melakukan tindakan ("We visited...", "She cooked...").',
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
                'concept_description' => 'Simple Past Tense bentuk verbal aktif digunakan untuk menceritakan kegiatan atau kejadian yang sudah selesai di masa lampau (Past Completed Action). Pada kata kerja beraturan (Regular Verbs), bentuk lampau dibentuk dengan menambahkan akhiran \'-ed\' atau \'-d\' pada bentuk dasar kata kerja (V1).',
                'formula' => 'Subject + Verb 2 (-ed) + Object / Complement + (Past Time Marker)',
                'rules' => [
                    'Bentuk V2 beraturan dibentuk dengan menambahkan \'-ed\' pada kata kerja dasar (visit -> visited, cook -> cooked).',
                    'Jika kata kerja berakhir dengan huruf \'e\', cukup tambahkan \'-d\' (close -> closed, like -> liked).',
                    'Jika berakhiran konsonan + \'y\', ubah \'y\' menjadi \'i\' lalu tambahkan \'-ed\' (study -> studied, carry -> carried).',
                    'Subject-Verb Agreement pada Simple Past verbal tidak membedakan subjek tunggal dan jamak; semua subjek menggunakan bentuk V2 yang sama.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Ibu saya memasak makanan favorit kami untuk makan malam tadi malam.',
                        'target_word' => 'cooked',
                        'vocab' => [
                            'my mother' => [
                                'id' => 'ibu saya',
                                'pos' => '(n)',
                            ],
                            'cooked' => [
                                'id' => 'memasak',
                                'pos' => '(v2)',
                            ],
                            'our favorite food' => [
                                'id' => 'makanan favorit kami',
                                'pos' => '(n phr)',
                            ],
                            'for dinner last night' => [
                                'id' => 'untuk makan malam tadi malam',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'My mother cooked our favorite food for dinner last night.',
                            'My mother cook our favorite food for dinner last night.',
                            'My mother cooks our favorite food for dinner last night.',
                            'My mother cooking our favorite food for dinner last night.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Tindakan lampau yang telah selesai dilaporkan dengan bentuk V2 beraturan \'cooked\'. Pilihan \'cook\' (V1) atau \'cooks\' salah tenses.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Kami membersihkan seluruh rumah sebelum tamu kami tiba.',
                        'target_word' => 'cleaned',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'cleaned' => [
                                'id' => 'membersihkan',
                                'pos' => '(v2)',
                            ],
                            'the whole house' => [
                                'id' => 'seluruh rumah',
                                'pos' => '(n phr)',
                            ],
                            'before our guests arrived' => [
                                'id' => 'sebelum tamu kami tiba',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'We cleaned the whole house before our guests arrived.',
                            'We clean the whole house before our guests arrived.',
                            'We cleans the whole house before our guests arrived.',
                            'We was cleaned the whole house before our guests arrived.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk aktif lampau menggunakan V2 \'cleaned\'. Bentuk \'was cleaned\' salah karena itu adalah pasif, sedangkan subjeknya adalah pelaku aktif (\'kami\').',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Guru itu menjelaskan pelajaran baru dengan sangat sabar.',
                        'target_word' => 'explained',
                        'vocab' => [
                            'the teacher' => [
                                'id' => 'guru itu',
                                'pos' => '(n)',
                            ],
                            'explained' => [
                                'id' => 'menjelaskan',
                                'pos' => '(v2)',
                            ],
                            'the new lesson' => [
                                'id' => 'pelajaran baru',
                                'pos' => '(n phr)',
                            ],
                            'very patiently' => [
                                'id' => 'dengan sangat sabar',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The teacher explained the new lesson very patiently.',
                            'The teacher explain the new lesson very patiently.',
                            'The teacher explains the new lesson very patiently.',
                            'The teacher is explained the new lesson very patiently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'explained\' adalah bentuk V2 lampau aktif dari kata kerja \'explain\'.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Kepala desa mengumumkan jadwal kerja bakti pada bulan lalu.',
                        'target_word' => 'announced',
                        'vocab' => [
                            'the village head' => [
                                'id' => 'kepala desa',
                                'pos' => '(n phr)',
                            ],
                            'announced' => [
                                'id' => 'mengumumkan',
                                'pos' => '(v2)',
                            ],
                            'the community clean-up schedule' => [
                                'id' => 'jadwal kerja bakti',
                                'pos' => '(n phr)',
                            ],
                            'last month' => [
                                'id' => 'bulan lalu',
                                'pos' => '(time adv)',
                            ],
                        ],
                        'options' => [
                            'The village head announced the community clean-up schedule last month.',
                            'The village head announces the community clean-up schedule last month.',
                            'The village head announce the community clean-up schedule last month.',
                            'The village head was announce the community clean-up schedule last month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu lampau \'last month\' mewajibkan penggunaan V2 \'announced\'.',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Adik saya menggambar sebuah rumah dan pohon besar di buku gambarnya.',
                        'target_word' => 'drew',
                        'vocab' => [
                            'my younger sibling' => [
                                'id' => 'adik saya',
                                'pos' => '(n)',
                            ],
                            'drew' => [
                                'id' => 'menggambar',
                                'pos' => '(v2)',
                            ],
                            'a house and a big tree' => [
                                'id' => 'sebuah rumah dan pohon besar',
                                'pos' => '(n phr)',
                            ],
                            'in his drawing book' => [
                                'id' => 'di buku gambarnya',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'My younger sibling drew a house and a big tree in his drawing book.',
                            'My younger sibling draw a house and a big tree in his drawing book.',
                            'My younger sibling draws a house and a big tree in his drawing book.',
                            'My younger sibling were drew a house and a big tree in his drawing book.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'drew\' adalah bentuk V2 untuk subjek aktif \'my younger sibling\'. (Catatan: meski \'draw\' aslinya tidak beraturan, polanya sama: aktif V2 + objek.)',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Para siswa menyelesaikan pekerjaan rumah mereka dalam waktu kurang dari tiga puluh menit.',
                        'target_word' => 'finished',
                        'vocab' => [
                            'the students' => [
                                'id' => 'para siswa',
                                'pos' => '(n pl)',
                            ],
                            'finished' => [
                                'id' => 'menyelesaikan',
                                'pos' => '(v2)',
                            ],
                            'their homework' => [
                                'id' => 'pekerjaan rumah mereka',
                                'pos' => '(n phr)',
                            ],
                            'in less than thirty minutes' => [
                                'id' => 'dalam waktu kurang dari tiga puluh menit',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The students finished their homework in less than thirty minutes.',
                            'The students finish their homework in less than thirty minutes.',
                            'The students finishes their homework in less than thirty minutes.',
                            'The students was finished their homework in less than thirty minutes.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'finished\' (V2) menyatakan tindakan lampau yang telah tuntas.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Ayah memperbaiki sepeda saya yang rusak akhir pekan lalu.',
                        'target_word' => 'fixed',
                        'vocab' => [
                            'dad' => [
                                'id' => 'ayah',
                                'pos' => '(n)',
                            ],
                            'fixed' => [
                                'id' => 'memperbaiki',
                                'pos' => '(v2)',
                            ],
                            'my broken bicycle' => [
                                'id' => 'sepeda saya yang rusak',
                                'pos' => '(n phr)',
                            ],
                            'last weekend' => [
                                'id' => 'akhir pekan lalu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'Dad fixed my broken bicycle last weekend.',
                            'Dad fixes my broken bicycle last weekend.',
                            'Dad fix my broken bicycle last weekend.',
                            'Dad was fixed my broken bicycle last weekend.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Tindakan aktif lampau menggunakan V2 \'fixed\'. \'Dad\' adalah pelaku aktif, jadi tidak perlu \'was\'.',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Panitia lomba mengumumkan pemenang di depan seluruh peserta.',
                        'target_word' => 'announced',
                        'vocab' => [
                            'the competition committee' => [
                                'id' => 'panitia lomba',
                                'pos' => '(n phr)',
                            ],
                            'announced' => [
                                'id' => 'mengumumkan',
                                'pos' => '(v2)',
                            ],
                            'the winner' => [
                                'id' => 'pemenang',
                                'pos' => '(n phr)',
                            ],
                            'in front of all the participants' => [
                                'id' => 'di depan seluruh peserta',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The competition committee announced the winner in front of all the participants.',
                            'The competition committee announce the winner in front of all the participants.',
                            'The competition committee announces the winner in front of all the participants.',
                            'The competition committee were announced the winner in front of all the participants.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'announced\' adalah bentuk lampau V2 beraturan.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Toko itu menutup pintunya lebih awal karena hujan deras.',
                        'target_word' => 'closed',
                        'vocab' => [
                            'the shop' => [
                                'id' => 'toko itu',
                                'pos' => '(n)',
                            ],
                            'closed' => [
                                'id' => 'menutup',
                                'pos' => '(v2)',
                            ],
                            'its doors early' => [
                                'id' => 'pintunya lebih awal',
                                'pos' => '(n phr)',
                            ],
                            'because of the heavy rain' => [
                                'id' => 'karena hujan deras',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The shop closed its doors early because of the heavy rain.',
                            'The shop close its doors early because of the heavy rain.',
                            'The shop closes its doors early because of the heavy rain.',
                            'The shop was closed its doors early because of the heavy rain.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'closed\' (V2 dari \'close\') menyatakan tindakan penutupan yang dilakukan toko di masa lampau.',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Kakak saya belajar bahasa Inggris selama dua jam sebelum ujian.',
                        'target_word' => 'studied',
                        'vocab' => [
                            'my older sibling' => [
                                'id' => 'kakak saya',
                                'pos' => '(n phr)',
                            ],
                            'studied' => [
                                'id' => 'belajar',
                                'pos' => '(v2)',
                            ],
                            'English' => [
                                'id' => 'bahasa Inggris',
                                'pos' => '(n)',
                            ],
                            'for two hours before the exam' => [
                                'id' => 'selama dua jam sebelum ujian',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'My older sibling studied English for two hours before the exam.',
                            'My older sibling studies English for two hours before the exam.',
                            'My older sibling study English for two hours before the exam.',
                            'My older sibling was studied English for two hours before the exam.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Studied\' mengikuti aturan konsonan+y ➔ i + ed. Ini adalah bentuk V2 lampau aktif yang benar.',
                    ],
                ],
            ],
            [
                'id' => 'past_verbal_irregular',
                'name' => 'Simple Past Verbal: Irregular Verbs (Subject + Irregular V2)',
                'code' => '1.8.2',
                'concept_title' => 'Simple Past Verbal: Irregular Verbs (Subject + Irregular V2)',
                'concept_description' => 'Kata kerja tak beraturan (Irregular Verbs) tidak menggunakan akhiran \'-ed\' untuk membentuk masa lampau (V2), melainkan mengalami perubahan ejaan internal (misal: find -> found, grow -> grew, take -> took, go -> went, rise -> rose). Kata-kata ini sangat sering dipakai sehari-hari, jadi penting untuk dihafal.',
                'formula' => 'Subject + Irregular V2 + Object / Prepositional Phrase + (Time Marker)',
                'rules' => [
                    'Bentuk V2 tak beraturan harus dihafalkan karena memiliki perubahan unik (find -> found, go -> went, buy -> bought).',
                    'Dilarang menambahkan \'-ed\' pada kata kerja tidak beraturan (misal: \'finded\' ➔ SALAH; \'found\' ➔ BENAR; \'goed\' ➔ SALAH; \'went\' ➔ BENAR).',
                    'Subjek tunggal maupun jamak menggunakan bentuk V2 yang sama persis.',
                    'Dalam kalimat negatif, verba kembali ke bentuk dasar V1 setelah kata kerja bantu \'did not\'.',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Saya menemukan dompet saya yang hilang di bawah tempat tidur.',
                        'target_word' => 'found',
                        'vocab' => [
                            'I' => [
                                'id' => 'saya',
                                'pos' => '(pron)',
                            ],
                            'found' => [
                                'id' => 'menemukan',
                                'pos' => '(v2 irregular)',
                            ],
                            'my lost wallet' => [
                                'id' => 'dompet saya yang hilang',
                                'pos' => '(n phr)',
                            ],
                            'under the bed' => [
                                'id' => 'di bawah tempat tidur',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'I found my lost wallet under the bed.',
                            'I finded my lost wallet under the bed.',
                            'I find my lost wallet under the bed.',
                            'I was found my lost wallet under the bed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'find\' adalah \'found\', bukan \'finded\'.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Pohon mangga di halaman belakang tumbuh dengan sangat cepat tahun ini.',
                        'target_word' => 'grew',
                        'vocab' => [
                            'the mango tree' => [
                                'id' => 'pohon mangga',
                                'pos' => '(n phr)',
                            ],
                            'in the backyard' => [
                                'id' => 'di halaman belakang',
                                'pos' => '(prep phr)',
                            ],
                            'grew very fast' => [
                                'id' => 'tumbuh dengan sangat cepat',
                                'pos' => '(v phr)',
                            ],
                            'this year' => [
                                'id' => 'tahun ini',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The mango tree in the backyard grew very fast this year.',
                            'The mango tree in the backyard growed very fast this year.',
                            'The mango tree in the backyard grow very fast this year.',
                            'The mango tree in the backyard was grew very fast this year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'grow\' adalah \'grew\', bukan \'growed\'.',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Perjalanan ke rumah nenek memakan waktu empat jam dengan mobil.',
                        'target_word' => 'took',
                        'vocab' => [
                            'the trip to grandmother\'s house' => [
                                'id' => 'perjalanan ke rumah nenek',
                                'pos' => '(n phr)',
                            ],
                            'took four hours' => [
                                'id' => 'memakan waktu empat jam',
                                'pos' => '(v phr)',
                            ],
                            'by car' => [
                                'id' => 'dengan mobil',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The trip to grandmother\'s house took four hours by car.',
                            'The trip to grandmother\'s house taked four hours by car.',
                            'The trip to grandmother\'s house take four hours by car.',
                            'The trip to grandmother\'s house was took four hours by car.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'take\' adalah \'took\'.',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Kami pergi ke pantai bersama seluruh keluarga pada hari Minggu.',
                        'target_word' => 'went',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'went' => [
                                'id' => 'pergi',
                                'pos' => '(v2 irregular)',
                            ],
                            'to the beach' => [
                                'id' => 'ke pantai',
                                'pos' => '(prep phr)',
                            ],
                            'with the whole family' => [
                                'id' => 'bersama seluruh keluarga',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'We went to the beach with the whole family on Sunday.',
                            'We goed to the beach with the whole family on Sunday.',
                            'We go to the beach with the whole family on Sunday.',
                            'We was went to the beach with the whole family on Sunday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'go\' adalah \'went\'.',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Matahari terbit sangat terlambat karena langit mendung pagi itu.',
                        'target_word' => 'rose',
                        'vocab' => [
                            'the sun' => [
                                'id' => 'matahari',
                                'pos' => '(n sg)',
                            ],
                            'rose very late' => [
                                'id' => 'terbit sangat terlambat',
                                'pos' => '(v phr)',
                            ],
                            'because the sky was cloudy' => [
                                'id' => 'karena langit mendung',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'The sun rose very late because the sky was cloudy that morning.',
                            'The sun rised very late because the sky was cloudy that morning.',
                            'The sun rise very late because the sky was cloudy that morning.',
                            'The sun was rose very late because the sky was cloudy that morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'rise\' (naik/terbit) adalah \'rose\', bukan \'rised\'.',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Cuaca menjadi sangat dingin setelah matahari terbenam.',
                        'target_word' => 'became',
                        'vocab' => [
                            'the weather' => [
                                'id' => 'cuaca',
                                'pos' => '(n sg)',
                            ],
                            'became very cold' => [
                                'id' => 'menjadi sangat dingin',
                                'pos' => '(v phr)',
                            ],
                            'after the sun set' => [
                                'id' => 'setelah matahari terbenam',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'The weather became very cold after the sun set.',
                            'The weather becomed very cold after the sun set.',
                            'The weather become very cold after the sun set.',
                            'The weather was became very cold after the sun set.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'become\' adalah \'became\'.',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Guru menunjukkan contoh soal yang mirip dengan ujian minggu depan.',
                        'target_word' => 'showed',
                        'vocab' => [
                            'the teacher' => [
                                'id' => 'guru',
                                'pos' => '(n)',
                            ],
                            'showed' => [
                                'id' => 'menunjukkan',
                                'pos' => '(v2)',
                            ],
                            'an example question' => [
                                'id' => 'contoh soal',
                                'pos' => '(n phr)',
                            ],
                            'similar to next week\'s exam' => [
                                'id' => 'yang mirip dengan ujian minggu depan',
                                'pos' => '(adj phr)',
                            ],
                        ],
                        'options' => [
                            'The teacher showed an example question similar to next week\'s exam.',
                            'The teacher was showed an example question similar to next week\'s exam.',
                            'The teacher shown an example question similar to next week\'s exam.',
                            'The teacher shows an example question similar to next week\'s exam.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'showed\' adalah V2 aktif. Hindari kesalahan lazim \'was showed\'.',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Pertandingan sepak bola dimulai tepat pada pukul delapan malam.',
                        'target_word' => 'began',
                        'vocab' => [
                            'the football match' => [
                                'id' => 'pertandingan sepak bola',
                                'pos' => '(n phr)',
                            ],
                            'began' => [
                                'id' => 'dimulai',
                                'pos' => '(v2 irregular)',
                            ],
                            'exactly at eight in the evening' => [
                                'id' => 'tepat pada pukul delapan malam',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The football match began exactly at eight in the evening.',
                            'The football match begined exactly at eight in the evening.',
                            'The football match begun exactly at eight in the evening.',
                            'The football match was began exactly at eight in the evening.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'begin\' adalah \'began\'. (\'begun\' adalah V3).',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Hujan deras menyebabkan banjir kecil di beberapa jalan.',
                        'target_word' => 'led to',
                        'vocab' => [
                            'the heavy rain' => [
                                'id' => 'hujan deras',
                                'pos' => '(n phr)',
                            ],
                            'led to' => [
                                'id' => 'menyebabkan / berujung pada',
                                'pos' => '(v phr)',
                            ],
                            'small floods on some streets' => [
                                'id' => 'banjir kecil di beberapa jalan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The heavy rain led to small floods on some streets.',
                            'The heavy rain leaded to small floods on some streets.',
                            'The heavy rain lead to small floods on some streets.',
                            'The heavy rain was led to small floods on some streets.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'lead to\' adalah \'led to\'.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Panitia memilih tiga siswa terbaik untuk mewakili sekolah.',
                        'target_word' => 'chose',
                        'vocab' => [
                            'the committee' => [
                                'id' => 'panitia',
                                'pos' => '(n)',
                            ],
                            'chose' => [
                                'id' => 'memilih',
                                'pos' => '(v2 irregular)',
                            ],
                            'the three best students' => [
                                'id' => 'tiga siswa terbaik',
                                'pos' => '(n phr)',
                            ],
                            'to represent the school' => [
                                'id' => 'untuk mewakili sekolah',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'The committee chose the three best students to represent the school.',
                            'The committee choosed the three best students to represent the school.',
                            'The committee choose the three best students to represent the school.',
                            'The committee was chose the three best students to represent the school.',
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
                    'Gunakan \'was\' untuk subjek tunggal: I, He, She, It, the soup, the movie, the weather.',
                    'Gunakan \'were\' untuk subjek jamak: We, They, the streets, the kids, our neighbors.',
                    'Komplemen dapat berupa: Kata Sifat (was happy), Kata Benda (was a teacher), atau Frasa Preposisi (were at home).',
                    'Dilarang meletakkan kata kerja V1 setelah was/were dalam kalimat nominal (misal: \'The test was succeed\' ➔ SALAH; \'The test was successful\' ➔ BENAR).',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Saya sangat bahagia ketika mendengar kabar itu.',
                        'target_word' => 'was very happy',
                        'vocab' => [
                            'I' => [
                                'id' => 'saya',
                                'pos' => '(pron)',
                            ],
                            'was very happy' => [
                                'id' => 'sangat bahagia',
                                'pos' => '(phr)',
                            ],
                            'when I heard the news' => [
                                'id' => 'ketika mendengar kabar itu',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'I was very happy when I heard the news.',
                            'I were very happy when I heard the news.',
                            'I am very happy when I heard the news.',
                            'I was very happiness when I heard the news.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'I\' menggunakan \'was\' + kata sifat \'happy\'.',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sup ayam buatan ibu sangat lezat malam ini.',
                        'target_word' => 'was delicious',
                        'vocab' => [
                            'mom\'s chicken soup' => [
                                'id' => 'sup ayam buatan ibu',
                                'pos' => '(n sg)',
                            ],
                            'was delicious' => [
                                'id' => 'sangat lezat',
                                'pos' => '(phr)',
                            ],
                            'tonight' => [
                                'id' => 'malam ini',
                                'pos' => '(time adv)',
                            ],
                        ],
                        'options' => [
                            'Mom\'s chicken soup was delicious tonight.',
                            'Mom\'s chicken soup were delicious tonight.',
                            'Mom\'s chicken soup was deliciousness tonight.',
                            'Mom\'s chicken soup did delicious tonight.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'soup\' menggunakan \'was\' + adjective \'delicious\'.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Jalan-jalan di kota sangat sepi pada pagi hari libur itu.',
                        'target_word' => 'were very quiet',
                        'vocab' => [
                            'the streets in the city' => [
                                'id' => 'jalan-jalan di kota',
                                'pos' => '(n pl)',
                            ],
                            'were very quiet' => [
                                'id' => 'sangat sepi',
                                'pos' => '(phr)',
                            ],
                            'on that holiday morning' => [
                                'id' => 'pada pagi hari libur itu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The streets in the city were very quiet on that holiday morning.',
                            'The streets in the city was very quiet on that holiday morning.',
                            'The streets in the city are very quiet on that holiday morning.',
                            'The streets in the city were very quietly on that holiday morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek adalah jamak (\'The streets\'), sehingga kata kerja bantu lampau yang wajib digunakan adalah \'were\'. Diikuti kata sifat \'quiet\'.',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Ayah saya adalah seorang guru olahraga di sekolah dasar dulu.',
                        'target_word' => 'was a sports teacher',
                        'vocab' => [
                            'my father' => [
                                'id' => 'ayah saya',
                                'pos' => '(n)',
                            ],
                            'was a sports teacher' => [
                                'id' => 'adalah seorang guru olahraga',
                                'pos' => '(phr)',
                            ],
                            'at an elementary school' => [
                                'id' => 'di sekolah dasar',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'My father was a sports teacher at an elementary school.',
                            'My father were a sports teacher at an elementary school.',
                            'My father is a sports teacher at an elementary school before.',
                            'My father was teaching sports at an elementary school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'my father\' menggunakan \'was\' + frasa nomina komplemen \'a sports teacher\'.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Semua tamu berada di ruang tamu ketika listrik tiba-tiba padam.',
                        'target_word' => 'were in the living room',
                        'vocab' => [
                            'all the guests' => [
                                'id' => 'semua tamu',
                                'pos' => '(n pl)',
                            ],
                            'were in the living room' => [
                                'id' => 'berada di ruang tamu',
                                'pos' => '(phr)',
                            ],
                            'when the power suddenly went out' => [
                                'id' => 'ketika listrik tiba-tiba padam',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'All the guests were in the living room when the power suddenly went out.',
                            'All the guests was in the living room when the power suddenly went out.',
                            'All the guests did in the living room when the power suddenly went out.',
                            'All the guests were living room when the power suddenly went out.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'guests\' menggunakan \'were\' + frasa preposisi \'in the living room\'.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Film yang kami tonton semalam sangat menyedihkan.',
                        'target_word' => 'was very sad',
                        'vocab' => [
                            'the movie we watched last night' => [
                                'id' => 'film yang kami tonton semalam',
                                'pos' => '(n sg)',
                            ],
                            'was very sad' => [
                                'id' => 'sangat menyedihkan',
                                'pos' => '(phr)',
                            ],
                        ],
                        'options' => [
                            'The movie we watched last night was very sad.',
                            'The movie we watched last night were very sad.',
                            'The movie we watched last night is very sad.',
                            'The movie we watched last night was very sadly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The movie\' tunggal, sehingga memerlukan kata kerja bantu \'was\' + adjective \'sad\'.',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Harga buah-buahan sangat mahal di pasar minggu ini.',
                        'target_word' => 'were very expensive',
                        'vocab' => [
                            'the prices of fruit' => [
                                'id' => 'harga buah-buahan',
                                'pos' => '(n pl)',
                            ],
                            'at the market' => [
                                'id' => 'di pasar',
                                'pos' => '(prep phr)',
                            ],
                            'were very expensive' => [
                                'id' => 'sangat mahal',
                                'pos' => '(phr)',
                            ],
                            'this week' => [
                                'id' => 'minggu ini',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The prices of fruit at the market were very expensive this week.',
                            'The prices of fruit at the market was very expensive this week.',
                            'The prices of fruit at the market did very expensive this week.',
                            'The prices of fruit at the market were very expense this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'prices\' menggunakan \'were\' + adjective \'expensive\'.',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Semua buku perpustakaan tersusun rapi di raknya sebelum liburan dimulai.',
                        'target_word' => 'were neatly arranged',
                        'vocab' => [
                            'all the library books' => [
                                'id' => 'semua buku perpustakaan',
                                'pos' => '(n pl)',
                            ],
                            'were neatly arranged' => [
                                'id' => 'tersusun rapi',
                                'pos' => '(phr)',
                            ],
                            'on the shelves' => [
                                'id' => 'di raknya',
                                'pos' => '(prep phr)',
                            ],
                            'before the holidays began' => [
                                'id' => 'sebelum liburan dimulai',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'All the library books were neatly arranged on the shelves before the holidays began.',
                            'All the library books was neatly arranged on the shelves before the holidays began.',
                            'All the library books did neatly arranged on the shelves before the holidays began.',
                            'All the library books were neat arranged on the shelves before the holidays began.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'books\' menggunakan \'were\' + kata sifat \'arranged\'.',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Air di dalam botol itu jernih dan tidak berbau sebelum dipanaskan.',
                        'target_word' => 'was clear and odorless',
                        'vocab' => [
                            'the water in the bottle' => [
                                'id' => 'air di dalam botol',
                                'pos' => '(n sg)',
                            ],
                            'was clear and odorless' => [
                                'id' => 'jernih dan tidak berbau',
                                'pos' => '(phr)',
                            ],
                            'before it was heated' => [
                                'id' => 'sebelum dipanaskan',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'The water in the bottle was clear and odorless before it was heated.',
                            'The water in the bottle were clear and odorless before it was heated.',
                            'The water in the bottle did clear and odorless before it was heated.',
                            'The water in the bottle was clearly and odorless before it was heated.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The water\' (tunggal) menggunakan \'was\' + pasangan kata sifat.',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Harga tiket konser sangat mahal tahun lalu.',
                        'target_word' => 'was very expensive',
                        'vocab' => [
                            'the price of the concert ticket' => [
                                'id' => 'harga tiket konser',
                                'pos' => '(n sg)',
                            ],
                            'was very expensive' => [
                                'id' => 'sangat mahal',
                                'pos' => '(phr)',
                            ],
                            'last year' => [
                                'id' => 'tahun lalu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The price of the concert ticket was very expensive last year.',
                            'The price of the concert ticket were very expensive last year.',
                            'The price of the concert ticket did very expensive last year.',
                            'The price of the concert ticket was very expensively last year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The price\' tunggal, menggunakan \'was\' + adjective \'expensive\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_passive',
                'name' => 'Simple Past Passive: Everyday Events (was / were + V3)',
                'code' => '1.8.4',
                'concept_title' => 'Simple Past Passive: Everyday Events (was / were + V3)',
                'concept_description' => 'Kalimat pasif lampau (Simple Past Passive) digunakan ketika kita ingin memfokuskan kalimat pada benda atau orang yang menerima tindakan, bukan pada siapa yang melakukannya. Sering dipakai dalam kehidupan sehari-hari, misalnya untuk bercerita tentang hal-hal yang "terjadi pada" sesuatu.',
                'formula' => 'Subject (Penerima Tindakan) + WAS / WERE + Verb 3 (Past Participle) + (by Pelaku) + (Konteks)',
                'rules' => [
                    'Gunakan \'was + V3\' jika subjek penerima tindakan adalah tunggal (the cake was baked, the window was broken).',
                    'Gunakan \'were + V3\' jika subjek penerima tindakan adalah jamak (the toys were collected, the guests were invited).',
                    'Verba setelah was/were WAJIB berbentuk Past Participle (V3), bukan V1 atau V2 murni.',
                    'Frasa pelaku (\'by my mother\') boleh ditambahkan atau dihilangkan, tergantung apakah pelakunya penting untuk disebutkan.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Kue ulang tahun itu dipanggang oleh ibu saya sendiri.',
                        'target_word' => 'was baked',
                        'vocab' => [
                            'the birthday cake' => [
                                'id' => 'kue ulang tahun itu',
                                'pos' => '(n sg)',
                            ],
                            'was baked' => [
                                'id' => 'dipanggang',
                                'pos' => '(v passive)',
                            ],
                            'by my own mother' => [
                                'id' => 'oleh ibu saya sendiri',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The birthday cake was baked by my own mother.',
                            'The birthday cake were baked by my own mother.',
                            'The birthday cake baked by my own mother.',
                            'The birthday cake was bake by my own mother.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'cake\' dipadukan dengan pasif lampau: \'was baked\' (was + V3).',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Jendela kamar itu dibuka setiap pagi untuk udara segar.',
                        'target_word' => 'was opened',
                        'vocab' => [
                            'the bedroom window' => [
                                'id' => 'jendela kamar',
                                'pos' => '(n sg)',
                            ],
                            'was opened' => [
                                'id' => 'dibuka',
                                'pos' => '(v passive)',
                            ],
                            'every morning for fresh air' => [
                                'id' => 'setiap pagi untuk udara segar',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The bedroom window was opened every morning for fresh air.',
                            'The bedroom window were opened every morning for fresh air.',
                            'The bedroom window opened every morning for fresh air.',
                            'The bedroom window was open every morning for fresh air.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The window\' menggunakan \'was opened\' (was + V3).',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Para tamu diundang ke pesta pernikahan melalui kartu undangan.',
                        'target_word' => 'were invited',
                        'vocab' => [
                            'the guests' => [
                                'id' => 'para tamu',
                                'pos' => '(n pl)',
                            ],
                            'were invited' => [
                                'id' => 'diundang',
                                'pos' => '(v passive)',
                            ],
                            'to the wedding party' => [
                                'id' => 'ke pesta pernikahan',
                                'pos' => '(prep phr)',
                            ],
                            'through invitation cards' => [
                                'id' => 'melalui kartu undangan',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The guests were invited to the wedding party through invitation cards.',
                            'The guests was invited to the wedding party through invitation cards.',
                            'The guests invited to the wedding party through invitation cards.',
                            'The guests were invite to the wedding party through invitation cards.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'were invited\' adalah kalimat pasif lampau untuk subjek jamak \'the guests\'.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Mainan-mainan anak-anak dikumpulkan dan disimpan ke dalam kotak.',
                        'target_word' => 'were collected',
                        'vocab' => [
                            'the children\'s toys' => [
                                'id' => 'mainan-mainan anak-anak',
                                'pos' => '(n pl)',
                            ],
                            'were collected' => [
                                'id' => 'dikumpulkan',
                                'pos' => '(v passive)',
                            ],
                            'and put into the box' => [
                                'id' => 'dan disimpan ke dalam kotak',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'The children\'s toys were collected and put into the box.',
                            'The children\'s toys was collected and put into the box.',
                            'The children\'s toys collected and put into the box.',
                            'The children\'s toys were collect and put into the box.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola pasif lampau: \'were collected\' (were + V3).',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Buku itu dipinjamkan kepada saya oleh teman sekelas minggu lalu.',
                        'target_word' => 'was lent',
                        'vocab' => [
                            'the book' => [
                                'id' => 'buku itu',
                                'pos' => '(n sg)',
                            ],
                            'was lent to me' => [
                                'id' => 'dipinjamkan kepada saya',
                                'pos' => '(v passive phr)',
                            ],
                            'by a classmate' => [
                                'id' => 'oleh teman sekelas',
                                'pos' => '(prep phr)',
                            ],
                            'last week' => [
                                'id' => 'minggu lalu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The book was lent to me by a classmate last week.',
                            'The book were lent to me by a classmate last week.',
                            'The book lent to me by a classmate last week.',
                            'The book was lend to me by a classmate last week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The book\' tunggal, menggunakan \'was lent\'.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Masalah di komputer itu ditemukan oleh teknisi sekolah.',
                        'target_word' => 'was found',
                        'vocab' => [
                            'the problem with the computer' => [
                                'id' => 'masalah di komputer itu',
                                'pos' => '(n sg)',
                            ],
                            'was found' => [
                                'id' => 'ditemukan',
                                'pos' => '(v passive)',
                            ],
                            'by the school technician' => [
                                'id' => 'oleh teknisi sekolah',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The problem with the computer was found by the school technician.',
                            'The problem with the computer were found by the school technician.',
                            'The problem with the computer found by the school technician.',
                            'The problem with the computer was find by the school technician.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'was found\' (was + V3) secara tepat memaparkan hasil penemuan masalah tersebut.',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Semua surat ditulis tangan oleh nenek saya dengan rapi.',
                        'target_word' => 'were handwritten',
                        'vocab' => [
                            'all the letters' => [
                                'id' => 'semua surat',
                                'pos' => '(n pl)',
                            ],
                            'were handwritten' => [
                                'id' => 'ditulis tangan',
                                'pos' => '(v passive phr)',
                            ],
                            'by my grandmother' => [
                                'id' => 'oleh nenek saya',
                                'pos' => '(prep phr)',
                            ],
                            'neatly' => [
                                'id' => 'dengan rapi',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'All the letters were handwritten neatly by my grandmother.',
                            'All the letters was handwritten neatly by my grandmother.',
                            'All the letters were handwrite neatly by my grandmother.',
                            'All the letters handwritten neatly by my grandmother.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'letters\' menggunakan \'were handwritten\' (were + V3).',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Aturan baru diterapkan di seluruh sekolah pada tahun 2023.',
                        'target_word' => 'was implemented',
                        'vocab' => [
                            'the new rule' => [
                                'id' => 'aturan baru',
                                'pos' => '(n sg)',
                            ],
                            'was implemented' => [
                                'id' => 'diterapkan',
                                'pos' => '(v passive)',
                            ],
                            'across the whole school' => [
                                'id' => 'di seluruh sekolah',
                                'pos' => '(prep phr)',
                            ],
                            'in 2023' => [
                                'id' => 'pada tahun 2023',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The new rule was implemented across the whole school in 2023.',
                            'The new rule were implemented across the whole school in 2023.',
                            'The new rule implemented across the whole school in 2023.',
                            'The new rule was implement across the whole school in 2023.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'rule\' menggunakan \'was implemented\'.',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Hasil ujian diumumkan setiap pukul tiga sore selama minggu itu.',
                        'target_word' => 'were announced',
                        'vocab' => [
                            'the exam results' => [
                                'id' => 'hasil ujian',
                                'pos' => '(n pl)',
                            ],
                            'were announced' => [
                                'id' => 'diumumkan',
                                'pos' => '(v passive)',
                            ],
                            'every three o\'clock in the afternoon' => [
                                'id' => 'setiap pukul tiga sore',
                                'pos' => '(time phr)',
                            ],
                            'during that week' => [
                                'id' => 'selama minggu itu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The exam results were announced every three o\'clock in the afternoon during that week.',
                            'The exam results was announced every three o\'clock in the afternoon during that week.',
                            'The exam results announced every three o\'clock in the afternoon during that week.',
                            'The exam results were announce every three o\'clock in the afternoon during that week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'results\' memerlukan pasif \'were announced\'.',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Rencana liburan keluarga disetujui oleh ayah pada akhir pekan lalu.',
                        'target_word' => 'was approved',
                        'vocab' => [
                            'the family vacation plan' => [
                                'id' => 'rencana liburan keluarga',
                                'pos' => '(n sg)',
                            ],
                            'was approved' => [
                                'id' => 'disetujui',
                                'pos' => '(v passive)',
                            ],
                            'by dad' => [
                                'id' => 'oleh ayah',
                                'pos' => '(prep phr)',
                            ],
                            'last weekend' => [
                                'id' => 'pada akhir pekan lalu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The family vacation plan was approved by dad last weekend.',
                            'The family vacation plan were approved by dad last weekend.',
                            'The family vacation plan approved by dad last weekend.',
                            'The family vacation plan was approve by dad last weekend.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'plan\' adalah singular noun: \'was approved\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_trifecta_comparison',
                'name' => 'Trifecta Comparison: Verbal vs Nominal vs Pasif Masa Lampau',
                'code' => '1.8.5',
                'concept_title' => 'Trifecta Comparison: Verbal vs Nominal vs Pasif Masa Lampau',
                'concept_description' => 'Sub-lesson ini dirancang khusus untuk membedakan dan menghindari kesalahan paling umum: kerancuan antara bentuk aktif lampau (V2), nominal lampau (was/were + Adj), dan pasif lampau (was/were + V3). Kesalahan seperti \'The cake was tasted\' (padahal maksudnya aktif) atau \'The accident was happened\' (padahal intransitif) perlu diperbaiki.',
                'formula' => 'Aktif: S + V2 + O | Nominal: S + WAS/WERE + Adj/Noun | Pasif: S + WAS/WERE + V3',
                'rules' => [
                    'JANGAN gunakan \'was/were\' di depan kata kerja aktif transitif (SALAH: \'The dog was barked\' ➔ BENAR: \'The dog barked\').',
                    'Gunakan \'was/were + V3\' HANYA jika subjek adalah penerima tindakan (BENAR: \'The toy was broken\').',
                    'Kata kerja intransitif seperti \'happen\', \'arrive\', \'sleep\' TIDAK BISA dipasifkan (SALAH: \'The accident was happened\' ➔ BENAR: \'The accident happened\').',
                    'Gunakan \'was/were + Adjective\' untuk kondisi subjek tanpa aksi (BENAR: \'The result was great\').',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Anjing itu menggonggong dengan keras sepanjang malam.',
                        'target_word' => 'barked (Aktif V2)',
                        'vocab' => [
                            'the dog' => [
                                'id' => 'anjing itu',
                                'pos' => '(n)',
                            ],
                            'barked loudly' => [
                                'id' => 'menggonggong dengan keras',
                                'pos' => '(v2 aktif phr)',
                            ],
                            'all night' => [
                                'id' => 'sepanjang malam',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The dog barked loudly all night.',
                            'The dog was barked loudly all night.',
                            'The dog were barked loudly all night.',
                            'The dog was barking loudly all night. (as a label)',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Karena anjing melakukan tindakan \'menggonggong\' sendiri (intransitif), gunakan bentuk verbal aktif \'barked\'. Bentuk \'was barked\' adalah kesalahan pasif.',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Kecelakaan kecil itu terjadi di depan sekolah pagi ini.',
                        'target_word' => 'happened (Intransitif V2)',
                        'vocab' => [
                            'the small accident' => [
                                'id' => 'kecelakaan kecil itu',
                                'pos' => '(n phr)',
                            ],
                            'happened' => [
                                'id' => 'terjadi',
                                'pos' => '(v2 intransitif)',
                            ],
                            'in front of the school' => [
                                'id' => 'di depan sekolah',
                                'pos' => '(prep phr)',
                            ],
                            'this morning' => [
                                'id' => 'pagi ini',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The small accident happened in front of the school this morning.',
                            'The small accident was happened in front of the school this morning.',
                            'The small accident was happening in front of the school this morning.',
                            'The small accident did happened in front of the school this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'happen\' adalah intransitif (tidak punya objek), sehingga TIDAK BISA dipasifkan menjadi \'was happened\'. Gunakan bentuk aktif \'happened\'.',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Sepeda itu ditaruh di garasi selama musim hujan.',
                        'target_word' => 'was kept (Pasif V3)',
                        'vocab' => [
                            'the bicycle' => [
                                'id' => 'sepeda itu',
                                'pos' => '(n sg)',
                            ],
                            'was kept' => [
                                'id' => 'ditaruh / disimpan',
                                'pos' => '(v pasif)',
                            ],
                            'in the garage' => [
                                'id' => 'di garasi',
                                'pos' => '(prep phr)',
                            ],
                            'during the rainy season' => [
                                'id' => 'selama musim hujan',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The bicycle was kept in the garage during the rainy season.',
                            'The bicycle kept in the garage during the rainy season.',
                            'The bicycle was keep in the garage during the rainy season.',
                            'The bicycle did kept in the garage during the rainy season.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Karena sepeda dikenai tindakan (\'ditaruh\'), gunakan pasif lampau \'was kept\' (was + V3).',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Hasil ulangan matematika sangat memuaskan bagi seluruh kelas.',
                        'target_word' => 'were very satisfying (Nominal)',
                        'vocab' => [
                            'the math test results' => [
                                'id' => 'hasil ulangan matematika',
                                'pos' => '(n pl)',
                            ],
                            'were very satisfying' => [
                                'id' => 'sangat memuaskan',
                                'pos' => '(adj phr)',
                            ],
                            'for the whole class' => [
                                'id' => 'bagi seluruh kelas',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The math test results were very satisfying for the whole class.',
                            'The math test results satisfied for the whole class.',
                            'The math test results was very satisfying for the whole class.',
                            'The math test results were very satisfyingly for the whole class.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'satisfying\' berfungsi sebagai kata sifat (adjective), sehingga memerlukan kata kerja bantu \'were\' (nominal).',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Kelas kami terdiri dari dua puluh lima siswa tahun lalu.',
                        'target_word' => 'consisted of (Intransitif V2)',
                        'vocab' => [
                            'our class' => [
                                'id' => 'kelas kami',
                                'pos' => '(n sg)',
                            ],
                            'consisted of' => [
                                'id' => 'terdiri dari',
                                'pos' => '(v phr aktif)',
                            ],
                            'twenty-five students' => [
                                'id' => 'dua puluh lima siswa',
                                'pos' => '(n phr)',
                            ],
                            'last year' => [
                                'id' => 'tahun lalu',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'Our class consisted of twenty-five students last year.',
                            'Our class was consisted of twenty-five students last year.',
                            'Our class was consist of twenty-five students last year.',
                            'Our class did consist of twenty-five students last year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'consist of\' tidak pernah dipasifkan. \'was consisted of\' atau \'was consist of\' adalah kesalahan umum yang harus dihindari.',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Kue kering itu dibuat oleh dua orang sepupu saya bersama-sama.',
                        'target_word' => 'were made (Pasif V3)',
                        'vocab' => [
                            'the cookies' => [
                                'id' => 'kue kering itu',
                                'pos' => '(n pl)',
                            ],
                            'were made' => [
                                'id' => 'dibuat',
                                'pos' => '(v pasif)',
                            ],
                            'by my two cousins' => [
                                'id' => 'oleh dua orang sepupu saya',
                                'pos' => '(n phr)',
                            ],
                            'together' => [
                                'id' => 'bersama-sama',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'The cookies were made by my two cousins together.',
                            'The cookies made by my two cousins together.',
                            'The cookies was made by my two cousins together.',
                            'The cookies were make by my two cousins together.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'cookies\' menerima tindakan pasif dari sepupu: \'were made by\'.',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Uang jajan saya tidak cukup untuk membeli buku baru itu.',
                        'target_word' => 'was not enough (Nominal)',
                        'vocab' => [
                            'my pocket money' => [
                                'id' => 'uang jajan saya',
                                'pos' => '(n sg)',
                            ],
                            'was not enough' => [
                                'id' => 'tidak cukup',
                                'pos' => '(adj phr)',
                            ],
                            'to buy the new book' => [
                                'id' => 'untuk membeli buku baru itu',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'My pocket money was not enough to buy the new book.',
                            'My pocket money enoughed to buy the new book.',
                            'My pocket money were not enough to buy the new book.',
                            'My pocket money was not enoughly to buy the new book.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'was not enough\' adalah kalimat nominal lampau menggunakan kata sifat \'enough\'.',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Ibu dan saya menyelesaikan menata ulang kamar sebelum tamu datang.',
                        'target_word' => 'finished (Aktif V2)',
                        'vocab' => [
                            'mom and I' => [
                                'id' => 'ibu dan saya',
                                'pos' => '(n phr)',
                            ],
                            'finished' => [
                                'id' => 'menyelesaikan',
                                'pos' => '(v2 aktif)',
                            ],
                            'rearranging the room' => [
                                'id' => 'menata ulang kamar',
                                'pos' => '(n phr)',
                            ],
                            'before the guests arrived' => [
                                'id' => 'sebelum tamu datang',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Mom and I finished rearranging the room before the guests arrived.',
                            'Mom and I were finished rearranging the room before the guests arrived.',
                            'Mom and I was finished rearranging the room before the guests arrived.',
                            'Mom and I did finished rearranging the room before the guests arrived.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'Mom and I\' adalah pelaku aktif: \'finished rearranging\', bukan \'were finished\'.',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Dugaan awal kami ternyata salah setelah kami mengecek ulang.',
                        'target_word' => 'turned out to be wrong (Aktif V2)',
                        'vocab' => [
                            'our first guess' => [
                                'id' => 'dugaan awal kami',
                                'pos' => '(n phr)',
                            ],
                            'turned out to be wrong' => [
                                'id' => 'ternyata salah',
                                'pos' => '(v phr)',
                            ],
                            'after we checked again' => [
                                'id' => 'setelah kami mengecek ulang',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Our first guess turned out to be wrong after we checked again.',
                            'Our first guess was turned out to be wrong after we checked again.',
                            'Our first guess was turn out to be wrong after we checked again.',
                            'Our first guess did turned out to be wrong after we checked again.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'turned out to be wrong\' berfungsi sebagai verba aktif yang menyatakan hasil.',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Jumlah uang di celengan dihitung oleh kakak saya.',
                        'target_word' => 'was counted (Pasif V3)',
                        'vocab' => [
                            'the amount of money in the piggy bank' => [
                                'id' => 'jumlah uang di celengan',
                                'pos' => '(n sg)',
                            ],
                            'was counted by' => [
                                'id' => 'dihitung oleh',
                                'pos' => '(v pasif phr)',
                            ],
                            'my older sibling' => [
                                'id' => 'kakak saya',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The amount of money in the piggy bank was counted by my older sibling.',
                            'The amount of money in the piggy bank counted by my older sibling.',
                            'The amount of money in the piggy bank were counted by my older sibling.',
                            'The amount of money in the piggy bank was count by my older sibling.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The amount\' (tunggal) menerima tindakan dihitung: \'was counted by\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_negative_questions',
                'name' => 'Simple Past Negative & Interrogative (did not + V1, was/were not)',
                'code' => '1.8.6',
                'concept_title' => 'Simple Past Negative & Interrogative (did not + V1, was/were not)',
                'concept_description' => 'Kalimat negatif dan tanya lampau digunakan untuk menyangkal sesuatu yang tidak terjadi atau menanyakan sesuatu tentang masa lalu. Pada kalimat verbal, bentuk negatif menggunakan kata kerja bantu \'did not\' diikuti kata kerja dasar (V1 murni). Pada kalimat nominal dan pasif, tambahkan \'not\' setelah was/were.',
                'formula' => 'Verbal Negatif: Subject + DID NOT + V1 (Base Form) | Nominal/Pasif Negatif: Subject + WAS/WERE NOT + Complement/V3',
                'rules' => [
                    'Setelah \'did not\', kata kerja WAJIB kembali ke bentuk dasar V1 (dilarang menggunakan V2 setelah did not: \'did not went\' ➔ SALAH; \'did not go\' ➔ BENAR).',
                    'Bentuk singkat \'didn\'t\'/\'wasn\'t\' sering dipakai dalam percakapan sehari-hari, sedangkan \'did not\'/\'was not\' lebih formal.',
                    'Pada kalimat tanya: \'Did + Subject + V1 ...?\' atau \'Was/Were + Subject + Complement/V3 ...?\'.',
                    'Jawaban singkat untuk pertanyaan ini: \'Yes, I did.\' / \'No, I did not.\' atau \'Yes, it was.\' / \'No, it was not.\'',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Saya tidak melihat pesan itu sampai pagi ini.',
                        'target_word' => 'did not see',
                        'vocab' => [
                            'I' => [
                                'id' => 'saya',
                                'pos' => '(pron)',
                            ],
                            'did not see' => [
                                'id' => 'tidak melihat',
                                'pos' => '(v neg)',
                            ],
                            'the message' => [
                                'id' => 'pesan itu',
                                'pos' => '(n phr)',
                            ],
                            'until this morning' => [
                                'id' => 'sampai pagi ini',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'I did not see the message until this morning.',
                            'I did not saw the message until this morning.',
                            'I not saw the message until this morning.',
                            'I was not see the message until this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk negatif verbal lampau: \'did not\' + V1 murni (\'see\'). Bentuk \'did not saw\' adalah kesalahan.',
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Gula itu tidak larut sepenuhnya di dalam air dingin.',
                        'target_word' => 'did not dissolve',
                        'vocab' => [
                            'the sugar' => [
                                'id' => 'gula itu',
                                'pos' => '(n sg)',
                            ],
                            'did not dissolve' => [
                                'id' => 'tidak larut',
                                'pos' => '(v neg)',
                            ],
                            'completely' => [
                                'id' => 'sepenuhnya',
                                'pos' => '(adv)',
                            ],
                            'in the cold water' => [
                                'id' => 'di dalam air dingin',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The sugar did not dissolve completely in the cold water.',
                            'The sugar did not dissolved completely in the cold water.',
                            'The sugar was not dissolve completely in the cold water.',
                            'The sugar not dissolved completely in the cold water.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'did not dissolve\' menggunakan V1 \'dissolve\' setelah auxiliary \'did not\'.',
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Perbedaan antara kedua kue itu tidak terlalu terasa.',
                        'target_word' => 'was not very noticeable',
                        'vocab' => [
                            'the difference between the two cakes' => [
                                'id' => 'perbedaan antara kedua kue itu',
                                'pos' => '(n sg)',
                            ],
                            'was not very noticeable' => [
                                'id' => 'tidak terlalu terasa',
                                'pos' => '(phr neg)',
                            ],
                        ],
                        'options' => [
                            'The difference between the two cakes was not very noticeable.',
                            'The difference between the two cakes did not very noticeable.',
                            'The difference between the two cakes were not very noticeable.',
                            'The difference between the two cakes was not noticeably.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'noticeable\' adalah kata sifat (adjective), sehingga kalimat negatifnya menggunakan \'was not noticeable\' (bukan \'did not\').',
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Kami tidak mendengar suara apa pun dari kamar sebelah tadi malam.',
                        'target_word' => 'did not hear',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'did not hear' => [
                                'id' => 'tidak mendengar',
                                'pos' => '(v neg)',
                            ],
                            'any sound' => [
                                'id' => 'suara apa pun',
                                'pos' => '(n phr)',
                            ],
                            'from the next room last night' => [
                                'id' => 'dari kamar sebelah tadi malam',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'We did not hear any sound from the next room last night.',
                            'We did not heard any sound from the next room last night.',
                            'We were not hear any sound from the next room last night.',
                            'We not heard any sound from the next room last night.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'did not hear\' mematuhi aturan \'did not + V1\'.',
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Surat itu tidak dikirim sebelum kantor pos tutup.',
                        'target_word' => 'was not sent',
                        'vocab' => [
                            'the letter' => [
                                'id' => 'surat itu',
                                'pos' => '(n sg)',
                            ],
                            'was not sent' => [
                                'id' => 'tidak dikirim',
                                'pos' => '(v pasif neg)',
                            ],
                            'before the post office closed' => [
                                'id' => 'sebelum kantor pos tutup',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'The letter was not sent before the post office closed.',
                            'The letter did not sent before the post office closed.',
                            'The letter was not send before the post office closed.',
                            'The letter not was sent before the post office closed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pasif negatif lampau: \'was not sent\' (was + not + V3).',
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Apakah hujan deras itu merusak tanaman di kebun?',
                        'target_word' => 'Did the heavy rain damage',
                        'vocab' => [
                            'the heavy rain' => [
                                'id' => 'hujan deras itu',
                                'pos' => '(n phr)',
                            ],
                            'damage' => [
                                'id' => 'merusak',
                                'pos' => '(v)',
                            ],
                            'the plants in the garden' => [
                                'id' => 'tanaman di kebun',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Did the heavy rain damage the plants in the garden?',
                            'Did the heavy rain damaged the plants in the garden?',
                            'Was the heavy rain damage the plants in the garden?',
                            'Does the heavy rain damaged the plants in the garden?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat tanya verbal lampau: \'Did + Subject + V1 (damage)?\'.',
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah pintu depan dikunci sebelum kalian tidur semalam?',
                        'target_word' => 'Was the front door locked',
                        'vocab' => [
                            'the front door' => [
                                'id' => 'pintu depan',
                                'pos' => '(n sg)',
                            ],
                            'locked' => [
                                'id' => 'dikunci',
                                'pos' => '(v3)',
                            ],
                            'before you went to sleep last night' => [
                                'id' => 'sebelum kalian tidur semalam',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Was the front door locked before you went to sleep last night?',
                            'Did the front door locked before you went to sleep last night?',
                            'Were the front door locked before you went to sleep last night?',
                            'Was the front door lock before you went to sleep last night?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat tanya pasif lampau: \'Was + Singular Subject + V3 (locked)?\'.',
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Tim kami tidak berhasil memenangkan pertandingan final itu.',
                        'target_word' => 'did not succeed in winning',
                        'vocab' => [
                            'our team' => [
                                'id' => 'tim kami',
                                'pos' => '(n phr)',
                            ],
                            'did not succeed in winning' => [
                                'id' => 'tidak berhasil memenangkan',
                                'pos' => '(v neg phr)',
                            ],
                            'the final match' => [
                                'id' => 'pertandingan final itu',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Our team did not succeed in winning the final match.',
                            'Our team did not succeeded in winning the final match.',
                            'Our team was not succeed in winning the final match.',
                            'Our team not succeeded in winning the final match.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'did not succeed\' (did not + V1).',
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Apakah murid-murid senang dengan kegiatan karyawisata yang diadakan?',
                        'target_word' => 'Were the students happy',
                        'vocab' => [
                            'the students' => [
                                'id' => 'murid-murid',
                                'pos' => '(n pl)',
                            ],
                            'happy with' => [
                                'id' => 'senang dengan',
                                'pos' => '(adj phr)',
                            ],
                            'the field trip that was held' => [
                                'id' => 'kegiatan karyawisata yang diadakan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'Were the students happy with the field trip that was held?',
                            'Did the students happy with the field trip that was held?',
                            'Was the students happy with the field trip that was held?',
                            'Did the students be happy with the field trip that was held?',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'happy\' adalah adjective (nominal), sehingga kalimat tanya menggunakan \'Were + Plural Subject + Adjective?\'.',
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Sinyal wifi di rumah tidak stabil sepanjang hari ini.',
                        'target_word' => 'was not stable',
                        'vocab' => [
                            'the wifi signal at home' => [
                                'id' => 'sinyal wifi di rumah',
                                'pos' => '(n sg)',
                            ],
                            'was not stable' => [
                                'id' => 'tidak stabil',
                                'pos' => '(adj neg)',
                            ],
                            'all day today' => [
                                'id' => 'sepanjang hari ini',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The wifi signal at home was not stable all day today.',
                            'The wifi signal at home did not stable all day today.',
                            'The wifi signal at home were not stable all day today.',
                            'The wifi signal at home was not stably all day today.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'stable\' adalah adjective, gunakan \'was not stable\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_time_adverbials',
                'name' => 'Past Time Adverbials & Contextual Positioning (last year, yesterday, in 2020)',
                'code' => '1.8.7',
                'concept_title' => 'Past Time Adverbials & Contextual Positioning (last year, yesterday, in 2020)',
                'concept_description' => 'Penempatan frasa keterangan waktu lampau (Past Time Adverbials) penting dalam menyusun cerita tentang kejadian masa lalu. Frasa keterangan waktu dapat diletakkan di awal kalimat (dengan tanda koma sebagai pembuka) atau di akhir kalimat sebagai penjelas kapan kejadiannya.',
                'formula' => 'Time Adverbial Phrase + , + Subject + V2 / was/were + Object | Subject + V2 + Object + Time Adverbial',
                'rules' => [
                    'Keterangan waktu lampau yang pasti (in 2022, last year, three days ago, yesterday) mewajibkan penggunaan Simple Past Tense (V2 / was / were).',
                    'Jika frasa keterangan waktu diletakkan di awal kalimat, biasanya dipisahkan dengan tanda koma (contoh: \'Last year, we moved to a new house.\').',
                    'Jangan menggabungkan Present Perfect (\'has/have + V3\') dengan keterangan waktu lampau pasti seperti \'in 2019\' atau \'yesterday\'.',
                    'Variasikan posisi keterangan waktu agar kalimat tidak terasa monoton.',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Tahun lalu, keluarga kami pindah ke rumah baru di pinggiran kota.',
                        'target_word' => 'Last year, our family moved',
                        'vocab' => [
                            'last year' => [
                                'id' => 'tahun lalu',
                                'pos' => '(time phr)',
                            ],
                            'our family' => [
                                'id' => 'keluarga kami',
                                'pos' => '(n phr)',
                            ],
                            'moved' => [
                                'id' => 'pindah',
                                'pos' => '(v2)',
                            ],
                            'to a new house in the suburbs' => [
                                'id' => 'ke rumah baru di pinggiran kota',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'Last year, our family moved to a new house in the suburbs.',
                            'Last year, our family has moved to a new house in the suburbs.',
                            'Last year our family moves to a new house in the suburbs.',
                            'Last year, our family was moved to a new house in the suburbs.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu pasti \'Last year,\' mewajibkan V2 lampau aktif \'moved\' (bukan present perfect \'has moved\'). Tanda koma wajib diletakkan setelah frasa pembuka waktu.',
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Selama perjalanan pulang, hujan turun sangat deras.',
                        'target_word' => 'During the trip home, it rained',
                        'vocab' => [
                            'during the trip home' => [
                                'id' => 'selama perjalanan pulang',
                                'pos' => '(time phr)',
                            ],
                            'it rained very heavily' => [
                                'id' => 'hujan turun sangat deras',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'During the trip home, it rained very heavily.',
                            'During the trip home, it rains very heavily.',
                            'During the trip home, it was rained very heavily.',
                            'During the trip home it has rained very heavily.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'During the trip home,\' adalah keterangan waktu lampau yang diikuti V2 \'rained\'.',
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Sebelum pindah ke kota ini, kami tinggal di sebuah desa kecil.',
                        'target_word' => 'Before moving to this city, we lived',
                        'vocab' => [
                            'before moving to this city' => [
                                'id' => 'sebelum pindah ke kota ini',
                                'pos' => '(prep phr)',
                            ],
                            'we lived' => [
                                'id' => 'kami tinggal',
                                'pos' => '(v2)',
                            ],
                            'in a small village' => [
                                'id' => 'di sebuah desa kecil',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'Before moving to this city, we lived in a small village.',
                            'Before moving to this city, we have lived in a small village.',
                            'Before moving to this city, we lives in a small village.',
                            'Before moving to this city, we were live in a small village.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Before moving to this city...\' merujuk pada waktu lampau, membutuhkan V2 \'lived\'.',
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Nenek saya bercerita tentang masa kecilnya di desa.',
                        'target_word' => 'told',
                        'vocab' => [
                            'my grandmother' => [
                                'id' => 'nenek saya',
                                'pos' => '(n phr)',
                            ],
                            'told' => [
                                'id' => 'bercerita / memberi tahu',
                                'pos' => '(v2)',
                            ],
                            'stories about her childhood in the village' => [
                                'id' => 'cerita tentang masa kecilnya di desa',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'My grandmother told stories about her childhood in the village.',
                            'My grandmother has told stories about her childhood in the village.',
                            'My grandmother tells stories about her childhood in the village.',
                            'My grandmother was told stories about her childhood in the village.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Untuk merujuk ke kejadian lampau tertentu, gunakan V2 \'told\'.',
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Tiga tahun lalu, internet belum sebaik sekarang di desa kami.',
                        'target_word' => 'Three years ago, the internet was not',
                        'vocab' => [
                            'three years ago' => [
                                'id' => 'tiga tahun lalu',
                                'pos' => '(time phr)',
                            ],
                            'the internet' => [
                                'id' => 'internet',
                                'pos' => '(n sg)',
                            ],
                            'was not as good as now' => [
                                'id' => 'belum sebaik sekarang',
                                'pos' => '(adj phr)',
                            ],
                            'in our village' => [
                                'id' => 'di desa kami',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'Three years ago, the internet was not as good as now in our village.',
                            'Three years ago, the internet were not as good as now in our village.',
                            'Three years ago, the internet did not as good as now in our village.',
                            'Three years ago, the internet has not been as good as now in our village.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Three years ago\' adalah penanda waktu lampau pasti. Diikuti \'was not\'.',
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Sepanjang liburan musim panas lalu, kami bermain di luar hampir setiap hari.',
                        'target_word' => 'Throughout last summer vacation, we played',
                        'vocab' => [
                            'throughout last summer vacation' => [
                                'id' => 'sepanjang liburan musim panas lalu',
                                'pos' => '(time phr)',
                            ],
                            'we played outside' => [
                                'id' => 'kami bermain di luar',
                                'pos' => '(v phr)',
                            ],
                            'almost every day' => [
                                'id' => 'hampir setiap hari',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Throughout last summer vacation, we played outside almost every day.',
                            'Throughout last summer vacation, we have played outside almost every day.',
                            'Throughout last summer vacation, we plays outside almost every day.',
                            'Throughout last summer vacation, we was played outside almost every day.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Rentang waktu \'Throughout last summer vacation\' memerlukan V2 \'played\'.',
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Setelah badai besar itu berlalu, listrik padam di seluruh desa selama tiga hari.',
                        'target_word' => 'Following the big storm, the power failed',
                        'vocab' => [
                            'following the big storm' => [
                                'id' => 'setelah badai besar itu berlalu',
                                'pos' => '(prep phr)',
                            ],
                            'the power' => [
                                'id' => 'listrik',
                                'pos' => '(n phr)',
                            ],
                            'failed across the whole village' => [
                                'id' => 'padam di seluruh desa',
                                'pos' => '(v phr)',
                            ],
                            'for three days' => [
                                'id' => 'selama tiga hari',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'Following the big storm, the power failed across the whole village for three days.',
                            'Following the big storm, the power has failed across the whole village for three days.',
                            'Following the big storm, the power fails across the whole village for three days.',
                            'Following the big storm, the power was failed across the whole village for three days.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'failed\' (V2) menyatakan pemadaman listrik yang terjadi setelah badai.',
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Pada awal tahun ini, harga bensin naik secara perlahan.',
                        'target_word' => 'At the start of this year, fuel prices rose',
                        'vocab' => [
                            'at the start of this year' => [
                                'id' => 'pada awal tahun ini',
                                'pos' => '(time phr)',
                            ],
                            'fuel prices' => [
                                'id' => 'harga bensin',
                                'pos' => '(n phr)',
                            ],
                            'rose slowly' => [
                                'id' => 'naik secara perlahan',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'At the start of this year, fuel prices rose slowly.',
                            'At the start of this year, fuel prices have risen slowly.',
                            'At the start of this year, fuel prices rises slowly.',
                            'At the start of this year, fuel prices was rose slowly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu di awal kalimat diikuti V2 \'rose\'.',
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Dokter itu menyelesaikan pemeriksaan pasiennya dalam waktu satu jam kemarin.',
                        'target_word' => 'completed',
                        'vocab' => [
                            'the doctor' => [
                                'id' => 'dokter itu',
                                'pos' => '(n)',
                            ],
                            'completed' => [
                                'id' => 'menyelesaikan',
                                'pos' => '(v2)',
                            ],
                            'the patient\'s check-up' => [
                                'id' => 'pemeriksaan pasiennya',
                                'pos' => '(n phr)',
                            ],
                            'in one hour yesterday' => [
                                'id' => 'dalam waktu satu jam kemarin',
                                'pos' => '(time phr)',
                            ],
                        ],
                        'options' => [
                            'The doctor completed the patient\'s check-up in one hour yesterday.',
                            'The doctor has completed the patient\'s check-up in one hour yesterday.',
                            'The doctor completes the patient\'s check-up in one hour yesterday.',
                            'The doctor was completed the patient\'s check-up in one hour yesterday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'yesterday\' adalah penanda waktu lampau pasti yang tidak boleh digabungkan dengan Present Perfect.',
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Sebelum ada telepon genggam, orang-orang mengirim surat untuk berkomunikasi jarak jauh.',
                        'target_word' => 'sent',
                        'vocab' => [
                            'before mobile phones existed' => [
                                'id' => 'sebelum ada telepon genggam',
                                'pos' => '(time phr)',
                            ],
                            'people' => [
                                'id' => 'orang-orang',
                                'pos' => '(n pl)',
                            ],
                            'sent letters' => [
                                'id' => 'mengirim surat',
                                'pos' => '(v2 phr)',
                            ],
                            'to communicate over long distances' => [
                                'id' => 'untuk berkomunikasi jarak jauh',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'Before mobile phones existed, people sent letters to communicate over long distances.',
                            'Before mobile phones existed, people have sent letters to communicate over long distances.',
                            'Before mobile phones existed, people sends letters to communicate over long distances.',
                            'Before mobile phones existed, people was sent letters to communicate over long distances.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Era lampau sebelum telepon genggam ada menggunakan Simple Past V2 \'sent\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_weekend_story_synthesis',
                'name' => 'A Weekend Story: Combining Active, Passive & Nominal Past (Cerita Akhir Pekan)',
                'code' => '1.8.8',
                'concept_title' => 'A Weekend Story: Combining Active, Passive & Nominal Past (Cerita Akhir Pekan)',
                'concept_description' => 'Sub-lesson penutup ini menggabungkan seluruh keterampilan Simple Past Tense: perpaduan kalimat aktif (apa yang kita lakukan), kalimat pasif (apa yang terjadi pada sesuatu), serta kalimat nominal (bagaimana keadaan/suasana) dalam satu cerita sederhana tentang kegiatan sehari-hari atau akhir pekan.',
                'formula' => 'Combined Past Narrative: S + V2 (Active) + while + S + was/were + V3 (Passive) + where + S + was/were + Adj (Nominal)',
                'rules' => [
                    'Gunakan kalimat pasif lampau (\'the table was cleaned\', \'the photos were printed\') untuk mendeskripsikan hal yang terjadi pada suatu benda.',
                    'Gunakan kalimat aktif lampau (\'we cooked\', \'the kids played\') untuk menekankan siapa yang melakukan tindakan.',
                    'Gunakan kalimat nominal lampau (\'the park was crowded\', \'the food was tasty\') untuk menjelaskan suasana atau keadaan.',
                    'Jaga konsistensi tenses di sepanjang cerita tanpa melompat ke Present Tense secara acak.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Kami mengumpulkan kayu bakar dan segera menyalakan api unggun.',
                        'target_word' => 'collected ... lit',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'collected' => [
                                'id' => 'mengumpulkan',
                                'pos' => '(v2 regular)',
                            ],
                            'immediately lit' => [
                                'id' => 'segera menyalakan',
                                'pos' => '(v2 irregular)',
                            ],
                            'the campfire' => [
                                'id' => 'api unggun',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'We collected firewood and immediately lit the campfire.',
                            'We collected firewood and immediately light the campfire.',
                            'We was collected firewood and immediately lit the campfire.',
                            'We have collected firewood and immediately lit the campfire.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua kata kerja yang dihubungkan oleh \'and\' wajib paralel dalam bentuk Simple Past: \'collected ... lit\'.',
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Sebanyak dua puluh anak diundang dan dibagi secara acak ke dalam empat kelompok permainan.',
                        'target_word' => 'were invited and randomly divided',
                        'vocab' => [
                            'twenty children' => [
                                'id' => '20 anak',
                                'pos' => '(n pl)',
                            ],
                            'were invited and randomly divided' => [
                                'id' => 'diundang dan dibagi secara acak',
                                'pos' => '(v pasif phr)',
                            ],
                            'four game groups' => [
                                'id' => 'empat kelompok permainan',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'A total of twenty children were invited and randomly divided into four game groups.',
                            'A total of twenty children was invited and randomly divided into four game groups.',
                            'A total of twenty children invited and randomly divided into four game groups.',
                            'A total of twenty children were invited and randomly divide into four game groups.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua verba pasif terkoordinasi: \'were invited and randomly divided\'.',
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Meskipun cuaca sangat panas, anak-anak tetap bermain dengan gembira.',
                        'target_word' => 'was ... kept',
                        'vocab' => [
                            'the weather was very hot' => [
                                'id' => 'cuaca sangat panas',
                                'pos' => '(clause nominal)',
                            ],
                            'the children kept playing happily' => [
                                'id' => 'anak-anak tetap bermain dengan gembira',
                                'pos' => '(clause aktif)',
                            ],
                        ],
                        'options' => [
                            'Although the weather was very hot, the children kept playing happily.',
                            'Although the weather were very hot, the children kept playing happily.',
                            'Although the weather was very hot, the children keeps playing happily.',
                            'Although the weather did hot, the children kept playing happily.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'was very hot\' (nominal lampau) dipadukan dengan klausa utama \'kept playing\' (aktif V2).',
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Baju-baju itu dicuci dengan hati-hati dan dijemur di bawah sinar matahari.',
                        'target_word' => 'were washed ... were hung',
                        'vocab' => [
                            'the clothes were carefully washed' => [
                                'id' => 'baju-baju itu dicuci dengan hati-hati',
                                'pos' => '(clause pasif)',
                            ],
                            'were hung under the sun' => [
                                'id' => 'dijemur di bawah sinar matahari',
                                'pos' => '(clause pasif)',
                            ],
                        ],
                        'options' => [
                            'The clothes were carefully washed, and they were hung under the sun.',
                            'The clothes carefully washed, and they were hung under the sun.',
                            'The clothes were carefully washed, and they hung under the sun.',
                            'The clothes were carefully wash, and they were hang under the sun.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa adalah kalimat pasif lampau yang rapi: \'were washed\' dan \'were hung\'.',
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Kami menemukan jalan pintas baru sebelum macet semakin parah.',
                        'target_word' => 'found ... got',
                        'vocab' => [
                            'we found' => [
                                'id' => 'kami menemukan',
                                'pos' => '(clause aktif)',
                            ],
                            'a new shortcut' => [
                                'id' => 'jalan pintas baru',
                                'pos' => '(n phr)',
                            ],
                            'before the traffic got worse' => [
                                'id' => 'sebelum macet semakin parah',
                                'pos' => '(clause aktif)',
                            ],
                        ],
                        'options' => [
                            'We found a new shortcut before the traffic got worse.',
                            'We was found a new shortcut before the traffic got worse.',
                            'We found a new shortcut before the traffic was got worse.',
                            'We have found a new shortcut before the traffic got worse.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'found\' dan \'got\' keduanya adalah bentuk aktif Simple Past V2.',
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Foto-foto liburan dicetak dan ditempel di album keluarga.',
                        'target_word' => 'were printed ... pasted',
                        'vocab' => [
                            'the vacation photos were printed' => [
                                'id' => 'foto-foto liburan dicetak',
                                'pos' => '(v pasif phr)',
                            ],
                            'pasted into the family album' => [
                                'id' => 'ditempel di album keluarga',
                                'pos' => '(v pasif phr)',
                            ],
                        ],
                        'options' => [
                            'The vacation photos were printed and pasted into the family album.',
                            'The vacation photos was printed and pasted into the family album.',
                            'The vacation photos printed and pasted into the family album.',
                            'The vacation photos were print and paste into the family album.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'photos\' dipasifkan dengan \'were printed ... and pasted\'.',
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Jarak dari rumah ke taman itu kira-kira dua kilometer dengan berjalan kaki.',
                        'target_word' => 'was about two kilometers',
                        'vocab' => [
                            'the distance' => [
                                'id' => 'jarak',
                                'pos' => '(n sg)',
                            ],
                            'from home to the park' => [
                                'id' => 'dari rumah ke taman itu',
                                'pos' => '(prep phr)',
                            ],
                            'was about two kilometers' => [
                                'id' => 'kira-kira dua kilometer',
                                'pos' => '(nominal phr)',
                            ],
                            'on foot' => [
                                'id' => 'dengan berjalan kaki',
                                'pos' => '(prep phr)',
                            ],
                        ],
                        'options' => [
                            'The distance from home to the park was about two kilometers on foot.',
                            'The distance from home to the park were about two kilometers on foot.',
                            'The distance from home to the park did about two kilometers on foot.',
                            'The distance from home to the park was about two kilometer on foot.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The distance\' (tunggal) menggunakan \'was\' + frasa jarak sebagai komplemen.',
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Ayah membawa payung tambahan karena langit terlihat mendung.',
                        'target_word' => 'brought ... looked',
                        'vocab' => [
                            'dad brought' => [
                                'id' => 'ayah membawa',
                                'pos' => '(clause aktif V2)',
                            ],
                            'an extra umbrella' => [
                                'id' => 'payung tambahan',
                                'pos' => '(n phr)',
                            ],
                            'the sky looked cloudy' => [
                                'id' => 'langit terlihat mendung',
                                'pos' => '(clause nominal)',
                            ],
                        ],
                        'options' => [
                            'Dad brought an extra umbrella because the sky looked cloudy.',
                            'Dad was brought an extra umbrella because the sky looked cloudy.',
                            'Dad brought an extra umbrella because the sky were cloudy.',
                            'Dad brought an extra umbrella because the sky did cloudy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'brought\' (aktif V2) berpasangan dengan \'looked cloudy\' (aktif V2 + adjective).',
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Semua pertanyaan dijawab dan dibahas dengan seksama di kelas.',
                        'target_word' => 'were answered and thoroughly discussed',
                        'vocab' => [
                            'all the questions' => [
                                'id' => 'semua pertanyaan',
                                'pos' => '(n pl)',
                            ],
                            'were answered and discussed' => [
                                'id' => 'dijawab dan dibahas',
                                'pos' => '(v pasif phr)',
                            ],
                            'carefully in class' => [
                                'id' => 'dengan seksama di kelas',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'All the questions were answered and thoroughly discussed in class.',
                            'All the questions was answered and thoroughly discussed in class.',
                            'All the questions answered and thoroughly discussed in class.',
                            'All the questions were answer and thoroughly discuss in class.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'questions\' menggunakan pasif koordinatif: \'were answered and thoroughly discussed\'.',
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Pertandingan persahabatan itu berhasil mempererat hubungan antar kedua tim.',
                        'target_word' => 'successfully strengthened',
                        'vocab' => [
                            'the friendly match' => [
                                'id' => 'pertandingan persahabatan itu',
                                'pos' => '(n phr)',
                            ],
                            'successfully strengthened' => [
                                'id' => 'berhasil mempererat',
                                'pos' => '(v2 aktif phr)',
                            ],
                            'the relationship between the two teams' => [
                                'id' => 'hubungan antar kedua tim',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The friendly match successfully strengthened the relationship between the two teams.',
                            'The friendly match was successfully strengthened the relationship between the two teams.',
                            'The friendly match successfully strengthens the relationship between the two teams.',
                            'The friendly match has successfully strengthened the relationship between the two teams.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The friendly match successfully strengthened...\' adalah bentuk verbal aktif V2 yang baku untuk menutup cerita.',
                    ],
                ],
            ],
        ];
    }
}
