<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IeltsReadingPractice9Seeder extends Seeder
{
    public function run()
    {
        $materialId = 9;

        // Clean up existing data for this practice test
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->pluck('id');
        \App\Models\IeltsReadingQuestion::whereIn('passage_id', $existingPassages)->delete();
        \App\Models\IeltsReadingPassage::where('material_id', $materialId)->delete();

        // ==========================================
        // PASSAGE 1: Natural Pesticide in India
        // ==========================================
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Natural Pesticide in India',
            'content' => '
<p><strong>A</strong> A dramatic story about cotton farmers in India shows how destructive pesticides can be for people and the environment; and why today\'s agriculture is so dependent on pesticides. This story also shows that it\'s possible to stop using chemical pesticides without losing a crop to ravaging insects, and it explains how to do it.</p>

<p><strong>B</strong> The story began about 30 years ago, a handful of families migrated from the Guntur district of Andhra Pradesh, southeast India, into Punukula, a community of around 900 people farming plots of between two and 10 acres. The outsiders from Guntur brought cotton-culture with them. Cotton wooed farmers by promising to bring in more hard cash than the mixed crops they were already growing to eat and sell: millet, sorghum, groundnuts, pigeon peas, mung beans, chili and rice. But raising cotton meant using pesticides and fertilizers – until then a mystery to the mostly illiterate farmers of the community. When cotton production started spreading through Andhra Pradesh state. The high value of cotton made it an exceptionally attractive crop, but growing cotton required chemical fertilizers and pesticides. As most of the farmers were poor, illiterate, and without previous experience using agricultural chemicals, they were forced to rely on local, small-scale agricultural dealers for advice. The dealers sold them seeds, fertilizers, and pesticides on credit and also guaranteed the purchase of their crop. The dealers themselves had little technical knowledge about pesticides. They merely passed on promotional information from multinational chemical companies that supplied their products.</p>

<p><strong>C</strong> At first, cotton yields were high, and expenses for pesticides were low because cotton pests had not yet moved in. The farmers had never earned so much! But within a few years, cotton pests like bollworms and aphids plagued the fields, and the farmers saw how rapid insect evolution can be. Repeated spraying killed off the weaker pests, but left the ones most resistant to pesticides to multiply. As pesticide resistance mounted, the farmers had to apply more and more of the pesticides to get the same results. At the same time, the pesticides killed off birds, wasps, beetles, spiders, and other predators that had once provided natural control of pest insects. Without these predators, the pests could destroy the entire crop if pesticides were not used. Eventually, farmers were mixing sometimes having to spray their cotton as frequently as two times a week. They were really hooked!</p>

<p><strong>D</strong> The villagers were hesitant, but one of Punukula\'s village elders decided to risk trying the natural methods instead of pesticides. His son had collapsed with acute pesticide poisoning and survived but the hospital bill was staggering. SECURE\'s staff coached this villager on how to protect his cotton crop by using a toolkit of natural methods chat India\'s Center for Sustainable Agriculture put together in collaboration with scientists at Andhra Pradesh\'s state university. They called the toolkit "Non-Pesticide Management" – or "NPM."</p>

<p><strong>E</strong> The most important resource in the NPM toolkit was the neem tree (Azadirachta indica) which is common throughout much of India. Neem tree is a broad-leaved evergreen tree related to mahogany. It protects itself against insects by producing a multitude of natural pesticides that work in a variety of ways: with an arsenal of chemical defenses that repel egg-laying, interfere with insect growth, and most important, disrupt the ability of crop-eating insects to sense their food.</p>

<p><strong>F</strong> In fact, neem has been used traditionally in India to protect stored grains from insects and to produce soaps, skin lotions, and other health products. To protect crops from insects, neem seeds are simply ground into a powder that is soaked overnight in water. The solution is then sprayed onto the crop. Another preparation, neem cake, can be mixed into the soil to kill pests and diseases in the soil, and it doubles as an organic fertilizer high in nitrogen. Neem trees grow locally, so the only "cost" is the labor to prepare neem for application to fields.</p>

<p><strong>G</strong> The first farmer\'s trial with NPM was a complete success! His harvest was as good as the harvests of farmers that were using pesticides, and he earned much more because he did not spend a single rupee on pesticides. Inspired by this success, 20 farmers tried NPM the next year. SECURE posted two well-trained staff in Punukula to teach and help everyone in the village, and the village women put pressure on their husbands to stop using toxic chemicals. Families that were no longer exposing themselves to pesticides began to feel much better, and the rapid improvement in income, health, and general wellbeing quickly sold everyone on the value of NPM. By 2000, all the farmers in Punukula were using NPM, not only for cotton but for their other crops as well.</p>

<p><strong>H</strong> The suicide epidemic came to an end. And with the cash, health, and energy that returned when they stopped poisoning themselves with pesticides, the villagers were inspired to start more community and business projects. The women of Punukula created a new source of income by collecting, grinding, and selling neem seeds for NPM in other villages. The villagers rescued their indentured children and gave them special six-month "catch-up," courses to return to school.</p>

<p><strong>I</strong> Fighting against pesticides, and winning, increased village solidarity, self-confidence, and optimism about the future. When dealers tried to punish NPM users by paying less for NPM cotton, the farmers united to form a marketing cooperative that found fairer prices elsewhere. The leadership and collaboration skills that the citizens of Punukula developed in the NPM struggle have helped them to take on other challenges, like water purification, building a cotton gin to add value to the cotton before they sell it, and convincing the state government to support NPM over the objection of multi-national pesticide corporations.</p>
            ',
            'order' => 1
        ]);

        // Questions 1-4: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1? In boxes 1-4 on your answer sheet, write TRUE if the statement agrees with the information, FALSE if the statement contradicts the information, NOT GIVEN if there is no information on this.',
            'type' => 'true_false_not_given',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'Cotton in Andhra Pradesh state could really bring more income to the local farmers than traditional farming.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '2', 'label' => 'The majority of farmers had used agricultural pesticides before 30 years ago.', 'correct_answer' => 'FALSE'],
                    ['id' => '3', 'label' => 'The yield of cotton is relatively lower than that of other agricultural crops.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '4', 'label' => 'The farmers didn\'t realize the spread of the pests was so fast.', 'correct_answer' => 'TRUE'],
                ]
            ]
        ]);

        // Questions 5-11: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 5,
            'question_text' => '',
            'type' => 'summary_completion',
            'options' => null,
            'correct_answer' => [
                '5' => 'evergreen',
                '6' => 'natural pesticides',
                '7' => 'powder',
                '8' => 'overnight',
                '9' => 'neem cake',
                '10' => 'doubles',
                '11' => 'nitrogen',
            ],
            'explanation' => '5: evergreen (Paragraph E - "broad-leaved evergreen tree"), 6: natural pesticides (Paragraph E), 7: powder (Paragraph F), 8: overnight (Paragraph F - "soaked overnight in water"), 9: neem cake (Paragraph F), 10: doubles (Paragraph F - "doubles as an organic fertilizer"), 11: nitrogen (Paragraph F - "high in nitrogen")',
            'data' => [
                'start_number' => 4,
                'instruction' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer. Write your answers in boxes 5-11 on your answer sheet.',
                'box_title' => 'The Making of pesticide protecting crops against insects',
                'summary_text' => 'The broad-leaved neem tree was chosen. It is a fast-growing and <strong>[5]</strong> tree and produces an amount of <strong>[6]</strong> for itself that can be effective like insects repellent. Firstly, neem seeds need to be crushed into <strong>[7]</strong> form, which is left behind <strong>[8]</strong> in water. Then we need to spray the solution onto the crop. A special <strong>[9]</strong> is used when mixing with soil in order to eliminate bugs and bacteria, and its effect <strong>[10]</strong> when it adds the level of <strong>[11]</strong> in this organic fertilizer meanwhile.',
                'placeholders' => [
                    '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11
                ]
            ]
        ]);

        // Questions 12-13: Short Answer
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 12,
            'question_text' => 'Answer the questions below. Choose NO MORE THAN TWO WORDS AND/OR A NUMBER from the passage for each answer. Write your answers in boxes 12-13 on your answer sheet.',
            'type' => 'short_answer_group',
            'options' => null,
            'correct_answer' => [
                '12' => 'In 2000',
                '13' => 'Neem seeds',
            ],
            'explanation' => '12: Paragraph G - "By 2000, all the farmers in Punukula". 13: Paragraph H - "collecting, grinding, and selling neem seeds".',
            'data' => [
                'start_number' => 11,
                'sub_questions' => [
                    ['id' => '12', 'label' => 'In which year did all the farmers use NPM for their crops in Punukala?', 'correct_answer' => 'In 2000'],
                    ['id' => '13', 'label' => 'What gave the women of Punukula a business opportunity to NPMs?', 'correct_answer' => 'Neem seeds'],
                ]
            ]
        ]);

        // ==========================================
        // PASSAGE 2: Is Graffiti Art or Crime?
        // ==========================================
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Is Graffiti Art or Crime?',
            'content' => '
<p><strong>A</strong> The term graffiti derives from the Italian graffito meaning \'scratching\' and can be defined as uninvited marking or writing scratched or applied to objects, built structures and natural features. It is not a new phenomenon: examples can be found on ancient structures around the world, in some cases predating the Greeks and Romans. In such circumstances it has acquired invaluable historical and archaeological significance, providing a social history of life and events at that time. Graffiti is now a problem that has become pervasive, as a result of the availability of cheap and quick means of mark-making.</p>

<p><strong>B</strong> It is usually considered a priority to remove graffiti as quickly as possible after it appears. This is for several reasons. The first is to prevent \'copy-cat\' emulation which can occur rapidly once a clean surface is defaced. It may also be of a racist or otherwise offensive nature and many companies and councils have a policy of removing this type of graffiti within an hour or two of it being reported. Also, as paints, glues and inks dry out over time they can become increasingly difficult to remove and are usually best dealt with as soon as possible after the incident. Graffiti can also lead to move serious forms of vandalism and, ultimately, the deterioration of an area, contributing to social decline.</p>

<p><strong>C</strong> Although graffiti may be regarded as an eyesore, any proposal to remove it from sensitive historic surfaces should be carefully considered: techniques designed for more robust or utilitarian surfaces may result in considerable damage. In the event of graffiti incidents, it is important that the owners of buildings or other structures and their consultants are aware of the approach they should take in dealing with the problem. The police should be informed as there may be other related attacks occurring locally. An incidence pattern can identify possible culprits, as can stylised signatures or nicknames, known as \'tags\', which may already be familiar to local police. Photographs are useful to record graffiti incidents and may assist the police in bringing a prosecution. Such images are also required for insurance claims and can be helpful in cleaning operatives, allowing them to see the problem area before arriving on site.</p>

<p><strong>D</strong> There are a variety of methods that are used to remove graffiti. Broadly these divide between chemical and mechanical systems. Chemical preparations are based on dissolving the media; these solvents can range from water to potentially hazardous chemical \'cocktails\'. Mechanical systems such as wire-brushing and grit-blasting attempt to abrade or chip the media from the surface. Care should be taken to comply with health and safety legislation with regard to the protection of both passers-by and any person carrying out the cleaning. Operatives should follow product guidelines in terms of application and removal, and wear the appropriate protective equipment. Measures must be taken to ensure that run-off, aerial mists, drips and splashes do not threaten unprotected members of the public. When examining a graffiti incident it is important to assess the ability of the substrate to withstand the prescribed treatment. If there is any doubt regarding this, then small trial areas should be undertaken to assess the impact of more extensive treatment.</p>

<p><strong>E</strong> A variety of preventive strategies can be adopted to combat a recurring problem of graffiti at a given site. As no two sites are the same, no one set of protection measures will be suitable for all situations. Each site must be looked at individually. Surveillance systems such as closed-circuit television may also help. In cities and towns around the country, prominently placed cameras have been shown to reduce anti-social behavior of all types including graffiti. Security patrols will also act as a deterrent to prevent recurring attacks. However, the cost of this may be too high for most situations. A physical barriers such as a wall, railings, doors or gates can be introduced to discourage unauthorized access to a vulnerable site. However, consideration has to be given to the impact measures have on the structure being protected. In the worst cases, they can be almost as damaging to the quality of the environment as the graffiti they prevent. In others, they might simply provide a new surface for graffiti.</p>

<p><strong>F</strong> One of the most significant problems associated with graffiti removal is the need to remove it from surfaces that are repeatedly attacked. Under these circumstances, the repeated removal of graffiti using even the most gentle methods will ultimately cause damage to the surface material. There may be situations where the preventive strategies mentioned above do not work or are not a viable proposition at a given site. Anti-graffiti coatings are usually applied by brush or spray leaving a thin veneer that essentially serves to isolate the graffiti from the surface.</p>

<p><strong>G</strong> Removal of graffiti from a surface that has been treated in this way is much easier, usually using low-pressure water which reduces the possibility of damage. Depending on the type of barrier selected it may be necessary to reapply the coating after each graffiti removal exercise.</p>
            ',
            'order' => 2
        ]);

        // Questions 14-19: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'question_text' => 'Reading passage 2 has seven paragraphs, A-G. Which paragraph contains the following information? Write the correct letter, A-G, in boxes 14-19 on your answer sheet.<br>NB You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'A',
                'B' => 'B',
                'C' => 'C',
                'D' => 'D',
                'E' => 'E',
                'F' => 'F',
                'G' => 'G'
            ],
            'correct_answer' => null,
            'explanation' => '14:D, 15:G, 16:B, 17:E, 18:C, 19:B',
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'why chemically cleaning graffiti may cause damage', 'correct_answer' => 'D'],
                    ['id' => '15', 'label' => 'the benefit of a precautionary strategy on the gentle removal', 'correct_answer' => 'G'],
                    ['id' => '16', 'label' => 'the damaging and accumulative impact of graffiti on the community', 'correct_answer' => 'B'],
                    ['id' => '17', 'label' => 'the need for different preventive measures being taken to cope with graffiti', 'correct_answer' => 'E'],
                    ['id' => '18', 'label' => 'a legal proposal made to the owner of building against graffiti', 'correct_answer' => 'C'],
                    ['id' => '19', 'label' => 'the reasons for removing graffiti as soon as possible', 'correct_answer' => 'B'],
                ]
            ]
        ]);

        // Questions 20-21: Multiple Choice (Multiple Correct) - graffiti removal
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 20,
            'question_text' => 'Choose TWO letters, A-E. Write your answers in boxes 20-21 on your answer sheet.<br>Which two statements are true concerning the removal of graffiti?',
            'type' => 'multiple_choice_multiple',
            'options' => [
                'A' => 'cocktail removal can be safer than water treatment',
                'B' => 'small patch trial before applying large scale of removing',
                'C' => 'Chemical treatments are the most expensive way of removing',
                'D' => 'there are risks for both Chemical and medication method',
                'E' => 'mechanical removals are much more applicable than Chemical treatments',
            ],
            'correct_answer' => ['B', 'D'],
            'explanation' => 'B: Paragraph D - "small trial areas should be undertaken". D: Paragraph D - risks for both chemical and mechanical methods mentioned.',
            'data' => [
                'max_selections' => 2
            ]
        ]);

        // Questions 22-23: Multiple Choice (Multiple Correct) - preventive measures
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 22,
            'question_text' => 'Choose TWO letters, A-E. Write your answers in boxes 22-23 on your answer sheet.<br>Which TWO of the following preventive measures against graffiti are mentioned effectively in the passage?',
            'type' => 'multiple_choice_multiple',
            'options' => [
                'A' => 'organise more anti-graffiti movement in the city communities',
                'B' => 'increase the police patrols on the street',
                'C' => 'Build a new building with material repelling to water',
                'D' => 'installing more visible security cameras',
                'E' => 'Provide a whole new surface with a chemical coat',
            ],
            'correct_answer' => ['B', 'D'],
            'explanation' => 'B: Paragraph E - "Security patrols will also act as a deterrent". D: Paragraph E - "prominently placed cameras have been shown to reduce anti-social behavior".',
            'data' => [
                'max_selections' => 2
            ]
        ]);

        // Questions 24-27: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 24,
            'question_text' => '',
            'type' => 'summary_completion',
            'options' => null,
            'correct_answer' => [
                '24' => 'social history',
                '25' => 'tag',
                '26' => 'protective equipment',
                '27' => 'low-pressure water',
            ],
            'explanation' => '24: Paragraph A - "providing a social history". 25: Paragraph C - "tags". 26: Paragraph D - "protective equipment". 27: Paragraph G - "low-pressure water".',
            'data' => [
                'start_number' => 23,
                'instruction' => 'Complete the Summary of the paragraphs of Reading Passage 2. Use NO MORE THAN TWO WORDS from the passage for each answer. Write your answers in boxes 24-27 on your answer sheet.',
                'summary_text' => 'Ancient graffiti is of significance and records the <strong>[24]</strong> of details life for that period. The police can recognize newly committed incidents of graffiti by the signature which is called <strong>[25]</strong> that they are familiar with. Operatives ought to comply with relevant rules during the operation, and put on the suitable <strong>[26]</strong>. Removal of graffiti from a new type of coating surface can be much convenient of using <strong>[27]</strong>.',
                'placeholders' => [
                    '24' => 24, '25' => 25, '26' => 26, '27' => 27
                ]
            ]
        ]);

        // ==========================================
        // PASSAGE 3: The concept of childhood in the western countries
        // ==========================================
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The concept of childhood in the western countries',
            'content' => '
<p>The history of childhood has been a topic of interest in social history since the highly influential 1960 book Centuries of Childhood, written by French historian Philippe Ariès. He argued that "childhood" is a concept created by modern society.</p>

<p><strong>A</strong> One of the most hotly debated issues in the history of childhood has been whether childhood is itself a recent invention. The historian Philippe Aries argued that in Western Europe during the Middle Ages (up to about the end of the fifteenth century) children were regarded as miniature adults, with all the intellect and personality that this implies. He scrutinized medieval pictures and diaries and found no distinction between children and adults as they shared similar leisure activities and often the same type of work. Aries, however, pointed out that this is not to suggest that children were neglected, forsaken or despised. The idea of childhood is not to be confused with affection for children; it corresponds to an awareness of the particular nature of childhood, that particular nature which distinguishes the child from the adult, even the young adult.</p>

<p><strong>B</strong> There is a long tradition of the children of the poor playing a functional role in contributing to the family income by working either inside or outside the home. In this sense, children are seen as \'useful\'. Back in the Middle Ages, children as young as 5 or 6 did important chores for their parents and, from the sixteenth century, were often encouraged (or forced) to leave the family by the age of 9 or 10 to work as servants for wealthier families or to be apprenticed to a trade.</p>

<p><strong>C</strong> With industrialization in the eighteenth and nineteenth centuries, a new demand for child labour was created, and many children were forced to work for long hours, in mines, workshops and factories. Social reformers began to question whether labouring long hours from an early age would harm children\'s growing bodies. They began to recognize the potential of carrying out systematic studies to monitor how far these early deprivations might be affecting children\'s development.</p>

<p><strong>D</strong> Gradually, the concerns of the reformers began to impact on the working conditions of children. In Britain, the Factory Act of 1833 signified the beginning of legal protection of children from exploitation and was linked to the rise of schools for factory children. The worst forms of child exploitation were gradually eliminated, partly through factory reform but also through the influence of trade unions and economic changes during the nineteenth century which made some forms of child labour redundant. Childhood was increasingly seen as a time for play and education for all children, not just for a privileged minority. As the age for starting full-time work was delayed, so childhood was increasingly understood as a more extended phase of dependency, development and learning. Even so, work continued to play a significant, if the less central role in children\'s lives throughout the later nineteenth and twentieth century. And the \'useful child\' has become a controversial image during the first decade of the twenty-first century especially in the context of global concern about large numbers of the world\'s children engaged in child labour.</p>

<p><strong>E</strong> The Factory Act of 1833 established half-time schools which allowed children to work and attend school. But in the 1840s, a large proportion of children never went to school, and if they did, they left by the age of 10 or 11. The situation was very different by the end of the nineteenth century in Britain. The school became central to images of \'a normal\' childhood.</p>

<p><strong>F</strong> Attending school was no longer a privilege and all children were expected to spend a significant part of their day in a classroom. By going to school, children\'s lives were now separated from domestic life at home and from the adult world of work. The school became an institution dedicated to shaping the minds, behavior and morals of the young. Education dominated the management of children\'s waking hours, not just through the hours spent in classrooms but through \'home\' work, the growth of \'after school\' activities and the importance attached to \'parental involvement.\'</p>

<p><strong>G</strong> Industrialization, urbanization and mass schooling also set new challenges for those responsible for protecting children\'s welfare and promoting their learning. Increasingly, children were being treated as a group with distinctive needs and they were organized into groups according to their age. For example, teachers needed to know what to expect of children in their classrooms, what kinds of instruction were appropriate for different age groups and how best to assess children\'s progress. They also wanted tools that could enable them to sort and select children according to their abilities and potential.</p>
            ',
            'order' => 3
        ]);

        // Questions 28-34: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 28,
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 3? Write your answers in boxes 28-34 on your answer sheet.',
            'type' => 'true_false_not_given',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 27,
                'sub_questions' => [
                    ['id' => '28', 'label' => 'Aries pointed out that children did different types of works as adults during the Middle Age.', 'correct_answer' => 'FALSE'],
                    ['id' => '29', 'label' => 'During the Middle Age, going to work necessarily means children were unloved indicated Aries.', 'correct_answer' => 'FALSE'],
                    ['id' => '30', 'label' => 'Scientists think that overworked labour damages the health of young children.', 'correct_answer' => 'TRUE'],
                    ['id' => '31', 'label' => 'The rise of trade union majorly contributed to the protection of children from exploitation in the 19th century.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '32', 'label' => 'By the aid of half-time schools, most children went to school in the mid of 19 century.', 'correct_answer' => 'FALSE'],
                    ['id' => '33', 'label' => 'In 20 century almost all children need to go to school in a full-time schedule.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '34', 'label' => 'Nowadays, children\'s needs were much differentiated and categorised based on how old they are.', 'correct_answer' => 'TRUE'],
                ]
            ]
        ]);

        // Questions 35-40: Short Answer
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 35,
            'question_text' => 'Answer the questions below. Choose NO MORE THAN THREE WORDS from the passage for each answer. Write your answers in boxes 35-40 on your answer sheet.',
            'type' => 'short_answer_group',
            'options' => null,
            'correct_answer' => [
                '35' => 'history of childhood',
                '36' => 'miniature adults',
                '37' => 'industrialization',
                '38' => 'The factory',
                '39' => 'play and education',
                '40' => 'classroom',
            ],
            'explanation' => '35: Introduction - "The history of childhood". 36: Paragraph A - "miniature adults". 37: Paragraph C - "With industrialization". 38: Paragraph D - "Factory Act of 1833". 39: Paragraph D - "play and education". 40: Paragraph F - "spend a significant part of their day in a classroom".',
            'data' => [
                'start_number' => 34,
                'sub_questions' => [
                    ['id' => '35', 'label' => 'What is the controversial topic arises with the French historian Philippe Ariès\'s concept?', 'correct_answer' => 'history of childhood'],
                    ['id' => '36', 'label' => 'What image for children did Aries believed to be like in Western Europe during the Middle Ages?', 'correct_answer' => 'miniature adults'],
                    ['id' => '37', 'label' => 'What historical event generated the need for great amount child labour to work a long time in 18 and 19 century?', 'correct_answer' => 'industrialization'],
                    ['id' => '38', 'label' => 'What legal format initiated the protection of children from exploitation in 19th centenary?', 'correct_answer' => 'The factory'],
                    ['id' => '39', 'label' => 'What the activities were more and more regarded as being preferable for almost all children time in 19th centenary?', 'correct_answer' => 'play and education'],
                    ['id' => '40', 'label' => 'Where has been the central area for children to spend largely of their day as people\'s expectation in modern society?', 'correct_answer' => 'classroom'],
                ]
            ]
        ]);
    }
}
