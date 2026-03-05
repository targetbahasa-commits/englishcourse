<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting4Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 4
        $meeting = ToeflReadingMeeting::where('meeting_number', 4)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 4,
                'title' => 'Main Ideas 4',
                'is_locked' => false
            ]);
        }

        // Passage 1: Deer Antlers
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "Antlers grow from permanent knob like bones on a deer's skull. Deer use their antlers chiefly to fight for mates or for leadership of a herd. Among most species of deer, only the males have antlers, but both male and female reindeer and caribou have antlers. Musk deer and Chinese water deer do not have antlers at all.

Deer that live in mild or cold climates lose their antlers each winter. New ones begin to grow the next spring. Deer that live in tropical climates may lose their antlers and grow new ones at other times of year.

New antlers are soft and tender. Thin skin grows over the antlers as they develop. Short, fine hair on the skin makes it look like velvet. Full-grown antlers are hard and strong. The velvety skin dries up and the deer rubs the skin off by scraping its antlers against trees. The antlers fall off several months later.

The size and shape of a deer's antlers depend on the animal's age and health. The first set grows when the deer is from one to two years old. On most deer, the first antlers are short and straight. As deer get older, their antlers grow larger and form intricate branches."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'How do deer primarily use their antlers?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 2,
            'question_text' => 'In what way are reindeer and caribou different from other types of deer?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 3,
            'question_text' => 'When do deer that live in temperate climates begin to grow their antlers?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 4,
            'question_text' => 'According to the article, which of the following does the skin on deer\'s antlers most closely resemble?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 5,
            'question_text' => 'Which of the following factors influences the size and shape of a deer\'s antlers?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 6,
            'question_text' => 'At what age do deer get their first antlers?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 7,
            'question_text' => 'What happens to a deer\'s antlers as the deer grow older?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Note: Options not visible in screenshot - will need to be added later

        // Passage 2: Louis Armstrong
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "The trumpet player Louis Armstrong, or Satchmo as he was usually called, was among the first jazz musicians to achieve international fame. He is known for the beautiful clear tone of his trumpet playing and for his gruff, gravelly singing voice. He was one of the first musicians to sing in the scat style, using rhythmic nonsense syllables instead of lyrics.

Armstrong was born into a poor family in New Orleans. He first learned to play the cornet at the age of 13, taking lessons while living in a children's home. As a teenager, he played in a number of local jazz bands in New Orleans' rollicking nightlife district, Storyville.

In 1922, Armstrong moved to Chicago to play in Joe \"King\" Oliver's band. Two years later, he joined Fletcher Henderson's band. Then, from 1925 to 1928, Armstrong made a series of records with groups called the Hot Five, the Hot Seven, and the Savoy Ballroom Five. These records rank among the greatest recordings in the history of jazz. They include \"Cornet Chop Suey\", \"Potato Head Blues,\" and \"West End Blues.\"

Armstrong led a big band during the 1930's and 1940's, but in 1947 returned to playing with small jazz groups. He performed all over the world and made a number of hit records, such as\" Hello, Dolly\" and \"Mack the Knife.\" Armstrong also appeared in a number of movies, first in New Orleans in 1947, High Society in 1956, and Hello, Dolly in 1969."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 8,
            'question_text' => 'What was Armstrong\'s nickname?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 9,
            'question_text' => 'Which of the following phrases best describes Armstrong\'s singing voice?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 10,
            'question_text' => 'Where did Armstrong first learn to play the cornet?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 11,
            'question_text' => 'In what city was Joe "King" Oliver\'s band based?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 12,
            'question_text' => 'During what period did Armstrong record some of jazz\'s greatest records?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 13,
            'question_text' => 'What was the first movie Armstrong appeared in?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Passage 3: Morrill Act and Land-Grant Colleges
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "In 1862, during the Civil War, President Lincoln signed the Morrill Act. The measure was named for its sponsor, Congressman (later Senator) Justin S. Morrill of Vermont. Popularly called the Land Grant Act, it provided each state with 30,000 acres of public land for each senator and each representative it had in Congress. It required that the land be sold, the proceeds invested, and the income used to create and maintain colleges to teach agriculture and engineering.

Although not all states used the money as planned in the act, some thirty states did establish new institutions. Purdue University, the University of Illinois, Texas A & M, Michigan State, and the University of California all trace their roots to the Morrill Act. Eighteen states gave the money to existing state universities to finance new agricultural and engineering departments. A few gave their money to private colleges. For example, Massachusetts used most of its funds to endow the Massachusetts Institute of Technology. One state chose to use its money to establish a college for women: Connecticut, but farmers protested, and the legislature moved the assets to the University of Connecticut.

Most students chose to study engineering. Agriculture was not even considered a science until it had been dignified by the work of research stations. These were established at land-grant institutions in 1887 by the Hatch Act. Gradually, universities broke away from the narrow functions Congress had assigned them and presented a full range of academic offerings, from anthropology to zoology.

Today there are some 69 land-grant institutions in all 50 states, the District of Columbia, and Puerto Rico. About one in five college students in the United States attends land-grant schools."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 14,
            'question_text' => 'When was the Morrill Act signed?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 15,
            'question_text' => 'Who sponsored the Morrill Act?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 16,
            'question_text' => 'What position did the sponsor of the Morrill Act have at the time it was passed?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 17,
            'question_text' => 'How much land did each state receive under the Morrill Act?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 18,
            'question_text' => 'How many states used the money in the way it was intended by Congress?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 19,
            'question_text' => 'Which of these states used its money to fund a private university?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 20,
            'question_text' => 'Who objected to the way the Connecticut legislature initially decided to spend its funds?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 21,
            'question_text' => 'What was one effect of the Hatch Act of 1887?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 22,
            'question_text' => 'How many land-grant institutions are in operation at present?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 23,
            'question_text' => 'What percent of college students in the United States currently attend land-grant institutions?',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        $this->command->info('TOEFL Reading Meeting 4 seeded successfully!');
    }
}
