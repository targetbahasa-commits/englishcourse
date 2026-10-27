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
            'banner_subtitle' => 'Kuasai penggunaan kata kerja bantu modal (can, could, may, might, must, should, will, would) untuk menyatakan kemungkinan, kemampuan, saran, keharusan, serta bentuk pasif dan dugaan masa lalu dalam konteks kerja, perjalanan, dan kehidupan sosial.',
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
                            'en' => 'The meeting might be postponed if the client cannot confirm in time.',
                            'id' => 'Rapat mungkin ditunda jika klien tidak bisa konfirmasi tepat waktu.',
                            'note' => 'Bentuk "might be postponed" digunakan untuk menyatakan kemungkinan di masa depan.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Menyatakan Kemampuan vs Kesimpulan Pasti (Can vs Must / Cannot)',
                    'rule_formula' => 'Can + V1 (Kemampuan) | Must / Cannot + BE (Kesimpulan Pasti / Mustahil)',
                    'rule_description' => '"Can" menyatakan kemampuan nyata seseorang. "Must be" menyatakan kesimpulan yang hampir pasti, sedangkan lawannya adalah "cannot be" (tidak mungkin, bukan must not).',
                    'examples' => [
                        [
                            'en' => 'He has not replied to any messages since this morning, so he must be in a meeting.',
                            'id' => 'Dia belum membalas pesan apa pun sejak pagi, jadi dia pasti sedang rapat.',
                            'note' => 'Gunakan "must be" untuk menyatakan kesimpulan yang hampir pasti benar.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Menyatakan Saran & Rekomendasi (Should, Ought to)',
                    'rule_formula' => 'Subject + SHOULD / OUGHT TO + V1',
                    'rule_description' => 'Gunakan "should" atau "ought to" untuk menyampaikan saran atau anjuran secara sopan, misalnya dalam konteks kerja atau kebijakan sehari-hari.',
                    'examples' => [
                        [
                            'en' => 'You should double-check the figures before submitting the report.',
                            'id' => 'Kamu sebaiknya memeriksa ulang angka-angkanya sebelum mengirimkan laporan.',
                            'note' => '"Should double-check" menyampaikan saran praktis sebelum sebuah tindakan penting.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Bentuk Pasif Modal & Dugaan Masa Lalu (Modal + Be + V3 / Modal + Have + V3)',
                    'rule_formula' => 'Pasif: Modal + BE + V3 | Masa Lalu: Modal + HAVE + V3',
                    'rule_description' => 'Pola pasif modal ("must be reviewed", "can be collected") memfokuskan kalimat pada tindakannya. Pola masa lalu ("may have missed", "should have confirmed") digunakan untuk menduga atau menyesali hal yang sudah terjadi.',
                    'examples' => [
                        [
                            'en' => 'She may have missed the announcement about the schedule change.',
                            'id' => 'Dia mungkin melewatkan pengumuman tentang perubahan jadwal itu.',
                            'note' => 'Menggunakan "may have missed" untuk menduga sesuatu yang terjadi di masa lalu.'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Modal Auxiliary', 'Fungsi Utama', 'Makna / Nuansa', 'Contoh Kalimat'],
                'rows' => [
                    ['may / might / could', 'Menyatakan Kemungkinan', 'Mungkin / Barangkali', 'The flight might be delayed because of the weather.'],
                    ['can / is able to', 'Menyatakan Kemampuan', 'Dapat / Bisa / Mampu', 'Our new assistant can handle customer complaints calmly.'],
                    ['should / ought to', 'Menyatakan Saran / Anjuran', 'Sebaiknya / Seharusnya', 'You should arrive at least ten minutes before your shift starts.'],
                    ['must / cannot', 'Kesimpulan Pasti', 'Pasti (must) / Mustahil (cannot)', 'That cannot be the correct address; the map clearly shows otherwise.'],
                    ['will / would', 'Masa Depan & Pengandaian', 'Akan (will) / Bersyarat (would)', 'I would accept the offer if the salary were a little higher.'],
                    ['modal + be + V3', 'Bentuk Pasif', 'Dapat / Harus di-...', 'The contract must be reviewed before anyone signs it.'],
                    ['modal + have + V3', 'Dugaan / Penyesalan Masa Lalu', 'Mungkin telah / Seharusnya sudah', 'We should have confirmed the booking earlier, before the price went up.'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The delivery might arrives later than expected.',
                    'correct' => 'The delivery might arrive later than expected.',
                    'explanation' => 'Modal selalu diikuti bentuk kata kerja dasar (V1 murni tanpa tambahan -s/-es).'
                ],
                [
                    'incorrect' => 'He did not answer his phone, so he must not be busy.',
                    'correct' => 'He did not answer his phone, so he cannot be busy.',
                    'explanation' => 'Untuk menarik kesimpulan bahwa sesuatu "tidak mungkin benar", gunakan "cannot be", bukan "must not be".'
                ],
                [
                    'incorrect' => 'I think I may has left the documents at the office.',
                    'correct' => 'I think I may have left the documents at the office.',
                    'explanation' => 'Setelah modal, selalu gunakan kata dasar "have", dilarang menggunakan "has" atau "had".'
                ],
                [
                    'incorrect' => 'You can to reschedule the appointment if you need to.',
                    'correct' => 'You can reschedule the appointment if you need to.',
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
            'concept_description' => 'Dalam percakapan, tulisan kerja, dan rencana perjalanan sehari-hari, kita sering tidak 100% yakin tentang sesuatu. Modal "may", "might", dan "could" digunakan untuk menyatakan hal yang mungkin terjadi atau mungkin benar, tanpa membuat klaim yang terlalu pasti.',
            'formula' => 'Subject + MAY / MIGHT / COULD + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan "may" untuk kemungkinan yang cukup masuk akal.',
              'Gunakan "might" atau "could" untuk kemungkinan yang lebih tidak pasti atau sekadar dugaan.',
              'Modal selalu diikuti kata kerja bentuk dasar (Bare Infinitive / V1 murni), dilarang menambahkan "to" atau akhiran -s/-es.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Rapat dengan klien itu mungkin ditunda jika mereka belum mengonfirmasi sebelum jam lima sore.',
                'target_word' => 'may be postponed',
                'vocab' => [
                  'the meeting with the client' => ['id' => 'rapat dengan klien itu', 'pos' => '(n phr)'],
                  'may' => ['id' => 'mungkin', 'pos' => '(modal)'],
                  'be postponed' => ['id' => 'ditunda', 'pos' => '(v, pasif)'],
                  'confirm' => ['id' => 'mengonfirmasi', 'pos' => '(v)'],
                ],
                'options' => [
                  'The meeting with the client may be postponed if they do not confirm before five in the afternoon.',
                  'The meeting with the client may is postponed if they do not confirm before five in the afternoon.',
                  'The meeting with the client may to be postponed if they do not confirm before five in the afternoon.',
                  'The meeting with the client may being postponed if they do not confirm before five in the afternoon.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "may" wajib diikuti bentuk dasar "be" ("may be postponed"), bukan "is", "to be", atau "being".',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Penerbangan kita mungkin tertunda karena ada badai di kota tujuan.',
                'target_word' => 'might be delayed',
                'vocab' => [
                  'our flight' => ['id' => 'penerbangan kita', 'pos' => '(n phr)'],
                  'might' => ['id' => 'mungkin', 'pos' => '(modal)'],
                  'be delayed' => ['id' => 'tertunda', 'pos' => '(v, pasif)'],
                  'storm' => ['id' => 'badai', 'pos' => '(n)'],
                ],
                'options' => [
                  'Our flight might be delayed because of a storm at the destination city.',
                  'Our flight might is delayed because of a storm at the destination city.',
                  'Our flight might to be delayed because of a storm at the destination city.',
                  'Our flight might being delayed because of a storm at the destination city.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti kata kerja dasar ("might be delayed") untuk menyatakan kemungkinan sebuah jadwal.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Harga sewa apartemen mungkin naik lagi menjelang akhir tahun.',
                'target_word' => 'might rise',
                'vocab' => [
                  'apartment rental prices' => ['id' => 'harga sewa apartemen', 'pos' => '(n phr)'],
                  'rise' => ['id' => 'naik', 'pos' => '(v)'],
                  'toward the end of the year' => ['id' => 'menjelang akhir tahun', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Apartment rental prices might rise again toward the end of the year.',
                  'Apartment rental prices might rises again toward the end of the year.',
                  'Apartment rental prices might to rise again toward the end of the year.',
                  'Apartment rental prices might rising again toward the end of the year.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti verba dasar ("might rise").',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Beberapa menit meditasi sebelum tidur bisa membantumu menghadapi hari yang penuh tekanan dengan lebih tenang.',
                'target_word' => 'could help',
                'vocab' => [
                  'a few minutes of meditation' => ['id' => 'beberapa menit meditasi', 'pos' => '(n phr)'],
                  'could' => ['id' => 'bisa', 'pos' => '(modal)'],
                  'help' => ['id' => 'membantu', 'pos' => '(v)'],
                  'a stressful day' => ['id' => 'hari yang penuh tekanan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'A few minutes of meditation before bed could help you face a stressful day more calmly.',
                  'A few minutes of meditation before bed could helps you face a stressful day more calmly.',
                  'A few minutes of meditation before bed could to help you face a stressful day more calmly.',
                  'A few minutes of meditation before bed could helping you face a stressful day more calmly.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "could" diikuti kata kerja dasar ("could help") untuk memberikan saran yang mungkin berguna.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Lalu lintas menuju bandara mungkin padat pagi ini karena ada perbaikan jalan tol.',
                'target_word' => 'may be',
                'vocab' => [
                  'traffic toward the airport' => ['id' => 'lalu lintas menuju bandara', 'pos' => '(n phr)'],
                  'heavy' => ['id' => 'padat', 'pos' => '(adj)'],
                  'toll road repairs' => ['id' => 'perbaikan jalan tol', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'Traffic toward the airport may be heavy this morning because of toll road repairs.',
                  'Traffic toward the airport may is heavy this morning because of toll road repairs.',
                  'Traffic toward the airport may to be heavy this morning because of toll road repairs.',
                  'Traffic toward the airport may being heavy this morning because of toll road repairs.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "may" diikuti "be" dalam bentuk dasar ("may be"), bukan "is" atau "being".',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Jika kamu terus bekerja lembur setiap malam, kamu mungkin merasa kelelahan pada akhir minggu.',
                'target_word' => 'might feel',
                'vocab' => [
                  'work overtime' => ['id' => 'bekerja lembur', 'pos' => '(v phr)'],
                  'feel' => ['id' => 'merasa', 'pos' => '(v)'],
                  'exhausted' => ['id' => 'kelelahan', 'pos' => '(adj)'],
                ],
                'options' => [
                  'If you keep working overtime every night, you might feel exhausted by the end of the week.',
                  'If you keep working overtime every night, you might feels exhausted by the end of the week.',
                  'If you keep working overtime every night, you might to feel exhausted by the end of the week.',
                  'If you keep working overtime every night, you might feeling exhausted by the end of the week.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti kata kerja dasar ("might feel").',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Pemasok baru itu mungkin menawarkan harga yang jauh lebih kompetitif daripada yang sekarang.',
                'target_word' => 'may offer',
                'vocab' => [
                  'the new supplier' => ['id' => 'pemasok baru itu', 'pos' => '(n phr)'],
                  'offer' => ['id' => 'menawarkan', 'pos' => '(v)'],
                  'far more competitive prices' => ['id' => 'harga yang jauh lebih kompetitif', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'The new supplier may offer far more competitive prices than the current one.',
                  'The new supplier may offers far more competitive prices than the current one.',
                  'The new supplier may to offer far more competitive prices than the current one.',
                  'The new supplier may offering far more competitive prices than the current one.',
                ],
                'correct_index' => 0,
                'explanation' => '"May offer" menyatakan dugaan yang masuk akal tentang sesuatu yang belum dipastikan.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Tim pemasaran kami mungkin pindah ke kantor cabang baru bulan depan.',
                'target_word' => 'could move',
                'vocab' => [
                  'our marketing team' => ['id' => 'tim pemasaran kami', 'pos' => '(n phr)'],
                  'move' => ['id' => 'pindah', 'pos' => '(v)'],
                  'branch office' => ['id' => 'kantor cabang', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'Our marketing team could move to the new branch office next month.',
                  'Our marketing team could moves to the new branch office next month.',
                  'Our marketing team could to move to the new branch office next month.',
                  'Our marketing team could moving to the new branch office next month.',
                ],
                'correct_index' => 0,
                'explanation' => '"Could move" (modal + bare verb) menyatakan kemungkinan yang belum pasti.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Jadwal rutin bangun lebih pagi mungkin membantu meningkatkan produktivitasmu secara keseluruhan.',
                'target_word' => 'might help',
                'vocab' => [
                  'a consistent routine of waking up earlier' => ['id' => 'jadwal rutin bangun lebih pagi', 'pos' => '(n phr)'],
                  'improve' => ['id' => 'meningkatkan', 'pos' => '(v)'],
                  'overall productivity' => ['id' => 'produktivitas secara keseluruhan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'A consistent routine of waking up earlier might help improve your overall productivity.',
                  'A consistent routine of waking up earlier might helps improve your overall productivity.',
                  'A consistent routine of waking up earlier might to help improve your overall productivity.',
                  'A consistent routine of waking up earlier might helping improve your overall productivity.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "might" diikuti bare verb "help".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Negosiasi kontrak itu mungkin memakan waktu lebih lama dari yang kita perkirakan.',
                'target_word' => 'may take',
                'vocab' => [
                  'the contract negotiation' => ['id' => 'negosiasi kontrak itu', 'pos' => '(n phr)'],
                  'take longer than expected' => ['id' => 'memakan waktu lebih lama dari yang diperkirakan', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The contract negotiation may take longer than we expected.',
                  'The contract negotiation may takes longer than we expected.',
                  'The contract negotiation may to take longer than we expected.',
                  'The contract negotiation may taking longer than we expected.',
                ],
                'correct_index' => 0,
                'explanation' => '"May take" adalah frasa modal umum untuk menyatakan dugaan tentang durasi sebuah proses.',
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
              'Dilarang menambahkan "to" setelah modal "can" (misal: "can to negotiate" salah; "can negotiate" benar).',
              'Gunakan "could" untuk kemampuan di masa lalu (misal: "Before the renovation, this hall could seat three hundred guests").',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Asisten baru kami bisa menangani keluhan pelanggan dengan tenang dan profesional.',
                'target_word' => 'can handle',
                'vocab' => [
                  'our new assistant' => ['id' => 'asisten baru kami', 'pos' => '(n phr)'],
                  'can' => ['id' => 'bisa', 'pos' => '(modal)'],
                  'handle' => ['id' => 'menangani', 'pos' => '(v)'],
                  'customer complaints' => ['id' => 'keluhan pelanggan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'Our new assistant can handle customer complaints calmly and professionally.',
                  'Our new assistant can handles customer complaints calmly and professionally.',
                  'Our new assistant can to handle customer complaints calmly and professionally.',
                  'Our new assistant can handling customer complaints calmly and professionally.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bentuk dasar kata kerja ("can handle"), bukan "handles", "to handle", atau "handling".',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Manajer kami bisa menegosiasikan kontrak dengan pemasok mana pun tanpa kesulitan berarti.',
                'target_word' => 'can negotiate',
                'vocab' => [
                  'our manager' => ['id' => 'manajer kami', 'pos' => '(n phr)'],
                  'negotiate' => ['id' => 'menegosiasikan', 'pos' => '(v)'],
                  'without much difficulty' => ['id' => 'tanpa kesulitan berarti', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Our manager can negotiate a contract with almost any supplier without much difficulty.',
                  'Our manager can negotiates a contract with almost any supplier without much difficulty.',
                  'Our manager can to negotiate a contract with almost any supplier without much difficulty.',
                  'Our manager can negotiating a contract with almost any supplier without much difficulty.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti verba dasar ("can negotiate").',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Sebelum direnovasi, aula ini bisa menampung tiga ratus tamu sekaligus.',
                'target_word' => 'could seat',
                'vocab' => [
                  'before the renovation' => ['id' => 'sebelum direnovasi', 'pos' => '(adv phr)'],
                  'could' => ['id' => 'dulu bisa', 'pos' => '(modal)'],
                  'seat' => ['id' => 'menampung (tempat duduk)', 'pos' => '(v)'],
                  'guests at once' => ['id' => 'tamu sekaligus', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'Before the renovation, this hall could seat three hundred guests at once.',
                  'Before the renovation, this hall could seats three hundred guests at once.',
                  'Before the renovation, this hall could to seat three hundred guests at once.',
                  'Before the renovation, this hall could seating three hundred guests at once.',
                ],
                'correct_index' => 0,
                'explanation' => '"Could seat" menyatakan kapasitas di masa lalu dengan kata kerja bentuk dasar.',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Rekan kerjaku bisa berbicara tiga bahasa dengan lancar di depan klien internasional.',
                'target_word' => 'can speak',
                'vocab' => [
                  'my colleague' => ['id' => 'rekan kerjaku', 'pos' => '(n phr)'],
                  'speak' => ['id' => 'berbicara', 'pos' => '(v)'],
                  'fluently' => ['id' => 'dengan lancar', 'pos' => '(adv)'],
                  'international clients' => ['id' => 'klien internasional', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'My colleague can speak three languages fluently in front of international clients.',
                  'My colleague can speaks three languages fluently in front of international clients.',
                  'My colleague can to speak three languages fluently in front of international clients.',
                  'My colleague can speaking three languages fluently in front of international clients.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "speak".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Gudang baru ini bisa menampung dua kali lipat persediaan dibandingkan gudang lama.',
                'target_word' => 'can hold',
                'vocab' => [
                  'this new warehouse' => ['id' => 'gudang baru ini', 'pos' => '(n phr)'],
                  'hold' => ['id' => 'menampung', 'pos' => '(v)'],
                  'twice the inventory' => ['id' => 'dua kali lipat persediaan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'This new warehouse can hold twice the inventory compared to the old one.',
                  'This new warehouse can holds twice the inventory compared to the old one.',
                  'This new warehouse can to hold twice the inventory compared to the old one.',
                  'This new warehouse can holding twice the inventory compared to the old one.',
                ],
                'correct_index' => 0,
                'explanation' => '"Can hold" menyatakan kapasitas atau kemampuan sebuah fasilitas.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Meskipun sudah pensiun, kakek saya masih bisa mengoperasikan mesin jahit tuanya dengan terampil.',
                'target_word' => 'can operate',
                'vocab' => [
                  'even though he has retired' => ['id' => 'meskipun sudah pensiun', 'pos' => '(adv phr)'],
                  'operate' => ['id' => 'mengoperasikan', 'pos' => '(v)'],
                  'skillfully' => ['id' => 'dengan terampil', 'pos' => '(adv)'],
                ],
                'options' => [
                  'Even though he has retired, my grandfather can still operate his old sewing machine skillfully.',
                  'Even though he has retired, my grandfather can still operates his old sewing machine skillfully.',
                  'Even though he has retired, my grandfather can still to operate his old sewing machine skillfully.',
                  'Even though he has retired, my grandfather can still operating his old sewing machine skillfully.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti verba dasar ("can operate").',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Saat masih bekerja di lapangan, dia bisa mendiagnosis masalah mesin hanya dari suaranya.',
                'target_word' => 'could diagnose',
                'vocab' => [
                  'while still working in the field' => ['id' => 'saat masih bekerja di lapangan', 'pos' => '(adv phr)'],
                  'diagnose' => ['id' => 'mendiagnosis', 'pos' => '(v)'],
                  'just from the sound' => ['id' => 'hanya dari suaranya', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'While still working in the field, he could diagnose an engine problem just from the sound.',
                  'While still working in the field, he could diagnoses an engine problem just from the sound.',
                  'While still working in the field, he could to diagnose an engine problem just from the sound.',
                  'While still working in the field, he could diagnosing an engine problem just from the sound.',
                ],
                'correct_index' => 0,
                'explanation' => '"Could diagnose" (modal + bare verb) menyatakan kemampuan di masa lalu.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Sistem keamanan baru ini bisa mendeteksi gerakan mencurigakan dari jarak lima puluh meter.',
                'target_word' => 'can detect',
                'vocab' => [
                  'this new security system' => ['id' => 'sistem keamanan baru ini', 'pos' => '(n phr)'],
                  'detect' => ['id' => 'mendeteksi', 'pos' => '(v)'],
                  'suspicious movement' => ['id' => 'gerakan mencurigakan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'This new security system can detect suspicious movement from fifty meters away.',
                  'This new security system can detects suspicious movement from fifty meters away.',
                  'This new security system can to detect suspicious movement from fifty meters away.',
                  'This new security system can detecting suspicious movement from fifty meters away.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "detect".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Saya belum bisa mengoperasikan perangkat lunak akuntansi itu, tapi saya bisa mempelajarinya dengan cepat.',
                'target_word' => 'can learn',
                'vocab' => [
                  'not yet' => ['id' => 'belum', 'pos' => '(adv)'],
                  'accounting software' => ['id' => 'perangkat lunak akuntansi', 'pos' => '(n phr)'],
                  'learn' => ['id' => 'mempelajari', 'pos' => '(v)'],
                  'quickly' => ['id' => 'dengan cepat', 'pos' => '(adv)'],
                ],
                'options' => [
                  "I can't operate the accounting software yet, but I can learn it quickly.",
                  "I can't operate the accounting software yet, but I can learns it quickly.",
                  "I can't operate the accounting software yet, but I can to learn it quickly.",
                  "I can't operate the accounting software yet, but I can learning it quickly.",
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "learn".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Tim kami bisa menyelesaikan proyek itu sebelum tenggat waktu meskipun anggarannya terbatas.',
                'target_word' => 'can finish',
                'vocab' => [
                  'our team' => ['id' => 'tim kami', 'pos' => '(n phr)'],
                  'finish' => ['id' => 'menyelesaikan', 'pos' => '(v)'],
                  'despite a limited budget' => ['id' => 'meskipun anggarannya terbatas', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Our team can finish the project before the deadline despite a limited budget.',
                  'Our team can finishes the project before the deadline despite a limited budget.',
                  'Our team can to finish the project before the deadline despite a limited budget.',
                  'Our team can finishing the project before the deadline despite a limited budget.',
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
            'concept_description' => 'Gunakan "should" atau "ought to" ketika kamu ingin memberi saran, anjuran, atau rekomendasi kepada orang lain tentang apa yang sebaiknya dilakukan, baik dalam konteks kerja maupun kehidupan sehari-hari.',
            'formula' => 'Subject + SHOULD / OUGHT TO + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan "should + V1" untuk memberi saran sehari-hari maupun saran profesional.',
              '"Ought to" memiliki arti yang sama dengan "should", tapi jarang dipakai dalam percakapan santai.',
              'Bentuk negatif: "should not / shouldn\'t + V1".',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Kamu sebaiknya memeriksa ulang angka-angkanya sebelum mengirimkan laporan ke atasan.',
                'target_word' => 'should double-check',
                'vocab' => [
                  'should' => ['id' => 'sebaiknya', 'pos' => '(modal)'],
                  'double-check' => ['id' => 'memeriksa ulang', 'pos' => '(v)'],
                  'figures' => ['id' => 'angka-angka', 'pos' => '(n)'],
                  'submit' => ['id' => 'mengirimkan', 'pos' => '(v)'],
                ],
                'options' => [
                  'You should double-check the figures before submitting the report to your supervisor.',
                  'You should double-checks the figures before submitting the report to your supervisor.',
                  'You should to double-check the figures before submitting the report to your supervisor.',
                  'You should double-checking the figures before submitting the report to your supervisor.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bentuk dasar kata kerja ("should double-check").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Karyawan sebaiknya tiba setidaknya sepuluh menit sebelum jam kerja dimulai.',
                'target_word' => 'should arrive',
                'vocab' => [
                  'employees' => ['id' => 'karyawan', 'pos' => '(n)'],
                  'arrive' => ['id' => 'tiba', 'pos' => '(v)'],
                  'at least ten minutes before' => ['id' => 'setidaknya sepuluh menit sebelum', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Employees should arrive at least ten minutes before their shift starts.',
                  'Employees should arrives at least ten minutes before their shift starts.',
                  'Employees should to arrive at least ten minutes before their shift starts.',
                  'Employees should arriving at least ten minutes before their shift starts.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should arrive").',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Kamu sebaiknya tidak membagikan informasi klien kepada pihak luar tanpa izin.',
                'target_word' => 'should not share',
                'vocab' => [
                  'should not' => ['id' => 'sebaiknya tidak', 'pos' => '(modal)'],
                  'share' => ['id' => 'membagikan', 'pos' => '(v)'],
                  'outside parties' => ['id' => 'pihak luar', 'pos' => '(n phr)'],
                  'without permission' => ['id' => 'tanpa izin', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'You should not share client information with outside parties without permission.',
                  'You should not shares client information with outside parties without permission.',
                  'You should not to share client information with outside parties without permission.',
                  'You should not sharing client information with outside parties without permission.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk negatif modal tetap diikuti verba dasar ("should not share").',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Dia sebaiknya meminta maaf secara resmi kepada pelanggan atas keterlambatan itu.',
                'target_word' => 'should apologize',
                'vocab' => [
                  'apologize' => ['id' => 'meminta maaf', 'pos' => '(v)'],
                  'formally' => ['id' => 'secara resmi', 'pos' => '(adv)'],
                  'for the delay' => ['id' => 'atas keterlambatan itu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'He should apologize formally to the customer for the delay.',
                  'He should apologizes formally to the customer for the delay.',
                  'He should to apologize formally to the customer for the delay.',
                  'He should apologizing formally to the customer for the delay.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bare verb "apologize".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Kamu sebaiknya membaca kembali kontrak sewa itu sebelum menandatanganinya.',
                'target_word' => 'should review',
                'vocab' => [
                  'review' => ['id' => 'membaca kembali / meninjau', 'pos' => '(v)'],
                  'lease agreement' => ['id' => 'kontrak sewa', 'pos' => '(n phr)'],
                  'before signing it' => ['id' => 'sebelum menandatanganinya', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'You should review the lease agreement before signing it.',
                  'You should reviews the lease agreement before signing it.',
                  'You should to review the lease agreement before signing it.',
                  'You should reviewing the lease agreement before signing it.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should review").',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Panitia sebaiknya mempersiapkan rencana cadangan jika cuaca buruk pada hari acara.',
                'target_word' => 'should prepare',
                'vocab' => [
                  'the committee' => ['id' => 'panitia', 'pos' => '(n)'],
                  'prepare' => ['id' => 'mempersiapkan', 'pos' => '(v)'],
                  'backup plan' => ['id' => 'rencana cadangan', 'pos' => '(n phr)'],
                  'bad weather' => ['id' => 'cuaca buruk', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'The committee should prepare a backup plan in case of bad weather on the event day.',
                  'The committee should prepares a backup plan in case of bad weather on the event day.',
                  'The committee should to prepare a backup plan in case of bad weather on the event day.',
                  'The committee should preparing a backup plan in case of bad weather on the event day.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bare verb "prepare".',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Kita sebaiknya mematikan semua perangkat elektronik sebelum meninggalkan kantor untuk menghemat listrik.',
                'target_word' => 'should turn off',
                'vocab' => [
                  'turn off' => ['id' => 'mematikan', 'pos' => '(v phr)'],
                  'electronic devices' => ['id' => 'perangkat elektronik', 'pos' => '(n phr)'],
                  'save electricity' => ['id' => 'menghemat listrik', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'We should turn off all the electronic devices before leaving the office to save electricity.',
                  'We should turns off all the electronic devices before leaving the office to save electricity.',
                  'We should to turn off all the electronic devices before leaving the office to save electricity.',
                  'We should turning off all the electronic devices before leaving the office to save electricity.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should turn off").',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Peserta sebaiknya mengumpulkan berkas pendaftaran paling lambat Jumat sore.',
                'target_word' => 'should submit',
                'vocab' => [
                  'participants' => ['id' => 'peserta', 'pos' => '(n)'],
                  'submit' => ['id' => 'mengumpulkan', 'pos' => '(v)'],
                  'registration documents' => ['id' => 'berkas pendaftaran', 'pos' => '(n phr)'],
                  'by Friday afternoon at the latest' => ['id' => 'paling lambat Jumat sore', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Participants should submit their registration documents by Friday afternoon at the latest.',
                  'Participants should submits their registration documents by Friday afternoon at the latest.',
                  'Participants should to submit their registration documents by Friday afternoon at the latest.',
                  'Participants should submitting their registration documents by Friday afternoon at the latest.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bare verb "submit".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Kamu sebaiknya beristirahat sejenak jika kamu merasa sangat kelelahan setelah perjalanan panjang itu.',
                'target_word' => 'should rest',
                'vocab' => [
                  'rest' => ['id' => 'beristirahat', 'pos' => '(v)'],
                  'thoroughly exhausted' => ['id' => 'sangat kelelahan', 'pos' => '(adj phr)'],
                  'long journey' => ['id' => 'perjalanan panjang', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'You should rest for a while if you feel thoroughly exhausted after such a long journey.',
                  'You should rests for a while if you feel thoroughly exhausted after such a long journey.',
                  'You should to rest for a while if you feel thoroughly exhausted after such a long journey.',
                  'You should resting for a while if you feel thoroughly exhausted after such a long journey.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti verba dasar ("should rest").',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Kita sebaiknya menghormati pendapat rekan kerja lain meskipun berbeda dari pendapat kita sendiri.',
                'target_word' => 'should respect',
                'vocab' => [
                  'respect' => ['id' => 'menghormati', 'pos' => '(v)'],
                  "colleagues' opinions" => ['id' => 'pendapat rekan kerja', 'pos' => '(n phr)'],
                ],
                'options' => [
                  "We should respect other colleagues' opinions even if they differ from our own.",
                  "We should respects other colleagues' opinions even if they differ from our own.",
                  "We should to respect other colleagues' opinions even if they differ from our own.",
                  "We should respecting other colleagues' opinions even if they differ from our own.",
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
                'id_sentence' => 'Dia belum membalas pesan apa pun sejak pagi, jadi dia pasti sedang rapat.',
                'target_word' => 'must be',
                'vocab' => [
                  'must' => ['id' => 'pasti', 'pos' => '(modal)'],
                  'be' => ['id' => 'berada / adalah', 'pos' => '(v)'],
                  'in a meeting' => ['id' => 'sedang rapat', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'He has not replied to any messages since this morning, so he must be in a meeting.',
                  'He has not replied to any messages since this morning, so he must is in a meeting.',
                  'He has not replied to any messages since this morning, so he must to be in a meeting.',
                  'He has not replied to any messages since this morning, so he must being in a meeting.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be" ("must be"), bukan "is" atau "being".',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Mereka baru saja makan siang bersama klien, jadi mereka pasti tidak lapar sekarang.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'just had lunch with the client' => ['id' => 'baru saja makan siang bersama klien', 'pos' => '(v phr)'],
                  'cannot' => ['id' => 'tidak mungkin', 'pos' => '(modal)'],
                  'hungry' => ['id' => 'lapar', 'pos' => '(adj)'],
                ],
                'options' => [
                  'They just had lunch with the client, so they cannot be hungry now.',
                  'They just had lunch with the client, so they cannot is hungry now.',
                  'They just had lunch with the client, so they cannot to be hungry now.',
                  'They just had lunch with the client, so they cannot being hungry now.',
                ],
                'correct_index' => 0,
                'explanation' => '"Cannot be" digunakan untuk menyatakan bahwa sesuatu tidak mungkin benar.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Mobil itu sangat mahal dan baru, jadi pemiliknya pasti berpenghasilan tinggi.',
                'target_word' => 'must be',
                'vocab' => [
                  'expensive and brand new' => ['id' => 'mahal dan baru', 'pos' => '(adj phr)'],
                  'owner' => ['id' => 'pemilik', 'pos' => '(n)'],
                  'highly paid' => ['id' => 'berpenghasilan tinggi', 'pos' => '(adj phr)'],
                ],
                'options' => [
                  'That car is very expensive and brand new, so its owner must be highly paid.',
                  'That car is very expensive and brand new, so its owner must is highly paid.',
                  'That car is very expensive and brand new, so its owner must to be highly paid.',
                  'That car is very expensive and brand new, so its owner must being highly paid.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Karyawan baru itu terus menguap dan memeriksa jam, jadi dia pasti kelelahan.',
                'target_word' => 'must be',
                'vocab' => [
                  'keep yawning and checking the clock' => ['id' => 'terus menguap dan memeriksa jam', 'pos' => '(v phr)'],
                  'exhausted' => ['id' => 'kelelahan', 'pos' => '(adj)'],
                ],
                'options' => [
                  'The new employee keeps yawning and checking the clock, so he must be exhausted.',
                  'The new employee keeps yawning and checking the clock, so he must is exhausted.',
                  'The new employee keeps yawning and checking the clock, so he must to be exhausted.',
                  'The new employee keeps yawning and checking the clock, so he must being exhausted.',
                ],
                'correct_index' => 0,
                'explanation' => '"Must be" menyatakan kesimpulan yang hampir pasti dari sebuah tanda/bukti.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Dia bisa bernegosiasi dalam bahasa Jepang dengan lancar, jadi dia pasti pernah tinggal di sana selama bertahun-tahun.',
                'target_word' => 'must have',
                'vocab' => [
                  'fluently' => ['id' => 'dengan lancar', 'pos' => '(adv)'],
                  'must have lived' => ['id' => 'pasti pernah tinggal', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'She negotiates in Japanese fluently, so she must have lived there for years.',
                  'She negotiates in Japanese fluently, so she must has lived there for years.',
                  'She negotiates in Japanese fluently, so she must to have lived there for years.',
                  'She negotiates in Japanese fluently, so she must having lived there for years.',
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah modal, gunakan "have" bentuk dasar, bukan "has".',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Kantor itu gelap dan pintunya terkunci, jadi semua staf pasti sudah pulang.',
                'target_word' => 'must have',
                'vocab' => [
                  'dark and locked' => ['id' => 'gelap dan terkunci', 'pos' => '(adj phr)'],
                  'gone home' => ['id' => 'pulang', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The office is dark and the door is locked, so all the staff must have gone home.',
                  'The office is dark and the door is locked, so all the staff must has gone home.',
                  'The office is dark and the door is locked, so all the staff must to have gone home.',
                  'The office is dark and the door is locked, so all the staff must having gone home.',
                ],
                'correct_index' => 0,
                'explanation' => '"Must have gone" (modal + have + V3) menyatakan kesimpulan hampir pasti tentang masa lalu.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Dia baru saja mendapatkan promosi besar, jadi rumor bahwa dia akan mengundurkan diri pasti tidak benar.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'just received a major promotion' => ['id' => 'baru saja mendapatkan promosi besar', 'pos' => '(v phr)'],
                  'resign' => ['id' => 'mengundurkan diri', 'pos' => '(v)'],
                ],
                'options' => [
                  'He just received a major promotion, so the rumor that he will resign cannot be true.',
                  'He just received a major promotion, so the rumor that he will resign cannot is true.',
                  'He just received a major promotion, so the rumor that he will resign cannot to be true.',
                  'He just received a major promotion, so the rumor that he will resign cannot being true.',
                ],
                'correct_index' => 0,
                'explanation' => '"Cannot be true" menyatakan bahwa sesuatu mustahil benar.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Toko itu masih gelap dan tirainya masih tertutup, jadi pemiliknya pasti belum tiba.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'curtains are still closed' => ['id' => 'tirainya masih tertutup', 'pos' => '(adj phr)'],
                  'arrived yet' => ['id' => 'tiba', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The shop is still dark and the curtains are still closed, so the owner cannot be here yet.',
                  'The shop is still dark and the curtains are still closed, so the owner cannot is here yet.',
                  'The shop is still dark and the curtains are still closed, so the owner cannot to be here yet.',
                  'The shop is still dark and the curtains are still closed, so the owner cannot being here yet.',
                ],
                'correct_index' => 0,
                'explanation' => '"Cannot be" menyatakan sesuatu tidak mungkin benar.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Dia memakai jaket tebal dan syal, jadi pasti cuacanya sangat dingin di luar.',
                'target_word' => 'must be',
                'vocab' => [
                  'thick jacket and a scarf' => ['id' => 'jaket tebal dan syal', 'pos' => '(n phr)'],
                  'bitterly cold' => ['id' => 'sangat dingin', 'pos' => '(adj phr)'],
                ],
                'options' => [
                  'He is wearing a thick jacket and a scarf, so it must be bitterly cold outside.',
                  'He is wearing a thick jacket and a scarf, so it must is bitterly cold outside.',
                  'He is wearing a thick jacket and a scarf, so it must to be bitterly cold outside.',
                  'He is wearing a thick jacket and a scarf, so it must being bitterly cold outside.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Anjing itu bermain dengan riang sepanjang hari, jadi dia pasti tidak sakit.',
                'target_word' => 'cannot be',
                'vocab' => [
                  'plays cheerfully all day' => ['id' => 'bermain dengan riang sepanjang hari', 'pos' => '(v phr)'],
                  'sick' => ['id' => 'sakit', 'pos' => '(adj)'],
                ],
                'options' => [
                  'The dog plays cheerfully all day, so it cannot be sick.',
                  'The dog plays cheerfully all day, so it cannot is sick.',
                  'The dog plays cheerfully all day, so it cannot to be sick.',
                  'The dog plays cheerfully all day, so it cannot being sick.',
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
            'concept_description' => '"Will" digunakan untuk menyatakan rencana, janji, atau prediksi masa depan. "Would" digunakan untuk pengandaian atau permintaan yang lebih sopan, termasuk dalam konteks negosiasi dan korespondensi bisnis.',
            'formula' => 'Subject + WILL / WOULD + V1 (Base Form) + Object',
            'rules' => [
              'Gunakan "will + V1" untuk keputusan, janji, atau prediksi tentang masa depan.',
              'Gunakan "would + V1" untuk pengandaian (jika... maka...) atau permintaan sopan.',
              'Bentuk negatif: "will not / won\'t" dan "would not / wouldn\'t".',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Saya akan mengonfirmasi reservasi itu setelah menerima uang muka dari Anda.',
                'target_word' => 'will confirm',
                'vocab' => [
                  'will' => ['id' => 'akan', 'pos' => '(modal)'],
                  'confirm' => ['id' => 'mengonfirmasi', 'pos' => '(v)'],
                  'deposit' => ['id' => 'uang muka', 'pos' => '(n)'],
                ],
                'options' => [
                  'I will confirm the reservation once I receive your deposit.',
                  'I will confirms the reservation once I receive your deposit.',
                  'I will to confirm the reservation once I receive your deposit.',
                  'I will confirming the reservation once I receive your deposit.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bentuk dasar kata kerja ("will confirm").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Jika pemilik rumah setuju menurunkan harga sewa, kami akan menandatangani kontraknya segera.',
                'target_word' => 'would sign',
                'vocab' => [
                  'if' => ['id' => 'jika', 'pos' => '(conj)'],
                  'would' => ['id' => 'akan (pengandaian)', 'pos' => '(modal)'],
                  'sign' => ['id' => 'menandatangani', 'pos' => '(v)'],
                  'lower the rent' => ['id' => 'menurunkan harga sewa', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'If the landlord agreed to lower the rent, we would sign the lease right away.',
                  'If the landlord agreed to lower the rent, we would signs the lease right away.',
                  'If the landlord agreed to lower the rent, we would to sign the lease right away.',
                  'If the landlord agreed to lower the rent, we would signing the lease right away.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "would" diikuti bentuk dasar kata kerja ("would sign") dalam kalimat pengandaian.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Kami akan memperluas cabang ke kota lain tahun depan jika penjualan tahun ini stabil.',
                'target_word' => 'will expand',
                'vocab' => [
                  'expand' => ['id' => 'memperluas', 'pos' => '(v)'],
                  'branches' => ['id' => 'cabang', 'pos' => '(n)'],
                  'stable' => ['id' => 'stabil', 'pos' => '(adj)'],
                ],
                'options' => [
                  "We will expand our branches to other cities next year if this year's sales remain stable.",
                  "We will expands our branches to other cities next year if this year's sales remain stable.",
                  "We will to expand our branches to other cities next year if this year's sales remain stable.",
                  "We will expanding our branches to other cities next year if this year's sales remain stable.",
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bare verb "expand".',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Maukah Anda mempertimbangkan kembali tawaran kami sebelum memutuskan sesuatu?',
                'target_word' => 'would you consider',
                'vocab' => [
                  'would you' => ['id' => 'maukah Anda', 'pos' => '(modal phr)'],
                  'consider' => ['id' => 'mempertimbangkan', 'pos' => '(v)'],
                  'before deciding anything' => ['id' => 'sebelum memutuskan sesuatu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Would you consider our offer again before deciding anything?',
                  'Would you considers our offer again before deciding anything?',
                  'Would you to consider our offer again before deciding anything?',
                  'Would you considering our offer again before deciding anything?',
                ],
                'correct_index' => 0,
                'explanation' => '"Would you consider" adalah permintaan sopan dengan modal + bare verb.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Dia berjanji akan mengirimkan laporan terbaru segera setelah rapat selesai.',
                'target_word' => 'will send',
                'vocab' => [
                  'promise' => ['id' => 'berjanji', 'pos' => '(v)'],
                  'send' => ['id' => 'mengirimkan', 'pos' => '(v)'],
                  'as soon as the meeting ends' => ['id' => 'segera setelah rapat selesai', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'She promises she will send the latest report as soon as the meeting ends.',
                  'She promises she will sends the latest report as soon as the meeting ends.',
                  'She promises she will to send the latest report as soon as the meeting ends.',
                  'She promises she will sending the latest report as soon as the meeting ends.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bentuk dasar kata kerja ("will send").',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Jika saya berada di posisi Anda, saya tidak akan menandatangani kontrak itu tanpa membaca syarat-syaratnya terlebih dahulu.',
                'target_word' => 'would not sign',
                'vocab' => [
                  'if I were in your position' => ['id' => 'jika saya berada di posisi Anda', 'pos' => '(phr)'],
                  'would not' => ['id' => 'tidak akan', 'pos' => '(modal)'],
                  'terms' => ['id' => 'syarat-syarat', 'pos' => '(n)'],
                ],
                'options' => [
                  'If I were in your position, I would not sign that contract without reading the terms first.',
                  'If I were in your position, I would not signs that contract without reading the terms first.',
                  'If I were in your position, I would not to sign that contract without reading the terms first.',
                  'If I were in your position, I would not signing that contract without reading the terms first.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk negatif modal tetap diikuti bare verb ("would not sign").',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Kantor kami akan tutup selama satu minggu penuh untuk renovasi bulan depan.',
                'target_word' => 'will be',
                'vocab' => [
                  'our office' => ['id' => 'kantor kami', 'pos' => '(n phr)'],
                  'closed' => ['id' => 'tutup', 'pos' => '(adj)'],
                  'for a full week' => ['id' => 'selama satu minggu penuh', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Our office will be closed for a full week for renovations next month.',
                  'Our office will is closed for a full week for renovations next month.',
                  'Our office will to be closed for a full week for renovations next month.',
                  'Our office will being closed for a full week for renovations next month.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Dia bilang dia akan tiba tepat waktu untuk wawancara kerja besok.',
                'target_word' => 'will arrive',
                'vocab' => [
                  'on time' => ['id' => 'tepat waktu', 'pos' => '(adv phr)'],
                  'job interview' => ['id' => 'wawancara kerja', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'He said he will arrive on time for the job interview tomorrow.',
                  'He said he will arrives on time for the job interview tomorrow.',
                  'He said he will to arrive on time for the job interview tomorrow.',
                  'He said he will arriving on time for the job interview tomorrow.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bare verb "arrive".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Jika perusahaan itu menawarkan gaji yang lebih tinggi, saya akan mempertimbangkan untuk pindah.',
                'target_word' => 'would consider',
                'vocab' => [
                  'offered a higher salary' => ['id' => 'menawarkan gaji yang lebih tinggi', 'pos' => '(v phr)'],
                  'consider moving' => ['id' => 'mempertimbangkan untuk pindah', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'If that company offered a higher salary, I would consider moving.',
                  'If that company offered a higher salary, I would considers moving.',
                  'If that company offered a higher salary, I would to consider moving.',
                  'If that company offered a higher salary, I would considering moving.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "would" diikuti bare verb "consider" dalam kalimat pengandaian.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Kami akan merayakan keberhasilan proyek itu dengan makan malam bersama seluruh tim.',
                'target_word' => 'will celebrate',
                'vocab' => [
                  'celebrate' => ['id' => 'merayakan', 'pos' => '(v)'],
                  "the project's success" => ['id' => 'keberhasilan proyek itu', 'pos' => '(n phr)'],
                ],
                'options' => [
                  "We will celebrate the project's success with a dinner for the whole team.",
                  "We will celebrates the project's success with a dinner for the whole team.",
                  "We will to celebrate the project's success with a dinner for the whole team.",
                  "We will celebrating the project's success with a dinner for the whole team.",
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
            'concept_title' => 'Bentuk Pasif Modal: can be done, must be reviewed (Modal + Be + V3)',
            'concept_description' => 'Gunakan bentuk pasif modal ketika yang penting adalah tindakannya, bukan siapa yang melakukannya — misalnya untuk kebijakan kantor, prosedur, atau aturan resmi.',
            'formula' => 'Subject + MODAL (can / may / must / should) + BE + Verb 3 (Past Participle)',
            'rules' => [
              'Pola pasif modal: Modal + BE + V3.',
              'Gunakan bentuk ini saat pelaku tindakan tidak penting atau tidak disebutkan.',
              'Jangan lupa "be" setelah modal sebelum kata kerja bentuk ketiga (V3).',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Kontrak ini harus ditinjau oleh pengacara sebelum ditandatangani.',
                'target_word' => 'must be reviewed',
                'vocab' => [
                  'contract' => ['id' => 'kontrak', 'pos' => '(n)'],
                  'must be reviewed' => ['id' => 'harus ditinjau', 'pos' => '(v phr)'],
                  'lawyer' => ['id' => 'pengacara', 'pos' => '(n)'],
                ],
                'options' => [
                  'This contract must be reviewed by a lawyer before it is signed.',
                  'This contract must reviewed by a lawyer before it is signed.',
                  'This contract must be reviewing by a lawyer before it is signed.',
                  'This contract must to be reviewed by a lawyer before it is signed.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk pasif modal: Modal + BE + V3 ("must be reviewed").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Paket itu bisa diambil dari meja resepsionis setelah pukul tiga sore.',
                'target_word' => 'can be collected',
                'vocab' => [
                  'package' => ['id' => 'paket', 'pos' => '(n)'],
                  'can be collected' => ['id' => 'bisa diambil', 'pos' => '(v phr)'],
                  'front desk' => ['id' => 'meja resepsionis', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'The package can be collected from the front desk after three in the afternoon.',
                  'The package can collected from the front desk after three in the afternoon.',
                  'The package can be collecting from the front desk after three in the afternoon.',
                  'The package can to be collected from the front desk after three in the afternoon.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "can be collected" (modal + be + V3) menekankan tindakannya, bukan pelakunya.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Kata sandi perusahaan harus diganti setiap tiga bulan demi keamanan.',
                'target_word' => 'must be changed',
                'vocab' => [
                  'company password' => ['id' => 'kata sandi perusahaan', 'pos' => '(n phr)'],
                  'must be changed' => ['id' => 'harus diganti', 'pos' => '(v phr)'],
                  'for security reasons' => ['id' => 'demi keamanan', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'The company password must be changed every three months for security reasons.',
                  'The company password must changed every three months for security reasons.',
                  'The company password must be changing every three months for security reasons.',
                  'The company password must to be changed every three months for security reasons.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: Modal + BE + V3 ("must be changed").',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Keluhan pelanggan ini sebaiknya ditangani dalam waktu dua puluh empat jam.',
                'target_word' => 'should be handled',
                'vocab' => [
                  'customer complaint' => ['id' => 'keluhan pelanggan', 'pos' => '(n phr)'],
                  'within twenty-four hours' => ['id' => 'dalam waktu dua puluh empat jam', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This customer complaint should be handled within twenty-four hours.',
                  'This customer complaint should handled within twenty-four hours.',
                  'This customer complaint should be handling within twenty-four hours.',
                  'This customer complaint should to be handled within twenty-four hours.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "should be handled".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Laporan keuangan itu bisa diselesaikan dalam waktu dua hari kerja.',
                'target_word' => 'can be finished',
                'vocab' => [
                  'financial report' => ['id' => 'laporan keuangan', 'pos' => '(n phr)'],
                  'within two working days' => ['id' => 'dalam waktu dua hari kerja', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This financial report can be finished within two working days.',
                  'This financial report can finished within two working days.',
                  'This financial report can be finishing within two working days.',
                  'This financial report can to be finished within two working days.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "can be finished".',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Peralatan kantor ini harus diperiksa secara rutin agar tetap berfungsi dengan baik.',
                'target_word' => 'must be inspected',
                'vocab' => [
                  'office equipment' => ['id' => 'peralatan kantor', 'pos' => '(n phr)'],
                  'inspected regularly' => ['id' => 'diperiksa secara rutin', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'This office equipment must be inspected regularly to keep functioning properly.',
                  'This office equipment must inspected regularly to keep functioning properly.',
                  'This office equipment must be inspecting regularly to keep functioning properly.',
                  'This office equipment must to be inspected regularly to keep functioning properly.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "must be inspected".',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Tiket konferensi itu bisa dibeli secara daring melalui situs resmi penyelenggara.',
                'target_word' => 'can be purchased',
                'vocab' => [
                  'conference tickets' => ['id' => 'tiket konferensi', 'pos' => '(n phr)'],
                  'online' => ['id' => 'secara daring', 'pos' => '(adv)'],
                  'official organizer website' => ['id' => 'situs resmi penyelenggara', 'pos' => '(n phr)'],
                ],
                'options' => [
                  "Conference tickets can be purchased online through the organizer's official website.",
                  "Conference tickets can purchased online through the organizer's official website.",
                  "Conference tickets can be purchasing online through the organizer's official website.",
                  "Conference tickets can to be purchased online through the organizer's official website.",
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "can be purchased".',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Kesalahan ini seharusnya bisa dihindari jika kita lebih teliti saat meninjau anggaran.',
                'target_word' => 'could be avoided',
                'vocab' => [
                  'mistake' => ['id' => 'kesalahan', 'pos' => '(n)'],
                  'avoided' => ['id' => 'dihindari', 'pos' => '(v, pasif)'],
                  'more careful when reviewing the budget' => ['id' => 'lebih teliti saat meninjau anggaran', 'pos' => '(adj phr)'],
                ],
                'options' => [
                  'This mistake could be avoided if we were more careful when reviewing the budget.',
                  'This mistake could avoided if we were more careful when reviewing the budget.',
                  'This mistake could be avoiding if we were more careful when reviewing the budget.',
                  'This mistake could to be avoided if we were more careful when reviewing the budget.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "could be avoided".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Ruang rapat ini harus dibersihkan sebelum presentasi klien dimulai.',
                'target_word' => 'must be cleaned',
                'vocab' => [
                  'meeting room' => ['id' => 'ruang rapat', 'pos' => '(n phr)'],
                  'client presentation begins' => ['id' => 'presentasi klien dimulai', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'This meeting room must be cleaned before the client presentation begins.',
                  'This meeting room must cleaned before the client presentation begins.',
                  'This meeting room must be cleaning before the client presentation begins.',
                  'This meeting room must to be cleaned before the client presentation begins.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola pasif modal: "must be cleaned".',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Dokumen ini harus dikirim ke kantor pusat paling lambat hari Jumat.',
                'target_word' => 'must be sent',
                'vocab' => [
                  'document' => ['id' => 'dokumen', 'pos' => '(n)'],
                  'head office' => ['id' => 'kantor pusat', 'pos' => '(n phr)'],
                  'by Friday at the latest' => ['id' => 'paling lambat hari Jumat', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This document must be sent to the head office by Friday at the latest.',
                  'This document must sent to the head office by Friday at the latest.',
                  'This document must be sending to the head office by Friday at the latest.',
                  'This document must to be sent to the head office by Friday at the latest.',
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
                'id_sentence' => 'Dia mungkin melewatkan pengumuman tentang perubahan jadwal rapat itu.',
                'target_word' => 'may have missed',
                'vocab' => [
                  'may have missed' => ['id' => 'mungkin melewatkan', 'pos' => '(v phr)'],
                  'announcement' => ['id' => 'pengumuman', 'pos' => '(n)'],
                  'schedule change' => ['id' => 'perubahan jadwal', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'She may have missed the announcement about the meeting schedule change.',
                  'She may has missed the announcement about the meeting schedule change.',
                  'She may have miss the announcement about the meeting schedule change.',
                  'She may having missed the announcement about the meeting schedule change.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "may have + V3" ("may have missed") menyatakan dugaan tentang masa lalu.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Kami seharusnya mengonfirmasi pemesanan itu lebih awal, sebelum harganya naik.',
                'target_word' => 'should have confirmed',
                'vocab' => [
                  'should have confirmed' => ['id' => 'seharusnya mengonfirmasi', 'pos' => '(v phr)'],
                  'booking' => ['id' => 'pemesanan', 'pos' => '(n)'],
                ],
                'options' => [
                  'We should have confirmed the booking earlier, before the price went up.',
                  'We should has confirmed the booking earlier, before the price went up.',
                  'We should have confirm the booking earlier, before the price went up.',
                  'We should having confirmed the booking earlier, before the price went up.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" menyatakan penyesalan tentang sesuatu yang tidak dilakukan.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Jalanan di depan kantor basah, jadi pasti sudah hujan deras semalam.',
                'target_word' => 'must have rained',
                'vocab' => [
                  'wet' => ['id' => 'basah', 'pos' => '(adj)'],
                  'must have rained' => ['id' => 'pasti sudah hujan', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The street in front of the office is wet, so it must have rained heavily last night.',
                  'The street in front of the office is wet, so it must has rained heavily last night.',
                  'The street in front of the office is wet, so it must have rain heavily last night.',
                  'The street in front of the office is wet, so it must having rained heavily last night.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "must have + V3" menyatakan kesimpulan hampir pasti tentang masa lalu.',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Saya seharusnya mempersiapkan presentasi itu lebih matang untuk rapat kemarin.',
                'target_word' => 'should have prepared',
                'vocab' => [
                  'should have prepared' => ['id' => 'seharusnya mempersiapkan', 'pos' => '(v phr)'],
                  'more thoroughly' => ['id' => 'lebih matang', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  "I should have prepared the presentation more thoroughly for yesterday's meeting.",
                  "I should has prepared the presentation more thoroughly for yesterday's meeting.",
                  "I should have prepare the presentation more thoroughly for yesterday's meeting.",
                  "I should having prepared the presentation more thoroughly for yesterday's meeting.",
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" ("should have prepared") menyatakan penyesalan.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Dia tidak membalas panggilan apa pun sejak sore, jadi dia mungkin sedang mengemudi.',
                'target_word' => 'might have been',
                'vocab' => [
                  "didn't answer any calls" => ['id' => 'tidak membalas panggilan apa pun', 'pos' => '(v phr)'],
                  'might have been driving' => ['id' => 'mungkin sedang mengemudi', 'pos' => '(v phr)'],
                ],
                'options' => [
                  "He didn't answer any calls since the afternoon, so he might have been driving.",
                  "He didn't answer any calls since the afternoon, so he might has been driving.",
                  "He didn't answer any calls since the afternoon, so he might have being driving.",
                  "He didn't answer any calls since the afternoon, so he might having been driving.",
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "might have been + V-ing" menyatakan dugaan tentang kegiatan di masa lalu.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Kami seharusnya memesan tiket kereta lebih awal sebelum musim liburan dimulai.',
                'target_word' => 'should have booked',
                'vocab' => [
                  'should have booked' => ['id' => 'seharusnya memesan', 'pos' => '(v phr)'],
                  'before the holiday season began' => ['id' => 'sebelum musim liburan dimulai', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'We should have booked the train tickets earlier before the holiday season began.',
                  'We should has booked the train tickets earlier before the holiday season began.',
                  'We should have book the train tickets earlier before the holiday season began.',
                  'We should having booked the train tickets earlier before the holiday season began.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" menyatakan penyesalan tentang keputusan masa lalu.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Alarm keamanan itu berbunyi, jadi seseorang pasti sudah masuk tanpa izin ke dalam gudang.',
                'target_word' => 'must have entered',
                'vocab' => [
                  'went off' => ['id' => 'berbunyi', 'pos' => '(v phr)'],
                  'must have entered' => ['id' => 'pasti sudah masuk', 'pos' => '(v phr)'],
                  'without permission' => ['id' => 'tanpa izin', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'The security alarm went off, so someone must have entered the warehouse without permission.',
                  'The security alarm went off, so someone must has entered the warehouse without permission.',
                  'The security alarm went off, so someone must have enter the warehouse without permission.',
                  'The security alarm went off, so someone must having entered the warehouse without permission.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "must have + V3" menyatakan kesimpulan hampir pasti.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Dia mungkin salah menafsirkan instruksi yang saya berikan melalui pesan tadi.',
                'target_word' => 'might have misunderstood',
                'vocab' => [
                  'might have misunderstood' => ['id' => 'mungkin salah menafsirkan', 'pos' => '(v phr)'],
                  'instructions' => ['id' => 'instruksi', 'pos' => '(n)'],
                ],
                'options' => [
                  'He might have misunderstood the instructions I gave through the message earlier.',
                  'He might has misunderstood the instructions I gave through the message earlier.',
                  'He might have misunderstand the instructions I gave through the message earlier.',
                  'He might having misunderstood the instructions I gave through the message earlier.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "might have + V3" menyatakan dugaan tentang masa lalu.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Kamu seharusnya tidak berjanji pada klien sebelum berkonsultasi dengan tim manajemen.',
                'target_word' => 'should not have promised',
                'vocab' => [
                  'should not have promised' => ['id' => 'seharusnya tidak berjanji', 'pos' => '(v phr)'],
                  'consulted' => ['id' => 'berkonsultasi', 'pos' => '(v)'],
                ],
                'options' => [
                  'You should not have promised the client before consulting the management team.',
                  'You should not has promised the client before consulting the management team.',
                  'You should not have promise the client before consulting the management team.',
                  'You should not having promised the client before consulting the management team.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola negatif "should not have + V3" menyatakan penyesalan atas tindakan yang dilakukan.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Arsipnya sudah berantakan, jadi dia pasti terburu-buru saat menutup kantor tadi malam.',
                'target_word' => 'must have been',
                'vocab' => [
                  'messy' => ['id' => 'berantakan', 'pos' => '(adj)'],
                  'must have been in a hurry' => ['id' => 'pasti terburu-buru', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The files are messy, so she must have been in a hurry when closing the office last night.',
                  'The files are messy, so she must has been in a hurry when closing the office last night.',
                  'The files are messy, so she must have be in a hurry when closing the office last night.',
                  'The files are messy, so she must having been in a hurry when closing the office last night.',
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
            'concept_description' => 'Latihan ini menggabungkan semua fungsi modal yang telah kamu pelajari: kemungkinan, kemampuan, saran, kepastian, masa depan, bentuk pasif, dan dugaan masa lalu — semua dalam konteks kerja, perjalanan, dan kehidupan sosial.',
            'formula' => 'Subject + MODAL + V1 (atau BE + V3 / HAVE + V3 sesuai konteks)',
            'rules' => [
              'Kenali dulu makna yang ingin disampaikan (kemungkinan, saran, kepastian, dsb.) sebelum memilih modal yang tepat.',
              'Modal selalu diikuti bentuk dasar kata kerja, baik dalam bentuk aktif, pasif, maupun dugaan masa lalu.',
              'Perhatikan konteks kalimat untuk menentukan modal mana yang paling cocok.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Karyawan baru sebaiknya menyelesaikan masa orientasi sebelum menangani proyek besar.',
                'target_word' => 'should complete',
                'vocab' => [
                  'complete the orientation period' => ['id' => 'menyelesaikan masa orientasi', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'New employees should complete the orientation period before handling a major project.',
                  'New employees should completes the orientation period before handling a major project.',
                  'New employees should to complete the orientation period before handling a major project.',
                  'New employees should completing the orientation period before handling a major project.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "should" diikuti bentuk dasar kata kerja ("should complete").',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Dia mungkin terlambat ke rapat karena kemacetan parah di jalan tol.',
                'target_word' => 'may be',
                'vocab' => [
                  'late' => ['id' => 'terlambat', 'pos' => '(adj)'],
                  'severe traffic jam' => ['id' => 'kemacetan parah', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'He may be late for the meeting because of a severe traffic jam on the toll road.',
                  'He may is late for the meeting because of a severe traffic jam on the toll road.',
                  'He may to be late for the meeting because of a severe traffic jam on the toll road.',
                  'He may being late for the meeting because of a severe traffic jam on the toll road.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "may" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Semua jendela gudang ini harus ditutup rapat sebelum badai tiba.',
                'target_word' => 'must be closed',
                'vocab' => [
                  'warehouse windows' => ['id' => 'jendela gudang', 'pos' => '(n phr)'],
                  'tightly closed' => ['id' => 'ditutup rapat', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'All the warehouse windows must be closed tightly before the storm arrives.',
                  'All the warehouse windows must closed tightly before the storm arrives.',
                  'All the warehouse windows must be closing tightly before the storm arrives.',
                  'All the warehouse windows must to be closed tightly before the storm arrives.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk pasif modal: "must be closed".',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Dia bisa memimpin presentasi dengan sangat percaya diri meskipun baru bergabung dua bulan lalu.',
                'target_word' => 'can lead',
                'vocab' => [
                  'lead a presentation' => ['id' => 'memimpin presentasi', 'pos' => '(v phr)'],
                  'confidently' => ['id' => 'dengan percaya diri', 'pos' => '(adv)'],
                ],
                'options' => [
                  'He can lead a presentation very confidently even though he only joined two months ago.',
                  'He can leads a presentation very confidently even though he only joined two months ago.',
                  'He can to lead a presentation very confidently even though he only joined two months ago.',
                  'He can leading a presentation very confidently even though he only joined two months ago.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "lead".',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Saya seharusnya menghubungi pemasok itu kemarin, tapi saya kehabisan waktu.',
                'target_word' => 'should have contacted',
                'vocab' => [
                  'should have contacted' => ['id' => 'seharusnya menghubungi', 'pos' => '(v phr)'],
                  'ran out of time' => ['id' => 'kehabisan waktu', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'I should have contacted the supplier yesterday, but I ran out of time.',
                  'I should has contacted the supplier yesterday, but I ran out of time.',
                  'I should have contact the supplier yesterday, but I ran out of time.',
                  'I should having contacted the supplier yesterday, but I ran out of time.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "should have + V3" menyatakan penyesalan atas sesuatu yang tidak dilakukan.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Proposal ini harus dikumpulkan sebelum rapat dewan dimulai besok pagi.',
                'target_word' => 'must be submitted',
                'vocab' => [
                  'proposal' => ['id' => 'proposal', 'pos' => '(n)'],
                  'submitted' => ['id' => 'dikumpulkan', 'pos' => '(v, pasif)'],
                  'board meeting' => ['id' => 'rapat dewan', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'This proposal must be submitted before the board meeting starts tomorrow morning.',
                  'This proposal must submitted before the board meeting starts tomorrow morning.',
                  'This proposal must be submitting before the board meeting starts tomorrow morning.',
                  'This proposal must to be submitted before the board meeting starts tomorrow morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Bentuk pasif modal: "must be submitted".',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Kita akan merayakan pencapaian target penjualan triwulan ini minggu depan.',
                'target_word' => 'will celebrate',
                'vocab' => [
                  'quarterly sales target' => ['id' => 'target penjualan triwulan', 'pos' => '(n phr)'],
                  'next week' => ['id' => 'minggu depan', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  "We will celebrate reaching this quarter's sales target next week.",
                  "We will celebrates reaching this quarter's sales target next week.",
                  "We will to celebrate reaching this quarter's sales target next week.",
                  "We will celebrating reaching this quarter's sales target next week.",
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "will" diikuti bare verb "celebrate".',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Server kantor mati total, jadi pasti ada gangguan listrik yang besar.',
                'target_word' => 'must be',
                'vocab' => [
                  'completely down' => ['id' => 'mati total', 'pos' => '(adj phr)'],
                  'major power outage' => ['id' => 'gangguan listrik yang besar', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'The office server is completely down, so there must be a major power outage.',
                  'The office server is completely down, so there must is a major power outage.',
                  'The office server is completely down, so there must to be a major power outage.',
                  'The office server is completely down, so there must being a major power outage.',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "must" diikuti bentuk dasar "be".',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Bisakah Anda menjaga meja saya sebentar sementara saya menerima telepon penting?',
                'target_word' => 'can you watch',
                'vocab' => [
                  'watch' => ['id' => 'menjaga', 'pos' => '(v)'],
                  'take an important call' => ['id' => 'menerima telepon penting', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'Can you watch my desk for a moment while I take an important call?',
                  'Can you watches my desk for a moment while I take an important call?',
                  'Can you to watch my desk for a moment while I take an important call?',
                  'Can you watching my desk for a moment while I take an important call?',
                ],
                'correct_index' => 0,
                'explanation' => 'Modal "can" diikuti bare verb "watch" dalam bentuk pertanyaan.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Dia mungkin sudah berangkat sebelum kita sempat menghubunginya tadi pagi.',
                'target_word' => 'might have left',
                'vocab' => [
                  'might have left' => ['id' => 'mungkin sudah berangkat', 'pos' => '(v phr)'],
                  'reach him' => ['id' => 'menghubunginya', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'He might have left before we managed to reach him this morning.',
                  'He might has left before we managed to reach him this morning.',
                  'He might have leave before we managed to reach him this morning.',
                  'He might having left before we managed to reach him this morning.',
                ],
                'correct_index' => 0,
                'explanation' => 'Pola "might have + V3" menyatakan dugaan tentang masa lalu.',
              ],
            ],
          ],
        ];
    }
}
