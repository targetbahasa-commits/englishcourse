<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting15Seeder extends Seeder
{
    /**
     * Meeting 15 — Listening: Mini-Talks & Longer Talks (Part C)
     * Format: 3-option questions about speaker identity, topic, audience, timing, and location
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 15)->delete();

        $setsData = [

            // ── SET 1 (from M15Seeder — real content, correct answers) ─────────
            1 => [
                ['q' => 1,  'a' => "A teacher.",                                    'b' => "A tour guide.",                                         'c' => "A photographer.",                                     'correct' => 'B'],
                ['q' => 2,  'a' => "A description of the wildlife preserve.",       'b' => "Advice about outdoor photography.",                      'c' => "The scientific classification of buffaloes.",          'correct' => 'A'],
                ['q' => 3,  'a' => "To explain the traditions of handball.",        'b' => "To give information about the rules of tennis.",         'c' => "To discuss the rules of handball.",                   'correct' => 'C'],
                ['q' => 4,  'a' => "At the end of a tournament.",                   'b' => "Before an exhibition game.",                             'c' => "During a game.",                                      'correct' => 'B'],
                ['q' => 5,  'a' => "Factory workers.",                              'b' => "Visitors to a factory.",                                 'c' => "Management trainees.",                                'correct' => 'B'],
                ['q' => 6,  'a' => "The process of canning soft drinks.",           'b' => "Management-labor teamwork.",                             'c' => "The life cycle of plants.",                           'correct' => 'A'],
                ['q' => 7,  'a' => "The physical rewards of dancing.",              'b' => "The importance of the program to the university.",        'c' => "The disadvantages of being in the program.",          'correct' => 'C'],
                ['q' => 8,  'a' => "Director of a dance program.",                  'b' => "Professor of psychology.",                               'c' => "Athletics coach.",                                    'correct' => 'A'],
                ['q' => 9,  'a' => "A host at a party.",                            'b' => "The president of a society.",                            'c' => "The captain of a ship.",                              'correct' => 'B'],
                ['q' => 10, 'a' => "The role of the State Historical Society.",     'b' => "The history of New England.",                            'c' => "The story of some shipwrecks.",                       'correct' => 'C'],
                ['q' => 11, 'a' => "Composition.",                                  'b' => "Fine arts.",                                             'c' => "Architecture.",                                       'correct' => 'A'],
                ['q' => 12, 'a' => "The use of blueprints.",                        'b' => "Methods of organization.",                               'c' => "Editing papers.",                                     'correct' => 'C'],
                ['q' => 13, 'a' => "Experienced skiers.",                           'b' => "Ski instructors.",                                       'c' => "Beginning skiers.",                                   'correct' => 'C'],
                ['q' => 14, 'a' => "The fundamentals of skiing.",                   'b' => "Championship skiers.",                                   'c' => "The development of ski resorts.",                     'correct' => 'A'],
                ['q' => 15, 'a' => "Law.",                                           'b' => "Economics.",                                             'c' => "Classical languages.",                                'correct' => 'B'],
                ['q' => 16, 'a' => "A few weeks after the beginning of class.",    'b' => "In the first class meeting.",                            'c' => "During the final exam.",                              'correct' => 'B'],
                ['q' => 17, 'a' => "On a boat.",                                    'b' => "At an aquarium.",                                        'c' => "On a plane.",                                         'correct' => 'A'],
                ['q' => 18, 'a' => "The habits of whales.",                         'b' => "Types of whales.",                                       'c' => "Efforts to protect whales.",                          'correct' => 'A'],
                ['q' => 19, 'a' => "Students who own bicycles.",                    'b' => "New members of the campus police force.",                'c' => "Pedestrians concerned about safety.",                  'correct' => 'A'],
                ['q' => 20, 'a' => "To describe some recent accidents.",            'b' => "To introduce a new program.",                            'c' => "To provide safety and security hints.",               'correct' => 'C'],
            ],

            // ── SET 2 ──────────────────────────────────────────────────────────
            2 => [
                ['q' => 1,  'a' => "A chef.",                                       'b' => "A nutritionist.",                                        'c' => "A cooking instructor.",                               'correct' => 'C'],
                ['q' => 2,  'a' => "The history of Italian cuisine.",               'b' => "How to prepare a healthy meal.",                         'c' => "Food safety regulations.",                            'correct' => 'B'],
                ['q' => 3,  'a' => "To warn students about health risks.",         'b' => "To encourage students to exercise.",                     'c' => "To explain the benefits of a balanced diet.",         'correct' => 'C'],
                ['q' => 4,  'a' => "At a gym orientation.",                         'b' => "At a health fair.",                                      'c' => "In a nutrition class.",                               'correct' => 'C'],
                ['q' => 5,  'a' => "High school students.",                         'b' => "Medical professionals.",                                 'c' => "College freshmen.",                                   'correct' => 'C'],
                ['q' => 6,  'a' => "The causes of stress.",                         'b' => "Time management strategies.",                            'c' => "Sleep and academic performance.",                     'correct' => 'B'],
                ['q' => 7,  'a' => "The benefits of the research program.",        'b' => "The requirements for graduation.",                       'c' => "The cost of the program.",                           'correct' => 'A'],
                ['q' => 8,  'a' => "The department chairperson.",                   'b' => "A graduate student.",                                    'c' => "A research program director.",                        'correct' => 'C'],
                ['q' => 9,  'a' => "A radio host.",                                 'b' => "A museum guide.",                                        'c' => "A history professor.",                                'correct' => 'B'],
                ['q' => 10, 'a' => "Ancient Egyptian burial customs.",              'b' => "Modern art movements.",                                  'c' => "The architectural history of the museum.",            'correct' => 'A'],
                ['q' => 11, 'a' => "Biology.",                                       'b' => "Environmental science.",                                 'c' => "Chemistry.",                                          'correct' => 'B'],
                ['q' => 12, 'a' => "The impact of pollution on river ecosystems.", 'b' => "New laboratory techniques.",                             'c' => "The classification of freshwater species.",           'correct' => 'A'],
                ['q' => 13, 'a' => "Competitive swimmers.",                         'b' => "Recreational swimmers.",                                 'c' => "Young children learning to swim.",                    'correct' => 'C'],
                ['q' => 14, 'a' => "Water safety techniques.",                      'b' => "Competitive swimming rules.",                            'c' => "The history of swimming as a sport.",                 'correct' => 'A'],
                ['q' => 15, 'a' => "Computer science.",                             'b' => "Business administration.",                              'c' => "Graphic design.",                                     'correct' => 'B'],
                ['q' => 16, 'a' => "On the last day of the semester.",             'b' => "During the first week of class.",                       'c' => "After midterm exams.",                                'correct' => 'B'],
                ['q' => 17, 'a' => "On a nature trail.",                            'b' => "In a botanic garden.",                                   'c' => "At a wildlife sanctuary.",                            'correct' => 'C'],
                ['q' => 18, 'a' => "The migration patterns of birds.",             'b' => "How to identify native plants.",                         'c' => "Conservation efforts for endangered species.",        'correct' => 'C'],
                ['q' => 19, 'a' => "New international students.",                   'b' => "Campus tour volunteers.",                               'c' => "Incoming faculty members.",                           'correct' => 'A'],
                ['q' => 20, 'a' => "To describe campus facilities.",               'b' => "To welcome students and explain support services.",      'c' => "To discuss academic requirements.",                   'correct' => 'B'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'a' => "A pharmacist.",                                 'b' => "A doctor.",                                             'c' => "A medical researcher.",                               'correct' => 'B'],
                ['q' => 2,  'a' => "Common cold prevention.",                       'b' => "The effects of vitamins on the immune system.",         'c' => "Prescription drug guidelines.",                       'correct' => 'B'],
                ['q' => 3,  'a' => "To describe the history of aviation.",         'b' => "To explain how airplanes stay in the air.",             'c' => "To compare different types of aircraft.",             'correct' => 'B'],
                ['q' => 4,  'a' => "At an aviation museum.",                        'b' => "In a physics class.",                                   'c' => "At an airport.",                                     'correct' => 'B'],
                ['q' => 5,  'a' => "Airline passengers.",                           'b' => "Engineering students.",                                  'c' => "Air traffic controllers.",                            'correct' => 'B'],
                ['q' => 6,  'a' => "The geology of volcanic islands.",             'b' => "Marine biology research methods.",                      'c' => "Ocean current patterns.",                             'correct' => 'A'],
                ['q' => 7,  'a' => "The funding sources for the expedition.",     'b' => "The scope of a recent geological study.",              'c' => "Equipment used by researchers.",                     'correct' => 'B'],
                ['q' => 8,  'a' => "A scientist presenting research.",             'b' => "A travel journalist.",                                  'c' => "A government official.",                              'correct' => 'A'],
                ['q' => 9,  'a' => "A librarian.",                                  'b' => "A bookseller.",                                         'c' => "A literature professor.",                             'correct' => 'C'],
                ['q' => 10, 'a' => "American literature of the 20th century.",     'b' => "How to find rare books.",                               'c' => "The process of publishing a novel.",                  'correct' => 'A'],
                ['q' => 11, 'a' => "Psychology.",                                   'b' => "Sociology.",                                             'c' => "Public health.",                                      'correct' => 'A'],
                ['q' => 12, 'a' => "The causes of workplace burnout.",             'b' => "Techniques for improving memory.",                      'c' => "The effects of social media on behavior.",            'correct' => 'B'],
                ['q' => 13, 'a' => "Advanced marathon runners.",                   'b' => "People new to running.",                                'c' => "Professional sports coaches.",                        'correct' => 'B'],
                ['q' => 14, 'a' => "How to train for a first 5K race.",           'b' => "Injury prevention for competitive athletes.",          'c' => "The history of the Olympic marathon.",               'correct' => 'A'],
                ['q' => 15, 'a' => "Political science.",                            'b' => "Philosophy.",                                           'c' => "Journalism.",                                         'correct' => 'C'],
                ['q' => 16, 'a' => "At the beginning of a journalism conference.", 'b' => "During a semester orientation.",                        'c' => "At an internship fair.",                              'correct' => 'A'],
                ['q' => 17, 'a' => "At a nature reserve.",                          'b' => "During a museum exhibition.",                           'c' => "At a science fair.",                                  'correct' => 'B'],
                ['q' => 18, 'a' => "The discovery of a new dinosaur species.",    'b' => "The process of fossil excavation.",                    'c' => "How to date ancient artifacts.",                      'correct' => 'A'],
                ['q' => 19, 'a' => "Incoming transfer students.",                   'b' => "Honor roll students.",                                 'c' => "Students applying for scholarships.",                 'correct' => 'C'],
                ['q' => 20, 'a' => "To explain the financial aid process.",        'b' => "To motivate students to apply for awards.",            'c' => "To outline scholarship eligibility requirements.",    'correct' => 'C'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 15,
                    'set_number'     => $setNumber,
                    'question_number'=> $q['q'],
                    'question_text'  => 'Question ' . $q['q'],
                    'option_a'       => $q['a'],
                    'option_b'       => $q['b'],
                    'option_c'       => $q['c'],
                    'option_d'       => '',
                    'correct_answer' => $q['correct'],
                    'audio_file'     => null,
                    'transcript_en'  => null,
                    'transcript_id'  => null,
                ]);
            }
            $this->command->info("Meeting 15 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
