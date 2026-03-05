<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting7Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 7
        $meeting = ToeflReadingMeeting::where('meeting_number', 7)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 7,
                'title' => 'Inferences 2',
                'is_locked' => false
            ]);
        }

        // Passage 1: Neon Lights
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "The term \"neon light\" was originally applied to a particular type of vapor lamp using the inert gas neon. A long tube was filled with neon, which then became luminous at low pressure when an electric current was passed through it. The lamp then emitted the characteristic reddish-orange light of neon. Today, the term \"neon light\" is given to lamps of this general type which may be filled with a variety of gases, depending on the color that is desired. Argon, for example, is used to produce blue light. Colors can also be altered by changing the color of the glass tube. The tubes must be quite long in all these lamps to produce light efficiently. As a result, high voltages are required. Neon tube lamps are not practical for indoor illumination, but they have found widespread outdoor use in glowing, colorful advertising signs."
        ]);

        // Questions 1-7 for Passage 1 (True/False/Not Given format - using textbox)
        for ($i = 1; $i <= 7; $i++) {
            $questions = [
                1 => 'The inert gas neon is reddish-orange in color.',
                2 => 'The meaning of the term "neon light" has changed over time.',
                3 => 'Today\'s "neon lights" never actually contain neon.',
                4 => 'All types of "neon lights" work on the same general principles.',
                5 => 'When stimulated by electricity, different types of gas produce different colors.',
                6 => 'Modern "neon lights" are more efficient than those used in the past.',
                7 => 'The primary market for neon lights is businesses rather than private households.'
            ];

            ToeflReadingQuestion::create([
                'passage_id' => $passage1->id,
                'question_number' => $i,
                'question_text' => $questions[$i],
                'option_a' => '',
                'option_b' => '',
                'option_c' => '',
                'option_d' => '',
                'correct_answer' => '' // Will be filled manually via UI
            ]);
        }

        // Passage 2: Synthetic Flavors and Fragrances
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "Natural flavorings and fragrances are often costly and limited in supply. For example, the vital ingredient in a rose fragrance is extracted from natural rose oil at a cost of thousands of dollars a pound; an identical synthetic substance can be made for 1 % of this cost. Since the early twentieth century, success in reproducing these substances has created a new industry that today produces hundreds of artificial flavors and fragrances.

Some natural fragrances are easily synthesized; these include vanillin, the aromatic ingredient in vanilla, and benzaldehyde, the aromatic ingredient in wild cherries. Other fragrances, however, have dozens, even hundreds of components. Only recently has it been possible to separate and identify these ingredients by the use of gas chromatography and spectroscopy. Once the chemical identity is known, it is often possible to synthesize them. Nevertheless, some complex substances, such as the aroma of fresh coffee, have still not been duplicated satisfactorily.

Many of the chemical compounds making up these synthetics are identical to those found in nature, and are as harmless or harmful as the natural substances. New products must be tested for safety and when used in food, must be approved by the US. Food and Drug Administration.

The availability of synthetic flavors and fragrances has made possible a large variety of products, from inexpensive beverages to perfumed soap to used cars with applied \"new car odor.\""
        ]);

        // Questions 8-15 for Passage 2 (True/False/Not Given format - using textbox)
        for ($i = 8; $i <= 15; $i++) {
            $questions = [
                8 => 'Natural rose fragrance is 100 times more expensive to produce than artificial rose fragrance.',
                9 => 'Vanillin is easier to synthesize than benzaldehyde.',
                10 => 'In general, the more components there are in a fragrance, the harder it is to synthesize.',
                11 => 'Once a substance has been chemically analyzed, it can always be easily synthesized.',
                12 => 'Only recently has it been possible to satisfactorily synthesize the aroma of fresh coffee.',
                13 => 'Not all synthetic flavors are harmless.',
                14 => 'Synthesized substances must be tested for safety only if they\" are used in food.',
                15 => 'Synthetic fragrances can be used to make a used car smell like a new one.'
            ];

            ToeflReadingQuestion::create([
                'passage_id' => $passage2->id,
                'question_number' => $i,
                'question_text' => $questions[$i],
                'option_a' => '',
                'option_b' => '',
                'option_c' => '',
                'option_d' => '',
                'correct_answer' => '' // Will be filled manually via UI
            ]);
        }

        // Passage 3: Legends
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "A legend is a popular type of folk tale. In some ways, legends resemble myths, another type of folk tale. But myths describe events from antiquity and usually deal with religious subjects, such as the birth of a god. Legends tell of recognizable people, places, and events and often take place in comparatively recent times. Some legends are based on real persons or events, but many are entirely fictional. The legends of the superhuman accomplishments of Paul Bunyan and Pecos Bill are imaginary, while the legends about Washington and Lincoln are mostly exaggerations of real qualities those two presidents had.

All societies have legends. Most legends began as stories about the heroes of a particular region, occupation, or ethnic group. For example, John Henry was a legendary hero of black Americans, and Casey Jones of railroad workers. Over time, however, these figures have become national heroes."
        ]);

        // Questions 16-20 for Passage 3 (True/False format - using textbox)
        for ($i = 16; $i <= 20; $i++) {
            $questions = [
                16 => 'Both legends and myths can be classified as folk tales.',
                17 => 'Myths generally take place in comparatively recent times.',
                18 => 'The stories of Paul Bunyan and Pecos Bill are not true, but they are based on actual people.',
                19 => 'Legends about Washington and Lincoln are not entirely fictional.',
                20 => 'John Henry and Casey Jones are today well-known only by certain groups of people.'
            ];

            ToeflReadingQuestion::create([
                'passage_id' => $passage3->id,
                'question_number' => $i,
                'question_text' => $questions[$i],
                'option_a' => '',
                'option_b' => '',
                'option_c' => '',
                'option_d' => '',
                'correct_answer' => '' // Will be filled manually via UI
            ]);
        }

        // Passage 4: Tumbleweeds
        $passage4 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "In 1881, a new type of weed began spreading across the northern Great Plains. Unlike other weeds, the tumbleweed did not spend its life rooted to the soil; instead it tumbled and rolled across fields in the wind. The weed had sharp, spiny leaves that could lacerate the flesh of ranchers and horses alike. It exploited the vast area of the plains, thriving in regions too barren to support other plants. With its ability to generate and disseminate numerous seeds quickly, it soon became the scourge of the prairies.

To present-day Americans, the tumbleweed symbolizes the Old West. They read the Zane Grey novels in which tumbleweeds drift across stark western landscapes and see classic western movies in which tumbleweeds roll past scenes with cowboys and covered wagons. Yet just over a century ago, the tumbleweed was a newcomer. The first sign of the invasion occurred in North and South Dakota in the late 1870's.

Farmers had noticed the sudden appearance of the new unusual plant. One group of immigrants, however, did not find the weed at all unfamiliar. The tumbleweed, it turns out, was a native of southern Russia, where it was known as Tartar thistle. It was imported to the United States by unknowing farmers.

Frontier settlers gave the plants various names: saltwort, Russian cactus, and wind witch. But botanists at the Department of Agriculture preferred the designation Russian thistle as the plant's common name. However, these botanists had a much harder time agreeing on the plant's scientific name. Generally, botanists compare a plant to published accounts of similar plants, or to samples kept as specimens. Unfortunately, no book described the weed, and no samples existed in herbaria in the United States."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 8,
            'question_text' => 'Which of the following can be inferred about tumbleweeds?',
            'option_a' => 'They have strong, deep roots.',
            'option_b' => 'They require a lot of care.',
            'option_c' => 'They reproduce efficiently.',
            'option_d' => 'They provided food for ranchers and animals.',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 9,
            'question_text' => 'The passage suggests that most present-day Americans ...',
            'option_a' => 'consider the tumbleweed beneficial',
            'option_b' => 'don\'t know when tumbleweeds came to North America',
            'option_c' => 'have never heard of tumbleweeds',
            'option_d' => 'believe tumbleweeds are newcomers to the United States',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 10,
            'question_text' => 'The author mentions the novels of Zane Grey and classic western movies (lines 8-9) because they...',
            'option_a' => 'tell the story of the invasion of tumbleweeds',
            'option_b' => 'are sources of popular information about tumbleweeds',
            'option_c' => 'present very inaccurate pictures of tumbleweeds',
            'option_d' => 'were written long before tumbleweeds were present in the United States',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 11,
            'question_text' => 'It is probable that the "group of immigrants" mentioned in line 18...',
            'option_a' => 'was from southern Russia',
            'option_b' => 'had lived in North and South Dakota for many years',
            'option_c' => 'imported tumbleweeds into the United States',
            'option_d' => 'wrote a number of accounts about tumbleweeds',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 12,
            'question_text' => 'From the passage it can be inferred that the botanists at the Department of Agriculture ...',
            'option_a' => 'could not find any tumbleweeds on the plains',
            'option_b' => 'gave the names saltwort, Russian cactus, and wind witch to the tumbleweed',
            'option_c' => 'could not decide on a common designation for the tumbleweed',
            'option_d' => 'found it difficult to classify the plant scientifically',
            'correct_answer' => 'D'
        ]);

        // Passage 7: Airport Design
        $passage7 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 7,
            'content' => "For most modern airports, the major design problem is scale how to allow adequate space on the ground for maneuvering wide body jets while permitting convenient and rapid movement of passengers departing, arriving, or transferring from one flight to another.

Most designs for airport terminals take one of four approaches. In the linear plan, the building may be straight or curved. The passengers board aircraft parked next to the terminal. This plan works well for small airports that need to provide boarding areas for only a few aircraft at a time.

In the pier plan, narrow corridors or piers extend from a central building. This plan allows many aircraft to park next to the building. However, it creates long walking distances for passengers.

In the satellite plan, passengers board aircraft from small terminals that are separated from the main terminals. Passengers reach the satellites by way of shuttle trains or underground passageways that have shuttle trains or moving sidewalks.

The transporter plan uses some system of transport to move passengers from the terminal building to the aircraft. If buses are used, the passengers must climb a flight of stairs to board the aircraft. If mobile lounges are used, they can link up directly with the aircraft and protect passengers from the weather."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage7->id,
            'question_number' => 13,
            'question_text' => 'It can be inferred that scale would not pose a major design problem at airports if ...',
            'option_a' => 'airports were larger',
            'option_b' => 'aircraft did not need so much space to maneuver on the ground',
            'option_c' => 'other forms of transportation were more efficient',
            'option_d' => 'airplanes could fly faster',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage7->id,
            'question_number' => 14,
            'question_text' => 'The linear plan would probably be best at ...',
            'option_a' => 'a busy airport',
            'option_b' => 'an airport used by many small aircraft',
            'option_c' => 'an airport with only a few arrivals or departures',
            'option_d' => 'an airport that serves a large city',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage7->id,
            'question_number' => 15,
            'question_text' => 'The passage implies that the term "satellite plan" is used because ...',
            'option_a' => 'satellites are launched and tracked from these sites',
            'option_b' => 'small terminals circle the main terminal like satellites around a planet',
            'option_c' => 'the plan makes use of the most modern, high-technology equipment',
            'option_d' => 'airports that make use of this plan utilize data from weather satellites',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage7->id,
            'question_number' => 16,
            'question_text' => 'The passage suggests that shuttle trains transfer passengers to satellite terminals from ...',
            'option_a' => 'the main terminal',
            'option_b' => 'airplanes',
            'option_c' => 'downtown',
            'option_d' => 'other satellite terminals',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage7->id,
            'question_number' => 17,
            'question_text' => 'It can be inferred that mobile lounges would be more desirable than buses when ...',
            'option_a' => 'passengers are in a hurry',
            'option_b' => 'flights have been delayed',
            'option_c' => 'the weather is bad',
            'option_d' => 'passengers need to save money',
            'correct_answer' => 'C'
        ]);

        // Passage 8: Beach Erosion and Seawalls
        $passage8 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 8,
            'content' => "The sea has been rising relative to the land for at least 100 years, geologists say. During that same period, the Atlantic Coast has eroded an average of 2 to 3 feet per year, the Gulf Coast even faster. Many engineers maintain that seawalls and replenished beaches are necessary to protect the nation's shoreline. Too many people live or vacation in Miami Beach, Atlantic City, or Martha's Vineyard to allow their roads and buildings to simply fall into the sea.

The problem with seawalls is that they simply don't work. One study has shown that, in fact, seawalls accelerate the erosion of beaches.

Faced with the loss of their beaches, other communities have tried a simple but expensive solution: replace the lost sand. These replenishment programs, however, are costly and of dubious value. Another study has shown that only 10% of replenished beaches lasted more than 5 years."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage8->id,
            'question_number' => 18,
            'question_text' => 'It can be inferred from the passage that the author ...',
            'option_a' => 'opposes the use of both seawalls and beach replenishment',
            'option_b' => 'believes beach replenishment would be more effective than seawalls',
            'option_c' => 'opposes any actions to protect the shoreline',
            'option_d' => 'denies that beach erosion is a problem',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage8->id,
            'question_number' => 19,
            'question_text' => 'Why does the author mention Miami Beach, Atlantic City, and Martha\'s Vineyard?',
            'option_a' => 'These are communities with seawalls.',
            'option_b' => 'These are communities that have implemented replenishment programs.',
            'option_c' => 'These are communities in danger of beach erosion.',
            'option_d' => 'These are communities which have lost roads and buildings to erosion.',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage8->id,
            'question_number' => 20,
            'question_text' => 'The author quotes the two studies in the passage in order to ...',
            'option_a' => 'suggest that the sea is not rising as fast as was originally believed',
            'option_b' => 'strengthen the engineers\' contention that seawalls and replenished beaches are necessary',
            'option_c' => 'propose two new solutions to beach erosion',
            'option_d' => 'support his own position',
            'correct_answer' => 'D'
        ]);

        $this->command->info('TOEFL Reading Meeting 7 seeded successfully!');
    }
}
