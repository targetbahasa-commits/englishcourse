<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IeltsReadingPractice20Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 20;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'SOSUS: Listening to the Ocean',
            'content' => '
<p><strong>A</strong></p>
<p>The oceans of Earth cover more than 70 percent of the planet’s surface, yet, until quite recently, we knew less about their depths than we did about the surface of the Moon. Distant as it is, the Moon has been far more accessible to study because astronomers long have been able to look at its surface, first with the naked eye and then with the telescope-both instruments that focus light. And, with telescopes tuned to different wavelengths of light, modern astronomers can not only analyze Earth’s atmosphere but also determine the temperature and composition of the Sun or other stars many hundreds of light-years away. Until the twentieth century, however, no analogous instruments were available for the study of Earth’s oceans: Light, which can travel trillions of miles through the vast vacuum of space, cannot penetrate very far in seawater.</p>

<p><strong>B</strong></p>
<p>Curious investigators long have been fascinated by sound and the way it travels in water. As early as 1490, Leonardo da Vinci observed: “If you cause your ship to stop and place the head of a long tube in the water and place the outer extremity to your ear, you will hear ships at a great distance from you.” In 1687, the first mathematical theory of sound propagation was published by Sir Isaac Newton in his Philosophiae Naturalis Principia Mathematica. Investigators were measuring the speed of sound in the air beginning in the mid-seventeenth century, but it was not until 1826 that Daniel Colladon, a Swiss physicist, and Charles Sturm, a French mathematician, accurately measured its speed in the water. Using a long tube to listen underwater (as da Vinci had suggested), they recorded how fast the sound of a submerged bell traveled across Lake Geneva. Their result-1,435 meters (1,569 yards) per second in the water of 1.8 degrees Celsius (35 degrees Fahrenheit) – was only 3 meters per second off from the speed accepted today. What these investigators demonstrated was that water – whether fresh or salt – is an excellent medium for sound, transmitting it almost five times faster than its speed in air.</p>

<p><strong>C</strong></p>
<p>In 1877 and 1878, the British scientist John William Strutt, third Baron Rayleigh, published his two-volume seminal work, The Theory of Sound, often regarded as marking the beginning of the modern study of acoustics. The recipient of the Nobel Prize for Physics in 1904 for his successful isolation of the element argon, Lord Rayleigh made key discoveries in the fields of acoustics and optics that are critical to the theory of wave propagation in fluids. Among other things, Lord Rayleigh was the first to describe a sound wave as a mathematical equation (the basis of all theoretical work on acoustics) and the first to describe how small particles in the atmosphere scatter certain wavelengths of sunlight, a principle that also applies to the behavior of sound waves in water.</p>

<p><strong>D</strong></p>
<p>A number of factors influence how far sound travels underwater and how long it lasts. For one, particles in seawater can reflect, scatter, and absorb certain frequencies of sound – just as certain wavelengths of light may be reflected, scattered, and absorbed by specific types of particles in the atmosphere. Seawater absorbs 30 times the amount of sound absorbed by distilled water, with specific chemicals (such as magnesium sulfate and boric acid) damping out certain frequencies of sound. Researchers also learned that low-frequency sounds, whose long wavelengths generally pass over tiny particles, tend to travel farther without loss through absorption or scattering. Further work on the effects of salinity, temperature, and pressure on the speed of sound has yielded fascinating insights into the structure of the ocean. Speaking generally, the ocean is divided into horizontal layers in which sound speed is influenced more greatly by temperature in the upper regions and by pressure in the lower depths. At the surface is a sun-warmed upper layer, the actual temperature and thickness of which varies with the season. At mid-latitudes, this layer tends to be isothermal, that is, the temperature tends to be uniform throughout the layer because the water is well mixed by the action of waves, winds, and convection currents; a sound signal moving down through this layer tends to travel at an almost constant speed. Next comes a transitional layer called the thermocline, in which temperature drops steadily with depth; as the temperature falls, so does the speed of sound.</p>

<p><strong>E</strong></p>
<p>The U.S. Navy was quick to appreciate the usefulness of low-frequency sound and the deep sound channel in extending the range at which it could detect submarines. In great secrecy during the 1950s, the U.S. Navy launched a project that went by the code name Jezebel; it would later come to be known as the Sound Surveillance System (SOSUS). The system involved arrays of underwater microphones, called hydrophones, that were placed on the ocean bottom and connected by cables to onshore processing centers. With SOSUS deployed in both deep and shallow water along both coasts of North America and the British West Indies, the U.S. Navy not only could detect submarines in much of the northern hemisphere, it also could distinguish how many propellers a submarine had, whether it was conventional or nuclear, and sometimes even the class of sub.</p>

<p><strong>F</strong></p>
<p>The realization that SOSUS could be used to listen to whales also was made by Christopher Clark, a biological acoustician at Cornell University, when he first visited a SOSUS station in 1992. When Clark looked at the graphic representations of sound, scrolling 24 hours day, every day, he saw the voice patterns of blue, finback, minke, and humpback whales. He also could hear the sounds. Using a SOSUS receiver in the West Indies, he could hear whales that were 1,770 kilometers (1,100 miles) away. Whales are the biggest of Earth’s creatures. The blue whale, for example, can be 100 feet long and weigh as many tons. Yet these animals also are remarkably elusive. Scientists wish to observe blue time and position them on a map. Moreover, they can track not just one whale at a time, but many creatures simultaneously throughout the North Atlantic and the eastern North Pacific. They also can learn to distinguish whale calls. For example, Fox and colleagues have detected changes in the calls of finback whales during different seasons and have found that blue whales in different regions of the Pacific Ocean have different calls. Whales firsthand must wait in their ships for the whales to surface. A few whales have been tracked briefly in the wild this way but not for very great distances, and much about them remains unknown. Using the SOSUS stations, scientists can track the whales in real-time and position them on a map. Moreover, they can track not just one whale at a time, but many creatures simultaneously throughout the North Atlantic and the eastern North Pacific. They also can learn to distinguish whale calls. For example, Fox and colleagues have detected changes in the calls of finback whales during different seasons and have found that blue whales in different regions of the Pacific Ocean have different calls.</p>

<p><strong>G</strong></p>
<p>SOSUS, with its vast reach, also has proved instrumental in obtaining information crucial to our understanding of Earth’s weather and climate. Specifically, the system has enabled researchers to begin making ocean temperature measurements on a global scale – measurements that are keys to puzzling out the workings of heat transfer between the ocean and the atmosphere. The ocean plays an enormous role in determining air temperature – the heat capacity in only the upper few meters of the ocean is thought to be equal to all of the heat in the entire atmosphere. For sound waves traveling horizontally in the ocean, speed is largely a function of temperature. Thus, the travel time of a wave of sound between two points is a sensitive indicator of the average temperature along its path. Transmitting sound in numerous directions through the deep sound channel can give scientists measurements spanning vast areas of the globe. Thousands of sound paths in the ocean could be pieced together into a map of global ocean temperatures and, by repeating measurements along the same paths overtimes, scientists could track changes in temperature over months or years.</p>

<p><strong>H</strong></p>
<p>Researchers also are using other acoustic techniques to monitor climate. Oceanographer Jeff Nystuen at the University of Washington, for example, has explored the use of sound to measure rainfall over the ocean. Monitoring changing global rainfall patterns undoubtedly will contribute to understanding major climate change as well as the weather phenomenon known as El Niño. Since 1985, Nystuen has used hydrophones to listen to rain over the ocean, acoustically measuring not only the rainfall rate but also the rainfall type, from drizzle to thunderstorms. By using the sound of rain underwater as a “natural” rain gauge, the measurement of rainfall over the oceans will become available to climatologists.</p>',
            'order' => 1,
        ]);

        // Questions 1-4: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1?<br>In boxes 1-4 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'In the past, difficulties of research carried out on Moon were much easier than that of the ocean.', 'correct_answer' => 'TRUE'],
                    ['id' => '2', 'label' => 'The same light technology used in the investigation of the moon can be employed in the field of the ocean.', 'correct_answer' => 'FALSE'],
                    ['id' => '3', 'label' => 'Research on the depth of the ocean by the method of the sound wave is more time-consuming.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '4', 'label' => 'Hydrophones technology is able to detect the category of precipitation.', 'correct_answer' => 'TRUE'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 5-8: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 5,
            'type' => 'matching_paragraph_information',
            'question_text' => 'The Reading Passage has seven paragraphs A-H.<br>Which paragraph contains the following information?<br>Write the correct letter A-H, in boxes 5-8 on your answer sheet.<br><br>NB  You may use any letter more than once.',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E',
                'F' => 'Paragraph F',
                'G' => 'Paragraph G',
                'H' => 'Paragraph H',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 4,
                'sub_questions' => [
                    ['id' => '5', 'label' => 'Elements affect sound transmission in the ocean.', 'correct_answer' => 'D'],
                    ['id' => '6', 'label' => 'Relationship between global climate and ocean temperature', 'correct_answer' => 'G'],
                    ['id' => '7', 'label' => 'Examples of how sound technology help people research ocean and creatures in it', 'correct_answer' => 'F'],
                    ['id' => '8', 'label' => 'Sound transmission underwater is similar to that of light in any condition.', 'correct_answer' => 'D'],
                ]
            ],
            'order' => 2,
        ]);

        // Question 9: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 9,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 9-13 on your answer sheet.<br><br>Who of the followings is dedicated to the research of rate of sound?',
            'options' => [
                'A' => 'Leonardo da Vinci',
                'B' => 'Isaac Newton',
                'C' => 'John William Strutt',
                'D' => 'Charles Sturm'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 8,
                'sub_questions' => [
                    ['id' => '9', 'label' => 'Who of the followings is dedicated to the research of rate of sound?', 'correct_answer' => 'D']
                ]
            ],
            'order' => 3,
        ]);

        // Question 10: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 10,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Lord Rayleigh',
                'B' => 'John William Strutt',
                'C' => 'Charles Sturm',
                'D' => 'Christopher Clark'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 9,
                'sub_questions' => [
                    ['id' => '10', 'label' => 'Who explained that the theory of light or sound wavelength is significant in the water?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 4,
        ]);

        // Question 11: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 11,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Change in various seasons',
                'B' => 'Change in various days',
                'C' => 'Change in different months',
                'D' => 'Change in different years'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 10,
                'sub_questions' => [
                    ['id' => '11', 'label' => 'According to Fox and colleagues, in what pattern does the change of finback whale calls happen', 'correct_answer' => 'A']
                ]
            ],
            'order' => 5,
        ]);

        // Question 12: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 12,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Track all kinds of whales in the ocean',
                'B' => 'Track bunches of whales at the same time',
                'C' => 'Track only finback whale in the ocean',
                'D' => 'Track whales by using multiple appliances or devices'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 11,
                'sub_questions' => [
                    ['id' => '12', 'label' => 'In which way does the SOSUS technology inspect whales?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 6,
        ]);

        // Question 13: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 13,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Temperature of the surface passed',
                'B' => 'Temperature of the deepest ocean floor',
                'C' => 'Variation of temperature',
                'D' => 'Fixed data of temperature'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 12,
                'sub_questions' => [
                    ['id' => '13', 'label' => 'What could scientists inspect via monitoring along a repeated route?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 7,
        ]);

        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Left-handed or Right-handed',
            'content' => '
<p><strong>Section A</strong></p>
<p>The probability that two right-handed people would have a left-handed child is only about 9.5 percent. The chance rises to 19.5 percent if one parent is a lefty and 26 percent if both parents are left-handed: The preference, however, could also stem from an infant’s imitation of his parents. To test genetic influence, starting in the 1970s British biologist Marian Annett of the University of Leicester hypothesized that no single gene determines handedness. Rather, during fetal development, a certain molecular factor helps to strengthen the brain’s left hemisphere, which increases the probability that the right hand will be dominant because the left side of the brain controls the right side of the body, and vice versa. Among the minority of people who lack this factor, handedness develops entirely by chance.</p>
<p>Research conducted on twins complicates the theory, however. One in five sets of identical twins involves one right-handed and one left-handed person, despite the fact that their genetic material is the same. Genes, therefore, are not solely responsible for handedness.</p>

<p><strong>Section B</strong></p>
<p>The genetic theory is also undermined by results from Peter Hepper and his team at Queen’s University in Belfast, Ireland. In 2004 the psychologists used ultrasound to show that by the 15th week of pregnancy, fetuses already have a preference as to which thumb they suck. In most cases, the preference continued after birth. At 15 weeks, though, the brain does not yet have control over the body’s limbs. Hepper speculates that fetuses tend to prefer whichever side of the body is developing quicker and that their movements, in turn, influence the brain’s development. Whether this early preference is temporary or holds up throughout development and infancy is unknown. Genetic predetermination is also contradicted by the widespread observation that children do not settle on either their right or left hand until they are two or three years old.</p>

<p><strong>Section C</strong></p>
<p>But even if these correlations were true, they did not explain what actually causes left-handedness. Furthermore, specialization on either side of the body is common among animals. Cats will favor one paw over another when fishing toys out from under the couch. Horses stomp more frequently with one hoof than the other. Certain crabs motion predominantly with the left or right claw. In evolutionary terms, focusing power and dexterity in one limb is more efficient than having to train two, four or even eight limbs equally. Yet for most animals, the preference for one side or the other is seemingly random. The overwhelming dominance of the right hand is associated only with humans. That fact directs attention toward the brain’s two hemispheres and perhaps toward language.</p>

<p><strong>Section D</strong></p>
<p>Interest in hemispheres dates back to at least 1836. That year, at a medical conference, French physician Marc Dax reported on an unusual commonality among his patients. During his many years as a country doctor, Dax had encountered more than 40 men and women for whom speech was difficult, the result of some kind of brain damage. What was unique was that every individual suffered damage to the left side of the brain. At the conference, Dax elaborated on his theory, stating that each half of the brain was responsible for certain functions and that the left hemisphere controlled speech. Other experts showed little interest in the Frenchman’s ideas.</p>
<p>Over time, however, scientists found more and more evidence of people experiencing speech difficulties following an injury to the left brain. Patients with damage to the right hemisphere most often displayed disruptions in perception or concentration. Major advancements in understanding the brain’s asymmetry were made in the 1960s as a result of so-called split-brain surgery, developed to help patients with epilepsy. During this operation, doctors severed the corpus callosum – the nerve bundle that connects the two hemispheres. The surgical cut also stopped almost all normal communication between the two hemispheres, which offered researchers the opportunity to investigate each side’s activity.</p>

<p><strong>Section E</strong></p>
<p>In 1949 neurosurgeon Juhn Wada devised the first test to provide access to the brain’s functional organization of language. By injecting an anesthetic into the right or left carotid artery, Wada temporarily paralyzed one side of a healthy brain, enabling him to more closely study the other side’s capabilities. Based on this approach, Brenda Milner and the late Theodore Rasmussen of the Montreal Neurological Institute published a major study in 1975 that confirmed the theory that country doctor Dax had formulated nearly 140 years earlier: in 96 percent of right-handed people, language is processed much more intensely in the left hemisphere. The correlation is not as clear in lefties, however. For two-thirds of them, the left hemisphere is still the most active language processor. But for the remaining third, either the right side is dominant or both sides work equally, controlling different language functions.</p>
<p>That last statistic has slowed acceptance of the notion that the predominance of right-handedness is driven by left-hemisphere dominance in language processing. It is not at all clear why language control should somehow have dragged the control of body movement with it. Some experts think one reason the left hemisphere reigns over language is that the organs of speech processing – the larynx and tongue – are positioned on the body’s symmetry axis. Because these structures were centered, it may have been unclear, in evolutionary terms, which side of the brain should control them, and it seems unlikely that shared operation would result in smooth motor activity.</p>
<p>Language and handedness could have developed preferentially for very different reasons as well. For example, some researchers, including evolutionary psychologist Michael C. Corballis of the University of Auckland in New Zealand, think that the origin of human speech lies in gestures. Gestures predated words and helped language emerge. If the left hemisphere began to dominate speech, it would have dominated gestures, too, and because the left brain controls the right side of the body, the right hand developed more strongly.</p>

<p><strong>Section F</strong></p>
<p>Perhaps we will know more soon. In the meantime, we can revel in what, if any, differences handedness brings to our human talents. Popular wisdom says right-handed, left-brained people excel at logical, analytical thinking. Left-handed, right-brained individuals are thought to possess more creative skills and maybe better at combining the functional features emergent on both sides of the brain. Yet some neuroscientists see such claims as pure speculation. Fewer scientists are ready to claim that left-handedness means greater creative potential. Yet lefties are prevalent among artists, composers and the generally acknowledged great political thinkers. Possibly if these individuals are among the lefties whose language abilities are evenly distributed between hemispheres, the intense interplay required could lead to unusual mental capabilities.</p>

<p><strong>Section G</strong></p>
<p>Or perhaps some lefties become highly creative because they must be more clever to get by in our right-handed world. This battle, which begins during the very early stages of childhood, may lay the groundwork for exceptional achievements.</p>',
            'order' => 2,
        ]);

        // Questions 14-18: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'matching_paragraph_information',
            'question_text' => 'The Reading Passage has seven paragraphs A-G.<br>Which paragraph contains the following information?<br>Write the correct letter A-G, in boxes 14-18 on your answer sheet.<br><br>NB  You may use any letter more than once.',
            'options' => [
                'A' => 'Section A',
                'B' => 'Section B',
                'C' => 'Section C',
                'D' => 'Section D',
                'E' => 'Section E',
                'F' => 'Section F',
                'G' => 'Section G',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'The phenomenon of using one side of their body for animals.', 'correct_answer' => 'C'],
                    ['id' => '15', 'label' => 'Statistics on the rate of one-handedness born.', 'correct_answer' => 'A'],
                    ['id' => '16', 'label' => 'The age when the preference for using one hand is fixed.', 'correct_answer' => 'B'],
                    ['id' => '17', 'label' => 'great talents of occupations in the left-handed population.', 'correct_answer' => 'F'],
                    ['id' => '18', 'label' => 'The earliest record of researching hemisphere’s function', 'correct_answer' => 'D'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 19-22: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 19,
            'type' => 'matching_features',
            'question_text' => 'Look at the following researchers (Questions 19-22) and the list of findings below.<br>March each researcher with the correct finding.',
            'options' => [
                'A' => 'Brenda Milner',
                'B' => 'Marian Annett',
                'C' => 'Peter Hepper',
                'D' => 'Michale Corballis',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 18,
                'sub_questions' => [
                    ['id' => '19', 'label' => 'Ancient language evolution is connected to body gesture and therefore influences handedness.', 'correct_answer' => 'D'],
                    ['id' => '20', 'label' => 'A child handedness is not determined by just biological factors.', 'correct_answer' => 'B'],
                    ['id' => '21', 'label' => 'Language process is generally undergoing in the left hemisphere of the brain.', 'correct_answer' => 'A'],
                    ['id' => '22', 'label' => 'The rate of development of one side of the body has an influence on hemisphere preference in the fetus.', 'correct_answer' => 'C'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 23-26: Yes/No/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 23,
            'type' => 'yes_no_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 2?<br>In boxes 23-26 on your answer sheet write',
            'options' => [
                'YES' => 'YES',
                'NO' => 'NO',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 22,
                'sub_questions' => [
                    ['id' => '23', 'label' => 'The study of twins shows that genetic determination is not the only factor for left Handedness.', 'correct_answer' => 'YES'],
                    ['id' => '24', 'label' => 'The number of men with left-handedness is more than that of women.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '25', 'label' => 'Marc Dax’s report was widely recognized in his time.', 'correct_answer' => 'NO'],
                    ['id' => '26', 'label' => 'Juhn Wada based his findings on his research of people with language problems.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
            'order' => 3,
        ]);


        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Power of Nothing',
            'content' => '
<p><strong>A</strong></p>
<p>Want to devise a new form of alternative medicine? No problem. Here is the recipe. Be warm, sympathetic, reassuring and enthusiastic. Your treatment should involve physical contact, and each session with your patients should last at least half an hour. Encourage your patients to take an active part in their treatment and understand how their disorders relate to the rest of their lives. Tell them that their own bodies possess the true power to heal. Make them pay you out of their own pockets. Describe your treatment in familiar words, but embroidered with a hint of mysticism: energy fields, energy flows, energy blocks, meridians, forces, auras, rhythms and the like. Refer to the knowledge of an earlier age: wisdom carelessly swept aside by the rise and rise of blind, mechanistic science. Oh, come off it, you are saying. Something invented off the top of your head could not possibly work, could it?</p>

<p><strong>B</strong></p>
<p>Well yes, it could – and often well enough to earn you a living. A good living if you are sufficiently convincing, or better still, really believe in your therapy. Many illnesses get better on their own, so if you are lucky and administer your treatment at just the right time you will get the credit. But that’s only part of it. Some of the improvement really would be down to you. Your healing power would be the outcome of a paradoxical force that conventional medicine recognizes but remains oddly ambivalent about: the placebo effect.</p>

<p><strong>C</strong></p>
<p>Placebos are treatments that have no direct effect on the body, yet still, work because the patient has faith in their power to heal. Most often the term refers to a dummy pill, but it applies just as much to any device or procedure, from a sticking plaster to a crystal to an operation. The existence of the placebo effect implies that even quackery may confer real benefits, which is why any mention of placebo is a touchy subject for many practitioners of complementary and alternative medicine, who are likely to regard it as tantamount to a charge of charlatanism. In fact, the placebo effect is a powerful part of all medical care, orthodox or otherwise, though its role is often neglected or misunderstood.</p>

<p><strong>D</strong></p>
<p>One of the great strengths of CAM may be its practitioners’ skill in deploying the placebo effect to accomplish real healing. “Complementary practitioners are miles better at producing non-specific effects and good therapeutic relationships,” says Edzard Ernst, professor of CAM at Exeter University. The question is whether CAM could be integrated into conventional medicines, as some would like, without losing much of this power.</p>

<p><strong>E</strong></p>
<p>At one level, it should come as no surprise that our state of mind can influence our physiology: anger opens the superficial blood vessels of the face; sadness pumps the tear glands. But exactly how placebos work their medical magic is still largely unknown. Most of the scant research done so far has focused on the control of pain because it’s one of the commonest complaints and lends itself to experimental study. Here, attention has turned to the endorphins, morphine-like neurochemicals known to help control pain.</p>

<p><strong>F</strong></p>
<p>But exactly how placebos work their medical magic is still largely unknown. Most of the scant research to date has focused on the control of pain because it’s one of the commonest complaints and lends itself to experimental study. Here, attention has turned to the endorphins, natural counterparts of morphine that are known to help control pain. “Any of the neurochemicals involved in transmitting pain impulses or modulating them might also be involved in generating the placebo response,” says Don Price, an oral surgeon at the University of Florida who studies the placebo effect in dental pain.</p>

<p><strong>G</strong></p>
<p>“But endorphins are still out in front.” That case has been strengthened by the recent work of Fabrizio Benedetti of the University of Turin, who showed that the placebo effect can be abolished by a drug, naloxone, which blocks the effects of endorphins. Benedetti induced pain in human volunteers by inflating a blood-pressure cuff on the forearm. He did this several times a day for several days, using morphine each time to control the pain. On the final day, without saying anything, he replaced the morphine with a saline solution. This still relieved the subjects’ pain: a placebo effect. But when he added naloxone to the saline the pain relief disappeared. Here was direct proof that placebo analgesia is mediated, at least in part, by these natural opiates.</p>

<p><strong>H</strong></p>
<p>Still, no one knows how belief triggers endorphin release, or why most people can’t achieve placebo pain relief simply by willing it. Though scientists don’t know exactly how placebos work, they have accumulated a fair bit of knowledge about how to trigger the effect. A London rheumatologist found, for example, that red dummy capsules made more effective painkillers than blue, green or yellow ones. Research on American students revealed that blue pills make better sedatives than pink, a colour more suitable for stimulants. Even branding can make a difference: if Aspro or Tylenol is what you like to take for a headache, their chemically identical generic equivalents may be less effective.</p>

<p><strong>I</strong></p>
<p>It matters, too, how the treatment is delivered. Decades ago, when the major tranquilliser chlorpromazine was being introduced, a doctor in Kansas categorised his colleagues according to whether they were keen on it, openly skeptical of its benefits, or took a “let’s try and see” attitude. His conclusion: the more enthusiastic the doctor, the better the drug performed. And this year Ernst surveyed published studies that compared doctors’ bedside manners. The studies turned up one consistent finding: “Physicians who adopt a warm, friendly and reassuring manner,” he reported, “are more effective than those whose consultations are formal and do not offer reassurance.”</p>

<p><strong>J</strong></p>
<p>Warm, friendly and reassuring are precisely CAM’s strong suits, of course. Many of the ingredients of that opening recipe – the physical contact, the generous swathes of time, the strong hints of supernormal healing power – are just the kind of thing likely to impress patients. It’s hardly surprising, then, that complementary practitioners are generally best at mobilising the placebo effect, says Arthur Kleinman, professor of social anthropology at Harvard University.</p>',
            'order' => 3,
        ]);

        // Questions 27-32: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'matching_features',
            'question_text' => 'Use the information in the passage to match the deed (listed A-H) with people below.<br>Write the appropriate letters A-H in boxes 27-32 on your answer sheet.<br><br>NB You may use any letter more than once',
            'options' => [
                'A' => 'Should easily be understood',
                'B' => 'Should improve by itself',
                'C' => 'Should not involve any mysticism',
                'D' => 'Ought to last a minimum length of time.',
                'E' => 'Needs to be treated at the right time.',
                'F' => 'Should give more recognition.',
                'G' => 'Can earn valuable money.',
                'H' => 'Do not rely on any specific treatment',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'Appointments with an alternative practitioner', 'correct_answer' => 'D'],
                    ['id' => '28', 'label' => 'An alternative practitioner’s description of the treatment', 'correct_answer' => 'A'],
                    ['id' => '29', 'label' => 'An alternative practitioner who has faith in what he does', 'correct_answer' => 'G'],
                    ['id' => '30', 'label' => 'the illness of patients convinced of alternative practice', 'correct_answer' => 'B'],
                    ['id' => '31', 'label' => 'Improvements of patients receiving alternative practice', 'correct_answer' => 'H'],
                    ['id' => '32', 'label' => 'Conventional medical doctors (who is aware of placebo)', 'correct_answer' => 'F'],
                ]
            ],
            'order' => 1,
        ]);

        // Question 33: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 33,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 33-35 on your answer sheet.<br><br>In the fifth paragraph, the writer uses the example of anger and sadness to illustrate that:',
            'options' => [
                'A' => 'People’s feeling could affect their physical behaviour',
                'B' => 'Scientists don’t understand how the mind influences the body.',
                'C' => 'Research on the placebo effect is very limited',
                'D' => 'How placebo achieves its effect is yet to be understood.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 32,
                'sub_questions' => [
                    ['id' => '33', 'label' => 'In the fifth paragraph, the writer uses the example of anger and sadness to illustrate that:', 'correct_answer' => 'A']
                ]
            ],
            'order' => 2,
        ]);

        // Question 34: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 34,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Scientists have discovered that endorphins can help to reduce pain.',
                'B' => 'Only a limited number of researchers gain relevant experience',
                'C' => 'Pain reducing agents might also be involved in the placebo effect.',
                'D' => 'Patients often experience pain and like to complain about it'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 33,
                'sub_questions' => [
                    ['id' => '34', 'label' => 'Research on pain control attracts most of the attention because', 'correct_answer' => 'D']
                ]
            ],
            'order' => 3,
        ]);

        // Question 35: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 35,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'They are widely used to regulate pain.',
                'B' => 'They can be produced by willful thoughts',
                'C' => 'They can be neutralized by introducing naloxone.',
                'D' => 'Their pain-relieving effects do not last long enough.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 34,
                'sub_questions' => [
                    ['id' => '35', 'label' => 'Fabrizio Benedetti’s research on endorphins indicates that', 'correct_answer' => 'C']
                ]
            ],
            'order' => 4,
        ]);

        // Questions 36-40: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 36,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 3?<br>In boxes 36-40 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 35,
                'sub_questions' => [
                    ['id' => '36', 'label' => 'There is enough information for scientists to fully understand the placebo effect.', 'correct_answer' => 'FALSE'],
                    ['id' => '37', 'label' => 'A London based researcher discovered that red pills should be taken off the market.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '38', 'label' => 'People’s preference for brands would also have an effect on their healing.', 'correct_answer' => 'TRUE'],
                    ['id' => '39', 'label' => 'Medical doctors have a range of views of the newly introduced drug of chlorpromazine.', 'correct_answer' => 'TRUE'],
                    ['id' => '40', 'label' => 'Alternative practitioners are seldom known for applying the placebo effect.', 'correct_answer' => 'FALSE'],
                ]
            ],
            'order' => 5,
        ]);

    }
}
