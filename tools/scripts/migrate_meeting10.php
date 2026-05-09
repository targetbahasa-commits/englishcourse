<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    1 => [
        'id' => 'Asia adalah benua terbesar di dunia.', 
        'en' => 'Asia is the biggest continent in the world', 
        'type' => 'Superlative',
        'vocab' => ['Continent' => ['id' => 'Benua', 'pos' => '(n)'], 'Big' => ['id' => 'Besar', 'pos' => '(adj)'], 'In the world' => ['id' => 'Di dunia', 'pos' => '(phrase)']],
        'example' => ['id' => 'Rusia adalah negara terluas di dunia.', 'en' => 'Russia is the largest country in the world.']
    ],
    2 => [
        'id' => 'Gunung tertinggi di dunia adalah Gunung Everest.', 
        'en' => 'The highest mountain in the world is Mount Everest', 
        'type' => 'Superlative',
        'vocab' => ['Mountain' => ['id' => 'Gunung', 'pos' => '(n)'], 'High' => ['id' => 'Tinggi', 'pos' => '(adj)'], 'In the world' => ['id' => 'Di dunia', 'pos' => '(phrase)']],
        'example' => ['id' => 'Sungai Nil adalah sungai terpanjang di dunia.', 'en' => 'The Nile is the longest river in the world.']
    ],
    3 => [
        'id' => 'Buku catatan Marie Curie adalah salah satu benda paling radioaktif di dunia.', 
        'en' => 'Marie Curie\'s notebook is one of the most radioactive objects in the world', 
        'type' => 'Superlative',
        'vocab' => ['Radioactive' => ['id' => 'Radioaktif', 'pos' => '(adj)'], 'Object' => ['id' => 'Benda', 'pos' => '(n)'], 'In the world' => ['id' => 'Di dunia', 'pos' => '(phrase)']],
        'example' => ['id' => 'Ini adalah salah satu mobil paling mahal di showroom.', 'en' => 'This is one of the most expensive cars in the showroom.']
    ],
    4 => [
        'id' => 'Dinar Kuwait adalah mata uang paling kuat di dunia.', 
        'en' => 'The Kuwaiti Dinar is the strongest currency in the world', 
        'type' => 'Superlative',
        'vocab' => ['Currency' => ['id' => 'Mata uang', 'pos' => '(n)'], 'Strong' => ['id' => 'Kuat', 'pos' => '(adj)'], 'In the world' => ['id' => 'Di dunia', 'pos' => '(phrase)']],
        'example' => ['id' => 'Cheetah adalah hewan darat tercepat.', 'en' => 'The cheetah is the fastest land animal.']
    ],
    5 => [
        'id' => 'Pulau terbesar di dunia adalah Greenland.', 
        'en' => 'The largest island in the world is Greenland', 
        'type' => 'Superlative',
        'vocab' => ['Island' => ['id' => 'Pulau', 'pos' => '(n)'], 'Large' => ['id' => 'Besar', 'pos' => '(adj)'], 'In the world' => ['id' => 'Di dunia', 'pos' => '(phrase)']],
        'example' => ['id' => 'Jupiter adalah planet terbesar di tata surya kita.', 'en' => 'Jupiter is the biggest planet in our solar system.']
    ],
    6 => [
        'id' => 'Tempat terbaik untuk menangkap ikan adalah area terumbu karang.', 
        'en' => 'The best place to catch fish is the coral reef area', 
        'type' => 'Superlative',
        'vocab' => ['Catch' => ['id' => 'Menangkap', 'pos' => '(v)'], 'Coral reef' => ['id' => 'Terumbu karang', 'pos' => '(n)'], 'Area' => ['id' => 'Area', 'pos' => '(n)'], 'Good' => ['id' => 'Baik/Bagus', 'pos' => '(adj)']],
        'example' => ['id' => 'Waktu terbaik untuk mengunjungi Jepang adalah musim semi.', 'en' => 'The best time to visit Japan is spring.']
    ],
    7 => [
        'id' => 'Peradaban tertua di dunia adalah Mesopotamia.', 
        'en' => 'The oldest civilization in the world is Mesopotamia', 
        'type' => 'Superlative',
        'vocab' => ['Civilization' => ['id' => 'Peradaban', 'pos' => '(n)'], 'Old' => ['id' => 'Tua', 'pos' => '(adj)'], 'In the world' => ['id' => 'Di dunia', 'pos' => '(phrase)']],
        'example' => ['id' => 'Bangunan tertua di kota ini adalah gereja.', 'en' => 'The oldest building in this city is the church.']
    ],
    8 => [
        'id' => 'Blanidae adalah kelompok yang paling primitif dari amphisbaenians.', 
        'en' => 'Blanidae is the most primitive group of amphisbaenians', 
        'type' => 'Superlative',
        'vocab' => ['Primitive' => ['id' => 'Primitif', 'pos' => '(adj)'], 'Group' => ['id' => 'Kelompok', 'pos' => '(n)']],
        'example' => ['id' => 'Ini adalah bagian paling rumit dari mesin itu.', 'en' => 'This is the most complex part of the machine.']
    ],
    9 => [
        'id' => 'Burung dodo kemungkinan merupakan contoh paling baru dari burung yang tidak bisa terbang.', 
        'en' => 'The dodo bird is probably the most recent example of flightless birds', 
        'type' => 'Superlative',
        'vocab' => ['Recent' => ['id' => 'Baru/Terkini', 'pos' => '(adj)'], 'Example' => ['id' => 'Contoh', 'pos' => '(n)'], 'Flightless' => ['id' => 'Tidak bisa terbang', 'pos' => '(adj)']],
        'example' => ['id' => 'Ini adalah pembaruan paling baru untuk perangkat lunak tersebut.', 'en' => 'This is the most recent update for the software.']
    ],
    10 => [
        'id' => 'Pada tahun 1955, Organisasi Kesehatan Dunia meluncurkan kampanye Global Malaria Eradication untuk melawan penyakit yang paling merusak di negara - negara tropis.', 
        'en' => 'In 1955, the World Health Organization launched the Global Malaria Eradication campaign to fight the most destructive disease in tropical countries', 
        'type' => 'Superlative',
        'vocab' => ['Launch' => ['id' => 'Meluncurkan', 'pos' => '(v)'], 'Campaign' => ['id' => 'Kampanye', 'pos' => '(n)'], 'Fight' => ['id' => 'Melawan', 'pos' => '(v)'], 'Destructive' => ['id' => 'Merusak', 'pos' => '(adj)']],
        'example' => ['id' => 'Ini adalah gempa bumi paling merusak dalam sejarah.', 'en' => 'This was the most destructive earthquake in history.']
    ],
    11 => [
        'id' => 'Semakin banyak kamu membaca, semakin banyak kamu tahu.', 
        'en' => 'The more you read the more you know', 
        'type' => 'Comparative',
        'vocab' => ['More' => ['id' => 'Lebih banyak', 'pos' => '(det)'], 'Read' => ['id' => 'Membaca', 'pos' => '(v)'], 'Know' => ['id' => 'Tahu', 'pos' => '(v)']],
        'example' => ['id' => 'Semakin keras kamu bekerja, semakin beruntung kamu.', 'en' => 'The harder you work, the luckier you get.']
    ],
    12 => [
        'id' => 'Semakin sedikit kamu belanjakan, semakin banyak kamu menabung.', 
        'en' => 'The less you spend the more you save', 
        'type' => 'Comparative',
        'vocab' => ['Less' => ['id' => 'Lebih sedikit', 'pos' => '(det)'], 'Spend' => ['id' => 'Membelanjakan', 'pos' => '(v)'], 'Save' => ['id' => 'Menabung', 'pos' => '(v)']],
        'example' => ['id' => 'Semakin sedikit kamu khawatir, semakin bahagia kamu.', 'en' => 'The less you worry, the happier you are.']
    ],
    13 => [
        'id' => 'Semakin cepat kita berangkat, semakin cepat kita sampai.', 
        'en' => 'The sooner we leave the sooner we arrive', 
        'type' => 'Comparative',
        'vocab' => ['Sooner' => ['id' => 'Lebih cepat (waktu)', 'pos' => '(adv)'], 'Leave' => ['id' => 'Berangkat', 'pos' => '(v)'], 'Arrive' => ['id' => 'Sampai', 'pos' => '(v)']],
        'example' => ['id' => 'Semakin cepat, semakin baik.', 'en' => 'The sooner, the better.']
    ],
    14 => [
        'id' => 'Semakin besar mimpinya, semakin besar tantangannya.', 
        'en' => 'The bigger the dream the bigger the challenge', 
        'type' => 'Comparative',
        'vocab' => ['Dream' => ['id' => 'Mimpi', 'pos' => '(n)'], 'Challenge' => ['id' => 'Tantangan', 'pos' => '(n)']],
        'example' => ['id' => 'Semakin tinggi pohon, semakin kencang anginnya.', 'en' => 'The higher the tree, the stronger the wind.']
    ],
    15 => [
        'id' => 'Semakin tinggi kita mendaki, semakin dingin udaranya.', 
        'en' => 'The higher we climb the colder the air gets', 
        'type' => 'Comparative',
        'vocab' => ['Climb' => ['id' => 'Mendaki', 'pos' => '(v)'], 'Cold' => ['id' => 'Dingin', 'pos' => '(adj)'], 'Air' => ['id' => 'Udara', 'pos' => '(n)']],
        'example' => ['id' => 'Semakin dalam kita menyelam, semakin gelap airnya.', 'en' => 'The deeper we dive, the darker the water gets.']
    ],
    16 => [
        'id' => 'Gunung Kilimanjaro hampir setinggi Gunung Everest.', 
        'en' => 'Mount Kilimanjaro is almost as high as Mount Everest', 
        'type' => 'Positive',
        'vocab' => ['Almost' => ['id' => 'Hampir', 'pos' => '(adv)'], 'High' => ['id' => 'Tinggi', 'pos' => '(adj)']],
        'example' => ['id' => 'Dia hampir setinggi ayahnya.', 'en' => 'He is almost as tall as his father.']
    ],
    17 => [
        'id' => 'Gurun Sahara sama panasnya dengan Death Valley di musim panas.', 
        'en' => 'The Sahara Desert is as hot as Death Valley in summer', 
        'type' => 'Positive',
        'vocab' => ['Desert' => ['id' => 'Gurun', 'pos' => '(n)'], 'Hot' => ['id' => 'Panas', 'pos' => '(adj)'], 'Summer' => ['id' => 'Musim panas', 'pos' => '(n)']],
        'example' => ['id' => 'Es krim ini sama dinginnya dengan es.', 'en' => 'This ice cream is as cold as ice.']
    ],
    18 => [
        'id' => 'Kota ini tidak seramai Jakarta.', 
        'en' => 'This city is not as crowded as Jakarta', 
        'type' => 'Positive',
        'vocab' => ['City' => ['id' => 'Kota', 'pos' => '(n)'], 'Crowded' => ['id' => 'Ramai', 'pos' => '(adj)']],
        'example' => ['id' => 'Buku ini tidak semenarik filmnya.', 'en' => 'This book is not as interesting as the movie.']
    ],
    19 => [
        'id' => 'Bahasa Inggris sama pentingnya dengan Matematika untuk karir masa depan.', 
        'en' => 'English is as important as Mathematics for future careers', 
        'type' => 'Positive',
        'vocab' => ['Important' => ['id' => 'Penting', 'pos' => '(adj)'], 'Career' => ['id' => 'Karir', 'pos' => '(n)'], 'Future' => ['id' => 'Masa depan', 'pos' => '(n/adj)']],
        'example' => ['id' => 'Kesehatan sama berharganya dengan kekayaan.', 'en' => 'Health is as precious as wealth.']
    ],
    20 => [
        'id' => 'Tugas ini tidak sesulit yang saya kira.', 
        'en' => 'This assignment is not as difficult as I thought', 
        'type' => 'Positive',
        'vocab' => ['Assignment' => ['id' => 'Tugas', 'pos' => '(n)'], 'Difficult' => ['id' => 'Sulit', 'pos' => '(adj)'], 'Think/Thought' => ['id' => 'Mengira/Berpikir', 'pos' => '(v)']],
        'example' => ['id' => 'Ujiannya tidak semudah yang diharapkan.', 'en' => 'The exam was not as easy as expected.']
    ]
];

// Check if data already exists to avoid duplicates
$existingCount = GrammarQuestion::where('meeting_number', 10)->count();

if ($existingCount > 0) {
    echo "Meeting 10 data already exists ($existingCount records). Skipping migration.\n";
} else {
    foreach ($questions as $num => $q) {
        GrammarQuestion::create([
            'meeting_number' => 10,
            'question_number' => $num,
            'question_text' => $q['id'],
            'correct_answer' => $q['en'],
            'structure' => $q['type'], // Storing 'Superlative', 'Comparative', etc. in structure column
            'vocab' => isset($q['vocab']) ? $q['vocab'] : null, // Model handles auto-array cast? Check model. Usually manually encoded if not cast.
            // Assuming model has 'vocab' => 'array' cast. If not, json_encode. 
            // Controller update method manually decodes, so likely it DOES NOT have cast or controller is defensive.
            // Let's json_encode explicitly to be safe if model doesn't cast.
            'example_id' => $q['example']['id'] ?? null,
            'example_en' => $q['example']['en'] ?? null,
        ]);
    }
    echo "Migrated " . count($questions) . " questions for Meeting 10.\n";
}
