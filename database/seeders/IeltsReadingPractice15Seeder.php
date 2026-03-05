<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice15Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 15;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Bamboo, A Wonder Plant',
            'content' => '
<p>The wonder plant with an uncertain future: more than a billion people rely on bamboo for either their shelter or income, while many endangered species depend on it for their survival. Despite its apparent abundance, a new report says that species of bamboo may be under serious threat.</p>

<p><strong>Section A</strong></p>
<p>Every year, during the rainy season, the mountain gorillas of Central Africa migrate to the foothills and lower slopes of the Virunga Mountains to graze on bamboo. For the 650 or so that remain in the wild, it’s a vital food source. Although they at almost 150 types of plant, as well as various insects and other invertebrates, at this time of year bamboo accounts for up to 90 per cent of their diet. Without it, says Ian Redmond, chairman of the Ape Alliance, their chances of survival would be reduced significantly. Gorillas aren’t the only locals keen on bamboo. For the people who live close to the Virungas, it’s a valuable and versatile raw material used for building houses and making household items such as mats and baskets. But in the past 100 years or so, resources have come under increasing pressure as populations have exploded and large areas of bamboo forest have been cleared to make way for farms and commercial plantations.</p>

<p><strong>Section B</strong></p>
<p>Sadly, this isn’t an isolated story. All over the world, the ranges of many bamboo species appear to be shrinking, endangering the people and animals (that depend upon them). But despite bamboo’s importance, we know surprisingly little about it. A recent report published by the UN Environment Programme (UNEP) and the International Network for Bamboo and Rattan (INBAR) has revealed just how profound is our ignorance of global bamboo resources, particularly in relation to conservation. There are almost 1,600 recognised species of bamboo, but the report concentrated on the 1,200 or so woody varieties distinguished by the strong stems, or culms, that most people associate with this versatile plant. Of these, only 38 ‘priority species’ identified for their commercial value have been the subject of any real scientific research, and this has focused mostly on matters relating to their viability as a commodity. This problem isn’t confined to bamboo. Compared to the work carried out on animals, the science of assessing the conservation status of plants is still in its infancy. “People have only started looking hard at this during the past 10-15 years, and only now are they getting a handle on how to go about it systematically,” says Dr Valerie Kapos, one of the report’s authors and a senior adviser in forest ecology and conservation to the UNEP.</p>

<p><strong>Section C</strong></p>
<p>Bamboo is a type of grass. It comes in a wide variety of forms, ranging in height from 30 centimetres to more than 40 metres. It is also the world’s fastest-growing woody plant: some species can grow more than a metre in a day. Bamboo’s ecological rote extends beyond providing food and habitat for animals. Bamboo tends to grow in stands made up of groups of individual plants that grow from root systems known as rhizomes. Its extensive rhizome systems, which tie in the top layers of the soil, are crucial in preventing soil erosion. And there is growing evidence that bamboo plays an important part in determining forest structure and dynamics. “Bamboo’s pattern of mass flowering and mass death leaves behind large areas of dry biomass that attract wildfire,” says Kapos. “When these burn, they create patches of open ground within the forest far bigger than would be left by a fallen tree.” Patchiness helps to preserve diversity because certain plant species do better during the early stages of regeneration when there are gaps in the canopy.</p>

<p><strong>Section D</strong></p>
<p>However, bamboo’s most immediate significance lies in its economic value. Modern processing techniques mean that it can be used in a variety of ways, for example, as flooring and laminates. One of the fastest-growing bamboo products is paper-25 per cent of paper produced in India is made from bamboo fiber, and in Brazil, 100,000 hectares of bamboo is grown for its production. Of course, bamboo’s main function has always been in domestic applications, and as a locally traded commodity, it’s worth about US$4.5 billion annually. Because of its versatility, flexibility and strength (its tensile strength compares to that of some steel), it has traditionally been used in construction. Today, more than one billion people worldwide live in bamboo houses. Bamboo is often the only readily available raw material for people in many developing countries, says Chris Staple-ton, a research associate at the Royal Botanic Gardens. “Bamboo can be harvested from forest areas or grown quickly elsewhere, and then converted simply without expensive machinery or facilities,” he says. “In this way, it contributes substantially to poverty alleviation and wealth creation.”</p>

<p><strong>Section E</strong></p>
<p>Given bamboo’s value in economic and ecological terms, the picture painted by the UNEP report is all the more worrying. But keen horticulturists will spot an apparent contradiction here. Those who’ve followed the recent vogue for cultivating exotic species in their gardens will point out that if it isn’t kept in check, bamboo can cause real problems. “In a lot of places, the people who live with bamboo don’t perceive it as being endangered in any way,” says Kapos. “In fact, a lot of bamboo species are actually very invasive if they’ve been introduced.” So why are so many species endangered? There are two separate issues here, says Ray Townsend, vice president of the British Bamboo Society and arboretum manager at the Royal Botanic Gardens. “Some plants are threatened because they can’t survive in the habitat – they aren’t strong enough or there aren’t enough of them, perhaps. But bamboo can take care of itself – it is strong enough to survive if left alone. What is under threat is its habitat.” It is the physical disturbance that is the threat to bamboo, says Kapos. “When forest goes, it is converted into something else: there isn’t any-where for forest plants such as bamboo to grow if you create a cattle pasture.”</p>

<p><strong>Section F</strong></p>
<p>Around the world, bamboo species are routinely protected as part of forest eco-systems in national parks and reserves, but there is next to nothing that protects bamboo in the wild for its own sake. However, some small steps are being taken to address this situation. The UNEP-INBAR report will help conservationists to establish effective measures aimed at protecting valuable wild bamboo species. Towns end, too, see the UNEP report as an important step forward in promoting the cause of bamboo conservation. “Until now, bamboo has been perceived as a second-class plant. When you talk about places such as the Amazon, everyone always thinks about the hardwoods. Of course, these are significant, but there is a tendency to overlook the plants they are associated with, which are often bamboo species. In many ways, it is the most important plant known to man. I can’t think of another plant that is used so much and is so commercially important in so many countries.” He believes that the most important first step is to get scientists into the field. “We need to go out there, look at these plants and see how they survive and then use that information to conserve them for the future.”</p>',
            'order' => 1,
        ]);

        // Questions 1-7: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'matching_paragraph_information',
            'question_text' => 'Reading Passage 1 has six section A-F.<br>Which section contains the following information?<br>Write the correct letter A-F in boxes 1-7 on your answer sheet<br>NB You may use any letter more than once',
            'options' => [
                'A' => 'Section A',
                'B' => 'Section B',
                'C' => 'Section C',
                'D' => 'Section D',
                'E' => 'Section E',
                'F' => 'Section F',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'The limited extent of existing research', 'correct_answer' => 'B'],
                    ['id' => '2', 'label' => 'Comparison of bamboo with other plant species', 'correct_answer' => 'E'],
                    ['id' => '3', 'label' => 'Commercial application of bamboo', 'correct_answer' => 'D'],
                    ['id' => '4', 'label' => 'Example of an animal which relies on bamboos for survival', 'correct_answer' => 'A'],
                    ['id' => '5', 'label' => 'The human activity that damaged large areas of bamboo', 'correct_answer' => 'A'],
                    ['id' => '6', 'label' => 'The approaches used to study bamboo', 'correct_answer' => 'B'],
                    ['id' => '7', 'label' => 'Bamboo helps the survival of a range of plants', 'correct_answer' => 'C'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 8-11: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 8,
            'type' => 'matching_features',
            'question_text' => 'Use the information in the passage to match the people (listed A-D) with opinions or deeds below.<br>Write the appropriate letters A-D in boxes 8-11 on your answer sheet.<br>NB You may use any letter more than once',
            'options' => [
                'A' => 'Ian Redmond',
                'B' => 'Valerie Kapos',
                'C' => 'Ray Townsend',
                'D' => 'Chris Stapleton'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of People',
                'start_number' => 7,
                'sub_questions' => [
                    ['id' => '8', 'label' => 'Destroying bamboo jeopardizes to wildlife.', 'correct_answer' => 'A'],
                    ['id' => '9', 'label' => 'People have very confined knowledge of bamboo.', 'correct_answer' => 'B'],
                    ['id' => '10', 'label' => 'Some people do not think that bamboo is endangered.', 'correct_answer' => 'B'],
                    ['id' => '11', 'label' => 'Bamboo has loads of commercial potentials.', 'correct_answer' => 'D'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 12-13: Short Answer
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 12,
            'type' => 'short_answer_group',
            'question_text' => 'Answer the questions below using <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.<br>Write your answers in boxes 12-13 on your answer sheet',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 11,
                'sub_questions' => [
                    ['id' => '12', 'label' => 'What problem does the bamboo’s root system prevent?', 'correct_answer' => 'Soil erosion'],
                    ['id' => '13', 'label' => 'Which bamboo product is experiencing market expansion?', 'correct_answer' => 'paper'],
                ]
            ],
            'order' => 3,
        ]);


        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Activities for Children',
            'content' => '
<p><strong>A</strong></p>
<p>Twenty-five years ago, children in London walked to school and played in parks and playing fields after school and at the weekend. Today they are usually driven to school by parents anxious about safety and spend hours glued to television screens or computer games. Meanwhile, community playing fields are being sold off to property developers at an alarming rate. ‘This change in lifestyle has, sadly, meant greater restrictions on children,’ says Neil Armstrong, Professor of Health and Exercise Sciences at the University of Exeter. ‘If children continue to be this inactive, they’ll be storing up big problems for the future.’</p>

<p><strong>B</strong></p>
<p>In 1985, Professor Armstrong headed a five-year research project into children’s fitness. The results, published in 1990, were alarming. The survey, which monitored 700 11-16-year-olds, found that 48 per cent of girls and 41 per cent of boys already exceeded safe cholesterol levels set for children by the American Heart Foundation. Armstrong adds, “heart is a muscle and need exercise, or it loses its strength.” It also found that 13 per cent of boys and 10 per cent of girls were overweight. More disturbingly, the survey found that over a four-day period, half the girls and one-third of the boys did less exercise than the equivalent of a brisk 10-minute walk. High levels of cholesterol, excess body fat and inactivity are believed to increase the risk of coronary heart disease.</p>

<p><strong>C</strong></p>
<p>Physical education is under pressure in the UK – most schools devote little more than 100 minutes a week to it in curriculum time, which is less than many other European countries. Three European countries are giving children a head start in PE, France, Austria and Switzerland – offer at least two hours in primary and secondary schools. These findings, from the European Union of Physical Education Associations, prompted specialists in children’s physiology to call on European governments to give youngsters a daily PE programme. The survey shows that the UK ranks 13th out of the 25 countries, with Ireland’s bottom, averaging under an hour a week for PE. From age six to 18, British children received, on average, 106 minutes of PE a week. Professor Armstrong, who presented the findings at the meeting, noted that since the introduction of the national curriculum there had been a marked fall in the time devoted to PE in UK schools, with only a minority of pupils getting two hours a week.</p>

<p><strong>D</strong></p>
<p>As a former junior football international, Professor Armstrong is a passionate advocate for the sport. Although the Government has poured millions into beefing up the sport in the community, there is less commitment to it as part of the crammed school curriculum. This means that many children never acquire the necessary skills to thrive in team games. If they are no good at them, they lose interest and establish an inactive pattern of behaviour. When this is coupled with a poor diet, it will lead inevitably to weight gain. Seventy per cent of British children gives up all sport when they leave school, compared with only 20 per cent of French teenagers. Professor Armstrong believes that there is far too great an emphasis on team games at school. “We need to look at the time devoted to PE and balance it between individual and pair activities, such as aerobics and badminton, as well as team sports. “He added that children need to have the opportunity to take part in a wide variety of individual, partner and team sports.</p>

<p><strong>E</strong></p>
<p>The good news, however, is that a few small companies and children’s activity groups have reacted positively and creatively to the problem. ‘Take That, shouts Gloria Thomas, striking a disco pose astride her mini-space hopper. ‘Take That, echo a flock of toddlers, adopting outrageous postures astride their space hoppers. ‘Michael Jackson, she shouts, and they all do a spoof fan-crazed shriek. During the wild and chaotic hopper race across the studio floor, commands like this are issued and responded to with untrammeled glee. The sight of 15 bouncing seven-year-olds who seem about to launch into orbit at every bounce brings tears to the eyes. Uncoordinated, loud, excited and emotional, children provide raw comedy.</p>

<p><strong>F</strong></p>
<p>Any cardiovascular exercise is a good option, and it doesn’t necessarily have to be high intensity. It can be anything that gets your heart rate up: such as walking the dog, swimming, running, skipping, hiking. “Even walking through the grocery store can be exercise,” Samis-Smith said. What they don’t know is that they’re at a Fit Kids class and that the fun is a disguise for the serious exercise plan they’re covertly being taken through. Fit Kids trains parents to run fitness classes for children. ‘Ninety per cent of children don’t like team sports,’ says company director, Gillian Gale.</p>

<p><strong>G</strong></p>
<p>A Prevention survey found that children whose parents keep in shape are much more likely to have healthy body weights themselves. “There’s nothing worse than telling a child what he needs to do and not doing it yourself,” says Elizabeth Ward, R.D., a Boston nutritional consultant and author of Healthy Foods, Healthy Kids. “Set a good example and get your nutritional house in order first.” In the 1930s and ‘40s, kids expended 800 calories a day just walking, carrying water, and doing other chores, notes Fima Lifshitz, M.D., a pediatric endocrinologist in Santa Barbara. “Now, kids in obese families are expending only 200 calories a day in physical activity,” says Lifshitz, “incorporate more movement in your family’s life – park farther away from the stores at the mall, take stairs instead of the elevator, and walk to nearby friends’ houses instead of driving.”</p>',
            'order' => 2,
        ]);

        // Questions 14-17: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'matching_paragraph_information',
            'question_text' => 'The Reading Passage has seven paragraphs A-G<br>Which paragraph contains the following information?<br>Write the correct letter A-G, in boxes 14-17 on your answer sheet.',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E',
                'F' => 'Paragraph F',
                'G' => 'Paragraph G',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'Health and living condition of children', 'correct_answer' => 'A'],
                    ['id' => '15', 'label' => 'Health organization monitored physical activity', 'correct_answer' => 'B'],
                    ['id' => '16', 'label' => 'Comparison of exercise time between the UK and other countries', 'correct_answer' => 'C'],
                    ['id' => '17', 'label' => 'Wrong approach for school activity', 'correct_answer' => 'D'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 18-21: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 18,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 2?<br>In boxes 18-21 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 17,
                'sub_questions' => [
                    ['id' => '18', 'label' => 'According to the American Heart Foundation, cholesterol levels of boys are higher than girls’.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '19', 'label' => 'British children generally do less exercise than some other European countries.', 'correct_answer' => 'TRUE'],
                    ['id' => '20', 'label' => 'Skipping becomes more and more popular in schools in the UK.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '21', 'label' => 'According to Healthy Kids, the first task is for parents to encourage their children to keep the same healthy body weight.', 'correct_answer' => 'FALSE'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 22-26: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 22,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 22-26 on your answer sheet.',
            'options' => [
                'A' => 'Spending more time on TV affect the academic level',
                'B' => 'Parents have less time to stay with their children',
                'C' => 'Future health of British children',
                'D' => 'Increasing speed of property’s development'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 21,
                'sub_questions' => [
                    ['id' => '22', 'label' => 'According to paragraph A, what does Professor Neil Armstrong concern about?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 23,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'We need to take a 10-minute walk every day',
                'B' => 'We should do more activity to exercise heart',
                'C' => 'Girls’ situation is better than boys',
                'D' => 'Exercise can cure many diseases'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 22,
                'sub_questions' => [
                    ['id' => '23', 'label' => 'What does Armstrong indicate in Paragraph B?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 4,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 24,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Make profit by running several sessions',
                'B' => 'Only concentrate on one activity for each child',
                'C' => 'To guide parents on how to organize activities for children',
                'D' => 'Spread the idea that team sport is better'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 23,
                'sub_questions' => [
                    ['id' => '24', 'label' => 'What is the aim of First Kids’ training?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 5,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 25,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Create opportunities to exercise your body',
                'B' => 'Taking elevator saves your time',
                'C' => 'Kids should spend more than 200 calories each day',
                'D' => 'We should never drive but walk'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 24,
                'sub_questions' => [
                    ['id' => '25', 'label' => 'What did Lifshitz suggest at the end of this passage?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 6,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 26,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'health of the children who are overweight is at risk in the future',
                'B' => 'Children in the UK need proper exercises',
                'C' => 'Government mistaken approach for children',
                'D' => 'Parents play the most important role in children’s activity'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 25,
                'sub_questions' => [
                    ['id' => '26', 'label' => 'What is the main idea of this passage?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 7,
        ]);


        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Save Endangered Language',
            'content' => '
<p>“Obviously we must do some serious rethinking of our priorities, lest linguistics go down in history as the only science that presided obviously over the disappearance of 90 percent of the very field to which it is dedicated.” – Michael Krauss, “The World’s Languages in Crisis”.</p>

<p><strong>A</strong></p>
<p>Ten years ago Michael Krauss sent a shudder through the discipline of linguistics with his prediction that half the 6,000 or so languages spoken in the world would cease to be uttered within a century. Unless scientists and community leaders directed a worldwide effort to stabilize the decline of local languages, he warned, nine-tenths of the linguistic diversity of humankind would probably be doomed to extinction. Krauss’s prediction was little more than an educated guess, but other respected linguists had been clanging out similar alarms. Keneth L. Hale of the Massachusetts Institute of Technology noted in the same journal issue that eight languages on which he had done fieldwork had since passed into extinction. A 1990 survey in Australia found that 70 of the 90 surviving Aboriginal languages were no longer used regularly by all age groups. The same was true for all but 20 of the 175 Native American languages spoken or remembered in the US., Krauss told a congressional panel in 1992.</p>

<p><strong>B</strong></p>
<p>Many experts in the field mourn the loss of rare languages, for several reasons. To start, there is scientific self-interest: some of the most basic questions in linguistics have to do with the limits of human speech, which are far from fully explored. Many researchers would like to know which structural elements of grammar and vocabulary – if any – are truly universal and probably, therefore, hardwired into the human brain. Other scientists try to reconstruct ancient migration patterns by comparing borrowed words that appear in otherwise unrelated languages. In each of these cases, the wider the portfolio of languages you study, the more likely you are to get the right answers.</p>

<p><strong>C</strong></p>
<p>Despite the near-constant buzz in linguistics about endangered languages over the past 10 years, the field has accomplished depressingly little. “You would think that there would be some organized response to this dire situation,” some attempt to determine which language can be saved and which should be documented before they disappear, says Sarah G. Thomason, a linguist at the University of Michigan at Ann Arbor. “But there isn’t any such effort organized in the profession. It is only recently that it has become fashionable enough to work on endangered languages.” Six years ago, recalls Douglas H. Whalen of Yale University, “when I asked linguists who were raising money to deal with these problems, I mostly got blank stares.” So Whalen and a few other linguists founded the Endangered Languages Fund. In the five years to 2001, they were able to collect only $80,000 for research grants. A similar foundation in England, directed by Nicholas Ostler, has raised just $8,000 since 1995.</p>

<p><strong>D</strong></p>
<p>But there are encouraging signs that the field has turned a corner. The Volkswagen Foundation, a German charity, just issued its second round of grants totaling more than $2 million. It has created a multimedia archive at the Max Planck Institute for Psycholinguistics in the Netherlands that can house recordings, grammars, dictionaries and other data on endangered languages. To fill the archive, the foundation has dispatched field linguists to document Aweti (100 or so speakers in Brazil), Ega (about 300 speakers in Ivory Coast), Waima’a (a few hundred speakers in East Timor), and a dozen or so other languages unlikely to survive the century. The Ford Foundation has also edged into the arena. Its contributions helped to reinvigorate a master-apprentice program created in 1992 by Leanne Hinton of Berkeley and Native Americans worried about the imminent demise of about 50 indigenous languages in California. Fluent speakers receive $3,000 to teach a younger relative (who is also paid) their native tongue through 360 hours of shared activities, spread over six months. So far about 5 teams have completed the program, Hinton says, transmitting a least some knowledge of 25 languages. “It’s too early to call this language revitalization,” Hinton admits. “In California, the death rate of elderly speakers will always be greater than the recruitment rate of young speakers. But at least we prolong the survival of the language.” That will give linguists more time to record these tongues before they vanish.</p>

<p><strong>E</strong></p>
<p>But the master-apprentice approach hasn’t caught on outside the U.S., and Hinton’s effort is a drop in the sea. At least 440 languages have been reduced to a mere handful of elders, according to the Ethnologue, a catalogue of languages produced by the Dallas-based group SIL International that comes closest to global coverage. For the vast majority of these languages, there is little or no record of their grammar, vocabulary, pronunciation or use in daily life. Even if a language has been fully documented, all that remains once it vanishes from active use is a fossil skeleton, a scattering of features that the scientist was lucky and astute enough to capture. Linguists may be able to sketch an outline of the forgotten language and fix its place on the evolutionary tree, but little more. “How did people start conversations and talk to babies? How dis husbands and wives converse?” Hinton asks. “Those are the first things you want to learn when you want to revitalize the language.”</p>

<p><strong>F</strong></p>
<p>But there is as yet no discipline of “conservation linguistics,” as there is for biology. Almost every strategy tried so far has succeeded in some places but failed in others, and there seems to be no way to predict with certainty what will work where. Twenty years ago in New Zealand, Maori speakers set up “language nests,” in which preschoolers were immersed in the native language. Additional Maori-only classes were added as the children progressed through elementary and secondary school. A similar approach was tried in Hawaii, with some success – the number of native speakers has stabilized at 1,000 or so, reports Joseph E. Grimes of SIL International, who is working on Oahu. Students can now get instruction in Hawaiian all the way through university.</p>

<p><strong>G</strong></p>
<p>One factor that always seems to occur in the demise of a language is that the speakers begin to have collective doubts about the usefulness of language loyalty. Once they start regarding their own language as inferior to the majority language, people stop using it in all situations. Kids pick up on the attitude and prefer the dominant language. In many cases, people don’t notice until they suddenly realize that their kids never speak the language, even at home. This is how Cornish and some dialects of Scottish Gaelic is still only rarely used for daily home life in Ireland, 80 years after the republic was founded with Irish as its first official language.</p>

<p><strong>H</strong></p>
<p>Linguists agree that ultimately, the answer to the problem of language extinction is multilingualism. Even uneducated people can learn several languages, as long as they start as children. Indeed, most people in the world speak more than one tongue, and in places such as Cameroon (279 languages), Papua New Guinea (823) and India (387) it is common to speak three of four distinct languages and a dialect or two as well. Most Americans and Canadians, to the west of Quebec, have a gut reaction that anyone speaking another language in front of them is committing an immoral act. You get the same reaction in Australia and Russia. It is no coincidence that these are the areas where languages are disappearing the fastest. The first step in saving dying languages is to persuade the world’s majorities to allow the minorities among them to speak with their own voices.</p>',
            'order' => 3,
        ]);

        // Questions 27-33: Matching Headings
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'matching_headings',
            'question_text' => 'The reading passage has eight paragraphs, A-H<br>Choose the correct heading for paragraphs A-H from the list below.<br>Write the correct number, i-xi, in boxes 27-33 on your answer sheet.',
            'options' => [
                'i' => 'data consistency needed for language',
                'ii' => 'consensuses on an initial recommendation for saving dying out languages',
                'iii' => 'positive gains for protection',
                'iv' => 'minimum requirement for saving a language',
                'v' => 'Potential threat to minority language',
                'vi' => 'a period when there was absent of real effort made.',
                'vii' => 'native language programs launched',
                'viii' => 'Lack of confidence in young speakers as a negative factor',
                'ix' => 'Practise in several developing countries',
                'x' => 'Value of minority language to linguists.',
                'xi' => 'government participation in the language field'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of headings',
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'Paragraph A', 'correct_answer' => 'v'],
                    ['id' => '28', 'label' => 'Paragraph B', 'correct_answer' => 'x'],
                    ['id' => '29', 'label' => 'Paragraph D', 'correct_answer' => 'iii'],
                    ['id' => '30', 'label' => 'Paragraph E', 'correct_answer' => 'i'],
                    ['id' => '31', 'label' => 'Paragraph F', 'correct_answer' => 'vii'],
                    ['id' => '32', 'label' => 'Paragraph G', 'correct_answer' => 'viii'],
                    ['id' => '33', 'label' => 'Paragraph H', 'correct_answer' => 'ii'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 34-38: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 34,
            'type' => 'matching_features',
            'question_text' => 'Use the information in the passage to match the people (listed A-F) with opinions or deeds below.<br>Write the appropriate letters A-F in boxes 34-38 on your answer sheet.',
            'options' => [
                'A' => 'Nicholas Ostler',
                'B' => 'Michael Krauss',
                'C' => 'Joseph E. Grimes',
                'D' => 'Sarah G. Thomason',
                'E' => 'Keneth L. Hale',
                'F' => 'Douglas H. Whalen'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of People',
                'start_number' => 33,
                'sub_questions' => [
                    ['id' => '34', 'label' => 'Reported language conservation practice in Hawaii', 'correct_answer' => 'C'],
                    ['id' => '35', 'label' => 'Predicted that many languages would disappear soon', 'correct_answer' => 'B'],
                    ['id' => '36', 'label' => 'The experienced process that languages die out personally', 'correct_answer' => 'E'],
                    ['id' => '37', 'label' => 'Raised language fund in England', 'correct_answer' => 'A'],
                    ['id' => '38', 'label' => 'Not enough effort on saving until recent work', 'correct_answer' => 'D'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 39-40: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 39,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 39-40 on your answer sheet.',
            'options' => [
                'A' => 'Teach children how to speak',
                'B' => 'Revive some endangered languages in California',
                'C' => 'postpone the dying date for some endangered languages',
                'D' => 'Increase communication between students'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 38,
                'sub_questions' => [
                    ['id' => '39', 'label' => 'What is the real result of a master-apprentice program sponsored by The Ford Foundation?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 40,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'They should teach their children endangered language in free lessons',
                'B' => 'They should learn at least four languages',
                'C' => 'They should now their loyalty to a dying language',
                'D' => 'They should be more tolerant of minority language speaker'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 39,
                'sub_questions' => [
                    ['id' => '40', 'label' => 'What should the majority language speakers do according to the last paragraph?', 'correct_answer' => 'D']
                ]
            ],
            'order' => 4,
        ]);

    }
}
