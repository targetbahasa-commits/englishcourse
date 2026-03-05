<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting6Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 6
        $meeting = ToeflReadingMeeting::where('meeting_number', 6)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 6,
                'title' => 'Inferences 1',
                'is_locked' => false
            ]);
        }

        // For inference questions without passages, we create a dummy passage
        $passage = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => 'This meeting contains inference questions without passages.'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 1,
            'question_text' => 'Cities founded around the turn of the eighteenth century, such as Williamsburg, Annapolis, and especially Philadelphia, were laid out on a regular grid with public squares, while cities laid out in the id-seventeenth century, such as Boston, remain chaotic to this day.',
            'option_a' => 'Philadelphia is today laid out more regularly than either Williamsburg or Annapolis.',
            'option_b' => 'Boston was not originally laid out according to a logical plan.',
            'option_c' => 'Philadelphia, Williamsburg, and Annapolis were founded before Boston.',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 2,
            'question_text' => 'When apple growers talk about new varieties of apples, they don\'t mean something developed last month, last year, or even in the last decade.',
            'option_a' => 'Apple growers haven\'t developed any new varieties in recent decades.',
            'option_b' => 'Some varieties of apples can be developed in a short time, but others take a long time.',
            'option_c' => 'New varieties of apples take many years to develop.',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 3,
            'question_text' => 'Blood cholesterol used to be thought of as a problem only for adults.',
            'option_a' => 'Blood cholesterol is no longer a problem for adults.',
            'option_b' => 'Only children have a problem with blood cholesterol.',
            'option_c' => 'Blood cholesterol affects both adults and children.',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 4,
            'question_text' => 'A metal-worker of 3,000 years ago would recognize virtually every step of the lost-wax process used to cast titanium for jet engines.',
            'option_a' => 'Titanium has been forged for thousands of years.',
            'option_b' => 'The lost-wax method of casting is very old.',
            'option_c' => 'Metal working has changed very little in 3,000 years.',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 5,
            'question_text' => 'There is more quartz in the world than anyone kind of feldspar, but the feldspars as a group are five times more common than quartz.',
            'option_a' => 'One type of quartz is five times more plentiful than feldspar.',
            'option_b' => 'Quartz is less common than the feldspars.',
            'option_c' => 'The most common type of feldspar is as plentiful as quartz',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 6,
            'question_text' => 'Compared with the rest of its brain, the visual area of a turtle\'s brain is comparatively small since turtles, like all other reptiles, depend on senses other than sight.',
            'option_a' => 'No reptile uses sight as its primary sense.',
            'option_b' => 'Animals that depend on sight all have larger visual areas in their brain than turtles do.',
            'option_c' => 'The visual areas of other reptile brains are comparatively smaller than those of turtles.',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 7,
            'question_text' => 'Contrary to popular belief, there is no validity to the stories one hears of initials carved in a tree by a young boy becoming elevated high above his head when he visits the tree as an old man.',
            'option_a' => 'Trees don\'t grow the way many people think they do.',
            'option_b' => 'If a child carves initials in a tree, it won\'t grow.',
            'option_c' => 'Over time, initials that are carved into a tree will be elevated.',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 8,
            'question_text' => 'Illegible handwriting does not indicate weakness of character, as even a quick glance at the penmanship of George Washington, Franklin D. Roosevelt, or John Kennedy reveals.',
            'option_a' => 'Washington, Roosevelt, and Kennedy all had handwriting that was difficult to read.',
            'option_b' => 'A person\'s handwriting reveals a lot about that person.',
            'option_c' => 'The author believes that Washington, Roosevelt, and Kennedy all had weak characters.',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 9,
            'question_text' => 'William Faulkner set many of his novels in and around an imaginary town, Jefferson, Mississippi, which he closely patterned after his hometown of Oxford, Mississippi.',
            'option_a' => 'William Faulkner wrote many of his novels while living in Jefferson, Mississippi.',
            'option_b' => 'The town of Oxford, Mississippi, exists only in Faulkner\'s novels.',
            'option_c' => 'Faulkner actually wrote about his hometown but did not use its real name.',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 10,
            'question_text' => 'Most fish take on, to a certain degree, the coloration of their natural surroundings, so it is not surprising that the fish inhabiting warm, shallow waters around tropical reefs are colored all the brilliant tints of the rainbow.',
            'option_a' => 'Tropical fish are unlike other fish because they take on the coloration of their environment.',
            'option_b' => 'Tropical fish are brightly colored because they inhabit warm waters.',
            'option_c' => 'Tropical reefs are brightly colored environments.',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 11,
            'question_text' => 'Although sheepherding is an older and more beloved occupation, shepherds never caught the attention of American filmmakers the way cowboys did.',
            'option_a' => 'There have been more American films about cowboys than about shepherds.',
            'option_b' => 'Films about shepherds were popular before films about cowboys.',
            'option_c' => 'Cowboys are generally younger than shepherds.',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 12,
            'question_text' => 'The Okefenokee Swamp is a fascinating realm that both confirms and contradicts popular notions of a swamp, because along with huge cypresses, dangerous quagmires, and dim waterways, the Okefenokee has sandy pine islands, sunlit prairies, and clear lakes.',
            'option_a' => 'People generally feel that swamps are fascinating places.',
            'option_b' => 'The Okefenokee has features that most people do not associate with swamps.',
            'option_c' => 'Most swamps do not have huge cypresses, dangerous quagmires, and dim waterways.',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 13,
            'question_text' => 'As an architect, Thomas Jefferson preferred the Roman style, as seen in the University of Virginia, to the English style favored by Charles Bullfinch.',
            'option_a' => 'The University of Virginia was influenced by the Roman style.',
            'option_b' => 'Bullfinch was an English architect.',
            'option_c' => 'Jefferson preferred to build in the English style of architecture.',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 14,
            'question_text' => 'In all cultures, gestures are used as a form of communication, but the same gestures may have very different meanings in different cultures.',
            'option_a' => 'No two cultures use the same gestures.',
            'option_b' => 'One gesture will never have the same meaning in two cultures.',
            'option_c' => 'A person from one culture may misunderstand the gestures used by a person from another culture.',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 15,
            'question_text' => 'Even spiders that do not build webs from silk use it for a variety of purposes, such as constructing egg sacs and nursery tents.',
            'option_a' => 'All spiders build webs.',
            'option_b' => 'Spiders that build webs don\'t build egg sacs or nursery tents.',
            'option_c' => 'Silk is used by all spiders.',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        $this->command->info('TOEFL Reading Meeting 6 seeded successfully!');
    }
}
