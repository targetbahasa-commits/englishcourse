<?php

namespace App\Application\GrammarWriting;

class GrammarWritingDataRepository
{

    public $meeting5TenseExamples = [
        'Simple Present' => [
            'verbal' => ['id' => 'Saya tidak makan nasi.', 'en' => 'I do not eat rice'],
            'nominal' => ['id' => 'Dia bukan guru.', 'en' => 'He is not a teacher'],
            'passive' => ['id' => 'Buku itu tidak dibaca.', 'en' => 'The book is not read']
        ],
        'Present Continuous' => [
            'verbal' => ['id' => 'Mereka tidak sedang bermain.', 'en' => 'They are not playing'],
            'nominal' => ['id' => 'Dia tidak sedang menjadi nakal.', 'en' => 'He is not being naughty'],
            'passive' => ['id' => 'Mobil itu tidak sedang dicuci.', 'en' => 'The car is not being washed']
        ],
        'Present Perfect' => [
            'verbal' => ['id' => 'Kita belum selesai.', 'en' => 'We have not finished'],
            'nominal' => ['id' => 'Dia belum pernah ke sana.', 'en' => 'He has not been there'],
            'passive' => ['id' => 'Surat itu belum dikirim.', 'en' => 'The letter has not been sent']
        ],
        'Present Perfect Continuous' => [
            'verbal' => ['id' => 'Saya belum sedang menunggu.', 'en' => 'I have not been waiting'],
            'nominal' => ['id' => 'Dia belum sedang menjadi baik.', 'en' => 'He has not been being good'],
            'passive' => ['id' => 'Rumah itu belum sedang dibangun.', 'en' => 'The house has not been being built']
        ],
        'Simple Past' => [
            'verbal' => ['id' => 'Dia tidak datang kemarin.', 'en' => 'He did not come yesterday'],
            'nominal' => ['id' => 'Saya tidak sedih tadi malam.', 'en' => 'I was not sad last night'],
            'passive' => ['id' => 'Kue itu tidak dimakan.', 'en' => 'The cake was not eaten']
        ],
        'Past Continuous' => [
            'verbal' => ['id' => 'Saya tidak sedang tidur jam 9.', 'en' => 'I was not sleeping at 9'],
            'nominal' => ['id' => 'Dia tidak sedang menjadi marah.', 'en' => 'He was not being angry'],
            'passive' => ['id' => 'Lagu itu tidak sedang dinyanyikan.', 'en' => 'The song was not being sung']
        ],
        'Past Perfect' => [
            'verbal' => ['id' => 'Mereka belum pergi sebelum hujan.', 'en' => 'They had not gone before rain'],
            'nominal' => ['id' => 'Dia belum pernah sakit sebelumnya.', 'en' => 'He had not been sick before'],
            'passive' => ['id' => 'Pekerjaan itu belum diselesaikan.', 'en' => 'The job had not been finished']
        ],
        'Past Perfect Continuous' => [
            'verbal' => ['id' => 'Kami belum sedang bekerja selama 2 jam.', 'en' => 'We had not been working for 2 hours'],
            'nominal' => ['id' => 'Dia belum sedang menjadi sibuk.', 'en' => 'He had not been being busy'],
            'passive' => ['id' => 'Jalan itu belum sedang diperbaiki.', 'en' => 'The road had not been being repaired']
        ],
        'Simple Future' => [
            'verbal' => ['id' => 'Saya tidak akan pergi.', 'en' => 'I will not go'],
            'nominal' => ['id' => 'Itu tidak akan mudah.', 'en' => 'It will not be easy'],
            'passive' => ['id' => 'Masalah itu tidak akan dilupakan.', 'en' => 'The problem will not be forgotten']
        ],
        'Future Continuous' => [
            'verbal' => ['id' => 'Kita tidak akan sedang belajar besok pagi.', 'en' => 'We will not be studying tomorrow morning'],
            'nominal' => ['id' => 'Dia tidak akan sedang menjadi malas.', 'en' => 'He will not be being lazy'],
            'passive' => ['id' => 'Kamar itu tidak akan sedang dibersihkan.', 'en' => 'The room will not be being cleaned']
        ],
        'Future Perfect' => [
            'verbal' => ['id' => 'Saya tidak akan sudah sampai jam 5.', 'en' => 'I will not have arrived by 5'],
            'nominal' => ['id' => 'Dia tidak akan sudah siap.', 'en' => 'He will not have been ready'],
            'passive' => ['id' => 'Proyek itu tidak akan sudah selesai.', 'en' => 'The project will not have been completed']
        ],
        'Future Perfect Continuous' => [
            'verbal' => ['id' => 'Mereka tidak akan sudah sedang menunggu lama.', 'en' => 'They will not have been waiting long'],
            'nominal' => ['id' => 'Dia tidak akan sudah sedang menjadi lelah.', 'en' => 'He will not have been being tired'],
            'passive' => ['id' => 'Gedung itu tidak akan sudah sedang dicat.', 'en' => 'The building will not have been being painted']
        ],
        'Simple Past Future' => [
            'verbal' => ['id' => 'Saya tidak akan melakukannya.', 'en' => 'I would not do it'],
            'nominal' => ['id' => 'Itu tidak akan benar.', 'en' => 'It would not be true'],
            'passive' => ['id' => 'Undangan itu tidak akan diterima.', 'en' => 'The invitation would not be accepted']
        ],
        'Past Future Continuous' => [
            'verbal' => ['id' => 'Kita tidak akan sedang rapat.', 'en' => 'We would not be meeting'],
            'nominal' => ['id' => 'Dia tidak akan sedang menjadi kasar.', 'en' => 'He would not be being rude'],
            'passive' => ['id' => 'Mobil itu tidak akan sedang diperbaiki.', 'en' => 'The car would not be being fixed']
        ],
        'Past Future Perfect' => [
            'verbal' => ['id' => 'Saya tidak akan sudah lupa.', 'en' => 'I would not have forgotten'],
            'nominal' => ['id' => 'Dia tidak akan sudah ada di sana.', 'en' => 'He would not have been there'],
            'passive' => ['id' => 'Paket itu tidak akan sudah dikirim.', 'en' => 'The package would not have been sent']
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => ['id' => 'Mereka tidak akan sudah sedang tidur.', 'en' => 'They would not have been sleeping'],
            'nominal' => ['id' => 'Dia tidak akan sudah sedang menjadi senang.', 'en' => 'He would not have been being happy'],
            'passive' => ['id' => 'Buku itu tidak akan sudah sedang ditulis.', 'en' => 'The book would not have been being written']
        ],
        'Modal' => [
            'verbal' => ['id' => 'Kamu tidak boleh merokok.', 'en' => 'You must not smoke'],
            'nominal' => ['id' => 'Dia mungkin tidak sakit.', 'en' => 'He might not be sick'],
            'passive' => ['id' => 'Pintu itu tidak bisa dibuka.', 'en' => 'The door cannot be opened']
        ]
    ];

    public $meeting9Questions = [
        // No individual questions - only paragraph translation
    ];

    public $meeting9Paragraph = [
        'id' => 'Pusat penelitian internasional itu telah memantau ekosistem laut di kawasan pesisir terpencil selama beberapa dekade. Banyak ilmuwan tidak sedang mempelajari metode usang karena mereka lebih suka melakukan eksperimen inovatif. Program konservasi baru akan dilaksanakan oleh pemerintah tahun depan untuk melindungi spesies yang terancam punah di perairan tropis. Laboratorium itu tidak tetap menjadi pengamat pasif; mereka harus terus mengembangkan sistem pemantauan canggih. Mahasiswa dari departemen lingkungan menikmati berpartisipasi dalam kerja lapangan bersama masyarakat lokal, meskipun beberapa staf senior menolak untuk ikut ekspedisi tahun lalu. Data historis belum dianalisis sepenuhnya oleh tim peneliti, tetapi para ahli sebaiknya mulai meninjau sampel arsip. Draf kebijakan laut, sebuah dokumen pemerintah yang komprehensif, tidak dianggap final pada konferensi karena masih memerlukan revisi. Di masa depan, pusat ini tidak akan menjadi hanya gudang data; pusat ini berencana untuk berubah menjadi pusat inovasi kolaboratif.',
        'en' => 'The international research center has been monitoring marine ecosystems in remote coastal areas for several decades. Many scientists are not studying outdated methods because they prefer to conduct innovative experiments. A new conservation program will be implemented by the government next year to protect endangered species in tropical waters. The laboratory does not remain a passive observer; they must continue to develop sophisticated monitoring systems. Students from the environmental department enjoy participating in fieldwork with local communities, although some senior staff refused to join the expedition last year. Historical data has not been fully analyzed by the research team, but experts should start reviewing archival samples. The marine policy draft, a comprehensive government document, was not considered final at the conference because it still requires revision. In the future, this center will not be just a data warehouse; it plans to transform into a collaborative innovation hub.',
        'vocab' => [
            'International research center' => 'Pusat penelitian internasional',
            'Monitor' => 'Memantau',
            'Marine ecosystem' => 'Ekosistem laut',
            'Remote coastal area' => 'Kawasan pesisir terpencil',
            'Decade' => 'Dekade',
            'Outdated method' => 'Metode usang',
            'Innovative experiment' => 'Eksperimen inovatif',
            'Conservation program' => 'Program konservasi',
            'Implement' => 'Dilaksanakan',
            'Endangered species' => 'Spesies terancam punah',
            'Tropical waters' => 'Perairan tropis',
            'Passive observer' => 'Pengamat pasif',
            'Sophisticated monitoring system' => 'Sistem pemantauan canggih',
            'Environmental department' => 'Departemen lingkungan',
            'Fieldwork' => 'Kerja lapangan',
            'Local community' => 'Masyarakat lokal',
            'Senior staff' => 'Staf senior',
            'Expedition' => 'Ekspedisi',
            'Historical data' => 'Data historis',
            'Analyze' => 'Dianalisis',
            'Archival sample' => 'Sampel arsip',
            'Marine policy draft' => 'Draf kebijakan laut',
            'Comprehensive' => 'Komprehensif',
            'Revision' => 'Revisi',
            'Data warehouse' => 'Gudang data',
            'Transform' => 'Berubah',
            'Collaborative innovation hub' => 'Pusat inovasi kolaboratif'
        ]
    ];

    public $meeting10Paragraph = [
        'id' => 'Energi surya adalah sumber energi bersih yang semakin populer. Biaya instalasi panel surya lebih rendah dibanding biaya energi fosil, walaupun adopsinya belum dianggap cukup oleh sebagian besar negara berkembang. Teknologi penyimpanan baterai saat ini adalah yang paling penting bagi transisi energi global dan harus segera ditingkatkan. Beberapa perusahaan tidak sedang menunda proyek karena mereka berkomitmen untuk mengurangi emisi. Para peneliti terus melakukan eksperimen dan berencana untuk memperluas jaringan energi terbarukan di kawasan pedesaan terpencil.',
        'en' => 'Solar energy is a clean energy source that is increasingly popular. The cost of installing solar panels is lower than the cost of fossil energy, although its adoption is not yet considered sufficient by most developing countries. Battery storage technology today is the most important for global energy transition and must be improved immediately. Some companies are not delaying projects because they are committed to reducing emissions. Researchers continue to conduct experiments and plan to expand renewable energy networks in remote rural areas.',
        'vocab' => [
            'Solar energy' => 'Energi surya',
            'Increasingly' => 'Semakin',
            'Installation' => 'Instalasi',
            'Fossil energy' => 'Energi fosil',
            'Adoption' => 'Adopsi',
            'Sufficient' => 'Cukup',
            'Developing countries' => 'Negara berkembang',
            'Battery storage' => 'Penyimpanan baterai',
            'Transition' => 'Transisi',
            'Committed' => 'Berkomitmen',
            'Emission' => 'Emisi',
            'Renewable energy' => 'Energi terbarukan',
            'Remote rural areas' => 'Kawasan pedesaan terpencil'
        ]
    ];

    public $meeting10Examples = [
        'Superlative' => [
            'id' => 'Gunung Everest adalah gunung tertinggi di dunia.',
            'en' => 'Mount Everest is the highest mountain in the world.'
        ],
        'Comparative' => [
            'id' => 'Mobilku lebih cepat daripada mobilmu.',
            'en' => 'My car is faster than yours.'
        ],
        'Positive' => [
            'id' => 'Dia secerdas saudaranya.',
            'en' => 'She is as smart as her brother.'
        ]
    ];

    public $meeting11Questions = [
        1 => [
            'id' => 'Universitas itu menambah program penelitian, karena kebutuhan energi terbarukan semakin mendesak.',
            'en' => 'The university added research programs, because the need for renewable energy is increasingly urgent',
            'vocab' => ['Renewable energy' => 'Energi terbarukan', 'Increasingly' => 'Semakin', 'Urgent' => 'Mendesak', 'Research program' => 'Program penelitian'],
            'example' => 'I stayed home, for it was raining.'
        ],
        2 => [
            'id' => 'Kota itu membangun jalur sepeda, dan warganya mulai beralih dari kendaraan bermotor.',
            'en' => 'The city built bicycle lanes, and its residents began to switch from motor vehicles',
            'vocab' => ['Bicycle lane' => 'Jalur sepeda', 'Resident' => 'Warga', 'Switch' => 'Beralih', 'Motor vehicle' => 'Kendaraan bermotor'],
            'example' => 'She likes apples, and he likes oranges.'
        ],
        3 => [
            'id' => 'Pusat studi tersebut tidak memiliki cukup dana, maupun menerima dukungan dari organisasi internasional.',
            'en' => 'The study center does not have enough funds, nor does it receive support from international organizations',
            'vocab' => ['Fund' => 'Dana', 'Receive' => 'Menerima', 'Support' => 'Dukungan', 'International organization' => 'Organisasi internasional'],
            'example' => 'He doesn\'t eat meat, nor does he drink milk.'
        ],
        4 => [
            'id' => 'Para ilmuwan ingin menguji teori baru, tetapi alat laboratorium mereka belum memadai.',
            'en' => 'Scientists want to test new theories, but their laboratory equipment is not yet adequate',
            'vocab' => ['Test' => 'Menguji', 'Theory' => 'Teori', 'Equipment' => 'Peralatan', 'Adequate' => 'Memadai'],
            'example' => 'I want to go, but I am tired.'
        ],
        5 => [
            'id' => 'Mahasiswa bisa memilih fokus pada biologi laut, atau mereka dapat menekuni bidang energi berkelanjutan.',
            'en' => 'Students can choose to focus on marine biology, or they can pursue the field of sustainable energy',
            'vocab' => ['Focus' => 'Fokus', 'Marine biology' => 'Biologi laut', 'Pursue' => 'Menekuni', 'Sustainable energy' => 'Energi berkelanjutan'],
            'example' => 'You can study now, or you can sleep.'
        ],
        6 => [
            'id' => 'Tim peneliti bekerja siang malam, namun hasil yang mereka peroleh masih belum stabil.',
            'en' => 'The research team works day and night, yet the results they obtain are still unstable',
            'vocab' => ['Obtain' => 'Memperoleh', 'Result' => 'Hasil', 'Unstable' => 'Tidak stabil', 'Research team' => 'Tim peneliti'],
            'example' => 'It is sunny, yet it is cold.'
        ],
        7 => [
            'id' => 'Pemerintah berkomitmen mengurangi emisi, sehingga mereka menetapkan regulasi yang lebih ketat.',
            'en' => 'The government is committed to reducing emissions, so they established stricter regulations',
            'vocab' => ['Committed' => 'Berkomitmen', 'Reduce' => 'Mengurangi', 'Emission' => 'Emisi', 'Establish' => 'Menetapkan', 'Regulation' => 'Regulasi'],
            'example' => 'I was hungry, so I ate.'
        ],
        8 => [
            'id' => 'Festival budaya berlangsung meriah, karena masyarakat ingin melestarikan tradisi leluhur.',
            'en' => 'The cultural festival took place festively, because the community wants to preserve ancestral traditions',
            'vocab' => ['Take place' => 'Berlangsung', 'Festively' => 'Meriah', 'Preserve' => 'Melestarikan', 'Ancestral tradition' => 'Tradisi leluhur'],
            'example' => 'He is happy, because he won.'
        ],
        9 => [
            'id' => 'Bandara itu meningkatkan kapasitas penerbangan, dan infrastruktur pendukung juga diperbaiki.',
            'en' => 'The airport increased flight capacity, and supporting infrastructure was also improved',
            'vocab' => ['Increase' => 'Meningkatkan', 'Flight capacity' => 'Kapasitas penerbangan', 'Infrastructure' => 'Infrastruktur', 'Improve' => 'Diperbaiki'],
            'example' => 'I bought a pen, and I bought a book.'
        ],
        10 => [
            'id' => 'Perusahaan itu tidak mengurangi produksi plastik sekali pakai, maupun mencoba mencari alternatif ramah lingkungan.',
            'en' => 'The company does not reduce single-use plastic production, nor does it try to find environmentally friendly alternatives',
            'vocab' => ['Reduce' => 'Mengurangi', 'Single-use' => 'Sekali pakai', 'Production' => 'Produksi', 'Environmentally friendly' => 'Ramah lingkungan'],
            'example' => 'She didn\'t call, nor did she text.'
        ],
        11 => [
            'id' => 'Jalur kereta cepat telah dibuka, tetapi harga tiketnya masih dianggap terlalu tinggi.',
            'en' => 'The high-speed rail line has been opened, but the ticket price is still considered too high',
            'vocab' => ['High-speed rail' => 'Kereta cepat', 'Line' => 'Jalur', 'Ticket price' => 'Harga tiket', 'Consider' => 'Dianggap'],
            'example' => 'The car is fast, but it is expensive.'
        ],
        12 => [
            'id' => 'Wisatawan dapat mengunjungi taman nasional, atau mereka bisa mengikuti program konservasi komunitas.',
            'en' => 'Tourists can visit national parks, or they can join community conservation programs',
            'vocab' => ['Tourist' => 'Wisatawan', 'Visit' => 'Mengunjungi', 'National park' => 'Taman nasional', 'Join' => 'Mengikuti', 'Conservation' => 'Konservasi'],
            'example' => 'We can go to the beach, or we can go to the mountains.'
        ],
        13 => [
            'id' => 'Data ilmiah telah terkumpul selama bertahun-tahun, namun interpretasinya tetap menimbulkan perdebatan.',
            'en' => 'Scientific data has been collected for years, yet its interpretation still causes debate',
            'vocab' => ['Collect' => 'Terkumpul', 'Interpretation' => 'Interpretasi', 'Cause' => 'Menimbulkan', 'Debate' => 'Perdebatan'],
            'example' => 'He is rich, yet he is unhappy.'
        ],
        14 => [
            'id' => 'Program pendidikan digital berkembang pesat, sehingga akses pembelajaran menjadi lebih merata.',
            'en' => 'Digital education programs are developing rapidly, so learning access becomes more equitable',
            'vocab' => ['Develop' => 'Berkembang', 'Rapidly' => 'Pesat', 'Access' => 'Akses', 'Equitable' => 'Merata'],
            'example' => 'It was late, so we went home.'
        ],
        15 => [
            'id' => 'Desa itu menjaga hutan adatnya, karena mereka percaya hutan adalah sumber kehidupan.',
            'en' => 'The village protects its customary forest, because they believe the forest is the source of life',
            'vocab' => ['Protect' => 'Menjaga', 'Customary forest' => 'Hutan adat', 'Believe' => 'Percaya', 'Source of life' => 'Sumber kehidupan'],
            'example' => 'She smiled, because she was happy.'
        ]
    ];

    public $meeting11Paragraph = [
        'id' => 'Pendidikan digital semakin berkembang karena teknologi internet sudah menjangkau banyak daerah. Sekolah mulai menggunakan platform daring dan guru mendapatkan pelatihan khusus untuk mengajar secara interaktif. Tidak semua siswa memiliki perangkat memadai, maupun koneksi internet yang stabil di rumah mereka. Banyak universitas menawarkan kursus online, tetapi masih ada hambatan dalam penerapan di daerah terpencil. Mahasiswa bisa mengikuti kelas tatap muka atau memilih pembelajaran jarak jauh sesuai kebutuhan. Sistem ini memberi fleksibilitas besar, namun tantangan kesenjangan akses masih perlu diatasi. Transformasi pendidikan berbasis digital terus berjalan, sehingga kesempatan belajar menjadi lebih terbuka untuk semua kalangan.',
        'en' => 'Digital education is increasingly developing because internet technology has reached many areas. Schools are starting to use online platforms and teachers are getting special training to teach interactively. Not all students have adequate devices, nor do they have stable internet connections at their homes. Many universities offer online courses, but there are still obstacles in implementation in remote areas. Students can attend face-to-face classes or choose distance learning according to their needs. This system provides great flexibility, yet the challenge of access gaps still needs to be addressed. The digital-based education transformation continues, so learning opportunities become more open to all groups.',
        'vocab' => [
            'Digital education' => 'Pendidikan digital',
            'Increasingly' => 'Semakin',
            'Online platform' => 'Platform daring',
            'Interactively' => 'Secara interaktif',
            'Adequate' => 'Memadai',
            'Stable' => 'Stabil',
            'Obstacle' => 'Hambatan',
            'Remote areas' => 'Daerah terpencil',
            'Face-to-face' => 'Tatap muka',
            'Distance learning' => 'Pembelajaran jarak jauh',
            'Flexibility' => 'Fleksibilitas',
            'Access gap' => 'Kesenjangan akses',
            'Transformation' => 'Transformasi'
        ]
    ];

    public $meeting12Questions = [
        1 => [
            'id' => 'Masyarakat agraris berkembang pesat ketika sistem irigasi kuno mulai digunakan.',
            'en' => 'Agrarian societies developed rapidly when ancient irrigation systems began to be used',
            'type' => 'time',
            'conjunction' => 'when (ketika)',
            'example' => ['id' => 'Dia menelepon ketika saya sedang makan.', 'en' => 'He called when I was eating.'],
            'vocab' => [
                'Agrarian' => ['id' => 'Agraris', 'pos' => '(adj)'],
                'Society' => ['id' => 'Masyarakat', 'pos' => '(n)'],
                'Develop' => ['id' => 'Berkembang', 'pos' => '(v)'],
                'Rapidly' => ['id' => 'Pesat', 'pos' => '(adv)'],
                'Irrigation' => ['id' => 'Irigasi', 'pos' => '(n)'],
                'Ancient' => ['id' => 'Kuno', 'pos' => '(adj)']
            ]
        ],
        2 => [
            'id' => 'Kebudayaan Mesir meninggalkan piramida megah, sementara banyak peradaban kuno lain telah runtuh.',
            'en' => 'Egyptian culture left magnificent pyramids, while many other ancient civilizations have collapsed',
            'type' => 'time',
            'conjunction' => 'while (sementara)',
            'example' => ['id' => 'Saya belajar, sementara adik saya bermain.', 'en' => 'I study, while my brother plays.'],
            'vocab' => [
                'Culture' => ['id' => 'Kebudayaan', 'pos' => '(n)'],
                'Magnificent' => ['id' => 'Megah', 'pos' => '(adj)'],
                'Pyramid' => ['id' => 'Piramida', 'pos' => '(n)'],
                'Civilization' => ['id' => 'Peradaban', 'pos' => '(n)'],
                'Collapse' => ['id' => 'Runtuh', 'pos' => '(v)']
            ]
        ],
        3 => [
            'id' => 'Penyebaran ilmu pengetahuan terbatas, sebelum mesin cetak Gutenberg diperkenalkan di Eropa.',
            'en' => 'The spread of knowledge was limited, before the Gutenberg printing press was introduced in Europe',
            'type' => 'time',
            'conjunction' => 'before (sebelum)',
            'example' => ['id' => 'Cuci tangan sebelum kamu makan.', 'en' => 'Wash your hands before you eat.'],
            'vocab' => [
                'Spread' => ['id' => 'Penyebaran', 'pos' => '(n)'],
                'Knowledge' => ['id' => 'Ilmu pengetahuan', 'pos' => '(n)'],
                'Limited' => ['id' => 'Terbatas', 'pos' => '(adj)'],
                'Printing press' => ['id' => 'Mesin cetak', 'pos' => '(n)'],
                'Introduce' => ['id' => 'Diperkenalkan', 'pos' => '(v)']
            ]
        ],
        4 => [
            'id' => 'Pola kerja manusia berubah drastis setelah revolusi industri dimulai di Inggris.',
            'en' => 'Human work patterns changed drastically after the industrial revolution began in England',
            'type' => 'time',
            'conjunction' => 'after (setelah)',
            'example' => ['id' => 'Dia pergi setelah rapat selesai.', 'en' => 'He left after the meeting ended.'],
            'vocab' => [
                'Pattern' => ['id' => 'Pola', 'pos' => '(n)'],
                'Work' => ['id' => 'Kerja', 'pos' => '(n)'],
                'Change' => ['id' => 'Berubah', 'pos' => '(v)'],
                'Drastically' => ['id' => 'Drastis', 'pos' => '(adv)'],
                'Industrial revolution' => ['id' => 'Revolusi industri', 'pos' => '(n)']
            ]
        ],
        5 => [
            'id' => 'Pemahaman tentang tata surya semakin akurat sejak astronomi berkembang sebagai ilmu modern.',
            'en' => 'Understanding of the solar system became increasingly accurate since astronomy developed as a modern science',
            'type' => 'time',
            'conjunction' => 'since (sejak)',
            'example' => ['id' => 'Saya tinggal di sini sejak tahun 2020.', 'en' => 'I have lived here since 2020.'],
            'vocab' => [
                'Understanding' => ['id' => 'Pemahaman', 'pos' => '(n)'],
                'Solar system' => ['id' => 'Tata surya', 'pos' => '(n)'],
                'Accurate' => ['id' => 'Akurat', 'pos' => '(adj)'],
                'Astronomy' => ['id' => 'Astronomi', 'pos' => '(n)'],
                'Modern' => ['id' => 'Modern', 'pos' => '(adj)']
            ]
        ],
        6 => [
            'id' => 'Epidemi luas sering terjadi sampai vaksin berhasil ditemukan.',
            'en' => 'Widespread epidemics often occurred until vaccines were successfully discovered',
            'type' => 'time',
            'conjunction' => 'until (sampai)',
            'example' => ['id' => 'Tunggu sampai hujan berhenti.', 'en' => 'Wait until the rain stops.'],
            'vocab' => [
                'Epidemic' => ['id' => 'Epidemi', 'pos' => '(n)'],
                'Widespread' => ['id' => 'Luas', 'pos' => '(adj)'],
                'Occur' => ['id' => 'Terjadi', 'pos' => '(v)'],
                'Vaccine' => ['id' => 'Vaksin', 'pos' => '(n)'],
                'Discover' => ['id' => 'Ditemukan', 'pos' => '(v)']
            ]
        ],
        7 => [
            'id' => 'Produktivitas industri meningkat signifikan segera setelah listrik diperkenalkan di kota besar.',
            'en' => 'Industrial productivity increased significantly as soon as electricity was introduced in big cities',
            'type' => 'time',
            'conjunction' => 'as soon as (segera setelah)',
            'example' => ['id' => 'Hubungi saya segera setelah kamu tiba.', 'en' => 'Contact me as soon as you arrive.'],
            'vocab' => [
                'Productivity' => ['id' => 'Produktivitas', 'pos' => '(n)'],
                'Industrial' => ['id' => 'Industri', 'pos' => '(adj)'],
                'Increase' => ['id' => 'Meningkat', 'pos' => '(v)'],
                'Significantly' => ['id' => 'Signifikan', 'pos' => '(adv)'],
                'Electricity' => ['id' => 'Listrik', 'pos' => '(n)']
            ]
        ],
        8 => [
            'id' => 'Banyak masyarakat tinggal di sekitar gunung berapi karena tanah di sekitarnya sangat subur.',
            'en' => 'Many communities live around volcanoes because the surrounding soil is very fertile',
            'type' => 'cause',
            'conjunction' => 'because (karena)',
            'example' => ['id' => 'Dia tidak datang karena dia sakit.', 'en' => 'He did not come because he was sick.'],
            'vocab' => [
                'Community' => ['id' => 'Masyarakat', 'pos' => '(n)'],
                'Volcano' => ['id' => 'Gunung berapi', 'pos' => '(n)'],
                'Surrounding' => ['id' => 'Sekitar', 'pos' => '(adj)'],
                'Soil' => ['id' => 'Tanah', 'pos' => '(n)'],
                'Fertile' => ['id' => 'Subur', 'pos' => '(adj)']
            ]
        ],
        9 => [
            'id' => 'Teori heliosentris akhirnya diterima sebagai dasar ilmu astronomi, meskipun awalnya ditolak.',
            'en' => 'The heliocentric theory was finally accepted as the basis of astronomy, although it was initially rejected',
            'type' => 'contrast',
            'conjunction' => 'although (meskipun)',
            'example' => ['id' => 'Dia tetap bekerja meskipun dia lelah.', 'en' => 'He kept working although he was tired.'],
            'vocab' => [
                'Heliocentric' => ['id' => 'Heliosentris', 'pos' => '(adj)'],
                'Theory' => ['id' => 'Teori', 'pos' => '(n)'],
                'Accept' => ['id' => 'Diterima', 'pos' => '(v)'],
                'Basis' => ['id' => 'Dasar', 'pos' => '(n)'],
                'Reject' => ['id' => 'Ditolak', 'pos' => '(v)']
            ]
        ],
        10 => [
            'id' => 'Para penjelajah berhasil menyeberangi Samudra Pasifik, walaupun lautannya sangat luas.',
            'en' => 'Explorers successfully crossed the Pacific Ocean, although the ocean was very vast',
            'type' => 'contrast',
            'conjunction' => 'although (walaupun)',
            'example' => ['id' => 'Dia lulus walaupun jarang belajar.', 'en' => 'He passed although he rarely studied.'],
            'vocab' => [
                'Explorer' => ['id' => 'Penjelajah', 'pos' => '(n)'],
                'Successfully' => ['id' => 'Berhasil', 'pos' => '(adv)'],
                'Cross' => ['id' => 'Menyeberangi', 'pos' => '(v)'],
                'Ocean' => ['id' => 'Samudra', 'pos' => '(n)'],
                'Vast' => ['id' => 'Luas', 'pos' => '(adj)']
            ]
        ],
        11 => [
            'id' => 'Keanekaragaman hayati dapat bertahan jika hutan hujan tropis tetap terjaga.',
            'en' => 'Biodiversity can survive if tropical rainforests remain preserved',
            'type' => 'condition',
            'conjunction' => 'if (jika)',
            'example' => ['id' => 'Jika hujan, saya akan di rumah.', 'en' => 'If it rains, I will stay home.'],
            'vocab' => [
                'Biodiversity' => ['id' => 'Keanekaragaman hayati', 'pos' => '(n)'],
                'Survive' => ['id' => 'Bertahan', 'pos' => '(v)'],
                'Tropical' => ['id' => 'Tropis', 'pos' => '(adj)'],
                'Rainforest' => ['id' => 'Hutan hujan', 'pos' => '(n)'],
                'Preserve' => ['id' => 'Terjaga', 'pos' => '(v)']
            ]
        ],
        12 => [
            'id' => 'Populasi ikan menurun drastis kecuali jika konservasi laut dilakukan secara serius.',
            'en' => 'Fish populations decline drastically unless marine conservation is carried out seriously',
            'type' => 'condition',
            'conjunction' => 'unless (kecuali jika)',
            'example' => ['id' => 'Kamu akan gagal kecuali jika kamu belajar.', 'en' => 'You will fail unless you study.'],
            'vocab' => [
                'Population' => ['id' => 'Populasi', 'pos' => '(n)'],
                'Decline' => ['id' => 'Menurun', 'pos' => '(v)'],
                'Marine' => ['id' => 'Laut', 'pos' => '(adj)'],
                'Conservation' => ['id' => 'Konservasi', 'pos' => '(n)'],
                'Carry out' => ['id' => 'Dilakukan', 'pos' => '(v)']
            ]
        ],
        13 => [
            'id' => 'Teknologi satelit dikembangkan agar komunikasi antarnegara menjadi lebih mudah.',
            'en' => 'Satellite technology was developed so that communication between countries became easier',
            'type' => 'purpose',
            'conjunction' => 'so that (agar)',
            'example' => ['id' => 'Dia belajar keras agar bisa lulus.', 'en' => 'He studies hard so that he can pass.'],
            'vocab' => [
                'Satellite' => ['id' => 'Satelit', 'pos' => '(n)'],
                'Technology' => ['id' => 'Teknologi', 'pos' => '(n)'],
                'Develop' => ['id' => 'Dikembangkan', 'pos' => '(v)'],
                'Communication' => ['id' => 'Komunikasi', 'pos' => '(n)'],
                'Easier' => ['id' => 'Lebih mudah', 'pos' => '(adj)']
            ]
        ],
        14 => [
            'id' => 'Interaksi budaya meningkat pesat di mana pun jalur perdagangan internasional terbuka.',
            'en' => 'Cultural interaction increased rapidly wherever international trade routes opened',
            'type' => 'place',
            'conjunction' => 'wherever (di mana pun)',
            'example' => ['id' => 'Dia pergi ke mana pun dia mau.', 'en' => 'He goes wherever he wants.'],
            'vocab' => [
                'Interaction' => ['id' => 'Interaksi', 'pos' => '(n)'],
                'Cultural' => ['id' => 'Budaya', 'pos' => '(adj)'],
                'Trade route' => ['id' => 'Jalur perdagangan', 'pos' => '(n)'],
                'International' => ['id' => 'Internasional', 'pos' => '(adj)'],
                'Open' => ['id' => 'Terbuka', 'pos' => '(v)']
            ]
        ],
        15 => [
            'id' => 'Kota Petra terlihat seakan keluar dari tebing batu, seolah-olah arsitekturnya terukir secara alami.',
            'en' => 'The city of Petra looks as if it emerges from the rock cliffs, as if its architecture was carved naturally',
            'type' => 'manner',
            'conjunction' => 'as if (seolah-olah)',
            'example' => ['id' => 'Dia bertingkah seolah-olah dia raja.', 'en' => 'He acts as if he is a king.'],
            'vocab' => [
                'Emerge' => ['id' => 'Keluar', 'pos' => '(v)'],
                'Rock cliff' => ['id' => 'Tebing batu', 'pos' => '(n)'],
                'Architecture' => ['id' => 'Arsitektur', 'pos' => '(n)'],
                'Carve' => ['id' => 'Terukir', 'pos' => '(v)'],
                'Naturally' => ['id' => 'Secara alami', 'pos' => '(adv)']
            ]
        ]
    ];

    public $meeting12Paragraph = [
        'id' => 'Perkembangan teknologi terus mengalami percepatan sejak revolusi industri dimulai di Eropa. Inovasi dalam bidang komunikasi semakin penting ketika mesin telegraf diperkenalkan pada abad ke-19. Internet menjadi tonggak besar, karena ia menghubungkan miliaran manusia dalam waktu nyata. Penyebaran informasi menjadi semakin cepat, walaupun masih terdapat kesenjangan digital di beberapa wilayah. Penelitian ilmiah pun berkembang pesat, agar masyarakat dapat memperoleh solusi atas tantangan global yang semakin kompleks.',
        'en' => 'Technological development has continued to accelerate since the industrial revolution began in Europe. Innovation in the field of communication became increasingly important when the telegraph machine was introduced in the 19th century. The internet became a major milestone, because it connects billions of humans in real time. The spread of information became increasingly fast, although there is still a digital divide in some regions. Scientific research also developed rapidly, so that society can obtain solutions to increasingly complex global challenges.',
        'vocab' => [
            'Technological development' => 'Perkembangan teknologi',
            'Accelerate' => 'Mengalami percepatan',
            'Industrial revolution' => 'Revolusi industri',
            'Innovation' => 'Inovasi',
            'Communication' => 'Komunikasi',
            'Telegraph machine' => 'Mesin telegraf',
            'Milestone' => 'Tonggak besar',
            'Connect' => 'Menghubungkan',
            'Real time' => 'Waktu nyata',
            'Spread of information' => 'Penyebaran informasi',
            'Digital divide' => 'Kesenjangan digital',
            'Scientific research' => 'Penelitian ilmiah',
            'Solution' => 'Solusi',
            'Challenge' => 'Tantangan',
            'Complex' => 'Kompleks'
        ]
    ];

    public $meeting13Paragraph = [
        'id' => 'Kota-kota besar di dunia membangun sistem transportasi yang ramah lingkungan, yang dirancang untuk mengurangi polusi udara dan kemacetan lalu lintas. Para ilmuwan mengembangkan teknologi baru, yang mampu menyimpan energi terbarukan secara lebih efisien. Program pendidikan modern kini menekankan keterampilan abad ke-21, yang dibutuhkan oleh siswa untuk menghadapi perubahan global. Banyak negara mendukung kebijakan ekonomi hijau, yang diyakini dapat menciptakan lapangan kerja baru sekaligus menjaga kelestarian alam. Inovasi sosial, yang melibatkan partisipasi masyarakat, semakin dianggap penting dalam menyelesaikan tantangan perkotaan.',
        'en' => 'Major cities around the world are building environmentally friendly transportation systems, which are designed to reduce air pollution and traffic congestion. Scientists are developing new technologies, which are able to store renewable energy more efficiently. Modern education programs now emphasize 21st-century skills, which are needed by students to face global changes. Many countries support green economic policies, which are believed to create new jobs while preserving nature. Social innovation, which involves community participation, is increasingly considered important in solving urban challenges.',
        'vocab' => [
            'Environmentally friendly' => 'Ramah lingkungan',
            'Transportation system' => 'Sistem transportasi',
            'Reduce' => 'Mengurangi',
            'Air pollution' => 'Polusi udara',
            'Traffic congestion' => 'Kemacetan lalu lintas',
            'Renewable energy' => 'Energi terbarukan',
            'Efficiently' => 'Secara efisien',
            'Emphasize' => 'Menekankan',
            '21st-century skills' => 'Keterampilan abad ke-21',
            'Green economic policies' => 'Kebijakan ekonomi hijau',
            'Preserve nature' => 'Menjaga kelestarian alam',
            'Community participation' => 'Partisipasi masyarakat',
            'Urban challenges' => 'Tantangan perkotaan'
        ]
    ];

    public $meeting14Paragraph = [
        'id' => 'Para arkeolog baru-baru ini menggali situs kuno yang menunjukkan pola pemukiman awal di daerah pesisir. Di sekitar lokasi itu, mereka menemukan peralatan batu yang digunakan untuk berburu hewan kecil. Temuan ini kemudian dikaitkan dengan catatan sejarah, termasuk naskah kuno yang menjelaskan migrasi manusia dari satu pulau ke pulau lain. Di sisi lain, para peneliti juga mempelajari fosil hewan laut yang menandakan perubahan iklim ribuan tahun lalu. Semua data tersebut dikumpulkan ke dalam laporan ilmiah yang dipublikasikan oleh lembaga riset internasional. Selain itu, perpustakaan universitas menyimpan koleksi manuskrip yang berasal dari abad pertengahan dan memberikan konteks tambahan pada penelitian ini. Para mahasiswa membaca dokumen yang memuat deskripsi perjalanan para pedagang kuno, sementara dosen mereka menyiapkan analisis yang menyoroti hubungan perdagangan dengan perkembangan budaya lokal. Dengan demikian, proyek lintas disiplin ini menciptakan sebuah gambaran sejarah yang memperlihatkan interaksi manusia dengan lingkungannya secara lebih jelas.',
        'en' => 'Archaeologists recently excavated ancient sites that show early settlement patterns in coastal areas. Around that location, they found stone tools that were used to hunt small animals. These findings were then linked to historical records, including ancient manuscripts that explain human migration from one island to another. On the other hand, researchers also studied marine animal fossils that indicate climate change thousands of years ago. All of that data was collected into a scientific report that was published by an international research institution. In addition, the university library stores manuscript collections that originate from the Middle Ages and provide additional context to this research. Students read documents that contain descriptions of ancient merchant journeys, while their lecturers prepare analyses that highlight the relationship between trade and local cultural development. Thus, this interdisciplinary project creates a historical picture that shows human interaction with their environment more clearly.',
        'vocab' => [
            'Archaeologist' => 'Arkeolog',
            'Excavate' => 'Menggali',
            'Settlement pattern' => 'Pola pemukiman',
            'Coastal area' => 'Daerah pesisir',
            'Stone tool' => 'Peralatan batu',
            'Hunt' => 'Berburu',
            'Manuscript' => 'Naskah/manuskrip',
            'Migration' => 'Migrasi',
            'Fossil' => 'Fosil',
            'Climate change' => 'Perubahan iklim',
            'Scientific report' => 'Laporan ilmiah',
            'Research institution' => 'Lembaga riset',
            'Middle Ages' => 'Abad pertengahan',
            'Merchant' => 'Pedagang',
            'Analysis' => 'Analisis',
            'Trade' => 'Perdagangan',
            'Cultural development' => 'Perkembangan budaya',
            'Interdisciplinary' => 'Lintas disiplin',
            'Interaction' => 'Interaksi'
        ]
    ];

    public $meeting15Paragraph = [
        'id' => 'Sebuah organisasi internasional meluncurkan program konservasi, yang dampaknya dirasakan oleh komunitas lokal yang tanahnya terancam oleh deforestasi. Kota besar modern membangun taman ekologis, di mana masyarakat dapat belajar tentang pentingnya menjaga keanekaragaman hayati. Tahun 2015 adalah titik penting, ketika negara-negara menandatangani Perjanjian Paris untuk mengurangi emisi karbon. Universitas riset global mendirikan pusat inovasi, yang penelitiannya berfokus pada pengembangan energi terbarukan. Banyak ahli menjelaskan alasan, mengapa kesadaran lingkungan harus ditingkatkan melalui pendidikan sejak usia dini.',
        'en' => 'An international organization launched a conservation program, whose impact is felt by local communities whose land is threatened by deforestation. Modern big cities build ecological parks, where people can learn about the importance of maintaining biodiversity. The year 2015 was an important point, when countries signed the Paris Agreement to reduce carbon emissions. Global research universities establish innovation centers, whose research focuses on renewable energy development. Many experts explain the reason, why environmental awareness must be increased through education from an early age.',
        'vocab' => [
            'Conservation' => 'Konservasi',
            'Impact' => 'Dampak',
            'Deforestation' => 'Deforestasi',
            'Ecological park' => 'Taman ekologis',
            'Biodiversity' => 'Keanekaragaman hayati',
            'Paris Agreement' => 'Perjanjian Paris',
            'Carbon emission' => 'Emisi karbon',
            'Innovation center' => 'Pusat inovasi',
            'Renewable energy' => 'Energi terbarukan',
            'Environmental awareness' => 'Kesadaran lingkungan',
            'Early age' => 'Usia dini'
        ]
    ];

    public $meeting16Paragraph = [
        'id' => 'Dalam beberapa tahun terakhir, kesadaran publik tentang pelestarian lingkungan meningkat dengan lebih cepat dibandingkan dekade sebelumnya, terutama di wilayah perkotaan yang menghadapi tekanan pembangunan paling serius. Banyak komunitas lokal berusaha menciptakan ruang hijau yang setua sejarah kota itu sendiri, meskipun mereka sering terbatas oleh sumber daya yang lebih sedikit daripada organisasi besar. Di antara semua proyek konservasi yang telah diluncurkan, program restorasi mangrove adalah inisiatif yang paling penting bagi perlindungan ekosistem pesisir, karena menyediakan habitat yang banyak spesies laut sangat bergantung padanya sebagai sumber makanan. Di pusat penelitian lingkungan yang berlokasi di pesisir utara, para ilmuwan sedang mengembangkan metode pemantauan baru yang dapat membantu pemerintah membuat kebijakan berbasis data. Mereka bekerja sama dengan para nelayan lokal yang kehidupan keluarganya bergantung pada laut untuk memastikan bahwa hasil penelitian tersebut relevan dalam praktik. Banyak warga menghargai para ilmuwan yang kontribusinya sangat berarti bagi kesejahteraan masyarakat, terutama selama periode ketika kondisi iklim berubah dengan cepat dan memengaruhi ketersediaan sumber daya alam. Di kawasan pesisir di mana kerusakan ekosistem terjadi paling parah, pemerintah mulai membangun pusat edukasi publik untuk memberikan alasan mengapa masyarakat harus terlibat secara aktif dalam pelestarian lingkungan. Tempat itu kini menjadi ruang belajar terbuka di mana para siswa dan relawan bekerja bersama untuk menanam kembali vegetasi yang hilang dan mengamati pemulihan ekosistem dalam suasana kolaboratif.',
        'en' => 'In recent years, public awareness of environmental conservation has increased more rapidly than in previous decades, especially in urban areas facing the most serious development pressures. Many local communities are trying to create green spaces as old as the city\'s history itself, although they are often limited by fewer resources than large organizations. Among all the conservation projects that have been launched, the mangrove restoration program is the most important initiative for protecting coastal ecosystems, because it provides habitat that many marine species heavily depend on as a food source. At the environmental research center located on the northern coast, scientists are developing new monitoring methods that can help the government make data-based policies. They work together with local fishermen whose family livelihoods depend on the sea to ensure that the research results are relevant in practice. Many residents appreciate the scientists whose contributions are very meaningful to the community\'s welfare, especially during periods when climate conditions change rapidly and affect the availability of natural resources. In coastal areas where ecosystem damage occurs most severely, the government has started building public education centers to provide reasons why the community should be actively involved in environmental conservation. The place has now become an open learning space where students and volunteers work together to replant lost vegetation and observe ecosystem recovery in a collaborative atmosphere.',
        'vocab' => [
            'Public awareness' => 'Kesadaran publik',
            'Environmental conservation' => 'Pelestarian lingkungan',
            'Rapidly' => 'Dengan cepat',
            'Previous decade' => 'Dekade sebelumnya',
            'Urban area' => 'Wilayah perkotaan',
            'Development pressure' => 'Tekanan pembangunan',
            'Local community' => 'Komunitas lokal',
            'Green space' => 'Ruang hijau',
            'Limited' => 'Terbatas',
            'Resources' => 'Sumber daya',
            'Conservation project' => 'Proyek konservasi',
            'Mangrove restoration' => 'Restorasi mangrove',
            'Initiative' => 'Inisiatif',
            'Coastal ecosystem' => 'Ekosistem pesisir',
            'Habitat' => 'Habitat',
            'Marine species' => 'Spesies laut',
            'Depend on' => 'Bergantung pada',
            'Food source' => 'Sumber makanan',
            'Research center' => 'Pusat penelitian',
            'Monitoring method' => 'Metode pemantauan',
            'Data-based policy' => 'Kebijakan berbasis data',
            'Fisherman' => 'Nelayan',
            'Livelihood' => 'Kehidupan/mata pencarian',
            'Relevant' => 'Relevan',
            'Practice' => 'Praktik',
            'Appreciate' => 'Menghargai',
            'Contribution' => 'Kontribusi',
            'Welfare' => 'Kesejahteraan',
            'Climate condition' => 'Kondisi iklim',
            'Natural resources' => 'Sumber daya alam',
            'Ecosystem damage' => 'Kerusakan ekosistem',
            'Severely' => 'Parah',
            'Public education center' => 'Pusat edukasi publik',
            'Actively involved' => 'Terlibat secara aktif',
            'Open learning space' => 'Ruang belajar terbuka',
            'Volunteer' => 'Relawan',
            'Replant' => 'Menanam kembali',
            'Vegetation' => 'Vegetasi',
            'Ecosystem recovery' => 'Pemulihan ekosistem',
            'Collaborative atmosphere' => 'Suasana kolaboratif'
        ]
    ];

    public $meeting17Questions = [
        1 => [
            'id' => 'NASA masih belum membuktikan secara visual apakah (whether) Mars mengandung air saat ini.',
            'en' => 'NASA has not yet visually proven whether Mars contains water at present',
            'example' => ['id' => 'Para ilmuwan belum membuktikan secara eksperimental apakah Jupiter memiliki inti padat.', 'en' => 'Scientists have not yet experimentally proven whether Jupiter has a solid core.'],
            'vocab' => [
                'Prove' => ['id' => 'Membuktikan', 'pos' => '(v)'],
                'Visually' => ['id' => 'Secara visual', 'pos' => '(adv)'],
                'Contain' => ['id' => 'Mengandung', 'pos' => '(v)'],
                'Water' => ['id' => 'Air', 'pos' => '(n)'],
                'At present' => ['id' => 'Saat ini', 'pos' => '(adv)']
            ]
        ],
        2 => [
            'id' => 'Kita tidak bisa mengasumsikan bahwa suhu Bumi akan bisa menurun secara sendirinya.',
            'en' => 'We cannot assume that Earth\'s temperature will decrease on its own',
            'example' => ['id' => 'Mereka tidak bisa mengasumsikan bahwa populasi hewan akan meningkat secara alami.', 'en' => 'They cannot assume that animal populations will increase naturally.'],
            'vocab' => [
                'Assume' => ['id' => 'Mengasumsikan', 'pos' => '(v)'],
                'Temperature' => ['id' => 'Suhu', 'pos' => '(n)'],
                'Decrease' => ['id' => 'Menurun', 'pos' => '(v)'],
                'On its own' => ['id' => 'Secara sendirinya', 'pos' => '(adv)']
            ]
        ],
        3 => [
            'id' => 'Banyak orang bertanya-tanya apakah kehidupan ada di planet lain.',
            'en' => 'Many people wonder whether life exists on other planets',
            'example' => ['id' => 'Beberapa peneliti bertanya-tanya apakah air ada di bulan Saturnus.', 'en' => 'Some researchers wonder whether water exists on Saturn\'s moons.'],
            'vocab' => [
                'Wonder' => ['id' => 'Bertanya-tanya', 'pos' => '(v)'],
                'Life' => ['id' => 'Kehidupan', 'pos' => '(n)'],
                'Exist' => ['id' => 'Ada', 'pos' => '(v)'],
                'Planet' => ['id' => 'Planet', 'pos' => '(n)']
            ]
        ],
        4 => [
            'id' => 'Jika sebuah populasi dari sebuah spesies menjadi terisolasi, mereka berpisah dalam apa yang disebut spesiasi.',
            'en' => 'If a population of a species becomes isolated, they separate in what is called speciation',
            'example' => ['id' => 'Ketika sebuah kelompok dari sebuah organisme menjadi terpisah, mereka berkembang dalam apa yang disebut adaptasi.', 'en' => 'When a group of an organism becomes separated, they develop in what is called adaptation.'],
            'vocab' => [
                'Population' => ['id' => 'Populasi', 'pos' => '(n)'],
                'Species' => ['id' => 'Spesies', 'pos' => '(n)'],
                'Isolated' => ['id' => 'Terisolasi', 'pos' => '(adj)'],
                'Separate' => ['id' => 'Berpisah', 'pos' => '(v)'],
                'Speciation' => ['id' => 'Spesiasi', 'pos' => '(n)']
            ]
        ],
        5 => [
            'id' => 'Negara mana yang akan menjadi tujuan migrasi adalah suatu fenomena yang masih diperdebatkan.',
            'en' => 'Which country will become a migration destination is a phenomenon that is still debated',
            'example' => ['id' => 'Pulau mana yang akan menjadi habitat terakhir adalah suatu misteri yang masih dipelajari.', 'en' => 'Which island will become the last habitat is a mystery that is still being studied.'],
            'vocab' => [
                'Country' => ['id' => 'Negara', 'pos' => '(n)'],
                'Destination' => ['id' => 'Tujuan', 'pos' => '(n)'],
                'Migration' => ['id' => 'Migrasi', 'pos' => '(n)'],
                'Phenomenon' => ['id' => 'Fenomena', 'pos' => '(n)'],
                'Debated' => ['id' => 'Diperdebatkan', 'pos' => '(v)']
            ]
        ],
        6 => [
            'id' => 'Bagaimana orang mesir kuno membangun piramida giza masih menjadi perdebatan dari para ahli sejarah.',
            'en' => 'How the ancient Egyptians built the Giza pyramids is still a matter of debate among historians',
            'example' => ['id' => 'Bagaimana suku Maya kuno membangun kota Tikal masih menjadi perdebatan dari para ahli arkeologi.', 'en' => 'How the ancient Maya built the city of Tikal is still a matter of debate among archaeologists.'],
            'vocab' => [
                'Ancient' => ['id' => 'Kuno', 'pos' => '(adj)'],
                'Egyptian' => ['id' => 'Mesir', 'pos' => '(n)'],
                'Build' => ['id' => 'Membangun', 'pos' => '(v)'],
                'Pyramid' => ['id' => 'Piramida', 'pos' => '(n)'],
                'Debate' => ['id' => 'Perdebatan', 'pos' => '(n)'],
                'Historian' => ['id' => 'Ahli sejarah', 'pos' => '(n)']
            ]
        ],
        7 => [
            'id' => 'Bahwa manusia tidak menyebabkan kepunahan banyak spesies adalah peremehan.',
            'en' => 'That humans do not cause the extinction of many species is an understatement',
            'example' => ['id' => 'Bahwa teknologi tidak menyebabkan polusi udara adalah kesalahpahaman.', 'en' => 'That technology does not cause air pollution is a misconception.'],
            'vocab' => [
                'Cause' => ['id' => 'Menyebabkan', 'pos' => '(v)'],
                'Extinction' => ['id' => 'Kepunahan', 'pos' => '(n)'],
                'Species' => ['id' => 'Spesies', 'pos' => '(n)'],
                'Understatement' => ['id' => 'Peremehan', 'pos' => '(n)']
            ]
        ],
        8 => [
            'id' => 'Kita mengelompokkan makhluk hidup melalui apa yang disebut taxonomy.',
            'en' => 'We classify living things through what is called taxonomy',
            'example' => ['id' => 'Kita mengorganisir tumbuhan melalui apa yang disebut botani.', 'en' => 'We organize plants through what is called botany.'],
            'vocab' => [
                'Classify' => ['id' => 'Mengelompokkan', 'pos' => '(v)'],
                'Living things' => ['id' => 'Makhluk hidup', 'pos' => '(n)'],
                'Taxonomy' => ['id' => 'Taxonomy', 'pos' => '(n)']
            ]
        ],
        9 => [
            'id' => 'Faktor-faktor yang menentukan bagaimana manusia berinteraksi dengan lingkungan adalah komplek.',
            'en' => 'The factors that determine how humans interact with the environment are complex',
            'example' => ['id' => 'Elemen-elemen yang menentukan bagaimana organisme beradaptasi dengan habitat adalah beragam.', 'en' => 'The elements that determine how organisms adapt to habitats are diverse.'],
            'vocab' => [
                'Factor' => ['id' => 'Faktor', 'pos' => '(n)'],
                'Determine' => ['id' => 'Menentukan', 'pos' => '(v)'],
                'Interact' => ['id' => 'Berinteraksi', 'pos' => '(v)'],
                'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
                'Complex' => ['id' => 'Komplek', 'pos' => '(adj)']
            ]
        ],
        10 => [
            'id' => 'Teori Perdagangan Baru menjelaskan mengapa banyak perdagangan dari ekonomi maju terdiri dari komoditas terbedakan yang dihasilkan dari kondisi kompetisi yang tidak sempurna.',
            'en' => 'New Trade Theory explains why much trade from advanced economies consists of differentiated commodities produced from imperfect competition conditions',
            'example' => ['id' => 'Teori Ekonomi Klasik menjelaskan mengapa banyak transaksi dari pasar bebas terdiri dari barang standar yang dihasilkan dari kondisi persaingan yang sempurna.', 'en' => 'Classical Economic Theory explains why many transactions from free markets consist of standard goods produced from perfect competition conditions.'],
            'vocab' => [
                'Trade' => ['id' => 'Perdagangan', 'pos' => '(n)'],
                'Advanced economy' => ['id' => 'Ekonomi maju', 'pos' => '(n)'],
                'Consist of' => ['id' => 'Terdiri dari', 'pos' => '(v)'],
                'Commodity' => ['id' => 'Komoditas', 'pos' => '(n)'],
                'Differentiated' => ['id' => 'Terbedakan', 'pos' => '(adj)'],
                'Competition' => ['id' => 'Kompetisi', 'pos' => '(n)']
            ]
        ],
        11 => [
            'id' => 'Kapan manusia mulai menghuni Australia masih belum dapat secara akurat ditentukan.',
            'en' => 'When humans began to inhabit Australia has not yet been accurately determined',
            'example' => ['id' => 'Kapan dinosaurus mulai menghuni Amerika masih belum dapat secara pasti ditentukan.', 'en' => 'When dinosaurs began to inhabit America has not yet been certainly determined.'],
            'vocab' => [
                'Inhabit' => ['id' => 'Menghuni', 'pos' => '(v)'],
                'Accurately' => ['id' => 'Secara akurat', 'pos' => '(adv)'],
                'Determined' => ['id' => 'Ditentukan', 'pos' => '(v)']
            ]
        ],
        12 => [
            'id' => 'Di Afrika Barat, dimana sedimen dibuang menyebabkan kerusakan yang signifikan terhadap terumbu karang di pesisir Kenya.',
            'en' => 'In West Africa, where sediment is dumped causes significant damage to coral reefs off the coast of Kenya',
            'example' => ['id' => 'Di Asia Tenggara, dimana limbah dibuang menyebabkan kerusakan yang serius terhadap ekosistem sungai di pesisir Thailand.', 'en' => 'In Southeast Asia, where waste is dumped causes serious damage to river ecosystems off the coast of Thailand.'],
            'vocab' => [
                'Sediment' => ['id' => 'Sedimen', 'pos' => '(n)'],
                'Dump' => ['id' => 'Dibuang', 'pos' => '(v)'],
                'Damage' => ['id' => 'Kerusakan', 'pos' => '(n)'],
                'Significant' => ['id' => 'Signifikan', 'pos' => '(adj)'],
                'Coral reef' => ['id' => 'Terumbu karang', 'pos' => '(n)'],
                'Coast' => ['id' => 'Pesisir', 'pos' => '(n)']
            ]
        ],
        13 => [
            'id' => 'Apa yang mungkin bernilai bagi kita di masa depan adalah hampir mustahil untuk diprediksi.',
            'en' => 'What might be valuable to us in the future is almost impossible to predict',
            'example' => ['id' => 'Apa yang mungkin berguna bagi kita di masa lalu adalah hampir mustahil untuk diingat.', 'en' => 'What might be useful to us in the past is almost impossible to remember.'],
            'vocab' => [
                'Valuable' => ['id' => 'Bernilai', 'pos' => '(adj)'],
                'Future' => ['id' => 'Masa depan', 'pos' => '(n)'],
                'Impossible' => ['id' => 'Mustahil', 'pos' => '(adj)'],
                'Predict' => ['id' => 'Diprediksi', 'pos' => '(v)']
            ]
        ],
        14 => [
            'id' => 'Beberapa merasa bahwa pemerintah dan perusahaan memiliki pengaruh yang lebih besar daripada individu terhadap keanekaragaman hayati lokal dan global.',
            'en' => 'Some feel that governments and companies have a greater influence than individuals on local and global biodiversity',
            'example' => ['id' => 'Beberapa berpendapat bahwa universitas dan institusi memiliki dampak yang lebih besar daripada individu terhadap inovasi teknologi lokal dan global.', 'en' => 'Some argue that universities and institutions have a greater impact than individuals on local and global technological innovation.'],
            'vocab' => [
                'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                'Company' => ['id' => 'Perusahaan', 'pos' => '(n)'],
                'Influence' => ['id' => 'Pengaruh', 'pos' => '(n)'],
                'Individual' => ['id' => 'Individu', 'pos' => '(n)'],
                'Biodiversity' => ['id' => 'Keanekaragaman hayati', 'pos' => '(n)']
            ]
        ],
        15 => [
            'id' => 'Ini masih belum jelas apakah spesies burung Carolina parakeet bersarang di musim semi atau musim panas.',
            'en' => 'It is still unclear whether the Carolina parakeet bird species nested in spring or summer',
            'example' => ['id' => 'Ini masih belum jelas apakah spesies ikan Coelacanth berkembang biak di musim hujan atau musim kemarau.', 'en' => 'It is still unclear whether the Coelacanth fish species reproduces in rainy season or dry season.'],
            'vocab' => [
                'Unclear' => ['id' => 'Belum jelas', 'pos' => '(adj)'],
                'Bird species' => ['id' => 'Spesies burung', 'pos' => '(n)'],
                'Nest' => ['id' => 'Bersarang', 'pos' => '(v)'],
                'Spring' => ['id' => 'Musim semi', 'pos' => '(n)'],
                'Summer' => ['id' => 'Musim panas', 'pos' => '(n)']
            ]
        ],
        16 => [
            'id' => 'Apa yang terjadi di pada suku Anasazi sebelum abad 12 menjadi bahan perdebatan banyak ahli.',
            'en' => 'What happened to the Anasazi tribe before the 12th century is a matter of debate among many experts',
            'example' => ['id' => 'Apa yang terjadi pada suku Inca sebelum abad 16 menjadi bahan perdebatan banyak sejarawan.', 'en' => 'What happened to the Inca tribe before the 16th century is a matter of debate among many historians.'],
            'vocab' => [
                'Happen' => ['id' => 'Terjadi', 'pos' => '(v)'],
                'Tribe' => ['id' => 'Suku', 'pos' => '(n)'],
                'Century' => ['id' => 'Abad', 'pos' => '(n)'],
                'Matter of debate' => ['id' => 'Bahan perdebatan', 'pos' => '(n)'],
                'Expert' => ['id' => 'Ahli', 'pos' => '(n)']
            ]
        ],
        17 => [
            'id' => 'Apa yang ahli ekonomi acu sebagai sebuah pilihan marginal adalah pilihan untuk memproduksi atau mengkonsumsi jasa atau barang selanjutnya.',
            'en' => 'What economists refer to as a marginal choice is the choice to produce or consume the next service or good',
            'example' => ['id' => 'Apa yang ahli biologi acu sebagai sebuah mutasi genetik adalah perubahan untuk menghasilkan atau mengadaptasi sifat atau karakteristik selanjutnya.', 'en' => 'What biologists refer to as a genetic mutation is the change to produce or adapt the next trait or characteristic.'],
            'vocab' => [
                'Economist' => ['id' => 'Ahli ekonomi', 'pos' => '(n)'],
                'Refer to' => ['id' => 'Acu sebagai', 'pos' => '(v)'],
                'Marginal choice' => ['id' => 'Pilihan marginal', 'pos' => '(n)'],
                'Produce' => ['id' => 'Memproduksi', 'pos' => '(v)'],
                'Consume' => ['id' => 'Mengkonsumsi', 'pos' => '(v)'],
                'Service' => ['id' => 'Jasa', 'pos' => '(n)'],
                'Good' => ['id' => 'Barang', 'pos' => '(n)']
            ]
        ],
        18 => [
            'id' => 'Apa yang ratu lebah konsumsi berbeda dengan apa yang lebah pekerja konsumsi.',
            'en' => 'What the queen bee consumes differs from what worker bees consume',
            'example' => ['id' => 'Apa yang burung hantu konsumsi berbeda dengan apa yang burung elang konsumsi.', 'en' => 'What owls consume differs from what eagles consume.'],
            'vocab' => [
                'Queen bee' => ['id' => 'Ratu lebah', 'pos' => '(n)'],
                'Consume' => ['id' => 'Konsumsi', 'pos' => '(v)'],
                'Differ' => ['id' => 'Berbeda', 'pos' => '(v)'],
                'Worker bee' => ['id' => 'Lebah pekerja', 'pos' => '(n)']
            ]
        ]
    ];

    public $meeting17Paragraph = [
        'id' => 'Banyak orang masih memperdebatkan apakah teknologi nuklir lebih membawa manfaat atau bahaya bagi umat manusia. Beberapa ilmuwan percaya bahwa energi nuklir adalah solusi terbaik untuk krisis energi global, karena efisiensinya yang tinggi dan emisi karbon yang rendah. Namun, masyarakat umum sering kali mengkhawatirkan apa yang bisa terjadi jika terjadi kebocoran reaktor atau penyalahgunaan bahan radioaktif. Fakta bahwa beberapa negara menggunakan teknologi ini untuk membuat senjata pemusnah massal semakin memperkuat rasa takut itu. Oleh karena itu, penting untuk mempertimbangkan bagaimana teknologi ini digunakan dan siapa yang mengendalikannya sebelum memutuskan arah pengembangannya di masa depan.',
        'en' => 'Many people still debate whether nuclear technology brings more benefits or harm to humanity. Some scientists believe that nuclear energy is the best solution to the global energy crisis, because of its high efficiency and low carbon emissions. However, the general public often worries about what could happen if a reactor leak or misuse of radioactive materials occurs. The fact that some countries use this technology to make weapons of mass destruction further reinforces that fear. Therefore, it is important to consider how this technology is used and who controls it before deciding its development direction in the future.',
        'vocab' => [
            'Debate' => ['id' => 'Memperdebatkan', 'pos' => '(v)'],
            'Nuclear technology' => ['id' => 'Teknologi nuklir', 'pos' => '(n)'],
            'Benefit' => ['id' => 'Manfaat', 'pos' => '(n)'],
            'Harm' => ['id' => 'Bahaya', 'pos' => '(n)'],
            'Humanity' => ['id' => 'Umat manusia', 'pos' => '(n)'],
            'Energy crisis' => ['id' => 'Krisis energi', 'pos' => '(n)'],
            'Efficiency' => ['id' => 'Efisiensi', 'pos' => '(n)'],
            'Carbon emission' => ['id' => 'Emisi karbon', 'pos' => '(n)'],
            'Worry' => ['id' => 'Mengkhawatirkan', 'pos' => '(v)'],
            'Reactor leak' => ['id' => 'Kebocoran reaktor', 'pos' => '(n)'],
            'Radioactive material' => ['id' => 'Bahan radioaktif', 'pos' => '(n)'],
            'Weapon of mass destruction' => ['id' => 'Senjata pemusnah massal', 'pos' => '(n)'],
            'Reinforce' => ['id' => 'Memperkuat', 'pos' => '(v)'],
            'Consider' => ['id' => 'Mempertimbangkan', 'pos' => '(v)'],
            'Control' => ['id' => 'Mengendalikan', 'pos' => '(v)']
        ]
    ];

    public $meeting18Questions = [
        // Reducing - Active
        1 => [
            'id' => 'Archaebacteria adalah kelompok bakteri yang termasuk prokariot yang tinggal di lingkungan ekstrim seperti gunung berapi atau danau asin.',
            'en' => 'Archaebacteria is a bacteria group including prokaryotic bacteria living in extreme environments such as volcanoes or salt water lakes',
            'example' => ['id' => 'Plankton adalah kelompok organisme yang termasuk autotrof yang melayang di perairan dangkal seperti muara sungai atau teluk terlindung.', 'en' => 'Plankton is an organism group including autotrophs floating in shallow waters such as river estuaries or sheltered bays.'],
            'vocab' => [
                'Bacteria group' => ['id' => 'Kelompok bakteri', 'pos' => '(n)'],
                'Include' => ['id' => 'Termasuk', 'pos' => '(v)'],
                'Extreme environment' => ['id' => 'Lingkungan ekstrim', 'pos' => '(n)'],
                'Volcano' => ['id' => 'Gunung berapi', 'pos' => '(n)'],
                'Salt water lake' => ['id' => 'Danau asin', 'pos' => '(n)']
            ]
        ],
        2 => [
            'id' => 'Selain memiliki kombinasi yang unik dari gen, spesies mungkin juga memiliki variasi dalam bentuk dan komposisi dari kromosom yang membawa gen.',
            'en' => 'Besides having a unique combination of genes, species may also have variations in the form and composition of chromosomes carrying genes',
            'example' => ['id' => 'Selain memiliki desain yang inovatif dari arsitektur, gedung mungkin juga memiliki keunikan dalam gaya dan material dari fondasi yang menopang struktur.', 'en' => 'Besides having an innovative design of architecture, buildings may also have uniqueness in the style and material of foundations supporting structures.'],
            'vocab' => [
                'Unique combination' => ['id' => 'Kombinasi unik', 'pos' => '(n)'],
                'Gene' => ['id' => 'Gen', 'pos' => '(n)'],
                'Variation' => ['id' => 'Variasi', 'pos' => '(n)'],
                'Composition' => ['id' => 'Komposisi', 'pos' => '(n)'],
                'Chromosome' => ['id' => 'Kromosom', 'pos' => '(n)'],
                'Carry' => ['id' => 'Membawa', 'pos' => '(v)']
            ]
        ],
        3 => [
            'id' => 'Dam-dam yang dibangun untuk pengendali banjir bisa memberikan orang-orang yang tinggal di hilir dari dam sebuah rasa keamanan palsu.',
            'en' => 'Dams built for flood control can give people living downstream from the dam a false sense of security',
            'example' => ['id' => 'Jalan-jalan yang dibangun untuk transportasi umum bisa memberikan pengendara-pengendara yang berkendara di jalur dari jalan sebuah akses mobilitas lancar.', 'en' => 'Roads built for public transportation can give drivers driving in the lanes from the road an access to smooth mobility.'],
            'vocab' => [
                'Flood control' => ['id' => 'Pengendali banjir', 'pos' => '(n)'],
                'Downstream' => ['id' => 'Hilir', 'pos' => '(n)'],
                'False sense' => ['id' => 'Rasa palsu', 'pos' => '(n)'],
                'Security' => ['id' => 'Keamanan', 'pos' => '(n)']
            ]
        ],
        4 => [
            'id' => 'Charles Darwin adalah ilmuwan yang mengembangkan teori evolusi melalui seleksi alam.',
            'en' => 'Charles Darwin is a scientist developing the theory of evolution through natural selection',
            'example' => ['id' => 'Marie Curie adalah peneliti yang menemukan unsur radium melalui eksperimen kimia.', 'en' => 'Marie Curie is a researcher discovering the element radium through chemical experiments.'],
            'vocab' => [
                'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
                'Develop' => ['id' => 'Mengembangkan', 'pos' => '(v)'],
                'Theory of evolution' => ['id' => 'Teori evolusi', 'pos' => '(n)'],
                'Natural selection' => ['id' => 'Seleksi alam', 'pos' => '(n)']
            ]
        ],
        5 => [
            'id' => 'Pemanasan global yang disebabkan oleh meningkatnya jumlah karbon di atmosfer merupakan akibat langsung dari revolusi industri.',
            'en' => 'Global warming caused by increasing amounts of carbon in the atmosphere is a direct result of the industrial revolution',
            'example' => ['id' => 'Urbanisasi yang disebabkan oleh meningkatnya migrasi penduduk di kota merupakan tantangan langsung terhadap infrastruktur publik.', 'en' => 'Urbanization caused by increasing population migration in cities is a direct challenge to public infrastructure.'],
            'vocab' => [
                'Global warming' => ['id' => 'Pemanasan global', 'pos' => '(n)'],
                'Cause' => ['id' => 'Menyebabkan', 'pos' => '(v)'],
                'Increase' => ['id' => 'Meningkat', 'pos' => '(v)'],
                'Amount' => ['id' => 'Jumlah', 'pos' => '(n)'],
                'Atmosphere' => ['id' => 'Atmosfer', 'pos' => '(n)'],
                'Direct result' => ['id' => 'Akibat langsung', 'pos' => '(n)'],
                'Industrial revolution' => ['id' => 'Revolusi industri', 'pos' => '(n)']
            ]
        ],
        6 => [
            'id' => 'Revolusi Industri adalah periode sejarah yang mengubah struktur ekonomi dan sosial di Eropa.',
            'en' => 'The Industrial Revolution is a historical period changing economic and social structures in Europe',
            'example' => ['id' => 'Pencerahan adalah zaman intelektual yang mengubah pemikiran politik dan ilmiah di Prancis.', 'en' => 'The Enlightenment is an intellectual age changing political and scientific thinking in France.'],
            'vocab' => [
                'Historical period' => ['id' => 'Periode sejarah', 'pos' => '(n)'],
                'Change' => ['id' => 'Mengubah', 'pos' => '(v)'],
                'Economic structure' => ['id' => 'Struktur ekonomi', 'pos' => '(n)'],
                'Social structure' => ['id' => 'Struktur sosial', 'pos' => '(n)']
            ]
        ],
        7 => [
            'id' => 'Pertumbuhan per capita Cina yang berata-rata 8.7 percent pada tahun 1990-2005 adalah salah satu pertumbuhan ekonomi tercepat di Dunia.',
            'en' => 'China\'s per capita growth averaging 8.7 percent in 1990-2005 is one of the fastest economic growths in the World',
            'example' => ['id' => 'Investasi per kapita Singapura yang berata-rata 7.5 persen pada tahun 2015-2025 adalah salah satu pertumbuhan modal terkuat di dunia.', 'en' => 'Singapore\'s per capita investment averaging 7.5 percent in 2015-2025 is one of the strongest capital growths in the world.'],
            'vocab' => [
                'Per capita growth' => ['id' => 'Pertumbuhan per kapita', 'pos' => '(n)'],
                'Average' => ['id' => 'Berata-rata', 'pos' => '(v)'],
                'Fastest' => ['id' => 'Tercepat', 'pos' => '(adj)'],
                'Economic growth' => ['id' => 'Pertumbuhan ekonomi', 'pos' => '(n)']
            ]
        ],
        8 => [
            'id' => 'Ekosistem hutan hujan yang telah menjadi sumber oxygen dunia sedang terancam oleh penebangan pohon liar.',
            'en' => 'Rainforest ecosystems having become the world\'s oxygen source are being threatened by illegal logging',
            'example' => ['id' => 'Ekosistem padang rumput yang telah menjadi tempat hidup mamalia besar sedang terancam oleh perubahan iklim ekstrem.', 'en' => 'Grassland ecosystems having become large mammal habitats are being threatened by extreme climate change.'],
            'vocab' => [
                'Rainforest ecosystem' => ['id' => 'Ekosistem hutan hujan', 'pos' => '(n)'],
                'Oxygen source' => ['id' => 'Sumber oksigen', 'pos' => '(n)'],
                'Threaten' => ['id' => 'Mengancam', 'pos' => '(v)'],
                'Illegal logging' => ['id' => 'Penebangan liar', 'pos' => '(n)']
            ]
        ],
        9 => [
            'id' => 'Banyak sumber air di dataran tinggi berasal dari glasier yang mencair di musim semi.',
            'en' => 'Many water sources in the highlands come from glaciers melting in spring',
            'example' => ['id' => 'Banyak cadangan minyak di laut dalam berasal dari endapan organik yang mengeras di era purba.', 'en' => 'Many oil reserves in the deep sea come from organic sediments hardening in ancient eras.'],
            'vocab' => [
                'Water source' => ['id' => 'Sumber air', 'pos' => '(n)'],
                'Highlands' => ['id' => 'Dataran tinggi', 'pos' => '(n)'],
                'Glacier' => ['id' => 'Glasier', 'pos' => '(n)'],
                'Melt' => ['id' => 'Mencair', 'pos' => '(v)'],
                'Spring' => ['id' => 'Musim semi', 'pos' => '(n)']
            ]
        ],
        10 => [
            'id' => 'Berbeda dengan glasiasi Phanerozoic, glasisasi Hirnantian bertahan kurang dari 1 juta tahun dengan kondisi glasiasi penuh yang bertahan 200.000 tahun.',
            'en' => 'Unlike Phanerozoic glaciation, Hirnantian glaciation lasted less than 1 million years with full glaciation conditions lasting 200,000 years',
            'example' => ['id' => 'Berbeda dengan dinasti Ming, dinasti Qing berkuasa lebih dari 250 tahun dengan sistem pemerintahan monarki yang berlangsung 200 tahun.', 'en' => 'Unlike the Ming dynasty, the Qing dynasty ruled more than 250 years with a monarchy government system lasting 200 years.'],
            'vocab' => [
                'Unlike' => ['id' => 'Berbeda dengan', 'pos' => '(prep)'],
                'Glaciation' => ['id' => 'Glasiasi', 'pos' => '(n)'],
                'Last' => ['id' => 'Bertahan', 'pos' => '(v)'],
                'Condition' => ['id' => 'Kondisi', 'pos' => '(n)']
            ]
        ],
        
        // Reducing - Passive
        11 => [
            'id' => 'Penggunaan pestisida sintetis meningkatkan ketergantungan kita pada pestisida dalam proses yang disebut "pesticide treadmill".',
            'en' => 'The use of synthetic pesticide improves our dependency on pesticide in a process called "pesticide treadmill"',
            'example' => ['id' => 'Penggunaan energi terbarukan meningkatkan keberlanjutan kita pada lingkungan dalam pendekatan yang disebut "green economy".', 'en' => 'The use of renewable energy improves our sustainability on the environment in an approach called "green economy".'],
            'vocab' => [
                'Synthetic pesticide' => ['id' => 'Pestisida sintetis', 'pos' => '(n)'],
                'Improve' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
                'Dependency' => ['id' => 'Ketergantungan', 'pos' => '(n)'],
                'Process' => ['id' => 'Proses', 'pos' => '(n)']
            ]
        ],
        12 => [
            'id' => 'Iklim juga mempengaruhi aktivitas manusia, seperti pertanian yang dipengaruhi oleh lama dari musim tanam, jumlah, dan distribusi dari hutan hujan dan temperatur.',
            'en' => 'Climate also affects human activities, such as agriculture affected by the length of the growing season, amount, and distribution of rainfall and temperature',
            'example' => ['id' => 'Teknologi juga mempengaruhi gaya hidup modern, seperti komunikasi yang dipengaruhi oleh kecepatan dari jaringan internet, bandwidth, dan distribusi dari sinyal dan konektivitas.', 'en' => 'Technology also affects modern lifestyles, such as communication affected by the speed of internet networks, bandwidth, and distribution of signals and connectivity.'],
            'vocab' => [
                'Climate' => ['id' => 'Iklim', 'pos' => '(n)'],
                'Affect' => ['id' => 'Mempengaruhi', 'pos' => '(v)'],
                'Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)'],
                'Growing season' => ['id' => 'Musim tanam', 'pos' => '(n)'],
                'Rainfall' => ['id' => 'Curah hujan', 'pos' => '(n)'],
                'Temperature' => ['id' => 'Temperatur', 'pos' => '(n)']
            ]
        ],
        13 => [
            'id' => 'Ekonomi dari Gulf Cooperation Council (GCC) bergantung sepenuhnya pada produksi dari minyak dan semua sektor ekonomi yang berkutat pada keuntungan yang dihasilkan oleh ekspor minyak.',
            'en' => 'The economy of the Gulf Cooperation Council (GCC) depends entirely on oil production and all economic sectors revolving around profits generated by oil exports',
            'example' => ['id' => 'Pendidikan dari negara-negara Skandinavia bergantung sebagian pada investasi dari pemerintah dan semua program sosial yang berfokus pada kesejahteraan yang dihasilkan oleh kebijakan publik.', 'en' => 'Education of Scandinavian countries depends partially on government investment and all social programs focusing on welfare generated by public policies.'],
            'vocab' => [
                'Economy' => ['id' => 'Ekonomi', 'pos' => '(n)'],
                'Depend entirely' => ['id' => 'Bergantung sepenuhnya', 'pos' => '(v)'],
                'Oil production' => ['id' => 'Produksi minyak', 'pos' => '(n)'],
                'Revolve around' => ['id' => 'Berkutat pada', 'pos' => '(v)'],
                'Profit' => ['id' => 'Keuntungan', 'pos' => '(n)'],
                'Generate' => ['id' => 'Dihasilkan', 'pos' => '(v)'],
                'Oil export' => ['id' => 'Ekspor minyak', 'pos' => '(n)']
            ]
        ],
        14 => [
            'id' => 'Dengan menghancurkan bebatuan, lichen melepaskan ke kolam, danau, dan sungai komponen fosfat dan nitrat yang diperlukan oleh organisme, oleh karena itu menghasilkan nutrisi untuk mikroba tanah dan akar-akar tanaman.',
            'en' => 'By destroying rocks, lichen releases into pools, lakes, and rivers phosphate and nitrate components required by organisms, therefore producing nutrients for soil microbes and plant roots',
            'example' => ['id' => 'Dengan memproses limbah organik, tanaman melepaskan ke udara, tanah, dan air komponen metana dan amonia yang dibutuhkan oleh mikroba, oleh karena itu menghasilkan kompos untuk kebun dan ladang.', 'en' => 'By processing organic waste, plants release into the air, soil, and water methane and ammonia components needed by microbes, therefore producing compost for gardens and fields.'],
            'vocab' => [
                'Destroy' => ['id' => 'Menghancurkan', 'pos' => '(v)'],
                'Rock' => ['id' => 'Bebatuan', 'pos' => '(n)'],
                'Release' => ['id' => 'Melepaskan', 'pos' => '(v)'],
                'Component' => ['id' => 'Komponen', 'pos' => '(n)'],
                'Require' => ['id' => 'Diperlukan', 'pos' => '(v)'],
                'Produce' => ['id' => 'Menghasilkan', 'pos' => '(v)'],
                'Nutrient' => ['id' => 'Nutrisi', 'pos' => '(n)']
            ]
        ],
        15 => [
            'id' => 'Fosil-fosil yang ditemukan dari ikan paus purba menunjukkan bahwa mereka masih memiliki kaki belakang 40.000 juta tahun yang lalu.',
            'en' => 'Fossils found from ancient whales show that they still had hind legs 40,000 million years ago',
            'example' => ['id' => 'Manuskrip-manuskrip yang ditemukan dari perpustakaan Alexandria menunjukkan bahwa mereka sudah memiliki pengetahuan matematika 2.000 tahun yang lalu.', 'en' => 'Manuscripts found from the Alexandria library show that they already had mathematical knowledge 2,000 years ago.'],
            'vocab' => [
                'Fossil' => ['id' => 'Fosil', 'pos' => '(n)'],
                'Ancient whale' => ['id' => 'Ikan paus purba', 'pos' => '(n)'],
                'Show' => ['id' => 'Menunjukkan', 'pos' => '(v)'],
                'Hind leg' => ['id' => 'Kaki belakang', 'pos' => '(n)']
            ]
        ],
        16 => [
            'id' => 'Penelitian yang dilakukan di dalam laboratorium biologi molekuler telah menunjukkan bahwa sejumlah besar spesies memiliki variasi genetik yang rendah yang disebabkan oleh pengurangan ukuran populasi.',
            'en' => 'Research conducted in molecular biology laboratories has shown that a large number of species have low genetic variation caused by population size reduction',
            'example' => ['id' => 'Studi yang dilakukan di dalam pusat penelitian antariksa telah menunjukkan bahwa sejumlah besar planet memiliki atmosfer tipis yang disebabkan oleh radiasi matahari.', 'en' => 'Studies conducted in space research centers have shown that a large number of planets have thin atmospheres caused by solar radiation.'],
            'vocab' => [
                'Research' => ['id' => 'Penelitian', 'pos' => '(n)'],
                'Conduct' => ['id' => 'Dilakukan', 'pos' => '(v)'],
                'Molecular biology' => ['id' => 'Biologi molekuler', 'pos' => '(n)'],
                'Genetic variation' => ['id' => 'Variasi genetik', 'pos' => '(n)'],
                'Reduction' => ['id' => 'Pengurangan', 'pos' => '(n)']
            ]
        ],
        17 => [
            'id' => 'Hypsodont terdiri dari serangkaian laminae tipis yang terbentuk dari enamel yang dikelilingi oleh dentine dengan cementun diantara tiap lamina.',
            'en' => 'Hypsodont consists of a series of thin laminae formed from enamel surrounded by dentine with cementum between each lamina',
            'example' => ['id' => 'Mesin terdiri dari serangkaian komponen mekanis yang terbuat dari logam yang dihubungkan oleh baut dengan pelumas diantara tiap bagian.', 'en' => 'Machines consist of a series of mechanical components made from metal connected by bolts with lubricant between each part.'],
            'vocab' => [
                'Consist of' => ['id' => 'Terdiri dari', 'pos' => '(v)'],
                'Series' => ['id' => 'Serangkaian', 'pos' => '(n)'],
                'Form' => ['id' => 'Terbentuk', 'pos' => '(v)'],
                'Surround' => ['id' => 'Dikelilingi', 'pos' => '(v)'],
                'Between' => ['id' => 'Diantara', 'pos' => '(prep)']
            ]
        ],
        18 => [
            'id' => 'Karena properti intelektual adalah dalam jangkauan nasional, level dari perlindungan yang disediakan oleh instrumen semacam ini bisa bervariasi di seluruh negara.',
            'en' => 'Because intellectual property is within national reach, the level of protection provided by such instruments can vary across countries',
            'example' => ['id' => 'Karena paten adalah dalam jangkauan global, standar dari lisensi yang disediakan oleh organisasi semacam ini bisa berbeda di seluruh wilayah.', 'en' => 'Because patents are within global reach, the standard of licensing provided by such organizations can differ across regions.'],
            'vocab' => [
                'Intellectual property' => ['id' => 'Properti intelektual', 'pos' => '(n)'],
                'National scope' => ['id' => 'Jangkauan nasional', 'pos' => '(n)'],
                'Protection' => ['id' => 'Perlindungan', 'pos' => '(n)'],
                'Provide' => ['id' => 'Disediakan', 'pos' => '(v)'],
                'Vary' => ['id' => 'Bervariasi', 'pos' => '(v)']
            ]
        ],
        19 => [
            'id' => 'Sebuah joint venture adalah sebuah mekanisme bisnis untuk menggabungkan aset komplementer yang dimiliki oleh perusahaan yang berbeda.',
            'en' => 'A joint venture is a business mechanism for combining complementary assets owned by different companies',
            'example' => ['id' => 'Sebuah kemitraan strategis adalah sebuah pendekatan kolaboratif untuk mengintegrasikan sumber daya spesifik yang dimiliki oleh organisasi yang berbeda.', 'en' => 'A strategic partnership is a collaborative approach for integrating specific resources owned by different organizations.'],
            'vocab' => [
                'Joint venture' => ['id' => 'Usaha patungan', 'pos' => '(n)'],
                'Mechanism' => ['id' => 'Mekanisme', 'pos' => '(n)'],
                'Combine' => ['id' => 'Menggabungkan', 'pos' => '(v)'],
                'Complementary asset' => ['id' => 'Aset komplementer', 'pos' => '(n)'],
                'Own' => ['id' => 'Dimiliki', 'pos' => '(v)']
            ]
        ],
        20 => [
            'id' => 'Akhir dari periode Permian yang ditandai dengan kepunahan dari banyak kelompok organisme yang telah mendominasi lingkungan laut dan darat selama ratusan juta tahun membukakan jalan bagi ekspansi dari fauna modern saat ini.',
            'en' => 'The end of the Permian period marked by the extinction of many groups of organisms having dominated marine and terrestrial environments for hundreds of millions of years paved the way for the expansion of modern fauna today',
            'example' => ['id' => 'Awal dari era digital yang ditandai dengan kemunculan dari banyak platform teknologi yang telah mengubah cara komunikasi dan bisnis selama puluhan tahun membuka peluang bagi pertumbuhan dari ekonomi digital saat ini.', 'en' => 'The beginning of the digital era marked by the emergence of many technology platforms having changed communication and business methods for decades opened opportunities for the growth of the digital economy today.'],
            'vocab' => [
                'Mark' => ['id' => 'Ditandai', 'pos' => '(v)'],
                'Extinction' => ['id' => 'Kepunahan', 'pos' => '(n)'],
                'Dominate' => ['id' => 'Mendominasi', 'pos' => '(v)'],
                'Marine' => ['id' => 'Laut', 'pos' => '(adj)'],
                'Terrestrial' => ['id' => 'Darat', 'pos' => '(adj)'],
                'Pave the way' => ['id' => 'Membukakan jalan', 'pos' => '(v)'],
                'Expansion' => ['id' => 'Ekspansi', 'pos' => '(n)']
            ]
        ],
        
        // Present Participle
        21 => [
            'id' => 'Para ilmuwan menemukan spesies living di hutan tropis terpencil.',
            'en' => 'Scientists discover species living in remote tropical forests',
            'example' => ['id' => 'Para peneliti mengamati mikroba thriving di mata air panas yang terisolasi.', 'en' => 'Researchers observe microbes thriving in isolated hot springs.'],
            'vocab' => [
                'Discover' => ['id' => 'Menemukan', 'pos' => '(v)'],
                'Species' => ['id' => 'Spesies', 'pos' => '(n)'],
                'Remote' => ['id' => 'Terpencil', 'pos' => '(adj)'],
                'Tropical forest' => ['id' => 'Hutan tropis', 'pos' => '(n)']
            ]
        ],
        22 => [
            'id' => 'Kota besar memiliki sistem transportasi connecting berbagai wilayah secara efisien.',
            'en' => 'Big cities have transportation systems connecting various regions efficiently',
            'example' => ['id' => 'Negara maju membangun jaringan komunikasi linking berbagai pulau secara cepat.', 'en' => 'Developed countries build communication networks linking various islands quickly.'],
            'vocab' => [
                'Transportation system' => ['id' => 'Sistem transportasi', 'pos' => '(n)'],
                'Connect' => ['id' => 'Menghubungkan', 'pos' => '(v)'],
                'Various' => ['id' => 'Berbagai', 'pos' => '(adj)'],
                'Region' => ['id' => 'Wilayah', 'pos' => '(n)'],
                'Efficiently' => ['id' => 'Secara efisien', 'pos' => '(adv)']
            ]
        ],
        23 => [
            'id' => 'Peneliti menerbitkan artikel tentang teknologi improving kualitas energi terbarukan.',
            'en' => 'Researchers publish articles about technology improving renewable energy quality',
            'example' => ['id' => 'Insinyur mengembangkan inovasi tentang perangkat enhancing efisiensi panel surya.', 'en' => 'Engineers develop innovations about devices enhancing solar panel efficiency.'],
            'vocab' => [
                'Researcher' => ['id' => 'Peneliti', 'pos' => '(n)'],
                'Publish' => ['id' => 'Menerbitkan', 'pos' => '(v)'],
                'Article' => ['id' => 'Artikel', 'pos' => '(n)'],
                'Improve' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
                'Renewable energy' => ['id' => 'Energi terbarukan', 'pos' => '(n)'],
                'Quality' => ['id' => 'Kualitas', 'pos' => '(n)']
            ]
        ],
        24 => [
            'id' => 'Perusahaan meluncurkan perangkat containing fitur keamanan digital terbaru.',
            'en' => 'Companies launch devices containing the latest digital security features',
            'example' => ['id' => 'Produsen merilis aplikasi offering sistem navigasi pintar terkini.', 'en' => 'Producers release applications offering the latest smart navigation systems.'],
            'vocab' => [
                'Launch' => ['id' => 'Meluncurkan', 'pos' => '(v)'],
                'Device' => ['id' => 'Perangkat', 'pos' => '(n)'],
                'Contain' => ['id' => 'Berisi', 'pos' => '(v)'],
                'Feature' => ['id' => 'Fitur', 'pos' => '(n)'],
                'Security' => ['id' => 'Keamanan', 'pos' => '(n)'],
                'Latest' => ['id' => 'Terbaru', 'pos' => '(adj)']
            ]
        ],
        25 => [
            'id' => 'Sungai panjang itu mendukung masyarakat depending pada air untuk pertanian.',
            'en' => 'The long river supports communities depending on water for agriculture',
            'example' => ['id' => 'Danau besar itu menciptakan ekosistem relying pada oksigen untuk kehidupan akuatik.', 'en' => 'The large lake creates ecosystems relying on oxygen for aquatic life.'],
            'vocab' => [
                'Support' => ['id' => 'Mendukung', 'pos' => '(v)'],
                'Community' => ['id' => 'Masyarakat', 'pos' => '(n)'],
                'Depend on' => ['id' => 'Bergantung pada', 'pos' => '(v)'],
                'Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)']
            ]
        ],
        
        // Past Participle
        26 => [
            'id' => 'Kota kuno itu ditemukan dengan sisa bangunan built pada abad ke-5 sebelum masehi.',
            'en' => 'The ancient city was found with building remains built in the 5th century BC',
            'example' => ['id' => 'Benteng bersejarah itu ditemukan dengan struktur pertahanan constructed pada abad ke-12 masehi.', 'en' => 'The historical fortress was found with defense structures constructed in the 12th century AD.'],
            'vocab' => [
                'Ancient city' => ['id' => 'Kota kuno', 'pos' => '(n)'],
                'Found' => ['id' => 'Ditemukan', 'pos' => '(v)'],
                'Remains' => ['id' => 'Sisa', 'pos' => '(n)'],
                'Built' => ['id' => 'Dibangun', 'pos' => '(v)'],
                'Century' => ['id' => 'Abad', 'pos' => '(n)'],
                'BC' => ['id' => 'Sebelum Masehi', 'pos' => '(n)']
            ]
        ],
        27 => [
            'id' => 'Para ilmuwan meneliti fosil preserved di dalam lapisan batuan sedimen.',
            'en' => 'Scientists study fossils preserved in sedimentary rock layers',
            'example' => ['id' => 'Para arkeolog mempelajari artefak stored di dalam ruang penyimpanan museum.', 'en' => 'Archaeologists study artifacts stored in museum storage rooms.'],
            'vocab' => [
                'Study' => ['id' => 'Meneliti', 'pos' => '(v)'],
                'Fossil' => ['id' => 'Fosil', 'pos' => '(n)'],
                'Preserved' => ['id' => 'Diawetkan', 'pos' => '(v)'],
                'Layer' => ['id' => 'Lapisan', 'pos' => '(n)'],
                'Sedimentary rock' => ['id' => 'Batuan sedimen', 'pos' => '(n)']
            ]
        ],
        28 => [
            'id' => 'Museum nasional menampilkan manuskrip written dalam bahasa Sanskerta.',
            'en' => 'The national museum displays manuscripts written in Sanskrit',
            'example' => ['id' => 'Galeri seni memamerkan lukisan created dalam gaya Renaisans.', 'en' => 'The art gallery exhibits paintings created in Renaissance style.'],
            'vocab' => [
                'Display' => ['id' => 'Menampilkan', 'pos' => '(v)'],
                'Manuscript' => ['id' => 'Manuskrip', 'pos' => '(n)'],
                'Written' => ['id' => 'Ditulis', 'pos' => '(v)'],
                'Sanskrit' => ['id' => 'Sanskerta', 'pos' => '(n)']
            ]
        ],
        29 => [
            'id' => 'Observatorium astronomi menggunakan teleskop designed untuk mendeteksi gelombang radio.',
            'en' => 'The astronomical observatory uses telescopes designed to detect radio waves',
            'example' => ['id' => 'Laboratorium fisika mengoperasikan akselerator engineered untuk menghasilkan partikel subatomik.', 'en' => 'The physics laboratory operates accelerators engineered to produce subatomic particles.'],
            'vocab' => [
                'Observatory' => ['id' => 'Observatorium', 'pos' => '(n)'],
                'Telescope' => ['id' => 'Teleskop', 'pos' => '(n)'],
                'Designed' => ['id' => 'Dirancang', 'pos' => '(v)'],
                'Detect' => ['id' => 'Mendeteksi', 'pos' => '(v)'],
                'Radio wave' => ['id' => 'Gelombang radio', 'pos' => '(n)']
            ]
        ],
        30 => [
            'id' => 'Universitas internasional memiliki arsip collected dari berbagai penelitian global.',
            'en' => 'International universities have archives collected from various global research',
            'example' => ['id' => 'Perpustakaan digital menyimpan database compiled dari berbagai publikasi akademik.', 'en' => 'Digital libraries store databases compiled from various academic publications.'],
            'vocab' => [
                'Archive' => ['id' => 'Arsip', 'pos' => '(n)'],
                'Collected' => ['id' => 'Dikumpulkan', 'pos' => '(v)'],
                'Various' => ['id' => 'Berbagai', 'pos' => '(adj)'],
                'Research' => ['id' => 'Penelitian', 'pos' => '(n)']
            ]
        ]
    ];

    public $meeting18Paragraph = [
        'id' => 'Penelitian yang dilakukan oleh para ilmuwan menunjukkan bahwa ekosistem laut yang terancam oleh polusi plastik memerlukan tindakan segera. Spesies living di terumbu karang mengalami penurunan populasi yang signifikan. Teknologi cleaning ocean yang dikembangkan oleh perusahaan internasional mulai diimplementasikan di berbagai negara. Data collected dari satelit membantu peneliti memahami pola migrasi hewan laut. Solusi yang diusulkan oleh komunitas ilmiah mencakup pengurangan penggunaan plastik sekali pakai dan peningkatan program daur ulang.',
        'en' => 'Research conducted by scientists shows that marine ecosystems threatened by plastic pollution require immediate action. Species living in coral reefs experience significant population decline. Ocean cleaning technology developed by international companies is beginning to be implemented in various countries. Data collected from satellites helps researchers understand marine animal migration patterns. Solutions proposed by the scientific community include reducing single-use plastic and increasing recycling programs.',
        'vocab' => [
            'Conduct' => ['id' => 'Melakukan', 'pos' => '(v)'],
            'Marine ecosystem' => ['id' => 'Ekosistem laut', 'pos' => '(n)'],
            'Threaten' => ['id' => 'Mengancam', 'pos' => '(v)'],
            'Pollution' => ['id' => 'Polusi', 'pos' => '(n)'],
            'Immediate action' => ['id' => 'Tindakan segera', 'pos' => '(n)'],
            'Coral reef' => ['id' => 'Terumbu karang', 'pos' => '(n)'],
            'Population decline' => ['id' => 'Penurunan populasi', 'pos' => '(n)'],
            'Implement' => ['id' => 'Mengimplementasikan', 'pos' => '(v)'],
            'Satellite' => ['id' => 'Satelit', 'pos' => '(n)'],
            'Migration pattern' => ['id' => 'Pola migrasi', 'pos' => '(n)'],
            'Propose' => ['id' => 'Mengusulkan', 'pos' => '(v)'],
            'Single-use plastic' => ['id' => 'Plastik sekali pakai', 'pos' => '(n)'],
            'Recycling program' => ['id' => 'Program daur ulang', 'pos' => '(n)']
        ]
    ];

    public $meeting19Questions = [
        1 => [
            'id' => 'Koleksi museum itu terlalu berharga untuk dipindahkan.',
            'en' => 'The museum collection is too valuable to be moved',
            'type' => 'Degree Adverb',
            'adverb' => 'too',
            'example' => ['id' => 'Kopi ini terlalu panas untuk diminum.', 'en' => 'This coffee is too hot to drink.'],
            'vocab' => [
                'Collection' => ['id' => 'Koleksi', 'pos' => '(n)'],
                'Valuable' => ['id' => 'Berharga', 'pos' => '(adj)'],
                'Move' => ['id' => 'Dipindahkan', 'pos' => '(v)']
            ]
        ],
        2 => [
            'id' => 'Sayangnya, banyak situs arkeologi hilang akibat pembangunan modern.',
            'en' => 'Unfortunately, many archaeological sites are lost due to modern development',
            'type' => 'Sentence Adverb',
            // Meeting 20 Data
            'example' => ['id' => 'Dia berjalan lambat.', 'en' => 'He walks slowly.'],
            'vocab' => [
                'Machine' => ['id' => 'Mesin', 'pos' => '(n)'],
                'Process' => ['id' => 'Memproses', 'pos' => '(v)'],
                'Limitation' => ['id' => 'Keterbatasan', 'pos' => '(n)']
            ]
        ],
        10 => [
            'id' => 'Masalah sampah plastik menjadi amat serius di perkotaan modern.',
            'en' => 'The plastic waste problem becomes extremely serious in modern cities',
            'type' => 'Degree Adverb',
            'adverb' => 'extremely',
            'example' => ['id' => 'Ini amat sulit.', 'en' => 'This is extremely difficult.'],
            'vocab' => [
                'Plastic waste' => ['id' => 'Sampah plastik', 'pos' => '(n)'],
                'Serious' => ['id' => 'Serius', 'pos' => '(adj)'],
                'Modern city' => ['id' => 'Perkotaan modern', 'pos' => '(n)']
            ]
        ],
        11 => [
            'id' => 'Untungnya, vaksin baru berhasil menekan penyebaran penyakit.',
            'en' => 'Fortunately, the new vaccine successfully suppresses disease spread',
            'type' => 'Sentence Adverb + Manner Adverb',
            'adverb' => 'fortunately, successfully',
            'example' => ['id' => 'Untungnya, dia berhasil lulus ujian.', 'en' => 'Fortunately, he successfully passed the exam.'],
            'vocab' => [
                'Vaccine' => ['id' => 'Vaksin', 'pos' => '(n)'],
                'Suppress' => ['id' => 'Menekan', 'pos' => '(v)'],
                'Disease spread' => ['id' => 'Penyebaran penyakit', 'pos' => '(n)']
            ]
        ],
        12 => [
            'id' => 'Para ilmuwan teliti mengamati perilaku burung migran.',
            'en' => 'Scientists carefully observe migratory bird behavior',
            'type' => 'Manner Adverb',
            'adverb' => 'carefully',
            'example' => ['id' => 'Dia teliti memeriksa dokumen.', 'en' => 'She carefully checks the documents.'],
            'vocab' => [
                'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
                'Observe' => ['id' => 'Mengamati', 'pos' => '(v)'],
                'Migratory bird' => ['id' => 'Burung migran', 'pos' => '(n)']
            ]
        ],
        13 => [
            'id' => 'Perubahan suhu di gurun terasa amat tiba-tiba pada malam hari.',
            'en' => 'Temperature changes in the desert feel extremely sudden at night',
            'type' => 'Degree Adverb',
            'adverb' => 'extremely',
            'example' => ['id' => 'Perubahan itu amat cepat.', 'en' => 'The change is extremely fast.'],
            'vocab' => [
                'Temperature' => ['id' => 'Suhu', 'pos' => '(n)'],
                'Desert' => ['id' => 'Gurun', 'pos' => '(n)'],
                'Sudden' => ['id' => 'Tiba-tiba', 'pos' => '(adj)']
            ]
        ],
        14 => [
            'id' => 'Pusat penelitian itu rutin mengadakan konferensi internasional.',
            'en' => 'The research center regularly holds international conferences',
            'type' => 'Manner Adverb',
            'adverb' => 'regularly',
            'example' => ['id' => 'Dia rutin berolahraga.', 'en' => 'He regularly exercises.'],
            'vocab' => [
                'Research center' => ['id' => 'Pusat penelitian', 'pos' => '(n)'],
                'Hold' => ['id' => 'Mengadakan', 'pos' => '(v)'],
                'Conference' => ['id' => 'Konferensi', 'pos' => '(n)']
            ]
        ],
        15 => [
            'id' => 'Data genetika dianggap sangat penting untuk memahami evolusi.',
            'en' => 'Genetic data is considered very important for understanding evolution',
            'type' => 'Degree Adverb',
            'adverb' => 'very',
            'example' => ['id' => 'Ini sangat berguna.', 'en' => 'This is very important.'],
            'vocab' => [
                'Genetic data' => ['id' => 'Data genetika', 'pos' => '(n)'],
                'Consider' => ['id' => 'Dianggap', 'pos' => '(v)'],
                'Evolution' => ['id' => 'Evolusi', 'pos' => '(n)']
            ]
        ],
        16 => [
            'id' => 'Secara umum, teknologi digital meningkatkan efisiensi komunikasi global.',
            'en' => 'Generally, digital technology increases global communication efficiency',
            'type' => 'Sentence Adverb',
            'adverb' => 'generally',
            'example' => ['id' => 'Secara umum, ini benar.', 'en' => 'Generally, this is true.'],
            'vocab' => [
                'Digital technology' => ['id' => 'Teknologi digital', 'pos' => '(n)'],
                'Increase' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
                'Efficiency' => ['id' => 'Efisiensi', 'pos' => '(n)']
            ]
        ],
        17 => [
            'id' => 'Para dokter cermat mendiagnosis pasien dengan metode modern.',
            'en' => 'Doctors carefully diagnose patients with modern methods',
            'type' => 'Manner Adverb',
            'adverb' => 'carefully',
            'example' => ['id' => 'Dia cermat menganalisis data.', 'en' => 'She carefully analyzes data.'],
            'vocab' => [
                'Doctor' => ['id' => 'Dokter', 'pos' => '(n)'],
                'Diagnose' => ['id' => 'Mendiagnosis', 'pos' => '(v)'],
                'Method' => ['id' => 'Metode', 'pos' => '(n)']
            ]
        ],
        18 => [
            'id' => 'Hujan deras menyebabkan sungai meluap sangat cepat.',
            'en' => 'Heavy rain causes the river to overflow very quickly',
            'type' => 'Intensifier + Manner Adverb',
            'adverb' => 'very quickly',
            'example' => ['id' => 'Dia berlari sangat cepat.', 'en' => 'He runs very quickly.'],
            'vocab' => [
                'Heavy rain' => ['id' => 'Hujan deras', 'pos' => '(n)'],
                'Overflow' => ['id' => 'Meluap', 'pos' => '(v)'],
                'Quickly' => ['id' => 'Cepat', 'pos' => '(adv)']
            ]
        ],
        19 => [
            'id' => 'Anehnya, fosil kuno ditemukan di lokasi yang jauh dari lautan.',
            'en' => 'Surprisingly, ancient fossils are found in locations far from the ocean',
            'type' => 'Sentence Adverb',
            'adverb' => 'surprisingly',
            'example' => ['id' => 'Anehnya, dia tidak datang.', 'en' => 'Surprisingly, he did not come.'],
            'vocab' => [
                'Fossil' => ['id' => 'Fosil', 'pos' => '(n)'],
                'Ancient' => ['id' => 'Kuno', 'pos' => '(adj)'],
                'Ocean' => ['id' => 'Lautan', 'pos' => '(n)']
            ]
        ],
        20 => [
            'id' => 'Data satelit ditransmisikan cukup cepat ke pusat kendali bumi.',
            'en' => 'Satellite data is transmitted quite quickly to the earth control center',
            'type' => 'Intensifier + Manner Adverb',
            'adverb' => 'quite quickly',
            'example' => ['id' => 'Dia bekerja cukup cepat.', 'en' => 'She works quite quickly.'],
            'vocab' => [
                'Satellite' => ['id' => 'Satelit', 'pos' => '(n)'],
                'Transmit' => ['id' => 'Ditransmisikan', 'pos' => '(v)'],
                'Control center' => ['id' => 'Pusat kendali', 'pos' => '(n)']
            ]
        ]
    ];

    public $meeting19Paragraph = [
        'id' => 'Memang, urbanisasi memengaruhi struktur sosial di berbagai kota besar, dan secara umum, teknologi digital meningkatkan efisiensi komunikasi global. Namun, sayangnya, banyak situs arkeologi hilang akibat pembangunan modern, meskipun beberapa koleksi museum tetap terlalu berharga untuk dipindahkan. Para ilmuwan teliti mengamati perilaku burung migran, sementara pusat penelitian rutin mengadakan konferensi internasional guna membahas isu lingkungan. Sungai besar tampak sangat kotor setelah banjir besar, dan hujan deras dapat membuat alirannya meluap sangat cepat. Anehnya, fosil kuno ditemukan di lokasi yang jauh dari lautan, sedangkan observatorium ditempatkan di lokasi sangat strategis di puncak gunung. Tim ekspedisi cepat menanggapi perubahan cuaca di dataran tinggi, dan para dokter cermat mendiagnosis pasien dengan metode modern. Data genetika dianggap sangat penting untuk memahami evolusi, dan masalah sampah plastik kini amat serius di perkotaan modern. Untungnya, vaksin baru berhasil menekan penyebaran penyakit, sementara data satelit ditransmisikan cukup cepat ke pusat kendali bumi. Gelombang radio bahkan diterima cukup jelas oleh antena komunikasi, meskipun perubahan suhu di gurun terasa amat tiba-tiba pada malam hari.',
        'en' => 'Indeed, urbanization affects social structures in various large cities, and generally, digital technology increases global communication efficiency. However, unfortunately, many archaeological sites are lost due to modern development, although some museum collections remain too valuable to be moved. Scientists carefully observe migratory bird behavior, while research centers regularly hold international conferences to discuss environmental issues. Large rivers look very dirty after major floods, and heavy rain can cause them to overflow very quickly. Surprisingly, ancient fossils are found in locations far from the ocean, while observatories are placed in very strategic locations at mountain peaks. Expedition teams quickly respond to weather changes in the highlands, and doctors carefully diagnose patients with modern methods. Genetic data is considered very important for understanding evolution, and the plastic waste problem is now extremely serious in modern cities. Fortunately, new vaccines successfully suppress disease spread, while satellite data is transmitted quite quickly to earth control centers. Radio waves are even received quite clearly by communication antennas, although temperature changes in the desert feel extremely sudden at night.',
        'vocab' => [
            'Urbanization' => 'Urbanisasi',
            'Affect' => 'Memengaruhi',
            'Archaeological site' => 'Situs arkeologi',
            'Valuable' => 'Berharga',
            'Carefully' => 'Teliti/hati-hati',
            'Migratory bird' => 'Burung migran',
            'Regularly' => 'Rutin',
            'Environmental issue' => 'Isu lingkungan',
            'Overflow' => 'Meluap',
            'Fossil' => 'Fosil',
            'Observatory' => 'Observatorium',
            'Strategic' => 'Strategis',
            'Expedition' => 'Ekspedisi',
            'Diagnose' => 'Mendiagnosis',
            'Genetic data' => 'Data genetika',
            'Evolution' => 'Evolusi',
            'Plastic waste' => 'Sampah plastik',
            'Suppress' => 'Menekan',
            'Transmit' => 'Mentransmisikan'
        ]
    ];

    public $meeting20Paragraph = [
        'id' => 'Perubahan lingkungan kini menjadi isu global yang semakin mendesak dan tidak dapat diabaikan. Banyak komunitas ilmiah di seluruh dunia sedang meneliti dampak pemanasan global terhadap keanekaragaman hayati di kawasan pesisir, hutan hujan tropis, dan wilayah kutub yang sensitif. Saya sendiri telah melihat bagaimana kualitas air menurun secara drastis selama satu dekade terakhir, terutama di daerah pesisir tempat saya melakukan penelitian kecil bersama kelompok konservasi lokal. Pada masa lalu, pemerintah membangun banyak program konservasi, tetapi sebagian besar tidak dijalankan secara efektif sehingga manfaatnya tidak dapat dirasakan secara nyata oleh masyarakat. Saat ini, prioritas utama adalah melindungi ekosistem laut, yang merupakan sumber kehidupan bagi jutaan orang dan menopang perekonomian daerah pesisir. Para ilmuwan yang saya temui menjelaskan bahwa perubahan iklim tidak hanya mempengaruhi spesies langka, tetapi juga ekonomi nelayan lokal yang semakin rentan terhadap badai dan ketidakpastian cuaca. Mereka menggunakan pengumpulan data secara sistematis untuk meningkatkan akurasi penelitian dan memperkirakan tren lingkungan jangka panjang. Untuk memahami penyebab utama kerusakan lingkungan, banyak peneliti melakukan analisis mendalam dengan metode yang lebih efisien melalui kolaborasi antaruniversitas dan lembaga internasional. Ekosistem terumbu karang adalah salah satu ekosistem paling rentan di dunia, karena lokasi di mana intensitas polusi sangat tinggi dan suhu permukaan laut terus meningkat. Komunitas nelayan, yang wilayahnya terancam naiknya permukaan laut akibat mencairnya es di kutub, terus berjuang mempertahankan mata pencaharian mereka meskipun bantuan pemerintah sering terlambat dan tidak mencukupi. Beberapa kelompok masyarakat mengembangkan strategi konservasi berbasis budaya lokal dengan harapan dapat meningkatkan kesadaran publik melalui pendidikan lingkungan dan pelatihan pengelolaan laut berkelanjutan.',
        'en' => 'Environmental change is now an increasingly urgent global issue that cannot be ignored. Many scientific communities around the world are researching the impact of global warming on biodiversity in coastal areas, tropical rainforests, and sensitive polar regions. I myself have seen how water quality has declined drastically over the last decade, especially in coastal areas where I conduct small research with local conservation groups. In the past, the government built many conservation programs, but most were not implemented effectively so that the benefits could not be felt tangibly by the community. Currently, the main priority is protecting marine ecosystems, which are a source of life for millions of people and support the economy of coastal areas. The scientists I met explained that climate change not only affects rare species, but also the economy of local fishermen who are increasingly vulnerable to storms and weather uncertainty. They use systematic data collection to improve research accuracy and predict long-term environmental trends. To understand the main causes of environmental damage, many researchers conduct in-depth analysis with more efficient methods through collaboration between universities and international institutions. Coral reef ecosystems are one of the most vulnerable ecosystems in the world, due to locations where pollution intensity is very high and sea surface temperatures continue to rise. Fishing communities, whose territories are threatened by rising sea levels due to melting polar ice, continue to struggle to maintain their livelihoods even though government assistance is often late and insufficient. Some community groups develop conservation strategies based on local culture with the hope of increasing public awareness through environmental education and sustainable marine management training.',
        'vocab' => [
            'Environmental change' => 'Perubahan lingkungan',
            'Urgent' => 'Mendesak',
            'Global issue' => 'Isu global',
            'Ignored' => 'Diabaikan',
            'Scientific community' => 'Komunitas ilmiah',
            'Research' => 'Meneliti',
            'Impact' => 'Dampak',
            'Global warming' => 'Pemanasan global',
            'Biodiversity' => 'Keanekaragaman hayati',
            'Coastal area' => 'Kawasan pesisir',
            'Tropical rainforest' => 'Hutan hujan tropis',
            'Polar region' => 'Wilayah kutub',
            'Sensitive' => 'Sensitif',
            'Water quality' => 'Kualitas air',
            'Decline' => 'Menurun',
            'Drastically' => 'Secara drastis',
            'Decade' => 'Dekade',
            'Conservation group' => 'Kelompok konservasi',
            'Conservation program' => 'Program konservasi',
            'Implemented' => 'Dijalankan',
            'Effectively' => 'Secara efektif',
            'Benefits' => 'Manfaat',
            'Tangibly' => 'Secara nyata',
            'Priority' => 'Prioritas',
            'Marine ecosystem' => 'Ekosistem laut',
            'Source of life' => 'Sumber kehidupan',
            'Support' => 'Menopang',
            'Economy' => 'Perekonomian',
            'Climate change' => 'Perubahan iklim',
            'Rare species' => 'Spesies langka',
            'Fisherman' => 'Nelayan',
            'Vulnerable' => 'Rentan',
            'Storm' => 'Badai',
            'Weather uncertainty' => 'Ketidakpastian cuaca',
            'Systematic' => 'Sistematis',
            'Data collection' => 'Pengumpulan data',
            'Accuracy' => 'Akurasi',
            'In-depth analysis' => 'Analisis mendalam',
            'Efficient' => 'Efisien',
            'Collaboration' => 'Kolaborasi',
            'International institution' => 'Lembaga internasional',
            'Coral reef ecosystem' => 'Ekosistem terumbu karang',
            'Sea surface temperature' => 'Suhu permukaan laut',
            'Sea level rise' => 'Naiknya permukaan laut',
            'Polar ice' => 'Es di kutub',
            'Livelihood' => 'Mata pencaharian',
            'Assistance' => 'Bantuan',
            'Insufficient' => 'Tidak mencukupi',
            'Local culture' => 'Budaya lokal',
            'Public awareness' => 'Kesadaran publik',
            'Environmental education' => 'Pendidikan lingkungan',
            'Sustainable marine management' => 'Pengelolaan laut berkelanjutan'
        ]
    ];

    public $meeting2Tenses = [
        'Simple Present' => ['verbal' => 'S + V1(s/es)', 'nominal' => 'S + Be(am/is/are)', 'passive' => 'S + Be(am/is/are) + V3'],
        'Present Continuous' => ['verbal' => 'S + Be(am/is/are) + Ving', 'nominal' => 'S + Be(am/is/are) + Being', 'passive' => 'S + Be(am/is/are) + Being + V3'],
        'Present Perfect' => ['verbal' => 'S + Have/Has + V3', 'nominal' => 'S + Have/Has + Been', 'passive' => 'S + Have/Has + Been + V3'],
        'Present Perfect Continuous' => ['verbal' => 'S + Have/Has + Been + Ving', 'nominal' => 'S + Have/Has + Been + Being', 'passive' => 'S + Have/Has + Been + Being + V3'],
        'Simple Past' => ['verbal' => 'S + V2', 'nominal' => 'S + Be(was/were)', 'passive' => 'S + Be(was/were) + V3'],
        'Past Continuous' => ['verbal' => 'S + Be(was/were) + Ving', 'nominal' => 'S + Be(was/were) + Being', 'passive' => 'S + Be(was/were) + Being + V3'],
        'Past Perfect' => ['verbal' => 'S + Had + V3', 'nominal' => 'S + Had + Been', 'passive' => 'S + Had + Been + V3'],
        'Past Perfect Continuous' => ['verbal' => 'S + Had + Been + Ving', 'nominal' => 'S + Had + Been + Being', 'passive' => 'S + Had + Been + Being + V3'],
        'Simple Future' => ['verbal' => 'S + Will + V1', 'nominal' => 'S + Will + Be', 'passive' => 'S + Will + Be + V3'],
        'Future Continuous' => ['verbal' => 'S + Will + Be + Ving', 'nominal' => 'S + Will + Be + Being', 'passive' => 'S + Will + Be + Being + V3'],
        'Future Perfect' => ['verbal' => 'S + Will + Have + V3', 'nominal' => 'S + Will + Have + Been', 'passive' => 'S + Will + Have + Been + V3'],
        'Future Perfect Continuous' => ['verbal' => 'S + Will + Have + Been + Ving', 'nominal' => 'S + Will + Have + Been + Being', 'passive' => 'S + Will + Have + Been + Being + V3'],
        'Simple Past Future' => ['verbal' => 'S + Would + V1', 'nominal' => 'S + Would + Be', 'passive' => 'S + Would + Be + V3'],
        'Past Future Continuous' => ['verbal' => 'S + Would + Be + Ving', 'nominal' => 'S + Would + Be + Being', 'passive' => 'S + Would + Be + Being + V3'],
        'Past Future Perfect' => ['verbal' => 'S + Would + Have + V3', 'nominal' => 'S + Would + Have + Been', 'passive' => 'S + Would + Have + Been + V3'],
        'Past Future Perfect Continuous' => ['verbal' => 'S + Would + Have + Been + Ving', 'nominal' => 'S + Would + Have + Been + Being', 'passive' => 'S + Would + Have + Been + Being + V3'],
        'Modal' => ['verbal' => 'S + Modal + V1', 'nominal' => 'S + Modal + Be', 'passive' => 'S + Modal + Be + V3']
    ];

    public $meeting2TranslationSentences = [
        1 => ['id' => 'Kita membangun dunia ini.', 'en' => 'We build this world', 'tense' => 'Simple Present', 'type' => 'verbal'],
        2 => ['id' => 'Dia (perempuan) menjadi pemimpin.', 'en' => 'She becomes a leader', 'tense' => 'Simple Present', 'type' => 'nominal']
    ];

    public $meeting2TranslationMatrix = [
        'Simple Present' => [
            'verbal' => ['id' => 'Bumi mengelilingi matahari.', 'en' => 'The earth orbits the sun'],
            'nominal' => ['id' => 'Perkembangan teknologi ini penting.', 'en' => 'This technological development is important'],
            'passive' => ['id' => 'Komputer dikendalikan oleh chip.', 'en' => 'Computers are controlled by chips']
        ],
        'Present Continuous' => [
            'verbal' => ['id' => 'Kita sedang menghadapi global warming.', 'en' => 'We are facing global warming'],
            'nominal' => ['id' => 'Pemerintah sedang berhati-hati.', 'en' => 'The government is being careful'],
            'passive' => ['id' => 'Sungai sedang dicemari oleh pabrik.', 'en' => 'Rivers are being polluted by factories']
        ],
        'Present Perfect' => [
            'verbal' => ['id' => 'Pemerintah sudah memberikan subsidi.', 'en' => 'The government has given subsidies'],
            'nominal' => ['id' => 'Tanggung jawab ini telah ada di pemerintah.', 'en' => 'This responsibility has been with the government'],
            'passive' => ['id' => 'Konservasi ini telah dibangun.', 'en' => 'This conservation has been built']
        ],
        'Present Perfect Continuous' => [
            'verbal' => ['id' => 'Pemanasan global telah sedang terjadi selama 30 tahun.', 'en' => 'Global warming has been happening for 30 years'],
            'nominal' => ['id' => 'Pemerintah sudah sedang berhati-hati.', 'en' => 'The government has been being careful'],
            'passive' => ['id' => 'Hutan sudah sedang dihancurkan.', 'en' => 'Forests have been being destroyed']
        ],
        'Simple Past' => [
            'verbal' => ['id' => 'Organisasi dunia bertemu 30 tahun yang lalu.', 'en' => 'World organizations met 30 years ago'],
            'nominal' => ['id' => 'Banyak hewan liar ada di Jawa dulu.', 'en' => 'Many wild animals were in Java in the past'],
            'passive' => ['id' => 'Perlindungan ini diberikan 10 tahun yang lalu.', 'en' => 'This protection was given 10 years ago']
        ],
        'Past Continuous' => [
            'verbal' => ['id' => 'Orang - orang sedang berburu dulu.', 'en' => 'People were hunting in the past'],
            'nominal' => ['id' => 'Pemerintah sedang berhati-hati dulu.', 'en' => 'The government was being careful in the past'],
            'passive' => ['id' => 'Industri sedang didorong pada waktu itu.', 'en' => 'Industry was being encouraged at that time']
        ],
        'Past Perfect' => [
            'verbal' => ['id' => 'Manusia telah mengembangkan pertanian 5000 tahun yang lalu.', 'en' => 'Humans had developed agriculture 5000 years ago'],
            'nominal' => ['id' => 'Manusia telah ada di Amerika Utara 7000 tahun yang lalu.', 'en' => 'Humans had been in North America 7000 years ago'],
            'passive' => ['id' => 'Pabrik - pabrik telah dibangun sebelum revolusi industri.', 'en' => 'Factories had been built before the industrial revolution']
        ],
        'Past Perfect Continuous' => [
            'verbal' => ['id' => 'Kepunahan dinosaurus telah terjadi sebelum tabrakan meteor.', 'en' => 'Dinosaur extinction had been happening before the meteor collision'],
            'nominal' => ['id' => 'Pemerintah telah sedang berhati-hati dulu.', 'en' => 'The government had been being careful in the past'],
            'passive' => ['id' => 'Mammoth telah diburu oleh manusia sebelum kepunahan mereka.', 'en' => 'Mammoths had been hunted by humans before their extinction']
        ],
        'Simple Future' => [
            'verbal' => ['id' => 'Dunia akan mengalami kegagalan panen.', 'en' => 'The world will experience crop failure'],
            'nominal' => ['id' => 'Banyak hewan akan punah.', 'en' => 'Many animals will be extinct'],
            'passive' => ['id' => 'Banyak ekosistem akan terpengaruh.', 'en' => 'Many ecosystems will be affected']
        ],
        'Future Continuous' => [
            'verbal' => ['id' => 'Dunia akan sedang berubah dalam 50 tahun.', 'en' => 'The world will be changing in 50 years'],
            'nominal' => ['id' => 'Pemerintah akan sedang berhati-hati.', 'en' => 'The government will be being careful'],
            'passive' => ['id' => 'Luar angkasa akan sedang dijelajahi dalam 300 tahun lagi', 'en' => 'Outer space will be being explored in 300 years']
        ],
        'Future Perfect' => [
            'verbal' => ['id' => 'Kerusakan lingkungan akan telah merusak 50% dari ekosistem dunia.', 'en' => 'Environmental damage will have destroyed 50% of the world\'s ecosystems'],
            'nominal' => ['id' => 'Banyak negara berkembang akan telah menjadi negara maju dalam 50 tahun lagi.', 'en' => 'Many developing countries will have become developed countries in 50 years'],
            'passive' => ['id' => 'DNA akan telah dipetakan 10 tahun lagi.', 'en' => 'DNA will have been mapped in 10 years']
        ],
        'Future Perfect Continuous' => [
            'verbal' => ['id' => 'Pemerintah akan telah sedang membangun proyek ini bulan depan.', 'en' => 'The government will have been building this project next month'],
            'nominal' => ['id' => 'Pemerintah akan telah sedang berhati - hati.', 'en' => 'The government will have been being careful'],
            'passive' => ['id' => 'Udara akan telah tercemar oleh polusi.', 'en' => 'The air will have been polluted by pollution']
        ],
        'Simple Past Future' => [
            'verbal' => ['id' => 'Hal ini akan merusak ekosistem.', 'en' => 'This would destroy the ecosystem'],
            'nominal' => ['id' => 'Masalah ini akan menjadi (nominal) masalah besar.', 'en' => 'This problem would be a big problem'],
            'passive' => ['id' => 'Bencana ini akan dihindari', 'en' => 'This disaster would be avoided']
        ],
        'Past Future Continuous' => [
            'verbal' => ['id' => 'Antartika akan sedang menghilang.', 'en' => 'Antarctica would be disappearing'],
            'nominal' => ['id' => 'Pemerintah akan sedang berhati-hati.', 'en' => 'The government would be being careful'],
            'passive' => ['id' => 'Bulan akan sedang ditambang.', 'en' => 'The moon would be being mined']
        ],
        'Past Future Perfect' => [
            'verbal' => ['id' => 'Teknologi ini akan telah berkembang.', 'en' => 'This technology would have developed'],
            'nominal' => ['id' => 'Manusia akan telah dalam harmoni.', 'en' => 'Humans would have been in harmony'],
            'passive' => ['id' => 'Perang di dunia akan telah dihentikan.', 'en' => 'Wars in the world would have been stopped']
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => ['id' => 'Manusia akan telah berjalan di Mars.', 'en' => 'Humans would have been walking on Mars'],
            'nominal' => ['id' => 'Pemerintah akan telah sedang berhati-hati.', 'en' => 'The government would have been being careful'],
            'passive' => ['id' => 'Perdamaian dunia akan telah tercapai.', 'en' => 'World peace would have been achieved']
        ],
        'Modal' => [
            'verbal' => ['id' => 'Perusahaan harus memperhatikan lingkungan.', 'en' => 'Companies must pay attention to the environment'],
            'nominal' => ['id' => 'Hewan langka seharusnya ada di habitat terlindungi.', 'en' => 'Rare animals should be in protected habitats'],
            'passive' => ['id' => 'Air bisa dijaga dengan hati - hati.', 'en' => 'Water can be maintained carefully']
        ]
    ];

    public $meeting2TenseExamples = [
        'Simple Present' => [
            'verbal' => ['id' => 'Bulan mengelilingi bumi.', 'en' => 'The moon orbits the earth.'],
            'nominal' => ['id' => 'Ini menjadi masalah.', 'en' => 'It becomes problem.'],
            'passive' => ['id' => 'Ruangan didinginkan oleh AC.', 'en' => 'The room is cooled by AC.']
        ],
        'Present Continuous' => [
            'verbal' => ['id' => 'Mereka sedang mendiskusikan rencana.', 'en' => 'They are discussing the plan.'],
            'nominal' => ['id' => 'Dia sedang sopan.', 'en' => 'He is being polite.'],
            'passive' => ['id' => 'Jalan sedang diperbaiki oleh pekerja.', 'en' => 'The road is being repaired by workers.']
        ],
        'Present Perfect' => [
            'verbal' => ['id' => 'Perusahaan sudah mengirimkan barang.', 'en' => 'The company has sent the goods.'],
            'nominal' => ['id' => 'Masalah ini telah ada di pikiran saya.', 'en' => 'This problem has been on my mind.'],
            'passive' => ['id' => 'Jembatan ini telah diselesaikan.', 'en' => 'This bridge has been completed.']
        ],
        'Present Perfect Continuous' => [
            'verbal' => ['id' => 'Hujan telah sedang turun selama 2 jam.', 'en' => 'Rain has been falling for 2 hours.'],
            'nominal' => ['id' => 'Anak-anak sudah sedang tenang.', 'en' => 'The children have been being quiet.'],
            'passive' => ['id' => 'Gedung sudah sedang direnovasi.', 'en' => 'The building has been being renovated.']
        ],
        'Simple Past' => [
            'verbal' => ['id' => 'Kami bertemu 2 hari yang lalu.', 'en' => 'We met 2 days ago.'],
            'nominal' => ['id' => 'Dinosaurus ada di bumi dulu.', 'en' => 'Dinosaurs were on earth in the past.'],
            'passive' => ['id' => 'Surat ini dikirim kemarin.', 'en' => 'This letter was sent yesterday.']
        ],
        'Past Continuous' => [
            'verbal' => ['id' => 'Mereka sedang bermain ketika hujan turun.', 'en' => 'They were playing when it rained.'],
            'nominal' => ['id' => 'Dia sedang marah waktu itu.', 'en' => 'He was being angry at that time.'],
            'passive' => ['id' => 'Mobil sedang dicuci ketika saya datang.', 'en' => 'The car was being washed when I arrived.']
        ],
        'Past Perfect' => [
            'verbal' => ['id' => 'Dia telah menyelesaikan tugas sebelum ibu pulang.', 'en' => 'He had finished the task before mom came home.'],
            'nominal' => ['id' => 'Mereka telah ada di sana sebelum kami tiba.', 'en' => 'They had been there before we arrived.'],
            'passive' => ['id' => 'Rumah telah dijual sebelum mereka pindah.', 'en' => 'The house had been sold before they moved.']
        ],
        'Past Perfect Continuous' => [
            'verbal' => ['id' => 'Dia telah sedang menunggu selama sejam...', 'en' => 'He had been waiting for an hour...'],
            'nominal' => ['id' => 'Dia telah sedang sedih sebelum kabar baik datang.', 'en' => 'He had been being sad before the good news came.'],
            'passive' => ['id' => 'Kota telah sedang diserang sebelum bantuan tiba.', 'en' => 'The city had been being attacked before help arrived.']
        ],
        'Simple Future' => [
            'verbal' => ['id' => 'Saya akan makan.', 'en' => 'I will eat.'],
            'nominal' => ['id' => 'Saya akan senang.', 'en' => 'I will be happy.'],
            'passive' => ['id' => 'Nasi akan dimakan.', 'en' => 'Rice will be eaten.']
        ],
        'Future Continuous' => [
            'verbal' => ['id' => 'Saya akan sedang makan.', 'en' => 'I will be eating.'],
            'nominal' => ['id' => 'Saya akan sedang senang.', 'en' => 'I will be being happy.'],
            'passive' => ['id' => 'Nasi akan sedang dimakan.', 'en' => 'Rice will be being eaten.']
        ],
        'Future Perfect' => [
            'verbal' => ['id' => 'Saya akan sudah makan.', 'en' => 'I will have eaten.'],
            'nominal' => ['id' => 'Saya akan sudah senang.', 'en' => 'I will have been happy.'],
            'passive' => ['id' => 'Nasi akan sudah dimakan.', 'en' => 'Rice will have been eaten.']
        ],
        'Future Perfect Continuous' => [
            'verbal' => ['id' => 'Saya akan sudah sedang makan.', 'en' => 'I will have been eating.'],
            'nominal' => ['id' => 'Saya akan sudah sedang senang.', 'en' => 'I will have been being happy.'],
            'passive' => ['id' => 'Nasi akan sudah sedang dimakan.', 'en' => 'Rice will have been being eaten.']
        ],
        'Simple Past Future' => [
            'verbal' => ['id' => 'Saya akan makan (dulu).', 'en' => 'I would eat.'],
            'nominal' => ['id' => 'Saya akan senang (dulu).', 'en' => 'I would be happy.'],
            'passive' => ['id' => 'Nasi akan dimakan (dulu).', 'en' => 'Rice would be eaten.']
        ],
        'Past Future Continuous' => [
            'verbal' => ['id' => 'Saya akan sedang makan (dulu).', 'en' => 'I would be eating.'],
            'nominal' => ['id' => 'Saya akan sedang senang (dulu).', 'en' => 'I would be being happy.'],
            'passive' => ['id' => 'Nasi akan sedang dimakan (dulu).', 'en' => 'Rice would be being eaten.']
        ],
        'Past Future Perfect' => [
            'verbal' => ['id' => 'Saya akan sudah makan (dulu).', 'en' => 'I would have eaten.'],
            'nominal' => ['id' => 'Saya akan sudah senang (dulu).', 'en' => 'I would have been happy.'],
            'passive' => ['id' => 'Nasi akan sudah dimakan (dulu).', 'en' => 'Rice would have been eaten.']
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => ['id' => 'Saya akan sudah sedang makan (dulu).', 'en' => 'I would have been eating.'],
            'nominal' => ['id' => 'Saya akan sudah sedang senang (dulu).', 'en' => 'I would have been being happy.'],
            'passive' => ['id' => 'Nasi akan sudah sedang dimakan (dulu).', 'en' => 'Rice would have been being eaten.']
        ],
        'Modal' => [
            'verbal' => ['id' => 'Saya bisa makan.', 'en' => 'I can eat.'],
            'nominal' => ['id' => 'Saya bisa senang.', 'en' => 'I can be happy.'],
            'passive' => ['id' => 'Nasi bisa dimakan.', 'en' => 'Rice can be eaten.']
        ]
    ];

    public $meeting2Vocabularies = [
        'Simple Present' => [
            'verbal' => [
                'Orbit' => ['id' => 'Mengelilingi', 'pos' => '(v)'],
                'Earth' => ['id' => 'Bumi', 'pos' => '(n)'],
                'Sun' => ['id' => 'Matahari', 'pos' => '(n)']
            ],
            'nominal' => [
                'Development' => ['id' => 'Perkembangan', 'pos' => '(n)'],
                'Technology' => ['id' => 'Teknologi', 'pos' => '(n)'],
                'Important' => ['id' => 'Penting', 'pos' => '(adj)']
            ],
            'passive' => [
                'Computer' => ['id' => 'Komputer', 'pos' => '(n)'],
                'By' => ['id' => 'Oleh', 'pos' => '(prep)'],
                'Chip' => ['id' => 'Chip', 'pos' => '(n)']
            ]
        ],
        'Present Continuous' => [
            'verbal' => [
                'Face' => ['id' => 'Menghadapi', 'pos' => '(v)'],
                'Global warming' => ['id' => 'Pemanasan global', 'pos' => '(n)']
            ],
            'nominal' => [
                'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => [
                'River' => ['id' => 'Sungai', 'pos' => '(n)'],
                'Factory' => ['id' => 'Pabrik', 'pos' => '(n)']
            ]
        ],
        'Present Perfect' => [
            'verbal' => [
                'Give' => ['id' => 'Memberikan', 'pos' => '(v)'],
                'Subsidy' => ['id' => 'Subsidi', 'pos' => '(n)']
            ],
            'nominal' => [
                'Responsibility' => ['id' => 'Tanggung jawab', 'pos' => '(n)'],
                'Government' => ['id' => 'Pemerintah', 'pos' => '(n)']
            ],
            'passive' => [
                'Conservation' => ['id' => 'Konservasi', 'pos' => '(n)']
            ]
        ],
        'Present Perfect Continuous' => [
            'verbal' => [
                'Global warming' => ['id' => 'Pemanasan global', 'pos' => '(n)'],
                'Happen' => ['id' => 'Terjadi', 'pos' => '(v)'],
                'For' => ['id' => 'Selama', 'pos' => '(prep)']
            ],
            'nominal' => [
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => [
                'Forest' => ['id' => 'Hutan', 'pos' => '(n)']
            ]
        ],
        'Simple Past' => [
            'verbal' => [
                'Organization' => ['id' => 'Organisasi', 'pos' => '(n)'],
                'Meet' => ['id' => 'Bertemu', 'pos' => '(v)'],
                'Ago' => ['id' => 'Yang lalu', 'pos' => '(adv)']
            ],
            'nominal' => [
                'Wild animal' => ['id' => 'Hewan liar', 'pos' => '(n)'],
                'Be/Exist' => ['id' => 'Ada', 'pos' => '(v)']
            ],
            'passive' => [
                'Protection' => ['id' => 'Perlindungan', 'pos' => '(n)']
            ]
        ],
        'Past Continuous' => [
            'verbal' => [
                'Hunt' => ['id' => 'Berburu', 'pos' => '(v)']
            ],
            'nominal' => [
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => [
                'Industry' => ['id' => 'Industri', 'pos' => '(n)']
            ]
        ],
        'Past Perfect' => [
            'verbal' => [
                'Develop' => ['id' => 'Mengembangkan', 'pos' => '(v)'],
                'Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)']
            ],
            'nominal' => [
                'Human' => ['id' => 'Manusia', 'pos' => '(n)']
            ],
            'passive' => [
                'Factory' => ['id' => 'Pabrik', 'pos' => '(n)'],
                'Industrial revolution' => ['id' => 'Revolusi industri', 'pos' => '(n)']
            ]
        ],
        'Past Perfect Continuous' => [
            'verbal' => [
                'Extinction' => ['id' => 'Kepunahan', 'pos' => '(n)'],
                'Happen' => ['id' => 'Terjadi', 'pos' => '(v)'],
                'Collision' => ['id' => 'Tabrakan', 'pos' => '(n)'],
                'Meteor' => ['id' => 'Meteor', 'pos' => '(n)']
            ],
            'nominal' => [
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => []
        ],
        'Simple Future' => [
            'verbal' => [
                'Experience' => ['id' => 'Mengalami', 'pos' => '(v)'],
                'Failure' => ['id' => 'Kegagalan', 'pos' => '(n)'],
                'Crop/Harvest' => ['id' => 'Panen', 'pos' => '(n)']
            ],
            'nominal' => [
                'Extinct' => ['id' => 'Punah', 'pos' => '(adj)']
            ],
            'passive' => [
                'Ecosystem' => ['id' => 'Ekosistem', 'pos' => '(n)']
            ]
        ],
        'Future Continuous' => [
            'verbal' => [
                'Change' => ['id' => 'Berubah', 'pos' => '(v)']
            ],
            'nominal' => [
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => [
                'Outer space' => ['id' => 'Luar angkasa', 'pos' => '(n)']
            ]
        ],
        'Future Perfect' => [
            'verbal' => [
                'Damage' => ['id' => 'Kerusakan', 'pos' => '(n)'],
                'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
                'Destroy' => ['id' => 'Merusak', 'pos' => '(v)']
            ],
            'nominal' => [
                'Developing country' => ['id' => 'Negara berkembang', 'pos' => '(n)'],
                'Developed country' => ['id' => 'Negara maju', 'pos' => '(n)']
            ],
            'passive' => []
        ],
        'Future Perfect Continuous' => [
            'verbal' => [
                'Build' => ['id' => 'Membangun', 'pos' => '(v)'],
                'Project' => ['id' => 'Proyek', 'pos' => '(n)']
            ],
            'nominal' => [
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => [
                'Air' => ['id' => 'Udara', 'pos' => '(n)'],
                'Pollution' => ['id' => 'Polusi', 'pos' => '(n)']
            ]
        ],
        'Simple Past Future' => [
            'verbal' => [
                'Destroy' => ['id' => 'Merusak', 'pos' => '(v)']
            ],
            'nominal' => [
                'Problem' => ['id' => 'Masalah', 'pos' => '(n)']
            ],
            'passive' => [
                'Disaster' => ['id' => 'Bencana', 'pos' => '(n)']
            ]
        ],
        'Past Future Continuous' => [
            'verbal' => [
                'Disappear' => ['id' => 'Menghilang', 'pos' => '(v)']
            ],
            'nominal' => [
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => [
                'Moon' => ['id' => 'Bulan', 'pos' => '(n)']
            ]
        ],
        'Past Future Perfect' => [
            'verbal' => [
                'Technology' => ['id' => 'Teknologi', 'pos' => '(n)'],
                'Develop' => ['id' => 'Berkembang', 'pos' => '(v)']
            ],
            'nominal' => [
                'Harmony' => ['id' => 'Harmoni', 'pos' => '(n)']
            ],
            'passive' => [
                'War' => ['id' => 'Perang', 'pos' => '(n)']
            ]
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => [
                'Walk' => ['id' => 'Berjalan', 'pos' => '(v)']
            ],
            'nominal' => [
                'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)']
            ],
            'passive' => [
                'Peace' => ['id' => 'Perdamaian', 'pos' => '(n)']
            ]
        ],
        'Modal' => [
            'verbal' => [
                'Company' => ['id' => 'Perusahaan', 'pos' => '(n)'],
                'Pay attention' => ['id' => 'Memperhatikan', 'pos' => '(v)'],
                'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
                'Must' => ['id' => 'Harus', 'pos' => '(modal)']
            ],
            'nominal' => [
                'Rare animal' => ['id' => 'Hewan langka', 'pos' => '(n)'],
                'Habitat' => ['id' => 'Habitat', 'pos' => '(n)'],
                'Should' => ['id' => 'Seharusnya', 'pos' => '(modal)']
            ],
            'passive' => [
                'Water' => ['id' => 'Air', 'pos' => '(n)'],
                'Can' => ['id' => 'Bisa', 'pos' => '(modal)']
            ]
        ]
    ];

}
