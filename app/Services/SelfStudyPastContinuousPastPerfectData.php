<?php

namespace App\Services;

class SelfStudyPastContinuousPastPerfectData
{
    /**
     * Get the complete Past Continuous & Past Perfect Tenses (Timeline Sequencing) package.
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
            'banner_title' => 'Past Continuous & Past Perfect Tenses (Timeline Sequencing)',
            'banner_subtitle' => 'Kuasai cara mengatur linimasa cerita yang lebih kompleks: aksi simultan lampau (was/were + V-ing), kegiatan pasif yang sedang berjalan (was/were being + V3), peristiwa pendahulu (had + V3), kondisi sebelum suatu momen (had been + Adj/Noun), durasi berkelanjutan (had been + V-ing), dan penghubung waktu (by the time, prior to).',
            'banner_badge' => 'MODULE 1.12 TIMELINE SEQUENCING',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.12
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Past Continuous & Past Perfect: Menguasai Linimasa Cerita',
            'concept_summary' => 'Saat menceritakan kejadian yang melibatkan beberapa tahap, kerancuan urutan waktu bisa membuat cerita sulit dipahami. Bab ini menggabungkan seluruh ragam tenses masa lampau untuk menciptakan linimasa yang jelas: (1) Past Continuous (was/were + V-ing) untuk aksi yang sedang berlangsung di latar belakang; (2) Past Perfect (had + V3) untuk menandai peristiwa yang selesai lebih awal dari peristiwa lampau lainnya (The Earlier Past); dan (3) Past Perfect Continuous (had been + V-ing) untuk menegaskan durasi suatu kegiatan sebelum peristiwa lain terjadi.',
            'rules' => [
                [
                    'rule_title' => '1. Past Continuous: Latar Belakang & Aksi Simultan (Was/Were + V-ing)',
                    'rule_formula' => 'Subject + was/were + Verb-ing + while / when + Clause',
                    'rule_description' => 'Gunakan "was + V-ing" untuk subjek tunggal dan "were + V-ing" untuk subjek jamak saat menggambarkan peristiwa latar belakang yang sedang berlangsung ketika peristiwa interupsi (Simple Past) terjadi.',
                    'examples' => [
                        [
                            'en' => 'While the technician was repairing the server, the backup system suddenly failed.',
                            'id' => 'Ketika teknisi sedang memperbaiki server, sistem cadangan tiba-tiba gagal berfungsi.',
                            'note' => '"was repairing" (sedang memperbaiki) disela oleh peristiwa seketika "failed".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Past Continuous Pasif: Sesuatu Sedang Dikerjakan (Was/Were Being + V3)',
                    'rule_formula' => 'Passive Subject + was/were + being + Verb 3 (Past Participle)',
                    'rule_description' => 'Fokus kalimat dialihkan ke sesuatu yang sedang dikenai tindakan di masa lampau. Sisipan partikel "being" wajib hadir untuk menandai progresivitas pasif lampau.',
                    'examples' => [
                        [
                            'en' => 'The contract was being reviewed by the legal team when the client called to renegotiate the terms.',
                            'id' => 'Kontrak itu sedang ditinjau oleh tim legal ketika klien menelepon untuk menegosiasikan ulang persyaratannya.',
                            'note' => '"was being reviewed" adalah bentuk pasif continuous tunggal yang tepat.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Past Perfect: Menandai Peristiwa yang Terjadi Lebih Dulu (Had + V3)',
                    'rule_formula' => 'Subject + had + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                    'rule_description' => 'Bila terdapat dua aksi masa lalu, aksi yang selesai lebih awal WAJIB menggunakan Past Perfect "had + V3", sedangkan aksi yang terjadi belakangan menggunakan Simple Past V2.',
                    'examples' => [
                        [
                            'en' => 'She had already left the office by the time the client called back.',
                            'id' => 'Dia sudah meninggalkan kantor pada saat klien menelepon kembali.',
                            'note' => 'Meninggalkan kantor ("had left") selesai sebelum klien menelepon kembali ("called back").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Past Perfect Nominal & Pasif: Had Been + Complement / V3',
                    'rule_formula' => 'Nominal: had been + Adj/Noun | Pasif: had been + Verb 3',
                    'rule_description' => 'Menyatakan status sebelum suatu momen, atau sesuatu yang telah selesai dikerjakan terhadap objek sebelum titik tolak pengamatan lampau tercapai.',
                    'examples' => [
                        [
                            'en' => 'The venue had been fully booked before the organizers could confirm the final guest list.',
                            'id' => 'Tempat acara itu telah sepenuhnya dipesan sebelum panitia sempat memastikan daftar tamu final.',
                            'note' => '"had been fully booked" menegaskan tempat sudah penuh sebelum daftar tamu dipastikan ("could confirm").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Aturan Konjungsi Linimasa: By the time, Prior to, Once',
                    'rule_formula' => 'By the time + S + V2 (Past), S + had + V3 / had been V3',
                    'rule_description' => 'Frasa "By the time" diikuti Simple Past mewajibkan induk kalimat menggunakan Past Perfect. Preposisi "Prior to" diikuti Gerund atau Noun Phrase.',
                    'examples' => [
                        [
                            'en' => 'By the time the negotiations concluded, both parties had already compromised on the budget.',
                            'id' => 'Menjelang negosiasi berakhir, kedua belah pihak telah berkompromi mengenai anggaran.',
                            'note' => '"had already compromised" terjadi mendahului berakhirnya negosiasi ("concluded").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '6. Past Perfect Continuous: Penekanan Durasi Lampau (Had Been + V-ing)',
                    'rule_formula' => 'Subject + had been + Verb-ing + duration (for/since) + before / when Clause',
                    'rule_description' => 'Digunakan saat kita ingin menonjolkan proses yang sudah berlangsung cukup lama sebelum suatu peristiwa terjadi di masa lalu.',
                    'examples' => [
                        [
                            'en' => 'The negotiations had been going on for hours before they finally reached an agreement.',
                            'id' => 'Negosiasi telah berlangsung selama berjam-jam sebelum akhirnya mereka mencapai kesepakatan.',
                            'note' => '"had been going on ... for hours" menekankan durasi negosiasi sebelum kesepakatan tercapai.'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Complete 8 sub-lessons with 10 questions each (80 questions total).
     */
    public static function getSubLessons(): array
    {
        return [
            [
                'id' => 'past-continuous-verbal',
                'name' => '1.12.1 Past Continuous: Simultaneous Actions & Ongoing Background Events',
                'code' => '1.12.1',
                'concept_title' => 'Past Continuous: Tindakan Simultan & Peristiwa Latar Belakang Lampau',
                'concept_description' => 'Past Continuous Tense (was/were + V-ing) digunakan untuk menggambarkan peristiwa yang sedang berlangsung sebagai latar belakang (background event) ketika suatu peristiwa lain terjadi (interrupted action), atau dua aktivitas yang berlangsung secara bersamaan di masa lampau (simultaneous actions) -- umum dijumpai dalam konteks pekerjaan, perjalanan, dan kehidupan sehari-hari.',
                'description' => 'Past Continuous Tense (was/were + V-ing) digunakan untuk menggambarkan peristiwa yang sedang berlangsung sebagai latar belakang (background event) ketika suatu peristiwa lain terjadi (interrupted action), atau dua aktivitas yang berlangsung secara bersamaan di masa lampau (simultaneous actions) -- umum dijumpai dalam konteks pekerjaan, perjalanan, dan kehidupan sehari-hari.',
                'formula' => 'Subject + was/were + Verb-ing + while / when + Clause',
                'rules' => [
                    "Gunakan 'was + V-ing' untuk subjek tunggal (I, he, she, it, singular noun: the manager, the flight).",
                    "Gunakan 'were + V-ing' untuk subjek jamak (they, we, plural nouns: the engineers, the passengers).",
                    "Gunakan 'while' untuk mengawali klausa yang sedang berlangsung (While the engineers were testing the system...).",
                    "Gunakan 'when' untuk mengawali peristiwa interupsi yang biasanya berbentuk Simple Past (When the alarm went off...).",
                    'Dilarang menggunakan to be present (is/are) untuk peristiwa masa lampau.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Ketika kami sedang melakukan rapat daring, koneksi internet tiba-tiba terputus.',
                        'target_word' => 'were having ... went down (Background Action + Interruption)',
                        'vocab' => [
                            ['en' => 'we', 'id' => 'kami'],
                            ['en' => 'having an online meeting', 'id' => 'melakukan rapat daring'],
                            ['en' => 'internet connection suddenly went down', 'id' => 'koneksi internet tiba-tiba terputus'],
                        ],
                        'options' => [
                            'While we were having an online meeting, the internet connection suddenly went down.',
                            'While we was having an online meeting, the internet connection suddenly went down.',
                            'While we were have an online meeting, the internet connection suddenly went down.',
                            'While we were having an online meeting, the internet connection was gone down.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'we' berpasangan dengan 'were having'. Peristiwa interupsi yang tiba-tiba terjadi menggunakan Simple Past aktif 'went down'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Manajer sedang meninjau laporan keuangan saat kliennya tiba-tiba menelepon.',
                        'target_word' => 'was reviewing ... called (Interrupted Past Action)',
                        'vocab' => [
                            ['en' => 'the manager', 'id' => 'manajer'],
                            ['en' => 'reviewing the financial report', 'id' => 'meninjau laporan keuangan'],
                            ['en' => 'the client suddenly called', 'id' => 'kliennya tiba-tiba menelepon'],
                        ],
                        'options' => [
                            'The manager was reviewing the financial report when the client suddenly called.',
                            'The manager were reviewing the financial report when the client suddenly called.',
                            'The manager was review the financial report when the client suddenly called.',
                            'The manager was reviewing the financial report when the client was called.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'the manager' berpasangan dengan 'was reviewing', sedangkan klausa 'when' memakai Simple Past aktif 'called'.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Sementara dokter sedang memeriksa pasien, perawat menyiapkan obat yang diperlukan.',
                        'target_word' => 'was examining ... prepared (Simultaneous Actions)',
                        'vocab' => [
                            ['en' => 'the doctor', 'id' => 'dokter'],
                            ['en' => 'examining the patient', 'id' => 'memeriksa pasien'],
                            ['en' => 'nurse prepared the necessary medicine', 'id' => 'perawat menyiapkan obat yang diperlukan'],
                        ],
                        'options' => [
                            'While the doctor was examining the patient, the nurse prepared the necessary medicine.',
                            'While the doctor were examining the patient, the nurse prepared the necessary medicine.',
                            'While the doctor was examine the patient, the nurse prepared the necessary medicine.',
                            'While the doctor was examining the patient, the nurse was prepared the necessary medicine.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'the doctor' (tunggal) memakai 'was examining', diikuti klausa 'prepared' Simple Past aktif.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Pada saat pemadaman listrik terjadi, para karyawan sedang menyelesaikan laporan akhir bulan di kantor.',
                        'target_word' => 'were finishing (Past Continuous Background)',
                        'vocab' => [
                            ['en' => 'blackout occurred', 'id' => 'pemadaman listrik terjadi'],
                            ['en' => 'the employees', 'id' => 'para karyawan'],
                            ['en' => 'finishing the month-end report', 'id' => 'menyelesaikan laporan akhir bulan'],
                        ],
                        'options' => [
                            'At the moment the blackout occurred, the employees were finishing the month-end report at the office.',
                            'At the moment the blackout occurred, the employees was finishing the month-end report at the office.',
                            'At the moment the blackout occurred, the employees were finish the month-end report at the office.',
                            'At the moment the blackout occurred, the employees had finishing the month-end report at the office.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'the employees' berpasangan dengan 'were finishing' sebagai aktivitas yang sedang berlangsung di momen tertentu lampau.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Sepanjang penerbangan itu, hujan sedang turun secara stabil di luar jendela pesawat.',
                        'target_word' => 'was falling (Past Continuous Gradual)',
                        'vocab' => [
                            ['en' => 'throughout that flight', 'id' => 'sepanjang penerbangan itu'],
                            ['en' => 'rain', 'id' => 'hujan'],
                            ['en' => 'falling steadily', 'id' => 'turun secara stabil'],
                        ],
                        'options' => [
                            'Throughout that flight, rain was falling steadily outside the plane window.',
                            'Throughout that flight, rain were falling steadily outside the plane window.',
                            'Throughout that flight, rain was fall steadily outside the plane window.',
                            'Throughout that flight, rain falling was steadily outside the plane window.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'rain' adalah uncountable singular, sehingga membutuhkan 'was falling'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Sementara satu tim sedang merancang proposal, tim lain menghubungi vendor untuk penawaran harga.',
                        'target_word' => 'was drafting ... contacted (Parallel Team Tasks)',
                        'vocab' => [
                            ['en' => 'one team', 'id' => 'satu tim'],
                            ['en' => 'drafting the proposal', 'id' => 'merancang proposal'],
                            ['en' => 'contacted the vendor for a price quote', 'id' => 'menghubungi vendor untuk penawaran harga'],
                        ],
                        'options' => [
                            'While one team was drafting the proposal, the other team contacted the vendor for a price quote.',
                            'While one team were drafting the proposal, the other team contacted the vendor for a price quote.',
                            'While one team was draft the proposal, the other team contacted the vendor for a price quote.',
                            'While one team was drafting the proposal, the other team was contacted the vendor for a price quote.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'one team' (tunggal) memakai 'was drafting', dikontraskan dengan tindakan tim lain 'contacted'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Para teknisi sedang memasang kabel jaringan saat mereka menemukan sambungan yang rusak.',
                        'target_word' => 'were installing ... found (Continuous + Simple Past Discovery)',
                        'vocab' => [
                            ['en' => 'the technicians', 'id' => 'para teknisi'],
                            ['en' => 'installing the network cables', 'id' => 'memasang kabel jaringan'],
                            ['en' => 'a damaged connection', 'id' => 'sambungan yang rusak'],
                        ],
                        'options' => [
                            'The technicians were installing the network cables when they found a damaged connection.',
                            'The technicians was installing the network cables when they found a damaged connection.',
                            'The technicians were install the network cables when they found a damaged connection.',
                            'The technicians were installing the network cables when they were found a damaged connection.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The technicians were installing' (latar belakang jamak) disela oleh temuan 'when they found'.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Ketika kontrak sedang ditandatangani, nilai saham perusahaan itu tiba-tiba naik secara signifikan.',
                        'target_word' => 'was being signed ... rose (Process + Sharp Result)',
                        'vocab' => [
                            ['en' => 'contract was being signed', 'id' => 'kontrak sedang ditandatangani'],
                            ['en' => "the company's share value", 'id' => 'nilai saham perusahaan'],
                            ['en' => 'rose significantly', 'id' => 'naik secara signifikan'],
                        ],
                        'options' => [
                            'As the contract was being signed, the company\'s share value suddenly rose significantly.',
                            'As the contract were being signed, the company\'s share value suddenly rose significantly.',
                            'As the contract was signed, the company\'s share value suddenly rose significantly.',
                            'As the contract was being signed, the company\'s share value was risen significantly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'contract' mengambil 'was being signed', sedangkan klausa hasil memakai 'rose' aktif.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Sementara kepala departemen sedang menyampaikan presentasi, salah satu anggota tim menerima pesan darurat.',
                        'target_word' => 'was giving ... received (Background + Interruption)',
                        'vocab' => [
                            ['en' => 'the department head was giving', 'id' => 'kepala departemen sedang menyampaikan'],
                            ['en' => 'the presentation', 'id' => 'presentasi'],
                            ['en' => 'one team member received an urgent message', 'id' => 'salah satu anggota tim menerima pesan darurat'],
                        ],
                        'options' => [
                            'While the department head was giving the presentation, one team member received an urgent message.',
                            'While the department head was giving the presentation, one team member was received an urgent message.',
                            'While the department head were giving the presentation, one team member received an urgent message.',
                            'While the department head was give the presentation, one team member received an urgent message.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'the department head was giving' (tunggal) dipadukan dengan pesan darurat 'received'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Komite perencanaan sedang mendiskusikan anggaran acara ketika pengumuman perubahan tanggal mendadak dirilis.',
                        'target_word' => 'was discussing ... was released (Continuous Active + Past Passive)',
                        'vocab' => [
                            ['en' => 'planning committee was discussing', 'id' => 'komite perencanaan sedang mendiskusikan'],
                            ['en' => 'the event budget', 'id' => 'anggaran acara'],
                            ['en' => 'sudden date-change announcement was released', 'id' => 'pengumuman perubahan tanggal mendadak dirilis'],
                        ],
                        'options' => [
                            'The planning committee was discussing the event budget when the sudden date-change announcement was released.',
                            'The planning committee were discussing the event budget when the sudden date-change announcement was released.',
                            'The planning committee was discuss the event budget when the sudden date-change announcement was released.',
                            'The planning committee was discussing the event budget when the sudden date-change announcement released.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The planning committee was discussing' (kolektif tunggal) disela oleh peristiwa pasif lampau 'was released'.",
                    ],
                ]
            ],
            [
                'id' => 'past-continuous-passive',
                'name' => '1.12.2 Past Continuous Passive: Activities in Progress',
                'code' => '1.12.2',
                'concept_title' => 'Past Continuous Pasif: Kegiatan yang Sedang Dikerjakan',
                'concept_description' => "Past Continuous Pasif digunakan untuk menceritakan sesuatu yang sedang aktif dikerjakan terhadap suatu objek pada saat tertentu di masa lalu. Rumusnya menggunakan 'was/were' diikuti partikel 'being' dan Past Participle (V3). Bentuk ini cocok dipakai ketika kita ingin menekankan objek yang sedang menerima tindakan, bukan siapa yang melakukannya -- sering muncul dalam konteks pekerjaan dan layanan publik.",
                'description' => "Past Continuous Pasif digunakan untuk menceritakan sesuatu yang sedang aktif dikerjakan terhadap suatu objek pada saat tertentu di masa lalu. Rumusnya menggunakan 'was/were' diikuti partikel 'being' dan Past Participle (V3). Bentuk ini cocok dipakai ketika kita ingin menekankan objek yang sedang menerima tindakan, bukan siapa yang melakukannya -- sering muncul dalam konteks pekerjaan dan layanan publik.",
                'formula' => 'Subject (Patient) + was/were + being + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    "Gunakan 'was being + V3' untuk subjek tunggal (the contract, the report, the building).",
                    "Gunakan 'were being + V3' untuk subjek jamak (the documents, the shipments, the applications).",
                    "Partikel 'being' wajib hadir untuk menunjukkan progresivitas tindakan lampau.",
                    "Jangan tertukar dengan Past Perfect Pasif (had been + V3); continuous pasif selalu memakai 'being'.",
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Dokumen-dokumen sedang diperiksa oleh audit internal ketika masalah pada sistem tiba-tiba muncul.',
                        'target_word' => 'were being checked (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the documents', 'id' => 'dokumen-dokumen'],
                            ['en' => 'checked by internal audit', 'id' => 'diperiksa oleh audit internal'],
                            ['en' => 'a system issue suddenly appeared', 'id' => 'masalah pada sistem tiba-tiba muncul'],
                        ],
                        'options' => [
                            'The documents were being checked by internal audit when a system issue suddenly appeared.',
                            'The documents was being checked by internal audit when a system issue suddenly appeared.',
                            'The documents were been checked by internal audit when a system issue suddenly appeared.',
                            'The documents were checking by internal audit when a system issue suddenly appeared.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'documents' membutuhkan 'were being checked'. Pilihan C salah memakai 'been' (untuk perfect), dan D aktif.",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Jaringan listrik baru sedang dipasang di gedung kantor saat kontraktornya tiba-tiba kehabisan material.',
                        'target_word' => 'was being installed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'new electrical wiring', 'id' => 'jaringan listrik baru'],
                            ['en' => 'installed', 'id' => 'dipasang'],
                            ['en' => 'contractor suddenly ran out of materials', 'id' => 'kontraktornya tiba-tiba kehabisan material'],
                        ],
                        'options' => [
                            'New electrical wiring was being installed at the office building when the contractor suddenly ran out of materials.',
                            'New electrical wiring were being installed at the office building when the contractor suddenly ran out of materials.',
                            'New electrical wiring was been installed at the office building when the contractor suddenly ran out of materials.',
                            'New electrical wiring was installing at the office building when the contractor suddenly ran out of materials.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'wiring' memerlukan 'was being installed'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Pesanan katering sedang disiapkan di dapur ketika aliran listrik terputus.',
                        'target_word' => 'was being prepared (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the catering order', 'id' => 'pesanan katering'],
                            ['en' => 'prepared in the kitchen', 'id' => 'disiapkan di dapur'],
                            ['en' => 'power went out', 'id' => 'aliran listrik terputus'],
                        ],
                        'options' => [
                            'The catering order was being prepared in the kitchen when the power went out.',
                            'The catering order were being prepared in the kitchen when the power went out.',
                            'The catering order was been prepared in the kitchen when the power went out.',
                            'The catering order was preparing in the kitchen when the power went out.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'order' berpasangan dengan 'was being prepared'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Barang-barang konsinyasi sedang dikemas di gudang sebelum pelanggan tiba-tiba membatalkan pesanannya.',
                        'target_word' => 'were being packed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the consignment goods', 'id' => 'barang-barang konsinyasi'],
                            ['en' => 'packed in the warehouse', 'id' => 'dikemas di gudang'],
                            ['en' => 'customer suddenly canceled the order', 'id' => 'pelanggan tiba-tiba membatalkan pesanannya'],
                        ],
                        'options' => [
                            'The consignment goods were being packed in the warehouse before the customer suddenly canceled the order.',
                            'The consignment goods was being packed in the warehouse before the customer suddenly canceled the order.',
                            'The consignment goods were been packed in the warehouse before the customer suddenly canceled the order.',
                            'The consignment goods were packing in the warehouse before the customer suddenly canceled the order.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'goods' membutuhkan 'were being packed'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Mesin produksi itu sedang diperbaiki ketika teknisinya menemukan masalah lain yang lebih serius.',
                        'target_word' => 'was being repaired (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the production machine', 'id' => 'mesin produksi itu'],
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'technician found another, more serious problem', 'id' => 'teknisi menemukan masalah lain yang lebih serius'],
                        ],
                        'options' => [
                            'The production machine was being repaired when the technician found another, more serious problem.',
                            'The production machine were being repaired when the technician found another, more serious problem.',
                            'The production machine was been repaired when the technician found another, more serious problem.',
                            'The production machine was repairing when the technician found another, more serious problem.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'machine' berpasangan dengan 'was being repaired'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Permohonan visa itu sedang diproses di kedutaan saat jadwal keberangkatan kami hampir tiba.',
                        'target_word' => 'was being processed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the visa application', 'id' => 'permohonan visa'],
                            ['en' => 'processed at the embassy', 'id' => 'diproses di kedutaan'],
                            ['en' => 'our departure schedule was almost here', 'id' => 'jadwal keberangkatan kami hampir tiba'],
                        ],
                        'options' => [
                            'The visa application was being processed at the embassy as our departure schedule was almost here.',
                            'The visa application was being processed at the embassy as our departure schedule were almost here.',
                            'The visa application were being processed at the embassy as our departure schedule was almost here.',
                            'The visa application was processing at the embassy as our departure schedule was almost here.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'application' dipadukan dengan 'was being processed'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Sistem pembayaran daring sedang diperbarui ketika pelanggan mulai melaporkan transaksi yang gagal.',
                        'target_word' => 'was being updated (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the online payment system', 'id' => 'sistem pembayaran daring'],
                            ['en' => 'updated', 'id' => 'diperbarui'],
                            ['en' => 'customers began reporting failed transactions', 'id' => 'pelanggan mulai melaporkan transaksi yang gagal'],
                        ],
                        'options' => [
                            'The online payment system was being updated when customers began reporting failed transactions.',
                            'The online payment system were being updated when customers began reporting failed transactions.',
                            'The online payment system was been updated when customers began reporting failed transactions.',
                            'The online payment system was updating when customers began reporting failed transactions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'system' membutuhkan 'was being updated'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Surat-surat penawaran sedang dibagikan ke investor saat hujan deras mulai turun.',
                        'target_word' => 'were being distributed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the offer letters', 'id' => 'surat-surat penawaran'],
                            ['en' => 'distributed to the investors', 'id' => 'dibagikan ke investor'],
                            ['en' => 'heavy rain started falling', 'id' => 'hujan deras mulai turun'],
                        ],
                        'options' => [
                            'The offer letters were being distributed to the investors when heavy rain started falling.',
                            'The offer letters was being distributed to the investors when heavy rain started falling.',
                            'The offer letters were been distributed to the investors when heavy rain started falling.',
                            'The offer letters were distributing to the investors when heavy rain started falling.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'letters' memerlukan 'were being distributed'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Proposal anggaran itu sedang direvisi di ruang rapat ketika listrik tiba-tiba padam.',
                        'target_word' => 'was being revised (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'budget proposal', 'id' => 'proposal anggaran'],
                            ['en' => 'revised in the meeting room', 'id' => 'direvisi di ruang rapat'],
                            ['en' => 'power suddenly went out', 'id' => 'listrik tiba-tiba padam'],
                        ],
                        'options' => [
                            'The budget proposal was being revised in the meeting room when the power suddenly went out.',
                            'The budget proposal were being revised in the meeting room when the power suddenly went out.',
                            'The budget proposal was been revised in the meeting room when the power suddenly went out.',
                            'The budget proposal was revising in the meeting room when the power suddenly went out.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'proposal' dipadukan dengan 'was being revised'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Berkas-berkas lamaran kerja sedang disortir ketika sistem perekrutan tiba-tiba mengalami gangguan.',
                        'target_word' => 'were being sorted (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'job application files', 'id' => 'berkas-berkas lamaran kerja'],
                            ['en' => 'sorted', 'id' => 'disortir'],
                            ['en' => 'recruitment system suddenly experienced a glitch', 'id' => 'sistem perekrutan tiba-tiba mengalami gangguan'],
                        ],
                        'options' => [
                            'The job application files were being sorted when the recruitment system suddenly experienced a glitch.',
                            'The job application files was being sorted when the recruitment system suddenly experienced a glitch.',
                            'The job application files were been sorted when the recruitment system suddenly experienced a glitch.',
                            'The job application files were sorting when the recruitment system suddenly experienced a glitch.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'files' berpasangan dengan 'were being sorted'.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-verbal',
                'name' => '1.12.3 Past Perfect Verbal: Establishing Earlier Actions (The Earlier Past)',
                'code' => '1.12.3',
                'concept_title' => 'Past Perfect Verbal: Peristiwa yang Terjadi Lebih Dulu dalam Linimasa Lampau',
                'concept_description' => "Past Perfect Verbal (had + V3) digunakan ketika ada DUA peristiwa yang sama-sama terjadi di masa lalu, dan kita harus menegaskan secara eksplisit bahwa tindakan A telah selesai sepenuhnya SEBELUM tindakan B terjadi. Tense ini dinamakan 'The Earlier Past' atau masa lalu yang lebih lampau. Tidak bergantung pada subjek tunggal/jamak: semua subjek menggunakan 'had + V3'.",
                'description' => "Past Perfect Verbal (had + V3) digunakan ketika ada DUA peristiwa yang sama-sama terjadi di masa lalu, dan kita harus menegaskan secara eksplisit bahwa tindakan A telah selesai sepenuhnya SEBELUM tindakan B terjadi. Tense ini dinamakan 'The Earlier Past' atau masa lalu yang lebih lampau. Tidak bergantung pada subjek tunggal/jamak: semua subjek menggunakan 'had + V3'.",
                'formula' => 'Subject + had + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                'rules' => [
                    "Gunakan 'had + V3' untuk tindakan pertama yang terjadi lebih awal.",
                    'Gunakan Simple Past (V2) untuk tindakan kedua yang terjadi kemudian.',
                    "Semua subjek (tunggal maupun jamak) menggunakan auxiliary yang sama: 'had'.",
                    "Dilarang menggunakan 'had + V3' sendirian tanpa adanya titik tolak masa lampau (Past Point of Reference) dalam konteks kalimat.",
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Saya telah menyelesaikan laporan sebelum manajer memintanya.',
                        'target_word' => 'had finished ... asked (Earlier Past vs Past)',
                        'vocab' => [
                            ['en' => 'I had finished', 'id' => 'saya telah menyelesaikan'],
                            ['en' => 'the report', 'id' => 'laporan'],
                            ['en' => 'the manager asked for it', 'id' => 'manajer memintanya'],
                        ],
                        'options' => [
                            'I had finished the report before the manager asked for it.',
                            'I has finished the report before the manager asked for it.',
                            'I finished the report before the manager had asked for it.',
                            'I had finish the report before the manager asked for it.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan menyelesaikan laporan terjadi lebih dulu ('had finished') sebelum manajer memintanya ('asked' Simple Past).",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sebelum mengajukan proposal itu, tim telah menganalisis seluruh data pasar.',
                        'target_word' => 'had analyzed ... submitted (Earlier Action)',
                        'vocab' => [
                            ['en' => 'analyzed all the market data', 'id' => 'menganalisis seluruh data pasar'],
                            ['en' => 'submitted the proposal', 'id' => 'mengajukan proposal'],
                        ],
                        'options' => [
                            'Before submitting the proposal, the team had analyzed all the market data.',
                            'Before submitting the proposal, the team has analyzed all the market data.',
                            'Before submitting the proposal, the team had analyze all the market data.',
                            'Before submitting the proposal, the team have analyzed all the market data back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Analisis data mendahului pengajuan proposal lampau, sehingga wajib menggunakan Past Perfect 'had analyzed'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Pelanggan itu telah menggunakan layanan kami selama lima tahun sebelum ia mulai mengeluhkan harga.',
                        'target_word' => 'had used ... started (Earlier Past Sequence)',
                        'vocab' => [
                            ['en' => 'the client had used our service', 'id' => 'pelanggan telah menggunakan layanan kami'],
                            ['en' => 'for five years', 'id' => 'selama lima tahun'],
                            ['en' => 'started complaining about the price', 'id' => 'mulai mengeluhkan harga'],
                        ],
                        'options' => [
                            'The client had used our service for five years before he started complaining about the price.',
                            'The client has used our service for five years before he started complaining about the price.',
                            'The client used our service for five years before he had started complaining about the price.',
                            'The client had use our service for five years before he started complaining about the price.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan menggunakan layanan ('had used') mendahului keluhan harga ('started'). Past Participle dari use adalah 'used'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Perusahaan itu telah menarik produk tersebut dari pasar sebelum regulator mengeluarkan larangan resmi.',
                        'target_word' => 'had recalled ... issued (Prior Action)',
                        'vocab' => [
                            ['en' => 'recalled the product', 'id' => 'menarik produk'],
                            ['en' => 'the regulator issued', 'id' => 'regulator mengeluarkan'],
                            ['en' => 'an official ban', 'id' => 'larangan resmi'],
                        ],
                        'options' => [
                            'The company had recalled the product from the market before the regulator issued an official ban.',
                            'The company has recalled the product from the market before the regulator issued an official ban.',
                            'The company recalled the product from the market before the regulator had issued an official ban.',
                            'The company had recall the product from the market before the regulator issued an official ban.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penarikan produk mendahului larangan resmi: 'had recalled' disusul 'issued'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Menjelang usia tiga puluh tahun, ia telah mendirikan dua perusahaan rintisan.',
                        'target_word' => 'had founded (Completed Before Past Milestone)',
                        'vocab' => [
                            ['en' => 'by the age of thirty', 'id' => 'menjelang usia tiga puluh tahun'],
                            ['en' => 'had founded two startups', 'id' => 'telah mendirikan dua perusahaan rintisan'],
                        ],
                        'options' => [
                            'By the age of thirty, he had founded two startups.',
                            'By the age of thirty, he has founded two startups.',
                            'By the age of thirty, he founded two startups.',
                            'By the age of thirty, he was founded two startups.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa batas waktu lampau 'By the age of thirty' mewajibkan Past Perfect 'had founded'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Desainer itu telah membuat tiga sketsa berbeda sebelum memilih yang terbaik untuk klien.',
                        'target_word' => 'had made ... chose (Sequential Decision)',
                        'vocab' => [
                            ['en' => 'the designer had made', 'id' => 'desainer telah membuat'],
                            ['en' => 'three different sketches', 'id' => 'tiga sketsa berbeda'],
                            ['en' => 'chose the best one for the client', 'id' => 'memilih yang terbaik untuk klien'],
                        ],
                        'options' => [
                            'The designer had made three different sketches before choosing the best one for the client.',
                            'The designer has made three different sketches before choosing the best one for the client.',
                            'The designer made three different sketches before he had chosen the best one for the client.',
                            'The designer had make three different sketches before choosing the best one for the client.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pembuatan ketiga sketsa selesai lebih dahulu ('had made') sebelum pemilihan sketsa terbaik.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Ketika juri mulai menilai, panitia telah menyusun semua karya peserta dengan rapi.',
                        'target_word' => 'had arranged ... began (Past Perfect with When)',
                        'vocab' => [
                            ['en' => 'judges began scoring', 'id' => 'juri mulai menilai'],
                            ['en' => 'the committee had arranged', 'id' => 'panitia telah menyusun'],
                            ["en" => "all the participants' entries", "id" => "semua karya peserta"],
                        ],
                        'options' => [
                            "When the judges began scoring, the committee had arranged all the participants' entries neatly.",
                            "When the judges began scoring, the committee has arranged all the participants' entries neatly.",
                            "When the judges had begun scoring, the committee arranged all the participants' entries neatly.",
                            "When the judges began scoring, the committee was arranged all the participants' entries neatly.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penyusunan karya selesai sebelum juri mulai menilai: 'had arranged' + 'began'.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Jumlah pelanggan toko daring itu telah bertambah dua kali lipat sebelum kompetitor baru masuk ke pasar.',
                        'target_word' => 'had doubled ... entered (Past Perfect + Past Simple)',
                        'vocab' => [
                            ['en' => "the online store's customer base had doubled", 'id' => 'jumlah pelanggan toko daring telah bertambah dua kali lipat'],
                            ['en' => 'a new competitor entered the market', 'id' => 'kompetitor baru masuk ke pasar'],
                        ],
                        'options' => [
                            "The online store's customer base had doubled before a new competitor entered the market.",
                            "The online store's customer base has doubled before a new competitor entered the market.",
                            "The online store's customer base doubled before a new competitor had entered the market.",
                            "The online store's customer base had double before a new competitor entered the market.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertambahan pelanggan terjadi lebih dahulu ('had doubled') sebelum kompetitor masuk ('entered').",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Setelah tim telah mengumpulkan seluruh umpan balik pengguna, mereka merombak desain aplikasi itu.',
                        'target_word' => 'had gathered ... redesigned (After + Past Perfect)',
                        'vocab' => [
                            ['en' => 'had gathered all the user feedback', 'id' => 'telah mengumpulkan seluruh umpan balik pengguna'],
                            ['en' => 'redesigned the app', 'id' => 'merombak desain aplikasi'],
                        ],
                        'options' => [
                            'After the team had gathered all the user feedback, they redesigned the app.',
                            'After the team has gathered all the user feedback, they redesigned the app.',
                            'After the team gathered all the user feedback, they had redesigned the app.',
                            'After the team were gathered all the user feedback, they redesigned the app.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengumpulan umpan balik selesai terlebih dahulu ('had gathered'), baru kemudian merombak desain ('redesigned').",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Koki itu telah mencicipi sup tersebut tiga kali sebelum menambahkan bumbu lagi.',
                        'target_word' => 'had tasted ... added (Repeated Past Action Before Mark)',
                        'vocab' => [
                            ['en' => 'had tasted the soup', 'id' => 'telah mencicipi sup'],
                            ['en' => 'three times', 'id' => 'tiga kali'],
                            ['en' => 'added more seasoning', 'id' => 'menambahkan bumbu lagi'],
                        ],
                        'options' => [
                            'The chef had tasted the soup three times before adding more seasoning.',
                            'The chef has tasted the soup three times before adding more seasoning.',
                            'The chef tasted the soup three times before adding more seasoning had been.',
                            'The chef had taste the soup three times before adding more seasoning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Mencicipi 3 kali selesai lebih dahulu ('had tasted') sebelum menambahkan bumbu.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-nominal',
                'name' => '1.12.4 Past Perfect Nominal: States & Conditions Before a Past Moment',
                'code' => '1.12.4',
                'concept_title' => 'Past Perfect Nominal: Keadaan & Sifat Sebelum Suatu Momen Lampau',
                'concept_description' => "Past Perfect Nominal (had been + Adjective / Noun / Prepositional Phrase) digunakan untuk menyatakan keadaan, status, atau sifat subjek yang telah berlangsung selama kurun waktu tertentu SEBELUM titik waktu masa lalu tertentu tiba. Kata 'been' wajib disisipkan setelah 'had'.",
                'description' => "Past Perfect Nominal (had been + Adjective / Noun / Prepositional Phrase) digunakan untuk menyatakan keadaan, status, atau sifat subjek yang telah berlangsung selama kurun waktu tertentu SEBELUM titik waktu masa lalu tertentu tiba. Kata 'been' wajib disisipkan setelah 'had'.",
                'formula' => 'Subject + had been + Adjective / Noun Phrase / Prepositional Phrase + before / when Clause',
                'rules' => [
                    'Pola rumus baku: Subject + had been + Complement.',
                    "Semua jenis subjek (tunggal dan jamak) menggunakan 'had been'.",
                    'Menunjukkan kondisi lampau yang bertahan hingga suatu momen interupsi masa lampau terjadi.',
                    "Dilarang meniadakan 'been' (*The client had unhappy adalah SALAH BESAR).",
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Klien itu telah tidak puas selama berbulan-bulan sebelum akhirnya ia mengajukan keluhan resmi.',
                        'target_word' => 'had been unhappy (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'the client had been unhappy', 'id' => 'klien telah tidak puas'],
                            ['en' => 'for months', 'id' => 'selama berbulan-bulan'],
                            ['en' => 'filed a formal complaint', 'id' => 'mengajukan keluhan resmi'],
                        ],
                        'options' => [
                            'The client had been unhappy for months before finally filing a formal complaint.',
                            'The client has been unhappy for months before finally filing a formal complaint.',
                            'The client had unhappy for months before finally filing a formal complaint.',
                            'The client was been unhappy for months before finally filing a formal complaint.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi tidak puas berlangsung sebelum keluhan diajukan, sehingga wajib 'had been unhappy'. Opsi C salah karena menghilangkan 'been'.",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Gedung itu telah menjadi kantor pusat perusahaan selama bertahun-tahun sebelum mereka pindah lokasi.',
                        'target_word' => 'had been the headquarters (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'the building had been', 'id' => 'gedung telah menjadi'],
                            ['en' => 'the company headquarters', 'id' => 'kantor pusat perusahaan'],
                            ['en' => 'they relocated', 'id' => 'mereka pindah lokasi'],
                        ],
                        'options' => [
                            'The building had been the company headquarters for years before they relocated.',
                            'The building has been the company headquarters for years before they relocated.',
                            'The building was been the company headquarters for years before they relocated.',
                            'The building had the company headquarters for years before they relocated.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Status kantor pusat mendahului kepindahan lampau: 'had been the company headquarters'.",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Kedua mesin itu telah dalam kondisi baik sebelum bagian cadangannya habis.',
                        'target_word' => 'had been in good condition (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'both machines had been in good condition', 'id' => 'kedua mesin telah dalam kondisi baik'],
                            ['en' => 'the spare parts ran out', 'id' => 'bagian cadangannya habis'],
                        ],
                        'options' => [
                            'Both machines had been in good condition before the spare parts ran out.',
                            'Both machines have been in good condition before the spare parts ran out.',
                            'Both machines had in good condition before the spare parts ran out.',
                            'Both machines were been in good condition before the spare parts ran out.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'machines' menggunakan 'had been in good condition' sebelum bagian cadangan habis ('ran out').",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Paman telah menjadi direktur cabang selama sepuluh tahun ketika ia memutuskan untuk pensiun.',
                        'target_word' => 'had been the branch director (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'had been the branch director', 'id' => 'telah menjadi direktur cabang'],
                            ['en' => 'for ten years', 'id' => 'selama sepuluh tahun'],
                            ['en' => 'decided to retire', 'id' => 'memutuskan untuk pensiun'],
                        ],
                        'options' => [
                            'My uncle had been the branch director for ten years when he decided to retire.',
                            'My uncle has been the branch director for ten years when he decided to retire.',
                            'My uncle was been the branch director for ten years when he decided to retire.',
                            'My uncle had the branch director for ten years when he decided to retire.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jabatan selama 10 tahun tersebut berlangsung sebelum keputusan pensiun lampau ('decided'): 'had been the branch director'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Suasana ruang rapat telah tegang selama beberapa menit sebelum direktur masuk.',
                        'target_word' => 'had been tense (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'meeting room had been tense', 'id' => 'ruang rapat telah tegang'],
                            ['en' => 'for a few minutes', 'id' => 'selama beberapa menit'],
                            ['en' => 'the director walked in', 'id' => 'direktur masuk'],
                        ],
                        'options' => [
                            'The meeting room had been tense for a few minutes before the director walked in.',
                            'The meeting room have been tense for a few minutes before the director walked in.',
                            'The meeting room had tense for a few minutes before the director walked in.',
                            'The meeting room were been tense for a few minutes before the director walked in.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi tegang ('had been tense') mendahului masuknya direktur lampau ('walked in').",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Kebijakan kerja jarak jauh itu telah berlaku selama satu tahun sebelum diganti dengan sistem hibrida.',
                        'target_word' => 'had been in effect (Past Perfect Nominal with Prepositional Phrase)',
                        'vocab' => [
                            ['en' => 'remote work policy had been in effect', 'id' => 'kebijakan kerja jarak jauh telah berlaku'],
                            ['en' => 'for one year', 'id' => 'selama satu tahun'],
                            ['en' => 'replaced with a hybrid system', 'id' => 'diganti dengan sistem hibrida'],
                        ],
                        'options' => [
                            'The remote work policy had been in effect for one year before it was replaced with a hybrid system.',
                            'The remote work policy has been in effect for one year before it was replaced with a hybrid system.',
                            'The remote work policy had in effect for one year before it was replaced with a hybrid system.',
                            'The remote work policy was in effect for one year before it had replaced with a hybrid system.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa 'in effect' memerlukan 'had been' untuk menyatakan masa berlaku sebelum penggantian lampau.",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Harga bahan baku telah mahal sejak beberapa minggu sebelum pemasok baru ditemukan.',
                        'target_word' => 'had been expensive (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'raw material prices had been expensive', 'id' => 'harga bahan baku telah mahal'],
                            ['en' => 'a new supplier was found', 'id' => 'pemasok baru ditemukan'],
                        ],
                        'options' => [
                            'Raw material prices had been expensive for several weeks before a new supplier was found.',
                            'Raw material prices has been expensive for several weeks before a new supplier was found.',
                            'Raw material prices had expensive for several weeks before a new supplier was found.',
                            'Raw material prices were been expensive for several weeks before a new supplier was found.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi harga mahal mendahului ditemukannya pemasok baru lampau: 'had been expensive'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Para peserta pelatihan telah kelelahan selama dua jam sebelum sesi istirahat akhirnya diumumkan.',
                        'target_word' => 'had been exhausted (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'the trainees had been exhausted', 'id' => 'para peserta pelatihan telah kelelahan'],
                            ['en' => 'for two hours', 'id' => 'selama dua jam'],
                            ['en' => 'the break session was finally announced', 'id' => 'sesi istirahat akhirnya diumumkan'],
                        ],
                        'options' => [
                            'The trainees had been exhausted for two hours before the break session was finally announced.',
                            'The trainees have been exhausted for two hours before the break session was finally announced.',
                            'The trainees had exhausted for two hours before the break session was finally announced.',
                            'The trainees were been exhausted for two hours before the break session was finally announced.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'trainees' berpasangan dengan 'had been exhausted'.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Jalan tol itu telah padat sepanjang hari ketika kami akhirnya memutuskan untuk mengambil rute alternatif.',
                        'target_word' => 'had been congested (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'toll road had been congested', 'id' => 'jalan tol telah padat'],
                            ['en' => 'all day', 'id' => 'sepanjang hari'],
                            ['en' => 'we finally decided to take an alternative route', 'id' => 'kami akhirnya memutuskan mengambil rute alternatif'],
                        ],
                        'options' => [
                            'The toll road had been congested all day when we finally decided to take an alternative route.',
                            'The toll road has been congested all day when we finally decided to take an alternative route.',
                            'The toll road had congested all day when we finally decided to take an alternative route.',
                            'The toll road was been congested all day when we finally decided to take an alternative route.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Status padat sepanjang hari mendahului keputusan mengambil rute alternatif lampau: 'had been congested'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Kinerja penjualan tim kami telah sangat baik sebelum kuartal terakhir diumumkan secara resmi.',
                        'target_word' => 'had been excellent (Past Perfect Nominal)',
                        'vocab' => [
                            ["en" => "our team's sales performance had been excellent", "id" => "kinerja penjualan tim kami telah sangat baik"],
                            ['en' => 'the final quarter was officially announced', 'id' => 'kuartal terakhir diumumkan secara resmi'],
                        ],
                        'options' => [
                            "Our team's sales performance had been excellent before the final quarter was officially announced.",
                            "Our team's sales performance have been excellent before the final quarter was officially announced.",
                            "Our team's sales performance had excellent before the final quarter was officially announced.",
                            "Our team's sales performance were been excellent before the final quarter was officially announced.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Our team's sales performance had been excellent' mendahului momen pengumuman pasif lampau 'was announced'.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-passive',
                'name' => '1.12.5 Past Perfect Passive: Things Completed Before a Past Moment',
                'code' => '1.12.5',
                'concept_title' => 'Past Perfect Pasif: Sesuatu yang Sudah Selesai Sebelum Suatu Momen Lampau',
                'concept_description' => 'Past Perfect Pasif (had been + V3) digunakan ketika subjek kalimat menerima tindakan yang telah tuntas dilakukan sebelum peristiwa masa lampau lainnya terjadi. Cocok dipakai untuk menegaskan bahwa sesuatu sudah selesai dikerjakan sebelum momen penting berikutnya tiba -- umum dalam konteks bisnis, proyek, dan layanan.',
                'description' => 'Past Perfect Pasif (had been + V3) digunakan ketika subjek kalimat menerima tindakan yang telah tuntas dilakukan sebelum peristiwa masa lampau lainnya terjadi. Cocok dipakai untuk menegaskan bahwa sesuatu sudah selesai dikerjakan sebelum momen penting berikutnya tiba -- umum dalam konteks bisnis, proyek, dan layanan.',
                'formula' => 'Subject (Patient) + had been + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                'rules' => [
                    'Rumus baku: Subject + had been + Past Participle (V3).',
                    'Jangan tertukar dengan Past Continuous Pasif (was/were being + V3) atau Present Perfect Pasif (have/has been + V3).',
                    "Berlaku sama untuk subjek tunggal dan jamak ('had been + V3').",
                    'Menegaskan bahwa sesuatu sudah selesai dikerjakan sebelum peristiwa berikutnya dimulai.',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Gedung itu telah dievakuasi oleh petugas keamanan sebelum inspeksi dimulai.',
                        'target_word' => 'had been evacuated ... started (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'building had been evacuated', 'id' => 'gedung telah dievakuasi'],
                            ['en' => 'security staff', 'id' => 'petugas keamanan'],
                            ['en' => 'inspection started', 'id' => 'inspeksi dimulai'],
                        ],
                        'options' => [
                            'The building had been evacuated by the security staff before the inspection started.',
                            'The building has been evacuated by the security staff before the inspection started.',
                            'The building was being evacuated by the security staff before the inspection started.',
                            'The building had evacuated by the security staff before the inspection started.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Evakuasi gedung terjadi dan selesai terlebih dahulu ('had been evacuated') sebelum inspeksi dimulai ('started'). Opsi D salah karena bermakna aktif.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Semua faktur telah dikonfirmasi sebelum laporan akhir bulan dikirim ke manajemen.',
                        'target_word' => 'had been confirmed ... was sent (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'all the invoices had been confirmed', 'id' => 'semua faktur telah dikonfirmasi'],
                            ['en' => 'the month-end report was sent to management', 'id' => 'laporan akhir bulan dikirim ke manajemen'],
                        ],
                        'options' => [
                            'All the invoices had been confirmed before the month-end report was sent to management.',
                            'All the invoices have been confirmed before the month-end report was sent to management.',
                            'All the invoices had being confirmed before the month-end report was sent to management.',
                            'All the invoices were confirmed before the month-end report had sent to management.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Konfirmasi faktur selesai lebih awal ('had been confirmed') mendahului pengiriman laporan ('was sent').",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Rencana itu telah dibahas berkali-kali sebelum direktur akhirnya menyetujuinya.',
                        'target_word' => 'had been discussed (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'plan had been discussed', 'id' => 'rencana telah dibahas'],
                            ['en' => 'many times', 'id' => 'berkali-kali'],
                            ['en' => 'the director finally approved it', 'id' => 'direktur akhirnya menyetujuinya'],
                        ],
                        'options' => [
                            'The plan had been discussed many times before the director finally approved it.',
                            'The plan has been discussed many times before the director finally approved it.',
                            'The plan was being discussed many times before the director finally approved it.',
                            'The plan had discussed many times before the director finally approved it.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The plan had been discussed' (pasif masa lalu lebih lampau) mendahului tindakan menyetujuinya ('approved').",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Paket itu telah dibungkus rapi sebelum dimasukkan ke dalam kotak pengiriman.',
                        'target_word' => 'had been wrapped ... was placed (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'package had been wrapped', 'id' => 'paket telah dibungkus'],
                            ['en' => 'neatly', 'id' => 'rapi'],
                            ['en' => 'placed into the shipping box', 'id' => 'dimasukkan ke dalam kotak pengiriman'],
                        ],
                        'options' => [
                            'The package had been wrapped neatly before it was placed into the shipping box.',
                            'The package has been wrapped neatly before it was placed into the shipping box.',
                            'The package had wrapped neatly before it was placed into the shipping box.',
                            'The package had being wrapped neatly before it was placed into the shipping box.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pembungkusan paket terjadi lebih awal ('had been wrapped') sebelum dimasukkan ke kotak ('was placed').",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Anggaran kami telah dibagi merata ke setiap divisi sebelum kuartal itu berakhir.',
                        'target_word' => 'had been divided (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'our budget', 'id' => 'anggaran kami'],
                            ['en' => 'divided evenly among the divisions', 'id' => 'dibagi merata ke setiap divisi'],
                            ['en' => 'the quarter ended', 'id' => 'kuartal itu berakhir'],
                        ],
                        'options' => [
                            'Our budget had been divided evenly among the divisions before the quarter ended.',
                            'Our budget have been divided evenly among the divisions before the quarter ended.',
                            'Our budget was being divided evenly among the divisions before the quarter ended.',
                            'Our budget had divided evenly among the divisions before the quarter ended.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'budget' berpasangan dengan 'had been divided'.",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Dua puluh undangan telah dikirim sebelum acara itu dibatalkan sementara.',
                        'target_word' => 'had been sent ... was canceled (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'twenty invitations had been sent', 'id' => '20 undangan telah dikirim'],
                            ['en' => 'event was temporarily canceled', 'id' => 'acara dibatalkan sementara'],
                        ],
                        'options' => [
                            'Twenty invitations had been sent before the event was temporarily canceled.',
                            'Twenty invitations have been sent before the event was temporarily canceled.',
                            'Twenty invitations were being sent before the event was temporarily canceled.',
                            'Twenty invitations had sent before the event was temporarily canceled.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengiriman 20 undangan selesai mendahului pembatalan acara lampau: 'had been sent'.",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Peralatan produksi telah diperiksa secara menyeluruh sebelum sesi produksi kedua dimulai.',
                        'target_word' => 'had been inspected (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'production equipment had been inspected', 'id' => 'peralatan produksi telah diperiksa'],
                            ['en' => 'thoroughly', 'id' => 'secara menyeluruh'],
                            ['en' => 'second production run began', 'id' => 'sesi produksi kedua dimulai'],
                        ],
                        'options' => [
                            'The production equipment had been inspected thoroughly before the second production run began.',
                            'The production equipment have been inspected thoroughly before the second production run began.',
                            'The production equipment was being inspected thoroughly before the second production run began.',
                            'The production equipment had inspected thoroughly before the second production run began.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemeriksaan selesai mendahului sesi produksi kedua: 'had been inspected'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Jalur kereta baru telah dibangun di kota itu setahun sebelum banjir besar melanda.',
                        'target_word' => 'had been built (Past Perfect Passive with Time Gap)',
                        'vocab' => [
                            ['en' => 'new rail line had been built', 'id' => 'jalur kereta baru telah dibangun'],
                            ['en' => 'one year before', 'id' => 'setahun sebelumnya'],
                            ['en' => 'big flood struck', 'id' => 'banjir besar melanda'],
                        ],
                        'options' => [
                            'A new rail line had been built in the city a year before the big flood struck.',
                            'A new rail line has been built in the city a year before the big flood struck.',
                            'A new rail line was being built in the city a year before the big flood struck.',
                            'A new rail line had built in the city a year before the big flood struck.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pembangunan jalur kereta selesai setahun sebelum banjir lampau terjadi: 'had been built'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Daftar pemasok telah diperiksa oleh tim pengadaan sebelum dibagikan kepada direksi.',
                        'target_word' => 'had been reviewed ... was shared (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'supplier list had been reviewed', 'id' => 'daftar pemasok telah diperiksa'],
                            ['en' => 'procurement team', 'id' => 'tim pengadaan'],
                            ['en' => 'shared with the board', 'id' => 'dibagikan kepada direksi'],
                        ],
                        'options' => [
                            'The supplier list had been reviewed by the procurement team before it was shared with the board.',
                            'The supplier list has been reviewed by the procurement team before it was shared with the board.',
                            'The supplier list had reviewed by the procurement team before it was shared with the board.',
                            'The supplier list was being reviewed by the procurement team before it was shared with the board.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemeriksaan daftar tuntas sebelum dibagikan: 'had been reviewed'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Jadwal shift karyawan telah disetujui oleh supervisor sebelum periode cuti dimulai.',
                        'target_word' => 'had been approved (Past Perfect Passive)',
                        'vocab' => [
                            ["en" => "employee shift schedule had been approved", "id" => "jadwal shift karyawan telah disetujui"],
                            ['en' => 'supervisor', 'id' => 'supervisor'],
                            ['en' => 'the leave period began', 'id' => 'periode cuti dimulai'],
                        ],
                        'options' => [
                            "The employee shift schedule had been approved by the supervisor before the leave period began.",
                            "The employee shift schedule has been approved by the supervisor before the leave period began.",
                            "The employee shift schedule had approved by the supervisor before the leave period began.",
                            "The employee shift schedule was being approved by the supervisor before the leave period began.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Persetujuan jadwal diselesaikan sebelum periode cuti mulai: 'had been approved'.",
                    ],
                ]
            ],
            [
                'id' => 'timeline-connectors-sequencing',
                'name' => '1.12.6 Timeline Connectors & Conjunctions: By the time, Prior to, Once, When, While',
                'code' => '1.12.6',
                'concept_title' => 'Penghubung Linimasa: By the time, Prior to, When, While',
                'concept_description' => "Menyusun cerita yang runtut membutuhkan konjungsi waktu yang tepat. Pola 'By the time + Simple Past, Subject + Past Perfect' menandai bahwa tindakan telah selesai sebelum batas waktu tercapai. Sebaliknya, 'While + Past Continuous' menandai durasi simultan. Memilih tenses yang selaras dengan kata hubung adalah kunci laporan atau cerita yang jelas, terutama dalam konteks pekerjaan dan proyek.",
                'description' => "Menyusun cerita yang runtut membutuhkan konjungsi waktu yang tepat. Pola 'By the time + Simple Past, Subject + Past Perfect' menandai bahwa tindakan telah selesai sebelum batas waktu tercapai. Sebaliknya, 'While + Past Continuous' menandai durasi simultan. Memilih tenses yang selaras dengan kata hubung adalah kunci laporan atau cerita yang jelas, terutama dalam konteks pekerjaan dan proyek.",
                'formula' => 'By the time + S + V2 (Past), S + had + V3 / had been V3 | While + S + was/were V-ing, S + V2',
                'rules' => [
                    "'By the time' + Simple Past mensyaratkan induk kalimat berbentuk Past Perfect ('By the time we arrived, the meeting had already ended').",
                    "'Prior to' adalah frasa formal yang diikuti Noun Phrase atau Gerund V-ing ('Prior to leaving, we had finalized the budget').",
                    "'While' mengawali klausa berdurasi sedang berlangsung (Past Continuous).",
                    "'Once' sebagai konjungsi lampau menghubungkan aksi tuntas dengan aksi berikutnya.",
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Menjelang saat kami tiba di kantor, sebagian besar rapat telah berakhir.',
                        'target_word' => 'By the time ... had ended (Timeline Connector: By the time)',
                        'vocab' => [
                            ['en' => 'by the time we arrived', 'id' => 'menjelang saat kami tiba'],
                            ['en' => 'most of the meeting had already ended', 'id' => 'sebagian besar rapat telah berakhir'],
                        ],
                        'options' => [
                            'By the time we arrived at the office, most of the meeting had already ended.',
                            'By the time we arrived at the office, most of the meeting has already ended.',
                            'By the time we had arrived at the office, most of the meeting was already ended.',
                            'By the time we arrived at the office, most of the meeting was already being ended so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola baku 'By the time + Simple Past ('arrived')' mewajibkan induk kalimat menggunakan Past Perfect ('had ended').",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Sebelum berangkat ke lokasi proyek, kami telah mengemas semua peralatan yang diperlukan.',
                        'target_word' => 'Prior to leaving ... had packed (Prepositional Connectors)',
                        'vocab' => [
                            ['en' => 'prior to leaving for the project site', 'id' => 'sebelum berangkat ke lokasi proyek'],
                            ['en' => 'had packed all the necessary equipment', 'id' => 'telah mengemas semua peralatan yang diperlukan'],
                        ],
                        'options' => [
                            'Prior to leaving for the project site, we had packed all the necessary equipment.',
                            'Prior to leaving for the project site, we has packed all the necessary equipment.',
                            'Prior to leaving for the project site, we packed had all the necessary equipment.',
                            'Prior to leaving for the project site, we have packed all the necessary equipment back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa 'Prior to leaving' mendahului tindakan lampau, sehingga induk kalimat memakai 'had packed'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Menjelang usia dua puluh lima tahun, ia telah bekerja di tiga perusahaan berbeda.',
                        'target_word' => 'By the age of twenty-five ... had worked (Timeline Milestone)',
                        'vocab' => [
                            ['en' => 'by the age of twenty-five', 'id' => 'menjelang usia dua puluh lima tahun'],
                            ['en' => 'had worked at three different companies', 'id' => 'telah bekerja di tiga perusahaan berbeda'],
                        ],
                        'options' => [
                            'By the age of twenty-five, she had worked at three different companies.',
                            'By the age of twenty-five, she has worked at three different companies.',
                            'By the age of twenty-five, she worked had at three different companies.',
                            'By the age of twenty-five, she have worked at three different companies back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Batas waktu lampau 'By the age of twenty-five' mewajibkan Past Perfect 'had worked'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Sementara akuntan sedang memeriksa angka-angka itu, direktur mengumumkan hasil kuartal terbaru.',
                        'target_word' => 'While ... was checking ... announced (Simultaneous vs Interruption)',
                        'vocab' => [
                            ['en' => 'the accountant was checking', 'id' => 'akuntan sedang memeriksa'],
                            ['en' => 'the figures', 'id' => 'angka-angka'],
                            ['en' => 'the director announced the latest quarterly results', 'id' => 'direktur mengumumkan hasil kuartal terbaru'],
                        ],
                        'options' => [
                            'While the accountant was checking the figures, the director announced the latest quarterly results.',
                            'While the accountant were checking the figures, the director announced the latest quarterly results.',
                            'While the accountant was check the figures, the director announced the latest quarterly results.',
                            'While the accountant was checking the figures, the director was announced the latest quarterly results.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'While' + Past Continuous tunggal 'was checking', disela oleh tindakan 'announced'.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Menjelang saat kontrak diserahkan, kami telah merevisi persyaratannya sebanyak dua kali.',
                        'target_word' => 'By the time ... had revised (By the time Sequence)',
                        'vocab' => [
                            ['en' => 'by the time the contract was submitted', 'id' => 'menjelang saat kontrak diserahkan'],
                            ['en' => 'had revised the terms twice', 'id' => 'telah merevisi persyaratannya dua kali'],
                        ],
                        'options' => [
                            'By the time the contract was submitted, we had revised the terms twice.',
                            'By the time the contract was submitted, we has revised the terms twice.',
                            'By the time the contract had been submitted, we revised the terms twice.',
                            'By the time the contract was submitted, we revised had the terms twice.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the time' + Simple Past Pasif ('was submitted'), induk kalimat memakai Past Perfect 'had revised'.",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Sebelum presentasi dilakukan, kami telah berlatih menyampaikan materi di ruang kosong.',
                        'target_word' => 'Prior to giving ... had practiced (Prior to + Gerund)',
                        'vocab' => [
                            ['en' => 'prior to giving the presentation', 'id' => 'sebelum melakukan presentasi'],
                            ['en' => 'had practiced delivering the material in an empty room', 'id' => 'telah berlatih menyampaikan materi di ruang kosong'],
                        ],
                        'options' => [
                            'Prior to giving the presentation, we had practiced delivering the material in an empty room.',
                            'Prior to giving the presentation, we has practiced delivering the material in an empty room.',
                            'Prior to giving the presentation, we had practice delivering the material in an empty room.',
                            'Prior to giving the presentation, we have practiced delivering the material in an empty room back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Latihan selesai lebih dulu sebelum presentasi: 'had practiced'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Begitu direktur menyetujui anggaran itu, tim segera memesan peralatan untuk proyek.',
                        'target_word' => 'Once ... approved ... ordered (Immediate Sequence with Once)',
                        'vocab' => [
                            ['en' => 'once the director approved the budget', 'id' => 'begitu direktur menyetujui anggaran'],
                            ['en' => 'the team ordered equipment for the project', 'id' => 'tim segera memesan peralatan untuk proyek'],
                        ],
                        'options' => [
                            'Once the director approved the budget, the team ordered equipment for the project.',
                            'Once the director had approved the budget, the team orders equipment for the project.',
                            'Once the director approved the budget, the team were ordered equipment for the project.',
                            'Once the director will approve the budget, the team ordered equipment for the project.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Dua tindakan berurutan langsung yang saling terkait cepat di masa lalu menggunakan Simple Past: 'approved' disusul 'ordered'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Menjelang akhir tahun itu, strategi pemasaran digital telah mengubah pola penjualan perusahaan kami secara signifikan.',
                        'target_word' => 'By the end of ... had changed (Milestone Past Perfect)',
                        'vocab' => [
                            ['en' => 'by the end of that year', 'id' => 'menjelang akhir tahun itu'],
                            ['en' => 'digital marketing strategy had changed', 'id' => 'strategi pemasaran digital telah mengubah'],
                            ["en" => "our company's sales pattern", "id" => "pola penjualan perusahaan kami"],
                        ],
                        'options' => [
                            "By the end of that year, the digital marketing strategy had changed our company's sales pattern significantly.",
                            "By the end of that year, the digital marketing strategy has changed our company's sales pattern significantly.",
                            "By the end of that year, the digital marketing strategy changed had our company's sales pattern significantly.",
                            "By the end of that year, the digital marketing strategy was changed our company's sales pattern significantly.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the end of that year' adalah penanda waktu pembatas masa lampau yang mewajibkan 'had changed'.",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Sementara kontrak-kontrak baru sedang dinegosiasikan, divisi lain terus menjalankan operasional seperti biasa.',
                        'target_word' => 'While ... were being negotiated ... kept running (Simultaneous Ongoing Passive + Active)',
                        'vocab' => [
                            ['en' => 'new contracts were being negotiated', 'id' => 'kontrak-kontrak baru sedang dinegosiasikan'],
                            ['en' => 'the other division kept running operations as usual', 'id' => 'divisi lain terus menjalankan operasional seperti biasa'],
                        ],
                        'options' => [
                            'While the new contracts were being negotiated, the other division kept running operations as usual.',
                            'While the new contracts was being negotiated, the other division kept running operations as usual.',
                            'While the new contracts were been negotiated, the other division kept running operations as usual.',
                            'While the new contracts were negotiating, the other division kept running operations as usual.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'While' memakai pasif continuous jamak 'were being negotiated', diiringi aksi utama 'kept running'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Sebelum dewan direksi memutuskan pemenang tender, kedua kandidat telah mencapai skor yang sama.',
                        'target_word' => 'Before the board decided ... had reached (Earlier Past Agreement)',
                        'vocab' => [
                            ['en' => 'board of directors decided the tender winner', 'id' => 'dewan direksi memutuskan pemenang tender'],
                            ['en' => 'both candidates had reached an equal score', 'id' => 'kedua kandidat telah mencapai skor yang sama'],
                        ],
                        'options' => [
                            'Before the board of directors decided the tender winner, both candidates had reached an equal score.',
                            'Before the board of directors decided the tender winner, both candidates has reached an equal score.',
                            'Before the board of directors had decided the tender winner, both candidates reached an equal score.',
                            'Before the board of directors decided the tender winner, both candidates reached had an equal score.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Skor yang sama tercapai lebih dahulu ('had reached') sebelum dewan direksi memutuskan ('decided').",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-continuous',
                'name' => '1.12.7 Past Perfect Continuous: Ongoing Duration Before a Past Event',
                'code' => '1.12.7',
                'concept_title' => 'Past Perfect Continuous: Durasi Tindakan Lampau Sebelum Terjadinya Peristiwa Lain',
                'concept_description' => "Past Perfect Continuous (had been + Verb-ing) digunakan untuk menekankan lamanya durasi suatu tindakan yang sedang berlangsung dan berakumulasi di masa lalu sebelum titik waktu atau peristiwa lampau lainnya terjadi. Tense ini sangat umum untuk menyoroti berapa lama sesuatu sudah berlangsung sebelum suatu kejadian terjadi ('The negotiations had been going on for hours before they reached an agreement').",
                'description' => "Past Perfect Continuous (had been + Verb-ing) digunakan untuk menekankan lamanya durasi suatu tindakan yang sedang berlangsung dan berakumulasi di masa lalu sebelum titik waktu atau peristiwa lampau lainnya terjadi. Tense ini sangat umum untuk menyoroti berapa lama sesuatu sudah berlangsung sebelum suatu kejadian terjadi ('The negotiations had been going on for hours before they reached an agreement').",
                'formula' => 'Subject + had been + Verb-ing + for/since (duration) + before / when + Simple Past Clause',
                'rules' => [
                    'Rumus baku: Subject + had been + Verb-ing + duration marker (for two hours, for days).',
                    "Berlaku seragam untuk seluruh subjek tunggal dan jamak ('had been + V-ing').",
                    'Menekankan durasi proses yang sedang berjalan hingga disela atau dihentikan oleh peristiwa lampau (Simple Past).',
                    'Jangan gunakan stative verbs dalam bentuk continuous (*had been knowing adalah SALAH; gunakan Past Perfect simple: had known).',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Negosiasi telah berlangsung selama berjam-jam sebelum akhirnya mereka mencapai kesepakatan.',
                        'target_word' => 'had been going on ... reached (Durative Pre-Past Action)',
                        'vocab' => [
                            ['en' => 'had been going on', 'id' => 'telah berlangsung'],
                            ['en' => 'for hours', 'id' => 'selama berjam-jam'],
                            ['en' => 'they finally reached an agreement', 'id' => 'mereka akhirnya mencapai kesepakatan'],
                        ],
                        'options' => [
                            'The negotiations had been going on for hours before they finally reached an agreement.',
                            'The negotiations have been going on for hours before they finally reached an agreement.',
                            'The negotiations were going on for hours before they finally reached an agreement.',
                            'The negotiations had going on for hours before they finally reached an agreement.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Untuk menekankan proses negosiasi berdurasi panjang ('for hours') yang mendahului tercapainya kesepakatan lampau ('reached'), gunakan Past Perfect Continuous 'had been going on'.",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Server itu telah menunjukkan tanda-tanda gangguan selama berjam-jam sebelum akhirnya mogok total.',
                        'target_word' => 'had been showing ... crashed (Continuous Accumulation Before Failure)',
                        'vocab' => [
                            ['en' => 'server had been showing', 'id' => 'server telah menunjukkan'],
                            ['en' => 'signs of trouble for hours', 'id' => 'tanda-tanda gangguan selama berjam-jam'],
                            ['en' => 'finally crashed completely', 'id' => 'akhirnya mogok total'],
                        ],
                        'options' => [
                            'The server had been showing signs of trouble for hours before it finally crashed completely.',
                            'The server has been showing signs of trouble for hours before it finally crashed completely.',
                            'The server was showing signs of trouble for hours before it finally crashed completely.',
                            'The server had showing signs of trouble for hours before it finally crashed completely.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tanda-tanda gangguan telah berlangsung akumulatif selama berjam-jam sebelum mogok: 'had been showing'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Perusahaan itu telah beroperasi di kota tersebut selama bertahun-tahun sebelum mereka memindahkan kantor pusatnya.',
                        'target_word' => 'had been operating ... relocated (Durative Residence Before Event)',
                        'vocab' => [
                            ['en' => 'had been operating', 'id' => 'telah beroperasi'],
                            ['en' => 'for years', 'id' => 'selama bertahun-tahun'],
                            ['en' => 'relocated their headquarters', 'id' => 'memindahkan kantor pusatnya'],
                        ],
                        'options' => [
                            'The company had been operating in that city for years before they relocated their headquarters.',
                            'The company has been operating in that city for years before they relocated their headquarters.',
                            'The company was operating in that city for years before they relocated their headquarters.',
                            'The company had operating in that city for years before they relocated their headquarters.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Operasional bertahun-tahun mendahului pemindahan kantor pusat lampau: 'had been operating'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Tim audit telah memantau arus kas perusahaan selama berminggu-minggu sebelum laporan akhir diterbitkan.',
                        'target_word' => 'had been monitoring ... was released (Monitoring Duration)',
                        'vocab' => [
                            ['en' => 'audit team had been monitoring', 'id' => 'tim audit telah memantau'],
                            ['en' => 'for weeks', 'id' => 'selama berminggu-minggu'],
                            ['en' => 'final report was released', 'id' => 'laporan akhir diterbitkan'],
                        ],
                        'options' => [
                            "The audit team had been monitoring the company's cash flow for weeks before the final report was released.",
                            "The audit team have been monitoring the company's cash flow for weeks before the final report was released.",
                            "The audit team were monitoring the company's cash flow for weeks before the final report was released.",
                            "The audit team had monitoring the company's cash flow for weeks before the final report was released.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Aktivitas pemantauan berdurasi minggu-minggu sebelum laporan akhir lampau: 'had been monitoring'.",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Permintaan terhadap produk itu telah meningkat secara stabil selama tiga bulan sebelum mencapai rekor penjualan tertinggi.',
                        'target_word' => 'had been rising ... reached (Thermal Rise Duration)',
                        'vocab' => [
                            ['en' => 'demand for the product had been rising', 'id' => 'permintaan produk telah meningkat'],
                            ['en' => 'steadily for three months', 'id' => 'secara stabil selama tiga bulan'],
                            ['en' => 'reached a record sales high', 'id' => 'mencapai rekor penjualan tertinggi'],
                        ],
                        'options' => [
                            'Demand for the product had been rising steadily for three months before reaching a record sales high.',
                            'Demand for the product has been rising steadily for three months before reaching a record sales high.',
                            'Demand for the product was rising steadily for three months before reaching a record sales high.',
                            'Demand for the product had rising steadily for three months before reaching a record sales high.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been rising steadily for three months' menekankan durasi kenaikan permintaan sebelum rekor tercapai.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Divisi IT telah memperingatkan tentang keamanan sistem yang rentan selama berbulan-bulan sebelum akhirnya terjadi peretasan.',
                        'target_word' => 'had been warning ... occurred (Warning Duration)',
                        'vocab' => [
                            ['en' => 'the IT division had been warning', 'id' => 'divisi IT telah memperingatkan'],
                            ['en' => 'about the vulnerable system security for months', 'id' => 'tentang keamanan sistem yang rentan selama berbulan-bulan'],
                            ['en' => 'a breach finally occurred', 'id' => 'akhirnya terjadi peretasan'],
                        ],
                        'options' => [
                            'The IT division had been warning about the vulnerable system security for months before a breach finally occurred.',
                            'The IT division have been warning about the vulnerable system security for months before a breach finally occurred.',
                            'The IT division was warning about the vulnerable system security for months before a breach finally occurred.',
                            'The IT division had warning about the vulnerable system security for months before a breach finally occurred.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been warning ... for months' melukiskan peringatan berkelanjutan sebelum peretasan terjadi.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Mesin itu telah beroperasi tanpa henti selama lima hari sebelum tiba-tiba mati sendiri.',
                        'target_word' => 'had been running ... shut down (Continuous Operation Before Shutdown)',
                        'vocab' => [
                            ['en' => 'machine had been running', 'id' => 'mesin telah beroperasi'],
                            ['en' => 'nonstop for five days', 'id' => 'tanpa henti selama lima hari'],
                            ['en' => 'suddenly shut down by itself', 'id' => 'tiba-tiba mati sendiri'],
                        ],
                        'options' => [
                            'The machine had been running nonstop for five days before it suddenly shut down by itself.',
                            'The machine has been running nonstop for five days before it suddenly shut down by itself.',
                            'The machine was running nonstop for five days before it suddenly shut down by itself.',
                            'The machine had running nonstop for five days before it suddenly shut down by itself.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi operasi 5 hari tanpa henti diungkapkan dengan 'had been running'.",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Kami telah menunggu persetujuan selama empat puluh menit ketika akhirnya email itu datang.',
                        'target_word' => 'had been waiting ... finally arrived (Waiting Duration Before Arrival)',
                        'vocab' => [
                            ['en' => 'we had been waiting for approval', 'id' => 'kami telah menunggu persetujuan'],
                            ['en' => 'for forty minutes', 'id' => 'selama 40 menit'],
                            ['en' => 'the email finally arrived', 'id' => 'email itu akhirnya datang'],
                        ],
                        'options' => [
                            'We had been waiting for approval for forty minutes when the email finally arrived.',
                            'We has been waiting for approval for forty minutes when the email finally arrived.',
                            'We were waiting for approval for forty minutes when the email finally arrived.',
                            'We had waiting for approval for forty minutes when the email finally arrived.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi menunggu sebelum email datang lampau: 'had been waiting'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Kedua rekan bisnis itu telah berdiskusi sepanjang malam sebelum mereka akhirnya mencapai kata sepakat.',
                        'target_word' => 'had been discussing ... reached (Overnight Discussion Duration)',
                        'vocab' => [
                            ['en' => 'the two business partners had been discussing', 'id' => 'kedua rekan bisnis telah berdiskusi'],
                            ['en' => 'all night', 'id' => 'sepanjang malam'],
                            ['en' => 'finally reached a consensus', 'id' => 'akhirnya mencapai kata sepakat'],
                        ],
                        'options' => [
                            'The two business partners had been discussing all night before they finally reached a consensus.',
                            'The two business partners have been discussing all night before they finally reached a consensus.',
                            'The two business partners were discussing all night before they finally reached a consensus.',
                            'The two business partners had discussing all night before they finally reached a consensus.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been discussing ... all night' menekankan proses berdiskusi berjam-jam sebelum akhirnya mencapai kesepakatan.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Permukaan air sungai itu telah naik selama dua jam sebelum tanggul darurat akhirnya jebol.',
                        'target_word' => 'had been rising ... breached (Water Level Duration)',
                        'vocab' => [
                            ['en' => 'river water level had been rising', 'id' => 'permukaan air sungai telah naik'],
                            ['en' => 'for two hours', 'id' => 'selama dua jam'],
                            ['en' => 'emergency levee breached', 'id' => 'tanggul darurat jebol'],
                        ],
                        'options' => [
                            'The river water level had been rising for two hours before the emergency levee finally breached.',
                            'The river water level has been rising for two hours before the emergency levee finally breached.',
                            'The river water level was rising for two hours before the emergency levee finally breached.',
                            'The river water level had rising for two hours before the emergency levee finally breached.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi kenaikan air 2 jam sebelum tanggul jebol: 'had been rising'.",
                    ],
                ]
            ],
            [
                'id' => 'timeline-full-story-synthesis',
                'name' => '1.12.8 Comprehensive Synthesis: Combining Three Past Tenses in One Story',
                'code' => '1.12.8',
                'concept_title' => 'Sintesis Lengkap: Menggabungkan Tiga Bentuk Waktu Lampau dalam Satu Cerita',
                'concept_description' => 'Menggabungkan Simple Past, Past Continuous, dan Past Perfect (aktif maupun pasif) ke dalam satu rangkaian kejadian yang runtut dan mudah dipahami, seperti menceritakan sebuah proyek kerja, acara komunitas, atau situasi sehari-hari yang melibatkan beberapa tahap. Latihan ini melatih kemampuan menyusun urutan kejadian: apa yang sudah terjadi lebih dulu, apa yang sedang berlangsung, dan apa peristiwa utamanya.',
                'description' => 'Menggabungkan Simple Past, Past Continuous, dan Past Perfect (aktif maupun pasif) ke dalam satu rangkaian kejadian yang runtut dan mudah dipahami, seperti menceritakan sebuah proyek kerja, acara komunitas, atau situasi sehari-hari yang melibatkan beberapa tahap. Latihan ini melatih kemampuan menyusun urutan kejadian: apa yang sudah terjadi lebih dulu, apa yang sedang berlangsung, dan apa peristiwa utamanya.',
                'formula' => 'Gabungan Tiga Waktu: Latar Belakang (Past Continuous) + Kejadian Sebelumnya (Past Perfect) + Peristiwa Utama (Simple Past)',
                'rules' => [
                    "Gunakan Past Perfect untuk kejadian yang sudah selesai sebelum kejadian lain di masa lalu ('After the contract had been finalized...').",
                    "Gunakan Past Continuous untuk kegiatan yang sedang berlangsung ('...while the team was testing the prototype...').",
                    "Gunakan Simple Past untuk kejadian utama atau titik waktu tertentu ('...the manager presented the results...').",
                    'Jaga urutan cerita tetap jelas agar pembaca mudah mengikuti apa yang terjadi lebih dulu dan apa yang terjadi kemudian.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Setelah kontrak telah difinalisasi dan ditandatangani, manajer proyek mempresentasikan hasilnya sementara tim teknis sedang menguji prototipe baru.',
                        'target_word' => 'had been finalized ... presented ... was testing (Multi-Tense Sequence)',
                        'vocab' => [
                            ['en' => 'had been finalized and signed', 'id' => 'telah difinalisasi dan ditandatangani'],
                            ['en' => 'presented the results', 'id' => 'mempresentasikan hasilnya'],
                            ['en' => 'technical team was testing the new prototype', 'id' => 'tim teknis sedang menguji prototipe baru'],
                        ],
                        'options' => [
                            'After the contract had been finalized and signed, the project manager presented the results while the technical team was testing the new prototype.',
                            'After the contract have been finalized and signed, the project manager presented the results while the technical team was testing the new prototype.',
                            'After the contract had been finalized and signed, the project manager presented the results while the technical team tested the new prototype.',
                            'After the contract were finalized and signed, the project manager had presented the results while the technical team was testing the new prototype.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kombinasi 3 lapisan waktu: Persiapan awal yang selesai ('had been finalized'), tindakan utama ('presented'), dan latar simultan yang sedang berlangsung ('was testing').",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Meskipun tim telah menguji aplikasi itu beberapa kali sebelumnya, sebuah bug kecil muncul saat demo sedang berlangsung di depan klien.',
                        'target_word' => 'had tested ... appeared ... was taking place (Project Narrative)',
                        'vocab' => [
                            ['en' => 'had tested the app several times before', 'id' => 'telah menguji aplikasi beberapa kali sebelumnya'],
                            ['en' => 'a small bug appeared', 'id' => 'sebuah bug kecil muncul'],
                            ['en' => 'the demo was taking place in front of the client', 'id' => 'demo sedang berlangsung di depan klien'],
                        ],
                        'options' => [
                            'Although the team had tested the app several times before, a small bug appeared while the demo was taking place in front of the client.',
                            'Although the team have tested the app several times before, a small bug appeared while the demo was taking place in front of the client.',
                            'Although the team had tested the app several times before, a small bug was appeared while the demo was taking place in front of the client.',
                            'Although the team tested the app several times before, a small bug appeared while the demo took place in front of the client.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengujian awal selesai ('had tested'), bug tiba-tiba muncul ('appeared'), saat demo sedang berlangsung ('was taking place').",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Sebelum kebijakan kerja jarak jauh yang baru diberlakukan, karyawan telah meminta fleksibilitas jadwal selama bertahun-tahun.',
                        'target_word' => 'was enacted ... had been requesting (Past Passive Boundary + Past Perfect Continuous)',
                        'vocab' => [
                            ['en' => 'new remote work policy was enacted', 'id' => 'kebijakan kerja jarak jauh baru diberlakukan'],
                            ['en' => 'had been requesting schedule flexibility for years', 'id' => 'telah meminta fleksibilitas jadwal selama bertahun-tahun'],
                        ],
                        'options' => [
                            'Before the new remote work policy was enacted, employees had been requesting schedule flexibility for years.',
                            'Before the new remote work policy has been enacted, employees had been requesting schedule flexibility for years.',
                            'Before the new remote work policy was enacted, employees have been requesting schedule flexibility for years.',
                            'Before the new remote work policy was enacted, employees were requesting schedule flexibility for years so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penetapan kebijakan pasif ('was enacted') didahului oleh permintaan berdurasi lama ('had been requesting').",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Ketika direktur tiba di lokasi konferensi, panitia telah menyiapkan semua perlengkapan sementara pembicara sedang melatih presentasinya.',
                        'target_word' => 'arrived ... had prepared ... was rehearsing (Cohesive Event Timeline)',
                        'vocab' => [
                            ['en' => 'director arrived', 'id' => 'direktur tiba'],
                            ['en' => 'had prepared all the equipment', 'id' => 'telah menyiapkan semua perlengkapan'],
                            ['en' => 'speaker was rehearsing their presentation', 'id' => 'pembicara sedang melatih presentasinya'],
                        ],
                        'options' => [
                            'When the director arrived at the conference venue, the committee had prepared all the equipment while the speaker was rehearsing their presentation.',
                            'When the director arrived at the conference venue, the committee has prepared all the equipment while the speaker was rehearsing their presentation.',
                            'When the director had arrived at the conference venue, the committee prepared all the equipment while the speaker was rehearsing their presentation.',
                            'When the director arrived at the conference venue, the committee were prepared all the equipment while the speaker was rehearsing their presentation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedatangan ('arrived') menjumpai persiapan yang sudah tuntas ('had prepared') dan latihan yang masih berlangsung ('was rehearsing').",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Karena penjualan awal telah menunjukkan hasil yang bagus, manajemen menyetujui anggaran tambahan sementara tim pemasaran sedang menyiapkan kampanye baru.',
                        'target_word' => 'had shown ... approved ... was preparing (Business Planning Sequence)',
                        'vocab' => [
                            ['en' => 'had shown good results', 'id' => 'telah menunjukkan hasil yang bagus'],
                            ['en' => 'management approved an additional budget', 'id' => 'manajemen menyetujui anggaran tambahan'],
                            ['en' => 'marketing team was preparing a new campaign', 'id' => 'tim pemasaran sedang menyiapkan kampanye baru'],
                        ],
                        'options' => [
                            'Because the early sales had shown good results, management approved an additional budget while the marketing team was preparing a new campaign.',
                            'Because the early sales has shown good results, management approved an additional budget while the marketing team was preparing a new campaign.',
                            'Because the early sales had shown good results, management had approved an additional budget while the marketing team was preparing a new campaign.',
                            'Because the early sales showed good results, management approved an additional budget while the marketing team prepared a new campaign.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bukti penjualan sudah ada lebih dahulu ('had shown'), persetujuan dikeluarkan ('approved'), sementara tim pemasaran sedang menyiapkan kampanye ('was preparing').",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Menjelang konferensi dimulai, panitia telah memastikan bahwa semua peserta yang sedang mereka daftar ulang sudah berada di ruang utama.',
                        'target_word' => 'began ... had confirmed ... were registering (Multi-Layer Event Narrative)',
                        'vocab' => [
                            ['en' => 'conference began', 'id' => 'konferensi dimulai'],
                            ['en' => 'had confirmed', 'id' => 'telah memastikan'],
                            ['en' => 'participants they were registering', 'id' => 'peserta yang sedang mereka daftar ulang'],
                            ['en' => 'already in the main hall', 'id' => 'sudah berada di ruang utama'],
                        ],
                        'options' => [
                            'By the time the conference began, the organizers had confirmed that all the participants they were registering were already in the main hall.',
                            'By the time the conference began, the organizers has confirmed that all the participants they were registering were already in the main hall.',
                            'By the time the conference had begun, the organizers confirmed that all the participants they were registering were already in the main hall.',
                            'By the time the conference began, the organizers had confirmed that all the participants they registered was already in the main hall.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the time' + Simple Past ('began'), induk kalimat Past Perfect ('had confirmed'), memuat anak kalimat pendaftaran ulang yang sedang berlangsung ('were registering').",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Setelah mesin telah diperiksa oleh teknisi, supervisor mengonfirmasi bahwa produksi aman dilanjutkan saat lini perakitan sedang berjalan kembali.',
                        'target_word' => 'had been checked ... confirmed ... was resuming (Factory Inspection Sequence)',
                        'vocab' => [
                            ['en' => 'had been checked by the technician', 'id' => 'telah diperiksa oleh teknisi'],
                            ['en' => 'supervisor confirmed production was safe to resume', 'id' => 'supervisor mengonfirmasi produksi aman dilanjutkan'],
                            ['en' => 'assembly line was resuming', 'id' => 'lini perakitan sedang berjalan kembali'],
                        ],
                        'options' => [
                            'After the machine had been checked by the technician, the supervisor confirmed that production was safe to resume while the assembly line was resuming operation.',
                            'After the machine has been checked by the technician, the supervisor confirmed that production was safe to resume while the assembly line was resuming operation.',
                            'After the machine had been checked by the technician, the supervisor was confirmed that production was safe to resume while the assembly line was resuming operation.',
                            'After the machine was checked by the technician, the supervisor had confirmed that production was safe to resume while the assembly line was resuming operation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemeriksaan selesai lebih dulu ('had been checked'), konfirmasi ditegakkan ('confirmed'), saat lini perakitan sedang berjalan kembali ('was resuming').",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Jumlah keluhan pelanggan di cabang itu telah berkurang selama bertahun-tahun sebelum manajemen meluncurkan program loyalitas baru.',
                        'target_word' => 'had been declining ... launched (Business Trend Sequence)',
                        'vocab' => [
                            ['en' => 'number of customer complaints had been declining', 'id' => 'jumlah keluhan pelanggan telah berkurang'],
                            ['en' => 'for years', 'id' => 'selama bertahun-tahun'],
                            ['en' => 'management launched a new loyalty program', 'id' => 'manajemen meluncurkan program loyalitas baru'],
                        ],
                        'options' => [
                            'The number of customer complaints at that branch had been declining for years before management launched a new loyalty program.',
                            'The number of customer complaints at that branch has been declining for years before management launched a new loyalty program.',
                            'The number of customer complaints at that branch was declining for years before management had launched a new loyalty program.',
                            'The number of customer complaints at that branch had declining for years before management launched a new loyalty program.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penurunan berdurasi panjang sebelum tindakan lampau: 'had been declining'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Ketika rapat evaluasi selesai, panitia telah menyelesaikan daftar anggaran sementara dua staf sedang menyusun laporan akhir.',
                        'target_word' => 'concluded ... had finalized ... were compiling (Committee Sequence)',
                        'vocab' => [
                            ['en' => 'evaluation meeting concluded', 'id' => 'rapat evaluasi selesai'],
                            ['en' => 'had finalized the budget list', 'id' => 'telah menyelesaikan daftar anggaran'],
                            ['en' => 'two staff members were compiling the final report', 'id' => 'dua staf sedang menyusun laporan akhir'],
                        ],
                        'options' => [
                            'When the evaluation meeting concluded, the committee had finalized the budget list while two staff members were compiling the final report.',
                            'When the evaluation meeting concluded, the committee has finalized the budget list while two staff members were compiling the final report.',
                            'When the evaluation meeting had concluded, the committee finalized the budget list while two staff members were compiling the final report.',
                            'When the evaluation meeting concluded, the committee had finalized the budget list while two staff members compiled the final report.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'concluded' (titik waktu lampau) mendapati daftar anggaran telah selesai ('had finalized') dan laporan sedang disusun ('were compiling').",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Laporan akhir mengonfirmasi bahwa panitia telah memeriksa semua daftar sebelum formulir diserahkan, yang memastikan bahwa seluruh persiapan telah mematuhi standar perusahaan.',
                        'target_word' => 'confirmed ... had checked ... was submitted ... complied (Preparation Climax)',
                        'vocab' => [
                            ['en' => 'final report confirmed', 'id' => 'laporan akhir mengonfirmasi'],
                            ['en' => 'had checked every list', 'id' => 'telah memeriksa semua daftar'],
                            ['en' => 'form was submitted', 'id' => 'formulir diserahkan'],
                            ['en' => 'complied with company standards', 'id' => 'mematuhi standar perusahaan'],
                        ],
                        'options' => [
                            'The final report confirmed that the committee had checked every list before the form was submitted, ensuring that all preparations complied with company standards.',
                            'The final report confirmed that the committee have checked every list before the form was submitted, ensuring that all preparations complied with company standards.',
                            'The final report had confirmed that the committee checked every list before the form was submitted, ensuring that all preparations complied with company standards.',
                            'The final report confirmed that the committee had checked every list before the form was submitted, ensuring that all preparations has complied with company standards.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Sintesis linimasa multi-klausa: Laporan mengonfirmasi ('confirmed') bahwa panitia telah memeriksa lebih dulu ('had checked') sebelum formulir diserahkan ('was submitted') dan memastikan persiapan mematuhi ('complied').",
                    ],
                ]
            ],
        ];
    }
}
