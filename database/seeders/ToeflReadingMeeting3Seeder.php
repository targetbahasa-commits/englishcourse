<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting3Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 3
        $meeting = ToeflReadingMeeting::where('meeting_number', 3)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 3,
                'title' => 'Main Ideas 3',
                'is_locked' => false
            ]);
        }

        // Passage 1: European vs American Farming
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "In most of Europe, farmers' homes and outbuildings are generally located within a village, and tools and animals are housed there. Every morning, the farmers and farm laborers leave their village to work their land or tend their animals in distant fields, and return to the village at the end of the day. Social life is thus centripetal; that is, it is focused around the community center, the village. Only in certain parts of Quebec has this pattern been preserved in North America.

Throughout most of North America, a different pattern was established. It was borrowed from northern Europe, but was pushed even further in the New World where land was cheap or even free. It is a centrifugal system of social life, with large isolated farms whose residents go to the village only to buy goods and procure services. The independence associated with American farmers stems from this pattern of farm settlement. The American farmer is as free of the intimacy of the village as the urbanite."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'The main topic of the first paragraph is',
            'option_a' => 'European farm products',
            'option_b' => 'social life in Quebec',
            'option_c' => 'the European pattern of rural settlement',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 2,
            'question_text' => 'The main topic of the second paragraph is',
            'option_a' => 'the relative isolation of North American farm families',
            'option_b' => 'the relationship between farmers and urbanites in North America',
            'option_c' => 'the low cost of farmland in North America',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 3,
            'question_text' => 'The main topic of the entire passage is',
            'option_a' => 'a comparison of farming in northern and southern Europe',
            'option_b' => 'the difference between farming in Quebec and the rest of North America',
            'option_c' => 'European influence on American agriculture',
            'option_d' => 'a contrast between a centripetal system of rural life and a centrifugal system',
            'correct_answer' => 'D'
        ]);

        // Passage 2: Fats and Nutrition
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "While fats have lately acquired a bad image, one should not forget how essential they are. Fats provide the body's best means of storing energy, far more efficient energy sources than either carbohydrates or proteins. They act as insulation against cold, as cushioning for the internal organs, and as lubricants. Without fats, there would be no way to utilize fat-soluble vitamins. Furthermore, some fats contain fatty acids that contain necessary growth factors and help with the digestion of other foods.

An important consideration of fat intake is the ratio of saturated fats to unsaturated fats. Saturated fats, which are derived from dairy products, animal fats, and tropical oils, increase the amount of cholesterol in the blood. Cholesterol may lead to coronary heart disease by building up in the arteries of the heart. However, unsaturated fats, derived from vegetable oils, tend to lower serum cholesterol if taken in a proportion twice that of saturated fats.

The consumption of a variety of fats is necessary, but the intake of too much fat may lead to a variety of health problems. Excessive intake of fats, like all nutritional excesses, is to be avoided."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 4,
            'question_text' => 'The main idea of the first paragraph is that',
            'option_a' => 'fats have a bad image',
            'option_b' => 'fats serve important functions in the body',
            'option_c' => 'fats store food more efficiently than proteins or carbohydrates',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 5,
            'question_text' => 'What is the main idea of the second paragraph?',
            'option_a' => 'Unsaturated fats may reduce cholesterol levels.',
            'option_b' => 'The consumption of any type of fat leads to heart disease.',
            'option_c' => 'Fats taken in the proper proportion may reduce serum cholesterol.',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 6,
            'question_text' => 'The main idea of the third paragraph is that',
            'option_a' => 'people are eating less and less fat today',
            'option_b' => 'fats should be gradually eliminated from the diet',
            'option_c' => 'excessive consumption of fats may be dangerous to one\'s health',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 7,
            'question_text' => 'With which of the following is the whole passage primarily concerned?',
            'option_a' => 'The role of fats in human health',
            'option_b' => 'The dangers of cholesterol',
            'option_c' => 'The benefits of fats in the diet',
            'option_d' => 'The importance of good nutrition',
            'correct_answer' => 'A'
        ]);

        // Passage 3: Weathering and Soil
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "The term weathering refers to all the ways in which rock can be broken down. It takes place because minerals formed in a particular way (say at high temperatures, in the case of igneous rocks) are often unstable when exposed to various conditions. Weathering involves the interaction of the lithosphere (the earth's crust) with the atmosphere and hydrosphere (air and water). It occurs at different rates and in different ways, depending on the climactic and environmental conditions. But all kinds of weathering ultimately produce broken minerals and rock fragments and other products of the decomposition of stone.

Soil is the most obvious and, from the human point of view, the most important result of the weathering process. Soil is the weathered part of the Earth's crust that is capable of sustaining plant life. The character of soil depends on the nature of rock from which it is formed. It also depends on the climate and on the relative \"age\" of the soil. Immature soils are little more than broken rock fragments. Over time, immature soil develops into mature soil, which contains quantities of humus, formed from decayed plant matter. Mature soil is darker, richer in microscopic life, and more conducive to plant growth."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 8,
            'question_text' => 'The first paragraph primarily describes',
            'option_a' => 'the process by which rocks are broken down',
            'option_b' => 'the weathering of igneous rocks',
            'option_c' => 'gradual changes in the earth\'s weather patterns',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 9,
            'question_text' => 'The main topic of the second paragraph is',
            'option_a' => 'a description of immature soil',
            'option_b' => 'the growth of plants',
            'option_c' => 'the evolution of soil',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 10,
            'question_text' => 'The main idea of the entire passage is that',
            'option_a' => 'weathering breaks down rocks and leads to the development of soil',
            'option_b' => 'soils may be classified as mature or immature',
            'option_c' => 'the process of soil development is more important to humans than that of weathering',
            'option_d' => 'the Earth\'s crust is constantly changing',
            'correct_answer' => 'A'
        ]);

        $this->command->info('TOEFL Reading Meeting 3 seeded successfully!');
    }
}
