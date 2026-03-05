<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflMockupQuestion;

class ToeflMockupQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        ToeflMockupQuestion::truncate();

        // Part A - Questions 1-6 (from screenshot)
        
        // Question 1
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 1,
            'question_text' => 'What does the woman imply?',
            'option_a' => 'She lost the man\'s calculator.',
            'option_b' => 'She will lend the man her calculator.',
            'option_c' => 'The calculator may be under the man\'s book.',
            'option_d' => 'The man will not have time to find the calculator.',
            'correct_answer' => 'C',
            'audio_file' => null, // Will be added later
        ]);

        // Question 2
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 2,
            'question_text' => 'What does the man suggest the woman do?',
            'option_a' => 'Work in the astronomy department',
            'option_b' => 'Add another course next spring',
            'option_c' => 'Find a job for the summer',
            'option_d' => 'Take an astronomy course in the summer',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 3
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 3,
            'question_text' => 'What does the woman imply about the man?',
            'option_a' => 'He should work at home.',
            'option_b' => 'He can use the lab on the weekend.',
            'option_c' => 'He will have to repeat the experiment next week.',
            'option_d' => 'He forgot to return the key to security.',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 4
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 4,
            'question_text' => 'What does the man mean?',
            'option_a' => 'He and his parents plan to visit Japan.',
            'option_b' => 'He recently returned from Japan.',
            'option_c' => 'His sweatshirt came from Japan.',
            'option_d' => 'The weather can be very cold in some parts of Japan.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 5
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 5,
            'question_text' => 'What does the woman mean?',
            'option_a' => 'She will go to the restaurant with the man.',
            'option_b' => 'She will meet the man and his friends later in the evening.',
            'option_c' => 'She has already had dinner.',
            'option_d' => 'She will not change her original plans.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 6
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 6,
            'question_text' => 'What can be inferred about the man?',
            'option_a' => 'He will register for the conference.',
            'option_b' => 'He has nearly completed all his research.',
            'option_c' => 'He is not teaching any classes today.',
            'option_d' => 'He went to the wrong Web site.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);


        // Question 7
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 7,
            'question_text' => 'What does the woman imply?',
            'option_a' => 'The bicycle is too big for her.',
            'option_b' => 'She bought the bicycle at a good price.',
            'option_c' => 'She did not know about the store on Harrison Street.',
            'option_d' => 'She has not used her bike all summer.',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 8
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 8,
            'question_text' => 'What does the woman imply?',
            'option_a' => 'She did not buy the ticket.',
            'option_b' => 'The ticket was expensive.',
            'option_c' => 'She does not know how much the ticket cost.',
            'option_d' => 'There are still a few tickets left.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 9
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 9,
            'question_text' => 'What does the professor mean?',
            'option_a' => 'She will extend the deadline for the paper.',
            'option_b' => 'She has already made an exception for the student.',
            'option_c' => 'She does not accept late papers.',
            'option_d' => 'She cannot meet with the student in the library.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 10
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 10,
            'question_text' => 'What can be inferred about the man?',
            'option_a' => 'He lives far from the university.',
            'option_b' => 'He is moving next month.',
            'option_c' => 'He prefers living on campus.',
            'option_d' => 'He might be able to help the woman.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 11
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 11,
            'question_text' => 'What does the woman mean?',
            'option_a' => 'She agrees with the man.',
            'option_b' => 'She would like to see the movie a second time.',
            'option_c' => 'She has not seen the movie.',
            'option_d' => 'She does not understand the man\'s point.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 12
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 12,
            'question_text' => 'What does the man imply about his sister?',
            'option_a' => 'She delayed submitting her application.',
            'option_b' => 'She does not know if her application will be accepted.',
            'option_c' => 'She was glad to finally receive the letter.',
            'option_d' => 'She started her classes several weeks ago.',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);


        // Question 13
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 13,
            'question_text' => 'What does the woman imply?',
            'option_a' => 'She was also late for the meeting.',
            'option_b' => 'She is waiting for Mark to fix her car.',
            'option_c' => 'The meeting has not started yet.',
            'option_d' => 'The bus did not arrive on time.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 14
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 14,
            'question_text' => 'What does the man mean?',
            'option_a' => 'He does not like to wake up early in the morning.',
            'option_b' => 'The woman seems unusually sad.',
            'option_c' => 'There is no special reason for his good mood.',
            'option_d' => 'He was not in a good mood when he woke up.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 15
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 15,
            'question_text' => 'What does the woman mean?',
            'option_a' => 'She took a history class last year.',
            'option_b' => 'She does not trust the man\'s opinion.',
            'option_c' => 'She probably will not take any history classes.',
            'option_d' => 'She did not like her sociology professor.',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 16
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 16,
            'question_text' => 'What does the man mean?',
            'option_a' => 'He is very busy now.',
            'option_b' => 'He has to check his schedule.',
            'option_c' => 'He can meet the woman at six o\'clock.',
            'option_d' => 'He prefers to meet the woman some other time.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 17
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 17,
            'question_text' => 'What does the man imply?',
            'option_a' => 'The course is too difficult.',
            'option_b' => 'The professor changed his mind.',
            'option_c' => 'The final exam was cancelled.',
            'option_d' => 'The woman misunderstood the professor.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 18
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 18,
            'question_text' => 'What does the man mean?',
            'option_a' => 'The woman deserves the recognition.',
            'option_b' => 'The woman should tell her friends how she feels.',
            'option_c' => 'The woman\'s friends do not know about the scholarship.',
            'option_d' => 'The woman should apply for a scholarship.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 19
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 19,
            'question_text' => 'What will the woman probably do next?',
            'option_a' => 'Ask the man to help her figure out how to use her new computer',
            'option_b' => 'Let the man use her computer',
            'option_c' => 'Take her computer to a repair shop',
            'option_d' => 'Help the man fix his computer',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 20
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 20,
            'question_text' => 'What does the man mean?',
            'option_a' => 'He was at the health center earlier today.',
            'option_b' => 'He intends to get his blood pressure checked.',
            'option_c' => 'He does not have time to wait in line today.',
            'option_d' => 'He is not concerned about his blood pressure.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 21
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 21,
            'question_text' => 'What does the woman mean?',
            'option_a' => 'She plans to visit the man occasionally.',
            'option_b' => 'She hopes the man is able to find a job.',
            'option_c' => 'She would like to hear from the man.',
            'option_d' => 'She wants to know when the man will return.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 22
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 22,
            'question_text' => 'What does the woman imply?',
            'option_a' => 'She does not know where her pen is.',
            'option_b' => 'The man may borrow her pen.',
            'option_c' => 'She does not buy expensive pens.',
            'option_d' => 'The man has found her missing pen.',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 23
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 23,
            'question_text' => 'What can be inferred from this conversation?',
            'option_a' => 'The man\'s directions were not very good.',
            'option_b' => 'The woman forgot to take the man\'s directions with her.',
            'option_c' => 'The woman was not able to drive to the conference.',
            'option_d' => 'The conference was not very interesting.',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 24
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 24,
            'question_text' => 'What does the woman mean?',
            'option_a' => 'She will meet the man at the café.',
            'option_b' => 'She has not yet read the proposal.',
            'option_c' => 'The proposal has been approved.',
            'option_d' => 'The café does not need renovations.',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 25
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 25,
            'question_text' => 'What does the woman suggest the man do?',
            'option_a' => 'Buy a different kind of medicine',
            'option_b' => 'See a doctor',
            'option_c' => 'Take a second pill',
            'option_d' => 'Avoid taking any medication',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 26
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 26,
            'question_text' => 'What does the man imply about Phil?',
            'option_a' => 'He changed his plans about school.',
            'option_b' => 'His parents are coming out to visit him.',
            'option_c' => 'He was only out of school one semester.',
            'option_d' => 'He is going to take next semester off.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 27
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 27,
            'question_text' => 'What does the woman imply?',
            'option_a' => 'The man should follow the florist\'s advice.',
            'option_b' => 'The man should go to a different florist.',
            'option_c' => 'She bought flowers from the same florist.',
            'option_d' => 'Cutting flowers does not make them last longer.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 28
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 28,
            'question_text' => 'What does the man imply?',
            'option_a' => 'There was not enough time for questions.',
            'option_b' => 'The lecture topic was not interesting.',
            'option_c' => 'The speaker was difficult to hear.',
            'option_d' => 'The audience\'s questions were not interesting.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 29
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 29,
            'question_text' => 'What does the man mean?',
            'option_a' => 'He wants to give the woman more information.',
            'option_b' => 'He does not mind waiting to see the dentist.',
            'option_c' => 'He does not remember where he put the dentist\'s card.',
            'option_d' => 'He will take the woman to the dentist\'s office soon.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 30
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'A',
            'question_number' => 30,
            'question_text' => 'What does the woman imply?',
            'option_a' => 'She also has a presentation to do.',
            'option_b' => 'She enjoys speaking in front of other people.',
            'option_c' => 'The man\'s presentation will be a success.',
            'option_d' => 'The man should practice his presentation.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // ============================================
        // LISTENING SECTION - PART B (Questions 31-37)
        // ============================================

        // Question 31
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'B',
            'question_number' => 31,
            'question_text' => 'What are the students mainly discussing?',
            'option_a' => 'A swimming competition',
            'option_b' => 'A singing contest',
            'option_c' => 'The water temperature at the beach',
            'option_d' => 'The woman\'s schedule this semester',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 32
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'B',
            'question_number' => 32,
            'question_text' => 'What does the woman say about the winners of the competition?',
            'option_a' => 'They have won for the past three years.',
            'option_b' => 'They placed second last year.',
            'option_c' => 'They practiced for three months prior to the competition.',
            'option_d' => 'She thought they did not perform well.',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 33
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'B',
            'question_number' => 33,
            'question_text' => 'How did the man spend his weekend?',
            'option_a' => 'Studying in the library',
            'option_b' => 'Practicing his singing',
            'option_c' => 'Walking on the beach',
            'option_d' => 'Swimming in the ocean',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 34
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'B',
            'question_number' => 34,
            'question_text' => 'What does the woman say about her weekend schedule?',
            'option_a' => 'She spent many hours on a bus.',
            'option_b' => 'She was too busy to enjoy the beach.',
            'option_c' => 'She had plenty of time to study.',
            'option_d' => 'She did not have time to watch the competition.',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 35
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'B',
            'question_number' => 35,
            'question_text' => 'What is the conversation mainly about?',
            'option_a' => 'The first Japanese artist to open an art school in the United States',
            'option_b' => 'Two artists\' efforts to promote Japanese art in Europe',
            'option_c' => 'One artist\'s struggle to overcome financial difficulties',
            'option_d' => 'Influences on one artist\'s work',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 36
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'B',
            'question_number' => 36,
            'question_text' => 'What kind of work did Noguchi\'s father do?',
            'option_a' => 'He wrote poetry.',
            'option_b' => 'He built houses.',
            'option_c' => 'He designed gardens.',
            'option_d' => 'He created modern sculptures.',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 37
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'B',
            'question_number' => 37,
            'question_text' => 'According to the professor, what did Noguchi learn to do when he was a child in Japan?',
            'option_a' => 'Draw the human figure',
            'option_b' => 'See similarities between poetry and visual art',
            'option_c' => 'Appreciate and work with natural materials',
            'option_d' => 'Use money wisely',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // ============================================
        // LISTENING SECTION - PART C (Questions 38-50)
        // ============================================

        // Question 38
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 38,
            'question_text' => 'What is the main purpose of the lecture?',
            'option_a' => 'To analyze the importance of touch in marketing',
            'option_b' => 'To compare marketing strategies involving touch and smell',
            'option_c' => 'To explain why shoppers rely more on touch than on their other senses',
            'option_d' => 'To introduce a new way to conduct market research',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 39
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 39,
            'question_text' => 'According to the professor, what psychological feeling do shoppers tend to have when they touch an item of merchandise?',
            'option_a' => 'That they have more time to make a purchasing decision',
            'option_b' => 'That they are highly valued by the owner of the store',
            'option_c' => 'That the item they are touching is already theirs',
            'option_d' => 'That the price of the item is too high',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 40
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 40,
            'question_text' => 'What does the professor imply about marketers who sell items online?',
            'option_a' => 'Their customers like that the products are not touched by others.',
            'option_b' => 'They get more returned items than traditional stores do.',
            'option_c' => 'Their descriptions ought to help shoppers imagine how items feel.',
            'option_d' => 'Their photographs are often ineffective.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 41
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 41,
            'question_text' => 'What does the professor emphasize as an important characteristic of shoppers?',
            'option_a' => 'They are usually willing to pay more for items they can touch.',
            'option_b' => 'They are reluctant to buy items that were touched repeatedly by other shoppers.',
            'option_c' => 'They touch only items that they intend to buy.',
            'option_d' => 'They are less likely to touch items when the store owner is watching.',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 42
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 42,
            'question_text' => 'What is the main purpose of the talk?',
            'option_a' => 'To summarize the history of mathematics',
            'option_b' => 'To show how Mesopotamian science influenced Greek science',
            'option_c' => 'To discuss a mistaken historical interpretation',
            'option_d' => 'To explain why tablets are reliable historical records',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 43
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 43,
            'question_text' => 'What was on the Mesopotamian tablet mentioned in the talk?',
            'option_a' => 'Names of mathematicians',
            'option_b' => 'Mathematical calculations',
            'option_c' => 'Measurements of buildings',
            'option_d' => 'Measurements of various shapes',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 44
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 44,
            'question_text' => 'According to the professor, what had been assumed about the Mesopotamians?',
            'option_a' => 'All records of their mathematics had been lost.',
            'option_b' => 'They created various types of measuring devices.',
            'option_c' => 'They did not use tablets to record information.',
            'option_d' => 'They could calculate measurements of triangles.',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 45
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 45,
            'question_text' => 'According to the professor, how was the tablet most likely used by the Mesopotamians?',
            'option_a' => 'As a math exercise sheet',
            'option_b' => 'As a record of business transactions',
            'option_c' => 'As a geometry textbook',
            'option_d' => 'As a plan for a new building',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 46
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 46,
            'question_text' => 'What does the professor imply about the ancient Greeks?',
            'option_a' => 'They learned geometry from Mesopotamian tablets.',
            'option_b' => 'They were less advanced in mathematics than the Mesopotamians.',
            'option_c' => 'They improved the quality of stone tablets.',
            'option_d' => 'They knew how to measure angles.',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 47
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 47,
            'question_text' => 'What is the talk mainly about?',
            'option_a' => 'How the age of a fossil is determined',
            'option_b' => 'How fossilized impressions were made on the seafloor',
            'option_c' => 'Techniques for excavating fossils from the sea',
            'option_d' => 'Recently discovered fossilized footprints',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 48
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 48,
            'question_text' => 'According to the professor, what question does the discovery in Canada help answer?',
            'option_a' => 'When animals first emerged from the sea',
            'option_b' => 'Where fossils are most easily found',
            'option_c' => 'How footprints on the seafloor are preserved',
            'option_d' => 'Why some animals became extinct',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 49
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 49,
            'question_text' => 'Why does the professor mention stonecutters?',
            'option_a' => 'To illustrate the variety of stone found in Canada',
            'option_b' => 'To show that the fossils were found by luck',
            'option_c' => 'To explain why sandstone often contains fossils',
            'option_d' => 'To tell why fossils are sometimes damaged',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 50
        ToeflMockupQuestion::create([
            'section' => 'listening',
            'part' => 'C',
            'question_number' => 50,
            'question_text' => 'What evidence is given to show whether the footprints were made by animals on land or underwater?',
            'option_a' => 'The hardness of the sandstone',
            'option_b' => 'The depth of the footprints',
            'option_c' => 'The type of animal that made the footprints',
            'option_d' => 'The location of the rock layer',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // ============================================
        // SECTION 2: STRUCTURE AND WRITTEN EXPRESSION
        // ============================================

        // Structure Questions 1-15

        // Question 1
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 1,
            'question_text' => '______ of classical ballet in the United States began around 1830.',
            'option_a' => 'To teach',
            'option_b' => 'Is teaching',
            'option_c' => 'It was taught',
            'option_d' => 'The teaching',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 2
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 2,
            'question_text' => 'Mason bees are solitary bees, which means ______ in colonies like honeybees or bumblebees.',
            'option_a' => 'do not live',
            'option_b' => 'when they do not live',
            'option_c' => 'that they do not live',
            'option_d' => 'that do not live',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 3
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 3,
            'question_text' => 'Long before the advent of written literature, ______ their myths and stories in oral poems told by successive generations.',
            'option_a' => 'people recorded',
            'option_b' => 'recording people',
            'option_c' => 'people\'s recordings',
            'option_d' => 'people who recorded',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 4
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 4,
            'question_text' => 'Comparative anatomy is ______ classification of both plants and animals.',
            'option_a' => 'the basis for',
            'option_b' => 'for basics',
            'option_c' => 'the basis that',
            'option_d' => 'the basically',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 5
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 5,
            'question_text' => 'Although legend has it that the Pilgrims first set foot in America on Plymouth Rock in 1620, ______ documentary evidence confirming this.',
            'option_a' => 'no',
            'option_b' => 'still is no',
            'option_c' => 'there is no',
            'option_d' => 'but no',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 6
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 6,
            'question_text' => 'Despite its fishlike form, the whale is ______ and will drown if submerged too long.',
            'option_a' => 'an animal breathes air that',
            'option_b' => 'an animal that breathes air',
            'option_c' => 'an animal breathes air',
            'option_d' => 'that an animal breathes air',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 7
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 7,
            'question_text' => 'Clouds ______ in warm air rises, cools, and condenses.',
            'option_a' => 'when form water vapor',
            'option_b' => 'form when water vapor',
            'option_c' => 'form vapor water when',
            'option_d' => 'vapor form when water',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 8
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 8,
            'question_text' => 'Portland, ______, is located primarily on two hilly peninsulas overlooking Casco Bay and its many islands.',
            'option_a' => 'which Maine\'s largest city',
            'option_b' => 'Maine\'s largest city where',
            'option_c' => 'is Maine\'s largest city',
            'option_d' => 'Maine\'s largest city',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 9
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 9,
            'question_text' => 'Mars, the so-called red planet, is actually colored red by iron oxide and other impurities ______ the whole surface.',
            'option_a' => 'that cover',
            'option_b' => 'in which are covered',
            'option_c' => 'that they cover',
            'option_d' => 'and covered',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 10
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 10,
            'question_text' => 'The 1903 film The Great Train Robbery was the first significant film in which the classic western story\'s formula of crime and retribution ______.',
            'option_a' => 'was used',
            'option_b' => 'to be used',
            'option_c' => 'used',
            'option_d' => 'had used',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 11
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 11,
            'question_text' => 'When played in certain ways, the bassoon can produce comical sounds, ______ it is sometimes referred to as the clown of the orchestra.',
            'option_a' => 'or',
            'option_b' => 'that',
            'option_c' => 'so',
            'option_d' => 'whether',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 12
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 12,
            'question_text' => 'In modern societies, ______ authorized body such as a legislature or a court makes the law.',
            'option_a' => 'some',
            'option_b' => 'some of',
            'option_c' => 'some the',
            'option_d' => 'for some',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 13
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 13,
            'question_text' => 'The sense of smell functions chemically, ______ the sense of taste, but it is 10,000 times more sensitive.',
            'option_a' => 'as does',
            'option_b' => 'so have',
            'option_c' => 'which as',
            'option_d' => 'by which',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 14
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 14,
            'question_text' => '______ primarily from plant oils, perfumes were used in ancient times as incense in religious rites, in medicines, and later for adornment.',
            'option_a' => 'Made them',
            'option_b' => 'They made',
            'option_c' => 'Made',
            'option_d' => 'By making',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 15
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Structure',
            'question_number' => 15,
            'question_text' => 'Boise became ______ of the state of Idaho in 1864.',
            'option_a' => 'as the capital',
            'option_b' => 'the capital',
            'option_c' => 'to be the capital',
            'option_d' => 'the capital was',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Written Expression Questions 16-40

        // Question 16
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 16,
            'question_text' => 'Soybeans contain a rich concentrations of phytoestrogens, estrogenlike molecules derived from plants.',
            'option_a' => 'rich',
            'option_b' => 'concentrations',
            'option_c' => 'derived',
            'option_d' => 'plants',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 17
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 17,
            'question_text' => 'The original Welland Canal, opened which in 1829, was neither deep enough nor wide enough for modern ships.',
            'option_a' => 'opened which',
            'option_b' => 'was neither',
            'option_c' => 'for modern',
            'option_d' => 'ships',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 18
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 18,
            'question_text' => 'A lubricant minimizes the introduction of dirt, moisture, or other foreign materials between sliding surfaces, eliminates wear by keeping the surfaces apart, and prevention corrosion.',
            'option_a' => 'introduction',
            'option_b' => 'foreign',
            'option_c' => 'between',
            'option_d' => 'prevention',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 19
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 19,
            'question_text' => 'There are thousands kinds of inks used both in the printing industry and in the manufacture of ballpoint and fountain pens for writing.',
            'option_a' => 'thousands kinds',
            'option_b' => 'used both',
            'option_c' => 'printing',
            'option_d' => 'writing',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 20
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 20,
            'question_text' => 'A gene is a biological unit of information who directs the activity of a cell or organism during its lifetime.',
            'option_a' => 'biological',
            'option_b' => 'who',
            'option_c' => 'a cell',
            'option_d' => 'its',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 21
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 21,
            'question_text' => 'Like landscapes in miniature, gardens are places to grow plants for pleasure and to provide beauty and relaxed.',
            'option_a' => 'Like landscapes',
            'option_b' => 'for pleasure',
            'option_c' => 'to provide',
            'option_d' => 'relaxed',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 22
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 22,
            'question_text' => 'Hurricanes consist at high-velocity winds blowing circularly around a low-pressure center known as the eye of the storm.',
            'option_a' => 'winds',
            'option_b' => 'blowing',
            'option_c' => 'consist',
            'option_d' => 'known',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 23
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 23,
            'question_text' => 'One of the most significance political movements since the Second World War ended has been the breaking up of former colonial empires into independent nations.',
            'option_a' => 'significance',
            'option_b' => 'since',
            'option_c' => 'breaking up',
            'option_d' => 'independent nations',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 24
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 24,
            'question_text' => 'Radar can determine the direction, distance, height, and speed of objects that are too much far away for the human eye to see.',
            'option_a' => 'can determine',
            'option_b' => 'height',
            'option_c' => 'too much',
            'option_d' => 'away',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 25
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 25,
            'question_text' => 'Establishing outside Minneapolis, Minnesota, in 1976, the Minnesota Valley National Wildlife Refuge contains more than 9,000 acres of forests, prairies, marshes, and lakes.',
            'option_a' => 'Establishing',
            'option_b' => 'contains',
            'option_c' => 'more than',
            'option_d' => 'lakes',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 26
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 26,
            'question_text' => 'Most animals have salivary glands what resemble those in humans.',
            'option_a' => 'Most',
            'option_b' => 'have',
            'option_c' => 'what',
            'option_d' => 'those',
            'correct_answer' => 'C',
            'audio_file' => null,
        ]);

        // Question 27
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 27,
            'question_text' => 'Used for making pottery, clay has two characteristics distinctive: it can be molded and it can be baked to form a brittle but otherwise durable material.',
            'option_a' => 'for making',
            'option_b' => 'characteristics distinctive',
            'option_c' => 'to form',
            'option_d' => 'otherwise',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        // Question 28
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 28,
            'question_text' => 'The novels of Amy Tan depict of tension between mothers and daughters as well as conflicts experienced by many Chinese immigrants to the United States.',
            'option_a' => 'depict of',
            'option_b' => 'as well as',
            'option_c' => 'experienced by',
            'option_d' => 'to',
            'correct_answer' => 'A',
            'audio_file' => null,
        ]);

        // Question 29
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 29,
            'question_text' => 'The symptoms of pneumonia, a lung infection, include high fever, chest pain, breathing difficult, and coughing.',
            'option_a' => 'of',
            'option_b' => 'a',
            'option_c' => 'include',
            'option_d' => 'difficult',
            'correct_answer' => 'D',
            'audio_file' => null,
        ]);

        // Question 30
        ToeflMockupQuestion::create([
            'section' => 'structure',
            'part' => 'Written Expression',
            'question_number' => 30,
            'question_text' => 'A basic premise of humanism is that people are rational beings who possesses the capacity for truth and goodness.',
            'option_a' => 'that',
            'option_b' => 'possesses',
            'option_c' => 'for',
            'option_d' => 'goodness',
            'correct_answer' => 'B',
            'audio_file' => null,
        ]);

        echo "TOEFL Mock Up Test - Section 1 Listening (50 questions: Part A 30, Part B 7, Part C 13) and Section 2 Structure (30 questions) seeded successfully!\n";
    }
}
