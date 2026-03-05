<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting2Seeder extends Seeder
{
    public function run()
    {
        // Get Meeting 2
        $meeting = ToeflReadingMeeting::where('meeting_number', 2)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 2,
                'title' => 'Main Ideas 2',
                'is_locked' => false
            ]);
        }

        // Passage 1: American Folk Music
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "American folk music originated with ordinary people at a time when the rural population was isolated and music was not yet spread by radio, audios, compact disks, or music DVDs. It was transmitted by oral tradition and is noted for its energy, humor, and emotional impact. The major source of early American folk songs was music from the British Isles, but songs from Africa as well as songs of the American Indians have a significant part in its heritage. Later settlers from other countries also contributed songs. In the nineteenth century, composer Stephen Foster wrote some of the most enduringly popular of all American songs, which soon became part of the folk tradition. Beginning in the 1930's, Woody Guthrie gained great popularity by adapting traditional melodies and lyrics and supplying new ones as well. In the 1950's and 1960's, singer-composers such as Pete Seeger, Bob Dylan, and Joan Baez continued this tradition by creating \"urban\" folk music. Many of these songs dealt with important social issues, such as racial integration and the war in Vietnam."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'The primary purpose of this passage is to',
            'option_a' => 'trace the development of American folk music',
            'option_b' => 'explain the oral tradition',
            'option_c' => 'contrast the styles of folk musicians',
            'option_d' => 'point out the influence of social issues on "urban" folk music',
            'correct_answer' => 'A'
        ]);

        // Passage 2: Psychology Language
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "Every scientific discipline tends to develop its own special language because it finds ordinary words inadequate, and psychology is no different. The purpose of this special jargon is not to mystify non-psychologists; rather, it allows psychologists to accurately describe the phenomena they are discussing and to communicate with each other effectively. Of course, psychological terminology consists in part of everyday words such as emotion, intelligence, and motivation, but psychologists use these words somewhat differently. For example, laymen use the term anxiety to mean nervousness or fear, but most psychologists reserve the term to describe a condition produced when one fears events over which one has no control."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 2,
            'question_text' => 'The main topic of this passage is',
            'option_a' => 'effective communication',
            'option_b' => 'the special language of psychology',
            'option_c' => 'two definitions of the word anxiety',
            'option_d' => 'the jargon of science',
            'correct_answer' => 'B'
        ]);

        // Passage 3: Gifford Pinchot
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "Gifford Pinchot was the first professionally trained forester in the United States. After he graduated from Yale in 1889, he studied forestry in Europe. In the 1890's he managed the forest on the Biltmore estate in North Carolina (now Pisgah National Forest) and became the first to practice scientific forestry. Perhaps his most important contribution to conservation was persuading President Theodore Roosevelt to set aside millions of acres in the West as forest reserves. These lands now make up much of the national parks and national forests of the United States. Pinchot became the Chief Forester of the U.S. Forest Service in 1905. Although he held that post for only five years, he established guidelines that set forest policy for decades to come."
        ]);

        // Note: No question visible in screenshot for Passage 3
        // Add question if provided later

        // Passage 4: Off-Broadway Theater
        $passage4 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "Off-Broadway theater developed in New York City in about 1950 as a result of dissatisfaction with conditions on Broadway. Its founders believed that Broadway was overly concerned with producing safe, commercially successful hit plays rather than drama with artistic quality. Off-Broadway producers tried to assist playwrights, directors, and performers who could not find work on Broadway. Off-Broadway theaters were poorly equipped, had limited seating, and provided few conveniences for audiences. But the originality of the plays, the creativity of the performers, and the low cost of tickets made up for these disadvantages, and off-Broadway theater prospered. However, by the 1960's, costs began to rise and by the 1970's, off-Broadway theater was encountering many of the difficulties of Broadway and had lost much of its vitality. With its decline, a experimental movement called off-off-Broadway theater developed."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 4,
            'question_text' => 'What is the main idea of this passage?',
            'option_a' => 'After initial success, off-Broadway theater began to decline.',
            'option_b' => 'Off-Broadway theaters produced many hit commercial plays.',
            'option_c' => 'Theaters on Broadway were not well equipped.',
            'option_d' => 'Off-Broadway plays were highly creative.',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 5,
            'question_text' => 'The paragraph that follows this passage most likely deals with',
            'option_a' => 'the help off-Broadway producers provided directors, playwrights, and performers',
            'option_b' => 'methods off-Broadway theaters used to cope with rising prices',
            'option_c' => 'the development of off-off-Broadway theater',
            'option_d' => 'the decline of Broadway theater',
            'correct_answer' => 'C'
        ]);

        // Passage 5: North American Indian Languages
        $passage5 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 5,
            'content' => "At the time of the first European contact, there were from 500 to 700 languages spoken by North American Indians. These were divided into some 60 language families, with no demonstrable genetic relationship among them. Some of these families spread across several of the seven cultural areas. The Algonquin family, for instance, contained dozens of languages and occupied a vast territory. Speakers of Algonquin languages included the Algonquins of the Eastern Woodland, the Blackfoots of the Plains, and the Wyots and Yuroks of California. Other language families, like the Zuni family of the Southwest, occupied only a few square miles of area and contained only a single tribal language."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 6,
            'question_text' => 'What is the main idea of this passage?',
            'option_a' => 'Each of the cultural areas was dominated by one of the language families.',
            'option_b' => 'The Zuni language is closely related to the Algonquin language.',
            'option_c' => 'There is considerable diversity in the size and the number of languages in language families of the North American Indians.',
            'option_d' => 'Contact with Europeans had an extraordinary effect on the languages of the Indian tribes of North America.',
            'correct_answer' => 'C'
        ]);

        // Passage 6: Journalism Changes
        $passage6 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 6,
            'content' => "Other major changes in journalism occurred around this time. In 1846, Richard Hoe invented the steam cylinder rotary press, making it possible to print newspapers faster and cheaper. The development of the telegraph made possible much speedier collection and distribution of news. Also in 1846, the first wire service was organized. A new type of newspaper appeared around this time, one that was more attuned to the spirit and needs of the new America. Although newspapers continued to cover politics, they came to report more human interest stories and to record the most recent news, which they could not have done before the telegraph. New York papers and those of other northern cities maintained corps of correspondents to go into all parts of the country to cover newsworthy events."
        ]);

        // Note: No question visible in screenshot for Passage 6
        // Add question if provided later

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 7,
            'question_text' => 'The main purpose of the passage is to',
            'option_a' => 'present a brief history of American journalism',
            'option_b' => 'outline certain developments in mid-19th-century journalism',
            'option_c' => 'explain the importance of the steam cylinder rotary press',
            'option_d' => 'present some biographical information about Richard Hoe',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 8,
            'question_text' => 'What is the most probable topic of the paragraph preceding this one?',
            'option_a' => 'Other types of rotary presses',
            'option_b' => 'Alternatives to using wire services',
            'option_c' => 'Newspapers that concentrated on politics',
            'option_d' => 'Other developments in journalism',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 9,
            'question_text' => 'The tone of the passage could best be described as',
            'option_a' => 'objective',
            'option_b' => 'optimistic',
            'option_c' => 'angry',
            'option_d' => 'humorous',
            'correct_answer' => 'A'
        ]);

        // Passage 7: Earthquakes in North America
        $passage7 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 7,
            'content' => "In the western third of North America, the convoluted folds of the Earth's surface and its fractured geologic structure tend to absorb the seismic energy of an earthquake. Even if an earthquake measuring 8.5 on the Richter scale struck Los Angeles, its force would fade by the time it reached San Francisco, some 400 miles away. But in the eastern two thirds of the continent the same energy travels more easily. The earthquake that struck New Madrid, Missouri, in 1811, estimated at 8 on the Richter scale, shook Washington, D.C., about 800 miles away, and was felt as far as Boston and Toronto."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage7->id,
            'question_number' => 10,
            'question_text' => 'Which of the following best expresses the main idea of this passage?',
            'option_a' => 'If a major earthquake strikes Los Angeles, it will probably damage San Francisco as well.',
            'option_b' => 'The New Madrid earthquake of 1811 was felt in Boston and Toronto.',
            'option_c' => 'The geology of the western United States is much more complex than that of the East.',
            'option_d' => 'Earthquakes travel farther in the East than in the West.',
            'correct_answer' => 'D'
        ]);

        // Passage 8: Children's Curiosity
        $passage8 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 8,
            'content' => "There has never been an adult scientist who has been half as curious as any child between the ages of four months and four years. Adults sometimes mistake this superb curiosity about everything as a lack of ability to concentrate. The truth is that children begin to learn at birth, and by the time they begin formal schooling at the age of five or six, they have already absorbed a fantastic amount of information, perhaps more, fact for fact, than they will learn for the rest of their lives. Adults can multiply by many times the knowledge children absorb if they appreciate this curiosity while Simultaneously encouraging the children to learn."
        ]);

        // Note: No question visible in screenshot for Passage 8
        // Add question if provided later

        ToeflReadingQuestion::create([
            'passage_id' => $passage8->id,
            'question_number' => 11,
            'question_text' => 'With which of the following statements would the author probably agree?',
            'option_a' => 'Children lack the ability to concentrate.',
            'option_b' => 'Young children have a much greater curiosity than adult scientists do.',
            'option_c' => 'The first few years of school are the most important ones for most children.',
            'option_d' => 'Adults can use children\'s intense curiosity to help children learn more.',
            'correct_answer' => 'D'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage8->id,
            'question_number' => 12,
            'question_text' => 'The paragraph following this one most likely deals with',
            'option_a' => 'ways in which adults can help children learn by stimulating their curiosity',
            'option_b' => 'the learning habits of children over the age of four',
            'option_c' => 'the methods adult scientists use to study the curiosity of young children',
            'option_d' => 'ways in which adults can become as curious as children about their environments',
            'correct_answer' => 'A'
        ]);

        // Passage 9: Settlement Houses
        $passage9 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 9,
            'content' => "Settlement houses were institutions established to improve living conditions in poor city neighborhoods in the late 1800's and early 1900's. They offered health, educational, recreational, and cultural activities. The first to open in the United States was University Settlement in New York City. It was established by the social reformer Stanton Coit in 1886. The most famous example was Hull House, established by the well-known reformer Jane Addams in Chicago in 1890. Settlement houses were usually staffed by idealistic young college graduates who were eager to improve the condition of the poor."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage9->id,
            'question_number' => 13,
            'question_text' => 'The passage mainly discusses',
            'option_a' => 'U.S. cities in the late nineteenth century',
            'option_b' => 'the idealism of college graduates',
            'option_c' => 'settlement houses in the late 1800\'s and early 1900\'s',
            'option_d' => 'the life of several American social reformers',
            'correct_answer' => 'C'
        ]);

        // Passage 10: Isadora Duncan
        $passage10 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 10,
            'content' => "The dancer Isadora Duncan was a daring, dynamic innovator in dance. While she was not very successful in teaching her highly personal style of dance to others, she taught a generation of dancers to trust their own forms of expression. She rebelled against the rigid, formal style of classical ballet. Inspired by the art of Greece, she usually danced barefoot in a loose, flowing Greek tunic. She found further inspiration in nature and used dance movements to mirror the waves of the sea and passing clouds. Isadora Duncan was born in San Francisco in 1878. She gave her first performance in 1899. Early failures gave way to triumphant performances in Budapest, Berlin, London, and finally, in 1908, back in the United States. She lived in Europe most of her life, establishing dancing schools for children there. She died in 1927 near Nice, France, in a freak accident, her long scarf being caught in the wheel of an open sports car in which she was riding."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage10->id,
            'question_number' => 14,
            'question_text' => 'The author\'s attitude toward Isadora Duncan could best be described as one of',
            'option_a' => 'displeasure',
            'option_b' => 'admiration',
            'option_c' => 'compassion',
            'option_d' => 'amazement',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage10->id,
            'question_number' => 15,
            'question_text' => 'Which of the following best describes the organization of the passage?',
            'option_a' => 'The author first discusses Isadora Duncan\'s style of dance and then her life history.',
            'option_b' => 'The first paragraph deals with Isadora Duncan\'s role as a teacher, the second her role as a performer.',
            'option_c' => 'The author first discusses Isadora Duncan\'s shortcomings and then her positive points.',
            'option_d' => 'First there is an analysis of Isadora Duncan\'s influences and then of her lasting contributions to dance.',
            'correct_answer' => 'A'
        ]);

        // Passage 11: Medieval Alchemists
        $passage11 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 11,
            'content' => "Through the centuries, the dream of medieval alchemists was to discover how to turn lead and other \"base\" metals into gold. Some were fakes, but many were learned men with philosophical goals. Their quest was based on the ancient idea that all matter consists of different proportions of just four substances-earth, water, fire, and air. They believed that it was possible to adjust the proportions of the elements that made up lead by chemical means so that it turned into gold, a process called transmutation. Their experiments were concerned with finding the substance-which they called the philosopher's stone-that, when added to lead, would cause this astonishing change to take place. Alchemists also searched for the elixir of life, a substance that could cure diseases and prolong life. They failed on both counts. However, their techniques for preparing and studying chemicals helped lay the foundation for the modern science of chemistry."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage11->id,
            'question_number' => 16,
            'question_text' => 'Which of the following statements best summarizes the author\'s attitude toward medieval alchemists?',
            'option_a' => 'Although they were all fakes, they made important contributions to science.',
            'option_b' => 'Their discovery of the philosopher\'s stone was more important than the achievements of modern chemists.',
            'option_c' => 'Although their theories were sound, they lacked the equipment needed to accomplish their goals.',
            'option_d' => 'They were unable to realize their goals, but they helped prepare the way for modern chemistry.',
            'correct_answer' => 'D'
        ]);

        $this->command->info('TOEFL Reading Meeting 2 seeded successfully!');
    }
}
