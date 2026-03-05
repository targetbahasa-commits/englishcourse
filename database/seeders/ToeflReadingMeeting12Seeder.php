<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting12Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 12
        $meeting = ToeflReadingMeeting::where('meeting_number', 12)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 12,
                'title' => 'Reference Questions 2',
                'is_locked' => false
            ]);
        }

        // Passage 1: Mining (Questions 1-6)
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "In addition to these various types of deep mining, several types of surface mining may be used when minerals lie relatively close to the surface of the Earth. One type is open-pit mining. The first step is to remove the overburden, the layers of rock and earth lying above the ore, with giant scrapers. The ore is broken up in a series of blasting operations. Power shovels pick up the pieces and load <u>them</u> into trucks or, in some cases, ore trains. <u>These</u> carry it up ramps to ground level. Soft ores are removed by drilling screws, called augers.

Another type is called \"placer\" mining. Sometimes heavy metals such as gold are found in soil deposited by streams and rivers. The soil is picked up by a power shovel and transferred to a long trough. Water is run through the soil in the trough. <u>This</u> carries soil particles away with it. The metal particles are heavier than the soil and sink to the bottom, where they can be recovered.

The finishing-off process of mining is called mineral concentration. In this process, the desired substances are removed from the waste in various ways. One technique is to bubble air through a liquid in which ore particles are suspended. Chemicals are added that make the minerals cling to the air bubbles. The bubbles rise to the surface with the mineral particles attached, and <u>they</u> can be skimmed off and saved.",
            'indonesian_translation' => "Selain berbagai jenis pertambangan dalam, beberapa jenis pertambangan permukaan dapat digunakan ketika mineral terletak relatif dekat dengan permukaan Bumi. Satu jenis adalah pertambangan terbuka. Langkah pertama adalah menghilangkan overburden, lapisan batuan dan tanah yang terletak di atas bijih, dengan pengikis raksasa. Bijih dipecah dalam serangkaian operasi peledakan. Sekop listrik mengambil potongan-potongan dan memuatnya ke dalam truk atau, dalam beberapa kasus, kereta bijih. Ini membawanya naik tanjakan ke permukaan tanah. Bijih lunak dihilangkan dengan bor pengeboran, yang disebut auger.

Jenis lain disebut pertambangan \"placer\". Kadang-kadang logam berat seperti emas ditemukan di tanah yang diendapkan oleh sungai dan aliran. Tanah diambil oleh sekop listrik dan dipindahkan ke palung panjang. Air dijalankan melalui tanah di palung. Ini membawa partikel tanah pergi dengannya. Partikel logam lebih berat daripada tanah dan tenggelam ke dasar, di mana mereka dapat dipulihkan.

Proses finishing pertambangan disebut konsentrasi mineral. Dalam proses ini, zat yang diinginkan dihilangkan dari limbah dengan berbagai cara. Satu teknik adalah menggelembungkan udara melalui cairan di mana partikel bijih tersuspensi. Bahan kimia ditambahkan yang membuat mineral menempel pada gelembung udara. Gelembung naik ke permukaan dengan partikel mineral yang melekat, dan mereka dapat diambil dan disimpan."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'The word "them" in line 5 refers to',
            'option_a' => 'power shovels',
            'option_b' => 'layers of rock and earth',
            'option_c' => 'giant scrapers',
            'option_d' => 'pieces of ore',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 2,
            'question_text' => 'To which of the following does the word "These" in line 6 refer?',
            'option_a' => 'Ramps',
            'option_b' => 'Trucks or ore trains',
            'option_c' => 'Augers',
            'option_d' => 'Blasting operations',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 3,
            'question_text' => 'The phrase "Another type" in line 8 is a reference to another type of',
            'option_a' => 'deep mining',
            'option_b' => 'ore',
            'option_c' => 'metal',
            'option_d' => 'surface mining',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 4,
            'question_text' => 'The word "This" in line 10 refers to',
            'option_a' => 'a power shovel',
            'option_b' => 'gold',
            'option_c' => 'running water',
            'option_d' => 'a long trough',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 5,
            'question_text' => 'In line 17, the phrase "this process" refers to',
            'option_a' => 'surface mining',
            'option_b' => 'the depositing of soil',
            'option_c' => 'mineral concentration',
            'option_d' => 'placer mining',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 6,
            'question_text' => 'The word "they" in line 17 refers to',
            'option_a' => 'the processes',
            'option_b' => 'the air bubbles',
            'option_c' => 'the chemicals',
            'option_d' => 'the minerals',
            'correct_answer' => 'D'
        ]);

        // Passage 2: Mount Rainier (Questions 7-10)
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "Mount Rainier, the heart of Mt. Rainier National Park, is the highest mountain in the state of Washington and in the Cascade Range. The mountain's summit is broad and rounded. <u>It</u> is 14,410 feet above sea level and has an area of about one square mile. Numerous steam and gas jets occur around the crater, but the volcano has been sleeping for many centuries.

Mount Rainier has a permanent ice cap and extensive snow fields, which give rise to over forty glaciers. <u>These</u> feed swift streams and tumbling waterfalls that race through the glacial valleys. Forests extend to 4,500 feet. There are alpine meadows between the glaciers and the forests <u>which</u> contain beautiful wild flowers. The Nisqually Glacier is probably the ice region that is most often explored by visitors. Paradise Valley, where hotel accommodations are available, perches on the mountain's slope at 5,400 feet. The Wonderland Trail encircles the mountain. <u>Its</u> 90 - mile length can be covered in about a week's time.",
            'indonesian_translation' => "Mount Rainier, jantung Taman Nasional Mt. Rainier, adalah gunung tertinggi di negara bagian Washington dan di Cascade Range. Puncak gunung luas dan bulat. Ini adalah 14.410 kaki di atas permukaan laut dan memiliki area sekitar satu mil persegi. Banyak jet uap dan gas terjadi di sekitar kawah, tetapi gunung berapi telah tidur selama berabad-abad.

Mount Rainier memiliki tutup es permanen dan ladang salju yang luas, yang menimbulkan lebih dari empat puluh gletser. Ini memberi makan aliran cepat dan air terjun yang bergulung yang berlomba melalui lembah glasial. Hutan membentang hingga 4.500 kaki. Ada padang rumput alpine antara gletser dan hutan yang berisi bunga liar yang indah. Gletser Nisqually mungkin adalah wilayah es yang paling sering dijelajahi oleh pengunjung. Paradise Valley, di mana akomodasi hotel tersedia, bertengger di lereng gunung pada 5.400 kaki. Wonderland Trail mengelilingi gunung. Panjangnya 90 mil dapat ditempuh dalam waktu sekitar satu minggu."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 7,
            'question_text' => 'To which of the following does the word "It" in line 3 refer?',
            'option_a' => 'Mt. Rainier',
            'option_b' => 'The summit',
            'option_c' => 'The Cascade range',
            'option_d' => 'The national park',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 8,
            'question_text' => 'The word "These" in line 7 refers to which of the following?',
            'option_a' => 'Snow fields',
            'option_b' => 'Steam and gas jets',
            'option_c' => 'Glaciers',
            'option_d' => 'Streams and waterfalls',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 9,
            'question_text' => 'The word "which" in line 9 refers to',
            'option_a' => 'forests',
            'option_b' => 'wild flowers',
            'option_c' => 'alpine meadows',
            'option_d' => 'glacial valleys',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 10,
            'question_text' => 'What does the word "Its" in line 12 refer to?',
            'option_a' => 'The trail\'s',
            'option_b' => 'An ice region\'s',
            'option_c' => 'The mountain\'s',
            'option_d' => 'A week\'s',
            'correct_answer' => 'A'
        ]);

        // Passage 3: Migration (Questions 11-15)
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "Some people associate migration mainly with birds. Birds do travel vast distances, but mammals also migrate. An example is the caribou, reindeer that graze on the grassy slopes of northern Canada. When the weather turns cold, <u>they</u> travel south until spring. Their tracks are so well-worn that they are clearly visible from the air. Another migrating mammal is the Alaska fur seal. These seals breed only in the Pribilof Islands in the Bering Sea. The young are born in June and by September are strong enough to go with their mothers on a journey of over 3,000 miles. Together <u>they</u> swim down the Pacific Coast of North America. The females and young travel as far as southern California. The males do not journey so far. They swim only to the Gulf of Alaska. In the spring, males and females all return to the islands, and there the cycle begins again.

Whales are among the greatest migrators of all. The humpback, fin, and blue whales migrate thousands of miles each year from the polar seas to the tropics. Whales eat huge quantities of tiny plants and animals (called plankton). These are most abundant in cold polar waters. In winter, the whales move to warm waters to breed and to give birth to <u>their</u> young.",
            'indonesian_translation' => "Beberapa orang mengasosiasikan migrasi terutama dengan burung. Burung memang melakukan perjalanan jarak jauh, tetapi mamalia juga bermigrasi. Contohnya adalah karibu, rusa kutub yang merumput di lereng berumput Kanada utara. Ketika cuaca menjadi dingin, mereka melakukan perjalanan ke selatan sampai musim semi. Jejak mereka sangat aus sehingga mereka jelas terlihat dari udara. Mamalia bermigrasi lainnya adalah anjing laut bulu Alaska. Anjing laut ini berkembang biak hanya di Kepulauan Pribilof di Laut Bering. Anak-anak lahir pada bulan Juni dan pada bulan September cukup kuat untuk pergi dengan ibu mereka dalam perjalanan lebih dari 3.000 mil. Bersama-sama mereka berenang menuruni Pantai Pasifik Amerika Utara. Betina dan anak-anak melakukan perjalanan sejauh California selatan. Jantan tidak melakukan perjalanan sejauh itu. Mereka berenang hanya ke Teluk Alaska. Di musim semi, jantan dan betina semua kembali ke pulau-pulau, dan di sana siklus dimulai lagi.

Paus adalah di antara migrator terbesar dari semua. Paus bungkuk, sirip, dan biru bermigrasi ribuan mil setiap tahun dari laut kutub ke daerah tropis. Paus memakan sejumlah besar tanaman dan hewan kecil (disebut plankton). Ini paling melimpah di perairan kutub yang dingin. Di musim dingin, paus pindah ke perairan hangat untuk berkembang biak dan melahirkan anak-anak mereka."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 11,
            'question_text' => 'The phrase "An example" in line 2 refers to an example of a',
            'option_a' => 'migratory mammal',
            'option_b' => 'place where animals migrate',
            'option_c' => 'bird',
            'option_d' => 'person who associates migration with birds',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 12,
            'question_text' => 'In line 4, the word "Their" is a reference to the',
            'option_a' => 'caribou\'s',
            'option_b' => 'grassy slopes\'',
            'option_c' => 'birds\'',
            'option_d' => 'seals\'',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 13,
            'question_text' => 'To what does the word "They" in line 9 refer?',
            'option_a' => 'female seals',
            'option_b' => 'young seals',
            'option_c' => 'the islands',
            'option_d' => 'male seals',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 14,
            'question_text' => 'In line 10, the word "there" refers to',
            'option_a' => 'the Gulf of Alaska',
            'option_b' => 'the Pribilof Islands',
            'option_c' => 'southern California',
            'option_d' => 'the Pacific Coast of North America',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 15,
            'question_text' => 'The word "These" in line 13 refers to',
            'option_a' => 'three types of whales',
            'option_b' => 'tiny plants and animals',
            'option_c' => 'polar seas',
            'option_d' => 'warm waters',
            'correct_answer' => 'B'
        ]);

        // Passage 4: Design (Questions 16-19)
        $passage4 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "Design is the arrangement of materials to produce certain effects. Design plays a role in visual arts and in the creation of commercial products as well. Designers are concerned with the direction of lines, the size of shapes, and the shading of colors. <u>They</u> arrange these patterns in ways that are satisfying to viewers. There are various elements involved in creating a pleasing design.

Harmony, or balance, can be obtained in a number of ways. It may be either symmetrical (in balance) or asymmetrical (out of balance, but still pleasing to the eye). Or a small area may balance a large area if it has an importance to the eye (because of color or treatment) which equals <u>that</u> of the larger area.

Contrast is the opposite of harmony. The colors red and orange harmonize, since orange contains red. A circle and oval harmonize, as they are both made up of curved lines. But a short line does not harmonize with a long line. It is in contrast.

Unity occurs when all the elements in a design combine to form a consistent whole. Unity resembles balance. A design has balance if its masses are balanced, or if its tones and colors harmonize. But unity differs from balance because it implies that balanced elements work together to form harmony in the design as a whole.",
            'indonesian_translation' => "Desain adalah pengaturan bahan untuk menghasilkan efek tertentu. Desain memainkan peran dalam seni visual dan dalam penciptaan produk komersial juga. Desainer peduli dengan arah garis, ukuran bentuk, dan bayangan warna. Mereka mengatur pola-pola ini dengan cara yang memuaskan pemirsa. Ada berbagai elemen yang terlibat dalam menciptakan desain yang menyenangkan.

Harmoni, atau keseimbangan, dapat diperoleh dengan berbagai cara. Ini mungkin simetris (dalam keseimbangan) atau asimetris (tidak seimbang, tetapi masih menyenangkan mata). Atau area kecil dapat menyeimbangkan area besar jika memiliki kepentingan bagi mata (karena warna atau perlakuan) yang sama dengan area yang lebih besar.

Kontras adalah kebalikan dari harmoni. Warna merah dan oranye harmonis, karena oranye mengandung merah. Lingkaran dan oval harmonis, karena keduanya terbuat dari garis melengkung. Tetapi garis pendek tidak harmonis dengan garis panjang. Ini dalam kontras.

Kesatuan terjadi ketika semua elemen dalam desain bergabung untuk membentuk keseluruhan yang konsisten. Kesatuan menyerupai keseimbangan. Desain memiliki keseimbangan jika massanya seimbang, atau jika nada dan warnanya harmonis. Tetapi kesatuan berbeda dari keseimbangan karena menyiratkan bahwa elemen yang seimbang bekerja bersama untuk membentuk harmoni dalam desain secara keseluruhan."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 16,
            'question_text' => 'The word "They" in line 3 refers to',
            'option_a' => 'designers',
            'option_b' => 'lines, shapes, and colors',
            'option_c' => 'directions, size, and shape',
            'option_d' => 'visual arts',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 17,
            'question_text' => 'The word "that" in line 9 is used as a reference to',
            'option_a' => 'a color',
            'option_b' => 'an area',
            'option_c' => 'importance',
            'option_d' => 'the eye',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 18,
            'question_text' => 'The word "they" in line 11 refers to',
            'option_a' => 'colors',
            'option_b' => 'circle and oval',
            'option_c' => 'curved lines',
            'option_d' => 'harmony',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 19,
            'question_text' => 'The word "its" in line 14 refers to',
            'option_a' => 'unity\'s',
            'option_b' => 'balance\'s',
            'option_c' => 'a design\'s',
            'option_d' => 'a whole\'s',
            'correct_answer' => 'C'
        ]);

        // Passage 5: Wagon Trains (Questions 20-22)
        $passage5 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 5,
            'content' => "Although <u>they</u> had been used to haul freight and passengers between the Eastern seaboard and the Ohio Valley since 1812, wagon trains were first used extensively in the 1820's on the Santa Fe Trail. Long trains of covered wagons drawn by oxen or mules carried manufactured goods to trade for fur, gold, and silver in Santa Fe. The independent traders who pooled <u>their</u> resources to form these trains elected a captain and several lieutenants who commanded the parallel columns in which the wagons usually moved. <u>They</u> enforced the rules, selected the routes, and designated stopping places.",
            'indonesian_translation' => "Meskipun mereka telah digunakan untuk mengangkut barang dan penumpang antara pantai Timur dan Lembah Ohio sejak 1812, kereta wagon pertama kali digunakan secara ekstensif pada tahun 1820-an di Santa Fe Trail. Kereta panjang wagon tertutup yang ditarik oleh lembu atau keledai membawa barang manufaktur untuk diperdagangkan dengan bulu, emas, dan perak di Santa Fe. Pedagang independen yang mengumpulkan sumber daya mereka untuk membentuk kereta ini memilih seorang kapten dan beberapa letnan yang memimpin kolom paralel di mana wagon biasanya bergerak. Mereka menegakkan aturan, memilih rute, dan menunjuk tempat pemberhentian."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 20,
            'question_text' => 'To what does the word "they" in line 1 refer?',
            'option_a' => 'the Eastern Seaboard and the Ohio Valley',
            'option_b' => 'wagon trains',
            'option_c' => 'freights and passengers',
            'option_d' => 'oxen and mules',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 21,
            'question_text' => 'The word "their" in line 5 refers to',
            'option_a' => 'the covered wagons\'',
            'option_b' => 'the oxen and mules\'',
            'option_c' => 'the independent traders\'',
            'option_d' => 'the captain and lieutenants\'',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 22,
            'question_text' => 'To what does the word "They" in line 7 refer?',
            'option_a' => 'the leaders',
            'option_b' => 'the traders',
            'option_c' => 'the parallel columns',
            'option_d' => 'the stopping places',
            'correct_answer' => 'A'
        ]);

        // Passage 6: Children's Books (Questions 23-26)
        $passage6 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 6,
            'content' => "In most of the earliest books for children, illustrations were an afterthought. But in the Caldecott \"toy books,\" pictures were as important as the few lines of copy, and <u>they</u> occupied far more space. One can almost read the nursery rhymes from the dramatic action in the pictures.

Since then, thousands of successful picture books have been published in the United States and in many countries around the world. In <u>the best</u>, the text and illustrations seem to complement each other perfectly. Often one person is the author and illustrator-for example, Robert McCloskey (Make Way for Ducklings) and Arnold Loebel (Frog and Toad Together). Many others have been produced by an author-artist team, as in The Happy Lion, written by Louise Fatio and illustrated by Roger Duvoisin.

Wordless picture books have also become popular. With a little help, three- or four-year-olds can follow the sequence of events and <u>they</u> can understand the stories suggested in them. One of the most delightful examples of a wordless book is Jan Ormerod's nshiite.

American publishers have also drawn on artists from other countries whose original, imaginative works have brought <u>their</u> different visions to American children's book illustration. Among them are Leo Lionni from Italy, Feodor ojankowski from Russia, and Taro Yashima from Japan.",
            'indonesian_translation' => "Di sebagian besar buku paling awal untuk anak-anak, ilustrasi adalah renungan. Tetapi dalam \"buku mainan\" Caldecott, gambar sama pentingnya dengan beberapa baris salinan, dan mereka menempati ruang yang jauh lebih banyak. Seseorang hampir dapat membaca sajak anak-anak dari aksi dramatis dalam gambar.

Sejak itu, ribuan buku gambar yang sukses telah diterbitkan di Amerika Serikat dan di banyak negara di seluruh dunia. Dalam yang terbaik, teks dan ilustrasi tampaknya saling melengkapi dengan sempurna. Seringkali satu orang adalah penulis dan ilustrator-misalnya, Robert McCloskey (Make Way for Ducklings) dan Arnold Loebel (Frog and Toad Together). Banyak lainnya telah diproduksi oleh tim penulis-seniman, seperti dalam The Happy Lion, ditulis oleh Louise Fatio dan diilustrasikan oleh Roger Duvoisin.

Buku gambar tanpa kata juga menjadi populer. Dengan sedikit bantuan, anak-anak berusia tiga atau empat tahun dapat mengikuti urutan peristiwa dan mereka dapat memahami cerita yang disarankan di dalamnya. Salah satu contoh paling menyenangkan dari buku tanpa kata adalah nshiite Jan Ormerod.

Penerbit Amerika juga telah menggunakan seniman dari negara lain yang karya asli dan imajinatif mereka telah membawa visi berbeda mereka ke ilustrasi buku anak-anak Amerika. Di antara mereka adalah Leo Lionni dari Italia, Feodor ojankowski dari Rusia, dan Taro Yashima dari Jepang."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 23,
            'question_text' => 'The word "they" in line 2 refers to',
            'option_a' => 'the earliest books for children',
            'option_b' => 'lines of copy',
            'option_c' => 'the Caldecott "toy books"',
            'option_d' => 'pictures',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 24,
            'question_text' => 'The phrase "the best" in line 6 refers to the best',
            'option_a' => 'picture books',
            'option_b' => 'illustrations',
            'option_c' => 'authors',
            'option_d' => 'nursery rhymes',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 25,
            'question_text' => 'The word "they" in line 12 refers to',
            'option_a' => 'delightful examples',
            'option_b' => 'events',
            'option_c' => '3- and 4-year-olds',
            'option_d' => 'wordless picture books',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 26,
            'question_text' => 'The word "their" in line 16 refers to',
            'option_a' => 'American publishers',
            'option_b' => 'original, imaginative works',
            'option_c' => 'artists from other countries',
            'option_d' => 'American children\'s',
            'correct_answer' => 'C'
        ]);

        $this->command->info('TOEFL Reading Meeting 12 seeded successfully!');
    }
}
