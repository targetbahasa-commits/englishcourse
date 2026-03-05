<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice11Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 11;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'decibel Hell',
            'content' => '
<p><strong>Section A decibel Hell:</strong></p>
<p>It’s not difficult for a person to encounter sound at levels that can cause adverse health effects. During a single day, people living in a typical urban environment can experience a wide range of sounds in many locations, even once-quiet locales have become polluted with noise. In fact, it’s difficult today to escape sound completely. In its 1999 Guidelines for Community Noise, the World Health Organization (WHO) declared, “Worldwide, noise-induced hearing impairment is the most prevalent irreversible occupational hazard, and it is estimated that 120 million people worldwide have disabling hearing difficulties.” Growing evidence also points to many other health effects of too much volume.</p>
<p>Mark Stephenson, a Cincinnati, Ohio-based senior research audiologist at the National Institute for Occupational Safety and Health (NIOSH), says his agency’s definition of hazardous noise is sound that exceeds the time-weighted average of 85 dBA, meaning the average noise exposure measured over a typical eight-hour workday. Other measures and definitions are used for other purposes.</p>

<p><strong>Section B Growing Volume</strong></p>
<p>In the United States, about 30 million workers are exposed to hazardous sound levels on the job, according to NIOSH. Industries having a high number of workers exposed to loud sounds include construction, agriculture, mining, manufacturing, utilities, transportation, and the military.</p>
<p>Noise in U.S. industry is an extremely difficult problem to monitor, acknowledges Craig Moulton, a senior industrial hygienist for the Occupational Safety and Health Administration (OSHA). “Still,” he says, “OSHA does require that any employer with workers overexposed to noise provide protection for those employees against the harmful effects of noise. Additionally, employers must implement a continuing, effective hearing conservation program as outlined in OSHA’s Noise Standard.”</p>

<p><strong>Section C Scary Sound Effects</strong></p>
<p>Numerous scientific studies over the years have confirmed that exposure to certain levels of sound can damage hearing. Prolonged exposure can actually change the structure of the hair cells in the inner ear, resulting in hearing loss. It can also cause tinnitus, a ringing, roaring, buzzing, or clicking on the ears.</p>
<p>NIOSH studies from the mid to late 1990s show that 90% of coal miners have hearing impairment by age 52 – compared to 9% of the general population – and 70% of male metal/nonmetal miners will experience hearing impairment by age 60 (Stephenson notes that from adolescence onward, females tend to have better hearing than males). Neitzel says nearly half of all construction workers have some degree of hearing loss. “NIOSH research also reveals that by age twenty-five, the average carpenter’s hearing is equivalent to an otherwise healthy fifty-year-old male who hasn’t been exposed to noise,” he says.</p>
<p>William Luxford, medical director of the House Ear Clinic of St. Vincent Medical Center in Los Angeles, points out one piece of good news: “It’s true that continuous noise exposure will lead to the continuation of hearing loss, but as soon as the exposure is stopped, the hearing loss stops. So a change in environment can improve a person’s hearing health.”</p>
<p>Research is catching up with this anecdotal evidence. In the July 2001 issue of Pediatrics, researchers from the Centers for Disease Control and Prevention reported that, based on audiometric testing of 5,249 children as part of the Third National Health and Nutrition, Examination Survey, an estimated 12.5% of American children have noise-induced hearing threshold shifts – or dulled hearing – in one or both ears. Most children with noise-induced hearing threshold shifts have only limited hearing damage, but continued exposure to excessive noise can lead to difficulties with high-frequency sound discrimination. The report listed stereos, music concerts, toys (such as toy telephones and certain rattles), lawnmowers, and fireworks as producing potentially harmful sounds.</p>

<p><strong>Section D Beyond the Ears</strong></p>
<p>The effects of sound don’t stop with the ears. Nonauditory effects of noise exposure are those effects that don’t cause hearing loss but still can be measured, such as elevated blood pressure, loss of sleep, increased heart rate, cardiovascular constriction, labored breathing, and changes in brain chemistry.</p>
<p>The nonauditory effects of noise were noted as early as 1930 in a study published by E.L. Smith and D.L. Laird in volume 2 of the Journal of the Acoustical Society of America. The results showed that exposure to noise caused stomach contractions in healthy human beings. Reports on noise’s nonauditory effects published since that pioneering study have been both contradictory and controversial in some areas.</p>
<p>Bronzaft and the school principal persuaded the school board to have acoustical tile installed in the classrooms adjacent to the tracks. The Transit Authority also treated the tracks near the school to make them less noisy. A follow-up study published in the September 1981 issue of the Journal of Environmental Psychology found that children’s reading scores improved after these interventions were put in place.</p>

<p><strong>Section E Fighting for Quiet</strong></p>
<p>Anti-noise activists say that Europe and several countries in Asia are more advanced than the United States in terms of combating noise. “Population pressure has prompted Europe to move more quickly on the noise issue that the United States has,” Hume says. In the European Union, countries with cities of at least 250,000 people are creating noise maps of those cities to help leaders determine noise pollution policies. Paris has already prepared its first noise maps. The map data, which must be finished by 2007, will be fed into computer models that will help test the sound impact of street designs or new buildings before construction begins.</p>
<p>Activists in other countries say they too want the United States to play a more leading role on the noise issue. But as in other areas of environmental health, merely having a more powerful government agency in place that can set more regulations is not the ultimate answer, according to other experts. Bronzaft stresses that governments worldwide need to increase funding for noise research and do a better job coordinating their noise pollution efforts so they can establish health and environmental policies based on solid scientific research. “Governments have a responsibility to protect their citizens by curbing noise pollution,” she says.</p>',
            'order' => 1,
        ]);

        // Questions 1-5: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '1' => '85 dBA',
                '2' => 'hearing impairment',
                '3' => 'high-frequency',
                '4' => 'stomach contractions',
                '5' => 'noise maps',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'instruction' => 'Complete the summary below.<br>Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.',
                'summary_text' => 'Nowadays it seems difficult for people to avoid the effects of living in a noisy world. Noise is the sound beyond the average of <strong>[1]</strong> referring to the agency’s definition. Scientific studies over the years from the mid to late 1990s have confirmed that exposure to certain levels of sound can cause damage <strong>[2]</strong> on certain senior age.<br><br>From the testing of 5,249 children, those who are constantly exposed to excessive noise may have trouble in <strong>[3]</strong> sound discrimination. The effects of sound don’t stop with the ears, exposure to noise may lead to the unease of <strong>[4]</strong> in healthy people. Europe has taken steps on the noise issue, big cities of over 250,000 people are creating <strong>[5]</strong> to help to create noise pollution policies.',
                'placeholders' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5
                ]
            ],
            'order' => 1,
        ]);


        // Questions 6-10: Matching Researcher with Finding
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 6,
            'type' => 'matching_features',
            'question_text' => 'Look at the following researchers and the list of findings below. Match each researcher with the correct finding.',
            'options' => [
                "A" => "WHO",
                "B" => "William Luxford (the House Ear Clinic)",
                "C" => "Craig Moulton (OSHA)",
                "D" => "Arline Bronzaft",
                "E" => "Centers for Disease Control and Prevention"
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of Findings',
                'start_number' => 5,
                'sub_questions' => [
                    ['id' => '6', 'label' => 'People can change the environment to improve hearing health.', 'correct_answer' => 'B'],
                    ['id' => '7', 'label' => 'The government should continue the research on anti-noise researches with the fund.', 'correct_answer' => 'D'],
                    ['id' => '8', 'label' => 'companies should be required to protect the employees to avoid noise', 'correct_answer' => 'C'],
                    ['id' => '9', 'label' => 'Noise has posed an effect on American children’s hearing ability', 'correct_answer' => 'E'],
                    ['id' => '10', 'label' => 'noise has seriously affected human being where they live worldwide', 'correct_answer' => 'A']
                ]
            ],
            'order' => 2,
        ]);
        
        // Question 11: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 11,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter A, B, C or D.<br>Write your answers in boxes 11-13 on your answer sheet.<br>',
            'options' => [
                'A' => 'moved the classrooms away from the noisy track',
                'B' => 'regulated the track usage to a less extent',
                'C' => 'utilised a special material into classroom buildings lessening the effect of outside noise',
                'D' => 'organised a team for a follow-up study'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 10,
                'sub_questions' => [
                    ['id' => '11', 'label' => 'The board of schools built close to the tracks are convinced to', 'correct_answer' => 'C']
                ]
            ],
            'order' => 3,
        ]);

        // Question 12: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 12,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'How to record pollution details of the city on maps',
                'B' => 'the impact of noise on population shift in the European cities',
                'C' => 'how wide can a city be to avoid noise pollution',
                'D' => 'helping the authorities better make a decision on management of the city'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 11,
                'sub_questions' => [
                    ['id' => '12', 'label' => 'In European countries, the big cities’ research on noise focuses on', 'correct_answer' => 'D']
                ]
            ],
            'order' => 4,
        ]);

        // Question 13: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 13,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'How people cope with noise pollutions',
                'B' => 'the fight against the noise with the powerful technology',
                'C' => 'The Effects of Living in a Noisy World',
                'D' => 'The Effects of noise on children’s learning'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 12,
                'sub_questions' => [
                    ['id' => '13', 'label' => 'What is the best title in paragraph 1?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 5,
        ]);

        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'TV Addiction 1',
            'content' => '
<p><strong>A</strong></p>
<p>The amount of time people spend watching television is astonishing. On average, individuals in the industrialized world devote three hours a day to the pursuit – fully half of their leisure time, and more than on any single activity save work and sleep. At this rate, someone who lives to 75 would spend nine years in front of the tube. To some commentators, this devotion means simply that people enjoy TV and make a conscious decision to watch it. But if that is the whole story, why do so many people experience misgivings about how much they view? In Gallup polls in 1992 and 1999, two out of five adult respondents and seven out of 10 teenagers said they spent too much time watching TV. Other surveys have consistently shown that roughly 10 percent of adults calls themselves TV addicts.</p>

<p><strong>B</strong></p>
<p>To study people’s reactions to TV, researchers have undertaken laboratory experiments in which they have monitored the brain waves (using an electroencephalograph, or EEG) to track behavior and emotion in the normal course of life, as opposed to the artificial conditions of the lab. Participants carried a beeper, and we signaled them six to eight times a day, at random, over the period of a week; whenever they heard the beep, they wrote down what they were doing and how they were feeling using a standardized scorecard.</p>

<p><strong>C</strong></p>
<p>As one might expect, people who were watching TV when we beeped them reported feeling relaxed and passive. The EEG studies similarly show less mental stimulation, as measured by alpha brain-wave production, during viewing than during reading. What is more surprising is that the sense of relaxation ends when the set is turned off, but the feelings of passivity and lowered alertness continue. Survey participants say they have more difficulty concentrating after viewing than before. In contrast, they rarely indicate such difficulty after reading. After playing sports or engaging in hobbies, people report improvements in mood. After watching TV, people’s moods are about the same or worse than before. That may be because of viewers’ vague learned sense that they will feel less relaxed if they stop viewing. So they tend not to turn the set-off. Viewing begets more viewing which is the same as the experience of habit-forming drugs. Thus, the irony of TV: people watch a great deal longer than they plan to, even though prolonged viewing is less rewarding. In our ESM studies the longer people sat in front of the set, the less satisfaction they said they derived from it. For some, a twinge of unease or guilt that they aren’t doing something more productive may also accompany and depreciate the enjoyment of prolonged viewing. Researchers in Japan, the U.K. and the U.S. have found that this guilt occurs much more among middle-class viewers than among less affluent ones.</p>

<p><strong>D</strong></p>
<p>What is it about TV that has such a hold on us? In part, the attraction seems to spring from our biological ‘orienting response.’ First described by Ivan Pavlov in 1927, the orienting response is our instinctive visual or auditory reaction to any sudden or novel stimulus. It is part of our evolutionary heritage, a built-in sensitivity to movement and potential predatory threats. In 1986 Byron Reeves of Stanford University, Esther Thorson of the University of Missouri and their colleagues began to study whether the simple formal features of television – cuts, edits, zooms, pans, sudden noises – activate the orienting response, thereby keeping attention on the screen. By watching how brain waves were affected by formal features, the researchers concluded that these stylistic tricks can indeed trigger involuntary responses and ‘derive their attentional value through the evolutionary significance of detecting movement… It is the form, not the content, of television that is unique.’</p>

<p><strong>E</strong></p>
<p>The natural attraction to television’s sound and the light starts very early in life. Dafna Lemish of Tel Aviv University has described babies at six to eight weeks attending to television. We have observed slightly older infants who, when lying on their backs on the floor, crane their necks around 180 degrees to catch what light through yonder window breaks. This inclination suggests how deeply rooted the orienting response is.</p>

<p><strong>F</strong></p>
<p>The Experience Sampling Method permitted us to look closely at most every domain of everyday life: working, eating, reading, talking to friends, playing a sport, and so on. We found that heavy viewers report feeling significantly more anxious and less happy than light viewers do in unstructured situations, such as doing nothing, daydreaming or waiting in line. The difference widens when the viewer is alone. Subsequently, Robert D. McIlwraith of the University of Manitoba extensively studies those who called themselves TV addicts on surveys. On a measure called the Short Imaginal Processes Inventory (SIPI), he found that the self-described addicts are more easily bored and distracted and have poorer attentional control than the non-addicts. The addicts said they used TV to distract themselves from unpleasant thoughts and to fill time. Other studies over the years have shown that heavy viewers are less likely to participate in community activities and sports and are more likely to be obese than moderate viewers or non-viewers.</p>

<p><strong>G</strong></p>
<p>More than 25 years ago psychologist Tannis M. MacBeth Williams of the University of British Columbia studied a mountain community that had no television until cable finally arrived. Over time, both adults and children in the town became less creative in problem-solving, less able to persevere at tasks, and less tolerant of unstructured time.</p>

<p><strong>H</strong></p>
<p>Nearly 40 years ago Gary A. Steiner of the University of Chicago collected fascinating individual accounts of families whose set had broken. In experiments, families have volunteered or been paid to stop viewing, typically for a week or a month. Some fought, verbally and physically. In a review of these could-turkey studies, Charles Winick of the City University of New York concluded: ‘The first three or four days for most persons were the worst, even in many homes where the viewing was minimal and where there were other ongoing activities. In over half of all the households, during these first few days of loss, the regular routines were disrupted, family members had difficulties in dealing with the newly available time, anxiety and aggressions were expressed…. By the second week, a move toward adaptation to the situation was common.’ Unfortunately, researchers have yet to flesh out these anecdotes; no one has systematically gathered statistics on the prevalence of these withdrawal symptoms.</p>

<p><strong>I</strong></p>
<p>Even though TV does seem to meet the criteria for substance dependence, not all researchers would go so far as to call TV addictive. McIlwraith said in 1988 that ‘displacement of other activities by television may be socially significant but still fall short of the clinical requirement of significant impairment.’ He argued that a new category of ‘TV addiction’ may not be necessary if heavy viewing stems from conditions such as depression and social phobia. Nevertheless, whether or not we formally diagnose someone as TV-dependent, millions of people sense that they cannot readily control the amount of television they watch.</p>',
            'order' => 2,
        ]);

        // Questions 14-18: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the claims of the writer in Reading Passage 2?<br>In boxes 14-18 on your answer sheet, write',
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
                    ['id' => '14', 'label' => 'Study shows that males are more likely to be addicted to TV than females.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '15', 'label' => 'Greater improvements in mood are experienced after watching TV than playing sports.', 'correct_answer' => 'FALSE'],
                    ['id' => '16', 'label' => 'TV addiction works in similar ways as drugs.', 'correct_answer' => 'TRUE'],
                    ['id' => '17', 'label' => 'It is reported that people’s satisfaction is in proportion to the time they spend watching TV.', 'correct_answer' => 'FALSE'],
                    ['id' => '18', 'label' => 'Middle-class viewers are more likely to feel guilty about watching TV than the poor.', 'correct_answer' => 'TRUE'],
                ]
            ],
            'order' => 1,
        ]);

        
        // Questions 19-23: Matching Researcher with Statements
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 19,
            'type' => 'matching_features',
            'question_text' => 'Look at the following researchers (Questions 19-23) and the list of statements below.<br>Match each researcher with the correct statements.',
            'options' => [
                "A" => "Audiences would get hypnotized from viewing too much television.",
                "B" => "People have been sensitive to the TV signals since a younger age.",
                "C" => "People are less likely to accomplish their work with television.",
                "D" => "A handful of studies have attempted to study other types of media addiction.",
                "E" => "The addictive power of television could probably minimize the problems.",
                "F" => "Various media formal characters stimulate people’s reaction on the screen.",
                "G" => "People who believe themselves to be TV addicts are less likely to join in the group activities.",
                "H" => "It is hard for people to accept life without a TV at the beginning."
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of Statements',
                'start_number' => 18,
                'sub_questions' => [
                    ['id' => '19', 'label' => 'Byron Reeves and Esther Thorson', 'correct_answer' => 'F'],
                    ['id' => '20', 'label' => 'Dafna Lemish', 'correct_answer' => 'B'],
                    ['id' => '21', 'label' => 'Robert D. McIlwraith', 'correct_answer' => 'G'],
                    ['id' => '22', 'label' => 'Tannis M. MacBeth Williams', 'correct_answer' => 'C'],
                    ['id' => '23', 'label' => 'Charles Winick', 'correct_answer' => 'H'],
                ]
            ],
            'order' => 2,
        ]);

        // Question 24: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 24,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter A, B, C or D.<br>Write the correct letter in boxes 24-26 on your answer sheet.<br>',
            'options' => [
                'A' => 'devote ten hours watching TV on average',
                'B' => 'spend more time on TV than other entertainment',
                'C' => 'call themselves TV addicts.',
                'D' => 'enjoy working best.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 23,
                'sub_questions' => [
                    ['id' => '24', 'label' => 'People in the industrialized world', 'correct_answer' => 'B']
                ]
            ],
            'order' => 4,
        ]);

        // Question 25: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 25,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'like playing sport more than reading.',
                'B' => 'feel relaxed after watching TV.',
                'C' => 'spend more time in daydreaming.',
                'D' => 'are more easily bored while waiting in line.'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 24,
                'sub_questions' => [
                    ['id' => '25', 'label' => 'When compared with light viewers, heavy viewers', 'correct_answer' => 'D']
                ]
            ],
            'order' => 5,
        ]);

        // Question 26: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 26,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Not all subjects participate in the experiment for free.',
                'B' => 'There has been complete gathered data.',
                'C' => 'People are prevented from other activities during the experiment.',
                'D' => 'People can not adapt to the situation until the end.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 25,
                'sub_questions' => [
                    ['id' => '26', 'label' => 'Which of the following statements is true about the family experiment?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 6,
        ]);

        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Communication in science',
            'content' => '
<p><strong>A</strong></p>
<p>Science plays an increasingly significant role in people’s lives, making the faithful communication of scientific developments more important than ever. Yet such communication is fraught with challenges that can easily distort discussions, leading to unnecessary confusion and misunderstandings.</p>

<p><strong>B</strong></p>
<p>Some problems stem from the esoteric nature of current research and the associated difficulty of finding sufficiently faithful terminology. Abstraction and complexity are not signs that a given scientific direction is wrong, as some commentators have suggested, but are instead a tribute to the success of human ingenuity in meeting the increasingly complex challenges that nature presents. They can, however, make communication more difficult. But many of the biggest challenges for science reporting arise because in areas of evolving research, scientists themselves often only partly understand the full implications of any particular advance or development. Since that dynamic applies to most of the scientific developments that directly affect people’s lives global warming, cancer research, diet studies – learning how to overcome it is critical to spurring a more informed scientific debate among the broader public.</p>

<p><strong>C</strong></p>
<p>Ambiguous word choices are the source of some misunderstandings. Scientists often employ colloquial terminology, which they then assign a specific meaning that is impossible to fathom without proper training. The term “relativity,” for example, is intrinsically misleading. Many interpret the theory to mean that everything is relative and there are no absolutes. Yet although the measurements any observer makes depend on his coordinates and reference frame, the physical phenomena he measures have an invariant description that transcends that observer’s particular coordinates. Einstein’s theory of relativity is really about finding an invariant description of physical phenomena. True, Einstein agreed with the idea that his theory would have been better named “Invarianten theorie.” But the term “relativity” was already entrenched at the time for him to change. </p>

<p><strong>D</strong></p>
<p>“The uncertainty principle” is another frequently abused term. It is sometimes interpreted as a limitation on observers and their ability to make measurements.</p>

<p><strong>E</strong></p>
<p>But it is not about intrinsic limitations on any one particular measurement; it is about the inability to precisely measure particular pairs of quantities simultaneously? The first interpretation is perhaps more engaging from a philosophical or political perspective. It’s just not what the science is about.</p>

<p><strong>F</strong></p>
<p>Even the word “theory” can be a problem. Unlike most people, who use the word to describe a passing conjecture that they often regard as suspect, physicists have very specific ideas in mind when they talk about theories. For physicists, theories entail a definite physical framework embodied in a set of fundamental assumptions about the world that lead to a specific set of equations and predictions – ones that are borne out by successful predictions. Theories aren’t necessarily shown to be correct or complete immediately. Even Einstein took the better part of a decade to develop the correct version of his theory of general relativity. But eventually both the ideas and the measurements settle down and theories are either proven correct, abandoned or absorbed into other, more encompassing theories.</p>

<p><strong>G</strong></p>
<p>“Global warming” is another example of problematic terminology. Climatologists predict more drastic fluctuations in temperature and rainfall – not necessarily that every place will be warmer. The name sometimes subverts the debate, since it lets people argue that their winter was worse, so how could there be global warming? Clearly “global climate change” would have been a better name. But not all problems stem solely from poor word choices. Some stem from the intrinsically complex nature of much of modern science. Science sometimes transcends this limitation: remarkably, chemists were able to detail the precise chemical processes involved in the destruction of the ozone layer, making the evidence that chlorofluorocarbon gases (Freon, for example) were destroying the ozone layer indisputable.</p>

<p><strong>H</strong></p>
<p>A better understanding of the mathematical significance of results and less insistence on a simple story would help to clarify many scientific discussions. For several months, Harvard was tortured months, Harvard was tortured by empty debates over the relative intrinsic scientific abilities of men and women. One of the more amusing aspects of the discussion was that those who believed in the differences and those who didn’t use the same evidence about gender-specific special ability? How could that be? The answer is that the data shows no substantial effects. Social factors might account for these tiny differences, which in any case have an unclear connection to scientific ability. Not much of a headline when phrased that way, is it? Each type of science has its own source of complexity and potential for miscommunication. Yet there are steps we can take to improve public understanding in all cases. The first would be to inculcate greater understanding and acceptance of indirect scientific evidence. The information from an unmanned space mission is no less legitimate than the information from one in which people are on board.</p>

<p><strong>I</strong></p>
<p>This doesn’t mean questioning an interpretation, but it also doesn’t mean equating indirect evidence with blind belief, as people sometimes suggest. Second, we might need different standards for evaluating science with urgent policy implications than research with the purely theoretical value. When scientists say they are not certain about their predictions, it doesn’t necessarily mean they’ve found nothing substantial. It would be better if scientists were more open about the mathematical significance of their results and if the public didn’t treat math as quite so scary; statistics and errors, which tell us the uncertainty in a measurement, give us the tools to evaluate new developments fairly.</p>

<p><strong>J</strong></p>
<p>But most important, people have to recognize that science can be complex. If we accept only simple stories, the description will necessarily be distorted. When advances are subtle or complicated, scientists should be willing to go the extra distance to give proper explanations and the public should be more patient about the truth. Even so, some difficulties are unavoidable. Most developments reflect work in progress, so the story is complex because no one yet knows the big picture.</p>',
            'order' => 3,
        ]);

        // Question 27: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter A, B, C or D.<br>Write your answers in boxes 27-31 on your answer sheet.<br>',
            'options' => [
                'A' => 'Science plays an increasingly significant role in people’s lives.',
                'B' => 'Science is fraught with challenges public are interested in.',
                'C' => 'The nature of complexity in science communication leads to confusion.',
                'D' => 'Scientific inventions are more important than ever before.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'Why faithful science communication important?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 1,
        ]);

        // Question 28: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 28,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'phenomenon such as global warming, cancer research, diet studies is too complex.',
                'B' => 'Scientists themselves often only partly understand the Theory of Evolution',
                'C' => 'Scientists do not totally comprehend the meaning of certain scientific evolution',
                'D' => 'Scientists themselves often partly understand the esoteric communication nature'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 27,
                'sub_questions' => [
                    ['id' => '28', 'label' => 'what is the reason that the author believes for the biggest challenges for science reporting', 'correct_answer' => 'C']
                ]
            ],
            'order' => 2,
        ]);

        // Question 29: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 29,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'theory of relativity is about an invariant physical phenomenon',
                'B' => 'common people may be misled by the inaccurate choice of scientific phrase',
                'C' => 'the term “relativity,” is designed to be misleading public',
                'D' => 'everything is relative and there is no absolutes existence'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 28,
                'sub_questions' => [
                    ['id' => '29', 'label' => 'According to the 3rd paragraph, the reference to the term and example of “theory of relativity” is to demonstrate', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);

        // Question 30: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 30,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Scientific theory for the uncertainty principle',
                'B' => 'phenomenon of Global warming',
                'C' => 'the importance of ozone layer',
                'D' => 'Freon’s destructive process on environmental'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 29,
                'sub_questions' => [
                    ['id' => '30', 'label' => 'Which one is a good example of appropriate word choice:', 'correct_answer' => 'D']
                ]
            ],
            'order' => 4,
        ]);

        // Question 31: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 31,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'There are equal intrinsic scientific abilities of men and women.',
                'B' => 'The proof applied by both sides seemed to be of no big difference.',
                'C' => 'The scientific data usually shows no substantial figures to support a debated idea.',
                'D' => 'Social factors might have a clear connection to scientific ability.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 30,
                'sub_questions' => [
                    ['id' => '31', 'label' => 'What is a surprising finding of the Harvard debates in the passage?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 5,
        ]);

        // Questions 32-35: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 32,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1?<br>In boxes 32-35 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 31,
                'sub_questions' => [
                    ['id' => '32', 'label' => '“Global warming” scientifically refers to greater fluctuations in temperature and rainfall rather than a universal temperature rise.', 'correct_answer' => 'TRUE'],
                    ['id' => '33', 'label' => 'More media coverage of “global warming” would help the public to recognize the phenomenon.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '34', 'label' => 'Harvard debates should focus more on female scientist and male scientists', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '35', 'label' => 'Public understanding and acceptance of indirect scientific evidence in all cases would lead to confusion', 'correct_answer' => 'FALSE'],
                ]
            ],
            'order' => 6,
        ]);
        
        // Questions 36-40: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 36,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '36' => 'word choices',
                '37' => 'colloquial terminology',
                '38' => 'observer',
                '39' => 'invariant description',
                '40' => 'general relativity',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 35,
                'instruction' => 'Complete the following summary of the paragraphs of Reading Passage.<br>Using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.',
                'summary_text' => 'Science Communication is fraught with challenges that can easily distort discussions, leading to unnecessary confusion and misunderstandings. Firstly, Ambiguous <strong>[36]</strong> are the source of some misunderstandings. Common people without proper training do not understand clearly or deeply a specific scientific meaning via the <strong>[37]</strong> scientists often employed. Besides, the measurements any <strong>[38]</strong> makes can not be confined to describe in a(n) constant <strong>[39]</strong> yet the phenomenon can be. What’s more, even the word “theory” can be a problem. Theories aren’t necessarily shown to be correct or complete immediately since scientists often evolved better versions of specific theories, a good example can be the theory of <strong>[40]</strong>. Thus, most importantly people have to recognize that science can be complex.',
                'placeholders' => [
                    '36' => 36,
                    '37' => 37,
                    '38' => 38,
                    '39' => 39,
                    '40' => 40
                ]
            ],
            'order' => 7,
        ]);

    }
}
