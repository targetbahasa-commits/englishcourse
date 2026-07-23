<?php

use App\Models\ToeflMockupQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    [
        'number' => 31,
        'part' => 'Written Expression',
        'question' => 'Dehydrated food is prepared by **removing** water from fresh food **to yield** a relatively dry, stable product **in** which the growth of microorganisms **are** inhibited.',
        'a' => 'removing',
        'b' => 'to yield',
        'c' => 'in',
        'd' => 'are',
        'answer' => 'D'
    ],
    [
        'number' => 32,
        'part' => 'Written Expression',
        'question' => 'Fireworks, combustible or **explosive** preparations **using** for entertainment, were probably **first devised** in **ancient** China.',
        'a' => 'explosive',
        'b' => 'using',
        'c' => 'first devised',
        'd' => 'ancient',
        'answer' => 'B'
    ],
    [
        'number' => 33,
        'part' => 'Written Expression',
        'question' => '**As** a dogfish swims, an S-shaped wave **passes** down its **body** toward its tail to provide **many** of its forward propulsion.',
        'a' => 'As',
        'b' => 'passes',
        'c' => 'body',
        'd' => 'many',
        'answer' => 'D'
    ],
    [
        'number' => 34,
        'part' => 'Written Expression',
        'question' => 'Marshes, wetland **areas characterized** by **plant grassy** growth, are distinguished **from** swamps, wetlands **where trees** grow.',
        'a' => 'areas characterized',
        'b' => 'plant grassy',
        'c' => 'from',
        'd' => 'where trees',
        'answer' => 'B'
    ],
    [
        'number' => 35,
        'part' => 'Written Expression',
        'question' => 'A **documentary film** shapes **factual material** and **interprets it** for purposes of education or **the entertainment**.',
        'a' => 'documentary film',
        'b' => 'factual material',
        'c' => 'interprets it',
        'd' => 'the entertainment',
        'answer' => 'D'
    ],
    [
        'number' => 36,
        'part' => 'Written Expression',
        'question' => '**Native** to South America **and cultivated** there for thousands of years, the peanut **is said** to **have introduced** to North America by early explorers.',
        'a' => 'Native',
        'b' => 'and cultivated',
        'c' => 'is said',
        'd' => 'have introduced',
        'answer' => 'D'
    ],
    [
        'number' => 37,
        'part' => 'Written Expression',
        'question' => 'The igloo, a **temporarily** winter home **built by** the Inuits of Canada and Greenland, **is generally** dome shaped and is usually **made from** blocks of snow.',
        'a' => 'temporarily',
        'b' => 'built by',
        'c' => 'is generally',
        'd' => 'made from',
        'answer' => 'A'
    ],
    [
        'number' => 38,
        'part' => 'Written Expression',
        'question' => 'Boston began a series of urban renewal **project** during the 1960s, **emphasizing** renovation **and modern** architectural **styles harmonious** with the traditional buildings.',
        'a' => 'project',
        'b' => 'emphasizing',
        'c' => 'and modern',
        'd' => 'styles harmonious',
        'answer' => 'A'
    ],
    [
        'number' => 39,
        'part' => 'Written Expression',
        'question' => 'Copper, **a soft** yellowish-red metal whose use **dates back** to prehistoric times, **has been** mined for over 6,000 **years ago**.',
        'a' => 'a soft',
        'b' => 'dates back',
        'c' => 'has been',
        'd' => 'years ago',
        'answer' => 'D'
    ],
    [
        'number' => 40,
        'part' => 'Written Expression',
        'question' => 'In 1999 astronomers **found evidence** of six new planets orbiting distant stars, **bringing to** 28 the number of planets **then known** to exist **out** the solar system.',
        'a' => 'found evidence',
        'b' => 'bringing to',
        'c' => 'then known',
        'd' => 'out',
        'answer' => 'D'
    ]
];

DB::beginTransaction();
try {
    foreach ($questions as $q) {
        ToeflMockupQuestion::updateOrCreate(
            [
                'package_number' => 1,
                'section' => 'structure',
                'question_number' => $q['number'],
            ],
            [
                'part' => $q['part'],
                'question_text' => $q['question'],
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => $q['c'],
                'option_d' => $q['d'],
                'correct_answer' => $q['answer'],
            ]
        );
    }
    DB::commit();
    echo "Updated " . count($questions) . " questions successfully.\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
