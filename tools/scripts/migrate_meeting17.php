<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    1 => [
        'id' => 'NASA masih belum membuktikan secara visual apakah (whether) Mars mengandung air saat ini.',
        'en' => 'NASA has not yet visually proven whether Mars contains water at present',
        'example' => ['id' => 'Para ilmuwan belum membuktikan secara eksperimental apakah Jupiter memiliki inti padat.', 'en' => 'Scientists have not yet experimentally proven whether Jupiter has a solid core.'],
        'vocab' => [
            'Prove' => ['id' => 'Membuktikan', 'pos' => '(v)'],
            'Visually' => ['id' => 'Secara visual', 'pos' => '(adv)'],
            'Contain' => ['id' => 'Mengandung', 'pos' => '(v)'],
            'Water' => ['id' => 'Air', 'pos' => '(n)'],
            'At present' => ['id' => 'Saat ini', 'pos' => '(adv)']
        ]
    ],
    2 => [
        'id' => 'Kita tidak bisa mengasumsikan bahwa suhu Bumi akan bisa menurun secara sendirinya.',
        'en' => 'We cannot assume that Earth\'s temperature will decrease on its own',
        'example' => ['id' => 'Mereka tidak bisa mengasumsikan bahwa populasi hewan akan meningkat secara alami.', 'en' => 'They cannot assume that animal populations will increase naturally.'],
        'vocab' => [
            'Assume' => ['id' => 'Mengasumsikan', 'pos' => '(v)'],
            'Temperature' => ['id' => 'Suhu', 'pos' => '(n)'],
            'Decrease' => ['id' => 'Menurun', 'pos' => '(v)'],
            'On its own' => ['id' => 'Secara sendirinya', 'pos' => '(adv)']
        ]
    ],
    3 => [
        'id' => 'Banyak orang bertanya-tanya apakah kehidupan ada di planet lain.',
        'en' => 'Many people wonder whether life exists on other planets',
        'example' => ['id' => 'Beberapa peneliti bertanya-tanya apakah air ada di bulan Saturnus.', 'en' => 'Some researchers wonder whether water exists on Saturn\'s moons.'],
        'vocab' => [
            'Wonder' => ['id' => 'Bertanya-tanya', 'pos' => '(v)'],
            'Life' => ['id' => 'Kehidupan', 'pos' => '(n)'],
            'Exist' => ['id' => 'Ada', 'pos' => '(v)'],
            'Planet' => ['id' => 'Planet', 'pos' => '(n)']
        ]
    ],
    4 => [
        'id' => 'Jika sebuah populasi dari sebuah spesies menjadi terisolasi, mereka berpisah dalam apa yang disebut spesiasi.',
        'en' => 'If a population of a species becomes isolated, they separate in what is called speciation',
        'example' => ['id' => 'Ketika sebuah kelompok dari sebuah organisme menjadi terpisah, mereka berkembang dalam apa yang disebut adaptasi.', 'en' => 'When a group of an organism becomes separated, they develop in what is called adaptation.'],
        'vocab' => [
            'Population' => ['id' => 'Populasi', 'pos' => '(n)'],
            'Species' => ['id' => 'Spesies', 'pos' => '(n)'],
            'Isolated' => ['id' => 'Terisolasi', 'pos' => '(adj)'],
            'Separate' => ['id' => 'Berpisah', 'pos' => '(v)'],
            'Speciation' => ['id' => 'Spesiasi', 'pos' => '(n)']
        ]
    ],
    5 => [
        'id' => 'Negara mana yang akan menjadi tujuan migrasi adalah suatu fenomena yang masih diperdebatkan.',
        'en' => 'Which country will become a migration destination is a phenomenon that is still debated',
        'example' => ['id' => 'Pulau mana yang akan menjadi habitat terakhir adalah suatu misteri yang masih dipelajari.', 'en' => 'Which island will become the last habitat is a mystery that is still being studied.'],
        'vocab' => [
            'Country' => ['id' => 'Negara', 'pos' => '(n)'],
            'Destination' => ['id' => 'Tujuan', 'pos' => '(n)'],
            'Migration' => ['id' => 'Migrasi', 'pos' => '(n)'],
            'Phenomenon' => ['id' => 'Fenomena', 'pos' => '(n)'],
            'Debated' => ['id' => 'Diperdebatkan', 'pos' => '(v)']
        ]
    ],
    6 => [
        'id' => 'Bagaimana orang mesir kuno membangun piramida giza masih menjadi perdebatan dari para ahli sejarah.',
        'en' => 'How the ancient Egyptians built the Giza pyramids is still a matter of debate among historians',
        'example' => ['id' => 'Bagaimana suku Maya kuno membangun kota Tikal masih menjadi perdebatan dari para ahli arkeologi.', 'en' => 'How the ancient Maya built the city of Tikal is still a matter of debate among archaeologists.'],
        'vocab' => [
            'Ancient' => ['id' => 'Kuno', 'pos' => '(adj)'],
            'Egyptian' => ['id' => 'Mesir', 'pos' => '(n)'],
            'Build' => ['id' => 'Membangun', 'pos' => '(v)'],
            'Pyramid' => ['id' => 'Piramida', 'pos' => '(n)'],
            'Debate' => ['id' => 'Perdebatan', 'pos' => '(n)'],
            'Historian' => ['id' => 'Ahli sejarah', 'pos' => '(n)']
        ]
    ],
    7 => [
        'id' => 'Bahwa manusia tidak menyebabkan kepunahan banyak spesies adalah peremehan.',
        'en' => 'That humans do not cause the extinction of many species is an understatement',
        'example' => ['id' => 'Bahwa teknologi tidak menyebabkan polusi udara adalah kesalahpahaman.', 'en' => 'That technology does not cause air pollution is a misconception.'],
        'vocab' => [
            'Cause' => ['id' => 'Menyebabkan', 'pos' => '(v)'],
            'Extinction' => ['id' => 'Kepunahan', 'pos' => '(n)'],
            'Species' => ['id' => 'Spesies', 'pos' => '(n)'],
            'Understatement' => ['id' => 'Peremehan', 'pos' => '(n)']
        ]
    ],
    8 => [
        'id' => 'Kita mengelompokkan makhluk hidup melalui apa yang disebut taxonomy.',
        'en' => 'We classify living things through what is called taxonomy',
        'example' => ['id' => 'Kita mengorganisir tumbuhan melalui apa yang disebut botani.', 'en' => 'We organize plants through what is called botany.'],
        'vocab' => [
            'Classify' => ['id' => 'Mengelompokkan', 'pos' => '(v)'],
            'Living things' => ['id' => 'Makhluk hidup', 'pos' => '(n)'],
            'Taxonomy' => ['id' => 'Taxonomy', 'pos' => '(n)']
        ]
    ],
    9 => [
        'id' => 'Faktor-faktor yang menentukan bagaimana manusia berinteraksi dengan lingkungan adalah komplek.',
        'en' => 'The factors that determine how humans interact with the environment are complex',
        'example' => ['id' => 'Elemen-elemen yang menentukan bagaimana organisme beradaptasi dengan habitat adalah beragam.', 'en' => 'The elements that determine how organisms adapt to habitats are diverse.'],
        'vocab' => [
            'Factor' => ['id' => 'Faktor', 'pos' => '(n)'],
            'Determine' => ['id' => 'Menentukan', 'pos' => '(v)'],
            'Interact' => ['id' => 'Berinteraksi', 'pos' => '(v)'],
            'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
            'Complex' => ['id' => 'Komplek', 'pos' => '(adj)']
        ]
    ],
    10 => [
        'id' => 'Teori Perdagangan Baru menjelaskan mengapa banyak perdagangan dari ekonomi maju terdiri dari komoditas terbedakan yang dihasilkan dari kondisi kompetisi yang tidak sempurna.',
        'en' => 'New Trade Theory explains why much trade from advanced economies consists of differentiated commodities produced from imperfect competition conditions',
        'example' => ['id' => 'Teori Ekonomi Klasik menjelaskan mengapa banyak transaksi dari pasar bebas terdiri dari barang standar yang dihasilkan dari kondisi persaingan yang sempurna.', 'en' => 'Classical Economic Theory explains why many transactions from free markets consist of standard goods produced from perfect competition conditions.'],
        'vocab' => [
            'Trade' => ['id' => 'Perdagangan', 'pos' => '(n)'],
            'Advanced economy' => ['id' => 'Ekonomi maju', 'pos' => '(n)'],
            'Consist of' => ['id' => 'Terdiri dari', 'pos' => '(v)'],
            'Commodity' => ['id' => 'Komoditas', 'pos' => '(n)'],
            'Differentiated' => ['id' => 'Terbedakan', 'pos' => '(adj)'],
            'Competition' => ['id' => 'Kompetisi', 'pos' => '(n)']
        ]
    ],
    11 => [
        'id' => 'Kapan manusia mulai menghuni Australia masih belum dapat secara akurat ditentukan.',
        'en' => 'When humans began to inhabit Australia has not yet been accurately determined',
        'example' => ['id' => 'Kapan dinosaurus mulai menghuni Amerika masih belum dapat secara pasti ditentukan.', 'en' => 'When dinosaurs began to inhabit America has not yet been certainly determined.'],
        'vocab' => [
            'Inhabit' => ['id' => 'Menghuni', 'pos' => '(v)'],
            'Accurately' => ['id' => 'Secara akurat', 'pos' => '(adv)'],
            'Determined' => ['id' => 'Ditentukan', 'pos' => '(v)']
        ]
    ],
    12 => [
        'id' => 'Di Afrika Barat, dimana sedimen dibuang menyebabkan kerusakan yang signifikan terhadap terumbu karang di pesisir Kenya.',
        'en' => 'In West Africa, where sediment is dumped causes significant damage to coral reefs off the coast of Kenya',
        'example' => ['id' => 'Di Asia Tenggara, dimana limbah dibuang menyebabkan kerusakan yang serius terhadap ekosistem sungai di pesisir Thailand.', 'en' => 'In Southeast Asia, where waste is dumped causes serious damage to river ecosystems off the coast of Thailand.'],
        'vocab' => [
            'Sediment' => ['id' => 'Sedimen', 'pos' => '(n)'],
            'Dump' => ['id' => 'Dibuang', 'pos' => '(v)'],
            'Damage' => ['id' => 'Kerusakan', 'pos' => '(n)'],
            'Significant' => ['id' => 'Signifikan', 'pos' => '(adj)'],
            'Coral reef' => ['id' => 'Terumbu karang', 'pos' => '(n)'],
            'Coast' => ['id' => 'Pesisir', 'pos' => '(n)']
        ]
    ],
    13 => [
        'id' => 'Apa yang mungkin bernilai bagi kita di masa depan adalah hampir mustahil untuk diprediksi.',
        'en' => 'What might be valuable to us in the future is almost impossible to predict',
        'example' => ['id' => 'Apa yang mungkin berguna bagi kita di masa lalu adalah hampir mustahil untuk diingat.', 'en' => 'What might be useful to us in the past is almost impossible to remember.'],
        'vocab' => [
            'Valuable' => ['id' => 'Bernilai', 'pos' => '(adj)'],
            'Future' => ['id' => 'Masa depan', 'pos' => '(n)'],
            'Impossible' => ['id' => 'Mustahil', 'pos' => '(adj)'],
            'Predict' => ['id' => 'Diprediksi', 'pos' => '(v)']
        ]
    ],
    14 => [
        'id' => 'Beberapa merasa bahwa pemerintah dan perusahaan memiliki pengaruh yang lebih besar daripada individu terhadap keanekaragaman hayati lokal dan global.',
        'en' => 'Some feel that governments and companies have a greater influence than individuals on local and global biodiversity',
        'example' => ['id' => 'Beberapa berpendapat bahwa universitas dan institusi memiliki dampak yang lebih besar daripada individu terhadap inovasi teknologi lokal dan global.', 'en' => 'Some argue that universities and institutions have a greater impact than individuals on local and global technological innovation.'],
        'vocab' => [
            'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
            'Company' => ['id' => 'Perusahaan', 'pos' => '(n)'],
            'Influence' => ['id' => 'Pengaruh', 'pos' => '(n)'],
            'Individual' => ['id' => 'Individu', 'pos' => '(n)'],
            'Biodiversity' => ['id' => 'Keanekaragaman hayati', 'pos' => '(n)']
        ]
    ],
    15 => [
        'id' => 'Ini masih belum jelas apakah spesies burung Carolina parakeet bersarang di musim semi atau musim panas.',
        'en' => 'It is still unclear whether the Carolina parakeet bird species nested in spring or summer',
        'example' => ['id' => 'Ini masih belum jelas apakah spesies ikan Coelacanth berkembang biak di musim hujan atau musim kemarau.', 'en' => 'It is still unclear whether the Coelacanth fish species reproduces in rainy season or dry season.'],
        'vocab' => [
            'Unclear' => ['id' => 'Belum jelas', 'pos' => '(adj)'],
            'Bird species' => ['id' => 'Spesies burung', 'pos' => '(n)'],
            'Nest' => ['id' => 'Bersarang', 'pos' => '(v)'],
            'Spring' => ['id' => 'Musim semi', 'pos' => '(n)'],
            'Summer' => ['id' => 'Musim panas', 'pos' => '(n)']
        ]
    ],
    16 => [
        'id' => 'Apa yang terjadi di pada suku Anasazi sebelum abad 12 menjadi bahan perdebatan banyak ahli.',
        'en' => 'What happened to the Anasazi tribe before the 12th century is a matter of debate among many experts',
        'example' => ['id' => 'Apa yang terjadi pada suku Inca sebelum abad 16 menjadi bahan perdebatan banyak sejarawan.', 'en' => 'What happened to the Inca tribe before the 16th century is a matter of debate among many historians.'],
        'vocab' => [
            'Happen' => ['id' => 'Terjadi', 'pos' => '(v)'],
            'Tribe' => ['id' => 'Suku', 'pos' => '(n)'],
            'Century' => ['id' => 'Abad', 'pos' => '(n)'],
            'Matter of debate' => ['id' => 'Bahan perdebatan', 'pos' => '(n)'],
            'Expert' => ['id' => 'Ahli', 'pos' => '(n)']
        ]
    ],
    17 => [
        'id' => 'Apa yang ahli ekonomi acu sebagai sebuah pilihan marginal adalah pilihan untuk memproduksi atau mengkonsumsi jasa atau barang selanjutnya.',
        'en' => 'What economists refer to as a marginal choice is the choice to produce or consume the next service or good',
        'example' => ['id' => 'Apa yang ahli biologi acu sebagai sebuah mutasi genetik adalah perubahan untuk menghasilkan atau mengadaptasi sifat atau karakteristik selanjutnya.', 'en' => 'What biologists refer to as a genetic mutation is the change to produce or adapt the next trait or characteristic.'],
        'vocab' => [
            'Economist' => ['id' => 'Ahli ekonomi', 'pos' => '(n)'],
            'Refer to' => ['id' => 'Acu sebagai', 'pos' => '(v)'],
            'Marginal choice' => ['id' => 'Pilihan marginal', 'pos' => '(n)'],
            'Produce' => ['id' => 'Memproduksi', 'pos' => '(v)'],
            'Consume' => ['id' => 'Mengkonsumsi', 'pos' => '(v)'],
            'Service' => ['id' => 'Jasa', 'pos' => '(n)'],
            'Good' => ['id' => 'Barang', 'pos' => '(n)']
        ]
    ],
    18 => [
        'id' => 'Apa yang ratu lebah konsumsi berbeda dengan apa yang lebah pekerja konsumsi.',
        'en' => 'What the queen bee consumes differs from what worker bees consume',
        'example' => ['id' => 'Apa yang burung hantu konsumsi berbeda dengan apa yang burung elang konsumsi.', 'en' => 'What owls consume differs from what eagles consume.'],
        'vocab' => [
            'Queen bee' => ['id' => 'Ratu lebah', 'pos' => '(n)'],
            'Consume' => ['id' => 'Konsumsi', 'pos' => '(v)'],
            'Differ' => ['id' => 'Berbeda', 'pos' => '(v)'],
            'Worker bee' => ['id' => 'Lebah pekerja', 'pos' => '(n)']
        ]
    ]
];

$paragraph = [
    'id' => 'Banyak orang masih memperdebatkan apakah teknologi nuklir lebih membawa manfaat atau bahaya bagi umat manusia. Beberapa ilmuwan percaya bahwa energi nuklir adalah solusi terbaik untuk krisis energi global, karena efisiensinya yang tinggi dan emisi karbon yang rendah. Namun, masyarakat umum sering kali mengkhawatirkan apa yang bisa terjadi jika terjadi kebocoran reaktor atau penyalahgunaan bahan radioaktif. Fakta bahwa beberapa negara menggunakan teknologi ini untuk membuat senjata pemusnah massal semakin memperkuat rasa takut itu. Oleh karena itu, penting untuk mempertimbangkan bagaimana teknologi ini digunakan dan siapa yang mengendalikannya sebelum memutuskan arah pengembangannya di masa depan.',
    'en' => 'Many people still debate whether nuclear technology brings more benefits or harm to humanity. Some scientists believe that nuclear energy is the best solution to the global energy crisis, because of its high efficiency and low carbon emissions. However, the general public often worries about what could happen if a reactor leak or misuse of radioactive materials occurs. The fact that some countries use this technology to make weapons of mass destruction further reinforces that fear. Therefore, it is important to consider how this technology is used and who controls it before deciding its development direction in the future.',
    'vocab' => [
        'Debate' => ['id' => 'Memperdebatkan', 'pos' => '(v)'],
        'Nuclear technology' => ['id' => 'Teknologi nuklir', 'pos' => '(n)'],
        'Benefit' => ['id' => 'Manfaat', 'pos' => '(n)'],
        'Harm' => ['id' => 'Bahaya', 'pos' => '(n)'],
        'Humanity' => ['id' => 'Umat manusia', 'pos' => '(n)'],
        'Energy crisis' => ['id' => 'Krisis energi', 'pos' => '(n)'],
        'Efficiency' => ['id' => 'Efisiensi', 'pos' => '(n)'],
        'Carbon emission' => ['id' => 'Emisi karbon', 'pos' => '(n)'],
        'Worry' => ['id' => 'Mengkhawatirkan', 'pos' => '(v)'],
        'Reactor leak' => ['id' => 'Kebocoran reaktor', 'pos' => '(n)'],
        'Radioactive material' => ['id' => 'Bahan radioaktif', 'pos' => '(n)'],
        'Weapon of mass destruction' => ['id' => 'Senjata pemusnah massal', 'pos' => '(n)'],
        'Reinforce' => ['id' => 'Memperkuat', 'pos' => '(v)'],
        'Consider' => ['id' => 'Mempertimbangkan', 'pos' => '(v)'],
        'Control' => ['id' => 'Mengendalikan', 'pos' => '(v)'],
        'Future' => ['id' => 'Masa depan', 'pos' => '(n)']
    ]
];

// Check existing data
$existing = GrammarQuestion::where('meeting_number', 17)->count();
if ($existing > 0) {
    echo "Deleting existing data for Meeting 17 to re-seed...\n";
    GrammarQuestion::where('meeting_number', 17)->delete();
}

// Insert Questions
foreach ($questions as $num => $q) {
    GrammarQuestion::create([
        'meeting_number' => 17,
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
    'meeting_number' => 17,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);
echo "Inserted paragraph for Meeting 17.\n";
