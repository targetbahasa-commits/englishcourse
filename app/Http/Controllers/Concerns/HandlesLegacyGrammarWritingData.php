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
    ];

    private $meeting3FallbackParagraph = [
        'id' => 'Upaya konservasi laut harus ditingkatkan untuk melindungi terumbu karang. Spesies langka mungkin dapat bertahan jika habitat mereka dijaga dengan baik. Masyarakat sebaiknya berpartisipasi aktif dalam menjaga kebersihan lingkungan.',
        'en' => 'Marine conservation efforts must be increased to protect coral reefs. Rare species may survive if their habitats are properly guarded. Society should actively participate in maintaining environmental cleanliness.',
        'vocab' => [
            'Conservation' => ['id' => 'Konservasi', 'pos' => '(n)'],
            'Habitat' => ['id' => 'Habitat', 'pos' => '(n)'],
            'Cleanliness' => ['id' => 'Kebersihan', 'pos' => '(n)'],
        ]
    ];

    private $meeting4Questions = [
        1 => ['id' => 'Peneliti tidak mengabaikan temuan statistik yang signifikan.', 'en' => 'Researchers do not ignore significant statistical findings', 'vocab' => ['researchers' => 'peneliti (n)', 'ignore' => 'mengabaikan (v1)', 'significant' => 'signifikan (adj)', 'findings' => 'temuan (n)']],
        2 => ['id' => 'Fasilitas ini bukan merupakan laboratorium utama.', 'en' => 'This facility is not the primary laboratory', 'vocab' => ['facility' => 'fasilitas (n)', 'primary' => 'utama (adj)', 'laboratory' => 'laboratorium (n)']],
        3 => ['id' => 'Laporan tahunan tersebut tidak dipublikasikan secara terbuka.', 'en' => 'The annual report is not published openly', 'vocab' => ['annual report' => 'laporan tahunan (n)', 'published' => 'dipublikasikan (v3)', 'openly' => 'secara terbuka (adv)']],
        4 => ['id' => 'Para analis tidak sedang mengabaikan fluktuasi pasar.', 'en' => 'The analysts are not ignoring market fluctuations', 'vocab' => ['analysts' => 'para analis (n)', 'ignoring' => 'mengabaikan (v-ing)', 'market fluctuations' => 'fluktuasi pasar (n)']],
        5 => ['id' => 'Kebijakan tersebut tidak sedang menjadi hambatan regulasi.', 'en' => 'The policy is not being a regulatory hindrance', 'vocab' => ['policy' => 'kebijakan (n)', 'regulatory' => 'regulasi (adj)', 'hindrance' => 'hambatan (n)']],
        6 => ['id' => 'Instrumen ilmiah tersebut tidak sedang dikalibrasi.', 'en' => 'The scientific instrument is not being calibrated', 'vocab' => ['scientific instrument' => 'instrumen ilmiah (n)', 'calibrated' => 'dikalibrasi (v3)']],
        7 => ['id' => 'Tim peneliti belum menyelesaikan evaluasi komprehensif.', 'en' => 'The research team has not completed the comprehensive evaluation', 'vocab' => ['research team' => 'tim peneliti (n)', 'completed' => 'menyelesaikan (v3)', 'comprehensive' => 'komprehensif (adj)']],
        8 => ['id' => 'Perusahaan tersebut belum pernah menjadi pimpinan pasar.', 'en' => 'The company has not been a market leader', 'vocab' => ['company' => 'perusahaan (n)', 'market leader' => 'pimpinan pasar (n)']],
        9 => ['id' => 'Dokumen rahasia tersebut belum disebarkan ke publik.', 'en' => 'The confidential document has not been distributed to the public', 'vocab' => ['confidential' => 'rahasia (adj)', 'document' => 'dokumen (n)', 'distributed' => 'disebarkan (v3)']],
        10 => ['id' => 'Para ilmuwan belum sedang mengamati fenomena tersebut.', 'en' => 'The scientists have not been observing the phenomenon', 'vocab' => ['scientists' => 'para ilmuwan (n)', 'observing' => 'mengamati (v-ing)', 'phenomenon' => 'fenomena (n)']],
        11 => ['id' => 'Otoritas terkait belum sedang menjadi transparan.', 'en' => 'The relevant authority has not been being transparent', 'vocab' => ['relevant authority' => 'otoritas terkait (n)', 'transparent' => 'transparan (adj)']],
        12 => ['id' => 'Infrastruktur tersebut belum sedang direnovasi.', 'en' => 'The infrastructure has not been being renovated', 'vocab' => ['infrastructure' => 'infrastruktur (n)', 'renovated' => 'direnovasi (v3)']],
        13 => ['id' => 'Dewan direksi tidak menyetujui usulan akuisisi kemarin.', 'en' => 'The board of directors did not approve the acquisition proposal yesterday', 'vocab' => ['board of directors' => 'dewan direksi (n)', 'approve' => 'menyetujui (v1)', 'acquisition' => 'akuisisi (n)']],
        14 => ['id' => 'Hasil eksperimen tersebut tidak konsisten minggu lalu.', 'en' => 'The experimental results were not consistent last week', 'vocab' => ['experimental results' => 'hasil eksperimen (n)', 'consistent' => 'konsisten (adj)']],
        15 => ['id' => 'Keputusan strategis tersebut tidak diambil tanpa pertimbangan.', 'en' => 'The strategic decision was not made without consideration', 'vocab' => ['strategic decision' => 'keputusan strategis (n)', 'consideration' => 'pertimbangan (n)']],
        16 => ['id' => 'Tim investigasi tidak sedang menginspeksi lokasi saat kejadian.', 'en' => 'The investigation team was not inspecting the site during the incident', 'vocab' => ['investigation team' => 'tim investigasi (n)', 'inspecting' => 'menginspeksi (v-ing)', 'incident' => 'kejadian (n)']],
        17 => ['id' => 'Kondisi ekonomi tidak sedang menjadi stabil pada periode itu.', 'en' => 'The economic condition was not being stable during that period', 'vocab' => ['economic condition' => 'kondisi ekonomi (n)', 'stable' => 'stabil (adj)']],
        18 => ['id' => 'Data mentah tersebut tidak sedang diolah oleh sistem.', 'en' => 'The raw data was not being processed by the system', 'vocab' => ['raw data' => 'data mentah (n)', 'processed' => 'diolah (v3)', 'system' => 'sistem (n)']],
        19 => ['id' => 'Perusahaan belum mengimplementasikan sistem baru sebelum krisis.', 'en' => 'The company had not implemented the new system before the crisis', 'vocab' => ['implemented' => 'mengimplementasikan (v3)', 'crisis' => 'krisis (n)']],
        20 => ['id' => 'Proyek tersebut belum pernah menjadi prioritas sebelumnya.', 'en' => 'The project had not been a priority before', 'vocab' => ['project' => 'proyek (n)', 'priority' => 'prioritas (n)']],
        21 => ['id' => 'Naskah akademik tersebut belum diterbitkan sebelum tahun 2020.', 'en' => 'The academic manuscript had not been published before 2020', 'vocab' => ['academic manuscript' => 'naskah akademik (n)', 'published' => 'diterbitkan (v3)']],
        22 => ['id' => 'Para peneliti belum sedang menganalisis sampel selama tiga bulan.', 'en' => 'The researchers had not been analyzing samples for three months', 'vocab' => ['researchers' => 'para peneliti (n)', 'analyzing' => 'menganalisis (v-ing)', 'samples' => 'sampel (n)']],
        23 => ['id' => 'Sektor finansial belum sedang menjadi produktif.', 'en' => 'The financial sector had not been being productive', 'vocab' => ['financial sector' => 'sektor finansial (n)', 'productive' => 'produktif (adj)']],
        24 => ['id' => 'Gedung cagar budaya tersebut belum sedang dipugar.', 'en' => 'The heritage building had not been being restored', 'vocab' => ['heritage building' => 'gedung cagar budaya (n)', 'restored' => 'dipugar (v3)']],
        25 => ['id' => 'Manajemen tidak akan mengeksekusi rencana tanpa verifikasi.', 'en' => 'Management will not execute the plan without verification', 'vocab' => ['management' => 'manajemen (n)', 'execute' => 'mengeksekusi (v1)', 'verification' => 'verifikasi (n)']],
        26 => ['id' => 'Proses adaptasi teknologi tidak akan mudah.', 'en' => 'The technology adaptation process will not be easy', 'vocab' => ['adaptation process' => 'proses adaptasi (n)', 'technology' => 'teknologi (n)']],
        27 => ['id' => 'Pelanggaran etik tersebut tidak akan ditoleransi oleh komite.', 'en' => 'The ethical violation will not be tolerated by the committee', 'vocab' => ['ethical violation' => 'pelanggaran etik (n)', 'tolerated' => 'ditoleransi (v3)', 'committee' => 'komite (n)']],
        28 => ['id' => 'Delegasi internasional tidak akan sedang berdiskusi besok pagi.', 'en' => 'The international delegation will not be discussing tomorrow morning', 'vocab' => ['international delegation' => 'delegasi internasional (n)', 'discussing' => 'berdiskusi (v-ing)']],
        29 => ['id' => 'Manajer tidak akan sedang menjadi kaku dalam negosiasi.', 'en' => 'The manager will not be being rigid in negotiations', 'vocab' => ['manager' => 'manajer (n)', 'rigid' => 'kaku (adj)', 'negotiations' => 'negosiasi (n)']],
        30 => ['id' => 'Fasilitas manufaktur tidak akan sedang diuji coba.', 'en' => 'The manufacturing facility will not be being tested', 'vocab' => ['manufacturing facility' => 'fasilitas manufaktur (n)', 'tested' => 'diuji coba (v3)']],
        31 => ['id' => 'Tim tidak akan sudah mencapai kesepakatan pada pukul lima.', 'en' => 'The team will not have reached an agreement by five oclock', 'vocab' => ['team' => 'tim (n)', 'reached' => 'mencapai (v3)', 'agreement' => 'kesepakatan (n)']],
        32 => ['id' => 'Infrastruktur baru tidak akan sudah siap pada kuartal depan.', 'en' => 'The new infrastructure will not have been ready by next quarter', 'vocab' => ['infrastructure' => 'infrastruktur (n)', 'quarter' => 'kuartal (n)']],
        33 => ['id' => 'Proyek penelitian tidak akan sudah diselesaikan akhir tahun ini.', 'en' => 'The research project will not have been completed by the end of this year', 'vocab' => ['research project' => 'proyek penelitian (n)', 'completed' => 'diselesaikan (v3)']],
        34 => ['id' => 'Para pakar tidak akan sudah sedang meneliti masalah tersebut.', 'en' => 'The experts will not have been researching that issue for long', 'vocab' => ['experts' => 'para pakar (n)', 'researching' => 'meneliti (v-ing)', 'issue' => 'masalah (n)']],
        35 => ['id' => 'Kondisi tidak akan sudah sedang menjadi kondusif.', 'en' => 'Conditions will not have been being conducive', 'vocab' => ['conditions' => 'kondisi (n)', 'conducive' => 'kondusif (adj)']],
        36 => ['id' => 'Jaringan komunikasi tidak akan sudah sedang diperbarui.', 'en' => 'The communication network will not have been being upgraded', 'vocab' => ['communication network' => 'jaringan komunikasi (n)', 'upgraded' => 'diperbarui (v3)']],
        37 => ['id' => 'Pemerintah tidak akan menerapkan sanksi ekstrem.', 'en' => 'The government would not enforce extreme sanctions', 'vocab' => ['government' => 'pemerintah (n)', 'enforce' => 'menerapkan (v1)', 'extreme sanctions' => 'sanksi ekstrem (n)']],
        38 => ['id' => 'Asumsi awal tersebut tidak akan akurat.', 'en' => 'The initial assumption would not be accurate', 'vocab' => ['initial assumption' => 'asumsi awal (n)', 'accurate' => 'akurat (adj)']],
        39 => ['id' => 'Rekomendasi teknis tersebut tidak akan ditolak oleh dewan.', 'en' => 'The technical recommendation would not be rejected by the board', 'vocab' => ['technical recommendation' => 'rekomendasi teknis (n)', 'rejected' => 'ditolak (v3)']],
        40 => ['id' => 'Para ilmuwan tidak akan sedang melakukan uji klinis.', 'en' => 'The scientists would not be conducting clinical trials', 'vocab' => ['scientists' => 'para ilmuwan (n)', 'conducting' => 'melakukan (v-ing)', 'clinical trials' => 'uji klinis (n)']],
        41 => ['id' => 'Otoritas tidak akan sedang menjadi kooperatif.', 'en' => 'The authority would not be being cooperative', 'vocab' => ['authority' => 'otoritas (n)', 'cooperative' => 'kooperatif (adj)']],
        42 => ['id' => 'Sistem jaringan tidak akan sedang diperbaiki.', 'en' => 'The network system would not be being repaired', 'vocab' => ['network system' => 'sistem jaringan (n)', 'repaired' => 'diperbaiki (v3)']],
        43 => ['id' => 'Tim riset tidak akan sudah melupakan protokol keselamatan.', 'en' => 'The research team would not have forgotten the safety protocol', 'vocab' => ['research team' => 'tim riset (n)', 'forgotten' => 'melupakan (v3)', 'safety protocol' => 'protokol keselamatan (n)']],
        44 => ['id' => 'Eksperimen tersebut tidak akan sudah menjadi sukses.', 'en' => 'The experiment would not have been successful', 'vocab' => ['experiment' => 'eksperimen (n)', 'successful' => 'sukses (adj)']],
        45 => ['id' => 'Laporan evaluasi tidak akan sudah diserahkan.', 'en' => 'The evaluation report would not have been submitted', 'vocab' => ['evaluation report' => 'laporan evaluasi (n)', 'submitted' => 'diserahkan (v3)']],
        46 => ['id' => 'Mereka tidak akan sudah sedang bernegosiasi.', 'en' => 'They would not have been negotiating', 'vocab' => ['negotiating' => 'bernegosiasi (v-ing)']],
        47 => ['id' => 'Situasi tidak akan sudah sedang menjadi stabil.', 'en' => 'The situation would not have been being stable', 'vocab' => ['situation' => 'situasi (n)', 'stable' => 'stabil (adj)']],
        48 => ['id' => 'Dokumen hukum tidak akan sudah sedang direvisi.', 'en' => 'The legal document would not have been being revised', 'vocab' => ['legal document' => 'dokumen hukum (n)', 'revised' => 'direvisi (v3)']],
        49 => ['id' => 'Staf peneliti tidak boleh memanipulasi data eksperimen.', 'en' => 'Research staff must not manipulate experimental data', 'vocab' => ['research staff' => 'staf peneliti (n)', 'manipulate' => 'memanipulasi (v1)', 'experimental data' => 'data eksperimen (n)']],
        50 => ['id' => 'Hipotesis tersebut mungkin tidak valid.', 'en' => 'The hypothesis might not be valid', 'vocab' => ['hypothesis' => 'hipotesis (n)', 'valid' => 'valid (adj)']],
        51 => ['id' => 'Pintu laboratorium tidak bisa diakses tanpa otorisasi.', 'en' => 'The laboratory door cannot be accessed without authorization', 'vocab' => ['laboratory door' => 'pintu laboratorium (n)', 'accessed' => 'diakses (v3)', 'authorization' => 'otorisasi (n)']],
    ];

    private $meeting4Paragraph = [
        'id' => 'Para peneliti harus memverifikasi data laboratorium secara berkala. Limbah kimia berbahaya tidak boleh dibuang sembarangan ke lingkungan. Seluruh staf laboratorium harus selalu waspada terhadap potensi bahaya. Laporan eksperimen ini dapat diselesaikan dalam dua hari. Hasil tes awal mungkin tidak akurat tanpa prosedur standar. Setiap asisten laboratorium harus mengenakan alat pelindung diri lengkap. Bahan kimia reaktif harus disimpan di dalam lemari asam khusus. Peralatan gelas laboratorium tidak boleh dibiarkan kotor setelah digunakan. Semua ilmuwan seharusnya mencatat setiap perubahan suhu secara cermat. Sampel biologis tersebut dapat terkontaminasi oleh udara luar. Ventilasi ruangan laboratorium harus selalu berfungsi secara optimal. Teknisi baru bisa menjadi sangat terampil melalui pelatihan intensif.',
        'en' => 'Researchers must verify laboratory data periodically. Hazardous chemical waste must not be disposed of carelessly into the environment. All laboratory staff must always be alert to potential hazards. This experiment report can be completed in two days. Initial test results might not be accurate without standard procedures. Every laboratory assistant must wear complete personal protective equipment. Reactive chemicals must be stored in a special fume hood. Laboratory glassware must not be left dirty after use. All scientists should record every temperature change carefully. The biological sample can be contaminated by outside air. Laboratory room ventilation must always function optimally. New technicians can become very skilled through intensive training.',
        'sentences' => [],
        'vocab' => [
            'verify' => ['id' => 'memverifikasi', 'pos' => '(v1)'],
            'periodically' => ['id' => 'secara berkala', 'pos' => '(adv)'],
            'hazardous chemical waste' => ['id' => 'limbah kimia berbahaya', 'pos' => '(n)'],
            'dispose of' => ['id' => 'membuang', 'pos' => '(v1)'],
            'carelessly' => ['id' => 'sembarangan', 'pos' => '(adv)'],
            'laboratory staff' => ['id' => 'staf laboratorium', 'pos' => '(n)'],
            'alert' => ['id' => 'waspada', 'pos' => '(adj)'],
            'potential hazard' => ['id' => 'potensi bahaya', 'pos' => '(n)'],
            'experiment report' => ['id' => 'laporan eksperimen', 'pos' => '(n)'],
            'complete' => ['id' => 'menyelesaikan', 'pos' => '(v1)'],
            'initial test' => ['id' => 'tes awal', 'pos' => '(n)'],
            'accurate' => ['id' => 'akurat', 'pos' => '(adj)'],
            'standard procedure' => ['id' => 'prosedur standar', 'pos' => '(n)'],
            'laboratory assistant' => ['id' => 'asisten laboratorium', 'pos' => '(n)'],
            'personal protective equipment' => ['id' => 'alat pelindung diri', 'pos' => '(n)'],
            'reactive chemical' => ['id' => 'bahan kimia reaktif', 'pos' => '(n)'],
            'fume hood' => ['id' => 'lemari asam', 'pos' => '(n)'],
            'store' => ['id' => 'menyimpan', 'pos' => '(v1)'],
            'glassware' => ['id' => 'peralatan gelas', 'pos' => '(n)'],
            'dirty' => ['id' => 'kotor', 'pos' => '(adj)'],
            'record' => ['id' => 'mencatat', 'pos' => '(v1)'],
            'temperature change' => ['id' => 'perubahan suhu', 'pos' => '(n)'],
            'carefully' => ['id' => 'secara cermat', 'pos' => '(adv)'],
            'biological sample' => ['id' => 'sampel biologis', 'pos' => '(n)'],
            'contaminate' => ['id' => 'mengontaminasi / mencemari', 'pos' => '(v1)'],
            'ventilation' => ['id' => 'ventilasi', 'pos' => '(n)'],
            'optimally' => ['id' => 'secara optimal', 'pos' => '(adv)'],
            'skilled' => ['id' => 'terampil', 'pos' => '(adj)'],
            'intensive training' => ['id' => 'pelatihan intensif', 'pos' => '(n)'],
        ],
    ];
}