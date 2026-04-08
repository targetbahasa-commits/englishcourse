<?php

namespace App\Services;

class ToeflReadingPracticeData
{
    public static function catalog(): array
    {
        $packages = [];

        foreach (range(1, 10) as $number) {
            $packages[] = [
                'package_number' => $number,
                'title' => 'Paket ' . $number,
                'subtitle' => 'Reading Comprehension',
                'status' => 'coming_soon',
                'description' => 'Paket soal reading akan segera tersedia.',
            ];
        }

        $packages[0] = [
            'package_number' => 1,
            'title' => 'Practice Test 01',
            'subtitle' => '5 Passages • 50 Questions',
            'status' => 'available',
            'description' => 'Latihan reading TOEFL ITP lengkap dengan 50 soal dan cek skor langsung.',
        ];

        $packages[1] = [
            'package_number' => 2,
            'title' => 'Practice Test 02',
            'subtitle' => '5 Passages • 50 Questions',
            'status' => 'available',
            'description' => 'Latihan reading TOEFL ITP paket 2 lengkap dengan 50 soal dan cek skor langsung.',
        ];

        return $packages;
    }

    public static function package(int $number): ?array
    {
        return match ($number) {
            1 => self::packageOne(),
            2 => self::packageTwo(),
            default => null,
        };
    }

    private static function attachExplanations(array $passages, int $packageNumber): array
    {
        $bank = self::explanationBank($packageNumber);

        return array_map(function (array $passage) use ($bank, $packageNumber) {
            if (!isset($passage['questions']) || !is_array($passage['questions'])) {
                return $passage;
            }

            $passage['questions'] = array_map(function (array $question) use ($bank, $packageNumber) {
                $number = (int) ($question['number'] ?? 0);
                $question['explanation'] = $bank[$number] ?? self::buildDefaultExplanation($question);
                $question['distractor_explanations'] = self::buildDistractorExplanations($question, $packageNumber);
                return $question;
            }, $passage['questions']);

            return $passage;
        }, $passages);
    }

    private static function buildDefaultExplanation(array $question): string
    {
        $answer = $question['answer'] ?? '-';
        $options = $question['options'] ?? [];
        $optionText = $options[$answer] ?? '';

        if ($optionText !== '') {
            return 'Jawaban benar adalah ' . $answer . ' karena opsi ini paling sesuai dengan informasi utama pada passage: ' . $optionText . '.';
        }

        return 'Jawaban benar adalah ' . $answer . ' karena paling sesuai dengan isi passage.';
    }

    private static function buildDistractorExplanations(array $question, int $packageNumber): array
    {
        $options = $question['options'] ?? [];
        $answer = $question['answer'] ?? '';
        $questionType = self::detectQuestionType((string) ($question['text'] ?? ''));
        $number = (int) ($question['number'] ?? 0);
        $manual = self::manualDistractorBank($packageNumber)[$number] ?? [];
        $feedback = [];

        foreach ($options as $letter => $optionText) {
            if ($letter === $answer) {
                continue;
            }

            $feedback[$letter] = $manual[$letter]
                ?? self::distractorReasonByType($questionType, (string) $optionText, (string) ($options[$answer] ?? ''));
        }

        return $feedback;
    }

    private static function manualDistractorBank(int $packageNumber): array
    {
        $banks = [
            1 => [
            1 => [
                'B' => 'Pilihan ini terlalu sempit karena passage tidak hanya membahas kesulitan mencari makanan, tetapi keseluruhan pola parental care pada berbagai hewan.',
                'C' => 'Pilihan ini terlalu sempit dan hanya menyorot mamalia, padahal passage juga membandingkannya dengan ikan, reptil, dan serangga.',
                'D' => 'Pilihan ini hanya menyorot satu gagasan turunan tentang kemandirian anak mamalia, bukan inti bahasan seluruh passage.',
            ],
            2 => [
                'A' => 'Daftar hewan tidak dipakai untuk membandingkan kebiasaan makan antar mamalia, melainkan menegaskan kesamaan dasar semua mamalia.',
                'B' => 'Passage tidak sedang menjelaskan sejarah definisi mamalia, tetapi mendukung klaim bahwa feeding young adalah ciri mamalia.',
                'D' => 'Istilah nonelective memang disebut, tetapi fungsi daftar hewan adalah menunjukkan universalitas ciri itu pada semua jenis mamalia.',
            ],
            3 => [
                'A' => 'Sit on tidak sesuai konteks karena kalimat membahas parental behavior setelah menetas/lahir, bukan tindakan duduk di atas telur.',
                'B' => 'Move tidak menangkap makna perawatan keturunan yang menjadi fokus frasa tend their offspring.',
                'C' => 'Notice terlalu lemah maknanya; tend dalam konteks ini menuntut tindakan aktif merawat, bukan sekadar menyadari.',
            ],
            4 => [
                'A' => 'Passage tidak menyatakan praktik ini tidak dikenal pada ikan; yang ditegaskan adalah pada banyak ikan orang tua tidak memberi makan langsung.',
                'B' => 'Passage justru mengaitkan feeding dengan ukuran/kemampuan anak hewan menghadapi lingkungan secara mandiri.',
                'C' => 'Tidak ada dukungan bahwa memberi makan anak berbahaya bagi orang tua; fokus penulis adalah manfaat survival bagi keturunan.',
            ],
            5 => [
                'B' => 'Preparing kurang tepat karena konteksnya bukan sekadar menyiapkan, tetapi menyediakan pasokan makanan siap dimakan larva.',
                'C' => 'Building tidak sesuai karena provisioning di sini terkait makanan, bukan membangun sarang atau struktur.',
                'D' => 'Expanding tidak terkait konteks; kata ini tidak menggambarkan tindakan menaruh persediaan makanan untuk anak.',
            ],
            6 => [
                'B' => 'Passage menyebut serangga menaruh mangsa di sel/sarang, bukan menempatkan sarang dekat mangsa hidup di alam.',
                'C' => 'Mencari makanan jauh dari sarang bukan poin utama; yang ditekankan adalah penyimpanan makanan bagi larva sebelum menetas.',
                'D' => 'Tidak ada informasi tentang sumber air; detail yang disebut spesifik pada ulat/laba-laba yang dilumpuhkan dan disimpan.',
            ],
            7 => [
                'A' => 'Opportunity tidak tepat karena edge di sini bermakna keunggulan kompetitif dalam survival, bukan sekadar kesempatan.',
                'C' => 'Purpose tidak sesuai konteks; edge menjelaskan hasil/benefit strategi reproduksi, bukan tujuan abstrak.',
                'D' => 'Rest sama sekali tidak relevan dengan konteks evolusioner tentang keunggulan keturunan.',
            ],
            8 => [
                'A' => 'Secara struktur kalimat, it tidak merujuk pada feeding, melainkan pada young animal yang menghadapi momen mandiri.',
                'B' => 'Moment bukan referen yang logis karena kata ganti it menjelaskan sesuatu yang tumbuh sampai ukuran tertentu.',
                'D' => 'Size adalah atribut, bukan entitas utama yang menjadi subjek klausa it is better able to cope.',
            ],
            9 => [
                'A' => 'Passage tidak menyebut fase ini sebagai paling rentan; inti paragraf menegaskan puncak kerentanan saat pertama kali mandiri.',
                'B' => 'Jumlah anak tidak dijadikan faktor utama kerentanan dalam passage.',
                'C' => 'Usia beberapa hari tidak disebut sebagai kondisi paling defenseless; penulis menandai momen kemandirian sebagai titik paling rawan.',
            ],
            10 => [
                'A' => 'Raised berarti dibesarkan, bukan dilindungi dari fluktuasi pasokan makanan seperti konteks kalimat di passage.',
                'C' => 'Hatched terkait proses menetas, tidak sejalan dengan makna shielded yang menekankan proteksi.',
                'D' => 'Valued berarti dihargai, berbeda jauh dari makna perlindungan yang dimaksud penulis.',
            ],
            11 => [
                'A' => 'Asal-usul dekorasi tekstil hanya dibahas sekilas sebagai latar sejarah woodcut, bukan fokus utama seluruh passage.',
                'B' => 'Karakteristik cetakan berkualitas memang disebut, tetapi hanya sebagai bagian kecil dari pembahasan dua teknik printmaking.',
                'D' => 'Passage tidak berfokus pada jenis kertas, melainkan proses, ciri, dan dampak produksi woodcut serta engraving.',
            ],
            12 => [
                'B' => 'Complex tidak sesuai karena prime examples menandakan contoh utama, bukan contoh yang rumit.',
                'C' => 'General terlalu umum; prime di sini menunjuk contoh yang paling penting/utama dalam kategori.',
                'D' => 'Recent tidak relevan karena prime tidak berkaitan dengan waktu, tetapi dengan tingkat kepentingan.',
            ],
            13 => [
                'A' => 'Paragraf tidak membahas temuan woodcut di China secara rinci; itu hanya informasi pengantar sebelum penjelasan proses.',
                'B' => 'Penggunaan woodcut di tekstil disebut singkat, bukan tujuan utama paragraf kedua.',
                'D' => 'Masuknya woodcut ke Eropa disebut, tetapi fokus paragraf tetap pada langkah-langkah pembuatan woodcut.',
            ],
            14 => [
                'A' => 'Burned tidak sesuai karena konteks engraving menggambarkan penggoresan/ukiran pada pelat logam, bukan pembakaran.',
                'C' => 'Framed tidak berkaitan dengan tindakan membuat alur pada pelat metal.',
                'D' => 'Baked tidak relevan dengan proses intaglio yang menekankan mengiris atau memahat permukaan.',
            ],
            15 => [
                'A' => 'Patterns disebut sebagai objek penggunaan awal, tetapi tidak diberi definisi istilah teknis.',
                'B' => 'Grain muncul dalam konteks arah potongan kayu, bukan didefinisikan secara khusus sebagai istilah.',
                'D' => 'Grooves dijelaskan secara fungsional, tetapi istilah yang benar-benar diperkenalkan sebagai alat adalah burin.',
            ],
            16 => [
                'B' => 'Accurate berarti tepat, sedangkan distinctive menekankan kekhasan/ciri pembeda.',
                'C' => 'Irregular berarti tidak teratur, bukan makna yang dimaksud dalam frasa distinctive characteristics.',
                'D' => 'Similar berlawanan nuansa karena distinctive justru menunjukkan perbedaan khas.',
            ],
            17 => [
                'A' => 'Pernyataan ini benar dan didukung langsung oleh teks: engraving berkembang dari seni goldsmith.',
                'C' => 'Pernyataan ini juga benar karena passage menyebut asal engraving di abad ke-15.',
                'D' => 'Ini benar karena engraving dijelaskan sebagai proses mengukir (incise) pelat logam.',
            ],
            18 => [
                'A' => 'Imitate tidak cocok karena kalimat membahas hasil yang dapat dihasilkan metode cetak, bukan meniru sesuatu.',
                'C' => 'Revise berarti merevisi, bukan makna yang sesuai dengan konteks output cetakan.',
                'D' => 'Contrast tidak tepat karena yield dalam konteks ini bermakna menghasilkan jumlah cetakan.',
            ],
            19 => [
                'A' => 'Desain sedikit terangkat adalah ciri relief woodcut, bukan kesamaan dengan engraving yang intaglio.',
                'B' => 'Hatching/cross-hatching terutama dijelaskan pada engraving, jadi bukan kesamaan utama keduanya.',
                'C' => 'Keduanya tidak pertama kali digunakan di Eropa; woodcut lebih dahulu dipakai di China.',
            ],
            20 => [
                'B' => 'Teks tidak menekankan peningkatan mutu kertas/ink sebagai alasan akses publik, tetapi faktor biaya rendah.',
                'C' => 'Jumlah pelaku industri bukan poin utama; yang ditekankan adalah produksi massal menurunkan biaya.',
                'D' => 'Passage tidak menyebut turunnya permintaan; justru akses meluas karena harga lebih terjangkau.',
            ],
            21 => [
                'A' => 'Ini justru benar karena passage menyebut cetak bisa pada kertas atau material lain.',
                'B' => 'Ini benar karena gambar pada hasil cetak menempel dalam posisi terbalik (reverse).',
                'C' => 'Ini juga benar karena passage menjelaskan gradasi terang-gelap melalui teknik garis dan kontras.',
            ],
            22 => [
                'A' => 'Perkembangan pertanian memang bagian penting, tetapi passage lebih luas membahas evolusi budaya dan masyarakatnya.',
                'B' => 'Lokasi kota/desa disebut sebagai detail pendukung, bukan ide utama seluruh bacaan.',
                'D' => 'Konstruksi mound dibahas, tetapi hanya salah satu ciri budaya, bukan fokus utama passage.',
            ],
            23 => [
                'A' => 'Perdagangan berkembang, tetapi efek langsung yang secara eksplisit ditekankan setelah pertanian adalah terbentuknya permukiman tetap.',
                'C' => 'Passage tidak menyebut konflik lahan sebagai akibat utama kebangkitan pertanian.',
                'D' => 'Tidak ada informasi bahwa pertanian menyebabkan migrasi mereka ke Rocky Mountains.',
            ],
            24 => [
                'B' => 'Adena-Hopewell bukan nama dua negara, melainkan nama budaya yang diambil dari situs/lokasi awal.',
                'C' => 'Istilah ini bukan penghormatan untuk dua pemimpin tertentu dalam teks.',
                'D' => 'Passage tidak mendefinisikan istilah ini sebagai dua rute dagang utama.',
            ],
            25 => [
                'A' => 'Producing berarti memproduksi, sedangkan bartering dalam konteks ini adalah menukar barang antar kelompok.',
                'C' => 'Transporting hanya memindahkan, bukan inti aktivitas barter yang ditekankan teks.',
                'D' => 'Loading tidak berhubungan dengan makna perdagangan tukar-menukar pada kalimat tersebut.',
            ],
            26 => [
                'A' => 'Conquered terlalu kuat dan bernuansa penaklukan militer, sementara konteksnya pergantian dominasi budaya.',
                'B' => 'Preceded berarti mendahului; arah maknanya berlawanan dengan supplanted pada kalimat.',
                'D' => 'Imitated tidak sesuai karena kalimat menegaskan budaya lama digantikan, bukan ditiru.',
            ],
            27 => [
                'A' => 'Sekitar A.D. 400 adalah periode kemunduran Hopewell, bukan puncak Mississippian.',
                'B' => 'Rentang ini adalah masa transisi, bukan titik puncak yang disebut eksplisit dalam passage.',
                'D' => 'Abad ke-16 terkait awal kedatangan Eropa, bukan periode puncak kejayaan budaya Mississippian.',
            ],
            28 => [
                'B' => 'Passage tidak menekankan penjualan hasil panen ke kelompok lain sebagai perbedaan utama pertanian mereka.',
                'C' => 'Ini bertentangan dengan teks karena varietas jagung baru justru mampu hidup di tanah basah dan iklim relatif sejuk.',
                'D' => 'Tidak ada keterangan bahwa mereka menanam pangan khusus untuk elite agama sebagai pembeda utama.',
            ],
            29 => [
                'A' => 'Pernyataan ini tidak menjadi tujuan utama penulis saat menyebut children of the Sun; fokusnya hubungan ke pertanian.',
                'B' => 'Penulis tidak sedang berargumen umum tentang agama, tetapi menunjukkan kaitan kepercayaan dengan produksi pangan.',
                'D' => 'Contoh ini bukan deskripsi ritual spesifik, melainkan bukti pentingnya pertanian dalam identitas budaya.',
            ],
            30 => [
                'A' => 'Passed on tidak sesuai karena charged with di sini bermakna diberi tanggung jawab menjaga api suci.',
                'B' => 'Experienced at menyatakan keahlian, sementara konteks kalimat membahas penugasan resmi.',
                'C' => 'Interested in adalah minat, bukan makna tugas/amanat pada frasa charged with.',
            ],
            31 => [
                'A' => 'Ini justru disebut sebagai fungsi mound: lokasi upacara keagamaan.',
                'C' => 'Passage secara eksplisit menyebut mound juga dipakai sebagai lokasi perdagangan.',
                'D' => 'Teks menyatakan pada waktu tertentu mound digunakan sebagai tempat pemakaman.',
            ],
            32 => [
                'A' => 'Popularitas turnpike dibahas, tetapi kerangka utama paragraf adalah bagaimana proyek jalan baru dibiayai.',
                'C' => 'Pengembangan interior muncul sebagai latar motivasi, bukan sudut utama pembahasan paragraf 1.',
                'D' => 'Aturan penggunaan jalan disebut sekilas; fokus yang lebih ditekankan adalah model pendanaan dan charter swasta.',
            ],
            33 => [
                'A' => 'Unsafe tidak sepenuhnya menangkap makna primitive dalam konteks ini; yang dimaksud adalah kondisi transportasi yang belum berkembang.',
                'B' => 'Unknown tidak tepat karena sistem transportasi itu ada, hanya masih sederhana dan minim infrastruktur.',
                'C' => 'Inexpensive tidak dibahas sebagai makna primitive pada kalimat awal.',
            ],
            34 => [
                'A' => 'Passage menyebut kebanyakan jalan menuju river town atau seaport terdekat, bukan antar komunitas pedalaman.',
                'B' => 'Koneksi antarnegeri belum dominan melalui jalan darat; interstate commerce lebih banyak lewat kapal layar.',
                'D' => 'Construction sites tidak disebut sebagai titik akhir utama jaringan jalan saat itu.',
            ],
            35 => [
                'A' => 'In need of menyatakan kebutuhan, sedangkan frasa on the threshold of menandakan awal fase baru.',
                'B' => 'In place of berarti penggantian, tidak cocok dengan konteks transisi menuju era pembangunan jalan.',
                'D' => 'With the purpose of menekankan tujuan, bukan posisi waktu di ambang sebuah era.',
            ],
            36 => [
                'B' => 'Teks tidak menekankan peralatan swasta lebih baik; alasan utama yang disebut adalah keterbatasan dana negara bagian.',
                'C' => 'Kecepatan pembangunan tidak menjadi alasan eksplisit dalam passage.',
                'D' => 'Pengetahuan interior bukan poin utama; motivasi utamanya tetap soal kemampuan pembiayaan.',
            ],
            37 => [
                'B' => 'Company adalah objek yang diberi wewenang, bukan subjek yang melakukan careful regulation pada rates.',
                'C' => 'Authority adalah konsep kewenangan, bukan referen kata ganti it dalam klausa tersebut.',
                'D' => 'Payment tidak sesuai secara gramatikal maupun logika konteks kalimat.',
            ],
            38 => [
                'A' => 'Investment tidak sama dengan imitation; konteksnya meniru keberhasilan model Lancaster Pike.',
                'B' => 'Suggestion hanya usulan, sedangkan imitation berarti tindakan nyata mencontoh model yang berhasil.',
                'C' => 'Increasing tidak menggambarkan makna meniru yang muncul dari konteks kalimat.',
            ],
            39 => [
                'A' => 'Passage tidak menekankan Virginia membangun jalan tanpa tollgates; kontras utamanya adalah sumber pendanaan publik.',
                'C' => 'Angka 1,500 miles merujuk New York pada 1810, bukan Virginia dalam satu tahun.',
                'D' => 'Tidak ada bagian yang menyebut Virginia memperkenalkan hukum baru pembatasan jalan sebagai poin utama.',
            ],
            40 => [
                'A' => 'Passage tidak menyatakan roda itu unik langka; yang ditekankan adalah fungsinya menghadapi jalan buruk.',
                'B' => 'Asal Jerman terkait pengembang wagon, bukan asal fitur roda besar sebagai fokus makna kalimat.',
                'D' => 'Justru desain roda membantu mengurangi masalah pada jalan rusak, bukan penyebab kerusakan muatan.',
            ],
            41 => [
                'B' => 'Passage tidak membahas batuan garam yang mengesankan sebagai objek utama, melainkan proses garam merusak batuan.',
                'C' => 'Jumlah produksi garam tidak menjadi fokus; teks menekankan mekanisme weathering oleh kristal garam.',
                'D' => 'Dampak pada jalan/kendaraan hanya contoh pembuka, bukan topik inti pembahasan passage.',
            ],
            42 => [
                'B' => 'Groundwater table adalah sumber air asin, tetapi kata ganti it pada kalimat tersebut merujuk pada salty water yang bergerak naik.',
                'C' => 'Capillary action adalah prosesnya, bukan benda/zat yang mencapai permukaan.',
                'D' => 'Sediment adalah medium yang dilalui, bukan referen kata ganti it pada klausa akhir.',
            ],
            43 => [
                'B' => 'Reduce berlawanan makna karena exert pressure justru berarti memberikan tekanan pada batu.',
                'C' => 'Replace tidak sesuai konteks mekanis pertumbuhan kristal yang menekan retakan batuan.',
                'D' => 'Control terlalu umum dan tidak menangkap aksi fisik langsung pada kata exert.',
            ],
            44 => [
                'B' => 'Ketersediaan air memang disebut untuk kristal, tetapi inti perbandingan dengan akar adalah kemampuan memecah permukaan keras.',
                'C' => 'Perbandingan tidak berfokus pada respons cepat terhadap suhu, melainkan gaya dorong yang memecah batu.',
                'D' => 'Kenaikan air asin dari groundwater table dibahas di bagian lain, bukan inti analogi akar vs kristal.',
            ],
            45 => [
                'A' => 'Penulis tidak menawarkan teori alternatif, melainkan memperluas mekanisme kerusakan batu oleh garam.',
                'B' => 'Bagian ini tidak membahas batu yang kebal garam; justru menambah bukti bagaimana kerusakan bisa terjadi.',
                'C' => 'Tujuannya bukan menyederhanakan, tetapi menambah kanal penyebab stres selain crystal growth.',
            ],
            46 => [
                'A' => 'Large terkait ukuran, sedangkan durable pada konteks ini menekankan ketahanan/kekuatan batu terhadap cuaca.',
                'C' => 'Flexible tidak tepat karena pembahasan menyasar batuan yang tahan lama, bukan sifat lentur.',
                'D' => 'Pressured adalah kondisi, bukan makna inti durable yang berarti kuat/awet.',
            ],
            47 => [
                'A' => 'Arranged berlawanan arah makna karena shattered berarti hancur, bukan tertata.',
                'B' => 'Dissolved berarti larut, padahal konteksnya pemecahan mekanis batu menjadi potongan kecil.',
                'D' => 'Gathered together berkebalikan dengan shattered yang justru memisahkan menjadi pecahan.',
            ],
            48 => [
                'A' => 'Most recent terkait waktu, sementara dominant pada kalimat ini menunjuk jenis garam yang paling utama/umum.',
                'C' => 'Least available berlawanan dengan dominant yang menandakan prevalensi tinggi.',
                'D' => 'Least damaging tidak disebut; dominant tidak merujuk tingkat bahaya paling rendah.',
            ],
            49 => [
                'A' => 'Passage menyebut lebih dari dua jenis garam (halite, karbonat, sulfat) dapat menyebabkan prying dan wedging.',
                'B' => 'Garam tidak harus bersama es untuk merusak batu; es disebut sebagai agen tambahan, bukan syarat.',
                'D' => 'Tidak ada perbandingan eksplisit yang menyatakan kerusakan di seashore lebih parah daripada Death Valley.',
            ],
            50 => [
                'A' => 'Kehadiran es tidak melindungi batu dari weathering; justru es dapat turut menyebabkan wedging.',
                'B' => 'Passage tidak menyimpulkan batu di daerah ber-es menolak capillary action secara umum.',
                'D' => 'Komposisi karbonat vs sulfat pada batu di daerah ber-es tidak disimpulkan dari passage.',
            ],
            ],
            2 => [
                1 => [
                    'A' => 'Passage memang menyebut meningkatnya permintaan Eropa, tetapi itu hanya latar yang mendukung gagasan lebih besar tentang dominasi ekspor kapas Amerika.',
                    'B' => 'Mekanisasi tekstil disebut sebagai faktor penyebab meningkatnya permintaan, bukan fokus utama keseluruhan passage.',
                    'C' => 'Pilihan ini terlalu sempit karena hanya menyorot profitabilitas dan proses kapas, bukan posisi kapas sebagai ekspor utama Amerika.',
                ],
                2 => [
                    'B' => 'Recommended berarti disarankan, sedangkan konteks kalimat menunjukkan kapas lebih dipilih dibanding flax atau wool.',
                    'C' => 'Imported tidak sesuai karena kalimat membahas preferensi industri tekstil Eropa, bukan kegiatan impor secara khusus.',
                    'D' => 'Included terlalu umum dan tidak menangkap nuansa pilihan aktif yang terkandung dalam favored.',
                ],
                3 => [
                    'A' => 'Softness justru disebut eksplisit sebagai alasan kapas digemari industri tekstil Eropa.',
                    'B' => 'Ease of processing juga disebut langsung dalam kalimat awal passage sebagai alasan permintaan meningkat.',
                    'D' => 'Ekspansi industri tekstil akibat mekanisasi disebut sebagai faktor yang menaikkan permintaan kapas.',
                ],
                4 => [
                    'A' => 'Unfamiliar berarti asing, bukan makna yang tepat untuk proses pemisahan kapas yang membutuhkan banyak usaha.',
                    'B' => 'Primitive menekankan kesederhanaan teknologi, sementara konteks kalimat menyorot beratnya pekerjaan manual.',
                    'C' => 'Skilled berarti membutuhkan keahlian, sedangkan laborious di sini terutama berarti sulit dan melelahkan.',
                ],
                5 => [
                    'A' => 'Passage tidak menyatakan keunggulannya berupa banyak biji; justru posisi biji yang terkonsentrasi memudahkan pemrosesan.',
                    'C' => 'Long growing season adalah syarat tumbuh sea island cotton, bukan keunggulan yang ditonjolkan dibanding short-staple cotton.',
                    'D' => 'Sea island cotton justru terbatas pada daerah pesisir timur, jadi bukan lebih adaptif terhadap banyak iklim.',
                ],
                6 => [
                    'A' => 'Sea island cotton mudah diproses bahkan sebelum gin, sehingga bukan sumber utama peningkatan produksi setelah gin diperkenalkan.',
                    'C' => 'Passage tidak menyatakan sebagian besar kapas dijual domestik; yang ditekankan justru perannya dalam ekspor.',
                    'D' => 'Passage membahas ekspor ke Eropa secara umum, bukan menyimpulkan mayoritasnya khusus ke England.',
                ],
                7 => [
                    'B' => 'Surge pada konteks produksi berarti lonjakan, bukan berhentinya produksi secara mendadak.',
                    'C' => 'Important change terlalu umum; kata surge menekankan kenaikan tajam.',
                    'D' => 'Excess amount tidak tepat karena penulis menyorot pertumbuhan cepat, bukan sekadar kelebihan stok.',
                ],
                8 => [
                    'A' => 'Contoh wheat tidak dipakai untuk membandingkan ekspor dan impor Amerika.',
                    'B' => 'Penulis tidak sedang membahas pertumbuhan ekspor gandum; gandum dipakai sebagai pembanding agar dominasi kapas terlihat.',
                    'D' => 'Tidak ada argumen bahwa gandum makin menguntungkan; justru nilainya jauh di bawah kapas.',
                ],
                9 => [
                    'A' => 'Slow berlawanan makna dengan unprecedented, yang menandakan sesuatu belum pernah terjadi sebelumnya.',
                    'B' => 'Profitable tidak terkait dengan makna unprecedented pada ekspansi settlement.',
                    'D' => 'Never explained tidak sesuai; unprecedented berbicara tentang kebaruan, bukan penjelasan.',
                ],
                10 => [
                    'B' => 'Passage tidak menjelaskan Mississippi sebagai sumber air utama pertanian pada bagian ini.',
                    'C' => 'Rute transportasi tidak menjadi poin pembahasan ketika sungai Mississippi disebut.',
                    'D' => 'Tidak ada keterangan bahwa sungai itu sumber tenaga utama mesin pertanian.',
                ],
                11 => [
                    'A' => 'Interesting tidak berkaitan dengan makna asal-usul yang belum jelas.',
                    'C' => 'Imperfect berarti tidak sempurna, sedangkan obscure dalam konteks ini berarti tidak terang atau tidak jelas.',
                    'D' => 'Complex berarti rumit, tetapi kalimat lebih menekankan bahwa asal-usulnya belum dipahami dengan jelas.',
                ],
                12 => [
                    'A' => 'Selecting a mate tidak disebut sebagai ciri utama fase awal; yang ditekankan adalah bermain dengan bahan sarang.',
                    'B' => 'Mengumpulkan bahan bisa terjadi, tetapi passage menekankan sifatnya lebih seperti bermain daripada konstruksi nyata.',
                    'D' => 'Pembangunan sarang efektif baru terjadi setelah mating, bukan pada awal siklus reproduksi.',
                ],
                13 => [
                    'A' => 'Communicate tidak cocok karena display di sini berarti memperlihatkan perilaku tertentu.',
                    'B' => 'Imitate berarti meniru, bukan menunjukkan perilaku secara langsung.',
                    'C' => 'Initiate berarti memulai; terlalu sempit dibanding makna display pada kalimat tersebut.',
                ],
                14 => [
                    'A' => 'Steinbeck disebut sebagai pengamat yang mencatat isi sarang, bukan peneliti ilmiah formal.',
                    'B' => 'Passage tidak menyatakan ia orang pertama yang menjelaskan lokasi sarang osprey.',
                    'D' => 'Ia tidak dipakai untuk membandingkan ukuran sarang, melainkan contoh bahan tak biasa yang dipakai.',
                ],
                15 => [
                    'A' => 'Ravens disebut memilih sticks berukuran tak sesuai, tetapi contoh benda aneh seperti baju dan handuk diberikan untuk osprey.',
                    'C' => 'Crows dibahas dalam konteks cara mengambil twigs, bukan penggunaan benda tidak biasa dalam sarang.',
                    'D' => 'Sparrowhawks dibahas karena cara mematahkan cabang, bukan isi sarang yang aneh.',
                ],
                16 => [
                    'B' => 'Green twigs disebut pada crows, bukan sparrowhawks.',
                    'C' => 'Passage tidak menyebut sparrowhawks menggunakan benda yang tertiup angin.',
                    'D' => 'Tidak ada informasi bahwa sparrowhawks mengumpulkan cabang berlebih.',
                ],
                17 => [
                    'A' => 'These muncul setelah pembahasan nest yang dibuat golden eagles; referen terdekatnya adalah nests, bukan burungnya.',
                    'B' => 'Generations adalah keterangan waktu/usaha, bukan benda yang kemudian diperiksa setelah terkena angin.',
                    'C' => 'Winds adalah penyebab sarang terlepas, bukan referen kata ganti these.',
                ],
                18 => [
                    'B' => 'Number tidak sesuai karena load pada konteks ini adalah beban yang dibawa burung.',
                    'C' => 'Section tidak relevan dengan kapasitas angkut.',
                    'D' => 'Level terlalu abstrak dan tidak sesuai konteks fisik membawa beban.',
                ],
                19 => [
                    'A' => 'Angka dua puluh persen tidak membandingkan ukuran elang dengan burung lain.',
                    'B' => 'Persentase itu tidak merujuk pada proporsi sarang dengan foundation branches.',
                    'C' => 'Tidak ada pernyataan bahwa sarang elang dua puluh persen lebih besar daripada sarang burung lain.',
                ],
                20 => [
                    'A' => 'Passage bukan sejarah survei, melainkan prinsip dasar agar survei dilakukan dengan tepat.',
                    'C' => 'Masalah interpretasi dibahas sebagai bagian dari desain pertanyaan, bukan fokus utama seluruh passage.',
                    'D' => 'Pentingnya poll politik hanya disebut di awal sebagai contoh, bukan inti pembahasan.',
                ],
                21 => [
                    'A' => 'They tidak merujuk pada North Americans, melainkan pada interviews yang disebut pada kalimat sebelumnya.',
                    'B' => 'News shows adalah tempat wawancara muncul, bukan referen kata ganti tersebut.',
                    'D' => 'Opinions adalah isi yang direfleksikan wawancara, bukan subjek they.',
                ],
                22 => [
                    'B' => 'Kenyataan bahwa wawancara itu di televisi bukan kelemahan utama yang ditekankan penulis.',
                    'C' => 'Masalah wording pertanyaan dibahas untuk survei formal, bukan person-on-the-street interviews.',
                    'D' => 'Wawancara itu tidak terbatas pada opini politik; masalah utamanya adalah sampel yang bias.',
                ],
                23 => [
                    'A' => 'Planned berarti direncanakan, bukan makna precise dalam konteks sampling yang akurat.',
                    'B' => 'Rational terlalu umum dan tidak menekankan ketepatan representasi sampel.',
                    'C' => 'Required adalah keharusan, bukan makna kata precise.',
                ],
                24 => [
                    'A' => 'Jumlah responden penting, tetapi passage menekankan bahwa wording yang hati-hati menentukan kualitas survei.',
                    'C' => 'Kemampuan interviewer menggali perasaan dibahas sebagai keunggulan interview, bukan syarat utama semua survei efektif.',
                    'D' => 'Interpretasi hasil penting, tetapi paragraf 3 khusus membahas perumusan pertanyaan.',
                ],
                25 => [
                    'B' => 'Consider berarti mempertimbangkan, sedangkan exercise great care berarti menggunakan atau menerapkan kehati-hatian besar.',
                    'C' => 'Design tidak sama dengan exercise pada frasa idiomatik exercise great care.',
                    'D' => 'Defend sama sekali tidak sesuai konteks.',
                ],
                26 => [
                    'A' => 'Compose berarti menyusun, sedangkan elicit berarti memunculkan atau memperoleh respons tertentu.',
                    'B' => 'Rule out berarti menyingkirkan kemungkinan, bukan menarik keluar informasi.',
                    'C' => 'Predict berarti meramalkan, tidak sesuai dengan tujuan pertanyaan survei.',
                ],
                27 => [
                    'B' => 'Passage tidak menyebut questionnaires sulit dibaca sebagai sumber frustrasi utama.',
                    'C' => 'Justru questionnaires disebut lebih murah, bukan lebih mahal atau sulit didistribusikan.',
                    'D' => 'Masalahnya bukan responden terlalu antusias menambah opini, tetapi kemungkinan mereka tidak merespons sama sekali.',
                ],
                28 => [
                    'A' => 'Questionnaires disebut lebih murah; ini bukan keunggulan interview langsung.',
                    'C' => 'Passage tidak menyatakan live interviews lebih mudah diinterpretasi.',
                    'D' => 'Tidak ada klaim bahwa live interviews meminimalkan pengaruh peneliti.',
                ],
                29 => [
                    'B' => 'Influence berarti memengaruhi, sedangkan probe di sini berarti menggali lebih dalam alasan dan perasaan.',
                    'C' => 'Analyze adalah menganalisis, bukan tindakan aktif menelusuri jawaban subjek saat wawancara.',
                    'D' => 'Apply tidak sesuai konteks.',
                ],
                30 => [
                    'B' => 'Public opinion tidak didefinisikan secara formal di passage.',
                    'C' => 'Representative sampling dibahas, tetapi tidak didefinisikan eksplisit seperti survey di kalimat pembuka.',
                    'D' => 'Response rate disebut sebagai konsep keunggulan interview, bukan istilah yang diberi definisi langsung.',
                ],
                31 => [
                    'A' => 'Sediment buildup dibahas, tetapi sebagai akibat dari perubahan besar dalam kehidupan plankton laut.',
                    'B' => 'Pembentukan petroleum hanya salah satu konsekuensi yang dibahas pada bagian akhir passage.',
                    'D' => 'Passage tidak terutama membandingkan plankton modern dan plankton Cretaceous.',
                ],
                32 => [
                    'A' => 'Passage menyebut perubahan ini terjadi late in the Mesozoic era, bukan awal era.',
                    'B' => 'Tidak ada indikasi bahwa Cretaceous berada di bagian tengah era itu.',
                    'D' => 'Cretaceous adalah bagian dari Mesozoic, bukan sesudahnya.',
                ],
                33 => [
                    'B' => 'Passage menyebut plankton hidup di uppermost, sunlit portion of the oceans.',
                    'C' => 'Pergerakan plankton disebut: float about or weakly propel themselves.',
                    'D' => 'Ukuran plankton juga disebut sebagai small plants and animals.',
                ],
                34 => [
                    'A' => 'Depended tidak sesuai karena accumulated menggambarkan penumpukan material.',
                    'B' => 'Matured berarti menjadi matang, bukan berkumpul atau menumpuk.',
                    'C' => 'Dissolved justru kebalikan dari penumpukan sedimen.',
                ],
                35 => [
                    'A' => 'Passage tidak menyebut perubahan besar pada kedalaman air.',
                    'C' => 'Justru kondisi ideal untuk oil accumulation meningkat, bukan penurunan sediment penghasil petroleum.',
                    'D' => 'Calcareous ooze dijelaskan meningkat sangat besar, bukan menurun.',
                ],
                36 => [
                    'A' => 'Cliffs of Dover tidak disebut sebagai lokasi pertama terbentuknya sedimen itu.',
                    'B' => 'Contoh ini bukan misteri ilmiah, melainkan ilustrasi konkret hasil akumulasi besar.',
                    'D' => 'Passage tidak menyatakan Dover sebagai single largest buildup di Bumi.',
                ],
                37 => [
                    'B' => 'Distinct berarti berbeda, tetapi prolific pada konteks ini menekankan banyaknya produksi atau kelimpahan.',
                    'C' => 'Determined berkaitan dengan tekad, bukan produktivitas tinggi.',
                    'D' => 'Energetic tidak sama dengan prolific.',
                ],
                38 => [
                    'A' => 'Common tidak tepat; ideal conditions berarti kondisi yang sangat sesuai.',
                    'B' => 'Clear tidak menangkap makna kesempurnaan/kemampuan optimal yang dimaksud.',
                    'D' => 'Immediate terkait waktu, bukan kualitas kondisi.',
                ],
                39 => [
                    'A' => 'Biological productivity adalah penyebab umum, tetapi it dalam kalimat berikut merujuk pada organic material yang berubah menjadi petroleum.',
                    'B' => 'Oil adalah hasil akhirnya, bukan sesuatu yang kemudian diubah menjadi petroleum.',
                    'D' => 'Petroleum adalah hasil transformasi, bukan referen awal kata ganti it.',
                ],
                40 => [
                    'A' => 'Practical tidak tepat; standard di sini berarti biasa atau lazim digunakan dalam opera orchestra.',
                    'C' => 'Possible terlalu lemah dan tidak menunjukkan status umum instrumen itu.',
                    'D' => 'Unusual justru berlawanan dengan standard.',
                ],
                41 => [
                    'B' => 'Passage tidak membahas kompetisi antara orkestra Prancis dan Italia.',
                    'C' => 'Tidak ada klaim tentang superioritas violin Prancis.',
                    'D' => 'Contoh ini tidak dipakai untuk menunjukkan bahwa violin hanya cocok bagi bangsawan.',
                ],
                42 => [
                    'B' => 'Passage tidak membuat klaim umum bahwa violin paling terkenal di dunia; paragraf 3 khusus membahas perubahan teknis alat ini.',
                    'C' => 'Tidak disebut bahwa popularitas violin mencapai puncak pada pertengahan abad kedelapan belas.',
                    'D' => 'Sebaliknya, passage menegaskan teknik dan struktur violin berkembang cukup besar.',
                ],
                43 => [
                    'A' => 'Penulis tidak menyorot jumlah pemain violin yang bertambah karena karya mereka.',
                    'B' => 'Bukan musik yang disesuaikan ke violin, melainkan violin yang dikembangkan untuk memenuhi tuntutan musik.',
                    'D' => 'Tidak ada informasi bahwa karya mereka hanya bisa dimainkan murid mereka.',
                ],
                44 => [
                    'A' => 'They tidak merujuk pada Vivaldi and Tartini; para komposer itu adalah penyebab perubahan, bukan benda yang harus menahan strain.',
                    'B' => 'Thinner strings and higher tension menyebabkan strain, tetapi yang harus withstand strain adalah struktur violin.',
                    'C' => 'Small changes adalah penyesuaian yang dibuat, bukan subjek yang harus withstand strain.',
                ],
                45 => [
                    'A' => 'Struggle berarti perjuangan, bukan tekanan fisik pada struktur instrumen.',
                    'B' => 'Strength adalah kekuatan, bukan beban atau tekanan yang harus ditahan.',
                    'C' => 'Strategy tidak relevan dalam konteks teknis instrumen.',
                ],
                46 => [
                    'A' => 'Accordingly di sini menyatakan akibat atau hasil dari perubahan teknis sebelumnya, bukan pertentangan.',
                    'C' => 'Nevertheless menyatakan kontras, padahal hubungan kalimatnya sebab-akibat.',
                    'D' => 'Ultimately terlalu longgar dibanding makna langsung consequently.',
                ],
                47 => [
                    'A' => 'Passage tidak membandingkan berat violin lama dan modern.',
                    'B' => 'Tidak dinyatakan bahwa violin awal lebih mudah rusak; yang dijelaskan adalah kualitas nada yang lebih redup.',
                    'D' => 'Tidak ada keterangan bahwa violin awal lebih mudah dimainkan.',
                ],
                48 => [
                    'A' => 'Long fingerboard tidak disebut sebagai penyebab dull tone.',
                    'B' => 'Small body tidak dibahas sebagai faktor nada redup pada violin awal.',
                    'C' => 'High string tension justru dikaitkan dengan nada yang lebih penuh dan cemerlang.',
                ],
                49 => [
                    'B' => 'Solo tidak didefinisikan secara langsung dalam passage.',
                    'C' => 'Left-hand technique disebut tetapi tidak diberi definisi.',
                    'D' => 'Fingering patterns juga tidak didefinisikan eksplisit.',
                ],
                50 => [
                    'A' => 'Passage memang menyebut left-hand technique became elaborated.',
                    'B' => 'New fingering patterns for very high notes disebut langsung sebagai salah satu perkembangan.',
                    'D' => 'Minor structural changes to internal structure and fingerboard juga disebut eksplisit.',
                ],
            ],
        ];

        return $banks[$packageNumber] ?? [];
    }

    private static function detectQuestionType(string $questionText): string
    {
        $text = strtolower($questionText);

        if (str_contains($text, 'closest in meaning')) {
            return 'vocabulary';
        }

        if (str_contains($text, 'refers to')) {
            return 'reference';
        }

        if (str_contains($text, 'inferred') || str_contains($text, 'infer')) {
            return 'inference';
        }

        if (str_contains($text, 'mainly discuss') || str_contains($text, 'main topic') || str_contains($text, 'main idea') || str_contains($text, 'mainly about')) {
            return 'main_idea';
        }

        if (str_contains($text, 'author') && (str_contains($text, 'purpose') || str_contains($text, 'mention'))) {
            return 'author_purpose';
        }

        if (str_contains($text, 'according to the passage') || str_contains($text, 'according to the author')) {
            return 'detail';
        }

        return 'general';
    }

    private static function distractorReasonByType(string $type, string $optionText, string $correctOptionText): string
    {
        return match ($type) {
            'vocabulary' => 'Pilihan ini tidak paling dekat maknanya dalam konteks kalimat passage; konteks kalimat lebih mengarah ke makna pada jawaban benar.',
            'reference' => 'Pilihan ini bukan rujukan kata ganti pada kalimat tersebut; rujukan yang tepat adalah unsur yang secara gramatikal dan makna paling dekat dengan kata ganti.',
            'inference' => 'Pilihan ini tidak merupakan simpulan yang paling didukung bukti implisit passage; dukungan teks lebih kuat ke arah jawaban benar.',
            'main_idea' => 'Pilihan ini terlalu sempit, terlalu spesifik, atau bukan fokus utama seluruh passage. Ide pokok keseluruhan lebih tepat pada jawaban benar.',
            'author_purpose' => 'Pilihan ini tidak menggambarkan tujuan utama penulis pada bagian yang ditanyakan; fungsi kalimat/paragraf lebih sesuai dengan jawaban benar.',
            'detail' => 'Pilihan ini tidak sesuai dengan informasi detail yang dinyatakan langsung di passage pada bagian terkait.',
            default => 'Pilihan ini masih terkait topik, tetapi bukan jawaban paling tepat karena dukungan informasi passage lebih kuat pada jawaban benar' . ($correctOptionText !== '' ? ' (' . $correctOptionText . ')' : '') . '.',
        };
    }

    private static function explanationBank(int $packageNumber): array
    {
        $banks = [
            1 => [
            1 => 'Fokus passage membahas pola pengasuhan anak pada berbagai hewan, terutama perbandingan antara mamalia dan non-mamalia. Jadi opsi A paling mewakili gagasan utama.',
            2 => 'Daftar hewan pada bagian awal dipakai untuk menekankan bahwa semua jenis mamalia tetap memberi makan anaknya. Ini mendukung pernyataan umum penulis tentang ciri khas mamalia.',
            3 => 'Dalam konteks kalimatnya, tend berarti merawat keturunan sampai menetas atau lahir. Karena itu padanan makna paling dekat adalah care for.',
            4 => 'Passage menyatakan memberi makan anak bukan hal universal pada semua hewan, tetapi menjadi ciri wajib mamalia. Maka inferensi yang tepat: praktik ini paling umum pada mamalia.',
            5 => 'Kata provisioning dijelaskan lewat contoh menyimpan ulat/laba-laba untuk larva. Artinya adalah supplying, yaitu menyediakan pasokan makanan.',
            6 => 'Penulis menjelaskan beberapa serangga menyiapkan sel/sarang berisi mangsa yang dilumpuhkan agar larva punya makanan saat menetas. Ini sesuai dengan opsi A.',
            7 => 'Frasa give them an edge berarti memberi keunggulan dalam bertahan hidup dan menghasilkan keturunan. Jadi edge paling dekat dengan advantage.',
            8 => 'Kata it merujuk pada young animal dalam kalimat tentang menunda momen saat anak hewan harus mencari makan sendiri. Referennya bukan feeding atau size.',
            9 => 'Passage menekankan saat paling rentan adalah ketika anak hewan pertama kali benar-benar mandiri. Karena itu jawaban yang tepat adalah they first become independent.',
            10 => 'Shielded muncul pada konteks perlindungan terhadap pasokan makanan yang tidak stabil. Makna terdekatnya adalah protected.',
            11 => 'Seluruh passage membandingkan dua teknik printmaking utama: woodcut dan engraving, termasuk proses dan karakteristiknya. Jadi topik utamanya adalah two types of printmaking.',
            12 => 'Prime pada frasa two prime examples berarti utama atau paling penting dalam kategori itu. Padanan paling dekat adalah principal.',
            13 => 'Paragraf kedua menjelaskan langkah-langkah teknis pembuatan woodcut dari blok kayu sampai cetak. Jadi tujuan paragraf adalah mendeskripsikan proses membuat woodcut.',
            14 => 'Incised dipakai saat gambar dibuat masuk ke permukaan pelat logam. Kata tersebut bermakna cut.',
            15 => 'Passage secara eksplisit menyebut burin sebagai cutting instrument dalam engraving. Jadi istilah yang benar-benar didefinisikan adalah burin.',
            16 => 'Distinctive characteristics berarti ciri yang khas atau unik dari masing-masing teknik. Karena itu jawaban paling tepat adalah unique.',
            17 => 'Engraving tidak memotong kertas dengan burin; yang diukir adalah pelat logam. Jadi pernyataan yang tidak benar (EXCEPT) adalah opsi B.',
            18 => 'Pada kalimat tentang kedua metode yang dapat yield beberapa ratus cetakan, yield berarti menghasilkan. Maka padanan tepat adalah produce.',
            19 => 'Kesamaan yang ditekankan adalah keduanya memungkinkan produksi banyak salinan dari satu blok/pelat asli. Ini cocok dengan opsi D.',
            20 => 'Penulis menyatakan produksi massal membuat gambar tersedia dengan biaya lebih rendah untuk publik luas. Jadi faktor utamanya adalah low cost.',
            21 => 'Passage menyebut transfer bisa dengan tangan atau printing press, jadi press tidak selalu wajib. Karena pertanyaan EXCEPT, jawaban benar adalah require a printing press.',
            22 => 'Passage merangkum perkembangan budaya awal di wilayah tenggara AS, dari Adena-Hopewell ke Mississippian. Jadi topik utama paling tepat adalah early people and cultures.',
            23 => 'Setelah mulai bercocok tanam, masyarakat beralih ke desa permanen dan budaya menetap berkembang. Itu akibat langsung yang dijelaskan passage.',
            24 => 'Adena-Hopewell adalah nama budaya yang diambil dari lokasi situs penting di Ohio. Jadi istilah ini menunjuk lokasi awal budaya tersebut.',
            25 => 'Bartering dalam konteks jaringan dagang berarti bertukar barang (exchange), bukan memproduksi atau mengangkut.',
            26 => 'Supplanted dijelaskan saat budaya Hopewell digantikan oleh budaya Mississippian. Jadi makna terdekatnya adalah replaced.',
            27 => 'Passage menyebut puncak kejayaan Mississippian terjadi sekitar tahun 1200, saat dianggap paling maju di Amerika Utara. Maka jawaban C.',
            28 => 'Perbedaan utama: Mississippian mengembangkan varietas jagung yang lebih tahan dan bercocok tanam dalam skala lebih besar. Ini menunjukkan hasil pangan lebih kuat/besar.',
            29 => 'Sebutan children of the Sun dipakai untuk menunjukkan betapa eratnya pertanian dengan kepercayaan mereka. Penulis memakainya untuk mengilustrasikan pentingnya agriculture.',
            30 => 'Frasa charged with guarding the flame berarti diberi tugas menjaga api suci. Jadi charged with paling dekat dengan assigned to.',
            31 => 'Mound digunakan untuk upacara, perdagangan, dan kadang pemakaman, tetapi tidak disebut sebagai tempat berkumpul seluruh komunitas. Karena EXCEPT, jawaban B.',
            32 => 'Paragraf pertama menyoroti bagaimana pembangunan jalan didanai saat negara belum mampu membiayai sendiri. Jadi fokus utamanya adalah financing of new roads.',
            33 => 'Primitive pada konteks transportasi 1790 berarti belum berkembang secara infrastruktur dan teknologi. Padanan paling tepat adalah undeveloped.',
            34 => 'Teks menyebut jalan umumnya menghubungkan komunitas pedalaman ke kota sungai atau pelabuhan terdekat. Jadi jawaban C.',
            35 => 'On the threshold of berarti berada di awal suatu periode baru, yaitu awal era pembangunan jalan. Jadi makna terdekat at the start of.',
            36 => 'Negara bagian meminta bantuan swasta karena tidak mampu membiayai konstruksi jalan sendiri. Alasan finansial disebut jelas di passage.',
            37 => 'Pada kalimat the legislature gave the company ... though it carefully regulated the rates, kata it kembali ke legislature. Jadi referennya opsi A.',
            38 => 'Imitation setelah keberhasilan Lancaster Pike berarti wilayah lain meniru model itu. Maka maknanya adalah copying.',
            39 => 'Virginia disebut kontras dengan negara bagian utara karena membangun jaringan jalan dengan dana publik. Jadi jawaban B.',
            40 => 'Roda Conestoga yang besar dan lebar efektif melewati jalan rusak, berlubang, dan beralur. Jadi fitur itu berguna untuk permukaan tidak rata.',
            41 => 'Passage membahas mekanisme bagaimana garam merusak batuan melalui crystal prying and wedging. Jadi topik utamanya adalah efek destruktif garam pada batu.',
            42 => 'Pada kalimat until it reaches the surface, it merujuk pada salty water yang naik lewat kapilaritas. Bukan groundwater table atau sediment.',
            43 => 'Exert pressure berarti memberikan atau menerapkan tekanan pada batu. Jadi padanan paling dekat adalah put.',
            44 => 'Perbandingan akar pohon dan kristal garam menekankan keduanya dapat memecah permukaan keras dengan tekanan bertahap. Jadi keduanya force hard surfaces to crack.',
            45 => 'Contoh ekspansi halite/sulfate ditambahkan untuk menunjukkan mekanisme tambahan selain pertumbuhan kristal yang juga merusak batu. Karena itu jawabannya D.',
            46 => 'Durable pada konteks batu berarti kuat/awet menahan kondisi alam lama. Makna terdekatnya adalah strong.',
            47 => 'Shattered into small pieces berarti pecah berkeping-keping. Jadi padanan yang tepat broken apart.',
            48 => 'Dominant salt berarti jenis garam yang paling banyak/utama di Death Valley, yaitu halite. Jadi most common.',
            49 => 'Paragraf akhir menyebut berbagai jenis garam dan berbagai lingkungan (bukan hanya gurun) bisa menyebabkan weathering. Jadi pernyataan benar adalah opsi C.',
            50 => 'Karena es juga dapat menyebabkan wedging, batu di daerah ber-ice cenderung mengalami pola kerusakan serupa dengan di Death Valley. Maka inferensi paling tepat opsi C.',
            ],
            2 => [
                1 => 'Passage menekankan bahwa kapas menjadi produk ekspor Amerika Serikat yang paling penting pada abad ke-18 dan ke-19. Faktor seperti permintaan Eropa dan cotton gin dibahas untuk mendukung ide utama ini, jadi jawaban terbaik adalah D.',
                2 => 'Dalam kalimat awal, favored menunjukkan bahwa industri tekstil Eropa lebih memilih kapas dibanding flax atau wool. Karena itu padanan makna terdekat adalah preferred.',
                3 => 'Passage menyebut tiga alasan kenaikan permintaan kapas: teksturnya lembut, mudah diproses, dan industri tekstil berkembang akibat mekanisasi. Tidak ada pembahasan tentang shortage of flax and wool, sehingga jawaban benar adalah C.',
                4 => 'Kata laborious muncul saat menjelaskan betapa berat dan lambatnya memisahkan serat kapas dari biji secara manual. Maka makna yang paling dekat adalah difficult.',
                5 => 'Sea island cotton lebih mudah diproses dengan tangan karena memiliki serat panjang dan biji terkonsentrasi di dasar bunga. Dari pilihan yang ada, keunggulan yang paling tepat adalah long fibers.',
                6 => 'Whitney\'s cotton gin terutama membuat short-staple cotton jauh lebih mudah diproses daripada sebelumnya. Karena short-staple cotton dapat tumbuh di lebih banyak wilayah Selatan, dapat disimpulkan bahwa lebih banyak kapas kemudian berasal dari tanaman short-staple, sehingga jawabannya B.',
                7 => 'Pada kalimat tentang cultivation of cotton dan surge in production, surge jelas menunjukkan kenaikan yang cepat dan besar. Maka arti terdekatnya adalah sharp increase.',
                8 => 'Penulis menyebut wheat and wheat flour hanya untuk menunjukkan betapa dominannya kapas di antara ekspor Amerika. Jadi fungsi contoh itu adalah menegaskan pentingnya cotton, yaitu opsi C.',
                9 => 'Unprecedented expansion berarti perluasan settlement pertanian yang belum pernah terjadi sebelumnya. Karena itu padanan makna paling dekat adalah not seen before.',
                10 => 'Pada akhir passage, wilayah ekspansi pertanian dijelaskan berada di timur Amerika Serikat, west of the Appalachian Mountains and east of the Mississippi River. Jadi Mississippi disebut sebagai salah satu batas wilayah settlement baru.',
                11 => 'Kalimat pembuka menyatakan origins of nest-building remain obscure, yang berarti asal-usul perilaku itu belum jelas dipahami. Jadi jawaban yang tepat adalah unclear.',
                12 => 'Passage secara eksplisit menyebut bahwa pada awal siklus reproduksi burung tampak only to play with the building materials. Maka aktivitas yang khas pada fase awal adalah playing with nest-building materials.',
                13 => 'Dalam konteks birds also display remarkable behavior, kata display berarti menunjukkan atau memperlihatkan perilaku tertentu. Karena itu padanan terbaik adalah exhibit.',
                14 => 'John Steinbeck disebut sebagai orang yang mencatat isi sarang osprey muda yang berisi benda-benda tidak biasa. Tujuan penyebutan ini adalah memberi contoh bahan sarang yang dapat dipakai osprey.',
                15 => 'Benda-benda aneh seperti shirts, bath towel, dan arrow disebut sebagai isi sarang young osprey. Jadi burung yang disebut membangun sarang dengan objek tidak biasa adalah ospreys.',
                16 => 'Passage menyatakan sparrowhawks will dive purposefully onto a branch until it snaps and then hang upside down to break it off. Jadi jawaban yang benar adalah hang upside down.',
                17 => 'Kata these dalam frasa One of these merujuk pada enormous nests yang baru saja disebut pada kalimat sebelumnya. Karena itu referennya adalah nests.',
                18 => 'Carrying an extra load of just over twenty percent of their body weight menunjukkan bahwa load berarti beban yang dibawa. Jadi padanan maknanya adalah weight.',
                19 => 'Angka twenty percent dipakai untuk menunjukkan kapasitas burung membawa beban tambahan relatif terhadap berat tubuhnya. Jadi maksud penulis adalah birds can carry twenty percent of their own weight.',
                20 => 'Seluruh passage membahas cara melakukan survei yang baik, mulai dari sampling, wording pertanyaan, sampai perbedaan interview dan questionnaire. Jadi topik utamanya adalah principles of conducting surveys.',
                21 => 'Pada kalimat While such interviews can be highly entertaining, they are not necessarily an accurate indication..., kata they jelas merujuk pada interviews. Jadi jawaban benar adalah C.',
                22 => 'Penulis menegaskan bahwa person-on-the-street interviews hanya mencerminkan orang-orang di lokasi tertentu dan cenderung menarik tipe orang tertentu. Karena itu kelemahan utamanya adalah tidak menggunakan representative sampling.',
                23 => 'Dalam frasa precise, representative sampling, kata precise berarti tepat atau akurat. Maka padanan yang paling dekat adalah accurate.',
                24 => 'Paragraf ketiga berfokus pada pentingnya penyusunan pertanyaan yang simple, clear, dan specific. Karena itu unsur paling penting yang ditekankan untuk survei efektif adalah carefully worded questions.',
                25 => 'Exercise great care adalah ungkapan yang berarti menggunakan atau menerapkan kehati-hatian besar. Maka padanan terdekat dari exercise adalah utilize.',
                26 => 'Questions must be carefully phrased in order to elicit the type of information desired berarti pertanyaan harus dirancang untuk memunculkan informasi yang diinginkan. Jadi elicit paling dekat dengan bring out.',
                27 => 'Karena questionnaire dapat dibuang atau diabaikan lebih mudah daripada permintaan interview personal, dapat diinferensikan bahwa frustration muncul saat respondents often do not complete and return questionnaires.',
                28 => 'Penulis menyebut interviewer can go beyond written questions and probe for underlying feelings and reasons. Artinya live interviews dapat menghasilkan informasi yang lebih banyak dan lebih dalam.',
                29 => 'Probe for a subject\'s underlying feelings and reasons berarti menggali lebih jauh alasan dan perasaan subjek. Jadi padanan makna terdekat adalah explore.',
                30 => 'Passage secara langsung mendefinisikan survey pada kalimat pembuka: A survey is a study.... Karena itu istilah yang didefinisikan adalah survey.',
                31 => 'Passage menjelaskan perubahan besar pada plankton di akhir Mesozoic dan dampaknya terhadap sedimen laut serta pembentukan minyak. Jadi ide utamanya adalah impact of changes in oceanic animal and plant life in the Mesozoic era.',
                32 => 'Kalimat opening menyebut perubahan ini occurred late in that era, dan kemudian mengidentifikasi Cretaceous period. Jadi Cretaceous terjadi pada bagian akhir Mesozoic era.',
                33 => 'Passage menyebut ukuran plankton, lokasi mereka di bagian atas laut, dan cara mereka bergerak lemah di air. Yang tidak disebut adalah panjang umur mereka.',
                34 => 'Accumulated dipakai untuk menjelaskan sedimen yang menumpuk di dasar laut. Karena itu makna terdekatnya adalah collected.',
                35 => 'Penulis secara eksplisit menyatakan perkembangan plankton radically changed the types of sediments that accumulated on the seafloor. Jadi perubahan paling dramatis menyangkut makeup of the sediment on the ocean floor.',
                36 => 'White chalk cliffs of Dover digunakan sebagai contoh nyata dari huge quantities of such material yang menumpuk pada Cretaceous period. Jadi tujuannya adalah memberi contoh buildup of plankton sediment.',
                37 => 'Calcareous plankton were so prolific berarti jumlah atau produksinya sangat besar/berlimpah. Maka padanan yang tepat adalah fruitful.',
                38 => 'Ideal conditions for oil accumulation berarti kondisi yang paling sesuai atau sempurna untuk terbentuknya akumulasi minyak. Jadi arti terdekat adalah perfect.',
                39 => 'Dalam kalimat Oil is formed when organic material trapped in sediments is slowly buried and subjected to increased temperatures and pressures, transforming it into petroleum, kata it merujuk pada organic material. Maka jawaban benar adalah C.',
                40 => 'When it first became standard in Italian opera orchestras, standard berarti menjadi hal yang lazim atau biasa digunakan. Jadi padanan terdekatnya adalah customary.',
                41 => 'Contoh The King\'s 24 Violins dipakai untuk menunjukkan bagaimana status violin naik dan menjadi terkenal sebagai instrumen orkestra penting. Karena itu jawabannya adalah A.',
                42 => 'Paragraf ketiga menjelaskan perubahan teknis pada violin, seperti thinner strings, higher tension, dan penyesuaian struktur, agar sesuai tuntutan musik yang berkembang. Jadi ide utamanya adalah violin has been modified to fit its evolving musical functions.',
                43 => 'Vivaldi dan Tartini disebut sebagai composer-violinists whose compositions demanded a fuller, clearer, and more brilliant tone. Artinya karya mereka menuntut violin yang lebih maju secara teknis.',
                44 => 'Pada kalimat so that they could withstand the extra strain, kata they merujuk pada violin\'s internal structure and the fingerboard. Kedua bagian inilah yang harus menahan ketegangan tambahan.',
                45 => 'Extra strain pada struktur violin berarti tekanan atau tegangan tambahan yang harus ditahan alat musik itu. Jadi makna terdekat strain adalah stress.',
                46 => 'Accordingly menghubungkan sebab dan akibat: setelah perubahan teknis dilakukan, hasilnya adalah higher standard of performance. Jadi makna terdekatnya adalah consequently.',
                47 => 'Passage menjelaskan violin awal memiliki dull and rather quiet tone karena strings yang tebal dan longgar. Jadi perbedaan utama yang disebut adalah early violins produced softer tones.',
                48 => 'Nada redup pada violin awal dikaitkan dengan strings were thick dan loosely attached. Dari pilihan yang ada, faktor yang disebut langsung adalah thick strings.',
                49 => 'Passage mendefinisikan resonator melalui aposisi: a hollow, varnished wooden sound box, or resonator. Jadi istilah yang didefinisikan adalah resonator.',
                50 => 'Passage menyebut kontribusi left-hand technique, new fingering patterns, dan small structural changes. Tidak ada pembahasan tentang penggunaan rare wood untuk fingerboard dan neck, jadi itulah jawaban EXCEPT.',
            ],
        ];

        return $banks[$packageNumber] ?? [];
    }

    private static function packageTwo(): array
    {
        return [
            'package_number' => 2,
            'title' => 'Practice Test 02',
            'subtitle' => 'TOEFL ITP Reading Practice',
            'description' => 'Read each passage and choose the best answer for every question.',
            'directions' => 'Read the passages. Then choose the correct answer for each question.',
            'questions_count' => 50,
            'passages' => self::attachExplanations([
                [
                    'section_title' => 'Questions 1-10',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">By far the most important United States export product in the eighteenth and nineteenth centuries was cotton, favored by the European textile industry over flax or wool because it was easy to process and soft to the touch. Mechanization of spinning and weaving allowed significant centralization and expansion in the textile industry during this period, and at the same time the demand for cotton increased dramatically. American producers were able to meet this demand largely because of the invention of the cotton gin by Eli Whitney in 1793. Cotton could be grown throughout the South, but separating the fiber -- or lint -- from the seed was a laborious process. Sea island cotton was relatively easy to process by hand, because its fibers were long and seeds were concentrated at the base of the flower, but it demanded a long growing season, available only along the nation's eastern seacoast. Short-staple cotton required a much shorter growing season, but the shortness of the fibers and their mixture with seeds meant that a worker could hand-process only about one pound per day. Whitney's gin was a hand-powered machine with revolving drums and metal teeth to pull cotton fibers away from seeds. Using the gin, a worker could produce up to 50 pounds of lint a day. The later development of larger gins, powered by horses, water, or steam, multiplied productivity further.</p>
    <p class="toefl-passage-paragraph">The interaction of improved processing and high demand led to the rapid spread of the cultivation of cotton and to a surge in production. It became the main American export, dwarfing all others. In 1802, cotton composed 14 percent of total American exports by value. Cotton had a 36 percent share by 1810 and over a 50 percent share in 1830. In 1860, 61 percent of the value of American exports was represented by cotton. In contrast, wheat and wheat flour composed only 6 percent of the value of American exports in that year. Clearly, cotton was king in the trade of the young republic. The growing market for cotton and other American agricultural products led to an unprecedented expansion of agricultural settlement, mostly in the eastern half of the United States -- west of the Appalachian Mountains and east of the Mississippi River.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 1, 'text' => 'The main point of the passage is that the eighteenth and nineteenth centuries were a time when', 'options' => ['A' => 'the European textile industry increased its demand for American export products', 'B' => 'mechanization of spinning and weaving dramatically changed the textile industry', 'C' => 'cotton became a profitable crop but was still time-consuming to process', 'D' => 'cotton became the most important American export product'], 'answer' => 'D'],
                        ['number' => 2, 'text' => 'The word "favored" in line 2 is closest in meaning to', 'options' => ['A' => 'preferred', 'B' => 'recommended', 'C' => 'imported', 'D' => 'included'], 'answer' => 'A'],
                        ['number' => 3, 'text' => 'All of the following are mentioned in the passage as reasons for the increased demand for cotton EXCEPT', 'options' => ['A' => 'cotton\'s softness', 'B' => 'cotton\'s ease of processing', 'C' => 'a shortage of flax and wool', 'D' => 'the growth that occurred in the textile industry'], 'answer' => 'C'],
                        ['number' => 4, 'text' => 'The word "laborious" in line 8 is closest in meaning to', 'options' => ['A' => 'unfamiliar', 'B' => 'primitive', 'C' => 'skilled', 'D' => 'difficult'], 'answer' => 'D'],
                        ['number' => 5, 'text' => 'According to the passage, one advantage of sea island cotton was its', 'options' => ['A' => 'abundance of seeds', 'B' => 'long fibers', 'C' => 'long growing season', 'D' => 'adaptability to different climates'], 'answer' => 'B'],
                        ['number' => 6, 'text' => 'Which of the following can be inferred from the passage about cotton production in the United States after the introduction of Whitney\'s cotton gin?', 'options' => ['A' => 'More cotton came from sea island cotton plants than before.', 'B' => 'More cotton came from short-staple cotton plants than before.', 'C' => 'Most cotton produced was sold domestically.', 'D' => 'Most cotton produced was exported to England.'], 'answer' => 'B'],
                        ['number' => 7, 'text' => 'The word "surge" in line 18 is closest in meaning to', 'options' => ['A' => 'sharp increase', 'B' => 'sudden stop', 'C' => 'important change', 'D' => 'excess amount'], 'answer' => 'A'],
                        ['number' => 8, 'text' => 'The author mentions "wheat and wheat flour" in line 22 in order to', 'options' => ['A' => 'show that Americans exported more agricultural products than they imported.', 'B' => 'show the increase in the amount of wheat products exported.', 'C' => 'demonstrate the importance of cotton among American export products.', 'D' => 'demonstrate that wheat farming was becoming more profitable.'], 'answer' => 'C'],
                        ['number' => 9, 'text' => 'The word "unprecedented" in line 25 is closest in meaning to', 'options' => ['A' => 'slow', 'B' => 'profitable', 'C' => 'not seen before', 'D' => 'never explained'], 'answer' => 'C'],
                        ['number' => 10, 'text' => 'According to the passage, the Mississippi River was', 'options' => ['A' => 'one of the boundaries of a region where new agricultural settlement took place', 'B' => 'a major source of water for agricultural crops', 'C' => 'the primary route by which agricultural crops were transported', 'D' => 'a main source of power for most agricultural machinery'], 'answer' => 'A'],
                    ],
                ],
                [
                    'section_title' => 'Questions 11-19',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">The origins of nest-building remain obscure, but current observation of nest-building activities provide evidence of their evolution. Clues to this evolutionary process can be found in the activities of play and in the behavior and movements of birds during mating, such as incessant pulling at strips of vegetation or scraping of the soil. During the early days of the reproductive cycle, the birds seem only to play with the building materials. In preparation for mating, they engage in activities that resemble nest-building, and continue these activities throughout and even after the mating cycle. Effective attempts at construction occur only after mating.</p>
    <p class="toefl-passage-paragraph">Although nest-building is an instinctive ability, there is considerable adaptability in both site selection and use of materials, especially with those species which build quite elaborate constructions. Furthermore, some element of learning is often evident since younger birds do not build as well as their practiced elders. Young ravens, for example, first attempt to build with sticks of quite unsuitable size, while a jackdaw's first nest includes virtually any movable object. The novelist John Steinbeck recorded the contents of a young osprey nest built in his garden, which included three shirts, a bath towel, and one arrow.</p>
    <p class="toefl-passage-paragraph">Birds also display remarkable behavior in collecting building materials. Crows have been seen to tear off stout green twigs, and sparrowhawks will dive purposefully onto a branch until it snaps and then hang upside down to break it off. Golden eagles, over generations of work, construct enormous nests. One of these, examined after it had been dislodged by high winds, weighed almost two tons and included foundation branches almost two meters long. The carrying capacity of the eagles, however, is only relative to their size and most birds are able to carry an extra load of just over twenty percent of their body weight.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)'],
                    'questions' => [
                        ['number' => 11, 'text' => 'The word "obscure" in line 1 is closest in meaning to', 'options' => ['A' => 'interesting', 'B' => 'unclear', 'C' => 'imperfect', 'D' => 'complex'], 'answer' => 'B'],
                        ['number' => 12, 'text' => 'According to the passage, which of the following activities is characteristic of the early part of the reproductive cycle of birds?', 'options' => ['A' => 'Selecting a mate', 'B' => 'Collecting nest-building materials', 'C' => 'Playing with nest-building materials', 'D' => 'Building a nest'], 'answer' => 'C'],
                        ['number' => 13, 'text' => 'The word "display" in line 17 is closest in meaning to', 'options' => ['A' => 'communicate', 'B' => 'imitate', 'C' => 'initiate', 'D' => 'exhibit'], 'answer' => 'D'],
                        ['number' => 14, 'text' => 'The novelist John Steinbeck is mentioned in line 14 because he', 'options' => ['A' => 'conducted a scientific study on the behavior of ospreys', 'B' => 'was the first to describe where ospreys built their nests', 'C' => 'described the materials ospreys can use to build their nests', 'D' => 'compared the size of osprey nests with the nests of other species'], 'answer' => 'C'],
                        ['number' => 15, 'text' => 'Which of the following birds are mentioned as those that build nests that include unusual objects?', 'options' => ['A' => 'Ravens', 'B' => 'Ospreys', 'C' => 'Crows', 'D' => 'Sparrowhawks'], 'answer' => 'B'],
                        ['number' => 16, 'text' => 'According to the passage, when gathering materials to build their nests, sparrowhawks do which of the following?', 'options' => ['A' => 'Hang upside down', 'B' => 'Select only green twigs', 'C' => 'Use objects blowing in the wind', 'D' => 'Collect more branches than necessary'], 'answer' => 'A'],
                        ['number' => 17, 'text' => 'The word "these" in line 20 refers to', 'options' => ['A' => 'golden eagles', 'B' => 'generations', 'C' => 'winds', 'D' => 'nests'], 'answer' => 'D'],
                        ['number' => 18, 'text' => 'The word "load" in line 23 is closest in meaning to', 'options' => ['A' => 'weight', 'B' => 'number', 'C' => 'section', 'D' => 'level'], 'answer' => 'A'],
                        ['number' => 19, 'text' => 'The author mentions twenty percent in line 23 to indicate that', 'options' => ['A' => 'eagles are twenty percent bigger than most birds', 'B' => 'twenty percent of all nests include foundation branches', 'C' => 'the nests of eagles are twenty percent larger than those of other birds', 'D' => 'birds can carry twenty percent of their own weight'], 'answer' => 'D'],
                    ],
                ],
                [
                    'section_title' => 'Questions 20-30',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">A survey is a study, generally in the form of an interview or a questionnaire, that provides information concerning how people think and act. In the United States, the best-known surveys are the Gallup poll and the Harris poll. As anyone who watches the news during presidential campaigns knows, these polls have become an important part of political life in the United States.</p>
    <p class="toefl-passage-paragraph">North Americans are familiar with the many "person-on-the-street" interviews on local television news shows. While such interviews can be highly entertaining, they are not necessarily an accurate indication of public opinion. First, they reflect the opinions of only those people who appear at a certain location. Thus, such samples can be biased in favor of commuters, middle-class shoppers, or factory workers, depending on which area the newspeople select. Second, television interviews tend to attract outgoing people who are willing to appear on the air, while they frighten away others who may feel intimidated by a camera. A survey must be based on a precise, representative sampling if it is to genuinely reflect a broad range of the population.</p>
    <p class="toefl-passage-paragraph">In preparing to conduct a survey, sociologists must exercise great care in the wording of questions. An effective survey question must be simple and clear enough for people to understand it. It must also be specific enough so that there are no problems in interpreting the results. Even questions that are less structured must be carefully phrased in order to elicit the type of information desired. Surveys can be indispensable sources of information, but only if the sampling is done properly and the questions are worded accurately.</p>
    <p class="toefl-passage-paragraph">There are two main forms of surveys: the interview and the questionnaire. Each of these forms of survey research has its advantages. An interviewer can obtain a high response rate because people find it more difficult to turn down a personal request for an interview than to throw away a written questionnaire. In addition, an interviewer can go beyond written questions and probe for a subject's underlying feelings and reasons. However, questionnaires have the advantage of being cheaper and more consistent.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 20, 'text' => 'What does the passage mainly discuss?', 'options' => ['A' => 'The history of surveys in North America', 'B' => 'The principles of conducting surveys', 'C' => 'Problems associated with interpreting surveys', 'D' => 'The importance of polls in American political life'], 'answer' => 'B'],
                        ['number' => 21, 'text' => 'The word "they" in line 8 refers to', 'options' => ['A' => 'North Americans', 'B' => 'news shows', 'C' => 'interviews', 'D' => 'opinions'], 'answer' => 'C'],
                        ['number' => 22, 'text' => 'According to the passage, the main disadvantage of person-on-the-street interviews is that they', 'options' => ['A' => 'are not based on a representative sampling', 'B' => 'are used only on television', 'C' => 'are not carefully worded', 'D' => 'reflect political opinions'], 'answer' => 'A'],
                        ['number' => 23, 'text' => 'The word "precise" in line 13 is closest in meaning to', 'options' => ['A' => 'planned', 'B' => 'rational', 'C' => 'required', 'D' => 'accurate'], 'answer' => 'D'],
                        ['number' => 24, 'text' => 'According to paragraph 3, which of the following is most important for an effective survey?', 'options' => ['A' => 'A high number of respondents', 'B' => 'Carefully worded questions', 'C' => 'An interviewer\'s ability to measure respondents\' feelings', 'D' => 'A sociologist who is able to interpret the results'], 'answer' => 'B'],
                        ['number' => 25, 'text' => 'The word "exercise" in line 15 is closest in meaning to', 'options' => ['A' => 'utilize', 'B' => 'consider', 'C' => 'design', 'D' => 'defend'], 'answer' => 'A'],
                        ['number' => 26, 'text' => 'The word "elicit" in line 18 is closest in meaning to', 'options' => ['A' => 'compose', 'B' => 'rule out', 'C' => 'predict', 'D' => 'bring out'], 'answer' => 'D'],
                        ['number' => 27, 'text' => 'It can be inferred from the passage that one reason that sociologists may become frustrated with questionnaires is that', 'options' => ['A' => 'respondents often do not complete and return questionnaires', 'B' => 'questionnaires are often difficult to read', 'C' => 'questionnaires are expensive and difficult to distribute', 'D' => 'respondents are too eager to supplement questions with their own opinions'], 'answer' => 'A'],
                        ['number' => 28, 'text' => 'According to the passage, one advantage of live interviews over questionnaires is that live interviews', 'options' => ['A' => 'cost less', 'B' => 'can produce more information', 'C' => 'are easier to interpret', 'D' => 'minimize the influence of the researcher'], 'answer' => 'B'],
                        ['number' => 29, 'text' => 'The word "probe" in line 25 is closest in meaning to', 'options' => ['A' => 'explore', 'B' => 'influence', 'C' => 'analyze', 'D' => 'apply'], 'answer' => 'A'],
                        ['number' => 30, 'text' => 'Which of the following terms is defined in the passage?', 'options' => ['A' => 'Survey (line 1)', 'B' => 'Public opinion (line 8)', 'C' => 'Representative sampling (line 13)', 'D' => 'Response rate (line 22)'], 'answer' => 'A'],
                    ],
                ],
                [
                    'section_title' => 'Questions 31-39',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">Perhaps one of the most dramatic and important changes that took place in the Mesozoic era occurred late in that era, among the small organisms that populate the uppermost, sunlit portion of the oceans -- the plankton. The term "plankton" is a broad one, designating all of the small plants and animals that float about or weakly propel themselves through the sea. In the late stages of the Mesozoic era, during the Cretaceous period, there was a great expansion of plankton that precipitated skeletons or shells composed of two types of mineral: silica and calcium carbonate. This development radically changed the types of sediments that accumulated on the seafloor, because, while the organic parts of the plankton decayed after the organisms died, their mineralized skeletons often survived and sank to the bottom. For the first time in the Earth's long history, very large quantities of silica skeletons, which would eventually harden into rock, began to pile up in parts of the deep sea. Thick deposits of calcareous ooze made up of the tiny remains of the calcium carbonate-secreting plankton also accumulated as never before. The famous white chalk cliffs of Dover, in the southeast of England, are just one example of the huge quantities of such material that amassed during the Cretaceous period; there are many more. Just why the calcareous plankton were so prolific during the latter part of the Cretaceous period is not fully understood. Such massive amounts of chalky sediments have never since been deposited over a comparable period of time.</p>
    <p class="toefl-passage-paragraph">The high biological productivity of the Cretaceous oceans also led to ideal conditions for oil accumulation. Oil is formed when organic material trapped in sediments is slowly buried and subjected to increased temperatures and pressures, transforming it into petroleum. Sediments rich in organic material accumulated along the margins of the Tethys Seaway, the tropical east-west ocean that formed when Earth's single landmass (known as Pangaea) split apart during the Mesozoic era. Many of today's important oil fields are found in those sediments -- in Russia, the Middle East, the Gulf of Mexico, and in the states of Texas and Louisiana in the United States.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 31, 'text' => 'What does the passage mainly discuss?', 'options' => ['A' => 'How sediments were built up in oceans during the Cretaceous period', 'B' => 'How petroleum was formed in the Mesozoic era', 'C' => 'The impact of changes in oceanic animal and plant life in the Mesozoic era', 'D' => 'The differences between plankton found in the present era and Cretaceous plankton'], 'answer' => 'C'],
                        ['number' => 32, 'text' => 'The passage indicates that the Cretaceous period occurred', 'options' => ['A' => 'in the early part of the Mesozoic era', 'B' => 'in the middle part of the Mesozoic era', 'C' => 'in the later part of the Mesozoic era', 'D' => 'after the Mesozoic era'], 'answer' => 'C'],
                        ['number' => 33, 'text' => 'The passage mentions all of the following aspects of plankton EXCEPT', 'options' => ['A' => 'the length of their lives', 'B' => 'the level of the ocean at which they are found', 'C' => 'their movement', 'D' => 'their size'], 'answer' => 'A'],
                        ['number' => 34, 'text' => 'The word "accumulated" in line 8 is closest in meaning to', 'options' => ['A' => 'depended', 'B' => 'matured', 'C' => 'dissolved', 'D' => 'collected'], 'answer' => 'D'],
                        ['number' => 35, 'text' => 'According to the passage, the most dramatic change to the oceans caused by plankton during the Cretaceous period concerned', 'options' => ['A' => 'the depth of the water', 'B' => 'the makeup of the sediment on the ocean floor', 'C' => 'the decrease in petroleum-producing sediment', 'D' => 'a decline in the quantity of calcareous ooze on the seafloor'], 'answer' => 'B'],
                        ['number' => 36, 'text' => 'The "white chalk cliffs of Dover" are mentioned in line 14 of the passage to', 'options' => ['A' => 'show where the plankton sediment first began to build up', 'B' => 'provide an example of a plankton buildup that scientists cannot explain', 'C' => 'provide an example of the buildup of plankton sediment', 'D' => 'indicate the largest single plankton buildup on Earth'], 'answer' => 'C'],
                        ['number' => 37, 'text' => 'The word "prolific" in line 16 is closest in meaning to', 'options' => ['A' => 'fruitful', 'B' => 'distinct', 'C' => 'determined', 'D' => 'energetic'], 'answer' => 'A'],
                        ['number' => 38, 'text' => 'The word "ideal" in line 19 is closest in meaning to', 'options' => ['A' => 'common', 'B' => 'clear', 'C' => 'perfect', 'D' => 'immediate'], 'answer' => 'C'],
                        ['number' => 39, 'text' => 'The word "it" in line 21 refers to', 'options' => ['A' => 'biological productivity', 'B' => 'oil', 'C' => 'organic material', 'D' => 'petroleum'], 'answer' => 'C'],
                    ],
                ],
                [
                    'section_title' => 'Questions 40-50',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">Of all modern instruments, the violin is apparently one of the simplest. It consists in essence of a hollow, varnished wooden sound box, or resonator, and a long neck, covered with a fingerboard, along which four strings are stretched at high tension. The beauty of design, shape, and decoration is no accident: the proportions of the instrument are determined almost entirely by acoustical considerations. Its simplicity of appearance is deceptive. About 70 parts are involved in the construction of a violin. Its tone and its outstanding range of expressiveness make it an ideal solo instrument. No less important, however, is its role as an orchestral and chamber instrument. In combination with the larger and deeper-sounding members of the same family, the violins form the nucleus of the modern symphony orchestra.</p>
    <p class="toefl-passage-paragraph">The violin has been in existence since about 1550. Its importance as an instrument in its own right dates from the early 1600's, when it first became standard in Italian opera orchestras. Its stature as an orchestral instrument was raised further when in 1626 Louis XIII of France established at his court the orchestra known as Les vingt-quatre violons du Roy (The King's 24 Violins), which was to become widely famous later in the century.</p>
    <p class="toefl-passage-paragraph">In its early history, the violin had a dull and rather quiet tone resulting from the fact that the strings were thick and were attached to the body of the instrument very loosely. During the eighteenth and nineteenth centuries, exciting technical changes were inspired by such composer-violinists as Vivaldi and Tartini. Their instrumental compositions demanded a fuller, clearer, and more brilliant tone that was produced by using thinner strings and a far higher string tension. Small changes had to be made to the violin's internal structure and to the fingerboard so that they could withstand the extra strain. Accordingly, a higher standard of performance was achieved, in terms of both facility and interpretation. Left-hand technique was considerably elaborated, and new fingering patterns on the fingerboard were developed for very high notes.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 40, 'text' => 'The word "standard" in line 12 is closest in meaning to', 'options' => ['A' => 'practical', 'B' => 'customary', 'C' => 'possible', 'D' => 'unusual'], 'answer' => 'B'],
                        ['number' => 41, 'text' => '"The King\'s 24 Violins" is mentioned in line 15 to illustrate', 'options' => ['A' => 'how the violin became a renowned instrument', 'B' => 'the competition in the 1600\'s between French and Italian orchestras', 'C' => 'the superiority of French violins', 'D' => 'why the violin was considered the only instrument suitable to be played by royalty'], 'answer' => 'A'],
                        ['number' => 42, 'text' => 'What is the main idea presented in paragraph 3?', 'options' => ['A' => 'The violin has been modified to fit its evolving musical functions.', 'B' => 'The violin is probably the best known and most widely distributed musical instrument in the world.', 'C' => 'The violin had reached the height of its popularity by the middle of the eighteenth century.', 'D' => 'The technique of playing the violin has remained essentially the same since the 1600\'s.'], 'answer' => 'A'],
                        ['number' => 43, 'text' => 'The author mentions Vivaldi and Tartini in line 20 as examples of composers whose music', 'options' => ['A' => 'inspired more people to play the violin', 'B' => 'had to be adapted to the violin', 'C' => 'demanded more sophisticated violins', 'D' => 'could be played only by their students'], 'answer' => 'C'],
                        ['number' => 44, 'text' => 'The word "they" in line 23 refers to', 'options' => ['A' => 'Vivaldi and Tartini', 'B' => 'thinner strings and a higher string tension', 'C' => 'small changes', 'D' => 'internal structure and fingerboard'], 'answer' => 'D'],
                        ['number' => 45, 'text' => 'The word "strain" in line 23 is closest in meaning to', 'options' => ['A' => 'struggle', 'B' => 'strength', 'C' => 'strategy', 'D' => 'stress'], 'answer' => 'D'],
                        ['number' => 46, 'text' => 'The word "Accordingly" in line 24 is closest in meaning to', 'options' => ['A' => 'However', 'B' => 'Consequently', 'C' => 'Nevertheless', 'D' => 'Ultimately'], 'answer' => 'B'],
                        ['number' => 47, 'text' => 'According to the passage, early violins were different from modern violins in that early violins', 'options' => ['A' => 'were heavier', 'B' => 'broke down more easily', 'C' => 'produced softer tones', 'D' => 'were easier to play'], 'answer' => 'C'],
                        ['number' => 48, 'text' => 'According to the passage, which of the following contributes to a dull sound being produced by a violin?', 'options' => ['A' => 'A long fingerboard', 'B' => 'A small body', 'C' => 'High string tension', 'D' => 'Thick strings'], 'answer' => 'D'],
                        ['number' => 49, 'text' => 'Which of the following terms is defined in the passage?', 'options' => ['A' => 'resonator (line 2)', 'B' => 'solo (line 7)', 'C' => 'left-hand technique (line 25)', 'D' => 'fingering patterns (lines 25-26)'], 'answer' => 'A'],
                        ['number' => 50, 'text' => 'All of the following are mentioned in the passage as contributing to the ability to play modern violin music EXCEPT', 'options' => ['A' => 'more complicated techniques for the left hand', 'B' => 'different ways to use the fingers to play very high notes', 'C' => 'use of rare wood for the fingerboard and neck', 'D' => 'minor alterations to the structure of the instrument'], 'answer' => 'C'],
                    ],
                ],
            ], 2),
        ];
    }

    private static function packageOne(): array
    {
        return [
            'package_number' => 1,
            'title' => 'Practice Test 01',
            'subtitle' => 'TOEFL ITP Reading Practice',
            'description' => 'Read each passage and choose the best answer for every question.',
            'directions' => 'Read the passages. Then choose the correct answer for each question.',
            'questions_count' => 50,
            'passages' => self::attachExplanations([
                [
                    'section_title' => 'Questions 1-10',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">All mammals feed their young. Beluga whale mothers, for example, nurse their calves for some twenty months, until they are about to give birth again and their young are able to find their own food. The behavior of feeding of the young is built into the reproductive system. It is a nonelective part of parental care and the defining feature of a mammal, the most important thing that mammals -- whether marsupials, platypuses, spiny anteaters, or placental mammals -- have in common.</p>
    <p class="toefl-passage-paragraph">But not all animal parents, even those that tend their offspring to the point of hatching or birth, feed their young. Most egg-guarding fish do not, for the simple reason that their young are so much smaller than the parents and eat food that is also much smaller than the food eaten by adults. In reptiles, the crocodile mother protects her young after they have hatched and takes them down to the water, where they will find food, but she does not actually feed them. Few insects feed their young after hatching, but some make other arrangement, provisioning their cells and nests with caterpillars and spiders that they have paralyzed with their venom and stored in a state of suspended animation so that their larvae might have a supply of fresh food when they hatch.</p>
    <p class="toefl-passage-paragraph">For animals other than mammals, then, feeding is not intrinsic to parental care. Animals add it to their reproductive strategies to give them an edge in their lifelong quest for descendants. The most vulnerable moment in any animal's life is when it first finds itself completely on its own, when it must forage and fend for itself. Feeding postpones that moment until a young animal has grown to such a size that it is better able to cope. Young that are fed by their parents become nutritionally independent at a much greater fraction of their full adult size. And in the meantime those young are shielded against the vagaries of fluctuating of difficult-to-find supplies. Once a species does take the step of feeding its young, the young become totally dependent on the extra effort. If both parents are removed, the young generally do no survive.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 1, 'text' => 'What does the passage mainly discuss?', 'options' => ['A' => 'The care that various animals give to their offspring.', 'B' => 'The difficulties young animals face in obtaining food.', 'C' => 'The methods that mammals use to nurse their young.', 'D' => 'The importance among young mammals of becoming independent.'], 'answer' => 'A'],
                        ['number' => 2, 'text' => 'The author lists various animals in line 5 to', 'options' => ['A' => 'contrast the feeding habits of different types of mammals', 'B' => 'describe the process by which mammals came to be defined', 'C' => 'emphasize the point that every type of mammal feeds its own young', 'D' => 'explain why a particular feature of mammals is nonelective'], 'answer' => 'C'],
                        ['number' => 3, 'text' => 'The word "tend" in line 7 is closest in meaning to', 'options' => ['A' => 'sit on', 'B' => 'move', 'C' => 'notice', 'D' => 'care for'], 'answer' => 'D'],
                        ['number' => 4, 'text' => 'What can be inferred from the passage about the practice of animal parents feeding their young?', 'options' => ['A' => 'It is unknown among fish.', 'B' => 'It is unrelated to the size of the young.', 'C' => 'It is dangerous for the parents.', 'D' => 'It is most common among mammals.'], 'answer' => 'D'],
                        ['number' => 5, 'text' => 'The word "provisioning" in line 13 is closest in meaning to', 'options' => ['A' => 'supplying', 'B' => 'preparing', 'C' => 'building', 'D' => 'expanding'], 'answer' => 'A'],
                        ['number' => 6, 'text' => 'According to the passage, how do some insects make sure their young have food?', 'options' => ['A' => 'By storing food near their young.', 'B' => 'By locating their nests or cells near spiders and caterpillars.', 'C' => 'By searching for food some distance from their nest.', 'D' => 'By gathering food from a nearby water source.'], 'answer' => 'A'],
                        ['number' => 7, 'text' => 'The word "edge" in line 17 is closest in meaning to', 'options' => ['A' => 'opportunity', 'B' => 'advantage', 'C' => 'purpose', 'D' => 'rest'], 'answer' => 'B'],
                        ['number' => 8, 'text' => 'The word "it" in line 20 refers to', 'options' => ['A' => 'feeding', 'B' => 'moment', 'C' => 'young animal', 'D' => 'size'], 'answer' => 'C'],
                        ['number' => 9, 'text' => 'According to the passage, animal young are most defenseless when', 'options' => ['A' => 'their parents are away searching for food', 'B' => 'their parents have many young to feed', 'C' => 'they are only a few days old', 'D' => 'they first become independent'], 'answer' => 'D'],
                        ['number' => 10, 'text' => 'The word "shielded" in line 22 is closest in meaning to', 'options' => ['A' => 'raised', 'B' => 'protected', 'C' => 'hatched', 'D' => 'valued'], 'answer' => 'B'],
                    ],
                ],
                [
                    'section_title' => 'Questions 11-21',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">Printmaking is the generic term for a number of processes, of which woodcut and engraving are two prime examples. Prints are made by pressing a sheet of paper (or other material) against an image-bearing surface to which ink has been applied. When the paper is removed, the image adheres to it, but in reverse.</p>
    <p class="toefl-passage-paragraph">The woodcut had been used in China from the fifth century A.D. for applying patterns to textiles. The process was not introduced into Europe until the fourteenth century, first for textile decoration and then for printing on paper. Woodcuts are created by a relief process; first, the artist takes a block of wood, which has been sawed parallel to the grain, covers it with a white ground, and then draws the image in ink. The background is carved away, leaving the design area slightly raised. The woodblock is inked, and the ink adheres to the raised image. It is then transferred to damp paper either by hand or with a printing press.</p>
    <p class="toefl-passage-paragraph">Engraving, which grew out of the goldsmith's art, originated in Germany and northern Italy in the middle of the fifteenth century. It is an intaglio process (from Italian intagliare, "to carve"). The image is incised into a highly polished metal plate, usually copper, with a cutting instrument, or burin. The artist inks the plate and wipes it clean so that some ink remains in the incised grooves. An impression is made on damp paper in a printing press, with sufficient pressure being applied so that the paper picks up the ink.</p>
    <p class="toefl-passage-paragraph">Both woodcut and engraving have distinctive characteristics. Engraving lends itself to subtle modeling and shading through the use of fine lines. Hatching and cross-hatching determine the degree of light and shade in a print. Woodcuts tend to be more linear, with sharper contrasts between light and dark. Printmaking is well suited to the production of multiple images. A set of multiples is called an edition. Both methods can yield several hundred good-quality prints before the original block or plate begins to show signs of wear. Mass production of prints in the sixteenth century made images available, at a lower cost, to a much broader public than before.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 11, 'text' => 'What does the passage mainly discuss?', 'options' => ['A' => 'The origins of textile decoration', 'B' => 'The characteristics of good-quality prints', 'C' => 'Two types of printmaking', 'D' => 'Types of paper used in printmaking'], 'answer' => 'C'],
                        ['number' => 12, 'text' => 'The word "prime" in line 2 is closest in meaning to', 'options' => ['A' => 'principal', 'B' => 'complex', 'C' => 'general', 'D' => 'recent'], 'answer' => 'A'],
                        ['number' => 13, 'text' => 'The author\'s purpose in paragraph 2 is to describe', 'options' => ['A' => 'the woodcuts found in China in the fifth century', 'B' => 'the use of woodcuts in the textile industry', 'C' => 'the process involved in creating a woodcut', 'D' => 'the introduction of woodcuts to Europe'], 'answer' => 'C'],
                        ['number' => 14, 'text' => 'The word "incised" in line 14 is closest in meaning to', 'options' => ['A' => 'burned', 'B' => 'cut', 'C' => 'framed', 'D' => 'baked'], 'answer' => 'B'],
                        ['number' => 15, 'text' => 'Which of the following terms is defined in the passage?', 'options' => ['A' => 'patterns', 'B' => 'grain', 'C' => 'burin', 'D' => 'grooves'], 'answer' => 'C'],
                        ['number' => 16, 'text' => 'The word "distinctive" in line 18 is closest in meaning to', 'options' => ['A' => 'unique', 'B' => 'accurate', 'C' => 'irregular', 'D' => 'similar'], 'answer' => 'A'],
                        ['number' => 17, 'text' => 'According to the passage, all of the following are true about engraving EXCEPT that it', 'options' => ['A' => 'developed from the art of the goldsmiths', 'B' => 'requires that the paper be cut with a burin', 'C' => 'originated in the fifteenth century', 'D' => 'involves carving into a metal plate'], 'answer' => 'B'],
                        ['number' => 18, 'text' => 'The word "yield" in line 22 is closest in meaning to', 'options' => ['A' => 'imitate', 'B' => 'produce', 'C' => 'revise', 'D' => 'contrast'], 'answer' => 'B'],
                        ['number' => 19, 'text' => 'According to the passage, what do woodcut and engraving have in common?', 'options' => ['A' => 'Their designs are slightly raised.', 'B' => 'They achieve contrast through hatching and cross-hatching.', 'C' => 'They were first used in Europe.', 'D' => 'They allow multiple copies to be produced from one original.'], 'answer' => 'D'],
                        ['number' => 20, 'text' => 'According to the author, what made it possible for members of the general public to own prints in the sixteenth century?', 'options' => ['A' => 'Prints could be made at low cost.', 'B' => 'The quality of paper and ink had improved.', 'C' => 'Many people became involved in the printmaking industry.', 'D' => 'Decreased demand for prints kept prices affordable.'], 'answer' => 'A'],
                        ['number' => 21, 'text' => 'According to the passage, all of the following are true about prints EXCEPT that they', 'options' => ['A' => 'can be reproduced on materials other than paper', 'B' => 'are created from a reversed image', 'C' => 'show variations between light and dark shades', 'D' => 'require a printing press'], 'answer' => 'D'],
                    ],
                ],
                [
                    'section_title' => 'Questions 22-31',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">The first peoples to inhabit what today is the southeastern United States sustained themselves as hunters and gathers. Sometimes early in the first millennium A.D., however, they began to cultivate corn and other crops. Gradually, as they became more skilled at gardening, they settled into permanent villages and developed a rich culture, characterized by the great earthen mounds they erected as monuments to their gods and as tombs for their distinguished dead. Most of these early mound builders were part of the Adena-Hopewell culture, which had its beginnings near the Ohio River and takes its name from sites in Ohio. The culture spread southward into the present-day states of Louisiana, Alabama, Georgia, and Florida. Its peoples became great traders, bartering jewellery, pottery, animal pelts, tools, and other goods along extensive trading networks that stretched up and down eastern North America and as far west as the Rocky Mountains.</p>
    <p class="toefl-passage-paragraph">About A.D. 400, the Hopewell culture fell into decay. Over the next centuries, it was supplanted by another culture, the Mississippian, named after the river along which many of its earliest villages were located. This complex civilization dominated the Southeast from about A.D. 700 until shortly before the Europeans began arriving in the sixteenth century. At the peak of its strength, about the year 1200, it was the most advanced culture in North America. Like their Hopewell predecessors, the Mississippians became highly skilled at growing food, although on a grander scale. They developed an improved strain of corn, which could survive in wet soil and a relatively cool climate, and also learned to cultivate beans. Indeed, agriculture became so important to the Mississippians that it became closely associated with the Sun -- the guarantor of good crops. Many tribes called themselves "children of the Sun" and believed their omnipotent priest-chiefs were descendants of the great sun god.</p>
    <p class="toefl-passage-paragraph">Although most Mississippians lived in small villages, many others inhabited large towns. Most of these towns boasted at least one major flat-topped mound on which stood a temple that contained a sacred flame. Only priests and those charged with guarding the flame could enter the temples. The mounds also served as ceremonial and trading sites, and at times they were used as burial grounds.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 22, 'text' => 'What does the passage mainly discuss?', 'options' => ['A' => 'The development of agriculture', 'B' => 'The locations of towns and villages', 'C' => 'The early people and cultures of the United States', 'D' => 'The construction of burial mounds'], 'answer' => 'C'],
                        ['number' => 23, 'text' => 'Which of the following resulted from the rise of agriculture in the southeastern United States?', 'options' => ['A' => 'The development of trade in North America', 'B' => 'The establishment of permanent settlements', 'C' => 'Conflicts with other Native American groups over land', 'D' => 'A migration of these peoples to the Rocky Mountains.'], 'answer' => 'B'],
                        ['number' => 24, 'text' => 'What does the term "Adena-Hopewell" designate?', 'options' => ['A' => 'The early locations of the Adena-Hopewell culture', 'B' => 'The two most important nations of the Adena-Hopewell culture', 'C' => 'Two former leaders who were honored with large burial mounds.', 'D' => 'Two important trade routes in eastern North America'], 'answer' => 'A'],
                        ['number' => 25, 'text' => 'The word "bartering" in line 9 is closest in meaning to', 'options' => ['A' => 'producing', 'B' => 'exchanging', 'C' => 'transporting', 'D' => 'loading'], 'answer' => 'B'],
                        ['number' => 26, 'text' => 'The word "supplanted" in line 13 is closest in meaning to', 'options' => ['A' => 'conquered', 'B' => 'preceded', 'C' => 'replaced', 'D' => 'imitated'], 'answer' => 'C'],
                        ['number' => 27, 'text' => 'According to the passage, when did the Mississippian culture reach its highest point of development?', 'options' => ['A' => 'About A.D. 400', 'B' => 'Between A.D. 400 and A.D. 700', 'C' => 'About A.D. 1200', 'D' => 'In the sixteenth century'], 'answer' => 'C'],
                        ['number' => 28, 'text' => 'According to the passage, how did the agriculture of the Mississippians differ from that of their Hopewell predecessors?', 'options' => ['A' => 'The Mississippians produced more durable and larger crops of food.', 'B' => 'The Mississippians sold their food to other groups.', 'C' => 'The Mississippians could only grow plants in warm, dry climates.', 'D' => 'The Mississippians produced special foods for their religious leaders.'], 'answer' => 'A'],
                        ['number' => 29, 'text' => 'Why does the author mention that many Mississippian tribes called themselves "children of the Sun"?', 'options' => ['A' => 'To explain why they were obedient to their priest-chiefs.', 'B' => 'To argue about the importance of religion in their culture.', 'C' => 'To illustrate the great importance they placed on agriculture.', 'D' => 'To provide an example of their religious rituals.'], 'answer' => 'C'],
                        ['number' => 30, 'text' => 'The phrase "charged with" in line 26 is closest in meaning to', 'options' => ['A' => 'passed on', 'B' => 'experienced at', 'C' => 'interested in', 'D' => 'assigned to'], 'answer' => 'D'],
                        ['number' => 31, 'text' => 'According to the passage, the flat-topped mounds in Mississippian towns were used for all of the following purposes EXCEPT', 'options' => ['A' => 'religious ceremonies', 'B' => 'meeting places for the entire community', 'C' => 'sites for commerce', 'D' => 'burial sites'], 'answer' => 'B'],
                    ],
                ],
                [
                    'section_title' => 'Questions 32-40',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">Overland transport in the United States was still extremely primitive in 1790. Roads were few and short, usually extending from inland communities to the nearest river town or seaport. Nearly all interstate commerce was carried out by sailing ships that served the bays and harbors of the seaboard. Yet, in 1790 the nation was on the threshold of a new era of road development. Unable to finance road construction, states turned for help to private companies, organized by merchants and land speculators who had a personal interest in improved communications with the interior. The pioneer in this move was the state of Pennsylvania, which chartered a company in 1792 to construct a turnpike, a road for the use of which a toll, or payment, is collected, from Philadelphia to Lancaster. The legislature gave the company the authority to erect tollgates at points along the road where payment would be collected, though it carefully regulated the rates. (The states had unquestioned authority to regulate private business in this period.)</p>
    <p class="toefl-passage-paragraph">The company built a gravel road within two years, and the success of the Lancaster Pike encouraged imitation. Northern states generally relied on private companies to build their toll roads, but Virginia constructed a network at public expense. Such was the road building fever that by 1810 New York alone had some 1,500 miles of turnpikes extending from the Atlantic to Lake Erie.</p>
    <p class="toefl-passage-paragraph">Transportation on these early turnpikes consisted of freight carrier wagons and passenger stagecoaches. The most common road freight carrier was the Conestoga wagon, a vehicle developed in the mid-eighteenth century by German immigrants in the area around Lancaster, Pennsylvania. It featured large, broad wheels able to negotiate all but the deepest ruts and holes, and its round bottom prevented the freight from shifting on a hill. Covered with canvas and drawn by four to six horses, the Conestoga wagon rivaled the log cabin as the primary symbol of the frontier. Passengers traveled in a variety of stagecoaches, the most common of which had four benches, each holding three persons. It was only a platform on wheels, with no springs; slender poles held up the top, and leather curtains kept out dust and rain.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 32, 'text' => 'Paragraph 1 discusses early road building in the United States mainly in terms of the', 'options' => ['A' => 'popularity of turnpikes', 'B' => 'financing of new roads', 'C' => 'development of the interior', 'D' => 'laws governing road use'], 'answer' => 'B'],
                        ['number' => 33, 'text' => 'The word "primitive" in line 1 is closest in meaning to', 'options' => ['A' => 'unsafe', 'B' => 'unknown', 'C' => 'inexpensive', 'D' => 'undeveloped'], 'answer' => 'D'],
                        ['number' => 34, 'text' => 'In 1790 most roads connected towns in the interior of the country with', 'options' => ['A' => 'other inland communities', 'B' => 'towns in other states', 'C' => 'river towns or seaports', 'D' => 'construction sites'], 'answer' => 'C'],
                        ['number' => 35, 'text' => 'The phrase "on the threshold of" in lines 4 and 5 is closest in meaning to', 'options' => ['A' => 'in need of', 'B' => 'in place of', 'C' => 'at the start of', 'D' => 'with the purpose of'], 'answer' => 'C'],
                        ['number' => 36, 'text' => 'According to the passage, why did states want private companies to help with road building?', 'options' => ['A' => 'The states could not afford to build roads themselves.', 'B' => 'The states were not as well equipped as private companies.', 'C' => 'Private companies could complete roads faster than the states.', 'D' => 'Private companies had greater knowledge of the interior.'], 'answer' => 'A'],
                        ['number' => 37, 'text' => 'The word "it" in line 11 refers to', 'options' => ['A' => 'legislature', 'B' => 'company', 'C' => 'authority', 'D' => 'payment'], 'answer' => 'A'],
                        ['number' => 38, 'text' => 'The word "imitation" in line 14 is closest in meaning to', 'options' => ['A' => 'investment', 'B' => 'suggestion', 'C' => 'increasing', 'D' => 'copying'], 'answer' => 'D'],
                        ['number' => 39, 'text' => 'Virginia is mentioned as an example of a state that', 'options' => ['A' => 'built roads without tollgates', 'B' => 'built roads with government money', 'C' => 'completed 1,500 miles of turnpikes in one year', 'D' => 'introduced new law restricting road use'], 'answer' => 'B'],
                        ['number' => 40, 'text' => 'The "large, broad wheels" of the Conestoga wagon are mentioned in line 21 as an example of a feature of wagons that was', 'options' => ['A' => 'unusual in mid-eighteenth century vehicles', 'B' => 'first found in Germany', 'C' => 'effective on roads with uneven surfaces', 'D' => 'responsible for frequent damage to freight'], 'answer' => 'C'],
                    ],
                ],
                [
                    'section_title' => 'Questions 41-50',
                    'content' => <<<'HTML'
<div class="toefl-passage-text">
    <p class="toefl-passage-paragraph">In Death Valley, California, one of the hottest, most arid places in North America, there is much salt, and salt can damage rocks impressively. Inhabitants of areas elsewhere, where streets and highways are salted to control ice, are familiar with the resulting rust and deterioration on cars. That attests to the chemically corrosive nature of salt, but it is not the way salt destroys rocks. Salt breaks rocks apart principally by a process called crystal prying and wedging. This happens not by soaking the rocks in salt water, but by moistening their bottoms with salt water. Such conditions exist in many areas along the eastern edge of central Death Valley. There, salty water rises from the groundwater table by capillary action through tiny spaces in sediment until it reaches the surface.</p>
    <p class="toefl-passage-paragraph">Most stones have capillary passages that suck salt water from the wet ground. Death Valley provides an ultra-dry atmosphere and high daily temperatures, which promote evaporation and the formation of salt crystals along the cracks or other openings within stones. These crystals grow as long as salt water is available. Like tree roots breaking up a sidewalk, the growing crystals exert pressure on the rock and eventually pry the rock apart along planes of weakness, such as banding in metamorphic rocks, bedding in sedimentary rocks, or preexisting or incipient fractions, and along boundaries between individual mineral crystals or grains. Besides crystal growth, the expansion of halite crystals (the same as everyday table salt) by heating and of sulfates and similar salts by hydration can contribute additional stresses. A rock durable enough to have withstood natural conditions for a very long time in other areas could probably be shattered into small pieces by salt weathering within a few generations.</p>
    <p class="toefl-passage-paragraph">The dominant salt in Death Valley is halite, or sodium chloride, but other salts, mostly carbonates and sulfates, also cause prying and wedging, as does ordinary ice. Weathering by a variety of salts, though often subtle, is a worldwide phenomenon. Not restricted to arid regions, intense salt weathering occurs mostly in salt-rich places like the seashore, near the large saline lakes in the Dry Valleys of Antarctica, and in desert sections of Australia, New Zealand, and central Asia.</p>
</div>
HTML,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)'],
                    'questions' => [
                        ['number' => 41, 'text' => 'What is the passage mainly about?', 'options' => ['A' => 'The destructive effects of salt on rocks.', 'B' => 'The impressive salt rocks in Death Valley.', 'C' => 'The amount of salt produced in Death Valley.', 'D' => 'The damaging effects of salt on roads and highways.'], 'answer' => 'A'],
                        ['number' => 42, 'text' => 'The word "it" in line 9 refers to', 'options' => ['A' => 'salty water', 'B' => 'groundwater table', 'C' => 'capillary action', 'D' => 'sediment'], 'answer' => 'A'],
                        ['number' => 43, 'text' => 'The word "exert" in line 14 is closest in meaning to', 'options' => ['A' => 'put', 'B' => 'reduce', 'C' => 'replace', 'D' => 'control'], 'answer' => 'A'],
                        ['number' => 44, 'text' => 'In lines 13-17, why does the author compare tree roots with growing salt crystals?', 'options' => ['A' => 'They both force hard surfaces to crack.', 'B' => 'They both grow as long as water is available.', 'C' => 'They both react quickly to a rise in temperature.', 'D' => 'They both cause salty water to rise from the groundwater table.'], 'answer' => 'A'],
                        ['number' => 45, 'text' => 'In lines 17-18, the author mentions the expansion of halite crystals by heating and of sulfates and similar salts by hydration in order to', 'options' => ['A' => 'present an alternative theory about crystal growth', 'B' => 'explain how some rocks are not affected by salt', 'C' => 'simplify the explanation of crystal prying and wedging', 'D' => 'introduce additional means by which crystals destroy rocks'], 'answer' => 'D'],
                        ['number' => 46, 'text' => 'The word "durable" in line 19 is closest in meaning to', 'options' => ['A' => 'large', 'B' => 'strong', 'C' => 'flexible', 'D' => 'pressured'], 'answer' => 'B'],
                        ['number' => 47, 'text' => 'The word "shattered" in line 20 is closest in meaning to', 'options' => ['A' => 'arranged', 'B' => 'dissolved', 'C' => 'broken apart', 'D' => 'gathered together'], 'answer' => 'C'],
                        ['number' => 48, 'text' => 'The word "dominant" in line 22 is closest in meaning to', 'options' => ['A' => 'most recent', 'B' => 'most common', 'C' => 'least available', 'D' => 'least damaging'], 'answer' => 'B'],
                        ['number' => 49, 'text' => 'According to the passage, which of the following is true about the effects of salts on rocks?', 'options' => ['A' => 'Only two types of salts cause prying and wedging.', 'B' => 'Salts usually cause damage only in combination with ice.', 'C' => 'A variety of salts in all kinds of environments can cause weathering.', 'D' => 'Salt damage at the seashore is more severe than salt damage in Death Valley.'], 'answer' => 'C'],
                        ['number' => 50, 'text' => 'Which of the following can be inferred from the passage about rocks that are found in areas where ice is common?', 'options' => ['A' => 'They are protected from weathering.', 'B' => 'They do not allow capillary action of water.', 'C' => 'They show similar kinds of damage as rocks in Death Valley.', 'D' => 'They contain more carbonates than sulfates.'], 'answer' => 'C'],
                    ],
                ],
            ], 1),
        ];
    }
}