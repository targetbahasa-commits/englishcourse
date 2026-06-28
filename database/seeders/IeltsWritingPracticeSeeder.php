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
            [
                'task_type'      => 2,
                'meeting_number' => 11,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Cyberbullying',
                'prompt'         => 'Cyberbullying among teenagers is increasingly common due to the widespread use of social media. What problems does this cause and what measures can be taken to reduce it?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 12,
                'category'       => 'practice',
                'title'          => 'Opinion Essay – Remote Work',
                'prompt'         => 'Remote work has become more popular in recent years. Do you think this trend is positive for society?',
                'view_type'      => 'opinion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 13,
                'category'       => 'practice',
                'title'          => 'Discussion – Artificial Intelligence',
                'prompt'         => 'Some people think that AI will create more jobs, while others believe it will lead to widespread unemployment. Discuss both views and give your opinion.',
                'view_type'      => 'discussion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 14,
                'category'       => 'practice',
                'title'          => 'Agree or Disagree – Public Transport',
                'prompt'         => 'Governments should prioritize investment in public transport rather than building more roads. To what extent do you agree or disagree?',
                'view_type'      => 'agree_disagree',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 15,
                'category'       => 'practice',
                'title'          => 'Advantages & Disadvantages – Social Media',
                'prompt'         => 'Social media has revolutionized the way we communicate. Discuss the advantages and disadvantages of using social media in modern society.',
                'view_type'      => 'advantages_disadvantages',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 16,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Noise Pollution',
                'prompt'         => 'Noise pollution is affecting the quality of life in urban areas. What are the main causes of this issue and how can it be reduced?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 17,
                'category'       => 'practice',
                'title'          => 'Opinion – Climate Change Action',
                'prompt'         => 'Climate change is one of the most serious issues facing the world today. What steps should governments and individuals take to address this problem?',
                'view_type'      => 'opinion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 18,
                'category'       => 'practice',
                'title'          => 'Discussion – Universal Basic Income',
                'prompt'         => 'Some people argue for universal basic income, while others believe it would be economically unfeasible. Discuss both views and give your opinion.',
                'view_type'      => 'discussion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 19,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Food Waste',
                'prompt'         => 'A large amount of food is wasted every day by households and businesses. What are the main causes of food waste and what solutions can be proposed?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 20,
                'category'       => 'practice',
                'title'          => 'Agree or Disagree – Plastics Ban',
                'prompt'         => 'Single-use plastics should be banned worldwide. To what extent do you agree or disagree with this statement?',
                'view_type'      => 'agree_disagree',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 21,
                'category'       => 'practice',
                'title'          => 'Advantages & Disadvantages – Urbanization',
                'prompt'         => 'Many people are moving to cities for better job opportunities. Discuss the advantages and disadvantages of urbanization.',
                'view_type'      => 'advantages_disadvantages',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 22,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Water Scarcity',
                'prompt'         => 'Many regions of the world are facing water scarcity. What are the reasons for this problem and what steps can be taken to deal with it?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 23,
                'category'       => 'practice',
                'title'          => 'Opinion – Higher Education',
                'prompt'         => 'University education should be free for all students. Do you agree or disagree with this view?',
                'view_type'      => 'opinion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 24,
                'category'       => 'practice',
                'title'          => 'Discussion – Nuclear Energy',
                'prompt'         => 'Some believe nuclear energy is essential for the future, while others think it is too dangerous. Discuss both views and give your opinion.',
                'view_type'      => 'discussion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 25,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Stress at Work',
                'prompt'         => 'Many employees suffer from stress at work. What are the main causes of workplace stress and what solutions can employers implement?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 26,
                'category'       => 'practice',
                'title'          => 'Agree or Disagree – Robots in Workplace',
                'prompt'         => 'Robots will eventually replace most human workers. To what extent do you agree or disagree with this statement?',
                'view_type'      => 'agree_disagree',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 27,
                'category'       => 'practice',
                'title'          => 'Advantages & Disadvantages – Online Learning',
                'prompt'         => 'Online education has become increasingly popular. Discuss the advantages and disadvantages of studying online.',
                'view_type'      => 'advantages_disadvantages',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 28,
                'category'       => 'practice',
                'title'          => 'Problem & Solution – Housing Shortage',
                'prompt'         => 'Many large cities are facing a shortage of affordable housing. What are the main causes of this issue and what solutions can be proposed?',
                'view_type'      => 'problem_solution',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 29,
                'category'       => 'practice',
                'title'          => 'Discussion – Genetic Engineering',
                'prompt'         => 'Genetic engineering offers great potential for improving human health, but some people are concerned about its safety. Discuss both views and give your opinion.',
                'view_type'      => 'discussion',
            ],
            [
                'task_type'      => 2,
                'meeting_number' => 30,
                'category'       => 'practice',
                'title'          => 'Opinion – Sustainable Living',
                'prompt'         => 'Sustainable living practices should be mandatory for all citizens. Do you agree or disagree?',
                'view_type'      => 'opinion',
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
