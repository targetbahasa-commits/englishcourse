<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting8SeederWithTranslation extends Seeder
{
    public function run()
    {
        // Get Meeting 8
        $meeting = ToeflReadingMeeting::where('meeting_number', 8)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 8,
                'title' => 'Inferences 3',
                'is_locked' => false
            ]);
        }

        // Delete existing passages for Meeting 8
        ToeflReadingPassage::where('meeting_id', $meeting->id)->delete();

        // Passage 1: Pigeons and Facial Recognition
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "Pigeons have been taught to recognize human facial expressions, upsetting longheld beliefs that only humans had evolved the sophisticated nervous systems to perform such a feat. In recent experiments at the University of Iowa, eight trained pigeons were shown photographs of people displaying emotions of happiness, anger, surprise, and disgust. The birds learned to distinguish between these expressions. Not only that, but they were also able to correctly identify the same expressions on photographs of unfamiliar faces. Their achievement does not suggest, of course, that the pigeons had any idea what the human expressions meant.

Some psychologists have theorized that because of the importance of facial expressions to human communication, humans developed special nervous systems capable of recognizing subtle expressions. The pigeons cast doubt on that idea, however.

In fact, the ability to recognize facial expressions of emotion is not necessarily innate even in human babies, but may have to be learned in much the same way pigeons learn. In experiments conducted several years ago at the University of Iowa, it was found that pigeons organize images of things into the same logical categories that humans do.

None of this work would come as any surprise to Charles Darwin, who long ago wrote about the continuity of mental development from animals to humans.",
            'indonesian_translation' => "Merpati telah diajarkan untuk mengenali ekspresi wajah manusia, mengguncang keyakinan lama bahwa hanya manusia yang telah mengembangkan sistem saraf canggih untuk melakukan hal tersebut. Dalam eksperimen terbaru di Universitas Iowa, delapan merpati terlatih ditunjukkan foto-foto orang yang menampilkan emosi kebahagiaan, kemarahan, kejutan, dan jijik. Burung-burung tersebut belajar membedakan ekspresi-ekspresi ini. Tidak hanya itu, mereka juga mampu mengidentifikasi dengan benar ekspresi yang sama pada foto wajah yang tidak dikenal. Pencapaian mereka tentu saja tidak menunjukkan bahwa merpati memiliki pemahaman tentang arti ekspresi manusia tersebut.

Beberapa psikolog berteori bahwa karena pentingnya ekspresi wajah dalam komunikasi manusia, manusia mengembangkan sistem saraf khusus yang mampu mengenali ekspresi halus. Namun, merpati meragukan ide tersebut.

Faktanya, kemampuan mengenali ekspresi wajah emosi tidak selalu bawaan bahkan pada bayi manusia, tetapi mungkin harus dipelajari dengan cara yang sama seperti merpati belajar. Dalam eksperimen yang dilakukan beberapa tahun lalu di Universitas Iowa, ditemukan bahwa merpati mengorganisir gambar benda ke dalam kategori logis yang sama seperti yang dilakukan manusia.

Tidak ada dari pekerjaan ini yang akan mengejutkan Charles Darwin, yang sudah lama menulis tentang kesinambungan perkembangan mental dari hewan ke manusia."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'From the passage, which of the following can be inferred about pigeons ...',
            'option_a' => 'They can show the same emotions humans can.',
            'option_b' => 'They can understand human emotions.',
            'option_c' => 'They can only identify the expressions of people they are familiar with.',
            'option_d' => 'They have more sophisticated nervous systems than was once thought.',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 2,
            'question_text' => 'The passage implies that, at birth, human babies ...',
            'option_a' => 'have nervous systems capable of recognizing subtle expressions',
            'option_b' => 'can learn from pigeons',
            'option_c' => 'are not able to recognize familiar faces',
            'option_d' => 'may not be able to identify basic emotions through facial expressions',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 3,
            'question_text' => 'Why does the author mention the experiments conducted several years ago at the University of Iowa?',
            'option_a' => 'They proved that pigeons were not the only kind of animal with the ability to recognize facial expressions.',
            'option_b' => 'They were contradicted by more recent experiments.',
            'option_c' => 'They proved that the ability to recognize human expressions was not innate in human babies.',
            'option_d' => 'They showed the similarities between the mental organization of pigeons and that of humans.',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 4,
            'question_text' => 'If Charles Darwin could have seen the results of this experiment, his most probable response would have been one of ...',
            'option_a' => 'rejection',
            'option_b' => 'surprise',
            'option_c' => 'agreement',
            'option_d' => 'amusement',
            'correct_answer' => 'C'
        ]);

        // Passage 2: Old Faithful Geyser
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "The spectacular eruptions of Old Faithful geyser in Yellowstone National Park do not occur like clockwork. Before the earthquake of 1959, eruptions came every 60 to 65 minutes; today they are as little as 30 minutes or as much as 90 minutes apart. The geyser usually gives a warning: a short burst of steam. Then a graceful column rises up to 150 feet in the air. The water unfurls in the sunlight with the colors of the rainbow playing across it.

This eruption is only the visible part of the spectacle. The geyser is linked by an intricate plumbing network to some extremely hot rocks. As water seeps into the underground system, it is heated at the bottom like water in a tea kettle. But while water in a kettle rises because of convection, the narrow tubes of the geyser system prevent free circulation of the water. Thus, the water in the upper tubes is far cooler than the water at the bottom. The weight of the water puts pressure on the column, and this raises the boiling point of the water near the bottom. Finally, the water in the upper part of the column warms and expands. some of it welling out of the mouth of the geyser. This decreases the pressure on the superheated water, which abruptly turns to steam. This in turn forces all the water and vapor out of the geyser.",
            'indonesian_translation' => "Letusan spektakuler geyser Old Faithful di Taman Nasional Yellowstone tidak terjadi seperti jarum jam. Sebelum gempa bumi tahun 1959, letusan terjadi setiap 60 hingga 65 menit; saat ini letusan terjadi dengan jarak sesingkat 30 menit atau selama 90 menit. Geyser biasanya memberikan peringatan: semburan uap pendek. Kemudian kolom air yang anggun naik hingga 150 kaki di udara. Air tersebut terbentang di bawah sinar matahari dengan warna-warna pelangi yang bermain di permukaannya.

Letusan ini hanya bagian yang terlihat dari pertunjukan. Geyser terhubung melalui jaringan pipa yang rumit ke beberapa batuan yang sangat panas. Saat air merembes ke sistem bawah tanah, air dipanaskan di bagian bawah seperti air dalam teko. Tetapi sementara air dalam teko naik karena konveksi, tabung sempit sistem geyser mencegah sirkulasi bebas air. Dengan demikian, air di tabung atas jauh lebih dingin daripada air di bagian bawah. Berat air memberikan tekanan pada kolom, dan ini meningkatkan titik didih air di dekat bagian bawah. Akhirnya, air di bagian atas kolom menghangat dan mengembang, sebagian keluar dari mulut geyser. Ini mengurangi tekanan pada air yang sangat panas, yang tiba-tiba berubah menjadi uap. Ini pada gilirannya memaksa semua air dan uap keluar dari geyser."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 5,
            'question_text' => 'It can be inferred from the passage that the earthquake of 1959 made Old Faithful geyser erupt ...',
            'option_a' => 'more frequently',
            'option_b' => 'less regularly',
            'option_c' => 'more suddenly',
            'option_d' => 'less spectacularly',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 6,
            'question_text' => 'Why does the author mention a rainbow in line 5?',
            'option_a' => 'The column of water forms an arc in the shape of a rainbow.',
            'option_b' => 'In the sunlight, the column of water may produce the colors of the rainbow.',
            'option_c' => 'Rainbows can be seen quite frequently in Yellowstone National Park.',
            'option_d' => 'The rainbow like the geyser is an example of the beauty of nature.',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 7,
            'question_text' => 'The passage implies that Old Faithful would probably not erupt at all if ...',
            'option_a' => 'the tubes of the geyser system were very wide',
            'option_b' => 'the climate suddenly changed',
            'option_c' => 'there had not been an earthquake in 1959',
            'option_d' => 'the underground tubes were longer',
            'correct_answer' => 'A'
        ]);

        // Passage 3: Tumbleweeds
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "In 1881, a new type of weed began spreading across the northern Great Plains. Unlike other weeds, the tumbleweed did not spend its life rooted to the soil; instead it tumbled and rolled across fields in the wind. The weed had sharp, spiny leaves that could lacerate the flesh of ranchers and horses alike. It exploited the vast area of the plains, thriving in regions too barren to support other plants. With its ability to generate and disseminate numerous seeds quickly, it soon became the scourge of the prairies.

To present-day Americans, the tumbleweed symbolizes the Old West. They read the Zane Grey novels in which tumbleweeds drift across stark western landscapes and see classic western movies in which tumbleweeds roll past scenes with cowboys and covered wagons. Yet just over a century ago, the tumbleweed was a newcomer. The first sign of the invasion occurred in North and South Dakota in the late 1870's.

Farmers had noticed the sudden appearance of the new unusual plant. One group of immigrants, however, did not find the weed at all unfamiliar. The tumbleweed, it turns out, was a native of southern Russia, where it was known as Tartar thistle. It was imported to the United States by unknowing farmers.

Frontier settlers gave the plants various names: saltwort, Russian cactus, and wind witch. But botanists at the Department of Agriculture preferred the designation Russian thistle as the plant's common name. However, these botanists had a much harder time agreeing on the plant's scientific name. Generally, botanists compare a plant to published accounts of similar plants, or to samples kept as specimens. Unfortunately, no book described the weed, and no samples existed in herbaria in the United States.",
            'indonesian_translation' => "Pada tahun 1881, jenis gulma baru mulai menyebar di seluruh Great Plains utara. Tidak seperti gulma lainnya, tumbleweed tidak menghabiskan hidupnya berakar di tanah; sebaliknya ia berguling dan menggelinding melintasi ladang tertiup angin. Gulma ini memiliki daun tajam dan berduri yang dapat melukai daging peternak dan kuda. Ia memanfaatkan wilayah luas dataran, berkembang di daerah yang terlalu tandus untuk menopang tanaman lain. Dengan kemampuannya menghasilkan dan menyebarkan banyak biji dengan cepat, ia segera menjadi momok padang rumput.

Bagi orang Amerika masa kini, tumbleweed melambangkan Wild West. Mereka membaca novel Zane Grey di mana tumbleweed melayang melintasi lanskap barat yang tandus dan melihat film barat klasik di mana tumbleweed berguling melewati adegan dengan koboi dan kereta tertutup. Namun hanya lebih dari seabad yang lalu, tumbleweed adalah pendatang baru. Tanda pertama invasi terjadi di North dan South Dakota pada akhir tahun 1870-an.

Petani telah memperhatikan munculnya tiba-tiba tanaman baru yang tidak biasa ini. Namun, satu kelompok imigran tidak merasa asing dengan gulma tersebut. Ternyata, tumbleweed berasal dari Rusia selatan, di mana ia dikenal sebagai Tartar thistle. Ia diimpor ke Amerika Serikat oleh petani yang tidak mengetahuinya.

Pemukim perbatasan memberikan berbagai nama untuk tanaman ini: saltwort, kaktus Rusia, dan penyihir angin. Tetapi ahli botani di Departemen Pertanian lebih memilih sebutan Russian thistle sebagai nama umum tanaman. Namun, para ahli botani ini jauh lebih kesulitan menyepakati nama ilmiah tanaman tersebut. Umumnya, ahli botani membandingkan tanaman dengan catatan yang diterbitkan tentang tanaman serupa, atau dengan sampel yang disimpan sebagai spesimen. Sayangnya, tidak ada buku yang menggambarkan gulma tersebut, dan tidak ada sampel yang ada di herbarium di Amerika Serikat."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 8,
            'question_text' => 'Which of the following can be inferred about tumbleweeds?',
            'option_a' => 'They have strong, deep roots.',
            'option_b' => 'They require a lot of care.',
            'option_c' => 'They reproduce efficiently.',
            'option_d' => 'They provided food for ranchers and animals.',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 9,
            'question_text' => 'The passage suggests that most present-day Americans ...',
            'option_a' => 'consider the tumbleweed beneficial',
            'option_b' => 'don\'t know when tumbleweeds came to North America',
            'option_c' => 'have never heard of tumbleweeds',
            'option_d' => 'believe tumbleweeds are newcomers to the United States',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 10,
            'question_text' => 'The author mentions the novels of Zane Grey and classic western movies (lines 8-9) because they...',
            'option_a' => 'tell the story of the invasion of tumbleweeds',
            'option_b' => 'are sources of popular information about tumbleweeds',
            'option_c' => 'present very inaccurate pictures of tumbleweeds',
            'option_d' => 'were written long before tumbleweeds were present in the United States',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 11,
            'question_text' => 'It is probable that the "group of immigrants" mentioned in line 18...',
            'option_a' => 'was from southern Russia',
            'option_b' => 'had lived in North and South Dakota for many years',
            'option_c' => 'imported tumbleweeds into the United States',
            'option_d' => 'wrote a number of accounts about tumbleweeds',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 12,
            'question_text' => 'From the passage it can be inferred that the botanists at the Department of Agriculture ...',
            'option_a' => 'could not find any tumbleweeds on the plains',
            'option_b' => 'gave the names saltwort, Russian cactus, and wind witch to the tumbleweed',
            'option_c' => 'could not decide on a common designation for the tumbleweed',
            'option_d' => 'found it difficult to classify the plant scientifically',
            'correct_answer' => 'D'
        ]);

        // Passage 4: Airport Design
        $passage4 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "For most modern airports, the major design problem is scale how to allow adequate space on the ground for maneuvering wide body jets while permitting convenient and rapid movement of passengers departing, arriving, or transferring from one flight to another.

Most designs for airport terminals take one of four approaches. In the linear plan, the building may be straight or curved. The passengers board aircraft parked next to the terminal. This plan works well for small airports that need to provide boarding areas for only a few aircraft at a time.

In the pier plan, narrow corridors or piers extend from a central building. This plan allows many aircraft to park next to the building. However, it creates long walking distances for passengers.

In the satellite plan, passengers board aircraft from small terminals that are separated from the main terminals. Passengers reach the satellites by way of shuttle trains or underground passageways that have shuttle trains or moving sidewalks.

The transporter plan uses some system of transport to move passengers from the terminal building to the aircraft. If buses are used, the passengers must climb a flight of stairs to board the aircraft. If mobile lounges are used, they can link up directly with the aircraft and protect passengers from the weather.",
            'indonesian_translation' => "Untuk sebagian besar bandara modern, masalah desain utama adalah skala bagaimana memberikan ruang yang memadai di darat untuk manuver jet berbadan lebar sambil memungkinkan pergerakan penumpang yang nyaman dan cepat saat berangkat, tiba, atau transit dari satu penerbangan ke penerbangan lainnya.

Sebagian besar desain terminal bandara mengambil salah satu dari empat pendekatan. Dalam rencana linear, bangunan bisa lurus atau melengkung. Penumpang naik pesawat yang diparkir di sebelah terminal. Rencana ini bekerja dengan baik untuk bandara kecil yang perlu menyediakan area boarding hanya untuk beberapa pesawat sekaligus.

Dalam rencana dermaga, koridor sempit atau dermaga memanjang dari bangunan pusat. Rencana ini memungkinkan banyak pesawat parkir di sebelah bangunan. Namun, ini menciptakan jarak berjalan yang panjang bagi penumpang.

Dalam rencana satelit, penumpang naik pesawat dari terminal kecil yang terpisah dari terminal utama. Penumpang mencapai satelit melalui kereta antar-jemput atau lorong bawah tanah yang memiliki kereta antar-jemput atau trotoar berjalan.

Rencana transporter menggunakan beberapa sistem transportasi untuk memindahkan penumpang dari bangunan terminal ke pesawat. Jika bus digunakan, penumpang harus menaiki tangga untuk naik pesawat. Jika lounge bergerak digunakan, mereka dapat terhubung langsung dengan pesawat dan melindungi penumpang dari cuaca."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 13,
            'question_text' => 'It can be inferred that scale would not pose a major design problem at airports if ...',
            'option_a' => 'airports were larger',
            'option_b' => 'aircraft did not need so much space to maneuver on the ground',
            'option_c' => 'other forms of transportation were more efficient',
            'option_d' => 'airplanes could fly faster',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 14,
            'question_text' => 'The linear plan would probably be best at ...',
            'option_a' => 'a busy airport',
            'option_b' => 'an airport used by many small aircraft',
            'option_c' => 'an airport with only a few arrivals or departures',
            'option_d' => 'an airport that serves a large city',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 15,
            'question_text' => 'The passage implies that the term "satellite plan" is used because ...',
            'option_a' => 'satellites are launched and tracked from these sites',
            'option_b' => 'small terminals circle the main terminal like satellites around a planet',
            'option_c' => 'the plan makes use of the most modern, high-technology equipment',
            'option_d' => 'airports that make use of this plan utilize data from weather satellites',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 16,
            'question_text' => 'The passage suggests that shuttle trains transfer passengers to satellite terminals from ...',
            'option_a' => 'the main terminal',
            'option_b' => 'airplanes',
            'option_c' => 'downtown',
            'option_d' => 'other satellite terminals',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 17,
            'question_text' => 'It can be inferred that mobile lounges would be more desirable than buses when ...',
            'option_a' => 'passengers are in a hurry',
            'option_b' => 'flights have been delayed',
            'option_c' => 'the weather is bad',
            'option_d' => 'passengers need to save money',
            'correct_answer' => 'C'
        ]);

        // Passage 5: Beach Erosion and Seawalls
        $passage5 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 5,
            'content' => "The sea has been rising relative to the land for at least 100 years, geologists say. During that same period, the Atlantic Coast has eroded an average of 2 to 3 feet per year, the Gulf Coast even faster. Many engineers maintain that seawalls and replenished beaches are necessary to protect the nation's shoreline. Too many people live or vacation in Miami Beach, Atlantic City, or Martha's Vineyard to allow their roads and buildings to simply fall into the sea.

The problem with seawalls is that they simply don't work. One study has shown that, in fact, seawalls accelerate the erosion of beaches.

Faced with the loss of their beaches, other communities have tried a simple but expensive solution: replace the lost sand. These replenishment programs, however, are costly and of dubious value. Another study has shown that only 10% of replenished beaches lasted more than 5 years.",
            'indonesian_translation' => "Laut telah naik relatif terhadap daratan setidaknya selama 100 tahun, kata para ahli geologi. Selama periode yang sama, Pantai Atlantik telah tererosi rata-rata 2 hingga 3 kaki per tahun, Pantai Teluk bahkan lebih cepat. Banyak insinyur berpendapat bahwa tembok laut dan pantai yang diisi ulang diperlukan untuk melindungi garis pantai negara. Terlalu banyak orang yang tinggal atau berlibur di Miami Beach, Atlantic City, atau Martha's Vineyard untuk membiarkan jalan dan bangunan mereka jatuh begitu saja ke laut.

Masalah dengan tembok laut adalah mereka sama sekali tidak bekerja. Satu studi telah menunjukkan bahwa, pada kenyataannya, tembok laut mempercepat erosi pantai.

Menghadapi hilangnya pantai mereka, komunitas lain telah mencoba solusi sederhana namun mahal: mengganti pasir yang hilang. Program pengisian ulang ini, bagaimanapun, mahal dan nilainya meragukan. Studi lain telah menunjukkan bahwa hanya 10% pantai yang diisi ulang bertahan lebih dari 5 tahun."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 18,
            'question_text' => 'It can be inferred from the passage that the author ...',
            'option_a' => 'opposes the use of both seawalls and beach replenishment',
            'option_b' => 'believes beach replenishment would be more effective than seawalls',
            'option_c' => 'opposes any actions to protect the shoreline',
            'option_d' => 'denies that beach erosion is a problem',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 19,
            'question_text' => 'Why does the author mention Miami Beach, Atlantic City, and Martha\'s Vineyard?',
            'option_a' => 'These are communities with seawalls.',
            'option_b' => 'These are communities that have implemented replenishment programs.',
            'option_c' => 'These are communities in danger of beach erosion.',
            'option_d' => 'These are communities which have lost roads and buildings to erosion.',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 20,
            'question_text' => 'The author quotes the two studies in the passage in order to ...',
            'option_a' => 'suggest that the sea is not rising as fast as was originally believed',
            'option_b' => 'strengthen the engineers\' contention that seawalls and replenished beaches are necessary',
            'option_c' => 'propose two new solutions to beach erosion',
            'option_d' => 'support his own position',
            'correct_answer' => 'D'
        ]);

        $this->command->info('TOEFL Reading Meeting 8 with Indonesian translations seeded successfully!');
    }
}
