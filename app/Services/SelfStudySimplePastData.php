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
            'banner_title' => 'Simple Past Tense: Reporting What Happened',
            'banner_subtitle' => 'Kuasai cara melaporkan kejadian yang sudah selesai di masa lalu pada level menengah: kata kerja beraturan & tidak beraturan (aktif), kalimat nominal dengan was/were, kalimat pasif (was/were + V3), kalimat negatif (did not + V1), dan penempatan keterangan waktu secara tepat.',
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
            'concept_summary' => 'Simple Past Tense digunakan untuk melaporkan kejadian, kegiatan, atau keadaan yang sudah selesai sepenuhnya di masa lalu (Completed Past Events) — misalnya apa yang terjadi pada proyek kerja minggu lalu atau bagaimana sebuah acara berlangsung. Ada tiga bentuk dasar yang perlu dikuasai: Bentuk Verbal Aktif (S + V2), Bentuk Nominal (S + was/were + Complement), dan Bentuk Pasif (S + was/were + V3).',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Beraturan vs Tidak Beraturan (Subject + V2)',
                    'rule_formula' => 'Subject + Verb 2 + Object / Complement',
                    'rule_description' => 'Gunakan V2 beraturan (-ed) atau tidak beraturan untuk tindakan aktif masa lalu. Subjek tunggal dan jamak menggunakan bentuk V2 yang sama. Jangan menambahkan was/were di depan V2 aktif (SALAH: "The manager was approved the budget" ➔ BENAR: "The manager approved the budget").',
                    'examples' => [
                        [
                            'en' => 'The company launched its new product three weeks earlier than planned.',
                            'id' => 'Perusahaan itu meluncurkan produk barunya tiga minggu lebih cepat dari rencana.',
                            'note' => '"launched" adalah bentuk V2 aktif beraturan.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Bentuk Nominal Lampau: was vs were (Subject + was/were + Complement)',
                    'rule_formula' => 'Singular Subject + WAS + Adj/Noun | Plural Subject + WERE + Adj/Noun',
                    'rule_description' => 'Gunakan "was" untuk subjek tunggal (I, he, she, it, the proposal, the traffic) dan "were" untuk subjek jamak (we, they, the negotiations). Diikuti kata sifat, kata benda, atau frasa preposisi tanpa kata kerja aksi.',
                    'examples' => [
                        [
                            'en' => 'The negotiations were unusually tense throughout the afternoon.',
                            'id' => 'Negosiasi itu terasa sangat tegang sepanjang sore.',
                            'note' => 'Subjek jamak "the negotiations" dipadukan dengan "were tense".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif (Subject + was/were + V3)',
                    'rule_formula' => 'Subject + WAS / WERE + Verb 3 (Past Participle)',
                    'rule_description' => 'Gunakan pasif lampau saat kita ingin fokus pada benda/orang yang menerima tindakan, bukan pelakunya (contoh: "the contract was signed", "the applications were reviewed"). Verba setelah was/were WAJIB berbentuk V3 (Past Participle).',
                    'examples' => [
                        [
                            'en' => 'The entire office was renovated while most staff worked remotely.',
                            'id' => 'Seluruh kantor direnovasi sementara sebagian besar staf bekerja dari jarak jauh.',
                            'note' => '"was renovated" (was + V3) menjelaskan tindakan yang dikenakan pada kantor.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Bentuk Negatif (did not + V1 / was/were not)',
                    'rule_formula' => 'Verbal: S + DID NOT + V1 (Base Form) | Nominal/Pasif: S + WAS/WERE NOT + Adj/V3',
                    'rule_description' => 'Pada kalimat verbal negatif, verba selalu kembali ke bentuk dasar V1 murni setelah "did not" (did not attend, did not submit). Jangan pernah menggunakan V2 setelah did not.',
                    'examples' => [
                        [
                            'en' => 'The supplier did not deliver the materials on time, although they had confirmed the schedule.',
                            'id' => 'Pemasok tidak mengirimkan bahan tepat waktu, meskipun mereka sudah mengonfirmasi jadwalnya.',
                            'note' => '"did not deliver" menggunakan V1 "deliver" setelah "did not".'
                        ]
                    ]
                ]
            ],
            'contrast_table' => [
                'headers' => ['Kategori Kalimat', 'Pola Rumus Baku', 'Kapan Digunakan', 'Contoh Kalimat'],
                'rows' => [
                    ['Verbal Aktif (Beraturan)', 'Subject + V2 (-ed)', 'Aksi aktif subjek yang selesai di masa lalu', 'They finalized the contract on Friday afternoon.'],
                    ['Verbal Aktif (Tidak Beraturan)', 'Subject + Irregular V2', 'Aksi aktif kata kerja tak beraturan', 'She caught an earlier train to avoid the traffic.'],
                    ['Nominal Lampau (Tunggal)', 'Singular Subject + was + Adj/Noun', 'Kondisi/sifat subjek tunggal masa lalu', 'The presentation was surprisingly effective.'],
                    ['Nominal Lampau (Jamak)', 'Plural Subject + were + Adj/Noun', 'Kondisi/sifat subjek jamak masa lalu', 'The results were far better than expected.'],
                    ['Pasif (Tunggal)', 'Singular Subject + was + V3', 'Benda tunggal yang dikenai tindakan', 'The proposal was rejected by the board.'],
                    ['Pasif (Jamak)', 'Plural Subject + were + V3', 'Benda jamak yang dikenai tindakan', 'The invoices were processed within two days.'],
                    ['Verbal Negatif', 'Subject + did not + V1', 'Penyangkalan kejadian/aksi lampau', 'He did not respond to the client\'s email.'],
                    ['Nominal/Pasif Negatif', 'Subject + was/were not + Adj/V3', 'Kondisi negatif atau tindakan tidak terjadi', 'The venue was not available on such short notice.']
                ]
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'The manager was approved the request yesterday.',
                    'correct' => 'The manager approved the request yesterday.',
                    'explanation' => 'Jangan menyisipkan "was/were" di depan kata kerja aktif transitif. "The manager approved" adalah bentuk aktif yang benar.'
                ],
                [
                    'incorrect' => 'A sudden problem was occurred during the presentation.',
                    'correct' => 'A sudden problem occurred during the presentation.',
                    'explanation' => 'Kata kerja intransitif seperti "occur", "arrive", "happen" tidak bisa dipasifkan.'
                ],
                [
                    'incorrect' => 'The team did not submitted the report on time.',
                    'correct' => 'The team did not submit the report on time.',
                    'explanation' => 'Setelah "did not", kata kerja WAJIB kembali ke bentuk dasar V1 ("submit", bukan "submitted").'
                ],
                [
                    'incorrect' => 'Last quarter, the company has expanded into two new markets.',
                    'correct' => 'Last quarter, the company expanded into two new markets.',
                    'explanation' => 'Keterangan waktu lampau spesifik ("Last quarter") mewajibkan Simple Past V2, bukan Present Perfect.'
                ]
            ],
            'exam_tips' => [
                'Gunakan Simple Past Pasif (was/were + V3) saat kamu ingin menekankan benda/orang yang menerima tindakan, bukan siapa pelakunya.',
                'Gunakan Simple Past Aktif (V2) saat menekankan siapa yang melakukan tindakan ("The team launched...", "She negotiated...").',
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
                'concept_description' => 'Simple Past Tense bentuk verbal aktif digunakan untuk melaporkan kegiatan atau kejadian yang sudah selesai di masa lampau (Past Completed Action). Pada kata kerja beraturan (Regular Verbs), bentuk lampau dibentuk dengan menambahkan akhiran \'-ed\' atau \'-d\' pada bentuk dasar kata kerja (V1).',
                'formula' => 'Subject + Verb 2 (-ed) + Object / Complement + (Past Time Marker)',
                'rules' => [
                    'Bentuk V2 beraturan dibentuk dengan menambahkan \'-ed\' pada kata kerja dasar (launch -> launched, process -> processed).',
                    'Jika kata kerja berakhir dengan huruf \'e\', cukup tambahkan \'-d\' (approve -> approved, finalize -> finalized).',
                    'Jika berakhiran konsonan + \'y\', ubah \'y\' menjadi \'i\' lalu tambahkan \'-ed\' (apply -> applied, carry -> carried).',
                    'Subject-Verb Agreement pada Simple Past verbal tidak membedakan subjek tunggal dan jamak; semua subjek menggunakan bentuk V2 yang sama.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Tim pemasaran meluncurkan kampanye baru itu dua minggu lebih awal.',
                        'target_word' => 'launched',
                        'vocab' => [
                            'the marketing team' => ['id' => 'tim pemasaran', 'pos' => '(n)'],
                            'launched' => ['id' => 'meluncurkan', 'pos' => '(v2)'],
                            'the new campaign' => ['id' => 'kampanye baru itu', 'pos' => '(n phr)'],
                            'two weeks earlier' => ['id' => 'dua minggu lebih awal', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The marketing team launched the new campaign two weeks earlier.',
                            'The marketing team launch the new campaign two weeks earlier.',
                            'The marketing team launches the new campaign two weeks earlier.',
                            'The marketing team launching the new campaign two weeks earlier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Tindakan lampau yang telah selesai dilaporkan dengan bentuk V2 beraturan \'launched\'. Pilihan \'launch\' (V1) atau \'launches\' salah tenses.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Kami memproses semua permohonan sebelum jam kantor berakhir.',
                        'target_word' => 'processed',
                        'vocab' => [
                            'we' => ['id' => 'kami', 'pos' => '(pron)'],
                            'processed' => ['id' => 'memproses', 'pos' => '(v2)'],
                            'all the applications' => ['id' => 'semua permohonan', 'pos' => '(n phr)'],
                            'before office hours ended' => ['id' => 'sebelum jam kantor berakhir', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'We processed all the applications before office hours ended.',
                            'We process all the applications before office hours ended.',
                            'We processes all the applications before office hours ended.',
                            'We was processed all the applications before office hours ended.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk aktif lampau menggunakan V2 \'processed\'. Bentuk \'was processed\' salah karena itu pasif, sedangkan subjeknya pelaku aktif (\'kami\').',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Konsultan itu menjelaskan strategi baru dengan sangat jelas kepada klien.',
                        'target_word' => 'explained',
                        'vocab' => [
                            'the consultant' => ['id' => 'konsultan itu', 'pos' => '(n)'],
                            'explained' => ['id' => 'menjelaskan', 'pos' => '(v2)'],
                            'the new strategy' => ['id' => 'strategi baru', 'pos' => '(n phr)'],
                            'very clearly to the client' => ['id' => 'dengan sangat jelas kepada klien', 'pos' => '(adv phr)'],
                        ],
                        'options' => [
                            'The consultant explained the new strategy very clearly to the client.',
                            'The consultant explain the new strategy very clearly to the client.',
                            'The consultant explains the new strategy very clearly to the client.',
                            'The consultant is explained the new strategy very clearly to the client.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'explained\' adalah bentuk V2 lampau aktif dari kata kerja \'explain\'.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Manajer HR mengumumkan kebijakan kerja jarak jauh bulan lalu.',
                        'target_word' => 'announced',
                        'vocab' => [
                            'the HR manager' => ['id' => 'manajer HR', 'pos' => '(n phr)'],
                            'announced' => ['id' => 'mengumumkan', 'pos' => '(v2)'],
                            'the remote-work policy' => ['id' => 'kebijakan kerja jarak jauh', 'pos' => '(n phr)'],
                            'last month' => ['id' => 'bulan lalu', 'pos' => '(time adv)'],
                        ],
                        'options' => [
                            'The HR manager announced the remote-work policy last month.',
                            'The HR manager announces the remote-work policy last month.',
                            'The HR manager announce the remote-work policy last month.',
                            'The HR manager was announce the remote-work policy last month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu lampau \'last month\' mewajibkan penggunaan V2 \'announced\'.',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Arsitek itu merancang sebuah rumah modern dengan taman di atap.',
                        'target_word' => 'designed',
                        'vocab' => [
                            'the architect' => ['id' => 'arsitek itu', 'pos' => '(n)'],
                            'designed' => ['id' => 'merancang', 'pos' => '(v2)'],
                            'a modern house' => ['id' => 'rumah modern', 'pos' => '(n phr)'],
                            'with a rooftop garden' => ['id' => 'dengan taman di atap', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The architect designed a modern house with a rooftop garden.',
                            'The architect design a modern house with a rooftop garden.',
                            'The architect designs a modern house with a rooftop garden.',
                            'The architect were designed a modern house with a rooftop garden.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'designed\' adalah bentuk V2 beraturan untuk subjek aktif tunggal \'the architect\'.',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Para peserta menyelesaikan survei itu dalam waktu kurang dari lima belas menit.',
                        'target_word' => 'completed',
                        'vocab' => [
                            'the participants' => ['id' => 'para peserta', 'pos' => '(n pl)'],
                            'completed' => ['id' => 'menyelesaikan', 'pos' => '(v2)'],
                            'the survey' => ['id' => 'survei itu', 'pos' => '(n phr)'],
                            'in less than fifteen minutes' => ['id' => 'dalam waktu kurang dari lima belas menit', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The participants completed the survey in less than fifteen minutes.',
                            'The participants complete the survey in less than fifteen minutes.',
                            'The participants completes the survey in less than fifteen minutes.',
                            'The participants was completed the survey in less than fifteen minutes.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'completed\' (V2) menyatakan tindakan lampau yang telah tuntas.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Teknisi itu memperbaiki server yang bermasalah akhir pekan lalu.',
                        'target_word' => 'repaired',
                        'vocab' => [
                            'the technician' => ['id' => 'teknisi itu', 'pos' => '(n)'],
                            'repaired' => ['id' => 'memperbaiki', 'pos' => '(v2)'],
                            'the faulty server' => ['id' => 'server yang bermasalah', 'pos' => '(n phr)'],
                            'last weekend' => ['id' => 'akhir pekan lalu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The technician repaired the faulty server last weekend.',
                            'The technician repairs the faulty server last weekend.',
                            'The technician repair the faulty server last weekend.',
                            'The technician was repaired the faulty server last weekend.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Tindakan aktif lampau menggunakan V2 \'repaired\'. \'The technician\' adalah pelaku aktif, jadi tidak perlu \'was\'.',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Panitia acara mengumumkan pemenang di depan seluruh tamu undangan.',
                        'target_word' => 'announced',
                        'vocab' => [
                            'the event committee' => ['id' => 'panitia acara', 'pos' => '(n phr)'],
                            'announced' => ['id' => 'mengumumkan', 'pos' => '(v2)'],
                            'the winner' => ['id' => 'pemenang', 'pos' => '(n phr)'],
                            'in front of all the invited guests' => ['id' => 'di depan seluruh tamu undangan', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The event committee announced the winner in front of all the invited guests.',
                            'The event committee announce the winner in front of all the invited guests.',
                            'The event committee announces the winner in front of all the invited guests.',
                            'The event committee were announced the winner in front of all the invited guests.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'announced\' adalah bentuk lampau V2 beraturan.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Toko itu menutup lebih awal karena ada pemadaman listrik mendadak.',
                        'target_word' => 'closed',
                        'vocab' => [
                            'the store' => ['id' => 'toko itu', 'pos' => '(n)'],
                            'closed' => ['id' => 'menutup', 'pos' => '(v2)'],
                            'early' => ['id' => 'lebih awal', 'pos' => '(adv)'],
                            'because of a sudden power outage' => ['id' => 'karena ada pemadaman listrik mendadak', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The store closed early because of a sudden power outage.',
                            'The store close early because of a sudden power outage.',
                            'The store closes early because of a sudden power outage.',
                            'The store was closed early because of a sudden power outage.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'closed\' (V2 dari \'close\') menyatakan tindakan penutupan yang dilakukan toko itu sendiri di masa lampau.',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Kandidat itu mempersiapkan diri untuk wawancara selama dua minggu penuh.',
                        'target_word' => 'prepared',
                        'vocab' => [
                            'the candidate' => ['id' => 'kandidat itu', 'pos' => '(n)'],
                            'prepared' => ['id' => 'mempersiapkan diri', 'pos' => '(v2)'],
                            'for the interview' => ['id' => 'untuk wawancara', 'pos' => '(prep phr)'],
                            'for two full weeks' => ['id' => 'selama dua minggu penuh', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The candidate prepared for the interview for two full weeks.',
                            'The candidate prepares for the interview for two full weeks.',
                            'The candidate prepare for the interview for two full weeks.',
                            'The candidate was prepared for the interview for two full weeks.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Prepared\' adalah bentuk V2 lampau aktif yang benar; subjek sendiri melakukan persiapan.',
                    ],
                ],
            ],
            [
                'id' => 'past_verbal_irregular',
                'name' => 'Simple Past Verbal: Irregular Verbs (Subject + Irregular V2)',
                'code' => '1.8.2',
                'concept_title' => 'Simple Past Verbal: Irregular Verbs (Subject + Irregular V2)',
                'concept_description' => 'Kata kerja tak beraturan (Irregular Verbs) tidak menggunakan akhiran \'-ed\' untuk membentuk masa lampau (V2), melainkan mengalami perubahan ejaan internal (misal: find -> found, grow -> grew, take -> took, go -> went, rise -> rose). Kata-kata ini sangat sering dipakai dalam konteks kerja dan kehidupan profesional, jadi penting untuk dihafal.',
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
                        'id_sentence' => 'Auditor menemukan beberapa ketidaksesuaian dalam laporan keuangan.',
                        'target_word' => 'found',
                        'vocab' => [
                            'the auditor' => ['id' => 'auditor', 'pos' => '(n)'],
                            'found' => ['id' => 'menemukan', 'pos' => '(v2 irregular)'],
                            'several discrepancies' => ['id' => 'beberapa ketidaksesuaian', 'pos' => '(n phr)'],
                            'in the financial report' => ['id' => 'dalam laporan keuangan', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The auditor found several discrepancies in the financial report.',
                            'The auditor finded several discrepancies in the financial report.',
                            'The auditor find several discrepancies in the financial report.',
                            'The auditor was found several discrepancies in the financial report.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'find\' adalah \'found\', bukan \'finded\'.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Permintaan terhadap produk itu tumbuh dengan sangat cepat tahun ini.',
                        'target_word' => 'grew',
                        'vocab' => [
                            'demand for the product' => ['id' => 'permintaan terhadap produk itu', 'pos' => '(n phr)'],
                            'grew very fast' => ['id' => 'tumbuh dengan sangat cepat', 'pos' => '(v phr)'],
                            'this year' => ['id' => 'tahun ini', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'Demand for the product grew very fast this year.',
                            'Demand for the product growed very fast this year.',
                            'Demand for the product grow very fast this year.',
                            'Demand for the product was grew very fast this year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'grow\' adalah \'grew\', bukan \'growed\'.',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Perjalanan bisnis ke cabang kedua memakan waktu empat jam dengan pesawat.',
                        'target_word' => 'took',
                        'vocab' => [
                            'the business trip to the second branch' => ['id' => 'perjalanan bisnis ke cabang kedua', 'pos' => '(n phr)'],
                            'took four hours' => ['id' => 'memakan waktu empat jam', 'pos' => '(v phr)'],
                            'by plane' => ['id' => 'dengan pesawat', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The business trip to the second branch took four hours by plane.',
                            'The business trip to the second branch taked four hours by plane.',
                            'The business trip to the second branch take four hours by plane.',
                            'The business trip to the second branch was took four hours by plane.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'take\' adalah \'took\'.',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Kami pergi ke konferensi tahunan bersama seluruh anggota divisi.',
                        'target_word' => 'went',
                        'vocab' => [
                            'we' => ['id' => 'kami', 'pos' => '(pron)'],
                            'went' => ['id' => 'pergi', 'pos' => '(v2 irregular)'],
                            'to the annual conference' => ['id' => 'ke konferensi tahunan', 'pos' => '(prep phr)'],
                            'with the entire division' => ['id' => 'bersama seluruh anggota divisi', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'We went to the annual conference with the entire division.',
                            'We goed to the annual conference with the entire division.',
                            'We go to the annual conference with the entire division.',
                            'We was went to the annual conference with the entire division.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'go\' adalah \'went\'.',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Biaya operasional naik secara signifikan karena kenaikan harga bahan bakar.',
                        'target_word' => 'rose',
                        'vocab' => [
                            'operational costs' => ['id' => 'biaya operasional', 'pos' => '(n pl)'],
                            'rose significantly' => ['id' => 'naik secara signifikan', 'pos' => '(v phr)'],
                            'due to rising fuel prices' => ['id' => 'karena kenaikan harga bahan bakar', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'Operational costs rose significantly due to rising fuel prices.',
                            'Operational costs rised significantly due to rising fuel prices.',
                            'Operational costs rise significantly due to rising fuel prices.',
                            'Operational costs was rose significantly due to rising fuel prices.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'rise\' (naik) adalah \'rose\', bukan \'rised\'.',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Atmosfer rapat itu menjadi sangat tegang setelah angka penjualan diumumkan.',
                        'target_word' => 'became',
                        'vocab' => [
                            'the atmosphere of the meeting' => ['id' => 'atmosfer rapat itu', 'pos' => '(n sg)'],
                            'became very tense' => ['id' => 'menjadi sangat tegang', 'pos' => '(v phr)'],
                            'after the sales figures were announced' => ['id' => 'setelah angka penjualan diumumkan', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'The atmosphere of the meeting became very tense after the sales figures were announced.',
                            'The atmosphere of the meeting becomed very tense after the sales figures were announced.',
                            'The atmosphere of the meeting become very tense after the sales figures were announced.',
                            'The atmosphere of the meeting was became very tense after the sales figures were announced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'become\' adalah \'became\'.',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Pembicara menunjukkan data yang mirip dengan temuan di konferensi sebelumnya.',
                        'target_word' => 'showed',
                        'vocab' => [
                            'the speaker' => ['id' => 'pembicara', 'pos' => '(n)'],
                            'showed' => ['id' => 'menunjukkan', 'pos' => '(v2)'],
                            'data similar to' => ['id' => 'data yang mirip dengan', 'pos' => '(adj phr)'],
                            'the findings at the previous conference' => ['id' => 'temuan di konferensi sebelumnya', 'pos' => '(n phr)'],
                        ],
                        'options' => [
                            'The speaker showed data similar to the findings at the previous conference.',
                            'The speaker was showed data similar to the findings at the previous conference.',
                            'The speaker shown data similar to the findings at the previous conference.',
                            'The speaker shows data similar to the findings at the previous conference.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'showed\' adalah V2 aktif. Hindari kesalahan lazim \'was showed\'.',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Sesi pelatihan dimulai tepat pada pukul sembilan pagi.',
                        'target_word' => 'began',
                        'vocab' => [
                            'the training session' => ['id' => 'sesi pelatihan', 'pos' => '(n phr)'],
                            'began' => ['id' => 'dimulai', 'pos' => '(v2 irregular)'],
                            'exactly at nine in the morning' => ['id' => 'tepat pada pukul sembilan pagi', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The training session began exactly at nine in the morning.',
                            'The training session begined exactly at nine in the morning.',
                            'The training session begun exactly at nine in the morning.',
                            'The training session was began exactly at nine in the morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'begin\' adalah \'began\'. (\'begun\' adalah V3).',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Penundaan pengiriman menyebabkan keterlambatan di beberapa toko cabang.',
                        'target_word' => 'led to',
                        'vocab' => [
                            'the shipment delay' => ['id' => 'penundaan pengiriman', 'pos' => '(n phr)'],
                            'led to' => ['id' => 'menyebabkan / berujung pada', 'pos' => '(v phr)'],
                            'delays at several branch stores' => ['id' => 'keterlambatan di beberapa toko cabang', 'pos' => '(n phr)'],
                        ],
                        'options' => [
                            'The shipment delay led to delays at several branch stores.',
                            'The shipment delay leaded to delays at several branch stores.',
                            'The shipment delay lead to delays at several branch stores.',
                            'The shipment delay was led to delays at several branch stores.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'lead to\' adalah \'led to\'.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Panel seleksi memilih tiga kandidat terbaik untuk tahap wawancara akhir.',
                        'target_word' => 'chose',
                        'vocab' => [
                            'the selection panel' => ['id' => 'panel seleksi', 'pos' => '(n)'],
                            'chose' => ['id' => 'memilih', 'pos' => '(v2 irregular)'],
                            'the three best candidates' => ['id' => 'tiga kandidat terbaik', 'pos' => '(n phr)'],
                            'for the final interview stage' => ['id' => 'untuk tahap wawancara akhir', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The selection panel chose the three best candidates for the final interview stage.',
                            'The selection panel choosed the three best candidates for the final interview stage.',
                            'The selection panel choose the three best candidates for the final interview stage.',
                            'The selection panel was chose the three best candidates for the final interview stage.',
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
                    'Gunakan \'was\' untuk subjek tunggal: I, He, She, It, the proposal, the meeting, the traffic.',
                    'Gunakan \'were\' untuk subjek jamak: We, They, the negotiations, the results, our clients.',
                    'Komplemen dapat berupa: Kata Sifat (was effective), Kata Benda (was a turning point), atau Frasa Preposisi (were in the boardroom).',
                    'Dilarang meletakkan kata kerja V1 setelah was/were dalam kalimat nominal (misal: \'The plan was succeed\' ➔ SALAH; \'The plan was successful\' ➔ BENAR).',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Saya sangat lega ketika mendengar bahwa kontrak itu disetujui.',
                        'target_word' => 'was very relieved',
                        'vocab' => [
                            'I' => ['id' => 'saya', 'pos' => '(pron)'],
                            'was very relieved' => ['id' => 'sangat lega', 'pos' => '(phr)'],
                            'when I heard that the contract was approved' => ['id' => 'ketika mendengar bahwa kontrak itu disetujui', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'I was very relieved when I heard that the contract was approved.',
                            'I were very relieved when I heard that the contract was approved.',
                            'I am very relieved when I heard that the contract was approved.',
                            'I was very relief when I heard that the contract was approved.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'I\' menggunakan \'was\' + kata sifat \'relieved\'.',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Presentasi kuartalan itu sangat meyakinkan malam ini.',
                        'target_word' => 'was very convincing',
                        'vocab' => [
                            'the quarterly presentation' => ['id' => 'presentasi kuartalan itu', 'pos' => '(n sg)'],
                            'was very convincing' => ['id' => 'sangat meyakinkan', 'pos' => '(phr)'],
                            'tonight' => ['id' => 'malam ini', 'pos' => '(time adv)'],
                        ],
                        'options' => [
                            'The quarterly presentation was very convincing tonight.',
                            'The quarterly presentation were very convincing tonight.',
                            'The quarterly presentation was very convincingly tonight.',
                            'The quarterly presentation did very convincing tonight.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'presentation\' menggunakan \'was\' + adjective \'convincing\'.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Negosiasi dengan pemasok sangat alot pada pagi hari libur itu.',
                        'target_word' => 'were very difficult',
                        'vocab' => [
                            'the negotiations with the supplier' => ['id' => 'negosiasi dengan pemasok', 'pos' => '(n pl)'],
                            'were very difficult' => ['id' => 'sangat alot', 'pos' => '(phr)'],
                            'on that holiday morning' => ['id' => 'pada pagi hari libur itu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The negotiations with the supplier were very difficult on that holiday morning.',
                            'The negotiations with the supplier was very difficult on that holiday morning.',
                            'The negotiations with the supplier are very difficult on that holiday morning.',
                            'The negotiations with the supplier were very difficultly on that holiday morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek adalah jamak (\'The negotiations\'), sehingga kata kerja bantu lampau yang wajib digunakan adalah \'were\'. Diikuti kata sifat \'difficult\'.',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Ayah saya adalah seorang manajer produksi di pabrik itu dulu.',
                        'target_word' => 'was a production manager',
                        'vocab' => [
                            'my father' => ['id' => 'ayah saya', 'pos' => '(n)'],
                            'was a production manager' => ['id' => 'adalah seorang manajer produksi', 'pos' => '(phr)'],
                            'at that factory' => ['id' => 'di pabrik itu', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'My father was a production manager at that factory.',
                            'My father were a production manager at that factory.',
                            'My father is a production manager at that factory before.',
                            'My father was managing production at that factory.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'my father\' menggunakan \'was\' + frasa nomina komplemen \'a production manager\'.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Semua klien berada di ruang rapat ketika proyektor tiba-tiba mati.',
                        'target_word' => 'were in the meeting room',
                        'vocab' => [
                            'all the clients' => ['id' => 'semua klien', 'pos' => '(n pl)'],
                            'were in the meeting room' => ['id' => 'berada di ruang rapat', 'pos' => '(phr)'],
                            'when the projector suddenly shut off' => ['id' => 'ketika proyektor tiba-tiba mati', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'All the clients were in the meeting room when the projector suddenly shut off.',
                            'All the clients was in the meeting room when the projector suddenly shut off.',
                            'All the clients did in the meeting room when the projector suddenly shut off.',
                            'All the clients were meeting room when the projector suddenly shut off.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'clients\' menggunakan \'were\' + frasa preposisi \'in the meeting room\'.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Proposal yang kami ajukan minggu lalu sangat rinci.',
                        'target_word' => 'was very detailed',
                        'vocab' => [
                            'the proposal we submitted last week' => ['id' => 'proposal yang kami ajukan minggu lalu', 'pos' => '(n sg)'],
                            'was very detailed' => ['id' => 'sangat rinci', 'pos' => '(phr)'],
                        ],
                        'options' => [
                            'The proposal we submitted last week was very detailed.',
                            'The proposal we submitted last week were very detailed.',
                            'The proposal we submitted last week is very detailed.',
                            'The proposal we submitted last week was very detail.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The proposal\' tunggal, sehingga memerlukan kata kerja bantu \'was\' + adjective \'detailed\'.',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Harga bahan baku sangat mahal di pasar kuartal ini.',
                        'target_word' => 'were very expensive',
                        'vocab' => [
                            'the prices of raw materials' => ['id' => 'harga bahan baku', 'pos' => '(n pl)'],
                            'on the market' => ['id' => 'di pasar', 'pos' => '(prep phr)'],
                            'were very expensive' => ['id' => 'sangat mahal', 'pos' => '(phr)'],
                            'this quarter' => ['id' => 'kuartal ini', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The prices of raw materials on the market were very expensive this quarter.',
                            'The prices of raw materials on the market was very expensive this quarter.',
                            'The prices of raw materials on the market did very expensive this quarter.',
                            'The prices of raw materials on the market were very expense this quarter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'prices\' menggunakan \'were\' + adjective \'expensive\'.',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Semua dokumen tersusun rapi di map sebelum audit dimulai.',
                        'target_word' => 'were neatly arranged',
                        'vocab' => [
                            'all the documents' => ['id' => 'semua dokumen', 'pos' => '(n pl)'],
                            'were neatly arranged' => ['id' => 'tersusun rapi', 'pos' => '(phr)'],
                            'in the folders' => ['id' => 'di map', 'pos' => '(prep phr)'],
                            'before the audit began' => ['id' => 'sebelum audit dimulai', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'All the documents were neatly arranged in the folders before the audit began.',
                            'All the documents was neatly arranged in the folders before the audit began.',
                            'All the documents did neatly arranged in the folders before the audit began.',
                            'All the documents were neat arranged in the folders before the audit began.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'documents\' menggunakan \'were\' + kata sifat \'arranged\'.',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Jaringan internet di kantor stabil dan cepat sebelum gangguan terjadi.',
                        'target_word' => 'was stable and fast',
                        'vocab' => [
                            'the office internet connection' => ['id' => 'jaringan internet di kantor', 'pos' => '(n sg)'],
                            'was stable and fast' => ['id' => 'stabil dan cepat', 'pos' => '(phr)'],
                            'before the outage happened' => ['id' => 'sebelum gangguan terjadi', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'The office internet connection was stable and fast before the outage happened.',
                            'The office internet connection were stable and fast before the outage happened.',
                            'The office internet connection did stable and fast before the outage happened.',
                            'The office internet connection was stably and fast before the outage happened.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The connection\' (tunggal) menggunakan \'was\' + pasangan kata sifat.',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Harga tiket konferensi sangat mahal tahun lalu.',
                        'target_word' => 'was very expensive',
                        'vocab' => [
                            'the price of the conference ticket' => ['id' => 'harga tiket konferensi', 'pos' => '(n sg)'],
                            'was very expensive' => ['id' => 'sangat mahal', 'pos' => '(phr)'],
                            'last year' => ['id' => 'tahun lalu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The price of the conference ticket was very expensive last year.',
                            'The price of the conference ticket were very expensive last year.',
                            'The price of the conference ticket did very expensive last year.',
                            'The price of the conference ticket was very expensively last year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The price\' tunggal, menggunakan \'was\' + adjective \'expensive\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_passive',
                'name' => 'Simple Past Passive: Professional Events (was / were + V3)',
                'code' => '1.8.4',
                'concept_title' => 'Simple Past Passive: Professional Events (was / were + V3)',
                'concept_description' => 'Kalimat pasif lampau (Simple Past Passive) digunakan ketika kita ingin memfokuskan kalimat pada benda atau orang yang menerima tindakan, bukan pada siapa yang melakukannya. Sering dipakai dalam laporan kerja dan komunikasi profesional, misalnya untuk menjelaskan apa yang "terjadi pada" sebuah dokumen, proyek, atau keputusan.',
                'formula' => 'Subject (Penerima Tindakan) + WAS / WERE + Verb 3 (Past Participle) + (by Pelaku) + (Konteks)',
                'rules' => [
                    'Gunakan \'was + V3\' jika subjek penerima tindakan adalah tunggal (the contract was signed, the budget was approved).',
                    'Gunakan \'were + V3\' jika subjek penerima tindakan adalah jamak (the invoices were processed, the applicants were interviewed).',
                    'Verba setelah was/were WAJIB berbentuk Past Participle (V3), bukan V1 atau V2 murni.',
                    'Frasa pelaku (\'by the finance team\') boleh ditambahkan atau dihilangkan, tergantung apakah pelakunya penting untuk disebutkan.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Kontrak itu ditandatangani oleh kedua belah pihak minggu ini.',
                        'target_word' => 'was signed',
                        'vocab' => [
                            'the contract' => ['id' => 'kontrak itu', 'pos' => '(n sg)'],
                            'was signed' => ['id' => 'ditandatangani', 'pos' => '(v passive)'],
                            'by both parties' => ['id' => 'oleh kedua belah pihak', 'pos' => '(prep phr)'],
                            'this week' => ['id' => 'minggu ini', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The contract was signed by both parties this week.',
                            'The contract were signed by both parties this week.',
                            'The contract signed by both parties this week.',
                            'The contract was sign by both parties this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'contract\' dipadukan dengan pasif lampau: \'was signed\' (was + V3).',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Anggaran tahunan disetujui oleh dewan direksi pekan lalu.',
                        'target_word' => 'was approved',
                        'vocab' => [
                            'the annual budget' => ['id' => 'anggaran tahunan', 'pos' => '(n sg)'],
                            'was approved' => ['id' => 'disetujui', 'pos' => '(v passive)'],
                            'by the board of directors' => ['id' => 'oleh dewan direksi', 'pos' => '(prep phr)'],
                            'last week' => ['id' => 'pekan lalu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The annual budget was approved by the board of directors last week.',
                            'The annual budget were approved by the board of directors last week.',
                            'The annual budget approved by the board of directors last week.',
                            'The annual budget was approve by the board of directors last week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The budget\' menggunakan \'was approved\' (was + V3).',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Para pelamar diwawancarai secara daring selama dua hari berturut-turut.',
                        'target_word' => 'were interviewed',
                        'vocab' => [
                            'the applicants' => ['id' => 'para pelamar', 'pos' => '(n pl)'],
                            'were interviewed' => ['id' => 'diwawancarai', 'pos' => '(v passive)'],
                            'online' => ['id' => 'secara daring', 'pos' => '(adv)'],
                            'for two consecutive days' => ['id' => 'selama dua hari berturut-turut', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The applicants were interviewed online for two consecutive days.',
                            'The applicants was interviewed online for two consecutive days.',
                            'The applicants interviewed online for two consecutive days.',
                            'The applicants were interview online for two consecutive days.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'were interviewed\' adalah kalimat pasif lampau untuk subjek jamak \'the applicants\'.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Semua faktur diproses dan diarsipkan ke dalam sistem.',
                        'target_word' => 'were processed',
                        'vocab' => [
                            'all the invoices' => ['id' => 'semua faktur', 'pos' => '(n pl)'],
                            'were processed' => ['id' => 'diproses', 'pos' => '(v passive)'],
                            'and filed into the system' => ['id' => 'dan diarsipkan ke dalam sistem', 'pos' => '(v phr)'],
                        ],
                        'options' => [
                            'All the invoices were processed and filed into the system.',
                            'All the invoices was processed and filed into the system.',
                            'All the invoices processed and filed into the system.',
                            'All the invoices were process and filed into the system.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola pasif lampau: \'were processed\' (were + V3).',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Laptop itu dipinjamkan kepada saya oleh departemen IT minggu lalu.',
                        'target_word' => 'was lent',
                        'vocab' => [
                            'the laptop' => ['id' => 'laptop itu', 'pos' => '(n sg)'],
                            'was lent to me' => ['id' => 'dipinjamkan kepada saya', 'pos' => '(v passive phr)'],
                            'by the IT department' => ['id' => 'oleh departemen IT', 'pos' => '(prep phr)'],
                            'last week' => ['id' => 'minggu lalu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The laptop was lent to me by the IT department last week.',
                            'The laptop were lent to me by the IT department last week.',
                            'The laptop lent to me by the IT department last week.',
                            'The laptop was lend to me by the IT department last week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The laptop\' tunggal, menggunakan \'was lent\'.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Masalah pada sistem pembayaran ditemukan oleh tim keamanan siber.',
                        'target_word' => 'was found',
                        'vocab' => [
                            'the problem with the payment system' => ['id' => 'masalah pada sistem pembayaran', 'pos' => '(n sg)'],
                            'was found' => ['id' => 'ditemukan', 'pos' => '(v passive)'],
                            'by the cybersecurity team' => ['id' => 'oleh tim keamanan siber', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The problem with the payment system was found by the cybersecurity team.',
                            'The problem with the payment system were found by the cybersecurity team.',
                            'The problem with the payment system found by the cybersecurity team.',
                            'The problem with the payment system was find by the cybersecurity team.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'was found\' (was + V3) secara tepat memaparkan hasil penemuan masalah tersebut.',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Semua surel balasan ditulis dengan nada profesional oleh asisten saya.',
                        'target_word' => 'were written',
                        'vocab' => [
                            'all the reply emails' => ['id' => 'semua surel balasan', 'pos' => '(n pl)'],
                            'were written in a professional tone' => ['id' => 'ditulis dengan nada profesional', 'pos' => '(v passive phr)'],
                            'by my assistant' => ['id' => 'oleh asisten saya', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'All the reply emails were written in a professional tone by my assistant.',
                            'All the reply emails was written in a professional tone by my assistant.',
                            'All the reply emails written in a professional tone by my assistant.',
                            'All the reply emails were write in a professional tone by my assistant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'emails\' menggunakan \'were written\' (were + V3).',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Konferensi pers itu dibatalkan karena cuaca buruk.',
                        'target_word' => 'was canceled',
                        'vocab' => [
                            'the press conference' => ['id' => 'konferensi pers itu', 'pos' => '(n sg)'],
                            'was canceled' => ['id' => 'dibatalkan', 'pos' => '(v passive)'],
                            'due to bad weather' => ['id' => 'karena cuaca buruk', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The press conference was canceled due to bad weather.',
                            'The press conference were canceled due to bad weather.',
                            'The press conference canceled due to bad weather.',
                            'The press conference was cancel due to bad weather.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'conference\' menggunakan \'was canceled\' (was + V3).',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Semua karyawan baru diperkenalkan kepada tim mereka pada hari pertama.',
                        'target_word' => 'were introduced',
                        'vocab' => [
                            'all the new employees' => ['id' => 'semua karyawan baru', 'pos' => '(n pl)'],
                            'were introduced to their teams' => ['id' => 'diperkenalkan kepada tim mereka', 'pos' => '(v passive phr)'],
                            'on the first day' => ['id' => 'pada hari pertama', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'All the new employees were introduced to their teams on the first day.',
                            'All the new employees was introduced to their teams on the first day.',
                            'All the new employees introduced to their teams on the first day.',
                            'All the new employees were introduce to their teams on the first day.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'employees\' menggunakan \'were introduced\' (were + V3).',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Situs web perusahaan diperbarui sepenuhnya selama akhir pekan.',
                        'target_word' => 'was updated',
                        'vocab' => [
                            'the company website' => ['id' => 'situs web perusahaan', 'pos' => '(n sg)'],
                            'was fully updated' => ['id' => 'diperbarui sepenuhnya', 'pos' => '(v passive phr)'],
                            'over the weekend' => ['id' => 'selama akhir pekan', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The company website was fully updated over the weekend.',
                            'The company website were fully updated over the weekend.',
                            'The company website fully updated over the weekend.',
                            'The company website was fully update over the weekend.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'website\' menggunakan \'was updated\' (was + V3).',
                    ],
                ],
            ],
            [
                'id' => 'past_trifecta',
                'name' => 'Trifecta Comparison: Verbal vs Nominal vs Pasif Masa Lampau',
                'code' => '1.8.5',
                'concept_title' => 'Trifecta Comparison: Verbal vs Nominal vs Pasif Masa Lampau',
                'concept_description' => 'Sub-lesson ini melatih kemampuan membedakan secara cepat kapan sebuah kalimat lampau membutuhkan bentuk Verbal (V2), Nominal (was/were + complement), atau Pasif (was/were + V3) berdasarkan konteks kalimat bahasa Indonesia.',
                'formula' => 'Verbal: S + V2 | Nominal: S + was/were + Adj/Noun | Pasif: S + was/were + V3',
                'rules' => [
                    'Jika subjek MELAKUKAN tindakan secara aktif, gunakan Verbal (V2).',
                    'Jika predikat menerangkan KONDISI atau SIFAT subjek (bukan tindakan), gunakan Nominal (was/were + complement).',
                    'Jika subjek MENERIMA tindakan dari pihak lain, gunakan Pasif (was/were + V3).',
                    'Perhatikan kata kerja dalam kalimat Indonesia: kata "di-" biasanya menandakan pasif, sedangkan "me-" biasanya menandakan aktif.',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Tim produk merilis pembaruan aplikasi pada hari Senin.',
                        'target_word' => 'released',
                        'vocab' => [
                            'the product team' => ['id' => 'tim produk', 'pos' => '(n)'],
                            'released' => ['id' => 'merilis', 'pos' => '(v2)'],
                            'the app update' => ['id' => 'pembaruan aplikasi', 'pos' => '(n phr)'],
                            'on Monday' => ['id' => 'pada hari Senin', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The product team released the app update on Monday.',
                            'The product team was released the app update on Monday.',
                            'The product team were released the app update on Monday.',
                            'The product team was release the app update on Monday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek melakukan tindakan aktif, sehingga gunakan Verbal V2 \'released\', bukan pasif.',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Pembaruan aplikasi itu dirilis oleh tim produk pada hari Senin.',
                        'target_word' => 'was released',
                        'vocab' => [
                            'the app update' => ['id' => 'pembaruan aplikasi itu', 'pos' => '(n sg)'],
                            'was released' => ['id' => 'dirilis', 'pos' => '(v passive)'],
                            'by the product team' => ['id' => 'oleh tim produk', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The app update was released by the product team on Monday.',
                            'The app update released by the product team on Monday.',
                            'The app update were released by the product team on Monday.',
                            'The app update was release by the product team on Monday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek menerima tindakan, sehingga gunakan Pasif \'was released\' (was + V3).',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Rapat evaluasi itu sangat produktif kemarin.',
                        'target_word' => 'was very productive',
                        'vocab' => [
                            'the evaluation meeting' => ['id' => 'rapat evaluasi itu', 'pos' => '(n sg)'],
                            'was very productive' => ['id' => 'sangat produktif', 'pos' => '(phr)'],
                            'yesterday' => ['id' => 'kemarin', 'pos' => '(time adv)'],
                        ],
                        'options' => [
                            'The evaluation meeting was very productive yesterday.',
                            'The evaluation meeting produced very productive yesterday.',
                            'The evaluation meeting were very productive yesterday.',
                            'The evaluation meeting was productively yesterday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat menerangkan kondisi (bukan tindakan), gunakan Nominal \'was productive\'.',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Vendor baru mengirimkan sampel produk minggu lalu.',
                        'target_word' => 'sent',
                        'vocab' => [
                            'the new vendor' => ['id' => 'vendor baru', 'pos' => '(n)'],
                            'sent' => ['id' => 'mengirimkan', 'pos' => '(v2 irregular)'],
                            'product samples' => ['id' => 'sampel produk', 'pos' => '(n phr)'],
                        ],
                        'options' => [
                            'The new vendor sent product samples last week.',
                            'The new vendor was sent product samples last week.',
                            'The new vendor were sent product samples last week.',
                            'The new vendor was send product samples last week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'vendor\' secara aktif mengirim, gunakan Verbal V2 \'sent\'.',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Sampel produk itu dikirimkan oleh vendor baru minggu lalu.',
                        'target_word' => 'were sent',
                        'vocab' => [
                            'the product samples' => ['id' => 'sampel produk itu', 'pos' => '(n pl)'],
                            'were sent' => ['id' => 'dikirimkan', 'pos' => '(v passive)'],
                            'by the new vendor' => ['id' => 'oleh vendor baru', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The product samples were sent by the new vendor last week.',
                            'The product samples was sent by the new vendor last week.',
                            'The product samples sent by the new vendor last week.',
                            'The product samples were send by the new vendor last week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'samples\' (jamak) menerima tindakan, gunakan Pasif \'were sent\' (were + V3).',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Para peserta pelatihan sangat antusias sepanjang hari.',
                        'target_word' => 'were very enthusiastic',
                        'vocab' => [
                            'the training participants' => ['id' => 'para peserta pelatihan', 'pos' => '(n pl)'],
                            'were very enthusiastic' => ['id' => 'sangat antusias', 'pos' => '(phr)'],
                            'throughout the day' => ['id' => 'sepanjang hari', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The training participants were very enthusiastic throughout the day.',
                            'The training participants was very enthusiastic throughout the day.',
                            'The training participants enthused very enthusiastic throughout the day.',
                            'The training participants were enthusiastically throughout the day.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Menerangkan kondisi subjek jamak, gunakan Nominal \'were enthusiastic\'.',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Konsultan eksternal meninjau seluruh prosedur keselamatan.',
                        'target_word' => 'reviewed',
                        'vocab' => [
                            'the external consultant' => ['id' => 'konsultan eksternal', 'pos' => '(n)'],
                            'reviewed' => ['id' => 'meninjau', 'pos' => '(v2)'],
                            'the entire safety procedure' => ['id' => 'seluruh prosedur keselamatan', 'pos' => '(n phr)'],
                        ],
                        'options' => [
                            'The external consultant reviewed the entire safety procedure.',
                            'The external consultant was reviewed the entire safety procedure.',
                            'The external consultant were reviewed the entire safety procedure.',
                            'The external consultant was review the entire safety procedure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'consultant\' secara aktif meninjau, gunakan Verbal V2 \'reviewed\'.',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Prosedur keselamatan itu ditinjau oleh konsultan eksternal.',
                        'target_word' => 'was reviewed',
                        'vocab' => [
                            'the safety procedure' => ['id' => 'prosedur keselamatan itu', 'pos' => '(n sg)'],
                            'was reviewed' => ['id' => 'ditinjau', 'pos' => '(v passive)'],
                            'by the external consultant' => ['id' => 'oleh konsultan eksternal', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The safety procedure was reviewed by the external consultant.',
                            'The safety procedure were reviewed by the external consultant.',
                            'The safety procedure reviewed by the external consultant.',
                            'The safety procedure was review by the external consultant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'procedure\' menerima tindakan, gunakan Pasif \'was reviewed\' (was + V3).',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Jadwal penerbangan kami sangat padat selama perjalanan dinas itu.',
                        'target_word' => 'was very tight',
                        'vocab' => [
                            'our flight schedule' => ['id' => 'jadwal penerbangan kami', 'pos' => '(n sg)'],
                            'was very tight' => ['id' => 'sangat padat', 'pos' => '(phr)'],
                            'during that business trip' => ['id' => 'selama perjalanan dinas itu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'Our flight schedule was very tight during that business trip.',
                            'Our flight schedule were very tight during that business trip.',
                            'Our flight schedule tightened very tight during that business trip.',
                            'Our flight schedule was very tightly during that business trip.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Menerangkan kondisi subjek tunggal, gunakan Nominal \'was tight\'.',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Hasil evaluasi kinerja dibagikan kepada setiap karyawan secara pribadi.',
                        'target_word' => 'were shared',
                        'vocab' => [
                            'the performance review results' => ['id' => 'hasil evaluasi kinerja', 'pos' => '(n pl)'],
                            'were shared' => ['id' => 'dibagikan', 'pos' => '(v passive)'],
                            'with each employee privately' => ['id' => 'kepada setiap karyawan secara pribadi', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The performance review results were shared with each employee privately.',
                            'The performance review results was shared with each employee privately.',
                            'The performance review results shared with each employee privately.',
                            'The performance review results were share with each employee privately.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'results\' (jamak) menerima tindakan, gunakan Pasif \'were shared\' (were + V3).',
                    ],
                ],
            ],
            [
                'id' => 'past_negative_interrogative',
                'name' => 'Simple Past Negative & Interrogative (did not + V1, was/were not)',
                'code' => '1.8.6',
                'concept_title' => 'Simple Past Negative & Interrogative (did not + V1, was/were not)',
                'concept_description' => 'Kalimat negatif verbal lampau dibentuk dengan \'did not\' + V1 (bentuk dasar, bukan V2). Kalimat negatif nominal/pasif menggunakan \'was/were not\'. Kalimat tanya verbal menggunakan \'Did\' di awal kalimat, sedangkan kalimat tanya nominal/pasif menggunakan \'Was/Were\'.',
                'formula' => 'Negative Verbal: S + DID NOT + V1 | Negative Nominal/Passive: S + WAS/WERE NOT + Adj/V3 | Question: DID + S + V1...? / WAS/WERE + S...?',
                'rules' => [
                    'Setelah \'did not\', kata kerja WAJIB kembali ke bentuk dasar V1 (did not submit, bukan did not submitted).',
                    'Kalimat tanya verbal: letakkan \'Did\' di awal kalimat, diikuti subjek, lalu V1.',
                    'Kalimat tanya nominal/pasif: letakkan \'Was/Were\' di awal kalimat, diikuti subjek, lalu complement/V3.',
                    'Pilih \'Was\' untuk subjek tunggal dan \'Were\' untuk subjek jamak, baik dalam kalimat negatif maupun tanya.',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Pemasok tidak mengirimkan bahan baku tepat waktu minggu ini.',
                        'target_word' => 'did not deliver',
                        'vocab' => [
                            'the supplier' => ['id' => 'pemasok', 'pos' => '(n)'],
                            'did not deliver' => ['id' => 'tidak mengirimkan', 'pos' => '(v phr)'],
                            'the raw materials on time' => ['id' => 'bahan baku tepat waktu', 'pos' => '(n phr)'],
                        ],
                        'options' => [
                            'The supplier did not deliver the raw materials on time this week.',
                            'The supplier did not delivered the raw materials on time this week.',
                            'The supplier does not deliver the raw materials on time this week.',
                            'The supplier was not deliver the raw materials on time this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah \'did not\', kata kerja kembali ke V1 \'deliver\', bukan V2 \'delivered\'.',
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Klien tidak menyetujui perubahan desain pada rapat terakhir.',
                        'target_word' => 'did not approve',
                        'vocab' => [
                            'the client' => ['id' => 'klien', 'pos' => '(n)'],
                            'did not approve' => ['id' => 'tidak menyetujui', 'pos' => '(v phr)'],
                            'the design changes' => ['id' => 'perubahan desain', 'pos' => '(n phr)'],
                            'at the last meeting' => ['id' => 'pada rapat terakhir', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The client did not approve the design changes at the last meeting.',
                            'The client did not approved the design changes at the last meeting.',
                            'The client does not approve the design changes at the last meeting.',
                            'The client was not approve the design changes at the last meeting.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Verba utama kembali ke bentuk dasar \'approve\' setelah \'did not\'.',
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Apakah tim keuangan sudah menyelesaikan laporan tahunan itu?',
                        'target_word' => 'Did the finance team finish',
                        'vocab' => [
                            'did' => ['id' => 'kata bantu tanya lampau', 'pos' => '(aux)'],
                            'the finance team' => ['id' => 'tim keuangan', 'pos' => '(n)'],
                            'finish' => ['id' => 'menyelesaikan', 'pos' => '(v1)'],
                            'the annual report' => ['id' => 'laporan tahunan itu', 'pos' => '(n phr)'],
                        ],
                        'options' => [
                            'Did the finance team finish the annual report?',
                            'Did the finance team finished the annual report?',
                            'Does the finance team finish the annual report?',
                            'Was the finance team finish the annual report?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pertanyaan verbal lampau diawali \'Did\' + subjek + V1 \'finish\'.',
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Apakah laporan tahunan itu diselesaikan sebelum tenggat waktu?',
                        'target_word' => 'Was the annual report finished',
                        'vocab' => [
                            'was' => ['id' => 'kata bantu tanya lampau (pasif/nominal)', 'pos' => '(aux)'],
                            'the annual report' => ['id' => 'laporan tahunan itu', 'pos' => '(n sg)'],
                            'finished' => ['id' => 'diselesaikan', 'pos' => '(v3)'],
                            'before the deadline' => ['id' => 'sebelum tenggat waktu', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'Was the annual report finished before the deadline?',
                            'Did the annual report finished before the deadline?',
                            'Were the annual report finished before the deadline?',
                            'Was the annual report finish before the deadline?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pertanyaan pasif lampau diawali \'Was\' (subjek tunggal) + subjek + V3 \'finished\'.',
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Ruang pertemuan itu tidak tersedia pada waktu yang kami minta.',
                        'target_word' => 'was not available',
                        'vocab' => [
                            'the meeting room' => ['id' => 'ruang pertemuan itu', 'pos' => '(n sg)'],
                            'was not available' => ['id' => 'tidak tersedia', 'pos' => '(phr)'],
                            'at the time we requested' => ['id' => 'pada waktu yang kami minta', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'The meeting room was not available at the time we requested.',
                            'The meeting room did not available at the time we requested.',
                            'The meeting room were not available at the time we requested.',
                            'The meeting room not was available at the time we requested.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kondisi negatif subjek tunggal menggunakan \'was not\' + adjective.',
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Apakah para peserta mendapatkan materi sebelum sesi dimulai?',
                        'target_word' => 'Did the participants receive',
                        'vocab' => [
                            'the participants' => ['id' => 'para peserta', 'pos' => '(n pl)'],
                            'receive' => ['id' => 'mendapatkan', 'pos' => '(v1)'],
                            'the materials' => ['id' => 'materi', 'pos' => '(n phr)'],
                            'before the session began' => ['id' => 'sebelum sesi dimulai', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'Did the participants receive the materials before the session began?',
                            'Did the participants received the materials before the session began?',
                            'Were the participants receive the materials before the session began?',
                            'Does the participants receive the materials before the session began?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pertanyaan verbal lampau menggunakan \'Did\' + subjek jamak + V1 \'receive\'.',
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Para manajer tidak hadir pada acara tahunan tahun ini.',
                        'target_word' => 'were not present',
                        'vocab' => [
                            'the managers' => ['id' => 'para manajer', 'pos' => '(n pl)'],
                            'were not present' => ['id' => 'tidak hadir', 'pos' => '(phr)'],
                            'at this year\'s annual event' => ['id' => 'pada acara tahunan tahun ini', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The managers were not present at this year\'s annual event.',
                            'The managers was not present at this year\'s annual event.',
                            'The managers did not present at this year\'s annual event.',
                            'The managers not were present at this year\'s annual event.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kondisi negatif subjek jamak \'managers\' menggunakan \'were not\' + adjective.',
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Apakah keputusan akhir diumumkan sebelum rapat ditutup?',
                        'target_word' => 'Was the final decision announced',
                        'vocab' => [
                            'the final decision' => ['id' => 'keputusan akhir', 'pos' => '(n sg)'],
                            'announced' => ['id' => 'diumumkan', 'pos' => '(v3)'],
                            'before the meeting ended' => ['id' => 'sebelum rapat ditutup', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'Was the final decision announced before the meeting ended?',
                            'Did the final decision announced before the meeting ended?',
                            'Were the final decision announced before the meeting ended?',
                            'Was the final decision announce before the meeting ended?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pertanyaan pasif lampau dengan subjek tunggal \'decision\' menggunakan \'Was\' + V3 \'announced\'.',
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Tim pengembang tidak menguji fitur itu sebelum perilisan.',
                        'target_word' => 'did not test',
                        'vocab' => [
                            'the development team' => ['id' => 'tim pengembang', 'pos' => '(n)'],
                            'did not test' => ['id' => 'tidak menguji', 'pos' => '(v phr)'],
                            'that feature' => ['id' => 'fitur itu', 'pos' => '(n phr)'],
                            'before the release' => ['id' => 'sebelum perilisan', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The development team did not test that feature before the release.',
                            'The development team did not tested that feature before the release.',
                            'The development team does not test that feature before the release.',
                            'The development team was not test that feature before the release.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Verba utama kembali ke bentuk dasar \'test\' setelah \'did not\'.',
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah target penjualan kuartal lalu tercapai?',
                        'target_word' => 'Was last quarter\'s sales target achieved',
                        'vocab' => [
                            'last quarter\'s sales target' => ['id' => 'target penjualan kuartal lalu', 'pos' => '(n sg)'],
                            'achieved' => ['id' => 'tercapai', 'pos' => '(v3)'],
                        ],
                        'options' => [
                            'Was last quarter\'s sales target achieved?',
                            'Did last quarter\'s sales target achieved?',
                            'Were last quarter\'s sales target achieved?',
                            'Was last quarter\'s sales target achieve?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pertanyaan pasif lampau dengan subjek tunggal \'target\' menggunakan \'Was\' + V3 \'achieved\'.',
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
                        'id_sentence' => 'Tahun lalu, perusahaan kami pindah kantor ke gedung baru di pusat kota.',
                        'target_word' => 'Last year, our company moved',
                        'vocab' => [
                            'last year' => ['id' => 'tahun lalu', 'pos' => '(time phr)'],
                            'our company' => ['id' => 'perusahaan kami', 'pos' => '(n phr)'],
                            'moved offices' => ['id' => 'pindah kantor', 'pos' => '(v2 phr)'],
                            'to a new building downtown' => ['id' => 'ke gedung baru di pusat kota', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'Last year, our company moved offices to a new building downtown.',
                            'Last year, our company has moved offices to a new building downtown.',
                            'Last year our company moves offices to a new building downtown.',
                            'Last year, our company was moved offices to a new building downtown.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu pasti \'Last year,\' mewajibkan V2 lampau aktif \'moved\' (bukan present perfect \'has moved\'). Tanda koma wajib diletakkan setelah frasa pembuka waktu.',
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Pada tahun 2020, perusahaan merilis produk andalannya untuk pertama kali.',
                        'target_word' => 'In 2020, ... released',
                        'vocab' => [
                            'in 2020' => ['id' => 'pada tahun 2020', 'pos' => '(time phr)'],
                            'the company' => ['id' => 'perusahaan', 'pos' => '(n)'],
                            'released its flagship product' => ['id' => 'merilis produk andalannya', 'pos' => '(v phr)'],
                            'for the first time' => ['id' => 'untuk pertama kali', 'pos' => '(adv phr)'],
                        ],
                        'options' => [
                            'In 2020, the company released its flagship product for the first time.',
                            'In 2020, the company has released its flagship product for the first time.',
                            'In 2020, the company releases its flagship product for the first time.',
                            'In 2020, the company was released its flagship product for the first time.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu spesifik \'In 2020\' mewajibkan Simple Past \'released\', ditempatkan di awal kalimat untuk penekanan.',
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Kami menandatangani kesepakatan itu kemarin sore.',
                        'target_word' => 'signed ... yesterday afternoon',
                        'vocab' => [
                            'we' => ['id' => 'kami', 'pos' => '(pron)'],
                            'signed the agreement' => ['id' => 'menandatangani kesepakatan itu', 'pos' => '(v phr)'],
                            'yesterday afternoon' => ['id' => 'kemarin sore', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'We signed the agreement yesterday afternoon.',
                            'We have signed the agreement yesterday afternoon.',
                            'We sign the agreement yesterday afternoon.',
                            'We were signed the agreement yesterday afternoon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Yesterday afternoon\' adalah keterangan waktu lampau spesifik yang mewajibkan Simple Past \'signed\'.',
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Pada saat itu, biaya produksi masih cukup rendah.',
                        'target_word' => 'At that time, ... was',
                        'vocab' => [
                            'at that time' => ['id' => 'pada saat itu', 'pos' => '(time phr)'],
                            'production costs' => ['id' => 'biaya produksi', 'pos' => '(n pl)'],
                            'were still fairly low' => ['id' => 'masih cukup rendah', 'pos' => '(phr)'],
                        ],
                        'options' => [
                            'At that time, production costs were still fairly low.',
                            'At that time, production costs are still fairly low.',
                            'At that time, production costs has been still fairly low.',
                            'At that time, production costs did still fairly low.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa \'At that time\' menandakan konteks lampau spesifik, memerlukan \'were\' untuk subjek jamak \'costs\'.',
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Tim riset menyelesaikan prototipe itu tiga bulan lalu.',
                        'target_word' => 'completed ... three months ago',
                        'vocab' => [
                            'the research team' => ['id' => 'tim riset', 'pos' => '(n)'],
                            'completed the prototype' => ['id' => 'menyelesaikan prototipe itu', 'pos' => '(v phr)'],
                            'three months ago' => ['id' => 'tiga bulan lalu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'The research team completed the prototype three months ago.',
                            'The research team has completed the prototype three months ago.',
                            'The research team completes the prototype three months ago.',
                            'The research team was completed the prototype three months ago.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Three months ago\' tidak boleh dipakai bersama Present Perfect; gunakan Simple Past \'completed\'.',
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Minggu lalu, dua karyawan baru bergabung dengan tim pemasaran.',
                        'target_word' => 'Last week, ... joined',
                        'vocab' => [
                            'last week' => ['id' => 'minggu lalu', 'pos' => '(time phr)'],
                            'two new employees' => ['id' => 'dua karyawan baru', 'pos' => '(n phr)'],
                            'joined the marketing team' => ['id' => 'bergabung dengan tim pemasaran', 'pos' => '(v phr)'],
                        ],
                        'options' => [
                            'Last week, two new employees joined the marketing team.',
                            'Last week, two new employees have joined the marketing team.',
                            'Last week, two new employees join the marketing team.',
                            'Last week, two new employees were joined the marketing team.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Last week\' di awal kalimat diikuti koma, lalu subjek + Simple Past \'joined\'.',
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Pada masa itu, perusahaan belum memiliki kantor cabang di luar negeri.',
                        'target_word' => 'Back then, ... did not have',
                        'vocab' => [
                            'back then' => ['id' => 'pada masa itu', 'pos' => '(time phr)'],
                            'the company' => ['id' => 'perusahaan', 'pos' => '(n)'],
                            'did not have branch offices abroad' => ['id' => 'belum memiliki kantor cabang di luar negeri', 'pos' => '(v phr)'],
                        ],
                        'options' => [
                            'Back then, the company did not have branch offices abroad.',
                            'Back then, the company does not have branch offices abroad.',
                            'Back then, the company has not had branch offices abroad.',
                            'Back then, the company was not have branch offices abroad.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Back then\' menandakan konteks lampau, memerlukan \'did not have\' (V1 setelah did not).',
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Kami menerima tawaran kerja sama itu dua hari yang lalu.',
                        'target_word' => 'received ... two days ago',
                        'vocab' => [
                            'we' => ['id' => 'kami', 'pos' => '(pron)'],
                            'received the partnership offer' => ['id' => 'menerima tawaran kerja sama itu', 'pos' => '(v phr)'],
                            'two days ago' => ['id' => 'dua hari yang lalu', 'pos' => '(time phr)'],
                        ],
                        'options' => [
                            'We received the partnership offer two days ago.',
                            'We have received the partnership offer two days ago.',
                            'We receive the partnership offer two days ago.',
                            'We were received the partnership offer two days ago.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Two days ago\' tidak kompatibel dengan Present Perfect; gunakan Simple Past \'received\'.',
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Selama periode itu, harga saham mengalami fluktuasi tajam.',
                        'target_word' => 'During that period, ... experienced',
                        'vocab' => [
                            'during that period' => ['id' => 'selama periode itu', 'pos' => '(time phr)'],
                            'the stock price' => ['id' => 'harga saham', 'pos' => '(n sg)'],
                            'experienced sharp fluctuations' => ['id' => 'mengalami fluktuasi tajam', 'pos' => '(v phr)'],
                        ],
                        'options' => [
                            'During that period, the stock price experienced sharp fluctuations.',
                            'During that period, the stock price has experienced sharp fluctuations.',
                            'During that period, the stock price experiences sharp fluctuations.',
                            'During that period, the stock price was experienced sharp fluctuations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'During that period\' adalah konteks waktu lampau spesifik, menggunakan Simple Past \'experienced\'.',
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Pada akhir tahun lalu, perusahaan mencatatkan laba tertinggi sepanjang sejarahnya.',
                        'target_word' => 'At the end of last year, ... recorded',
                        'vocab' => [
                            'at the end of last year' => ['id' => 'pada akhir tahun lalu', 'pos' => '(time phr)'],
                            'the company' => ['id' => 'perusahaan', 'pos' => '(n)'],
                            'recorded its highest profit in history' => ['id' => 'mencatatkan laba tertinggi sepanjang sejarahnya', 'pos' => '(v phr)'],
                        ],
                        'options' => [
                            'At the end of last year, the company recorded its highest profit in history.',
                            'At the end of last year, the company has recorded its highest profit in history.',
                            'At the end of last year, the company records its highest profit in history.',
                            'At the end of last year, the company was recorded its highest profit in history.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keterangan waktu spesifik di awal kalimat diikuti koma, lalu subjek + Simple Past \'recorded\'.',
                    ],
                ],
            ],
            [
                'id' => 'past_synthesis_story',
                'name' => 'A Business Trip Story: Combining Active, Passive & Nominal Past',
                'code' => '1.8.8',
                'concept_title' => 'A Business Trip Story: Combining Active, Passive & Nominal Past',
                'concept_description' => 'Sub-lesson sintesis ini menggabungkan ketiga bentuk Simple Past (Verbal, Nominal, Pasif) dalam satu alur cerita berkelanjutan tentang sebuah perjalanan dinas, melatih kemampuan beralih antar bentuk secara alami dalam satu narasi.',
                'formula' => 'Kombinasi bebas: Verbal (S+V2), Nominal (S+was/were+Comp), Pasif (S+was/were+V3) sesuai konteks kalimat.',
                'rules' => [
                    'Baca konteks kalimat dengan cermat untuk menentukan apakah subjek bertindak aktif, dijelaskan kondisinya, atau menerima tindakan.',
                    'Jaga konsistensi tenses Simple Past di seluruh narasi, kecuali ada penanda waktu lain yang jelas.',
                    'Perhatikan kata kerja tidak beraturan yang sering muncul dalam narasi perjalanan (left, flew, drove, met).',
                    'Gunakan koneksi logis antar kalimat (then, after that, meanwhile, finally) untuk menjaga alur cerita.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Saya terbang ke Singapura untuk menghadiri konferensi regional.',
                        'target_word' => 'flew',
                        'vocab' => [
                            'I' => ['id' => 'saya', 'pos' => '(pron)'],
                            'flew to Singapore' => ['id' => 'terbang ke Singapura', 'pos' => '(v phr)'],
                            'to attend the regional conference' => ['id' => 'untuk menghadiri konferensi regional', 'pos' => '(v phr)'],
                        ],
                        'options' => [
                            'I flew to Singapore to attend the regional conference.',
                            'I flied to Singapore to attend the regional conference.',
                            'I fly to Singapore to attend the regional conference.',
                            'I was flew to Singapore to attend the regional conference.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'fly\' adalah \'flew\'.',
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Penerbangan itu sangat nyaman meskipun agak terlambat.',
                        'target_word' => 'was very comfortable',
                        'vocab' => [
                            'the flight' => ['id' => 'penerbangan itu', 'pos' => '(n sg)'],
                            'was very comfortable' => ['id' => 'sangat nyaman', 'pos' => '(phr)'],
                            'although it was a bit late' => ['id' => 'meskipun agak terlambat', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'The flight was very comfortable although it was a bit late.',
                            'The flight were very comfortable although it was a bit late.',
                            'The flight comforted very much although it was a bit late.',
                            'The flight was very comfortably although it was a bit late.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Menerangkan kondisi subjek tunggal \'flight\', gunakan Nominal \'was comfortable\'.',
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Saya dijemput oleh perwakilan perusahaan mitra di bandara.',
                        'target_word' => 'was picked up',
                        'vocab' => [
                            'I' => ['id' => 'saya', 'pos' => '(pron)'],
                            'was picked up' => ['id' => 'dijemput', 'pos' => '(v passive phr)'],
                            'by a representative from the partner company' => ['id' => 'oleh perwakilan perusahaan mitra', 'pos' => '(prep phr)'],
                            'at the airport' => ['id' => 'di bandara', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'I was picked up by a representative from the partner company at the airport.',
                            'I were picked up by a representative from the partner company at the airport.',
                            'I picked up by a representative from the partner company at the airport.',
                            'I was pick up by a representative from the partner company at the airport.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'I\' menerima tindakan penjemputan, gunakan Pasif \'was picked up\'.',
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Kemudian, kami mengunjungi pabrik utama mitra bisnis itu.',
                        'target_word' => 'Then, ... visited',
                        'vocab' => [
                            'then' => ['id' => 'kemudian', 'pos' => '(conj adv)'],
                            'we' => ['id' => 'kami', 'pos' => '(pron)'],
                            'visited the partner\'s main factory' => ['id' => 'mengunjungi pabrik utama mitra bisnis itu', 'pos' => '(v phr)'],
                        ],
                        'options' => [
                            'Then, we visited the partner\'s main factory.',
                            'Then, we visit the partner\'s main factory.',
                            'Then, we have visited the partner\'s main factory.',
                            'Then, we were visited the partner\'s main factory.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Konektor \'Then\' menghubungkan kalimat berikutnya dengan Simple Past aktif \'visited\'.',
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Fasilitas produksinya jauh lebih besar dari perkiraan kami.',
                        'target_word' => 'was much bigger',
                        'vocab' => [
                            'the production facility' => ['id' => 'fasilitas produksinya', 'pos' => '(n sg)'],
                            'was much bigger than we expected' => ['id' => 'jauh lebih besar dari perkiraan kami', 'pos' => '(phr)'],
                        ],
                        'options' => [
                            'The production facility was much bigger than we expected.',
                            'The production facility were much bigger than we expected.',
                            'The production facility bigger than we expected.',
                            'The production facility was much biggest than we expected.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Menerangkan kondisi subjek tunggal \'facility\', gunakan Nominal \'was bigger\'.',
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Sesudah itu, kami mengadakan rapat singkat dengan tim produksi.',
                        'target_word' => 'After that, ... held',
                        'vocab' => [
                            'after that' => ['id' => 'sesudah itu', 'pos' => '(time phr)'],
                            'we' => ['id' => 'kami', 'pos' => '(pron)'],
                            'held a brief meeting' => ['id' => 'mengadakan rapat singkat', 'pos' => '(v phr)'],
                            'with the production team' => ['id' => 'dengan tim produksi', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'After that, we held a brief meeting with the production team.',
                            'After that, we holded a brief meeting with the production team.',
                            'After that, we hold a brief meeting with the production team.',
                            'After that, we were held a brief meeting with the production team.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'hold\' adalah \'held\'.',
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Beberapa poin penting dibahas selama rapat tersebut.',
                        'target_word' => 'were discussed',
                        'vocab' => [
                            'several important points' => ['id' => 'beberapa poin penting', 'pos' => '(n pl)'],
                            'were discussed' => ['id' => 'dibahas', 'pos' => '(v passive)'],
                            'during the meeting' => ['id' => 'selama rapat tersebut', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'Several important points were discussed during the meeting.',
                            'Several important points was discussed during the meeting.',
                            'Several important points discussed during the meeting.',
                            'Several important points were discuss during the meeting.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'points\' menerima tindakan, gunakan Pasif \'were discussed\' (were + V3).',
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Pada malam harinya, mitra bisnis mengajak kami makan malam di restoran lokal.',
                        'target_word' => 'took',
                        'vocab' => [
                            'that evening' => ['id' => 'pada malam harinya', 'pos' => '(time phr)'],
                            'our business partners' => ['id' => 'mitra bisnis', 'pos' => '(n pl)'],
                            'took us to dinner' => ['id' => 'mengajak kami makan malam', 'pos' => '(v phr)'],
                            'at a local restaurant' => ['id' => 'di restoran lokal', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'That evening, our business partners took us to dinner at a local restaurant.',
                            'That evening, our business partners taked us to dinner at a local restaurant.',
                            'That evening, our business partners take us to dinner at a local restaurant.',
                            'That evening, our business partners were took us to dinner at a local restaurant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk V2 dari \'take\' adalah \'took\'.',
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Makan malam itu adalah penutup yang sempurna untuk kunjungan kami.',
                        'target_word' => 'was a perfect ending',
                        'vocab' => [
                            'the dinner' => ['id' => 'makan malam itu', 'pos' => '(n sg)'],
                            'was a perfect ending' => ['id' => 'adalah penutup yang sempurna', 'pos' => '(phr)'],
                            'to our visit' => ['id' => 'untuk kunjungan kami', 'pos' => '(prep phr)'],
                        ],
                        'options' => [
                            'The dinner was a perfect ending to our visit.',
                            'The dinner were a perfect ending to our visit.',
                            'The dinner ended a perfect ending to our visit.',
                            'The dinner was perfect ending to our visit.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'dinner\' menggunakan \'was\' + frasa nomina komplemen.',
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Akhirnya, kesepakatan kerja sama baru ditandatangani sebelum kami kembali.',
                        'target_word' => 'was signed',
                        'vocab' => [
                            'finally' => ['id' => 'akhirnya', 'pos' => '(adv)'],
                            'the new partnership agreement' => ['id' => 'kesepakatan kerja sama baru', 'pos' => '(n sg)'],
                            'was signed' => ['id' => 'ditandatangani', 'pos' => '(v passive)'],
                            'before we returned' => ['id' => 'sebelum kami kembali', 'pos' => '(clause)'],
                        ],
                        'options' => [
                            'Finally, the new partnership agreement was signed before we returned.',
                            'Finally, the new partnership agreement were signed before we returned.',
                            'Finally, the new partnership agreement signed before we returned.',
                            'Finally, the new partnership agreement was sign before we returned.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'agreement\' menerima tindakan, gunakan Pasif \'was signed\' (was + V3).',
                    ],
                ],
            ],
        ];
    }
}
