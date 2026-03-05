<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice12Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 12;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Food for thought 2',
            'content' => '
<p><strong>A</strong></p>
<p>There are not enough classrooms at the Msekeni primary school, so half the lessons take place in the shade of yellow-blossomed acacia trees. Given this shortage, it might seem odd that one of the school’s purpose-built classrooms has been emptied of pupils and turned into a storeroom for sacks of grain. But it makes sense. Food matters more than shelter.</p>

<p><strong>B</strong></p>
<p>Msekeni is in one of the poorer parts of Malawi, a landlocked southern African country of exceptional beauty and great poverty. No war lays waste Malawi, nor is the land unusually crowed or infertile, but Malawians still have trouble finding enough to eat. Half of the children under five are underfed to the point of stunting. Hunger blights most aspects of Malawian life, so the country is as good a place as any to investigate how nutrition affects development, and vice versa.</p>

<p><strong>C</strong></p>
<p>The headmaster at Msekeni, Bernard Kumanda, has strong views on the subject. He thinks food is a priceless teaching aid. Since 1999, his pupils have received free school lunches. Donors such as the World Food Programme (WFP) provide the food: those sacks of grain (mostly mixed maize and soya bean flour, enriched with vitamin A) in that converted classroom. Local volunteers do the cooking – turning the dry ingredients into a bland but nutritious slop and spooning it out on to plastic plates. The children line up in large crowds, cheerfully singing a song called “We are getting porridge”.</p>

<p><strong>D</strong></p>
<p>When the school’s feeding programme was introduced, enrolment at Msekeni doubled. Some of the new pupils had switched from nearby schools that did not give out free porridge, but most were children whose families had previously kept them at home to work. These families were so poor that the long-term benefits of education seemed unattractive when setting against the short-term gain of sending children out to gather firewood or help in the fields. One plate of porridge a day completely altered the calculation. A child fed at school will not howl so plaintively for food at home. Girls, who are more likely than boys to be kept out of school, are given extra snacks to take home.</p>

<p><strong>E</strong></p>
<p>When a school takes in a horde of extra students from the poorest homes, you would expect standards to drop. Anywhere in the world, poor kids tend to perform worse than their better-off classmates. When the influx of new pupils is not accompanied by an increase in the number of teachers, as was the case at Msekeni, you would expect standards to fall even further. But they have not. Pass rates at Msekeni improved dramatically, from 30% to 85%. Although this was an exceptional example, the nationwide results of school feeding programmes were still pretty good. On average, after a Malawian school started handing out free food it attracted 38% more girls and 24% more boys. The pass rate for boys stayed about the same, while for girls it improved by 9.5%.</p>

<p><strong>F</strong></p>
<p>Better nutrition makes for brighter children. Most immediately, well-fed children find it easier to concentrate. It is hard to focus the mind on long division when your stomach is screaming for food. Mr Kumanda says that it used to be easy to spot the kids who were really undernourished. “They were the ones who stared into space and didn’t respond when you asked the question,” he says. More crucially, though, more and better food helps brains grow and develop. Like any other organ in the body, the brain needs nutrition and exercise. But if it is starved of the necessary calories, proteins and micronutrients, it is stunted, perhaps not as severely as a muscle would be, but stunted nonetheless. That is why feeding children at schools work so well. And the fact that the effect of feeding was more pronounced in girls than in boys gives a clue to who eats first in rural Malawian households. It isn’t the girls.</p>

<p><strong>G</strong></p>
<p>On a global scale, the good news is that people are eating better than ever before. Homo sapiens has grown 50% bigger since the industrial revolution. Three centuries ago, chronic malnutrition was more or less universal. Now, it is extremely rare in rich countries. In developing countries, where most people live, plates and rice bowls are also fuller than ever before. The proportion of children under five in the developing world who are malnourished to the point of stunting fell from 39% in 1990 to 30% in 2000, says the World Health Organisation (WHO). In other places, the battle against hunger is steadily being won. Better nutrition is making people cleverer and more energetic, which will help them grow more prosperous. And when they eventually join the ranks of the well off, they can start fretting about growing too fast.</p>',
            'order' => 1,
        ]);

        // Questions 1-7: Matching Headings
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'matching_headings',
            'question_text' => 'The reading passage has seven paragraphs, A-G<br>Choose the correct heading for paragraphs A-G from the list below.<br>Write the correct number, i-xi, in boxes 1-7 on your answer sheet.',
            'options' => [
                'i' => 'Why better food helps students’ learning',
                'ii' => 'A song for getting porridge',
                'iii' => 'Surprising use of school premises',
                'iv' => 'Global perspective',
                'v' => 'Brains can be starved',
                'vi' => 'Surprising academics outcome',
                'vii' => 'Girls are specially treated in the program',
                'viii' => 'How food program is operated',
                'ix' => 'How food program affects school attendance',
                'x' => 'None of the usual reasons',
                'xi' => 'How to maintain an academic standard'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of Headings',
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'Paragraph A', 'correct_answer' => 'iii'],
                    ['id' => '2', 'label' => 'Paragraph B', 'correct_answer' => 'x'],
                    ['id' => '3', 'label' => 'Paragraph C', 'correct_answer' => 'viii'],
                    ['id' => '4', 'label' => 'Paragraph D', 'correct_answer' => 'ix'],
                    ['id' => '5', 'label' => 'Paragraph E', 'correct_answer' => 'vi'],
                    ['id' => '6', 'label' => 'Paragraph F', 'correct_answer' => 'i'],
                    ['id' => '7', 'label' => 'Paragraph G', 'correct_answer' => 'iv']
                ]
            ],
            'order' => 1,
        ]);

        // Questions 8-11: Short Answer Questions
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 8,
            'type' => 'short_answer_group',
            'question_text' => 'Complete the sentences below using NO MORE THAN TWO WORDS AND/OR A NUMBER from the passage?<br>Write your answers in boxes 8-11 on your answer sheet',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 7,
                'sub_questions' => [
                    ['id' => '8', 'label' => '………………….. are exclusively offered to girls in the feeding programme.', 'correct_answer' => 'extra snacks'],
                    ['id' => '9', 'label' => 'Instead of going to school, many children in poverty are sent to collect ……………………. in the fields.', 'correct_answer' => 'firewood'],
                    ['id' => '10', 'label' => 'The pass rate as Msekeni has risen to …………………….. with the help of the feeding programme.', 'correct_answer' => '85%'],
                    ['id' => '11', 'label' => 'Since the industrial revolution, the size of the modern human has grown by …………………….', 'correct_answer' => '50%'],
                ]
            ],
            'order' => 2,
        ]);

        // Question 12: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 12,
            'type' => 'multiple_choice',
            'question_text' => 'Choose TWO letters, A-F<br>Write your answers in boxes 12 and 13 on your answer sheet.<br>Which TWO of the following statements are true?',
            'options' => [
                'A' => 'Some children are taught in the open air.',
                'B' => 'Malawi has trouble to feed its large population.',
                'C' => 'No new staffs were recruited when attendance rose.',
                'D' => 'Girls enjoy a higher status than boys in the family',
                'E' => 'Boys and girls experience the same improvement in the pass rate.',
                'F' => 'WHO has cooperated with WFP to provide grain to the school at Msekeni.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 11,
                'sub_questions' => [
                    ['id' => '12', 'label' => 'First Statement', 'correct_answer' => 'A']
                ]
            ],
            'order' => 3,
        ]);

        // Question 13: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 13,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Some children are taught in the open air.',
                'B' => 'Malawi has trouble to feed its large population.',
                'C' => 'No new staffs were recruited when attendance rose.',
                'D' => 'Girls enjoy a higher status than boys in the family',
                'E' => 'Boys and girls experience the same improvement in the pass rate.',
                'F' => 'WHO has cooperated with WFP to provide grain to the school at Msekeni.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 12,
                'sub_questions' => [
                    ['id' => '13', 'label' => 'Second Statement', 'correct_answer' => 'C']
                ]
            ],
            'order' => 4,
        ]);
        
        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Biodiversity',
            'content' => '
<p><strong>A</strong></p>
<p>It seems biodiversity has become a buzzword beloved of politicians, conservationists, protesters and scientists alike. But what exactly is it? The Convention on Biological Diversity, an international agreement to conserve and share the planet’s biological riches, provides a good working definition: biodiversity comprises every form of life, from the smallest microbe to the largest animal or plant, the genes that give them their specific characteristics and the ecosystems of which they are apart.</p>

<p><strong>B</strong></p>
<p>In October, the World Conservation Union (also known as the IUCN) published its updated Red List of Threatened Species, a roll call of 11,167 creatures facing extinction – 121 more than when the list was last published in 2000. But the new figures almost certainly underestimate the crisis. Some 1.2 million species of animal and 270,000 species of plant have been classified, but the well-being of only a fraction has been assessed. The resources are simply not available. The IUCN reports that 5714 plants are threatened, for example, but admits that only 4 per cent of known plants has been assessed. And, of course, there are thousands of species that we have yet to discover. Many of these could also be facing extinction.</p>

<p><strong>C</strong></p>
<p>It is important to develop a picture of the diversity of life on Earth now so that comparisons can be made in the future and trends identified. But it isn’t necessary to observe every single type of organism in an area to get a snapshot of the health of the ecosystem. In many habitats, there are species that are particularly susceptible to shifting conditions, and these can be used as indicator species.</p>

<p><strong>D</strong></p>
<p>In the media, it is usually large, charismatic animals such as pandas, elephants, tigers and whales that get all the attention when a loss of biodiversity is discussed. However, animals or plants far lower down the food chain are often the ones vital for preserving habitats – in the process saving the skins of those more glamorous species. There are known as keystone species.</p>

<p><strong>E</strong></p>
<p>By studying the complex feeding relationships within habitats, species can be identified that have a particularly important impact on the environment. For example, the members of the fig family are the staple food for hundreds of different species in many different countries, so important that scientists sometimes call figs “jungle burgers”. A whole range of animals, from tiny insects to birds and large mammals, feed on everything from the tree’s bark and leaves to its flowers and fruits. Many fig species have very specific pollinators. There are several dozen species of the fig tree in Costa Rica, and a different type of wasp has evolved to pollinate each one. Chris Lyle of the Natural History Museum in London – who is also involved in the Global Taxonomy Initiative of the Convention on Biological Diversity – points out that if fig trees are affected by global warming, pollution, disease or any other catastrophe, the loss of biodiversity will be enormous.</p>

<p><strong>F</strong></p>
<p>Similarly, sea otters play a major role in the survival of giant kelp forests along the coasts of California and Alaska. These “marine rainforests” provide a home for a wide range of other species. The kelp itself is the main food of purple and red sea urchins and in turn, the urchins are eaten by predators, particularly sea otters. They detach an urchin from the seabed then float to the surface and lie on their backs with the urchin shell on their tummy, smashing it open with a stone before eating the contents. Urchins that are not eaten tend to spend their time in rock crevices to avoid the predators. This allows the kelp to grow – and it can grow many centimetres in a day. As the forests form, bits of kelp break off and fall to the bottom to provide food for the urchins in their crevices. The sea otters thrive hunting for sea urchins in the kelp, and many other fish and invertebrates live among the fronds. The problems start when the sea otter population declines. As large predators they are vulnerable – their numbers are relatively small to disease or human hunters can wipe them out. The result is that the sea urchin population grows unchecked and they roam the seafloor eating young kelp fronds. This tends to keep the kelp very short and stops forests developing, which has a huge impact on biodiversity.</p>

<p><strong>G</strong></p>
<p>Conversely, keystone species can also make dangerous alien species: they can wreak havoc if they end up in the wrong ecosystem. The cactus moth, whose caterpillar is a voracious eater of prickly pear was introduced to Australia to control the rampant cacti. It was so successful that someone thought it would be a good idea to introduce it to Caribbean islands that had the same problem. It solved the cactus menace, but unfortunately, some of the moths have now reached the US mainland – borne on winds and in tourists’ luggage – where they are devastating the native cactus populations of Florida.</p>

<p><strong>H</strong></p>
<p>Organisations like the Convention on Biological Diversity work with groups such as the UN and with governments and scientists to raise awareness and fund research. A number of major international meetings – including the World Summit on Sustainable Development in Johannesburg this year – have set targets for governments around the world to slow the loss of biodiversity. And the CITES meeting in Santiago last month added several more names to its list of endangered species for which trade is controlled. Of course, these agreements will prove of limited value if some countries refuse to implement them.</p>

<p><strong>I</strong></p>
<p>There is cause for optimism, however. There seems to be a growing understanding of the need for sustainable agriculture and sustainable tourism to conserve biodiversity. Problems such as illegal logging are being tackled through sustainable forestry programmes, with the emphasis on minimising the use of rainforest hardwoods in the developed world and on rigorous replanting of whatever trees are harvested. CITES is playing its part by controlling trade in wood from endangered tree species. In the same way, sustainable farming techniques that minimise environmental damage and avoid monoculture.</p>

<p><strong>J</strong></p>
<p>Action at a national level often means investing in public education and awareness. Getting people like you and me involved can be very effective. Australia and many European countries are becoming increasingly efficient at recycling much of their domestic waste, for example, preserving natural resources and reducing the use of fossil fuels. This, in turn, has a direct effect on biodiversity by minimising pollution, and an indirect effect by reducing the number of greenhouse gases emitted from incinerators and landfill sites. Preserving ecosystems intact for future generations to enjoy is obviously important, but biodiversity is not some kind of optional extra. Variety may be “the spice of life”, but biological variety is also our life-support system.</p>',
            'order' => 2,
        ]);

        // Questions 14-20: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 2?<br>In boxes 14-20 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'The term “biodiversity” consists of living creatures and the environment that they live in.', 'correct_answer' => 'TRUE'],
                    ['id' => '15', 'label' => 'There are species that have not been researched because it’s unnecessary to study all creatures.', 'correct_answer' => 'FALSE'],
                    ['id' => '16', 'label' => 'It is not necessary to investigate all creatures in a certain place.', 'correct_answer' => 'TRUE'],
                    ['id' => '17', 'label' => 'The press more often than not focuses on animals well-known.', 'correct_answer' => 'TRUE'],
                    ['id' => '18', 'label' => 'There is a successful case that cactus moth plays a positive role in the US.', 'correct_answer' => 'FALSE'],
                    ['id' => '19', 'label' => 'Usage of hardwoods is forbidden in some European countries.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '20', 'label' => 'Agriculture experts advise farmers to plant single crops in the field in terms of sustainable farming.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 21-26: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 21,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '21' => 'keystone',
                '22' => 'fig family/figs',
                '23' => 'sea urchins (urchins)',
                '24' => 'cactus moth',
                '25' => 'Australia',
                '26' => 'Public education'
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 20,
                'instruction' => 'Complete the following summary of the paragraphs of Reading Passage, using NO MORE THAN TWO WORDS from the Reading Passage for each answer.<br>Write your answers in boxes 21-26 on your answer sheet.',
                'summary_text' => 'Because of the ignorance brought by media, people tend to neglect significant creatures called <strong>[21]</strong>. Every creature has diet connections with others, such as <strong>[22]</strong>, which provide a majority of foods for other species. In some states of America, the decline in a number of sea otters leads to the boom of <strong>[23]</strong>. An impressing case is that imported <strong>[24]</strong> successfully tackles the plant cacti in <strong>[25]</strong>. However, the operation is needed for the government to increase its financial support in <strong>[26]</strong>.',
                'placeholders' => [
                    '21' => 21,
                    '22' => 22,
                    '23' => 23,
                    '24' => 24,
                    '25' => 25,
                    '26' => 26
                ]
            ],
            'order' => 2,
        ]);

        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Soviet’s New Working Week',
            'content' => '
<p><strong>A</strong></p>
<p>“There are no fortresses that Bolsheviks cannot storm”. With these words, Stalin expressed the dynamic self-confidence of the Soviet Union’s Five Year Plan: weak and backward Russia was to turn overnight into a powerful modern industrial country. Between 1928 and 1932, production of coal, iron and steel increased at a fantastic rate, and new industrial cities sprang up, along with the world’s biggest dam. Everyone’s life was affected, as collectivised farming drove millions from the land to swell the industrial proletariat. Private enterprise disappeared in city and country, leaving the State supreme under the dictatorship of Stalin. Unlimited enthusiasm was the mood of the day, with the Communists believing that iron will and hard-working manpower alone would bring about a new world.</p>

<p><strong>B</strong></p>
<p>Enthusiasm spread to time itself, in the desire to make the state a huge efficient machine, where not a moment would be wasted, especially in the workplace. Lenin had already been intrigued by the ideas of the American Frederick Winslow Taylor (1856-1915), whose time-motion studies had discovered ways of stream-lining effort so that every worker could produce the maximum. The Bolsheviks were also great admirers of Henry Ford’s assembly line mass production and of his Fordson tractors that were imported by the thousands. The engineers who came with them to train their users helped spread what became a real cult of Ford. Emulating and surpassing such capitalist models formed part of the training of the new Soviet Man, a heroic figure whose unlimited capacity for work would benefit everyone in the dynamic new society. All this culminated in the Plan, which has been characterized as the triumph of the machine, where workers would become supremely efficient robot-like creatures.</p>

<p><strong>C</strong></p>
<p>Yet this was Communism whose goals had always included improving the lives of the proletariat. One major step in that direction was the sudden announcement in 1927 that reduced the working day from eight to seven hours. In January 1929, all Indus-tries were ordered to adopt the shorter day by the end of the Plan. Workers were also to have an extra hour off on the eve of Sundays and holidays. Typically though, the state took away more than it gave, for this was part of a scheme to increase production by establishing a three-shift system. This meant that the factories were open day and night and that many had to work at highly undesirable hours.</p>

<p><strong>D</strong></p>
<p>Hardly had that policy been announced, though, then Yuri Larin, who had been a close associate of Lenin and architect of his radical economic policy, came up with an idea for even greater efficiency. Workers were free and plants were closed on Sundays. Why not abolish that wasted day by instituting a continuous workweek so that the machines could operate to their full capacity every day of the week? When Larin presented his idea to the Congress of Soviets in May 1929, no one paid much attention. Soon after, though, he got the ear of Stalin, who approved. Suddenly, in June, the Soviet press was filled with articles praising the new scheme. In August, the Council of Peoples’ Commissars ordered that the continuous workweek be brought into immediate effect, during the height of enthusiasm for the Plan, whose goals the new schedule seemed guaranteed to forward.</p>

<p><strong>E</strong></p>
<p>The idea seemed simple enough but turned out to be very complicated in practice. Obviously, the workers couldn’t be made to work seven days a week, nor should their total work hours be increased. The solution was ingenious: a new five-day week would have the workers on the job for four days, with the fifth day free; holidays would be reduced from ten to five, and the extra hour off on the eve of rest days would be abolished. Staggering the rest-days between groups of workers meant that each worker would spend the same number of hours on the job, but the factories would be working a full 360 days a year instead of 300. The 360 divided neatly into 72 five-day weeks. Workers in each establishment (at first factories, then stores and offices) were divided into five groups, each assigned a colour which appeared on the new Uninterrupted Work Week calendars distributed all over the country. Colour-coding was a valuable mnemonic device since workers might have trouble remembering what their day off was going to be, for it would change every week. A glance at the colour on the calendar would reveal the free day, and allow workers to plan their activities. This system, however, did not apply to construction or seasonal occupations, which followed a six-day week, or to factories or mines which had to close regularly for maintenance: they also had a six-day week, whether interrupted (with the same day off for everyone) or continuous. In all cases, though, Sunday was treated like any other day.</p>

<p><strong>F</strong></p>
<p>Official propaganda touted the material and cultural benefits of the new scheme. Workers would get more rest; production and employment would increase (for more workers would be needed to keep the factories running continuously); the standard of living would improve. Leisure time would be more rationally employed, for cultural activities (theatre, clubs, sports) would no longer have to be crammed into a weekend, but could flourish every day, with their facilities far less crowded. Shopping would be easier for the same reasons. Ignorance and superstition, as represented by organized religion, would suffer a mortal blow, since 80 per cent of the workers would be on the job on any given Sunday. The only objection concerned the family, where normally more than one member was working: well, the Soviets insisted, the narrow family was har less important than the vast common good and besides, arrangements could be made for husband and wife to share a common schedule. In fact, the regime had long wanted to weaken or sideline the two greatest potential threats to its total dominance: organised religion and the nuclear family. Religion succumbed, but the family, as even Stalin finally had to admit, proved much more resistant.</p>

<p><strong>G</strong></p>
<p>The continuous work week, hailed as a Utopia where time itself was conquered and the sluggish Sunday abolished forever, spread like an epidemic. According to official figures, 63 per cent of industrial workers were so employed by April 1930; in June, all industry was ordered to convert during the next year. The fad reached its peak in October when it affected 73 per cent of workers. In fact, many managers simply claimed that their factories had gone over to the new week, without actually applying it. Conforming to the demands of the Plan was important; practical matters could wait. By then, though, problems were becoming obvious. Most serious (though never officially admitted), the workers hated it. Coordination of family schedules was virtually impossible and usually ignored, so husbands and wives only saw each other before or after work; rest days were empty without any loved ones to share them – even friends were likely to be on a different schedule. Confusion reigned: the new plan was introduced haphazardly, with some factories operating five-, six- and seven-day weeks at the same time, and the workers often not getting their rest days at all.</p>

<p><strong>H</strong></p>
<p>The Soviet government might have ignored all that (It didn’t depend on public approval), but the new week was far from having the vaunted effect on production. With the complicated rotation system, the work teams necessarily found themselves doing different kinds of work in successive weeks. Machines, no longer consistently in the hands of people how knew how to tend them, were often poorly maintained or even broken. Workers lost a sense of responsibility for the special tasks they had normally performed.</p>

<p><strong>I</strong></p>
<p>As a result, the new week started to lose ground. Stalin’s speech of June 1931, which criticised the “depersonalised labor” its too hasty application had brought, marked the beginning of the end. In November, the government ordered the widespread adoption of the six-day week, which had its own calendar, with regular breaks on the 6th, 12th, 18th, 24th, and 30th, with Sunday usually as a working day. By July 1935, only 26 per cent of workers still followed the continuous schedule, and the six-day week was soon on its way out. Finally, in 1940, as part of the general reversion to more traditional methods, both the continuous five-day week and the novel six-day week were abandoned, and Sunday returned as the universal day of rest. A bold but typically ill-conceived experiment was at an end.</p>',
            'order' => 3,
        ]);


        // Questions 27-34: Matching Headings
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'matching_headings',
            'question_text' => 'Reading Passage 3 has nine paragraphs A-I<br>Choose the correct heading for each paragraph from the list of headings below.<br>Write the correct number i-xii in boxes 27-34 on your answer sheet',
            'options' => [
                'i' => 'Benefits of the new scheme and its resistance',
                'ii' => 'Making use of the once wasted weekends',
                'iii' => 'Cutting work hours for better efficiency',
                'iv' => 'Optimism of the great future',
                'v' => 'Negative effects on the production itself',
                'vi' => 'Soviet Union’s five-year plan',
                'vii' => 'The abolishment of the new work-week scheme',
                'viii' => 'The Ford model',
                'ix' => 'Reaction from factory workers and their families',
                'x' => 'The color-coding scheme',
                'xi' => 'Establishing a three-shift system',
                'xii' => 'Foreign inspiration'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of Headings',
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'Paragraph A', 'correct_answer' => 'iv'],
                    ['id' => '28', 'label' => 'Paragraph B', 'correct_answer' => 'xii'],
                    // Paragraph C is given as an example (iii)
                    ['id' => '29', 'label' => 'Paragraph D', 'correct_answer' => 'ii'],
                    ['id' => '30', 'label' => 'Paragraph E', 'correct_answer' => 'x'],
                    ['id' => '31', 'label' => 'Paragraph F', 'correct_answer' => 'i'],
                    ['id' => '32', 'label' => 'Paragraph G', 'correct_answer' => 'ix'],
                    ['id' => '33', 'label' => 'Paragraph H', 'correct_answer' => 'v'],
                    ['id' => '34', 'label' => 'Paragraph I', 'correct_answer' => 'vii']
                ]
            ],
            'order' => 1,
        ]);

        // Question 35: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 35,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter A, B, C or D.<br>Write your answers in boxes 35-37 on your answer sheet.<br>',
            'options' => [
                'A' => 'Bolsheviks built a strong fortress.',
                'B' => 'Russia was weak and backward.',
                'C' => 'industrial production increased.',
                'D' => 'Stalin was confident about the Soviet’s potential.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 34,
                'sub_questions' => [
                    ['id' => '35', 'label' => 'According to paragraph A, the Soviet’s five-year plan was a success because', 'correct_answer' => 'C']
                ]
            ],
            'order' => 2,
        ]);

        // Question 36: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 36,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'improve the lives of all people',
                'B' => 'boost industrial productivity.',
                'C' => 'get rid of undesirable work hours.',
                'D' => 'change the already establish three-shift work system.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 35,
                'sub_questions' => [
                    ['id' => '36', 'label' => 'Daily working hours were cut from eight to seven to', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);

        // Question 37: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 37,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'they were pressurized by the state to do so.',
                'B' => 'they believed there would not be any practical problems.',
                'C' => 'they were able to apply it.',
                'D' => 'workers hated the new plan.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 36,
                'sub_questions' => [
                    ['id' => '37', 'label' => 'Many factory managers claimed to have complied with the demands of the new work week because', 'correct_answer' => 'A']
                ]
            ],
            'order' => 4,
        ]);

        // Questions 38-40: Short Answer
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 38,
            'type' => 'short_answer_group',
            'question_text' => 'Answer the questions below using NO MORE THAN TWO WORDS from the passage for each answer.<br>Write your answers in boxes 38-40 on your answer sheet.',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 37,
                'sub_questions' => [
                    ['id' => '38', 'label' => 'Whose idea of continuous work week did Stalin approve and helped to implement?', 'correct_answer' => 'Yuri Larin'],
                    ['id' => '39', 'label' => 'What method was used to help workers to remember the rotation of their off days?', 'correct_answer' => 'Colour-coding/colour'],
                    ['id' => '40', 'label' => 'What was the most resistant force to the new work week scheme?', 'correct_answer' => 'family'],
                ]
            ],
            'order' => 5,
        ]);
    }
}
