<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;
use App\Models\ToeflReadingMeeting;

class ToeflReadingPackage1Part3Seeder extends Seeder
{
    public function run(): void
    {
        $meeting = ToeflReadingMeeting::where('title', 'Mockup Package 1 Reading')->first();
        if (!$meeting) {
            $this->command->error('Meeting not found. Run ToeflReadingPackage1Seeder first.');
            return;
        }

        // ==============================
        // UPDATE PASSAGE 4: Add Q36-40 (Insect Wings)
        // Q30-35 still pending from user
        // ==============================
        $passage4 = ToeflReadingPassage::where('package_number', 1)->where('passage_number', 4)->first();
        if ($passage4) {
            // Remove old placeholder Q30
            ToeflReadingQuestion::where('passage_id', $passage4->id)->delete();

            // Add Q30-35 placeholders (to be corrected later)
            $q30_35 = [
                [
                    'question_number' => 30,
                    'question_text'   => 'What is the main topic of the passage?',
                    'option_a'        => 'How insects developed wings for flight',
                    'option_b'        => 'The differences between insects and birds',
                    'option_c'        => 'How insects use their wings to find food',
                    'option_d'        => 'The various types of flying insects',
                    'correct_answer'  => 'A',
                ],
                [
                    'question_number' => 31,
                    'question_text'   => 'According to the passage, which of the following is true about insect wings?',
                    'option_a'        => 'They are similar to the wings of birds.',
                    'option_b'        => 'They evolved specifically for flight.',
                    'option_c'        => 'They are attached to the lower thorax.',
                    'option_d'        => 'They were originally used for swimming.',
                    'correct_answer'  => 'B',
                ],
                [
                    'question_number' => 32,
                    'question_text'   => 'The word "primitive" in line 10 is closest in meaning to',
                    'option_a'        => 'simple',
                    'option_b'        => 'ancient',
                    'option_c'        => 'rare',
                    'option_d'        => 'small',
                    'correct_answer'  => 'B',
                ],
                [
                    'question_number' => 33,
                    'question_text'   => 'According to the passage, what is the function of veins in insect wings?',
                    'option_a'        => 'They help insects identify members of their species.',
                    'option_b'        => 'They provide strength and flexibility.',
                    'option_c'        => 'They allow insects to fold their wings.',
                    'option_d'        => 'They help insects breathe during flight.',
                    'correct_answer'  => 'B',
                ],
                [
                    'question_number' => 34,
                    'question_text'   => 'The word "critical" in line 15 is closest in meaning to',
                    'option_a'        => 'difficult',
                    'option_b'        => 'important',
                    'option_c'        => 'unique',
                    'option_d'        => 'visible',
                    'correct_answer'  => 'B',
                ],
                [
                    'question_number' => 35,
                    'question_text'   => 'According to the passage, what causes the wings of a newly emerged insect to unfurl?',
                    'option_a'        => 'Blood pumped through the wing cells',
                    'option_b'        => 'Air pumped through the veins',
                    'option_c'        => 'The hardening of the wing veins',
                    'option_d'        => 'Exercise of the tracheal system',
                    'correct_answer'  => 'B',
                ],
            ];

            foreach ($q30_35 as $q) {
                ToeflReadingQuestion::create(array_merge(['passage_id' => $passage4->id], $q));
            }

            // Add actual Q36-40 from user images
            $q36_40 = [
                [
                    'question_number' => 36,
                    'question_text'   => 'The word "they" in line 21 refers to',
                    'option_a'        => 'spaces',
                    'option_b'        => 'wings',
                    'option_c'        => 'insects',
                    'option_d'        => 'veins',
                    'correct_answer'  => 'D',
                ],
                [
                    'question_number' => 37,
                    'question_text'   => 'How do the forward and trailing edges of insect wings differ?',
                    'option_a'        => 'There are fewer veins in the trailing edge.',
                    'option_b'        => 'They have veins of different thicknesses.',
                    'option_c'        => 'Only the forward edge produces forward movement.',
                    'option_d'        => 'One curls on the upstroke and the other curls on the downstroke.',
                    'correct_answer'  => 'B',
                ],
                [
                    'question_number' => 38,
                    'question_text'   => 'The word "flexible" in line 24 is closest in meaning to',
                    'option_a'        => 'pointed',
                    'option_b'        => 'weak',
                    'option_c'        => 'able to expand',
                    'option_d'        => 'able to bend',
                    'correct_answer'  => 'D',
                ],
                [
                    'question_number' => 39,
                    'question_text'   => 'Which of the following can be inferred from the passage about the capabilities of an adult insect that has recently emerged from the pupa?',
                    'option_a'        => 'It cannot fly immediately.',
                    'option_b'        => 'It has difficulty breathing.',
                    'option_c'        => 'It uses its wings for balance.',
                    'option_d'        => 'It cannot remain upright.',
                    'correct_answer'  => 'A',
                ],
                [
                    'question_number' => 40,
                    'question_text'   => 'Which of the following aspects of insects that can fly is NOT discussed in the passage?',
                    'option_a'        => 'The origin of their wings',
                    'option_b'        => 'Their movements while in flight',
                    'option_c'        => 'The physical structure of their wings',
                    'option_d'        => 'The speed at which they can fly',
                    'correct_answer'  => 'D',
                ],
            ];

            foreach ($q36_40 as $q) {
                ToeflReadingQuestion::create(array_merge(['passage_id' => $passage4->id], $q));
            }
            echo "✅ Updated Passage 4 (Insect Wings): Q30-35 (placeholder) + Q36-40 (confirmed) ";
        }

        // ==============================
        // PASSAGE 5: Formalism vs Contextualism
        // Questions 41-50
        // ==============================
        $existing5 = ToeflReadingPassage::where('package_number', 1)->where('passage_number', 5)->first();
        if ($existing5) {
            ToeflReadingQuestion::where('passage_id', $existing5->id)->delete();
            $existing5->delete();
        }

        $passage5 = ToeflReadingPassage::create([
            'meeting_id'     => $meeting->id,
            'package_number' => 1,
            'passage_number' => 5,
            'content'        => "Viewed from a formalist perspective, art is appreciated for the enlivening aesthetic experience its visual form can provide. The name formalism stems from the primary focus of this perspective on the artistic form of the work: its line, shape, color, texture, and composition. For the formalist, art is to be valued for its artistic qualities, separate from its connection to the larger world. In the case of a film, the viewer would concentrate on its formal qualities (for instance, camera compositions, editing rhythms, settings, lighting effects, dialogue, and sound track) while ignoring the film's contextual relationships to social and political issues. It is believed that such \"nonartistic\" considerations only detract from the aesthetic experience the work's artistic form can provide. Although the formalist approach pares away history, morality, and virtually everything other than color, shape, technique, and composition, this approach does get the viewer to look closely and respond with feeling to the artwork's sensuous qualities.  In contrast to formalism, contextualism is concerned with the appreciation of art \"in context,\" that is, in relation to the rest of life. Like a wide-angle camera shot, contextualism takes in the big picture. Everything that surrounds and relates to the artwork is relevant: the viewer; the artist; the physical setting of the work; and the art, culture, and society that gave birth to it. For the contextualist, a full appreciation of a film is impossible without information about its director and the director's creative process, as well as knowledge about the era and the culture of the country in which the film was made. The strong point of the contextualist approach is its ability to expand the viewer's understanding of the work in relation to the larger world. In contrast to the reductive focus of formalism, contextualism offers the viewer many ways of looking at and giving meaning to the artwork. Its major limitation, the formalists say, stems from its primary concern with facts and theories. They argue that contextualists can often emphasize fact-finding and theorizing to the exclusion of any sensuous response to the work of art.",
        ]);

        $questions5 = [
            [
                'question_number' => 41,
                'question_text'   => 'What is the passage mainly about?',
                'option_a'        => 'Formalist and contextualist issues reflected in visual art',
                'option_b'        => 'Appreciation of artistic qualities in film',
                'option_c'        => 'Formalist and contextualist points of view on art',
                'option_d'        => 'Limitations of modern theories of art',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 42,
                'question_text'   => 'According to the first paragraph, a formalist evaluates a work of art in terms of',
                'option_a'        => '"nonartistic" considerations that enhance the aesthetic experience of the artwork',
                'option_b'        => 'purely aesthetic aspects of the artwork',
                'option_c'        => 'the relationship of the artwork to social and political matters',
                'option_d'        => 'the historical accuracy of the artist\'s treatment of the subject of the artwork',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 43,
                'question_text'   => 'The first paragraph mentions all of the following as examples of artistic form EXCEPT',
                'option_a'        => 'texture',
                'option_b'        => 'color',
                'option_c'        => 'morality',
                'option_d'        => 'shape',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 44,
                'question_text'   => 'The phrase "concentrate on" in line 6 is closest in meaning to',
                'option_a'        => 'memorize',
                'option_b'        => 'focus on',
                'option_c'        => 'experiment with',
                'option_d'        => 'criticize',
                'correct_answer'  => 'B',
            ],
            [
                'question_number' => 45,
                'question_text'   => 'Which of the following would most likely be a topic of discussion in a formalist analysis of a painting?',
                'option_a'        => 'The artistic techniques used in the painting',
                'option_b'        => 'The social background of the artist',
                'option_c'        => 'The place where the piece was painted',
                'option_d'        => 'The impact of the painting on society',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 46,
                'question_text'   => 'The author makes a comparison between a "wide-angle camera shot" (line 15) and the way that contextualists',
                'option_a'        => 'utilize a large range of artistic styles',
                'option_b'        => 'interpret the formal aspects of art',
                'option_c'        => 'study various influences on a work of art',
                'option_d'        => 'emphasize aesthetic experience',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 47,
                'question_text'   => 'The word "it" in line 18 refers to',
                'option_a'        => 'artwork',
                'option_b'        => 'physical setting',
                'option_c'        => 'culture',
                'option_d'        => 'society',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 48,
                'question_text'   => 'The word "era" in line 20 is closest in meaning to',
                'option_a'        => 'character',
                'option_b'        => 'development',
                'option_c'        => 'period',
                'option_d'        => 'role',
                'correct_answer'  => 'C',
            ],
            [
                'question_number' => 49,
                'question_text'   => 'The phrase "stems from" in line 24 is closest in meaning to',
                'option_a'        => 'grows out of',
                'option_b'        => 'turns into',
                'option_c'        => 'runs up against',
                'option_d'        => 'argues for',
                'correct_answer'  => 'A',
            ],
            [
                'question_number' => 50,
                'question_text'   => 'According to the second paragraph, formalists claim that the weakest aspect of contextualism is which of the following?',
                'option_a'        => 'Its reductive focus',
                'option_b'        => 'Its concentration on appealing to the viewer\'s senses',
                'option_c'        => 'Its inability to offer a viewer more than one way of looking at art',
                'option_d'        => 'Its primary concern with facts and theories',
                'correct_answer'  => 'D',
            ],
        ];

        foreach ($questions5 as $q) {
            ToeflReadingQuestion::create(array_merge(['passage_id' => $passage5->id], $q));
        }
        echo "✅ Added Passage 5 (Formalism vs Contextualism): 10 questions (Q41-50) ";

        // Summary
        echo " === Final Summary === ";
        ToeflReadingPassage::where('package_number', 1)->with('questions')->orderBy('passage_number')->get()->each(function($p) {
            $min = $p->questions->min('question_number');
            $max = $p->questions->max('question_number');
            echo "Passage {$p->passage_number}: {$p->questions->count()} questions | Q{$min}-Q{$max} ";
        });
        echo "Total: " . ToeflReadingPassage::where('package_number', 1)->count() . " passages ";
    }
}
