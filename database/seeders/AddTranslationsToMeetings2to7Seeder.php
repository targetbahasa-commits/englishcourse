<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingPassage;
use Illuminate\Support\Facades\DB;

class AddTranslationsToMeetings2to7Seeder extends Seeder
{
    public function run()
    {
        $this->command->info('Adding Indonesian translations to Meetings 2-7...');

        // Meeting 2 Translations
        $this->addMeeting2Translations();
        
        // Meeting 3 Translations
        $this->addMeeting3Translations();
        
        // Meeting 4 Translations
        $this->addMeeting4Translations();
        
        // Meeting 5 Translations
        $this->addMeeting5Translations();
        
        // Meeting 6 - Skip (inference questions only, no real passages)
        
        // Meeting 7 Translations
        $this->addMeeting7Translations();

        $this->command->info('All translations added successfully!');
    }

    private function addMeeting2Translations()
    {
        $this->command->info('Adding Meeting 2 translations...');
        
        // Get Meeting 2
        $meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 2)->first();
        if (!$meeting) return;

        $passages = DB::table('toefl_reading_passages')->where('meeting_id', $meeting->id)->get();
        
        foreach ($passages as $passage) {
            $translation = '';
            
            // Passage 1: American Folk Music
            if ($passage->passage_number == 1) {
                $translation = "Musik rakyat Amerika berasal dari orang biasa pada saat ketika populasi pedesaan terisolasi dan musik belum tersebar melalui radio, audio, compact disk, atau DVD musik. Musik ini ditransmisikan melalui tradisi lisan dan terkenal karena energi, humor, dan dampak emosionalnya. Sumber utama lagu rakyat Amerika awal adalah musik dari Kepulauan Inggris, tetapi lagu dari Afrika serta lagu dari orang Indian Amerika juga berkontribusi. Pada abad kesembilan belas, komposer Stephen Foster menulis beberapa lagu yang paling abadi dan populer dari semua lagu Amerika, yang segera menjadi bagian dari tradisi rakyat. Dimulai pada tahun 1930-an, Woody Guthrie mendapat popularitas besar dengan mengadopsi melodi dan gaya tradisional serta menyediakan kata-kata baru yang menangani integrasi rasial dan perang di Vietnam.

Banyak dari lagu-lagu ini berurusan dengan masalah sosial \"urban\" seperti musik rakyat. Banyak dari lagu-lagu ini berurusan dengan pengaruh masalah sosial pada musik rakyat \"urban\".";
            }
            // Passage 2: Helicopter
            else if ($passage->passage_number == 2) {
                $translation = "Helikopter adalah pesawat yang diangkat dan didorong oleh satu atau lebih rotor horizontal. Setiap rotor terdiri dari dua atau lebih bilah rotor yang berputar di sekitar poros. Helikopter dirancang untuk terbang dengan aman jika mesin mati selama penerbangan. Dalam keadaan darurat seperti itu, bilah rotor diputar secara bebas oleh udara yang bergerak ke atas melalui rotor, memberikan cukup daya angkat untuk memperlambat penurunan helikopter.

Helikopter pertama yang berhasil dibangun pada tahun 1940-an, tetapi ide untuk kendaraan seperti itu sebenarnya berusia berabad-abad. Pada awal tahun 1490-an, seniman dan penemu Italia yang hebat Leonardo da Vinci membuat gambar untuk mesin terbang yang sangat mirip dengan helikopter modern.";
            }
            // Passage 3: Sequoia
            else if ($passage->passage_number == 3) {
                $translation = "Sequoia adalah anggota keluarga cemara dan merupakan pohon tertinggi yang hidup di dunia. Sequoia tumbuh di sepanjang pantai Oregon dan California. Pohon tertinggi, yang ditemukan di Taman Nasional Redwood di California utara, mengukur 385 kaki (117 meter). Sequoia dapat hidup lebih dari 2.000 tahun dan memiliki ketahanan yang luar biasa terhadap api dan penyakit. Kulit pohon yang tebal dan kaya tanin melindungi pohon dari api. Pohon yang tumbuh di dekat sungai tumbuh paling cepat, sementara yang tumbuh di lereng yang lebih tinggi dan lebih kering tumbuh lebih lambat. Pohon sequoia dapat bereproduksi dengan tunas yang tumbuh dari akar pohon induk atau dari tunggul pohon yang ditebang, serta dari biji. Biji sequoia sangat kecil, dengan sekitar 3.000 biji per ons, dan mereka tumbuh di kerucut yang matang dalam dua musim.";
            }
            // Passage 4: Gifford Pinchot
            else if ($passage->passage_number == 4) {
                $translation = "Gifford Pinchot adalah ahli kehutanan terlatih profesional pertama di Amerika Serikat. Setelah lulus dari Yale pada tahun 1889, ia belajar kehutanan di Eropa. Pada tahun 1890-an ia mengelola hutan di perkebunan Biltmore di North Carolina (sekarang Hutan Nasional Pisgah) dan menjadi orang pertama yang mempraktikkan kehutanan ilmiah. Mungkin kontribusi terpentingnya untuk konservasi adalah membujuk Presiden Theodore Roosevelt untuk menyisihkan jutaan hektar di Barat sebagai cadangan hutan. Tanah-tanah ini sekarang membentuk sebagian besar taman nasional dan hutan nasional Amerika Serikat. Pinchot menjadi Kepala Kehutanan Layanan Kehutanan AS pada tahun 1905. Meskipun ia memegang posisi itu hanya selama lima tahun, ia menetapkan pedoman yang menetapkan kebijakan hutan selama beberapa dekade mendatang.";
            }
            // Passage 5: Off-Broadway Theater
            else if ($passage->passage_number == 5) {
                $translation = "Teater Off-Broadway berkembang di New York City sekitar tahun 1950 sebagai akibat dari ketidakpuasan dengan kondisi di Broadway. Para pendirinya percaya bahwa Broadway terlalu peduli dengan memproduksi drama hit yang aman dan sukses secara komersial daripada drama dengan kualitas artistik. Produser Off-Broadway mencoba membantu penulis naskah, sutradara, dan pemain yang tidak dapat menemukan pekerjaan di Broadway. Teater Off-Broadway dilengkapi dengan buruk, memiliki tempat duduk terbatas, dan memberikan sedikit kenyamanan untuk penonton. Tetapi orisinalitas drama, kreativitas pemain, dan biaya tiket yang rendah mengimbangi kerugian ini, dan teater Off-Broadway berkembang. Namun, pada tahun 1960-an, biaya mulai naik dan pada tahun 1970-an, teater Off-Broadway menghadapi banyak kesulitan Broadway dan telah kehilangan banyak vitalitasnya. Dengan penurunannya, gerakan eksperimental yang disebut teater off-off-Broadway berkembang.";
            }
            // Passage 6: North American Indian Languages
            else if ($passage->passage_number == 6) {
                $translation = "Pada saat kontak Eropa pertama, ada dari 500 hingga 700 bahasa yang digunakan oleh orang Indian Amerika Utara. Ini dibagi menjadi sekitar 60 keluarga bahasa, tanpa hubungan genetik yang dapat ditunjukkan di antara mereka. Beberapa keluarga ini tersebar di beberapa dari tujuh wilayah budaya. Keluarga Algonquin, misalnya, berisi lusinan bahasa dan menduduki wilayah yang luas. Penutur bahasa Algonquin termasuk Algonquin dari Woodland Timur, Blackfoot dari Plains, dan Wyot dan Yurok dari California. Keluarga bahasa lain, seperti keluarga Zuni dari Southwest, hanya menduduki beberapa mil persegi area dan hanya berisi satu bahasa suku.";
            }
            // Passage 7: Journalism Changes
            else if ($passage->passage_number == 7) {
                $translation = "Perubahan besar lainnya dalam jurnalisme terjadi sekitar waktu ini. Pada tahun 1846, Richard Hoe menemukan mesin cetak silinder rotari uap, memungkinkan untuk mencetak surat kabar lebih cepat dan lebih murah. Pengembangan telegraf memungkinkan pengumpulan dan distribusi berita yang jauh lebih cepat. Juga pada tahun 1846, layanan kawat pertama diorganisir. Jenis surat kabar baru muncul sekitar waktu ini, yang lebih selaras dengan semangat dan kebutuhan Amerika baru. Meskipun surat kabar terus meliput politik, mereka mulai melaporkan lebih banyak cerita minat manusia dan merekam berita terbaru, yang tidak dapat mereka lakukan sebelum telegraf. Surat kabar New York dan kota-kota utara lainnya mempertahankan korps koresponden untuk pergi ke semua bagian negara untuk meliput peristiwa yang layak diberitakan.";
            }
            // Passage 8: Earthquakes in North America
            else if ($passage->passage_number == 8) {
                $translation = "Di sepertiga barat Amerika Utara, lipatan berbelit-belit permukaan Bumi dan struktur geologis yang retak cenderung menyerap energi seismik gempa bumi. Bahkan jika gempa bumi yang mengukur 8,5 pada skala Richter menyerang Los Angeles, kekuatannya akan memudar pada saat mencapai San Francisco, sekitar 400 mil jauhnya. Tetapi di dua pertiga timur benua energi yang sama berjalan lebih mudah. Gempa bumi yang menyerang New Madrid, Missouri, pada tahun 1811, diperkirakan 8 pada skala Richter, mengguncang Washington, D.C., sekitar 800 mil jauhnya, dan dirasakan sejauh Boston dan Toronto.";
            }
            // Passage 9: Children's Curiosity
            else if ($passage->passage_number == 9) {
                $translation = "Tidak pernah ada ilmuwan dewasa yang setengah penasaran seperti anak mana pun antara usia empat bulan dan empat tahun. Orang dewasa kadang-kadang salah mengartikan rasa ingin tahu yang luar biasa tentang segala sesuatu ini sebagai kurangnya kemampuan untuk berkonsentrasi. Kenyataannya adalah bahwa anak-anak mulai belajar sejak lahir, dan pada saat mereka mulai sekolah formal pada usia lima atau enam tahun, mereka telah menyerap sejumlah informasi yang fantastis, mungkin lebih banyak, fakta demi fakta, daripada yang akan mereka pelajari selama sisa hidup mereka. Orang dewasa dapat melipatgandakan berkali-kali pengetahuan yang diserap anak-anak jika mereka menghargai rasa ingin tahu ini sambil secara bersamaan mendorong anak-anak untuk belajar.";
            }
            // Passage 10: Settlement Houses
            else if ($passage->passage_number == 10) {
                $translation = "Rumah pemukiman adalah lembaga yang didirikan untuk meningkatkan kondisi hidup di lingkungan kota miskin pada akhir tahun 1800-an dan awal 1900-an. Mereka menawarkan kegiatan kesehatan, pendidikan, rekreasi, dan budaya. Yang pertama dibuka di Amerika Serikat adalah University Settlement di New York City. Ini didirikan oleh reformis sosial Stanton Coit pada tahun 1886. Contoh yang paling terkenal adalah Hull House, didirikan oleh reformis terkenal Jane Addams di Chicago pada tahun 1890. Rumah pemukiman biasanya dikelola oleh lulusan perguruan tinggi muda yang idealis yang ingin meningkatkan kondisi orang miskin.";
            }
            // Passage 11: Isadora Duncan
            else if ($passage->passage_number == 11) {
                $translation = "Penari Isadora Duncan adalah inovator yang berani dan dinamis dalam tari. Meskipun ia tidak sangat berhasil dalam mengajarkan gaya tari yang sangat pribadi kepada orang lain, ia mengajarkan generasi penari untuk mempercayai bentuk ekspresi mereka sendiri. Ia memberontak terhadap gaya balet klasik yang kaku dan formal. Terinspirasi oleh seni Yunani, ia biasanya menari dengan kaki telanjang dalam tunik Yunani yang longgar dan mengalir. Ia menemukan inspirasi lebih lanjut di alam dan menggunakan gerakan tari untuk mencerminkan ombak laut dan awan yang lewat. Isadora Duncan lahir di San Francisco pada tahun 1878. Ia memberikan penampilan pertamanya pada tahun 1899. Kegagalan awal memberi jalan kepada penampilan yang menang di Budapest, Berlin, London, dan akhirnya, pada tahun 1908, kembali di Amerika Serikat. Ia tinggal di Eropa sebagian besar hidupnya, mendirikan sekolah tari untuk anak-anak di sana. Ia meninggal pada tahun 1927 dekat Nice, Prancis, dalam kecelakaan aneh, syal panjangnya tersangkut di roda mobil sport terbuka yang ia tumpangi.";
            }
            // Passage 12: Medieval Alchemists (if exists)
            else if ($passage->passage_number == 12) {
                $translation = "Melalui berabad-abad, impian alkemis abad pertengahan adalah menemukan cara mengubah timbal dan logam \"dasar\" lainnya menjadi emas. Beberapa adalah penipu, tetapi banyak adalah orang terpelajar dengan tujuan filosofis. Pencarian mereka didasarkan pada ide kuno bahwa semua materi terdiri dari proporsi yang berbeda dari hanya empat zat - tanah, air, api, dan udara. Mereka percaya bahwa mungkin untuk menyesuaikan proporsi elemen yang membentuk timbal dengan cara kimia sehingga berubah menjadi emas, proses yang disebut transmutasi. Eksperimen mereka berkaitan dengan menemukan zat - yang mereka sebut batu filsuf - yang, ketika ditambahkan ke timbal, akan menyebabkan perubahan mengejutkan ini terjadi. Alkemis juga mencari ramuan kehidupan, zat yang dapat menyembuhkan penyakit dan memperpanjang hidup. Mereka gagal di kedua hal. Namun, teknik mereka untuk menyiapkan dan mempelajari bahan kimia membantu meletakkan dasar untuk ilmu kimia modern.";
            }
            
            if ($translation) {
                DB::table('toefl_reading_passages')
                    ->where('id', $passage->id)
                    ->update(['indonesian_translation' => $translation]);
            }
        }
    }

    private function addMeeting3Translations()
    {
        $this->command->info('Adding Meeting 3 translations...');
        
        $meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 3)->first();
        if (!$meeting) return;

        $passages = DB::table('toefl_reading_passages')->where('meeting_id', $meeting->id)->get();
        
        foreach ($passages as $passage) {
            $translation = '';
            
            // Passage 1: Nitrogen Fixation
            if ($passage->passage_number == 1) {
                $translation = "Fiksasi nitrogen adalah proses alami di mana nitrogen dari atmosfer diubah menjadi senyawa nitrogen yang dapat digunakan oleh tanaman. Nitrogen, yang membentuk sekitar 78 persen atmosfer, sangat penting untuk kehidupan. Namun, sebagian besar organisme tidak dapat menggunakan nitrogen atmosfer secara langsung. Fiksasi nitrogen terutama dilakukan oleh bakteri tertentu yang hidup di tanah atau di akar tanaman legum seperti kacang polong dan kacang-kacangan. Bakteri ini mengubah nitrogen atmosfer menjadi amonia, yang kemudian dapat digunakan oleh tanaman untuk membuat protein dan asam nukleat.";
            }
            // Passage 2: Fossils
            else if ($passage->passage_number == 2) {
                $translation = "Fosil adalah sisa-sisa atau jejak organisme yang hidup di masa lalu yang telah diawetkan di batuan sedimen. Fosil dapat berupa tulang, gigi, cangkang, atau bahkan jejak kaki. Proses pembentukan fosil, yang disebut fosilisasi, biasanya memerlukan kondisi khusus. Organisme harus dikubur dengan cepat setelah kematian untuk melindunginya dari pembusukan dan pemulung. Seiring waktu, mineral dari air tanah meresap ke dalam sisa-sisa organisme, menggantinya dengan batu. Fosil memberikan bukti penting tentang kehidupan di masa lalu dan membantu ilmuwan memahami evolusi dan sejarah Bumi.";
            }
            // Passage 3: Uranium Dating
            else if ($passage->passage_number == 3) {
                $translation = "Penanggalan uranium adalah metode yang digunakan untuk menentukan usia batuan dan mineral dengan mengukur peluruhan radioaktif uranium. Uranium adalah unsur radioaktif yang meluruh menjadi timbal pada tingkat yang dapat diprediksi. Dengan mengukur rasio uranium terhadap timbal dalam sampel batuan, ilmuwan dapat menghitung berapa lama uranium telah meluruh, dan dengan demikian menentukan usia batuan. Metode ini sangat berguna untuk menentukan usia batuan yang sangat tua, termasuk beberapa batuan tertua di Bumi yang berusia lebih dari 4 miliar tahun.";
            }
            
            if ($translation) {
                DB::table('toefl_reading_passages')
                    ->where('id', $passage->id)
                    ->update(['indonesian_translation' => $translation]);
            }
        }
    }

    private function addMeeting4Translations()
    {
        $this->command->info('Adding Meeting 4 translations...');
        
        $meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 4)->first();
        if (!$meeting) return;

        $passages = DB::table('toefl_reading_passages')->where('meeting_id', $meeting->id)->get();
        
        foreach ($passages as $passage) {
            $translation = '';
            
            // Passage 1: Geysers
            if ($passage->passage_number == 1) {
                $translation = "Geyser adalah mata air panas yang secara berkala menyemburkan air dan uap ke udara. Geyser terbentuk ketika air tanah dipanaskan oleh magma di bawah permukaan Bumi. Air yang dipanaskan naik melalui celah-celah di batuan dan menumpuk di ruang bawah tanah. Ketika tekanan menjadi terlalu besar, air dan uap disemburkan ke permukaan dalam letusan yang spektakuler. Geyser paling terkenal di dunia adalah Old Faithful di Taman Nasional Yellowstone, yang meletus secara teratur setiap 60 hingga 90 menit.";
            }
            // Passage 2: Icebergs
            else if ($passage->passage_number == 2) {
                $translation = "Gunung es adalah massa besar es yang mengapung di laut. Mereka terbentuk ketika gletser mencapai laut dan potongan besar es terlepas dan jatuh ke air. Sebagian besar gunung es berasal dari Greenland dan Antartika. Hanya sekitar 10 persen dari gunung es yang terlihat di atas permukaan air; 90 persen sisanya tersembunyi di bawah air. Ini membuat gunung es sangat berbahaya bagi kapal. Gunung es yang terkenal menenggelamkan kapal Titanic pada tahun 1912, menewaskan lebih dari 1.500 orang.";
            }
            // Passage 3: Phosphorus
            else if ($passage->passage_number == 3) {
                $translation = "Fosfor adalah unsur kimia yang sangat penting untuk kehidupan. Ini adalah komponen kunci dari DNA, RNA, dan ATP, molekul yang menyimpan dan mentransfer energi dalam sel. Fosfor juga merupakan komponen utama tulang dan gigi. Dalam alam, fosfor ditemukan terutama dalam batuan dan mineral. Tanaman menyerap fosfor dari tanah, dan hewan mendapatkan fosfor dengan memakan tanaman atau hewan lain. Fosfor juga digunakan dalam pupuk untuk membantu tanaman tumbuh lebih baik.";
            }
            
            if ($translation) {
                DB::table('toefl_reading_passages')
                    ->where('id', $passage->id)
                    ->update(['indonesian_translation' => $translation]);
            }
        }
    }

    private function addMeeting5Translations()
    {
        $this->command->info('Adding Meeting 5 translations...');
        
        $meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 5)->first();
        if (!$meeting) return;

        $passages = DB::table('toefl_reading_passages')->where('meeting_id', $meeting->id)->get();
        
        foreach ($passages as $passage) {
            $translation = '';
            
            // Passage 1: Mesa Verde
            if ($passage->passage_number == 1) {
                $translation = "Mesa Verde, yang terletak di barat daya Colorado, adalah rumah bagi reruntuhan pemukiman tebing yang dibangun oleh orang Anasazi, sebuah suku Indian Amerika. Orang Anasazi tinggal di daerah tersebut dari sekitar 550 M hingga 1300 M. Mereka awalnya tinggal di atas mesa dalam rumah-rumah yang dibangun dari lumpur dan batu. Sekitar tahun 1150, mereka mulai membangun rumah yang rumit di ceruk-ceruk batu di sisi tebing. Beberapa pemukiman tebing ini memiliki lebih dari 200 kamar. Sekitar tahun 1300, orang Anasazi meninggalkan Mesa Verde, kemungkinan karena kekeringan yang parah.";
            }
            // Passage 2: Dulcimers
            else if ($passage->passage_number == 2) {
                $translation = "Dulcimer adalah alat musik petik yang memiliki senar yang dipetik atau dipukul. Ada dua jenis utama dulcimer: dulcimer gunung dan dulcimer palu. Dulcimer gunung, yang populer di Appalachia, dimainkan dengan memetik senar dengan jari atau plektrum. Dulcimer palu, yang berasal dari Timur Tengah, dimainkan dengan memukul senar dengan palu kecil. Kedua jenis dulcimer menghasilkan suara yang lembut dan merdu yang sering digunakan dalam musik rakyat.";
            }
            // Passage 3: Dorothea Dix
            else if ($passage->passage_number == 3) {
                $translation = "Dorothea Dix adalah reformis sosial Amerika yang berjuang untuk meningkatkan kondisi bagi orang-orang dengan penyakit mental. Pada awal abad ke-19, orang dengan penyakit mental sering diperlakukan dengan buruk dan dikurung di penjara atau rumah miskin. Dix melakukan perjalanan ke seluruh Amerika Serikat, mendokumentasikan kondisi mengerikan di mana orang-orang ini hidup. Upayanya mengarah pada pembentukan rumah sakit jiwa pertama di Amerika Serikat dan peningkatan signifikan dalam perawatan orang dengan penyakit mental.";
            }
            // Passage 4: Quilts
            else if ($passage->passage_number == 4) {
                $translation = "Selimut adalah penutup tempat tidur yang terbuat dari dua lapisan kain dengan lapisan pengisi di antaranya, semuanya dijahit bersama dalam pola dekoratif. Pembuatan selimut telah menjadi tradisi Amerika sejak zaman kolonial. Selimut awalnya dibuat untuk kehangatan, tetapi mereka juga menjadi bentuk seni. Wanita sering berkumpul untuk \"quilting bees,\" di mana mereka akan bekerja bersama untuk membuat selimut sambil bersosialisasi. Banyak selimut antik sekarang dianggap sebagai karya seni yang berharga dan dipamerkan di museum.";
            }
            // Passage 5: Ambient Divers
            else if ($passage->passage_number == 5) {
                $translation = "Penyelam ambient adalah penyelam yang bernapas udara pada tekanan yang sama dengan tekanan air di sekitarnya. Ini berbeda dengan penyelam yang menggunakan peralatan pernapasan khusus yang mempertahankan tekanan konstan. Penyelam ambient harus berhati-hati untuk naik perlahan ke permukaan untuk menghindari penyakit dekompresi, yang terjadi ketika nitrogen yang terlarut dalam darah membentuk gelembung saat tekanan berkurang terlalu cepat. Penyelaman ambient memungkinkan penyelam untuk tinggal di bawah air untuk waktu yang lebih lama daripada dengan peralatan pernapasan tradisional.";
            }
            
            if ($translation) {
                DB::table('toefl_reading_passages')
                    ->where('id', $passage->id)
                    ->update(['indonesian_translation' => $translation]);
            }
        }
    }

    private function addMeeting7Translations()
    {
        $this->command->info('Adding Meeting 7 translations...');
        
        $meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 7)->first();
        if (!$meeting) return;

        $passages = DB::table('toefl_reading_passages')->where('meeting_id', $meeting->id)->get();
        
        foreach ($passages as $passage) {
            $translation = '';
            
            // Passage 1: Neon Lights
            if ($passage->passage_number == 1) {
                $translation = "Istilah \"lampu neon\" awalnya diterapkan pada jenis lampu uap tertentu yang menggunakan gas mulia neon. Tabung panjang diisi dengan neon, yang kemudian menjadi bercahaya pada tekanan rendah ketika arus listrik dilewatkan melaluinya. Lampu kemudian memancarkan cahaya merah-oranye khas neon. Saat ini, istilah \"lampu neon\" diberikan pada lampu jenis umum ini yang dapat diisi dengan berbagai gas, tergantung pada warna yang diinginkan. Argon, misalnya, digunakan untuk menghasilkan cahaya biru. Warna juga dapat diubah dengan mengubah warna tabung kaca. Tabung harus cukup panjang di semua lampu ini untuk menghasilkan cahaya secara efisien. Akibatnya, tegangan tinggi diperlukan. Lampu tabung neon tidak praktis untuk penerangan dalam ruangan, tetapi mereka telah menemukan penggunaan luar ruangan yang luas dalam tanda iklan yang bercahaya dan berwarna-warni.";
            }
            // Passage 2: Synthetic Flavors
            else if ($passage->passage_number == 2) {
                $translation = "Perasa dan pewangi alami seringkali mahal dan terbatas pasokannya. Misalnya, bahan vital dalam pewangi mawar diekstraksi dari minyak mawar alami dengan biaya ribuan dolar per pon; zat sintetis yang identik dapat dibuat dengan biaya 1% dari biaya ini. Sejak awal abad kedua puluh, keberhasilan dalam mereproduksi zat-zat ini telah menciptakan industri baru yang saat ini menghasilkan ratusan perasa dan pewangi buatan.

Beberapa pewangi alami mudah disintesis; ini termasuk vanilin, bahan aromatik dalam vanila, dan benzaldehida, bahan aromatik dalam ceri liar. Pewangi lain, bagaimanapun, memiliki puluhan, bahkan ratusan komponen. Baru-baru ini dimungkinkan untuk memisahkan dan mengidentifikasi bahan-bahan ini dengan menggunakan kromatografi gas dan spektroskopi. Setelah identitas kimia diketahui, seringkali mungkin untuk mensintesisnya. Namun demikian, beberapa zat kompleks, seperti aroma kopi segar, masih belum berhasil diduplikasi dengan memuaskan.

Banyak senyawa kimia yang membentuk sintetik ini identik dengan yang ditemukan di alam, dan sama tidak berbahaya atau berbahaya seperti zat alami. Produk baru harus diuji keamanannya dan ketika digunakan dalam makanan, harus disetujui oleh Administrasi Makanan dan Obat AS.

Ketersediaan perasa dan pewangi sintetis telah memungkinkan berbagai macam produk, dari minuman murah hingga sabun beraroma hingga mobil bekas dengan \"bau mobil baru\" yang diterapkan.";
            }
            // Passage 3: Legends
            else if ($passage->passage_number == 3) {
                $translation = "Legenda adalah jenis cerita rakyat yang populer. Dalam beberapa hal, legenda menyerupai mitos, jenis cerita rakyat lainnya. Tetapi mitos menggambarkan peristiwa dari zaman kuno dan biasanya berurusan dengan subjek keagamaan, seperti kelahiran dewa. Legenda menceritakan tentang orang, tempat, dan peristiwa yang dapat dikenali dan sering terjadi di masa yang relatif baru. Beberapa legenda didasarkan pada orang atau peristiwa nyata, tetapi banyak yang sepenuhnya fiksi. Legenda tentang pencapaian superhuman Paul Bunyan dan Pecos Bill adalah imajiner, sementara legenda tentang Washington dan Lincoln sebagian besar adalah berlebihan dari kualitas nyata yang dimiliki kedua presiden tersebut.

Semua masyarakat memiliki legenda. Sebagian besar legenda dimulai sebagai cerita tentang pahlawan dari wilayah, pekerjaan, atau kelompok etnis tertentu. Misalnya, John Henry adalah pahlawan legendaris orang Afrika-Amerika, dan Casey Jones dari pekerja kereta api. Namun seiring waktu, tokoh-tokoh ini telah menjadi pahlawan nasional.";
            }
            // Passage 4: Tumbleweeds
            else if ($passage->passage_number == 4) {
                $translation = "Pada tahun 1881, jenis gulma baru mulai menyebar di seluruh Great Plains utara. Tidak seperti gulma lainnya, tumbleweed tidak menghabiskan hidupnya berakar di tanah; sebaliknya ia jatuh dan berguling melintasi ladang tertiup angin. Gulma ini memiliki daun tajam dan berduri yang dapat melukai daging peternak dan kuda. Ia mengeksploitasi area luas dataran, berkembang di daerah yang terlalu tandus untuk mendukung tanaman lain. Dengan kemampuannya untuk menghasilkan dan menyebarkan banyak biji dengan cepat, ia segera menjadi momok padang rumput.

Bagi orang Amerika masa kini, tumbleweed melambangkan Wild West Lama. Mereka membaca novel Zane Grey di mana tumbleweed melayang melintasi lanskap barat yang keras dan melihat film barat klasik di mana tumbleweed berguling melewati adegan dengan koboi dan kereta tertutup. Namun hanya lebih dari satu abad yang lalu, tumbleweed adalah pendatang baru. Tanda pertama invasi terjadi di North dan South Dakota pada akhir tahun 1870-an.

Petani telah memperhatikan munculnya tiba-tiba tanaman baru yang tidak biasa. Namun, satu kelompok imigran tidak menemukan gulma itu asing sama sekali. Tumbleweed, ternyata, adalah asli Rusia selatan, di mana ia dikenal sebagai Tartar thistle. Ia diimpor ke Amerika Serikat oleh petani yang tidak tahu.

Pemukim perbatasan memberi tanaman berbagai nama: saltwort, kaktus Rusia, dan penyihir angin. Tetapi ahli botani di Departemen Pertanian lebih memilih sebutan Russian thistle sebagai nama umum tanaman. Namun, ahli botani ini memiliki waktu yang jauh lebih sulit untuk menyetujui nama ilmiah tanaman. Umumnya, ahli botani membandingkan tanaman dengan catatan yang diterbitkan tentang tanaman serupa, atau dengan sampel yang disimpan sebagai spesimen. Sayangnya, tidak ada buku yang menggambarkan gulma, dan tidak ada sampel yang ada di herbaria di Amerika Serikat.";
            }
            // Passage 5-6: (might be missing or error in seeder)
            // Passage 7: Airport Design
            else if ($passage->passage_number == 7) {
                $translation = "Untuk sebagian besar bandara modern, masalah desain utama adalah skala bagaimana memungkinkan ruang yang memadai di tanah untuk manuver jet berbadan lebar sambil memungkinkan pergerakan penumpang yang nyaman dan cepat yang berangkat, tiba, atau transfer dari satu penerbangan ke penerbangan lain.

Sebagian besar desain untuk terminal bandara mengambil salah satu dari empat pendekatan. Dalam rencana linier, bangunan mungkin lurus atau melengkung. Penumpang naik pesawat yang diparkir di sebelah terminal. Rencana ini bekerja dengan baik untuk bandara kecil yang perlu menyediakan area boarding hanya untuk beberapa pesawat pada satu waktu.

Dalam rencana dermaga, koridor sempit atau dermaga memanjang dari bangunan pusat. Rencana ini memungkinkan banyak pesawat untuk parkir di sebelah bangunan. Namun, ini menciptakan jarak berjalan yang panjang untuk penumpang.

Dalam rencana satelit, penumpang naik pesawat dari terminal kecil yang terpisah dari terminal utama. Penumpang mencapai satelit melalui kereta antar-jemput atau lorong bawah tanah yang memiliki kereta antar-jemput atau trotoar bergerak.

Rencana transporter menggunakan beberapa sistem transportasi untuk memindahkan penumpang dari bangunan terminal ke pesawat. Jika bus digunakan, penumpang harus menaiki tangga untuk naik pesawat. Jika lounge mobile digunakan, mereka dapat terhubung langsung dengan pesawat dan melindungi penumpang dari cuaca.";
            }
            // Passage 8: Beach Erosion and Seawalls
            else if ($passage->passage_number == 8) {
                $translation = "Laut telah naik relatif terhadap daratan setidaknya selama 100 tahun, kata ahli geologi. Selama periode yang sama, Pantai Atlantik telah terkikis rata-rata 2 hingga 3 kaki per tahun, Pantai Teluk bahkan lebih cepat. Banyak insinyur mempertahankan bahwa tembok laut dan pantai yang diisi ulang diperlukan untuk melindungi garis pantai negara. Terlalu banyak orang tinggal atau berlibur di Miami Beach, Atlantic City, atau Martha's Vineyard untuk membiarkan jalan dan bangunan mereka jatuh ke laut.

Masalah dengan tembok laut adalah bahwa mereka tidak bekerja. Satu studi telah menunjukkan bahwa, pada kenyataannya, tembok laut mempercepat erosi pantai.

Menghadapi kehilangan pantai mereka, komunitas lain telah mencoba solusi sederhana tetapi mahal: ganti pasir yang hilang. Program pengisian ulang ini, bagaimanapun, mahal dan nilai yang meragukan. Studi lain telah menunjukkan bahwa hanya 10% dari pantai yang diisi ulang bertahan lebih dari 5 tahun.";
            }
            
            if ($translation) {
                DB::table('toefl_reading_passages')
                    ->where('id', $passage->id)
                    ->update(['indonesian_translation' => $translation]);
            }
        }
    }
}
