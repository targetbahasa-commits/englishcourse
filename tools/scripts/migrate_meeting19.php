<?php

use App\Models\GrammarQuestion;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Data Definition
$questions = [
    1 => [
        'id' => 'Koleksi museum itu terlalu berharga untuk dipindahkan.',
        'en' => 'The museum collection is too valuable to be moved',
        'type' => 'Degree Adverb',
        'adverb' => 'too',
        'example' => ['id' => 'Kopi ini terlalu panas untuk diminum.', 'en' => 'This coffee is too hot to drink.'],
        'vocab' => [
            'Collection' => ['id' => 'Koleksi', 'pos' => '(n)'],
            'Valuable' => ['id' => 'Berharga', 'pos' => '(adj)'],
            'Move' => ['id' => 'Dipindahkan', 'pos' => '(v)']
        ]
    ],
    2 => [
        'id' => 'Sayangnya, banyak situs arkeologi hilang akibat pembangunan modern.',
        'en' => 'Unfortunately, many archaeological sites are lost due to modern development',
        'type' => 'Sentence Adverb',
        'adverb' => 'unfortunately',
        'example' => ['id' => 'Sayangnya, cuaca buruk hari ini.', 'en' => 'Unfortunately, the weather is bad today.'],
        'vocab' => [
            'Archaeological site' => ['id' => 'Situs arkeologi', 'pos' => '(n)'],
            'Lost' => ['id' => 'Hilang', 'pos' => '(adj)'],
            'Development' => ['id' => 'Pembangunan', 'pos' => '(n)']
        ]
    ],
    3 => [
        'id' => 'Para peneliti bekerja sangat hati-hati di laboratorium biologi molekuler.',
        'en' => 'Researchers work very carefully in the molecular biology laboratory',
        'type' => 'Intensifier + Manner Adverb',
        'adverb' => 'very carefully',
        'example' => ['id' => 'Dia membaca sangat hati-hati.', 'en' => 'He reads very carefully.'],
        'vocab' => [
            'Researcher' => ['id' => 'Peneliti', 'pos' => '(n)'],
            'Carefully' => ['id' => 'Hati-hati', 'pos' => '(adv)'],
            'Laboratory' => ['id' => 'Laboratorium', 'pos' => '(n)']
        ]
    ],
    4 => [
        'id' => 'Sungai itu tampak sangat kotor setelah banjir besar.',
        'en' => 'The river looks very dirty after the big flood',
        'type' => 'Degree Adverb',
        'adverb' => 'very',
        'example' => ['id' => 'Dia sangat pintar.', 'en' => 'She is very smart.'],
        'vocab' => [
            'River' => ['id' => 'Sungai', 'pos' => '(n)'],
            'Dirty' => ['id' => 'Kotor', 'pos' => '(adj)'],
            'Flood' => ['id' => 'Banjir', 'pos' => '(n)']
        ]
    ],
    5 => [
        'id' => 'Tim ekspedisi cepat menanggapi perubahan cuaca di gunung tinggi.',
        'en' => 'The expedition team quickly responds to weather changes in the high mountains',
        'type' => 'Manner Adverb',
        'adverb' => 'quickly',
        'example' => ['id' => 'Dia berlari cepat.', 'en' => 'He runs quickly.'],
        'vocab' => [
            'Expedition' => ['id' => 'Ekspedisi', 'pos' => '(n)'],
            'Respond' => ['id' => 'Menanggapi', 'pos' => '(v)'],
            'Weather change' => ['id' => 'Perubahan cuaca', 'pos' => '(n)']
        ]
    ],
    6 => [
        'id' => 'Gelombang radio diterima cukup jelas oleh antena komunikasi.',
        'en' => 'Radio waves are received quite clearly by communication antennas',
        'type' => 'Intensifier + Manner Adverb',
        'adverb' => 'quite clearly',
        'example' => ['id' => 'Dia berbicara cukup jelas.', 'en' => 'She speaks quite clearly.'],
        'vocab' => [
            'Radio wave' => ['id' => 'Gelombang radio', 'pos' => '(n)'],
            'Receive' => ['id' => 'Diterima', 'pos' => '(v)'],
            'Antenna' => ['id' => 'Antena', 'pos' => '(n)']
        ]
    ],
    7 => [
        'id' => 'Memang, urbanisasi memengaruhi struktur sosial di berbagai kota besar.',
        'en' => 'Indeed, urbanization affects social structures in various large cities',
        'type' => 'Sentence Adverb',
        'adverb' => 'indeed',
        'example' => ['id' => 'Memang, ini masalah serius.', 'en' => 'Indeed, this is a serious problem.'],
        'vocab' => [
            'Urbanization' => ['id' => 'Urbanisasi', 'pos' => '(n)'],
            'Affect' => ['id' => 'Memengaruhi', 'pos' => '(v)'],
            'Social structure' => ['id' => 'Struktur sosial', 'pos' => '(n)']
        ]
    ],
    8 => [
        'id' => 'Observatorium berada di lokasi sangat strategis di puncak gunung.',
        'en' => 'The observatory is located in a very strategic location at the mountain peak',
        'type' => 'Degree Adverb',
        'adverb' => 'very',
        'example' => ['id' => 'Ini sangat penting.', 'en' => 'This is very important.'],
        'vocab' => [
            'Observatory' => ['id' => 'Observatorium', 'pos' => '(n)'],
            'Strategic' => ['id' => 'Strategis', 'pos' => '(adj)'],
            'Peak' => ['id' => 'Puncak', 'pos' => '(n)']
        ]
    ],
    9 => [
        'id' => 'Mesin itu lambat memproses data karena keterbatasan daya.',
        'en' => 'The machine slowly processes data due to power limitations',
        'type' => 'Manner Adverb',
        'adverb' => 'slowly',
        'example' => ['id' => 'Dia berjalan lambat.', 'en' => 'He walks slowly.'],
        'vocab' => [
            'Machine' => ['id' => 'Mesin', 'pos' => '(n)'],
            'Process' => ['id' => 'Memproses', 'pos' => '(v)'],
            'Limitation' => ['id' => 'Keterbatasan', 'pos' => '(n)']
        ]
    ],
    10 => [
        'id' => 'Masalah sampah plastik menjadi amat serius di perkotaan modern.',
        'en' => 'The plastic waste problem becomes extremely serious in modern cities',
        'type' => 'Degree Adverb',
        'adverb' => 'extremely',
        'example' => ['id' => 'Ini amat sulit.', 'en' => 'This is extremely difficult.'],
        'vocab' => [
            'Plastic waste' => ['id' => 'Sampah plastik', 'pos' => '(n)'],
            'Serious' => ['id' => 'Serius', 'pos' => '(adj)'],
            'Modern city' => ['id' => 'Perkotaan modern', 'pos' => '(n)']
        ]
    ],
    11 => [
        'id' => 'Untungnya, vaksin baru berhasil menekan penyebaran penyakit.',
        'en' => 'Fortunately, the new vaccine successfully suppresses disease spread',
        'type' => 'Sentence Adverb + Manner Adverb',
        'adverb' => 'fortunately, successfully',
        'example' => ['id' => 'Untungnya, dia berhasil lulus ujian.', 'en' => 'Fortunately, he successfully passed the exam.'],
        'vocab' => [
            'Vaccine' => ['id' => 'Vaksin', 'pos' => '(n)'],
            'Suppress' => ['id' => 'Menekan', 'pos' => '(v)'],
            'Disease spread' => ['id' => 'Penyebaran penyakit', 'pos' => '(n)']
        ]
    ],
    12 => [
        'id' => 'Para ilmuwan teliti mengamati perilaku burung migran.',
        'en' => 'Scientists carefully observe migratory bird behavior',
        'type' => 'Manner Adverb',
        'adverb' => 'carefully',
        'example' => ['id' => 'Dia teliti memeriksa dokumen.', 'en' => 'She carefully checks the documents.'],
        'vocab' => [
            'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
            'Observe' => ['id' => 'Mengamati', 'pos' => '(v)'],
            'Migratory bird' => ['id' => 'Burung migran', 'pos' => '(n)']
        ]
    ],
    13 => [
        'id' => 'Perubahan suhu di gurun terasa amat tiba-tiba pada malam hari.',
        'en' => 'Temperature changes in the desert feel extremely sudden at night',
        'type' => 'Degree Adverb',
        'adverb' => 'extremely',
        'example' => ['id' => 'Perubahan itu amat cepat.', 'en' => 'The change is extremely fast.'],
        'vocab' => [
            'Temperature' => ['id' => 'Suhu', 'pos' => '(n)'],
            'Desert' => ['id' => 'Gurun', 'pos' => '(n)'],
            'Sudden' => ['id' => 'Tiba-tiba', 'pos' => '(adj)']
        ]
    ],
    14 => [
        'id' => 'Pusat penelitian itu rutin mengadakan konferensi internasional.',
        'en' => 'The research center regularly holds international conferences',
        'type' => 'Manner Adverb',
        'adverb' => 'regularly',
        'example' => ['id' => 'Dia rutin berolahraga.', 'en' => 'He regularly exercises.'],
        'vocab' => [
            'Research center' => ['id' => 'Pusat penelitian', 'pos' => '(n)'],
            'Hold' => ['id' => 'Mengadakan', 'pos' => '(v)'],
            'Conference' => ['id' => 'Konferensi', 'pos' => '(n)']
        ]
    ],
    15 => [
        'id' => 'Data genetika dianggap sangat penting untuk memahami evolusi.',
        'en' => 'Genetic data is considered very important for understanding evolution',
        'type' => 'Degree Adverb',
        'adverb' => 'very',
        'example' => ['id' => 'Ini sangat berguna.', 'en' => 'This is very important.'],
        'vocab' => [
            'Genetic data' => ['id' => 'Data genetika', 'pos' => '(n)'],
            'Consider' => ['id' => 'Dianggap', 'pos' => '(v)'],
            'Evolution' => ['id' => 'Evolusi', 'pos' => '(n)']
        ]
    ],
    16 => [
        'id' => 'Secara umum, teknologi digital meningkatkan efisiensi komunikasi global.',
        'en' => 'Generally, digital technology increases global communication efficiency',
        'type' => 'Sentence Adverb',
        'adverb' => 'generally',
        'example' => ['id' => 'Secara umum, ini benar.', 'en' => 'Generally, this is true.'],
        'vocab' => [
            'Digital technology' => ['id' => 'Teknologi digital', 'pos' => '(n)'],
            'Increase' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
            'Efficiency' => ['id' => 'Efisiensi', 'pos' => '(n)']
        ]
    ],
    17 => [
        'id' => 'Para dokter cermat mendiagnosis pasien dengan metode modern.',
        'en' => 'Doctors carefully diagnose patients with modern methods',
        'type' => 'Manner Adverb',
        'adverb' => 'carefully',
        'example' => ['id' => 'Dia cermat menganalisis data.', 'en' => 'She carefully analyzes data.'],
        'vocab' => [
            'Doctor' => ['id' => 'Dokter', 'pos' => '(n)'],
            'Diagnose' => ['id' => 'Mendiagnosis', 'pos' => '(v)'],
            'Method' => ['id' => 'Metode', 'pos' => '(n)']
        ]
    ],
    18 => [
        'id' => 'Hujan deras menyebabkan sungai meluap sangat cepat.',
        'en' => 'Heavy rain causes the river to overflow very quickly',
        'type' => 'Intensifier + Manner Adverb',
        'adverb' => 'very quickly',
        'example' => ['id' => 'Dia berlari sangat cepat.', 'en' => 'He runs very quickly.'],
        'vocab' => [
            'Heavy rain' => ['id' => 'Hujan deras', 'pos' => '(n)'],
            'Overflow' => ['id' => 'Meluap', 'pos' => '(v)'],
            'Quickly' => ['id' => 'Cepat', 'pos' => '(adv)']
        ]
    ],
    19 => [
        'id' => 'Anehnya, fosil kuno ditemukan di lokasi yang jauh dari lautan.',
        'en' => 'Surprisingly, ancient fossils are found in locations far from the ocean',
        'type' => 'Sentence Adverb',
        'adverb' => 'surprisingly',
        'example' => ['id' => 'Anehnya, dia tidak datang.', 'en' => 'Surprisingly, he did not come.'],
        'vocab' => [
            'Fossil' => ['id' => 'Fosil', 'pos' => '(n)'],
            'Ancient' => ['id' => 'Kuno', 'pos' => '(adj)'],
            'Ocean' => ['id' => 'Lautan', 'pos' => '(n)']
        ]
    ],
    20 => [
        'id' => 'Data satelit ditransmisikan cukup cepat ke pusat kendali bumi.',
        'en' => 'Satellite data is transmitted quite quickly to the earth control center',
        'type' => 'Intensifier + Manner Adverb',
        'adverb' => 'quite quickly',
        'example' => ['id' => 'Dia bekerja cukup cepat.', 'en' => 'She works quite quickly.'],
        'vocab' => [
            'Satellite' => ['id' => 'Satelit', 'pos' => '(n)'],
            'Transmit' => ['id' => 'Ditransmisikan', 'pos' => '(v)'],
            'Control center' => ['id' => 'Pusat kendali', 'pos' => '(n)']
        ]
    ]
];

$paragraph = [
    'id' => 'Memang, urbanisasi memengaruhi struktur sosial di berbagai kota besar, dan secara umum, teknologi digital meningkatkan efisiensi komunikasi global. Namun, sayangnya, banyak situs arkeologi hilang akibat pembangunan modern, meskipun beberapa koleksi museum tetap terlalu berharga untuk dipindahkan. Para ilmuwan teliti mengamati perilaku burung migran, sementara pusat penelitian rutin mengadakan konferensi internasional guna membahas isu lingkungan. Sungai besar tampak sangat kotor setelah banjir besar, dan hujan deras dapat membuat alirannya meluap sangat cepat. Anehnya, fosil kuno ditemukan di lokasi yang jauh dari lautan, sedangkan observatorium ditempatkan di lokasi sangat strategis di puncak gunung. Tim ekspedisi cepat menanggapi perubahan cuaca di dataran tinggi, dan para dokter cermat mendiagnosis pasien dengan metode modern. Data genetika dianggap sangat penting untuk memahami evolusi, dan masalah sampah plastik kini amat serius di perkotaan modern. Untungnya, vaksin baru berhasil menekan penyebaran penyakit, sementara data satelit ditransmisikan cukup cepat ke pusat kendali bumi. Gelombang radio bahkan diterima cukup jelas oleh antena komunikasi, meskipun perubahan suhu di gurun terasa amat tiba-tiba pada malam hari.',
    'en' => 'Indeed, urbanization affects social structures in various large cities, and generally, digital technology increases global communication efficiency. However, unfortunately, many archaeological sites are lost due to modern development, although some museum collections remain too valuable to be moved. Scientists carefully observe migratory bird behavior, while research centers regularly hold international conferences to discuss environmental issues. Large rivers look very dirty after major floods, and heavy rain can cause them to overflow very quickly. Surprisingly, ancient fossils are found in locations far from the ocean, while observatories are placed in very strategic locations at mountain peaks. Expedition teams quickly respond to weather changes in the highlands, and doctors carefully diagnose patients with modern methods. Genetic data is considered very important for understanding evolution, and the plastic waste problem is now extremely serious in modern cities. Fortunately, new vaccines successfully suppress disease spread, while satellite data is transmitted quite quickly to earth control centers. Radio waves are even received quite clearly by communication antennas, although temperature changes in the desert feel extremely sudden at night.',
    'vocab' => [
        'Urbanization' => 'Urbanisasi',
        'Affect' => 'Memengaruhi',
        'Archaeological site' => 'Situs arkeologi',
        'Valuable' => 'Berharga',
        'Carefully' => 'Teliti/hati-hati',
        'Migratory bird' => 'Burung migran',
        'Regularly' => 'Rutin',
        'Environmental issue' => 'Isu lingkungan',
        'Overflow' => 'Meluap',
        'Fossil' => 'Fosil',
        'Observatory' => 'Observatorium',
        'Strategic' => 'Strategis',
        'Expedition' => 'Ekspedisi',
        'Diagnose' => 'Mendiagnosis',
        'Genetic data' => 'Data genetika',
        'Evolution' => 'Evolusi',
        'Plastic waste' => 'Sampah plastik',
        'Suppress' => 'Menekan',
        'Transmit' => 'Mentransmisikan'
    ]
];

// Clean up existing Meeting 19 data
GrammarQuestion::where('meeting_number', 19)->delete();

// Insert Questions
foreach ($questions as $num => $q) {
     // Inject type and adverb into vocab for retrieval
    $vocab = $q['vocab'];
    $vocab['_type'] = $q['type'];
    $vocab['_adverb'] = $q['adverb'];

    GrammarQuestion::create([
        'meeting_number' => 19,
        'question_number' => $num,
        'question_text' => $q['id'],
        'correct_answer' => $q['en'],
        'vocab' => $vocab,
        'example_id' => $q['example']['id'],
        'example_en' => $q['example']['en'],
    ]);
}

// Insert Paragraph
GrammarQuestion::create([
    'meeting_number' => 19,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);

echo "Meeting 19 migration completed successfully.\n";
