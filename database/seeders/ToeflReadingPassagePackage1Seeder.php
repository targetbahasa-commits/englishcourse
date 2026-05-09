<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflReadingPassagePackage1Seeder extends Seeder
{
    /**
     * Run the database seeds for Reading Passages Package 1.
     */
    public function run(): void
    {
        // Clear existing passages and questions for package 1
        $passages = \App\Models\ToeflReadingPassage::where('package_number', 1)->get();
        foreach ($passages as $passage) {
            \App\Models\ToeflReadingQuestion::where('passage_id', $passage->id)->delete();
            $passage->delete();
        }

        $dummyMeeting = \App\Models\ToeflReadingMeeting::firstOrCreate(
            ['meeting_number' => 999],
            ['title' => 'Mockup Dummy Meeting', 'is_locked' => false]
        );

        // Passage 1: Romantic Music (Questions 1-9)
        $passage1 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $dummyMeeting->id,
            'package_number' => 1,
            'passage_number' => 1,
            'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Romantic music of the nineteenth century differed greatly from the classical music of the eighteenth century. Classical music was primarily concerned with strict form and style. Romantic composers, however, wanted to express their feelings and thoughts through music. Their music was less structured than the music of the classicists; its goal was to fill the listener with emotion, with thoughts of beauty, wonder, and nature, and with poetry.</p></div>',
        ]);

        $questions1 = [
            ['question_number' => 1, 'question_text' => 'What is the topic of this passage?', 'option_a' => 'The characteristics of romantic music', 'option_b' => 'Various types of music', 'option_c' => 'Popular music in the eighteenth century', 'option_d' => 'A comparison of romantic and classical music', 'correct_answer' => 'D'],
            ['question_number' => 2, 'question_text' => 'The word "greatly" in line 1 could best be replaced by which of the following?', 'option_a' => 'Famously', 'option_b' => 'Tremendously', 'option_c' => 'Structurally', 'option_d' => 'Slightly', 'correct_answer' => 'B'],
            ['question_number' => 3, 'question_text' => 'According to the passage, classical music', 'option_a' => 'expresses feelings and thoughts', 'option_b' => 'was popular in the nineteenth century', 'option_c' => 'has rigid forms', 'option_d' => 'is less structured than romantic music', 'correct_answer' => 'C'],
            ['question_number' => 4, 'question_text' => 'The word "form" in line 2 is closest in meaning to', 'option_a' => 'structure', 'option_b' => 'meter', 'option_c' => 'meaning', 'option_d' => 'use', 'correct_answer' => 'A'],
            ['question_number' => 5, 'question_text' => 'It can be inferred from the passage that romantic music', 'option_a' => 'developed prior to the eighteenth century', 'option_b' => 'did not have a strict form', 'option_c' => 'came before classical music', 'option_d' => 'was more concerned with form than feeling', 'correct_answer' => 'B'],
            ['question_number' => 6, 'question_text' => 'The word "goal" in line 4 is NOT close in meaning to which of the following?', 'option_a' => 'Aim', 'option_b' => 'Objective', 'option_c' => 'Result', 'option_d' => 'Purpose', 'correct_answer' => 'C'],
            ['question_number' => 7, 'question_text' => 'The word "emotion" in line 4 is closest in meaning to', 'option_a' => 'feeling', 'option_b' => 'logic', 'option_c' => 'sound', 'option_d' => 'movement', 'correct_answer' => 'A'],
            ['question_number' => 8, 'question_text' => 'According to the passage, romantic music filled the listener with all of the following EXCEPT', 'option_a' => 'thoughts of poetry', 'option_b' => 'thoughts of wonder', 'option_c' => 'thoughts of loveliness', 'option_d' => 'thoughts of strictness', 'correct_answer' => 'D'],
            ['question_number' => 9, 'question_text' => 'Where in the passage does the author mention when the different types of music were popular?', 'option_a' => 'Lines 1-2', 'option_b' => 'Line 3', 'option_c' => 'Line 4', 'option_d' => 'Line 5', 'correct_answer' => 'A'],
        ];

        foreach ($questions1 as $q) {
            \App\Models\ToeflReadingQuestion::create([
                'passage_id' => $passage1->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        // Passage 2: Benjamin Franklin (Questions 10-19)
        $passage2 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $dummyMeeting->id,
            'package_number' => 1,
            'passage_number' => 2,
            'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">In the American colonies, Benjamin Franklin worked as a printer; from his work, he clearly understood how difficult and costly it was to make books. However, he and his friends really enjoyed reading and wanted to get hold of as many books as they could.</p><p class="toefl-passage-paragraph">One of Franklin\'s good ideas, and he had many good ideas, was to set up a club where people could share their books. The 50 members who joined the club when it was started in 1732 donated books and also pooled their money to buy additional books. Anyone who wanted to could stop in and read the books; club members were also allowed to take the books home with them, provided they returned them on time. This "club" became America\'s first circulating library.</p></div>',
        ]);

        $questions2 = [
            ['question_number' => 10, 'question_text' => 'The passage mainly discusses', 'option_a' => 'the American colonies', 'option_b' => 'Benjamin Franklin\'s work as a printer', 'option_c' => 'Franklin\'s many good ideas', 'option_d' => 'America\'s first circulating library', 'correct_answer' => 'D'],
            ['question_number' => 11, 'question_text' => 'A "printer" in line 1 is a person who', 'option_a' => 'works in a library', 'option_b' => 'runs a book club', 'option_c' => 'reads a lot of books', 'option_d' => 'produces books and pamphlets', 'correct_answer' => 'D'],
            ['question_number' => 12, 'question_text' => 'The passage indicates that Franklin had', 'option_a' => 'no good ideas', 'option_b' => 'one good idea', 'option_c' => 'few good ideas', 'option_d' => 'numerous good ideas', 'correct_answer' => 'D'],
            ['question_number' => 13, 'question_text' => 'According to the passage, how many people were in the original club?', 'option_a' => '5', 'option_b' => '15', 'option_c' => '50', 'option_d' => '500', 'correct_answer' => 'C'],
            ['question_number' => 14, 'question_text' => 'The word "pooled" in line 6 could best be replaced by', 'option_a' => 'watered', 'option_b' => 'swam', 'option_c' => 'earned', 'option_d' => 'shared', 'correct_answer' => 'D'],
            ['question_number' => 15, 'question_text' => 'Which of the following is NOT mentioned as something that club members did?', 'option_a' => 'They gave books to the club.', 'option_b' => 'They started new clubs.', 'option_c' => 'They took books home.', 'option_d' => 'They helped buy additional books.', 'correct_answer' => 'B'],
            ['question_number' => 16, 'question_text' => 'It can be inferred that nonmembers of Franklin\'s club could NOT', 'option_a' => 'enter the club', 'option_b' => 'look at the club\'s books', 'option_c' => 'read', 'option_d' => 'take books out of the club', 'correct_answer' => 'D'],
            ['question_number' => 17, 'question_text' => 'The word "provided" in line 7 could best be replaced by', 'option_a' => 'If', 'option_b' => 'Before', 'option_c' => 'Where', 'option_d' => 'Although', 'correct_answer' => 'A'],
            ['question_number' => 18, 'question_text' => 'In line 8, the books in a "circulating" library are probably', 'option_a' => 'spun in circles', 'option_b' => 'moved up and down on the library shelves', 'option_c' => 'checked in and out of the library', 'option_d' => 'turned upside-down', 'correct_answer' => 'C'],
            ['question_number' => 19, 'question_text' => 'Where in the passage does the author explain why Franklin started the book club?', 'option_a' => 'Lines 1-2', 'option_b' => 'Lines 4-5', 'option_c' => 'Lines 6-7', 'option_d' => 'Line 8', 'correct_answer' => 'A'],
        ];

        foreach ($questions2 as $q) {
            \App\Models\ToeflReadingQuestion::create([
                'passage_id' => $passage2->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        // Passage 3: Trees (Questions 20-29)
        $passage3 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $dummyMeeting->id,
            'package_number' => 1,
            'passage_number' => 3,
            'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Trees are the largest living things on Earth. They are also among the oldest living organisms. The oldest known living tree is a bristlecone pine in California that is more than 4,000 years old. Trees are important to the environment in many ways. Their roots hold the soil together and prevent erosion. They provide shade and oxygen. Many animals depend on trees for food and shelter.</p><p class="toefl-passage-paragraph">Trees have several parts. The roots anchor the tree in the ground and absorb water and minerals from the soil. The trunk supports the tree and carries water and nutrients between the roots and leaves. The leaves use sunlight, water, and carbon dioxide to make food for the tree through a process called photosynthesis. This process also produces oxygen, which humans and animals need to breathe.</p><p class="toefl-passage-paragraph">Different types of trees grow in different parts of the world. Coniferous trees, such as pine and spruce, grow in cold climates and have needles instead of leaves. Deciduous trees, such as oak and maple, grow in temperate climates and lose their leaves in winter. Tropical trees grow in warm, rainy areas near the equator and stay green all year.</p></div>',
        ]);

        $questions3 = [
            ['question_number' => 20, 'question_text' => 'What is the main topic of this passage?', 'option_a' => 'The oldest trees in the world', 'option_b' => 'Trees and their importance', 'option_c' => 'How photosynthesis works', 'option_d' => 'Types of forests', 'correct_answer' => 'B'],
            ['question_number' => 21, 'question_text' => 'According to the passage, where is the oldest known living tree?', 'option_a' => 'In Oregon', 'option_b' => 'In Alaska', 'option_c' => 'In California', 'option_d' => 'In Washington', 'correct_answer' => 'C'],
            ['question_number' => 22, 'question_text' => 'The word "erosion" in line 3 refers to', 'option_a' => 'the cooling of the soil', 'option_b' => 'the wearing away of soil', 'option_c' => 'the growth of new plants', 'option_d' => 'the flooding of rivers', 'correct_answer' => 'B'],
            ['question_number' => 23, 'question_text' => 'According to the passage, which part of the tree absorbs water from the soil?', 'option_a' => 'The trunk', 'option_b' => 'The leaves', 'option_c' => 'The roots', 'option_d' => 'The bark', 'correct_answer' => 'C'],
            ['question_number' => 24, 'question_text' => 'The word "anchor" in line 6 is closest in meaning to', 'option_a' => 'decorate', 'option_b' => 'hold in place', 'option_c' => 'push away', 'option_d' => 'surround', 'correct_answer' => 'B'],
            ['question_number' => 25, 'question_text' => 'What is the main function of the trunk?', 'option_a' => 'It captures sunlight for photosynthesis.', 'option_b' => 'It produces oxygen for animals.', 'option_c' => 'It supports the tree and carries nutrients.', 'option_d' => 'It stores water for dry seasons.', 'correct_answer' => 'C'],
            ['question_number' => 26, 'question_text' => 'Photosynthesis requires all of the following EXCEPT', 'option_a' => 'water', 'option_b' => 'oxygen', 'option_c' => 'sunlight', 'option_d' => 'carbon dioxide', 'correct_answer' => 'B'],
            ['question_number' => 27, 'question_text' => 'According to the passage, coniferous trees are characterized by', 'option_a' => 'broad, flat leaves', 'option_b' => 'losing leaves in winter', 'option_c' => 'growing near the equator', 'option_d' => 'having needles instead of leaves', 'correct_answer' => 'D'],
            ['question_number' => 28, 'question_text' => 'The word "temperate" in line 11 is closest in meaning to', 'option_a' => 'extreme', 'option_b' => 'moderate', 'option_c' => 'tropical', 'option_d' => 'frozen', 'correct_answer' => 'B'],
            ['question_number' => 29, 'question_text' => 'It can be inferred that deciduous trees in winter', 'option_a' => 'continue to grow rapidly', 'option_b' => 'do not have leaves', 'option_c' => 'produce more oxygen', 'option_d' => 'absorb more water', 'correct_answer' => 'B'],
        ];

        foreach ($questions3 as $q) {
            \App\Models\ToeflReadingQuestion::create([
                'passage_id' => $passage3->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        // Passage 4: Hurricanes (Questions 30-39)
        $passage4 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $dummyMeeting->id,
            'package_number' => 1,
            'passage_number' => 4,
            'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Hurricanes are among the most powerful and destructive storms on Earth. These massive tropical storms form over warm ocean waters and can produce winds exceeding 74 miles per hour. The word "hurricane" is used specifically for storms that develop in the Atlantic Ocean or eastern Pacific Ocean. Similar storms in other parts of the world are called typhoons or cyclones.</p><p class="toefl-passage-paragraph">A hurricane forms when warm, moist air over the ocean rises rapidly, creating an area of low pressure below. As the warm air rises, it cools and forms clouds. More warm air rushes in to replace the rising air, and this air also rises and cools. This cycle continues, and the storm begins to rotate due to the Earth\'s rotation. The center of the hurricane is called the eye, and it is surprisingly calm. The most destructive winds and rain exist in the area just around the eye, called the eyewall.</p><p class="toefl-passage-paragraph">Scientists use a scale of 1 to 5 to measure the strength of hurricanes. A Category 1 hurricane has winds between 74 and 95 miles per hour and causes minimal damage. A Category 5 hurricane has winds greater than 157 miles per hour and causes catastrophic damage. Meteorologists track hurricanes carefully and issue warnings to help people prepare or evacuate.</p></div>',
        ]);

        $questions4 = [
            ['question_number' => 30, 'question_text' => 'What is the passage mainly about?', 'option_a' => 'How to prepare for hurricanes', 'option_b' => 'The formation and characteristics of hurricanes', 'option_c' => 'The difference between typhoons and hurricanes', 'option_d' => 'The damage caused by Category 5 storms', 'correct_answer' => 'B'],
            ['question_number' => 31, 'question_text' => 'The minimum wind speed for a storm to be called a hurricane is', 'option_a' => '50 mph', 'option_b' => '65 mph', 'option_c' => '74 mph', 'option_d' => '95 mph', 'correct_answer' => 'C'],
            ['question_number' => 32, 'question_text' => 'The word "exceeding" in line 2 is closest in meaning to', 'option_a' => 'below', 'option_b' => 'approaching', 'option_c' => 'going beyond', 'option_d' => 'measuring exactly', 'correct_answer' => 'C'],
            ['question_number' => 33, 'question_text' => 'How does a hurricane begin to form?', 'option_a' => 'Cold air descends rapidly over the ocean.', 'option_b' => 'Warm, moist air rises over warm ocean water.', 'option_c' => 'High pressure pushes air outward.', 'option_d' => 'Ocean currents force air upward near the coast.', 'correct_answer' => 'B'],
            ['question_number' => 34, 'question_text' => 'The "eye" of a hurricane is described as', 'option_a' => 'the most dangerous part of the storm', 'option_b' => 'the area with the strongest winds', 'option_c' => 'surprisingly calm', 'option_d' => 'surrounded by the eyewall on one side only', 'correct_answer' => 'C'],
            ['question_number' => 35, 'question_text' => 'The word "rotation" in line 8 refers to', 'option_a' => 'cooling of the air', 'option_b' => 'spinning movement', 'option_c' => 'upward flow of water', 'option_d' => 'violent rainfall', 'correct_answer' => 'B'],
            ['question_number' => 36, 'question_text' => 'Where is the most destructive part of a hurricane?', 'option_a' => 'At the outer edge of the storm', 'option_b' => 'In the eye', 'option_c' => 'In the eyewall', 'option_d' => 'Above the storm clouds', 'correct_answer' => 'C'],
            ['question_number' => 37, 'question_text' => 'A Category 1 hurricane causes damage that is described as', 'option_a' => 'catastrophic', 'option_b' => 'devastating', 'option_c' => 'moderate', 'option_d' => 'minimal', 'correct_answer' => 'D'],
            ['question_number' => 38, 'question_text' => 'The word "catastrophic" in line 14 is closest in meaning to', 'option_a' => 'minor', 'option_b' => 'expected', 'option_c' => 'disastrous', 'option_d' => 'temporary', 'correct_answer' => 'C'],
            ['question_number' => 39, 'question_text' => 'What do meteorologists do when a hurricane is approaching?', 'option_a' => 'They stop the hurricane from forming.', 'option_b' => 'They track the hurricane and issue warnings.', 'option_c' => 'They measure ocean temperatures carefully.', 'option_d' => 'They create a safe zone around the storm.', 'correct_answer' => 'B'],
        ];

        foreach ($questions4 as $q) {
            \App\Models\ToeflReadingQuestion::create([
                'passage_id' => $passage4->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        // Passage 5: Dolphins (Questions 40-50)
        $passage5 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $dummyMeeting->id,
            'package_number' => 1,
            'passage_number' => 5,
            'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Dolphins are marine mammals that are closely related to whales and porpoises. They are found in oceans and rivers throughout the world. Dolphins are well known for their intelligence and playful behavior. They are highly social animals that live and travel in groups called pods, which can range in size from just a few individuals to hundreds of dolphins.</p><p class="toefl-passage-paragraph">Dolphins are highly intelligent animals. They have large brains relative to their body size and are capable of complex problem-solving. Dolphins communicate with each other using a variety of sounds, including clicks, whistles, and squeaks. Each dolphin has a unique whistle, called a signature whistle, which acts like a name that other dolphins can recognize. Dolphins also use a form of sonar called echolocation to find fish and navigate in dark or murky waters. They emit sounds that bounce off objects and return as echoes, allowing the dolphin to determine the location and shape of objects.</p><p class="toefl-passage-paragraph">Many people are fascinated by the relationship between dolphins and humans. Dolphins have been known to help drowning swimmers by keeping them afloat or guiding them to shore. Scientists have also trained dolphins to perform various tasks. Despite this friendly reputation, dolphins are wild animals and should be treated with respect and caution.</p></div>',
        ]);

        $questions5 = [
            ['question_number' => 40, 'question_text' => 'What is the main idea of this passage?', 'option_a' => 'Why dolphins help humans', 'option_b' => 'The intelligence of marine animals', 'option_c' => 'General information about dolphins', 'option_d' => 'How dolphins use echolocation', 'correct_answer' => 'C'],
            ['question_number' => 41, 'question_text' => 'A group of dolphins is called a', 'option_a' => 'school', 'option_b' => 'herd', 'option_c' => 'pod', 'option_d' => 'flock', 'correct_answer' => 'C'],
            ['question_number' => 42, 'question_text' => 'The word "range" in line 4 is closest in meaning to', 'option_a' => 'vary', 'option_b' => 'remain constant', 'option_c' => 'decrease', 'option_d' => 'follow a pattern', 'correct_answer' => 'A'],
            ['question_number' => 43, 'question_text' => 'According to the passage, dolphins are highly intelligent because', 'option_a' => 'they live in large groups', 'option_b' => 'they help drowning humans', 'option_c' => 'they have large brains and can solve complex problems', 'option_d' => 'they can be trained by scientists', 'correct_answer' => 'C'],
            ['question_number' => 44, 'question_text' => 'A "signature whistle" functions like a dolphin\'s', 'option_a' => 'warning call', 'option_b' => 'personal name', 'option_c' => 'hunting signal', 'option_d' => 'mating call', 'correct_answer' => 'B'],
            ['question_number' => 45, 'question_text' => 'Echolocation helps dolphins to', 'option_a' => 'communicate their emotions to each other', 'option_b' => 'find food and navigate in dark waters', 'option_c' => 'warn other dolphins of danger', 'option_d' => 'attract mates during breeding season', 'correct_answer' => 'B'],
            ['question_number' => 46, 'question_text' => 'The word "emit" in line 11 is closest in meaning to', 'option_a' => 'receive', 'option_b' => 'absorb', 'option_c' => 'send out', 'option_d' => 'reflect', 'correct_answer' => 'C'],
            ['question_number' => 47, 'question_text' => 'According to the passage, what is one way dolphins have helped humans?', 'option_a' => 'By fishing alongside them', 'option_b' => 'By keeping drowning swimmers afloat', 'option_c' => 'By guarding ships at sea', 'option_d' => 'By warning of approaching storms', 'correct_answer' => 'B'],
            ['question_number' => 48, 'question_text' => 'The word "murky" in line 11 is closest in meaning to', 'option_a' => 'clear', 'option_b' => 'cold', 'option_c' => 'deep', 'option_d' => 'cloudy and dark', 'correct_answer' => 'D'],
            ['question_number' => 49, 'question_text' => 'What does the author suggest in the final paragraph?', 'option_a' => 'Dolphins should be kept in captivity.', 'option_b' => 'Dolphins are the most intelligent animals.', 'option_c' => 'People should be careful around dolphins despite their friendly image.', 'option_d' => 'Scientists have fully understood dolphin communication.', 'correct_answer' => 'C'],
            ['question_number' => 50, 'question_text' => 'Which of the following is NOT mentioned as a dolphin sound?', 'option_a' => 'Clicks', 'option_b' => 'Whistles', 'option_c' => 'Roars', 'option_d' => 'Squeaks', 'correct_answer' => 'C'],
        ];

        foreach ($questions5 as $q) {
            \App\Models\ToeflReadingQuestion::create([
                'passage_id' => $passage5->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        $this->command->info('ToeflReadingPassagePackage1Seeder: Successfully seeded 5 passages with questions for package 1.');
    }
}
