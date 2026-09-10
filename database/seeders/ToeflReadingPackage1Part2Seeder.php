<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;
use App\Models\ToeflReadingMeeting;

class ToeflReadingPackage1Part2Seeder extends Seeder
{
    public function run(): void
    {
        $meeting = ToeflReadingMeeting::where('title', 'Mockup Package 1 Reading')->first();
        if (!$meeting) {
            $this->command->error('Meeting not found. Run ToeflReadingPackage1Seeder first.');
            return;
        }

        // ==============================
        // FIX Q17-19 for Passage 2
        // ==============================
        $passage2 = ToeflReadingPassage::where('package_number', 1)->where('passage_number', 2)->first();
        if ($passage2) {
            // Delete old Q17, Q18, Q19
            ToeflReadingQuestion::where('passage_id', $passage2->id)
                ->whereIn('question_number', [17, 18, 19])
                ->delete();

            $fixedQ = [
                [
                    'question_number' => 17,
                    'question_text'   => 'The word "grievances" in line 17 is closest in meaning to',
                    'option_a'        => 'stories',
                    'option_b'        => 'opinions',
                    'option_c'        => 'findings',
                    'option_d'        => 'complaints',
                    'correct_answer'  => 'D',
                ],
                [
                    'question_number' => 18,
                    'question_text'   => 'According to the passage, what did George Pullman do to promote tourism in the town of Pullman?',
                    'option_a'        => 'He personally showed tourists around the town.',
                    'option_b'        => 'He published a travel guide to the town.',
                    'option_c'        => 'He started to invest in the town\'s cultural development.',
                    'option_d'        => 'He built a new road connecting it to the World\'s Columbian Exposition.',
                    'correct_answer'  => 'A',
                ],
                [
                    'question_number' => 19,
                    'question_text'   => 'The passage suggests that George Pullman worked to hide which of the following from tourists?',
                    'option_a'        => 'His role as an investor in the World\'s Columbian Exposition',
                    'option_b'        => 'His conflicts with the inhabitants of the town of Pullman',
                    'option_c'        => 'His efforts to promote the town of Pullman',
                    'option_d'        => 'His lack of knowledge about how the inhabitants of Pullman really lived',
                    'correct_answer'  => 'B',
                ],
            ];

            foreach ($fixedQ as $q) {
                ToeflReadingQuestion::create(array_merge(['passage_id' => $passage2->id], $q));
            }
            echo "✅ Fixed Q17-19 for Passage 2 (Pullman) ";
        }

        // ==============================
        // PASSAGE 3: Chesapeake Bay Oysters
        // Questions 20-29
        // ==============================
        // Remove if exists
        $existing3 = ToeflReadingPassage::where('package_number', 1)->where('passage_number', 3)->first();
        if ($existing3) {
            ToeflReadingQuestion::where('passage_id', $existing3->id)->delete();
            $existing3->delete();
        }

        $passage3 = ToeflReadingPassage::create([
            'meeting_id'     => $meeting->id,
            'package_number' => 1,
            'passage_number' => 3,
            'content'        => "In the 1820s, the exhaustion of commercial oyster beds along the northeastern coast set the stage for the industry that would shift the Chesapeake Bay region located in the southern state of Maryland forever from an underdeveloped subsistence economy, and define its culture for the next 150 years. In the early nineteenth century, the Chesapeake oyster beds, perhaps the world's richest trove of the shellfish, were discovered. Following the Civil War in 1865, the exploitation built to the fever pitch of a gold rush. More than 1,000 sail craft, including four-masted schooners, sloops, pungeys, and bugeyes, dragged heavy iron dredges ceaselessly across the \"rocks,\" as the reeflike agglomerations of the shellfish were called, catching oysters by the hundreds of bushels a day.  At the height of this activity, the Chesapeake region probably was less isolated than at any time in its history, including present times. In 1886, the oyster harvest peaked in Maryland at some 15 million bushels, an annual production of edible meat equal to the yield from 160,000 head of cattle. The oyster fleet employed a fifth of everyone involved in fishing in the United States. Oyster captains ruled the waves, outgunning attempts to enforce even modest conservation by the Maryland Oyster Navy, charged with policing the oyster beds. On the positive side, the oyster industry of this era used its political clout to force the nearby city of Baltimore to construct the nation's most modern sewage treatment plant to protect the water quality of the bay. So intense was the oystering that it eventually altered the physical shape of the bay's bottom, breaking apart the reefs in which oysters naturally grew. Studies comparing old charts of the bay bottom to new bathymetric surveys have found a dramatic flattening of original bottom contours. This made oysters more susceptible to silting over, and perhaps more vulnerable to the diseases that now plague them—though this latter is still speculative.  As harvests slid from the unsustainable peaks of the 1880s never to return, people involved in harvesting oysters sought an easy-to-build, cheaper alternative to the big sail dredge craft which would require fewer crew. What evolved was a beamy vessel, usually 38 to 55 feet long, the bottom made with simple crosswise planking. It could be built by a good backyard carpenter, and hundreds were.",
        ]);

        $questions3 = [
            [
                'question_number' => 20,
                'question_text'   => 'What does the passage mainly discuss?',
                'option_a'        => 'The oyster industry in the Chesapeake Bay region',
                'option_b'        => 'The subsistence economy of the Chesapeake Bay region',
                'option_c'        => 'The exhaustion of commercial oyster beds along the northeastern coast',
                'option_d'        => 'Sail craft used in the fishing industry of the nineteenth century',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 21,
                'question_text'   => 'The word "its" in line 4 refers to',
                'option_a'        => 'the northeastern coast',
                'option_b'        => 'Maryland',
                'option_c'        => 'subsistence economy',
                'option_d'        => 'the Chesapeake Bay region',
                'correct_answer'  => 'D',
            ],
            [
                'question_number' => 22,
                'question_text'   => 'The author mentions "a gold rush" in line 7 in order to',
                'option_a'        => 'illustrate that oysters were very expensive',
                'option_b'        => 'imply that oystering had a greater impact on Maryland\'s economy than mining gold',
                'option_c'        => 'explain that the new oyster beds were discovered while deposits of gold were being studied',
                'option_d'        => 'compare the exploiting of the new oyster beds with the excitement of discovering gold',
                'correct_answer'  => 'D',
            ],
            [
                'question_number' => 23,
                'question_text'   => 'According to the passage, what year was the Chesapeake Bay oyster harvest the largest?',
                'option_a'        => '1820',
                'option_b'        => '1865',
                'option_c'        => '1880',
                'option_d'        => '1886',
                'correct_answer'  => 'D',
            ],
            [
                'question_number' => 24,
                'question_text'   => 'The word "clout" in line 18 is closest in meaning to',
                'option_a'        => 'belief',
                'option_b'        => 'influence',
                'option_c'        => 'information',
                'option_d'        => 'division',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 25,
                'question_text'   => 'According to the second paragraph, which of the following was a beneficial effect of the oyster industry?',
                'option_a'        => 'Oyster fleets increased pay for fishers by one-fifth.',
                'option_b'        => 'Baltimore constructed a modern sewage treatment plant to keep the Chesapeake Bay clean.',
                'option_c'        => 'Conservation measures were enforced to protect the reefs where oysters grew.',
                'option_d'        => 'The people of Maryland gained access to a more nutritious diet including a large quantity of oyster meat.',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 26,
                'question_text'   => 'According to the second paragraph, which of the following has been revealed by bathymetric surveys of the Chesapeake Bay?',
                'option_a'        => 'The bottom of the bay has been radically altered by oyster harvesting.',
                'option_b'        => 'Oysters are still available, but current equipment is unable to harvest them.',
                'option_c'        => 'Oysters have adapted well to significant changes in their environment.',
                'option_d'        => 'New reefs have formed for oysters to grow in.',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 27,
                'question_text'   => 'The word "speculative" in line 24 is closest in meaning to',
                'option_a'        => 'radical',
                'option_b'        => 'popular',
                'option_c'        => 'theoretical',
                'option_d'        => 'temporary',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 28,
                'question_text'   => 'It can be inferred from the author\'s description of the beamy vessel in the third paragraph that this boat was',
                'option_a'        => 'made from planking recovered from old oyster boats',
                'option_b'        => 'relatively simple in design',
                'option_c'        => 'rarely used on Chesapeake Bay',
                'option_d'        => 'able to handle heavy dredges better than earlier boats had',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 29,
                'question_text'   => 'It can be inferred from the passage that the Chesapeake Bay oyster beds were similar to the oyster beds along the northeastern coast in that they',
                'option_a'        => 'were discovered following the Civil War',
                'option_b'        => 'were fished primarily by large sail craft that were operated by the state government',
                'option_c'        => 'eventually became less productive than they had been in the past',
                'option_d'        => 'gradually expanded in spite of diseases carried by polluted waters',
                'correct_answer'  => 'C',
            ],
        ];

        foreach ($questions3 as $q) {
            ToeflReadingQuestion::create(array_merge(['passage_id' => $passage3->id], $q));
        }
        echo "✅ Added Passage 3 (Chesapeake Bay Oysters): 10 questions (Q20-29) ";

        // ==============================
        // PASSAGE 4: Insect Wings
        // Questions 30-40
        // ==============================
        // Remove if exists
        $existing4 = ToeflReadingPassage::where('package_number', 1)->where('passage_number', 4)->first();
        if ($existing4) {
            ToeflReadingQuestion::where('passage_id', $existing4->id)->delete();
            $existing4->delete();
        }

        $passage4 = ToeflReadingPassage::create([
            'meeting_id'     => $meeting->id,
            'package_number' => 1,
            'passage_number' => 4,
            'content'        => "Except for flies, all flying insects have two pairs of wings, one of which is attached to the upper mesothorax and the other to the upper metathorax. It is likely that their wings originated as flaps that could be extended from the thorax, allowing wingless insects to escape danger by leaping from an elevated perch and gliding some distance away. Insect wings are unique, having evolved specifically for flight, while the wings of birds and bats are merely modifications of preexisting limbs.  The earliest insects known to be capable of true flight had two pairs of wings that remained extended and did not fold, even when the creature was at rest. Each pair flapped independently of the other pair, a contemporary parallel to this feature being found in the wings of dragonflies, which are members of a primitive but common order of insects. Many advanced insects, such as beetles, butterflies, and wasps, have evolved means to link their forewings and hind wings to form two coordinated flight surfaces rather than four.  Most insect wings are laced with veins. These are distinct ridges, the pattern of which is often critical to the identification of individual species. The spaces between the veins are called cells; those extending to the wing margin are open cells, and those enclosed by veins on all sides are closed cells. Adult insects that emerge from a pupa have wings that at first look crumpled and useless. Extensions of the tracheal respiratory system run through the veins, and blood circulates in the spaces around the tracheae. As air is pumped through the veins, the wings of these newly emerged insects unfurl and straighten. As the veins harden, they provide both strength and a degree of flexibility, and the wings become capable of sustaining flight.  The veins of the wings tend to be thicker and stronger near the body and along the forward, or leading, edge and thinner and more flexible near the tip and along the trailing edge. The trailing edge curls on both the upstroke and the downstroke, pushing against the air behind it and producing not only lift but forward propulsion and reduced drag.",
        ]);

        // Placeholder questions for Passage 4 (Q30-40) - to be updated with actual questions
        $questions4Placeholder = [
            [
                'question_number' => 30,
                'question_text'   => 'What does the passage mainly discuss?',
                'option_a'        => 'How insect wings work',
                'option_b'        => 'The differences between insects and birds',
                'option_c'        => 'How insects evolved from wingless creatures',
                'option_d'        => 'The various types of flying insects',
                'correct_answer'  => 'A',
            ],
        ];

        // Note: Q31-40 will be inserted once the user provides the remaining question images
        foreach ($questions4Placeholder as $q) {
            ToeflReadingQuestion::create(array_merge(['passage_id' => $passage4->id], $q));
        }

        echo "✅ Added Passage 4 (Insect Wings): placeholder Q30 — awaiting Q31-40 ";
        echo " Summary: ";
        echo "Package 1 now has " . ToeflReadingPassage::where('package_number', 1)->count() . " passages ";
    }
}
