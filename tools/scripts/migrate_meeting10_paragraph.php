<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meeting10Paragraph = [
    'id' => 'Gunung Everest adalah gunung tertinggi di dunia, dan mendakinya adalah salah satu tantangan paling berbahaya bagi para petualang. Meskipun K2 dianggap lebih sulit didaki daripada Everest, Everest tetap menjadi tujuan paling populer. Cuaca di sana lebih ekstrem dibandingkan di pegunungan Alps, dengan angin yang bertiup secepat badai. Biaya ekspedisi ini juga lebih mahal daripada liburan mewah biasa. Namun, pemandangan dari puncaknya adalah hal terindah yang pernah dilihat oleh banyak pendaki. Sherpa adalah pemandu paling tangguh yang membantu pendaki mencapai puncak dengan selamat. Persiapan fisik harus dilakukan seintensif mungkin, karena kadar oksigen di sana jauh lebih rendah daripada di permukaan laut. Bagi mereka yang berhasil, pengalaman ini lebih berharga daripada uang. Everest bukan hanya gunung terbesar, tetapi juga simbol ketahanan manusia yang paling agung.',
    'en' => 'Mount Everest is the highest mountain in the world, and climbing it is one of the most dangerous challenges for adventurers. Although K2 is considered harder to climb than Everest, Everest remains the most popular destination. The weather there is more extreme than in the Alps, with winds blowing as fast as storms. The cost of this expedition is also more expensive than a regular luxury vacation. However, the view from the summit is the most beautiful thing many climbers have ever seen. Sherpas are the toughest guides who help climbers reach the peak safely. Physical preparation must be done as intensively as possible, because the oxygen level there is much lower than at sea level. For those who succeed, this experience is more valuable than money. Everest is not just the biggest mountain, but also the grandest symbol of human resilience.',
    'vocab' => [
        'Dangerous' => ['id' => 'Berbahaya', 'pos' => '(adj)'],
        'Adventurer' => ['id' => 'Petualang', 'pos' => '(n)'],
        'Considered' => ['id' => 'Dianggap', 'pos' => '(v)'],
        'Destination' => ['id' => 'Tujuan', 'pos' => '(n)'],
        'Extreme' => ['id' => 'Ekstrem', 'pos' => '(adj)'],
        'Blowing' => ['id' => 'Bertiup', 'pos' => '(v)'],
        'Storm' => ['id' => 'Badai', 'pos' => '(n)'],
        'Luxury' => ['id' => 'Mewah', 'pos' => '(adj)'],
        'Summit' => ['id' => 'Puncak', 'pos' => '(n)'],
        'Tough' => ['id' => 'Tangguh', 'pos' => '(adj)'],
        'Guide' => ['id' => 'Pemandu', 'pos' => '(n)'],
        'Intensively' => ['id' => 'Secara intensif', 'pos' => '(adv)'],
        'Oxygen level' => ['id' => 'Kadar oksigen', 'pos' => '(n)'],
        'Sea level' => ['id' => 'Permukaan laut', 'pos' => '(n)'],
        'Valuable' => ['id' => 'Berharga', 'pos' => '(adj)'],
        'Resilience' => ['id' => 'Ketahanan', 'pos' => '(n)'],
        'Grand' => ['id' => 'Agung', 'pos' => '(adj)']
    ]
];

// Check if data already exists to avoid duplicates
$existing = GrammarQuestion::where('meeting_number', 10)
                           ->where('section', 'paragraph')
                           ->first();

if ($existing) {
    echo "Meeting 10 paragraph data already exists. Updating if needed...\n";
} else {
    GrammarQuestion::create([
        'meeting_number' => 10,
        'question_number' => 1,
        'section' => 'paragraph',
        'question_type' => 'paragraph',
        'question_text' => $meeting10Paragraph['id'],
        'correct_answer' => $meeting10Paragraph['en'],
        'vocab' => $meeting10Paragraph['vocab'],
    ]);
    echo "Migrated Meeting 10 paragraph.\n";
}
