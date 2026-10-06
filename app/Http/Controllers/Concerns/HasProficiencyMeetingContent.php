<?php

namespace App\Http\Controllers\Concerns;

trait HasProficiencyMeetingContent
{
    private function proficiencyMeetingQuestions(int $meeting): array
    {
        return match ($meeting) {
            1 => [ // Suffixes
                'Efisiensi sistem operasional perusahaan telah meningkat secara signifikan.',
                'Keandalan hasil tes sangat penting untuk penelitian medis ini.',
                'Para karyawan menunjukkan dedikasi yang luar biasa selama penyelesaian proyek.',
                'Ketidakstabilan ekonomi global mempengaruhi keputusan investasi para pemegang saham.',
                'Pelaksanaan kebijakan baru membutuhkan persetujuan dari dewan direksi.',
                'Pembangunan infrastruktur yang berkelanjutan adalah prioritas utama pemerintah.',
                'Pemahaman yang komprehensif tentang perilaku konsumen sangat penting untuk pemasaran.',
                'Keberhasilan kampanye periklanan bergantung pada kreativitas tim desain.',
                'Penilaian kinerja tahunan memberikan evaluasi yang obyektif bagi setiap staf.',
                'Ketergantungan pada energi fosil harus dikurangi untuk menjaga kelestarian lingkungan.',
                'Penyesuaian strategi bisnis diperlukan untuk merespons fluktuasi pasar.',
                'Kerentanan sistem keamanan siber perusahaan perlu segera diatasi oleh tim IT.',
                'Validitas argumen yang disajikan dalam makalah akademis tersebut tidak diragukan lagi.',
                'Ketahanan material konstruksi diuji di bawah kondisi cuaca yang ekstrem.',
                'Partisipasi aktif dari seluruh warga diperlukan dalam program pemilihan umum.',
            ],
            2 => [ // Reducing
                'Archaebacteria adalah kelompok bakteri yang termasuk prokariot yang tinggal di lingkungan ekstrim seperti gunung berapi atau danau asin.',
                'Selain memiliki kombinasi yang unik dari gen, spesies mungkin juga memiliki variasi dalam bentuk dan komposisi dari kromosom yang membawa gen.',
                'Dam - dam yang dibangun untuk pengendali banjir bisa memberikan orang - orang yang tinggal di hilir dari dam sebuah rasa keamanan palsu.',
                'Sistem yang terdiri dari sub sistem terhubung yang dinamis bisa menjaga stabilitas melalui apa yang disebut ketahanan.',
                'Pemanasan global yang disebabkan oleh meningkatnya jumlah karbon di atmosfer merupakan akibat langsung dari revolusi industri.',
                'Semua populasi lokal dari spesies yang berbeda berinteraksi dalam cara yang berbeda di dalam jaringan rumit yang melibatkan aliran energi dan nutrisi dari satu populasi ke populasi lainnya.',
                'Pertumbuhan per capita Cina yang berata - rata 8.7 percent pada tahun 1990 - 2005 adalah salah satu pertumbuhan ekonomi tercepat di Dunia.',
                'Ekosistem hutan hujan yang telah menjadi sumber oxygen dunia sedang terancam oleh penebangan pohon liar.',
                'Banyak sumber air di dataran tinggi berasal dari glasier yang mencair di musim semi.',
                'Berbeda dengan glasiasi Phanerozoic, glasisasi Hirnantian bertahan kurang dari 1 juta tahun dengan kondisi glasiasi penuh yang bertahan 200.000 tahun.',
                'Penggunaan pestisida sintetis meningkatkan ketergantungan kita pada pestisida dalam proses yang disebut “pesticide treadmill”.',
                'Iklim juga mempengaruhi aktivitas manusia, seperti pertanian yang dipengaruhi oleh lama dari musim tanam, jumlah, dan distribusi dari hutan hujan dan temperatur.',
                'Ekonomi dari Gulf Cooperation Council (GCC) bergantung sepenuhnya pada produksi dari minyak dan semua sektor ekonomi yang berkutat pada keuntungan yang dihasilkan oleh ekspor minyak.',
                'Dengan menghancurkan bebatuan, lichen melepaskan ke kolam, danau, dan sungai komponen fosfat dan nitrat yang diperlukan oleh organisme, oleh karena itu menghasilkan nutrisi untuk mikroba tanah dan akar - akar tanaman.',
                'Fosil - fosil yang ditemukan dari ikan paus purba menunjukkan bahwa mereka masih memiliki kaki belakang 40.000 juta tahun yang lalu.',
                'Penelitian yang dilakukan di dalam laboratorium biologi molekuler telah menunjukkan bahwa sejumlah besar spesies memiliki variasi genetik yang rendah yang disebabkan oleh pengurangan ukuran populasi.',
                'Hypsodont terdiri dari serangkaian laminae tipis yang terbentuk dari enamel yang dikelilingi oleh dentine dengan cementum diantara tiap lamina.',
                'Karena properti intelektual adalah dalam jangkauan nasional, level dari perlindungan yang disediakan oleh instrumen semacam ini bisa bervariasi di seluruh negara.',
                'Sebuah joint venture adalah sebuah mekanisme bisnis untuk menggabungkan aset komplementer yang dimiliki oleh perusahaan yang berbeda.',
                'Akhir dari periode Permian yang ditandai dengan kepunahan dari banyak kelompok organisme yang telah mendominasi lingkungan laut dan darat selama ratusan juta tahun membukakan jalan bagi ekspansi dari fauna modern saat ini.',
            ],
            3 => [ // Abridgement
                'Beberapa spesies menjadi punah segera setelah mereka berevolusi.',
                'Setelah mendapatkan sebuah M.D dari Universitas Edinburgh, James Hutton kemudian mempelajari kimia dan kedokteran di Paris dan Leyden.',
                'Sejumlah besar dari organisme laut memiliki larva planktonic yang makan plankton sebelum mengalami metamorfosis.',
                'Bumi mengelilingi Matahari sambil berotasi pada sumbunya.',
                'Elapids ada di antara ular paling berbisa di planet, meskipun cenderung untuk kurang agresif daripada pit vipers.',
                'Boquila trifoliolata adalah satu - satunya tanaman yang dikenal untuk melakukan mimetic polymorphism seakan - akan memiliki mata.',
                'Ekosistem akan sedikit dirusak oleh perubahan iklim, spesies invasif, dan gangguan manusia jika beradaptasi sebagai respon dari perubahan.',
                'Dimanapun tinggal, mamalia selalu beradaptasi dengan lingkungan mereka.',
                'Sebuah virus yang berlipat ganda terlalu cepat sebelum bereproduksi dapat menghancurkan diri mereka sendiri.',
                'Pengaruh dari spesies invasif harus diminimalkan sekali setelah (once) mengkoloni suatu region.',
                'Mammoth menjadi punah setelah diburu oleh manusia purba.',
                'Bumi dipenuhi oleh jamur sebelum dipenuhi oleh tumbuhan.',
                'Antoninus Pius bertugas selama bertahun -tahun di Senate sebelum diadopsi sebagai penerus dari kaisar Hadrian pada 138 setelah masehi.',
                'PBB diprotes oleh banyak orang untuk kelambatannya ketika diminta untuk segera menyebarkan vaksin.',
                'Sebuah trangene menyebabkan sebuah tanaman untuk menunjukkan sebuah trait baru ketika secara sukses diperkenalkan dari tanaman lain.',
                'Bahkan crop yang tidak membutuhkan polinasi untuk bereproduksi, seperti cotton, memproduksi peningkatan total panen (yield) ketika dipolinasi.',
                'Gurita dapat berkamuflase seperti lingkungan sekitar mereka kapanpun terancam oleh predator.',
                'Berdasarkan pada catatan arkeologi, dimanapun diinvasi oleh manusia, ekosistem terganggu secara parah dan banyak hewan secara cepat kalah ke kepunahan.',
                'Swordfish harus mencapai ukuran tertentu sebelum dipanen.',
                'Negara - negara seperti Amerika Serikat dan Australia menerapkan hukum yang mengatakan bahwa seseorang tidak bersalah (innocent) hingga terbukti bersalah.',
                'Ide klasifikasi yang menggambarkan genealogy seharusnya diadopsi dimanapun mungkin.',
                'Penelitian terbaru telah menunjukkan bahwa archaeans, meskipun tidak pernah dominan, adalah anggota kosmopolitan dari plankton.',
                'Meskipun seekor mamalia, Platypus bertelur.',
                'Mesites meskipun mampu untuk terbang menghabiskan sebagian besar waktu mereka di atas tanah.',
                'Burung Dodo telah hidup di Pulau Mascarene selama 26 juta tahun sebelum punah di akhir 1600 an oleh perburuan manusia.',
                'Banyak hewan bersembunyi dan mengisolasikan diri mereka ketika sakit.',
                'Hanya jika ada di perairan Australia, Hiu putih melompat dari air untuk menangkap mangsa mereka.',
                'Sementara masih di dalam daftar hewan terancam punah, Harimau Sumatera mengalami peningkatan di dalam populasi mereka.',
                'Meskipun sukses, perang sipil telah memperlemah militer dari Assyrian.',
                'Kecuali (unless) tidak mampu terbang, burung menggunakan terbang sebagai mekanisme melarikan diri.',
            ],
            4 => [ // Omitting
                'Ini telah dihipotesiskan bahwa kita saat ini diambang kepunahan massal ke-enam.',
                'Boas menekankan bahwa antropologi berbeda dengan bidang lainnya dalam hal penelitian terhadap manusia di dalam masyarakat, bukan sebagai individual.',
                'Para peneliti telah menemukan bahwa efisiensi penggunaan air seringkali dirintangi oleh ketidak-kompetensian birokrasi, pertikaian akses air, penggunaan yang sia-sia dan perubahan iklim.',
                'Dari semua radiasi matahari yang Bumi terima dari matahari hampir 30 persen dipantulkan kembali ke luar angkasa oleh awan, debu, dan atmosfer.',
                'Ini adalah fakta bahwa kehidupan manusia bergantung pada keanekaragaman hayati.',
                'Anak - anak menggunakan kemampuan bawaan untuk mempelajari bahasa yang mereka terekspos.',
                'Para ilmuwan menduga bahwa black hole hadir di pusat dari galaksi - galaksi.',
                'Kebudayaan yang orang - orang miliki memiliki kebijaksanaan di dalamnya.',
                'Sebagian besar masyarakat menolak kebijakan yang kongres sahkan.',
                'Perkembangan mental anak - anak kemungkinan terganggu oleh sosial media melalui gadget yang banyak orang tua abaikan.',
            ],
            5 => [ // Inversion
                'Tidak pernah sebelumnya perusahaan mengalami kerugian finansial sebesar ini.',
                'Hanya setelah analisis data selesai, tim riset merumuskan kesimpulan akhir.',
                'Jarang sekali seorang pemimpin mengakui kesalahannya di depan publik.',
                'Sama sekali tidak saya menyadari bahwa proposal tersebut telah ditolak oleh klien.',
                'Tidak hanya mereka melanggar perjanjian kontrak, tetapi mereka juga merusak properti.',
                'Segera setelah peluncuran produk dimulai, sistem server mengalami gangguan jaringan.',
                'Sangat jarang para siswa mendapatkan kesempatan untuk berpartisipasi dalam konferensi tingkat ini.',
                'Sama sekali para investor tidak menduga bahwa pasar saham akan anjlok tajam.',
                'Hanya dengan menerapkan strategi ini kita dapat memenangkan persaingan bisnis global.',
                'Tepat di depan gedung utama berdiri monumen peringatan yang sangat bersejarah.',
                'Baru saja seminar dimulai ketika alarm kebakaran tiba-tiba berbunyi keras.',
                'Di bawah meja konferensi tersembunyi alat perekam suara rahasia.',
                'Hanya pada saat-saat krisis kualitas kepemimpinan yang sesungguhnya terlihat.',
                'Sangat sedikit manajer menyadari dampak psikologis dari restrukturisasi perusahaan.',
                'Sama sekali tidak dapat diterima bahwa laporan audit ini dimanipulasi secara sengaja.',
            ],
            6 => [ // Appositives
                'Dr. Smith, seorang pakar ekonomi terkemuka, memberikan kuliah tamu di kampus kami.',
                'Proyek infrastruktur baru, sebuah inisiatif ambisius pemerintah, membutuhkan dana triliunan rupiah.',
                'Buku terlarisnya, sebuah analisis mendalam tentang kecerdasan buatan, telah memenangkan banyak penghargaan.',
                'Jakarta, ibu kota Indonesia, adalah pusat bisnis dan pemerintahan yang padat.',
                'Keputusan manajer, sebuah langkah yang sangat kontroversial, menyebabkan protes dari para pekerja.',
                'Bapak Jokowi, Presiden Republik Indonesia, meresmikan bendungan baru di Jawa Barat.',
                'Senyawa kimia tersebut, sebuah elemen kunci dalam obat ini, disintesis di laboratorium.',
                'Universitas Harvard, salah satu institusi pendidikan tertua, memiliki standar penerimaan yang ketat.',
                'Bencana alam baru-baru ini, sebuah gempa bumi berkekuatan tinggi, menghancurkan banyak infrastruktur.',
                'Algoritma ini, sebuah terobosan dalam pembelajaran mesin, mengoptimalkan analisis data besar.',
                'Nyonya Lee, manajer sumber daya manusia kita, akan mengumumkan kebijakan cuti yang baru.',
                'Strategi pemasaran, sebuah pendekatan berbasis data komprehensif, terbukti sangat berhasil.',
                'Penemuan penisilin, sebuah pencapaian medis revolusioner, menyelamatkan jutaan nyawa.',
                'Gedung pencakar langit itu, sebuah keajaiban arsitektur modern, mendominasi cakrawala kota.',
                'Teori relativitas, mahakarya Albert Einstein, mengubah pemahaman kita tentang ruang dan waktu.',
            ],
            7 => [ // Adjective & Adverb
                'Sistem otomasi beroperasi secara sangat efisien, sehingga mengurangi biaya tenaga kerja.',
                'Perusahaan tersebut secara agresif memasarkan produk inovatif barunya kepada konsumen muda.',
                'Dampak ekonomi yang signifikan dari pandemi ini belum sepenuhnya dipahami oleh para ahli.',
                'Peneliti menganalisis data empiris dengan sangat cermat untuk menghindari kesalahan statistik.',
                'Manajemen merespons keluhan pelanggan secara cepat dan menyelesaikan masalah dengan efektif.',
                'Instruksi untuk merakit mesin yang rumit ini dijelaskan dengan sangat jelas.',
                'Tingkat pengangguran yang relatif tinggi sangat mengkhawatirkan pemerintah daerah saat ini.',
                'Pertumbuhan finansial perusahaan luar biasa stabil meskipun kondisi pasar sedang sulit.',
                'Protokol keamanan yang ketat diterapkan secara konsisten di seluruh departemen perusahaan.',
                'Tim ahli bedah melakukan operasi yang sangat kompleks dengan tingkat akurasi tinggi.',
                'Sikapnya yang sangat profesional dan tenang sangat dihargai selama negosiasi krisis.',
                'Laporan investasi tersebut disusun secara ringkas namun memuat informasi yang sangat komprehensif.',
                'Kampanye kesadaran lingkungan telah memengaruhi opini publik secara dramatis tahun ini.',
                'Software terbaru ini dirancang secara khusus untuk memenuhi kebutuhan bisnis berskala besar.',
                'Bahan kimia berbahaya harus ditangani secara sangat hati-hati oleh personel yang terlatih.',
            ],
            8 => [ // Fronting
                'Di puncak bukit itu berdiri sebuah observatorium astronomi yang sangat canggih.',
                'Ke dalam ruang rapat masuklah dewan direksi untuk memulai diskusi tahunan.',
                'Jauh di dalam hutan hujan tropis ditemukan spesies anggrek yang belum teridentifikasi.',
                'Di ujung koridor panjang terletak laboratorium tempat eksperimen rahasia dilakukan.',
                'Dengan sangat hati-hati teknisi tersebut membongkar mesin yang rusak itu.',
                'Kepada para pemegang saham, CEO menyampaikan laporan pendapatan kuartal ketiga.',
                'Hanya dalam beberapa dekade, teknologi internet telah mengubah cara kita berkomunikasi secara radikal.',
                'Di seberang jalan raya sedang dibangun sebuah kompleks apartemen mewah.',
                'Dari hasil analisis data muncul pola statistik yang sangat menarik dan tak terduga.',
                'Tepat di tengah krisis moneter, perusahaan teknologi tersebut berani melakukan ekspansi global.',
                'Sangat mengejutkan adalah keputusan pemerintah untuk tiba-tiba menaikkan suku bunga bank.',
                'Lebih penting dari sekadar keuntungan finansial adalah keberlanjutan lingkungan hidup.',
                'Dalam keheningan malam, suara ledakan mesin terdengar dari arah pabrik industri.',
                'Di sekitar inti sel terdapat mitokondria yang berfungsi sebagai penghasil energi.',
                'Secara tak terduga datanglah tawaran akuisisi dari perusahaan pesaing multinasional.',
            ],
            9 => [ // Clef Sentence
                'Adalah strategi pemasaran inovatif ini yang membuat penjualan kita meningkat drastis.',
                'Adalah profesor Johns yang pertama kali mempublikasikan teori kontroversial tersebut tahun lalu.',
                'Yang paling saya kagumi dari pemimpin tersebut adalah dedikasinya terhadap kesejahteraan rakyat.',
                'Bukanlah kekurangan dana yang menyebabkan proyek ini gagal, melainkan manajemen yang buruk.',
                'Adalah di konferensi internasional ini kita dapat memperluas jaringan bisnis secara efektif.',
                'Yang perusahaan butuhkan saat ini adalah seorang analis data yang sangat berpengalaman.',
                'Adalah melalui pendidikan berkualitas kita dapat secara efektif memberantas kemiskinan struktural.',
                'Yang terjadi sebenarnya adalah miskomunikasi antara departemen produksi dan departemen logistik.',
                'Adalah penemuan mesin uap yang memulai era Revolusi Industri di Eropa.',
                'Bukanlah teknologi yang menyelesaikan masalah, melainkan cara manusia menggunakannya.',
                'Yang paling dikhawatirkan oleh para investor adalah tingkat inflasi yang terus meroket.',
                'Adalah sistem perpajakan baru yang membebani usaha kecil dan menengah.',
                'Adalah kesabaran dan ketekunannya yang pada akhirnya membawa kesuksesan besar baginya.',
                'Yang membedakan produk ini dari kompetitor adalah daya tahannya yang luar biasa.',
                'Adalah di laboratorium kampus ini tim mahasiswa berhasil merakit prototipe robotika.',
            ],
            10 => [ // Conditional Sentences
                'Jika perusahaan berinvestasi dalam teknologi hijau, mereka akan mendapatkan insentif pajak dari pemerintah.',
                'Seandainya kami mengetahui perubahan jadwal itu lebih awal, kami pasti sudah menyesuaikan rencana presentasi.',
                'Apabila tingkat inflasi terus meningkat, bank sentral kemungkinan besar akan menaikkan suku bunga.',
                'Seandainya struktur bangunannya lebih kokoh, gedung itu tidak akan runtuh saat gempa bumi.',
                'Jika pelamar memiliki pengalaman manajerial, ia akan dipertimbangkan untuk posisi direktur eksekutif.',
                'Seandainya tim riset menerima dana yang cukup, mereka mungkin telah menemukan pengobatan baru.',
                'Kecuali kualitas produk ditingkatkan, kita akan kehilangan sebagian besar pelanggan setia kita.',
                'Bahkan jika anggaran disetujui besok, proyek konstruksi tetap akan mengalami keterlambatan.',
                'Seandainya kamu belajar pemrograman Python, kamu akan dengan mudah mendapatkan pekerjaan di bidang analitik data.',
                'Jika pemerintah tidak campur tangan dalam krisis ini, dampaknya terhadap ekonomi akan sangat merusak.',
                'Asalkan data dienkripsi dengan benar, kerahasiaan informasi pengguna akan terjamin keamanannya.',
                'Seandainya proposal merger tersebut diterima, kedua perusahaan akan menguasai pangsa pasar dominan.',
                'Jika mesin pendingin beroperasi pada kapasitas penuh, konsumsi energi akan meningkat secara signifikan.',
                'Seandainya saya mendengarkan nasihat penasihat keuangan, saya tidak akan mengalami kebangkrutan.',
                'Apabila kebijakan impor diperketat, industri manufaktur lokal akan mulai mendominasi pasar domestik.',
            ],
            default => [],
        };
    }

    private function proficiencyMeetingAnswerKeys(int $meeting): array
    {
        return match ($meeting) {
            1 => [
                1 => 'The efficiency of the company\'s operational system has improved significantly.',
                2 => 'The reliability of the test results is very important for this medical research.',
                3 => 'The employees showed remarkable dedication during the completion of the project.',
                4 => 'The instability of the global economy affects the investment decisions of the shareholders.',
                5 => 'The implementation of the new policy requires the approval of the board of directors.',
                6 => 'Sustainable infrastructure development is the government\'s main priority.',
                7 => 'A comprehensive understanding of consumer behavior is crucial for marketing.',
                8 => 'The success of the advertising campaign depends on the design team\'s creativity.',
                9 => 'The annual performance assessment provides an objective evaluation for every staff member.',
                10 => 'Dependence on fossil energy must be reduced to maintain environmental sustainability.',
                11 => 'Adjustment of business strategies is necessary to respond to market fluctuations.',
                12 => 'The vulnerability of the company\'s cyber security system needs to be addressed immediately by the IT team.',
                13 => 'The validity of the arguments presented in the academic paper is undoubted.',
                14 => 'The durability of construction materials is tested under extreme weather conditions.',
                15 => 'Active participation from all citizens is required in the general election program.',
            ],
            2 => [
                1 => 'Realizing the importance of innovation, the company allocated more funds for research.',
                2 => 'Written in simple language, the financial report is easily understood by beginners.',
                3 => 'Having finished his postgraduate studies, he founded a technology startup company.',
                4 => 'Surrounded by experts, the CEO felt confident about his strategic expansion decision.',
                5 => 'Hoping to increase sales, the manager launched a massive discount campaign.',
                6 => 'Being criticized by reviewers, the author decided to revise his draft manuscript.',
                7 => 'Facing intense competition, the company must find a unique value proposition.',
                8 => 'Built in the 19th century, this museum stores a collection of priceless historical artifacts.',
                9 => 'Despite experiencing financial difficulties, the charity organization continues to help the community.',
                10 => 'Impressed by the presentation, the investors agreed to fund the ambitious project.',
                11 => 'Working collaboratively, the research team successfully identified a new genetic mutation.',
                12 => 'Promoted as an organic product, consumers are willing to pay a premium price.',
                13 => 'Failing to meet the deadline, the contractor had to pay a substantial fine.',
                14 => 'Located in the business center, this office building offers highly strategic access.',
                15 => 'Considering all risks, the board of commissioners postponed the acquisition of the competitor company.',
            ],
            3 => [
                1 => 'Our main goal is to streamline the production process and reduce operational costs.',
                2 => 'Both high inflation and rising unemployment are major challenges for the economy.',
                3 => 'The manager suggested that we revise the project schedule, and the technicians agreed.',
                4 => 'This new software system is designed to be faster, more efficient, and more secure.',
                5 => 'Seminar participants can choose to attend either the morning or afternoon session.',
                6 => 'The candidate has a strong academic background and extensive industry experience.',
                7 => 'Monetary policy aims not only to control inflation but also to stimulate growth.',
                8 => 'Companies must adapt to technological changes, or they will lose market share.',
                9 => 'Students were asked to submit their assignments on Friday, but many did not.',
                10 => 'The strategic plan is ambitious, detailed, and highly challenging to implement.',
                11 => 'Most respondents agreed with the proposal, and some strongly supported it.',
                12 => 'This report analyzes market trends, identifies opportunities, and recommends strategic actions.',
                13 => 'Employee training covers technical skills as well as interpersonal communication abilities.',
                14 => 'The new building is not only designed with modern aesthetics but also built environmentally friendly.',
                15 => 'Some departments reported an increase in productivity, while others experienced a decline.',
            ],
            4 => [
                1 => 'Workers lacking the qualifications for the position will be automatically rejected.',
                2 => 'The project funded by the local government was completed on time.',
                3 => 'The equipment used in this laboratory was imported directly from Germany.',
                4 => 'Employees working the night shift receive additional allowances.',
                5 => 'The product launched last week received very positive reviews.',
                6 => 'Patients suffering from chronic diseases require specialized medical care.',
                7 => 'The data collected from the field survey will be analyzed statistically.',
                8 => 'The regulations implemented this month aim to improve workplace safety.',
                9 => 'The book written by the professor became a mandatory reference at the university.',
                10 => 'Students applying for the scholarship program must attach their academic transcripts.',
                11 => 'The facilities provided by the campus strongly support research activities.',
                12 => 'The document sent via email yesterday contained the details of the employment contract.',
                13 => 'The strategy proposed by the consultant proved highly effective in increasing profit.',
                14 => 'Customers purchasing premium products receive priority customer service.',
                15 => 'The article published in the prestigious journal cited many previous studies.',
            ],
            5 => [
                1 => 'Never before has the company experienced such massive financial losses.',
                2 => 'Only after the data analysis was completed did the research team formulate the final conclusion.',
                3 => 'Rarely does a leader admit his mistakes in public.',
                4 => 'Little did I realize that the proposal had been rejected by the client.',
                5 => 'Not only did they breach the contract agreement, but they also damaged the property.',
                6 => 'No sooner had the product launch started than the server system experienced a network failure.',
                7 => 'Seldom do students get the opportunity to participate in a conference of this level.',
                8 => 'Little did the investors expect that the stock market would plunge sharply.',
                9 => 'Only by implementing this strategy can we win the global business competition.',
                10 => 'Right in front of the main building stands a very historic memorial monument.',
                11 => 'Hardly had the seminar begun when the fire alarm suddenly rang loudly.',
                12 => 'Under the conference table lay a hidden voice recording device.',
                13 => 'Only in moments of crisis is the true quality of leadership seen.',
                14 => 'Little did the managers realize the psychological impact of the corporate restructuring.',
                15 => 'In no way is it acceptable that this audit report was intentionally manipulated.',
            ],
            6 => [
                1 => 'Dr. Smith, a prominent economic expert, gave a guest lecture at our campus.',
                2 => 'The new infrastructure project, an ambitious government initiative, requires trillions of rupiah in funding.',
                3 => 'His bestseller, an in-depth analysis of artificial intelligence, has won many awards.',
                4 => 'Jakarta, the capital of Indonesia, is a crowded business and government center.',
                5 => 'The manager\'s decision, a highly controversial move, led to protests from the workers.',
                6 => 'Mr. Jokowi, the President of the Republic of Indonesia, inaugurated a new dam in West Java.',
                7 => 'The chemical compound, a key element in this drug, was synthesized in the laboratory.',
                8 => 'Harvard University, one of the oldest educational institutions, has strict admission standards.',
                9 => 'The recent natural disaster, a high-magnitude earthquake, destroyed much infrastructure.',
                10 => 'This algorithm, a breakthrough in machine learning, optimizes big data analysis.',
                11 => 'Mrs. Lee, our human resources manager, will announce the new leave policy.',
                12 => 'The marketing strategy, a comprehensive data-driven approach, proved highly successful.',
                13 => 'The discovery of penicillin, a revolutionary medical achievement, saved millions of lives.',
                14 => 'The skyscraper, a marvel of modern architecture, dominates the city skyline.',
                15 => 'The theory of relativity, Albert Einstein\'s masterpiece, changed our understanding of space and time.',
            ],
            7 => [
                1 => 'The automation system operates highly efficiently, thereby reducing labor costs.',
                2 => 'The company aggressively marketed its new innovative product to young consumers.',
                3 => 'The significant economic impact of this pandemic is not yet fully understood by experts.',
                4 => 'Researchers analyzed the empirical data very carefully to avoid statistical errors.',
                5 => 'Management responded to customer complaints rapidly and resolved the issues effectively.',
                6 => 'The instructions to assemble this complicated machine are explained very clearly.',
                7 => 'The relatively high unemployment rate is extremely worrying to the local government right now.',
                8 => 'The company\'s financial growth is remarkably stable despite difficult market conditions.',
                9 => 'Strict security protocols are implemented consistently across all corporate departments.',
                10 => 'The team of surgeons performed a highly complex operation with high accuracy.',
                11 => 'His highly professional and calm demeanor was greatly appreciated during the crisis negotiations.',
                12 => 'The investment report was drafted concisely yet contains extremely comprehensive information.',
                13 => 'The environmental awareness campaign has influenced public opinion dramatically this year.',
                14 => 'This latest software is specifically designed to meet the needs of large-scale businesses.',
                15 => 'Hazardous chemicals must be handled extremely carefully by trained personnel.',
            ],
            8 => [
                1 => 'On top of the hill stood a very advanced astronomical observatory.',
                2 => 'Into the meeting room entered the board of directors to begin the annual discussion.',
                3 => 'Deep inside the tropical rainforest was found an unidentified species of orchid.',
                4 => 'At the end of the long corridor lies the laboratory where secret experiments are conducted.',
                5 => 'With great care did the technician dismantle the broken machine.',
                6 => 'To the shareholders did the CEO present the third-quarter revenue report.',
                7 => 'In just a few decades has internet technology radically changed how we communicate.',
                8 => 'Across the highway is being built a luxury apartment complex.',
                9 => 'From the results of the data analysis emerged a very interesting and unexpected statistical pattern.',
                10 => 'Right in the middle of the monetary crisis did the technology company bravely undertake global expansion.',
                11 => 'Very surprising was the government\'s decision to suddenly raise bank interest rates.',
                12 => 'More important than mere financial profit is environmental sustainability.',
                13 => 'In the silence of the night could be heard the sound of machine explosions from the direction of the industrial factory.',
                14 => 'Around the cell nucleus are mitochondria that function as energy producers.',
                15 => 'Unexpectedly came an acquisition offer from a multinational competing company.',
            ],
            9 => [
                1 => 'It is this innovative marketing strategy that caused our sales to increase drastically.',
                2 => 'It was Professor Johns who first published the controversial theory last year.',
                3 => 'What I admire most about the leader is his dedication to the welfare of the people.',
                4 => 'It is not a lack of funding that caused this project to fail, but poor management.',
                5 => 'It is at this international conference that we can expand our business network effectively.',
                6 => 'What the company needs right now is a highly experienced data analyst.',
                7 => 'It is through quality education that we can effectively eradicate structural poverty.',
                8 => 'What actually happened was a miscommunication between the production department and the logistics department.',
                9 => 'It was the invention of the steam engine that started the era of the Industrial Revolution in Europe.',
                10 => 'It is not technology that solves problems, but how humans use it.',
                11 => 'What investors worry about most is the skyrocketing inflation rate.',
                12 => 'It is the new taxation system that burdens small and medium businesses.',
                13 => 'It was his patience and perseverance that ultimately brought him great success.',
                14 => 'What distinguishes this product from its competitors is its remarkable durability.',
                15 => 'It is in this campus laboratory that the team of students successfully assembled a robotics prototype.',
            ],
            10 => [
                1 => 'If the company invests in green technology, they will receive tax incentives from the government.',
                2 => 'If we had known about the schedule change earlier, we would certainly have adjusted the presentation plan.',
                3 => 'If the inflation rate continues to rise, the central bank will most likely raise interest rates.',
                4 => 'If the building\'s structure had been stronger, the building would not have collapsed during the earthquake.',
                5 => 'If the applicant has managerial experience, he will be considered for the executive director position.',
                6 => 'If the research team had received sufficient funding, they might have discovered a new treatment.',
                7 => 'Unless product quality is improved, we will lose most of our loyal customers.',
                8 => 'Even if the budget is approved tomorrow, the construction project will still experience delays.',
                9 => 'If you had learned Python programming, you would easily get a job in data analytics.',
                10 => 'If the government does not intervene in this crisis, its impact on the economy will be highly destructive.',
                11 => 'Provided that the data is encrypted properly, the confidentiality of user information will be guaranteed secure.',
                12 => 'If the merger proposal were accepted, the two companies would control a dominant market share.',
                13 => 'If the cooling machine operates at full capacity, energy consumption will increase significantly.',
                14 => 'If I had listened to the financial advisor\'s advice, I would not have experienced bankruptcy.',
                15 => 'If the import policy is tightened, the local manufacturing industry will begin to dominate the domestic market.',
            ],
            default => [],
        };
    }

    private function proficiencyMeetingParagraphs(int $meeting): array
    {
        return match ($meeting) {
            1 => [ // Suffixes
                'id' => 'Perkembangan pesat kecerdasan buatan telah memicu transformasi mendalam di berbagai sektor industri. Banyak perusahaan menyadari perlunya adaptasi teknologi untuk menjaga daya saing mereka. Namun, implementasi sistem otomatisasi ini sering kali menimbulkan kekhawatiran tentang hilangnya pekerjaan tradisional. Oleh karena itu, investasi dalam pelatihan keterampilan ulang menjadi keharusan strategis. Kolaborasi antara sektor publik dan swasta sangat penting untuk memastikan transisi yang mulus ini.',
                'en' => 'The rapid development of artificial intelligence has triggered a profound transformation across various industrial sectors. Many companies realize the necessity of technological adaptation to maintain their competitiveness. However, the implementation of these automation systems often raises concerns about the loss of traditional jobs. Therefore, investment in reskilling training becomes a strategic imperative. Collaboration between the public and private sectors is crucial to ensure this smooth transition.',
                'vocab' => [
                    'development' => ['id' => 'perkembangan', 'pos' => '(n)'],
                    'transformation' => ['id' => 'transformasi', 'pos' => '(n)'],
                    'competitiveness' => ['id' => 'daya saing', 'pos' => '(n)'],
                    'implementation' => ['id' => 'implementasi', 'pos' => '(n)'],
                    'automation' => ['id' => 'otomatisasi', 'pos' => '(n)'],
                    'investment' => ['id' => 'investasi', 'pos' => '(n)'],
                    'collaboration' => ['id' => 'kolaborasi', 'pos' => '(n)'],
                ]
            ],
            2 => [ // Reducing
                'id' => 'Menghadapi tekanan ekonomi global, pemerintah memutuskan untuk merevisi kebijakan fiskalnya. Diharapkan dapat merangsang investasi asing, undang-undang baru tersebut memotong tarif pajak perusahaan. Perusahaan yang beroperasi di sektor energi terbarukan akan menerima insentif tambahan. Berfokus pada pembangunan infrastruktur, anggaran negara telah dialokasikan secara besar-besaran untuk proyek jalan tol dan pelabuhan. Meskipun dikritik oleh beberapa pengamat ekonomi, langkah-langkah ini diprediksi akan mempercepat pemulihan ekonomi nasional.',
                'en' => 'Facing global economic pressure, the government decided to revise its fiscal policy. Expected to stimulate foreign investment, the new law cuts corporate tax rates. Companies operating in the renewable energy sector will receive additional incentives. Focusing on infrastructure development, the state budget has been heavily allocated to toll road and port projects. Despite being criticized by some economic observers, these measures are predicted to accelerate the national economic recovery.',
                'vocab' => [
                    'Face' => ['id' => 'Menghadapi', 'pos' => '(v1)'],
                    'Expect' => ['id' => 'Mengharapkan', 'pos' => '(v1)'],
                    'operate' => ['id' => 'beroperasi', 'pos' => '(v1)'],
                    'Focus' => ['id' => 'Berfokus pada', 'pos' => '(v1)'],
                    'Despite being criticized' => ['id' => 'Meskipun dikritik', 'pos' => '(phrase)'],
                ]
            ],
            3 => [ // Abridgement
                'id' => 'Proyek penelitian ini tidak hanya bertujuan untuk mengeksplorasi sumber energi alternatif, tetapi juga untuk mengurangi emisi karbon secara signifikan. Para ilmuwan mengusulkan desain turbin angin yang lebih ringan, lebih kuat, dan lebih tahan lama. Jika diimplementasikan dalam skala besar, teknologi inovatif ini dapat menurunkan biaya listrik dan menciptakan ribuan lapangan kerja baru. Banyak negara maju telah menyatakan ketertarikannya, dan beberapa negara berkembang mulai mempertimbangkan opsi serupa. Namun, pendanaan awal tetap menjadi tantangan utama, menghambat adopsi massal teknologi ini.',
                'en' => 'This research project aims not only to explore alternative energy sources but also to significantly reduce carbon emissions. Scientists proposed a wind turbine design that is lighter, stronger, and more durable. If implemented on a large scale, this innovative technology could lower electricity costs and create thousands of new jobs. Many developed countries have expressed interest, and several developing countries are beginning to consider similar options. However, initial funding remains a major challenge, hindering the mass adoption of this technology.',
                'vocab' => [
                    'not only... but also' => ['id' => 'tidak hanya... tetapi juga', 'pos' => '(conj)'],
                    'lighter, stronger, and more durable' => ['id' => 'lebih ringan, lebih kuat, dan lebih tahan lama', 'pos' => '(phrase)'],
                    'If implemented' => ['id' => 'Jika diimplementasikan', 'pos' => '(phrase)'],
                    'expressed interest' => ['id' => 'menyatakan ketertarikan', 'pos' => '(phrase)'],
                ]
            ],
            4 => [ // Omitting
                'id' => 'Kandidat yang memiliki sertifikasi profesional akan diprioritaskan dalam proses seleksi. Laporan yang diserahkan oleh komite audit menyoroti beberapa penyimpangan keuangan yang serius. Pasien yang didiagnosis menderita penyakit langka tersebut akan menerima perawatan gratis dari pemerintah. Data yang bocor akibat peretasan server menimbulkan kepanikan di kalangan pengguna aplikasi. Langkah-langkah keamanan yang diterapkan bulan lalu terbukti sangat efektif mencegah serangan siber lebih lanjut.',
                'en' => 'Candidates holding professional certifications will be prioritized in the selection process. The report submitted by the audit committee highlighted several serious financial irregularities. Patients diagnosed with the rare disease will receive free treatment from the government. The data leaked due to the server hack caused panic among application users. The security measures implemented last month proved highly effective in preventing further cyberattacks.',
                'vocab' => [
                    'hold' => ['id' => 'memiliki', 'pos' => '(v1)'],
                    'submit' => ['id' => 'menyerahkan', 'pos' => '(v1)'],
                    'diagnose' => ['id' => 'mendiagnosis', 'pos' => '(v1)'],
                    'leak' => ['id' => 'bocor', 'pos' => '(v1)'],
                    'implement' => ['id' => 'menerapkan', 'pos' => '(v1)'],
                ]
            ],
            5 => [ // Inversion
                'id' => 'Sama sekali tidak para direktur menyadari bahwa perusahaan berada di ambang kebangkrutan. Hanya setelah laporan keuangan tahunan diterbitkan, kebenaran tentang utang besar itu terungkap. Jarang sekali industri pasar saham mengalami volatilitas yang begitu ekstrem dalam waktu singkat. Baru saja CEO mengumumkan pengunduran dirinya ketika nilai saham anjlok tajam. Tidak hanya manajemen gagal mengantisipasi krisis, tetapi mereka juga menyembunyikan informasi dari para pemegang saham.',
                'en' => 'Little did the directors realize that the company was on the verge of bankruptcy. Only after the annual financial report was published was the truth about the massive debt revealed. Seldom does the stock market industry experience such extreme volatility in a short time. Hardly had the CEO announced his resignation when the stock value plummeted sharply. Not only did the management fail to anticipate the crisis, but they also hid information from the shareholders.',
                'vocab' => [
                    'Little did... realize' => ['id' => 'Sama sekali tidak... menyadari', 'pos' => '(phrase)'],
                    'Only after...' => ['id' => 'Hanya setelah...', 'pos' => '(phrase)'],
                    'Seldom does...' => ['id' => 'Jarang sekali...', 'pos' => '(phrase)'],
                    'Hardly had...' => ['id' => 'Baru saja... ketika', 'pos' => '(phrase)'],
                    'Not only did...' => ['id' => 'Tidak hanya...', 'pos' => '(phrase)'],
                ]
            ],
            6 => [ // Appositives
                'id' => 'Dr. Amelia, seorang ahli biologi kelautan terkemuka, telah menghabiskan dua dekade meneliti terumbu karang. Bukunya yang terbaru, sebuah mahakarya tentang ekologi samudra, menyoroti dampak pemanasan global. Great Barrier Reef, sistem terumbu karang terbesar di dunia, saat ini menghadapi pemutihan massal yang parah. Fenomena ini, peringatan keras bagi umat manusia, membutuhkan tindakan konservasi segera. Pemerintah Australia, kustodian utama wilayah ini, telah mengalokasikan jutaan dolar untuk riset dan perlindungan.',
                'en' => 'Dr. Amelia, a leading marine biologist, has spent two decades researching coral reefs. Her latest book, a masterpiece on ocean ecology, highlights the impacts of global warming. The Great Barrier Reef, the world\'s largest coral reef system, is currently facing severe mass bleaching. This phenomenon, a stark warning to humanity, requires immediate conservation action. The Australian government, the primary custodian of this region, has allocated millions of dollars for research and protection.',
                'vocab' => [
                    'a leading marine biologist' => ['id' => 'seorang ahli biologi kelautan terkemuka', 'pos' => '(appositive)'],
                    'a masterpiece on ocean ecology' => ['id' => 'sebuah mahakarya tentang ekologi samudra', 'pos' => '(appositive)'],
                    'a stark warning to humanity' => ['id' => 'peringatan keras bagi umat manusia', 'pos' => '(appositive)'],
                    'the primary custodian' => ['id' => 'kustodian utama', 'pos' => '(appositive)'],
                ]
            ],
            7 => [ // Adjective & Adverb
                'id' => 'Inovasi teknologi ini sangat krusial bagi kelangsungan hidup perusahaan di pasar global. Tim insinyur bekerja secara luar biasa tekun untuk memecahkan masalah sistemik tersebut. Meskipun harganya relatif mahal, permintaan untuk kendaraan listrik terus meningkat secara stabil. Perangkat lunak analitik itu dengan cepat dan akurat mengidentifikasi anomali dalam database. Manajemen sangat puas dengan laporan komprehensif yang disajikan secara ringkas dan profesional oleh para konsultan.',
                'en' => 'This technological innovation is highly crucial for the company\'s survival in the global market. The engineering team worked remarkably diligently to solve the systemic problem. Although the price is relatively expensive, the demand for electric vehicles continues to rise steadily. The analytic software rapidly and accurately identifies anomalies within the database. Management was extremely satisfied with the comprehensive report presented concisely and professionally by the consultants.',
                'vocab' => [
                    'highly crucial' => ['id' => 'sangat krusial', 'pos' => '(adv + adj)'],
                    'remarkably diligently' => ['id' => 'secara luar biasa tekun', 'pos' => '(adv + adv)'],
                    'relatively expensive' => ['id' => 'relatif mahal', 'pos' => '(adv + adj)'],
                    'rise steadily' => ['id' => 'meningkat secara stabil', 'pos' => '(v + adv)'],
                    'concisely and professionally' => ['id' => 'secara ringkas dan profesional', 'pos' => '(adv)'],
                ]
            ],
            8 => [ // Fronting
                'id' => 'Di jantung kawasan finansial itu berdirilah markas besar bank sentral yang megah. Ke dalam ruang sidang melangkah masuk hakim ketua dengan ekspresi wajah yang sangat serius. Tepat di bawah lapisan es Kutub Utara tersimpan cadangan gas alam yang sangat besar. Dari diskusi panel yang panjang tersebut muncul sebuah proposal resolusi yang inovatif. Sangat mengejutkan publik adalah pengungkapan skandal korupsi yang melibatkan beberapa menteri kabinet.',
                'en' => 'In the heart of the financial district stood the magnificent headquarters of the central bank. Into the courtroom stepped the presiding judge with a very serious facial expression. Right beneath the Arctic ice sheet lie enormous reserves of natural gas. From the long panel discussion emerged an innovative resolution proposal. Very surprising to the public was the revelation of a corruption scandal involving several cabinet ministers.',
                'vocab' => [
                    'In the heart of' => ['id' => 'Di jantung', 'pos' => '(phrase)'],
                    'Into the courtroom' => ['id' => 'Ke dalam ruang sidang', 'pos' => '(phrase)'],
                    'Right beneath' => ['id' => 'Tepat di bawah', 'pos' => '(phrase)'],
                    'From the long panel discussion' => ['id' => 'Dari diskusi panel yang panjang', 'pos' => '(phrase)'],
                    'Very surprising to the public' => ['id' => 'Sangat mengejutkan publik', 'pos' => '(phrase)'],
                ]
            ],
            9 => [ // Clef Sentence
                'id' => 'Adalah dedikasi dan kerja keras staf medis yang berhasil mengendalikan penyebaran virus tersebut. Bukanlah kurangnya sumber daya yang menghambat kemajuan proyek ini, melainkan lemahnya koordinasi antar departemen. Yang paling dikritik oleh aktivis lingkungan adalah lambatnya respons pemerintah terhadap krisis iklim. Adalah penemuan antibiotik di awal abad ke-20 yang merevolusi pengobatan modern secara drastis. Yang benar-benar dibutuhkan oleh industri pertanian saat ini adalah infrastruktur irigasi yang tahan terhadap cuaca ekstrem.',
                'en' => 'It was the dedication and hard work of the medical staff that successfully controlled the spread of the virus. It is not the lack of resources that hinders the progress of this project, but the weak coordination among departments. What environmental activists criticize most is the government\'s slow response to the climate crisis. It was the discovery of antibiotics in the early 20th century that drastically revolutionized modern medicine. What the agricultural industry truly needs right now is irrigation infrastructure resilient to extreme weather.',
                'vocab' => [
                    'It was... that' => ['id' => 'Adalah... yang', 'pos' => '(cleft)'],
                    'It is not... but' => ['id' => 'Bukanlah... melainkan', 'pos' => '(cleft)'],
                    'What... is' => ['id' => 'Yang... adalah', 'pos' => '(cleft)'],
                ]
            ],
            10 => [ // Conditional Sentences
                'id' => 'Jika pemerintah tidak segera menerapkan reformasi struktural, perekonomian akan menghadapi resesi berkepanjangan. Seandainya dewan direksi menyetujui proposal akuisisi tersebut tahun lalu, pangsa pasar kita pasti sudah berlipat ganda sekarang. Bahkan jika vaksin baru terbukti sangat efektif, distribusinya ke negara-negara berkembang akan tetap menjadi tantangan logistik yang besar. Seandainya kamu mengambil kursus manajemen risiko itu, kamu akan lebih siap menghadapi fluktuasi pasar saat ini. Asalkan standar keselamatan dipatuhi dengan ketat, kecelakaan kerja di pabrik industri dapat diminimalkan secara signifikan.',
                'en' => 'If the government does not implement structural reforms immediately, the economy will face a prolonged recession. If the board of directors had approved the acquisition proposal last year, our market share would certainly have doubled by now. Even if the new vaccine proves to be highly effective, its distribution to developing countries will remain a massive logistical challenge. If you had taken that risk management course, you would be better prepared to face current market fluctuations. Provided that safety standards are strictly followed, workplace accidents in industrial factories can be significantly minimized.',
                'vocab' => [
                    'If... will' => ['id' => 'Jika... akan', 'pos' => '(conditional type 1)'],
                    'If... had approved... would have doubled' => ['id' => 'Seandainya... menyetujui... pasti sudah berlipat ganda', 'pos' => '(conditional type 3)'],
                    'Even if...' => ['id' => 'Bahkan jika...', 'pos' => '(phrase)'],
                    'If... had taken... would be' => ['id' => 'Seandainya... mengambil... akan', 'pos' => '(mixed conditional)'],
                    'Provided that' => ['id' => 'Asalkan', 'pos' => '(phrase)'],
                ]
            ],
            default => [],
        };
    }

    public function proficiencyMeetingCheatSheet(int $meeting): ?array
    {
        return match ($meeting) {
            1 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            1. Pola Parts of Speech & Main Clause Structure (Modul Hal. 2)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kelas Kata (Parts of Speech)</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Fungsi Gramatikal</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Peran dalam Kalimat</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Contoh Perubahan Kata</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Noun (Kata Benda)</td>
                            <td class="p-3.5 text-gray-800">Menyatakan nama orang, tempat, benda, ide</td>
                            <td class="p-3.5 text-gray-800">Wajib sebagai Subject / Object</td>
                            <td class="p-3.5 italic text-gray-600">beauty, development, ecosystem</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Adjective (Kata Sifat)</td>
                            <td class="p-3.5 text-gray-800">Menjelaskan/memodifikasi Noun / Pronoun</td>
                            <td class="p-3.5 text-gray-800">Modifier sebelum Noun / Complement setelah To-Be</td>
                            <td class="p-3.5 italic text-gray-600">beautiful, sustainable, complex</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Verb (Kata Kerja)</td>
                            <td class="p-3.5 text-gray-800">Menyatakan aksi atau kondisi (Ordinary / Auxiliary)</td>
                            <td class="p-3.5 text-gray-800">Inti Predikat (Wajib ada dalam Main Clause)</td>
                            <td class="p-3.5 italic text-gray-600">beautify, transform, alter</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Adverb (Kata Keterangan)</td>
                            <td class="p-3.5 text-gray-800">Menjelaskan Verb, Adjective, atau Adverb lain</td>
                            <td class="p-3.5 text-gray-800">Keterangan waktu, tempat, cara, derajat</td>
                            <td class="p-3.5 italic text-gray-600">beautifully, significantly, highly</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman Parts of Speech:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Kalimat (Sentence) adalah kumpulan kata yang mengandung <strong>Main Clause ($S + V$)</strong> dan diakhiri tanda titik, tanya, atau seru.</li>
            <li class="leading-relaxed">Contoh: <em>Climate change (S) is altering (V) the world ecosystems (O).</em></li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             Aturan Emas Posisional:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Subjek kalimat <u>WAJIB</u> diisi oleh Noun atau Pronoun.</li>
            <li class="leading-relaxed">Satu Main Clause <u>WAJIB</u> memiliki setidaknya 1 Verb Asli (Finite Verb).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Bedakan kata sifat (beautiful), kata benda (beauty), dan kata kerja (beautify).</em>
    </div>
    
HTML
],
            2 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            2. Pola Academic Suffixes & Complex Nominalizations (Modul Hal. 2)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kelas Kata Target</th><th class="p-3.5 font-semibold border-b border-gray-700">Akhiran Akademik (Suffixes)</th><th class="p-3.5 font-semibold border-b border-gray-700">Fungsi Nominalisasi</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kata & Kalimat C1-C2</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Noun Suffixes</td><td class="p-3.5 text-gray-800">-ment, -tion, -ity, -ness, -ance, -ence, -th, -ty, -or, -er</td><td class="p-3.5 text-gray-800">Mengubah verb/adj menjadi kata benda abstrak</td><td class="p-3.5 italic text-gray-600">The rapid development of AI triggered profound transformation.</td></tr>
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Adjective Suffixes</td><td class="p-3.5 text-gray-800">-able, -al, -ive, -ic, -ous, -ful, -less, -ible</td><td class="p-3.5 text-gray-800">Membentuk kata sifat deskriptif presisi</td><td class="p-3.5 italic text-gray-600">Sustainable infrastructure development is a strategic priority.</td></tr>
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Verb Suffixes</td><td class="p-3.5 text-gray-800">-ize, -fy, -ate, -en, -age</td><td class="p-3.5 text-gray-800">Membentuk kata kerja aksi akademik</td><td class="p-3.5 italic text-gray-600">Companies must adapt automation to maintain competitiveness.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman Suffixes:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Nominalisasi (Nominalization) adalah teknik mengubah kata kerja/sifat menjadi kata benda untuk membuat gaya penulisan lebih formal, obyektif, dan berbobot akademik (C1–C2 Level).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Gunakan pembentukan kata berakhiran (-tion, -ment, -ity) secara tepat sesuai aturan tata bahasa Inggris.</li>
            <li class="leading-relaxed">Perhatikan pergeseran penekanan kata (stress shift) saat kata benda dibentuk.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Contoh: develop $\rightarrow$ development | transform $\rightarrow$ transformation | vulnerable $\rightarrow$ vulnerability.</em>
    </div>
    
HTML
],
            2 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            3. Reducing (Peringkasan Adjective Clause - RPS)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Kalimat</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Hasil Peringkasan</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kalimat Sebelum Diringkas</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Hasil Peringkasan (Kalimat Lengkap)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Kalimat aktif</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Ving</td>
                            <td class="p-3.5 italic text-gray-600">Caribou <strong>which migrates</strong> to South on winter is member of deer family.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold">Caribou <strong>migrating</strong> to South on winter is member of deer family.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Kalimat pasif</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">V3</td>
                            <td class="p-3.5 italic text-gray-600">Mastodons <strong>which were hunted</strong> by pre-historic human grazed in North.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold">Mastodon <strong>hunted</strong> by human grazed in North.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Kalimat nominal</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Adjective / Adverb / Noun</td>
                            <td class="p-3.5 italic text-gray-600">Human used to hunt giant sloth <strong>which was 3 meters tall</strong>.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold">Human used to hunt giant sloth <strong>3 meters tall</strong>.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
             Definisi & Aturan Reducing:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed"><strong>Reducing</strong> = Penghilangan Conjunction.</li>
            <li class="leading-relaxed">Digunakan untuk <strong>Adjective Clause pada Relative Pronoun as Subject (C V)</strong>.</li>
            <li class="leading-relaxed">Hasil dari peringkasan untuk kalimat aktif adalah <strong>Ving</strong>.</li>
            <li class="leading-relaxed">Hasil dari peringkasan untuk kalimat pasif adalah <strong>V3</strong>.</li>
            <li class="leading-relaxed">Hasil dari peringkasan untuk kalimat nominal adalah <strong>Adjective / Adverb / Noun</strong>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             + Tambahan: Peringkasan RPS yang Menghasilkan To Infinitive
        </strong>
        <p class="text-xs sm:text-sm text-amber-950 mb-2 leading-relaxed">
            Jika ingin melakukan peringkasan pada RPS maka kalimat majemuk yang akan diringkas <strong>harus mengandung certain word</strong>, yaitu:
        </p>
        <ul class="list-disc list-inside space-y-1.5 ml-2 text-xs sm:text-sm text-amber-950 font-medium">
            <li><strong>Superlative degree</strong> $\rightarrow$ <em>the best, the cheapest</em></li>
            <li><strong>Indefinite pronoun</strong> $\rightarrow$ <em>someone, somebody</em></li>
            <li><strong>Indefinite time</strong> $\rightarrow$ <em>the next, the last</em></li>
            <li><strong>Ordinal number</strong> $\rightarrow$ <em>the first, the second</em></li>
            <li><strong>The only</strong> $\rightarrow$ <em>satu-satunya</em></li>
        </ul>
        <div class="mt-3 text-xs text-amber-900 font-mono bg-white p-2.5 rounded-lg border border-amber-200/80">
            <strong>Contoh Peringkasan ke To Infinitive:</strong><br>
            • Normal: <em>The only person who love you purely is me.</em><br>
            • Reduce: <em>The only person <u>to love</u> you purely is me. / The only person <u>loving</u> you purely is me.</em><br>
            • Normal: <em>The first man who walked on the Moon was Neil Armstrong.</em><br>
            • Reduce: <em>The first man <u>to walk</u> on the Moon was Neil Armstrong. / The first man <u>walking</u> on the Moon was Neil Armstrong.</em>
        </div>
    </div>
    
HTML
],
            3 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            2. Abridgement (Penghilangan Subject dari Sub Clause)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Kalimat</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Hasil Peringkasan</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kalimat Sebelum Diringkas</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Hasil Peringkasan (Kalimat Lengkap)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Kalimat aktif</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Conjunction + Ving</td>
                            <td class="p-3.5 italic text-gray-600"><strong>When dinosaurs roamed</strong> the Earth, dinosaurs dominated many regions.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold"><strong>When roaming</strong> the Earth, dinosaurs dominated many regions.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Kalimat pasif</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Conjunction + V3</td>
                            <td class="p-3.5 italic text-gray-600"><strong>Since dodo birds were hunted</strong> for their meats, dodo birds became extinct.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold"><strong>Since hunted</strong> for their meats, dodo birds became extinct.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Kalimat nominal</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Conjunction + Adjective / Adverb / Noun</td>
                            <td class="p-3.5 italic text-gray-600"><strong>Although penguin is an Aves</strong>, penguin cannot fly.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold"><strong>Although an Aves</strong>, penguin cannot fly.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
             Syarat & Aturan Abridgement:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed"><strong>Abridgement</strong> = Penghilangan Subject dari Sub Clause.</li>
            <li class="leading-relaxed">Digunakan untuk <strong>Adverbial Clause</strong>.</li>
            <li class="leading-relaxed"><strong>Syarat:</strong> Subject dari Main Clause <u>sama dengan</u> Subject dari Sub Clause.</li>
            <li class="leading-relaxed"><strong>Pengecualian:</strong> Tidak bisa digunakan untuk Conjunction <em>because</em> dan <em>if</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             Formulasi Hasil Abridgement:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Kalimat aktif $\rightarrow$ <strong>Conjunction + Ving</strong></li>
            <li class="leading-relaxed">Kalimat pasif $\rightarrow$ <strong>Conjunction + V3</strong></li>
            <li class="leading-relaxed">Kalimat nominal $\rightarrow$ <strong>Conjunction + Adjective / Adverb / Noun</strong></li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: When roaming the Earth... | Since hunted for their meats... | Although an Aves...</em>
    </div>
    
HTML
],
            4 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            1. Omitting (Penghilangan Conjunction pada Sub Clause)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tipe Omitting</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Aturan Penggunaan</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kalimat Sebelum Omitting</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Hasil Peringkasan (Omitting)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Noun Clause "that" as Object</td>
                            <td class="p-3.5 font-semibold text-blue-700 text-xs sm:text-sm">Penghilangan kata hubung <em>that</em></td>
                            <td class="p-3.5 italic text-gray-600">Some archeological evidences suggest <strong>that</strong> human began inhabiting America 2000 years ago.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold">Some archeological evidences suggest human began inhabiting America 2000 years ago.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Adjective Clause (RPO)</td>
                            <td class="p-3.5 font-semibold text-blue-700 text-xs sm:text-sm">Relative Pronoun as Object (C S V)</td>
                            <td class="p-3.5 italic text-gray-600">The theory <strong>which</strong> many people support seems to have fallacy.</td>
                            <td class="p-3.5 italic text-blue-900 font-semibold">The theory many people support seems to have fallacy.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Definisi Omitting:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed"><strong>Omitting</strong> = Penghilangan Conjunction pada Sub Clause.</li>
            <li class="leading-relaxed">Digunakan untuk <strong>Noun Clause "that" sebagai object</strong>.</li>
            <li class="leading-relaxed">Digunakan untuk <strong>Adjective Clause pada Relative Pronoun as Object (C S V)</strong>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             Aturan Penting Omitting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Hanya kata hubung <em>that</em> sebagai Objek Noun Clause atau relative pronoun sebagai Objek Adjective Clause (RPO) yang boleh dihilangkan.</li>
            <li class="leading-relaxed">Relative pronoun yang berfungsi sebagai Subjek (RPS) <u>TIDAK BOLEH</u> di-omitting secara langsung tanpa mengubah verb ke bentuk Participle (Ving/V3).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Evidences suggest human began... | The theory many people support...</em>
    </div>
    
HTML
],
            5 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Inversion (Negative Fronting & Inverted Conditionals)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tipe Inversi</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Inversi</th><th class="p-3.5 font-semibold border-b border-gray-700">Kata Kunci Depan</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik C1-C2</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Negative Fronting</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Neg. Adverb + Aux + Subject + Verb</td><td class="p-3.5 text-gray-800">Never, Seldom, Rarely, Hardly, Little</td><td class="p-3.5 italic text-gray-600">Little did the directors realize that the company was bankrupt.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Only / Restrictive Fronting</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Only after / Only by + Aux + S + V</td><td class="p-3.5 text-gray-800">Only after, Only by, Only in</td><td class="p-3.5 italic text-gray-600">Only after the financial report was published was the truth revealed.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Inverted Conditional (Type 3)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Had + Subject + V3, Main Clause</td><td class="p-3.5 text-gray-800">Had (seandainya)</td><td class="p-3.5 italic text-gray-600">Had the board approved the proposal, our market share would double.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Inversi adalah pembalikan urutan Subjek dan Auxiliary Verb untuk memberikan efek penekanan emosional atau retoris yang kuat.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Setelah frasa negatif di awal kalimat, susunan kalimat WAJIB berbentuk pertanyaan (Auxiliary + Subject + Verb).</li><li class="leading-relaxed"><s>Little the directors realized</s> → <strong>Little did the directors realize</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Contoh: Seldom does the market experience... | Hardly had the CEO resigned when...</em>
    </div>
    
HTML
],
            6 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Advanced Participle Structures & Special Expressions
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kategori Participle</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Formula Gramatikal</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Fungsi / Makna</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Modul</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Verbs of Perception</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + see/hear/watch/feel + O + Ving / V1</td>
                            <td class="p-3.5 text-gray-800">Ving (proses sebagian) vs V1 (aksi utuh)</td>
                            <td class="p-3.5 italic text-gray-600">I saw him <strong>crossing</strong> the street. (Ving) / I saw him <strong>cross</strong> the street. (V1)</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Have Fun / Difficulty</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + have + fun/difficulty/trouble + Ving</td>
                            <td class="p-3.5 text-gray-800">Menyatakan pengalaman/kesulitan melakukan sesuatu</td>
                            <td class="p-3.5 italic text-gray-600">We had fun <strong>playing</strong> games. / She had difficulty <strong>finding</strong> the location.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Sit / Stand / Lie</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + sit/stand/lie + (place) + Ving</td>
                            <td class="p-3.5 text-gray-800">Postur tubuh sambil melakukan aksi lain</td>
                            <td class="p-3.5 italic text-gray-600">He sat <strong>reading</strong> a book. / She stood <strong>watching</strong> the sunset.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Spend / Waste Time/Money</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + spend/waste + time/money + Ving</td>
                            <td class="p-3.5 text-gray-800">Menghabiskan waktu/uang untuk suatu kegiatan</td>
                            <td class="p-3.5 italic text-gray-600">They spent three hours <strong>revising</strong> the essay.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Find / Catch Object</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + find/catch + Object + Ving</td>
                            <td class="p-3.5 text-gray-800">Menemukan/tertangkap basah sedang melakukan aksi</td>
                            <td class="p-3.5 italic text-gray-600">I found him <strong>sleeping</strong>. / The teacher caught them <strong>cheating</strong>.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman Participle:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Participle berfungsi sebagai <strong>Adjective (Kata Sifat)</strong> yang menjelaskan kondisi kata benda atau subjek.</li>
            <li class="leading-relaxed">Verbs of perception: <em>feel, hear, notice, listen, see, smell, cook, observe, watch</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             Aturan Emas Ekspresi Khusus Participle:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Setelah <em>spend/waste time/money</em>, kata kerja berikutnya <strong>WAJIB berbentuk V-ing</strong> (bukan To-Infinitive).</li>
            <li class="leading-relaxed">Setelah <em>have fun / have difficulty / have trouble</em>, kata kerja berikutnya <strong>WAJIB berbentuk V-ing</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Contoh: spend time studying (bukan to study) | had fun playing (bukan to play).</em>
    </div>
    
HTML
],
            7 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Advanced Adjective & Adverb Placement & Intensifiers
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tipe Modifier</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Gramatikal</th><th class="p-3.5 font-semibold border-b border-gray-700">Target Penguat Makna</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik C1-C2</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Academic Adverb Intensifier</td><td class="p-3.5 text-gray-800">highly / remarkably / profoundly + Adj</td><td class="p-3.5 text-gray-800">Memperkuat derajat kata sifat</td><td class="p-3.5 italic text-gray-600">Technological innovation is highly crucial for survival.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Adverbial Manner Placement</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Verb + Adverb + Verb / Object</td><td class="p-3.5 text-gray-800">Keterangan cara presisi</td><td class="p-3.5 italic text-gray-600">The team worked remarkably diligently to solve systemic issues.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Post-modifying Adverbial</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Verb + Object + Adverbially</td><td class="p-3.5 text-gray-800">Keterangan hasil di akhir</td><td class="p-3.5 italic text-gray-600">The analytical software rapidly and accurately identifies anomalies.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Di tingkat C1–C2, hindari kata umum seperti <em>very</em> atau <em>really</em>. Gunakan penegas akademik seperti <em>highly, remarkably, profoundly, substantially, considerably</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Letakkan kata keterangan (Adverb) secara tepat sebelum kata sifat yang diterangkan (<em>highly crucial, remarkably diligently</em>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Penggunaan penguat akademik meningkatkan bobot formalitas penulisan ilmiah.</em>
    </div>
    
HTML
],
            8 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Fronting & Topicalization (Keterangan Depan)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tipe Fronting</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Fronting</th><th class="p-3.5 font-semibold border-b border-gray-700">Elemen yang Dipindahkan ke Depan</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik C1-C2</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Prepositional Fronting</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Prep. Phrase + Verb + Subject</td><td class="p-3.5 text-gray-800">Frasa Tempat / Lokasi</td><td class="p-3.5 italic text-gray-600">In the heart of the financial district stood the central bank.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Directional Fronting</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Direction Phrase + Verb + Subject</td><td class="p-3.5 text-gray-800">Arah / Pergerakan</td><td class="p-3.5 italic text-gray-600">Into the courtroom stepped the presiding judge.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Adjectival Fronting</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Adjective Phrase + Verb + Subject</td><td class="p-3.5 text-gray-800">Kata Sifat / Penekanan Status</td><td class="p-3.5 italic text-gray-600">Very surprising to the public was the revelation of scandal.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Fronting memindahkan kata keterangan tempat/arah atau kata sifat ke paling depan kalimat untuk menciptakan transisi paragraf yang dramatis dan mengalir (*focus & flow*).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Ketika frasa keterangan dipindahkan ke paling depan, kata kerja (Verb) mendahului kata benda (Subject).</li><li class="leading-relaxed"><s>In the room the CEO entered</s> → <strong>Into the room stepped the CEO</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Fronting sangat efektif digunakan dalam penulisan deskriptif dan analisis naratif akademik.</em>
    </div>
    
HTML
],
            9 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Cleft Sentences (It-clefts & Wh-clefts)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tipe Cleft Sentence</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Cleft</th><th class="p-3.5 font-semibold border-b border-gray-700">Fokus Penekanan (Emphasis)</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik C1-C2</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">It-cleft (Fokus Subjek/Sebab)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">It is/was + Focus + that/who + Rest</td><td class="p-3.5 text-gray-800">Menekankan agen/penyebab spesifik</td><td class="p-3.5 italic text-gray-600">It was the dedication of medical staff that controlled the virus.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Wh-cleft (Pseudo-cleft)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">What + S + V + is/was + Focus</td><td class="p-3.5 text-gray-800">Menekankan kebutuhan/hasil utama</td><td class="p-3.5 italic text-gray-600">What environmental activists criticize most is the slow response.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Cleft Negasi (Contrast)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">It is not + A + but + B + that...</td><td class="p-3.5 text-gray-800">Membandingkan dua faktor bertentangan</td><td class="p-3.5 italic text-gray-600">It is not the lack of resources that hinders progress, but poor coordination.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Cleft Sentences membelah satu kalimat sederhana menjadi dua bagian untuk memberikan sorotan (highlight) kuat pada satu elemen penting.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">It-cleft: <strong>It + is/was + [elemen fokus] + that/who + [sisa kalimat]</strong>.</li><li class="leading-relaxed">Wh-cleft: <strong>What + [subjek + verb] + is/was + [elemen fokus]</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Format: It was the dedication that controlled... | What activists criticize is...</em>
    </div>
    
HTML
],
            10 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Advanced & Mixed Conditionals (Pengandaian Tingkat Lanjut)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tipe Conditional</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Pengandaian</th><th class="p-3.5 font-semibold border-b border-gray-700">Hubungan Waktu</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik C1-C2</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Mixed Conditional (Past → Pres)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">If + S + had V3, S + would + V1</td><td class="p-3.5 text-gray-800">Sebab Masa Lalu → Akibat Masa Sekarang</td><td class="p-3.5 italic text-gray-600">If the board had approved the acquisition, our market share would double now.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Mixed Conditional (Pres → Past)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">If + S + V2/were, S + would have V3</td><td class="p-3.5 text-gray-800">Sifat Masa Sekarang → Akibat Masa Lalu</td><td class="p-3.5 italic text-gray-600">If you were more cautious, you would not have experienced bankruptcy.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Inverted Conditional (Type 3)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Had + S + V3, S + would have V3</td><td class="p-3.5 text-gray-800">Pengandaian Lampau Inversi Formal</td><td class="p-3.5 italic text-gray-600">Had structural reforms been implemented, the recession would be avoided.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Alternative Conditioners</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Provided that / As long as + S + V1</td><td class="p-3.5 text-gray-800">Persyaratan Mutlak</td><td class="p-3.5 italic text-gray-600">Provided that safety standards are followed, accidents can be minimized.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Mixed Conditionals menghubungkan waktu yang berbeda antara sebab dan akibat (misalnya: keputusan masa lalu mempengaruhi kondisi saat ini).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Gunakan konjungsi alternatif seperti <em>provided that, as long as, on condition that, assuming that</em> sebagai variasi kata <em>if</em>.</li><li class="leading-relaxed">Inversi pengandaian tipe 3 menghilangkan kata 'if' dan memajukan 'Had' ke depan.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Format: Had the board approved... | Provided that safety standards are followed...</em>
    </div>
    
HTML
],
            default => null,
        };
    }



    private function proficiencyMeetingQuestionHelpers(int $meeting): array
    {
        $questions = $this->proficiencyMeetingQuestions($meeting);
        $helpers = [];

        foreach ($questions as $index => $qText) {
            $num = $index + 1;
            $helpers[$num] = $this->buildProficiencyQuestionHelperItem($meeting, $num, $qText);
        }

        return $helpers;
    }

    private function buildProficiencyQuestionHelperItem(int $meeting, int $num, string $qText): array
    {
        $sampleMap = [
            1 => ['id' => 'Efisiensi sistem operasional perusahaan meningkat secara signifikan.', 'en' => 'The efficiency of the operational system improved significantly.'],
            2 => ['id' => 'Menghadapi tekanan ekonomi global, pemerintah merevisi kebijakan fiskalnya.', 'en' => 'Facing global economic pressure, the government revised its fiscal policy.'],
            3 => ['id' => 'Proyek ini bertujuan untuk mengeksplorasi energi terbarukan.', 'en' => 'This project aims to explore renewable energy.'],
            4 => ['id' => 'Kandidat yang memiliki sertifikasi profesional akan diprioritaskan.', 'en' => 'Candidates holding professional certification will be prioritized.'],
            5 => ['id' => 'Jarang sekali seorang pemimpin mengakui kesalahannya di depan publik.', 'en' => 'Rarely does a leader admit his mistakes in public.'],
            6 => ['id' => 'Dr. Smith, seorang pakar ekonomi terkemuka, memberikan kuliah.', 'en' => 'Dr. Smith, a leading economic expert, gave a lecture.'],
            7 => ['id' => 'Inovasi teknologi ini sangat krusial bagi kelangsungan perusahaan.', 'en' => 'This technological innovation is highly crucial for the company.'],
            8 => ['id' => 'Di puncak bukit itu berdiri observatorium astronomi yang canggih.', 'en' => 'On top of the hill stood an advanced astronomical observatory.'],
            9 => ['id' => 'Adalah strategi pemasaran ini yang membuat penjualan meningkat.', 'en' => 'It is this marketing strategy that caused sales to increase.'],
            10 => ['id' => 'Jika perusahaan berinvestasi dalam teknologi hijau, mereka mendapat insentif.', 'en' => 'If the company invests in green tech, they will receive incentives.']
        ];

        $example = $sampleMap[$meeting] ?? ['id' => 'Perhatikan pola klausa dan tenses pada kalimat ini.', 'en' => 'Observe the clause structure and tenses in this sentence.'];

        // Extract words for dynamic vocab helper
        $words = preg_split('/[\s,\.\(\)]+/', $qText);
        $vocab = [];
        
        $dict = [
            'efisiensi' => ['id' => 'efisiensi', 'pos' => '(n)'],
            'operasional' => ['id' => 'operasional', 'pos' => '(adj)'],
            'perusahaan' => ['id' => 'perusahaan', 'pos' => '(n)'],
            'keandalan' => ['id' => 'keandalan', 'pos' => '(n)'],
            'penelitian' => ['id' => 'penelitian', 'pos' => '(n)'],
            'karyawan' => ['id' => 'karyawan', 'pos' => '(n)'],
            'dedikasi' => ['id' => 'dedikasi', 'pos' => '(n)'],
            'penyelesaian' => ['id' => 'penyelesaian', 'pos' => '(n)'],
            'proyek' => ['id' => 'proyek', 'pos' => '(n)'],
            'ketidakstabilan' => ['id' => 'ketidakstabilan', 'pos' => '(n)'],
            'ekonomi' => ['id' => 'ekonomi', 'pos' => '(n)'],
            'keputusan' => ['id' => 'keputusan', 'pos' => '(n)'],
            'investasi' => ['id' => 'investasi', 'pos' => '(n)'],
            'pemegang saham' => ['id' => 'pemegang saham', 'pos' => '(n)'],
            'pelaksanaan' => ['id' => 'pelaksanaan', 'pos' => '(n)'],
            'kebijakan' => ['id' => 'kebijakan', 'pos' => '(n)'],
            'persetujuan' => ['id' => 'persetujuan', 'pos' => '(n)'],
            'infrastruktur' => ['id' => 'infrastruktur', 'pos' => '(n)'],
            'berkelanjutan' => ['id' => 'berkelanjutan', 'pos' => '(adj)'],
            'prioritas' => ['id' => 'prioritas', 'pos' => '(n)'],
            'pemerintah' => ['id' => 'pemerintah', 'pos' => '(n)'],
            'pemahaman' => ['id' => 'pemahaman', 'pos' => '(n)'],
            'komprehensif' => ['id' => 'komprehensif', 'pos' => '(adj)'],
            'perilaku' => ['id' => 'perilaku', 'pos' => '(n)'],
            'konsumen' => ['id' => 'konsumen', 'pos' => '(n)'],
            'pemasaran' => ['id' => 'pemasaran', 'pos' => '(n)'],
            'keberhasilan' => ['id' => 'keberhasilan', 'pos' => '(n)'],
            'kampanye' => ['id' => 'kampanye', 'pos' => '(n)'],
            'periklanan' => ['id' => 'periklanan', 'pos' => '(n)'],
            'kreativitas' => ['id' => 'kreativitas', 'pos' => '(n)'],
            'penilaian' => ['id' => 'penilaian', 'pos' => '(n)'],
            'kinerja' => ['id' => 'kinerja', 'pos' => '(n)'],
            'evaluasi' => ['id' => 'evaluasi', 'pos' => '(n)'],
            'ketergantungan' => ['id' => 'ketergantungan', 'pos' => '(n)'],
            'energi' => ['id' => 'energi', 'pos' => '(n)'],
            'lingkungan' => ['id' => 'lingkungan', 'pos' => '(n)'],
            'penyesuaian' => ['id' => 'penyesuaian', 'pos' => '(n)'],
            'fluktuasi' => ['id' => 'fluktuasi', 'pos' => '(n)'],
            'kerentanan' => ['id' => 'kerentanan', 'pos' => '(n)'],
            'keamanan' => ['id' => 'keamanan', 'pos' => '(n)'],
            'validitas' => ['id' => 'validitas', 'pos' => '(n)'],
            'argumen' => ['id' => 'argumen', 'pos' => '(n)'],
            'makalah' => ['id' => 'makalah', 'pos' => '(n)'],
            'ketahanan' => ['id' => 'ketahanan', 'pos' => '(n)'],
            'konstruksi' => ['id' => 'konstruksi', 'pos' => '(n)'],
            'partisipasi' => ['id' => 'partisipasi', 'pos' => '(n)'],
            'bakteri' => ['id' => 'bakteri', 'pos' => '(n)'],
            'spesies' => ['id' => 'spesies', 'pos' => '(n)'],
            'pemanasan' => ['id' => 'pemanasan', 'pos' => '(n)'],
            'populasi' => ['id' => 'populasi', 'pos' => '(n)'],
            'pertumbuhan' => ['id' => 'pertumbuhan', 'pos' => '(n)'],
            'glasier' => ['id' => 'glasier', 'pos' => '(n)'],
            'pestisida' => ['id' => 'pestisida', 'pos' => '(n)'],
            'iklim' => ['id' => 'iklim', 'pos' => '(n)'],
            'laboratorium' => ['id' => 'laboratorium', 'pos' => '(n)'],
            'properti' => ['id' => 'properti', 'pos' => '(n)'],
            'mekanisme' => ['id' => 'mekanisme', 'pos' => '(n)'],
            'kepunahan' => ['id' => 'kepunahan', 'pos' => '(n)'],
            'vaksin' => ['id' => 'vaksin', 'pos' => '(n)'],
            'predator' => ['id' => 'predator', 'pos' => '(n)'],
            'hukum' => ['id' => 'hukum', 'pos' => '(n)'],
            'birokrasi' => ['id' => 'birokrasi', 'pos' => '(n)'],
            'keanekaragaman' => ['id' => 'keanekaragaman', 'pos' => '(n)'],
            'lubang' => ['id' => 'lubang hitam', 'pos' => '(n)'],
            'kerugian' => ['id' => 'kerugian', 'pos' => '(n)'],
            'pemimpin' => ['id' => 'pemimpin', 'pos' => '(n)'],
            'proposal' => ['id' => 'proposal', 'pos' => '(n)'],
            'kontrak' => ['id' => 'kontrak', 'pos' => '(n)'],
            'server' => ['id' => 'server', 'pos' => '(n)'],
            'investor' => ['id' => 'investor', 'pos' => '(n)'],
            'restrukturisasi' => ['id' => 'restrukturisasi', 'pos' => '(n)'],
            'inovatif' => ['id' => 'inovatif', 'pos' => '(adj)'],
            'dramatis' => ['id' => 'dramatis', 'pos' => '(adj)'],
            'presisi' => ['id' => 'presisi', 'pos' => '(n)'],
            'analisis' => ['id' => 'analisis', 'pos' => '(n)'],
        ];

        foreach ($words as $w) {
            $wLower = strtolower($w);
            if (isset($dict[$wLower])) {
                $vocab[$wLower] = $dict[$wLower];
            }
        }

        if (empty($vocab)) {
            $vocab = [
                'analisis' => ['id' => 'analisis', 'pos' => '(n)'],
                'struktur' => ['id' => 'struktur', 'pos' => '(n)'],
            ];
        }

        return [
            'example' => $example,
            'vocab' => $vocab,
        ];
    }

}
