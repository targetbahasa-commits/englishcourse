<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflReadingMeeting1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Find Meeting 1
        $meeting = \App\Models\ToeflReadingMeeting::where('meeting_number', 1)->first();

        // Ensure Meeting 1 exists (it should from previous seeder)
        if (!$meeting) {
            $meeting = \App\Models\ToeflReadingMeeting::create([
                'meeting_number' => 1,
                'title' => 'Main Idea, Main Topic, and Main Purpose Questions',
                'is_locked' => false,
            ]);
        }

        // Clear existing content to prevent duplicates if re-run
        // Delete passages (cascades to questions)
        \App\Models\ToeflReadingPassage::where('meeting_id', $meeting->id)->delete();

        // Passage 1
        $p1 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "There are two main types of cell division. Most cells are produced by a process called mitosis. In mitosis, a cell divides and forms two identical daughter cells, each with an identical number of chromosomes. Most one-celled creatures reproduce by this method, as do most of the cells in multicelled plants and animals. Sex cells, however, are formed in a special type of cell division called meiosis. This process reduces the number of chromosomes in a sex cell to half the number found in other kinds of cells. Then, when sex cells unite, they produce a single cell with the original number of chromosomes."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 1,
            'question_text' => "What is the main topic of this passage?",
            'option_a' => "The method by which one-celled organisms reproduce",
            'option_b' => "A comparison between mitosis and meiosis",
            'option_c' => "Meiosis, the process by which identical cells are produced",
            'option_d' => null, // Only 3 options provided
            'correct_answer' => 'B' // Inferred
        ]);

        // Passage 2
        $p2 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "The last gold rush belongs as much to Canadian history as it does to American. The discovery of gold along the Klondike River, which flows from Canada's Yukon Territory into Alaska, drew some 30,000 fortune hunters to the north. The Yukon became a territory, and its capital of the time, Dawson, would not have existed without the gold rush. The gold strike furnished material for a dozen of Jack London's novels. It inspired Robert Service to write \"The Shooting of Dan McGrew\" and other poems, and it provided the background for the wonderful Charlie Chaplin movie, The Gold Rush. It also marked the beginnings of modern Alaska."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 2,
            'question_text' => "This author's main purpose in writing is to",
            'option_a' => "discuss the significance of mining in Canada and the United States",
            'option_b' => "show the influence of the Klondike gold strike on the creative arts",
            'option_c' => "point out the impact of the Klondike gold strike",
            'option_d' => null,
            'correct_answer' => 'C' // C is broadest, B is specific to arts
        ]);

        // Passage 3
        $p3 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "The keystone arch was used by almost every early civilization. To build a keystone arch, stones are cut so that the opposite sides taper toward each other slightly. The upper and lower surfaces are carved so that when several stones are placed side by side, the upper and lower surfaces meet in smooth, continuous curves. Some form of scaffolding is built under the arch and shaped to accept the curved underside of the stones. Then the stones are fitted in place one by one. The keystone is the top center stone, the last to be dropped into position. Afterwards, the scaffolding is removed and the arch is self-supporting."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 3,
            'question_text' => "The passage mainly concerns the",
            'option_a' => "basic principles of building keystone arches",
            'option_b' => "uses of arches in modern architecture",
            'option_c' => "role of scaffolding in building keystone arches",
            'option_d' => null,
            'correct_answer' => 'A'
        ]);

        // Passage 4
        $p4 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "Circumstantial evidence is evidence not drawn from the direct observation of a fact. If, for example, there is evidence that a piece of rock embedded in a wrapped chocolate bar is the same type of rock found in the vicinity of the candy factory, and that rock of this type is found in few other places, then there is circumstantial evidence that the stone found its way into the candy during manufacture and suggests that the candy-maker was negligent. Despite a popular notion to look down on the quality of circumstantial evidence, it is of great usefulness if there is enough of it and if it is properly interpreted. Each circumstance, taken singly, may mean little, but a whole chain of circumstances can be as conclusive as direct evidence."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p4->id,
            'question_number' => 4,
            'question_text' => "What is the author's main purpose in this passage?",
            'option_a' => "To show that a manufacturer's negligence can be shown by direct evidence only",
            'option_b' => "To define circumstantial evidence and show its usefulness",
            'option_c' => "To demonstrate that circumstantial evidence can be very useful in science",
            'option_d' => null,
            'correct_answer' => 'B'
        ]);

        // Passage 5
        $p5 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 5,
            'content' => "The Northwest Ordinance was passed by Congress in 1787. It set up the government structure of the region north of the Ohio River and west of Pennsylvania, then called the Northwest Territory. It set the conditions under which parts of the Territory could become states having equality with the older states. But the ordinance was more than just a plan for government. The law also guaranteed freedom of religion and trial by jury in the Territory. It organized the Territory into townships of 36 square miles and ordered a school to be built for each township. It also abolished slavery in the Territory. The terms were so attractive that thousands of pioneers poured into the Territory. Eventually, the Territory became the states of Ohio, Indiana, Illinois, Michigan, and Wisconsin."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p5->id,
            'question_number' => 5,
            'question_text' => "What is the main topic of this passage?",
            'option_a' => "The structure of government",
            'option_b' => "The provisions of an important law",
            'option_c' => "The establishment of schools in the NorthwestTerritory",
            'option_d' => null,
            'correct_answer' => 'B'
        ]);

        // Passage 6
        $p6 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 6,
            'content' => "The story of the motel business from 1920 to the start of World War II in 1941 is one of uninterrupted growth. Motels spread from the West and the Midwest all the way to Maine and Florida. They clustered along transcontinental highways such as U.S. routes 40 and 66 and along the north-south routes running up and down both the East and West coast. There were 16,000 motels by 1930 and 24,000 by 1940. The motel industry was one of the few industries that was not hurt by the Depression ofthe 1930's. Their cheap rates attracted travelers who had very little money."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p6->id,
            'question_number' => 6,
            'question_text' => "What does the passage mainly discuss?",
            'option_a' => "How the Depression hurt U.S. motels",
            'option_b' => "The impact of transcontinental highways",
            'option_c' => "Two decades of growth for the motel industry",
            'option_d' => null,
            'correct_answer' => 'C'
        ]);

        // Passage 7
        $p7 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 7,
            'content' => "An old proverb states, \"Beware of oak, it draws the stroke.\" This saying is handy during thunderstorm season. In general, trees with deep roots that tap into groundwater attract more lightning than do trees with shallow, drier roots. Oaks are around 50 times more likely to be struck than beeches. Spruces are nearly as safe as beeches. Pines are not as safe as these two, but are still much safer than oaks."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p7->id,
            'question_number' => 7,
            'question_text' => "What is the author's main point?",
            'option_a' => "Old proverbs often contain important truths.",
            'option_b' => "Trees with shallow roots are more likely to avoid lightning than those with deep roots.",
            'option_c' => "The deeper a tree's roots, the safer it is during a thunderstorm.",
            'option_d' => null,
            'correct_answer' => 'B'
        ]);

        // Passage 8
        $p8 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 8,
            'content' => "Alternative history is generally classified as a type of science fiction, but it also bears some relation to historical fiction. This type of writing describes an imaginary world that is identical to ours up to a certain point in history, but at that point, the two worlds diverge; some important historical event takes place in one world but not in the other, and they go in different directions. Alternative histories might describe worlds in which the Roman Empire had never fallen, in which the Spanish Armada had been victorious, or in which the South had won the Civil War. Or they may suppose that some technology had been introduced earlier in the world's history than actually happened. For example: What if computers had been invented in Victorian times? Many readers find these stories interesting because of the way they stimulate the imagination and get them thinking about the phenomenon of cause and effect in history."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p8->id,
            'question_number' => 8,
            'question_text' => "What is the main idea of this passage?",
            'option_a' => "Alternative histories describe worlds in which history has taken another course.",
            'option_b' => "Alternative histories are a type of historical novel.",
            'option_c' => "Science fiction writers have accurately predicted certain actual scientific developments.",
            'option_d' => null,
            'correct_answer' => 'A'
        ]);

        // Passage 9
        $p9 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 9,
            'content' => "Until the late 1700's, metal could not be turned on a lathe to make it uniformly smooth and round. The operator could not guide the cutting tool evenly by hand against the turning piece. This problem was solved by David Wilkinson of Pawtucket, Rhode Island. In 1798 he invented a machine in which the cutter was clamped into a movable slide that could be advanced precisely, by hand crank, parallel to the work. The slide rest, as it came to be called, has many uses. It permits the manufacture of parts so uniform that they can be interchanged. Without it, mass production would not have been possible. As it turns out, the great English machinist Henry Maudsley had developed nearly the same mechanism a few years before, but this was unknown to Wilkinson and does not diminish his accomplishment."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p9->id,
            'question_number' => 9,
            'question_text' => "Why did the author write this passage?",
            'option_a' => "To prove that Wilkinson's invention was based on Maudsley's",
            'option_b' => "To demonstrate the importance of mass production to American society",
            'option_c' => "To show the usefulness of Wilkinson's invention",
            'option_d' => null,
            'correct_answer' => 'C'
        ]);

        // Passage 10
        $p10 = \App\Models\ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 10,
            'content' => "Almost every form of transportation has given someone the idea for a new type of toy. After the Montgolfier brothers flew the first balloon, toy balloons became popular playthings. In the nineteenth century, soon after railroads and steamships were developed, every child had to have model trains and steamboats. The same held true for automobiles and airplanes in the early twentieth century. Toy rockets and missiles became popular at the beginning of the space age, and by the 1980's, there were many different versions of space-shuttle toys."
        ]);

        \App\Models\ToeflReadingQuestion::create([
            'passage_id' => $p10->id,
            'question_number' => 10,
            'question_text' => "The main idea of this passage is that",
            'option_a' => "inventors have been inspired by toys to build new forms of transportation",
            'option_b' => "toy automobiles and airplanes were very popular in the early 1900's",
            'option_c' => "toy design has followed developments in transportation",
            'option_d' => null,
            'correct_answer' => 'C'
        ]);
    }
}
