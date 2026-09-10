<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsGeneralReadingSeeder extends Seeder
{
    public function run(): void
    {

        // === GT TEST 1 (material_id = 101) ===
        $matId = 101;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-6',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "You will receive a card telling you if an item has been left with a neighbour.", "text": "You will receive a card telling you if an item has been left with a neighbour.", "correct_answer": "NOT GIVEN"}, {"id": "2", "label": "It may be quicker to get a refund than a replacement for a non-delivered item.", "text": "It may be quicker to get a refund than a replacement for a non-delivered item.", "correct_answer": "NOT GIVEN"}, {"id": "3", "label": "You are entitled to a refund if the item fails to arrive by a certain time.", "text": "You are entitled to a refund if the item fails to arrive by a certain time.", "correct_answer": "TRUE"}, {"id": "4", "label": "There is a time limit when using the \\u2018chargeback\\u2019 scheme for a debit card payment.", "text": "There is a time limit when using the \\u2018chargeback\\u2019 scheme for a debit card payment.", "correct_answer": "TRUE"}, {"id": "5", "label": "You can use the \\u2018chargeback\\u2019 scheme for a credit card payment of more than \\u00a3100.", "text": "You can use the \\u2018chargeback\\u2019 scheme for a credit card payment of more than \\u00a3100.", "correct_answer": "FALSE"}, {"id": "6", "label": "PayPal\\u2019s online resolution centre has a good reputation for efficiency. Read the text below and answer Questions 7-14. Rice cookers What\\u2019s the best rice cooker for you?", "text": "PayPal\\u2019s online resolution centre has a good reputation for efficiency. Read the text below and answer Questions 7-14. Rice cookers What\\u2019s the best rice cooker for you?", "correct_answer": "NOT GIVEN"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 7,
            'question_text' => 'Questions 7-14',
            'type' => 'summary_completion',
            'options' => '{"A": "selection of recipes is provided with the cooker."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 6, "sub_questions": [{"id": "7", "label": "The handles at the side are hard to use.", "text": "The handles at the side are hard to use.", "correct_answer": "D"}, {"id": "8", "label": "It cooks brown rice without making a mess.", "text": "It cooks brown rice without making a mess.", "correct_answer": "E"}, {"id": "9", "label": "It automatically switches setting to keep to rice warm when cooked.", "text": "It automatically switches setting to keep to rice warm when cooked.", "correct_answer": "B"}, {"id": "10", "label": "It\\u2019s difficult to get the removable top really clean.", "text": "It\\u2019s difficult to get the removable top really clean.", "correct_answer": "A"}, {"id": "11", "label": "Question 11", "text": "Question 11", "correct_answer": "D"}, {"id": "12", "label": "It has a handle at the top for carrying the cooker safely.", "text": "It has a handle at the top for carrying the cooker safely.", "correct_answer": "B"}, {"id": "13", "label": "The outside of the cooker doesn\\u2019t get too hot.", "text": "The outside of the cooker doesn\\u2019t get too hot.", "correct_answer": "E"}, {"id": "14", "label": "You can put the pot in the dishwasher. Advertisements", "text": "You can put the pot in the dishwasher. Advertisements", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-22',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u25cf most falls are from ladders and roofs \\u25cf falls cost $24 million per year \\u25cf the majority of falls occur on", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u25cf most falls are from ladders and roofs \\u25cf falls cost $24 million per year \\u25cf the majority of falls occur on", "correct_answer": "3 / three metres / meters"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Hazard identification should be carried out \\u25cf before the work starts \\u25cf when conditions such as the weather or worker numbers change Controls \\u25cf 17 \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. the hazard at the planning stage before the work begins if possible \\u25cf prevent a fall by using edge protection, e.g. scaffolding or", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Hazard identification should be carried out \\u25cf before the work starts \\u25cf when conditions such as the weather or worker numbers change Controls \\u25cf 17 \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. the hazard at the planning stage before the work begins if possible \\u25cf prevent a fall by using edge protection, e.g. scaffolding or", "correct_answer": "residential building sites"}, {"id": "17", "label": "Question 17", "text": "Question 17", "correct_answer": "eliminate"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u25cf reduce the likelihood of injury, e.g. by using", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u25cf reduce the likelihood of injury, e.g. by using", "correct_answer": "platforms"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026.. Ladders \\u25cf these should only be used for", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026.. Ladders \\u25cf these should only be used for", "correct_answer": "safety nets"}, {"id": "20", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 which does not take a long time \\u25cf training should be provided in their", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 which does not take a long time \\u25cf training should be provided in their", "correct_answer": "work"}, {"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026.. and use \\u25cf regular", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026.. and use \\u25cf regular", "correct_answer": "selection"}, {"id": "22", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of ladders is required Read the text below and answer Questions 23-27 Maternity Allowance for working women You can claim Maternity Allowance once you\\u2019ve been pregnant for 26 weeks. Payments start 11 weeks before the date on which your baby is due. The amount you can get depends on your eligibility. You could get either: \\u25cf \\u00a3140.98 a week or 90% of your average weekly earnings (whichever is less) for 39 weeks \\u25cf \\u00a327 a week for 14 weeks Maternity Allowance for 39 weeks You might get Maternity Allowance for 39 weeks if one of the following applies: \\u25cf you\\u2019re employed \\u25cf you\\u2019re self-employed and pay Class 2 National Insurance (including voluntary National Insurance) \\u25cf you\\u2019ve recently stopped working You may still qualify even if you\\u2019ve recently stopped working. It doesn\\u2019t matter if you had different jobs, or periods when you were unemployed. Maternity Allowance for 14 weeks You might get Maternity Allowance for 14 weeks if for at least 26 weeks in the 66 weeks before your baby is due: \\u25cf you were married or in a civil partnership \\u25cf you were not employed or self-employed \\u25cf you took part in the business of your self-employed spouse or civil partner How to claim You\\u2019ll need an MA1 claim form, available online. You can print this and fill it in, or fill it in online. You also need to provide a payslip or a Certificate of Small Earnings Exemption as proof of your income, and proof of the baby\\u2019s due date, such as a doctor\\u2019s letter. You should get a decision on your claim within 24 working days. You should report any changes to your circumstances, for example, if you go back to work, to your local Jobcentre Plus as they can affect how much allowance you get.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of ladders is required Read the text below and answer Questions 23-27 Maternity Allowance for working women You can claim Maternity Allowance once you\\u2019ve been pregnant for 26 weeks. Payments start 11 weeks before the date on which your baby is due. The amount you can get depends on your eligibility. You could get either: \\u25cf \\u00a3140.98 a week or 90% of your average weekly earnings (whichever is less) for 39 weeks \\u25cf \\u00a327 a week for 14 weeks Maternity Allowance for 39 weeks You might get Maternity Allowance for 39 weeks if one of the following applies: \\u25cf you\\u2019re employed \\u25cf you\\u2019re self-employed and pay Class 2 National Insurance (including voluntary National Insurance) \\u25cf you\\u2019ve recently stopped working You may still qualify even if you\\u2019ve recently stopped working. It doesn\\u2019t matter if you had different jobs, or periods when you were unemployed. Maternity Allowance for 14 weeks You might get Maternity Allowance for 14 weeks if for at least 26 weeks in the 66 weeks before your baby is due: \\u25cf you were married or in a civil partnership \\u25cf you were not employed or self-employed \\u25cf you took part in the business of your self-employed spouse or civil partner How to claim You\\u2019ll need an MA1 claim form, available online. You can print this and fill it in, or fill it in online. You also need to provide a payslip or a Certificate of Small Earnings Exemption as proof of your income, and proof of the baby\\u2019s due date, such as a doctor\\u2019s letter. You should get a decision on your claim within 24 working days. You should report any changes to your circumstances, for example, if you go back to work, to your local Jobcentre Plus as they can affect how much allowance you get.", "correct_answer": "inspection"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 23,
            'question_text' => 'Questions 23-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 22, "sub_questions": [{"id": "23", "label": "The maximum amount of money a woman can get each week is \\u00a3\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "The maximum amount of money a woman can get each week is \\u00a3\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "140.98"}, {"id": "24", "label": "Being \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. for a time does not necessarily mean that a woman will not be eligible for Maternity Allowance.", "text": "Being \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. for a time does not necessarily mean that a woman will not be eligible for Maternity Allowance.", "correct_answer": "unemployed"}, {"id": "25", "label": "In order to claim, a woman must send a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. or a Small Earnings Exemption Certificate as evidence of her income.", "text": "In order to claim, a woman must send a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. or a Small Earnings Exemption Certificate as evidence of her income.", "correct_answer": "payslip"}, {"id": "26", "label": "In order to claim, a woman may need to provide a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. as evidence of the due date.", "text": "In order to claim, a woman may need to provide a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. as evidence of the due date.", "correct_answer": "doctor\\u2019s letter"}, {"id": "27", "label": "Payment may be affected by differences in someone\\u2019s \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 , such as a return to work, and the local Jobcentre Plus must be informed. Advertisements", "text": "Payment may be affected by differences in someone\\u2019s \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 , such as a return to work, and the local Jobcentre Plus must be informed. Advertisements", "correct_answer": "circumstances"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-31',
            'type' => 'multiple_choice',
            'options' => '{"A": "rocker needed more than one miner to operate it."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "The writer suggests that Marshall\\u2019s discovery came at a good time for the US because A the Mexican-American War was ending so there were men needing work. B his expertise in water power would be useful in gold mining. C the population of California had already begun to increase rapidly. D the region was about to come under the control of the US.", "text": "The writer suggests that Marshall\\u2019s discovery came at a good time for the US because A the Mexican-American War was ending so there were men needing work. B his expertise in water power would be useful in gold mining. C the population of California had already begun to increase rapidly. D the region was about to come under the control of the US.", "correct_answer": "D"}, {"id": "29", "label": "What was the reaction in 1848 to the news of the discovery of gold? A The press played a large part in convincing the public of the riches available. B Many men in San Francisco left immediately to check it out for themselves. C People needed to see physical evidence before they took it seriously. D Men in other mines in the US were among the first to respond to it.", "text": "What was the reaction in 1848 to the news of the discovery of gold? A The press played a large part in convincing the public of the riches available. B Many men in San Francisco left immediately to check it out for themselves. C People needed to see physical evidence before they took it seriously. D Men in other mines in the US were among the first to respond to it.", "correct_answer": "C"}, {"id": "30", "label": "What was the result of thousands of people moving to California? A San Francisco could not cope with the influx of people from around the world. B Many miners got more money than they could ever have earned at home. C Some of those who stayed behind had to take on unexpected roles. D New towns were established which became good places to live.", "text": "What was the result of thousands of people moving to California? A San Francisco could not cope with the influx of people from around the world. B Many miners got more money than they could ever have earned at home. C Some of those who stayed behind had to take on unexpected roles. D New towns were established which became good places to live.", "correct_answer": "C"}, {"id": "31", "label": "What does the writer say about using pans and rockers to find gold? A Both methods required the addition of mercury. B", "text": "What does the writer say about using pans and rockers to find gold? A Both methods required the addition of mercury. B", "correct_answer": "D"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 32,
            'question_text' => 'Questions 32-36',
            'type' => 'matching_paragraph_information',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 31, "sub_questions": [{"id": "32", "label": "a reference to ways of making money in California other than mining for gold", "text": "a reference to ways of making money in California other than mining for gold", "correct_answer": "C"}, {"id": "33", "label": "a suggestion that the gold that was found did not often compensate for the hard work undertaken", "text": "a suggestion that the gold that was found did not often compensate for the hard work undertaken", "correct_answer": "F"}, {"id": "34", "label": "a mention of an individual who convinced many of the existence of gold in California.", "text": "a mention of an individual who convinced many of the existence of gold in California.", "correct_answer": "B"}, {"id": "35", "label": "details of the pre-Gold Rush population of California", "text": "details of the pre-Gold Rush population of California", "correct_answer": "A"}, {"id": "36", "label": "a contrast between shrinking revenue and increasing population", "text": "a contrast between shrinking revenue and increasing population", "correct_answer": "G"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 37,
            'question_text' => 'Questions 37-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 36, "sub_questions": [{"id": "37", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. out of a river and hoping it might contain gold. Small amounts were put in a pan with water. The pan was spun round, causing the liquid and less heavy contents of the pan to come out. Gold dust, which weighed more, remained in the pan or, if the miners were very lucky, there might even be some", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. out of a river and hoping it might contain gold. Small amounts were put in a pan with water. The pan was spun round, causing the liquid and less heavy contents of the pan to come out. Gold dust, which weighed more, remained in the pan or, if the miners were very lucky, there might even be some", "correct_answer": "gravel"}, {"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. too. It was, however, a very laborious method. The rocker was also used. A miner would put some earth and rock into the higher end, together with some water. He would then shake the rocker. Larger stones stuck in the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. too. It was, however, a very laborious method. The rocker was also used. A miner would put some earth and rock into the higher end, together with some water. He would then shake the rocker. Larger stones stuck in the", "correct_answer": "nuggets"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. , while gold dropped to the bottom. Unfortunately, the rocker was not designed to catch what was called flour. However, a process was introduced involving", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. , while gold dropped to the bottom. Unfortunately, the rocker was not designed to catch what was called flour. However, a process was introduced involving", "correct_answer": "sieve"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to ensure no gold was washed out in the water. IELTS General Reading Tests IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to ensure no gold was washed out in the water. IELTS General Reading Tests IELTS General", "correct_answer": "mercury"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 2 (material_id = 102) ===
        $matId = 102;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-6',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "There is an extra charge for locks and keys.", "text": "There is an extra charge for locks and keys.", "correct_answer": "FALSE"}, {"id": "2", "label": "It is possible to arrange to share a storage unit with someone else.", "text": "It is possible to arrange to share a storage unit with someone else.", "correct_answer": "NOT GIVEN"}, {"id": "3", "label": "You can pick up your property from the storage unit during the night-time.", "text": "You can pick up your property from the storage unit during the night-time.", "correct_answer": "TRUE"}, {"id": "4", "label": "You can drive your vehicle right next to your storage unit.", "text": "You can drive your vehicle right next to your storage unit.", "correct_answer": "TRUE"}, {"id": "5", "label": "Students\\u2019 possessions can only be stored during vacation periods.", "text": "Students\\u2019 possessions can only be stored during vacation periods.", "correct_answer": "FALSE"}, {"id": "6", "label": "The storage company will collect and deliver students\\u2019 property. Read the text below and answer Questions 7-14. Local museums", "text": "The storage company will collect and deliver students\\u2019 property. Read the text below and answer Questions 7-14. Local museums", "correct_answer": "FALSE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 7,
            'question_text' => 'Questions 7-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 6, "sub_questions": [{"id": "7", "label": "There are exhibits related to the history of agriculture in the region.", "text": "There are exhibits related to the history of agriculture in the region.", "correct_answer": "C"}, {"id": "8", "label": "Equipment for putting out fires used to be kept in this building.", "text": "Equipment for putting out fires used to be kept in this building.", "correct_answer": "A"}, {"id": "9", "label": "You can find information on the rise of one type of transport.", "text": "You can find information on the rise of one type of transport.", "correct_answer": "C"}, {"id": "10", "label": "There are things to see both inside and outside.", "text": "There are things to see both inside and outside.", "correct_answer": "B"}, {"id": "11", "label": "It is possible to obtain copies of old pictures and documents.", "text": "It is possible to obtain copies of old pictures and documents.", "correct_answer": "C"}, {"id": "12", "label": "On certain days you can see an original work by a writer of fiction.", "text": "On certain days you can see an original work by a writer of fiction.", "correct_answer": "E"}, {"id": "13", "label": "Someone who was interested in environmental matters lived here for a time.", "text": "Someone who was interested in environmental matters lived here for a time.", "correct_answer": "B"}, {"id": "14", "label": "This museum has an exhibit related to a heroic achievement. Advertisements", "text": "This museum has an exhibit related to a heroic achievement. Advertisements", "correct_answer": "D"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'yes_no_not_given',
            'options' => '{"YES": "YES", "NO": "NO", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026. , mould, bacteria, algae can lead to disease and death use protective clothing and equipment Confined spaces Contaminants e.g. gases, vapours and dusts injury from fire or explosion follow Safe Work code of practice high concentrations of harmful airborne contaminants e.g. carbon monoxide", "text": "\\u2026\\u2026\\u2026\\u2026. , mould, bacteria, algae can lead to disease and death use protective clothing and equipment Confined spaces Contaminants e.g. gases, vapours and dusts injury from fire or explosion follow Safe Work code of practice high concentrations of harmful airborne contaminants e.g. carbon monoxide", "correct_answer": "sewage"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026.. follow Safe Work code of practice water", "text": "\\u2026\\u2026\\u2026\\u2026.. follow Safe Work code of practice water", "correct_answer": "poisoning"}, {"id": "17", "label": "\\u2026\\u2026\\u2026\\u2026. cut off water sources Electricity metal pipes which are conductive death from electrocution - use insulated", "text": "\\u2026\\u2026\\u2026\\u2026. cut off water sources Electricity metal pipes which are conductive death from electrocution - use insulated", "correct_answer": "drowning"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026.. and appropriate equipment - ensure equipment has", "text": "\\u2026\\u2026\\u2026\\u2026.. and appropriate equipment - ensure equipment has", "correct_answer": "gloves"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026 on to show it is safe - make sure electricity has been", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026 on to show it is safe - make sure electricity has been", "correct_answer": "tags"}, {"id": "20", "label": "\\u2026\\u2026\\u2026\\u2026. Read the text below and answer Questions 21-27 How to manage flexible working with your employees There is no denying that flexible working has grown enormously in recent years. It does, however, require careful management. When it comes to implementing flexible working one word is key: trust. All flexible workers should be trusted and given well-defined objectives from the start and their contribution should be assessed according to their output, as opposed to the time they spend on the job. It can be a big step to implement such as change in your business, so if you are slightly cautious then I recommend perhaps setting up an end-of-the-day review to see how much progress has been made. As all parties find their feet with the new set-up, this contact can slowly be reduced. In my eyes, it is also vital that there is shared calendar access for everyone so that people can see where their colleagues are each day. This way if they need to catch up with someone they can plan when to do so. Technology now exists to enable employees to stay in touch with other members of staff and external partners. iMeet, for example, is a tool which allows all forms of collaboration for remote working, from video conferencing, live chat and file sharing to screen sharing. The new breed of worker is therefore fully equipped to work productively away from the office, and can still feel like they\\u2019re in the same room as others when necessary. In my experience, employees are often more productive working at home as they can work the exact hours they want and do not have to cope with distraction caused by other employees. Being outside the confines of the office walls also appears to foster creativity. In addition, we find staff are more motivated as they have a better work-life balance. In terms of the business, we find this helps with top talent recruitment and staff retention, and a happy workforce is a more successful one.", "text": "\\u2026\\u2026\\u2026\\u2026. Read the text below and answer Questions 21-27 How to manage flexible working with your employees There is no denying that flexible working has grown enormously in recent years. It does, however, require careful management. When it comes to implementing flexible working one word is key: trust. All flexible workers should be trusted and given well-defined objectives from the start and their contribution should be assessed according to their output, as opposed to the time they spend on the job. It can be a big step to implement such as change in your business, so if you are slightly cautious then I recommend perhaps setting up an end-of-the-day review to see how much progress has been made. As all parties find their feet with the new set-up, this contact can slowly be reduced. In my eyes, it is also vital that there is shared calendar access for everyone so that people can see where their colleagues are each day. This way if they need to catch up with someone they can plan when to do so. Technology now exists to enable employees to stay in touch with other members of staff and external partners. iMeet, for example, is a tool which allows all forms of collaboration for remote working, from video conferencing, live chat and file sharing to screen sharing. The new breed of worker is therefore fully equipped to work productively away from the office, and can still feel like they\\u2019re in the same room as others when necessary. In my experience, employees are often more productive working at home as they can work the exact hours they want and do not have to cope with distraction caused by other employees. Being outside the confines of the office walls also appears to foster creativity. In addition, we find staff are more motivated as they have a better work-life balance. In terms of the business, we find this helps with top talent recruitment and staff retention, and a happy workforce is a more successful one.", "correct_answer": "disconnected"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026. \\u25cf base measurements of performance on their output \\u25cf initially, have a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026. \\u25cf base measurements of performance on their output \\u25cf initially, have a", "correct_answer": "objectives"}, {"id": "22", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026.. of progress each day \\u25cf make sure a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026.. of progress each day \\u25cf make sure a", "correct_answer": "review"}, {"id": "23", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Is accessible to give details of colleague locations. \\u25cf use a program such as iMeet to encourage different types of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Is accessible to give details of colleague locations. \\u25cf use a program such as iMeet to encourage different types of", "correct_answer": "calendar"}, {"id": "24", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. between workers Benefits of flexibility \\u25cf greater productivity \\u25cf less", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. between workers Benefits of flexibility \\u25cf greater productivity \\u25cf less", "correct_answer": "collaboration"}, {"id": "25", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 from colleagues \\u25cf increase in", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 from colleagues \\u25cf increase in", "correct_answer": "distraction"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u25cf more motivated staff \\u25cf greater success for the company with staff recruitment and", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u25cf more motivated staff \\u25cf greater success for the company with staff recruitment and", "correct_answer": "creativity"}, {"id": "27", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 Advertisements", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 Advertisements", "correct_answer": "retention"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-33',
            'type' => 'matching_headings',
            'options' => '{"A": "short but intensive investigation with longer-term follow-up"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Section A", "text": "Section A", "correct_answer": "iv"}, {"id": "29", "label": "Section B", "text": "Section B", "correct_answer": "vi"}, {"id": "30", "label": "Section C", "text": "Section C", "correct_answer": "vii"}, {"id": "31", "label": "Section D", "text": "Section D", "correct_answer": "i"}, {"id": "32", "label": "Section E", "text": "Section E", "correct_answer": "v"}, {"id": "33", "label": "Section F Preventing the theft of turtle eggs Conservationists and law enforcement have struggled to prevent wildlife trafficking. But could some plastic eggs and GPS trackers change the game? A Humans have been eating sea turtle eggs (and killing adult turtles for meat) for millennia. However, as human populations exploded and as sea turtles began to confront additional threats such as intensive fishing, beach development and climate change, sea turtle populations declined precipitously. Today, all but one of the world\\u2019s seven species of sea turtles are considered threatened according to the IUCN* Red List. And the one that\\u2019s not \\u2013 the flatback turtle \\u2013 is listed as data deficient, which means scientists simply don\\u2019t know how it\\u2019s doing. B One major problem is that every year millions of sea turtle eggs are illegally taken by poachers for sale on the black market. The situation is particularly serious in Nicaragua, in Central America, which is home to four sea turtle species. Kim Williams-Guillen, who works for conservation body Paso Pacifico, described the poaching of sea turtle nests on the beaches of Nicaragua as \\u2018uncontrolled, unregulated, extensive and contested\\u2019. Even the best-protected beaches are plundered to some extent and it\\u2019s not uncommon to see poachers digging up nests just meters from tourists watching sea turtles laying their clutch at night, she said. This poaching becomes particularly frenzied during the arribadas \\u2013 mass laying events where thousands of turtles nest on the same beach for a single night in a biological strategy to overwhelm natural predators. C \\u2018Even with armed guards, the numbers of poachers overwhelm military personnel by ten to twenty to one,\\u2019 Williams-Guillen said. \\u2018Although many poachers are locals with limited resources, during these arribadas there are influxes of gangs of poachers from larger cities outside local communities. These are not just local poor people without other options.\\u2019 But to protect the country\\u2019s sea turtles, Williams-Guillen said conservationists shouldn\\u2019t just depend on catching low-level operators. \\u2018If one poacher decides to stop, another one will just step into his place\\u2026 we need to know more about the middlemen and people higher up in the distribution chain,\\u2019 she said. D Paso Pacifico\\u2019s solution is the creation of high-tech sea turtle eggs: fake eggs convincingly crafted to look like the real thing, but which contain GPS tracking devices. These have the potential to reveal the destination markets for trafficked sea turtle eggs. Making convincing sea turtle eggs is not easy, and Paso Pacifico is still working on perfecting a prototype. In particular, it\\u2019s proving quite problematic to create the right texture, since sea turtle eggs are not covered in a hard shell like those of birds, but are quite flexible. So Paso Pacifico brought in Lauren Wilde, a special effects artist in the US, to create a convincing outer shell. First, Wilde had to get her hands on the real thing. Since it\\u2019s illegal to send sea turtle eggs over the border, Wilde is using land turtle eggs from California. \\u2018It was really eye opening and important for me to feel these eggs and how the shell bends a little,\\u2019 she said. To get the GPS device inside the shell, Paso Pacifico is using 3D printers to make a plastic ball which will then have a GPS transmitter fitted inside. This will take the place of the embryo inside the shell. Lastly the fake shells will be sealed with silicone, waterproofing them. E Sea turtles on average lay around 100 eggs in a nest, and once the fake eggs are finished they will be slipped in with the real ones. Williams-Guillen said it might even be possible to deliver fake eggs into nests while poachers are at work. Wary of tourists, poachers will often back off if strangers come near and then return when they have gone. \\u2018It would be pretty easy to drop an egg in the dark into a nest they have been digging up,\\u2019 she said. Once the poacher picks up the fake egg along with the real ones, conservationists and law enforcement agents will be able to track them. Experts believe most of the stolen eggs eventually make their way out of Nicaragua, possibly to El Salvador or Guatemala. However, there is also growing concern that sea turtle eggs from Central America are actually heading to the USA, from where they are sold on to other countries around the world. F To date, Paso Pacifico has yet to put a single fake egg in a nest. But Williams-Guillen said she isn\\u2019t too concerned that publicity for their scheme will result in poachers looking for the eggs. \\u2018The vast majority of the poaching is happening at night, so already it is hard to tell [the eggs] apart, and at this point, poachers and middlemen are not closely inspecting eggs, but rather shoving them into a sack as quickly as possible.\\u2019 Of course, poachers will eventually become aware of the prospect of fake eggs among the real ones \\u2013 especially when customers try to bite into an egg and break their teeth on the GPS transmitter instead. So, Paso Pacifico plans to do a massive deployment of as many fakes as possible to gather a lot of data before poachers get wise. Knowing where the eggs go will allow conservationists and law enforcement agents to focus their resources on the right places \\u2013 whether it be through awareness-building campaigns or crackdowns on illegal sellers. And eventually Paso Pacifico hopes to share the technology with interested parties around the world. ------ *IUCN: International Union for Conservation of Nature", "text": "Section F Preventing the theft of turtle eggs Conservationists and law enforcement have struggled to prevent wildlife trafficking. But could some plastic eggs and GPS trackers change the game? A Humans have been eating sea turtle eggs (and killing adult turtles for meat) for millennia. However, as human populations exploded and as sea turtles began to confront additional threats such as intensive fishing, beach development and climate change, sea turtle populations declined precipitously. Today, all but one of the world\\u2019s seven species of sea turtles are considered threatened according to the IUCN* Red List. And the one that\\u2019s not \\u2013 the flatback turtle \\u2013 is listed as data deficient, which means scientists simply don\\u2019t know how it\\u2019s doing. B One major problem is that every year millions of sea turtle eggs are illegally taken by poachers for sale on the black market. The situation is particularly serious in Nicaragua, in Central America, which is home to four sea turtle species. Kim Williams-Guillen, who works for conservation body Paso Pacifico, described the poaching of sea turtle nests on the beaches of Nicaragua as \\u2018uncontrolled, unregulated, extensive and contested\\u2019. Even the best-protected beaches are plundered to some extent and it\\u2019s not uncommon to see poachers digging up nests just meters from tourists watching sea turtles laying their clutch at night, she said. This poaching becomes particularly frenzied during the arribadas \\u2013 mass laying events where thousands of turtles nest on the same beach for a single night in a biological strategy to overwhelm natural predators. C \\u2018Even with armed guards, the numbers of poachers overwhelm military personnel by ten to twenty to one,\\u2019 Williams-Guillen said. \\u2018Although many poachers are locals with limited resources, during these arribadas there are influxes of gangs of poachers from larger cities outside local communities. These are not just local poor people without other options.\\u2019 But to protect the country\\u2019s sea turtles, Williams-Guillen said conservationists shouldn\\u2019t just depend on catching low-level operators. \\u2018If one poacher decides to stop, another one will just step into his place\\u2026 we need to know more about the middlemen and people higher up in the distribution chain,\\u2019 she said. D Paso Pacifico\\u2019s solution is the creation of high-tech sea turtle eggs: fake eggs convincingly crafted to look like the real thing, but which contain GPS tracking devices. These have the potential to reveal the destination markets for trafficked sea turtle eggs. Making convincing sea turtle eggs is not easy, and Paso Pacifico is still working on perfecting a prototype. In particular, it\\u2019s proving quite problematic to create the right texture, since sea turtle eggs are not covered in a hard shell like those of birds, but are quite flexible. So Paso Pacifico brought in Lauren Wilde, a special effects artist in the US, to create a convincing outer shell. First, Wilde had to get her hands on the real thing. Since it\\u2019s illegal to send sea turtle eggs over the border, Wilde is using land turtle eggs from California. \\u2018It was really eye opening and important for me to feel these eggs and how the shell bends a little,\\u2019 she said. To get the GPS device inside the shell, Paso Pacifico is using 3D printers to make a plastic ball which will then have a GPS transmitter fitted inside. This will take the place of the embryo inside the shell. Lastly the fake shells will be sealed with silicone, waterproofing them. E Sea turtles on average lay around 100 eggs in a nest, and once the fake eggs are finished they will be slipped in with the real ones. Williams-Guillen said it might even be possible to deliver fake eggs into nests while poachers are at work. Wary of tourists, poachers will often back off if strangers come near and then return when they have gone. \\u2018It would be pretty easy to drop an egg in the dark into a nest they have been digging up,\\u2019 she said. Once the poacher picks up the fake egg along with the real ones, conservationists and law enforcement agents will be able to track them. Experts believe most of the stolen eggs eventually make their way out of Nicaragua, possibly to El Salvador or Guatemala. However, there is also growing concern that sea turtle eggs from Central America are actually heading to the USA, from where they are sold on to other countries around the world. F To date, Paso Pacifico has yet to put a single fake egg in a nest. But Williams-Guillen said she isn\\u2019t too concerned that publicity for their scheme will result in poachers looking for the eggs. \\u2018The vast majority of the poaching is happening at night, so already it is hard to tell [the eggs] apart, and at this point, poachers and middlemen are not closely inspecting eggs, but rather shoving them into a sack as quickly as possible.\\u2019 Of course, poachers will eventually become aware of the prospect of fake eggs among the real ones \\u2013 especially when customers try to bite into an egg and break their teeth on the GPS transmitter instead. So, Paso Pacifico plans to do a massive deployment of as many fakes as possible to gather a lot of data before poachers get wise. Knowing where the eggs go will allow conservationists and law enforcement agents to focus their resources on the right places \\u2013 whether it be through awareness-building campaigns or crackdowns on illegal sellers. And eventually Paso Pacifico hopes to share the technology with interested parties around the world. ------ *IUCN: International Union for Conservation of Nature", "correct_answer": "iii"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 34,
            'question_text' => 'Questions 34-37',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 33, "sub_questions": [{"id": "34", "label": "What does the writer suggest about the flatback turtle? A It could be as severely threatened as other turtles. B It has been neglected by scientists in the past. C It is in less danger than some other species. D It should be removed from the IUCN Red List.", "text": "What does the writer suggest about the flatback turtle? A It could be as severely threatened as other turtles. B It has been neglected by scientists in the past. C It is in less danger than some other species. D It should be removed from the IUCN Red List.", "correct_answer": "A"}, {"id": "35", "label": "Williams-Guillen says that the poaching of sea turtle eggs in Nicaragua A is mainly carried out by local people. B may be encouraged by the presence of tourists. C sometimes has a highly organised structure. D can only be controlled by the use of armed guards.", "text": "Williams-Guillen says that the poaching of sea turtle eggs in Nicaragua A is mainly carried out by local people. B may be encouraged by the presence of tourists. C sometimes has a highly organised structure. D can only be controlled by the use of armed guards.", "correct_answer": "C"}, {"id": "36", "label": "In Section E, Williams-Guillen says that one way to encourage poachers to take the fake eggs is to A make fake nests and put the eggs into them. B put them in nests with just a few real eggs. C distract the poachers after the fake eggs have been put in the nests. D put them in nests that the poachers have started to dig up.", "text": "In Section E, Williams-Guillen says that one way to encourage poachers to take the fake eggs is to A make fake nests and put the eggs into them. B put them in nests with just a few real eggs. C distract the poachers after the fake eggs have been put in the nests. D put them in nests that the poachers have started to dig up.", "correct_answer": "D"}, {"id": "37", "label": "It is planned to use a large number of fake eggs at the beginning because A some of the fake eggs may be missed by the poachers. B it may not be possible to continue the project indefinitely. C some eggs may be hidden in the sand. D it may not be feasible to fund long-term research.", "text": "It is planned to use a large number of fake eggs at the beginning because A some of the fake eggs may be missed by the poachers. B it may not be possible to continue the project indefinitely. C some eggs may be hidden in the sand. D it may not be feasible to fund long-term research.", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 38,
            'question_text' => 'Questions 38-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 37, "sub_questions": [{"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . Lauren Wilde has studied eggs from Californian turtles that live on", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . Lauren Wilde has studied eggs from Californian turtles that live on", "correct_answer": "flexible"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to create a realistic reproduction of the shell. A GPS device will then be placed inside a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to create a realistic reproduction of the shell. A GPS device will then be placed inside a", "correct_answer": "land"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026.. in the fake shell. Finally, silicone will be applied to the shell to make it waterproof. IELTS General Reading Test 01 IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026.. in the fake shell. Finally, silicone will be applied to the shell to make it waterproof. IELTS General Reading Test 01 IELTS General", "correct_answer": "ball"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 3 (material_id = 103) ===
        $matId = 103;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "Participants are required to create a new item of clothing for the Young Fashion Designer UK competition.", "text": "Participants are required to create a new item of clothing for the Young Fashion Designer UK competition.", "correct_answer": "FALSE"}, {"id": "2", "label": "Participants must send information about the thoughts that led to the item they are entering for the competition.", "text": "Participants must send information about the thoughts that led to the item they are entering for the competition.", "correct_answer": "TRUE"}, {"id": "3", "label": "The shortlist will consist of a fixed number of finalists.", "text": "The shortlist will consist of a fixed number of finalists.", "correct_answer": "NOT GIVEN"}, {"id": "4", "label": "Finalists can choose how to present their work to the judges on their stand.", "text": "Finalists can choose how to present their work to the judges on their stand.", "correct_answer": "TRUE"}, {"id": "5", "label": "It is strongly recommended that finalists support their entry with additional photographs.", "text": "It is strongly recommended that finalists support their entry with additional photographs.", "correct_answer": "FALSE"}, {"id": "6", "label": "Questions that the students ask the judges may count towards the final decisions.", "text": "Questions that the students ask the judges may count towards the final decisions.", "correct_answer": "NOT GIVEN"}, {"id": "7", "label": "Extra prizes may be awarded depending on the standard of the entries submitted. Read the text below and answer Questions 8-14. Which keyboard should you buy? It\\u2019s worth remembering that a bad keyboard can significantly affect your entire computing experience. So make sure you pick the right keyboard for your needs.", "text": "Extra prizes may be awarded depending on the standard of the entries submitted. Read the text below and answer Questions 8-14. Which keyboard should you buy? It\\u2019s worth remembering that a bad keyboard can significantly affect your entire computing experience. So make sure you pick the right keyboard for your needs.", "correct_answer": "TRUE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "This keyboard may not suit users who prefer the keys to be almost silent.", "text": "This keyboard may not suit users who prefer the keys to be almost silent.", "correct_answer": "B"}, {"id": "9", "label": "This keyboard is easily portable because it can be made to fit into a small space.", "text": "This keyboard is easily portable because it can be made to fit into a small space.", "correct_answer": "E"}, {"id": "10", "label": "This keyboard includes a special place to put small devices.", "text": "This keyboard includes a special place to put small devices.", "correct_answer": "C"}, {"id": "11", "label": "This keyboard is designed to prevent injury to those who spend a lot of time on the computer.", "text": "This keyboard is designed to prevent injury to those who spend a lot of time on the computer.", "correct_answer": "D"}, {"id": "12", "label": "This keyboard offers good value for money.", "text": "This keyboard offers good value for money.", "correct_answer": "A"}, {"id": "13", "label": "This keyboard is primarily aimed at people who use their computer for entertainment.", "text": "This keyboard is primarily aimed at people who use their computer for entertainment.", "correct_answer": "F"}, {"id": "14", "label": "It shouldn\\u2019t take long for users to get used to the shape of the keys on this keyboard. Advertisements", "text": "It shouldn\\u2019t take long for users to get used to the shape of the keys on this keyboard. Advertisements", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "In a small business it is easy to become \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. with colleagues and other departments.", "text": "In a small business it is easy to become \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. with colleagues and other departments.", "correct_answer": "familiar"}, {"id": "16", "label": "You may find you have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... you were not aware of.", "text": "You may find you have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... you were not aware of.", "correct_answer": "abilities"}, {"id": "17", "label": "Finding that your work is \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 will make you enjoy doing it.", "text": "Finding that your work is \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 will make you enjoy doing it.", "correct_answer": "stimulating"}, {"id": "18", "label": "Other people are likely to realise that you have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "Other people are likely to realise that you have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "potential"}, {"id": "19", "label": "Opportunities for \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 will come sooner than in a larger business.", "text": "Opportunities for \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 will come sooner than in a larger business.", "correct_answer": "promotion"}, {"id": "20", "label": "You can benefit from a small company being more \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. than a large one. Read the text below and answer Questions 21-27 Starting a new job A Make sure you know when and where you are expected to report on your first day. If the route from home is unfamiliar to you, make a practice run first: the normal first activity in a new job is a meeting with your boss, and it would be embarrassing to be late. Dress formally until you\\u2019re sure of the dress code. B You should expect to have an induction programme planned for you: a security pass; visits to whatever parts of the organisation you need to understand to do your job properly; meetings with anyone who could affect your success in the role; and someone to show you where everything is and tell you all the real rules of the culture \\u2013 the ones that are never written down but which everyone is meant to follow. C It can be a shock to join a new organisation. When you are a newcomer, feeling uncertain and perhaps a little confused, there can be a strong temptation to talk about your old job and organisation as a way of reminding yourself and telling others that you really know what you are doing, because you did it in your previous role. Unfortunately, this will suggest that you have a high opinion of yourself, and that you think your old place was better. It has enormous power to annoy, so don\\u2019t do it. D All employers have a core product or service paid for by customers which justifies their existence. If you are not part of this core activity, remember that your role is to provide a service to the people who are part of it. Understanding their concerns and passions is essential for understanding why your own role exists, and for knowing how to work alongside these colleagues. This is why you must see this product or service in action. E When I worked for a television company, all of us, whatever our job, were strongly encouraged to visit a studio and see how programmes were made. This was wise. Make sure you do the equivalent for whatever is the core activity of your new employer. F Don\\u2019t try to do the job too soon. This may seem strange because, after all, you have been appointed to get on and do the job. But in your first few weeks your task is to learn what the job really is, rather than immediately starting to do what you assume it is. G Starting a new job is one of life\\u2019s major transitions. Treat it with the attention it deserves and you will find that all your work in preparing and then going through the selection process has paid off magnificently.", "text": "You can benefit from a small company being more \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. than a large one. Read the text below and answer Questions 21-27 Starting a new job A Make sure you know when and where you are expected to report on your first day. If the route from home is unfamiliar to you, make a practice run first: the normal first activity in a new job is a meeting with your boss, and it would be embarrassing to be late. Dress formally until you\\u2019re sure of the dress code. B You should expect to have an induction programme planned for you: a security pass; visits to whatever parts of the organisation you need to understand to do your job properly; meetings with anyone who could affect your success in the role; and someone to show you where everything is and tell you all the real rules of the culture \\u2013 the ones that are never written down but which everyone is meant to follow. C It can be a shock to join a new organisation. When you are a newcomer, feeling uncertain and perhaps a little confused, there can be a strong temptation to talk about your old job and organisation as a way of reminding yourself and telling others that you really know what you are doing, because you did it in your previous role. Unfortunately, this will suggest that you have a high opinion of yourself, and that you think your old place was better. It has enormous power to annoy, so don\\u2019t do it. D All employers have a core product or service paid for by customers which justifies their existence. If you are not part of this core activity, remember that your role is to provide a service to the people who are part of it. Understanding their concerns and passions is essential for understanding why your own role exists, and for knowing how to work alongside these colleagues. This is why you must see this product or service in action. E When I worked for a television company, all of us, whatever our job, were strongly encouraged to visit a studio and see how programmes were made. This was wise. Make sure you do the equivalent for whatever is the core activity of your new employer. F Don\\u2019t try to do the job too soon. This may seem strange because, after all, you have been appointed to get on and do the job. But in your first few weeks your task is to learn what the job really is, rather than immediately starting to do what you assume it is. G Starting a new job is one of life\\u2019s major transitions. Treat it with the attention it deserves and you will find that all your work in preparing and then going through the selection process has paid off magnificently.", "correct_answer": "flexible"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "the emotions that new employees are likely to experience at first", "text": "the emotions that new employees are likely to experience at first", "correct_answer": "C"}, {"id": "22", "label": "a warning to be patient at first", "text": "a warning to be patient at first", "correct_answer": "F"}, {"id": "23", "label": "how colleagues might react to certain behaviour", "text": "how colleagues might react to certain behaviour", "correct_answer": "C"}, {"id": "24", "label": "travelling to your new workplace before you start working there", "text": "travelling to your new workplace before you start working there", "correct_answer": "A"}, {"id": "25", "label": "an example of observing an activity carried out within an organisation", "text": "an example of observing an activity carried out within an organisation", "correct_answer": "E"}, {"id": "26", "label": "some things that the organisation should arrange for when you begin", "text": "some things that the organisation should arrange for when you begin", "correct_answer": "B"}, {"id": "27", "label": "a division of jobs within an organisation into two categories Advertisements", "text": "a division of jobs within an organisation into two categories Advertisements", "correct_answer": "D"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-30',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "The writer discusses marathon runners and barnacle geese to introduce the idea that A marathon runners may be using inefficient training methods. B the role of diet in achieving fitness has been underestimated. C barnacle geese spend much longer preparing to face a challenge. D serious training is not always necessary for physical achievement.", "text": "The writer discusses marathon runners and barnacle geese to introduce the idea that A marathon runners may be using inefficient training methods. B the role of diet in achieving fitness has been underestimated. C barnacle geese spend much longer preparing to face a challenge. D serious training is not always necessary for physical achievement.", "correct_answer": "D"}, {"id": "29", "label": "The writer says that human muscles A use up a lot of energy even when resting. B are heavier than other types of body tissue. C were more efficiently used by our ancestors. D have become weaker than they were in the past.", "text": "The writer says that human muscles A use up a lot of energy even when resting. B are heavier than other types of body tissue. C were more efficiently used by our ancestors. D have become weaker than they were in the past.", "correct_answer": "A"}, {"id": "30", "label": "The writer says that in order to survive, early humans developed the ability to A hide from their prey. B run long distances. C adapt their speeds to different situations. D predict different types of animal movements.", "text": "The writer says that in order to survive, early humans developed the ability to A hide from their prey. B run long distances. C adapt their speeds to different situations. D predict different types of animal movements.", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 31,
            'question_text' => 'Questions 31-35',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 30, "sub_questions": [{"id": "31", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . For bears, this change may be initially caused by colder weather or a lack of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . For bears, this change may be initially caused by colder weather or a lack of", "correct_answer": "efficient"}, {"id": "32", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. , which during", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. , which during", "correct_answer": "food"}, {"id": "33", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026. causes certain compounds to be released into their", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026. causes certain compounds to be released into their", "correct_answer": "hibernation"}, {"id": "34", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and to travel around the body. These compounds appear to prevent muscle loss. In the case of barnacle geese, the change may be due to a variation in", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and to travel around the body. These compounds appear to prevent muscle loss. In the case of barnacle geese, the change may be due to a variation in", "correct_answer": "blood"}, {"id": "35", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026.. .", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026.. .", "correct_answer": "temperature"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 36,
            'question_text' => 'Questions 36-40) and the list of researchers below.',
            'type' => 'matching_features',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 35, "sub_questions": [{"id": "36", "label": "One belief about how animals stay fit is possibly untrue.", "text": "One belief about how animals stay fit is possibly untrue.", "correct_answer": "A"}, {"id": "37", "label": "It may not be possible to train all animals to improve their speed.", "text": "It may not be possible to train all animals to improve their speed.", "correct_answer": "D"}, {"id": "38", "label": "One type of bird has demonstrated fitness when exposed to a stimulus in experimental conditions.", "text": "One type of bird has demonstrated fitness when exposed to a stimulus in experimental conditions.", "correct_answer": "B"}, {"id": "39", "label": "Human energy use developed in a different way from that of animals.", "text": "Human energy use developed in a different way from that of animals.", "correct_answer": "C"}, {"id": "40", "label": "One type of bird may develop more strength when the weather becomes warmer or cooler. List of Researchers A Lewis Halsey B Chris Guglielmo C Daniel Lieberman D Ross Tucker IELTS General Reading Test 02 IELTS General", "text": "One type of bird may develop more strength when the weather becomes warmer or cooler. List of Researchers A Lewis Halsey B Chris Guglielmo C Daniel Lieberman D Ross Tucker IELTS General Reading Test 02 IELTS General", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 4 (material_id = 104) ===
        $matId = 104;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "what still needs to be done", "text": "what still needs to be done", "correct_answer": "E"}, {"id": "2", "label": "the original suggestion for creating the path", "text": "the original suggestion for creating the path", "correct_answer": "C"}, {"id": "3", "label": "a reason why the path opened early", "text": "a reason why the path opened early", "correct_answer": "B"}, {"id": "4", "label": "people who no longer need to get to the park by car", "text": "people who no longer need to get to the park by car", "correct_answer": "D"}, {"id": "5", "label": "the route of the path", "text": "the route of the path", "correct_answer": "A"}, {"id": "6", "label": "the length of the path", "text": "the length of the path", "correct_answer": "C"}, {"id": "7", "label": "who paid for the path Read the text below and answer Questions 8-14. Study dramatic arts at Thornley If you are hoping for a career in the theatre, Thornley College of Dramatic Arts is the place to come. For fifty years we have been providing top-quality courses for actors, directors, producers, musicians and everyone else who wishes to work professionally in the theatre or related industries. We also have expertise in preparing students for the specialised requirements of TV, film and radio. We\\u2019ll make sure you\\u2019re thoroughly prepared for the reality of work in your chosen field. Our college-based tutors all have extensive practical experience in the entertainment industry as well as academic qualifications, and we also collaborate with some of the country\\u2019s best directors, writers and actors to create challenging, inspiring and exciting projects with our students. We are well-known around the world, with our students coming from every continent. Every year, we receive two thousand applications for the one hundred places on our degree courses. Only the most talented get places, and we are proud that over ninety percent of our students gain professional work within a year of graduating \\u2013 a figure few other drama colleges in the UK can match. To mark our fiftieth anniversary this year, we are putting on a production of Theatre 500 . Written by two staff members especially for this occasion, this multimedia show celebrates five hundred years of drama, and involves all our students in one way or another. Another major development is that the college is about to move. Our new premises are now under construction in the heart of Thornley, next to the council building, which has won a prize for its architecture. For the last two years, we have been developing designs with Miller Furbank Architects for our new home, and one aim has been to ensure the buildings complement the council offices. Work started on the foundations of the buildings in March last year, and we plan to move to the new site this coming September. We have also been talking to cultural organisations in the district, and considering how we can bring cost-free benefits to the local community, as well as to our students. As a result, part of the space in the new buildings has been designed to be adaptable, in order to accommodate classes, performances and workshops for different-sized groups of local people.", "text": "who paid for the path Read the text below and answer Questions 8-14. Study dramatic arts at Thornley If you are hoping for a career in the theatre, Thornley College of Dramatic Arts is the place to come. For fifty years we have been providing top-quality courses for actors, directors, producers, musicians and everyone else who wishes to work professionally in the theatre or related industries. We also have expertise in preparing students for the specialised requirements of TV, film and radio. We\\u2019ll make sure you\\u2019re thoroughly prepared for the reality of work in your chosen field. Our college-based tutors all have extensive practical experience in the entertainment industry as well as academic qualifications, and we also collaborate with some of the country\\u2019s best directors, writers and actors to create challenging, inspiring and exciting projects with our students. We are well-known around the world, with our students coming from every continent. Every year, we receive two thousand applications for the one hundred places on our degree courses. Only the most talented get places, and we are proud that over ninety percent of our students gain professional work within a year of graduating \\u2013 a figure few other drama colleges in the UK can match. To mark our fiftieth anniversary this year, we are putting on a production of Theatre 500 . Written by two staff members especially for this occasion, this multimedia show celebrates five hundred years of drama, and involves all our students in one way or another. Another major development is that the college is about to move. Our new premises are now under construction in the heart of Thornley, next to the council building, which has won a prize for its architecture. For the last two years, we have been developing designs with Miller Furbank Architects for our new home, and one aim has been to ensure the buildings complement the council offices. Work started on the foundations of the buildings in March last year, and we plan to move to the new site this coming September. We have also been talking to cultural organisations in the district, and considering how we can bring cost-free benefits to the local community, as well as to our students. As a result, part of the space in the new buildings has been designed to be adaptable, in order to accommodate classes, performances and workshops for different-sized groups of local people.", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "The college has introduced new courses since it opened.", "text": "The college has introduced new courses since it opened.", "correct_answer": "NOT GIVEN"}, {"id": "9", "label": "The college provides training for work in the film industry.", "text": "The college provides training for work in the film industry.", "correct_answer": "TRUE"}, {"id": "10", "label": "Students have the chance to work with relevant professionals.", "text": "Students have the chance to work with relevant professionals.", "correct_answer": "TRUE"}, {"id": "11", "label": "Many more people apply to study at the college than are accepted.", "text": "Many more people apply to study at the college than are accepted.", "correct_answer": "TRUE"}, {"id": "12", "label": "Theatre 500 was created by students.", "text": "Theatre 500 was created by students.", "correct_answer": "FALSE"}, {"id": "13", "label": "The new building and the council building were designed by the same architects.", "text": "The new building and the council building were designed by the same architects.", "correct_answer": "NOT GIVEN"}, {"id": "14", "label": "Local groups will be charged for using college premises. Advertisements", "text": "Local groups will be charged for using college premises. Advertisements", "correct_answer": "FALSE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "Bringing a personal \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to work will make the place feel more homely.", "text": "Bringing a personal \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to work will make the place feel more homely.", "correct_answer": "photo"}, {"id": "16", "label": "It is important to check the position of all \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 before use to avoid pulling any muscles.", "text": "It is important to check the position of all \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 before use to avoid pulling any muscles.", "correct_answer": "screens"}, {"id": "17", "label": "Leaving the office in the middle of the day may help to raise \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. later on.", "text": "Leaving the office in the middle of the day may help to raise \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. later on.", "correct_answer": "productivity"}, {"id": "18", "label": "It is advisable to avoid checking a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. during breaks.", "text": "It is advisable to avoid checking a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. during breaks.", "correct_answer": "mobile"}, {"id": "19", "label": "Getting involved in \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. at work may have negative results.", "text": "Getting involved in \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. at work may have negative results.", "correct_answer": "gossip"}, {"id": "20", "label": "Having a few \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. available can help people concentrate better at work. Read the text below and answer Questions 21-27 How to get promoted If you\\u2019re sitting at your desk wondering whether this will be the year you finally get promoted, here are some tips. It starts with you. You are perhaps the most important part in the \\u2018promotion process\\u2019, so you need to know what you want \\u2013 and why you want it. Take an honest look at yourself \\u2013 your achievements and also your skills, particularly those you could exploit to take on a different role. Your boss is the gatekeeper. If you think your boss is likely to be on your side, ask for a meeting to discuss your serious commitment to the organisation and how this could translate into a more defined career plan. If you are less sure about your boss\\u2019s view of your prospects and how they may react, start softly with a more deliberate focus on increasing your boss\\u2019s understanding of the work you do and the added value you deliver. Think about how you are perceived at work. In order for you to get your promotion, who needs to know about you? Who would be on the interview panel and whose opinion and input would they seek? And once you\\u2019ve got a list of people to impress, ask yourself \\u2013 do they know enough about you? And I mean really know \\u2013 what you do day to day at your desk, your contribution to the team, and perhaps most importantly, your potential. The chances are that those decision-makers won\\u2019t know all they should about you. Raising your profile in your organisation is critical so that when those in charge start looking at that empty office and considering how best to fill it, the first name that pops into their heads is yours. If your firm has a newsletter, volunteer to write a feature to include in it. If they arrange regular client events, get involved in the organisation of them. And so on. If you think your experience needs enhancing, then look at ways you can continue to improve it. If you are confident in your professional expertise but lack the latest management theory, enrol on some relevant courses that fit around your day job. So what are you waiting for?", "text": "Having a few \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026.. available can help people concentrate better at work. Read the text below and answer Questions 21-27 How to get promoted If you\\u2019re sitting at your desk wondering whether this will be the year you finally get promoted, here are some tips. It starts with you. You are perhaps the most important part in the \\u2018promotion process\\u2019, so you need to know what you want \\u2013 and why you want it. Take an honest look at yourself \\u2013 your achievements and also your skills, particularly those you could exploit to take on a different role. Your boss is the gatekeeper. If you think your boss is likely to be on your side, ask for a meeting to discuss your serious commitment to the organisation and how this could translate into a more defined career plan. If you are less sure about your boss\\u2019s view of your prospects and how they may react, start softly with a more deliberate focus on increasing your boss\\u2019s understanding of the work you do and the added value you deliver. Think about how you are perceived at work. In order for you to get your promotion, who needs to know about you? Who would be on the interview panel and whose opinion and input would they seek? And once you\\u2019ve got a list of people to impress, ask yourself \\u2013 do they know enough about you? And I mean really know \\u2013 what you do day to day at your desk, your contribution to the team, and perhaps most importantly, your potential. The chances are that those decision-makers won\\u2019t know all they should about you. Raising your profile in your organisation is critical so that when those in charge start looking at that empty office and considering how best to fill it, the first name that pops into their heads is yours. If your firm has a newsletter, volunteer to write a feature to include in it. If they arrange regular client events, get involved in the organisation of them. And so on. If you think your experience needs enhancing, then look at ways you can continue to improve it. If you are confident in your professional expertise but lack the latest management theory, enrol on some relevant courses that fit around your day job. So what are you waiting for?", "correct_answer": "snacks"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 that would help gain promotion \\u25cf Set up a meeting with your boss to talk about: - how best to use your high level of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 that would help gain promotion \\u25cf Set up a meeting with your boss to talk about: - how best to use your high level of", "correct_answer": "skills"}, {"id": "22", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in future - or how much extra", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in future - or how much extra", "correct_answer": "commitment"}, {"id": "23", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. you already bring to the company \\u25cf Focus on the important people in the company: - find out which ones will be members of the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. you already bring to the company \\u25cf Focus on the important people in the company: - find out which ones will be members of the", "correct_answer": "value"}, {"id": "24", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 who decide on the promotion - consider how much they are aware of your", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 who decide on the promotion - consider how much they are aware of your", "correct_answer": "panel"}, {"id": "25", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 for the future \\u25cf Take steps to raise your profile by: - offering to create a feature for a company publication - participating in the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 for the future \\u25cf Take steps to raise your profile by: - offering to create a feature for a company publication - participating in the", "correct_answer": "potential"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of events for customers \\u25cf Work on self-development: - take any", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of events for customers \\u25cf Work on self-development: - take any", "correct_answer": "organisation / organization"}, {"id": "27", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. that fill in gaps in knowledge Advertisements", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. that fill in gaps in knowledge Advertisements", "correct_answer": "courses"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-32',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 concerning their behaviour. Some observers believe they exhibit a sense of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 concerning their behaviour. Some observers believe they exhibit a sense of", "correct_answer": "rules"}, {"id": "29", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . The stronger, more senior wolves seem to adopt the roles of the junior wolves when they are playing together. They act as if they are", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . The stronger, more senior wolves seem to adopt the roles of the junior wolves when they are playing together. They act as if they are", "correct_answer": "fairness"}, {"id": "30", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to the juniors and even permit some gentle", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to the juniors and even permit some gentle", "correct_answer": "submissive"}, {"id": "31", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . What is even more surprising is that when one of the juniors gets too forceful, it bends down begging for", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . What is even more surprising is that when one of the juniors gets too forceful, it bends down begging for", "correct_answer": "biting"}, {"id": "32", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . Only when that has been granted will the wolves continue playing.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . Only when that has been granted will the wolves continue playing.", "correct_answer": "forgiveness"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 33,
            'question_text' => 'Questions 33-37) and the list of descriptions below.',
            'type' => 'matching_features',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 32, "sub_questions": [{"id": "33", "label": "coyotes", "text": "coyotes", "correct_answer": "E"}, {"id": "34", "label": "domestic dogs", "text": "domestic dogs", "correct_answer": "C"}, {"id": "35", "label": "elephants", "text": "elephants", "correct_answer": "G"}, {"id": "36", "label": "Diana monkeys", "text": "Diana monkeys", "correct_answer": "D"}, {"id": "37", "label": "rats List of Descriptions A often attack peers who fail to follow the moral code B appear to enjoy playing with members of a different species C sometimes share treats with a peer D may assist a peer who is failing to complete a task E may be driven away by their peers if they do not obey the moral code F seem unwilling to benefit from something that hurts their peers G may help a different type of animal which is in difficulty", "text": "rats List of Descriptions A often attack peers who fail to follow the moral code B appear to enjoy playing with members of a different species C sometimes share treats with a peer D may assist a peer who is failing to complete a task E may be driven away by their peers if they do not obey the moral code F seem unwilling to benefit from something that hurts their peers G may help a different type of animal which is in difficulty", "correct_answer": "F"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 38,
            'question_text' => 'Questions 38-40',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 37, "sub_questions": [{"id": "38", "label": "What view is expressed by Professor de Waal? A Apes have advanced ideas about the difference between good and evil. B The social manners of some animals prove that they are highly moral. C Some human moral beliefs developed from our animal ancestors. D The desire to live in peace with others is a purely human quality.", "text": "What view is expressed by Professor de Waal? A Apes have advanced ideas about the difference between good and evil. B The social manners of some animals prove that they are highly moral. C Some human moral beliefs developed from our animal ancestors. D The desire to live in peace with others is a purely human quality.", "correct_answer": "C"}, {"id": "39", "label": "Why does Professor Bekoff mention the experiment on Diana monkeys? A It shows that this species of monkey is not very easy to train. B It confirms his view on the value of research into certain monkeys. C It proves that female monkeys are generally less intelligent than males. D It illustrates a point he wants to make about monkeys and other creatures.", "text": "Why does Professor Bekoff mention the experiment on Diana monkeys? A It shows that this species of monkey is not very easy to train. B It confirms his view on the value of research into certain monkeys. C It proves that female monkeys are generally less intelligent than males. D It illustrates a point he wants to make about monkeys and other creatures.", "correct_answer": "D"}, {"id": "40", "label": "What does the writer find most surprising about chimpanzees? A They can suffer from some of the same illnesses as humans. B They appear to treat disabled peers with consideration. C They have sets of social conventions that they follow. D The males can be quite destructive at times. IELTS General Reading Test 03 IELTS General", "text": "What does the writer find most surprising about chimpanzees? A They can suffer from some of the same illnesses as humans. B They appear to treat disabled peers with consideration. C They have sets of social conventions that they follow. D The males can be quite destructive at times. IELTS General Reading Test 03 IELTS General", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 5 (material_id = 105) ===
        $matId = 105;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-6',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "Only hospital patients can go on to have transition care.", "text": "Only hospital patients can go on to have transition care.", "correct_answer": "TRUE"}, {"id": "2", "label": "Transition care may be long term or short term.", "text": "Transition care may be long term or short term.", "correct_answer": "FALSE"}, {"id": "3", "label": "Everyone receiving transition care must contribute to the cost.", "text": "Everyone receiving transition care must contribute to the cost.", "correct_answer": "FALSE"}, {"id": "4", "label": "Transition care at home is only available for patients who live alone.", "text": "Transition care at home is only available for patients who live alone.", "correct_answer": "NOT GIVEN"}, {"id": "5", "label": "Transition care may be given on a hospital site.", "text": "Transition care may be given on a hospital site.", "correct_answer": "TRUE"}, {"id": "6", "label": "You may lose your place in a care home if you have to leave it to receive transition care. Read the text below and answer Questions 7-14. CABIN BAGS FOR AIR TRAVEL If you want a small bag with wheels that you can take onto the plane with you, there\\u2019s a wide choice. Here are some of the best. A The Flyer B3 is an ultra-lightweight cabin bag which can withstand some pretty harsh treatment, its nylon and polyester sides won\\u2019t rip or burst open if it\\u2019s dropped or thrown whilst in transit. However, the trolley handle feels quite thin and flimsy. The top carrying handle is hard and flat, and the side handle isn\\u2019t easy to grip. B The Lightglide has two external pockets, both of which are zipped and lockable, but the inside pocket does not zip. In tests, we found the contents remain dry when given a good soaking, even around the zips. The trolley handle has a choice of two heights and the plastic hand grip doesn\\u2019t have any sharp ridges that\\u2019ll make your hands sore. For carrying there are fabric handles at the top and side. C The Foxton is easy to control across most surfaces. However, the zips don\\u2019t always run smoothly especially around the corners, so you may have to give them a good tug, especially if the case is very full. This is definitely one to avoid if you\\u2019re going somewhere rainy as it lets loads of water in, and documents in the pockets will also get pretty wet unless they\\u2019re in plastic folders. D The Skybag has a single external zipped pocket and another located inside the lid. Your clothes are kept in place by two adjustable straps. The zips are easy to grip and they run smoothly around the case. However, this cabin bag felt a little heavy to pull on all but smooth floors, and it was hard to steer compared with some of the other suitcases. E The Travelsure", "text": "You may lose your place in a care home if you have to leave it to receive transition care. Read the text below and answer Questions 7-14. CABIN BAGS FOR AIR TRAVEL If you want a small bag with wheels that you can take onto the plane with you, there\\u2019s a wide choice. Here are some of the best. A The Flyer B3 is an ultra-lightweight cabin bag which can withstand some pretty harsh treatment, its nylon and polyester sides won\\u2019t rip or burst open if it\\u2019s dropped or thrown whilst in transit. However, the trolley handle feels quite thin and flimsy. The top carrying handle is hard and flat, and the side handle isn\\u2019t easy to grip. B The Lightglide has two external pockets, both of which are zipped and lockable, but the inside pocket does not zip. In tests, we found the contents remain dry when given a good soaking, even around the zips. The trolley handle has a choice of two heights and the plastic hand grip doesn\\u2019t have any sharp ridges that\\u2019ll make your hands sore. For carrying there are fabric handles at the top and side. C The Foxton is easy to control across most surfaces. However, the zips don\\u2019t always run smoothly especially around the corners, so you may have to give them a good tug, especially if the case is very full. This is definitely one to avoid if you\\u2019re going somewhere rainy as it lets loads of water in, and documents in the pockets will also get pretty wet unless they\\u2019re in plastic folders. D The Skybag has a single external zipped pocket and another located inside the lid. Your clothes are kept in place by two adjustable straps. The zips are easy to grip and they run smoothly around the case. However, this cabin bag felt a little heavy to pull on all but smooth floors, and it was hard to steer compared with some of the other suitcases. E The Travelsure", "correct_answer": "FALSE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 7,
            'question_text' => 'Questions 7-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 6, "sub_questions": [{"id": "7", "label": "The zips on this cabin bag may be difficult to use.", "text": "The zips on this cabin bag may be difficult to use.", "correct_answer": "C"}, {"id": "8", "label": "This cabin bag may be badly damaged if it is dropped.", "text": "This cabin bag may be badly damaged if it is dropped.", "correct_answer": "E"}, {"id": "9", "label": "The handles of this cabin bag have a number of different problems.", "text": "The handles of this cabin bag have a number of different problems.", "correct_answer": "A"}, {"id": "10", "label": "This cabin bag is very resistant to water.", "text": "This cabin bag is very resistant to water.", "correct_answer": "B"}, {"id": "11", "label": "There\\u2019s a good choice of patterns for the fabric of this cabin bag.", "text": "There\\u2019s a good choice of patterns for the fabric of this cabin bag.", "correct_answer": "E"}, {"id": "12", "label": "This cabin bag isn\\u2019t very easy to move around.", "text": "This cabin bag isn\\u2019t very easy to move around.", "correct_answer": "D"}, {"id": "13", "label": "This cabin bag has just one internal zipped pocket.", "text": "This cabin bag has just one internal zipped pocket.", "correct_answer": "D"}, {"id": "14", "label": "The trolley handle of this cabin bag is adjustable. Advertisements", "text": "The trolley handle of this cabin bag is adjustable. Advertisements", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "Where can you buy parking permits at the college?", "text": "Where can you buy parking permits at the college?", "correct_answer": "Hospitality Department"}, {"id": "16", "label": "Which document shows the dates of term time?", "text": "Which document shows the dates of term time?", "correct_answer": "academic calendar"}, {"id": "17", "label": "What is the start date of annual parking permits?", "text": "What is the start date of annual parking permits?", "correct_answer": "1st October"}, {"id": "18", "label": "Who is responsible for giving out parking fines if you park in the wrong place?", "text": "Who is responsible for giving out parking fines if you park in the wrong place?", "correct_answer": "nominated contractor"}, {"id": "19", "label": "What do visitors need to show when parking?", "text": "What do visitors need to show when parking?", "correct_answer": "permits"}, {"id": "20", "label": "Where can the nursery pick-up point be found? Read the text below and answer Questions 21-27. Maternity benefits If you are expecting a baby, there are a number of benefit schemes that could help you financially. However, eligibility differs for each individual scheme. Statutory Maternity Pay (SMP) You may be entitled to Statutory Maternity Pay (SMP) from your employer. This is a weekly payment, to help make it easier for you to take time off, both before and after the birth of your baby. SMP can be paid for up to 39 weeks. You are entitled to SMP if you have been employed by the same company for at least 26 weeks by the end of the 15th week before your baby is due. You must also be earning an average of at least \\u00a387 per week (before tax). The amount you get depends on how much you earn. For 6 weeks, you will receive 90% of your average weekly earnings. Then you will receive \\u00a3112.75 per week for the remaining 33 weeks. Maternity Allowance (MA) Maternity Allowance (MA) is available to those who are employed or self-employed but not eligible for Statutory Maternity Pay (SMP). You may be entitled to Maternity Allowance if you have been employed or self-employed for at least 26 weeks in the 66 weeks before you are due to give birth. You don\\u2019t have to work for the same employer for those 26 weeks. You also don\\u2019t have to work full weeks (as a part week counts as a full week) during the same period. Maternity Allowance can be paid for up to 39 weeks, and is either paid at the same standard rate as SMP or 90% of your average weekly earnings. You\\u2019ll receive whichever amount is the lower. You can find Maternity Allowance forms at antenatal clinics throughout the country. Child Tax Credit If you\\u2019re on a low income, over 16, and are responsible for at least one child, you may also be entitled to Child Tax Credit. The amount you get will depend on your personal circumstances and income. When your income is being assessed, any child benefit, maintenance payments or Maternity Allowance payments will not be classed as income. This means that it will not be taken into account when calculating your Child Tax Credit. Sure Start Maternity Payments If you get benefits or Child Tax Credit because you\\u2019re on a low income, then you may be entitled to Sure Start Maternity Payments. These are individual grants to help towards the cost of a new baby.", "text": "Where can the nursery pick-up point be found? Read the text below and answer Questions 21-27. Maternity benefits If you are expecting a baby, there are a number of benefit schemes that could help you financially. However, eligibility differs for each individual scheme. Statutory Maternity Pay (SMP) You may be entitled to Statutory Maternity Pay (SMP) from your employer. This is a weekly payment, to help make it easier for you to take time off, both before and after the birth of your baby. SMP can be paid for up to 39 weeks. You are entitled to SMP if you have been employed by the same company for at least 26 weeks by the end of the 15th week before your baby is due. You must also be earning an average of at least \\u00a387 per week (before tax). The amount you get depends on how much you earn. For 6 weeks, you will receive 90% of your average weekly earnings. Then you will receive \\u00a3112.75 per week for the remaining 33 weeks. Maternity Allowance (MA) Maternity Allowance (MA) is available to those who are employed or self-employed but not eligible for Statutory Maternity Pay (SMP). You may be entitled to Maternity Allowance if you have been employed or self-employed for at least 26 weeks in the 66 weeks before you are due to give birth. You don\\u2019t have to work for the same employer for those 26 weeks. You also don\\u2019t have to work full weeks (as a part week counts as a full week) during the same period. Maternity Allowance can be paid for up to 39 weeks, and is either paid at the same standard rate as SMP or 90% of your average weekly earnings. You\\u2019ll receive whichever amount is the lower. You can find Maternity Allowance forms at antenatal clinics throughout the country. Child Tax Credit If you\\u2019re on a low income, over 16, and are responsible for at least one child, you may also be entitled to Child Tax Credit. The amount you get will depend on your personal circumstances and income. When your income is being assessed, any child benefit, maintenance payments or Maternity Allowance payments will not be classed as income. This means that it will not be taken into account when calculating your Child Tax Credit. Sure Start Maternity Payments If you get benefits or Child Tax Credit because you\\u2019re on a low income, then you may be entitled to Sure Start Maternity Payments. These are individual grants to help towards the cost of a new baby.", "correct_answer": "Concorde Building"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "What is the minimum period you must have worked for an employer in order to be eligible for SMP?", "text": "What is the minimum period you must have worked for an employer in order to be eligible for SMP?", "correct_answer": "26 weeks"}, {"id": "22", "label": "For how long is SMP payable every week as a percentage of your average weekly earnings?", "text": "For how long is SMP payable every week as a percentage of your average weekly earnings?", "correct_answer": "6 weeks/ six weeks"}, {"id": "23", "label": "What sum is payable every week as the second part of SMP entitlement?", "text": "What sum is payable every week as the second part of SMP entitlement?", "correct_answer": "\\u00a3112.75"}, {"id": "24", "label": "What is the maximum length of time MA is payable?", "text": "What is the maximum length of time MA is payable?", "correct_answer": "39 weeks"}, {"id": "25", "label": "Where can MA forms be obtained?", "text": "Where can MA forms be obtained?", "correct_answer": "antenatal clinics"}, {"id": "26", "label": "Apart from income, what else is considered when assessing how much Child Tax Credit is paid?", "text": "Apart from income, what else is considered when assessing how much Child Tax Credit is paid?", "correct_answer": "personal circumstances"}, {"id": "27", "label": "What are Sure Start Maternity Payments? Advertisements", "text": "What are Sure Start Maternity Payments? Advertisements", "correct_answer": "grants"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Question 28-32',
            'type' => 'matching_headings',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Section A", "text": "Section A", "correct_answer": "ii"}, {"id": "29", "label": "Section B", "text": "Section B", "correct_answer": "viii"}, {"id": "30", "label": "Section C", "text": "Section C", "correct_answer": "vii"}, {"id": "31", "label": "Section D", "text": "Section D", "correct_answer": "iii"}, {"id": "32", "label": "Section E", "text": "Section E", "correct_answer": "vi"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 33,
            'question_text' => 'Questions 33-37',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 32, "sub_questions": [{"id": "33", "label": "What was the problem with using animal skins and wood strips for writing on? A They did not last for a long time. B They were not easy to store. C They were insufficiently flexible. D They could be destroyed by fire.", "text": "What was the problem with using animal skins and wood strips for writing on? A They did not last for a long time. B They were not easy to store. C They were insufficiently flexible. D They could be destroyed by fire.", "correct_answer": "A"}, {"id": "34", "label": "Why did papyrus manufacturers hammer the papyrus? A to remove water from the pith strips B to join the layers of pith strips together C to allow the pith strips to be easily cut D to position the layers of pith strips at the correct angle", "text": "Why did papyrus manufacturers hammer the papyrus? A to remove water from the pith strips B to join the layers of pith strips together C to allow the pith strips to be easily cut D to position the layers of pith strips at the correct angle", "correct_answer": "B"}, {"id": "35", "label": "When referring to burning libraries and books, the writer is suggesting that A information can be used for harm as well as for good. B new ways must be found to ensure information is not lost. C cultural knowledge depends on more than written texts. D those in power may Wish to keep others in ignorance.", "text": "When referring to burning libraries and books, the writer is suggesting that A information can be used for harm as well as for good. B new ways must be found to ensure information is not lost. C cultural knowledge depends on more than written texts. D those in power may Wish to keep others in ignorance.", "correct_answer": "D"}, {"id": "36", "label": "The writer refers to Thor Heyerdahl to illustrate the point that A papyrus could be used as a food on long sea voyages. B the ancient Egyptians already had advanced navigation skills. C papyrus could be used to build boats for long sea journeys. D the ancient Egyptians knew of the environmental benefits of papyrus", "text": "The writer refers to Thor Heyerdahl to illustrate the point that A papyrus could be used as a food on long sea voyages. B the ancient Egyptians already had advanced navigation skills. C papyrus could be used to build boats for long sea journeys. D the ancient Egyptians knew of the environmental benefits of papyrus", "correct_answer": "C"}, {"id": "37", "label": "What does the writer conclude about papyrus today? A It is better for the environment than using paper. B Its significance is restricted to its role in the past. C It is still the best writing surface for some purposes. D More efforts need to be made to ensure it stays in use.", "text": "What does the writer conclude about papyrus today? A It is better for the environment than using paper. B Its significance is restricted to its role in the past. C It is still the best writing surface for some purposes. D More efforts need to be made to ensure it stays in use.", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 38,
            'question_text' => 'Questions 38-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 37, "sub_questions": [{"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 However, it can survive for long periods in an environment that is dry. It has been found in a 5,000-year-old", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 However, it can survive for long periods in an environment that is dry. It has been found in a 5,000-year-old", "correct_answer": "insects"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in Egypt, and in Herculaneum many papyrus documents were preserved following a huge", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in Egypt, and in Herculaneum many papyrus documents were preserved following a huge", "correct_answer": "tomb"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in 79 CE. in the town of Oxyrhynchus, unwanted administrative documents were left on rubbish dumps which were covered with sand, preserving them for many years. IELTS General Reading Test 04 IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in 79 CE. in the town of Oxyrhynchus, unwanted administrative documents were left on rubbish dumps which were covered with sand, preserving them for many years. IELTS General Reading Test 04 IELTS General", "correct_answer": "eruption"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 6 (material_id = 106) ===
        $matId = 106;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "liking the view from the bedroom window", "text": "liking the view from the bedroom window", "correct_answer": "C"}, {"id": "2", "label": "finding the receptionists welcoming", "text": "finding the receptionists welcoming", "correct_answer": "A"}, {"id": "3", "label": "being pleased with the bedroom", "text": "being pleased with the bedroom", "correct_answer": "B"}, {"id": "4", "label": "becoming confused when booking a room", "text": "becoming confused when booking a room", "correct_answer": "E"}, {"id": "5", "label": "being impressed by the wide choice of food", "text": "being impressed by the wide choice of food", "correct_answer": "D"}, {"id": "6", "label": "staying in the hotel regularly", "text": "staying in the hotel regularly", "correct_answer": "A"}, {"id": "7", "label": "finding it inconvenient that the hotel was crowded Read the text below and answer Questions 8-14. Come and play walking football or walking netball Walking football and netball have become increasingly popular in recent years, but do you know you can take part in this area? The names make it clear what they are \\u2013 two of the country\\u2019s favourite sports where, instead of running, the players walk. It\\u2019s as simple as that. Walking football was invented in the UK in 2011, but it was a 2014 TV commercial for a bank, showing it providing financial support to someone who wanted to set up a website for the game, that brought it to people\\u2019s attention. Since then, tens of thousands of people \\u2014 mostly, though not only, over the age of 50 \\u2014 have started playing, and there are more than 800 walking football clubs. Both men and women play walking football, but at the moment the netball teams consist only of women. However, men are beginning to show an interest in playing. The two games are designed to help people to be active or get fit, whatever their age and level of fitness. In particular, they were invented to encourage older men and women to get more exercise, and to give them a chance to meet other people. Regular physical activity helps to maintain energy, strength and flexibility. You can start gently and do a little more each session. The benefits include lower heart rate and blood pressure, greater mobility, less fat and more muscle. Many players have given up a sport \\u2013 either through age or injury \\u2013 and can now take it up again. They\\u2019re great ways for people to enjoy a sport they used to play and love, and keep active at the same time, though people who have never played the standard game before are also very welcome. The local councils Active Lifestyles Team runs sessions at all the council\\u2019s leisure centres. Come alone or with a friend, and enjoy a friendly game on Monday or Saturday afternoons, or Tuesday or Thursday evenings. Each session costs \\u00a33 per person, and you don\\u2019t have to come regularly or at the same time each week. Our aim is to set up netball and football clubs as soon as there are enough regular players.", "text": "finding it inconvenient that the hotel was crowded Read the text below and answer Questions 8-14. Come and play walking football or walking netball Walking football and netball have become increasingly popular in recent years, but do you know you can take part in this area? The names make it clear what they are \\u2013 two of the country\\u2019s favourite sports where, instead of running, the players walk. It\\u2019s as simple as that. Walking football was invented in the UK in 2011, but it was a 2014 TV commercial for a bank, showing it providing financial support to someone who wanted to set up a website for the game, that brought it to people\\u2019s attention. Since then, tens of thousands of people \\u2014 mostly, though not only, over the age of 50 \\u2014 have started playing, and there are more than 800 walking football clubs. Both men and women play walking football, but at the moment the netball teams consist only of women. However, men are beginning to show an interest in playing. The two games are designed to help people to be active or get fit, whatever their age and level of fitness. In particular, they were invented to encourage older men and women to get more exercise, and to give them a chance to meet other people. Regular physical activity helps to maintain energy, strength and flexibility. You can start gently and do a little more each session. The benefits include lower heart rate and blood pressure, greater mobility, less fat and more muscle. Many players have given up a sport \\u2013 either through age or injury \\u2013 and can now take it up again. They\\u2019re great ways for people to enjoy a sport they used to play and love, and keep active at the same time, though people who have never played the standard game before are also very welcome. The local councils Active Lifestyles Team runs sessions at all the council\\u2019s leisure centres. Come alone or with a friend, and enjoy a friendly game on Monday or Saturday afternoons, or Tuesday or Thursday evenings. Each session costs \\u00a33 per person, and you don\\u2019t have to come regularly or at the same time each week. Our aim is to set up netball and football clubs as soon as there are enough regular players.", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "Walking football became well-known when a club featured in a TV programme about the sport.", "text": "Walking football became well-known when a club featured in a TV programme about the sport.", "correct_answer": "FALSE"}, {"id": "9", "label": "The majority of walking netball players are men.", "text": "The majority of walking netball players are men.", "correct_answer": "FALSE"}, {"id": "10", "label": "Most clubs arrange social activities for their members,", "text": "Most clubs arrange social activities for their members,", "correct_answer": "NOT GIVEN"}, {"id": "11", "label": "Players are tested regularly to measure changes in their fitness.", "text": "Players are tested regularly to measure changes in their fitness.", "correct_answer": "NOT GIVEN"}, {"id": "12", "label": "People who have never played football are encouraged to play walking football.", "text": "People who have never played football are encouraged to play walking football.", "correct_answer": "TRUE"}, {"id": "13", "label": "People can take part in the Active Lifestyles Team\\u2019s sessions whenever they wish", "text": "People can take part in the Active Lifestyles Team\\u2019s sessions whenever they wish", "correct_answer": "TRUE"}, {"id": "14", "label": "The Active Lifestyles Team intends to start clubs in the future. Advertisements", "text": "The Active Lifestyles Team intends to start clubs in the future. Advertisements", "correct_answer": "TRUE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "If employees are unsure what their company wishes them to wear for work, they should request \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "text": "If employees are unsure what their company wishes them to wear for work, they should request \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "correct_answer": "clarification"}, {"id": "16", "label": "Some companies offer their employees a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 when they buy items to wear for work.", "text": "Some companies offer their employees a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 when they buy items to wear for work.", "correct_answer": "discount"}, {"id": "17", "label": "Employees who fail to wear protective clothing when required could be subject to \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 procedures.", "text": "Employees who fail to wear protective clothing when required could be subject to \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 procedures.", "correct_answer": "disciplinary"}, {"id": "18", "label": "Employees ought not to be in \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 because of protective clothing or equipment.", "text": "Employees ought not to be in \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 because of protective clothing or equipment.", "correct_answer": "pain"}, {"id": "19", "label": "It is the company\\u2019s responsibility to ensure that there is a suitable place for the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of protective equipment.", "text": "It is the company\\u2019s responsibility to ensure that there is a suitable place for the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of protective equipment.", "correct_answer": "storage"}, {"id": "20", "label": "Employees who work with certain types of \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 may have to remove jewellery to avoid potential injuries. Read the text below and answer Questions 21-27. How to achieve a better work-life balance As more and more employees work from home full time and everyone has 24/7 access to email, balancing work and family may not seem like an easily attainable goal. So how can you juggle the demands of both worlds? Below are some tips to help you get started. It\\u2019s easy to get sucked into habits that, make us less efficient without realizing it \\u2013 like keeping your social media page open at work so you don\\u2019t miss something \\u2018important\\u2019. Draw up a list with all the activities that don\\u2019t enhance your life or career. Then minimize the time you spend on them. It\\u2019s hard to say no\\u2019, especially to a supervisor or loved one, but sometimes that powerful little word is essential. Learn to use \\u2018no\\u2019 judiciously and it will become a powerful tool in balancing work and family. Research shows that exercise helps you remain alert. Finding time to hit the gym may be hard, but it will ultimately help you get more things done because exercise really boosts energy and improves your ability to concentrate. Study after study shows that significant sleep deprivation affects your health and well-being. Exposure to electronics can significantly negatively impact your sleep, so try to unplug an hour before you go to sleep. What would you do if you had a whole day to yourself with no demands on your time? While most people don\\u2019t have the luxury of a whole day dedicated to relaxation, constantly putting off that downtime and putting everyone\\u2019s needs before yours will wear you down. Pick a time to do something just for you. Even just a few minutes of \\u2018me time\\u2019 a day will help to recharge your batteries. Don\\u2019t assume your family and manager are aware of your concerns. If you feel you have to adjust your schedule to discover a better work-life balance, then voice that requirement. If that means asking your boss for permission to leave a few minutes early once a week so you can hit that yoga class on the way home, do it. All new habits require time to build, so if you find yourself sneaking your smartphone to bed, that\\u2019s okay. Leave your phone downstairs tomorrow night. Tiny steps are the key to finding that balance, so start small, and go from there. Most of all, know your limitations and what works best for you; then decide what really matters, what advice you want to follow, and prioritize.", "text": "Employees who work with certain types of \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 may have to remove jewellery to avoid potential injuries. Read the text below and answer Questions 21-27. How to achieve a better work-life balance As more and more employees work from home full time and everyone has 24/7 access to email, balancing work and family may not seem like an easily attainable goal. So how can you juggle the demands of both worlds? Below are some tips to help you get started. It\\u2019s easy to get sucked into habits that, make us less efficient without realizing it \\u2013 like keeping your social media page open at work so you don\\u2019t miss something \\u2018important\\u2019. Draw up a list with all the activities that don\\u2019t enhance your life or career. Then minimize the time you spend on them. It\\u2019s hard to say no\\u2019, especially to a supervisor or loved one, but sometimes that powerful little word is essential. Learn to use \\u2018no\\u2019 judiciously and it will become a powerful tool in balancing work and family. Research shows that exercise helps you remain alert. Finding time to hit the gym may be hard, but it will ultimately help you get more things done because exercise really boosts energy and improves your ability to concentrate. Study after study shows that significant sleep deprivation affects your health and well-being. Exposure to electronics can significantly negatively impact your sleep, so try to unplug an hour before you go to sleep. What would you do if you had a whole day to yourself with no demands on your time? While most people don\\u2019t have the luxury of a whole day dedicated to relaxation, constantly putting off that downtime and putting everyone\\u2019s needs before yours will wear you down. Pick a time to do something just for you. Even just a few minutes of \\u2018me time\\u2019 a day will help to recharge your batteries. Don\\u2019t assume your family and manager are aware of your concerns. If you feel you have to adjust your schedule to discover a better work-life balance, then voice that requirement. If that means asking your boss for permission to leave a few minutes early once a week so you can hit that yoga class on the way home, do it. All new habits require time to build, so if you find yourself sneaking your smartphone to bed, that\\u2019s okay. Leave your phone downstairs tomorrow night. Tiny steps are the key to finding that balance, so start small, and go from there. Most of all, know your limitations and what works best for you; then decide what really matters, what advice you want to follow, and prioritize.", "correct_answer": "machinery"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of things that are not helpful and reduce involvement in them \\u2022 Refuse some requests as this can be a useful", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of things that are not helpful and reduce involvement in them \\u2022 Refuse some requests as this can be a useful", "correct_answer": "list"}, {"id": "22", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in gaining a better work-life balance Things that cars help \\u2022 Regular exercise \\u2013 can increase", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in gaining a better work-life balance Things that cars help \\u2022 Regular exercise \\u2013 can increase", "correct_answer": "tool"}, {"id": "23", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 significantly \\u2022 Sleep \\u2013 insufficient sleep can make people ill \\u2013 avoid focusing on", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 significantly \\u2022 Sleep \\u2013 insufficient sleep can make people ill \\u2013 avoid focusing on", "correct_answer": "energy"}, {"id": "24", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in the lead-up to bedtime Issues that require attention \\u2022 Those who see other people\\u2019s", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in the lead-up to bedtime Issues that require attention \\u2022 Those who see other people\\u2019s", "correct_answer": "electronics"}, {"id": "25", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 as more important than their own will suffer \\u2022 If the working day is too long, get", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 as more important than their own will suffer \\u2022 If the working day is too long, get", "correct_answer": "needs"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to shorten it occasionally \\u2022 People should learn to recognise their own", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to shorten it occasionally \\u2022 People should learn to recognise their own", "correct_answer": "permission"}, {"id": "27", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 Advertisements", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 Advertisements", "correct_answer": "limitations"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-35',
            'type' => 'matching_paragraph_information',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "why it was easy to recruit workers to build the bridge", "text": "why it was easy to recruit workers to build the bridge", "correct_answer": "E"}, {"id": "29", "label": "a change in the design of the bridge", "text": "a change in the design of the bridge", "correct_answer": "C"}, {"id": "30", "label": "opposition to building the bridge", "text": "opposition to building the bridge", "correct_answer": "B"}, {"id": "31", "label": "why a bridge was desirable", "text": "why a bridge was desirable", "correct_answer": "A"}, {"id": "32", "label": "problems with raising funding for the bridge", "text": "problems with raising funding for the bridge", "correct_answer": "D"}, {"id": "33", "label": "permission being given to build the bridge", "text": "permission being given to build the bridge", "correct_answer": "B"}, {"id": "34", "label": "which records the bridge broke", "text": "which records the bridge broke", "correct_answer": "G"}, {"id": "35", "label": "the idea that building a bridge might be impossible", "text": "the idea that building a bridge might be impossible", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 36,
            'question_text' => 'Questions 36-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 35, "sub_questions": [{"id": "36", "label": "Building the bridge required a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 issued by the Secretary of War.", "text": "Building the bridge required a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 issued by the Secretary of War.", "correct_answer": "permit"}, {"id": "37", "label": "One objection to building the bridge was that another \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 would destroy it.", "text": "One objection to building the bridge was that another \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 would destroy it.", "correct_answer": "earthquakes"}, {"id": "38", "label": "Construction was delayed when the framework was damaged by a ship and again by a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "text": "Construction was delayed when the framework was damaged by a ship and again by a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "correct_answer": "storm"}, {"id": "39", "label": "The last part of the bridge to be constructed was the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "text": "The last part of the bridge to be constructed was the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "correct_answer": "roadway"}, {"id": "40", "label": "The bridge was first used by \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in May 1937. IELTS General Reading Test 05 IELTS General", "text": "The bridge was first used by \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in May 1937. IELTS General Reading Test 05 IELTS General", "correct_answer": "pedestrians"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 7 (material_id = 107) ===
        $matId = 107;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "Payment at this venue is optional.", "text": "Payment at this venue is optional.", "correct_answer": "B"}, {"id": "2", "label": "Expert instructors are available for lessons.", "text": "Expert instructors are available for lessons.", "correct_answer": "E"}, {"id": "3", "label": "There is a restriction on what you can wear.", "text": "There is a restriction on what you can wear.", "correct_answer": "D"}, {"id": "4", "label": "Some basic information is published in another place.", "text": "Some basic information is published in another place.", "correct_answer": "C"}, {"id": "5", "label": "This has particular provision for very young children.", "text": "This has particular provision for very young children.", "correct_answer": "C"}, {"id": "6", "label": "It has a feature especially recommended for educational parties.", "text": "It has a feature especially recommended for educational parties.", "correct_answer": "B"}, {"id": "7", "label": "They will open at unscheduled times if you make an arrangement. Read the text below and answer Questions 8-14. DO YOU HAVE A MUSIC PROJECT IN MIND THAT MIGHT BENEFIT FROM FUNDING? Music is wonderfully therapeutic! This is recognised by The Dosoco Foundation, which supports local projects that use music for social good. The next round of Dosoco grant funding will shortly be open for applications. Grants are available from \\u00a3700 to \\u00a31,000 (for organisations) and up to \\u00a3300 (for individuals) in the areas of music education (e.g. working with a talented music student with either physical, social or learning disabilities), music access (e.g. a music club for groups that might struggle to start something on their own), music innovation (e.g. using an electronic device such as Raspberry Pi to help disabled people make music) and music therapy (e.g. an idea for using music to support positive mental health). Case study Dosoco recently awarded a grant to Alexia Sloane, a young composer with sight loss, to enable her to attend the sound-and-music summer-school composition course at the Purcell School. Alexia has since gained a place as a composer with the National Youth Orchestra of Great Britain \\u2013 the first blind composer to be appointed \\u2013 and has also been awarded the title of Young Composer of the Year. She was the first female composer ever to receive this honour in its ten-year history. Organisations, families and individuals can apply by completing a simple form. Dosoco can contribute up to 50% towards project costs. Projects must be locally based and must be new ideas for using music to make a positive impact on people\\u2019s lives where help is really needed. For more information please visit www.thedosocofoundation.org", "text": "They will open at unscheduled times if you make an arrangement. Read the text below and answer Questions 8-14. DO YOU HAVE A MUSIC PROJECT IN MIND THAT MIGHT BENEFIT FROM FUNDING? Music is wonderfully therapeutic! This is recognised by The Dosoco Foundation, which supports local projects that use music for social good. The next round of Dosoco grant funding will shortly be open for applications. Grants are available from \\u00a3700 to \\u00a31,000 (for organisations) and up to \\u00a3300 (for individuals) in the areas of music education (e.g. working with a talented music student with either physical, social or learning disabilities), music access (e.g. a music club for groups that might struggle to start something on their own), music innovation (e.g. using an electronic device such as Raspberry Pi to help disabled people make music) and music therapy (e.g. an idea for using music to support positive mental health). Case study Dosoco recently awarded a grant to Alexia Sloane, a young composer with sight loss, to enable her to attend the sound-and-music summer-school composition course at the Purcell School. Alexia has since gained a place as a composer with the National Youth Orchestra of Great Britain \\u2013 the first blind composer to be appointed \\u2013 and has also been awarded the title of Young Composer of the Year. She was the first female composer ever to receive this honour in its ten-year history. Organisations, families and individuals can apply by completing a simple form. Dosoco can contribute up to 50% towards project costs. Projects must be locally based and must be new ideas for using music to make a positive impact on people\\u2019s lives where help is really needed. For more information please visit www.thedosocofoundation.org", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "You can apply to Dosoco now for grant funding.", "text": "You can apply to Dosoco now for grant funding.", "correct_answer": "FALSE"}, {"id": "9", "label": "You can apply for a grant that will help to educate a musician.", "text": "You can apply for a grant that will help to educate a musician.", "correct_answer": "TRUE"}, {"id": "10", "label": "Alexia Sloane lost her sight after attending a summer-school composition course.", "text": "Alexia Sloane lost her sight after attending a summer-school composition course.", "correct_answer": "FALSE"}, {"id": "11", "label": "Alexia now plays several instruments with the National Youth Orchestra of Great Britain.", "text": "Alexia now plays several instruments with the National Youth Orchestra of Great Britain.", "correct_answer": "FALSE"}, {"id": "12", "label": "Alexia has received an award for her work in music.", "text": "Alexia has received an award for her work in music.", "correct_answer": "TRUE"}, {"id": "13", "label": "Applications can be made by filling in an online form.", "text": "Applications can be made by filling in an online form.", "correct_answer": "NOT GIVEN"}, {"id": "14", "label": "In some cases Dosoco will cover the full cost of the project. Advertisements", "text": "In some cases Dosoco will cover the full cost of the project. Advertisements", "correct_answer": "FALSE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-21',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2022 your phone calls and which websites you have visited Rules for monitoring are established by data protection law. This states that employers must carry out a procedure that is known as", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2022 your phone calls and which websites you have visited Rules for monitoring are established by data protection law. This states that employers must carry out a procedure that is known as", "correct_answer": "emails"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. before introducing monitoring. In general, monitoring is legal if \\u2022 it relates to the business \\u2022 you are using", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. before introducing monitoring. In general, monitoring is legal if \\u2022 it relates to the business \\u2022 you are using", "correct_answer": "impact assessment"}, {"id": "17", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. intended for work \\u2022 the worker has been informed Monitoring may be used \\u2022 to evaluate the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. intended for work \\u2022 the worker has been informed Monitoring may be used \\u2022 to evaluate the", "correct_answer": "equipment"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. of your work \\u2022 to stop of find out about", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. of your work \\u2022 to stop of find out about", "correct_answer": "quality"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2022 to stop the possibility of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2022 to stop the possibility of", "correct_answer": "crime"}, {"id": "20", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. affecting systems \\u2022 to check calls to", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. affecting systems \\u2022 to check calls to", "correct_answer": "viruses"}, {"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. (these cannot be recorded) Read the text below and answer Questions 22-27. International Experience Canada: application process If you want to travel and work temporarily in Canada as part of International Experience Canada (IEC), your first step is to become a candidate in one or more IEC pools. There are three categories of pool: International Co-op (Internship), Working Holiday and Young Professionals. To apply, first use our questionnaire to see if you meet the criteria to get into the IEC pools. This should take you about ten minutes. You can find it at www.cic.gc.ca/ctc-vac/cometocanada.asp. After completing this, if you are eligible you will be sent a personal reference code, which you should use to create your online account. At the same time, you should fill in any remaining fields in your profile with the required information, including which IEC pools you want to be in. (Some parts will already have been completed for you.) If you are sent an invitation to proceed with your application, you will have 10 days to decide whether to accept this or not. If you accept, click the \\u2018Start Application\\u2019 button. You then have 20 days to complete your application. For International Co-op and Young Professionals categories, your employer in Canada must pay the compliance fee and inform you of your offer of employment number. (This does not apply to the Working Holiday pool.) Once you have received this, you should then upload copies of police and medical certificates, if required. If you do not have these, you should upload proof that you have applied for them. You should then pay your participation fee of C$126 online by credit card. (There is an additional payment of C$100 if you are applying for the Working Holiday category.) Your application will then be assessed. You can apply to withdraw at this stage and will be given a refund if you do this within 56 days. If your application is successful, you will receive a letter of introduction which you can show to Immigration when you enter Canada.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. (these cannot be recorded) Read the text below and answer Questions 22-27. International Experience Canada: application process If you want to travel and work temporarily in Canada as part of International Experience Canada (IEC), your first step is to become a candidate in one or more IEC pools. There are three categories of pool: International Co-op (Internship), Working Holiday and Young Professionals. To apply, first use our questionnaire to see if you meet the criteria to get into the IEC pools. This should take you about ten minutes. You can find it at www.cic.gc.ca/ctc-vac/cometocanada.asp. After completing this, if you are eligible you will be sent a personal reference code, which you should use to create your online account. At the same time, you should fill in any remaining fields in your profile with the required information, including which IEC pools you want to be in. (Some parts will already have been completed for you.) If you are sent an invitation to proceed with your application, you will have 10 days to decide whether to accept this or not. If you accept, click the \\u2018Start Application\\u2019 button. You then have 20 days to complete your application. For International Co-op and Young Professionals categories, your employer in Canada must pay the compliance fee and inform you of your offer of employment number. (This does not apply to the Working Holiday pool.) Once you have received this, you should then upload copies of police and medical certificates, if required. If you do not have these, you should upload proof that you have applied for them. You should then pay your participation fee of C$126 online by credit card. (There is an additional payment of C$100 if you are applying for the Working Holiday category.) Your application will then be assessed. You can apply to withdraw at this stage and will be given a refund if you do this within 56 days. If your application is successful, you will receive a letter of introduction which you can show to Immigration when you enter Canada.", "correct_answer": "helplines"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 22,
            'question_text' => 'Questions 22-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 21, "sub_questions": [{"id": "22", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to get a personal reference code. \\u2193 Create your", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to get a personal reference code. \\u2193 Create your", "correct_answer": "questionnaire"}, {"id": "23", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026., and provide the necessary information for the profile in your application. \\u2193 If sent an invitation, you must accept this within", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026., and provide the necessary information for the profile in your application. \\u2193 If sent an invitation, you must accept this within", "correct_answer": "account"}, {"id": "24", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . You then have a limited time to", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . You then have a limited time to", "correct_answer": "10 days"}, {"id": "25", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. the application. \\u2193 Your", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. the application. \\u2193 Your", "correct_answer": "complete"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. is required to send you an offer of employment number. \\u2193 Upload copies of any necessary certificates or proof of application. \\u2193 Make the payment for participation online. You may receive a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. is required to send you an offer of employment number. \\u2193 Upload copies of any necessary certificates or proof of application. \\u2193 Make the payment for participation online. You may receive a", "correct_answer": "employer"}, {"id": "27", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. later if you change your mind. \\u2193 If successful, you will receive a letter of introduction to be shown at Immigration. Advertisements", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. later if you change your mind. \\u2193 If successful, you will receive a letter of introduction to be shown at Immigration. Advertisements", "correct_answer": "refund"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-32',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "What is the main problem faced by cattle farmers in Ethiopia, according to Professor Wood? A TB is being transmitted from people to cattle. B New breeds of cattle have led to an increase in TB. C The traditional breeds of cattle are being affected by TB. D TB has spread into places where it was previously unknown.", "text": "What is the main problem faced by cattle farmers in Ethiopia, according to Professor Wood? A TB is being transmitted from people to cattle. B New breeds of cattle have led to an increase in TB. C The traditional breeds of cattle are being affected by TB. D TB has spread into places where it was previously unknown.", "correct_answer": "B"}, {"id": "29", "label": "When discussing the cultivation of cabbages in Ghana, the writer says that this crop A was introduced from outside Africa. B is not eaten much by local people. C is not grown correctly by many farmers. D requires the use of fertiliser and special equipment.", "text": "When discussing the cultivation of cabbages in Ghana, the writer says that this crop A was introduced from outside Africa. B is not eaten much by local people. C is not grown correctly by many farmers. D requires the use of fertiliser and special equipment.", "correct_answer": "A"}, {"id": "30", "label": "Fening believed that the new disease destroying cabbages was A caused by overuse of pesticides. B also affecting other locally grown vegetables. C linked to insect attacks on these vegetables. D connected with the development of new insect breeds.", "text": "Fening believed that the new disease destroying cabbages was A caused by overuse of pesticides. B also affecting other locally grown vegetables. C linked to insect attacks on these vegetables. D connected with the development of new insect breeds.", "correct_answer": "C"}, {"id": "31", "label": "Fening first suspected that the cabbage disease was caused by a virus because A evidence of viral disease could be seen on the cabbage leaves. B pink and green aphids did not commonly attack cabbages. C viral diseases affecting vegetables had occurred elsewhere in Africa. D aphids would not have caused so much damage to the crops.", "text": "Fening first suspected that the cabbage disease was caused by a virus because A evidence of viral disease could be seen on the cabbage leaves. B pink and green aphids did not commonly attack cabbages. C viral diseases affecting vegetables had occurred elsewhere in Africa. D aphids would not have caused so much damage to the crops.", "correct_answer": "D"}, {"id": "32", "label": "When doing further research in Cambridge, Fening and Carr discovered that A the virus was unfamiliar to them. B two different viruses were present. C the aphids\\u2019 DNA was more complex than expected. D one aphid was more harmful than the other.", "text": "When doing further research in Cambridge, Fening and Carr discovered that A the virus was unfamiliar to them. B two different viruses were present. C the aphids\\u2019 DNA was more complex than expected. D one aphid was more harmful than the other.", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 33,
            'question_text' => 'Questions 33-36) and the list of researchers below.',
            'type' => 'matching_features',
            'options' => '{"A": "particular crop may make an important contribution to the local economy in one African country."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 32, "sub_questions": [{"id": "33", "label": "Question 33", "text": "Question 33", "correct_answer": "B"}, {"id": "34", "label": "Tests will be carried out by local people in the country where the research is focused.", "text": "Tests will be carried out by local people in the country where the research is focused.", "correct_answer": "D"}, {"id": "35", "label": "Different specialists must work together to ensure the success of a programme.", "text": "Different specialists must work together to ensure the success of a programme.", "correct_answer": "A"}, {"id": "36", "label": "One type of insect attacking plants in Ghana was previously unknown there. List of Researchers A James Wood B Ken Fening C John Carr D Theresa Manful E Mark Carrington", "text": "One type of insect attacking plants in Ghana was previously unknown there. List of Researchers A James Wood B Ken Fening C John Carr D Theresa Manful E Mark Carrington", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 37,
            'question_text' => 'Questions 37-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 36, "sub_questions": [{"id": "37", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. The parasite can remain unaffected by the host\\u2019s", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. The parasite can remain unaffected by the host\\u2019s", "correct_answer": "tsetse fly"}, {"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. because it is able to change the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. because it is able to change the", "correct_answer": "immune system"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. on its outer covering. It is uncommon among humans but has been found to affect most", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. on its outer covering. It is uncommon among humans but has been found to affect most", "correct_answer": "proteins"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in Ghana. IELTS General Reading Test 06 IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in Ghana. IELTS General Reading Test 06 IELTS General", "correct_answer": "cattle"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 8 (material_id = 108) ===
        $matId = 108;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-8',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "This wallet will suit people who prefer natural materials.", "text": "This wallet will suit people who prefer natural materials.", "correct_answer": "D"}, {"id": "2", "label": "Users of this wallet do not need to worry about taking it out in the rain.", "text": "Users of this wallet do not need to worry about taking it out in the rain.", "correct_answer": "B"}, {"id": "3", "label": "Parts of the inside of this wallet have categories printed on them in one colour.", "text": "Parts of the inside of this wallet have categories printed on them in one colour.", "correct_answer": "C"}, {"id": "4", "label": "This wallet would suit someone who needs to keep several passports together.", "text": "This wallet would suit someone who needs to keep several passports together.", "correct_answer": "F"}, {"id": "5", "label": "Something is provided for writing.", "text": "Something is provided for writing.", "correct_answer": "D"}, {"id": "6", "label": "This will suit people who want to be able to find their document wallet easily in their luggage.", "text": "This will suit people who want to be able to find their document wallet easily in their luggage.", "correct_answer": "G"}, {"id": "7", "label": "Something to keep this wallet in is provided.", "text": "Something to keep this wallet in is provided.", "correct_answer": "E"}, {"id": "8", "label": "This wallet has been specially made to prevent people detecting the numbers on any bank cards, etc. inside it. Read the text below and answer Questions 9-14. UK rail services \\u2013 how do I claim for my delayed train? Generally, if you have been delayed on a train journey, you may be able to claim compensation, but train companies all have different rules, so it can be confusing to work out what you\\u2019re entitled to. The type of delay you can claim for depends on whether the train company runs a Delay Repay scheme or a less generous, older-style scheme. Delay Repay is a train operator scheme to compensate passengers when trains are late, and the train company will pay out even if it was not responsible for the delay. The scheme varies between companies, but up to 2016 most paid 50 percent of the single ticket cost for 30 minutes\\u2019 delay and 100 percent for an hour. On the London Underground, you get a full refund for 15-minute delays. Companies that do not use Delay Repay and still use the older scheme will not usually pay compensation if the problem is considered to be out of their control. But it is still worth asking them for compensation, as some may pay out. You are unlikely to get compensation for a delay if any of the following occur: \\u2022 Accidents involving people getting onto the line illegally \\u2022 Gas leaks or fires in buildings next to the line which were not caused by a train company \\u2022 Line closures at the request of the emergency services \\u2022 Exceptionally severe weather conditions \\u2022 Strike action National Rail Conditions of Travel state that you are entitled to compensation in the same form that you paid for the ticket. Some train companies are still paying using rail vouchers, which they are allowed to do if you do not ask for a cash refund. Since 2016, rail passengers have acquired further rights for compensation through the Consumer Rights Act. This means that passengers could now be eligible for compensation due to: a severely overcrowded train with too few carriages available; a consistently late running service; and a service that is delayed for less than the time limit that applied under existing compensation schemes. However, in order to exercise their rights beyond the existing compensation schemes, for instance Delay Repay, and where the train operating company refuses to compensate despite letters threatening court action, passengers may need to bring their claims to a court of law.", "text": "This wallet has been specially made to prevent people detecting the numbers on any bank cards, etc. inside it. Read the text below and answer Questions 9-14. UK rail services \\u2013 how do I claim for my delayed train? Generally, if you have been delayed on a train journey, you may be able to claim compensation, but train companies all have different rules, so it can be confusing to work out what you\\u2019re entitled to. The type of delay you can claim for depends on whether the train company runs a Delay Repay scheme or a less generous, older-style scheme. Delay Repay is a train operator scheme to compensate passengers when trains are late, and the train company will pay out even if it was not responsible for the delay. The scheme varies between companies, but up to 2016 most paid 50 percent of the single ticket cost for 30 minutes\\u2019 delay and 100 percent for an hour. On the London Underground, you get a full refund for 15-minute delays. Companies that do not use Delay Repay and still use the older scheme will not usually pay compensation if the problem is considered to be out of their control. But it is still worth asking them for compensation, as some may pay out. You are unlikely to get compensation for a delay if any of the following occur: \\u2022 Accidents involving people getting onto the line illegally \\u2022 Gas leaks or fires in buildings next to the line which were not caused by a train company \\u2022 Line closures at the request of the emergency services \\u2022 Exceptionally severe weather conditions \\u2022 Strike action National Rail Conditions of Travel state that you are entitled to compensation in the same form that you paid for the ticket. Some train companies are still paying using rail vouchers, which they are allowed to do if you do not ask for a cash refund. Since 2016, rail passengers have acquired further rights for compensation through the Consumer Rights Act. This means that passengers could now be eligible for compensation due to: a severely overcrowded train with too few carriages available; a consistently late running service; and a service that is delayed for less than the time limit that applied under existing compensation schemes. However, in order to exercise their rights beyond the existing compensation schemes, for instance Delay Repay, and where the train operating company refuses to compensate despite letters threatening court action, passengers may need to bring their claims to a court of law.", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 9,
            'question_text' => 'Questions 9-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 8, "sub_questions": [{"id": "9", "label": "The system for claiming compensation varies from one company to another.", "text": "The system for claiming compensation varies from one company to another.", "correct_answer": "TRUE"}, {"id": "10", "label": "Under Delay Repay, a train company will only provide compensation if it caused the delay.", "text": "Under Delay Repay, a train company will only provide compensation if it caused the delay.", "correct_answer": "FALSE"}, {"id": "11", "label": "Under Delay Repay, underground and other train companies give exactly the same amounts of money in compensation.", "text": "Under Delay Repay, underground and other train companies give exactly the same amounts of money in compensation.", "correct_answer": "FALSE"}, {"id": "12", "label": "An increasing number of train companies are willing to pay compensation for problems they are not responsible for.", "text": "An increasing number of train companies are willing to pay compensation for problems they are not responsible for.", "correct_answer": "NOT GIVEN"}, {"id": "13", "label": "It is doubtful whether companies using the older scheme will provide compensation if a delay is caused by a strike.", "text": "It is doubtful whether companies using the older scheme will provide compensation if a delay is caused by a strike.", "correct_answer": "TRUE"}, {"id": "14", "label": "Passengers may receive compensation in the form of a train voucher if they forget to request cash. Advertisements", "text": "Passengers may receive compensation in the form of a train voucher if they forget to request cash. Advertisements", "correct_answer": "TRUE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-19',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Requirements: \\u2022 relevant experience \\u2022 ability to multitask \\u2022 must enjoy working in a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Requirements: \\u2022 relevant experience \\u2022 ability to multitask \\u2022 must enjoy working in a", "correct_answer": "stadium"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Responsibilities include: \\u2022 maintaining high standards of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Responsibilities include: \\u2022 maintaining high standards of", "correct_answer": "team"}, {"id": "17", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and quality \\u2022 checking the freshness of raw food \\u2022 ensuring no food is used after its expiry date \\u2022 learning the procedure for the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and quality \\u2022 checking the freshness of raw food \\u2022 ensuring no food is used after its expiry date \\u2022 learning the procedure for the", "correct_answer": "hygiene"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. of food \\u2022 doing a considerable amount of the baking Conditions: \\u2022 working hours are not", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. of food \\u2022 doing a considerable amount of the baking Conditions: \\u2022 working hours are not", "correct_answer": "storage"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2022 payment is made for holidays Read the text below and answer Questions 20-27. Setting up a business partnership in the UK Two or more people can go into business together by setting up either a limited company or a partnership. A partnership is the easier way to get started, and simply links two or more people together in a simple business structure. Unlike a limited company, a partnership doesn\\u2019t have a separate legal status. The partners are usually self-employed individuals, although a limited company counts as a \\u2018legal person\\u2019 and can also be a partner. In a partnership, you and your partner or partners personally share responsibility for your business. This means, among other things, that if your business cannot afford to pay its debts, you must pay them yourselves. Again, this is not the case with a limited company. Partners share the business\\u2019s profits, and each partner pays tax on their share. When you set up a business partnership you need to choose a name. You can trade under your own names, for example, \\u2018Smith and Jones\\u2019, or you can choose another name for your business. You don\\u2019t need to register your name. However, you should register your name as a trademark if you want to stop people from trading under your business name. Business partnership names must not include \\u2018limited\\u2019, \\u2018Ltd\\u2019, \\u2018limited liability partnership\\u2019, LLP\\u2019, \\u2018public limited company\\u2019 or \\u2018pic\\u2019, be offensive, or be the same as an existing trademark. Your name also can\\u2019t suggest a connection with government or local authorities, unless you get permission. There is no central database of partnership names in the UK, so to avoid using the same name as another business, it is advisable to search on the internet for the name you are considering. You must include all the partners\\u2019 names and the business name (if you have one) on official paperwork, for example invoices. You must choose a \\u2018nominated partner\\u2019 who is responsible for registering your partnership with HM Revenue and Customs (HMRC), the government department responsible for the collection of taxes. This person is responsible for managing the partnership\\u2019s tax returns and keeping business records. Alternatively, you can appoint an agent to deal with HMRC on your behalf. All partners need to register with HMRC separately and send their own tax returns as individuals. You must register by 5 October in your business\\u2019s second tax year, or you could be charged a penalty. You must also register for VAT if your VAT taxable turnover is more than \\u00a385,000. You can choose to register if it\\u2019s below this, for example to reclaim VAT on business supplies.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2022 payment is made for holidays Read the text below and answer Questions 20-27. Setting up a business partnership in the UK Two or more people can go into business together by setting up either a limited company or a partnership. A partnership is the easier way to get started, and simply links two or more people together in a simple business structure. Unlike a limited company, a partnership doesn\\u2019t have a separate legal status. The partners are usually self-employed individuals, although a limited company counts as a \\u2018legal person\\u2019 and can also be a partner. In a partnership, you and your partner or partners personally share responsibility for your business. This means, among other things, that if your business cannot afford to pay its debts, you must pay them yourselves. Again, this is not the case with a limited company. Partners share the business\\u2019s profits, and each partner pays tax on their share. When you set up a business partnership you need to choose a name. You can trade under your own names, for example, \\u2018Smith and Jones\\u2019, or you can choose another name for your business. You don\\u2019t need to register your name. However, you should register your name as a trademark if you want to stop people from trading under your business name. Business partnership names must not include \\u2018limited\\u2019, \\u2018Ltd\\u2019, \\u2018limited liability partnership\\u2019, LLP\\u2019, \\u2018public limited company\\u2019 or \\u2018pic\\u2019, be offensive, or be the same as an existing trademark. Your name also can\\u2019t suggest a connection with government or local authorities, unless you get permission. There is no central database of partnership names in the UK, so to avoid using the same name as another business, it is advisable to search on the internet for the name you are considering. You must include all the partners\\u2019 names and the business name (if you have one) on official paperwork, for example invoices. You must choose a \\u2018nominated partner\\u2019 who is responsible for registering your partnership with HM Revenue and Customs (HMRC), the government department responsible for the collection of taxes. This person is responsible for managing the partnership\\u2019s tax returns and keeping business records. Alternatively, you can appoint an agent to deal with HMRC on your behalf. All partners need to register with HMRC separately and send their own tax returns as individuals. You must register by 5 October in your business\\u2019s second tax year, or you could be charged a penalty. You must also register for VAT if your VAT taxable turnover is more than \\u00a385,000. You can choose to register if it\\u2019s below this, for example to reclaim VAT on business supplies.", "correct_answer": "guaranteed"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 20,
            'question_text' => 'Questions 20–27',
            'type' => 'summary_completion',
            'options' => '{"A": "partnership is different from a limited company in not having its own \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. as a legal body."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 19, "sub_questions": [{"id": "20", "label": "Question 20", "text": "Question 20", "correct_answer": "status"}, {"id": "21", "label": "The partners are personally responsible for paying all the partnership\\u2019s \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. .", "text": "The partners are personally responsible for paying all the partnership\\u2019s \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. .", "correct_answer": "debts"}, {"id": "22", "label": "The partnership\\u2019s \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. are divided between the partners.", "text": "The partnership\\u2019s \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. are divided between the partners.", "correct_answer": "profits"}, {"id": "23", "label": "Registering the partnership\\u2019s name prevents others from using that name when \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. .", "text": "Registering the partnership\\u2019s name prevents others from using that name when \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. .", "correct_answer": "trading"}, {"id": "24", "label": "The best way to find out if a name is already in use is to use the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. .", "text": "The best way to find out if a name is already in use is to use the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. .", "correct_answer": "internet"}, {"id": "25", "label": "The names of the partners and the partnership must appear on \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and other documents.", "text": "The names of the partners and the partnership must appear on \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and other documents.", "correct_answer": "invoices"}, {"id": "26", "label": "You must have a nominated partner, or someone to act as your \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026., for all contact with HMRC.", "text": "You must have a nominated partner, or someone to act as your \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026., for all contact with HMRC.", "correct_answer": "agent"}, {"id": "27", "label": "You will have to pay a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. if you miss the deadline for registering the partnership. Advertisements", "text": "You will have to pay a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. if you miss the deadline for registering the partnership. Advertisements", "correct_answer": "penatly"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-32',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "When comparing the Swiss transportation system to a tree, the writer emphasises A the size of the postbus system. B how competitive the postbus system is. C how important the postbus system is. D the threat to the postbus system.", "text": "When comparing the Swiss transportation system to a tree, the writer emphasises A the size of the postbus system. B how competitive the postbus system is. C how important the postbus system is. D the threat to the postbus system.", "correct_answer": "C"}, {"id": "29", "label": "What is said about bus services in the second paragraph? A Villages have the chance to request more buses every four years. B New routes are often introduced to reflect an increase in population. C Bus timetables tend to change every four years. D The number of buses that call at a village depends on how many people live there.", "text": "What is said about bus services in the second paragraph? A Villages have the chance to request more buses every four years. B New routes are often introduced to reflect an increase in population. C Bus timetables tend to change every four years. D The number of buses that call at a village depends on how many people live there.", "correct_answer": "D"}, {"id": "30", "label": "According to the fourth paragraph, what were three-tone horns first used to indicate? A how many coach horses required food B how long the bus would stay at the station C how many passengers wanted a meal D how soon the bus would arrive at the station", "text": "According to the fourth paragraph, what were three-tone horns first used to indicate? A how many coach horses required food B how long the bus would stay at the station C how many passengers wanted a meal D how soon the bus would arrive at the station", "correct_answer": "A"}, {"id": "31", "label": "What point does the writer make about the postbus drivers? A Many choose to give passengers information about the surroundings. B Most are proud of driving buses to places without other forms of transport. C They are required to inform passengers about the sights seen from the bus. D They are not allowed to stop for passengers to take photographs.", "text": "What point does the writer make about the postbus drivers? A Many choose to give passengers information about the surroundings. B Most are proud of driving buses to places without other forms of transport. C They are required to inform passengers about the sights seen from the bus. D They are not allowed to stop for passengers to take photographs.", "correct_answer": "A"}, {"id": "32", "label": "What is said about the buses\\u2019 automated announcements? A They are given in the language of the bus\'s starting point. B The language they are given in depends on where the bus is at the time. C They are always given in all the four languages of Switzerland. D The language they are given in depends on the bus\'s destination.", "text": "What is said about the buses\\u2019 automated announcements? A They are given in the language of the bus\'s starting point. B The language they are given in depends on where the bus is at the time. C They are always given in all the four languages of Switzerland. D The language they are given in depends on the bus\'s destination.", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 33,
            'question_text' => 'Questions 33-40',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 32, "sub_questions": [{"id": "33", "label": "Some postbuses after the First World War were originally army vehicles.", "text": "Some postbuses after the First World War were originally army vehicles.", "correct_answer": "TRUE"}, {"id": "34", "label": "The number of driverless buses has increased steadily since 2015.", "text": "The number of driverless buses has increased steadily since 2015.", "correct_answer": "NOT GIVEN"}, {"id": "35", "label": "On the longest postbus route in Switzerland, passengers have to change buses.", "text": "On the longest postbus route in Switzerland, passengers have to change buses.", "correct_answer": "FALSE"}, {"id": "36", "label": "The weather on the longest postbus route is likely to include extreme weather conditions.", "text": "The weather on the longest postbus route is likely to include extreme weather conditions.", "correct_answer": "TRUE"}, {"id": "37", "label": "There is a widely used nickname for part of the longest route used by postbuses.", "text": "There is a widely used nickname for part of the longest route used by postbuses.", "correct_answer": "TRUE"}, {"id": "38", "label": "Bus drivers\\u2019 training can be shortened if they have driven buses before joining PostBus.", "text": "Bus drivers\\u2019 training can be shortened if they have driven buses before joining PostBus.", "correct_answer": "FALSE"}, {"id": "39", "label": "In some villages most passengers are school children.", "text": "In some villages most passengers are school children.", "correct_answer": "NOT GIVEN"}, {"id": "40", "label": "Buses carry only rubbish that can be recycled. IELTS General Reading Test 07 IELTS General", "text": "Buses carry only rubbish that can be recycled. IELTS General Reading Test 07 IELTS General", "correct_answer": "NOT GIVEN"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 9 (material_id = 109) ===
        $matId = 109;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "This suitcase is for those who wish to purchase expensive luggage.", "text": "This suitcase is for those who wish to purchase expensive luggage.", "correct_answer": "B"}, {"id": "2", "label": "This suitcase is the right one for people who like to follow the latest fashion.", "text": "This suitcase is the right one for people who like to follow the latest fashion.", "correct_answer": "F"}, {"id": "3", "label": "It is easy to choose one of these suitcases to match most clothing.", "text": "It is easy to choose one of these suitcases to match most clothing.", "correct_answer": "D"}, {"id": "4", "label": "The manufacturer is confident that this suitcase will last a long time.", "text": "The manufacturer is confident that this suitcase will last a long time.", "correct_answer": "E"}, {"id": "5", "label": "Items in this suitcase will not be affected if it gets wet.", "text": "Items in this suitcase will not be affected if it gets wet.", "correct_answer": "A"}, {"id": "6", "label": "This suitcase is of a useful, medium size.", "text": "This suitcase is of a useful, medium size.", "correct_answer": "E"}, {"id": "7", "label": "Those who want to be reminded of an earlier age of travel will like this suitcase. Read the text below and answer Questions 8-14. THE OXFORD SCHOOL OF DRAMA One-Year Acting Course This is an intensive course which is designed for those who have completed their academic studies and have some theatre or film experience already. In order to be accepted, you should be a high achiever, knowledgeable about the industry and determined to succeed. Term One: Technical classes in acting, voice, movement, applied movement and characterisation, music, singing, film, radio and professional development. The term finishes with an internal production given for tutors and students. Term Two: All technical classes continue from term one. There is an internal performance of a one-act play, the recording of an audio showreel at a professional studio and the Showcase Drama in front of an invited audience including casting directors and agents. Term Three: Technical classes continue with additional focus on audition technique, workshops and masterclasses. This term includes a public performance of a play outdoors in the grounds of Blenheim Palace, and the chance to act a short film recorded on location by a professional crew. How to Apply Entry to The Oxford School of Drama is by audition only and there are no academic requirements for any of our courses. Once we have received your application form and audition fee, we will email you with a date for your audition and further details about what to expect when you are here. For your initial audition, you will need to prepare two contrasting speeches from plays, lasting no longer than two minutes. There will also be some group work for which you will need to wear loose, comfortable clothing. If you are applying from overseas, you will be able to submit your first audition by means of DVD, YouTube or link to a secure website. You will be invited to submit this once we have received your application form and audition fee. If you are successful in your first audition, you will be invited to attend future auditions here at the school. The school will provide a free bus from central Oxford for those attending auditions.", "text": "Those who want to be reminded of an earlier age of travel will like this suitcase. Read the text below and answer Questions 8-14. THE OXFORD SCHOOL OF DRAMA One-Year Acting Course This is an intensive course which is designed for those who have completed their academic studies and have some theatre or film experience already. In order to be accepted, you should be a high achiever, knowledgeable about the industry and determined to succeed. Term One: Technical classes in acting, voice, movement, applied movement and characterisation, music, singing, film, radio and professional development. The term finishes with an internal production given for tutors and students. Term Two: All technical classes continue from term one. There is an internal performance of a one-act play, the recording of an audio showreel at a professional studio and the Showcase Drama in front of an invited audience including casting directors and agents. Term Three: Technical classes continue with additional focus on audition technique, workshops and masterclasses. This term includes a public performance of a play outdoors in the grounds of Blenheim Palace, and the chance to act a short film recorded on location by a professional crew. How to Apply Entry to The Oxford School of Drama is by audition only and there are no academic requirements for any of our courses. Once we have received your application form and audition fee, we will email you with a date for your audition and further details about what to expect when you are here. For your initial audition, you will need to prepare two contrasting speeches from plays, lasting no longer than two minutes. There will also be some group work for which you will need to wear loose, comfortable clothing. If you are applying from overseas, you will be able to submit your first audition by means of DVD, YouTube or link to a secure website. You will be invited to submit this once we have received your application form and audition fee. If you are successful in your first audition, you will be invited to attend future auditions here at the school. The school will provide a free bus from central Oxford for those attending auditions.", "correct_answer": "G"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "Students can begin the one-year course without any previous involvement in acting.", "text": "Students can begin the one-year course without any previous involvement in acting.", "correct_answer": "FALSE"}, {"id": "9", "label": "Students will act in a performance in front of their classmates at the end of the first term.", "text": "Students will act in a performance in front of their classmates at the end of the first term.", "correct_answer": "TRUE"}, {"id": "10", "label": "Family members may attend a performance during the second term.", "text": "Family members may attend a performance during the second term.", "correct_answer": "NOT GIVEN"}, {"id": "11", "label": "Students are required to make a film on their own in the last term of the course.", "text": "Students are required to make a film on their own in the last term of the course.", "correct_answer": "FALSE"}, {"id": "12", "label": "In their first audition, candidates perform speeches they have worked on in advance.", "text": "In their first audition, candidates perform speeches they have worked on in advance.", "correct_answer": "TRUE"}, {"id": "13", "label": "The Oxford School of Drama will send candidates details of local accommodation.", "text": "The Oxford School of Drama will send candidates details of local accommodation.", "correct_answer": "NOT GIVEN"}, {"id": "14", "label": "Overseas candidates can do all their auditions via a digital link. Advertisements", "text": "Overseas candidates can do all their auditions via a digital link. Advertisements", "correct_answer": "FALSE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 details and current vehicle inspection documents. \\u2193 Before arriving at the border Check that documents such as", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 details and current vehicle inspection documents. \\u2193 Before arriving at the border Check that documents such as", "correct_answer": "shipment"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 and birth certificate/passport are ready for inspection. Make sure the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 and birth certificate/passport are ready for inspection. Make sure the", "correct_answer": "photo ID"}, {"id": "17", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 are on inside the vehicle. Check that the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 are on inside the vehicle. Check that the", "correct_answer": "lights"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in the vehicle can be easily seen. \\u2193 At the border (Primary Inspection) This may be the only stop if paperwork is in order.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in the vehicle can be easily seen. \\u2193 At the border (Primary Inspection) This may be the only stop if paperwork is in order.", "correct_answer": "sleeper areas"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 area to complete an I-94 card (there is a small", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 area to complete an I-94 card (there is a small", "correct_answer": "immigration"}, {"id": "20", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 for this) and to receive verbal clearance. \\u2193 At the border (Secondary Inspection) If there is a problem with paperwork, you will be sent to Truck Inspection. Read the text below and answer Questions 21-27. Appendix: Dealing with absence in the workplace This appendix considers how to handle problems of absence and gives guidance about authorised and unauthorised absence of employees from work. The organisation should be aware of the rights of employees and in particular the requirements of the Equality Act 201O when making any decisions about absences of employees who are disabled. In these cases, the employer should consider what reasonable adjustments could be made in the workplace to help the employee. This might be something as simple as supplying an appropriate chair for the use of the employee. In cases where an employee suffers from an allergy caused by something in the workplace, the employer should consider remedial action or a transfer to alternative work. If the absence is because of temporary difficulties relating to dependants, the employee may be entitled to have time off under the provisions of the Employment Rights Act 1996. In cases where the employee has difficulty managing both work and home responsibilities, employees have the right to request flexible ways of working, such as job-sharing, and employers must have a good business reason for rejecting any such application. Employers should investigate unexpected absences promptly and the employee should be asked for an explanation at a return-to-work interview. In order to show both the employee concerned and other employees that absence is regarded as a serious matter and may result in dismissal, it is very important that persistent absence is dealt with firmly and consistently. Records showing lateness and the duration of and explanations for all spells of absence should be kept to help monitor levels of absence or lateness. If the employer wishes to contact the employee\\u2019s doctor for more information about a medical condition, he or she must notify the employee in writing that they intend to make such an application and they must secure the employee\\u2019s consent in writing. Consideration should be given to introducing measures to help employees, regardless of status or seniority, who may be suffering from stress. The aim should be to identify employees affected and encourage them to seek help and treatment.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 for this) and to receive verbal clearance. \\u2193 At the border (Secondary Inspection) If there is a problem with paperwork, you will be sent to Truck Inspection. Read the text below and answer Questions 21-27. Appendix: Dealing with absence in the workplace This appendix considers how to handle problems of absence and gives guidance about authorised and unauthorised absence of employees from work. The organisation should be aware of the rights of employees and in particular the requirements of the Equality Act 201O when making any decisions about absences of employees who are disabled. In these cases, the employer should consider what reasonable adjustments could be made in the workplace to help the employee. This might be something as simple as supplying an appropriate chair for the use of the employee. In cases where an employee suffers from an allergy caused by something in the workplace, the employer should consider remedial action or a transfer to alternative work. If the absence is because of temporary difficulties relating to dependants, the employee may be entitled to have time off under the provisions of the Employment Rights Act 1996. In cases where the employee has difficulty managing both work and home responsibilities, employees have the right to request flexible ways of working, such as job-sharing, and employers must have a good business reason for rejecting any such application. Employers should investigate unexpected absences promptly and the employee should be asked for an explanation at a return-to-work interview. In order to show both the employee concerned and other employees that absence is regarded as a serious matter and may result in dismissal, it is very important that persistent absence is dealt with firmly and consistently. Records showing lateness and the duration of and explanations for all spells of absence should be kept to help monitor levels of absence or lateness. If the employer wishes to contact the employee\\u2019s doctor for more information about a medical condition, he or she must notify the employee in writing that they intend to make such an application and they must secure the employee\\u2019s consent in writing. Consideration should be given to introducing measures to help employees, regardless of status or seniority, who may be suffering from stress. The aim should be to identify employees affected and encourage them to seek help and treatment.", "correct_answer": "charge"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 provision of arrangements to deal with any work-related", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 provision of arrangements to deal with any work-related", "correct_answer": "chair"}, {"id": "22", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 time off work to deal with short-term problems of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 time off work to deal with short-term problems of", "correct_answer": "allergy"}, {"id": "23", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 possibility of arrangements that are", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 possibility of arrangements that are", "correct_answer": "dependants"}, {"id": "24", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to help with domestic responsibilities Recommendations to employers \\u2022 make it clear that absence is a possible reason for", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to help with domestic responsibilities Recommendations to employers \\u2022 make it clear that absence is a possible reason for", "correct_answer": "flexible"}, {"id": "25", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 ask employees for consent before contacting their", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2022 ask employees for consent before contacting their", "correct_answer": "dismissal"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . \\u2022 identify employees affected by", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . \\u2022 identify employees affected by", "correct_answer": "doctor"}, {"id": "27", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 and provide support Advertisements", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 and provide support Advertisements", "correct_answer": "stress"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-36',
            'type' => 'matching_headings',
            'options' => '{"A": "contrast in the landscape"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Paragraph A", "text": "Paragraph A", "correct_answer": "ix"}, {"id": "29", "label": "Paragraph B", "text": "Paragraph B", "correct_answer": "iv"}, {"id": "30", "label": "Paragraph C", "text": "Paragraph C", "correct_answer": "ii"}, {"id": "31", "label": "Paragraph D", "text": "Paragraph D", "correct_answer": "iii"}, {"id": "32", "label": "Paragraph E", "text": "Paragraph E", "correct_answer": "vi"}, {"id": "33", "label": "Paragraph F", "text": "Paragraph F", "correct_answer": "x"}, {"id": "34", "label": "Paragraph G", "text": "Paragraph G", "correct_answer": "vii"}, {"id": "35", "label": "Paragraph H", "text": "Paragraph H", "correct_answer": "i"}, {"id": "36", "label": "Paragraph I", "text": "Paragraph I", "correct_answer": "viii"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 37,
            'question_text' => 'Questions 37-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 36, "sub_questions": [{"id": "37", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 which would prevent the temperature from falling so low. The town is located in a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 which would prevent the temperature from falling so low. The town is located in a", "correct_answer": "ocean"}, {"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 within a plateau surrounded by", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 within a plateau surrounded by", "correct_answer": "valley"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 Because there is not much", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 Because there is not much", "correct_answer": "mountains"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 cold air collects in the town. IELTS General Reading Test 08 IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 cold air collects in the town. IELTS General Reading Test 08 IELTS General", "correct_answer": "wind"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 10 (material_id = 110) ===
        $matId = 110;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "The room available has two beds.", "text": "The room available has two beds.", "correct_answer": "FALSE"}, {"id": "2", "label": "The Australian in Sasha\\u2019s apartment is a musician.", "text": "The Australian in Sasha\\u2019s apartment is a musician.", "correct_answer": "TRUE"}, {"id": "3", "label": "Sasha does all the cleaning in the apartment.", "text": "Sasha does all the cleaning in the apartment.", "correct_answer": "FALSE"}, {"id": "4", "label": "Sasha likes being in the open air.", "text": "Sasha likes being in the open air.", "correct_answer": "TRUE"}, {"id": "5", "label": "The room available would be suitable for someone who likes to be quiet.", "text": "The room available would be suitable for someone who likes to be quiet.", "correct_answer": "TRUE"}, {"id": "6", "label": "Sasha thinks her apartment is in the best part of Toronto.", "text": "Sasha thinks her apartment is in the best part of Toronto.", "correct_answer": "NOT GIVEN"}, {"id": "7", "label": "Sasha has never had a roommate from Canada. Read the text below and answer Questions 8-14. Smartphone fitness apps", "text": "Sasha has never had a roommate from Canada. Read the text below and answer Questions 8-14. Smartphone fitness apps", "correct_answer": "NOT GIVEN"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "This app can be used for more than one sport.", "text": "This app can be used for more than one sport.", "correct_answer": "C"}, {"id": "9", "label": "You have to pay if you want this app to suggest where you can go.", "text": "You have to pay if you want this app to suggest where you can go.", "correct_answer": "D"}, {"id": "10", "label": "This app has well-presented visuals.", "text": "This app has well-presented visuals.", "correct_answer": "D"}, {"id": "11", "label": "You do not have to pay for any of the features on this app.", "text": "You do not have to pay for any of the features on this app.", "correct_answer": "A"}, {"id": "12", "label": "You can pay to download true stories on this app.", "text": "You can pay to download true stories on this app.", "correct_answer": "B"}, {"id": "13", "label": "You can get ideas about where to go from other people on this app.", "text": "You can get ideas about where to go from other people on this app.", "correct_answer": "C"}, {"id": "14", "label": "This app gives you details of the energy you have used. Advertisements", "text": "This app gives you details of the energy you have used. Advertisements", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "good CV should be clear, simple and easy to understand. Here are four of the most popular CV formats and advice on when to use them:"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "Ensure team members are aware of any \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 there are regarding how the work should be presented.", "text": "Ensure team members are aware of any \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 there are regarding how the work should be presented.", "correct_answer": "expectations"}, {"id": "16", "label": "Make sure support is made available if any \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 exist as to the team member\\u2019s ability to do the work.", "text": "Make sure support is made available if any \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 exist as to the team member\\u2019s ability to do the work.", "correct_answer": "concerns"}, {"id": "17", "label": "Ask the team member to detail how the work is developing, for example by providing a regular \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "Ask the team member to detail how the work is developing, for example by providing a regular \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "report"}, {"id": "18", "label": "Don\\u2019t delegate administrative tasks simply because they are \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "Don\\u2019t delegate administrative tasks simply because they are \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "dull"}, {"id": "19", "label": "Managers can ask a team member to check on the achievement of \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 at fixed intervals.", "text": "Managers can ask a team member to check on the achievement of \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 at fixed intervals.", "correct_answer": "targets"}, {"id": "20", "label": "If you \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you risk delaying the whole project. Read the text below and answer Questions 21-27. Choosing the right format for your CV", "text": "If you \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you risk delaying the whole project. Read the text below and answer Questions 21-27. Choosing the right format for your CV", "correct_answer": "micromanage"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in most cases \\u2013 perhaps inappropriate if there are periods where", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in most cases \\u2013 perhaps inappropriate if there are periods where", "correct_answer": "flexibility"}, {"id": "22", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. is not easy to explain Functional \\u2013 appropriate for people who intend to follow a new", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. is not easy to explain Functional \\u2013 appropriate for people who intend to follow a new", "correct_answer": "unemployment"}, {"id": "23", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in their career \\u2013 suits recent graduates \\u2013 can create", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in their career \\u2013 suits recent graduates \\u2013 can create", "correct_answer": "direction"}, {"id": "24", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in recruiters, so is best used with caution Achievement \\u2013 focuses mainly on what the person has achieved \\u2013 may be advisable if the person has no", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in recruiters, so is best used with caution Achievement \\u2013 focuses mainly on what the person has achieved \\u2013 may be advisable if the person has no", "correct_answer": "suspicion"}, {"id": "25", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in the area \\u2013 enables use of attractive", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in the area \\u2013 enables use of attractive", "correct_answer": "experience"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to present data \\u2013 suits applications for jobs in marketing or", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to present data \\u2013 suits applications for jobs in marketing or", "correct_answer": "graphics"}, {"id": "27", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Advertisements", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. Advertisements", "correct_answer": "media"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-32',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . It is thought to have eaten", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . It is thought to have eaten", "correct_answer": "sheep"}, {"id": "29", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and it used its", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. and it used its", "correct_answer": "shellfish"}, {"id": "30", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to get through their hard exterior. The fossil of Tongtianlong was found surrounded by", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. to get through their hard exterior. The fossil of Tongtianlong was found surrounded by", "correct_answer": "beak"}, {"id": "31", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. under the ground where the foundations of a new", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. under the ground where the foundations of a new", "correct_answer": "rock"}, {"id": "32", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. were being dug.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. were being dug.", "correct_answer": "school"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 33,
            'question_text' => 'Questions 33-37',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 32, "sub_questions": [{"id": "33", "label": "What does the writer suggest about finding new dinosaurs? A Many scientists dream of being able to do so one day. B It is probable that most have now been discovered. C People are running out of places to look for them. D It is becoming relatively common to dig one up.", "text": "What does the writer suggest about finding new dinosaurs? A Many scientists dream of being able to do so one day. B It is probable that most have now been discovered. C People are running out of places to look for them. D It is becoming relatively common to dig one up.", "correct_answer": "D"}, {"id": "34", "label": "In the fourth paragraph, what does the writer suggest about palaeontologists? A They should study the fossilised bones of dinosaurs more closely. B Their theories are based on evidence that can be interpreted in different ways. C It is impossible to have any confidence in the proposals they have made. D It is worrying that they still cannot agree about dinosaurs\\u2019 body temperature.", "text": "In the fourth paragraph, what does the writer suggest about palaeontologists? A They should study the fossilised bones of dinosaurs more closely. B Their theories are based on evidence that can be interpreted in different ways. C It is impossible to have any confidence in the proposals they have made. D It is worrying that they still cannot agree about dinosaurs\\u2019 body temperature.", "correct_answer": "B"}, {"id": "35", "label": "When describing the theory of how dinosaurs began to fly, the writer is A amused that their flight probably came about by chance. B surprised by the reason for the initial development of feathers. C excited by the different possibilities it holds for future research. D confused that feathers were also present on some creatures\\u2019 legs.", "text": "When describing the theory of how dinosaurs began to fly, the writer is A amused that their flight probably came about by chance. B surprised by the reason for the initial development of feathers. C excited by the different possibilities it holds for future research. D confused that feathers were also present on some creatures\\u2019 legs.", "correct_answer": "C"}, {"id": "36", "label": "One significance of melanosomes is that they A provide further evidence of where birds evolved from. B are only found in certain parts of the world. C can be clearly seen in most fossilised feathers. D are only found in certain birds and dinosaurs.", "text": "One significance of melanosomes is that they A provide further evidence of where birds evolved from. B are only found in certain parts of the world. C can be clearly seen in most fossilised feathers. D are only found in certain birds and dinosaurs.", "correct_answer": "A"}, {"id": "37", "label": "Which of the following best summarises the writer\\u2019s point in the final paragraph? A Scientists are right to continue questioning the effects of the asteroid strike. B Large flightless dinosaurs may have existed after the asteroid hit. C The dinosaurs were already declining before the asteroid hit. D The effects of the asteroid strike killed most dinosaurs.", "text": "Which of the following best summarises the writer\\u2019s point in the final paragraph? A Scientists are right to continue questioning the effects of the asteroid strike. B Large flightless dinosaurs may have existed after the asteroid hit. C The dinosaurs were already declining before the asteroid hit. D The effects of the asteroid strike killed most dinosaurs.", "correct_answer": "D"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 38,
            'question_text' => 'Questions 38-40) and the list of prehistoric animals below.',
            'type' => 'matching_features',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 37, "sub_questions": [{"id": "38", "label": "It may have used its feathers to frighten off members of the same species.", "text": "It may have used its feathers to frighten off members of the same species.", "correct_answer": "D"}, {"id": "39", "label": "This species resembles a large flightless bird that exists today.", "text": "This species resembles a large flightless bird that exists today.", "correct_answer": "D"}, {"id": "40", "label": "Finding this species made scientists revise their opinion of the brain power of dinosaurs. List of Prehistoric Animals A Tongtianlong B Tyrannosaurus Rex C Deinonychus D Ornithomimosaur IELTS General Reading Test 09 IELTS General", "text": "Finding this species made scientists revise their opinion of the brain power of dinosaurs. List of Prehistoric Animals A Tongtianlong B Tyrannosaurus Rex C Deinonychus D Ornithomimosaur IELTS General Reading Test 09 IELTS General", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 11 (material_id = 111) ===
        $matId = 111;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "The idea behind NYLSO was based on another orchestra.", "text": "The idea behind NYLSO was based on another orchestra.", "correct_answer": "TRUE"}, {"id": "2", "label": "An ability to read music is essential.", "text": "An ability to read music is essential.", "correct_answer": "TRUE"}, {"id": "3", "label": "The NYLSO might be unsuitable for very advanced level musicians.", "text": "The NYLSO might be unsuitable for very advanced level musicians.", "correct_answer": "TRUE"}, {"id": "4", "label": "NYLSO concerts are free to members\\u2019 families and friends.", "text": "NYLSO concerts are free to members\\u2019 families and friends.", "correct_answer": "NOT GIVEN"}, {"id": "5", "label": "Rehearsals always involve the full orchestra playing together.", "text": "Rehearsals always involve the full orchestra playing together.", "correct_answer": "FALSE"}, {"id": "6", "label": "The conductor provides her services free to NYLSO.", "text": "The conductor provides her services free to NYLSO.", "correct_answer": "FALSE"}, {"id": "7", "label": "The NYLSO gives advice on what instrument to purchase. Read the advertisements below and answer Questions 8-14. The 7 best running watches Kate Hilpern advises people on the best watches to use when they go running.", "text": "The NYLSO gives advice on what instrument to purchase. Read the advertisements below and answer Questions 8-14. The 7 best running watches Kate Hilpern advises people on the best watches to use when they go running.", "correct_answer": "NOT GIVEN"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "This would be a suitable and not too expensive first watch for a runner.", "text": "This would be a suitable and not too expensive first watch for a runner.", "correct_answer": "E"}, {"id": "9", "label": "Care has been taken to make this watch very attractive to look at.", "text": "Care has been taken to make this watch very attractive to look at.", "correct_answer": "F"}, {"id": "10", "label": "This watch can be programmed to let the runner know when it is time to get some refreshment.", "text": "This watch can be programmed to let the runner know when it is time to get some refreshment.", "correct_answer": "D"}, {"id": "11", "label": "This watch will need recharging at frequent intervals.", "text": "This watch will need recharging at frequent intervals.", "correct_answer": "C"}, {"id": "12", "label": "Both experienced and inexperienced runners will find this watch useful.", "text": "Both experienced and inexperienced runners will find this watch useful.", "correct_answer": "D"}, {"id": "13", "label": "Runners will find all the features on this watch are useful.", "text": "Runners will find all the features on this watch are useful.", "correct_answer": "A"}, {"id": "14", "label": "People who do most of their running in cities may find this watch is not appropriate for them. Advertisements", "text": "People who do most of their running in cities may find this watch is not appropriate for them. Advertisements", "correct_answer": "G"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-22',
            'type' => 'summary_completion',
            'options' => '{"A": "Advance warning", "B": "Information about financial systems", "C": "Purchasing Manager", "D": "We\\u2019re doing well!", "E": "Quality control", "F": "New opportunity", "G": "And finally\\u2026"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. and include the following: \\u2013 employers should manage any potential dangers to their staff\\u2019s health and safety \\u2013 any", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. and include the following: \\u2013 employers should manage any potential dangers to their staff\\u2019s health and safety \\u2013 any", "correct_answer": "law"}, {"id": "16", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. needed for employees to work safely should be free \\u2013 employees may inform management of any", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. needed for employees to work safely should be free \\u2013 employees may inform management of any", "correct_answer": "equipment"}, {"id": "17", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. they have relating to health and safety \\u2013 employees are entitled to some", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. they have relating to health and safety \\u2013 employees are entitled to some", "correct_answer": "concerns"}, {"id": "18", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. while they are working Employees\\u2019 responsibilities \\u2013 to take off jewellery and dress appropriately for their particular work \\u2013 to avoid putting colleagues and others at", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. while they are working Employees\\u2019 responsibilities \\u2013 to take off jewellery and dress appropriately for their particular work \\u2013 to avoid putting colleagues and others at", "correct_answer": "breaks"}, {"id": "19", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2013 to do any", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. \\u2013 to do any", "correct_answer": "risk"}, {"id": "20", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. that the employer offers \\u2013 to inform the employer of any", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. that the employer offers \\u2013 to inform the employer of any", "correct_answer": "training"}, {"id": "21", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. received while working \\u2013 to make sure the employer knows of any", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. received while working \\u2013 to make sure the employer knows of any", "correct_answer": "injuries"}, {"id": "22", "label": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. you are taking that might affect performance. Read the text below and answer Questions 23-27. Our company notices", "text": "\\u2026.\\u2026\\u2026\\u2026\\u2026\\u2026. you are taking that might affect performance. Read the text below and answer Questions 23-27. Our company notices", "correct_answer": "medication"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 23,
            'question_text' => 'Questions 23-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 22, "sub_questions": [{"id": "23", "label": "Staff are needed to work on internal communications.", "text": "Staff are needed to work on internal communications.", "correct_answer": "F"}, {"id": "24", "label": "People are needed to help improve an internal system.", "text": "People are needed to help improve an internal system.", "correct_answer": "E"}, {"id": "25", "label": "Staff are asked if they want to take part in an internal competition.", "text": "Staff are asked if they want to take part in an internal competition.", "correct_answer": "G"}, {"id": "26", "label": "Volunteers are asked to work overtime for a limited period.", "text": "Volunteers are asked to work overtime for a limited period.", "correct_answer": "D"}, {"id": "27", "label": "Staff will be told where to work temporarily. Advertisements", "text": "Staff will be told where to work temporarily. Advertisements", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-31) and the list of countries below.',
            'type' => 'matching_features',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "The vanilla that is grown here was created from more than one type of vanilla plant.", "text": "The vanilla that is grown here was created from more than one type of vanilla plant.", "correct_answer": "C"}, {"id": "29", "label": "This vanilla is often mixed with other types of vanilla.", "text": "This vanilla is often mixed with other types of vanilla.", "correct_answer": "D"}, {"id": "30", "label": "Some people claim that this country produces the finest vanilla.", "text": "Some people claim that this country produces the finest vanilla.", "correct_answer": "B"}, {"id": "31", "label": "This vanilla goes well with both sweet and savoury ingredients. List of Countries A Mexico B Madagascar C Tahiti D Indonesia", "text": "This vanilla goes well with both sweet and savoury ingredients. List of Countries A Mexico B Madagascar C Tahiti D Indonesia", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 32,
            'question_text' => 'Questions 32-34',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 31, "sub_questions": [{"id": "32", "label": "What prevented countries, apart from Mexico, from growing vanilla in the 17th and 18th centuries? A the Aztecs\\u2019 refusal to let the pods be exported B the lack of the most suitable pollinating insect C the widespread ignorance of the existence of the plant D the poor condition of the vanilla pods that Cortez collected", "text": "What prevented countries, apart from Mexico, from growing vanilla in the 17th and 18th centuries? A the Aztecs\\u2019 refusal to let the pods be exported B the lack of the most suitable pollinating insect C the widespread ignorance of the existence of the plant D the poor condition of the vanilla pods that Cortez collected", "correct_answer": "B"}, {"id": "33", "label": "What does the writer suggest was the main reason for the success of vanilla cultivation on Madagascar? A the adoption of a particular agricultural technique B the type of vanilla orchid that was selected C the unique quality of the soil on the island D the rapidly increasing number of growers", "text": "What does the writer suggest was the main reason for the success of vanilla cultivation on Madagascar? A the adoption of a particular agricultural technique B the type of vanilla orchid that was selected C the unique quality of the soil on the island D the rapidly increasing number of growers", "correct_answer": "A"}, {"id": "34", "label": "The writer believes that Madagascan vanilla is so popular because A it works well in a variety of main courses and puddings. B its pod is less likely than others to break up when it is cooked. C its taste is widely considered to be the standard taste of vanilla. D it is the one that is used in a number of commercial frozen desserts.", "text": "The writer believes that Madagascan vanilla is so popular because A it works well in a variety of main courses and puddings. B its pod is less likely than others to break up when it is cooked. C its taste is widely considered to be the standard taste of vanilla. D it is the one that is used in a number of commercial frozen desserts.", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 35,
            'question_text' => 'Questions 35-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 34, "sub_questions": [{"id": "35", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 all over. They then wash them quickly before the main stage of the curing process begins. They place the pods in the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 all over. They then wash them quickly before the main stage of the curing process begins. They place the pods in the", "correct_answer": "brown"}, {"id": "36", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 during the early part of the day. Cloths are then wrapped round them and they are left in boxes overnight. This procedure encourages", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 during the early part of the day. Cloths are then wrapped round them and they are left in boxes overnight. This procedure encourages", "correct_answer": "sunlight"}, {"id": "37", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . Gradually, the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 . Gradually, the", "correct_answer": "transpiration"}, {"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of the individual pods starts to decrease. While this is happening, the farmers continue to work on the pods. They use their", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of the individual pods starts to decrease. While this is happening, the farmers continue to work on the pods. They use their", "correct_answer": "weight"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to flatten them out. For the last stage in the curing process, the pods are kept in a cool place which is open to the air, so that the amount of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to flatten them out. For the last stage in the curing process, the pods are kept in a cool place which is open to the air, so that the amount of", "correct_answer": "fingers"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 within them is reduced. IELTS General Reading Test 10 IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 within them is reduced. IELTS General Reading Test 10 IELTS General", "correct_answer": "moisture"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 12 (material_id = 112) ===
        $matId = 112;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-8',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "This is the first year that The Guardianhas run a travel photography competition.", "text": "This is the first year that The Guardianhas run a travel photography competition.", "correct_answer": "FALSE"}, {"id": "2", "label": "Any photograph for the competition must have been taken on an overseas trip.", "text": "Any photograph for the competition must have been taken on an overseas trip.", "correct_answer": "FALSE"}, {"id": "3", "label": "The end-of-year exhibition in London is free for the public to attend.", "text": "The end-of-year exhibition in London is free for the public to attend.", "correct_answer": "NOT GIVEN"}, {"id": "4", "label": "The judging panel is made up of a group of journalists and a professional photographer.", "text": "The judging panel is made up of a group of journalists and a professional photographer.", "correct_answer": "TRUE"}, {"id": "5", "label": "The trip to Swedish Lapland will only be offered to one winner.", "text": "The trip to Swedish Lapland will only be offered to one winner.", "correct_answer": "TRUE"}, {"id": "6", "label": "Every activity on the trip is focused on improving photography techniques.", "text": "Every activity on the trip is focused on improving photography techniques.", "correct_answer": "TRUE"}, {"id": "7", "label": "Anyone going on the trip may take some of the cold weather clothing home at the end of the trip.", "text": "Anyone going on the trip may take some of the cold weather clothing home at the end of the trip.", "correct_answer": "FALSE"}, {"id": "8", "label": "Articles written about the trip may be changed before being published. Read the text below and answer Questions 9-14. Running headphones Listening to music on headphones makes running and even working out at the gym much more enjoyable. Here are some alternatives to choose from.", "text": "Articles written about the trip may be changed before being published. Read the text below and answer Questions 9-14. Running headphones Listening to music on headphones makes running and even working out at the gym much more enjoyable. Here are some alternatives to choose from.", "correct_answer": "TRUE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 9,
            'question_text' => 'Questions 9-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 8, "sub_questions": [{"id": "9", "label": "These headphones would suit someone who doesn\\u2019t mind spending a lot to get good quality.", "text": "These headphones would suit someone who doesn\\u2019t mind spending a lot to get good quality.", "correct_answer": "G"}, {"id": "10", "label": "The battery on these headphones has a surprisingly long life.", "text": "The battery on these headphones has a surprisingly long life.", "correct_answer": "A"}, {"id": "11", "label": "It is possible to keep in contact with other people while using these headphones.", "text": "It is possible to keep in contact with other people while using these headphones.", "correct_answer": "B"}, {"id": "12", "label": "Although these headphones are cheaper than most, music sounds quite good through them.", "text": "Although these headphones are cheaper than most, music sounds quite good through them.", "correct_answer": "E"}, {"id": "13", "label": "These headphones are very strong and do not require gentle handling.", "text": "These headphones are very strong and do not require gentle handling.", "correct_answer": "A"}, {"id": "14", "label": "These headphones allow users to move around their playlist of music easily while they are exercising. Advertisements", "text": "These headphones allow users to move around their playlist of music easily while they are exercising. Advertisements", "correct_answer": "F"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-21',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... about the risks. \\u2193 At a meeting, he talked to the client company about \\u2022 the policy of the company regarding", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... about the risks. \\u2193 At a meeting, he talked to the client company about \\u2022 the policy of the company regarding", "correct_answer": "representatives"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... (e.g. clear walkways) \\u2022 procedures to be followed in case of a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... (e.g. clear walkways) \\u2022 procedures to be followed in case of a", "correct_answer": "housekeeping"}, {"id": "17", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... \\u2022 facilities available to cleaners (e.g. space available for", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... \\u2022 facilities available to cleaners (e.g. space available for", "correct_answer": "fire"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026...) \\u2022 a way of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026...) \\u2022 a way of", "correct_answer": "storage"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... risks and hazards. \\u2193 He created a risk assessment document identifying existing controls of risks and hazards. \\u2193 He compared these to information that the HSE provided on its", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... risks and hazards. \\u2193 He created a risk assessment document identifying existing controls of risks and hazards. \\u2193 He compared these to information that the HSE provided on its", "correct_answer": "reporting"}, {"id": "20", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... . \\u2193 He displayed a copy of the risk assessment inside a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... . \\u2193 He displayed a copy of the risk assessment inside a", "correct_answer": "website"}, {"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... available to all cleaning staff. Read the text below and answer Questions 22-27. Preparing for a virtual job interview Businesses are always looking for new ways to increase efficiency and profits. For example, organisations often reduce costs by conducting virtual job interviews. The video or Skype interview benefits both interviewer and interviewee, especially when an applicant would otherwise need to travel far. Despite the convenience though, it poses unique challenges. How a virtual interview is the same The typical interview process usually entails multiple steps. First, there is screening, lasting about thirty minutes. Its purpose is to ensure candidates have the basic requirements. In the second interview, they\\u2019re assessed for their technical skills and on whether they would fit the organisation. Virtual interviews follow the same steps so you\\u2019ll need to focus on the same core topics. Identify what the critical topics are based on the job description and prepare to talk about them. If you can, gather inside information so you can impress interviewers with your knowledge. How a virtual interview is different Modern technology is great when it works, but a pain when it doesn\\u2019t. So, it\\u2019s wise to check you can operate your webcam, especially if you don\\u2019t use it often. Test the headset too and find out how intelligible your voice sounds. It\\u2019s also wise to establish what software the interviewer is going to work with and give it a trial run. Probably the biggest problem in a virtual interview is what the camera can see. You want the interviewer to see you as a professional. Having a messy or cluttered room behind you won\\u2019t help you achieve this image \\u2013 a clear white background is usually a safe bet. The most important part of your preparation is to run through everything first as best you can. Have a friend conduct a rehearsal with you before the big day. This will help you know how to behave in front of the camera. All things considered, though, virtual interviews should be treated like any other type of interview. Being at home requires as much preparation as a traditional interview. If you follow the steps mentioned above, you have every chance of getting the job you want. Good luck!", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... available to all cleaning staff. Read the text below and answer Questions 22-27. Preparing for a virtual job interview Businesses are always looking for new ways to increase efficiency and profits. For example, organisations often reduce costs by conducting virtual job interviews. The video or Skype interview benefits both interviewer and interviewee, especially when an applicant would otherwise need to travel far. Despite the convenience though, it poses unique challenges. How a virtual interview is the same The typical interview process usually entails multiple steps. First, there is screening, lasting about thirty minutes. Its purpose is to ensure candidates have the basic requirements. In the second interview, they\\u2019re assessed for their technical skills and on whether they would fit the organisation. Virtual interviews follow the same steps so you\\u2019ll need to focus on the same core topics. Identify what the critical topics are based on the job description and prepare to talk about them. If you can, gather inside information so you can impress interviewers with your knowledge. How a virtual interview is different Modern technology is great when it works, but a pain when it doesn\\u2019t. So, it\\u2019s wise to check you can operate your webcam, especially if you don\\u2019t use it often. Test the headset too and find out how intelligible your voice sounds. It\\u2019s also wise to establish what software the interviewer is going to work with and give it a trial run. Probably the biggest problem in a virtual interview is what the camera can see. You want the interviewer to see you as a professional. Having a messy or cluttered room behind you won\\u2019t help you achieve this image \\u2013 a clear white background is usually a safe bet. The most important part of your preparation is to run through everything first as best you can. Have a friend conduct a rehearsal with you before the big day. This will help you know how to behave in front of the camera. All things considered, though, virtual interviews should be treated like any other type of interview. Being at home requires as much preparation as a traditional interview. If you follow the steps mentioned above, you have every chance of getting the job you want. Good luck!", "correct_answer": "cupboard"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 22,
            'question_text' => 'Questions 22-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 21, "sub_questions": [{"id": "22", "label": "Some companies prefer to interview job applicants digitally because of lower \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "Some companies prefer to interview job applicants digitally because of lower \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "costs"}, {"id": "23", "label": "As with the standard recruitment process, virtual recruitment opens with \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "As with the standard recruitment process, virtual recruitment opens with \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "screening"}, {"id": "24", "label": "Applicants should read any details about the advertised post carefully and pick out important \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 which they can discuss if necessary.", "text": "Applicants should read any details about the advertised post carefully and pick out important \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 which they can discuss if necessary.", "correct_answer": "topics"}, {"id": "25", "label": "It is a good idea for applicants to check if they can be clearly understood when they use a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "It is a good idea for applicants to check if they can be clearly understood when they use a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "headset"}, {"id": "26", "label": "Applicants may not be familiar with the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 that the person conducting the interview will use, so they should try it out.", "text": "Applicants may not be familiar with the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 that the person conducting the interview will use, so they should try it out.", "correct_answer": "software"}, {"id": "27", "label": "It is very useful to go through a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of the interview, with someone playing the part of the interviewer. Advertisements", "text": "It is very useful to go through a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of the interview, with someone playing the part of the interviewer. Advertisements", "correct_answer": "rehearsal"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-33',
            'type' => 'matching_paragraph_information',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "a summary of the different aspects of leadership that are covered in the study", "text": "a summary of the different aspects of leadership that are covered in the study", "correct_answer": "B"}, {"id": "29", "label": "a description of how band leaders sometimes passed on their leadership skills to others", "text": "a description of how band leaders sometimes passed on their leadership skills to others", "correct_answer": "E"}, {"id": "30", "label": "a summary of the backgrounds of the band leaders chosen for the study", "text": "a summary of the backgrounds of the band leaders chosen for the study", "correct_answer": "B"}, {"id": "31", "label": "examples of ways in which one band leader encouraged his musicians to be more creative", "text": "examples of ways in which one band leader encouraged his musicians to be more creative", "correct_answer": "D"}, {"id": "32", "label": "an overview of the main similarities between the work of business people and jazz musicians", "text": "an overview of the main similarities between the work of business people and jazz musicians", "correct_answer": "A"}, {"id": "33", "label": "a description of two contrasting ways of leading a team", "text": "a description of two contrasting ways of leading a team", "correct_answer": "D"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 34,
            'question_text' => 'Questions 34-36',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 33, "sub_questions": [{"id": "34", "label": "The study by Ucbasaran and Lockett was the first to compare the worlds of music and business.", "text": "The study by Ucbasaran and Lockett was the first to compare the worlds of music and business.", "correct_answer": "FALSE"}, {"id": "35", "label": "One reason why jazz musicians were chosen for the research is because the setting in which they work is unpredictable.", "text": "One reason why jazz musicians were chosen for the research is because the setting in which they work is unpredictable.", "correct_answer": "TRUE"}, {"id": "36", "label": "The researchers decided to cover only certain aspects of leadership.", "text": "The researchers decided to cover only certain aspects of leadership.", "correct_answer": "TRUE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 37,
            'question_text' => 'Questions 37-40',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 36, "sub_questions": [{"id": "37", "label": "When assembling their teams, the band leaders all prioritised players A who had special technical skill. B who were used to working independently. C who had an individual style of their own. D who would get on well with other band members.", "text": "When assembling their teams, the band leaders all prioritised players A who had special technical skill. B who were used to working independently. C who had an individual style of their own. D who would get on well with other band members.", "correct_answer": "C"}, {"id": "38", "label": "What obstacle might jazz leaders face in reducing destructive conflict among team members? A They may also reduce productive conflict in the process. B Their team members tend to have especially strong personalities. C They are unaware of the theory concerning different types of conflict. D Their team members may be unwilling to cooperate in reducing this.", "text": "What obstacle might jazz leaders face in reducing destructive conflict among team members? A They may also reduce productive conflict in the process. B Their team members tend to have especially strong personalities. C They are unaware of the theory concerning different types of conflict. D Their team members may be unwilling to cooperate in reducing this.", "correct_answer": "A"}, {"id": "39", "label": "What approach to group coordination was shared by Ellington, Davis and Blakey? A They allowed musicians to be creative within certain agreed limits. B They increased opportunities for success and reduced chances of failure. C They provided a structure within which musicians could express themselves. D They coordinated the work of their teams so each member contributed equally.", "text": "What approach to group coordination was shared by Ellington, Davis and Blakey? A They allowed musicians to be creative within certain agreed limits. B They increased opportunities for success and reduced chances of failure. C They provided a structure within which musicians could express themselves. D They coordinated the work of their teams so each member contributed equally.", "correct_answer": "C"}, {"id": "40", "label": "Ucbasaran and her colleagues found that the high turnover of members in jazz bands A was eventually reduced by the policies of the band leaders. B was welcomed by band leaders for the benefits it brought. C was due to a shortage of effective band leaders. D was a feature of the growing popularity of jazz. IELTS General Reading Test 11 IELTS General", "text": "Ucbasaran and her colleagues found that the high turnover of members in jazz bands A was eventually reduced by the policies of the band leaders. B was welcomed by band leaders for the benefits it brought. C was due to a shortage of effective band leaders. D was a feature of the growing popularity of jazz. IELTS General Reading Test 11 IELTS General", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 13 (material_id = 113) ===
        $matId = 113;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-8',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "Visitors can help to make one particular event a success at this festival.", "text": "Visitors can help to make one particular event a success at this festival.", "correct_answer": "G"}, {"id": "2", "label": "People can listen to local musicians here.", "text": "People can listen to local musicians here.", "correct_answer": "D"}, {"id": "3", "label": "At this festival, people can listen to music in lots of different places.", "text": "At this festival, people can listen to music in lots of different places.", "correct_answer": "B"}, {"id": "4", "label": "It is not necessary to pay for one of the events here.", "text": "It is not necessary to pay for one of the events here.", "correct_answer": "A"}, {"id": "5", "label": "It is possible to stay overnight at this festival.", "text": "It is possible to stay overnight at this festival.", "correct_answer": "F"}, {"id": "6", "label": "Children will enjoy this festival.", "text": "Children will enjoy this festival.", "correct_answer": "D"}, {"id": "7", "label": "Visitors can get advice here.", "text": "Visitors can get advice here.", "correct_answer": "E"}, {"id": "8", "label": "People can watch craftspeople at work here. Read the text below and answer Questions 9-14. BIG ROCK CLIMBING CENTRE Big Rock Climbing Centre is a modern, friendly, professionally run centre offering over 1,250 square metres of fantastic indoor climbing. We use trained and experienced instructors to give you the opportunity to learn and develop climbing skills, keep fit and have fun. Master our 11 m-high climbing walls, using a rope harness, for an unbeatable sense of achievement. Or experience the thrills of climbing without any harness in our special low-level arena, which has foam mats on the floor to cushion any fall safely. Who is Big Rock for? Almost anyone can enjoy Big Rock. Previous climbing experience and specialist equipment are not required. You can come on your own or with friends and family. Come as a fun alternative to the gym or for a special day out with the kids. If you\'re visiting with friends or family but not climbing, or just fancy coming to look, please feel free to relax in our excellent cafe overlooking the climbing areas. Mobile Climbing Wall Available on a day hire basis at any location, the Big Rock Mobile Climbing Wall is the perfect way to enhance any show, festival or event. The mobile wall can be used indoors or outdoors and features four unique 7.3 m-high climbing faces designed to allow four people to climb simultaneously. Quick to set up and pack up, the Mobile Climbing Wall is sta\\ufb00ed by qualified and experienced climbing instructors, providing the opportunity to climb the wall in a controlled and safe environment. When considering what to wear, we\'ve found that trousers and t-shirts are ideal. We will, however, ask people to remove scarves. Most flat shoes are suitable as long as they\'re enclosed and support the foot. The mobile wall is very adaptable and can be operated in light rain and winds up to 50 kph. There are, however, particular measures that we take in such conditions. What about hiring the Mobile Climbing Wall for my school or college? As climbing is different from the usual team games practised at schools, we\'ve found that some students who don\'t usually like participating in sports are willing to have a go on the mobile climbing wall. If you\'re concerned that some children may not want to take part because they feel nervous if they climb, then please be assured that our instructors will support them up to a level which they\'re comfortable with. They will still benefit greatly from the experience.", "text": "People can watch craftspeople at work here. Read the text below and answer Questions 9-14. BIG ROCK CLIMBING CENTRE Big Rock Climbing Centre is a modern, friendly, professionally run centre offering over 1,250 square metres of fantastic indoor climbing. We use trained and experienced instructors to give you the opportunity to learn and develop climbing skills, keep fit and have fun. Master our 11 m-high climbing walls, using a rope harness, for an unbeatable sense of achievement. Or experience the thrills of climbing without any harness in our special low-level arena, which has foam mats on the floor to cushion any fall safely. Who is Big Rock for? Almost anyone can enjoy Big Rock. Previous climbing experience and specialist equipment are not required. You can come on your own or with friends and family. Come as a fun alternative to the gym or for a special day out with the kids. If you\'re visiting with friends or family but not climbing, or just fancy coming to look, please feel free to relax in our excellent cafe overlooking the climbing areas. Mobile Climbing Wall Available on a day hire basis at any location, the Big Rock Mobile Climbing Wall is the perfect way to enhance any show, festival or event. The mobile wall can be used indoors or outdoors and features four unique 7.3 m-high climbing faces designed to allow four people to climb simultaneously. Quick to set up and pack up, the Mobile Climbing Wall is sta\\ufb00ed by qualified and experienced climbing instructors, providing the opportunity to climb the wall in a controlled and safe environment. When considering what to wear, we\'ve found that trousers and t-shirts are ideal. We will, however, ask people to remove scarves. Most flat shoes are suitable as long as they\'re enclosed and support the foot. The mobile wall is very adaptable and can be operated in light rain and winds up to 50 kph. There are, however, particular measures that we take in such conditions. What about hiring the Mobile Climbing Wall for my school or college? As climbing is different from the usual team games practised at schools, we\'ve found that some students who don\'t usually like participating in sports are willing to have a go on the mobile climbing wall. If you\'re concerned that some children may not want to take part because they feel nervous if they climb, then please be assured that our instructors will support them up to a level which they\'re comfortable with. They will still benefit greatly from the experience.", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 9,
            'question_text' => 'Questions 9-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 8, "sub_questions": [{"id": "9", "label": "When climbing at the Big Rock Centre, it is compulsory to be attached by a rope.", "text": "When climbing at the Big Rock Centre, it is compulsory to be attached by a rope.", "correct_answer": "FALSE"}, {"id": "10", "label": "People who just want to watch the climbing can enter the Centre without paying.", "text": "People who just want to watch the climbing can enter the Centre without paying.", "correct_answer": "NOT GIVEN"}, {"id": "11", "label": "People can arrange to have a climbing session in their own garden if they wish.", "text": "People can arrange to have a climbing session in their own garden if they wish.", "correct_answer": "TRUE"}, {"id": "12", "label": "Question 12", "text": "Question 12", "correct_answer": "TRUE"}, {"id": "13", "label": "The Mobile Climbing Wall can only be used in dry, calm weather.", "text": "The Mobile Climbing Wall can only be used in dry, calm weather.", "correct_answer": "FALSE"}, {"id": "14", "label": "It is inadvisable for children who are afraid of heights to use the Mobile Climbing Wall. Advertisements", "text": "It is inadvisable for children who are afraid of heights to use the Mobile Climbing Wall. Advertisements", "correct_answer": "FALSE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "period of availability can be taken at the workstation. Providing the worker has a reasonable amount of freedom (e.g. they can read and relax) for a known duration, this could satisfy the requirements of a period of availability."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "Some ........................... will help you to discover the most e\\ufb00ective places to advertise.", "text": "Some ........................... will help you to discover the most e\\ufb00ective places to advertise.", "correct_answer": "research"}, {"id": "16", "label": "Question 16", "text": "Question 16", "correct_answer": "survey"}, {"id": "17", "label": "Question 17", "text": "Question 17", "correct_answer": "mix"}, {"id": "18", "label": "If you can, provide customers with useful ........................... about your business.", "text": "If you can, provide customers with useful ........................... about your business.", "correct_answer": "updates"}, {"id": "19", "label": "Measuring the e\\ufb00ects of your advertising can give you ........................... that will improve your business.", "text": "Measuring the e\\ufb00ects of your advertising can give you ........................... that will improve your business.", "correct_answer": "information"}, {"id": "20", "label": "Success in finding new customers largely depends on your ........................... . Read the text below and answer Questions 21-27. Working Time Regulations for Mobile Workers These rules apply to drivers and crew of heavy goods vehicles or public service vehicles. The rules limit the amount of time that can be worked. Those defined in the Regulations as being self-employed are currently not covered by the Regulations. What are the limits? \\u2022 An average of 48 hours\' work per week. \\u2022 In any single week up to 60 hours can be worked so long as the 48-hour average is maintained. \\u2022 Night work is limited to 1 O hours per night, unless there is a workforce agreement to work longer. \\u2022 Statutory annual leave and any sick leave and/or maternity/paternity leave counts as working time. What counts as work? In general, any activities performed in connection with the transport operation count as work, for example, driving, loading/unloading and those checks that are the responsibility of drivers, such as checking lights, brakes, etc. There are a number of periods of time that do not count as work, for example, travelling between home and your normal place of work, lunch or other breaks and periods of availability. Periods of availability are periods of time during which the mobile worker is not required to remain at their workstation but is required to be available for work, the foreseeable duration of which is known about in advance, for example: \\u2022 Delays at a distribution centre. \\u2022 Reporting for work then being informed that no duties are to be undertaken for a specified period. \\u2022 Accompanying a vehicle being transported, for example by train.", "text": "Success in finding new customers largely depends on your ........................... . Read the text below and answer Questions 21-27. Working Time Regulations for Mobile Workers These rules apply to drivers and crew of heavy goods vehicles or public service vehicles. The rules limit the amount of time that can be worked. Those defined in the Regulations as being self-employed are currently not covered by the Regulations. What are the limits? \\u2022 An average of 48 hours\' work per week. \\u2022 In any single week up to 60 hours can be worked so long as the 48-hour average is maintained. \\u2022 Night work is limited to 1 O hours per night, unless there is a workforce agreement to work longer. \\u2022 Statutory annual leave and any sick leave and/or maternity/paternity leave counts as working time. What counts as work? In general, any activities performed in connection with the transport operation count as work, for example, driving, loading/unloading and those checks that are the responsibility of drivers, such as checking lights, brakes, etc. There are a number of periods of time that do not count as work, for example, travelling between home and your normal place of work, lunch or other breaks and periods of availability. Periods of availability are periods of time during which the mobile worker is not required to remain at their workstation but is required to be available for work, the foreseeable duration of which is known about in advance, for example: \\u2022 Delays at a distribution centre. \\u2022 Reporting for work then being informed that no duties are to be undertaken for a specified period. \\u2022 Accompanying a vehicle being transported, for example by train.", "correct_answer": "reputation"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "......................... workers. Maximum working hours: 60 hours a week, provided the", "text": "......................... workers. Maximum working hours: 60 hours a week, provided the", "correct_answer": "selfemployed"}, {"id": "22", "label": "......................... is no more than 48 hours. Night work can be more than 10 hours with the", "text": "......................... is no more than 48 hours. Night work can be more than 10 hours with the", "correct_answer": "average"}, {"id": "23", "label": "......................... of the workers. Work includes driving, loading and unloading, and carrying out various", "text": "......................... of the workers. Work includes driving, loading and unloading, and carrying out various", "correct_answer": "agreement"}, {"id": "24", "label": "......................... of the vehicle. Periods of availability include: going on a", "text": "......................... of the vehicle. Periods of availability include: going on a", "correct_answer": "checks"}, {"id": "25", "label": "......................... or other form of transport with a vehicle a period at the workstation when the driver has some", "text": "......................... or other form of transport with a vehicle a period at the workstation when the driver has some", "correct_answer": "train"}, {"id": "26", "label": "......................... might count as a period of availability Periods of availability exclude: time spent stopping and starting the vehicle when", "text": "......................... might count as a period of availability Periods of availability exclude: time spent stopping and starting the vehicle when", "correct_answer": "freedom"}, {"id": "27", "label": "......................... causes delays being in a queue, e.g. in order to load or unload Advertisements", "text": "......................... causes delays being in a queue, e.g. in order to load or unload Advertisements", "correct_answer": "congestion"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-30',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Question 28", "text": "Question 28", "correct_answer": "myths"}, {"id": "29", "label": "...................... which were worked by human operators. Some automata were designed to be", "text": "...................... which were worked by human operators. Some automata were designed to be", "correct_answer": "levers"}, {"id": "30", "label": "Automata and the ancient Greeks The ancient Greeks had a number of", "text": "Automata and the ancient Greeks The ancient Greeks had a number of", "correct_answer": "tools"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 31,
            'question_text' => 'Questions 31-35) and the list of people below.',
            'type' => 'matching_features',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 30, "sub_questions": [{"id": "31", "label": "created an automaton that represented a bird in water, interacting with its surroundings", "text": "created an automaton that represented a bird in water, interacting with its surroundings", "correct_answer": "F"}, {"id": "32", "label": "created an automaton that performed on a musical instrument", "text": "created an automaton that performed on a musical instrument", "correct_answer": "E"}, {"id": "33", "label": "produced documents about how to create automata", "text": "produced documents about how to create automata", "correct_answer": "B"}, {"id": "34", "label": "created automata which required a human being to operate the mechanism", "text": "created automata which required a human being to operate the mechanism", "correct_answer": "D"}, {"id": "35", "label": "used air and water power List of People A Ctesibius B Arab engineers C da Vinci D Maillardet E Vaucanson F Merlin G Jaquet-Droz", "text": "used air and water power List of People A Ctesibius B Arab engineers C da Vinci D Maillardet E Vaucanson F Merlin G Jaquet-Droz", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 36,
            'question_text' => 'Questions 36-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 35, "sub_questions": [{"id": "36", "label": "The Mechanical Theatre shows court life inside a ...................... .", "text": "The Mechanical Theatre shows court life inside a ...................... .", "correct_answer": "palace"}, {"id": "37", "label": "In the Mechanical Theatre, building workers, butchers and a barber represent various ...................... of the time.", "text": "In the Mechanical Theatre, building workers, butchers and a barber represent various ...................... of the time.", "correct_answer": "trades"}, {"id": "38", "label": "...................... provides the power that operates the Mechanical Theatre.", "text": "...................... provides the power that operates the Mechanical Theatre.", "correct_answer": "water"}, {"id": "39", "label": "New ...................... that developed in the nineteenth century reduced the cost of the production of automata.", "text": "New ...................... that developed in the nineteenth century reduced the cost of the production of automata.", "correct_answer": "techniques"}, {"id": "40", "label": "During the nineteenth century, most automata were intended for use by ...................... . IELTS General Reading Test 12 IELTS General", "text": "During the nineteenth century, most automata were intended for use by ...................... . IELTS General Reading Test 12 IELTS General", "correct_answer": "children"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 14 (material_id = 114) ===
        $matId = 114;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'summary_completion',
            'options' => '{"A": "range of workshops, including music and combat, are held here during the summer. Children of all ages will enjoy learning at these and there is a guided tour which has been especially designed with younger visitors in mind. Some of them may find the dungeon quite scary though.", "B": "Glamis Castle", "C": "Tintagel Castle", "D": "Pickering Castle", "E": "Stokesay Castle", "F": "Warwick Castle"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "............................. that contains the relevant information When filling in the form \\u2022 refer to the", "text": "............................. that contains the relevant information When filling in the form \\u2022 refer to the", "correct_answer": "booklet"}, {"id": "2", "label": "............................. to ensure all the relevant sections are completed (You can use their", "text": "............................. to ensure all the relevant sections are completed (You can use their", "correct_answer": "checklist"}, {"id": "3", "label": "............................. to request action if you don\'t have enough proof to make a claim.) When claiming compensation for a lost item \\u2022 include proof that you have posted the item \\u2022 in the case of a package, include something (e.g. bank statement) to prove its", "text": "............................. to request action if you don\'t have enough proof to make a claim.) When claiming compensation for a lost item \\u2022 include proof that you have posted the item \\u2022 in the case of a package, include something (e.g. bank statement) to prove its", "correct_answer": "website"}, {"id": "4", "label": "............................. When claiming for the cost of a damaged item, include \\u2022 either the actual item or", "text": "............................. When claiming for the cost of a damaged item, include \\u2022 either the actual item or", "correct_answer": "value"}, {"id": "5", "label": "............................. showing the damage to the item (You should keep the", "text": "............................. showing the damage to the item (You should keep the", "correct_answer": "photograph / photos"}, {"id": "6", "label": "............................. that was used when the item was originally sent.) When to claim \\u2022 Lost or damaged items: within 12 months of posting the item \\u2022 Delayed items: if you are the", "text": "............................. that was used when the item was originally sent.) When to claim \\u2022 Lost or damaged items: within 12 months of posting the item \\u2022 Delayed items: if you are the", "correct_answer": "packaging"}, {"id": "7", "label": "............................., you must claim within three months of posting the package Read the text below and answer Questions 8-14. Days out for the family", "text": "............................., you must claim within three months of posting the package Read the text below and answer Questions 8-14. Days out for the family", "correct_answer": "sender"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'summary_completion',
            'options' => '{"A": "guided tour is o\\ufb00ered which is particularly suitable for children."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "At certain times of year you can eat special meals here.", "text": "At certain times of year you can eat special meals here.", "correct_answer": "A"}, {"id": "9", "label": "Children can get dressed up here.", "text": "Children can get dressed up here.", "correct_answer": "F"}, {"id": "10", "label": "There is another castle in the same area.", "text": "There is another castle in the same area.", "correct_answer": "D"}, {"id": "11", "label": "Question 11", "text": "Question 11", "correct_answer": "B"}, {"id": "12", "label": "Part of the castle may be frightening for some children.", "text": "Part of the castle may be frightening for some children.", "correct_answer": "E"}, {"id": "13", "label": "Plays are performed here during part of the year.", "text": "Plays are performed here during part of the year.", "correct_answer": "D"}, {"id": "14", "label": "Question 14", "text": "Question 14", "correct_answer": "E"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "Which employees may choose not to work regular hours?", "text": "Which employees may choose not to work regular hours?", "correct_answer": "indoor"}, {"id": "16", "label": "How much time o\\ufb00 each year is an employee able to take to look after a relative?", "text": "How much time o\\ufb00 each year is an employee able to take to look after a relative?", "correct_answer": "3 weeks/three weeks"}, {"id": "17", "label": "What kind of leave involves a choice between two alternative periods of time?", "text": "What kind of leave involves a choice between two alternative periods of time?", "correct_answer": "maternity"}, {"id": "18", "label": "How long must employees have worked without a break before being entitled to additional holidays?", "text": "How long must employees have worked without a break before being entitled to additional holidays?", "correct_answer": "5 years/five years"}, {"id": "19", "label": "What does the Financial Advice Program advise sta\\ufb00 about?", "text": "What does the Financial Advice Program advise sta\\ufb00 about?", "correct_answer": "pension"}, {"id": "20", "label": "What kind of professional people can employees see if they want to talk about their job in private? Read the text below and answer Questions 21-27. Registering As An Apprentice If you are keen to acquire new skills and learn best through \'hands-on\' experiences, then registered apprenticeship is a good option for you. These programmes always involve work experience as well as classroom instruction and produce workers skilled in the occupation. There is a written contract to be signed by the apprentice and the employer, which acknowledge their joint commitment to the training process. This contract is approved and registered by the New York State Department of Labor. How Do I Qualify? First of all you must meet the employer\'s minimum qualifications. This could be a high school diploma or the equivalent. However, some employers will ask for specific high school courses, prior experience, or occupationally related courses. What Is My Training Like? Training for each apprenticeable occupation is conducted according to a training outline that has been standardized for the occupation. This assures that apprentices across the state have the same sets of basic competencies and skills. At the successful completion of each registered apprenticeship, the Department of Labor awards the apprentice a \'Certificate of Completion\', which is a nationally recognized credential. The length of time it takes you to learn the skills of the occupation depends upon two things: the standard training outline and your aptitude. Each trade has a definite term of training, listed in years. As a registered apprentice, you may progress according to that established training term, or you may become skilled more quickly or more slowly. It may even be that you start your apprenticeship with credit toward the goal. Your employer may choose to award you this for previous working experience in the occupation, or for prior coursework related to the occupation. As an apprentice, you are part of the employer\'s workforce. You work full-time for the employer. A registered apprentice works under the guidance of more experienced craft workers called journey workers. From them, you learn the skills of the trade. As you master each skill, you become a more productive employee. At the same time as you are working, you are also required to attend classes (usually in the evenings). The location and times of these are set up by the local education agent in consultation with the employer. Your progress is tracked by you, your employer and your education provider. Successful completion of all requirements results in your certificate.", "text": "What kind of professional people can employees see if they want to talk about their job in private? Read the text below and answer Questions 21-27. Registering As An Apprentice If you are keen to acquire new skills and learn best through \'hands-on\' experiences, then registered apprenticeship is a good option for you. These programmes always involve work experience as well as classroom instruction and produce workers skilled in the occupation. There is a written contract to be signed by the apprentice and the employer, which acknowledge their joint commitment to the training process. This contract is approved and registered by the New York State Department of Labor. How Do I Qualify? First of all you must meet the employer\'s minimum qualifications. This could be a high school diploma or the equivalent. However, some employers will ask for specific high school courses, prior experience, or occupationally related courses. What Is My Training Like? Training for each apprenticeable occupation is conducted according to a training outline that has been standardized for the occupation. This assures that apprentices across the state have the same sets of basic competencies and skills. At the successful completion of each registered apprenticeship, the Department of Labor awards the apprentice a \'Certificate of Completion\', which is a nationally recognized credential. The length of time it takes you to learn the skills of the occupation depends upon two things: the standard training outline and your aptitude. Each trade has a definite term of training, listed in years. As a registered apprentice, you may progress according to that established training term, or you may become skilled more quickly or more slowly. It may even be that you start your apprenticeship with credit toward the goal. Your employer may choose to award you this for previous working experience in the occupation, or for prior coursework related to the occupation. As an apprentice, you are part of the employer\'s workforce. You work full-time for the employer. A registered apprentice works under the guidance of more experienced craft workers called journey workers. From them, you learn the skills of the trade. As you master each skill, you become a more productive employee. At the same time as you are working, you are also required to attend classes (usually in the evenings). The location and times of these are set up by the local education agent in consultation with the employer. Your progress is tracked by you, your employer and your education provider. Successful completion of all requirements results in your certificate.", "correct_answer": "psychologists"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "You and your employer will need. to sign a ........................... before training starts.", "text": "You and your employer will need. to sign a ........................... before training starts.", "correct_answer": "contract"}, {"id": "22", "label": "Employers may have di\\ufb00erent minimum requirements regarding applicants\' ........................... and experience.", "text": "Employers may have di\\ufb00erent minimum requirements regarding applicants\' ........................... and experience.", "correct_answer": "qualifications/courses"}, {"id": "23", "label": "Each industry has its own standardised ........................... of training.", "text": "Each industry has its own standardised ........................... of training.", "correct_answer": "outline/term"}, {"id": "24", "label": "You may be given credit for work experience or if you have done relevant", "text": "You may be given credit for work experience or if you have done relevant", "correct_answer": "coursework"}, {"id": "25", "label": "You will be considered as a member of the ........................... during the apprenticeship.", "text": "You will be considered as a member of the ........................... during the apprenticeship.", "correct_answer": "workforce"}, {"id": "26", "label": "While at work, apprentices are supervised by what are known as ........................... .", "text": "While at work, apprentices are supervised by what are known as ........................... .", "correct_answer": "journey workers"}, {"id": "27", "label": "Employers are consulted when deciding the ........................... and schedule for lessons. Advertisements", "text": "Employers are consulted when deciding the ........................... and schedule for lessons. Advertisements", "correct_answer": "location"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-34',
            'type' => 'matching_headings',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Section A", "text": "Section A", "correct_answer": "vi"}, {"id": "29", "label": "Section B", "text": "Section B", "correct_answer": "ix"}, {"id": "30", "label": "Section C", "text": "Section C", "correct_answer": "vii"}, {"id": "31", "label": "Section D", "text": "Section D", "correct_answer": "iii"}, {"id": "32", "label": "Section E", "text": "Section E", "correct_answer": "ii"}, {"id": "33", "label": "Section F", "text": "Section F", "correct_answer": "iv"}, {"id": "34", "label": "Section G", "text": "Section G", "correct_answer": "viii"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 35,
            'question_text' => 'Questions 35-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 34, "sub_questions": [{"id": "35", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. with other forms of transport. The mid-19th century saw greater", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. with other forms of transport. The mid-19th century saw greater", "correct_answer": "integrated"}, {"id": "36", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in the provision of services. In 1968, an attempt to establish a service across the river using", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. in the provision of services. In 1968, an attempt to establish a service across the river using", "correct_answer": "competition"}, {"id": "37", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. failed. The Humber Bridge is a suspension bridge because the channel that ships travel along moves, and", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. failed. The Humber Bridge is a suspension bridge because the channel that ships travel along moves, and", "correct_answer": "hovercraft"}, {"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. supporting a bridge would obstruct it. A bridge rather than a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. supporting a bridge would obstruct it. A bridge rather than a", "correct_answer": "piers"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. was chosen on the grounds of cost. This was also one reason why", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. was chosen on the grounds of cost. This was also one reason why", "correct_answer": "tunnel"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. was used for the towers. IELTS General Reading Test 13 IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. was used for the towers. IELTS General Reading Test 13 IELTS General", "correct_answer": "concrete"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 15 (material_id = 115) ===
        $matId = 115;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-7',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "After taking this course, participants will be able to teach their skills to others.", "text": "After taking this course, participants will be able to teach their skills to others.", "correct_answer": "C"}, {"id": "2", "label": "Participants will be expected to prepare at home for each class.", "text": "Participants will be expected to prepare at home for each class.", "correct_answer": "E"}, {"id": "3", "label": "Certain materials will be included in the course fee.", "text": "Certain materials will be included in the course fee.", "correct_answer": "D"}, {"id": "4", "label": "This course aims to teach people to prepare meals for guests.", "text": "This course aims to teach people to prepare meals for guests.", "correct_answer": "B"}, {"id": "5", "label": "This course will help participants to make the best use of a certain item.", "text": "This course will help participants to make the best use of a certain item.", "correct_answer": "E"}, {"id": "6", "label": "This course is for people who want to do more than follow instructions.", "text": "This course is for people who want to do more than follow instructions.", "correct_answer": "A"}, {"id": "7", "label": "Following this course should improve participants\' health. Read the text and answer Questions 8-14. The Bike Found The Bike Foundry aims to promote cycling, and to make an environmentally-friendly means of transport and leisure available to as many people as we can. Our Bikes All our bikes are hand-restored by our team and come with a three months\' guarantee. We stock bikes to suit di\\ufb00erent needs, at a\\ufb00ordable prices. We gratefully accept donations of unwanted bikes. Training We o\\ufb00er maintenance and cycle training to schools and small groups on their own premises. Additionally we provide training to individuals and groups in our workshops. Maintenance Training Bike Basics This is a three-hour course which will teach you everything you need to know to keep on top of simple maintenance issues like looking after brakes and gears and how to repair a puncture. By the end of the course you\'ll know how to take good care of your bike. Home Mechanics This twelve-hour course consists of teaching you how to use specialist tools and how to fit compatible replacement parts. It\'s aimed at those who have completed Bike Basics or have some prior knowledge. Courses are run regularly for groups of up to fur trainees. We use professional mechanics\' tools and employ experienced staff Most importantly we have tea- and co\\ufb00ee-making facilities and a fridge where participants can keep their sandwiches, etc. Unfortunately our training room is up a \\ufb02ight of stairs. For \\u00a310 a year you can join our Tool Club. Membership gives you access to our workshop for one evening a week. If you want to repair your bike and know how to fit it, but lack specialist tools, then join our club. There\'s a range of reference manuals available and a mechanic to o\\ufb00er advice. Cycling Training Our qualified instructors can teach you how to ride your bike, whether you have had prior experience or not. If you\'re already riding and would like to build your confidence, we can teach you safe techniques to negotiate traffic. Booking Information To book a place, email training@bikefoundry.org We ask for a 50% deposit to confirm your place, refundable up to seven days before the course.", "text": "Following this course should improve participants\' health. Read the text and answer Questions 8-14. The Bike Found The Bike Foundry aims to promote cycling, and to make an environmentally-friendly means of transport and leisure available to as many people as we can. Our Bikes All our bikes are hand-restored by our team and come with a three months\' guarantee. We stock bikes to suit di\\ufb00erent needs, at a\\ufb00ordable prices. We gratefully accept donations of unwanted bikes. Training We o\\ufb00er maintenance and cycle training to schools and small groups on their own premises. Additionally we provide training to individuals and groups in our workshops. Maintenance Training Bike Basics This is a three-hour course which will teach you everything you need to know to keep on top of simple maintenance issues like looking after brakes and gears and how to repair a puncture. By the end of the course you\'ll know how to take good care of your bike. Home Mechanics This twelve-hour course consists of teaching you how to use specialist tools and how to fit compatible replacement parts. It\'s aimed at those who have completed Bike Basics or have some prior knowledge. Courses are run regularly for groups of up to fur trainees. We use professional mechanics\' tools and employ experienced staff Most importantly we have tea- and co\\ufb00ee-making facilities and a fridge where participants can keep their sandwiches, etc. Unfortunately our training room is up a \\ufb02ight of stairs. For \\u00a310 a year you can join our Tool Club. Membership gives you access to our workshop for one evening a week. If you want to repair your bike and know how to fit it, but lack specialist tools, then join our club. There\'s a range of reference manuals available and a mechanic to o\\ufb00er advice. Cycling Training Our qualified instructors can teach you how to ride your bike, whether you have had prior experience or not. If you\'re already riding and would like to build your confidence, we can teach you safe techniques to negotiate traffic. Booking Information To book a place, email training@bikefoundry.org We ask for a 50% deposit to confirm your place, refundable up to seven days before the course.", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 8,
            'question_text' => 'Questions 8-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 7, "sub_questions": [{"id": "8", "label": "The Bike Foundry sells only second-hand bicycles.", "text": "The Bike Foundry sells only second-hand bicycles.", "correct_answer": "TRUE"}, {"id": "9", "label": "All the training sessions are held at the Bike Foundry.", "text": "All the training sessions are held at the Bike Foundry.", "correct_answer": "FALSE"}, {"id": "10", "label": "The Bike Basics course is aimed at new cyclists.", "text": "The Bike Basics course is aimed at new cyclists.", "correct_answer": "NOT GIVEN"}, {"id": "11", "label": "Snacks are provided for participants on the maintenance training courses.", "text": "Snacks are provided for participants on the maintenance training courses.", "correct_answer": "FALSE"}, {"id": "12", "label": "Members of the Tool Club have access to cycle reference books.", "text": "Members of the Tool Club have access to cycle reference books.", "correct_answer": "TRUE"}, {"id": "13", "label": "Most of the participants on the Cycling Training courses are beginners.", "text": "Most of the participants on the Cycling Training courses are beginners.", "correct_answer": "NOT GIVEN"}, {"id": "14", "label": "People can cancel their place on a training course one week before it begins and still get their money back. Advertisements", "text": "People can cancel their place on a training course one week before it begins and still get their money back. Advertisements", "correct_answer": "TRUE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-21',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "The hospital provides benefits to show its recognition of the ............................. of sta\\ufb00 to its work.", "text": "The hospital provides benefits to show its recognition of the ............................. of sta\\ufb00 to its work.", "correct_answer": "contribution"}, {"id": "16", "label": "Financial benefits include pay for sta\\ufb00 who are ............................. or on maternity leave.", "text": "Financial benefits include pay for sta\\ufb00 who are ............................. or on maternity leave.", "correct_answer": "sick"}, {"id": "17", "label": "............................. are available for sta\\ufb00 who wish to buy a home.", "text": "............................. are available for sta\\ufb00 who wish to buy a home.", "correct_answer": "loans"}, {"id": "18", "label": "Helping staff with their work-life balance is not restricted to ............................. .", "text": "Helping staff with their work-life balance is not restricted to ............................. .", "correct_answer": "parents"}, {"id": "19", "label": "The hospital has ............................. that are designed to help sta\\ufb00 return to work after a long absence.", "text": "The hospital has ............................. that are designed to help sta\\ufb00 return to work after a long absence.", "correct_answer": "policies/schemes"}, {"id": "20", "label": "The facilities on hospital premises include a large area for ............................. .", "text": "The facilities on hospital premises include a large area for ............................. .", "correct_answer": "parking"}, {"id": "21", "label": "The cost of ............................. is reduced by using the Red Guava scheme. Read the text and answer Questions 22-27. Performance-related pay There are a number of reasons why your employer might introduce this type of pay scheme. They may: \\u2022 be keen to ret current staff \\u2022 want to compete for new talent \\u2022 be seeking a fairer way of distributing wages. In order for performance-related schemes to work they should be based on clear, measurable targets agreed by both employer and employee. You will normally find out about these targets from your contract of employment and the performance appraisal meetings you have with your manager. Short-term schemes Short-term schemes usually o\\ufb00er bonus payment, or, depending on the type of work, commission on sales achieved. Payments vary and these schemes are normally used just to encourage staff to improve their own performance. Long-term schemes Long-term schemes o\\ufb00er rewards like share options, and can help to encourage loyalty to the organisation and its aims. Such schemes tend to be used as a way of retaining senior staff. What to do if you have problems If you don\'t receive bonus or commission payments which you believe you are owed, check your contract of employment or staff handbook to see how your bonus is paid. Ask your employer if you need more information. If you think a mistake has been made, you should: \\u2022 speak to your employer to see if there has been a misunderstanding \\u2022 ask your employer to set out in writing how they have calculated your pay \\u2022 keep copies of ay letters ad notes of ay meetings. There are three ways that the law might cover a case of unpaid bonuses: \\u2022 breach of contract \\u2022 unlawful deductions from wages \\u2022 unlawful discrimination. Deductions from wages / breach of contract Any right to a bonus will normally be included in your contract of employment. It may not always be written down. It can be verbally agreed or understood to be there due to normal practice in your particular area of business. Failure to pay a bonus or commission that you are entitled to could amount to an unlawful deduction of wages. Discrimination Your employer must not discriminate against particular groups of people - for example, by giving smaller bonuses to women. Ideally your employer should have some guidelines setting out the normal range of bonuses to give, and these must be followed without discriminating against any specific group.", "text": "The cost of ............................. is reduced by using the Red Guava scheme. Read the text and answer Questions 22-27. Performance-related pay There are a number of reasons why your employer might introduce this type of pay scheme. They may: \\u2022 be keen to ret current staff \\u2022 want to compete for new talent \\u2022 be seeking a fairer way of distributing wages. In order for performance-related schemes to work they should be based on clear, measurable targets agreed by both employer and employee. You will normally find out about these targets from your contract of employment and the performance appraisal meetings you have with your manager. Short-term schemes Short-term schemes usually o\\ufb00er bonus payment, or, depending on the type of work, commission on sales achieved. Payments vary and these schemes are normally used just to encourage staff to improve their own performance. Long-term schemes Long-term schemes o\\ufb00er rewards like share options, and can help to encourage loyalty to the organisation and its aims. Such schemes tend to be used as a way of retaining senior staff. What to do if you have problems If you don\'t receive bonus or commission payments which you believe you are owed, check your contract of employment or staff handbook to see how your bonus is paid. Ask your employer if you need more information. If you think a mistake has been made, you should: \\u2022 speak to your employer to see if there has been a misunderstanding \\u2022 ask your employer to set out in writing how they have calculated your pay \\u2022 keep copies of ay letters ad notes of ay meetings. There are three ways that the law might cover a case of unpaid bonuses: \\u2022 breach of contract \\u2022 unlawful deductions from wages \\u2022 unlawful discrimination. Deductions from wages / breach of contract Any right to a bonus will normally be included in your contract of employment. It may not always be written down. It can be verbally agreed or understood to be there due to normal practice in your particular area of business. Failure to pay a bonus or commission that you are entitled to could amount to an unlawful deduction of wages. Discrimination Your employer must not discriminate against particular groups of people - for example, by giving smaller bonuses to women. Ideally your employer should have some guidelines setting out the normal range of bonuses to give, and these must be followed without discriminating against any specific group.", "correct_answer": "holidays"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 22,
            'question_text' => 'Questions 22-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 21, "sub_questions": [{"id": "22", "label": "............................. existing employees Employer and employee should agree on some", "text": "............................. existing employees Employer and employee should agree on some", "correct_answer": "retain"}, {"id": "23", "label": "............................. that can be measured Shor-term schemes: bonus or the payment of a", "text": "............................. that can be measured Shor-term schemes: bonus or the payment of a", "correct_answer": "targets"}, {"id": "24", "label": "............................. related to sales Long-term reward schemes: generally o\\ufb00ered to employees at a", "text": "............................. related to sales Long-term reward schemes: generally o\\ufb00ered to employees at a", "correct_answer": "commission"}, {"id": "25", "label": "............................. level Details of bonus payments: may be included in a contract or a handbook for staff If you think there has been a mistake with your pay: \\u2022 discuss the issue with your employer \\u2022 keep records of any relevant", "text": "............................. level Details of bonus payments: may be included in a contract or a handbook for staff If you think there has been a mistake with your pay: \\u2022 discuss the issue with your employer \\u2022 keep records of any relevant", "correct_answer": "senior"}, {"id": "26", "label": "............................. It is illegal for employers to discriminate against any specific group, e.g. by giving less money to", "text": "............................. It is illegal for employers to discriminate against any specific group, e.g. by giving less money to", "correct_answer": "meetings/letters"}, {"id": "27", "label": "............................. Advertisements", "text": "............................. Advertisements", "correct_answer": "women"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-34',
            'type' => 'matching_headings',
            'options' => '{"A": "reason for sore optimism"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Section A", "text": "Section A", "correct_answer": "vi"}, {"id": "29", "label": "Section B", "text": "Section B", "correct_answer": "iv"}, {"id": "30", "label": "Section C", "text": "Section C", "correct_answer": "ii"}, {"id": "31", "label": "Section D", "text": "Section D", "correct_answer": "viii"}, {"id": "32", "label": "Section E", "text": "Section E", "correct_answer": "v"}, {"id": "33", "label": "Section F", "text": "Section F", "correct_answer": "vii"}, {"id": "34", "label": "Section G", "text": "Section G", "correct_answer": "iii"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 35,
            'question_text' => 'Questions 35-37',
            'type' => 'multiple_choice',
            'options' => '{"A": "radical review of marine resource management is needed."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 34, "sub_questions": [{"id": "35", "label": "Boris Worm\'s main concern is that A marine ecosystems will completely break down. B insufficient attention is being paid to fish numbers. C there will no longer be enough seafood for people to eat. D politicians will be unwilling to discuss marine resources.", "text": "Boris Worm\'s main concern is that A marine ecosystems will completely break down. B insufficient attention is being paid to fish numbers. C there will no longer be enough seafood for people to eat. D politicians will be unwilling to discuss marine resources.", "correct_answer": "A"}, {"id": "36", "label": "What point does John Shepherd make? A Marine conservation areas are not high on the list of visitor attractions. B People know very little about how di\\ufb00erent species actually live. C The public are much less likely to help unattractive creatures. D The marine environment was better understood in the past.", "text": "What point does John Shepherd make? A Marine conservation areas are not high on the list of visitor attractions. B People know very little about how di\\ufb00erent species actually live. C The public are much less likely to help unattractive creatures. D The marine environment was better understood in the past.", "correct_answer": "C"}, {"id": "37", "label": "Which of the following best summarises the text as a whole? A Scientists disagree about the state of the world\'s oceans. B", "text": "Which of the following best summarises the text as a whole? A Scientists disagree about the state of the world\'s oceans. B", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 38,
            'question_text' => 'Questions 38-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 37, "sub_questions": [{"id": "38", "label": "............................. slowly contracting. The waters were full of di\\ufb00erent species of marine creatures, and there were large numbers of", "text": "............................. slowly contracting. The waters were full of di\\ufb00erent species of marine creatures, and there were large numbers of", "correct_answer": "glaciers"}, {"id": "39", "label": "............................. living on the wetlands along the shore. This continued until species began to decline 2,000 years ago. Overfishing was partly responsible for the changing circumstances, and so was pollution. At the same time there has been an increase in some nutrients in the Wadden Sea which can also destroy marine creatures and vegetation by depriving them of", "text": "............................. living on the wetlands along the shore. This continued until species began to decline 2,000 years ago. Overfishing was partly responsible for the changing circumstances, and so was pollution. At the same time there has been an increase in some nutrients in the Wadden Sea which can also destroy marine creatures and vegetation by depriving them of", "correct_answer": "birds"}, {"id": "40", "label": "............................. which is essential for their survival. IELTS General Reading Test 14 IELTS General", "text": "............................. which is essential for their survival. IELTS General Reading Test 14 IELTS General", "correct_answer": "oxygen"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 16 (material_id = 116) ===
        $matId = 116;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-6.',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "Question 1", "text": "Question 1", "correct_answer": "C"}, {"id": "2", "label": "Question 2", "text": "Question 2", "correct_answer": "A"}, {"id": "3", "label": "Question 3", "text": "Question 3", "correct_answer": "D"}, {"id": "4", "label": "Question 4", "text": "Question 4", "correct_answer": "A"}, {"id": "5", "label": "Question 5", "text": "Question 5", "correct_answer": "B"}, {"id": "6", "label": "Question 6", "text": "Question 6", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-8',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "It needs members who can find ways of increasing audience numbers.", "text": "It needs members who can find ways of increasing audience numbers.", "correct_answer": "C"}, {"id": "2", "label": "All its members perform in club concerts.", "text": "All its members perform in club concerts.", "correct_answer": "A"}, {"id": "3", "label": "It distributes information about musical events to its members.", "text": "It distributes information about musical events to its members.", "correct_answer": "D"}, {"id": "4", "label": "It requires its members to have reached a certain level as performers.", "text": "It requires its members to have reached a certain level as performers.", "correct_answer": "A"}, {"id": "5", "label": "One of its aims is to introduce its members to music they may not be familiar with.", "text": "One of its aims is to introduce its members to music they may not be familiar with.", "correct_answer": "B"}, {"id": "6", "label": "It helps children to develop their musical skills.", "text": "It helps children to develop their musical skills.", "correct_answer": "A"}, {"id": "7", "label": "Its performances are popular with local people.", "text": "Its performances are popular with local people.", "correct_answer": "C"}, {"id": "8", "label": "It helps people who are in financial need. Read the text below and answer Questions 9-14. Biological Research Institute Welcome to the Biological Research Institute campus. We hope that your visit will be enjoyable and interesting. Please read the information below and comply with the instructions given. On arrival, you should report to the Reception building by the main entrance gate, where you will be issued with a pass. This must be visible at all times during your visit to the campus. If you are driving a vehicle, please inform Reception. They will contact Security, who will identify the area where you should park your car. Please ensure that you park it in the designated area. You must keep to the campus speed limit (10 mph) at all times. Cars are parked at the owner\'s risk. For your own safety, please follow the instructions displayed on noticeboards around the campus, as well as all instructions issued by authorised personnel. Do not enter any restricted areas or touch any machinery or other equipment unless authorised. Visitors must be accompanied by their host at all times whilst on the campus. Entry into certain areas requires the wearing of special clothing or equipment. This will be provided for you by your host, who will advise you on the appropriate protection for the area you visit. Unless your host has previously obtained permission from the Institute management, photography, whether still or video, is not permitted in any part of the campus. Children under the age of 16 must be accompanied by an adult at all times, and should only be brought on campus if the Institute management has previously agreed to this. No nursery facilities are available for visiting children. In the event of an accident, call 3333 and request the assistance of site first-aid personnel.", "text": "It helps people who are in financial need. Read the text below and answer Questions 9-14. Biological Research Institute Welcome to the Biological Research Institute campus. We hope that your visit will be enjoyable and interesting. Please read the information below and comply with the instructions given. On arrival, you should report to the Reception building by the main entrance gate, where you will be issued with a pass. This must be visible at all times during your visit to the campus. If you are driving a vehicle, please inform Reception. They will contact Security, who will identify the area where you should park your car. Please ensure that you park it in the designated area. You must keep to the campus speed limit (10 mph) at all times. Cars are parked at the owner\'s risk. For your own safety, please follow the instructions displayed on noticeboards around the campus, as well as all instructions issued by authorised personnel. Do not enter any restricted areas or touch any machinery or other equipment unless authorised. Visitors must be accompanied by their host at all times whilst on the campus. Entry into certain areas requires the wearing of special clothing or equipment. This will be provided for you by your host, who will advise you on the appropriate protection for the area you visit. Unless your host has previously obtained permission from the Institute management, photography, whether still or video, is not permitted in any part of the campus. Children under the age of 16 must be accompanied by an adult at all times, and should only be brought on campus if the Institute management has previously agreed to this. No nursery facilities are available for visiting children. In the event of an accident, call 3333 and request the assistance of site first-aid personnel.", "correct_answer": "D"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 9,
            'question_text' => 'Questions 9-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 8, "sub_questions": [{"id": "9", "label": "If you come by car, ............................ will tell you where to park it.", "text": "If you come by car, ............................ will tell you where to park it.", "correct_answer": "security"}, {"id": "10", "label": "Advice on ............................ can be seen on noticeboards.", "text": "Advice on ............................ can be seen on noticeboards.", "correct_answer": "safety"}, {"id": "11", "label": "You will need to obtain authorisation before touching equipment such as ............................ .", "text": "You will need to obtain authorisation before touching equipment such as ............................ .", "correct_answer": "machinery"}, {"id": "12", "label": "Permission from the management is required if you want to do any kind of ............................ .", "text": "Permission from the management is required if you want to do any kind of ............................ .", "correct_answer": "photography"}, {"id": "13", "label": "The Institute does not provide a ............................ for children visiting the campus.", "text": "The Institute does not provide a ............................ for children visiting the campus.", "correct_answer": "nursery"}, {"id": "14", "label": "You should phone 3333 if any kind of ............................ occurs. Advertisements", "text": "You should phone 3333 if any kind of ............................ occurs. Advertisements", "correct_answer": "accident"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-20',
            'type' => 'summary_completion',
            'options' => '{"A": "project manager\'s main task is to bring a particular project to completion, both on time and within budget. There are many factors that can cause a project to veer off its tracks, but steps can be taken to ensure that your project experiences as little disruption as possible."}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "When negotiating a salary, potential employees should take advantage of the company\'s view of them as a useful ............................ .", "text": "When negotiating a salary, potential employees should take advantage of the company\'s view of them as a useful ............................ .", "correct_answer": "asset"}, {"id": "16", "label": "When negotiating a salary it is important to be aware of the company\'s particular", "text": "When negotiating a salary it is important to be aware of the company\'s particular", "correct_answer": "culture"}, {"id": "17", "label": "Some people use the ............................ to monitor salaries o\\ufb00ered for similar positions.", "text": "Some people use the ............................ to monitor salaries o\\ufb00ered for similar positions.", "correct_answer": "internet"}, {"id": "18", "label": "People who belong to a ............................ can ask for recommendations on what is the norm for payment in their field.", "text": "People who belong to a ............................ can ask for recommendations on what is the norm for payment in their field.", "correct_answer": "union"}, {"id": "19", "label": "Some people try to arrange for a ............................ of their salary to be carried out after an initial period.", "text": "Some people try to arrange for a ............................ of their salary to be carried out after an initial period.", "correct_answer": "review"}, {"id": "20", "label": "It is important to be willing to accept a ............................ if the negotiations are getting nowhere. Read the text and answer Questions 21-27. How to run a successful project", "text": "It is important to be willing to accept a ............................ if the negotiations are getting nowhere. Read the text and answer Questions 21-27. How to run a successful project", "correct_answer": "compromise"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "............................ for the project. \\u2193 Fix the details at the start to prevent what is called", "text": "............................ for the project. \\u2193 Fix the details at the start to prevent what is called", "correct_answer": "budget"}, {"id": "22", "label": "............................ - the client asking for more and more. \\u2193 Choose the team members wisely so that their", "text": "............................ - the client asking for more and more. \\u2193 Choose the team members wisely so that their", "correct_answer": "scope creep"}, {"id": "23", "label": "............................ match the duties you want them to take on. \\u2193 Promote good\\u00b7", "text": "............................ match the duties you want them to take on. \\u2193 Promote good\\u00b7", "correct_answer": "skills"}, {"id": "24", "label": "............................ at all times so everyone knows what you require of them. \\u2193 Make sure", "text": "............................ at all times so everyone knows what you require of them. \\u2193 Make sure", "correct_answer": "communication"}, {"id": "25", "label": "............................ are set so you can check whether the project is running to schedule. \\u2193 Prepare", "text": "............................ are set so you can check whether the project is running to schedule. \\u2193 Prepare", "correct_answer": "milestones"}, {"id": "26", "label": "............................ which can be activated if things go wrong on the project. \\u2193 Once the project is over, produce a", "text": "............................ which can be activated if things go wrong on the project. \\u2193 Once the project is over, produce a", "correct_answer": "plans"}, {"id": "27", "label": "............................ outlining its strengths and weaknesses for future reference. Advertisements", "text": "............................ outlining its strengths and weaknesses for future reference. Advertisements", "correct_answer": "report"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-30',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "a record that is being kept of manta rays in the area", "text": "a record that is being kept of manta rays in the area", "correct_answer": "D"}, {"id": "29", "label": "something that the writer regrets", "text": "something that the writer regrets", "correct_answer": "B"}, {"id": "30", "label": "the reason for the writer\'s visit", "text": "the reason for the writer\'s visit", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 31,
            'question_text' => 'Questions 31-36',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 30, "sub_questions": [{"id": "31", "label": "It is di\\ufb00icult to distinguish one manta ray from another.", "text": "It is di\\ufb00icult to distinguish one manta ray from another.", "correct_answer": "FALSE"}, {"id": "32", "label": "For hotel guests, viewing manta rays feeding has to be arranged at short notice.", "text": "For hotel guests, viewing manta rays feeding has to be arranged at short notice.", "correct_answer": "TRUE"}, {"id": "33", "label": "The manta rays appear to object to the presence of people in the water while they are feeding.", "text": "The manta rays appear to object to the presence of people in the water while they are feeding.", "correct_answer": "FALSE"}, {"id": "34", "label": "Guy Stevens is concerned about the increasing interest in Hanifaru.", "text": "Guy Stevens is concerned about the increasing interest in Hanifaru.", "correct_answer": "TRUE"}, {"id": "35", "label": "Mohamed Nasheed succeeded in persuading certain other countries to take steps to protect the environment.", "text": "Mohamed Nasheed succeeded in persuading certain other countries to take steps to protect the environment.", "correct_answer": "NOT GIVEN"}, {"id": "36", "label": "Question 36", "text": "Question 36", "correct_answer": "FALSE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 37,
            'question_text' => 'Questions 37-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 36, "sub_questions": [{"id": "37", "label": "............................ to feed on. They eat the same food as other species, such as giant whale sharks. As for keeping clean, they are kept free from", "text": "............................ to feed on. They eat the same food as other species, such as giant whale sharks. As for keeping clean, they are kept free from", "correct_answer": "plankton"}, {"id": "38", "label": "............................ by smaller fish. Manta rays have certain characteristics which make them good swimmers; they use their", "text": "............................ by smaller fish. Manta rays have certain characteristics which make them good swimmers; they use their", "correct_answer": "parasites"}, {"id": "39", "label": "............................ to get up speed and they have flattened bodies, which help them to move quickly through the water. The nature of the manta\'s", "text": "............................ to get up speed and they have flattened bodies, which help them to move quickly through the water. The nature of the manta\'s", "correct_answer": "wings"}, {"id": "40", "label": "............................ is of particular interest to scientists. IELTS General Reading Test 15 IELTS General", "text": "............................ is of particular interest to scientists. IELTS General Reading Test 15 IELTS General", "correct_answer": "brain"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 17 (material_id = 117) ===
        $matId = 117;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-5',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "Children must go to the school where they are registered.", "text": "Children must go to the school where they are registered.", "correct_answer": "TRUE"}, {"id": "2", "label": "All arrivals after the register has closed are recorded as \\u2018unauthorised\\u2019 absences.", "text": "All arrivals after the register has closed are recorded as \\u2018unauthorised\\u2019 absences.", "correct_answer": "FALSE"}, {"id": "3", "label": "If your child is absent from school, you must send the school a letter to explain why.", "text": "If your child is absent from school, you must send the school a letter to explain why.", "correct_answer": "NOT GIVEN"}, {"id": "4", "label": "Staff who think a child is having difficulties at school will contact the parents.", "text": "Staff who think a child is having difficulties at school will contact the parents.", "correct_answer": "NOT GIVEN"}, {"id": "5", "label": "Schools will contact other authorities about children who take frequent unauthorised absences. Read the text below and answer Questions 6-14. HOLIDAY APARTMENTS TO LET A Sleeps 2-3. One-bedroom apartment with uninterrupted sea views. This is a small first-floor apartment in a well-established apartment complex containing a range of leisure facilities and a supermarket for residents. On the edge of the town but close to cafes and restaurants. On-street parking is generally available. B Sleeps 2-4. Spacious one-bedroom apartment in a complex that has only just opened, five minutes\\u2019 walk from the sea. Private parking in front of the building. It is located in a quiet, unspoilt village with a local market, banks, caf\\u00e9s and restaurants. There are some fabulous championship golf courses within easy walking distance. C Sleeps 2+child. One-bedroom cottage (child\\u2019s bed can also be provided), large terrace with uninterrupted views of the river and mountains. A truly peaceful location in a picturesque village, but less than ten minutes\\u2019 drive from the coast and all the amenities of a town. Owners live nearby and are happy to help in any way they can. D Sleeps 2-5. Two-bedroom apartment in a complex with its own pool and beautiful views of the national park. A peaceful location just 3 km from the town centre, where there are plenty of shops and excellent sports facilities. Superb local golf courses within easy reach. E Sleeps 2-4. Modern one-bedroom first-floor apartment in the house, owners resident on the ground floor. This great location offers easy access to all that this fantastic town has to offer, a few minutes\\u2019 drive from its supermarket, bank, cafes, restaurants. The ferry to the island beach leaves from 100 m away. Ten minutes walk from the new shopping centre, which has many shops, food hall, cinema and multi-storey car park. F Sleeps 2. One-bedroom first-floor apartment. Beautifully furnished, offering a high standard of comfort. Situated in a peaceful location on the edge of an inland village, with attractive views of the golf course. Many restaurants, bars, shops etc. are within easy walking distance. Garage available by arrangement with the owners. G Sleeps 2-4. Two-bedroom apartment in central location in the busy street with shops, restaurants etc. not far from the beach. The town has ideal facilities for holidays all year round, including swimming pool, tennis courts and golf course.", "text": "Schools will contact other authorities about children who take frequent unauthorised absences. Read the text below and answer Questions 6-14. HOLIDAY APARTMENTS TO LET A Sleeps 2-3. One-bedroom apartment with uninterrupted sea views. This is a small first-floor apartment in a well-established apartment complex containing a range of leisure facilities and a supermarket for residents. On the edge of the town but close to cafes and restaurants. On-street parking is generally available. B Sleeps 2-4. Spacious one-bedroom apartment in a complex that has only just opened, five minutes\\u2019 walk from the sea. Private parking in front of the building. It is located in a quiet, unspoilt village with a local market, banks, caf\\u00e9s and restaurants. There are some fabulous championship golf courses within easy walking distance. C Sleeps 2+child. One-bedroom cottage (child\\u2019s bed can also be provided), large terrace with uninterrupted views of the river and mountains. A truly peaceful location in a picturesque village, but less than ten minutes\\u2019 drive from the coast and all the amenities of a town. Owners live nearby and are happy to help in any way they can. D Sleeps 2-5. Two-bedroom apartment in a complex with its own pool and beautiful views of the national park. A peaceful location just 3 km from the town centre, where there are plenty of shops and excellent sports facilities. Superb local golf courses within easy reach. E Sleeps 2-4. Modern one-bedroom first-floor apartment in the house, owners resident on the ground floor. This great location offers easy access to all that this fantastic town has to offer, a few minutes\\u2019 drive from its supermarket, bank, cafes, restaurants. The ferry to the island beach leaves from 100 m away. Ten minutes walk from the new shopping centre, which has many shops, food hall, cinema and multi-storey car park. F Sleeps 2. One-bedroom first-floor apartment. Beautifully furnished, offering a high standard of comfort. Situated in a peaceful location on the edge of an inland village, with attractive views of the golf course. Many restaurants, bars, shops etc. are within easy walking distance. Garage available by arrangement with the owners. G Sleeps 2-4. Two-bedroom apartment in central location in the busy street with shops, restaurants etc. not far from the beach. The town has ideal facilities for holidays all year round, including swimming pool, tennis courts and golf course.", "correct_answer": "NOT GIVEN"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 6,
            'question_text' => 'Questions 6-14',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 5, "sub_questions": [{"id": "6", "label": "It overlooks a golf course.", "text": "It overlooks a golf course.", "correct_answer": "F"}, {"id": "7", "label": "It has its own parking space.", "text": "It has its own parking space.", "correct_answer": "B"}, {"id": "8", "label": "It is in the centre of a town.", "text": "It is in the centre of a town.", "correct_answer": "G"}, {"id": "9", "label": "The sea can be seen from it.", "text": "The sea can be seen from it.", "correct_answer": "A"}, {"id": "10", "label": "There is a swimming pool for residents of the apartment complex.", "text": "There is a swimming pool for residents of the apartment complex.", "correct_answer": "D"}, {"id": "11", "label": "It is in a new apartment complex.", "text": "It is in a new apartment complex.", "correct_answer": "B"}, {"id": "12", "label": "It is part of an apartment complex with its own supermarket.", "text": "It is part of an apartment complex with its own supermarket.", "correct_answer": "A"}, {"id": "13", "label": "It has a private outdoor area where you can sit.", "text": "It has a private outdoor area where you can sit.", "correct_answer": "C"}, {"id": "14", "label": "The owners will organise parking on request Advertisements", "text": "The owners will organise parking on request Advertisements", "correct_answer": "F"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-21',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 (Note: additional requirements for applicants interested in the role of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 (Note: additional requirements for applicants interested in the role of", "correct_answer": "marketing environment"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026) \\u2193 Stage Two \\u2013 Telephone discussion \\u2022 More information is given about company and the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026) \\u2193 Stage Two \\u2013 Telephone discussion \\u2022 More information is given about company and the", "correct_answer": "Corporate Travel Consultant"}, {"id": "17", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you could receive. \\u2022 Information about the annual event, where the prizes are given to those who have made", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you could receive. \\u2022 Information about the annual event, where the prizes are given to those who have made", "correct_answer": "rewards"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2193 Stage Three \\u2013 Group interview \\u2022 Chance to tell us about how good you are at selling, and also about the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 \\u2193 Stage Three \\u2013 Group interview \\u2022 Chance to tell us about how good you are at selling, and also about the", "correct_answer": "outstanding efforts"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you have. \\u2022 Take part in a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you have. \\u2022 Take part in a", "correct_answer": "ambitions"}, {"id": "20", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 (used to learn about your way of working) \\u2022 Information given on benefits (e.g. health consultations) \\u2193 Stage Four \\u2013 Individual interview \\u2022 Meet a manager, and the", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 (used to learn about your way of working) \\u2022 Information given on benefits (e.g. health consultations) \\u2193 Stage Four \\u2013 Individual interview \\u2022 Meet a manager, and the", "correct_answer": "psychometric test"}, {"id": "21", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 working in a particular store. \\u2193 Stage Five \\u2013 Job offer \\u2022 Job offer sent out to successful applicants. Read the text below and answer Questions 22-27. Hilton Laboratory Health and safety in the workplace Personal safety You must be familiar with the emergency procedures in your building so that you know what to do in the event of fire, spillages or other accidents. Do not enter restricted areas without authorisation, and at all times observe the warnings given. Do not wedge open fire doors or tamper with door closures, and do not block doorways, corridors or stairs, as ob\\u00adstructions may affect access in the event of a fire. Avoid leaving drawers and doors open unnecessarily and do not trail cables or flexes across the floor. How to dispose of rubbish safely We aim to protect the environment by saving and recycling glass, waste paper, and an increasing range of other materials. It is important to check materials carefully for con\\u00adtamination before placing them in recycling containers. Never put sharp objects such as razor blades or broken glass into waste bins without having wrapped the items carefully to protect those emptying the bins. Other waste procedures may vary \\u2013 contact your Building Manager or Divisional Safety Officer for advice with regard to your particular department. How to handle heavy objects Make sure that shelves are not overloaded and that glass and heavy objects are stored at working height where they will be easier to reach. Use steps or ladders to reach items at height; never climb on benches, tables or chairs. Never move anything that is beyond your capability. Wherever possible you should use the trolleys provided in the workplace to do the job for you. If repetitive manual operations are routine in your work, your department will ensure you receive appropriate instruction on safe working practices and posture. Staying alert If you become mentally or physically tired during the working day, and find that you\\u2019re feeling drowsy or not concentrating properly, you could be at risk of causing an accident or making a mistake that could harm you or your colleagues. To prevent this, make sure that you take regular breaks when necessary.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 working in a particular store. \\u2193 Stage Five \\u2013 Job offer \\u2022 Job offer sent out to successful applicants. Read the text below and answer Questions 22-27. Hilton Laboratory Health and safety in the workplace Personal safety You must be familiar with the emergency procedures in your building so that you know what to do in the event of fire, spillages or other accidents. Do not enter restricted areas without authorisation, and at all times observe the warnings given. Do not wedge open fire doors or tamper with door closures, and do not block doorways, corridors or stairs, as ob\\u00adstructions may affect access in the event of a fire. Avoid leaving drawers and doors open unnecessarily and do not trail cables or flexes across the floor. How to dispose of rubbish safely We aim to protect the environment by saving and recycling glass, waste paper, and an increasing range of other materials. It is important to check materials carefully for con\\u00adtamination before placing them in recycling containers. Never put sharp objects such as razor blades or broken glass into waste bins without having wrapped the items carefully to protect those emptying the bins. Other waste procedures may vary \\u2013 contact your Building Manager or Divisional Safety Officer for advice with regard to your particular department. How to handle heavy objects Make sure that shelves are not overloaded and that glass and heavy objects are stored at working height where they will be easier to reach. Use steps or ladders to reach items at height; never climb on benches, tables or chairs. Never move anything that is beyond your capability. Wherever possible you should use the trolleys provided in the workplace to do the job for you. If repetitive manual operations are routine in your work, your department will ensure you receive appropriate instruction on safe working practices and posture. Staying alert If you become mentally or physically tired during the working day, and find that you\\u2019re feeling drowsy or not concentrating properly, you could be at risk of causing an accident or making a mistake that could harm you or your colleagues. To prevent this, make sure that you take regular breaks when necessary.", "correct_answer": "team"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 22,
            'question_text' => 'Questions 22-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 21, "sub_questions": [{"id": "22", "label": "There are certain places in the building that staff should avoid unless they have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "text": "There are certain places in the building that staff should avoid unless they have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026", "correct_answer": "authorization/ authorisation"}, {"id": "23", "label": "To ensure people can get out easily, it is important that there are no \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to exits.", "text": "To ensure people can get out easily, it is important that there are no \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to exits.", "correct_answer": "obstructions"}, {"id": "24", "label": "Items which could cause injury must be \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 before they are disposed of.", "text": "Items which could cause injury must be \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 before they are disposed of.", "correct_answer": "wrapped/ wrapped"}, {"id": "25", "label": "Question 25", "text": "Question 25", "correct_answer": "waste/ rubbish"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 are available to make tasks, which require moving objects easier.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 are available to make tasks, which require moving objects easier.", "correct_answer": "Trolleys"}, {"id": "27", "label": "You should have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 while you are working. Advertisements", "text": "You should have \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 while you are working. Advertisements", "correct_answer": "breaks"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-34',
            'type' => 'matching_headings',
            'options' => '{"A": "decrease in the zebra population"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Section A", "text": "Section A", "correct_answer": "vi"}, {"id": "29", "label": "Section B", "text": "Section B", "correct_answer": "viii"}, {"id": "30", "label": "Section C", "text": "Section C", "correct_answer": "iv"}, {"id": "31", "label": "Section D", "text": "Section D", "correct_answer": "ii"}, {"id": "32", "label": "Section E", "text": "Section E", "correct_answer": "ix"}, {"id": "33", "label": "Section F", "text": "Section F", "correct_answer": "vii"}, {"id": "34", "label": "Section G", "text": "Section G", "correct_answer": "x"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 35,
            'question_text' => 'Questions 35-37',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 34, "sub_questions": [{"id": "35", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... . Here, a male zebra has charge of a number of adult", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... . Here, a male zebra has charge of a number of adult", "correct_answer": "harems"}, {"id": "36", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... and their young. These units sometimes assemble in bigger groupings or", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... and their young. These units sometimes assemble in bigger groupings or", "correct_answer": "mares"}, {"id": "37", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026..., but it is still clear that the zebras\\u2019 loyalty only extends to the small unit they live in.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026..., but it is still clear that the zebras\\u2019 loyalty only extends to the small unit they live in.", "correct_answer": "herds"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 38,
            'question_text' => 'Questions 38-40',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 37, "sub_questions": [{"id": "38", "label": "How did Hattie feel when she heard some of the zebras had travelled so far? A annoyed because she would have to follow them to Makgadikgadi B disappointed that not all of them made it back to Okavango C frustrated as the rains had made the roads unusable D unsure as to their real motivation for going", "text": "How did Hattie feel when she heard some of the zebras had travelled so far? A annoyed because she would have to follow them to Makgadikgadi B disappointed that not all of them made it back to Okavango C frustrated as the rains had made the roads unusable D unsure as to their real motivation for going", "correct_answer": "D"}, {"id": "39", "label": "When describing the different Botswana zebra populations, the writer indicates A his admiration for the ones who migrate the furthest distance. B his sympathy for the ones who stay by the Okavango River. C his disbelief that those by the Boteti have difficulty finding food. D his anxiety that their migration patterns may not be able to continue.", "text": "When describing the different Botswana zebra populations, the writer indicates A his admiration for the ones who migrate the furthest distance. B his sympathy for the ones who stay by the Okavango River. C his disbelief that those by the Boteti have difficulty finding food. D his anxiety that their migration patterns may not be able to continue.", "correct_answer": "A"}, {"id": "40", "label": "What does the writer suggest in the final paragraph? A Too much time has been wasted on research into the predators like lions. B it is sometimes necessary to go against the trend in research matters. C Research will result in a ban on fences in areas where zebras live. D Research into animals which are not endangered will increase. IELTS General Reading Test 16 IELTS General", "text": "What does the writer suggest in the final paragraph? A Too much time has been wasted on research into the predators like lions. B it is sometimes necessary to go against the trend in research matters. C Research will result in a ban on fences in areas where zebras live. D Research into animals which are not endangered will increase. IELTS General Reading Test 16 IELTS General", "correct_answer": "B"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 18 (material_id = 118) ===
        $matId = 118;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-6',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "More children are injured when walking or cycling to school than when travelling by car.", "text": "More children are injured when walking or cycling to school than when travelling by car.", "correct_answer": "NOT GIVEN"}, {"id": "2", "label": "Children who are driven to school are more ready to learn than those who walk or cycle.", "text": "Children who are driven to school are more ready to learn than those who walk or cycle.", "correct_answer": "FALSE"}, {"id": "3", "label": "Every year the Council gathers information about travel to schools.", "text": "Every year the Council gathers information about travel to schools.", "correct_answer": "TRUE"}, {"id": "4", "label": "The Council is disappointed with the small reduction in the number of cars taking children to school.", "text": "The Council is disappointed with the small reduction in the number of cars taking children to school.", "correct_answer": "FALSE"}, {"id": "5", "label": "The number of children in schools has risen in recent years.", "text": "The number of children in schools has risen in recent years.", "correct_answer": "TRUE"}, {"id": "6", "label": "Parents can get help with paying for their children to travel to school by public transport. Read the text below and answer Questions 7-14. Flu: the facts A Flu (influenza) is an acute viral respiratory infection. It spreads easily from person to person: at home, at school, at work, at the supermarket or on the train. B It gets passed on when someone who already has flu coughs or sneezes and is transmitted through the air by droplets, or it can be spread by hands infected by the virus. C Symptoms can include fever, chills, headache, muscle pain, extreme fatigue, a dry cough, sore throat and stuffy nose. Most people will recover within a week but flu can cause severe illness or even death in people at high risk. It is estimated that 18,500-24,800 deaths in England and Wales are attributable to influenza infections annually. D Vaccination is the most effective way to prevent infection. Although anyone can catch flu, certain people are at greater risk from the implications of flu, as their bodies may not be able to fight the virus. If you are over 65 years old, or suffer from asthma, diabetes, or certain other conditions, you are considered at greater risk from flu and the implications can be serious. If you fall into one of these \\u2018at-risk\\u2019 groups, are pregnant or a carer, you are eligible for a free flu vaccination. E If you are not eligible for a free flu vaccination, you can still protect yourself and those around you from flu by getting a flu vaccination at a local pharmacy. F About seven to ten days after vaccination, your body makes antibodies that help to protect you against any similar viruses that may infect you. This protection lasts about a year. G", "text": "Parents can get help with paying for their children to travel to school by public transport. Read the text below and answer Questions 7-14. Flu: the facts A Flu (influenza) is an acute viral respiratory infection. It spreads easily from person to person: at home, at school, at work, at the supermarket or on the train. B It gets passed on when someone who already has flu coughs or sneezes and is transmitted through the air by droplets, or it can be spread by hands infected by the virus. C Symptoms can include fever, chills, headache, muscle pain, extreme fatigue, a dry cough, sore throat and stuffy nose. Most people will recover within a week but flu can cause severe illness or even death in people at high risk. It is estimated that 18,500-24,800 deaths in England and Wales are attributable to influenza infections annually. D Vaccination is the most effective way to prevent infection. Although anyone can catch flu, certain people are at greater risk from the implications of flu, as their bodies may not be able to fight the virus. If you are over 65 years old, or suffer from asthma, diabetes, or certain other conditions, you are considered at greater risk from flu and the implications can be serious. If you fall into one of these \\u2018at-risk\\u2019 groups, are pregnant or a carer, you are eligible for a free flu vaccination. E If you are not eligible for a free flu vaccination, you can still protect yourself and those around you from flu by getting a flu vaccination at a local pharmacy. F About seven to ten days after vaccination, your body makes antibodies that help to protect you against any similar viruses that may infect you. This protection lasts about a year. G", "correct_answer": "NOT GIVEN"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 7,
            'question_text' => 'Questions 7-14',
            'type' => 'matching_paragraph_information',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 6, "sub_questions": [{"id": "7", "label": "examples of people who are likely to be particularly badly affected by flu", "text": "examples of people who are likely to be particularly badly affected by flu", "correct_answer": "D"}, {"id": "8", "label": "how to get a vaccination if you choose to pay for it", "text": "how to get a vaccination if you choose to pay for it", "correct_answer": "E"}, {"id": "9", "label": "why new vaccines become available", "text": "why new vaccines become available", "correct_answer": "I"}, {"id": "10", "label": "how long a vaccine remains effective", "text": "how long a vaccine remains effective", "correct_answer": "F"}, {"id": "11", "label": "reference to the possibility of catching a different type of flu from the ones in the vaccine", "text": "reference to the possibility of catching a different type of flu from the ones in the vaccine", "correct_answer": "H"}, {"id": "12", "label": "categories of people who do not have to pay for vaccination", "text": "categories of people who do not have to pay for vaccination", "correct_answer": "D"}, {"id": "13", "label": "information about what a vaccine consists of", "text": "information about what a vaccine consists of", "correct_answer": "G"}, {"id": "14", "label": "signs that you might have flu Advertisements", "text": "signs that you might have flu Advertisements", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15-22',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "Practising your presentation on a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 or a family member is helpful.", "text": "Practising your presentation on a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 or a family member is helpful.", "correct_answer": "colleague"}, {"id": "16", "label": "Be prepared for a problem such as a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "text": "Be prepared for a problem such as a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 .", "correct_answer": "power cut"}, {"id": "17", "label": "One way to overcome pre-presentation nerves is to make your \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 less rapid.", "text": "One way to overcome pre-presentation nerves is to make your \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 less rapid.", "correct_answer": "breathing"}, {"id": "18", "label": "It is acceptable to do something called a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 at the start of the presentation to reassure you.", "text": "It is acceptable to do something called a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 at the start of the presentation to reassure you.", "correct_answer": "displacement activity"}, {"id": "19", "label": "Your presentation should be like a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 with the people who have come to hear you.", "text": "Your presentation should be like a \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 with the people who have come to hear you.", "correct_answer": "conversation"}, {"id": "20", "label": "Check constantly for \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to the points you are making.", "text": "Check constantly for \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to the points you are making.", "correct_answer": "reactions"}, {"id": "21", "label": "Make sure you use plenty of \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to communicate your message effectively.", "text": "Make sure you use plenty of \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to communicate your message effectively.", "correct_answer": "examples"}, {"id": "22", "label": "To keep the presentation short, use things like \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to provide extra details. Read the text below and answer Questions 23-27. How to get a job in journalism You can get a good qualification in journalism, but what employers actually want is practical, rather than theoretical, knowledge. There\\u2019s no substitute for creating real stories that have to be handed in by strict deadlines. So write for your school magazine, then maybe try your hand at editing. Once you\\u2019ve done that for a while, start requesting internships in newspapers in the area. These are generally short-term and unpaid, but they\\u2019re definitely worthwhile, since, instead of providing you with money, they\\u2019ll teach you the skills that every twenty-first-century journalist has to have, like laying out articles, creating web pages, taking good digital pictures and so on. Most reporters keep a copy of every story they\\u2019ve had published, from secondary school onwards. They\\u2019re called cuttings, and you need them to get a job \\u2014 indeed a few impressive ones can be the deciding factor in whether you\\u2019re appointed or not. So start creating a portfolio now that will show off your developing talent. It seems obvious \\u2013 research is an important part of an effective job hunt. But it\\u2019s surprising how many would-be journalists do little or none. If you\\u2019re thorough, it can help you decide whether the job you\\u2019re thinking about applying for is right for you. And nothing impresses an editor more than an applicant who knows a lot about the paper. There are two more elements to an application \\u2013 your covering letter and curriculum vitae. However, your CV is the thing that will attract an editor\\u2019s attention first, so get it right. The key words are brevity, (no more than one page) accuracy (absolutely no spelling or typing errors) and clarity (it should be easy to follow). In journalism, good writing skills are essential, so it\\u2019s critical that the style of your letter is appropriate. And, make sure it conveys your love of journalism and your eagerness to do the work.", "text": "To keep the presentation short, use things like \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 to provide extra details. Read the text below and answer Questions 23-27. How to get a job in journalism You can get a good qualification in journalism, but what employers actually want is practical, rather than theoretical, knowledge. There\\u2019s no substitute for creating real stories that have to be handed in by strict deadlines. So write for your school magazine, then maybe try your hand at editing. Once you\\u2019ve done that for a while, start requesting internships in newspapers in the area. These are generally short-term and unpaid, but they\\u2019re definitely worthwhile, since, instead of providing you with money, they\\u2019ll teach you the skills that every twenty-first-century journalist has to have, like laying out articles, creating web pages, taking good digital pictures and so on. Most reporters keep a copy of every story they\\u2019ve had published, from secondary school onwards. They\\u2019re called cuttings, and you need them to get a job \\u2014 indeed a few impressive ones can be the deciding factor in whether you\\u2019re appointed or not. So start creating a portfolio now that will show off your developing talent. It seems obvious \\u2013 research is an important part of an effective job hunt. But it\\u2019s surprising how many would-be journalists do little or none. If you\\u2019re thorough, it can help you decide whether the job you\\u2019re thinking about applying for is right for you. And nothing impresses an editor more than an applicant who knows a lot about the paper. There are two more elements to an application \\u2013 your covering letter and curriculum vitae. However, your CV is the thing that will attract an editor\\u2019s attention first, so get it right. The key words are brevity, (no more than one page) accuracy (absolutely no spelling or typing errors) and clarity (it should be easy to follow). In journalism, good writing skills are essential, so it\\u2019s critical that the style of your letter is appropriate. And, make sure it conveys your love of journalism and your eagerness to do the work.", "correct_answer": "handouts"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 23,
            'question_text' => 'Questions 23-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 22, "sub_questions": [{"id": "23", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 with local papers and acquire the extra", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 with local papers and acquire the extra", "correct_answer": "internships"}, {"id": "24", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you\\u2019ll need. \\u2193 Build up a set of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 you\\u2019ll need. \\u2193 Build up a set of", "correct_answer": "skills"}, {"id": "25", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in a portfolio, displaying how your writing ability has progressed over time. \\u2193 Take time to do detailed", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 in a portfolio, displaying how your writing ability has progressed over time. \\u2193 Take time to do detailed", "correct_answer": "cuttings"}, {"id": "26", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 first, before applying for a post with a paper. \\u2193 Once you decide to apply, make sure your CV is short, makes sense and is without", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 first, before applying for a post with a paper. \\u2193 Once you decide to apply, make sure your CV is short, makes sense and is without", "correct_answer": "research"}, {"id": "27", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of any kind. \\u2193 Write your covering letter, paying particular attention to the style. Advertisements", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026 of any kind. \\u2193 Write your covering letter, paying particular attention to the style. Advertisements", "correct_answer": "errors"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-35',
            'type' => 'matching_headings',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Section A", "text": "Section A", "correct_answer": "viii"}, {"id": "29", "label": "Section B", "text": "Section B", "correct_answer": "ii"}, {"id": "30", "label": "Section C", "text": "Section C", "correct_answer": "x"}, {"id": "31", "label": "Section D", "text": "Section D", "correct_answer": "iv"}, {"id": "32", "label": "Section E", "text": "Section E", "correct_answer": "vii"}, {"id": "33", "label": "Section F", "text": "Section F", "correct_answer": "v"}, {"id": "34", "label": "Section G", "text": "Section G", "correct_answer": "iii"}, {"id": "35", "label": "Section H", "text": "Section H", "correct_answer": "vi"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 36,
            'question_text' => 'Questions 36-40',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 35, "sub_questions": [{"id": "36", "label": "Perriss encourages staff to offer help to all customers.", "text": "Perriss encourages staff to offer help to all customers.", "correct_answer": "FALSE"}, {"id": "37", "label": "Perriss is sometimes worried that customers will arrive before the store is ready for them.", "text": "Perriss is sometimes worried that customers will arrive before the store is ready for them.", "correct_answer": "TRUE"}, {"id": "38", "label": "When Perriss first became a store manager, he knew the store was going to close.", "text": "When Perriss first became a store manager, he knew the store was going to close.", "correct_answer": "NOT GIVEN"}, {"id": "39", "label": "On average, produce worth \\u00a34,200 is thrown away every week.", "text": "On average, produce worth \\u00a34,200 is thrown away every week.", "correct_answer": "FALSE"}, {"id": "40", "label": "Perriss was surprised how many staff asked about promotion on the \\u2018talent\\u2019 day. IELTS General Reading Test 17 IELTS General", "text": "Perriss was surprised how many staff asked about promotion on the \\u2018talent\\u2019 day. IELTS General Reading Test 17 IELTS General", "correct_answer": "NOT GIVEN"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === GT TEST 19 (material_id = 119) ===
        $matId = 119;
        $existingPassages = DB::table('ielts_reading_passages')->where('material_id', $matId)->pluck('id');
        if ($existingPassages->isNotEmpty()) {
            DB::table('ielts_reading_questions')->whereIn('passage_id', $existingPassages)->delete();
            DB::table('ielts_reading_passages')->where('material_id', $matId)->delete();
        }

        // Passage 1: Section 1
        $p1Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 1',
            'content' => '',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 1,
            'question_text' => 'Questions 1-6',
            'type' => 'matching_paragraph_information',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D", "E": "Option E", "F": "Option F", "G": "Option G", "H": "Option H"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 0, "sub_questions": [{"id": "1", "label": "learning what all the different sections of a plant do", "text": "learning what all the different sections of a plant do", "correct_answer": "F"}, {"id": "2", "label": "seeing art showing plants from a different part of the world", "text": "seeing art showing plants from a different part of the world", "correct_answer": "H"}, {"id": "3", "label": "the possibility of having your work exhibited", "text": "the possibility of having your work exhibited", "correct_answer": "E"}, {"id": "4", "label": "learning about why human beings need plants", "text": "learning about why human beings need plants", "correct_answer": "G"}, {"id": "5", "label": "something that happens daily at the same times", "text": "something that happens daily at the same times", "correct_answer": "D"}, {"id": "6", "label": "learning about the relationship between various creatures, insects and plants Read the text below and answer Questions 7-14. City Park and Ride We have six purpose-built Park and Ride sites serving the city, more than almost anywhere else in the UK. Established for over 40 years, they provide around 5,000 parking spaces for cars. The sites are located on the main routes into the city centre. More than 3,000,000 passengers a year take a bus from a Park and Ride site into the city, reducing congestion and helping to improve the air quality in the city centre. Parking at the sites is available only for those travelling from the site on a Park and Ride or other scheduled bus services, and is free. No overnight parking is permitted. Heavy goods vehicles are not permitted at the Park and Ride site at any time. It\\u2019s simple to use. Just park your car and buy your bus ticket from the bus driver, with the correct money if possible. An individual adult daily return purchased prior to 12:30 hrs for use chat day costs \\u00a32.40. If purchased after 12:30 hrs it costs \\u00a32.10. Up to four children under 16 travel free with an adult or concessionary pass holder. The return fare for unaccompanied children under 16 is \\u00a31.10. Cycle and Ride for just \\u00a31.10 a day. Just park your cycle, motorcycle or scooter in the allocated space, and buy your ticket from the site office. You may be asked to provide evidence that you have travelled to the Park and Ride site by cycle, motorcycle or scooter. Return tickets for concessionary bus pass holders cost \\u00a31 after 09:30 Monday to Friday and any time at the weekend or bank holidays (when open). At other times there is no reduction for holders of concessionary bus passes.", "text": "learning about the relationship between various creatures, insects and plants Read the text below and answer Questions 7-14. City Park and Ride We have six purpose-built Park and Ride sites serving the city, more than almost anywhere else in the UK. Established for over 40 years, they provide around 5,000 parking spaces for cars. The sites are located on the main routes into the city centre. More than 3,000,000 passengers a year take a bus from a Park and Ride site into the city, reducing congestion and helping to improve the air quality in the city centre. Parking at the sites is available only for those travelling from the site on a Park and Ride or other scheduled bus services, and is free. No overnight parking is permitted. Heavy goods vehicles are not permitted at the Park and Ride site at any time. It\\u2019s simple to use. Just park your car and buy your bus ticket from the bus driver, with the correct money if possible. An individual adult daily return purchased prior to 12:30 hrs for use chat day costs \\u00a32.40. If purchased after 12:30 hrs it costs \\u00a32.10. Up to four children under 16 travel free with an adult or concessionary pass holder. The return fare for unaccompanied children under 16 is \\u00a31.10. Cycle and Ride for just \\u00a31.10 a day. Just park your cycle, motorcycle or scooter in the allocated space, and buy your ticket from the site office. You may be asked to provide evidence that you have travelled to the Park and Ride site by cycle, motorcycle or scooter. Return tickets for concessionary bus pass holders cost \\u00a31 after 09:30 Monday to Friday and any time at the weekend or bank holidays (when open). At other times there is no reduction for holders of concessionary bus passes.", "correct_answer": "C"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p1Id,
            'question_number' => 7,
            'question_text' => 'Questions 7-14',
            'type' => 'true_false_not_given',
            'options' => '{"TRUE": "TRUE", "FALSE": "FALSE", "NOT GIVEN": "NOT GIVEN"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 6, "sub_questions": [{"id": "7", "label": "This was one of the first UK cities to introduce a Park and Ride scheme.", "text": "This was one of the first UK cities to introduce a Park and Ride scheme.", "correct_answer": "NOT GIVEN"}, {"id": "8", "label": "The amount of congestion in the city centre has fallen.", "text": "The amount of congestion in the city centre has fallen.", "correct_answer": "TRUE"}, {"id": "9", "label": "There is a special section of the car park for heavy goods vehicles.", "text": "There is a special section of the car park for heavy goods vehicles.", "correct_answer": "FALSE"}, {"id": "10", "label": "Bus drivers do not give change so you must have the correct money for a ticket.", "text": "Bus drivers do not give change so you must have the correct money for a ticket.", "correct_answer": "FALSE"}, {"id": "11", "label": "Ticket prices vary depending on the time of day.", "text": "Ticket prices vary depending on the time of day.", "correct_answer": "TRUE"}, {"id": "12", "label": "Children under 16 travelling alone are allowed free travel.", "text": "Children under 16 travelling alone are allowed free travel.", "correct_answer": "FALSE"}, {"id": "13", "label": "The space for cycles, motorcycles and scooters is close to the site office.", "text": "The space for cycles, motorcycles and scooters is close to the site office.", "correct_answer": "NOT GIVEN"}, {"id": "14", "label": "People with concessionary bus passes must pay the full fare to travel at certain times. Advertisements", "text": "People with concessionary bus passes must pay the full fare to travel at certain times. Advertisements", "correct_answer": "TRUE"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 2: Section 2
        $p2Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 2',
            'content' => '',
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 15,
            'question_text' => 'Questions 15 -20',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 14, "sub_questions": [{"id": "15", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... times or when other annual conferences occur \\u2013 check accessibility by different modes of transport \\u2013 choose a place with a large hall and also", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... times or when other annual conferences occur \\u2013 check accessibility by different modes of transport \\u2013 choose a place with a large hall and also", "correct_answer": "holiday"}, {"id": "16", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... spaces for smaller meetings Speakers: \\u2013 choose appropriate speakers \\u2013 give the speakers as much", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... spaces for smaller meetings Speakers: \\u2013 choose appropriate speakers \\u2013 give the speakers as much", "correct_answer": "breakout"}, {"id": "17", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... as possible Communication: \\u2013 send out a mailshot to potential delegates \\u2013 confirm individual details with speakers, check if they will need accommodation and request a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... as possible Communication: \\u2013 send out a mailshot to potential delegates \\u2013 confirm individual details with speakers, check if they will need accommodation and request a", "correct_answer": "notice"}, {"id": "18", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... of their presentation Final tasks: \\u2013 give the venue precise numbers of attendees \\u2013 make sure each person attending receives information about the conference and a", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... of their presentation Final tasks: \\u2013 give the venue precise numbers of attendees \\u2013 make sure each person attending receives information about the conference and a", "correct_answer": "summary"}, {"id": "19", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... for identification \\u2013 use", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... for identification \\u2013 use", "correct_answer": "badge"}, {"id": "20", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... to get opinions on the conference Read the text below and answer Questions 21-27 How to deal with the annual performance appraisal The annual performance appraisal can help improve your productivity and provide a foundation for your work priorities. It is, however, critical to have the right attitude and approach. Knowing what areas your superiors see as your weaknesses is the most direct way of increasing the likelihood of being considered for promotion, if that is what you are looking for. Preparation Send your boss a summary of your achievements. Reminding your boss of activities, special assignments you did, and projects you were in charge of helps him or her create a more accurate performance appraisal. Consider keeping notes of these on a regular basis to make it easier to provide the data when required. Create a list of questions you would like to discuss during your appraisal. This one-on-one time with your boss is an excellent opportunity to ask him or her about your role in the company, request any additional responsibilities you would like and clarify your priorities. But it is best to focus your attention around personal and professional improvements, rather than financial considerations, such as an increase in salary. During the appraisal Present a positive attitude as soon as you enter the appraisal room. This approach may lead to a more constructive discussion of review items. Avoid taking any negative assessments that are offered as a personal attack, but rather try to take them on board calmly, because if you put the failings right you will improve your performance. A realistic assessment of your strengths and weaknesses can be one of the most beneficial ways of helping you advance in the company. After the appraisal Create a list of personal goals based on your performance appraisal. Make the items detailed and measurable if possible. Send this list to your boss so he or she knows you took the appraisal seriously. Use this list to help achieve higher scores on your next performance appraisal. Six months after the appraisal, ask for a mid-term review with your boss to discuss your progress. This session should be more relaxed and informal than the official review. Ask for more feedback to help you improve. Checking in with your boss helps him or her remember your dedication as far as your job is concerned, and may help remove any criticisms before they become a review point on your next formal appraisal.", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... to get opinions on the conference Read the text below and answer Questions 21-27 How to deal with the annual performance appraisal The annual performance appraisal can help improve your productivity and provide a foundation for your work priorities. It is, however, critical to have the right attitude and approach. Knowing what areas your superiors see as your weaknesses is the most direct way of increasing the likelihood of being considered for promotion, if that is what you are looking for. Preparation Send your boss a summary of your achievements. Reminding your boss of activities, special assignments you did, and projects you were in charge of helps him or her create a more accurate performance appraisal. Consider keeping notes of these on a regular basis to make it easier to provide the data when required. Create a list of questions you would like to discuss during your appraisal. This one-on-one time with your boss is an excellent opportunity to ask him or her about your role in the company, request any additional responsibilities you would like and clarify your priorities. But it is best to focus your attention around personal and professional improvements, rather than financial considerations, such as an increase in salary. During the appraisal Present a positive attitude as soon as you enter the appraisal room. This approach may lead to a more constructive discussion of review items. Avoid taking any negative assessments that are offered as a personal attack, but rather try to take them on board calmly, because if you put the failings right you will improve your performance. A realistic assessment of your strengths and weaknesses can be one of the most beneficial ways of helping you advance in the company. After the appraisal Create a list of personal goals based on your performance appraisal. Make the items detailed and measurable if possible. Send this list to your boss so he or she knows you took the appraisal seriously. Use this list to help achieve higher scores on your next performance appraisal. Six months after the appraisal, ask for a mid-term review with your boss to discuss your progress. This session should be more relaxed and informal than the official review. Ask for more feedback to help you improve. Checking in with your boss helps him or her remember your dedication as far as your job is concerned, and may help remove any criticisms before they become a review point on your next formal appraisal.", "correct_answer": "questionnaires"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p2Id,
            'question_number' => 21,
            'question_text' => 'Questions 21-27',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 20, "sub_questions": [{"id": "21", "label": "By learning at an appraisal what areas of work need improving, staff can improve their chances of getting \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... .", "text": "By learning at an appraisal what areas of work need improving, staff can improve their chances of getting \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... .", "correct_answer": "promotion"}, {"id": "22", "label": "It is important to think of some \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... that can be used during the appraisal.", "text": "It is important to think of some \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... that can be used during the appraisal.", "correct_answer": "questions"}, {"id": "23", "label": "The appraisal can be a good time to ask the boss for extra \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... .", "text": "The appraisal can be a good time to ask the boss for extra \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... .", "correct_answer": "responsibilities"}, {"id": "24", "label": "React \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... to any criticism.", "text": "React \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... to any criticism.", "correct_answer": "calmly"}, {"id": "25", "label": "It is helpful to identify a number of individual \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... arising from the appraisal comments.", "text": "It is helpful to identify a number of individual \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... arising from the appraisal comments.", "correct_answer": "goals"}, {"id": "26", "label": "Staff can request a meeting half-way through the year to look at the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... which has been achieved.", "text": "Staff can request a meeting half-way through the year to look at the \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... which has been achieved.", "correct_answer": "progress"}, {"id": "27", "label": "If staff act on any appraisal comments, they will demonstrate their \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... to their work. Advertisements", "text": "If staff act on any appraisal comments, they will demonstrate their \\u2026\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026... to their work. Advertisements", "correct_answer": "dedication"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Passage 3: Section 3
        $p3Id = DB::table('ielts_reading_passages')->insertGetId([
            'material_id' => $matId,
            'title' => 'Section 3',
            'content' => '',
            'order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 28,
            'question_text' => 'Questions 28-33',
            'type' => 'matching_headings',
            'options' => '{"A": "very unusual feature of these birds"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 27, "sub_questions": [{"id": "28", "label": "Section A", "text": "Section A", "correct_answer": "vii"}, {"id": "29", "label": "Section B", "text": "Section B", "correct_answer": "iv"}, {"id": "30", "label": "Section C", "text": "Section C", "correct_answer": "ii"}, {"id": "31", "label": "Section D", "text": "Section D", "correct_answer": "vi"}, {"id": "32", "label": "Section E", "text": "Section E", "correct_answer": "iii"}, {"id": "33", "label": "Section F", "text": "Section F", "correct_answer": "viii"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 34,
            'question_text' => 'Questions 34 – 37',
            'type' => 'multiple_choice',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 33, "sub_questions": [{"id": "34", "label": "\\u201437", "text": "\\u201437", "correct_answer": "B"}, {"id": "35", "label": "What do we learn about the drop in the sandpiper population? A The birds are increasingly being hunted on their way north to Russia. B Scientists are managing to reduce deaths from netting considerably. C Efforts are being made to protect some of their coastal habitat sites. D Economic growth is one of the underlying causes of the decline.", "text": "What do we learn about the drop in the sandpiper population? A The birds are increasingly being hunted on their way north to Russia. B Scientists are managing to reduce deaths from netting considerably. C Efforts are being made to protect some of their coastal habitat sites. D Economic growth is one of the underlying causes of the decline.", "correct_answer": "D"}, {"id": "36", "label": "Which feeling did the writer express when the sandpiper chicks hatched? A relief that his long wait was over B surprise at the sound of their song C worry about birds of the same species D amazement that they could walk so soon", "text": "Which feeling did the writer express when the sandpiper chicks hatched? A relief that his long wait was over B surprise at the sound of their song C worry about birds of the same species D amazement that they could walk so soon", "correct_answer": "C"}, {"id": "37", "label": "The writer describes the sandpipers\\u2019 unit at WWT Slimbridge to emphasise A how much care is being devoted to their welfare. B how much money is being spent on the project. C his surprise at how fragile the young birds are. D his confidence in the technology available.", "text": "The writer describes the sandpipers\\u2019 unit at WWT Slimbridge to emphasise A how much care is being devoted to their welfare. B how much money is being spent on the project. C his surprise at how fragile the young birds are. D his confidence in the technology available.", "correct_answer": "A"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ielts_reading_questions')->insert([
            'passage_id' => $p3Id,
            'question_number' => 38,
            'question_text' => 'Questions 38-40',
            'type' => 'summary_completion',
            'options' => '{"A": "Option A", "B": "Option B", "C": "Option C", "D": "Option D"}',
            'correct_answer' => null,
            'explanation' => null,
            'data' => '{"start_number": 37, "sub_questions": [{"id": "38", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . Although the weather there is often very harsh, to begin with, there are obvious advantages to the sandpipers. There is above all a plentiful supply of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. . Although the weather there is often very harsh, to begin with, there are obvious advantages to the sandpipers. There is above all a plentiful supply of", "correct_answer": "tundra"}, {"id": "39", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. , and this makes it possible for the sandpiper chicks to develop well. The lack of", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. , and this makes it possible for the sandpiper chicks to develop well. The lack of", "correct_answer": "insects"}, {"id": "40", "label": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. is another definite advantage. As a result, a good proportion of the chicks grow up to face the long flight to the South-East Asian coasts. IELTS General Reading Test 18 IELTS General", "text": "\\u2026\\u2026\\u2026\\u2026\\u2026\\u2026. is another definite advantage. As a result, a good proportion of the chicks grow up to face the long flight to the South-East Asian coasts. IELTS General Reading Test 18 IELTS General", "correct_answer": "predators"}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "Done seeding IELTS General Reading Practice Tests 1-19!\n";
    }
}
