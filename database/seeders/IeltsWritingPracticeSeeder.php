<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsWritingMeeting;

class IeltsWritingPracticeSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // TASK 1 - Academic Report (Describe visual information)
        // =========================================================
        $task1Practices = [
            [
                'task_type'      => 1,
                'meeting_number' => 1,
                'category'       => 'practice',
                'title'          => 'Bar Chart',
                'prompt'         => 'The bar chart below shows the number of students enrolled in different university subjects in a particular country in 2010 and 2020. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.',
                'view_type'      => 'bar_chart',
            ],
            [
                'task_type'      => 1,
                'meeting_number' => 2,
                'category'       => 'practice',
                'title'          => 'Line Graph',
                'prompt'         => 'The line graph below shows the percentage of households in three different countries with internet access between 2000 and 2020. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.',
                'view_type'      => 'line_graph',
            ],
            [
                'task_type'      => 1,
                'meeting_number' => 3,
                'category'       => 'practice',
                'title'          => 'Pie Charts',
                'prompt'         => 'The two pie charts below compare water usage for different purposes in two regions of the world in 2010. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.',
                'view_type'      => 'pie_chart',
            ],
            [
                'task_type'      => 1,
                'meeting_number' => 4,
                'category'       => 'practice',
                'title'          => 'Table',
                'prompt'         => 'The table below shows international tourist arrivals (in millions) in five countries in 2000, 2010, and 2020. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.',
                'view_type'      => 'table',
            ],
            [
                'task_type'      => 1,
                'meeting_number' => 5,
                'category'       => 'practice',
                'title'          => 'Process Diagram',
                'prompt'         => 'The diagram below illustrates the process of recycling paper. Summarise the information by selecting and reporting the main features.',
                'view_type'      => 'process',
            ],
            [
                'task_type'      => 1,
                'meeting_number' => 6,
                'category'       => 'practice',
                'title'          => 'Map',
                'prompt'         => 'The maps below show the town centre of Bradfield in 1990 and today. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.',
                'view_type'      => 'map',
            ],
            [
                'task_type'      => 1,
                'meeting_number' => 7,
                'category'       => 'practice',
                'title'          => 'Pie Chart & Bar Chart',
                'prompt'         => 'The charts below show the main methods of commuting to work in a city in 2005 and 2020. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.',
                'view_type'      => 'mixed',
            ],
        // the remaining slots (8,9,10) have been removed to keep only seven Task 1 types

        ];

        // =========================================================
        // TASK 2 - Essay Writing (Discursive/Argumentative)
        // =========================================================
        $task2Practices = [
            [
                'task_type'      => 2,
                'meeting_number' => 1,
                'category'       => 'practice',
                'title'          => 'Opinion Essay – Technology and Social Skills',
                'prompt'         => 'Some people believe that modern technology has made people more isolated and less socially skilled. Others believe that it has improved communication and brought people closer together. Discuss both views and give your own opinion.',
                'view_type'      => 'opinion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 2,
                'category'       => 'practice',
                'title'          => 'Discussion Essay – Free Higher Education',
                'prompt'         => 'In some countries, higher education is funded by the government and is free for students. In other countries, students are required to pay tuition fees themselves. Discuss both views and give your own opinion.',
                'view_type'      => 'discussion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 3,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Urban Traffic Congestion',
                'prompt'         => 'Traffic congestion is becoming a major problem in many cities around the world. What are the main causes of this problem and what measures could be taken to address it?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 4,
                'category'       => 'practice',
                'title'          => 'Advantages & Disadvantages – Working from Home',
                'prompt'         => 'More and more people are choosing to work from home rather than commuting to an office. What are the advantages and disadvantages of working from home?',
                'view_type'      => 'advantages_disadvantages',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 5,
                'category'       => 'practice',
                'title'          => 'Agree or Disagree – Children and Smartphones',
                'prompt'         => 'Some people argue that children under the age of 14 should not be allowed to own smartphones. To what extent do you agree or disagree with this statement?',
                'view_type'      => 'agree_disagree',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 6,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Endangered Species',
                'prompt'         => 'Many species of plants and animals are becoming extinct due to human behaviour. Some people argue that governments should spend money protecting these species. Others believe the money could be better spent elsewhere. Discuss both views and give your opinion.',
                'view_type'      => 'discussion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 7,
                'category'       => 'practice',
                'title'          => 'Opinion Essay – Space Exploration',
                'prompt'         => 'Governments spend billions of dollars on space exploration, while many people around the world live in poverty. Some argue that this money should be spent on solving problems on Earth instead. To what extent do you agree or disagree?',
                'view_type'      => 'agree_disagree',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 8,
                'category'       => 'practice',
                'title'          => 'Discussion – Celebrity Influence on Youth',
                'prompt'         => 'Some people think that celebrities have a positive influence on the younger generation, while others believe they have a negative effect. Discuss both views and give your opinion.',
                'view_type'      => 'discussion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 9,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Obesity',
                'prompt'         => 'The number of people who are overweight has been increasing in many countries. What are the causes of this problem and what steps can governments and individuals take to address it?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 10,
                'category'       => 'practice',
                'title'          => 'Advantages & Disadvantages – Tourism',
                'prompt'         => 'International tourism has become an important part of many countries\' economies. However, some argue that it also has significant negative effects on the local environment and culture. Discuss the advantages and disadvantages of international tourism.',
                'view_type'      => 'advantages_disadvantages',
            ],
        ];

        foreach (array_merge($task1Practices, $task2Practices) as $practice) {
            IeltsWritingMeeting::firstOrCreate(
                [
                    'task_type'      => $practice['task_type'],
                    'meeting_number' => $practice['meeting_number'],
                    'category'       => 'practice',
                ],
                $practice
            );
        }

        $this->command->info('✅ IELTS Writing Practice seeded: ' . count($task1Practices) . ' Task 1 + ' . count($task2Practices) . ' Task 2');
    }
}
