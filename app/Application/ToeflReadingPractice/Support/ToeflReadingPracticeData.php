<?php

namespace App\Application\ToeflReadingPractice\Support;

class ToeflReadingPracticeData
{
    public static function catalog(): array
    {
        $packages = [];

        foreach (range(1, 14) as $number) {
            $numFormatted = sprintf('%02d', $number);
            $packages[] = [
                'package_number' => $number,
                'title' => 'Practice Test ' . $numFormatted,
                'subtitle' => '5 Passages • 50 Questions',
                'status' => 'available',
                'description' => 'Latihan reading TOEFL ITP paket ' . $number . ' lengkap dengan 50 soal dan cek skor langsung.',
            ];
        }

        return $packages;
    }

    public static function package(int $number): ?array
    {
        $data = match ($number) {
            1 => Packages\Package01::data(),
            2 => Packages\Package02::data(),
            3 => Packages\Package03::data(),
            4 => Packages\Package04::data(),
            5 => Packages\Package05::data(),
            6 => Packages\Package06::data(),
            7 => Packages\Package07::data(),
            8 => Packages\Package08::data(),
            9 => Packages\Package09::data(),
            10 => Packages\Package10::data(),
            11 => Packages\Package11::data(),
            12 => Packages\Package12::data(),
            13 => Packages\Package13::data(),
            14 => Packages\Package14::data(),
            default => null,
        };

        if (!$data) {
            return null;
        }

        $data['passages'] = self::attachExplanations($data['passages'], $number);

        return $data;
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
}