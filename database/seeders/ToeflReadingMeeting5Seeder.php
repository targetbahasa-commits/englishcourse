<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting5Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 5
        $meeting = ToeflReadingMeeting::where('meeting_number', 5)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 5,
                'title' => 'Main Ideas 5',
                'is_locked' => false
            ]);
        }

        // Passage 1: Mesa Verde and Anasazi Culture
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "Mesa Verde is the center of the prehistoric Anasazi culture. It is located in the high plateau lands near Four Corners, where Colorado, Utah, New Mexico, and Arizona come together. This high ground is majestic but not forbidding. The climate is dry, but tiny streams trickle at the bottom of deeply cut canyons, where seeps and springs provided water for the Anasazi to irrigate their crops. Rich red soil provided fertile ground for their crops of corn, beans, squash, tobacco, and cotton. The Anasazi domesticated the wild turkey and hunted deer, rabbits, and mountain sheep.

For a thousand years the Anasazi lived around Mesa Verde. Although the Anasazi are not related to the Navajos, no one knows what these Indians called themselves, and so they are commonly referred to by their Navajo name, Anasazi, which means \"ancient ones\" in the Navajo language.

Around 550 A.D., early Anasazi-then a nomadic people archaeologists call the basket makers began constructing permanent homes on mesa tops. In the next 300 years, the Anasazi made rapid technological advancements, including the refinement of not only basket-making but also pottery making and weaving. This phase of development is referred to as the Early Pueblo Culture.

By the Great Pueblo Period (1100-1300 A.D.), the Anasazi population swelled to over 5,000 and the architecturally ambitious cliff dwellings came into being. The Anasazi moved from the mesa tops onto ledges on the steep canyon walls, creating two and three story dwellings. They used sandstone blocks and mud mortar. There were no doors on the first floor and the Anasazi used ladders to reach the first roof. All the villages had underground chambers called kivas. Men held tribal councils there and also used them for secret religious ceremonies and clan meetings. Winding paths, ladders, and steps cut into the cliffs led from the valleys below to the ledges on which the villages stood. The largest settlement contained 217 rooms. One might surmise that these dwellings were built for protection, but the Anasazi had no known enemies and there is no sign of conflict.

But a bigger mystery is why the Anasazi occupied these structures such a short time. By 1300, Mesa Verde was deserted. It is conjectured that the Anasazi abandoned their settlements because of drought, overpopulation, crop failure, or some combination of these. They probably moved southward and were incorporated into the pueblo villages that the Spanish explorers encountered two hundred years later. Their descendants still live in the Southwest."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'The passage does NOT mention that the Anasazi hunted ...',
            'option_a' => 'sheep',
            'option_b' => 'turkeys',
            'option_c' => 'deer',
            'option_d' => 'rabbits',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 2,
            'question_text' => 'The name that the Anasazi used for themselves ...',
            'option_a' => 'means "basketmakers" in the Navajo language',
            'option_b' => 'is unknown today',
            'option_c' => 'was given to them by archaeologists',
            'option_d' => 'means "ancient ones" in the Anasazi language',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 3,
            'question_text' => 'How long did the Early Pueblo Culture last?',
            'option_a' => '200 years',
            'option_b' => '300 years',
            'option_c' => '550 years',
            'option_d' => '1000 years',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 4,
            'question_text' => 'Where did the Anasazi move during the Great Pueblo Period?',
            'option_a' => 'To settlements on ledges of canyon walls',
            'option_b' => 'To pueblos in the south',
            'option_c' => 'Onto the tops of the mesas',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 5,
            'question_text' => 'According to the passage, the Anasazi buildings were made primarily of ...',
            'option_a' => 'mud',
            'option_b' => 'blocks of wood',
            'option_c' => 'sandstone',
            'option_d' => 'the skins of animals',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 6,
            'question_text' => 'According to the passage, the Anasazi entered their buildings on the ledges ...',
            'option_a' => 'by means of ladders',
            'option_b' => 'from underground chambers',
            'option_c' => 'by means of stone stairways',
            'option_d' => 'through doors on the first floor',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 7,
            'question_text' => 'According to the passage, kivas were used for all the following purposes EXCEPT ...',
            'option_a' => 'clan meetings',
            'option_b' => 'food preparation',
            'option_c' => 'religious ceremonies',
            'option_d' => 'tribal councils',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 8,
            'question_text' => 'According to the passage, the LEAST likely reason that the Anasazi abandoned Mesa Verde was ...',
            'option_a' => 'drought',
            'option_b' => 'overpopulation',
            'option_c' => 'war',
            'option_d' => 'crop failure',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 9,
            'question_text' => 'Where in the passage does the author mention specific accomplishments of the Basketmakers?',
            'option_a' => 'Lines 8-11',
            'option_b' => 'Lines 12-16',
            'option_c' => 'Lines 17-19',
            'option_d' => 'Lines 29-31',
            'correct_answer' => 'B'
        ]);

        // Passage 2: Dulcimers
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "Dulcimers are musical instruments that basically consist of wooden boxes with strings stretched over them. In one form or another, they have been around since ancient times, probably originating with the Persian santir. Today there are two varieties: the hammered dulcimer and the Appalachian, or mountain dulcimer. The former is shaped like a trapezoid, has two or more strings, and is played with wooden mallets. It is the same instrument played in a number of Old World countries. The Appalachian dulcimer is classified by musicologists as a box zither. It is a descendant of the Pennsylvania Dutch scheitholt and the French epinette. Appalachian dulcimers are painstakingly fashioned by artisans in the mountains of West Virginia, Kentucky, Tennessee, and Virginia. These instruments have three or four strings and are plucked with quills or the fingers. They are shaped like teardrops or hourglasses. Heart-shaped holes in the sounding board are traditional. Most performers play the instruments while seated with the instruments in their laps, but others wear them around their necks like guitars or place them on tables in front of them. Originally used to play dance music, Appalachian dulcimers were popularized by performers such as John Jacob Niles and Jean Ritchie during the folk music revival of the 1960's."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 10,
            'question_text' => 'According to the passage, a hammered dulcimer is made in the shape of',
            'option_a' => 'an hourglass',
            'option_b' => 'a heart',
            'option_c' => 'a trapezoid',
            'option_d' => 'a teardrop',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 11,
            'question_text' => 'According to the passage, which of the following is NOT an ancestor of the Appalachian dulcimer?',
            'option_a' => 'The box zither',
            'option_b' => 'The santir',
            'option_c' => 'The scheitholt',
            'option_d' => 'The epinette',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 12,
            'question_text' => 'According to the passage, how many strings does the Appalachian dulcimer have?',
            'option_a' => 'One or two',
            'option_b' => 'Three or four',
            'option_c' => 'Four or five',
            'option_d' => 'Six or more',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 13,
            'question_text' => 'According to the author, most performers play the Appalachian dulcimer',
            'option_a' => 'while sitting down',
            'option_b' => 'with the instrument strapped around their neck',
            'option_c' => 'while standing at a table',
            'option_d' => 'with wooden hammers',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'question_text' => 'According to the author, what are John Jacob Niles and Jean Ritchie known for?',
            'option_a' => 'Played dance music on Appalachian dulcimers',
            'option_b' => 'Are artisans who design Appalachian dulcimers',
            'option_c' => 'Helped bring Appalachian dulcimers to the public\'s attention',
            'option_d' => 'Began the folk music revival of the 1960\'s',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 15,
            'question_text' => 'Where in the passage does the author describe the hammered dulcimer?',
            'option_a' => 'Lines 1-2',
            'option_b' => 'Lines 4-5',
            'option_c' => 'Lines 11-13',
            'option_d' => 'Lines 14-16',
            'correct_answer' => 'B'
        ]);

        // Passage 3: Dorothea Dix
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "Humanitarian Dorothea Dix was born in Hampden, Maine, in 1802. At the age of 19, she established a school for girls, the Dix Mansion School, in Boston, but had to close it in 1835 due to her poor health. She wrote and published the first of many books for children in 1824. In 1841, Dix accepted an invitation to teach classes at a prison in East Cambridge, Massachusetts. She was deeply disturbed by the sight of mentally ill persons thrown in the jail and treated like criminals. For the next 18 months, she toured Massachusetts institutions where other mental patients were confined, and reported the shocking conditions she found to the state legislature. When improvements followed in Massachusetts, she turned her attention to the neighboring states and then to the West and South.

Dix's work was interrupted by the Civil War; she served as superintendent of women hospital nurses for the federal government.

Dix saw special hospitals for the mentally ill built in some 15 states. Although her plan to obtain public land for her cause failed, she aroused concern for the problem of mental illness all over the United States as well as in Canada and Europe.

Dix's success was due to her independent and thorough research, her gentle but persistent manner, and her ability to secure the help of powerful and wealthy supporters."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 16,
            'question_text' => 'In what year was the Dix Mansion School closed?',
            'option_a' => '1802',
            'option_b' => '1824',
            'option_c' => '1835',
            'option_d' => '1841',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 17,
            'question_text' => 'Why did Dorothea Dix first go to a prison?',
            'option_a' => 'She taught classes there.',
            'option_b' => 'She was sent there by the state legislature.',
            'option_c' => 'She was convicted of a crime.',
            'option_d' => 'She was doing research for a book.',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 18,
            'question_text' => 'Where was Dorothea Dix first able to bring about reforms in the treatment of the mentally ill?',
            'option_a' => 'Canada',
            'option_b' => 'Massachusetts',
            'option_c' => 'The West and South',
            'option_d' => 'Europe',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 19,
            'question_text' => 'Dorothea Dix was NOT successful in her attempt to',
            'option_a' => 'become superintendent of nurses',
            'option_b' => 'publish books for children',
            'option_c' => 'arouse concern for the mentally ill',
            'option_d' => 'obtain public lands',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 20,
            'question_text' => 'At what point of the passage does the author discuss specific reasons for Dix\'s success?',
            'option_a' => 'Lines 1-4',
            'option_b' => 'Lines 5-6',
            'option_c' => 'Lines 11-12',
            'option_d' => 'Lines 16-17',
            'correct_answer' => 'D'
        ]);

        // Passage 4: Quilts
        $passage4 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "A quilt is a bed cover made of squares of material pieced together. Each square consists of two layers filled with a layer of wool or cotton cloth, feathers, or down. Often, the squares are decorated with fancy stitches and designs. According to legend, the earliest pieced quilt was stitched in 1704 by Sarah Sedgewick Everett, wife of the governor of the Massachusetts colony. By 1774 George Washington was buying quilts in Belvoir, Virginia, to take back to Martha in Mount Vernon. As the frontier moved westward, quilting went along. In addition to sleeping under them, homesteaders kept out drafts by hanging quilts over doors and windows. And if the money ran out, quilts were used to pay debts.

For isolated pioneer women, quilts were a source of comfort. Mary Wilman, whose family moved to Texas from Missouri in 1890, recalled the first time she and her mother had to spend a week alone and a dust storm came up. \"The wind blew for three days and nights, and it was so thick you couldn't see the barn. My mother quilted all day, and she taught me how to quilt. If it hadn't been for quilting, I think we would have gone crazy.\"

Quilting provided an important social function for the women of the frontier as well. At quilting bees, women met to work on quilts and to share the latest news.

Today, however, the homely quilt has become a costly cultural phenomenon. The International Quilt Festival in Houston, Texas, the \"world's fair of quilting,' attracted only 2,500 people and displayed only 200 quilts when it began a dozen years ago. This year there were over 20,000 visitors and 5,000 quilts, some of which sold for as much as $50,000."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 21,
            'question_text' => 'According to legend, who made the first American quilt?',
            'option_a' => 'Sarah Sedgewick Everett',
            'option_b' => 'the governor of the colony of Massachusetts',
            'option_c' => 'Martha Washington',
            'option_d' => 'Mary Wilman',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 22,
            'question_text' => 'Which of the following is NOT mentioned in the passage as one of the benefits of quilts for pioneers?',
            'option_a' => 'They could be used to pay debts.',
            'option_b' => 'They could be used to help insulate houses.',
            'option_c' => 'They could provide psychological comfort.',
            'option_d' => 'They could be worn as warm clothing.',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 23,
            'question_text' => 'According to the passage, what is a "quilting bee?"',
            'option_a' => 'A type of insect',
            'option_b' => 'A gathering where women socialized and made quilts',
            'option_c' => 'A type of quilt',
            'option_d' => 'A place where people buy and sell quilts',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 24,
            'question_text' => 'In what state is the International Quilt Festival held?',
            'option_a' => 'Massachusetts',
            'option_b' => 'Texas',
            'option_c' => 'Virginia',
            'option_d' => 'Missouri',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 25,
            'question_text' => 'How many quilts were displayed at the first International Quilt Festival?',
            'option_a' => '200',
            'option_b' => '2,500',
            'option_c' => '5,000',
            'option_d' => '20,000',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 26,
            'question_text' => 'Where in the passage does the author first begin to discuss the way in which the public\'s perception of quilts has changed in modern times?',
            'option_a' => 'Lines 7-9',
            'option_b' => 'Line 10',
            'option_c' => 'Lines 16-17',
            'option_d' => 'Line 18',
            'correct_answer' => 'D'
        ]);

        // Passage 5: Ambient Divers
        $passage5 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 5,
            'content' => "Ambient divers, unlike divers who go underwater in submersible vehicles or pressure-resistant suits, are exposed to the pressure and temperature of the surrounding (ambient) water. Of all types of diving, the oldest and simplest is free diving. Free divers may use no equipment at all, but most use a face mask, foot fins, and a snorkel. Under the surface, free divers must hold their breath. Most free divers can descend only 30 to 40 feet, but some skilled divers can go as deep as 100 feet. Scuba diving provides greater range than free diving. The word scuba stands for self-contained underwater breathing apparatus.

Scuba divers wear metal tanks with compressed air or other breathing gases. When using open-circuit equipment, a scuba diver simply breathes air from the tank through a hose and releases the exhaled air into the water. A closed-circuit breathing device, also called a rebreather, filters out carbon dioxide and other harmful gases and automatically adds oxygen. This enables the diver to breathe the same air over and over.

In surface-supplied diving, divers wear helmets and waterproof canvas suits. Today, sophisticated plastic helmets have replaced the heavy copper helmets used in the past. These divers get their air from a hose connected to compressors on a boat. Surface-supplied divers can go deeper than any other type of ambient diver."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 27,
            'question_text' => 'Ambient divers are ones who',
            'option_a' => 'can descend to extreme depths',
            'option_b' => 'use submersible vehicles',
            'option_c' => 'use no equipment',
            'option_d' => 'are exposed to the surrounding water',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 28,
            'question_text' => 'According to the passage, a free diver may use any of the following EXCEPT',
            'option_a' => 'a rebreather',
            'option_b' => 'a snorkel',
            'option_c' => 'foot fins',
            'option_d' => 'a mask',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 29,
            'question_text' => 'According to the passage, the maximum depth for free divers is around',
            'option_a' => '40 feet',
            'option_b' => '100 feet',
            'option_c' => '200 feet',
            'option_d' => '1,000 feet',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 30,
            'question_text' => 'When using closed-circuit devices, divers',
            'option_a' => 'exhale air into the water',
            'option_b' => 'hold their breath',
            'option_c' => 'breathe the same air over and over',
            'option_d' => 'receive air from the surface',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 31,
            'question_text' => 'According to the passage, surface-supplied divers today use helmets made from',
            'option_a' => 'glass',
            'option_b' => 'copper',
            'option_c' => 'plastic',
            'option_d' => 'canvas',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 32,
            'question_text' => 'Where in the passage does the author mention which type of diver can make the deepest descents?',
            'option_a' => 'Lines 3',
            'option_b' => 'Lines 9',
            'option_c' => 'Lines 11-13',
            'option_d' => 'Lines 16-17',
            'correct_answer' => 'D'
        ]);

        $this->command->info('TOEFL Reading Meeting 5 seeded successfully!');
    }
}
