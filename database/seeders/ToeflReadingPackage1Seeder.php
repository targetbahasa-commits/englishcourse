<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;
use App\Models\ToeflReadingMeeting;

class ToeflReadingPackage1Seeder extends Seeder
{
    public function run(): void
    {
        // Create a meeting for Package 1 if not exists
        $meeting = ToeflReadingMeeting::firstOrCreate(
            ['title' => 'Mockup Package 1 Reading'],
            ['meeting_number' => 14, 'is_locked' => false]
        );

        // Delete existing passages for package 1
        $existingPassageIds = ToeflReadingPassage::where('package_number', 1)->pluck('id');
        ToeflReadingQuestion::whereIn('passage_id', $existingPassageIds)->delete();
        ToeflReadingPassage::where('package_number', 1)->delete();

        // ==============================
        // PASSAGE 1: The Surface of Venus
        // Questions 1-10
        // ==============================
        $passage1 = ToeflReadingPassage::create([
            'meeting_id'      => $meeting->id,
            'package_number'  => 1,
            'passage_number'  => 1,
            'content'         => "The first maps of Venus were made using radar beams transmitted from Earth. Radar was the only way to map its surface, because the clouds on Venus are so thick that the surface cannot be seen through them. The results of these early attempts at mapping were relatively crude and difficult to interpret, although the regions known as Alpha and Beta Regiones were discovered.  The first direct view of the surface came from probes, which were landed on Venus in 1975 by the spacecraft Venera 9 and 10, and showed a dry rock-strewn surface.  Maps of the surface improved dramatically in 1978, when the Pioneer-Venus 1 spacecraft went into orbit around Venus, equipped with a radar altimeter. It showed huge rolling plains stretching right around the planet, some lowland areas, and two highland regions called Ishtar and Aphrodite. The peaks of the highest mountains, Maxwell Montes, in the eastern part of Ishtar, were found to be 12,000 meters above the general surface level, so they are appreciably higher than the Himalayas. Aphrodite, which is larger than Ishtar, has a vast rift valley at its eastern end nearly 3,000 meters deep, 2,200 kilometers long, and 280 kilometers wide. Two shield volcanoes, broad volcanoes formed of successive outpourings of lava, which are much larger than any found on Earth, were also found isolated from the two upland areas. Six years later a great many impact craters and small volcanoes were found by Venera 15 and 16 orbiters.  Later yet, the Magellan spacecraft entered orbit around Venus in August 1990, and over the next two years completed a detailed radar mapping of the surface. It found that the surface is mostly volcanic, with large lava-flooded plains and thousands of volcanoes. There are also signs of tectonic activity, which has caused, for example, multiple faulting and deep fractures. There are a number of rift valleys, some of which have been partly flooded by molten lava, and a number of impact craters, the density of which has enabled the ages of various areas to be estimated. The absence of impact craters in an area suggests an age of no more than a few tens of millions of years.",
        ]);

        $questions1 = [
            [
                'question_number' => 1,
                'question_text'   => 'The passage mainly discusses how',
                'option_a'        => 'radar technology improved over time',
                'option_b'        => 'the surface of Venus compares to Earth\'s surface',
                'option_c'        => 'the age of Venus was determined scientifically',
                'option_d'        => 'knowledge about the surface of Venus was obtained',
                'correct_answer'  => 'D',
            ],
            [
                'question_number' => 2,
                'question_text'   => 'The passage mentions that radar beams were used to obtain the first maps of Venus because they',
                'option_a'        => 'allowed for mapping more than the two regions already familiar to scientists',
                'option_b'        => 'could penetrate the clouds that concealed the surface of Venus',
                'option_c'        => 'were the least expensive method of mapping at the time',
                'option_d'        => 'could be transmitted easily from Earth',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 3,
                'question_text'   => 'The word "equipped" in line 9 is closest in meaning to',
                'option_a'        => 'selected',
                'option_b'        => 'adjusted',
                'option_c'        => 'inspected',
                'option_d'        => 'furnished',
                'correct_answer'  => 'D',
            ],
            [
                'question_number' => 4,
                'question_text'   => 'The author discusses Maxwell Montes together with the Himalayas in the passage in order to',
                'option_a'        => 'indicate their similar composition',
                'option_b'        => 'establish the height of Maxwell Montes',
                'option_c'        => 'indicate that the terrain on Earth resembles the terrain on Venus',
                'option_d'        => 'compare the origins of the two mountain ranges',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 5,
                'question_text'   => 'The word "appreciably" in line 13 is closest in meaning to',
                'option_a'        => 'surprisingly',
                'option_b'        => 'probably',
                'option_c'        => 'noticeably',
                'option_d'        => 'consistently',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 6,
                'question_text'   => 'The word "vast" in line 14 is closest in meaning to',
                'option_a'        => 'extensive',
                'option_b'        => 'remote',
                'option_c'        => 'obvious',
                'option_d'        => 'raised',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 7,
                'question_text'   => 'The word "isolated" in line 17 is closest in meaning to',
                'option_a'        => 'surrounded',
                'option_b'        => 'separated',
                'option_c'        => 'accumulated',
                'option_d'        => 'elevated',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 8,
                'question_text'   => 'Pioneer-Venus 1 discovered that Venus had all of the following features EXCEPT',
                'option_a'        => 'impact craters',
                'option_b'        => 'lowlands',
                'option_c'        => 'mountains',
                'option_d'        => 'shield volcanoes',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 9,
                'question_text'   => 'The Magellan spacecraft discovered that most of the surface of Venus is covered with',
                'option_a'        => 'faults and fractures',
                'option_b'        => 'rift valleys',
                'option_c'        => 'lava and volcanoes',
                'option_d'        => 'impact craters',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 10,
                'question_text'   => 'It can be inferred from the passage that scientists use the density of impact craters on Venus to determine which of the following?',
                'option_a'        => 'The cause of the faults and fractures',
                'option_b'        => 'The age of different areas of the planet\'s surface',
                'option_c'        => 'The areas that are most geologically active',
                'option_d'        => 'The amount of flooding of rift valley areas',
                'correct_answer'  => 'B',
            ],
        ];

        foreach ($questions1 as $q) {
            ToeflReadingQuestion::create(array_merge(['passage_id' => $passage1->id], $q));
        }

        // ==============================
        // PASSAGE 2: George Pullman's Model City
        // Questions 11-19
        // ==============================
        $passage2 = ToeflReadingPassage::create([
            'meeting_id'      => $meeting->id,
            'package_number'  => 1,
            'passage_number'  => 2,
            'content'         => "In the United States, many social reformers in the late nineteenth century demonstrated a concern for improved housing conditions for workers. George Pullman (1831-1897), the wealthy industrialist who introduced luxury railway cars with beds, built his model city called Pullman in 1880 to address housing problems caused by Chicago's industrialization. In constructing the town, Pullman hoped to produce an ideal environment that would help attract workers of a superior type to the railway car industry and retain them. Pullman inhabitants were expected to embody values of thrift, industry, and morality. They were taught to develop propriety and good manners, cleanliness and neatness of appearance, diligence, and self-improvement through education and savings. Like the brick clock tower that dominated the town center, Pullman kept a regulatory eye on his workers.  In its first five years, this new experiment in industrial life received little criticism, except from radical political groups. Crediting the town of Pullman with producing a new type of dependable and ambitious worker in a rationally ordered environment, reformers, at first, praised it as a successful model for modern industrial life. However, after 1885, with the high gloss of the experiment dulled, it became clear that the residents of Pullman had honest grievances about the overcharging of rent and other services.  In 1893, The World's Columbian Exposition, an exhibition that aimed to promote American cultural, economic, and technological development, and in which George Pullman was a major investor, was held in Chicago. The town of Pullman became a popular tourist stop, attracting more than its share of curious travelers. There were 10,000 foreign visitors alone during the exposition year. In fact, the first Baedeker Travel Guide to the United States advised visitors to tour Pullman. Frequent trains and trolley cars connected the fairgrounds of the exposition with the town, and on several occasions, George Pullman himself guided the tours. Constructing a fantastic environment for the benefit of tourists, he made sure that any real tensions between his office and the working inhabitants of the town were rendered invisible to the tourist gaze.",
        ]);

        $questions2 = [
            [
                'question_number' => 11,
                'question_text'   => 'What does the passage mainly discuss?',
                'option_a'        => 'The effect of industrialization on the city of Pullman',
                'option_b'        => 'The model city built by George Pullman',
                'option_c'        => 'The career of George Pullman',
                'option_d'        => 'Housing problems in the nineteenth century',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 12,
                'question_text'   => 'According to the passage, which of the following led to the creation of the town of Pullman?',
                'option_a'        => 'A surplus of railway workers in Chicago',
                'option_b'        => 'Housing problems caused by industrialization',
                'option_c'        => 'George Pullman\'s decision to stop producing railway cars',
                'option_d'        => 'The opening of the World\'s Columbian Exposition',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 13,
                'question_text'   => 'According to the passage, George Pullman expected that the city of Pullman would',
                'option_a'        => 'impress social reformers',
                'option_b'        => 'satisfy radical political groups',
                'option_c'        => 'soon develop housing problems',
                'option_d'        => 'draw workers to the railway car industry',
                'correct_answer'  => 'D',
            ],
            [
                'question_number' => 14,
                'question_text'   => 'The word "retain" in line 7 is closest in meaning to',
                'option_a'        => 'house',
                'option_b'        => 'train',
                'option_c'        => 'keep',
                'option_d'        => 'reward',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 15,
                'question_text'   => 'According to the passage, Pullman inhabitants were taught to do all of the following EXCEPT',
                'option_a'        => 'have good manners',
                'option_b'        => 'become active in town politics',
                'option_c'        => 'value education',
                'option_d'        => 'save money',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 16,
                'question_text'   => 'What does the author imply about George Pullman\'s attitude toward his workers in line 11?',
                'option_a'        => 'Pullman believed that his workers should follow a strict daily schedule.',
                'option_b'        => 'Pullman felt that his workers required careful monitoring and supervision.',
                'option_c'        => 'Pullman thought that individual workers could be taught to work together as a team.',
                'option_d'        => 'Pullman believed that his workers had trouble keeping track of the time they spent on a task.',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 17,
                'question_text'   => 'The word "grievances" in line 17 is closest in meaning to',
                'option_a'        => 'concerns',
                'option_b'        => 'compliments',
                'option_c'        => 'debates',
                'option_d'        => 'complaints',
                'correct_answer'  => 'D',
            ],
            [
                'question_number' => 18,
                'question_text'   => 'The word "rendered" in line 28 is closest in meaning to',
                'option_a'        => 'made',
                'option_b'        => 'kept',
                'option_c'        => 'allowed',
                'option_d'        => 'found',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 19,
                'question_text'   => 'Why does the author mention the Baedeker Travel Guide in line 24?',
                'option_a'        => 'To show that Pullman attracted international tourists',
                'option_b'        => 'To describe how visitors traveled to the Exposition',
                'option_c'        => 'To indicate that Pullman was a well-known tourist destination',
                'option_d'        => 'To suggest that Pullman was the most important city in the United States',
                'correct_answer'  => 'C',
            ],
        ];

        foreach ($questions2 as $q) {
            ToeflReadingQuestion::create(array_merge(['passage_id' => $passage2->id], $q));
        }

        echo "✅ Seeded Package 1 Reading: 2 passages, 19 questions ";
    }
}
