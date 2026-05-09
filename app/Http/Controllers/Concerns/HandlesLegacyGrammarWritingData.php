<?php

namespace App\Http\Controllers\Concerns;

trait HandlesLegacyGrammarWritingData
{
    private function grammarQuestionsHasSectionColumn(): bool
    {
        static $hasSectionColumn = null;

        if ($hasSectionColumn === null) {
            $hasSectionColumn = \Illuminate\Support\Facades\Schema::hasColumn('grammar_questions', 'section');
        }

        return $hasSectionColumn;
    }

    private $meeting1Paragraph = [
        'id' => 'Ibuku seorang koki. Dia memasak makanan untuk berbagai acara, seperti pesta ulang tahun dan pernikahan. Masakannya sangat enak, sehingga banyak orang menyukainya. Dia bekerja dengan penuh semangat dan selalu menjaga kualitas makanannya. Setiap hari, banyak pelanggan memesan makanan darinya.',
        'en' => 'My mother is a chef. She cooks food for various events, like birthday parties and weddings. Her cooking is very delicious, so many people like it. She works with passion and always maintains the quality of her food. Every day, many customers order food from her.'
    ];

    private $meeting1FallbackQuestions = [
        1 => [
            'id' => 'Saya menyukainya.',
            'en' => 'I like her',
            'example' => ['id' => 'Saya mengenalnya dengan baik.', 'en' => 'I know her well'],
            'vocab' => [
                'like' => ['id' => 'menyukai', 'pos' => '(v)'],
                'her' => ['id' => 'dia (objek perempuan)', 'pos' => '(pron)'],
            ],
            'db_id' => null,
        ],
        2 => [
            'id' => 'Dia memberiku sebuah buku.',
            'en' => 'He gives me a book',
            'example' => ['id' => 'Dia mengirimiku pesan setiap hari.', 'en' => 'He sends me a message every day'],
            'vocab' => [
                'gives' => ['id' => 'memberi', 'pos' => '(v)'],
                'me' => ['id' => 'saya (objek)', 'pos' => '(pron)'],
                'book' => ['id' => 'buku', 'pos' => '(n)'],
            ],
            'db_id' => null,
        ],
        3 => [
            'id' => 'Mereka menolong kami.',
            'en' => 'They help us',
            'example' => ['id' => 'Mereka selalu mendukung kami.', 'en' => 'They always support us'],
            'vocab' => [
                'they' => ['id' => 'mereka', 'pos' => '(pron)'],
                'help' => ['id' => 'menolong', 'pos' => '(v)'],
                'us' => ['id' => 'kami (objek)', 'pos' => '(pron)'],
            ],
            'db_id' => null,
        ],
        4 => [
            'id' => 'Kami melihat mereka di pasar.',
            'en' => 'We see them at the market',
            'example' => ['id' => 'Kami bertemu mereka kemarin.', 'en' => 'We met them yesterday'],
            'vocab' => [
                'we' => ['id' => 'kami', 'pos' => '(pron)'],
                'them' => ['id' => 'mereka (objek)', 'pos' => '(pron)'],
                'market' => ['id' => 'pasar', 'pos' => '(n)'],
            ],
            'db_id' => null,
        ],
        5 => [
            'id' => 'Apakah kamu mengenalnya?',
            'en' => 'Do you know him',
            'example' => ['id' => 'Apakah kamu melihatnya?', 'en' => 'Do you see him'],
            'vocab' => [
                'do' => ['id' => 'apakah (aux)', 'pos' => '(aux)'],
                'know' => ['id' => 'mengenal', 'pos' => '(v)'],
                'him' => ['id' => 'dia (objek laki-laki)', 'pos' => '(pron)'],
            ],
            'db_id' => null,
        ],
    ];

    private $meeting1FallbackVocab = [
        'mother' => ['id' => 'ibu', 'pos' => '(n)', 'db_id' => null],
        'chef' => ['id' => 'koki', 'pos' => '(n)', 'db_id' => null],
        'cook' => ['id' => 'memasak', 'pos' => '(v)', 'db_id' => null],
        'event' => ['id' => 'acara', 'pos' => '(n)', 'db_id' => null],
        'birthday party' => ['id' => 'pesta ulang tahun', 'pos' => '(n)', 'db_id' => null],
        'wedding' => ['id' => 'pernikahan', 'pos' => '(n)', 'db_id' => null],
        'delicious' => ['id' => 'enak', 'pos' => '(adj)', 'db_id' => null],
        'passion' => ['id' => 'semangat', 'pos' => '(n)', 'db_id' => null],
        'quality' => ['id' => 'kualitas', 'pos' => '(n)', 'db_id' => null],
        'customer' => ['id' => 'pelanggan', 'pos' => '(n)', 'db_id' => null],
        'order' => ['id' => 'memesan', 'pos' => '(v)', 'db_id' => null],
    ];

    private $meeting3FallbackQuestions = [
        1 => ['id' => 'Tempat penyimpanan air telah dibangun di desa ini.', 'en' => 'Water storage has been built in this village', 'tense' => 'Present Perfect Passive', 'vocab' => ['Water' => ['id' => 'Air', 'pos' => '(n)'], 'Storage' => ['id' => 'Penyimpanan', 'pos' => '(n)'], 'Village' => ['id' => 'Desa', 'pos' => '(n)']]],
        2 => ['id' => 'Kemerdekaan Indonesia ada pada tanggal 17 agustus 1945.', 'en' => 'Indonesia\'s independence was on August 17, 1945', 'tense' => 'Simple Past Nominal', 'vocab' => ['Independence' => ['id' => 'Kemerdekaan', 'pos' => '(n)'], 'August' => ['id' => 'Agustus', 'pos' => '(n)']]],
        3 => ['id' => 'Pembangunan daerah membantu perekonomian lokal.', 'en' => 'Regional development helps the local economy', 'tense' => 'Simple Present Verbal', 'vocab' => ['Regional' => ['id' => 'Daerah', 'pos' => '(adj)'], 'Development' => ['id' => 'Pembangunan', 'pos' => '(n)'], 'Help' => ['id' => 'Membantu', 'pos' => '(v)'], 'Local' => ['id' => 'Lokal', 'pos' => '(adj)'], 'Economy' => ['id' => 'Perekonomian', 'pos' => '(n)']]],
        4 => ['id' => 'Pemanasan global sedang dibicarakan oleh seluruh orang di dunia.', 'en' => 'Global warming is being discussed by everyone in the world', 'tense' => 'Present Continuous Passive', 'vocab' => ['Global warming' => ['id' => 'Pemanasan global', 'pos' => '(n)'], 'Discuss' => ['id' => 'Membicarakan', 'pos' => '(v)'], 'Everyone' => ['id' => 'Seluruh orang', 'pos' => '(pron)'], 'World' => ['id' => 'Dunia', 'pos' => '(n)']]],
        5 => ['id' => 'Laut adalah tempat dari banyak mineral di Bumi.', 'en' => 'The ocean is the place of many minerals on Earth', 'tense' => 'Simple Present Nominal', 'vocab' => ['Ocean' => ['id' => 'Laut', 'pos' => '(n)'], 'Place' => ['id' => 'Tempat', 'pos' => '(n)'], 'Many' => ['id' => 'Banyak', 'pos' => '(adj)'], 'Mineral' => ['id' => 'Mineral', 'pos' => '(n)'], 'Earth' => ['id' => 'Bumi', 'pos' => '(n)']]],
        6 => ['id' => 'Banyak kebijakan telah diterapkan untuk melindungi satwa liar.', 'en' => 'Many policies have been implemented to protect wildlife', 'tense' => 'Present Perfect Passive', 'vocab' => ['Many' => ['id' => 'Banyak', 'pos' => '(adj)'], 'Policy' => ['id' => 'Kebijakan', 'pos' => '(n)'], 'Implement' => ['id' => 'Menerapkan', 'pos' => '(v)'], 'Protect' => ['id' => 'Melindungi', 'pos' => '(v)'], 'Wildlife' => ['id' => 'Satwa liar', 'pos' => '(n)']]],
        7 => ['id' => 'Pendidikan adalah kunci untuk masa depan yang lebih baik.', 'en' => 'Education is the key to a better future', 'tense' => 'Simple Present Nominal', 'vocab' => ['Education' => ['id' => 'Pendidikan', 'pos' => '(n)'], 'Key' => ['id' => 'Kunci', 'pos' => '(n)'], 'Future' => ['id' => 'Masa depan', 'pos' => '(n)'], 'Better' => ['id' => 'Lebih baik', 'pos' => '(adj)']]],
        8 => ['id' => 'Mereka sedang mendiskusikan rencana proyek baru.', 'en' => 'They are discussing the new project plan', 'tense' => 'Present Continuous Verbal', 'vocab' => ['Discuss' => ['id' => 'Mendiskusikan', 'pos' => '(v)'], 'Plan' => ['id' => 'Rencana', 'pos' => '(n)'], 'Project' => ['id' => 'Proyek', 'pos' => '(n)'], 'New' => ['id' => 'Baru', 'pos' => '(adj)']]],
        9 => ['id' => 'Teknologi telah mengubah cara kita berkomunikasi.', 'en' => 'Technology has changed the way we communicate', 'tense' => 'Present Perfect Verbal', 'vocab' => ['Technology' => ['id' => 'Teknologi', 'pos' => '(n)'], 'Change' => ['id' => 'Mengubah', 'pos' => '(v)'], 'Way' => ['id' => 'Cara', 'pos' => '(n)'], 'Communicate' => ['id' => 'Berkomunikasi', 'pos' => '(v)']]],
        10 => ['id' => 'Gunung krakatau akan menjadi lebih tinggi.', 'en' => 'Mount Krakatoa will become higher', 'tense' => 'Simple Future Verbal', 'vocab' => ['Mount' => ['id' => 'Gunung', 'pos' => '(n)'], 'Become' => ['id' => 'Menjadi', 'pos' => '(v)'], 'Higher' => ['id' => 'Lebih tinggi', 'pos' => '(adj)']]],
        11 => ['id' => 'Apollo 11 mendarat di bulan 50 tahun lalu.', 'en' => 'Apollo 11 landed on the moon 50 years ago', 'tense' => 'Simple Past Verbal', 'vocab' => ['Land' => ['id' => 'Mendarat', 'pos' => '(v)'], 'Moon' => ['id' => 'Bulan', 'pos' => '(n)'], 'Ago' => ['id' => 'Lalu/Yang lalu', 'pos' => '(adv)']]],
        12 => ['id' => 'Pertanian telah berkembang di Asia sebelum di America.', 'en' => 'Agriculture had developed in Asia before in America', 'tense' => 'Past Perfect Verbal', 'vocab' => ['Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)'], 'Develop' => ['id' => 'Berkembang', 'pos' => '(v)'], 'Before' => ['id' => 'Sebelum', 'pos' => '(prep)']]],
        13 => ['id' => 'Pembangunan negara telah sedang diwujudkan saat ini.', 'en' => 'National development has been being realized at this moment', 'tense' => 'Present Perfect Continuous Passive', 'vocab' => ['National' => ['id' => 'Negara', 'pos' => '(adj)'], 'Development' => ['id' => 'Pembangunan', 'pos' => '(n)'], 'Realize' => ['id' => 'Mewujudkan', 'pos' => '(v)'], 'Moment' => ['id' => 'Saat', 'pos' => '(n)']]],
        14 => ['id' => 'Kami akan mengimplementasikan kebijakan baru bulan depan.', 'en' => 'We will implement the new policy next month', 'tense' => 'Simple Future Verbal', 'vocab' => ['Implement' => ['id' => 'Mengimplementasikan', 'pos' => '(v)'], 'Policy' => ['id' => 'Kebijakan', 'pos' => '(n)'], 'Next month' => ['id' => 'Bulan depan', 'pos' => '(adv)']]],
        15 => ['id' => 'Anak-anak itu bermain di taman setiap sore.', 'en' => 'Those children play in the park every afternoon', 'tense' => 'Simple Present Verbal', 'vocab' => ['Children' => ['id' => 'Anak-anak', 'pos' => '(n)'], 'Play' => ['id' => 'Bermain', 'pos' => '(v)'], 'Park' => ['id' => 'Taman', 'pos' => '(n)'], 'Every afternoon' => ['id' => 'Setiap sore', 'pos' => '(adv)']]],
        16 => ['id' => 'Peraturan harus diikuti secara ketat.', 'en' => 'Regulations must be followed strictly', 'tense' => 'Modal Passive', 'vocab' => ['Regulation' => ['id' => 'Peraturan', 'pos' => '(n)'], 'Must' => ['id' => 'Harus', 'pos' => '(modal)'], 'Follow' => ['id' => 'Mengikuti', 'pos' => '(v)'], 'Strictly' => ['id' => 'Secara ketat', 'pos' => '(adv)']]],
        17 => ['id' => 'Pemerintah sedang ceroboh dalam kebijakan ini.', 'en' => 'The government is being careless in this policy', 'tense' => 'Present Continuous Nominal', 'vocab' => ['Government' => ['id' => 'Pemerintah', 'pos' => '(n)'], 'Careless' => ['id' => 'Ceroboh', 'pos' => '(adj)'], 'Policy' => ['id' => 'Kebijakan', 'pos' => '(n)']]],
        18 => ['id' => 'Kerusakan ekosistem bisa menyebabkan kerusakan ekonomi.', 'en' => 'Ecosystem damage can cause economic damage', 'tense' => 'Modal Present', 'vocab' => ['Ecosystem' => ['id' => 'Ekosistem', 'pos' => '(n)'], 'Damage' => ['id' => 'Kerusakan', 'pos' => '(n)'], 'Can' => ['id' => 'Bisa', 'pos' => '(modal)'], 'Cause' => ['id' => 'Menyebabkan', 'pos' => '(v)'], 'Economic' => ['id' => 'Ekonomi', 'pos' => '(adj)']]],
        19 => ['id' => 'Iklim global telah dipengaruhi oleh aktivitas manusia selama 1 abad ini.', 'en' => 'Global climate has been influenced by human activity for this century', 'tense' => 'Present Perfect Passive', 'vocab' => ['Global' => ['id' => 'Global', 'pos' => '(adj)'], 'Climate' => ['id' => 'Iklim', 'pos' => '(n)'], 'Influence' => ['id' => 'Mempengaruhi', 'pos' => '(v)'], 'Human' => ['id' => 'Manusia', 'pos' => '(n)'], 'Activity' => ['id' => 'Aktivitas', 'pos' => '(n)'], 'Century' => ['id' => 'Abad', 'pos' => '(n)']]],
        20 => ['id' => 'Populasi Asia telah berada nomor 1 di dunia selama berabad - abad.', 'en' => 'Asia\'s population has been number 1 in the world for centuries', 'tense' => 'Present Perfect Nominal', 'vocab' => ['Population' => ['id' => 'Populasi', 'pos' => '(n)'], 'Number' => ['id' => 'Nomor', 'pos' => '(n)'], 'World' => ['id' => 'Dunia', 'pos' => '(n)'], 'Centuries' => ['id' => 'Berabad-abad', 'pos' => '(n)']]],
    ];

    private $meeting3FallbackParagraph = [
        'id' => 'Polusi plastik merusak lingkungan setiap hari. Sampah plastik sedang mencemari lautan di seluruh dunia. Para ilmuwan telah menemukan mikroplastik dalam tubuh hewan laut. Banyak komunitas telah lama memperingatkan bahaya plastik sekali pakai. Larangan penggunaan kantong plastik dapat mengurangi jumlah sampah di tempat umum. Botol plastik bekas didaur ulang oleh beberapa perusahaan ramah lingkungan. Pada masa lalu, masyarakat kurang menyadari dampak jangka panjang limbah plastik. Anak-anak sekolah sedang diajari tentang pentingnya pengelolaan sampah. Masalah polusi plastik adalah ancaman serius bagi keberlanjutan bumi. Tahun depan, pemerintah akan memberlakukan regulasi baru tentang penggunaan plastik. Program pengurangan plastik akan sedang dilaksanakan di berbagai kota besar. Para aktivis lingkungan akan telah mengorganisir kampanye global dalam beberapa bulan mendatang. Upaya global harus difokuskan pada solusi jangka panjang. Negara-negara berkembang bisa mengalami kesulitan dalam menerapkan kebijakan ramah lingkungan. Organisasi internasional telah lama berusaha menyatukan negara-negara untuk mengatasi krisis ini. Edukasi sejak dini merupakan kunci dalam mengubah kebiasaan konsumen. Pada masa lalu, penggunaan plastik adalah simbol kemajuan dan kemudahan. Jika tidak dikendalikan, polusi plastik akan menjadi bencana lingkungan yang lebih besar.',
        'en' => 'Plastic pollution damages the environment every day. Plastic waste is polluting oceans all over the world. Scientists have found microplastics in the bodies of marine animals. Many communities have long warned about the dangers of single-use plastic. The ban on plastic bags can reduce the amount of waste in public places. Used plastic bottles are recycled by several eco-friendly companies. In the past, society was less aware of the long-term impact of plastic waste. School children are being taught about the importance of waste management. The problem of plastic pollution is a serious threat to the earth\'s sustainability. Next year, the government will enforce new regulations on plastic use. Plastic reduction programs will be being implemented in various major cities. Environmental activists will have organized global campaigns in the coming months. Global efforts must be focused on long-term solutions. Developing countries could experience difficulties in implementing eco-friendly policies. International organizations have long been trying to unite countries to overcome this crisis. Early education is the key to changing consumer habits. In the past, plastic use was a symbol of progress and convenience. If not controlled, plastic pollution will become a greater environmental disaster.',
        'vocab' => [
            'Plastic' => ['id' => 'Plastik', 'pos' => '(n)'],
            'Pollution' => ['id' => 'Polusi', 'pos' => '(n)'],
            'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
            'Waste' => ['id' => 'Sampah/Limbah', 'pos' => '(n)'],
            'Ocean' => ['id' => 'Lautan', 'pos' => '(n)'],
            'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
            'Microplastic' => ['id' => 'Mikroplastik', 'pos' => '(n)'],
            'Single-use' => ['id' => 'Sekali pakai', 'pos' => '(adj)'],
            'Regulation' => ['id' => 'Regulasi', 'pos' => '(n)'],
            'Sustainability' => ['id' => 'Keberlanjutan', 'pos' => '(n)'],
            'Disaster' => ['id' => 'Bencana', 'pos' => '(n)']
        ]
    ];

    private $meeting4Questions = [
        1 => ['id' => 'Artefak kuno dapat dilestarikan oleh metode konservasi modern.', 'en' => 'Ancient artifacts can be preserved by modern conservation methods', 'vocab' => ['artefak' => 'artifact', 'kuno' => 'ancient', 'oleh' => 'by', 'metode' => 'method', 'konservasi' => 'conservation', 'modern' => 'modern']],
        2 => ['id' => 'Perubahan iklim mungkin mempercepat pemutihan terumbu karang.', 'en' => 'Climate change may accelerate coral bleaching', 'vocab' => ['perubahan' => 'change', 'iklim' => 'climate', 'mempercepat' => 'accelerate', 'pemutihan' => 'bleaching', 'terumbu karang' => 'coral reef']],
        3 => ['id' => 'Organisasi internasional mungkin adalah penggerak utama aksi iklim dunia.', 'en' => 'International organizations may be the main drivers of global climate action', 'vocab' => ['organisasi' => 'organization', 'internasional' => 'international', 'penggerak' => 'driver', 'utama' => 'main', 'aksi' => 'action', 'dunia' => 'global']],
        4 => ['id' => 'Negara-negara sebaiknya melindungi spesies yang terancam punah.', 'en' => 'Countries should protect endangered species', 'vocab' => ['negara' => 'country', 'melindungi' => 'protect', 'spesies' => 'species', 'terancam punah' => 'endangered']],
        5 => ['id' => 'Hutan tropis harus dilindungi dari deforestasi besar-besaran.', 'en' => 'Tropical forests must be protected from massive deforestation', 'vocab' => ['hutan' => 'forest', 'tropis' => 'tropical', 'dari' => 'from', 'deforestasi' => 'deforestation', 'besar-besaran' => 'massive']],
        6 => ['id' => 'Teknologi baru dapat menghasilkan solusi energi lebih efisien.', 'en' => 'New technology can produce more efficient energy solutions', 'vocab' => ['teknologi' => 'technology', 'baru' => 'new', 'menghasilkan' => 'produce', 'solusi' => 'solution', 'energi' => 'energy', 'lebih' => 'more', 'efisien' => 'efficient']],
        7 => ['id' => 'Kerja sama global harus menjadi prioritas utama.', 'en' => 'Global cooperation must be the top priority', 'vocab' => ['kerja sama' => 'cooperation', 'global' => 'global', 'menjadi' => 'be', 'prioritas' => 'priority', 'utama' => 'top']],
        8 => ['id' => 'Fosil baru mungkin ditemukan di daerah terpencil.', 'en' => 'New fossils may be found in remote areas', 'vocab' => ['fosil' => 'fossil', 'baru' => 'new', 'di' => 'in', 'daerah' => 'area', 'terpencil' => 'remote']],
        9 => ['id' => 'Data ini dapat merupakan bukti evolusi yang signifikan.', 'en' => 'This data can be significant evidence of evolution', 'vocab' => ['data' => 'data', 'ini' => 'this', 'merupakan' => 'be', 'bukti' => 'evidence', 'evolusi' => 'evolution', 'signifikan' => 'significant']],
        10 => ['id' => 'Pemerintah akan menerapkan kebijakan lingkungan baru tahun depan.', 'en' => 'The government will implement new environmental policies next year', 'vocab' => ['pemerintah' => 'government', 'menerapkan' => 'implement', 'kebijakan' => 'policy', 'lingkungan' => 'environmental', 'baru' => 'new', 'tahun depan' => 'next year']],
        11 => ['id' => 'Spesies langka sebaiknya dijaga oleh lembaga resmi.', 'en' => 'Rare species should be protected by official institutions', 'vocab' => ['spesies' => 'species', 'langka' => 'rare', 'oleh' => 'by', 'lembaga' => 'institution', 'resmi' => 'official']],
        12 => ['id' => 'Pendidikan sejak dini sebaiknya adalah kunci keberhasilan konservasi.', 'en' => 'Early education should be the key to conservation success', 'vocab' => ['pendidikan' => 'education', 'sejak dini' => 'early', 'kunci' => 'key', 'keberhasilan' => 'success', 'konservasi' => 'conservation']],
        13 => ['id' => 'Teknologi masa depan mungkin mengurangi polusi udara secara drastis.', 'en' => 'Future technology may reduce air pollution drastically', 'vocab' => ['teknologi' => 'technology', 'masa depan' => 'future', 'mengurangi' => 'reduce', 'polusi' => 'pollution', 'udara' => 'air', 'secara' => 'in a way', 'drastis' => 'drastically']],
        14 => ['id' => 'Bakteri tertentu dapat diuraikan oleh enzim khusus.', 'en' => 'Certain bacteria can be decomposed by special enzymes', 'vocab' => ['bakteri' => 'bacteria', 'tertentu' => 'certain', 'oleh' => 'by', 'enzim' => 'enzyme', 'khusus' => 'special']],
        15 => ['id' => 'Perjanjian ini akan menjadi dasar hukum perlindungan laut internasional.', 'en' => 'This agreement will be the legal basis for international marine protection', 'vocab' => ['perjanjian' => 'agreement', 'ini' => 'this', 'menjadi' => 'be', 'dasar' => 'basis', 'hukum' => 'legal', 'perlindungan' => 'protection', 'laut' => 'marine', 'internasional' => 'international']],
        16 => ['id' => 'Paus dapat dianggap sebagai hewan terbesar di bumi.', 'en' => 'Whales can be considered the largest animals on earth', 'vocab' => ['paus' => 'whale', 'sebagai' => 'as', 'hewan' => 'animal', 'terbesar' => 'largest', 'di' => 'on', 'bumi' => 'earth']],
        17 => ['id' => 'Energi terbarukan dapat menggantikan bahan bakar fosil sebagai sumber energi utama.', 'en' => 'Renewable energy can replace fossil fuels as the main energy source', 'vocab' => ['energi' => 'energy', 'terbarukan' => 'renewable', 'menggantikan' => 'replace', 'bahan bakar' => 'fuel', 'fosil' => 'fossil', 'sebagai' => 'as', 'sumber' => 'source', 'utama' => 'main']],
        18 => ['id' => 'Aturan baru akan diberlakukan di kawasan konservasi.', 'en' => 'New rules will be implemented in conservation areas', 'vocab' => ['aturan' => 'rule', 'baru' => 'new', 'di' => 'in', 'kawasan' => 'area', 'konservasi' => 'conservation']],
        19 => ['id' => 'Arkeolog harus mendokumentasikan penemuan mereka secara akurat.', 'en' => 'Archaeologists must document their findings accurately', 'vocab' => ['arkeolog' => 'archaeologist', 'mendokumentasikan' => 'document', 'penemuan' => 'finding', 'mereka' => 'their', 'secara' => 'in a way', 'akurat' => 'accurately']],
        20 => ['id' => 'Penemuan ini mungkin merupakan titik balik dalam riset medis.', 'en' => 'This discovery may be a turning point in medical research', 'vocab' => ['penemuan' => 'discovery', 'ini' => 'this', 'merupakan' => 'be', 'titik balik' => 'turning point', 'dalam' => 'in', 'riset' => 'research', 'medis' => 'medical']],
        21 => ['id' => 'Mamalia laut seharusnya mampu berkomunikasi melintasi jarak samudra menggunakan suara frekuensi rendah.', 'en' => 'Marine mammals should be able to communicate across ocean distances using low-frequency sounds', 'vocab' => ['mamalia' => 'mammal', 'laut' => 'marine', 'berkomunikasi' => 'communicate', 'melintasi' => 'across', 'jarak' => 'distance', 'samudra' => 'ocean', 'menggunakan' => 'using', 'suara' => 'sound', 'frekuensi' => 'frequency', 'rendah' => 'low']],
        22 => ['id' => 'Komunitas internasional mungkin akan mengadopsi peraturan lebih ketat untuk spesies terancam punah.', 'en' => 'The international community may adopt stricter regulations for endangered species', 'vocab' => ['komunitas' => 'community', 'internasional' => 'international', 'mengadopsi' => 'adopt', 'peraturan' => 'regulation', 'lebih' => 'more', 'ketat' => 'strict', 'untuk' => 'for', 'spesies' => 'species', 'terancam punah' => 'endangered']],
        23 => ['id' => 'Mahasiswa program kedokteran akan seharusnya menyelesaikan pelatihan klinis ekstensif sebelum lulus.', 'en' => 'Medical students will be supposed to complete extensive clinical training before graduation', 'vocab' => ['mahasiswa' => 'student', 'program' => 'program', 'kedokteran' => 'medical', 'menyelesaikan' => 'complete', 'pelatihan' => 'training', 'klinis' => 'clinical', 'ekstensif' => 'extensive', 'sebelum' => 'before', 'lulus' => 'graduation']],
        24 => ['id' => 'Peradaban kuno seharusnya mampu membangun monumen besar tanpa mesin modern.', 'en' => 'Ancient civilizations should have been able to build large monuments without modern machines', 'vocab' => ['peradaban' => 'civilization', 'kuno' => 'ancient', 'membangun' => 'build', 'monumen' => 'monument', 'besar' => 'large', 'tanpa' => 'without', 'mesin' => 'machine', 'modern' => 'modern']],
        25 => ['id' => 'Para peneliti akan meluncurkan satelit pemantau iklim global.', 'en' => 'Researchers will launch global climate monitoring satellites', 'vocab' => ['peneliti' => 'researcher', 'meluncurkan' => 'launch', 'satelit' => 'satellite', 'pemantau' => 'monitoring', 'iklim' => 'climate', 'global' => 'global']],
        26 => ['id' => 'Seluruh petugas laboratorium seharusnya memakai perlengkapan pelindung selama eksperimen.', 'en' => 'All laboratory staff should wear protective equipment during experiments', 'vocab' => ['seluruh' => 'all', 'petugas' => 'staff', 'laboratorium' => 'laboratory', 'memakai' => 'wear', 'perlengkapan' => 'equipment', 'pelindung' => 'protective', 'selama' => 'during', 'eksperimen' => 'experiment']],
        27 => ['id' => 'Tanaman tertentu harus mampu bertahan di lingkungan yang sangat kering.', 'en' => 'Certain plants must be able to survive in very dry environments', 'vocab' => ['tanaman' => 'plant', 'tertentu' => 'certain', 'bertahan' => 'survive', 'di' => 'in', 'lingkungan' => 'environment', 'sangat' => 'very', 'kering' => 'dry']],
        28 => ['id' => 'Pemerintah akan menerapkan kebijakan baru tentang sampah plastik.', 'en' => 'The government will implement new policies about plastic waste', 'vocab' => ['pemerintah' => 'government', 'menerapkan' => 'implement', 'kebijakan' => 'policy', 'baru' => 'new', 'tentang' => 'about', 'sampah' => 'waste', 'plastik' => 'plastic']],
        29 => ['id' => 'Astronaut akan bisa mengikuti protokol ketat selama misi luar angkasa.', 'en' => 'Astronauts will be able to follow strict protocols during space missions', 'vocab' => ['astronaut' => 'astronaut', 'mengikuti' => 'follow', 'protokol' => 'protocol', 'ketat' => 'strict', 'selama' => 'during', 'misi' => 'mission', 'luar angkasa' => 'space']],
        30 => ['id' => 'Manusia purba mampu bermigrasi antar benua.', 'en' => 'Ancient humans were able to migrate between continents', 'vocab' => ['manusia' => 'human', 'purba' => 'ancient', 'bermigrasi' => 'migrate', 'antar' => 'between', 'benua' => 'continent']]
    ];

    private $meeting4Paragraph = [
        'id' => 'Ini adalah paragraf contoh untuk pertemuan 4 karena teks asli tidak disediakan. Silakan terjemahkan kalimat ini dengan benar.',
        'en' => 'This is a sample paragraph for meeting 4 because the original text was not provided. Please translate this sentence correctly.',
        'sentences' => [],
        'vocab' => []
    ];
}