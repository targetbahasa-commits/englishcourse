<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddTranslationsToMeeting1Seeder extends Seeder
{
    public function run()
    {
        $this->command->info('Adding Indonesian translations to Meeting 1...');
        
        $meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 1)->first();
        if (!$meeting) {
            $this->command->error('Meeting 1 not found!');
            return;
        }

        $passages = DB::table('toefl_reading_passages')
            ->where('meeting_id', $meeting->id)
            ->orderBy('passage_number')
            ->get();
        
        $translations = [
            1 => "Ada dua jenis utama pembelahan sel. Sebagian besar sel diproduksi melalui proses yang disebut mitosis. Dalam mitosis, sel membelah dan membentuk dua sel anak yang identik, masing-masing dengan jumlah kromosom yang identik. Sebagian besar makhluk bersel satu bereproduksi dengan metode ini, begitu juga sebagian besar sel pada tumbuhan dan hewan bersel banyak. Namun, sel kelamin dibentuk dalam jenis pembelahan sel khusus yang disebut meiosis. Proses ini mengurangi jumlah kromosom dalam sel kelamin menjadi setengah dari jumlah yang ditemukan dalam jenis sel lainnya. Kemudian, ketika sel kelamin bersatu, mereka menghasilkan sel tunggal dengan jumlah kromosom asli.",
            
            2 => "Demam emas terakhir adalah bagian dari sejarah Kanada sama seperti sejarah Amerika. Penemuan emas di sepanjang Sungai Klondike, yang mengalir dari Wilayah Yukon Kanada ke Alaska, menarik sekitar 30.000 pemburu keberuntungan ke utara. Yukon menjadi wilayah, dan ibu kotanya saat itu, Dawson, tidak akan ada tanpa demam emas. Penemuan emas ini memberikan bahan untuk selusin novel Jack London. Ini menginspirasi Robert Service untuk menulis \"The Shooting of Dan McGrew\" dan puisi lainnya, dan memberikan latar belakang untuk film Charlie Chaplin yang luar biasa, The Gold Rush. Ini juga menandai awal dari Alaska modern.",
            
            3 => "Lengkungan batu kunci digunakan oleh hampir setiap peradaban awal. Untuk membangun lengkungan batu kunci, batu dipotong sehingga sisi yang berlawanan meruncing satu sama lain sedikit. Permukaan atas dan bawah diukir sehingga ketika beberapa batu ditempatkan berdampingan, permukaan atas dan bawah bertemu dalam kurva halus dan kontinu. Beberapa bentuk perancah dibangun di bawah lengkungan dan dibentuk untuk menerima bagian bawah batu yang melengkung. Kemudian batu dipasang satu per satu. Batu kunci adalah batu tengah atas, yang terakhir dijatuhkan ke posisinya. Setelah itu, perancah dilepas dan lengkungan dapat menopang dirinya sendiri.",
            
            4 => "Bukti tidak langsung adalah bukti yang tidak diambil dari pengamatan langsung terhadap suatu fakta. Jika, misalnya, ada bukti bahwa sepotong batu yang tertanam dalam cokelat batangan yang dibungkus adalah jenis batu yang sama yang ditemukan di sekitar pabrik permen, dan bahwa batu jenis ini ditemukan di beberapa tempat lain, maka ada bukti tidak langsung bahwa batu tersebut masuk ke dalam permen selama pembuatan dan menunjukkan bahwa pembuat permen lalai. Terlepas dari anggapan populer untuk meremehkan kualitas bukti tidak langsung, ini sangat berguna jika ada cukup banyak dan jika ditafsirkan dengan benar. Setiap keadaan, diambil secara terpisah, mungkin berarti sedikit, tetapi seluruh rangkaian keadaan dapat sama konklusifnya dengan bukti langsung.",
            
            5 => "Ordonansi Barat Laut disahkan oleh Kongres pada tahun 1787. Ini menetapkan struktur pemerintahan wilayah di utara Sungai Ohio dan barat Pennsylvania, yang kemudian disebut Wilayah Barat Laut. Ini menetapkan kondisi di mana bagian-bagian dari Wilayah dapat menjadi negara bagian yang memiliki kesetaraan dengan negara bagian yang lebih tua. Tetapi ordonansi itu lebih dari sekadar rencana untuk pemerintahan. Undang-undang ini juga menjamin kebebasan beragama dan pengadilan oleh juri di Wilayah. Ini mengatur Wilayah menjadi township seluas 36 mil persegi dan memerintahkan sekolah dibangun untuk setiap township. Ini juga menghapuskan perbudakan di Wilayah. Persyaratannya sangat menarik sehingga ribuan perintis berbondong-bondong ke Wilayah. Akhirnya, Wilayah menjadi negara bagian Ohio, Indiana, Illinois, Michigan, dan Wisconsin.",
            
            6 => "Kisah bisnis motel dari tahun 1920 hingga dimulainya Perang Dunia II pada tahun 1941 adalah kisah pertumbuhan yang tidak terputus. Motel menyebar dari Barat dan Midwest hingga ke Maine dan Florida. Mereka berkumpul di sepanjang jalan raya lintas benua seperti rute AS 40 dan 66 dan di sepanjang rute utara-selatan yang naik turun di pantai Timur dan Barat. Ada 16.000 motel pada tahun 1930 dan 24.000 pada tahun 1940. Industri motel adalah salah satu dari sedikit industri yang tidak dirugikan oleh Depresi tahun 1930-an. Tarif murah mereka menarik wisatawan yang memiliki sangat sedikit uang.",
            
            7 => "Sebuah pepatah lama menyatakan, \"Hati-hati dengan pohon ek, ia menarik petir.\" Ucapan ini berguna selama musim badai petir. Secara umum, pohon dengan akar dalam yang menembus air tanah menarik lebih banyak petir daripada pohon dengan akar dangkal dan kering. Pohon ek sekitar 50 kali lebih mungkin disambar petir daripada pohon beech. Pohon cemara hampir sama amannya dengan pohon beech. Pohon pinus tidak seaman kedua pohon ini, tetapi masih jauh lebih aman daripada pohon ek.",
            
            8 => "Sejarah alternatif umumnya diklasifikasikan sebagai jenis fiksi ilmiah, tetapi juga memiliki hubungan dengan fiksi sejarah. Jenis penulisan ini menggambarkan dunia imajiner yang identik dengan dunia kita hingga titik tertentu dalam sejarah, tetapi pada titik itu, kedua dunia berbeda; beberapa peristiwa sejarah penting terjadi di satu dunia tetapi tidak di dunia lain, dan mereka pergi ke arah yang berbeda. Sejarah alternatif mungkin menggambarkan dunia di mana Kekaisaran Romawi tidak pernah jatuh, di mana Armada Spanyol menang, atau di mana Selatan memenangkan Perang Saudara. Atau mereka mungkin mengandaikan bahwa beberapa teknologi telah diperkenalkan lebih awal dalam sejarah dunia daripada yang sebenarnya terjadi. Misalnya: Bagaimana jika komputer ditemukan pada zaman Victoria? Banyak pembaca menemukan cerita-cerita ini menarik karena cara mereka merangsang imajinasi dan membuat mereka berpikir tentang fenomena sebab dan akibat dalam sejarah.",
            
            9 => "Sampai akhir tahun 1700-an, logam tidak dapat diputar pada mesin bubut untuk membuatnya halus dan bulat secara seragam. Operator tidak dapat memandu alat pemotong secara merata dengan tangan terhadap potongan yang berputar. Masalah ini dipecahkan oleh David Wilkinson dari Pawtucket, Rhode Island. Pada tahun 1798 ia menemukan mesin di mana pemotong dijepit ke dalam slide yang dapat dipindahkan yang dapat dimajukan dengan tepat, dengan engkol tangan, sejajar dengan pekerjaan. Slide rest, seperti yang kemudian disebut, memiliki banyak kegunaan. Ini memungkinkan pembuatan bagian yang begitu seragam sehingga dapat dipertukarkan. Tanpa itu, produksi massal tidak akan mungkin terjadi. Ternyata, ahli mesin Inggris yang hebat Henry Maudsley telah mengembangkan mekanisme yang hampir sama beberapa tahun sebelumnya, tetapi ini tidak diketahui oleh Wilkinson dan tidak mengurangi pencapaiannya.",
            
            10 => "Hampir setiap bentuk transportasi telah memberi seseorang ide untuk jenis mainan baru. Setelah saudara Montgolfier menerbangkan balon pertama, balon mainan menjadi mainan populer. Pada abad kesembilan belas, segera setelah kereta api dan kapal uap dikembangkan, setiap anak harus memiliki model kereta api dan kapal uap. Hal yang sama berlaku untuk mobil dan pesawat terbang di awal abad kedua puluh. Roket dan rudal mainan menjadi populer pada awal era luar angkasa, dan pada tahun 1980-an, ada banyak versi berbeda dari mainan pesawat ulang-alik.",
        ];

        foreach ($passages as $passage) {
            if (isset($translations[$passage->passage_number])) {
                DB::table('toefl_reading_passages')
                    ->where('id', $passage->id)
                    ->update(['indonesian_translation' => $translations[$passage->passage_number]]);
                
                $this->command->info("Added translation for Passage {$passage->passage_number}");
            }
        }

        $this->command->info('Meeting 1 translations added successfully!');
    }
}
