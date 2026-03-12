<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting12Seeder extends Seeder
{
    /**
     * Meeting 12 — Listening: Longer Conversations (What are they talking about? Where? Who?)
     * Format: 3-option questions about conversation context, topic, location, and relationship
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 12)->delete();

        $setsData = [

            // ── SET 1 (from M12Seeder — real content, correct answers) ─────────
            1 => [
                ['q' => 1,  'a' => "Methods of predicting earthquakes.",                    'b' => "Ways to improve the man's presentation.",          'c' => "The many new uses of computer graphics.",     'correct' => 'B'],
                ['q' => 2,  'a' => "Statistics.",                                            'b' => "Computer science.",                               'c' => "Geology.",                                    'correct' => 'C'],
                ['q' => 3,  'a' => "A language teacher and a student.",                     'b' => "A dean and a teacher.",                           'c' => "A teacher and an assistant.",                 'correct' => 'A'],
                ['q' => 4,  'a' => "The language of the deaf.",                             'b' => "Methods of teaching German.",                     'c' => "Communication networks.",                     'correct' => 'A'],
                ['q' => 5,  'a' => "Professor Quinn's approach to teaching.",               'b' => "The process of getting a student identification card.", 'c' => "Procedures for checking out reserve material.", 'correct' => 'C'],
                ['q' => 6,  'a' => "At a university library.",                              'b' => "In a psychology class.",                          'c' => "In a laboratory.",                            'correct' => 'A'],
                ['q' => 7,  'a' => "To ask for a job.",                                     'b' => "To get some advice.",                             'c' => "To discuss medical research.",                'correct' => 'B'],
                ['q' => 8,  'a' => "Academic advisor.",                                     'b' => "Physician.",                                     'c' => "Administrator.",                              'correct' => 'C'],
                ['q' => 9,  'a' => "Helpful.",                                              'b' => "Discouraging.",                                  'c' => "Inconsiderate.",                              'correct' => 'A'],
                ['q' => 10, 'a' => "The art of raising dogs.",                              'b' => "A softball game.",                               'c' => "A dogsled race.",                             'correct' => 'C'],
                ['q' => 11, 'a' => "An archaeologist.",                                     'b' => "An anthropologist.",                             'c' => "A university student.",                       'correct' => 'C'],
                ['q' => 12, 'a' => "Their plans for the coming school year.",               'b' => "Tina's volunteer position.",                     'c' => "Tina's trip to Europe.",                      'correct' => 'B'],
                ['q' => 13, 'a' => "A clerk at a bookstore.",                               'b' => "A librarian.",                                   'c' => "A publisher's sales officer.",                'correct' => 'C'],
                ['q' => 14, 'a' => "Before the spring term begins.",                        'b' => "In the middle of the spring term.",               'c' => "After the spring term ends.",                 'correct' => 'A'],
                ['q' => 15, 'a' => "In Nicholson Hall.",                                    'b' => "In the Graduate Admissions Office.",             'c' => "In the Financial Aid Office.",                'correct' => 'C'],
                ['q' => 16, 'a' => "Requirements for graduate admission.",                  'b' => "Directions to another office.",                  'c' => "The woman's need for a scholarship.",         'correct' => 'B'],
            ],

            // ── SET 2 ──────────────────────────────────────────────────────────
            2 => [
                ['q' => 1,  'a' => "The history of jazz music.",                            'b' => "Upcoming concert events.",                       'c' => "The woman's music project.",                  'correct' => 'C'],
                ['q' => 2,  'a' => "Music school.",                                         'b' => "A recording studio.",                            'c' => "A university common room.",                   'correct' => 'C'],
                ['q' => 3,  'a' => "A student and a professor.",                            'b' => "Two classmates.",                                'c' => "Two musicians.",                              'correct' => 'B'],
                ['q' => 4,  'a' => "Where to find a good restaurant.",                     'b' => "The best way to travel to campus.",              'c' => "How to get a campus parking permit.",         'correct' => 'C'],
                ['q' => 5,  'a' => "At a parking office.",                                  'b' => "On the telephone.",                             'c' => "Near a campus entrance.",                     'correct' => 'A'],
                ['q' => 6,  'a' => "To report a lost item.",                                'b' => "To request an appointment.",                    'c' => "To renew a parking permit.",                  'correct' => 'B'],
                ['q' => 7,  'a' => "A secretary.",                                          'b' => "A campus security officer.",                    'c' => "A university administrator.",                 'correct' => 'C'],
                ['q' => 8,  'a' => "Cooperative.",                                          'b' => "Strict.",                                       'c' => "Unresponsive.",                               'correct' => 'A'],
                ['q' => 9,  'a' => "The student's research findings.",                     'b' => "The design of an experiment.",                  'c' => "How to analyze data.",                        'correct' => 'B'],
                ['q' => 10, 'a' => "In a science lab.",                                     'b' => "At a professor's office.",                      'c' => "In a study lounge.",                          'correct' => 'B'],
                ['q' => 11, 'a' => "A researcher.",                                         'b' => "A graduate student.",                           'c' => "A lab technician.",                           'correct' => 'B'],
                ['q' => 12, 'a' => "A marketing campaign.",                                 'b' => "Scheduling for next semester.",                 'c' => "Group project deadlines.",                    'correct' => 'C'],
                ['q' => 13, 'a' => "A tutor.",                                              'b' => "A student.",                                    'c' => "A teaching assistant.",                       'correct' => 'C'],
                ['q' => 14, 'a' => "Two weeks from now.",                                   'b' => "At the end of the month.",                     'c' => "Before this Friday.",                         'correct' => 'C'],
                ['q' => 15, 'a' => "In the student center.",                                'b' => "Online.",                                       'c' => "In the registrar's office.",                  'correct' => 'B'],
                ['q' => 16, 'a' => "The best time to submit the project.",                  'b' => "Which topic to choose.",                        'c' => "Where to submit the final paper.",             'correct' => 'B'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'a' => "Planning a field trip.",                                'b' => "Preparing a class presentation.",               'c' => "Choosing an elective course.",                'correct' => 'B'],
                ['q' => 2,  'a' => "In a lecture hall.",                                    'b' => "In a faculty office.",                          'c' => "In the school canteen.",                      'correct' => 'B'],
                ['q' => 3,  'a' => "Two professors.",                                       'b' => "A professor and a student.",                    'c' => "Two students.",                               'correct' => 'B'],
                ['q' => 4,  'a' => "How to improve sleep habits.",                         'b' => "The effects of stress on academic performance.", 'c' => "Campus health services.",                    'correct' => 'B'],
                ['q' => 5,  'a' => "At a health clinic.",                                   'b' => "In a counseling office.",                       'c' => "In the student common room.",                 'correct' => 'B'],
                ['q' => 6,  'a' => "To pick up a prescription.",                           'b' => "To seek mental health support.",               'c' => "To report a problem.",                        'correct' => 'B'],
                ['q' => 7,  'a' => "A counselor.",                                          'b' => "A doctor.",                                    'c' => "A professor.",                                'correct' => 'A'],
                ['q' => 8,  'a' => "Empathetic.",                                           'b' => "Dismissive.",                                  'c' => "Overly formal.",                              'correct' => 'A'],
                ['q' => 9,  'a' => "Career options after graduation.",                     'b' => "Requirements for the journalism program.",     'c' => "How to get a summer internship.",             'correct' => 'C'],
                ['q' => 10, 'a' => "In a career center.",                                   'b' => "In a journalism classroom.",                   'c' => "At a job fair.",                              'correct' => 'A'],
                ['q' => 11, 'a' => "A career counselor.",                                   'b' => "A journalism professor.",                      'c' => "A company recruiter.",                        'correct' => 'A'],
                ['q' => 12, 'a' => "Volunteer work at a local school.",                    'b' => "An upcoming exchange program.",                'c' => "Summer travel plans.",                        'correct' => 'A'],
                ['q' => 13, 'a' => "A student coordinator.",                                'b' => "A school administrator.",                      'c' => "A community organizer.",                      'correct' => 'A'],
                ['q' => 14, 'a' => "During the summer break.",                              'b' => "Starting next month.",                         'c' => "After final exams.",                          'correct' => 'C'],
                ['q' => 15, 'a' => "At the volunteer center.",                              'b' => "Through the school website.",                  'c' => "By contacting the coordinator directly.",     'correct' => 'B'],
                ['q' => 16, 'a' => "Getting parental approval.",                           'b' => "Finding transportation.",                      'c' => "Meeting the minimum age requirement.",        'correct' => 'C'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 12,
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
            $this->command->info("Meeting 12 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
