<?php

namespace App\Application\GrammarWriting;

class GrammarWritingDataRepository
{

    public $meeting5TenseExamples = [
        'Simple Present' => [
            'verbal' => ['id' => 'Peneliti tidak mengabaikan temuan statistik yang signifikan.', 'en' => 'Researchers do not ignore significant statistical findings'],
            'nominal' => ['id' => 'Fasilitas ini bukan merupakan laboratorium utama.', 'en' => 'This facility is not the primary laboratory'],
            'passive' => ['id' => 'Laporan tahunan tersebut tidak dipublikasikan secara terbuka.', 'en' => 'The annual report is not published openly']
        ],
        'Present Continuous' => [
            'verbal' => ['id' => 'Para analis tidak sedang mengabaikan fluktuasi pasar.', 'en' => 'The analysts are not ignoring market fluctuations'],
            'nominal' => ['id' => 'Kebijakan tersebut tidak sedang menjadi hambatan regulasi.', 'en' => 'The policy is not being a regulatory hindrance'],
            'passive' => ['id' => 'Instrumen ilmiah tersebut tidak sedang dikalibrasi.', 'en' => 'The scientific instrument is not being calibrated']
        ],
        'Present Perfect' => [
            'verbal' => ['id' => 'Tim peneliti belum menyelesaikan evaluasi komprehensif.', 'en' => 'The research team has not completed the comprehensive evaluation'],
            'nominal' => ['id' => 'Perusahaan tersebut belum pernah menjadi pimpinan pasar.', 'en' => 'The company has not been a market leader'],
            'passive' => ['id' => 'Dokumen rahasia tersebut belum disebarkan ke publik.', 'en' => 'The confidential document has not been distributed to the public']
        ],
        'Present Perfect Continuous' => [
            'verbal' => ['id' => 'Para ilmuwan belum sedang mengamati fenomena tersebut.', 'en' => 'The scientists have not been observing the phenomenon'],
            'nominal' => ['id' => 'Otoritas terkait belum sedang menjadi transparan.', 'en' => 'The relevant authority has not been being transparent'],
            'passive' => ['id' => 'Infrastruktur tersebut belum sedang direnovasi.', 'en' => 'The infrastructure has not been being renovated']
        ],
        'Simple Past' => [
            'verbal' => ['id' => 'Dewan direksi tidak menyetujui usulan akuisisi kemarin.', 'en' => 'The board of directors did not approve the acquisition proposal yesterday'],
            'nominal' => ['id' => 'Hasil eksperimen tersebut tidak konsisten minggu lalu.', 'en' => 'The experimental results were not consistent last week'],
            'passive' => ['id' => 'Keputusan strategis tersebut tidak diambil tanpa pertimbangan.', 'en' => 'The strategic decision was not made without consideration']
        ],
        'Past Continuous' => [
            'verbal' => ['id' => 'Tim investigasi tidak sedang menginspeksi lokasi saat kejadian.', 'en' => 'The investigation team was not inspecting the site during the incident'],
            'nominal' => ['id' => 'Kondisi ekonomi tidak sedang menjadi stabil pada periode itu.', 'en' => 'The economic condition was not being stable during that period'],
            'passive' => ['id' => 'Data mentah tersebut tidak sedang diolah oleh sistem.', 'en' => 'The raw data was not being processed by the system']
        ],
        'Past Perfect' => [
            'verbal' => ['id' => 'Perusahaan belum mengimplementasikan sistem baru sebelum krisis.', 'en' => 'The company had not implemented the new system before the crisis'],
            'nominal' => ['id' => 'Proyek tersebut belum pernah menjadi prioritas sebelumnya.', 'en' => 'The project had not been a priority before'],
            'passive' => ['id' => 'Naskah akademik tersebut belum diterbitkan sebelum tahun 2020.', 'en' => 'The academic manuscript had not been published before 2020']
        ],
        'Past Perfect Continuous' => [
            'verbal' => ['id' => 'Para peneliti belum sedang menganalisis sampel selama tiga bulan.', 'en' => 'The researchers had not been analyzing samples for three months'],
            'nominal' => ['id' => 'Sektor finansial belum sedang menjadi produktif.', 'en' => 'The financial sector had not been being productive'],
            'passive' => ['id' => 'Gedung cagar budaya tersebut belum sedang dipugar.', 'en' => 'The heritage building had not been being restored']
        ],
        'Simple Future' => [
            'verbal' => ['id' => 'Manajemen tidak akan mengeksekusi rencana tanpa verifikasi.', 'en' => 'Management will not execute the plan without verification'],
            'nominal' => ['id' => 'Proses adaptasi teknologi tidak akan mudah.', 'en' => 'The technology adaptation process will not be easy'],
            'passive' => ['id' => 'Pelanggaran etik tersebut tidak akan ditoleransi oleh komite.', 'en' => 'The ethical violation will not be tolerated by the committee']
        ],
        'Future Continuous' => [
            'verbal' => ['id' => 'Delegasi internasional tidak akan sedang berdiskusi besok pagi.', 'en' => 'The international delegation will not be discussing tomorrow morning'],
            'nominal' => ['id' => 'Manajer tidak akan sedang menjadi kaku dalam negosiasi.', 'en' => 'The manager will not be being rigid in negotiations'],
            'passive' => ['id' => 'Fasilitas manufaktur tidak akan sedang diuji coba.', 'en' => 'The manufacturing facility will not be being tested']
        ],
        'Future Perfect' => [
            'verbal' => ['id' => 'Tim tidak akan sudah mencapai kesepakatan pada pukul lima.', 'en' => 'The team will not have reached an agreement by five oclock'],
            'nominal' => ['id' => 'Infrastruktur baru tidak akan sudah siap pada kuartal depan.', 'en' => 'The new infrastructure will not have been ready by next quarter'],
            'passive' => ['id' => 'Proyek penelitian tidak akan sudah diselesaikan akhir tahun ini.', 'en' => 'The research project will not have been completed by the end of this year']
        ],
        'Future Perfect Continuous' => [
            'verbal' => ['id' => 'Para pakar tidak akan sudah sedang meneliti masalah tersebut.', 'en' => 'The experts will not have been researching that issue for long'],
            'nominal' => ['id' => 'Kondisi tidak akan sudah sedang menjadi kondusif.', 'en' => 'Conditions will not have been being conducive'],
            'passive' => ['id' => 'Jaringan komunikasi tidak akan sudah sedang diperbarui.', 'en' => 'The communication network will not have been being upgraded']
        ],
        'Simple Past Future' => [
            'verbal' => ['id' => 'Pemerintah tidak akan menerapkan sanksi ekstrem.', 'en' => 'The government would not enforce extreme sanctions'],
            'nominal' => ['id' => 'Asumsi awal tersebut tidak akan akurat.', 'en' => 'The initial assumption would not be accurate'],
            'passive' => ['id' => 'Rekomendasi teknis tersebut tidak akan ditolak oleh dewan.', 'en' => 'The technical recommendation would not be rejected by the board']
        ],
        'Past Future Continuous' => [
            'verbal' => ['id' => 'Para ilmuwan tidak akan sedang melakukan uji klinis.', 'en' => 'The scientists would not be conducting clinical trials'],
            'nominal' => ['id' => 'Otoritas tidak akan sedang menjadi kooperatif.', 'en' => 'The authority would not be being cooperative'],
            'passive' => ['id' => 'Sistem jaringan tidak akan sedang diperbaiki.', 'en' => 'The network system would not be being repaired']
        ],
        'Past Future Perfect' => [
            'verbal' => ['id' => 'Tim riset tidak akan sudah melupakan protokol keselamatan.', 'en' => 'The research team would not have forgotten the safety protocol'],
            'nominal' => ['id' => 'Eksperimen tersebut tidak akan sudah menjadi sukses.', 'en' => 'The experiment would not have been successful'],
            'passive' => ['id' => 'Laporan evaluasi tidak akan sudah diserahkan.', 'en' => 'The evaluation report would not have been submitted']
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => ['id' => 'Mereka tidak akan sudah sedang bernegosiasi.', 'en' => 'They would not have been negotiating'],
            'nominal' => ['id' => 'Situasi tidak akan sudah sedang menjadi stabil.', 'en' => 'The situation would not have been being stable'],
            'passive' => ['id' => 'Dokumen hukum tidak akan sudah sedang direvisi.', 'en' => 'The legal document would not have been being revised']
        ],
        'Modal' => [
            'verbal' => ['id' => 'Staf peneliti tidak boleh memanipulasi data eksperimen.', 'en' => 'Research staff must not manipulate experimental data'],
            'nominal' => ['id' => 'Hipotesis tersebut mungkin tidak valid.', 'en' => 'The hypothesis might not be valid'],
            'passive' => ['id' => 'Pintu laboratorium tidak bisa diakses tanpa otorisasi.', 'en' => 'The laboratory door cannot be accessed without authorization']
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

        public $meeting12Questions = array (
  1 => 
  array (
    'id' => 'Burung-burung Trumpeter lebih suka dengan kanopi yang tebal untuk menyediakan perlindungan dan penutup di sarang mereka.',
    'en' => 'Trumpeter birds more prefer thick canopy to provide protection and cover on their nests',
    'type' => 'fanboys',
    'conjunction' => 'and (dan)',
    'example' => 
    array (
      'id' => 'Burung mencari tempat teduh untuk sarang mereka.',
      'en' => 'Birds seek shade for their nests.',
    ),
    'vocab' => 
    array (
      'Trumpeter bird' => 
      array (
        'id' => 'Burung Trumpeter',
        'pos' => '(n)',
      ),
      'Prefer' => 
      array (
        'id' => 'Lebih suka',
        'pos' => '(v)',
      ),
      'Thick canopy' => 
      array (
        'id' => 'Kanopi yang tebal',
        'pos' => '(n)',
      ),
      'Provide' => 
      array (
        'id' => 'Menyediakan',
        'pos' => '(v)',
      ),
      'Protection' => 
      array (
        'id' => 'Perlindungan',
        'pos' => '(n)',
      ),
      'Cover' => 
      array (
        'id' => 'Penutup',
        'pos' => '(n)',
      ),
      'Nest' => 
      array (
        'id' => 'Sarang',
        'pos' => '(n)',
      ),
    ),
  ),
  2 => 
  array (
    'id' => 'Perencanaan dari proyek baru termasuk dari pendesainan, perhitungan biaya, dan pembangunan.',
    'en' => 'The planning of the new project includes designing, cost calculation, and construction',
    'type' => 'fanboys',
    'conjunction' => 'and (dan)',
    'example' => 
    array (
      'id' => 'Proyek ini mencakup analisis dan implementasi.',
      'en' => 'This project includes analysis and implementation.',
    ),
    'vocab' => 
    array (
      'Planning' => 
      array (
        'id' => 'Perencanaan',
        'pos' => '(n)',
      ),
      'New project' => 
      array (
        'id' => 'Proyek baru',
        'pos' => '(n)',
      ),
      'Include' => 
      array (
        'id' => 'Termasuk / Mencakup',
        'pos' => '(v)',
      ),
      'Designing' => 
      array (
        'id' => 'Pendesainan',
        'pos' => '(n/gerund)',
      ),
      'Cost calculation' => 
      array (
        'id' => 'Perhitungan biaya',
        'pos' => '(n)',
      ),
      'Construction' => 
      array (
        'id' => 'Pembangunan',
        'pos' => '(n)',
      ),
    ),
  ),
  3 => 
  array (
    'id' => 'Permintaan, kecantikan, keawetan, kelangkaan, dan kesempurnaan dari potongan menentukan nilai dari batu berharga.',
    'en' => 'Demand, beauty, durability, rarity, and perfection of the cut determine the value of precious stones',
    'type' => 'fanboys',
    'conjunction' => 'and (dan)',
    'example' => 
    array (
      'id' => 'Kualitas dan warna menentukan harga permata.',
      'en' => 'Quality and color determine the gemstone price.',
    ),
    'vocab' => 
    array (
      'Demand' => 
      array (
        'id' => 'Permintaan',
        'pos' => '(n)',
      ),
      'Beauty' => 
      array (
        'id' => 'Kecantikan',
        'pos' => '(n)',
      ),
      'Durability' => 
      array (
        'id' => 'Keawetan',
        'pos' => '(n)',
      ),
      'Rarity' => 
      array (
        'id' => 'Kelangkaan',
        'pos' => '(n)',
      ),
      'Perfection of the cut' => 
      array (
        'id' => 'Kesempurnaan dari potongan',
        'pos' => '(n)',
      ),
      'Determine' => 
      array (
        'id' => 'Menentukan',
        'pos' => '(v)',
      ),
      'Precious stone' => 
      array (
        'id' => 'Batu berharga',
        'pos' => '(n)',
      ),
    ),
  ),
  4 => 
  array (
    'id' => 'Perkembangan bayi dipengaruhi oleh keturunan dan oleh lingkungan.',
    'en' => 'Infant development is influenced by heredity and by the environment',
    'type' => 'fanboys',
    'conjunction' => 'and (dan)',
    'example' => 
    array (
      'id' => 'Pertumbuhan anak dipengaruhi oleh nutrisi dan pola asuh.',
      'en' => 'Child growth is influenced by nutrition and parenting.',
    ),
    'vocab' => 
    array (
      'Infant development' => 
      array (
        'id' => 'Perkembangan bayi',
        'pos' => '(n)',
      ),
      'Influence' => 
      array (
        'id' => 'Mempengaruhi / Dipengaruhi',
        'pos' => '(v)',
      ),
      'Heredity' => 
      array (
        'id' => 'Keturunan',
        'pos' => '(n)',
      ),
      'Environment' => 
      array (
        'id' => 'Lingkungan',
        'pos' => '(n)',
      ),
    ),
  ),
  5 => 
  array (
    'id' => 'Terumbu karang terpengaruhi oleh perubahan iklim dan dasar samudra dipengaruhi oleh sampah plastik.',
    'en' => 'Coral reefs are affected by climate change, and the ocean floor is affected by plastic waste',
    'type' => 'fanboys',
    'conjunction' => 'and (dan)',
    'example' => 
    array (
      'id' => 'Hutan terancam deforestasi, dan satwa terancam perburuan.',
      'en' => 'Forests are threatened by deforestation, and animals are threatened by poaching.',
    ),
    'vocab' => 
    array (
      'Coral reef' => 
      array (
        'id' => 'Terumbu karang',
        'pos' => '(n)',
      ),
      'Climate change' => 
      array (
        'id' => 'Perubahan iklim',
        'pos' => '(n)',
      ),
      'Ocean floor' => 
      array (
        'id' => 'Dasar samudra',
        'pos' => '(n)',
      ),
      'Plastic waste' => 
      array (
        'id' => 'Sampah plastik',
        'pos' => '(n)',
      ),
      'Affect' => 
      array (
        'id' => 'Mempengaruhi / Terpengaruhi',
        'pos' => '(v)',
      ),
    ),
  ),
  6 => 
  array (
    'id' => 'Hutan harus dilindungi, diamankan, dan dilestarikan untuk generasi mendatang.',
    'en' => 'Forests must be protected, secured, and preserved for future generations',
    'type' => 'fanboys',
    'conjunction' => 'and (dan)',
    'example' => 
    array (
      'id' => 'Sumber air harus dijaga dan dilindungi untuk masa depan.',
      'en' => 'Water sources must be maintained and protected for the future.',
    ),
    'vocab' => 
    array (
      'Forest' => 
      array (
        'id' => 'Hutan',
        'pos' => '(n)',
      ),
      'Protect' => 
      array (
        'id' => 'Dilindungi',
        'pos' => '(v)',
      ),
      'Secure' => 
      array (
        'id' => 'Diamankan',
        'pos' => '(v)',
      ),
      'Preserve' => 
      array (
        'id' => 'Dilestarikan',
        'pos' => '(v)',
      ),
      'Future generations' => 
      array (
        'id' => 'Generasi mendatang',
        'pos' => '(n)',
      ),
    ),
  ),
  7 => 
  array (
    'id' => 'Kepolisian bertugas menjaga negara dan tentara bertugas mempertahankan negara.',
    'en' => 'The police are tasked with guarding the country, and the army is tasked with defending the country',
    'type' => 'fanboys',
    'conjunction' => 'and (dan)',
    'example' => 
    array (
      'id' => 'Dokter merawat pasien, dan perawat membantu pemulihan.',
      'en' => 'Doctors treat patients, and nurses assist in recovery.',
    ),
    'vocab' => 
    array (
      'Police' => 
      array (
        'id' => 'Kepolisian',
        'pos' => '(n)',
      ),
      'Tasked with' => 
      array (
        'id' => 'Bertugas',
        'pos' => '(phrase)',
      ),
      'Guard' => 
      array (
        'id' => 'Menjaga',
        'pos' => '(v)',
      ),
      'Army' => 
      array (
        'id' => 'Tentara',
        'pos' => '(n)',
      ),
      'Defend' => 
      array (
        'id' => 'Mempertahankan',
        'pos' => '(v)',
      ),
      'Country' => 
      array (
        'id' => 'Negara',
        'pos' => '(n)',
      ),
    ),
  ),
  8 => 
  array (
    'id' => 'Kita harus mencari solusi dari masalah ini atau negara kita akan menghadapi masalah yang serius.',
    'en' => 'We must find a solution to this problem, or our country will face serious problems',
    'type' => 'fanboys',
    'conjunction' => 'or (atau)',
    'example' => 
    array (
      'id' => 'Kita harus bertindak sekarang, atau kita akan terlambat.',
      'en' => 'We must act now, or we will be too late.',
    ),
    'vocab' => 
    array (
      'Find a solution' => 
      array (
        'id' => 'Mencari solusi',
        'pos' => '(phrase)',
      ),
      'Problem' => 
      array (
        'id' => 'Masalah',
        'pos' => '(n)',
      ),
      'Our country' => 
      array (
        'id' => 'Negara kita',
        'pos' => '(n)',
      ),
      'Face' => 
      array (
        'id' => 'Menghadapi',
        'pos' => '(v)',
      ),
      'Serious problem' => 
      array (
        'id' => 'Masalah yang serius',
        'pos' => '(n)',
      ),
    ),
  ),
  9 => 
  array (
    'id' => 'Penelitian genetik telah memberikan banyak kontribusi kepada masyarakat namun banyak orang yang masih tidak setuju dengan bidang ini.',
    'en' => 'Genetic research has made many contributions to society, yet many people still disagree with this field',
    'type' => 'fanboys',
    'conjunction' => 'yet / but (namun)',
    'example' => 
    array (
      'id' => 'Teknologi membawa manfaat, namun beberapa pihak masih ragu.',
      'en' => 'Technology brings benefits, yet some parties remain doubtful.',
    ),
    'vocab' => 
    array (
      'Genetic research' => 
      array (
        'id' => 'Penelitian genetik',
        'pos' => '(n)',
      ),
      'Contribution' => 
      array (
        'id' => 'Kontribusi',
        'pos' => '(n)',
      ),
      'Society' => 
      array (
        'id' => 'Masyarakat',
        'pos' => '(n)',
      ),
      'Disagree' => 
      array (
        'id' => 'Tidak setuju',
        'pos' => '(v)',
      ),
      'Field' => 
      array (
        'id' => 'Bidang',
        'pos' => '(n)',
      ),
    ),
  ),
  10 => 
  array (
    'id' => 'Sayangnya, ini saat sekarang hampir mustahil untuk memprediksi kesuksesan dari spesies invasif, tidak juga kita bisa membuat prediksi daftar dari penginvasi.',
    'en' => 'Unfortunately, it is currently almost impossible to predict the success of invasive species, nor can we make a predicted list of invaders',
    'type' => 'fanboys',
    'conjunction' => 'nor (tidak juga)',
    'example' => 
    array (
      'id' => 'Dia tidak dapat datang, dan tidak juga dia memberi kabar.',
      'en' => 'He cannot come, nor did he give notice.',
    ),
    'vocab' => 
    array (
      'Unfortunately' => 
      array (
        'id' => 'Sayangnya',
        'pos' => '(adv)',
      ),
      'Currently' => 
      array (
        'id' => 'Saat sekarang',
        'pos' => '(adv)',
      ),
      'Almost impossible' => 
      array (
        'id' => 'Hampir mustahil',
        'pos' => '(phrase)',
      ),
      'Predict' => 
      array (
        'id' => 'Memprediksi',
        'pos' => '(v)',
      ),
      'Invasive species' => 
      array (
        'id' => 'Spesies invasif',
        'pos' => '(n)',
      ),
      'Invader' => 
      array (
        'id' => 'Penginvasi',
        'pos' => '(n)',
      ),
    ),
  ),
  11 => 
  array (
    'id' => 'Pengoperasian dari sistem ini tidak menyebabkan kehilangan biodiversitas dalam lingkungan alam. Tidak juga terdapat bukti untuk membangun aturan yang ketat.',
    'en' => 'The operation of this system does not cause loss of biodiversity in the natural environment, nor is there evidence to establish strict regulations',
    'type' => 'fanboys',
    'conjunction' => 'nor (tidak juga)',
    'example' => 
    array (
      'id' => 'Pabrik tidak mencemari sungai, dan tidak juga melanggar baku mutu.',
      'en' => 'The factory does not pollute the river, nor does it violate standards.',
    ),
    'vocab' => 
    array (
      'Operation' => 
      array (
        'id' => 'Pengoperasian',
        'pos' => '(n)',
      ),
      'Loss of biodiversity' => 
      array (
        'id' => 'Kehilangan biodiversitas',
        'pos' => '(phrase)',
      ),
      'Natural environment' => 
      array (
        'id' => 'Lingkungan alam',
        'pos' => '(n)',
      ),
      'Evidence' => 
      array (
        'id' => 'Bukti',
        'pos' => '(n)',
      ),
      'Establish' => 
      array (
        'id' => 'Membangun / Menetapkan',
        'pos' => '(v)',
      ),
      'Strict regulations' => 
      array (
        'id' => 'Aturan yang ketat',
        'pos' => '(n)',
      ),
    ),
  ),
  12 => 
  array (
    'id' => 'Dalam beberapa situasi, kapasitas untuk terbang menjadi tidak diperlukan, sehingga ini ditinggalkan.',
    'en' => 'In some situations, the capacity to fly becomes unnecessary, so it is abandoned',
    'type' => 'fanboys',
    'conjunction' => 'so (sehingga)',
    'example' => 
    array (
      'id' => 'Fitur tersebut jarang dipakai, sehingga dihapus.',
      'en' => 'The feature was rarely used, so it was removed.',
    ),
    'vocab' => 
    array (
      'Situation' => 
      array (
        'id' => 'Situasi',
        'pos' => '(n)',
      ),
      'Capacity to fly' => 
      array (
        'id' => 'Kapasitas untuk terbang',
        'pos' => '(phrase)',
      ),
      'Unnecessary' => 
      array (
        'id' => 'Tidak diperlukan',
        'pos' => '(adj)',
      ),
      'Abandoned' => 
      array (
        'id' => 'Ditinggalkan',
        'pos' => '(v3)',
      ),
    ),
  ),
  13 => 
  array (
    'id' => 'Penelitian menunjukkan bahwa kelompok experimental tidak menunjukkan perubahan signifikan dalam kinerja kognitif mereka setelah intervensi, tidak juga group kendali.',
    'en' => 'Research shows that the experimental group did not show significant changes in their cognitive performance after the intervention, nor did the control group',
    'type' => 'fanboys',
    'conjunction' => 'nor (tidak juga)',
    'example' => 
    array (
      'id' => 'Siswa kelas A tidak mengalami penurunan nilai, dan tidak juga kelas B.',
      'en' => 'Class A students saw no score drop, nor did Class B.',
    ),
    'vocab' => 
    array (
      'Experimental group' => 
      array (
        'id' => 'Kelompok experimental',
        'pos' => '(n)',
      ),
      'Significant change' => 
      array (
        'id' => 'Perubahan signifikan',
        'pos' => '(n)',
      ),
      'Cognitive performance' => 
      array (
        'id' => 'Kinerja kognitif',
        'pos' => '(n)',
      ),
      'Intervention' => 
      array (
        'id' => 'Intervensi',
        'pos' => '(n)',
      ),
      'Control group' => 
      array (
        'id' => 'Grup kendali',
        'pos' => '(n)',
      ),
    ),
  ),
  14 => 
  array (
    'id' => 'Penurunan nilai ekonomi mempengaruhi pasar saham, sehingga hal ini juga menghasilkan kehilangan pekerjaan yang meluas ke berbagai industri.',
    'en' => 'The economic decline affects the stock market, so this also results in widespread job losses across various industries',
    'type' => 'fanboys',
    'conjunction' => 'so (sehingga)',
    'example' => 
    array (
      'id' => 'Inflasi meningkat tinggi, sehingga daya beli masyarakat menurun.',
      'en' => 'Inflation rose high, so public purchasing power decreased.',
    ),
    'vocab' => 
    array (
      'Economic decline' => 
      array (
        'id' => 'Penurunan nilai ekonomi',
        'pos' => '(n)',
      ),
      'Stock market' => 
      array (
        'id' => 'Pasar saham',
        'pos' => '(n)',
      ),
      'Affect' => 
      array (
        'id' => 'Mempengaruhi',
        'pos' => '(v)',
      ),
      'Result in' => 
      array (
        'id' => 'Menghasilkan',
        'pos' => '(v)',
      ),
      'Widespread job loss' => 
      array (
        'id' => 'Kehilangan pekerjaan yang meluas',
        'pos' => '(n)',
      ),
      'Various industries' => 
      array (
        'id' => 'Berbagai industri',
        'pos' => '(n)',
      ),
    ),
  ),
  15 => 
  array (
    'id' => 'Ilmuwan dan ahli lingkungan sedang semakin khawatir mengenai dampak dari perubahan iklim terhadap ekosistem laut, tidak juga masalah ini bisa diabaikan.',
    'en' => 'Scientists and environmentalists are increasingly worried about the impact of climate change on marine ecosystems, nor can this problem be ignored',
    'type' => 'fanboys',
    'conjunction' => 'nor (tidak juga)',
    'example' => 
    array (
      'id' => 'Pakar riset cemas akan polusi udara, dan isu ini tidak bisa disepelekan.',
      'en' => 'Researchers worry about air pollution, nor can this issue be downplayed.',
    ),
    'vocab' => 
    array (
      'Scientist' => 
      array (
        'id' => 'Ilmuwan',
        'pos' => '(n)',
      ),
      'Environmentalist' => 
      array (
        'id' => 'Ahli lingkungan',
        'pos' => '(n)',
      ),
      'Increasingly worried' => 
      array (
        'id' => 'Semakin khawatir',
        'pos' => '(phrase)',
      ),
      'Impact' => 
      array (
        'id' => 'Dampak',
        'pos' => '(n)',
      ),
      'Marine ecosystem' => 
      array (
        'id' => 'Ekosistem laut',
        'pos' => '(n)',
      ),
      'Ignored' => 
      array (
        'id' => 'Diabaikan',
        'pos' => '(v3)',
      ),
    ),
  ),
  16 => 
  array (
    'id' => 'Banyak orang menolak AI. Namun begitu kemajuan dari kecerdasan buatan telah merevolusi berbagai industri dari bidang kesehatan hingga keuangan.',
    'en' => 'Many people reject AI, yet advancements in artificial intelligence have revolutionized various industries from healthcare to finance',
    'type' => 'fanboys',
    'conjunction' => 'yet (namun begitu)',
    'example' => 
    array (
      'id' => 'Banyak yang menolak metode baru, namun hasilnya terbukti efektif.',
      'en' => 'Many rejected the new method, yet its results proved effective.',
    ),
    'vocab' => 
    array (
      'Reject' => 
      array (
        'id' => 'Menolak',
        'pos' => '(v)',
      ),
      'Advancement' => 
      array (
        'id' => 'Kemajuan',
        'pos' => '(n)',
      ),
      'Artificial intelligence' => 
      array (
        'id' => 'Kecerdasan buatan',
        'pos' => '(n)',
      ),
      'Revolutionize' => 
      array (
        'id' => 'Merevolusi',
        'pos' => '(v)',
      ),
      'Healthcare' => 
      array (
        'id' => 'Bidang kesehatan',
        'pos' => '(n)',
      ),
      'Finance' => 
      array (
        'id' => 'Keuangan',
        'pos' => '(n)',
      ),
    ),
  ),
  17 => 
  array (
    'id' => 'Karenakan media sosial memiliki peran yang kuat dalam membentuk arah politik, ini telah menjadi point utama dalam berbagai penelitian akademik dan debat publik.',
    'en' => 'Social media has a strong role in shaping political direction, for it has become a focal point in various academic studies and public debates',
    'type' => 'fanboys',
    'conjunction' => 'for (karenakan / sebab)',
    'example' => 
    array (
      'id' => 'Isu ini sangat krusial, sebab menentukan masa depan organisasi.',
      'en' => 'This issue is very crucial, for it determines the organization future.',
    ),
    'vocab' => 
    array (
      'Social media' => 
      array (
        'id' => 'Media sosial',
        'pos' => '(n)',
      ),
      'Strong role' => 
      array (
        'id' => 'Peran yang kuat',
        'pos' => '(n)',
      ),
      'Shape political direction' => 
      array (
        'id' => 'Membentuk arah politik',
        'pos' => '(phrase)',
      ),
      'Focal point' => 
      array (
        'id' => 'Poin utama',
        'pos' => '(n)',
      ),
      'Academic study' => 
      array (
        'id' => 'Penelitian akademik',
        'pos' => '(n)',
      ),
      'Public debate' => 
      array (
        'id' => 'Debat publik',
        'pos' => '(n)',
      ),
    ),
  ),
  18 => 
  array (
    'id' => 'Implikasi etis dari modifikasi gen telah menyalakan debat di antara para ilmuwan, pembuat kebijakan, dan publik. Namun, masyarakat telah merasakan manfaatnya secara langsung.',
    'en' => 'The ethical implications of gene modification have sparked debate among scientists, policymakers, and the public, but society has directly experienced its benefits',
    'type' => 'fanboys',
    'conjunction' => 'but / yet (namun)',
    'example' => 
    array (
      'id' => 'Teknologi ini memicu perdebatan, namun manfaatnya sudah terasa.',
      'en' => 'This technology sparked debate, but its benefits are already felt.',
    ),
    'vocab' => 
    array (
      'Ethical implications' => 
      array (
        'id' => 'Implikasi etis',
        'pos' => '(n)',
      ),
      'Gene modification' => 
      array (
        'id' => 'Modifikasi gen',
        'pos' => '(n)',
      ),
      'Spark debate' => 
      array (
        'id' => 'Menyalakan / Memicu debat',
        'pos' => '(phrase)',
      ),
      'Policymakers' => 
      array (
        'id' => 'Pembuat kebijakan',
        'pos' => '(n)',
      ),
      'Directly' => 
      array (
        'id' => 'Secara langsung',
        'pos' => '(adv)',
      ),
      'Benefit' => 
      array (
        'id' => 'Manfaat',
        'pos' => '(n)',
      ),
    ),
  ),
  19 => 
  array (
    'id' => 'Sampai kekebalan kelompok yang memadai tercapai secara komprehensif, otoritas kesehatan terus memantau mutasi patogen secara ketat.',
    'en' => 'Until adequate herd immunity is comprehensively achieved, health authorities continually monitor pathogen mutations closely',
    'type' => 'time',
    'pos_type' => 'initial',
    'conjunction' => 'until (sampai / hingga)',
    'example' => 
    array (
      'id' => 'Sebelum rapat dimulai, peserta membaca dokumen.',
      'en' => 'Before the meeting started, attendees read documents.',
    ),
    'vocab' => 
    array (
      'Until' => 
      array (
        'id' => 'Sampai / Hingga',
        'pos' => '(conj)',
      ),
      'Adequate' => 
      array (
        'id' => 'Memadai',
        'pos' => '(adj)',
      ),
      'Herd immunity' => 
      array (
        'id' => 'Kekebalan kelompok',
        'pos' => '(n)',
      ),
      'Comprehensively' => 
      array (
        'id' => 'Secara komprehensif',
        'pos' => '(adv)',
      ),
      'Health authority' => 
      array (
        'id' => 'Otoritas kesehatan',
        'pos' => '(n)',
      ),
      'Continually monitor' => 
      array (
        'id' => 'Terus memantau',
        'pos' => '(v)',
      ),
      'Pathogen mutation' => 
      array (
        'id' => 'Mutasi patogen',
        'pos' => '(n)',
      ),
    ),
  ),
  20 => 
  array (
    'id' => 'Ketika instrumen teleskopik canggih mendeteksi anomali gelombang mikro, para astronom mengidentifikasi radiasi kosmik purba.',
    'en' => 'When sophisticated telescopic instruments detected microwave anomalies, astronomers identified ancient cosmic radiation',
    'type' => 'time',
    'pos_type' => 'initial',
    'conjunction' => 'when (ketika / saat)',
    'example' => 
    array (
      'id' => 'Ketika alarm berbunyi, petugas evakuasi bertindak.',
      'en' => 'When the alarm sounded, evacuation officers acted.',
    ),
    'vocab' => 
    array (
      'When' => 
      array (
        'id' => 'Ketika / Saat',
        'pos' => '(conj)',
      ),
      'Sophisticated' => 
      array (
        'id' => 'Canggih',
        'pos' => '(adj)',
      ),
      'Telescopic instrument' => 
      array (
        'id' => 'Instrumen teleskopik',
        'pos' => '(n)',
      ),
      'Detect' => 
      array (
        'id' => 'Mendeteksi',
        'pos' => '(v)',
      ),
      'Microwave anomaly' => 
      array (
        'id' => 'Anomali gelombang mikro',
        'pos' => '(n)',
      ),
      'Astronomer' => 
      array (
        'id' => 'Astronom',
        'pos' => '(n)',
      ),
      'Identify' => 
      array (
        'id' => 'Mengidentifikasi',
        'pos' => '(v)',
      ),
      'Cosmic radiation' => 
      array (
        'id' => 'Radiasi kosmik',
        'pos' => '(n)',
      ),
    ),
  ),
  21 => 
  array (
    'id' => 'Sebelum teknologi percetakan tipe bergerak diperkenalkan di Eropa Barat, diseminasi literatur ilmiah sangat terbatas.',
    'en' => 'Before movable-type printing technology was introduced in Western Europe, the dissemination of scientific literature was profoundly constrained',
    'type' => 'time',
    'pos_type' => 'initial',
    'conjunction' => 'before (sebelum)',
    'example' => 
    array (
      'id' => 'Sebelum eksperimen dimulai, lab disterilkan.',
      'en' => 'Before the experiment began, the lab was sterilized.',
    ),
    'vocab' => 
    array (
      'Before' => 
      array (
        'id' => 'Sebelum',
        'pos' => '(conj)',
      ),
      'Movable-type printing' => 
      array (
        'id' => 'Percetakan tipe bergerak',
        'pos' => '(n)',
      ),
      'Introduce' => 
      array (
        'id' => 'Diperkenalkan',
        'pos' => '(v)',
      ),
      'Dissemination' => 
      array (
        'id' => 'Diseminasi / Penyebaran',
        'pos' => '(n)',
      ),
      'Scientific literature' => 
      array (
        'id' => 'Literatur ilmiah',
        'pos' => '(n)',
      ),
      'Profoundly constrained' => 
      array (
        'id' => 'Sangat terbatas / Terhambat',
        'pos' => '(adj)',
      ),
    ),
  ),
  22 => 
  array (
    'id' => 'Karena sedimentasi aluvial sangat memperkaya kesuburan tanah, banyak peradaban agraris mendiami wilayah delta sungai.',
    'en' => 'Because alluvial sedimentation greatly enriched soil fertility, many agrarian civilizations inhabited river delta regions',
    'type' => 'cause',
    'pos_type' => 'initial',
    'conjunction' => 'because (karena)',
    'example' => 
    array (
      'id' => 'Karena iklim mendukung, hasil panen melimpah.',
      'en' => 'Because the climate was favorable, yields were abundant.',
    ),
    'vocab' => 
    array (
      'Because' => 
      array (
        'id' => 'Karena',
        'pos' => '(conj)',
      ),
      'Alluvial sedimentation' => 
      array (
        'id' => 'Sedimentasi aluvial',
        'pos' => '(n)',
      ),
      'Enrich soil fertility' => 
      array (
        'id' => 'Memperkaya kesuburan tanah',
        'pos' => '(v)',
      ),
      'Agrarian civilization' => 
      array (
        'id' => 'Peradaban agraris',
        'pos' => '(n)',
      ),
      'Inhabit' => 
      array (
        'id' => 'Mendiami / Menghuni',
        'pos' => '(v)',
      ),
      'River delta region' => 
      array (
        'id' => 'Wilayah delta sungai',
        'pos' => '(n)',
      ),
    ),
  ),
  23 => 
  array (
    'id' => 'Meskipun tantangan kestabilan medan magnet plasma masih sangat kompleks, eksperimen fusi nuklir tetap dilanjutkan.',
    'en' => 'Although the challenges of plasma magnetic field stability remain exceptionally complex, nuclear fusion experiments are still continued',
    'type' => 'contrast',
    'pos_type' => 'initial',
    'conjunction' => 'although (meskipun)',
    'example' => 
    array (
      'id' => 'Meskipun biaya tinggi, riset tetap berjalan.',
      'en' => 'Although costs were high, research continued.',
    ),
    'vocab' => 
    array (
      'Although' => 
      array (
        'id' => 'Meskipun / Walaupun',
        'pos' => '(conj)',
      ),
      'Stability challenge' => 
      array (
        'id' => 'Tantangan kestabilan',
        'pos' => '(n)',
      ),
      'Plasma magnetic field' => 
      array (
        'id' => 'Medan magnet plasma',
        'pos' => '(n)',
      ),
      'Exceptionally complex' => 
      array (
        'id' => 'Sangat kompleks',
        'pos' => '(adj)',
      ),
      'Nuclear fusion experiment' => 
      array (
        'id' => 'Eksperimen fusi nuklir',
        'pos' => '(n)',
      ),
      'Continue' => 
      array (
        'id' => 'Dilanjutkan',
        'pos' => '(v)',
      ),
    ),
  ),
  24 => 
  array (
    'id' => 'Paradigma sosioekonomi global, setelah otomatisasi industri berskala besar diterapkan, bertransformasi secara radikal.',
    'en' => 'The global socioeconomic paradigm, after large-scale industrial automation was implemented, transformed radically',
    'type' => 'time',
    'pos_type' => 'middle',
    'conjunction' => 'after (setelah)',
    'example' => 
    array (
      'id' => 'Perusahaan, setelah regulasi baru berlaku, meningkatkan standar keselamatan.',
      'en' => 'The company, after new rules took effect, upgraded safety standards.',
    ),
    'vocab' => 
    array (
      'Socioeconomic paradigm' => 
      array (
        'id' => 'Paradigma sosioekonomi',
        'pos' => '(n)',
      ),
      'After' => 
      array (
        'id' => 'Setelah',
        'pos' => '(conj)',
      ),
      'Large-scale' => 
      array (
        'id' => 'Berskala besar',
        'pos' => '(adj)',
      ),
      'Industrial automation' => 
      array (
        'id' => 'Otomatisasi industri',
        'pos' => '(n)',
      ),
      'Implement' => 
      array (
        'id' => 'Diterapkan',
        'pos' => '(v)',
      ),
      'Transform radically' => 
      array (
        'id' => 'Bertransformasi secara radikal',
        'pos' => '(v)',
      ),
    ),
  ),
  25 => 
  array (
    'id' => 'Pemodelan iklim global, sejak komputasi kuantum diterapkan dalam meteorologi modern, menjadi semakin presisi.',
    'en' => 'Global climate modeling, since quantum computing was implemented in modern meteorology, became increasingly precise',
    'type' => 'time',
    'pos_type' => 'middle',
    'conjunction' => 'since (sejak)',
    'example' => 
    array (
      'id' => 'Kualitas udara, sejak filter baru dipasang, membaik drastis.',
      'en' => 'Air quality, since new filters were installed, improved drastically.',
    ),
    'vocab' => 
    array (
      'Climate modeling' => 
      array (
        'id' => 'Pemodelan iklim',
        'pos' => '(n)',
      ),
      'Since' => 
      array (
        'id' => 'Sejak',
        'pos' => '(conj)',
      ),
      'Quantum computing' => 
      array (
        'id' => 'Komputasi kuantum',
        'pos' => '(n)',
      ),
      'Meteorology' => 
      array (
        'id' => 'Meteorologi',
        'pos' => '(n)',
      ),
      'Increasingly precise' => 
      array (
        'id' => 'Semakin presisi',
        'pos' => '(adj)',
      ),
    ),
  ),
  26 => 
  array (
    'id' => 'Model heliosentris, meskipun awalnya ditentang keras oleh kalangan ortodoks, akhirnya diakui sebagai landasan kosmologi modern.',
    'en' => 'The heliocentric model, although the notion was initially vehemently opposed by orthodox circles, was eventually acknowledged as the cornerstone of modern cosmology',
    'type' => 'contrast',
    'pos_type' => 'middle',
    'conjunction' => 'although (meskipun)',
    'example' => 
    array (
      'id' => 'Teori itu, meskipun diragukan pada awalnya, kini terbukti benar.',
      'en' => 'The theory, although initially doubted, is now proven correct.',
    ),
    'vocab' => 
    array (
      'Heliocentric model' => 
      array (
        'id' => 'Model heliosentris',
        'pos' => '(n)',
      ),
      'Although' => 
      array (
        'id' => 'Meskipun',
        'pos' => '(conj)',
      ),
      'Vehemently opposed' => 
      array (
        'id' => 'Ditentang keras',
        'pos' => '(v)',
      ),
      'Orthodox circles' => 
      array (
        'id' => 'Kalangan ortodoks',
        'pos' => '(n)',
      ),
      'Eventually acknowledged' => 
      array (
        'id' => 'Akhirnya diakui',
        'pos' => '(v)',
      ),
      'Cornerstone' => 
      array (
        'id' => 'Landasan / Batu penjuru',
        'pos' => '(n)',
      ),
      'Cosmology' => 
      array (
        'id' => 'Kosmologi',
        'pos' => '(n)',
      ),
    ),
  ),
  27 => 
  array (
    'id' => 'Keanekaragaman hayati ekosistem laut, jika eksploitasi terumbu karang dihentikan secara permanen, dapat dipertahankan secara optimal.',
    'en' => 'Marine ecosystem biodiversity, if coral reef exploitation is permanently halted, can be preserved optimally',
    'type' => 'condition',
    'pos_type' => 'middle',
    'conjunction' => 'if (jika)',
    'example' => 
    array (
      'id' => 'Populasi satwa, jika perburuan liar dilarang, akan pulih dengan cepat.',
      'en' => 'Wildlife populations, if poaching is banned, will recover quickly.',
    ),
    'vocab' => 
    array (
      'Biodiversity' => 
      array (
        'id' => 'Keanekaragaman hayati',
        'pos' => '(n)',
      ),
      'Marine ecosystem' => 
      array (
        'id' => 'Ekosistem laut',
        'pos' => '(n)',
      ),
      'If' => 
      array (
        'id' => 'Jika',
        'pos' => '(conj)',
      ),
      'Coral reef exploitation' => 
      array (
        'id' => 'Eksploitasi terumbu karang',
        'pos' => '(n)',
      ),
      'Permanently halted' => 
      array (
        'id' => 'Dihentikan secara permanen',
        'pos' => '(v)',
      ),
      'Preserve optimally' => 
      array (
        'id' => 'Dipertahankan secara optimal',
        'pos' => '(v)',
      ),
    ),
  ),
  28 => 
  array (
    'id' => 'Stabilitas fiskal nasional, kecuali jika reformasi perpajakan progresif diimplementasikan secara konsisten, akan memburuk secara drastis.',
    'en' => 'National fiscal stability, unless progressive tax reforms are implemented consistently, will deteriorate drastically',
    'type' => 'condition',
    'pos_type' => 'middle',
    'conjunction' => 'unless (kecuali jika)',
    'example' => 
    array (
      'id' => 'Perekonomian, kecuali jika suku bunga distabilkan, akan mengalami resesi.',
      'en' => 'The economy, unless interest rates are stabilized, will face a recession.',
    ),
    'vocab' => 
    array (
      'Fiscal stability' => 
      array (
        'id' => 'Stabilitas fiskal',
        'pos' => '(n)',
      ),
      'Unless' => 
      array (
        'id' => 'Kecuali jika',
        'pos' => '(conj)',
      ),
      'Progressive tax reform' => 
      array (
        'id' => 'Reformasi pajak progresif',
        'pos' => '(n)',
      ),
      'Implement consistently' => 
      array (
        'id' => 'Diimplementasikan secara konsisten',
        'pos' => '(v)',
      ),
      'Deteriorate drastically' => 
      array (
        'id' => 'Memburuk secara drastis',
        'pos' => '(v)',
      ),
    ),
  ),
  29 => 
  array (
    'id' => 'Sektor bioteknologi mengalami ekspansi eksponensial, sementara industri manufaktur konvensional menghadapi stagnasi berkepanjangan.',
    'en' => 'The biotechnology sector experiences exponential expansion, while conventional manufacturing industries face prolonged stagnation',
    'type' => 'time',
    'pos_type' => 'final',
    'conjunction' => 'while / whereas (sementara)',
    'example' => 
    array (
      'id' => 'Ekspor meningkat sementara impor menurun.',
      'en' => 'Exports rose while imports declined.',
    ),
    'vocab' => 
    array (
      'Biotechnology sector' => 
      array (
        'id' => 'Sektor bioteknologi',
        'pos' => '(n)',
      ),
      'Exponential expansion' => 
      array (
        'id' => 'Ekspansi eksponensial',
        'pos' => '(n)',
      ),
      'While / Whereas' => 
      array (
        'id' => 'Sementara',
        'pos' => '(conj)',
      ),
      'Conventional manufacturing' => 
      array (
        'id' => 'Manufaktur konvensional',
        'pos' => '(n)',
      ),
      'Prolonged stagnation' => 
      array (
        'id' => 'Stagnasi berkepanjangan',
        'pos' => '(n)',
      ),
    ),
  ),
  30 => 
  array (
    'id' => 'Efisiensi termodinamika meningkat secara signifikan segera setelah katalis nanoteknologi disintesis ke dalam reaktor.',
    'en' => 'Thermodynamic efficiency increases significantly as soon as nanotechnology catalysts are synthesized into the reactor',
    'type' => 'time',
    'pos_type' => 'final',
    'conjunction' => 'as soon as (segera setelah)',
    'example' => 
    array (
      'id' => 'Reaksi terjadi segera setelah suhu dinaikkan.',
      'en' => 'The reaction occurred as soon as temperature rose.',
    ),
    'vocab' => 
    array (
      'Thermodynamic efficiency' => 
      array (
        'id' => 'Efisiensi termodinamika',
        'pos' => '(n)',
      ),
      'Significantly' => 
      array (
        'id' => 'Secara signifikan',
        'pos' => '(adv)',
      ),
      'As soon as' => 
      array (
        'id' => 'Segera setelah',
        'pos' => '(conj)',
      ),
      'Nanotechnology catalyst' => 
      array (
        'id' => 'Katalis nanoteknologi',
        'pos' => '(n)',
      ),
      'Synthesize' => 
      array (
        'id' => 'Disintesis',
        'pos' => '(v)',
      ),
      'Reactor' => 
      array (
        'id' => 'Reaktor',
        'pos' => '(n)',
      ),
    ),
  ),
  31 => 
  array (
    'id' => 'Protokol enkripsi kuantum dikembangkan agar transmisi data antarlembaga tetap terlindungi dari intersepsi siber.',
    'en' => 'Quantum encryption protocols were developed so that inter-institutional data transmission remains safeguarded from cyber interception',
    'type' => 'purpose',
    'pos_type' => 'final',
    'conjunction' => 'so that (agar / supaya)',
    'example' => 
    array (
      'id' => 'Sistem diamankan agar data tidak bocor.',
      'en' => 'Systems are secured so that data is safe.',
    ),
    'vocab' => 
    array (
      'Quantum encryption protocol' => 
      array (
        'id' => 'Protokol enkripsi kuantum',
        'pos' => '(n)',
      ),
      'So that' => 
      array (
        'id' => 'Agar / Supaya',
        'pos' => '(conj)',
      ),
      'Inter-institutional' => 
      array (
        'id' => 'Antarlembaga',
        'pos' => '(adj)',
      ),
      'Transmission' => 
      array (
        'id' => 'Transmisi',
        'pos' => '(n)',
      ),
      'Safeguarded' => 
      array (
        'id' => 'Terlindungi',
        'pos' => '(v)',
      ),
      'Cyber interception' => 
      array (
        'id' => 'Intersepsi siber',
        'pos' => '(n)',
      ),
    ),
  ),
  32 => 
  array (
    'id' => 'Kolaborasi akademik berkembang secara dinamis di mana pun ekosistem riset interdisipliner didukung secara optimal.',
    'en' => 'Academic collaboration flourishes dynamically wherever interdisciplinary research ecosystems are optimally supported',
    'type' => 'place',
    'pos_type' => 'final',
    'conjunction' => 'wherever (di mana pun)',
    'example' => 
    array (
      'id' => 'Inovasi muncul di mana pun ada dukungan.',
      'en' => 'Innovation emerges wherever there is support.',
    ),
    'vocab' => 
    array (
      'Academic collaboration' => 
      array (
        'id' => 'Kolaborasi akademik',
        'pos' => '(n)',
      ),
      'Flourish dynamically' => 
      array (
        'id' => 'Berkembang secara dinamis',
        'pos' => '(v)',
      ),
      'Wherever' => 
      array (
        'id' => 'Di mana pun',
        'pos' => '(conj)',
      ),
      'Interdisciplinary' => 
      array (
        'id' => 'Interdisipliner',
        'pos' => '(adj)',
      ),
      'Optimally supported' => 
      array (
        'id' => 'Didukung secara optimal',
        'pos' => '(v)',
      ),
    ),
  ),
  33 => 
  array (
    'id' => 'Formasi geologis ngarai tersebut tampak seolah-olah struktur batuannya terukir oleh gaya tektonik prasejarah yang masif.',
    'en' => 'The geological formation of the canyon appears as if its rock structure was sculpted by massive prehistoric tectonic forces',
    'type' => 'manner',
    'pos_type' => 'final',
    'conjunction' => 'as if (seolah-olah)',
    'example' => 
    array (
      'id' => 'Batu itu tampak seolah-olah dipahat.',
      'en' => 'The rock looks as if it was carved.',
    ),
    'vocab' => 
    array (
      'Geological formation' => 
      array (
        'id' => 'Formasi geologis',
        'pos' => '(n)',
      ),
      'Canyon' => 
      array (
        'id' => 'Ngarai / Lembah curam',
        'pos' => '(n)',
      ),
      'As if' => 
      array (
        'id' => 'Seolah-olah',
        'pos' => '(conj)',
      ),
      'Sculpted' => 
      array (
        'id' => 'Terukir / Terpahat',
        'pos' => '(v)',
      ),
      'Prehistoric' => 
      array (
        'id' => 'Prasejarah',
        'pos' => '(adj)',
      ),
      'Tectonic forces' => 
      array (
        'id' => 'Gaya tektonik',
        'pos' => '(n)',
      ),
    ),
  ),
);

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
            'id' => 'Para astrofisikawan belum dapat memastikan secara empiris apakah biosfer ekstraterestrial eksis di exoplanet lain.',
            'en' => 'Astrophysicists have not yet empirically ascertained whether extraterrestrial biospheres exist on other exoplanets',
            'example' => ['id' => 'Ilmuwan meneliti apakah ada air di Mars.', 'en' => 'Scientists investigate whether water exists on Mars.'],
            'vocab' => [
                'Astrophysicist' => ['id' => 'Astrofisikawan', 'pos' => '(n)'],
                'Empirically ascertain' => ['id' => 'Memastikan secara empiris', 'pos' => '(v)'],
                'Extraterrestrial' => ['id' => 'Ekstraterestrial / Luar bumi', 'pos' => '(adj)'],
                'Biosphere' => ['id' => 'Biosfer', 'pos' => '(n)'],
                'Exoplanet' => ['id' => 'Exoplanet', 'pos' => '(n)']
            ]
        ],
        2 => [
            'id' => 'Para pembuat kebijakan tidak boleh mengasumsikan bahwa degradasi biosfer global akan pulih secara spontan.',
            'en' => 'Policymakers cannot presume that global biosphere degradation will regenerate spontaneously',
            'example' => ['id' => 'Kita tidak boleh menganggap bahwa masalah selesai sendiri.', 'en' => 'We cannot assume that problems resolve on their own.'],
            'vocab' => [
                'Policymaker' => ['id' => 'Pembuat kebijakan', 'pos' => '(n)'],
                'Presume' => ['id' => 'Mengasumsikan / Menganggap', 'pos' => '(v)'],
                'Degradation' => ['id' => 'Degradasi', 'pos' => '(n)'],
                'Regenerate' => ['id' => 'Pulih / Regenerasi', 'pos' => '(v)'],
                'Spontaneously' => ['id' => 'Secara spontan', 'pos' => '(adv)']
            ]
        ],
        3 => [
            'id' => 'Para filsuf epistemologi sering memperdebatkan apakah kesadaran manusia murni merupakan fenomena neurologis.',
            'en' => 'Epistemologists frequently debate whether human consciousness is purely a neurological phenomenon',
            'example' => ['id' => 'Banyak orang bertanya-tanya apakah robot bisa berpikir.', 'en' => 'Many wonder whether robots can think.'],
            'vocab' => [
                'Epistemologist' => ['id' => 'Filsuf epistemologi', 'pos' => '(n)'],
                'Consciousness' => ['id' => 'Kesadaran', 'pos' => '(n)'],
                'Purely' => ['id' => 'Murni / Semata-mata', 'pos' => '(adv)'],
                'Neurological phenomenon' => ['id' => 'Fenomena neurologis', 'pos' => '(n)']
            ]
        ],
        4 => [
            'id' => 'Ketika populasi biologis terisolasi secara geografis, mereka mengalami divergensi dalam apa yang didefinisikan sebagai spesiasi.',
            'en' => 'When biological populations become geographically isolated, they undergo divergence in what is defined as speciation',
            'example' => ['id' => 'Hewan terpisah dalam apa yang disebut isolasi habitat.', 'en' => 'Animals separate in what is called habitat isolation.'],
            'vocab' => [
                'Biological population' => ['id' => 'Populasi biologis', 'pos' => '(n)'],
                'Geographically isolated' => ['id' => 'Terisolasi secara geografis', 'pos' => '(adj)'],
                'Undergo divergence' => ['id' => 'Mengalami divergensi / pemisahan', 'pos' => '(v)'],
                'Speciation' => ['id' => 'Spesiasi / pembentukan spesies baru', 'pos' => '(n)']
            ]
        ],
        5 => [
            'id' => 'Yurisdiksi mana yang akan mengadopsi regulasi kecerdasan buatan paling ketat tetap menjadi diskursus global yang intens.',
            'en' => 'Which jurisdiction will adopt the most stringent artificial intelligence regulations remains an intense global discourse',
            'example' => ['id' => 'Negara mana yang memimpin inovasi masih diperdebatkan.', 'en' => 'Which country leads innovation is still debated.'],
            'vocab' => [
                'Jurisdiction' => ['id' => 'Yurisdiksi / Wilayah hukum', 'pos' => '(n)'],
                'Adopt' => ['id' => 'Mengadopsi', 'pos' => '(v)'],
                'Stringent' => ['id' => 'Ketat / Mengikat', 'pos' => '(adj)'],
                'Discourse' => ['id' => 'Diskursus / Pembahasan', 'pos' => '(n)']
            ]
        ],
        6 => [
            'id' => 'Bagaimana peradaban kuno mendirikan monumen megalitik dengan presisi geometris tinggi terus membingungkan para arkeolog.',
            'en' => 'How ancient civilizations erected megalithic monuments with immense geometric precision continues to confound archaeologists',
            'example' => ['id' => 'Bagaimana piramida dibangun masih menjadi misteri.', 'en' => 'How pyramids were built remains a mystery.'],
            'vocab' => [
                'Ancient civilization' => ['id' => 'Peradaban kuno', 'pos' => '(n)'],
                'Erect' => ['id' => 'Mendirikan', 'pos' => '(v)'],
                'Megalithic monument' => ['id' => 'Monumen megalitik', 'pos' => '(n)'],
                'Geometric precision' => ['id' => 'Presisi geometris', 'pos' => '(n)'],
                'Confound' => ['id' => 'Membingungkan', 'pos' => '(v)']
            ]
        ],
        7 => [
            'id' => 'Bahwa aktivitas antropogenik telah mempercepat laju kepunahan spesies global merupakan konsensus ilmiah yang tak terbantahkan.',
            'en' => 'That anthropogenic activities have accelerated the rate of global species extinction is an irrefutable scientific consensus',
            'example' => ['id' => 'Bahwa polusi merusak bumi sudah terbukti.', 'en' => 'That pollution harms the Earth is proven.'],
            'vocab' => [
                'Anthropogenic activity' => ['id' => 'Aktivitas antropogenik', 'pos' => '(n)'],
                'Accelerate' => ['id' => 'Mempercepat', 'pos' => '(v)'],
                'Extinction rate' => ['id' => 'Laju kepunahan', 'pos' => '(n)'],
                'Irrefutable' => ['id' => 'Tak terbantahkan', 'pos' => '(adj)'],
                'Consensus' => ['id' => 'Konsensus', 'pos' => '(n)']
            ]
        ],
        8 => [
            'id' => 'Para ahli biologi taksonomi mengklasifikasikan organisme hidup melalui apa yang dirumuskan sebagai filogenetika molekuler.',
            'en' => 'Taxonomic biologists classify living organisms through what is formulated as molecular phylogenetics',
            'example' => ['id' => 'Saintis mengelompokkan hewan melalui apa yang disebut taksonomi.', 'en' => 'Scientists group animals through what is called taxonomy.'],
            'vocab' => [
                'Taxonomic biologist' => ['id' => 'Ahli biologi taksonomi', 'pos' => '(n)'],
                'Classify' => ['id' => 'Mengklasifikasikan', 'pos' => '(v)'],
                'Living organism' => ['id' => 'Organisme hidup', 'pos' => '(n)'],
                'Formulate' => ['id' => 'Dirumuskan', 'pos' => '(v)'],
                'Molecular phylogenetics' => ['id' => 'Filogenetika molekuler', 'pos' => '(n)']
            ]
        ],
        9 => [
            'id' => 'Faktor sosioekonomi yang menentukan bagaimana masyarakat beradaptasi terhadap disrupsi iklim sangatlah kompleks.',
            'en' => 'The socioeconomic factors that determine how communities adapt to climate disruption are exceptionally complex',
            'example' => ['id' => 'Faktor yang mengatur interaksi manusia sangat rumit.', 'en' => 'Factors that regulate human interaction are complex.'],
            'vocab' => [
                'Socioeconomic factor' => ['id' => 'Faktor sosioekonomi', 'pos' => '(n)'],
                'Determine' => ['id' => 'Menentukan', 'pos' => '(v)'],
                'Adapt' => ['id' => 'Beradaptasi', 'pos' => '(v)'],
                'Climate disruption' => ['id' => 'Disrupsi iklim', 'pos' => '(n)'],
                'Exceptionally complex' => ['id' => 'Sangatlah kompleks', 'pos' => '(adj)']
            ]
        ],
        10 => [
            'id' => 'Teori Perdagangan Modern mengelaborasi mengapa negara-negara maju mendominasi pertukaran komoditas bernilai tambah tinggi.',
            'en' => 'Modern Trade Theory elaborates why industrialized nations dominate the exchange of high-value-added commodities',
            'example' => ['id' => 'Teori ekonomi menjelaskan mengapa negara kaya berdagang.', 'en' => 'Economic theory explains why rich nations trade.'],
            'vocab' => [
                'Trade theory' => ['id' => 'Teori perdagangan', 'pos' => '(n)'],
                'Elaborate' => ['id' => 'Mengelaborasi / Menguraikan', 'pos' => '(v)'],
                'Industrialized nation' => ['id' => 'Negara maju / terindustrialisasi', 'pos' => '(n)'],
                'Dominate' => ['id' => 'Mendominasi', 'pos' => '(v)'],
                'High-value-added commodity' => ['id' => 'Komoditas bernilai tambah tinggi', 'pos' => '(n)']
            ]
        ],
        11 => [
            'id' => 'Kapan hominin purba pertama kali mengolonisasi benua Australia belum dapat ditentukan secara definitif.',
            'en' => 'When early hominins initially colonized the Australian continent has not yet been definitively determined',
            'example' => ['id' => 'Kapan manusia tiba di pulau itu belum diketahui pasti.', 'en' => 'When humans arrived on the island is not known for sure.'],
            'vocab' => [
                'Early hominin' => ['id' => 'Hominin purba', 'pos' => '(n)'],
                'Colonize' => ['id' => 'Mengolonisasi / Mendiami', 'pos' => '(v)'],
                'Definitively' => ['id' => 'Secara definitif / Pasti', 'pos' => '(adv)'],
                'Determine' => ['id' => 'Ditentukan', 'pos' => '(v)']
            ]
        ],
        12 => [
            'id' => 'Di mana limbah industri radioaktif didepositokan menimbulkan kekhawatiran ekologis yang mendalam bagi ekosistem marin.',
            'en' => 'Where radioactive industrial waste is deposited generates profound ecological concerns for marine ecosystems',
            'example' => ['id' => 'Di mana sampah dibuang mencemari laut.', 'en' => 'Where trash is dumped pollutes the sea.'],
            'vocab' => [
                'Radioactive waste' => ['id' => 'Limbah radioaktif', 'pos' => '(n)'],
                'Deposit' => ['id' => 'Didepositokan / Dibuang', 'pos' => '(v)'],
                'Profound' => ['id' => 'Mendalam / Serius', 'pos' => '(adj)'],
                'Ecological concern' => ['id' => 'Kekhawatiran ekologis', 'pos' => '(n)'],
                'Marine ecosystem' => ['id' => 'Ekosistem marin / laut', 'pos' => '(n)']
            ]
        ],
        13 => [
            'id' => 'Apa yang dianggap sebagai aset strategis di masa depan hampir mustahil untuk diproyeksikan secara akurat.',
            'en' => 'What constitutes a strategic asset in the future is virtually impossible to project accurately',
            'example' => ['id' => 'Apa yang berharga kelak sulit ditebak.', 'en' => 'What will be valuable later is hard to guess.'],
            'vocab' => [
                'Constitute' => ['id' => 'Dianggap sebagai / Membentuk', 'pos' => '(v)'],
                'Strategic asset' => ['id' => 'Aset strategis', 'pos' => '(n)'],
                'Virtually impossible' => ['id' => 'Hampir mustahil', 'pos' => '(adj)'],
                'Project accurately' => ['id' => 'Diproyeksikan secara akurat', 'pos' => '(v)']
            ]
        ],
        14 => [
            'id' => 'Sejumlah analis berpendapat bahwa korporasi multinasional memiliki pengaruh yang lebih determinan daripada entitas negara.',
            'en' => 'Several analysts contend that multinational corporations wield a more decisive influence than state entities',
            'example' => ['id' => 'Pengamat merasa perusahaan besar sangat berkuasa.', 'en' => 'Observers feel that big corporations are powerful.'],
            'vocab' => [
                'Contend' => ['id' => 'Berpendapat / Menegaskan', 'pos' => '(v)'],
                'Multinational corporation' => ['id' => 'Korporasi multinasional', 'pos' => '(n)'],
                'Wield influence' => ['id' => 'Memiliki pengaruh', 'pos' => '(v)'],
                'Decisive' => ['id' => 'Determinan / Menentukan', 'pos' => '(adj)'],
                'State entity' => ['id' => 'Entitas negara', 'pos' => '(n)']
            ]
        ],
        15 => [
            'id' => 'Masih belum dapat disimpulkan secara konklusif apakah pemanasan global akan memicu titik kritis iklim yang ireversibel.',
            'en' => 'It remains inconclusive whether global warming will precipitate irreversible climatic tipping points',
            'example' => ['id' => 'Belum jelas apakah spesies burung bermigrasi saat musim dingin.', 'en' => 'It is unclear whether birds migrate in winter.'],
            'vocab' => [
                'Inconclusive' => ['id' => 'Belum konklusif / pasti', 'pos' => '(adj)'],
                'Precipitate' => ['id' => 'Memicu / Mempercepat', 'pos' => '(v)'],
                'Irreversible' => ['id' => 'Ireversibel / Tak dapat dipulihkan', 'pos' => '(adj)'],
                'Climatic tipping point' => ['id' => 'Titik kritis iklim', 'pos' => '(n)']
            ]
        ],
        16 => [
            'id' => 'Apa yang memicu keruntuhan peradaban Maya kuno masih menjadi subjek perdebatan ilmiah di kalangan sejarawan.',
            'en' => 'What triggered the collapse of the ancient Maya civilization remains a subject of scholarly debate among historians',
            'example' => ['id' => 'Apa yang terjadi pada masa lalu masih diperdebatkan.', 'en' => 'What happened in the past is still debated.'],
            'vocab' => [
                'Trigger' => ['id' => 'Memicu', 'pos' => '(v)'],
                'Collapse' => ['id' => 'Keruntuhan', 'pos' => '(n)'],
                'Ancient civilization' => ['id' => 'Peradaban kuno', 'pos' => '(n)'],
                'Scholarly debate' => ['id' => 'Perdebatan ilmiah', 'pos' => '(n)']
            ]
        ],
        17 => [
            'id' => 'Apa yang para ekonom konseptualisasikan sebagai eksternalitas negatif mengacu pada dampak sampingan yang merugikan.',
            'en' => 'What economists conceptualize as negative externalities refers to adverse side effects imposed on third parties',
            'example' => ['id' => 'Apa yang ahli maksud adalah pilihan marjinal.', 'en' => 'What experts mean is marginal choice.'],
            'vocab' => [
                'Conceptualize' => ['id' => 'Mengonseptualisasikan', 'pos' => '(v)'],
                'Negative externality' => ['id' => 'Eksternalitas negatif', 'pos' => '(n)'],
                'Refer to' => ['id' => 'Mengacu pada', 'pos' => '(v)'],
                'Adverse side effect' => ['id' => 'Dampak sampingan yang merugikan', 'pos' => '(n)']
            ]
        ],
        18 => [
            'id' => 'Bagaimana transmisi sinaptik mentransmisikan impuls neurokimia membedakan mekanisme kognitif manusia dari pemrosesan silikon.',
            'en' => 'How synaptic transmission propagates neurochemical impulses distinguishes human cognitive mechanisms from silicon processing',
            'example' => ['id' => 'Bagaimana otak bekerja berbeda dari komputer.', 'en' => 'How the brain works differs from computers.'],
            'vocab' => [
                'Synaptic transmission' => ['id' => 'Transmisi sinaptik', 'pos' => '(n)'],
                'Propagate' => ['id' => 'Mentransmisikan / Merambatkan', 'pos' => '(v)'],
                'Neurochemical impulse' => ['id' => 'Impuls neurokimia', 'pos' => '(n)'],
                'Distinguish' => ['id' => 'Membedakan', 'pos' => '(v)'],
                'Cognitive mechanism' => ['id' => 'Mekanisme kognitif', 'pos' => '(n)']
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

    // ── Meeting 4 (Fast-track) — Negative Sentence, mirrors the
    // matrix+sentences architecture used by Meeting 2 (Tenses), negated. ──

    public $meeting4NegativeFormulas = [
        'Simple Present' => ['verbal' => 'S + do/does + not + V1', 'nominal' => 'S + Be(am/is/are) + not', 'passive' => 'S + Be(am/is/are) + not + V3'],
        'Present Continuous' => ['verbal' => 'S + Be(am/is/are) + not + Ving', 'nominal' => 'S + Be(am/is/are) + not + Being', 'passive' => 'S + Be(am/is/are) + not + Being + V3'],
        'Present Perfect' => ['verbal' => 'S + Have/Has + not + V3', 'nominal' => 'S + Have/Has + not + Been', 'passive' => 'S + Have/Has + not + Been + V3'],
        'Present Perfect Continuous' => ['verbal' => 'S + Have/Has + not + Been + Ving', 'nominal' => 'S + Have/Has + not + Been + Being', 'passive' => 'S + Have/Has + not + Been + Being + V3'],
        'Simple Past' => ['verbal' => 'S + did + not + V1', 'nominal' => 'S + Be(was/were) + not', 'passive' => 'S + Be(was/were) + not + V3'],
        'Past Continuous' => ['verbal' => 'S + Be(was/were) + not + Ving', 'nominal' => 'S + Be(was/were) + not + Being', 'passive' => 'S + Be(was/were) + not + Being + V3'],
        'Past Perfect' => ['verbal' => 'S + Had + not + V3', 'nominal' => 'S + Had + not + Been', 'passive' => 'S + Had + not + Been + V3'],
        'Past Perfect Continuous' => ['verbal' => 'S + Had + not + Been + Ving', 'nominal' => 'S + Had + not + Been + Being', 'passive' => 'S + Had + not + Been + Being + V3'],
        'Simple Future' => ['verbal' => 'S + Will + not + V1', 'nominal' => 'S + Will + not + Be', 'passive' => 'S + Will + not + Be + V3'],
        'Future Continuous' => ['verbal' => 'S + Will + not + Be + Ving', 'nominal' => 'S + Will + not + Be + Being', 'passive' => 'S + Will + not + Be + Being + V3'],
        'Future Perfect' => ['verbal' => 'S + Will + not + Have + V3', 'nominal' => 'S + Will + not + Have + Been', 'passive' => 'S + Will + not + Have + Been + V3'],
        'Future Perfect Continuous' => ['verbal' => 'S + Will + not + Have + Been + Ving', 'nominal' => 'S + Will + not + Have + Been + Being', 'passive' => 'S + Will + not + Have + Been + Being + V3'],
        'Simple Past Future' => ['verbal' => 'S + Would + not + V1', 'nominal' => 'S + Would + not + Be', 'passive' => 'S + Would + not + Be + V3'],
        'Past Future Continuous' => ['verbal' => 'S + Would + not + Be + Ving', 'nominal' => 'S + Would + not + Be + Being', 'passive' => 'S + Would + not + Be + Being + V3'],
        'Past Future Perfect' => ['verbal' => 'S + Would + not + Have + V3', 'nominal' => 'S + Would + not + Have + Been', 'passive' => 'S + Would + not + Have + Been + V3'],
        'Past Future Perfect Continuous' => ['verbal' => 'S + Would + not + Have + Been + Ving', 'nominal' => 'S + Would + not + Have + Been + Being', 'passive' => 'S + Would + not + Have + Been + Being + V3'],
        'Modal' => ['verbal' => 'S + Modal + not + V1', 'nominal' => 'S + Modal + not + Be', 'passive' => 'S + Modal + not + Be + V3']
    ];

    public $meeting4NegativeMatrixIntroSentences = [
        1 => ['id' => 'Kita tidak menyelesaikan masalah ini.', 'en' => 'We do not solve this problem', 'tense' => 'Simple Present', 'type' => 'verbal'],
        2 => ['id' => 'Dia (it) tidak membantu.', 'en' => 'It does not help', 'tense' => 'Simple Present', 'type' => 'verbal'],
        3 => ['id' => 'Pemerintah tidak melindungi hutan.', 'en' => 'The government does not protect the forest', 'tense' => 'Simple Present', 'type' => 'verbal'],
        4 => ['id' => 'Undang-undang tidak menjamin kebebasan berekspresi.', 'en' => 'The law does not guarantee freedom of expression', 'tense' => 'Simple Present', 'type' => 'verbal'],
        5 => ['id' => 'Mamalia tidak menyebar secara luas 2 juta tahun yang lalu.', 'en' => 'Mammals did not spread widely 2 million years ago', 'tense' => 'Simple Past', 'type' => 'verbal'],
    ];

    public $meeting4NegativeTranslationSentences = [
        1 => ['id' => 'Pemerintah tidak mengabaikan dampak perubahan iklim global.', 'en' => 'The government does not ignore the impact of global climate change', 'tense' => 'Simple Present', 'type' => 'verbal'],
        2 => ['id' => 'Bahan bakar fosil bukan sumber energi terbarukan.', 'en' => 'Fossil fuels are not renewable energy sources', 'tense' => 'Simple Present', 'type' => 'nominal'],
        3 => ['id' => 'Para peneliti tidak menemukan bukti pencemaran air pada ekspedisi kemarin.', 'en' => 'Researchers did not find evidence of water pollution on yesterday\'s expedition', 'tense' => 'Simple Past', 'type' => 'verbal'],
        4 => ['id' => 'Stasiun penelitian itu tidak aktif selama musim dingin tahun lalu.', 'en' => 'The research station was not active during the winter last year', 'tense' => 'Simple Past', 'type' => 'nominal'],
        5 => ['id' => 'Para ilmuwan tidak sedang menguji vaksin baru tersebut saat ini.', 'en' => 'Scientists are not testing the new vaccine at present', 'tense' => 'Present Continuous', 'type' => 'verbal'],
        6 => ['id' => 'Tim geologi tidak sedang mengebor batuan vulkanik ketika badai terjadi.', 'en' => 'The geological team was not drilling volcanic rock when the storm occurred', 'tense' => 'Past Continuous', 'type' => 'verbal'],
        7 => ['id' => 'Banyak negara berkembang belum menerapkan teknologi energi terbarukan.', 'en' => 'Many developing countries have not implemented renewable energy technology', 'tense' => 'Present Perfect', 'type' => 'verbal'],
        8 => ['id' => 'Spesies langka itu belum punah sebelum bencana letusan gunung terjadi.', 'en' => 'The rare species had not become extinct before the volcanic eruption occurred', 'tense' => 'Past Perfect', 'type' => 'verbal'],
        9 => ['id' => 'Kecerdasan buatan tidak akan menggantikan seluruh peran tenaga medis profesional.', 'en' => 'Artificial intelligence will not replace all roles of professional medical personnel', 'tense' => 'Simple Future', 'type' => 'verbal'],
        10 => ['id' => 'Masyarakat seharusnya tidak membuang limbah kimia berbahaya ke sungai.', 'en' => 'Society should not dispose of hazardous chemical waste into the river', 'tense' => 'Modal', 'type' => 'verbal'],
    ];

    public $meeting4NegativeTranslationMatrix = [
        'Simple Present' => [
            'nominal' => ['id' => 'Beruang bukan karnivora.', 'en' => 'Bears are not carnivores'],
            'passive' => ['id' => 'Gajah utamanya tidak diburu untuk dagingnya.', 'en' => 'Elephants are not primarily hunted for their meat']
        ],
        'Present Continuous' => [
            'verbal' => ['id' => 'Ekonomi global tidak sedang tumbuh.', 'en' => 'The global economy is not growing'],
            'nominal' => ['id' => 'Pemerintah tidak sedang berhati-hati.', 'en' => 'The government is not being careful'],
            'passive' => ['id' => 'Konsumsi bahan bakar tidak sedang dikurangi.', 'en' => 'Fuel consumption is not being reduced']
        ],
        'Present Perfect' => [
            'verbal' => ['id' => 'Beberapa negara belum bergabung dengan PBB.', 'en' => 'Some countries have not joined the UN'],
            'nominal' => ['id' => 'Hukum ini masih belum ada di negara kami.', 'en' => 'This law has not been in our country yet'],
            'passive' => ['id' => 'Air bersih masih belum dinikmati oleh banyak orang.', 'en' => 'Clean water has not been enjoyed by many people yet']
        ],
        'Present Perfect Continuous' => [
            'verbal' => ['id' => 'Negara belum sedang mengembangkan teknologi semikonduktor.', 'en' => 'The country has not been developing semiconductor technology'],
            'nominal' => ['id' => 'Pemerintah belum sedang berhati-hati.', 'en' => 'The government has not been being careful'],
            'passive' => ['id' => 'Proyek ini belum sedang dibangun.', 'en' => 'This project has not been being built']
        ],
        'Simple Past' => [
            'nominal' => ['id' => 'Pantodonta tidak ada di berbagai ekosistem pada 66 juta tahun yang lalu.', 'en' => 'Pantodonts were not in various ecosystems 66 million years ago'],
            'passive' => ['id' => 'Kehidupan mamalia tidak dimusnahkan oleh komet.', 'en' => 'Mammal life was not wiped out by the comet']
        ],
        'Past Continuous' => [
            'verbal' => ['id' => 'Manusia tidak sedang menjelajahi Antartika 400 tahun yang lalu.', 'en' => 'Humans were not exploring Antarctica 400 years ago'],
            'nominal' => ['id' => 'Pemerintah tidak sedang berhati-hati tahun lalu.', 'en' => 'The government was not being careful last year'],
            'passive' => ['id' => 'Minyak tidak sedang ditambang di Alaska.', 'en' => 'Oil was not being mined in Alaska']
        ],
        'Past Perfect' => [
            'verbal' => ['id' => 'Columbus belum mengunjungi dataran utama Amerika di pelayaran pertama.', 'en' => 'Columbus had not visited mainland America on his first voyage'],
            'nominal' => ['id' => 'Mamalia belum ada di Selandia Baru 1000 tahun yang lalu.', 'en' => 'Mammals had not been in New Zealand 1000 years ago'],
            'passive' => ['id' => 'Permafrost belum ditemukan dulu.', 'en' => 'Permafrost had not been discovered in the past']
        ],
        'Past Perfect Continuous' => [
            'verbal' => ['id' => 'Banyak pabrik belum sedang menerapkan regulasi keamanan 50 tahun yang lalu.', 'en' => 'Many factories had not been implementing safety regulations 50 years ago'],
            'nominal' => ['id' => 'Pemerintah belum sedang berhati-hati.', 'en' => 'The government had not been being careful'],
            'passive' => ['id' => 'Nuklir belum sedang dikembangkan 100 tahun lalu.', 'en' => 'Nuclear technology had not been being developed 100 years ago']
        ],
        'Simple Future' => [
            'verbal' => ['id' => 'AI tidak akan menghancurkan lapangan pekerjaan.', 'en' => 'AI will not destroy jobs'],
            'nominal' => ['id' => 'Dunia tidak akan sama dalam 50 tahun lagi.', 'en' => 'The world will not be the same in 50 years'],
            'passive' => ['id' => 'Hidrogen tidak akan digunakan untuk bahan bakar utama dalam 10 tahun.', 'en' => 'Hydrogen will not be used as the main fuel within 10 years']
        ],
        'Future Continuous' => [
            'verbal' => ['id' => 'Matahari tidak akan sedang meledak.', 'en' => 'The sun will not be exploding'],
            'nominal' => ['id' => 'Pemerintah tidak akan sedang berhati-hati.', 'en' => 'The government will not be being careful'],
            'passive' => ['id' => 'Asteroid tidak akan sedang ditambang dalam waktu dekat.', 'en' => 'The asteroid will not be being mined in the near future']
        ],
        'Future Perfect' => [
            'verbal' => ['id' => 'Lautan tidak akan telah membanjiri kota-kota pesisir.', 'en' => 'The oceans will not have flooded coastal cities'],
            'nominal' => ['id' => 'Ekosistem di lantai samudra belum akan aman dari sampah plastik.', 'en' => 'Ecosystems on the ocean floor will not have been safe from plastic waste'],
            'passive' => ['id' => 'Mesin anti gravitasi belum akan diciptakan dalam 100 tahun.', 'en' => 'Anti-gravity machines will not have been invented within 100 years']
        ],
        'Future Perfect Continuous' => [
            'verbal' => ['id' => 'Ekosistem akan belum sedang menyembuhkan.', 'en' => 'The ecosystem will not have been healing'],
            'nominal' => ['id' => 'Pemerintah tidak akan telah sedang berhati-hati.', 'en' => 'The government will not have been being careful'],
            'passive' => ['id' => 'Dyson Sphere belum akan sedang dibangun.', 'en' => 'The Dyson Sphere will not have been being built']
        ],
        'Simple Past Future' => [
            'verbal' => ['id' => 'Bencana ini tidak akan terjadi dengan pencegahan.', 'en' => 'This disaster would not happen with prevention'],
            'nominal' => ['id' => 'Burung kiwi tidak akan ada di Selandia Baru.', 'en' => 'Kiwi birds would not be in New Zealand'],
            'passive' => ['id' => 'Teknologi ini tidak akan dikembangkan.', 'en' => 'This technology would not be developed']
        ],
        'Past Future Continuous' => [
            'verbal' => ['id' => 'Geyser tidak akan sedang membanjiri kota.', 'en' => 'The geyser would not be flooding the city'],
            'nominal' => ['id' => 'Pemerintah tidak akan sedang berhati-hati.', 'en' => 'The government would not be being careful'],
            'passive' => ['id' => 'Tanah di daerah ini tidak akan sedang diteliti.', 'en' => 'The land in this area would not be being researched']
        ],
        'Past Future Perfect' => [
            'verbal' => ['id' => 'Aircraft belum akan menyebar tanpa insiden Heidelberg.', 'en' => 'Aircraft would not have spread without the Heidelberg incident'],
            'nominal' => ['id' => 'Mammoth tidak akan punah.', 'en' => 'Mammoths would not be extinct'],
            'passive' => ['id' => 'Pesawat jet belum akan dikembangkan di perang.', 'en' => 'Jet planes would not have been developed in the war']
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => ['id' => 'Letusan Yellowstone belum akan sedang mengubah iklim.', 'en' => 'The Yellowstone eruption would not have been changing the climate'],
            'nominal' => ['id' => 'Pemerintah tidak akan telah sedang berhati-hati.', 'en' => 'The government would not have been being careful'],
            'passive' => ['id' => 'Proyek ini belum akan sedang diajukan.', 'en' => 'This project would not have been being proposed']
        ],
        'Modal' => [
            'verbal' => ['id' => 'Manusia seharusnya tidak menghancurkan alam.', 'en' => 'Humans should not destroy nature'],
            'nominal' => ['id' => 'Teori ini mungkin tidak benar.', 'en' => 'This theory might not be true'],
            'passive' => ['id' => 'Ekosistem terumbu karang seharusnya tidak dieksploitasi.', 'en' => 'Coral reef ecosystems should not be exploited']
        ]
    ];

    public $meeting4NegativeTenseExamples = [
        'Simple Present' => [
            'verbal' => ['id' => 'Saya tidak makan.', 'en' => 'I do not eat.'],
            'nominal' => ['id' => 'Saya tidak senang.', 'en' => 'I am not happy.'],
            'passive' => ['id' => 'Nasi tidak dimakan.', 'en' => 'Rice is not eaten.']
        ],
        'Present Continuous' => [
            'verbal' => ['id' => 'Saya tidak sedang makan.', 'en' => 'I am not eating.'],
            'nominal' => ['id' => 'Saya tidak sedang senang.', 'en' => 'I am not being happy.'],
            'passive' => ['id' => 'Nasi tidak sedang dimakan.', 'en' => 'Rice is not being eaten.']
        ],
        'Present Perfect' => [
            'verbal' => ['id' => 'Saya belum makan.', 'en' => 'I have not eaten.'],
            'nominal' => ['id' => 'Saya belum senang.', 'en' => 'I have not been happy.'],
            'passive' => ['id' => 'Nasi belum dimakan.', 'en' => 'Rice has not been eaten.']
        ],
        'Present Perfect Continuous' => [
            'verbal' => ['id' => 'Saya belum sedang makan.', 'en' => 'I have not been eating.'],
            'nominal' => ['id' => 'Saya belum sedang senang.', 'en' => 'I have not been being happy.'],
            'passive' => ['id' => 'Nasi belum sedang dimakan.', 'en' => 'Rice has not been being eaten.']
        ],
        'Simple Past' => [
            'verbal' => ['id' => 'Saya tidak makan (dulu).', 'en' => 'I did not eat.'],
            'nominal' => ['id' => 'Saya tidak senang (dulu).', 'en' => 'I was not happy.'],
            'passive' => ['id' => 'Nasi tidak dimakan (dulu).', 'en' => 'Rice was not eaten.']
        ],
        'Past Continuous' => [
            'verbal' => ['id' => 'Saya tidak sedang makan (dulu).', 'en' => 'I was not eating.'],
            'nominal' => ['id' => 'Saya tidak sedang senang (dulu).', 'en' => 'I was not being happy.'],
            'passive' => ['id' => 'Nasi tidak sedang dimakan (dulu).', 'en' => 'Rice was not being eaten.']
        ],
        'Past Perfect' => [
            'verbal' => ['id' => 'Saya belum makan (dulu).', 'en' => 'I had not eaten.'],
            'nominal' => ['id' => 'Saya belum senang (dulu).', 'en' => 'I had not been happy.'],
            'passive' => ['id' => 'Nasi belum dimakan (dulu).', 'en' => 'Rice had not been eaten.']
        ],
        'Past Perfect Continuous' => [
            'verbal' => ['id' => 'Saya belum sedang makan (dulu).', 'en' => 'I had not been eating.'],
            'nominal' => ['id' => 'Saya belum sedang senang (dulu).', 'en' => 'I had not been being happy.'],
            'passive' => ['id' => 'Nasi belum sedang dimakan (dulu).', 'en' => 'Rice had not been being eaten.']
        ],
        'Simple Future' => [
            'verbal' => ['id' => 'Saya tidak akan makan.', 'en' => 'I will not eat.'],
            'nominal' => ['id' => 'Saya tidak akan senang.', 'en' => 'I will not be happy.'],
            'passive' => ['id' => 'Nasi tidak akan dimakan.', 'en' => 'Rice will not be eaten.']
        ],
        'Future Continuous' => [
            'verbal' => ['id' => 'Saya tidak akan sedang makan.', 'en' => 'I will not be eating.'],
            'nominal' => ['id' => 'Saya tidak akan sedang senang.', 'en' => 'I will not be being happy.'],
            'passive' => ['id' => 'Nasi tidak akan sedang dimakan.', 'en' => 'Rice will not be being eaten.']
        ],
        'Future Perfect' => [
            'verbal' => ['id' => 'Saya tidak akan sudah makan.', 'en' => 'I will not have eaten.'],
            'nominal' => ['id' => 'Saya tidak akan sudah senang.', 'en' => 'I will not have been happy.'],
            'passive' => ['id' => 'Nasi tidak akan sudah dimakan.', 'en' => 'Rice will not have been eaten.']
        ],
        'Future Perfect Continuous' => [
            'verbal' => ['id' => 'Saya tidak akan sudah sedang makan.', 'en' => 'I will not have been eating.'],
            'nominal' => ['id' => 'Saya tidak akan sudah sedang senang.', 'en' => 'I will not have been being happy.'],
            'passive' => ['id' => 'Nasi tidak akan sudah sedang dimakan.', 'en' => 'Rice will not have been being eaten.']
        ],
        'Simple Past Future' => [
            'verbal' => ['id' => 'Saya tidak akan makan (dulu).', 'en' => 'I would not eat.'],
            'nominal' => ['id' => 'Saya tidak akan senang (dulu).', 'en' => 'I would not be happy.'],
            'passive' => ['id' => 'Nasi tidak akan dimakan (dulu).', 'en' => 'Rice would not be eaten.']
        ],
        'Past Future Continuous' => [
            'verbal' => ['id' => 'Saya tidak akan sedang makan (dulu).', 'en' => 'I would not be eating.'],
            'nominal' => ['id' => 'Saya tidak akan sedang senang (dulu).', 'en' => 'I would not be being happy.'],
            'passive' => ['id' => 'Nasi tidak akan sedang dimakan (dulu).', 'en' => 'Rice would not be being eaten.']
        ],
        'Past Future Perfect' => [
            'verbal' => ['id' => 'Saya tidak akan sudah makan (dulu).', 'en' => 'I would not have eaten.'],
            'nominal' => ['id' => 'Saya tidak akan sudah senang (dulu).', 'en' => 'I would not have been happy.'],
            'passive' => ['id' => 'Nasi tidak akan sudah dimakan (dulu).', 'en' => 'Rice would not have been eaten.']
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => ['id' => 'Saya tidak akan sudah sedang makan (dulu).', 'en' => 'I would not have been eating.'],
            'nominal' => ['id' => 'Saya tidak akan sudah sedang senang (dulu).', 'en' => 'I would not have been being happy.'],
            'passive' => ['id' => 'Nasi tidak akan sudah sedang dimakan (dulu).', 'en' => 'Rice would not have been being eaten.']
        ],
        'Modal' => [
            'verbal' => ['id' => 'Saya tidak bisa makan.', 'en' => 'I cannot eat.'],
            'nominal' => ['id' => 'Saya tidak bisa senang.', 'en' => 'I cannot be happy.'],
            'passive' => ['id' => 'Nasi tidak bisa dimakan.', 'en' => 'Rice cannot be eaten.']
        ]
    ];

    public $meeting4NegativeVocabularies = [
        'Simple Present' => [
            'verbal' => ['solve' => ['id' => 'menyelesaikan', 'pos' => '(v1)'], 'problem' => ['id' => 'masalah', 'pos' => '(n)']],
            'nominal' => ['carnivore' => ['id' => 'karnivora', 'pos' => '(n)']],
            'passive' => ['hunt' => ['id' => 'memburu', 'pos' => '(v1)'], 'meat' => ['id' => 'daging', 'pos' => '(n)']],
        ],
        'Present Continuous' => [
            'verbal' => ['economy' => ['id' => 'ekonomi', 'pos' => '(n)'], 'grow' => ['id' => 'tumbuh', 'pos' => '(v1)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['fuel consumption' => ['id' => 'konsumsi bahan bakar', 'pos' => '(n)'], 'reduce' => ['id' => 'mengurangi', 'pos' => '(v1)']],
        ],
        'Present Perfect' => [
            'verbal' => ['join' => ['id' => 'bergabung', 'pos' => '(v1)']],
            'nominal' => ['law' => ['id' => 'hukum', 'pos' => '(n)']],
            'passive' => ['clean water' => ['id' => 'air bersih', 'pos' => '(n)'], 'enjoy' => ['id' => 'menikmati', 'pos' => '(v1)']],
        ],
        'Present Perfect Continuous' => [
            'verbal' => ['semiconductor' => ['id' => 'semikonduktor', 'pos' => '(n)'], 'develop' => ['id' => 'mengembangkan', 'pos' => '(v1)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['project' => ['id' => 'proyek', 'pos' => '(n)'], 'build' => ['id' => 'membangun', 'pos' => '(v1)']],
        ],
        'Simple Past' => [
            'verbal' => ['mammal' => ['id' => 'mamalia', 'pos' => '(n)'], 'spread' => ['id' => 'menyebar', 'pos' => '(v1)'], 'widely' => ['id' => 'secara luas', 'pos' => '(adv)']],
            'nominal' => ['ecosystem' => ['id' => 'ekosistem', 'pos' => '(n)']],
            'passive' => ['wipe out' => ['id' => 'memusnahkan', 'pos' => '(v1)'], 'comet' => ['id' => 'komet', 'pos' => '(n)']],
        ],
        'Past Continuous' => [
            'verbal' => ['explore' => ['id' => 'menjelajahi', 'pos' => '(v1)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['mine' => ['id' => 'menambang', 'pos' => '(v1)']],
        ],
        'Past Perfect' => [
            'verbal' => ['visit' => ['id' => 'mengunjungi', 'pos' => '(v1)'], 'mainland' => ['id' => 'dataran utama', 'pos' => '(n)']],
            'nominal' => ['mammal' => ['id' => 'mamalia', 'pos' => '(n)']],
            'passive' => ['permafrost' => ['id' => 'permafrost', 'pos' => '(n)'], 'discover' => ['id' => 'menemukan', 'pos' => '(v1)']],
        ],
        'Past Perfect Continuous' => [
            'verbal' => ['factory' => ['id' => 'pabrik', 'pos' => '(n)'], 'safety regulation' => ['id' => 'regulasi keamanan', 'pos' => '(n)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['nuclear' => ['id' => 'nuklir', 'pos' => '(n)'], 'develop' => ['id' => 'mengembangkan', 'pos' => '(v1)']],
        ],
        'Simple Future' => [
            'verbal' => ['destroy' => ['id' => 'menghancurkan', 'pos' => '(v1)'], 'job' => ['id' => 'lapangan pekerjaan', 'pos' => '(n)']],
            'nominal' => ['same' => ['id' => 'sama', 'pos' => '(adj)']],
            'passive' => ['hydrogen' => ['id' => 'hidrogen', 'pos' => '(n)'], 'fuel' => ['id' => 'bahan bakar', 'pos' => '(n)']],
        ],
        'Future Continuous' => [
            'verbal' => ['explode' => ['id' => 'meledak', 'pos' => '(v1)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['asteroid' => ['id' => 'asteroid', 'pos' => '(n)'], 'mine' => ['id' => 'menambang', 'pos' => '(v1)']],
        ],
        'Future Perfect' => [
            'verbal' => ['flood' => ['id' => 'membanjiri', 'pos' => '(v1)'], 'coastal city' => ['id' => 'kota pesisir', 'pos' => '(n)']],
            'nominal' => ['ocean floor' => ['id' => 'lantai samudra', 'pos' => '(n)'], 'plastic waste' => ['id' => 'sampah plastik', 'pos' => '(n)']],
            'passive' => ['anti-gravity' => ['id' => 'anti gravitasi', 'pos' => '(n)'], 'invent' => ['id' => 'menciptakan', 'pos' => '(v1)']],
        ],
        'Future Perfect Continuous' => [
            'verbal' => ['heal' => ['id' => 'menyembuhkan', 'pos' => '(v1)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['Dyson Sphere' => ['id' => 'Dyson Sphere', 'pos' => '(n)']],
        ],
        'Simple Past Future' => [
            'verbal' => ['disaster' => ['id' => 'bencana', 'pos' => '(n)'], 'prevention' => ['id' => 'pencegahan', 'pos' => '(n)']],
            'nominal' => ['kiwi bird' => ['id' => 'burung kiwi', 'pos' => '(n)']],
            'passive' => ['develop' => ['id' => 'mengembangkan', 'pos' => '(v1)']],
        ],
        'Past Future Continuous' => [
            'verbal' => ['geyser' => ['id' => 'geyser', 'pos' => '(n)'], 'flood' => ['id' => 'membanjiri', 'pos' => '(v1)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['research' => ['id' => 'meneliti', 'pos' => '(v1)']],
        ],
        'Past Future Perfect' => [
            'verbal' => ['aircraft' => ['id' => 'pesawat terbang', 'pos' => '(n)'], 'incident' => ['id' => 'insiden', 'pos' => '(n)']],
            'nominal' => ['mammoth' => ['id' => 'mammoth', 'pos' => '(n)'], 'extinct' => ['id' => 'punah', 'pos' => '(adj)']],
            'passive' => ['jet plane' => ['id' => 'pesawat jet', 'pos' => '(n)']],
        ],
        'Past Future Perfect Continuous' => [
            'verbal' => ['eruption' => ['id' => 'letusan', 'pos' => '(n)'], 'climate' => ['id' => 'iklim', 'pos' => '(n)']],
            'nominal' => ['careful' => ['id' => 'berhati-hati', 'pos' => '(adj)']],
            'passive' => ['propose' => ['id' => 'mengajukan', 'pos' => '(v1)']],
        ],
        'Modal' => [
            'verbal' => ['destroy' => ['id' => 'menghancurkan', 'pos' => '(v1)'], 'nature' => ['id' => 'alam', 'pos' => '(n)']],
            'nominal' => ['theory' => ['id' => 'teori', 'pos' => '(n)']],
            'passive' => ['coral reef' => ['id' => 'terumbu karang', 'pos' => '(n)'], 'exploit' => ['id' => 'mengeksploitasi', 'pos' => '(v1)']],
        ],
    ];

}
