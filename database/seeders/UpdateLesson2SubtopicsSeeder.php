<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsSpeakingTopic;

class UpdateLesson2SubtopicsSeeder extends Seeder
{
    public function run()
    {
        $subtopics = [
            [
                'slug' => 'artificial-intelligence',
                'title' => 'Artificial Intelligence',
                'questions' => [
                    'Do you often use AI tools, like chatbots or translation apps?',
                    'How do you think AI helps you in your daily life or work?',
                    'Are there any tasks you wouldn\'t want a computer or AI to do?',
                    'Do you think AI will change the way we learn in the future?',
                ]
            ],
            [
                'slug' => 'public-transport-lesson2', // Unique slug to avoid potential conflict/confusion
                'title' => 'Public Transport',
                'questions' => [
                    'How often do you use public transport?',
                    'What is the most popular form of public transport in your city?',
                    'Do you prefer traveling by bus or by train? Why?',
                    'What improvements would you like to see in the public transport system?',
                ]
            ],
            [
                'slug' => 'feeling-happy',
                'title' => 'Feeling Happy',
                'questions' => [
                    'What things make you feel happy?',
                    'Is it important to stay positive all the time?',
                    'What do you do to cheer yourself up when you are sad?',
                    'Do you think people were happier in the past than they are now?',
                ]
            ],
        ];

        $topic = IeltsSpeakingTopic::where('slug', 'lesson-2')->first();

        if ($topic) {
            $topic->subtopics = $subtopics;
            $topic->save();
        }
    }
}
