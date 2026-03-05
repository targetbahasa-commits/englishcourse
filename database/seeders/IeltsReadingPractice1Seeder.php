<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice1Seeder extends Seeder
{
    public function run()
    {
        $materialId = 1;

        // Clean existing data for this material
        $passages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($passages as $passage) {
            \App\Models\IeltsReadingQuestion::where('passage_id', $passage->id)->delete();
            $passage->delete();
        }

        // ==========================================
        // PASSAGE 1: Andrea Palladio
        // ==========================================
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Andrea Palladio',
            'content' => '<p><strong>A</strong> Vicenza is a pleasant, prosperous city in the Veneto, 60km west of Venice. Its grand families settled and farmed the area from the 16th century. But its principal claim to fame is Andrea Palladio, who is such an influential architect that a neoclassical style is known as Palladian. The city is a permanent exhibition of some of his finest buildings, and as he was born – in Padua, to be precise – 500 years ago, the International Centre for the Study of Palladio’s Architecture has an excellent excuse for mounting la grande Mostra, the big show</p>
<p><strong>B</strong> The exhibition has the special advantage of being held in one of Palladio’s buildings, Palazzo Barbaran da Porto. Its bold façade is a mixture of rustication and decoration set between two rows of elegant columns. On the second floor, the pediments are alternately curved or pointed, a Palladian trademark. The harmonious proportions of the atrium at the entrance lead through to a dramatic interior of fine fireplaces and painted ceilings. Palladio’s design is simple, clear and not over-crowded. The show has been organised on the same principles, according to Howard Burns, the architectural historian who co-curated it.</p>
<p><strong>C</strong> Palladio’s father was a miller who settled in Vicenza, where the young Andrea was apprenticed to a skilled stonemason. How did a humble miller’s son become a world-renowned architect? The answer in the exhibition is that, as a young man, Palladio excelled at carving decorative stonework on columns, doorways and fireplaces. He was plainly intelligent, and lucky enough to come across a rich patron, Gian Giorgio Trissino, a landowner and scholar, who organised his education, taking him to Rome in the 1540s, where he studied the masterpieces of classical Roman and Greek architecture and the work of other influential architects of the time, such as Donato Bramante and Raphael.</p>
<p><strong>D</strong> Burns argues that social mobility was also important. Entrepreneurs, prosperous from agriculture in the Veneto, commissioned the promising local architect to design their country villas and their urban mansions. In Venice, the aristocracy was anxious to co-opt talented artists, and Palladio has given the chance to design the buildings that have made him famous – the churches of San Giorgio Maggiore and the Redentore, both easy to admire because they can be seen from the city’s historical centre across a stretch of water.</p>
<p><strong>E</strong> He tried his hand at bridges – his unbuilt version of the Rialto Bridge was decorated with the large pediment and columns of a temple – and, after a fire at the Ducal Palace, he offered an alternative design which bears an uncanny resemblance to the Banqueting House in Whitehall in London. Since it was designed by Inigo Jones, Palladio’s first foreign disciple, this is not as surprising as it sounds.</p>
<p><strong>F</strong> Jones, who visited Italy in 1614, bought a trunk full of the master’s architectural drawings; they passed through the hands of Dukes of Burlington and Devonshire before settling at the Royal Institute of British Architects in 1894. Many are now on display at Palazzo Barbaran. What they show is how Palladio drew on the buildings of ancient Rome as models. The major theme of both his rural and urban building was temple architecture, with a strong pointed pediment supported by columns and approached by wide steps.</p>
<p><strong>G</strong> Palladio’s work for rich landowners alienates unreconstructed critics on the Italian left, but among the papers in the show are designed for cheap housing in Venice. In the wider world, Palladio’s reputation has been nurtured by a text he wrote and illustrated, "Quattro Libri dell’ Architettura". His influence spread to St Petersburg and to Charlottesville in Virginia, where Thomas Jefferson commissioned a Palladian villa he called Monticello.</p>
<p><strong>H</strong> Vicenza’s show contains detailed models of the major buildings and is leavened by portraits of Palladio’s teachers and clients by Titian, Veronese and Tintoretto; the paintings of his Venetian buildings are all by Canaletto, no less. This is an uncompromising exhibition; many of the drawings are small and faint, and there are no sideshows for children, but the impact of harmonious lines and satisfying proportions is to impart in a viewer a feeling of benevolent calm. Palladio is history’s most therapeutic architect.</p>
<p><strong>I</strong> "Palladio, 500 Anni: La Grande Mostra" is at Palazzo Barbaran da Porto, Vicenza, until January 6th 2009. The exhibition continues at the Royal Academy of Arts, London, from January 31st to April 13th, and travels afterwards to Barcelona and Madrid.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1?',
            'type' => 'true_false_not_given',
            'options' => [
                'TRUE' => 'if the statement agrees with the information',
                'FALSE' => 'if the statement contradicts the information',
                'NOT GIVEN' => 'if there is no information on this'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'The building where the exhibition is staged has been newly renovated', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '2', 'label' => 'Palazzo Barbaran da Porto typically represent the Palladio’s design', 'correct_answer' => 'TRUE'],
                    ['id' => '3', 'label' => 'Palladio’s father worked as an architect.', 'correct_answer' => 'FALSE'],
                    ['id' => '4', 'label' => 'Palladio’s family refused to pay for his architectural studies', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '5', 'label' => 'Palladio’s alternative design for the Ducal Palace in Venice was based on an English building.', 'correct_answer' => 'FALSE'],
                    ['id' => '6', 'label' => 'Palladio designed both wealthy and poor people.', 'correct_answer' => 'TRUE'],
                    ['id' => '7', 'label' => 'The exhibition includes paintings of people by famous artists', 'correct_answer' => 'TRUE']
                ]
            ],
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 8,
            'question_text' => 'Answer the questions below. Choose NO MORE THAN THREE WORDS from the passage for each answer.',
            'type' => 'short_answer',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 7,
                'sub_questions' => [
                    ['id' => '8', 'label' => 'What job was Palladio training for before he became an architect?', 'correct_answer' => 'stonemason'],
                    ['id' => '9', 'label' => 'Who arranged Palladio’s architectural studies?', 'correct_answer' => 'Gian Giorgio Trissino'],
                    ['id' => '10', 'label' => 'Who was the first non-Italian architect influenced by Palladio?', 'correct_answer' => 'Inigo Jones'],
                    ['id' => '11', 'label' => 'What type of Ancient Roman buildings most heavily influenced Palladio’s work?', 'correct_answer' => 'temple architecture'],
                    ['id' => '12', 'label' => 'What did Palladio write that strengthened his reputation?', 'correct_answer' => "Quattro Libri dell' Architettura"],
                    ['id' => '13', 'label' => 'In the writer’s opinion, what feeling will visitors to the exhibition experience?', 'correct_answer' => 'benevolent calm']
                ]
            ],
            'order' => 2
        ]);

        // ==========================================
        // PASSAGE 2: The future never dies?
        // ==========================================
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The future never dies?',
            'content' => '<p>The prospects for humanity and for the world as a whole are somewhere between glorious and dire. It is hard to be much more precise.</p>
<p><strong>A</strong> By ‘glorious’, I mean that our descendants – all who are born on to this Earth – could live very comfortably and securely, and could continue to do so for as long as the Earth can support life, which should be for a very long time indeed. We should at least be thinking in terms of the next million years. Furthermore, our descendants could continue to enjoy the company of other species – establishing a much better relationship with them than we have now. Other animals need not live in constant fear of us. Many of those fellow species now seem bound to become extinct, but a significant proportion could and should continue to live alongside us. Such a future may seem ideal, and so it is. Yet I do not believe it is fanciful. There is nothing in the physical fabric of the Earth or in our own biology to suggest that this is not possible.</p>
<p><strong>B</strong> ‘Dire’ means that we human beings could be in deep trouble within the next few centuries, living but also dying in large numbers in political terror and from starvation, while huge numbers of our fellow creatures would simply disappear, leaving only the ones that we find convenient – chickens, cattle – or that we can’t shake off, like flies and mice. I’m taking it to be self-evident that glory is preferable.</p>
<p><strong>C</strong> Our future is not entirely in our own hands because the Earth has its own rules, is part of the solar system and is neither stable nor innately safe. Other planets in the solar system are quite beyond habitation, because their temperature is far too high or too low to be endured, and ours, too, in principle could tip either way. Even relatively unspectacular changes in the atmosphere could do the trick. The core of the Earth is hot, which in many ways is good for living creatures, but every now and again, the molten rock bursts through volcanoes on the surface. Among the biggest volcanic eruptions in recent memory was Mount St Helens, in the USA, which threw out a cubic kilometre of ash – fortunately, in an area where very few people live. In 1815, Tambora (in present-day Indonesia) expelled so much ash into the upper atmosphere that climatic effects seriously harmed food production around the world for the season after season. Entire civilisations have been destroyed by volcanoes.</p>
<p><strong>D</strong> <img src="/TargetBahasaCourse/public/images/ielts/reading/volcano-diagram.png" alt="Main Features of a Volcano" class="w-full my-6 rounded-lg shadow"></p>
<p>Yet nothing we have so far experienced shows what volcanoes can really do. Yellowstone National Park in the USA occupies the caldera (the crater formed when a volcano collapses) of an exceedingly ancient volcano of extraordinary magnitude. Modern surveys show that its centre is now rising. Sometime in the next 200 million years, Yellowstone could erupt again, and when it does, the whole world will be transformed. Yellowstone could erupt tomorrow. But there’s a very good chance that it will give us another million years, and that surely is enough to be going on with. It seems sensible to assume that this will be the case.</p>
<p><strong>E</strong> The universe at large is dangerous, too: in particular, we share the sky with vast numbers of asteroids, and now and again, the come into our planet’s atmosphere. An asteroid the size of a small island, hitting the Earth at 15,000 kilometres an hour (a relatively modest speed by the standards of heavenly bodies), would strike the ocean bed like a rock in a puddle, send a tidal wave around the world as high as a small mountain and as fast as a jumbo jet, and propel us into an ice age that could last for centuries. There are plans to head off such disasters (including rockets to push approaching asteroids into new trajectories), but in truth, it’s down to luck.</p>
<p><strong>F</strong> On the other hand, the archaeological and the fossil evidence shows that no truly devastating asteroid has struck since the one that seems to have accounted for the extinction of the dinosaurs 65 million years ago. So again, there seems no immediate reason for despair. The Earth is indeed an uncertain place, in an uncertain universe, but with average luck, it should do us well enough. If the world does become inhospitable in the next few thousand or million years, then it will probably be our own fault. In short, despite the underlying uncertainty, our own future and that of our fellow creatures are very much in our own hands.</p>
<p><strong>G</strong> Given average luck on the geological and the cosmic scale, the difference between glory and disaster will be made and is being made, by politics. Certain kinds of political systems and strategies would predispose us to long-term survival (and indeed to comfort and security and pleasure of being alive), while others would take us more and more frenetically towards collapse. The broad point is, though, that we need to look at ourselves – humanity – and at the world in general in a quite new light. Our material problems are fundamentally those of biology. We need to think, and we need our politicians to think, biologically. Do that, and take the ideas seriously, and we are in with a chance. Ignore biology and we and our fellow creatures haven’t a hope.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'question_text' => 'Do the following statements reflect the claims of the writer in Reading Passage 2?',
            'type' => 'yes_no_not_given',
            'options' => [
                'YES' => 'if the statement is true',
                'NO' => 'if the statement is false',
                'NOT GIVEN' => 'if the information is not given in the passage'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'It seems predictable that some species will disappear.', 'correct_answer' => 'YES'],
                    ['id' => '15', 'label' => 'The nature of the Earth and human biology make it impossible for human beings to survive another million years.', 'correct_answer' => 'NO'],
                    ['id' => '16', 'label' => 'An eruption by Yellowstone is likely to be more destructive than previous volcanic eruptions.', 'correct_answer' => 'YES'],
                    ['id' => '17', 'label' => 'There is a greater chance of the Earth being hit by small asteroids than large ones.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '18', 'label' => 'If the world becomes uninhabitable, it is most likely to be as a result of a natural disaster.', 'correct_answer' => 'NO'],
                    ['id' => '19', 'label' => 'Politicians currently in power seem unlikely to change their way of thinking.', 'correct_answer' => 'NOT GIVEN']
                ]
            ],
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 20,
            'question_text' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'summary_completion',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'summary_text' => 'The Earth could become uninhabitable, like other planets, through a major change in the [20]. Volcanic eruptions of [21] can lead to shortages of [22] in a wide area. An asteroid hitting the Earth could create a [23] that would result in a new [24]. Plans are being made to use [25] to deflect asteroids heading for the Earth.',
                'blanks' => [
                    ['id' => '20', 'blank_number' => 20, 'correct_answer' => 'atmosphere'],
                    ['id' => '21', 'blank_number' => 21, 'correct_answer' => 'ash'],
                    ['id' => '22', 'blank_number' => 22, 'correct_answer' => 'food production'],
                    ['id' => '23', 'blank_number' => 23, 'correct_answer' => 'tidal wave'],
                    ['id' => '24', 'blank_number' => 24, 'correct_answer' => 'ice age'],
                    ['id' => '25', 'blank_number' => 25, 'correct_answer' => 'rockets']
                ]
            ],
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 26,
            'question_text' => 'What is the writer’s purpose in Reading Passage 2?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'to propose a new theory about the causes of natural disasters',
                'B' => 'to prove that generally held beliefs about the future are all mistaken',
                'C' => 'to present a range of opinions currently held by scientists',
                'D' => 'to argue the need for a general change in behavior'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 25,
            ],
            'order' => 3
        ]);

        // ==========================================
        // PASSAGE 3: Pottery production in ancient Akrotiri
        // ==========================================
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Pottery production in ancient Akrotiri',
            'content' => '<p><strong>A</strong> Excavations at the site of prehistoric Akrotiri, on the coast of the Aegean Sea, have revealed much about the technical aspects of pottery manufacture, indisputably one of the basic industries of this Greek city. However, considerably less is known about the socio-economic context and the way production was organised.</p>
<p><strong>B</strong> The bulk of pottery found at Akrotiri is locally made and dates from the late fifteenth century BC. It clearly fulfilled a vast range of the settlement’s requirements: more than fifty different types of pots can be distinguished. The pottery found includes a wide variety of functional types like storage jars, smaller containers, pouring vessels, cooking pots, drinking vessels and so on, which all relate to specific activities and which would have been made and distributed with those activities in mind. Given a large number of shapes produced and the relatively high degree of standardisation, it has generally been assumed that most, if not all, of Akrotiri pottery, was produced by specialised craftsmen in a non-domestic context. Unfortunately, neither the potters’ workshops nor kilns have been found within the excavated area. The reason may be that the ceramic workshops were located on the periphery of the site, which has not yet been excavated. In any event, the ubiquity of the pottery, and the consistent repetition of the same types in different sizes suggest production on an industrial scale.</p>
<p><strong>C</strong> The Akrotirian potters seem to have responded to pressures beyond their households, namely to the increasing complexity of regional distribution and exchange systems. We can imagine them as full-time craftsmen working permanently in a high production-rate craft such as pottery manufacture, and supporting themselves entirely from the proceeds of their craft. In view of the above, one can begin to speak in terms of mass-produced pottery and the existence of organised workshops of craftsmen during the period 1550-1500 BC. Yet, how pottery production was organised at Akrotiri remains an open question, as there is no real documentary evidence. Our entire knowledge comes from the ceramic material itself, and the tentative conclusions which can be drawn from it.</p>
<p><strong>D</strong> The invention of units of quantity and of a numerical system to count them was of capital importance of an exchange-geared society such as that of Akrotiri. In spite of the absence of any written records, the archaeological evidence reveals that concepts of measurements, both weight and number, had been formulated. Standard measures may already have been in operation, such as those evidenced by a graduated series of lead weights – made in disc form – found at the site. The existence of units of capacity in Late Bronze Age times is also evidenced, by the notation of units of a liquid measure for wine on excavated containers.</p>
<p><strong>E</strong> It must be recognised that the function of pottery vessels plays a very important role in determining their characteristics. The intended function affects the choice of clay, the production technique, and the shape and the size of the pots. For example, large storage jars would be needed to store commodities, whereas smaller containers would be used for transport. In fact, the length of a man’s arm limits the size of a smaller pot to a capacity of about twenty litres; that is also the maximum a man can comfortably carry.</p>
<p><strong>F</strong> The various sizes of container would thus represent standard quantities of a commodity, which is a fundamental element in the function of exchange. Akrotirian merchants handling a commodity such as wine would have been able to determine easily the amount of wine they were transporting from the number of containers they carried in their ships since the capacity of each container was known to be 14-18 litres. (We could draw a parallel here with the current practice in Greece of selling oil in 17-kilogram tins.)</p>
<p><strong>G</strong> We may, therefore, assume that the shape, capacity, and, sometimes decoration of vessels are indicative of the commodity contained by them. Since individual transactions would normally involve different quantities of a given commodity, a range of ‘standardised’ types of the vessel would be needed to meet traders’ requirements.</p>
<p><strong>H</strong> In trying to reconstruct systems of capacity by measuring the volume of excavated pottery, a rather generous range of tolerances must be allowed. It seems possible that the potters of that time had specific sizes of the vessel in mind, and tried to reproduce them using a specific type and amount of clay. However, it would be quite difficult for them to achieve the exact size required every time, without any mechanical means of regulating symmetry and wall thickness, and some potters would be more skilled than others. In addition, variations in the repetition of types and size may also occur because of unforeseen circumstances during the throwing process. For instance, instead of destroying the entire pot if the clay in the rim contained a piece of grit, a potter might produce a smaller pot by simply cutting off the rim. Even where there is no noticeable external difference between pots meant to contain the same quantity of a commodity, differences in their capacity can actually reach one or two litres. In one case the deviation from the required size appears to be as much as 10-20 per cent.</p>
<p><strong>I</strong> The establishment of regular trade routes within the Aegean led to increased movement of goods; consequently, a regular exchange of local, luxury and surplus goods, including metals, would have become feasible as a result of the advances in transport technology. The increased demand for standardised exchanges, inextricably linked to commercial transactions, might have been one of the main factors which led to the standardisation of pottery production. Thus, the whole network of ceramic production and exchange would have depended on specific regional economic conditions and would reflect the socio-economic structure of prehistoric Akrotiri.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'question_text' => 'What does the writer say about of pottery excavated at Akrotiri?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'There was very little duplication.',
                'B' => 'They would have met a big variety of needs.',
                'C' => 'Most of them had been imported from other places.',
                'D' => 'The intended purpose of each piece was unclear.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 26,
            ],
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 28,
            'question_text' => 'The assumption that pottery from Akrotiri was produced by specialists is partly based on',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'The discovery of kilns.',
                'B' => 'The central location of workshops.',
                'C' => 'The sophistication of decorative patterns.',
                'D' => 'The wide range of shapes represented.'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 27,
            ],
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 29,
            'question_text' => 'Complete each sentence with the correct ending, A-F, below.',
            'type' => 'matching_sentence_endings',
            'options' => [
                'A' => 'The discovery of a collection of metal discs.',
                'B' => 'The size and type of sailing ships in use.',
                'C' => 'Variations in the exact shape and thickness of similar containers.',
                'D' => 'The physical characteristics of workmen.',
                'E' => 'Marks found on wine containers.',
                'F' => 'The variety of commodities for which they would have been used.'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 28,
                'sub_questions' => [
                    ['id' => '29', 'label' => 'The assumption that standard units of weight were in use could be based on', 'correct_answer' => 'A'],
                    ['id' => '30', 'label' => 'Evidence of the use of standard units of the volume is provided by', 'correct_answer' => 'E'],
                    ['id' => '31', 'label' => 'The size of certain types of containers would have been restricted by', 'correct_answer' => 'D'],
                    ['id' => '32', 'label' => 'Attempts to identify the intended capacity of containers are complicated by', 'correct_answer' => 'C']
                ]
            ],
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 33,
            'question_text' => 'Do the following statements agree with the views of the writer in Reading Passage 3?',
            'type' => 'yes_no_not_given',
            'options' => [
                'YES' => 'if the statement agrees with the claims of the writer',
                'NO' => 'if the statement contradicts the claims of the writer',
                'NOT GIVEN' => 'if it is impossible to say what the writer thinks about this'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 32,
                'sub_questions' => [
                    ['id' => '33', 'label' => 'There are plans to excavate new areas of the archaeological site the near future.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '34', 'label' => 'Some of the evidence concerning pottery production in ancient Akrotiri comes from written records', 'correct_answer' => 'NO'],
                    ['id' => '35', 'label' => 'Pots for transporting liquids would have held no more than about 20 litres.', 'correct_answer' => 'YES'],
                    ['id' => '36', 'label' => 'It would have been hard for merchants to calculate how much wine was on their ships.', 'correct_answer' => 'NO'],
                    ['id' => '37', 'label' => 'The capacity of containers intended to hold the same amounts differed by up to 20 per cent.', 'correct_answer' => 'YES'],
                    ['id' => '38', 'label' => 'Regular trading of goods around the Aegean would have led to the general standardisation of quantities.', 'correct_answer' => 'YES']
                ]
            ],
            'order' => 4
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 39,
            'question_text' => 'What does the writer say about the standardisation of container sizes?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'Containers which looked the same from the outside often varied incapacity.',
                'B' => 'The instruments used to control container size were unreliable.',
                'C' => 'The unsystematic use of different types of clay resulted in size variations.',
                'D' => 'Potters usually discarded containers which were of a non-standard size.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 38,
            ],
            'order' => 5
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 40,
            'question_text' => 'What is probably the main purpose of Reading Passage 3?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'To evaluate the quality of pottery containers found in prehistoric Akrotiri.',
                'B' => 'To suggest how features of pottery production at Akrotiri reflected other developments in the region.',
                'C' => 'To outline the development of pottery-making skills in ancient Greece.',
                'D' => 'To describe methods for storing and transporting household goods in prehistoric societies.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 39,
            ],
            'order' => 6
        ]);
    }
}
