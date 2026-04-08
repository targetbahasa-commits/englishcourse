<?php

namespace Database\Seeders;

use App\Models\ToeflMockupQuestion;
use Illuminate\Database\Seeder;

class ToeflListeningPackage1Seeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            ['part' => 'A', 'number' => 1, 'a' => 'Her concerns were expressed.', 'b' => 'She wonders if the concert was good.', 'c' => 'The music was fantastic.', 'd' => 'She wandered about during the night.', 'answer' => 'C'],
            ['part' => 'A', 'number' => 2, 'a' => 'In a bus station.', 'b' => 'In a post office.', 'c' => 'In an airport.', 'd' => 'In a travel agency.', 'answer' => 'B'],
            ['part' => 'A', 'number' => 3, 'a' => 'He spends half his time with his daughter.', 'b' => "His daughter's under a year old.", 'c' => 'His daughter will start school in a year and a half.', 'd' => "His daughter's eighteen months old.", 'answer' => 'D'],
            ['part' => 'A', 'number' => 4, 'a' => "He's on the basketball team.", 'b' => "He doesn't even like to play basketball.", 'c' => "He's too short to make the team.", 'd' => "He thinks he's tall enough.", 'answer' => 'C'],
            ['part' => 'A', 'number' => 5, 'a' => "She's thinking about her grade in the seminar.", 'b' => 'The seminar is quite realistic.', 'c' => 'The seminar will take a great deal of time.', 'd' => 'She agrees with the man about the seminar.', 'answer' => 'D'],
            ['part' => 'A', 'number' => 6, 'a' => 'The location of the meeting.', 'b' => 'The purpose of the meeting.', 'c' => 'Who will attend the meeting.', 'd' => 'The time the meeting starts.', 'answer' => 'A'],
            ['part' => 'A', 'number' => 7, 'a' => 'Preparing dinner later.', 'b' => 'Going to a restaurant.', 'c' => 'Cooking a full dinner.', 'd' => 'Eating dinner outside in the garden.', 'answer' => 'B'],
            ['part' => 'A', 'number' => 8, 'a' => 'She is fond of Joe.', 'b' => 'Joe is not lost anymore.', 'c' => 'She visits Joe regularly.', 'd' => 'The call was already made.', 'answer' => 'D'],
            ['part' => 'A', 'number' => 9, 'a' => 'He was quite fortunate.', 'b' => 'He lacked the opportunity to play the game.', 'c' => "He didn't actually win the game.", 'd' => 'He came sometime after Luke.', 'answer' => 'A'],
            ['part' => 'A', 'number' => 10, 'a' => "It's quite clean.", 'b' => "It doesn't move.", 'c' => "It's clearly better.", 'd' => "It's rather dirty.", 'answer' => 'D'],
            ['part' => 'A', 'number' => 11, 'a' => 'A bus driver.', 'b' => 'An art teacher.', 'c' => 'A flight attendant.', 'd' => 'A travel agent.', 'answer' => 'C'],
            ['part' => 'A', 'number' => 12, 'a' => 'His desk is made of metal.', 'b' => 'He never meddles with his office workers.', 'c' => 'His desk is on the right side of the office.', 'd' => 'He works in the center of the office.', 'answer' => 'D'],
            ['part' => 'A', 'number' => 13, 'a' => 'Learning something about golf.', 'b' => 'Taking fewer lessons than he has in the past.', 'c' => 'Letting her play golf instead of him.', 'd' => 'Going to play golf together.', 'answer' => 'A'],
            ['part' => 'A', 'number' => 14, 'a' => 'He does not live nearby.', 'b' => 'They will go later.', 'c' => 'It is not time to deliver the paper.', 'd' => 'He does not have time to read.', 'answer' => 'B'],
            ['part' => 'A', 'number' => 15, 'a' => 'She will assign the homework tomorrow.', 'b' => 'The man can do the homework next week.', 'c' => 'She will return the homework next week.', 'd' => 'The assignment must be turned in tomorrow.', 'answer' => 'D'],
            ['part' => 'A', 'number' => 16, 'a' => 'The woman is really beautiful.', 'b' => 'The woman should repeat what she said.', 'c' => "He shares the woman's opinion.", 'd' => 'He has time this year to travel.', 'answer' => 'C'],
            ['part' => 'A', 'number' => 17, 'a' => 'In a shoe store.', 'b' => 'In a motel.', 'c' => 'In a clothing store.', 'd' => 'In a storage facility.', 'answer' => 'C'],
            ['part' => 'A', 'number' => 18, 'a' => "She's going to the supermarket.", 'b' => 'She works in a grocery store.', 'c' => "She's not going out.", 'd' => "She doesn't have enough money for groceries.", 'answer' => 'A'],
            ['part' => 'A', 'number' => 19, 'a' => "He didn't really get the highest grade.", 'b' => "He's rather intelligent.", 'c' => "He's not done with the exam.", 'd' => "He's not even in the class.", 'answer' => 'B'],
            ['part' => 'A', 'number' => 20, 'a' => 'Resting for a few minutes.', 'b' => 'Studying a bit longer.', 'c' => 'Taking a five-hour break.', 'd' => 'Studying for shorter periods of time.', 'answer' => 'A'],
            ['part' => 'A', 'number' => 21, 'a' => 'She needs a new suitcase.', 'b' => "She's putting on a suit.", 'c' => "She's preparing for a trip.", 'd' => 'She just received a package.', 'answer' => 'C'],
            ['part' => 'A', 'number' => 22, 'a' => 'It was the last game.', 'b' => 'The dream was really bad.', 'c' => 'The man never lets her talk.', 'd' => 'She feels the same way as the man.', 'answer' => 'D'],
            ['part' => 'A', 'number' => 23, 'a' => "He's a bit too strong.", 'b' => "He's bitter about the accident.", 'c' => "He's still weak.", 'd' => 'He feels the accident was not his fault.', 'answer' => 'C'],
            ['part' => 'A', 'number' => 24, 'a' => 'There seems to be a problem with the motor.', 'b' => "He doesn't want to be an engineer.", 'c' => 'The music on the car stereo is good.', 'd' => 'He likes the sound of the engine.', 'answer' => 'A'],
            ['part' => 'A', 'number' => 25, 'a' => 'An artist.', 'b' => 'A tour guide.', 'c' => 'A teacher.', 'd' => 'A pilot.', 'answer' => 'B'],
            ['part' => 'A', 'number' => 26, 'a' => 'Buying some cream for coffee.', 'b' => 'Cleaning out the garage.', 'c' => 'Painting the apartment walls green.', 'd' => 'Putting the apartment in order.', 'answer' => 'D'],
            ['part' => 'A', 'number' => 27, 'a' => 'He was happy to write the check.', 'b' => 'He received a large sum of money.', 'c' => 'He was working in a huge factory.', 'd' => 'He found some hidden bones.', 'answer' => 'B'],
            ['part' => 'A', 'number' => 28, 'a' => "She doesn't need to store anything.", 'b' => 'She prefers shopping nearby.', 'c' => 'The stores are all too far away.', 'd' => "She doesn't want to go shopping.", 'answer' => 'B'],
            ['part' => 'A', 'number' => 29, 'a' => 'The door was closed really hard.', 'b' => 'Alice left because she was hungry.', 'c' => 'The door was smoothly sanded.', 'd' => 'Alice went out through the door on the left side.', 'answer' => 'A'],
            ['part' => 'A', 'number' => 30, 'a' => 'Take a bike ride.', 'b' => 'Take the high road.', 'c' => 'Go for a walk in the forest.', 'd' => 'Look for firewood.', 'answer' => 'C'],

            ['part' => 'B', 'number' => 31, 'a' => 'A new bicycle.', 'b' => 'An inexpensive bicycle.', 'c' => 'A fast bicycle.', 'd' => 'A stationary bicycle.', 'answer' => 'B'],
            ['part' => 'B', 'number' => 32, 'a' => 'A half mile.', 'b' => 'A mile.', 'c' => 'Two miles.', 'd' => 'Four miles.', 'answer' => 'C'],
            ['part' => 'B', 'number' => 33, 'a' => "He doesn't like it.", 'b' => "It doesn't work very well.", 'c' => "It's broken.", 'd' => 'He got a new one.', 'answer' => 'D'],
            ['part' => 'B', 'number' => 34, 'a' => "Go see his friend's bicycle.", 'b' => 'See her new apartment.', 'c' => 'Walk to school.', 'd' => 'Buy a new bicycle.', 'answer' => 'A'],
            ['part' => 'B', 'number' => 35, 'a' => 'Planning a trip.', 'b' => 'Camping in the woods.', 'c' => 'Putting up a tent.', 'd' => 'Looking at photos.', 'answer' => 'D'],
            ['part' => 'B', 'number' => 36, 'a' => 'It looks comfortable.', 'b' => "It doesn't seem very big.", 'c' => 'It looks funny.', 'd' => "It's full of fish.", 'answer' => 'B'],
            ['part' => 'B', 'number' => 37, 'a' => 'Standing in a river.', 'b' => 'Putting up a tent.', 'c' => 'Sitting in front of the tent.', 'd' => 'Swimming in the river.', 'answer' => 'A'],
            ['part' => 'B', 'number' => 38, 'a' => 'Lots.', 'b' => 'A few.', 'c' => 'One.', 'd' => 'None.', 'answer' => 'D'],

            ['part' => 'C', 'number' => 39, 'a' => 'Only three chapters.', 'b' => 'Three chemistry books.', 'c' => 'Lecture notes and part of the book.', 'd' => 'Only class notes from the lectures.', 'answer' => 'C'],
            ['part' => 'C', 'number' => 40, 'a' => 'Only multiple choice.', 'b' => 'Short and long essays.', 'c' => 'Three short essays.', 'd' => 'Essays and multiple choice.', 'answer' => 'D'],
            ['part' => 'C', 'number' => 41, 'a' => 'Half an hour.', 'b' => 'Fifty minutes.', 'c' => 'An hour.', 'd' => 'Ninety minutes.', 'answer' => 'D'],
            ['part' => 'C', 'number' => 42, 'a' => 'Listen to a lecture.', 'b' => 'Study for the exam.', 'c' => 'Read three chapters.', 'd' => 'Take an exam.', 'answer' => 'A'],
            ['part' => 'C', 'number' => 43, 'a' => 'In a zoo.', 'b' => 'On a boat.', 'c' => 'In a prison.', 'd' => 'In a lecture hall.', 'answer' => 'B'],
            ['part' => 'C', 'number' => 44, 'a' => 'A type of rock.', 'b' => 'A Spanish explorer.', 'c' => 'A prison in San Francisco.', 'd' => 'A kind of bird.', 'answer' => 'D'],
            ['part' => 'C', 'number' => 45, 'a' => 'Five.', 'b' => 'Ten.', 'c' => 'Twenty-four.', 'd' => 'Thirty-nine.', 'answer' => 'D'],
            ['part' => 'C', 'number' => 46, 'a' => 'It is open to visitors.', 'b' => 'It is still in use as a prison.', 'c' => 'It is closed to the public.', 'd' => 'It contains few prisoners.', 'answer' => 'A'],
            ['part' => 'C', 'number' => 47, 'a' => 'Artificial plants.', 'b' => 'Plants in plastic containers.', 'c' => 'Plants that resemble plastic.', 'd' => 'Plants that produce a usable substance.', 'answer' => 'D'],
            ['part' => 'C', 'number' => 48, 'a' => 'It lasts longer.', 'b' => 'It is more artificial.', 'c' => 'It is easy to make in a laboratory.', 'd' => 'It is good for the environment.', 'answer' => 'D'],
            ['part' => 'C', 'number' => 49, 'a' => 'It biodegrades slowly.', 'b' => 'It kills plants.', 'c' => 'People never throw it away.', 'd' => 'It is not very strong.', 'answer' => 'A'],
            ['part' => 'C', 'number' => 50, 'a' => 'Engineering.', 'b' => 'Art.', 'c' => 'Botany.', 'd' => 'Geology.', 'answer' => 'C'],
        ];

        foreach ($questions as $row) {
            $question = ToeflMockupQuestion::firstOrNew([
                'section' => 'listening',
                'part' => $row['part'],
                'question_number' => $row['number'],
            ]);

            $question->question_text = '';
            $question->option_a = $row['a'];
            $question->option_b = $row['b'];
            $question->option_c = $row['c'];
            $question->option_d = $row['d'];
            $question->correct_answer = $row['answer'];
            $question->audio_file = $question->audio_file ?? null;
            $question->save();
        }
    }
}
