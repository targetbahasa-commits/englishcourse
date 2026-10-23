<?php

namespace App\Domain\CustomClass;

class CustomCurriculumHelper
{
    /**
     * Get pre-configured high-impact curriculum details for executive custom class meetings.
     */
    public static function getMeetingDetails(int $meetingNumber): ?array
    {
        $curriculum = [
            1 => [
                'topic' => 'Simple Present (Verbal, Nominal & Passive)',
                'grammar' => [
                    'title' => 'Simple Present: Verbal, Nominal & Passive Sentences',
                    'subtitle' => 'Penguasaan Komprehensif Kalimat Verbal (Aktif), Nominal (State of Being), dan Pasif (Object/Result Focus) pada Simple Present',
                    'patterns' => [
                        'Simple Present Verbal (Aktif): S + V1(s/es) + O',
                        'Simple Present Nominal: S + is/am/are + Complement (Adjective / Noun / Adverb)',
                        'Simple Present Passive: S + is/am/are + V3 (+ by Agent)',
                    ],
                    'concept' => 'Simple Present digunakan untuk menyatakan fakta umum (general truths), kebiasaan/rutinitas (habits/routines), dan kondisi permanen. Kalimat Verbal berfokus pada subjek pelaku tindakan (agent). Kalimat Nominal mendeskripsikan kondisi, status, karakteristik, atau identitas subjek tanpa kata kerja aksi melalui Linking Verb (is/am/are + Complement). Kalimat Pasif mengalihkan fokus utama pada objek atau hasil tindakan (result/action) dengan pola is/am/are + V3.',
                    'examples' => [
                        'Verbal (Aktif): "Our research team analyzes water quality samples every morning."',
                        'Nominal: "Clean drinking water is essential and vital for community well-being."',
                        'Passive: "Plastic bottles are collected and recycled at the local processing plant."',
                    ],
                    'practice_task' => 'Terjemahkan kalimat berikut dengan cermat, identifikasi apakah kalimat tersebut Verbal (Aktif), Nominal, atau Pasif pada Simple Present.',
                ],
                'speaking' => [
                    'title' => 'Simple Present Spoken Fluency Mastery',
                    'subtitle' => 'Latihan Kelancaran Spontan Beralih Antara Verbal, Nominal, dan Pasif (Daily Life, Social Issues & Science)',
                    'target' => 'Siswa mampu secara spontan beralih antara kalimat verbal (pelaku aksi), nominal (kondisi/status), dan pasif (hasil/proses) dalam Simple Present saat berdiskusi dan presentasi.',
                    'main_theme' => 'Simple Present: Daily Habits, Social Issues & Environmental Science',
                    'scenarios' => [
                        'Personal Life & Routines: Jelaskan aktivitas harian, kebiasaan belajar, dan pola hidup sehat menggunakan kalimat verbal dan nominal.',
                        'Social Issues & Environmental Science: Bahas kesadaran kesehatan mental, kesenjangan digital, dan pemilahan sampah menggunakan kalimat pasif dan aktif.',
                    ],
                    'delivery_rules' => [
                        'Gunakan kalimat verbal (V1/s/es) saat menegaskan peran dan kebiasaan subjek pelaku.',
                        'Gunakan kalimat nominal (is/am/are + Adj/Noun) saat mendeskripsikan status, karakteristik, atau kondisi.',
                        'Gunakan kalimat pasif (is/am/are + V3) saat memaparkan proses, regulasi, atau dampak yang diterima objek.',
                    ],
                    'discussion_prompt' => 'Sampaikan paparan lisan 2 menit yang memadukan kalimat verbal, nominal, dan pasif dalam Simple Present.',
                ],
            ],

            2 => [
                'topic' => 'Simple Present vs. Simple Past',
                'grammar' => [
                    'title' => 'Simple Present vs. Simple Past (Verbal, Nominal & Passive)',
                    'subtitle' => 'Perbandingan Dimensi Waktu: Fakta/Kebiasaan Masa Kini vs. Peristiwa Selesai Masa Lampau',
                    'patterns' => [
                        'Verbal: S + V1(s/es) + O (Present) vs. S + V2 + O (Past)',
                        'Nominal: S + is/am/are + Adj/Noun (Present) vs. S + was/were + Adj/Noun (Past)',
                        'Passive: S + is/am/are + V3 (Present) vs. S + was/were + V3 (Past)',
                        'Time Signals: always, currently, every day vs. yesterday, last year, two months ago, in 2021',
                    ],
                    'concept' => 'Membedakan secara tegas antara peristiwa/kondisi yang berlaku saat ini (Simple Present) dengan peristiwa yang sudah tuntas di masa lampau pada titik waktu spesifik (Simple Past). Fokus pada ketepatan perubahan kata kerja bentuk lampau (regular -ed & irregular verbs) serta perbedaan linking verb is/am/are vs was/were.',
                    'examples' => [
                        'Verbal: "The company operates five regional offices today, but it operated only one small office in 2018."',
                        'Nominal: "Air quality in the city center is satisfactory today, whereas it was hazardous last week."',
                        'Passive: "Thousands of solar panels are installed every month now, while the first solar plant was built ten years ago."',
                    ],
                    'practice_task' => 'Terjemahkan kalimat perbandingan masa lalu dan masa kini dengan perubahan bentuk tenses (V1 vs V2, is vs was) yang presisi.',
                ],
                'speaking' => [
                    'title' => 'Comparative Timeline Fluency: Past vs. Present',
                    'subtitle' => 'Menceritakan Latar Belakang, Pengalaman Lampau, dan Kondisi Terkini',
                    'target' => 'Siswa mampu menceritakan transformasi karier, perkembangan isu sosial, dan perubahan lingkungan dengan mengontraskan masa lalu dan masa kini secara lancar.',
                    'scenarios' => [
                        'Career & Study Transformation: Bandingkan pengalaman dan metode belajar Anda di masa lalu dengan rutinitas saat ini.',
                        'Urban & Environmental Changes: Jelaskan kondisi lingkungan kota 10 tahun lalu dibandingkan dengan kemajuan fasilitas publik saat ini.',
                    ],
                    'delivery_rules' => [
                        'Gunakan Simple Past saat merujuk waktu spesifik di masa lampau (last year, ago, in 2019).',
                        'Beralihlah secara mulus ke Simple Present saat mendeskripsikan situasi atau fakta saat ini.',
                        'Gunakan frasa transisi perbandingan ("In contrast", "Whereas previously", "Nowadays", "Back then").',
                    ],
                    'discussion_prompt' => 'Bandingkan gaya hidup dan kebiasaan masyarakat sebelum dan sesudah era digitalisasi menggunakan Simple Past dan Simple Present.',
                ],
            ],

            3 => [
                'topic' => 'Simple Past vs. Present Perfect',
                'grammar' => [
                    'title' => 'Simple Past vs. Present Perfect: Finished Event vs. Life Experience & Ongoing Impact',
                    'subtitle' => 'Titik Waktu Lampau Definitif vs. Rentang Waktu Terbuka & Dampak yang Relevan Hari Ini',
                    'patterns' => [
                        'Simple Past (Finished Time): S + V2 + O (+ yesterday / last week / two years ago / in 2022)',
                        'Present Perfect (Unfinished / Experience / Result): S + have/has + V3 (+ since / for / already / yet / ever / so far)',
                        'Passive Comparison: S + was/were + V3 (Past) vs. S + have/has been + V3 (Present Perfect)',
                    ],
                    'concept' => 'Simple Past digunakan saat peristiwa terjadi pada waktu lampau yang sudah selesai dan definitif. Sebaliknya, Present Perfect (have/has + V3) digunakan untuk aksi yang terjadi pada waktu tidak spesifik di masa lalu, pengalaman hidup (life experiences), atau aksi lampau yang dampaknya/akibatnya masih nyata dan relevan dengan situasi saat ini.',
                    'examples' => [
                        'Simple Past: "The ministry published a comprehensive climate report last month."',
                        'Present Perfect: "The ministry has published five major environmental reports since 2020."',
                        'Experience & Context: "She worked as a junior analyst in 2021, but she has led the sustainability division for three years now."',
                    ],
                    'practice_task' => 'Bedakan penggunaan Simple Past dan Present Perfect berdasarkan ada tidaknya penanda waktu spesifik dan kesinambungan dampak.',
                ],
                'speaking' => [
                    'title' => 'Professional Track Record & Milestone Discussion',
                    'subtitle' => 'Menyajikan Rekam Jejak, Pencapaian Hidup, dan Bukti Konkret',
                    'target' => 'Siswa mahir membuka topik dengan Present Perfect (pencapaian/pengalaman umum), lalu memperdalam rincian kronologis dengan Simple Past.',
                    'scenarios' => [
                        'Professional Achievements: Sampaikan pencapaian utama yang telah Anda raih ("I have worked on...") lalu detailkan peristiwa spesifiknya ("Last year, I completed...").',
                        'Conservation Milestones: Bahas program pelestarian lingkungan yang telah berjalan bertahun-tahun serta target spesifik yang dicapai tahun lalu.',
                    ],
                    'delivery_rules' => [
                        'Gunakan Present Perfect untuk membuka pengalaman hidup atau pencapaian kumulatif.',
                        'Pindah ke Simple Past saat masuk ke rincian waktu, tempat, atau kronologi spesifik.',
                        'Jangan mencampur penanda waktu spesifik (yesterday, ago) dengan Present Perfect.',
                    ],
                    'discussion_prompt' => 'Diskusikan pencapaian terpenting dalam pendidikan atau proyek Anda menggunakan kombinasi Present Perfect dan Simple Past.',
                ],
            ],

            4 => [
                'topic' => 'Present Continuous vs. Simple Past',
                'grammar' => [
                    'title' => 'Present Continuous vs. Simple Past: In-Progress Dynamics vs. Completed Milestones',
                    'subtitle' => 'Aktivitas yang Sedang Bergulir (Ongoing Reality) vs. Peristiwa Masa Lalu yang Telah Rampung',
                    'patterns' => [
                        'Present Continuous (Active): S + is/am/are + V-ing (+ right now / currently / at present)',
                        'Present Continuous (Passive): S + is/am/are + being + V3',
                        'Simple Past: S + V2 + O | S + was/were + V3',
                        'Stative Verbs Check: know, understand, believe, need (tidak digunakan dalam bentuk Continuous)',
                    ],
                    'concept' => 'Present Continuous (is/am/are + V-ing) menggambarkan aksi dinamis yang sedang berlangsung saat ini atau tren sementara yang sedang bergulir. Simple Past (V2) digunakan untuk peristiwa yang sudah selesai dan menjadi rekam jejak. Mengontraskan antara apa yang sudah diselesaikan (milestone) dengan apa yang sedang dikerjakan atau diuji coba saat ini (work in progress).',
                    'examples' => [
                        'Active Comparison: "The engineering team finalized the blueprint last week, and they are currently constructing the prototype."',
                        'Passive Comparison: "The solar facility was approved last semester, and new transmission cables are being installed right now."',
                        'Societal Trends: "Many households used plastic bags in the past, but more families are adopting reusable tote bags today."',
                    ],
                    'practice_task' => 'Terjemahkan kalimat yang mengontraskan milestone masa lalu yang telah tuntas dengan aksi/proses yang sedang berjalan saat ini.',
                ],
                'speaking' => [
                    'title' => 'Project Status Briefing & Real-Time Case Monitoring',
                    'subtitle' => 'Melaporkan Progres yang Sedang Berjalan Berdasarkan Evaluasi Masa Lalu',
                    'target' => 'Siswa mampu memberikan status report pekerjaan atau evaluasi isu sosial/lingkungan dengan membandingkan apa yang telah selesai vs apa yang sedang bergulir.',
                    'scenarios' => [
                        'Project Status Update: Laporkan progres inisiatif riset ("Last month we collected the data, and we are currently running the laboratory simulations").',
                        'Environmental Monitoring: Paparkan program rehabilitasi hutan yang telah dimulai tahun lalu dan aktivitas penanaman yang sedang berlangsung saat ini.',
                    ],
                    'delivery_rules' => [
                        'Gunakan is/am/are + V-ing untuk aksi aktif yang sedang berlangsung.',
                        'Gunakan is/am/are + being + V3 untuk proses pasif yang sedang dikerjakan.',
                        'Gunakan Simple Past untuk milestone yang sudah tuntas sempurna.',
                    ],
                    'discussion_prompt' => 'Jelaskan sebuah program atau studi yang sedang Anda/institusi Anda kembangkan saat ini dengan mengaitkannya pada evaluasi masa lalu.',
                ],
            ],

            5 => [
                'topic' => 'Modal Present & Modal Past',
                'grammar' => [
                    'title' => 'Modal Present & Modal Past: Ability, Obligation, Advice & Past Retrospection',
                    'subtitle' => 'Kewajiban & Saran Masa Kini vs. Spekulasi, Penyesalan, dan Evaluasi Kritis Masa Lampau',
                    'patterns' => [
                        'Modal Present: S + can / may / must / should + V1 | be + Adj | be + V3',
                        'Modal Past Retrospective: S + should have + V3 (Seharusnya dilakukan di masa lalu, tapi tidak)',
                        'Modal Past Deduction: S + must have + V3 (Pasti telah terjadi) | could have + V3 (Bisa saja terjadi)',
                        'Modal Past Obligation: S + had to + V1 (Keharusan masa lampau)',
                    ],
                    'concept' => 'Modal Present mengekspresikan kemampuan, izin, kewajiban, dan rekomendasi saat ini. Modal Past (khususnya Modal + have + V3) digunakan untuk evaluasi retrospektif: mengkritisi apa yang seharusnya dilakukan di masa lalu (should have + V3), menarik kesimpulan logis dari bukti lampau (must have / could have + V3), atau menyatakan keharusan masa lalu (had to + V1).',
                    'examples' => [
                        'Modal Present: "Municipal governments must enforce strict industrial emission standards to protect urban air quality."',
                        'Modal Past (Advice): "The regional authorities should have constructed flood defense barriers before the monsoon season."',
                        'Modal Past (Deduction): "The water sample must have been contaminated during the collection process."',
                    ],
                    'practice_task' => 'Terjemahkan kalimat saran kebijakan saat ini serta evaluasi retrospektif masa lalu menggunakan pola modal verbs.',
                ],
                'speaking' => [
                    'title' => 'Policy Advisory & Strategic Retrospective Analysis',
                    'subtitle' => 'Memberikan Rekomendasi Masa Kini & Mengkritisi Keputusan Masa Lalu',
                    'target' => 'Siswa mampu merekomendasikan solusi kebijakan saat ini sekaligus mengevaluasi kegagalan atau langkah masa lalu secara objektif dan diplomatis.',
                    'scenarios' => [
                        'Crisis Post-Mortem: Analisis kegagalan sebuah proyek atau penanganan bencana lingkungan dan evaluasi apa yang seharusnya dilakukan.',
                        'Strategic Advisory: Berikan rekomendasi kebijakan mendesak yang harus diterapkan pemerintah kota untuk mengatasi krisis perumahan/sampah.',
                    ],
                    'delivery_rules' => [
                        'Gunakan "should have + V3" untuk menyatakan kritik konstruktif terhadap masa lalu.',
                        'Gunakan "must have + V3" untuk menarik kesimpulan logis dari bukti yang ada.',
                        'Gunakan "must / should + V1" untuk rekomendasi tindakan mendesak saat ini.',
                    ],
                    'discussion_prompt' => 'Diskusikan sebuah kebijakan publik atau penanganan krisis lingkungan di masa lalu yang seharusnya ditangani secara berbeda.',
                ],
            ],

            6 => [
                'topic' => 'Adverbial Clause',
                'grammar' => [
                    'title' => 'Adverbial Clauses: Time, Cause, Condition, Concession & Purpose',
                    'subtitle' => 'Menghubungkan Dua Klausa dengan Hubungan Sebab-Akibat, Waktu, Konsesi, dan Tujuan',
                    'patterns' => [
                        'Adverbial of Time: When, while, before, after, as soon as + [S + V]',
                        'Adverbial of Cause/Reason: Because, since, as + [S + V]',
                        'Adverbial of Concession/Contrast: Although, even though, whereas, while + [S + V]',
                        'Adverbial of Condition & Purpose: If, unless, provided that, in order that, so that + [S + V]',
                    ],
                    'concept' => 'Adverbial Clause adalah anak kalimat (dependent clause) yang berfungsi sebagai keterangan bagi klausa utama. Menguasai adverbial clause memungkinkan pembicara menyusun argumen yang kaya nuansa logis: menjelaskan mengapa sesuatu terjadi (cause), di bawah syarat apa (condition), meskipun ada tantangan apa (concession), atau untuk tujuan apa (purpose).',
                    'examples' => [
                        'Concession: "Although renewable energy infrastructure requires substantial initial capital, it delivers immense long-term ecological benefits."',
                        'Cause: "Because urban population is expanding rapidly, municipal planners must upgrade wastewater treatment facilities immediately."',
                        'Purpose: "Coastal communities plant extensive mangrove forests so that fragile shorelines are protected from severe sea erosion."',
                    ],
                    'practice_task' => 'Susun kalimat majemuk bertingkat menggunakan klausa adverbial kontras (although), sebab (because/since), dan tujuan (so that).',
                ],
                'speaking' => [
                    'title' => 'Complex Argumentation, Persuasion & Nuanced Debate',
                    'subtitle' => 'Menyajikan Argumen Multi-Sudut Pandang dengan Hubungan Logis Kuat',
                    'target' => 'Siswa mampu menyajikan argumen berbobot tinggi dengan mengakui sanggahan (concession) sebelum menegaskan poin utama (main clause).',
                    'scenarios' => [
                        'Academic Debate: Diskusikan transisi energi fosil ke energi terbarukan dengan menimbang biaya awal versus keuntungan jangka panjang.',
                        'Policy Proposal: Paparkan usulan kebijakan lingkungan dengan menguraikan latar belakang masalah, syarat pelaksanaan, dan tujuan akhir.',
                    ],
                    'delivery_rules' => [
                        'Awali argumen dengan klausa konsesi ("Although X is challenging, Y remains vital...").',
                        'Gunakan jeda intonasi koma dengan tepat jika adverbial clause diletakkan di awal kalimat.',
                        'Hindari menggabungkan "although" dan "but" dalam satu kalimat yang sama.',
                    ],
                    'discussion_prompt' => 'Sampaikan argumen 2 menit mengenai dilema pembangunan industri vs pelestarian lingkungan menggunakan adverbial clauses.',
                ],
            ],

            7 => [
                'topic' => 'Adjective Clause (RPS, RPO, RPP & RA)',
                'grammar' => [
                    'title' => 'Adjective Clauses: Relative Pronoun as Subject, Object, Possessive & Relative Adverb',
                    'subtitle' => 'Mendeskripsikan dan Mendefinisikan Benda/Orang dengan Presisi Akademis Tinggi',
                    'patterns' => [
                        'Relative Pronoun as Subject (RPS): [Noun] + who / which / that + [Verb + Object]',
                        'Relative Pronoun as Object (RPO): [Noun] + whom / which / that + [Subject + Verb]',
                        'Relative Pronoun as Possessive (RPP): [Noun] + whose + [Noun] + [Verb]',
                        'Relative Adverb (RA): [Noun of Place/Time/Reason] + where / when / why + [S + V]',
                        'Defining (tanpa koma - esensial) vs Non-Defining (pakai koma - info tambahan)',
                    ],
                    'concept' => 'Adjective Clause berfungsi menerangkan kata benda (noun) di depannya. RPS menggantikan subjek anak kalimat (the scientist who discovered...), RPO menggantikan objek (the report which we reviewed...), RPP menyatakan kepemilikan (the community whose forest was restored...), dan RA menerangkan tempat/waktu/alasan (the facility where waste is processed).',
                    'examples' => [
                        'RPS: "Students who participate in environmental research develop valuable critical thinking skills."',
                        'RPO: "The climate policies that the minister introduced last week received widespread international praise."',
                        'RPP: "Coastal communities whose livelihoods depend on coral reefs are actively restoring marine habitats."',
                        'RA: "Urban neighborhoods where green corridors are preserved experience significantly lower heat-island effects."',
                    ],
                    'practice_task' => 'Gabungkan dua kalimat terpisah menjadi satu kalimat komprehensif menggunakan RPS, RPO, RPP, dan RA.',
                ],
                'speaking' => [
                    'title' => 'Elaborate Profiling, Scientific Descriptions & Rich Detail Speech',
                    'subtitle' => 'Menjelaskan Objek, Fenomena, dan Tokoh Secara Spesifik Tanpa Repetisi',
                    'target' => 'Siswa mampu mendeskripsikan program kerja, teknologi lingkungan, dan peran pemangku kepentingan secara elegan menggunakan adjective clause.',
                    'scenarios' => [
                        'Scientific Presentation: Deskripsikan spesies langka, habitat terancam, atau teknologi pengolahan air menggunakan defining dan non-defining clauses.',
                        'Stakeholder Pitch: Paparkan mitra kerja dan komunitas binaan dengan menghubungkan peran dan kontribusinya secara spesifik.',
                    ],
                    'delivery_rules' => [
                        'Gunakan "who" untuk manusia sebagai subjek, "whom" untuk objek formal.',
                        'Gunakan "whose" untuk menyatakan relasi kepemilikan.',
                        'Gunakan jeda intonasi mikro saat melafalkan non-defining clause diapit koma.',
                    ],
                    'discussion_prompt' => 'Presentasikan sebuah inovasi teknologi atau tokoh lingkungan yang paling menginspirasi Anda dengan menerapkan variasi adjective clauses.',
                ],
            ],

            8 => [
                'topic' => 'Noun Clause',
                'grammar' => [
                    'title' => 'Noun Clauses: That-Clauses, Wh-Questions, If/Whether & Subjunctive',
                    'subtitle' => 'Klausa yang Berfungsi Sebagai Subjek, Objek Kata Kerja, dan Komplemen Kalimat',
                    'patterns' => [
                        'Noun Clause as Subject: What / That / How + [S + V] + [Main Verb]',
                        'Noun Clause as Object: [S + Verb] + that / whether / if / what / why + [S + V]',
                        'Reporting Verbs: explain that, emphasize that, argue that, investigate whether',
                        'Subjunctive Noun Clause: demand / recommend / require that + [S + V-infinitive]',
                    ],
                    'concept' => 'Noun Clause adalah anak kalimat yang menempati posisi kata benda (sebagai subjek, objek langsung, objek preposisi, atau komplemen). Sangat lazim digunakan dalam bahasa formal dan akademik untuk menyampaikan fakta, temuan riset, pertanyaan tidak langsung, atau hipotesis ("What the research demonstrates is that...").',
                    'examples' => [
                        'As Subject: "What environmental scientists emphasize is that immediate climate action is unavoidable."',
                        'As Object: "The survey reveals that eighty percent of urban residents support mandatory waste separation."',
                        'With Whether/If: "Environmental watchdogs are investigating whether corporate emissions reports are authentic."',
                    ],
                    'practice_task' => 'Ubah pertanyaan langsung menjadi noun clause formal dan susun kalimat dengan noun clause sebagai subjek argumen.',
                ],
                'speaking' => [
                    'title' => 'Executive Briefing, Scholarly Reporting & Indirect Communication',
                    'subtitle' => 'Menyampaikan Data, Hasil Riset, dan Kesimpulan Diskusi Tingkat Tinggi',
                    'target' => 'Siswa mampu memaparkan temuan data, menyimpulkan pandangan pihak lain, dan menegaskan fokus argumen menggunakan pola noun clause.',
                    'scenarios' => [
                        'Board Briefing: Laporkan temuan audit atau riset pasar ("What our preliminary findings suggest is that...").',
                        'Diplomatic Panel: Bahas ketidakpastian kebijakan atau pertanyaan etis ("Whether municipal governments can fund this project remains uncertain").',
                    ],
                    'delivery_rules' => [
                        'Pertahankan susunan subjek-predikat normal di dalam noun clause (bukan susunan kalimat tanya).',
                        'Gunakan "What [S + V] is that..." untuk memberi penekanan pada poin sentral.',
                        'Gunakan reporting verbs formal (demonstrate, indicate, contend, affirm).',
                    ],
                    'discussion_prompt' => 'Sampaikan laporan eksekutif 2 menit mengenai arah kebijakan masa depan institusi Anda menggunakan struktur noun clause.',
                ],
            ],

            9 => [
                'topic' => 'Reducing & Abridgement',
                'grammar' => [
                    'title' => 'Reducing & Abridgement: Streamlining Clauses to Participles & Appositives',
                    'subtitle' => 'Meringkas Klausa Panjang Menjadi Frasa Padat, Elegan, dan Bergaya Bahasa Lanjutan',
                    'patterns' => [
                        'Reducing Adjective Clause (Active): [Noun] + who works → [Noun] + working',
                        'Reducing Adjective Clause (Passive): [Noun] + which was built in 2020 → [Noun] + built in 2020',
                        'Reducing Adverbial Clause: Because she realized the risk → Having realized the risk, ...',
                        'Abridgement with Time/Condition: While studying → While studying / When completed',
                    ],
                    'concept' => 'Peringkasan kalimat (Reducing & Abridgement) adalah teknik mengubah anak kalimat (klausa bertingkat dengan subjek dan konjungsi) menjadi frasa partisipial (-ing atau -ed) atau frasa aposisi. Teknik ini membuat kalimat menjadi ringkas, berbobot, dinamis, dan sangat disukai dalam penulisan ilmiah serta pidato kepemimpinan formal.',
                    'examples' => [
                        'Active Participle: "Having analyzed the water samples, the research team published their final environmental assessment."',
                        'Passive Participle: "The recycling methodology developed by local scientists reduces carbon emissions by forty percent."',
                        'Adverbial Reduction: "Facing severe seasonal droughts, regional agricultural communities adopted automated drip irrigation."',
                    ],
                    'practice_task' => 'Ringkas kalimat majemuk ber-adjective clause dan adverbial clause menjadi kalimat padat berparticiple phrase.',
                ],
                'speaking' => [
                    'title' => 'Executive Brevity, Dynamic Storytelling & Keynote Speech',
                    'subtitle' => 'Menyampaikan Narasi dan Presentasi Mengalir Tanpa Kalimat Terputus',
                    'target' => 'Siswa mampu menyederhanakan alur tutur tanpa kata sambung berulang, merangkai cerita dan paparan profesional dengan frasa pembuka participle yang elegan.',
                    'scenarios' => [
                        'Leadership Anecdote: Ceritakan momen penting saat menghadapi krisis proyek dengan pembuka participle ("Confronted with an unexpected budget cut, we restructured...").',
                        'Keynote Pitch: Buka presentasi produk atau ide riset dengan merangkum latar belakang dalam satu tarikan nafas yang anggun.',
                    ],
                    'delivery_rules' => [
                        'Pastikan subjek pada frasa pembuka sama dengan subjek klausa utama (hindari dangling participle).',
                        'Gunakan variasi intonasi: jeda sejenak setelah melafalkan participle phrase di awal kalimat.',
                        'Terapkan tempo bicara terukur untuk memperkuat wibawa profesional.',
                    ],
                    'discussion_prompt' => 'Bawakan pidato ringkas 2 menit mengenai perjalanan mengatasi sebuah tantangan besar dengan menerapkan reducing and abridgement.',
                ],
            ],

            10 => [
                'topic' => 'Comprehensive Review & Applied Mastery (Materi Menyusul)',
                'grammar' => [
                    'title' => 'Comprehensive Grammar Integration & Applied Mastery',
                    'subtitle' => 'Review Menyeluruh, Klinik Akurasi Struktur (Meeting 1 s.d. 9), & Pengayaan Materi Khusus',
                    'patterns' => [
                        'Tenses Mastery: Simple Present, Past, Perfect, Continuous & Modals',
                        'Complex Clause Syntax: Adverbial Clauses, Adjective Clauses & Noun Clauses',
                        'Advanced Stylistics: Sentence Reduction, Active-Passive Precision & Nominal Accuracy',
                        'Special Topic: Materi pengayaan lanjutan menyusul sesuai kebutuhan dan minat spesifik siswa',
                    ],
                    'concept' => 'Pertemuan pamungkas untuk mengintegrasikan seluruh bangunan tata bahasa yang telah dipelajari sejak Pertemuan 1 hingga 9 ke dalam penguasaan lisan dan tulisan yang natural, presisi, dan spontan. Sesi ini juga membuka ruang materi pengayaan khusus (custom topics) yang dibutuhkan siswa untuk tujuan akademik atau profesional.',
                    'examples' => [
                        '"Combining precise tenses with layered clauses allows speakers to articulate complex arguments with executive authority."',
                        '"Scholars who master syntactic reduction and clause subordination consistently produce compelling discourse."',
                    ],
                    'practice_task' => 'Selesaikan latihan integrasi tata bahasa komprehensif yang menguji kombinasi tenses, klausa, dan reduksi.',
                ],
                'speaking' => [
                    'title' => 'Capstone Speaking Simulation: Multi-Round Table Discussion & Debate',
                    'subtitle' => 'Simulasi Lisan Komprehensif: Interview, Diskusi Kasus & Presentasi Ilmiah',
                    'target' => 'Siswa mampu berbicara secara spontan, percaya diri, dan fasih selama 10-15 menit dengan memadukan seluruh struktur gramatikal yang telah dilatih.',
                    'scenarios' => [
                        'Comprehensive Interview: Sesi tanya jawab cepat meliputi topik personal, sosial, dan akademik.',
                        'Roundtable Debate & Presentation: Pemaparan studi kasus interaktif bersama pengajar dengan evaluasi performa menyeluruh.',
                    ],
                    'delivery_rules' => [
                        'Tunjukkan variasi struktur kalimat aktif, pasif, nominal, klausa majemuk, dan reduksi.',
                        'Jaga kontak mata, intonasi vokal, dan ritme bicara profesional.',
                        'Sampaikan ide dengan argumen logis yang matang.',
                    ],
                    'discussion_prompt' => 'Simulasi roundtable komprehensif bersama pengajar sebagai evaluasi akhir pencapaian kompetensi bahasa.',
                ],
            ],
        ];

        return $curriculum[$meetingNumber] ?? null;
    }

    /**
     * Get tailored grammar translation practice questions, helpers, paragraph, and cheat sheet HTML.
     */
    public static function getGrammarPracticeData(int $meetingNumber, array $curriculumData = []): array
    {
        $grammar = $curriculumData['grammar'] ?? [];
        $title = $grammar['title'] ?? ('Meeting ' . $meetingNumber . ' Grammar');
        $patterns = $grammar['patterns'] ?? [];
        $concept = $grammar['concept'] ?? 'Pelajari pola tata bahasa dan terjemahkan kalimat di bawah ini dengan tepat.';
        $examples = $grammar['examples'] ?? [];
        $practiceTask = $grammar['practice_task'] ?? 'Terjemahkan seluruh kalimat berikut ke dalam Bahasa Inggris akademis/formal.';

        // Build HTML CheatSheet matching TOEFL/Grammar-Writing layout
        $patternsHtml = '';
        foreach ($patterns as $p) {
            $patternsHtml .= '<div class="bg-white border border-emerald-200 text-emerald-950 font-mono text-xs sm:text-sm p-3 rounded-xl font-bold shadow-xs mb-2">' . htmlspecialchars($p) . '</div>';
        }

        $examplesHtml = '';
        foreach ($examples as $ex) {
            $examplesHtml .= '<div class="p-3 bg-white border-l-4 border-emerald-500 rounded-r-xl border border-gray-100 text-xs sm:text-sm text-gray-800 leading-relaxed font-serif mb-2">&ldquo;' . htmlspecialchars($ex) . '&rdquo;</div>';
        }

        $cheatSheetHtml = '
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3">
                <span class="bg-emerald-600 text-white w-7 h-7 flex items-center justify-center rounded-xl text-xs font-bold shadow-xs">✍️</span>
                <h4 class="text-base sm:text-lg font-bold text-gray-900 leading-tight">
                    ' . htmlspecialchars($title) . '
                </h4>
            </div>

            ' . (!empty($patterns) ? '
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-4 sm:p-5 shadow-xs mb-5">
                <strong class="block text-xs font-black uppercase tracking-wider text-emerald-800 mb-2.5">
                    Pola Struktur Kunci (Key Patterns / Formula)
                </strong>
                ' . $patternsHtml . '
            </div>' : '') . '

            <div class="rounded-2xl border border-gray-200 bg-gray-50/70 p-4 sm:p-5 mb-5 space-y-2">
                <strong class="block text-xs font-black uppercase tracking-wider text-gray-600">
                    Konsep &amp; Esensi Penggunaan
                </strong>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed font-normal">
                    ' . htmlspecialchars($concept) . '
                </p>
            </div>

            ' . (!empty($examples) ? '
            <div class="mb-5">
                <strong class="block text-xs font-black uppercase tracking-wider text-emerald-800 mb-2.5">
                    Contoh Model Kalimat Berbobot (C1/C2 Level)
                </strong>
                ' . $examplesHtml . '
            </div>' : '') . '

            <div class="bg-amber-50 border border-amber-200 text-amber-950 p-4 rounded-xl text-xs sm:text-sm">
                <strong class="block mb-1 text-amber-900 font-bold">Fokus &amp; Aturan Praktik:</strong>
                <span class="text-amber-900 leading-relaxed">' . htmlspecialchars($practiceTask) . '</span>
            </div>
        </div>';

        // Meeting specific question datasets
        $datasets = [
            1 => [
                'guide_box' => '
                    <div class="flex items-center gap-2 mb-2 font-bold text-emerald-900 text-sm sm:text-base">
                        <span class="text-lg">💡</span> Panduan Penguasaan Simple Present (Verbal, Nominal &amp; Pasif):
                    </div>
                    <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm text-emerald-900 leading-relaxed font-medium">
                        <li>
                            <strong>Verbal (Kalimat Aksi Aktif): S + V1(s/es) + O</strong>
                            <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                <div>• Digunakan ketika subjek melakukan tindakan langsung secara rutin atau fakta umum.</div>
                                <div>• Contoh: <em>"Our management team analyzes the financial report every month."</em></div>
                            </div>
                        </li>
                        <li>
                            <strong>Nominal (Kalimat Kondisi / Status): S + is/am/are + Complement (Adj/Noun/Adv)</strong>
                            <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                <div>• Digunakan untuk mendeskripsikan sifat, identitas, atau keberadaan tanpa kata kerja aksi (wajib to be).</div>
                                <div>• Contoh: <em>"Clean drinking water is essential for community health."</em></div>
                            </div>
                        </li>
                        <li>
                            <strong>Pasif (Fokus Objek &amp; Hasil Tindakan): S + is/am/are + V3 (+ by Agent)</strong>
                            <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                <div>• Digunakan ketika subjek kalimat menerima tindakan atau hasil proses yang diutamakan.</div>
                                <div>• Contoh: <em>"All company financial data is audited by an independent public accountant regularly."</em></div>
                            </div>
                        </li>
                    </ol>
                    <div class="mt-3 pt-2.5 border-t border-emerald-200/70 text-xs font-semibold text-emerald-800 flex items-center gap-1">
                        <span>📌 Catatan Kunci:</span> <span>adalah, merupakan, ada, berada = <strong>Nominal (is/am/are)</strong> | di-, ter- = <strong>Pasif (is/am/are + V3)</strong> | aksi aktif = <strong>Verbal (V1/s/es)</strong></span>
                    </div>
                ',
                'questions' => [
                    'Tim manajemen kami menganalisis laporan kinerja penjualan setiap akhir bulan.',
                    'Semua data keuangan perusahaan diaudit oleh akuntan publik independen secara berkala.',
                    'Sistem keamanan digital perusahaan saat ini sangat andal dan aman untuk perlindungan data nasabah.',
                    'Para peneliti lingkungan menguji sampel air sungai di laboratorium setiap minggu.',
                    'Sampah plastik dan kemasan botol disortir secara manual oleh pekerja fasilitas daur ulang setiap hari.',
                    'Udara pagi di kawasan pegunungan sangat segar dan nyaman untuk kesehatan paru-paru.',
                    'Banyak profesional muda memilih jam kerja fleksibel untuk menjaga keseimbangan hidup.',
                    'Layanan konseling profesional disediakan oleh universitas untuk membantu mahasiswa yang mengalami stres.',
                    'Kesenjangan infrastruktur internet di daerah terpencil masih menjadi tantangan besar bagi pendidikan nasional.',
                    'Pemerintah kota merancang jalur transportasi publik yang terpadu, karena mobilitas ramah lingkungan sangat penting bagi masyarakat.',
                ],
                'expectedAnswers' => [
                    1 => 'Our management team analyzes the sales performance report at the end of every month.',
                    2 => 'All company financial data is audited by an independent public accountant regularly.',
                    3 => 'The company digital security system is currently very reliable and safe for customer data protection.',
                    4 => 'Environmental researchers test river water samples in the laboratory every week.',
                    5 => 'Plastic waste and bottle packaging are sorted manually by recycling facility workers every day.',
                    6 => 'The morning air in the mountain area is very fresh and comfortable for lung health.',
                    7 => 'Many young professionals choose flexible working hours to maintain work-life balance.',
                    8 => 'Professional counseling services are provided by the university to assist students experiencing stress.',
                    9 => 'The internet infrastructure divide in remote areas is still a major challenge for national education.',
                    10 => 'The municipal government designs integrated public transportation routes, because eco-friendly mobility is essential for the community.',
                ],
                'questionHelpers' => [
                    1 => ['example' => ['id' => 'Direktur memeriksa anggaran setiap bulan.', 'en' => 'The director inspects the budget every month.'], 'vocab' => ['management team' => ['id' => 'tim manajemen', 'pos' => '(n)'], 'analyzes' => ['id' => 'menganalisis (aktif present)', 'pos' => '(v)'], 'sales performance' => ['id' => 'kinerja penjualan', 'pos' => '(n)']]],
                    2 => ['example' => ['id' => 'Laporan ini ditinjau setiap minggu.', 'en' => 'This report is reviewed every week.'], 'vocab' => ['financial data' => ['id' => 'data keuangan', 'pos' => '(n)'], 'is audited' => ['id' => 'diaudit (pasif present)', 'pos' => '(v)'], 'independent accountant' => ['id' => 'akuntan independen', 'pos' => '(n)']]],
                    3 => ['example' => ['id' => 'Server baru ini sangat cepat.', 'en' => 'This new server is very fast.'], 'vocab' => ['security system' => ['id' => 'sistem keamanan', 'pos' => '(n)'], 'is reliable' => ['id' => 'adalah andal (nominal present)', 'pos' => '(adj)'], 'protection' => ['id' => 'perlindungan', 'pos' => '(n)']]],
                    4 => ['example' => ['id' => 'Ilmuwan meneliti tanaman setiap hari.', 'en' => 'Scientists research plants every day.'], 'vocab' => ['environmental researchers' => ['id' => 'peneliti lingkungan', 'pos' => '(n)'], 'test' => ['id' => 'menguji (aktif present)', 'pos' => '(v)'], 'water samples' => ['id' => 'sampel air', 'pos' => '(n)']]],
                    5 => ['example' => ['id' => 'Kertas dikumpulkan setiap sore.', 'en' => 'Paper is collected every afternoon.'], 'vocab' => ['plastic waste' => ['id' => 'sampah plastik', 'pos' => '(n)'], 'are sorted' => ['id' => 'disortir (pasif present)', 'pos' => '(v)'], 'recycling facility' => ['id' => 'fasilitas daur ulang', 'pos' => '(n)']]],
                    6 => ['example' => ['id' => 'Taman ini sangat indah.', 'en' => 'This park is very beautiful.'], 'vocab' => ['morning air' => ['id' => 'udara pagi', 'pos' => '(n)'], 'is fresh' => ['id' => 'segar (nominal present)', 'pos' => '(adj)'], 'comfortable' => ['id' => 'nyaman', 'pos' => '(adj)']]],
                    7 => ['example' => ['id' => 'Mereka menyukai pekerjaan mereka.', 'en' => 'They like their jobs.'], 'vocab' => ['young professionals' => ['id' => 'profesional muda', 'pos' => '(n)'], 'choose' => ['id' => 'memilih (aktif present)', 'pos' => '(v)'], 'work-life balance' => ['id' => 'keseimbangan hidup dan kerja', 'pos' => '(n)']]],
                    8 => ['example' => ['id' => 'Beasiswa diberikan kepada siswa berprestasi.', 'en' => 'Scholarships are given to outstanding students.'], 'vocab' => ['counseling services' => ['id' => 'layanan konseling', 'pos' => '(n)'], 'are provided' => ['id' => 'disediakan (pasif present)', 'pos' => '(v)'], 'assist' => ['id' => 'membantu', 'pos' => '(v)']]],
                    9 => ['example' => ['id' => 'Masalah ini cukup rumit.', 'en' => 'This problem is quite complicated.'], 'vocab' => ['infrastructure divide' => ['id' => 'kesenjangan infrastruktur', 'pos' => '(n)'], 'is a major challenge' => ['id' => 'adalah tantangan besar (nominal present)', 'pos' => '(n)'], 'remote areas' => ['id' => 'daerah terpencil', 'pos' => '(n)']]],
                    10 => ['example' => ['id' => 'Pemerintah membangun taman karena penghijauan penting.', 'en' => 'The government builds parks because greening is important.'], 'vocab' => ['designs' => ['id' => 'merancang (aktif present)', 'pos' => '(v)'], 'integrated routes' => ['id' => 'jalur terpadu', 'pos' => '(n)'], 'is essential' => ['id' => 'sangat penting (nominal present)', 'pos' => '(adj)']]],
                ],
                'paragraph' => [
                    'id' => 'Perusahaan modern terus mengembangkan inovasi teknologi untuk meningkatkan efisiensi operasional. Sistem informasi terbaru saat ini sangat penting bagi keberlanjutan bisnis. Semua laporan transaksi diaudit secara otomatis oleh perangkat lunak akuntansi cerdas. Para karyawan menggunakan aplikasi seluler untuk mencatat kehadiran harian mereka. Program pelatihan digital disediakan secara berkala oleh divisi sumber daya manusia agar seluruh staf memiliki kompetensi yang unggul.',
                    'en' => 'Modern enterprises continuously develop technological innovations to enhance operational efficiency. The latest information system is currently vital for business sustainability. All transaction reports are audited automatically by smart accounting software. Employees use mobile applications to record their daily attendance. Digital training programs are provided regularly by the human resources division so that all staff have superior competence.',
                    'vocab' => [
                        'develop' => ['id' => 'mengembangkan (aktif present)', 'pos' => '(v)'],
                        'is vital' => ['id' => 'sangat penting (nominal present)', 'pos' => '(adj)'],
                        'are audited' => ['id' => 'diaudit (pasif present)', 'pos' => '(v3)'],
                        'use' => ['id' => 'menggunakan (aktif present)', 'pos' => '(v)'],
                        'are provided' => ['id' => 'disediakan (pasif present)', 'pos' => '(v3)'],
                        'have' => ['id' => 'memiliki (aktif present)', 'pos' => '(v)'],
                    ]
                ],
            ],
            2 => [
                'guide_box' => '
                    <div class="flex items-center gap-2 mb-2 font-bold text-emerald-900 text-sm sm:text-base">
                        <span class="text-lg">💡</span> Panduan Membedakan Simple Present vs. Simple Past:
                    </div>
                    <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm text-emerald-900 leading-relaxed font-medium">
                        <li>
                            <strong>Tahap 1: Identifikasi Penanda Waktu &amp; Dimensi (Present vs. Past)</strong>
                            <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                <div>• <strong>Masa Sekarang (Present):</strong> <em>now, currently, today, every day, regularly, at present</em> &rarr; gunakan V1(s/es), is/am/are, atau is/am/are + V3.</div>
                                <div>• <strong>Masa Lampau (Past):</strong> <em>yesterday, last week, two years ago, in 2018, previously, in the past</em> &rarr; gunakan V2, was/were, atau was/were + V3.</div>
                            </div>
                        </li>
                        <li>
                            <strong>Tahap 2: Tentukan Bentuk Kalimat (Verbal, Nominal, atau Pasif)</strong>
                            <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                <div>• <strong>Verbal (Aksi Aktif):</strong> Present: <code>S + V1(s/es)</code> (contoh: <em>employs, tests</em>) | Past: <code>S + V2</code> (contoh: <em>hired, found</em>).</div>
                                <div>• <strong>Nominal (Kondisi/Status):</strong> Present: <code>S + is/am/are + Adj</code> (contoh: <em>is clean</em>) | Past: <code>S + was/were + Adj</code> (contoh: <em>was toxic</em>).</div>
                                <div>• <strong>Pasif (Objek Dikenai Aksi):</strong> Present: <code>S + is/am/are + V3</code> (contoh: <em>is managed</em>) | Past: <code>S + was/were + V3</code> (contoh: <em>was built</em>).</div>
                            </div>
                        </li>
                        <li>
                            <strong>Tahap 3: Perhatikan Konjungsi Perbandingan Waktu</strong>
                            <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                <div>• Hubungkan kedua klausa dengan kata hubung kontras seperti <em>whereas (padahal/sedangkan), while (sementara), but (tetapi), although (meskipun), after (setelah)</em>.</div>
                            </div>
                        </li>
                    </ol>
                    <div class="mt-3 pt-2.5 border-t border-emerald-200/70 text-xs font-semibold text-emerald-800 flex items-center gap-1">
                        <span>📌 Catatan Kunci:</span> <span>Hati-hati jangan mencampuradukkan kata kerja lampau (V2 / was / were) ke dalam peristiwa kebiasaan masa kini (V1 / is / are).</span>
                    </div>
                ',
                'questions' => [
                    'Perusahaan teknologi itu mempekerjakan ratusan insinyur perangkat lunak sekarang, tetapi mereka hanya merekrut lima staf pada tahun 2018.',
                    'Kualitas udara di pusat kota sangat bersih pagi ini, padahal kondisinya sangat beracun minggu lalu akibat kebakaran hutan.',
                    'Limbah medis dari rumah sakit dikelola dengan ketat setiap hari, sedangkan protokol keselamatan baru disahkan oleh kementerian bulan lalu.',
                    'Sebagian besar warga kota lebih memilih belanja daring saat ini, padahal mereka berbelanja di pasar tradisional lima tahun yang lalu.',
                    'Proyek energi terbarukan ini sangat menguntungkan bagi daerah, meskipun awalnya rencana tersebut sangat sulit pada tahap awal dua tahun lalu.',
                    'Jutaan liter air bersih didistribusikan ke rumah-rumah warga setiap pagi, setelah jaringan pipa utama dibangun oleh kontraktor tahun lalu.',
                    'Tim peneliti menguji sampel tanah baru di laboratorium setiap minggu, karena mereka menemukan indikasi mineral berharga pada survei lapangan kemarin.',
                    'Fasilitas perpustakaan universitas kami sekarang sangat modern dan lengkap, padahal gedung tua tersebut dulunya sangat sempit sepuluh tahun yang lalu.',
                    'Denda finansial yang berat dijatuhkan kepada pabrik yang mencemari sungai hari ini, setelah laporan pelanggaran diverifikasi oleh dinas lingkungan kemarin sore.',
                    'Pemerintah daerah mengalokasikan anggaran khusus untuk penghijauan kota setiap tahun, karena tingkat polusi udara pada tahun lalu sangat tinggi dan berbahaya.',
                ],
                'expectedAnswers' => [
                    1 => 'The technology company employs hundreds of software engineers now, but they only hired five staff in 2018.',
                    2 => 'The air quality in the city center is very clean this morning, whereas the condition was very toxic last week due to forest fires.',
                    3 => 'Medical waste from the hospital is managed strictly every day, while the new safety protocol was approved by the ministry last month.',
                    4 => 'Most city residents prefer online shopping at present, whereas they shopped in traditional markets five years ago.',
                    5 => 'This renewable energy project is very beneficial for the region, although initially the plan was very difficult in the early stage two years ago.',
                    6 => 'Millions of liters of clean water are distributed to residents houses every morning, after the main pipeline was built by the contractor last year.',
                    7 => 'The research team tests new soil samples in the laboratory every week, because they found valuable mineral indications in the field survey yesterday.',
                    8 => 'Our university library facility is now very modern and complete, whereas the old building was formerly very cramped ten years ago.',
                    9 => 'Heavy financial fines are imposed on factories polluting the river today, after the violation report was verified by the environmental agency yesterday afternoon.',
                    10 => 'The local government allocates a dedicated budget for urban greening every year, because the air pollution level last year was very high and dangerous.',
                ],
                'questionHelpers' => [
                    1 => ['example' => ['id' => 'Dia tinggal di Jakarta sekarang, tapi dia tinggal di Surabaya dua tahun lalu.', 'en' => 'He lives in Jakarta now, but he lived in Surabaya two years ago.'], 'vocab' => ['employs' => ['id' => 'mempekerjakan (aktif present)', 'pos' => '(v)'], 'hired' => ['id' => 'merekrut (aktif past)', 'pos' => '(v2)'], 'software engineers' => ['id' => 'insinyur perangkat lunak', 'pos' => '(n)']]],
                    2 => ['example' => ['id' => 'Cuaca hari ini cerah, padahal kemarin mendung.', 'en' => 'The weather today is sunny, whereas yesterday it was cloudy.'], 'vocab' => ['air quality' => ['id' => 'kualitas udara', 'pos' => '(n)'], 'is very clean' => ['id' => 'sangat bersih (nominal present)', 'pos' => '(adj)'], 'was very toxic' => ['id' => 'sangat beracun (nominal past)', 'pos' => '(adj)'], 'forest fires' => ['id' => 'kebakaran hutan', 'pos' => '(n)']]],
                    3 => ['example' => ['id' => 'Laporan diperiksa setiap pagi, dan berkas dikirim kemarin.', 'en' => 'The report is checked every morning, and the file was sent yesterday.'], 'vocab' => ['medical waste' => ['id' => 'limbah medis', 'pos' => '(n)'], 'is managed' => ['id' => 'dikelola (pasif present)', 'pos' => '(v)'], 'was approved' => ['id' => 'disahkan (pasif past)', 'pos' => '(v2)'], 'safety protocol' => ['id' => 'protokol keselamatan', 'pos' => '(n)']]],
                    4 => ['example' => ['id' => 'Kami membaca buku digital sekarang, tapi kami membeli buku fisik dulu.', 'en' => 'We read digital books now, but we bought physical books in the past.'], 'vocab' => ['city residents' => ['id' => 'warga kota', 'pos' => '(n)'], 'prefer' => ['id' => 'lebih memilih (aktif present)', 'pos' => '(v)'], 'online shopping' => ['id' => 'belanja daring', 'pos' => '(n)'], 'shopped' => ['id' => 'berbelanja (aktif past)', 'pos' => '(v2)']]],
                    5 => ['example' => ['id' => 'Sistem ini stabil sekarang, walaupun dulu tidak stabil.', 'en' => 'This system is stable now, although previously it was unstable.'], 'vocab' => ['renewable energy' => ['id' => 'energi terbarukan', 'pos' => '(n)'], 'is beneficial' => ['id' => 'menguntungkan (nominal present)', 'pos' => '(adj)'], 'was difficult' => ['id' => 'sulit (nominal past)', 'pos' => '(adj)']]],
                    6 => ['example' => ['id' => 'Surat diantar setiap hari, dan kantor pos dibuka tahun lalu.', 'en' => 'Letters are delivered every day, and the post office was opened last year.'], 'vocab' => ['are distributed' => ['id' => 'didistribusikan (pasif present)', 'pos' => '(v)'], 'clean water' => ['id' => 'air bersih', 'pos' => '(n)'], 'was built' => ['id' => 'dibangun (pasif past)', 'pos' => '(v2)'], 'contractor' => ['id' => 'kontraktor', 'pos' => '(n)']]],
                    7 => ['example' => ['id' => 'Guru menjelaskan materi hari ini, dan murid membaca teks kemarin.', 'en' => 'The teacher explains the material today, and students read the text yesterday.'], 'vocab' => ['research team' => ['id' => 'tim peneliti', 'pos' => '(n)'], 'tests' => ['id' => 'menguji (aktif present)', 'pos' => '(v)'], 'found' => ['id' => 'menemukan (aktif past)', 'pos' => '(v2)'], 'mineral indications' => ['id' => 'indikasi mineral', 'pos' => '(n)']]],
                    8 => ['example' => ['id' => 'Ruang rapat ini luas, padahal kantor lama kami sempit.', 'en' => 'This meeting room is spacious, whereas our old office was small.'], 'vocab' => ['library facility' => ['id' => 'fasilitas perpustakaan', 'pos' => '(n)'], 'is modern' => ['id' => 'modern (nominal present)', 'pos' => '(adj)'], 'was cramped' => ['id' => 'sempit (nominal past)', 'pos' => '(adj)']]],
                    9 => ['example' => ['id' => 'Aturan ditegakkan sekarang, setelah undang-undang disahkan kemarin.', 'en' => 'The rule is enforced now, after the law was passed yesterday.'], 'vocab' => ['financial fines' => ['id' => 'denda finansial', 'pos' => '(n)'], 'are imposed' => ['id' => 'dijatuhkan (pasif present)', 'pos' => '(v)'], 'was verified' => ['id' => 'diverifikasi (pasif past)', 'pos' => '(v2)'], 'environmental agency' => ['id' => 'dinas lingkungan', 'pos' => '(n)']]],
                    10 => ['example' => ['id' => 'Perusahaan menghemat biaya tahun ini karena kerugian tahun lalu sangat besar.', 'en' => 'The company saves costs this year because last year loss was very large.'], 'vocab' => ['allocates' => ['id' => 'mengalokasikan (aktif present)', 'pos' => '(v)'], 'urban greening' => ['id' => 'penghijauan kota', 'pos' => '(n)'], 'pollution level' => ['id' => 'tingkat polusi', 'pos' => '(n)'], 'was very high' => ['id' => 'sangat tinggi (nominal past)', 'pos' => '(adj)']]],
                ],
                'paragraph' => [
                    'id' => 'Perkembangan kawasan industri hijau di wilayah pesisir menunjukkan kemajuan yang luar biasa pada saat ini. Dahulu, sebagian besar energi di kawasan tersebut dipasok oleh pembangkit listrik tenaga batu bara yang menghasilkan emisi karbon tinggi. Namun, pemerintah daerah meresmikan kompleks turbin angin modern pada tahun 2022. Kini, ribuan megawatt listrik bersih dialirkan ke permukiman warga setiap hari, dan kualitas udara setempat jauh lebih segar dibandingkan lima tahun yang lalu.',
                    'en' => 'The development of the green industrial estate in the coastal region shows remarkable progress at present. Previously, most of the energy in the area was supplied by coal-fired power plants that produced high carbon emissions. However, the regional government inaugurated a modern wind turbine complex in 2022. Nowadays, thousands of megawatts of clean electricity are delivered to residential areas every day, and the local air quality is much fresher than it was five years ago.',
                    'vocab' => [
                        'shows' => ['id' => 'menunjukkan (aktif present)', 'pos' => '(v)'],
                        'was supplied' => ['id' => 'dipasok (pasif past)', 'pos' => '(v3)'],
                        'inaugurated' => ['id' => 'meresmikan (aktif past)', 'pos' => '(v2)'],
                        'are delivered' => ['id' => 'dialirkan/didistribusikan (pasif present)', 'pos' => '(v3)'],
                        'is much fresher' => ['id' => 'jauh lebih segar (nominal present)', 'pos' => '(adj)'],
                    ]
                ],
            ],
        ];

        // Generic fallback generator for meetings 3-10 if not explicitly defined above
        if (!isset($datasets[$meetingNumber])) {
            $baseQuestions = [
                1 => 'Para ilmuwan di seluruh dunia terus mempelajari dinamika perubahan iklim global.',
                2 => 'Selama beberapa dekade terakhir, suhu rata-rata bumi telah meningkat secara signifikan.',
                3 => 'Saat ini, tim peneliti sedang menganalisis data satelit untuk memantau pencairan lapisan es.',
                4 => 'Pada tahun lalu, stasiun meteorologi mencatat rekor suhu tertinggi di berbagai belahan dunia.',
                5 => 'Jika tren pemanasan ini tidak segera dihentikan, keanekaragaman hayati akan terancam punah.',
                6 => 'Kebijakan transisi energi terbarukan harus diterapkan secara komprehensif oleh seluruh negara.',
                7 => 'Para arsitek telah membangun struktur tahan guncangan pada fasilitas riset tersebut.',
                8 => 'Analisis komparatif membuktikan keunggulan metodologi baru dibandingkan pendekatan tradisional.',
                9 => 'Setiap elemen dalam sistem tata kelola organisasi wajib mempertahankan transparansi publik.',
                10 => 'Penerapan standar akuntabilitas tinggi memperkuat kepercayaan investor internasional.',
            ];

            $baseAnswers = [
                1 => 'Scientists around the world continue to study the dynamics of global climate change.',
                2 => 'Over the past few decades, the average temperature of the earth has increased significantly.',
                3 => 'Currently, research teams are analyzing satellite data to monitor ice sheet melting.',
                4 => 'Last year, meteorological stations recorded record high temperatures across the globe.',
                5 => 'If this warming trend is not stopped immediately, biodiversity will face extinction.',
                6 => 'Renewable energy transition policies must be implemented comprehensively by all nations.',
                7 => 'Architects have constructed earthquake-resistant structures on the research facility.',
                8 => 'Comparative analysis proves the superiority of the new methodology over traditional approaches.',
                9 => 'Every element in the organizational governance system must maintain public transparency.',
                10 => 'The application of high accountability standards reinforces international investor trust.',
            ];

            $baseHelpers = [
                1 => ['example' => ['id' => 'Peneliti mempelajari ekosistem hutan tropis.', 'en' => 'Researchers study tropical forest ecosystems.'], 'vocab' => ['dynamics' => ['id' => 'dinamika', 'pos' => '(n)']]],
                2 => ['example' => ['id' => 'Produksi pabrik meningkat pesat.', 'en' => 'Factory production increased rapidly.'], 'vocab' => ['significantly' => ['id' => 'secara signifikan', 'pos' => '(adv)']]],
                3 => ['example' => ['id' => 'Tim mengkaji data pasar.', 'en' => 'The team reviews market data.'], 'vocab' => ['monitor' => ['id' => 'memantau', 'pos' => '(v)']]],
                4 => ['example' => ['id' => 'Lembaga mencatat rekor penjualan.', 'en' => 'The institution recorded sales records.'], 'vocab' => ['meteorological' => ['id' => 'meteorologi', 'pos' => '(adj)']]],
                5 => ['example' => ['id' => 'Spesies langka terancam punah.', 'en' => 'Rare species face extinction.'], 'vocab' => ['biodiversity' => ['id' => 'keanekaragaman hayati', 'pos' => '(n)']]],
                6 => ['example' => ['id' => 'Kebijakan baru diterapkan segera.', 'en' => 'The new policy is implemented soon.'], 'vocab' => ['comprehensively' => ['id' => 'secara komprehensif', 'pos' => '(adv)']]],
                7 => ['example' => ['id' => 'Insinyur membangun jembatan modern.', 'en' => 'Engineers built modern bridges.'], 'vocab' => ['earthquake-resistant' => ['id' => 'tahan gempa', 'pos' => '(adj)']]],
                8 => ['example' => ['id' => 'Analisis data mengungkap tren baru.', 'en' => 'Data analysis revealed new trends.'], 'vocab' => ['methodology' => ['id' => 'metodologi', 'pos' => '(n)']]],
                9 => ['example' => ['id' => 'Sistem tata kelola berjalan baik.', 'en' => 'The governance system works well.'], 'vocab' => ['transparency' => ['id' => 'transparansi', 'pos' => '(n)']]],
                10 => ['example' => ['id' => 'Standar tinggi menjaga mutu.', 'en' => 'High standards maintain quality.'], 'vocab' => ['accountability' => ['id' => 'akuntabilitas', 'pos' => '(n)']]],
            ];

            $datasets[$meetingNumber] = [
                'questions' => array_values($baseQuestions),
                'expectedAnswers' => $baseAnswers,
                'questionHelpers' => $baseHelpers,
                'paragraph' => [
                    'id' => 'Para ilmuwan di seluruh dunia terus mempelajari dinamika perubahan iklim global. Selama beberapa dekade terakhir, suhu rata-rata bumi telah meningkat secara signifikan akibat emisi gas rumah kaca. Saat ini, tim peneliti sedang menganalisis data satelit untuk memantau pencairan lapisan es di kutub. Oleh karena itu, kebijakan transisi energi terbarukan harus diterapkan secara komprehensif oleh seluruh negara.',
                    'en' => 'Scientists around the world continue to study the dynamics of global climate change. Over the past few decades, the earth average temperature has increased significantly due to greenhouse gas emissions. Currently, research teams are analyzing satellite data to monitor polar ice sheet melting. Therefore, renewable energy transition policies must be implemented comprehensively by all nations.',
                    'vocab' => [
                        'climate change' => ['id' => 'perubahan iklim', 'pos' => '(n)'],
                        'average temperature' => ['id' => 'suhu rata-rata', 'pos' => '(n)'],
                        'satellite data' => ['id' => 'data satelit', 'pos' => '(n)'],
                        'renewable energy' => ['id' => 'energi terbarukan', 'pos' => '(n)'],
                    ]
                ],
            ];
        }

        $data = $datasets[$meetingNumber];
        $data['cheatSheet'] = ['__html__' => $cheatSheetHtml];

        return $data;
    }

    /**
     * Get structured speaking practice materials, debate scenarios, signposting toolkit, and audio prompts.
     */
    public static function getSpeakingPracticeData(int $meetingNumber, array $curriculumData = []): array
    {
        $speaking = $curriculumData['speaking'] ?? [];
        $title = $speaking['title'] ?? ('Meeting ' . $meetingNumber . ' Speaking Practice');
        $subtitle = $speaking['subtitle'] ?? 'Executive Fluency, Debates & Delivery';
        $target = $speaking['target'] ?? 'Latih kefasihan berbicara formal level C1/C2 dengan struktur argumen yang kuat.';
        $scenarios = $speaking['scenarios'] ?? [
            'Executive Motion: Berikan analisis komprehensif mengenai strategi transformasi digital dan mitigasi risiko operasional.',
            'Strategic Review: Presentasikan evaluasi pencapaian kuartal terakhir dan proyeksi alokasi sumber daya di hadapan direksi.'
        ];
        $deliveryRules = $speaking['delivery_rules'] ?? [
            'Hindari respons singkat satu kata ("Yes/No").',
            'Awali setiap argumen dengan frasa pembuka berbobot (signposting phrase).',
            'Pertahankan tempo bicara tenang, stabil, dan artikulasi jelas.'
        ];
        $discussionPrompt = $speaking['discussion_prompt'] ?? 'Sampaikan argumen 2 menit tanpa naskah langsung kepada mentor.';

        // Signposting & Speech Framework
        $framework = [
            'openers' => [
                'Much as I recognize the merits of the counter-argument, ...',
                'From an executive vantage point, the critical variable at play is ...',
                'Having thoroughly evaluated prevailing market conditions, ...',
                'It is fundamentally incumbent upon leadership to distinguish between ...',
            ],
            'transitions' => [
                'Conversely, looking at the long-term strategic horizon, ...',
                'Nevertheless, that assumption fails to account for ...',
                'Consequently, the immediate priority must center around ...',
                'Building upon that premise, empirical evidence indicates that ...',
            ],
            'closers' => [
                'In the final analysis, striking a judicious equilibrium between ...',
                'Ultimately, the most viable path forward necessitates ...',
                'To synthesize our position, success will hinge upon ...',
            ]
        ];

        // Specific scenarios per meeting with pro/con aids & key vocab
        $scenarioDetails = [
            1 => [
                [
                    'scenario' => 'How should leadership communicate operational changes across active, passive, and nominal frameworks?',
                    'context' => 'Menyeimbangkan penegasan akuntabilitas tim (aktif), kepatuhan proses kerja (pasif), dan evaluasi status/kondisi kesiapan organisasi (nominal).',
                    'pro_points' => [
                        'Active sentences clearly designate executive and managerial ownership.',
                        'Passive constructions highlight institutional standards, audits, and systemic deliverables.',
                        'Nominal statements provide objective qualitative assessments of team readiness.',
                    ],
                    'con_points' => [
                        'Overusing passives can obfuscate individual accountability.',
                        'Excessive active verbs may sound overly aggressive in formal diplomatic memos.',
                    ],
                    'vocab' => [
                        'operational accountability' => 'akuntabilitas operasional',
                        'systemic compliance' => 'kepatuhan sistemik',
                        'qualitative assessment' => 'penilaian kualitatif',
                        'institutional standard' => 'standar institusional',
                    ],
                    'model_response' => 'Our leadership team designs the strategic roadmap every quarter. At the operational level, all compliance protocols are audited by external partners. Currently, our internal infrastructure is fully resilient, and all division heads will execute the directives before the deadline.',
                ],
                [
                    'scenario' => 'Is remote work sustainable for all knowledge-sector organizations over the next decade?',
                    'context' => 'Menimbang fleksibilitas kerja jarak jauh, penghematan sewa kantor, versus memudarnya budaya kolaboratif dan tantangan integrasi karyawan baru.',
                    'pro_points' => [
                        'Global talent acquisition without geographic or visa-related boundaries.',
                        'Measurable uplift in individual focus time and autonomy.',
                        'Substantial overhead reduction on commercial real estate.',
                    ],
                    'con_points' => [
                        'Gradual dilution of organizational culture and spontaneous innovation.',
                        'Asynchronous communication fatigue and cross-border timezone friction.',
                        'Difficulties in mentoring and onboarding junior talent effectively.',
                    ],
                    'vocab' => [
                        'asynchronous communication' => 'komunikasi asinkron',
                        'talent acquisition' => 'perekrutan talenta',
                        'cultural dilution' => 'pengikisan budaya organisasi',
                        'commercial real estate' => 'properti komersial',
                    ],
                    'model_response' => 'Much as modern digital tools facilitate seamless communication across continents, the assumption that fully remote setups suit every enterprise is overly simplistic. Provided that hybrid frameworks are implemented with deliberate in-person touchpoints, organizations can capture productivity gains while safeguarding team cohesion. Even if physical presence is reduced, collective innovation still thrives on spontaneous interaction.',
                ],
            ],
        ];

        // Fallback for meetings without explicit customized scenario breakdown
        $currentScenarioDetails = $scenarioDetails[$meetingNumber] ?? [
            [
                'scenario' => $scenarios[0] ?? 'Strategic Analysis Discussion',
                'context' => 'Diskusikan implikasi strategis, dampak risiko, dan solusi nyata berdasarkan topik pertemuan ini.',
                'pro_points' => [
                    'Identifikasi keuntungan utama dan peluang ekspansi.',
                    'Optimasi efisiensi dan keunggulan kompetitif jangka panjang.',
                ],
                'con_points' => [
                    'Pertimbangkan potensi risiko kepatuhan dan biaya mitigasi.',
                    'Antisipasi resistensi tim dan tantangan eksekusi di lapangan.',
                ],
                'vocab' => [
                    'strategic alignment' => 'keselarasan strategis',
                    'contingency plan' => 'rencana kontinjensi',
                    'mitigation strategy' => 'strategi mitigasi',
                ],
                'model_response' => 'From an executive perspective, achieving sustainable growth requires a disciplined balance between ambitious innovation and rigorous risk oversight.',
            ]
        ];

        // Rapid-Fire Impromptu Prompts
        $impromptuPrompts = [
            1 => [
                'prompt' => 'In 60 seconds: Is it better to launch an imperfect product quickly, or wait until all features are polished?',
                'hint' => 'Awali dengan: "Much as I value thorough product refinement, in today\'s agile landscape..."',
            ],
            2 => [
                'prompt' => 'In 60 seconds: How should a leader handle a situation where a key project misses its deadline due to unforeseen external market conditions?',
                'hint' => 'Awali dengan: "Provided that transparent communication is prioritized from day one..."',
            ],
            3 => [
                'prompt' => 'In 60 seconds: Do you agree that high salaries are more effective in retaining executive talent than corporate culture?',
                'hint' => 'Awali dengan: "Even if financial compensation remains a critical baseline, long-term retention..."',
            ],
        ];

        // Self-evaluation checklist
        $evaluationCriteria = [
            'Mengawali argumen dengan pola struktur C1/C2 (tanpa jawaban singkat "Yes/No").',
            'Menyertakan minimal 2 kosakata tingkat lanjut / frasa bisnis yang relevan.',
            'Menjaga tempo bicara stabil, jelas, dan menghindari pengisi ("um / uh / like").',
            'Menyajikan sudut pandang berimbang (mengakui sanggahan sebelum menegaskan kesimpulan).',
            'Menyampaikan argumen dalam batas waktu yang ditentukan (90-120 detik).',
        ];

        $translations = self::getSpeakingTranslations($meetingNumber);
        $qa20 = self::getSpeakingQA20($meetingNumber);
        $qa10 = self::getSpeakingQA10($meetingNumber);
        $monologue = self::getSpeakingMonologue($meetingNumber);
        $aiInterview = self::getAiInterviewQuestions($qa20);

        return [
            'speaking' => $speaking,
            'title' => $title,
            'subtitle' => $subtitle,
            'target' => $target,
            'scenarios' => $scenarios,
            'deliveryRules' => $deliveryRules,
            'discussionPrompt' => $discussionPrompt,
            'framework' => $framework,
            'scenarioDetails' => $currentScenarioDetails,
            'impromptuPrompts' => $impromptuPrompts,
            'evaluationCriteria' => $evaluationCriteria,
            'translations' => $translations,
            'qa20' => $qa20,
            'qa10' => $qa10,
            'monologue' => $monologue,
            'ai_interview' => $aiInterview,
        ];
    }

    /**
     * Derives a ~10-question AI voice interview set from the existing 20
     * tutor Q&A bank (every other question, so all 4 level clusters -
     * A2/B1, B1/B2, B2/C1, C1/C2 - stay represented) instead of maintaining
     * a separate hand-written question list per meeting.
     */
    public static function getAiInterviewQuestions(array $qa20): array
    {
        $questions = [];
        foreach (array_values($qa20) as $i => $item) {
            if ($i % 2 !== 0) {
                continue;
            }
            $hintParts = array_filter([
                !empty($item['focus']) ? 'Pola: ' . $item['focus'] : null,
                !empty($item['vocab_hint']) ? 'Kosakata: ' . $item['vocab_hint'] : null,
            ]);
            $questions[] = [
                'id' => count($questions) + 1,
                'question' => $item['tutor_question'] ?? '',
                'hint' => implode(' | ', $hintParts),
            ];
        }

        return $questions;
    }

    /**
     * 1. 10 Translation practice sentences (Indonesian to English) for speaking drill.
     */
    public static function getSpeakingTranslations(int $meetingNumber): array
    {
        $speakingClass = "\\App\\Domain\\CustomClass\\Speaking\\Meeting{$meetingNumber}SpeakingData";
        if (class_exists($speakingClass) && method_exists($speakingClass, 'getTranslations')) {
            return $speakingClass::getTranslations();
        }

        $all = [
            1 => [
                // -------------------------------------------------------------
                // -------------------------------------------------------------
                // BAGIAN A: 10 LATIHAN TERJEMAHAN SANTAI SEPUTAR KEHIDUPAN SEHARI-HARI (GENERAL)
                // -------------------------------------------------------------
                [
                    'num' => 1,
                    'section' => 'general',
                    'category' => 'Daily Routine',
                    'id_text' => 'Kakak perempuan saya selalu menyiapkan sarapan lezat untuk keluarga kami setiap pagi sebelum berangkat kerja.',
                    'en_text' => 'My older sister always prepares a delicious breakfast for our family every morning before leaving for work.',
                    'grammar_point' => 'Simple Present (Aktif): S + V1(s/es) + O',
                    'vocab_hint' => 'kakak perempuan: older sister, selalu: always, menyiapkan: prepare (prepares), sarapan lezat: delicious breakfast, sebelum: before, berangkat kerja: leave for work',
                ],
                [
                    'num' => 2,
                    'section' => 'general',
                    'category' => 'Home & Living',
                    'id_text' => 'Tanaman hias di teras depan disiram dua kali sehari oleh adik laki-laki saya.',
                    'en_text' => 'The ornamental plants on the front porch are watered twice a day by my younger brother.',
                    'grammar_point' => 'Simple Present (Pasif): S + is/am/are + V3',
                    'vocab_hint' => 'tanaman hias: ornamental plants, teras depan: front porch, disiram: watered, dua kali sehari: twice a day, adik laki-laki: younger brother',
                ],
                [
                    'num' => 3,
                    'section' => 'general',
                    'category' => 'Lifestyle',
                    'id_text' => 'Udara pagi di taman kota sangat sejuk dan nyaman untuk berolahraga jalan santai.',
                    'en_text' => 'The morning air in the city park is very cool and comfortable for a casual walk.',
                    'grammar_point' => 'Simple Present (Nominal): S + is/am/are + Adj',
                    'vocab_hint' => 'udara pagi: morning air, taman kota: city park, sangat sejuk: very cool, nyaman: comfortable, jalan santai: casual walk',
                ],
                [
                    'num' => 4,
                    'section' => 'general',
                    'category' => 'Family & Weekend',
                    'id_text' => 'Kami mengunjungi rumah nenek akhir pekan lalu dan memasak makan siang bersama.',
                    'en_text' => 'We visited our grandmother’s house last weekend and cooked lunch together.',
                    'grammar_point' => 'Simple Past (Aktif): S + V2 + O',
                    'vocab_hint' => 'mengunjungi: visit (visited), rumah nenek: grandmother’s house, akhir pekan lalu: last weekend, memasak makan siang: cook lunch (cooked lunch), bersama: together',
                ],
                [
                    'num' => 5,
                    'section' => 'general',
                    'category' => 'Food & Baking',
                    'id_text' => 'Kue bolu cokelat lezat ini dipanggang oleh ibu saya kemarin sore.',
                    'en_text' => 'This delicious chocolate sponge cake was baked by my mother yesterday afternoon.',
                    'grammar_point' => 'Simple Past (Pasif): S + was/were + V3',
                    'vocab_hint' => 'kue bolu cokelat lezat: delicious chocolate sponge cake, dipanggang: baked, kemarin sore: yesterday afternoon',
                ],
                [
                    'num' => 6,
                    'section' => 'general',
                    'category' => 'Daily Experiences',
                    'id_text' => 'Kondisi cuaca kemarin sangat cerah dan sejuk sepanjang hari.',
                    'en_text' => 'The weather condition yesterday was very sunny and cool all day.',
                    'grammar_point' => 'Simple Past (Nominal): S + was/were + Adj',
                    'vocab_hint' => 'kondisi cuaca: weather condition, kemarin: yesterday, sangat cerah: very sunny, sejuk: cool, sepanjang hari: all day',
                ],
                [
                    'num' => 7,
                    'section' => 'general',
                    'category' => 'Vacation Plans',
                    'id_text' => 'Keluarga kami akan pergi berlibur ke pantai akhir pekan ini untuk menikmati matahari terbenam.',
                    'en_text' => 'Our family will go on a holiday to the beach this weekend to enjoy the sunset.',
                    'grammar_point' => 'Simple Future (Aktif): S + will + V1 + O',
                    'vocab_hint' => 'keluarga kami: our family, pergi berlibur: go on a holiday, ke pantai: to the beach, akhir pekan ini: this weekend, menikmati: enjoy, matahari terbenam: sunset',
                ],
                [
                    'num' => 8,
                    'section' => 'general',
                    'category' => 'Home Preparation',
                    'id_text' => 'Kamar tidur tamu akan dibersihkan oleh adik saya besok pagi.',
                    'en_text' => 'The guest bedroom will be cleaned by my sister tomorrow morning.',
                    'grammar_point' => 'Simple Future (Pasif): S + will be + V3',
                    'vocab_hint' => 'kamar tidur tamu: guest bedroom, dibersihkan: cleaned, oleh adik perempuan saya: by my sister, besok pagi: tomorrow morning',
                ],
                [
                    'num' => 9,
                    'section' => 'general',
                    'category' => 'Health Habits',
                    'id_text' => 'Kita harus minum banyak air putih dan berolahraga ringan setiap hari agar tubuh tetap bugar.',
                    'en_text' => 'We must drink plenty of water and do light exercise every day to stay fit.',
                    'grammar_point' => 'Modal Verbs (Aktif): S + Modal + V1 + O',
                    'vocab_hint' => 'harus: must, minum banyak air putih: drink plenty of water, olahraga ringan: light exercise, setiap hari: every day, tetap bugar: stay fit',
                ],
                [
                    'num' => 10,
                    'section' => 'general',
                    'category' => 'Pet Care',
                    'id_text' => 'Kucing peliharaan kami harus diberi makan tepat waktu agar selalu sehat dan lincah.',
                    'en_text' => 'Our pet cat must be fed on time so that he stays healthy and playful.',
                    'grammar_point' => 'Modal Verbs (Pasif): S + Modal + be + V3',
                    'vocab_hint' => 'kucing peliharaan: pet cat, harus diberi makan: must be fed, tepat waktu: on time, selalu sehat: always healthy, lincah: playful',
                ],

                // -------------------------------------------------------------
                // BAGIAN B: 10 LATIHAN TERJEMAHAN TOPIK ENVIRONMENTAL SCIENCE
                // -------------------------------------------------------------
                [
                    'num' => 11,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Renewable Energy',
                    'id_text' => 'Pembangkit listrik tenaga surya menghasilkan energi bersih untuk ribuan rumah tangga di wilayah pedesaan ini.',
                    'en_text' => 'Solar power plants generate clean energy for thousands of households in this rural region.',
                    'grammar_point' => 'Simple Present (Aktif): S + V1(s/es) + O',
                    'vocab_hint' => 'pembangkit listrik tenaga surya: solar power plants, menghasilkan: generate, energi bersih: clean energy, ribuan rumah tangga: thousands of households, wilayah pedesaan: rural region',
                ],
                [
                    'num' => 12,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Waste Management',
                    'id_text' => 'Limbah plastik dari kawasan perumahan dipilah dan didaur ulang setiap minggu oleh fasilitas pengolahan limbah kota.',
                    'en_text' => 'Plastic waste from residential areas is sorted and recycled every week by the municipal waste facility.',
                    'grammar_point' => 'Simple Present (Pasif): S + is/am/are + V3',
                    'vocab_hint' => 'limbah plastik: plastic waste, kawasan perumahan: residential areas, dipilah dan didaur ulang: sorted and recycled, setiap minggu: every week, fasilitas limbah kota: municipal waste facility',
                ],
                [
                    'num' => 13,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Coastal Conservation',
                    'id_text' => 'Hutan mangrove di sepanjang garis pantai sangat penting untuk perlindungan daratan dari abrasi air laut.',
                    'en_text' => 'Mangrove forests along the coastline are vital for mainland protection against sea wave erosion.',
                    'grammar_point' => 'Simple Present (Nominal): S + is/am/are + Adj',
                    'vocab_hint' => 'hutan mangrove: mangrove forests, sepanjang garis pantai: along the coastline, sangat penting: vital, perlindungan daratan: mainland protection, abrasi air laut: sea wave erosion',
                ],
                [
                    'num' => 14,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Reforestation Project',
                    'id_text' => 'Para relawan lingkungan menanam lima ribu bibit pohon di bukit gundul itu bulan lalu.',
                    'en_text' => 'Environmental volunteers planted five thousand tree seedlings on that barren hill last month.',
                    'grammar_point' => 'Simple Past (Aktif): S + V2 + O',
                    'vocab_hint' => 'relawan lingkungan: environmental volunteers, menanam: plant (planted), lima ribu bibit pohon: five thousand tree seedlings, bukit gundul: barren hill, bulan lalu: last month',
                ],
                [
                    'num' => 15,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Marine Ecosystem',
                    'id_text' => 'Taman nasional laut ini dilindungi secara ketat oleh pemerintah tahun lalu.',
                    'en_text' => 'This marine national park was strictly protected by the government last year.',
                    'grammar_point' => 'Simple Past (Pasif): S + was/were + V3',
                    'vocab_hint' => 'taman nasional laut: marine national park, dilindungi secara ketat: strictly protected, oleh pemerintah: by the government, tahun lalu: last year',
                ],
                [
                    'num' => 16,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Air Quality',
                    'id_text' => 'Indeks kualitas udara di kota metropolitan itu sangat berbahaya selama musim kemarau panjang tahun 2023.',
                    'en_text' => 'The air quality index in that metropolitan city was hazardous during the prolonged dry season in 2023.',
                    'grammar_point' => 'Simple Past (Nominal): S + was/were + Adj',
                    'vocab_hint' => 'indeks kualitas udara: air quality index, kota metropolitan: metropolitan city, sangat berbahaya: hazardous, musim kemarau panjang: prolonged dry season',
                ],
                [
                    'num' => 17,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Urban Decarbonization',
                    'id_text' => 'Pemerintah kota akan meluncurkan armada bus listrik baru tahun depan untuk menekan emisi karbon perkotaan.',
                    'en_text' => 'The city government will launch a new fleet of electric buses next year to reduce urban carbon emissions.',
                    'grammar_point' => 'Simple Future (Aktif): S + will + V1 + O',
                    'vocab_hint' => 'pemerintah kota: city government, meluncurkan: launch, armada bus listrik: fleet of electric buses, tahun depan: next year, menekan emisi karbon: reduce carbon emissions',
                ],
                [
                    'num' => 18,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Water Management',
                    'id_text' => 'Panel surya ramah lingkungan akan dipasang di atap gedung sekolah minggu depan.',
                    'en_text' => 'Eco-friendly solar panels will be installed on the school roof next week.',
                    'grammar_point' => 'Simple Future (Pasif): S + will be + V3',
                    'vocab_hint' => 'panel surya ramah lingkungan: eco-friendly solar panels, dipasang: installed, atap gedung sekolah: school roof, minggu depan: next week',
                ],
                [
                    'num' => 19,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Pollution Prevention',
                    'id_text' => 'Kita harus mengurangi pemakaian kemasan plastik sekali pakai untuk mencegah pencemaran mikroplastik di ekosistem perairan.',
                    'en_text' => 'We must reduce the consumption of single-use plastic packaging to prevent microplastic pollution in aquatic ecosystems.',
                    'grammar_point' => 'Modal Verbs (Aktif): S + Modal + V1 + O',
                    'vocab_hint' => 'harus mengurangi pemakaian: must reduce consumption, kemasan plastik sekali pakai: single-use plastic packaging, mencegah pencemaran: prevent pollution, mikroplastik: microplastic, ekosistem perairan: aquatic ecosystems',
                ],
                [
                    'num' => 20,
                    'section' => 'environmental',
                    'category' => 'Environmental Science',
                    'sub_category' => 'Industrial Emissions',
                    'id_text' => 'Standar emisi gas buang pabrik harus dipatuhi secara ketat oleh setiap perusahaan industri untuk menjaga kelestarian lingkungan.',
                    'en_text' => 'Industrial exhaust emission standards must be strictly obeyed by every manufacturing company to preserve the environment.',
                    'grammar_point' => 'Modal Verbs (Pasif): S + Modal + be + V3',
                    'vocab_hint' => 'standar emisi gas buang pabrik: industrial exhaust emission standards, harus dipatuhi secara ketat: must be strictly obeyed, perusahaan industri: manufacturing company, menjaga kelestarian lingkungan: preserve the environment',
                ],
            ],
        ];

        if (isset($all[$meetingNumber])) {
            return $all[$meetingNumber];
        }

        // Generic fallback for meetings 3-10
        $curriculum = self::getMeetingDetails($meetingNumber);
        $topic = $curriculum['topic'] ?? "Meeting {$meetingNumber}";
        $items = [];
        for ($i = 1; $i <= 10; $i++) {
            $items[] = [
                'num' => $i,
                'id_text' => "Latihan Kalimat {$i}: Terjemahkan kalimat mengenai dinamika {$topic} ke dalam bahasa Inggris formal level C1/C2.",
                'en_text' => "Professional sentence {$i} relating to {$topic}: Demonstrating precise structure, formal business terminology, and natural executive pacing.",
                'grammar_point' => "Target Grammar Structure for Meeting {$meetingNumber}",
                'vocab_hint' => 'strategic alignment, operational synergy, executive delivery',
            ];
        }
        return $items;
    }

    /**
     * 2. 20 Questions & Answers Drill (Tutor & Teacher).
     * Fully unified around the single central topic of the meeting.
     */
    public static function getSpeakingQA20(int $meetingNumber): array
    {
        $speakingClass = "\\App\\Domain\\CustomClass\\Speaking\\Meeting{$meetingNumber}SpeakingData";
        if (class_exists($speakingClass) && method_exists($speakingClass, 'getQA20')) {
            return $speakingClass::getQA20();
        }

        $all = [
            1 => [
                // -------------------------------------------------------------------------------------------------
                // SESI INTERVIEW (20 PERTANYAAN): 4 CLUSTER x 5 SOAL (10% A1-A2, 60% B1-B2, 30% C1-C2)
                // -------------------------------------------------------------------------------------------------

                // =========================================================================
                // CLUSTER 1: PERTANYAAN PRIBADI (PERSONAL & DAILY LIFE) - 5 SOAL
                // =========================================================================
                [
                    'num' => 1,
                    'cluster' => 'Pertanyaan Pribadi',
                    'category' => 'Daily Routine',
                    'level' => 'A2',
                    'tutor_question' => 'What is your typical morning routine before you start your daily study or work?',
                    'teacher_answer' => 'I usually wake up at six in the morning, drink a glass of warm water, and prepare a simple breakfast before I begin my daily activities.',
                    'focus' => 'Simple Present (Aktif): S + V1(s/es) + O',
                    'vocab_hint' => 'typical morning routine: rutinitas pagi umum, wake up: bangun tidur, prepare breakfast: menyiapkan sarapan, daily activities: aktivitas harian',
                ],
                [
                    'num' => 2,
                    'cluster' => 'Pertanyaan Pribadi',
                    'category' => 'Free Time & Weekend',
                    'level' => 'A2',
                    'tutor_question' => 'What did you do to unwind last weekend, and who did you spend time with?',
                    'teacher_answer' => 'I visited my grandparents\' house last weekend, and we cooked traditional noodles together for family lunch.',
                    'focus' => 'Simple Past (Aktif): S + V2 + O',
                    'vocab_hint' => 'unwind: bersantai/melepas lelah, last weekend: akhir pekan lalu, visit grandparents: mengunjungi kakek-nenek, cook together: memasak bersama',
                ],
                [
                    'num' => 3,
                    'cluster' => 'Pertanyaan Pribadi',
                    'category' => 'Language & Confidence',
                    'level' => 'B1',
                    'tutor_question' => 'Are you usually confident when speaking English with new acquaintances, or are you quite reserved?',
                    'teacher_answer' => 'I am generally enthusiastic and sociable, but I am sometimes nervous when I have to articulate complex concepts quickly.',
                    'focus' => 'Simple Present (Nominal): S + is/am/are + Adj',
                    'vocab_hint' => 'confident: percaya diri, new acquaintances: kenalan baru, reserved: pendiam/tertutup, articulate concepts: menyampaikan konsep',
                ],
                [
                    'num' => 4,
                    'cluster' => 'Pertanyaan Pribadi',
                    'category' => 'Past Achievement',
                    'level' => 'B1',
                    'tutor_question' => 'What proud personal project or assignment was accomplished by you during your previous studies?',
                    'teacher_answer' => 'A comprehensive field report on rural drinking water was completed by my research team last semester with great success.',
                    'focus' => 'Simple Past (Pasif): S + was/were + V3',
                    'vocab_hint' => 'proud personal project: proyek pribadi yang membanggakan, accomplished: diselesaikan, field report: laporan lapangan, last semester: semester lalu',
                ],
                [
                    'num' => 5,
                    'cluster' => 'Pertanyaan Pribadi',
                    'category' => 'Future Aspirations',
                    'level' => 'B2',
                    'tutor_question' => 'How will you organize your weekly schedule to balance rigorous academic study and personal health this year?',
                    'teacher_answer' => 'I will dedicate early mornings to cardiovascular workouts and designate specific uninterrupted blocks for academic research.',
                    'focus' => 'Simple Future (Aktif): S + will + V1 + O',
                    'vocab_hint' => 'rigorous study: studi intensif/ketat, balance schedule: menyeimbangkan jadwal, cardiovascular workouts: latihan kardio, uninterrupted blocks: waktu fokus tanpa gangguan',
                ],

                // =========================================================================
                // CLUSTER 2: OPINI TENTANG ISU SOSIAL & KEMASYARAKATAN (SOCIAL ISSUES) - 5 SOAL
                // =========================================================================
                [
                    'num' => 6,
                    'cluster' => 'Opini Isu Sosial',
                    'category' => 'Mental Health Awareness',
                    'level' => 'B1',
                    'tutor_question' => 'Why is mental health awareness now openly discussed in schools and modern workplaces?',
                    'teacher_answer' => 'Emotional stress is recognized as a genuine health condition, so professional counseling services are provided to assist struggling individuals.',
                    'focus' => 'Simple Present (Pasif): S + is/am/are + V3',
                    'vocab_hint' => 'mental health awareness: kesadaran kesehatan mental, openly discussed: dibahas secara terbuka, recognized: diakui, counseling services: layanan konseling, assist individuals: membantu individu',
                ],
                [
                    'num' => 7,
                    'cluster' => 'Opini Isu Sosial',
                    'category' => 'Digital Divide & Education',
                    'level' => 'B1',
                    'tutor_question' => 'Why must governments provide affordable internet access to underprivileged students in rural communities?',
                    'teacher_answer' => 'Public authorities must bridge the digital divide because equal educational materials must be distributed fairly to all children.',
                    'focus' => 'Modal Verbs (Aktif): S + Modal + V1 + O',
                    'vocab_hint' => 'digital divide: kesenjangan digital, affordable internet: internet terjangkau, underprivileged students: siswa kurang mampu, rural communities: masyarakat pedesaan, bridge the divide: menjembatani kesenjangan',
                ],
                [
                    'num' => 8,
                    'cluster' => 'Opini Isu Sosial',
                    'category' => 'Youth & Gig Economy',
                    'level' => 'B2',
                    'tutor_question' => 'Is flexible freelance work truly advantageous for young jobseekers, or is traditional corporate employment more secure?',
                    'teacher_answer' => 'Independent freelancing is wonderfully flexible for self-directed workers, but traditional company employment is far more dependable for medical benefits and retirement security.',
                    'focus' => 'Simple Present (Nominal): S + is/am/are + Adj',
                    'vocab_hint' => 'freelance work: kerja lepas, advantageous: menguntungkan, jobseekers: pencari kerja, corporate employment: pekerjaan kantor, dependable: dapat diandalkan, medical benefits: tunjangan kesehatan',
                ],
                [
                    'num' => 9,
                    'cluster' => 'Opini Isu Sosial',
                    'category' => 'Affordable Urban Housing',
                    'level' => 'B2',
                    'tutor_question' => 'Will affordable public housing be constructed by metropolitan governments to assist lower-income families in coming years?',
                    'teacher_answer' => 'Subsidized rental apartments will be developed near major train stations, and property price speculation will be regulated strictly by housing authorities.',
                    'focus' => 'Simple Future (Pasif): S + will be + V3',
                    'vocab_hint' => 'affordable public housing: perumahan rakyat terjangkau, constructed: dibangun, lower-income families: keluarga berpenghasilan rendah, subsidized apartments: apartemen bersubsidi, price speculation: spekulasi harga',
                ],
                [
                    'num' => 10,
                    'cluster' => 'Opini Isu Sosial',
                    'category' => 'Aging Population & Elderly Care',
                    'level' => 'B2',
                    'tutor_question' => 'Why should modern urban communities be more compassionate and supportive toward senior citizens?',
                    'teacher_answer' => 'Societies should be respectful of older generations because retired seniors are often vulnerable to loneliness and physical isolation.',
                    'focus' => 'Modal Verbs (Nominal): S + Modal + be + Adj',
                    'vocab_hint' => 'aging population: populasi menua, compassionate: penuh kepedulian, supportive: mendukung, senior citizens: warga lansia, vulnerable: rentan, loneliness: kesepian, physical isolation: isolasi fisik',
                ],

                // =========================================================================
                // CLUSTER 3: KEHIDUPAN DI AMERIKA DAN KAMPUS (US LIFE & CAMPUS) - 5 SOAL
                // =========================================================================
                [
                    'num' => 11,
                    'cluster' => 'Kehidupan di Amerika & Kampus',
                    'category' => 'Classroom Dynamics',
                    'level' => 'B2',
                    'tutor_question' => 'How do American university professors encourage active debate and student participation in seminars?',
                    'teacher_answer' => 'Professors frequently pose provocative questions, encourage students to challenge opinions politely, and reward critical thinking during class.',
                    'focus' => 'Simple Present (Aktif): S + V1(s/es) + O',
                    'vocab_hint' => 'active debate: debat aktif, seminar participation: partisipasi seminar, pose questions: mengajukan pertanyaan, critical thinking: berpikir kritis',
                ],
                [
                    'num' => 12,
                    'cluster' => 'Kehidupan di Amerika & Kampus',
                    'category' => 'Dormitory Living',
                    'level' => 'B2',
                    'tutor_question' => 'How should shared living arrangements and chores be negotiated between international roommates in college dorms?',
                    'teacher_answer' => 'Quiet hours, grocery sharing, and cleaning duties should be negotiated openly during the first week to prevent interpersonal conflict.',
                    'focus' => 'Modal Verbs (Pasif): S + Modal + be + V3',
                    'vocab_hint' => 'living arrangements: aturan tempat tinggal, chores: tugas rumah tangga, college dorms: asrama kampus, interpersonal conflict: konflik antar-pribadi',
                ],
                [
                    'num' => 13,
                    'cluster' => 'Kehidupan di Amerika & Kampus',
                    'category' => 'Cultural Adaptation',
                    'level' => 'B2',
                    'tutor_question' => 'Was the initial cultural adaptation process challenging for international scholars upon arriving in the United States?',
                    'teacher_answer' => 'The transition was quite demanding at first due to colloquial slang and fast conversational pace, but campus orientation programs were extremely helpful.',
                    'focus' => 'Simple Past (Nominal): S + was/were + Adj',
                    'vocab_hint' => 'cultural adaptation: adaptasi budaya, challenging / demanding: menantang, colloquial slang: bahasa gaul lokal, orientation programs: program orientasi',
                ],
                [
                    'num' => 14,
                    'cluster' => 'Kehidupan di Amerika & Kampus',
                    'category' => 'Campus Networking',
                    'level' => 'B2',
                    'tutor_question' => 'What campus student organizations or academic societies will you join to expand your international professional network?',
                    'teacher_answer' => 'I will join the graduate student council and attend university colloquiums to establish enduring professional relationships with scholars.',
                    'focus' => 'Simple Future (Aktif): S + will + V1 + O',
                    'vocab_hint' => 'student organizations: organisasi mahasiswa, professional network: jaringan profesional, graduate council: dewan pascasarjana, colloquiums: pertemuan ilmiah',
                ],
                [
                    'num' => 15,
                    'cluster' => 'Kehidupan di Amerika & Kampus',
                    'category' => 'Academic Integrity',
                    'level' => 'C1',
                    'tutor_question' => 'Why must rigorous academic integrity and citation standards be maintained without compromise in American higher education?',
                    'teacher_answer' => 'Scholarly citation standards must be enforced strictly to safeguard institutional credibility, acknowledge intellectual property, and eliminate scholarly misconduct.',
                    'focus' => 'Modal Verbs (Pasif): S + Modal + be + V3',
                    'vocab_hint' => 'academic integrity: integritas akademik, citation standards: standar sitasi, institutional credibility: kredibilitas institusi, intellectual property: kekayaan intelektual',
                ],

                // =========================================================================
                // CLUSTER 4: ENVIRONMENTAL SCIENCE & SUSTAINABILITY - 5 SOAL
                // =========================================================================
                [
                    'num' => 16,
                    'cluster' => 'Environmental Science',
                    'category' => 'Renewable Energy',
                    'level' => 'C1',
                    'tutor_question' => 'How do progressive municipal governments accelerate the operational integration of decentralized renewable energy?',
                    'teacher_answer' => 'Municipal utility operators construct smart microgrids, deploy utility-scale storage batteries, and provide feed-in tariffs for residential rooftop solar.',
                    'focus' => 'Simple Present (Aktif): S + V1(s/es) + O',
                    'vocab_hint' => 'municipal governments: pemerintah kota, operational integration: integrasi operasional, decentralized renewable energy: energi terbarukan terdesentralisasi, smart microgrids: jaringan mikro pintar',
                ],
                [
                    'num' => 17,
                    'cluster' => 'Environmental Science',
                    'category' => 'Greenwashing & Regulation',
                    'level' => 'C1',
                    'tutor_question' => 'How were corporate sustainability claims and greenwashing tactics penalized by international regulatory watchdogs last year?',
                    'teacher_answer' => 'Deceptive emissions reporting was investigated through forensic environmental audits, and substantial financial fines were levied on non-compliant corporations.',
                    'focus' => 'Simple Past (Pasif): S + was/were + V3',
                    'vocab_hint' => 'sustainability claims: klaim keberlanjutan, greenwashing tactics: taktik greenwashing, regulatory watchdogs: pengawas regulasi, forensic audits: audit forensik',
                ],
                [
                    'num' => 18,
                    'cluster' => 'Environmental Science',
                    'category' => 'Climate Resilience',
                    'level' => 'C1',
                    'tutor_question' => 'How will climate-resilient sponge cities be engineered to withstand severe monsoon cloudbursts in the next decade?',
                    'teacher_answer' => 'Urban centers will be redesigned with permeable pavements, bioswales, and subterranean storm reservoirs to absorb unprecedented rainwater volumes.',
                    'focus' => 'Simple Future (Pasif): S + will be + V3',
                    'vocab_hint' => 'climate-resilient: tahan iklim, sponge cities: konsep kota spons, engineered: dirancang teknik, permeable pavements: aspal berpori, bioswales: saluran drainase vegetasi',
                ],
                [
                    'num' => 19,
                    'cluster' => 'Environmental Science',
                    'category' => 'Circular Economy',
                    'level' => 'C2',
                    'tutor_question' => 'Why must multinational manufacturing consortia transition unconditionally toward closed-loop industrial ecology?',
                    'teacher_answer' => 'Heavy industries must dismantle linear production models to eliminate toxic downstream externalities and decouple economic productivity from finite resource consumption.',
                    'focus' => 'Modal Verbs (Aktif): S + Modal + V1 + O',
                    'vocab_hint' => 'manufacturing consortia: konsorsium manufaktur, closed-loop industrial ecology: ekologi industri sirkular tertutup, downstream externalities: dampak eksternalitas hilir, resource consumption: konsumsi sumber daya',
                ],
                [
                    'num' => 20,
                    'cluster' => 'Environmental Science',
                    'category' => 'Ocean Governance',
                    'level' => 'C2',
                    'tutor_question' => 'Why is multilateral oceanic governance indispensable for safeguarding fragile benthic biodiversity across the high seas?',
                    'teacher_answer' => 'Extraterritorial marine ecosystems are exceptionally vulnerable to unregulated seabed mining, so binding multinational treaties are imperative for holistic oceanic preservation.',
                    'focus' => 'Simple Present (Nominal): S + is/am/are + Adj',
                    'vocab_hint' => 'multilateral governance: tata kelola multilateral, indispensable: sangat penting/mutlak, benthic biodiversity: keanekaragaman hayati laut dalam, high seas: laut lepas internasional',
                ],
            ],
        ];

        if (isset($all[$meetingNumber])) {
            return $all[$meetingNumber];
        }

        // Generic fallback for meetings 3-10
        $curriculum = self::getMeetingDetails($meetingNumber);
        $topic = $curriculum['topic'] ?? "Meeting {$meetingNumber}";
        $items = [];
        for ($i = 1; $i <= 20; $i++) {
            $items[] = [
                'num' => $i,
                'tutor_question' => "Executive question {$i} regarding {$topic}: How would you strategically approach this challenge?",
                'teacher_answer' => "In addressing question {$i}, our priority centers on disciplined execution, stakeholder alignment, and clear measurable outcomes.",
                'focus' => "Focus area {$i} for {$topic}",
            ];
        }
        return $items;
    }

    /**
     * 3. 10 In-Depth Q&A Questions (Tutor & Teacher / Deep Discussion).
     * Strictly focused on the single central theme of the meeting.
     */
    public static function getSpeakingQA10(int $meetingNumber): array
    {
        $speakingClass = "\\App\\Domain\\CustomClass\\Speaking\\Meeting{$meetingNumber}SpeakingData";
        if (class_exists($speakingClass) && method_exists($speakingClass, 'getQA10')) {
            return $speakingClass::getQA10();
        }

        $all = [
            1 => [
                // -------------------------------------------------------------------------------------------------
                // 10 DISKUSI KASUS: 5 TOPIK ISU SOSIAL (B1-B2) & 5 TOPIK ENVIRONMENTAL SCIENCE POPULER (B1-B2)
                // -------------------------------------------------------------------------------------------------

                // =========================================================================
                // BAGIAN 1: 5 SOAL DISKUSI ISU SOSIAL & KEMASYARAKATAN (LEVEL B1 - B2)
                // =========================================================================
                [
                    'num' => 1,
                    'cluster' => 'Isu Sosial',
                    'category' => 'Mental Health & Modern Pressure',
                    'level' => 'B1',
                    'tutor_question' => 'Why do many young adults experience severe burnout today, and how are professional counseling services perceived in modern society?',
                    'teacher_answer' => 'Many young adults face intense academic and professional pressure daily. Professional counseling is now perceived as a vital healthcare service, and community empathy is indispensable for emotional recovery.',
                    'focus' => 'Kasus 1: Kesehatan Mental & Tekanan Hidup (Simple Present: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'young adults: generasi muda/dewasa muda, burnout: kelelahan mental ekstrim, professional counseling: konseling profesional, perceived: dipandang/dianggap, indispensable: mutlak dibutuhkan, emotional recovery: pemulihan emosional',
                ],
                [
                    'num' => 2,
                    'cluster' => 'Isu Sosial',
                    'category' => 'Digital Divide & Education',
                    'level' => 'B1',
                    'tutor_question' => 'How is educational quality affected by unequal internet connectivity, and why do rural schools struggle in the digital era?',
                    'teacher_answer' => 'Equal learning opportunities are restricted by poor broadband access in remote regions. Underprivileged students struggle without modern digital tablets, and reliable connectivity is crucial for national education.',
                    'focus' => 'Kasus 2: Kesenjangan Digital & Pemerataan Sekolah (Simple Present: Pasif, Aktif & Nominal)',
                    'vocab_hint' => 'educational quality: mutu pendidikan, unequal connectivity: konektivitas tidak merata, restricted: dibatasi, remote regions: daerah terpencil, underprivileged students: siswa kurang mampu, crucial: sangat penting',
                ],
                [
                    'num' => 3,
                    'cluster' => 'Isu Sosial',
                    'category' => 'Youth Employment & Gig Economy',
                    'level' => 'B2',
                    'tutor_question' => 'How did recent university graduates navigate the competitive job market last year, and why was freelance gig work so popular?',
                    'teacher_answer' => 'Many young graduates chose temporary freelance projects over traditional corporate jobs last year. Flexible contracts were favored by jobseekers, and online platform employment was very attractive for fresh graduates.',
                    'focus' => 'Kasus 3: Pengangguran Kaum Muda & Tren Gig Economy (Simple Past: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'university graduates: lulusan perguruan tinggi, job market: bursa kerja, freelance gig work: pekerjaan lepas berbasis proyek, favored: disukai/diminati, attractive: sangat menarik',
                ],
                [
                    'num' => 4,
                    'cluster' => 'Isu Sosial',
                    'category' => 'Affordable Urban Housing',
                    'level' => 'B2',
                    'tutor_question' => 'How will municipal governments address escalating housing prices in the coming decade, and will young families afford homes in metropolitan areas?',
                    'teacher_answer' => 'Metropolitan leaders will build subsidized high-rise apartments near central transport hubs. Rent ceilings will be enforced by municipal housing councils, and urban residences will be affordable for middle-income workers.',
                    'focus' => 'Kasus 4: Krisis Perumahan Terjangkau di Perkotaan (Simple Future: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'municipal governments: pemerintah kota, escalating prices: lonjakan harga, subsidized apartments: apartemen bersubsidi, rent ceilings: batas maksimal sewa, enforced: ditegakkan/diterapkan, affordable: terjangkau',
                ],
                [
                    'num' => 5,
                    'cluster' => 'Isu Sosial',
                    'category' => 'Aging Population & Elderly Care',
                    'level' => 'B2',
                    'tutor_question' => 'What should modern communities do to support an aging demographic, and how can comprehensive eldercare be improved effectively?',
                    'teacher_answer' => 'Local neighborhood associations should organize social visiting programs for retired seniors. Community nursing centers must be funded by public budgets, and social environments should be accessible for elderly citizens.',
                    'focus' => 'Kasus 5: Populasi Menua & Kepedulian Warga Lansia (Modal Verbs: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'aging demographic: populasi menua, eldercare: perawatan lansia, retired seniors: pensiunan lansia, funded: didanai, accessible: ramah/mudah diakses, elderly citizens: warga lanjut usia',
                ],

                // =========================================================================
                // BAGIAN 2: 5 SOAL ENVIRONMENTAL SCIENCE POPULER (LEVEL B1 - B2)
                // =========================================================================
                [
                    'num' => 6,
                    'cluster' => 'Environmental Science',
                    'category' => 'Electric Vehicles',
                    'level' => 'B1',
                    'tutor_question' => 'Why are electric vehicles becoming increasingly popular among urban motorists, and what charging infrastructure is needed?',
                    'teacher_answer' => 'Electric vehicles produce zero direct exhaust pollution, and battery charging is considerably cheaper than buying petrol. Nevertheless, fast charging stations must be installed across all rest stops and residential complexes.',
                    'focus' => 'Kasus 6: Kendaraan Listrik & Mobilitas Bersih (Simple Present: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'electric vehicles: kendaraan listrik, urban motorists: pengemudi perkotaan, zero exhaust pollution: bebas polusi knalpot, fast charging stations: stasiun pengisian cepat',
                ],
                [
                    'num' => 7,
                    'cluster' => 'Environmental Science',
                    'category' => 'Plastic Bag Reduction',
                    'level' => 'B1',
                    'tutor_question' => 'How did local retail stores implement plastic bag bans last year, and how was shopper behavior transformed?',
                    'teacher_answer' => 'Retail supermarkets phased out disposable plastic bags and offered reusable cotton bags at checkout registers. Shoppers brought their own shopping bags habitually, and plastic rubbish was reduced remarkably.',
                    'focus' => 'Kasus 7: Pengurangan Kantong Plastik & Tas Ramah Lingkungan (Simple Past: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'retail stores: toko ritel, plastic bag bans: larangan kantong plastik, disposable: sekali pakai, reusable cotton bags: tas katun pakai ulang, plastic rubbish: sampah plastik',
                ],
                [
                    'num' => 8,
                    'cluster' => 'Environmental Science',
                    'category' => 'Rooftop Solar Energy',
                    'level' => 'B2',
                    'tutor_question' => 'How will residential rooftop solar panels decrease monthly utility expenses in coming years, and will installation costs become affordable?',
                    'teacher_answer' => 'Rooftop solar panels will generate clean electricity during peak sunny hours for household appliances. Surplus power will be fed back into the local grid, and government rebates will make initial installation very affordable.',
                    'focus' => 'Kasus 8: Panel Surya Mandiri untuk Rumah Tangga (Simple Future: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'rooftop solar panels: panel surya atap, utility expenses: biaya utilitas/listrik, surplus power: kelebihan listrik, local grid: jaringan listrik lokal, government rebates: potongan/subsidi pemerintah',
                ],
                [
                    'num' => 9,
                    'cluster' => 'Environmental Science',
                    'category' => 'Fast Fashion & Thrifting',
                    'level' => 'B2',
                    'tutor_question' => 'Why is the fast fashion industry criticized for textile waste, and why is second-hand clothing thrifting so popular now?',
                    'teacher_answer' => 'Tons of cheap polyester clothing are dumped into landfills prematurely, and local waterways are contaminated by toxic textile colorants. Thrifting is very fashionable because pre-loved clothes are affordable, unique, and planet-friendly.',
                    'focus' => 'Kasus 9: Dampak Fast Fashion & Tren Thrifting (Simple Present: Pasif, Aktif & Nominal)',
                    'vocab_hint' => 'fast fashion: pakaian cepat ganti tren, textile waste: limbah tekstil, dumped into landfills: dibuang ke TPA, thrifting: belanja pakaian bekas, pre-loved clothes: pakaian bekas berkualitas, planet-friendly: ramah bumi',
                ],
                [
                    'num' => 10,
                    'cluster' => 'Environmental Science',
                    'category' => 'Food Waste & Composting',
                    'level' => 'B2',
                    'tutor_question' => 'What practical habits should families develop to prevent food waste, and how can kitchen scraps be composted at home?',
                    'teacher_answer' => 'Households should plan realistic weekly meal portions and store perishable groceries correctly. Leftover vegetable cuttings and fruit peels can be converted into organic compost for potted garden plants.',
                    'focus' => 'Kasus 10: Pengurangan Sampah Makanan & Kompos Rumahan (Modal Verbs: Aktif, Pasif & Nominal)',
                    'vocab_hint' => 'practical habits: kebiasaan praktis, food waste: sampah makanan, perishable groceries: bahan makanan yang mudah basi, kitchen scraps: sisa dapur, organic compost: kompos organik',
                ],
            ],
        ];

        if (isset($all[$meetingNumber])) {
            return $all[$meetingNumber];
        }

        // Generic fallback for meetings 3-10
        $curriculum = self::getMeetingDetails($meetingNumber);
        $topic = $curriculum['topic'] ?? "Meeting {$meetingNumber}";
        $items = [];
        for ($i = 1; $i <= 10; $i++) {
            $items[] = [
                'num' => $i,
                'tutor_question' => "In-depth strategic debate question {$i} regarding {$topic}: What are the long-term trade-offs and leadership considerations involved?",
                'teacher_answer' => "From an executive perspective on issue {$i}, leadership must balance immediate operational realities against long-term strategic resilience, ensuring full stakeholder buy-in.",
                'focus' => "Deep dive strategic analysis {$i}",
            ];
        }
        return $items;
    }

    /**
     * 4. Executive Monologue Structure, Guidelines, and Model Texts.
     */
    public static function getSpeakingMonologue(int $meetingNumber): array
    {
        $speakingClass = "\\App\\Domain\\CustomClass\\Speaking\\Meeting{$meetingNumber}SpeakingData";
        if (class_exists($speakingClass) && method_exists($speakingClass, 'getMonologue')) {
            return $speakingClass::getMonologue();
        }

        $all = [
            1 => [
                'topic' => 'Undergraduate Academic Presentation: Explaining the Closed-Loop Plastic Recycling & Material Recovery Process',
                'duration' => '2-3 Menit Presentasi Akademik Mandiri',
                'prompt' => 'Presentasikan bagan alur proses daur ulang plastik kampus (5 tahap) berikut selama 2-3 menit. Gunakan kata transisi sekuensial (First, Moving to the second stage, In the third stage, Subsequently, Finally) dan padukan kalimat pasif (pengolahan material), aktif (tindakan pemilahan), serta modal verbs (aturan kebersihan & residu) melintasi Simple Present, Simple Past, Simple Future, dan Modal Verbs.',
                'outline_guide' => [
                    '1. Introduction & Overview (30-40s)' => 'Sapa audiens, sebutkan judul bagan, jelaskan bahwa daur ulang ini terdiri dari 5 tahapan berkelanjutan (Simple Present Aktif & Nominal).',
                    '2. Step-by-Step Flowchart Walkthrough (60-80s)' => 'Jelaskan Tahap 1 s/d Tahap 5 secara runtut menggunakan pola Pasif (are collected, are sorted, is shredded, is melted, are molded).',
                    '3. Campus Pilot & Future Outlook (40-50s)' => 'Ceritakan uji coba semester lalu (Simple Past), instalasi lini otomatis semester depan (Simple Future), dan peran mahasiswa (Modal Verbs).',
                ],
                'process_diagram' => [
                    'title' => 'Closed-Loop Campus Plastic Recycling & Material Recovery Process',
                    'subtitle' => 'Bagan Alur 5 Tahap Pengolahan Sampah Botol Plastik Kampus Menjadi Produk Baru Bermanfaat',
                    'image_url' => '/images/custom-class/plastic_recycling_flowchart.jpg',
                    'diagram_vocab' => 'flowchart: bagan alur proses, closed-loop cycle: siklus tertutup, material recovery: pemulihan material, smart recycling bins: tempat sampah pintar, segregation: pemilahan di sumber, optical sorting: pemilahan sensor optik, conveyor belt: ban berjalan, sanitizing bath: bak air panas, mechanical shredding: pencacahan mekanis, granulator: mesin pencacah, plastic flakes: serpihan plastik, thermal melting: pelelehan termal, extrusion: ekstrusi plastik, recycled pellets: butiran pelet daur ulang, remanufacturing: pencetakan produk baru, park benches: bangku taman kampus, plant pots: pot tanaman',
                    'steps' => [
                        [
                            'step' => 1,
                            'icon' => '🗑️',
                            'title' => 'Source Collection & Segregation',
                            'title_id' => 'Pengumpulan & Pemilahan di Sumber',
                            'description' => 'Plastic beverage bottles are deposited into smart bins, and non-recyclables are separated immediately.',
                            'key_verb' => 'are collected & separated',
                            'vocab' => 'smart bins: tempat sampah pintar, segregation: pemilahan di sumber, beverage bottles: botol minuman',
                        ],
                        [
                            'step' => 2,
                            'icon' => '🔬',
                            'title' => 'Optical Sorting & Washing',
                            'title_id' => 'Pemisahan Polimer & Pencucian',
                            'description' => 'Plastics are sorted by resin type (PET/HDPE), and adhesive labels are washed away in hot sanitizing baths.',
                            'key_verb' => 'are sorted & washed',
                            'vocab' => 'optical sorting: pemilahan sensor optik, conveyor belt: ban berjalan, sanitizing bath: bak air panas',
                        ],
                        [
                            'step' => 3,
                            'icon' => '⚙️',
                            'title' => 'Mechanical Shredding & Drying',
                            'title_id' => 'Pencacahan & Pengeringan Flakes',
                            'description' => 'Clean plastic containers are shredded into small uniform flakes by granulators and dried thoroughly.',
                            'key_verb' => 'is shredded & dried',
                            'vocab' => 'mechanical shredding: pencacahan mekanis, granulator: mesin pencacah, plastic flakes: serpihan plastik',
                        ],
                        [
                            'step' => 4,
                            'icon' => '🧪',
                            'title' => 'Thermal Extrusion & Pelletizing',
                            'title_id' => 'Pelelehan Termal & Pembuatan Pelet',
                            'description' => 'Flakes are melted under high temperature and extruded into high-quality recycled plastic pellets.',
                            'key_verb' => 'is melted & extruded',
                            'vocab' => 'thermal melting: pelelehan termal, extrusion: ekstrusi plastik, recycled pellets: butiran pelet daur ulang',
                        ],
                        [
                            'step' => 5,
                            'icon' => '♻️',
                            'title' => 'Remanufacturing & Campus Utility',
                            'title_id' => 'Pencetakan Produk Kampus Baru',
                            'description' => 'Recycled pellets are molded into durable student stationery, campus planters, and outdoor park benches.',
                            'key_verb' => 'are molded into products',
                            'vocab' => 'remanufacturing: pencetakan produk baru, park benches: bangku taman, plant pots: pot tanaman',
                        ],
                    ],
                ],
                'vocab_hint' => 'flowchart: bagan alur proses, closed-loop recycling: daur ulang siklus tertutup, material recovery: pemulihan material, smart bins: tempat sampah pintar, resin type: jenis polimer plastik, hot sanitizing baths: bak pencucian air panas, granulators: mesin pencacah, uniform flakes: serpihan seragam, thermal extrusion: ekstrusi/pelelehan panas, recycled pellets: butiran pelet daur ulang, remanufactured: diproduksi ulang, park benches: bangku taman',
                'monologue_formal' => "Good morning, honorable professors and fellow colleagues. Today, I am honored to present this technical flowchart illustrating our university's closed-loop plastic recycling and material recovery process. As we can see on the diagram, the entire recycling cycle consists of five continuous stages. In the first stage, plastic beverage bottles are collected from designated smart bins across campus, and foreign non-recyclables are separated immediately. Moving to the second stage, the plastics are sorted mechanically by polymer resin type, and surface labels and dirt are washed away thoroughly in hot sanitizing baths. In the third stage, the clean containers are fed into high-speed granulators, where the material is shredded into fine, uniform plastic flakes. Subsequently, in the fourth stage, these plastic flakes are melted under controlled thermal extrusion and converted into high-grade recycled pellets. Finally, in the fifth stage, these recycled pellets are molded into new campus utility products, such as student clipboards, eco-friendly plant pots, and durable garden benches. Last semester, our engineering department tested this prototype system successfully, and over four hundred kilograms of plastic waste were diverted from regional landfills. Looking ahead, the university will install an automated processing facility next quarter, and all single-use plastics will be phased out campus-wide. To maintain high purity, students must rinse their bottles before disposal, and toxic contaminants should never be placed in recycling receptacles. In conclusion, this closed-loop process demonstrates that campus plastic waste can be transformed into valuable resources through systematic engineering. Thank you very much for your attention.",
                'monologue_conversational' => "Hello everyone, and welcome to my presentation. Today, I would like to walk you through this flowchart showing how our campus recycles plastic waste into useful everyday items. If you look at the diagram, there are five key stages in this closed-loop cycle. First, students drop their empty plastic bottles into campus recycling bins, and any dirty items are removed right away. Second, our facility sorts the plastics by material type, and sticky labels are washed off with hot water. Third, industrial machines shred the clean plastic into small colorful flakes. Next, in stage four, these flakes are melted down and formed into tiny recycled plastic pellets. Finally, in the fifth stage, manufacturers mold these pellets into brand new campus items like student stationery, flower planters, and outdoor benches. Last month, our green team tested this system during campus orientation, and the student community was truly impressed by the results. Next semester, our university will expand this recycling line, and new drop-off kiosks will be set up near all student dorms. Every student should clean their containers before recycling, and food residue must not enter the shredding machines. By following this simple flowchart, we can eliminate plastic trash together. Thanks a lot for listening!",
            ],
        ];

        if (isset($all[$meetingNumber])) {
            return $all[$meetingNumber];
        }

        $curriculum = self::getMeetingDetails($meetingNumber);
        $topic = $curriculum['topic'] ?? "Meeting {$meetingNumber}";
        return [
            'topic' => "Executive Monologue: Strategic Analysis of {$topic}",
            'duration' => '2-3 Menit Bicara Mandiri',
            'prompt' => "Sampaikan paparan eksekutif monolog selama 2 menit mengenai {$topic}. Gunakan struktur pembuka berbobot, jabarkan analisis dampak, dan akhiri dengan rekomendasi konkrit.",
            'outline_guide' => [
                'Hook / Opener (30s): Awali dengan identifikasi isu strategis utama.',
                'Core Arguments (60s): Uraikan bukti empiris, peluang inovasi, dan mitigasi risiko.',
                'Strategic Closer (30s): Rekomendasikan langkah keputusan eksekutif.',
            ],
            'monologue_formal' => "Good morning, colleagues. Regarding {$topic}, our executive priority must center on disciplined strategic alignment and risk mitigation. Demonstrating thorough evaluation of market forces ensures our sustained competitive edge. Thank you.",
            'monologue_conversational' => "Hello everyone. Looking closely at {$topic}, we need to ensure our teams remain focused on core execution while adapting swiftly to industry changes. Thank you.",
        ];
    }
}


