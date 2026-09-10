<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\IeltsWritingMeeting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $informalPrompts = [
            [
                'title' => 'Practice 1: Inviting a Friend to Stay at Your New Home',
                'prompt' => "You recently moved into a new apartment in a different city.\n\nWrite a letter to your friend. In your letter:\n- describe your new home and surrounding neighborhood\n- explain why you think your friend would enjoy visiting\n- suggest suitable dates and activities for their stay",
            ],
            [
                'title' => 'Practice 2: Apologizing for Missing a Friend\'s Birthday Party',
                'prompt' => "You were invited to a friend's birthday party last week, but you were unable to attend due to an unexpected situation.\n\nWrite a letter to your friend. In your letter:\n- apologize for not attending the celebration\n- explain the reason why you could not make it\n- propose meeting up soon to celebrate together",
            ],
            [
                'title' => 'Practice 3: Asking a Relative for Advice About Moving Overseas',
                'prompt' => "You are planning to move to another country for higher studies or work, and your cousin has lived abroad for several years.\n\nWrite a letter to your cousin. In your letter:\n- inform your cousin about your plans to move\n- ask for advice regarding accommodation and adjusting to a new culture\n- invite them to talk on a video call at a convenient time",
            ],
            [
                'title' => 'Practice 4: Thanking a Friend for Hosting You During Vacation',
                'prompt' => "You recently returned home after staying at your friend's house for a week during your holidays.\n\nWrite a letter to your friend. In your letter:\n- thank your friend and their family for their hospitality\n- mention what you enjoyed most during your stay\n- invite your friend to visit your hometown in the near future",
            ],
            [
                'title' => 'Practice 5: Recommending a Book or Movie to a Friend',
                'prompt' => "A friend recently asked you to recommend a good book to read or movie to watch during their weekend break.\n\nWrite a letter to your friend. In your letter:\n- recommend a specific book or movie you recently enjoyed\n- explain what the story is about and why you liked it\n- suggest where or how your friend can access it",
            ],
            [
                'title' => 'Practice 6: Asking a Friend to Look After Your Pet While Away',
                'prompt' => "You need to go on an urgent business trip next week and need someone to take care of your pet cat/dog.\n\nWrite a letter to your friend. In your letter:\n- explain the details of your upcoming trip\n- ask your friend if they can look after your pet while you are away\n- give instructions regarding feeding schedules and care requirements",
            ],
            [
                'title' => 'Practice 7: Inviting a Former Colleague to a Reunion',
                'prompt' => "You are organizing a reunion dinner with former workplace colleagues.\n\nWrite a letter to your former colleague. In your letter:\n- explain why the reunion is being organized\n- provide details about the date, time, and venue\n- ask if your friend has any dietary preferences or suggestions",
            ],
            [
                'title' => 'Practice 8: Congratulating a Friend on a Job Promotion',
                'prompt' => "You heard news that your close friend recently got promoted at their company.\n\nWrite a letter to your friend. In your letter:\n- congratulate your friend on their achievement\n- express how happy and proud you are of their hard work\n- suggest going out to dinner to celebrate together",
            ],
            [
                'title' => 'Practice 9: Asking a Friend for Help Planning a Surprise Party',
                'prompt' => "You are organizing a surprise anniversary party for your parents and need assistance from a creative friend.\n\nWrite a letter to your friend. In your letter:\n- describe the details of the upcoming surprise event\n- explain what specific help you need from your friend\n- suggest when you can meet to discuss the arrangements",
            ],
            [
                'title' => 'Practice 10: Explaining a Delay in Returning a Borrowed Item',
                'prompt' => "You borrowed a camera or laptop from your friend a month ago and promised to return it this week, but you need it for a few more days.\n\nWrite a letter to your friend. In your letter:\n- apologize for not returning the item on time\n- explain why you still need to use it a bit longer\n- state when and how you plan to return it to them",
            ],
            [
                'title' => 'Practice 11: Inviting a Friend on a Camping Weekend',
                'prompt' => "You are planning a weekend camping trip to a nearby national park next month.\n\nWrite a letter to your friend. In your letter:\n- describe the location and the planned camping activities\n- invite your friend to join you on the trip\n- explain what gear or items they should bring along",
            ],
            [
                'title' => 'Practice 12: Describing a Recent Fitness Routine to a Friend',
                'prompt' => "Your friend mentioned they want to get fitter and asked about your workout routine.\n\nWrite a letter to your friend. In your letter:\n- describe the exercise and diet routine you have been following\n- explain how this routine has benefited your health and energy levels\n- offer to exercise together or share useful fitness resources",
            ],
            [
                'title' => 'Practice 13: Asking a Cousin to Help Find Accommodation',
                'prompt' => "You are starting a new job in your cousin's city next month and need to find a place to rent.\n\nWrite a letter to your cousin. In your letter:\n- inform your cousin about your new job and moving timeline\n- specify your preferences regarding rent, location, and apartment size\n- ask if they know any suitable rentals or room vacancies",
            ],
            [
                'title' => 'Practice 14: Informing a Friend About Accidental Property Damage',
                'prompt' => "While staying at your friend's beach house, you accidentally damaged a piece of furniture or kitchen appliance.\n\nWrite a letter to your friend. In your letter:\n- explain what happened and how the damage occurred\n- express your sincere regret for the incident\n- offer to pay for repairs or buy a replacement",
            ],
            [
                'title' => 'Practice 15: Recommending a Language Course to a Friend',
                'prompt' => "Your friend wants to learn Spanish/French and asked if you know a good language school or online course.\n\nWrite a letter to your friend. In your letter:\n- recommend a specific course or platform you have experience with\n- explain why the teaching methods and instructors are effective\n- share details on registration fees and class schedules",
            ],
            [
                'title' => 'Practice 16: Inviting a Friend to Attend a Music Festival',
                'prompt' => "You bought two tickets for an outdoor music concert next month and want your friend to go with you.\n\nWrite a letter to your friend. In your letter:\n- give details about the artists performing and concert venue\n- explain why you thought of inviting them\n- suggest arrangements for travel and accommodation",
            ],
            [
                'title' => 'Practice 17: Apologizing for Being Late to a Meeting with a Friend',
                'prompt' => "You kept your friend waiting for over an hour at a cafe last Saturday because of traffic and car trouble.\n\nWrite a letter to your friend. In your letter:\n- apologize again for making them wait so long\n- explain what went wrong on your way to the meeting\n- offer to treat them to lunch next weekend to make up for it",
            ],
            [
                'title' => 'Practice 18: Asking a Friend to Recommend a Reliable Mechanic',
                'prompt' => "Your car recently broke down, and you need a reliable auto repair shop in town.\n\nWrite a letter to your friend. In your letter:\n- describe the issue your car is experiencing\n- ask your friend for contact details of a trustworthy mechanic\n- inquire about their past experience with that service center",
            ],
            [
                'title' => 'Practice 19: Sharing News About Starting a New Hobby',
                'prompt' => "You recently started taking photography or pottery classes in your free time.\n\nWrite a letter to your friend. In your letter:\n- explain why you chose to take up this new hobby\n- describe what you have learned and created so far\n- invite your friend to join a beginner session with you",
            ],
            [
                'title' => 'Practice 20: Thanking a Friend for Giving You Useful Career Advice',
                'prompt' => "You recently passed a job interview following advice your friend gave you last month.\n\nWrite a letter to your friend. In your letter:\n- share the good news about landing the job position\n- thank your friend for their valuable interview tips and encouragement\n- propose celebrating together over drinks or dinner",
            ],
            [
                'title' => 'Practice 21: Inviting a Friend to Your Graduation Ceremony',
                'prompt' => "You are graduating from university in two months and have extra guest tickets available.\n\nWrite a letter to your friend. In your letter:\n- provide the date, time, and location of the graduation event\n- explain how much it would mean to you if they could attend\n- suggest post-ceremony celebration plans with family and friends",
            ],
            [
                'title' => 'Practice 22: Explaining a Change of Travel Plans to a Friend',
                'prompt' => "You had planned to travel to visit your friend next month, but work commitments forced you to reschedule.\n\nWrite a letter to your friend. In your letter:\n- explain why you have to postpone your visit\n- express your disappointment about not meeting as scheduled\n- suggest alternative dates when you will be free to travel",
            ],
            [
                'title' => 'Practice 23: Asking a Childhood Friend to Send Old Photos',
                'prompt' => "You are creating a photo album for a high school reunion project.\n\nWrite a letter to your friend. In your letter:\n- explain the purpose of the photo collection project\n- ask if your friend has old photographs from your school days\n- suggest how they can scan or share digital copies with you",
            ],
            [
                'title' => 'Practice 24: Recommending a Restaurant for a Family Celebration',
                'prompt' => "A friend is planning a dinner for their parents' anniversary and asked for dining recommendations.\n\nWrite a letter to your friend. In your letter:\n- suggest a restaurant you recently visited and enjoyed\n- describe the food quality, atmosphere, and pricing\n- advise them on reservation procedures and signature dishes",
            ],
            [
                'title' => 'Practice 25: Inviting a Neighbor to a Neighborhood BBQ Party',
                'prompt' => "You are hosting a weekend backyard barbecue for residents in your street.\n\nWrite a letter to your neighbor. In your letter:\n- invite your neighbor and their family to the gathering\n- give details about the date, start time, and food being served\n- ask if they would like to bring a dish or side salad",
            ],
            [
                'title' => 'Practice 26: Asking a Friend to Borrow Their Study Materials',
                'prompt' => "You are preparing for an upcoming professional exam, and your friend took the same exam last year.\n\nWrite a letter to your friend. In your letter:\n- mention the exam date and your study progress\n- ask if you can borrow their prep books or summary notes\n- promise to return the materials in good condition by a set date",
            ],
            [
                'title' => 'Practice 27: Apologizing for Missing a Housewarming Party',
                'prompt' => "Your friend hosted a housewarming party last weekend, but you were ill with a fever.\n\nWrite a letter to your friend. In your letter:\n- apologize for your absence at their party\n- explain your illness and why you could not attend\n- ask if you can visit their new home next week with a gift",
            ],
            [
                'title' => 'Practice 28: Writing to a Pen Pal About Culture & Festivals',
                'prompt' => "Your overseas pen pal asked you about traditional celebrations in your home country.\n\nWrite a letter to your pen pal. In your letter:\n- describe a major festival or cultural tradition in your country\n- explain how people prepare for and celebrate it\n- invite your pen pal to visit during festival season",
            ],
            [
                'title' => 'Practice 29: Asking a Friend to Help You Move House',
                'prompt' => "You are moving to a new apartment next Saturday and need help carrying heavy boxes.\n\nWrite a letter to your friend. In your letter:\n- explain the date and time of your move\n- ask if your friend is free to assist with loading a van\n- promise to supply pizza, drinks, and fuel money for their help",
            ],
            [
                'title' => 'Practice 30: Recommending a Travel Destination for a Family Trip',
                'prompt' => "A friend is looking for a kid-friendly holiday destination for their upcoming family vacation.\n\nWrite a letter to your friend. In your letter:\n- recommend a destination you have visited with great family attractions\n- describe the best activities, resorts, and places to visit\n- give practical tips on travel season and budgeting",
            ],
            [
                'title' => 'Practice 31: Inviting a Colleague to Join a Weekend Hiking Club',
                'prompt' => "You joined a local trekking club that organizes weekly mountain hikes.\n\nWrite a letter to your colleague. In your letter:\n- describe the club activities and difficulty levels of the trails\n- explain why hiking would be a great weekend activity for your colleague\n- invite them to attend the next scenic trail walk this Sunday",
            ],
            [
                'title' => 'Practice 32: Explaining Why You Cannot Lend Your Car to a Friend',
                'prompt' => "A friend asked to borrow your vehicle for a road trip next weekend, but you need it for work.\n\nWrite a letter to your friend. In your letter:\n- politely explain why you are unable to lend your car\n- describe your work schedule and transportation requirements\n- suggest alternative car rental options or transport services",
            ],
            [
                'title' => 'Practice 33: Asking a Friend for Feedback on a Project Draft',
                'prompt' => "You wrote an article or business proposal draft and want a knowledgeable friend to review it.\n\nWrite a letter to your friend. In your letter:\n- explain what the article/proposal is about\n- ask if they can spend time reading and giving feedback\n- mention your deadline and how they can send comments",
            ],
            [
                'title' => 'Practice 34: Thanking a Friend for Sending a Birthday Present',
                'prompt' => "You received a birthday package in the mail from a friend who lives overseas.\n\nWrite a letter to your friend. In your letter:\n- thank your friend for the gift and birthday wishes\n- explain why the gift was meaningful and how you plan to use it\n- update them on what you did on your birthday",
            ],
            [
                'title' => 'Practice 35: Inviting a Friend to a Cooking Workshop',
                'prompt' => "You registered for a weekend Italian pasta-making workshop and have a spare ticket.\n\nWrite a letter to your friend. In your letter:\n- describe what the cooking workshop covers and who is instructing\n- explain why you think your friend would enjoy it\n- give details on date, venue, and start time",
            ],
            [
                'title' => 'Practice 36: Apologizing for Losing a Borrowed Book',
                'prompt' => "You borrowed a novel from a friend, but accidentally left it on a train.\n\nWrite a letter to your friend. In your letter:\n- explain how the book was misplaced or lost\n- express your sincere apologies for the carelessness\n- offer to buy a brand-new copy or reimburse the cost",
            ],
            [
                'title' => 'Practice 37: Asking a Relative for Advice on Buying a First Car',
                'prompt' => "Your uncle is a car enthusiast, and you are planning to purchase your first used vehicle.\n\nWrite a letter to your uncle. In your letter:\n- explain your budget and driving needs\n- ask for advice on reliable car models and potential pitfalls\n- ask if he would be willing to accompany you to inspect a car",
            ],
            [
                'title' => 'Practice 38: Sharing News About Getting a New Pet',
                'prompt' => "You recently adopted a puppy or kitten from an animal rescue shelter.\n\nWrite a letter to your friend. In your letter:\n- describe your new pet and how you decided to adopt it\n- explain how your daily routine has changed since bringing it home\n- invite your friend over to meet the pet",
            ],
            [
                'title' => 'Practice 39: Recommending a Mobile App to a Friend',
                'prompt' => "Your friend mentioned having difficulty managing daily tasks and budgeting.\n\nWrite a letter to your friend. In your letter:\n- recommend a productivity or financial tracking app you use regularly\n- explain its key features and how it helped organize your life\n- guide them on how to download and set it up",
            ],
            [
                'title' => 'Practice 40: Inviting a Former Roommate to Stay During Vacation',
                'prompt' => "Your former university roommate is visiting your city next month.\n\nWrite a letter to your former roommate. In your letter:\n- express excitement about their upcoming visit\n- invite them to stay in your spare guest room free of charge\n- suggest reminiscing over dinner and exploring local spots",
            ],
            [
                'title' => 'Practice 41: Asking a Friend to Collect Mail While Away',
                'prompt' => "You will be travelling abroad for three weeks and need someone to check your mailbox.\n\nWrite a letter to your friend. In your letter:\n- state the exact dates of your travel\n- ask if your friend can pick up your letters twice a week\n- explain where you will leave the mailbox key and home security code",
            ],
            [
                'title' => 'Practice 42: Apologizing for Cancelling a Shared Holiday Trip',
                'prompt' => "You and your friend planned a beach getaway next month, but a family emergency requires your presence.\n\nWrite a letter to your friend. In your letter:\n- explain the emergency situation clearly\n- express regret for canceling the trip at short notice\n- offer to help cover any non-refundable booking fees incurred",
            ],
            [
                'title' => 'Practice 43: Writing to a Friend About Returning to College',
                'prompt' => "After working for a few years, you decided to enroll in a Master's degree program.\n\nWrite a letter to your friend. In your letter:\n- explain why you chose to go back to university\n- describe the degree course and your expectations\n- ask how your friend has been doing lately",
            ],
            [
                'title' => 'Practice 44: Recommending a Gym or Sports Club to a Friend',
                'prompt' => "Your friend is looking for a local gym with modern equipment and group classes.\n\nWrite a letter to your friend. In your letter:\n- recommend a fitness center you currently attend\n- highlight its facilities, trainers, and clean environment\n- offer to take them as a guest on a free trial pass",
            ],
            [
                'title' => 'Practice 45: Inviting a Friend to a Charity Event',
                'prompt' => "You are volunteering for a local charity marathon or charity dinner next month.\n\nWrite a letter to your friend. In your letter:\n- explain the cause and objectives of the charity event\n- invite your friend to participate or attend as a guest\n- provide details on registration, date, and venue",
            ],
            [
                'title' => 'Practice 46: Asking a Friend to Return a Borrowed Item',
                'prompt' => "A friend borrowed your tent or toolkit six months ago and forgot to return it.\n\nWrite a letter to your friend. In your letter:\n- politely remind them about the borrowed item\n- explain why you need to use it for an upcoming project\n- suggest a convenient time when you can pick it up",
            ],
            [
                'title' => 'Practice 47: Sharing News About Starting a Small Business',
                'prompt' => "You recently launched an online craft or bakery business.\n\nWrite a letter to your friend. In your letter:\n- describe your new business concept and products\n- explain the challenges and excitement of starting out\n- share your website link and invite them to sample your goods",
            ],
            [
                'title' => 'Practice 48: Apologizing to a Neighbor for Garden Damage',
                'prompt' => "While trimming tree branches in your yard, a branch fell and damaged your neighbor's garden fence.\n\nWrite a letter to your neighbor. In your letter:\n- explain how the accident occurred\n- apologize for the damage to their property\n- assure them that you will hire a carpenter to repair it promptly",
            ],
            [
                'title' => 'Practice 49: Recommending a Hotel for a Friend\'s Honeymoon',
                'prompt' => "A friend is getting married soon and asked for romantic resort recommendations.\n\nWrite a letter to your friend. In your letter:\n- recommend a hotel or resort you know well\n- describe its scenic views, luxury amenities, and peaceful environment\n- share advice on booking special packages for couples",
            ],
            [
                'title' => 'Practice 50: Inviting a Friend to Celebrate a Milestone',
                'prompt' => "You just paid off your student loan or bought your first vehicle and want to celebrate with friends.\n\nWrite a letter to your friend. In your letter:\n- share the happy news about your milestone\n- invite your friend to a celebratory dinner at your favorite restaurant\n- provide the date, time, and location details",
            ],
        ];

        foreach ($informalPrompts as $index => $item) {
            $meetingNumber = 2051 + $index;
            IeltsWritingMeeting::updateOrCreate(
                [
                    'meeting_number' => $meetingNumber,
                    'category' => 'practice_item',
                    'task_type' => 1,
                ],
                [
                    'title' => $item['title'],
                    'prompt' => $item['prompt'],
                    'view_type' => 'writing_practice',
                    'is_locked' => false,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        IeltsWritingMeeting::whereBetween('meeting_number', [2051, 2100])
            ->where('category', 'practice_item')
            ->delete();
    }
};
