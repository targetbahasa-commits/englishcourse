<?php

namespace App\Services;

class SelfStudySimpleFutureData
{
    /**
     * Get the complete Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive) package.
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
            'banner_title' => 'Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive)',
            'banner_subtitle' => 'Kuasai cara menyatakan rencana, prediksi, janji, dan kondisi masa depan dalam konteks kerja dan kehidupan sehari-hari dengan "will" dan "be going to", termasuk bentuk nominal, bentuk pasif, dan aturan larangan "will" dalam klausa waktu.',
            'banner_badge' => 'MODULE 1.11 SIMPLE FUTURE TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.11
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Simple Future Tense: Rencana, Prediksi, & Komitmen',
            'concept_summary' => 'Simple Future Tense digunakan untuk menyatakan rencana, prediksi, janji, dan kondisi di masa depan, baik dalam percakapan santai maupun situasi kerja/formal. Kita perlu membedakan antara "will" (keputusan spontan, janji, prediksi umum), "be going to" (rencana yang sudah dipikirkan atau prediksi berdasarkan bukti nyata saat ini), bentuk nominal ("will be"), bentuk pasif ("will be + V3"), dan aturan penting: tidak boleh memakai "will" di dalam anak kalimat waktu atau syarat.',
            'rules' => [
                [
                    'rule_title' => '1. Simple Future Verbal Aktif: Will + Verb 1 (Base Form)',
                    'rule_formula' => 'Subject + will + Verb 1 (Bare Infinitive) + Object',
                    'rule_description' => 'Gunakan "will + V1" untuk seluruh subjek tunggal dan jamak saat membuat janji, keputusan spontan, atau prediksi umum. Kata kerja setelah "will" wajib berbentuk dasar tanpa akhiran -s, -ed, atau -ing.',
                    'examples' => [
                        [
                            'en' => 'I will call the client as soon as the contract is ready.',
                            'id' => 'Saya akan menelepon klien begitu kontraknya siap.',
                            'note' => '"will" langsung diikuti kata kerja dasar murni "call".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Prediksi Berbasis Bukti Nyata: Be Going To + V1',
                    'rule_formula' => 'Subject + am/is/are + going to + Verb 1 (Base Form)',
                    'rule_description' => 'Gunakan "be going to" jika ada bukti nyata saat ini yang mengindikasikan suatu kepastian hasil, atau jika suatu rencana sudah dipikirkan/diputuskan sebelumnya.',
                    'examples' => [
                        [
                            'en' => 'Judging by the traffic report, we are going to be late for the meeting.',
                            'id' => 'Melihat laporan lalu lintas, sepertinya kita akan terlambat ke rapat.',
                            'note' => 'Didukung oleh bukti nyata yang terlihat saat ini ("the traffic report").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Nominal Masa Depan: Will Be & Be Going To Be',
                    'rule_formula' => 'Subject + will be / is/are going to be + Adjective / Noun Phrase / Prepositional Phrase',
                    'rule_description' => 'Menyatakan status, peran, atau kondisi subjek di masa mendatang. Kata "be" wajib hadir sebelum kata sifat, nomina, atau preposisi.',
                    'examples' => [
                        [
                            'en' => 'The flight will be delayed because of the storm.',
                            'id' => 'Penerbangannya akan tertunda karena badai.',
                            'note' => 'Dilarang meniadakan "be" (*will delayed adalah SALAH).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Bentuk Pasif Masa Depan: Will Be + Verb 3 (Past Participle)',
                    'rule_formula' => 'Passive Subject + will be + Verb 3 (Past Participle) + (by Agent)',
                    'rule_description' => 'Digunakan ketika fokus kalimat ada pada sesuatu yang akan dikenai tindakan, bukan pada pelaku tindakannya.',
                    'examples' => [
                        [
                            'en' => 'The package will be delivered by courier this afternoon.',
                            'id' => 'Paket itu akan diantar oleh kurir sore ini.',
                            'note' => '"will be delivered" memaparkan tindakan yang akan dikenakan pada paket.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Aturan Larangan "Will" dalam Klausa Waktu (No Future in Time Clauses)',
                    'rule_formula' => 'Time Conjunction (When/Once/As soon as/Before/Unless/Provided that) + S + Verb 1/V-s (Simple Present), Main Clause (will + V1)',
                    'rule_description' => 'Anak kalimat yang diawali konjungsi waktu (when, as soon as, once, before, after, until) atau syarat (if, unless, provided that) DILARANG menggunakan "will". Gunakan Simple Present di anak kalimat, dan letakkan "will" hanya di induk kalimat.',
                    'examples' => [
                        [
                            'en' => 'Once the invoice is approved, the payment will be processed.',
                            'id' => 'Begitu faktur disetujui, pembayaran akan diproses.',
                            'note' => 'Gunakan "is approved" (Simple Present Pasif), BUKAN *will be approved.'
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
                'id' => 'future-verbal-will',
                'name' => "1.11.1 Simple Future Verbal with 'Will': Promises & Spontaneous Decisions",
                'code' => '1.11.1',
                'concept_title' => 'Simple Future Verbal (Will): Janji & Keputusan Spontan',
                'concept_description' => "Simple Future Verbal dengan modal auxiliary 'will' digunakan untuk membuat janji, menyampaikan keputusan spontan, dan menyatakan prediksi umum, baik dalam percakapan sehari-hari maupun situasi kerja. Strukturnya tidak bergantung pada subjek tunggal atau jamak: selalu gunakan 'will' diikuti kata kerja dasar murni (Bare Infinitive / V1) tanpa akhiran -s, -ed, atau -ing.",
                'description' => "Simple Future Verbal dengan modal auxiliary 'will' digunakan untuk membuat janji, menyampaikan keputusan spontan, dan menyatakan prediksi umum, baik dalam percakapan sehari-hari maupun situasi kerja. Strukturnya tidak bergantung pada subjek tunggal atau jamak: selalu gunakan 'will' diikuti kata kerja dasar murni (Bare Infinitive / V1) tanpa akhiran -s, -ed, atau -ing.",
                'formula' => 'Subject + will + Verb 1 (Base Form) + Object / Complement',
                'rules' => [
                    "Gunakan 'will + V1' untuk seluruh jenis subjek, baik tunggal (the manager, this update) maupun jamak (my colleagues, the clients).",
                    "Kata kerja setelah 'will' wajib berbentuk dasar (Bare Infinitive): will handle, will review, will contact.",
                    'Dilarang menambahkan to be sebelum V1 aktif (*will is review, *will to contact adalah SALAH).',
                    "Dalam percakapan santai boleh dipendekkan jadi 'I'll', 'we'll', tapi dalam latihan menulis, tulis secara utuh 'I will' dan 'we will'.",
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Manajer akan menghubungi klien malam ini untuk mengonfirmasi jadwal pertemuan.',
                        'target_word' => 'will contact (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'manager', 'id' => 'manajer'],
                            ['en' => 'contact the client tonight', 'id' => 'menghubungi klien malam ini'],
                            ['en' => 'confirm the meeting schedule', 'id' => 'mengonfirmasi jadwal pertemuan'],
                        ],
                        'options' => [
                            'The manager will contact the client tonight to confirm the meeting schedule.',
                            'The manager will contacts the client tonight to confirm the meeting schedule.',
                            'The manager will to contact the client tonight to confirm the meeting schedule.',
                            'The manager is will contact the client tonight to confirm the meeting schedule.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah modal auxiliary 'will', kata kerja wajib berbentuk dasar (Bare Infinitive) 'contact' tanpa akhiran -s atau partikel 'to'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Rekan-rekan kerjaku akan mengunjungi kantor cabang baru bulan depan.',
                        'target_word' => 'will visit (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'my colleagues', 'id' => 'rekan-rekan kerjaku'],
                            ['en' => 'visit the new branch office', 'id' => 'mengunjungi kantor cabang baru'],
                            ['en' => 'next month', 'id' => 'bulan depan'],
                        ],
                        'options' => [
                            'My colleagues will visit the new branch office next month.',
                            'My colleagues will visits the new branch office next month.',
                            'My colleagues will visited the new branch office next month.',
                            'My colleagues are will visit the new branch office next month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'colleagues' dipadukan dengan modal 'will' + V1 'visit'. Pilihan C salah menggunakan V2.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Aplikasi pelacakan pengiriman baru ini akan memprediksi waktu kedatangan dengan lebih akurat.',
                        'target_word' => 'will predict (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'new delivery tracking app', 'id' => 'aplikasi pelacakan pengiriman baru'],
                            ['en' => 'predict arrival time', 'id' => 'memprediksi waktu kedatangan'],
                            ['en' => 'more accurately', 'id' => 'dengan lebih akurat'],
                        ],
                        'options' => [
                            'This new delivery tracking app will predict arrival time more accurately.',
                            'This new delivery tracking app will predicts arrival time more accurately.',
                            'This new delivery tracking app will predicting arrival time more accurately.',
                            'This new delivery tracking app will be predict arrival time more accurately.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Modal 'will' langsung diikuti V1 murni 'predict'. Bentuk 'will predicts' melanggar aturan modal.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Kebijakan kerja jarak jauh yang diusulkan perusahaan akan mendorong keseimbangan hidup-kerja karyawan.',
                        'target_word' => 'will encourage (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => "the company's proposed remote work policy", 'id' => 'kebijakan kerja jarak jauh yang diusulkan perusahaan'],
                            ['en' => 'encourage work-life balance', 'id' => 'mendorong keseimbangan hidup-kerja'],
                            ['en' => 'employees', 'id' => 'karyawan'],
                        ],
                        'options' => [
                            "The company's proposed remote work policy will encourage employees' work-life balance.",
                            "The company's proposed remote work policy will encourages employees' work-life balance.",
                            "The company's proposed remote work policy will encouraged employees' work-life balance.",
                            "The company's proposed remote work policy is will encourage employees' work-life balance.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will encourage' adalah konstruksi verbal aktif masa depan yang benar; tidak boleh ditambah to be 'is' di depannya.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Tim IT akan menyelidiki penyebab gangguan jaringan yang terjadi pagi tadi.',
                        'target_word' => 'will investigate (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'IT team', 'id' => 'tim IT'],
                            ['en' => 'investigate the cause', 'id' => 'menyelidiki penyebab'],
                            ['en' => 'network outage', 'id' => 'gangguan jaringan'],
                        ],
                        'options' => [
                            'The IT team will investigate the cause of the network outage this morning.',
                            'The IT team will investigates the cause of the network outage this morning.',
                            'The IT team will to investigate the cause of the network outage this morning.',
                            'The IT team will investigating the cause of the network outage this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will investigate' menggunakan bentuk dasar setelah modal 'will'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Pemerintah kota akan memperluas jalur sepeda agar warga punya akses transportasi yang lebih aman.',
                        'target_word' => 'will expand (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'city government', 'id' => 'pemerintah kota'],
                            ['en' => 'expand the bike lanes', 'id' => 'memperluas jalur sepeda'],
                            ['en' => 'safer access', 'id' => 'akses yang lebih aman'],
                        ],
                        'options' => [
                            'The city government will expand the bike lanes so residents have safer transport access.',
                            'The city government will expands the bike lanes so residents have safer transport access.',
                            'The city government will expanded the bike lanes so residents have safer transport access.',
                            'The city government will to expand the bike lanes so residents have safer transport access.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk dasar 'expand' wajib digunakan setelah 'will'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Cuaca buruk akan mengancam jadwal penerbangan besok pagi.',
                        'target_word' => 'will threaten (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'bad weather', 'id' => 'cuaca buruk'],
                            ['en' => 'threaten the flight schedule', 'id' => 'mengancam jadwal penerbangan'],
                            ['en' => 'tomorrow morning', 'id' => 'besok pagi'],
                        ],
                        'options' => [
                            "Bad weather will threaten tomorrow morning's flight schedule.",
                            "Bad weather will threatens tomorrow morning's flight schedule.",
                            "Bad weather will threatened tomorrow morning's flight schedule.",
                            "Bad weather is will threaten tomorrow morning's flight schedule.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will threaten' memaparkan prediksi masa depan dengan kata kerja dasar.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Perusahaan akan memperkenalkan sistem absensi digital baru bagi seluruh karyawan tahun depan.',
                        'target_word' => 'will introduce (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'the company', 'id' => 'perusahaan'],
                            ['en' => 'introduce a new digital attendance system', 'id' => 'memperkenalkan sistem absensi digital baru'],
                            ['en' => 'next year', 'id' => 'tahun depan'],
                        ],
                        'options' => [
                            'The company will introduce a new digital attendance system for all employees next year.',
                            'The company will introduces a new digital attendance system for all employees next year.',
                            'The company will introduced a new digital attendance system for all employees next year.',
                            'The company will to introduce a new digital attendance system for all employees next year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The company' diikuti modal 'will' + V1 'introduce'.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Kebiasaan menyusun anggaran akan menurunkan pengeluaran bulanan perusahaan kami.',
                        'target_word' => 'will decrease (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'habit of budgeting', 'id' => 'kebiasaan menyusun anggaran'],
                            ['en' => 'decrease monthly expenses', 'id' => 'menurunkan pengeluaran bulanan'],
                            ['en' => 'our company', 'id' => 'perusahaan kami'],
                        ],
                        'options' => [
                            "The habit of budgeting will decrease our company's monthly expenses.",
                            "The habit of budgeting will decreases our company's monthly expenses.",
                            "The habit of budgeting will decreased our company's monthly expenses.",
                            "The habit of budgeting is will decrease our company's monthly expenses.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek frase panjang 'The habit of budgeting' berpredikat 'will decrease'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Analis memperkirakan bahwa permintaan pasar akan membaik pada kuartal berikutnya.',
                        'target_word' => 'will improve (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'the analyst predicts', 'id' => 'analis memperkirakan'],
                            ['en' => 'market demand', 'id' => 'permintaan pasar'],
                            ['en' => 'improve', 'id' => 'membaik'],
                        ],
                        'options' => [
                            'The analyst predicts that market demand will improve next quarter.',
                            'The analyst predicts that market demand will improves next quarter.',
                            'The analyst predicts that market demand will improved next quarter.',
                            'The analyst predicts that market demand will to improve next quarter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa prediksi menggunakan modal masa depan 'will improve'.",
                    ],
                ]
            ],
            [
                'id' => 'future-be-going-to',
                'name' => "1.11.2 Simple Future with 'Be Going To': Evidence-Based Predictions & Pre-Planned Activities",
                'code' => '1.11.2',
                'concept_title' => 'Simple Future (Be Going To): Prediksi Berbasis Bukti & Rencana Matang',
                'concept_description' => "Konstruksi 'be going to' digunakan ketika ada bukti nyata saat ini (seperti laporan, data, atau tanda-tanda yang terlihat) yang mengarah kuat pada hasil masa depan, atau ketika suatu kegiatan sudah direncanakan sebelumnya. Auxiliary 'be' diselaraskan dengan subjek (is / am / are) diikuti 'going to' dan kata kerja dasar (V1).",
                'description' => "Konstruksi 'be going to' digunakan ketika ada bukti nyata saat ini (seperti laporan, data, atau tanda-tanda yang terlihat) yang mengarah kuat pada hasil masa depan, atau ketika suatu kegiatan sudah direncanakan sebelumnya. Auxiliary 'be' diselaraskan dengan subjek (is / am / are) diikuti 'going to' dan kata kerja dasar (V1).",
                'formula' => 'Subject + am/is/are + going to + Verb 1 (Base Form) + Object',
                'rules' => [
                    "Selaraskan to be dengan subjek: 'is going to' (tunggal), 'are going to' (jamak), 'am going to' (I).",
                    "Setelah 'going to', kata kerja wajib berbentuk dasar V1 murni (Bare Infinitive).",
                    "Gunakan 'be going to' saat ada bukti nyata saat ini (misal: 'Judging by the sales report, the project is going to exceed its budget').",
                    'Jangan menghilangkan to be (*The team going to launch adalah SALAH).',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Lihat laporan penjualan itu, sepertinya proyek akan melampaui anggaran sebentar lagi.',
                        'target_word' => 'is going to exceed (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'look at the sales report', 'id' => 'lihat laporan penjualan itu'],
                            ['en' => 'going to exceed the budget', 'id' => 'akan melampaui anggaran'],
                            ['en' => 'soon', 'id' => 'sebentar lagi'],
                        ],
                        'options' => [
                            'Look at the sales report, the project is going to exceed the budget soon.',
                            'Look at the sales report, the project are going to exceed the budget soon.',
                            'Look at the sales report, the project is going to exceeding the budget soon.',
                            'Look at the sales report, the project going to exceed the budget soon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'the project' memerlukan to be 'is' + 'going to exceed'. Ada bukti nyata ('the sales report') yang mendasari prediksi.",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Melihat antrean klien yang semakin panjang, biaya layanan pelanggan tampaknya akan naik dengan cepat.',
                        'target_word' => 'is going to rise (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'the client queue getting longer', 'id' => 'antrean klien yang semakin panjang'],
                            ['en' => 'customer service cost', 'id' => 'biaya layanan pelanggan'],
                            ['en' => 'rise quickly', 'id' => 'naik dengan cepat'],
                        ],
                        'options' => [
                            'Given the client queue getting longer, customer service cost is going to rise quickly.',
                            'Given the client queue getting longer, customer service cost are going to rise quickly.',
                            'Given the client queue getting longer, customer service cost is going to rising quickly.',
                            'Given the client queue getting longer, customer service cost going to rise quickly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'customer service cost' berpasangan dengan 'is going to rise'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Perusahaan kami akan membuka kantor cabang baru pada semester depan.',
                        'target_word' => 'is going to open (Pre-Planned Activity)',
                        'vocab' => [
                            ['en' => 'our company', 'id' => 'perusahaan kami'],
                            ['en' => 'open a new branch office', 'id' => 'membuka kantor cabang baru'],
                            ['en' => 'next semester', 'id' => 'semester depan'],
                        ],
                        'options' => [
                            'Our company is going to open a new branch office next semester.',
                            'Our company are going to open a new branch office next semester.',
                            'Our company is going to opens a new branch office next semester.',
                            'Our company is going to opened a new branch office next semester.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rencana perusahaan yang sudah dipersiapkan memakai 'is going to open' dengan kata kerja dasar 'open'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Melihat ban mobilnya kempis, rekan kerjaku akan menambalnya sebelum berangkat ke kantor.',
                        'target_word' => 'is going to patch (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'notices the flat tire', 'id' => 'melihat ban kempis'],
                            ['en' => 'my colleague', 'id' => 'rekan kerjaku'],
                            ['en' => 'patch it', 'id' => 'menambalnya'],
                        ],
                        'options' => [
                            'Noticing the flat tire, my colleague is going to patch it before heading to the office.',
                            'Noticing the flat tire, my colleague are going to patch it before heading to the office.',
                            'Noticing the flat tire, my colleague is going to patching it before heading to the office.',
                            'Noticing the flat tire, my colleague going to patch it before heading to the office.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'my colleague' berpasangan dengan 'is going to patch'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Melihat stok gudang yang hampir habis, kami akan menghadapi masalah pasokan minggu ini.',
                        'target_word' => 'is going to face (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'the warehouse stock being almost empty', 'id' => 'stok gudang yang hampir habis'],
                            ['en' => 'our team', 'id' => 'tim kami'],
                            ['en' => 'face a supply problem', 'id' => 'menghadapi masalah pasokan'],
                        ],
                        'options' => [
                            'With the warehouse stock almost empty, our team is going to face a supply problem this week.',
                            'With the warehouse stock almost empty, our team are going to face a supply problem this week.',
                            'With the warehouse stock almost empty, our team is going to facing a supply problem this week.',
                            'With the warehouse stock almost empty, our team going to face a supply problem this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'our team' menggunakan 'is going to face'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Panitia acara akan meninjau kembali rencana anggaran pada rapat minggu depan.',
                        'target_word' => 'is going to review (Pre-Planned Activity)',
                        'vocab' => [
                            ['en' => 'event committee', 'id' => 'panitia acara'],
                            ['en' => 'review the budget plan', 'id' => 'meninjau kembali rencana anggaran'],
                            ['en' => "next week's meeting", 'id' => 'rapat minggu depan'],
                        ],
                        'options' => [
                            "The event committee is going to review the budget plan at next week's meeting.",
                            "The event committee are going to review the budget plan at next week's meeting.",
                            "The event committee is going to reviewing the budget plan at next week's meeting.",
                            "The event committee going to review the budget plan at next week's meeting.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Collective noun 'The event committee' sebagai entitas tunggal memakai 'is going to review'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Karena persediaan bahan baku menipis, kami akan memesan tambahan sore ini.',
                        'target_word' => 'are going to order (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'raw material supply running low', 'id' => 'persediaan bahan baku menipis'],
                            ['en' => 'we', 'id' => 'kami'],
                            ['en' => 'order more', 'id' => 'memesan tambahan'],
                        ],
                        'options' => [
                            'Because the raw material supply is running low, we are going to order more this afternoon.',
                            'Because the raw material supply is running low, we is going to order more this afternoon.',
                            'Because the raw material supply is running low, we are going to ordering more this afternoon.',
                            'Because the raw material supply is running low, we going to order more this afternoon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'we' berpasangan dengan 'are going to order'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Tim proyek kami akan mempresentasikan hasil kerja pada minggu depan.',
                        'target_word' => 'is going to present (Pre-Planned Schedule)',
                        'vocab' => [
                            ['en' => 'our project team', 'id' => 'tim proyek kami'],
                            ['en' => 'present the work results', 'id' => 'mempresentasikan hasil kerja'],
                            ['en' => 'next week', 'id' => 'minggu depan'],
                        ],
                        'options' => [
                            'Our project team is going to present the work results next week.',
                            'Our project team are going to present the work results next week.',
                            'Our project team is going to presents the work results next week.',
                            'Our project team going to present the work results next week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our project team' mengambil 'is going to present'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Melihat angka penjualan yang menurun, toko kami akan mengalami kerugian jika tidak segera bertindak.',
                        'target_word' => 'is going to suffer (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'the declining sales figures', 'id' => 'angka penjualan yang menurun'],
                            ['en' => 'our shop', 'id' => 'toko kami'],
                            ['en' => 'suffer a loss', 'id' => 'mengalami kerugian'],
                        ],
                        'options' => [
                            'Given the declining sales figures, our shop is going to suffer a loss unless we act soon.',
                            'Given the declining sales figures, our shop are going to suffer a loss unless we act soon.',
                            'Given the declining sales figures, our shop is going to suffering a loss unless we act soon.',
                            'Given the declining sales figures, our shop going to suffer a loss unless we act soon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'shop' adalah subjek tunggal, maka to be yang benar adalah 'is going to suffer'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Staf keamanan kantor akan memperbarui jadwal piket untuk mencegah kelalaian.',
                        'target_word' => 'are going to update (Pre-Planned Action)',
                        'vocab' => [
                            ['en' => 'office security staff', 'id' => 'staf keamanan kantor'],
                            ['en' => 'update the duty schedule', 'id' => 'memperbarui jadwal piket'],
                            ['en' => 'prevent oversights', 'id' => 'mencegah kelalaian'],
                        ],
                        'options' => [
                            'The office security staff are going to update the duty schedule to prevent oversights.',
                            'The office security staff is going to update the duty schedule to prevent oversights.',
                            'The office security staff are going to updating the duty schedule to prevent oversights.',
                            'The office security staff going to update the duty schedule to prevent oversights.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'The office security staff' membutuhkan 'are going to update'.",
                    ],
                ]
            ],
            [
                'id' => 'future-nominal',
                'name' => "1.11.3 Simple Future Nominal: Future States & Conditions ('Will Be' & 'Be Going To Be')",
                'code' => '1.11.3',
                'concept_title' => 'Simple Future Nominal: Menjelaskan Status & Kondisi Masa Depan',
                'concept_description' => "Dalam konteks kerja maupun sehari-hari, kita sering perlu memperkirakan status, peran, atau sifat sesuatu di masa depan. Simple Future Nominal dibentuk dengan meletakkan 'be' setelah modal 'will' (will be) atau setelah 'going to' (is/are going to be) diikuti pelengkap (Adjective, Noun Phrase, atau Prepositional Phrase). Jangan pernah meniadakan kata 'be' pada kalimat nominal masa depan.",
                'description' => "Dalam konteks kerja maupun sehari-hari, kita sering perlu memperkirakan status, peran, atau sifat sesuatu di masa depan. Simple Future Nominal dibentuk dengan meletakkan 'be' setelah modal 'will' (will be) atau setelah 'going to' (is/are going to be) diikuti pelengkap (Adjective, Noun Phrase, atau Prepositional Phrase). Jangan pernah meniadakan kata 'be' pada kalimat nominal masa depan.",
                'formula' => 'Subject + will be / is/are going to be + Adjective / Noun Phrase / Prepositional Phrase',
                'rules' => [
                    "Bentuk baku nominal: 'will be + Complement' atau 'is/are going to be + Complement'.",
                    'Pelengkap (Complement) dapat berupa kata sifat (ready, delayed), frasa nomina (a supervisor), atau preposisi (on leave).',
                    "Dilarang keras meniadakan 'be' (*will ready adalah KESALAHAN BESAR).",
                    'Dilarang menggunakan to be lain setelah will (*will is, *will was).',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Penerbangannya akan tertunda besok, jadi siapkan rencana cadangan.',
                        'target_word' => 'will be delayed (Future Nominal)',
                        'vocab' => [
                            ['en' => 'the flight', 'id' => 'penerbangannya'],
                            ['en' => 'delayed', 'id' => 'tertunda'],
                            ['en' => 'prepare a backup plan', 'id' => 'siapkan rencana cadangan'],
                        ],
                        'options' => [
                            'The flight will be delayed tomorrow, so prepare a backup plan.',
                            'The flight will delayed tomorrow, so prepare a backup plan.',
                            'The flight will is delayed tomorrow, so prepare a backup plan.',
                            'The flight will being delayed tomorrow, so prepare a backup plan.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah modal 'will', kita wajib menyertakan kata kerja bantu 'be' sebelum adjective 'delayed' ('will be delayed').",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Rekan kerjaku akan menjadi supervisor baru setelah pelatihan kepemimpinan tahun depan.',
                        'target_word' => 'will be a supervisor (Future Nominal)',
                        'vocab' => [
                            ['en' => 'my colleague', 'id' => 'rekan kerjaku'],
                            ['en' => 'a supervisor', 'id' => 'supervisor'],
                            ['en' => 'after leadership training', 'id' => 'setelah pelatihan kepemimpinan'],
                        ],
                        'options' => [
                            'My colleague will be a supervisor after leadership training next year.',
                            'My colleague will a supervisor after leadership training next year.',
                            'My colleague will is a supervisor after leadership training next year.',
                            'My colleague will being a supervisor after leadership training next year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be' sebelum noun phrase 'a supervisor'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Jalan tol diperkirakan akan lebih padat akibat libur panjang.',
                        'target_word' => 'are going to be busier (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'the toll roads', 'id' => 'jalan tol'],
                            ['en' => 'busier', 'id' => 'lebih padat'],
                            ['en' => 'long holiday', 'id' => 'libur panjang'],
                        ],
                        'options' => [
                            'The toll roads are going to be busier because of the long holiday.',
                            'The toll roads is going to be busier because of the long holiday.',
                            'The toll roads are going to busier because of the long holiday.',
                            'The toll roads are going to being busier because of the long holiday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'roads' membutuhkan 'are going to be' diikuti adjective 'busier'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Kebijakan kerja jarak jauh yang baru akan berlaku mulai awal bulan depan.',
                        'target_word' => 'will be in effect (Future Nominal with Prepositional Phrase)',
                        'vocab' => [
                            ['en' => 'new remote work policy', 'id' => 'kebijakan kerja jarak jauh yang baru'],
                            ['en' => 'in effect', 'id' => 'berlaku'],
                            ['en' => 'beginning of next month', 'id' => 'awal bulan depan'],
                        ],
                        'options' => [
                            'The new remote work policy will be in effect starting next month.',
                            'The new remote work policy will in effect starting next month.',
                            'The new remote work policy will are in effect starting next month.',
                            'The new remote work policy will being in effect starting next month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa preposisional 'in effect' memerlukan 'will be'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Harga tiket kereta akan lebih murah pada hari biasa.',
                        'target_word' => 'will be cheaper (Future Nominal)',
                        'vocab' => [
                            ['en' => 'train ticket price', 'id' => 'harga tiket kereta'],
                            ['en' => 'cheaper', 'id' => 'lebih murah'],
                            ['en' => 'on weekdays', 'id' => 'pada hari biasa'],
                        ],
                        'options' => [
                            'The train ticket price will be cheaper on weekdays.',
                            'The train ticket price will cheaper on weekdays.',
                            'The train ticket price will are cheaper on weekdays.',
                            'The train ticket price will being cheaper on weekdays.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kalimat nominal masa depan wajib menggunakan 'will be' sebelum komparatif 'cheaper'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Program magang ini akan menjadi kesempatan emas bagi para lulusan baru.',
                        'target_word' => 'is going to be a golden opportunity (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'this internship program', 'id' => 'program magang ini'],
                            ['en' => 'golden opportunity', 'id' => 'kesempatan emas'],
                            ['en' => 'new graduates', 'id' => 'lulusan baru'],
                        ],
                        'options' => [
                            'This internship program is going to be a golden opportunity for new graduates.',
                            'This internship program are going to be a golden opportunity for new graduates.',
                            'This internship program is going to a golden opportunity for new graduates.',
                            'This internship program going to be a golden opportunity for new graduates.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'This internship program' dipadukan dengan 'is going to be a golden opportunity'.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Kerja sama antar divisi akan sangat penting untuk memenangkan tender ini.',
                        'target_word' => 'will be very important (Future Nominal)',
                        'vocab' => [
                            ['en' => 'cross-division teamwork', 'id' => 'kerja sama antar divisi'],
                            ['en' => 'very important', 'id' => 'sangat penting'],
                            ['en' => 'winning this tender', 'id' => 'memenangkan tender ini'],
                        ],
                        'options' => [
                            'Cross-division teamwork will be very important for winning this tender.',
                            'Cross-division teamwork will very important for winning this tender.',
                            'Cross-division teamwork will is very important for winning this tender.',
                            'Cross-division teamwork will being very important for winning this tender.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be very important' adalah struktur nominal masa depan yang baku.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Hasil survei ini akan berguna untuk mengukur kepuasan pelanggan.',
                        'target_word' => 'will be useful (Future Nominal)',
                        'vocab' => [
                            ['en' => 'this survey result', 'id' => 'hasil survei ini'],
                            ['en' => 'useful', 'id' => 'berguna'],
                            ['en' => 'measuring customer satisfaction', 'id' => 'mengukur kepuasan pelanggan'],
                        ],
                        'options' => [
                            'This survey result will be useful for measuring customer satisfaction.',
                            'This survey result will useful for measuring customer satisfaction.',
                            'This survey result will are useful for measuring customer satisfaction.',
                            'This survey result will being useful for measuring customer satisfaction.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be' sebelum kata sifat 'useful'.",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Kedua karyawan itu akan menjadi perwakilan perusahaan dalam pameran dagang kota.',
                        'target_word' => 'are going to be representatives (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'the two employees', 'id' => 'kedua karyawan itu'],
                            ['en' => 'representatives', 'id' => 'perwakilan'],
                            ['en' => 'city trade fair', 'id' => 'pameran dagang kota'],
                        ],
                        'options' => [
                            'The two employees are going to be representatives at the city trade fair.',
                            'The two employees is going to be representatives at the city trade fair.',
                            'The two employees are going to representatives at the city trade fair.',
                            'The two employees are going to being representatives at the city trade fair.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'employees' mengambil 'are going to be'.",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Gudang kami akan rentan kebanjiran jika sistem drainase tidak segera diperbaiki.',
                        'target_word' => 'will be vulnerable (Future Nominal)',
                        'vocab' => [
                            ['en' => 'our warehouse', 'id' => 'gudang kami'],
                            ['en' => 'vulnerable to flooding', 'id' => 'rentan kebanjiran'],
                            ['en' => 'the drainage system is not repaired', 'id' => 'sistem drainase tidak diperbaiki'],
                        ],
                        'options' => [
                            'Our warehouse will be vulnerable to flooding if the drainage system is not repaired soon.',
                            'Our warehouse will vulnerable to flooding if the drainage system is not repaired soon.',
                            'Our warehouse will is vulnerable to flooding if the drainage system is not repaired soon.',
                            'Our warehouse will being vulnerable to flooding if the drainage system is not repaired soon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be vulnerable' menggabungkan modal 'will' dengan 'be' dan adjective 'vulnerable'.",
                    ],
                ]
            ],
            [
                'id' => 'future-passive',
                'name' => '1.11.4 Simple Future Passive: Plans, Procedures & Deliveries',
                'code' => '1.11.4',
                'concept_title' => 'Simple Future Pasif: Rencana, Prosedur, & Pengiriman',
                'concept_description' => "Simple Future Pasif digunakan ketika fokus kalimat ada pada sesuatu atau seseorang yang akan dikenai suatu tindakan di masa depan, bukan pada siapa yang melakukannya (misal: 'the contract will be signed', 'the office will be renovated'). Rumusnya menggunakan 'will be' diikuti Past Participle (V3).",
                'description' => "Simple Future Pasif digunakan ketika fokus kalimat ada pada sesuatu atau seseorang yang akan dikenai suatu tindakan di masa depan, bukan pada siapa yang melakukannya (misal: 'the contract will be signed', 'the office will be renovated'). Rumusnya menggunakan 'will be' diikuti Past Participle (V3).",
                'formula' => 'Subject (Patient) + will be / is/are going to be + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    'Rumus utama: will be + Verb 3 (Past Participle).',
                    'Jangan tertukar dengan Future Continuous aktif (will be + V-ing); bentuk pasif WAJIB berakhiran V3 (will be signed, bukan will be signing).',
                    "Dalam bentuk 'be going to', rumusnya adalah 'is/are going to be + V3'.",
                    'Bentuk pasif cocok dipakai saat kita ingin menekankan objek yang menerima tindakan, bukan pelakunya.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Kontrak itu akan ditandatangani oleh direktur sore ini untuk kerja sama baru.',
                        'target_word' => 'will be signed (Future Passive)',
                        'vocab' => [
                            ['en' => 'the contract', 'id' => 'kontrak itu'],
                            ['en' => 'signed by the director', 'id' => 'ditandatangani oleh direktur'],
                            ['en' => 'new partnership', 'id' => 'kerja sama baru'],
                        ],
                        'options' => [
                            'The contract will be signed by the director this afternoon for the new partnership.',
                            'The contract will sign by the director this afternoon for the new partnership.',
                            'The contract will be sign by the director this afternoon for the new partnership.',
                            'The contract will being signed by the director this afternoon for the new partnership.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'The contract' memerlukan 'will be' diikuti bentuk V3 'signed'. Opsi B aktif ('akan menandatangani').",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Ruang rapat akan dirapikan sebelum klien datang akhir pekan ini.',
                        'target_word' => 'will be tidied (Future Passive)',
                        'vocab' => [
                            ['en' => 'the meeting room', 'id' => 'ruang rapat'],
                            ['en' => 'tidied', 'id' => 'dirapikan'],
                            ['en' => 'before the clients arrive', 'id' => 'sebelum klien datang'],
                        ],
                        'options' => [
                            'The meeting room will be tidied before the clients arrive this weekend.',
                            'The meeting room will tidy before the clients arrive this weekend.',
                            'The meeting room will be tidy before the clients arrive this weekend.',
                            'The meeting room will being tidied before the clients arrive this weekend.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk pasif masa depan yang tepat adalah 'will be tidied' (will be + V3).",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Laptop baru itu akan dikirim ke kantor kami pekan depan.',
                        'target_word' => 'is going to be delivered (Future Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'the new laptop', 'id' => 'laptop baru itu'],
                            ['en' => 'delivered to our office', 'id' => 'dikirim ke kantor kami'],
                            ['en' => 'next week', 'id' => 'pekan depan'],
                        ],
                        'options' => [
                            'The new laptop is going to be delivered to our office next week.',
                            'The new laptop are going to be delivered to our office next week.',
                            'The new laptop is going to be deliver to our office next week.',
                            'The new laptop is going to being delivered to our office next week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The new laptop' dipadukan dengan 'is going to be delivered' (is going to be + V3).",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Penghargaan karyawan terbaik itu akan diserahkan kepada pemenang di akhir acara.',
                        'target_word' => 'will be presented (Future Passive)',
                        'vocab' => [
                            ['en' => 'the best-employee award', 'id' => 'penghargaan karyawan terbaik itu'],
                            ['en' => 'presented to the winner', 'id' => 'diserahkan kepada pemenang'],
                            ['en' => 'at the end of the event', 'id' => 'di akhir acara'],
                        ],
                        'options' => [
                            'The best-employee award will be presented to the winner at the end of the event.',
                            'The best-employee award will present to the winner at the end of the event.',
                            'The best-employee award will be present to the winner at the end of the event.',
                            'The best-employee award will being presented to the winner at the end of the event.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'The best-employee award' dikenai aksi penyerahan sehingga memerlukan 'will be presented'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Kebijakan kantor yang baru akan diterapkan mulai minggu depan.',
                        'target_word' => 'will be applied (Future Passive)',
                        'vocab' => [
                            ['en' => 'the new office policy', 'id' => 'kebijakan kantor yang baru'],
                            ['en' => 'applied', 'id' => 'diterapkan'],
                            ['en' => 'starting next week', 'id' => 'mulai minggu depan'],
                        ],
                        'options' => [
                            'The new office policy will be applied starting next week.',
                            'The new office policy will apply starting next week.',
                            'The new office policy will be apply starting next week.',
                            'The new office policy are will be applied starting next week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be applied' adalah pola pasif masa depan yang benar.",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Laporan keuangan akan diperiksa oleh auditor setiap akhir bulan.',
                        'target_word' => 'will be checked (Future Passive)',
                        'vocab' => [
                            ['en' => 'the financial report', 'id' => 'laporan keuangan'],
                            ['en' => 'checked by the auditor', 'id' => 'diperiksa oleh auditor'],
                        ],
                        'options' => [
                            'The financial report will be checked by the auditor every month-end.',
                            'The financial report will check by the auditor every month-end.',
                            'The financial report will be check by the auditor every month-end.',
                            'The financial report is will be checked by the auditor every month-end.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk pasif 'will be checked' (will be + V3).",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Pos keamanan baru akan dibangun di ujung jalan kompleks perkantoran kami.',
                        'target_word' => 'is going to be built (Future Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'new security post', 'id' => 'pos keamanan baru'],
                            ['en' => 'built', 'id' => 'dibangun'],
                            ['en' => 'at the end of our office complex street', 'id' => 'di ujung jalan kompleks perkantoran kami'],
                        ],
                        'options' => [
                            'A new security post is going to be built at the end of our office complex street.',
                            'A new security post are going to be built at the end of our office complex street.',
                            'A new security post is going to be build at the end of our office complex street.',
                            'A new security post going to be built at the end of our office complex street.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'post' mengambil pasif 'is going to be built'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Hasil evaluasi kinerja akan dinilai melalui dua kali pemeriksaan.',
                        'target_word' => 'will be graded (Future Passive)',
                        'vocab' => [
                            ['en' => 'performance evaluation results', 'id' => 'hasil evaluasi kinerja'],
                            ['en' => 'graded', 'id' => 'dinilai'],
                            ['en' => 'two rounds of checking', 'id' => 'dua kali pemeriksaan'],
                        ],
                        'options' => [
                            'Performance evaluation results will be graded through two rounds of checking.',
                            'Performance evaluation results will grade through two rounds of checking.',
                            'Performance evaluation results will be grade through two rounds of checking.',
                            'Performance evaluation results will being graded through two rounds of checking.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be graded' menyajikan rencana pasif yang jelas.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Dana tambahan akan dialokasikan untuk acara ulang tahun perusahaan.',
                        'target_word' => 'will be allocated (Future Passive)',
                        'vocab' => [
                            ['en' => 'extra fund', 'id' => 'dana tambahan'],
                            ['en' => 'allocated', 'id' => 'dialokasikan'],
                            ['en' => "company's anniversary event", 'id' => 'acara ulang tahun perusahaan'],
                        ],
                        'options' => [
                            "The extra fund will be allocated for the company's anniversary event.",
                            "The extra fund will allocate for the company's anniversary event.",
                            "The extra fund will be allocate for the company's anniversary event.",
                            "The extra fund will being allocated for the company's anniversary event.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'fund' memerlukan 'will be allocated'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Para pelamar kerja akan diberitahu mengenai hasil wawancara melalui surel.',
                        'target_word' => 'will be notified (Future Passive)',
                        'vocab' => [
                            ['en' => 'job applicants', 'id' => 'pelamar kerja'],
                            ['en' => 'notified', 'id' => 'diberitahu'],
                            ['en' => 'through an email', 'id' => 'melalui surel'],
                        ],
                        'options' => [
                            'Job applicants will be notified of the interview results through an email.',
                            'Job applicants will notify of the interview results through an email.',
                            'Job applicants will be notify of the interview results through an email.',
                            'Job applicants are will be notified of the interview results through an email.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be notified' (will be + V3) menyatakan bahwa pelamar akan menerima pemberitahuan (pasif).",
                    ],
                ]
            ],
            [
                'id' => 'future-aspect-distinctions',
                'name' => "1.11.5 'Will' vs 'Be Going To' vs Present Continuous for Future Plans",
                'code' => '1.11.5',
                'concept_title' => "Nuansa Masa Depan: 'Will' vs 'Be Going To' vs Present Continuous",
                'concept_description' => "Kita perlu membedakan tiga cara menyatakan masa depan: (1) 'Will' untuk janji, keputusan spontan, dan prediksi umum tanpa bukti langsung; (2) 'Be Going To' untuk prediksi berbasis tanda/bukti nyata saat ini atau niat yang sudah dipikirkan; dan (3) 'Present Continuous' (is/are + V-ing) untuk acara atau janji yang sudah terjadwal pasti di kalender.",
                'description' => "Kita perlu membedakan tiga cara menyatakan masa depan: (1) 'Will' untuk janji, keputusan spontan, dan prediksi umum tanpa bukti langsung; (2) 'Be Going To' untuk prediksi berbasis tanda/bukti nyata saat ini atau niat yang sudah dipikirkan; dan (3) 'Present Continuous' (is/are + V-ing) untuk acara atau janji yang sudah terjadwal pasti di kalender.",
                'formula' => 'Will (Promises/Predictions) | Be Going To (Evidence/Intention) | Present Continuous (Scheduled Events)',
                'rules' => [
                    "Gunakan Present Continuous untuk jadwal pasti yang sudah punya tanggal/waktu tertentu ('We are meeting the client tomorrow at 10 AM').",
                    "Gunakan 'be going to' bila ada bukti nyata saat ini yang mengindikasikan hasil ('Look at the delivery tracker, the package is going to arrive late').",
                    "Gunakan 'will' untuk janji, keputusan spontan, atau prediksi umum ('This update will fix the bug').",
                    "Hindari penggunaan 'will' pada anak kalimat penunjuk waktu (Time Clauses: when, as soon as, before).",
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Perusahaan mengadakan rapat tahunan pada hari Senin depan di ruang serbaguna.',
                        'target_word' => 'is holding next Monday (Present Continuous for Fixed Arrangement)',
                        'vocab' => [
                            ['en' => 'company', 'id' => 'perusahaan'],
                            ['en' => 'annual meeting', 'id' => 'rapat tahunan'],
                            ['en' => 'multipurpose room', 'id' => 'ruang serbaguna'],
                        ],
                        'options' => [
                            'The company is holding the annual meeting next Monday in the multipurpose room.',
                            'The company will to hold the annual meeting next Monday in the multipurpose room.',
                            'The company is going to held the annual meeting next Monday in the multipurpose room.',
                            'The company holds will the annual meeting next Monday in the multipurpose room.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Untuk agenda terjadwal pasti dengan waktu dan lokasi tertentu ('next Monday in the multipurpose room'), Present Continuous ('is holding') adalah ekspresi yang paling alami.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Jika kamu bekerja dengan teliti, kinerjamu akan meningkat.',
                        'target_word' => 'will improve (Conditional Future Consequence)',
                        'vocab' => [
                            ['en' => 'work carefully', 'id' => 'bekerja dengan teliti'],
                            ['en' => 'performance', 'id' => 'kinerja'],
                            ['en' => 'improve', 'id' => 'meningkat'],
                        ],
                        'options' => [
                            'If you work carefully, your performance will improve.',
                            'If you work carefully, your performance is improving next week.',
                            'If you work carefully, your performance will improves.',
                            'If you work carefully, your performance is going to improved.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Konsekuensi logis masa depan dalam klausa pengandaian (First Conditional) wajib menggunakan modal 'will + V1' ('will improve').",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Melihat harga bahan bakar yang terus naik, sepertinya biaya pengiriman akan bertambah bulan ini.',
                        'target_word' => 'is going to rise (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'rising fuel prices', 'id' => 'harga bahan bakar yang terus naik'],
                            ['en' => 'shipping cost', 'id' => 'biaya pengiriman'],
                            ['en' => 'this month', 'id' => 'bulan ini'],
                        ],
                        'options' => [
                            'Looking at the rising fuel prices, shipping cost is going to rise this month.',
                            'Looking at the rising fuel prices, shipping cost will rising this month.',
                            'Looking at the rising fuel prices, shipping cost is going to risen this month.',
                            'Looking at the rising fuel prices, shipping cost rises will this month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Prediksi yang didasarkan pada bukti nyata saat ini ('the rising fuel prices') paling tepat menggunakan 'is going to rise'.",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Panitia mengumumkan daftar pemenang lomba inovasi pada tanggal lima belas.',
                        'target_word' => 'is announcing on the 15th (Scheduled Arrangement)',
                        'vocab' => [
                            ['en' => 'committee', 'id' => 'panitia'],
                            ['en' => 'innovation contest winners', 'id' => 'pemenang lomba inovasi'],
                            ['en' => 'on the 15th', 'id' => 'pada tanggal 15'],
                        ],
                        'options' => [
                            'The committee is announcing the innovation contest winners on the 15th.',
                            'The committee will to announce the innovation contest winners on the 15th.',
                            'The committee is going to announced the innovation contest winners on the 15th.',
                            'The committee announcing will the innovation contest winners on the 15th.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jadwal pengumuman resmi ('on the 15th') secara efektif dinyatakan dengan Present Continuous 'is announcing'.",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Kami berjanji bahwa data pelanggan akan tetap aman bersama kami.',
                        'target_word' => 'will remain (Formal Promise)',
                        'vocab' => [
                            ['en' => 'promise', 'id' => 'berjanji'],
                            ['en' => 'customer data', 'id' => 'data pelanggan'],
                            ['en' => 'remain safe', 'id' => 'tetap aman'],
                        ],
                        'options' => [
                            'We promise that customer data will remain safe with us.',
                            'We promise that customer data are remaining safe with us.',
                            'We promise that customer data will to remain safe with us.',
                            'We promise that customer data is going to remaining safe with us.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Janji formal (promise, guarantee) selalu menggunakan 'will + V1' ('will remain').",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Grafik performa menunjukkan bahwa penjualan rata-rata akan melampaui target tahun ini.',
                        'target_word' => 'is going to exceed (Chart Evidence)',
                        'vocab' => [
                            ['en' => 'the performance chart shows', 'id' => 'grafik performa menunjukkan'],
                            ['en' => 'average sales', 'id' => 'penjualan rata-rata'],
                            ['en' => 'exceed the target', 'id' => 'melampaui target'],
                        ],
                        'options' => [
                            'The performance chart shows that average sales is going to exceed the target this year.',
                            'The performance chart shows that average sales are going to exceed the target this year.',
                            'The performance chart shows that average sales is going to exceeding the target this year.',
                            'The performance chart shows that average sales will to exceed the target this year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Data tren visual yang terlihat ('the performance chart shows') lazim dilaporkan dengan 'is going to exceed' (subjek tunggal 'sales').",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Pak Direktur memimpin rombongan kunjungan ke pabrik baru hari Kamis ini.',
                        'target_word' => 'is leading on Thursday (Definite Trip Arrangement)',
                        'vocab' => [
                            ['en' => 'lead the visit group', 'id' => 'memimpin rombongan kunjungan'],
                            ['en' => 'this Thursday', 'id' => 'hari Kamis ini'],
                        ],
                        'options' => [
                            'The director is leading the visit group to the new factory this coming Thursday.',
                            'The director will to lead the visit group to the new factory this coming Thursday.',
                            'The director is going to led the visit group to the new factory this coming Thursday.',
                            'The director will leading the visit group to the new factory this coming Thursday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rencana perjalanan dengan tanggal pasti ('this coming Thursday') diekspresikan dengan Present Continuous 'is leading'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Berolahraga setiap pagi akan membuat tubuhmu lebih bugar.',
                        'target_word' => 'will make (General Prediction)',
                        'vocab' => [
                            ['en' => 'exercising every morning', 'id' => 'berolahraga setiap pagi'],
                            ['en' => 'make your body fitter', 'id' => 'membuat tubuhmu lebih bugar'],
                        ],
                        'options' => [
                            'Exercising every morning will make your body fitter.',
                            'Exercising every morning will makes your body fitter.',
                            'Exercising every morning is making your body fitter next week.',
                            'Exercising every morning will to make your body fitter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Prediksi umum tentang manfaat suatu kebiasaan diungkapkan dengan modal 'will make'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Melihat antrean yang semakin panjang, kasir akan membuka konter tambahan.',
                        'target_word' => 'is going to open (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'the growing queue', 'id' => 'antrean yang semakin panjang'],
                            ['en' => 'cashier', 'id' => 'kasir'],
                            ['en' => 'open an extra counter', 'id' => 'membuka konter tambahan'],
                        ],
                        'options' => [
                            'Judging by the growing queue, the cashier is going to open an extra counter.',
                            'Judging by the growing queue, the cashier are going to open an extra counter.',
                            'Judging by the growing queue, the cashier is going to opening an extra counter.',
                            'Judging by the growing queue, the cashier will to open an extra counter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan yang didasari bukti nyata ('Judging by the growing queue...') menggunakan 'is going to open'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Rekan-rekan tim menandatangani kartu ucapan untuk supervisor besok pagi.',
                        'target_word' => 'are signing tomorrow (Scheduled Team Activity)',
                        'vocab' => [
                            ['en' => 'team members', 'id' => 'rekan-rekan tim'],
                            ['en' => 'greeting card', 'id' => 'kartu ucapan'],
                            ['en' => 'supervisor', 'id' => 'supervisor'],
                        ],
                        'options' => [
                            'Team members are signing the greeting card for the supervisor tomorrow morning.',
                            'Team members will to sign the greeting card for the supervisor tomorrow morning.',
                            'Team members are going to signed the greeting card for the supervisor tomorrow morning.',
                            'Team members will signing the greeting card for the supervisor tomorrow morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jadwal kegiatan tim yang sudah ditetapkan ('tomorrow morning') memakai Present Continuous 'are signing'.",
                    ],
                ]
            ],
            [
                'id' => 'future-negative-interrogative',
                'name' => '1.11.6 Simple Future Negative & Interrogative: Denying Plans & Asking About the Future',
                'code' => '1.11.6',
                'concept_title' => 'Simple Future Negatif & Interogatif: Menyangkal Rencana & Bertanya Tentang Masa Depan',
                'concept_description' => "Bentuk negatif Simple Future ('will not' / 'is/are not going to') digunakan untuk menyangkal suatu rencana atau menolak melakukan sesuatu di masa depan. Bentuk interogatif ('Will + Subject + V1...?' atau 'Is/Are + Subject + going to...?') digunakan untuk menanyakan rencana atau prediksi orang lain.",
                'description' => "Bentuk negatif Simple Future ('will not' / 'is/are not going to') digunakan untuk menyangkal suatu rencana atau menolak melakukan sesuatu di masa depan. Bentuk interogatif ('Will + Subject + V1...?' atau 'Is/Are + Subject + going to...?') digunakan untuk menanyakan rencana atau prediksi orang lain.",
                'formula' => 'Negative: Subject + will NOT + V1 / be Adj/V3 | Interrogative: Will + Subject + V1 / be V3?',
                'rules' => [
                    "Bentuk negatif: 'will not + V1' atau 'will not be + V3/Adj'. Boleh disingkat 'won't' dalam percakapan santai.",
                    "Untuk bentuk 'be going to' negatif: 'is/are not going to + V1'.",
                    "Kalimat tanya dimulai dengan modal 'Will' atau to be 'Is/Are' diikuti subjek dan verba bentuk dasar.",
                    'Dilarang menggunakan do/does not sebelum will (*does not will arrive adalah SALAH).',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Prosedur baru ini tidak akan membuat proses persetujuan menjadi berbelit-belit.',
                        'target_word' => 'will not make (Negative Verbal with Will)',
                        'vocab' => [
                            ['en' => 'new procedure', 'id' => 'prosedur baru'],
                            ['en' => 'make the approval process complicated', 'id' => 'membuat proses persetujuan berbelit-belit'],
                        ],
                        'options' => [
                            'This new procedure will not make the approval process complicated.',
                            'This new procedure will not makes the approval process complicated.',
                            'This new procedure does not will make the approval process complicated.',
                            'This new procedure will not to make the approval process complicated.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk negatif modal adalah 'will not' diikuti kata kerja dasar murni 'make'.",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Dokumen itu tidak akan disimpan di server lama agar tidak rusak karena pembaruan sistem.',
                        'target_word' => 'will not be stored (Negative Passive)',
                        'vocab' => [
                            ['en' => 'the documents', 'id' => 'dokumen itu'],
                            ['en' => 'stored on the old server', 'id' => 'disimpan di server lama'],
                            ['en' => 'damaged by the system update', 'id' => 'rusak karena pembaruan sistem'],
                        ],
                        'options' => [
                            'The documents will not be stored on the old server so they are not damaged by the system update.',
                            'The documents will not stored on the old server so they are not damaged by the system update.',
                            'The documents will not be store on the old server so they are not damaged by the system update.',
                            'The documents do not will be stored on the old server so they are not damaged by the system update.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola pasif negatif masa depan adalah 'will not be' + V3 'stored'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Apakah tim pemasaran kita akan mengalahkan target penjualan kuartal ini?',
                        'target_word' => 'Will ... beat (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'our marketing team', 'id' => 'tim pemasaran kita'],
                            ['en' => 'beat', 'id' => 'mengalahkan'],
                            ['en' => "this quarter's sales target", 'id' => 'target penjualan kuartal ini'],
                        ],
                        'options' => [
                            "Will our marketing team beat this quarter's sales target?",
                            "Will our marketing team beats this quarter's sales target?",
                            "Does our marketing team will beat this quarter's sales target?",
                            "Will our marketing team to beat this quarter's sales target?",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertanyaan masa depan diawali 'Will' + Subject + V1 'beat'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Kenaikan biaya langganan yang kecil ini tidak akan menghalangi kami untuk tetap berlangganan.',
                        'target_word' => 'will not stop (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'this small subscription fee increase', 'id' => 'kenaikan biaya langganan yang kecil ini'],
                            ['en' => 'stop us from subscribing', 'id' => 'menghalangi kami berlangganan'],
                        ],
                        'options' => [
                            'This small subscription fee increase will not stop us from subscribing.',
                            'This small subscription fee increase will not stops us from subscribing.',
                            'This small subscription fee increase does not will stop us from subscribing.',
                            'This small subscription fee increase will not to stop us from subscribing.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will not stop' memaparkan penyangkalan dampak secara lugas.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Apakah acara peluncuran produk akan diadakan di gedung utama atau di hotel?',
                        'target_word' => 'Will ... be held (Interrogative Passive)',
                        'vocab' => [
                            ['en' => 'product launch event', 'id' => 'acara peluncuran produk'],
                            ['en' => 'held', 'id' => 'diadakan'],
                            ['en' => 'main building or the hotel', 'id' => 'gedung utama atau hotel'],
                        ],
                        'options' => [
                            'Will the product launch event be held in the main building or the hotel?',
                            'Will the product launch event hold in the main building or the hotel?',
                            'Will the product launch event be hold in the main building or the hotel?',
                            'Is the product launch event will be held in the main building or the hotel?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertanyaan pasif masa depan menggunakan struktur: 'Will' + Subject + 'be' + V3 ('be held').",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Perusahaan kami tidak akan mengurangi jatah cuti tahunan tahun depan.',
                        'target_word' => 'is not going to reduce (Negative with Be Going To)',
                        'vocab' => [
                            ['en' => 'our company', 'id' => 'perusahaan kami'],
                            ['en' => 'reduce annual leave allowance', 'id' => 'mengurangi jatah cuti tahunan'],
                            ['en' => 'next year', 'id' => 'tahun depan'],
                        ],
                        'options' => [
                            'Our company is not going to reduce annual leave allowance next year.',
                            'Our company are not going to reduce annual leave allowance next year.',
                            'Our company is not going to reducing annual leave allowance next year.',
                            'Our company not is going to reduce annual leave allowance next year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our company' berpasangan dengan 'is not going to reduce'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah musim liburan tahun ini akan mengubah jadwal pengiriman kurir?',
                        'target_word' => 'Will ... change (Interrogative Verbal)',
                        'vocab' => [
                            ["en" => "this year's holiday season", "id" => "musim liburan tahun ini"],
                            ['en' => "change the courier's delivery schedule", 'id' => 'mengubah jadwal pengiriman kurir'],
                        ],
                        'options' => [
                            "Will this year's holiday season change the courier's delivery schedule?",
                            "Will this year's holiday season changes the courier's delivery schedule?",
                            "Does this year's holiday season will change the courier's delivery schedule?",
                            "Will this year's holiday season to change the courier's delivery schedule?",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Will' diletakkan di depan subjek 'this year's holiday season' dan diikuti V1 'change'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Nomor telepon pribadi karyawan tidak akan dibagikan kepada pihak luar tanpa izin.',
                        'target_word' => 'will not be shared (Negative Passive)',
                        'vocab' => [
                            ["en" => "employees' personal phone numbers", "id" => "nomor telepon pribadi karyawan"],
                            ['en' => 'shared with outsiders', 'id' => 'dibagikan kepada pihak luar'],
                            ['en' => 'without permission', 'id' => 'tanpa izin'],
                        ],
                        'options' => [
                            "Employees' personal phone numbers will not be shared with outsiders without permission.",
                            "Employees' personal phone numbers will not shared with outsiders without permission.",
                            "Employees' personal phone numbers will not be share with outsiders without permission.",
                            "Employees' personal phone numbers do not will be shared with outsiders without permission.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola pasif negatif 'will not be shared' (will not be + V3).",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Formulir kertas lama tidak akan dipakai lagi setelah sistem baru diterapkan.',
                        'target_word' => 'are not going to be used (Negative Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'old paper forms', 'id' => 'formulir kertas lama'],
                            ['en' => 'used', 'id' => 'dipakai'],
                            ['en' => 'new system', 'id' => 'sistem baru'],
                        ],
                        'options' => [
                            'Old paper forms are not going to be used once the new system is applied.',
                            'Old paper forms is not going to be used once the new system is applied.',
                            'Old paper forms are not going to be use once the new system is applied.',
                            'Old paper forms are not going to used once the new system is applied.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'forms' memakai 'are not going to be used'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah prosedur baru ini akan memberikan hasil yang lebih cepat dari sebelumnya?',
                        'target_word' => 'Will ... give (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'this new procedure', 'id' => 'prosedur baru ini'],
                            ['en' => 'faster results', 'id' => 'hasil yang lebih cepat'],
                            ['en' => 'than before', 'id' => 'dari sebelumnya'],
                        ],
                        'options' => [
                            'Will this new procedure give faster results than before?',
                            'Will this new procedure gives faster results than before?',
                            'Does this new procedure will give faster results than before?',
                            'Will this new procedure to give faster results than before?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Will' + Subject ('this new procedure') + V1 ('give').",
                    ],
                ]
            ],
            [
                'id' => 'future-time-clauses',
                'name' => "1.11.7 Future Time Clauses: The 'No Future in Time Clauses' Rule",
                'code' => '1.11.7',
                'concept_title' => "Klausa Waktu Masa Depan: Aturan Larangan 'Will' dalam Time Clauses",
                'concept_description' => "Salah satu aturan penting dalam Bahasa Inggris adalah: anak kalimat yang diawali konjungsi waktu (when, as soon as, once, after, before, until) atau syarat (if, unless, provided that) DILARANG menggunakan kata kerja masa depan ('will' atau 'be going to'). Anak kalimat tersebut WAJIB menggunakan Simple Present Tense (V1/V-s), meskipun maknanya merujuk ke masa depan. Bentuk Simple Future ('will') hanya diletakkan pada induk kalimat (Main Clause).",
                'description' => "Salah satu aturan penting dalam Bahasa Inggris adalah: anak kalimat yang diawali konjungsi waktu (when, as soon as, once, after, before, until) atau syarat (if, unless, provided that) DILARANG menggunakan kata kerja masa depan ('will' atau 'be going to'). Anak kalimat tersebut WAJIB menggunakan Simple Present Tense (V1/V-s), meskipun maknanya merujuk ke masa depan. Bentuk Simple Future ('will') hanya diletakkan pada induk kalimat (Main Clause).",
                'formula' => 'Time Conjunction (When/Once/As soon as/Provided that) + Subject + Verb 1/V-s (Simple Present), Subject + will + V1',
                'rules' => [
                    "Dilarang menggunakan 'will' dalam klausa yang diawali: when, as soon as, once, after, before, until, if, unless, provided that (*When the client will confirm adalah KESALAHAN).",
                    'Gunakan Simple Present (V1 atau V-s) di dalam anak kalimat waktu.',
                    "Gunakan 'will + V1' atau 'will be + V3' di dalam induk kalimat (Main Clause).",
                    'Jika anak kalimat diletakkan di awal, wajib dipisahkan dengan tanda koma sebelum induk kalimat.',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Ketika klien mengonfirmasi pesanan, kami akan mulai memproses pengiriman.',
                        'target_word' => 'confirms ... will start (Time Clause Rule)',
                        'vocab' => [
                            ['en' => 'client confirms the order', 'id' => 'klien mengonfirmasi pesanan'],
                            ['en' => 'start processing the shipment', 'id' => 'mulai memproses pengiriman'],
                        ],
                        'options' => [
                            'When the client confirms the order, we will start processing the shipment.',
                            'When the client will confirm the order, we will start processing the shipment.',
                            'When the client confirms the order, we start will processing the shipment.',
                            'When the client is going to confirm the order, we will start processing the shipment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa waktu yang diawali 'When' wajib menggunakan Simple Present ('confirms'), bukan 'will confirm'. Modal 'will' hanya ada pada induk kalimat ('will start').",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Segera setelah laporan selesai disusun, kami akan mengirimkannya ke manajemen.',
                        'target_word' => 'is finished ... will send (Passive Time Clause)',
                        'vocab' => [
                            ['en' => 'as soon as', 'id' => 'segera setelah'],
                            ['en' => 'report is finished', 'id' => 'laporan selesai disusun'],
                            ['en' => 'send it to management', 'id' => 'mengirimkannya ke manajemen'],
                        ],
                        'options' => [
                            'As soon as the report is finished, we will send it to management.',
                            'As soon as the report will be finished, we will send it to management.',
                            'As soon as the report is finished, we send will it to management.',
                            'As soon as the report will finish, we will send it to management.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah konjungsi 'As soon as', gunakan Simple Present Pasif ('is finished'), bukan 'will be finished'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Setelah manajer menyetujui anggaran itu, kami akan mulai mempersiapkan acara.',
                        'target_word' => 'approves ... will start (Time Clause Rule)',
                        'vocab' => [
                            ['en' => 'manager approves', 'id' => 'manajer menyetujui'],
                            ['en' => 'the budget', 'id' => 'anggaran itu'],
                            ['en' => 'start preparing the event', 'id' => 'mulai mempersiapkan acara'],
                        ],
                        'options' => [
                            'Once the manager approves the budget, we will start preparing the event.',
                            'Once the manager will approve the budget, we will start preparing the event.',
                            'Once the manager approves the budget, we start will preparing the event.',
                            'Once the manager will approves the budget, we will start preparing the event.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa waktu 'Once...' wajib memakai Simple Present 'approves'. Induk kalimat memakai 'will start'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Manajemen tidak akan mengizinkan kami cuti sebelum laporan akhir tahun selesai dikerjakan.',
                        'target_word' => 'will not allow ... is finished (Before Time Clause)',
                        'vocab' => [
                            ['en' => 'allow us to take leave', 'id' => 'mengizinkan kami cuti'],
                            ['en' => 'year-end report is finished', 'id' => 'laporan akhir tahun selesai'],
                        ],
                        'options' => [
                            'Management will not allow us to take leave before the year-end report is finished.',
                            'Management will not allow us to take leave before the year-end report will be finished.',
                            'Management does not allow us to take leave before the year-end report will be finished.',
                            'Management will not to allow us to take leave before the year-end report is finished.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah konjungsi 'before', kata kerja wajib Simple Present 'is finished'.",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Jika produk ini terbukti laris, desainnya akan dibagikan kepada seluruh tim regional.',
                        'target_word' => 'proves ... will be shared (Conditional + Passive Future)',
                        'vocab' => [
                            ['en' => 'proves popular', 'id' => 'terbukti laris'],
                            ['en' => 'shared with the entire regional team', 'id' => 'dibagikan kepada seluruh tim regional'],
                        ],
                        'options' => [
                            'If this product proves popular, the design will be shared with the entire regional team.',
                            'If this product will prove popular, the design will be shared with the entire regional team.',
                            'If this product proves popular, the design will shared with the entire regional team.',
                            'If this product is will prove popular, the design will be shared with the entire regional team.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' menggunakan Simple Present 'proves', sedangkan induk kalimat menggunakan pasif masa depan 'will be shared'.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Kecuali jika izin anggaran diperoleh minggu ini, perjalanan dinas akan dibatalkan sementara.',
                        'target_word' => 'is obtained ... will be canceled (Unless Clause)',
                        'vocab' => [
                            ['en' => 'unless budget approval is obtained', 'id' => 'kecuali izin anggaran diperoleh'],
                            ['en' => 'business trip', 'id' => 'perjalanan dinas'],
                            ['en' => 'canceled', 'id' => 'dibatalkan'],
                        ],
                        'options' => [
                            'Unless budget approval is obtained this week, the business trip will be canceled temporarily.',
                            'Unless budget approval will be obtained this week, the business trip will be canceled temporarily.',
                            'Unless budget approval is obtained this week, the business trip is canceled will temporarily.',
                            'Unless budget approval will obtain this week, the business trip will be canceled temporarily.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'Unless' menggunakan Simple Present Pasif 'is obtained'. Induk kalimat menggunakan 'will be canceled'.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Setelah tim magang menyelesaikan pelatihan dasar, mereka akan mulai menangani proyek kecil.',
                        'target_word' => 'complete ... will start (After Time Clause)',
                        'vocab' => [
                            ['en' => 'the intern team completes', 'id' => 'tim magang menyelesaikan'],
                            ['en' => 'basic training', 'id' => 'pelatihan dasar'],
                            ['en' => 'start handling small projects', 'id' => 'mulai menangani proyek kecil'],
                        ],
                        'options' => [
                            'After the intern team completes basic training, they will start handling small projects.',
                            'After the intern team will complete basic training, they will start handling small projects.',
                            'After the intern team completes basic training, they start will handling small projects.',
                            'After the intern team will to complete basic training, they will start handling small projects.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah 'After', gunakan Simple Present 'completes' (subjek jamak 'intern team' di sini diperlakukan sebagai satu entitas, sehingga 'completes').",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Kami akan menunda perjalanan dinas sampai cuaca kembali membaik.',
                        'target_word' => 'will postpone ... returns (Until Time Clause)',
                        'vocab' => [
                            ['en' => 'our business trip', 'id' => 'perjalanan dinas kami'],
                            ['en' => 'weather returns to normal', 'id' => 'cuaca kembali membaik'],
                        ],
                        'options' => [
                            'We will postpone our business trip until the weather returns to normal.',
                            'We will postpone our business trip until the weather will return to normal.',
                            'We postpone will our business trip until the weather returns to normal.',
                            'We will to postpone our business trip until the weather returns to normal.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa setelah 'until' wajib menggunakan Simple Present tunggal 'returns', bukan 'will return'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Begitu presentasi selesai disiapkan, kita akan langsung mengirimkannya ke klien.',
                        'target_word' => 'is prepared ... will send (As soon as Time Clause)',
                        'vocab' => [
                            ['en' => 'presentation is prepared', 'id' => 'presentasi selesai disiapkan'],
                            ['en' => 'send it to the client right away', 'id' => 'langsung mengirimkannya ke klien'],
                        ],
                        'options' => [
                            'As soon as the presentation is prepared, we will send it to the client right away.',
                            'As soon as the presentation will be prepared, we will send it to the client right away.',
                            'As soon as the presentation is prepared, we send will it to the client right away.',
                            'As soon as the presentation will prepare, we will send it to the client right away.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'As soon as' + Simple Present Pasif tunggal 'is prepared', diikuti induk kalimat 'will send'.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Jika kamu rajin berlatih presentasi setiap hari, kemampuan berbicaramu akan meningkat pesat.',
                        'target_word' => 'practice ... will improve (Conditional Clause)',
                        'vocab' => [
                            ['en' => 'practice presenting diligently every day', 'id' => 'rajin berlatih presentasi setiap hari'],
                            ['en' => 'your speaking skills', 'id' => 'kemampuan berbicaramu'],
                            ['en' => 'improve rapidly', 'id' => 'meningkat pesat'],
                        ],
                        'options' => [
                            'If you practice presenting diligently every day, your speaking skills will improve rapidly.',
                            'If you will practice presenting diligently every day, your speaking skills will improve rapidly.',
                            'If you practice presenting diligently every day, your speaking skills improve will rapidly.',
                            'If you are going to practice presenting diligently every day, your speaking skills will improve rapidly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' menggunakan Simple Present 'practice', dan induk kalimat menggunakan 'will improve'.",
                    ],
                ]
            ],
            [
                'id' => 'future-event-roadmap-synthesis',
                'name' => '1.11.8 Comprehensive Synthesis: Planning a Community Fundraising Event',
                'code' => '1.11.8',
                'concept_title' => 'Sintesis Komprehensif: Merencanakan Acara Penggalangan Dana Komunitas',
                'concept_description' => "Menggabungkan seluruh variasi Simple Future (aktif 'will', bukti 'be going to', bentuk nominal, bentuk pasif, dan aturan klausa waktu) ke dalam narasi yang runtut, seperti merencanakan acara komunitas, peluncuran produk, atau kegiatan kantor.",
                'description' => "Menggabungkan seluruh variasi Simple Future (aktif 'will', bukti 'be going to', bentuk nominal, bentuk pasif, dan aturan klausa waktu) ke dalam narasi yang runtut, seperti merencanakan acara komunitas, peluncuran produk, atau kegiatan kantor.",
                'formula' => 'Synthesized Future Narrative: Time/Condition Clause + Passive Future Plan + Direct Projection',
                'rules' => [
                    "Gunakan Simple Present dalam anak kalimat bersyarat/waktu ('Once the sponsors confirm...').",
                    "Gunakan Future Passive untuk hal yang sudah direncanakan ('...the venue will be decorated').",
                    "Gunakan Future Active untuk akibat langsung ('...which will boost attendance').",
                    'Jaga konsistensi logika waktu dan keselarasan subjek-verba di seluruh kalimat majemuk.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Begitu semua sponsor mengonfirmasi, tenda akan didirikan, yang akan membuat persiapan lebih mudah.',
                        'target_word' => 'confirm ... will be set up ... will make (Event Synthesis)',
                        'vocab' => [
                            ['en' => 'all the sponsors confirm', 'id' => 'semua sponsor mengonfirmasi'],
                            ['en' => 'the tents will be set up', 'id' => 'tenda akan didirikan'],
                            ['en' => 'will make preparation easier', 'id' => 'akan membuat persiapan lebih mudah'],
                        ],
                        'options' => [
                            'Once all the sponsors confirm, the tents will be set up, which will make preparation easier.',
                            'Once all the sponsors will confirm, the tents will be set up, which will make preparation easier.',
                            'Once all the sponsors confirm, the tents will setting up, which will make preparation easier.',
                            'Once all the sponsors will confirm, the tents will setting up, which will make preparation easier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'Once' menggunakan Simple Present 'confirm'. Induk kalimat menggunakan Future Pasif 'will be set up', dilanjutkan relative clause aktif 'which will make'.",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Jika cuaca tetap cerah, kita akan mengadakan acara di halaman, dan suasananya akan lebih meriah.',
                        'target_word' => 'stays ... will hold ... will be (Conditional Future Synthesis)',
                        'vocab' => [
                            ['en' => 'weather stays sunny', 'id' => 'cuaca tetap cerah'],
                            ['en' => 'we will hold the event in the yard', 'id' => 'kita akan mengadakan acara di halaman'],
                            ['en' => 'will be livelier', 'id' => 'akan lebih meriah'],
                        ],
                        'options' => [
                            'If the weather stays sunny, we will hold the event in the yard, and the mood will be livelier.',
                            'If the weather will stay sunny, we will hold the event in the yard, and the mood will be livelier.',
                            'If the weather stays sunny, we will holds the event in the yard, and the mood will are livelier.',
                            'If the weather stays sunny, we will hold the event in the yard, and the mood will being livelier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa syarat memakai Simple Present 'stays', diikuti dua klausa masa depan: aktif 'will hold' dan nominal 'will be livelier'.",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Panitia memperkirakan bahwa panggung utama akan siap sebelum tamu pertama datang.',
                        'target_word' => 'will be ready (Future Nominal Projection)',
                        'vocab' => [
                            ['en' => 'the committee anticipates', 'id' => 'panitia memperkirakan'],
                            ['en' => 'main stage', 'id' => 'panggung utama'],
                            ['en' => 'ready before the first guest arrives', 'id' => 'siap sebelum tamu pertama datang'],
                        ],
                        'options' => [
                            'The committee anticipates that the main stage will be ready before the first guest arrives.',
                            'The committee anticipates that the main stage will ready before the first guest arrives.',
                            'The committee anticipates that the main stage will are ready before the first guest arrives.',
                            'The committee anticipates that the main stage will to be ready before the first guest arrives.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be ready' sebelum adjective 'ready'.",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Sebelum acara dimulai, semua kursi akan ditata ulang secara rapi oleh para sukarelawan.',
                        'target_word' => 'begins ... will be rearranged (Time Clause with Passive Main)',
                        'vocab' => [
                            ['en' => 'event begins', 'id' => 'acara dimulai'],
                            ['en' => 'all the chairs', 'id' => 'semua kursi'],
                            ['en' => 'rearranged neatly', 'id' => 'ditata ulang secara rapi'],
                        ],
                        'options' => [
                            'Before the event begins, all the chairs will be rearranged neatly by the volunteers.',
                            'Before the event will begin, all the chairs will be rearranged neatly by the volunteers.',
                            'Before the event begins, all the chairs will rearrange neatly by the volunteers.',
                            'Before the event will begins, all the chairs will being rearranged neatly by the volunteers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Before' + Simple Present tunggal 'begins', disusul Future Pasif 'will be rearranged'.",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Karena langit tampak mendung, tenda cadangan akan dipasang untuk berjaga-jaga.',
                        'target_word' => 'is going to be set up (Evidence-Based Passive)',
                        'vocab' => [
                            ['en' => 'sky looks cloudy', 'id' => 'langit tampak mendung'],
                            ['en' => 'backup tent', 'id' => 'tenda cadangan'],
                            ['en' => 'set up just in case', 'id' => 'dipasang untuk berjaga-jaga'],
                        ],
                        'options' => [
                            'Because the sky looks cloudy, a backup tent is going to be set up just in case.',
                            'Because the sky looks cloudy, a backup tent are going to be set up just in case.',
                            'Because the sky looks cloudy, a backup tent is going to be setting up just in case.',
                            'Because the sky looks cloudy, a backup tent going to be set up just in case.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Keputusan berbasis bukti nyata yang terlihat ('the sky looks cloudy') menggunakan pasif tunggal 'is going to be set up'.",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Ketika band mulai tampil, para pengunjung akan segera berkumpul, yang akan membuat suasana makin meriah.',
                        'target_word' => 'starts ... will gather ... will make (Event Multi-Clause)',
                        'vocab' => [
                            ['en' => 'band starts performing', 'id' => 'band mulai tampil'],
                            ['en' => 'visitors will gather', 'id' => 'pengunjung akan berkumpul'],
                            ['en' => 'will make the mood livelier', 'id' => 'akan membuat suasana makin meriah'],
                        ],
                        'options' => [
                            'When the band starts performing, the visitors will gather, which will make the mood livelier.',
                            'When the band will start performing, the visitors will gather, which will make the mood livelier.',
                            'When the band starts performing, the visitors will gathers, which will make the mood livelier.',
                            'When the band starts performing, the visitors will gather, which making will the mood livelier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'When' menggunakan Simple Present 'starts', induk kalimat memakai 'will gather', dan relative clause hasil memakai 'which will make'.",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Meskipun persiapannya akan melelahkan, melihat acara berjalan lancar akan sepadan dengan usaha kami.',
                        'target_word' => 'will be tiring ... will be worth (Dual Future Contrast)',
                        'vocab' => [
                            ['en' => 'the preparation', 'id' => 'persiapannya'],
                            ['en' => 'tiring', 'id' => 'melelahkan'],
                            ['en' => 'seeing the event run smoothly', 'id' => 'melihat acara berjalan lancar'],
                            ['en' => 'worth our effort', 'id' => 'sepadan dengan usaha kami'],
                        ],
                        'options' => [
                            'Although the preparation will be tiring, seeing the event run smoothly will be worth our effort.',
                            'Although the preparation will tiring, seeing the event run smoothly will be worth our effort.',
                            'Although the preparation will are tiring, seeing the event run smoothly will be worth our effort.',
                            'Although the preparation will being tiring, seeing the event run smoothly will be worth our effort.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa konsesi memakai nominal masa depan 'will be tiring', disusul klausa utama nominal 'will be worth'.",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Setelah pidato pembuka selesai disampaikan, donasi akan mulai dikumpulkan dari para pengunjung.',
                        'target_word' => 'is delivered ... will be collected (Event Milestone Synthesis)',
                        'vocab' => [
                            ['en' => 'opening speech is delivered', 'id' => 'pidato pembuka disampaikan'],
                            ['en' => 'donations', 'id' => 'donasi'],
                            ['en' => 'collected from visitors', 'id' => 'dikumpulkan dari pengunjung'],
                        ],
                        'options' => [
                            'After the opening speech is delivered, donations will be collected from visitors.',
                            'After the opening speech will be delivered, donations will be collected from visitors.',
                            'After the opening speech is delivered, donations will collect from visitors.',
                            'After the opening speech will deliver, donations will be collected from visitors.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'After' + Simple Present Pasif 'is delivered', diikuti Future Pasif 'will be collected'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Jika hujan tidak berhenti sampai sore, acara akan dipindahkan ke dalam gedung dan semua orang akan tetap senang.',
                        'target_word' => 'does not stop ... will be moved ... will be (Triple Future Clause)',
                        'vocab' => [
                            ['en' => 'rain does not stop by evening', 'id' => 'hujan tidak berhenti sampai sore'],
                            ['en' => 'the event will be moved indoors', 'id' => 'acara akan dipindahkan ke dalam gedung'],
                            ['en' => 'everyone will still be happy', 'id' => 'semua orang akan tetap senang'],
                        ],
                        'options' => [
                            'If the rain does not stop by evening, the event will be moved indoors and everyone will still be happy.',
                            'If the rain will not stop by evening, the event will be moved indoors and everyone will still be happy.',
                            'If the rain does not stop by evening, the event will moved indoors and everyone will still happy.',
                            'If the rain does not stop by evening, the event will be moved indoors and everyone will still being happy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' memakai Simple Present negatif 'does not stop'. Induk kalimat memadukan pasif 'will be moved' dan nominal 'will be happy'.",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Jadwal acara ini menegaskan bahwa penggalangan dana akan menjadi kesuksesan besar segera setelah semua sponsor memastikan kehadiran.',
                        'target_word' => 'will be ... as soon as ... confirm (Event Plan Climax)',
                        'vocab' => [
                            ['en' => 'this event schedule confirms', 'id' => 'jadwal acara ini menegaskan'],
                            ['en' => 'a great success', 'id' => 'kesuksesan besar'],
                            ['en' => 'all the sponsors confirm attendance', 'id' => 'semua sponsor memastikan kehadiran'],
                        ],
                        'options' => [
                            'This event schedule confirms that the fundraiser will be a great success as soon as all the sponsors confirm attendance.',
                            'This event schedule confirms that the fundraiser will be a great success as soon as all the sponsors will confirm attendance.',
                            'This event schedule confirms that the fundraiser will a great success as soon as all the sponsors confirm attendance.',
                            'This event schedule confirms that the fundraiser will is a great success as soon as all the sponsors confirm attendance.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa komplemen memakai Future Nominal 'will be a great success', disusul klausa waktu 'as soon as' dengan Simple Present jamak 'confirm'.",
                    ],
                ]
            ],
        ];
    }
}
