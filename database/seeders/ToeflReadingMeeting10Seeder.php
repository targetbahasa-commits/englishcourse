<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting10Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 10
        $meeting = ToeflReadingMeeting::where('meeting_number', 10)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 10,
                'title' => 'Vocabulary in Context 2',
                'is_locked' => false
            ]);
        }

        // Passage about Civil War
        $passage = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "The Civil War created feverish manufacturing activity to supply critical material, especially in the North. When the fighting stopped, the stage was set for dramatic economic growth. Wartime taxes on production vanished, and the few taxes that remained leaned heavily on real estate, not on business. The population flow from farm to city increased, and the labor force in provided was buttressed by millions of newly arrived immigrants willing to work for low wages in the textile mills of the North and on the railroad crews of the Midwest and West.

Government was nothing if not accommodating. It established tariff barriers, provided loans and grants to build a transcontinental railroad, and assumed a studied posture of nonintervention in private enterprise. The social Darwinism of British philosopher Herbert Spencer and American economist William Graham Summer prevailed. The theory was that left to its own devices, business would eliminate the weak and nurture the strong. But as business expanded, rivalry heated up. In the 1880's, five railroads operating between New York and Chicago were vying for traffic, and two more were under construction. As a result of the battle, the fare for the trip decreased to $1. The petroleum industry suffered from similar savage competition, and in the 1870's, many oil industries failed.",
            'indonesian_translation' => "Perang Saudara menciptakan aktivitas manufaktur yang demam untuk memasok bahan kritis, terutama di Utara. Ketika pertempuran berhenti, panggung telah disiapkan untuk pertumbuhan ekonomi yang dramatis. Pajak masa perang pada produksi lenyap, dan beberapa pajak yang tersisa sangat bergantung pada real estat, bukan pada bisnis. Aliran populasi dari pertanian ke kota meningkat, dan tenaga kerja yang disediakan diperkuat oleh jutaan imigran yang baru tiba yang bersedia bekerja dengan upah rendah di pabrik tekstil di Utara dan di kru kereta api di Midwest dan Barat.

Pemerintah sangat mengakomodasi. Ia menetapkan hambatan tarif, memberikan pinjaman dan hibah untuk membangun jalur kereta api lintas benua, dan mengambil sikap tidak campur tangan yang dipelajari dalam perusahaan swasta. Darwinisme sosial dari filsuf Inggris Herbert Spencer dan ekonom Amerika William Graham Summer berlaku. Teorinya adalah bahwa jika dibiarkan sendiri, bisnis akan menghilangkan yang lemah dan memelihara yang kuat. Tetapi ketika bisnis berkembang, persaingan memanas. Pada tahun 1880-an, lima jalur kereta api yang beroperasi antara New York dan Chicago bersaing untuk lalu lintas, dan dua lagi sedang dalam konstruksi. Sebagai hasil dari pertempuran, tarif untuk perjalanan menurun menjadi $1. Industri minyak bumi menderita dari persaingan biadab yang serupa, dan pada tahun 1870-an, banyak industri minyak gagal."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 1,
            'question_text' => 'The word "feverish" in line 1 is closest in meaning to',
            'option_a' => 'extremely rapid',
            'option_b' => 'sickly and slow',
            'option_c' => 'very dangerous',
            'option_d' => 'understandable',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 2,
            'question_text' => 'Which of the following is closest in meaning to the word "critical" in line 1?',
            'option_a' => 'Industrial',
            'option_b' => 'Serious',
            'option_c' => 'Crucial',
            'option_d' => 'Insulting',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 3,
            'question_text' => 'The phrase "the stage was set" in line 2 is closest in meaning to which of the following?',
            'option_a' => 'The play was over.',
            'option_b' => 'The progress continued.',
            'option_c' => 'The foundation was laid.',
            'option_d' => 'The direction was clear.',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 4,
            'question_text' => 'The phrase "real estate" in line 4 refers to',
            'option_a' => 'tools and machines',
            'option_b' => 'actual income',
            'option_c' => 'new enterprises',
            'option_d' => 'land and buildings',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 5,
            'question_text' => 'The word "buttressed" in line 5 is closest in meaning to',
            'option_a' => 'concerned',
            'option_b' => 'supplemented',
            'option_c' => 'restructured',
            'option_d' => 'enriched',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 6,
            'question_text' => 'The word "accommodating" in line 8 is closest in meaning to',
            'option_a' => 'persistent',
            'option_b' => 'indifferent',
            'option_c' => 'balanced',
            'option_d' => 'helpful',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 7,
            'question_text' => 'Which of the following could best be substituted for the word "posture" in line 10?',
            'option_a' => 'Stature',
            'option_b' => 'Predicament',
            'option_c' => 'Position',
            'option_d' => 'Situation',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 8,
            'question_text' => 'The word "prevailed" in line 12 is closest in meaning to',
            'option_a' => 'influenced',
            'option_b' => 'triumphed',
            'option_c' => 'premiered',
            'option_d' => 'evolved',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 9,
            'question_text' => 'The phrase "left to its own devices" in lines 12 means',
            'option_a' => 'forced to do additional work',
            'option_b' => 'allowed to do as it pleased',
            'option_c' => 'made to change its plans',
            'option_d' => 'encouraged to produce more goods',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 10,
            'question_text' => 'The word "vying" in line 14 is closest in meaning to',
            'option_a' => 'competing',
            'option_b' => 'hoping',
            'option_c' => 'arranging',
            'option_d' => 'caring',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 11,
            'question_text' => 'The word "savage" in line 16 is closest in meaning to',
            'option_a' => 'fierce',
            'option_b' => 'growing',
            'option_c' => 'surprising',
            'option_d' => 'genuine',
            'correct_answer' => 'A'
        ]);

        // Passage 2: Birds
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "All birds have feathers, and all animals with feathers are birds. No other major group of animals is so easy to categorize. All birds have wings, too, but wings are not peculiar to birds.

Many adaptations are found in both feathers and wings. Feathers form the soft down of geese and ducks, the long decorative plumes of ostriches, and the strong flight feathers of eagles and hawks. Wings vary from the short, broad ones of chickens, which seldom fly, to the long, slim ones of albatrosses, which spend almost all their lives soaring on air currents. In penguins, wings have been modified into flippers and feathers into a waterproof covering. In kiwis, the wings are almost impossible to detect.

Yet diversity among birds is not so striking as it is among mammals. The difference between a hummingbird and a penguin is immense, but hardly as startling as that between a bat and a whale. It is variations in details rather than in fundamental patterns that have been important in the adaptation of birds to many kinds of ecosystems.",
            'indonesian_translation' => "Semua burung memiliki bulu, dan semua hewan dengan bulu adalah burung. Tidak ada kelompok hewan besar lainnya yang begitu mudah dikategorikan. Semua burung juga memiliki sayap, tetapi sayap tidak khas untuk burung.

Banyak adaptasi ditemukan baik pada bulu maupun sayap. Bulu membentuk bulu halus angsa dan bebek, bulu dekoratif panjang burung unta, dan bulu terbang yang kuat dari elang dan elang. Sayap bervariasi dari yang pendek dan lebar dari ayam, yang jarang terbang, hingga yang panjang dan ramping dari albatros, yang menghabiskan hampir seluruh hidup mereka melayang di arus udara. Pada penguin, sayap telah dimodifikasi menjadi sirip dan bulu menjadi penutup tahan air. Pada kiwi, sayap hampir tidak mungkin dideteksi.

Namun keragaman di antara burung tidak begitu mencolok seperti di antara mamalia. Perbedaan antara burung kolibri dan penguin sangat besar, tetapi hampir tidak mengejutkan seperti antara kelelawar dan paus. Variasi dalam detail daripada pola fundamental yang telah penting dalam adaptasi burung ke berbagai jenis ekosistem."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 12,
            'question_text' => 'The word "categorize" in line 2 is closest in meaning to',
            'option_a' => 'appreciate',
            'option_b' => 'comprehend',
            'option_c' => 'classify',
            'option_d' => 'visualize',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 13,
            'question_text' => 'Which of the following is closest in meaning to the phrase "peculiar to" in line 3?',
            'option_a' => 'Unusual for',
            'option_b' => 'Common to',
            'option_c' => 'Necessary for',
            'option_d' => 'Unique to',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'question_text' => 'The word "slim" in line 7 is closest in meaning to',
            'option_a' => 'slender',
            'option_b' => 'powerful',
            'option_c' => 'graceful',
            'option_d' => 'soft',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 15,
            'question_text' => 'The word "detect" in line 9 is closest in meaning to',
            'option_a' => 'utilize',
            'option_b' => 'notice',
            'option_c' => 'activate',
            'option_d' => 'value',
            'correct_answer' => 'B'
        ]);

        // Passage 3: Concord Coach
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "Manufactured in the tranquil New England town of Concord, New Hampshire, the famous Concord Coach was symbolized the Wild West. Its rugged body and a suspension system of leather straps could handle the hard jolts from rough roads. A journalist in 1868, describing a railroad shipment of 30 coaches bound for Wells, Fargo and Company, wrote \"They were splendidly decorated ... the bodies red and the running parts yellow. Each door has a handsome picture, mostly landscapes, and no two coaches are exactly alike.\"

Wells, Fargo and Company was founded in 1852 to provide mail and banking services for the gold camps of California and later won a monopoly on express services west of the Mississippi. A Wells, Fargo Concord Coach carried nine to fourteen passengers plus baggage and mail. The accommodations were by no means plush. However, the stagecoach was the swiftest method of travel through much of the Far West.",
            'indonesian_translation' => "Diproduksi di kota New England yang tenang di Concord, New Hampshire, Concord Coach yang terkenal melambangkan Wild West. Bodi yang kokoh dan sistem suspensi tali kulit dapat menangani guncangan keras dari jalan yang kasar. Seorang jurnalis pada tahun 1868, menggambarkan pengiriman kereta api dari 30 kereta yang terikat untuk Wells, Fargo and Company, menulis \"Mereka dihias dengan indah ... bodi merah dan bagian yang berjalan kuning. Setiap pintu memiliki gambar yang tampan, sebagian besar pemandangan, dan tidak ada dua kereta yang persis sama.\"

Wells, Fargo and Company didirikan pada tahun 1852 untuk menyediakan layanan surat dan perbankan untuk kamp emas California dan kemudian memenangkan monopoli pada layanan ekspres di barat Mississippi. Sebuah Wells, Fargo Concord Coach membawa sembilan hingga empat belas penumpang ditambah bagasi dan surat. Akomodasinya sama sekali tidak mewah. Namun, kereta kuda adalah metode perjalanan tercepat melalui sebagian besar Far West."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 20,
            'question_text' => 'The word "tranquil" in line 1 is closest in meaning to',
            'option_a' => 'Peaceful',
            'option_b' => 'Bustling',
            'option_c' => 'Industrial',
            'option_d' => 'Tiny',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 21,
            'question_text' => 'The word "symbolize" in line 2 is closest in meaning to',
            'option_a' => 'Recollect',
            'option_b' => 'Fulfill',
            'option_c' => 'Deny',
            'option_d' => 'Represent',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 22,
            'question_text' => 'Which of the following could best substitute for the word "rugged" in line 2?',
            'option_a' => 'Streamlined',
            'option_b' => 'Roomy',
            'option_c' => 'Sturdy',
            'option_d' => 'Primitive',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 23,
            'question_text' => 'Which of the following is closest in meaning to the word "jolts" in line 3?',
            'option_a' => 'Signs',
            'option_b' => 'Shocks',
            'option_c' => 'Sights',
            'option_d' => 'Shots',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 24,
            'question_text' => 'The phrase "bound for" in line 4 is closest in meaning to',
            'option_a' => 'Belonged To',
            'option_b' => 'Destined For',
            'option_c' => 'Built By',
            'option_d' => 'Paid For',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 25,
            'question_text' => 'The word "splendidly" in line 5 is closest in meaning to',
            'option_a' => 'Superbly',
            'option_b' => 'Deliberately',
            'option_c' => 'Specifically',
            'option_d' => 'Slightly',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 26,
            'question_text' => 'The word "plush" in line 11 is closest in meaning to',
            'option_a' => 'Normal',
            'option_b' => 'Luxurious',
            'option_c' => 'Memorable',
            'option_d' => 'Unpleasant',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'question_text' => 'Which of the following is closest in meaning to the word "swiftest" in line 12?',
            'option_a' => 'Most comfortable',
            'option_b' => 'Cheapest',
            'option_c' => 'Fastest',
            'option_d' => 'Safest',
            'correct_answer' => 'C'
        ]);

        // Passage 4: Hopi People
        $passage4 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "The Hopi people of Arizona stress the institutions of family and religion in a harmonious existence which makes the self-sacrificing individual the ideal. The Hopi individual is trained to be his or her responsibility to and for the Peaceful People-the Hopi's own term for themselves. Fighting, bullying, or attempting to surpass others bring automatic rebuke from the community.

Implicit in the Hopi view is an original and integrated theory of the universe. With this they organize their society in such a way to obtain a measure of security from a harsh and hazardous environment made up of human foes, famine, and plagues. They conceive of the universe-humans, animals, plants, and supernatural spirits-as an ordered system functioning under a set of rules known to them alone. These rules govern their behavior, emotions, and thoughts in a prescribed way.",
            'indonesian_translation' => "Orang Hopi dari Arizona menekankan institusi keluarga dan agama dalam keberadaan yang harmonis yang membuat individu yang berkorban diri sebagai ideal. Individu Hopi dilatih untuk menjadi tanggung jawabnya kepada dan untuk Orang Damai-istilah Hopi sendiri untuk diri mereka sendiri. Berkelahi, menggertak, atau mencoba melampaui orang lain membawa teguran otomatis dari komunitas.

Implisit dalam pandangan Hopi adalah teori asli dan terintegrasi tentang alam semesta. Dengan ini mereka mengorganisir masyarakat mereka sedemikian rupa untuk mendapatkan ukuran keamanan dari lingkungan yang keras dan berbahaya yang terdiri dari musuh manusia, kelaparan, dan wabah. Mereka memahami alam semesta-manusia, hewan, tanaman, dan roh supernatural-sebagai sistem yang teratur berfungsi di bawah seperangkat aturan yang hanya diketahui oleh mereka. Aturan-aturan ini mengatur perilaku, emosi, dan pikiran mereka dengan cara yang ditentukan."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 28,
            'question_text' => 'The word "stress" in line 1 is closest in meaning to',
            'option_a' => 'Emphasize',
            'option_b' => 'Define',
            'option_c' => 'Describe',
            'option_d' => 'Persuade',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 29,
            'question_text' => 'Which of the following could best substitute for the word "harmonious" in line 2?',
            'option_a' => 'Cooperative',
            'option_b' => 'Dangerous',
            'option_c' => 'Philosophical',
            'option_d' => 'Exclusive',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 30,
            'question_text' => 'The word "term" in line 4 is closest in meaning to',
            'option_a' => 'Era',
            'option_b' => 'Name',
            'option_c' => 'Area',
            'option_d' => 'Law',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 31,
            'question_text' => 'The word "bullying" in line 4 is closest in meaning to',
            'option_a' => 'Lying',
            'option_b' => 'Organizing',
            'option_c' => 'Entertaining',
            'option_d' => 'Tormenting',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 32,
            'question_text' => 'Which of the following can replace the word "rebuke" in line 5 with the least change in meaning?',
            'option_a' => 'Prestige',
            'option_b' => 'Criticism',
            'option_c' => 'Reaction',
            'option_d' => 'Acknowledgment',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 33,
            'question_text' => 'Which of the following could best be substituted for the word "hazardous" in line 8?',
            'option_a' => 'Changing',
            'option_b' => 'Random',
            'option_c' => 'Familiar',
            'option_d' => 'Dangerous',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 34,
            'question_text' => 'The word "foes" in line 8 is closest in meaning to',
            'option_a' => 'Fears',
            'option_b' => 'Needs',
            'option_c' => 'Enemies',
            'option_d' => 'Failures',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 35,
            'question_text' => 'The word "prescribed" in line 11 is closest in meaning to',
            'option_a' => 'Specific',
            'option_b' => 'Careful',
            'option_c' => 'Orderly',
            'option_d' => 'Particular',
            'correct_answer' => 'A'
        ]);

        // Passage 5: Canadian Researchers and Nematode
        $passage5 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 5,
            'content' => "Canadian researchers have discovered a set of genes that determine the lifespan of the common nematode, a type of worm. This finding sheds new light on the aging process that may eventually allow scientists to delay the inexorable process of aging and death.

By manipulating the newly discovered genes, the team at McGill University in Montreal was able to increase the lifespan of the nematode fivefold. Altering the genes apparently slowed the metabolism of the worms to a more leisurely pace. This in turn may slow the accumulation of the DNA defects thought to cause aging.

Although the causes of aging in humans are undoubtedly more involved, researchers are confident that the discoveries will provide invaluable clues about this heretofore mysterious process.",
            'indonesian_translation' => "Peneliti Kanada telah menemukan serangkaian gen yang menentukan rentang hidup nematoda umum, sejenis cacing. Temuan ini memberikan cahaya baru pada proses penuaan yang pada akhirnya dapat memungkinkan ilmuwan untuk menunda proses penuaan dan kematian yang tak terhindarkan.

Dengan memanipulasi gen yang baru ditemukan, tim di McGill University di Montreal mampu meningkatkan rentang hidup nematoda lima kali lipat. Mengubah gen tampaknya memperlambat metabolisme cacing ke kecepatan yang lebih santai. Ini pada gilirannya dapat memperlambat akumulasi cacat DNA yang dianggap menyebabkan penuaan.

Meskipun penyebab penuaan pada manusia tidak diragukan lagi lebih rumit, peneliti yakin bahwa penemuan ini akan memberikan petunjuk yang sangat berharga tentang proses misterius yang sebelumnya ini."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 36,
            'question_text' => 'The word "determine" in line 1 is closest in meaning to',
            'option_a' => 'Control',
            'option_b' => 'Modify',
            'option_c' => 'Maintain',
            'option_d' => 'Shorten',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 37,
            'question_text' => 'Which of the following is closest in meaning to the phrase "sheds new light on" in line 2?',
            'option_a' => 'Contradicts what is known about',
            'option_b' => 'Gives new meaning to',
            'option_c' => 'Provides more information about',
            'option_d' => 'Calls more attention to',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 38,
            'question_text' => 'The word "inexorable" in line 3 is closest in meaning to',
            'option_a' => 'Cruel',
            'option_b' => 'Unstoppable',
            'option_c' => 'Essential',
            'option_d' => 'Incomprehensible',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 39,
            'question_text' => 'Which of the following could best be used in place of the phrase "more leisurely" in line 7?',
            'option_a' => 'More relaxed',
            'option_b' => 'Livelier',
            'option_c' => 'Easier',
            'option_d' => 'More irregular',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 40,
            'question_text' => 'The word "involved" in line 9 is closest in meaning to',
            'option_a' => 'Committed',
            'option_b' => 'Serious',
            'option_c' => 'Apparent',
            'option_d' => 'Complicated',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 41,
            'question_text' => 'Which of the following is closest in meaning to the word "clues" in line 10?',
            'option_a' => 'Plans',
            'option_b' => 'Secrets',
            'option_c' => 'Signals',
            'option_d' => 'Hints',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 42,
            'question_text' => 'The word "heretofore" in line 11 is closest in meaning to',
            'option_a' => 'Universally',
            'option_b' => 'Almost',
            'option_c' => 'Previously',
            'option_d' => 'Somewhat',
            'correct_answer' => 'C'
        ]);

        $this->command->info('TOEFL Reading Meeting 10 seeded successfully!');
    }
}
