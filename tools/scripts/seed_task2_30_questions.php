<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::capture());

use App\Models\IeltsWritingMeeting;

$newQuestions = [
    // 1. Advantages & Disadvantages
    ['advantages_disadvantages', 'Adv/Disadv: E-books vs Paper Books', 'Many people now prefer reading e-books rather than printed books. What are the advantages and disadvantages of this trend?'],
    ['advantages_disadvantages', 'Adv/Disadv: Video Games for Children', 'Children today spend a large amount of time playing video games. What are the advantages and disadvantages of this?'],
    ['advantages_disadvantages', 'Adv/Disadv: Four-Day Work Week', 'Some companies are reducing the working week to four days for their employees. What are the advantages and disadvantages of this policy?'],
    ['advantages_disadvantages', 'Adv/Disadv: Genetic Engineering', 'Advancements in genetic engineering allow scientists to alter the DNA of crops and animals. What are the advantages and disadvantages of this?'],
    ['advantages_disadvantages', 'Adv/Disadv: Free Public Transport', 'Some cities provide free public transport for their citizens. What are the advantages and disadvantages of free public transport?'],
    ['advantages_disadvantages', 'Adv/Disadv: Universal Basic Income', 'There is a growing discussion about providing every citizen with a Universal Basic Income. What are the advantages and disadvantages?'],
    ['advantages_disadvantages', 'Adv/Disadv: AI in Healthcare', 'Artificial Intelligence is increasingly being used in medical diagnosis and healthcare. What are the advantages and disadvantages of this development?'],
    ['advantages_disadvantages', 'Adv/Disadv: Remote Learning', 'Since the pandemic, remote learning has become a standard in many educational institutions. What are the advantages and disadvantages?'],
    ['advantages_disadvantages', 'Adv/Disadv: Advertising to Children', 'Many advertisements are aimed directly at children. What are the advantages and disadvantages of this practice?'],
    ['advantages_disadvantages', 'Adv/Disadv: High-Density Housing', 'To solve housing shortages, many cities are building high-density apartment blocks. What are the advantages and disadvantages of living in such housing?'],
    ['advantages_disadvantages', 'Adv/Disadv: Cashless Society', 'Many countries are moving towards becoming cashless societies. What are the advantages and disadvantages of this trend?'],
    ['advantages_disadvantages', 'Adv/Disadv: Space Tourism', 'Commercial space tourism is becoming a reality for wealthy individuals. What are the advantages and disadvantages?'],
    ['advantages_disadvantages', 'Adv/Disadv: Freelancing', 'Working as a freelancer is becoming more popular than traditional employment. What are the advantages and disadvantages of freelance work?'],
    ['advantages_disadvantages', 'Adv/Disadv: English as a Global Language', 'English is widely spoken and used as the primary language in international business and education. What are the advantages and disadvantages of having a single global language?'],
    ['advantages_disadvantages', 'Adv/Disadv: Homework for Students', 'Teachers frequently assign homework to students to complete outside of school hours. What are the advantages and disadvantages of homework?'],

    // 2. Positive or Negative (opinion)
    ['opinion', 'Positive/Negative: Replacing Human Workers with Robots', 'Many factories and businesses are replacing human workers with robots. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Aging Population', 'In many countries, the proportion of older people is steadily increasing. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Decline in Local Languages', 'Many local languages and dialects are dying out as people prefer to speak dominant national or global languages. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Marrying Later in Life', 'People today are choosing to get married at a much older age compared to previous generations. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Heavy Reliance on Smartphones', 'People today are heavily reliant on their smartphones for daily tasks, communication, and entertainment. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Influencers as a Career', 'Becoming a social media influencer is now seen as a highly desirable career choice by many young people. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Decline of Traditional Newspapers', 'Fewer people are reading printed newspapers, preferring to get their news online. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Globalization of Culture', 'Due to the internet and global media, people around the world are increasingly sharing the same culture and lifestyle. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Privatization of Healthcare', 'Some governments are allowing private companies to manage public healthcare systems. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Single-Person Households', 'An increasing number of people are choosing to live alone rather than with family or roommates. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: CCTV in Public Places', 'The use of CCTV cameras in public places is increasing globally to reduce crime. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Shift Towards Renewable Energy', 'Many countries are phasing out fossil fuels in favour of renewable energy sources. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Studying Online', 'University students are increasingly choosing to study their degrees entirely online. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Fast Fashion', 'The rapid production of cheap clothing, known as fast fashion, has become extremely popular globally. Is this a positive or negative development?'],
    ['opinion', 'Positive/Negative: Celebrities in Politics', 'It is becoming more common for famous entertainers and athletes to enter politics. Is this a positive or negative development?'],

    // 3. Problem & Solution
    ['problem_solution', 'Problem/Solution: Traffic Congestion', 'Traffic congestion is becoming a major issue in many large cities. What are the main causes of this problem, and what solutions can you suggest?'],
    ['problem_solution', 'Problem/Solution: Water Scarcity', 'Many regions around the world are facing severe water shortages. What causes this problem, and how can it be solved?'],
    ['problem_solution', 'Problem/Solution: Youth Unemployment', 'High rates of youth unemployment are a serious concern in many countries. What are the causes of this issue, and what measures can be taken to resolve it?'],
    ['problem_solution', 'Problem/Solution: Plastic Pollution', 'Plastic pollution is causing massive damage to the world’s oceans and wildlife. What are the causes of this, and what solutions can be implemented?'],
    ['problem_solution', 'Problem/Solution: Cyberbullying', 'Cyberbullying has become a widespread problem among young people. Why is this happening, and what can be done to tackle it?'],
    ['problem_solution', 'Problem/Solution: Lack of Affordable Housing', 'In many urban areas, affordable housing is becoming increasingly difficult to find. What problems does this cause, and how can the situation be improved?'],
    ['problem_solution', 'Problem/Solution: Decline of Biodiversity', 'Many species of plants and animals are currently at risk of extinction. What are the causes of this decline in biodiversity, and what solutions exist?'],
    ['problem_solution', 'Problem/Solution: High Stress Levels', 'People in modern society frequently suffer from high levels of stress. What are the main causes of this stress, and how can individuals and society manage it?'],
    ['problem_solution', 'Problem/Solution: Food Waste', 'A significant amount of food is wasted every day by supermarkets and consumers. Why does this happen, and what can be done to reduce food waste?'],
    ['problem_solution', 'Problem/Solution: Air Pollution', 'Air pollution in major cities is causing serious health problems. What are the primary causes, and what steps should be taken to improve air quality?'],
    ['problem_solution', 'Problem/Solution: Brain Drain', 'Many highly skilled professionals migrate from developing countries to developed nations. What problems does this cause, and how can developing countries retain their talent?'],
    ['problem_solution', 'Problem/Solution: Screen Time Addiction', 'Addiction to screens and digital devices is a growing problem for both adults and children. What are the causes, and what solutions can you propose?'],
    ['problem_solution', 'Problem/Solution: Inequality in Education', 'In many countries, children from poor families do not have access to the same quality of education as wealthy children. What problems does this create, and how can it be addressed?'],
    ['problem_solution', 'Problem/Solution: Overpopulation', 'The global population continues to grow rapidly, placing immense strain on resources. What are the major consequences of overpopulation, and what solutions can be offered?'],
    ['problem_solution', 'Problem/Solution: Decline in Physical Activity', 'People are living increasingly sedentary lifestyles with very little physical activity. Why is this occurring, and what can be done to encourage people to exercise more?'],

    // 4. Two-Part Question (discussion)
    ['discussion', 'Discussion: University vs Vocational Training', 'Some people believe that university education should be the goal for all students, while others argue that vocational training is more practical. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Arts vs Healthcare Funding', 'Some people think the government should spend money on the arts, while others believe that this money should be spent on public health and education. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Strict vs Lenient Parenting', 'Some people believe that strict parenting produces better-behaved children, while others think that a more lenient approach encourages independence. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Zoos: Cruel vs Educational', 'Some people believe that zoos are cruel and should be closed down, while others argue that they are necessary for education and conservation. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Free Healthcare vs Private Healthcare', 'Some people think that all healthcare should be completely free and funded by the government, while others believe that private healthcare systems are more efficient. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Preserving Old Buildings', 'Some people believe that historic buildings should be preserved regardless of the cost, while others think they should be destroyed to make way for new developments. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Team vs Individual Sports', 'Some people think that team sports are better for developing character, while others believe that individual sports are more beneficial. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Traditional vs Modern Teaching', 'Some people prefer traditional teaching methods with a teacher at the front of the classroom, while others advocate for modern, interactive, and student-led approaches. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: City vs Countryside Living', 'Some people believe that growing up in a city provides children with more opportunities, while others argue that the countryside is a better environment for children. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Public vs Private Transport', 'Some people believe that governments should invest heavily in public transport, while others think they should focus on improving road infrastructure for private cars. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Fixed vs Flexible Sentencing', 'Some people think that there should be a fixed punishment for each type of crime, while others argue that the circumstances of the individual crime should always be considered. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Books vs Television', 'Some people believe that reading books is the best way to gain knowledge, while others argue that television and documentaries are more effective. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Innate Talent vs Hard Work', 'Some people believe that success in sports or music requires innate talent, while others argue that anyone can succeed with enough hard work and practice. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: History vs Science Subjects', 'Some people think that history is one of the most important subjects in school, while others believe that science and technology subjects are far more crucial for the future. Discuss both views and give your opinion.'],
    ['discussion', 'Discussion: Printed Media vs Online News', 'Some people believe that printed newspapers will completely disappear in the future, while others think they will always remain relevant. Discuss both views and give your opinion.'],

    // 5. Agree or Disagree
    ['agree_disagree', 'Agree/Disagree: Technology and Isolation', 'Technology has made us more isolated from one another. To what extent do you agree or disagree with this statement?'],
    ['agree_disagree', 'Agree/Disagree: Government Funding for University', 'The government should pay for all citizens to attend university, regardless of their financial background. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Animal Testing', 'Animal testing is a cruel practice and should be banned completely. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Abolishing Homework', 'Homework places unnecessary stress on students and should be completely abolished. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Sports Stars Salaries', 'The high salaries paid to professional sports stars are completely unjustified. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Wealth and Happiness', 'Wealth does not bring happiness. To what extent do you agree or disagree with this statement?'],
    ['agree_disagree', 'Agree/Disagree: Controlling Internet Access', 'Parents should strictly control the amount of time their children spend on the internet. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Manipulative Advertising', 'Advertising is manipulative and encourages people to buy things they do not need. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: School Uniforms', 'School uniforms should be mandatory in all schools. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Retaking Driving Tests', 'People should have to retake their driving test every ten years to ensure road safety. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Compulsory Physical Education', 'Physical education should be a compulsory subject for all school students until they graduate. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Equal Parental Leave', 'Men and women should be given exactly the same amount of paid parental leave when they have a child. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: The Death Penalty', 'The death penalty should be completely abolished everywhere in the world. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Traditional Gender Roles', 'Traditional gender roles, where men work and women stay at home, are outdated and have no place in modern society. To what extent do you agree or disagree?'],
    ['agree_disagree', 'Agree/Disagree: Multinational Companies', 'Multinational companies cause more harm than good to local economies. To what extent do you agree or disagree?']
];

$startMeetingNumber = 2000;
$count = 0;

foreach ($newQuestions as $q) {
    $view_type = $q[0];
    $title = $q[1];
    $prompt = $q[2];

    IeltsWritingMeeting::create([
        'task_type' => 2,
        'meeting_number' => $startMeetingNumber++,
        'title' => $title,
        'prompt' => $prompt,
        'view_type' => $view_type,
        'category' => 'practice'
    ]);
    $count++;
}

echo "Successfully seeded $count new practice items!\n";
