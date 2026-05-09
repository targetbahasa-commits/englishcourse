<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    1 => [
        'id' => 'Oseanografi meliputi banyak bidang ilmiah yang tujuannya adalah untuk memahami laut dan kehidupan di dalamnya.', 
        'en' => 'Oceanography consists of many scientific fields whose purpose is to understand the sea and life inside it',
        'vocab' => [
            'Oceanography' => ['id' => 'Oseanografi', 'pos' => '(n)'],
            'Scientific field' => ['id' => 'Bidang ilmiah', 'pos' => '(n)'],
            'Purpose' => ['id' => 'Tujuan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Saya punya teman yang ayahnya adalah seorang dokter.',
            'en' => 'I have a friend whose father is a doctor.'
        ]
    ],
    2 => [
        'id' => 'Palung mariana yang kedalamannya menyembunyikan banyak spesies asing terletak di Samudra Pasifik.', 
        'en' => 'The Mariana Trench whose depth hides many alien species is located in the Pacific Ocean',
        'vocab' => [
            'Trench' => ['id' => 'Palung', 'pos' => '(n)'],
            'Depth' => ['id' => 'Kedalaman', 'pos' => '(n)'],
            'Hide' => ['id' => 'Menyembunyikan', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Wanita yang mobilnya dicuri itu menelpon polisi.',
            'en' => 'The woman whose car was stolen called the police.'
        ]
    ],
    3 => [
        'id' => 'Terdapat lebih dari 300 spesies dari alga emas yang platistidnya kuning keemasan.', 
        'en' => 'There are more than 300 species of golden algae whose plastids are golden yellow',
        'vocab' => [
            'Species' => ['id' => 'Spesies', 'pos' => '(n)'],
            'Algae' => ['id' => 'Alga', 'pos' => '(n)'],
            'Plastid' => ['id' => 'Plastida', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Saya melihat burung yang sayapnya berwarna biru.',
            'en' => 'I saw a bird whose wings are blue.'
        ]
    ],
    4 => [
        'id' => 'Paus bungkuk, anjing laut monk, dan penyu hijau adalah beberapa makhluk air yang habitatnya secara buruk dipengaruhi oleh pembangunan pesisir.', 
        'en' => 'Humpback whales, monk seals, and green turtles are some aquatic creatures whose habitats are badly affected by coastal development',
        'vocab' => [
            'Whale' => ['id' => 'Paus', 'pos' => '(n)'],
            'Creature' => ['id' => 'Makhluk', 'pos' => '(n)'],
            'Habitat' => ['id' => 'Habitat', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Keluarga yang rumahnya terbakar itu selamat.',
            'en' => 'The family whose house burned down is safe.'
        ]
    ],
    5 => [
        'id' => 'Invasif spesies bisa berupa spesies eksotis atau natif yang populasinya berkembang secara cepat dan mengancam fungsi dari ekosistem.', 
        'en' => 'Invasive species can be exotic or native species whose populations grow rapidly and threaten ecosystem functions',
        'vocab' => [
            'Invasive' => ['id' => 'Invasif', 'pos' => '(adj)'],
            'Population' => ['id' => 'Populasi', 'pos' => '(n)'],
            'Threaten' => ['id' => 'Mengancam', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Perusahaan yang keuntungannya meningkat itu akan membuka cabang baru.',
            'en' => 'The company whose profits increased will open a new branch.'
        ]
    ],
    6 => [
        'id' => 'Tanaman yang reproduksinya dikendalikan oleh panjang dari siang hari dan malam hari mungkin tidak akan berbunga di bawah cahaya buatan.', 
        'en' => 'Plants whose reproduction is controlled by the length of day and night may not flower under artificial light',
        'vocab' => [
            'Plant' => ['id' => 'Tanaman', 'pos' => '(n)'],
            'Reproduction' => ['id' => 'Reproduksi', 'pos' => '(n)'],
            'Artificial' => ['id' => 'Buatan', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Penulis yang bukunya menjadi best seller itu sangat kaya.',
            'en' => 'The writer whose book became a best seller is very rich.'
        ]
    ],
    7 => [
        'id' => 'Di Australia sekitar 40.000 tahun yang lalu, satu satunya mamalia di sana adalah marsupials yang anaknya berkembang di kantong external di badan induknya.', 
        'en' => 'In Australia about 40,000 years ago, the only mammals there were marsupials whose young develop in external pouches on their mother\'s body',
        'vocab' => [
            'Mammal' => ['id' => 'Mamalia', 'pos' => '(n)'],
            'Develop' => ['id' => 'Berkembang', 'pos' => '(v)'],
            'Pouch' => ['id' => 'Kantong', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Kucing yang anaknya hilang itu terus mengeong.',
            'en' => 'The cat whose kitten is lost keeps meowing.'
        ]
    ],
    8 => [
        'id' => 'Banyak negara maju yang penduduk mudanya terus menurun mendatangkan tenaga asing dari negara berkembang.', 
        'en' => 'Many developed countries whose young populations continue to decline bring in foreign workers from developing countries',
        'vocab' => [
            'Developed' => ['id' => 'Maju', 'pos' => '(adj)'],
            'Population' => ['id' => 'Penduduk/Populasi', 'pos' => '(n)'],
            'Decline' => ['id' => 'Menurun', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Negara yang ekonominya kuat memiliki pengaruh besar.',
            'en' => 'A country whose economy is strong has great influence.'
        ]
    ],
    9 => [
        'id' => 'Tingkat kelahiran tertinggi dimiliki oleh negara-negara berkembang yang kondisi perekonomiannya tidak mampu menopang pertumbuhan penduduknya.', 
        'en' => 'The highest birth rates are owned by developing countries whose economic conditions cannot support their population growth',
        'vocab' => [
            'Birth rate' => ['id' => 'Tingkat kelahiran', 'pos' => '(n)'],
            'Support' => ['id' => 'Menopang/Mendukung', 'pos' => '(v)'],
            'Growth' => ['id' => 'Pertumbuhan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Siswa yang nilainya bagus mendapat beasiswa.',
            'en' => 'Students whose grades are good get scholarships.'
        ]
    ],
    10 => [
        'id' => 'Kutub selatan yang banyak sumber daya alamnya masih belum dimanfaatkan perlu dilindungi oleh PBB.', 
        'en' => 'Antarctica whose many natural resources are still not utilized needs to be protected by the UN',
        'vocab' => [
            'Resource' => ['id' => 'Sumber daya', 'pos' => '(n)'],
            'Utilize' => ['id' => 'Memanfaatkan', 'pos' => '(v)'],
            'Protect' => ['id' => 'Melindungi', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Pulau yang pantainya indah itu menarik banyak turis.',
            'en' => 'The island whose beaches are beautiful attracts many tourists.'
        ]
    ],
    11 => [
        'id' => 'R.H. Whittaker yang penelitiannya menunjukkan betapa berbedanya bakteri dan jamur dengan tanaman mengajukan sistem 5 kerajaan untuk makhluk hidup.', 
        'en' => 'R.H. Whittaker whose research showed how different bacteria and fungi are from plants proposed a 5-kingdom system for living things',
        'vocab' => [
            'Research' => ['id' => 'Penelitian', 'pos' => '(n)'],
            'Show' => ['id' => 'Menunjukkan', 'pos' => '(v)'],
            'Propose' => ['id' => 'Mengajukan', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Ilmuwan yang teorinya terbukti benar itu mendapat hadiah Nobel.',
            'en' => 'The scientist whose theory was proven correct received a Nobel prize.'
        ]
    ],
    12 => [
        'id' => 'Kita harus menghormati dan menjaga setiap ekologi dimana makhluk hidup lainnya hidup.', 
        'en' => 'We must respect and keep every ecology where other living creatures live',
        'vocab' => [
            'Respect' => ['id' => 'Menghormati', 'pos' => '(v)'],
            'Ecology' => ['id' => 'Ekologi', 'pos' => '(n)'],
            'Creature' => ['id' => 'Makhluk', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Ini adalah rumah dimana saya lahir.',
            'en' => 'This is the house where I was born.'
        ]
    ],
    13 => [
        'id' => 'Meskipun perbedaan namanya, embriologi dan biologi perkembangan berbagi satu tujuan tunggal untuk membuka tabir dari cara yang rumit dimana organisme multisel dibangun.', 
        'en' => 'Despite their different names, embryology and developmental biology share a single goal to unveil the complex way in which multicellular organisms are built',
        'vocab' => [
            'Goal' => ['id' => 'Tujuan', 'pos' => '(n)'],
            'Unveil' => ['id' => 'Membuka tabir/Mengungkap', 'pos' => '(v)'],
            'Complex' => ['id' => 'Rumit', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Saya suka cara dia berbicara.',
            'en' => 'I like the way in which he speaks.'
        ]
    ],
    14 => [
        'id' => 'Homo sapiens adalah pengklasifikasian genus dan spesies dimana semua tingkah laku dan anatomi dari manusia modern teridentifikasi.', 
        'en' => 'Homo sapiens is the genus and species classification in which all behavior and anatomy of modern humans are identified',
        'vocab' => [
            'Classification' => ['id' => 'Pengklasifikasian', 'pos' => '(n)'],
            'Behavior' => ['id' => 'Tingkah laku', 'pos' => '(n)'],
            'Identify' => ['id' => 'Mengidentifikasi', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Kotak dimana saya menyimpan uang hilang.',
            'en' => 'The box in which I kept the money is lost.'
        ]
    ],
    15 => [
        'id' => 'Agama menyediakan pengikut mereka dengan etika atau kode yang berfungsi sebagai tujuan bagi tingkah laku manusia dan norma dimana tingkah laku dievaluasi.', 
        'en' => 'Religion provides its followers with ethics or codes that serve as goals for human behavior and norms by which behavior is evaluated',
        'vocab' => [
            'Provide' => ['id' => 'Menyediakan', 'pos' => '(v)'],
            'Follower' => ['id' => 'Pengikut', 'pos' => '(n)'],
            'Evaluate' => ['id' => 'Mengevaluasi', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Standar dimana kita dinilai sangat tinggi.',
            'en' => 'The standard by which we are judged is very high.'
        ]
    ],
    16 => [
        'id' => 'Bioakumulasi adalah proses dimana bahan kimia yang larut dalam lemak terkumpul di lapisan kulit lemak dari hewan setelah mereka mengolah nutrisi mereka.', 
        'en' => 'Bioaccumulation is the process by which fat-soluble chemicals accumulate in the fatty skin layers of animals after they process their nutrients',
        'vocab' => [
            'Process' => ['id' => 'Proses', 'pos' => '(n)'],
            'Accumulate' => ['id' => 'Terkumpul/Menumpuk', 'pos' => '(v)'],
            'Nutrient' => ['id' => 'Nutrisi', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Cara dimana dia memecahkan masalah itu cerdas.',
            'en' => 'The process by which he solved the problem was clever.'
        ]
    ],
    17 => [
        'id' => 'Zaman es terakhir ketika manusia mengembangkan seni adalah 26.000 tahun sebelum masehi.', 
        'en' => 'The last ice age when humans developed art was 26,000 BC',
        'vocab' => [
            'Ice age' => ['id' => 'Zaman es', 'pos' => '(n)'],
            'Develop' => ['id' => 'Mengembangkan', 'pos' => '(v)'],
            'Art' => ['id' => 'Seni', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Saya ingat hari ketika kita bertemu.',
            'en' => 'I remember the day when we met.'
        ]
    ],
    18 => [
        'id' => 'Asia dimana lebih dari 50% populasi manusia tinggal menghadapi masalah kependudukan yang parah.', 
        'en' => 'Asia where more than 50% of the human population lives faces severe population problems',
        'vocab' => [
            'Population' => ['id' => 'Populasi', 'pos' => '(n)'],
            'Face' => ['id' => 'Menghadapi', 'pos' => '(v)'],
            'Severe' => ['id' => 'Parah', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Taman dimana anak-anak bermain sangat bersih.',
            'en' => 'The park where children play is very clean.'
        ]
    ],
    19 => [
        'id' => '500 sebelum masehi - 600 sebelum masehi ketika masyarakat pemburu dan pengumpul berakhir adalah awal dari masyarakat pertanian.', 
        'en' => '500 BC - 600 BC when hunter-gatherer societies ended was the beginning of agricultural societies',
        'vocab' => [
            'Society' => ['id' => 'Masyarakat', 'pos' => '(n)'],
            'End' => ['id' => 'Berakhir', 'pos' => '(v)'],
            'Beginning' => ['id' => 'Awal', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Tahun ketika saya lulus adalah tahun yang spesial.',
            'en' => 'The year when I graduated was a special year.'
        ]
    ],
    20 => [
        'id' => 'Area dimana F spinosum dikumpulkan telah dibersihkan dari hutannya untuk membuka lahan untuk pertanian.', 
        'en' => 'The area where F spinosum was collected has been cleared of its forests to open land for agriculture',
        'vocab' => [
            'Area' => ['id' => 'Area/Wilayah', 'pos' => '(n)'],
            'Collect' => ['id' => 'Mengumpulkan', 'pos' => '(v)'],
            'Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Tempat dimana kami berkemah sangat sepi.',
            'en' => 'The place where we camped was very quiet.'
        ]
    ],
    21 => [
        'id' => 'Sampah manusia bahkan bisa ditemukan di gunung everest dimana titik tertinggi di Bumi terletak.', 
        'en' => 'Human waste can even be found on Mount Everest where the highest point on Earth is located',
        'vocab' => [
            'Waste' => ['id' => 'Sampah/Limbah', 'pos' => '(n)'],
            'Highest' => ['id' => 'Tertinggi', 'pos' => '(adj)'],
            'Located' => ['id' => 'Terletak', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Kota dimana dia tinggal sangat ramai.',
            'en' => 'The city where he lives is very crowded.'
        ]
    ],
    22 => [
        'id' => '2023 ketika suhu tertinggi yang pernah tercatat sejak 1850 merupakan tahun terburuk bagi es di kutub Bumi.', 
        'en' => '2023 when the highest temperature ever recorded since 1850 was the worst year for ice at Earth\'s poles',
        'vocab' => [
            'Temperature' => ['id' => 'Suhu', 'pos' => '(n)'],
            'Record' => ['id' => 'Mencatat', 'pos' => '(v)'],
            'Pole' => ['id' => 'Kutub', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Masa ketika dinosaurus hidup sangat berbeda.',
            'en' => 'The time when dinosaurs lived was very different.'
        ]
    ],
    23 => [
        'id' => 'Antartika dimana Gunung berapi Erebus terletak memiliki es setebal 4776 meter.', 
        'en' => 'Antarctica where Mount Erebus volcano is located has ice as thick as 4776 meters',
        'vocab' => [
            'Volcano' => ['id' => 'Gunung berapi', 'pos' => '(n)'],
            'Located' => ['id' => 'Terletak', 'pos' => '(v)'],
            'Thick' => ['id' => 'Tebal', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Desa dimana nenek saya tinggal sangat asri.',
            'en' => 'The village where my grandmother lives is very beautiful.'
        ]
    ],
    24 => [
        'id' => 'Alasan mengapa Bumi dapat dihuni oleh makhluk hidup adalah karena jaraknya dari matahari dan air yang dikandungnya.', 
        'en' => 'The reason why Earth can be inhabited by living things is because of its distance from the sun and the water it contains',
        'vocab' => [
            'Reason' => ['id' => 'Alasan', 'pos' => '(n)'],
            'Inhabit' => ['id' => 'Menghuni', 'pos' => '(v)'],
            'Distance' => ['id' => 'Jarak', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Alasan mengapa dia menangis tidak diketahui.',
            'en' => 'The reason why she cried is unknown.'
        ]
    ],
    25 => [
        'id' => 'Mekanisme fisiologi bagaimana lemur mendetoks sianida masih tidak diketahui.', 
        'en' => 'The physiological mechanism of how lemurs detoxify cyanide is still unknown',
        'vocab' => [
            'Mechanism' => ['id' => 'Mekanisme', 'pos' => '(n)'],
            'Detoxify' => ['id' => 'Mendetoks', 'pos' => '(v)'],
            'Unknown' => ['id' => 'Tidak diketahui', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Saya tidak tahu bagaimana dia melakukannya.',
            'en' => 'I don\'t know how he did it.'
        ]
    ],
    26 => [
        'id' => 'Erosi adalah proses dinamis dimana air yang mengalir, glasier, angin, ombak dan arus, gravitasi, dan air tanah mengusangkan Bumi.', 
        'en' => 'Erosion is a dynamic process in which flowing water, glaciers, wind, waves and currents, gravity, and groundwater wear down the Earth',
        'vocab' => [
            'Process' => ['id' => 'Proses', 'pos' => '(n)'],
            'Flow' => ['id' => 'Mengalir', 'pos' => '(v)'],
            'Wear down' => ['id' => 'Mengusangkan/Mengikis', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Cara dimana burung membangun sarang sangat menarik.',
            'en' => 'The way in which birds build nests is very interesting.'
        ]
    ]
];

$paragraph = [
    'id' => 'Sebuah organisasi internasional meluncurkan program konservasi, yang dampaknya dirasakan oleh komunitas lokal yang tanahnya terancam oleh deforestasi. Kota besar modern membangun taman ekologis, di mana masyarakat dapat belajar tentang pentingnya menjaga keanekaragaman hayati. Tahun 2015 adalah titik penting, ketika negara-negara menandatangani Perjanjian Paris untuk mengurangi emisi karbon. Universitas riset global mendirikan pusat inovasi, yang penelitiannya berfokus pada pengembangan energi terbarukan. Banyak ahli menjelaskan alasan, mengapa kesadaran lingkungan harus ditingkatkan melalui pendidikan sejak usia dini.',
    'en' => 'An international organization launched a conservation program, whose impact is felt by local communities whose land is threatened by deforestation. Modern big cities build ecological parks, where people can learn about the importance of maintaining biodiversity. The year 2015 was an important point, when countries signed the Paris Agreement to reduce carbon emissions. Global research universities establish innovation centers, whose research focuses on renewable energy development. Many experts explain the reason, why environmental awareness must be increased through education from an early age.',
    'vocab' => [
        'Conservation' => 'Konservasi',
        'Impact' => 'Dampak',
        'Deforestation' => 'Deforestasi',
        'Ecological park' => 'Taman ekologis',
        'Biodiversity' => 'Keanekaragaman hayati',
        'Paris Agreement' => 'Perjanjian Paris',
        'Carbon emission' => 'Emisi karbon',
        'Innovation center' => 'Pusat inovasi',
        'Renewable energy' => 'Energi terbarukan',
        'Environmental awareness' => 'Kesadaran lingkungan',
        'Early age' => 'Usia dini'
    ]
];

// Check existing data
$existing = GrammarQuestion::where('meeting_number', 15)->count();
if ($existing > 0) {
    echo "Deleting existing data for Meeting 15 to re-seed...\n";
    GrammarQuestion::where('meeting_number', 15)->delete();
}

// Insert Questions
foreach ($questions as $num => $q) {
    GrammarQuestion::create([
        'meeting_number' => 15,
        'question_number' => $num,
        'question_text' => $q['id'],
        'correct_answer' => $q['en'],
        'vocab' => $q['vocab'],
        'example_id' => $q['example']['id'],
        'example_en' => $q['example']['en'],
    ]);
}
echo "Inserted " . count($questions) . " questions.\n";

// Insert Paragraph
GrammarQuestion::create([
    'meeting_number' => 15,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);
echo "Inserted paragraph.\n";
