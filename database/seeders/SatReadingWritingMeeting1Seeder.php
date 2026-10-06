<?php

namespace Database\Seeders;

use App\Models\SatReadingWritingMeeting;
use App\Models\SatReadingWritingQuestion;
use Illuminate\Database\Seeder;

class SatReadingWritingMeeting1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Practice Test: Diagnostic Drills - Reading & Writing
        $meeting1 = SatReadingWritingMeeting::updateOrCreate(
            ['meeting_number' => 1],
            [
                'title' => 'Diagnostic Drills',
                'subtitle' => 'Reading & Writing Diagnostic Assessment',
                'description' => 'Evaluasi awal untuk mendiagnosis kemampuan Reading & Writing Anda pada Digital SAT, mencakup Vocabulary, Purpose, Claims, Conventions of Standard English, Transitions, dan Rhetorical Synthesis.',
                'is_locked' => false,
            ]
        );

        // Delete existing questions to ensure clean update
        $meeting1->questions()->delete();

        $questionsMeeting1 = [
            [
                'question_number' => 1,
                'category' => 'Vocabulary',
                'passage' => 'Texas-based artist Dawolu Jabari Anderson can partially ______ his interest in the medium to his upbringing; her mother worked as an administrative assistant at Kodak, a well-known film and camera company, and her father was an employee of Xerox, a company known for its photocopier machines.',
                'question_prompt' => 'Which choice completes the text with the most logical and precise word or phrase?',
                'option_a' => 'attribute',
                'option_b' => 'adhere',
                'option_c' => 'postulate',
                'option_d' => 'inherit',
                'correct_answer' => 'A',
                'explanation' => 'This is a Vocabulary question, as it asks for the most logical and precise word or phrase. Read the text and highlight what can help to fill in the blank, which describes the relationship between Anderson’s interest and her upbringing. The first part of the sentence mentions that Anderson is a Texas-based artist, and the part after the colon mentions that both of her parents worked around film and photos. This suggests that there is a connection between her photography interest and her upbringing, so write "connect" in the annotation box. (A) is correct because attribute means "give credit to," and she can partially credit her interest to her upbringing. (B) is wrong because adhere means "stick." (C) is wrong because the sentence doesn’t indicate that Anderson is postulating her interest. (D) is wrong because while her interest might be inherited, the sentence would be that she can "inherit" the interest, in her upbringing, which doesn’t provide a clear meaning.',
            ],
            [
                'question_number' => 2,
                'category' => 'Purpose',
                'passage' => 'Oral tradition is a type of communication method used by a variety of cultures to pass information, art, thoughts, and wisdom between generations. The information can be shared through poetry, folktales, songs, and more and allows cultures to convey these traditions without, or along with, an established writing system. However, the transmission of ideas this way can present certain obstacles: it is difficult to verify whether the knowledge being transferred is correct and similar to the original version. As a result of this, many cultures use devices such as repetition, assonance, alliteration, and rhythmic timing. Through the use of devices like these, it is easier to retain the knowledge in order to correctly pass it on the next generation.',
                'question_prompt' => 'Which choice best states the main purpose of the text?',
                'option_a' => 'To propose a solution to the obstacles faced by oral tradition',
                'option_b' => 'To clarify that oral tradition can only be used in certain cultures',
                'option_c' => 'To explain how cultures make it easier to memorize knowledge from oral tradition',
                'option_d' => 'To assert that oral tradition is more beneficial than a writing system is',
                'correct_answer' => 'C',
                'explanation' => 'This is a Purpose question, as it asks for the main purpose. Read the text and highlight what can help to understand the overall purpose. The text introduces oral tradition and then mentions obstacles with oral tradition. Then the author states what many cultures use as a result of the obstacle in order to facilitate recall of the knowledge, so write "repetition, etc about problems will allow solution" in the annotation box. (A) is wrong because the author isn’t proposing a solution; the author is explaining what cultures already do. (B) is wrong because the author doesn’t state that it can only be used by certain cultures. (C) is correct because the author describes a solution that makes it easier to recall the knowledge through oral tradition. (D) is wrong because the author mentions that oral tradition can be used without, or along with, an established writing system and never says one is more beneficial.',
            ],
            [
                'question_number' => 3,
                'category' => 'Factual Information',
                'passage' => 'The following text is from Elizabeth von Arnim\'s 1922 novel The Enchanted April. Four women from England have rented an Italian castle for a month\'s vacation. The cook, who had been working in increasing agitation in the kitchen, watching the clock getting nearer to lunch-time while she still was without knowledge of what lunch was to consist of, had gone in search of Mrs. Fisher, who had immediately waved her away; she then wandered about the house seeking a mistress, any mistress, who would realize what 12:30 is, and findung none, and at last, directed by Francesca, who always knew where everybody was, went out to Lady Caroline.',
                'question_prompt' => 'According to the text, why does the cook go to see Lady Caroline?',
                'option_a' => 'The cook wants to express her agitation regarding the condition of the kitchen.',
                'option_b' => 'The cook wants to determine what she should prepare for lunch.',
                'option_c' => 'The cook needs approval for her planned menu.',
                'option_d' => 'The cook has been sent by Francesca to deliver a message to Lady Caroline.',
                'correct_answer' => 'B',
                'explanation' => 'This is a Retrieval question, as it says According to the text. Read the text and look to highlight the reason given for why the cook goes to see Lady Caroline. The first sentence states that the cook was agitated and was without knowledge of what lunch was to consist of. The second sentence indicates that she was seeking a mistress...who would tell her what to cook and that she was then sent to see Lady Caroline. (A) is wrong because the cook’s agitation isn’t about the condition of the kitchen, which isn’t mentioned. (B) is correct because this is the reason stated in the text. (C) is wrong because the cook hasn’t planned a menu; she wants to know what to cook. (D) is wrong because no message from Francesca is mentioned.',
            ],
            [
                'question_number' => 4,
                'category' => 'Claims & Evidence',
                'passage' => 'Carbon dioxide emissions are known to have harmful environmental effects. Because the cement industry is one of the biggest producers of carbon dioxide emissions, developing more sustainable processes for manufacturing cement is of major concern. Researchers at Columbia University have developed a method that uses seawater to make cement by converting magnesium ions, which are highly abundant in the oceans, into magnesium-based cement that can then be turned into magnesium-based cement. According to the researchers, not only does the resulting cement not produce carbon dioxide, but it can actually improve the environment.',
                'question_prompt' => 'Which finding, if true, would most directly support the researchers\' claim?',
                'option_a' => 'The magnesium-based cement is more energy-intensive than traditionally made cement.',
                'option_b' => 'Cement is traditionally produced from suction rather than evaporation.',
                'option_c' => 'The magnesium-based cement consumes carbon dioxide.',
                'option_d' => 'Cement made from seawater is less costly to produce than cement made from other methods.',
                'correct_answer' => 'C',
                'explanation' => 'This is a Claims question, as it asks to support the researchers\' claim. Read the text and highlight the claim, which is that the magnesium-based cement can actually improve the environment. Eliminate answers that don\'t support this idea. (A) is wrong because this would be a downside, rather than a benefit of the cement. (B) and (D) are wrong because they don\'t relate to the environment. (C) is correct because the text states that Carbon dioxide emissions are known to have harmful environmental effects, so if the cement removes carbon dioxide, then it would reduce carbon dioxide and therefore improve the environment.',
            ],
            [
                'question_number' => 5,
                'category' => 'Data / Chart Analysis',
                'passage' => 'Researchers conducted a survey on young adults in the United States regarding their recycling habits. The survey examined the percentage of respondents who reported recycling specific types of materials regularly. The data revealed that while awareness of recycling benefits was high, participation varied widely across different product types and communities.',
                'question_prompt' => 'Which choice best describes the data from the study in relation to the researchers\' findings?',
                'option_a' => 'Respondents were uniformly consistent across all categories of recyclable goods.',
                'option_b' => 'A significant percentage of young adults recognized the benefits of recycling yet exhibited selective participation in actual recycling practices.',
                'option_c' => 'Young adults in urban areas recycled fewer items than those in rural communities.',
                'option_d' => 'Participation in recycling was solely determined by the availability of municipal bins.',
                'correct_answer' => 'B',
                'explanation' => 'This is a Charts/Data question. Look for the choice that aligns accurately with the passage and survey results highlighting that high awareness is accompanied by selective practical involvement.',
            ],
            [
                'question_number' => 6,
                'category' => 'Conclusion',
                'passage' => 'The hippocampus is one of the first areas of the brain to display damage from Alzheimer\'s disease, and therefore common symptoms of early-stage Alzheimer\'s disease, such as difficulties with short-term memory and learning new information, are believed to stem directly from this initial neurological deterioration.',
                'question_prompt' => 'Which choice most logically completes the text?',
                'option_a' => 'damage to the hippocampus plays a critical role in the emergence of these cognitive impairments.',
                'option_b' => 'Alzheimer\'s disease is most accurately diagnosed through cognitive tests alone.',
                'option_c' => 'other areas of the brain rarely undergo degeneration in Alzheimer\'s patients.',
                'option_d' => 'treatment of hippocampal tissue can reverse all symptoms of Alzheimer\'s disease.',
                'correct_answer' => 'A',
                'explanation' => 'This is a Conclusion question. The text notes that the hippocampus is the first area to display damage, and therefore early symptoms are related to damage to the hippocampus. (A) logically concludes the text based on the presented evidence.',
            ],
            [
                'question_number' => 7,
                'category' => 'Boundaries & Punctuation',
                'passage' => 'The part of the sentence describes two independent clauses that need proper connection: Medical recording systems track a variety of problems in a dose of deep monitoring, ______ they also alert physicians to subtle changes in vital signs.',
                'question_prompt' => 'Which choice completes the text so that it conforms to the conventions of Standard English?',
                'option_a' => 'and',
                'option_b' => ', and',
                'option_c' => '; and',
                'option_d' => ', which',
                'correct_answer' => 'B',
                'explanation' => 'In this Rules question, punctuation is changing in the answer choices. Look for independent clauses. Connecting two independent clauses requires a comma plus a coordinating conjunction (FANBOYS: and), or a semicolon alone. Hence, ", and" correctly joins the two clauses.',
            ],
            [
                'question_number' => 8,
                'category' => 'Form, Structure, and Sense',
                'passage' => 'Researchers at the Environmental Protection Agency all claim to study the effects of highway traffic on local bird populations, so they constructed a fake road with 14 pairs of speakers playing the sounds of traffic noise. According to the study, the mere sounds of traffic ______ avian populations by a third and cut species diversity by a significant amount.',
                'question_prompt' => 'Which choice completes the text so that it conforms to the conventions of Standard English?',
                'option_a' => 'reduced',
                'option_b' => 'reducing',
                'option_c' => 'having reduced',
                'option_d' => 'to reduce',
                'correct_answer' => 'A',
                'explanation' => 'In this Rules question, verb forms are changing. The sentence needs a finite main verb for the clause following "traffic". "reduced" is the simple past tense finite verb that functions as the predicate and parallels "cut".',
            ],
            [
                'question_number' => 9,
                'category' => 'Form, Structure, and Sense',
                'passage' => 'Civil engineering as a profession is centuries old and has long been necessary for the functioning of modern government, as it includes designing and building roads and bridges. As long as people need to get to school or work, civil engineers ______ to the cornerstone of modern societies.',
                'question_prompt' => 'Which choice completes the text so that it conforms to the conventions of Standard English?',
                'option_a' => 'will continue',
                'option_b' => 'continued',
                'option_c' => 'have continued',
                'option_d' => 'are continuing',
                'correct_answer' => 'A',
                'explanation' => 'The dependent clause begins with "As long as people need...", indicating an ongoing condition extending into the future. Thus, the future tense "will continue" logically matches the context.',
            ],
            [
                'question_number' => 10,
                'category' => 'Dangling Modifiers',
                'passage' => 'The Nobel Prizes in scientific fields, such as Physics, Chemistry, Literature, and Medicine, are typically awarded with little controversy. The Nobel Peace Prize, on the other hand, tends to generate more debate. When given to first-year President Barack Obama in 2009, ______ because some believed that the choice was too politically motivated.',
                'question_prompt' => 'Which choice completes the text so that it conforms to the conventions of Standard English?',
                'option_a' => 'there was a great deal of controversy surrounding the award',
                'option_b' => 'the award\'s controversy received significant attention',
                'option_c' => 'the award caused a great deal of controversy',
                'option_d' => 'a controversy surrounded the award',
                'correct_answer' => 'C',
                'explanation' => 'In this modifier question, look at the introductory modifying phrase: "When given to first-year President Barack Obama in 2009...". Whatever was given to Obama must immediately follow the comma. Obama was given "the award", not "there" or "a controversy". Choice (C) correctly places "the award" right after the comma.',
            ],
            [
                'question_number' => 11,
                'category' => 'Transitions',
                'passage' => 'Although all states hold elections, there are many major differences in how they do so. ______ some states hold primaries, while others use caucuses. Both meant to accomplish the goal of nominating candidates for office.',
                'question_prompt' => 'Which choice completes the text with the most logical transition?',
                'option_a' => 'In addition,',
                'option_b' => 'In other words,',
                'option_c' => 'Consequently,',
                'option_d' => 'For example,',
                'correct_answer' => 'D',
                'explanation' => 'The preceding sentence states that there are many differences in how states hold elections. The subsequent sentence provides a specific illustration of these differences (primaries vs caucuses). Therefore, "For example," is the appropriate illustration transition.',
            ],
            [
                'question_number' => 12,
                'category' => 'Rhetorical Synthesis',
                'passage' => "While researching a topic, a student has taken the following notes:\n- A polar vortex can have a significant effect on other areas of the globe when it breaks into two or more sections.\n- A break occurs when a shift in the jet stream causes a piece of the vortex to be broken off from the main system and pushed along the path of the jet stream.\n- In 1985, the United States suffered one of its worst weather events due to a break in the Arctic polar vortex.\n- A wave of extreme cold swept through the United States, primarily in the East Coast and Midwest regions.\n- In all, 126 deaths were attributed to the arctic wave, over $1.2 billion in agricultural losses were reported, and hundreds of homes were lost to winter damage.",
                'question_prompt' => 'The student wants to explain the cause of a destructive weather event. Which choice most effectively uses relevant information from the notes to accomplish this goal?',
                'option_a' => 'When a polar vortex breaks into several small sections, it can cause a wave of extreme cold.',
                'option_b' => 'A weather event in 1985 caused 126 deaths, over $1.2 billion in agricultural losses, and hundreds of home losses, primarily in the East Coast and Midwest regions.',
                'option_c' => 'In 1985, a piece of the Arctic polar vortex broke off from the main system, causing a wave of extreme cold that led to deaths, agricultural losses, and wind damage to homes.',
                'option_d' => 'A polar vortex can have a significant effect on other areas of the globe, like the Arctic polar vortex in 1985 for the East Coast and Midwest regions.',
                'correct_answer' => 'C',
                'explanation' => 'The question asks the student to explain the *cause* of a destructive weather event. Choice (C) specifically explains the event (1985 freeze), its cause (a piece of the Arctic polar vortex broke off from the main system), and its destructive effects.',
            ],
        ];

        foreach ($questionsMeeting1 as $q) {
            SatReadingWritingQuestion::create(array_merge($q, ['meeting_id' => $meeting1->id]));
        }

        // We also create placeholders for Practice Tests
        SatReadingWritingMeeting::updateOrCreate(
            ['meeting_number' => 2],
            [
                'title' => 'Practice Test 1 — Module 1',
                'subtitle' => 'Reading & Writing Module 1 (Standard Difficulty)',
                'description' => '27 soal latihan lengkap Digital SAT Reading & Writing Module 1. Modul ini merupakan tahap awal yang menentukan tingkat kesulitan Modul 2 Anda.',
                'is_locked' => false,
            ]
        );

        SatReadingWritingMeeting::updateOrCreate(
            ['meeting_number' => 3],
            [
                'title' => 'Practice Test 1 — Module 2 (Easier)',
                'subtitle' => 'Reading & Writing Module 2 (Adaptive Route: Easier)',
                'description' => '27 soal latihan lengkap Digital SAT Reading & Writing Module 2 jalur Easier untuk melatih penguasaan konsep dasar dan strategi efisiensi waktu.',
                'is_locked' => false,
            ]
        );

        SatReadingWritingMeeting::updateOrCreate(
            ['meeting_number' => 4],
            [
                'title' => 'Practice Test 1 — Module 2 (Harder)',
                'subtitle' => 'Reading & Writing Module 2 (Adaptive Route: Harder)',
                'description' => '27 soal latihan tingkat lanjut Digital SAT Reading & Writing Module 2 jalur Harder untuk mencapai skor maksimal 700+.',
                'is_locked' => false,
            ]
        );
    }
}
