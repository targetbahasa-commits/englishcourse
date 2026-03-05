<?php
/**
 * Seed script: IELTS Reading Material 1 – Andrea Palladio (Passage 1)
 * Run via: php seed_reading_passage1.php
 *
 * Questions 1-7  : True / False / Not Given
 * Questions 8-13 : Short Answer (NO MORE THAN THREE WORDS)
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$materialId = 1;   // Material: Passage 1 set

// ─── Guard: clean any existing data for material 1 ───────────────────────────
$existingPassages = DB::table('ielts_reading_passages')
    ->where('material_id', $materialId)
    ->pluck('id');

if ($existingPassages->count()) {
    DB::table('ielts_reading_questions')
        ->whereIn('passage_id', $existingPassages)
        ->delete();
    DB::table('ielts_reading_passages')
        ->whereIn('id', $existingPassages)
        ->delete();
    echo "Cleared " . $existingPassages->count() . " existing passage(s) for material $materialId.\n";
}

// ─── 1. Insert the Passage ────────────────────────────────────────────────────
$passageId = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Andrea Palladio',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong> which are based on Reading Passage 1 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Andrea Palladio</h2>
<p class="text-sm font-semibold text-gray-500 mb-1 italic">Italian architect</p>
<p class="font-bold text-gray-700 mb-6">A new exhibition celebrates Palladio's architecture 500 years on</p>

<p><strong>A</strong> &nbsp;Vicenza is a pleasant, prosperous city in the Veneto, 60km west of Venice. Its grand families settled and farmed the area from the 16th century. But its principal claim to fame is Andrea Palladio, who is such an influential architect that a neoclassical style is known as Palladian. The city is a permanent exhibition of some of his finest buildings, and as he was born – in Padua, to be precise – 500 years ago, the International Centre for the Study of Palladio's Architecture has an excellent excuse for mounting la grande Mostra, the big show.</p>

<p><strong>B</strong> &nbsp;The exhibition has the special advantage of being held in one of Palladio's buildings, Palazzo Barbaran da Porto. Its bold façade is a mixture of rustication and decoration set between two rows of elegant columns. On the second floor, the pediments are alternately curved or pointed, a Palladian trademark. The harmonious proportions of the atrium at the entrance lead through to a dramatic interior of fine fireplaces and painted ceilings. Palladio's design is simple, clear and not over-crowded. The show has been organised on the same principles, according to Howard Burns, the architectural historian who co-curated it.</p>

<p><strong>C</strong> &nbsp;Palladio's father was a miller who settled in Vicenza, where the young Andrea was apprenticed to a skilled stonemason. How did a humble miller's son become a world-renowned architect? The answer in the exhibition is that, as a young man, Palladio excelled at carving decorative stonework on columns, doorways and fireplaces. He was plainly intelligent, and lucky enough to come across a rich patron, Gian Giorgio Trissino, a landowner and scholar, who organised his education, taking him to Rome in the 1540s, where he studied the masterpieces of classical Roman and Greek architecture and the work of other influential architects of the time, such as Donato Bramante and Raphael.</p>

<p><strong>D</strong> &nbsp;Burns argues that social mobility was also important. Entrepreneurs, prosperous from agriculture in the Veneto, commissioned the promising local architect to design their country villas and their urban mansions. In Venice, the aristocracy was anxious to co-opt talented artists, and Palladio was given the chance to design the buildings that have made him famous – the churches of San Giorgio Maggiore and the Redentore, both easy to admire because they can be seen from the city's historical centre across a stretch of water.</p>

<p><strong>E</strong> &nbsp;He tried his hand at bridges – his unbuilt version of the Rialto Bridge was decorated with the large pediment and columns of a temple – and, after a fire at the Ducal Palace, he offered an alternative design which bears an uncanny resemblance to the Banqueting House in Whitehall in London. Since it was designed by Inigo Jones, Palladio's first foreign disciple, this is not as surprising as it sounds.</p>

<p><strong>F</strong> &nbsp;Jones, who visited Italy in 1614, bought a trunk full of the master's architectural drawings; they passed through the hands of Dukes of Burlington and Devonshire before settling at the Royal Institute of British Architects in 1894. Many are now on display at Palazzo Barbaran. What they show is how Palladio drew on the buildings of ancient Rome as models. The major theme of both his rural and urban building was temple architecture, with a strong pointed pediment supported by columns and approached by wide steps.</p>

<p><strong>G</strong> &nbsp;Palladio's work for rich landowners alienates unreconstructed critics on the Italian left, but among the papers in the show are designs for cheap housing in Venice. In the wider world, Palladio's reputation has been nurtured by a text he wrote and illustrated, "Quattro Libri dell' Architettura". His influence spread to St Petersburg and to Charlottesville in Virginia, where Thomas Jefferson commissioned a Palladian villa he called Monticello.</p>

<p><strong>H</strong> &nbsp;Vicenza's show contains detailed models of the major buildings and is leavened by portraits of Palladio's teachers and clients by Titian, Veronese and Tintoretto; the paintings of his Venetian buildings are all by Canaletto, no less. This is an uncompromising exhibition; many of the drawings are small and faint, and there are no sideshows for children, but the impact of harmonious lines and satisfying proportions is to impart in a viewer a feeling of benevolent calm. Palladio is history's most therapeutic architect.</p>

<p><strong>I</strong> &nbsp;"Palladio, 500 Anni: La Grande Mostra" is at Palazzo Barbaran da Porto, Vicenza, until January 6th 2009. The exhibition continues at the Royal Academy of Arts, London, from January 31st to April 13th, and travels afterwards to Barcelona and Madrid.</p>
HTML,
    'order'       => 1,
    'created_at'  => now(),
    'updated_at'  => now(),
]);

echo "Created passage ID: $passageId\n";

// ─── 2. Insert Question Block 1: True / False / Not Given (Q1–7) ──────────────
$tfngSubQuestions = [
    ['id' => 'q1', 'label' => 'The building where the exhibition is staged has been newly renovated.'],
    ['id' => 'q2', 'label' => 'Palazzo Barbaran da Porto typically represents the Palladio\'s design.'],
    ['id' => 'q3', 'label' => 'Palladio\'s father worked as an architect.'],
    ['id' => 'q4', 'label' => 'Palladio\'s family refused to pay for his architectural studies.'],
    ['id' => 'q5', 'label' => 'Palladio\'s alternative design for the Ducal Palace in Venice was based on an English building.'],
    ['id' => 'q6', 'label' => 'Palladio designed buildings for both wealthy and poor people.'],
    ['id' => 'q7', 'label' => 'The exhibition includes paintings of people by famous artists.'],
];

$tfngData = [
    'sub_questions'  => $tfngSubQuestions,
    'options'        => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q1' => 'NOT GIVEN', 'q2' => 'TRUE', 'q3' => 'FALSE', 'q4' => 'NOT GIVEN', 'q5' => 'FALSE', 'q6' => 'TRUE', 'q7' => 'TRUE'],
    'start_number'   => 0,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $passageId,
    'question_number' => 1,
    'type'            => 'true_false',
    'question_text'   => 'Do the following statements agree with the information given in Reading Passage 1? Write <strong>TRUE</strong> if the statement agrees with the information, <strong>FALSE</strong> if the statement contradicts the information, or <strong>NOT GIVEN</strong> if there is no information on this.',
    'options'         => json_encode(['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q1' => 'NOT GIVEN', 'q2' => 'TRUE', 'q3' => 'FALSE', 'q4' => 'NOT GIVEN', 'q5' => 'FALSE', 'q6' => 'TRUE', 'q7' => 'TRUE']),
    'explanation'     => null,
    'data'            => json_encode($tfngData),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted T/F/NG question block (Q1-7).\n";

// ─── 3. Insert Question Block 2: Short Answer (Q8–13) ────────────────────────
$shortAnswerSubQuestions = [
    ['id' => 'q8',  'label' => "What job was Palladio training for before he became an architect?"],
    ['id' => 'q9',  'label' => "Who arranged Palladio's architectural studies?"],
    ['id' => 'q10', 'label' => "Who was the first non-Italian architect influenced by Palladio?"],
    ['id' => 'q11', 'label' => "What type of Ancient Roman buildings most heavily influenced Palladio's work?"],
    ['id' => 'q12', 'label' => "What did Palladio write that strengthened his reputation?"],
    ['id' => 'q13', 'label' => "In the writer's opinion, what feeling will visitors to the exhibition experience?"],
];

$shortAnswerData = [
    'sub_questions'  => $shortAnswerSubQuestions,
    'options'        => [],
    'correct_answer' => [
        'q8'  => 'stonemason',
        'q9'  => 'Gian Giorgio Trissino',
        'q10' => 'Inigo Jones',
        'q11' => 'temple architecture',
        'q12' => 'Quattro Libri dell\' Architettura',
        'q13' => 'benevolent calm',
    ],
    'start_number' => 7,
    'instruction'  => 'Choose NO MORE THAN THREE WORDS from the passage for each answer.',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $passageId,
    'question_number' => 8,
    'type'            => 'short_answer_group',
    'question_text'   => 'Answer the questions below. Choose <strong>NO MORE THAN THREE WORDS</strong> from the passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode([
        'q8'  => 'stonemason',
        'q9'  => 'Gian Giorgio Trissino',
        'q10' => 'Inigo Jones',
        'q11' => 'temple architecture',
        'q12' => "Quattro Libri dell' Architettura",
        'q13' => 'benevolent calm',
    ]),
    'explanation'     => null,
    'data'            => json_encode($shortAnswerData),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Short Answer question block (Q8-13).\n";
echo "\nDone! Visit /assignments/ielts-academic/reading/material/1 to view Passage 1.\n";
